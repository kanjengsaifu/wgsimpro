<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPCLASS;

class Mst_rik extends App {
	
	public function __construct() {
		parent::__construct();
			
		$this->load->model('mst_rik_model');
		$this->load->library('datatables');
	}

	public function index() {
		$data = array();
		$data['idmenu'] = 'rik-header';
		$data['content'] = '../../mst_rik/views/table';
		$data['js'] = '../../mst_rik/views/table_js';
		$this->buildView($data);
	}
	
	public function form($kode_entity) {
		$data = array();
		$data['idmenu'] = 'rik-header-input';
		$data['content'] = '../../mst_rik/views/form';
		$data['datacontent'] = $this->mst_rik_model->get_optional($kode_entity);
		$data['js'] = '../../mst_rik/views/form_js';
		$data['datajs'] = $this->mst_rik_model->get_rik($kode_entity);
		$this->buildView($data);
	}
	
	public function save() {
		$data = $this->input->post();
		$this->mst_rik_model->save($data);
		
		$out = array();
		// if($res) {
			$out['status'] = '200';
			$out['msg'] = "Data tersimpan";
		// } else {
			// $out['status'] = '500';
			// $out['msg'] = "Terjadi kesalahan, silahkan kontak administrator.";
		// }
		$this->output->set_content_type('application/json');
		echo json_encode($out);
	}
	
	public function genDT() {
		$this->datatables->select('e.id, e.kode as kode, e.nama as nama, e.type_entity as type_entity')
				->unset_column('e.id')
				->from('mst_entity e')
				->where(array('e.kode'=>$this->session->userdata('kode_entity')))
				->add_column('action', '<a href="javascript:action(\'edit\',\'$1\')"><span class="glyphicons glyphicons-edit"></span></a>&nbsp;&nbsp','kode');
		echo $this->datatables->generate();
	}

	public function get_detail_produk(){
		$this->output->set_content_type('application/json');
		echo json_encode($this->mst_rik_new_model->get_detail_produk());
	}
	
}