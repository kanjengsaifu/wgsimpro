<title>Sample</title>
<body>
	<?php
 	//]=var_dump($td);
 	//foreach ($td as $k => $v) {
 	//	echo ($k+1).' '.$v['uid'].', '.$v['kode_divisi'].'<br>';
 	//}
 	?>
<form action="<?php echo site_url('import')?>" method="post" enctype="multipart/form-data" role="form">
        <input type="file" id="import" name="import"></td>
        <input type="submit"  value="Import" name="save" /></td>         
 
</form>
		<table>
			<tr>
				<th>KODE DIVISI</th>
				<th>TANGGAL</th>
				<th>NO BUKTI</th>
				<th>NO TERBIT</th>
				<th>KODE COA</th>
				<th>KODE NASABAH</th>
				<th>KODE SUMBERDAYA</th>
				<th>KODE SPK</th>
				<th>KODE TAHAP</th>
				<th>NO INVOICE</th>
				<th>KOFR FAKTUR</th>
				<th>BUKTI POTONG</th>
				<th>VOLUME</th>
				<th>DESKRIPSI</th>
				<th>D/K</th>
				<th>RUPIAH</th>
				<th>IS BALANCE?</th>
			</tr>
<?php
		$CI = &get_instance();
		$this->load->helper('combo');

		for ($row = 4; $row <= $highestRow; $row++) {

            //  Read a row of data into an array
            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, 
            NULL, TRUE, FALSE);

            $tglExcel = date('Y-m-d',PHPExcel_Shared_Date::ExcelToPHP($rowData[0][1])); 
            $tgl_sys = str_replace('--', '', tgl_tosystem($tglExcel));
            
            foreach($rowData[0] as $k=>$v){
               // echo "Row: ".$row."- Col: ".($k+1)." = ".$v."<br />";
                $data = array(
                        "uid"               => 'chairul',
                        "kode_divisi"       => $rowData[0][0],
                        "tanggal"           => ($rowData[0][1]==NULL?NULL:$tgl_sys),
                        "no_bukti"          => $rowData[0][2],
                        "no_terbit"         => $rowData[0][3],
                        "kode_coa"          => $rowData[0][4],
                        "kode_nasabah"      => $rowData[0][5],
                        "kode_sumberdaya"   => $rowData[0][6],
                        "kode_spk"          => $rowData[0][7],
                        "kode_tahap"        => $rowData[0][8],
                        "no_invoice"        => $rowData[0][9],
                        "kode_faktur"       => $rowData[0][10],
                        "bukti_potong"      => $rowData[0][11],
                        "volume"            => $rowData[0][12],
                        "uraian"            => $rowData[0][13],
                        "dk"                => $rowData[0][14],
                        "rupiah"            => $rowData[0][15]
                );
			$tbl = "<tr>";
				$tbl .= '<td>'.$rowData[0][0].'</td>';
				$tbl .= '<td>'.($rowData[0][1]==NULL?NULL:$tgl_sys).'</td>';
				$tbl .= '<td>'.(cek_NoBuktiExist($rowData[0][2])==false?'<input type="hidden" id="nobuk_false[]" class="nobuk_false" value="1">':'<input type="hidden" id="nobuk_true[]" value="1">').($rowData[0][2]==null?'False':$rowData[0][2]).'</td>';
				$tbl .= '<td>'.$rowData[0][3].'</td>';
				$tbl .= '<td>'.$rowData[0][4].'</td>';
				$tbl .= '<td>'.(mand_Nasabah($rowData[0][4],$rowData[0][5])==false?'<input type="hidden" id="mnas_false[]" class="mnas_false" value="1">':'<input type="hidden" id="mnas_true[]" value="1">').($rowData[0][5]==null?'False':$rowData[0][5]).'</td>';
				$tbl .= '<td>'.(mand_Sbdy($rowData[0][4],$rowData[0][6])==false?'<input type="hidden" id="msbd_false[]" class="msbd_false" value="1">':'<input type="hidden" id="msbd_true[]" value="1">').($rowData[0][6]==null?'False':$rowData[0][6]).'</td>';
				$tbl .= '<td>'.$rowData[0][7].'</td>';
				$tbl .= '<td>'.(mand_Tahap($rowData[0][4],$rowData[0][8])==false?'<input type="hidden" id="mtahap_false[]" class="mtahap_false" value="1">':'<input type="hidden" id="mtahap_true[]" value="1">').($rowData[0][8]==null?'False':$rowData[0][8]).'</td>';
				$tbl .= '<td>'.$rowData[0][9].'</td>';
				$tbl .= '<td>'.(mand_Pajak($rowData[0][4],$rowData[0][10])==false?'<input type="hidden" id="mpajak_false[]" class="mpajak_false" value="1">':'<input type="hidden" id="mpajak_true[]" value="1">').($rowData[0][10]==null?'False':$rowData[0][10]).'</td>';
				$tbl .= '<td>'.$rowData[0][11].'</td>';
				$tbl .= '<td>'.$rowData[0][12].'</td>';
				$tbl .= '<td>'.$rowData[0][13].'</td>';
				$tbl .= '<td>'.$rowData[0][14].'</td>';
				$tbl .= '<td>'.$rowData[0][15].'</td>';
				$tbl .= '<td>'.(cek_IsBalance($rowData[0][2],$rowData[0][15],$rowData[0][14])).'</td>';
			$tbl .='</tr>';
	            try 
	            {
	                //$this->db->insert("tr_accounting_upload",$data);
	                //var_dump($data);
	              $data['batch'] = $data;
	            }catch(Exception $e){
	                die('Error : '.$e->getMessage());
	            }
        	}
        	
        	echo $tbl;
        	
        }
        
        ?>
    </table>
    <!-- jQuery -->
    <script type="text/javascript" src="<?=base_url()?>assets/vendor/jquery/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="<?=base_url()?>assets/vendor/jquery/jquery_ui/jquery-ui.min.js"></script>
    <script type="text/javascript">
    	jQuery(document).ready(function() {
    		
    		var t_mnas = 0;
    		var t_tahap =0; 
    		var t_sbd =0; 
    		var t_pajak =0; 
    		var t_bank = 0;
		    $('.mnas_false').each(function (index, element) {
		        t_mnas = t_mnas + parseFloat($(element).val());
		    });
		    $('.mtahap_false').each(function (index, element) {
		        t_tahap = t_tahap + parseFloat($(element).val());
		    });
		    alert('Kolom yang tak dapat diproses adalah Kode Nasabah:'+t_mnas+' error, Kode Tahap: '+t_tahap+' error');
		   
		});
    </script>
</body>
</html>