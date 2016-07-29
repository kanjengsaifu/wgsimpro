<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPCLASS;

class Mst_tahap_pekerjaan extends App {
	
	public function __construct() {
		parent::__construct();
			
		$this->load->model('mst_tahap_pekerjaan_model');
		$this->load->library('datatables');
	}

	public function index() {
		$data = array();
		$data['idmenu'] = 'tahap-pekerjaan-table';
		$data['content'] = '../../mst_tahap_pekerjaan/views/table';
		$data['js'] = '../../mst_tahap_pekerjaan/views/table_js';
		$data['btnurl'] = base_url().'index.php/tahap-pekerjaan/form';
		$this->buildView($data);
	}
	
	public function form($id = FALSE) {
		$data = array();
		$data['idmenu'] = 'tahap-pekerjaan-form';
		$data['content'] = '../../mst_tahap_pekerjaan/views/form';
		//$data['datacontent'] = $this->mst_entity_model->get_optional();
		$data['js'] = '../../mst_tahap_pekerjaan/views/form_js';
		if($id!==FALSE) {
			$data['datajs'] = $this->mst_tahap_pekerjaan_model->get($id);
		}
		$this->buildView($data);
	}
	
	public function save() {
		$data = $this->input->post();
		if($this->input->post('id')==='') {
			return $this->mst_tahap_pekerjaan_model->_insert($data);
		} else {
			return $this->mst_tahap_pekerjaan_model->_update($data, $this->input->post('id'));
		}
	}
	
	public function delete($id) {
		$res = $this->mst_tahap_pekerjaan_model->_delete($id);
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
		$this->datatables->select('t.id, t.kode, t.nama, t.satuan, t.volume')
				->unset_column('t.id')
				->from('mst_tahap t')
				->where(array('t.kode_entity'=>$this->session->userdata('kode_entity')))
				->add_column('action', '<a href="javascript:action(\'edit\',\'$1\')"><span class="glyphicons glyphicons-edit"></span></a>&nbsp;&nbsp'.
						'<a href="javascript:action(\'delete\',\'$1\')"><span class="glyphicons glyphicons-bin"></span></a>', 't.id');
		echo $this->datatables->generate();
	}
	
}