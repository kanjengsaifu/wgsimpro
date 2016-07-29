<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mst_harga_sumberdaya_model extends CI_Model {

	public function get_optional() {
		$this->db->select('*')
				 ->from('mst_sumberdaya');
		$q = $this->db->get();
		return $q->result_array();
	}	

	public function _insert($data) {
		return $this->db->insert('mst_harga_sumberdaya',$data);
	}
	
	public function _update($data, $id) {
		$this->db->where(array('id'=>$id));
		return $this->db->update('mst_harga_sumberdaya',$data);
	}
	
	public function _delete($id) {
		$this->db->where(array('id'=>$id));
		return $this->db->delete('mst_harga_sumberdaya');
	}
	
	public function cek_data($kode) {
		$this->db->from('mst_sumberdaya');
		$this->db->where(array('kode'=>$kode));
		$result = $this->db->get();
		$num=$result->num_rows();
		return $num;
		/*
		$this->db->where(array('id'=>$id));
		return $this->db->delete('mst_harga_sumberdaya');*/
	}
	
	public function loaddata($dataarray) {
		//echo count($dataarray);
		//print_r($dataarray);
		/*for ($i = 0; $i < count($dataarray); $i++) {
			//echo $i;
			echo $dataarray[1]['kode_entity'];
		}*/
		foreach($dataarray as $data){
			/*echo $data['kode_entity'];
			echo $data['kode_sumberdaya'];
			echo $data['harga_satuan'];*/
			 $dataa = array(
                'kode_entity' => $data['kode_entity'],
                'kode_sumberdaya' => $data['kode_sumberdaya'],
                'harga_satuan' => $data['harga_satuan'],
                'harga_satuan_review' => $data['harga_satuan_review']
            );
            //ini untuk menambahkan apakah dalam tabel sudah ada data yang sama
            //apabila data sudah ada maka data di-skip
            // saya contohkan kalau ada data nama yang sama maka data tidak dimasukkan
            //$this->db->where('nama', $this->input->post('nama'));            
            //if ($cek) {
                //$this->db->insert($this->table, $data);
				$this->db->insert('mst_harga_sumberdaya',$dataa);
			
		}
		/*
        for ($i = 0; $i < count($dataarray); $i++) {
            $dataa = array(
                'kode_entity' => $dataarray[$i]['kode_entity'],
                'kode_sumberdaya' => $dataarray[$i]['kode_sumberdaya'],
                'harga_satuan' => $dataarray[$i]['harga_satuan']
            );
            //ini untuk menambahkan apakah dalam tabel sudah ada data yang sama
            //apabila data sudah ada maka data di-skip
            // saya contohkan kalau ada data nama yang sama maka data tidak dimasukkan
            //$this->db->where('nama', $this->input->post('nama'));            
            //if ($cek) {
                //$this->db->insert($this->table, $data);
				$this->db->insert('mst_harga_sumberdaya',$dataa);
				
			$i++;
				//var_dump(exit);
            //}
        }*/
	}

}