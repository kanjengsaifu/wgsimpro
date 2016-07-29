<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


/*
*
*
*/
function sendEmail($from,$to_address,$cc='',$subject,$message,$attachment=array())
{


	foreach ($to_address as $name => $addr)
	{
		$CI =& get_instance();

		$config = Array(
				'protocol' => 'smtp',
				'smtp_host' => 'ssl://mail.wika.co.id',
				'smtp_port' => 465,
				'smtp_user' => 'chairoelz@wika.co.id', 
				'smtp_pass' => 'w1k4ku', 
				'mailtype' => 'html',
				'charset' => 'iso-8859-1',
				'wordwrap' => TRUE
			);


		$CI->load->library('email', $config);
		$CI->email->clear();
		$CI->email->set_newline("\r\n");

		$CI->email->from($from);
		$CI->email->to($addr['address']);
		if(!$cc==''){
			$CI->email->to($cc);
		}
		$CI->email->subject($subject);
		$CI->email->message($message);

		foreach($attachment as $attc => $lampiran){
			$CI->email->attach($lampiran);
		}
		try {
			if (!$CI->email->send()) {
			    show_error($CI->email->print_debugger()); 
			}
			else {
				echo 'Your e-mail has been sent to '.$addr['address'].'<br>';
			}
			
			$CI->load->helper('file');
			$data = array('['.date().'] - '.aaaa)

			if ( !write_file('./logs/mail_logs.txt', $data)){
			echo 'Unable to write the file';
			}
		} catch(Exception $e) {
			return $e->getMessage();
		}
	}
}

/**
 * DMY 2 YMD
 *
 * Mengkonversi format tanggal DMY menjadi YMD
 *
 * @access    public
 * @param    string    tgl
 * @param    string    separator
 * @return   string
 */    
if (! function_exists('DMY2YMD'))
{
    function DMY2YMD($tgl, $separator) 
    {
        $arr = explode($separator, $tgl);
        return sprintf('%s%s%s%s%s', $arr[2], $separator, $arr[1], $separator, $arr[0]);
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
if (! function_exists('MDY2YMD'))
{
    function MDY2YMD($tgl, $separator) 
    {
        $arr = explode($separator, $tgl);
        return sprintf('%s%s%s%s%s', $arr[2], $separator, $arr[0], $separator, $arr[1]);
    }
}

/**
 * YMD 2 DMY
 *
 * Mengkonversi format tanggal YMD menjadi DMY
 *
 * @access    public
 * @param    string    tgl
 * @param    string    separator
 * @return   string
 */    
if (! function_exists('YMD2DMY'))
{
    function YMD2DMY($tgl, $separator) 
    {
        $arr = explode($separator, $tgl);
        if (count($arr)==3) {
            return sprintf('%s%s%s%s%s', $arr[2], $separator, $arr[1], $separator, $arr[0]);
        } else {
            return $tgl;
        }
    }
}

/**
 * Month Num to String
 *
 * @access    public
 * @param    string    bln
 * @param    string    separator
 * @return   string
 */ 
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
				return "Nopember";
				break;
			case 12:
				return "Desember";
				break;
		}
	}
}

/**
 * YMD2Indo
 *
 * Mengkonversi format tanggal YMD menjadi format D MMM YYYY versi Indonesia
 *
 * @access    public
 * @param    string    tgl
 * @param    string    separator
 * @return   string
 */    
if (! function_exists('YMD2Indo')) {
    function YMD2Indo($tgl, $separator) {
        $bul = array(0 => '00', 1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'Nopember', 'Desember');
    	$arr = explode($separator, $tgl);
        return sprintf('%d %s %s', $arr[2]*1, $bul[ $arr[1]*1 ], $arr[0]);
    }
}

/**
 * Day to Indo Day
 *
 * @access    public
 * @param    string    tanggal
 * @param    string    separator
 * @return   string
 */ 
if ( ! function_exists('nama_hari'))
{
	function nama_hari($tanggal)
	{
		$ubah = gmdate($tanggal, time()+60*60*8);
		$pecah = explode("-",$ubah);
		$tgl = $pecah[2];
		$bln = $pecah[1];
		$thn = $pecah[0];

		$nama = date("l", mktime(0,0,0,$bln,$tgl,$thn));
		$nama_hari = "";
		if($nama=="Sunday") {	$nama_hari="Minggu";	}
		else if($nama=="Monday") {$nama_hari="Senin";}
		else if($nama=="Tuesday") {$nama_hari="Selasa";}
		else if($nama=="Wednesday") {$nama_hari="Rabu";}
		else if($nama=="Thursday") {$nama_hari="Kamis";}
		else if($nama=="Friday") {$nama_hari="Jumat";}
		else if($nama=="Saturday") {$nama_hari="Sabtu";}
		return $nama_hari;
	}
}
?>