<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mst_nasabah_model extends CI_Model {
		
	public function __construct() {
		// $this->load->database();
	}
	
	public function get($id = FALSE, $filter = FALSE) {
		if($id==FALSE) {
			$q = $this->db->get_where('mst_nasabah', array('jenis'=>'CUSTOMER'));
			return $q->result_array();
		} else {
			$q = $this->db->get_where('mst_nasabah', array('jenis'=>'CUSTOMER','id'=>$id));
			return $q->row_array();
		}
	}
	
	public function gen_kode_nasabah($no_unit) {
		$q = $this->db->query("SELECT IFNULL(MAX(id),0)+1 AS new_kode FROM mst_nasabah FOR UPDATE", FALSE);
		$res = $q->row_array();
		return sprintf('%s-%06d',$no_unit,$res['new_kode']);
	}
	
	public function _insert($data) {
		return $this->db->insert('mst_nasabah',$data);
	}
	
	public function _update($data, $id) {
		$this->db->where(array('id'=>$id));
		return $this->db->update('mst_nasabah',$data);
	}
	
	public function _delete($id) {
		$this->db->where(array('id'=>$id));
		return $this->db->delete('mst_nasabah');
	}
		
}
	