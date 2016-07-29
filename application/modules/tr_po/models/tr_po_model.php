<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tr_po_model extends CI_Model {
	
	public function get($id = FALSE, $filter = FALSE) {
		if($id==FALSE) {
			$this->db->select('po.*')
					 ->select("date_format(po.tanggal,'%d/%m/%Y') as xtanggal",FALSE)
					 ->from('tr_po po');
			$q = $this->db->get();
			return $q->result_array();
		} else {
			$this->db->select('po.*')
					 ->select("date_format(po.tanggal,'%d/%m/%Y') as xtanggal",FALSE)
					 ->from('tr_po po')
					 ->where(array('po.id'=>$id));
			$q = $this->db->get();
			return $q->row_array();
		}
	}
	
	public function report_persediaan($from,$to){
		$sql = "
			SELECT 
				kode,nama,satuan, volume_in,
				(volume_in * harga_in) as harga_in,
				volume_out, 
				(volume_out*(( volume_in * harga_in)/volume_in)) as harga_out,
				(volume_in-volume_out) as volume_sisa, 
				(volume_in * harga_in)-(volume_out*(( volume_in * harga_in)/volume_in)) as harga_sisa,
				((volume_in * harga_in)-(volume_out*(( volume_in * harga_in)/volume_in))/(volume_in-volume_out)) as harga_rata
				FROM(
					SELECT
						sd.kode, sd.nama, sd.satuan, 
						(
							SELECT 
								sum(bapb.volume) 
							FROM tr_bapb_detail bapb 
							LEFT JOIN tr_bapb bp ON bp.id = bapb.bapb_id
							WHERE bapb.kode_sumberdaya = sd.kode AND
									  bp.tanggal BETWEEN '{$from}' AND '{$to}'
						 ) as volume_in,
						 (
							SELECT 
								sum(bapb.harga_satuan) 
							FROM tr_bapb_detail bapb 
							LEFT JOIN tr_bapb bp ON bp.id = bapb.bapb_id
							WHERE bapb.kode_sumberdaya = sd.kode AND
									  bp.tanggal BETWEEN '{$from}' AND '{$to}'
						 ) as harga_in,
						 (
							SELECT 
								sum(bpm.volume) 
							FROM tr_bpm_detail bpm 
							LEFT JOIN tr_bpm bm ON bm.id = bpm.bpm_id
							WHERE bpm.kode_sumberdaya = sd.kode AND
									  bm.tanggal BETWEEN '{$from}' AND '{$to}'
						 ) as volume_out,
						 (
							SELECT 
								sum(bpm.harga_satuan) 
							FROM tr_bpm_detail bpm 
							LEFT JOIN tr_bpm bm ON bm.id = bpm.bpm_id
							WHERE bpm.kode_sumberdaya = sd.kode AND
									  bm.tanggal BETWEEN '{$from}' AND '{$to}'
						 ) as harga_out
					FROM mst_sumberdaya sd
				) sbd
			";
		$q = $this->db->query($sql);
		return $q->result_array();
	}
	
	public function report_po($from,$to){
		$sql = "SELECT 
					a.no_kontrak,a.kdnasabah,d.nama,
				  	c.no_bapb,date_format(a.tanggal,'%d/%m/%Y') as tanggal,
				  	b.volume, b.harga_satuan
				FROM tr_po a
				LEFT JOIN tr_po_sumberdaya b ON b.po_id = a.id
				LEFT JOIN tr_bapb c ON c.no_kontrak = a.no_kontrak
				LEFT JOIN mst_nasabah_konstruksi d ON d.kode = a.kdnasabah 
				WHERE c.kode_entity = '".$this->session->userdata('kode_entity')."' AND a.tanggal BETWEEN '{$from}' AND '{$to}'";
		$q = $this->db->query($sql);
		return $q->result_array();
	}
	

	public function get_po_and_detail($id) {
		// po
		$this->db->select('po.*')
			->select("date_format(po.tanggal,'%d/%m/%Y') as xtanggal",FALSE)
			->from('tr_po po')
			->where(array('po.id'=>$id));
		$q = $this->db->get();
		$data = $q->row_array();

		// po - sumberdaya
		$this->db->select('posd.*, sd.nama')
			->from('tr_po_sumberdaya posd')
			->join('mst_sumberdaya sd', 'sd.kode = posd.kode_sumberdaya')
			->where(array('po_id'=>$id));
		$q = $this->db->get();
		$data['sumberdayas'] = $q->result_array();

		// unit
		/*$this->db->select('no_unit, sd_id')
				->from('tr_po_units')
				->where(array('no_po'=>$id));
		$q = $this->db->get();
		$data['units'] = $q->result_array();*/
		

		return $data;
	}

	public function get_optional() {
		//nasabah
		$this->db->select('kode, nama')
				 ->from('mst_nasabah_konstruksi');
		$q = $this->db->get();
		$data['nasabahkon'] = $q->result_array();
		// bpdp
		$this->db->select('no_path, uraian')
				 ->from('tr_bpdp');
		$q = $this->db->get();
		$data['bpdps'] = $q->result_array();
		// rekanan
		$this->db->select('k.no_kontrak, r.nama')
				 ->from('tr_kontrak k')
				 ->join('mst_rekanan r', 'r.kode_rekanan = k.kode_rekanan')
				 ->where(array('kode_entity'=>$this->session->userdata('kode_entity')));
		$q = $this->db->get();
		$data['kontraks'] = $q->result_array();
		// sumberdaya
		$this->db->select('s.kode, s.nama, IFNULL(sh.harga_satuan, 0) AS harga_satuan', FALSE)
				 ->from('mst_sumberdaya s')
				 ->join('mst_harga_sumberdaya sh', 'sh.kode_sumberdaya = s.kode AND sh.kode_entity = "'.$this->session->userdata('kode_entity').'"', 'left');
		$q = $this->db->get();
		$data['sumberdayas'] = $q->result_array();
		// unit
		$this->db->select('no_unit')
				 ->from('mst_stock')
				 ->where(array('kode_entity'=>$this->session->userdata('kode_entity')));
		$q = $this->db->get();
		$data['stocks'] = $q->result_array();
		//rekanan
		$this->db->select('r.kode_rekanan, r.nama')
					->from('mst_rekanan r');
		$q = $this->db->get();
		$data['rekanans'] = $q->result_array();


		return $data;
	}	
	
	function tambah_unit($data)
	{
		foreach ($data['nounit'] as $k => $v) {
			$dataUnit = array(
				'sd_id'			=>$data['sdid'],
				'no_po'			=>$data['sdpo'],
				'kode_entity'	=>$this->session->userdata('kode_entity'),
				'no_unit'		=>$v
			);
			$this->db->insert('tr_po_units', $dataUnit);
		}
	}

	public function _insert($data) {
		// po
		$dataPO = array(
			'tanggal'		=>$data['tanggal'],
			'no_kontrak'	=>$data['no_kontrak'],
			'kdnasabah'		=>$data['kd_nasabah'],
			'ppn'			=>isset($data['ppn'])?$data['ppn']:0,
			'pph'			=>isset($data['pph'])?$data['pph']:0,
			'kode_entity'	=>$this->session->userdata('kode_entity'),
			'flag'			=>$data['flag'],
			'status' 		=>0
		);
		$this->db->insert('tr_po',$dataPO);
		$po_id = $this->db->insert_id();

		$sumberdayas = $data['kode_sumberdaya'];
		$hargas = $data['harga_satuan'];
		$volumes = $data['volume'];
		foreach ($sumberdayas as $k => $v) {
			$dataPOSD = array(
				'po_id'					=>$po_id,
				'kode_sumberdaya'		=>$v,
				'harga_satuan'			=>$hargas[$k],
				'volume'				=>$volumes[$k]
			);
			$dataPOSD['volume'] 		= str_replace(',', '', $dataPOSD['volume']);
			$dataPOSD['harga_satuan'] 	= str_replace(',', '', $dataPOSD['harga_satuan']);
			$this->db->insert('tr_po_sumberdaya',$dataPOSD);
		}

	}

	public function _update($data, $id) {
		// po
		$dataPO = array(
			'tanggal'			=>$data['tanggal'],
			'no_po'				=>$data['no_po'],
			'kode_bpdp'			=>$data['kode_bpdp'],
			'is_pkp'			=>isset($data['is_pkp'])?$data['is_pkp']:0,
			'is_order'			=>isset($data['is_order'])?$data['is_order']:0,
			'kode_entity'		=>$data['kode_entity'],
			//'no_unit'=>$data['no_unit'],
			'kode_spk'			=>$data['kode_spk']
		);

		$this->db->where(array('id'=>$id));
		$this->db->update('tr_po',$dataPO);

		//var_dump($dataUnits);
		//delete unit
		//$this->db->where(array('no_po'=>$data['no_po'],'kode_entity'=>$data['kode_entity']));
		//$this->db->delete('tr_po_units');
		//insert ulang unit
		//$this->db->insert('tr_po_units', $dataUnits);
		
		
		
		// po - sumberdaya
		// delete existing
		//$this->db->where(array('no_po'=>$data['no_po']));
		//$this->db->delete('tr_po_sumberdaya');
		// build new
		$sumberdayas 	= $data['kode_sumberdaya'];
		$hargas 		= $data['harga_satuan'];
		$volumes 		= $data['volume'];
		$units 			= $data['nounit'];
		foreach ($sumberdayas as $k => $v) {
			$dataPOSD = array(
				'no_po'				=>$data['no_po'],
				'po_id'				=>$id,
				'kode_sumberdaya'	=>$v,
				'harga_satuan'		=>$hargas[$k],
				'volume'			=>$volumes[$k],
				'no_unit'			=>$units[$k]
			);
			$dataPOSD['volume'] = str_replace(',', '', $dataPOSD['volume']);
			$dataPOSD['harga_satuan'] = str_replace(',', '', $dataPOSD['harga_satuan']);
			$this->db->insert('tr_po_sumberdaya',$dataPOSD);
		}

		// po - unit
		//cari parent id sumberdaya
		
		$this->db->select('id, po_id')
				 ->from('tr_po_sumberdaya')
				 ->where(array('no_po'=>$data['no_po']));
		$q = $this->db->get();
		$res = $q->row();
		$sd_id = $res->id;
		// delete existing
		$this->db->where(array('no_po'=>$data['no_po']));
		$this->db->delete('tr_po_units');
		// build new
		$units = $data['no_unit'];
		$hargas = $data['harga_satuan'];
		$volumes = $data['volume'];
		foreach ($units as $k => $v) {
			$dataUNIT = array(
				'sd_id'			=>$sd_id,
				'no_po'			=>$data['no_po'],
				'kode_entity'	=>$data['kode_entity'],
				'no_unit'		=>$v
			);
			$this->db->insert('tr_po_units',$dataUNIT);
		}
		
	}

	public function _delete($id) {
		// get info
		$q = $this->db->get_where('tr_po', array('id'=>$id));
		$res = $q->row_array();
		// delete detail
		$this->db->where(array('no_po'=>$res['no_po'], 'kode_entity'=>$res['kode_entity'], 'kode_bpdp'=>$res['kode_bpdp']));
		$this->db->delete('tr_po_sumberdaya');
		// delete po
		$this->db->where(array('id'=>$id));
		return $this->db->delete('tr_po');
	}

	public function genNoUnitEdit()
	{
		// unit
		$this->db->select('no_unit')
				 ->from('mst_stock')
				 ->where(array('kode_entity'=>$this->session->userdata('kode_entity')));
		return $q = $this->db->get();
	}
	public function getUnit_BySDID($sdid)
	{
		$this->db->select('*')
				 ->from('tr_po_units')
				 ->where(array('sd_id'=>$sdid));
		return $q = $this->db->get();
	}

	function deltUnit_byID($id)
	{
		$this->db->where(array('id'=>$id));
		return $this->db->delete('tr_po_sumberdaya');
	}
		
}

?>