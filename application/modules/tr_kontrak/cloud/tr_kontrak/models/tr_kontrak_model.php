<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tr_kontrak_model extends CI_Model {
	
	public function get($id = FALSE, $filter = FALSE) {
		if($id==FALSE) {
			$this->db->select('k.*')
					 ->select("date_format(k.tanggal,'%d/%m/%Y') as xtanggal",FALSE)
					 ->from('tr_kontrak k');
			$q = $this->db->get();
			return $q->result_array();
		} else {
			$this->db->select('k.*')
					 ->select("date_format(k.tanggal,'%d/%m/%Y') as xtanggal",FALSE)
					 ->from('tr_kontrak k')
					 ->where(array('k.id'=>$id));
			$q = $this->db->get();
			return $q->row_array();
		}
	}

	public function get_optional_rekanan() {
		$this->db->select('r.kode_rekanan, r.nama')
				 ->from('mst_rekanan r');
		$q = $this->db->get();
		return $q->result_array();
	}	
	
	public function _insert($data) {
		return $this->db->insert('tr_kontrak',$data);
	}
	
	public function _update($data, $id) {
		$this->db->where(array('id'=>$id));
		return $this->db->update('tr_kontrak',$data);
	}
	
	public function _delete($id) {
		$this->db->where(array('id'=>$id));
		return $this->db->delete('tr_kontrak');
	}
		
}
	