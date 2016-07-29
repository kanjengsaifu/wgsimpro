<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPCLASS;

class Tr_rab_bl extends App {
	
	public function __construct() {
		parent::__construct();
			
		$this->load->model('tr_rab_bl_model');
		$this->load->library('datatables');
	}

	public function index() {
		$data = array();
		$data['idmenu'] = 'rab-bl';
		$data['content'] = '../../tr_rab_bl/views/table';
		$data['js'] = '../../tr_rab_bl/views/table_js';
		$data['btnurl'] = base_url().'index.php/rab-bl/form';
		$this->buildView($data);
	}
	
	public function form($id = FALSE) {
		$data = array();
		$data['idmenu'] = 'rab-bl-form';
		$data['content'] = '../../tr_rab_bl/views/form';
		
		$data['datacontent']['list_sumberdaya'] = $this->tr_rab_bl_model->get_sumberdaya();
		$data['datacontent']['list_tahap'] = $this->tr_rab_bl_model->get_tahap(); 
		
		//$data['datacontent'] = $this->mst_entity_model->get_optional();
		$data['js'] = '../../tr_rab_bl/views/form_js';
		if($id!==FALSE) {
			$data['datajs'] = $this->tr_rab_bl_model->get($id);
		}
		$this->buildView($data);
	}
	
	public function save() {
		$data = $this->input->post();
		if($this->input->post('id')==='') {
			return $this->tr_rab_bl_model->_insert($data);
		} else {
			return $this->tr_rab_bl_model->_update($data, $this->input->post('id'));
		}
	}
	
	public function delete($id) {
		$res = $this->tr_rab_bl_model->_delete($id);
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
		$this->datatables->select('id, kode_tahap, kode_sumberdaya, volume, volume_rev')
				->unset_column('id')
				->from('tr_rab_bl')
				->where(array('kode_entity'=>$this->session->userdata('kode_entity')))
				->add_column('action', '<a href="javascript:action(\'edit\',\'$1\')"><span class="glyphicons glyphicons-edit"></span></a>&nbsp;&nbsp'.
						'<a href="javascript:action(\'delete\',\'$1\')"><span class="glyphicons glyphicons-bin"></span></a>', 'id');
		echo $this->datatables->generate();
	}
	
	public function excel() {
		
		$data = array();
		$data['idmenu'] = 'harga-sumberdaya-excel';
		$data['content'] = '../../mst_harga_sumberdaya/views/form_excel';
		//$data['datacontent']['list_sumberdaya'] = $this->mst_harga_sumberdaya_model->get_optional();
		//$data['js'] = '../../mst_harga_sumberdaya/views/form_excel_js';
		$this->buildView($data);
	}
	
	public function save_excel() {
		$data = array();
		$data['idmenu'] = 'harga-sumberdaya-excel-save';
		$this->load->library('upload');
		
		if($_FILES['f_excel']['name'])
        {
			
			$nmfile = "file_".time(); //nama file saya beri nama langsung dan diikuti fungsi time
			$config['upload_path'] = './assets/uploads/harga_sumberdaya/'; //path folder di luar admin
			$config['allowed_types'] = 'xls'; //type yang dapat diakses bisa anda sesuaikan
			$config['max_size'] = '8192'; //maksimum besar file 8Mb
			$config['file_name'] = $nmfile; //nama yang terupload nantinya

			$this->upload->initialize($config);
            if ($this->upload->do_upload('f_excel'))
            {
                $f_excel = $this->upload->data();
				$file=1;
            }else{ 
				$f_excel="";
				$file=2;
            }
        }else{
			$f_excel="";
			$file=0;
		}
		
		if($file==1){
			//echo "File Terupload";
			$this->load->library('Excel_reader');
        	 $dfile = $f_excel['full_path'];
              $this->excel_reader->read($dfile);
              error_reporting(E_ALL ^ E_NOTICE);
 
              // array data
              $data = $this->excel_reader->sheets[0];
              $dataexcel = Array();
			 // $valid=0;
			  $tidak_valid=0;
			  $data_tidak_valid=Array();
              for ($i = 2; $i <= $data['numRows']; $i++) {
                   if ($data['cells'][$i][1] == '')
                       break;
				   
                   $dataexcel[$i - 1]['kode_entity'] = $this->input->post('kode_entity');//kode_entity
                   $dataexcel[$i - 1]['kode_sumberdaya'] = $data['cells'][$i][2];
                   $dataexcel[$i - 1]['harga_satuan'] = $data['cells'][$i][3];
				   $hasildata=$this->mst_harga_sumberdaya_model->cek_data($data['cells'][$i][2]);
				   if($hasildata>0){
					   $datane="valid";
					  // $valid++;
				   }else{
					   echo $datane="tidak valid";
					   $tidak_valid++;
					   $data_tidak_valid[$i-1]=$data['cells'][$i][2];
				   }
              } 
				//print_r($dataexcel);
				//echo $tidak_valid;
				
			if($tidak_valid==0){
				   $this->mst_harga_sumberdaya_model->loaddata($dataexcel);
					echo "Harga sumberdaya Berhasil di Upload <br />";
					echo "<a href='".base_url()."index.php/harga-sumberdaya-excel'>Klik disini untuk kembali ke Upload Sumberdaya</a>";
		
			  }else{
				  echo "Silahkan cek Kode Sumberdaya <br />";
				  foreach($data_tidak_valid as $dtv){
					  echo $dtv."<br />";
				  }
				  	echo "Kode sumberdaya tidak ditemukan <br />";
					echo "<a href='".base_url()."index.php/harga-sumberdaya-excel'>Klik disini untuk kembali ke Upload Sumberdaya</a>";
			  }
			  
		}elseif($file==2){
			echo "hanya file extensi .xls yang diijinkan untuk diupload<br />";
			echo "<a href='".base_url()."index.php/harga-sumberdaya-excel'>Klik disini untuk kembali ke Upload Sumberdaya</a>";
		}else{
			echo "File tidak boleh kosong<br />";
			echo "<a href='".base_url()."index.php/harga-sumberdaya-excel'>Klik disini untuk kembali ke Upload Sumberdaya</a>";
		} 
	}
}