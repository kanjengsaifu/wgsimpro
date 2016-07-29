<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPCLASS;

class Mst_sumberdaya extends App {
	
	public function __construct() {
		parent::__construct();
			
		$this->load->model('mst_sumberdaya_model');
		$this->load->library('datatables');
	}

	public function index() {
		$data = array();
		$data['idmenu'] = 'sumberdaya';
		$data['content'] = '../../mst_sumberdaya/views/table';
		$data['js'] = '../../mst_sumberdaya/views/table_js';
		$data['btnurl'] = base_url().'index.php/mst_sumberdaya/form';
		$this->buildView($data);
	}
	
	public function form($id = FALSE) {
		$data = array();
		$data['idmenu'] = 'sumberdaya-form';
		$data['content'] = '../../mst_sumberdaya/views/form';
		$data['js'] = '../../mst_sumberdaya/views/form_js';
		if($id!==FALSE) {
			$data['datajs'] = $this->mst_sumberdaya_model->get($id);
		}
		$this->buildView($data);
	}
	
	public function save() {
		$data = $this->input->post();
		if($this->input->post('id')==='') {
			return $this->mst_sumberdaya_model->_insert($data);
		} else {
			return $this->mst_sumberdaya_model->_update($data, $this->input->post('id'));
		}
	}
	
	public function delete($id) {
		$res = $this->mst_sumberdaya_model->_delete($id);
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
		$this->datatables->select('id, kode, jenis, nama, satuan')
				->unset_column('id')
				->from('mst_sumberdaya')
				->add_column('action', '<a href="javascript:action(\'edit\',\'$1\')"><span class="glyphicons glyphicons-edit"></span></a>&nbsp;&nbsp'.
						'<a href="javascript:action(\'delete\',\'$1\')"><span class="glyphicons glyphicons-bin"></span></a>', 'id');
		echo $this->datatables->generate();
	}
	
}