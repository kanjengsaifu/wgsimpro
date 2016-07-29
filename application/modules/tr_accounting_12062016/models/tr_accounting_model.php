<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tr_accounting_model extends CI_Model {
	
    function __construct() {
        //$this->traccTable = 'tr_accounting';
    }

    public function get_integration_ar($payid) {
		$this->db->select('paydet.id AS payment_id, paydet.reserve_no, pay.no_unit, paydet.rp, paydet.tgl_bayar AS tanggal, pay.kode_nasabah, paydet.no_kwitansi AS no_invoice')
			->from('tr_payment_detail paydet')
			->join('tr_payment pay', 'pay.reserve_no = paydet.reserve_no', 'inner')
			->where(array('paydet.id'=>$payid));
		$q = $this->db->get();
		return $q->row_array();
	}

    function getDivisi($username)
    {
        $array = array('udiv.username' => $this->session->userdata('usernm'));
        $this->db->where($array); 
        $this->db->select('udiv.divisi_level, mdiv.kode, mdiv.nama');
        $this->db->from('t_user_divisi udiv');
        $this->db->join('mst_divisi mdiv', 'mdiv.kode = udiv.kode_divisi','inner');

        $query = $this->db->get();

        return $res = $query->row_array();
    }

    function getRows($params = array())
    {
        $this->db->select('*');
        $this->db->from($this->traccTable);
        $this->db->order_by('no_bukti','asc');
        $this->db->order_by('tanggal','asc');
        
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }
        
        $query = $this->db->get();
        
        return ($query->num_rows() > 0)?$query->result_array():FALSE;
    }

	public function get_datacombo() {
        $data = array();
        $q = $this->db->get('mst_coa');
        $res = $q->result_array(); 
        foreach($res as $k => $v) {
            foreach($v as $k2 => $v2) {
                $data['coa'][$k][$k2] = $v2;
            }
        }

        $q = $this->db->get('mst_nasabah');
        $res = $q->result_array(); 
        foreach($res as $k => $v) {
            foreach($v as $k2 => $v2) {
                $data['nasabah'][$k][$k2] = $v2;
            }
        }


        $q = $this->db->get('mst_sumberdaya');
        $res = $q->result_array(); 
        foreach($res as $k => $v) {
            foreach($v as $k2 => $v2) {
                $data['sumberdaya'][$k][$k2] = $v2;
            }
        }

        $q = $this->db->get('tr_spk');
        $res = $q->result_array(); 
        foreach($res as $k => $v) {
            foreach($v as $k2 => $v2) {
                $data['spk'][$k][$k2] = $v2;
            }
        }

        $q = $this->db->get('mst_tahap');
        $res = $q->result_array(); 
        foreach($res as $k => $v) {
            foreach($v as $k2 => $v2) {
                $data['tahap'][$k][$k2] = $v2;
            }
        }

        $q = $this->db->get('mst_bank');
        $res = $q->result_array(); 
        foreach($res as $k => $v) {
            foreach($v as $k2 => $v2) {
                $data['bank'][$k][$k2] = $v2;
            }
        }

        return $data;
    }

    public function load_tmpjurnal()
    {
        // tahap, sbdy, nasabah, fakturpajak, kdbank -->
        $uid = $this->session->userdata('usernm');
        $sql = 'SELECT tid, uid, kode_divisi, tanggal, no_bukti, no_terbit, kode_coa, f_cekcoa(kode_coa) as coa, '.
                ' kode_nasabah, f_cekmandatory("nasabah",kode_coa) as nasabah, kode_sumberdaya, f_cekmandatory("sbd",kode_coa) as sumberdaya, kode_spk, kode_tahap, f_cekmandatory("tahap",kode_coa) as tahap, '.
                ' no_invoice, kode_faktur, f_cekmandatory("pajak",kode_coa) as pajak, bukti_potong, volume, uraian, dk, rupiah, '.
                " F_GET_BALANCE(no_bukti,uid) as IS_BALANCE, f_ceknobukti(no_bukti) as IS_EXIST ".
                'FROM tr_accounting_upload '.
                "WHERE uid='".$uid."'";//.
                //'ORDER by no_bukti ASC, tanggal ASC ';
               // 'LIMIT '.$limit.','.$start;//(array('uid'=>'chairul')); //$this->session->userdata('kode_entity')));
        return $q = $this->db->query($sql);//$this->db->get();
    }

    public function _insert($data)
    {
        
        //var_dump($data);die;
        //return $this->db->insert_batch('tr_accounting', $data);
        //$kddiv            = $this->input->post('divisi'); 
        $is_mode        = $this->input->post('is_mode');

        $kddiv          = $this->input->post('kd_div');
        $tanggal        = $this->input->post('tanggal');
        $kd_jenis       = $this->input->post('kd_jenis');
        $no_batch       = $this->input->post('no_batch');
        $no_bukti       = $this->input->post('nomor_bukti');
        //$no_bukti       = $this->input->post('no_bukti');
        //$nomor_bukti    = $no_bukti.'/'.$kd_jenis.'/'.substr($tanggal, -4);
        /* ---- DARI GRID --- */
        
        $kdcoa          = $this->input->post('kode_coa');
        $nasabah        = $this->input->post('kode_nasabah');
        $customer       = $this->input->post('kode_customer');
        $sumberdaya     = $this->input->post('kode_sumberdaya');
        $spk            = $this->input->post('kode_spk');
        $tahap          = $this->input->post('kode_tahap');
        $bank           = $this->input->post('kode_bank');
        $no_terbit      = $this->input->post('nomor_terbit');
        $faktur_pajak   = $this->input->post('kode_faktur');
        $invoice        = $this->input->post('nomor_invoice');
        $bukti_potong   = $this->input->post('bukti_potong');
        $debit          = $this->input->post('f_debit');
        $kredit         = $this->input->post('f_kredit');
        $volume         = $this->input->post('f_volume');
        $keterangan     = $this->input->post('f_keterangan');
        $userlogin      = $this->session->userdata('usernm');

        $tgl            = substr($tanggal,-4).'-'.substr($tanggal, 3,2).'-'.substr($tanggal, 0,2);
        $rupiah = array();
        $data = array();
        $dk = '';
        
        $data = array();
        $call_sp = 0;
        //JIKA MODE='EDIT' data dari VIEW, MAKA HAPUS RECORD EXISTING
        if($is_mode=='edit'){
            $sql = "CALL sp_DeleteJurnal_By_NoBuk('".$no_bukti."','".$userlogin."');";
            $query   = $this->db->query($sql);
            
            
            //var_dump($query);die;
            if($query->result_id == true){
                $data['call_sp'] = array('msg'=>'Success','response'=>1,'action'=>'delete','note'=>'nomor bukti '.$no_bukti.' deleted!','res'=>true);
                $call_sp = 1;
            }else{
                $data['call_sp'] = array('msg'=>'Failed','response'=>0,'action'=>'delete','note'=>'nomor bukti '.$no_bukti.' deleted!','res'=>false);
                $call_sp = 0;
            }
        }

        foreach ($kdcoa as $key => $val) {
            $rupiah1 = $debit[$key];
            $rupiah2 = $kredit[$key];
            if($rupiah1 > 0 ){
                $rupiah = $debit[$key];
                $dk = "D";
            }
            if($rupiah2 > 0){
                $rupiah = $kredit[$key];
                $dk = "K";
            }
            
            $post_time = gmdate("Y-m-d H:i:m", time()+60*60*7);
            if($is_mode=='edit'){
                $qke = 1;
                $data = array(
                    'kode_divisi'       =>$kddiv,
                    'no_bukti'          =>$no_bukti,
                    'no_invoice'        =>$invoice[$key]==''?Null:$invoice[$key],
                    'kode_coa'          =>$val,
                    'kode_nasabah'      =>($nasabah[$key]==''?Null:$nasabah[$key]),
                    'kode_customer'     =>($customer[$key]==''?Null:$customer[$key]),
                    'kode_sumberdaya'   =>$sumberdaya[$key]==''?Null:$sumberdaya[$key],
                    'kode_spk'          =>$spk[$key]==''?Null:$spk[$key],
                    'kode_tahap'        =>$tahap[$key]==''?Null:$tahap[$key],
                    'kode_faktur'       =>$faktur_pajak[$key]==''?Null:$faktur_pajak[$key],
                    'volume'            =>$volume[$key],
                    'keterangan'        =>$keterangan[$key],
                    'dk'                =>$dk,
                    'rupiah'            =>$rupiah,
                    'bukti_potong'      =>$bukti_potong[$key]==''?Null:$bukti_potong[$key],
                    'kode_batch'        =>$no_batch,
                    'no_terbit'         =>$no_terbit[$key]==''?Null:$no_terbit[$key],
                    'tr_level'          =>$kddiv=='V'?'PROYEK':'DEPARTEMEN',
                    'posted_by'         =>$userlogin,
                    'posted_date'       =>$post_time
                );
            }else{
                $qke = 2;
                $data = array(
                    'kode_divisi'       =>$kddiv,
                    'tanggal'           =>$tgl,
                    'jenis'             =>$kd_jenis==''?Null:$kd_jenis,
                    'no_bukti'          =>$no_bukti,
                    'no_invoice'        =>$invoice[$key]==''?Null:$invoice[$key],
                    'kode_coa'          =>$val,
                    'kode_nasabah'      =>($nasabah[$key]==''?Null:$nasabah[$key]),
                    'kode_customer'     =>($customer[$key]==''?Null:$customer[$key]),
                    'kode_sumberdaya'   =>$sumberdaya[$key]==''?Null:$sumberdaya[$key],
                    'kode_spk'          =>$spk[$key]==''?Null:$spk[$key],
                    'kode_tahap'        =>$tahap[$key]==''?Null:$tahap[$key],
                    'kode_faktur'       =>$faktur_pajak[$key]==''?Null:$faktur_pajak[$key],
                    'volume'            =>$volume[$key],
                    'keterangan'        =>$keterangan[$key],
                    'dk'                =>$dk,
                    'rupiah'            =>$rupiah,
                    'bukti_potong'      =>$bukti_potong[$key]==''?Null:$bukti_potong[$key],
                    'kode_batch'        =>$no_batch,
                    'no_terbit'         =>$no_terbit[$key]==''?Null:$no_terbit[$key],
                    'tr_level'          =>$kddiv=='V'?'PROYEK':'DEPARTEMEN',
                    'posted_by'         =>$userlogin,
                    'posted_date'       =>$post_time
                );
            }
            //print_r(array('Query ke' =>$qke));
            //die(print_r($data));
            //INSERT DATA
            $this->db->insert('tr_accounting', $data);
        }

       
       

        if ($this->db->affected_rows() > 0) {
            //return true;
            $data = array('msg'=>'Success','response'=>1,'action'=>'insert','note'=>'nomor bukti '.$no_bukti.' inserted!','res'=>true,'call_sp'=>$call_sp);
        } else {
            //return false;
            $data = array('msg'=>'Failed','response'=>0,'action'=>'insert','note'=>'nomor bukti '.$no_bukti.' inserted!','res'=>true,'call_sp'=>$call_sp);
        }  
        // var_dump($data);die;
        return $data;
    }

    function _insert_voucher($data)
    {
        //var_dump($data);die;
        //return $this->db->insert_batch('tr_accounting', $data);
        //$kddiv            = $this->input->post('divisi'); 
        $is_mode        = $this->input->post('is_mode');

        $kddiv          = $this->input->post('kd_div');
        $tanggal        = $this->input->post('tanggal');
        $kd_jenis       = $this->input->post('kd_jenis');
        $no_batch       = $this->input->post('no_batch');
        $no_bukti       = $this->input->post('nomor_bukti');
        //$no_bukti       = $this->input->post('no_bukti');
        //$nomor_bukti    = $no_bukti.'/'.$kd_jenis.'/'.substr($tanggal, -4);
        /* ---- DARI GRID --- */
        
        $kdcoa          = $this->input->post('kode_coa');
        $nasabah        = $this->input->post('kode_nasabah');
        $customer       = $this->input->post('kode_customer');
        $sumberdaya     = $this->input->post('kode_sumberdaya');
        $spk            = $this->input->post('kode_spk');
        $kd_spk         = $this->input->post('kd_spk');
        $tahap          = $this->input->post('kode_tahap');
        $bank           = $this->input->post('kode_bank');
        $no_terbit      = $this->input->post('nomor_terbit');
        $faktur_pajak   = $this->input->post('kode_faktur');
        $invoice        = $this->input->post('nomor_invoice');
        $bukti_potong   = $this->input->post('bukti_potong');
        $debit          = $this->input->post('f_debit');
        $kredit         = $this->input->post('f_kredit');
        $volume         = $this->input->post('f_volume');
        $keterangan     = $this->input->post('f_keterangan');
        $userlogin      = $this->session->userdata('usernm');

        $tgl            = substr($tanggal,-4).'-'.substr($tanggal, 3,2).'-'.substr($tanggal, 0,2);
        $rupiah = array();
        $data = array();
        $dk = '';
        
        $data = array();
        $call_sp = 0;
        //JIKA MODE='EDIT' data dari VIEW, MAKA HAPUS RECORD EXISTING
        if($is_mode=='edit'){
            //$sql = "CALL sp_DeleteJurnal_By_NoBuk('".$no_bukti."','".$userlogin."');";
            //$query   = $this->db->query($sql);
            
            
            //var_dump($query);die;
            if($query->result_id == true){
                $data['call_sp'] = array('msg'=>'Success','response'=>1,'action'=>'delete','note'=>'nomor bukti '.$no_bukti.' deleted!','res'=>true);
                $call_sp = 1;
            }else{
                $data['call_sp'] = array('msg'=>'Failed','response'=>0,'action'=>'delete','note'=>'nomor bukti '.$no_bukti.' deleted!','res'=>false);
                $call_sp = 0;
            }
        }
        $post_time = gmdate("Y-m-d H:i:m", time()+60*60*7);

        $kd_div = $this->session->userdata('kode_dept');
        $sql_vcr = "SELECT MAX(voucher_no) as no_vcr FROM tr_voucher WHERE kd_div ='".$kd_div."' AND kd_entity='".$kd_spk."'";
        //die('<pre>'.$sql_vcr.'</pre>');
        $qvcr = $this->db->query($sql_vcr);
        $res_vcr = $qvcr->row_array();
        $no_voucher = (int)($res_vcr['no_vcr'])+1;

        $trvcr = array(
                'voucher_no'            =>$no_voucher,
                'voucher_print_date'    =>$post_time,
                'print_by'              =>$userlogin,
                'tr_acc_id'             =>null,
                'tr_vcr_id'             =>null,
                'tr_jenis'              =>$kd_jenis,
                'kd_div'                =>$kd_div,
                'no_bukti'              =>$no_bukti,
                'kd_entity'             =>$kd_spk
            );
        
        $this->db->insert('tr_voucher', $trvcr);
        //var_dump($trvcr);die;
        //$kd_div = $this->session->userdata('kode_dept');
        //$sql_vcr = "SELECT MAX(voucher_no) as no_vcr FROM tr_voucher WHERE kd_div ='".$kd_div."' AND kd_entity='".$kd_spk."'";
        //$qvcr = $this->db->query($sql_vcr);
        //$res_vcr = $qvcr->row_array();
        //$vcr_no = $res_vcr['no_vcr']+1;
        
        foreach ($kdcoa as $key => $val) {
            $rupiah1 = $debit[$key];
            $rupiah2 = $kredit[$key];
            if($rupiah1 > 0 ){
                $rupiah = $debit[$key];
                $dk = "D";
            }
            if($rupiah2 > 0){
                $rupiah = $kredit[$key];
                $dk = "K";
            }
            

            $data = array(
                    'kode_divisi'       =>$kddiv,
                    'tanggal'           =>$tgl,
                    'jenis'             =>$kd_jenis==''?Null:$kd_jenis,
                    'no_bukti'          =>$no_bukti,
                    'no_invoice'        =>$invoice[$key]==''?Null:$invoice[$key],
                    'kode_coa'          =>$val,
                    'kode_nasabah'      =>($nasabah[$key]==''?Null:$nasabah[$key]),
                    'kode_customer'     =>($customer[$key]==''?Null:$customer[$key]),
                    'kode_sumberdaya'   =>$sumberdaya[$key]==''?Null:$sumberdaya[$key],
                    'kode_spk'          =>$spk[$key]==''?Null:$spk[$key],
                    'kode_tahap'        =>$tahap[$key]==''?Null:$tahap[$key],
                    'kode_faktur'       =>$faktur_pajak[$key]==''?Null:$faktur_pajak[$key],
                    'volume'            =>$volume[$key],
                    'keterangan'        =>$keterangan[$key],
                    'dk'                =>$dk,
                    'rupiah'            =>$rupiah,
                    'bukti_potong'      =>$bukti_potong[$key]==''?Null:$bukti_potong[$key],
                    'kode_batch'        =>$no_batch,
                    'no_terbit'         =>$no_terbit[$key]==''?Null:$no_terbit[$key],
                    'tr_level'          =>$kddiv=='V'?'PROYEK':'DEPT',
                    'posted_by'         =>$userlogin,
                    'posted_date'       =>$post_time,
                    'voucher_no'        =>$no_voucher,
                );

            //INSERT ACCOUNTING_VOUCHER
            $this->db->insert('tr_accounting_voucher', $data);

            $dt[] = $data;
        }

       
        if ($this->db->affected_rows() > 0) {
            //return true;
            $data = array('msg'=>'Success','response'=>1,'action'=>'print_vcr','no_voucher'=>$no_voucher,'head'=>$trvcr, 'data'=>$dt,'jenis'=>$kd_jenis);
        } else {
            //return false;
            $data = array('msg'=>'Failed','response'=>0,'action'=>'print_vcr','no_voucher'=>$no_voucher,'head'=>$trvcr, 'data'=>$dt,'jenis'=>$kd_jenis);
        }  
        // var_dump($data);die;
        return $data;
    }

    public function cetakVoucher($nomor){
        $data = array();
        $sql = "SELECT * FROM tr_voucher WHERE voucher_no=$nomor";
        $q = $this->db->query($sql);
        $data = $q->row_array();

        $sql = "SELECT keterangan,kode_spk,kode_nasabah,volume,rupiah,dk 
                FROM tr_accounting_voucher WHERE voucher_no=$nomor";
        $query = $this->db->query($sql);
        $data['content'] = $query->result_array();

        return $data;
    }

    public function _delete($no_bukti) {
        $this->db->where(array('no_bukti'=>$no_bukti));
        return $this->db->delete('tr_accounting');
    }

    public function gen_rpt_neraca_t($periode,$divisi,$spk='') 
    {
        list($bln, $thn) = explode('-', $periode);
        $tgl_s = $thn.'-01-01';
        $tgl_e = date("Y-m-t", strtotime($thn.'-'.$bln.'-01'));
        // get coa, varname & rp

        $kode_spk = $this->session->userdata('kode_entity');

        $sql = "
            SELECT
                tbl.coa,
                tbl.varname,
                SUM(tbl.rpmin1th) AS rpmin1th,
                SUM(tbl.rpmin1bln) AS rpmin1bln
            FROM
                (
                    SELECT
                        tmpl_coa.coa,
                        tmpl_coa.varname,
                        IFNULL(SUM(rpmin1th.rp), 0) AS rpmin1th,
                        0 AS rpmin1bln
                    FROM
                        template_coa_list tmpl_coa
                    LEFT JOIN (
                        SELECT
                            kode_coa,
                            SUM(
                                CASE
                                WHEN dk = 'D' THEN
                                    rupiah
                                ELSE
                                    (rupiah *- 1)
                                END
                            ) AS rp
                        FROM
                            tr_accounting
                        WHERE
                            tanggal < '$tgl_s' ";
                             //$sql .= $divisi==''?'':"AND kode_divisi = '".$divisi."'";
                        /*AND kode_divisi = 'P'
                        AND kode_spk = '2WGA13'*/
                            $sql .= " AND kode_spk='$kode_spk'";
                    $sql.="
                        GROUP BY
                            kode_coa
                    ) rpmin1th ON rpmin1th.kode_coa LIKE CONCAT(tmpl_coa.coa, '%')
                    WHERE
                        tmpl_coa.jenis_rpt = 'NRCT'
                    AND tmpl_coa.coa <> ''
                    AND tmpl_coa.is_range_current = 0
                    GROUP BY
                        tmpl_coa.coa
                    UNION ALL
                        SELECT
                            tmpl_coa.coa,
                            tmpl_coa.varname,
                            0 AS rpmin1th,
                            IFNULL(SUM(rpmin1bln.rp), 0) AS rpmin1bln
                        FROM
                            template_coa_list tmpl_coa
                        LEFT JOIN (
                            SELECT
                                kode_coa,
                                SUM(
                                    CASE
                                    WHEN dk = 'D' THEN
                                        rupiah
                                    ELSE
                                        (rupiah *- 1)
                                    END
                                ) AS rp
                            FROM
                                tr_accounting
                            WHERE
                                tanggal <= '$tgl_e'";
                             //$sql .= $divisi==''?'':"AND kode_divisi = '".$divisi."'";
                        /*AND kode_divisi = 'P'
                        AND kode_spk = '2WGA13'*/
                        $sql .= " AND kode_spk='$kode_spk'";
                    $sql.="
                            GROUP BY
                                kode_coa
                        ) rpmin1bln ON rpmin1bln.kode_coa LIKE CONCAT(tmpl_coa.coa, '%')
                        WHERE
                            tmpl_coa.jenis_rpt = 'NRCT'
                        AND tmpl_coa.coa <> ''
                        AND tmpl_coa.is_range_current = 0
                        GROUP BY
                            tmpl_coa.coa
                ) AS tbl
            GROUP BY
                tbl.coa
            UNION ALL
                SELECT
                    tbl.coa,
                    tbl.varname,
                    SUM(tbl.rpmin1th) AS rpmin1th,
                    SUM(tbl.rpmin1bln) AS rpmin1bln
                FROM
                    (
                        SELECT
                            tmpl_coa.coa,
                            tmpl_coa.varname,
                            IFNULL(SUM(rpmin1th.rp), 0) AS rpmin1th,
                            0 AS rpmin1bln
                        FROM
                            template_coa_list tmpl_coa
                        LEFT JOIN (
                            SELECT
                                kode_coa,
                                SUM(
                                    CASE
                                    WHEN dk = 'D' THEN
                                        rupiah
                                    ELSE
                                        (rupiah *- 1)
                                    END
                                ) AS rp
                            FROM
                                tr_accounting
                            WHERE
                                tanggal >= DATE_ADD(
                                    '$tgl_s',
                                    INTERVAL - 1 YEAR
                                )
                            AND tanggal < '$tgl_s'";
                            // $sql .= $divisi==''?'':"AND kode_divisi = '".$divisi."'";
                        /*AND kode_divisi = 'P'
                        AND kode_spk = '2WGA13'*/
                            $sql .= " AND kode_spk='$kode_spk'";
                    $sql.="
                            GROUP BY
                                kode_coa
                        ) rpmin1th ON rpmin1th.kode_coa LIKE CONCAT(tmpl_coa.coa, '%')
                        WHERE
                            tmpl_coa.jenis_rpt = 'NRCT'
                        AND tmpl_coa.coa <> ''
                        AND tmpl_coa.is_range_current = 1
                        GROUP BY
                            tmpl_coa.coa
                        UNION ALL
                            SELECT
                                tmpl_coa.coa,
                                tmpl_coa.varname,
                                0 AS rpmin1th,
                                IFNULL(SUM(rpmin1bln.rp), 0) AS rpmin1bln
                            FROM
                                template_coa_list tmpl_coa
                            LEFT JOIN (
                                SELECT
                                    kode_coa,
                                    SUM(
                                        CASE
                                        WHEN dk = 'D' THEN
                                            rupiah
                                        ELSE
                                            (rupiah *- 1)
                                        END
                                    ) AS rp
                                FROM
                                    tr_accounting
                                WHERE
                                    tanggal >= '$tgl_s'
                                AND tanggal <= '$tgl_e'";
                            //$sql .= " AND kode_divisi = '".$divisi."'";
                           // $sql .= $spk==''?'':" AND kode_spk ='".$spk."'";
                            $sql .= " AND kode_spk='$kode_spk'";
                        /*AND kode_divisi = 'P'
                        AND kode_spk = '2WGA13'*/
                    $sql.="
                                GROUP BY
                                    kode_coa
                            ) rpmin1bln ON rpmin1bln.kode_coa LIKE CONCAT(tmpl_coa.coa, '%')
                            WHERE
                                tmpl_coa.jenis_rpt = 'NRCT'
                            AND tmpl_coa.coa <> ''
                            AND tmpl_coa.is_range_current = 1
                            GROUP BY
                                tmpl_coa.coa
                    ) AS tbl
                GROUP BY
                    tbl.coa
                UNION ALL
                    SELECT
                        tbl.coa,
                        tbl.varname,
                        SUM(tbl.rpmin1th) AS rpmin1th,
                        SUM(tbl.rpmin1bln) AS rpmin1bln
                    FROM
                        (
                            SELECT
                                tmpl_coa.coa,
                                tmpl_coa.varname,
                                IFNULL(SUM(rpmin1th.rp), 0) AS rpmin1th,
                                0 AS rpmin1bln
                            FROM
                                template_coa_list tmpl_coa
                            LEFT JOIN (
                                SELECT
                                    kode_coa,
                                    SUM(
                                        CASE
                                        WHEN dk = 'D' THEN
                                            rupiah
                                        ELSE
                                            (rupiah *- 1)
                                        END
                                    ) AS rp
                                FROM
                                    tr_accounting
                                WHERE
                                    tanggal < DATE_ADD(
                                        '$tgl_s',
                                        INTERVAL - 1 YEAR
                                    )";
                           // $sql .= " AND kode_divisi = '".$divisi."'";
                            $sql .= " AND kode_spk='$kode_spk'";
                        /*AND kode_divisi = 'P'
                        AND kode_spk = '2WGA13'*/
                    $sql.="
                                GROUP BY
                                    kode_coa
                            ) rpmin1th ON rpmin1th.kode_coa LIKE CONCAT(tmpl_coa.coa, '%')
                            WHERE
                                tmpl_coa.jenis_rpt = 'NRCT'
                            AND tmpl_coa.coa <> ''
                            AND tmpl_coa.is_range_current = 2
                            GROUP BY
                                tmpl_coa.coa
                            UNION ALL
                                SELECT
                                    tmpl_coa.coa,
                                    tmpl_coa.varname,
                                    0 AS rpmin1th,
                                    IFNULL(SUM(rpmin1bln.rp), 0) AS rpmin1bln
                                FROM
                                    template_coa_list tmpl_coa
                                LEFT JOIN (
                                    SELECT
                                        kode_coa,
                                        SUM(
                                            CASE
                                            WHEN dk = 'D' THEN
                                                rupiah
                                            ELSE
                                                (rupiah *- 1)
                                            END
                                        ) AS rp
                                    FROM
                                        tr_accounting
                                    WHERE
                                        tanggal < '$tgl_s'";
                           // $sql .= " AND kode_divisi = '".$divisi."'";
                            $sql .= " AND kode_spk='$kode_spk'";
                        /*AND kode_divisi = 'P'
                        AND kode_spk = '2WGA13'*/
                    $sql.="
                                    GROUP BY
                                        kode_coa
                                ) rpmin1bln ON rpmin1bln.kode_coa LIKE CONCAT(tmpl_coa.coa, '%')
                                WHERE
                                    tmpl_coa.jenis_rpt = 'NRCT'
                                AND tmpl_coa.coa <> ''
                                AND tmpl_coa.is_range_current = 2
                                GROUP BY
                                    tmpl_coa.coa
                        ) AS tbl
                    GROUP BY
                        tbl.coa
        ";
        //print_r($sql);
        $qVar = $this->db->query($sql);
        $resVar = $qVar->result_array();
        // math lib
        $this->load->library('MathParser');
        $math_now = new MathParser();
        $math_past = new MathParser();
        // register var & val
        foreach ($resVar as $k => $v) {
            $math_now->setVars(
                array(
                    $v['varname']=>$v['rpmin1bln']
                ),
                FALSE
            );
            $math_past->setVars(
                array(
                    $v['varname']=>$v['rpmin1th']
                ),
                FALSE
            );
        }
        // get rpt template
        $kode_spk = $this->session->userdata('kode_entity');
        $sql = "
            SELECT 
                tmpl_l.description AS l_desc, 
                tmpl_l._line AS l_line, 
                tmpl_l.is_bold AS l_bold, 
                tmpl_l.varname AS l_var, 
                IFNULL(tmpl_l._formula,'') AS l_formula, 
                tmpl_r.description AS r_desc, 
                tmpl_r._line AS r_line, 
                tmpl_r.is_bold AS r_bold, 
                tmpl_r.varname AS r_var, 
                IFNULL(tmpl_r._formula,'') AS r_formula 
            FROM 
                ( 
                    SELECT 
                        * 
                    FROM 
                        template_report 
                    WHERE 
                        _position = 'L' 
                ) tmpl_l 
                LEFT JOIN  
                ( 
                    SELECT 
                        * 
                    FROM 
                        template_report 
                    WHERE 
                        _position = 'R' 
                ) tmpl_r ON tmpl_r.jenis_rpt = tmpl_l.jenis_rpt 
                 AND tmpl_r.no_urut = tmpl_l.no_urut 
            WHERE 
                tmpl_l.jenis_rpt = 'NRCT' 
            ORDER BY 
                tmpl_l.no_urut
        ";
        //print_r('<p>'.$sql.'</p>');die;
        $qTmpl = $this->db->query($sql);
        $resTmpl = $qTmpl->result_array();
        $data = array();
        foreach ($resTmpl as $k => $v) {
            $l_rp1 = strpos($v['l_formula'], 'nt')!==FALSE ? $math_now->execute($v['l_formula']) : 0;
            $l_rp1 = strpos($v['l_formula'], 'L')!==FALSE ? $math_now->execute($v['l_formula']) : $l_rp1;
            $l_rp2 = strpos($v['l_formula'], 'nt')!==FALSE ? $math_past->execute($v['l_formula']) : 0;
            $l_rp2 = strpos($v['l_formula'], 'L')!==FALSE ? $math_past->execute($v['l_formula']) : $l_rp2;
            $l_nonsum = $v['l_formula']!=='' ? '0' : '1';
            $r_rp1 = strpos($v['r_formula'], 'nt')!==FALSE ? $math_now->execute($v['r_formula']) : 0;
            $r_rp1 = strpos($v['r_formula'], 'R')!==FALSE ? $math_now->execute($v['r_formula']) : $r_rp1;
            $r_rp2 = strpos($v['r_formula'], 'nt')!==FALSE ? $math_past->execute($v['r_formula']) : 0;
            $r_rp2 = strpos($v['r_formula'], 'R')!==FALSE ? $math_past->execute($v['r_formula']) : $r_rp2;
            $r_nonsum = $v['r_formula']!=='' ? '0' : '1';
            $data[] = array(
                'l_desc'=>$v['l_desc'],
                'l_line'=>$v['l_line'],
                'l_bold'=>$v['l_bold'],
                'l_rpmin1bln'=>number_format($l_rp1,2),
                'l_rpmin1thn'=>number_format($l_rp2,2),
                'l_nonsum'=>$l_nonsum,
                'r_desc'=>$v['r_desc'],
                'r_line'=>$v['r_line'],
                'r_bold'=>$v['r_bold'],
                'r_rpmin1bln'=>number_format($r_rp1,2),
                'r_rpmin1thn'=>number_format($r_rp2,2),
                'r_nonsum'=>$r_nonsum
            );
            if($v['l_var']!=='') {
                $math_now->setVars(
                    array(
                        $v['l_var']=>$l_rp1
                    ),
                    FALSE
                );
                $math_past->setVars(
                    array(
                        $v['l_var']=>$l_rp2
                    ),
                    FALSE
                );
            }
            if($v['r_var']!=='') {
                $math_now->setVars(
                    array(
                        $v['r_var']=>$r_rp1
                    ),
                    FALSE
                );
                $math_past->setVars(
                    array(
                        $v['r_var']=>$r_rp2
                    ),
                    FALSE
                );
            }
        }

        return $data;  
    }

    public function gen_rpt_neraca_lajur_olddd($periode,$divisi=FALSE) 
    {
        list($bln, $thn) = explode('-', $periode);
        $tgl_s = $thn.'-'.$bln.'-01';
        $tgl_e = date("Y-m-t", strtotime($tgl_s));
        // build sql
        $sql = "
            SELECT
                tbl.kode,
                tbl.nama,
                SUM(tbl.sa_d) AS sa_d,
                SUM(tbl.sa_k) AS sa_k,
                SUM(tbl.now_d) AS now_d,
                SUM(tbl.now_k) AS now_k
            FROM
                (
                    SELECT
                        coa.kode,
                        coa.nama,
                        CASE
                    WHEN IFNULL(SUM(sa.rp_dk), 0) > 0 THEN
                        IFNULL(SUM(sa.rp_dk), 0)
                    ELSE
                        0
                    END sa_d,
                    CASE
                WHEN IFNULL(SUM(sa.rp_dk), 0) < 0 THEN
                    IFNULL(SUM(sa.rp_dk) *- 1, 0)
                ELSE
                    0
                END sa_k,
                0 now_d,
                0 now_k
            FROM
                (
                    SELECT
                        kode_coa,
                        SUM(
                            CASE
                            WHEN dk = 'D' THEN
                                rupiah
                            ELSE
                                (rupiah *- 1)
                            END
                        ) AS rp_dk
                    FROM
                        tr_accounting
                    WHERE
                        tanggal < '$tgl_s'";
                            //$sql .= ($divisi!=false?"AND kode_divisi = '".$divisi."'":"");
                            $sql .= " AND kode_spk = '$kode_spk'";
                        /*AND kode_divisi = 'P'
                        AND kode_spk = '2WGA13'*/
                    $sql.="
                    GROUP BY
                        kode_coa
                ) sa
            LEFT JOIN mst_coa coa ON sa.kode_coa LIKE CONCAT(coa.kode, '%')
            GROUP BY
                coa.kode
            HAVING
                IFNULL(SUM(sa.rp_dk), 0) <> 0
            UNION ALL
                SELECT
                    coa.kode,
                    coa.nama,
                    0 sa_d,
                    0 sa_k,
                    IFNULL(SUM(now.rp_d), 0) now_d,
                    IFNULL(SUM(now.rp_k), 0) now_k
                FROM
                    (
                        SELECT
                            kode_coa,
                            SUM(
                                CASE
                                WHEN dk = 'D' THEN
                                    rupiah
                                ELSE
                                    0
                                END
                            ) AS rp_d,
                            SUM(
                                CASE
                                WHEN dk = 'K' THEN
                                    rupiah
                                ELSE
                                    0
                                END
                            ) AS rp_k
                        FROM
                            tr_accounting
                        WHERE
                            tanggal >= '$tgl_s'
                        AND tanggal <= '$tgl_e'";
                            //$sql .= ($divisi!=false?"AND kode_divisi = '".$divisi."'":"");
                            $sql .= " AND kode_spk = '$kode_spk'";
                        /*AND kode_divisi = 'P'
                        AND kode_spk = '2WGA13'*/
                    $sql.="
                        GROUP BY
                            kode_coa
                    ) AS now
                LEFT JOIN mst_coa coa ON now.kode_coa LIKE CONCAT(coa.kode, '%')
                GROUP BY
                    coa.kode
                ) AS tbl
            GROUP BY
                tbl.kode
        ";
        //echo $sql;
        //die;
        $q = $this->db->query($sql);
        return $q->result_array();
    }

    public function gen_rpt_neraca_lajur($periode,$divisi=FALSE) 
    {
        $kd_spk = $this->session->userdata('kode_entity');
        list($bln, $thn) = explode('-', $periode);
        $tgl_s = $thn.'-'.$bln.'-01';
        $tgl_e = date("Y-m-t", strtotime($tgl_s));
        // build sql
        $sql = "
            SELECT
                tbl.kode,
                tbl.nama,
                SUM(tbl.sa_d) AS sa_d,
                SUM(tbl.sa_k) AS sa_k,
                SUM(tbl.now_d) AS now_d,
                SUM(tbl.now_k) AS now_k
            FROM
                (
                    SELECT
                        coa.kode,
                        coa.nama,
                        CASE
                    WHEN IFNULL(SUM(sa.rp_dk), 0) > 0 THEN
                        IFNULL(SUM(sa.rp_dk), 0)
                    ELSE
                        0
                    END sa_d,
                    CASE
                WHEN IFNULL(SUM(sa.rp_dk), 0) < 0 THEN
                    IFNULL(SUM(sa.rp_dk) *- 1, 0)
                ELSE
                    0
                END sa_k,
                0 now_d,
                0 now_k
            FROM
                (
                    SELECT
                        kode_coa,
                        SUM(
                            CASE
                            WHEN dk = 'D' THEN
                                rupiah
                            ELSE
                                (rupiah *- 1)
                            END
                        ) AS rp_dk
                    FROM
                        tr_accounting
                    WHERE
                        tanggal < '$tgl_s'";
                            $sql .= ($divisi!=false?"AND kode_divisi = '".$divisi."'":"");
                        /*AND kode_divisi = 'P'
                        AND kode_spk = '2WGA13'*/
                    $sql.="
                    AND kode_spk = '$kd_spk'
                    GROUP BY
                        kode_coa
                ) sa
            LEFT JOIN mst_coa coa ON sa.kode_coa LIKE CONCAT(coa.kode, '%')
            GROUP BY
                coa.kode
            HAVING
                IFNULL(SUM(sa.rp_dk), 0) <> 0
            UNION ALL
                SELECT
                    coa.kode,
                    coa.nama,
                    0 sa_d,
                    0 sa_k,
                    IFNULL(SUM(now.rp_d), 0) now_d,
                    IFNULL(SUM(now.rp_k), 0) now_k
                FROM
                    (
                        SELECT
                            kode_coa,
                            SUM(
                                CASE
                                WHEN dk = 'D' THEN
                                    rupiah
                                ELSE
                                    0
                                END
                            ) AS rp_d,
                            SUM(
                                CASE
                                WHEN dk = 'K' THEN
                                    rupiah
                                ELSE
                                    0
                                END
                            ) AS rp_k
                        FROM
                            tr_accounting
                        WHERE
                            tanggal >= '$tgl_s'
                        AND tanggal <= '$tgl_e'";
                            $sql .= ($divisi!=false?"AND kode_divisi = '".$divisi."'":"");
                        /*AND kode_divisi = 'P'*/
                        
                    $sql.="
                        AND kode_spk = '$kd_spk'
                        GROUP BY
                            kode_coa
                    ) AS now
                LEFT JOIN mst_coa coa ON now.kode_coa LIKE CONCAT(coa.kode, '%')
                GROUP BY
                    coa.kode
                ) AS tbl
            GROUP BY
                tbl.kode
        ";
        //echo $sql;
        //die;
        $q = $this->db->query($sql);
        return $q->result_array();
    }

    public function gen_rpt_labarugi($periode,$divisi=FALSE) 
    {
        list($bln, $thn) = explode('-', $periode);
        $tgl_now_s = $thn.'-'.$bln.'-01';
        $tgl_now_e = date("Y-m-t", strtotime($tgl_now_s));
        $tgl_year_s = $thn.'-01-01'; 

        $kode_spk = $this->session->userdata('kode_entity');
        // build sql
        $sql = "
            SELECT
                tmpl_coa.coa,
                tmpl_coa.varname,
                IFNULL(rpmin1bln_d.rp, 0) AS rpmin1bln_d,
                IFNULL(rp_now_d.rp, 0) AS rp_now_d,
                IFNULL(rpmin1thn_p.rp, 0)AS rpmin1thn_p,
                IFNULL(rpmin1bln_p.rp, 0) AS rpmin1bln_p,
                IFNULL(rp_now_p.rp, 0) AS rp_now_p
            FROM
                template_coa_list tmpl_coa
            LEFT JOIN (
                SELECT
                    tmpl_coa.coa,
                    SUM(
                        CASE
                        WHEN dk = 'D' THEN
                            acc.rupiah
                        ELSE
                            (acc.rupiah *- 1)
                        END
                    ) AS rp
                FROM
                    template_coa_list tmpl_coa
                LEFT JOIN tr_accounting acc ON acc.kode_coa LIKE CONCAT(tmpl_coa.coa, '%')
                WHERE
                    acc.tanggal >= '$tgl_year_s'
                AND acc.tanggal < '$tgl_now_s'
                AND acc.tr_level = 'DEPARTEMEN'";
                           // $sql .= ($divisi!=false?"AND kode_divisi = '".$divisi."'":"");
                            $sql .= " AND kode_spk='$kode_spk'";
                        /*AND kode_divisi = 'P'
                        AND kode_spk = '2WGA13'*/
                    $sql.="
                GROUP BY
                    tmpl_coa.coa
            ) rpmin1bln_d ON rpmin1bln_d.coa = tmpl_coa.coa
            LEFT JOIN (
                SELECT
                    tmpl_coa.coa,
                    SUM(
                        CASE
                        WHEN dk = 'D' THEN
                            acc.rupiah
                        ELSE
                            (acc.rupiah *- 1)
                        END
                    ) AS rp
                FROM
                    template_coa_list tmpl_coa
                LEFT JOIN tr_accounting acc ON acc.kode_coa LIKE CONCAT(tmpl_coa.coa, '%')
                WHERE
                    acc.tanggal >= '$tgl_now_s'
                AND acc.tanggal <= '$tgl_now_e'
                AND acc.tr_level = 'DEPARTEMEN'";
                //$sql .= ($divisi!=false?"AND acc.kode_divisi = '".$divisi."'":"");
                $sql .= " AND kode_spk='$kode_spk'";
            /*AND kode_divisi = 'P'
            AND kode_spk = '2WGA13'*/
        $sql.="
                GROUP BY
                    tmpl_coa.coa
            ) rp_now_d ON rp_now_d.coa = tmpl_coa.coa
            LEFT JOIN(
                SELECT
                    tmpl_coa.coa,
                    SUM(
                        CASE
                        WHEN dk = 'D' THEN
                            acc.rupiah
                        ELSE
                            (acc.rupiah *- 1)
                        END
                    )AS rp
                FROM
                    template_coa_list tmpl_coa
                LEFT JOIN tr_accounting acc ON acc.kode_coa LIKE CONCAT(tmpl_coa.coa, '%')
                WHERE
                    acc.tanggal < '$tgl_year_s'
                AND acc.tr_level = 'PROYEK' ";
                $sql .= " AND kode_spk='$kode_spk'";
                $sql .= "
                GROUP BY
                    tmpl_coa.coa
            )rpmin1thn_p ON rpmin1thn_p.coa = tmpl_coa.coa
            LEFT JOIN (
                SELECT
                    tmpl_coa.coa,
                    SUM(
                        CASE
                        WHEN dk = 'D' THEN
                            acc.rupiah
                        ELSE
                            (acc.rupiah *- 1)
                        END
                    ) AS rp
                FROM
                    template_coa_list tmpl_coa
                LEFT JOIN tr_accounting acc ON acc.kode_coa LIKE CONCAT(tmpl_coa.coa, '%')
                WHERE
                    acc.tanggal >= '$tgl_year_s'
                AND acc.tanggal < '$tgl_now_s'
                AND acc.tr_level = 'PROYEK'";
                //$sql .= ($divisi!=false?"AND acc.kode_divisi = '".$divisi."'":"");
                $sql .= " AND kode_spk='$kode_spk'";
                    /*AND kode_divisi = 'P'
                    AND kode_spk = '2WGA13'*/
                $sql.="
                GROUP BY
                    tmpl_coa.coa
            ) rpmin1bln_p ON rpmin1bln_p.coa = tmpl_coa.coa
            LEFT JOIN (
                SELECT
                    tmpl_coa.coa,
                    SUM(
                        CASE
                        WHEN dk = 'D' THEN
                            acc.rupiah
                        ELSE
                            (acc.rupiah *- 1)
                        END
                    ) AS rp
                FROM
                    template_coa_list tmpl_coa
                LEFT JOIN tr_accounting acc ON acc.kode_coa LIKE CONCAT(tmpl_coa.coa, '%')
                WHERE
                    acc.tanggal >= '$tgl_now_s'
                AND acc.tanggal <= '$tgl_now_e'
                AND acc.tr_level = 'PROYEK'";
                //$sql .= ($divisi!=false?"AND acc.kode_divisi = '".$divisi."'":"");
                $sql .= " AND kode_spk='$kode_spk'";
                        /*AND kode_divisi = 'P'
                        AND kode_spk = '2WGA13'*/
            $sql.="
                GROUP BY
                    tmpl_coa.coa
            ) rp_now_p ON rp_now_p.coa = tmpl_coa.coa
            WHERE
                tmpl_coa.coa <> ''
            AND tmpl_coa.jenis_rpt = 'LBRG'
            GROUP BY
                tmpl_coa.coa
        ";
        //print_r('<pre>'.$sql.'</pre>');die;
        $qVar = $this->db->query($sql);
        $resVar = $qVar->result_array();
        // math lib
        $this->load->library('MathParser');
        $math_now_d = new MathParser();
        $math_now_p = new MathParser();
        $math_past_d = new MathParser();
        $math_past_p = new MathParser();
        $math_y_past_p = new MathParser();
        
        // register var & val
        foreach ($resVar as $k => $v) {
            $math_past_d->setVars(
                array(
                    $v['varname']=>$v['rpmin1bln_d']
                ),
                FALSE
            );
            $math_now_d->setVars(
                array(
                    $v['varname']=>$v['rp_now_d']
                ),
                FALSE
            );
            $math_y_past_p->setVars(
                array(
                    $v['varname']=>$v['rpmin1thn_p']
                ),
                FALSE
            );
            $math_past_p->setVars(
                array(
                    $v['varname']=>$v['rpmin1bln_p']
                ),
                FALSE
            );
            $math_now_p->setVars(
                array(
                    $v['varname']=>$v['rp_now_p']
                ),
                FALSE
            );
        }
        // get rpt template
        $qTmpl = $this->db->query("
            SELECT 
                _line,
                is_bold,
                description,
                IFNULL(varname,'') AS varname, 
                IFNULL(_formula, '') AS _formula
            FROM 
                template_report 
            WHERE 
                jenis_rpt = 'LBRG' 
            ORDER BY 
                no_urut");
        $resTmpl = $qTmpl->result_array();
        $data = array();
        foreach ($resTmpl as $k => $v) {
            $rp_past_d = strpos($v['_formula'], 'lb')!==FALSE ? $math_past_d->execute($v['_formula']) : 0;
            $rp_past_d = strpos($v['_formula'], 'L')!==FALSE ? $math_past_d->execute($v['_formula']) : $rp_past_d;
            $rp_now_d = strpos($v['_formula'], 'lb')!==FALSE ? $math_now_d->execute($v['_formula']) : 0;
            $rp_now_d = strpos($v['_formula'], 'L')!==FALSE ? $math_now_d->execute($v['_formula']) : $rp_now_d;
            $rp_past_p = strpos($v['_formula'], 'lb')!==FALSE ? $math_past_p->execute($v['_formula']) : 0;
            $rp_past_p = strpos($v['_formula'], 'L')!==FALSE ? $math_past_p->execute($v['_formula']) : $rp_past_p;
            
            $rp_y_past_p = strpos($v['_formula'], 'lb')!==FALSE ? $math_y_past_p->execute($v['_formula']) : 0;
            $rp_y_past_p = strpos($v['_formula'], 'L')!==FALSE ? $math_y_past_p->execute($v['_formula']) : $rp_y_past_p;

            $rp_now_p = strpos($v['_formula'], 'lb')!==FALSE ? $math_now_p->execute($v['_formula']) : 0;
            $rp_now_p = strpos($v['_formula'], 'L')!==FALSE ? $math_now_p->execute($v['_formula']) : $rp_now_p;
            $data[] = array(
                'description'=>$v['description'],
                'line'=>$v['_line'],
                'isbold'=>$v['is_bold'],
                'rp_past_d'=>$rp_past_d,
                'rp_now_d'=>$rp_now_d,
                'rp_y_past_p'=>$rp_y_past_p,
                'rp_past_p'=>$rp_past_p,
                'rp_now_p'=>$rp_now_p,
                'is_nonsum'=>$v['_formula']==='' ? '1' : '0'
            );
            if($v['varname']!=='') {
                $math_past_d->setVars(
                    array(
                        $v['varname']=>$rp_past_d
                    ),
                    FALSE
                );
                $math_now_d->setVars(
                    array(
                        $v['varname']=>$rp_now_d
                    ),
                    FALSE
                );
                $math_y_past_p->setVars(
                    array(
                        $v['varname']=>$rp_y_past_p
                    ),
                    FALSE
                );
                $math_past_p->setVars(
                    array(
                        $v['varname']=>$rp_past_p
                    ),
                    FALSE
                );
                $math_now_p->setVars(
                    array(
                        $v['varname']=>$rp_now_p
                    ),
                    FALSE
                );
            }
        }


        return $data;
    }

    function gen_rpt_bukubesar_ext($periode,$kd_div,$kdcoa=false) {
       //echo $kd_div;
        if($kdcoa!=false){
            $saldoawal = $this->get_saldoAwal_childbukubesar($kdcoa,$periode);
        }else{            
            $saldoawal = 0;
        }
        
        $kode_spk = $this->session->userdata('kode_entity');

        list($bln, $thn) = explode('-', $periode);
        $perio_de =  $thn.'-'.sprintf('%02d',$bln);
        $periode_lalu = $thn.'-'.sprintf('%02d',($bln - 1));

        //$this->db->query('SET @s = '.$saldoawal['saldo']);
        //$this->db->query('SET @d = 0');
        //$this->db->query('SET @k = 0');
        $sqlx = 'SET @s = '.$saldoawal['saldo'].'; SET @d = 0; SET @k = 0;';
        $this->db->query($sqlx);

        $sql = "SELECT
                    tra.kode_coa AS kd_coa,
                    mcoa.nama AS nm_coa,
                    tra.tanggal AS tanggal,
                    tra.no_bukti,
                    tra.no_terbit,
                    tra.keterangan AS uraian,
                    tra.dk AS dk,
                    tra.rupiah AS rupiah,
                    @d:=IF(tra.dk = 'D', tra.rupiah, 0)AS debit,
                    @k:=IF(tra.dk = 'K', tra.rupiah, 0)AS kredit, 
                    @s:=(@s+@d)-@k AS saldo 
                FROM
                    tr_accounting tra
                INNER JOIN mst_coa mcoa ON mcoa.kode = tra.kode_coa
                WHERE
                    tra.kode_spk = '$kode_spk' AND 
                    YEAR(tra.tanggal)='$thn' AND MONTH(tra.tanggal)='$bln' ";
                if(!$kdcoa==false||!empty($kdcoa)){
                    //$sql .= " AND tra.kode_coa ='".$kdcoa."' ";
                }
        $sql .= " ORDER BY mcoa.kode, tra.tanggal ASC";
        //echo '<pre>'.$sql.'</pre>';die;
        $query = $this->db->query($sql);
       
        $data = $query->result_array();
        
        //echo $data['SA']['SALDO_AWAL'];
        //var_dump($data);die;
        return $query;
    }

    function gen_rpt_bukubesar2($periode){
        list($bln, $thn) = explode('-', $periode);
        $periode =  $thn.'-'.sprintf('%02d',$bln).'-01';
        $periode_lalu = $thn.'-'.sprintf('%02d',($bln - 1)).'-01';
        $period = $thn.'-'.sprintf('%02d',$bln);

        $kode_spk = $this->session->userdata('kode_entity');

        $sqlx = "SELECT * FROM (
                    select hd.tanggal, hd.no_bukti, hd.kode_coa, CONCAT('---',mc.nama) as keterangan, ''AS debit, ''AS kredit
                    FROM tr_accounting hd
                    INNER JOIN mst_coa mc ON mc.kode = hd.kode_coa
                    WHERE tanggal <= LAST_DAY('$periode_lalu') AND hd.kode_spk = '$kode_spk'  
                    GROUP BY hd.kode_coa
                    UNION

                            SELECT dit.tanggal, dit.no_bukti,dit.kode_coa, dit.keterangan, IF(dit.dk='D',dit.rupiah,0) as debit, IF(dit.dk='K',dit.rupiah,0)AS kredit
                            FROM tr_accounting dit
                            INNER JOIN mst_coa mc1 ON mc1.kode = dit.kode_coa
                            WHERE tanggal LIKE '$period%'
                            ORDER BY kode_coa, tanggal
                    ) t
                    ORDER BY kode_coa,tanggal";
        $sql = "SELECT * FROM (
                    SELECT hd.tanggal, hd.no_bukti, hd.kode_coa, CONCAT('---',mc.nama) as keterangan, ''AS debit, ''AS kredit, 
                    SUM(IF(hd.dk='D',hd.rupiah,0)-IF(hd.dk='K',hd.rupiah,0)) as saldo_awal, 'unset' as saldo_detail
                    FROM tr_accounting hd
                    INNER JOIN mst_coa mc ON mc.kode = hd.kode_coa
                    WHERE tanggal <= LAST_DAY('$periode_lalu')  AND hd.kode_spk = '$kode_spk'  
                    GROUP BY hd.kode_coa
                UNION
                    /*SELECT dit.tanggal, dit.no_bukti,dit.kode_coa, dit.keterangan, 
                    IF(dit.dk='D',dit.rupiah,0) as debit, IF(dit.dk='K',dit.rupiah,0)AS kredit, 0 as saldo_awal, 0 as saldo_detail
                    FROM tr_accounting dit
                    INNER JOIN mst_coa mc1 ON mc1.kode = dit.kode_coa
                    WHERE tanggal LIKE '$period%'
                    ORDER BY kode_coa, tanggal*/
                    SELECT dit.tanggal, dit.no_bukti, dit.kode_coa, dit.keterangan, 
                        IF(dit.dk='D',dit.rupiah,0) as debit, IF(dit.dk='K',dit.rupiah,0)AS kredit, 
                        (
                            (
                                (
                                    SELECT DISTINCT SUM(IF(tac.dk='D',tac.rupiah,0)-IF(tac.dk='K',tac.rupiah,0))AS saldo_awal 
                                    FROM tr_accounting tac
                                    WHERE tac.tanggal <= LAST_DAY('$periode_lalu') and tac.kode_coa = dit.kode_coa
                                    GROUP BY kode_coa 
                                )+IF(dit.dk='D',dit.rupiah,0)
                            )-IF(dit.dk='K',dit.rupiah,0)
                        )as saldo, 0 as saldo_detail
                        FROM tr_accounting dit
                        INNER JOIN mst_coa mc1 ON mc1.kode = dit.kode_coa
                        WHERE tanggal LIKE '$period%'
                        ORDER BY kode_coa, tanggal
                ) t
                ORDER BY kode_coa,tanggal";

        //echo $sql;die;

        $query = $this->db->query($sql);
        $res = $query->result_array();
        
        return $res;
    }

    function get_saldoAwal_childbukubesar($kdcoa,$periode) {
       // echo $kdcoa.'::'.$periode;die;
        list($bln, $thn) = explode('-', $periode);
        $periode =  $thn.'-'.sprintf('%02d',$bln);
        $periode_lalu = $thn.'-'.sprintf('%02d',($bln - 1)).'-01';

        $kode_spk = $this->session->userdata('kode_entity');

        $sqlx = 'SET @sa = 0; SET @da = 0; SET @ka = 0;';
        $this->db->query($sqlx);

        $sql_sa = "SELECT
                            tra.kode_coa,
                            mcoa.nama AS nama_akun, tra.dk,
                            @d := sum(IF(tra.dk = 'D', tra.rupiah, 0))AS debit,
                            @k := sum(IF(tra.dk = 'K', tra.rupiah, 0))AS kredit, 
                            sum(IF(tra.dk = 'D', tra.rupiah, 0)) -  sum(IF(tra.dk = 'K', tra.rupiah, 0))AS saldo 
                    FROM
                            tr_accounting tra
                    INNER JOIN mst_coa mcoa ON mcoa.kode = tra.kode_coa
                    WHERE
                            tra.tanggal <= LAST_DAY('$periode_lalu')  AND tra.kode_coa = $kdcoa AND kode_spk = '$kode_spk' 
                    GROUP BY mcoa.kode
                    ORDER BY mcoa.kode, tra.tanggal ASC";
        echo '<pre>'.$sql_sa.'</pre>';die;
        $q_sa   = $this->db->query($sql_sa);
        $data = array();
        $res = $q_sa->row_array();
        //foreach ($res as $k => $v) {
        //    $saldo = $v['saldo'];
            
        //}
        return $res;
    }

    function get_saldoAwal_bukubesar($periode,$kddiv) {
        list($bln, $thn) = explode('-', $periode);
        $periode =  $thn.'-'.sprintf('%02d',$bln);
        $periode_lalu = $thn.'-'.sprintf('%02d',$bln-1).'-01';

        $kode_spk = $this->session->userdata('kode_entity');

        $this->db->query('SET @sa = 0');
        $this->db->query('SET @da = 0');
        $this->db->query('SET @ka = 0');

        $sql_sa = "SELECT
                            tra.kode_coa,
                            mcoa.nama AS nama_akun, tra.dk,
                            @d := sum(IF(tra.dk = 'D', tra.rupiah, 0))AS debit,
                            @k := sum(IF(tra.dk = 'K', tra.rupiah, 0))AS kredit, 
                            sum(IF(tra.dk = 'D', tra.rupiah, 0)) -  sum(IF(tra.dk = 'K', tra.rupiah, 0))AS saldo 
                    FROM
                            tr_accounting tra
                    INNER JOIN mst_coa mcoa ON mcoa.kode = tra.kode_coa
                    WHERE
                            tra.tanggal <= LAST_DAY('$periode_lalu') AND tra.kode_spk = '$kode_spk' 
                    GROUP BY mcoa.kode
                    ORDER BY mcoa.kode, tra.tanggal ASC";
        $q_sa   = $this->db->query($sql_sa);
        $data = array();
        $res = $q_sa->result_array();
        /*foreach ($res as $k => $v) {
            $coa[] = $v['kode_coa'];
            $nm_coa[] = $v['nama_akun']; 
            $data[] = array('coa'=>$v['kode_coa'],'nm_coa'=>$v['nama_akun'],'saldo'=>$v['saldo']);
        }*/
        return $res;
    }

    function gen_saldoAwal_kasbank($periode){
        
        list($bln, $thn) = explode('-', $periode);
        $periode =  $thn.'-'.sprintf('%02d',$bln).'-01';
        $kode_spk = $this->session->userdata('kode_entity');

        $sql = "SELECT kode_coa, mc.nama as deskripsi, SUM(IF(dk='D',rupiah,0)-IF(dk='K',rupiah,0))AS saldo_awal 
                FROM tr_accounting tac
                INNER JOIN mst_coa mc ON mc.kode = tac.kode_coa
                WHERE tanggal <= LAST_DAY('$periode')
                    AND tac.kode_spk = '$kode_spk' 
                GROUP BY kode_coa  ";

        $query = $this->db->query($sql);  

        $res = $query->result_array();

        return $res;
    }
    function gen_rpt_bukubesar($periode) {
        list($bln, $thn) = explode('-', $periode);
        $periode =  $thn.'-'.sprintf('%02d',$bln);
        $periode_lalu = $thn.'-'.sprintf('%02d',($bln - 1));

        $kode_spk = $this->session->userdata('kode_entity');

        $this->db->query('SET @sa = 0');
        $this->db->query('SET @da = 0');
        $this->db->query('SET @ka = 0');

        $sql1 = "SELECT
                    mcoa.kode AS kode_akun,
                    mcoa.nama AS nama_akun,
                    sum(IF(tr.dk = 'D', tr.rupiah, 0) )AS sDebit,
                    sum(IF(tr.dk = 'K', tr.rupiah, 0) )AS sKredit,
                    ( (sum(IF(tr.dk = 'D', tr.rupiah, 0))) - (sum(IF(tr.dk = 'K', tr.rupiah, 0))) )AS SALDO_AWAL
                FROM
                    tr_accounting tr
                INNER JOIN mst_coa mcoa ON mcoa.kode = tr.kode_coa
                WHERE
                    tr.kode_spk = '$kode_spk' AND tr.tanggal LIKE '".$periode_lalu."%' 
                AND tr.kode_coa = 11111
                GROUP BY
                    tr.kode_coa"; 
        $q_sa   = $this->db->query($sql1);
        $data = array();
        if($q_sa->num_rows() > 0){
        $res = $q_sa->row_array();
            $data = $res;

            $sa = $res['SALDO_AWAL'];
        }else{
            $sa = 0;
        }
        

        //var_dump($data);die;
        $this->db->query('SET @s = '.$sa);
        $this->db->query('SET @d = 0');
        $this->db->query('SET @k = 0');
        $sql = "SELECT
                    tra.kode_coa AS KODE_AKUN,
                    mcoa.nama AS NAMA_AKUN,
                    tra.tanggal AS TANGGAL,
                    tra.no_bukti AS NO_BUKTI,
                    tra.keterangan AS URAIAN,
                    tra.dk AS DK,
                    tra.rupiah AS RUPIAH,
                    @d := IF(tra.dk = 'D', tra.rupiah, 0)AS DEBIT,
                    @k := IF(tra.dk = 'K', tra.rupiah, 0)AS KREDIT, 
                    @s :=(@s + @d)- @k AS SALDO 
                FROM
                    tr_accounting tra
                INNER JOIN mst_coa mcoa ON mcoa.kode = tra.kode_coa
                WHERE
                    tra.kode_spk = '$kode_spk' AND tra.tanggal LIKE '".$periode."%' 
                ORDER BY mcoa.kode, tra.tanggal ASC";
        $q_bb = $this->db->query($sql);
        
        $data = $q_bb->result_array();
        $data['SA'] = array('SALDO_AWAL'=>$sa);
        //echo $data['SA']['SALDO_AWAL'];
        //var_dump($data);die;
        return $data;
    }

    function gen_rpt_kasbank($periode) {
        list($bln, $thn) = explode('-', $periode);
        $periode =  $thn.'-'.sprintf('%02d',$bln);
        $periode_lalu = $thn.'-'.sprintf('%02d',($bln - 1)).'-01';
        $last_periode = $thn.'-'.sprintf('%02d',($bln-1) ).'-01';

        $this->db->query('SET @sa = 0');
        $this->db->query('SET @da = 0');
        $this->db->query('SET @ka = 0');

        $kode_spk = $this->session->userdata('kode_entity');

        $sql1 = "SELECT
                    mcoa.kode AS kode_akun,
                    mcoa.nama AS nama_akun,
                    sum(IF(tr.dk = 'D', tr.rupiah, 0) )AS sDebit,
                    sum(IF(tr.dk = 'K', tr.rupiah, 0) )AS sKredit,
                    ( (sum(IF(tr.dk = 'D', tr.rupiah, 0))) - (sum(IF(tr.dk = 'K', tr.rupiah, 0))) )AS SALDO_AWAL
                FROM
                    tr_accounting tr
                INNER JOIN mst_coa mcoa ON mcoa.kode = tr.kode_coa
                WHERE
                    tr.kode_spk = '$kode_spk' AND 
                    tr.tanggal <= '".$periode."-01'
                AND tr.kode_coa IN (11111,11121)
                GROUP BY
                    tr.kode_coa"; 
        $q_sa   = $this->db->query($sql1);
        //print_r($sql1);die;
        //echo $sql1.'<br>#<br>';
        $data = array();
        $sa = array();
        if($q_sa->num_rows() > 0){
        $res = $q_sa->result_array();
            $data = $res;
            $sa = array('coa'=>$res['kode_akun'],'s_awal'=>$res['SALDO_AWAL']);
        }else{
            $sa = array('coa'=>$res['kode_akun'],'s_awal'=>0);
        }
        

        //var_dump($data);die;
        $this->db->query('SET @s = 0');
        $this->db->query('SET @d = 0');
        $this->db->query('SET @k = 0');
        $this->db->query('SET @bs = 0');
        $this->db->query('SET @bd = 0');
        $this->db->query('SET @bk = 0');
        $this->db->query('SET @ts = 0');
        $sql = "SELECT
                    tra.kode_coa AS KODE_AKUN,
                    mcoa.nama AS NAMA_AKUN,
                    tra.tanggal AS TANGGAL,
                    tra.no_bukti AS NO_BUKTI,
                    tra.keterangan AS URAIAN,
                    @d := IF(tra.dk = 'D', IF(tra.kode_coa=11111,tra.rupiah,0), 0)AS KAS_DEBIT,
                    @k := IF(tra.dk = 'K', IF(tra.kode_coa=11111,tra.rupiah,0), 0)AS KAS_KREDIT,
                    @s :=(@s + @d)- @k AS SALDO_KAS,
                    @bd := IF(tra.dk = 'D', IF(tra.kode_coa=11121,tra.rupiah,0), 0)AS BANK_DEBIT,
                    @bk := IF(tra.dk = 'K', IF(tra.kode_coa=11121,tra.rupiah,0), 0)AS BANK_KREDIT,
                    @bs :=(@bs + @bd)- @bk AS SALDO_BANK,
                    @ts := (@s + @bs) AS JUMLAH_KAS
                FROM
                    tr_accounting tra
                INNER JOIN mst_coa mcoa ON mcoa.kode = tra.kode_coa
                WHERE
                    tra.kode_spk = '$kode_spk' AND YEAR(tra.tanggal)='$thn' AND MONTH(tra.tanggal)='$bln'
                AND mcoa.kode IN(11111,11121)
                ORDER BY tra.no_bukti ASC";
        $q_bb = $this->db->query($sql);
        //print($sql);
        $data = $q_bb->result_array();
        $data['SA'] = array('SALDO_AWAL'=>$sa);
        //echo $data['SA']['SALDO_AWAL'];
        //var_dump($data);die;
        return $data;
    }

    function get_saldoAwalKasBank($periode,$kode_coa=false) {
        list($bln, $thn) = explode('-', $periode);
        $periode =  $thn.'-'.sprintf('%02d',$bln);
        $periode_lalu = $thn.'-'.sprintf('%02d',($bln - 1));
        $last_periode = $thn.'-'.sprintf('%02d',($bln-1) ).'-01';

        $periode_sa = $thn.'-'.sprintf('%02d',$bln ).'-01';
        $kode_spk = $this->session->userdata('kode_entity');

        if($kode_coa!=false)
        {
            
            $sql = "SELECT
                        mcoa.kode AS kode_akun,
                        mcoa.nama AS nama_akun,
                        sum(IF(tr.dk = 'D', IF(tr.kode_coa=".$kode_coa.",tr.rupiah,0), 0) )AS sa_debit,
                        sum(IF(tr.dk = 'K', IF(tr.kode_coa=".$kode_coa.",tr.rupiah,0), 0) )AS sa_kredit,
                        ( (sum(IF(tr.dk = 'D', IF(tr.kode_coa=".$kode_coa.",tr.rupiah,0), 0))) - (sum(IF(tr.dk = 'K', IF(tr.kode_coa=".$kode_coa.",tr.rupiah,0), 0))) )AS sa_awal
                    FROM
                        tr_accounting tr
                    INNER JOIN mst_coa mcoa ON mcoa.kode = tr.kode_coa
                    WHERE
                        tr.kode_spk = '".$kode_spk."' AND tr.tanggal < '".$periode.'-01'."'
                    AND tr.kode_coa = 11111
                    GROUP BY
                        tr.kode_coa"; 
           
            $query   = $this->db->query($sql);
            //echo $sql;die;
            $data = array();
            $data['sql'] = $sql;
            //var_dump($data);die;
            if($query->num_rows() > 0){
            $res = $query->row_array();
                $data = $res;

                //$sa = $res['SALDO_AWAL'];
            }else{
                $data = array('sa_debit'=>0,'sa_kredit'=>0,'sa_awal'=>0);
            }
        }else{
            $this->db->query('SET @sa = 0');
            $this->db->query('SET @da = 0');
            $this->db->query('SET @ka = 0');

            $sql = "SELECT
                        mcoa.kode AS kode_akun,
                        mcoa.nama AS nama_akun,
                        sum(IF(tr.dk = 'D', IF(tr.kode_coa=11111,tr.rupiah,0), 0) )AS kas_debit,
                        sum(IF(tr.dk = 'K', IF(tr.kode_coa=11111,tr.rupiah,0), 0) )AS kas_kredit,
                        ( (sum(IF(tr.dk = 'D', IF(tr.kode_coa=11111,tr.rupiah,0), 0))) - (sum(IF(tr.dk = 'K', IF(tr.kode_coa=11111,tr.rupiah,0), 0))) )AS SALDO_KAS,
                        sum(IF(tr.dk = 'D', IF(tr.kode_coa=11121,tr.rupiah,0), 0) )AS bank_debit,
                        sum(IF(tr.dk = 'K', IF(tr.kode_coa=11121,tr.rupiah,0), 0) )AS bank_kredit,
                        ( (sum(IF(tr.dk = 'D', IF(tr.kode_coa=11121,tr.rupiah,0), 0))) - (sum(IF(tr.dk = 'K', IF(tr.kode_coa=11121,tr.rupiah,0), 0))) )AS SALDO_BANK,
                        '' AS JUMLAH_SALDO
                    FROM
                        tr_accounting tr
                    INNER JOIN mst_coa mcoa ON mcoa.kode = tr.kode_coa
                    WHERE
                        tr.kode_spk = '$kode_spk' AND 
                        tr.tanggal < '".$periode.'-01'."'
                        AND tr.kode_coa IN(11111,11121)
                    GROUP BY
                        tr.kode_coa"; 
            //echo '<code>$sql.'</code><p>';die;
            $query   = $this->db->query($sql);
            $data = array();
            $data = $query->result();
            if ($query->num_rows() > 0)
            {
                $row = $query->row();
                foreach ($query->result() as $row)
                    $data = array( 
                    'kas_debit'=>$query->first_row()->kas_debit,'kas_kredit'=>$query->first_row()->kas_kredit,'kas_saldoawal'=>$query->first_row()->SALDO_KAS,
                    'bank_debit'=>$row->bank_debit,'bank_kredit'=>$row->bank_kredit,'bank_saldoawal'=>$row->SALDO_BANK );
            }
        }
        //var_dump($data);die;
        return $data;
    }

    function save_file_info($file) {
        //start db traction
        $this->db->trans_start();
        //file data
        $file_data = array(
            'file_name'         => $file['file_name'],
            'file_orig_name'    => $file['orig_name'],
            'file_path'         => $file['full_path'],
            'upload_date'       => date('Y-m-d H:i:s')
        );
        //insert file data
        $this->db->insert('tr_upload', $file_data);
        //complete the transaction
        $this->db->trans_complete();
        //check transaction status
        if ($this->db->trans_status() === FALSE) {
            $file_path = $file['full_path'];
            //delete the file from destination
            if (file_exists($file_path)) {
                unlink($file_path);
            }
            //rollback transaction
            $this->db->trans_rollback();
            return FALSE;
        } else {
            //commit the transaction
            $this->db->trans_commit();
            return TRUE;
        }
    }

    function transferUploadedByUsername($username){
        
        $kode_spk = $this->session->userdata('kode_entity');
        $tr_level = $this->session->userdata('unit_kerja')=='KAWASAN'?'PROYEK':'DEPT';
        $kd_divisi = $this->session->userdata('kode_dept');
        $post_time = gmdate("Y-m-d H:i:m", time()+60*60*7);

        $no_buk = '';



        $sql = "SELECT * FROM tr_accounting_upload WHERE uid='".$username."'";
        $q = $this->db->query($sql);
        $data = $q->result_array();
        foreach ($data as $k => $v) {
            $no_bukti[] = $v['no_bukti'];
            
            $dt = array($username,$v['no_bukti']);

            $ins2trx[] = array(
                    'kode_divisi'       =>$v['kode_divisi'], 
                    'jenis'             =>substr($v['no_bukti'],-4,1), 
                    'tanggal'           =>$v['tanggal'], 
                    'no_bukti'          =>strtoupper($v['no_bukti']), 
                    'no_terbit'         =>$v['no_terbit'], 
                    'kode_coa'          =>$v['kode_coa'], 
                    'kode_nasabah'      =>$v['kode_nasabah'], 
                    'kode_sumberdaya'   =>$v['kode_sumberdaya'], 
                    'kode_spk'          =>$v['kode_spk'], 
                    'kode_tahap'        =>$v['kode_tahap'], 
                    'no_invoice'        =>$v['no_invoice'], 
                    'kode_faktur'       =>$v['kode_faktur'],
                    'bukti_potong'      =>$v['bukti_potong'], 
                    'volume'            =>$v['volume'], 
                    'keterangan'        =>$v['uraian'], 
                    'dk'                =>$v['dk'], 
                    'rupiah'            =>$v['rupiah'], 
                    'tr_level'          =>$tr_level,
                    'posted_by'         =>$username,
                    'posted_date'       =>$post_time
                );
            
        }
        $sql = "SELECT DISTINCT * FROM tr_accounting_upload WHERE uid='".$username."'";
        $q = $this->db->query($sql);
        $ris = $q->result_array();
        //$string = '';
        foreach ($ris as $k => $v) {
            $no_buk .= ', '."'".$v['no_bukti']."'";
        }
        $no_buk = substr($no_buk, 1);
        //echo($no_buk);die;
        $sqls = "SELECT * FROM tr_accounting WHERE no_bukti IN($no_buk)";
        //echo $sqls;die;
        $qr = $this->db->query($sqls);
        $res = $qr->result_array();
        foreach ($res as $key => $v) {
            $ins2bin[] = array(
                    'kode_divisi'       =>$v['kode_divisi'], 
                    'jenis'             =>$v['jenis'], 
                    'tanggal'           =>$v['tanggal'], 
                    'no_bukti'          =>$v['no_bukti'], 
                    'no_terbit'         =>$v['no_terbit'], 
                    'kode_coa'          =>$v['kode_coa'], 
                    'kode_nasabah'      =>$v['kode_nasabah'], 
                    'kode_sumberdaya'   =>$v['kode_sumberdaya'], 
                    'kode_spk'          =>$v['kode_spk'], 
                    'kode_tahap'        =>$v['kode_tahap'], 
                    'no_invoice'        =>$v['no_invoice'], 
                    'kode_faktur'       =>$v['kode_faktur'],
                    'bukti_potong'      =>$v['bukti_potong'], 
                    'volume'            =>$v['volume'], 
                    'keterangan'        =>$v['keterangan'], 
                    'dk'                =>$v['dk'], 
                    'rupiah'            =>$v['rupiah'], 
                    'tr_level'          =>$tr_level,
                    'posted_by'         =>$v['posted_by'],
                    'posted_date'       =>$v['posted_date'],
                    'deleted_by'        =>$username, 
                    'deleted_date'      =>$post_time,
                    'deleted_rowid'     =>$v['id']
                );
        }

        $delexist = "DELETE FROM tr_accounting WHERE no_bukti IN($no_buk)";

        $this->db->insert_batch('tr_accounting_bin', $ins2bin);
        $this->db->query($delexist);
        $this->db->insert_batch('tr_accounting', $ins2trx); 
        
        $empty_bin = "DELETE FROM tr_accounting_upload WHERE uid='".$username."'";
        $this->db->query($empty_bin);
    }

    function read_n_save($fileExcel) {
        $this->load->library(array('PHPExcel','PHPExcel'));
        $this->load->helper('tglbil');
        $this->load->helper('combo');
        //$this->load->model('Tr_accounting_model');

        $uid = $this->session->userdata('usernm');
        //sikat habis 
        $this->db->where(array('uid'=>$uid));
        $this->db->delete('tr_accounting_upload');

        $inputFileName = $fileExcel;

        try {
            $inputFileType  = PHPExcel_IOFactory::identify($inputFileName);
            $objReader      = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel    = $objReader->load($inputFileName);
        } catch (Exception $e) {
            die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) 
            . '": ' . $e->getMessage());
        }

        $sheet          = $objPHPExcel->getSheet(0);
        $highestRow     = $sheet->getHighestRow();
        $highestColumn  = $sheet->getHighestColumn();

        for ($row = 4; $row <= $highestRow; $row++) 
        {
            
            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, 
            NULL, TRUE, FALSE);

            $tglExcel = date('Y-m-d',PHPExcel_Shared_Date::ExcelToPHP($rowData[0][1])); 
            $tgl_sys = str_replace('--', '', tgl_tosystem($tglExcel));

            foreach($rowData[0] as $k=>$v) 
                //echo "Row: ".$row."- Col: ".($k+1)." = ".$v."<br />";
                $data = array(
                        "uid"               => $uid,
                        "kode_divisi"       => $rowData[0][0],
                        "tanggal"           => ($rowData[0][1]==NULL?NULL:$tgl_sys),
                        "no_bukti"          => $rowData[0][2],
                        "no_terbit"         => $rowData[0][3],
                        "kode_coa"          => $rowData[0][4],
                        "kode_nasabah"      => $rowData[0][5],
                        "kode_sumberdaya"   => $rowData[0][6],
                        "kode_spk"          => $rowData[0][7],
                        "kode_tahap"        => $rowData[0][8],
                        "no_invoice"        => $rowData[0][9],
                        "kode_faktur"       => $rowData[0][10],
                        "bukti_potong"      => $rowData[0][11],
                        "volume"            => $rowData[0][12],
                        "uraian"            => $rowData[0][13],
                        "dk"                => $rowData[0][14],
                        "rupiah"            => $rowData[0][15]
                );
                $this->db->trans_start();
                $this->db->insert("tr_accounting_upload",$data);     
                $this->db->trans_complete();
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            //echo 'ROLL BACK';
            return FALSE;
        } else {
            //commit the transaction
            $this->db->trans_commit();
            return TRUE;
            //echo 'COMMIT';
        }
    }

    function cek_uploaddata() {
        $uid    = $this->session->userdata('usernm');
        $this->db->select('*');
        $this->db->where(array('uid'=>$uid));
        $q      = $this->db->get('tr_accounting_upload');
        
        $num = $q->num_rows();
        if($num > 0) {
            $out = array(
                'response'      =>'1',
                'error_num'     =>'0',
                'msg'           =>'Success'
            );
        } else {
            $out = array(
                'response'      =>'0',
                'error_num'     =>$this->db->_error_number(),
                'msg'           =>$this->db->_error_message()
            );
        }
        //var_dump($out);die;
        return $out;
    }

    function set_NoBuktiIsExist($no_bukti) {
        $updSQL = "UPDATE tr_accounting_upload SET is_nobuk_exist=1 WHERE no_bukti='".$no_bukti."'";
        
        $this->db->distinct();
        $this->db->select('no_bukti');
        $this->db->where('no_bukti', $no_bukti); 
        $query = $this->db->get('tr_accounting');
        $num = $query->num_rows();
        $row = $query->row();
        if($num > 0)
        {
            $this->db->where('no_bukti', $no_bukti);
            $this->db->update('tr_accounting_upload','is_nobuk_exist = 1');
        }else{
            $this->db->where('no_bukti', $no_bukti);
            $this->db->update('tr_accounting_upload','is_nobuk_exist = 2');
        }
        /*$sql = "SELECT "
        $sql = "CALL sp_setStatusExistTRX('".$no_bukti."')";
        $this->db->query($sql);*/
    }

    function getmove_nobuktiExist($nobuk) {
    }

    function getNamaDivisi($kode) {
        $array = array('udiv.username' => $this->session->userdata('usernm'), 'mdiv.kode' => $kode);
        $this->db->where($array); 
        $this->db->select('udiv.divisi_level, mdiv.kode, mdiv.nama');
        $this->db->from('t_user_divisi udiv');
        $this->db->join('mst_divisi mdiv', 'mdiv.kode = udiv.kode_divisi','inner');

        $query = $this->db->get();
        //var_dump($query);die;
        return $query->row_array();
    }

    function isMandatory($kode){
        $array = array('kode' => $kode);
        $this->db->where($array); 
        $this->db->select('kode, mand_tahap, mand_nasabah, mand_pajak, mand_sbd, mand_bank');
        $this->db->from('mst_coa');

        $query = $this->db->get();
        
        $res = $query->row_array();

        return $res;
    }

    function getNomorBukti($no_bukti){
        $this->db->distinct();
        $this->db->select('no_bukti');
        $this->db->where('no_bukti', $no_bukti); 
        $query = $this->db->get('tr_accounting');
        $num = $query->num_rows();
        $row = $query->row();
        if($num > 0)
        {
            return true;
        }else{
            return false;
        }
    }

    function _lookup($str_kode,$keyword){
        if($str_kode=='coa'){
            $this->db->select('kode,nama,mand_tahap,mand_sbd,mand_nasabah,mand_pajak,mand_bank')->from('mst_coa');
            $this->db->like('kode',$keyword,'after');
            $this->db->or_like('nama',$keyword,'both');  
        }
        if($str_kode=='customer'){
            $this->db->select('kode,nama')->from('mst_nasabah'); 
            $this->db->like('kode',$keyword,'both');
            $this->db->or_like('nama',$keyword,'both'); 
        }
        if($str_kode=='nasabah'){    ///ini perlu direvisi... terbalik sm yg atas. ok?!
            $this->db->select('kode, nama')->from('mst_nasabah_konstruksi'); 
            $this->db->like('kode',$keyword,'both');
            $this->db->or_like('nama',$keyword,'both'); 
        }
        if($str_kode=='sbdy'){
            $this->db->select('kode, nama')->from('mst_sumberdaya'); 
            $this->db->like('kode',$keyword,'both');
            $this->db->or_like('nama',$keyword,'both'); 
        }
        if($str_kode=='spk'){
            $this->db->select('kode,nama')->from('mst_entity'); 
            $this->db->like('kode',$keyword,'both');
            $this->db->or_like('nama',$keyword,'both'); 
        }
        if($str_kode=='tahap'){
            $this->db->select('kode,nama')->from('mst_tahap'); 
            $this->db->like('kode',$keyword,'both');
            $this->db->or_like('nama',$keyword,'both'); 
        }
        if($str_kode=='bank'){
            $this->db->select('kode,nama')->from('mst_bank'); 
            $this->db->like('kode',$keyword,'both');
            $this->db->or_like('nama',$keyword,'both'); 
        }
        if($str_kode=='jenis'){
            $this->db->select('kode,nama_jenis as nama')->from('mst_jenis_jurnal');
            $this->db->like('kode',$keyword,'both');
            $this->db->or_like('nama_jenis',$keyword,'both'); 
        }
        if($str_kode=='sales_customer'){
            $this->db->select('kode,no_id, jenis_id, klasifikasi, salutation, nama,npwp,email,hp,tempat_lahir,tgl_lahir,nationality, agama, jk, alamat, kota, telp_rumah,
                nama_perusahaan, alamat_perusahaan, kota_perusahaan, kodepos_perusahaan, telp_perusahaan, fax_perusahaan ')->from('mst_customer_tmp');
            $this->db->like('nama',$keyword,'both'); 
        }
        if($str_kode=='kode_terbit'){
            $this->db->select('no_terbit as kode, keterangan as nama')->from('tr_accounting');
            $this->db->like('no_terbit',$keyword,'both'); 
        }

        $query = $this->db->get();
 
        return $query->result();
    }
    
    function _json_nobuk($nobuk){
        $this->db->select('
            id, kode_divisi, tanggal, jenis, no_bapb, no_invoice, no_bukti, kode_coa, 
            f_getNamaAkun(kode_coa) as nama_akun, 
            f_getNamaCustomer(kode_customer) as nama_nasabah, kode_nasabah, 
            f_getNamaNasabah(kode_nasabah) as nama_customer, kode_customer, 
            f_getNamaSumberdaya(kode_sumberdaya) as nama_sumberdaya, kode_sumberdaya,  
            f_getNamaEntity(kode_spk) as nama_entity, kode_spk, 
            f_getNamaTahap(kode_tahap) as nama_tahap, kode_tahap, 
            f_getNamaBank(kode_bank) as nama_bank, kode_bank, 
            kode_faktur, volume, keterangan, dk, rupiah, 
            bukti_potong, tr_level, no_terbit')->from('tr_accounting'); 
        $this->db->where(array('no_bukti'=>$nobuk));
        $query = $this->db->get();
        
        return $query->result();
    }

    function gen_utang_rincipemasokx($periode,$kd_nasabah)
    {
        
        list($bln, $thn) = explode('-', $periode);
        $periode =  $thn.'-'.sprintf('%02d',$bln).'-01';
        $periode_lalu = $thn.'-'.sprintf('%02d',($bln - 1));
        

        $sql = " SELECT DISTINCT kode_nasabah FROM tr_accounting ";
        $q = $this->db->query($sql);
        $data = $q->result_array();
        //print_r($data);
        foreach ($data  as $k => $v) {
            if(!empty($v['kode_nasabah'])){
                $kd_nasabah[] =  $v['kode_nasabah'];
            }
            //var_dump($v['kode_nasabah']);
        }
        //die('<pre>'.$sql.'</pre>');

        //eodcm = End Of Day Current Month

        //CEK YANG SUDAH LUNAS = 0
        $sql_lunas = "  SELECT DISTINCT tra.no_terbit, tra.no_bukti, 'SUB TOTAL' AS keterangan, tra.kode_nasabah, 
                            SUM( IF( tra.dk = f_cek_os_penerbitan(tra.kode_coa), tra.rupiah, 0 ) )AS penerbitan, 
                            SUM( IF( tra.dk = f_cek_os_pelunasan(tra.kode_coa), tra.rupiah, 0 ) )AS pelunasan, 
                            ( sum( IF( tra.dk = f_cek_os_penerbitan(tra.kode_coa), tra.rupiah, 0 ) ) - SUM( IF( tra.dk = f_cek_os_pelunasan(tra.kode_coa), tra.rupiah, 0 ) ) ) as sisa, 
                            LAST_DAY( DATE_ADD(CURDATE(), INTERVAL - 1 MONTH) )AS eodcm, datediff( LAST_DAY( DATE_ADD(CURDATE(), INTERVAL - 1 MONTH) ), tra.tanggal )AS umur 
                        FROM tr_accounting tra 
                        INNER JOIN mst_nasabah mn ON mn.kode = tra.kode_nasabah 
                        WHERE tra.tanggal < '$periode' 
                        GROUP BY no_terbit,kode_nasabah 
                        ORDER BY keterangan ASC ";
                    //echo $sql_lunas;die;
        $ql = $this->db->query($sql_lunas);
        $res_l = $ql->result_array();
        foreach ($res_l as $k => $v) {
            if($v['sisa'] > 0){
                $no_bukti[] = $v['no_bukti'];
                $kd_nasabah[] = $v['kode_nasabah'];
                $sisa[] = $v['sisa'];
            }
        }
        

        $nomor_bukti = count($no_bukti)>0?" AND no_bukti NOT IN('".implode("','", $no_bukti)."' ":"";

        $sql2 = "SELECT tra.no_terbit, tra.kode_coa, tra.tanggal, tra.no_bukti, tra.keterangan, tra.kode_nasabah, 
                        mn.nama AS nama_nasabah, IF( tra.dk = f_cek_os_penerbitan(tra.kode_coa), tra.rupiah, 0 )AS penerbitan, 
                        IF( tra.dk = f_cek_os_pelunasan(tra.kode_coa), tra.rupiah, 0 )AS pelunasan, 
                        LAST_DAY( DATE_ADD(CURDATE(), INTERVAL - 1 MONTH) )AS eodcm, 
                        datediff( LAST_DAY( DATE_ADD(CURDATE(), INTERVAL - 1 MONTH) ), tra.tanggal )AS umur 
                FROM tr_accounting tra 
                INNER JOIN mst_nasabah mn ON mn.kode = tra.kode_nasabah
                WHERE tanggal < '$periode'
                ORDER BY tanggal, no_terbit, no_bukti ASC 
                ";

        //print($sql2);
        
        $data = array();
        $query = $this->db->query($sql2);
        $data = $query->result_array();
        
        
        return $data;   
    }

    function get_hutangnol($periode){
        $kode_spk = $this->session->userdata('kode_entity');
        $sql_lunas = "  SELECT DISTINCT tra.no_terbit, tra.no_bukti, 'SUB TOTAL' AS keterangan, tra.kode_nasabah, 
                            SUM( IF( tra.dk = f_cek_os_penerbitan(tra.kode_coa), tra.rupiah, 0 ) )AS penerbitan, 
                            SUM( IF( tra.dk = f_cek_os_pelunasan(tra.kode_coa), tra.rupiah, 0 ) )AS pelunasan, 
                            ( sum( IF( tra.dk = f_cek_os_penerbitan(tra.kode_coa), tra.rupiah, 0 ) ) - SUM( IF( tra.dk = f_cek_os_pelunasan(tra.kode_coa), tra.rupiah, 0 ) ) ) as sisa, 
                            LAST_DAY( DATE_ADD(CURDATE(), INTERVAL - 1 MONTH) )AS eodcm, datediff( LAST_DAY( DATE_ADD(CURDATE(), INTERVAL - 1 MONTH) ), tra.tanggal )AS umur 
                        FROM tr_accounting tra 
                        INNER JOIN mst_nasabah_konstruksi mn ON mn.kode = tra.kode_nasabah 
                        WHERE tra.tanggal < '$periode' AND kode_coa = (select kode_coa from mst_setting_os where kode_menu='rpt-opensystem-pemasok') AND kode_spk = '$kode_spk' 
                        GROUP BY no_bukti,no_terbit
                        ORDER BY no_terbit ASC ";
                    //echo $sql_lunas;die;
        $ql = $this->db->query($sql_lunas);
        $res_l = $ql->result_array();
        foreach ($res_l as $k => $v) {
            if($v['sisa'] > 0){
                $no_bukti[] = $v['no_bukti'];
                $kd_nasabah[] = $v['kode_nasabah'];
                $sisa[] = $v['sisa'];
            }
        }

        return $kd_nasabah;
    }
    function get_sisaHutang($periode) {
        $kode_spk = $this->session->userdata('kode_entity');

        $this->db->query('SET @ter := 0; SET @lun := 0; SET @sis := 0;');
        $sql = "SELECT sh.* FROM (";
        $sql .= "SELECT tanggal, kode_nasabah, @ter:= SUM(IF( dk = f_cek_os_penerbitan(kode_coa), rupiah, 0 ))AS penerbitan,
                    @lun:= SUM(IF( dk = f_cek_os_pelunasan(kode_coa), rupiah, 0 ))AS pelunasan,
                    @sis:= SUM(IF( dk = f_cek_os_penerbitan(kode_coa), rupiah, 0 )) - SUM(IF( dk = f_cek_os_pelunasan(kode_coa), rupiah, 0 )) AS sisa,
                    (CASE
                        WHEN SUM(IF( dk = f_cek_os_penerbitan(kode_coa), rupiah, 0 )) - SUM(IF( dk = f_cek_os_pelunasan(kode_coa), rupiah, 0 ))= 0 THEN
                            no_terbit
                        ELSE
                            0
                        END )AS noterbit
                FROM tr_accounting
                INNER JOIN mst_nasabah_konstruksi mn ON mn.kode = tr_accounting.kode_nasabah
                WHERE kode_spk = '$kode_spk' AND tanggal <= LAST_DAY('$periode') AND  kode_coa = (select kode_coa from mst_setting_os where kode_menu='rpt-opensystem-pemasok')  
                GROUP BY kode_nasabah ";
        $sql .= "WHERE  sh.noterbit>0";

        //echo $sql;die;
        $query = $this->db->query($sql);
        $res = $query->result_array();

        return $res;
    }
    
    function gen_utang_rincipemasok($modul,$periode,$kd_nasabah){
        list($bln, $thn) = explode('-', $periode);
        $periode =  $thn.'-'.sprintf('%02d',$bln).'-01';
        $periode_sebelum = $thn.'-'.sprintf('%02d',$bln-1).'-01';
        $kode_spk = $this->session->userdata('kode_entity');
        $not_in_noterbit = $this->get_sisaHutang($periode_sebelum);

        $kode_spk = $this->session->userdata('kode_entity');
        $noterbit = array();

        foreach($not_in_noterbit as $k => $v){
            if(!$v['noterbit']==0){
                $noterbit[] = $v['noterbit'];
            }
        }
        if(count($noterbit)>0){
            $no_ter = " AND no_terbit NOT IN('".implode("','", $noterbit)."')";
        }else{
            $no_ter = "";
        }

        $sql_hn = " SELECT nt.* FROM (
                        SELECT  no_terbit, kode_coa, MAX(tanggal) as tanggal, '' as no_bukti, 'SISA' as keterangan, kode_nasabah, '' as nama_nasabah, '' as dk, 
                             SUM(IF( dk = f_cek_os_penerbitan(kode_coa), rupiah, 0 ))AS penerbitan, 
                             SUM(IF( dk = f_cek_os_pelunasan(kode_coa), rupiah, 0 ))AS pelunasan, 
                                (SUM(IF( dk = f_cek_os_penerbitan(kode_coa), rupiah, 0 )) - SUM(IF( dk = f_cek_os_pelunasan(kode_coa), rupiah, 0 )) )as sisa,
                             datediff( LAST_DAY( DATE_ADD(CURDATE(), INTERVAL - 1 MONTH) ), tanggal )AS umur, 'A2' as label,
                             IF ( (SUM(IF( dk = f_cek_os_penerbitan(kode_coa), rupiah, 0 )) - SUM(IF( dk = f_cek_os_pelunasan(kode_coa), rupiah, 0 )) ) = 0 , no_terbit,Null) as closed,
                             IF ( MAX(tanggal) <= LAST_DAY('$periode_sebelum'),no_terbit,Null) as closed2
                    FROM tr_accounting
                        INNER JOIN mst_nasabah_konstruksi mn ON mn.kode = tr_accounting.kode_nasabah
                        WHERE tanggal <= LAST_DAY('$periode') AND kode_coa = (select kode_coa from mst_setting_os where kode_menu='rpt-opensystem-subkon')  AND kode_spk='$kode_spk'
                        GROUP BY kode_nasabah,no_terbit ) AS nt";
   
        $q = $this->db->query($sql_hn);
        $res = $q->result_array();
        $hn_terbit = array();
        foreach($res as $k => $v){
            
            $closed1 = $v['closed'];
            $closed2 = $v['closed2'];
            if($closed1 != Null && $closed2 != Null){
                $hn_terbit[] = $closed1;
            }
            
        }
        if(count($hn_terbit)>0){
            $terbit_hide = " AND no_terbit NOT IN('".implode("','",$hn_terbit)."')";
        }else{
            $terbit_hide = " ";
        }

    //print_r('<pre>'.$sql_hn.'</pre>');


        $sql = "SELECT no_terbit, kode_coa, tanggal, no_bukti, keterangan, kode_nasabah, nama as nama_nasabah, dk, 
                         IF( dk = f_cek_os_penerbitan(kode_coa), rupiah, 0 )AS penerbitan, 
                         IF( dk = f_cek_os_pelunasan(kode_coa), rupiah, 0 )AS pelunasan, 
                         ( IF( dk = f_cek_os_penerbitan(kode_coa), rupiah, 0 ) - IF( dk = f_cek_os_pelunasan(kode_coa), rupiah, 0 ) ) as sisa,
                         datediff(
                                LAST_DAY('$periode'),
                                tanggal
                        ) AS umur, 'A1' as label
                FROM tr_accounting
                INNER JOIN mst_nasabah_konstruksi mn ON mn.kode = tr_accounting.kode_nasabah
                WHERE tanggal <= LAST_DAY('$periode') $terbit_hide  AND kode_coa = (select kode_coa from mst_setting_os where kode_menu='rpt-opensystem-$modul')  AND kode_spk = '$kode_spk' 
               UNION
                SELECT nt.* FROM (
                    SELECT  no_terbit, kode_coa, '' as tanggal, '' as no_bukti, 'SISA' as keterangan, kode_nasabah, '' as nama_nasabah, '' as dk, 
                            '' as penerbitan,
                        '' as pelunasan,
                            (SUM(IF( dk = f_cek_os_penerbitan(kode_coa), rupiah, 0 )) - SUM(IF( dk = f_cek_os_pelunasan(kode_coa), rupiah, 0 )) )as sisa,
                         datediff( LAST_DAY('$periode'), tanggal )AS umur, 'A2' as label
                    FROM tr_accounting
                    INNER JOIN mst_nasabah_konstruksi mn ON mn.kode = tr_accounting.kode_nasabah
                    WHERE tanggal <= LAST_DAY('$periode') $terbit_hide AND kode_coa = (select kode_coa from mst_setting_os where kode_menu='rpt-opensystem-$modul')  
                    GROUP BY kode_nasabah,no_terbit ) AS nt
                UNION 
                SELECT tt.* FROM (
                    SELECT  '' as no_terbit, kode_coa, '' as tanggal, '' as no_bukti, concat('SISA PERNASABAH: ',kode_nasabah,' - ', mn.nama) as keterangan, kode_nasabah, mn.nama as nama_nasabah, '' as dk, 
                     '' as penerbitan,
                       '' as pelunasan,
                         (SUM(IF( dk = f_cek_os_penerbitan(kode_coa), rupiah, 0 )) - SUM(IF( dk = f_cek_os_pelunasan(kode_coa), rupiah, 0 )) )as sisa,
                         '' AS umur, 'B' as label
                    FROM tr_accounting
                    INNER JOIN mst_nasabah_konstruksi mn ON mn.kode = tr_accounting.kode_nasabah
                    WHERE tanggal <= LAST_DAY('$periode') $terbit_hide AND kode_coa = (select kode_coa from mst_setting_os where kode_menu='rpt-opensystem-$modul')  
                    GROUP BY kode_nasabah ) AS tt /* */
                ORDER BY kode_nasabah, no_terbit DESC, label ASC";
//die('<pre>'.$sql.'</pre>');
        $query  = $this->db->query($sql);
        $res    = $query->result_array(); 
        $numrow = $query->num_rows(); 

        return $res; 
    }

    function getMenuTitle($kode){
        $sql = "SELECT judul_halaman 
                FROM mst_menu where kode like '%$kode'";
        $query = $this->db->query($sql);
        $res = $query->row_array();

        return $res;
    }

    function getData_BankInOut(){

    }

    function query_jurnal() {

        $data['idmenu']         = 'accounting-jurnal-query';
        $data['content']        = '../../tr_accounting/views/query_jurnal';
        $data['js']             = '../../tr_accounting/views/query_jurnal_js2'; 

        $this->buildView($data);
    }
    
    function queryjurnal() {
        $fld = json_decode($_POST['fld']);
        $opt = json_decode($_POST['opt']);
        $src_key = json_decode($_POST['src_key']);
        $ordfld = json_decode($_POST['ordfld']);
        $ordopt = json_decode($_POST['ordopt']);
        
        //where clausa
        $dimana="";
        $totdimana=count($fld);
        $no=0;
        foreach ($fld as $index => $fielda) {
            $no++;
            if($opt[$index]=="%LIKE"){
                $dimana.=" ".$fielda." LIKE '%".$src_key[$index]."' ";
            }elseif($opt[$index]=="LIKE%"){
                $dimana.=" ".$fielda." LIKE '".$src_key[$index]."%' ";  
            }elseif($opt[$index]=="%LIKE%"){
                $dimana.=" ".$fielda." LIKE '%".$src_key[$index]."%' "; 
            }elseif($opt[$index]=="IN"){
                $dimana.=" ".$fielda." IN (".$src_key[$index].") "; 
            }else{
                $dimana.=" ".$fielda." ".$opt[$index]." '".$src_key[$index]."' ";   
            } 
            
            if($no<$totdimana){
                $dimana.=" AND ";
            }
        }
        //$dimana;
        
        //order by
        $berdasarkan="";
        $totberdasarkan=count($ordfld);
        $no=0;$nopasti=0;
        //Ambil data yang pasti terisi
        foreach ($ordfld as $orindex => $ordfield) {
            if($ordfield!=""){
                $nopasti++;
            } 
        }
        
        foreach ($ordfld as $orindex => $ordfield) {
            
            
            if($ordfield!=""){
                $staord="ok";
                $no++;
                if($no==1){
                    $berdasarkan.=" ORDER BY ";
                }
                
                $berdasarkan.=" ".$ordfield." ".$ordopt[$orindex];
                
                if(($no<$nopasti)){
                    $berdasarkan.=", ";
                }
            }
            
        } 
        $quuery=$dimana.$berdasarkan;
         $this->load->database();
         $sqole="SELECT no_bukti, date_format(tanggal, '%d-%m-%Y') AS tanggal, kode_coa, kode_customer as kode_nasabah, kode_nasabah as kode_customer, kode_sumberdaya,
                kode_spk, kode_tahap, no_invoice, kode_faktur, format(volume, 2) AS volume,
                format(CASE WHEN dk = 'D' THEN rupiah ELSE 0 END, 2) AS debet, format(CASE WHEN dk = 'K' THEN rupiah ELSE 0 END, 2) AS kredit,
                keterangan, FALSE FROM tr_accounting WHERE ".$quuery;
         $query = $this->db->query($sqole);
         foreach ($query->result() as $row)
            {
                echo "<tr>";
                echo "<td>".$row->no_bukti.'</td>'; 
                echo "<td>".$row->tanggal.'</td>'; 
                echo "<td>".$row->kode_coa.'</td>'; 
                echo "<td>".$row->kode_nasabah.'</td>'; 
                echo "<td>".$row->kode_customer.'</td>'; 
                echo "<td>".$row->kode_sumberdaya.'</td>'; 
                echo "<td>".$row->kode_spk.'</td>'; 
                echo "<td>".$row->kode_tahap.'</td>'; 
                echo "<td>".$row->no_invoice.'</td>'; 
                echo "<td>".$row->kode_faktur.'</td>'; 
                echo "<td>".$row->volume.'</td>'; 
                echo "<td>".$row->debet.'</td>'; 
                echo "<td>".$row->kredit.'</td>'; 
                echo "<td>".$row->keterangan.'</td>'; 
                echo "</tr>";
            } 
    }
    

    function getViewDataCari($limit, $start, $pencarian, $is_adv, $is_periode_on) {
        //var_dump($pencarian);die;
        $this->db->select('*');
        //$this->db->from('tr_accounting');
        //var_dump($pencarian);
        
        $sql = 'SELECT no_bukti, tanggal, jenis, no_invoice, kode_coa, kode_nasabah, kode_customer, 
                       kode_sumberdaya, kode_spk, kode_tahap, kode_faktur, kode_alat, volume, dk, 
                       rupiah, keterangan, tr_level  
                FROM tr_accounting
                WHERE no_bukti IS NOT NULL ';
        
        if (!empty($pencarian)) {
            if ($is_adv==1) {
                foreach($pencarian as $k => $v){
                    $ar = $k.' '.$v['field'].','.$v['nilai'].','.$v['kondisi'];
                    //echo $is_adv.' '.$v['kondisi']."<<<<";
                    if( $v['kondisi']=='like_before'){
                        $this->db->like($v['field'],$v['nilai'],'before');
                        $sql.=" AND ".$v['field']." LIKE '%".$v['nilai']."' ";
                    }elseif( $v['kondisi']=='like_after'){
                        $this->db->like($v['field'],$v['nilai'],'after');
                        $sql.=" AND ".$v['field']." LIKE '".$v['nilai']."%' ";
                    }elseif( $v['kondisi']=='like_both'){
                        $this->db->like($v['field'],$v['nilai'],'both');
                        $sql.=" AND ".$v['field']." LIKE '%".$v['nilai']."%' ";
                    }elseif( $v['kondisi']=='like_match'){
                        $this->db->like($v['field'],$v['nilai'],'match');
                        $sql.=" AND ".$v['field']." = '".$v['nilai']."' ";
                    }else{
                        if( $v['field']=='rp_debit'){
                            $this->db->where(array('dk'=>'D'));
                            $this->db->where('rupiah '.$v['kondisi'],$v['nilai']);
                            $sql.=" AND DK='D'";
                            $sql.=" AND rupiah ".$v['kondisi']." ".$v['nilai']." ";
                        }elseif( $v['field']=='rp_kredit'){
                            $this->db->where(array('dk'=>'K'));
                            $this->db->where('rupiah '.$v['kondisi'],$v['nilai']);
                            $sql.=" AND DK='K'";
                            $sql.=" AND rupiah ".$v['kondisi']." ".$v['nilai']." ";
                        }else{
                            $this->db->where($v['field'].' '.$v['kondisi'],$v['nilai']);
                            $sql.=" AND rupiah ".$v['kondisi']." ".$v['nilai']." ";
                        }
                    }
                    if($is_periode_on==1){
                        $this->db->like('tanggal',$v['periode'],'after');
                        $sql.=" AND tanggal LIKE '".$v['periode']."%' ";
                    }
                }
                //die;
            }else{
                    $this->db->like($pencarian, 'both');
                    $sql.=" AND no_bukti LKE '%".$pencarian['no_bukti']."%' ";
                //}
            }
            //$this->db->like('no_bukti', $pencarian);
            //$this->db->like($pencarian,'both');

        }
        $sql.=' ORDER BY no_bukti ASC, tanggal ASC ';
        $lim = !empty($limit)?$limit:0;
        $str = !empty($start)?$start:'';
        $kom = !empty($start)?',':'';
        $sql = $sql.'LIMIT '.$lim.$kom.$str;
//echo $sql."<br>";die;
//$query = $this->db->query($sql);
//$res = $query->result_array();
//return $res;
//var_dump($res);die;

        $this->db->order_by('no_bukti','asc');
        $this->db->order_by('tanggal','asc');
        $this->db->limit($limit, $start);
        $q = $this->db->get('tr_accounting');//'', $limit, $start);
       // var_dump($q);
        $data = array();
      // echo $q->num_rows();
        $dbg = array('QUERY_MODEL'=>$this->db->last_query());
        //print_r($dbg);
        //echo $q->num_rows();
        //$data['page_count'] =$this->getViewCountDataCari($pencarian, $is_adv, $is_periode_on);

        $data = $q->result_array();
        //var_dump($data);
        if ($q->num_rows() > 0){
            return $data;
        }else{
            return null;
        }
    }
    function user_limit($limit, $start = 0) {
        $this->db->order_by('no_bukti','asc');
        $this->db->order_by('tanggal','asc');
        $this->db->limit($limit, $start);
        return $this->db->get('tr_accounting');
    }
    function getViewCountDataCari($pencarian, $is_adv, $is_periode_on) {
        
        $this->db->select('count(no_bukti) as JUMROW');
        $this->db->from('tr_accounting');

        $sql = 'SELECT count(no_bukti) as JUMROW
                FROM tr_accounting
                WHERE no_bukti IS NOT NULL ';
        
        if (!empty($pencarian)) {
            if ($is_adv==1) {
                foreach($pencarian as $k => $v){
                    $ar = $k.' '.$v['field'].','.$v['nilai'].','.$v['kondisi'];
                    //echo $is_adv.' '.$v['kondisi']."<<<<";
                    if( $v['kondisi']=='like_before'){
                        $this->db->like($v['field'],$v['nilai'],'before');
                        $sql.=" AND ".$v['field']." LIKE '%".$v['nilai']."' ";
                    }elseif( $v['kondisi']=='like_after'){
                        $this->db->like($v['field'],$v['nilai'],'after');
                        $sql.=" AND ".$v['field']." LIKE '".$v['nilai']."%' ";
                    }elseif( $v['kondisi']=='like_both'){
                        $this->db->like($v['field'],$v['nilai'],'both');
                        $sql.=" AND ".$v['field']." LIKE '%".$v['nilai']."%' ";
                    }elseif( $v['kondisi']=='like_match'){
                        $this->db->like($v['field'],$v['nilai'],'match');
                        $sql.=" AND ".$v['field']." = '".$v['nilai']."' ";
                    }else{
                        if( $v['field']=='rp_debit'){
                            $this->db->where(array('dk'=>'D'));
                            $this->db->where('rupiah '.$v['kondisi'],$v['nilai']);
                            $sql.=" AND DK='D'";
                            $sql.=" AND rupiah ".$v['kondisi']." ".$v['nilai']." ";
                        }elseif( $v['field']=='rp_kredit'){
                            $this->db->where(array('dk'=>'K'));
                            $this->db->where('rupiah '.$v['kondisi'],$v['nilai']);
                            $sql.=" AND DK='K'";
                            $sql.=" AND rupiah ".$v['kondisi']." ".$v['nilai']." ";
                        }else{
                            $this->db->where($v['field'].' '.$v['kondisi'],$v['nilai']);
                            $sql.=" AND rupiah ".$v['kondisi']." ".$v['nilai']." ";
                        }
                    }
                    if($is_periode_on==1){
                        $this->db->like('tanggal',$v['periode'],'after');
                        $sql.=" AND tanggal LIKE '".$v['periode']."%' ";
                    }
                    
                }
                //die;
            }else{
                    $this->db->like($pencarian, 'both');
                    $sql.=" AND no_bukti LKE '%".$pencarian['no_bukti']."%' ";
                //}
            }
            //$this->db->like('no_bukti', $pencarian);
            //$this->db->like($pencarian,'both');

        }
        $sql.=' ORDER BY no_bukti ASC, tanggal ASC ';
        //echo $sql;
        //$q = $this->db->query($sql);
        $q = $this->db->get();
        //$data = $q->row_array();//$this->db->count_all_results();
        

        if ($q->num_rows() > 0){
            foreach ($q->result() as $row)
            {
                $data = $row->JUMROW;
            }
            return (int)$data;
        }else{
            return null;
        }

    }

    function gen_rpt_rk($periode,$kdspk){
        $periode =  $thn.'-'.sprintf('%02d',$bln).'-01';
        $data = array();

        $sql_spk = "    SELECT kode_spk, tr_level 
                        FROM tr_accounting 
                        WHERE kode_coa = '21711'
                        GROUP BY kode_spk";
        $qspk = $this->db->query($sql_spk);
        $data['res_spk'] = $qspk->result_array();

        //var_dump($data['res_spk'][0]['kode_spk']);die;
        $kdspk = $data['res_spk'][0]['kode_spk'];
        
        $sql = "  SELECT 
        tanggal, acc.kode_spk, acc.no_bukti, keterangan, acc.tr_level, acc.dk, 
        IFNULL(SUM( 
          CASE 
          WHEN acc.dk = 'D'
          AND acc.tr_level = 'DEPARTEMEN' THEN 
            rupiah 
          ELSE 
            CASE 
          WHEN acc.dk = 'K' 
          AND acc.tr_level = 'DEPARTEMEN' THEN 
            (rupiah *- 1) 
          END 
          END 
        ),0) AS rp_dept, 

        IFNULL(SUM( 
          CASE 
          WHEN acc.dk = 'D' 
          AND acc.tr_level = 'PROYEK' THEN 
            rupiah 
          ELSE 
            CASE 
          WHEN acc.dk = 'K' 
          AND acc.tr_level = 'PROYEK' THEN 
            (rupiah *- 1) 
          END 
          END 
        ),0) AS rp_pro

      FROM 
        ( 
          SELECT 
            acc.* 
          FROM 
            ( 
              SELECT 
                CASE 
              WHEN no_terbit = no_bukti THEN 
                1 
              ELSE 
                0 
              END AS is_terbit, 
              tanggal, 
              kode_coa, 
              kode_spk, 
              no_bukti, 
              no_terbit, 
              dk, 
              rupiah, 
              keterangan, 
              tr_level 
            FROM 
              tr_accounting 
            WHERE 
              tanggal <= '2015-12-31' AND
              kode_divisi = 'V' AND 
              no_terbit <> '' 
            ) AS acc 
          WHERE 
            acc.kode_coa = '21711' 
        ) acc 
      GROUP BY 
        acc.kode_spk, no_bukti
      HAVING 
        (rp_dept + rp_pro) <> 0; ";
                    //echo $sql;die;
        $ql = $this->db->query($sql);
        $data = $ql->result_array();
        foreach ($data as $k => $v) {
            //if($v['sisa'] > 0){
                $data['kd_spk'] = $v['no_bukti'];
                $data['tanggal'] = $v['tanggal'];
                $data['no_bukti'] = $v['no_bukti'];
                $data['uraian'] = $v['keterangan'];
                $data['dk'] = $v['dk'];
                $data['rupiah'] = $v['rupiah'];
            //}
        }
        $data['kod_spk'] = $kdspk;
        //var_dump($data);die;
        return $data;
    }

    function _getLastNoBukti(){

        $spk = $this->session->userdata('kode_entity');
        $sql = "SELECT MAX(no_bukti) as nobuk
                FROM tr_accounting 
                WHERE 
                    Month(tanggal) = 4 AND 
                    Year(tanggal) = 2016 AND
                    kode_spk='$spk' ";
       // print_r('<pre>'.$sql.'</pre>');
        $q = $this->db->query($sql);

        foreach($q->row_array() as $k => $v){
            $nobuk = $v['nobuk'];
            $last_nobuk = array('last_num'=> $nobuk);
        }
        return $last_num;
    }

    function _doubleEntryNoBukChecking($nobuk){
        $sql = "SELECT max(no_bukti) as no_bukti, posted_by FROM tr_accounting WHERE no_bukti='$nobuk'";
        $q = $this->db->query($sql);

        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                $data = array('msg'=>'Nomor Bukti '.$nobuk.' sudah diinput oleh '.$row->posted_by, 'nobuk'=>$nobuk);
            }
        }else{
            $data = array('msg'=>'QC_PASSED', 'nobuk'=>$nobuk);
        }

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    function _get_listnobuk($jenis='A',$periode){
        $periode = $periode.'-01';

        if($jenis=='M'){
            $s_nobuk = "AND no_bukti LIKE '%M%' ";
        }elseif ($jenis=='A'){
            $s_nobuk = " ";
        }else{
            $s_nobuk = "AND (no_bukti LIKE '%B%' OR no_bukti LIKE '%K%') ";
        }
        $sql = "SELECT DISTINCT 
                    SUBSTRING(no_bukti, 1 ,6)AS no_bukti,
                    SUBSTRING(no_bukti, -4 ,1)AS jenis
                FROM tr_accounting
                WHERE 
                    MONTH(tanggal) = MONTH('$periode') AND 
                    YEAR(tanggal) = YEAR('$periode')  
                    $s_nobuk
                ORDER BY no_bukti ASC, tanggal ASC";
        //echo $sql;
        $q = $this->db->query($sql);
        $result = $q->result_array();
        $num = $q->num_rows();
        $no_bk = array();
        
            foreach($result as $k => $v){
                for($i=1;$i<281102;$i++){
                    echo sprintf('28%04d',$i).', '.$v['no_bukti'].'<br>';
                }
            }
        //var_dump($result);
        die;

        $sqlmax = " SELECT max(no_bukti) as MAX_NOBUK
                    FROM tr_accounting
                    WHERE 
                        MONTH(tanggal) = MONTH('$periode') AND 
                        YEAR(tanggal) = YEAR('$periode')  
                        $s_nobuk
                    ORDER BY no_bukti DESC, tanggal DESC";
        $qmax = $this->db->query($sqlmax);
        
        foreach($qmax->row_array() as $row => $v){
            $max_number = explode('/', $v);
            $res_max = $max_number[0];
        }
        $nmax = $res_max;

        //$endnobuk = $this->lastNoBuk();
        $res = array();
        foreach($q->result_array() as $row => $v){
            $maxnumber = explode('/', $v['no_bukti']);
            
            //$res[] = array($max_number[0],'ada', $nmax );
            $res[] = array('nomor'=>$maxnumber[0], 'max'=>$nmax );
            //$i++;
        }
        //die(var_dump($res));
        return $res;

    }
    
}