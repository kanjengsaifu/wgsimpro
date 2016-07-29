<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPCLASS;

class Mail_Notification extends App {

	function __construct()
	{	
		// Commented this for allow access from other machine
		// if($_SERVER['REMOTE_ADDR']!='127.0.0.1') exit("Access Denied.");	
		parent::__construct();
		//$this->load->library('Plugins');
	}

	function index() {}

	function broadcast(){
		$this->load->helper('utilitys');


		$mail_from 	= MAIL_FROM;
		$passFrom 	= MAIL_FROM_PASSWORD;
		$mail_cc 	= MAIL_CC;
		$subject = 'PERCOBAAN';
		$message = 'coba dulu aja yaaaa......<br>dasdasdasdasd.....<b>sadasoiqpwoeipqwjelkqwe</b>';
		$mail_to = array(
					array('nama'=>'Abi Alif','address'=>'chairoelz@hotmail.com'),
					array('nama'=>'Mama Alif','address'=>'fermita.guchany@gmail.com')
					);
		$attachment = array();
		sendEmail($mail_from,$mail_to,$cc='',$subject,$message,$attachment);
	}

}