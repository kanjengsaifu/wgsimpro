<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
// ------------------------------------------------------------------------

/**
 * CodeIgniter Combo Helpers
 *
 * @package        	CodeIgniter
 * @subpackage    	Helpers
 * @category    	Helpers
 * @author        	Chairul
 * @link        
 */

// ------------------------------------------------------------------------

if (! function_exists('tr_bukbes')) {
    function tr_bukbes($coa, $period, $kd_div, $saldo_awal, $tr_idname='', $tr_varval='', $tr_class='', $td_idname='', $td_varval='', $td_class='', $extra='')  {
        //echo $period;die;
        $CI =& get_instance();
        list($bln, $thn) = explode('-', $period);
        $perio_de =  $thn.'-'.sprintf('%02d',$bln);
        $periode_lalu = $thn.'-'.sprintf('%02d',($bln - 1));
        $kode_spk = $CI->session->userdata('kode_entity');
        //echo '<pre>'.$coa.'::'.$perio_de.'::'.$kd_div.'::'.$saldo_awal.(':: tra.tanggal,'.$perio_de.',after').'</pre>';
        $retval = '';

        //$sql = 'SET @s = '.$saldo_awal.'; SET @d = 0; SET @k = 0;';
        //$CI->db->query($sql);

        $cari_tgl = array('tra.tanggal'=>$periode_lalu);
        //'tra.tanggal',(string)$perio_de,'after'
        //$CI->db->where(array('tra.kode_coa'=>$coa,'tra.kode_divisi'=>$kd_div, 'tra.kode_spk'=>$kode_spk));
        //$CI->db->like('tra.tanggal',(string)$perio_de,'after');
        /*$CI->db->select("tra.kode_coa AS kd_coa,
                    tra.tanggal AS tanggal,
                    tra.no_bukti,
                    tra.no_terbit,
                    tra.keterangan AS uraian,
                    tra.dk AS dk,
                    tra.rupiah AS rupiah,
                    IF(tra.dk = 'D', tra.rupiah, 0)AS debit,
                    IF(tra.dk = 'K', tra.rupiah, 0)AS kredit, 
                    tra.rupiah,
                    (".$saldo_awal."+IF(tra.dk = 'D', tra.rupiah, 0))-IF(tra.dk = 'K', tra.rupiah, 0) AS saldo");*/
        //$CI->db->select('tra.*');
        //$CI->db->from('tr_accounting tra');
        //$query = $CI->db->get();

        //$sqlset = "SET @SA = ".$saldo_awal.";";  
        //$query = $CI->db->query($sqlset);
        $sql = "
                SELECT bk.tanggal, bk.kode_coa, bk.no_bukti, bk.no_terbit, bk.keterangan, bk.debit, bk.kredit, bk.saldo_mutasi FROM 
                (
                    SELECT tanggal, kode_coa, no_bukti, no_terbit, keterangan, if(dk='D', rupiah,0) as debit, if(dk='K', rupiah,0) as kredit, dk,
                        @PrevSaldo :=  ((@PrevSaldo + if(dk='D', rupiah, 0) ) - if(dk='K', rupiah, 0)) AS saldo_mutasi
                    FROM tr_accounting
                    WHERE 
                        kode_coa = ".$coa."  AND 
                        
                        kode_spk = '".$kode_spk."' AND 
                        YEAR(tanggal) = ".$thn." AND MONTH(tanggal) = ".$bln."
                ) AS bk,
                ( SELECT @PrevSaldo := ".$saldo_awal." ) AS qrSaldo ";

        //print_r($sqlset.$sql);die;
        $query = $CI->db->query($sql);
        
        $i=1;
        $saldo = 0;
        $t_saldo = 0;
        $debit = $kredit = 0;
        foreach ($query->result() as $row) {

           $debit = $row->debit;//($row->dk=='D'?$row->rupiah:0);
           $kredit = $row->kredit;// ($row->dk=='K'?$row->rupiah:0);
            //$saldo += ($saldo+$debit)-$kredit;
            //$saldo = $row->saldo_mutasi;//($saldo_awal + $debit) - $kredit;
            //$t_saldo += $saldo;
            $retval .= '<tr id="sub_'.$coa.'" '.$tr_varval.' '.$tr_class.' '.$extra.'>';
            $retval .= '   <td '.$td_idname.' '.$td_varval.' '.$td_class.'>';
            $retval .= '    ';
            $retval .= '   </td>';
            $retval .= '   <td '.$td_idname.' '.$td_varval.' class="text-right">';
            $retval .= '    '.$i;
            $retval .= '   </td>';
            $retval .= '   <td '.$td_idname.' '.$td_varval.'  class="text-right">';
            $retval .= '    '.$row->tanggal.'&nbsp;&nbsp;&nbsp;&nbsp;';
            $retval .= '   </td>';
            $retval .= '   <td '.$td_idname.' '.$td_varval.' class="text-center">';
            $retval .= '    '.$row->no_bukti;
            $retval .= '   </td>';
            $retval .= '   <td '.$td_idname.' '.$td_varval.' '.$td_class.'>';
            $retval .= '    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$row->keterangan;
            $retval .= '   </td>';
            $retval .= '   <td '.$td_idname.' '.$td_varval.' class="text-right">';
            $retval .= '    '.number_format($debit);
            $retval .= '   </td>';
            $retval .= '   <td '.$td_idname.' '.$td_varval.' class="text-right">';
            $retval .= '    '.number_format($kredit);
            $retval .= '   </td>';
            $retval .= '   <td '.$td_idname.' '.$td_varval.' class="text-right">';
            $retval .=      number_format($row->saldo_mutasi);
            $retval .= '   </td>';
            $retval .= '</tr>';
            $i++;
        }
        return $retval;
    }
}


if (! function_exists('tr_opensystem')) {
    function tr_opensystem($modul,$period)  {
        //echo $period;die;
        $CI =& get_instance();
        list($bln, $thn)    = explode('-', $period);
        $periode            =  $thn.'-'.sprintf('%02d',$bln).'-01';
        //$periode_lalu = $thn.'-'.sprintf('%02d',($bln - 1));
        $kd_spk             = $CI->session->userdata('kode_entity');
        $retval = '';
        $retval = '<table id="example" class="table table-bordered mbn exportExcel">
                        <thead>
                            <tr class="bg-primary light">
                                <th class="text-center"></th>
                                <th class="text-center">TANGGAL</th>
                                <th class="text-center">NOMOR BUKTI</th>
                                <th class="text-center">URAIAN</th>
                                <th class="text-center">PENERBITAN</th>
                                <th class="text-center">PELUNASAN</th>
                                <th class="text-center">SISA</th>
                                <th class="text-center">UMUR</th>
                            </tr>
                        </thead>
                        <tbody>';
        $sqlx = "
            SELECT
                no_terbit,
                tanggal,
                no_bukti,
                keterangan,
                kode_nasabah,
                nama AS nama_nasabah,
                SUM(
                    IF (
                        dk = f_cek_os_penerbitan (kode_coa),
                        rupiah,
                        0
                    )
                ) AS penerbitan,
                SUM(
                    IF (
                        dk = f_cek_os_pelunasan (kode_coa),
                        rupiah,
                        0
                    )
                ) AS pelunasan,
                SUM(
                    IF (
                        dk = f_cek_os_penerbitan (kode_coa),
                        rupiah,
                        0
                    ) -
                    IF (
                        dk = f_cek_os_pelunasan (kode_coa),
                        rupiah,
                        0
                    )
                ) AS sisa,
                datediff(
                    LAST_DAY('$periode'),
                    tanggal
                ) AS umur
            FROM
                tr_accounting
            INNER JOIN mst_nasabah_konstruksi mn ON mn.kode = tr_accounting.kode_nasabah
            WHERE
                tanggal <= LAST_DAY('$periode')
            AND kode_coa = (
                SELECT
                    kode_coa
                FROM
                    mst_setting_os
                WHERE
                    kode_menu = 'rpt-opensystem-$modul'
            )
            AND kode_spk = '$kd_spk'
            GROUP BY
                kode_nasabah ASC

        ";
        $sql = "
                SELECT nt.* FROM (
                    SELECT  
                            mn.kode as kode_nasabah, mn.nama as nama_nasabah, tra.no_terbit, tra.kode_coa, tra.tanggal, 
                            mn.kode as kode_nas, tra.keterangan, 
                            SUM(IF( dk = f_cek_os_penerbitan(kode_coa), rupiah, 0 ))AS penerbitan, 
                            SUM(IF( dk = f_cek_os_pelunasan(kode_coa), rupiah, 0 ))AS pelunasan, 
                            @s:=(SUM(IF( dk = f_cek_os_penerbitan(kode_coa), rupiah, 0 )) - SUM(IF( dk = f_cek_os_pelunasan(kode_coa), rupiah, 0 )) )as sisa,
                            datediff( LAST_DAY( DATE_ADD(CURDATE(), INTERVAL - 1 MONTH) ), tanggal )AS umur,
                            IF ( (SUM(IF( dk = f_cek_os_penerbitan(kode_coa), rupiah, 0 )) - SUM(IF( dk = f_cek_os_pelunasan(kode_coa), rupiah, 0 )) ) = 0 , no_terbit,Null) as closed,
                            IF ( MAX(tanggal) <= LAST_DAY('$periode'), no_terbit,Null) as closed2
                    FROM tr_accounting tra
                    INNER JOIN mst_nasabah_konstruksi mn ON mn.kode = tra.kode_nasabah
                    WHERE 
                                    tanggal <= LAST_DAY('$periode') AND 
                                    kode_coa = (select kode_coa from mst_setting_os where kode_menu='rpt-opensystem-$modul')  AND 
                                    kode_spk='$kd_spk'
                    GROUP BY no_bukti ) AS nt
                WHERE nt.closed is NULL OR nt.closed2 is NULL
                GROUP BY nt.kode_nasabah ASC 
                ORDER BY nt.kode_nasabah, nt.tanggal ASC
                ";
        //echo '<pre>'.$sql.'</pre>';
        $query = $CI->db->query($sql);
        $i=A;
        $saldo = 0;
        $coa=$tr_varval=$tr_class=$extra='';
        $t_penerbitan = $t_pelunasan = $t_subtotal = $t_total = $t_sisa = $t_umur = 0;

        foreach ($query->result() as $row) {
            $retval .= '<tr id="sub_'.$coa.'" '.$tr_varval.' '.$tr_class.' '.$extra.'>';
            $retval .= '   <td '.$td_idname.' '.$td_varval.' class="text-right">';
            $retval .= '    <b>'.$i.'</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            $retval .= '   </td>';
            $retval .= '   <td '.$td_idname.' '.$td_varval.' '.$td_class.' colspan="3">';
            $retval .= '    &nbsp;<b>'.$row->kode_nasabah.' - '.$row->nama_nasabah.'</b>';
            $retval .= '   </td>';
            
            $retval .= '   <td '.$td_idname.' '.$td_varval.' class="text-right">';
            $retval .= '    '.number_format($row->penerbitan);
            $retval .= '   </td>';
            $retval .= '   <td '.$td_idname.' '.$td_varval.' '.$td_class.'>';
            $retval .= '    ';
            $retval .= '   </td>';
            $retval .= '   <td '.$td_idname.' '.$td_varval.' class="text-right">';
            $retval .= '    '.number_format($row->sisa);
            $retval .= '   </td>';
            $retval .= '   <td '.$td_idname.' '.$td_varval.' class="text-right">';
            $retval .= '    '.number_format($row->umur);
            $retval .= '   </td>';
            
            $retval .= '</tr>';

            $CI->load->helper('generator');
            $retval .= tr_opensystem_pernasabah($modul,$period,$row->kode_nasabah);
           /* $retval .= '<tfoot>
                            <tr class="bg-primary light">
                                <th colspan="4" class="text-right"> SUB TOTAL</th>
                                <th class="text-right">'.number_format($row->penerbitan).'</th>
                                <th class="text-right">'.number_format($row->pelunasan).'</th>
                                <th class="text-right">'.number_format($row->penerbitan-$row->pelunasan).'</th>
                                <th class="text-right">'.number_format($row->umur).'</th>
                            </tr>
                        </tfoot>';
            */
            $i++;
        }
        $retval .= '</tbody></table>';
        return $retval;
    }
}

if (! function_exists('tr_opensystem_pernasabah')) {
    function tr_opensystem_pernasabah($modul,$period,$kd_nasabah)  {
        //echo $period;die;
        $CI =& get_instance();
        list($bln, $thn) = explode('-', $period);
        $periode            =  $thn.'-'.sprintf('%02d',$bln).'-01';
        $kd_spk             = $CI->session->userdata('kode_entity');
        $coa=$tr_varval=$tr_class=$extra='';
        $retval = '';

        $sql_pernobukz = "
            SELECT
                no_terbit,
                tanggal,
                no_bukti,
                kode_nasabah,
                keterangan,
                SUM(
                    IF (
                        dk = f_cek_os_penerbitan (kode_coa),
                        rupiah,
                        0
                    )
                ) AS penerbitan,
                SUM(
                    IF (
                        dk = f_cek_os_pelunasan (kode_coa),
                        rupiah,
                        0
                    )
                ) AS pelunasan,
                    SUM(
                        IF (
                            dk = f_cek_os_penerbitan (kode_coa),
                            rupiah,
                            0
                        ) -
                        IF (
                            dk = f_cek_os_pelunasan (kode_coa),
                            rupiah,
                            0
                        )
                ) AS sisa,
                datediff(
                    LAST_DAY('$periode'),
                    tanggal
                ) AS umur
            FROM
                tr_accounting
            INNER JOIN mst_nasabah_konstruksi mn ON mn.kode = tr_accounting.kode_nasabah
            WHERE
                tanggal <= LAST_DAY('$periode')
            AND kode_coa = (
                SELECT
                    kode_coa
                FROM
                    mst_setting_os
                WHERE
                    kode_menu = 'rpt-opensystem-$modul'
            )
            AND kode_spk = '$kd_spk' AND kode_nasabah = '$kd_nasabah' ";
        $sql = "
                SELECT nt.* FROM (
                    SELECT  
                            mn.kode as kode_nasabah, mn.nama as nama_nasabah, tra.no_terbit, tra.kode_coa, tra.tanggal, 
                            mn.kode as kode_nas,
                            IF( dk = f_cek_os_penerbitan(kode_coa), rupiah, 0 )AS penerbitan, 
                            IF( dk = f_cek_os_pelunasan(kode_coa), rupiah, 0 )AS pelunasan, 
                            SUM(IF( dk = f_cek_os_penerbitan(kode_coa), rupiah, 0 )) - SUM(IF( dk = f_cek_os_pelunasan(kode_coa), rupiah, 0 ) )as sisa,
                            datediff( LAST_DAY( DATE_ADD(CURDATE(), INTERVAL - 1 MONTH) ), tanggal )AS umur,
                            IF ( (IF( dk = f_cek_os_penerbitan(kode_coa), rupiah, 0 )) - SUM(IF( dk = f_cek_os_pelunasan(kode_coa), rupiah, 0 ) ) = 0 , no_terbit,Null) as closed,
                            IF ( MAX(tanggal) <= LAST_DAY('$periode'), no_terbit,Null) as closed2
                    FROM tr_accounting tra
                    INNER JOIN mst_nasabah_konstruksi mn ON mn.kode = tra.kode_nasabah
                    WHERE 
                            tanggal <= LAST_DAY('$periode') AND 
                            kode_coa = (select kode_coa from mst_setting_os where kode_menu='rpt-opensystem-$modul')  AND 
                            kode_spk='$kd_spk' AND kode_nasabah = '$kd_nasabah' 
                    GROUP BY no_bukti ) AS nt
                WHERE nt.closed is NULL OR nt.closed2 is NULL
                GROUP BY nt.kode_nasabah ASC 
                ORDER BY nt.kode_nasabah, nt.tanggal ASC
        ";
        //echo '<pre>'.$sql.'</pre>';
        $query = $CI->db->query($sql);
        $nobuk=array();
        foreach($query->result() as $k){
            $nobuk[] = $k->no_bukti;
        }
        //var_dump($nobuk);
        $i=1;
        $t_penerbitan += $row->penerbitan;
        $t_pelunasan += $row->pelunasan;
        $t_sisa += 0 + $t_pelunasan - $t_penerbitan;
        foreach ($query->result() as $row) {
            $retval .= '<tr id="sub_'.$coa.'" '.$tr_varval.' '.$tr_class.' '.$extra.'>';
            $retval .= '   <td '.$td_idname.' '.$td_varval.' class="text-right">';
            $retval .= '    '.$i;
            $retval .= '   </td>';
            $retval .= '   <td '.$td_idname.' '.$td_varval.'  class="text-right">';
            $retval .= '    '.$row->tanggal.'&nbsp;&nbsp;&nbsp;&nbsp;';
            $retval .= '   </td>';
            $retval .= '   <td '.$td_idname.' '.$td_varval.' class="text-center">';
            $retval .= '    '.$row->no_bukti;
            $retval .= '   </td>';
            $retval .= '   <td '.$td_idname.' '.$td_varval.' '.$td_class.'>';
            $retval .= '    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$row->keterangan;
            $retval .= '   </td>';
            $retval .= '   <td '.$td_idname.' '.$td_varval.' class="text-right">';
            $retval .= '    '.number_format($row->penerbitan);
            $retval .= '   </td>';
            $retval .= '   <td '.$td_idname.' '.$td_varval.' class="text-right">';
            $retval .= '    '.number_format($row->pelunasan);
            $retval .= '   </td>';
            $retval .= '   <td '.$td_idname.' '.$td_varval.' class="text-right">';
            $retval .= '    '.number_format($t_sisa);
            $retval .= '   </td>';
            $retval .= '   <td '.$td_idname.' '.$td_varval.' class="text-right">';
            $retval .= '    '.number_format($row->umur);
            $retval .= '   </td>';
            $retval .= '</tr>';
            //$CI->load->helper('generator');
            //$retval .= tr_opensystem_pernobuk($modul,$period,$row->no_bukti);
            $sa = $t_penerbitan;
            $t_penerbitan += $row->penerbitan;
            $t_pelunasan += $row->pelunasan;
            $t_sisa += ($sa + $t_penerbitan) - $t_pelunasan;
            /*$retval .= '<tfoot>
                            <tr class="bg-primary light">
                                <th colspan="4" class="text-right"> SUB TOTAL</th>
                                <th class="text-right">'.number_format($t_penerbitan).'</th>
                                <th class="text-right">'.number_format($t_pelunasan).'</th>
                                <th class="text-right">'.number_format($t_penerbitan-$t_pelunasan).'</th>
                                <th class="text-right">'.number_format($t_sisa).'</th>
                            </tr>
                        </tfoot>';*/
            $i++;
        }

        return $retval;
    }
}

if (! function_exists('tr_opensystem_pernobuk')) {
    function tr_opensystem_pernobuk($modul,$period,$no_bukti)  {
        //echo $period;die;
        $CI =& get_instance();
        list($bln, $thn) = explode('-', $period);
        $periode            =  $thn.'-'.sprintf('%02d',$bln).'-01';
        $kd_spk             = $CI->session->userdata('kode_entity');
        $coa=$tr_varval=$tr_class=$extra='';
        $retval = '';
        $CI->db->query('SET @ss = 0;');
        $CI->db->query('SET @pl = 0;');
        $CI->db->query('SET @tr = 0;');
        $sql_pernobuk = "
            SELECT
                no_terbit,
                tanggal,
                no_bukti,
                kode_nasabah,
                keterangan,
                SUM(
                    IF (
                        dk = f_cek_os_penerbitan (kode_coa),
                        rupiah,
                        0
                    )
                ) AS penerbitan,
                SUM(
                    IF (
                        dk = f_cek_os_pelunasan (kode_coa),
                        rupiah,
                        0
                    )
                ) AS pelunasan,
                    SUM(
                        (
                            IF (
                                dk = f_cek_os_penerbitan (kode_coa),
                                rupiah,
                                0
                            ) +
                            IF (
                                dk = f_cek_os_penerbitan (kode_coa),
                                rupiah,
                                0
                            )
                        ) -
                        IF (
                            dk = f_cek_os_pelunasan (kode_coa),
                            rupiah,
                            0
                        )
                ) AS sisa,
                datediff(
                    LAST_DAY('$periode'),
                    tanggal
                ) AS umur
            FROM
                tr_accounting
            INNER JOIN mst_nasabah_konstruksi mn ON mn.kode = tr_accounting.kode_nasabah
            WHERE
                tanggal <= LAST_DAY('$periode')
            AND kode_coa = (
                SELECT
                    kode_coa
                FROM
                    mst_setting_os
                WHERE
                    kode_menu = 'rpt-opensystem-$modul'
            )
            AND kode_spk = '$kd_spk' AND no_bukti = '$no_bukti'
            GROUP BY
                no_bukti ASC
        ";
        //echo '<pre>'.$sql_pernobuk.'</pre>';
        $query = $CI->db->query($sql_pernobuk);
        $nobuk=array();
        foreach($query->result() as $k){
            $nobuk[] = $k->no_bukti;
        }
        //var_dump($nobuk);
        $i=1;
        $sa=0;
        $t_penerbitan += $row->penerbitan;
        $t_pelunasan += $row->pelunasan;
        $t_sisa += $t_penerbitan+($t_penerbitan-$t_pelunasan);
        foreach ($query->result() as $row) {
            $retval .= '<tr id="sub_'.$coa.'" '.$tr_varval.' '.$tr_class.' '.$extra.'>';
            $retval .= '   <td '.$td_idname.' '.$td_varval.' class="text-right">';
            $retval .= '    ';
            $retval .= '   </td>';
            $retval .= '   <td class="text-right" colspan="3">';
            $retval .= '    Sub Total';
            $retval .= '   </td>';
            $retval .= '   <td '.$td_idname.' '.$td_varval.' class="text-right">';
            $retval .= '    '.number_format($row->penerbitan);
            $retval .= '   </td>';
            $retval .= '   <td '.$td_idname.' '.$td_varval.' class="text-right">';
            $retval .= '    '.number_format($row->pelunasan);
            $retval .= '   </td>';
            $retval .= '   <td '.$td_idname.' '.$td_varval.' class="text-right">';
            $retval .= '    '.number_format($t_sisa);
            $retval .= '   </td>';
            $retval .= '   <td '.$td_idname.' '.$td_varval.' class="text-right">';
            $retval .= '    ';
            $retval .= '   </td>';
            $retval .= '</tr>';
            $i++;
        }

        return $retval;
    }
}
/**
 * 
 * FUNGSI : GENERATE LAPORAN TAHAP RA-RI       
 */

if (! function_exists('tr_tahap_rari')) {
    function tr_tahap_rari($kelompok_biaya, $kode_spk, $period, $tr_idname='', $tr_varval='', $tr_class='', $td_idname='', $td_varval='', $td_class='', $extra='')  {
        //echo $period;die;
        $CI =& get_instance();
        list($bln, $thn) = explode('-', $period);
        $perio_de =  $thn.'-'.sprintf('%02d',$bln);
        $periode_lalu = $thn.'-'.sprintf('%02d',($bln - 1));
        $periode = $thn.'-'.sprintf('%02d',($bln+1)).'-01';

        //$kode_entity = $this->session->userdata('kode_entity');
        $retval = '';
        $cari_tgl = array('tra.tanggal'=>$periode_lalu);

        //$query = $CI->db->get();
        //echo('<pre>'.$CI->db->last_query().'</pre>');
        if($kelompok_biaya=='BL'){
            //--'41%'
            $sql = "SELECT
                        'BIAYA LANGSUNG' AS grup,
                        thp.kode AS kode_item,
                        thp.nama AS nama_item,
                        sd.kode AS kode_sd,
                        sd.nama AS nama_sd,
                        bl.volume AS ra_vol,
                        bl.volume * hsd.harga_satuan AS ra_harga,
                        bl.volume_rev AS rol_vol,
                        bl.volume_rev * hsd.harga_satuan_review AS rol_harga,
                        SUM(IFNULL( acc.volume, 0) )AS ri_vol,
                        IFNULL( SUM( IF ( acc.dk = 'D', acc.rupiah, (acc.rupiah *- 1) ) ), 0 ) AS ri_harga
                    FROM
                        tr_rab_bl AS bl
                    INNER JOIN mst_tahap AS thp ON thp.kode = bl.kode_tahap
                        AND thp.kode_entity = bl.kode_entity
                    INNER JOIN mst_sumberdaya AS sd ON sd.kode = bl.kode_sumberdaya
                    INNER JOIN mst_harga_sumberdaya AS hsd ON hsd.kode_sumberdaya = sd.kode
                    AND hsd.kode_entity = bl.kode_entity
                    LEFT JOIN (
                        SELECT
                            kode_tahap,
                            kode_sumberdaya,
                            kode_spk,
                            dk,
                            rupiah,
                            volume
                        FROM
                            tr_accounting
                        WHERE
                            tanggal < '$periode'
                        AND kode_tahap IS NOT NULL
                        AND kode_sumberdaya IS NOT NULL
                        AND kode_coa LIKE '411%'
                    ) AS acc ON acc.kode_tahap = bl.kode_tahap
                    AND acc.kode_sumberdaya = bl.kode_sumberdaya
                    AND acc.kode_spk = bl.kode_entity
                    WHERE
                        bl.kode_entity = '$kode_spk'  
                    GROUP BY
                        thp.kode ASC";

        }elseif($kelompok_biaya=='BTL'){
            //-- '48%'
            $sql = "SELECT
                        'BIAYA TIDAK LANGSUNG' AS kelompok_biaya,
                        acc.tanggal AS tanggal,
                        btl.kode_coa AS kode_item,
                        coa.nama AS nama_item,
                        btl.kode_sumberdaya AS kode_sd,
                        sd.nama AS nama_sd,
                        0 AS ra_vol,
                        btl.harga AS ra_harga,
                        0 AS rol_vol,
                        btl.harga_rev AS rol_harga,
                        0 AS ri_vol,
                        IFNULL( SUM( IF ( acc.dk = 'D', acc.rupiah, (acc.rupiah *- 1) ) ), 0 ) AS ri_harga
                    FROM
                        tr_rab_btl AS btl
                    INNER JOIN mst_coa AS coa ON coa.kode = btl.kode_coa
                    LEFT JOIN mst_sumberdaya AS sd ON sd.kode = btl.kode_sumberdaya
                    INNER JOIN tr_accounting acc ON acc.kode_sumberdaya = btl.kode_sumberdaya
                        AND acc.kode_sumberdaya = btl.kode_sumberdaya
                        AND acc.kode_spk = btl.kode_entity

                    WHERE acc.tanggal < '$periode' AND acc.kode_spk = '$kode_spk' AND acc.kode_coa LIKE '481%'
                    GROUP BY
                        btl.kode_coa";
        }
        
        //die('<pre>'.$sql.'</pre>');
        $query = $CI->db->query($sql);
        
        $t_raVol = $t_riVol = 0;
        $t_raHarga =  $t_riHarga = 0;
        $subtot_raVol =  $subtot_riVol = 0;
        $subtot_riHarga = 0;
        $subtot_raHarga = 0;
        $kelompok = '';
        $subtot_raHargaBLBTL = $subtot_riHargaBLBTL = 0;
        $i='A';
        foreach ($query->result() as $row) {
           $ra_vol      = $row->ra_vol;
           $ra_harga    = $row->ra_harga;
           $rol_harga    = $row->rol_harga;
           $ri_harga    = $row->ri_harga;
           $ri_vol      = $row->ri_vol;
           
            $retval .= '<tr id="sub_'.$kelompok_biaya.'" '.$tr_varval.' '.$tr_class.' '.$extra.'>';
            $retval .= '   <td '.$td_idname.' class="text-center">';
            //$retval .= '    '.$i.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; 
            $retval .= '<b>'.$i.'</b>'; 
            $retval .= '   </td>';
            $retval .= '   </td>';
            $retval .= '   <td colspan="8" '.$td_idname.' '.$td_varval.' '.$td_class.'>';
            $retval .= '    &nbsp;&nbsp;<b>'.$row->kode_item.' - '.$row->nama_item.'</b>';
            $retval .= '   </td>';
            $retval .= '</tr>';
            
            $subtot_raVol += $ra_vol;
            $subtot_riVol += $ri_vol;
            $subtot_riHarga += $row->ri_harga;
            $subtot_raHarga += $row->ra_harga;
            $subtot_rolHarga += $row->rol_harga;
            $subtot_riHargaBLBTL += $subtot_riHarga;
            $subtot_raHargaBLBTL += $subtot_raHarga;
            $subtot_rolHargaBLBTL += $subtot_rolHarga;

            $CI->load->helper('generator');
            $retval .=  tr_tahap_rari_detil($kelompok_biaya,$kode_spk,$period,$row->kode_item,'x');
            

            $i++;
        }

        $sql_sum = "
        SELECT
             tmp.grup, sum(tmp.ra_harga) as ra_harga, sum(tmp.rol_harga) as rol_harga, sum(tmp.ri_harga) as ri_harga
            FROM
             (
              SELECT
               'BIAYA LANGSUNG' AS grup,
               thp.kode AS kode_item,
               thp.nama AS nama_item,
               sd.kode AS kode_sd,
               sd.nama AS nama_sd,
               bl.volume AS ra_vol,
               bl.volume*hsd.harga_satuan AS ra_harga,
               bl.volume_rev AS rol_vol,
               bl.volume_rev*hsd.harga_satuan_review AS rol_harga,
               IFNULL(acc.volume,0) AS ri_vol,
               IFNULL(SUM(IF(acc.dk='D',acc.rupiah,(acc.rupiah*-1))),0) AS ri_harga
              FROM
               tr_rab_bl AS bl
               INNER JOIN mst_tahap AS thp ON thp.kode = bl.kode_tahap
                AND thp.kode_entity = bl.kode_entity
               INNER JOIN mst_sumberdaya AS sd ON sd.kode = bl.kode_sumberdaya
               INNER JOIN mst_harga_sumberdaya AS hsd ON hsd.kode_sumberdaya = sd.kode
                AND hsd.kode_entity = bl.kode_entity
               LEFT JOIN (
                SELECT
                 kode_tahap,
                 kode_sumberdaya,
                 kode_spk,
                 dk,
                 rupiah,
                 volume
                FROM
                 tr_accounting
                WHERE
                 tanggal < '$periode'
                 AND kode_tahap IS NOT NULL
                 AND kode_sumberdaya IS NOT NULL
                 AND kode_coa LIKE '411%'
               ) AS acc ON acc.kode_tahap = bl.kode_tahap
                AND acc.kode_sumberdaya = bl.kode_sumberdaya AND acc.kode_spk = bl.kode_entity
              WHERE
               bl.kode_entity = '$kode_spk'
              GROUP BY
               bl.kode_tahap,
               bl.kode_sumberdaya
              UNION ALL
              SELECT
               'BIAYA TIDAK LANGSUNG' AS grup,
               btl.kode_coa AS kode_item,
               coa.nama AS nama_item,
               btl.kode_sumberdaya AS kode_sd,
               sd.nama AS nama_sd,
               0 AS ra_vol,
               btl.harga AS ra_harga,
               0 AS rol_vol,
               btl.harga_rev AS rol_harga,
               0 AS ri_vol,
               IFNULL(SUM(IF(acc.dk='D',acc.rupiah,(acc.rupiah*-1))),0) AS ri_harga
              FROM
               tr_rab_btl AS btl
               LEFT JOIN mst_coa AS coa ON coa.kode = btl.kode_coa
               LEFT JOIN mst_sumberdaya AS sd ON sd.kode = btl.kode_sumberdaya
               LEFT JOIN (
                SELECT
                 kode_coa,
                 kode_sumberdaya,
                 kode_spk,
                 dk,
                 rupiah,
                 volume
                FROM
                 tr_accounting
                WHERE
                 tanggal < '$periode'
                 AND kode_sumberdaya IS NOT NULL
                 AND kode_coa LIKE '481%'
               ) AS acc ON acc.kode_coa = btl.kode_coa
                AND acc.kode_sumberdaya = btl.kode_sumberdaya AND acc.kode_spk = btl.kode_entity
              WHERE
               btl.kode_entity = '$kode_spk'
              GROUP BY
               btl.kode_coa,
               btl.kode_sumberdaya
             ) AS tmp
            GROUP BY tmp.grup
            ORDER BY
             tmp.grup,
             tmp.kode_item,
             tmp.kode_sd";
        //echo $sql_sum;die;
        $qs = $CI->db->query($sql_sum);
        $subtot_raHarga1 = 0;
        $subtot_rolHarga1 = 0;
        $subtot_riHarga1 = 0;
        $grandTotal_ri1 = 0;
        $grandTotal_ra1 = 0;
        foreach ($qs->result() as $row) {
            $subtot_raHarga1 = $row->ra_harga;
            $subtot_rolHarga1 = $row->rol_harga;
            $subtot_riHarga1 = $row->ri_harga;
            $grandTotal_ri1 += $subtot_riHarga1;
            $grandTotal_rol1 += $subtot_rolHarga1;
            $grandTotal_ra1 += $subtot_raHarga1;
            //print_r($row);
            if($kelompok_biaya=='BL'){
                if($row->grup == 'BIAYA LANGSUNG'){
                   $retval .= 
                            '<tr class="bg-info">
                                <td></td>
                                <td colspan="2" class="text-right">SUB TOTAL '.$row->grup.'</td>
                                <td></td>
                                <td class="text-right">'.number_format($subtot_raHarga1).'</td>
                                <td></td>
                                <td class="text-right">'.number_format($subtot_rolHarga1).'</td>
                                <td></td>
                                <td class="text-right">'.number_format($subtot_riHarga1).'</td>
                                <td></td>
                                <td class="text-right">'.number_format($subtot_rolHarga1-$subtot_riHarga1).'</td>
                            </tr>';
                
                }
            }else{
                if($kelompok_biaya=='BTL'){
                    if($row->grup == 'BIAYA TIDAK LANGSUNG'){
                       $retval .= 
                                '<tr class="bg-info">
                                    <td></td>
                                    <td colspan="2" class="text-right">SUB TOTAL '.$row->grup.'</td>
                                    <td></td>
                                    <td class="text-right">'.number_format($subtot_raHarga1).'</td>
                                    <td></td>
                                    <td class="text-right">'.number_format($subtot_rolHarga1).'</td>
                                    <td></td>
                                    <td class="text-right">'.number_format($subtot_riHarga1).'</td>
                                    <td></td>
                                    <td class="text-right">'.number_format($subtot_rolHarga1-$subtot_riHarga1).'</td>
                                </tr>';
                    }
                }
                
            }
        }

        $grandTotal_raHarga = 0;
        $grandTotal_rolHarga = 0;
        $grandTotal_riHarga = 0;
        $grandTotal_raHarga += $subtot_raHargaBLBTL;
        $grandTotal_rolHarga += $subtot_rolHargaBLBTL;
        $grandTotal_riHarga += $subtot_riHargaBLBTL;

        if($kelompok_biaya =='BTL'){
        $retval .= 
                    '<tr class="bg-system">
                        <td></td>
                        <td colspan="2" class="text-right">GRAND TOTAL</td>
                        <td></td>
                        <td class="text-right">'.number_format($grandTotal_ra1).'</td>
                        <td></td>
                        <td class="text-right">'.number_format($grandTotal_rol1).'</td>
                        <td></td>
                        <td class="text-right">'.number_format($grandTotal_ri1).'</td>
                        <td></td>
                        <td class="text-right">'.number_format($grandTotal_ra1-$grandTotal_ri1).'</td>
                    </tr>';
        }
        return $retval;
    }
}

if (! function_exists('tr_tahap_rari_detil')) {
    function tr_tahap_rari_detil($kelompok_biaya, $kode_spk, $period, $kode_item, $tr_idname='', $tr_varval='', $tr_class='', $td_idname='', $td_varval='', $td_class='', $extra='')  {
        //echo $period;die;
        $CI =& get_instance();
        list($bln, $thn) = explode('-', $period);
        $perio_de =  $thn.'-'.sprintf('%02d',$bln);
        $periode_lalu = $thn.'-'.sprintf('%02d',($bln - 1));
        $periode = $thn.'-'.sprintf('%02d',($bln+1)).'-01';

        //$kode_entity = $this->session->userdata('kode_entity');
        $retval = '';
        $cari_tgl = array('tra.tanggal'=>$periode_lalu);

        //$query = $CI->db->get();
        //echo('<pre>'.$CI->db->last_query().'</pre>');
        if($kelompok_biaya=='BL'){
            $sql = "SELECT
                        'BIAYA LANGSUNG' AS grup,
                        thp.kode AS kode_item,
                        thp.nama AS nama_item,
                        sd.kode AS kode_sd,
                        sd.nama AS nama_sd,
                        bl.volume AS ra_vol,
                        bl.volume_rev AS rol_vol,
                        bl.volume_rev * hsd.harga_satuan_review AS rol_harga,
                        bl.volume * hsd.harga_satuan AS ra_harga,
                        SUM(IFNULL( acc.volume, 0) )AS ri_vol,
                        IFNULL( SUM( IF ( acc.dk = 'D', acc.rupiah, (acc.rupiah *- 1) ) ), 0 ) AS ri_harga
                    FROM
                        tr_rab_bl AS bl
                    INNER JOIN mst_tahap AS thp ON thp.kode = bl.kode_tahap
                        AND thp.kode_entity = bl.kode_entity
                    INNER JOIN mst_sumberdaya AS sd ON sd.kode = bl.kode_sumberdaya
                    INNER JOIN mst_harga_sumberdaya AS hsd ON hsd.kode_sumberdaya = sd.kode
                    AND hsd.kode_entity = bl.kode_entity
                    LEFT JOIN (
                        SELECT
                            kode_tahap,
                            kode_sumberdaya,
                            kode_spk,
                            dk,
                            rupiah,
                            volume
                        FROM
                            tr_accounting
                        WHERE
                            tanggal < '$periode'
                        AND kode_tahap IS NOT NULL
                        AND kode_sumberdaya IS NOT NULL
                        AND kode_coa LIKE '411%'
                    ) AS acc ON acc.kode_tahap = bl.kode_tahap
                    AND acc.kode_sumberdaya = bl.kode_sumberdaya
                    AND acc.kode_spk = bl.kode_entity
                    WHERE
                        bl.kode_entity = '$kode_spk' AND thp.kode = '$kode_item'
                    GROUP BY
                        bl.kode_tahap,
                        bl.kode_sumberdaya";

        }elseif($kelompok_biaya=='BTL'){

            $sql = "SELECT
                        'BIAYA TIDAK LANGSUNG' AS grup,
                        btl.kode_coa AS kode_item,
                        coa.nama AS nama_item,
                        btl.kode_sumberdaya AS kode_sd,
                        sd.nama AS nama_sd,
                        0 AS ra_vol,
                        btl.harga AS ra_harga,
                        0 AS rol_vol,
                        btl.harga_rev as rol_harga,
                        0 AS ri_vol,
                        IFNULL( SUM( IF ( acc.dk = 'D', acc.rupiah, (acc.rupiah *- 1) ) ), 0 ) AS ri_harga
                    FROM
                        tr_rab_btl AS btl
                    LEFT JOIN mst_coa AS coa ON coa.kode = btl.kode_coa
                    LEFT JOIN mst_sumberdaya AS sd ON sd.kode = btl.kode_sumberdaya
                    LEFT JOIN (
                        SELECT
                            kode_coa,
                            kode_sumberdaya,
                            kode_spk,
                            dk,
                            rupiah,
                            volume
                        FROM
                            tr_accounting
                        WHERE
                            tanggal < '$periode'
                        AND kode_sumberdaya IS NOT NULL
                        AND kode_coa LIKE '481%'
                    ) AS acc ON acc.kode_coa = btl.kode_coa
                    AND acc.kode_sumberdaya = btl.kode_sumberdaya
                    AND acc.kode_spk = btl.kode_entity
                    WHERE
                        btl.kode_entity = '$kode_spk' AND 
                        btl.kode_coa = '$kode_item'
                    GROUP BY
                        btl.kode_coa,
                        btl.kode_sumberdaya";
            
        }
        
        //print_r('<pre>'.$sql.'</pre>');die;
        $query = $CI->db->query($sql);
        
        $t_raVol = 0;
        $t_rolVol = 0;
        $t_riVol = 0;
        $t_raHarga = 0;
        $t_rolHarga = 0;
        $t_riHarga = 0;
        $subtot_raVol = 0;
        $subtot_rolVol = 0;
        $subtot_riVol = 0;
        $subtot_riHarga = 0;
        $subtot_raHarga = 0;
        $subtot_rolHarga = 0;
        $i=1;
        foreach ($query->result() as $row) {
            $ra_vol         = $row->ra_vol;
            $ra_harga       = $row->ra_harga;
            //---
            $rol_vol        = $row->rol_vol;
            $rol_harga      = $row->rol_harga;
            //--
            $ri_vol         = $row->ri_vol;
            $ri_harga       = $row->ri_harga;
            //--
            $retval .= '<tr id="sub_'.$kelompok_biaya.'" '.$tr_varval.' '.$tr_class.' '.$extra.'>';
            $retval .= '   <td '.$td_idname.' class="text-right">';
            $retval .= '    '.$i.'&nbsp;&nbsp;&nbsp;&nbsp;'; //NOMOR URUT
            $retval .= '   </td>';
            $retval .= '   </td>';
            $retval .= '   <td colspan="2" '.$td_idname.' '.$td_varval.' '.$td_class.'>';
            $retval .= '    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$row->kode_sd.' - '.$row->nama_sd;
            $retval .= '   </td>';
            //Ra
            $retval .= '   <td '.$td_idname.' class="text-right">';
            $retval .= '    '.$ra_vol;
            $retval .= '   </td>';
            $retval .= '   <td '.$td_idname.' class="text-right">';
            $retval .= '    '.number_format($ra_harga);
            $retval .= '   </td>';
             //Rolling
            $retval .= '   <td '.$td_idname.' class="text-right">';
            $retval .= '    '.$rol_vol;
            $retval .= '   </td>';
            $retval .= '   <td '.$td_idname.' class="text-right">';
            $retval .= '    '.number_format($rol_harga);
            $retval .= '   </td>';
            //Ri
            $retval .= '   <td '.$td_idname.' class="text-right">';
            $retval .= '    '.$ri_vol;
            $retval .= '   </td>';
            $retval .= '   <td '.$td_idname.' class="text-right">';
            $retval .= '    '.number_format($ri_harga);
            $retval .= '   </td>';
            //deviasi
            $retval .= '   <td '.$td_idname.' class="text-right">';
            $retval .= '    '.($rol_vol-$ri_vol);
            $retval .= '   </td>';
            $retval .= '   <td '.$td_idname.' class="text-right">';
            $retval .= '    '.number_format($rol_harga-$ri_harga);
            $retval .= '   </td>';
            $retval .= '</tr>';
            
            $subtot_raVol += $ra_vol;
            $subtot_rolVol += $rol_vol;
            $subtot_riVol += $ri_vol;
            $subtot_raHarga += $ra_harga;
            $subtot_rolHarga += $rol_harga;
            $subtot_riHarga += $ri_harga;
            
            $i++;
        }

        $retval .= 
                    '<tr>
                        <td></td>
                        <td colspan="2" class="text-right text-dark">Subtotal</td>
                        <td></td>
                        <td class="text-right text-dark">'.number_format($subtot_raHarga).'</td>
                        <td></td>
                        <td class="text-right text-dark">'.number_format($subtot_rolHarga).'</td>
                        <td></td>
                        <td class="text-right text-dark">'.number_format($subtot_riHarga).'</td>
                        <td></td>
                        <td class="text-right text-dark">'.number_format($subtot_rolHarga-$subtot_riHarga).'</td>
                    </tr>';
        return $retval;
    }
}

/**
 * MDY 2 YMD
 *
 * Mengkonversi format tanggal datepicker
 *
 * @access    public
 * @param    string    tgl
 * @param    string    separator
 * @return   string
 */    
if (! function_exists('draw_os_sisa'))
{
    function draw_os_sisa($tgl_periode, $kd_nasabah, $no_terbit, $modul) 
    {
        list($bln, $thn) = explode('-', $tgl_periode);
        $periode =  $thn.'-'.sprintf('%02d',$bln).'-01';
        $periode_sebelum = $thn.'-'.sprintf('%02d',$bln-1).'-01';

        $sql = "SELECT
                    no_terbit,
                    kode_coa,
                    kode_nasabah,
                    (
                        SUM( IF(dk = f_cek_os_penerbitan (kode_coa),rupiah, 0 ) ) - SUM( IF(dk = f_cek_os_pelunasan (kode_coa), rupiah, 0 ) )
                    ) AS sisa,
                    datediff( LAST_DAY('$periode_sebelum'),  tanggal ) AS umur
                FROM
                        tr_accounting
                INNER JOIN mst_nasabah_konstruksi mn ON mn.kode = tr_accounting.kode_nasabah
                WHERE
                        tanggal <= LAST_DAY('$periode_sebelum')
                AND no_terbit NOT IN ('$no_terbit')
                AND kode_coa = (
                    SELECT kode_coa
                    FROM mst_setting_os
                    WHERE kode_menu = 'rpt-opensystem-$modul'
                )
                GROUP BY
                    kode_nasabah,
                    no_terbit";
        $CI->db->query($sql);
        
        $query = $CI->db->get();

        $data = array();
        foreach ($query->result() as $k => $v) {
            $data[$k] = $v;
        }

        return $data;
    }
}

/**
 * create row report RK
 *
 * @access    public
 * @param    string    tgl
 * @param    string    separator
 * @return   string
 */    
if (! function_exists('row_rpt_rk'))
{
    function row_rpt_rk($tgl_periode, $kode_spk, $nomor_bukti) 
    {
        list($bln, $thn) = explode('-', $tgl_periode);
        $periode =  $thn.'-'.sprintf('%02d',$bln).'-31';
        $periode_sebelum = $thn.'-'.sprintf('%02d',$bln-1).'-01';

        $sql = "SELECT
                    tanggal,
                    acc.kode_spk,
                    acc.no_bukti,
                    keterangan,
                    acc.tr_level,
                    acc.dk,
                    IFNULL(
                        SUM(
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
                        ),
                        0
                    ) AS rp_dept,
                    IFNULL(
                        SUM(
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
                        ),
                        0
                    ) AS rp_pro
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
                                tanggal <= LAST_DAY('$periode')
                            AND kode_divisi = 'V'
                            AND no_terbit <> ''
                            ) AS acc
                        WHERE
                            acc.kode_coa = '21711'
                    ) acc
                GROUP BY
                    acc.kode_spk,
                    no_bukti
                HAVING
                    (rp_dept + rp_pro) <> 0";
        $CI->db->query($sql);
        
        $query = $CI->db->get();

        $data = array();
        foreach ($query->result() as $k => $v) {
            $data[$k] = $v;
        }

        return $data;
    }
}

if (! function_exists('firstDay'))
{
    function firstDay($month = '', $year = '')
    {
        if (empty($month)) {
          $month = date('m');
       }
       if (empty($year)) {
          $year = date('Y');
       }
       $result = strtotime("{$year}-{$month}-01");
       return date('d', $result);
    } 
}
if (! function_exists('firstDayFull'))
{
    function firstDayFull($month = '', $year = '')
    {
        if (empty($month)) {
          $month = date('m');
       }
       if (empty($year)) {
          $year = date('Y');
       }
       $result = strtotime("{$year}-{$month}-01");
       return date('Y-m-d', $result);
    } 
}
if (! function_exists('lastDayFull'))
{
    function lastDayFull($month = '', $year = '') {
       if (empty($month)) {
          $month = date('m');
       }
       if (empty($year)) {
          $year = date('Y');
       }
       $result = strtotime("{$year}-{$month}-01");
       $result = strtotime('-1 second', strtotime('+1 month', $result));
       return date('Y-m-d', $result);
    }
}