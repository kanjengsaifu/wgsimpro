<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mst_nasabah extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		if($this->session->userdata('isloggedin')===FALSE)
			redirect(base_url().'index.php/login');
			
		$this->load->model('mst_nasabah_model');
		$this->load->library('datatables');
		$this->load->library('dateUtils');
	}

	public function index($type = 'CUSTOMER') {
		$this->load->view('../../home/views/header'); 
		$this->load->view('../../home/views/sidebar');
		if($type==='CUSTOMER') {
			$this->load->view('mst_customer_table');
		}
		$data['idmenu'] = "mst_customer";
		$this->load->view('../../home/views/js',$data);
		if($type==='CUSTOMER') {
			$this->load->view('mst_customer_table_js');
		}
		$this->load->view('../../home/views/footer');
	}
	
	public function form($id = FALSE, $type = 'CUSTOMER') {
		 
		$this->load->view('../../home/views/header'); 
		$this->load->view('../../home/views/sidebar');
		// $this->load->model('../../mst_entity/models/mst_entity_model');
		// $data['entities'] = $this->mst_entity_model->get();
		if($id === FALSE) {
			if($type==='CUSTOMER') {
				$this->load->view('mst_customer_form');
			}
		} else {
			if($type==='CUSTOMER') {
				$this->load->view('mst_customer_form');
			}
			$data['data'] = $this->mst_nasabah_model->get($id);
		} 
		$this->load->view('../../home/views/js');
		if($id === FALSE) {
			if($type==='CUSTOMER') {
				$this->load->view('mst_customer_form_js');
			}
		} else {
			if($type==='CUSTOMER') {
				$this->load->view('mst_customer_form_js',$data);
			}
		} 
		$this->load->view('../../home/views/footer');
	}
	
	public function save($type = 'CUSTOMER') {
		if($type==='CUSTOMER') {
			$data = array(
				'jenis'=>'CUSTOMER',
				'kode'=>$this->input->post('kode'),
				'nama'=>$this->input->post('nama'),
				'alamat_ktp'=>$this->input->post('alamat_ktp'),
				'alamat_domisili'=>$this->input->post('alamat_domisili'),
				'no_ktp'=>$this->input->post('no_ktp'),
				'no_kk'=>$this->input->post('no_kk'),
				'tempat_lahir'=>$this->input->post('tempat_lahir'),
				'tgl_lahir'=>$this->dateutils->dateStr_to_mysql($this->input->post('tgl_lahir')),
				'email'=>$this->input->post('email'),
				'kodepos'=>$this->input->post('kodepos'),
				'telp'=>$this->input->post('telp'),
				'hp'=>$this->input->post('hp'),
				'fax'=>$this->input->post('fax'),
				'nama_perusahaan'=>$this->input->post('nama_perusahaan'),
				'alamat_perusahaan'=>$this->input->post('alamat_perusahaan'),
				'kota_perusahaan'=>$this->input->post('kota_perusahaan'),
				'kodepos_perusahaan'=>$this->input->post('kodepos_perusahaan'),
				'telp_perusahaan'=>$this->input->post('telp_perusahaan'),
				'fax_perusahaan'=>$this->input->post('fax_perusahaan'),
				'jenis_pekerjaan'=>$this->input->post('jenis_pekerjaan'),
				'status_pekerjaan'=>$this->input->post('status_pekerjaan'),
				'lama_bekerja'=>$this->input->post('lama_bekerja'),
				'jenis_usaha'=>$this->input->post('jenis_usaha'),
				'jabatan'=>$this->input->post('jabatan'),
				'pendapatan'=>$this->input->post('pendapatan'),
				'sumber_pendapatan_tambahan'=>$this->input->post('sumber_pendapatan_tambahan'),
				'pendapatan_tambahan'=>$this->input->post('pendapatan_tambahan')
			);
		} elseif($type==='NASABAH') {
			$data = array(
				'jenis'=>'NASABAH',
				'kode'=>$this->input->post('kode'),
				'nama'=>$this->input->post('nama'),
				'alamat'=>$this->input->post('alamat'),
				'npwp'=>$this->input->post('npwp'),
				'ispkp'=>$this->input->post('ispkp')
			);
		}
		if($this->input->post('id')==='') {
			$this->mst_nasabah_model->_insert($data);
		} else {
			$this->mst_nasabah_model->_update($data, $this->input->post('id'));
		}
		redirect('/customer/');
	}
	
	public function delete($id) {
		$res = $this->mst_nasabah_model->_delete($id);
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
		$this->datatables->select('id,nama,no_ktp,alamat_ktp,email,telp,hp,nama_perusahaan')
				->unset_column('id')
				->from('mst_nasabah')
				->where('jenis = "CUSTOMER"')
				->add_column('action', '<a href="javascript:action(\'edit\',\'$1\')"><span class="glyphicons glyphicons-edit"></span></a>&nbsp;&nbsp'.
						'<a href="javascript:action(\'delete\',\'$1\')"><span class="glyphicons glyphicons-bin"></span></a>', 'id');
		echo $this->datatables->generate();
	}
	
}