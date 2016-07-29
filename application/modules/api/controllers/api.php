<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPCLASS;

class Api extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('api_model');
	}

	public function do_backup_sales($kode_entity) {
		echo json_encode($this->api_model->do_backup_sales($kode_entity));
	}

	public function do_sinkron_trx() {
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Methods: GET, POST");
		echo $this->api_model->do_sinkron_trx();
	}

}