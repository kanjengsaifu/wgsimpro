<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPCLASS;

class Tr_progress extends App {
	
	public function __construct() {

		parent::__construct();
		$this->load->model('tr_progress_model');
        $this->load->library('dateUtils');
        $this->load->library('datatables');
	}

	public function index() {
        $data['idmenu'] = 'progress-form';
		$data['content'] = '../../tr_progress/views/form';
        $data['datacontent'] = $this->tr_progress_model->get_optional();
		$data['js'] = '../../tr_progress/views/form_js';
		$this->buildView($data);
	}
    
    public function table_progress() {
        $data['idmenu'] = 'produksi-rpt-progress';
		$data['content'] = '../../tr_progress/views/table_progress';
		$data['js'] = '../../tr_progress/views/table_progress_js';
		$this->buildView($data);
	}
    
    public function get_progress_unit() {
//        $this->output->enable_profiler(TRUE);
		$this->output->set_content_type('application/json');
		echo json_encode($this->tr_progress_model->get_progress_unit($this->input->post('no_unit')));
	}
    
    public function genDT_progress() {
        $this->datatables->select('p.no_unit, p.persen_progress, p.petugas, DATE_FORMAT(p.tgl_progress, "%d/%m/%Y") AS tgl_progress', FALSE)
            ->from('tr_progress p')
            ->where('p.id IN (SELECT id FROM tr_progress WHERE is_active = 1 GROUP BY kode_entity, no_unit ORDER BY tgl_progress DESC)');
        echo $this->datatables->generate();
    }

	public function save() {
        $stgl = $this->dateutils->dateStr_to_mysql($this->input->post('tgl_progress'));
        $units = $this->input->post('no_unit');
        $progress = $this->input->post('persen_progress');
//		if($this->input->post('id')==='') {
            foreach($units as $k => $v) {
                $this->tr_progress_model->_insert(array(
                    'kode_entity'=>$this->session->userdata('kode_entity'),
                    'no_unit'=>$v,
                    'persen_progress'=>$progress[$k],
                    'petugas'=>$this->input->post('petugas'),
                    'tgl_progress'=>$stgl
                ));
            }
//		} else {
//			return $this->tr_progress_model->_update($data, $data['id']);
//		}
	}

//	public function delete($id) {
//		return $this->mst_diskon_model->_delete($id);
//	}
	
} 