<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mst_bank_model extends CI_Model {
		
	public function __construct() {
		// $this->load->database();
	}
	
	public function get($id = FALSE, $filter = FALSE) { 
		if($id==FALSE) {
			$q = $this->db->get('mst_bank');
			return $q->result_array();
		} else {
			$q = $this->db->get_where('mst_bank', array('id'=>$id));
			return $q->row_array();
		}
	}
	
	public function getAccounting($id = FALSE, $filter = FALSE) { 
		if($id==FALSE) {
			$q = $this->db->get('mst_bank_accounting');
			return $q->result_array();
		} else {
			$q = $this->db->get_where('mst_bank_accounting', array('id'=>$id));
			return $q->row_array();
		}
	}

	public function get_alokasi($kode) {
		$this->db->select('a.id, b.kode, b.nama, b.no_rekening, /*a.kode_entity,*/ IFNULL(a.persentase,"") AS persentase, IFNULL(a.keterangan, "") AS keterangan, CASE WHEN tgl_akad_kredit>0 THEN "Akad Kredit" ELSE CASE WHEN progress>0 THEN CONCAT("Progress: ",progress,"%") ELSE CASE WHEN perijinan<>"" THEN CONCAT("Dokumen: ",dok.konten) END END END AS indikator', FALSE)
			->from('mst_bank b')
			->join('mst_bank_alokasi a', 'a.kode_bank = b.kode AND a.kode_entity = "'.$this->session->userdata('kode_entity').'"', 'left')
            ->join('mst_optional_dokumen dok', 'a.perijinan = dok.kode', 'left')
			->where(array('b.kode'=>$kode));
		$q = $this->db->get();
		//print_r($q);
		$res = $q->result_array();
		$data = array(
			'kode'=>$res[0]['kode'],
			'nama'=>$res[0]['nama'],
			'no_rekening'=>$res[0]['no_rekening'],
//			'kode_entity'=>$res[0]['kode_entity'],
		);
		foreach ($res as $k => $v) {
			$data['items'][] = $v;
		}
		return $data;
	}

	public function get_plafond($resno) {
		$this->db->select('pay.reserve_no, nsb.nama AS nasabah, pay.no_unit, pay.harga_unit, pay.kode_bank, '.
				'IFNULL(pf.rp, paydet.rp) AS rp_kpr, IFNULL(DATE_FORMAT(pay.tgl_akad,"%d/%m/%Y"),"") AS tgl_akad', FALSE)
			->from('tr_payment pay')
			->join('mst_nasabah nsb', 'nsb.kode = pay.kode_nasabah', 'inner')
			->join('mst_bank_plafond pf', 'pf.reserve_no = pay.reserve_no', 'left')
			->join('tr_payment_detail paydet', 'paydet.reserve_no = pay.reserve_no AND paydet.kode_pay LIKE "%KPR%"', 'inner')
			->where(array('pay.reserve_no'=>$resno));
		$q = $this->db->get();
		$data = $q->row_array();
		//terbilang
		$this->load->library('strUtils'); 
		$strObj = new StrUtils();
		$data['terbilang'] = $strObj->terbilang($data['harga_unit']);
		$data['harga_unit'] = number_format($data['harga_unit'],2);
		// alokasi bank
		$q = $this->db->get_where('mst_bank_alokasi', array('kode_bank'=>$data['kode_bank']));
		$data['alokasi'] = $q->result_array();
		return $data;
	}

	public function get_dokumen() {
        $this->db->select('kode, konten')
            ->from('mst_optional_dokumen')
            ->where(array('sfield'=>'jenis_dokumen', 'isactive'=>1))
            ->order_by('no_urut');
        $q = $this->db->get();
        $data['dokumen'] = $q->result_array();
        return $data;
    }
	
	public function get_optional_alokasi() {
		// entity
		$this->db->select('kode, nama, CASE WHEN kode="'.$this->session->userdata('kode_entity').'" THEN 0 ELSE 1 END AS urut', FALSE)
			->from('mst_entity')
			->order_by('urut');
		$q = $this->db->get();
		$data['entity'] = $q->result_array();
		// dokumen
		$this->db->select('kode, konten')
		    ->from('mst_optional_dokumen')
		    ->where(array('sfield'=>'jenis_dokumen', 'isactive'=>1))
		    ->order_by('no_urut');
		$q = $this->db->get();
		$data['dokumen'] = $q->result_array();
		return $data;
	}
    
	public function get_bank_kpr() {
		$q = $this->db->get_where('mst_bank', array('iskpr'=>1));
		$data['bankkpr'] = $q->result_array();
		return $data;
	}
	
	public function _insert($data) {
		return $this->db->insert('mst_bank',$data);
	}

	public function _insertAccounting($data) {
		return $this->db->insert('mst_bank_accounting',$data);
	}

	public function _insert_alokasi($data) {
        $q = $this->db->get_where('mst_bank_alokasi', array('keterangan'=>$data['keterangan']));
        if($data['id']=='') {
            return $this->db->insert('mst_bank_alokasi', $data);
        } else {
            $this->db->where(array('id'=>$data['id']));
            return $this->db->update('mst_bank_alokasi', $data);
        }
//		return $this->db->insert('mst_bank_alokasi', $data);
	}

	public function _insert_plafond($data) {
		// ra plafond
		$this->db->where('reserve_no = "'.$data['reserve_no'].'" AND kode_pay LIKE "%KPR%"');
		$q = $this->db->get('tr_payment_detail');
		$resRa = $q->row_array();
		// plafond
		$flafondData = array(
			'reserve_no'=>$data['reserve_no'],
			'kode_bank'=>$data['kode_bank'],
			'rp'=>$data['rp'],
			'tgl_disetujui'=>$data['tgl_disetujui'],
			'no_persetujuan_kredit'=>$data['no_persetujuan_kredit']
		);
		$q = $this->db->get_where('mst_bank_plafond', array('reserve_no'=>$data['reserve_no']));
		if($q->num_rows()>0) {
			$this->db->where(array('reserve_no'=>$data['reserve_no']));
			$this->db->update('mst_bank_plafond', $flafondData);
		} else {
			$this->db->insert('mst_bank_plafond', $flafondData);
		}
		// update trx payment (bank)
		$paymentData = array(
			'kode_bank'=>$data['kode_bank'],
			'tgl_akad'=>$data['tgl_ri_akad'],
			'tgl_ri_akad'=>$data['tgl_ri_akad']
		);
		$this->db->where(array('reserve_no'=>$data['reserve_no']));
		$this->db->update('tr_payment', $paymentData);
		// if diff on Ra & Ri
		if($resRa['rp']-$data['rp']>0) {
			// delete item (if exist)
			$q = $this->db->get_where('tr_payment_detail', 'reserve_no = "'.$data['reserve_no'].'" AND '.
				'kode_pay LIKE "%KPR%" AND tgl_bayar IS NULL');
			$resItem = $q->row_array();
			$this->db->where('reserve_no = "'.$data['reserve_no'].'" AND '.
				'no_urut > '.$resItem['no_urut']);
			$this->db->delete('tr_payment_detail');
			// update rp ra KPR
			$this->db->where(array('id'=>$resItem['id']));
			$this->db->update('tr_payment_detail', array('rp'=>$data['rp']));
			// insert ri kpr
			// $riKPRData = $resItem;
			// $riKPRData['id'] = null;
			// $riKPRData['rp'] = $data['rp'];
			// $riKPRData['tgl_bayar'] = $data['tgl_disetujui'];
			// $riKPRData['tgl_tempo'] = null;
			// $riKPRData['no_urut']++;
			// $this->db->insert('tr_payment_detail', $riKPRData);
			// insert as new item
			$this->db->query("
				INSERT INTO
					tr_payment_detail (reserve_no, kode_pay, nama, persentase, rp, tgl_tempo, no_urut, flag)
				SELECT
					'".$data['reserve_no']."',
					kode_pay,
					nama,
					persentase,
					".($resRa['rp']-$data['rp']).",
					DATE_ADD(tgl_tempo, INTERVAL 1 MONTH),
					(SELECT IFNULL(COUNT(*),0)+1 FROM tr_payment_detail WHERE reserve_no = '".$data['reserve_no']."'),
					flag
				FROM
					tr_payment_detail
				WHERE
					reserve_no = '".$data['reserve_no']."'
					AND kode_pay LIKE '%UM%'
					AND tgl_bayar IS NULL
				ORDER BY
					no_urut DESC
				LIMIT 1
			");
			$out['msg'] = "(Tersimpan) Plafond yang disetujui bank: Rp. ".number_format($data['rp'],2).
				"\nSelisih ".number_format(($resRa['rp']-$data['rp']),2)." tersimpan sebagai tambahan Uang Muka.";
		} else {
			$out['msg'] = '(Tersimpan) Plafond yang disetujui bank: Rp. '.number_format($data['rp'],2);
		}
		$out['status'] = '200';
		return $out;
	}
	
	public function _update($data,$id) {
		$this->db->where(array('id'=>$id));
		return $this->db->update('mst_bank',$data);
	}
	
	public function _updateAccounting($data,$id) {
		$this->db->where(array('id'=>$id));
		return $this->db->update('mst_bank_accounting',$data);
	}
	
	public function _delete($id) {
		$this->db->where(array('id'=>$id));
		return $this->db->delete('mst_bank');
	}
    
    public function _delete_alokasi($id) {
        $this->db->where(array('id'=>$id));
        return $this->db->delete('mst_bank_alokasi');
    }
		
}
	
