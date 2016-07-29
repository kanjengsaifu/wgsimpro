<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPCLASS;

class Tr_ri_kpr extends App {
	
	public function __construct() {
		parent::__construct();
			
		$this->load->model('tr_ri_kpr_model');
		$this->load->library('datatables');
		$this->load->library('dateUtils');
	}

	public function index() {
		$data = array();
		$data['idmenu'] = 'rikpr-form';
		$data['content'] = '../../tr_ri_kpr/views/form';
		$data['js'] = '../../tr_ri_kpr/views/form_js';
		$this->buildView($data);
	}

	public function get_tr($reserve_no) {
		$this->output->set_content_type('application/json');
		echo json_encode($this->tr_ri_kpr_model->get_tr($reserve_no));
	}
	
	public function save() {
		$data = $this->input->post();
		$data['tanggal'] = $this->dateutils->dateStr_to_mysql($this->input->post('tanggal'));
		$data['rp'] = str_replace(',', '', $data['rp']);
		return $this->tr_ri_kpr_model->_insert($data);
	}
	
	public function delete($id) {
		
	}
	
	public function genDT() {
		$this->datatables->select('pay.reserve_no, pay.no_unit As no_unit, nsb.nama AS nasabah, bank.nama AS bank, '.
				'FORMAT(paydet.rp,2) AS kpr, FORMAT(rp_um.rp,2) AS um', FALSE)
			->unset_column('pay.reserve_no')
			->from('tr_payment pay')
			->join('mst_nasabah nsb', 'nsb.kode = pay.kode_nasabah', 'inner')
			->join('mst_bank bank', 'bank.kode = pay.kode_bank', 'left')
			->join('tr_payment_detail paydet', 'paydet.reserve_no = pay.reserve_no AND paydet.kode_pay LIKE "%KPR%" AND paydet.tgl_bayar IS NULL', 'inner')
			->join('(SELECT paydet.reserve_no, SUM(paydet.rp) AS rp FROM tr_payment_detail paydet INNER JOIN '.
				'mst_payment_plan plan ON plan.kode_pay = paydet.kode_pay WHERE paydet.tgl_bayar IS NULL AND '.
				'plan.tipe_pay IN ("BOOKINGFEE", "DOWNPAYMENT") GROUP BY paydet.reserve_no) rp_um', 'rp_um.reserve_no = pay.reserve_no', 'inner')
			->join('mst_bank_plafond pf', 'pf.reserve_no = pay.reserve_no AND pf.kode_bank = pay.kode_bank', 'inner')
			->where(array('pay.cara_bayar'=>'KPRKPA','pay.kode_entity'=>$this->session->userdata('kode_entity')))
			->add_column('action', '<a href="javascript:" class="row-view" data-resno="$1"><span class="glyphicons glyphicons-edit"></span></a>', 'pay.reserve_no');
		echo $this->datatables->generate();
	}
	
}
