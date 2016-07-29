<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPCLASS;

class Jurnal_export_import extends App {
	
	private $error;
    private $success;

	public function __construct() {
		parent::__construct();
		//date_default_timezone_set('Asia/Jakarta');

		$this->load->model('jurnal_export_import_model');
		$this->load->library('datatables');
		$this->load->library('dateUtils');
		$this->load->library('strUtils');
		$this->load->helper('combo');

        

	}

	private function handle_error($err) {
        $this->error .= $err . "\r\n";
    }
    private function handle_success($succ) {
        $this->success .= $succ . "\r\n";
    }

	public function index() {}


	function export()
	{
		
		$data = array();
		$data['idmenu'] = 'jurnal-export';
		$data['content'] = '../../jurnal_export_import/views/exporttable';
		$data['js'] = '../../jurnal_export_import/views/exporttable_js'; 
		$kode_enti=$this->session->userdata('kode_entity');
		$data['datacontent']['listexport'] = $this->jurnal_export_import_model->getExport($kode_enti);
		$this->buildView($data);
	}
	
	function transfer()
	{
		
		$data = array();
		$data['idmenu'] = 'jurnal-transfer';
		$data['content'] = '../../jurnal_export_import/views/transfer_jurnal';
		$data['js'] = '../../jurnal_export_import/views/transfer_jurnal_js'; 
		$kode_enti=$this->session->userdata('kode_entity');
		$data['datacontent']['listexport'] = $this->jurnal_export_import_model->getTransfer($kode_enti);
		$this->buildView($data);
	}
	
	function successtransfer($periode=FALSE,$kode=FALSE,$status=FALSE)
	{
		//Data perusahaan 
		$tgltransfer=date("Y-m-d H:i:s");
		$data = array(  
			'kode_entity'=>$kode,
			'status'=>$status,
			'periode'=>$periode,
			'tgl_transfer'=>$tgltransfer
		); 
		  
		$impor=$this->jurnal_export_import_model->insertstatus($data); 
		
		$urlnya=base_url()."index.php/export-import/transfer";
		echo "<script>window.location='".$urlnya."';</script>";
	}
	function porta()
	{
		$this->load->library('upload');
        $this->load->library('csvimport');
		
		if($_FILES['transfile']['name'])
			{
				
				$nmfile = "file_".time(); //nama file saya beri nama langsung dan diikuti fungsi time
				//$config['upload_path'] = './assets/uploads/'; //path folder di dalam admin
				 $config['upload_path'] = './assets/uploads/csv/'; //path folder di luar admin
				$config['allowed_types'] = 'csv'; //type yang dapat diakses bisa anda sesuaikan
				//$config['max_size'] = '2048'; //maksimum besar file 2M
				$config['max_size'] = '204800'; //maksimum besar file 2M
				$config['max_width']  = '2088'; //lebar maksimum 1288 px
				$config['max_height']  = '1000'; //tinggi maksimu 768 px
				$config['file_name'] = $nmfile; //nama yang terupload nantinya

				$this->upload->initialize($config);
				if ($this->upload->do_upload('transfile'))
				{
					$transfile = $this->upload->data();
				}else{ 
					$transfile="";
				}
			}else{
				$transfile="";
			} 
 			
		$tanggaltransfer=date('Y-m-d H:i:s'); 
		//Data perusahaan 
		$data = array( 
			'namafile'=>$transfile['file_name'],
			'kode_entity'=>$this->input->post('kode_entity'),
			'periode'=>$this->input->post('periode'),
			'tgl_transfer'=>$tanggaltransfer,
			'status'=>'0'
		); 
		  
		$impor=$this->jurnal_export_import_model->insertimport($data); 
		$file_path =  './assets/uploads/csv/'.$transfile['file_name'];
 
            if ($this->csvimport->get_array($file_path)) {
                $csv_array = $this->csvimport->get_array($file_path);
				$no=0;
                foreach ($csv_array as $row) {
					//if($no==0){
						$insert_data = array(
							//"id","kode_divisi","tanggal","jenis","no_bukti","no_invoice","kode_coa","kode_nasabah","kode_customer","kode_sumberdaya","kode_spk","kode_tahap","kode_faktur","kode_alat","volume","keterangan","dk","rupiah","no_bapb","no_bpm","id_ap_payment","id_ar_receive","id_cashbook","id_unitprice","id_rik_tahap","kode_bank","kode_modul","bukti_potong","kode_batch","tr_level","no_terbit","posted_by","posted_date",
							
 							'kode_divisi'=>$row['kode_divisi'],
							'tanggal'=>$row['tanggal'],
							'jenis'=>$row['jenis'],
							'no_bukti'=>$row['no_bukti'],
							'no_invoice'=>$row['no_invoice'],
							'kode_coa'=>$row['kode_coa'],
							'kode_nasabah'=>$row['kode_nasabah'],
							'kode_customer'=>$row['kode_customer'],
							'kode_sumberdaya'=>$row['kode_sumberdaya'],
							'kode_spk'=>$row['kode_spk'],
							'kode_tahap'=>$row['kode_tahap'],
							'kode_faktur'=>$row['kode_faktur'],
							'kode_alat'=>$row['kode_alat'],
							'volume'=>$row['volume'],
							'keterangan'=>$row['keterangan'],
							'dk'=>$row['dk'],
							'rupiah'=>$row['rupiah'],
							'no_bapb'=>$row['no_bapb'],
							'no_bpm'=>$row['no_bpm'],
							'id_ap_payment'=>$row['id_ap_payment'],
							'id_ar_receive'=>$row['id_ar_receive'],
							'id_cashbook'=>$row['id_cashbook'],
							'id_unitprice'=>$row['id_unitprice'],
							'id_rik_tahap'=>$row['id_rik_tahap'],
							'kode_bank'=>$row['kode_bank'],
							'kode_modul'=>$row['kode_modul'],
							'bukti_potong'=>$row['bukti_potong'],
							'kode_batch'=>$row['kode_batch'],
							'tr_level'=>$row['tr_level'],
							'no_terbit'=>$row['no_terbit'],
							'posted_by'=>$row['posted_by'],
							'posted_date'=>$row['posted_date'],
						);
						$this->jurnal_export_import_model->insert_csv($insert_data);
					//}
                    $no++;
                }
                $this->session->set_flashdata('success', 'Csv Data Imported Succesfully');
                //redirect(base_url().'csv');
                //echo "<pre>"; print_r($insert_data);
            } else {
                $data['error'] = "Error occured";
                //$this->load->view('csvindex', $data);
            }
			
		if($impor){
			$arrResult = array ('response'=>'success');
			$pesan="Data Berhasil Terkirim";
			$urlnya=base_url()."index.php/export-import/successtransfer/".$this->input->post('periode')."/".$this->input->post('kode_entity')."/1";
			
		}else{ 
			$arrResult = array ('response'=>'failed');
			$pesan="Data Gagal Terkirim";
			$urlnya=base_url()."index.php/export-import/successtransfer/".$this->input->post('periode')."/".$this->input->post('kode_entity')."/0";
		}
		//echo json_encode($arrResult);
		
		echo "<script>window.alert('".$pesan."');window.location='".$urlnya."';</script>";
		//redirect('./export-import/');
	}

	function portaaaa()
	{
		$this->load->library('upload');

		if($_FILES['transfile']['name'])
			{
				
				$nmfile = "file_".time(); //nama file saya beri nama langsung dan diikuti fungsi time
				//$config['upload_path'] = './assets/uploads/'; //path folder di dalam admin
				 $config['upload_path'] = './../assets/uploads/csv/'; //path folder di luar admin
				$config['allowed_types'] = 'csv'; //type yang dapat diakses bisa anda sesuaikan
				//$config['max_size'] = '2048'; //maksimum besar file 2M
				$config['max_size'] = '204800'; //maksimum besar file 2M
				$config['max_width']  = '2088'; //lebar maksimum 1288 px
				$config['max_height']  = '1000'; //tinggi maksimu 768 px
				$config['file_name'] = $nmfile; //nama yang terupload nantinya

				$this->upload->initialize($config);
				if ($this->upload->do_upload(transfile))
				{
					$transfile = $this->upload->data();
				}else{ 
					$transfile="";
				}
			}else{
				$transfile="";
			} 
 			
		$tanggaltransfer=date('Y-m-d H:i:s'); 
		//Data perusahaan 
		$data = array( 
			'namafile'=>$transfile['filename'],
			'kode_entity'=>$this->input->post('kode_entity'),
			'periode'=>$this->input->post('periode'),
			'tgl_transfer'=>$tanggaltransfer,
			'status'=>'0'
		); 
		  
		$impor=$this->jurnal_export_import_model->insertimport($data); 
		
		if($impor){
			$arrResult = array ('response'=>'success');
			$pesan="Data Berhasil Terkirim";
		}else{ 
			$arrResult = array ('response'=>'failed');
			$pesan="Data Gagal Terkirim";
		}
		//echo json_encode($arrResult);
		
		echo "<script>window.alert('".$pesan."');window.location='".base_url()."index.php/export-import/transfer';</script>";
		//redirect('./export-import/');
	}
	function export_generate()
	{
		$kode_enti=$this->session->userdata('kode_entity');
		$periode=$this->input->post('periode');
		$bersihkan = array('"',"'");
		$periode = str_replace($bersihkan, "", $periode);
		$periode=explode("/",$periode);
		$periode=$periode[1]."-".$periode[0];
		//echo $periode;
		
		$this->load->dbutil();
        $this->load->helper('file');
        //$this->load->helper('download');
        $delimiter = ",";
        $newline = "\r\n";
		/*
		$where = "hangtag_spoc_number = 2202";
		$result = $this->db->select('*')
		->from('hangtag_request')
		->where($where)
		->get();
		return $result;
		*/
		$filename = $kode_enti."-".date("Ymdhis").".csv";
        //$query = "SELECT * FROM tr_accounting WHERE kode";
		//$sql = "SELECT * FROM tr_accounting WHERE kode_spk = ? AND tanggal LIKE '?%'"; 
		
		//$result=$this->db->query($sql, array($kode_enti, $periode));
        //$result = $this->db->query($query);
		$result=$this->db->query("SELECT * FROM tr_accounting WHERE kode_spk = '".$kode_enti."' AND tanggal LIKE '".$periode."%'");
        $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
        
	//if ( ! write_file(APPPATH.'/assets/generate/'.$filename, $data))
		//$paths=APPPATH.'/assets/generate/';
		$paths=realpath('./../../assets/generate/iki/');
		//$paths=realpath('.\..\..\assets\generate\'');
	if ( ! write_file($paths.'assets/generate/'.$filename, $data))
        {
            $res=false;
       }
       else
       {
            $res=true;
			
			$kode=date('Ymdhi');
			$skrg=date('Y-m-d h:i:s');
			
			$data = array(
						'kode_entity'=>$kode_enti,
						'namafile'=>$filename,
						'periode'=>$periode,
						'tgl_generate'=>$skrg,
						'status'=>'0'
					);
			
				$this->jurnal_export_import_model->_insertexport($data);
       }
	   
		 //echo "";
		 //$rwmu=$this->jurnal_export_import_model->getExport($kode_enti);
		 
		/* $listd="";
		 foreach ($rwmu as $row)
			{
				$listd.="<tr>";
				$listd.="<td>".$row['periode']."</td>"; 
				$listd.="<td>".$row['tgl_generate']."</td>"; 
				if($row['tgl_export']=="0000-00-00 00:00:00"){
					$listd.="<td>-</td>"; 
				}else{
					$listd.="<td>".$row['tgl_export']."</td>"; 
				}
				if($row['status']=="0"){
					$listd.="<td>Belum Upload</td>"; 
				}else{
					$listd.="<td>Terkirim</td>"; 
				}

				if($row['status']=="0"){
					//echo '<td><button type="button" id="btn-submit" class="btn btn-sm btn-primary btn-gradient dark btn-block">Transfer File</button></td>'; 
					$listd.='<td><button type="button" id="tranfi-'.$row['id_export'].'" onclick="transfer('.$row['id_export'].',"'.$row['namafile'].'")" class="btn btn-sm btn-primary btn-gradient dark btn-block">Transfer File</button></td>'; 
				}else{
					$listd.="<td>&nbsp;</td>"; 
				}
				$listd.="</tr>";
			}
			echo '<tbody>';
			echo $listd;
			echo '</tbody>';*/
		//$res = force_download($filename, $data);
		//var_dump($res);die;
        /*
		if($res==true) {
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
		echo json_encode($out);*/
	}

	function doUpload($periode='')
	{
	   $gagal = '';
       $sukses = '';	
		if ($this->input->post('file_upload')) {
            //set preferences
            
            //file upload destination
            $config['upload_path'] = './upload/';
            $config['allowed_types'] = 'xls|xlsx';
            $config['max_size'] = '0';
            $config['max_filename'] = '255';
            $config['encrypt_name'] = TRUE;
            $file = array();
            $is_file_error = FALSE;
            if (!$_FILES) {
                $is_file_error = TRUE;
                $this->handle_error('Select at least one file.');
                $gagal = 'Pilih sedikitnya 1 file';
            }

            if (!$is_file_error) {
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('file_name')) {
                    $this->handle_error($this->upload->display_errors());
                    
                    $gagal = $this->upload->display_errors();
                    $is_file_error = TRUE;
                } else {
                    $file = $this->upload->data();
                }
            }

            if ($is_file_error) {
                if ($file) {
                    $file = './upload/' . $file['file_name'];
                    if (file_exists($file)) {
                        unlink($file);
                    }
                }
            }
            if (!$is_file_error) {
                $resp = $this->jurnal_export_import->save_file_info($file);
                //echo '<pre>'.$res.'</pre>';
                
                if ($resp === TRUE) {
                    $this->jurnal_export_import->read_n_save($file = './upload/' . $file['file_name']);
                    $this->handle_success('File was successfully uploaded and validating.');

                    $sukses = 'File was successfully uploaded and validating.';
                } else {
                    //if file info save in database was not successful then delete from the destination folder
                    $file = './upload/' . $file['file_name'];
                    if (file_exists($file)) {
                        unlink($file);
                    }
                    $this->handle_error('Error while saving file info to Database.');
                    $gagal = 'Error while saving file info to Database.';
                }
            }
        }

        //die('<pre>'.$gagal.'</pre><br>'.'<pre>'.$sukses.'</pre><br>');
        $data['idmenu'] 		= 'accounting-upload-jurnal';
		$data['content'] 		= '../../tr_accounting/views/upload_jurnal';
		$data['js'] 			= '../../tr_accounting/views/upload_jurnal_js'; 

        $data['datacontent']['errors']  = $gagal;//$this->error;
        $data['datacontent']['success'] = $sukses; //$this->success;
        
        //$this->load->view('file_upload', $data);

        $this->buildView($data);

        /*return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
            */
	}

	function do_transfer()
	{
        $user = $this->input->post('uid');
        $res = $this->jurnal_export_import->transferUploadedByUsername($user);
        $out = array();
        if($res){
            $out['res'] = 'false';
            $out['pesan'] = 'Proses Upload Jurnal gagal';
        }else{
            $out['res'] = 'true';
            $out['pesan'] = 'Proses Upload Jurnal berhasil';
        }
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($out));
	}

	function genDT_jurnal($periode = FALSE) { 
		if($periode===FALSE)
			$periode = date('m-Y');
		list($bln, $thn) = explode('-', $periode);
		$bln = ltrim($bln, '0');
		$this->datatables->select('no_bukti, date_format(tanggal, "%d-%m-%Y") AS tanggal, kode_coa, kode_customer as kode_nasabah, kode_nasabah as kode_customer, kode_sumberdaya,'.
				'kode_spk, kode_tahap, no_invoice, kode_faktur, format(volume, 2) AS volume,'.
				'format(CASE WHEN dk = "D" THEN rupiah ELSE 0 END, 2) AS debet, format(CASE WHEN dk = "K" THEN rupiah ELSE 0 END, 2) AS kredit,'.
				'keterangan', FALSE)
			->from('tr_accounting')
			->where(array('MONTH(tanggal)'=>$bln, 'YEAR(tanggal)'=>$thn));
		echo $this->datatables->generate();
	}

	function genDT_jurnal2() {
		
		$bln = $this->input->post('bln');
		$thn = $this->input->post('thn');
		$periode = $bln.'-'.$thn;
		//print_r($periode);
		//if($periode===FALSE)
		//	$periode = date('m-Y');
		list($bln, $thn) = explode('-', $periode);
		$bln = ltrim($bln, '0');
		$this->datatables->select('no_bukti, date_format(tanggal, "%d-%m-%Y") AS tanggal, kode_coa, kode_nasabah, kode_sumberdaya,'.
				'kode_spk, kode_tahap, no_invoice, kode_faktur, format(volume, 2) AS volume,'.
				'format(CASE WHEN dk = "D" THEN rupiah ELSE 0 END, 2) AS debet, format(CASE WHEN dk = "K" THEN rupiah ELSE 0 END, 2) AS kredit,'.
				'keterangan', FALSE)
			->from('tr_accounting')
			->where(array('MONTH(tanggal)'=>$bln, 'YEAR(tanggal)'=>$thn));
		echo $this->datatables->generate();
	}

	function upload_jurnal()
	{
		$data['idmenu'] 		= 'accounting-upload-jurnal';
		$data['content'] 		= '../../tr_accounting/views/upload_jurnal';
		$data['js'] 			= '../../tr_accounting/views/upload_jurnal_js'; 
		//$data['upload']			= jurnal_export_import::upload_jurnal();
		$this->buildView($data);
	}
	function load_Jurnal($uid)
	{
		$data= $this->jurnal_export_import->load_tmpjurnal($uid);
		return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
	}
	function loadjurnal()
	{

		$q					= $this->jurnal_export_import->load_tmpjurnal();
		$data['num']		= $q->num_rows();
		$data['query']		= $q->result();
		$data['rowu']		= $q->row();
		/*$config = array();
        $config["base_url"] = base_url() . "index.php/jurnal/upload";
        $config["total_rows"] = $data['num'];//count($q->num_rows());
        $config["per_page"] = 4;
        $config["uri_segment"] = 3;

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["results"] = jurnal_export_import::load_jurnal($config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();
		*/

		$this->load->view('form_child', $data);
	}

	function lookup($field)
	{
     	$keyword = $this->input->post('term');
     	$data['response'] = 'false'; //mengatur default response
     	
        /*
        if($field=='coa'){
     		$query = $this->jurnal_export_import->_lookup($field,$keyword); 
     	}
     	if ($field=='nasabah') {
     		$query = $this->jurnal_export_import->_lookup($field,$keyword); 
     	}
        if ($field=='customer') {
            $query = $this->jurnal_export_import->_lookup($field,$keyword); 
        }
     	if ($field=='sbdy') {
     		$query = $this->jurnal_export_import->_lookup($field,$keyword); 
     	}
     	if ($field=='spk') {
     		$query = $this->jurnal_export_import->_lookup($field,$keyword); 
     	}
     	if ($field=='tahap') {
     		$query = $this->jurnal_export_import->_lookup($field,$keyword); 
     	}
     	if ($field=='bank') {
     		$query = $this->jurnal_export_import->_lookup($field,$keyword); 
     	}
     	if ($field=='jenis') {
     		$query = $this->jurnal_export_import->_lookup($field,$keyword); 
     	}*/
        if ($field=='sales_customer') {
            $query = $this->jurnal_export_import->_lookup($field,$keyword); 
            if(! empty($query) ) {
                $data['response']   = 'true'; //mengatur response
                $data['message']    = array(); //membuat array
                foreach( $query as $row ){
                    $data['message'][] = array(
                        'klasifikasi'   => $row->klasifikasi, 
                        'nama'          => $row->nama,
                        'no_id'         => $row->no_id,
                        'jenis_id'      => $row->jenis_id,
                        'npwp'          => $row->npwp,
                        'no_hp'         => $row->hp,
                        'tempat_lahir'  => $row->tempat_lahir,
                        'warganeraga'   => $row->nationality,
                        'jenis_kelamin' => $row->jk,
                        'salutation'    => $row->salutation,
                        'no_identitas'  => $row->no_id,
                        'email'         => $row->email,
                        'tgl_lahir'     => date('d').'/'.date('m').'/'.date('Y'),
                        'tmpt_lahir'    => $row->tempat_lahir,
                        'agama'         => $row->agama,
                        'alamat'        => $row->alamat,
                        'kota'          => $row->kota,
                        'tlp_rumah'     => $row->telp_rumah,
                        'nama_pt'       => $row->nama_perusahaan,
                        'kota_pt'       => $row->kota_perusahaan,
                        'telp_pt'       => $row->telp_perusahaan,
                        'alamat_pt'     => $row->alamat_perusahaan,
                        'kodepos_pt'    => $row->kodepos_perusahaan,
                        'nationality'   => $row->nationality,
                        'jk'            => $row->jk,
                        'value'         => $row->nama); 
                } 
                
            }
        }else{
            $query = $this->jurnal_export_import->_lookup($field,$keyword); 
 
            if(! empty($query) ) {
                $data['response']   = 'true'; //mengatur response
                $data['message']    = array(); //membuat array
                foreach( $query as $row ){
                    $data['message'][] = array('label' => $row->kode.' - '.$row->nama, 'value' => $row->kode);
                }           
                
            }
        }
     	

	  	if(IS_AJAX){
	   		echo json_encode($data); 
	  	}else {
	  		//$this->load->view('home/index',$data); 
	   	}
    }

    function sales_lookup($field)
    {
        $keyword = $this->input->post('term');
        $data['response'] = 'false';
        $query = $this->jurnal_export_import->_lookup($field,$keyword); 
 
        if(! empty($query) ) {
            $data['response']   = 'true';
            $data['message']    = array();
            foreach( $query as $row ){
                $data['message'][] = array('klasifikasi' => $row->kode, 'value' => $row->nama);
            }           
            
        }
        
        if(IS_AJAX){
            echo json_encode($data); 
        }else {
            //$this->load->view('home/index',$data); 
        }
    }

    function lookup_nasabah()
	{
     	$keyword = $this->input->post('term');
     	$data['response'] = 'false'; //mengatur default response
     	$query = $this->jurnal_export_import->cari_nasabah($keyword); //memanggil fungsi pencarian pada model
 
     	if(! empty($query) ) {
        	$data['response'] 	= 'true'; //mengatur response
        	$data['message'] 	= array(); //membuat array
        	foreach( $query as $row ){
           		$data['message'][] = array('label' => $row->kode.' - '.$row->nama, 'value' => $row->kode); //mengisi array dengan record yang diperoleh
          	}
     	}
	    
	  	if(IS_AJAX){
	   		echo json_encode($data); //mencetak json jika merupakan permintaan ajax
	  	}else {
	  		$this->load->view('home/index',$data); //memanggil file view dan mengisi data yg diperoleh
	   	}
    }

    function json_jurnalnobuk()
    {
    	$nobuk = $this->input->cookie('is_edit_nobukti');
    	$query = $this->jurnal_export_import->_json_nobuk($nobuk);
    	if(!empty($query)) {
    		foreach ($query as $row) { 
    			$data[] = array(
    				'kd_coa'		=> $row->kode_coa.'<input type="hidden" name="no_bukti[]" id="no_bukti[]" value="'.$row->no_bukti.'"><input type="hidden" name="kode_coa[]" id="kode_coa[]" value="'.$row->kode_coa.'">'.'<input type="hidden" name="l_coa[]" id="l_coa[]" value="'.$row->nama_akun.'"/>', 
                    'kd_nasabah'	=> $row->kode_nasabah.'<input type="hidden" name="kode_nasabah[]" id="kode_nasabah[]" value="'.$row->kode_nasabah.'">'.'<input type="hidden" name="l_nas[]" id="l_nas[]" value="'.$row->nama_nasabah.'"/>', 
                    'kd_customer'   => $row->kode_customer.'<input type="hidden" name="kode_customer[]" id="kode_customer[]" value="'.$row->kode_customer.'">'.'<input type="hidden" name="l_cus[]" id="l_cus[]" value="'.$row->nama_customer.'"/>', 
                    'kd_sumberdaya'	=> $row->kode_sumberdaya.'<input type="hidden" name="kode_sumberdaya[]" id="kode_sumberdaya[]" value="'.$row->kode_sumberdaya.'">'.'<input type="hidden" name="l_sby[]" id="l_sby[]" value="'.$row->nama_sumberdaya.'"/>', 
                    'kd_spk'		=> $row->kode_spk.'<input type="hidden" name="kode_spk[]" id="kode_spk[]" value="'.$row->kode_spk.'">'.'<input type="hidden" name="l_spk[]" id="l_spk[]" value="'.$row->nama_entity.'"/>', 
                    'kd_tahap'   	=> $row->kode_tahap.'<input type="hidden" name="kode_tahap[]" id="kode_tahap[]" value="'.$row->kode_tahap.'">'.'<input type="hidden" name="l_thp[]" id="l_thp[]" value="'.$row->nama_tahap.'"/>', 
                    'kd_bank'     	=> $row->kode_bank.'<input type="hidden" name="kode_bank[]" id="kode_bank[]" value="'.$row->kode_bank.'">'.'<input type="hidden" name="l_bnk[]" id="l_bnk[]" value="'.$row->nama_bank.'"/>', 
                    'nomor_terbit'	=> $row->no_terbit.'<input type="hidden" name="nomor_terbit[]" id="nomor_terbit[]" value="'.$row->no_terbit.'">', 
                    'faktur_pajak'	=> $row->kode_faktur.'<input type="hidden" name="kode_faktur[]" id="kode_faktur[]" value="'.$row->kode_faktur.'">', 
                    'no_invoice'  	=> $row->no_invoice.'<input type="hidden" name="no_invoice[]" id="no_invoice[]" value="'.$row->no_invoice.'">', 
                    'bukti_potong' 	=> $row->bukti_potong.'<input type="hidden" name="bukti_potong[]" id="bukti_potong[]" value="'.$row->bukti_potong.'">', 
                    'debit'     	=> ($row->dk=='D'?number_format($row->rupiah,2):0).'<input type="hidden" name="f_debit[]" id="f_debit[]" class="jDebit" value="'.($row->dk=='D'?$row->rupiah:0).'">', 
                    'kredit'     	=> ($row->dk=='K'?number_format($row->rupiah,2):0).'<input type="hidden" name="f_kredit[]" id="f_kredit[]" class="jKredit" value="'.($row->dk=='K'?$row->rupiah:0).'">', 
                    //'vdebit'     	=> ($row->dk=='D'?number_format($row->rupiah,2):0), 
                    //'vkredit'     	=> ($row->dk=='K'?number_format($row->rupiah,2):0), 
                    'vol'    		=> ($row->volume==null||$row->volume==''?0:$row->volume).'<input type="hidden" name="f_volume[]" id="f_volume[]" value="'.($row->volume==null||$row->volume==''?0:$row->volume).'">', 
                    'keterangan' 	=> $row->keterangan.'<input type="hidden" name="f_keterangan[]" id="f_keterangan[]" value="'.$row->keterangan.'">', 
                    'aksi'      	=> '<a href="javascript:" class="row-edit" data-toggle="tooltip" title="Edit data"><span class="glyphicons glyphicons-edit"></span></a>&nbsp;&nbsp;&nbsp;'.
                                       '<a href="javascript:" class="row-delete" data-toggle="tooltip" title="Delete data"><span class="glyphicons glyphicons-bin"></span></a>&nbsp;&nbsp;&nbsp;'.
                                       '<a href="javascript:" class="row-duplicate" data-toggle="tooltip" title="Duplicate data"><span class="glyphicons glyphicons-playing_dices"></span></a>'
                	);
    		}
    		//$this->output->set_content_type('application/json');
    		//header('Content-type: text/html');
			echo json_encode($data);
    	}


    }
    function jsons()
    {
    	$data = $this->json_jurnalnobuk();
    	$json = json_decode($data,true);
    	echo $json;
    	
    }
    function json_deco(){
    	$data['idmenu'] 						= 'accounting-jurnal-entry';
		//$data['batch_num'] 					= $this->get_batch();
		$data['content'] 						= '../../tr_accounting/views/json_test';
		$data['js'] 							= '../../tr_accounting/views/json_test_js';

		$this->buildView($data);
    }
 

	function cek_uploaded()
	{
		$res = $this->jurnal_export_import->cek_uploaddata();
		$this->output->set_content_type('application/json');
		echo json_encode($res);
	}

	public function form_integrasi_ar() {
		$data['idmenu'] = 'accounting-jurnal-ar';
		$data['content'] = '../../tr_accounting/views/form_integrasi_ar';
		$data['js'] = '../../tr_accounting/views/form_integrasi_ar_js';
		$this->buildView($data);
	}

	public function genDT_ar() {
		$sql_join = "(SELECT kode_entity, no_unit, SUM(rp) AS rp FROM tr_hpp GROUP BY kode_entity, no_unit) AS hpp";
		if($this->session->userdata('type_entity')==='HR') {
			$sql_join = "(SELECT stk.kode_entity, stk.no_unit, stk.wide_gross * SUM(hpp.rp) / rik.luas AS rp FROM tr_hpp_hr hpp 
				INNER JOIN mst_stock stk ON stk.kode_entity = hpp.kode_entity AND stk.type_property = hpp.type_property 
				INNER JOIN ( SELECT kode_entity, type_property, SUM(luas * volume) AS luas FROM tr_rik_detail_rencana_produk 
				GROUP BY kode_entity, type_property ) AS rik ON rik.kode_entity = hpp.kode_entity AND rik.type_property = hpp.type_property 
				GROUP BY stk.kode_entity, stk.type_property, stk.no_unit) AS hpp";
		}
		$this->datatables->select('CONCAT(pay.reserve_no,"<br/>No. Unit: ",pay.no_unit,"<br/>Kode Nasabah: ",pay.kode_nasabah) AS info, '.
				'FORMAT(IFNULL(ri.rp,0)/IFNULL(hpp.rp, 0)*100, 2) AS progress, '.
				'FORMAT(paydet.rp,2) AS rp, '.
				'CASE WHEN IFNULL(ar.id,0) = 0 THEN '.
				'CONCAT("<a href=\"javascript:\" class=\"label label-warning btn-posting\" data-payid=\"",paydet.id,"\"> Belum Posting </a>") ELSE '.
				'"<a href=\"javascript:\" class=\"label label-success\"> Sudah Posting </a>" END AS status', FALSE)
			->from('tr_payment_detail paydet')
			->join('tr_payment pay', 'pay.reserve_no = paydet.reserve_no', 'inner')
			->join('(SELECT invunit.kode_entity, invunit.no_unit, inv.rp / tbl.n AS rp FROM tr_invoice_unit invunit '.
				'LEFT JOIN ( SELECT no_po, COUNT(*) AS n FROM tr_invoice_unit GROUP BY no_po ) AS tbl ON tbl.no_po = invunit.no_po '.
				'INNER JOIN tr_invoice inv ON inv.no_po = invunit.no_po) AS ri', 'ri.kode_entity = pay.kode_entity AND ri.no_unit = pay.no_unit', 'left')
			->join($sql_join, 'hpp.kode_entity = pay.kode_entity AND hpp.no_unit = pay.no_unit', 'left')
			->join('tr_posting_jurnal_ar ar', 'ar.reserve_no = pay.reserve_no AND ar.payment_id = paydet.id', 'left')
			->where('pay.kode_entity = "'.$this->session->userdata('kode_entity').'" AND pay.iscancelled = 0 AND paydet.tgl_bayar IS NOT NULL');
		echo $this->datatables->generate();
	}

	public function do_integration_ar($payid) {
		$data = $this->jurnal_export_import->get_integration_ar($payid);
		$this->load->model('../../tr_sales/models/tr_sales_model');
		return $this->tr_sales_model->do_integration($data);
	}

	public function input_jurnal() {

		$data['idmenu'] 						= 'accounting-jurnal-entry';
		//$data['batch_num'] 					= $this->get_batch();
		$data['content'] 						= '../../tr_accounting/views/input_jurnal';
		$data['js'] 							= '../../tr_accounting/views/input_jurnal_js';
		$data['datacontent'] 					= $this->jurnal_export_import->get_datacombo();
		$data['datacontent']['divisi'] 			= $this->jurnal_export_import->getDivisi($this->session->userdata('usernm'));
		$data['datacontent']['cbo_jenisjurnal'] = cbo_kode_jenisjurnal('kd_jenis','','','---Pilih Jenis Jurnal---');
		$data['datacontent']['cbo_bank'] 		= cbo_bank('kd_bank','','','---Pilih Nama Bank---');
		$data['datacontent']['cbo_tahap'] 		= cbo_tahap('kd_tahap','','','---Pilih Tahap Pekerjaan---');
		$this->buildView($data);
	}


	function entry_jurnal($post) 
	{

		$data['idmenu'] 						= 'accounting-jurnal-entry';
		//$data['batch_num'] 					= $this->get_batch();
		$data['content'] 						= '../../tr_accounting/views/input_jurnal2';
		$data['js'] 							= '../../tr_accounting/views/input_jurnal2_js';
		$data['datacontent'] 					= $this->jurnal_export_import->get_datacombo();
		$data['datacontent']['divisi'] 			= $this->jurnal_export_import->getDivisi($this->session->userdata('usernm'));
		$data['datacontent']['cbo_jenisjurnal'] = cbo_kode_jenisjurnal('kd_jenis','','','-pilih Jenis-');
		$data['datacontent']['cbo_bank'] 		= cbo_bank('kd_bank','','','---Pilih Nama Bank---');
		$data['datacontent']['cbo_tahap'] 		= cbo_tahap('kd_tahap','','','---Pilih Tahap Pekerjaan---');
        $data['datacontent']['post']            = $post;
        //die(var_dump($data));
		$this->buildView($data);
	}

    function simpan_voucher($cond='print'){
        $data = $this->input->post();

        //var_dump($data);die;
        $res = $this->jurnal_export_import->_insert_voucher($data);
        //var_dump($res);die;
        //if($this->input->post('is_mode')=='edit')
        /*if($res==true) {
            $out = array(
                'response'=>'1',
                'msg'=>'Success'
            );
        } else {
            $out = array(
                'response'=>'0',
                'msg'=>'Failed'
            );
        }*/
        $this->output->set_content_type('application/json');
        echo json_encode($res);
    }

    function print_voucher($nomor){
        
        $data['datacontent'] = $this->jurnal_export_import->cetakVoucher($nomor);
        
        
        $this->buildView($data);
    }
	function is_edit_jurnal($no_bukti)
	{
		return $this->jurnal_export_import->_get_jurnal($no_bukti);
	}

	function view_jurnal() {

		$data['idmenu'] 		= 'accounting-jurnal';
		$data['content'] 		= '../../tr_accounting/views/view_jurnal';
		$data['js'] 			= '../../tr_accounting/views/view_jurnal_js2'; 

		$this->buildView($data);
	}

    function view_jurnal2($prpage=0)
    {
        //error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        $data = array();
        $arr_data = array();
        $is_adv = $this->input->post('is_adv');
        $ck_periode = $this->input->post('is_periode');
        $limit = $this->session->userdata('page_limit');
        $offset = 4;
        if($is_adv==0){
            //var_dump($this->input->post('cari'));
            $arr_cari = array("no_bukti"=>$this->input->post('cari') );
            $data['search'] = $arr_cari;
            //$this->session->set_userdata('pencarian', $data['search']);
        }else{
            $fields     = $this->input->post('field');
            $kondisi    = $this->input->post('kondisi');
            $nilai      = $this->input->post('nilai');
            $periode    = $this->input->post('periode');
            list($b,$t) = explode('/',$periode);
        }
       
        $sql = 'SELECT no_bukti, tanggal, jenis, no_invoice, kode_coa, kode_nasabah, kode_customer, 
                       kode_sumberdaya, kode_spk, kode_tahap, kode_faktur, kode_alat, volume, dk, 
                       rupiah, keterangan, tr_level  
                FROM tr_accounting
                WHERE no_bukti IS NOT NULL ';

        //if ($is_adv==0 || $is_adv==1) {//(isset($_POST['q']) && !empty($_POST['q'])) {
        //if ( isset($_POST['q']) ){
        if(!empty($_POST)){
            
            if($is_adv==0){
                //var_dump($this->input->post('cari'));
                $arr_cari = array("no_bukti"=>$this->input->post('cari') );
                $data['search'] = $arr_cari;
                //$this->session->set_userdata('pencarian', $data['search']);
            }else{
                for($i=0; $i < count($fields); $i++){
                    if($ck_periode==1){
                        $arr_data[] = array(
                                    'field'     =>$fields[$i], 
                                    'nilai'     =>$nilai[$i],
                                    'periode'   =>$t.'-'.$b,
                                    'kondisi'   =>$kondisi[$i]
                                );
                    }else{
                        $arr_data[] = array(
                                    'field'     =>$fields[$i], 
                                    'nilai'     =>$nilai[$i],
                                    'kondisi'   =>$kondisi[$i]
                                );
                    }
                    
                }
                
                $arr_cari = $arr_data;
                //echo '11111 - '.$is_adv;
                $data['search'] = $arr_data; 
            }
            $this->session->set_userdata('pencarian', $arr_data);
            $this->session->set_userdata('is_advance', $is_adv);
        }else{
            $is_adv = $this->session->userdata('is_advance');
            if ($is_adv==0) {
                //echo '22222 - '.$is_adv;
                $data['search'] = $this->session->userdata('pencarian'); //$this->session->set_userdata('pencarian', $data['search']);
                //var_dump($this->session->userdata('pencarian'));
            }
            else {
                //echo '33333 - '.$is_adv;
                //var_dump($data['search']);
                $data['search'] = $this->session->userdata('pencarian');  
            }
        }
        
        if(!empty($_POST)){

        }else{
        
            if ($is_adv==0) {
                if(!empty($_POST)){
                //var_dump($data['search']);
                    $this->db->like($data['search'], 'both');
                }
            }else{
                
                foreach($this->session->userdata('pencarian') as $k => $v){
                    $ar = $v['field'].','.$v['nilai'].','.$v['kondisi'];
                    //var_dump($v);
                    //echo $ar."zzzzz<br>";die;
                    if( $v['kondisi']=='like_before'){
                        $this->db->like($v['field'],$v['nilai'],'before');
                        $sql.=" AND ".$v['field']." LIKE '%".$v['nilai']."' ";
                    }elseif( $v['kondisi']=='like_after'){
                        $this->db->like($v['field'],$v['nilai'],'after');
                        $sql.=" AND ".$v['field']." LIKE '".$v['nilai']."%' ";
                    }elseif( $v['kondisi']=='like_both'){
                        $this->db->like($v['field'],$v['nilai'],'both');
                        $sql.=" AND ".$v['field']." LIKE '%".$v['nilai']."%' ";
                    }elseif( $v['kondisi']=='like_match'){
                        $this->db->like($v['field'],$v['nilai'],'match');
                        $sql.=" AND ".$v['field']." = '".$v['nilai']."' ";
                    }else{
                        if( $v['field']=='rp_debit'){
                            $this->db->where(array('dk'=>'D'));
                            $this->db->where('rupiah '.$v['kondisi'],$v['nilai']);
                            $sql.=" AND DK='D'";
                            $sql.=" AND rupiah ".$v['kondisi']." ".$v['nilai']." ";
                        }elseif( $v['field']=='rp_kredit'){
                            $this->db->where(array('dk'=>'K'));
                            $this->db->where('rupiah '.$v['kondisi'],$v['nilai']);
                            $sql.=" AND DK='K'";
                            $sql.=" AND rupiah ".$v['kondisi']." ".$v['nilai']." ";
                        }else{
                            $this->db->where($v['field'].' '.$v['kondisi'],$v['nilai']);
                            $sql.=" AND rupiah ".$v['kondisi']." ".$v['nilai']." ";
                        }
                    }
                    if($ck_periode==1){
                        $this->db->like('tanggal',$v['periode'],'after');
                        $sql.=" AND tanggal LIKE '".$v['periode']."%' ";
                    }
                }
               
            }
        }
        //var_dump($this->jurnal_export_import->getViewCountDataCari($data['search'], $is_adv, $ck_periode));die;

        $sql.=' ORDER BY no_bukti ASC, tanggal ASC ';
        $lim = !empty($limit)?$limit:0;
        $uri = !empty($offset)?$offset:'';
        $kom = !empty($offset)?',':'';
        $sql.='LIMIT '.$lim.$kom.$uri;
       // $q = $this->db->query($sql);
        //$this->db->from('tr_accounting');
        //echo $this->db->last_query();
        
        if(empty($limit)){
            $limit = 10;
        }
        // pagination limit
        $pagination['base_url']         = base_url().'index.php/jurnal/view2/page/';
        
        $pagination['full_tag_open']    = "<div class=\"paginationx\" style='letter-spacing:2px;'>";
        $pagination['full_tag_close']   = "</div>";
        $pagination['cur_tag_open']     = '<span class="btn btn-default light current">';
        $pagination['cur_tag_close']    = "</span>";
        $pagination['num_tag_open']     = '<span class="btn btn-default dark">';
        $pagination['num_tag_close']    = "</span>";
        $pagination['first_link']       = '<button type="button" class="btn btn-default light"><i class="fa fa-chevron-left"></i></button>';
        $pagination['prev_link']        = '<button type="button" class="btn btn-default light"><i class="fa fa-chevron-left"></i></button>';
        $pagination['next_link']        = '<button type="button" class="btn btn-default light"><i class="fa fa-chevron-right"></i></button>';
        $pagination['last_link']        = '<button type="button" class="btn btn-default light"><i class="fa fa-chevron-right"></i></button>';
        $pagination['per_page']         = $limit;
        $pagination['uri_segment']      = 4;
        $pagination['num_links']        = 3;
        $pagination['total_rows']       = $this->jurnal_export_import->getViewCountDataCari($data['search'], $is_adv, $ck_periode);

        $this->pagination->initialize($pagination);

        $start = $this->uri->segment(4, 0);

        $data['idmenu']                 = 'accounting-jurnal';
        $data['content']                = '../../tr_accounting/views/view_jurnal2';
        $data['js']                     = '../../tr_accounting/views/view_jurnal2_js'; 
       
        $data['datacontent']            = $this->jurnal_export_import->getViewDataCari($limit, $start, $data['search'], $is_adv, $ck_periode);
        $data['datacontent']['rowtot']  = $this->jurnal_export_import->getViewCountDataCari($data['search'], $is_adv, $ck_periode);
        $data['datacontent']['total_record'] = $this->jurnal_export_import->getViewCountDataCari($data['search'], $is_adv, $ck_periode);
        $data['datacontent']['limit']   = $pagination['per_page'];
        $data['datacontent']['start']    = $prpage==0?$limit:($prpage+$limit);
        $data['datacontent']['pagination']=$this->pagination->create_links();

        $this->buildView($data);
    }

    function page_limit(){
        $limit = $this->input->post('limit');
        //$data = array('page_limit'=>$limit,'page_uri'=>$offset);
        $this->session->set_userdata('page_limit', $limit);
        $res= array('limit'=>$limit);
        $this->output->set_content_type('application/json');
        echo json_encode($res);
    }

    function ajaxPaginationData()
    {
        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
        
        //total rows count
        $totalRec = count($this->post->getRows());
        
        //pagination configuration
        $config['first_link']  = 'First';
        $config['div']         = 'postList'; //parent div tag id
        $config['base_url']    = base_url().'posts/ajaxPaginationData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        
        $this->ajax_pagination->initialize($config);
        
        //get the posts data
        $data['posts'] = $this->post->getRows(array('start'=>$offset,'limit'=>$this->perPage));
        
        //load the view
        $this->load->view('posts/ajax-pagination-data', $data, false);
    }

    function ExportExcel(){
        $this->load->library('ExportExcel');
        
        $sql = $this->jurnal_export_import->myqueryfunction();
        $this->export->to_excel($sql, 'nameForFile'); 
    }
	function save_jurnal()
	{
		$data = $this->input->post();

		$res = $this->jurnal_export_import->_insert($data);
		//var_dump($res);die;
        //if($this->input->post('is_mode')=='edit')
		/*if($res==true) {
			$out = array(
				'response'=>'1',
				'msg'=>'Success'
			);
		} else {
			$out = array(
				'response'=>'0',
				'msg'=>'Failed'
			);
		}*/
		$this->output->set_content_type('application/json');
		echo json_encode($res);
		
	}

	function delete_jurnal()
	{
		$data = $this->input->post('no_bukti');

		$res = $this->jurnal_export_import->_delete($data);
		//var_dump($res);die;
        
		if($res==true) {
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

	public function form_jurnal() {
		$data['idmenu'] = 'accounting-jurnal';
		$data['content'] = '../../tr_accounting/views/v_input_jurnal';
		$data['js'] = '../../tr_accounting/views/input_jurnal_js';
		$data['datacontent'] = $this->jurnal_export_import->get_datacombo();
		$this->buildView($data);
	}

	public function rpt_form_periode($target) {
		$data['idmenu'] 				= 'rpt-'.$target;
		$data['content'] 				= '../../tr_accounting/views/form_periode';
		$data['js'] 					= '../../tr_accounting/views/form_periode_js';
		$data['datacontent']['target'] 	= $target;
		if($target==='ledger'){
			$data['datacontent']['coa'] = combo_coa('kode_coa', '', '','chosen-select');
			$data['datacontent']['param'] = 'ledger';
			$data['datacontent']['cbo_div']	= combo_divisi('div_id', '', '', 'chosen-select');
		}
        if($target==='opensystem-pemasok'){

        }
        if($target==='opensystem-subkon'){

        }
		//$data['datacontent']['cbo_div']	= combo_divisi('div_id', '', '', 'chosen-select');
	
		$this->buildView($data);
	}

	public function rpt_neraca_t($periode = FALSE, $divisi = FALSE) {
		if($periode===FALSE) {
			$this->rpt_form_periode('neraca-t');
		} else {
            $kd_unitkerja                       = $this->session->userdata('unit_kerja');
            $unit_kerja                         = $kd_unitkerja=='KAWASAN'?$this->session->userdata('kode_entity'):'';
            $kd_spk                             = $unit_kerja; //kode_entity = kode_spk
			$data = array(); 
			$data['idmenu'] 					= 'rpt-neraca-t';
			$data['content'] 					= '../../tr_accounting/views/rpt_neraca_t';
			$data['js'] 						= '../../tr_accounting/views/rpt_neraca_t_js';
			$data['datacontent']['datatable'] 	= $this->jurnal_export_import->gen_rpt_neraca_t($periode,$divisi,$kd_spk);
			$data['datacontent']['nama'] 		= $this->session->userdata('nama');
			list($b,$t) = explode('-',$periode);
			$data['datacontent']['periode'] 	= $this->strutils->strBulan($b).' '.$t;
			$data['datacontent']['periode_t'] 	= $t;
			$data['datacontent']['divisi'] 		= $this->jurnal_export_import->getNamaDivisi($divisi);
			$data['datacontent']['kawasan'] 	= $this->session->userdata('nama_entity');
			$this->buildView($data);
		}
	}

	public function rpt_neraca_lajur($periode = FALSE, $divisi = FALSE) {
		if($periode===FALSE) {
			$this->rpt_form_periode('neraca-lajur');
		} else {
			$data = array();
			$data['idmenu'] 					= 'rpt-neraca-lajur';
			$data['content'] 					= '../../tr_accounting/views/rpt_neraca_lajur';
			$data['js'] 						= '../../tr_accounting/views/rpt_neraca_lajur_js';
			$data['datacontent']['datatable'] 	= $this->jurnal_export_import->gen_rpt_neraca_lajur($periode);
			$data['datacontent']['nama'] 		= $this->session->userdata('nama');
			list($b,$t) = explode('-',$periode);
			$data['datacontent']['periode'] 	= $this->strutils->strBulan($b).' '.$t;
			$data['datacontent']['divisi'] 		= $this->jurnal_export_import->getNamaDivisi($divisi);
			$data['datacontent']['kawasan'] 	= $this->session->userdata('nama_entity');
			$this->buildView($data);
		}
	}

	public function rpt_labarugi($periode = FALSE, $divisi = FALSE) {
		if($periode===FALSE) {
			$this->rpt_form_periode('labarugi');
		} else {
			$data = array();
			$data['idmenu'] 					= 'rpt-labarugi';
			$data['content'] 					= '../../tr_accounting/views/rpt_labarugi';
			$data['js'] 						= '../../tr_accounting/views/rpt_labarugi_js';
			$data['datacontent']['datatable']	= $this->jurnal_export_import->gen_rpt_labarugi($periode);
			$data['datacontent']['nama'] 		= $this->session->userdata('nama');
			list($b,$t) = explode('-',$periode);
			$data['datacontent']['periode'] 	= $this->strutils->strBulan($b).' '.$t;
			$data['datacontent']['divisi'] 		= $this->jurnal_export_import->getNamaDivisi($divisi);
			$data['datacontent']['kawasan'] 	= $this->session->userdata('nama_entity');
			$this->buildView($data);
		}
	}

    public function rpt_labarugi_proyek($periode = FALSE, $divisi = FALSE) {
        if($periode===FALSE) {
            $this->rpt_form_periode('labarugi-proyek');
        } else {
            $data = array();
            $data['idmenu']                     = 'rpt-labarugi-proyek';
            $data['content']                    = '../../tr_accounting/views/report/rpt_labarugi_proyek';
            $data['js']                         = '../../tr_accounting/views/report/rpt_labarugi_proyek_js';
            $data['datacontent']['datatable']   = $this->jurnal_export_import->gen_rpt_labarugi($periode);
            $data['datacontent']['nama']        = $this->session->userdata('nama');
            list($b,$t) = explode('-',$periode);
            $data['datacontent']['periode']     = $this->strutils->strBulan($b).' '.$t;
            $data['datacontent']['divisi']      = $this->jurnal_export_import->getNamaDivisi($divisi);
            $data['datacontent']['kawasan']     = $this->session->userdata('nama_entity');
            $this->buildView($data);
        }
    }

	function cekMandatory($kode_akun)
	{
		$this->output->set_content_type('application/json');
		$res = $this->jurnal_export_import->isMandatory($kode_akun);
		echo json_encode($res);
	}

	function cekNomorBukti()
	{	
		$no_bukti = $this->input->post('nobuk');
		$this->output->set_content_type('application/json');
		$res = $this->jurnal_export_import->getNomorBukti($no_bukti);
		if($res==true) {
			$out = array(
				'response'=>'1',
				'msg'=>'Exist'
			);
		} else {
			$out = array(
				'response'=>'0',
				'msg'=>'NotExist'
			);
		}
		$this->output->set_content_type('application/json');
		echo json_encode($out);
	}

	function rpt_bukubesar($periode=false, $divisi = FALSE)
	{
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		if($periode===FALSE || $divisi=false) {
			$this->rpt_form_periode('ledger');
		} else {
			$data = array();
			$data['idmenu'] 					= 'rpt-ledger';
			$data['content'] 					= '../../tr_accounting/views/rpt_bukubesar3';
			$data['datacontent']['rows']		= $this->jurnal_export_import->gen_rpt_bukubesar2($periode);
            //$data['datacontent']['rows']        = $this->jurnal_export_import->gen_rpt_bukubesar($periode);
			$data['datacontent']['rowsa']		= $this->jurnal_export_import->gen_saldoAwal_kasbank($periode);
			$data['datacontent']['nama'] 		= $this->session->userdata('nama');
			list($b,$t) = explode('-',$periode);
			$data['datacontent']['periode'] 	= $this->strutils->strBulan($b).' '.$t;
			$data['datacontent']['kawasan'] 	= $this->session->userdata('nama_entity');
            $data['datacontent']['sa_per']      = $t.'-'.sprintf('%02d',$b-1).'-01';

			$this->buildView($data);
		}
	}

    function rpt_bukubesar_ext($periode=false, $divisi = FALSE)
    {
        $div = $divisi;
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        if($periode===FALSE || $divisi=false) {
            $this->rpt_form_periode('ledger2');
        } else {
            $data = array();
            $data['idmenu']                     = 'rpt-ledger2';
            $data['content']                    = '../../tr_accounting/views/rpt_bukubesar2';
            $data['js']                         = '../../tr_accounting/views/rpt_bukubesar_js';
            $data['datacontent']['rows']        = $this->jurnal_export_import->gen_rpt_bukubesar_ext($periode,$div);
            $data['datacontent']['rowsa']       = $this->jurnal_export_import->get_saldoAwal_bukubesar($periode,$div);
            $data['datacontent']['nama']        = $this->session->userdata('nama');
            list($b,$t) = explode('-',$periode);
            $data['datacontent']['periode']     = $this->strutils->strBulan($b).' '.$t;
            $data['datacontent']['peuriode']    = $periode;
            $data['datacontent']['kawasan']     = $this->session->userdata('nama_entity');
            $this->buildView($data);
        }
    }

	function rpt_kasbank($periode=false, $divisi = FALSE)
	{
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		if($periode===FALSE || $divisi=false) {
			$this->rpt_form_periode('kasbank');
		} else {
			$data = array();
			$data['idmenu'] 					= 'rpt-kasbank';
			$data['content'] 					= '../../tr_accounting/views/rpt_kasbank';
			$data['datacontent']['rows']		= $this->jurnal_export_import->gen_rpt_kasbank($periode);
			$data['datacontent']['rowsa']		= $this->jurnal_export_import->get_saldoAwal($periode);
			$data['datacontent']['nama'] 		= $this->session->userdata('nama');
			//var_dump($data);die;
			list($b,$t) = explode('-',$periode);
			$data['datacontent']['periode'] 	= $this->strutils->strBulan($b).' '.$t;
			$data['datacontent']['divisi'] 		= $this->jurnal_export_import->getNamaDivisi($divisi);
			$data['datacontent']['kawasan'] 	= $this->session->userdata('nama_entity');
			
			$this->buildView($data);
		}
	}

    function rpt_utang_pemasok($periode=false,$divisi = FALSE){
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $modul = 'pemasok';
        if($periode===FALSE) {
            $this->rpt_form_periode('opensystem-pemasok');
        } else {
            $data = array();
            $data['idmenu']                     = 'rpt-opensystem-pemasok';
            $data['content']                    = '../../tr_accounting/views/utang/utang_pemasok3';
            $data['js']                         = '../../tr_accounting/views/utang/utang_pemasok_js';
            $data['datacontent']['rows']        = $this->jurnal_export_import->gen_utang_rincipemasok($modul,$periode);
            //$data['datacontent']['rowsa']       = $this->jurnal_export_import->get_saldoAwal($periode);
            $data['datacontent']['nama']        = $this->session->userdata('nama'); 

            list($b,$t) = explode('-',$periode);
            $data['datacontent']['periode']     = $this->strutils->strBulan($b).' '.$t;
            $data['datacontent']['divisi']      = $this->jurnal_export_import->getNamaDivisi($divisi);
            $data['datacontent']['kawasan']     = $this->session->userdata('nama_entity');
            $data['datacontent']['title_lap']   = $this->jurnal_export_import->getMenuTitle($modul);
            $this->buildView($data);
        }
    }
    function rpt_utang_subkon($periode=false,$divisi = FALSE){
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $modul = 'subkon';
        if($periode===FALSE) {
            $this->rpt_form_periode('opensystem-subkon');
        } else {
            $data = array();
            $data['idmenu']                     = 'rpt-opensystem-subkon';
            $data['content']                    = '../../tr_accounting/views/utang/utang_pemasok3';
            $data['js']                         = '../../tr_accounting/views/utang/utang_pemasok_js';
            $data['datacontent']['rows']        = $this->jurnal_export_import->gen_utang_rincipemasok($modul,$periode);
            //$data['datacontent']['rowsa']       = $this->jurnal_export_import->get_saldoAwal($periode);
            $data['datacontent']['nama']        = $this->session->userdata('nama'); 

            list($b,$t) = explode('-',$periode);
            $data['datacontent']['periode']     = $this->strutils->strBulan($b).' '.$t;
            $data['datacontent']['divisi']      = $this->jurnal_export_import->getNamaDivisi($divisi);
            $data['datacontent']['kawasan']     = $this->session->userdata('nama_entity');
            $data['datacontent']['title_lap']   = $this->jurnal_export_import->getMenuTitle($modul);
            $this->buildView($data);
        }
    }
    function rpt_utang_mandor($periode=false,$divisi = FALSE){
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $modul = 'mandor';
        if($periode===FALSE) {
            $this->rpt_form_periode('opensystem-mandor');
        } else {
            $data = array();
            $data['idmenu']                     = 'rpt-opensystem-mandor';
            $data['content']                    = '../../tr_accounting/views/utang/utang_pemasok3';
            $data['js']                         = '../../tr_accounting/views/utang/utang_pemasok_js';
            $data['datacontent']['rows']        = $this->jurnal_export_import->gen_utang_rincipemasok($modul,$periode);
            //$data['datacontent']['rowsa']       = $this->jurnal_export_import->get_saldoAwal($periode);
            $data['datacontent']['nama']        = $this->session->userdata('nama'); 

            list($b,$t) = explode('-',$periode);
            $data['datacontent']['periode']     = $this->strutils->strBulan($b).' '.$t;
            $data['datacontent']['divisi']      = $this->jurnal_export_import->getNamaDivisi($divisi);
            $data['datacontent']['kawasan']     = $this->session->userdata('nama_entity');
            $data['datacontent']['title_lap']   = $this->jurnal_export_import->getMenuTitle($modul);
            $this->buildView($data);
        }
    }
    function rpt_utang_badmaterial($periode=false,$divisi = FALSE){
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $modul = 'badmaterial';
        if($periode===FALSE) {
            $this->rpt_form_periode('opensystem-badmaterial');
        } else {
            $data = array();
            $data['idmenu']                     = 'rpt-opensystem-badmaterial';
            $data['content']                    = '../../tr_accounting/views/utang/utang_pemasok3';
            $data['js']                         = '../../tr_accounting/views/utang/utang_pemasok_js';
            $data['datacontent']['rows']        = $this->jurnal_export_import->gen_utang_rincipemasok($modul,$periode);
            //$data['datacontent']['rowsa']       = $this->jurnal_export_import->get_saldoAwal($periode);
            $data['datacontent']['nama']        = $this->session->userdata('nama'); 

            list($b,$t) = explode('-',$periode);
            $data['datacontent']['periode']     = $this->strutils->strBulan($b).' '.$t;
            $data['datacontent']['divisi']      = $this->jurnal_export_import->getNamaDivisi($divisi);
            $data['datacontent']['kawasan']     = $this->session->userdata('nama_entity');
            $data['datacontent']['title_lap']   = $this->jurnal_export_import->getMenuTitle($modul);
            $this->buildView($data);
        }
    }
    function rpt_utang_badupah($periode=false,$divisi = FALSE){
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $modul = 'badupah';
        if($periode===FALSE) {
            $this->rpt_form_periode('opensystem-badupah');
        } else {
            $data = array();
            $data['idmenu']                     = 'rpt-opensystem-badupah';
            $data['content']                    = '../../tr_accounting/views/utang/utang_pemasok3';
            $data['js']                         = '../../tr_accounting/views/utang/utang_pemasok_js';
            $data['datacontent']['rows']        = $this->jurnal_export_import->gen_utang_rincipemasok($modul,$periode);
            //$data['datacontent']['rowsa']       = $this->jurnal_export_import->get_saldoAwal($periode);
            $data['datacontent']['nama']        = $this->session->userdata('nama'); 

            list($b,$t) = explode('-',$periode);
            $data['datacontent']['periode']     = $this->strutils->strBulan($b).' '.$t;
            $data['datacontent']['divisi']      = $this->jurnal_export_import->getNamaDivisi($divisi);
            $data['datacontent']['kawasan']     = $this->session->userdata('nama_entity');
            $data['datacontent']['title_lap']   = $this->jurnal_export_import->getMenuTitle($modul);
            $this->buildView($data);
        }
    }
    function rpt_utang_badalat($periode=false,$divisi = FALSE){
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $modul = 'badalat';
        if($periode===FALSE) {
            $this->rpt_form_periode('opensystem-badalat');
        } else {
            $data = array();
            $data['idmenu']                     = 'rpt-opensystem-badalat';
            $data['content']                    = '../../tr_accounting/views/utang/utang_pemasok3';
            $data['js']                         = '../../tr_accounting/views/utang/utang_pemasok_js';
            $data['datacontent']['rows']        = $this->jurnal_export_import->gen_utang_rincipemasok($modul,$periode);
            //$data['datacontent']['rowsa']       = $this->jurnal_export_import->get_saldoAwal($periode);
            $data['datacontent']['nama']        = $this->session->userdata('nama'); 

            list($b,$t) = explode('-',$periode);
            $data['datacontent']['periode']     = $this->strutils->strBulan($b).' '.$t;
            $data['datacontent']['divisi']      = $this->jurnal_export_import->getNamaDivisi($divisi);
            $data['datacontent']['kawasan']     = $this->session->userdata('nama_entity');
            $data['datacontent']['title_lap']   = $this->jurnal_export_import->getMenuTitle($modul);
            $this->buildView($data);
        }
    }
    function rpt_utang_badsubkon($periode=false,$divisi = FALSE){
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $modul = 'badsubkon';
        if($periode===FALSE) {
            $this->rpt_form_periode('opensystem-badsubkon');
        } else {
            $data = array();
            $data['idmenu']                     = 'rpt-opensystem-badsubkon';
            $data['content']                    = '../../tr_accounting/views/utang/utang_pemasok3';
            $data['js']                         = '../../tr_accounting/views/utang/utang_pemasok_js';
            $data['datacontent']['rows']        = $this->jurnal_export_import->gen_utang_rincipemasok($modul,$periode);
            //$data['datacontent']['rowsa']       = $this->jurnal_export_import->get_saldoAwal($periode);
            $data['datacontent']['nama']        = $this->session->userdata('nama'); 

            list($b,$t) = explode('-',$periode);
            $data['datacontent']['periode']     = $this->strutils->strBulan($b).' '.$t;
            $data['datacontent']['divisi']      = $this->jurnal_export_import->getNamaDivisi($divisi);
            $data['datacontent']['kawasan']     = $this->session->userdata('nama_entity');
            $data['datacontent']['title_lap']   = $this->jurnal_export_import->getMenuTitle($modul);
            $this->buildView($data);
        }
    }
    
    function rpt_utang_piutangusaha($periode=false,$divisi = FALSE){
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $modul = 'piutangusaha';
        if($periode===FALSE) {
            $this->rpt_form_periode('opensystem-piutangusaha');
        } else {
            $data = array();
            $data['idmenu']                     = 'rpt-opensystem-piutangretensi';
            $data['content']                    = '../../tr_accounting/views/utang/utang_pemasok3';
            $data['js']                         = '../../tr_accounting/views/utang/utang_pemasok_js';
            $data['datacontent']['rows']        = $this->jurnal_export_import->gen_utang_rincipemasok($modul,$periode);
            //$data['datacontent']['rowsa']       = $this->jurnal_export_import->get_saldoAwal($periode);
            $data['datacontent']['nama']        = $this->session->userdata('nama'); 

            list($b,$t) = explode('-',$periode);
            $data['datacontent']['periode']     = $this->strutils->strBulan($b).' '.$t;
            $data['datacontent']['divisi']      = $this->jurnal_export_import->getNamaDivisi($divisi);
            $data['datacontent']['kawasan']     = $this->session->userdata('nama_entity');
            $data['datacontent']['title_lap']   = $this->jurnal_export_import->getMenuTitle($modul);
            $this->buildView($data);
        }
    }
    function rpt_utang_piutangretensi($periode=false,$divisi = FALSE){
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $modul = 'badsubkon';
        if($periode===FALSE) {
            $this->rpt_form_periode('opensystem-badsubkon');
        } else {
            $data = array();
            $data['idmenu']                     = 'rpt-opensystem-mandor';
            $data['content']                    = '../../tr_accounting/views/utang/utang_pemasok3';
            $data['js']                         = '../../tr_accounting/views/utang/utang_pemasok_js';
            $data['datacontent']['rows']        = $this->jurnal_export_import->gen_utang_rincipemasok($modul,$periode);
            //$data['datacontent']['rowsa']       = $this->jurnal_export_import->get_saldoAwal($periode);
            $data['datacontent']['nama']        = $this->session->userdata('nama'); 

            list($b,$t) = explode('-',$periode);
            $data['datacontent']['periode']     = $this->strutils->strBulan($b).' '.$t;
            $data['datacontent']['divisi']      = $this->jurnal_export_import->getNamaDivisi($divisi);
            $data['datacontent']['kawasan']     = $this->session->userdata('nama_entity');
            $data['datacontent']['title_lap']   = $this->jurnal_export_import->getMenuTitle($modul);
            $this->buildView($data);
        }
    }
    function genDT_utang_pemasok($periode) { 
        list($bln, $thn) = explode('-', $periode);
        $periode =  $thn.'-'.sprintf('%02d',$bln).'-01';

        //$kd_nas = $this->jurnal_export_import->get_hutangnol($periode);
        //echo implode("','",$kd_nas);
        $this->datatables->select('tanggal, kode_nasabah, nama_nasabah, no_terbit, no_bukti, keterangan, penerbitan, pelunasan, umur', FALSE)
            ->from('v_utang_pemasok');
            //->where("tra.tanggal < '".$periode."'")
            //->where("kode_nasabah IN('".implode("','",$kd_nas)."')");
            //->where_in('kode_nasabah',array($kd_nas));
            //->where(array('MONTH(tanggal)'=>$bln, 'YEAR(tanggal)'=>$thn));
        echo $this->datatables->generate();
    }

    function load_child($kdcoa,$periode)
    {
        //echo '::'.$kdcoa.'::'.$periode;die;
        //error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $q                  = $this->jurnal_export_import->gen_rpt_bukubesar_ext($periode,$kdcoa);

        $data['num']        = $q->num_rows(); 
        $data['query']      = $q->result();
        $data['rowu']       = $q->row();
        $data['saldo_awal'] = $this->jurnal_export_import->get_saldoAwal_childbukubesar($kdcoa,$periode);
        
        
        $this->load->view('rpt_bukubesar_child', $data);
    }
	
    function bank_form($inout='in',$id=false){
        $data['idmenu']                         = 'akuntansi-kas-bank-masuk-voucher'; 
        $data['content']                        = '../../tr_accounting/views/bank/form_bank';
        $data['js']                             = '../../tr_accounting/views/bank/form_bank_js';
        $data['datacontent']                    = '';//$this->tra->getData_BankInOut();
        $data['datacontent']['inout']           = $inout;

        $this->buildView($data);
    }
    function bank_save($data){

    }
    function bank_delete($id){

    }
    function gen_bankinout_data() { 
        $this->datatables->select('id, uraian, id_trx, kd_bank, no_rek, kd_cus, status, no_reserve, no_kuitansi, rupiah', FALSE)
            ->unset_column('id')
            ->from('tr_bank')
            ->add_column('action', '<a href="javascript:" class="row-unit" data-encunit="$1" data-unit="$2"><span class="glyphicons glyphicons-check"></span> View</a>', 
                    'id,id_trx');
        echo $this->datatables->generate();
    }

    function bank_posting($inout='in') {
        $data = array();
        $data['idmenu']             = 'akuntansi-kas-bank-masuk-posting';
        $data['content']            = '../../tr_accounting/views/bank/form_posting';
        $data['js']                 = '../../tr_accounting/views/bank/form_posting_js';

        $this->buildView($data);
    }

    function genDT_bankpost_confirm_payment() {
        $this->datatables->select('stk.no_unit,nsb.nama,stk.lantai_blok,CONCAT(stk.wide_netto, " m&sup2;"), CONCAT(stk.wide_gross, " m&sup2;"), pd.nama AS ketbayar, pay.reserve_no,pd.tgl_bayar, pd.rp_diterima, pd.no_kwitansi', FALSE)
            ->from('tr_payment_detail pd')
            ->join('tr_payment pay', 'pay.reserve_no=pd.reserve_no', 'inner')
            ->join('mst_nasabah nsb', 'nsb.kode = pay.kode_nasabah AND nsb.jenis = "CUSTOMER"', 'inner')
            ->join('mst_stock stk', 'stk.no_unit = pay.no_unit AND stk.kode_entity = "'.$this->session->userdata('kode_entity').'"')
            ->where('pay.iscancelled = 0 AND pay.status_tr <> "HOLD" AND pay.kode_entity = "'.$this->session->userdata('kode_entity').'" AND pd.tgl_bayar IS NOT NULL AND pd.no_kwitansi IS NOT NULL')
            //->group_by('pd.no_kwitansi')
            ->add_column('action', 
                    '<input type="checkbox" id="chk_post[]" name="chk_post[]" value="$1">', 'pay.no_kwitansi');
           // $this->datatables->group('pd.no_kwitansi');
        echo $this->datatables->generate();
    }
}