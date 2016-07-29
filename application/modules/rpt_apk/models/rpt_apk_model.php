<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class rpt_apk_model extends CI_Model {
	
    function __construct() {
        $this->t_accounting = 'tr_accounting';
    }


    function _generateIkhtisar($modul,$periode)
    {
        list($bln, $thn) = explode('-', $periode);
        $periode =  $thn.'-'.sprintf('%02d',$bln).'-01';
        $periode_sebelum = $thn.'-'.sprintf('%02d',$bln-1).'-01';
        $kd_spk = $this->session->userdata('kode_entity');

        $sql = "SELECT kode_sumberdaya, nama as nama_sumberdaya, kode_coa,
                     sum(IF( dk = f_cek_os_penerbitan(kode_coa), volume, 0 ) )AS vol_masuk, 
                     sum(IF( dk = f_cek_os_penerbitan(kode_coa), rupiah, 0 ) )AS harga_masuk, 
                     sum(IF( dk = f_cek_os_pelunasan(kode_coa), volume, 0 ) )AS vol_keluar, 
                     sum(IF( dk = f_cek_os_pelunasan(kode_coa), rupiah, 0 ) )AS harga_keluar, 
                     sum( IF( dk = f_cek_os_penerbitan(kode_coa), volume, 0 ) - IF( dk = f_cek_os_pelunasan(kode_coa), volume, 0 ) ) as volume_sisa,
                     sum( IF( dk = f_cek_os_penerbitan(kode_coa), rupiah, 0 ) - IF( dk = f_cek_os_pelunasan(kode_coa), rupiah, 0 ) ) as harga_sisa,
                     sum( IF( dk = f_cek_os_penerbitan(kode_coa), rupiah, 0 ) - IF( dk = f_cek_os_pelunasan(kode_coa), rupiah, 0 ) ) /
                     sum( IF( dk = f_cek_os_penerbitan(kode_coa), volume, 0 ) - IF( dk = f_cek_os_pelunasan(kode_coa), volume, 0 ) ) as harga_rata2
                FROM tr_accounting
                INNER JOIN mst_sumberdaya mn ON mn.kode = tr_accounting.kode_sumberdaya
                WHERE tanggal <= LAST_DAY('$periode')  
                        AND kode_coa = (select kode_coa from mst_setting_os where kode_menu='rpt-persediaan-$modul') 
                        AND kode_spk =  '$kd_spk'
                GROUP BY kode_sumberdaya";
        //echo '<pre>'.$sql.'</pre>';
        $query = $this->db->query($sql);
        $hasil = array();
        foreach($query->result() as $row) {
        	$hasil[] = array(
	        			'kode'=>$row->kode_sumberdaya,
	        			'nama'=>$row->nama_sumberdaya,
	        			'coa'=>$row->kode_coa,
	        			'vol_in'=>$row->vol_masuk,
	        			'price_in'=>$row->harga_masuk,
	        			'vol_out'=>$row->vol_keluar,
	        			'price_out'=>$row->harga_keluar,
	        			'vol_sisa'=>$row->volume_sisa,
	        			'price_sisa'=>$row->harga_sisa,
	        			'price_avg'=>$row->harga_rata2
        			);
        }
        //var_dump($hasil);die;
        //header('Content-type: application/json');
        return json_encode( $hasil);
    }

    function getMenuTitle($kode){
        $sql = "SELECT judul_halaman 
                FROM mst_menu where kode like '%$kode'";
        $query = $this->db->query($sql);
        $res = $query->row_array();

        return $res;
    }
}