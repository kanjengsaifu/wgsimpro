<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPCLASS;

class Mst_harga_sumberdaya extends App {

	public function __construct() {
		parent::__construct();
		$this->load->model('mst_harga_sumberdaya_model');
		$this->load->library('datatables');
	}

	function index(){
		$data = array();
		$data['idmenu'] = 'harga-sumberdaya';
		$data['content'] = '../../mst_harga_sumberdaya/views/form';
		$data['datacontent']['list_sumberdaya'] = $this->mst_harga_sumberdaya_model->get_optional();
		$data['js'] = '../../mst_harga_sumberdaya/views/form_js';
		$this->buildView($data);
	}

	public function save() {
		$data = $this->input->post();
		$data['harga_satuan'] = str_replace(',', '', $data['harga_satuan']);
		$data['harga_satuan_review'] = str_replace(',', '', $data['harga_satuan_review']);
		if($this->input->post('id')==='') {
			return $this->mst_harga_sumberdaya_model->_insert($data);
		} else {
			return $this->mst_harga_sumberdaya_model->_update($data, $this->input->post('id'));
		}
	}

	public function delete($id) {
		$res = $this->mst_harga_sumberdaya_model->_delete($id);
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

	function genDT($kodeSumberdaya){
		$this->datatables->select('hs.id, sd.nama AS nama, hs.harga_satuan AS harga, hs.harga_satuan_review')
				->unset_column('hs.id')
				->from('mst_harga_sumberdaya hs')
				->join('mst_sumberdaya sd', 'sd.kode = hs.kode_sumberdaya', 'left')
				->where(array('hs.kode_entity'=>$this->session->userdata('kode_entity'), 'sd.kode'=>$kodeSumberdaya))
				->add_column('action', '<a href="javascript:" class="row-edit" data-id="$1"><span class="glyphicons glyphicons-edit"></span></a>&nbsp;&nbsp'.
						'<a href="javascript:" class="row-delete" data-id="$1"><span class="glyphicons glyphicons-bin"></span></a>', 'hs.id');
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
		//$tampilkan="";
		//$data['content'] = '../../mst_harga_sumberdaya/views/import_excel',$tampilkan;
		//$this->buildView($data);
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
                   $dataexcel[$i - 1]['harga_satuan_review'] = $data['cells'][$i][4];
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
			  
			  
			 /*
              // array data
              $data = $this->excel_reader->sheets[0];
              $dataexcel = Array();
              for ($i = 1; $i <= $data['numRows']; $i++) {
                   if ($data['cells'][$i][1] == '')
                       break;
                   $dataexcel[$i - 1]['nama'] = $data['cells'][$i][1];
                   $dataexcel[$i - 1]['tempat_lahir'] = $data['cells'][$i][2];
                   $dataexcel[$i - 1]['tanggal_lahir'] = $data['cells'][$i][3];
              }
			*/
		}elseif($file==2){
			echo "hanya file extensi .xls yang diijinkan untuk diupload<br />";
			echo "<a href='".base_url()."index.php/harga-sumberdaya-excel'>Klik disini untuk kembali ke Upload Sumberdaya</a>";
		}else{
			echo "File tidak boleh kosong<br />";
			echo "<a href='".base_url()."index.php/harga-sumberdaya-excel'>Klik disini untuk kembali ke Upload Sumberdaya</a>";
		}
		/*
		$data = $this->input->post();
		$data['harga_satuan'] = str_replace(',', '', $data['harga_satuan']);
		if($this->input->post('id')==='') {
			return $this->mst_harga_sumberdaya_model->_insert($data);
		} else {
			return $this->mst_harga_sumberdaya_model->_update($data, $this->input->post('id'));
		}*/
	}
}

/* End of file mst_harga_sumberdaya.php */
/* Location: ./application/modules/mst_harga_sumberdaya/controllers/mst_harga_sumberdaya.php */