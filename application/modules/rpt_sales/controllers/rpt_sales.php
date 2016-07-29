<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPCLASS;

class Rpt_sales extends App {

	public function __construct() {
		parent::__construct();
		$this->load->model('rpt_sales_model');
		$this->load->model('../../mst_entity/models/mst_entity_model');
		// $this->load->library('pdf');
		$this->load->library('datatables');
		$this->load->library('strUtils');
	}
	

	public function index($type = 'kartu-nasabah') {

		$data = array();
		if($type==='penagihan') {
			$data['idmenu'] = 'sales-penagihan';
			$data['content'] = '../../rpt_sales/views/form_select_periode_3';
			$data['js'] = '../../rpt_sales/views/form_select_periode_js_3';
		} elseif($type==='penagihan-kpr') { 
			$data['idmenu'] = 'sales-penagihan';
			$data['content'] = '../../rpt_sales/views/form_select_periode_3';
			$data['js'] = '../../rpt_sales/views/form_select_periode_js_4';
		} elseif($type==='kartu-piutang') {
			$data['idmenu'] = 'sales-kartu-piutang';
			$data['content'] = '../../rpt_sales/views/form_select_periode';
			$data['js'] = '../../rpt_sales/views/form_select_periode_js';
		} elseif($type==='rpt-op') {
			$data['idmenu'] = 'sales-rpt-op';
			$data['content'] = '../../rpt_sales/views/form_select_periode_2';
			$data['js'] = '../../rpt_sales/views/form_select_periode_js_2';
		} elseif($type==='rpt-ok') {
			$data['idmenu'] = 'sales-rpt-ok';
			$data['content'] = '../../rpt_sales/views/form_select_periode_8';
			$data['js'] = '../../rpt_sales/views/form_select_periode_js_8';
		} elseif(in_array($type, array('kartu-nasabah', 'konfirmasi-unit', 'surat-pesanan'))) {
			$data['idmenu'] = 'sales-'.$type;
			$data['content'] = '../../rpt_sales/views/form_table';
			$data['js'] = '../../rpt_sales/views/form_table_js';
			$data['datajs'] = $type;
		}elseif($type==='kartu-piutangnew') {
			$data['idmenu'] = 'sales-kartu-piutangnew';
			$data['content'] = '../../rpt_sales/views/form_select_periode';
			$data['js'] = '../../rpt_sales/views/form_select_periode_js_5';
		}
		elseif($type==='penagihanew') {
			$data['idmenu'] = 'sales-kartu-piutangnew';
			$data['content'] = '../../rpt_sales/views/form_select_periode';
			$data['js'] = '../../rpt_sales/views/form_select_periode_js_6';
		}
		elseif($type==='masterstockopname') {
			$data['idmenu'] = 'sales-masteropname';
			$data['content'] = '../../rpt_sales/views/form_select_periode_4';
			$data['js'] = '../../rpt_sales/views/form_select_periode_js_7';
		}
		$this->buildView($data);
	}
	
	public function form_kartu_piutang($from, $to) {
		$data = array();
		$data['idmenu'] = 'sales-kartu-piutang';
		$data['content'] = '../../rpt_sales/views/form_kartu_piutang';
		$data['datacontent']['datatable'] = $this->rpt_sales_model->gen_kartu_piutang($from, $to);
		$data['datacontent']['nama'] = $this->session->userdata('nama');
		list($ft,$fb,$fh) = explode('-',$from);
		list($tt,$tb,$th) = explode('-',$to);
		$data['datacontent']['periode'] = $fh.' '.$this->strutils->strBulan($fb).' '.$ft.' s.d '.$th.' '.$this->strutils->strBulan($tb).' '.$tt;
		$data['datacontent']['kawasan'] = $this->session->userdata('nama_entity');
		$data['js'] = '../../rpt_sales/views/form_kartu_piutang_js';
		$this->buildView($data);
	}

	public function form_kartu_piutangnew($from, $to) {
		$data = array();
		$data['idmenu'] = 'sales-kartu-piutangnew';
		$data['content'] = '../../rpt_sales/views/form_kartu_piutangnew';
		$data['datacontent']['datatable'] = $this->rpt_sales_model->gen_kartu_piutangnew($from, $to);
		$data['datacontent']['nama'] = $this->session->userdata('nama');
		list($ft,$fb,$fh) = explode('-',$from);
		list($tt,$tb,$th) = explode('-',$to);
		$data['datacontent']['periode'] = $fh.' '.$this->strutils->strBulan($fb).' '.$ft.' s.d '.$th.' '.$this->strutils->strBulan($tb).' '.$tt;
		$data['datacontent']['kawasan'] = $this->session->userdata('nama_entity');
		$data['js'] = '../../rpt_sales/views/form_kartu_piutang_js';
		$this->buildView($data);
	}

	public function form_penagihan($from, $to) {
		$data = array();
		$data['idmenu'] = 'sales-penagihan';
		$data['content'] = '../../rpt_sales/views/form_penagihan';
		$data['datacontent']['datatable'] = $this->rpt_sales_model->gen_penagihan($from, $to);
		$data['datacontent']['nama'] = $this->session->userdata('nama');
		list($ft,$fb,$fh) = explode('-',$from);
		list($tt,$tb,$th) = explode('-',$to);
		$data['datacontent']['periode'] = $fh.' '.$this->strutils->strBulan($fb).' '.$ft.' s.d '.$th.' '.$this->strutils->strBulan($tb).' '.$tt;
		$data['datacontent']['kawasan'] = $this->session->userdata('nama_entity');
		// $data['js'] = '../../rpt_sales/views/form_kartu_piutang_js';
		$this->buildView($data);
	}

	public function form_penagihannew($from, $to) {
		$data = array();
		$data['idmenu'] = 'sales-penagihannew';
		$data['content'] = '../../rpt_sales/views/form_penagihannew';
		$data['datacontent']['datatable'] = $this->rpt_sales_model->gen_penagihannew($from, $to);
		$data['datacontent']['nama'] = $this->session->userdata('nama');
		list($ft,$fb,$fh) = explode('-',$from);
		list($tt,$tb,$th) = explode('-',$to);
		$data['datacontent']['periode'] = $fh.' '.$this->strutils->strBulan($fb).' '.$ft.' s.d '.$th.' '.$this->strutils->strBulan($tb).' '.$tt;
		$data['datacontent']['kawasan'] = $this->session->userdata('nama_entity');
		// $data['js'] = '../../rpt_sales/views/form_kartu_piutang_js';
		$this->buildView($data);
	}

	public function form_kartu_masterstock($from){
		$data = array();
		$data['idmenu'] = 'sales-masteropname';
		$data['content'] = '../../rpt_sales/views/form_opnamemasterstock';
		$data['js'] = '../../rpt_sales/views/table_js';
		$data['datacontent']['datatable'] = $this->rpt_sales_model->gen_opnamemasterstock($from,false);
		$data['datacontent']['nama'] = $this->session->userdata('nama');
		list($ft,$fb,$fh) = explode('-',$from);
		$data['datacontent']['periode'] = $fh.' '.$this->strutils->strBulan($fb).' '.$ft;
		$data['datacontent']['kawasan'] = $this->session->userdata('nama_entity');
		// $data['js'] = '../../rpt_sales/views/form_kartu_piutang_js';
		$this->buildView($data);
	}
	public function form_penagihan_kpr($from, $to) {
		$data = array();
		$data['idmenu'] = 'sales-penagihan';
		$data['content'] = '../../rpt_sales/views/form_penagihan';
		$data['datacontent']['datatable'] = $this->rpt_sales_model->gen_penagihan2($from, $to);
		$data['datacontent']['nama'] = $this->session->userdata('nama');
		list($ft,$fb,$fh) = explode('-',$from);
		list($tt,$tb,$th) = explode('-',$to);
		$data['datacontent']['periode'] = $fh.' '.$this->strutils->strBulan($fb).' '.$ft.' s.d '.$th.' '.$this->strutils->strBulan($tb).' '.$tt;
		$data['datacontent']['kawasan'] = $this->session->userdata('nama_entity');
		$data['datacontent']['addtitle'] = " (CARA BAYAR KPR/KPA) ";
		// $data['js'] = '../../rpt_sales/views/form_kartu_piutang_js';
		$this->buildView($data);
	}

	// Report Konsolidasi OK
	public function form_rpt_ok($from,$to) {
		//$this->output->enable_profiler(TRUE);
		$data = array();
		$data['idmenu'] = 'sales-rpt-ok';
		$data['content'] = '../../rpt_sales/views/form_rpt_oknew';
		$data['datacontent']['datatable'] = $this->rpt_sales_model->getreportok($from, $to);
		$data['datacontent']['nama'] = $this->session->userdata('nama');
		list($ft,$fb,$fh) = explode('-',$from);
		list($tt,$tb,$th) = explode('-',$to);
		$data['datacontent']['periode'] = $fh.' '.$this->strutils->strBulan($fb).' '.$ft.' s.d '.$th.' '.$this->strutils->strBulan($tb).' '.$tt;
		$data['datacontent']['kawasan'] = $this->session->userdata('nama_entity');
		$data['js'] = '../../rpt_sales/views/form_rpt_ok_js';
		$this->buildView($data);
	}
	
	// Report Konsolidasi OP
	public function form_rpt_op($from,$to) {
		// $this->output->enable_profiler(TRUE);
		$data = array();
		$data['idmenu'] = 'sales-rpt-op';
		$data['content'] = '../../rpt_sales/views/form_rpt_op_rev1';
		$data['datacontent']['datatable'] = $this->rpt_sales_model->gen_rpt_op_rev1($from,$to);
		$data['datacontent']['nama'] = $this->session->userdata('nama');
		list($ft,$fb,$fh) = explode('-',$from);
		list($tt,$tb,$th) = explode('-',$to);
		$data['datacontent']['periode'] = $fh.' '.$this->strutils->strBulan($fb).' '.$ft.' s.d '.$th.' '.$this->strutils->strBulan($tb).' '.$tt;
		$data['datacontent']['kawasan'] = $this->session->userdata('nama_entity');
//		$data['js'] = '../../rpt_sales/views/form_rpt_op_js';
		$this->buildView($data);
	}

	public function form_kartu_nasabah($type, $kode) {
		$data['idmenu'] = 'sales-kartu-nasabah';
		$data['content'] = '../../rpt_sales/views/form_kartu_nasabah';
		$data['datacontent'] = $this->rpt_sales_model->gen_kartu_nasabah($type, $kode);
		$this->buildView($data);
	}

	public function form_konfirmasi_unit($type, $kode) {
		$data['idmenu'] = 'sales-konfirmasi-unit';
		$data['content'] = '../../rpt_sales/views/form_konfirmasi_unit';
		$data['datacontent'] = $this->rpt_sales_model->gen_konfirmasi_unit($type, $kode);
		$this->buildView($data);
	}

	public function form_surat_pesanan($type, $kode) {
		$data['idmenu'] = 'sales-surat-pesanan';
		$data['content'] = '../../rpt_sales/views/form_surat_pesanan';
		$data['datacontent'] = $this->rpt_sales_model->gen_surat_pesanan($type, $kode);
		$this->buildView($data);
	}
	
	public function genDT_stock($type) {
		$this->datatables->select('DISTINCT MD5(s.no_unit) AS xnounit, s.no_unit AS no_unit, mnas.nama as nama_nasabah, mpd.deskripsi as cara_bayar, stypep.konten AS type_property,stypeu.konten AS type_unit,'.
					'stower.konten AS tower_cluster,s.wide_netto AS wide_netto,s.wide_gross AS wide_gross,slantai.konten AS lantai_blok,sdir.konten AS direction',FALSE)
			->unset_column('xnounit') 
			->from('mst_stock s') 
			->join('tr_payment pay','pay.no_unit = s.no_unit AND pay.iscancelled = 0','inner')
			->join('mst_optional_stock stypep', 'stypep.kode = s.type_property AND stypep.sfield = "type_property" AND stypep.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->join('mst_optional_stock stower', 'stower.kode = s.tower_cluster AND stower.sfield = "tower_cluster" AND stower.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->join('mst_optional_stock stypeu', 'stypeu.kode = s.type_unit AND stypeu.sfield = "type_unit" AND stypeu.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->join('mst_optional_stock slantai', 'slantai.kode = s.lantai_blok AND slantai.sfield = "lantai_blok" AND slantai.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->join('mst_optional_stock sdir', 'sdir.kode = s.mata_angin AND sdir.sfield = "mata_angin" AND sdir.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->join('mst_nasabah mnas', 'mnas.kode = pay.kode_nasabah')
			->join('mst_payment_plan_detail mpd','mpd.kode_pay = pay.kode_pay')
			->where(array('s.kode_entity'=>$this->session->userdata('kode_entity')))
			->add_column('action', '<a href="'.base_url().'index.php/sales/'.$type.'/stk.no_unit/$1"><span class="glyphicons glyphicons-check"></span> View</a>&nbsp;&nbsp '.
				'<a target="_blank" href="'.base_url().'index.php/laporan/doprint/'.$type.'/stk.no_unit/$1"><span class="glyphicons glyphicons-print"></span> PDF</a>', 'xnounit');
		echo $this->datatables->generate();
	}

} 