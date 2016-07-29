<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class T_user_group_model extends CI_Model {
	
	public function get($id = FALSE, $filter = FALSE) {
		if($id==FALSE) {
			$this->db->select('*')
                ->from('t_user_group')
                ->order_by('nama');
			$q = $this->db->get();
			return $q->result_array();
		} else {
			$this->db->select('*')
					 ->from('t_user_group')
					 ->where(array('id'=>$id));
			$q = $this->db->get();
			return $q->row_array();
		}
	}
    
    public function get_entity($id = FALSE) {
        if($id!==FALSE) {
            $this->db->select('e.kode, e.nama, IFNULL(g.id, 0) AS selected', FALSE)
                ->from('mst_entity e')
                ->join('t_group_entity g', 'g.kode_entity = e.kode AND g.user_group = '.$id, 'left');
        } else {
            $this->db->select('e.kode, e.nama, "0" AS selected', FALSE)
                ->from('mst_entity e');
        }
        $q = $this->db->get();
        return array('entity'=>$q->result_array());
    }
    
    public function gen_menu($group = FALSE) {
        if($group===FALSE) {
            $this->db->select('m.*, 0 AS selected, "" AS akses', FALSE)
                ->from('mst_menu m')
                ->where(array('is_active'=>1, 'as_sidemenu'=>1))
                ->order_by('parent, no_urut');
            $q = $this->db->get();
        } else {
            $this->db->select('m.*, IFNULL(a.id, 0) AS selected, IFNULL(a.akses, "") AS akses', FALSE)
                ->from('mst_menu m')
                ->join('t_group_akses a', 'a.menu = m.kode AND a.user_group = '.$group, 'left')
                ->where(array('m.is_active'=>1, 'm.as_sidemenu'=>1))
                ->order_by('parent, no_urut');
            $q = $this->db->get();
        }
        return array(
            array(
                'id'=>'root',
                'text'=>'<b>SIMPRO Wika Gedung</b>',
                'icon'=>'imoon imoon-folder',
                'state'=>array('opened'=>true, 'enabled'=>false),
                'children'=>$this->build_menu_tree($q->result_array())
            )
        );
    }
    
    private function build_menu_tree($data, $parent = null) {
		$op = array();
		foreach ($data as $k => $v) {
			if($v['parent']===$parent) {
                
                $item = array(
                    'id'=>$v['kode'],
					'text'=>$v['judul_menu'],
                    'state'=>array(
                        'opened'=>true,
                        'enabled'=>true
                    )
                );
                if($v['selected']!=='0') {
                    $item['state']['selected'] = true;
                }
                $children = $this->build_menu_tree($data, $v['kode']);
                if($children) {
                    $item['icon'] = 'imoon imoon-folder';
                    $item['children'] = $children;
                    $item['li_attr']['data-access'] = 0;
                    $item['li_attr']['style'] = 'color: #4a89dc !important;font-weight: bold';
				} else {
                    $item['icon'] = 'imoon imoon-file'; 
                    $item['li_attr']['data-access'] = $v['akses'];
//                    $item['li_attr']['data-id'] = $v['id'];
                    $item['li_attr']['style'] = 'color: #008fda !important;font-weight: bold';
                }
                $op[] = $item;
			}
		}
        return $op;
	}
	
	public function _insert() {
//        $entities = $this->input->post('kode_entity');
        $menus = $this->input->post('menu');
        $akses = $this->input->post('rdAkses');
        $this->db->insert('t_user_group',array('nama'=>$this->input->post('nama')));
        $group = $this->db->insert_id();
//        foreach($entities as $k => $v) {
//            $this->db->insert('t_group_entity',array(
//                'user_group'=>$group,
//                'kode_entity'=>$v
//            ));
//        }
        foreach($menus as $k => $v) {
            $this->db->insert('t_group_akses',array(
                'user_group'=>$group,
                'menu'=>$v,
                'akses'=>isset($akses[$v]) ? $akses[$v] : 'view'
            ));
        }
	}
	
	public function _update() {
//		$entities = $this->input->post('kode_entity');
        $menus = $this->input->post('menu');
        $group = $this->input->post('id');
        $akses = $this->input->post('rdAkses');
//        print_r($akses);
        $this->db->where(array('id'=>$group));
        $this->db->update('t_user_group', array('nama'=>$this->input->post('nama')));
        // group entity
//        $this->db->where(array('user_group'=>$group));
//        $this->db->delete('t_group_entity');
//        foreach($entities as $k => $v) {
//            $this->db->insert('t_group_entity',array(
//                'user_group'=>$group,
//                'kode_entity'=>$v
//            ));
//        }
        // group akses
        $this->db->where(array('user_group'=>$group));
        $this->db->delete('t_group_akses');
        foreach($menus as $k => $v) {
            $this->db->insert('t_group_akses',array(
                'user_group'=>$group,
                'menu'=>$v,
                'akses'=>isset($akses[$v]) ? $akses[$v] : 'view'
            ));
        }
	}
	
	public function _delete($id) {
		$this->db->where(array('id'=>$id));
		$this->db->delete('t_user_group');
        $this->db->where(array('user_group'=>$id));
        $this->db->delete('t_group_entity');
        $this->db->where(array('user_group'=>$id));
        $this->db->delete('t_group_akses');
	}
		
}
	