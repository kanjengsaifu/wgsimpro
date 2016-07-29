<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPCLASS;

class Tr_kontrak extends App {
	
	public function __construct() {
		parent::__construct();
			
		$this->load->model('tr_kontrak_model');
		$this->load->library('datatables');
		$this->load->library('dateUtils');
	}

	public function index() {
		$data = array();
		$data['idmenu'] 						= 'kontrak-table';
		$data['content'] 						= '../../tr_kontrak/views/table';
		$data['js'] 							= '../../tr_kontrak/views/table_js';
		$data['btnurl'] 						= base_url().'index.php/kontrak/form';
		$this->buildView($data);
	}
	
	public function form($id = FALSE) {
		$data = array();
		$data['idmenu'] 						= 'kontrak-form';
		$data['content'] 						= '../../tr_kontrak/views/form';
		//$data['datacontent']['rekanans'] 		= tr_kontrak_model::get_optional_rekanan($id);
		$data['datacontent']					= tr_kontrak_model::get($id);
		$data['js'] 							= '../../tr_kontrak/views/form_js';
		if($id!==FALSE) {
			$data['datajs'] 					= tr_kontrak_model::get_termin_detail($id);
		}
		$this->buildView($data);
	}
	
	public function save() {
		$data = $this->input->post();
		$data['tanggal_sign'] 		= $this->dateutils->dateStr_to_mysql($data['tanggal_sign']);
		$data['tanggal_mulai'] 		= $this->dateutils->dateStr_to_mysql($data['tanggal_mulai']);
		$data['tanggal_akhir'] 		= $this->dateutils->dateStr_to_mysql($data['tanggal_akhir']);
		//$data['volume'] 		= str_replace(',', '', $data['volume']);
		$data['nilai_kontrak'] 		= str_replace(',', '', $data['nilai_kontrak']);
		if($this->input->post('id')==='') {
			return $this->tr_kontrak_model->_insert($data);
		} else {
			return $this->tr_kontrak_model->_update($data, $this->input->post('id'));
		}
	}
	
	public function delete($id) {
		$res = $this->tr_kontrak_model->_delete($id);
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
		/*
		$this->datatables->select('k.id')
						 ->select('DATE_FORMAT(k.tanggal,"%d/%m/%Y") as xtanggal', FALSE)
						 ->select('k.jenis_kontrak as jenis')
						 // ->select('spk.nama as nama')
						 ->select('r.nama as rekanan')
						 ->select('FORMAT(k.volume,2) as xvolume', FALSE)
						 ->select('FORMAT(k.rp,2) as xrupiah', FALSE)
						 ->unset_column('k.id')
						 ->from('tr_kontrak k')
						 ->join('xmst_rekanan r','k.kode_rekanan=r.kode_rekanan')
						 // ->join('tr_spk spk' , 'spk.kode=k.kode_spk')
		*/
		$this->datatables->select('k.id')
						 ->select('k.no_kontrak, k.nilai_kontrak, k.retensi')
						 //->select('DATE_FORMAT(k.tanggal_sign,"%d/%m/%Y") as xtanggal', FALSE)
						 ->select('DATE_FORMAT(k.tanggal_mulai,"%d/%m/%Y") as stanggal', FALSE)
						 ->select('DATE_FORMAT(k.tanggal_akhir,"%d/%m/%Y") as etanggal', FALSE)
						 ->select('r.nama as nama_rekanan')
						 ->unset_column('k.id')
						 ->from('tr_kontrak k')
						 ->join('mst_rekanan r','k.kode_rekanan=r.kode_rekanan')
						 ->where(array('k.kode_entity' => $this->session->userdata('kode_entity')))
						 ->add_column('action', '<a href="javascript:action(\'edit\',\'$1\')" class="row-edit" data-id="$1"><span class="glyphicons glyphicons-edit"></span></a>&nbsp;&nbsp'.
						'<a href="javascript:action(\'delete\',\'$1\')" class="row-delete" data-id="$1"><span class="glyphicons glyphicons-bin"></span></a>', 'k.id');
		echo $this->datatables->generate();
	}
	
}