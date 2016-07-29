<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mst_perijinan_model extends CI_Model {
		
	public function __construct() {
		// $this->load->database();
	}

	public function get_optional($id = FALSE) {
        if($id===FALSE) {
            $this->db->select('*')
                ->from('mst_optional_dokumen')
                ->where(array('isactive'=>1))
                ->order_by('no_urut');
            $q = $this->db->get();
            return $q->result_array();
        } else {
            $this->db->select('*')
                ->from('mst_optional_dokumen')
                ->where(array('isactive'=>1, 'id'=>$id));
            $q = $this->db->get();
            return $q->row_array();
        }
	}
    
    public function get_optional_master() {
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
        $this->db->select('*')
            ->from('mst_stock')
            ->where(array('kode_entity'=>$this->session->userdata('kode_entity')))
            ->order_by('tower_cluster, lantai_blok, kavling');
        $q = $this->db->get();
        $res = $q->result_array();
        foreach($res as $k => $v) {
            $data['units'][] = array(
                'no_unit'=>$v['no_unit'],
                'tower_cluster'=>$v['tower_cluster'],
                'type_property'=>$v['type_property'],
                'lantai_blok'=>$v['lantai_blok']
            );
        }
        $this->db->select('*')
            ->from('mst_optional_dokumen')
            ->where(array('isactive'=>1))
            ->order_by('no_urut');
		$q = $this->db->get();
        $res = $q->result_array();
        foreach($res as $k => $v) {
            $data['dokumen'][] = array(
                'kode'=>$v['kode'],
                'konten'=>$v['konten']
            );
        }
        return $data;
    }
    
    public function get_master_unit($no_unit) {
        $this->db->select('*')
            ->order_by('id')
            ->from('mst_perijinan')
            ->where(array('kode_entity'=>$this->session->userdata('kode_entity'), 'no_unit'=>$no_unit));
        $q = $this->db->get();
        return $q->row_array();
    }

	public function get_unit($no_unit) {
		$this->db->select('*, IFNULL(date_format(tgl_ra,"%d/%m/%Y"),"") AS xtgl_ra, IFNULL(date_format(tgl_ri,"%d/%m/%Y"),"") AS xtgl_ri', FALSE);
		$q = $this->db->get_where('mst_perijinan', array('MD5(no_unit)'=>$no_unit, 'kode_entity'=>$this->session->userdata('kode_entity')));
		return $q->result_array();
	}
    
    public function get_some_units() {
        $units = $this->input->post('no_unit');
        $data = array();
        if(isset($units[0])) {
            $sql = "
                SELECT 
                    s.no_unit,
                    IFNULL(date_format(p.tgl_ra, '%d/%m/%Y'), '') AS tgl_ra
                FROM
                    mst_stock s
                    LEFT JOIN mst_perijinan p ON p.no_unit = s.no_unit
                        AND p.kode_entity = '".$this->session->userdata('kode_entity')."'
                WHERE 
                    s.no_unit IN ('".implode("','", $units)."')
            ";
            $q = $this->db->query($sql);
            $data = $q->result_array();
        }
        return $data;
    }
    
    public function get_nourut() {
        $this->db->select('no_urut')
            ->order_by('no_urut');
        $q = $this->db->get_where('mst_optional_dokumen', array('sfield'=>'jenis_dokumen', 'isactive'=>1));
        return $q->result_array();
    }
    
    public function get_list() {
        $data = array();
        // optional
        $this->db->select('sfield, kode, konten')
            ->from('mst_optional_stock')
            ->where('isactive = 1 AND sfield IN ("type_property", "tower_cluster", "lantai_blok") AND sflag = "'.$this->session->userdata('type_entity').'"')
            ->order_by('sfield, no_urut');
        $q = $this->db->get();
        $res = $q->result_array();
        foreach($res as $k => $v) {
            $data[$v['sfield']][] = array(
                'kode'=>$v['kode'],
                'konten'=>$v['konten']
            );
        }
        // docs
        $this->db->select('kode, konten')
            ->order_by('no_urut');
        $q = $this->db->get_where('mst_optional_dokumen', array('sfield'=>'jenis_dokumen'));
        $res = $q->result_array();
        foreach($res as $v) {
            $data['head'][] = array(
                'kode'=>$v['kode'],
                'nama'=>$v['konten']
            );
        }
        // units
        $this->db->select('no_unit, tower_cluster, lantai_blok, type_property')
            ->order_by('tower_cluster, lantai_blok, kavling');
        $q = $this->db->get_where('mst_stock', array('kode_entity'=>$this->session->userdata('kode_entity')));
        $res = $q->result_array();
        foreach($res as $v) {
            $docs = array();
            foreach($data['head'] as $v2) {
                $this->db->select('DATE_FORMAT(tgl_ra, "%d/%m/%Y") AS ra, DATE_FORMAT(tgl_ri, "%d/%m/%Y") AS ri', FALSE);
                $qx = $this->db->get_where('mst_perijinan', array(
                    'kode_entity'=>$this->session->userdata('kode_entity'),
                    'no_unit'=>$v['no_unit'],
                    'kode_dokumen'=>$v2['kode']
                ));
                if($qx->num_rows()>0) {
                    $resx = $qx->row_array();
                } else {
                    $resx = array('ra'=>'', 'ri'=>'');
                }
                $docs[] = $resx;
            }
            $data['body'][] = array(
                'no_unit'=>$v['no_unit'],
                'tower_cluster'=>$v['tower_cluster'],
                'lantai_blok'=>$v['lantai_blok'],
                'type_property'=>$v['type_property'],
                'docs'=>$docs
            );
        }
        return $data;
    }

	public function _insert($data) {
		return $this->db->insert('mst_perijinan', $data);
	}
    
    public function _insert_master() {
        $units = $this->input->post('no_unit');
        $stgl = $this->dateutils->dateStr_to_mysql($this->input->post('tgl_ra'));
        foreach($units as $k => $v) {
            $q = $this->db->get_where('mst_perijinan', array(
                'kode_entity'=>$this->session->userdata('kode_entity'),
                'no_unit'=>$v,
                'kode_dokumen'=>$this->input->post('kode_dokumen')
            ));
            if($q->num_rows()<1) {
                $qdok = $this->db->get_where('mst_optional_dokumen', array('kode'=>$this->input->post('kode_dokumen')));
                $rdok = $qdok->row_array();
                $this->db->insert('mst_perijinan', array(
                    'kode_entity'=>$this->session->userdata('kode_entity'),
                    'no_unit'=>$v,
                    'kode_dokumen'=>$this->input->post('kode_dokumen'),
                    'nama_dokumen'=>$rdok['konten'],
                    'tgl_ra'=>$stgl,
                    'nama_notaris'=>$this->input->post('nama_notaris')
                ));
            }
        }
	}
    
    public function _insert_master_2() {
        $units = $this->input->post('no_unit');
        $stgl = $this->dateutils->dateStr_to_mysql($this->input->post('tgl_ri'));
        foreach($units as $k => $v) {
            $q = $this->db->get_where('mst_perijinan', array(
                'kode_entity'=>$this->session->userdata('kode_entity'),
                'no_unit'=>$v,
                'kode_dokumen'=>$this->input->post('kode_dokumen')
            ));
            if($q->num_rows()>0) {
                $res = $q->row_array();
                $qdok = $this->db->get_where('mst_optional_dokumen', array('kode'=>$this->input->post('kode_dokumen')));
                $rdok = $qdok->row_array();
                $this->db->where(array(
                    'id'=>$res['id']
                ));
                $this->db->update('mst_perijinan', array(
                    'no_dokumen'=>$this->input->post('no_dokumen'),
                    'tgl_ri'=>$stgl,
                    'nama_notaris'=>$this->input->post('nama_notaris')
                ));
            }
        }
	}

	public function save_tanggal($target, $ids, $tgls) {
		$this->load->library('dateUtils');
		foreach ($ids as $k => $v) {
			$data = array(
				'tgl_'.$target => $this->dateutils->dateStr_to_mysql($tgls[$k])
			);
			$this->db->where(array('id'=>$v));
			$this->db->update('mst_perijinan', $data);
		}
	}
    
    public function insert_optional($data) {
        return $this->db->insert('mst_optional_dokumen', array(
            'sfield'=>'jenis_dokumen',
            'kode'=>$data['kode'],
            'konten'=>$data['konten'],
            'no_urut'=>$data['no_urut']
        ));
    }
    
    public function update_optional($data) {
        $this->db->where(array('id'=>$data['id']));
        return $this->db->update('mst_optional_dokumen', array(
            'kode'=>$data['kode'],
            'konten'=>$data['konten'],
            'no_urut'=>$data['no_urut']
        ));
    }
    
    public function delete_optional($id) {
        $this->db->where(array('id'=>$id));
        $this->db->delete('mst_optional_dokumen');
        return 1;
    }
		
}
	