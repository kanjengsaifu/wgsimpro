<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class rpt_persediaan_model extends CI_Model {
	
    function __construct() {
        $this->tr_accounting= 'tr_accounting';
    }


    function _generateIkhtisar($modul,$periode)
    {
        list($bln, $thn) = explode('-', $periode);
        $periode =  $thn.'-'.sprintf('%02d',$bln).'-01';
        $periode_sa = $thn.'-'.sprintf('%02d',$bln-1).'-01';
        $kd_spk = $this->session->userdata('kode_entity');

         $sql = "SELECT tr.kode_sumberdaya, mn.nama as nama_sumberdaya, tr.kode_coa, 
                        bl.volume as rab_vol,
                        (bl.volume*mhs.harga_satuan) as rab_price,
                        f_apk_saldo_vol(mn.kode,'$periode_sa','$modul','$kd_spk') as sa_vol,
                        f_apk_saldo_price(mn.kode,'$periode_sa','$modul','$kd_spk') as sa_price,
                        f_apk_mutasi_vol_in(mn.kode,'$periode','$modul','$kd_spk') as vol_masuk,
                        f_apk_mutasi_price_in(mn.kode,'$periode','$modul','$kd_spk') as harga_masuk,
                        f_apk_mutasi_vol_out(mn.kode,'$periode','$modul','$kd_spk') as vol_keluar,
                        f_apk_mutasi_price_out(mn.kode,'$periode','$modul','$kd_spk') as harga_keluar, 
                        sum( IF( dk = f_cek_os_penerbitan(tr.kode_coa), tr.volume, 0 ) - IF( dk = f_cek_os_pelunasan(tr.kode_coa), tr.volume, 0 ) ) as volume_sisa,
                        sum( IF( dk = f_cek_os_penerbitan(tr.kode_coa), tr.rupiah, 0 ) - IF( dk = f_cek_os_pelunasan(tr.kode_coa), tr.rupiah, 0 ) ) as harga_sisa,
                        sum( IF( dk = f_cek_os_penerbitan(tr.kode_coa), tr.rupiah, 0 ) - IF( dk = f_cek_os_pelunasan(tr.kode_coa), tr.rupiah, 0 ) ) /
                        sum( IF( dk = f_cek_os_penerbitan(tr.kode_coa), tr.volume, 0 ) - IF( dk = f_cek_os_pelunasan(tr.kode_coa), tr.volume, 0 ) ) as harga_rata2,
                        SUM(f_apk_saldo_vol(mn.kode,'$periode','$modul','$kd_spk') + ( IF( dk = f_cek_os_penerbitan(tr.kode_coa), tr.volume, 0 ) - IF( dk = f_cek_os_pelunasan(tr.kode_coa), tr.volume, 0 ) )) as vol_moving, 
                        SUM(f_apk_saldo_price(mn.kode,'$periode','$modul','$kd_spk') + ( IF( dk = f_cek_os_penerbitan(tr.kode_coa), tr.rupiah, 0 ) - IF( dk = f_cek_os_pelunasan(tr.kode_coa), tr.rupiah, 0 ) )) as price_moving
                FROM tr_accounting tr
                INNER JOIN mst_sumberdaya mn ON mn.kode = tr.kode_sumberdaya
                LEFT JOIN tr_rab_bl bl ON bl.kode_sumberdaya = tr.kode_sumberdaya
                LEFT JOIN mst_harga_sumberdaya mhs ON mhs.kode_sumberdaya = bl.kode_sumberdaya  
                WHERE tanggal <= LAST_DAY('$periode')
                
                        AND kode_coa = (select kode_coa from mst_setting_os where kode_menu='rpt-persediaan-jurnal-$modul') 
                        AND kode_spk =  '$kd_spk'
                GROUP BY kode_sumberdaya";
        //echo '<pre>'.$sql.'</pre>';
                //--month(tanggal) = month('$periode') AND year(tanggal) = year('$periode')
        $query = $this->db->query($sql);
        $hasil = array();
        foreach($query->result() as $row) {
        	$hasil[] = array(
	        			'kode'=>$row->kode_sumberdaya,
	        			'nama'=>$row->nama_sumberdaya,
	        			'coa'=>$row->kode_coa,
                        'rab_vol'=>$row->rab_vol,
                        'rab_price'=>$row->rab_price,
	        			'sa_vol'=>$row->sa_vol,
                        'sa_price'=>$row->sa_price,
                        'vol_in'=>$row->vol_masuk,
	        			'price_in'=>$row->harga_masuk,
	        			'vol_out'=>$row->vol_keluar,
	        			'price_out'=>$row->harga_keluar,
	        			'vol_sisa'=>$row->volume_sisa,
	        			'price_sisa'=>$row->harga_sisa,
	        			'price_avg'=>$row->harga_rata2,
                        'vol_mov'=>$row->vol_moving,
                        'price_mov'=>$row->price_moving,
        			);
        }
        
        return json_encode($hasil);
    }

    function getMenuTitle($kode){
        $sql = "SELECT judul_halaman 
                FROM mst_menu where kode like '%$kode'";
        $query = $this->db->query($sql);
        $res = $query->row_array();

        return $res;
    }
}