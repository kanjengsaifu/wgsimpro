<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class import_model extends CI_Model {
			
		public function __construct() {
			 $this->load->database();
		}
		function cek_mandatory($fl_mandName,$kode_coa)
		{
			$this->db->select($fl_mandName);
			$this->db->where(array('kode' => $kode_coa));
			$query = $this->db->get('mst_coa');
			return $query->result();
		}
	}

?>