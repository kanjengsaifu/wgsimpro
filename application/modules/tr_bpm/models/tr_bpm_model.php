<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tr_bpm_model extends CI_Model {
	
	public function get($id = FALSE, $filter = FALSE) {
		if($id==FALSE) {
			$this->db->select('b.*')
					 ->select('date_format(b.tanggal,"%d/%m/%Y") as xtanggal', FALSE)
					 ->from('tr_bpm b');
			$q = $this->db->get();
			return $q->result_array();
		} else {
			$this->db->select('b.*')
					 ->select('date_format(b.tanggal,"%d/%m/%Y") as xtanggal', FALSE)
					 ->from('tr_bpm b')
					 ->where(array('b.id'=>$id));
			$q = $this->db->get();
			return $q->row_array();
		}
	}

	public function get_optional() {
		// sumberdaya
		$this->db->select('kode, nama')
				 ->from('mst_sumberdaya');
		$q = $this->db->get();
		$data['sumberdayas'] = $q->result_array();
		return $data;
	}	
	
	public function _insert($data) {
		return $this->db->insert('tr_bpm',$data);
	}
	
	public function _update($data, $id) {
		$this->db->where(array('id'=>$id));
		return $this->db->update('tr_bpm',$data);
	}
	
	public function _delete($id) {
		$this->db->where(array('id'=>$id));
		return $this->db->delete('tr_bpm');
	}
		
}
	