<!-- Begin: Content -->
<section id="content">
    <div class="row">
		<div class="col-md-12 pn">
			<div class="panel mbn">
				<div class="panel-body" style="overflow-x: scroll;">
					<div class="row">
						<div class="col-md-12">
							<!--<h4 class="mbn">PT WIJAYA KARYA REALTY</h4>-->
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 text-center">
							<h4 class="mbn">LAPORAN KONSOLIDASI OK</h4>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 text-center">
							<h5 class="mbn">Periode <?=@$data['periode']?></h5>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<p>Dicetak tanggal: <?=date('d').' '.@$data['periode']?>, Oleh: <?=@$data['nama']?></p>
						</div>
					</div>
					<table id="example" class="table table-bordered mbn" style="font-size: 12px!important">
						<thead>
							<tr class="bg-primary light">
								<th rowspan="2" class="text-center">No.</th>
								<th rowspan="2" class="text-center">UNIT PPU</th>
								<th rowspan="2" class="text-center">Carry Over<br>Tahun Lalu</th>
								<th colspan="3" class="text-center">Realisasi</th>
								<th rowspan="2" class="text-center" style="vertical-align:middle">Reserve</th>
							</tr>
							<tr class="bg-primary light">
								<th class="text-center">Minggu Lalu</th>
								<th class="text-center">Minggu Ini</th>
								<th class="text-center">s.d Minggu Ini</th>
							</tr>
						</thead>
						<tbody>
						<?php
						$nourut=$ttl=1;
						$chk = array();
						$dir = $ent = "";
						foreach($data['datatable'] as $k => $v) {
							$r = (object) $v;
							$chk['rithlalu'][$r->direktorat][]=$r->rithlalu;
							$chk['rimglalu'][$r->direktorat][]=$r->rimglalu;
							$chk['rimgini'][$r->direktorat][]=$r->rimgini;
							$chk['risdmgini'][$r->direktorat][]=$r->risdmgini;
							$chk['reserveini'][$r->direktorat][]=$r->reserveini;
							$chk['rinettothlalu'][$r->direktorat][]=$r->rinettothlalu;
							$chk['rinettolalu'][$r->direktorat][]=$r->rinettolalu;
							$chk['rinettoini'][$r->direktorat][]=$r->rinettoini;
							$chk['rinettosdini'][$r->direktorat][]=$r->rinettosdini;
							$chk['reservenetto'][$r->direktorat][]=$r->reservenetto;
							$chk['rigrossthlalu'][$r->direktorat][]=$r->rigrossthlalu;
							$chk['rigrosslalu'][$r->direktorat][]=$r->rigrosslalu;
							$chk['rigrossini'][$r->direktorat][]=$r->rigrossini;
							$chk['rigrosssdini'][$r->direktorat][]=$r->rigrosssdini;
							$chk['reservegross'][$r->direktorat][]=$r->reservegross;
							$chk['ribayarthlalu'][$r->direktorat][]=$r->ribayarthlalu;
							$chk['ribayarlalu'][$r->direktorat][]=$r->ribayarlalu;
							$chk['ribayarini'][$r->direktorat][]=$r->ribayarini;
							$chk['ribayarsdini'][$r->direktorat][]=$r->ribayarsdini;
							$chk['reservejmlh'][$r->direktorat][]=$r->reservejmlh;
						?>
							<? if($dir != $r->direktorat): 
								$nourut=1;
							?>
							<tr>
								<td colspan="7"><b><?=$r->direktorat?></b></td>
							</tr>
							<? 
								$ttl++;
								$dir = $r->direktorat;
							endif;?>
							<? if($ent != $r->type_entity): ?>
							<tr>
								<td colspan="7"><b>&nbsp;&nbsp;<?=$r->nama_entity?></b></td>
							</tr>
							<? 
								$ent = $r->type_entity;
							endif;?>
							<tr>
								<td class="text-center"><b><?=$nourut?></b></td>
								<td colspan="6"><b><?=$r->nama?></b></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>- Unit</td>
								<td class="text-right"><?=number_format($r->rithlalu,0)?></td>
								<td class="text-right"><?=number_format($r->rimglalu,0)?></td>
								<td class="text-right"><?=number_format($r->rimgini,0)?></td>
								<td class="text-right"><?=number_format($r->risdmgini,0)?></td>
								<td class="text-right"><?=number_format($r->reserveini,0)?></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>- Luas Bang</td>
								<td class="text-right"><?=number_format($r->rinettothlalu,0)?></td>
								<td class="text-right"><?=number_format($r->rinettolalu,0)?></td>
								<td class="text-right"><?=number_format($r->rinettoini,0)?></td>
								<td class="text-right"><?=number_format($r->rinettosdini,0)?></td>
								<td class="text-right"><?=number_format($r->reservenetto,0)?></td>
							</tr>
							<? if($r->type_entity === 'LD'): ?>
							<tr>
								<td>&nbsp;</td>
								<td>- Luas Tanah</td>
								<td class="text-right"><?=number_format($r->rigrossthlalu,0)?></td>
								<td class="text-right"><?=number_format($r->rigrosslalu,0)?></td>
								<td class="text-right"><?=number_format($r->rigrossini,0)?></td>
								<td class="text-right"><?=number_format($r->rigrosssdini,0)?></td>
								<td class="text-right"><?=number_format($r->reservegross,0)?></td>
							</tr>
							<? endif;?>
							<tr>
								<td>&nbsp;</td>
								<td>- Omzet Netto</td>
								<td class="text-right"><?=number_format($r->ribayarthlalu,0)?></td>
								<td class="text-right"><?=number_format($r->ribayarlalu,0)?></td>
								<td class="text-right"><?=number_format($r->ribayarini,0)?></td>
								<td class="text-right"><?=number_format($r->ribayarsdini,0)?></td>
								<td class="text-right"><?=number_format($r->reservejmlh,0)?></td>
							</tr>
						<? 
						$nourut++;
						} ?>
							<tr>
								<td colspan="7">&nbsp;</td>
							</tr>
							<? $drr = array('DIR1','DIR2'); 
							   foreach($drr as $dr){?>
							<tr>
								<td><b>Total <?=$dr ?></b></td>
								<td>- Unit</td>
								<td class="text-right"><?=number_format(array_sum($chk['rithlalu'][$dr]),0)?></td>
								<td class="text-right"><?=number_format(array_sum($chk['rimglalu'][$dr]),0)?></td>
								<td class="text-right"><?=number_format(array_sum($chk['rimgini'][$dr]),0)?></td>
								<td class="text-right"><?=number_format(array_sum($chk['risdmgini'][$dr]),0)?></td>
								<td class="text-right"><?=number_format(array_sum($chk['reserveini'][$dr]),0)?></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>- Luas Bang</td>
								<td class="text-right"><?=number_format(array_sum($chk['rinettothlalu'][$dr]),0)?></td>
								<td class="text-right"><?=number_format(array_sum($chk['rinettolalu'][$dr]),0)?></td>
								<td class="text-right"><?=number_format(array_sum($chk['rinettoini'][$dr]),0)?></td>
								<td class="text-right"><?=number_format(array_sum($chk['rinettosdini'][$dr]),0)?></td>
								<td class="text-right"><?=number_format(array_sum($chk['reservenetto'][$dr]),0)?></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>- Luas Tanah</td>
								<td class="text-right"><?=number_format(array_sum($chk['rigrossthlalu'][$dr]),0)?></td>
								<td class="text-right"><?=number_format(array_sum($chk['rigrosslalu'][$dr]),0)?></td>
								<td class="text-right"><?=number_format(array_sum($chk['rigrossini'][$dr]),0)?></td>
								<td class="text-right"><?=number_format(array_sum($chk['rigrosssdini'][$dr]),0)?></td>
								<td class="text-right"><?=number_format(array_sum($chk['reservegross'][$dr]),0)?></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>- Omzet Netto</td>
								<td class="text-right"><?=number_format(array_sum($chk['ribayarthlalu'][$dr]),0)?></td>
								<td class="text-right"><?=number_format(array_sum($chk['ribayarlalu'][$dr]),0)?></td>
								<td class="text-right"><?=number_format(array_sum($chk['ribayarini'][$dr]),0)?></td>
								<td class="text-right"><?=number_format(array_sum($chk['ribayarsdini'][$dr]),0)?></td>
								<td class="text-right"><?=number_format(array_sum($chk['reservejmlh'][$dr]),0)?></td>
							</tr>
							<? } ?>
							<tr>
								<td colspan="7">&nbsp;</td>
							</tr>
							<tr>
								<td><b>Total WIKA Realty</b></td>
								<td>- Unit</td>
								<td class="text-right"><?=number_format(array_sum($chk['rithlalu']),0)?></td>
								<td class="text-right"><?=number_format(array_sum($chk['rimglalu']),0)?></td>
								<td class="text-right"><?=number_format(array_sum($chk['rimgini']),0)?></td>
								<td class="text-right"><?=number_format(array_sum($chk['risdmgini']),0)?></td>
								<td class="text-right"><?=number_format(array_sum($chk['reserveini']),0)?></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>- Luas Bang</td>
								<td class="text-right"><?=number_format(array_sum($chk['rinettothlalu']),0)?></td>
								<td class="text-right"><?=number_format(array_sum($chk['rinettolalu']),0)?></td>
								<td class="text-right"><?=number_format(array_sum($chk['rinettoini']),0)?></td>
								<td class="text-right"><?=number_format(array_sum($chk['rinettosdini']),0)?></td>
								<td class="text-right"><?=number_format(array_sum($chk['reservenetto']),0)?></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>- Luas Tanah</td>
								<td class="text-right"><?=number_format(array_sum($chk['rigrossthlalu']),0)?></td>
								<td class="text-right"><?=number_format(array_sum($chk['rigrosslalu']),0)?></td>
								<td class="text-right"><?=number_format(array_sum($chk['rigrossini']),0)?></td>
								<td class="text-right"><?=number_format(array_sum($chk['rigrosssdini']),0)?></td>
								<td class="text-right"><?=number_format(array_sum($chk['reservegross']),0)?></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>- Omzet Netto</td>
								<td class="text-right"><?=number_format(array_sum($chk['ribayarthlalu']),0)?></td>
								<td class="text-right"><?=number_format(array_sum($chk['ribayarlalu']),0)?></td>
								<td class="text-right"><?=number_format(array_sum($chk['ribayarini']),0)?></td>
								<td class="text-right"><?=number_format(array_sum($chk['ribayarsdini']),0)?></td>
								<td class="text-right"><?=number_format(array_sum($chk['ribayarsdini']),0)?></td>
								<td class="text-right"><?=number_format(array_sum($chk['reservejmlh']),0)?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	
</section>
<!-- End: Content -->