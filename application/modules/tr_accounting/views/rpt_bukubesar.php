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
							<tr>
								<td class="text-right" colspan="3"><b>SALDO AWAL</b></td>
								<td class="text-center"></td>
							    <td class="text-center"></td>
							    <td class="text-right"><b><?=number_format($data['rows']['SA']['SALDO_AWAL'])?></b></td>
							</tr>
						<?php
						$this->load->helper('combo');
						$t_debit = 0;
						$t_kredit = 0;
						$t_saldo = 0;
						$t_saldo_awal = 0;
						foreach ($data['rows'] as $k => $v) {
							$t_debit += @($v['DK']=='D'?$v['RUPIAH']:0);
							$t_kredit += @($v['DK']=='K'?$v['RUPIAH']:0);
							$t_saldo = ($t_saldo_awal + $t_debit) - $t_kredit;
							$t_saldo += $t_saldo;
							//2015-12-31
							$tanggal = tgl_indo(@$v['TANGGAL'],'-');//substr($v['TANGGAL'],8,2).'-'.substr($v['TANGGAL'],5,2).'-'.substr($v['TANGGAL'],0,4);
						?>
							<tr>
								<td class="text-center"><?=@$tanggal?></td>
								<td class="text-center"><?=@$v['NO_BUKTI']?></td>
								<td class="text-left"><?=@$v['URAIAN']?></td>
								<td class="text-right"><?=@$v['DK']=='D'?number_format($v['RUPIAH']):0;?></td>
								<td class="text-right"><?=@$v['DK']=='K'?number_format($v['RUPIAH']):0;?></td>
								<td class="text-right"><?=@number_format($v['SALDO'])?></td>
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