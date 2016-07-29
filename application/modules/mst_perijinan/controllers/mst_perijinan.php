<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPCLASS;

class Mst_perijinan extends App {
	
	public function __construct() {

		parent::__construct();
		$this->load->model('mst_perijinan_model');
		$this->load->library('datatables');
		$this->load->library('dateUtils');
	}

	public function index() {
		$data['idmenu'] = 'perijinan-form';
		$data['content'] = '../../mst_perijinan/views/form';
		$data['datacontent'] = $this->mst_perijinan_model->get_optional();
		$data['js'] = '../../mst_perijinan/views/form_js';
		$this->buildView($data);
	}
    
    public function table_optional() {
        $data['idmenu'] = 'perijinan-optional';
		$data['content'] = '../../mst_perijinan/views/table_optional';
		$data['js'] = '../../mst_perijinan/views/table_optional_js';
        $data['btnurl'] = base_url().'index.php/optional-perijinan/form';
		$this->buildView($data);
    }
    
    public function form_master() {
		$data['idmenu'] = 'perijinan-form-master';
		$data['content'] = '../../mst_perijinan/views/form_master';
		$data['datacontent'] = $this->mst_perijinan_model->get_optional_master();
		$data['js'] = '../../mst_perijinan/views/form_master_js';
		$this->buildView($data);
	}
    
    public function form_master_2() {
		$data['idmenu'] = 'perijinan-form-master-2';
		$data['content'] = '../../mst_perijinan/views/form_master2';
		$data['datacontent'] = $this->mst_perijinan_model->get_optional_master();
		$data['js'] = '../../mst_perijinan/views/form_master_js2';
		$this->buildView($data);
	}
    
    public function form_optional($id = FALSE) {
        $data['idmenu'] = 'perijinan-optional';
		$data['content'] = '../../mst_perijinan/views/form_optional';
		$data['js'] = '../../mst_perijinan/views/form_optional_js';
        $data['datajs']['uruts'] = $this->mst_perijinan_model->get_nourut();
        if($id!==FALSE) {
            $data['datajs']['data'] = $this->mst_perijinan_model->get_optional($id);
        }
		$this->buildView($data);
    }
    
    public function table_perijinan($id = FALSE) {
        $data['idmenu'] 			= 'perijinan-list';
		$data['content'] 			= '../../mst_perijinan/views/table_perijinan';
        $data['datacontent'] 		= $this->mst_perijinan_model->get_list();
		$data['js'] 				= '../../mst_perijinan/views/table_perijinan_js';
		$this->buildView($data);
    }
    
    public function get_master_unit($no_unit) {
		$this->output->set_content_type('application/json');
		echo json_encode($this->mst_perijinan_model->get_master_unit($this->input->post('no_unit')));
	}

	public function get_unit($no_unit) {
		$this->output->set_content_type('application/json');
		echo json_encode($this->mst_perijinan_model->get_unit($no_unit));
	}
    
    public function get_some_units() {
        $this->output->set_content_type('application/json');
        echo json_encode(
            array(
                'kode'=>'200',
                'data'=>$this->mst_perijinan_model->get_some_units()
            )
        );
    }

	public function genDT() {
		$this->datatables->select('MD5(s.no_unit) AS xnounit,s.no_unit AS no_unit,stypep.konten AS type_property,stypeu.konten AS type_unit,stower.konten AS tower_cluster,'.
					's.wide_netto AS wide_netto,s.wide_gross AS wide_gross,slantai.konten AS lantai_blok,'.
					'sdir.konten AS direction, sangin.konten AS mata_angin')
			->unset_column('xnounit')
			->from('mst_stock s')
			->join('mst_optional_stock stypep', 'stypep.kode = s.type_property AND stypep.sfield = "type_property" AND stypep.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->join('mst_optional_stock stower', 'stower.kode = s.tower_cluster AND stower.sfield = "tower_cluster" AND stower.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->join('mst_optional_stock stypeu', 'stypeu.kode = s.type_unit AND stypeu.sfield = "type_unit" AND stypeu.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->join('mst_optional_stock slantai', 'slantai.kode = s.lantai_blok AND slantai.sfield = "lantai_blok" AND slantai.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->join('mst_optional_stock sdir', 'sdir.kode = s.direction AND sdir.sfield = "direction" AND sdir.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->join('mst_optional_stock sangin', 'sangin.kode = s.mata_angin AND sangin.sfield = "mata_angin" AND sangin.sflag = "'.$this->session->userdata('type_entity').'"', 'left')
			->where(array('s.kode_entity'=>$this->session->userdata('kode_entity')))
			->add_column('action', '<a href="javascript:" class="row-unit" data-encunit="$1" data-unit="$2"><span class="glyphicons glyphicons-check"></span> View</a>', 
					'xnounit,no_unit');
		echo $this->datatables->generate();
	}
    
    public function genDT_optional() {
        $this->datatables->select('id, kode, konten, CASE WHEN isactive = 1 THEN "Ya" ELSE "Tidak" END AS aktif, no_urut AS nourut', FALSE)
            ->unset_column('id')
            ->from('mst_optional_dokumen')
            ->where(array('sfield'=>'jenis_dokumen'))
            ->add_column('action', '<a href="javascript:action(\'edit\',\'$1\')"><span class="glyphicons glyphicons-edit"></span></a>&nbsp;&nbsp'.
                '<a href="javascript:action(\'delete\',\'$1\')"><span class="glyphicons glyphicons-bin"></span></a>', 'id');
        echo $this->datatables->generate();
    }
    
    public function genDT_perijinan() {
        $this->datatables->select('s.no_unit, i.nama_dokumen, i.no_dokumen, i.tgl_ra, i.tgl_ri, i.nama_notaris', FALSE)
            ->from('mst_stock s')
            ->join('mst_perijinan i', 'i.kode_entity = s.kode_entity AND i.no_unit = s.no_unit', 'left')
            ->where(array('s.kode_entity'=>$this->session->userdata('kode_entity')));
        echo $this->datatables->generate();
    }

	public function save() {
		$data = $this->input->post();
		$data['kode_entity'] = $this->session->userdata('kode_entity');
		// $data['tgl_ra'] = $this->dateutils->dateStr_to_mysql($this->input->post('tgl_ra'));
		// $data['tgl_ri'] = $this->dateutils->dateStr_to_mysql($this->input->post('tgl_ri'));
		return $this->mst_perijinan_model->_insert($data);
	}
    
    public function save_master() {
        return $this->mst_perijinan_model->_insert_master();
    }
    
    public function save_master_2() {
        return $this->mst_perijinan_model->_insert_master_2();
    }

	public function save_tanggal() {
		$target = $this->input->post('target');
		$sfield = 'tgl_'.$target;
		$ids = $this->input->post('id');
		$tgls = $this->input->post($sfield);
		return $this->mst_perijinan_model->save_tanggal($target, $ids, $tgls);
	}
    
    public function save_optional() {
        $data = $this->input->post();
        $data['no_urut'] = str_replace(',','',$data['no_urut']);
        if($data['id']==='')
            $this->mst_perijinan_model->insert_optional($data);
        else
            $this->mst_perijinan_model->update_optional($data);
    }
    
    public function delete_optional($id) {
        echo $this->mst_perijinan_model->delete_optional($id);
    }
	
}