<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tr_po_model extends CI_Model {
	
	public function get($id = FALSE, $filter = FALSE) {
		if($id==FALSE) {
			$this->db->select('po.*')
					 ->select("date_format(po.tanggal,'%d/%m/%Y') as xtanggal",FALSE)
					 ->from('tr_po po');
			$q = $this->db->get();
			return $q->result_array();
		} else {
			$this->db->select('po.*')
					 ->select("date_format(po.tanggal,'%d/%m/%Y') as xtanggal",FALSE)
					 ->from('tr_po po')
					 ->where(array('po.id'=>$id));
			$q = $this->db->get();
			return $q->row_array();
		}
	}

	public function get_po_and_detail($id) {
		// po
		$this->db->select('po.*')
			->select("date_format(po.tanggal,'%d/%m/%Y') as xtanggal",FALSE)
			->from('tr_po po')
			->where(array('po.id'=>$id));
		$q = $this->db->get();
		$data = $q->row_array();

		// po - sumberdaya
		$this->db->select('posd.*, sd.nama')
			->from('tr_po_sumberdaya posd')
			->join('mst_sumberdaya sd', 'sd.kode = posd.kode_sumberdaya')
			->where(array('no_po'=>$data['no_po']));
		$q = $this->db->get();
		$data['sumberdayas'] = $q->result_array();

		// unit
		$this->db->select('no_unit, sd_id')
				->from('tr_po_units')
				->where(array('no_po'=>$data['no_po']));
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
	
	public function _insert($data) {
		// po
		$dataPO = array(
			'tanggal'=>$data['tanggal'],
			'no_po'=>$data['no_po'],
			'kode_bpdp'=>$data['kode_bpdp'],
			'is_pkp'=>isset($data['is_pkp'])?$data['is_pkp']:0,
			'is_order'=>isset($data['is_order'])?$data['is_order']:0,
			'kode_entity'=>$data['kode_entity'],
			//'no_unit'=>$data['no_unit'],
			'kode_spk'=>$data['kode_spk']
		);
		$this->db->insert('tr_po',$dataPO);

		// po - sumberdaya
		//cari parent id po
		$this->db->select('id')
				 ->from('tr_po')
				 ->where(array('no_po'=>$data['no_po']));
		$q = $this->db->get();
		$res = $q->row();
		$po_id = $res->id;

		$sumberdayas = $data['kode_sumberdaya'];
		$hargas = $data['harga_satuan'];
		$volumes = $data['volume'];
		foreach ($sumberdayas as $k => $v) {
			$dataPOSD = array(
				'po_id'					=>$po_id,
				'no_po'					=>$data['no_po'],
				'kode_sumberdaya'		=>$v,
				'harga_satuan'			=>$hargas[$k],
				'volume'				=>$volumes[$k]
			);
			$dataPOSD['volume'] 		= str_replace(',', '', $dataPOSD['volume']);
			$dataPOSD['harga_satuan'] 	= str_replace(',', '', $dataPOSD['harga_satuan']);
			$this->db->insert('tr_po_sumberdaya',$dataPOSD);
		}

		//cari parent id sumberdaya
		$this->db->select('id')
				 ->from('tr_po_sumberdaya')
				 ->where(array('no_po'=>$data['no_po']));
		$q = $this->db->get();
		$res = $q->row();
		$sd_id = $res->id;
		foreach ($data['no_unit'] as $k => $v) {
			$dataUnit = array(
				'sd_id'			=> $sd_id,
				'no_po'		=>$data['no_po'],
				'kode_entity'	=>$this->session->userdata('kode_entity'),
				'no_unit'		=>$v
			);
			$this->db->insert('tr_po_units', $dataUnit);
		}

	}
	
	public function _update($data, $id) {
		// po
		$dataPO = array(
			'tanggal'=>$data['tanggal'],
			'no_po'=>$data['no_po'],
			'kode_bpdp'=>$data['kode_bpdp'],
			'is_pkp'=>isset($data['is_pkp'])?$data['is_pkp']:0,
			'is_order'=>isset($data['is_order'])?$data['is_order']:0,
			'kode_entity'=>$data['kode_entity'],
			//'no_unit'=>$data['no_unit'],
			'kode_spk'=>$data['kode_spk']
		);

		$dataUnits = array(
			'no_po'			=>$data['no_po'],
			'kode_entity'	=>$data['kode_entity'],
			'no_unit'		=>$data['no_unit']
			);

		//var_dump($dataUnits);
		//delete unit
		//$this->db->where(array('no_po'=>$data['no_po'],'kode_entity'=>$data['kode_entity']));
		//$this->db->delete('tr_po_units');
		//insert ulang unit
		//$this->db->insert('tr_po_units', $dataUnits);
		
		$this->db->where(array('id'=>$id));
		return $this->db->update('tr_po',$dataPO);
		//die;
		// po - sumberdaya
		// delete existing
		$this->db->where(array('no_po'=>$data['no_po'], 'kode_bpdp'=>$data['kode_bpdp'], 'kode_entity'=>$data['kode_entity']));
		$this->db->delete('tr_po_sumberdaya');
		// build new
		$sumberdayas = $data['kode_sumberdaya'];
		$hargas = $data['harga_satuan'];
		$volumes = $data['volume'];
		foreach ($sumberdayas as $k => $v) {
			$dataPOSD = array(
				'no_po'=>$data['no_po'],
				'kode_sumberdaya'=>$v,
				'harga_satuan'=>$hargas[$k],
				'volume'=>$volumes[$k]
			);
			$dataPOSD['volume'] = str_replace(',', '', $dataPOSD['volume']);
			$dataPOSD['harga_satuan'] = str_replace(',', '', $dataPOSD['harga_satuan']);
			$this->db->insert('tr_po_sumberdaya',$dataPOSD);
		}
	}
	
	public function _delete($id) {
		// get info
		$q = $this->db->get_where('tr_po', array('id'=>$id));
		$res = $q->row_array();
		// delete detail
		$this->db->where(array('no_po'=>$res['no_po'], 'kode_entity'=>$res['kode_entity'], 'kode_bpdp'=>$res['kode_bpdp']));
		$this->db->delete('tr_po_sumberdaya');
		// delete po
		$this->db->where(array('id'=>$id));
		return $this->db->delete('tr_po');
	}
		
}
	