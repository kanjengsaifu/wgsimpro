<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPCLASS;

class T_user_group extends App {
	
	public function __construct() {
		parent::__construct();
			
		$this->load->model('t_user_group_model');
		$this->load->library('datatables');
	}

	public function index() {
		$data = array();
		$data['idmenu'] = 'setting-user-group';
		$data['content'] = '../../t_user_group/views/table';
		$data['js'] = '../../t_user_group/views/table_js';
		$data['btnurl'] = base_url().'index.php/t_user_group/form';
		$this->buildView($data);
	}
	
	public function form($id = FALSE) {
		$data = array();
		$data['idmenu'] 		= 'setting-user-group-form';
		$data['content'] 		= '../../t_user_group/views/form';
        $data['datacontent'] 	= $this->t_user_group_model->get_entity($id);
		$data['js'] 			= '../../t_user_group/views/form_js';
		if($id!==FALSE) {
			$data['datajs'] 	= $this->t_user_group_model->get($id);
		}
		$this->buildView($data);
	}
    
    public function gen_menu($group = FALSE) {
        $this->output->set_content_type('application/json;charset=utf-8');
		echo json_encode($this->t_user_group_model->gen_menu($group));
    }
	
	public function save() {
		if($this->input->post('id')==='') {
			return $this->t_user_group_model->_insert();
		} else {
			return $this->t_user_group_model->_update();
		}
	}
	
	public function delete($id) {
		$res = $this->t_user_group_model->_delete($id);
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
		$this->datatables->select('id, nama')
				->unset_column('id')
				->from('t_user_group')
                ->where('id > 1')
				->add_column('action', '<a href="javascript:action(\'edit\',\'$1\')"><span class="glyphicons glyphicons-edit"></span></a>&nbsp;&nbsp'.
						'<a href="javascript:action(\'delete\',\'$1\')"><span class="glyphicons glyphicons-bin"></span></a>', 'id');
		echo $this->datatables->generate();
	}
	
}