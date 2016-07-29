<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPCLASS;

class Mst_diskon extends App {
	
	public function __construct() {

		parent::__construct();
		$this->load->model('mst_diskon_model');
		$this->load->library('datatables');
	}

	public function index() {

	}
	
	public function table() {
		$data['idmenu'] = 'diskon-table';
		$data['content'] = '../../mst_diskon/views/table';
		$data['js'] = '../../mst_diskon/views/table_js';
		$data['btnurl'] = base_url().'index.php/diskon/form/';
		$this->buildView($data);
	}

	public function form($id = FALSE) {
		$data['idmenu'] = 'diskon-form';
		$data['content'] = '../../mst_diskon/views/form';
		$data['js'] = '../../mst_diskon/views/form_js';
		if($id!==FALSE) {
			$data['datajs'] = $this->mst_diskon_model->get($id);
		}
		$this->buildView($data);
	}

	public function genDT() {
		$this->datatables->select('id, nama, diskon, jenis, mekanisme')
			->unset_column('id')
			->from('mst_diskon')
			->add_column('action', '<a href="'.base_url().'index.php/diskon/form/$1"><span class="glyphicons glyphicons-edit"></span></a>&nbsp;&nbsp'.
				'<a href="javascript:" data-id="$1" class="row-delete"><span class="glyphicons glyphicons-bin"></span></a>', 'id');
		echo $this->datatables->generate();
	}

	public function save() {
		$data = $this->input->post();
		if($data['id']==='') {
			return $this->mst_diskon_model->_insert($data);
		} else {
			return $this->mst_diskon_model->_update($data, $data['id']);
		}
	}

	public function delete($id) {
		return $this->mst_diskon_model->_delete($id);
	}
	
}