<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Laporan_Model extends CI_Model {
			
		public function __construct() {
			// $this->load->database();
		}

		public function get_data_sku($field, $code) {
			$sql = "
				SELECT
					nsb.kode AS nsb_kode,
					nsb.nama AS nsb_nama,
					/*nsb.alamat_ktp*/ '' AS nsb_alamat,
					/*nsb.telp*/ '' AS nsb_telp,
					nsb.email AS nsb_email,
					nsb.tempat_lahir AS nsb_tempat_lahir,
					DATE_FORMAT(nsb.tgl_lahir,'%d/%m/%Y') AS nsb_tgl_lahir,
					nsb.hp AS nsb_hp,
					/*nsb.fax*/ '' AS nsb_fax,
					nsb.no_id AS nsb_noktp,
					/*nsb.alamat_domisili*/ '' AS nsb_domisili,
					nsb.nama_perusahaan AS nsb_nama_pt,
					nsb.alamat_perusahaan AS nsb_alamat_pt,
					nsb.kota_perusahaan AS nsb_kota_pt,
					nsb.kodepos_perusahaan AS nsb_kodepos_pt,
					nsb.telp_perusahaan AS nsb_telp_pt,
					nsb.fax_perusahaan AS nsb_fax_pt,
					nsb.jenis_pekerjaan AS nsb_jenis_job,
					nsb.status_pekerjaan AS nsb_status_job,
					nsb.lama_bekerja AS nsb_lama_kerja,
					nsb.jenis_usaha AS nsb_jenis_usaha,
					nsb.jabatan AS nsb_jabatan,
					nsb.pendapatan AS nsb_pendapatan,
					nsb.sumber_pendapatan_tambahan AS nsb_sumber_pendapatan_tambahan,
					nsb.pendapatan_tambahan AS nsb_pendapatan_tambahan,
					nsb.npwp AS nsb_npwp,
					stk.lantai_blok AS prod_blok,
					stk.kavling AS prod_kavling,
					stk.no_unit AS prod_nounit,
					stk.lantai_blok AS prod_unit,
					stk.type_unit AS prod_type,
					stk.wide_gross AS prod_luas_gross,
					stk.wide_netto AS prod_luas_netto,
					stk.type_kavling AS prod_kondisi,
					CASE pay.cara_bayar
						WHEN 'HARDCASH' THEN 'CASH KERAS'
						WHEN 'GRADCASH' THEN 'CASH BERTAHAP'
						WHEN 'KPRKPA' THEN 'KPR / KPA'
					END AS pay_cara_bayar,
					IFNULL(pay.harga_unit,0) AS tr_jual,
					paydet.pay_um AS pay_um,
					paydet.pay_reserve AS pay_reserve,
					DATE_FORMAT(paydet.pay_reserve_tgl,'%d/%m/%Y') AS pay_reserve_tgl,
					paydet.pay_jadi AS pay_jadi,
					DATE_FORMAT(paydet.pay_jadi_tgl,'%d/%m/%Y') AS pay_jadi_tgl,
					paydet.pay_kpr AS pay_kpr
				FROM
					mst_stock stk
					LEFT JOIN tr_payment pay ON stk.no_unit = pay.no_unit
					LEFT JOIN (
						SELECT
							paydet.reserve_no,
							IFNULL(SUM(CASE WHEN plan.kode_pay = 'RES' THEN paydet.rp ELSE 0 END), 0) AS pay_reserve,
							IFNULL(IF(plan.kode_pay = 'RES', paydet.tgl_tempo, NULL), '') AS pay_reserve_tgl,
							IFNULL(SUM(CASE WHEN plan.kode_pay = 'TJ' THEN paydet.rp ELSE 0 END), 0) AS pay_jadi,
							IFNULL(IF(plan.kode_pay = 'TJ', paydet.tgl_tempo, NULL), '') AS pay_jadi_tgl,
							IFNULL(SUM(CASE WHEN plan.tipe_pay = 'DOWNPAYMENT' THEN paydet.rp ELSE 0 END), 0) AS pay_um,
							IFNULL(SUM(CASE WHEN plan.tipe_pay = 'BANKLOAN' THEN paydet.rp ELSE 0 END), 0) AS pay_kpr
						FROM
							tr_payment_detail AS paydet
							INNER JOIN mst_payment_plan AS plan ON plan.kode_pay = paydet.kode_pay
						GROUP BY
							reserve_no
					) AS paydet ON paydet.reserve_no = pay.reserve_no
					LEFT JOIN mst_nasabah nsb ON pay.kode_nasabah = nsb.kode
				WHERE
					MD5($field) = '$code'
			";
			// echo $sql;
			$q = $this->db->query($sql);
			$res = $q->row_array();
			$data = array();
			foreach($res as $k => $v) {
				$data[$k] = $v;
			}
			// terbilang
			$this->load->library('strUtils'); 
			$strObj = new StrUtils();
			$data['terbilang'] = $strObj->terbilang($data['tr_jual']);
			return $data;
		}

		public function get_data_ksp($field, $code) {
			$sql = "
			SELECT
				nsb.kode AS nsb_kode,
				nsb.nama AS nsb_nama,
				/*nsb.alamat_ktp*/ '' AS nsb_alamat,
				/*nsb.telp*/ '' AS nsb_telp,
				nsb.email AS nsb_email,
				nsb.tempat_lahir AS nsb_tempat_lahir,
				DATE_FORMAT(nsb.tgl_lahir,'%d/%m/%Y') AS nsb_tgl_lahir,
				nsb.hp AS nsb_hp,
				/*nsb.fax*/ '' AS nsb_fax,
				nsb.no_id AS nsb_noktp,
				/*nsb.alamat_domisili*/ '' AS nsb_domisili,
				nsb.nama_perusahaan AS nsb_nama_pt,
				nsb.alamat_perusahaan AS nsb_alamat_pt,
				nsb.kota_perusahaan AS nsb_kota_pt,
				nsb.kodepos_perusahaan AS nsb_kodepos_pt,
				nsb.telp_perusahaan AS nsb_telp_pt,
				nsb.fax_perusahaan AS nsb_fax_pt,
				nsb.jenis_pekerjaan AS nsb_jenis_job,
				nsb.status_pekerjaan AS nsb_status_job,
				nsb.lama_bekerja AS nsb_lama_kerja,
				nsb.jenis_usaha AS nsb_jenis_usaha,
				nsb.jabatan AS nsb_jabatan,
				nsb.pendapatan AS nsb_pendapatan,
				nsb.sumber_pendapatan_tambahan AS nsb_sumber_pendapatan_tambahan,
				nsb.pendapatan_tambahan AS nsb_pendapatan_tambahan,
				nsb.npwp AS nsb_npwp,
				stk.lantai_blok AS prod_blok,
				stk.kavling AS prod_kavling,
				stk.no_unit AS prod_nounit,
				stk.lantai_blok AS prod_unit,
				stk.type_unit AS prod_type,
				stk.wide_gross AS prod_luas_gross,
				stk.wide_netto AS prod_luas_netto,
				stk.type_kavling AS prod_kondisi,
				CASE pay.cara_bayar
					WHEN 'HARDCASH' THEN 'CASH KERAS'
					WHEN 'GRADCASH' THEN 'CASH BERTAHAP'
					WHEN 'KPRKPA' THEN 'KPR / KPA'
				END AS pay_cara_bayar,
				pay.harga_unit AS tr_jual,
				paydet.pay_um AS pay_um,
				paydet.pay_reserve AS pay_reserve,
				DATE_FORMAT(paydet.pay_reserve_tgl,'%d/%m/%Y') AS pay_reserve_tgl,
				paydet.pay_jadi AS pay_jadi,
				DATE_FORMAT(paydet.pay_jadi_tgl,'%d/%m/%Y') AS pay_jadi_tgl,
				paydet.pay_kpr AS pay_kpr,
				ent.nama AS ent_nama
			FROM
				mst_stock stk
				LEFT JOIN tr_payment pay ON stk.no_unit = pay.no_unit
				LEFT JOIN (
					SELECT
						paydet.reserve_no,
						IFNULL(SUM(CASE WHEN plan.kode_pay = 'RES' THEN paydet.rp ELSE 0 END), 0) AS pay_reserve,
						IFNULL(IF(plan.kode_pay = 'RES', paydet.tgl_tempo, NULL), '') AS pay_reserve_tgl,
						IFNULL(SUM(CASE WHEN plan.kode_pay = 'TJ' THEN paydet.rp ELSE 0 END), 0) AS pay_jadi,
						IFNULL(IF(plan.kode_pay = 'TJ', paydet.tgl_tempo, NULL), '') AS pay_jadi_tgl,
						IFNULL(SUM(CASE WHEN plan.tipe_pay = 'DOWNPAYMENT' THEN paydet.rp ELSE 0 END), 0) AS pay_um,
						IFNULL(SUM(CASE WHEN plan.tipe_pay = 'BANKLOAN' THEN paydet.rp ELSE 0 END), 0) AS pay_kpr
					FROM
						tr_payment_detail AS paydet
						INNER JOIN mst_payment_plan AS plan ON plan.kode_pay = paydet.kode_pay
					GROUP BY
						reserve_no
				) AS paydet ON paydet.reserve_no = pay.reserve_no
				LEFT JOIN mst_nasabah nsb ON pay.kode_nasabah = nsb.kode
				INNER JOIN mst_entity ent ON ent.kode = stk.kode_entity
			WHERE
				MD5($field) = '$code'
		";
		$q = $this->db->query($sql);
		$res = $q->row_array();

		$data = array();
		foreach($res as $k => $v) {
			$data[$k] = $v;
		}
		// terbilang
		$this->load->library('strUtils'); 
		$strObj = new StrUtils();
		$data['terbilang'] = $strObj->terbilang($data['tr_jual']);
		return $data;
		}

		public function get_data_spu($field, $code) {
			$sql = "
				SELECT
					nsb.kode AS nsb_kode,
					nsb.nama AS nsb_nama,
					/*nsb.alamat_ktp*/ '' AS nsb_alamat,
					/*nsb.telp*/ '' AS nsb_telp,
					nsb.email AS nsb_email,
					nsb.tempat_lahir AS nsb_tempat_lahir,
					DATE_FORMAT(nsb.tgl_lahir,'%d/%m/%Y') AS nsb_tgl_lahir,
					nsb.hp AS nsb_hp,
					/*nsb.fax*/ '' AS nsb_fax,
					nsb.no_id AS nsb_noktp,
					/*nsb.alamat_domisili*/ '' AS nsb_domisili,
					nsb.nama_perusahaan AS nsb_nama_pt,
					nsb.alamat_perusahaan AS nsb_alamat_pt,
					nsb.kota_perusahaan AS nsb_kota_pt,
					nsb.kodepos_perusahaan AS nsb_kodepos_pt,
					nsb.telp_perusahaan AS nsb_telp_pt,
					nsb.fax_perusahaan AS nsb_fax_pt,
					nsb.jenis_pekerjaan AS nsb_jenis_job,
					nsb.status_pekerjaan AS nsb_status_job,
					nsb.lama_bekerja AS nsb_lama_kerja,
					nsb.jenis_usaha AS nsb_jenis_usaha,
					nsb.jabatan AS nsb_jabatan,
					nsb.pendapatan AS nsb_pendapatan,
					nsb.sumber_pendapatan_tambahan AS nsb_sumber_pendapatan_tambahan,
					nsb.pendapatan_tambahan AS nsb_pendapatan_tambahan,
					nsb.npwp AS nsb_npwp,
					stk.lantai_blok AS prod_blok,
					stk.kavling AS prod_kavling,
					stk.no_unit AS prod_nounit,
					stk.lantai_blok AS prod_unit,
					stk.type_unit AS prod_type,
					stk.wide_gross AS prod_luas_gross,
					stk.wide_netto AS prod_luas_netto,
					stk.type_kavling AS prod_kondisi,
					CASE pay.cara_bayar
						WHEN 'HARDCASH' THEN 'CASH KERAS'
						WHEN 'GRADCASH' THEN 'CASH BERTAHAP'
						WHEN 'KPRKPA' THEN 'KPR / KPA'
					END AS pay_cara_bayar,
					IFNULL(pay.harga_unit,0) AS tr_jual,
					paydet.pay_um AS pay_um,
					paydet.pay_reserve AS pay_reserve,
					DATE_FORMAT(paydet.pay_reserve_tgl,'%d/%m/%Y') AS pay_reserve_tgl,
					paydet.pay_jadi AS pay_jadi,
					DATE_FORMAT(paydet.pay_jadi_tgl,'%d/%m/%Y') AS pay_jadi_tgl,
					paydet.pay_kpr AS pay_kpr
				FROM
					mst_stock stk
					LEFT JOIN tr_payment pay ON stk.no_unit = pay.no_unit
					LEFT JOIN (
						SELECT
							paydet.reserve_no,
							IFNULL(SUM(CASE WHEN plan.kode_pay = 'RES' THEN paydet.rp ELSE 0 END), 0) AS pay_reserve,
							IFNULL(IF(plan.kode_pay = 'RES', paydet.tgl_tempo, NULL), '') AS pay_reserve_tgl,
							IFNULL(SUM(CASE WHEN plan.kode_pay = 'TJ' THEN paydet.rp ELSE 0 END), 0) AS pay_jadi,
							IFNULL(IF(plan.kode_pay = 'TJ', paydet.tgl_tempo, NULL), '') AS pay_jadi_tgl,
							IFNULL(SUM(CASE WHEN plan.tipe_pay = 'DOWNPAYMENT' THEN paydet.rp ELSE 0 END), 0) AS pay_um,
							IFNULL(SUM(CASE WHEN plan.tipe_pay = 'BANKLOAN' THEN paydet.rp ELSE 0 END), 0) AS pay_kpr
						FROM
							tr_payment_detail AS paydet
							INNER JOIN mst_payment_plan AS plan ON plan.kode_pay = paydet.kode_pay
						GROUP BY
							reserve_no
					) AS paydet ON paydet.reserve_no = pay.reserve_no
					LEFT JOIN mst_nasabah nsb ON pay.kode_nasabah = nsb.kode
				WHERE
					MD5($field) = '$code'
			";
			// echo $sql;
			$q = $this->db->query($sql);
			$res = $q->row_array();
			$data = array();
			foreach($res as $k => $v) {
				$data[$k] = $v;
			}
			// terbilang
			$this->load->library('strUtils'); 
			$strObj = new StrUtils();
			$data['terbilang'] = $strObj->terbilang($data['tr_jual']);
			return $data;
		}

		public function get_data_kartunasabah($field, $code) {
			$sql = "
					SELECT
						nsb.kode AS nsb_kode,
						nsb.nama AS nsb_nama,
						'' AS nsb_alamat,
						'' AS nsb_telp,
						stk.no_unit AS prod_nounit,
						CONCAT(stk.lantai_blok,' / No. ',stk.no_unit) AS prod_unit,
						stk.wide_gross AS prod_luas_gross,
						stk.wide_netto AS prod_luas_netto,
						IFNULL(pay.harga_unit,0) AS tr_jual,
						pay.reserve_no
					FROM
						mst_stock stk
						LEFT JOIN tr_payment pay ON stk.no_unit = pay.no_unit
						LEFT JOIN mst_nasabah nsb ON pay.kode_nasabah = nsb.kode
					WHERE
						MD5($field) = '$code'
				";
				$q = $this->db->query($sql);
				$res = $q->row_array();
				$data = array();
				foreach($res as $k => $v) {
					$data[$k] = $v;
				}
				
				$sql = "
					SELECT
						* 
					FROM (
						SELECT
							nama,
							DATE_FORMAT(tgl_tempo, '%d/%m/%Y') AS xtgl_tempo,
							rp AS rp_ra,
							'' AS xtgl_bayar,
							'' AS no_kwitansi,
							'' AS rp_ri,
							hari_denda,
							rp_denda,
							no_urut
						FROM
							tr_payment_detail
						WHERE
							reserve_no = '".@$data['reserve_no']."'
							AND tgl_bayar IS NULL
						UNION ALL
						SELECT
							'' AS nama,
							'' AS xtgl_tempo,
							'' AS rp_ra,
							DATE_FORMAT(tgl_bayar, '%d/%m/%Y') AS xtgl_bayar,
							no_kwitansi,
							rp AS rp_ri,
							hari_denda,
							rp_denda,
							no_urut
						FROM
							tr_payment_detail
						WHERE
							reserve_no = '".@$data['reserve_no']."'
							AND tgl_bayar IS NOT NULL
					) AS tbl
					ORDER BY
						no_urut
				";
				$q = $this->db->query($sql);
				$res = $q->result_array();
				foreach($res as $k => $v) {
					foreach($v as $k2 => $v2) {
						$data['payment'][$k][$k2] = $v2;
					}
				}
				return $data;
		}

}

?>