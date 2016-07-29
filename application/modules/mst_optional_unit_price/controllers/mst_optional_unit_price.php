<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPCLASS;

class Mst_optional_unit_price extends App {
	
	public function __construct() {
		parent::__construct();
			
		$this->load->model('mst_optional_unit_price_model');
		$this->load->library('datatables');
	}

	public function index() {
		$data['idmenu'] = 'optional-stock';
		$data['content'] = '../../mst_optional_unit_price/views/form';
		$data['js'] = '../../mst_optional_unit_price/views/form_js';
		$this->buildView($data);
	}

	public function genDT($sfield) {
		// $this->output->enable_profiler(TRUE);
		$this->datatables->select('grup, kode, konten, formula, no_urut, id')
			->unset_column('id')
			->from('mst_optional_unit_price')
			->where(array('sflag'=>$this->session->userdata('type_entity'), 'sfield'=>$sfield))
			->add_column('action', '<a href="javascript:" class="row-edit" data-id="$1"><span class="glyphicons glyphicons-edit"></span></a>&nbsp;&nbsp'.
				'<a href="javascript:" class="row-delete" data-id="$1"><span class="glyphicons glyphicons-bin"></span></a>', 'id');
		echo $this->datatables->generate();
	}

	public function save() {
		$data = $this->input->post();
		if($data['id']==='') {
			return $this->mst_optional_unit_price_model->_insert($data);
		} else {
			return $this->mst_optional_unit_price_model->_update($data, $data['id']);
		}
	}

	public function delete($id) {
		return $this->mst_optional_unit_price_model->_delete($id);
	}
	
}