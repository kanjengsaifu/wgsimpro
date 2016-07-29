<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPCLASS;

class Tr_po extends App {
	
	public function __construct() {
		parent::__construct();
			
		$this->load->model('tr_po_model','',TRUE);
		$this->load->library('datatables');
		$this->load->library('dateUtils');
		$this->load->library('strUtils');
	}

	public function index() {
		$data = array();
		$data['idmenu'] = 'po-table';
		$data['content'] = '../../tr_po/views/table';
		$data['js'] = '../../tr_po/views/table_js';
		$data['btnurl'] = base_url().'index.php/po/form';
		$this->buildView($data);
	}
	
	public function report(){
		$data = array();
		$data['idmenu'] = 'po-report';
		$data['content'] = '../../tr_po/views/form_select_periode';
		$data['js'] = '../../tr_po/views/form_select_periode_js';
		$this->buildView($data);
	}
	
	public function report_persediaan(){
		$data = array();
		$data['idmenu'] = 'po-report-persediaan';
		$data['content'] = '../../tr_po/views/form_select_periode2';
		$data['js'] = '../../tr_po/views/form_select_periode_js2';
		$this->buildView($data);
	}
	
	public function report_persediaan_view($from, $to) {
		$data = array();
		$data['idmenu'] = 'po-report-persediaan-view';
		$data['content'] = '../../tr_po/views/form_persediaan';
		$data['datacontent']['datatable'] = $this->tr_po_model->report_persediaan($from, $to);
		$data['datacontent']['nama'] = $this->session->userdata('nama');
		list($ft,$fb,$fh) = explode('-',$from);
		list($tt,$tb,$th) = explode('-',$to);
		$data['datacontent']['periode'] = $fh.' '.$this->strutils->strBulan($fb).' '.$ft.' s.d '.$th.' '.$this->strutils->strBulan($tb).' '.$tt;
		$data['datacontent']['kawasan'] = $this->session->userdata('nama_entity');
		$data['js'] = '../../tr_po/views/form_persediaan_js';
		$this->buildView($data);
	}
	
	public function report_apg(){
		$data = array();
		$data['idmenu'] = 'po-report-apg';
		$data['content'] = '../../tr_po/views/form_select_periode3';
		$data['js'] = '../../tr_po/views/form_select_periode_js3';
		$this->buildView($data);
	}
	
	public function report_apg_view($from, $to) {
		$data = array();
		$data['idmenu'] = 'po-report-apg-view';
		$data['content'] = '../../tr_po/views/form_apg';
		$data['datacontent']['datatable'] = $this->tr_po_model->report_persediaan($from, $to);
		$data['datacontent']['nama'] = $this->session->userdata('nama');
		list($ft,$fb,$fh) = explode('-',$from);
		list($tt,$tb,$th) = explode('-',$to);
		$data['datacontent']['periode'] = $fh.' '.$this->strutils->strBulan($fb).' '.$ft.' s.d '.$th.' '.$this->strutils->strBulan($tb).' '.$tt;
		$data['datacontent']['kawasan'] = $this->session->userdata('nama_entity');
		$data['js'] = '../../tr_po/views/form_apg_js';
		$this->buildView($data);
	}
	
	public function report_view($from, $to) {
		$data = array();
		$data['idmenu'] = 'po-report-penerimaan';
		$data['content'] = '../../tr_po/views/form_penerimaan';
		$data['datacontent']['datatable'] = $this->tr_po_model->report_po($from, $to);
		$data['datacontent']['nama'] = $this->session->userdata('nama');
		list($ft,$fb,$fh) = explode('-',$from);
		list($tt,$tb,$th) = explode('-',$to);
		$data['datacontent']['periode'] = $fh.' '.$this->strutils->strBulan($fb).' '.$ft.' s.d '.$th.' '.$this->strutils->strBulan($tb).' '.$tt;
		$data['datacontent']['kawasan'] = $this->session->userdata('nama_entity');
		$data['js'] = '../../tr_po/views/form_penerimaan_js';
		$this->buildView($data);
	}
	
	public function form($id = FALSE) {
		$data = array();
		$data['idmenu'] 		= 'po-form';
		$data['content'] 		= '../../tr_po/views/form';
		$data['datacontent']	= $this->tr_po_model->get_optional();
		$data['js'] 			= '../../tr_po/views/form_js';
		if($id) {
			$data['datajs'] 	= $this->tr_po_model->get_po_and_detail($id);
			//$data['child_load']	= site_url('form_child');
		}
		$this->buildView($data);
	}
	
	function load_child($sdid)
	{
		
		$q					= tr_po_model::getUnit_BySDID($sdid);
		$data['num']		= $q->num_rows();
		$data['query']		= $q->result();
		$data['rowu']		= $q->row();
		
		// unit
		$qr					= tr_po_model::genNoUnitEdit();
		$data['numb']		= $qr->num_rows();
		$data['query2']		= $qr->result();

		$this->load->view('form_child', $data);
	}

	function add_unit()
	{
		$data = $this->input->post();
		return $this->tr_po_model->tambah_unit($data);
	}

	function del_unit($id)
	{
		$res = tr_po_model::deltUnit_byID($id);
		if($res) {
			$out = array(
				'response'=>'1',
				'msg'=>'Success'
			);
		} else {
			$out = array(
				'response'=>'0',
				'msg'=>'Failed'
			);
		}
		$this->output->set_content_type('application/json');
		echo json_encode($out);
	}

	public function save() {
		$data = $this->input->post();
		$data['tanggal'] = $this->dateutils->dateStr_to_mysql($data['tanggal']);
		// $data['volume'] = str_replace(',', '', $data['volume']);
		// $data['harga_satuan'] = str_replace(',', '', $data['harga_satuan']);
		
		if($this->input->post('id')==='') {
			return $this->tr_po_model->_insert($data);
		} else {
			return $this->tr_po_model->_update($data, $this->input->post('id'));
		}
	}
	
	public function delete($id) {
		$res = $this->tr_po_model->_delete($id);
		if($res) {
			$out = array(
				'response'=>'1',
				'msg'=>'Success'
			);
		} else {
			$out = array(
				'response'=>'0',
				'msg'=>'Failed'
			);
		}
		$this->output->set_content_type('application/json');
		echo json_encode($out);
	}
	
	public function genDT() {
		// $this->output->enable_profiler(TRUE);
		$this->datatables->select('po.id, DATE_FORMAT(po.tanggal,"%d/%m/%Y") as tanggal, po.no_kontrak, po.kdnasabah, ks.nama', FALSE)
			->from('tr_po po')
			->unset_column('po.id')
			->join('mst_nasabah_konstruksi ks', 'ks.kode = po.kdnasabah' )			
			->where(array('po.kode_entity'=>$this->session->userdata('kode_entity')))
			->add_column('action', '<a href="javascript:action(\'edit\',\'$1\')" class="row-edit" data-id="$1">'.
				'<span class="glyphicons glyphicons-edit"></span></a>&nbsp;&nbsp'.
				'<a href="javascript:action(\'delete\',\'$1\')" class="row-delete" data-id="$1">'.
				'<span class="glyphicons glyphicons-bin"></span></a>', 'po.id');
		echo $this->datatables->generate();
	}
	
}