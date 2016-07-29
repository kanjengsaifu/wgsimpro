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
					<table id="example" class="table table-bordered mbn">
						<thead>
							<tr class="bg-primary light">
								<th rowspan="2" class="text-center">No.</th>
								<th rowspan="2" class="text-center">UNIT PPU</th>
								<th colspan="8" class="text-center">Tahun ini</th>
								<th rowspan="2" class="text-center" style="vertical-align:middle">Reserve</th>
							</tr>
							<tr class="bg-primary light">
								<th class="text-center">Minggu Lalu</th>
								<th class="text-center">Minggu Ini</th>
								<th class="text-center">Pembatalan Minggu Lalu</th>
								<th class="text-center">s.d Minggu Ini</th>
								<th class="text-center">Ra. s.d Minggu Lalu</th>
								<th class="text-center">Ra. s.d Minggu Ini</th>
								<th class="text-center">Ra. s.d Minggu Depan</th>
								<th class="text-center">RKAP</th>
							</tr>
						</thead>
						<tbody>
						<?php
						$arrData = isset($data['datatable']) ? $data['datatable'] : array();
						foreach($arrData as $ktype => $vtype) { ?>
							<tr>
								<td colspan="11"><b><?=$ktype?></b></td>
							</tr>
						<?php 
							$sumF1 = $sumG1 = $sumH1 = $sumI1 = $sumJ1 = $sumK1 = $sumN1 = 0;
							$sumF2 = $sumG2 = $sumH2 = $sumI2 = $sumJ2 = $sumK2 = $sumN2 = 0;
							$sumF3 = $sumG3 = $sumH3 = $sumI3 = $sumJ3 = $sumK3 = $sumN3 = 0;
							$sumF4 = $sumG4 = $sumH4 = $sumI4 = $sumJ4 = $sumK4 = $sumN4 = 0;

							$sumRaL1 = $sumRaI1 = $sumRaD1 = 0;
							$sumRaL2 = $sumRaI2 = $sumRaD2 = 0;
							$sumRaL3 = $sumRaI3 = $sumRaD3 = 0;
							$sumRaL4 = $sumRaI4 = $sumRaD4 = 0;

							$sumRaLWn4 = $sumRaIWn4 =  $sumRaDWn4 = 0;
							$sumRaLWn3 = $sumRaIWn3 =  $sumRaDWn4 = 0;
							$sumRaLWn2 = $sumRaIWn2 =  $sumRaDWn4 = 0;
							$sumRaLWn1 = $sumRaIWn1 =  $sumRaDWn4 = 0;

							$sumRaLWg4 = $sumRaIWg4 =  $sumRaDWg4 = 0;
							$sumRaLWg3 = $sumRaIWg3 =  $sumRaDWg4 = 0;
							$sumRaLWg2 = $sumRaIWg2 =  $sumRaDWg4 = 0;
							$sumRaLWg1 = $sumRaIWg1 =  $sumRaDWg4 = 0;

							$nourut = 1;
							foreach ($vtype as $kkode => $vkode) {
								$theF = isset($vkode['unit']['F'])?$vkode['unit']['F']:0;
								$theG = isset($vkode['unit']['G'])?$vkode['unit']['G']:0;
								$theH = isset($vkode['unit']['H'])?$vkode['unit']['H']:0;
								$theI = $theF+$theG;
								$theJ = isset($vkode['ra_unit']['F'])?$vkode['ra_unit']['F']:0;
								$theK = isset($vkode['ra_unit_ini']['K'])?$vkode['ra_unit_ini']['K']:0;
								$theL = isset($vkode['ra_unit_depan']['L'])?$vkode['ra_unit_depan']['L']:0;
								$theN = isset($vkode['unit']['N'])?$vkode['unit']['N']:0; //Jumlah status Reserve

								$theRaL = isset($vkode['ra_lalu']['F'])?$vkode['ra_lalu']['F']:0;
								$theRaI = isset($vkode['ra_ini']['F'])?$vkode['ra_ini']['F']:0;
								$theRaD = isset($vkode['ra_depan']['F'])?$vkode['ra_depan']['F']:0;

								$theIni = isset($vkode['ra_unit']['F'])?$vkode['ra_unit']['F']:0;
								$theIWn = isset($vkode['ra_unit']['F'])?$vkode['ra_unit']['F']:0;

								$sumF1 += $theF;
								$sumG1 += $theG;
								$sumH1 += $theH;
								$sumI1 += $theI;
								$sumJ1 += $theJ;
								$sumK1 += $theK;
								$sumN1 += $theN;

								$sumRaL1 += $theRaL;
								$sumRaI1 += $theRaI;
								$sumRaD1 += $theRaD;

								$sumRaIWn1 += $theIWn;

						?>
							<tr>
								<td class="text-center"><b><?=$nourut?></b></td>
								<td colspan="10"><b><?=$kkode?></b></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>- Unit</td>
								<td class="text-right"><?=$theF?></td>
								<td class="text-right"><?=$theG?></td>
								<td class="text-right"><?=$theH?></td>
								<td class="text-right"><?=$theI?></td>
								<td class="text-right"><?=$theJ?></td>
								<td class="text-right"><?=$theK?></td>
								<td class="text-right"></td>
								<td class="text-right"><?=$theK?></td>
								<td class="text-right"><?=$theN?></td>
							</tr>
						<?php 
								$theF = isset($vkode['netto']['F'])?$vkode['netto']['F']:0;
								$theG = isset($vkode['netto']['G'])?$vkode['netto']['G']:0;
								$theH = isset($vkode['canceled']['H'])?$vkode['pebatalan']['H']:0;
								$theI = $theF+$theG;
								$theJ = isset($vkode['ra_unit']['F'])?$vkode['ra_unit']['F']:0;
								$theK = 0;
								$theN = isset($vkode['netto']['N'])?$vkode['netto']['N']:0;

								$theRaL = isset($vkode['ra_lalu']['F'])?$vkode['ra_lalu']['F']:0;
								$theRaI = isset($vkode['ra_ini']['G'])?$vkode['ra_ini']['G']:0;
								$theRaD = isset($vkode['ra_depan']['H'])?$vkode['ra_depan']['H']:0;

								$sumF2 += $theF;
								$sumG2 += $theG;
								$sumH2 += $theH;
								$sumI2 += $theI;
								$sumJ2 += $theJ;
								$sumK2 += $theK;
								$sumN2 += $theN;

								$sumRaL2 += $theRaL;
								$sumRaI2 += $theRaI;
								$sumRaD2 += $theRaD;
								$theRaLWn = isset($vkode['ra_l_wn']['F'])?$vkode['ra_l_wn']['F']:0;
								$sumRaLWn2 += $theRaLWn;
								$theRaIWn = isset($vkode['ra_i_wn']['F'])?$vkode['ra_i_wn']['F']:0;
								$sumRaIWn2 += $theRaIWn;
						?>
							<tr>
								<td>&nbsp;</td>
								<td>- <?=$ktype==='Highrise'?'Luas Netto':'Luas Bang'?></td>
								<td class="text-right"><?=$theF?></td>
								<td class="text-right"><?=$theG?></td>
								<td class="text-right"><?=$theH?></td>
								<td class="text-right"><?=$theI?></td>
								<td class="text-right"><?=$theRaLWn?></td>
								<td class="text-right"><?=$theRaIWn?></td>
								<td class="text-right"></td>
								<td class="text-right"><?=$theK?></td>
								<td class="text-right"><?=$theN?></td>
							</tr>
						<?php 
								$theF = isset($vkode['gross']['F'])?$vkode['gross']['F']:0;
								$theG = isset($vkode['gross']['G'])?$vkode['gross']['G']:0;
								$theH = isset($vkode['gross']['H'])?$vkode['gross']['H']:0;
								$theI = $theF+$theG;
								$theJ = isset($vkode['ra_unit']['F'])?$vkode['ra_unit']['F']:0;
								$theK = 0;
								$theN = isset($vkode['gross']['N'])?$vkode['gross']['N']:0;

								$theRaL = isset($vkode['ra_lalu']['N'])?$vkode['ra_lalu']['N']:0;
								$theRaI = isset($vkode['ra_ini']['F'])?$vkode['ra_ini']['F']:0;
								$theRaD = isset($vkode['ra_depan']['F'])?$vkode['ra_depan']['F']:0;

								$sumF3 += $theF;
								$sumG3 += $theG;
								$sumH3 += $theH;
								$sumI3 += $theI;
								$sumJ3 += $theJ;
								$sumK3 += $theK;
								$sumN3 += $theN;

								$sumRaL3 += $theRaL;
								$sumRaI3 += $theRaI;
								$sumRaD3 += $theRaD;

								$theRaLWg = isset($vkode['ra_l_wg']['F'])?$vkode['ra_l_wg']['F']:0;
								$sumRaLWg3 += $theRaLWg;
								$theRaIWg = isset($vkode['ra_i_wg']['F'])?$vkode['ra_i_wg']['F']:0;
								$sumRaIWg3 += $theRaLWg;
						?>
							<tr>
								<td>&nbsp;</td>
								<td>- <?=$ktype==='Highrise'?'Luas Semi Gross':'Luas Tanah'?></td>
								<td class="text-right"><?=$theF?></td>
								<td class="text-right"><?=$theG?></td>
								<td class="text-right"><?=$theH?></td>
								<td class="text-right"><?=$theI?></td>
								<td class="text-right"><?=$theRaLWg?></td>
								<td class="text-right"><?=$theRaIWg?></td>
								<td class="text-right"></td>
								<td class="text-right"><?=$theK?></td>
								<td class="text-right"><?=$theN?></td>
							</tr>
						<?php 
								$theF = isset($vkode['rp']['F'])?($vkode['rp']['F']-$vkode['resvr_price']['N']):0;
								$theG = isset($vkode['rp']['G'])?$vkode['rp']['G']:0;
								$theH = isset($vkode['rp']['H'])?$vkode['rp']['H']:0;
								$theI = $theF+$theG;
								$theJ = isset($vkode['ra_unit']['J'])?$vkode['ra_unit']['J']:0;
								$theK = 0;
								$theN = isset($vkode['resvr_price']['N'])?$vkode['resvr_price']['N']:0;

								$sumF4 += $theF;
								$sumG4 += $theG;
								$sumH4 += $theH;
								$sumI4 += $theI;
								$sumJ4 += $theJ;
								$sumK4 += $theK;
								$sumN4 += $theN;

								$theRaL = isset($vkode['ra_lalu']['F'])?$vkode['ra_lalu']['F']:0;
								$theRaI = isset($vkode['ra_ini']['F'])?$vkode['ra_ini']['F']:0;
								$theRaD = isset($vkode['ra_depan']['F'])?$vkode['ra_depan']['F']:0;

								$sumRaL4 += $theRaL;
								$sumRaI4 += $theRaI;
								$sumRaD4 += $theRaD;

								$theRaLWn = isset($vkode['ra_l_wn']['F'])?$vkode['ra_l_wn']['F']:0;
								$sumRaLWn4 += $theRaLWn;
								$theRaLWg = isset($vkode['ra_i_wg']['F'])?$vkode['ra_i_wg']['F']:0;
								$sumRaLWg4 += $theRaLWg;
								
						?>
							<tr>
								<td>&nbsp;</td>
								<td>- Omzet Netto</td>
								<td class="text-right input-numeric"><?=$theF?></td>
								<td class="text-right input-numeric"><?=$theG?></td>
								<td class="text-right input-numeric"><?=$theH?></td>
								<td class="text-right input-numeric"><?=$theI?></td>
								<td class="text-right input-numeric"><?=$theRaL?></td>
								<td class="text-right input-numeric"><?=$theRaI?></td>
								<td class="text-right input-numeric"><?=$theRaD?></td>
								<td class="text-right input-numeric"><?=$theK?></td>
								<td class="text-right input-numeric"><?=$theN?></td>
							</tr>
						<?php
								$nourut++;
							}
						?>
							<tr>
								<td colspan="11">&nbsp;</td>
							</tr>
							<tr>
								<td colspan="11"><b>Total <?=$ktype?></b></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>- Unit</td>
								<td class="text-right"><?=$sumF1?></td>
								<td class="text-right"><?=$sumG1?></td>
								<td class="text-right"><?=$sumH1?></td>
								<td class="text-right"><?=$sumI1?></td>
								<td class="text-right"><?=$sumJ1?></td>
								<td class="text-right"><?=$sumRaLWn1?></td>
								<td class="text-right"><?=$sumRaLWg1?></td>
								<td class="text-right"><?=$sumK1?></td>
								<td class="text-right"><?=$sumN1?></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>- <?=$ktype==='Highrise'?'Luas Netto':'Luas Bang'?></td>
								<td class="text-right"><?=$sumF2?></td>
								<td class="text-right"><?=$sumG2?></td>
								<td class="text-right"><?=$sumH2?></td>
								<td class="text-right"><?=$sumI2?></td>
								<td class="text-right"><?=$sumRaLWn2?></td>
								<td class="text-right"><?=$sumRaLWg2?></td>
								<td class="text-right">12</td>
								<td class="text-right"><?=$sumK2?></td>
								<td class="text-right"><?=$sumN2?></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>- <?=$ktype==='Highrise'?'Luas Semi Gross':'Luas Tanah'?></td>
								<td class="text-right"><?=$sumF3?></td>
								<td class="text-right"><?=$sumG3?></td>
								<td class="text-right"><?=$sumH3?></td>
								<td class="text-right"><?=$sumI3?></td>
								<td class="text-right"><?=$sumRaLWg3?></td>
								<td class="text-right"></td>
								<td class="text-right"></td>
								<td class="text-right"><?=$sumK3?></td>
								<td class="text-right"><?=$sumN3?></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>- Omzet Netto</td>
								<td class="text-right input-numeric"><?=$sumF4?></td>
								<td class="text-right input-numeric"><?=$sumG4?></td>
								<td class="text-right input-numeric"><?=$sumH4?></td>
								<td class="text-right input-numeric"><?=$sumI4?></td>
								<td class="text-right input-numeric"><?=$sumRaL4?></td>
								<td class="text-right input-numeric"><?=$sumRaI4?></td>
								<td class="text-right input-numeric"><?=$sumRaD4?></td>
								<td class="text-right input-numeric"><?=$sumK4?></td>
								<td class="text-right input-numeric"><?=$sumN4?></td>
							</tr>
							<tr>
								<td colspan="11">&nbsp;</td>
							</tr>
						<?php
						} ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	
</section>
<!-- End: Content -->