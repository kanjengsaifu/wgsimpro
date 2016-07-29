<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tr_opensystem_model extends CI_Model {

	function gen_utang_rincipemasok($periode,$kd_nasabah)
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
		//var_dump($kd_nasabah);
		//die;

		//eodcm = End Of Day Current Month
		$sql_lunas = "SELECT tra.no_bukti, 'SUB TOTAL' AS keterangan, tra.kode_nasabah, 
						SUM( IF( tra.dk = f_cek_os_penerbitan(tra.kode_coa), tra.rupiah, 0 ) )AS penerbitan,  
						SUM( IF( tra.dk = f_cek_os_pelunasan(tra.kode_coa), tra.rupiah, 0 ) )AS pelunasan,
						( sum( IF( tra.dk = f_cek_os_penerbitan(tra.kode_coa), tra.rupiah, 0 ) ) - SUM( IF( tra.dk = f_cek_os_pelunasan(tra.kode_coa), tra.rupiah, 0 ) ) ) as sisa, 
						LAST_DAY( DATE_ADD(CURDATE(), INTERVAL - 1 MONTH) )AS eodcm, datediff( LAST_DAY( DATE_ADD(CURDATE(), INTERVAL - 1 MONTH) ), tra.tanggal )AS umur 
					FROM tr_accounting tra 
					INNER JOIN mst_nasabah mn ON mn.kode = tra.kode_nasabah
					WHERE tra.tanggal < '$periode' 
					GROUP BY kode_nasabah 
					ORDER BY keterangan ASC ";
		$ql = $this->db->query($sql_lunas);
		$res_l = $ql->result_array();
		foreach ($res_l as $k => $v) {
			if($v['sisa'] <= 0){
				$no_bukti[] = $v['no_bukti'];
			}
		}
		//print_r($no_bukti);
		//die;

		$nomor_bukti = count($no_bukti)>0?" AND no_bukti NOT IN('".implode("','", $no_bukti)."' ":"";

		$sql2 = "SELECT tra.id,tra.kode_coa, tra.tanggal, tra.no_bukti, tra.keterangan, tra.kode_nasabah, 
						mn.nama AS nama_nasabah, IF( tra.dk = f_cek_os_penerbitan(tra.kode_coa), tra.rupiah, 0 )AS penerbitan, 
						IF( tra.dk = f_cek_os_pelunasan(tra.kode_coa), tra.rupiah, 0 )AS pelunasan, 
						LAST_DAY( DATE_ADD(CURDATE(), INTERVAL - 1 MONTH) )AS eodcm, 
						datediff( LAST_DAY( DATE_ADD(CURDATE(), INTERVAL - 1 MONTH) ), tra.tanggal )AS umur 
				FROM tr_accounting tra 
				INNER JOIN mst_nasabah mn ON mn.kode = tra.kode_nasabah
				WHERE tanggal < '$periode' $nomor_bukti 

				UNION 

				SELECT * FROM ( 
					SELECT tra1.id, '' AS kode_coa, '' AS tanggal, '999999/12/X/99' AS no_bukti, 'SUB TOTAL' AS keterangan, 
							tra1.kode_nasabah, mn1.nama  AS nama_nasabah, 
							SUM( IF( tra1.dk = f_cek_os_penerbitan(tra1.kode_coa), tra1.rupiah, 0 ) )AS penerbitan, 
							SUM( IF( tra1.dk = f_cek_os_pelunasan(tra1.kode_coa), tra1.rupiah, 0 ) )AS pelunasan, 
							LAST_DAY( DATE_ADD(CURDATE(), INTERVAL - 1 MONTH) )AS eodcm, 
							datediff( LAST_DAY( DATE_ADD(CURDATE(), INTERVAL - 1 MONTH) ), tra1.tanggal )AS umur 
					FROM tr_accounting tra1 
					INNER JOIN mst_nasabah mn1 ON mn1.kode = tra1.kode_nasabah
					WHERE tra1.tanggal < '$periode'  $nomor_bukti
					GROUP BY tra1.kode_nasabah 
					ORDER BY tra1.keterangan ASC ) t 
				WHERE  t.tanggal < '$periode' $nomor_bukti
				GROUP BY t.kode_nasabah 
				ORDER BY no_bukti ASC";

		//print($sql2);
		$data = array();
		$query = $this->db->query($sql2);
		$data = $query->result_array();
		foreach ($data as $k => $v) {
			
			//print_r($v);
			//
		}
		//
		//var_dump($data);
		//die;
		return $data;	
	}
}

?>