<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPCLASS;

class Tr_opname_progress extends App {
	
	public function __construct() {
		parent::__construct();
			
		$this->load->model('tr_opname_progress_model');
		$this->load->library('datatables');
		$this->load->library('dateUtils');
	}

	public function index() {
		$data = array();
		$data['idmenu'] = 'opname-progress-table';
		$data['content'] = '../../tr_opname_progress/views/table';
		$data['js'] = '../../tr_opname_progress/views/table_js';
		$data['btnurl'] = base_url().'index.php/opname-progress/form';
		$this->buildView($data);
	}
	
	public function form($id = FALSE) {
		$data = array();
		$data['idmenu'] = 'opname-progress-form';
		$data['content'] = '../../tr_opname_progress/views/form';
		$data['datacontent']['list_tahap'] = $this->tr_opname_progress_model->get_optional_tahap();
		$data['js'] = '../../tr_opname_progress/views/form_js';
		if($id!==FALSE) {
			$data['datajs'] = $this->tr_opname_progress_model->get($id);
		}
		$this->buildView($data);
	}
	
	public function save() {
		$data = $this->input->post();
		$data['tanggal'] = $this->dateutils->dateStr_to_mysql($data['tanggal']);
		$data['volume'] = str_replace(',', '', $data['volume']);
		if($this->input->post('id')==='') {
			return $this->tr_opname_progress_model->_insert($data);
		} else {
			return $this->tr_opname_progress_model->_update($data, $this->input->post('id'));
		}
	}
	
	public function delete($id) {
		$res = $this->tr_opname_progress_model->_delete($id);
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
		$this->datatables->select('op.id, DATE_FORMAT(op.tanggal,"%d/%m/%Y") as tanggal, t.nama as Tahap, spk.nama as Nama , FORMAT(op.volume,2) as volume', FALSE)
				->unset_column('op.id')
				->from('tr_opname_progress op')
				->join('mst_tahap t','t.kode=op.kode_tahap')
				->join('tr_spk spk' , 'spk.kode=op.kode_spk')
				->where(array('op.kode_entity' => $this->session->userdata('kode_entity')))
				->add_column('action', '<a href="javascript:action(\'edit\',\'$1\')" class="row-edit" data-id="$1"><span class="glyphicons glyphicons-edit"></span></a>&nbsp;&nbsp'.
						'<a href="javascript:action(\'delete\',\'$1\')" class="row-delete" data-id="$1"><span class="glyphicons glyphicons-bin"></span></a>', 'op.id');
		echo $this->datatables->generate();
	}
	
}