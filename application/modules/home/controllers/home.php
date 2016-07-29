<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPCLASS;

class Home extends App {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('../../mst_entity/models/mst_entity_model');
	}

	public function index($msgid = FALSE) {
        $msg = '';
        if($msgid!==FALSE) {
            switch($msgid) {
                case 1: $msg = 'Anda tidak memiliki hak mengakses menu terpilih.'; break;
                default: $msg = '';
            }
        }
		$this->buildView(
			array(
				'idmenu'=>'entity-pilih',
				'pg_home'=>'true',
				'content'=>'../../home/views/content_main',
				'datacontent'=>array('entities'=>$this->mst_entity_model->get_user_entity()),
				'js'=>'../../home/views/content_main_js',
				'datajs'=>array(
                    'entity'=>$this->mst_entity_model->get($this->session->userdata('id_entity')),
                    'msg'=>$msg
                )
			)
		);
	}
	
	public function session_set_entity($kode) {
        $res = array();
        $res = $this->mst_entity_model->get($kode);
        if($this->session->userdata('usernm')==='admin' OR in_array($res['kode'], explode(',',$this->session->userdata('user_entity')))) {
            $this->session->set_userdata(array('kode_entity'=>$res['kode'], 'id_entity'=>$res['id'], 
                    'type_entity'=>$res['type_entity'], 'nama_entity'=>$res['nama']));
        } else {
            $res = array('msg'=>'Anda tidak memiliki hak akses untuk Kawasan / Entity yg dipilih.');
        }
//        $res['out'] = $this->session->userdata('user_entity');
        $this->output->set_content_type('application/json');
		echo json_encode($res);
	}
	
	
}