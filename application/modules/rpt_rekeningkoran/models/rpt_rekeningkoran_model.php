<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class rpt_rekeningkoran_model extends CI_Model {
	
    function __construct() {
        $this->t_acc = 'tr_accounting';
    }


    function get_SPK(){
    	$sql = "SELECT ac.kode_spk, me.nama as nama_entity 
                FROM tr_accounting_test ac 
                LEFT JOIN mst_entity me ON me.kode=ac.kode_spk
                GROUP BY ac.kode_spk
                ORDER BY ac.kode_spk ASC";
    	$query = $this->db->query($sql);
		$res = $query->result_array();

		//$data = array();
		foreach($res as $row => $v){
			$data[] = array('kd_spk'=>$v['kode_spk'],'nama_entity'=>$v['nama_entity']);
		}
//var_dump($data);
		return json_encode($data);
    }

    function menus() {

        $sql = "SELECT 
                    kode_spk, tanggal, no_bukti, 
                    no_terbit, keterangan, dk, rupiah, 
                    tr_level, kode_divisi, 
                    (SELECT sum(if(dk='K',(b.rupiah*-1),b.rupiah)) as rupiah
                    FROM tr_accounting_test b
                    WHERE kode_coa = 21711  
                        AND b.kode_spk = '5WGA05'
                        AND b.no_bukti = t.no_bukti OR b.no_terbit= t.no_bukti
                        AND b.tanggal <= LAST_DAY('2016-04-01') AND b.kode_spk='5WGA05') as sisa
                    FROM tr_accounting_test t 
                    WHERE kode_coa = 21711  
                        AND kode_spk = '5WGA05'
                        AND no_terbit IS NULL
                        AND tanggal <= LAST_DAY('2016-04-01')";
        $q = $this->db->query($sql);
       // echo $sql;
        //var_dump($q);
            /* 
        $this->db->select("kode_spk, tanggal, no_bukti, no_terbit, keterangan, dk, rupiah, tr_level, kode_divisi");
        $this->db->from("tr_accounting_test t");
        $this->db->where(array("kode_spk"=>'5WGA05'));
        $this->db->where('no_terbit IS NULL');
        $q = $this->db->get();
        */

        $final = array();
        $data = array();
        $terbit = $lunas = 0;
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $row) {

                $this->db->select("tanggal, no_bukti, no_terbit, keterangan, dk, rupiah, tr_level, kode_divisi");
                $this->db->from("tr_accounting_test");
                $this->db->where(array("kode_spk"=>'5WGA05', "no_terbit"=> $row->no_bukti));
                $qr = $this->db->get();
                if ($q->num_rows() > 0) {
                    // "kd_spk" => $row->kode_spk, "rupiah" => $row->rupiah,
                    //$rows[] = array( "no_bukti" => array($row->no_bukti => $q->result() ));
                    if($row->sisa > 0){
                        $data[] = array(
                                'kode_spk'  =>$row->kode_spk,  
                                'tanggal'   => $row->tanggal,
                                'no_bukti'  => $row->no_bukti,  
                                'uraian'    => $row->keterangan, 
                                'dk'        => $row->dk, 
                                'rupiah'    => $row->rupiah, 
                                'tr_level'  => $row->tr_level,
                                'child'     => $qr->result() 
                            );
                    }
                }
                //array_push($final, $row);
            }
        }
        return json_encode($data);
    }

    function array2json($arr) { 
        if(function_exists('json_encode')) return json_encode($arr); //Lastest versions of PHP already has this functionality. 
        $parts = array(); 
        $is_list = false; 

        //Find out if the given array is a numerical array 
        $keys = array_keys($arr); 
        $max_length = count($arr)-1; 
        if(($keys[0] == 0) and ($keys[$max_length] == $max_length)) {//See if the first key is 0 and last key is length - 1 
            $is_list = true; 
            for($i=0; $i<count($keys); $i++) { //See if each key correspondes to its position 
                if($i != $keys[$i]) { //A key fails at position check. 
                    $is_list = false; //It is an associative array. 
                    break; 
                } 
            } 
        } 

        foreach($arr as $key=>$value) { 
            if(is_array($value)) { //Custom handling for arrays 
                if($is_list) $parts[] = array2json($value); /* :RECURSION: */ 
                else $parts[] = '"' . $key . '":' . array2json($value); /* :RECURSION: */ 
            } else { 
                $str = ''; 
                if(!$is_list) $str = '"' . $key . '":'; 

                //Custom handling for multiple data types 
                if(is_numeric($value)) $str .= $value; //Numbers 
                elseif($value === false) $str .= 'false'; //The booleans 
                elseif($value === true) $str .= 'true'; 
                else $str .= '"' . addslashes($value) . '"'; //All other things 
                // :TODO: Is there any more datatype we should be in the lookout for? (Object?) 

                $parts[] = $str; 
            } 
        } 
        $json = implode(',',$parts); 
         
        if($is_list) return '[' . $json . ']';//Return numerical JSON 
        return '{' . $json . '}';//Return associative JSON 
    } 
    

}