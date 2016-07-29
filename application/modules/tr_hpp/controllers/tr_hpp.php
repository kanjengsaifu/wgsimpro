<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPCLASS;

class Tr_hpp extends App {
	
	public function __construct() {

		parent::__construct();
		$this->load->model('tr_hpp_model');
		$this->load->library('datatables');
	}

	public function index() {

	}
	
	public function form($id = FALSE) {
		$data['idmenu'] = 'hpp-form';
		if($this->session->userdata('type_entity')=='LD') {
			$data['content'] = '../../tr_hpp/views/form';
			$data['datacontent'] = $this->tr_hpp_model->get_optional();
			$data['js'] = '../../tr_hpp/views/form_js';
		} elseif($this->session->userdata('type_entity')=='HR') {
			$data['content'] = '../../tr_hpp/views/form_hr';
			$data['datacontent'] = $this->tr_hpp_model->get_optional_hr();
			$data['js'] = '../../tr_hpp/views/form_hr_js';
		}
		$this->buildView($data);
	}

	public function form_progress() {
		$data['idmenu'] = 'progress-form';
		$data['content'] = '../../tr_hpp/views/form_progress';
		$data['datacontent'] = $this->tr_hpp_model->get_total_progress();
		$data['js'] = '../../tr_hpp/views/form_progress_js';
		$this->buildView($data);
	}
	
	public function save($idx = 0) {
		$data = $this->input->post();
		$data['kode_entity'] = $this->session->userdata('kode_entity');
		if($idx===0) {
			$data['rp'] = str_replace(',', '', $data['rp']);
			return $this->tr_hpp_model->_insert($data);
		} else {
			return $this->tr_hpp_model->_insert_hr($data);
		}
	}

	public function genDT() {
		$this->datatables->select('MD5(s.no_unit) AS xnounit, s.no_unit AS no_unit,stypep.konten AS type_property,stypeu.konten AS type_unit,'.
				'stower.konten AS tower_cluster,s.wide_netto AS wide_netto,s.wide_gross AS wide_gross,slantai.konten AS lantai_blok,'.
				'FORMAT(IFNULL(hpp.rp, 0),2) AS rp',FALSE)
			->unset_column('xnounit')
			->from('mst_stock s')
			->join('mst_optional_stock stypep', 'stypep.kode = s.type_property AND stypep.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->join('mst_optional_stock stower', 'stower.kode = s.tower_cluster AND stower.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->join('mst_optional_stock stypeu', 'stypeu.kode = s.type_unit AND stypeu.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->join('mst_optional_stock slantai', 'slantai.kode = s.lantai_blok AND slantai.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->join('(SELECT kode_entity, no_unit, SUM(rp) AS rp FROM tr_hpp GROUP BY kode_entity, no_unit) AS hpp', 'hpp.kode_entity = s.kode_entity AND hpp.no_unit = s.no_unit', 'left')
			->where('s.kode_entity = "'.$this->session->userdata('kode_entity').'"')
			->add_column('action', '<a href="javascript:" class="row-unit" data-encunit="$1" data-unit="$2"><span class="glyphicons glyphicons-check"></span> View</a>', 
					'xnounit,no_unit');
		echo $this->datatables->generate();
	}

	public function genDT_progress() {
		if($this->session->userdata('type_entity')==='LD') {
			$this->datatables->select('s.no_unit AS no_unit,stypep.konten AS type_property,stypeu.konten AS type_unit,'.
					'FORMAT(IFNULL(hpp.rp, 0),2) AS hpp, FORMAT(IFNULL(ri.rp,0), 2) AS ri, FORMAT(IFNULL(ri.rp,0)/IFNULL(hpp.rp, 0)*100, 2) AS progress',FALSE)
				->from('mst_stock s')
				->join('mst_optional_stock stypep', 'stypep.kode = s.type_property AND stypep.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
				->join('mst_optional_stock stower', 'stower.kode = s.tower_cluster AND stower.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
				->join('mst_optional_stock stypeu', 'stypeu.kode = s.type_unit AND stypeu.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
				->join('(SELECT kode_entity, no_unit, SUM(rp) AS rp FROM tr_hpp GROUP BY kode_entity, no_unit) AS hpp', 'hpp.kode_entity = s.kode_entity AND hpp.no_unit = s.no_unit', 'left')
				->join('(SELECT invunit.kode_entity, invunit.no_unit, inv.rp / tbl.n AS rp FROM tr_invoice_unit invunit '.
					'LEFT JOIN ( SELECT no_po, COUNT(*) AS n FROM tr_invoice_unit GROUP BY no_po ) AS tbl ON tbl.no_po = invunit.no_po '.
					'INNER JOIN tr_invoice inv ON inv.no_po = invunit.no_po) AS ri', 'ri.kode_entity = s.kode_entity AND ri.no_unit = s.no_unit', 'left')
				->where('s.kode_entity = "'.$this->session->userdata('kode_entity').'"');
		} elseif($this->session->userdata('type_entity')==='HR') {
			$this->datatables->select('s.no_unit AS no_unit,stypep.konten AS type_property,stypeu.konten AS type_unit,'.
					'FORMAT(IFNULL(hpp.rp, 0),2) AS hpp, FORMAT(IFNULL(ri.rp,0), 2) AS ri, FORMAT(IFNULL(ri.rp,0)/IFNULL(hpp.rp, 0)*100, 2) AS progress',FALSE)
				->from('mst_stock s')
				->join('mst_optional_stock stypep', 'stypep.kode = s.type_property AND stypep.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
				->join('mst_optional_stock stower', 'stower.kode = s.tower_cluster AND stower.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
				->join('mst_optional_stock stypeu', 'stypeu.kode = s.type_unit AND stypeu.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
				->join('(SELECT stk.kode_entity, stk.no_unit, stk.wide_gross * SUM(hpp.rp) / rik.luas AS rp FROM tr_hpp_hr hpp '.
					'INNER JOIN mst_stock stk ON stk.kode_entity = hpp.kode_entity AND stk.type_property = hpp.type_property '.
					'INNER JOIN ( SELECT kode_entity, type_property, SUM(luas * volume) AS luas FROM tr_rik_detail_rencana_produk '.
					'GROUP BY kode_entity, type_property ) AS rik ON rik.kode_entity = hpp.kode_entity AND rik.type_property = hpp.type_property '.
					'GROUP BY stk.kode_entity, stk.type_property, stk.no_unit) AS hpp', 'hpp.kode_entity = s.kode_entity AND hpp.no_unit = s.no_unit', 'left')
				->join('(SELECT invunit.kode_entity, invunit.no_unit, inv.rp / tbl.n AS rp FROM tr_invoice_unit invunit '.
					'LEFT JOIN ( SELECT no_po, COUNT(*) AS n FROM tr_invoice_unit GROUP BY no_po ) AS tbl ON tbl.no_po = invunit.no_po '.
					'INNER JOIN tr_invoice inv ON inv.no_po = invunit.no_po) AS ri', 'ri.kode_entity = s.kode_entity AND ri.no_unit = s.no_unit', 'left')
				->where('s.kode_entity = "'.$this->session->userdata('kode_entity').'"');
		}
		echo $this->datatables->generate();
	}

	public function get_hpp($enc_unit) {
		$this->output->set_content_type('application/json');
		echo json_encode($this->tr_hpp_model->get_hpp($enc_unit));
	}

	public function get_hpp_hr($kode_entity) {
		$this->output->set_content_type('application/json');
		echo json_encode($this->tr_hpp_model->get($kode_entity));
	}
	
}