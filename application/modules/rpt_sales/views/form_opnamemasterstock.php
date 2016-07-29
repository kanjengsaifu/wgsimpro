<!-- Begin: Content -->
<section id="content">
	<style>
		/*table.dataTable {
		  width: 100%!important;
		}*/
		thead.dataTable{
		  width: 100%!important;
		}
		.hBiru{
			background-color: #649ae1 !important;
			color: #ffffff;
		}
	</style>
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
							<h5 class="mbn"><?=@$data['kawasan']?></h5>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 text-center">
							<h4 class="mbn">LAPORAN MASTER STOCK OPNAME <?=isset($data['addtitle'])?$data['addtitle']:''?></h4>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 text-center">
							<h5 class="mbn">Periode s/d <?=@$data['periode']?></h5>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<p>Dicetak tanggal: <?=date('d/m/Y H:i:s')?>, Oleh: <?=$data['nama']?></p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
					<table id="datatable" class="table table-bordered mbn">
						<thead>
							<tr>
								<th rowspan="2" class="text-center hBiru" style="vertical-align:middle;">No.</th>
								<th rowspan="2" class="text-center hBiru" style="vertical-align:middle;">BLOK </th>
								<th rowspan="2" class="text-center hBiru" style="vertical-align:middle;">UNIT</th>
								<th colspan="3" class="text-center hBiru" style="vertical-align:middle;">LUAS TANAH (M2)</th>
								<th rowspan="2" class="text-center hBiru" style="vertical-align:middle;">KONSUMEN</th>
								<th colspan="2" class="text-center hBiru" style="vertical-align:middle;">TERJUAL</th>
								<th colspan="2" class="text-center hBiru" style="vertical-align:middle;">TERPESAN</th>
								<th colspan="2" class="text-center hBiru" style="vertical-align:middle;">STOCK</th>
							</tr> 
							<tr>
								<th class="text-center hBiru">SITE PLAN</th>
								<th class="text-center hBiru">STAKE OUT</th>
								<th class="text-center hBiru">HASIL UKUR BPN</th>
								<th class="text-center hBiru">UNIT</th>
								<th class="text-center hBiru">LUAS (M2)</th>
								<th class="text-center hBiru">UNIT</th>
								<th class="text-center hBiru">LUAS (M2)</th>
								<th class="text-center hBiru">UNIT</th>
								<th class="text-center hBiru">LUAS (M2)</th>
							</tr>
						</thead>
						<tbody>
						<?php 
						$no = 1;
						$sumTerjual = $sumTerpesan = $sumStock = $sumTerjual2 = $sumTerpesan2 = $sumStock2 = 0;
						foreach($data['datatable'] as $k => $v) {
							$r = (object) $v;
							$terjual = ($r->status ==='terjual')?1:'';
							$terpesan = ($r->status ==='terpesan')?1:'';
							$stock = ($r->status ==='stock')?1:'';
							$terjualm2 = ($r->status ==='terjual')?$r->bpn:'';
							$terpesanm2 = ($r->status ==='terpesan')?$r->bpn:'';
							$stockm2 = ($r->status ==='stock')?$r->bpn:'';
							$sumTerjual += ($r->status ==='terjual')?1:0;
							$sumTerpesan += ($r->status ==='terpesan')?1:0;
							$sumStock += ($r->status ==='stock')?1:0;
							$sumTerjual2 += ($r->status ==='terjual')?$r->bpn:0;
							$sumTerpesan2 += ($r->status ==='terpesan')?$r->bpn:0;
							$sumStock2 += ($r->status ==='stock')?$r->bpn:0;
						?>
							<tr>
								<td class="text-center"><?=$no?></td>
								<td class="text-center"><?=$r->kavling ?></td>
								<td class="text-center"><?=$r->no_unit ?></td>
								<td class="text-center"><?=$r->siteplan ?></td>
								<td class="text-center"><?=$r->stakeout ?></td>
								<td class="text-center"><?=$r->bpn ?></td>
								<td class="text-left"><?=$r->nama ?></td>
								<td class="text-center"><?=$terjual ?></td>
								<td class="text-center"><?=$terjualm2 ?></td>
								<td class="text-center"><?=$terpesan ?></td>
								<td class="text-center"><?=$terpesanm2 ?></td>
								<td class="text-center"><?=$stock ?></td>
								<td class="text-center"><?=$stockm2 ?></td>
							</tr>
						<?php 
							$no++;
						} ?>
							<tr>
								<td class="text-center"></td>
								<td class="text-center"></td>
								<td class="text-center"></td>
								<td class="text-center"></td>
								<td class="text-center"></td>
								<td class="text-center"></td>
								<td class="text-right"><b>TOTAL</b></td>
								<td class="text-center"><b><?=$sumTerjual ?></b></td>
								<td class="text-center"><b><?=$sumTerjual2 ?></b></td>
								<td class="text-center"><b><?=$sumTerpesan ?></b></td>
								<td class="text-center"><b><?=$sumTerpesan2 ?></b></td>
								<td class="text-center"><b><?=$sumStock ?></b></td>
								<td class="text-center"><b><?=$sumStock2 ?></b></td>
							</tr>
						</tbody>
					</table>
					</div>
				</div>
				</div>
			</div>
		</div>
	</div>
	
</section>
<!-- End: Content -->