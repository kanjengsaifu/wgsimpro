<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mst_settingos_model extends CI_Model {

	function _construct(){
	        parent::_construct();
	    }

	public function get_coa()
	{
		$this->db->select('coa.*')
				 ->from('mst_coa coa');
		$q = $this->db->get();
		$data['coa'] = $q->result_array();
		
		return $data;
	}

	public function get_data($id=false)
	{
		if($id==false)
			$id = -1;
		
		$sql =  'SELECT os.id, os.jenis, os.kode_coa, f_cekcoa(os.kode_coa) as coa, os.penerbitan, os.pelunasan '.
			    'FROM mst_setting_os os  WHERE os.id='.$id;

		$q = $this->db->query($sql);
		return $q->row_array();
	}

	function _insert($data) 
	{
		$dta = array(
			'jenis'			=>strtoupper($data['jenis']),
			'kode_coa'		=>$data['kode_coa'],
			'penerbitan'	=>isset($data['penerbitan'])?$data['penerbitan']:NULL,
			'pelunasan'		=>isset($data['pelunasan'])?$data['pelunasan']:NULL
		);
		$this->db->insert('mst_setting_os',$dta);
	}

	function _update($data, $id) {
		// po
		$dta = array(
			'jenis'			=>strtoupper($data['jenis']),
			'kode_coa'		=>$data['kode_coa'],
			'penerbitan'	=>isset($data['penerbitan'])?$data['penerbitan']:NULL,
			'pelunasan'		=>isset($data['pelunasan'])?$data['pelunasan']:NULL
		);

		$this->db->where(array('id'=>$id));
		$this->db->update('mst_setting_os',$dta);
	}

	function _delete($id)
	{
		$this->db->where(array('id'=>$id));
		return $this->db->delete('mst_setting_os');
	}

}

?>