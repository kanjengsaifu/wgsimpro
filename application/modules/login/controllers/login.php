<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('m_login');
	}

	public function index() {
		$sess = array(
			'usernm' => '',
			'isloggedin' => FALSE,
			'id_entity'=>'',
			'kode_entity'=>'',
			'tipe_entity'=>''
		);
		$this->session->unset_userdata($sess);
		$this->load->view('login2');
	}
	
	public function doLogin() {
		$us = $this->input->post('username');
		$pw = $this->input->post('password');
		$res = $this->m_login->chkLogin($us, $pw);
		//var_dump($res);exit;
		if($res>0) {
			redirect(base_url().'index.php/home');
		} else {
			redirect(base_url().'index.php/login');
		}
	}
	
	public function doLogout() {
		$sess = array(
			'usernm' => '',
			'isloggedin' => FALSE,
			'id_entity'=>'',
			'kode_entity'=>'',
			'tipe_entity'=>''
		);
		$this->session->unset_userdata($sess);
		redirect(base_url().'index.php/login');
	}
	
}