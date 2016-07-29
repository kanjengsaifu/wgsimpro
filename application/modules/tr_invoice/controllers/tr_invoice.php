<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPCLASS;

class Tr_invoice extends App {
	
	public function __construct() {
		parent::__construct();
			
		$this->load->model('tr_invoice_model');
		$this->load->library('datatables');
		$this->load->library('dateUtils');
	}

	public function index() {
		$data = array();
		$data['idmenu'] = 'invoice-table';
		$data['content'] = '../../tr_invoice/views/table';
		$data['js'] = '../../tr_invoice/views/table_js';
		$data['btnurl'] = base_url().'index.php/invoice/form';
		$this->buildView($data);
	}
	
	public function form($id = FALSE) {
		$data = array();
		$data['idmenu'] = 'invoice-form';
		$data['content'] = '../../tr_invoice/views/form';
		$data['datacontent'] = $this->tr_invoice_model->get_optional();
		$data['js'] = '../../tr_invoice/views/form_js';
		if($id!==FALSE) {
			$data['datajs'] = $this->tr_invoice_model->get_inv_and_detail($id);
			//var_dump($data);
		}
		

		$this->buildView($data);
	}
	
	public function save() {
		$data = $this->input->post();
		$data['tanggal'] = $this->dateutils->dateStr_to_mysql($data['tanggal']);
		$data['tgl_surat_jalan'] = $this->dateutils->dateStr_to_mysql($data['tgl_surat_jalan']);
		$data['tgl_bapb'] = $this->dateutils->dateStr_to_mysql($data['tgl_bapb']);
		if($this->input->post('id')==='') {
			return $this->tr_invoice_model->_insert($data);
		} else {
			return $this->tr_invoice_model->_update($data, $this->input->post('id'));
		}
	}
	
	public function delete($id) {
		$res = $this->tr_invoice_model->_delete($id);
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

	public function delete_sd($id) {
		$res = $this->tr_invoice_model->_delete_sd($id);
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
		$this->datatables->select('inv.id, inv.tanggal, inv.no_po, rek.nama, bpdp.uraian', FALSE)
			->from('tr_invoice inv')
			->unset_column('inv.id')
			->join('mst_rekanan rek', 'rek.kode_rekanan = inv.kode_rekanan', 'inner')
			->join('tr_bpdp bpdp', 'bpdp.no_path = inv.kode_bpdp AND bpdp.kode_entity = inv.kode_entity', 'inner')
			->where(array('inv.kode_entity'=>$this->session->userdata('kode_entity')))
			->add_column('action', '<a href="'.base_url().'index.php/invoice/edit/$1" class="row-edit" data-id="$1">'.
				'<span class="glyphicons glyphicons-edit"></span></a>&nbsp;&nbsp'.
				'<a href="javascript:" class="row-delete" data-id="$1">'.
				'<span class="glyphicons glyphicons-bin"></span></a>', 'inv.id');
		echo $this->datatables->generate();
	}
	
}