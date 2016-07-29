<?php  
class Import extends CI_Controller {
    
    //variable for storing error message
    private $error;
    //variable for storing success message
    private $success;

    function __construct()  {
        parent::__construct();
            $this->load->library(array('PHPExcel','PHPExcel'));
            $this->load->helper('tglbil');
            $this->load->model('import_model');
    }

    //appends all error messages
    private function handle_error($err) {
        $this->error .= $err . "\r\n";
    }
    //appends all success messages
    private function handle_success($succ) {
        $this->success .= $succ . "\r\n";
    }

    function index(){
        if ($this->input->post('save')) {
            $fileName = $_FILES['import']['name'];

            $config['upload_path'] = './files/';
            $config['file_name'] = $fileName;
            $config['allowed_types'] = 'xls|xlsx';
            $config['max_size']     = 10000;

            $this->load->library('upload');
            $this->upload->initialize($config);

            if(! $this->upload->do_upload('import') )
                $this->upload->display_errors();

            $media = $this->upload->data('import');
            $inputFileName = './files/'.$media['file_name'];

            //  Read your Excel workbook
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch(Exception $e) {
                die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
            }

            //  Get worksheet dimensions
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();

            //  Loop through each row of the worksheet in turn
            for ($row = 4; $row <= $highestRow; $row++){                //  Read a row of data into an array                
                        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                                NULL,
                                                TRUE,
                                                FALSE);
                 

                $tglExcel = date('Y-m-d',PHPExcel_Shared_Date::ExcelToPHP($rowData[0][1])); 
                $tgl_sys = str_replace('--', '', tgl_tosystem($tglExcel));
                $data = array(
                            "uid"               => 'chairul',
                            "kode_divisi"       => $rowData[0][0],
                            "tanggal"           => ($tgl_sys==''?'0000-00-00':$tgl_sys),
                            "no_bukti"          => $rowData[0][2],
                            "no_terbit"         => $rowData[0][3],
                            "kode_coa"          => $rowData[0][4],
                            "kode_nasabah"      => $rowData[0][5],
                            "kode_sumberdaya"   => $rowData[0][6],
                            "kode_spk"          => $rowData[0][7],
                            "kode_tahap"        => $rowData[0][8],
                            "no_invoice"        => $rowData[0][9],
                            "kode_faktur"       => $rowData[0][10],
                            "bukti_potong"      => $rowData[0][11],
                            "volume"            => $rowData[0][12],
                            "uraian"            => $rowData[0][13],
                            "dk"                => $rowData[0][14],
                            "rupiah"            => $rowData[0][15]
                        );
                    //echo "TANGGAL KU: ".is_null($rowData[0][1])."<br><br>";
                try {
                    //$this->db->insert("tr_accounting_ledger_temp",$data);
                    //var_dump($data);
                }catch (Exception $e){
                    die('Error : '.$e->getMessage());
                }
                
            }
                        echo "Import Success";
        }
        //var_dump($this->impexcel());
        $this->load->view('import_view');
    }

    public function xcl_upload() {
        //check whether submit button was clicked or not
        if ($this->input->post('save')) {
            //set preferences
            
            //file upload destination
            $config['upload_path'] = './upload/';
            //allowed file types. * means all types
            $config['allowed_types'] = 'xls|xlsx';
            //allowed max file size. 0 means unlimited file size
            $config['max_size'] = '0';
            //max file name size
            $config['max_filename'] = '255';
            //whether file name should be encrypted or not
            $config['encrypt_name'] = TRUE;
            //store file info once uploaded
            $file = array();
            //check for errors
            $is_file_error = FALSE;
            //check if file was selected for upload
            if (!$_FILES) {
                $is_file_error = TRUE;
                $this->handle_error('Select at least one file.');
            }
            //if file was selected then proceed to upload
            if (!$is_file_error) {
                //load the preferences
                $this->load->library('upload', $config);
                //check file successfully uploaded. 'file_name' is the name of the input
                if (!$this->upload->do_upload('file_name')) {
                    //if file upload failed then catch the errors
                    $this->handle_error($this->upload->display_errors());
                    $is_file_error = TRUE;
                } else {
                    //store the file info
                    $file = $this->upload->data();
                }
            }
            // There were errors, we have to delete the uploaded files
            if ($is_file_error) {
                if ($file) {
                    $file = './upload/' . $file['file_name'];
                    if (file_exists($file)) {
                        //unlink($file);
                    }
                }
            }
            if (!$is_file_error) {
                //save the file info in the database
                $resp = $this->file->save_file_info($file);
                if ($resp === TRUE) {
                    $this->handle_success('File was successfully uploaded.');
                } else {
                    //if file info save in database was not successful then delete from the destination folder
                    $file = './upload/' . $file['file_name'];
                    if (file_exists($file)) {
                        unlink($file);
                    }
                    $this->handle_error('Error while saving file info to Database.');
                }
            }
        }
        
        //load the error and success messages
        $data['errors'] = $this->error;
        $data['success'] = $this->success;
        //load the view along with data
        $this->load->view('file_upload', $data);
    }

    public function readCell($column, $row, $worksheetName = '') {
          // Read columns from 'A' to 'AF'
          if (in_array($column, $this->columns)) {
              return true;
          }
          return false;
    }

    function impexcel()
    {
        $inputFileName = './files/'.'_tmpl_ledger1a.xls';

        try {
            $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFileName);
        } catch (Exception $e) {
            die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) 
            . '": ' . $e->getMessage());
        }

        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        $data['sheet'] =  $objPHPExcel->getSheet(0);
        $data['highestRow'] = $sheet->getHighestRow();
        $data['highestColumn'] = $sheet->getHighestColumn();

        $this->load->view('import_view',$data);
        //  Loop through each row of the worksheet in turn
        /*
        for ($row = 4; $row <= $highestRow; $row++) {

            //  Read a row of data into an array
            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, 
            NULL, TRUE, FALSE);

            $tglExcel = date('Y-m-d',PHPExcel_Shared_Date::ExcelToPHP($rowData[0][1])); 
            $tgl_sys = str_replace('--', '', tgl_tosystem($tglExcel));

            foreach($rowData[0] as $k=>$v)
                //echo "Row: ".$row."- Col: ".($k+1)." = ".$v."<br />";
                $data = array(
                        "uid"               => 'chairul',
                        "kode_divisi"       => $rowData[0][0],
                        "tanggal"           => ($rowData[0][1]==NULL?NULL:$tgl_sys),
                        "no_bukti"          => $rowData[0][2],
                        "no_terbit"         => $rowData[0][3],
                        "kode_coa"          => $rowData[0][4],
                        "kode_nasabah"      => $rowData[0][5],
                        "kode_sumberdaya"   => $rowData[0][6],
                        "kode_spk"          => $rowData[0][7],
                        "kode_tahap"        => $rowData[0][8],
                        "no_invoice"        => $rowData[0][9],
                        "kode_faktur"       => $rowData[0][10],
                        "bukti_potong"      => $rowData[0][11],
                        "volume"            => $rowData[0][12],
                        "uraian"            => $rowData[0][13],
                        "dk"                => $rowData[0][14],
                        "rupiah"            => $rowData[0][15]
                );

            try 
            {
                //$this->db->insert("tr_accounting_upload",$data);
                //var_dump($data);
              $data['batch'] = $data;
            }catch(Exception $e){
                die('Error : '.$e->getMessage());
            }
        }*/

    }

    function f_cekmandatory($mand_field_name,$kode_coa)
    {
        echo import_model::cek_mandatory($mand_field_name,$kode_coa);
    }
}