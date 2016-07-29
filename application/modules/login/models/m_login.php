<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_login extends CI_Model {

	public function chkLogin($us = FALSE, $pw = FALSE) {
		if($us!==FALSE and $pw!==FALSE) {
			$x = 0;
			$q = $this->db->get_where('t_user',array('username'=>$us, 'password'=>$pw));
			$res = $q->row_array();
			$x = $q->num_rows();
			if($x>0) {
                // user akses
                $this->db->select('ga.menu, ga.akses')
                    ->from('t_user u')
                    ->join('t_group_akses ga', 'ga.user_group = u.user_group', 'inner')
                    ->where(array('u.username'=>$us));
                $qMenu = $this->db->get();
                $resMenu = $qMenu->result_array();
                $strMenu = $strAkses = '';
                foreach($resMenu as $k => $v) {
                    $strMenu .= ','.$v['menu'];
                    $strAkses .= ','.$v['akses'];
                }
                // user entity
                $this->db->select('e.id, ue.kode_entity, e.type_entity, e.nama')
                    ->from('t_user u')
                    ->join('t_user_entity ue', 'ue.user_id = u.id', 'inner')
                    ->join('mst_entity e', 'e.kode = ue.kode_entity', 'inner')
                    ->where(array('u.username'=>$us));
                $qEnt = $this->db->get();
                $resEnt = $qEnt->result_array();
                $strEnt = '';
                $sessEnt = array();
                foreach($resEnt as $v) {
                    $strEnt .= ','.$v['kode_entity'];
                    if(!isset($sessEnt['id_entity'])) {
                        $sessEnt = array(
                            'id_entity'=>$v['id'],
                            'kode_entity'=>$v['kode_entity'],
                            'type_entity'=>$v['type_entity'],
                            'nama_entity'=>$v['nama_entity']
                        );
                    }
                }
                // set session
				$sess = array(
					'usernm' => $res['username'],
					'nama' => $res['nama'],
					'isloggedin' => TRUE,
                    'menu' => substr($strMenu, 1),
                    'akses' => substr($strAkses, 1),
                    'user_entity' => substr($strEnt, 1)
				);
				$this->session->set_userdata($sess);
                $this->session->set_userdata($sessEnt);
			}
			return $x;
		}
	}	
	
}
	