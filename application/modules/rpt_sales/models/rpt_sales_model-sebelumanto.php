<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rpt_sales_model extends CI_Model {
		
	public function __construct() {
		// $this->load->database();
	}

	function gen_konfirmasi_unit($field, $code) {
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
		$data['terbilang'] = $strObj->rp_terbilang($data['tr_jual']);
		return $data;
	}

	function gen_surat_pesanan($field, $code) {
		$sql = "
			SELECT
				nsb.kode AS nsb_kode,
				nsb.nama AS nsb_nama,
				'' AS nsb_alamat,
				'' AS nsb_telp,
				nsb.email AS nsb_email,
				nsb.tempat_lahir AS nsb_tempat_lahir,
				DATE_FORMAT(nsb.tgl_lahir,'%d/%m/%Y') AS nsb_tgl_lahir,
				nsb.hp AS nsb_hp,
				'' AS nsb_fax,
				nsb.no_id AS nsb_noktp,
				'' AS nsb_domisili,
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
				stk.land_wid AS luas_tanah,
        		stk.land_len as luas_bangunan,
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
				pay.kode_bank,
				mbank.nama as nama_bank,
				pay.harga_unit AS tr_jual,
				paydet.pay_um AS pay_um,
				paydet.pay_reserve AS pay_reserve,
				DATE_FORMAT(paydet.pay_reserve_tgl,'%d/%m/%Y') AS pay_reserve_tgl,
				paydet.pay_jadi AS pay_jadi,
				DATE_FORMAT(paydet.pay_jadi_tgl,'%d/%m/%Y') AS pay_jadi_tgl,
				paydet.pay_kpr AS pay_kpr,
				ent.nama AS ent_nama,
				CASE mentity.type_entity
					WHEN 'HR' THEN
						'HIGHRISE'
					WHEN 'LD' THEN
						'LANDED'
					END AS type_entity,
				pay.reserve_no
			FROM
				mst_stock stk
				LEFT JOIN tr_payment pay ON stk.no_unit = pay.no_unit
				LEFT JOIN mst_bank mbank ON mbank.kode = pay.kode_bank
				LEFT JOIN mst_entity mentity ON mentity.kode = stk.kode_entity
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
				nsb.kode IS NOT NULL 
			AND 
				MD5($field) = '$code'
		";
		$q = $this->db->query($sql);
		$res = $q->row_array();
		$data = array();
		foreach($res as $k => $v) {
			$data[$k] = $v;
		}

		$reserve_no = $res['reserve_no'];
		//uang muka
		$sql = "
				SELECT DISTINCT
					MIN(id) AS idpay,
					kode_pay,
					nama,
					no_urut,
					SUM(CASE WHEN tgl_bayar IS NULL THEN rp ELSE (rp*-1) END) rp
				FROM
					tr_payment_detail
				WHERE
					reserve_no = '$reserve_no'
					AND kode_pay NOT IN (
						SELECT
							kode_pay
						FROM
							mst_payment_plan
						WHERE
							tipe_pay = 'BANKLOAN'
					)
				GROUP BY
					kode_pay,
					no_urut
				HAVING
					rp > 0
				ORDER BY
					no_urut
			";
			$qpay = $this->db->query($sql);
			$data['pays'] = $qpay->result_array();
			
			$sql = "
				SELECT
					kode_pay,
					nama,
					IFNULL(DATE_FORMAT(tgl_tempo,'%d/%m/%Y'), '') AS tgl_tempo,
					SUM(rp) AS ra_rp,
					'' AS tgl_bayar,
					'' AS no_kwitansi,
					'' AS ri_rp,
					'' AS hari_denda,
					'' AS rp_denda,
					no_urut
				FROM
					tr_payment_detail
				WHERE
					reserve_no = '$reserve_no'
					AND tgl_bayar IS NULL
				GROUP BY
					kode_pay,
					no_urut
				ORDER BY
					tgl_bayar,
					kode_pay,
					no_urut";
			$qpay = $this->db->query($sql);
			$data['angsurans'] = $qpay->result_array();
			
		// terbilang
		$this->load->library('strUtils'); 
		$strObj = new StrUtils();
		$data['terbilang'] = $strObj->rp_terbilang($data['tr_jual']);
		//var_dump($data); die;
		return $data;
		
	}

	function gen_kartu_nasabah($field, $code) {
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
				pay.reserve_no,
				pay.kode_pay
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

		// unit price
		$sql = "
			SELECT
				opsi.konten,
				pr.rp
			FROM
				mst_unit_price AS pr
			INNER JOIN mst_optional_unit_price AS opsi ON opsi.kode = pr.type_price
			AND opsi.sfield = 'type_price'
			AND opsi.sflag = '".$this->session->userdata('type_entity')."'
			WHERE
				pr.kode_entity = '".$this->session->userdata('kode_entity')."'
			AND pr.no_unit = '".@$data['prod_nounit']."'
			AND pr.kode_pay = '".@$data['kode_pay']."'
			ORDER BY
				opsi.no_urut ASC
		";
		$q = $this->db->query($sql);
		$res = $q->result_array();
		foreach ($res as $k => $v) {
			$data['unit_price'][] = $v;
		}
		// ra ri payment
		$sql = "
			SELECT
				ra_payment.kode_pay,
				ra_payment.tipe_pay,
				ra_payment.nama,
				ra_payment.tgl AS tgl_tempo,
				ra_payment.rp AS rp_ra,
				IFNULL(ri_payment.tgl,'') AS tgl_bayar,
				IFNULL(ri_payment.rp,'') AS rp_ri,
				IFNULL(ri_payment.no_kwitansi,'') AS no_kwitansi,
				IFNULL(ri_payment.hari_denda,'') AS hari_denda,
				IFNULL(ri_payment.rp_denda,'') AS rp_denda
			FROM
				(
					SELECT
						paydet.kode_pay,
						plan.tipe_pay,
						paydet.nama,
						paydet.rp,
						DATE_FORMAT(paydet.tgl_tempo, '%d/%m/%Y') AS tgl,
						'' AS no_kwitansi,
						paydet.no_urut
					FROM
						tr_payment_detail paydet
						INNER JOIN mst_payment_plan plan ON plan.kode_pay = paydet.kode_pay
					WHERE
						paydet.reserve_no = '".@$data['reserve_no']."'
						AND paydet.tgl_bayar IS NULL
				) AS ra_payment
				LEFT JOIN (
					SELECT
						nama,
						rp,
						DATE_FORMAT(tgl_bayar, '%d/%m/%Y') AS tgl,
						no_kwitansi,
						hari_denda,
						rp_denda,
						no_urut
					FROM
						tr_payment_detail
					WHERE
						reserve_no = '".@$data['reserve_no']."'
						AND tgl_bayar IS NOT NULL
				) AS ri_payment ON ri_payment.nama = ra_payment.nama
			ORDER BY
				ra_payment.no_urut,
				ri_payment.tgl
		";
		$q = $this->db->query($sql);
		$res = $q->result_array();
		foreach($res as $k => $v) {
			foreach($v as $k2 => $v2) {
				$data['payment'][$k][$k2] = $v2;
			}
		}
		// ra ri kpr
		$sql = "
			SELECT
				alok.keterangan,
				alok.persentase,
				plaf.rp*alok.persentase/100 AS ra_rp,
				IFNULL(date_format(kpr.tanggal, '%d/%m/%Y'),'') AS ri_tgl,
				IFNULL(kpr.rp,'') AS ri_rp
			FROM
				tr_payment pay
				INNER JOIN mst_bank_alokasi alok ON alok.kode_bank = pay.kode_bank
				INNER JOIN mst_bank_plafond plaf ON plaf.reserve_no = pay.reserve_no
					AND plaf.kode_bank = pay.kode_bank
				LEFT JOIN tr_ri_kpr_detail kpr ON kpr.reserve_no = pay.reserve_no
					AND kpr.keterangan = alok.keterangan
			WHERE
				pay.reserve_no = '".@$data['reserve_no']."'
		";
		$q = $this->db->query($sql);
		$res = $q->result_array();
		foreach ($res as $k => $v) {
			$data['kpr'][] = $v;
		}
		return $data;
	}
	
	function gen_kartu_piutang($from, $to) {
		$sql = "
			SELECT
				stk.no_unit AS no_unit,
				nsb.nama AS nsb_nama,
				DATE_FORMAT(
					pay.reserve_date,
					'%d/%m/%Y'
				) AS pay_res_date,
				stk.tower_cluster AS tower_kode,
				mos.konten AS tower,
				stk.type_unit AS prop_type,
				stk.lantai_blok AS blok,
				stk.kavling AS kavling,
				stk.wide_netto AS luas_nett,
				stk.wide_gross AS luas_gross,
				pay.harga_unit AS bruto,
				opsi_bayar.nama AS cara_bayar,
				IFNULL(ra_pay_ini.rp_um,0) AS ra_um_ini,
				IFNULL(ra_pay_ini.rp_ag,0) AS ra_ag_ini,
				IFNULL(ri_pay_ini.rp_um,0) AS ri_um_ini,
				IFNULL(ri_pay_ini.rp_ag,0) AS ri_ag_ini,
				IFNULL(ra_pay_lalu.rp_um,0) AS ra_um_lalu,
				IFNULL(ra_pay_lalu.rp_ag,0) AS ra_ag_lalu,
				IFNULL(ri_pay_lalu.rp_um,0) AS ri_um_lalu,
				IFNULL(ri_pay_lalu.rp_ag,0) AS ri_ag_lalu,
				IFNULL(ra_pay_depan.rp_um,0) AS ra_um_depan,
				IFNULL(ra_pay_depan.rp_ag,0) AS ra_ag_depan,
				IFNULL(ri_pay_depan.rp_um,0) AS ri_um_depan,
				IFNULL(ri_pay_depan.rp_ag,0) AS ri_ag_depan
			FROM
				tr_payment AS pay
				INNER JOIN mst_stock AS stk ON stk.no_unit = pay.no_unit
					AND stk.kode_entity = '".$this->session->userdata('kode_entity')."'
				INNER JOIN mst_nasabah AS nsb ON nsb.kode = pay.kode_nasabah
					AND nsb.jenis = 'CUSTOMER'
				INNER JOIN mst_optional AS opsi_bayar ON opsi_bayar.kode = pay.cara_bayar
				INNER JOIN mst_optional_stock mos ON mos.kode = stk.tower_cluster
				LEFT JOIN (
					SELECT
						paydet.reserve_no,
						SUM(
							CASE
							WHEN pay.cara_bayar = 'HARDCASH' THEN
								paydet.rp
							ELSE
								CASE
							WHEN plan.tipe_pay IN ('BOOKINGFEE', 'DOWNPAYMENT') THEN
								paydet.rp
							ELSE
								0
							END
							END
						) AS rp_um,
						SUM(
							CASE
							WHEN pay.cara_bayar = 'HARDCASH' THEN
								0
							ELSE
								CASE
							WHEN plan.tipe_pay IN ('BOOKINGFEE', 'DOWNPAYMENT') THEN
								0
							ELSE
								paydet.rp
							END
							END
						) AS rp_ag
					FROM
						tr_payment_detail paydet
					INNER JOIN mst_payment_plan AS plan ON plan.kode_pay = paydet.kode_pay
					INNER JOIN tr_payment AS pay ON pay.reserve_no = paydet.reserve_no
					WHERE
						paydet.tgl_bayar IS NULL
					AND pay.iscancelled = 0
					AND paydet.tgl_tempo >= '$from'
					AND paydet.tgl_tempo <= '$to'
					GROUP BY
						paydet.reserve_no
				) AS ra_pay_ini ON ra_pay_ini.reserve_no = pay.reserve_no
				LEFT JOIN (
					SELECT
						paydet.reserve_no,
						SUM(
							CASE
							WHEN pay.cara_bayar = 'HARDCASH' THEN
								paydet.rp
							ELSE
								CASE
							WHEN plan.tipe_pay IN ('BOOKINGFEE', 'DOWNPAYMENT') THEN
								paydet.rp
							ELSE
								0
							END
							END
						) AS rp_um,
						SUM(
							CASE
							WHEN pay.cara_bayar = 'HARDCASH' THEN
								0
							ELSE
								CASE
							WHEN plan.tipe_pay IN ('BOOKINGFEE', 'DOWNPAYMENT') THEN
								0
							ELSE
								paydet.rp
							END
							END
						) AS rp_ag
					FROM
						tr_payment_detail paydet
					INNER JOIN mst_payment_plan AS plan ON plan.kode_pay = paydet.kode_pay
					INNER JOIN tr_payment AS pay ON pay.reserve_no = paydet.reserve_no
					WHERE
						paydet.tgl_bayar IS NOT NULL
					AND pay.iscancelled = 0
					AND paydet.tgl_bayar >= '$from'
					AND paydet.tgl_bayar <= '$to'
					GROUP BY
						paydet.reserve_no
				) AS ri_pay_ini ON ri_pay_ini.reserve_no = pay.reserve_no
				LEFT JOIN (
					SELECT
						paydet.reserve_no,
						SUM(
							CASE
							WHEN pay.cara_bayar = 'HARDCASH' THEN
								paydet.rp
							ELSE
								CASE
							WHEN plan.tipe_pay IN ('BOOKINGFEE', 'DOWNPAYMENT') THEN
								paydet.rp
							ELSE
								0
							END
							END
						) AS rp_um,
						SUM(
							CASE
							WHEN pay.cara_bayar = 'HARDCASH' THEN
								0
							ELSE
								CASE
							WHEN plan.tipe_pay IN ('BOOKINGFEE', 'DOWNPAYMENT') THEN
								0
							ELSE
								paydet.rp
							END
							END
						) AS rp_ag
					FROM
						tr_payment_detail paydet
					INNER JOIN mst_payment_plan AS plan ON plan.kode_pay = paydet.kode_pay
					INNER JOIN tr_payment AS pay ON pay.reserve_no = paydet.reserve_no
					WHERE
						paydet.tgl_bayar IS NULL
					AND pay.iscancelled = 0
					AND paydet.tgl_tempo < '$from'
					GROUP BY
						paydet.reserve_no
				) AS ra_pay_lalu ON ra_pay_lalu.reserve_no = pay.reserve_no
				LEFT JOIN (
					SELECT
						paydet.reserve_no,
						SUM(
							CASE
							WHEN pay.cara_bayar = 'HARDCASH' THEN
								paydet.rp
							ELSE
								CASE
							WHEN plan.tipe_pay IN ('BOOKINGFEE', 'DOWNPAYMENT') THEN
								paydet.rp
							ELSE
								0
							END
							END
						) AS rp_um,
						SUM(
							CASE
							WHEN pay.cara_bayar = 'HARDCASH' THEN
								0
							ELSE
								CASE
							WHEN plan.tipe_pay IN ('BOOKINGFEE', 'DOWNPAYMENT') THEN
								0
							ELSE
								paydet.rp
							END
							END
						) AS rp_ag
					FROM
						tr_payment_detail paydet
					INNER JOIN mst_payment_plan AS plan ON plan.kode_pay = paydet.kode_pay
					INNER JOIN tr_payment AS pay ON pay.reserve_no = paydet.reserve_no
					WHERE
						paydet.tgl_bayar IS NOT NULL
					AND pay.iscancelled = 0
					AND paydet.tgl_bayar < '$from'
					GROUP BY
						paydet.reserve_no
				) AS ri_pay_lalu ON ri_pay_lalu.reserve_no = pay.reserve_no
				LEFT JOIN (
					SELECT
						paydet.reserve_no,
						SUM(
							CASE
							WHEN pay.cara_bayar = 'HARDCASH' THEN
								paydet.rp
							ELSE
								CASE
							WHEN plan.tipe_pay IN ('BOOKINGFEE', 'DOWNPAYMENT') THEN
								paydet.rp
							ELSE
								0
							END
							END
						) AS rp_um,
						SUM(
							CASE
							WHEN pay.cara_bayar = 'HARDCASH' THEN
								0
							ELSE
								CASE
							WHEN plan.tipe_pay IN ('BOOKINGFEE', 'DOWNPAYMENT') THEN
								0
							ELSE
								paydet.rp
							END
							END
						) AS rp_ag
					FROM
						tr_payment_detail paydet
					INNER JOIN mst_payment_plan AS plan ON plan.kode_pay = paydet.kode_pay
					INNER JOIN tr_payment AS pay ON pay.reserve_no = paydet.reserve_no
					WHERE
						paydet.tgl_bayar IS NULL
					AND pay.iscancelled = 0
					AND paydet.tgl_tempo > '$to'
					GROUP BY
						paydet.reserve_no
				) AS ra_pay_depan ON ra_pay_depan.reserve_no = pay.reserve_no
				LEFT JOIN (
					SELECT
						paydet.reserve_no,
						SUM(
							CASE
							WHEN pay.cara_bayar = 'HARDCASH' THEN
								paydet.rp
							ELSE
								CASE
							WHEN plan.tipe_pay IN ('BOOKINGFEE', 'DOWNPAYMENT') THEN
								paydet.rp
							ELSE
								0
							END
							END
						) AS rp_um,
						SUM(
							CASE
							WHEN pay.cara_bayar = 'HARDCASH' THEN
								0
							ELSE
								CASE
							WHEN plan.tipe_pay IN ('BOOKINGFEE', 'DOWNPAYMENT') THEN
								0
							ELSE
								paydet.rp
							END
							END
						) AS rp_ag
					FROM
						tr_payment_detail paydet
					INNER JOIN mst_payment_plan AS plan ON plan.kode_pay = paydet.kode_pay
					INNER JOIN tr_payment AS pay ON pay.reserve_no = paydet.reserve_no
					WHERE
						paydet.tgl_bayar IS NOT NULL
					AND pay.iscancelled = 0
					AND paydet.tgl_bayar > '$to'
					GROUP BY
						paydet.reserve_no
				) AS ri_pay_depan ON ri_pay_depan.reserve_no = pay.reserve_no
			WHERE
				pay.iscancelled = 0
				AND pay.status_tr <> 'HOLD'
				AND pay.status_tr <> 'RESERVE' 
				AND pay.kode_entity = '".$this->session->userdata('kode_entity')."'
		";
		$q = $this->db->query($sql);
		return $q->result_array();
	}

	function gen_penagihan($from, $to) {
		$sql = "
			SELECT
				stk.no_unit AS no_unit,
				nsb.nama AS nsb_nama,
				DATE_FORMAT(
					pay.reserve_date,
					'%d/%m/%Y'
				) AS pay_res_date,
				stk.tower_cluster AS tower_kode,
				mos.konten AS tower,
				stk.type_unit AS prop_type,
				stk.lantai_blok AS blok,
				stk.kavling AS kavling,
				stk.wide_netto AS luas_nett,
				stk.wide_gross AS luas_gross,
				pay.harga_unit AS bruto,
				opsi_bayar.nama AS cara_bayar,
				IFNULL(ra_pay_ini.rp_um,0) AS ra_um_ini,
				IFNULL(ra_pay_ini.rp_ag,0) AS ra_ag_ini,
				IFNULL(ri_pay_ini.rp_um,0) AS ri_um_ini,
				IFNULL(ri_pay_ini.rp_ag,0) AS ri_ag_ini,
				IFNULL(ra_pay_lalu.rp_um,0) AS ra_um_lalu,
				IFNULL(ra_pay_lalu.rp_ag,0) AS ra_ag_lalu,
				IFNULL(ri_pay_lalu.rp_um,0) AS ri_um_lalu,
				IFNULL(ri_pay_lalu.rp_ag,0) AS ri_ag_lalu,
				IFNULL(ra_pay_depan.rp,0) AS ra_depan
			FROM
				tr_payment AS pay
				INNER JOIN mst_stock AS stk ON stk.no_unit = pay.no_unit
					AND stk.kode_entity = '".$this->session->userdata('kode_entity')."'
				INNER JOIN mst_nasabah AS nsb ON nsb.kode = pay.kode_nasabah
					AND nsb.jenis = 'CUSTOMER'
				INNER JOIN mst_optional AS opsi_bayar ON opsi_bayar.kode = pay.cara_bayar
				INNER JOIN mst_optional_stock mos ON mos.kode = stk.tower_cluster
				LEFT JOIN (
					SELECT
						paydet.reserve_no,
						SUM(
							CASE
							WHEN pay.cara_bayar = 'HARDCASH' THEN
								paydet.rp
							ELSE
								CASE
							WHEN plan.tipe_pay IN ('BOOKINGFEE', 'DOWNPAYMENT') THEN
								paydet.rp
							ELSE
								0
							END
							END
						) AS rp_um,
						SUM(
							CASE
							WHEN pay.cara_bayar = 'HARDCASH' THEN
								0
							ELSE
								CASE
							WHEN plan.tipe_pay IN ('BOOKINGFEE', 'DOWNPAYMENT') THEN
								0
							ELSE
								paydet.rp
							END
							END
						) AS rp_ag
					FROM
						tr_payment_detail paydet
					INNER JOIN mst_payment_plan AS plan ON plan.kode_pay = paydet.kode_pay
					INNER JOIN tr_payment AS pay ON pay.reserve_no = paydet.reserve_no
					WHERE
						paydet.tgl_bayar IS NULL
					AND pay.iscancelled = 0
					AND paydet.tgl_tempo >= '$from'
					AND paydet.tgl_tempo <= '$to'
					GROUP BY
						paydet.reserve_no
				) AS ra_pay_ini ON ra_pay_ini.reserve_no = pay.reserve_no
				LEFT JOIN (
					SELECT
						paydet.reserve_no,
						SUM(
							CASE
							WHEN pay.cara_bayar = 'HARDCASH' THEN
								paydet.rp
							ELSE
								CASE
							WHEN plan.tipe_pay IN ('BOOKINGFEE', 'DOWNPAYMENT') THEN
								paydet.rp
							ELSE
								0
							END
							END
						) AS rp_um,
						SUM(
							CASE
							WHEN pay.cara_bayar = 'HARDCASH' THEN
								0
							ELSE
								CASE
							WHEN plan.tipe_pay IN ('BOOKINGFEE', 'DOWNPAYMENT') THEN
								0
							ELSE
								paydet.rp
							END
							END
						) AS rp_ag
					FROM
						tr_payment_detail paydet
					INNER JOIN mst_payment_plan AS plan ON plan.kode_pay = paydet.kode_pay
					INNER JOIN tr_payment AS pay ON pay.reserve_no = paydet.reserve_no
					WHERE
						paydet.tgl_bayar IS NOT NULL
					AND pay.iscancelled = 0
					AND paydet.tgl_bayar >= '$from'
					AND paydet.tgl_bayar <= '$to'
					GROUP BY
						paydet.reserve_no
				) AS ri_pay_ini ON ri_pay_ini.reserve_no = pay.reserve_no
				LEFT JOIN (
					SELECT
						paydet.reserve_no,
						SUM(
							CASE
							WHEN pay.cara_bayar = 'HARDCASH' THEN
								paydet.rp
							ELSE
								CASE
							WHEN plan.tipe_pay IN ('BOOKINGFEE', 'DOWNPAYMENT') THEN
								paydet.rp
							ELSE
								0
							END
							END
						) AS rp_um,
						SUM(
							CASE
							WHEN pay.cara_bayar = 'HARDCASH' THEN
								0
							ELSE
								CASE
							WHEN plan.tipe_pay IN ('BOOKINGFEE', 'DOWNPAYMENT') THEN
								0
							ELSE
								paydet.rp
							END
							END
						) AS rp_ag
					FROM
						tr_payment_detail paydet
					INNER JOIN mst_payment_plan AS plan ON plan.kode_pay = paydet.kode_pay
					INNER JOIN tr_payment AS pay ON pay.reserve_no = paydet.reserve_no
					WHERE
						paydet.tgl_bayar IS NULL
					AND pay.iscancelled = 0
					AND paydet.tgl_tempo < '$from'
					GROUP BY
						paydet.reserve_no
				) AS ra_pay_lalu ON ra_pay_lalu.reserve_no = pay.reserve_no
				LEFT JOIN (
					SELECT
						paydet.reserve_no,
						SUM(
							CASE
							WHEN pay.cara_bayar = 'HARDCASH' THEN
								paydet.rp
							ELSE
								CASE
							WHEN plan.tipe_pay IN ('BOOKINGFEE', 'DOWNPAYMENT') THEN
								paydet.rp
							ELSE
								0
							END
							END
						) AS rp_um,
						SUM(
							CASE
							WHEN pay.cara_bayar = 'HARDCASH' THEN
								0
							ELSE
								CASE
							WHEN plan.tipe_pay IN ('BOOKINGFEE', 'DOWNPAYMENT') THEN
								0
							ELSE
								paydet.rp
							END
							END
						) AS rp_ag
					FROM
						tr_payment_detail paydet
					INNER JOIN mst_payment_plan AS plan ON plan.kode_pay = paydet.kode_pay
					INNER JOIN tr_payment AS pay ON pay.reserve_no = paydet.reserve_no
					WHERE
						paydet.tgl_bayar IS NOT NULL
					AND pay.iscancelled = 0
					AND paydet.tgl_bayar < '$from'
					GROUP BY
						paydet.reserve_no
				) AS ri_pay_lalu ON ri_pay_lalu.reserve_no = pay.reserve_no
				LEFT JOIN (
					SELECT
						paydet.reserve_no,
						MIN(paydet.no_urut) AS no_urut,
						paydet.rp
					FROM
						tr_payment_detail paydet
					INNER JOIN mst_payment_plan AS plan ON plan.kode_pay = paydet.kode_pay
					INNER JOIN tr_payment AS pay ON pay.reserve_no = paydet.reserve_no
					WHERE
						paydet.tgl_bayar IS NULL
					AND pay.iscancelled = 0
					AND paydet.tgl_tempo > '$to'
					AND paydet.tgl_tempo <= DATE_ADD('$to', INTERVAL 7 DAY)
					GROUP BY
						paydet.reserve_no
				) AS ra_pay_depan ON ra_pay_depan.reserve_no = pay.reserve_no
			WHERE
				pay.iscancelled = 0
				AND pay.status_tr <> 'HOLD'
				AND pay.kode_entity = '".$this->session->userdata('kode_entity')."'
		";
		$q = $this->db->query($sql);
		return $q->result_array();
	}

	function gen_penagihan2($from, $to) {
		$sql = "
			SELECT
				stk.no_unit AS no_unit,
				nsb.nama AS nsb_nama,
				DATE_FORMAT(
					pay.reserve_date,
					'%d/%m/%Y'
				) AS pay_res_date,
				stk.tower_cluster AS tower_kode,
				mos.konten AS tower,
				stk.type_unit AS prop_type,
				stk.lantai_blok AS blok,
				stk.kavling AS kavling,
				stk.wide_netto AS luas_nett,
				stk.wide_gross AS luas_gross,
				pay.harga_unit AS bruto,
				opsi_bayar.nama AS cara_bayar,
				IFNULL(ra_pay_ini.rp_um,0) AS ra_um_ini,
				IFNULL(ra_pay_ini.rp_ag,0) AS ra_ag_ini,
				IFNULL(ri_pay_ini.rp_um,0) AS ri_um_ini,
				IFNULL(ri_pay_ini.rp_ag,0) AS ri_ag_ini,
				IFNULL(ra_pay_lalu.rp_um,0) AS ra_um_lalu,
				IFNULL(ra_pay_lalu.rp_ag,0) AS ra_ag_lalu,
				IFNULL(ri_pay_lalu.rp_um,0) AS ri_um_lalu,
				IFNULL(ri_pay_lalu.rp_ag,0) AS ri_ag_lalu,
				IFNULL(ra_pay_depan.rp,0) AS ra_depan
			FROM
				tr_payment AS pay
				INNER JOIN mst_stock AS stk ON stk.no_unit = pay.no_unit
					AND stk.kode_entity = '".$this->session->userdata('kode_entity')."'
				INNER JOIN mst_nasabah AS nsb ON nsb.kode = pay.kode_nasabah
					AND nsb.jenis = 'CUSTOMER'
				INNER JOIN mst_optional AS opsi_bayar ON opsi_bayar.kode = pay.cara_bayar
				INNER JOIN mst_optional_stock mos ON mos.kode = stk.tower_cluster
				LEFT JOIN (
					SELECT
						paydet.reserve_no,
						SUM(
							CASE
							WHEN pay.cara_bayar = 'HARDCASH' THEN
								paydet.rp
							ELSE
								CASE
							WHEN plan.tipe_pay IN ('BOOKINGFEE', 'DOWNPAYMENT') THEN
								paydet.rp
							ELSE
								0
							END
							END
						) AS rp_um,
						SUM(
							CASE
							WHEN pay.cara_bayar = 'HARDCASH' THEN
								0
							ELSE
								CASE
							WHEN plan.tipe_pay IN ('BOOKINGFEE', 'DOWNPAYMENT') THEN
								0
							ELSE
								paydet.rp
							END
							END
						) AS rp_ag
					FROM
						tr_payment_detail paydet
					INNER JOIN mst_payment_plan AS plan ON plan.kode_pay = paydet.kode_pay
					INNER JOIN tr_payment AS pay ON pay.reserve_no = paydet.reserve_no
					WHERE
						paydet.tgl_bayar IS NULL
					AND pay.iscancelled = 0
					AND paydet.tgl_tempo >= '$from'
					AND paydet.tgl_tempo <= '$to'
					GROUP BY
						paydet.reserve_no
				) AS ra_pay_ini ON ra_pay_ini.reserve_no = pay.reserve_no
				LEFT JOIN (
					SELECT
						paydet.reserve_no,
						SUM(
							CASE
							WHEN pay.cara_bayar = 'HARDCASH' THEN
								paydet.rp
							ELSE
								CASE
							WHEN plan.tipe_pay IN ('BOOKINGFEE', 'DOWNPAYMENT') THEN
								paydet.rp
							ELSE
								0
							END
							END
						) AS rp_um,
						SUM(
							CASE
							WHEN pay.cara_bayar = 'HARDCASH' THEN
								0
							ELSE
								CASE
							WHEN plan.tipe_pay IN ('BOOKINGFEE', 'DOWNPAYMENT') THEN
								0
							ELSE
								paydet.rp
							END
							END
						) AS rp_ag
					FROM
						tr_payment_detail paydet
					INNER JOIN mst_payment_plan AS plan ON plan.kode_pay = paydet.kode_pay
					INNER JOIN tr_payment AS pay ON pay.reserve_no = paydet.reserve_no
					WHERE
						paydet.tgl_bayar IS NOT NULL
					AND pay.iscancelled = 0
					AND paydet.tgl_bayar >= '$from'
					AND paydet.tgl_bayar <= '$to'
					GROUP BY
						paydet.reserve_no
				) AS ri_pay_ini ON ri_pay_ini.reserve_no = pay.reserve_no
				LEFT JOIN (
					SELECT
						paydet.reserve_no,
						SUM(
							CASE
							WHEN pay.cara_bayar = 'HARDCASH' THEN
								paydet.rp
							ELSE
								CASE
							WHEN plan.tipe_pay IN ('BOOKINGFEE', 'DOWNPAYMENT') THEN
								paydet.rp
							ELSE
								0
							END
							END
						) AS rp_um,
						SUM(
							CASE
							WHEN pay.cara_bayar = 'HARDCASH' THEN
								0
							ELSE
								CASE
							WHEN plan.tipe_pay IN ('BOOKINGFEE', 'DOWNPAYMENT') THEN
								0
							ELSE
								paydet.rp
							END
							END
						) AS rp_ag
					FROM
						tr_payment_detail paydet
					INNER JOIN mst_payment_plan AS plan ON plan.kode_pay = paydet.kode_pay
					INNER JOIN tr_payment AS pay ON pay.reserve_no = paydet.reserve_no
					WHERE
						paydet.tgl_bayar IS NULL
					AND pay.iscancelled = 0
					AND paydet.tgl_tempo < '$from'
					GROUP BY
						paydet.reserve_no
				) AS ra_pay_lalu ON ra_pay_lalu.reserve_no = pay.reserve_no
				LEFT JOIN (
					SELECT
						paydet.reserve_no,
						SUM(
							CASE
							WHEN pay.cara_bayar = 'HARDCASH' THEN
								paydet.rp
							ELSE
								CASE
							WHEN plan.tipe_pay IN ('BOOKINGFEE', 'DOWNPAYMENT') THEN
								paydet.rp
							ELSE
								0
							END
							END
						) AS rp_um,
						SUM(
							CASE
							WHEN pay.cara_bayar = 'HARDCASH' THEN
								0
							ELSE
								CASE
							WHEN plan.tipe_pay IN ('BOOKINGFEE', 'DOWNPAYMENT') THEN
								0
							ELSE
								paydet.rp
							END
							END
						) AS rp_ag
					FROM
						tr_payment_detail paydet
					INNER JOIN mst_payment_plan AS plan ON plan.kode_pay = paydet.kode_pay
					INNER JOIN tr_payment AS pay ON pay.reserve_no = paydet.reserve_no
					WHERE
						paydet.tgl_bayar IS NOT NULL
					AND pay.iscancelled = 0
					AND paydet.tgl_bayar < '$from'
					GROUP BY
						paydet.reserve_no
				) AS ri_pay_lalu ON ri_pay_lalu.reserve_no = pay.reserve_no
				LEFT JOIN (
					SELECT
						paydet.reserve_no,
						MIN(paydet.no_urut) AS no_urut,
						paydet.rp
					FROM
						tr_payment_detail paydet
					INNER JOIN mst_payment_plan AS plan ON plan.kode_pay = paydet.kode_pay
					INNER JOIN tr_payment AS pay ON pay.reserve_no = paydet.reserve_no
					WHERE
						paydet.tgl_bayar IS NULL
					AND pay.iscancelled = 0
					AND paydet.tgl_tempo > '$to'
					AND paydet.tgl_tempo <= DATE_ADD('$to', INTERVAL 7 DAY)
					GROUP BY
						paydet.reserve_no
				) AS ra_pay_depan ON ra_pay_depan.reserve_no = pay.reserve_no
			WHERE
				pay.iscancelled = 0
				AND pay.status_tr <> 'HOLD'
				AND opsi_bayar.nama = 'KPR / KPA'
				AND pay.kode_entity = '".$this->session->userdata('kode_entity')."'
		";
		$q = $this->db->query($sql);
		return $q->result_array();
	}
	
	function gen_rpt_op($from, $to) {
		$sql = "
			SELECT
				opent.konten AS type_entity,
				ent.nama,
				'F' as scol,
				IFNULL(SUM(paydet.rp),0) AS rp,
				stk.wide_netto,
				stk.wide_gross,
				1 AS n_unit,
				stk.no_unit,
				pay.harga_unit
			FROM
				tr_payment pay
				INNER JOIN mst_stock AS stk ON stk.no_unit = pay.no_unit
				INNER JOIN mst_entity AS ent ON ent.kode = stk.kode_entity AND ent.kode = pay.kode_entity
				INNER JOIN mst_optional_entity opent ON opent.kode = ent.type_entity
						AND opent.sfield = 'type_entity'
				INNER JOIN tr_payment_detail paydet ON paydet.reserve_no = pay.reserve_no
			WHERE
				pay.iscancelled = 0
				AND pay.status_tr <> 'HOLD'
				AND paydet.tgl_bayar < '$from'
			GROUP BY
				ent.type_entity,
				ent.kode,
				stk.no_unit
			UNION ALL
			SELECT
				opent.konten AS type_entity,
				ent.nama,
				'G' as scol,
				IFNULL(SUM(paydet.rp),0) AS rp,
				stk.wide_netto,
				stk.wide_gross,
				1 AS n_unit,
				stk.no_unit,
				pay.harga_unit
			FROM
				tr_payment pay
				INNER JOIN mst_stock AS stk ON stk.no_unit = pay.no_unit
				INNER JOIN mst_entity AS ent ON ent.kode = stk.kode_entity AND ent.kode = pay.kode_entity
				INNER JOIN mst_optional_entity opent ON opent.kode = ent.type_entity
						AND opent.sfield = 'type_entity'
				INNER JOIN tr_payment_detail paydet ON paydet.reserve_no = pay.reserve_no
			WHERE
				pay.iscancelled = 0
				AND pay.status_tr <> 'HOLD'
				AND paydet.tgl_bayar >= '$from'
				AND paydet.tgl_bayar <= '$to'
			GROUP BY
				ent.type_entity,
				ent.kode,
				stk.no_unit
			UNION ALL
			SELECT
				opent.konten AS type_entity,
				ent.nama,
				'J' as scol,
				IFNULL(SUM(paydet.rp),0) AS rp,
				stk.wide_netto,
				stk.wide_gross,
				1 AS n_unit,
				stk.no_unit,
				pay.harga_unit
			FROM
				tr_payment pay
				INNER JOIN mst_stock AS stk ON stk.no_unit = pay.no_unit
				INNER JOIN mst_entity AS ent ON ent.kode = stk.kode_entity AND ent.kode = pay.kode_entity
				INNER JOIN mst_optional_entity opent ON opent.kode = ent.type_entity
						AND opent.sfield = 'type_entity'
				INNER JOIN tr_payment_detail paydet ON paydet.reserve_no = pay.reserve_no
			WHERE
				pay.iscancelled = 0
				AND pay.status_tr <> 'HOLD'
				AND paydet.tgl_bayar > '$to'
			GROUP BY
				ent.type_entity,
				ent.kode,
				stk.no_unit
			UNION ALL
			SELECT
				opent.konten AS type_entity,
				ent.nama,
				'H' as scol,
				IFNULL(SUM(paydet.rp),0) AS rp,
				stk.wide_netto,
				stk.wide_gross,
				1 AS n_unit,
				stk.no_unit,
				pay.harga_unit
			FROM
				tr_payment pay
				INNER JOIN mst_stock AS stk ON stk.no_unit = pay.no_unit
				INNER JOIN mst_entity AS ent ON ent.kode = stk.kode_entity AND ent.kode = pay.kode_entity
				INNER JOIN mst_optional_entity opent ON opent.kode = ent.type_entity
						AND opent.sfield = 'type_entity'
				INNER JOIN tr_payment_detail paydet ON paydet.reserve_no = pay.reserve_no
			WHERE
				pay.iscancelled = 1
				AND pay.status_tr <> 'HOLD'
				AND paydet.tgl_bayar < '$from'
			GROUP BY
				ent.type_entity,
				ent.kode,
				stk.no_unit
		";
		$q = $this->db->query($sql);
		$data = array();
		foreach ($q->result_array() as $k => $v) {
			if(!isset($data[$v['type_entity']][$v['nama']]['unit'][$v['scol']])) {
				// ri > 5%
				$data[$v['type_entity']][$v['nama']]['unit'][$v['scol']] = 0;
				$data[$v['type_entity']][$v['nama']]['netto'][$v['scol']] = 0;
				$data[$v['type_entity']][$v['nama']]['gross'][$v['scol']] = 0;
				$data[$v['type_entity']][$v['nama']]['rp'][$v['scol']] = 0;
				// ri <= 5%
				$data[$v['type_entity']][$v['nama']]['unit']['N'] = 0;
				$data[$v['type_entity']][$v['nama']]['netto']['N'] = 0;
				$data[$v['type_entity']][$v['nama']]['gross']['N'] = 0;
				$data[$v['type_entity']][$v['nama']]['rp']['N'] = 0;
			}
			$diff = $v['rp'] / $v['harga_unit'] *100;
			if($v['scol']!=='H' AND $v['scol']!=='J') {
				if($diff>=5) {
					$data[$v['type_entity']][$v['nama']]['unit'][$v['scol']] += $v['n_unit'];
					$data[$v['type_entity']][$v['nama']]['netto'][$v['scol']] += $v['wide_netto'];
					$data[$v['type_entity']][$v['nama']]['gross'][$v['scol']] += $v['wide_gross'];
					$data[$v['type_entity']][$v['nama']]['rp'][$v['scol']] += $v['rp'];
				} else {
					$data[$v['type_entity']][$v['nama']]['unit']['N'] += $v['n_unit'];
					$data[$v['type_entity']][$v['nama']]['netto']['N'] += $v['wide_netto'];
					$data[$v['type_entity']][$v['nama']]['gross']['N'] += $v['wide_gross'];
					$data[$v['type_entity']][$v['nama']]['rp']['N'] += $v['rp'];
				}
			} else {
				$data[$v['type_entity']][$v['nama']]['unit'][$v['scol']] += $v['n_unit'];
				$data[$v['type_entity']][$v['nama']]['netto'][$v['scol']] += $v['wide_netto'];
				$data[$v['type_entity']][$v['nama']]['gross'][$v['scol']] += $v['wide_gross'];
				$data[$v['type_entity']][$v['nama']]['rp'][$v['scol']] += $v['rp'];
			}
		}
		return $data;
	}
		
}
	