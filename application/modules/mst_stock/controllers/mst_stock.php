<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPCLASS;

class Mst_stock extends App {
	
	public function __construct() {
		parent::__construct();
			
		$this->load->model('mst_stock_model');
		$this->load->library('datatables');
		$this->load->library('dateUtils');
	}

	public function index() {
		$data['idmenu'] = 'stock-table';
		$data['content'] = '../../mst_stock/views/table';
		$data['js'] = '../../mst_stock/views/table_js';
		$data['btnurl'] = base_url().'index.php/stock/form';
		$this->buildView($data);
	}
	
	public function form($id = FALSE) {
		$data['idmenu'] = 'stock-form';
		$data['content'] = '../../mst_stock/views/form';
		$data['datacontent'] = $this->mst_stock_model->get_optional();
		$data['js'] = '../../mst_stock/views/form_js';
		if($id!==FALSE)
			$data['datajs'] = $this->mst_stock_model->get($id);
		$this->buildView($data);
	}
	
	public function save() {
		$data = $this->input->post();
		$data['land_len'] = str_replace(',', '', $data['land_len']);
		$data['land_wid'] = str_replace(',', '', $data['land_wid']);
		$data['wide_netto'] = str_replace(',', '', $data['wide_netto']);
		$data['wide_gross'] = str_replace(',', '', $data['wide_gross']);
		/*$data['wide_netto_2'] = str_replace(',', '', $data['wide_netto_2']);
		$data['wide_gross_2'] = str_replace(',', '', $data['wide_gross_2']);
		$data['wide_netto_3'] = str_replace(',', '', $data['wide_netto_3']);
		$data['wide_gross_3'] = str_replace(',', '', $data['wide_gross_3']);*/
		$data['extra_area'] = str_replace(',', '', $data['extra_area']);
		$data['recog_date'] = $this->dateutils->dateStr_to_mysql($data['recog_date']);
		if($data['id']==='') {
			$data['no_unit'] = ($this->session->userdata('type_entity')=='LD' ? 
					$data['lantai_blok'].'-'.$data['kavling'].'-' : 
					$data['tower_cluster'].'-'.$data['lantai_blok'].'-') .
					$this->mst_stock_model->gen_no_unit();
			return $this->mst_stock_model->_insert($data);
		} else {
			return $this->mst_stock_model->_update($data, $data['id']);
		}
	}
	
	public function delete($id) {
		$res = $this->mst_stock_model->_delete($id);
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
		$this->datatables->select('s.id,s.no_unit AS no_unit,stypep.konten AS type_property,stypeu.konten AS type_unit,stower.konten AS tower_cluster,'.
					's.wide_netto AS wide_netto,s.wide_gross AS wide_gross,slantai.konten AS lantai_blok,'.
					'sdir.konten AS direction, sangin.konten AS mata_angin')
			->unset_column('s.id')
			->from('mst_stock s')
			->join('mst_optional_stock stypep', 'stypep.kode = s.type_property AND stypep.sfield="type_property" AND stypep.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->join('mst_optional_stock stower', 'stower.kode = s.tower_cluster AND stower.sfield="tower_cluster" AND stower.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->join('mst_optional_stock stypeu', 'stypeu.kode = s.type_unit AND stypeu.sfield="type_unit" AND stypeu.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->join('mst_optional_stock slantai', 'slantai.kode = s.lantai_blok AND slantai.sfield="lantai_blok" AND slantai.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->join('mst_optional_stock sdir', 'sdir.kode = s.direction AND sdir.sfield="direction" AND sdir.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->join('mst_optional_stock sangin', 'sangin.kode = s.mata_angin AND sangin.sfield="mata_angin" AND sangin.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->where(array('s.kode_entity'=>$this->session->userdata('kode_entity')))
			->add_column('action', '<a href="javascript:action(\'edit\',\'$1\')"><span class="glyphicons glyphicons-edit"></span></a>&nbsp;&nbsp'.
				'<a href="javascript:action(\'delete\',\'$1\')"><span class="glyphicons glyphicons-bin"></span></a>', 's.id');
		echo $this->datatables->generate();
	}

	public function genDT_ro() {
		$this->datatables->select('MD5(s.no_unit) AS xnounit, s.no_unit AS no_unit,stypep.konten AS type_property,stypeu.konten AS type_unit,'.
					'stower.konten AS tower_cluster,s.wide_netto AS wide_netto,s.wide_gross AS wide_gross,slantai.konten AS lantai_blok,'.
					'sdir.konten AS direction, sangin.konten AS mata_angin',FALSE)
			->unset_column('xnounit')
			->from('mst_stock s')
			->join('mst_optional_stock stypep', 'stypep.kode = s.type_property AND stypep.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->join('mst_optional_stock stower', 'stower.kode = s.tower_cluster AND stower.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->join('mst_optional_stock stypeu', 'stypeu.kode = s.type_unit AND stypeu.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->join('mst_optional_stock slantai', 'slantai.kode = s.lantai_blok AND slantai.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->join('mst_optional_stock sdir', 'sdir.kode = s.direction AND sdir.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->join('mst_optional_stock sangin', 'sangin.kode = s.mata_angin AND sangin.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->where(array('s.kode_entity'=>$this->session->userdata('kode_entity')))
			->add_column('action', '<a href="javascript:" class="row-unit" data-encunit="$1" data-unit="$2"><span class="glyphicons glyphicons-check"></span> View</a>', 
					'xnounit,no_unit');
		echo $this->datatables->generate();
	}
	
}