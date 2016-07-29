<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mst_mandatory_coa_model extends CI_Model {

	function _construct(){
	        parent::_construct();
	    }

	function get_coa()
	{
		$this->db->select('coa.*')->from('mst_coa coa');
		$q = $this->db->get();
		$data['coa'] = $q->result_array();
		
		return $data;
	}

	function get_data()
	{
		// tahap, sbdy, nasabah, fakturpajak, kdbank
		$this->db->select(	'rc.rid, rc.kode_coa, f_cekcoa(rc.kode_coa) as coa, '.
							'rc.is_tahap, rc.is_sbdy, rc.is_nasabah, rc.is_fpajak, rc.is_bank')
				 ->from('tr_mandatory_coa rc');
		$q = $this->db->get();
		$data['t_data'] = $q->result_array();
		
		return $data;
	}

	function _insert($data) 
	{
		$dta = array(
			'kode_coa'		=>$data['kode_coa'],
			'is_tahap'		=>$data['tahap'],
			'is_sbdy'		=>$data['sbdy'],
			'is_nasabah'	=>$data['nasabah'],
			'is_fpajak'		=>$data['pajak'],
			'is_bank'		=>$data['bank']
		);
		$t_mandatory = array(
			'mand_tahap' =>$data['tahap'],
			'mand_sbd' =>$data['sbdy'],
			'mand_nasabah' =>$data['nasabah'],
			'mand_pajak' =>$data['pajak'],
			'mand_bank' =>$data['bank']
			);

		$this->db->where(array('kode'=>$data['kode_coa']));
		$res = $this->db->update('mst_coa',$t_mandatory);
		if($res) {
			$out = array(
				'response'		=>'1',
				'error_num'		=>'0',
				'msg'			=>'Success'
			);
			$this->db->insert('tr_mandatory_coa',$dta);
		} else {
			$out = array(
				'response'		=>'0',
				'error_num'		=>$this->db->_error_number(),
				'msg'			=>$this->db->_error_message()
			);
		}
		return $out;
	}

	function _update($data, $id) {
		// tahap, sbdy, nasabah, fakturpajak, kdbank
		$dta = array(
			'kode_coa'		=>$data['kode_coa'],
			'is_tahap'		=>$data['tahap'],
			'is_sbdy'		=>$data['sbdy'],
			'is_nasabah'	=>$data['nasabah'],
			'is_fpajak'		=>$data['pajak'],
			'is_bank'		=>$data['bank']
		);
		
		
		$t_mandatory = array(
			'mand_tahap' 	=>$data['tahap'],
			'mand_sbd' 		=>$data['sbdy'],
			'mand_nasabah' 	=>$data['nasabah'],
			'mand_pajak' 	=>$data['pajak'],
			'mand_bank' 	=>$data['bank']
			);

		$this->db->where(array('kode'=>$data['kode_coa']));
		$res = $this->db->update('mst_coa',$t_mandatory);
		if($res) {
			$out = array(
				'response'		=>'1',
				'error_num'		=>'0',
				'msg'			=>'Success'
			);
			$this->db->where(array('rid'=>$id));
			$this->db->update('tr_mandatory_coa',$dta);
		} else {
			$out = array(
				'response'		=>'0',
				'error_num'		=>$this->db->_error_number(),
				'msg'			=>$this->db->_error_message()
			);
		}
		return $out;
	}

	function _delete($id)
	{
		$this->db->where(array('id'=>$id));
		return $this->db->delete('tr_mandatory_coa');
	}

}

?>