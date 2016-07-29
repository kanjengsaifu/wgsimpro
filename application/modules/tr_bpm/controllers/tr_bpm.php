<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPCLASS;

class Tr_bpm extends App {
	
	public function __construct() {
		parent::__construct();
			
		$this->load->model('tr_bpm_model');
		$this->load->library('datatables');
		$this->load->library('dateUtils');
	}

	public function index() {
		$data = array();
		$data['idmenu'] = 'bpm-table';
		$data['content'] = '../../tr_bpm/views/table';
		$data['js'] = '../../tr_bpm/views/table_js';
		$data['btnurl'] = base_url().'index.php/tr_bpm/form';
		$this->buildView($data);
	}
	
	public function form($id = FALSE) {
		$data = array();
		$data['idmenu'] = 'bpm-form';
		$data['content'] = '../../tr_bpm/views/form';
		$data['datacontent'] = $this->tr_bpm_model->get_optional();
		$data['js'] = '../../tr_bpm/views/form_js';
		$this->buildView($data);
	}
	
	public function save() {
		$data = $this->input->post();
		$bpm = array(
			'kode_entity'=>$this->session->userdata('kode_entity'),
			'no_bpm'=>$data['no_bpm'],
			'tanggal'=>$this->dateutils->dateStr_to_mysql($data['tgl_bpm']),
			'konfirmasi'=>$data['konfirmasi'],
		);
		//print_r($bapb);
		if($this->input->post('id')==='') {
			$id = $this->tr_bpm_model->_insert($bpm);
			$sumberdayas = $data['kode_sumberdaya'];
			$hargas = $data['harga_satuan'];
			$volumes = $data['volume'];
			foreach ($sumberdayas as $k => $v) {
				$dataPOSD = array(
					'bpm_id'				=>$id,
					'kode_sumberdaya'		=>$v,
					'harga_satuan'			=>$hargas[$k],
					'volume'				=>$volumes[$k]
				);
				$dataPOSD['volume'] 		= str_replace(',', '', $dataPOSD['volume']);
				$dataPOSD['harga_satuan'] 	= str_replace(',', '', $dataPOSD['harga_satuan']);
				$this->db->insert('tr_bpm_detail',$dataPOSD);
			}
			return 'ok';
		} else {
			return $this->tr_bpm_model->_update($bpm, $this->input->post('id'));
		}
	}
	
	public function delete($id) {
		$res = $this->tr_bpm_model->_delete($id);
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
		$this->datatables->select('id,DATE_FORMAT(tanggal,"%d/%m/%Y") as tanggal, no_bpm', FALSE)
				->unset_column('id')
				->from('tr_bpm')
				->add_column('action', '<a href="javascript:action(\'edit\',\'$1\')"><span class="glyphicons glyphicons-edit"></span></a>&nbsp;&nbsp'.
						'<a href="javascript:action(\'delete\',\'$1\')"><span class="glyphicons glyphicons-bin"></span></a>', 'id');
		echo $this->datatables->generate();
	}
	
}