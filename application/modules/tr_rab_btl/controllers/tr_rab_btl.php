<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPCLASS;

class Tr_rab_btl extends App {
	
	public function __construct() {
		parent::__construct();
			
		$this->load->model('tr_rab_btl_model');
		$this->load->library('datatables');
	}

	public function index() {
		$data = array();
		$data['idmenu'] = 'rab-btl';
		$data['content'] = '../../tr_rab_btl/views/table';
		$data['js'] = '../../tr_rab_btl/views/table_js';
		$data['btnurl'] = base_url().'index.php/rab-btl/form';
		$this->buildView($data);
	}
	/*
	
	public function form($id = FALSE) {
		$data = array();
		$data['idmenu'] = 'sumberdaya-form';
		$data['content'] = '../../mst_sumberdaya/views/form';
		$data['js'] = '../../mst_sumberdaya/views/form_js';
		if($id!==FALSE) {
			$data['datajs'] = $this->mst_sumberdaya_model->get($id);
		}
		$this->buildView($data);
	}
	*/
	public function form($id = FALSE) {
		$data = array();
		$data['idmenu'] = 'rab-btl-form';
		$data['content'] = '../../tr_rab_btl/views/form';
		$data['datacontent']['list_sumberdaya'] = $this->tr_rab_btl_model->get_sumberdaya();
		$data['datacontent']['list_coa'] = $this->tr_rab_btl_model->get_coa(); 
		
		$data['js'] = '../../tr_rab_btl/views/form_js';
		if($id!==FALSE) {
			$data['datajs'] = $this->tr_rab_btl_model->get($id);
		}
		$this->buildView($data);
	}
	
	public function save() {
		$data = $this->input->post();
		if($this->input->post('id')==='') {
			return $this->tr_rab_btl_model->_insert($data);
		} else {
			return $this->tr_rab_btl_model->_update($data, $this->input->post('id'));
		}
	}
	
	public function delete($id) {
		$res = $this->tr_rab_btl_model->_delete($id);
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
		$this->datatables->select('id, kode_coa, kode_sumberdaya, harga, harga_rev, rolling')
				->unset_column('id')
				->from('tr_rab_btl')
				->where(array('kode_entity'=>$this->session->userdata('kode_entity')))
				->add_column('action', '<a href="javascript:action(\'edit\',\'$1\')"><span class="glyphicons glyphicons-edit"></span></a>&nbsp;&nbsp'.
						'<a href="javascript:action(\'delete\',\'$1\')"><span class="glyphicons glyphicons-bin"></span></a>', 'id');
		echo $this->datatables->generate();
	}
	
	public function excel() {
		
		$data = array();
		$data['idmenu'] = 'btl-excel';
		$data['content'] = '../../tr_rab_btl/views/form_excel';
		//$data['datacontent']['list_sumberdaya'] = $this->tr_rab_btl_model->get_optional();
		//$data['js'] = '../../tr_rab_btl/views/form_excel_js';
		$this->buildView($data);
	}
	
	public function save_excel() {
		$data = array();
		$data['idmenu'] = 'btl-excel-save';
		$this->load->library('upload');
		
		if($_FILES['f_excel']['name'])
        {
			
			$nmfile = "file_".time(); //nama file saya beri nama langsung dan diikuti fungsi time
			$config['upload_path'] = './assets/uploads/btl/'; //path folder di luar admin
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
                   $dataexcel[$i - 1]['kode_coa'] = $data['cells'][$i][2];
                   $dataexcel[$i - 1]['kode_sumberdaya'] = $data['cells'][$i][3];
                   $dataexcel[$i - 1]['harga'] = $data['cells'][$i][4];
                   $dataexcel[$i - 1]['harga_rev'] = $data['cells'][$i][5];
                   $dataexcel[$i - 1]['rolling'] = $data['cells'][$i][6];
				   $hasildatacoa=$this->tr_rab_btl_model->cek_coa($data['cells'][$i][2]);
				   $hasildatasb=$this->tr_rab_btl_model->cek_data($data['cells'][$i][3]);
				   if($hasildatacoa>0&&$hasildatasb>0){
					   $datane="valid";
					  // $valid++;
				   }else{
					   $datane="tidak valid";
					   $tidak_valid++;
					   $data_tidak_valid[$i-1]=$data['cells'][$i][2];
				   }
              } 
				 
			if($tidak_valid==0){
				   $this->tr_rab_btl_model->loaddata($dataexcel);
					echo "BTL Berhasil di Upload <br />";
					echo "<a href='".base_url()."index.php/rab-btl-excel'>Klik disini untuk kembali ke Upload BTL</a>";
		
			  }else{
				  echo "Silahkan cek Kode COA <br />";
				  foreach($data_tidak_valid as $dtv){
					  echo $dtv."<br />";
				  }
				  	echo "Kode COA / Kode sumberdaya tidak ditemukan <br />";
					echo "<a href='".base_url()."index.php/rab-btl-excel'>Klik disini untuk kembali ke Upload BTL</a>";
			  }
			  
		}elseif($file==2){
			echo "hanya file extensi .xls yang diijinkan untuk diupload<br />";
			echo "<a href='".base_url()."index.php/rab-btl-excel'>Klik disini untuk kembali ke Upload BTL</a>";
		}else{
			echo "File tidak boleh kosong<br />";
			echo "<a href='".base_url()."index.php/rab-btl-excel'>Klik disini untuk kembali ke Upload BTL</a>";
		} 
	}
}