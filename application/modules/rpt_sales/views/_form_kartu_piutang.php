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
							<p>Dicetak tanggal: <?=date('d').' '.@$data['periode']?>, Oleh: <?=$data['nama']?></p>
						</div>
					</div>
					<table id="example" class="table table-bordered mbn">
						<thead>
							<tr class="bg-primary light">
								<th rowspan="2" class="text-center" style="vertical-align:middle">No.</th>
								<th rowspan="2" class="text-center" style="vertical-align:middle">No. Unit</th>
								<th rowspan="2" class="text-center" style="vertical-align:middle">Customer</th>
								<!--<th rowspan="2" class="text-center" style="vertical-align:middle">Tanggal Bayar</th>-->
								<th rowspan="2" class="text-center" style="vertical-align:middle">Tower</th>
								<th rowspan="2" class="text-center" style="vertical-align:middle">Jenis</th>
								<th rowspan="2" class="text-center" style="vertical-align:middle">Bruto</th>
								
								<th colspan="5" class="text-center">RENCANA PEMBAYARAN</th>
								<th colspan="6" class="text-center">REALISASI PEMBAYARAN</th>
								<th colspan="6" class="text-center">KEKURANGAN PEMBAYARAN</th>
							</tr>
							<tr class="bg-primary light">
								<!-- RA -->
								<th class="text-center">Cara Bayar</th>
								<th class="text-center">Uang Muka</th>
								<th class="text-center">%</th>
								<th class="text-center">Angsuran</th>
								<th class="text-center">%</th>
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
								<th class="text-center">%</th>
							</tr>
						</thead>
						<tbody>
						<?php 
						$no = 1;
						$sumRAUM = $sumRAAG = $sumRIUM = $sumRIAG = $sumRIE = $sumKRUM = $sumKRAG = $sumKRE = $vbruto = 0;
						foreach($data['datatable'] as $k => $v) { ?>
							<tr>
								<td class="text-center"><?=$no?></td>
								<td class="text-center"><?=$v['no_unit']?></td>
								<td><?=$v['nsb_nama']?></td>
								<!--<td class="text-center"><?=''//$v['pay_res_date']?></td>-->
								<td class="text-center"><?=$v['tower']?></td>
								<td class="text-center"><?=$v['prop_type']?></td><!--
								<td><?=''//$v['blok']?></td>
								<td><?=''//$v['kavling']?></td>
								<td><?=''//$v['luas_nett']?></td>
								<td><?=''//$v['luas_gross']?></td>-->
								<td class="text-right"><?=$v['bruto']?></td>
								<td class="text-center"><?=$v['cara_bayar']?></td>
								<td class="text-right"><?=$v['ra_um']?></td>
								<td class="text-center"><?=$v['ra_um_pr']?></td>
								<td class="text-right"><?=$v['ra_ag']?></td>
								<td class="text-center"><?=$v['ra_ag_pr']?></td>
								<td class="text-right"><?=$v['ri_um']?></td>
								<td class="text-center"><?=$v['ri_um_pr']?></td>
								<td class="text-right"><?=$v['ri_ag']?></td>
								<td class="text-center"><?=$v['ri_ag_pr']?></td>
								<td class="text-right"><?=$v['ri_total']?></td>
								<td class="text-center"><?=$v['ri_total_pr']?></td> 
								<td class="text-right"><?=$v['kurang_um']?></td>
								<td class="text-center"><?=$v['kurang_um_pr']?></td>
								<td class="text-right"><?=$v['kurang_ag']?></td>
								<td class="text-center"><?=$v['kurang_ag_pr']?></td>
								<td class="text-right"><?=$v['total_kurang']?></td>
								<td class="text-center"><?=$v['total_kurang_pr']?></td>
							</tr>
						<?php 
							$sumRAUM += str_replace(',','',$v['ra_um']);
							$sumRAAG += str_replace(',','',$v['ra_ag']);
							$sumRIUM += str_replace(',','',$v['ri_um']);
							$sumRIAG += str_replace(',','',$v['ri_ag']);
							$sumRIE += str_replace(',','',$v['ri_total']);
							$sumKRUM += str_replace(',','',$v['kurang_um']);
							$sumKRAG += str_replace(',','',$v['kurang_ag']);
							$sumKRE += str_replace(',','',$v['total_kurang']);
							$vbruto += str_replace(',','',$v['bruto']);
							$no++;
						} ?>
							<tr class="bg-primary light">
								<td colspan="5" class="text-right"><b>Total</b></td>
								<td class="text-right"><b><?=@number_format($vbruto,2)?></b></td>
								<td class="text-right">&nbsp;</td>
								<td class="text-right"><b><?=@number_format($sumRAUM,2)?></b></td>
								<td class="text-center"><b><?=@number_format($sumRAUM/$vbruto*100,2)?></b></td>
								<td class="text-right"><b><?=@number_format($sumRAAG,2)?></b></td>
								<td class="text-center"><b><?=@number_format($sumRAAG/$vbruto*100,2)?></b></td>
								<td class="text-right"><b><?=@number_format($sumRIUM,2)?></b></td>
								<td class="text-center"><b><?=@number_format($sumRIUM/$vbruto*100,2)?></b></td>
								<td class="text-right"><b><?=@number_format($sumRIAG,2)?></b></td>
								<td class="text-center"><b><?=@number_format($sumRIAG/$vbruto*100,2)?></b></td>
								<td class="text-right"><b><?=@number_format($sumRIE,2)?></b></td>
								<td class="text-center"><b><?=@number_format($sumRIE/$vbruto*100,2)?></b></td>
								<td class="text-right"><b><?=@number_format($sumKRUM,2)?></b></td>
								<td class="text-center"><b><?=@number_format($sumKRUM/$vbruto*100,2)?></b></td>
								<td class="text-right"><b><?=@number_format($sumKRAG,2)?></b></td>
								<td class="text-center"><b><?=@number_format($sumKRAG/$vbruto*100,2)?></b></td>
								<td class="text-right"><b><?=@number_format($sumKRE,2)?></b></td>
								<td class="text-center"><b><?=@number_format($sumKRE/$vbruto*100,2)?></b></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	
</section>
<!-- End: Content -->