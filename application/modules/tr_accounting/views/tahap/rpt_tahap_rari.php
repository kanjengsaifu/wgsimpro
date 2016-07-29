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
					<table id="t_bukubesar" class="table table-bordered mbn export2excel">
						<thead>
							<tr class="bg-primary light">
								<th class="text-center">#</th>
								<th width='3%' align='center'>KELOMPOK BIAYA</th>
								<th align='center'>TANGGAL</th> 
								<th align='center'>KODE COA</th>
								<th align='center'>URAIAN</th>
								<th align='center'>SUMBERDAYA</th>
								<th align='center'>RENCANA</th>
								<th align='center'>REALISASI</th>
							</tr>
						</thead>
						<tbody>
						<?php
						$coa = $data['rowsa']['coa'];
						$sal_awal = $data['rowsa']['saldo'];
						$kode_spk = $this->session->userdata('kode_entity');
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
						
						$i=1;
						foreach ($data['rowsa'] as $k => $v) {
							$ks_debit += $v['debit'];
							$ks_kredit += $v['kredit'];
							$ks_saldo = ($ks_saldo_awal + $ks_debit) - $ks_kredit;
							$ks_saldo += $ks_saldo;

							//2015-12-31
							$tanggal = tgl_indo($v['tanggal'],'-');//substr($v['TANGGAL'],8,2).'-'.substr($v['TANGGAL'],5,2).'-'.substr($v['TANGGAL'],0,4);
							//if($v['KAS_DEBIT']>0 && $v['KAS_KREDIT']>0 && $v['SALDO_KAS']>0 && $v['BANK_DEBIT']>0 && $v['BANK_KREDIT']>0 && $v['SALDO_BANK']>0)	{
						
							$ks_mut = ($sa_ks_mut+$ks_debit)-$ks_kredit;
							$bs_mut = ($sa_bs_mut+$bs_debit)-$bs_kredit;
							$sal_akhir = $ks_debit-$ks_kredit;
						?>
							<tr id="<?=$v['kode_coa']?>" bgcolor="#FFCC66;">
								<td class="text-center"><a class="tangan" onclick="show_child('BL','<?=$kode_spk?>','<?=$data['peuriode']?>')"><span id="spn_<?=$v['kode_coa']?>" class="fa fa-chevron-down"></span></a></td>
								<td class="text-center"><b><?=$v['kode_coa']?></b></td>
								<td class="text-left" colspan="5"><b><?=$v['nama_akun']?></b></td>
								<!--td class="text-right"><?=number_format($v['debit'])?></td>
								<td class="text-right"><?=number_format($v['kredit'])?></td-->
								<td class="text-right"><b><?=number_format($v['saldo'])?></b></td>
							</tr>
							<?php $this->load->helper('generator');
							$subclas="sub_".$v['kode_coa'];
							
							//$kelompok_biaya, $kode_spk, $periode, $tr_idname='', $tr_varval='', $tr_class='', $td_idname='', $td_varval='', $td_class='', $extra=''
							?>
							
							<?=tr_tahap_rari('BL',$kode_spk, $data['peuriode'],$data['kde_div'],$v['saldo'],'sub_'.$v['kode_coa'],'','class="'.$subclas.'"')?>
							
							
						<?php
							$i++;
						}
						?>
						</tbody>
						<tfoot>
							<tr class="bg-primary light">
								<th colspan="5" class="text-right">GRAND TOTAL</th>
								<th class="text-right"><?=number_format($ks_debit)?></th>
								<th class="text-right"><?=number_format($ks_kredit)?></th>
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