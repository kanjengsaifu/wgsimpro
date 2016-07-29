<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mst_unit_price_model extends CI_Model {
		
	public function __construct() {
		// $this->load->database();
	}
	
	public function get($id = FALSE, $filter = FALSE) {
		if($id==FALSE) {
			$q = $this->db->get_where('mst_unit_price', array('kode_entity'=>$this->session->userdata('kode_entity')));
			return $q->result_array();
		} else {
			$q = $this->db->get_where('mst_unit_price', array('id'=>$id));
			return $q->row_array();
		}
	}

	public function get_optional() {
		// get optional
		$q = $this->db->get_where('mst_optional_unit_price', array('sflag'=>$this->session->userdata('type_entity')));
		$data = array();
		$iLoop = 0;
		foreach ($q->result_array() as $k => $v) {
			$data[$v['sfield']][$iLoop]['kode'] = $v['kode'];
			$data[$v['sfield']][$iLoop]['grup'] = $v['grup'];
			$data[$v['sfield']][$iLoop]['formula'] = $v['formula'];
			$data[$v['sfield']][$iLoop]['konten'] = $v['konten'];
			$iLoop++;
		}
		// get cara bayar
		// $q = $this->db->get_where('mst_optional', array('opsi'=>'PAYMENTPAYMODE', 'isactive'=>1));
		$q = $this->db->distinct()
				->select('kode_pay, deskripsi')
				->from('mst_payment_plan_detail')
				->order_by('kode_pay')
				->get();
		$data['paymodes'] = $q->result_array();
		return $data;
	}
	
	public function get_no_unit($id) {
		$q = $this->db->get_where('mst_unit_price', array('id'=>$id));
		$res = $q->row_array();
		$data = array();
		$data['no_unit'] = $q->num_rows()>0?$res['no_unit']:'';
		$this->db->select('pr.id, opsi.nama as type_price, FORMAT(pr.rp,2) AS rp', FALSE)
			->from('mst_unit_price AS pr')
			->join('mst_optional AS opsi', 'opsi.kode = pr.type_price', 'inner')
			->where(array('no_unit'=>$data['no_unit'], 'kode_entity'=>$this->session->userdata('kode_entity')));
		$qall = $this->db->get();
		$data['all'] = $qall->result_array();
		return $data;
	}
	
	public function get_price($id) {
		// prices
		$data['prices'] = $this->get($id);
		// stock
		$this->db->select('MD5(s.no_unit) AS xnounit, s.no_unit AS no_unit,stypep.konten AS type_property,stower.konten AS tower_cluster,'.
				'stypeu.konten AS type_unit,s.wide_netto AS wide_netto,s.wide_gross AS wide_gross,slantai.konten AS lantai_blok,sdir.konten AS direction',FALSE)
			->from('mst_stock s')
			->join('mst_optional_stock stypep', 'stypep.kode = s.type_property AND stypep.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->join('mst_optional_stock stower', 'stower.kode = s.tower_cluster AND stower.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->join('mst_optional_stock stypeu', 'stypeu.kode = s.type_unit AND stypeu.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->join('mst_optional_stock slantai', 'slantai.kode = s.lantai_blok AND slantai.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->join('mst_optional_stock sdir', 'sdir.kode = s.direction AND sdir.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->where(array('s.no_unit'=>$data['prices']['no_unit'],'kode_entity'=>$this->session->userdata('kode_entity')));
		$q = $this->db->get();
		$data['stock'] = $q->row_array();
		return $data;
	}

	public function get_prices($no_unit) {
		$q = $this->db->query("
			SELECT
				opr.grup AS grup,
				opr.konten AS jenis,
				IFNULL(pr.rp,0) AS rp,
				IFNULL(pr.kode_pay, '') AS xkode_pay,
				IFNULL(plan.deskripsi,'') AS pay
			FROM
				mst_optional_unit_price opr
				LEFT JOIN mst_unit_price pr ON pr.type_price = opr.kode 
					AND MD5(pr.no_unit) = '$no_unit'
					AND kode_entity = '".$this->session->userdata('kode_entity')."'
					AND pr.isactive = 1
				LEFT JOIN
				(
					SELECT DISTINCT
						kode_pay, deskripsi
					FROM
						mst_payment_plan_detail
				) AS plan ON plan.kode_pay = pr.kode_pay
			WHERE
				opr.sfield = 'type_price'
				AND opr.sflag = '".$this->session->userdata('type_entity')."'
			ORDER BY
				opr.no_urut,
				pr.kode_pay
		");
		foreach ($q->result_array() as $k => $v) {
			$data[$v['grup']][$v['jenis']][] = $v;
		}
		return $data;
	}

	public function _rounding($no_unit) {
		$q = $this->db->query("
			SELECT
				no_unit,
				kode_pay,
				IFNULL(SUM(rp), 0) AS rp
			FROM
				mst_unit_price
			WHERE
				MD5(no_unit) = '$no_unit'
				AND kode_entity = '".$this->session->userdata('kode_entity')."'
				AND isactive = 1
			GROUP BY
				no_unit,
				kode_pay
		");
		if($q->num_rows>0) {
			foreach ($q->result_array() as $k => $v) {
				if($v['rp'] % 1000 !== 0) {
					$qcbonus = $this->db->get_where('mst_unit_price', array('no_unit'=>$v['no_unit'],'kode_pay'=>$v['kode_pay'],
						'type_price'=>'CBONUS','isactive'=>1,'kode_entity'=>$this->session->userdata('kode_entity')));
					$rescbonus = $qcbonus->row_array();
					$data = array(
						'kode_entity'=>$this->session->userdata('kode_entity'),
						'no_unit'=>$v['no_unit'],
						'kode_pay'=>$v['kode_pay'],
						'type_price'=>'CBONUS',
						'grup'=>'CUSTOM',
						'rp'=>$rescbonus['rp']+(1000-($v['rp']%1000))
					);
					$this->_insert($data);
				}
			}
		}
	}
	
	public function _insert($data) {
		$data['kode_entity'] = $this->session->userdata('kode_entity');
		$q = $this->db->get_where('mst_unit_price', array('no_unit'=>$data['no_unit'], 
				'kode_pay'=>$data['kode_pay'], 'type_price'=>$data['type_price'], 
				'isactive'=>1,'kode_entity'=>$this->session->userdata('kode_entity')));
		if($q->num_rows()>0) {
			$this->db->where(array('no_unit'=>$data['no_unit'], 
				'kode_pay'=>$data['kode_pay'], 'type_price'=>$data['type_price'], 
				'isactive'=>1,'kode_entity'=>$this->session->userdata('kode_entity')));
			$this->db->update('mst_unit_price', array('isactive'=>0));
		}
		$this->db->insert('mst_unit_price',$data);
		return $this->db->insert_id();
	}
	
	public function _update($data, $id) {
		$this->db->where(array('id'=>$id));
		$this->db->update('mst_unit_price',$data);
		return $id;
	}
	
	public function _delete($id) {
		$this->db->where(array('id'=>$id));
		return $this->db->delete('mst_unit_price');
	}
		
}
	