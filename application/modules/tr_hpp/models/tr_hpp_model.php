<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tr_hpp_model extends CI_Model {
		
	public function __construct() {
		// $this->load->database();
	}

	public function get_optional() {
		$q = $this->db->get_where('mst_optional_hpp', array('sflag'=>'jenis', 'isactive'=>1, 'type_entity'=>'LD'));
		$data['jenises'] = $q->result_array();
		return $data;
	}

	public function get_optional_hr() {
		$q = $this->db->get_where('mst_optional_hpp', array('sflag'=>'uraian', 'isactive'=>1, 'type_entity'=>'HR'));
		$data['uraians'] = $q->result_array();
		return $data;
	}

	public function get_hpp($enc_unit) {
		$this->db->select('opsi.konten, hpp.rp')
			->from('tr_hpp hpp')
			->join('mst_optional_hpp opsi', 'opsi.kode = hpp.jenis AND opsi.sflag = "jenis" AND isactive = 1', 'inner')
			->where(array('kode_entity'=>$this->session->userdata('kode_entity'), 'MD5(hpp.no_unit)'=>$enc_unit));
		$q = $this->db->get();
		return $q->result_array();
	}

	public function get_total_progress() {
		if($this->session->userdata('type_entity')==='LD') {
			$sql = "
				SELECT
					IFNULL(SUM(hpp.rp),0) AS hpp,
					IFNULL(SUM(ri.rp),0) AS ri
				FROM
					mst_stock s
				LEFT JOIN (
					SELECT
						kode_entity,
						no_unit,
						SUM(rp) AS rp
					FROM
						tr_hpp
					GROUP BY
						kode_entity,
						no_unit
				) AS hpp ON hpp.kode_entity = s.kode_entity
				AND hpp.no_unit = s.no_unit
				LEFT JOIN (
					SELECT
						invunit.kode_entity,
						invunit.no_unit,
						inv.rp / tbl.n AS rp
					FROM
						tr_invoice_unit invunit
					LEFT JOIN (
						SELECT
							no_po,
							COUNT(*) AS n
						FROM
							tr_invoice_unit
						GROUP BY
							no_po
					) AS tbl ON tbl.no_po = invunit.no_po
					INNER JOIN tr_invoice inv ON inv.no_po = invunit.no_po
				) AS ri ON ri.kode_entity = s.kode_entity AND ri.no_unit = s.no_unit
				WHERE
					s.kode_entity = '".$this->session->userdata('kode_entity')."'
			";
		} elseif($this->session->userdata('type_entity')==='HR') {
			$sql = "
				SELECT
					IFNULL(SUM(hpp.rp), 0) AS hpp,
					IFNULL(SUM(ri.rp), 0) AS ri
				FROM
					mst_stock s
				LEFT JOIN (
					SELECT
						stk.kode_entity,
						stk.no_unit,
						stk.wide_gross * SUM(hpp.rp) / rik.luas AS rp
					FROM
						tr_hpp_hr hpp
					INNER JOIN mst_stock stk ON stk.kode_entity = hpp.kode_entity
						AND stk.type_property = hpp.type_property
					INNER JOIN (
						SELECT
							kode_entity,
							type_property,
							SUM(luas * volume) AS luas
						FROM
							tr_rik_detail_rencana_produk
						GROUP BY
							kode_entity,
							type_property
					) AS rik ON rik.kode_entity = hpp.kode_entity
						AND rik.type_property = hpp.type_property
					GROUP BY
						stk.kode_entity,
						stk.type_property,
						stk.no_unit
				) AS hpp ON hpp.kode_entity = s.kode_entity
				AND hpp.no_unit = s.no_unit
				LEFT JOIN (
					SELECT
						invunit.kode_entity,
						invunit.no_unit,
						inv.rp / tbl.n AS rp
					FROM
						tr_invoice_unit invunit
					LEFT JOIN (
						SELECT
							no_po,
							COUNT(*) AS n
						FROM
							tr_invoice_unit
						GROUP BY
							no_po
					) AS tbl ON tbl.no_po = invunit.no_po
					INNER JOIN tr_invoice inv ON inv.no_po = invunit.no_po
				) AS ri ON ri.kode_entity = s.kode_entity AND ri.no_unit = s.no_unit
				WHERE
					s.kode_entity = '".$this->session->userdata('kode_entity')."'
			";
		}
		$q = $this->db->query($sql);
		return $q->row_array();
	}

	public function get($kode_entity) {
		// luas
		$this->db->select('rik_rap.type_property, SUM(rik_rap.luas*rik_rap.volume) AS luas, opsi.nama AS str', FALSE)
			->from('tr_rik_detail_rencana_produk rik_rap')
			->join('mst_optional opsi', 'opsi.kode = rik_rap.type_property AND opsi.opsi = "STOCKUNITTYPE"', 'left')
			->where(array('rik_rap.kode_entity'=>$this->session->userdata('kode_entity')))
			->group_by('rik_rap.type_property');
		$q = $this->db->get();
		$dataX = array(
			'luas'=>$q->result_array(),
			'data'=>array()
		);
		// contents
		$this->db->select('*', FALSE)
			->from('tr_hpp_hr')
			->where(array('kode_entity'=>$kode_entity));
		$q = $this->db->get();
		if($q->num_rows()>0) {
			$res = $q->result_array();
			$data = array();
			foreach ($res as $k => $v) {
				$data[$v['jenis']][$v['no_path']][$v['parent']][$v['uraian']][$v['type_property']] = $v['rp'];
			}
			$iLoop = 0;
			foreach ($data as $k => $v) {
				$dataX['data'][$iLoop]['jenis'] = $k;
				foreach ($v as $k2 => $v2) {
					if(!isset($dataX['data'][$iLoop]['jenis']))
						$dataX['data'][$iLoop]['jenis'] = $k;
					$dataX['data'][$iLoop]['no_path'] = $k2;
					foreach ($v2 as $k3 => $v3) {
						$dataX['data'][$iLoop]['parent'] = $k3;
						foreach ($v3 as $k4 => $v4) {
							$dataX['data'][$iLoop]['uraian'] = $k4;
							foreach ($v4 as $k5 => $v5) {
								$dataX['data'][$iLoop]['rp_'.$k5] = $v5;
							}
						}
					}
					$iLoop++;
				}
				$iLoop++;
			}
		}
		return $dataX;
	}

	public function _insert($data) {
		$q = $this->db->get_where('tr_hpp', array('kode_entity'=>$this->session->userdata('kode_entity'),
			'no_unit'=>$data['no_unit'], 'jenis'=>$data['jenis']));
		$res = $q->row_array();
		if($q->num_rows()>0) {
			$this->db->where(array('id'=>$res['id']));
			return $this->db->update('tr_hpp', $data);
		} else {
			return $this->db->insert('tr_hpp', $data);
		}
	}
	public function _insert_hr($data) {
		// print_r($data);
		$rps = $data['rp'];
		$out = '';
		// delete old data
		$this->db->where(array('kode_entity'=>$this->session->userdata('kode_entity')));
		$this->db->delete('tr_hpp_hr');
		// new hpp
		foreach ($data['rp'] as $k => $v) {
			foreach ($v as $k2 => $v2) {
				// uraian (optional)
				$q = $this->db->get_where('mst_optional_hpp', 
					array('sflag'=>'uraian', 'type_entity'=>'HR', 'jenis'=>$data['jenis'][$k2], 
						'konten'=>$data['uraian'][$k2]));
				if($q->num_rows()<1) {
					$this->db->insert('mst_optional_hpp', 
						array('sflag'=>'uraian', 'type_entity'=>'HR', 'jenis'=>$data['jenis'][$k2], 
							'kode'=>'HR', 'konten'=>$data['uraian'][$k2]));
				}
				// hpp
				$arr = array(
					'kode_entity'=>$this->session->userdata('kode_entity'),
					'no_path'=>$data['no_path'][$k2],
					'parent'=>$data['parent'][$k2],
					'uraian'=>$data['uraian'][$k2],
					'jenis'=>$data['jenis'][$k2],
					'type_property'=>$k,
					'rp'=>str_replace(',', '', $v2)
				);
				$out .= $this->db->insert('tr_hpp_hr', $arr);
			}
		}
		return $out;
	}
		
}
	