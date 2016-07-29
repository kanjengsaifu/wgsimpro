<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class T_user_model extends CI_Model {
	
	public function get($id = FALSE, $filter = FALSE) {
		if($id==FALSE) {
			$this->db->select('*')
                ->from('t_user')
                ->order_by('nama');
			$q = $this->db->get();
			return $q->result_array();
		} else {
			$this->db->select('*')
					 ->from('t_user')
					 ->where(array('id'=>$id));
			$q = $this->db->get();
			return $q->row_array();
		}
	}
    
    public function get_group() {
        $this->db->select('*')
            ->from('t_user_group')
            ->where('id > 1')
            ->order_by('nama');
        $q = $this->db->get();
        return $q->result_array();
    }
    
    public function get_entity($id = FALSE) {
        if($id!==FALSE) {
            $this->db->select('e.kode, e.nama, IFNULL(g.id, 0) AS selected', FALSE)
                ->from('mst_entity e')
                ->join('t_user_entity g', 'g.kode_entity = e.kode AND g.user_id = '.$id, 'left');
        } else {
            $this->db->select('e.kode, e.nama, "0" AS selected', FALSE)
                ->from('mst_entity e');
        }
        $q = $this->db->get();
        return $q->result_array();
    }
	
	public function _insert() {
        $this->db->insert('t_user',array(
            'username'=>$this->input->post('username'),
            'password'=>$this->input->post('passwd'),
            'nama'=>$this->input->post('nama'),
            'user_group'=>$this->input->post('user_group'),
        ));
        $id = $this->db->insert_id();
        // user entity
        $ent = $this->input->post('kode_entity');
        foreach($ent as $k => $v) {
            $this->db->insert('t_user_entity', array('user_id'=>$id, 'kode_entity'=>$v));
        }
	}
	
	public function _update() {
        $id = $this->input->post('id');
        $this->db->where(array('id'=>$id));
        $this->db->update('t_user', array(
            'username'=>$this->input->post('username'),
            'nama'=>$this->input->post('nama'),
            'user_group'=>$this->input->post('user_group'),
			'password'=>$this->input->post('passwd'),
        ));
        // user entity
        $this->db->where(array('user_id'=>$id));
        $this->db->delete('t_user_entity');
        $ent = $this->input->post('kode_entity');
        foreach($ent as $k => $v) {
            $this->db->where(array('user_id'=>$id));
            $this->db->insert('t_user_entity', array('user_id'=>$id, 'kode_entity'=>$v));
        }
	}
	
	public function _delete($id) {
		$this->db->where(array('id'=>$id));
		$this->db->delete('t_user');
	}
		
}
	