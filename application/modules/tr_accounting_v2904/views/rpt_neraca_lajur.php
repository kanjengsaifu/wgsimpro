<!-- Begin: Content -->
<style>
.text-bold {
	font-weight: bold;
}
.loader {
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
	background: url('<?=base_url()?>assets/img/spinner.gif') 50% 50% no-repeat rgb(249,249,249);
}
</style>
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
							<h4 class="mbn">LAPORAN NERACA LAJUR <?=(isset($data['divisi'])?strtoupper($data['divisi']['nama']):'')?></h4>
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
								<th class="text-center" style="vertical-align: middle" colspan="2" rowspan="2">URAIAN</th>
								<th class="text-center" colspan="2">NERACA AWAL</th>
								<th class="text-center" colspan="2">MUTASI</th>
								<th class="text-center" colspan="2">NERACA PERCOBAAN</th>
							</tr>
							<tr class="bg-primary light">
								<th class="text-center">DEBET</th>
								<th class="text-center">KREDIT</th>
								<th class="text-center">DEBET</th>
								<th class="text-center">KREDIT</th>
								<th class="text-center">DEBET</th>
								<th class="text-center">KREDIT</th>
							</tr>
						</thead>
						<tbody>
						<?php
						$sumSA_d = $sumSA_k = $sumNOW_d = $sumNOW_k = $sumD = $sumK = 0;
						foreach ($data['datatable'] as $k => $v) {
							$sumSA_d += $v['sa_d'];
							$sumSA_k += $v['sa_k'];
							$sumNOW_d += $v['now_d'];
							$sumNOW_k += $v['now_k'];
							$xSum = ($v['sa_d']+$v['now_d']) - ($v['sa_k']+$v['now_k']);
							$rp_d = $xSum >= 0 ? $xSum : 0;
							$rp_k = $xSum < 0 ? $xSum*-1 : 0;
							$sumD += $rp_d;
							$sumK += $rp_k;
						?>
							<tr>
								<td class="text-center"><?=$v['kode']?></td>
								<td><?=$v['nama']?></td>
								<td class="text-right"><?=number_format($v['sa_d'])?></td>
								<td class="text-right"><?=number_format($v['sa_k'])?></td>
								<td class="text-right"><?=number_format($v['now_d'])?></td>
								<td class="text-right"><?=number_format($v['now_k'])?></td>
								<td class="text-right"><?=number_format($rp_d)?></td>
								<td class="text-right"><?=number_format($rp_k)?></td>
							</tr>
						<?php
						}
						?>
							<tr>
								<td class="text-right" colspan="2"><b>Jumlah</b></td>
								<td class="text-right"><b><?=number_format($sumSA_d)?></b></td>
								<td class="text-right"><b><?=number_format($sumSA_k)?></b></td>
								<td class="text-right"><b><?=number_format($sumNOW_d)?></b></td>
								<td class="text-right"><b><?=number_format($sumNOW_k)?></b></td>
								<td class="text-right"><b><?=number_format($sumD)?></b></td>
								<td class="text-right"><b><?=number_format($sumK)?></b></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	
</section>
<!-- End: Content -->