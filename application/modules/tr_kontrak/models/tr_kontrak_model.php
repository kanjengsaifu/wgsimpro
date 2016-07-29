<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tr_kontrak_model extends CI_Model {
	
	public function get($id = FALSE, $filter = FALSE) {
		if($id==FALSE) {
			$this->db->select('k.*')
					 ->select("date_format(k.tanggal_sign,'%d/%m/%Y') as xtanggal",FALSE)
					 ->select("date_format(k.tanggal_mulai,'%d/%m/%Y') as stanggal",FALSE)
					 ->select("date_format(k.tanggal_akhir,'%d/%m/%Y') as etanggal",FALSE)
					 ->from('tr_kontrak k');
			$q = $this->db->get();
			$data =  $q->result_array();
		} else {
			$this->db->select('k.*')
					 ->select("date_format(k.tanggal_sign,'%d/%m/%Y') as xtanggal",FALSE)
					 ->select("date_format(k.tanggal_mulai,'%d/%m/%Y') as stanggal",FALSE)
					 ->select("date_format(k.tanggal_akhir,'%d/%m/%Y') as etanggal",FALSE)
					 ->from('tr_kontrak k')
					 ->where(array('k.id'=>$id));
			$q = $this->db->get();
			$data =  $q->row_array();
		}

		$this->db->select('r.kode_rekanan, r.nama')
					->from('mst_rekanan r');
		$q = $this->db->get();
		$data['rekanans'] = $q->result_array();
		
		return $data;
	}

	function get_optional_rekanan($id) {
		$this->db->select('r.kode_rekanan, r.nama')
					->from('mst_rekanan r');
					$q = $this->db->get();
		if(isset($id)) {
			return $q->row_array();
		}else{ 
			return $q->result_array();
		}
		
	}	
	
	function get_termin_detail($id) {
		//get data kontrak
		$this->db->select('k.*')
					 ->select("date_format(k.tanggal_sign,'%d/%m/%Y') as xtanggal",FALSE)
					 ->select("date_format(k.tanggal_mulai,'%d/%m/%Y') as stanggal",FALSE)
					 ->select("date_format(k.tanggal_akhir,'%d/%m/%Y') as etanggal",FALSE)
					 ->from('tr_kontrak k')
					 ->where(array('k.id'=>$id));
		$q = $this->db->get();
		$data = $q->row_array();

		$no_kontrak = $data['no_kontrak'];
		$kode_rekanan = $data['kode_rekanan'];

		//get data rekanan
		$this->db->select('rk.kode_rekanan, rk.nama')
				 ->from('mst_rekanan rk')
				 ->where(array('rk.kode_rekanan'=>$kode_rekanan));
		$q = $this->db->get();
		$data['rekanans'] = $q->result_array();

		//get data termin
		$this->db->select('kt.*')
			->from('tr_kontrak_termin kt')
			->where(array('kt.no_kontrak'=>$no_kontrak));
		$q = $this->db->get();
		$data['termins'] = $q->result_array();

		return $data;
		//var_dump($data);
		//die;
	}

	public function _insert($data) {
		$trKontrak = array(
						'kode_entity' 	=> $this->session->userdata('kode_entity'),
						'no_kontrak' 	=> $data['no_kontrak'],
						'jenis_kontrak' => $data['jenis_kontrak'],
						'nilai_kontrak' => $data['nilai_kontrak'],
						'tanggal_sign' 	=> $data['tanggal_sign'],
						'tanggal_mulai' => $data['tanggal_mulai'],
						'tanggal_akhir' => $data['tanggal_akhir'],
						'kode_rekanan' 	=> $data['kode_rekanan'],
						'jenis_retensi' => $data['jenis_retensi'],
						'retensi' 		=> $data['retensi'],
						'jenis_termin' 	=> $data['jenis_termin'],
						'jumlah_termin'	=> $data['jumlah_termin']);
		$trKontrak['nilai_kontrak'] 	= str_replace(',', '', $trKontrak['nilai_kontrak']);
		$this->db->insert('tr_kontrak',$trKontrak);

		//termin pembayarannya
		$termins = $data['t_ke'];
		$termin_ke = $data['t_ke'];
		$pr_pk = $data['pr_pekerjaan'];
		$pr_tagih = $data['pr_penagihan'];
		$t_bayar = $data['t_rupiah'];
		foreach ($termins as $k => $v) {
			$trTermin = array(
							'no_kontrak'	=>$data['no_kontrak'],
							'termin_ke'		=>$termin_ke[$k],
							'pr_pkerjaan'	=>$pr_pk[$k],
							'pr_penagihan'	=>$pr_tagih[$k],
							'nilai_termin'	=>$t_bayar[$k] );
			$trTermin['nilai_termin'] = str_replace(',', '', $trTermin['nilai_termin']);
			$this->db->insert('tr_kontrak_termin', $trTermin);
		}

	}
	
	public function _update($data, $id) {

		$trKontrak = array(
						'kode_entity' 	=> $this->session->userdata('kode_entity'),
						'no_kontrak' 	=> $data['no_kontrak'],
						'jenis_kontrak' => $data['jenis_kontrak'],
						'nilai_kontrak' => $data['nilai_kontrak'],
						'tanggal_sign' 	=> $data['tanggal_sign'],
						'tanggal_mulai' => $data['tanggal_mulai'],
						'tanggal_akhir' => $data['tanggal_akhir'],
						'kode_rekanan' 	=> $data['kode_rekanan'],
						'jenis_retensi' => $data['jenis_retensi'],
						'retensi' 		=> $data['retensi'],
						'jenis_termin' 	=> $data['jenis_termin'],
						'jumlah_termin'	=> $data['jumlah_termin']);
		$trKontrak['nilai_kontrak'] 	= str_replace(',', '', $trKontrak['nilai_kontrak']);
		$this->db->where(array('id'=>$id));
		$this->db->update('tr_kontrak', $trKontrak);

		//delete dulu
		$this->db->where(array('no_kontrak'=>$data['no_kontrak']));
		$this->db->delete('tr_kontrak_termin');

		$termins = $data['t_ke'];
		$termin_ke = $data['t_ke'];
		$pr_pk = $data['pr_pekerjaan'];
		$pr_tagih = $data['pr_penagihan'];
		$t_bayar = $data['t_rupiah'];

		foreach ($termins as $k => $v) {
			$trTermin = array(
							'no_kontrak'	=>$data['no_kontrak'],
							'termin_ke'		=>$termin_ke[$k],
							'pr_pkerjaan'	=>$pr_pk[$k],
							'pr_penagihan'	=>$pr_tagih[$k],
							'nilai_termin'	=>$t_bayar[$k] );
			$trTermin['nilai_termin'] = str_replace(',', '', $trTermin['nilai_termin']);
			$this->db->insert('tr_kontrak_termin', $trTermin);
		}
		
	}
	
	public function _delete($id) {
		$this->db->where(array('id'=>$id));
		return $this->db->delete('tr_kontrak');
	}
		
}
	