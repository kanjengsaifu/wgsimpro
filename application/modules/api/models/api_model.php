<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api_model extends CI_Model {

	public function do_backup_sales($kode_entity) {
		$data = array();
		$q = $this->db->get('mst_optional_stock');
		$res = $q->result_array();
		$iLoop = 0;
		foreach ($res as $krow => $vrow) {
			foreach ($vrow as $kcol => $vcol) {
				$data['mst_optional_stock'][$iLoop][$kcol] = $kcol==='id' ? NULL : $vcol; 
			}
			$iLoop++;
		}
		$q = $this->db->get_where('mst_stock', array('kode_entity'=>$kode_entity));
		$res = $q->result_array();
		$iLoop = 0;
		foreach ($res as $krow => $vrow) {
			foreach ($vrow as $kcol => $vcol) {
				$data['mst_stock'][$iLoop][$kcol] = $kcol==='id' ? NULL : $vcol; 
			}
			$iLoop++;
		}
		$q = $this->db->get('mst_payment_plan');
		$res = $q->result_array();
		$iLoop = 0;
		foreach ($res as $krow => $vrow) {
			foreach ($vrow as $kcol => $vcol) {
				$data['mst_payment_plan'][$iLoop][$kcol] = $kcol==='id' ? NULL : $vcol; 
			}
			$iLoop++;
		}
		$q = $this->db->get('mst_payment_plan_detail');
		$res = $q->result_array();
		$iLoop = 0;
		foreach ($res as $krow => $vrow) {
			foreach ($vrow as $kcol => $vcol) {
				$data['mst_payment_plan_detail'][$iLoop][$kcol] = $kcol==='id' ? NULL : $vcol; 
			}
			$iLoop++;
		}
		$q = $this->db->get('mst_optional_unit_price');
		$res = $q->result_array();
		$iLoop = 0;
		foreach ($res as $krow => $vrow) {
			foreach ($vrow as $kcol => $vcol) {
				$data['mst_optional_unit_price'][$iLoop][$kcol] = $kcol==='id' ? NULL : $vcol; 
			}
			$iLoop++;
		}
		$q = $this->db->get_where('mst_unit_price', array('kode_entity'=>$kode_entity));
		$res = $q->result_array();
		$iLoop = 0;
		foreach ($res as $krow => $vrow) {
			foreach ($vrow as $kcol => $vcol) {
				$data['mst_unit_price'][$iLoop][$kcol] = $kcol==='id' ? NULL : $vcol; 
			}
			$iLoop++;
		}
		$q = $this->db->get_where('mst_bank', array('kode_entity'=>$kode_entity));
		$res = $q->result_array();
		$iLoop = 0;
		foreach ($res as $krow => $vrow) {
			foreach ($vrow as $kcol => $vcol) {
				$data['mst_bank'][$iLoop][$kcol] = $kcol==='id' ? NULL : $vcol; 
			}
			$iLoop++;
		}
		$q = $this->db->get('mst_diskon');
		$res = $q->result_array();
		$iLoop = 0;
		foreach ($res as $krow => $vrow) {
			foreach ($vrow as $kcol => $vcol) {
				$data['mst_diskon'][$iLoop][$kcol] = $kcol==='id' ? NULL : $vcol; 
			}
			$iLoop++;
		}
		$q = $this->db->get('mst_optional_dokumen');
		$res = $q->result_array();
		$iLoop = 0;
		foreach ($res as $krow => $vrow) {
			foreach ($vrow as $kcol => $vcol) {
				$data['mst_optional_dokumen'][$iLoop][$kcol] = $kcol==='id' ? NULL : $vcol; 
			}
			$iLoop++;
		}
		$q = $this->db->get('mst_sales');
		$res = $q->result_array();
		$iLoop = 0;
		foreach ($res as $krow => $vrow) {
			foreach ($vrow as $kcol => $vcol) {
				$data['mst_sales'][$iLoop][$kcol] = $kcol==='id' ? NULL : $vcol; 
			}
			$iLoop++;
		}
		$q = $this->db->get_where('tr_payment', array('kode_entity'=>$kode_entity));
		$res = $q->result_array();
		$iLoop = 0;
		foreach ($res as $krow => $vrow) {
			foreach ($vrow as $kcol => $vcol) {
				$data['tr_payment'][$iLoop][$kcol] = $kcol==='id' ? NULL : $vcol; 
			}
			$iLoop++;
		}
		$this->db->select('paydet.*')
			->from('tr_payment_detail AS paydet')
			->join('tr_payment AS pay', 'pay.reserve_no = paydet.reserve_no AND paydet.tgl_bayar IS NULL AND pay.kode_entity = "'.$kode_entity.'"', 'inner');
		$q = $this->db->get();
		$res = $q->result_array();
		$iLoop = 0;
		foreach ($res as $krow => $vrow) {
			foreach ($vrow as $kcol => $vcol) {
				$data['tr_payment_detail'][$iLoop][$kcol] = $kcol==='id' ? NULL : $vcol; 
			}
			$iLoop++;
		}
		$this->db->select('n.*')
			->from('mst_nasabah AS n')
			->join('tr_payment AS pay', 'pay.kode_nasabah = n.kode AND pay.kode_entity = "'.$kode_entity.'"', 'inner');
		$q = $this->db->get();
		$res = $q->result_array();
		$iLoop = 0;
		foreach ($res as $krow => $vrow) {
			foreach ($vrow as $kcol => $vcol) {
				$data['mst_nasabah'][$iLoop][$kcol] = $kcol==='id' ? NULL : $vcol; 
			}
			$iLoop++;
		}
		$this->db->select('na.*')
			->from('mst_nasabah_alamat AS na')
			->join('tr_payment AS pay', 'pay.kode_nasabah = na.kode_nasabah AND pay.kode_entity = "'.$kode_entity.'"','inner');
		$q = $this->db->get();
		$res = $q->result_array();
		$iLoop = 0;
		foreach ($res as $krow => $vrow) {
			foreach ($vrow as $kcol => $vcol) {
				$data['mst_nasabah_alamat'][$iLoop][$kcol] = $kcol==='id' ? NULL : $vcol; 
			}
			$iLoop++;
		}
		return $data;
	}

	public function do_sinkron_trx() {
		$json = json_decode($this->input->post('data'));
		$this->db->trans_start(TRUE);
		$sinkron = array(
			'job_code'=>'SINKRON_TRX',
			'kode_entity'=>$json->kode_entity,
			'source'=>$json->kode_entity,
			'destination'=>'http://ris.wikarealty.co.id',
			'json'=>$this->input->post('data'),
			'actor'=>$json->sender,
			'job_time'=>date('Y-m-d H:i:s')
		);
		$this->db->insert('tr_sinkron', $sinkron);
		$sinkron_id = $this->db->insert_id();
		$pref = array(
			'tables'=>array(
				'mst_bank_alokasi', 'mst_bank_plafond', 'tr_payment_detail', 'tr_ri_kpr_detail',
				'mst_perijinan', 'mst_progress_landed', 'tr_progress'
			),
			'format'=>'txt',
			'filename'=>'sinkron_trx_'.$sinkron_id.'.sql',
			'add_drop'=>TRUE,
			'add_insert'=>TRUE,
			'newline'=>"\n"
		);
		$this->load->dbutil();
		$backup = $this->dbutil->backup($pref);
		$this->load->helper('file');
		write_file(FCPATH.'sinkron_trx_'.$sinkron_id.'.sql', $backup);
		if(isset($json->mst_bank_alokasi)) {
			$this->db->where(array('kode_entity'=>$json->kode_entity));
			$this->db->delete('mst_bank_alokasi');
			foreach ($json->mst_bank_alokasi as $k => $v) {
				$this->db->insert('mst_bank_alokasi', $v);
			}
		}
		if(isset($json->mst_bank_plafond)) {
			$this->db->like('reserve_no', 'RSV-'.$json->kode_entity.'-');
			$this->db->delete('mst_bank_plafond');
			foreach ($json->mst_bank_plafond as $k => $v) {
				$this->db->insert('mst_bank_plafond', $v);
			}
		}
		if(isset($json->tr_payment_detail)) {
			$this->db->like('reserve_no', 'RSV-'.$json->kode_entity.'-');
				// ->where('tgl_bayar IS NULL', NULL, FALSE);
			$this->db->delete('tr_payment_detail');
			foreach ($json->tr_payment_detail as $k => $v) {
				$this->db->insert('tr_payment_detail', $v);
			}
		}
		if(isset($json->mst_perijinan)) {
			$this->db->where(array('kode_entity'=>$json->kode_entity));
			$this->db->delete('mst_perijinan');
			foreach ($json->mst_perijinan as $k => $v) {
				$this->db->insert('mst_perijinan', $v);
			}
		}
		if(isset($json->mst_progress_landed)) {
			$this->db->query('TRUNCATE mst_progress_landed');
			foreach ($json->mst_progress_landed as $k => $v) {
				$this->db->insert('mst_progress_landed', $v);
			}
		}
		if(isset($json->tr_progress)) {
			$this->db->where(array('kode_entity'=>$json->kode_entity));
			$this->db->delete('tr_progress');
			foreach ($json->tr_progress as $k => $v) {
				$this->db->insert('tr_progresss', $v);
			}
		}
		$this->db->trans_complete();
		return '1';
	}

}