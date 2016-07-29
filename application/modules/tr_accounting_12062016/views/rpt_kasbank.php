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
							<h4 class="mbn">LAPORAN KAS/BANK <?//(isset($data['divisi'])?strtoupper($data['divisi']['nama']):'')?></h4>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 text-center">
							<h5 class="mbn">PERIODE <?=@strtoupper($data['periode'])?></h5>
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
					<table id="example" class="table table-bordered mbn export2excel">
						<thead>
							<tr class="bg-primary light">
								<th class="text-center" rowspan="2">TANGGAL</th>
							    <th class="text-center" rowspan="2">NOMOR BUKTI</th>
							    <th class="text-center" rowspan="2">URAIAN</th>
							    <th class="text-center" colspan="2">MUTASI KAS</th>
							    <th class="text-center" rowspan="2">SALDO KAS</th>
							    <th class="text-center" colspan="2">MUTASI BANK</th>
							    <th class="text-center" rowspan="2">SALDO BANK</th>
							    <th class="text-center" rowspan="2">JUMLAH</th>
							</tr>
							<tr class="bg-primary light">
							    <td class="text-center">DEBIT</td>
							    <td class="text-center">KREDIT</td>
							    <td class="text-center">DEBIT</td>
							    <td class="text-center">KREDIT</td>
							</tr>
						</thead>
						<tbody>
							<?php
							//var_dump($data['rowsa']);
							$sa =($data['rowsa']['kas_saldoawal']+$data['rowsa']['bank_saldoawal']);
							$sa_ks_mut =($data['rowsa']['kas_saldoawal']);
							$sa_bs_mut =($data['rowsa']['bank_saldoawal']);
							?>
							<tr>
								<td class="text-right" colspan="3"><strong>SALDO AWAL</strong> (<i>dari periode sebelumnya</i>)</td>
							    <td class="text-right"><?//number_format($data['rowsa']['kas_debit'])?></td>
							    <td class="text-right"><?//number_format($data['rowsa']['kas_kredit'])?></td>
							    <td class="text-right"><?=number_format($data['rowsa']['kas_saldoawal'])?></td>
							    <td class="text-right"><?//number_format($data['rowsa']['bank_debit'])?></td>
							    <td class="text-right"><?//number_format($data['rowsa']['bank_kredit'])?></td>
							    <td class="text-right"><?=number_format($data['rowsa']['bank_saldoawal'])?></td>
							    <td class="text-right"><?=number_format(($data['rowsa']['kas_saldoawal']+$data['rowsa']['bank_saldoawal']))?></td>
							</tr>
						<?php
						//var_dump($data['rowsa']);die;
						$this->load->helper('combo');
						$bs_debit = 0;
						$bs_kredit = 0;
						$ks_debit = 0;
						$ks_kredit = 0;

						$bs_saldo = 0;
						$ks_saldo = 0;
						
						$d_mut = 0;
						$k_mut = 0;
						$s_mut = 0;

						$bank_sal = 0;

						$t_saldo_awal = 0;
						//var_dump($data['rows']);die;
						foreach ($data['rows'] as $k => $v) {
							$ks_debit += $v['KAS_DEBIT'];
							$ks_kredit += $v['KAS_KREDIT'];
							$ks_saldo = ($ks_saldo_awal + $ks_debit) - $ks_kredit;
							$ks_saldo += $ks_saldo;

							$bs_debit += $v['BANK_DEBIT'];
							$bs_kredit += $v['BANK_KREDIT'];
							$bs_saldo = ($bs_saldo_awal + $bs_debit) - $bs_kredit;
							$bs_saldo += $bs_saldo;
							//2015-12-31
							$tanggal = tgl_indo($v['TANGGAL'],'-');//substr($v['TANGGAL'],8,2).'-'.substr($v['TANGGAL'],5,2).'-'.substr($v['TANGGAL'],0,4);
							//if($v['KAS_DEBIT']>0 && $v['KAS_KREDIT']>0 && $v['SALDO_KAS']>0 && $v['BANK_DEBIT']>0 && $v['BANK_KREDIT']>0 && $v['SALDO_BANK']>0)	{
						
							$ks_mut = ($sa_ks_mut+$ks_debit)-$ks_kredit;
							$bs_mut = ($sa_bs_mut+$bs_debit)-$bs_kredit;
						?>
							<tr>
								<td class="text-center"><?=$tanggal?></td>
								<td class="text-center"><?=$v['NO_BUKTI']?></td>
								<td class="text-left"><?=$v['URAIAN']?></td>
								<td class="text-right"><?=number_format($v['KAS_DEBIT'])?></td>
								<td class="text-right"><?=number_format($v['KAS_KREDIT'])?></td>
								<td class="text-right"><?=number_format($ks_mut)?></td>
								<td class="text-right"><?=number_format($v['BANK_DEBIT'])?></td>
								<td class="text-right"><?=number_format($v['BANK_KREDIT'])?></td>
								<td class="text-right"><?=number_format($bs_mut)?></td>
								<td class="text-right"><?=number_format(($sa)+($v['SALDO_KAS']+$v['SALDO_BANK']))?></td>
							</tr>
						<?php
							//}
						}
						?>
						</tbody>
						<tfoot>
							<tr class="bg-primary light">
								<th colspan="3" class="text-right">SUB TOTAL</th>
								<th class="text-right"><?=number_format($ks_debit)?></th>
								<th class="text-right"><?=number_format($ks_kredit)?></th>
								<th class="text-right"></th>
								<th class="text-right"><?=number_format($bs_debit)?></th>
								<th class="text-right"><?=number_format($bs_kredit)?></th>
								<th class="text-right"></th>
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