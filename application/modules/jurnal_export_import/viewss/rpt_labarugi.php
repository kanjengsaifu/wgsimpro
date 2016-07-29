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
							<h4 class="mbn">LAPORAN LABA RUGI <?=(isset($data['divisi'])?strtoupper($data['divisi']['nama']):'')?></h4>
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
								<th class="text-center" style="vertical-align: middle" rowspan="2">URAIAN</th>
								<!--th class="text-center" colspan="3">KONSOLIDASI</th>
								<th class="text-center" colspan="3">DEPARTEMEN</th-->
									<th class="text-center" rowspan="2">S.D TAHUN LALU</th>
								<th class="text-center" colspan="4">TAHUN INI</th>
							</tr>
							<tr class="bg-primary light">
								<!-- 
									UNTUK DEPARTEMEN, YG HIDE DI UNHIDE SAJA 
								-->
								<!--th class="text-center">SALDO AWAL</th>
								<th class="text-center">MUTASI</th>
								<th class="text-center">S.D. SAAT INI</th>
								<th class="text-center">SALDO AWAL</th>
								<th class="text-center">MUTASI</th>
								<th class="text-center">S.D. SAAT INI</th-->
								
								<th class="text-center">S.D BULAN LALU</th>
								<th class="text-center">BULAN INI</th>
								<th class="text-center">S.D. BULAN INI</th>
								<th class="text-center">S.D. TAHUN INI</th>
							</tr>
						</thead>
						<tbody>
						<?php
						foreach ($data['datatable'] as $k => $v) {
						?>
							<tr>
								<td class="<?=$v['isbold']==='1' ? 'text-bold' : ''?>"><?=$v['description']?></td>
								<!--<td class="text-right <?=$v['isbold']==='1' ? 'text-bold' : ''?>"><?=$v['is_nonsum']==='0' ? number_format($v['rp_past_d']+$v['rp_past_p'],2) : ''?></td>
								<td class="text-right <?=$v['isbold']==='1' ? 'text-bold' : ''?>"><?=$v['is_nonsum']==='0' ? number_format($v['rp_now_d']+$v['rp_now_p'],2) : ''?></td>
								<td class="text-right <?=$v['isbold']==='1' ? 'text-bold' : ''?>"><?=$v['is_nonsum']==='0' ? number_format($v['rp_past_d']+$v['rp_now_d']+$v['rp_past_p']+$v['rp_now_p'],2) : ''?></td>
								<td class="text-right <?=$v['isbold']==='1' ? 'text-bold' : ''?>"><?=$v['is_nonsum']==='0' ? number_format($v['rp_past_d'],2) : ''?></td>
								<td class="text-right <?=$v['isbold']==='1' ? 'text-bold' : ''?>"><?=$v['is_nonsum']==='0' ? number_format($v['rp_now_d'],2) : ''?></td>
								<td class="text-right <?=$v['isbold']==='1' ? 'text-bold' : ''?>"><?=$v['is_nonsum']==='0' ? number_format($v['rp_past_d']+$v['rp_now_d'],2) : ''?></td>-->
								<!-- sd tahun lalu-->
								<td class="text-right <?=$v['isbold']==='1' ? 'text-bold' : ''?>"><?=$v['is_nonsum']==='0' ? number_format($v['rp_y_past_p'],2) : ''?></td>
								<!-- sd bulan ini -->
								<td class="text-right <?=$v['isbold']==='1' ? 'text-bold' : ''?>"><?=$v['is_nonsum']==='0' ? number_format($v['rp_past_p'],2) : ''?></td>
								<!-- bulan ini -->
								<td class="text-right <?=$v['isbold']==='1' ? 'text-bold' : ''?>"><?=$v['is_nonsum']==='0' ? number_format($v['rp_now_p'],2) : ''?></td>
								<!-- sd bulan ini -->
								<td class="text-right <?=$v['isbold']==='1' ? 'text-bold' : ''?>"><?=$v['is_nonsum']==='0' ? number_format($v['rp_past_p']+$v['rp_now_p'],2) : ''?></td>
								<!-- sd tahun ini -->
								<td class="text-right <?=$v['isbold']==='1' ? 'text-bold' : ''?>"><?=$v['is_nonsum']==='0' ? number_format($v['rp_y_past_p']+($v['rp_past_p']+$v['rp_now_p']),2) : ''?></td>
							</tr>
						<?php
						}
						?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	
</section>
<!-- End: Content -->