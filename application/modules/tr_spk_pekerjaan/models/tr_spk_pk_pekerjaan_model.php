<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tr_spk_pk_pekerjaan_model extends CI_Model {
	
	public function get($id = FALSE, $filter = FALSE) {
		if($id==FALSE) {
			$this->db->select('spk.*')
					 ->select("date_format(spk.tanggal,'%d/%m/%Y') as xtanggal",FALSE)
					 ->from('tr_spk_pk spk');
			$q = $this->db->get();
			return $q->result_array();
		} else {
			$this->db->select('spk.*')
					 ->select("date_format(spk.tanggal,'%d/%m/%Y') as xtanggal",FALSE)
					 ->from('tr_spk_pk spk')
					 ->where(array('spk.id'=>$id));
			$q = $this->db->get();
			return $q->row_array();
		}
	}

	public function get_spk_and_detail($id) {
		// spk
		$this->db->select('spk.*')
			->select("date_format(spk.tanggal,'%d/%m/%Y') as xtanggal",FALSE)
			->from('tr_spk_pk spk')
			->where(array('spk.id'=>$id));
		$q = $this->db->get();
		$data = $q->row_array();

		// spk - sumberdaya
		$this->db->select('spksd.*, sd.nama')
			->from('tr_spk_pk_sumberdaya spksd')
			->join('mst_sumberdaya sd', 'sd.kode = spksd.kode_sumberdaya')
			->where(array('no_spk'=>$data['no_spk']));
		$q = $this->db->get();
		$data['sumberdayas'] = $q->result_array();

		// unit
		$this->db->select('no_unit, sd_id')
				->from('tr_spk_pk_units')
				->where(array('no_spk'=>$data['no_spk']));
		$q = $this->db->get();
		$data['units'] = $q->result_array();
		//var_dump($data);
		//die;
		return $data;
	}

	public function get_optional() {
		// bpdp
		$this->db->select('no_path, uraian')
				 ->from('tr_bpdp');
		$q = $this->db->get();
		$data['bpdps'] = $q->result_array();
		// rekanan
		$this->db->select('k.kode_spk, r.nama')
				 ->from('tr_kontrak k')
				 ->join('mst_rekanan r', 'r.kode_rekanan = k.kode_rekanan')
				 ->where(array('kode_entity'=>$this->session->userdata('kode_entity')));
		$q = $this->db->get();
		$data['kontraks'] = $q->result_array();
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
	
	function tambah_unit($data)
	{
		foreach ($data['nounit'] as $k => $v) {
			$dataUnit = array(
				'sd_id'			=>$data['sdid'],
				'no_spk'			=>$data['no_spk'],
				'kode_entity'	=>$this->session->userdata('kode_entity'),
				'no_unit'		=>$v
			);
			$this->db->insert('tr_spk_pk_units', $dataUnit);
		}
	}
	public function _insert($data) {
		// spk
		$dataspk = array(
			'tanggal'=>$data['tanggal'],
			'no_spk'=>$data['no_spk'],
			'kode_bpdp'=>$data['kode_bpdp'],
			'is_pkp'=>isset($data['is_pkp'])?$data['is_pkp']:0,
			'is_order'=>isset($data['is_order'])?$data['is_order']:0,
			'kode_entity'=>$data['kode_entity'],
			//'no_unit'=>$data['no_unit'],
			'kode_spk'=>$data['kode_spk']
		);
		$this->db->insert('tr_spk_pk',$dataspk);

		// spk - sumberdaya
		//cari parent id spk
		$this->db->select('id')
				 ->from('tr_spk_pk')
				 ->where(array('no_spk'=>$data['no_spk']));
		$q = $this->db->get();
		$res = $q->row();
		$spk_id = $res->id;

		$sumberdayas = $data['kode_sumberdaya'];
		$hargas = $data['harga_satuan'];
		$volumes = $data['volume'];
		$units = $data['nounit'];
		foreach ($sumberdayas as $k => $v) {
			$dataSPKSD = array(
				'spk_id'					=>$spk_id,
				'no_spk'					=>$data['no_spk'],
				'kode_sumberdaya'		=>$v,
				'harga_satuan'			=>$hargas[$k],
				'volume'				=>$volumes[$k],
				'no_unit'				=>$units[$k]
			);
			$dataSPKSD['volume'] 		= str_replace(',', '', $dataSPKSD['volume']);
			$dataSPKSD['harga_satuan'] 	= str_replace(',', '', $dataSPKSD['harga_satuan']);
			$this->db->insert('tr_po_sumberdaya',$dataSPKSD);
		}

		//cari parent id sumberdaya
		$this->db->select('spk_id')
				 ->from('tr_spk_pk_sumberdaya')
				 ->where(array('no_spk'=>$data['no_spk']));
		$q = $this->db->get();
		$res = $q->row();
		$sd_id = $res->spk_id;
		foreach ($data['no_unit'] as $k => $v) {
			$dataUnit = array(
				'sd_id'			=> $sd_id,
				'no_spk'			=>$data['no_spk'],
				'kode_entity'	=>$this->session->userdata('kode_entity'),
				'no_unit'		=>$v
			);
			$this->db->insert('tr_spk_pk_units', $dataUnit);
		}

	}

	function genNoUnitEdit()
	{
		// unit
		$this->db->select('no_unit')
				 ->from('mst_stock')
				 ->where(array('kode_entity'=>$this->session->userdata('kode_entity')));
		return $q = $this->db->get();
		//$data['stocks'] = $q->result_array();
		//return $data;
	}
	public function getUnit_BySDID($sdid)
	{
		$this->db->select('*')
				 ->from('tr_spk_pk_units')
				 ->where(array('sd_id'=>$sdid));
		return $q = $this->db->get();
		//$data['units'] = $q->result_array();
		//return $data;
	}

	function deltUnit_byID($id)
	{
		$this->db->where(array('id'=>$id));
		return $this->db->delete('tr_spk_pk_sumberdaya');
	}
	
	public function _update($data, $id) {
		// spk
		$dataspk = array(
			'tanggal'			=>$data['tanggal'],
			'no_spk'				=>$data['no_spk'],
			'kode_bpdp'			=>$data['kode_bpdp'],
			'is_pkp'			=>isset($data['is_pkp'])?$data['is_pkp']:0,
			'is_order'			=>isset($data['is_order'])?$data['is_order']:0,
			'kode_entity'		=>$data['kode_entity'],
			//'no_unit'=>$data['no_unit'],
			'kode_spk'			=>$data['kode_spk']
		);

		$this->db->where(array('id'=>$id));
		$this->db->update('tr_spk_pk',$dataspk);

		// build new
		$sumberdayas 	= $data['kode_sumberdaya'];
		$hargas 		= $data['harga_satuan'];
		$volumes 		= $data['volume'];
		$units 			= $data['nounit'];
		foreach ($sumberdayas as $k => $v) {
			$dataSPKSD = array(
				'no_spk'				=>$data['no_spk'],
				'spk_id'				=>$id,
				'kode_sumberdaya'	=>$v,
				'harga_satuan'		=>$hargas[$k],
				'volume'			=>$volumes[$k],
				'no_unit'			=>$units[$k]
			);
			$dataSPKSD['volume'] = str_replace(',', '', $dataSPKSD['volume']);
			$dataSPKSD['harga_satuan'] = str_replace(',', '', $dataSPKSD['harga_satuan']);
			$this->db->insert('tr_spk_pk_sumberdaya',$dataSPKSD);
		}

		// spk - unit
		//cari parent id sumberdaya
		/*
		$this->db->select('id, spk_id')
				 ->from('tr_spk_pk_sumberdaya')
				 ->where(array('no_spk'=>$data['no_spk']));
		$q = $this->db->get();
		$res = $q->row();
		$sd_id = $res->id;
		// delete existing
		//$this->db->where(array('no_spk'=>$data['no_spk']));
		//$this->db->delete('tr_spk_pk_units');
		// build new
		$units = $data['no_unit'];
		$hargas = $data['harga_satuan'];
		$volumes = $data['volume'];
		foreach ($units as $k => $v) {
			$dataUNIT = array(
				'sd_id'			=>$sd_id,
				'no_spk'			=>$data['no_spk'],
				'kode_entity'	=>$data['kode_entity'],
				'no_unit'		=>$v
			);
			$this->db->insert('tr_spk_pk_units',$dataUNIT);
		}
		*/
	}
	
	public function _delete($id) {
		// get info
		$q = $this->db->get_where('tr_spk_pk', array('id'=>$id));
		$res = $q->row_array();
		// delete detail
		$this->db->where(array('no_spk'=>$res['no_spk'], 'kode_entity'=>$res['kode_entity'], 'kode_bpdp'=>$res['kode_bpdp']));
		$this->db->delete('tr_spk_pk_sumberdaya');
		// delete spk
		$this->db->where(array('id'=>$id));
		return $this->db->delete('tr_spk_pk');
	}
		
}
	