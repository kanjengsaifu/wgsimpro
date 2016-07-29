<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPCLASS;

class Mst_rab_btl extends App {
	
	public function __construct() {
		parent::__construct();
			
		$this->load->model('mst_rab_btl_model');
		$this->load->library('datatables');
	}

	public function index() {
		$data = array();
		$data['idmenu'] = 'rab-btl';
		$data['content'] = '../../mst_rab_btl/views/table';
		$data['js'] = '../../mst_rab_btl/views/table_js';
		$data['btnurl'] = base_url().'index.php/rab-btl/form';
		$this->buildView($data);
	}
	
	public function form($id = FALSE) {
		$data = array();
		$data['idmenu'] = 'rabbtl-form';
		$data['content'] = '../../mst_rab_btl/views/form';
		$data['datacontent']['list_sumberdaya'] = $this->mst_rab_btl_model->get_sumberdaya();
		$data['datacontent']['list_tahap'] = $this->mst_rab_btl_model->get_tahap(); 
		
		$data['js'] = '../../mst_rab_btl/views/form_js';
		if($id!==FALSE) {
			$data['datajs'] = $this->mst_rab_btl_model->get($id);
		}
		$this->buildView($data);
	}
	
	public function save() {
		$data = $this->input->post();
		if($this->input->post('id')==='') {
			return $this->mst_rab_btl_model->_insert($data);
		} else {
			return $this->mst_rab_btl_model->_update($data, $this->input->post('id'));
		}
	}
	
	public function delete($id) {
		$res = $this->mst_rab_btl_model->_delete($id);
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
	
	public function genDxxT() {
		// $this->output->enable_profiler(TRUE);
		$this->datatables->select('btl.id, btl.kode_tahap, btl.kode_sumberdaya, btl.harga, btl.harga_rev')
				->unset_column('btl.id')
				->from('tr_rab_btl btl')
				->where(array('btl.kode_entity'=>$this->session->userdata('kode_entity')))
				->add_column('action', '<a href="javascript:action(\'edit\',\'$1\')"><span class="glyphicons glyphicons-edit"></span></a>&nbsp;&nbsp'.
						'<a href="javascript:action(\'delete\',\'$1\')"><span class="glyphicons glyphicons-bin"></span></a>', 't.id');
		echo $this->datatables->generate();
	}

	public function genDT(){
		$this->datatables->select('btl.id, btl.kode_coa, btl.kode_sumberdaya, btl.harga, btl.harga_rev')
				->unset_column('btl.id')
				->from('tr_rab_btl btl')
				->where(array('kode_entity'=>$this->session->userdata('kode_entity')))
				->add_column('action', '<a href="javascript:action(\'edit\',\'$1\')"><span class="glyphicons glyphicons-edit"></span></a>&nbsp;&nbsp'.
						'<a href="javascript:action(\'delete\',\'$1\')"><span class="glyphicons glyphicons-bin"></span></a>', 'id');
		echo $this->datatables->generate();
	}
	
}