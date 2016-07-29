<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPCLASS;

class Tr_SPK_Pekerjaan extends App {
	
	public function __construct() {
		parent::__construct();
			
		$this->load->model('Tr_spk_pk_pekerjaan_model','',TRUE);
		$this->load->library('datatables');
		$this->load->library('dateUtils');
	}

	public function index() {
		$data = array();
		$data['idmenu'] 		= 'spk_pk-table';
		$data['content'] 		= '../../tr_spk_pekerjaan/views/table';
		$data['js'] 			= '../../tr_spk_pekerjaan/views/table_js';
		$data['btnurl'] 		= base_url().'index.php/tr_spk/form';
		$this->buildView($data);
	}
	
	public function form($id = FALSE) {
		$data = array();
		$data['idmenu'] 		= 'spk_pk-table';
		$data['content'] 		= '../../tr_spk_pekerjaan/views/form';
		$data['datacontent'] 	= tr_spk_pk_pekerjaan_model::get_optional();
		$data['js'] 			= '../../tr_spk_pekerjaan/views/form_js';
		if($id!==FALSE) {
			$data['idmenu'] 	= 'spk_pk-form-edit';
			$data['datajs'] 	= tr_spk_pk_pekerjaan_model::get_spk_and_detail($id);
			//$data['child_load']	= site_url('form_child');
		}
		$this->buildView($data);
	}
	
	function load_child($sdid)
	{
		
		$q					= tr_spk_pk_pekerjaan_model::getUnit_BySDID($sdid);
		$data['num']		= $q->num_rows();
		$data['query']		= $q->result();
		$data['rowu']		= $q->row();
		
		// unit
		$qr					= tr_spk_pk_pekerjaan_model::genNoUnitEdit();
		$data['numb']		= $qr->num_rows();
		$data['query2']		= $qr->result();

		$this->load->view('form_child', $data);
	}

	function add_unit()
	{
		$data = $this->input->spkst();
		return tr_spk_pk_pekerjaan_model::tambah_unit($data);
	}

	function del_unit($id)
	{
		$res = tr_spk_pk_pekerjaan_model::deltUnit_byID($id);
		if($res) {
			$out = array(
				'resspknse'=>'1',
				'msg'=>'Success'
			);
		} else {
			$out = array(
				'resspknse'=>'0',
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
			return tr_spk_pk_pekerjaan_model::_insert($data);
		} else {
			return tr_spk_pk_pekerjaan_model::_update($data, $this->input->post('id'));
		}
	}
	
	public function delete($id) {
		$res = tr_spk_pk_pekerjaan_model::_delete($id);
		if($res) {
			$out = array(
				'resspknse'=>'1',
				'msg'=>'Success'
			);
		} else {
			$out = array(
				'resspknse'=>'0',
				'msg'=>'Failed'
			);
		}
		$this->output->set_content_type('application/json');
		echo json_encode($out);
	}
	
	public function genDT() {
		// $this->output->enable_profiler(TRUE);
		$this->datatables->select('sppk.id, DATE_FORMAT(sppk.tanggal,"%d/%m/%Y") as tanggal, sppk.no_spk, sppk.kode_spk,  '.
				'bp.uraian', FALSE)
			->from('tr_spk_pk sppk')
			->join('tr_bpdp bp','bp.no_path = sppk.kode_bpdp')
			->unset_column('sppk.id')
			->where(array('sppk.kode_entity'=>$this->session->userdata('kode_entity')))
			->add_column('action', '<a href="javascript:action(\'edit\',\'$1\')" class="row-edit" data-id="$1">'.
				'<span class="glyphicons glyphicons-edit"></span></a>&nbsp;&nbsp'.
				'<a href="javascript:action(\'delete\',\'$1\')" class="row-delete" data-id="$1">'.
				'<span class="glyphicons glyphicons-bin"></span></a>', 'sppk.id');
		echo $this->datatables->generate();
	}
	
}