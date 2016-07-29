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

if (! function_exists('cbo_menu')) {
    function cbo_menu($name, $selected, $val_pilih='', $txt_pilih='---Silahkan Pilih---', $class_style='', $extra='')  {
        $CI =& get_instance();
        
        $retval = "<select ".($class_style=="" ? "" : "class=\"$class_style\"")." name=\"$name\" id=\"$name\" $extra>";
        
        $retval .= "<option value=\"".$val_pilih."\">".$txt_pilih."</option>";         
        //Get data 
        $CI->db->where(array('is_active'=>1,'as_sidemenu'=>1));
        $CI->db->where('parent is not null');
        $CI->db->select('kode, judul_menu');
        $CI->db->from('mst_menu');
        $query = $CI->db->get();

        foreach ($query->result() as $row) {
            $retval .= "<option value=\"".$row->kode."\"";
            if ($row->kode==$selected) $retval .= " selected=\"selected\" ";
            $retval .= " >".$row->judul_menu."</option>";
        }
        
        $retval .= "</select>";
        return $retval;
    }
}

if (! function_exists('cbo_entity')) {
    function cbo_entity($name, $selected, $val_pilih='', $txt_pilih='---Silahkan Pilih---', $class_style='', $extra='')  {
        $CI =& get_instance();
        
        $ent_id = $CI->session->userdata('id_entity');
        
        $retval = "<select ".($class_style=="" ? "" : "class=\"$class_style\"")." name=\"$name\" id=\"$name\" $extra>";
        
        if(count($ent_id) > 1)
            $retval .= "<option value=\"".$val_pilih."\">".$txt_pilih."</option>";         
        //Get data 

        if($ent_id!=null)
            $CI->db->where(array('id' => $ent_id));

        $CI->db->select('kode, nama');
        $CI->db->from('mst_entity');
        $query = $CI->db->get();

        foreach ($query->result() as $row) {
            $retval .= "<option value=\"".$row->kode."\"";
            if ($row->kode==$selected) $retval .= " selected=\"selected\" ";
            $retval .= " >".$row->kode." - ".$row->nama."</option>";
        }
        
        $retval .= "</select>";
        return $retval;
    }
}

if (! function_exists('cbo_entity_byRole')) {
    function cbo_entity_byRole($name, $selected, $val_pilih='', $txt_pilih='---Silahkan Pilih---', $class_style='', $extra='')  {
        $CI =& get_instance();
        
        $ent_id = $CI->session->userdata('id_entity');
        
        $retval = "<select ".($class_style=="" ? "" : "class=\"$class_style\"")." name=\"$name\" id=\"$name\" $extra>";
        
        if(count($ent_id) > 1)
            $retval .= "<option value=\"".$val_pilih."\">".$txt_pilih."</option>";         
        //Get data 

        if($ent_id!=null)
            $CI->db->where(array('id' => $ent_id));

        $CI->db->select('kode, nama');
        $CI->db->from('mst_entity');
        $query = $CI->db->get();

        foreach ($query->result() as $row) {
            $retval .= "<option value=\"".$row->kode."\"";
            if ($row->kode==$selected) $retval .= " selected=\"selected\" ";
            $retval .= " >".$row->kode." - ".$row->nama."</option>";
        }
        
        $retval .= "</select>";
        return $retval;
    }
}

if (! function_exists('cbo_group_user')) {
    function cbo_group_user($name, $selected, $val_pilih='', $txt_pilih='---Silahkan Pilih---', $class_style='', $extra='')  {
        $CI =& get_instance();
        
        $retval = "<select ".($class_style=="" ? "" : "class=\"$class_style\"")." name=\"$name\" id=\"$name\" $extra>";
        
        $retval .= "<option value=\"".$val_pilih."\">".$txt_pilih."</option>";         
        //Get data 
        $ent_id = $CI->session->userdata('id_entity');

        $CI->db->where(array('is_aktif'=>1));
        if($ent_id!=null)
           // $CI->db->where(array('entity_id' => $ent_id));

        $CI->db->select('gid, group_name');
        $CI->db->from('mst_user_group');
        $query = $CI->db->get();

        foreach ($query->result() as $row) {
            $retval .= "<option value=\"".$row->gid."\"";
            if ($row->gid==$selected) $retval .= " selected=\"selected\" ";
            $retval .= " >".$row->group_name."</option>";
        }
        
        $retval .= "</select>";
        return $retval;
    }
}

if (! function_exists('show_bukbes')) {
    function show_bukbes($coa, $kd_div, $periode)  {
        $CI =& get_instance();
        
        $period = explode('-', $periode);
        list($b,$t) = explode('-',$periode);
        $ent_id = $CI->session->userdata('id_entity');
        $sql = " SELECT * FROM tr_accounting WHERE kode_coa='".$coa."' AND kode_divisi='".$kd_div."' AND tanggal LIKE '".$t.'-'.$b."%'";
        die('<pre>'.$sql.'</pre>');
        $query = $CI->db->query($sql);
        $res = $query->result();
        foreach ($res as $row) {
            var_dump($row);
        }
        
        return $res;
    }
}

if ( ! function_exists('bulan'))
{
    function bulan($bln)
    {
        switch ($bln)
        {
            case 1:
                return "Januari";
                break;
            case 2:
                return "Februari";
                break;
            case 3:
                return "Maret";
                break;
            case 4:
                return "April";
                break;
            case 5:
                return "Mei";
                break;
            case 6:
                return "Juni";
                break;
            case 7:
                return "Juli";
                break;
            case 8:
                return "Agustus";
                break;
            case 9:
                return "September";
                break;
            case 10:
                return "Oktober";
                break;
            case 11:
                return "November";
                break;
            case 12:
                return "Desember";
                break;
        }
    }
}
//format tanggal yyyy-mm-dd
if ( ! function_exists('tgl_indo'))
{
    function tgl_indo($tgl,$separator)
    {
        $ubah = gmdate($tgl, time()+60*60*8);
        $pecah = explode($separator,$ubah);  //memecah variabel berdasarkan -
        $tanggal = @$pecah[2];
        $bulan = @bulan($pecah[1]);
        $tahun = $pecah[0];
        return $tanggal.' '.$bulan.' '.$tahun; //hasil akhir
    }
}

if (! function_exists('combo_coa')) {
    function combo_coa($name, $selected, $pilih='pilih', $class_style='', $extra='')  {
        $CI =& get_instance();
        
        $retval = "<select ".($class_style=="" ? "" : "class=\"$class_style\"")." name=\"$name\" id=\"$name\" $extra>";
        
        $retval .= "<option value=\"".$pilih."\"> </option>";         
        //Get data 
        $CI->db->from('mst_coa');
        
        $query = $CI->db->get();

        foreach ($query->result() as $row) {
            $retval .= "<option value=\"".$row->kode."\"";
            if ($row->kode==$selected) $retval .= " selected=\"selected\" ";
            $retval .= " >".$row->kode." - ".$row->nama."</option>";
        }
        
        $retval .= "</select>";
        return $retval;
    }
}

if (! function_exists('combo_divisi')) {
    function combo_divisi($name, $selected, $pilih='pilih', $class_style='', $extra='')  {
        $CI =& get_instance();
        
        $retval = "<select ".($class_style=="" ? "" : "class=\"$class_style\"")." name=\"$name\" id=\"$name\" $extra>";
        
        $retval .= "<option value=\"".$pilih."\"> </option>";         
        //Get data 

        $CI->db->where(array('udiv.username'=>$CI->session->userdata('usernm')));
        $CI->db->select("udiv.divisi_level, mdiv.kode, mdiv.nama");
        $CI->db->from('t_user_divisi udiv');
        $CI->db->join("mst_divisi mdiv", "mdiv.kode = udiv.kode_divisi");
        $query = $CI->db->get();

        foreach ($query->result() as $row) {
            $retval .= "<option value=\"".$row->kode."\"";
            if ($row->kode==$selected) $retval .= " selected=\"selected\" ";
            $retval .= " >".$row->kode." - ".$row->nama."</option>";
        }
        
        $retval .= "</select>";
        return $retval;
    }
}

if (! function_exists('cbo_unitkerja')) {
    function cbo_unitkerja($name, $selected, $pilih='pilih', $class_style='', $extra='')  {
        $CI =& get_instance();
        
        $retval = "<select ".($class_style=="" ? "" : "class=\"$class_style\"")." name=\"$name\" id=\"$name\" $extra>";
        
        $retval .= "<option value=\"".""."\">".$pilih."</option>";         
        //Get data 

       // $CI->db->where(array('udiv.username'=>$CI->session->userdata('usernm')));
        $CI->db->select("divisi_level, kode, nama");
        $CI->db->distinct("divisi_level");
        $CI->db->from('mst_divisi'); 
        $CI->db->group_by('divisi_level');
        $query = $CI->db->get();
        //var_dump($query);
        foreach ($query->result() as $row) {
            $retval .= "<option value=\"".$row->divisi_level."\"";
            if ($row->kode==$selected) $retval .= " selected=\"selected\" ";
            $retval .= " >".$row->divisi_level."</option>";
        }
        
        $retval .= "</select>";
        return $retval;
    }
}

if (! function_exists('cbo_kode_jenisjurnal')) {
    function cbo_kode_jenisjurnal($name, $selected, $val_pilih='', $txt_pilih='---Silahkan Pilih---', $class_style='', $extra='')  {
        $CI =& get_instance();
        
        $retval = "<select ".($class_style=="" ? "" : "class=\"$class_style\"")." name=\"$name\" id=\"$name\" $extra>";
        
        $retval .= "<option value=\"".$val_pilih."\">".$txt_pilih."</option>";         
        //Get data 
        $CI->db->select('kode, nama_jenis as nama');
        $CI->db->from('mst_jenis_jurnal');
        $query = $CI->db->get();

        foreach ($query->result() as $row) {
            $retval .= "<option value=\"".$row->kode."\"";
            if ($row->kode==$selected) $retval .= " selected=\"selected\" ";
            $retval .= " >".$row->kode." - ".$row->nama."</option>";
        }
        
        $retval .= "</select>";
        return $retval;
    }
}

if (! function_exists('cbo_bank')) {
    function cbo_bank($name, $selected, $val_pilih='', $txt_pilih='---Silahkan Pilih---', $class_style='', $extra='')  {
        $CI =& get_instance();
        
        $retval = "<select ".($class_style=="" ? "" : "class=\"$class_style\"")." name=\"$name\" id=\"$name\" $extra>";
        
        $retval .= "<option value=\"".$val_pilih."\">".$txt_pilih."</option>";         
        //Get data 
        $CI->db->select('kode, nama, no_rekening');
        $CI->db->from('mst_bank');
        $query = $CI->db->get();

        foreach ($query->result() as $row) {
            $retval .= "<option value=\"".$row->kode."\"";
            if ($row->kode==$selected) $retval .= " selected=\"selected\" ";
            $retval .= " >".$row->kode." - ".$row->nama."</option>";
        }
        
        $retval .= "</select>";
        return $retval;
    }
}

if (! function_exists('cbo_tahap')) {
    function cbo_tahap($name, $selected, $val_pilih='', $txt_pilih='---Silahkan Pilih---', $class_style='', $extra='')  {
        $CI =& get_instance();
        
        $retval = "<select ".($class_style=="" ? "" : "class=\"$class_style\"")." name=\"$name\" id=\"$name\" $extra>";
        
        $retval .= "<option value=\"".$val_pilih."\">".$txt_pilih."</option>";         
        //Get data 
        $CI->db->where(array('kode_entity'=>$CI->session->userdata('kode_entity')));
        $CI->db->select('kode, nama');
        $CI->db->from('mst_tahap');
        $query = $CI->db->get();

        foreach ($query->result() as $row) {
            $retval .= "<option value=\"".$row->kode."\"";
            if ($row->kode==$selected) $retval .= " selected=\"selected\" ";
            $retval .= " >".$row->kode." - ".$row->nama."</option>";
        }
        
        $retval .= "</select>";
        return $retval;
    }
}

if (! function_exists('set_ExistNoBuktiIfThere')) {
    function set_ExistNoBuktiIfThere($no_bukti)  {
        $CI =& get_instance();
        // $CI->load->database();

        $CI->db->where(array('a.no_bukti'=>$no_bukti));
        $CI->db->select('a.no_bukti as no_bukti');
        $CI->db->from('tr_accounting_upload a');
        $CI->db->join('tr_accounting b','b.no_bukti = a.no_bukti');
        $query = $CI->db->get();   

        if ($query->num_rows() > 0)
        {
            $sql = "SELECT f_ceknobukti('".$no_bukti."')";
            $CI->db->query($sql);
        }
    }
}

if (! function_exists('cek_KodeCOA')) {
    function cek_KodeCOA($coa)  {
        $CI =& get_instance();

        $CI->db->where(array('kode'=>$coa));
        $CI->db->select('kode');
        $CI->db->from('mst_coa');
        $query = $CI->db->get();   

        if ($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
}

//format tanggal timestamp
if( ! function_exists('tgl_indo_timestamp')){
    function tgl_indo_timestamp($tgl)
    {
        $inttime=date('Y-m-d H:i:s',$tgl); //mengubah format menjadi tanggal biasa
        $tglBaru=explode(" ",$inttime); //memecah berdasarkan spaasi
         
        $tglBaru1=$tglBaru[0]; //mendapatkan variabel format yyyy-mm-dd
        $tglBaru2=$tglBaru[1]; //mendapatkan fotmat hh:ii:ss
        $tglBarua=explode("-",$tglBaru1); //lalu memecah variabel berdasarkan -
     
        $tgl=$tglBarua[2];
        $bln=$tglBarua[1];
        $thn=$tglBarua[0];
     
        $bln=bulan($bln); //mengganti bulan angka menjadi text dari fungsi bulan
        $ubahTanggal="$tgl $bln $thn | $tglBaru2 "; //hasil akhir tanggal
     
        return $ubahTanggal;
    }
}

function get_SaldoAwalBukBer($coa,$periode)
{
    $CI =& get_instance();
 
    //$CI->db->where(array('kode_coa'=>$coa));
    //$CI->db->select("(SUM(IF(dk='D',rupiah,0))-SUM(IF(dk='K',rupiah,0)))as saldo_awal");
    //$CI->db->from('tr_accounting');
    $sql = "SELECT SUM(IF(dk='D',rupiah,0)-IF(dk='K',rupiah,0))AS saldo_awal 
            FROM tr_accounting 
            WHERE 
                tanggal <= LAST_DAY('$periode') AND kode_coa=".$coa;

    //$CI->db->query($sql);
    $query = $CI->db->query($sql);  

    $res = $query->row_array();

    
    return $res['saldo_awal'];
   
}

function mand_Nasabah($coa,$isian)
{
    $CI =& get_instance();
 
    $CI->db->where(array('kode'=>$coa));
    $CI->db->select('mand_nasabah');
    $CI->db->from('mst_coa');
    $query = $CI->db->get();  

    if ($query->num_rows() > 0)
    {
        $row = $query->row_array(); 
        if($row['mand_nasabah']==1){
            if($isian==null || $isian=='' || empty($isian))
            {
                return false;
            }else{
                return true; 
            }
        }else{ //0
            if($isian==null || $isian=='' || empty($isian))
            {
                return false;
            }else{
                return true; 
            }
        }
    }
}

function mand_Sbdy($coa,$isian)
{
    $CI =& get_instance();

    $CI->db->where(array('kode'=>$coa));
    $CI->db->select('mand_sbd');
    $CI->db->from('mst_coa');
    $query = $CI->db->get();   

    if ($query->num_rows() > 0)
    {
        $row = $query->row_array(); 
        if($row['mand_sbd']==1){
            if($isian==null || $isian=='' || empty($isian))
            {
                return false;
            }else{
                return true; 
            }
        }else{ //0
            if($isian==null || $isian=='' || empty($isian))
            {
                return false;
            }else{
                return true; 
            }
        }
    }
}

function mand_Tahap($coa,$isian)
{
    $CI =& get_instance();

    $CI->db->where(array('kode'=>$coa));
    $CI->db->select('mand_tahap');
    $CI->db->from('mst_coa');
    $query = $CI->db->get();   

    if ($query->num_rows() > 0)
    {
        $row = $query->row_array(); 
        if($row['mand_tahap']==1){
            if($isian==null || $isian=='' || empty($isian))
            {
                return false;
            }else{
                return true; 
            }
        }else{ //0
            if($isian==null || $isian=='' || empty($isian))
            {
                return false;
            }else{
                return true; 
            }
        }
    }
}

function mand_Pajak($coa,$isian)
{
    $CI =& get_instance();

    $CI->db->where(array('kode'=>$coa));
    $CI->db->select('mand_pajak');
    $CI->db->from('mst_coa');
    $query = $CI->db->get();   

    if ($query->num_rows() > 0)
    {
        $row = $query->row_array(); 
        if($row['mand_pajak']==1){
            if($isian==null || $isian=='' || empty($isian))
            {
                return false;
            }else{
                return true; 
            }
        }else{ //0
            if($isian==null || $isian=='' || empty($isian))
            {
                return false;
            }else{
                return true; 
            }
        }
    }
}

function mand_Bank($coa,$isian)
{
    $CI =& get_instance();

    $CI->db->where(array('kode'=>$coa));
    $CI->db->select('mand_bank');
    $CI->db->from('mst_coa');
    $query = $CI->db->get();   

    if ($query->num_rows() > 0)
    {
        $row = $query->row_array(); 
        if($row['mand_bank']==1){
            if($isian==null || $isian=='' || empty($isian))
            {
                return false;
            }else{
                return true; 
            }
        }else{ //0
            if($isian==null || $isian=='' || empty($isian))
            {
                return false;
            }else{
                return true; 
            }
        }
    }
}

function mand_SPK($coa,$isian)
{
    $CI =& get_instance();

    $CI->db->where(array('kode'=>$coa));
    $CI->db->select('mand_spk');
    $CI->db->from('mst_coa');
    $query = $CI->db->get();   

    if ($query->num_rows() > 0)
    {
        $row = $query->row_array(); 
        if($row['mand_spk']==1){
            if($isian==null || $isian=='' || empty($isian))
            {
                return false;
            }else{
                return true; 
            }
        }else{ //0
            if($isian==null || $isian=='' || empty($isian))
            {
                return false;
            }else{
                return true; 
            }
        }
    }
}

function cek_NoBuktiExist($no_bukti)
{
    $CI =& get_instance();

    $CI->db->where(array('no_bukti'=>$no_bukti));
    $CI->db->select('no_bukti');
    $CI->db->from('tr_accounting');
    $query = $CI->db->get();   

    if ($query->num_rows() > 0)
    {
        $row = $query->row_array(); 
        if($row['no_bukti']==$no_bukti){
            if($no_bukti==null || $no_bukti=='' || empty($no_bukti))
            {
                return false;
            }else{
                return true; 
            }
        }else{ //0
            if($no_bukti==null || $no_bukti=='' || empty($no_bukti))
            {
                return false;
            }else{
                return true; 
            }
        }
    }
}

function cek_IsBalance($nobuk,$rp,$dk)
{
    $CI =& get_instance();

    $stmt = '';

    $CI->db->where(array('no_bukti'=>$nobuk));
    $CI->db->select('no_bukti');
    $CI->db->from('tr_accounting');
    $qr_nobuk = $CI->db->get();   

    $CI->db->where(array('no_bukti'=>$nobuk,'dk'=>'D'));
    $CI->db->select('SUM(rupiah) as sum_d');
    $CI->db->from('tr_accounting');
    $qr_bal_d = $CI->db->get();   

    $CI->db->where(array('no_bukti'=>$nobuk,'dk'=>'K'));
    $CI->db->select('SUM(rupiah) as sum_k');
    $CI->db->from('tr_accounting');
    $qr_bal_k = $CI->db->get();  

    if ($qr_nobuk->num_rows() > 0)
    {
        $row = $qr_nobuk->row_array(); 
        $rwd = $qr_bal_d->row_array();
        $rwk = $qr_bal_k->row_array();

        $debit = $rwd->sum_d;
        $kredit = $rwk->sum_k;

        if($row['no_bukti']==$nobuk){
            if($rp==null || $rp=='' || empty($rp))
            {
                return false;
            }else{
                if($debit > $kredit){
                    $stmt = 'DEBIT > KREDIT';
                }elseif($debit<$kredit){
                    $stmt = 'DEBIT < KREDIT';
                }else{
                    $stmt = 'BALANCE';
                }
            }
        }else{ //0
            if($rp==null || $rp=='' || empty($rp))
            {
                return false;
            }else{
                if($debit > $kredit){
                    $stmt = 'DEBIT > KREDIT';
                }elseif($debit<$kredit){
                    $stmt = 'DEBIT < KREDIT';
                }else{
                    $stmt = 'BALANCE';
                }
            }
        }
    }else{
        $stmt = 'BLANK';
    }

    return $stmt;
}


if (! function_exists('cbo_nasabah_ho')) {
    function cbo_nasabah_ho($name, $selected, $val_pilih='', $txt_pilih='---Silahkan Pilih---', $class_style='', $extra='')  {
        $CI =& get_instance();
        
        $ent_id = $CI->session->userdata('id_entity');
        
        $retval = "<select ".($class_style=="" ? "" : "class=\"$class_style\"")." name=\"$name\" id=\"$name\" $extra>";
        
        //if(count($ent_id) > 1)
            $retval .= "<option value=\"".$val_pilih."\">".$txt_pilih."</option>";         

        $CI->db->where(array('ho_bo' => 'HO', 'approved'=>1));
        $CI->db->order_by("nama", "asc"); 
        $CI->db->select('kode, nama');
        $CI->db->from('mst_nasabah_konstruksi');
        $query = $CI->db->get();

        foreach ($query->result() as $row) {
            $retval .= "<option value=\"".$row->kode."\"";
            if ($row->kode==$selected) $retval .= " selected=\"selected\" ";
            $retval .= " >".$row->kode." - ".$row->nama."</option>";
        }
        
        $retval .= "</select>";
        return $retval;
    }
}

if (! function_exists('cbo_agen')) {
    function cbo_agen($name, $selected, $val_pilih='', $txt_pilih='---Silahkan Pilih---', $class_style='', $extra='')  {
        $CI =& get_instance();
        
        $retval = "<select ".($class_style=="" ? "" : "class=\"$class_style\"")." name=\"$name\" id=\"$name\" $extra>";
        
        $retval .= "<option value=\"".$val_pilih."\">".$txt_pilih."</option>";         
        //Get data 
        $CI->db->where(array('is_aktif'=>'Ya'));
        $CI->db->select('kode, nama');
        $CI->db->from('mst_sales');
        $query = $CI->db->get();

        foreach ($query->result() as $row) {
            $retval .= "<option value=\"".$row->kode."\"";
            if ($row->kode==$selected) $retval .= " selected=\"selected\" ";
            $retval .= " >".$row->nama."</option>";
        }
        
        $retval .= "</select>";
        return $retval;
    }
}