<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPCLASS;

class Mst_entity extends App {
	
	public function __construct() {
		parent::__construct();
			
		$this->load->model('mst_entity_model');
		$this->load->library('datatables');
		$this->load->library('dateUtils');
	}

	public function index() {
		$data = array();
		$data['idmenu'] = 'entity-table';
		$data['content'] = '../../mst_entity/views/table';
		$data['js'] = '../../mst_entity/views/table_js';
		$data['btnurl'] = base_url().'index.php/entity/form';
		$this->buildView($data);
	}
	
	public function form($id = FALSE) {
		$data = array();
		$data['idmenu'] = 'entity-form';
		$data['content'] = '../../mst_entity/views/form';
		$data['datacontent'] = $this->mst_entity_model->get_optional();
		$data['js'] = '../../mst_entity/views/form_js';
		if($id!==FALSE) {
			$data['datajs'] = $this->mst_entity_model->get($id);
		}
		$this->buildView($data);
	}
	
	public function save() {
		$data = $this->input->post();
		$data['tgl_mulai'] = $this->dateutils->dateStr_to_mysql($data['tgl_mulai']);
		$data['tgl_selesai'] = $this->dateutils->dateStr_to_mysql($data['tgl_selesai']);
		$data['nilai_developer'] = str_replace(',', '', $data['nilai_developer']);
		$data['nilai_no_tax'] = str_replace(',', '', $data['nilai_no_tax']);
		if($this->input->post('id')==='') {
			return $this->mst_entity_model->_insert($data);
		} else {
			return $this->mst_entity_model->_update($data, $this->input->post('id'));
		}
	}
	
	public function delete($id) {
		$res = $this->mst_entity_model->_delete($id);
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
		$this->datatables->select('e.id,e.kode as kode,e.nama as nama,ejenis.konten AS jenis,etype.konten AS tipe,'.
					'DATE_FORMAT(e.tgl_mulai,"%d/%m/%Y") as tgl_mulai,DATE_FORMAT(e.tgl_selesai,"%d/%m/%Y") as tgl_selesai,'.
					'FORMAT(e.nilai_developer,2) as nilai_developer,e.pemilik as pemilik,estatus.konten AS status_entity', FALSE)
				->unset_column('e.id')
				->from('mst_entity e')
				->join('mst_optional_entity ejenis','ejenis.kode=e.jenis')
				->join('mst_optional_entity etype','etype.kode=e.type_entity')
				->join('mst_optional_entity estatus','estatus.kode=e.status_entity')
				->add_column('action', '<a href="javascript:action(\'edit\',\'$1\')"><span class="glyphicons glyphicons-edit"></span></a>&nbsp;&nbsp'.
						'<a href="javascript:action(\'delete\',\'$1\')"><span class="glyphicons glyphicons-bin"></span></a>', 'e.id');
		echo $this->datatables->generate();
	}
	
}