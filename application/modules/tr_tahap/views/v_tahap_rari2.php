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
	a.tangan {
		cursor: pointer;
	}
</style>
<div class="loaderx"></div>
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
							<h4 class="mbn">LAPORAN TAHAP RENCANA (Ra) & REALISASI (Ri) <?=(isset($data['divisi'])?strtoupper($data['divisi']['nama']):'')?></h4>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 text-center">
							<h5 class="mbn">PERIODE <?=@strtoupper($data['periode'])?></h5>
							<input type="hidden" id="periode" name="periode" value="<?=$data['peuriode']?>">
						</div>
					</div>
					<div class="row">
						<div class="col-md-10">
							<p>Dicetak tanggal: <?=date('d/m/Y H:i:s')?>, Oleh: <?=$data['nama']?></p>
						</div>
						<div class="col-md-2 text-right">
							<button id="exp2excel" name="exp2excel">Export To Excel</button>
						</div>
					</div>
					<?php 
					
					?>
					<table id="t_bukubesar" class="table table-bordered mbn export2excel">
						<thead>
							<tr class="bg-primary light">
								<th class="text-center" rowspan="2">#</th>
								<th width='3%' align='center' rowspan="2">TAHAP</th>
								<th class='text-center' rowspan="2">SUMBERDAYA</th> 
								<th class='text-center' colspan="2">RENCANA AWAL</th>
								<th class='text-center' colspan="2">REALISASI</th>
								<th class='text-center' colspan="2">DEVIASI</th>
							</tr>
							<tr class="bg-primary light">
								<th class='text-center'>Kode</th>
								<th class='text-center'>Nama</th>
								<th class='text-center'>Vol</th>
								<th class='text-center'>Harga</th>
								<th class='text-center'>Vol</th>
								<th class='text-center'>Harga</th>
							</tr>
						</thead>
						<tbody>
						<?php
						$this->load->helper('generator');
						$n = 0;
						$x = 1;
						$group = '';
						$item = '';
						$t_ra_harga = 0;
						$t_ri_harga = 0;
						
						$kel_biaya = array(
								array('kode'=>'BL','nm_kel'=>'BIAYA LANGSUNG'),
								array('kode'=>'BTL','nm_kel'=>'BIAYA TIDAK LANGSUNG')
								);

						
						$i=1;
						$subclas="sub_".$v['kode'];
						foreach ($kel_biaya as $k => $v) {
						?>
							<tr id="<?=$v['kode']?>"class="alert alert-primary alert-border-bottom">
								<td class="text-center"><a class="tangan" onclick="show_child('<?=$v["kode"]?>','<?=$kode_spk?>','<?=$data['periode']?>')"><span id="spn_<?=$v['kode']?>" class="fa fa-chevron-down"></span></a></td>
								<td class="text-left" colspan="10"><b><?=$v['nm_kel']?></b></td>
							</tr>

						<?php
							echo tr_tahap_rari($v['kode'], $kode_spk, $data['peuriode'],$data['kde_div'],$v['saldo'],'sub_'.$v['kode'],'','class="'.$subclas.'"');
							$i++;
						}
							
							?>
							<tr class="bg-dark light">
								<th colspan="5" class="text-right">SUB TOTAL</th>
								<th class="text-right"><?=number_format($ks_debit)?></th>
								<th class="text-right"><?=number_format($ks_kredit)?></th>
								<th class="text-right"><?=number_format($ks_debit)?></th>
								<th class="text-right"><?=number_format($ks_kredit)?></th>
								<th class="text-right"><?=number_format($ks_debit)?></th>
								<th class="text-right"></th>
							</tr>
						</tbody>
						<tfoot>
							<tr class="bg-danger danger-border-bottom">
								<th colspan="5" class="text-right">GRAND TOTAL</th>
								<th class="text-right"><?=number_format($ks_debit)?></th>
								<th class="text-right"><?=number_format($ks_kredit)?></th>
								<th class="text-right"><?=number_format($ks_debit)?></th>
								<th class="text-right"><?=number_format($ks_kredit)?></th>
								<th class="text-right"><?=number_format($ks_debit)?></th>
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