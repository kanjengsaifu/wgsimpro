<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mst_stock_model extends CI_Model {
		
	public function __construct() {
		// $this->load->database();
	}
	
	public function get($id = FALSE, $filter = FALSE) { 
		if($id==FALSE) {
			$q = $this->db->get_where('mst_stock', array('kode_entity'=>$this->session->userdata('kode_entity')));
			return $q->result_array();
		} else {
			$this->db->select('*, DATE_FORMAT(recog_date,"dd/mm/yyyy") as xrecog_date',FALSE);
			$q = $this->db->get_where('mst_stock', array('id'=>$id));
			return $q->row_array();
		}
	}

	public function get_optional() {
		$q = $this->db->get_where('mst_optional_stock', array('sflag'=>$this->session->userdata('type_entity')));
		$data = array();
		$iLoop = 0;
		foreach ($q->result_array() as $k => $v) {
			$data[$v['sfield']][$iLoop]['kode'] = $v['kode'];
			$data[$v['sfield']][$iLoop]['konten'] = $v['konten'];
			$iLoop++;
		}
		return $data;
	}

	public function gen_no_unit() {
		$q = $this->db->query('SELECT IFNULL(MAX(id),0)+1 as num FROM mst_stock FOR UPDATE');
		$res = $q->row_array();
		return sprintf('%02d',$res['num']);
	}
	
	public function get_and_group() {
		$this->db->select('mst_stock.*, CASE WHEN DATEDIFF(NOW(),mst_stock.limit_hold) < 0 THEN 1 ELSE 0 END AS xishold, tr_payment.status_tr', FALSE)
				->from('mst_stock')
				->join('tr_payment','tr_payment.no_unit=mst_stock.no_unit','LEFT');
		$q = $this->db->get();
		$res = $q->result_array();
		$data = array();
		$iLoop = 0;
		foreach($res as $k => $v) {
			$data[$v['tower']][$v['lantai']][$iLoop]['no_unit'] = $v['no_unit'];
			$data[$v['tower']][$v['lantai']][$iLoop]['ishold_admin'] = $v['ishold_admin'];
			$data[$v['tower']][$v['lantai']][$iLoop]['ishold'] = $v['xishold'];
			$data[$v['tower']][$v['lantai']][$iLoop]['status_tr'] = $v['status_tr'];
			$iLoop++;
		}
		return $data;
	}
	
	public function _insert($data) {
		$q = $this->db->query("
			SELECT 
				IFNULL(COUNT(*),0)+1 AS num 
			FROM 
				mst_stock 
			WHERE 
				tower_cluster = '".$data['tower_cluster']."' 
				AND lantai_blok = '".$data['lantai_blok']."'
				AND kode_entity = '".$this->session->userdata('kode_entity')."'
		");
		$res = $q->row_array();
		$data['no_unit'] = sprintf('%s-%s-%02d',$data['tower_cluster'],$data['lantai_blok'],$res['num']);
		return $this->db->insert('mst_stock',$data);
	}
	
	public function _update($data,$id) {
		$this->db->where(array('id'=>$id));
		return $this->db->update('mst_stock',$data);
	}
	
	public function _delete($id) {
		$this->db->where(array('id'=>$id));
		return $this->db->delete('mst_stock');
	}
	
	public function _update_hold($data,$no_unit) {
		$this->db->where(array('no_unit'=>$no_unit));
		return $this->db->update('mst_stock',$data);
	}
		
}
	