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
							<h4 class="mbn">LAPORAN PROGNOSA PENAGIHAN</h4>
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
								<th rowspan="2" class="text-center" style="vertical-align:middle">No.</th>
								<th rowspan="2" class="text-center" style="vertical-align:middle">Customer</th>
								<th rowspan="2" class="text-center" style="vertical-align:middle">No. Unit</th>
								<!--<th rowspan="2" class="text-center" style="vertical-align:middle">Tanggal Bayar</th>-->
								<th rowspan="2" class="text-center" style="vertical-align:middle">Landed</th>
								<th rowspan="2" class="text-center" style="vertical-align:middle">Type</th>
								<th rowspan="2" class="text-center" style="vertical-align:middle">Bruto</th>
								<th rowspan="2" class="text-center" style="vertical-align:middle">Cara Bayar</th>
								
								<th colspan="3" class="text-center">RENCANA PEMBAYARAN</th>
								<!--th colspan="2" class="text-center">REALISASI PEMBAYARAN</th>
								<th colspan="4" class="text-center">KEKURANGAN PEMBAYARAN</th-->
								<th colspan="2" class="text-center">PROGNOSA</th>
							</tr>
							<tr class="bg-primary light">
								<!-- RA -->
								<th class="text-center">Minggu Lalu</th>
								<th class="text-center">Minggu Ini</th>
								<th class="text-center">TOTAL</th>
								<!-- REALISASI -->
								<!--th class="text-center">Minggu Ini</th>
								<th class="text-center">TOTAL</th>
								<!-- KEKURANGAN -->
								<!--th class="text-center">Minggu Lalu</th>
								<th class="text-center">MInggu Ini</th>
								<th class="text-center">TOTAL</th>
								<th class="text-center">Keterangan</th>
								<!-- JATUH TEMPO -->
								<th class="text-center">Minggu Depan</th>
								<th class="text-center">TOTAL s.d <?=@$data['end_prg_date'];?></th>
							</tr>
						</thead>
						<tbody>
						<?php 
						$no = 1;
						$sumBruto = $sumRaLalu = $sumRaIni = $sumRiIni = $sumKRLalu = $sumKRIni = $sumRaDepan = 0;
						foreach($data['datatable'] as $k => $v) { 
							$ra_lalu = $v['ra_um_lalu']+$v['ra_ag_lalu'];
							$ra_ini = $v['ra_um_ini']+$v['ra_ag_ini'];
							$ri_ini = $v['ri_um_lalu']+$v['ri_ag_lalu']+$v['ri_um_ini']+$v['ri_ag_ini'];
							// $ra_depan = $v['ra_um_depan'] + $v['ra_ag_depan'];
							$sisa_ri = $ri_ini;
							$kr_lalu = 0;
							if($ra_lalu>0) {
								$kr_lalu = $sisa_ri>$ra_lalu ? 0 : ($ra_lalu-$sisa_ri);
								$sisa_ri = $sisa_ri>$ra_lalu ? ($sisa_ri-$ra_lalu) : 0;
							}
							$kr_ini = 0;
							if($ra_ini>0) {
								$kr_ini = $sisa_ri>$ra_ini ? 0 : ($ra_ini-$sisa_ri);
								$sisa_ri = $sisa_ri>$ra_ini ? ($sisa_ri-$ra_ini) : 0;
							}
						?>
							<tr>
								<td class="text-center"><?=$no?></td>
								<td><?=$v['nsb_nama']?></td>
								<td class="text-center"><?=$v['no_unit']?></td>
								<td class="text-center"><?=$v['tower']?></td>
								<td class="text-center"><?=$v['prop_type']?></td>
								<td class="text-right"><?=number_format($v['bruto'],2)?></td>
								<td class="text-center"><?=$v['cara_bayar']?></td>
								<td class="text-right"><?=number_format($ra_lalu,2)?></td>
								<td class="text-right"><?=number_format($ra_ini,2)?></td>
								<td class="text-right"><?=number_format($ra_lalu+$ra_ini,2)?></td>
								<!--td class="text-right"><?=number_format($ri_ini,2)?></td>
								<td class="text-right"><?=number_format($ri_ini,2)?></td>
								<td class="text-right"><?=number_format($kr_lalu,2)?></td>
								<td class="text-right"><?=number_format($kr_ini,2)?></td>
								<td class="text-right"><?=number_format($kr_lalu+$kr_ini,2)?></td>
								<td>&nbsp;</td-->
								<td class="text-right"><?=number_format($v['ra_depan'],2)?></td>
								<td class="text-right"><?=number_format($kr_lalu+$kr_ini+$v['ra_depan'],2)?></td>
							</tr>
						<?php 
							$sumBruto += $v['bruto'];
							$sumRaLalu += $ra_lalu;
							$sumRaIni += $ra_ini;
							$sumRiIni += $ri_ini;
							$sumKRLalu += $kr_lalu;
							$sumKRIni += $kr_ini;
							$sumRaDepan += $v['ra_depan'];
							$no++;
						} ?>
							<tr class="bg-primary light">
								<td colspan="5" class="text-right"><b>Total</b></td>
								<td class="text-right"><b><?=@number_format($sumBruto,2)?></b></td>
								<td class="text-right">&nbsp;</td>
								<td class="text-right"><b><?=@number_format($sumRaLalu,2)?></b></td>
								<td class="text-right"><b><?=@number_format($sumRaIni,2)?></b></td>
								<td class="text-right"><b><?=@number_format($sumRaLalu+$sumRaIni,2)?></b></td>
								<!--td class="text-right"><b><?=@number_format($sumRiIni,2)?></b></td>
								<td class="text-right"><b><?=@number_format($sumRiIni,2)?></b></td>
								<td class="text-right"><b><?=@number_format($sumKRLalu,2)?></b></td>
								<td class="text-right"><b><?=@number_format($sumKRIni,2)?></b></td>
								<td class="text-right"><b><?=@number_format($sumKRLalu+$sumKRIni,2)?></b></td>
								<td>&nbsp;</td-->
								<td class="text-right"><b><?=@number_format($sumRaDepan,2)?></b></td>
								<td class="text-right"><b><?=@number_format($sumKRLalu+$sumKRIni+$sumRaDepan,2)?></b></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	
</section>
<!-- End: Content -->