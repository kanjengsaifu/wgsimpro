<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';
 
class TCPDF_BANK extends TCPDF {
	function __construct()
    {
        parent::__construct();
    }

	public function Header() {
		$this->setJPEGQuality(90);
		//LOGO, JARAK, BATAS DR ATAS, WIDTH IMAGE, HEIGH IMAGE
		$this->Image(base_url().PDF_HEADER_LOGO_WIKA, 8, 8, 40, 0, 'PNG', 'http://www.wika-gedung.co.id');
		//$this->Image(base_url().PDF_HEADER_LOGO_WIKA, 145, 10, 50, 0, 'PNG', 'http://www.wika-gedung.co.id');
		/*$this->ln(3);

		$this->SetFont(PDF_FONT_NAME_MAIN, '', 8);
		$this->Cell(158, 8, '', 0, 0, 'L', 0, '', 0, false, 'T', 'C');
        $this->Cell( 30, 8, 'Untuk Akuntansi', 1, 0, 'C', 0, '', 0, false, 'T', 'C');
        $this->Cell(  8, 8, '', 0, 1, 'L', 0, '', 0, false, 'T', 'C');
        $this->ln(3);
        $this->SetFont(PDF_FONT_NAME_MAIN, '', 6);
        $this->Cell(158, 5, 'PROYEK : ATRIUM EXTENSION SENEN', 0, 0, 'L', 0, '', 0, false, 'T', 'C');
        $this->Cell( 37, 5, 'VERIFIKATOR', 1, 0, 'C', 0, '', 0, false, 'T', 'C');
        $this->ln();
        $this->Cell(158, 8, '', 0, 0, 'L', 0, '', 0, false, 'T', 'C');
        $this->Cell( 10, 8, 'TTD', 1, 0, 'C', 0, '', 0, false, 'T', 'C');
        $this->Cell( 27, 8, '', 1, 1, 'L', 0, '', 0, false, 'T', 'C');
        $this->Cell(158, 5, '', 0, 0, 'L', 0, '', 0, false, 'T', 'C');
        $this->Cell( 10, 5, 'Nama', 1, 0, 'C', 0, '', 0, false, 'T', 'C');
        $this->Cell( 27, 5, '  MULYONO S', 1, 1, 'L', 0, '', 0, false, 'T', 'C');
 */
        /*$this->SetFont(PDF_FONT_NAME_MAIN, '', 7);
        $html = '<table style="width: 40%;" cellpadding="1">
                    <tr>
                        <td class="tengah" style="width: 40%;">&nbsp;VERIFIKATOR</td>
                        <td class="tengah" style="width: 13%;" align="center">111222</td>
                        <td class="tengah" style="width: 13%;" align="center">555111</td>
                        <td class="tengah" style="width: 14%;" align="center">A12331</td>
                        <td class="tengah" style="width: 20%;" align="right">90,000,000,-</td>
                    </tr>
                    <tr>
                        <td class="tengah" style="width: 40%;">&nbsp;VERIFIKATOR</td>
                        <td class="tengah" style="width: 13%;" align="center">111222</td>
                        <td class="tengah" style="width: 13%;" align="center">555111</td>
                        <td class="tengah" style="width: 14%;" align="center">A12331</td>
                        <td class="tengah" style="width: 20%;" align="right">90,000,000,-</td>
                    </tr>
            </table>';
            $this->writeHTML($html, true, false, true, false, '');*/
	}
	public function Footer() {
		$this->SetY(-8);
		$this->SetFont(PDF_FONT_NAME_MAIN, '', 7);
        $this->Cell(0, 0, 'PT. Wijaya Karya Realty :: Akuntansi Keuangan - '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        //$this->setCellPaddings(1, 1, 0, 0);
        /*
		$this->Cell(25, 5, 'Diteliti dan diuji', 1, false, 'C');
		$this->Cell(18, 5, 'Oleh', 1, false, 'C');
		$this->Cell(15, 5, 'Tanggal', 1, false, 'C');
		$this->Cell(20, 5, 'Tanda Tangan', 1, false, 'C');
		$this->ln();
		$this->Cell(25, 10, 'Benar Lengkap Absah', 1, 0, 'C', 0, '', 3, true, 'T', 'M'); 
		$this->Cell(18, 5, 'Keu & Akt', 0, false, 'C');
		$this->Cell(15, 10, ' ', 1, 0, 'C', 0, '', 3, true, 'T', 'M'); 
		$this->Cell(20, 10, ' ', 1, 0, 'C', 0, '', 3, true, 'T', 'M');
		$this->Cell(30, 5, '  [  ] Kontrak/SP3/SPK/PB/Konfirmasi Pesanan', 0, 0, 'L', 0, '', 0, false, 'B', 'M');
		$this->Cell(25, 5, '  [  ] Surat Setoran Pajak', 0, 0, 'L', 0, '', 0, false, 'B', 'M');  
		$this->ln();
		$this->Cell(25, 5, '', 0, 0, 'C', 0, '', 3, true, 'T', 'M'); 
		$this->Cell(18, 5, ' ', 0, 0, 'C', 0, '', 3, true, 'T', 'M'); 
		$this->Cell(15, 5, ' ', 0, 0, 'C', 0, '', 3, true, 'T', 'M'); 
		$this->Cell(20, 5, ' ', 0, 0, 'C', 0, '', 3, true, 'T', 'M'); 
		$this->Cell(25, 5, '  [  ] Kuitansi/Faktur', 0, 0, 'L', 0, '', 0, false, 'B', 'M'); 
		$this->Cell(20, 5, '  [  ] Bukti Pemotongan PPh', 0, 0, 'L', 0, '', 0, false, 'B', 'M'); 
		$this->ln();
		$this->Cell(25, 5, ' ', 0, 0, 'C', 0, '', 3, true, 'B', 'M'); 
		$this->Cell(18, 5, ' MKU ', 1, 0, 'C', 0, '', 3, true, 'B', 'M'); 
		$this->Cell(15, 5, ' ', 1, 0, 'C', 0, '', 3, true, 'B', 'M'); 
		$this->Cell(20, 5, ' ', 1, 0, 'C', 0, '', 3, true, 'B', 'M'); 
		$this->Cell(20, 5, '  [  ] BAST/BAOP/BAPB', 0, 0, 'L', 0, '', 0, false, 'B', 'M'); 
		$this->ln();
		$this->Cell(25, 5, 'Sudah diterima & dibukukan', 1, 0, 'C', 0, '', 0, true, 'B', 'M'); 
		$this->Cell(18, 5, ' DKU ', 1, 0, 'C', 0, '', 3, true, 'B', 'M'); 
		$this->Cell(15, 5, ' ', 1, 0, 'C', 0, '', 3, true, 'B', 'M'); 
		$this->Cell(20, 5, ' ', 1, 0, 'C', 0, '', 3, true, 'B', 'M'); 
		$this->Cell(20, 5, '  [  ] Faktur Pajak', 0, 0, 'L', 0, '', 0, false, 'B', 'M'); 
		$this->ln();
        */
	}
	public function CreateTextBox($textval, $x = 0, $y, $width = 0, $height = 10, $fontsize = 10, $fontstyle = '', $align = 'L') {
		$this->SetXY($x+20, $y); // 20 = margin left
		$this->SetFont(PDF_FONT_NAME_MAIN, $fontstyle, $fontsize);
		$this->Cell($width, $height, $textval, 0, false, $align);
	}
	// Load table data from file
    public function LoadData($file) {
        // Read file lines
        $lines = file($file);
        $data = array();
        foreach($lines as $line) {
            $data[] = explode(';', chop($line));
        }
        return $data;
    }
	// Colored table
    public function ColoredTable($header,$data) {
        // Colors, line width and bold font
        $this->SetFillColor(255, 0, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(0.3);
        $this->SetFont('', 'B');
        // Header
        $w = array(40, 35, 40, 45);
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $fill = 0;
        foreach($data as $row) {
            $this->Cell($w[0], 6, $row[0], 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, $row[1], 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 6, number_format($row[2]), 'LR', 0, 'R', $fill);
            $this->Cell($w[3], 6, number_format($row[3]), 'LR', 0, 'R', $fill);
            $this->Ln();
            $fill=!$fill;
        }
        $this->Cell(array_sum($w), 0, '', 'T');
    }
}

?>