<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mst_sumberdaya_model extends CI_Model {
	
	public function get($id = FALSE, $filter = FALSE) {
		if($id==FALSE) {
			$this->db->select('sd.*')
					 ->from('mst_sumberdaya sd');
			$q = $this->db->get();
			return $q->result_array();
		} else {
			$this->db->select('sd.*')
					 ->from('mst_sumberdaya sd')
					 ->where(array('sd.id'=>$id));
			$q = $this->db->get();
			return $q->row_array();
		}
	}
	
	public function _insert($data) {
		return $this->db->insert('mst_sumberdaya',$data);
	}
	
	public function _update($data, $id) {
		$this->db->where(array('id'=>$id));
		return $this->db->update('mst_sumberdaya',$data);
	}
	
	public function _delete($id) {
		$this->db->where(array('id'=>$id));
		return $this->db->delete('mst_sumberdaya');
	}
		
}
	