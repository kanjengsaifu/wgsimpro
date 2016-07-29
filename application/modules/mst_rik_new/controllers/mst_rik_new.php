<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPCLASS;

class Mst_rik_new extends App {
	
	public function __construct() {
		parent::__construct();
			
		$this->load->model('mst_rik_new_model');
		$this->load->library('datatables');
	}

	public function index() {
		$data = array();
		$data['idmenu'] = 'rik-header';
		$data['content'] = '../../mst_rik_new/views/table';
		$data['js'] = '../../mst_rik_new/views/table_js';
		$this->buildView($data);
	}
	
	public function form($kode_entity_p = FALSE) {
		if($kode_entity_p!==FALSE || $kode_entity==='0') {
			$this->session->set_userdata(array('kode_entity_rik' => $kode_entity_p));
			if($this->mst_rik_new_model->getStatus($kode_entity_p) > 0){
				$data = array();
				$data['idmenu'] = 'rik-header-input';
				$data['content'] = '../../mst_rik_new/views/form_detail';
				$data['datacontent']['list_produk'] = $this->mst_rik_new_model->get_rencana_produk($kode_entity_p);
				$data['datacontent']['detail_harga_jual'] = $this->mst_rik_new_model->get_detail_harga_jual($kode_entity_p);
				$data['datacontent']['detail_data_luas'] = $this->mst_rik_new_model->get_detail_data_luas($kode_entity_p);
				$data['datacontent']['detail_rencana_penjualan'] = $this->mst_rik_new_model->get_rencana_penjualan($kode_entity_p);
				$data['datacontent']['total_rencana_penjualan'] = $this->mst_rik_new_model->get_total_rencana_penjualan($kode_entity_p);
				$data['datacontent']['list_rencana_biaya'] = $this->mst_rik_new_model->get_rencana_biaya();
				$data['datacontent']['detail_rencana_biaya'] = $this->mst_rik_new_model->get_rencana_biaya($kode_entity_p);
				$data['datacontent']['total_rencana_biaya'] = $this->mst_rik_new_model->get_total_rencana_biaya($kode_entity_p);
				$data['datacontent']['list_harga_jual_netto'] = $this->mst_rik_new_model->get_harga_jual_netto();
				$data['datacontent']['detail_rencana_laba'] = $this->mst_rik_new_model->get_detail_rencana_laba($kode_entity_p);
				$data['datacontent']['detail_profit_sharing'] = $this->mst_rik_new_model->get_detail_profit_sharing($kode_entity_p);
				$data['datacontent']['detail_nilai_tanah'] = $this->mst_rik_new_model->get_detail_nilai_tanah($kode_entity_p);
				$data['datacontent']['combo_detail_produk'] = $this->mst_rik_new_model->get_detail_produk();					
				$data['js'] = '../../mst_rik_new/views/form_js';
			} else {
				$data = array();
				$data['idmenu'] = 'rik-header-input';
				$data['content'] = '../../mst_rik_new/views/form';
				$data['datacontent']['list_produk'] = $this->mst_rik_new_model->get_rencana_produk($kode_entity_p);
				$data['datacontent']['list_rencana_biaya'] = $this->mst_rik_new_model->get_rencana_biaya();
				$data['datacontent']['list_harga_jual_netto'] = $this->mst_rik_new_model->get_harga_jual_netto();
				$data['js'] = '../../mst_rik_new/views/form_js';
			}
		}
		$this->buildView($data);
	}
	
	public function save() {
		//var umum
		$kode_entity = $this->session->userdata('kode_entity_rik');
		if($this->mst_rik_new_model->getStatus($kode_entity) > 0){
			$this->mst_rik_new_model->delete_all_rik($kode_entity);
		}
		/*rencana produk */
		$data_rencana_produk = array();
		$type_property = $this->input->post('type_property_detil');
		$type_unit = $this->input->post('type_unit_detil');
		$sflag = 'rencana_produk';
		$volume = $this->input->post('volume_detil');
		$volume = str_replace(',', '', $volume);
		$satuan = $this->input->post('satuan_detil');
		$persentase = $this->input->post('persen_detil');
		$persentase = str_replace(',','',$persentase);
		$harga_m2 = $this->input->post('harga_m2_detil');
		$harga_m2 = str_replace(',', '', $harga_m2);
		$harga_unit = $this->input->post('harga_unit_detil');
		$harga_unit = str_replace(',', '', $harga_unit);
		foreach ($type_property as $index => $value) {
			$item = array(
				'kode_entity' => $kode_entity,
				'type_property' => $type_property[$index],
				'type_unit' => empty($type_unit) ? '' : $type_unit[$index],
				'sflag' => $sflag,
				'volume' => empty($volume) ? '0' : $volume[$index],
				'satuan' => empty($satuan) ? '' : $satuan[$index],
				'persentase' => empty($persentase) ? '0' : $persentase[$index],
				'harga_m2' => empty($harga_m2) ? '0' : $harga_m2[$index],
				'harga_unit' => empty($harga_unit) ? '0' : $harga_unit[$index]
			);
			$data_rencana_produk[] = $item;
		}// End Rencana Produk

		/*harga jual netto*/
		$data_harga_jual1 = array();
		$type_property = $this->input->post('type_property_harga_jual');
		$harga_jual = $this->input->post('harga_jual');
		$harga_jual = str_replace(',', '', $harga_jual);
		foreach ($type_property as $index => $value) {
			$item = array(
				'kode_entity' => $kode_entity,
				'type_property' => $type_property[$index],
				'sflag' => 'harga_jual_netto',
				'gross' => '',
				'satuan_gross' => '',
				'efektif' => '',
				'satuan_efektif' => '',
				'percentage' => '',
				'harga_jual' => empty($harga_jual) ? '0' : $harga_jual[$index]
			);
			$data_harga_jual1[] = $item;
		} // End Harga Jual Netto

		/* Data Luas */
		$data_luas = array();
		$type_property = $this->input->post('type_property_luas');
		$gross = $this->input->post('volume_luas');
		$gross = str_replace(',', '', $gross);
		$satuan_gross = $this->input->post('satuan_luas');
		$efektif = $this->input->post('efektif_luas');
		$efektif = str_replace(',', '', $efektif);
		$satuan_efektif = $this->input->post('satuan_efektif');
		$percentage = $this->input->post('percentage_luas');
		foreach ($type_property as $key => $value) {
			$item = array(
				'kode_entity' => $kode_entity,
				'type_property' => $type_property[$key],
				'sflag' => 'data_luas',
				'gross' => empty($gross) ? '0' : $gross[$key],
				'satuan_gross' => empty($satuan_gross) ? '' : $satuan_gross[$key],
				'efektif' => empty($efektif) ? '0' : $efektif[$key],
				'satuan_efektif' => empty($satuan_efektif) ? '' : $satuan_efektif[$key],
				'percentage' => empty($percentage) ? '0' : $percentage[$key],
				'harga_jual' => '0'
			);
			$data_luas[] = $item;
		} //End Data Luas

		/*
		 * Rencana Penjualan
		 */
		$data_rencana_penjualan = array();
		$nama_produk = $this->input->post('nama_produk_rp');
		$volume = $this->input->post('volume_rp');
		$volume = str_replace(',', '', $volume);
		$satuan = $this->input->post('satuan_rp');
		$harga_jual = $this->input->post('harga_jual_rp');
		$harga_jual = str_replace(',', '', $harga_jual);
		foreach ($nama_produk as $key => $value) {
			$item = array(
				'kode_entity' => $kode_entity,
				'nama_produk' => $nama_produk[$key],
				'volume' => empty($volume) ? '0' : $volume[$key],
				'satuan' => empty($satuan) ? '' : $satuan[$key],
				'harga_jual' => empty($harga_jual) ? '0' : $harga_jual[$key]
			);
			$data_rencana_penjualan[] = $item;
		}
		//End Rencana Penjualan

		/*rencana Biaya*/
		$data_rencana_biaya = array();
		$sflag = 'rencana_biaya';
		$kode_biaya = $this->input->post('kode_biaya');
		$volume = $this->input->post('volume_rb');
		$volume = str_replace(',', '', $volume);
		$satuan = $this->input->post('satuan_rb');
		$bobot = $this->input->post('bobot_rb');
		$bobot = str_replace(',', '', $bobot);
		$biaya = $this->input->post('biaya_rb');
		$biaya = str_replace(',', '', $biaya);

		foreach ($kode_biaya as $index => $value) {
			$item = array(
				'kode_entity' => $kode_entity,
				'sflag' => $sflag,
				'kode_biaya' => $kode_biaya[$index],
				'volume' => empty($volume) ? '0' : $volume[$index],
				'satuan' => $satuan[$index],
				'bobot' => empty($bobot) ? '0' : $bobot[$index],
				'biaya' => empty($biaya) ? '0' : $biaya[$index]
			);
			$data_rencana_biaya[] = $item;
		} //End Rencana biaya

		/*
		 * GET DATA RENCANA LABA
		 * SEHARUSNYA TIDAK USAH INSERT TO KE DALAM TABEL / TIDAK USAH ADA FORMNYA
		 * TAPI BIKIN AJA VIEW NYA. UNTUK SEMENTARA MASUK TABEL (STATIC)
		 */
		$total_rencana_penjualan = $this->input->post('laba_total_rencana_penjualan');
		$total_rencana_penjualan = str_replace(',', '', $total_rencana_penjualan);
		$total_rencana_biaya = $this->input->post('laba_total_rencana_biaya');
		$total_rencana_biaya = str_replace(',', '', $total_rencana_biaya);
		$sub_total_laba = $this->input->post('laba_sub_total');
		$sub_total_laba = str_replace(',', '', $sub_total_laba);
		$pph_final = $this->input->post('laba_pph_final');
		$pph_final = str_replace(',', '', $pph_final);
		$grand_total = $this->input->post('laba_total_rencana');
		$grand_total = str_replace(',', '', $grand_total);

		$data_rencana_laba = array(
			'kode_entity' => $kode_entity,
			'rencana_penjualan' => empty($total_rencana_penjualan) ? '0' : $total_rencana_penjualan,
			'rencana_biaya' => empty($total_rencana_biaya) ? '0' : $total_rencana_biaya,
			'sub_total' => empty($sub_total_laba) ? '0' : $sub_total_laba,
			'pph_final' => empty($pph_final) ? '0' : $pph_final,
			'grand_total' => empty($grand_total) ? '0' : $grand_total
		);// -- END DATA RENCANA LABA

		/*
		 * GET DATA PROFIT SHARING
		 * SEHARUSNYA TIDAK USAH INSERT TO KE DALAM TABEL / TIDAK USAH ADA FORMNYA 
		 * TAPI BIKIN AJA VIEW NYA. UNTUK SEMENTARA MASUK TABEL (STATIC)
		 */
		$to_wika = $this->input->post('sharing_total_wika');
		$to_wika = str_replace(',', '', $to_wika);
		$persen_wika = $this->input->post('sharing_persen_wika');
		$persen_wika = str_replace(',', '', $persen_wika);
		$to_pemilik = $this->input->post('sharing_total_pemilik');
		$to_pemilik = str_replace(',', '', $to_pemilik);
		$persen_pemilik = $this->input->post('sharing_persen_pemilik');
		$persen_pemilik = str_replace(',', '', $persen_pemilik);
		$data_profit_sharing = array(
			'kode_entity' => $kode_entity,
			'to_wika' => empty($to_wika) ? '0' : $to_wika,
			'to_pemilik' =>  empty($to_pemilik) ? '0' : $to_pemilik,
			'persen_wika' => empty($persen_wika) ? '0' : $persen_wika,
			'persen_pemilik' =>  empty($persen_pemilik) ? '0' : $persen_pemilik
		); //END GET DATA PROFIT SHARING

		/*
		 * GET DATA NILAI TANAH TOTAL
		 * DI ISI MANUAL, TIDAK TAHU REFER KE TABEL APA DAN CARA HITUNGNYA
		 */
		$nilai_tanah = $this->input->post('tanah_total_nilai');
		$nilai_tanah = str_replace(',', '', $nilai_tanah);
		$tanah_pemilik_lahan = $this->input->post('tanah_pemilik_lahan');
		$tanah_pemilik_lahan = str_replace(',', '', $tanah_pemilik_lahan);
		$kolom_satu = $this->input->post('kolom_satu');
		$kolom_satu = str_replace(',', '', $kolom_satu);
		$kolom_dua = $this->input->post('kolom_dua');
		$kolom_dua = str_replace(',', '', $kolom_dua);
		$nilai_tanah_total = array(
			'kode_entity' => $kode_entity,
			'nilai_tanah' => empty($nilai_tanah) ? '0' : $nilai_tanah,
			'profit_sharing' => empty($tanah_pemilik_lahan) ? '0' : $tanah_pemilik_lahan,
			'kolom_satu' => empty($kolom_satu) ? '0' : $kolom_satu,
			'kolom_dua' => empty($kolom_dua) ? '0' : $kolom_dua
		);

		$res = $this->mst_rik_new_model->save($data_rencana_produk, 
											  $data_rencana_biaya, 
											  $data_harga_jual1, 
											  $data_luas, 
											  $data_rencana_penjualan, 
											  $data_rencana_laba, 
											  $data_profit_sharing,
											  $nilai_tanah_total);
		
		$out = array();
		// if($res) {
			$out['status'] = '200';
			$out['msg'] = "Data tersimpan";
		// } else {
			// $out['status'] = '500';
			// $out['msg'] = "Terjadi kesalahan, silahkan kontak administrator.";
		// }
		$this->output->set_content_type('application/json');
		echo json_encode($out);
	}
	
	public function delete($id) {
		$res = $this->mst_rik_model->_delete($id);
		if($res) {
			$out = array(
				'response'=>'1',
				'msg'=>'Success'
			);
		} else {
			$out = array(
				'response'=>'0',
				'msg'=>'Failed'
			);
		}
		$this->output->set_content_type('application/json');
		echo json_encode($out);
	}
	
	public function genDT() {
		$this->datatables->select('e.id, e.kode as kode, e.nama as nama, e.type_entity as type_entity')
				->unset_column('e.id')
				->from('mst_entity e')
				->where(array('e.kode'=>$this->session->userdata('kode_entity')))
				->add_column('action', '<a href="javascript:action(\'edit\',\'$1\')"><span class="glyphicons glyphicons-edit"></span></a>&nbsp;&nbsp','kode');
		echo $this->datatables->generate();
	}

	public function get_detail_produk(){
		$this->output->set_content_type('application/json');
		echo json_encode($this->mst_rik_new_model->get_detail_produk());
	}
	
}