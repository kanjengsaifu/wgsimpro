<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class App extends CI_Controller {

    public $kd_spk = '';
	public function __construct() {
		parent::__construct();
		if($this->session->userdata('isloggedin')===FALSE)
			redirect(base_url().'index.php/login');
		$this->load->model('../../app/models/app_model');
	}

    public function getKodeSPK(){
        return $this->kd_spk = $this->session->userdata('kode_entity');
    }

	public function buildView($dataView) {
		/**
		* used to generate complete page view
		* $dataView: parameter as array of =
		* array(
		*   'idmenu' => 'theIDofmenu'
		*   'content'=>'thecontent', 'datacontent'=>array('thedatacontent'),
		*   'js'=>'thejs', 'datajs'=>array('thedatajs')
		* )
		*/
//        if($this->session->userdata('usernm')==='admin' OR $dataView['idmenu']==='entity-pilih' OR in_array($dataView['idmenu'], explode(',',$this->session->userdata('user_akses')))) {
            $this->load->view('../../home/views/top');
            $dataMenu['data'] = $this->app_model->gen_sidemenu();
            $this->load->view('../../home/views/left', $dataMenu);
            if(isset($dataView['pg_home'])){
                if(isset($dataView['idmenu'])) {
                    $data = array();
                    // $data['idmenu'] = $dataView['idmenu'];
                    $data['nama'] = $this->getJudul($dataView['idmenu']);
                    if(isset($dataView['btnurl'])) {
                        $data['btnurl'] = $dataView['btnurl'];
                    }
                    $this->load->view('../../home/views/content_head', $data);
                } else {
                    $this->load->view('../../home/views/content_head');
                }
                if(isset($dataView['content'])) {
                    if(isset($dataView['datacontent'])) {
                        $this->load->view($dataView['content'], array('data'=>$dataView['datacontent']));
                    } else {
                        $this->load->view($dataView['content']);
                    }
                }
                $this->load->view('../../home/views/js');
                if(isset($dataView['js'])) {
                    if(isset($dataView['datajs'])) {
                        $this->load->view($dataView['js'], array('data'=>$dataView['datajs']));
                    } else {
                        $this->load->view($dataView['js']);
                    }
                }
                $this->load->view('../../home/views/bottom');
            }else{
                
                    if(isset($dataView['idmenu'])) {
                        $data = array();
                        // $data['idmenu'] = $dataView['idmenu'];
                        $data['nama'] = $this->getJudul($dataView['idmenu']);
                        if(isset($dataView['btnurl'])) {
                            $data['btnurl'] = $dataView['btnurl'];
                        }
                        $this->load->view('../../home/views/content_head', $data);
                    } else {
                        $this->load->view('../../home/views/content_head');
                    }
                    if($this->getKodeSPK()<>NULL){
                        if(isset($dataView['content'])) {
                            if(isset($dataView['datacontent'])) {
                                $this->load->view($dataView['content'], array('data'=>$dataView['datacontent']));
                            } else {
                                $this->load->view($dataView['content']);
                            }
                        }
                    }else{
                        $data['idmenu']                 = 'no_session';
                        $this->load->view('../../app/views/no_session',$data);
                    }
                    $this->load->view('../../home/views/js');
                    if(isset($dataView['js'])) {
                        if(isset($dataView['datajs'])) {
                            $this->load->view($dataView['js'], array('data'=>$dataView['datajs']));
                        } else {
                            $this->load->view($dataView['js']);
                        }
                    }
                    $this->load->view('../../home/views/bottom');
                
            }
            
//        } else {
//            redirect(base_url().'index.php/home/1');
//        }
	}

	public function getJudul($idmenu) {
		$menu = $this->app_model->gen_judul();
		return isset($menu[$idmenu]) ? $menu[$idmenu] : '';
	}

	public function test_menu() {
		print_r($this->app_model->gen_sidemenu());
	}
	

    public function getSelectedKawasan(){
        $kd_spk = $this->session->userdata('kode_entity');

        $msg = '';
        if($kd_spk == NULL) {
            $this->load->model('../../mst_entity/models/mst_entity_model');
            
            $data = array(
                'idmenu'=>'entity-pilih',
                'content'=>'../../home/views/content_main',
                'js'=>'../../home/views/content_main_js',
                'datajs'=>array(
                    'entity'=>$this->mst_entity_model->get($this->session->userdata('id_entity')),
                    'msg'=>$msg
                )
            );
        }
    }
	
}