<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mst_optional_unit_price_model extends CI_Model {
		
	public function __construct() {
		// $this->load->database();
	}
	
	public function get($id = FALSE, $filter = FALSE) { 
		if($id==FALSE) {
			$q = $this->db->get_where('mst_optional_unit_price', array('kode_entity'=>$this->session->userdata('kode_entity')));
			return $q->result_array();
		} else {
			$q = $this->db->get_where('mst_optional_unit_price', array('id'=>$id));
			return $q->row_array();
		}
	}
	
	public function _insert($data) {
		return $this->db->insert('mst_optional_unit_price',$data);
	}
	
	public function _update($data,$id) {
		$this->db->where(array('id'=>$id));
		return $this->db->update('mst_optional_unit_price',$data);
	}
	
	public function _delete($id) {
		$this->db->where(array('id'=>$id));
		return $this->db->delete('mst_optional_unit_price');
	}
		
}
	