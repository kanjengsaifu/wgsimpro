<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tr_ri_kpr_model extends CI_Model {
	
	public function get_tr($reserve_no) {
		$this->db->select('pay.kode_nasabah, nsb.nama AS nasabah, pay.no_unit, pay.harga_unit, pay.reserve_no, pay.kode_bank, bank.nama AS bank,'.
				'pf.rp AS plafond')
			->from('tr_payment pay')
			->join('mst_nasabah nsb', 'nsb.kode = pay.kode_nasabah', 'inner')
			->join('mst_bank bank', 'bank.kode = pay.kode_bank', 'left')
			->join('mst_bank_plafond pf', 'pf.reserve_no = pay.reserve_no AND pf.kode_bank = pay.kode_bank', 'inner')
			->where(array('pay.reserve_no'=>$reserve_no));
		$q = $this->db->get();
		$data = $q->row_array();
		$this->db->select('alok.*, IFNULL(FORMAT(ridet.rp,2),"") AS rp, IFNULL(DATE_FORMAT(ridet.tanggal,"%d/%m/%Y"),"") AS tanggal', FALSE)
			->from('mst_bank_alokasi alok')
			->join('mst_bank_plafond pf', 'pf.kode_bank = alok.kode_bank', 'inner')
			->join('tr_ri_kpr_detail ridet', 'ridet.reserve_no = pf.reserve_no AND ridet.reserve_no = pf.reserve_no AND '.
				'ridet.persentase = alok.persentase AND ridet.keterangan = alok.keterangan', 'left')
			->where(array('pf.reserve_no'=>$reserve_no, 'alok.kode_entity'=>$this->session->userdata('kode_entity')))
			->order_by('alok.keterangan');
		$q = $this->db->get();
		$data['alokasi'] = $q->result_array();
		// terbilang
		$this->load->library('strUtils'); 
		$strObj = new StrUtils();
		$data['terbilang'] = $strObj->terbilang($data['harga_unit']);
		// format
		$data['harga_unit'] = number_format($data['harga_unit'],2);
		$data['plafond'] = number_format($data['plafond'],2);
		return $data;
	}

	public function _insert($data) {
		$this->db->insert('tr_ri_kpr_detail', $data);
		$this->db->select('*')
			->from('tr_payment_detail')
			->where('reserve_no = "'.$data['reserve_no'].'" AND kode_pay LIKE "%KPR%" AND tgl_bayar IS NULL');
		$q = $this->db->get();
		$res = $q->row_array();
		$rikpr = array(
			'reserve_no'=>$res['reserve_no'],
			'kode_pay'=>$res['kode_pay'],
			'nama'=>$res['nama'],
			'persentase'=>$res['persentase'],
			'rp'=>$data['rp'],
			'tgl_bayar'=>$data['tanggal'],
			'tgl_tempo'=>null,
			'no_kwitansi'=>'',
			'no_urut'=>$res['no_urut']
		);
		$this->db->insert('tr_payment_detail', $rikpr);
	}
		
}
	
