<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPCLASS;

class Tr_bpdp extends App {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('tr_bpdp_model');
		$this->load->library('datatables');
	}

	public function index() {
		$data = array();
		$data['idmenu'] = 'bpdp-table';
		$data['content'] = '../../tr_bpdp/views/table';
		$data['js'] = '../../tr_bpdp/views/table_js';
		$this->buildView($data);
	}

	public function form($kode_entity) {
		$data = array();
		$data['idmenu'] = 'bpdp-table';
		$data['content'] = '../../tr_bpdp/views/form';
		$data['datacontent'] = $this->tr_bpdp_model->get_optional();
		$data['js'] = '../../tr_bpdp/views/form_js';
		$data['datajs']['entity'] = $this->tr_bpdp_model->get_by_kode($kode_entity);
		$data['datajs']['option'] = $this->tr_bpdp_model->get_optional();
		$this->buildView($data);
	}

	public function get($kode_entity, $tahun, $prop = FALSE, $jenis = FALSE) {
		// $this->output->enable_profiler(TRUE);
		$this->output->set_content_type('application/json');
		echo json_encode($this->tr_bpdp_model->get($kode_entity, $tahun, $prop, $jenis));
	}

	public function genDT() {
		// $this->output->enable_profiler(TRUE);
		$this->datatables->select('e.kode as kode,e.nama as nama,ejenis.konten AS jenis,etype.konten AS tipe,'.
					'DATE_FORMAT(e.tgl_mulai,"%d/%m/%Y") as tgl_mulai,DATE_FORMAT(e.tgl_selesai,"%d/%m/%Y") as tgl_selesai,'.
					'FORMAT(e.nilai_developer,2) as nilai_developer,e.pemilik as pemilik,estatus.konten AS status_entity', FALSE)
				->from('mst_entity e')
				->join('mst_optional_entity ejenis','ejenis.kode=e.jenis')
				->join('mst_optional_entity etype','etype.kode=e.type_entity')
				->join('mst_optional_entity estatus','estatus.kode=e.status_entity')
				->where(array('e.kode'=>$this->session->userdata('kode_entity')))
				->add_column('action', '<a href="'.base_url().'index.php/bpdp/form/$1" class="row-data"><span class="glyphicons glyphicons-edit"></span></a>', 'kode');
		echo $this->datatables->generate();
	}

	public function save() {
		$data = $this->input->post();
		return $this->tr_bpdp_model->save($data);
		// print_r($data);
	}

}