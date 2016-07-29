<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tr_opname_progress_model extends CI_Model {
	
	public function get($id = FALSE, $filter = FALSE) {
		if($id==FALSE) {
			$this->db->select('op.*')
					 ->select("date_format(op.tanggal,'%d/%m/%Y') as xtanggal",FALSE)
					 ->from('tr_opname_progress op');
			$q = $this->db->get();
			return $q->result_array();
		} else {
			$this->db->select('op.*')
					 ->select("date_format(op.tanggal,'%d/%m/%Y') as xtanggal",FALSE)
					 ->from('tr_opname_progress op')
					 ->where(array('op.id'=>$id));
			$q = $this->db->get();
			return $q->row_array();
		}
	}

	public function get_optional_tahap() {
		$this->db->select('t.kode, t.nama')
				 ->from('mst_tahap t')
				 ->where(array('t.kode_entity' =>  $this->session->userdata('kode_entity')));
		$q = $this->db->get();
		return $q->result_array();
	}

	public function get_optional_spk() {
		$this->db->select('*')
				 ->from('mst_sumberdaya');
		$q = $this->db->get();
		return $q->result_array();
	}	
	
	public function _insert($data) {
		return $this->db->insert('tr_opname_progress',$data);
	}
	
	public function _update($data, $id) {
		$this->db->where(array('id'=>$id));
		return $this->db->update('tr_opname_progress',$data);
	}
	
	public function _delete($id) {
		$this->db->where(array('id'=>$id));
		return $this->db->delete('tr_opname_progress');
	}
		
}
	