<!-- Begin: Content -->
<section id="content">

    <div class="row">
		<div class="col-md-12 pn">
			<div class="panel mbn">
				<div class="panel-body" style="overflow-x: scroll">
					<div class="row">
						<div class="col-md-12">
							<!--<h4 class="mbn">PT WIJAYA KARYA REALTY</h4>-->
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<h5 class="mbn">KAWASAN <?=@$data['kawasan']?></h5>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 text-center">
							<h4 class="mbn">LAPORAN PENERIMAAN</h4>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 text-center">
							<h5 class="mbn">Periode <?=@$data['periode']?></h5>
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
								<th rowspan="3" class="text-center" style="vertical-align:middle">No.</th>
								<th rowspan="3" class="text-center" style="vertical-align:middle">No. Unit</th>
								<th rowspan="3" class="text-center" style="vertical-align:middle">Customer</th>
								<!--<th rowspan="2" class="text-center" style="vertical-align:middle">Tanggal Bayar</th>-->
								<th rowspan="3" class="text-center" style="vertical-align:middle"><?=$this->session->userdata('type_property')==='HR' ? "Tower" : "Cluster"?></th>
								<th rowspan="3" class="text-center" style="vertical-align:middle">Jenis</th>
								<th rowspan="3" class="text-center" style="vertical-align:middle">Bruto</th>
								<th rowspan="3" class="text-center" style="vertical-align:middle">Cara Bayar</th>
								
								<th colspan="5" class="text-center">RENCANA PEMBAYARAN</th>
								<th colspan="6" class="text-center">REALISASI PEMBAYARAN</th>
								<th colspan="5" class="text-center">KEKURANGAN PEMBAYARAN</th>
							</tr>
							<tr class="bg-primary light">
								<!-- RA -->
								<th class="text-center">Uang Muka</th>
								<th class="text-center">%</th>
								<th class="text-center">Angsuran</th>
								<th class="text-center">%</th>
								<th class="text-center">TOTAL</th>
								<!-- REALISASI -->
								<th class="text-center">Uang Muka</th>
								<th class="text-center">%</th>
								<th class="text-center">Angsuran</th>
								<th class="text-center">%</th>
								<th class="text-center">TOTAL</th>
								<th class="text-center">%</th>
								<!-- KEKURANGAN -->
								<th class="text-center">Uang Muka</th>
								<th class="text-center">%</th>
								<th class="text-center">Angsuran</th>
								<th class="text-center">%</th>
								<th class="text-center">TOTAL</th>
							</tr>
						</thead>
						<tbody>
						<?php 
						$no = 1;
						$sumRAUM = $sumRAAG = $sumRIUM = $sumRIAG = $sumKRUM1 = $sumKRAG1 = $sumKRUM2 = $sumKRAG2 = $sumKRUM3 = $sumKRAG3 = $vbruto = 0;
						foreach($data['datatable'] as $k => $v) { 
							$bruto = $v['bruto'];
							$ra_um = $v['ra_um_lalu'] + $v['ra_um_ini'] + $v['ra_um_depan'];
							$ra_ag = $v['ra_ag_lalu'] + $v['ra_ag_ini'] + $v['ra_ag_depan'];
							$ri_um = $v['ri_um_lalu'] + $v['ri_um_ini'] + $v['ri_um_depan'];
							$ri_ag = $v['ri_ag_lalu'] + $v['ri_ag_ini'] + $v['ri_ag_depan'];
							// $ri_um = $v['ri_um_lalu'] + $v['ri_um_ini'];
							// $ri_ag = $v['ri_ag_lalu'] + $v['ri_ag_ini'];
							// kekurangan lalu
							$kr_ra_um1 = 0;
							$sisa_ri_um = $ri_um;
							if($v['ra_um_lalu']>0) {
								if($sisa_ri_um>$v['ra_um_lalu']) {
									$kr_ra_um1 = 0;
									$sisa_ri_um -= $v['ra_um_lalu'];
								} else {
									$kr_ra_um1 = $v['ra_um_lalu'] - $sisa_ri_um;
									$sisa_ri_um = 0;
								}
							}
							$kr_ra_ag1 = 0;
							$sisa_ri_ag = $ri_ag;
							if($v['ra_ag_lalu']>0) {
								if($sisa_ri_ag>$v['ra_ag_lalu']) {
									$kr_ra_ag1 = 0;
									$sisa_ri_ag -= $v['ra_ag_lalu'];
								} else {
									$kr_ra_ag1 = $v['ra_ag_lalu'] - $sisa_ri_ag;
									$sisa_ri_ag = 0;
								}
							}
							// kekurangan ini
							$kr_ra_um2 = 0;
							if($v['ra_um_ini']>0) {
								if($sisa_ri_um>$v['ra_um_ini']) {
									$kr_ra_um2 = 0;
									$sisa_ri_um -= $v['ra_um_ini'];
								} else {
									$kr_ra_um2 = $v['ra_um_ini'] - $sisa_ri_um;
									$sisa_ri_um = 0;
								}
							}
							$kr_ra_ag2 = 0;
							if($v['ra_ag_ini']>0) {
								if($sisa_ri_ag>$v['ra_ag_ini']) {
									$kr_ra_ag2 = 0;
									$sisa_ri_ag -= $v['ra_ag_ini'];
								} else {
									$kr_ra_ag2 = $v['ra_ag_ini'] - $sisa_ri_ag;
									$sisa_ri_ag = 0;
								}
							}
							// kekurangan depan
							$kr_ra_um3 = 0;
							if($v['ra_um_depan']>0) {
								if($sisa_ri_um>$v['ra_um_depan']) {
									$kr_ra_um3 = 0;
									$sisa_ri_um -= $v['ra_um_depan'];
								} else {
									$kr_ra_um3 = $v['ra_um_depan'] - $sisa_ri_um;
									$sisa_ri_um = 0;
								}
							}
							$kr_ra_ag3 = 0;
							if($v['ra_ag_depan']>0) {
								if($sisa_ri_ag>$v['ra_ag_depan']) {
									$kr_ra_ag3 = 0;
									$sisa_ri_ag -= $v['ra_ag_depan'];
								} else {
									$kr_ra_ag3 = $v['ra_ag_depan'] - $sisa_ri_ag;
									$sisa_ri_ag = 0;
								}
							}
							$kr_total = $kr_ra_um1 + $kr_ra_um2 + $kr_ra_um3 + $kr_ra_ag1 + $kr_ra_ag2 + $kr_ra_ag3;
						?>
							<tr>
								<td class="text-center"><?=$no?></td>
								<td class="text-center"><?=$v['no_unit']?></td>
								<td><?=$v['nsb_nama']?></td>
								<td class="text-center"><?=$v['tower']?></td>
								<td class="text-center"><?=$v['prop_type']?></td>
								<td class="text-right"><?=number_format($v['bruto'],2)?></td>
								<td class="text-center"><?=$v['cara_bayar']?></td>
								<td class="text-right"><?=number_format($ra_um,2)?></td>
								<td class="text-center"><?=number_format($ra_um/$bruto*100,2)?></td>
								<td class="text-right"><?=number_format($ra_ag,2)?></td>
								<td class="text-center"><?=number_format($ra_ag/$bruto*100,2)?></td>
								<td class="text-right"><?=number_format($ra_um+$ra_ag,2)?></td>
								<td class="text-right"><?=number_format($ri_um,2)?></td>
								<td class="text-center"><?=number_format($ri_um/($ra_um+$ra_ag)*100,2)?></td>
								<td class="text-right"><?=number_format($ri_ag,2)?></td>
								<td class="text-center"><?=number_format($ri_ag/($ra_um+$ra_ag)*100,2)?></td>
								<td class="text-right"><?=number_format($ri_ag+$ri_um,2)?></td>
								<td class="text-center"><?=number_format(($ri_ag+$ri_um)/($ra_um+$ra_ag)*100,2)?></td>
								<td class="text-right"><?=number_format($kr_ra_um1+$kr_ra_um2+$kr_ra_um3,2)?></td>
								<td class="text-right"><?=number_format(($kr_ra_um1+$kr_ra_um2+$kr_ra_um3)/($ra_um+$ra_ag)*100,2)?></td>
								<td class="text-right"><?=number_format($kr_ra_ag1+$kr_ra_ag2+$kr_ra_ag3,2)?></td>
								<td class="text-right"><?=@number_format(($kr_ra_ag1+$kr_ra_ag2+$kr_ra_ag3)/($ra_um+$ra_ag)*100,2)?></td>
								<td class="text-right"><?=number_format($kr_total,2)?></td>
							</tr>
						<?php 
							$vbruto += $bruto;
							$sumRAUM += $ra_um;
							$sumRAAG += $ra_ag;
							$sumRIUM += $ri_um;
							$sumRIAG += $ri_ag;
							$sumKRUM1 += $kr_ra_um1;
							$sumKRAG1 += $kr_ra_ag1;
							$sumKRUM2 += $kr_ra_um2;
							$sumKRAG2 += $kr_ra_ag2;
							$sumKRUM3 += $kr_ra_um3;
							$sumKRAG3 += $kr_ra_ag3;
							$no++;
						} ?>
							<tr class="bg-primary light">
								<td colspan="5" class="text-right"><b>Total</b></td>
								<td class="text-right"><b><?=@number_format($vbruto,2)?></b></td>
								<td class="text-right">&nbsp;</td>
								<td class="text-right"><b><?=@number_format($sumRAUM,2)?></b></td>
								<td class="text-center">&nbsp;</td>
								<td class="text-right"><b><?=@number_format($sumRAAG,2)?></b></td>
								<td class="text-center">&nbsp;</b></td>
								<td class="text-right"><b><?=@number_format($sumRAUM+$sumRAAG,2)?></b></td>
								<td class="text-right"><b><?=@number_format($sumRIUM,2)?></b></td>
								<td class="text-center"><b><?=@number_format(($sumRIUM)/($sumRAUM+$sumRAAG)*100,2)?></b></td>
								<td class="text-right"><b><?=@number_format($sumRIAG,2)?></b></td>
								<td class="text-center"><b><?=@number_format(($sumRIAG)/($sumRAUM+$sumRAAG)*100,2)?></b></td>
								<td class="text-right"><b><?=@number_format($sumRIUM+$sumRIAG,2)?></b></td>
								<td class="text-center"><b><?=@number_format(($sumRIUM+$sumRIAG)/($sumRAUM+$sumRAAG)*100,2)?></b></td>
								<td class="text-right"><b><?=@number_format($sumKRUM1+$sumKRUM2+$sumKRUM3,2)?></b></td>
								<td class="text-right"><b><?=@number_format(($sumKRUM1+$sumKRUM2+$sumKRUM3)/$sumRAUM*100,2)?></b></td>
								<td class="text-right"><b><?=@number_format($sumKRAG1+$sumKRAG2+$sumKRAG3,2)?></b></td>
								<td class="text-right"><b><?=@number_format(($sumKRAG1+$sumKRAG2+$sumKRAG3)/$sumRAAG*100,2)?></b></td>
								<td class="text-right"><b><?=@number_format($sumKRUM1+$sumKRUM2+$sumKRUM3+$sumKRAG1+$sumKRAG2+$sumKRAG3,2)?></b></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	
</section>
<!-- End: Content -->