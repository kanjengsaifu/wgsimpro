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
	function gen_kartu_piutangnew($from, $to) {
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
				IFNULL(ri_pay_sdini.ri_total,0) AS ri_total,
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
				INNER JOIN mst_optional_stock mos ON mos.kode = stk.tower_cluster AND mos.sfield = 'tower_cluster'
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
						) AS rp_ag,
						paydet.tgl_bayar as tglbayar
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
				
				-- TAMBAH
				
					LEFT JOIN (
					SELECT
						paydet.reserve_no,
						SUM(paydet.rp )as ri_total
					FROM
						tr_payment_detail paydet
					INNER JOIN mst_payment_plan AS plan ON plan.kode_pay = paydet.kode_pay
					INNER JOIN tr_payment AS pay ON pay.reserve_no = paydet.reserve_no
					WHERE
						paydet.tgl_bayar IS NOT NULL
					AND pay.iscancelled = 0
					AND paydet.tgl_bayar <= '$to'
					GROUP BY
						paydet.reserve_no
				) AS ri_pay_sdini ON ri_pay_sdini.reserve_no = pay.reserve_no

				-- END
				
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
				-- AND pay.status_tr <> 'RESERVE' 
				AND pay.kode_entity = '".$this->session->userdata('kode_entity')."'
				AND (ri_pay_ini.tglbayar BETWEEN '$from' AND '$to')
		";
		// die('<pre>'.$sql.'</pre>');
		$q = $this->db->query($sql);
		return $q->result_array();
	}
	
	/* 2015-10-07 Penambahan Progress Bangunan untuk Laporan Opname Master Stock
	 * Function yang digunakan fJumlahBayar = Untuk Mengecek apakah Type Entity HR harga_unit * 20% LD harga_unit
	 * fGetProgress =  Untuk Mengecek Progress Bangunan HR = 10%, LD */
	function gen_opnamemasterstock($from,$to){
		
		$m = explode('-', $from);
		$pilih = 0;
		$jenisbayar = "";
		$typepro = $this->session->userdata('type_entity');//==='HR' ?
		$sql = "SELECT 
						reserve_no,
						kode_entity, 
						no_unit, 
						cara_bayar,
						nama,
						type_unit, 
						kavling, 
						harga_unit,
						rp_bayar,
						siteplan, 
						stakeout, 
						bpn,
						IFNULL(progress,0) as progress,
						tgl_akad,
						kode_bank,
						(
						CASE 
						WHEN cara_bayar not like '%KPR%' AND rp_bayar >= fJumlahBayar('{$typepro}',harga_unit)  AND progress <= fGetProgress('{$typepro}','".$m[1]."') THEN
							'terjual'
						ELSE
							CASE
							WHEN cara_bayar LIKE '%KPR%' AND progress <= fGetProgress('{$typepro}','".$m[1]."') AND kode_bank IS NOT NULL AND tgl_akad IS NOT NULL THEN
								'terjual'
							ELSE
								CASE
								WHEN nama IS NOT NULL THEN
									'terpesan'
								ELSE
									'stock'
								END
							END
							
						END
						) as status
							
				 FROM
				 (
					SELECT 
						b.reserve_no,
						a.kode_entity, 
						a.no_unit, 
						b.cara_bayar,
						c.nama,
						a.type_unit, 
						a.kavling, 
						b.harga_unit,
						(SELECT sum(f.rp) 
						FROM tr_payment_detail f 
						WHERE f.reserve_no = b.reserve_no 
						AND f.kode_pay NOT LIKE '%KPR%' AND f.no_kwitansi IS NOT NULL AND f.tgl_bayar <= '{$from}') AS rp_bayar,
						a.wide_gross as siteplan, 
						a.wide_gross_2 as stakeout, 
						a.wide_gross_3 as bpn,
						(SELECT d.persen_progress 
						FROM tr_progress d
						WHERE d.kode_entity = a.kode_entity AND d.no_unit = a.no_unit 
						AND (d.tgl_progress BETWEEN '".date('Y')."-01-01' AND '{$from}' )
						ORDER BY d.tgl_progress DESC LIMIT 1) as progress,
						b.tgl_akad,
						e.kode_bank
					FROM mst_stock a 
					LEFT JOIN tr_payment b ON b.kode_entity = a.kode_entity AND b.no_unit = a.no_unit AND b.iscancelled <> 1
					LEFT JOIN mst_nasabah c ON c.kode = b.kode_nasabah
					LEFT JOIN tr_progress d ON d.kode_entity = a.kode_entity AND d.no_unit = a.no_unit 
					LEFT JOIN mst_bank_plafond e ON e.reserve_no = b.reserve_no
					WHERE a.kode_entity = '".$this->session->userdata('kode_entity')."'
					GROUP BY no_unit ORDER BY kavling ASC, a.no_unit ASC
				 ) f
				-- WHERE f.progress > 0";
		//die('<pre>'.$sql.'</pre>');
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
	
	function gen_penagihannew($from, $to) {
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
				IFNULL(ri_pay_sdmggulalu.ri_total,0) AS ri_mggulalutotal,
				IFNULL(ri_pay_sdini.ri_total,0) AS ri_total,
				IFNULL(ra_pay_lalu.rp_um,0) AS ra_um_lalu,
				IFNULL(ra_pay_lalu.rp_ag,0) AS ra_ag_lalu,
				IFNULL(ri_pay_lalu.rp_um,0) AS ri_um_lalu,
				IFNULL(ri_pay_lalu.rp_ag,0) AS ri_ag_lalu,
				IFNULL(ra_pay_depan.rp,0) AS ra_depan,
				IFNULL(jm_plafond.plafond,0) AS plafond,
				(IFNULL(jm_plafond.plafond,0)*IFNULL(krg_bayar.persen_progress,0))/100 AS krg_bayar_total,
				(IFNULL(jm_plafond.plafond,0)*IFNULL(krg_bayarini.persen_progress,0))/100 AS krg_bayarini_total,
				krg_bayar.persen_progress
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
				
				
				-- TAMBAH
				
					LEFT JOIN (
					SELECT
						paydet.reserve_no,
						SUM(paydet.rp )as ri_total
					FROM
						tr_payment_detail paydet
					INNER JOIN mst_payment_plan AS plan ON plan.kode_pay = paydet.kode_pay
					INNER JOIN tr_payment AS pay ON pay.reserve_no = paydet.reserve_no
					WHERE
						paydet.tgl_bayar IS NOT NULL
					AND pay.iscancelled = 0
					AND paydet.tgl_bayar <= '$from'
					GROUP BY
						paydet.reserve_no
				) AS ri_pay_sdmggulalu ON ri_pay_sdmggulalu.reserve_no = pay.reserve_no
				
				
				LEFT JOIN (
					SELECT
						paydet.reserve_no,
						SUM(paydet.rp )as ri_total
					FROM
						tr_payment_detail paydet
					INNER JOIN mst_payment_plan AS plan ON plan.kode_pay = paydet.kode_pay
					INNER JOIN tr_payment AS pay ON pay.reserve_no = paydet.reserve_no
					WHERE
						paydet.tgl_bayar IS NOT NULL
					AND pay.iscancelled = 0
					AND paydet.tgl_bayar <= '$to'
					GROUP BY
						paydet.reserve_no
				) AS ri_pay_sdini ON ri_pay_sdini.reserve_no = pay.reserve_no

				-- END
				-- CEK PLAFOND
				LEFT JOIN (
						SELECT
							paydet.reserve_no,
							pla.rp as plafond
						FROM
							tr_payment_detail paydet
						INNER JOIN tr_payment AS pay ON pay.reserve_no = paydet.reserve_no
						INNER JOIN mst_bank_plafond AS pla ON pla.reserve_no = pay.reserve_no
						GROUP BY
							paydet.reserve_no
				) AS jm_plafond ON jm_plafond.reserve_no = pay.reserve_no

				-- END CEK PLAFOND
				-- KPR Kurang Bayar Sd Mgg lalu
				
				LEFT JOIN (
					SELECT
						paydet.reserve_no,
						-- alokasi.
						(
							SELECT alok.persentase FROM mst_bank_alokasi alok
							INNER JOIN tr_payment py ON py.kode_bank = alok.kode_bank AND py.kode_entity = alok.kode_entity
							WHERE alok.kode_bank = pay.kode_bank 
								AND progress <= (
												 SELECT 
													prog.persen_progress 
												 FROM tr_progress prog 
												 WHERE prog.no_unit = pay.no_unit 
												 AND prog.kode_entity = pay.kode_entity
												 AND prog.tgl_progress < '$from'
												 ORDER BY prog.tgl_progress DESC LIMIT 1
												)
							AND py.tgl_ri_akad < '$from'
							AND alok.kode_entity = pay.kode_entity AND alok.perijinan = ''
							ORDER BY alok.progress DESC LIMIT 1
						)
						 as persen_progress
					FROM
						tr_payment_detail paydet
					INNER JOIN mst_payment_plan AS plan ON plan.kode_pay = paydet.kode_pay
					INNER JOIN tr_payment AS pay ON pay.reserve_no = paydet.reserve_no
					INNER JOIN mst_bank_alokasi as alokasi ON alokasi.kode_bank = pay.kode_bank
					INNER JOIN mst_optional AS carabyr ON carabyr.kode = pay.cara_bayar
					-- INNER JOIN tr_progress AS prog ON prog.no_unit = pay.no_unit AND prog.kode_entity = pay.kode_entity
					WHERE
						paydet.tgl_bayar IS NOT NULL
					AND pay.iscancelled = 0
					AND paydet.tgl_bayar <= '$to'
					AND carabyr.nama = 'KPR / KPA'
					-- ORDER BY prog.tgl_progress DESC LIMIT 1
					GROUP BY
						paydet.reserve_no
				) AS krg_bayar ON krg_bayar.reserve_no = pay.reserve_no

				-- KPR Kurang Bayar Sd Mgg lalu
				-- KPR Kurang Bayar Mgg ini
				
				LEFT JOIN (
					SELECT
						paydet.reserve_no,
						-- alokasi.
						(
							SELECT alok.persentase FROM mst_bank_alokasi alok
							INNER JOIN tr_payment py ON py.kode_bank = alok.kode_bank AND py.kode_entity = alok.kode_entity
							WHERE alok.kode_bank = pay.kode_bank 
								AND progress <= (
												 SELECT 
													prog.persen_progress 
												 FROM tr_progress prog 
												 WHERE prog.no_unit = pay.no_unit 
												 AND prog.kode_entity = pay.kode_entity
												 AND prog.tgl_progress <= '$to' AND prog.tgl_progress > '$from'
												 ORDER BY prog.tgl_progress DESC LIMIT 1
												)
							AND py.tgl_ri_akad <= '$to'
							AND alok.kode_entity = pay.kode_entity AND alok.perijinan = ''
							ORDER BY alok.progress DESC LIMIT 1
						)
						 as persen_progress
					FROM
						tr_payment_detail paydet
					INNER JOIN mst_payment_plan AS plan ON plan.kode_pay = paydet.kode_pay
					INNER JOIN tr_payment AS pay ON pay.reserve_no = paydet.reserve_no
					INNER JOIN mst_bank_alokasi as alokasi ON alokasi.kode_bank = pay.kode_bank
					INNER JOIN mst_optional AS carabyr ON carabyr.kode = pay.cara_bayar
					-- INNER JOIN tr_progress AS prog ON prog.no_unit = pay.no_unit AND prog.kode_entity = pay.kode_entity
					WHERE
						paydet.tgl_bayar IS NOT NULL
					AND pay.iscancelled = 0
					AND paydet.tgl_bayar <= '$to'
					AND carabyr.nama = 'KPR / KPA'
					-- ORDER BY prog.tgl_progress DESC LIMIT 1
					GROUP BY
						paydet.reserve_no
				) AS krg_bayarini ON krg_bayarini.reserve_no = pay.reserve_no

				-- KPR Kurang Bayar Sd Mgg lalu
				
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
		//die('<pre>'.$sql.'</pre>');
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
	
	function gen_rpt_op_old($from, $to) {
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
	function setflagok(){
		$sql= "
		SELECT 
			pay_det.reserve_no, 
			pay_det.no_kwitansi, 
			pay_det.rp, 
			(SELECT SUM(pyt.rp) 
				FROM tr_payment_detail pyt
				WHERE pyt.tgl_bayar <= pay_det.tgl_bayar AND pyt.reserve_no = pay_det.reserve_no) as rp_bayar,
			pay_det.tgl_bayar, 
			pay.harga_unit, 
			pay_det.flag_ok 
		FROM 
			tr_payment pay
		LEFT JOIN 
			tr_payment_detail pay_det ON pay_det.reserve_no = pay.reserve_no
		WHERE 
			LENGTH(pay_det.no_kwitansi) > 0
		GROUP BY 
			pay_det.reserve_no, pay_det.no_kwitansi
		";
		$q = $this->db->query($sql);
		foreach ($q->result_array() as $k => $v) {
			$r = (object) $v;
			$this->db->query("SELECT setRiOK('{$r->reserve_no}','{$r->tgl_bayar}', {$r->rp_bayar},{$r->harga_unit})");
		}
	}
	function getreportok($from,$to){
		$this->setflagok();
		$sql = "
			SELECT
				direktorat, kode, nama, type_entity, getTypeEntity(type_entity) as nama_entity,
				SUM(rimglalu) as rimglalu,
				SUM(ribayarlalu) as ribayarlalu,
				SUM(rinettolalu) as rinettolalu,
				SUM(rigrosslalu) as rigrosslalu,
				SUM(rimgini) as rimgini,
				SUM(ribayarini) as ribayarini,
				SUM(rinettoini) as rinettoini,
				SUM(rigrossini) as rigrossini,
				SUM(risdmgini) as risdmgini,
				SUM(ribayarsdini) as ribayarsdini,
				SUM(rinettosdini) as rinettosdini,
				SUM(rigrosssdini) as rigrosssdini,
				SUM(rithlalu) as rithlalu,
				SUM(ribayarthlalu) as ribayarthlalu,
				SUM(rinettothlalu) as rinettothlalu,
				SUM(rigrossthlalu) as rigrossthlalu,
				SUM(reserveini) as reserveini,
				SUM(reservejmlh) as reservejmlh,
				SUM(reservenetto) as reservenetto,
				SUM(reservegross) as reservegross 
			FROM
			
					(
						SELECT 
								direktorat, kode, nama, type_entity, no_unit, harga_unit ,
								f_getReserve(harga_unit, (totalribayar),rimglalu) as rimglalu,
								f_getReserve(harga_unit, (totalribayar),ribayarlalu) as ribayarlalu,
								f_getReserve(harga_unit, (totalribayar),rinettolalu) as rinettolalu,
								f_getReserve(harga_unit, (totalribayar),rigrosslalu) as rigrosslalu,
								f_getReserve(harga_unit, (totalribayar),rimgini) as rimgini,
								f_getReserve(harga_unit, (totalribayar),ribayarini) as ribayarini,
								f_getReserve(harga_unit, (totalribayar),rinettoini) as rinettoini,
								f_getReserve(harga_unit, (totalribayar),rigrossini) as rigrossini,
								f_getReserve(harga_unit, (totalribayar),risdmgini) as risdmgini,
								f_getReserve(harga_unit, (totalribayar),ribayarsdini) as ribayarsdini,
								f_getReserve(harga_unit, (totalribayar),rinettosdini) as rinettosdini,
								f_getReserve(harga_unit, (totalribayar),rigrosssdini) as rigrosssdini,
								f_getReserve(harga_unit, (totalribayar),rithlalu) as rithlalu,
								f_getReserve(harga_unit, (totalribayar),ribayarthlalu) as ribayarthlalu,
							 	f_getReserve(harga_unit, (totalribayar),rinettothlalu) as rinettothlalu,
							 	f_getReserve(harga_unit, (totalribayar),rigrossthlalu) as rigrossthlalu,
								f_getReserveFix(harga_unit, (totalribayar),1) as reserveini,
								f_getReserveFix(harga_unit, (totalribayar),(harga_unit)) as reservejmlh,
								f_getReserveFix(harga_unit, (totalribayar),(rinettothlalu+rinettolalu+rinettoini)) as reservenetto,
								f_getReserveFix(harga_unit, (totalribayar),(rigrossthlalu+rigrosslalu+rigrossini)) as reservegross
						FROM 
						(
							SELECT   
									 direktorat,
									 mst.kode, 
									 mst.nama, 
									 mst.type_entity,
									 pay.no_unit, 
									 /*pay.harga_unit,*/
									 SUM(upr.rp) AS harga_unit,
									 f_getTotalRiUnit(pay.reserve_no,'MgLalu','{$from}','{$to}') as rimglalu,
									 f_getTotalRiBayar(pay.reserve_no,'MgLalu','{$from}','{$to}') as ribayarlalu,
									 f_getTotalRiBayar(pay.reserve_no,'TOTAL','{$from}','{$to}') as totalribayar,
									 f_getTotalTanahRi(pay.reserve_no,'MgLalu','{$from}','{$to}','netto') as rinettolalu,
									 f_getTotalTanahRi(pay.reserve_no,'MgLalu','{$from}','{$to}','gross') as rigrosslalu,
									 f_getTotalRiUnit(pay.reserve_no,'MgIni','{$from}','{$to}') as rimgini,
									 f_getTotalRiBayar(pay.reserve_no,'MgIni','{$from}','{$to}') as ribayarini,
									 f_getTotalTanahRi(pay.reserve_no,'MgIni','{$from}','{$to}','netto') as rinettoini,
									 f_getTotalTanahRi(pay.reserve_no,'MgIni','{$from}','{$to}','gross') as rigrossini,
									 f_getTotalRiUnit(pay.reserve_no,'SdMgIni','{$from}','{$to}') as risdmgini,
									 f_getTotalRiBayar(pay.reserve_no,'SdMgIni','{$from}','{$to}') as ribayarsdini,
									 f_getTotalTanahRi(pay.reserve_no,'SdMgIni','{$from}','{$to}','netto') as rinettosdini,
									 f_getTotalTanahRi(pay.reserve_no,'SdMgIni','{$from}','{$to}','gross') as rigrosssdini,
									 f_getTotalRiUnit(pay.reserve_no,'ThLalu','{$from}','{$to}') as rithlalu,
									 f_getTotalRiBayar(pay.reserve_no,'ThLalu','{$from}','{$to}') as ribayarthlalu,
									 f_getTotalTanahRi(pay.reserve_no,'ThLalu','{$from}','{$to}','netto') as rinettothlalu,
									 f_getTotalTanahRi(pay.reserve_no,'ThLalu','{$from}','{$to}','gross') as rigrossthlalu
											 
								FROM mst_entity mst
								LEFT JOIN tr_payment pay ON pay.kode_entity = mst.kode 
								INNER JOIN mst_unit_price upr ON upr.kode_entity = mst.kode
	                                AND upr.no_unit = pay.no_unit AND upr.grup = 'NETTO'
	                                AND upr.isactive = 1 AND upr.kode_pay = pay.kode_pay
	                            GROUP BY mst.kode, pay.no_unit
								ORDER BY mst.type_entity DESC, mst.kode ASC 
						 ) mst_ok
			) fix_data GROUP BY direktorat, kode, nama, type_entity ORDER BY direktorat ASC, type_entity DESC, nama ASC
			
			";
		//die("<pre>{$sql}</pre>");
		$q = $this->db->query($sql);
		return $q->result_array();
	}
	 
	//13-10-2015 ini function untuk OP, function untuk OK dibawah cuma belom ganti Querynya * Hardiyanto *
	//Untuk OP di tambahkan progress bangunan
	//Syarat Penjualan Landed House 
 	// 1. Jika Sudah Akad Kredit (KPR) /  Jika Sudah 100% Pembayaran (Cash Keras / Cash Bertahap)
 	// 2. Progress Bangunan 100% (Bulan 1-2-3 *25%*, Bulan 4-5-6 *50%*, Bulan 7-8-9 *75%*, Bulan 10-11-12 *100%*)
 	// 		Penjelasan : Tanggal contoh 2015-02-02, Jika Syarat ke 1 Terpenuhi Maka Syarat ke 2 harus terpenuhi walau belom 100% progress bangunan
 	// 		dengan asumsi Bulan Jan-Feb-Mar Progress bangunan sudah 25% dst.
 	//Syarat Penjualan High Rise 
 	// 1. Jika Sudah Akad Kredit (KPR) /  Jika Sudah 20% Pembayaran (Cash Keras / Cash Bertahap)
 	// 2. Progress Bangunan 10%
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
				(IF(pay.status_tr='SALES',stk.wide_netto,0)) as widenet_sales,
				(IF(pay.status_tr='SALES',stk.wide_gross,0)) as widegros_sales,
				stk.no_unit,
				pay.harga_unit,
				IF(pay.status_tr='RESERVE',1,0) as status_res,
				IF(pay.status_tr='RESERVE',SUM(paydet.rp),0) as reseve_price,
				IF(pay.status_tr='RESERVE',stk.wide_netto,0) as widenet_reserve,
				IF(pay.status_tr='RESERVE',stk.wide_gross,0) as widegros_reserve,
				IF(pay.iscancelled=1,SUM(paydet.rp),0) as pembatalan,
				(SELECT SUM(rp) FROM tr_payment_detail paydet2 WHERE paydet2.kode_pay NOT IN('RES','TJ') 
					AND paydet2.tgl_bayar IS NULL AND paydet2.no_kwitansi IS NULL AND paydet2.reserve_no=pay.reserve_no AND paydet2.tgl_tempo < '$from' )as t_ra_lalu,
				(SELECT SUM(rp) FROM tr_payment_detail paydet2 WHERE  paydet2.kode_pay NOT IN('RES','TJ') 
								AND paydet2.tgl_bayar IS NULL AND paydet2.no_kwitansi IS NULL AND paydet2.reserve_no=pay.reserve_no AND paydet2.tgl_tempo >= '$from' AND paydet2.tgl_tempo <= '$to' ) as t_ra_ini,
				(SELECT SUM(rp) FROM tr_payment_detail paydet2 WHERE  paydet2.kode_pay NOT IN('RES','TJ') 
								AND paydet2.tgl_bayar IS NULL AND paydet2.no_kwitansi IS NULL AND paydet2.reserve_no=pay.reserve_no AND paydet2.tgl_tempo > '$to' ) as t_ra_depan,
				1 AS ra_unit,
				f_getTotalRaUnit(pay.reserve_no,'MgLalu','$from','$to') as ra_unit_lalu,
				IF(f_getTotalRaUnit(pay.reserve_no,'MgLalu','$from','$to')=1,stk.wide_netto,0) as ra_unit_lwidenet,
				IF(f_getTotalRaUnit(pay.reserve_no,'MgLalu','$from','$to')=1,stk.wide_gross,0) as ra_unit_lwidegros,
				f_getTotalRaUnit(pay.reserve_no,'MgIni','$from','$to') as ra_unit_ini,
				IF(f_getTotalRaUnit(pay.reserve_no,'MgIni','$from','$to')=1,stk.wide_netto,0) as ra_unit_iwidenet,
				IF(f_getTotalRaUnit(pay.reserve_no,'MgIni','$from','$to')=1,stk.wide_gross,0) as ra_unit_iwidegros,
				f_getTotalRaUnit(pay.reserve_no,'MgDepan','$from','$to') as ra_unit_depan,
				IF(f_getTotalRaUnit(pay.reserve_no,'MgDepan','$from','$to')=1,stk.wide_netto,0) as ra_unit_dwidenet,
				IF(f_getTotalRaUnit(pay.reserve_no,'MgDepan','$from','$to')=1,stk.wide_gross,0) as ra_unit_dwidegros
			FROM
				tr_payment pay
				INNER JOIN mst_stock AS stk ON stk.no_unit = pay.no_unit
				INNER JOIN mst_entity AS ent ON ent.kode = stk.kode_entity AND ent.kode = pay.kode_entity
				INNER JOIN mst_optional_entity opent ON opent.kode = ent.type_entity
						AND opent.sfield = 'type_entity'
				INNER JOIN tr_payment_detail paydet ON paydet.reserve_no = pay.reserve_no
			WHERE
				pay.status_tr <> 'HOLD'
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
				(IF(pay.status_tr='SALES',stk.wide_netto,0)) as widenet_sales,
				(IF(pay.status_tr='SALES',stk.wide_gross,0)) as widegros_sales,
				stk.no_unit,
				pay.harga_unit,
				IF(pay.status_tr='RESERVE',1,0) as status_res,
				IF(pay.status_tr='RESERVE',SUM(paydet.rp),0) as reseve_price,
				IF(pay.status_tr='RESERVE',stk.wide_netto,0) as widenet_reserve,
				IF(pay.status_tr='RESERVE',stk.wide_gross,0) as widegros_reserve,
				IF(pay.iscancelled=1,SUM(paydet.rp),0) as pembatalan,
				(SELECT SUM(rp) FROM tr_payment_detail paydet2 WHERE paydet2.kode_pay NOT IN('RES','TJ') 
					AND paydet2.tgl_bayar IS NULL AND paydet2.no_kwitansi IS NULL AND paydet2.reserve_no=pay.reserve_no AND paydet2.tgl_tempo < '$from' )as t_ra_lalu,
				(SELECT SUM(rp) FROM tr_payment_detail paydet2 WHERE  paydet2.kode_pay NOT IN('RES','TJ') 
								AND paydet2.tgl_bayar IS NULL AND paydet2.no_kwitansi IS NULL AND paydet2.reserve_no=pay.reserve_no AND paydet2.tgl_tempo >= '$from' AND paydet2.tgl_tempo <= '$to' ) as t_ra_ini,
				(SELECT SUM(rp) FROM tr_payment_detail paydet2 WHERE  paydet2.kode_pay NOT IN('RES','TJ') 
								AND paydet2.tgl_bayar IS NULL AND paydet2.no_kwitansi IS NULL AND paydet2.reserve_no=pay.reserve_no AND paydet2.tgl_tempo > '$to' ) as t_ra_depan,
				1 AS ra_unit,
				f_getTotalRaUnit(pay.reserve_no,'MgLalu','$from','$to') as ra_unit_lalu,
				IF(f_getTotalRaUnit(pay.reserve_no,'MgLalu','$from','$to')=1,stk.wide_netto,0) as ra_unit_lwidenet,
				IF(f_getTotalRaUnit(pay.reserve_no,'MgLalu','$from','$to')=1,stk.wide_gross,0) as ra_unit_lwidegros,
				f_getTotalRaUnit(pay.reserve_no,'MgIni','$from','$to') as ra_unit_ini,
				IF(f_getTotalRaUnit(pay.reserve_no,'MgIni','$from','$to')=1,stk.wide_netto,0) as ra_unit_iwidenet,
				IF(f_getTotalRaUnit(pay.reserve_no,'MgIni','$from','$to')=1,stk.wide_gross,0) as ra_unit_iwidegros,
				f_getTotalRaUnit(pay.reserve_no,'MgDepan','$from','$to') as ra_unit_depan,
				IF(f_getTotalRaUnit(pay.reserve_no,'MgDepan','$from','$to')=1,stk.wide_netto,0) as ra_unit_dwidenet,
				IF(f_getTotalRaUnit(pay.reserve_no,'MgDepan','$from','$to')=1,stk.wide_gross,0) as ra_unit_dwidegros
			FROM
				tr_payment pay
				INNER JOIN mst_stock AS stk ON stk.no_unit = pay.no_unit
				INNER JOIN mst_entity AS ent ON ent.kode = stk.kode_entity AND ent.kode = pay.kode_entity
				INNER JOIN mst_optional_entity opent ON opent.kode = ent.type_entity
						AND opent.sfield = 'type_entity'
				INNER JOIN tr_payment_detail paydet ON paydet.reserve_no = pay.reserve_no
			WHERE
				pay.status_tr <> 'HOLD'
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
				(IF(pay.status_tr='SALES',stk.wide_netto,0)) as widenet_sales,
				(IF(pay.status_tr='SALES',stk.wide_gross,0)) as widegros_sales,
				stk.no_unit,
				pay.harga_unit,
				IF(pay.status_tr='RESERVE',1,0) as status_res,
				IF(pay.status_tr='RESERVE',SUM(paydet.rp),0) as reseve_price,
				IF(pay.status_tr='RESERVE',stk.wide_netto,0) as widenet_reserve,
				IF(pay.status_tr='RESERVE',stk.wide_gross,0) as widegros_reserve,
				IF(pay.iscancelled=1,SUM(paydet.rp),0) as pembatalan,
				(SELECT SUM(rp) FROM tr_payment_detail paydet2 WHERE paydet2.kode_pay NOT IN('RES','TJ') 
					AND paydet2.tgl_bayar IS NULL AND paydet2.no_kwitansi IS NULL AND paydet2.reserve_no=pay.reserve_no AND paydet2.tgl_tempo < '$from' )as t_ra_lalu,
				(SELECT SUM(rp) FROM tr_payment_detail paydet2 WHERE  paydet2.kode_pay NOT IN('RES','TJ') 
								AND paydet2.tgl_bayar IS NULL AND paydet2.no_kwitansi IS NULL AND paydet2.reserve_no=pay.reserve_no AND paydet2.tgl_tempo >= '$from' AND paydet2.tgl_tempo <= '$to' ) as t_ra_ini,
				(SELECT SUM(rp) FROM tr_payment_detail paydet2 WHERE  paydet2.kode_pay NOT IN('RES','TJ') 
								AND paydet2.tgl_bayar IS NULL AND paydet2.no_kwitansi IS NULL AND paydet2.reserve_no=pay.reserve_no AND paydet2.tgl_tempo > '$to' ) as t_ra_depan,
				1 AS ra_unit,
				f_getTotalRaUnit(pay.reserve_no,'MgLalu','$from','$to') as ra_unit_lalu,
				IF(f_getTotalRaUnit(pay.reserve_no,'MgLalu','$from','$to')=1,stk.wide_netto,0) as ra_unit_lwidenet,
				IF(f_getTotalRaUnit(pay.reserve_no,'MgLalu','$from','$to')=1,stk.wide_gross,0) as ra_unit_lwidegros,
				f_getTotalRaUnit(pay.reserve_no,'MgIni','$from','$to') as ra_unit_ini,
				IF(f_getTotalRaUnit(pay.reserve_no,'MgIni','$from','$to')=1,stk.wide_netto,0) as ra_unit_iwidenet,
				IF(f_getTotalRaUnit(pay.reserve_no,'MgIni','$from','$to')=1,stk.wide_gross,0) as ra_unit_iwidegros,
				f_getTotalRaUnit(pay.reserve_no,'MgDepan','$from','$to') as ra_unit_depan,
				IF(f_getTotalRaUnit(pay.reserve_no,'MgDepan','$from','$to')=1,stk.wide_netto,0) as ra_unit_dwidenet,
				IF(f_getTotalRaUnit(pay.reserve_no,'MgDepan','$from','$to')=1,stk.wide_gross,0) as ra_unit_dwidegros
			FROM
				tr_payment pay
				INNER JOIN mst_stock AS stk ON stk.no_unit = pay.no_unit
				INNER JOIN mst_entity AS ent ON ent.kode = stk.kode_entity AND ent.kode = pay.kode_entity
				INNER JOIN mst_optional_entity opent ON opent.kode = ent.type_entity
						AND opent.sfield = 'type_entity'
				INNER JOIN tr_payment_detail paydet ON paydet.reserve_no = pay.reserve_no
			WHERE
				pay.status_tr <> 'HOLD'
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
				(IF(pay.status_tr='SALES',stk.wide_netto,0)) as widenet_sales,
				(IF(pay.status_tr='SALES',stk.wide_gross,0)) as widegros_sales,
				stk.no_unit,
				pay.harga_unit,
				IF(pay.status_tr='RESERVE',1,0) as status_res,
				IF(pay.status_tr='RESERVE',SUM(paydet.rp),0) as reseve_price,
				IF(pay.status_tr='RESERVE',stk.wide_netto,0) as widenet_reserve,
				IF(pay.status_tr='RESERVE',stk.wide_gross,0) as widegros_reserve,
				IF(pay.iscancelled=1,SUM(paydet.rp),0) as pembatalan,
				(SELECT SUM(rp) FROM tr_payment_detail paydet2 WHERE paydet2.kode_pay NOT IN('RES','TJ') 
					AND paydet2.tgl_bayar IS NULL AND paydet2.no_kwitansi IS NULL AND paydet2.reserve_no=pay.reserve_no AND paydet2.tgl_tempo < '$from' )as t_ra_lalu,
				(SELECT SUM(rp) FROM tr_payment_detail paydet2 WHERE  paydet2.kode_pay NOT IN('RES','TJ') 
								AND paydet2.tgl_bayar IS NULL AND paydet2.no_kwitansi IS NULL AND paydet2.reserve_no=pay.reserve_no AND paydet2.tgl_tempo >= '$from' AND paydet2.tgl_tempo <= '$to' ) as t_ra_ini,
				(SELECT SUM(rp) FROM tr_payment_detail paydet2 WHERE  paydet2.kode_pay NOT IN('RES','TJ') 
								AND paydet2.tgl_bayar IS NULL AND paydet2.no_kwitansi IS NULL AND paydet2.reserve_no=pay.reserve_no AND paydet2.tgl_tempo > '$to' ) as t_ra_depan,
				1 AS ra_unit,
				f_getTotalRaUnit(pay.reserve_no,'MgLalu','$from','$to') as ra_unit_lalu,
				IF(f_getTotalRaUnit(pay.reserve_no,'MgLalu','$from','$to')=1,stk.wide_netto,0) as ra_unit_lwidenet,
				IF(f_getTotalRaUnit(pay.reserve_no,'MgLalu','$from','$to')=1,stk.wide_gross,0) as ra_unit_lwidegros,
				f_getTotalRaUnit(pay.reserve_no,'MgIni','$from','$to') as ra_unit_ini,
				IF(f_getTotalRaUnit(pay.reserve_no,'MgIni','$from','$to')=1,stk.wide_netto,0) as ra_unit_iwidenet,
				IF(f_getTotalRaUnit(pay.reserve_no,'MgIni','$from','$to')=1,stk.wide_gross,0) as ra_unit_iwidegros,
				f_getTotalRaUnit(pay.reserve_no,'MgDepan','$from','$to') as ra_unit_depan,
				IF(f_getTotalRaUnit(pay.reserve_no,'MgDepan','$from','$to')=1,stk.wide_netto,0) as ra_unit_dwidenet,
				IF(f_getTotalRaUnit(pay.reserve_no,'MgDepan','$from','$to')=1,stk.wide_gross,0) as ra_unit_dwidegros
				
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
		//die("<pre>{$sql}</pre>");
		$q = $this->db->query($sql);
		$data = array();
		foreach ($q->result_array() as $k => $v) {
			if(!isset($data[$v['type_entity']][$v['nama']]['unit'][$v['scol']])) {
				// ri > 5%
				$data[$v['type_entity']][$v['nama']]['unit'][$v['scol']] 		= 0;
				$data[$v['type_entity']][$v['nama']]['netto'][$v['scol']] 		= 0;
				$data[$v['type_entity']][$v['nama']]['gross'][$v['scol']] 		= 0;
				$data[$v['type_entity']][$v['nama']]['rp'][$v['scol']] 			= 0;
				$data[$v['type_entity']][$v['nama']]['resvr'][$v['scol']] 		= 0;
				$data[$v['type_entity']][$v['nama']]['resvr_price'][$v['scol']] = 0;
				$data[$v['type_entity']][$v['nama']]['netto_rsv'][$v['scol']] 	= 0;
				$data[$v['type_entity']][$v['nama']]['gross_rsv'][$v['scol']] 	= 0;
				$data[$v['type_entity']][$v['nama']]['canceled'][$v['scol']] 	= 0;
				$data[$v['type_entity']][$v['nama']]['ra_lalu'][$v['scol']] 	= 0;
				$data[$v['type_entity']][$v['nama']]['ra_ini'][$v['scol']] 		= 0;
				$data[$v['type_entity']][$v['nama']]['ra_depan'][$v['scol']] 	= 0;
				$data[$v['type_entity']][$v['nama']]['ra_unit'][$v['scol']] 	= 0;
				$data[$v['type_entity']][$v['nama']]['ra_unit_lalu'][$v['scol']] 	= 0;
				$data[$v['type_entity']][$v['nama']]['ra_l_wn'][$v['scol']]	= 0;
				$data[$v['type_entity']][$v['nama']]['ra_l_wg'][$v['scol']]	= 0;
				$data[$v['type_entity']][$v['nama']]['ra_i_wn'][$v['scol']]	= 0;
				$data[$v['type_entity']][$v['nama']]['ra_i_wg'][$v['scol']]	= 0;
				$data[$v['type_entity']][$v['nama']]['ra_unit_ini'][$v['scol']] 	= 0;
				$data[$v['type_entity']][$v['nama']]['ra_unit_depan'][$v['scol']] 	= 0;
				// ri <= 5%
				$data[$v['type_entity']][$v['nama']]['unit']['N'] 				= 0;
				$data[$v['type_entity']][$v['nama']]['netto']['N'] 				= 0;
				$data[$v['type_entity']][$v['nama']]['gross']['N'] 				= 0;
				$data[$v['type_entity']][$v['nama']]['rp']['N'] 				= 0;
				$data[$v['type_entity']][$v['nama']]['resvr']['N'] 				= 0;
				$data[$v['type_entity']][$v['nama']]['resvr_price']['N'] 		= 0;
				$data[$v['type_entity']][$v['nama']]['netto_rsv']['N'] 			= 0;
				$data[$v['type_entity']][$v['nama']]['gross_rsv']['N'] 			= 0;
				$data[$v['type_entity']][$v['nama']]['canceled']['N'] 			= 0;
				$data[$v['type_entity']][$v['nama']]['ra_unit']['N'] 			= 0;
				$data[$v['type_entity']][$v['nama']]['ra_lalu']['N'] 			= 0;
				$data[$v['type_entity']][$v['nama']]['ra_ini']['N'] 			= 0;
				$data[$v['type_entity']][$v['nama']]['ra_depan']['N'] 			= 0;
				$data[$v['type_entity']][$v['nama']]['ra_unit_lalu']['N'] 		= 0;
				$data[$v['type_entity']][$v['nama']]['ra_l_wn']['N'] 	= 0;
				$data[$v['type_entity']][$v['nama']]['ra_l_wg']['N'] 	= 0;
				$data[$v['type_entity']][$v['nama']]['ra_i_wn']['N'] 	= 0;
				$data[$v['type_entity']][$v['nama']]['ra_i_wg']['N'] 	= 0;
				$data[$v['type_entity']][$v['nama']]['ra_unit_ini']['N'] 		= 0;
				$data[$v['type_entity']][$v['nama']]['ra_unit_depan']['N'] 		= 0;
			}
			$diff = $v['rp'] / $v['harga_unit'] * 100;
			if($v['scol']!=='H' AND $v['scol']!=='J') {

				if($diff >= 5) {
					$data[$v['type_entity']][$v['nama']]['unit'][$v['scol']] 		+= $v['n_unit'];
					$data[$v['type_entity']][$v['nama']]['netto'][$v['scol']] 		+= $v['widenet_sales'];
					$data[$v['type_entity']][$v['nama']]['gross'][$v['scol']] 		+= $v['widegros_sales'];
					$data[$v['type_entity']][$v['nama']]['rp'][$v['scol']] 			+= $v['rp'];
					$data[$v['type_entity']][$v['nama']]['resvr'][$v['scol']] 		+= $v['status_res'];
					$data[$v['type_entity']][$v['nama']]['resvr_price'][$v['scol']]	+= $v['reseve_price'];
					$data[$v['type_entity']][$v['nama']]['netto_rsv'][$v['scol']] 	+= $v['widenet_reserve'];
					$data[$v['type_entity']][$v['nama']]['gross_rsv'][$v['scol']] 	+= $v['widegros_reserve'];
					$data[$v['type_entity']][$v['nama']]['canceled'][$v['scol']] 	+= $v['pembatalan'];
					$data[$v['type_entity']][$v['nama']]['ra_lalu'][$v['scol']] 	+= $v['t_ra_lalu'];
					$data[$v['type_entity']][$v['nama']]['ra_ini'][$v['scol']] 		+= $v['t_ra_ini'];
					$data[$v['type_entity']][$v['nama']]['ra_depan'][$v['scol']] 	+= $v['t_ra_depan'];
					$data[$v['type_entity']][$v['nama']]['canceled'][$v['scol']] 	+= $v['pembatalan'];
					$data[$v['type_entity']][$v['nama']]['ra_unit_lalu'][$v['scol']] 	+= $v['ra_unit_lalu'];
					$data[$v['type_entity']][$v['nama']]['ra_l_wn'][$v['scol']]	+= $v['ra_unit_lwidenet'];
					$data[$v['type_entity']][$v['nama']]['ra_l_wg'][$v['scol']]	+= $v['ra_unit_lwidegros'];
					$data[$v['type_entity']][$v['nama']]['ra_i_wn'][$v['scol']]	+= $v['ra_unit_iwidenet'];
					$data[$v['type_entity']][$v['nama']]['ra_i_wg'][$v['scol']]	+= $v['ra_unit_iwidegros'];
					$data[$v['type_entity']][$v['nama']]['ra_unit_ini'][$v['scol']] 	+= $v['ra_unit_ini'];
					$data[$v['type_entity']][$v['nama']]['ra_unit_depan'][$v['scol']] 	+= $v['ra_unit_depan']; 
					$data[$v['type_entity']][$v['nama']]['ra_unit'][$v['scol']] 		+= $v['ra_unit'];
					
				} else {
					$data[$v['type_entity']][$v['nama']]['unit']['N'] 				+= $v['n_unit'];
					$data[$v['type_entity']][$v['nama']]['netto']['N'] 				+= $v['widenet_sales'];
					$data[$v['type_entity']][$v['nama']]['gross']['N'] 				+= $v['widegros_sales'];
					$data[$v['type_entity']][$v['nama']]['rp']['N'] 				+= $v['rp'];
					$data[$v['type_entity']][$v['nama']]['resvr']['N'] 				+= $v['status_res'];
					$data[$v['type_entity']][$v['nama']]['resvr_price']['N'] 		+= $v['reseve_price'];
					$data[$v['type_entity']][$v['nama']]['netto_rsv']['N'] 			+= $v['widenet_reserve'];
					$data[$v['type_entity']][$v['nama']]['gross_rsv']['N'] 			+= $v['widegros_reserve'];
					$data[$v['type_entity']][$v['nama']]['canceled']['N']  			+= $v['pembatalan'];
					$data[$v['type_entity']][$v['nama']]['ra_lalu']['N']  			+= $v['t_ra_lalu'];
					$data[$v['type_entity']][$v['nama']]['ra_ini']['N'] 			+= $v['t_ra_ini'];
					$data[$v['type_entity']][$v['nama']]['ra_depan']['N']  			+= $v['t_ra_depan'];
					$data[$v['type_entity']][$v['nama']]['ra_unit_lalu']['N']  		+= $v['ra_unit_lalu'];
					$data[$v['type_entity']][$v['nama']]['ra_l_wn']['N']			+= $v['ra_unit_lwidenet'];
					$data[$v['type_entity']][$v['nama']]['ra_l_wg']['N']			+= $v['ra_unit_lwidegros'];
					$data[$v['type_entity']][$v['nama']]['ra_i_wn']['N']			+= $v['ra_unit_iwidenet'];
					$data[$v['type_entity']][$v['nama']]['ra_i_wg']['N']			+= $v['ra_unit_iwidegros'];
					$data[$v['type_entity']][$v['nama']]['ra_unit_ini']['N']  		+= $v['ra_unit_ini'];
					$data[$v['type_entity']][$v['nama']]['ra_unit_depan']['N']  	+= $v['ra_unit_depan'];
					$data[$v['type_entity']][$v['nama']]['ra_unit']['N'] 			+= $v['ra_unit'];
				} 

			} else {
				$data[$v['type_entity']][$v['nama']]['unit'][$v['scol']] 			+= $v['n_unit'];
				$data[$v['type_entity']][$v['nama']]['netto'][$v['scol']] 			+= $v['widenet_sales'];
				$data[$v['type_entity']][$v['nama']]['gross'][$v['scol']] 			+= $v['widegros_sales'];
				$data[$v['type_entity']][$v['nama']]['rp'][$v['scol']] 				+= $v['rp'];
				$data[$v['type_entity']][$v['nama']]['resvr'][$v['scol']] 			+= $v['status_res'];
				$data[$v['type_entity']][$v['nama']]['resvr_price'][$v['scol']] 	+= $v['reseve_price'];
				$data[$v['type_entity']][$v['nama']]['netto_rsv'][$v['scol']] 		+= $v['widenet_reserve'];
				$data[$v['type_entity']][$v['nama']]['gross_rsv'][$v['scol']] 		+= $v['widegros_reserve'];
				$data[$v['type_entity']][$v['nama']]['canceled'][$v['scol']] 		+= $v['pembatalan'];
				$data[$v['type_entity']][$v['nama']]['ra_lalu'][$v['scol']] 		+= $v['t_ra_lalu'];
				$data[$v['type_entity']][$v['nama']]['ra_ini'][$v['scol']] 			+= $v['t_ra_ini'];
				$data[$v['type_entity']][$v['nama']]['ra_depan'][$v['scol']] 		+= $v['t_ra_depan'];
				$data[$v['type_entity']][$v['nama']]['ra_unit_lalu'][$v['scol']] 	+= $v['ra_unit_lalu'];
				$data[$v['type_entity']][$v['nama']]['ra_l_wn'][$v['scol']]			+= $v['ra_unit_lwidenet'];
				$data[$v['type_entity']][$v['nama']]['ra_l_wg'][$v['scol']]			+= $v['ra_unit_lwidegros'];
				$data[$v['type_entity']][$v['nama']]['ra_i_wn'][$v['scol']]			+= $v['ra_unit_iwidenet'];
				$data[$v['type_entity']][$v['nama']]['ra_i_wg'][$v['scol']]			+= $v['ra_unit_iwidegros'];
				$data[$v['type_entity']][$v['nama']]['ra_unit_ini'][$v['scol']] 	+= $v['ra_unit_ini'];
				$data[$v['type_entity']][$v['nama']]['ra_unit_depan'][$v['scol']] 	+= $v['ra_unit_depan'];
				$data[$v['type_entity']][$v['nama']]['ra_unit'][$v['scol']] 		+= $v['ra_unit'];
			}
		}
		//var_dump($data);die;
		return $data;
	}
    
    /*
    **  adesr -> generate report OP
    **  syarat diakui OP:
    **  HR:
    **  -  progress bangunan >= progress minimal per entity (mst_entity=>progress_pondasi)
    **  -  Ri. Bayar >= 20%, jika Ri. bayar < 5% masuk ke reserve
    **  LD:
    **  -  progress bangunan >= progress minimal sesuai periode bln (1-3=>20%, 4-6=>40%, 7-9=>60%, 10-12=>80%)
    **  -  utk CK/CB Ri bayar = 100%, utk KPR/KPA Ri bayar >= 5% & sudah akad kredit
    */
    function gen_rpt_op_rev1($from, $to) {
        $data = array();
        // HR
        $sql = "
            							SELECT
								direktorat,
								type_entity,
								nama,
								_kode,
								_min_progress,
								no_unit,
								cara_bayar,
								tgl_ri_akad,
								p_ri,
								SUM(CASE WHEN n_unit_lalu = 1 THEN 0 ELSE n_unit END) AS n_unit,
								SUM(CASE WHEN n_unit_lalu = 1 THEN 0 ELSE wide_gross END) AS wide_gross,
								SUM(CASE WHEN n_unit_lalu = 1 THEN 0 ELSE wide_netto END) AS wide_netto,
								SUM(CASE WHEN n_unit_lalu = 1 THEN 0 ELSE netto END) AS netto,
								SUM(n_unit_r) AS n_unit_r,
								SUM(wide_gross_r) AS wide_gross_r,
								SUM(wide_netto_r) AS wide_netto_r,
								SUM(netto_r) AS netto_r,
								SUM(n_unit_lalu) AS n_unit_lalu,
								SUM(wide_gross_lalu) AS wide_gross_lalu,
								SUM(wide_netto_lalu) AS wide_netto_lalu,
								SUM(netto_lalu) AS netto_lalu,
								SUM(netto_pr) AS netto_pr,
								SUM(netto_pr_r) AS netto_pr_r,
								SUM(netto_pr_lalu) AS netto_pr_lalu
							FROM	(
								SELECT
									direktorat,
									type_entity,
									nama,
									_kode,
									_min_progress,
									no_unit,
									cara_bayar,
									tgl_ri_akad,
									p_ri,
									SUM(n_unit) AS n_unit,
									SUM(wide_gross) AS wide_gross,
									SUM(wide_netto) AS wide_netto,
									SUM(netto) AS netto,
									SUM(n_unit_r) AS n_unit_r,
									SUM(wide_gross_r) AS wide_gross_r,
									SUM(wide_netto_r) AS wide_netto_r,
									SUM(netto_r) AS netto_r,
									SUM(n_unit_lalu) AS n_unit_lalu,
									SUM(wide_gross_lalu) AS wide_gross_lalu,
									SUM(wide_netto_lalu) AS wide_netto_lalu,
									SUM(netto_lalu) AS netto_lalu,
									SUM(netto_pr) AS netto_pr,
									SUM(netto_pr_r) AS netto_pr_r,
									SUM(netto_pr_lalu) AS netto_pr_lalu
								FROM (
									SELECT
                    @tgl_1 := '$from' AS _tgl_1,
                    @tgl_2 := '$to' AS _tgl_2,
                    e.direktorat,
                    e.type_entity,
                    e.nama,
                    @ent := e.kode AS _kode,
                    @prog := e.progress_pondasi AS
 _min_progress,
                    IFNULL(ld.no_unit,'') AS no_unit,
                    IFNULL(ld.cara_bayar,'') AS cara_bayar,
                    IFNULL(ld.tgl_ri_akad,'') AS tgl_ri_akad,
                    IFNULL(ld.p_ri,0) AS p_ri,
                    CASE WHEN ld.p_ri >= 20 THEN 1
 ELSE 0 END AS n_unit,
                    IFNULL(CASE WHEN ld.p_ri >= 20
 THEN ld.wide_gross ELSE 0 END,0) AS wide_gross,
                    IFNULL(CASE WHEN ld.p_ri >= 20
 THEN ld.wide_netto ELSE 0 END,0) AS wide_netto,
                    IFNULL(CASE WHEN ld.p_ri >= 20
 THEN ld.netto ELSE 0 END,0) AS netto,
                    CASE WHEN ld.p_ri < 5 THEN 1 ELSE 0 END AS n_unit_r,
                    IFNULL(CASE WHEN ld.p_ri < 5 THEN ld.wide_gross ELSE 0 END,0) AS wide_gross_r,
                    IFNULL(CASE WHEN ld.p_ri < 5 THEN ld.wide_netto ELSE 0 END,0) AS wide_netto_r,
                    IFNULL(CASE WHEN ld.p_ri < 5 THEN ld.netto ELSE 0 END,0) AS netto_r,
                    0 AS n_unit_lalu,
                    0 AS wide_gross_lalu,
                    0 AS wide_netto_lalu,
                    0 AS netto_lalu,
                    IFNULL(CASE WHEN ld.p_ri >= 20
 THEN ld.netto*ld.p_pr ELSE 0 END,0) AS netto_pr,
					IFNULL(CASE WHEN ld.p_ri < 5 THEN ld.netto*ld.p_pr ELSE 0 END,0) AS netto_pr_r,
					0 AS netto_pr_lalu
                FROM
                    mst_entity e
                    LEFT JOIN (
                        SELECT
                            s1.kode_entity AS kode,
                            s1.no_unit,	
                            ri1.cara_bayar,
                            ri1.tgl_ri_akad,
                            ri1.p_ri,
                            s1.wide_gross,
                            s1.wide_netto,
                            SUM(upr1.rp) AS netto,
                            pr1.persen_progress AS p_pr
                        FROM
                            mst_stock s1
                            INNER JOIN (
                                SELECT
                                    pay11.kode_entity,
                                    pay11.no_unit,
                                    pay11.cara_bayar,
                                    pay11.kode_pay,
                                    tgl_ri_akad,
                                    SUM(paydet11.rp)/pay11.harga_unit*100 AS p_ri
                                FROM
                                    tr_payment pay11
                                    INNER JOIN tr_payment_detail paydet11 ON paydet11.reserve_no = pay11
.reserve_no
                                WHERE
                                    pay11.kode_entity = @ent
                                    AND pay11.reserve_no IN (
                                        SELECT
                                            DISTINCT pay111.reserve_no
                                        FROM
                                            tr_payment pay111
                                            INNER JOIN tr_payment_detail paydet111 ON paydet111.reserve_no
 = pay111.reserve_no
                                        WHERE
                                            pay111.kode_entity = @ent
                                            AND paydet111.tgl_bayar >= @tgl_1
                                            AND paydet111.tgl_bayar <= @tgl_2
                                    )
                                    AND	paydet11.tgl_bayar <= @tgl_2
                                    AND pay11.iscancelled = 0
                                GROUP BY
                                    pay11.kode_entity,
                                    pay11.no_unit
                                HAVING
                                    p_ri >= 20

                            ) AS ri1 ON ri1.kode_entity = s1.kode_entity
                                and ri1.no_unit = s1.no_unit
                            LEFT JOIN (
                                SELECT
                                    pr11.kode_entity,
                                    pr11.no_unit,
                                    pr11.persen_progress
                                FROM
                                    tr_progress pr11
                                WHERE
                                    pr11.kode_entity = @ent
                                    AND pr11.tgl_progress <= @tgl_2
                                    AND pr11.persen_progress >= @prog
                                GROUP BY
                                    pr11.kode_entity,
                                    pr11.no_unit
                                ORDER BY
                                    pr11.tgl_progress DESC
                            ) AS pr1 ON pr1.kode_entity = s1.kode_entity
                                and pr1.no_unit = s1.no_unit
                            INNER JOIN mst_unit_price upr1 ON upr1.kode_entity = s1.kode_entity
                                AND upr1.no_unit = s1.no_unit AND upr1.grup = 'NETTO'
                                AND upr1.isactive = 1 AND upr1.kode_pay = ri1.kode_pay
                        GROUP BY
                            s1.kode_entity,
                            s1.no_unit
                    ) AS ld ON ld.kode = e.kode
                WHERE
                    e.type_entity = 'HR'
								UNION ALL
                SELECT
                    @tgl_1 := '$from' AS _tgl_1,
                    @tgl_2 := '$to' AS _tgl_2,
                    e.direktorat,
                    e.type_entity,
                    e.nama,
                    @ent := e.kode AS _kode,
                    @prog := e.progress_pondasi AS
 _min_progress,
                    IFNULL(ld.no_unit,'') AS no_unit,
                    IFNULL(ld.cara_bayar,'') AS cara_bayar,
                    IFNULL(ld.tgl_ri_akad,'') AS tgl_ri_akad,
                    IFNULL(ld.p_ri,0) AS p_ri,
                    0 AS n_unit,
                    0 AS wide_gross,
                    0 AS wide_netto,
                    0 AS netto,
                    0 AS n_unit_r,
                    0 AS wide_gross_r,
                    0 AS wide_netto_r,
                    0 AS netto_r,
                    CASE WHEN ld.p_ri >= 20 THEN 1
 ELSE 0 END AS n_unit_lalu,
				    IFNULL(CASE WHEN ld.p_ri >= 20 THEN ld.wide_gross
 ELSE 0 END,0) AS wide_gross_lalu,
                    IFNULL(CASE WHEN ld.p_ri >= 20
 THEN ld.wide_netto ELSE 0 END,0) AS wide_netto_lalu,
                    IFNULL(CASE WHEN ld.p_ri >= 20
 THEN ld.netto ELSE 0 END,0) AS netto_lalu,
                    0 AS netto_pr,
					0 AS netto_pr_r,
					IFNULL(CASE WHEN ld.p_ri >= 20
 THEN ld.netto*ld.p_pr ELSE 0 END,0) AS netto_pr_lalu
                FROM
                    mst_entity e
                    LEFT JOIN (
                        SELECT
                            s1.kode_entity AS kode,
                            s1.no_unit,	
                            ri1.cara_bayar,
                            ri1.tgl_ri_akad,
                            ri1.p_ri,
                            s1.wide_gross,
                            s1.wide_netto,
                            SUM(upr1.rp) AS netto,
                            pr1.persen_progress AS p_pr
                        FROM
                            mst_stock s1
                            INNER JOIN (
                                SELECT
                                    pay11.kode_entity,
                                    pay11.no_unit,
                                    pay11.cara_bayar,
                                    pay11.kode_pay,
                                    tgl_ri_akad,
                                    SUM(paydet11.rp)/pay11.harga_unit*100 AS p_ri
                                FROM
                                    tr_payment pay11
                                    INNER JOIN tr_payment_detail paydet11 ON paydet11.reserve_no = pay11
.reserve_no
                                WHERE
                                    pay11.kode_entity = @ent
                                    AND	paydet11.tgl_bayar < @tgl_1
                                    AND pay11.iscancelled = 0
                                GROUP BY
                                    pay11.kode_entity,
                                    pay11.no_unit
                                HAVING
                                    p_ri >= 20

                            ) AS ri1 ON ri1.kode_entity = s1.kode_entity
                                and ri1.no_unit = s1.no_unit
                            LEFT JOIN (
                                SELECT
                                    pr11.kode_entity,
                                    pr11.no_unit,
                                    pr11.persen_progress
                                FROM
                                    tr_progress pr11
                                WHERE
                                    pr11.kode_entity = @ent
                                    AND pr11.tgl_progress < @tgl_1
                                    AND pr11.persen_progress >= @prog
                                GROUP BY
                                    pr11.kode_entity,
                                    pr11.no_unit
                                ORDER BY
                                    pr11.tgl_progress DESC
                            ) AS pr1 ON pr1.kode_entity = s1.kode_entity
                                and pr1.no_unit = s1.no_unit
                            INNER JOIN mst_unit_price upr1 ON upr1.kode_entity = s1.kode_entity
                                AND upr1.no_unit = s1.no_unit AND upr1.grup = 'NETTO'
                                AND upr1.isactive = 1 AND upr1.kode_pay = ri1.kode_pay
                        GROUP BY
                            s1.kode_entity,
                            s1.no_unit
                    ) AS ld ON ld.kode = e.kode
                WHERE
                    e.type_entity = 'HR'
							) AS tmp
							GROUP BY
								direktorat,
								type_entity,
								_kode,
								no_unit
						) AS tmp
						GROUP BY
							direktorat,
							type_entity,
							_kode
        ";
        $qHR = $this->db->query($sql);
        $qHR = $this->db->query($sql);
        $resHR = $qHR->result_array();
        foreach($resHR as $v) {
            $item = array(
                array('- Unit', $v['n_unit_lalu'], $v['n_unit'], $v['n_unit_r']),
                array('- Luas Netto', $v['wide_netto_lalu'], $v['wide_netto'], $v['wide_netto_r']),
                array('- Luas Gross', $v['wide_gross_lalu'], $v['wide_gross'], $v['wide_gross_r']),
                array('- Omzet', $v['netto_pr_lalu'], $v['netto_pr'], $v['netto_pr_r']),
            );
            $data[$v['direktorat']==='DIR1'?'Direktorat I':'Direktorat II']['High Rise'][] = array(
                $v['nama'],
                $item
            );
        }
        // landed
        $sql = "
            SELECT
                direktorat,
                type_entity,
                nama,
                _kode,
                _min_progress,
                no_unit,
                cara_bayar,
                tgl_ri_akad,
                p_ri,
                SUM(CASE WHEN n_unit_lalu = 1 THEN 0 ELSE n_unit END) AS n_unit,
                SUM(CASE WHEN n_unit_lalu = 1 THEN 0 ELSE wide_gross END) AS wide_gross,
                SUM(CASE WHEN n_unit_lalu = 1 THEN 0 ELSE wide_netto END) AS wide_netto,
                SUM(CASE WHEN n_unit_lalu = 1 THEN 0 ELSE netto END) AS netto,
                SUM(n_unit_r) AS n_unit_r,
                SUM(wide_gross_r) AS wide_gross_r,
                SUM(wide_netto_r) AS wide_netto_r,
                SUM(netto_r) AS netto_r,
                SUM(n_unit_lalu) AS n_unit_lalu,
                SUM(wide_gross_lalu) AS wide_gross_lalu,
                SUM(wide_netto_lalu) AS wide_netto_lalu,
                SUM(netto_lalu) AS netto_lalu,
				SUM(netto_pr) AS netto_pr,
				SUM(netto_pr_r) AS netto_pr_r,
				SUM(netto_pr_lalu) AS netto_pr_lalu
            FROM (
                SELECT
                    direktorat,
                    type_entity,
                    nama,
                    _kode,
                    _min_progress,
                    no_unit,
                    cara_bayar,
                    tgl_ri_akad,
                    p_ri,
                    SUM(n_unit) AS n_unit,
                    SUM(wide_gross) AS wide_gross,
                    SUM(wide_netto) AS wide_netto,
                    SUM(netto) AS netto,
                    SUM(n_unit_r) AS n_unit_r,
                    SUM(wide_gross_r) AS wide_gross_r,
                    SUM(wide_netto_r) AS wide_netto_r,
                    SUM(netto_r) AS netto_r,
                    SUM(n_unit_lalu) AS n_unit_lalu,
                    SUM(wide_gross_lalu) AS wide_gross_lalu,
                    SUM(wide_netto_lalu) AS wide_netto_lalu,
                    SUM(netto_lalu) AS netto_lalu,
					SUM(netto_pr) AS netto_pr,
					SUM(netto_pr_r) AS netto_pr_r,
					SUM(netto_pr_lalu) AS netto_pr_lalu
                FROM (
                    SELECT
                        @tgl_1 := '$from' AS _tgl_1,
                        @tgl_2 := '$to' AS _tgl_2,
                        e.direktorat,
                        e.type_entity,
                        e.nama,
                        @ent := e.kode AS _kode,
                        (SELECT @prog := progress FROM mst_progress_landed WHERE bln = MONTH(@tgl_1)) AS
     _min_progress,
                        IFNULL(ld.no_unit,'') AS no_unit,
                        IFNULL(ld.cara_bayar,'') AS cara_bayar,
                        IFNULL(ld.tgl_ri_akad,'') AS tgl_ri_akad,
                        IFNULL(ld.p_ri,0) AS p_ri,
                        CASE WHEN ld.p_ri >= CASE WHEN ld.cara_bayar='KPRKPA' THEN 5 ELSE 100 END THEN 1
     ELSE 0 END AS n_unit,
                        IFNULL(CASE WHEN ld.p_ri >= CASE WHEN ld.cara_bayar='KPRKPA' THEN 5 ELSE 100 END
     THEN ld.wide_gross ELSE 0 END,0) AS wide_gross,
                        IFNULL(CASE WHEN ld.p_ri >= CASE WHEN ld.cara_bayar='KPRKPA' THEN 5 ELSE 100 END
     THEN ld.wide_netto ELSE 0 END,0) AS wide_netto,
                        IFNULL(CASE WHEN ld.p_ri >= CASE WHEN ld.cara_bayar='KPRKPA' THEN 5 ELSE 100 END
     THEN ld.netto ELSE 0 END,0) AS netto,
                        CASE WHEN ld.p_ri < 5 THEN 1 ELSE 0 END AS n_unit_r,
                        IFNULL(CASE WHEN ld.p_ri < 5 THEN ld.wide_gross ELSE 0 END,0) AS wide_gross_r,
                        IFNULL(CASE WHEN ld.p_ri < 5 THEN ld.wide_netto ELSE 0 END,0) AS wide_netto_r,
                        IFNULL(CASE WHEN ld.p_ri < 5 THEN ld.netto ELSE 0 END,0) AS netto_r,
                        0 AS n_unit_lalu,
                        0 AS wide_gross_lalu,
                        0 AS wide_netto_lalu,
                        0 AS netto_lalu,
	                    IFNULL(CASE WHEN ld.p_ri >= CASE WHEN ld.cara_bayar='KPRKPA' THEN 5 ELSE 100 END
	 THEN ld.netto*ld.p_pr ELSE 0 END,0) AS netto_pr,
						IFNULL(CASE WHEN ld.p_ri < 5 THEN ld.netto*ld.p_pr ELSE 0 END,0) AS netto_pr_r,
						0 AS netto_pr_lalu
                    FROM
                        mst_entity e
                        LEFT JOIN (
                            SELECT
                                s1.kode_entity AS kode,
                                s1.no_unit,	
                                ri1.cara_bayar,
                                ri1.tgl_ri_akad,
                                ri1.p_ri,
                                s1.wide_gross,
                                s1.wide_netto,
                                SUM(upr1.rp) AS netto,
                                pr1.persen_progress AS p_pr
                            FROM
                                mst_stock s1
                                INNER JOIN (
                                    SELECT
                                        pay11.kode_entity,
                                        pay11.no_unit,
                                        pay11.cara_bayar,
                                        tgl_ri_akad,
                                        SUM(paydet11.rp)/pay11.harga_unit*100 AS p_ri
                                    FROM
                                        tr_payment pay11
                                        INNER JOIN tr_payment_detail paydet11 ON paydet11.reserve_no = pay11
    .reserve_no
                                    WHERE
                                        pay11.kode_entity = @ent
                                        AND pay11.reserve_no IN (
                                            SELECT
                                                DISTINCT pay111.reserve_no
                                            FROM
                                                tr_payment pay111
                                                INNER JOIN tr_payment_detail paydet111 ON paydet111.reserve_no
     = pay111.reserve_no
                                            WHERE
                                                pay111.kode_entity = @ent
                                                AND paydet111.tgl_bayar >= @tgl_1
                                                AND paydet111.tgl_bayar <= @tgl_2
                                        )
                                        AND	paydet11.tgl_bayar <= @tgl_2
                                        AND pay11.iscancelled = 0
                                    GROUP BY
                                        pay11.kode_entity,
                                        pay11.no_unit
                                    HAVING
                                        p_ri >= CASE WHEN pay11.cara_bayar='KPRKPA' THEN 5 ELSE 100 END

                                ) AS ri1 ON ri1.kode_entity = s1.kode_entity
                                    and ri1.no_unit = s1.no_unit
                                LEFT JOIN (
                                    SELECT
                                        pr11.kode_entity,
                                        pr11.no_unit,
                                        pr11.persen_progress
                                    FROM
                                        tr_progress pr11
                                    WHERE
                                        pr11.kode_entity = @ent
                                        AND pr11.tgl_progress <= @tgl_2
                                        AND pr11.persen_progress >= @prog
                                    GROUP BY
                                        pr11.kode_entity,
                                        pr11.no_unit
                                    ORDER BY
                                        pr11.tgl_progress DESC
                                ) AS pr1 ON pr1.kode_entity = s1.kode_entity
                                    and pr1.no_unit = s1.no_unit
                                INNER JOIN mst_unit_price upr1 ON upr1.kode_entity = s1.kode_entity
                                    AND upr1.no_unit = s1.no_unit AND upr1.grup = 'NETTO'
                                    AND upr1.isactive = 1
                            GROUP BY
                                s1.kode_entity,
                                s1.no_unit
                        ) AS ld ON ld.kode = e.kode
                    WHERE
                        e.type_entity = 'LD'
								UNION ALL
                SELECT
                    @tgl_1 := '$from' AS _tgl_1,
                    @tgl_2 := '$to' AS _tgl_2,
                    e.direktorat,
                    e.type_entity,
                    e.nama,
                    @ent := e.kode AS _kode,
                    (SELECT @prog := progress FROM mst_progress_landed WHERE bln = MONTH(@tgl_1)) AS
 _min_progress,
                    IFNULL(ld.no_unit,'') AS no_unit,
                    IFNULL(ld.cara_bayar,'') AS cara_bayar,
                    IFNULL(ld.tgl_ri_akad,'') AS tgl_ri_akad,
                    IFNULL(ld.p_ri,0) AS p_ri,
                    0 AS n_unit,
                    0 AS wide_gross,
                    0 AS wide_netto,
                    0 AS netto,
                    0 AS n_unit_r,
                    0 AS wide_gross_r,
                    0 AS wide_netto_r,
                    0 AS netto_r,
                    CASE WHEN ld.p_ri >= CASE WHEN ld.cara_bayar='KPRKPA' THEN 5 ELSE 100 END THEN 1
 ELSE 0 END AS n_unit_lalu,
				    IFNULL(CASE WHEN ld.p_ri >= CASE WHEN ld.cara_bayar='KPRKPA' THEN 5 ELSE 100 END THEN ld.wide_gross
 ELSE 0 END,0) AS wide_gross_lalu,
                    IFNULL(CASE WHEN ld.p_ri >= CASE WHEN ld.cara_bayar='KPRKPA' THEN 5 ELSE 100 END
 THEN ld.wide_netto ELSE 0 END,0) AS wide_netto_lalu,
                    IFNULL(CASE WHEN ld.p_ri >= CASE WHEN ld.cara_bayar='KPRKPA' THEN 5 ELSE 100 END
 THEN ld.netto ELSE 0 END,0) AS netto_lalu,
                    0 AS netto_pr,
					0 AS netto_pr_r,
					IFNULL(CASE WHEN ld.p_ri >= CASE WHEN ld.cara_bayar='KPRKPA' THEN 5 ELSE 100 END
 THEN ld.netto*ld.p_pr ELSE 0 END,0) AS netto_pr_lalu
                FROM
                    mst_entity e
                    LEFT JOIN (
                        SELECT
                            s1.kode_entity AS kode,
                            s1.no_unit,	
                            ri1.cara_bayar,
                            ri1.tgl_ri_akad,
                            ri1.p_ri,
                            s1.wide_gross,
                            s1.wide_netto,
                            SUM(upr1.rp) AS netto,
                            pr1.persen_progress AS p_pr
                        FROM
                            mst_stock s1
                            INNER JOIN (
                                SELECT
                                    pay11.kode_entity,
                                    pay11.no_unit,
                                    pay11.cara_bayar,
                                    tgl_ri_akad,
                                    SUM(paydet11.rp)/pay11.harga_unit*100 AS p_ri
                                FROM
                                    tr_payment pay11
                                    INNER JOIN tr_payment_detail paydet11 ON paydet11.reserve_no = pay11
.reserve_no
                                WHERE
                                    pay11.kode_entity = @ent
                                    AND	paydet11.tgl_bayar < @tgl_1
                                    AND pay11.iscancelled = 0
                                GROUP BY
                                    pay11.kode_entity,
                                    pay11.no_unit
                                HAVING
                                    p_ri >= CASE WHEN pay11.cara_bayar='KPRKPA' THEN 5 ELSE 100 END

                            ) AS ri1 ON ri1.kode_entity = s1.kode_entity
                                and ri1.no_unit = s1.no_unit
                            LEFT JOIN (
                                SELECT
                                    pr11.kode_entity,
                                    pr11.no_unit,
                                    pr11.persen_progress
                                FROM
                                    tr_progress pr11
                                WHERE
                                    pr11.kode_entity = @ent
                                    AND pr11.tgl_progress < @tgl_1
                                    AND pr11.persen_progress >= @prog
                                GROUP BY
                                    pr11.kode_entity,
                                    pr11.no_unit
                                ORDER BY
                                    pr11.tgl_progress DESC
                            ) AS pr1 ON pr1.kode_entity = s1.kode_entity
                                and pr1.no_unit = s1.no_unit
                            INNER JOIN mst_unit_price upr1 ON upr1.kode_entity = s1.kode_entity
                                AND upr1.no_unit = s1.no_unit AND upr1.grup = 'NETTO'
                                AND upr1.isactive = 1
                        GROUP BY
                            s1.kode_entity,
                            s1.no_unit
                    ) AS ld ON ld.kode = e.kode
                WHERE
                    e.type_entity = 'LD'
							) AS tmp
							GROUP BY
								direktorat,
								type_entity,
								_kode,
								no_unit
						) AS tmp
						GROUP BY
							direktorat,
							type_entity,
							_kode
        ";
//        var_dump($sql);
        $qLD = $this->db->query($sql);
        $qLD = $this->db->query($sql);
        $resLD = $qLD->result_array();
        foreach($resLD as $v) {
            $item = array(
                array('- Unit', $v['n_unit_lalu'], $v['n_unit'], $v['n_unit_r']),
                array('- Luas Bang.', $v['wide_netto_lalu'], $v['wide_netto'], $v['wide_netto_r']),
                array('- Luas Tanah', $v['wide_gross_lalu'], $v['wide_gross'], $v['wide_gross_r']),
                array('- Omzet', $v['netto_pr_lalu'], $v['netto_pr'], $v['netto_pr_r']),
            );
            $data[$v['direktorat']==='DIR1'?'Direktorat I':'Direktorat II']['Landed House'][] = array(
                $v['nama'],
                $item
            );
        }
//        die(print_r($data));
        return $data;
    }

	// Model OK -- Query masih sama seperti yang atas * Hardiyanto *
	function gen_rpt_ok($from, $to) {
		$sql = "
			SELECT
				opent.konten AS type_entity,
				ent.nama,
				'F' as scol,
				IFNULL(SUM(paydet.rp),0) AS rp,
				stk.wide_netto,
				stk.wide_gross,
				1 AS n_unit,
				(IF(pay.status_tr='SALES',stk.wide_netto,0)) as widenet_sales,
				(IF(pay.status_tr='SALES',stk.wide_gross,0)) as widegros_sales,
				stk.no_unit,
				pay.harga_unit,
				IF(pay.status_tr='RESERVE',1,0) as status_res,
				IF(pay.status_tr='RESERVE',SUM(paydet.rp),0) as reseve_price,
				IF(pay.status_tr='RESERVE',stk.wide_netto,0) as widenet_reserve,
				IF(pay.status_tr='RESERVE',stk.wide_gross,0) as widegros_reserve,
				IF(pay.iscancelled=1,SUM(paydet.rp),0) as pembatalan,
				(SELECT SUM(rp) FROM tr_payment_detail paydet2 WHERE paydet2.kode_pay NOT IN('RES','TJ') 
					AND paydet2.tgl_bayar IS NULL AND paydet2.no_kwitansi IS NULL AND paydet2.reserve_no=pay.reserve_no AND paydet2.tgl_tempo < '$from' )as t_ra_lalu,
				(SELECT SUM(rp) FROM tr_payment_detail paydet2 WHERE  paydet2.kode_pay NOT IN('RES','TJ') 
								AND paydet2.tgl_bayar IS NULL AND paydet2.no_kwitansi IS NULL AND paydet2.reserve_no=pay.reserve_no AND paydet2.tgl_tempo >= '$from' AND paydet2.tgl_tempo <= '$to' ) as t_ra_ini,
				(SELECT SUM(rp) FROM tr_payment_detail paydet2 WHERE  paydet2.kode_pay NOT IN('RES','TJ') 
								AND paydet2.tgl_bayar IS NULL AND paydet2.no_kwitansi IS NULL AND paydet2.reserve_no=pay.reserve_no AND paydet2.tgl_tempo > '$to' ) as t_ra_depan,
				1 AS ra_unit,
				f_getTotalRaUnit(pay.reserve_no,'MgLalu','$from','$to') as ra_unit_lalu,
				IF(f_getTotalRaUnit(pay.reserve_no,'MgLalu','$from','$to')=1,stk.wide_netto,0) as ra_unit_lwidenet,
				IF(f_getTotalRaUnit(pay.reserve_no,'MgLalu','$from','$to')=1,stk.wide_gross,0) as ra_unit_lwidegros,
				f_getTotalRaUnit(pay.reserve_no,'MgIni','$from','$to') as ra_unit_ini,
				IF(f_getTotalRaUnit(pay.reserve_no,'MgIni','$from','$to')=1,stk.wide_netto,0) as ra_unit_iwidenet,
				IF(f_getTotalRaUnit(pay.reserve_no,'MgIni','$from','$to')=1,stk.wide_gross,0) as ra_unit_iwidegros,
				f_getTotalRaUnit(pay.reserve_no,'MgDepan','$from','$to') as ra_unit_depan,
				IF(f_getTotalRaUnit(pay.reserve_no,'MgDepan','$from','$to')=1,stk.wide_netto,0) as ra_unit_dwidenet,
				IF(f_getTotalRaUnit(pay.reserve_no,'MgDepan','$from','$to')=1,stk.wide_gross,0) as ra_unit_dwidegros
			FROM
				tr_payment pay
				INNER JOIN mst_stock AS stk ON stk.no_unit = pay.no_unit
				INNER JOIN mst_entity AS ent ON ent.kode = stk.kode_entity AND ent.kode = pay.kode_entity
				INNER JOIN mst_optional_entity opent ON opent.kode = ent.type_entity
						AND opent.sfield = 'type_entity'
				INNER JOIN tr_payment_detail paydet ON paydet.reserve_no = pay.reserve_no
			WHERE
				pay.status_tr <> 'HOLD'
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
				(IF(pay.status_tr='SALES',stk.wide_netto,0)) as widenet_sales,
				(IF(pay.status_tr='SALES',stk.wide_gross,0)) as widegros_sales,
				stk.no_unit,
				pay.harga_unit,
				IF(pay.status_tr='RESERVE',1,0) as status_res,
				IF(pay.status_tr='RESERVE',SUM(paydet.rp),0) as reseve_price,
				IF(pay.status_tr='RESERVE',stk.wide_netto,0) as widenet_reserve,
				IF(pay.status_tr='RESERVE',stk.wide_gross,0) as widegros_reserve,
				IF(pay.iscancelled=1,SUM(paydet.rp),0) as pembatalan,
				(SELECT SUM(rp) FROM tr_payment_detail paydet2 WHERE paydet2.kode_pay NOT IN('RES','TJ') 
					AND paydet2.tgl_bayar IS NULL AND paydet2.no_kwitansi IS NULL AND paydet2.reserve_no=pay.reserve_no AND paydet2.tgl_tempo < '$from' )as t_ra_lalu,
				(SELECT SUM(rp) FROM tr_payment_detail paydet2 WHERE  paydet2.kode_pay NOT IN('RES','TJ') 
								AND paydet2.tgl_bayar IS NULL AND paydet2.no_kwitansi IS NULL AND paydet2.reserve_no=pay.reserve_no AND paydet2.tgl_tempo >= '$from' AND paydet2.tgl_tempo <= '$to' ) as t_ra_ini,
				(SELECT SUM(rp) FROM tr_payment_detail paydet2 WHERE  paydet2.kode_pay NOT IN('RES','TJ') 
								AND paydet2.tgl_bayar IS NULL AND paydet2.no_kwitansi IS NULL AND paydet2.reserve_no=pay.reserve_no AND paydet2.tgl_tempo > '$to' ) as t_ra_depan,
				1 AS ra_unit,
				f_getTotalRaUnit(pay.reserve_no,'MgLalu','$from','$to') as ra_unit_lalu,
				IF(f_getTotalRaUnit(pay.reserve_no,'MgLalu','$from','$to')=1,stk.wide_netto,0) as ra_unit_lwidenet,
				IF(f_getTotalRaUnit(pay.reserve_no,'MgLalu','$from','$to')=1,stk.wide_gross,0) as ra_unit_lwidegros,
				f_getTotalRaUnit(pay.reserve_no,'MgIni','$from','$to') as ra_unit_ini,
				IF(f_getTotalRaUnit(pay.reserve_no,'MgIni','$from','$to')=1,stk.wide_netto,0) as ra_unit_iwidenet,
				IF(f_getTotalRaUnit(pay.reserve_no,'MgIni','$from','$to')=1,stk.wide_gross,0) as ra_unit_iwidegros,
				f_getTotalRaUnit(pay.reserve_no,'MgDepan','$from','$to') as ra_unit_depan,
				IF(f_getTotalRaUnit(pay.reserve_no,'MgDepan','$from','$to')=1,stk.wide_netto,0) as ra_unit_dwidenet,
				IF(f_getTotalRaUnit(pay.reserve_no,'MgDepan','$from','$to')=1,stk.wide_gross,0) as ra_unit_dwidegros
			FROM
				tr_payment pay
				INNER JOIN mst_stock AS stk ON stk.no_unit = pay.no_unit
				INNER JOIN mst_entity AS ent ON ent.kode = stk.kode_entity AND ent.kode = pay.kode_entity
				INNER JOIN mst_optional_entity opent ON opent.kode = ent.type_entity
						AND opent.sfield = 'type_entity'
				INNER JOIN tr_payment_detail paydet ON paydet.reserve_no = pay.reserve_no
			WHERE
				pay.status_tr <> 'HOLD'
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
				(IF(pay.status_tr='SALES',stk.wide_netto,0)) as widenet_sales,
				(IF(pay.status_tr='SALES',stk.wide_gross,0)) as widegros_sales,
				stk.no_unit,
				pay.harga_unit,
				IF(pay.status_tr='RESERVE',1,0) as status_res,
				IF(pay.status_tr='RESERVE',SUM(paydet.rp),0) as reseve_price,
				IF(pay.status_tr='RESERVE',stk.wide_netto,0) as widenet_reserve,
				IF(pay.status_tr='RESERVE',stk.wide_gross,0) as widegros_reserve,
				IF(pay.iscancelled=1,SUM(paydet.rp),0) as pembatalan,
				(SELECT SUM(rp) FROM tr_payment_detail paydet2 WHERE paydet2.kode_pay NOT IN('RES','TJ') 
					AND paydet2.tgl_bayar IS NULL AND paydet2.no_kwitansi IS NULL AND paydet2.reserve_no=pay.reserve_no AND paydet2.tgl_tempo < '$from' )as t_ra_lalu,
				(SELECT SUM(rp) FROM tr_payment_detail paydet2 WHERE  paydet2.kode_pay NOT IN('RES','TJ') 
								AND paydet2.tgl_bayar IS NULL AND paydet2.no_kwitansi IS NULL AND paydet2.reserve_no=pay.reserve_no AND paydet2.tgl_tempo >= '$from' AND paydet2.tgl_tempo <= '$to' ) as t_ra_ini,
				(SELECT SUM(rp) FROM tr_payment_detail paydet2 WHERE  paydet2.kode_pay NOT IN('RES','TJ') 
								AND paydet2.tgl_bayar IS NULL AND paydet2.no_kwitansi IS NULL AND paydet2.reserve_no=pay.reserve_no AND paydet2.tgl_tempo > '$to' ) as t_ra_depan,
				1 AS ra_unit,
				f_getTotalRaUnit(pay.reserve_no,'MgLalu','$from','$to') as ra_unit_lalu,
				IF(f_getTotalRaUnit(pay.reserve_no,'MgLalu','$from','$to')=1,stk.wide_netto,0) as ra_unit_lwidenet,
				IF(f_getTotalRaUnit(pay.reserve_no,'MgLalu','$from','$to')=1,stk.wide_gross,0) as ra_unit_lwidegros,
				f_getTotalRaUnit(pay.reserve_no,'MgIni','$from','$to') as ra_unit_ini,
				IF(f_getTotalRaUnit(pay.reserve_no,'MgIni','$from','$to')=1,stk.wide_netto,0) as ra_unit_iwidenet,
				IF(f_getTotalRaUnit(pay.reserve_no,'MgIni','$from','$to')=1,stk.wide_gross,0) as ra_unit_iwidegros,
				f_getTotalRaUnit(pay.reserve_no,'MgDepan','$from','$to') as ra_unit_depan,
				IF(f_getTotalRaUnit(pay.reserve_no,'MgDepan','$from','$to')=1,stk.wide_netto,0) as ra_unit_dwidenet,
				IF(f_getTotalRaUnit(pay.reserve_no,'MgDepan','$from','$to')=1,stk.wide_gross,0) as ra_unit_dwidegros
			FROM
				tr_payment pay
				INNER JOIN mst_stock AS stk ON stk.no_unit = pay.no_unit
				INNER JOIN mst_entity AS ent ON ent.kode = stk.kode_entity AND ent.kode = pay.kode_entity
				INNER JOIN mst_optional_entity opent ON opent.kode = ent.type_entity
						AND opent.sfield = 'type_entity'
				INNER JOIN tr_payment_detail paydet ON paydet.reserve_no = pay.reserve_no
			WHERE
				pay.status_tr <> 'HOLD'
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
				(IF(pay.status_tr='SALES',stk.wide_netto,0)) as widenet_sales,
				(IF(pay.status_tr='SALES',stk.wide_gross,0)) as widegros_sales,
				stk.no_unit,
				pay.harga_unit,
				IF(pay.status_tr='RESERVE',1,0) as status_res,
				IF(pay.status_tr='RESERVE',SUM(paydet.rp),0) as reseve_price,
				IF(pay.status_tr='RESERVE',stk.wide_netto,0) as widenet_reserve,
				IF(pay.status_tr='RESERVE',stk.wide_gross,0) as widegros_reserve,
				IF(pay.iscancelled=1,SUM(paydet.rp),0) as pembatalan,
				(SELECT SUM(rp) FROM tr_payment_detail paydet2 WHERE paydet2.kode_pay NOT IN('RES','TJ') 
					AND paydet2.tgl_bayar IS NULL AND paydet2.no_kwitansi IS NULL AND paydet2.reserve_no=pay.reserve_no AND paydet2.tgl_tempo < '$from' )as t_ra_lalu,
				(SELECT SUM(rp) FROM tr_payment_detail paydet2 WHERE  paydet2.kode_pay NOT IN('RES','TJ') 
								AND paydet2.tgl_bayar IS NULL AND paydet2.no_kwitansi IS NULL AND paydet2.reserve_no=pay.reserve_no AND paydet2.tgl_tempo >= '$from' AND paydet2.tgl_tempo <= '$to' ) as t_ra_ini,
				(SELECT SUM(rp) FROM tr_payment_detail paydet2 WHERE  paydet2.kode_pay NOT IN('RES','TJ') 
								AND paydet2.tgl_bayar IS NULL AND paydet2.no_kwitansi IS NULL AND paydet2.reserve_no=pay.reserve_no AND paydet2.tgl_tempo > '$to' ) as t_ra_depan,
				1 AS ra_unit,
				f_getTotalRaUnit(pay.reserve_no,'MgLalu','$from','$to') as ra_unit_lalu,
				IF(f_getTotalRaUnit(pay.reserve_no,'MgLalu','$from','$to')=1,stk.wide_netto,0) as ra_unit_lwidenet,
				IF(f_getTotalRaUnit(pay.reserve_no,'MgLalu','$from','$to')=1,stk.wide_gross,0) as ra_unit_lwidegros,
				f_getTotalRaUnit(pay.reserve_no,'MgIni','$from','$to') as ra_unit_ini,
				IF(f_getTotalRaUnit(pay.reserve_no,'MgIni','$from','$to')=1,stk.wide_netto,0) as ra_unit_iwidenet,
				IF(f_getTotalRaUnit(pay.reserve_no,'MgIni','$from','$to')=1,stk.wide_gross,0) as ra_unit_iwidegros,
				f_getTotalRaUnit(pay.reserve_no,'MgDepan','$from','$to') as ra_unit_depan,
				IF(f_getTotalRaUnit(pay.reserve_no,'MgDepan','$from','$to')=1,stk.wide_netto,0) as ra_unit_dwidenet,
				IF(f_getTotalRaUnit(pay.reserve_no,'MgDepan','$from','$to')=1,stk.wide_gross,0) as ra_unit_dwidegros
				
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
		//die("<pre>{$sql}</pre>");
		$q = $this->db->query($sql);
		$data = array();
		foreach ($q->result_array() as $k => $v) {
			if(!isset($data[$v['type_entity']][$v['nama']]['unit'][$v['scol']])) {
				// ri > 5%
				$data[$v['type_entity']][$v['nama']]['unit'][$v['scol']] 		= 0;
				$data[$v['type_entity']][$v['nama']]['netto'][$v['scol']] 		= 0;
				$data[$v['type_entity']][$v['nama']]['gross'][$v['scol']] 		= 0;
				$data[$v['type_entity']][$v['nama']]['rp'][$v['scol']] 			= 0;
				$data[$v['type_entity']][$v['nama']]['resvr'][$v['scol']] 		= 0;
				$data[$v['type_entity']][$v['nama']]['resvr_price'][$v['scol']] = 0;
				$data[$v['type_entity']][$v['nama']]['netto_rsv'][$v['scol']] 	= 0;
				$data[$v['type_entity']][$v['nama']]['gross_rsv'][$v['scol']] 	= 0;
				$data[$v['type_entity']][$v['nama']]['canceled'][$v['scol']] 	= 0;
				$data[$v['type_entity']][$v['nama']]['ra_lalu'][$v['scol']] 	= 0;
				$data[$v['type_entity']][$v['nama']]['ra_ini'][$v['scol']] 		= 0;
				$data[$v['type_entity']][$v['nama']]['ra_depan'][$v['scol']] 	= 0;
				$data[$v['type_entity']][$v['nama']]['ra_unit'][$v['scol']] 	= 0;
				$data[$v['type_entity']][$v['nama']]['ra_unit_lalu'][$v['scol']] 	= 0;
				$data[$v['type_entity']][$v['nama']]['ra_l_wn'][$v['scol']]	= 0;
				$data[$v['type_entity']][$v['nama']]['ra_l_wg'][$v['scol']]	= 0;
				$data[$v['type_entity']][$v['nama']]['ra_i_wn'][$v['scol']]	= 0;
				$data[$v['type_entity']][$v['nama']]['ra_i_wg'][$v['scol']]	= 0;
				$data[$v['type_entity']][$v['nama']]['ra_unit_ini'][$v['scol']] 	= 0;
				$data[$v['type_entity']][$v['nama']]['ra_unit_depan'][$v['scol']] 	= 0;
				// ri <= 5%
				$data[$v['type_entity']][$v['nama']]['unit']['N'] 				= 0;
				$data[$v['type_entity']][$v['nama']]['netto']['N'] 				= 0;
				$data[$v['type_entity']][$v['nama']]['gross']['N'] 				= 0;
				$data[$v['type_entity']][$v['nama']]['rp']['N'] 				= 0;
				$data[$v['type_entity']][$v['nama']]['resvr']['N'] 				= 0;
				$data[$v['type_entity']][$v['nama']]['resvr_price']['N'] 		= 0;
				$data[$v['type_entity']][$v['nama']]['netto_rsv']['N'] 			= 0;
				$data[$v['type_entity']][$v['nama']]['gross_rsv']['N'] 			= 0;
				$data[$v['type_entity']][$v['nama']]['canceled']['N'] 			= 0;
				$data[$v['type_entity']][$v['nama']]['ra_unit']['N'] 			= 0;
				$data[$v['type_entity']][$v['nama']]['ra_lalu']['N'] 			= 0;
				$data[$v['type_entity']][$v['nama']]['ra_ini']['N'] 			= 0;
				$data[$v['type_entity']][$v['nama']]['ra_depan']['N'] 			= 0;
				$data[$v['type_entity']][$v['nama']]['ra_unit_lalu']['N'] 		= 0;
				$data[$v['type_entity']][$v['nama']]['ra_l_wn']['N'] 	= 0;
				$data[$v['type_entity']][$v['nama']]['ra_l_wg']['N'] 	= 0;
				$data[$v['type_entity']][$v['nama']]['ra_i_wn']['N'] 	= 0;
				$data[$v['type_entity']][$v['nama']]['ra_i_wg']['N'] 	= 0;
				$data[$v['type_entity']][$v['nama']]['ra_unit_ini']['N'] 		= 0;
				$data[$v['type_entity']][$v['nama']]['ra_unit_depan']['N'] 		= 0;
			}
			$diff = $v['rp'] / $v['harga_unit'] * 100;
			if($v['scol']!=='H' AND $v['scol']!=='J') {

				if($diff >= 5) {
					$data[$v['type_entity']][$v['nama']]['unit'][$v['scol']] 		+= $v['n_unit'];
					$data[$v['type_entity']][$v['nama']]['netto'][$v['scol']] 		+= $v['widenet_sales'];
					$data[$v['type_entity']][$v['nama']]['gross'][$v['scol']] 		+= $v['widegros_sales'];
					$data[$v['type_entity']][$v['nama']]['rp'][$v['scol']] 			+= $v['rp'];
					$data[$v['type_entity']][$v['nama']]['resvr'][$v['scol']] 		+= $v['status_res'];
					$data[$v['type_entity']][$v['nama']]['resvr_price'][$v['scol']]	+= $v['reseve_price'];
					$data[$v['type_entity']][$v['nama']]['netto_rsv'][$v['scol']] 	+= $v['widenet_reserve'];
					$data[$v['type_entity']][$v['nama']]['gross_rsv'][$v['scol']] 	+= $v['widegros_reserve'];
					$data[$v['type_entity']][$v['nama']]['canceled'][$v['scol']] 	+= $v['pembatalan'];
					$data[$v['type_entity']][$v['nama']]['ra_lalu'][$v['scol']] 	+= $v['t_ra_lalu'];
					$data[$v['type_entity']][$v['nama']]['ra_ini'][$v['scol']] 		+= $v['t_ra_ini'];
					$data[$v['type_entity']][$v['nama']]['ra_depan'][$v['scol']] 	+= $v['t_ra_depan'];
					$data[$v['type_entity']][$v['nama']]['canceled'][$v['scol']] 	+= $v['pembatalan'];
					$data[$v['type_entity']][$v['nama']]['ra_unit_lalu'][$v['scol']] 	+= $v['ra_unit_lalu'];
					$data[$v['type_entity']][$v['nama']]['ra_l_wn'][$v['scol']]	+= $v['ra_unit_lwidenet'];
					$data[$v['type_entity']][$v['nama']]['ra_l_wg'][$v['scol']]	+= $v['ra_unit_lwidegros'];
					$data[$v['type_entity']][$v['nama']]['ra_i_wn'][$v['scol']]	+= $v['ra_unit_iwidenet'];
					$data[$v['type_entity']][$v['nama']]['ra_i_wg'][$v['scol']]	+= $v['ra_unit_iwidegros'];
					$data[$v['type_entity']][$v['nama']]['ra_unit_ini'][$v['scol']] 	+= $v['ra_unit_ini'];
					$data[$v['type_entity']][$v['nama']]['ra_unit_depan'][$v['scol']] 	+= $v['ra_unit_depan']; 
					$data[$v['type_entity']][$v['nama']]['ra_unit'][$v['scol']] 		+= $v['ra_unit'];
					
				} else {
					$data[$v['type_entity']][$v['nama']]['unit']['N'] 				+= $v['n_unit'];
					$data[$v['type_entity']][$v['nama']]['netto']['N'] 				+= $v['widenet_sales'];
					$data[$v['type_entity']][$v['nama']]['gross']['N'] 				+= $v['widegros_sales'];
					$data[$v['type_entity']][$v['nama']]['rp']['N'] 				+= $v['rp'];
					$data[$v['type_entity']][$v['nama']]['resvr']['N'] 				+= $v['status_res'];
					$data[$v['type_entity']][$v['nama']]['resvr_price']['N'] 		+= $v['reseve_price'];
					$data[$v['type_entity']][$v['nama']]['netto_rsv']['N'] 			+= $v['widenet_reserve'];
					$data[$v['type_entity']][$v['nama']]['gross_rsv']['N'] 			+= $v['widegros_reserve'];
					$data[$v['type_entity']][$v['nama']]['canceled']['N']  			+= $v['pembatalan'];
					$data[$v['type_entity']][$v['nama']]['ra_lalu']['N']  			+= $v['t_ra_lalu'];
					$data[$v['type_entity']][$v['nama']]['ra_ini']['N'] 			+= $v['t_ra_ini'];
					$data[$v['type_entity']][$v['nama']]['ra_depan']['N']  			+= $v['t_ra_depan'];
					$data[$v['type_entity']][$v['nama']]['ra_unit_lalu']['N']  		+= $v['ra_unit_lalu'];
					$data[$v['type_entity']][$v['nama']]['ra_l_wn']['N']			+= $v['ra_unit_lwidenet'];
					$data[$v['type_entity']][$v['nama']]['ra_l_wg']['N']			+= $v['ra_unit_lwidegros'];
					$data[$v['type_entity']][$v['nama']]['ra_i_wn']['N']			+= $v['ra_unit_iwidenet'];
					$data[$v['type_entity']][$v['nama']]['ra_i_wg']['N']			+= $v['ra_unit_iwidegros'];
					$data[$v['type_entity']][$v['nama']]['ra_unit_ini']['N']  		+= $v['ra_unit_ini'];
					$data[$v['type_entity']][$v['nama']]['ra_unit_depan']['N']  	+= $v['ra_unit_depan'];
					$data[$v['type_entity']][$v['nama']]['ra_unit']['N'] 			+= $v['ra_unit'];
				} 

			} else {
				$data[$v['type_entity']][$v['nama']]['unit'][$v['scol']] 			+= $v['n_unit'];
				$data[$v['type_entity']][$v['nama']]['netto'][$v['scol']] 			+= $v['widenet_sales'];
				$data[$v['type_entity']][$v['nama']]['gross'][$v['scol']] 			+= $v['widegros_sales'];
				$data[$v['type_entity']][$v['nama']]['rp'][$v['scol']] 				+= $v['rp'];
				$data[$v['type_entity']][$v['nama']]['resvr'][$v['scol']] 			+= $v['status_res'];
				$data[$v['type_entity']][$v['nama']]['resvr_price'][$v['scol']] 	+= $v['reseve_price'];
				$data[$v['type_entity']][$v['nama']]['netto_rsv'][$v['scol']] 		+= $v['widenet_reserve'];
				$data[$v['type_entity']][$v['nama']]['gross_rsv'][$v['scol']] 		+= $v['widegros_reserve'];
				$data[$v['type_entity']][$v['nama']]['canceled'][$v['scol']] 		+= $v['pembatalan'];
				$data[$v['type_entity']][$v['nama']]['ra_lalu'][$v['scol']] 		+= $v['t_ra_lalu'];
				$data[$v['type_entity']][$v['nama']]['ra_ini'][$v['scol']] 			+= $v['t_ra_ini'];
				$data[$v['type_entity']][$v['nama']]['ra_depan'][$v['scol']] 		+= $v['t_ra_depan'];
				$data[$v['type_entity']][$v['nama']]['ra_unit_lalu'][$v['scol']] 	+= $v['ra_unit_lalu'];
				$data[$v['type_entity']][$v['nama']]['ra_l_wn'][$v['scol']]			+= $v['ra_unit_lwidenet'];
				$data[$v['type_entity']][$v['nama']]['ra_l_wg'][$v['scol']]			+= $v['ra_unit_lwidegros'];
				$data[$v['type_entity']][$v['nama']]['ra_i_wn'][$v['scol']]			+= $v['ra_unit_iwidenet'];
				$data[$v['type_entity']][$v['nama']]['ra_i_wg'][$v['scol']]			+= $v['ra_unit_iwidegros'];
				$data[$v['type_entity']][$v['nama']]['ra_unit_ini'][$v['scol']] 	+= $v['ra_unit_ini'];
				$data[$v['type_entity']][$v['nama']]['ra_unit_depan'][$v['scol']] 	+= $v['ra_unit_depan'];
				$data[$v['type_entity']][$v['nama']]['ra_unit'][$v['scol']] 		+= $v['ra_unit'];
			}
		}
		//var_dump($data);die;
		return $data;
	}
	
		
}
	