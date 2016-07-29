<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPCLASS;

class T_user extends App {
	
	public function __construct() {
		parent::__construct();
			
		$this->load->model('t_user_model');
		$this->load->library('datatables');
	}

	public function index() {
		$data = array();
		$data['idmenu'] = 'setting-user-table';
		$data['content'] = '../../t_user/views/table';
		$data['js'] = '../../t_user/views/table_js';
		$data['btnurl'] = base_url().'index.php/t_user/form';
		$this->buildView($data);
	}
	
	public function form($id = FALSE) {
		$data = array();
		$data['idmenu'] = 'setting-user-form';
		$data['content'] = '../../t_user/views/form';
        $data['datacontent']['user_group'] = $this->t_user_model->get_group();
        $data['datacontent']['entity'] = $this->t_user_model->get_entity($id);
		$data['js'] = '../../t_user/views/form_js';
		if($id!==FALSE) {
			$data['datajs'] = $this->t_user_model->get($id);
		}
		$this->buildView($data);
	}
	
	public function save() {
		if($this->input->post('id')==='') {
			return $this->t_user_model->_insert();
		} else {
			return $this->t_user_model->_update();
		}
	}
	
	public function delete($id) {
		$res = $this->t_user_model->_delete($id);
		if($res) {
			$out = array(
				'response'=>'1',
				'msg'=>'Success'
			);
		} else {
			$out = array(
				'response'=>'0',
				'msg'=>'Failed'
			);
		}
		$this->output->set_content_type('application/json');
		echo json_encode($out);
	}
	
	public function genDT() {
		// $this->output->enable_profiler(TRUE);
		$this->datatables->select('u.id, u.username, u.nama, CASE WHEN u.isactive=1 THEN "Ya" ELSE "Tidak" END AS aktif, g.nama AS sgroup', FALSE)
				->unset_column('u.id')
				->from('t_user u')
                ->join('t_user_group g', 'g.id = u.user_group', 'left')
                ->where('u.id > 1')
				->add_column('action', '<a href="javascript:action(\'edit\',\'$1\')"><span class="glyphicons glyphicons-edit"></span></a>&nbsp;&nbsp'.
						'<a href="javascript:action(\'delete\',\'$1\')"><span class="glyphicons glyphicons-bin"></span></a>', 'u.id');
		echo $this->datatables->generate();
	}
	
}