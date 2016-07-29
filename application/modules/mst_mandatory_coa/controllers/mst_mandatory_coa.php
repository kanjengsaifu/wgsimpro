<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPCLASS;

class mst_mandatory_coa extends App {
	
	function __construct() {
		parent::__construct();
			
		$this->load->model('mst_mandatory_coa_model');
		$this->load->library('datatables');
		$this->load->library('dateUtils');
		$this->load->library('strUtils');
	}

	function index() {
		$data = array();
		$data['idmenu'] 		= 'mandcoa';
		$data['content'] 		= '../../mst_mandatory_coa/views/table';
		$data['js'] 			= '../../mst_mandatory_coa/views/table_js';
		$data['datajs'] 		= mst_mandatory_coa_model::get_coa();
		$data['datacontent'] 		= mst_mandatory_coa_model::get_data();
		//$data['num']			= $q->num_rows();
		//$data['query']			= $q->result();
		//$data['row']			= $q->row();
		//echo count($data['t_data']);
		//var_dump($data);die;
		$data['btnurl'] 		= '#';

		$this->buildView($data);
	}

	function form($id=false) {
		$data = array();
		$data['idmenu'] 		= 'mandcoa-form';
		$data['content'] 		= '../../mst_mandatory_coa/views/form';
		$data['datacontent'] 	= mst_mandatory_coa_model::get_coa();
		$data['js'] 			= '../../mst_mandatory_coa/views/form_js';
		if(!$id==false || !$id=='')
			$data['idmenu'] 	= 'mandcoa-edit';
			$data['datajs'] 	= mst_mandatory_coa_model::get_data(); 

		$this->buildView($data);
	}

	function save()
	{
		$data = $this->input->post();

		if($this->input->post('id')==0) {
			$res =  mst_mandatory_coa_model::_insert($data);
		} else {
			$res = mst_mandatory_coa_model::_update($data, $this->input->post('id'));
		}
		
		$this->output->set_content_type('application/json');
		echo json_encode($res);
		
	}

	function delete()
	{
		$res = mst_mandatory_coa_model::_delete($id);
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

	function genDT() {
		$this->datatables->select('id, jenis, kode_coa, f_cekcoa(kode_coa) as coa, penerbitan, pelunasan', FALSE)
			->from('mst_setting_os')
			->unset_column('id')
			->unset_column('kode_coa')
			->add_column('action', '<a href="javascript:action(\'edit\',\'$1\')" class="row-edit" data-id="$1">'.
				'<span class="glyphicons glyphicons-edit"></span></a>&nbsp;&nbsp'.
				'<a href="javascript:action(\'delete\',\'$1\')" class="row-delete" data-id="$1">'.
				'<span class="glyphicons glyphicons-bin"></span></a>', 'id');
		echo $this->datatables->generate();
	}
}

?>
