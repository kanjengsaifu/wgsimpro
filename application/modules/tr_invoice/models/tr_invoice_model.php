<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tr_invoice_model extends CI_Model {
	
	public function get_optional() {
		// bpdp
		$this->db->select('no_path, uraian')
				 ->from('tr_bpdp');
		$q = $this->db->get();
		$data['bpdps'] = $q->result_array();
		// po
		$this->db->select('no_po')
				 ->from('tr_po');
		$q = $this->db->get();
		$data['pos'] = $q->result_array();
		// po
		$this->db->select('no_po')
				 ->from('tr_bapb')
				 ->where(array('kode_entity'=>$this->session->userdata('kode_entity')));
		$q = $this->db->get();
		$data['bapbs'] = $q->result_array();
		// rekanan
		$this->db->select('r.kode_rekanan, r.nama')
				 ->from('mst_rekanan r');
		$q = $this->db->get();
		$data['rekanans'] = $q->result_array();
		// sumberdaya
		$this->db->select('s.kode, s.nama, IFNULL(sh.harga_satuan, 0) AS harga_satuan', FALSE)
				 ->from('mst_sumberdaya s')
				 ->join('mst_harga_sumberdaya sh', 'sh.kode_sumberdaya = s.kode AND sh.kode_entity = "'.$this->session->userdata('kode_entity').'"', 'left');
		$q = $this->db->get();
		$data['sumberdayas'] = $q->result_array();
		// unit
		$this->db->select('no_unit')
				 ->from('mst_stock')
				 ->where(array('kode_entity'=>$this->session->userdata('kode_entity')));
		$q = $this->db->get();
		$data['stocks'] = $q->result_array();
		return $data;
	}

	public function get_inv_and_detail($id) {
		// invoice
		$this->db->select('*', FALSE)
			->select('DATE_FORMAT(tanggal, "%d/%m/%Y") AS xtanggal',FALSE)
			->select('IFNULL(DATE_FORMAT(tgl_surat_jalan, "%d/%m/%Y"),"") AS xtgl_surat_jalan', FALSE)
			->select('IFNULL(DATE_FORMAT(tgl_bapb, "%d/%m/%Y"),"") AS xtgl_bapb', FALSE)
			->from('tr_invoice')
			->where(array('id'=>$id));
		$q = $this->db->get();
		$data = $q->row_array();

		// sumberdaya
		//$q = $this->db->get_where('tr_invoice_sumberdayax', array('no_po'=>$data['no_po']));
		// po - sumberdaya
		$this->db->select('tiv.*, msd.nama')
			->from('tr_invoice_sumberdaya tiv')
			->join('mst_sumberdaya msd', 'msd.kode = tiv.kode_sumberdaya')
			->where(array('no_po'=>$data['no_po']));
		$q = $this->db->get();
		$data['sumberdayas'] = $q->result_array();
		
		// units
		$q = $this->db->get_where('tr_invoice_unit', array('no_po'=>$data['no_po'], 'kode_entity'=>$this->session->userdata('kode_entity')));
		$data['units'] = $q->row_array();
		

		return $data;
	}

	public function _insert($data) {
		// invoice (master)
		$dataInv = array(
			'kode_entity'		=>$data['kode_entity'],
			'tanggal'			=>$data['tanggal'],
			'is_um'				=>isset($data['is_um'])?$data['is_um']:'0',
			'no_po'				=>$data['no_po'],
			'asal_po'			=>$data['asal_po'],
			'kode_rekanan'		=>$data['kode_rekanan'],
			'no_surat_jalan'	=>$data['no_surat_jalan'],
			'tgl_surat_jalan'	=>$data['tgl_surat_jalan'],
			'no_bapb'			=>$data['no_bapb'],
			'tgl_bapb'			=>$data['tgl_bapb'],
			'kode_bpdp'			=>$data['kode_bpdp'],
			'is_pkp'			=>isset($data['is_pkp'])?$data['is_pkp']:'0',
			'rp'				=>str_replace(',', '', $data['rp']),
			'ppn'				=>str_replace(',', '', $data['ppn']),
			'pph'				=>str_replace(',', '', $data['pph'])
		);
		$this->db->insert('tr_invoice', $dataInv);

		// invoice unit
		foreach ($data['no_unit'] as $k => $v) {
			$dataInvUnit = array(
				'no_po'=>$data['no_po'],
				'kode_entity'=>$this->session->userdata('kode_entity'),
				'no_unit'=>$v
			);
			$this->db->insert('tr_invoice_unit', $dataInvUnit);
		}
		// invoice sumberdaya
		foreach ($data['kode_sumberdaya'] as $k => $v) {
			$dataInvSD = array(
				'no_po'=>$data['no_po'],
				'kode_sumberdaya'=>$v,
				'volume'=>str_replace(',', '', $data['volume'][$k]),
				'harga_satuan'=>str_replace(',', '', $data['harga_satuan'][$k])
			);
			$this->db->insert('tr_invoice_sumberdaya', $dataInvSD);
		}
	}

	public function _update($data, $id) {
		// invoice (master)
		$dataInv = array(
			'kode_entity'		=>$data['kode_entity'],
			'tanggal'			=>$data['tanggal'],
			'is_um'				=>$data['is_um'],
			'no_invoice'		=>$data['no_invoice'],
			'asal_invoice'		=>$data['asal_invoice'],
			'no_po'				=>$data['no_po'],
			'kode_rekanan'		=>$data['kode_rekanan'],
			'no_surat_jalan'	=>$data['no_surat_jalan'],
			'tgl_surat_jalan'	=>$data['tgl_surat_jalan'],
			'no_bapb'			=>$data['no_bapb'],
			'tgl_bapb'			=>$data['tgl_bapb'],
			'kode_bpdp'			=>$data['kode_bpdp'],
			'is_pkp'			=>$data['is_pkp'],
			'rp'				=>str_replace(',', '', $data['rp']),
			'ppn'				=>str_replace(',', '', $data['ppn']),
			'pph'				=>str_replace(',', '', $data['pph'])
		);
		$this->db->where(array('id'=>$id));
		$this->db->update('tr_invoice', $dataInv);
		// invoice unit
		// delete existing
		$this->db->where(array('no_po'=>$data['no_po'], 'kode_entity'=>$data['kode_entity']));
		$this->db->delete('tr_invoice_unit');
		foreach ($data['no_unit'] as $k => $v) {
			$dataInvUnit = array(
				'no_po'=>$data['no_po'],
				'kode_entity'=>$this->session->userdata('kode_entity'),
				'no_unit'=>$v
			);
			$this->db->insert('tr_invoice_unit', $dataInvUnit);
		}
		// invoice sumberdaya
		$this->db->where(array('no_po'=>$data['no_po']));
		$this->db->delete('tr_invoice_sumberdaya');
		foreach ($data['kode_sumberdaya'] as $k => $v) {
			$dataInvSD = array(
				'no_po'=>$data['no_po'],
				'kode_sumberdaya'=>$v,
				'volume'=>str_replace(',', '', $data['volume'][$k]),
				'harga_satuan'=>str_replace(',', '', $data['harga_satuan'][$k])
			);
			$this->db->insert('tr_invoice_sumberdaya', $dataInvSD);
		}
	}

	public function delete($id) {
		// get info
		$q = $this->db->get_where('tr_invoice', array('id'=>$id));
		$res = $q->row_array();
		// delete unit
		$this->db->where(array('no_po'=>$res['no_po'], 'kode_entity'=>$res['kode_entity']));
		$this->db->delete('tr_invoice_unit');
		// delete sumberdaya
		$this->db->where(array('no_po'=>$res['no_po']));
		$this->db->delete('tr_invoice_sumberdaya');
		// delete invoice
		$this->db->where(array('id'=>$id));
		$this->db->delete('tr_invoice');
	}

	function _delete_sd($id) {
		// delete sumberdaya
		$this->db->where(array('no_po'=>$res['no_po']));
		$this->db->delete('tr_invoice_sumberdaya');
	}
		
}
	