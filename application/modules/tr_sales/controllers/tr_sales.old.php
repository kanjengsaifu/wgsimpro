<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPCLASS;

class Tr_sales extends App {
	
	public function __construct() {
		parent::__construct();
			
		$this->load->model('tr_sales_model');
		$this->load->model('../../mst_nasabah/models/mst_nasabah_model');
		$this->load->library('datatables');
		$this->load->library('dateUtils');
		$this->load->library('strUtils');
	}

	public function index() {

	}
	
	public function form_dashboard($id = FALSE) {
		$data = array();
		$data['idmenu'] = 'sales-dashboard';
		$data['content'] = '../../tr_sales/views/dashboard_form';
		$data['datacontent']['units'] = $this->tr_sales_model->get_grouped_unit();
		$data['js'] = '../../tr_sales/views/dashboard_form_js';
		$this->buildView($data);
		// print_r($this->tr_sales_model->get_grouped_unit());
	}

	public function form_hold() {
		$data = array();
		$data['idmenu'] = 'sales-hold';
		$data['content'] = '../../tr_sales/views/hold_form';
		$data['datacontent'] = $this->tr_sales_model->get_customer_optional();
		$data['js'] = '../../tr_sales/views/hold_form_js';
		$this->buildView($data);
	}

	public function form_hold_2($no_unit) {
		$data = array();
		$data['idmenu'] = 'sales-hold';
		$data['content'] = '../../tr_sales/views/hold_form_2';
		$data['datacontent'] = $this->tr_sales_model->get_customer_optional();
		$data['js'] = '../../tr_sales/views/hold_form_js_2';
		$data['datajs']['no_unit'] = $no_unit;
		$this->buildView($data);
	}

	public function form_reserve() {
		$data = array();
		$data['idmenu'] = 'sales-reserve';
		$data['content'] = '../../tr_sales/views/reserve_form';
		$data['datacontent'] = $this->tr_sales_model->get_customer_optional();
		$data['datacontent']['saleses'] = $this->tr_sales_model->get_saleses();
		$data['datacontent']['paymodes'] = $this->tr_sales_model->get_paymodes();
		$data['datacontent']['bankkpr'] = $this->tr_sales_model->get_bank_kpr();
		$data['datacontent']['diskons'] = $this->tr_sales_model->get_diskon();
		$data['js'] = '../../tr_sales/views/reserve_form_js';
		$this->buildView($data);
	}

	public function form_reserve_2($no_unit) {
		$data = array();
		$data['idmenu'] = 'sales-reserve';
		$data['content'] = '../../tr_sales/views/reserve_form_2';
		$data['datacontent'] = $this->tr_sales_model->get_customer_optional();
		$data['datacontent']['saleses'] = $this->tr_sales_model->get_saleses();
		$data['datacontent']['paymodes'] = $this->tr_sales_model->get_paymodes();
		$data['datacontent']['bankkpr'] = $this->tr_sales_model->get_bank_kpr();
		$data['datacontent']['diskons'] = $this->tr_sales_model->get_diskon();
		$data['js'] = '../../tr_sales/views/reserve_form_js_2';
		$data['datajs']['no_unit'] = $no_unit;
		$this->buildView($data);
	}

	public function form_booking() {
		$data = array();
		$data['idmenu'] = 'sales-booking';
		$data['content'] = '../../tr_sales/views/booking_form';
		$data['datacontent'] = $this->tr_sales_model->get_customer_optional();
		$data['datacontent']['saleses'] = $this->tr_sales_model->get_saleses();
		$data['datacontent']['paymodes'] = $this->tr_sales_model->get_paymodes();
		$data['datacontent']['bankkpr'] = $this->tr_sales_model->get_bank_kpr();
		$data['datacontent']['diskons'] = $this->tr_sales_model->get_diskon();
		$data['js'] = '../../tr_sales/views/booking_form_js';
		$this->buildView($data);
	}

	public function form_booking_2($no_unit) {
		$data = array();
		$data['idmenu'] = 'sales-booking';
		$data['content'] = '../../tr_sales/views/booking_form_2';
		$data['datacontent'] = $this->tr_sales_model->get_customer_optional();
		$data['datacontent']['saleses'] = $this->tr_sales_model->get_saleses();
		$data['datacontent']['paymodes'] = $this->tr_sales_model->get_paymodes();
		$data['datacontent']['bankkpr'] = $this->tr_sales_model->get_bank_kpr();
		$data['datacontent']['diskons'] = $this->tr_sales_model->get_diskon();
		$data['js'] = '../../tr_sales/views/booking_form_js_2';
		$data['datajs']['no_unit'] = $no_unit;
		$this->buildView($data);
	}

	public function form_confirm_payment() {
		$data = array();
		$data['idmenu'] = 'confirm-payment';
		$data['content'] = '../../tr_sales/views/confirm_payment';
		$data['js'] = '../../tr_sales/views/confirm_payment_js';
		$this->buildView($data);
	}

	public function form_cancellation() {
		$data = array();
		$data['idmenu'] = 'sales-cancel';
		$data['content'] = '../../tr_sales/views/cancel_sales';
		$data['js'] = '../../tr_sales/views/cancel_sales_js';
		$this->buildView($data);
	}

	public function form_change_owner() {
		$data = array();
		$data['idmenu'] = 'sales-change-owner';
		$data['content'] = '../../tr_sales/views/change_customer';
		$data['datacontent'] = $this->tr_sales_model->get_customer_optional();
		$data['js'] = '../../tr_sales/views/change_customer_js';
		$this->buildView($data);
	}

	public function form_change_unit() {
		$data = array();
		$data['idmenu'] = 'sales-change-unit';
		$data['content'] = '../../tr_sales/views/change_unit';
		$data['datacontent']['saleses'] = $this->tr_sales_model->get_saleses();
		$data['datacontent']['paymodes'] = $this->tr_sales_model->get_paymodes();
		$data['datacontent']['bankkpr'] = $this->tr_sales_model->get_bank_kpr();
		$data['js'] = '../../tr_sales/views/change_unit_js';
		$this->buildView($data);
	}

	public function get_groupby($groupby) {
		$this->output->set_content_type('application/json');
		echo json_encode($this->tr_sales_model->get_groupby($groupby));
	}

	public function get_filterby($groupby, $filterby) {
		$this->output->set_content_type('application/json');
		echo json_encode($this->tr_sales_model->get_filterby($groupby, $filterby));
	}

	public function get_unit($no_unit) {
		// $this->output->enable_profiler(TRUE);
		// $this->tr_sales_model->get_unit($no_unit);
		$this->output->set_content_type('application/json');
		echo json_encode($this->tr_sales_model->get_unit($no_unit));
	}

	public function get_payment_plan($cara) {
		$this->output->set_content_type('application/json');
		echo json_encode($this->tr_sales_model->get_payment_plan($cara));
	}

	public function get_payment_mode($kode) {
		$this->output->set_content_type('application/json');
		echo json_encode($this->tr_sales_model->get_payment_mode($kode));
	}

	public function get_reserve($no_unit) {
		$this->output->set_content_type('application/json');
		echo json_encode($this->tr_sales_model->get_reserve($no_unit));
	}

	public function genDT_stock($status_tr = FALSE) {
		$this->datatables->select('MD5(s.no_unit) AS xnounit, s.no_unit AS no_unit,stypep.konten AS type_property,stypeu.konten AS type_unit,'.
					'stower.konten AS tower_cluster,s.wide_netto AS wide_netto,s.wide_gross AS wide_gross,slantai.konten AS lantai_blok,sdir.konten AS direction',FALSE)
			->unset_column('xnounit')
			->from('mst_stock s')
			->join('mst_optional_stock stypep', 'stypep.kode = s.type_property AND stypep.sfield = "type_property" AND stypep.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->join('mst_optional_stock stower', 'stower.kode = s.tower_cluster AND stower.sfield = "tower_cluster" AND stower.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->join('mst_optional_stock stypeu', 'stypeu.kode = s.type_unit AND stypeu.sfield = "type_unit" AND stypeu.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->join('mst_optional_stock slantai', 'slantai.kode = s.lantai_blok AND slantai.sfield = "lantai_blok" AND slantai.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->join('mst_optional_stock sdir', 'sdir.kode = s.mata_angin AND sdir.sfield = "mata_angin" AND sdir.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->where('s.kode_entity = "'.$this->session->userdata('kode_entity').'" AND s.no_unit NOT IN (SELECT no_unit FROM tr_payment WHERE iscancelled = 0)')
			->add_column('action', '<a href="javascript:" class="row-unit" data-encunit="$1" data-unit="$2"><span class="glyphicons glyphicons-check"></span> View</a>', 
					'xnounit,no_unit');
		echo $this->datatables->generate();
	}

	public function genDT_hold($status_tr = FALSE) {
		$this->datatables->select('MD5(s.no_unit) AS xnounit, s.no_unit AS no_unit,pay.kode_nasabah AS kode_nasabah, mnas.nama as nama_customer, stypep.konten AS type_property,stypeu.konten AS type_unit,'.
					'stower.konten AS tower_cluster,s.wide_netto AS wide_netto,s.wide_gross AS wide_gross,slantai.konten AS lantai_blok,'.
					'sdir.konten AS direction,DATE_FORMAT(hold_date,"%d/%m/%Y"), CONCAT(DATEDIFF(NOW(),hold_date)," hari"),pay.hold_extend AS isextend',FALSE)
			->unset_column('xnounit')
			->unset_column('isextend')
			->unset_column('kode_nasabah')
			->from('mst_stock s')
			->join('tr_payment pay', 'pay.no_unit = s.no_unit AND pay.iscancelled = 0 AND pay.status_tr = "HOLD"', 'inner')
			->join('mst_nasabah mnas', 'mnas.kode = pay.kode_nasabah', 'left')
			->join('mst_optional_stock stypep', 'stypep.kode = s.type_property AND stypep.sfield = "type_property" AND stypep.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->join('mst_optional_stock stower', 'stower.kode = s.tower_cluster AND stower.sfield = "tower_cluster" AND stower.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->join('mst_optional_stock stypeu', 'stypeu.kode = s.type_unit AND stypeu.sfield = "type_unit" AND stypeu.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->join('mst_optional_stock slantai', 'slantai.kode = s.lantai_blok AND slantai.sfield = "lantai_blok" AND slantai.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->join('mst_optional_stock sdir', 'sdir.kode = s.direction AND sdir.sfield = "direction" AND sdir.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->where('s.kode_entity = "'.$this->session->userdata('kode_entity').'" ')
			->add_column('action', '<a href="javascript:" data-encunit="$1" data-extend="$2" class="row-extend"><span class="label label-info">Extend</span></a>&nbsp;&nbsp;'.
					'<a href="javascript:" data-encunit="$1" class="row-cancel"><span class="label label-danger">Cancel</span></a>', 
					'xnounit,isextend');
		echo $this->datatables->generate();
	}

	public function genDT_reserve($status_tr = FALSE) {
		$this->datatables->select('MD5(s.no_unit) AS xnounit, s.no_unit AS no_unit, pay.kode_nasabah AS kode_nasabah, mnas.nama as nama_customer, stypep.konten AS type_property,stypeu.konten AS type_unit,'.
					'stower.konten AS tower_cluster,s.wide_netto AS wide_netto,s.wide_gross AS wide_gross,slantai.konten AS lantai_blok,'.
					'sdir.konten AS direction,DATE_FORMAT(hold_date,"%d/%m/%Y") AS hold_date, CONCAT(DATEDIFF(NOW(),hold_date)," hari") AS umur',FALSE)
			->unset_column('xnounit')
			->unset_column('kode_nasabah')
			->from('mst_stock s')
			->join('tr_payment pay', 'pay.no_unit = s.no_unit AND pay.iscancelled = 0 AND pay.status_tr = "HOLD"', 'inner')
			->join('mst_nasabah mnas', 'mnas.kode = pay.kode_nasabah', 'left')
			->join('mst_optional_stock stypep', 'stypep.kode = s.type_property AND stypep.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->join('mst_optional_stock stower', 'stower.kode = s.tower_cluster AND stower.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->join('mst_optional_stock stypeu', 'stypeu.kode = s.type_unit AND stypeu.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->join('mst_optional_stock slantai', 'slantai.kode = s.lantai_blok AND slantai.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->join('mst_optional_stock sdir', 'sdir.kode = s.direction AND sdir.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->where('s.kode_entity = "'.$this->session->userdata('kode_entity').'" ')
			->add_column('action', '<a href="javascript:" class="row-unit" data-encunit="$1" data-unit="$2"><span class="glyphicons glyphicons-check"></span> View</a>', 
					'xnounit,no_unit');
		echo $this->datatables->generate();
	}

	public function genDT_booking($status_tr = FALSE) {
		$this->datatables->select('MD5(s.no_unit) AS xnounit, s.no_unit AS no_unit, pay.kode_nasabah AS kode_nasabah, mnas.nama as nama_customer, stypep.konten AS type_property,stypeu.konten AS type_unit,'.
					'stower.konten AS tower_cluster,s.wide_netto AS wide_netto,s.wide_gross AS wide_gross,slantai.konten AS lantai_blok,'.
					'sdir.konten AS direction,DATE_FORMAT(reserve_date,"%d/%m/%Y") AS reserve_date, CONCAT(DATEDIFF(NOW(),reserve_date)," hari") AS umur',FALSE)
			->unset_column('xnounit')
			->unset_column('kode_nasabah')
			->from('mst_stock s')
			->join('tr_payment pay', 'pay.no_unit = s.no_unit AND pay.iscancelled = 0 AND pay.status_tr = "RESERVE"', 'inner')
			->join('mst_nasabah mnas', 'mnas.kode = pay.kode_nasabah', 'left')
			->join('mst_optional_stock stypep', 'stypep.kode = s.type_property AND stypep.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->join('mst_optional_stock stower', 'stower.kode = s.tower_cluster AND stower.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->join('mst_optional_stock stypeu', 'stypeu.kode = s.type_unit AND stypeu.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->join('mst_optional_stock slantai', 'slantai.kode = s.lantai_blok AND slantai.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->join('mst_optional_stock sdir', 'sdir.kode = s.mata_angin AND sdir.sfield = "mata_angin" AND sdir.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->where('s.kode_entity = "'.$this->session->userdata('kode_entity').'" ')
			->add_column('action', '<a href="javascript:" class="row-unit" data-encunit="$1" data-unit="$2"><span class="glyphicons glyphicons-check"></span> View</a>', 
					'xnounit,no_unit'); //'sdir.sfield = "mata_angin" AND sdir.kode = s.mata_angin
		echo $this->datatables->generate();
	}

	public function genDT_confirm_payment() {
		$this->datatables->select('stk.no_unit, nsb.nama, stk.lantai_blok, CONCAT(stk.wide_netto," m&sup2;"), CONCAT(stk.wide_gross," m&sup2;"), FORMAT(pay.harga_unit,0) AS harga_unit, '.
				'pay.reserve_no, DATE_FORMAT(reserve_date,"%d/%m/%Y"), /*CONCAT(DATEDIFF(NOW(),reserve_date)," hari")*/ CASE WHEN pay.status_tr="SALES" THEN "PESANAN" ELSE pay.status_tr END', FALSE)
			->from('tr_payment AS pay')
			->join('mst_nasabah AS nsb', 'nsb.kode=pay.kode_nasabah AND nsb.jenis="CUSTOMER"', 'inner')
			->join('mst_stock AS stk', 'stk.no_unit=pay.no_unit AND stk.kode_entity = "'.$this->session->userdata('kode_entity').'"', 'inner')
			->where('pay.iscancelled = 0 AND pay.status_tr <> "HOLD" AND pay.kode_entity = "'.$this->session->userdata('kode_entity').'"')
			->add_column('action', 
					'<a data-resno="$1" href="javascript:" class="row-data"><span class="label label-alert">'.
					'<span class="glyphicons glyphicons-check"></span> view</span></a>', 'pay.reserve_no');
		echo $this->datatables->generate();
	}

	public function get_payment_details($reserve_no) {
		$this->output->set_content_type('application/json');
		echo json_encode($this->tr_sales_model->get_payment_details($reserve_no));
	}

	public function get_reserve_payment_det($mode) {
		$this->output->set_content_type('application/json');
		echo json_encode($this->tr_sales_model->get_payment_plan_3($mode));
	}

	public function get_saved_payment($res_no, $cara_bayar, $kode_pay, $plan = 'PLAN1') {
		$this->output->set_content_type('application/json');
		echo json_encode($this->tr_sales_model->get_saved_payment($res_no, $cara_bayar, $kode_pay, $plan = 'PLAN1'));
	}

	public function get_reserve_and_payment_data($res_no) {
		$this->output->set_content_type('application/json');
		echo json_encode($this->tr_sales_model->get_reserve_and_payment_data($res_no));
	}

	public function pdf_kwitansi($no_kwitansi) {
		$data = $this->tr_sales_model->get_kwitansi($no_kwitansi);
		if(isset($data['no_kwitansi'])) {
			$this->load->library('Pdf');
			list($d,$m,$y) = explode('-', $data['tgl_bayar']);
			$bulan = $this->strutils->strBulan($m);
			// pdf settings
			$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
			$pdf->SetTitle('KUITANSI');
			$pdf->SetMargins(10,10,10);
			$pdf->setPrintHeader(false);
			$pdf->setPrintFooter(false);
			$pdf->SetAutoPageBreak(true);
			$pdf->SetAuthor('PT. WIJAYA KARYA REALTY');
			$pdf->SetDisplayMode('real', 'default');
			$pdf->setCellPaddings(0,0,0,0);
			$pdf->setCellMargins(0,0,0,0);
			// start print asli
			// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)
			$pdf->AddPage();
			$pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
			$pdf->Ln(1);
			$pdf->SetFont('times', 'B', '8');
			$pdf->MultiCell(140, 1, ' ', 0, 'L', 0, 0);
			$pdf->MultiCell(100, 1, 'PT. WIKA REALTY', 0, 'L');
			$pdf->SetFont('times', '', '8');
			$pdf->MultiCell(140, 1, ' ', 0, 'L', 0, 0);
			$pdf->MultiCell(100, 1, 'Menara Bidakara 1 Lt. 18', 0, 'L');
			$pdf->MultiCell(140, 1, ' ', 0, 'L', 0, 0);
			$pdf->MultiCell(100, 1, 'Jl. Jend. Gatot Subroto Kav. 71 - 73', 0, 'L');
			$pdf->MultiCell(140, 1, ' ', 0, 'L', 0, 0);
			$pdf->MultiCell(100, 1, 'Pancoran - Jakarta 12870', 0, 'L');
			$pdf->Ln(2);
			$pdf->SetFont('times', 'B', '14');
			$pdf->MultiCell(190, 1, 'KUITANSI', 0, 'C');
			$pdf->Ln(2);
			$pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
			$pdf->Ln(2);
			// content asli
			$pdf->SetFont('times', '', '10');
			$pdf->MultiCell(35, 1, 'No. Kuitansi', 0, 'L', 0, 0);
			$pdf->MultiCell(3, 1, ':', 0, 'L', 0, 0);
			$pdf->MultiCell(140, 1, $data['no_kwitansi'], 0, 'L', 0, 0);
			$pdf->MultiCell(30, 1, 'Asli', 0, 'L');
			$pdf->MultiCell(35, 1, 'Sudah Diterima dari', 0, 'L', 0, 0);
			$pdf->MultiCell(3, 1, ':', 0, 'L', 0, 0);
			$pdf->MultiCell(100, 1, strtoupper($data['nama']), 0, 'L');
			$pdf->MultiCell(35, 1, 'Sejumlah', 0, 'L', 0, 0);
			$pdf->MultiCell(3, 1, ':', 0, 'L', 0, 0);
			$pdf->MultiCell(100, 1, 'Rp. '.$data['rp'], 0, 'L');
			$pdf->MultiCell(35, 1, 'Terbilang', 0, 'L', 0, 0);
			$pdf->MultiCell(3, 1, ':', 0, 'L', 0, 0);
			$pdf->MultiCell(150, 1, '#'.$data['terbilang'].'Rupiah #', 0, 'L');
			$pdf->MultiCell(35, 1, 'Untuk Pembayaran', 0, 'L', 0, 0);
			$pdf->MultiCell(3, 1, ':', 0, 'L', 0, 0);
			foreach ($data['pays'] as $k => $v) {
				if($k>0) {
					$pdf->MultiCell(35, 1, ' ', 0, 'L', 0, 0);
					$pdf->MultiCell(3, 1, ' ', 0, 'L', 0, 0);
				}
				$pdf->MultiCell(100, 1, $v['nama'].' - '.$v['rp'], 0, 'L');
			}
			$pdf->MultiCell(35, 1, 'No. Unit', 0, 'L', 0, 0);
			$pdf->MultiCell(3, 1, ':', 0, 'L', 0, 0);
			$pdf->MultiCell(100, 1, $data['no_unit'], 0, 'L');
			$pdf->Ln(8);
			// footer
			$pdf->MultiCell(140, 1, 'Keterangan : Ini merupakan kuitansi asli dari '.ucwords($data['nama_entity']), 0, 'L', 0, 0);
			$pdf->MultiCell(100, 1, $data['kota_marketing'].', '.$d.' '.$bulan.' '.$y, 0, 'L');
			$pdf->MultiCell(140, 1, 'untuk pembayaran selanjutnya ditransfer ke Rek Mandiri 130-0042000-888, BCA 2273004225', 0, 'L', 0, 0);
			$pdf->MultiCell(100, 1, 'PT. WIKA REALTY', 0, 'L');
			$pdf->MultiCell(140, 1, 'a.n Wijaya Karya Realty', 0, 'L', 0, 0);
			$pdf->SetFont('times', '', '8');
			$pdf->MultiCell(100, 1, ucwords($data['nama_entity']), 0, 'L');
			$pdf->SetFont('times', '', '10');
			$pdf->Ln(30);
			$pdf->MultiCell(135, 1, 'Pembayaran dengan bilyet Giro / Cek diakui sah sebagai pembayaran Bilyet Giro / Cek tersebut telah cair dalam rekening Bank kami.', 1, 'L', 0, 0);
			$pdf->MultiCell(5, 1, '', 0, 'L', 0, 0);
			$pdf->SetFont('times', 'BU', '10');
			$pdf->MultiCell(100, 1, $data['mgr_proyek'], 0, 'L');
			$pdf->SetFont('times', '', '10');
			$pdf->MultiCell(140, 1, '', 0, 'L', 0, 0);
			$pdf->MultiCell(100, 1, 'Manager Realty', 0, 'L');
			$pdf->Ln(8);
			$pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
			$pdf->Ln(8);
			// header copy
			$pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
			$pdf->Ln(1);
			$pdf->SetFont('times', 'B', '8');
			$pdf->MultiCell(140, 1, ' ', 0, 'L', 0, 0);
			$pdf->MultiCell(100, 1, 'PT. WIKA REALTY', 0, 'L');
			$pdf->SetFont('times', '', '8');
			$pdf->MultiCell(140, 1, ' ', 0, 'L', 0, 0);
			$pdf->MultiCell(100, 1, 'Menara Bidakara 1 Lt. 18', 0, 'L');
			$pdf->MultiCell(140, 1, ' ', 0, 'L', 0, 0);
			$pdf->MultiCell(100, 1, 'Jl. Jend. Gatot Subroto Kav. 71 - 73', 0, 'L');
			$pdf->MultiCell(140, 1, ' ', 0, 'L', 0, 0);
			$pdf->MultiCell(100, 1, 'Pancoran - Jakarta 12870', 0, 'L');
			$pdf->Ln(2);
			$pdf->SetFont('times', 'B', '14');
			$pdf->MultiCell(190, 1, 'KUITANSI', 0, 'C');
			$pdf->Ln(2);
			$pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
			$pdf->Ln(2);
			// content copy
			$pdf->SetFont('times', '', '10');
			$pdf->MultiCell(35, 1, 'No. Kuitansi', 0, 'L', 0, 0);
			$pdf->MultiCell(3, 1, ':', 0, 'L', 0, 0);
			$pdf->MultiCell(140, 1, $data['no_kwitansi'], 0, 'L', 0, 0);
			$pdf->MultiCell(30, 1, 'Copy', 0, 'L');
			$pdf->MultiCell(35, 1, 'Sudah Diterima dari', 0, 'L', 0, 0);
			$pdf->MultiCell(3, 1, ':', 0, 'L', 0, 0);
			$pdf->MultiCell(100, 1, strtoupper($data['nama']), 0, 'L');
			$pdf->MultiCell(35, 1, 'Sejumlah', 0, 'L', 0, 0);
			$pdf->MultiCell(3, 1, ':', 0, 'L', 0, 0);
			$pdf->MultiCell(100, 1, 'Rp. '.$data['rp'], 0, 'L');
			$pdf->MultiCell(35, 1, 'Terbilang', 0, 'L', 0, 0);
			$pdf->MultiCell(3, 1, ':', 0, 'L', 0, 0);
			$pdf->MultiCell(150, 1, '#'.$data['terbilang'].'Rupiah #', 0, 'L');
			$pdf->MultiCell(35, 1, 'Untuk Pembayaran', 0, 'L', 0, 0);
			$pdf->MultiCell(3, 1, ':', 0, 'L', 0, 0);
			foreach ($data['pays'] as $k => $v) {
				if($k>0) {
					$pdf->MultiCell(35, 1, ' ', 0, 'L', 0, 0);
					$pdf->MultiCell(3, 1, ' ', 0, 'L', 0, 0);
				}
				$pdf->MultiCell(100, 1, $v['nama'].' - '.$v['rp'], 0, 'L');
			}
			$pdf->MultiCell(35, 1, 'No. Unit', 0, 'L', 0, 0);
			$pdf->MultiCell(3, 1, ':', 0, 'L', 0, 0);
			$pdf->MultiCell(100, 1, $data['no_unit'], 0, 'L');
			$pdf->Ln(8);
			// footer
			$pdf->MultiCell(140, 1, 'Keterangan : Ini merupakan kuitansi asli dari '.ucwords($data['nama_entity']), 0, 'L', 0, 0);
			$pdf->MultiCell(100, 1, $data['kota_marketing'].', '.$d.' '.$bulan.' '.$y, 0, 'L');
			$pdf->MultiCell(140, 1, 'untuk pembayaran selanjutnya ditransfer ke Rek Mandiri 130-0042000-888, BCA 2273004225', 0, 'L', 0, 0);
			$pdf->MultiCell(100, 1, 'PT. WIKA REALTY', 0, 'L');
			$pdf->MultiCell(140, 1, 'a.n Wijaya Karya Realty', 0, 'L', 0, 0);
			$pdf->SetFont('times', '', '8');
			$pdf->MultiCell(100, 1, ucwords($data['nama_entity']), 0, 'L');
			$pdf->SetFont('times', '', '10');
			$pdf->Ln(30);
			$pdf->MultiCell(135, 1, 'Pembayaran dengan bilyet Giro / Cek diakui sah sebagai pembayaran Bilyet Giro / Cek tersebut telah cair dalam rekening Bank kami.', 1, 'L', 0, 0);
			$pdf->MultiCell(5, 1, '', 0, 'L', 0, 0);
			$pdf->SetFont('times', 'BU', '10');
			$pdf->MultiCell(100, 1, $data['mgr_proyek'], 0, 'L');
			$pdf->SetFont('times', '', '10');
			$pdf->MultiCell(140, 1, '', 0, 'L', 0, 0);
			$pdf->MultiCell(100, 1, 'Manager Realty', 0, 'L');
			$pdf->Ln(8);
			$pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
			// send output
			$pdf->Output('kuitansi-'.date('Ymd').'.pdf', 'D');
		} else {
			echo 'Data tidak tersedia.';
		}
	}

	public function save_hold() {
		// $this->output->enable_profiler(TRUE);
		$res_no = $this->input->post('reserve_no') ? $this->input->post('reserve_no') : $this->tr_sales_model->gen_reserve_no($this->input->post('no_unit'));
		$kode = $this->input->post('kode') ? $this->input->post('kode') : $this->mst_nasabah_model->gen_kode_nasabah($this->input->post('no_unit'));
		$payment = array(
			'cara_bayar'=>'',
			'kode_pay'=>'',
			'kode_entity'=>$this->session->userdata('kode_entity'),
			'no_unit'=>$this->input->post('no_unit'),
			'kode_nasabah'=>$kode,
			'reserve_no'=>$res_no,
			'hold_date'=>$this->input->post('hold_date'),
			'status_tr'=>$this->input->post('status_tr')
		);

		$customer = array(
			'jenis'=>'CUSTOMER',
			'kode'=>$kode,
			'klasifikasi'=>$this->input->post('klasifikasi'),
			'salutation'=>$this->input->post('salutation'),
			'nama'=>$this->input->post('nama'),
			'jenis_id'=>$this->input->post('jenis_id'),
			'no_id'=>$this->input->post('no_id'),
			'npwp'=>$this->input->post('npwp'),
			'email'=>$this->input->post('email'),
			'hp'=>$this->input->post('hp'),
			'tempat_lahir'=>$this->input->post('tempat_lahir'),
			'tgl_lahir'=>$this->dateutils->dateStr_to_mysql($this->input->post('tgl_lahir')),
			'nationality'=>$this->input->post('nationality'),
			'agama'=>$this->input->post('agama'),
			'jk'=>$this->input->post('jk'),
			'nama_perusahaan'=>$this->input->post('nama_perusahaan'),
			'alamat_perusahaan'=>$this->input->post('alamat_perusahaan'),
			// 'kota_perusahaan'=>$this->input->post('kota_perusahaan'),
			// 'kodepos_perusahaan'=>$this->input->post('kodepos_perusahaan'),
			// 'telp_perusahaan'=>$this->input->post('telp_perusahaan'),
			// 'fax_perusahaan'=>$this->input->post('fax_perusahaan'),
			// 'jenis_pekerjaan'=>$this->input->post('jenis_pekerjaan'),
			// 'status_pekerjaan'=>$this->input->post('status_pekerjaan'),
			// 'lama_bekerja'=>$this->input->post('lama_bekerja'),
			// 'jenis_usaha'=>$this->input->post('jenis_usaha'),
			// 'jabatan'=>$this->input->post('jabatan'),
			// 'pendapatan'=>$this->input->post('pendapatan'),
			// 'sumber_pendapatan_tambahan'=>$this->input->post('sumber_pendapatan_tambahan'),
			// 'pendapatan_tambahan'=>$this->input->post('pendapatan_tambahan')
		);

		$dataAlamat = array();
		$alamats = $this->input->post('alamat');
		$kotas = $this->input->post('kota');
		$kodepos = $this->input->post('kodepos');
		$telps = $this->input->post('telp');
		$faxs = $this->input->post('fax');
		foreach ($alamats as $k => $v) {
			$item = array(
				'kode_nasabah' => $kode,
				'alamat' => $alamats[$k],
				'kota' => $kotas[$k],
				'kodepos' => $kodepos[$k],
				'telp' => $telps[$k],
				'fax' => $faxs[$k]
			);
			$dataAlamat[] = $item;
		}
		$idxAlamat = $this->input->post('idx-alamat');

		$res = $this->tr_sales_model->save_hold($payment, $customer, $dataAlamat, $idxAlamat);
		
		$out = array();
		// if($res) {
			$out['status'] = '200';
			$out['msg'] = "Data tersimpan.\nKode Customer: $kode.";
		// } else {
			// $out['status'] = '500';
			// $out['msg'] = "Terjadi kesalahan, silahkan kontak administrator.";
		// }
		$this->output->set_content_type('application/json');
		echo json_encode($out);
	}

	public function extend_hold($no_unit) {
		$res = $this->tr_sales_model->extend_hold($no_unit);
		if($res) {
			$out['status'] = '200';
			$out['msg'] = "Data tersimpan.";
		} else {
			$out['status'] = '500';
			$out['msg'] = "Terjadi kesalahan, silahkan kontak administrator.";
		}
		$this->output->set_content_type('application/json');
		echo json_encode($out);
	}

	public function cancel_hold($no_unit) {
		$res = $this->tr_sales_model->cancel_hold($no_unit);
		if($res) {
			$out['status'] = '200';
			$out['msg'] = "Data tersimpan.";
		} else {
			$out['status'] = '500';
			$out['msg'] = "Terjadi kesalahan, silahkan kontak administrator.";
		}
		$this->output->set_content_type('application/json');
		echo json_encode($out);
	}

	public function save_reserve() {
		// $this->output->enable_profiler(TRUE);
		$res_no = $this->input->post('reserve_no') ? $this->input->post('reserve_no') : $this->tr_sales_model->gen_reserve_no($this->input->post('no_unit'));
		$kode = $this->input->post('kode') ? $this->input->post('kode') : $this->mst_nasabah_model->gen_kode_nasabah($this->input->post('no_unit'));
		$harga_old = $this->input->post('harga_unit_old');
		$payment = array(
			'cara_bayar'=>$this->input->post('cara_bayar'),
			'kode_pay'=>$this->input->post('kode_pay'),
			'kode_entity'=>$this->session->userdata('kode_entity'),
			'no_unit'=>$this->input->post('no_unit'),
			'sales_no'=>$this->input->post('sales_no'),
			'kode_nasabah'=>$kode,
			'harga_unit'=>$harga_old==='0' || $harga_old==='0.00' ? $this->input->post('harga') : $harga_old,
			'harga_unit_old'=>$harga_old==='0' || $harga_old==='0.00' ? $harga_old : $this->input->post('harga'),
			'reserve_no'=>$res_no,
			'hold_date'=>$this->input->post('hold_date')===''?null:$this->input->post('hold_date'),
			'reserve_date'=>$this->dateutils->dateStr_to_mysql($this->input->post('reserve_date')),//date('Y-m-d'),
			'status_tr'=>$this->input->post('status_tr'),
			'tgl_akad'=>$this->dateutils->dateStr_to_mysql($this->input->post('tgl_akad')),
			'tgl_dokumen'=>$this->dateutils->dateStr_to_mysql($this->input->post('tgl_dokumen')),
			'kode_bank'=>$this->input->post('kode_bank')
		);
		$paymentdet = array();
		$kodepays = $this->input->post('fkodepay');
		$namapays = $this->input->post('fnamapay');
		$persenpays = $this->input->post('fpersenpay');
		$valpays = $this->input->post('fvalpay');
		// diskon
		$valpaysnew = $this->input->post('fvalpaynew');
		$tglpays = $this->input->post('ftglpay');
		$no_urut = 1;
		foreach($kodepays as $k => $v) {
			$rpOld = str_replace(',','',$valpays[$k]);
			$rpNew = str_replace(',','',$valpaysnew[$k]);
			$item = array(
				'reserve_no'=>$res_no,
				'kode_pay'=>$v,
				'nama'=>$namapays[$k],
				'persentase'=>$persenpays[$k],
				'rp'=>$rpNew==='0' || $rpNew==='0.00' ? $rpOld : $rpNew,
				'rp_old'=>$rpNew==='0' || $rpNew==='0.00' ? $rpNew : $rpOld,
				'tgl_tempo'=>$this->dateutils->dateStr_to_mysql($tglpays[$k]),
				'no_urut'=>$no_urut,
				'flag'=>'PLAN1'
			);
			$paymentdet[] = $item;
			$no_urut++;
		}
		
		$customer = array(
			'jenis'=>'CUSTOMER',
			'kode'=>$kode,
			'klasifikasi'=>$this->input->post('klasifikasi'),
			'salutation'=>$this->input->post('salutation'),
			'nama'=>$this->input->post('nama'),
			'jenis_id'=>$this->input->post('jenis_id'),
			'no_id'=>$this->input->post('no_id'),
			'npwp'=>$this->input->post('npwp'),
			'email'=>$this->input->post('email'),
			'hp'=>$this->input->post('hp'),
			'tempat_lahir'=>$this->input->post('tempat_lahir'),
			'tgl_lahir'=>$this->dateutils->dateStr_to_mysql($this->input->post('tgl_lahir')),
			'nationality'=>$this->input->post('nationality'),
			'agama'=>$this->input->post('agama'),
			'jk'=>$this->input->post('jk'),
			'nama_perusahaan'=>$this->input->post('nama_perusahaan'),
			'alamat_perusahaan'=>$this->input->post('alamat_perusahaan'),
			// 'kota_perusahaan'=>$this->input->post('kota_perusahaan'),
			// 'kodepos_perusahaan'=>$this->input->post('kodepos_perusahaan'),
			// 'telp_perusahaan'=>$this->input->post('telp_perusahaan'),
			// 'fax_perusahaan'=>$this->input->post('fax_perusahaan'),
			// 'jenis_pekerjaan'=>$this->input->post('jenis_pekerjaan'),
			// 'status_pekerjaan'=>$this->input->post('status_pekerjaan'),
			// 'lama_bekerja'=>$this->input->post('lama_bekerja'),
			// 'jenis_usaha'=>$this->input->post('jenis_usaha'),
			// 'jabatan'=>$this->input->post('jabatan'),
			// 'pendapatan'=>$this->input->post('pendapatan'),
			// 'sumber_pendapatan_tambahan'=>$this->input->post('sumber_pendapatan_tambahan'),
			// 'pendapatan_tambahan'=>$this->input->post('pendapatan_tambahan')
		);

		$dataAlamat = array();
		$alamats = $this->input->post('alamat');
		$kotas = $this->input->post('kota');
		$kodepos = $this->input->post('kodepos');
		$telps = $this->input->post('telp');
		$faxs = $this->input->post('fax');
		foreach ($alamats as $k => $v) {
			$item = array(
				'kode_nasabah' => $kode,
				'alamat' => $alamats[$k],
				'kota' => $kotas[$k],
				'kodepos' => $kodepos[$k],
				'telp' => $telps[$k],
				'fax' => $faxs[$k]
			);
			$dataAlamat[] = $item;
		}
		$idxAlamat = $this->input->post('idx-alamat');

		$res = $this->tr_sales_model->_update_booking2($payment, $paymentdet, $customer, $dataAlamat, $idxAlamat);
		
		$out = array();
		// if($res) {
			$out['status'] = '200';
			$out['msg'] = "Data tersimpan.\nNo. Reserve: $res_no.\nKode Customer: $kode.";
		// } else {
			// $out['status'] = '500';
			// $out['msg'] = "Terjadi kesalahan, silahkan kontak administrator.";
		// }
		$this->output->set_content_type('application/json');
		echo json_encode($out);
	}

	public function save_booking() {
		// $this->output->enable_profiler(TRUE);
		$res_no = $this->input->post('reserve_no') ? $this->input->post('reserve_no') : $this->tr_sales_model->gen_reserve_no($this->input->post('no_unit'));
		$kode = $this->input->post('kode') ? $this->input->post('kode') : $this->mst_nasabah_model->gen_kode_nasabah($this->input->post('no_unit'));
		$payment = array(
			'cara_bayar'=>$this->input->post('cara_bayar'),
			'kode_pay'=>$this->input->post('kode_pay'),
			'kode_entity'=>$this->session->userdata('kode_entity'),
			'no_unit'=>$this->input->post('no_unit'),
			'sales_no'=>$this->input->post('sales_no'),
			'kode_nasabah'=>$kode,
			'harga_unit'=>$this->input->post('harga'),
			'reserve_no'=>$res_no,
			'hold_date'=>$this->input->post('hold_date')===''?null:$this->input->post('hold_date'),
			'reserve_date'=>$this->input->post('reserve_date')===''?null:$this->input->post('reserve_date'),
			'booking_date'=>$this->dateutils->dateStr_to_mysql($this->input->post('booking_date')),//date('Y-m-d'),
			'status_tr'=>$this->input->post('status_tr'),
			'tgl_akad'=>$this->dateutils->dateStr_to_mysql($this->input->post('tgl_akad')),
			'tgl_bangunan'=>$this->dateutils->dateStr_to_mysql($this->input->post('tgl_bangunan')),
			'tgl_dokumen'=>$this->dateutils->dateStr_to_mysql($this->input->post('tgl_dokumen')),
			'kode_bank'=>$this->input->post('kode_bank')
		);
		$paymentdet = array();
		$kodepays = $this->input->post('fkodepay');
		$namapays = $this->input->post('fnamapay');
		$persenpays = $this->input->post('fpersenpay');
		$valpays = $this->input->post('fvalpay');
		$tglpays = $this->input->post('ftglpay');
		$no_urut = 1;
		foreach($kodepays as $k => $v) {
			$item = array(
				'reserve_no'=>$res_no,
				'kode_pay'=>$v,
				'nama'=>$namapays[$k],
				'persentase'=>$persenpays[$k],
				'rp'=>str_replace(',','',$valpays[$k]),
				'tgl_tempo'=>$this->dateutils->dateStr_to_mysql($tglpays[$k]),
				'no_urut'=>$no_urut,
				'flag'=>'PLAN1'
			);
			$paymentdet[] = $item;
			$no_urut++;
		}
		
		$customer = array(
			'jenis'=>'CUSTOMER',
			'kode'=>$kode,
			'klasifikasi'=>$this->input->post('klasifikasi'),
			'salutation'=>$this->input->post('salutation'),
			'nama'=>$this->input->post('nama'),
			'jenis_id'=>$this->input->post('jenis_id'),
			'no_id'=>$this->input->post('no_id'),
			'npwp'=>$this->input->post('npwp'),
			'email'=>$this->input->post('email'),
			'hp'=>$this->input->post('hp'),
			'tempat_lahir'=>$this->input->post('tempat_lahir'),
			'tgl_lahir'=>$this->dateutils->dateStr_to_mysql($this->input->post('tgl_lahir')),
			'nationality'=>$this->input->post('nationality'),
			'agama'=>$this->input->post('agama'),
			'jk'=>$this->input->post('jk'),
			'nama_perusahaan'=>$this->input->post('nama_perusahaan'),
			'alamat_perusahaan'=>$this->input->post('alamat_perusahaan'),
			// 'kota_perusahaan'=>$this->input->post('kota_perusahaan'),
			// 'kodepos_perusahaan'=>$this->input->post('kodepos_perusahaan'),
			// 'telp_perusahaan'=>$this->input->post('telp_perusahaan'),
			// 'fax_perusahaan'=>$this->input->post('fax_perusahaan'),
			// 'jenis_pekerjaan'=>$this->input->post('jenis_pekerjaan'),
			// 'status_pekerjaan'=>$this->input->post('status_pekerjaan'),
			// 'lama_bekerja'=>$this->input->post('lama_bekerja'),
			// 'jenis_usaha'=>$this->input->post('jenis_usaha'),
			// 'jabatan'=>$this->input->post('jabatan'),
			// 'pendapatan'=>$this->input->post('pendapatan'),
			// 'sumber_pendapatan_tambahan'=>$this->input->post('sumber_pendapatan_tambahan'),
			// 'pendapatan_tambahan'=>$this->input->post('pendapatan_tambahan')
		);

		$dataAlamat = array();
		$alamats = $this->input->post('alamat');
		$kotas = $this->input->post('kota');
		$kodepos = $this->input->post('kodepos');
		$telps = $this->input->post('telp');
		$faxs = $this->input->post('fax');
		foreach ($alamats as $k => $v) {
			$item = array(
				'kode_nasabah' => $kode,
				'alamat' => $alamats[$k],
				'kota' => $kotas[$k],
				'kodepos' => $kodepos[$k],
				'telp' => $telps[$k],
				'fax' => $faxs[$k]
			);
			$dataAlamat[] = $item;
		}
		$idxAlamat = $this->input->post('idx-alamat');

		$res = $this->tr_sales_model->_update_booking2($payment, $paymentdet, $customer, $dataAlamat, $idxAlamat);
		
		$out = array();
		// if($res) {
			$out['status'] = '200';
			$out['msg'] = "Data tersimpan.\nNo. Reserve: $res_no.\nKode Customer: $kode.";
		// } else {
			// $out['status'] = '500';
			// $out['msg'] = "Terjadi kesalahan, silahkan kontak administrator.";
		// }
		$this->output->set_content_type('application/json');
		echo json_encode($out);
	}

	public function save_confirm_payment() {
		$stgl = $this->dateutils->dateStr_to_mysql($this->input->post('tgl_bayar'));
		// list($t,$b,$h) = explode('-',$stgl);
		$no_kwitansi = '0';//sprintf('KWT-%s%s%s%06d',substr($t,2),$b,$h,$this->input->post('idpay'));
		$data = array(
			'reserve_no'=>$this->input->post('reserve_no'),
			'kode_pay'=>$this->input->post('kode_pay'),
			'nama'=>$this->input->post('nama'),
			'rp'=>str_replace(',','',$this->input->post('rp')),
			'tgl_bayar'=>$stgl,
			'no_kwitansi'=>$no_kwitansi,
			'no_urut'=>$this->input->post('no_urut')
		);
		$status = 'HOLD';
		if($data['kode_pay']==='RES')
			$status = 'RESERVE';
		elseif($data['kode_pay']==='TJ')
			$status = 'BOOKING';
		else
			$status = 'SALES';
		$this->tr_sales_model->save_confirm_payment($data, $status);
		echo $no_kwitansi;
	}

	public function save_cancellation() {
		$data = $this->input->post();
		$data['jenis'] = 'CANCELLATION';
		$data['tanggal'] = date('Y-m-d');
		$data['adm_rp'] = str_replace(',','',$this->input->post('adm_rp'));
		$data['tax_rp'] = str_replace(',','',$this->input->post('tax_rp'));
		$data['refund_rp'] = str_replace(',','',$this->input->post('refund_rp'));
		return $this->tr_sales_model->save_cancellation($data);
	}

	public function save_change_owner() {
		$data = $this->input->post();
		$data['tgl_lahir'] = $this->dateutils->dateStr_to_mysql($this->input->post('tgl_lahir'));
		$data['tanggal'] = date('Y-m-d');
		$data['adm_rp'] = str_replace(',','',$this->input->post('adm_rp'));
		echo $this->tr_sales_model->save_change_owner($data);
	}

	public function save_change_unit() {
		$data = $this->input->post();
		$data['tgl_akad'] = $this->dateutils->dateStr_to_mysql($this->input->post('tgl_akad'));
		$data['tgl_dokumen'] = $this->dateutils->dateStr_to_mysql($this->input->post('tgl_dokumen'));
		$data['tanggal'] = date('Y-m-d');
		$data['adm_rp'] = str_replace(',','',$this->input->post('adm_rp'));
		echo $this->tr_sales_model->save_change_unit($data);
	}

	public function test_integration() {
		$this->output->enable_profiler(TRUE);
		$data = array(
			'reserve_no'=>'RSV-TCBR-000002',
			'no_unit'=>'H.A/2',
			'rp'=>5000000,
			'tanggal'=>'2015-06-26',
			'kode_nasabah'=>'H.A/2-000004',
			'no_invoice'=>'KWT-1506000015'
		);
		$this->tr_sales_model->do_integration($data);
	}
	
}