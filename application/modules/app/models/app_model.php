<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class App_model extends CI_Model {
	
	public function gen_judul() {
		$this->db->select('kode, judul_halaman');
		$q = $this->db->get_where('mst_menu', array('is_active'=>1, 'is_header'=>0));
		$res = $q->result_array();
		$data = array();
		foreach ($res as $k => $v) {
			$data[$v['kode']] = $v['judul_halaman'];
		}
		return $data;
	}

	public function gen_sidemenu() {
        if($this->session->userdata('usernm')==='admin') {
            $this->db->order_by('no_urut');
            $q = $this->db->get_where('mst_menu', array('is_active'=>1, 'as_sidemenu'=>1));
        } else {
            $username = $this->session->userdata('usernm');
            $sql = "
                SELECT
                    DISTINCT m.*
                FROM (
                    SELECT
                        m.*
                    FROM
                        mst_menu AS m
                        INNER JOIN t_group_akses ga ON ga.menu = m.kode
                        INNER JOIN t_user u ON u.user_group = ga.user_group
                    WHERE
                        u.username = '$username'
                    UNION ALL
                    SELECT
                        m.*
                    FROM
                        mst_menu AS m
                    WHERE
                        m.kode IN (
                            SELECT
                                m.parent
                            FROM
                                mst_menu AS m
                                INNER JOIN t_group_akses ga ON ga.menu = m.kode
                                INNER JOIN t_user u ON u.user_group = ga.user_group
                            WHERE
                                u.username = '$username'
                        )
                    UNION ALL
                    SELECT
                        m.*
                    FROM
                        mst_menu AS m
                    WHERE
                        m.kode IN (
                            SELECT
                                m.parent
                            FROM
                                mst_menu AS m
                            WHERE
                                m.kode IN (
                                    SELECT
                                        m.parent
                                    FROM
                                        mst_menu AS m
                                        INNER JOIN t_group_akses ga ON ga.menu = m.kode
                                        INNER JOIN t_user u ON u.user_group = ga.user_group
                                    WHERE
                                        u.username = '$username'
                                )
                        )
                    ) AS m
                ORDER BY
                    m.no_urut
            ";
            $q = $this->db->query($sql);
        }
		$res = $q->result_array();
		$data = $this->build_menu_tree($res);
		return $data;
	}

	private function build_menu_tree($data, $parent = null) {
		$op = array();
		foreach ($data as $k => $v) {
			if($v['parent']===$parent) {
				$op[$v['kode']] = array(
					'judul_menu'=>$v['judul_menu'],
					'url'=>$v['url'],
					'icon'=>$v['icon'],
					'is_header'=>$v['is_header'],
					'parent'=>$v['parent']
				);
				// recursion
				$children = $this->build_menu_tree($data, $v['kode']);
				if($children) {
					$op[$v['kode']]['children'] = $children;
				}
			}
		}
		return $op;
	}
		
}
	