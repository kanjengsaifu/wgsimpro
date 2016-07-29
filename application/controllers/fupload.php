<?php  
class fUpload extends CI_Controller {
    
    //variable for storing error message
    private $error;
    //variable for storing success message
    private $success;

    function __construct()  {
        parent::__construct();
            //$this->load->library(array('PHPExcel','PHPExcel'));
            //$this->load->helper('tglbil');
            $this->load->model('file_model','file');
    }

    //appends all error messages
    private function handle_error($err) {
        $this->error .= $err . "\r\n";
    }
    //appends all success messages
    private function handle_success($succ) {
        $this->success .= $succ . "\r\n";
    }

    public function index() {
        //check whether submit button was clicked or not
        if ($this->input->post('file_upload')) {
            //set preferences
            
            //file upload destination
            $config['upload_path'] = './upload/';
            //allowed file types. * means all types
            $config['allowed_types'] = '*';
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
                        unlink($file);
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
}
?>