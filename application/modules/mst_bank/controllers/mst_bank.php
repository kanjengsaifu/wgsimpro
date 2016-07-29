<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPCLASS;

class Mst_bank extends App {

	public function __construct() {
		parent::__construct();
			
		$this->load->model('mst_bank_model');
		$this->load->library('datatables');
		$this->load->library('dateUtils');
	}

	public function index() {
		$data['idmenu'] = 'bank-table';
		$data['content'] = '../../mst_bank/views/table';
		$data['js'] = '../../mst_bank/views/table_js';
		$data['btnurl'] = base_url().'index.php/bank/form';
		$this->buildView($data);
	}
	
	public function bank_accounting() {
		$data['idmenu'] = 'bank-table-accounting';
		$data['content'] = '../../mst_bank/views/table_accounting';
		$data['js'] = '../../mst_bank/views/table_accounting_js';
		$data['btnurl'] = base_url().'index.php/bank/form_accounting';
		$this->buildView($data);
	}

	public function form($id = FALSE) {
		$this->load->helper('combo');
		$data['idmenu'] 	= 'bank-form';
		$data['content'] 	= '../../mst_bank/views/form';
		$data['js'] 		= '../../mst_bank/views/form_js';
		$like = array('field'=>'nama_jenis','text_2search'=>'bank','position'=>'after');
		$data['datacontent']['cbo_jenis']	= cbo_jenisjurnal('kd_jenis','', '','---Pilih---',$like,'chosen-select');
		$data['datacontent']['cbo_entity']	= cbo_entity('kd_entity','', '','---Pilih---','chosen-select');
		if($id!==FALSE) {
			$data['datajs'] = $this->mst_bank_model->getAccounting($id);
		}
		$this->buildView($data);
	}

	public function form_accounting($id = FALSE) {
		$this->load->helper('combo');
		$data['idmenu'] 	= 'bank-form';
		$data['content'] 	= '../../mst_bank/views/form_accounting';
		$data['js'] 		= '../../mst_bank/views/form_accounting_js';
		$like = array('field'=>'nama_jenis','text_2search'=>'bank','position'=>'after');
		$data['datacontent']['cbo_jenis']	= cbo_jenisjurnal('kode_jenis','', '','---Pilih---',$like,'chosen-select'); 
		$data['datacontent']['cbo_entity']	= cbo_entity('kode_entity','', '','---Pilih---','chosen-select');
		if($id!==FALSE) {
			$data['datajs'] = $this->mst_bank_model->getAccounting($id);
		}
		$this->buildView($data);
	}
	

	public function form_alokasi() {
		$this->load->helper('combo');
		$data['idmenu'] 			= 'akuntansi-bank-kpr';
		$data['content'] 			= '../../mst_bank/views/alokasi_form';
		$data['js'] 				= '../../mst_bank/views/alokasi_form_js';
		//$data['datacontent'] 			= $this->mst_bank_model->get_dokumen();
		//$data['datacontent']['cbo_entity']	= cbo_entity('kd_entity','', '','---Pilih---','chosen-select');
		$data['datacontent']			= $this->mst_bank_model->get_optional_alokasi();
		$this->buildView($data);
	}
	
	public function form_bank_accounting() {
		$this->load->helper('combo');
		$data['idmenu'] 			= 'akuntansi-kas-bank';
		$data['content'] 			= '../../mst_bank/views/alokasi_form';
		$data['js'] 				= '../../mst_bank/views/alokasi_form_js';
		//$data['datacontent'] 			= $this->mst_bank_model->get_dokumen();
		//$data['datacontent']['cbo_entity']	= cbo_entity('kd_entity','', '','---Pilih---','chosen-select');
		$data['datacontent']			= $this->mst_bank_model->get_optional_alokasi();
		$this->buildView($data);
	}

	public function form_plafond() {
		$data['idmenu'] = 'bank-plafond-form';
		$data['content'] = '../../mst_bank/views/plafond_form';
		$data['datacontent'] = $this->mst_bank_model->get_bank_kpr();
		$data['js'] = '../../mst_bank/views/plafond_form_js';
		$this->buildView($data);
	}

	public function get_alokasi($kode) {
		$this->output->set_content_type('application/json');
		echo json_encode($this->mst_bank_model->get_alokasi($kode));
	}

	public function get_plafond($resno) {
		$this->output->set_content_type('application/json');
		echo json_encode($this->mst_bank_model->get_plafond($resno));
	}

	public function genDT() {
		// $this->output->enable_profiler(TRUE);
		$this->datatables->select('mb.kode, mb.nama, mb.no_rekening, mb.kode_entity, me.nama as nama_entity, mb.kode_jenis, IF(mb.iskpr = 1, "Y", "N") AS iskpr, mb.id, IF(mb.is_ops=1,"YA","-") AS is_ops, IF(mb.is_tamp=1,"YA","-") AS is_tamp', FALSE)
			->unset_column('mb.id')
			->from('mst_bank mb')
			->join('mst_entity me','me.kode = mb.kode_entity','inner')
			->add_column('action', '<a href="'.base_url().'index.php/bank/edit/$1"><span class="glyphicons glyphicons-edit"></span></a>&nbsp;&nbsp'.
				'<a href="javascript:" class="row-delete" data-id="$1"><span class="glyphicons glyphicons-bin"></span></a>', 'id');
		echo $this->datatables->generate();
	}
	
	public function genaccDT(){
		$this->datatables->select('mb.id, mb.kode, mb.nama, mb.no_rekening, mb.kode_entity, me.nama as nama_entity', FALSE)
			->unset_column('mb.id')
			->from('mst_bank_accounting mb')
			->join('mst_entity me','me.kode = mb.kode_entity','inner')
			->add_column('action', '<a href="'.base_url().'index.php/bank/form_accounting/$1"><span class="glyphicons glyphicons-edit"></span></a>&nbsp;&nbsp'.
				'<a href="javascript:" class="row-delete" data-id="$1"><span class="glyphicons glyphicons-bin"></span></a>', 'mb.id');
		echo $this->datatables->generate();
	}

	public function genDT_alokasi() {
		// $this->output->enable_profiler(TRUE);
		$this->datatables->select('mb.kode, mb.nama, mb.no_rekening, mb.kode_entity, me.nama as nama_entity,mb.id,', FALSE)
			->unset_column('mb.id')
			->unset_column('mb.kode_entity')
			->from('mst_bank mb')
			->join('mst_entity me','me.kode = mb.kode_entity','inner')
			->where(array('mb.iskpr'=>1, 'me.kode'=>$this->session->userdata('kode_entity')))
			->add_column('action', '<a href="javascript:" class="row-view" data-kode="$1"><span class="glyphicons glyphicons-edit"></span></a>', 'mb.kode');
		echo $this->datatables->generate();
	}

	public function genDT_plafond() {
		$this->datatables->select('pay.reserve_no, pay.no_unit As no_unit, nsb.nama AS nasabah, bank.nama AS bank, FORMAT(paydet.rp,2) AS kpr, FORMAT(rp_um.rp,2) AS um', FALSE)
			->unset_column('pay.reserve_no')
			->from('tr_payment pay')
			->join('mst_nasabah nsb', 'nsb.kode = pay.kode_nasabah', 'inner')
			->join('mst_bank bank', 'bank.kode = pay.kode_bank', 'left')
			->join('tr_payment_detail paydet', 'paydet.reserve_no = pay.reserve_no AND paydet.kode_pay LIKE "%KPR%" AND paydet.tgl_bayar IS NULL', 'inner')
			->join('(SELECT paydet.reserve_no, SUM(paydet.rp) AS rp FROM tr_payment_detail paydet INNER JOIN mst_payment_plan plan ON plan.kode_pay = paydet.kode_pay WHERE paydet.tgl_bayar IS NULL AND plan.tipe_pay IN ("BOOKINGFEE", "DOWNPAYMENT") GROUP BY paydet.reserve_no) rp_um', 'rp_um.reserve_no = pay.reserve_no', 'inner')
			->where(array('pay.cara_bayar'=>'KPRKPA','pay.kode_entity'=>$this->session->userdata('kode_entity')))
			->add_column('action', '<a href="javascript:" class="row-view" data-resno="$1"><span class="glyphicons glyphicons-edit"></span></a>', 'pay.reserve_no');
		echo $this->datatables->generate();
	}

	public function save() {
		$data = $this->input->post();
		if($data['id']==='') {
			return $this->mst_bank_model->_insert($data);
		} else {
			return $this->mst_bank_model->_update($data, $data['id']);
		}
	}

	public function saveaccounting(){
		$data = $this->input->post();
		if($data['id']==='') {
			return $this->mst_bank_model->_insertAccounting($data);
		} else {
			return $this->mst_bank_model->_updateAccounting($data, $data['id']);
		}
	}

	public function save_alokasi() {
		$data = $this->input->post();
		return $this->mst_bank_model->_insert_alokasi($data);
	}

	public function save_plafond() {
		$data = $this->input->post();
		$data['rp'] = str_replace(',', '', $data['rp']);
		$data['tgl_ri_akad'] = $this->dateutils->dateStr_to_mysql($this->input->post('tgl_ri_akad'));
		$data['tgl_disetujui'] = $this->dateutils->dateStr_to_mysql($this->input->post('tgl_disetujui'));
		$this->output->set_content_type('application/json');
		echo json_encode($this->mst_bank_model->_insert_plafond($data));
	}

	public function delete($id) {
		return $this->mst_bank_model->_delete($id);
	}
    
    public function delete_alokasi($id) {
        return $this->mst_bank_model->_delete_alokasi($id);
    }

}
