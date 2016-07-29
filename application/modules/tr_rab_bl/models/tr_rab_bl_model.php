<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class tr_rab_bl_model extends CI_Model {
	
	public function get($id = FALSE, $filter = FALSE) {
		if($id==FALSE) {
			$this->db->select('bl.*')
					 ->from('tr_rab_bl bl');
			$q = $this->db->get();
			return $q->result_array();
		} else {
			$this->db->select('bl.*')
					 ->from('tr_rab_bl bl')
					 ->where(array('bl.id'=>$id));
			$q = $this->db->get();
			return $q->row_array();
		}
	}
	
	
	public function get_sumberdaya() {
		$this->db->select('*')
				 ->from('mst_sumberdaya');
		$q = $this->db->get();
		return $q->result_array();
	}	
	
	public function get_tahap() {
		$this->db->select('*')
				 ->from('mst_tahap');
		$q = $this->db->get();
		return $q->result_array();
	}	
	
	public function _insert($data) {
		return $this->db->insert('tr_rab_bl',$data);
	}
	
	public function _update($data, $id) {
		$this->db->where(array('id'=>$id));
		return $this->db->update('tr_rab_bl',$data);
	}
	
	public function _delete($id) {
		$this->db->where(array('id'=>$id));
		return $this->db->delete('tr_rab_bl');
	}
		
}
	