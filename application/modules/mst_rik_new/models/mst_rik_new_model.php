<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mst_rik_new_model extends CI_Model {

	public function getEntity($id = FALSE, $filter = FALSE) {
		if($id == FALSE) {
			$this->db->select('e.*')
				 ->select("date_format(e.tgl_mulai,'%d/%m/%Y') as xtgl_mulai",FALSE)
				 ->select("date_format(e.tgl_selesai,'%d/%m/%Y') as xtgl_selesai",FALSE)
				 ->select("format(e.nilai_developer,2) as nilai_developer",FALSE)
				 ->select('ejenis.konten AS xjenis, etype.konten AS xtype_entity')
				 ->from('mst_entity e')
				 ->join('mst_optional_entity ejenis','ejenis.kode=e.jenis')
				 ->join('mst_optional_entity etype','etype.kode=e.type_entity');
			$q = $this->db->get();
			return $q->result_array();
		} else {

		}
	}

	/**
	 * GET STATUS ENTITY
	 * RETURN ADA ATAU TIDAK DALAM SALAH SATU TABEL DETAIL ENTITY
	 */
	public function getStatus($id){
		$q = $this->db->get_where('tr_rik_detail_rencana_produk',array('kode_entity'=>$id));
		$res = $q->row_array();
		$x = $q->num_rows();
		return $x;
	}

	/**
	 * GET RENCANA PRODUK
	 * 
	 */
	public function get_rencana_produk($kode_entity_p){
		$this->db->select('os.kode, os.konten')
				 ->from('mst_optional_stock os')
				 ->join('mst_entity me', 'os.sflag=me.type_entity')
				 ->order_by('os.no_urut','asc')
				 ->where(array('me.kode'=>$kode_entity_p, 'os.sfield'=>'type_property'));
		$q = $this->db->get();
		return $q->result_array();
	}

	public function get_detail_produk(){
		$this->db->select('os.kode, os.konten')
				 ->from('mst_optional_stock os')
				 ->join('mst_entity me', 'os.sflag=me.type_entity')
				 ->order_by('os.no_urut','asc')
				 ->where(array('me.kode'=>$this->session->userdata('kode_entity_rik'), 'os.sfield'=>'type_unit'));
		$q = $this->db->get();
		return $q->result_array();
	}

	public function get_rencana_biaya($kode_entity = FALSE){
		if($kode_entity == FALSE){
			$this->db->select('opr.kode, opr.konten')
					 ->from('mst_optional_rik opr')
					 ->where(array('opr.sflag'=>'rencana_biaya'));
			$q = $this->db->get();
			return $q->result_array();
		} else {
			$this->db->select('drb.*, mor.konten as konten')
					 ->from('tr_rik_detail_rencana_biaya drb')
					 ->join('mst_optional_rik mor','drb.kode_biaya=mor.kode')
					 ->where(array('drb.sflag'=>'rencana_biaya', 'drb.kode_entity' => $kode_entity));
			$q = $this->db->get();
			return $q->result_array();
		}
	}

	public function get_total_rencana_biaya($kode_entity_p){
		$this->db->select('SUM(biaya) as total_rencana_biaya', FALSE)
				 ->from('tr_rik_detail_rencana_biaya drb')
				 ->where(array('drb.sflag'=>'rencana_biaya', 'kode_entity' => $kode_entity_p));
		$q = $this->db->get();
		$res = $q->row_array();
		return $res['total_rencana_biaya'];
	}

	public function delete_all_rik($kode_entity_p){
		$tables = array('tr_rik_detail_rencana_produk',
						'tr_rik_detail_harga_jual',
						'tr_rik_detail_rencana_penjualan',
						'tr_rik_detail_rencana_laba',
						'tr_rik_detail_nilai_tanah',
						'tr_rik_detail_profit_sharing',
						'tr_rik_detail_rencana_biaya');
		$this->db->where('kode_entity', $kode_entity_p);
		$this->db->delete($tables);
	}

	public function get_rencana_penjualan($kode_entity = FALSE){
		if($kode_entity != FALSE){
			$this->db->select('drp.*, mos.konten as konten')
					 ->from('tr_rik_detail_rencana_penjualan drp')
					 ->join('mst_optional_stock mos','drp.nama_produk=mos.kode')
					 ->join('mst_entity me', 'me.type_entity=mos.sflag')
					 ->where(array('me.kode' => $kode_entity));
			$q = $this->db->get();
			$res = $q->result_array();
			foreach ($res as $key => $value) {
				$type_property = $value['nama_produk'];
				$data_anak = $this->get_anak_produk($kode_entity, $type_property);
				$i = 0;			
				$res[$key]['anak'] = array();
				foreach ($data_anak as $k => $v) {		
					$daftar_anak = array();
					$daftar_anak['type_property'] = $v['type_property'];
					$daftar_anak['type_unit'] = $v['type_unit'];
					$daftar_anak['volume'] = $v['volume'];
					$daftar_anak['satuan'] = $v['satuan'];
					$daftar_anak['persentase'] = $v['persentase'];
					$daftar_anak['harga_m2'] = $v['harga_m2'];
					$daftar_anak['harga_unit'] = $v['harga_unit'];
					array_push($res[$key]['anak'], $daftar_anak);
					$i++;
				}
			}
			return $res;
		}
	}

	public function get_anak_produk($kode_entity = FALSE, $type_property){
		if($kode_entity != FALSE){
			$this->db->select('drpo.*')
					 ->from('tr_rik_detail_rencana_produk drpo')
					 ->where(array('drpo.kode_entity' => $kode_entity, 'drpo.type_property' => $type_property));
			$q = $this->db->get();
			$res = $q->result_array();
			return $res;
		}
	}

	public function get_total_rencana_penjualan($kode_entity_p){
		$this->db->select('SUM(harga_jual) as total_rencana_penjualan', FALSE)
				 ->from('tr_rik_detail_rencana_penjualan drp')
				 ->where(array('kode_entity' => $kode_entity_p));
		$q = $this->db->get();
		$res = $q->row_array();
		return $res['total_rencana_penjualan'];
	}

	public function get_detail_harga_jual($kode_entity_p){
		if($kode_entity_p != FALSE){
			$this->db->select('dhj.*, mos.konten as konten')
					 ->from('tr_rik_detail_harga_jual dhj')
					 ->join('mst_optional_stock mos','dhj.type_property=mos.kode')
					 ->join('mst_entity me', 'me.type_entity=mos.sflag')
					 ->where(array('dhj.sflag'=>'harga_jual_netto', 'me.kode' => $kode_entity_p));
			$q = $this->db->get();
			return $q->result_array();
		} else {
			return false;
		}
	}

	public function get_detail_data_luas($kode_entity_p){
		if($kode_entity_p != FALSE){
			$this->db->select('dhj.*, mor.konten as konten')
					 ->from('tr_rik_detail_harga_jual dhj')
					 ->join('mst_optional_rik mor','dhj.type_property=mor.kode')
					 ->where(array('dhj.sflag'=>'data_luas', 'dhj.kode_entity' => $kode_entity_p));
			$q = $this->db->get();
			return $q->result_array();
		} else {
			return false;
		}
	}

	public function get_detail_rencana_laba($kode_entity_p){
		if($kode_entity_p != FALSE){
			$this->db->select('drl.*')
					 ->from('tr_rik_detail_rencana_laba drl')
					 ->where(array('drl.kode_entity'=>$kode_entity_p));
			$q = $this->db->get();
			return $q->result_array();
		}
	}

	public function get_detail_profit_sharing($kode_entity_p){
		if($kode_entity_p != FALSE){
			$this->db->select('dps.*')
					 ->from('tr_rik_detail_profit_sharing dps')
					 ->where(array('dps.kode_entity'=>$kode_entity_p));
			$q = $this->db->get();
			return $q->result_array();
		}
	}

	public function get_detail_nilai_tanah($kode_entity_p){
		if($kode_entity_p != FALSE){
			$this->db->select('dnt.*')
					 ->from('tr_rik_detail_nilai_tanah dnt')
					 ->where(array('dnt.kode_entity'=>$kode_entity_p));
			$q = $this->db->get();
			return $q->result_array();
		}
	}

	public function get_harga_jual_netto(){
		$this->db->select('opr.kode, opr.konten')
				 ->from('mst_optional_rik opr')
				 ->where(array('opr.sflag'=>'type_harga_netto'));
		$q = $this->db->get();
		return $q->result_array();
	}

	public function save($data_rencana_produk = FALSE, 
		$data_rencana_biaya = FALSE, $data_harga_jual1 = FALSE, $data_luas = FALSE, 
		$data_rencana_penjualan = FALSE, $data_rencana_laba = FALSE, $data_profit_sharing = FALSE,
		$nilai_tanah_total = FALSE){

		if($data_rencana_produk !== FALSE){
			foreach ($data_rencana_produk as $key => $value) {
				$query = $this->db->insert('tr_rik_detail_rencana_produk', $value);
			}
		}		
		if($data_harga_jual1 !== FALSE){
			foreach ($data_harga_jual1 as $k => $v) {
				$q = $this->db->insert('tr_rik_detail_harga_jual', $v);
			}
		}
		if($data_luas !== FALSE){
			foreach ($data_luas as $k => $v) {
				$q = $this->db->insert('tr_rik_detail_harga_jual', $v);
			}
		}
		if($data_rencana_penjualan !== FALSE){
			foreach ($data_rencana_penjualan as $k => $v) {
				$q = $this->db->insert('tr_rik_detail_rencana_penjualan', $v);
			}
		}
		if($data_rencana_biaya !== FALSE){
			foreach ($data_rencana_biaya as $k => $v) {
				$q = $this->db->insert('tr_rik_detail_rencana_biaya', $v);
			}
		}
		if($data_rencana_laba !== FALSE){
			$q = $this->db->insert('tr_rik_detail_rencana_laba', $data_rencana_laba);
		}
		if($data_profit_sharing !== FALSE){
			$q = $this->db->insert('tr_rik_detail_profit_sharing', $data_profit_sharing);
		}
		if($nilai_tanah_total !== FALSE){
			$q = $this->db->insert('tr_rik_detail_nilai_tanah', $nilai_tanah_total);
		}
	}
}