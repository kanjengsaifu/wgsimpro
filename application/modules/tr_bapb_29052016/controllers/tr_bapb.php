<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPCLASS;

class tr_bapb extends App {
	
	public function __construct() {
		parent::__construct();
			
		$this->load->model('tr_bapb_model');
		$this->load->library('datatables');
		$this->load->library('dateUtils');
	}

	public function index() {
		$data = array();
		$data['idmenu'] 			= 'bapb-list';
		$data['content'] 			= '../../tr_bapb/views/table';
		$data['js'] 				= '../../tr_bapb/views/table_js';
		$data['btnurl'] 			= base_url().'index.php/tr_bapb/form';
		$this->buildView($data);
		//$this->form();
	}

	public function get_po($po) {
		$this->output->set_content_type('application/json');
		echo json_encode($this->tr_bapb_model->get_po($po));
	}
	
	public function form($id = FALSE) {
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$data = array();
		$data['idmenu'] 			= 'bapb-form';
		$data['content'] 			= '../../tr_bapb/views/form';
		
		$data['datacontent'] 		= $this->tr_bapb_model->get_optional($id);
		if($id!==false){
			$data['datacontent']['naskon'] 		= $this->tr_bapb_model->get($id);
		}
		//print_r($data);die;
		
		$data['js'] 				= '../../tr_bapb/views/form_js';
		$this->buildView($data);
	}
	
	public function save() {
		$data = $this->input->post();
		$bapb = array(
			'kode_entity'=>$this->session->userdata('kode_entity'),
			'no_bapb'=>$data['no_bapb'],
			'tanggal'=>$this->dateutils->dateStr_to_mysql($data['tgl_bapb']),
			'kdnasabah'=>$data['kd_nasabah'],
			'no_surat_jalan'=>$data['no_surat_jalan'],
			'angkut_id'=>$data['angkut_id'],
			'no_kontrak'=>$data['no_kontrak'],
			'konfirmasi'=>$data['konfirmasi'],
			'uraian'=>$data['uraian'],
		);
		//print_r($bapb);
		if($this->input->post('id')==='') {
			$id = $this->tr_bapb_model->_insert($bapb);
			$sumberdayas = $data['kode_sumberdaya'];
			$hargas 	= $data['harga_satuan'];
			$volumes 	= $data['volume'];
			foreach ($sumberdayas as $k => $v) {
				$dataPOSD = array(
					'bapb_id'				=>$id,
					'kode_sumberdaya'		=>$v,
					'harga_satuan'			=>$hargas[$k],
					'volume'				=>$volumes[$k]
				);
				$dataPOSD['volume'] 		= str_replace(',', '', $dataPOSD['volume']);
				$dataPOSD['harga_satuan'] 	= str_replace(',', '', $dataPOSD['harga_satuan']);
				$this->db->insert('tr_bapb_detail',$dataPOSD);
			}
			return 'ok';
		} else {
			return $this->tr_bapb_model->_update($data, $this->input->post('id'));
		}
	}
	
	public function delete($id) {
		$res = $this->tr_bapb_model->_delete($id);
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

	public function delete_sd($id) {
		$res = $this->tr_bapb_model->_delete_sd($id);
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
		$this->datatables->select('id,DATE_FORMAT(tanggal,"%d/%m/%Y") as tanggal, no_bapb, no_kontrak, kdnasabah', FALSE)
				->unset_column('id')
				->from('tr_bapb')
				->add_column('action', '<a href="javascript:action(\'edit\',\'$1\')"><span class="glyphicons glyphicons-edit"></span></a>&nbsp;&nbsp'.
						'<a href="javascript:action(\'delete\',\'$1\')"><span class="glyphicons glyphicons-bin"></span></a>', 'id');
		echo $this->datatables->generate();
	}

	public function genDT_po() {
		// $this->output->enable_profiler(TRUE);
		$this->datatables->select('DATE_FORMAT(po.tanggal,"%d/%m/%Y") as tanggal, po.no_po, po.kode_spk, po.kode_bpdp, '.
				'po.no_unit', FALSE)
			->from('tr_po po')
			->where(array('kode_entity'=>$this->session->userdata('kode_entity')))
			->add_column('action', '<a href="javascript:" class="row-data" data-po="$1">'.
				'<span class="glyphicons glyphicons-edit"></span></a>', 'po.no_po');
		echo $this->datatables->generate();
	}
	
}