<!-- Begin: Content -->
<style>
.text-bold {
	font-weight: bold;
}
</style>
<section id="content">

    <div class="row">
		<div class="col-md-12 pn">
			<div class="panel mbn">
				<div class="panel-body" style="overflow-x: scroll">
					<div class="row">
						<div class="col-md-12">
							<!--<h4 class="mbn">PT WIJAYA KARYA BANGUN GEDUNG</h4>-->
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<h5 class="mbn">KAWASAN <?=@$data['kawasan']?></h5>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 text-center">
							<h4 class="mbn">LAPORAN BUKU BESAR <?=(isset($data['divisi'])?strtoupper($data['divisi']['nama']):'')?></h4>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 text-center">
							<h5 class="mbn">PERIODE <?=@strtoupper($data['periode'])?></h5>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<p>Dicetak tanggal: <?=date('d/m/Y H:i:s')?>, Oleh: <?=$data['nama']?></p>
						</div>
					</div>
					<table id="example" class="table table-bordered mbn">
						<thead>
							<tr class="bg-primary light">
								<th class="text-center" rowspan="2">TANGGAL</th>
							    <th class="text-center" rowspan="2">NOMOR BUKTI</th>
							    <th class="text-center" rowspan="2">URAIAN</th>
							    <th class="text-center" colspan="2">MUTASI</th>
							    <th class="text-center" rowspan="2">SALDO</th>
							</tr>
							<tr class="bg-primary light">
							    <td class="text-center">DEBIT</td>
							    <td class="text-center">KREDIT</td>
							</tr>
						</thead>
						<tbody>
						<?php
						$this->load->helper('combo');
						$t_debit = 0;
						$t_kredit = 0;
						$t_saldo = 0;
						$t_saldo_awal = 0;
						$saldo = 0;
						//$saldo = get_SaldoAwalBukBer($data['rows']['kode_coa'],$data['sa_per']);

						foreach ($data['rows'] as $k => $v) {
							$t_debit += $v['debit'];
							$t_kredit += $v['kredit'];
							
							$sa_1 =  $v['saldo_awal'];
							$sa_2 =  $v['saldo_detail'];
							$isCOA = strspn($v['keterangan'],'---');
							$t_saldo += $t_saldo;
							$t_saldo = ($sa_1 + $t_debit) - $t_kredit;

							if($isCOA==3){
                                $class = 'text-right text-bold';
                                $style = 'style="background-color: #D3D3D3; color: #696969;"';
                                if($sa_2=='unset'){
                                $saldo = $t_saldo;//get_SaldoAwalBukBer($v['kode_coa'],$data['sa_per']);
                            	$t_saldo_awal = $saldo;

                            	}else{
                            		$saldo =0;//$t_saldo;
                            	}
                            }else{
                                $class = 'text-right text-bold';
                                $style = '';
                                if($sa_2=='unset'){

                                $saldo = $t_saldo_awal;//+$t_debit-$t_kredit;
                            	}else{
                            		$saldo = $sa_1;//+$t_saldo;
                            	}
                            }
							$tanggal = tgl_indo($v['tanggal'],'-');
							
						?>
							<tr>
								<td class="text-center"><?=$tanggal?></td>
								<td class="text-center"><?=$v['no_bukti']?></td>
								<td class="text-left"><?=$v['keterangan']?></td>
								<td class="text-right"><?=number_format($v['debit'])?></td>
								<td class="text-right"><?=number_format($v['kredit'])?></td>
								<td class="text-right"><?=number_format($saldo)?></td>
							</tr>
						<?php

						}
						?>
						</tbody>
						<tfoot>
							<tr class="bg-primary light">
								<th colspan="3" class="text-right">SUB TOTAL</th>
								<th class="text-right"><?=number_format($t_debit)?></th>
								<th class="text-right"><?=number_format($t_kredit)?></th>
								<th class="text-right"></th>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
	
</section>
<!-- End: Content -->