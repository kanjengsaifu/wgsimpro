<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class tr_spk_pekerjaan_model extends CI_Model {
	
	public function get($id = FALSE, $filter = FALSE) {
		if($id==FALSE) {
			$this->db->select('sppk.*')
					 ->select("date_format(sppk.tanggal,'%d/%m/%Y') as xtanggal",FALSE)
					 ->from('tr_spk_pk sppk');
			$q = $this->db->get();
			return $q->result_array();
		} else {
			$this->db->select('sppk.*')
					 ->select("date_format(sppk.tanggal,'%d/%m/%Y') as xtanggal",FALSE)
					 ->from('tr_spk_pk sppk')
					 ->where(array('sppk.id'=>$id));
			$q = $this->db->get();
			return $q->row_array();
		}
	}

	public function get_spk_and_detail($id) {
		// sppk
		$this->db->select('sppk.*')
			->select("date_format(sppk.tanggal,'%d/%m/%Y') as xtanggal",FALSE)
			->from('tr_spk_pk sppk')
			->where(array('sppk.id'=>$id));
		$q = $this->db->get();
		$data = $q->row_array();
		// sppk - sumberdaya
		$this->db->select('sppksd.*, sd.nama')
			->from('tr_spk_pk_sumberdaya sppksd')
			->join('mst_sumberdaya sd', 'sd.kode = sppksd.kode_sumberdaya')
			->where(array('no_spk'=>$data['no_spk']));
		$q = $this->db->get();
		$data['sumberdayas'] = $q->result_array();

		$this->db->select('*')
				 ->from('tr_spk_pk_units')
				 ->where(array('no_spk' => $data['no_spk']));
				$q = $this->db->get();
		$data['units'] = $q->result_array();
		
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
	
	public function _insert($data) {
		// spk_pk
		$dataSPK = array(
			'tanggal'=>$data['tanggal'],
			'no_spk'=>$data['no_spk'],
			'kode_bpdp'=>$data['kode_bpdp'],
			'is_pkp'=>isset($data['is_pkp'])?$data['is_pkp']:0,
			'is_order'=>isset($data['is_order'])?$data['is_order']:0,
			'kode_entity'=>$data['kode_entity'],
			//'no_unit'=>$data['no_unit'],
			'kode_spk'=>$data['kode_spk']
		);
		$this->db->insert('tr_spk_pk',$dataSPK);
		// spk_pk - sumberdaya
		$sumberdayas = $data['kode_sumberdaya'];
		$hargas = $data['harga_satuan'];
		$volumes = $data['volume'];
		foreach ($sumberdayas as $k => $v) {
			$dataSPKSD = array(
				'no_spk'=>$data['no_spk'],
				'kode_sumberdaya'=>$v,
				'harga_satuan'=>$hargas[$k],
				'volume'=>$volumes[$k]
			);
			$dataSPKSD['volume'] = str_replace(',', '', $dataSPKSD['volume']);
			$dataSPKSD['harga_satuan'] = str_replace(',', '', $dataSPKSD['harga_satuan']);
			$this->db->insert('tr_spk_pk_sumberdaya',$dataSPKSD);
		}

		
		foreach ($data['no_unit'] as $k => $v) {
			$dataUnit = array(
				'no_spk'		=>$data['no_spk'],
				'kode_entity'	=>$this->session->userdata('kode_entity'),
				'no_unit'		=>$v
			);
			$this->db->insert('tr_spk_pk_units', $dataUnit);
		}
	}


	public function _update($data, $id) {
		
		$dataSPK = array(
			'tanggal'=>$data['tanggal'],
			'no_spk'=>$data['no_spk'],
			'kode_bpdp'=>$data['kode_bpdp'],
			'is_pkp'=>isset($data['is_pkp'])?$data['is_pkp']:0,
			'is_order'=>isset($data['is_order'])?$data['is_order']:0,
			'kode_entity'=>$data['kode_entity'],
			//'no_unit'=>$data['no_unit'],
			'kode_spk'=>$data['kode_spk']
		);
		$this->db->where(array('id'=>$id));
		$this->db->update('tr_spk_pk',$dataSPK);
		// po - sumberdaya
		// delete existing
		$this->db->where(array('spk_pk_id'=>$id));
		$this->db->delete('tr_spk_pk_sumberdaya');
		// build new
		$sumberdayas = $data['kode_sumberdaya'];
		$hargas = $data['harga_satuan'];
		$volumes = $data['volume'];
		foreach ($sumberdayas as $k => $v) {
			$dataSPKSD = array(
				'no_spk'			=>$data['no_spk'],
				'kode_sumberdaya'	=>$v,
				'harga_satuan'		=>$hargas[$k],
				'volume'			=>$volumes[$k],
				'spk_pk_id'			=>$id
			);
			$dataSPKSD['volume'] = str_replace(',', '', $dataSPKSD['volume']);
			$dataSPKSD['harga_satuan'] = str_replace(',', '', $dataSPKSD['harga_satuan']);
			
			$this->db->insert('tr_spk_pk_sumberdaya',$dataSPKSD);
		}

		// delete existing
		$this->db->where(array('spk_pk_id'=>$id));
		$this->db->delete('tr_spk_pk_units');
		foreach ($data['no_unit'] as $k => $v) {
			$dataUnit = array(
				'no_spk'		=>$data['no_spk'],
				'kode_entity'	=>$this->session->userdata('kode_entity'),
				'no_unit'		=>$v,
				'spk_pk_id'		=>$id
			);
			$this->db->insert('tr_spk_pk_units', $dataUnit);
		}

	}
	
	public function _delete($id) {
		// get info
		$q = $this->db->get_where('tr_spk_pk', array('id'=>$id));
		$res = $q->row_array();

		// delete detail
		$this->db->where(array('spk_pk_id'=>$id));
		$this->db->delete('tr_spk_pk_sumberdaya');
		
		//unit
		$this->db->where(array('spk_pk_id'=>$id));
		$this->db->delete('tr_spk_pk_units');

		// delete spk
		$this->db->where(array('spk_pk_id'=>$id));
		return $this->db->delete('tr_spk_pk');
	}
		
}
	