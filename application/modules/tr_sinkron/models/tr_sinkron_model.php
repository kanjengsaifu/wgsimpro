<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tr_sinkron_model extends CI_Model {

	public function do_proses_sales($json) {
		$this->db->trans_start(TRUE);
		$sinkron = array(
			'job_code'=>'SINKRON_SALES',
			'kode_entity'=>$this->session->userdata('kode_entity'),
			'source'=>'http://ris.wikarealty.co.id',
			'destination'=>'localhost',
			'json'=>$json,
			'actor'=>$this->session->userdata('usernm'),
			'job_time'=>date('Y-m-d H:i:s')
		);
		$this->db->insert('tr_sinkron', $sinkron);
		$sinkron_id = $this->db->insert_id();
		$pref = array(
			'tables'=>array(
				'mst_optional_stock', 'mst_stock', 'mst_payment_plan', 'mst_payment_plan_detail',
				'mst_optional_unit_price', 'mst_unit_price', 'mst_bank', 'mst_diskon', 'mst_optional_dokumen',
				'mst_sales', 'tr_payment', 'tr_payment_detail', 'mst_nasabah', 'mst_nasabah_alamat'
			),
			'format'=>'txt',
			'filename'=>'sinkron_sales_'.$sinkron_id.'.sql',
			'add_drop'=>TRUE,
			'add_insert'=>TRUE,
			'newline'=>"\n"
		);
		$this->load->dbutil();
		$backup = $this->dbutil->backup($pref);
		$this->load->helper('file');
		write_file(FCPATH.'sinkron_sales_'.$sinkron_id.'.sql', $backup);
		$data = json_decode($json);
		// var_dump($data->tr_payment); die();
		if(isset($data->mst_optional_stock)) {
			$this->db->query('TRUNCATE mst_optional_stock');
			foreach ($data->mst_optional_stock as $k => $v) {
				$this->db->insert('mst_optional_stock', $v);
			}
		}
		if(isset($data->mst_stock)) {
			$this->db->query('TRUNCATE mst_stock');
			foreach ($data->mst_stock as $k => $v) {
				$this->db->insert('mst_stock', $v);
			}
		}
		if(isset($data->mst_payment_plan)) {
			$this->db->query('TRUNCATE mst_payment_plan');
			foreach ($data->mst_payment_plan as $k => $v) {
				$this->db->insert('mst_payment_plan', $v);
			}
		}
		if(isset($data->mst_payment_plan_detail)) {
			$this->db->query('TRUNCATE mst_payment_plan_detail');
			foreach ($data->mst_payment_plan_detail as $k => $v) {
				$this->db->insert('mst_payment_plan_detail', $v);
			}
		}
		if(isset($data->mst_optional_unit_price)) {
			$this->db->query('TRUNCATE mst_optional_unit_price');
			foreach ($data->mst_optional_unit_price as $k => $v) {
				$this->db->insert('mst_optional_unit_price', $v);
			}
		}
		if(isset($data->mst_unit_price)) {
			$this->db->query('TRUNCATE mst_unit_price');
			foreach ($data->mst_unit_price as $k => $v) {
				$this->db->insert('mst_unit_price', $v);
			}
		}
		if(isset($data->mst_bank)) {
			$this->db->query('TRUNCATE mst_bank');
			foreach ($data->mst_bank as $k => $v) {
				$this->db->insert('mst_bank', $v);
			}
		}
		if(isset($data->mst_diskon)) {
			$this->db->query('TRUNCATE mst_diskon');
			foreach ($data->mst_diskon as $k => $v) {
				$this->db->insert('mst_diskon', $v);
			}
		}
		if(isset($data->mst_sales)) {
			$this->db->query('TRUNCATE mst_sales');
			foreach ($data->mst_sales as $k => $v) {
				$this->db->insert('mst_sales', $v);
			}
		}
		if(isset($data->mst_optional_dokumen)) {
			$this->db->query('TRUNCATE mst_optional_dokumen');
			foreach ($data->mst_optional_dokumen as $k => $v) {
				$this->db->insert('mst_optional_dokumen', $v);
			}
		}
		// $this->db->select('paydet.*')
		// 	->from('tr_payment_detail AS paydet')
		// 	->join('tr_payment AS pay', 'pay.reserve_no = paydet.reserve_no AND pay.kode_entity = "'.$this->session->userdata('kode_entity').'"')
		// 	->where('paydet.tgl_bayar IS NOT NULL', NULL, FALSE);
		$this->db->like('reserve_no', 'RSV-'.$this->session->userdata('kode_entity').'-')
			->where('tgl_bayar IS NOT NULL', NULL, FALSE);
		$qpaydet = $this->db->get('tr_payment_detail');
		$respaydet = $qpaydet->result_array();
		$datapaydet = array();
		$iLoop = 0;
		foreach ($respaydet as $k => $v) {
			foreach ($v as $kcol => $vcol) {
				$datapaydet[$iLoop][$kcol] = $kcol==='id' ? NULL : $vcol; 
			}
			$iLoop++;
		}
		if(isset($data->tr_payment)) {
			$this->db->query('TRUNCATE tr_payment');
			foreach ($data->tr_payment as $k => $v) {
				$this->db->insert('tr_payment', $v);
			}
		}
		if(isset($data->tr_payment_detail)) {
			$this->db->query('TRUNCATE tr_payment_detail');
			foreach ($data->tr_payment_detail as $k => $v) {
				$this->db->insert('tr_payment_detail', $v);
			}
			foreach ($datapaydet as $k => $v) {
				$this->db->insert('tr_payment_detail', $v);
			}
		}
		if(isset($data->mst_nasabah)) {
			$this->db->query('TRUNCATE mst_nasabah');
			foreach ($data->mst_nasabah as $k => $v) {
				$this->db->insert('mst_nasabah', $v);
			}
		}
		if(isset($data->mst_nasabah_alamat)) {
			$this->db->query('TRUNCATE mst_nasabah_alamat');
			foreach ($data->mst_nasabah_alamat as $k => $v) {
				$this->db->insert('mst_nasabah_alamat', $v);
			}
		}
		$this->db->trans_complete();
		return '1';
	}

	public function do_backup_trx() {
		$data = array();
		$q = $this->db->get_where('mst_bank_alokasi', array('kode_entity'=>$this->session->userdata('kode_entity')));
		$res = $q->result_array();
		$iLoop = 0;
		foreach ($res as $krow => $vrow) {
			foreach ($vrow as $kcol => $vcol) {
				$data['mst_bank_alokasi'][$iLoop][$kcol] = $kcol==='id' ? NULL : $vcol; 
			}
			$iLoop++;
		}
		$this->db->like('reserve_no', 'RSV-'.$this->session->userdata('kode_entity').'-');
		$q = $this->db->get('mst_bank_plafond');
		$res = $q->result_array();
		$iLoop = 0;
		foreach ($res as $krow => $vrow) {
			foreach ($vrow as $kcol => $vcol) {
				$data['mst_bank_plafond'][$iLoop][$kcol] = $kcol==='id' ? NULL : $vcol; 
			}
			$iLoop++;
		}
		$this->db->like('reserve_no', 'RSV-'.$this->session->userdata('kode_entity').'-');
			// ->where('tgl_bayar IS NULL', NULL, false);
		$q = $this->db->get('tr_payment_detail');
		$res = $q->result_array();
		$iLoop = 0;
		foreach ($res as $krow => $vrow) {
			foreach ($vrow as $kcol => $vcol) {
				$data['tr_payment_detail'][$iLoop][$kcol] = $kcol==='id' ? NULL : $vcol; 
			}
			$iLoop++;
		}
		$this->db->like('reserve_no', 'RSV-'.$this->session->userdata('kode_entity').'-');
		$q = $this->db->get('tr_ri_kpr_detail');
		$res = $q->result_array();
		$iLoop = 0;
		foreach ($res as $krow => $vrow) {
			foreach ($vrow as $kcol => $vcol) {
				$data['tr_ri_kpr_detail'][$iLoop][$kcol] = $kcol==='id' ? NULL : $vcol; 
			}
			$iLoop++;
		}
		$q = $this->db->get_where('mst_perijinan', array('kode_entity'=>$this->session->userdata('kode_entity')));
		$res = $q->result_array();
		$iLoop = 0;
		foreach ($res as $krow => $vrow) {
			foreach ($vrow as $kcol => $vcol) {
				$data['mst_perijinan'][$iLoop][$kcol] = $kcol==='id' ? NULL : $vcol; 
			}
			$iLoop++;
		}
		$q = $this->db->get('mst_progress_landed');
		$res = $q->result_array();
		$iLoop = 0;
		foreach ($res as $krow => $vrow) {
			foreach ($vrow as $kcol => $vcol) {
				$data['mst_progress_landed'][$iLoop][$kcol] = $kcol==='id' ? NULL : $vcol; 
			}
			$iLoop++;
		}
		$q = $this->db->get_where('tr_progress', array('kode_entity'=>$this->session->userdata('kode_entity')));
		$res = $q->result_array();
		$iLoop = 0;
		foreach ($res as $krow => $vrow) {
			foreach ($vrow as $kcol => $vcol) {
				$data['tr_progress'][$iLoop][$kcol] = $kcol==='id' ? NULL : $vcol; 
			}
			$iLoop++;
		}
		$data['kode_entity'] = $this->session->userdata('kode_entity');
		$data['sender'] = $this->session->userdata('usernm');
		return $data;
	}

}