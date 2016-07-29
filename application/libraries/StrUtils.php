<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class StrUtils
{
	
	public function terbilang($x)
	{
	  $abil = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
	  if ($x < 12)
		return " " . $abil[$x];
	  elseif ($x < 20)
		return $this->terbilang($x - 10) . " belas";
	  elseif ($x < 100)
		return $this->terbilang($x / 10) . " Puluh" . $this->terbilang($x % 10);
	  elseif ($x < 200)
		return " seratus" . $this->terbilang($x - 100);
	  elseif ($x < 1000)
		return $this->terbilang($x / 100) . " Ratus" . $this->terbilang($x % 100);
	  elseif ($x < 2000)
		return " seribu" . $this->terbilang($x - 1000);
	  elseif ($x < 1000000)
		return $this->terbilang($x / 1000) . " Ribu" . $this->terbilang($x % 1000);
	  elseif ($x < 1000000000)
		return $this->terbilang($x / 1000000) . " Juta" . $this->terbilang($x % 1000000);
	  elseif ($x < 1000000000000)
		return $this->terbilang($x / 1000000000) . " Milyar" . $this->terbilang($x % 1000000000);
	}

	function rp_terbilang($rp) 
	{
		return $this->terbilang($rp).' Rupiah ';
	}
	
	public function strBulan($x) {
		$strbulan = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'Nopember', 'Desember');
		return substr($x, 0, 1)==='0' ? $strbulan[intval(substr($x,1))] : $strbulan[intval($x)];
	}

	public function strHari($hari) {
		$sepekan=array("Minggu","Senin","Selasa","Rabu","Kamis","Jum'at","Sabtu");
		return $sepekan[$hari];
	}

	public function tgl_Indo($tgl){
		$tanggal = substr($tgl,8,2);
		$bulan = strBulan(substr($tgl,5,2));
		$tahun = substr($tgl,0,4);
		return $tanggal.' '.$bulan.' '.$tahun;
	}

	function strBulanToNumber($bulan){
		$months = array( 1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                 5 => 'Mei',     6 => 'Juni',     7 => 'July',  8 => 'Agustus',
                 9 => 'September', 10 => 'Oktober', 11 => 'Nopember',
                 12 => 'Desember');
		return $months[$bulan];
	}
}