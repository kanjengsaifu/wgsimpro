<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPCLASS;

class Mst_payment_plan extends App {
	
	public function __construct() {

		parent::__construct();
		$this->load->model('mst_payment_plan_model');
		$this->load->library('datatables');
	}

	public function index() {

	}
	
	public function table($type = 'jenis') {
		$data['idmenu'] = 'payment-plan-table-'.$type;
		$data['content'] = '../../mst_payment_plan/views/'.$type.'_table';
		$data['js'] = '../../mst_payment_plan/views/'.$type.'_table_js';
		$data['btnurl'] = base_url().'index.php/payment-plan/form/'.$type;
		$this->buildView($data);
	}

	public function form($type = 'jenis', $id = FALSE) {
		$data['idmenu'] = 'payment-plan-form-'.$type;
		$data['content'] = '../../mst_payment_plan/views/'.$type.'_form';
		if($type==='pola') {
			$data['datacontent'] = $this->mst_payment_plan_model->get_optional();
		}
		$data['js'] = '../../mst_payment_plan/views/'.$type.'_form_js';
		if($id!==FALSE) {
			$data['datajs'] = $this->mst_payment_plan_model->get($type, $id);
		}
		$this->buildView($data);
	}

	public function genDT($type = 'jenis') {
		if($type==='jenis') {
			$this->datatables->select('id, kode_pay, deskripsi, tipe_pay, base_period, install_num, persentase, limit_day')
				->unset_column('id')
				->from('mst_payment_plan')
				->add_column('action', '<a href="'.base_url().'index.php/payment-plan/form/'.$type.'/$1"><span class="glyphicons glyphicons-edit"></span></a>&nbsp;&nbsp'.
					'<a href="javascript:" data-id="$1" class="row-delete"><span class="glyphicons glyphicons-bin"></span></a>', 'id');
		} elseif($type==='pola') {
			$this->datatables->distinct('det.kode_pay')
				->select('det.kode_pay, op.nama AS cara_bayar, det.deskripsi')
				->unset_column('det.kode_pay')
				->from('mst_payment_plan_detail det')
				->join('mst_optional op','op.kode = det.cara_bayar AND op.opsi = "PAYMENTPAYMODE" AND isactive = 1')
				->add_column('action', '<a href="'.base_url().'index.php/payment-plan/form/'.$type.'/$1"><span class="glyphicons glyphicons-edit"></span></a>&nbsp;&nbsp'.
					'<a href="javascript:" data-kode="$1" class="row-delete"><span class="glyphicons glyphicons-bin"></span></a>', 'det.kode_pay');
		}
		echo $this->datatables->generate();
	}

	public function save($type = 'jenis') {
		$data = $this->input->post();
		if($type==='jenis') {
			$data['rp'] = str_replace(',', '', $data['rp']);
		}
		if($type==='pola' OR $data['id']==='') {
			return $this->mst_payment_plan_model->_insert($type, $data);
		} else {
			return $this->mst_payment_plan_model->_update($type, $data, $data['id']);
		}
	}

	public function delete($type = 'jenis', $id) {
		return $this->mst_payment_plan_model->_delete($type, $id);
	}
	
}