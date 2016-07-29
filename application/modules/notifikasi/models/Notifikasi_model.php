<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notifikasi_Model extends CI_Model {
	
	public function getDataGroup(){
		$sql = "SELECT 
					a.id, a.reserve_no, a.no_unit, a.transaksi as jenis_trx, SUM(a.rupiah) as rp_ra, 
					SUM(a.rupiah_realisasi) as rp_ri, a.tgl_tempo, datediff(current_date(), tgl_tempo) as hari_h, 
					b.kode_nasabah, a.nama_nasabah, a.no_hp, 
					a.alamat_email, d.alamat, d.kota, d.kodepos, e.nama as nama_kawasan, 
					e.alamat_marketing as alamat_kawasan, e.norek_entity as norek_kawasan, e.no_telp as telp_kawasan, 
					e.email as email_kawasan
				FROM tr_alert a 
				LEFT JOIN tr_payment b ON b.reserve_no = a.reserve_no
				LEFT JOIN mst_nasabah c ON c.kode = b.kode_nasabah
				LEFT JOIN mst_nasabah_alamat d ON d.kode_nasabah = c.kode
				LEFT JOIN mst_entity e ON e.kode = b.kode_entity
				GROUP BY a.reserve_no ASC
				";
		$query = $this->db->query($sql);
		$res = $query->result_array();
		$data = array();
		foreach($res as $row => $v){
			$data[] = array(
					'id'=>$v['id'],
					'reserve_no'=>$v['reserve_no'],
					'no_unit'=>$v['no_unit'],
					'jenis_trx'=>$v['jenis_trx'],
					'rp_ra'=>$v['rp_ra'],
					'rp_ri'=>$v['rp_ri'],
					'tgl_tempo'=>$v['tgl_tempo'],
					'hari_h'=>$v['hari_h'],
					'kode_nasabah'=>$v['kode_nasabah'],
					'nama_nasabah'=>$v['nama_nasabah'],
					'alamat_email'=>$v['alamat_email'],
					'no_hp'=>$v['no_hp']
					);
		}
		/*
		return $this->output
			    ->set_content_type('application/json')
			    ->set_output(json_encode($data));
			    */
		return json_encode($data);
	}

	public function getDataDetail($reserve_no){
		
		$sql = "SELECT 
					a.id, a.reserve_no, a.no_unit, a.transaksi as jenis_trx, a.rupiah as rp_ra, 
					a.rupiah_realisasi as rp_ri, a.tgl_tempo, datediff(current_date(), tgl_tempo) as hari_h, 
					b.kode_nasabah, a.nama_nasabah, a.no_hp, 
					a.alamat_email, d.alamat, d.kota, d.kodepos, e.nama as nama_kawasan, 
					e.alamat_marketing as alamat_kawasan, e.norek_entity as norek_kawasan, e.no_telp as telp_kawasan, 
					e.email as email_kawasan
				FROM tr_alert a 
				LEFT JOIN tr_payment b ON b.reserve_no = a.reserve_no
				LEFT JOIN mst_nasabah c ON c.kode = b.kode_nasabah
				LEFT JOIN mst_nasabah_alamat d ON d.kode_nasabah = c.kode
				LEFT JOIN mst_entity e ON e.kode = b.kode_entity
				WHERE a.reserve_no = '".$reserve_no."'
				";
		$query = $this->db->query($sql);
		$res = $query->result_array();

		$data = array();
		foreach($res as $row => $v){
			$data[] = array(
					'id'=>$v['id'],
					'reserve_no'=>$v['reserve_no'],
					'no_unit'=>$v['no_unit'],
					'jenis_trx'=>$v['jenis_trx'],
					'rp_ra'=>$v['rp_ra'],
					'rp_ri'=>$v['rp_ri'],
					'tgl_tempo'=>$v['tgl_tempo'],
					'hari_h'=>$v['hari_h'],
					'kode_nasabah'=>$v['kode_nasabah'],
					'nama_nasabah'=>$v['nama_nasabah'],
					'alamat_email'=>$v['alamat_email'],
					'no_hp'=>$v['no_hp']
					);
		}
		/*
		return $this->output
			    ->set_content_type('application/json')
			    ->set_output(json_encode($data));
			    */
		return json_encode($data);
	}
}