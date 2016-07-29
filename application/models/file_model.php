<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Description of file_model
 *
 * @author Admin
 */
class file_model extends CI_Model {
    //table name
    private $file = 'files';   // files
    function __construct() {
    }
    function save_file_info($file) {
        //start db traction
        $this->db->trans_start();
        //file data
        $file_data = array(
            'file_name' => $file['file_name'],
            'file_orig_name' => $file['orig_name'],
            'file_path' => $file['full_path'],
            'upload_date' => date('Y-m-d H:i:s')
        );
        //insert file data
        $this->db->insert($this->file, $file_data);
        //complete the transaction
        $this->db->trans_complete();
        //check transaction status
        if ($this->db->trans_status() === FALSE) {
            $file_path = $file['full_path'];
            //delete the file from destination
            if (file_exists($file_path)) {
                unlink($file_path);
            }
            //rollback transaction
            $this->db->trans_rollback();
            return FALSE;
        } else {
            //commit the transaction
            $this->db->trans_commit();
            return TRUE;
        }
    }
}
/* End of file file_model.php */
/* Location: ./models/file_model.php */