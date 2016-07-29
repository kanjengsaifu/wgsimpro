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
	

	public function get_optional($id) {
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

		// sumberdaya list table
		$this->db->select('a.*, b.nama')
				 ->from('tr_bapb_detail a')
				 ->join('mst_sumberdaya b','b.kode=a.kode_sumberdaya')
				 ->where(array('a.bapb_id'=>$id));
		$qs = $this->db->get();
		$data['list_sbdy'] = $qs->result_array();
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
	
	public function a_update($data, $id) {
		$this->db->where(array('id'=>$id));
		return $this->db->update('tr_bapb',$data);
	}

	public function _update($data, $id) {
		// bapb (master)
		$bapb = array(
			'kode_entity'=>$this->session->userdata('kode_entity'),
			'no_bapb'=>$data['no_bapb'],
			'tanggal'=>$this->dateutils->dateStr_to_mysql($data['tgl_bapb']),
			'kdnasabah'=>$data['kd_nasabah'],
			'no_surat_jalan'=>$data['no_surat_jalan'],
			'angkut_id'=>$data['angkut_id'],
			'no_kontrak'=>$data['no_kontrak'],
			'konfirmasi'=>$data['konfirmasi'],
			'uraian'=>$data['uraian'],
		);
		$this->db->where(array('id'=>$id));
		$this->db->update('tr_bapb',$data);
		
		//  sumberdaya detail
		$this->db->where(array('bapb_id'=>$id));
		$this->db->delete('tr_bapb_detail');
		//var_dump($data);
		$sumberdayas = $data['kode_sumberdaya'];
		$hargas 	= $data['harga_satuan'];
		$volumes 	= $data['volume'];
		foreach ($sumberdayas as $k => $v) {
			$detail = array(
				'bapb_id'				=>$id,
				'kode_sumberdaya'		=>$v,
				'harga_satuan'			=>$hargas[$k],
				'volume'				=>$volumes[$k]
			);
			$detail['volume'] 			= str_replace(',', '', $detail['volume']);
			$detail['harga_satuan'] 	= str_replace(',', '', $detail['harga_satuan']);
			$this->db->insert('tr_bapb_detail',$detail);
		}
	}
	
	public function _delete($id) {
		$this->db->where(array('id'=>$id));
		return $this->db->delete('tr_bapb');
	}
	
	public function _delete_sd($id) {
		return $this->db->query("DELETE FROM tr_bapb_detail WHERE id=".$id);
	}	
}
	