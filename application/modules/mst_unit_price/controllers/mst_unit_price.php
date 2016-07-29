<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPCLASS;

class Mst_unit_price extends App {
	
	public function __construct() {

		parent::__construct();
		$this->load->model('mst_unit_price_model');
		$this->load->library('datatables');
	}

	public function index() {

	}
	
	public function form($id = FALSE) {
		$data['idmenu'] = 'unit-price-form';
		$data['content'] = '../../mst_unit_price/views/form';
		$data['datacontent'] = $this->mst_unit_price_model->get_optional();
		$data['js'] = '../../mst_unit_price/views/form_js';
		$this->buildView($data);
		// $this->output->enable_profiler(TRUE);
	}
	
	public function get_price($no_unit) {
		// $this->output->enable_profiler(TRUE);
		// $this->mst_unit_price_model->get_prices($no_unit);
		$this->output->set_content_type('application/json');
		echo json_encode($this->mst_unit_price_model->get_prices($no_unit));
	}
	
	public function save() {
		$data = $this->input->post();
		$data['rp'] = str_replace(',', '', $data['rp']);
		$id = '';
		// if($this->input->post('id')==='') {
			$id = $this->mst_unit_price_model->_insert($data);
		// } else {
			// $id = $this->mst_unit_price_model->_update($data, $this->input->post('id'));
		// }
		echo $id;
	}
	
	public function delete($id) {
		$res = $this->mst_unit_price_model->_delete($id);
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
		$this->datatables->select('MD5(s.no_unit) AS xnounit, s.no_unit AS no_unit,stypep.konten AS type_property,stypeu.konten AS type_unit,'.
					'stower.konten AS tower_cluster,s.wide_netto AS wide_netto,s.wide_gross AS wide_gross,slantai.konten AS lantai_blok,'.
					'sdir.konten AS direction, sangin.konten AS mata_angin',FALSE)
			->unset_column('xnounit')
			->from('mst_stock s')
			->join('mst_optional_stock stypep', 'stypep.kode = s.type_property AND stypep.sfield = "type_property" AND stypep.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->join('mst_optional_stock stower', 'stower.kode = s.tower_cluster AND stower.sfield = "tower_cluster" AND stower.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->join('mst_optional_stock stypeu', 'stypeu.kode = s.type_unit AND stypeu.sfield = "type_unit" AND stypeu.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->join('mst_optional_stock slantai', 'slantai.kode = s.lantai_blok AND slantai.sfield = "lantai_blok" AND slantai.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->join('mst_optional_stock sdir', 'sdir.kode = s.direction AND sdir.sfield = "direction" AND sdir.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->join('mst_optional_stock sangin', 'sangin.kode = s.mata_angin AND sangin.sfield = "mata_angin" AND sangin.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->where('s.kode_entity = "'.$this->session->userdata('kode_entity').'" AND '.
					's.no_unit NOT IN (SELECT no_unit FROM tr_payment WHERE iscancelled = 0 AND kode_entity = "'.$this->session->userdata('kode_entity').'")')
			->add_column('action', '<a href="javascript:" class="row-unit" data-encunit="$1" data-unit="$2"><span class="glyphicons glyphicons-check"></span> View</a>', 
					'xnounit,no_unit');
		echo $this->datatables->generate();
		// $this->output->enable_profiler(TRUE);
	}

	public function set_rounding($no_unit) {
		// $this->output->enable_profiler(TRUE);
		echo $this->mst_unit_price_model->_rounding($no_unit);
	}
	
}