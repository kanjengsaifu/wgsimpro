<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rpt_opensystem_model extends CI_Model {
	
    function __construct() {
        $this->t_accounting = 'tr_accounting';
    }

    function get_hutangnol($periode,$modul)
    {
        $kode_spk = $this->session->userdata('kode_entity');
        $sql_lunas = "  SELECT DISTINCT tra.no_terbit, tra.no_bukti, 'SUB TOTAL' AS keterangan, tra.kode_nasabah, 
                            SUM( IF( tra.dk = f_cek_os_penerbitan(tra.kode_coa), tra.rupiah, 0 ) )AS penerbitan, 
                            SUM( IF( tra.dk = f_cek_os_pelunasan(tra.kode_coa), tra.rupiah, 0 ) )AS pelunasan, 
                            ( sum( IF( tra.dk = f_cek_os_penerbitan(tra.kode_coa), tra.rupiah, 0 ) ) - SUM( IF( tra.dk = f_cek_os_pelunasan(tra.kode_coa), tra.rupiah, 0 ) ) ) as sisa, 
                            LAST_DAY( DATE_ADD(CURDATE(), INTERVAL - 1 MONTH) )AS eodcm, datediff( LAST_DAY( DATE_ADD(CURDATE(), INTERVAL - 1 MONTH) ), tra.tanggal )AS umur 
                        FROM tr_accounting tra 
                        INNER JOIN mst_nasabah_konstruksi mn ON mn.kode = tra.kode_nasabah 
                        WHERE tra.tanggal < '$periode' AND kode_coa = (select kode_coa from mst_setting_os where kode_menu='rpt-opensystem-$modul	') AND kode_spk = '$kode_spk' 
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

    function get_sisaHutang($periode,$modul) 
    {
        $kode_spk = $this->session->userdata('kode_entity');

        $this->db->query('SET @ter := 0; SET @lun := 0; SET @sis := 0;');
        $sql = "SELECT tanggal, kode_nasabah, @ter:= SUM(IF( dk = f_cek_os_penerbitan(kode_coa), rupiah, 0 ))AS penerbitan,
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
                WHERE kode_spk = '$kode_spk' AND tanggal <= LAST_DAY('$periode') AND  kode_coa = (select kode_coa from mst_setting_os where kode_menu='rpt-opensystem-$modul')  
                GROUP BY kode_nasabah ";

        //die('<pre>'.$sql.'</pre>');
        $query = $this->db->query($sql);
        $res = $query->result_array();

        return $res;
    }
    
    function generateHutang($modul,$periode,$kd_nasabah,$modul)
    {
        list($bln, $thn) = explode('-', $periode);
        $periode =  $thn.'-'.sprintf('%02d',$bln).'-01';
        $periode_sebelum = $thn.'-'.sprintf('%02d',$bln-1).'-01';
        $kode_spk = $this->session->userdata('kode_entity');
        

        $kode_spk = $this->session->userdata('kode_entity');
        $noterbit = array();

        $cek_multi_os = 0;
        $sql_mos = "SELECT mos.id, mos.kode_coa 
                    FROM mst_setting_os  sos
                    INNER JOIN mst_setting_os_multi mos ON mos.parent_id=sos.id
                    WHERE kode_menu = 'rpt-opensystem-$modul' ";
        $qmos = $this->db->query($sql_mos);
        if ($qmos->num_rows() > 0)
        {
            foreach($qmos->result() as $row){
                $qmos_id =  $row->id;
                $multi_coa[] = $row->kode_coa;
            } 

            $is_multi_os = " AND kode_coa IN('".implode("','", $multi_coa)."')";
        }else{
            $is_multi_os = " AND kode_coa = (select kode_coa from mst_setting_os where kode_menu='rpt-opensystem-$modul') ";
        }
        //print_r($is_multi_os);die;

        $not_in_noterbit = $this->get_sisaHutang($periode_sebelum);
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
        //lama
        $sql_hn1 = " SELECT nt.* FROM (
                        SELECT  no_terbit, kode_coa, MAX(tanggal) as tanggal, '' as no_bukti, 'SISA' as keterangan, kode_nasabah, '' as nama_nasabah, '' as dk, 
                             SUM(IF( dk = f_cek_os_penerbitan(kode_coa), rupiah, 0 ))AS penerbitan, 
                             SUM(IF( dk = f_cek_os_pelunasan(kode_coa), rupiah, 0 ))AS pelunasan, 
                                (SUM(IF( dk = f_cek_os_penerbitan(kode_coa), rupiah, 0 )) - SUM(IF( dk = f_cek_os_pelunasan(kode_coa), rupiah, 0 )) )as sisa,
                             datediff( LAST_DAY( DATE_ADD(CURDATE(), INTERVAL - 1 MONTH) ), tanggal )AS umur, 'A2' as label,
                             IF ( (SUM(IF( dk = f_cek_os_penerbitan(kode_coa), rupiah, 0 )) - SUM(IF( dk = f_cek_os_pelunasan(kode_coa), rupiah, 0 )) ) = 0 , no_terbit,Null) as closed,
                             IF ( MAX(tanggal) <= LAST_DAY('$periode_sebelum'),no_terbit,Null) as closed2
                    FROM tr_accounting
                        INNER JOIN mst_nasabah_konstruksi mn ON mn.kode = tr_accounting.kode_nasabah
                        WHERE tanggal <= LAST_DAY('$periode') $is_multi_os AND kode_spk='$kode_spk'
                        GROUP BY kode_nasabah,no_terbit ) AS nt";
        //baru
        $sql_hn = " SELECT nt.* FROM (
                        SELECT  no_terbit, kode_coa, MAX(tanggal) as tanggal, '' as no_bukti, 'SISA' as keterangan, kode_nasabah, '' as nama_nasabah, '' as dk, 
                             SUM(IF( dk = f_cek_os_penerbitan(kode_coa), rupiah, 0 ))AS penerbitan, 
                             SUM(IF( dk = f_cek_os_pelunasan(kode_coa), rupiah, 0 ))AS pelunasan, 
                                (SUM(IF( dk = f_cek_os_penerbitan(kode_coa), rupiah, 0 )) - SUM(IF( dk = f_cek_os_pelunasan(kode_coa), rupiah, 0 )) )as sisa,
                             datediff( LAST_DAY( DATE_ADD(CURDATE(), INTERVAL - 1 MONTH) ), tanggal )AS umur, 'A2' as label,
                             IF ( (SUM(IF( dk = f_cek_os_penerbitan(kode_coa), rupiah, 0 )) - SUM(IF( dk = f_cek_os_pelunasan(kode_coa), rupiah, 0 )) ) = 0 , no_terbit,Null) as closed,
                             IF ( MAX(tanggal) <= '$periode',no_terbit,Null) as closed2
                    FROM tr_accounting
                        INNER JOIN mst_nasabah_konstruksi mn ON mn.kode = tr_accounting.kode_nasabah
                        WHERE tanggal <= '$periode' $is_multi_os AND kode_spk='$kode_spk'
                        GROUP BY kode_nasabah,no_terbit ) AS nt";
        
        //print_r('<pre>'.$sql_hn.'</pre>;<br>');
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

        //print_r($hn_terbit);die;
        $sql = "
		SELECT no_terbit, kode_coa, tanggal, no_bukti, keterangan, kode_faktur, kode_nasabah, nama as nama_nasabah, dk, 
                         IF( dk = f_cek_os_penerbitan(kode_coa), rupiah, 0 )AS penerbitan, 
                         IF( dk = f_cek_os_pelunasan(kode_coa), rupiah, 0 )AS pelunasan, 
                         ( IF( dk = f_cek_os_penerbitan(kode_coa), rupiah, 0 ) - IF( dk = f_cek_os_pelunasan(kode_coa), rupiah, 0 ) ) as sisa,
                         datediff(
                                LAST_DAY('$periode'),
                                tanggal
                        ) AS umur, 'A1' as label
                FROM tr_accounting
                INNER JOIN mst_nasabah_konstruksi mn ON mn.kode = tr_accounting.kode_nasabah
                WHERE tanggal <= LAST_DAY('$periode') $terbit_hide  $is_multi_os AND kode_spk = '$kode_spk' 
                UNION
                SELECT nt.* FROM (
                    SELECT  no_terbit, kode_coa, '' as tanggal, '' as no_bukti, 'SISA' as keterangan, '' as kode_faktur, kode_nasabah, '' as nama_nasabah, '' as dk, 
                            '' as penerbitan,
                        '' as pelunasan,
                            (SUM(IF( dk = f_cek_os_penerbitan(kode_coa), rupiah, 0 )) - SUM(IF( dk = f_cek_os_pelunasan(kode_coa), rupiah, 0 )) )as sisa,
                         datediff( LAST_DAY('$periode'), tanggal )AS umur, 'A2' as label
                    FROM tr_accounting
                    INNER JOIN mst_nasabah_konstruksi mn ON mn.kode = tr_accounting.kode_nasabah
                    WHERE tanggal <= LAST_DAY('$periode') $terbit_hide $is_multi_os  AND kode_spk = '$kode_spk' 
                    GROUP BY kode_nasabah,no_terbit ) AS nt
                UNION 
                SELECT tt.* FROM (
                    SELECT  '' as no_terbit, kode_coa, '' as tanggal, '' as no_bukti, concat('SISA PERNASABAH: ',kode_nasabah,' - ', mn.nama) as keterangan, '' as kode_faktur, kode_nasabah, mn.nama as nama_nasabah, '' as dk, 
                        SUM(IF( dk = f_cek_os_penerbitan(kode_coa), rupiah, 0 )) as penerbitan,
                        SUM(IF( dk = f_cek_os_pelunasan(kode_coa), rupiah, 0 )) as pelunasan,
                        (SUM(IF( dk = f_cek_os_penerbitan(kode_coa), rupiah, 0 )) - SUM(IF( dk = f_cek_os_pelunasan(kode_coa), rupiah, 0 )) )as sisa,
                         '' AS umur, 'B' as label
                    FROM tr_accounting
                    INNER JOIN mst_nasabah_konstruksi mn ON mn.kode = tr_accounting.kode_nasabah
                    WHERE tanggal <= LAST_DAY('$periode') $terbit_hide $is_multi_os  AND kode_spk = '$kode_spk' 
                    GROUP BY kode_nasabah ) AS tt 
                ORDER BY kode_nasabah, no_terbit DESC, label ASC";
               
		//die('<pre>'.$sql.'</pre>');
        
        $query  = $this->db->query($sql);
        $res    = $query->result_array(); 
        $numrow = $query->num_rows(); 

        return $res; 
    }

    function _showColumnOptional($modul){
        $sql = " SELECT is_tmp_faktur, is_tmp_invoice FROM mst_setting_os WHERE kode_menu = 'rpt-opensystem-$modul'";
        $query = $this->db->query($sql);
        //print_r($sql);
        $data = array();
        foreach($query->result() as $row){
            $data = array('is_tmp_faktur' => $row->is_tmp_faktur, 'is_tmp_invoice' => $row->is_tmp_invoice);
        }
        return $data;
    }


    function generateHutangIkhtisar($modul,$periode,$kd_nasabah,$modul)
    {
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
                        WHERE tanggal <= LAST_DAY('$periode') AND kode_coa = (select kode_coa from mst_setting_os where kode_menu='rpt-opensystem-$modul')  AND kode_spk='$kode_spk'
                        GROUP BY kode_nasabah,no_terbit ) AS nt";
        
        //print_r('<pre>'.$sql_hn.';</pre>');   
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


        $sqxl  = "SELECT nt.* FROM (
                        SELECT  
                            mn.kode as kode_nasabah, mn.nama as nama_nasabah, no_terbit, 
                            kode_coa, 
                            MAX(tanggal) as tanggal, 
                            mn.kode as kode_nas,
                            SUM(IF( dk = f_cek_os_penerbitan(kode_coa), rupiah, 0 ))AS penerbitan, 
                            SUM(IF( dk = f_cek_os_pelunasan(kode_coa), rupiah, 0 ))AS pelunasan, 
                            (SUM(IF( dk = f_cek_os_penerbitan(kode_coa), rupiah, 0 )) - SUM(IF( dk = f_cek_os_pelunasan(kode_coa), rupiah, 0 )) )as sisa,
                            datediff( LAST_DAY( DATE_ADD(CURDATE(), INTERVAL - 1 MONTH) ), tanggal )AS umur,
                            IF ( (SUM(IF( dk = f_cek_os_penerbitan(kode_coa), rupiah, 0 )) - SUM(IF( dk = f_cek_os_pelunasan(kode_coa), rupiah, 0 )) ) = 0 , no_terbit,Null) as closed,
                            IF ( MAX(tanggal) <= LAST_DAY('$periode'), no_terbit,Null) as closed2
                        FROM tr_accounting
                        INNER JOIN mst_nasabah_konstruksi mn ON mn.kode = tr_accounting.kode_nasabah
                        WHERE 
                                tanggal <= LAST_DAY('$periode') AND 
                                kode_coa = (select kode_coa from mst_setting_os where kode_menu='rpt-opensystem-$modul')  AND 
                                kode_spk='$kode_spk'
                        GROUP BY kode_nasabah,no_bukti ) AS nt
                WHERE nt.closed is NULL OR nt.closed2 is NULL
                GROUP BY nt.kode_nasabah ASC 
                ORDER BY nt.kode_nasabah, nt.tanggal ASC ";
        
        //die('<pre>'.$sql.'</pre>');
        $sql= " 
                SELECT ch.kode_nasabah, ch.nama_nasabah, ch.no_terbit, ch.kode_coa, ch.tanggal, ch.no_bukti, ch.keterangan, ch.penerbitan as penerbitan, ch.pelunasan as pelunasan, ch.dk,  ch.sisa,
                    if(ch.umur<=30,ch.sisa,0) as 30d, 
                    if(ch.umur>30&&ch.umur<=90,ch.sisa,0) as 90d, 
                    if(ch.umur>=90&&ch.umur<=180,ch.sisa,0) as 180d, 
                    if(ch.umur>=180&&ch.umur<=360,ch.sisa,0) as 360d,
                    if(ch.umur>=360,ch.sisa,0) as over_360d,
                    @PrevSisa := @PrevSisa + ch.penerbitan - ch.pelunasan as t_sisa,
                    @PrevMutasi := @PrevMutasi + ch.pelunasan as t_mutasi,
                    @PrevNRC := @PrevSisa + @PrevMutasi as ncr_trial_kredit
                    FROM
                    (
                        SELECT no_terbit, kode_coa, tanggal, no_bukti, keterangan, kode_nasabah, nama as nama_nasabah, dk, 
                                         sum(IF( dk = f_cek_os_penerbitan(kode_coa), rupiah, 0 ) )AS penerbitan, 
                                         sum(IF( dk = f_cek_os_pelunasan(kode_coa), rupiah, 0 ) )AS pelunasan, 
                                         sum( IF( dk = f_cek_os_penerbitan(kode_coa), rupiah, 0 ) - IF( dk = f_cek_os_pelunasan(kode_coa), rupiah, 0 ) ) as sisa,
                                         sum( datediff( LAST_DAY('$periode'), tanggal ) ) AS umur
                        FROM tr_accounting
                        INNER JOIN mst_nasabah_konstruksi mn ON mn.kode = tr_accounting.kode_nasabah
                        WHERE tanggal <= LAST_DAY('$periode')  
                                AND kode_coa = (select kode_coa from mst_setting_os where kode_menu='rpt-opensystem-$modul') 
                                AND kode_spk =  '$kode_spk'
                    GROUP BY kode_nasabah
                    ) AS ch,
                ( select @PrevSisa := 0.00, @PrevMutasi :=0.00 ) as sqlSaldo
                WHERE ch.sisa > 0
                ORDER BY ch.no_terbit ASC, ch.kode_nasabah ASC";
        //die('<pre>'.$sql.'</pre>');
        $sqlxz = "
                SELECT tt.* FROM (
                        SELECT  '' as no_terbit, kode_coa, '' as tanggal, '' as no_bukti, concat('SISA PERNASABAH: ',kode_nasabah,' - ', mn.nama) as keterangan, kode_nasabah, mn.nama as nama_nasabah, '' as dk, 
                         '' as penerbitan,
                             '' as pelunasan,
                                 (SUM(IF( dk = f_cek_os_penerbitan(kode_coa), rupiah, 0 )) - SUM(IF( dk = f_cek_os_pelunasan(kode_coa), rupiah, 0 )) )as sisa,
                                 '' AS umur
                        FROM tr_accounting
                        INNER JOIN mst_nasabah_konstruksi mn ON mn.kode = tr_accounting.kode_nasabah
                        WHERE tanggal <= LAST_DAY('$periode') 
                            AND kode_coa = (select kode_coa from mst_setting_os where kode_menu='rpt-opensystem-$modul') 
                            AND kode_spk = '$kode_spk' 
                        GROUP BY kode_nasabah ) AS tt 
                WHERE sisa > 0
                GROUP BY kode_nasabah
                ORDER BY kode_nasabah, no_terbit DESC, label ASC";
        
        
        $sql = "
                SELECT tn.kode_nasabah, tn.nama_nasabah, sum(sisa) as sisa,sum(30d) as _30d ,sum(90d) as _90d,sum(180d) as _180d,sum(360d) as _360d,sum(over_360d) as _over360d 
                FROM (
                     SELECT nt.* FROM (
                                SELECT  no_terbit, kode_coa, '' as tanggal, '' as no_bukti, 'SISA' as keterangan, kode_nasabah, mn.nama as nama_nasabah, '' as dk, 
                                                '' as penerbitan,
                                        '' as pelunasan,
                                                (SUM(IF( dk = f_cek_os_penerbitan(kode_coa), rupiah, 0 )) - SUM(IF( dk = f_cek_os_pelunasan(kode_coa), rupiah, 0 )) )as sisa,
                                         datediff( LAST_DAY('$periode'), tanggal )AS umur, 'A2' as label,
                                         if(datediff( LAST_DAY('$periode'),tanggal)<=30,( IF( dk = f_cek_os_penerbitan(kode_coa), rupiah, 0 ) - IF( dk = f_cek_os_pelunasan(kode_coa), rupiah, 0 ) ) ,0) as 30d,
                                         if( (SUM(IF( dk = f_cek_os_penerbitan(kode_coa), rupiah, 0 )) - SUM(IF( dk = f_cek_os_pelunasan(kode_coa), rupiah, 0 )) )=0,0,
                                                     if(datediff( LAST_DAY('$periode'),tanggal)>30&&datediff( LAST_DAY('$periode'),tanggal)<=90,( IF( dk = f_cek_os_penerbitan(kode_coa), rupiah, 0 ) - IF( dk = f_cek_os_pelunasan(kode_coa), rupiah, 0 ) ) ,0)) as 90d,
                                         if( (SUM(IF( dk = f_cek_os_penerbitan(kode_coa), rupiah, 0 )) - SUM(IF( dk = f_cek_os_pelunasan(kode_coa), rupiah, 0 )) )=0,0,
                                                     if(datediff( LAST_DAY('$periode'),tanggal)>90&&datediff( LAST_DAY('$periode'),tanggal)<=180,( IF( dk = f_cek_os_penerbitan(kode_coa), rupiah, 0 ) - IF( dk = f_cek_os_pelunasan(kode_coa), rupiah, 0 ) ) ,0)) as 180d,
                                         if( (SUM(IF( dk = f_cek_os_penerbitan(kode_coa), rupiah, 0 )) - SUM(IF( dk = f_cek_os_pelunasan(kode_coa), rupiah, 0 )) )=0,0,
                                                     if(datediff( LAST_DAY('$periode'),tanggal)>180&&datediff( LAST_DAY('$periode'),tanggal)<=360,( IF( dk = f_cek_os_penerbitan(kode_coa), rupiah, 0 ) - IF( dk = f_cek_os_pelunasan(kode_coa), rupiah, 0 ) ) ,0)) as 360d,
                                         if( (SUM(IF( dk = f_cek_os_penerbitan(kode_coa), rupiah, 0 )) - SUM(IF( dk = f_cek_os_pelunasan(kode_coa), rupiah, 0 )) )=0,0,
                                                     if(datediff( LAST_DAY('$periode'),tanggal)>360,( IF( dk = f_cek_os_penerbitan(kode_coa), rupiah, 0 ) - IF( dk = f_cek_os_pelunasan(kode_coa), rupiah, 0 ) ) ,0)) as over_360d
                                FROM tr_accounting
                                INNER JOIN mst_nasabah_konstruksi mn ON mn.kode = tr_accounting.kode_nasabah
                                WHERE tanggal <= LAST_DAY('$periode') 
                                    $terbit_hide
                                    AND kode_coa = (select kode_coa from mst_setting_os where kode_menu='rpt-opensystem-$modul')   
                                    AND kode_spk = '$kode_spk' 
                                GROUP BY kode_nasabah,no_terbit ) AS nt)
                    as tn
                    GROUP BY kode_nasabah
                    ";
        //die('<pre>'.$sql.';</pre>');
        $query  = $this->db->query($sql);
        $res    = $query->result_array(); 
        $numrow = $query->num_rows(); 

        return $res; 
    }

    function generateOptionBox(){
        $sql = "SELECT kode,judul_menu,judul_halaman 
                FROM mst_menu 
                WHERE kode LIKE 'rpt-opensystem%' ORDER BY no_urut ASC";
        $query = $this->db->query($sql);
        $res = $query->result_array();

        return $res;
    }
    function getMenuTitle($kode){
        $sql = "SELECT judul_halaman 
                FROM mst_menu where kode like '%$kode'";
        $query = $this->db->query($sql);
        $res = $query->row_array();

        return $res;
    }

    function getNamaDivisi($kode) {
        $array = array('udiv.username' => $this->session->userdata('usernm'), 'mdiv.kode' => $kode);
        $this->db->where($array); 
        $this->db->select('udiv.divisi_level, mdiv.kode, mdiv.nama');
        $this->db->from('t_user_divisi udiv');
        $this->db->join('mst_divisi mdiv', 'mdiv.kode = udiv.kode_divisi','inner');

        $query = $this->db->get();

        return $query->row_array();
    }
}