<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tr_tools_model extends CI_Model {
	
    function __construct() {
        //$this->traccTable = 'tr_accounting';
    }

    function _getListUnsedNoBuk(){
        $sql = "SELECT max(no_bukti) as MAX_NOBUK
                FROM tr_accounting
                WHERE MONTH(tanggal) = MONTH(DATE(now())) AND YEAR(tanggal) = YEAR(DATE(now()))
                ORDER BY no_bukti DESC, tanggal DESC";
        $q = $this->db->query($sql);
        $res = array();
        foreach($q->result() as $row){
            $max_number = explode('/', $row->MAX_NOBUK);
            $res = array('max_number'=>$max_number[0]);
        }
        return $res;

    }

    function lastNoBuk(){
        $sql = "SELECT max(no_bukti) as MAX_NOBUK
                FROM tr_accounting
                WHERE MONTH(tanggal) = MONTH(DATE(now())) AND YEAR(tanggal) = YEAR(DATE(now()))
                ORDER BY no_bukti DESC, tanggal DESC";
        $q = $this->db->query($sql);
        //$res = array();
        
        $res = $q->row_array();
        foreach($res as $row => $v){
            $number = explode('/', $v);
            $no= array($number[0]);
        }
        return $no;
    }

    function _getTotalRecords($jenis='M',$periode){
        if($jenis=='M'){
            $s_nobuk = "AND no_bukti LIKE '%M%' ";
        }elseif ($jenis=='A'){
            $s_nobuk = " ";
        }else{
            $s_nobuk = "AND (no_bukti LIKE '%B%' OR no_bukti LIKE '%K%') ";
        }
        $sql = "SELECT max(no_bukti) as MAX_NOBUK
                    FROM tr_accounting
                    WHERE 
                        MONTH(tanggal) = MONTH(DATE(now())) AND 
                        YEAR(tanggal) = YEAR(DATE(now()))  
                        $s_nobuk
                    ORDER BY no_bukti DESC, tanggal DESC";
        $query = $this->db->query($sql);
        foreach ($query->result() as $row ) {
            $nobuk = explode('/',$row->MAX_NOBUK) ;
            $data[] = (int)$nobuk[0];
        }
        return $data ;
    }
    function _getListNoBuk($jenis='M',$periode){
        $spk = $this->session->userdata('kode_entity');
        if($jenis=='M'){
            $s_nobuk = "AND no_bukti LIKE '%M%' ";
        }elseif ($jenis=='A'){
            $s_nobuk = " ";
        }else{
            $s_nobuk = "AND (no_bukti LIKE '%B%' OR no_bukti LIKE '%K%') ";
        }
        $sql = "SELECT no_bukti
                FROM tr_accounting
                WHERE 
                    MONTH(tanggal) = MONTH('$periode') AND 
                    YEAR(tanggal) = YEAR('$periode')  
                    $s_nobuk
                    AND kode_spk='$spk'
                GROUP BY no_bukti
                ORDER BY no_bukti ASC";
        $q = $this->db->query($sql);


       // echo '<pre>'.$sql.'</pre>';

        $sql_minmax = " SELECT
                            min(a.no_bukti)AS MIN_NOBUK,
                            max(a.no_bukti)AS MAX_NOBUK,
                            b.kode_trjurnal
                        FROM
                            tr_accounting a
                        INNER JOIN mst_entity b on b.kode = a.kode_spk
                        WHERE
                            MONTH(a.tanggal)= MONTH('$periode')
                        AND YEAR(a.tanggal)= YEAR('$periode')
                        $s_nobuk 
                        AND a.kode_spk='$spk'
                        ";
        $qmax = $this->db->query($sql_minmax);
        //echo $sql_minmax;
        foreach($qmax->result_array() as $row => $v){
            //var_dump($v['MAX_NOBUK']);die;
            $min_number = explode('/', $v['MIN_NOBUK']);
            $max_number = explode('/', $v['MAX_NOBUK']);
            $res_min = $min_number[0];
            $res_max = $max_number[0];
            $kd_trjurnal = $v['kode_trjurnal'];
        }
        $nmin = $res_min;
        $nmax = $res_max;

        //$endnobuk = $this->lastNoBuk();
        $res = array();
        foreach($q->result_array() as $row => $v){
            $real_number = explode('/', $v['no_bukti']);
            $numr[] =$real_number[0];
            //$maxnumber = explode('/', $v['no_bukti']);
            
            //$res[] = array($max_number[0],'ada', $nmax );

            //$i++;
        }
        //var_dump($numr[1]);die;
        
        for($i=0;$i<1000;$i++){
            //echo $numr[$i];
                //$res[]= array('num'=>$real_number[0],'nmin'=>$nmin, 'nmax'=>$nmax, 'kd_trj'=>$kd_trjurnal );
                $nomor = explode(',',sprintf('28%04d',($i+1) ));
                $n_nomor = explode(',',sprintf('%04d',($i+1) ));
                if($nomor[0]===$numr[$i]){
                   //echo ($i+1).',  '.$nomor[0].'--used--'.$numr[($i)].'<br>';
                   $res[] = array('nomor'=>$nomor[0],'status'=>'Used');
                }else{
                    //echo ($i+1).',  '.$nomor[0].'<br>';
                    $res[] = array('nomor'=>$nomor[0],'status'=>'Unused');
                }
            }
            
        $sqlt = "SELECT DISTINCT tanggal, nomor, nobuk, no_bukti, kode_spk, tr_level, label
                FROM
                 (
                   SELECT '' as tanggal, a.nomor, '' as nobuk, '' as no_bukti, '' as kode_spk, '' as tr_level, 'A' as label
                   FROM tmpl_nomor_bukti a
                   UNION ALL
                   SELECT tanggal, '' as nomor, SUBSTRING(b.no_bukti, 3,4) as nobuk, no_bukti, kode_spk, tr_level, 'B' as label
                   FROM tr_accounting b
                        WHERE b.kode_spk = '5WGA05' AND b.tr_level = 'PROYEK' AND no_bukti LIKE '%M%' AND (YEAR(tanggal) = YEAR('2016-01-01') AND MONTH(tanggal)= MONTH('2016-03-01'))

                )  t
                ORDER BY label, nomor ASC";
        $q = $this->db->query($sqlt);
        $res1 = $q->result_array($q);
        $data = array();
        $iLabel=0;
        $requestData= $_REQUEST;
        $totalData = $q->num_rows();
        $totalFiltered = $totalData; 

        $label = array();
        foreach($res1 as $row => $v){
            $i++;
            //$data[$iLabel] = array('nomor'=>$v['nomor'],'no_bukti'=>$v['no_bukti']);
            $iLoop = 0;
            /*
            $data[$v['tower_cluster']][$v['lantai_blok']][$iLoop]['no_unit'] = $v['no_unit'];
            $data[$v['tower_cluster']][$v['lantai_blok']][$iLoop]['xno_unit'] = $v['xno_unit'];
            $data[$v['tower_cluster']][$v['lantai_blok']][$iLoop]['ishold'] = $v['ishold'];
            $data[$v['tower_cluster']][$v['lantai_blok']][$iLoop]['status_tr'] = $v['status_tr'];
            */
            /*$data[$v['label']][$v['nomor']][$iLoop]['label'] = $v['label'];
            $data[$v['label']][$v['nomor']][$iLoop]['nomor_a'] = $v['nomor'];
            $data[$v['label']][$v['nomor']][$iLoop]['nomor_b'] = $v['nobuk'];
            $data[$v['label']][$v['nomor']][$iLoop]['nomor_bukti'] = $v['no_bukti'];
            $iLoop++;
            */

            $nestedData1=array(); 
            $nestedData2=array();
            if($v['label']==='A'){
            $nestedData1[] = $v['label'];
            $nestedData1[] = $v['nomor'];
            $nestedData1[] = $v['nobuk'];
            $nestedData1[] = $v['no_bukti'];
            }
            if($v['label']==='B'){
            $nestedData2[] = $v['label'];
            $nestedData2[] = $v['nomor'];
            $nestedData2[] = $v['nobuk'];
            $nestedData2[] = $v['no_bukti'];
            }

            $data[] = [$nestedData1,$nestedData2];
        }
        $json_data = array(
            "draw"            => intval( $requestData['draw'] ),   
            "recordsTotal"    => intval( $totalData ),  // total number of records
            "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data"            => $data   // total data array
            );

//echo json_encode($json_data);
//die;
        return $res;

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
        if($kbm == 'M') {
            $like_kbm = " no_bukti LIKE '%M%' AND ";
        }else{
            $like_kbm = " ( no_bukti LIKE '%B%' OR no_bukti LIKE '%K%' ) AND ";
        }
        	$sql = "SELECT 
                        SUBSTRING(MAX( no_bukti ),1,6)as last_num 
                    FROM tr_accounting
                    WHERE 
                        kode_spk = '$spk' AND 
                        $like_kbm 
                        ( 
                            MONTH(tanggal) = MONTH(DATE(now())) OR YEAR(tanggal)=YEAR(DATE(now()))
                        )";
                    //AND (MONTH(tanggal) = MONTH('$periode') AND YEAR(tanggal)=YEAR('$periode'))"; 

        //echo $sql;die;
        $q = $this->db->query($sql);

        $res = array();
        foreach($q->result() as $row){
            $res = array('last_num'=>$row->last_num);//array('b_kas'=>$row->b_kas, 'b_bank'=>$row->b_bank, 'b_memo'=>$row->b_memo, 'kbm'=>$kbm);
        }
        return $res;
    }

     function _lookupCommon($jenis,$kode){
        if($jenis=='M'){
        	$sql = "SELECT coa.kode, coa.nama 
        			FROM tr_coa_common tcc 
        			INNER JOIN mst_coa coa ON coa.kode=tcc.kode_coa 
        			WHERE tcc.jenis_trx='M' AND coa.kode LIKE '%$kode%'
        			ORDER BY tcc.kode_coa ASC";

            //$this->db->select('kode,nama,mand_tahap,mand_sbd,mand_nasabah,mand_pajak,mand_bank')->from('mst_coa');
            //$this->db->like('kode',$jenis,'after');
            //$this->db->or_like('nama',$jenis,'both');  
        }else{
        	$sql = "SELECT coa.kode, coa.nama 
        			FROM tr_coa_common tcc 
        			INNER JOIN mst_coa coa ON coa.kode=tcc.kode_coa 
        			WHERE tcc.jenis_trx='K' OR tcc.jenis_trx='B' AND coa.kode LIKE '%$kode%'
        			ORDER BY tcc.kode_coa ASC";
        }
        //echo $sql;
        $query = $this->db->query($sql);
 
        return $query->result();
    }

}