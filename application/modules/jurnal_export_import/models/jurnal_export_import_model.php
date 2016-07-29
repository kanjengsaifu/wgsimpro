<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jurnal_export_import_model extends CI_Model {
	
    function __construct() {
        $this->traccTable = 'tr_accounting';
    }
	public function _insertexport($data) {
		return $this->db->insert('export_proyek',$data);
	}  
	public function insertimport($data) {
		return $this->db->insert('import_simproyek',$data);
	}  
	public function insertstatus($data) {
		return $this->db->insert('transfer_simproyek',$data);
	}  
	public function getExport($id = FALSE) { 
			
			$q = $this->db->get_where('export_proyek', array('kode_entity'=>$id));
			return $q->result_array(); 
	}
	public function getTransfer($id = FALSE) { 
			
			$q = $this->db->get_where('transfer_simproyek', array('kode_entity'=>$id));
			return $q->result_array(); 
	}
	function insert_csv($data) {
        $this->db->insert('tr_accounting', $data);
    }
	
}