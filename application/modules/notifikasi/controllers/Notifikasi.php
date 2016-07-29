<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPCLASS;

class Notifikasi extends App {

	public function __construct()
	{	
		parent::__construct();
		$this->load->model('Notifikasi_model');
		$this->load->helper('utilitys');
	}

	public function index($rsv_no=FALSE) {
		$data = array();
		
		if($rsv_no==FALSE){
			$data['idmenu'] 		= 'notifikasi_smsemail';
			$data['content'] 		= '../../Notifikasi/views/table';
			$data['datacontent']['jdata'] 	= $this->Notifikasi_model->getDataGroup();
		}else{
			$data['idmenu'] 		= 'notifikasi_smsemail_detail';
			$data['content'] 		= '../../Notifikasi/views/table_detail';
			$data['datacontent']['jdata'] 	= $this->Notifikasi_model->getDataDetail($rsv_no);
		}
		$data['js'] 			= '../../Notifikasi/views/table_js';
		
		$this->buildView($data);
	} 

}