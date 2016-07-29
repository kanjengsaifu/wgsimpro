<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPCLASS;

class Mst_rab_bl extends App {
	
	public function __construct() {
		parent::__construct();
			
		$this->load->model('mst_rab_bl_model');
		$this->load->library('datatables');
	}

	public function index() {
		$data = array();
		$data['idmenu'] 		= 'rab-bl';
		$data['content'] 		= '../../mst_rab_bl/views/table';
		$data['js'] 			= '../../mst_rab_bl/views/table_js';
		$data['btnurl'] 		= base_url().'index.php/rab-bl/form';
		$this->buildView($data);
	}
	
	public function form($id = FALSE) {
		$data = array();
		$data['idmenu'] = 'rabbl-form';
		$data['content'] = '../../mst_rab_bl/views/form';
		
		$data['datacontent']['list_sumberdaya'] = $this->mst_rab_bl_model->get_sumberdaya();
		$data['datacontent']['list_tahap'] = $this->mst_rab_bl_model->get_tahap(); 
		
		//$data['datacontent'] = $this->mst_entity_model->get_optional();
		$data['js'] = '../../mst_rab_bl/views/form_js';
		if($id!==FALSE) {
			$data['datajs'] = $this->mst_rab_bl_model->get($id);
		}
		$this->buildView($data);
	}
	
	public function save() {
		$data = $this->input->post();
		if($this->input->post('id')==='') {
			return $this->mst_rab_bl_model->_insert($data);
		} else {
			return $this->mst_rab_bl_model->_update($data, $this->input->post('id'));
		}
	}
	
	public function delete($id) {
		$res = $this->mst_rab_bl_model->_delete($id);
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
		$this->datatables->select('id, kode_tahap, kode_sumberdaya, volume, volume_rev')
				->unset_column('id')
				->from('tr_rab_bl')
				->where(array('kode_entity'=>$this->session->userdata('kode_entity')))
				->add_column('action', '<a href="javascript:action(\'edit\',\'$1\')"><span class="glyphicons glyphicons-edit"></span></a>&nbsp;&nbsp'.
						'<a href="javascript:action(\'delete\',\'$1\')"><span class="glyphicons glyphicons-bin"></span></a>', 'id');
		echo $this->datatables->generate();
	}
	
}