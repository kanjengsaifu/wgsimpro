<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPCLASS;

class Rpt_Apk extends App {
	
	public function __construct() {
		parent::__construct();
			
		$this->load->model('rpt_apk_model');
		$this->load->library('dateUtils');
		$this->load->library('strUtils');
	}

	public function index() {
		$data = array();
		$data['idmenu'] = 'rab-bl';
		$data['content'] = '../../tr_rab_bl/views/table';
		$data['js'] = '../../tr_rab_bl/views/table_js';
		$data['btnurl'] = base_url().'index.php/rab-bl/form';
		$this->buildView($data);
	}

	public function f_periode($nm_modul=false) {
        $data['idmenu']                 = 'rpt-apk-persediaan';
        $data['content']                = '../../rpt_apk/views/f_periode';
        $data['js']                     = '../../rpt_apk/views/f_periode_js';
        $data['datacontent']['target']  = $nm_modul==false?'':$nm_modul;
        //$data['datacontent']['kombo']           = $this->rpt_opensystem_model->generateOptionBox();

        $this->buildView($data);
    }

	function generateReport($nm_modul,$periode=false)
    {
        //$data = $this->input->post();

        //$divisi = $data['divisi'];

        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $kd_spk = $this->session->userdata('kode_entity');
        if($periode==FALSE) {
            $this->f_periode($nm_modul);
        } else {
            $data = array();
            $data['idmenu']                   	= 'rpt-apk-'.$nm_modul;
            
            $data['content']                    = '../../rpt_apk/views/v_apk_ikhtisar';
            $data['js']                         = '../../rpt_apk/views/v_apk_ikhtisar_js';
            $data['datacontent']['rows']        		= $this->rpt_apk_model->_generateIkhtisar($nm_modul,$periode);

            list($b,$t) = explode('-',$periode);
            $data['datacontent']['kd_spk']		= $kd_spk;
            $data['datacontent']['periode']     = $this->strutils->strBulan($b).' '.$t;
            $data['datacontent']['kawasan']     = $this->session->userdata('nama_entity');
            $data['datacontent']['title_lap']   = $this->rpt_apk_model->getMenuTitle($nm_modul);



            $this->buildView($data);
        }
    }

}