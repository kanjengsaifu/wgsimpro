<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Laporan extends CI_Controller{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('laporan_model');
	}

	function index()
	{
		$this->load->view('myindex');
	}

	function genbukbes(){
		echo '<table id="example" class="table table-bordered mbn">
						<thead>
							<tr class="bg-primary light">
								<th class="text-center">#</th>
								<th align="center">TANGGAL</th> 
								<th align="center">NO BUKTI</th>
								<th align="center">DESKRIPSI</th>
								<th align="center">DEBIT</th>
								<th align="center">KREDIT</th>
								<th align="center">SALDO</th>
							</tr>
						</thead>
						<tbody>';
		$this->load->helper('generator');
		echo tr_bukbes('11121','09-2015','V');
		echo '</tbody>
				</table>';
	}

	function test(){
		$xData = array();
		$string = '';$string2 = '';
		$br = '<br>';
		$num = array();
		$data = array(
			"01-01","02-01","03-01","05-01","07-01","08-01",
			"01-02","02-02","03-02","05-02","07-02","08-02",
			"01-03","02-03","03-03","05-03","07-03","08-03","10-03");
		$data2 = array(
			array(1=>'01-01', 2=>'02-01', 3=>'03-01', 5=>'05-01', 7=>'07-01', 8=>'08-01'),
			array(1=>'01-02', 2=>'02-02', 3=>'03-02', 5=>'05-02', 7=>'07-02', 8=>'08-02'),
			array(1=>'01-03', 2=>'02-03', 3=>'03-03', 5=>'05-03', 7=>'07-03', 8=>'08-03', 10=>'10-03')
			);
		//var_dump($data);x;
		foreach ($data as $k => $v) {
			$num = explode('-', $v); 
			//$value[] = $num[0].'=>'.$v.',';
			$string .= ' ,'.(int)$num[0]."=>'".$v."'";
		}
		foreach ($data2 as $k => $v) {
			foreach ($v as $kv => $vv) {
				$num = explode('-', $vv); 
				$string2 .= ', '.(int)$num[0]."=>'".$vv."'";
			}
			
		}
		$string2 = trim(substr($string2, 1));
		var_dump($string2);die;
		
		$string = substr($string, 1);
		echo $string.$br;die;
		$str = explode(',', $string);
		//var_dump(array($str));
		$arr = array(1=>'01-01', 2=>'02-01', 3=>'03-01', 5=>'05-01', 7=>'07-01', 8=>'08-01', 1=>'01-02', 2=>'02-02', 3=>'03-02', 5=>'05-02', 7=>'07-02', 8=>'08-02', 1=>'01-03', 2=>'02-03', 3=>'03-03', 5=>'05-03', 7=>'07-03', 8=>'08-03', 10=>'10-03');
		
		print_r($arr);
		echo '<table width="200px">'.
				'<tr>'.
				'	<th>Urut</th>'.
				'	<th>Ruang</th>'. 
				'</tr>'.
				'<tbody>';
		for($i=1;$i<=10;$i++){
			echo '<tr>'.
				 '	<td align="center">'.($i).'</td>'.
				 '	<td align="center">'.@($arr[$i]==''?'xxx':@$arr[$i]).'</td>'.
				 '</tr>';
		}
		echo '	  </tbody>'.
			 '</table>';
		
		
	}
		
	function coba(){
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$sql = "SELECT tower, lantai, urut, no_unit, status
				FROM tr_dashboard
				WHERE entity='5WPA01' 
				ORDER BY lantai ASC,urut ASC";
		$query=$this->db->query($sql);
		$res = $query->result_array();
		//var_dump($res[0]['urut']);
		
		$data = array();
		//for($i=0;$i<(32*7);$i++){
		$i = 1;
		$u = 1;
		foreach($res as $k => $v){
			//echo ($i+1).', '.$res[$i]['lantai'].'<br>';
			//echo $v['tower'].','.$v['lantai'].','.$v['urut'].','.$v['no_unit'].'<br>';
			$uu=1;
			foreach($v['no_unit'] as $uk => $uv){
				$du = array($uu=>$v['urut'], 'nomor'=>$uv);
			}
			/*$irul[] = array(
						array(
							'tower'		=>$v['tower'],//$res[$i]['tower'],
							'lantai'	=>$v['lantai'],//$res[$i]['lantai'],
							'unit'	=>
								/*array(
									$i	=>$v['urut'],//$res[$i]['urut'],
									'nomor'	=>$v['no_unit'],//$res[$i]['no_unit'],
									'status'=>$v['status'],//$res[$i]['status'],
								)*/
			/*					array($du)
						)
					);
			*/
			if($v['urut']==1){ $i=1;}
			$dt_unit[] = array(
							$i			=>$v['urut'],//$res[$i]['urut'],
							'urut'		=>$v['urut'],
							'tower'		=>$v['tower'],//$res[$i]['tower'],
							'lantai'	=>$v['lantai'],//$res[$i]['lantai'],
							'no_unit'	=>$v['no_unit'],//$res[$i]['no_unit'],
							'status'	=>$v['status'],//$res[$i]['status'],
						);
			$i++;
		}
		var_dump($dt_unit);die;
		/*$arr_unit = '';
		for($lan=0;$lan<2;$lan++){
			
			for($u_nit=0; $u_nit<32;$u_nit++){
				$arr_unit[] = array($u_nit=>$res[$u_nit]['no_unit'],'status'=>$res[$u_nit]['status']);
			
			}
				$units[] =	array(
							'tower' 	=> $res[$lan]['tower'],
							'lantai'	=> $res[$lan]['lantai'],
							'unit'		=>
								array($arr_unit)
							);
		}*/
		//print_r($dt_unit)."<br>";

		$sql = "SELECT tower_cluster as tower, lantai_blok as lantai, kavling, no_unit, urut 
				FROM mst_stock
				WHERE kode_entity='5WPA01' AND urut IS NOT NULL 
				ORDER BY urut ASC";
		$query=$this->db->query($sql);
		//$res = $query->result_array();
		//var_dump($res[0]['urut']);
		//foreach ($res as $k => $v) {
			//echo $v['urut'].' '.$v['no_unit'].'<br>';
		//}

		for($i=0;$i<32;$i++){
			if($res[$i]['urut']==($i+1)){
				//echo ($i+1).', '.$res[$i]['urut'].' - '.$res[$i]['no_unit'].'<br>';
			}else{
				//echo ($i+1).', ';
			}
		}
		//die;
		$data = array(
			array('id'=>1,'title'=>'Abrakadabra 1','tgl'=>'2015-01-01'),
			array('id'=>2,'title'=>'Abrakadabra 2','tgl'=>'2015-01-02'),
			array('id'=>3,'title'=>'Abrakadabra 3','tgl'=>'2015-01-03'),
			array('id'=>5,'title'=>'Abrakadabra 4','tgl'=>'2015-01-05'),
			array('id'=>6,'title'=>'Abrakadabra 5','tgl'=>'2015-01-06')
			);
		$data2 = array(
			array('tower'=>1,'lantai'=>1,'unit'=>'01-01'),
			array('tower'=>1,'lantai'=>1,'unit'=>'02-01'),
			array('tower'=>1,'lantai'=>1,'unit'=>'03-01'),
			array('tower'=>1,'lantai'=>1,'unit'=>'04-01'),
			array('tower'=>1,'lantai'=>1,'unit'=>'05-01'),
			array('tower'=>1,'lantai'=>1,'unit'=>'06-01'),
			array('tower'=>1,'lantai'=>1,'unit'=>'08-01'),
			array('tower'=>1,'lantai'=>1,'unit'=>'09-01'),
			array('tower'=>1,'lantai'=>1,'unit'=>'10-01'),
			array('tower'=>1,'lantai'=>1,'unit'=>'11-01'),
			array('tower'=>1,'lantai'=>1,'unit'=>'13-01'),
			array('tower'=>2,'lantai'=>2,'unit'=>'01-01'),
			array('tower'=>2,'lantai'=>2,'unit'=>'02-01'),
			array('tower'=>2,'lantai'=>2,'unit'=>'03-01'),
			array('tower'=>2,'lantai'=>2,'unit'=>'04-01'),
			array('tower'=>2,'lantai'=>2,'unit'=>'05-01'),
			array('tower'=>2,'lantai'=>2,'unit'=>'06-01'),
			array('tower'=>2,'lantai'=>2,'unit'=>'08-01'),
			array('tower'=>2,'lantai'=>2,'unit'=>'09-01'),
			array('tower'=>2,'lantai'=>2,'unit'=>'10-01'),
			array('tower'=>2,'lantai'=>2,'unit'=>'11-01'),
			array('tower'=>2,'lantai'=>2,'unit'=>'13-01'),
			);
		$datax = array(
				array(
					array('tower'=>1,'lantai'=>1,'unit'=>'01-01','urut'=>1),
					array('tower'=>1,'lantai'=>1,'unit'=>'02-01','urut'=>2),
					array('tower'=>1,'lantai'=>1,'unit'=>'03-01','urut'=>3),
					array('tower'=>1,'lantai'=>1,'unit'=>'04-01','urut'=>4),
					array('tower'=>1,'lantai'=>1,'unit'=>'05-01','urut'=>5),
					array('tower'=>1,'lantai'=>1,'unit'=>'06-01','urut'=>6),
					array('tower'=>1,'lantai'=>1,'unit'=>'08-01','urut'=>8),
					array('tower'=>1,'lantai'=>1,'unit'=>'09-01','urut'=>9),
					array('tower'=>1,'lantai'=>1,'unit'=>'10-01','urut'=>10),
					array('tower'=>1,'lantai'=>1,'unit'=>'11-01','urut'=>11),
					array('tower'=>1,'lantai'=>1,'unit'=>'13-01','urut'=>13),

					array('tower'=>1,'lantai'=>2,'unit'=>'01-02','urut'=>1),
					array('tower'=>1,'lantai'=>2,'unit'=>'02-02','urut'=>2),
					array('tower'=>1,'lantai'=>2,'unit'=>'03-02','urut'=>3),
					array('tower'=>1,'lantai'=>2,'unit'=>'04-02','urut'=>4),
					array('tower'=>1,'lantai'=>2,'unit'=>'05-02','urut'=>5),
					array('tower'=>1,'lantai'=>2,'unit'=>'06-02','urut'=>6),
					array('tower'=>1,'lantai'=>2,'unit'=>'08-02','urut'=>8),
					array('tower'=>1,'lantai'=>2,'unit'=>'09-02','urut'=>9),
					array('tower'=>1,'lantai'=>2,'unit'=>'10-02','urut'=>10),
					array('tower'=>1,'lantai'=>2,'unit'=>'11-02','urut'=>11),
					array('tower'=>1,'lantai'=>2,'unit'=>'13-02','urut'=>13)
					),

				array(
					array('tower'=>2,'lantai'=>1,'unit'=>'01-01','urut'=>1),
					array('tower'=>2,'lantai'=>1,'unit'=>'02-01','urut'=>2),
					array('tower'=>2,'lantai'=>1,'unit'=>'03-01','urut'=>3),
					array('tower'=>2,'lantai'=>1,'unit'=>'04-01','urut'=>4),
					array('tower'=>2,'lantai'=>1,'unit'=>'05-01','urut'=>5),
					array('tower'=>2,'lantai'=>1,'unit'=>'06-01','urut'=>6),
					array('tower'=>2,'lantai'=>1,'unit'=>'08-01','urut'=>8),
					array('tower'=>2,'lantai'=>1,'unit'=>'09-01','urut'=>9),
					array('tower'=>2,'lantai'=>1,'unit'=>'10-01','urut'=>10),
					array('tower'=>2,'lantai'=>1,'unit'=>'11-01','urut'=>11),
					array('tower'=>2,'lantai'=>1,'unit'=>'13-01','urut'=>13),

					array('tower'=>2,'lantai'=>2,'unit'=>'01-02','urut'=>1),
					array('tower'=>2,'lantai'=>2,'unit'=>'02-02','urut'=>2),
					array('tower'=>2,'lantai'=>2,'unit'=>'03-02','urut'=>3),
					array('tower'=>2,'lantai'=>2,'unit'=>'04-02','urut'=>4),
					array('tower'=>2,'lantai'=>2,'unit'=>'05-02','urut'=>5),
					array('tower'=>2,'lantai'=>2,'unit'=>'06-02','urut'=>6),
					array('tower'=>2,'lantai'=>2,'unit'=>'08-02','urut'=>8),
					array('tower'=>2,'lantai'=>2,'unit'=>'09-02','urut'=>9),
					array('tower'=>2,'lantai'=>2,'unit'=>'10-02','urut'=>10),
					array('tower'=>2,'lantai'=>2,'unit'=>'11-02','urut'=>11),
					array('tower'=>2,'lantai'=>2,'unit'=>'13-02','urut'=>13)
					),

				/*array(
					array('tower'=>3,'lantai'=>1,'unit'=>'01-01','urut'=>1),
					array('tower'=>3,'lantai'=>1,'unit'=>'02-01','urut'=>2),
					array('tower'=>3,'lantai'=>1,'unit'=>'03-01','urut'=>3),
					array('tower'=>3,'lantai'=>1,'unit'=>'04-01','urut'=>4),
					array('tower'=>3,'lantai'=>1,'unit'=>'05-01','urut'=>5),
					array('tower'=>3,'lantai'=>1,'unit'=>'06-01','urut'=>6),
					array('tower'=>3,'lantai'=>1,'unit'=>'08-01','urut'=>8),
					array('tower'=>3,'lantai'=>1,'unit'=>'09-01','urut'=>9),
					array('tower'=>3,'lantai'=>1,'unit'=>'10-01','urut'=>10),
					array('tower'=>3,'lantai'=>1,'unit'=>'11-01','urut'=>11),
					array('tower'=>3,'lantai'=>1,'unit'=>'13-01','urut'=>13),

					array('tower'=>3,'lantai'=>2,'unit'=>'01-02','urut'=>1),
					array('tower'=>3,'lantai'=>2,'unit'=>'02-02','urut'=>2),
					array('tower'=>3,'lantai'=>2,'unit'=>'03-02','urut'=>3),
					array('tower'=>3,'lantai'=>2,'unit'=>'04-02','urut'=>4),
					array('tower'=>3,'lantai'=>2,'unit'=>'05-02','urut'=>5),
					array('tower'=>3,'lantai'=>2,'unit'=>'06-02','urut'=>6),
					array('tower'=>3,'lantai'=>2,'unit'=>'08-02','urut'=>8),
					array('tower'=>3,'lantai'=>2,'unit'=>'09-02','urut'=>9),
					array('tower'=>3,'lantai'=>2,'unit'=>'10-02','urut'=>10),
					array('tower'=>3,'lantai'=>2,'unit'=>'11-02','urut'=>11),
					array('tower'=>3,'lantai'=>2,'unit'=>'13-02','urut'=>13),

					array('tower'=>3,'lantai'=>3,'unit'=>'01-03','urut'=>1),
					array('tower'=>3,'lantai'=>3,'unit'=>'02-03','urut'=>2),
					array('tower'=>3,'lantai'=>3,'unit'=>'03-03','urut'=>3),
					array('tower'=>3,'lantai'=>3,'unit'=>'04-03','urut'=>4),
					array('tower'=>3,'lantai'=>3,'unit'=>'05-03','urut'=>5),
					array('tower'=>3,'lantai'=>3,'unit'=>'06-03','urut'=>6),
					array('tower'=>3,'lantai'=>3,'unit'=>'08-03','urut'=>8),
					array('tower'=>3,'lantai'=>3,'unit'=>'09-03','urut'=>9),
					array('tower'=>3,'lantai'=>3,'unit'=>'10-03','urut'=>10),
					array('tower'=>3,'lantai'=>3,'unit'=>'12-03','urut'=>12),
					array('tower'=>3,'lantai'=>3,'unit'=>'13-03','urut'=>13)
					)*/
				);
		//print_r($datax[0][0]);
		$unit = array(
					array(
						'tower'=>1,
						'lantai'=>1,
						'unit'=>
						array(
							1=>'01-01','status'=>0,
							2=>'02-01','status'=>0,
							3=>'03-01','status'=>0,
							4=>'04-01','status'=>0,
							5=>'05-01','status'=>1,
							6=>'06-01','status'=>0,
							8=>'08-01','status'=>3,
							9=>'09-01','status'=>0,
							10=>'10-01','status'=>2,
							12=>'12-01','status'=>0,
							13=>'13-01','status'=>0
						)
					),
					array(
						'tower'=>2,
						'lantai'=>1,
						'unit'=>
						array(
							1=>'01-01','status'=>0,
							2=>'02-01','status'=>0,
							3=>'03-01','status'=>0,
							4=>'04-01','status'=>0,
							5=>'05-01','status'=>1,
							6=>'06-01','status'=>0,
							8=>'08-01','status'=>3,
							9=>'09-01','status'=>0,
							10=>'10-01','status'=>2,
							12=>'12-01','status'=>0,
							13=>'13-01','status'=>0
						)
					),
					array(
						'tower'=>2,
						'lantai'=>2,
						'unit'=>
							array(
								1=>'01-02','status'=>1,
								2=>'02-02','status'=>0,
								3=>'03-02','status'=>0,
								4=>'04-02','status'=>0,
								5=>'05-02','status'=>0,
								6=>'06-02','status'=>0,
								8=>'08-02','status'=>0,
								9=>'09-02','status'=>0,
								10=>'10-02','status'=>1,
								12=>'12-02','status'=>0,
								13=>'13-02','status'=>2
							),
					),
					array(
						'tower'=>2,
						'lantai'=>3,
						'unit'=>
							array(
								1=>'01-03','status'=>0,
								2=>'02-03','status'=>0,
								3=>'03-03','status'=>0,
								4=>'04-03','status'=>0,
								5=>'05-03','status'=>0,
								6=>'06-03','status'=>0,
								7=>'08-03','status'=>0,
								9=>'09-03','status'=>0,
								11=>'10-03','status'=>0,
								12=>'12-03','status'=>0,
								13=>'13-03','status'=>1
							),
					)
				);
		
		$arr1 = array(
			1,2,3,5,6,8,9,12,14,15,16);
		//print_r($arr1);
		//echo '<br>';
		for($i=1;$i<17;$i++){
			//if($p==$arr1[$i]){
				//echo $i.', =>'.($arr1[$i]==($i-1)?$arr1[$i]:$arr1[$i]).'<br>';
			//}else{
			//	echo $i.'<br>';
			//}
		}
		
	    $sql = "SELECT tower, lantai, urut, no_unit, jenis FROM tr_dashboard";
	    $q = $this->db->query($sql);
	    $res = $q->result_array();
	    $data = array();

		$tabl ='
			<table style="border:1px solid #000;padding:10px;">
		    <thead>
		        <tr>';
		            
		            $tabl .= '<th width="100px">Tower xx</th>';
		            for($l=1;$l<=2 ;$l++){
						//echo 'Lantai: '.$unit[$l]['lantai'].'<br>';
						$tabl .= '<th> Lt.'.($l).'</th>';		
					}
		$tabl .= '	            
			        </tr>
			     </thead>
			     <tbody>'; 
			     	$tw=1;
			     	//for($tw=1; $tw<=2; $tw++){
			     	while ($tw <=1){
			     	$tabl .='	<tr>';
			     	$tabl .='		<td align="center">';
			     	$tabl .='		    Tower: '.($tw);
			     	$tabl .='		</td>';
			     	for($lt=1;$lt<=4 ;$lt++){
			     	$tabl .='		<td>';
			     	$tabl .='		    <table>';
			     	
			     	for($un=0;$un<32;$un++){
			     		//if($unit[$l]['unit'][$un+1])
			     			$urut = ($un+1);
			     			//var_dump($dt_unit[$un]['lantai']);
			     			/*
			     			//CARA 1
				     		$tabl .='			<tr>';
					     	$tabl .='		    	<td>'.$urut.' '.$unit[$l]['unit'][$un+1].'</td>';
					     	$tabl .='		    </tr>';
						    */
			     			/*
			     			//CARA 2
			     			if($tw==$unit[$l]['tower'] && $unit[$l]['lantai'] == ($l+1)){
					     		$tabl .='			<tr>';
						     	$tabl .='		    	<td>'.$urut.'['.$tw.']'.$unit[$l]['unit'][$un+1].'</td>';
						     	$tabl .='		    </tr>';
						    }else{
						     	$tabl .='			<tr>';
						     	$tabl .='		    	<td>&nbsp</td>';
						     	$tabl .='		    </tr>';
						    }
						    */

						    /*
			     			//CARA 3
			     			if($tw==$unit[$l]['tower'] && $unit[$l]['lantai'] == ($l+1)){
				     			$tabl .='			<tr>';
						     	$tabl .='		    	<td>'.$urut.'['.($l+1).'] '.$unit[$l]['unit'][$un+1].'...'.$unit[$l]['lantai'].'</td>';
						     	$tabl .='		    </tr>';
						     }else{
						     	$tabl .='			<tr>';
						     	$tabl .='		    	<td>&nbsp</td>';
						     	$tabl .='		    </tr>';
						     }*/

						    //CARA DR DB
						   // if($tw==$dt_unit[$un]['tower'] && $dt_unit[$l]['lantai']==($un+1)  ){
						    $tabl .='			<tr>';
					     	$tabl .='		    	<td>'.($un+1).', '.$dt_unit[$un]['no_unit'].'</td>';
					     	$tabl .='		    </tr>';
							//}else{
							//	$tabl .='			<tr>';
							//	$tabl .='		    	<td>'.($un+1).', '.$dt_unit[$un]['lantai'].'--&nbsp</td>';
							//	$tabl .='		    </tr>';
							//}
				     }
				     $tabl .='		    </table>';
			     	$tabl .='		</td>';
			     	}
			     	$tabl .='	</tr>';
			     	$tw++;
			     }
		$tabl .='</tbody>';
		$tabl .='</table>';
		echo $tabl;
		//var_dump($unit);die;
		//for($t=0;$t<2;$t++){
			//var_dump($unit[$t]['tower']);
			//echo 'tower: '.$unit[$t]['tower'].'<br>';
			for($l=0;$l<3 ;$l++){

				echo 'Lantai: '.$unit[$l]['lantai'].'<br>';
				for($o=0;$o<13;$o++){
					echo ($o+1).' ---> '.$unit[$l]['unit'][$o+1].'<br>';
				}			
			}
		//}
		

	$tbl ='
			<table style="border:1px solid #000;padding:10px;">
		    <thead>
		        <tr>';
		            
		            $tbl .= '<th width="100px">Tower</th>';
		            for ($i = 0; $i < 3; $i++) {
		            	
		                $tbl .= '<th>Lt. ' . ($i+1) . '</th>';
		            }
	$tbl .= '	            
		        </tr>
		    </thead>
		    <tbody>'; 
		    $i = 1;
		    //echo count($datax);die;
		    while ($i<= count($datax) ) { //get tower row
		    	$tbl .= '<tr>';
			  	$tbl .= '    <td>';
			  	$tbl .= 'Tower '.$i;
			  	$tbl .= '    </td>';
			  	
			  	for($l=1;$l<3;$l++){	//get lantai col
			  		$tbl .= '    <td>';
			  			$units = array_keys($datax[$l]);
				  		$tbl .= '<table>';
				  		for($u=0;$u<13;$u++){ //(int)substr(max($unit),0,2)// get unit number
				  			//echo  '>> '.substr($unit[$u],3,2);
				  			//]if( $datax[$l][$u]['lantai']==($l) ){
				  			$lti = $l;
					  			//if($unit[$u+1]==($u+1) ){//&& $datax[$l][$u]['lantai'] == substr($unit[$u],3,2) ){
					  				//if($datax[$l][$u]['lantai'] == $lti){
					  					//$no_unit = ($u+1).' '.$datax[$l][$u]['unit'].' [ Lt.'.$datax[$l][$u]['lantai'].','.$datax[$l][$u]['tower'].']';//$unit[$u+1];
										$no_unit = ($u).' '.$datax[$l][$u]['unit'];//($datax[$l][$u]['urut']==($u+1)?'ok':$u+1);
					  				//}
					  			//}else{
					  			//	$no_unit = ($u+1)."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
					  			//}
					  		//}else{
					  		//	$no_unit = '-';
					  		//}
					  		$tbl .= '	<tr>';
					  		$tbl .= '		<th align="right">';
					  		$tbl .= '		'.$no_unit;
					  		$tbl .= '		</th>';
					  		$tbl .= '	</tr>';
				  		}
				  		$tbl .= '</table>';
				  	$tbl .= '    </td>';
				  }
			  	$tbl .= '</tr>';
			  	$i++;
		    }

	$tbl .= '
		    </tbody>
		</table> ';
	echo $tbl;
	

	$cars = array
	  (
	  array("Volvo",22,18),
	  array("BMW",15,13),
	  array("Saab",5,2),
	  array("Land Rover",17,15)
	  );
	for ($row = 0; $row < 4; $row++) {
	  //echo "<p><b>Row number $row</b></p>";
	  //echo "<ul>";
	  for ($col = 0; $col < 3; $col++) {
	   // echo "<li>".$cars[$row][$col]."</li>";
	  }
	 // echo "</ul>";
	}

	$unit = array(
				array('tower'=>1,'lantai'=>1,
					array(
						1=>'01-01',
						2=>'02-01',
						3=>'03-01',
						4=>'04-01',
						5=>'05-01',
						6=>'06-01',
						8=>'08-01',
						9=>'09-01',
						10=>'10-01',
						11=>'11-01',
						13=>'13-01'
					)
				),
				array('tower'=>1,'lantai'=>2,
					array(
						1=>'01-01',
						2=>'02-01',
						3=>'03-01',
						4=>'04-01',
						5=>'05-01',
						6=>'06-01',
						8=>'08-01',
						9=>'09-01',
						10=>'10-01',
						11=>'11-01',
						13=>'13-01'
					)
				),
				array('tower'=>2,'lantai'=>1,
					array(
						1=>'01-01',
						2=>'02-01',
						3=>'03-01',
						4=>'04-01',
						5=>'05-01',
						6=>'06-01',
						8=>'08-01',
						9=>'09-01',
						10=>'10-01',
						11=>'11-01',
						13=>'13-01'
					),
					'tower'=>2,'lantai'=>2,
					array(
						1=>'01-02',
						2=>'02-02',
						3=>'03-02',
						4=>'04-02',
						5=>'05-02',
						6=>'06-02',
						8=>'08-02',
						9=>'09-02',
						10=>'10-02',
						11=>'11-02',
						13=>'13-02'
					)
				)
			);
	echo '<p>+++++</p>';
	foreach($unit as $k => $v){
		echo 'vv----'.$v[$k].'<br>';
		foreach($v as $kk => $vv){
				echo 'vv----'.$vv.'<br>';
			foreach($vv as $kkk => $vvv){
				echo 'vvv---'.$vvv.'<br>';
			}
		}
	}
	$unit_max = (int)substr(max($unit),0,2);

	for($i=0; $i<$unit_max;$i++){
		echo ($i+1).', '.($unit[$i+1]!=''?$unit[$i+1]:'xx-xx').'<br>';
	}
	
	}

	function _pdf_sku_pesanan($jenisReport, $type,$kode)
	{
		ob_end_clean();
		//$type='stk.no_unit';
		//$kode='1a8639af8c0c2e67aabb58cfb675c306';
		$tipe = $type;
		$hash = $kode;
		$paper='Legal';
		if($jenisReport=="konfirmasi-unit"){
			$data = $this->laporan_model->get_data_sku($tipe, $hash);
			$judul = "SURAT KONFIRMASI UNIT";
		}else{
			$data = $this->laporan_model->get_data_ksp($tipe, $hash);
			$judul = "KESEPAKATAN PESANAN";
		}
		//var_dump($data['nsb_nama']);
		$CI =& get_instance();
		
		$CI->load->library('mpdf/mpdf');
		$mpdf=new mPDF('utf-8', $paper );

		$mpdf->mirrorMargins = 1;	// Use different Odd/Even headers and footers and mirror margins

		$header = '
		<table width="100%" style="border-bottom: 1px solid #000000; vertical-align: bottom; font-family: Tahoma; font-size: 16pt; color: #000088;">
			<tr>
				<td width="33%"><img src="'.base_url().'/assets/assets/img/logos/logo_wg.png" width="126px" /></td>
				<td width="47%" align="center">'.$judul.'</td>
				<td width="20%" style="text-align: right;"></td>
			</tr>
		</table>
		';
		$headerE = '
		<table width="100%" style="border-bottom: 1px solid gray; vertical-align: bottom; font-family: Tahoma; font-size: 8pt; color: #000088;">
			<tr>
				<td width="33%"><span style="font-weight: bold;"></span></td>
				<td width="33%" align="center"></td>
				<td width="33%" style="text-align: right;">Hal: <span style="font-size:8pt;">{PAGENO}</span></td>
			</tr>
		</table>
		';

		$footer = '
		<table width="100%" style="border-top: 1px solid gray; vertical-align: bottom; font-family: Tahoma; font-size: 8pt; color: #000088;">
			<tr>
				<td width="33%"><span style="font-weight: bold;"></span></td>
				<td width="33%" align="center"></td>
				<td width="33%" style="text-align: right;">Hal: <span style="font-size:8pt;">{PAGENO}</span></td>
			</tr>
		</table>
		';;//'<div align="center">See <a href="http://mpdf1.com/manual/index.php">documentation manual</a></div>';
		$footerE = '
		<table width="100%" style="border-top: 1px solid #000000; vertical-align: bottom; font-family: Tahoma; font-size: 8pt; color: #000088;">
			<tr>
				<td width="33%"><span style="font-weight: bold;"></span></td>
				<td width="33%" align="center"></td>
				<td width="33%" style="text-align: right;">Hal: <span style="font-size:8pt;">{PAGENO}</span></td>
			</tr>
		</table>
		';//'<div align="center">See <a href="http://mpdf1.com/manual/index.php">documentation manual</a></div>';


		$mpdf->SetHTMLHeader($header);
		$mpdf->SetHTMLHeader($headerE,'E');
		$mpdf->SetHTMLFooter($footer);
		$mpdf->SetHTMLFooter($footerE,'E');


		$html = '<br>
		<!--table width="100%" style="font-family: Tahoma; font-size: 9pt; ">
		<tr>
			<td width="25%">[ ] Tanah dan Bangunan</td>
			<td width="25%">[ ] Proses Bangun</td>
			<td width="25%">[ ] Rumah Stock</td>
			<td width="25%" style="text-align: right;"></td>
		</tr>
		</table-->

		<style type="text/css">
		.tg  {border-collapse:collapse;border-spacing:0;}
		.tg td{font-family:Arial, sans-serif;font-size:10px;padding:5px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;}
		.tg th{font-family:Arial, sans-serif;font-size:10px;font-weight:normal;padding:5px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;}
		</style>


		<table class="tg" width="100%">
		<!-- Data Nasabah -->
		  <tr>
		    <th class="tg-031e" width="5%">I.</th>
		    <th class="tg-031e" width="95%" colspan="5" style="text-align: left;">DATA NASABAH</th>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e" width="20%">- Nama</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;">'.$data['nsb_nama'].'</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;"></td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;"></td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;">Agama:  '.$data['nsb_agama'].'</td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e">- Alamat KTP</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;">'.$data['nsb_alamat'].'</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;"></td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;"></td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;"></td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e"></td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;" width="6%">Kota: '.$data['nsb_kota'].'</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;"></td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;">Kode Pos:</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;">Telp: '.$data['nsb_hp'].'</td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e">- Alamat Email</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;" colspan="4">'.$data['nsb_email'].'</td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e">- Tempat/Tgl.Lahir</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;">'.$data['nsb_tempat_lahir'].', '.$data['nsb_tgl_lahir'].'</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;"></td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;"></td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;"></td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e">- Alamat Domisili</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;">'.$data['nsb_domisili'].'</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;"></td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;"></td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;"></td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e"></td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;" width="6%">Kota:</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;"></td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;" colspan="2">Kode Pos:</td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e">- Penanggungjawab</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;" colspan="4"></td>
		  </tr>

		  <!-- 
		  --
		  -- DATA PEKERJAAN
		  -- 
		  -->
		  <tr>
		    <th class="tg-031e" width="95%" colspan="6" style="text-align: left;"><br></th>
		  </tr>
		  <tr>
		    <th class="tg-031e" width="5%">II.</th>
		    <th class="tg-031e" width="95%" colspan="5" style="text-align: left;">DATA PEKERJAAN DAN PENGHASILAN</th>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e" width="20%">- Nama Perusahaan</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;" colspan="4">'.$data['nsb_nama_pt'].'</td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e" width="20%">- Alamat Perusahaan</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;" colspan="4">'.$data['nsb_alamat_pt'].'</td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e" width="20%">- Kota / Kode Pos</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;" colspan="4">'.$data['nsb_kota_pt'].' / '.$data['nsb_kodepos_pt'].'</td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e" width="20%">- Telp Kantor & Ext</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;" colspan="4">'.$data['nsb_telp_pt'].' / '.$data['nsb_fax_pt'].'</td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e" width="20%">- No. Faximile</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;" colspan="4">'.$data['nsb_fax_pt'].'</td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e">- Jenis Pekerjaan </td>
		    <td class="tg-031e">[ ] Pegawai Negeri</td>
		    <td class="tg-031e">[ ] Kary. Swasta</td>
		    <td class="tg-031e" style="text-align: right;">Status: </td>
		    <td class="tg-031e">[ ] Tetap</td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e"></td>
		    <td class="tg-031e" width="15%">[ ] Kary. BUMN</td>
		    <td class="tg-031e">[ ] Wiraswasta</td>
		    <td class="tg-031e"></td>
		    <td class="tg-031e">[ ] Tidak Tetap</td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e"></td>
		    <td class="tg-031e"width="15%">[ ] Profesional</td>
		    <td class="tg-031e"colspan="3"></td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e">- Lama Bekerja</td>
		    <td class="tg-031e"  style="border-bottom:0.5px solid gray;">[ ] < 5 Thn</td>
		    <td class="tg-031e"  style="border-bottom:0.5px solid gray;">[ ] 5 - 10 Thn</td>
		    <td class="tg-031e"  style="border-bottom:0.5px solid gray;">[ ] 11 - 15 Thn</td>
		    <td class="tg-031e"  style="border-bottom:0.5px solid gray;">[ ] > 15 Thn</td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e">- Jenis Usaha</td>
		    <td class="tg-031e"  style="border-bottom:0.5px solid gray;" colspan="4">'.$data['nsb_jenis_usaha'].'</td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e">- Jabatan</td>
		    <td class="tg-031e"  style="border-bottom:0.5px solid gray;" colspan="4">'.$data['nsb_jabatan'].'</td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e">- Pendapatan Kotor Tetap perbulan</td>
		    <td class="tg-031e"  style="border-bottom:0.5px solid gray;">[ ] < 5 Juta</td>
		    <td class="tg-031e"  style="border-bottom:0.5px solid gray;">[ ] 5 - 10 Juta</td>
		    <td class="tg-031e"  style="border-bottom:0.5px solid gray;">[ ] 11 - 15 Juta</td>
		    <td class="tg-031e"  style="border-bottom:0.5px solid gray;">[ ] > 15 Juta</td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e">- Sumber Pendapatan Tambahan</td>
		    <td class="tg-031e"  style="border-bottom:0.5px solid gray;" colspan="4"></td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e">- Pendapatan Kotor Tambahan perbulan</td>
		    <td class="tg-031e"  style="border-bottom:0.5px solid gray;">[ ] < 5 Juta</td>
		    <td class="tg-031e"  style="border-bottom:0.5px solid gray;">[ ] 5 - 10 Juta</td>
		    <td class="tg-031e"  style="border-bottom:0.5px solid gray;">[ ] 11 - 15 Juta</td>
		    <td class="tg-031e"  style="border-bottom:0.5px solid gray;">[ ] > 15 Juta</td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e">- N P W P</td>
		    <td class="tg-031e"  style="border-bottom:0.5px solid gray;" colspan="4">'.$data['nsb_npwp'].'</td>
		  </tr>

		  <!--
		  --
		  -- TUJUAN PEMBELIAN
		  --
		  -->
		  <tr>
		    <th class="tg-031e" width="95%" colspan="6" style="text-align: left;"><br></th>
		  </tr>
		  <tr>
		    <th class="tg-031e" width="5%">II.</th>
		    <th class="tg-031e" width="95%" colspan="5" style="text-align: left;">DATA PEKERJAAN DAN PENGHASILAN</th>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e">- Tujuan Pembelian Aset</td>
		    <td class="tg-031e">[ ] Investasi</td>
		    <td class="tg-031e">[ ] N</td>
		    <td class="tg-031e" colspan="2"></td>
		  </tr>
		  <tr>
		    <td class="tg-031e" colspan="2"></td>
		    <td class="tg-031e">[ ] Ditempati</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;">[ ] </td>
		    <td class="tg-031e" colspan="2"></td>
		  </tr>
		  <tr>
		    <td class="tg-031e" colspan="2"></td>
		    <td class="tg-031e">[ ] Disewakan</td>
		    <td class="tg-031e">  <i>( harap diisi )</i></td>
		    <td class="tg-031e" colspan="2"></td>
		  </tr>

		  <!-- 
		  --
		  -- DATA PESANAN 
		  --
		  -->
		  <tr>
		    <th class="tg-031e" width="95%" colspan="6" style="text-align: left;"><br></th>
		  </tr>
		  <tr>
		    <th class="tg-031e" width="5%">III.</th>
		    <th class="tg-031e" width="95%" colspan="5" style="text-align: left;">DATA PESANAN</th>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e">- Blok / Kavling</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;">'.$data['prod_blok'].' / '.$data['prod_kavling'].'</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;">No: '.$data['prod_unit'].'</td>
		    <td class="tg-031e" colspan="2"></td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e">- Type</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;">'.$data['prod_type'].'</td>
		    <td class="tg-031e" colspan="3"></td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e">- Luas Bangunan</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;text-align: right;">'.$data['prod_luas_netto'].' m2</td>
		    <td class="tg-031e" colspan="3"></td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e">- Luas Tanah</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;text-align: right;">'.$data['prod_luas_gross'].' m2</td>
		    <td class="tg-031e" colspan="3"></td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e">- Kondisi Kavling</td>
		    <td class="tg-031e" colspan="4" style="text-align: left;">xxx / xxx / xxx / Dekat Taman *)</td>
		  </tr>
		  <!-- 
		  --
		  -- TOTAL HARGA PESANAN
		  --
		  -->
		  <tr>
		    <th class="tg-031e" width="95%" colspan="6" style="text-align: left;"><br></th>
		  </tr>
		  <tr>
		    <th class="tg-031e" width="5%">V.</th>
		    <th class="tg-031e" colspan="5" style="text-align: left;">TOTAL HARGA PESANAN &nbsp;&nbsp;&nbsp; Rp. '.number_format($data['tr_jual'],2,'.',',').'</th>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e" style="text-align: right;">Terbilang</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;" colspan="4"><i>'.$data['terbilang'].'</i></td>
		  </tr>

		  <!--
		  --
		  -- KESEPAKATAN PEMBAYARAN
		  --
		  -->
		  <tr>
		    <th class="tg-031e" width="95%" colspan="6" style="text-align: left;"><br></th>
		  </tr>
		  <tr>
		    <th class="tg-031e" width="5%">VI.</th>
		    <th class="tg-031e" width="95%" colspan="5" style="text-align: left;">KESEPAKATAN PEMBAYARAN</th>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e">- Cara Pembayaran</td>
		    <td class="tg-031e">[ ] Cash Keras</td>
		    <td class="tg-031e">[ ] Cash Bertahap</td>
		    <td class="tg-031e" colspan="2">[ ] KPR</td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e">A. Uang Muka</td>
		    <td class="tg-031e" colspan="2" style="border-bottom:0.5px solid gray; text-align: right;">Rp. '.number_format($data['pay_um'],2,'.',',').'</td>
		    <td class="tg-031e" colspan="3"></td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e">  - Reserved</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray; text-align: right;" colspan="2">Rp. '.number_format($data['pay_reserve'],2,'.',',').'</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;" colspan="2">Tanggal</td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e">  - Tanda Jadi</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray; text-align: right;" colspan="2">Rp. '.number_format($data['pay_jadi'],2,'.',',').'</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;" colspan="2">Tanggal</td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e">  - Angsuran UM #1</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;" colspan="2">Rp. </td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;" colspan="2">Tanggal</td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e">  - Angsuran UM #2</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;" colspan="2">Rp. </td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;" colspan="2">Tanggal</td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e">  - Angsuran UM #3</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;" colspan="2">Rp. </td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;" colspan="2">Tanggal</td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e">B. Rencana KPR</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;" colspan="2"><span style="text-align: left;">Rp.</span> <span style="text-align: right;">'.number_format($data['pay_kpr'],2,'.',',').'</span></td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;" colspan="2">Tanggal</td>
		  </tr>
		</table>
		<table class="tg" width="100%">
		<!--
		  --
		  -- TANGGAL PENYERAHAN
		  --
		  -->
		  <tr>
		    <th class="tg-031e" width="95%" colspan="6" style="text-align: left;"><br></th>
		  </tr>
		  <tr>
		    <th class="tg-031e" width="5%">VII.</th>
		    <th class="tg-031e" width="95%" colspan="5" style="text-align: left;">PENYERAHAN APLIKASI KPR DAN PERSYARATAN</th>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e" style="text-align: right;">Tanggal</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;" colspan="4"></td>
		  </tr>

		  <!--
		  --
		  -- KETENTUAN
		  --
		  -->
		  <tr>
		    <th class="tg-031e" width="95%" colspan="5" style="text-align: left;"><br></th>
		  </tr>
		  <tr>
		    <th class="tg-031e" width="5%">VIII.</th>
		    <th class="tg-031e" width="95%" colspan="5" style="text-align: left;">KETENTUAN</th>
		   </tr>
		  <tr>
		  	<td class="tg-031e"></td>
		    <td class="tg-031e" colspan="5">
		    	<ol>
		    		<li>Harga tersebut berlaku apabila pembayaran di masukan sesuai waktu rencana pembayaran. Jika tidak dengan kesepakatan diatas maka developer berhak meninjau kembali harga tersebut</li>
		    		<li>Pembayaran hanya dapat dilakukan melalui transfer ke Rekening PT. WIJAYA KARYA REALTY pada Bank Mandiri No. Rekening: 000/00</li>
		    		<li>Kesepakatan Pesanan ini merupakan bagian yang tidak terpisahkan dari Surat Pesanan yang akan di... dalam waktu dekat setelah pembayaran tanda jadi</li>
		    		<li>Penggunaan produk sesuai dengan peruntukannya</li>
		    		<li>Pembayaran tanda jadi 5% selambat-lambatnya...</li>
		    		<li>Pemesan telah membaca dan mengerti syarat-syarat serta ketentuan dalam form pemesanan</li>
		    	</ol>
		    </td>
		  </tr> 
		  <!--
		  --
		  -- CATATAN LAIN-LAIN
		  --
		  -->
		  <tr>
		    <th class="tg-031e" width="95%" colspan="5" style="text-align: left;"><br></th>
		  </tr>
		  <tr>
		    <th class="tg-031e" width="5%">VIII.</th>
		    <th class="tg-031e" width="95%" colspan="5" style="text-align: left;">CATATAN LAIN-LAIN</th>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;" colspan="5"></td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e" colspan="5"></td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;" colspan="5"></td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e"colspan="5"></td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;" colspan="5"></td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;" colspan="5">
		    	Jakarta, .... .........................'.date('Y').'<br>
		    </td>
		  </tr>
		</table>';
		$mpdf->WriteHTML($html);
		$mpdf->Output($jenisReport.'_'.$type.'_'.strtotime(now).'.pdf','D');
	}

	function _pdf_spu($jenisReport, $type,$kode)
	{
		ob_end_clean(); 
		//$type='stk.no_unit';
		//$kode='1a8639af8c0c2e67aabb58cfb675c306';
		$tipe = $type;
		$hash = $kode;
		$paper='Legal';
		if($jenisReport=="sku"){
			$data = $this->laporan_model->get_data_sku($tipe, $hash);
			$judul = "SURAT PESANAN";
		}else{
			$data = $this->laporan_model->get_data_ksp($tipe, $hash);
			$judul = "SURAT PESANAN";
		}
		//var_dump($data['nsb_nama']);
		$CI =& get_instance();
		
		$CI->load->library('mpdf/mpdf');
		$mpdf=new mPDF('utf-8', $paper );

		$mpdf->mirrorMargins = 1;	// Use different Odd/Even headers and footers and mirror margins

		$header = '
		<table width="100%" style="border-bottom: 1px solid #000000; vertical-align: bottom; font-family: Tahoma; font-size: 16pt; color: #000088;">
			<tr>
				<td width="33%"><img src="'.base_url().'/assets/assets/img/logos/logo_wg.png" width="126px" /></td>
				<td width="47%" align="center">'.$judul.'</td>
				<td width="20%" style="text-align: right;"></td>
			</tr>
		</table>
		';
		$headerE = '
		<table width="100%" style="border-bottom: 1px solid gray; vertical-align: bottom; font-family: Tahoma; font-size: 8pt; color: #000088;">
			<tr>
				<td width="33%"><span style="font-weight: bold;"></span></td>
				<td width="33%" align="center"></td>
				<td width="33%" style="text-align: right;">Hal: <span style="font-size:8pt;">{PAGENO}</span></td>
			</tr>
		</table>
		';

		$footer = '
		<table width="100%" style="border-top: 1px solid gray; vertical-align: bottom; font-family: Tahoma; font-size: 8pt; color: #000088;">
			<tr>
				<td width="33%"><span style="font-weight: bold;"></span></td>
				<td width="33%" align="center"></td>
				<td width="33%" style="text-align: right;">Hal: <span style="font-size:8pt;">{PAGENO}</span></td>
			</tr>
		</table>
		';;//'<div align="center">See <a href="http://mpdf1.com/manual/index.php">documentation manual</a></div>';
		$footerE = '
		<table width="100%" style="border-top: 1px solid #000000; vertical-align: bottom; font-family: Tahoma; font-size: 8pt; color: #000088;">
			<tr>
				<td width="33%"><span style="font-weight: bold;"></span></td>
				<td width="33%" align="center"></td>
				<td width="33%" style="text-align: right;">Hal: <span style="font-size:8pt;">{PAGENO}</span></td>
			</tr>
		</table>
		';//'<div align="center">See <a href="http://mpdf1.com/manual/index.php">documentation manual</a></div>';


		$mpdf->SetHTMLHeader($header);
		$mpdf->SetHTMLHeader($headerE,'E');
		$mpdf->SetHTMLFooter($footer);
		$mpdf->SetHTMLFooter($footerE,'E');


		$html = '<br>
		<style type="text/css">
		.tg  {border-collapse:collapse;border-spacing:0;}
		.tg td{font-family:Arial, sans-serif;font-size:10px;padding:5px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;}
		.tg th{font-family:Arial, sans-serif;font-size:10px;font-weight:normal;padding:5px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;}
		</style>

		<table class="tg" width="100%">
		<!-- Data Nasabah -->
		  <tr>
		    <th class="tg-031e" colspan="5" style="text-align: left;">Yang bertandatangan dibawah ini :</th>
		    <th class="tg-031e" style="text-align: left;"></th>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e" width="20%">1. Nama Lengkap</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;">'.$data['nsb_nama'].'</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;"></td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;"></td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;"></td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e">2. Tempat / Tanggal.Lahir</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;" colspan="4"></td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e">3. Alamat Lengkap</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;">'.$data['nsb_alamat'].'</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;"></td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;"></td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;"></td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e"></td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;" width="6%">Kota: '.$data['nsb_kota'].'</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;"></td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;">Kode Pos:</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;">Telp: '.$data['nsb_hp'].'</td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e">&nbsp;&nbsp;&nbsp;&nbsp;Alamat Kantor</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;">'.$data['nsb_domisili'].'</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;"></td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;"></td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;"></td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e"></td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;" width="6%">Kota:</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;"></td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;" colspan="2">Kode Pos:</td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e">4. No. Telp</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;" colspan="4"></td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e"></td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;" width="6%">Rumah:</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;">Telp.Kantor: </td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;" colspan="2">HP:</td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e">5. Email</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;" colspan="4"></td>
		  </tr>
		  <!--tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e">6. No. KTP</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;" colspan="4"></td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e">7. NPWP</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;" colspan="4"></td>
		  </tr-->
		  <tr>
		    <th class="tg-031e" width="95%" colspan="6" style="text-align: left;"><br></th>
		  </tr>
		  <tr>
		    <td class="tg-031e"  colspan="6">Dalam hal ini bertindak dan atas diri sendiri, yang untuk selanjutnya disebut <b>PEMESAN</b>
		    <br>Dengan ini sepakat untuk memesan sebuah unit <b>Apartemen</b> sebagai berikut :</td>
		  </tr>

		  <!-- 
		  --
		  -- DATA PRODUK
		  -- 
		  -->
		  <tr>
		    <th class="tg-031e" width="95%" colspan="6" style="text-align: left;"><br></th>
		  </tr>
		  <tr>
		    <th class="tg-031e" width="5%">I.</th>
		    <th class="tg-031e" width="95%" colspan="5" style="text-align: left;">DATA PRODUK</th>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e" width="20%">1. Nama Proyek</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;" colspan="4">'.$data['nsb_nama_pt'].'</td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e" width="20%">2. Lantai / Nomor Unit</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;" colspan="4">'.$data['nsb_alamat_pt'].'</td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e" width="20%">3. Luas Unit (Netto)</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;" colspan="4">'.$data['nsb_kota_pt'].' / '.$data['nsb_kodepos_pt'].'</td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e" width="20%">4. Luas Unit (Semigross)</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;" colspan="4">'.$data['nsb_telp_pt'].' / '.$data['nsb_fax_pt'].'</td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e" width="20%">5. Peruntukan</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;" colspan="4">'.$data['nsb_fax_pt'].'</td>
		  </tr>

		  <!--
		  --
		  -- HARGA PESANAN
		  --
		  -->
		  <tr>
		    <th class="tg-031e" width="95%" colspan="6" style="text-align: left;"><br></th>
		  </tr>
		  <tr>
		    <th class="tg-031e" width="5%">II.</th>
		    <th class="tg-031e" width="95%" colspan="5" style="text-align: left;">HARGA PESANAN</th>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e" style="text-align: left;">A. Harga Jual sebelum Discount</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;" colspan="4">: <i>'.$data['terbilang'].'</i></td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e" style="text-align: left;"> . Discount</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;" colspan="4">: <i>'.$data['terbilang'].'</i></td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e" style="text-align: left;"> . Harga Jual Setelah Discount</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;" colspan="4">: <i>'.$data['terbilang'].'</i></td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e" style="text-align: left;">B. Pajak Pertambahan Nilai (PPN)</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;" colspan="4">: <i>'.$data['terbilang'].'</i></td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e" style="text-align: left;">C.  Harga Jual Total</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;" colspan="4">: <i>'.$data['terbilang'].'</i></td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e" style="text-align: left;"> . Terbilang</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;" colspan="4">: <i>'.$data['terbilang'].'</i></td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e" style="text-align: left;">D. Harga belum termasuk</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;" colspan="4">: <i>'.$data['terbilang'].'</i></td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e" style="text-align: left;"> 1. BPHTB</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;" colspan="4">: <i>'.$data['terbilang'].'</i></td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e" style="text-align: left;"> 2. AJB, PPJB, BN Sertifikat</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;" colspan="4">: <i>'.$data['terbilang'].'</i></td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e" style="text-align: left;"> 3. PPN BM (bila ada)</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;" colspan="4">: <i>'.$data['terbilang'].'</i></td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e" style="text-align: left;"> 4. Biaya Pengelolaan/Bulan/M2</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;" colspan="4">: <i>'.$data['terbilang'].'</i></td>
		  </tr>
		  

		  <!-- 
		  --
		  -- CARA PEMBAYARAN
		  --
		  -->
		  <tr>
		    <th class="tg-031e" width="95%" colspan="6" style="text-align: left;"></th>
		  </tr>
		  <tr>
		    <th class="tg-031e" width="5%">III.</th>
		    <th class="tg-031e" width="95%" colspan="5" style="text-align: left;">CARA PEMBAYARAN</th>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e" style="text-align: left;">Pembayaran dilakukan dengan cara</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;" colspan="4">: <i>BERTAHAP 24 Kali</i></td>
		  </tr>
		  <tr>
		 	<td class="tg-031e" ></td>
		    <td class="tg-031e" colspan="5">

		    	<table class="tg" width="100%">
				  <tr>
				    <th class="tg-031e" colspan="2">Cara Pembayaran dengan: {PAY}<br>dgn rincian sebagai berikut :</th>
				    <th class="tg-031e" colspan="2">Bank: NAMA BANK</th>
				    <th class="tg-031e" colspan="3"><!--Total KPA: Rp. 1.000.000.000.00,---></th>
				  </tr>
				  <tr>
				    <td class="tg-031e" colspan="7"></td>
				  </tr>
				  <tr>
				    <td class="tg-031e" width="5%" style="border-bottom:0.5px solid gray;border-top:0.5px solid gray;">No</td>
				    <td class="tg-031e" style="border-bottom:0.5px solid gray;border-top:0.5px solid gray;">Keterangan</td>
				    <td class="tg-031e" style="border-bottom:0.5px solid gray;border-top:0.5px solid gray;">Jatuh Tempo</td>
				    <td class="tg-031e" style="border-bottom:0.5px solid gray;border-top:0.5px solid gray;">Interval</td>
				    <td class="tg-031e" style="border-bottom:0.5px solid gray;border-top:0.5px solid gray;">Jumlah</td>
				    <td class="tg-s6z2" style="border-bottom:0.5px solid gray;border-top:0.5px solid gray;" colspan="2">Total</td>
				  </tr>
				  <!-- LOOP ISINYA -->
				  <tr>
				    <td class="tg-031e" style="border-bottom:0.5px solid gray;"></td>
				    <td class="tg-031e" style="border-bottom:0.5px solid gray;"></td>
				    <td class="tg-031e" style="border-bottom:0.5px solid gray;"></td>
				    <td class="tg-031e" style="border-bottom:0.5px solid gray;"></td>
				    <td class="tg-031e" style="border-bottom:0.5px solid gray;"></td>
				    <td class="tg-031e" style="border-bottom:0.5px solid gray;"></td>
				    <td class="tg-031e" style="border-bottom:0.5px solid gray;"></td>
				  </tr>
				  <-- END LOOP -->
				  <tr>
				    <td class="tg-031e" colspan="5" style="border-bottom:0.5px solid gray;"></td>
				    <td class="tg-031e" style="border-bottom:0.5px solid gray;">Rp</td>
				    <td class="tg-031e" style="border-bottom:0.5px solid gray;"></td>
				  </tr>
				</table>
		    </td>
		    
		  </tr>
		 
		  <!-- 
		  --
		  -- PENYERAHAN BANGUNAN
		  --
		  -->
		  <tr>
		    <th class="tg-031e" width="95%" colspan="6" style="text-align: left;"><br></th>
		  </tr>
		  <tr>
		    <th class="tg-031e" width="5%">IV.</th>
		    <th class="tg-031e" width="95%" colspan="5" style="text-align: left;">PENYERAHAN BANGUNAN</th>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e" width="20%">1. Waktu penyerahan</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;" colspan="4">: '.$data['nsb_nama_pt'].'</td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e" width="20%">2. Masa pemeliharaan</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;" colspan="4">: '.$data['nsb_alamat_pt'].'</td>
		  </tr>

		  <!--
		  --
		  -- LAIN-LAIN
		  --
		  -->
		  <tr>
		    <th class="tg-031e" width="95%" colspan="6" style="text-align: left;"><br></th>
		  </tr>
		  <tr>
		    <th class="tg-031e" width="5%">V.</th>
		    <th class="tg-031e" width="95%" colspan="5" style="text-align: left;">LAIN-LAIN</th>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e" colspan="5">Pemesan bersedia memenuhi peraturan dan persyaratan yang ditetapkan PT. Wijaya Karya Bangun Gedung (WIKA Gedung) yang diatur dalam Syarat dan Ketentuan Suat Pesanan Unit Aoartemen sebagaiman terlampir.</td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e" colspan="5">Terkait biaya dan pembatalan, akan dikenakan biaya sesuai syarat dan ketentyan dan gimmic yang telah diberikan</td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e" colspan="5">*) Perkiraan Waktu</td>
		  </tr>
		  <!--
		  --
		  -- CATATAN
		  --
		  -->
		  <tr>
		    <th class="tg-031e" width="95%" colspan="6" style="text-align: left;"><br></th>
		  </tr>
		  <tr>
		    <th class="tg-031e" width="5%">V.</th>
		    <th class="tg-031e" width="95%" colspan="5" style="text-align: left;">CATATAN</th>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e" ><br>Yang menerima Pesanan,<br><br><br><br><br><br><br>{PENERIMA_PESANAN}</td>
		    <td class="tg-031e"></td>
		    <td class="tg-031e" ><br></td>
		    <td class="tg-031e"></td>
		    <td class="tg-031e" >Jakarta, {TGL-BLN-THN}<br>Pemesan,<br><br><br><br><br><br><br><br>{PEMESAN}</td>
		  </tr>
		</table>';
		$mpdf->WriteHTML($html);
		$mpdf->Output($jenisReport.'_'.$type.'_'.strtotime(now).'.pdf','D');
	}

	function _pdf_kartunasabah($jenisReport, $type,$kode)
	{
		ob_end_clean();
		//$type='stk.no_unit';
		//$kode='1a8639af8c0c2e67aabb58cfb675c306';
		$tipe = $type;
		$hash = $kode;
		$paper='Legal';
		$data = $this->laporan_model->get_data_kartunasabah($tipe, $hash);
		$judul = "KARTU NASABAH";
		
		//var_dump($data['nsb_nama']);
		$CI =& get_instance();
		
		$CI->load->library('mpdf/mpdf');
		$mpdf=new mPDF('', 'Legal');
		$mpdf->AddPage('L');
		$mpdf->mirrorMargins = 2;	// Use different Odd/Even headers and footers and mirror margins

		$header = '
		<table width="100%" style="border-bottom: 1px solid #000000; vertical-align: bottom; font-family: Tahoma; font-size: 16pt; color: #000088;">
			<tr>
				<td width="33%"><img src="'.base_url().'/assets/assets/img/logos/logo_wg.png"></td>
				<td width="47%" align="center">'.$judul.'</td>
				<td width="20%" style="text-align: right;"></td>
			</tr>
		</table>
		';
		$headerE = '
		<table width="100%" style="border-bottom: 1px solid gray; vertical-align: bottom; font-family: Tahoma; font-size: 8pt; color: #000088;">
			<tr>
				<td width="33%"><span style="font-weight: bold;"></span></td>
				<td width="33%" align="center"></td>
				<td width="33%" style="text-align: right;">Hal: <span style="font-size:8pt;">{PAGENO}</span></td>
			</tr>
		</table>
		';

		$footer = '
		<table width="100%" style="border-top: 1px solid gray; vertical-align: bottom; font-family: Tahoma; font-size: 8pt; color: #000088;">
			<tr>
				<td width="33%"><span style="font-weight: bold;"></span></td>
				<td width="33%" align="center"></td>
				<td width="33%" style="text-align: right;">Hal: <span style="font-size:8pt;">{PAGENO}</span></td>
			</tr>
		</table> ';

		$footerE = '
		<table width="100%" style="border-top: 1px solid #000000; vertical-align: bottom; font-family: Tahoma; font-size: 8pt; color: #000088;">
			<tr>
				<td width="33%"><span style="font-weight: bold;"></span></td>
				<td width="33%" align="center"></td>
				<td width="33%" style="text-align: right;">Hal: <span style="font-size:8pt;">{PAGENO}</span></td>
			</tr>
		</table>';

		$mpdf->SetHTMLHeader($header);
		$mpdf->SetHTMLHeader($headerE,'E');
		$mpdf->SetHTMLFooter($footer);
		$mpdf->SetHTMLFooter($footerE,'E');
		
		$css = '
		<style type="text/css">
			.tg  {border-collapse:collapse;border-spacing:0;}
			.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
			.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
			.tg .tg-0ord{text-align:right}
			.tg .tg-s6z2{text-align:center}
		</style>';

		$html = '<br>
		<style type="text/css">
			.tg  {border-collapse:collapse;border-spacing:0;}
			.tg td{font-family:Arial, sans-serif;font-size:10px;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;}
			.tg th{font-family:Arial, sans-serif;font-size:10px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;}
			.tg .tg-0ord{text-align:right}
			.tg .tg-s6z2{text-align:center}
		</style>

		<table  width="100%" style="font-family:Arial, sans-serif;font-size:12px;font-weight:normal;">
		  <!-- 
		  --
		  -- DATA NASABAH
		  -- 
		  -->
		  <tr>
		    <th class="tg-031e" width="95%" colspan="7" style="text-align: left;"><br></th>
		  </tr>
		  <tr>
		    <th class="tg-0ord" width="5%">I.</th>
		    <th class="tg-031e" width="10%" style="text-align: left;">DATA NASABAH</th>
		    <th class="tg-031e" width="85%" colspan="6" style="text-align: left;">'.strtoupper($data['nsb_kode']).' -- '.$data['reserve_no'].'</th>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e" width="20%">- Nama Nasabah</td>
		    <td class="tg-031e" colspan="5">: '.$data['nsb_nama'].'</td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e" width="20%">- Alamat</td>
		    <td class="tg-031e" colspan="5">: '.$data['nsb_alamat'].'</td>
		  </tr>
		  <!--
		  --
		  -- DATA PRODUK
		  --
		  -->
		  <tr>
		    <th class="tg-031e" width="95%" colspan="7" style="text-align: left;"><br><br><br></th>
		  </tr>
		  <tr>
		    <th class="tg-031e" width="5%">II.</th>
		    <th class="tg-031e" width="95%" colspan="6" style="text-align: left;">DATA PRODUK</th>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e" style="text-align: left;">- Nama Unit</td>
		    <td class="tg-031e" >: <i>'.$data['prod_unit'].'</i></td>
		  	<td class="tg-031e" style="text-align: left;" colspan="4"></td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e" style="text-align: left;">- Luas Semi Gross</td>
		    <td class="tg-031e" colspan="5">: <i>'.$data['prod_luas_gross'].'</i>M2</td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e" style="text-align: left;">- Luas Unit</td>
		    <td class="tg-031e"  colspan="5">: <i>'.$data['prod_luas_netto'].'</i> M2</td>
		  </tr>

		  <!-- 
		  --
		  -- DATA PRODUK
		  --
		  -->
		  <tr>
		    <th class="tg-031e" width="95%" colspan="7" style="text-align: left;"><br><br><br></th>
		  </tr>
		  <tr>
		    <th class="tg-0ord" width="5%">III.</th>
		    <th class="tg-031e" style="text-align: left;" colspan="3">DATA PRODUK YANG DITRANSAKSIKAN</th>
		    <th class="tg-031e" colspan="2" style="text-align: right;">PERUBAHAN DATA</th>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e" width="10%">- Harga Jual Netto</td>
		    <td class="tg-031e">: <i>'.$data['tr_jual'].'</i></td>
		    <td class="tg-031e" width="6%"></td>
		    <td class="tg-031e" width="10%">- Harga Jual Netto</td>
		    <td class="tg-031e" width="15%">: <i>'.$data['prod_luas_gross'].'</i></td>
		    <td class="tg-031e"></td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e">- PPN</td>
		    <td class="tg-031e">: <i>'.$data['prod_luas_gross'].'</i></td>
		    <td class="tg-031e"></td>
		    <td class="tg-031e">- Adendum (*)</td>
		    <td class="tg-031e">: <i>'.$data['prod_luas_gross'].'</i></td>
		  	<td class="tg-031e"></td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e">- BHPHTB</td>
		    <td class="tg-031e">: <i>'.$data['prod_luas_gross'].'</i></td>
		    <td class="tg-031e"></td>
		    <td class="tg-031e">- Adendum (*)</td>
		    <td class="tg-031e">: <i>'.$data['prod_luas_gross'].'</i></td>
		  	<td class="tg-031e"></td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e">- Surat-surat</td>
		    <td class="tg-031e">: <i>'.$data['prod_luas_gross'].'</i></td>
		    <td class="tg-031e"></td>
		    <td class="tg-031e">- Harga Jual Netto</td>
		    <td class="tg-031e">: <i>'.$data['prod_luas_gross'].'</i></td>
		    <td class="tg-031e"></td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e">- Biaya Lainnya</td>
		    <td class="tg-031e">: <i>'.$data['prod_luas_gross'].'</i></td>
		    <td class="tg-031e"></td>
		    <td class="tg-031e">- PPN</td>
		    <td class="tg-031e">: <i>'.$data['prod_luas_gross'].'</i></td>
		    <td class="tg-031e"></td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e">- Cadangan Bonus</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;">: <i>'.$data['prod_luas_gross'].'</i></td>
		    <td class="tg-031e"></td>
		    <td class="tg-031e">- BPHTB</td>
		    <td class="tg-031e">: <i>'.$data['prod_luas_gross'].'</i></td>
		    <td class="tg-031e"></td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e">- Total Harga Jual</td>
		    <td class="tg-031e">: <i>'.$data['prod_luas_gross'].'</i></td>
		    <td class="tg-031e"></td>
		    <td class="tg-031e">- Surat-surat</td>
		    <td class="tg-031e">: <i>'.$data['prod_luas_gross'].'</i></td>
		    <td class="tg-031e"></td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e"></td>
		    <td class="tg-031e"></td>
		    <td class="tg-031e"></td>
		    <td class="tg-031e">- Biaya Lot</td>
		    <td class="tg-031e">: <i>'.$data['prod_luas_gross'].'</i></td>
		    <td class="tg-031e"></td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e"></td>
		    <td class="tg-031e"></td>
		    <td class="tg-031e"></td>
		    <td class="tg-031e">- Cadangan Bonus</td>
		    <td class="tg-031e" style="border-bottom:0.5px solid gray;">: <i>'.$data['prod_luas_gross'].'</i></td>
		    <td class="tg-031e"></td>
		  </tr>
		  <tr>
		    <td class="tg-031e"></td>
		    <td class="tg-031e"></td>
		    <td class="tg-031e"></td>
		    <td class="tg-031e"></td>
		    <td class="tg-031e">- Total Harga Jual</td>
		    <td class="tg-031e">: <i>'.$data['prod_luas_gross'].'</i></td>
		    <td class="tg-031e"></td>
		  </tr>

		 
		  <!-- 
		  --
		  -- RINCIAN PEMBAYARAN DAN PERHITUNGAN PAJAK
		  --
		  -->
		  <tr>
		    <th class="tg-031e" width="95%" colspan="6" style="text-align: left;"><br><br><br></th>
		  </tr>
		  <tr>
		    <th class="tg-0ord" width="5%">IV.</th>
		    <th class="tg-031e" width="95%" colspan="5" style="text-align: left;">RINCIAN PEMBAYARAN DAN PERHITUNGAN PAJAK</th>
		  </tr>
		  <tr>
		  	<td class-"tg-031e"></td>
		    <td class="tg-031e" width="100%" colspan="6">
		    	<table class="tg" style="border:0.5px solid gray;solid gray;" width="100%">
				  <tr>
				    <th style="border:0.5px solid gray;solid gray;" width="2%" rowspan="2">No</th>
				    <th style="border:0.5px solid gray;solid gray;" width="7.3%" colspan="4">Piutang</th>
				    <th style="border:0.5px solid gray;solid gray;" width="7.3%" colspan="3">Pembayaran</th>
				    <th style="border:0.5px solid gray;solid gray;" width="7.3%" colspan="4">Giro</th>
				    <th style="border:0.5px solid gray;solid gray;" width="7.3%" colspan="2">Denda</th>
				  </tr>
				  <tr>
				    <td style="border:0.5px solid gray;solid gray;" width="10%">Keterangan</td>
				    <td style="border:0.5px solid gray;solid gray;" width="7.3%">Tgl Tagih</td>
				    <td style="border:0.5px solid gray;solid gray;" width="7.3%">Jth Tempo</td>
				    <td style="border:0.5px solid gray;solid gray;" width="7.3%">Nilai Tagihan (a)</td>
				    <td style="border:0.5px solid gray;solid gray;" width="7.3%">Tgl Bayar</td>
				    <td style="border:0.5px solid gray;solid gray;" width="7.3%">No. Kuitansi</td>
				    <td style="border:0.5px solid gray;solid gray;" width="7.3%">Nilai Bayar (b)</td>
				    <td style="border:0.5px solid gray;solid gray;" width="7.3%">Bank Giro</td>
				    <td style="border:0.5px solid gray;solid gray;" width="7.3%">No.Giro</td>
				    <td style="border:0.5px solid gray;solid gray;" width="7.3%">Tgl.Giro</td>
				    <td style="border:0.5px solid gray;solid gray;" width="7.3%">Nilai Giro (c)</td>
				    <td style="border:0.5px solid gray;solid gray;" width="7.3%">Hari</td>
				    <td style="border:0.5px solid gray;solid gray;" width="7.3%">Nilai</td>
				  </tr>

				  <!-- LOOP DATA DISINI -->
				  <tr>
				    <td style="border:0.5px solid gray;solid gray;"></td>
				    <td style="border:0.5px solid gray;solid gray;"></td>
				    <td style="border:0.5px solid gray;solid gray;"></td>
				    <td style="border:0.5px solid gray;solid gray;"></td>
				    <td style="border:0.5px solid gray;solid gray;"></td>
				    <td style="border:0.5px solid gray;solid gray;"></td>
				    <td style="border:0.5px solid gray;solid gray;"></td>
				    <td style="border:0.5px solid gray;solid gray;"></td>
				    <td style="border:0.5px solid gray;solid gray;"></td>
				    <td style="border:0.5px solid gray;solid gray;"></td>
				    <td style="border:0.5px solid gray;solid gray;"></td>
				    <td style="border:0.5px solid gray;solid gray;"></td>
				    <td style="border:0.5px solid gray;solid gray;"></td>
				    <td style="border:0.5px solid gray;solid gray;"></td>
				  </tr>';
				$iLoop = 1; 
                $total_tagihan = $total_bayar = 0;
                if(isset($data['payment'])) {
                	foreach($data['payment'] as $k => $v) { 

                $html.='
				  <!-- END LOOP DATA -->
				  <tr>
				    <td style="border:0.5px solid gray;solid gray;text-align: right;" colspan="3">Sub Total</td>
				    <td style="border:0.5px solid gray;solid gray;"></td>
				    <td style="border:0.5px solid gray;solid gray;">Rp</td>
				    <td style="border:0.5px solid gray;solid gray;"></td>
				    <td style="border:0.5px solid gray;solid gray;text-align: right;">%</td>
				    <td style="border:0.5px solid gray;solid gray;">Rp</td>
				    <td style="border:0.5px solid gray;solid gray;"></td>
				    <td style="border:0.5px solid gray;solid gray;"></td>
				    <td style="border:0.5px solid gray;solid gray;text-align: right;">%</td>
				    <td style="border:0.5px solid gray;solid gray;"></td>
				    <td style="border:0.5px solid gray;solid gray;"></td>
				    <td style="border:0.5px solid gray;solid gray;"></td>
				  </tr>
				  ';
					}
				}
				  $html.='
				  <tr>
				    <td style="border:0.5px solid gray;solid gray;text-align: right" colspan="3">Sub Balance</td>
				    <td style="border:0.5px solid gray;solid gray;"></td>
				    <td style="border:0.5px solid gray;solid gray;"></td>
				    <td style="border:0.5px solid gray;solid gray;"></td>
				    <td style="border:0.5px solid gray;solid gray;"></td>
				    <td style="border:0.5px solid gray;solid gray;"></td>
				    <td style="border:0.5px solid gray;solid gray;"></td>
				    <td style="border:0.5px solid gray;solid gray;"></td>
				    <td style="border:0.5px solid gray;solid gray;"></td>
				    <td style="border:0.5px solid gray;solid gray;"></td>
				    <td style="border:0.5px solid gray;solid gray;"></td>
				    <td style="border:0.5px solid gray;solid gray;"></td>
				  </tr>
				</table>
				<br>
				<table class="tg" style="border:0.5px solid gray;solid gray;" width="100%">
				  <tr>
				  	<td style="border:0.5px solid gray;solid gray;" width="100%" colspan="7"><br><br></td>
				  </tr>
				</table>
				<br>
				<table class="tg" style="border:0.5px solid gray;solid gray;" width="75%">
				  <tr>
				    <th style="border:0.5px solid gray;solid gray;" width="5%" rowspan="2">Ke</th>
				    <th style="border:0.5px solid gray;solid gray;" rowspan="2">Kondisi Cair</th>
				    <th style="border:0.5px solid gray;solid gray;" width="5%" rowspan="2">%</th>
				    <th style="border:0.5px solid gray;solid gray;">Ra</th>
				    <th style="border:0.5px solid gray;solid gray;" colspan="2">Ri</th>
				  </tr>
				  <tr>
				    <td style="border:0.5px solid gray;solid gray;" width="20%">Rp</td>
				    <td style="border:0.5px solid gray;solid gray;" width="15%">Tanggal</td>
				    <td style="border:0.5px solid gray;solid gray;" width="20%">Rp</td>
				  </tr>
				  <tr>
				    <td style="border:0.5px solid gray;solid gray;"></td>
				    <td style="border:0.5px solid gray;solid gray;"></td>
				    <td style="border:0.5px solid gray;solid gray;"></td>
				    <td style="border:0.5px solid gray;solid gray;"></td>
				    <td style="border:0.5px solid gray;solid gray;"></td>
				    <td style="border:0.5px solid gray;solid gray;"></td>
				  </tr>
				  <tr>
				    <td style="border:0.5px solid gray;solid gray;" colspan="6"></td>
				  </tr>
				</table>
		    </td>
		  </tr>
		</table>';
		$mpdf->WriteHTML($html);
		$mpdf->Output($jenisReport.'_'.$type.'_'.strtotime(now).'.pdf','D');
	}


	/////////////////////////////////////////////////////////
	public function doprint($jenisReport,$type,$kode)
	{
		$data['tes'] = 'ini print dari HTML ke PDF';
		$output = $this->load->view('page_prints', $data, true);

		if ($jenisReport=="konfirmasi-unit") {
			return $this->_pdf_sku_pesanan($jenisReport,$type,$kode);
		}elseif ($jenisReport=="surat-pesanan") {
			return $this->_pdf_spu($jenisReport,$type,$kode);
		}elseif ($jenisReport=="kartu-nasabah") {
			return $this->_pdf_kartunasabah($jenisReport,$type,$kode);
		}else{
			return $this->_pdf_sku_pesanan($jenisReport,$type,$kode);
		}
	}
}
?>