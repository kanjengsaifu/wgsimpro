<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mst_rik_model extends CI_Model {

	public function get_optional($kode_entity){
		$this->db->select('kode, konten')
				 ->from('mst_optional_rik')
				 ->where(array('sflag'=>'rencana_biaya'));
		$q = $this->db->get();
		$data['list_rencana_biaya'] = $q->result_array();
		return $data;
	}

	public function get_rik($kode_entity) {
		$this->db->select('rb.*, op.konten')
			->from('tr_rik_detail_rencana_biaya rb')
			->join('mst_optional_rik op', 'op.kode = rb.kode_biaya AND op.sflag = rb.sflag', 'inner')
			->where(array('rb.kode_entity'=>$this->session->userdata('kode_entity')));
		$q = $this->db->get();
		$data['ra_biayas'] = $q->result_array();
		return $data;
	}

	public function save($data) {
		// ra. biaya
		$this->db->where(array('kode_entity'=>$this->session->userdata('kode_entity')));
		$this->db->delete('tr_rik_detail_rencana_biaya');
		foreach ($data['kode_biaya'] as $k => $v) {
			$ra_biaya = array(
				'kode_entity'=>$this->session->userdata('kode_entity'),
				'sflag'=>'rencana_biaya',
				'kode_biaya'=>$v,
				'volume'=>str_replace(',', '', $data['volume_rb'][$k]),
				'satuan'=>$data['satuan_rb'][$k],
				'bobot'=>str_replace(',', '', $data['bobot_rb'][$k]),
				'biaya'=>str_replace(',', '', $data['biaya_rb'][$k])
			);
			$this->db->insert('tr_rik_detail_rencana_biaya', $ra_biaya);
		}
	}

}