<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tr_bapb_model extends CI_Model {
	
	public function get($id = FALSE, $filter = FALSE) {
		if($id==FALSE) {
			$this->db->select('b.*')
					 ->select('date_format(b.tanggal,"%d/%m/%Y") as xtanggal', FALSE)
					 ->from('tr_bapb b');
			$q = $this->db->get();
			return $q->result_array();
		} else {
			$this->db->select('b.*')
					 ->select('date_format(b.tanggal,"%d/%m/%Y") as xtanggal', FALSE)
					 ->from('tr_bapb b')
					 ->where(array('b.id'=>$id));
			$q = $this->db->get();
			return $q->row_array();
		}
	}
	

	public function get_optional() {
		//kontrak po
		$this->db->select('a.no_kontrak, a.kdnasabah, b.nama')
				 ->join('mst_nasabah_konstruksi b','b.kode = a.kdnasabah')					
				 ->where('flag',2)
				 ->from('tr_po a');
		$qz = $this->db->get();
		$data['kontrak'] = $qz->result_array();
		//nasabah
		$this->db->select('kode, nama')
				 ->from('mst_nasabah_konstruksi');
		$qz = $this->db->get();
		$data['nasabahkon'] = $qz->result_array();
		// sumberdaya
		$this->db->select('kode, nama')
				 ->from('mst_sumberdaya');
		$q = $this->db->get();
		$data['sumberdayas'] = $q->result_array();
		return $data;
	}	

	public function get_po($po) {
		$this->db->select('bapb.*, sd.nama, date_format(bapb.tanggal, "%d/%m/%Y") AS xtanggal', FALSE)
			->from('tr_bapb bapb')
			->join('mst_sumberdaya sd', 'sd.kode = bapb.kode_sumberdaya')
			->where(array('bapb.no_po'=>$po, 'bapb.kode_entity'=>$this->session->userdata('kode_entity')));
		$q = $this->db->get();
		return $q->result_array();
	}
	
	public function _insert($data) {
		$this->db->insert('tr_bapb',$data);
		return $this->db->insert_id();
	}
	
	public function _update($data, $id) {
		$this->db->where(array('id'=>$id));
		return $this->db->update('tr_bapb',$data);
	}
	
	public function _delete($id) {
		$this->db->where(array('id'=>$id));
		return $this->db->delete('tr_bapb');
	}
		
}
	