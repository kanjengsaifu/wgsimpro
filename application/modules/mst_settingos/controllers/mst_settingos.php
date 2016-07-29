<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPCLASS;

class mst_settingos extends App {
	
	function __construct() {
		parent::__construct();
			
		$this->load->model('mst_settingos_model','mSom');
		$this->load->library('datatables');
		$this->load->library('dateUtils');
		$this->load->library('strUtils');
	}

	function index() {
		$data = array();
		$data['idmenu'] 		= 'msettos';
		$data['content'] 		= '../../mst_settingos/views/table';
		$data['js'] 			= '../../mst_settingos/views/table_js';
		$data['btnurl'] 		= base_url().'index.php/settos/form';

		$this->buildView($data);
	}

	function form($id=false) {
		$data = array();
		$data['idmenu'] 		= 'msettos-form';
		$data['content'] 		= '../../mst_settingos/views/form';
		$data['datacontent'] 	= mst_settingos_model::get_coa();
		$data['js'] 			= '../../mst_settingos/views/form_js';
		if(!$id==false || !$id=='')
			$data['idmenu'] 	= 'msettos-edit';
			$data['datajs'] 	= mst_settingos_model::get_data($id); 

		$this->buildView($data);
	}

	function save()
	{
		$data = $this->input->post();

		if($this->input->post('id')=='') {
			return mst_settingos_model::_insert($data);
		} else {
			return mst_settingos_model::_update($data, $this->input->post('id'));
		}
	}

	function delete()
	{
		$res = mst_settingos_model::_delete($id);
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

	function genDT() {
		$this->datatables->select('id, jenis, kode_coa, f_cekcoa(kode_coa) as coa, penerbitan, pelunasan', FALSE)
			->from('mst_setting_os')
			->unset_column('id')
			->unset_column('kode_coa')
			->add_column('action', '<a href="javascript:action(\'edit\',\'$1\')" class="row-edit" data-id="$1">'.
				'<span class="glyphicons glyphicons-edit"></span></a>&nbsp;&nbsp'.
				'<a href="javascript:action(\'delete\',\'$1\')" class="row-delete" data-id="$1">'.
				'<span class="glyphicons glyphicons-bin"></span></a>', 'id');
		echo $this->datatables->generate();
	}
}

?>
