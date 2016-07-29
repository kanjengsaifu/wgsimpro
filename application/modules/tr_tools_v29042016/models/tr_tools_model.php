<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tr_tools_model extends CI_Model {
	
    function __construct() {
        //$this->traccTable = 'tr_accounting';
    }

    function _updateCoaCommon()
    {
    	$spk = $this->session->userdata('kode_entity');
        $sql = "CALL updateCoaCommon('".$spk."');";
        $this->db->query($sql);

        $sqlcount = "SELECT COUNT(*) as ROWCOUNT FROM tr_coa_common WHERE kode_spk='$spk'";
        //echo $sqlcount;
        $qc = $this->db->query($sqlcount);
        $msg = '';
        //var_dump($qc);die;
        foreach($qc->result() as $row){
            $msg = $row->ROWCOUNT;
        }

        return $msg;
    }

    function _getListNoBuktiWithBlank(){
        $spk = $this->session->userdata('kode_entity');
        $sql = "SELECT 
                        IF(SUBSTR(no_bukti, -4, 1) = 'K', MAX(no_bukti), '') as bk_kas,
                        IF(SUBSTR(no_bukti, -4, 1) = 'B', MAX(no_bukti), '') as bk_bank,
                        IF(SUBSTR(no_bukti, -4, 1) = 'M', MAX(no_bukti), '') as bk_memo
                FROM tr_accounting
                WHERE kode_spk='$spk'
                GROUP BY no_bukti ASC";

        $q = $this->db->query($sql);

        $res = array();
        foreach($q->result() as $row){
            $res = array('bk_kas'=>$row->bk_kas, 'bk_bank'=>$row->bk_bank, 'bk_memo'=>$row->bk_memo);
        }
        return $res;
    }
    function _getLastNoBukti($kbm){

        $spk = $this->session->userdata('kode_entity');
        $sql = '';
        $sql2 = '';
        //if($kbm == 'M') {
        	$sql.= "SELECT 
                        MAX((SELECT MAX(no_bukti) FROM tr_accounting WHERE no_bukti LIKE '%K%') )as b_kas,
                        MAX((SELECT MAX(no_bukti) FROM tr_accounting WHERE no_bukti LIKE '%B%') )as b_bank, 
                        MAX((SELECT MAX(no_bukti) FROM tr_accounting WHERE no_bukti LIKE '%M%') )as b_memo 
                    FROM tr_accounting
                    WHERE kode_spk='$spk' "; 

        //echo $sql;die;
        $q = $this->db->query($sql);

        $res = array();
        foreach($q->result() as $row){
            $res = array('b_kas'=>$row->b_kas, 'b_bank'=>$row->b_bank, 'b_memo'=>$row->b_memo, 'kbm'=>$kbm);
        }
        return $res;
    }

     function _lookupCommon($jenis){
        if($jenis=='M'){
        	$sql = "SELECT coa.kode, coa.nama 
        			FROM tr_coa_common tcc 
        			INNER JOIN mst_coa coa ON coa.kode=tcc.kode_coa 
        			WHERE tcc.jenis_trx='M'
        			ORDER BY tcc.kode_coa ASC";

            //$this->db->select('kode,nama,mand_tahap,mand_sbd,mand_nasabah,mand_pajak,mand_bank')->from('mst_coa');
            //$this->db->like('kode',$jenis,'after');
            //$this->db->or_like('nama',$jenis,'both');  
        }else{
        	$sql = "SELECT coa.kode, coa.nama 
        			FROM tr_coa_common tcc 
        			INNER JOIN mst_coa coa ON coa.kode=tcc.kode_coa 
        			WHERE tcc.jenis_trx='K' OR tcc.jenis_trx='B'
        			ORDER BY tcc.kode_coa ASC";
        }
        //echo $sql;
        $query = $this->db->query($sql);
 
        return $query->result();
    }

}