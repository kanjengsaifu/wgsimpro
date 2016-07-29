<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPCLASS;

class Tr_tahap extends App {

	public function __construct() {
		parent::__construct();
		$this->load->library('datatables');
		$this->load->library('dateUtils');
		$this->load->library('strUtils');
		$this->load->model('tr_tahap_model');
	}

	public function form_rpt_ra_ri() {
		$data = array();
		$data['idmenu'] = 'rpt-ra-ri-form';
		$data['content'] = '../../tr_tahap/views/form';
		
		//$data['datacontent']['list_sumberdaya'] = $this->tr_rab_bl_model->get_sumberdaya();
		//$data['datacontent']['list_tahap'] = $this->tr_rab_bl_model->get_tahap(); 
		
		//$data['datacontent'] = $this->mst_entity_model->get_optional();
		$data['js'] = '../../tr_tahap/views/form_js';
		/*if($id!==FALSE) {
			$data['datajs'] = $this->tr_rab_bl_model->get($id);
		}*/
		$this->buildView($data);
	}

	public function rpt_form_periode($target) {
		$data['idmenu'] 				= 'rpt-'.$target;
		$data['content'] 				= '../../tr_tahap/views/v_form';
		$data['js'] 					= '../../tr_tahap/views/v_form_js';
		$data['datacontent']['target'] 	= $target;

		$this->buildView($data);
	}


	function rpt_tahaprari($periode=false)
	{
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$kdentity = $this->session->userdata('kode_entity');

		if($periode===FALSE || $divisi=false) {
			$this->rpt_form_periode('rari');
		} else {
			$data = array();
			$data['idmenu']                     = 'rpt-rari';
			$data['content']                    = '../../tr_tahap/views/v_tahap_rari';
			$data['js']                         = '../../tr_tahap/views/v_tahap_rari_js';
			//$data['datacontent']      			= $this->tr_tahap_model->genRaRiXls($periode,$kdentity);
			$data['datacontent']      			= $this->tr_tahap_model->genReportRaRi('BLBTL',$periode);
            //var_dump($data);die;
            $data['datacontent']['rowsa']       = 0;// $this->tr_tahap_model->get_saldoAwal_bukubesar($periode,'');
            $data['datacontent']['nama']        = $this->session->userdata('nama');
            list($b,$t) = explode('-',$periode);
            $data['datacontent']['periode']     = $this->strutils->strBulan($b).' '.$t;
            $data['datacontent']['peuriode']    = $periode;
            $data['datacontent']['kde_div']     = $div;
            $data['datacontent']['kawasan']     = $this->session->userdata('nama_entity');
            $this->buildView($data);
        }
    }

    function view_rari() {

    	$data['idmenu'] 		= 'rpt-rari-view';
    	$data['content'] 		= '../../tr_tahap/views/v_rari';
    	$data['js'] 			= '../../tr_tahap/views/v_rari_js'; 

    	$this->buildView($data);
    }

    function genDT($periode) {

		//$bln = $this->input->post('bln');
		//$thn = $this->input->post('thn');
		//$periode = $bln.'-'.$thn;
		//print_r($periode);
		//if($periode===FALSE)
		//	$periode = date('m-Y');
    	list($bln, $thn) = explode('-', $periode);
    	$bln = ltrim($bln, '0');
    	$periode = $thn.'-'.($bln+1).'-'.'01';
    	$kdentity = $this->session->userdata('kode_entity');
    	$this->datatables->select('*', FALSE)
    	->from("
    		(
    			SELECT
    			'BIAYA LANGSUNG' AS grup,
    			acc.kode_spk AS kode_spk,
    			thp.kode AS kode_item,
    			thp.nama AS nama_item,
    			sd.kode AS kode_sd,
    			sd.nama AS nama_sd,
    			bl.volume AS ra_vol,
    			bl.volume * hsd.harga_satuan AS ra_harga,
    			IFNULL(acc.volume, 0) AS ri_vol,
    			IFNULL(
    				SUM(

    					IF (
    						acc.dk = 'D',
    						acc.rupiah,
    						(acc.rupiah *- 1)
    						)
						),
						0
				) AS ri_harga
				FROM
					tr_rab_bl AS bl
				INNER JOIN mst_tahap AS thp ON thp.kode = bl.kode_tahap
					AND thp.kode_entity = bl.kode_entity
				INNER JOIN mst_sumberdaya AS sd ON sd.kode = bl.kode_sumberdaya
				INNER JOIN mst_harga_sumberdaya AS hsd ON hsd.kode_sumberdaya = sd.kode
					AND hsd.kode_entity = bl.kode_entity
				LEFT JOIN tr_accounting acc ON acc.kode_tahap = bl.kode_tahap
					AND acc.kode_sumberdaya = bl.kode_sumberdaya
					AND acc.kode_spk = bl.kode_entity
					AND acc.tanggal <= '2015-03-01'
					AND bl.kode_entity = '5WGA07'
				GROUP BY
					bl.kode_tahap,
					bl.kode_sumberdaya
				
				UNION ALL
				
				SELECT
				'BIAYA TIDAK LANGSUNG' AS grup,
				acc.kode_spk AS kode_spk,
				btl.kode_coa AS kode_item,
				coa.nama AS nama_item,
				btl.kode_sumberdaya AS kode_sd,
				sd.nama AS nama_sd,
				0 AS ra_vol,
				btl.harga AS ra_harga,
				0 AS ri_vol,
				IFNULL(
					SUM(

						IF (
							acc.dk = 'D',
							acc.rupiah,
							(acc.rupiah *- 1)
							)
				),
				0
				) AS ri_harga
				FROM
				tr_rab_btl AS btl
				LEFT JOIN mst_coa AS coa ON coa.kode = btl.kode_coa
				LEFT JOIN mst_sumberdaya AS sd ON sd.kode = btl.kode_sumberdaya
				LEFT JOIN tr_accounting AS acc ON acc.tanggal <= '2015-03-01'
				AND acc.kode_sumberdaya IS NOT NULL
				AND acc.kode_coa = btl.kode_coa
				AND acc.kode_sumberdaya = btl.kode_sumberdaya
				AND acc.kode_spk = btl.kode_entity
				AND btl.kode_entity = '5WGA07'
				GROUP BY
				btl.kode_coa,
				btl.kode_sumberdaya
				) AS tmp");
		//echo $this->db->last_query();die;
		echo $this->datatables->generate();
	}	


	public function genRaRiXls($tanggal,$kdentity) { 
	//	echo $kdentity;
		//echo $tanggal;

		$data = $this->tr_tahap_model->genRaRiXls($tanggal,$kdentity);
		if($data!==0) {
			$this->load->library('excel');
			$this->excel->setActiveSheetIndex(0);
			$row = 1;
	            // $objWorksheet->getActiveSheet()->getColumnDimension('A')->setWidth(100);
	            // $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
	            // $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
	            // $this->excel->getActiveSheet()->mergeCells('A1:D1');
	            // $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$allBorder = array('borders'=>array('allborders'=>array('style'=>PHPExcel_Style_border::BORDER_THIN)));
			$this->excel->getActiveSheet()->getStyle('A'.$row.':H'.($row+1))->applyFromArray($allBorder);
			$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
			$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
			$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(8);
			$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(18);
			$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(8);
			$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(18);
			$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(8);
			$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(18);
			$this->excel->getActiveSheet()->getRowDimension($row)->setRowHeight(15);
			$this->excel->getActiveSheet()->getStyle('A'.$row.':H'.($row+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('A'.$row.':H'.($row+1))->getFont()->setBold(true);
			$this->excel->getActiveSheet()->mergeCells('A'.$row.':A'.($row+1));
			$this->excel->getActiveSheet()->setCellValue('A'.$row, 'Tahap');
			$this->excel->getActiveSheet()->mergeCells('B'.$row.':B'.($row+1));
			$this->excel->getActiveSheet()->setCellValue('B'.$row, 'Sumberdaya');
			$this->excel->getActiveSheet()->mergeCells('C'.$row.':D'.$row);
			$this->excel->getActiveSheet()->setCellValue('C'.$row, 'Rencana Awal');
			$this->excel->getActiveSheet()->mergeCells('E'.$row.':F'.$row);
			$this->excel->getActiveSheet()->setCellValue('E'.$row, 'Realisasi');
			$this->excel->getActiveSheet()->mergeCells('G'.$row.':H'.$row);
			$this->excel->getActiveSheet()->setCellValue('G'.$row, 'Deviasi');
			$row++;
			$this->excel->getActiveSheet()->getRowDimension($row)->setRowHeight(15);
			$this->excel->getActiveSheet()->setCellValue('C'.$row, 'Vol');
			$this->excel->getActiveSheet()->setCellValue('D'.$row, 'Harga');
			$this->excel->getActiveSheet()->setCellValue('E'.$row, 'Vol');
			$this->excel->getActiveSheet()->setCellValue('F'.$row, 'Harga');
			$this->excel->getActiveSheet()->setCellValue('G'.$row, 'Vol');
			$this->excel->getActiveSheet()->setCellValue('H'.$row, 'Harga');
			$row++;
			$grup = '';
			$item = '';
			$totalD='';
			$totalF='';
			$totalH='';
			foreach($data as $v) {
				if($v['grup']!==$grup) {
					if($grup!=='') {
						$this->excel->getActiveSheet()->getStyle('A'.$row.':H'.$row)->applyFromArray($allBorder);
						$this->excel->getActiveSheet()->getRowDimension($row)->setRowHeight(15);
						$this->excel->getActiveSheet()->getStyle('A'.$row.':H'.$row)->getFont()->setBold(true);
						$this->excel->getActiveSheet()->getStyle('C'.$row.':H'.$row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

						$this->excel->getActiveSheet()->mergeCells('A'.$row.':B'.$row);
						$this->excel->getActiveSheet()->setCellValue('A'.$row, 'TOTAL '.$grup);

						$this->excel->getActiveSheet()->setCellValue('D'.$row, $Dtot[]=array_sum($totalD[$grup]));
						$this->excel->getActiveSheet()->setCellValue('F'.$row, $Ftot[]=array_sum($totalF[$grup]));
						$this->excel->getActiveSheet()->setCellValue('H'.$row, $Htot[]=array_sum($totalH[$grup]));
						$row++; $row++;
					}
					$this->excel->getActiveSheet()->getStyle('A'.$row.':H'.$row)->applyFromArray($allBorder);
					$this->excel->getActiveSheet()->getRowDimension($row)->setRowHeight(15);
					$this->excel->getActiveSheet()->getStyle('A'.$row.':H'.$row)->getFont()->setBold(true);
					$this->excel->getActiveSheet()->mergeCells('A'.$row.':B'.$row);
					$this->excel->getActiveSheet()->setCellValue('A'.$row, $v['grup']);
					$row++;
				}
				if($v['kode_item']!==$item) {
					$this->excel->getActiveSheet()->getStyle('A'.$row.':H'.$row)->applyFromArray($allBorder);
					$this->excel->getActiveSheet()->getRowDimension($row)->setRowHeight(15);
					$this->excel->getActiveSheet()->getStyle('A'.$row.':H'.$row)->getFont()->setBold(true);
					$this->excel->getActiveSheet()->mergeCells('A'.$row.':B'.$row);
					$this->excel->getActiveSheet()->setCellValue('A'.$row, $v['kode_item'].' - '.$v['nama_item']);
					$row++;
				}
				$this->excel->getActiveSheet()->getStyle('A'.$row.':H'.$row)->applyFromArray($allBorder);
				$this->excel->getActiveSheet()->getRowDimension($row)->setRowHeight(15);
				$this->excel->getActiveSheet()->setCellValue('A'.$row, '    '.$v['kode_sd']);
				$this->excel->getActiveSheet()->setCellValue('B'.$row, '    '.$v['nama_sd']);
				$this->excel->getActiveSheet()->getStyle('C'.$row.':H'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$this->excel->getActiveSheet()->getStyle('C'.$row.':H'.$row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
				$this->excel->getActiveSheet()->setCellValue('C'.$row, $v['ra_vol']);
				$this->excel->getActiveSheet()->setCellValue('D'.$row, $v['ra_harga']);
				$this->excel->getActiveSheet()->setCellValue('E'.$row, $v['ri_vol']);
				$this->excel->getActiveSheet()->setCellValue('F'.$row, $v['ri_harga']);
				$this->excel->getActiveSheet()->setCellValue('G'.$row, $v['ra_vol']-$v['ri_vol']);
				$this->excel->getActiveSheet()->setCellValue('H'.$row, $v['ra_harga']-$v['ri_harga']);
				$row++;
				$grup = $v['grup'];
				$item = $v['kode_item'];
				$totalD[$grup][]=$v['ra_harga'];
				$totalF[$grup][]=$v['ri_harga'];
				$totalH[$grup][]=$v['ra_harga']-$v['ri_harga'];
			}
			if($grup!=='') {
				$this->excel->getActiveSheet()->getStyle('A'.$row.':H'.$row)->applyFromArray($allBorder);
				$this->excel->getActiveSheet()->getRowDimension($row)->setRowHeight(15);
				$this->excel->getActiveSheet()->getStyle('A'.$row.':H'.$row)->getFont()->setBold(true);
				$this->excel->getActiveSheet()->getStyle('C'.$row.':H'.$row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
				$this->excel->getActiveSheet()->mergeCells('A'.$row.':B'.$row.'');
				$this->excel->getActiveSheet()->setCellValue('A'.$row, 'TOTAL '.$grup);
				$this->excel->getActiveSheet()->setCellValue('D'.$row, $Dtot[]=array_sum($totalD[$grup]));
				$this->excel->getActiveSheet()->setCellValue('F'.$row, $Ftot[]=array_sum($totalF[$grup]));
				$this->excel->getActiveSheet()->setCellValue('H'.$row, $Htot[]=array_sum($totalH[$grup]));
				$row++;
			}
			
			$this->excel->getActiveSheet()->getStyle('A'.$row.':H'.$row)->applyFromArray($allBorder);
			$this->excel->getActiveSheet()->getRowDimension($row)->setRowHeight(15);
			$this->excel->getActiveSheet()->mergeCells('A'.$row.':H'.$row.'');

			$row=$row+1;
			$this->excel->getActiveSheet()->getStyle('A'.$row.':H'.$row)->applyFromArray($allBorder);
			$this->excel->getActiveSheet()->getRowDimension($row)->setRowHeight(15);
			$this->excel->getActiveSheet()->getStyle('A'.$row.':H'.$row)->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('C'.$row.':H'.$row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$this->excel->getActiveSheet()->mergeCells('A'.$row.':B'.$row.'');
			$this->excel->getActiveSheet()->setCellValue('A'.$row, 'GRAND TOTAL');
			$this->excel->getActiveSheet()->setCellValue('D'.$row, array_sum($Dtot));
			$this->excel->getActiveSheet()->setCellValue('F'.$row, array_sum($Ftot));
			$this->excel->getActiveSheet()->setCellValue('H'.$row, array_sum($Htot));

	            $filename='Laporan Ra. vs Ri Tahap Pekerjaan - '.date('Y-m-d His').'.xls'; //save our workbook as this file name
	            header('Content-Type: application/vnd.ms-excel'); //mime type
	            header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
	            header('Cache-Control: max-age=0'); //no cache
	            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
	            $objWriter->save('php://output');
	        }
	    }
	/*    public function genRaRiXls($tanggal) {
	        $data = $this->tr_tahap_model->genRaRiXls($tanggal);
	        if($data!==0) {
	            $this->load->library('excel');
	            $this->excel->setActiveSheetIndex(0);
	            $row = 1;
	            // $objWorksheet->getActiveSheet()->getColumnDimension('A')->setWidth(100);
	            // $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
	            // $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
	            // $this->excel->getActiveSheet()->mergeCells('A1:D1');
	            // $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		    $allBorder = array('borders'=>array('allborders'=>array('style'=>PHPExcel_Style_border::BORDER_THIN)));
		    $this->excel->getActiveSheet()->getStyle('A'.$row.':H'.($row+1))->applyFromArray($allBorder);
		    $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		    $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
		    $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(8);
		    $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(18);
		    $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(8);
		    $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(18);
		    $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(8);
		    $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(18);
		    $this->excel->getActiveSheet()->getRowDimension($row)->setRowHeight(15);
	            $this->excel->getActiveSheet()->getStyle('A'.$row.':H'.($row+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		    $this->excel->getActiveSheet()->getStyle('A'.$row.':H'.($row+1))->getFont()->setBold(true);
	            $this->excel->getActiveSheet()->mergeCells('A'.$row.':A'.($row+1));
	            $this->excel->getActiveSheet()->setCellValue('A'.$row, 'Tahap');
	            $this->excel->getActiveSheet()->mergeCells('B'.$row.':B'.($row+1));
	            $this->excel->getActiveSheet()->setCellValue('B'.$row, 'Sumberdaya');
	            $this->excel->getActiveSheet()->mergeCells('C'.$row.':D'.$row);
	            $this->excel->getActiveSheet()->setCellValue('C'.$row, 'Rencana Awal');
	            $this->excel->getActiveSheet()->mergeCells('E'.$row.':F'.$row);
	            $this->excel->getActiveSheet()->setCellValue('E'.$row, 'Realisasi');
	            $this->excel->getActiveSheet()->mergeCells('G'.$row.':H'.$row);
	            $this->excel->getActiveSheet()->setCellValue('G'.$row, 'Deviasi');
	            $row++;
		    $this->excel->getActiveSheet()->getRowDimension($row)->setRowHeight(15);
	            $this->excel->getActiveSheet()->setCellValue('C'.$row, 'Vol');
	            $this->excel->getActiveSheet()->setCellValue('D'.$row, 'Harga');
	            $this->excel->getActiveSheet()->setCellValue('E'.$row, 'Vol');
	            $this->excel->getActiveSheet()->setCellValue('F'.$row, 'Harga');
	            $this->excel->getActiveSheet()->setCellValue('G'.$row, 'Vol');
	            $this->excel->getActiveSheet()->setCellValue('H'.$row, 'Harga');
		    $row++;
		    $grup = '';
		    $item = '';
		    foreach($data as $v) {
			if($v['grup']!==$grup) {
			    if($grup!=='') {
				$this->excel->getActiveSheet()->getStyle('A'.$row.':H'.$row)->applyFromArray($allBorder);
				$this->excel->getActiveSheet()->getRowDimension($row)->setRowHeight(15);
				$this->excel->getActiveSheet()->getStyle('A'.$row.':H'.$row)->getFont()->setBold(true);
				$this->excel->getActiveSheet()->mergeCells('A'.$row.':B'.$row);
			    	$this->excel->getActiveSheet()->setCellValue('A'.$row, 'TOTAL '.$grup);
				$row++; $row++;
			    }
			    $this->excel->getActiveSheet()->getStyle('A'.$row.':H'.$row)->applyFromArray($allBorder);
			    $this->excel->getActiveSheet()->getRowDimension($row)->setRowHeight(15);
			    $this->excel->getActiveSheet()->getStyle('A'.$row.':H'.$row)->getFont()->setBold(true);
			    $this->excel->getActiveSheet()->mergeCells('A'.$row.':B'.$row);
			    $this->excel->getActiveSheet()->setCellValue('A'.$row, $v['grup']);
			    $row++;
			}
			if($v['kode_item']!==$item) {
			    $this->excel->getActiveSheet()->getStyle('A'.$row.':H'.$row)->applyFromArray($allBorder);
			    $this->excel->getActiveSheet()->getRowDimension($row)->setRowHeight(15);
			    $this->excel->getActiveSheet()->getStyle('A'.$row.':H'.$row)->getFont()->setBold(true);
			    $this->excel->getActiveSheet()->mergeCells('A'.$row.':B'.$row);
			    $this->excel->getActiveSheet()->setCellValue('A'.$row, $v['kode_item'].' - '.$v['nama_item']);
			    $row++;
			}
			$this->excel->getActiveSheet()->getStyle('A'.$row.':H'.$row)->applyFromArray($allBorder);
			$this->excel->getActiveSheet()->getRowDimension($row)->setRowHeight(15);
			$this->excel->getActiveSheet()->setCellValue('A'.$row, '    '.$v['kode_sd']);
			$this->excel->getActiveSheet()->setCellValue('B'.$row, '    '.$v['nama_sd']);
			$this->excel->getActiveSheet()->getStyle('C'.$row.':H'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$this->excel->getActiveSheet()->getStyle('C'.$row.':H'.$row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$this->excel->getActiveSheet()->setCellValue('C'.$row, $v['ra_vol']);
			$this->excel->getActiveSheet()->setCellValue('D'.$row, $v['ra_harga']);
			$this->excel->getActiveSheet()->setCellValue('E'.$row, $v['ri_vol']);
			$this->excel->getActiveSheet()->setCellValue('F'.$row, $v['ri_harga']);
			$this->excel->getActiveSheet()->setCellValue('G'.$row, $v['ra_vol']-$v['ri_vol']);
			$this->excel->getActiveSheet()->setCellValue('H'.$row, $v['ra_harga']-$v['ri_harga']);
			$row++;
			$grup = $v['grup'];
			$item = $v['kode_item'];
		    }
		    if($grup!=='') {
			$this->excel->getActiveSheet()->getStyle('A'.$row.':H'.$row)->applyFromArray($allBorder);
			$this->excel->getActiveSheet()->getRowDimension($row)->setRowHeight(15);
			$this->excel->getActiveSheet()->getStyle('A'.$row.':H'.$row)->getFont()->setBold(true);
			$this->excel->getActiveSheet()->mergeCells('A'.$row.':B'.$row.'');
		    	$this->excel->getActiveSheet()->setCellValue('A'.$row, 'TOTAL '.$grup);
			$row++;
		    }
	            
	            $filename='Laporan Ra. vs Ri Tahap Pekerjaan - '.date('Y-m-d His').'.xls'; //save our workbook as this file name
	            header('Content-Type: application/vnd.ms-excel'); //mime type
	            header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
	            header('Cache-Control: max-age=0'); //no cache
	            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
	            $objWriter->save('php://output');
	        }
	    }
	 
	*/   
}