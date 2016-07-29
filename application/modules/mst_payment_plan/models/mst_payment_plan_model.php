<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mst_payment_plan_model extends CI_Model {
		
	public function __construct() {
		// $this->load->database();
	}

	public function get($type = 'jenis', $id = FALSE) {
		if($id===FALSE) {
			$q = $this->db->get($type==='jenis'?'mst_payment_plan':'mst_payment_plan_detail');
			return $q->result_array();
		} else {
			if($type==='jenis') {
				$q = $this->db->get_where('mst_payment_plan', array('id'=>$id));
				return $type==='jenis'?$q->row_array():$q->result_array();
			} else {
				$q = $this->db->select('det.id, det.kode_pay, det.deskripsi, det.cara_bayar, '.
						'det.kode_item, pay.deskripsi AS item_deskripsi, pay.tipe_pay, pay.install_num, '.
						'pay.persentase, pay.rp')
					->from('mst_payment_plan_detail det')
					->join('mst_payment_plan pay', 'pay.kode_pay = det.kode_item', 'inner')
					->where(array('det.kode_pay'=>$id))
					->get();
				return $q->result_array();
			}
		}
	}

	public function get_optional() {
		$q = $this->db->get_where('mst_optional', array('opsi'=>'PAYMENTPAYMODE', 'isactive'=>1));
		$data['pays'] = $q->result_array();
		$q = $this->db->get('mst_payment_plan');
		// $data['items'] = $q->result_array();
		foreach ($q->result_array() as $k => $v) {
			$data['items'][$v['tipe_pay']][] = $v;
		}
		return $data;
	}

	public function _insert($type = 'jenis', $data) {
		return $this->db->insert($type==='jenis'?'mst_payment_plan':'mst_payment_plan_detail', $data);
	}

	public function _update($type = 'jenis', $data, $id) {
		$this->db->where(array('id'=>$id));
		return $this->db->update($type==='jenis'?'mst_payment_plan':'mst_payment_plan_detail', $data);
	}

	public function _delete($type = 'jenis', $id) {
		if($type==='pola') {
			$this->db->where(array('kode_pay'=>$id));
		} else {
			$this->db->where(array('id'=>$id));
		}
		return $this->db->delete($type==='jenis'?'mst_payment_plan':'mst_payment_plan_detail');
	}
		
}
	