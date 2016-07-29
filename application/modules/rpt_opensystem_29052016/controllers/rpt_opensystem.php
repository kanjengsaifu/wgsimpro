<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPCLASS;

class Rpt_Opensystem extends App {

	public function __construct() {
		parent::__construct();

		$this->load->model('rpt_opensystem_model');
		$this->load->library('datatables');
		$this->load->library('dateUtils');
		$this->load->library('strUtils');
	}

    public function index() {}


	public function f_periode($nm_modul=false) {
        $data['idmenu']                 = 'akuntansi-lap-opensytem';//'rpt-opensystem-'.$nm_modul;
        $data['content']                = '../../rpt_opensystem/views/f_periode';
        $data['js']                     = '../../rpt_opensystem/views/f_periode_js';
        $data['datacontent']['target']  = $nm_modul==false?'':$nm_modul;
        $data['datacontent']['kombo']           = $this->rpt_opensystem_model->generateOptionBox();
        
        $this->buildView($data);
    }


    function generateReport($nm_modul,$periode=false,$jenisReport='R')
    {
        $data = $this->input->post();
        //$modul = $data['nama-modul'];
        //$periode = $data['periode'];
        $divisi = $data['divisi'];

        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        
        if($periode===FALSE) {
            $this->f_periode($nm_modul);
        } else {
            $data = array();
            $data['idmenu']                         = 'rpt-opensystem-'.$nm_modul;
            if($jenisReport=='D'){
                $data['content']                    = '../../rpt_opensystem/views/f_rpt_opensystem';
                $data['js']                         = '../../rpt_opensystem/views/f_rpt_opensystem_js';
                $data['datacontent']['rows']        = $this->rpt_opensystem_model->generateHutang($nm_modul,$periode);
                $data['datacontent']['is_rpt_show'] = $this->rpt_opensystem_model->_showColumnOptional($nm_modul);
                $data['datacontent']['gt']          = $this->rpt_opensystem_model->generateHutangIkhtisar($nm_modul,$periode);
            }else{
                $data['content']                    = '../../rpt_opensystem/views/f_rpt_opensystem_ikhtisar';
                $data['js']                         = '../../rpt_opensystem/views/f_rpt_opensystem_ikhtisar_js';
                $data['datacontent']['rows']        = $this->rpt_opensystem_model->generateHutangIkhtisar($nm_modul,$periode);
                
               //redirect('rpt-opsys');
            }
            //die(var_dump($data['datacontent']['is_rpt_show']));
            //die('<pre>'.$data.'</pre>');
            $data['datacontent']['nama']        = $this->session->userdata('nama'); 

            list($b,$t) = explode('-',$periode);
            $data['datacontent']['periode']     = $this->strutils->strBulan($b).' '.$t;
            $data['datacontent']['divisi']      = $this->rpt_opensystem_model->getNamaDivisi($divisi);
            $data['datacontent']['kawasan']     = $this->session->userdata('nama_entity');
            $data['datacontent']['title_lap']   = $this->rpt_opensystem_model->getMenuTitle($nm_modul);
        }

        $this->buildView($data);
        
    }

    function rpt_opsys($nm_modul,$periode) {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $data = array();
        $data['idmenu']                         = 'rpt-opensystem-'.$nm_modul;
    
        $data['content']                    = '../../rpt_opensystem/views/f_rpt_opensystem2';
        $data['js']                         = '../../rpt_opensystem/views/f_rpt_opensystem_js';
        $data['datacontent']['periode']     = $periode;
        $data['datacontent']['modul']       = $nm_modul;
        $this->buildView($data);
    }


}