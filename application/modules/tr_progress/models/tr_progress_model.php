<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tr_progress_model extends CI_Model {
		
	public function __construct() {
		// $this->load->database();
	}

//	public function get($id = FALSE) {
//		if($id===FALSE) {
//			$q = $this->db->get('mst_diskon');
//			return $q->result_array();
//		} else {
//			$q = $this->db->get_where('mst_diskon', array('id'=>$id));
//			return $q->row_array();
//		}
//	}
    
    public function get_optional() {
        $this->db->select('sfield, kode, konten')
            ->from('mst_optional_stock')
            ->where('isactive = 1 AND sfield IN ("type_property", "tower_cluster", "lantai_blok") AND sflag = "'.$this->session->userdata('type_entity').'"')
            ->order_by('sfield, no_urut');
        $q = $this->db->get();
        $res = $q->result_array();
        $data = array();
        foreach($res as $k => $v) {
            $data[$v['sfield']][] = array(
                'kode'=>$v['kode'],
                'konten'=>$v['konten']
            );
        }
        $q = $this->db->get_where('mst_stock', array('kode_entity'=>$this->session->userdata('kode_entity')));
        $res = $q->result_array();
        foreach($res as $k => $v) {
            $data['units'][] = array(
                'no_unit'=>$v['no_unit'],
                'tower_cluster'=>$v['tower_cluster'],
                'type_property'=>$v['type_property'],
                'lantai_blok'=>$v['lantai_blok']
            );
        }
        return $data;
    }
    
    public function get_progress_unit($no_unit) {
        $this->db->select('persen_progress')
            ->from('tr_progress')
            ->where(array('kode_entity'=>$this->session->userdata('kode_entity'), 'no_unit'=>$no_unit))
            ->order_by('tgl_progress DESC');
        $q = $this->db->get();
        return $q->num_rows()>0 ? $q->row_array() : array('persen_progress'=>0);
    }

	public function _insert($data) {
		$this->db->insert('tr_progress', $data);
	}

	public function _update($data, $id) {
		$this->db->where(array('id'=>$id));
		return $this->db->update('tr_progress', $data);
	}

//	public function _delete($id) {
//		$this->db->where(array('id'=>$id));
//		return $this->db->delete('mst_diskon');
//	}
		
}
	