<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mst_diskon_model extends CI_Model {
		
	public function __construct() {
		// $this->load->database();
	}

	public function get($id = FALSE) {
		if($id===FALSE) {
			$q = $this->db->get('mst_diskon');
			return $q->result_array();
		} else {
			$q = $this->db->get_where('mst_diskon', array('id'=>$id));
			return $q->row_array();
		}
	}

	public function _insert($data) {
		return $this->db->insert('mst_diskon', $data);
	}

	public function _update($data, $id) {
		$this->db->where(array('id'=>$id));
		return $this->db->update('mst_diskon', $data);
	}

	public function _delete($id) {
		$this->db->where(array('id'=>$id));
		return $this->db->delete('mst_diskon');
	}
		
}
	