<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mst_entity_model extends CI_Model {
	
	public function get($id = FALSE, $filter = FALSE) {
		if($id==FALSE) {
			$this->db->select('e.*')
				->select("date_format(e.tgl_mulai,'%d/%m/%Y') as xtgl_mulai",FALSE)
				->select("date_format(e.tgl_selesai,'%d/%m/%Y') as xtgl_selesai",FALSE)
				->select("format(e.nilai_developer,2) as nilai_developer",FALSE)
				->select('ejenis.konten AS xjenis, etype.konten AS xtype_entity')
				->from('mst_entity e')
				->join('mst_optional_entity ejenis','ejenis.kode=e.jenis')
				->join('mst_optional_entity etype','etype.kode=e.type_entity');
			$q = $this->db->get();
			return $q->result_array();
		} else {
			$this->db->select('e.*')
				->select("date_format(e.tgl_mulai,'%d/%m/%Y') as xtgl_mulai",FALSE)
				->select("date_format(e.tgl_selesai,'%d/%m/%Y') as xtgl_selesai",FALSE)
				->select("format(e.nilai_developer,2) as nilai_developer",FALSE)
				->select('ejenis.konten AS xjenis, etype.konten AS xtype_entity')
				->from('mst_entity e')
				->join('mst_optional_entity ejenis','ejenis.kode=e.jenis')
				->join('mst_optional_entity etype','etype.kode=e.type_entity')
				->where(array('e.id'=>$id));
			$q = $this->db->get();
			return $q->row_array();
		}
	}

	public function get_optional($kode = FALSE) {
		$where = $kode===FALSE ? array('isactive'=>1) : array('isactive'=>1, 'kode'=>$kode);
		$this->db->select('*')
			->from('mst_optional_entity')
			->where($where)
			->order_by('sfield, no_urut');
		$q = $this->db->get();
		if($kode===FALSE) {
			$res = $q->result_array();
			$data = array();
			$iLoop = 0;
			foreach ($res as $k => $v) {
				$data[$v['sfield']][$iLoop]['kode'] = $v['kode'];
				$data[$v['sfield']][$iLoop]['konten'] = $v['konten'];
				$iLoop++;
			}
			return $data;
		} else {
			return $q->row_array();
		}
	}
    
    public function get_user_entity() {
        $this->db->select('e.*')
            ->select("date_format(e.tgl_mulai,'%d/%m/%Y') as xtgl_mulai",FALSE)
            ->select("date_format(e.tgl_selesai,'%d/%m/%Y') as xtgl_selesai",FALSE)
            ->select("format(e.nilai_developer,2) as nilai_developer",FALSE)
            ->select('ejenis.konten AS xjenis, etype.konten AS xtype_entity')
            ->from('mst_entity e')
            ->join('mst_optional_entity ejenis','ejenis.kode=e.jenis')
            ->join('mst_optional_entity etype','etype.kode=e.type_entity');
        if($this->session->userdata('usernm')!=='admin')
            $this->db->where_in('e.kode', explode(',', $this->session->userdata('user_entity')));
        $q = $this->db->get();
        return $q->result_array();
    }
	
	public function _insert($data) {
		return $this->db->insert('mst_entity',$data);
	}
	
	public function _update($data, $id) {
		$this->db->where(array('id'=>$id));
		return $this->db->update('mst_entity',$data);
	}
	
	public function _delete($id) {
		$this->db->where(array('id'=>$id));
		return $this->db->delete('mst_entity');
	}
		
}
	