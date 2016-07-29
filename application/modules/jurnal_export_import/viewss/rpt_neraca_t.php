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

<div class="loader"></div>
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
							<?php 
								$kd_unitkerja	= $this->session->userdata('unit_kerja');
							 	$unit_kerja 	= $kd_unitkerja=='KAWASAN'?$this->session->userdata('kode_entity'):'';
							 	$label_top 		= $kd_unitkerja=='KAWASAN'?'KAWASAN '.$data['kawasan']:'LAPORAN POSISI KEUANGAN '.(isset($data['divisi'])?strtoupper($data['divisi']['nama']):'');
							?>
							<h5 class="mbn"><?=$label_top?></h5>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 text-center">
							<h4 class="mbn">LAPORAN POSISI KEUANGAN</h4>
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
								<th class="text-center">ASET LANCAR</th>
								<th class="text-center">DESEMBER <?=@($data['periode_t'])-1?></th>
								<th class="text-center"><?=@strtoupper($data['periode'])?></th>
								<th class="text-center">UTANG JANGKA PENDEK</th>
								<th class="text-center">DESEMBER <?=@($data['periode_t'])-1?></th>
								<th class="text-center"><?=@strtoupper($data['periode'])?></th>
								
							</tr>
						</thead>
						<tbody>
						<?php
						foreach ($data['datatable'] as $k => $v) {
						?>
							<tr>
								<td class="<?=$v['l_bold']==='1' ? 'text-bold' : ''?>"><?=$v['l_desc']?></td>
								<td class="text-right <?=$v['l_bold']==='1' ? 'text-bold' : ''?>"><?=$v['l_nonsum']==='0' ? $v['l_rpmin1thn'] : ''?></td> <!-- DES -->
								<td class="text-right <?=$v['l_bold']==='1' ? 'text-bold' : ''?>"><?=$v['l_nonsum']==='0' ? $v['l_rpmin1bln'] : ''?></td>
								<td class="<?=$v['r_bold']==='1' ? 'text-bold' : ''?>"><?=$v['r_desc']?></td>
								<td class="text-right <?=$v['r_bold']==='1' ? 'text-bold' : ''?>"><?=$v['r_nonsum']==='0' ? $v['r_rpmin1thn'] : ''?></td> <!-- DES -->
								<td class="text-right <?=$v['r_bold']==='1' ? 'text-bold' : ''?>"><?=$v['r_nonsum']==='0' ? $v['r_rpmin1bln'] : ''?></td>
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