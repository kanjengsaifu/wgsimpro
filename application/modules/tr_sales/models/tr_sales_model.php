<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tr_sales_model extends CI_Model {
	
	public function save_undefined($data){
		$this->db->insert('tr_undefined',$data);
	}
	
	public function save_payment_undefined($data,$id){
		$this->db->where('id',$id);
		$this->db->update('tr_undefined',$data);
	}
	
	public function save_bank_in($data){
		$this->db->insert('tr_cashbank',$data);
		return $this->save_kode_bank_in($data, $this->db->insert_id());
	}
	
	public function update_bank_in($data,$id){
		$this->db->where('id',$id);
		return $this->db->update('tr_cashbank',$data);
	}
	
	public function save_kode_bank_in($data,$id){
		$dt = array(
					'no_voucher'=>sprintf($data['jenis_transaksi'].date('ym')."%04s", $id)
				);
		$this->db->where('id',$id);
		$this->db->update('tr_cashbank',$dt);
		return $id;
	}
	
	public function save_kode_bank_in_post($id){
		$dt = array('status'=>'t');
		$this->db->where('id',$id);
		$this->db->update('tr_cashbank',$dt);
		return $id;
	}
	
	public function get_unit_undefiend(){
		$this->db->select('reserve_no,no_unit,kode_nasabah')
				->from('tr_payment')		
				->where('kode_entity ',$this->session->userdata('kode_entity'))
				->order_by('no_unit');
		$q = $this->db->get();
		return $q->result_array();
	}
	public function get_nasabah(){
		$this->db->select('kode,nama')
				->from('mst_nasabah')	
				->join('tr_payment a','a.kode_nasabah = mst_nasabah.kode','inner')	
				->where('kode_entity ',$this->session->userdata('kode_entity'))
				->order_by('kode');
		$q = $this->db->get();
		return $q->result_array();
	}
	
	public function get_grouped_unit() {
		$this->db->select('mst_stock.*, MD5(mst_stock.no_unit) AS xno_unit, '.
					'CASE WHEN tr_payment.status_tr = "HOLD" THEN CASE WHEN DATEDIFF(DATE_ADD(tr_payment.hold_date, INTERVAL 7 DAY), NOW())>0 AND iscancelled=0 THEN "HOLD" ELSE NULL END '.
					'ELSE tr_payment.status_tr END AS status_tr, , stower.konten AS stower, slantai.konten AS slantai', FALSE)
				->from('mst_stock ')
				->join('tr_payment','tr_payment.no_unit=mst_stock.no_unit AND tr_payment.iscancelled=0 AND tr_payment.kode_entity = "'.$this->session->userdata('kode_entity').'"','LEFT')
                ->join('mst_optional_stock stower', 'stower.kode = mst_stock.tower_cluster AND stower.sfield = "tower_cluster" AND stower.sflag = "'.$this->session->userdata('type_entity').'"', 'LEFT')
                ->join('mst_optional_stock slantai', 'slantai.kode = mst_stock.lantai_blok AND slantai.sfield = "lantai_blok" AND slantai.sflag = "'.$this->session->userdata('type_entity').'"', 'LEFT')
				->where(array('mst_stock.kode_entity'=>$this->session->userdata('kode_entity')))
                ->order_by('tower_cluster, lantai_blok, kavling');
		$q = $this->db->get();
		$res = $q->result_array();
		$dUnit = $dLantai = $dTower = array();
		$iUnit = $iLantai = $iTower = -1;
        $xlantai = $xslantai = $xTower = $xsTower = '';
		foreach($res as $k => $v) {
            if($xTower!==$v['tower_cluster'] AND $xTower!=='') {
                $iTower++;
                $dTower[$iTower] = array(
                    'ktower'=>$xTower,
                    'stower'=>$xsTower,
                    'lantais'=>$dLantai
                );
                $iLantai = -1;
                unset($dLantai);
            }
            $xTower = $v['tower_cluster'];
            $xsTower = $v['stower'];
            
            if($xlantai!==$v['lantai_blok'] AND $xlantai!=='') {
                $iLantai++;
                $dLantai[$iLantai] = array(
                    'klantai'=>$xlantai,
                    'slantai'=>$xslantai,
                    'units'=>$dUnit
                );
                $iUnit = -1;
                unset($dUnit);
            }
            $xlantai = $v['lantai_blok'];
            $xslantai = $v['slantai'];
            
            $iUnit++;
            $dUnit[$iUnit] = array(
                'no_unit'=>$v['no_unit'],
                'xno_unit'=>$v['xno_unit'],
                'ishold'=>$v['ishold'],
                'status_tr'=>$v['status_tr'],
            );
		}
        $iLantai++;
        $dLantai[$iLantai] = array(
            'klantai'=>$xlantai,
            'slantai'=>$xslantai,
            'units'=>$dUnit
        );
        $iTower++;
        $dTower[$iTower] = array(
            'ktower'=>$xTower,
            'stower'=>$xsTower,
            'lantais'=>$dLantai
        );
		return $dTower;
	}

	public function get_groupby($groupby) {
		
		$this->db->distinct()
				->select($groupby.' AS field')
				->select('mst_optional_stock.konten AS nmfield')
				->from('mst_stock')
				->join('mst_optional_stock','mst_optional_stock.kode = mst_stock.'.$groupby.' '.
						'AND mst_optional_stock.sfield = "'.$groupby.'" AND mst_stock.kode_entity = "'.$this->session->userdata('kode_entity').'"')
				->where('mst_stock.'.$groupby.' IS NOT NULL AND mst_stock.'.$groupby.' <> "" AND mst_stock.kode_entity = "'.$this->session->userdata('kode_entity').'"')
				->order_by($groupby);
		$q = $this->db->get();
		return $q->result_array();
	}

	public function get_filterby($groupby, $filterby) {
		$this->db->select('mst_stock.*, MD5(mst_stock.no_unit) AS xno_unit, CASE WHEN tr_payment.status_tr = "HOLD" THEN CASE WHEN DATEDIFF(DATE_ADD(tr_payment.hold_date, INTERVAL 7 DAY), NOW())>0 THEN '.
					'"HOLD" ELSE NULL END ELSE tr_payment.status_tr END AS status_tr', FALSE) 
				->from('mst_stock')
				->join('tr_payment','tr_payment.no_unit=mst_stock.no_unit AND tr_payment.iscancelled = 0 AND tr_payment.kode_entity = "'.$this->session->userdata('kode_entity').'"','LEFT')
				->where(array($groupby => $filterby, 'mst_stock.kode_entity'=>$this->session->userdata('kode_entity'))); 
		$q = $this->db->get();
		$res = $q->result_array();
		$data = array();
		$iLoop = 0;
		$ltLoop = 0;
		$ltStr = '';
		foreach($res as $k => $v) {
			$data[$v['lantai_blok']][$iLoop]['no_unit'] = $v['no_unit'];
			$data[$v['lantai_blok']][$iLoop]['xno_unit'] = $v['xno_unit'];
			$data[$v['lantai_blok']][$iLoop]['ishold'] = $v['ishold'];
			$data[$v['lantai_blok']][$iLoop]['status_tr'] = $v['status_tr'];
			$iLoop++;
		}
		return $data;
	}

	public function get_unit($no_unit) {
		// unit & payment details
		$q = $this->db->query("
			SELECT DISTINCT 
				mst_stock.no_unit,
				slantai.konten AS lantai_blok,
				stower.konten AS tower_cluster,
				mst_stock.wide_netto,
				mst_stock.wide_gross,
				szone.konten AS zone,
				sdir.konten AS direction,
				sangin.konten AS mata_angin_kode,
				mos.konten AS mata_angin,
				stypeu.konten AS type_unit,
				stypep.konten AS type_property,
				CASE WHEN tr_payment.status_tr = 'HOLD' THEN 
					CASE WHEN DATEDIFF(DATE_ADD(tr_payment.hold_date, INTERVAL 7 DAY), NOW())>0 THEN 'HOLD' ELSE NULL END 
					ELSE tr_payment.status_tr END AS status_tr, 
				tr_payment.hold_date, 
				DATE_FORMAT(tr_payment.hold_date,'%d/%m/%Y') AS xhold_date,
				CONCAT(DATEDIFF(NOW(),hold_date),' hari') AS hold_umur,
				tr_payment.reserve_date, 
				DATE_FORMAT(tr_payment.reserve_date,'%d/%m/%Y') AS xreserve_date,
				CONCAT(DATEDIFF(NOW(),reserve_date),' hari') AS reserve_umur,
				tr_payment.booking_date, 
				DATE_FORMAT(tr_payment.booking_date,'%d/%m/%Y') AS xbooking_date,
				CONCAT(DATEDIFF(NOW(),booking_date),' hari') AS booking_umur,
				DATE_FORMAT(tr_payment.tgl_akad,'%d/%m/%Y') AS tgl_akad,
				DATE_FORMAT(tr_payment.tgl_dokumen,'%d/%m/%Y') AS tgl_dokumen,
				DATE_FORMAT(tr_payment.tgl_bangunan,'%d/%m/%Y') AS tgl_bangunan,
				tr_payment.reserve_no, 
				tr_payment.sales_no, 
				msaler.nama AS nama_sales, 
				tr_payment.cara_bayar, 
				scb.nama AS scara_bayar,
				tr_payment.kode_pay,
				skp.deskripsi AS skode_pay,
				tr_payment.harga_unit AS harga_jual,
				MD5(mst_stock.no_unit) AS xno_unit,
				tr_payment.kode_bank,
				mpd.deskripsi as cara_bayar_desc 
			FROM
				mst_stock
				LEFT JOIN tr_payment ON tr_payment.no_unit=mst_stock.no_unit AND tr_payment.iscancelled = 0  AND tr_payment.kode_entity = '".$this->session->userdata('kode_entity')."'
				LEFT JOIN mst_optional AS scb ON scb.kode = tr_payment.cara_bayar AND scb.opsi = 'PAYMENTPAYMODE'
				LEFT JOIN mst_payment_plan_detail AS mpd ON mpd.kode_pay = tr_payment.kode_pay
				LEFT JOIN mst_sales AS msaler ON msaler.kode = tr_payment.sales_no
				LEFT JOIN mst_optional_stock as mos ON mos.kode = mst_stock.mata_angin
				LEFT JOIN (
					SELECT
						DISTINCT cara_bayar,kode_pay, deskripsi
					FROM
						mst_payment_plan_detail
				) AS skp ON skp.kode_pay = tr_payment.kode_pay AND skp.cara_bayar = tr_payment.cara_bayar
				LEFT JOIN mst_optional_stock stypep ON  stypep.sfield = 'type_property' AND stypep.kode = mst_stock.type_property 
					AND stypep.sflag = '".$this->session->userdata('type_entity')."'
				LEFT JOIN mst_optional_stock stower ON stower.sfield = 'tower_cluster' AND stower.kode = mst_stock.tower_cluster 
					AND stower.sflag = '".$this->session->userdata('type_entity')."'
				LEFT JOIN mst_optional_stock stypeu ON stypeu.sfield = 'type_unit' AND stypeu.kode = mst_stock.type_unit 
					AND stypeu.sflag = '".$this->session->userdata('type_entity')."'
				LEFT JOIN mst_optional_stock slantai ON slantai.sfield = 'lantai_blok' AND slantai.kode = mst_stock.lantai_blok 
					AND slantai.sflag = '".$this->session->userdata('type_entity')."'
				LEFT JOIN mst_optional_stock sdir ON sdir.sfield = 'direction' AND sdir.kode = mst_stock.direction 
					AND sdir.sflag = '".$this->session->userdata('type_entity')."'
				LEFT JOIN mst_optional_stock sangin ON sangin.sfield = 'mata_angin' AND sangin.kode = mst_stock.mata_angin 
					AND sangin.sflag = '".$this->session->userdata('type_entity')."'
				LEFT JOIN mst_optional_stock szone ON szone.sfield = 'zone' AND szone.kode = mst_stock.zone 
					AND szone.sflag = '".$this->session->userdata('type_entity')."'
			WHERE
				MD5(mst_stock.no_unit) = '$no_unit'
		");
		$data = $q->row_array();
		// unit prices
		$q = $this->db->query("
			SELECT
				mst_unit_price.kode_pay,
				mst_payment_plan_detail.deskripsi AS nama,
				SUM(mst_unit_price.rp) AS tr_jual,
				rp_netto.rp AS rp_netto
			FROM
				mst_unit_price
				INNER JOIN (
					SELECT
						DISTINCT kode_pay, deskripsi
					FROM
						mst_payment_plan_detail
				) AS mst_payment_plan_detail  ON mst_payment_plan_detail.kode_pay = mst_unit_price.kode_pay
				LEFT JOIN (
					SELECT
						no_unit,
						kode_pay,
						SUM(rp) AS rp
					FROM
						mst_unit_price
					WHERE
						MD5(no_unit) = '$no_unit'
						AND kode_entity = '".$this->session->userdata('kode_entity')."'
						AND grup = 'NETTO'
					GROUP BY
						no_unit,
						kode_pay
				) AS rp_netto ON rp_netto.no_unit = mst_unit_price.no_unit AND rp_netto.kode_pay = mst_unit_price.kode_pay
			WHERE
				MD5(mst_unit_price.no_unit) = '$no_unit'
				AND mst_unit_price.kode_entity = '".$this->session->userdata('kode_entity')."'
			GROUP BY
				mst_unit_price.kode_pay
		");
		$data['prices'] = $q->result_array();
		// terbilang
		$this->load->library('strUtils'); 
		$strObj = new StrUtils();
		foreach ($data['prices'] as $k => $v) {
			$data['prices'][$k]['terbilang'] = $strObj->rp_terbilang($v['tr_jual']);
			$data['prices'][$k]['terbilang_netto'] = $strObj->rp_terbilang($v['rp_netto']);
		}
		if(isset($data['reserve_no'])) {
			$arrStatus = array(
				'HOLD'=>'hold',
				'RESERVE'=>'reserve',
				'BOOKING'=>'booking',
				'SALES'=>'booking'
			);
			$data['terbilang_jual'] = $strObj->rp_terbilang($data['harga_jual']);
			$data['tgl_payment'] = $data['x'.$arrStatus[$data['status_tr']].'_date'];
			$data['umur_payment'] = $data[$arrStatus[$data['status_tr']].'_umur'];
			// payment plan
			$q = $this->db->query("
				SELECT
					paydet.*
				FROM
					tr_payment AS pay
					INNER JOIN tr_payment_detail AS paydet ON paydet.reserve_no = pay.reserve_no
				WHERE
					pay.iscancelled = 0
					AND MD5(pay.no_unit) = '$no_unit'
					AND pay.kode_entity = '".$this->session->userdata('kode_entity')."'
				ORDER BY
					paydet.no_urut
			");
			$data['payments'] = $q->result_array();
			// get customer
			$sql = "
				SELECT
					nsb.kode,
					sklas.konten AS klasifikasi,
					ssalut.konten AS salutation,
					nsb.nama,
					sid.konten AS jenis_id,
					nsb.no_id,
					nsb.email,
					nsb.npwp,
					nsb.hp,
					nsb.tempat_lahir,
					snat.konten AS nationality,
					sag.konten AS agama,
					sjk.konten AS jk,
					DATE_FORMAT(nsb.tgl_lahir,'%d/%m/%Y') AS xtgl_lahir,
					pay.harga_unit_old
				FROM
					mst_nasabah AS nsb
					INNER JOIN tr_payment AS pay ON pay.kode_nasabah = nsb.kode AND pay.iscancelled = 0 AND pay.kode_entity = '".$this->session->userdata('kode_entity')."'
					LEFT JOIN mst_optional_nasabah AS sklas ON sklas.kode = nsb.klasifikasi 
						AND sklas.sfield = 'klasifikasi'
					LEFT JOIN mst_optional_nasabah AS ssalut ON ssalut.kode = nsb.salutation 
						AND ssalut.sfield = 'salutation'
					LEFT JOIN mst_optional_nasabah AS sid ON sid.kode = nsb.jenis_id 
						AND sid.sfield = 'jenis_id'
					LEFT JOIN mst_optional_nasabah AS snat ON snat.kode = nsb.nationality 
						AND snat.sfield = 'nationality'
					LEFT JOIN mst_optional_nasabah AS sag ON sag.kode = nsb.agama 
						AND sag.sfield = 'agama'
					LEFT JOIN mst_optional_nasabah AS sjk ON sjk.kode = nsb.jk 
						AND sjk.sfield = 'jk'
				WHERE
					MD5(pay.no_unit) = '$no_unit'
			";
			$q = $this->db->query($sql);
			$res = $q->row_array();
			if($q->num_rows()>0) {
				foreach($res as $k => $v) {
					$data[$k] = $v;
				}
				$qalm = $this->db->get_where('mst_nasabah_alamat', array('kode_nasabah'=>$res['kode']));
				foreach ($qalm->result_array() as $k => $v) {
					$data['alamats'][] = $v;
				}
			}
		}
		return $data;
	}

	public function get_saleses() {
		$q = $this->db->get('mst_sales');
		return $q->result_array();
	}

	public function get_paymodes() {
		$q = $this->db->get_where('mst_optional_sales', array('sfield'=>'cara_bayar'));
		return $q->result_array();
	}

	public function get_jenis_id() {
		$q = $this->db->get_where('mst_optional', array('opsi'=>'CUSTOMERIDTYPE'));
		return $q->result_array();
	}

	public function get_customer_optional() {
		$this->db->select('sfield,kode,konten')
				->from('mst_optional_nasabah')
				->where(array('isactive'=>1))
				->order_by('sfield,no_urut');
		$q = $this->db->get();
		$data = array();
		foreach ($q->result_array() as $k => $v) {
			$data[$v['sfield']][] = $v;
		}
		return $data;
	}

	public function get_payment_plan($cara) {
		$this->db->distinct()
				->select('kode_pay,deskripsi')
				->where(array('cara_bayar'=>$cara));
		$q = $this->db->get('mst_payment_plan_detail'); 
		return $q->result_array();
	}

	public function get_payment_mode($kode) {
		$sql = "
			SELECT
				pay.kode_pay AS klabel,
				pay.deskripsi AS slabel,
				pay.persentase AS persen,
				pay.rp AS nval,
				/*CASE WHEN pay.limit_day > 0 THEN 0 ELSE 1 END AS has_date,*/
				1 AS has_date,
				pay.limit_day,
				pay.install_num AS nfield,
				pay.tipe_pay AS tipepay,
				0 AS respay
			FROM
				mst_payment_plan_detail AS paydet
				INNER JOIN mst_payment_plan AS pay ON pay.kode_pay = paydet.kode_item
			WHERE
				paydet.kode_pay = '$kode'
			ORDER BY
				paydet.no_urut
		";
		$q = $this->db->query($sql);
		return $q->result_array();
	}

	public function get_reserve($no_unit) {
		$q = $this->db->query("
			SELECT
				mst_stock.no_unit AS no_unit,stypep.konten AS type_property,stypeu.konten AS type_unit,
				stower.konten AS tower_cluster,mst_stock.wide_netto AS wide_netto,mst_stock.wide_gross AS wide_gross,
				slantai.konten AS lantai_blok,sdir.konten AS direction,sangin.konten AS mata_angin,CASE WHEN tr_payment.status_tr = 'HOLD' THEN 
					CASE WHEN DATEDIFF(DATE_ADD(tr_payment.hold_date, INTERVAL 7 DAY), NOW())>0 THEN 'HOLD' ELSE NULL END 
					ELSE tr_payment.status_tr END AS status_tr, 
				tr_payment.hold_date, tr_payment.reserve_date, tr_payment.reserve_no, tr_payment.sales_no, tr_payment.cara_bayar, tr_payment.kode_pay,
				DATE_FORMAT(tr_payment.tgl_akad,'%d/%m/%Y') AS tgl_akad, DATE_FORMAT(tr_payment.tgl_dokumen,'%d/%m/%Y') AS tgl_dokumen,
				DATE_FORMAT(tr_payment.tgl_bangunan,'%d/%m/%Y') AS tgl_bangunan,
				tr_payment.kode_bank
			FROM
				mst_stock
				LEFT JOIN tr_payment ON tr_payment.no_unit=mst_stock.no_unit AND tr_payment.iscancelled = 0 AND tr_payment.kode_entity = '".$this->session->userdata('kode_entity')."'
				LEFT JOIN mst_optional_stock stypep ON  stypep.sfield = 'type_property' AND stypep.kode = mst_stock.type_property 
					AND stypep.sflag = '".$this->session->userdata('type_entity')."'
				LEFT JOIN mst_optional_stock stower ON stower.sfield = 'tower_cluster' AND stower.kode = mst_stock.tower_cluster 
					AND stypep.sflag = '".$this->session->userdata('type_entity')."'
				LEFT JOIN mst_optional_stock stypeu ON stypeu.sfield = 'type_unit' AND stypeu.kode = mst_stock.type_unit 
					AND stypep.sflag = '".$this->session->userdata('type_entity')."'
				LEFT JOIN mst_optional_stock slantai ON slantai.sfield = 'lantai_blok' AND slantai.kode = mst_stock.lantai_blok 
					AND stypep.sflag = '".$this->session->userdata('type_entity')."'
				LEFT JOIN mst_optional_stock sdir ON sdir.sfield = 'direction' AND sdir.kode = mst_stock.direction 
					AND stypep.sflag = '".$this->session->userdata('type_entity')."'
				LEFT JOIN mst_optional_stock sangin ON sangin.sfield = 'mata_angin' AND sangin.kode = mst_stock.mata_angin 
					AND sangin.sflag = '".$this->session->userdata('type_entity')."'
			WHERE
				MD5(mst_stock.no_unit) = '$no_unit'
				AND mst_stock.kode_entity = '".$this->session->userdata('kode_entity')."'
		");
		$data = $q->row_array();
		// unit prices
		$q = $this->db->query("
			SELECT
				mst_unit_price.kode_pay,
				mst_payment_plan_detail.deskripsi AS nama,
				SUM(rp) AS tr_jual
			FROM
				mst_unit_price
				INNER JOIN (
					SELECT
						DISTINCT kode_pay, deskripsi
					FROM
						mst_payment_plan_detail
				) AS mst_payment_plan_detail  ON mst_payment_plan_detail.kode_pay = mst_unit_price.kode_pay
			WHERE
				MD5(no_unit) = '$no_unit'
				AND mst_unit_price.kode_entity = '".$this->session->userdata('kode_entity')."'
			GROUP BY
				kode_pay
		");
		$res = $q->result_array();
		$data['prices'] = $res;
		// terbilang
		$this->load->library('strUtils'); 
		$strObj = new StrUtils();
		foreach ($data['prices'] as $k => $v) {
			$data['prices'][$k]['terbilang'] = $strObj->rp_terbilang($v['tr_jual']);
		}
		// get customer
		$sql = "
			SELECT
				nsb.kode,
				nsb.klasifikasi,
				sklas.konten AS sklasifikasi,
				nsb.salutation,
				ssalut.konten AS ssalutation,
				nsb.nama,
				nsb.jenis_id,
				sid.konten AS sjenis_id,
				nsb.no_id,
				nsb.email,
				nsb.npwp,
				nsb.hp,
				nsb.tempat_lahir,
				nsb.nationality,
				snat.konten AS snationality,
				nsb.agama,
				sag.konten AS sagama,
				nsb.jk,
				sjk.konten AS sjk,
				nsb.alamat,
				DATE_FORMAT(nsb.tgl_lahir,'%d/%m/%Y') AS xtgl_lahir
			FROM
				mst_nasabah AS nsb
				INNER JOIN tr_payment AS pay ON pay.kode_nasabah = nsb.kode AND pay.iscancelled = 0 AND pay.kode_entity = '".$this->session->userdata('kode_entity')."'
				LEFT JOIN mst_optional_nasabah AS sklas ON sklas.kode = nsb.klasifikasi 
					AND sklas.sfield = 'klasifikasi'
				LEFT JOIN mst_optional_nasabah AS ssalut ON ssalut.kode = nsb.salutation 
					AND ssalut.sfield = 'salutation'
				LEFT JOIN mst_optional_nasabah AS sid ON sid.kode = nsb.jenis_id 
					AND sid.sfield = 'jenis_id'
				LEFT JOIN mst_optional_nasabah AS snat ON snat.kode = nsb.nationality 
					AND snat.sfield = 'nationality'
				LEFT JOIN mst_optional_nasabah AS sag ON sag.kode = nsb.agama 
					AND sag.sfield = 'agama'
				LEFT JOIN mst_optional_nasabah AS sjk ON sjk.kode = nsb.jk 
					AND sjk.sfield = 'jk'
			WHERE
				MD5(pay.no_unit) = '$no_unit'
		";
		$q = $this->db->query($sql);
		// $this->db->select('mst_nasabah.*, DATE_FORMAT(mst_nasabah.tgl_lahir,"%d/%m/%Y") AS xtgl_lahir',FALSE)
		// 		->from('mst_nasabah')
		// 		->join('tr_payment','tr_payment.kode_nasabah = mst_nasabah.kode AND tr_payment.iscancelled = 0')
		// 		->where(array('tr_payment.no_unit'=>$no_unit));
		// $q = $this->db->get();
		$res = $q->row_array();
		if($q->num_rows()>0) {
			foreach($res as $k => $v) {
				$data[$k] = $v;
			}
			$qalm = $this->db->get_where('mst_nasabah_alamat', array('kode_nasabah'=>$res['kode']));
			foreach ($qalm->result_array() as $k => $v) {
				$data['alamats'][] = $v;
			}
		}
		return $data;
	}

	public function gen_reserve_no($no_unit) {
		$q = $this->db->get_where('mst_stock', array('no_unit'=>$no_unit, 'kode_entity'=>$this->session->userdata('kode_entity')));
		$res = $q->row_array();
		$entity = $res['kode_entity'];
		$sql = "
			SELECT
				IFNULL(MAX(id),0)+1 AS n
			FROM
				tr_payment
			FOR UPDATE"; 
		$q = $this->db->query($sql);
		$res = $q->row_array();
		return sprintf('RSV-%s-%06d',$entity,$res['n']);
	}

	public function get_payment_details($reserve_no) {
		$this->db->select('IFNULL(nsb.nama,"") AS nsb_nama, stk.no_unit AS no_unit, '.
				'IFNULL(stk.wide_netto,0) AS stk_luas_nett, IFNULL(stk.wide_gross,0) AS stk_luas_gross, '.
				'IFNULL(pay.harga_unit,0) AS harga_unit, op.nama AS cara_bayar,pay.cara_bayar AS cb,pay.kode_pay, pay.reserve_no', FALSE)
			->from('tr_payment AS pay')
			->join('mst_nasabah AS nsb', 'nsb.kode = pay.kode_nasabah', 'inner')
			->join('mst_stock AS stk', 'stk.no_unit = pay.no_unit AND stk.kode_entity = "'.$this->session->userdata('kode_entity').'"', 'inner')
			->join('mst_optional AS op', 'op.kode = pay.cara_bayar', 'inner')
			->where('pay.reserve_no = "'.$reserve_no.'"');
		$q = $this->db->get();
		$res = $q->row_array();
		$data = array();
		if($q->num_rows()>0) {
			foreach($res as $k => $v) {
				$data[$k] = $v;
			}
			
			$this->load->library('strUtils'); 
			$strObj = new StrUtils();
			$data['fharga_unit'] = number_format($data['harga_unit'],2,'.',',');
			$data['terbilang'] = $strObj->rp_terbilang($data['harga_unit']);
			
			$sql = "
				SELECT
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
			$respay = $qpay->result_array();
			foreach($respay as $krow => $vrow) {
				$data['pays'][] = $vrow;
			}

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
					no_urut,
					kode_pay,
					tgl_bayar
			";
			$qdet = $this->db->query($sql);
			$resdet = $qdet->result_array();
			foreach($resdet as $krow => $vrow) {
				$data['paydet_ra'][] = $vrow;
			}
			$sql = "
				SELECT
					kode_pay,
					nama,
					'' AS tgl_tempo,
					'' AS ra_rp,
					IFNULL(DATE_FORMAT(tgl_bayar,'%d/%m/%Y'), '') AS tgl_bayar,
					no_kwitansi,
					rp AS ri_rp,
					'' AS hari_denda,
					'' AS rp_denda,
					no_urut
				FROM
					tr_payment_detail
				WHERE
					reserve_no = '$reserve_no'
					AND tgl_bayar IS NOT NULL
				ORDER BY
					no_urut,
					kode_pay,
					tgl_bayar
			";
			$qdet = $this->db->query($sql);
			$resdet = $qdet->result_array();
			foreach($resdet as $krow => $vrow) {
				$data['paydet_ri'][] = $vrow;
			}
            $sql = "
                SELECT
                    ra.kode_pay,
                    ra.nama,
                    IFNULL(DATE_FORMAT(ra.tgl_tempo,'%d/%m/%Y'), '') AS tgl_tempo,
                    SUM(ra.rp) AS ra_rp,
                    IFNULL(DATE_FORMAT(ri.tgl_bayar,'%d/%m/%Y'), '') AS tgl_bayar,
                    IFNULL(ri.no_kwitansi,'') AS no_kwitansi,
                    IFNULL(SUM(ri.rp),0) AS ri_rp,
                    ra.no_urut
                FROM
                    tr_payment_detail ra
                LEFT JOIN tr_payment_detail as ri ON ri.reserve_no = ra.reserve_no 
                                    AND ri.kode_pay = ra.kode_pay
                                    AND ri.tgl_bayar IS NOT NULL
                WHERE
                    ra.reserve_no = '$reserve_no'
                    AND ra.tgl_bayar IS NULL
                GROUP BY
                    ra.kode_pay,
                    ri.tgl_bayar
                ORDER BY 
                    ra.tgl_tempo,
                    ri.tgl_bayar
            ";
            $qdet = $this->db->query($sql);
			$resdet = $qdet->result_array();
			foreach($resdet as $krow => $vrow) {
				$data['paydet_rari'][] = $vrow;
			}
		}
		return $data;
	}

	public function get_payment_plan_3($mode) {
		$sql = "
			SELECT
				pay.kode_pay AS klabel,
				pay.deskripsi AS slabel,
				pay.persentase AS persen,
				pay.rp AS nval,
				/*CASE WHEN pay.limit_day > 0 THEN 0 ELSE 1 END AS has_date,*/
				1 AS has_date,
				pay.limit_day,
				pay.install_num AS nfield,
				pay.tipe_pay AS tipepay,
				0 AS respay
			FROM
				mst_payment_plan_detail AS paydet
				INNER JOIN mst_payment_plan AS pay ON pay.kode_pay = paydet.kode_item
			WHERE
				paydet.kode_pay = '$mode'
			ORDER BY
				paydet.no_urut
		";
		$q = $this->db->query($sql);
		return $q->result_array();
	}

	public function get_saved_payment($res_no, $cara_bayar, $kode_pay, $plan = 'PLAN1') {
		$sql = "
			SELECT
				paydet.kode_pay AS klabel,
				paydet.nama AS slabel,
				paydet.persentase AS persen,
				paydet.rp AS nval,
				/*CASE WHEN paydet.tgl_tempo IS NULL THEN 0 ELSE 1 END AS has_date,*/
				1 AS has_date,
				1 AS nfield,
				plan.tipe_pay AS tipepay,
				CASE WHEN paydet.tgl_tempo IS NULL THEN '' ELSE DATE_FORMAT(tgl_tempo, '%d/%m/%Y') END AS tgl_tempo,
				CASE WHEN IFNULL(respay.rp,0) > 0 AND respay.kode_pay = paydet.kode_pay THEN 1 ELSE 0 END AS respay
			FROM
				tr_payment AS pay
				LEFT JOIN tr_payment_detail AS paydet ON paydet.reserve_no = pay.reserve_no AND paydet.flag = '$plan'
				LEFT JOIN mst_payment_plan AS plan ON plan.kode_pay = paydet.kode_pay
				LEFT JOIN (
					SELECT
						reserve_no,
						kode_pay,
						rp
					FROM
						tr_payment_detail
					WHERE
						kode_pay = 'RES' AND tgl_bayar IS NOT NULL
				) AS respay ON respay.reserve_no = pay.reserve_no
			WHERE
				pay.reserve_no = '$res_no' 
				AND pay.cara_bayar = '$cara_bayar' AND pay.kode_pay = '$kode_pay' AND tgl_bayar IS NULL
				AND pay.kode_entity = '".$this->session->userdata('kode_entity')."'
			ORDER BY
				paydet.no_urut
		";
        //die('<pre>'.$sql.'</pre>');
		$q = $this->db->query($sql);
		return $q->result_array();
	}
    
    public function get_change_payment($res_no, $cara_bayar, $kode_pay, $plan = 'PLAN1') {
		$sql = "
			SELECT
                paydet.kode_pay AS klabel,
                paydet.nama AS slabel,
                paydet.persentase AS persen,
                paydet.rp AS nval,
                sum(respay.rp) AS ripay,
	            DATE_FORMAT(respay.tgl_bayar, '%d/%m/%Y') as tglbayar,
                /*CASE WHEN paydet.tgl_tempo IS NULL THEN 0 ELSE 1 END AS has_date,*/
                1 AS has_date,
                1 AS nfield,
                plan.tipe_pay AS tipepay,
                CASE WHEN paydet.tgl_tempo IS NULL THEN '' ELSE DATE_FORMAT(paydet.tgl_tempo, '%d/%m/%Y') END AS tgl_tempo,
                CASE WHEN IFNULL(respay.rp,0) > 0 AND respay.kode_pay = paydet.kode_pay THEN 1 ELSE 0 END AS respay
            FROM
                tr_payment AS pay	
                LEFT JOIN tr_payment_detail AS paydet ON paydet.reserve_no = pay.reserve_no AND paydet.flag = '$plan'
                LEFT JOIN mst_payment_plan AS plan ON plan.kode_pay = paydet.kode_pay
                LEFT JOIN tr_payment_detail as respay ON respay.reserve_no = paydet.reserve_no 
					AND respay.kode_pay = paydet.kode_pay
					AND respay.tgl_bayar IS NOT NULL
                /*LEFT JOIN (
                    SELECT
                        reserve_no,
                        kode_pay,
                        rp
                    FROM
                        tr_payment_detail
                    WHERE
                        tgl_bayar IS NOT NULL
                ) AS respay ON respay.reserve_no = pay.reserve_no*/
			WHERE
				pay.reserve_no = '$res_no' 
				AND pay.cara_bayar = '$cara_bayar' AND pay.kode_pay = '$kode_pay' AND paydet.tgl_bayar IS NULL
				AND pay.kode_entity = '".$this->session->userdata('kode_entity')."'
            GROUP BY klabel, tglbayar
			ORDER BY
				paydet.no_urut, tglbayar DESC
		";
        //die('<pre>'.$sql.'</pre>');
		$q = $this->db->query($sql);
		return $q->result_array();
	}

	public function get_kwitansi($no_kwitansi) {
		$q = $this->db->query("
			SELECT
				paydet.no_kwitansi,
				nsb.nama,
				CASE WHEN MAX(paydet.rp_diterima)>0 THEN paydet.rp_diterima ELSE paydet.rp END AS rp,
				pay.no_unit,
				DATE_FORMAT(paydet.tgl_bayar,'%d-%m-%Y') AS tgl_bayar,
				ent.nama AS nama_entity,
				ent.kota_marketing,
				ent.mgr_proyek
			FROM
				tr_payment_detail paydet
				INNER JOIN tr_payment pay ON pay.reserve_no = paydet.reserve_no AND pay.kode_entity = '".$this->session->userdata('kode_entity')."'
				INNER JOIN mst_nasabah nsb ON nsb.kode = pay.kode_nasabah
				INNER JOIN mst_stock stk ON stk.no_unit = pay.no_unit AND stk.kode_entity = '".$this->session->userdata('kode_entity')."'
				INNER JOIN mst_entity ent ON ent.kode = stk.kode_entity AND ent.kode = '".$this->session->userdata('kode_entity')."'
			WHERE
				paydet.no_kwitansi = '$no_kwitansi'
			GROUP BY
				paydet.no_kwitansi
		");
		$data = $q->row_array();
		if($q->num_rows()>0) {
			//terbilang
			$this->load->library('strUtils'); 
			$strObj = new StrUtils();
			$data['terbilang'] = $strObj->rp_terbilang($data['rp']);
			$data['rp'] = number_format($data['rp'],0);

			$q = $this->db->query("
				SELECT
					nama,
					FORMAT(rp,0) AS rp
				FROM
					tr_payment_detail
				WHERE
					no_kwitansi = '$no_kwitansi'
			");
			$data['pays'] = $q->result_array();
		}
		return $data;
	}

	public function get_bank_kpr() {
		$q = $this->db->get_where('mst_bank', array('iskpr'=>1));
		return $q->result_array();
	}
	
	public function get_bank_ops() {
		$q = $this->db->get_where('mst_bank', array('is_ops'=>1,'kode_entity'=>$this->session->userdata('kode_entity')));
		return $q->result_array();
	}

	public function get_reserve_and_payment_data($reserve_no) {
		$this->db->select('IFNULL(nsb.nama,"") AS nsb_nama, stk.no_unit AS no_unit, '.
				'IFNULL(stk.wide_netto,0) AS stk_luas_nett, IFNULL(stk.wide_gross,0) AS stk_luas_gross, '.
				'IFNULL(pay.harga_unit,0) AS harga_unit, op.nama AS cara_bayar, pay.cara_bayar as cb, mpay.deskripsi AS pola_bayar, '.
				'pay.reserve_no, pay.kode_entity, pay.kode_pay', FALSE)
			->from('tr_payment AS pay')
			->join('mst_nasabah AS nsb', 'nsb.kode = pay.kode_nasabah', 'inner')
			->join('mst_stock AS stk', 'stk.no_unit = pay.no_unit AND stk.kode_entity = "'.$this->session->userdata('kode_entity').'"', 'inner')
			->join('mst_optional AS op', 'op.kode = pay.cara_bayar', 'inner')
			->join('(SELECT DISTINCT kode_pay, deskripsi FROM mst_payment_plan_detail) AS mpay', 'mpay.kode_pay = pay.kode_pay', 'inner')
			->where('pay.reserve_no = "'.$reserve_no.'"');
		$q = $this->db->get();
		$res = $q->row_array();
		$data = array();
		if($q->num_rows()>0) {
			foreach($res as $k => $v) {
				$data[$k] = $v;
			}
			$this->load->library('strUtils'); 
			$strObj = new StrUtils();
			$data['fharga_unit'] = number_format($data['harga_unit'],2,'.',',');
			$data['terbilang'] = $strObj->rp_terbilang($data['harga_unit']);
			// unit price netto
			$this->db->select('SUM(rp) AS rp_netto', FALSE)
				->from('mst_unit_price')
				->where(array('kode_entity'=>$data['kode_entity'], 'no_unit'=>$data['no_unit'], 'kode_pay'=>$data['kode_pay'],
					'grup'=>'NETTO', 'isactive'=>1));
			$qpr = $this->db->get();
			$respr = $qpr->row_array();
			$data['rp_netto'] = $respr['rp_netto'];
			// trx TJ (5%)
			$sql = "
				SELECT
					SUM(paydet.rp) AS tj_rp
				FROM
					tr_payment_detail AS paydet
					INNER JOIN mst_payment_plan AS plan ON plan.kode_pay = paydet.kode_pay AND plan.tipe_pay = 'BOOKINGFEE'
				WHERE
					paydet.reserve_no = '$reserve_no'
					AND paydet.tgl_bayar IS NOT NULL
			";
			$qtj = $this->db->query($sql);
			$restj = $qtj->row_array();
			$data['rp_tj'] = $restj['tj_rp'];
			// trx payment detail
			$sql = "
				SELECT
					nama,
					IFNULL(DATE_FORMAT(tgl_bayar,'%d/%m/%Y'), '') AS tgl_bayar,
					rp AS ri_rp,
					no_urut
				FROM
					tr_payment_detail
				WHERE
					reserve_no = '$reserve_no'
					AND tgl_bayar IS NOT NULL
				ORDER BY
					no_urut,
					kode_pay,
					tgl_bayar
			";
			$qdet = $this->db->query($sql);
			$resdet = $qdet->result_array();
			foreach($resdet as $krow => $vrow) {
				$data['paydet_ri'][] = $vrow;
			}
		}
		return $data;
	}

	public function get_diskon() {
		$q = $this->db->get('mst_diskon');
		return $q->result_array();
	}

	public function save_hold($payment, $customer, $dataAlamat, $idxAlamat) {
		$q = $this->db->get_where('tr_payment', array('kode_nasabah'=>$payment['kode_nasabah'],'no_unit'=>$payment['no_unit'],'iscancelled'=>0, 'kode_entity'=>$this->session->userdata('kode_entity')));
		if($q->num_rows()>0) {
			$this->db->where(array('kode_nasabah'=>$payment['kode_nasabah'],'no_unit'=>$payment['no_unit'],'iscancelled'=>0,'kode_entity'=>$this->session->userdata('kode_entity')));
			$this->db->update('tr_payment', $payment);
		} else {
			$this->db->insert('tr_payment', $payment);
		}

		$q = $this->db->get_where('mst_nasabah', array('kode'=>$customer['kode']));
		if($q->num_rows()>0) {
			$this->db->where(array('kode'=>$customer['kode']));
			$this->db->update('mst_nasabah', $customer);
		} else {
			$this->db->insert('mst_nasabah', $customer);
		}

		$this->db->where(array('kode_nasabah'=>$customer['kode']));
		$this->db->delete('mst_nasabah_alamat');
		foreach ($dataAlamat as $k => $v) {
			$q = $this->db->insert('mst_nasabah_alamat', $v);
			if($k===intval($idxAlamat)) {
				$this->db->where(array('kode'=>$customer['kode']));
				$this->db->update('mst_nasabah', array('alamat'=>$this->db->insert_id()));
			}
		}
	}

	public function extend_hold($no_unit) {
		// return $this->db->where(array('MD5(no_unit)'=>$no_unit))
		// 		->update('tr_payment', array('hold_date'=>'DATE_ADD(hold_date, INTERVAL 7 DAY)','hold_extend'=>1));
		return $this->db->query("UPDATE tr_payment SET hold_date = DATE_ADD(hold_date, INTERVAL 7 DAY), hold_extend = 1 WHERE MD5(no_unit) = '$no_unit' AND kode_entity = '".$this->session->userdata('kode_entity')."'");
	}

	public function cancel_hold($no_unit) {
		$this->db->where(array('MD5(no_unit)'=>$no_unit, 'kode_entity'=>$this->session->userdata('kode_entity')));
		return $this->db->update('tr_payment', array('iscancelled'=>1));
	}

	public function _update_booking2($payment, $paymentdet, $customer, $dataAlamat, $idxAlamat) {
		$q = $this->db->get_where('tr_payment', array('kode_nasabah'=>$payment['kode_nasabah'],'no_unit'=>$payment['no_unit'],'iscancelled'=>0, 'kode_entity'=>$this->session->userdata('kode_entity')));
		if($q->num_rows()>0) {
			$this->db->where(array('kode_nasabah'=>$payment['kode_nasabah'],'no_unit'=>$payment['no_unit'],'iscancelled'=>0, 'kode_entity'=>$this->session->userdata('kode_entity')));
			$this->db->update('tr_payment', $payment);
		} else {
			$this->db->insert('tr_payment', $payment);
		}
		
		foreach($paymentdet as $k => $v) {
			$q = $this->db->get_where('tr_payment_detail', array('reserve_no'=>$v['reserve_no'],'kode_pay'=>$v['kode_pay'],
					'no_urut'=>$v['no_urut'],'flag'=>$v['flag'],'tgl_bayar'=>null));
			if($q->num_rows()>0) {
				$this->db->where(array('reserve_no'=>$v['reserve_no'],'kode_pay'=>$v['kode_pay'],'no_urut'=>$v['no_urut'],'tgl_bayar'=>null));
				$this->db->update('tr_payment_detail', $v);
			} else {
				$this->db->insert('tr_payment_detail', $v);
			}
			if($v['kode_pay']==='RES') {
				$this->db->where(array('kode_nasabah'=>$payment['kode_nasabah'],'no_unit'=>$payment['no_unit'],'iscancelled'=>0, 'kode_entity'=>$this->session->userdata('kode_entity')));
				$this->db->update('tr_payment', array('reserve_date'=>$v['tgl_tempo']));
			}
			if($v['kode_pay']==='TJ') {
				$this->db->where(array('kode_nasabah'=>$payment['kode_nasabah'],'no_unit'=>$payment['no_unit'],'iscancelled'=>0, 'kode_entity'=>$this->session->userdata('kode_entity')));
				$this->db->update('tr_payment', array('booking_date'=>$v['tgl_tempo']));
			}
		}
		
		$q = $this->db->get_where('mst_nasabah', array('kode'=>$customer['kode']));
		if($q->num_rows()>0) {
			$this->db->where(array('kode'=>$customer['kode']));
			$this->db->update('mst_nasabah', $customer);
		} else {
			$this->db->insert('mst_nasabah', $customer);
		}

		$this->db->where(array('kode_nasabah'=>$customer['kode']));
		$this->db->delete('mst_nasabah_alamat');
		foreach ($dataAlamat as $k => $v) {
			$q = $this->db->insert('mst_nasabah_alamat', $v);
			if($k===intval($idxAlamat)) {
				$this->db->where(array('kode'=>$customer['kode']));
				$this->db->update('mst_nasabah', array('alamat'=>$this->db->insert_id()));
			}
		}
	}
	
	public function save_confirm_payment($data, $status) {
		// sum current rp
		$q = $this->db->query("
			SELECT
				SUM(CASE WHEN tgl_bayar IS NULL THEN rp ELSE (rp*-1) END) AS rp
			FROM
				tr_payment_detail
			WHERE
				reserve_no = '".$data['reserve_no']."'
				AND kode_pay = '".$data['kode_pay']."'
				AND no_urut = '".$data['no_urut']."'
			GROUP BY
				reserve_no,
				kode_pay,
				no_urut
		");
		$res = $q->row_array();
		$oldRP = $res['rp'];
		$payRP = $data['rp'];
		$toRP = $payRP - $oldRP;
		// tanggal kwitansi
		$stgl = $this->dateutils->dateStr_to_mysql($this->input->post('tgl_bayar'));
		list($t,$b,$h) = explode('-',$stgl);
		if($toRP>0) {
			$data['rp'] = $oldRP;
			$data['rp_diterima'] = $payRP;
			$this->db->insert('tr_payment_detail', $data);
			// update no kwitansi
			$no_kwitansi = sprintf('KWT-%s%s%06d',substr($t,2),$b,$this->db->insert_id());
			$this->db->where(array('id'=>$this->db->insert_id()));
			$this->db->update('tr_payment_detail', array('no_kwitansi'=>$no_kwitansi));
			// loop every ra. payment
			$iLoop = 1;
			while($toRP>0) {
				$qnext = $this->db->query("
					SELECT
						*
					FROM
						tr_payment_detail
					WHERE
						reserve_no = '".$data['reserve_no']."'
						AND no_urut = '".(intval($data['no_urut'])+$iLoop)."'
						AND tgl_bayar IS NULL
				");
				if($qnext->num_rows()>0) {
					$resnext = $qnext->row_array();
					$payRP = $resnext['rp'];
					if($toRP<$payRP) {
						$payRP = $toRP;
					}
					$toRP -= $payRP;
					$datanext = array(
						'reserve_no'=>$data['reserve_no'],
						'kode_pay'=>$resnext['kode_pay'],
						'nama'=>$resnext['nama'],
						'rp'=>$payRP,
						'tgl_bayar'=>$stgl,
						'no_kwitansi'=>$no_kwitansi,
						'no_urut'=>$resnext['no_urut']
					);
					$this->db->insert('tr_payment_detail', $datanext);
					// update no kwitansi
					// $no_kwitansi = sprintf('KWT-%s%s%06d',substr($t,2),$b,$this->db->insert_id());
					// $this->db->where(array('id'=>$this->db->insert_id()));
					// $this->db->update('tr_payment_detail', array('no_kwitansi'=>$no_kwitansi));

					// update trx status
					if($resnext['kode_pay']==='RES')
						$status = 'RESERVE';
					elseif($resnext['kode_pay']==='TJ')
						$status = 'BOOKING';
					else
						$status = 'SALES';
					$this->db->where(array('reserve_no'=>$data['reserve_no']));
					$this->db->update('tr_payment', array('status_tr'=>$status));
				}
				$iLoop++;
			}
		} else {
			$this->db->insert('tr_payment_detail', $data);
			// update no kwitansi
			$no_kwitansi = sprintf('KWT-%s%s%06d',substr($t,2),$b,$this->db->insert_id());
			$this->db->where(array('id'=>$this->db->insert_id()));
			$this->db->update('tr_payment_detail', array('no_kwitansi'=>$no_kwitansi));
		}
		// update status trx
		$this->db->where(array('reserve_no'=>$data['reserve_no']));
		return $this->db->update('tr_payment', array('status_tr'=>$status));	
	}

	public function save_cancellation($data) {
		// insert into payment custom
		$this->db->insert('tr_payment_custom', $data);
		// cancel trx payment
		$this->db->where(array('reserve_no'=>$data['reserve_no']));
		return $this->db->update('tr_payment', array('iscancelled'=>1));	
	}

	public function save_change_owner($data) {
		// get trx payment
		$qTRold = $this->db->get_where('tr_payment', array('reserve_no'=>$data['reserve_no_old']));
		$resTRold = $qTRold->row_array();
		// get trx payment detail
		$qTRDETold = $this->db->get_where('tr_payment_detail', array('reserve_no'=>$data['reserve_no_old']));
		$resTRDETold = $qTRDETold->result_array();
		// new kode nasabah
		$this->load->model('mst_nasabah_model');
		$newKdNasabah = $this->mst_nasabah_model->gen_kode_nasabah($resTRold['no_unit']);
		// new trx
		$newResNo = $this->gen_reserve_no($resTRold['no_unit']);
		$newTrx = $resTRold;
		$newTrx['id'] = null;
		$newTrx['reserve_no'] = $newResNo;
		$newTrx['kode_nasabah'] = $newKdNasabah;
		// insert new trx
		$this->db->insert('tr_payment', $newTrx);
		// insert new trx detail
		foreach ($resTRDETold as $k => $v) {
			$v['id'] = null;
			$v['reserve_no'] = $newResNo;
			$this->db->insert('tr_payment_detail', $v);
		}
		// new customer
		$newCustomer = array(
			'jenis'=>'CUSTOMER',
			'kode'=>$newKdNasabah,
			'klasifikasi'=>$data['klasifikasi'],
			'salutation'=>$data['salutation'],
			'nama'=>$data['nama'],
			'jenis_id'=>$data['jenis_id'],
			'no_id'=>$data['no_id'],
			'npwp'=>$data['npwp'],
			'email'=>$data['email'],
			'hp'=>$data['hp'],
			'tempat_lahir'=>$data['tempat_lahir'],
			'tgl_lahir'=>$data['tgl_lahir'],
			'nationality'=>$data['nationality'],
			'agama'=>$data['agama'],
			'jk'=>$data['jk'],
			// 'nama_perusahaan'=>$data['nama_perusahaan'],
			// 'alamat_perusahaan'=>$data['alamat_perusahaan'],
			// 'kota_perusahaan'=>$this->input->post('kota_perusahaan'),
			// 'kodepos_perusahaan'=>$this->input->post('kodepos_perusahaan'),
			// 'telp_perusahaan'=>$this->input->post('telp_perusahaan'),
			// 'fax_perusahaan'=>$this->input->post('fax_perusahaan'),
			// 'jenis_pekerjaan'=>$this->input->post('jenis_pekerjaan'),
			// 'status_pekerjaan'=>$this->input->post('status_pekerjaan'),
			// 'lama_bekerja'=>$this->input->post('lama_bekerja'),
			// 'jenis_usaha'=>$this->input->post('jenis_usaha'),
			// 'jabatan'=>$this->input->post('jabatan'),
			// 'pendapatan'=>$this->input->post('pendapatan'),
			// 'sumber_pendapatan_tambahan'=>$this->input->post('sumber_pendapatan_tambahan'),
			// 'pendapatan_tambahan'=>$this->input->post('pendapatan_tambahan')
		);
		// insert new customer
		$this->db->insert('mst_nasabah', $newCustomer);
		// new customer alamat
		$dataAlamat = array();
		$alamats = $data['alamat'];
		$kotas = $data['kota'];
		$kodepos = $data['kodepos'];
		$telps = $data['telp'];
		$faxs = $data['fax'];
		foreach ($alamats as $k => $v) {
			$item = array(
				'kode_nasabah' => $newKdNasabah,
				'alamat' => $alamats[$k],
				'kota' => $kotas[$k],
				'kodepos' => $kodepos[$k],
				'telp' => $telps[$k],
				'fax' => $faxs[$k]
			);
			$dataAlamat[] = $item;
		}
		$idxAlamat = $data['idx-alamat'];
		// insert new alamat
		$this->db->where(array('kode_nasabah'=>$newKdNasabah));
		$this->db->delete('mst_nasabah_alamat');
		foreach ($dataAlamat as $k => $v) {
			$q = $this->db->insert('mst_nasabah_alamat', $v);
			if($k===intval($idxAlamat)) {
				$this->db->where(array('kode'=>$newKdNasabah));
				$this->db->update('mst_nasabah', array('alamat'=>$this->db->insert_id()));
			}
		}
		// trx custom
		$custom = array(
			'jenis'=>'CHANGEOWNER',
			'tanggal'=>$data['tanggal'],
			'reserve_no'=>$newResNo,
			'reserve_no_old'=>$data['reserve_no_old'],
			'remarks'=>$data['remarks'],
			'adm_rp'=>$data['adm_rp']
		);
		// insert custom
		$this->db->insert('tr_payment_custom', $custom);
		// cancel old trx
		$this->db->where(array('reserve_no'=>$data['reserve_no_old']));
		$this->db->update('tr_payment', array('iscancelled'=>1));
		return "Data tersimpan.\nNo. Reserve (baru): $newResNo.\nKode Nasabah (baru): $newKdNasabah.";
	}

	public function save_change_unit($data) {
		// load date lib
		$this->load->library('dateUtils');
		$dateutils = new DateUtils();
		// get trx payment
		$qTRold = $this->db->get_where('tr_payment', array('reserve_no'=>$data['reserve_no_old']));
		$resTRold = $qTRold->row_array();
		// get trx payment detail
		$qTRDETold = $this->db->get_where('tr_payment_detail', array('reserve_no'=>$data['reserve_no_old']));
		$resTRDETold = $qTRDETold->result_array();
		// new kode nasabah
		$this->load->model('mst_nasabah_model');
		$newKdNasabah = $this->mst_nasabah_model->gen_kode_nasabah($data['no_unit']);
		// new trx
		$newResNo = $this->gen_reserve_no($resTRold['no_unit']);
		$newTrx = array(
			'cara_bayar'=>$data['cara_bayar'],
			'kode_pay'=>$data['kode_pay'],
			'kode_entity'=>$this->session->userdata('kode_entity'),
			'no_unit'=>$data['no_unit'],
			'sales_no'=>$data['sales_no'],
			'kode_nasabah'=>$newKdNasabah,
			'harga_unit'=>$data['harga'],
			'reserve_no'=>$newResNo,
			'hold_date'=>$data['hold_date']===''?null:$data['hold_date'],
			'reserve_date'=>date('Y-m-d'),
			'status_tr'=>$data['status_tr'],
			'tgl_akad'=>$data['tgl_akad'],
			'tgl_dokumen'=>$data['tgl_dokumen'],
			'kode_bank'=>$data['kode_bank']
		);
		// insert new trx
		$this->db->insert('tr_payment', $newTrx);
		// get ri bayar
		$sql = "
			SELECT
				SUM(rp) AS ri_rp
			FROM
				tr_payment_detail
			WHERE
				reserve_no = '".$data['reserve_no_old']."'
				AND tgl_bayar IS NOT NULL
		";
		$qTRRIold = $this->db->query($sql);
		$resTRRIold = $qTRRIold->row_array();
		// insert new trx detail
		$kodepays = $data['fkodepay'];
		$namapays = $data['fnamapay'];
		$persenpays = $data['fpersenpay'];
		$valpays = $data['fvalpay'];
		$tglpays = $data['ftglpay'];
		$no_urut = 1;
		foreach($kodepays as $k => $v) {
			$item = array(
				'reserve_no'=>$newResNo,
				'kode_pay'=>$v,
				'nama'=>$namapays[$k],
				'persentase'=>$persenpays[$k],
				'rp'=>str_replace(',','',$valpays[$k]),
				'tgl_tempo'=>$dateutils->dateStr_to_mysql($tglpays[$k]),
				'no_urut'=>$no_urut,
				'flag'=>'PLAN1'
			);
			$this->db->insert('tr_payment_detail', $item);
			$no_urut++;
		}
		// ri trx detail
		// tanggal kwitansi
		$stgl = date('Y-m-d');
		list($t,$b,$h) = explode('-',$stgl);
		// loop every ra. payment
		$toRP = $resTRRIold['ri_rp'];
		$iLoop = 1;
		$no_kwitansi = '';
		$trID = 0;
		while($toRP>0) {
			$qnext = $this->db->query("
				SELECT
					*
				FROM
					tr_payment_detail
				WHERE
					reserve_no = '".$newResNo."'
					AND no_urut = '".$iLoop."'
					AND tgl_bayar IS NULL
			");
			if($qnext->num_rows()>0) {
				$resnext = $qnext->row_array();
				$payRP = $resnext['rp'];
				if($toRP<$payRP) {
					$payRP = $toRP;
				}
				$toRP -= $payRP;
				$datanext = array(
					'reserve_no'=>$newResNo,
					'kode_pay'=>$resnext['kode_pay'],
					'nama'=>$resnext['nama'],
					'rp'=>$payRP,
					'tgl_bayar'=>date('Y-m-d'),
					'no_kwitansi'=>$no_kwitansi,
					'no_urut'=>$resnext['no_urut']
				);
				$this->db->insert('tr_payment_detail', $datanext);
				$trID = $this->db->insert_id();
				// update trx status
				if($resnext['kode_pay']==='RES')
					$status = 'RESERVE';
				elseif($resnext['kode_pay']==='TJ')
					$status = 'BOOKING';
				else
					$status = 'SALES';
			}
			if($iLoop===1) {
				// update no kwitansi
				$no_kwitansi = sprintf('KWT-%s%s%06d',substr($t,2),$b,$this->db->insert_id());
				$this->db->where(array('id'=>$trID));
				$this->db->update('tr_payment_detail', array('no_kwitansi'=>$no_kwitansi, 'rp_diterima'=>$resTRRIold['ri_rp']));
			}
			$this->db->where(array('reserve_no'=>$data['reserve_no']));
			$this->db->update('tr_payment', array('status_tr'=>$status));
			$iLoop++;
		}
		// get nasabah
		$qNSBold = $this->db->get_where('mst_nasabah', array('kode'=>$resTRold['kode_nasabah']));
		$resNSBold = $qNSBold->row_array();
		// new customer
		$newCustomer = $resNSBold;
		$newCustomer['id'] = null;
		$newCustomer['kode'] = $newKdNasabah;
		// insert new customer
		$this->db->insert('mst_nasabah', $newCustomer);
		// get nasabah alamat
		$qNSBAold = $this->db->get_where('mst_nasabah_alamat', array('kode_nasabah'=>$resTRold['kode_nasabah']));
		$resNSBAold = $qNSBAold->result_array();
		foreach ($resNSBAold as $k => $v) {
			$idx = $v['id'];
			$v['id'] = null;
			$v['kode_nasabah'] = $newKdNasabah;
			$this->db->insert('mst_nasabah_alamat', $v);
			if($idx===$resNSBold['alamat']) {
				$this->db->where(array('kode'=>$newKdNasabah));
				$this->db->update('mst_nasabah', array('alamat'=>$this->db->insert_id()));
			}
		}
		// trx custom
		$custom = array(
			'jenis'=>'CHANGEUNIT',
			'tanggal'=>$data['tanggal'],
			'reserve_no'=>$newResNo,
			'reserve_no_old'=>$data['reserve_no_old'],
			'remarks'=>$data['remarks'],
			'adm_rp'=>$data['adm_rp']
		);
		// insert custom
		$this->db->insert('tr_payment_custom', $custom);
		// cancel old trx
		$this->db->where(array('reserve_no'=>$data['reserve_no_old']));
		$this->db->update('tr_payment', array('iscancelled'=>1));
		if ($this->db->trans_status() === FALSE) {
			return "Terjadi kesalahan, silahkan hubungi administrator anda.";
		} else {
			return "Data tersimpan.\nNo. Reserve (baru): $newResNo.\nKode Nasabah (baru): $newKdNasabah.";
		}
	}

	public function do_integration($data) {
		/* sample data
		$data = array(
			'reserve_no'=>'RSV-TCBR-000002',
			'no_unit'=>'H.A/2',
			'rp'=>5000000,
			'tanggal'=>'2015-06-26',
			'kode_nasabah'=>'H.A/2-000004',
			'no_invoice'=>'KWT-1506000015'
		);
		*/
		// todo: PROGRESS ?
		if($this->session->userdata('type_entity')==='LD') {
			$sql = "
				SELECT
					IFNULL(SUM(hpp.rp),0) AS hpp,
					IFNULL(SUM(ri.rp),0) AS ri
				FROM
					mst_stock s
				LEFT JOIN (
					SELECT
						kode_entity,
						no_unit,
						SUM(rp) AS rp
					FROM
						tr_hpp
					GROUP BY
						kode_entity,
						no_unit
				) AS hpp ON hpp.kode_entity = s.kode_entity
				AND hpp.no_unit = s.no_unit
				LEFT JOIN (
					SELECT
						invunit.kode_entity,
						invunit.no_unit,
						inv.rp / tbl.n AS rp
					FROM
						tr_invoice_unit invunit
					LEFT JOIN (
						SELECT
							no_po,
							COUNT(*) AS n
						FROM
							tr_invoice_unit
						GROUP BY
							no_po
					) AS tbl ON tbl.no_po = invunit.no_po
					INNER JOIN tr_invoice inv ON inv.no_po = invunit.no_po
				) AS ri ON ri.kode_entity = s.kode_entity AND ri.no_unit = s.no_unit
				WHERE
					s.kode_entity = '".$this->session->userdata('kode_entity')."'
					AND s.no_unit = '".$data['no_unit']."'
				GROUP BY
					s.kode_entity,
					s.no_unit
			";
		} elseif($this->session->userdata('type_entity')==='HR') {
			$sql = "
				SELECT
					IFNULL(SUM(hpp.rp), 0) AS hpp,
					IFNULL(SUM(ri.rp), 0) AS ri
				FROM
					mst_stock s
				LEFT JOIN (
					SELECT
						stk.kode_entity,
						stk.no_unit,
						stk.wide_gross * SUM(hpp.rp) / rik.luas AS rp
					FROM
						tr_hpp_hr hpp
					INNER JOIN mst_stock stk ON stk.kode_entity = hpp.kode_entity
						AND stk.type_property = hpp.type_property
					INNER JOIN (
						SELECT
							kode_entity,
							type_property,
							SUM(luas * volume) AS luas
						FROM
							tr_rik_detail_rencana_produk
						GROUP BY
							kode_entity,
							type_property
					) AS rik ON rik.kode_entity = hpp.kode_entity
						AND rik.type_property = hpp.type_property
					GROUP BY
						stk.kode_entity,
						stk.type_property,
						stk.no_unit
				) AS hpp ON hpp.kode_entity = s.kode_entity
				AND hpp.no_unit = s.no_unit
				LEFT JOIN (
					SELECT
						invunit.kode_entity,
						invunit.no_unit,
						inv.rp / tbl.n AS rp
					FROM
						tr_invoice_unit invunit
					LEFT JOIN (
						SELECT
							no_po,
							COUNT(*) AS n
						FROM
							tr_invoice_unit
						GROUP BY
							no_po
					) AS tbl ON tbl.no_po = invunit.no_po
					INNER JOIN tr_invoice inv ON inv.no_po = invunit.no_po
				) AS ri ON ri.kode_entity = s.kode_entity AND ri.no_unit = s.no_unit
				WHERE
					s.kode_entity = '".$this->session->userdata('kode_entity')."'
					AND s.no_unit = '".$data['no_unit']."'
			";
		}
		$q = $this->db->query($sql);
		$resProg = $q->row_array();
		$prog = number_format($resProg['ri']/$resProg['hpp']*100,2);
		$progPer = $prog>0 ? $prog/100 : 0;
		// math lib
		$this->load->library('MathParser');
		$math = new MathParser();
		$math->setVars(
			array(
				'PROG'=>$progPer,
				'RP'=>$data['rp']
			)
		);
		$q = $this->db->get_where('setting_coa', array('tr_type'=>'RIPAYMENT'));
		$dataSetCoa = $q->result_array();
		//gen no. bukti, kode batch
		$kode_divisi = 'P';
		list($thn, $bln, $tgl) = explode('-', $data['tanggal']);
		$this->db->select('kode_batch')
			->from('tr_accounting')
			->where('kode_divisi = "'.$kode_divisi.'" AND MONTH(tanggal) = '.$bln.' AND YEAR(tanggal) = '.$thn)
			->order_by('kode_batch DESC');
		$q = $this->db->get();
		if($q->num_rows()>0) {
			$resAcc = $q->row_array();
			$kode_batch = sprintf('%06d', ltrim($resAcc['kode_batch'], '0')+1);
		} else {
			$kode_batch = '000001';
		}
		foreach ($dataSetCoa as $k => $v) {
			$rp = $math->execute($v['formulas']);
			$dataAcc = array(
				'kode_divisi'=>$kode_divisi,
				'tanggal'=>$data['tanggal'],
				'jenis'=>'B',
				'no_bukti'=>$kode_batch.'/'.$bln.'/B/'.$thn,
				'no_invoice'=>$data['no_invoice'],
				'kode_coa'=>$v['coa'],
				'kode_nasabah'=>$data['kode_nasabah'],
				'kode_spk'=>$this->session->userdata('kode_entity'),
				'keterangan'=>$data['reserve_no'].' PROG:'.$prog.'%',
				'dk'=>$v['dk'],
				'rupiah'=>$rp,
				'kode_modul'=>'RIPAYMENT',
				'kode_batch'=>$kode_batch,
				'tr_level'=>'PROYEK'
			);
			$this->db->insert('tr_accounting', $dataAcc);
			if($v['varname']!=='') {
				$math->setVars(
					array(
						$v['varname']=>$rp
					),
					FALSE
				);
			}
			// echo '<br>execute: ';
			// print_r($dataAcc);
		}
		// insert posting status
		$this->db->insert('tr_posting_jurnal_ar', array(
			'reserve_no'=>$data['reserve_no'],
			'payment_id'=>$data['payment_id'],
			'progress'=>$prog,
			'rp'=>$data['rp'],
			'tgl_posting'=>date('Y-m-d')
		));
	}
		
}
	
