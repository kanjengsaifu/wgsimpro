<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPCLASS;

class Tr_sinkron extends App {
	
	public function __construct() {

		parent::__construct();
		$this->load->model('tr_sinkron_model');
        $this->load->library('dateUtils');
        $this->load->library('datatables');
	}

	public function form_sales() {
		$data['idmenu'] = 'setting-sinkron-sales';
		$data['content'] = '../../tr_sinkron/views/form_sinkron_sales';
        // $data['datacontent'] = $this->tr_sinkron_model->get_optional();
		$data['js'] = '../../tr_sinkron/views/form_sinkron_sales_js';
		$this->buildView($data);
	}

	public function do_sinkron_sales() {
		$url = $this->input->post('url');
		$json = file_get_contents($url.'/index.php/api/do_backup_sales/'.$this->session->userdata('kode_entity'));
		echo $this->tr_sinkron_model->do_proses_sales($json);
	}

	public function form_trx() {
		$data['idmenu'] = 'setting-sinkron-trx';
		$data['content'] = '../../tr_sinkron/views/form_sinkron_trx';
        // $data['datacontent'] = $this->tr_sinkron_model->get_optional();
		$data['js'] = '../../tr_sinkron/views/form_sinkron_trx_js';
		$this->buildView($data);
	}

	public function do_backup_trx() {
		echo json_encode($this->tr_sinkron_model->do_backup_trx());
	}

}