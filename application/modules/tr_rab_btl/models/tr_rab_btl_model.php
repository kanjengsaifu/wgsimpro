<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class tr_rab_btl_model extends CI_Model {
	
	public function get($id = FALSE, $filter = FALSE) {
		if($id==FALSE) {
			$this->db->select('btl.*')
					 ->from('tr_rab_btl btl');
			$q = $this->db->get();
			return $q->result_array();
		} else {
			$this->db->select('btl.*')
					 ->from('tr_rab_btl btl')
					 ->where(array('btl.id'=>$id));
			$q = $this->db->get();
			return $q->row_array();
		}
	}
	
	
	public function get_sumberdaya() {
		$this->db->select('*')
				 ->from('mst_sumberdaya');
		$q = $this->db->get();
		return $q->result_array();
	}	
	
	public function get_coa() {
		$this->db->select('*')
				 ->from('mst_coa');
		$q = $this->db->get();
		return $q->result_array();
	}	
	
	public function _insert($data) {
		return $this->db->insert('tr_rab_btl',$data);
	}
	
	public function _update($data, $id) {
		$this->db->where(array('id'=>$id));
		return $this->db->update('tr_rab_btl',$data);
	}
	
	public function _delete($id) {
		$this->db->where(array('id'=>$id));
		return $this->db->delete('tr_rab_btl');
	}
		
		
	public function cek_data($kode) {
		$this->db->from('mst_sumberdaya');
		$this->db->where(array('kode'=>$kode));
		$result = $this->db->get();
		$num=$result->num_rows();
		return $num; 
	}
		
	public function cek_coa($kode) {
		$this->db->from('mst_coa');
		$this->db->where(array('kode'=>$kode));
		$result = $this->db->get();
		$num=$result->num_rows();
		return $num;
		/*
		$this->db->where(array('id'=>$id));
		return $this->db->delete('mst_harga_sumberdaya');*/
	}

	public function loaddata($dataarray) {
		
		foreach($dataarray as $data){ 
			 $dataa = array(
                'kode_entity' => $data['kode_entity'],
                'kode_coa' => $data['kode_coa'],
                'kode_sumberdaya' => $data['kode_sumberdaya'],
                'harga' => $data['harga'],
                'harga_rev' => $data['harga_rev'],
                'rolling' => $data['rolling']
            );
          
				$this->db->insert('tr_rab_btl',$dataa);
			
		} 
	}
}
	