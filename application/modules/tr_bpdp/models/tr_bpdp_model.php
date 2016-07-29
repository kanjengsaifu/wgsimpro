<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tr_bpdp_model extends CI_Model {

	public function get_by_kode($kode_entity) {
		$this->db->select('e.kode AS kode_entity, e.nama, IFNULL(ejenis.konten,"") AS jenis, DATE_FORMAT(tgl_mulai, "%d/%m/%Y") AS tgl_mulai,'.
				'DATE_FORMAT(tgl_selesai, "%d/%m/%Y") AS tgl_selesai, IFNULL(etype.konten,"") AS type_entity, '.
				'FORMAT(nilai_developer, 2) AS nilai_developer', FALSE)
			->from('mst_entity e')
			->join('mst_optional_entity ejenis', 'ejenis.kode = e.jenis AND ejenis.sfield = "jenis" AND ejenis.isactive = 1', 'left')
			->join('mst_optional_entity etype', 'etype.kode = e.type_entity AND etype.sfield = "type_entity" AND etype.isactive = 1', 'left')
			->where(array('e.kode'=>$kode_entity));
		$q = $this->db->get();
		$data = $q->row_array();
		return $data;
	}

	public function get_optional() {
		// uraian
		// $this->db->select('konten');
		// $q = $this->db->get_where('mst_optional_bpdp', array('sflag'=>'uraian', 'isactive'=>1));
		$this->db->select('konten, jenis');
		$q = $this->db->get_where('mst_optional_rik', array('sflag'=>'rencana_biaya', 'isactive'=>1));
		$data['uraians'] = $q->result_array();

		$this->db->distinct()
			->select('uraian AS konten, jenis')
			->from('tr_bpdp')
			->where('uraian NOT IN (SELECT konten FROM mst_optional_rik WHERE sflag = "rencana_biaya")');
		$q = $this->db->get();
		foreach ($q->result_array() as $k => $v) {
			$data['uraians'][] = $v;
		}
		// coa
		$this->db->select('kode, nama')
			->from('mst_coa')
			->where('kode LIKE "4%"');
		$q = $this->db->get();
		$data['coas'] = $q->result_array();
		// unit
		$this->db->select('no_unit')
			->where(array('kode_entity'=>$this->session->userdata('kode_entity')));
		$q = $this->db->get('mst_stock');
		$data['units'] = $q->result_array();
		// rik
		$this->db->select('rb.id, opsi.konten')
			->from('tr_rik_detail_rencana_biaya rb')
			->join('mst_optional_rik opsi', 'opsi.kode = rb.kode_biaya AND opsi.sflag = "rencana_biaya" AND opsi.isactive = 1', 'inner')
			->where('rb.kode_entity = "'.$this->session->userdata('kode_entity').'"');
		$q = $this->db->get();
		$data['riks'] = $q->result_array();
		// type property
		$q = $this->db->get_where('mst_optional_stock', array('sfield'=>'type_property', 
			'sflag'=>$this->session->userdata('type_entity'), 'isactive'=>1));
		$data['type_property'] = $q->result_array();
		return $data;
	}

	public function get($kode_entity, $tahun, $prop, $jenis) {
		$this->db->select('*', FALSE)
			->from('tr_bpdp')
			->where(array('kode_entity'=>$kode_entity, 'tahun'=>$tahun, 'type_property'=>$prop, 'jenis'=>$jenis))
			->order_by('grup, no_path');
		$q = $this->db->get();
		if($q->num_rows()>0) {
			$data['kode_entity'] = $kode_entity;
			$data['items'] = $q->result_array();
			foreach ($data['items'] as $k => $v) {
				$this->db->select('*')
					->from('tr_bpdp_unit')
					->where(array('kode_entity'=>$kode_entity, 'tahun'=>$tahun, 'no_path'=>$v['no_path']))
					->order_by('no_unit');
				$qunit = $this->db->get();
				if($qunit->num_rows()>0)
					$data['items'][$k]['units'] = $qunit->result_array();
			}
			return $data;
		} else {
			$this->db->select('"0" AS parent, "1" AS grup, orik.konten AS uraian, '.
					'"" AS kode_coa, 0 AS bobot, (rb.volume*rb.biaya) AS rp, 0 AS has_total, '.
					'jenis, "'.$prop.'" AS type_property, "" AS kode_rik', FALSE)
				->from('tr_rik_detail_rencana_biaya rb')
				->join('mst_optional_rik orik', 'orik.kode = rb.kode_biaya AND orik.sflag = "rencana_biaya" AND orik.jenis = "'.$jenis.'"', 'inner')
				->where(array('rb.kode_entity'=>$kode_entity))
				->order_by('jenis');
			$q = $this->db->get();
			$data['kode_entity'] = $kode_entity;
			$data['items'] = $q->result_array();
			foreach ($data['items'] as $k => $v) {
				$data['items'][$k]['no_path'] = ($k+1);
			}
			return $data;
		}
	}

	public function save($data) {
		// delete bpdp if exist
		$this->db->where(
			array(
				'kode_entity'=>$data['kode_entity'],
				'tahun'=>$data['tahun']
			)
		);
		$this->db->delete('tr_bpdp');
		// delete bpdp units if exist
		$this->db->where(
			array(
				'kode_entity'=>$data['kode_entity'],
				'tahun'=>$data['tahun']
			)
		);
		$this->db->delete('tr_bpdp_unit');
		// build data
		$items = $data['no_path'];
		foreach ($items as $k => $v) {
			// insert bpdp
			$item = array(
				'kode_entity'=>$data['kode_entity'],
				'tahun'=>$data['tahun'],
				'no_path'=>$v,
				'parent'=>$data['parent'][$k],
				'uraian'=>$data['uraian'][$k],
				'kode_coa'=>$data['kode_coa'][$k],
				'bobot'=>str_replace(',', '', $data['bobot'][$k]),
				'rp'=>str_replace(',', '', $data['rp'][$k]),
				'jenis'=>$data['jenis'][$k],
				'type_property'=>$data['type_property'][$k],
			);
			$this->db->insert('tr_bpdp', $item);
			// insert units
			// reformat 
			$thePath = str_replace('.', '_', $v);
			if(isset($data['no_unit']['d'.$thePath])) {
				foreach ($data['no_unit']['d'.$thePath] as $k2 => $v2) {
					$itemUnit = array(
						'kode_entity'=>$data['kode_entity'],
						'tahun'=>$data['tahun'],
						'jenis'=>$data['jenis'][$k],
						'type_property'=>$data['type_property'][$k],
						'no_path'=>$v,
						'no_unit'=>$v2,
						'volume'=>str_replace(',', '', $data['vol_unit']['d'.$thePath][$k]),
						'rp'=>str_replace(',', '', $data['rp_unit']['d'.$thePath][$k])
					);
					$this->db->insert('tr_bpdp_unit', $itemUnit);
				}
			}
		}
	}

}