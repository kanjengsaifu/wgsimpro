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
					<table id="example" class="table table-bordered mbn" style="font-size: 10px!important">
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
						$chkdir = ['DIR1'=>'Direktorat I','DIR2'=>'Direktorat II'];
						$chk = $chk1 = $ttl = $dr = $type = $ent = $val = array(); 
						$dir = $ent = "";
						foreach($data['datatable'] as $k => $v) {
							$r = (object) $v;
							$ttl['rithlalu'][]=$chk1['rithlalu'][$r->direktorat][$r->nama_entity]=$chk['rithlalu'][$r->direktorat][$r->nama_entity][$r->nama]=$r->rithlalu;
							$ttl['rimglalu'][]=$chk1['rimglalu'][$r->direktorat][$r->nama_entity]=$chk['rimglalu'][$r->direktorat][$r->nama_entity][$r->nama]=$r->rimglalu;
							$ttl['rimgini'][]=$chk1['rimgini'][$r->direktorat][$r->nama_entity]=$chk['rimgini'][$r->direktorat][$r->nama_entity][$r->nama]=$r->rimgini;
							$ttl['risdmgini'][]=$chk1['risdmgini'][$r->direktorat][$r->nama_entity]=$chk['risdmgini'][$r->direktorat][$r->nama_entity][$r->nama]=$r->risdmgini;
							$ttl['reserveini'][]=$chk1['reserveini'][$r->direktorat][$r->nama_entity]=$chk['reserveini'][$r->direktorat][$r->nama_entity][$r->nama]=$r->reserveini;
							$ttl['rinettothlalu'][]=$chk1['rinettothlalu'][$r->direktorat][$r->nama_entity]=$chk['rinettothlalu'][$r->direktorat][$r->nama_entity][$r->nama]=$r->rinettothlalu;
							$ttl['rinettolalu'][]=$chk1['rinettolalu'][$r->direktorat][$r->nama_entity]=$chk['rinettolalu'][$r->direktorat][$r->nama_entity][$r->nama]=$r->rinettolalu;
							$ttl['rinettoini'][]=$chk1['rinettoini'][$r->direktorat][$r->nama_entity]=$chk['rinettoini'][$r->direktorat][$r->nama_entity][$r->nama]=$r->rinettoini;
							$ttl['rinettosdini'][]=$chk1['rinettosdini'][$r->direktorat][$r->nama_entity]=$chk['rinettosdini'][$r->direktorat][$r->nama_entity][$r->nama]=$r->rinettosdini;
							$ttl['reservenetto'][]=$chk1['reservenetto'][$r->direktorat][$r->nama_entity]=$chk['reservenetto'][$r->direktorat][$r->nama_entity][$r->nama]=$r->reservenetto;
							$ttl['rigrossthlalu'][]=$chk1['rigrossthlalu'][$r->direktorat][$r->nama_entity]=$chk['rigrossthlalu'][$r->direktorat][$r->nama_entity][$r->nama]=$r->rigrossthlalu;
							$ttl['rigrosslalu'][]=$chk1['rigrosslalu'][$r->direktorat][$r->nama_entity]=$chk['rigrosslalu'][$r->direktorat][$r->nama_entity][$r->nama]=$r->rigrosslalu;
							$ttl['rigrossini'][]=$chk1['rigrossini'][$r->direktorat][$r->nama_entity]=$chk['rigrossini'][$r->direktorat][$r->nama_entity][$r->nama]=$r->rigrossini;
							$ttl['rigrosssdini'][]=$chk1['rigrosssdini'][$r->direktorat][$r->nama_entity]=$chk['rigrosssdini'][$r->direktorat][$r->nama_entity][$r->nama]=$r->rigrosssdini;
							$ttl['reservegross'][]=$chk1['reservegross'][$r->direktorat][$r->nama_entity]=$chk['reservegross'][$r->direktorat][$r->nama_entity][$r->nama]=$r->reservegross;
							$ttl['ribayarthlalu'][]=$chk1['ribayarthlalu'][$r->direktorat][$r->nama_entity]=$chk['ribayarthlalu'][$r->direktorat][$r->nama_entity][$r->nama]=$r->ribayarthlalu;
							$ttl['ribayarlalu'][]=$chk1['ribayarlalu'][$r->direktorat][$r->nama_entity]=$chk['ribayarlalu'][$r->direktorat][$r->nama_entity][$r->nama]=$r->ribayarlalu;
							$ttl['ribayarini'][]=$chk1['ribayarini'][$r->direktorat][$r->nama_entity]=$chk['ribayarini'][$r->direktorat][$r->nama_entity][$r->nama]=$r->ribayarini;
							$ttl['ribayarsdini'][]=$chk1['ribayarsdini'][$r->direktorat][$r->nama_entity]=$chk['ribayarsdini'][$r->direktorat][$r->nama_entity][$r->nama]=$r->ribayarsdini;
							$ttl['reservejmlh'][]=$chk1['reservejmlh'][$r->direktorat][$r->nama_entity]=$chk['reservejmlh'][$r->direktorat][$r->nama_entity][$r->nama]=$r->reservejmlh;
							//$chk[$r->direktorat][$r->nama_entity][$r->nama]['nama_entity']=$r->nama_entity;
							//$chk[$r->direktorat][$r->nama_entity][$r->nama]['type_entity']=$r->type_entity;
							$ent[$r->direktorat][$r->nama_entity][]=$r->nama;
							$dr['direktorat'][]=$r->direktorat;
							$type['jenis'][$r->direktorat][] = $r->nama_entity;
						}
							foreach(array_unique($dr['direktorat']) as $rp){
								echo '<tr>
											<td colspan="7"><b>'.$chkdir[$rp].'</b></td>
									  </tr>';
								$nourut = 1;
								foreach(array_unique($type['jenis'][$rp]) as $tp){
									echo '<tr>
											<td colspan="7">&nbsp;&nbsp;&nbsp;&nbsp;<b>'.$tp.'</b></td>
									  </tr>';
									  foreach(array_unique($ent[$rp][$tp]) as $et){
									  		echo '<tr>
													<td class="text-center"><b>'.$nourut.'</b></td>
													<td colspan="6"><b>'.$et.'</b></td>
											      </tr>';
											echo '<tr>
														<td>&nbsp;</td>
														<td>- Unit</td>
														<td class="text-right">'.number_format($chk['rithlalu'][$rp][$tp][$et],0).'</td>
														<td class="text-right">'.number_format($chk['rimglalu'][$rp][$tp][$et],0).'</td>
														<td class="text-right">'.number_format($chk['rimgini'][$rp][$tp][$et],0).'</td>
														<td class="text-right">'.number_format($chk['risdmgini'][$rp][$tp][$et],0).'</td>
														<td class="text-right">'.number_format($chk['reserveini'][$rp][$tp][$et],0).'</td>
												  </tr>';
											echo '<tr>
														<td>&nbsp;</td>
														<td>- Luas '.($tp==='High Rise'?'Netto':'Bang.').'</td>
														<td class="text-right">'.number_format($chk['rinettothlalu'][$rp][$tp][$et],0).'</td>
														<td class="text-right">'.number_format($chk['rinettolalu'][$rp][$tp][$et],0).'</td>
														<td class="text-right">'.number_format($chk['rinettoini'][$rp][$tp][$et],0).'</td>
														<td class="text-right">'.number_format($chk['rinettosdini'][$rp][$tp][$et],0).'</td>
														<td class="text-right">'.number_format($chk['reservenetto'][$rp][$tp][$et],0).'</td>
												  </tr>';
											/*if($tp !== 'High Rise'){*/
											echo '<tr>
														<td>&nbsp;</td>
														<td>- Luas '.($tp==='High Rise'?'Gross':'Tanah').'</td>
														<td class="text-right">'.number_format($chk['rigrossthlalu'][$rp][$tp][$et],0).'</td>
														<td class="text-right">'.number_format($chk['rigrosslalu'][$rp][$tp][$et],0).'</td>
														<td class="text-right">'.number_format($chk['rigrossini'][$rp][$tp][$et],0).'</td>
														<td class="text-right">'.number_format($chk['rigrosssdini'][$rp][$tp][$et],0).'</td>
														<td class="text-right">'.number_format($chk['reservegross'][$rp][$tp][$et],0).'</td>
												  </tr>';
											/*}*/
											echo '<tr>
														<td>&nbsp;</td>
														<td>- Omzet</td>
														<td class="text-right">'.number_format($chk['ribayarthlalu'][$rp][$tp][$et],0).'</td>
														<td class="text-right">'.number_format($chk['ribayarlalu'][$rp][$tp][$et],0).'</td>
														<td class="text-right">'.number_format($chk['ribayarini'][$rp][$tp][$et],0).'</td>
														<td class="text-right">'.number_format($chk['ribayarsdini'][$rp][$tp][$et],0).'</td>
														<td class="text-right">'.number_format($chk['reservejmlh'][$rp][$tp][$et],0).'</td>
												  </tr>';
											$nourut++;
									  }
									  // Sub Total per Type
									  echo '<tr>
													<td  colspan="7"><b>&nbsp;&nbsp;&nbsp;&nbsp;Sub Total '.$tp.'</b></td>
											      </tr>';
											echo '<tr>
														<td>&nbsp;</td>
														<td>- Unit</td>
														<td class="text-right">'.number_format(array_sum($chk['rithlalu'][$rp][$tp]),0).'</td>
														<td class="text-right">'.number_format(array_sum($chk['rimglalu'][$rp][$tp]),0).'</td>
														<td class="text-right">'.number_format(array_sum($chk['rimgini'][$rp][$tp]),0).'</td>
														<td class="text-right">'.number_format(array_sum($chk['risdmgini'][$rp][$tp]),0).'</td>
														<td class="text-right">'.number_format(array_sum($chk['reserveini'][$rp][$tp]),0).'</td>
												  </tr>';
											echo '<tr>
														<td>&nbsp;</td>
														<td>- Luas '.($tp==='High Rise'?'Netto':'Bang.').'</td>
														<td class="text-right">'.number_format(array_sum($chk['rinettothlalu'][$rp][$tp]),0).'</td>
														<td class="text-right">'.number_format(array_sum($chk['rinettolalu'][$rp][$tp]),0).'</td>
														<td class="text-right">'.number_format(array_sum($chk['rinettoini'][$rp][$tp]),0).'</td>
														<td class="text-right">'.number_format(array_sum($chk['rinettosdini'][$rp][$tp]),0).'</td>
														<td class="text-right">'.number_format(array_sum($chk['reservenetto'][$rp][$tp]),0).'</td>
												  </tr>';
											echo '<tr>
														<td>&nbsp;</td>
														<td>- Luas '.($tp==='High Rise'?'Gross':'Tanah').'</td>
														<td class="text-right">'.number_format(array_sum($chk['rigrossthlalu'][$rp][$tp]),0).'</td>
														<td class="text-right">'.number_format(array_sum($chk['rigrosslalu'][$rp][$tp]),0).'</td>
														<td class="text-right">'.number_format(array_sum($chk['rigrossini'][$rp][$tp]),0).'</td>
														<td class="text-right">'.number_format(array_sum($chk['rigrosssdini'][$rp][$tp]),0).'</td>
														<td class="text-right">'.number_format(array_sum($chk['reservegross'][$rp][$tp]),0).'</td>
												  </tr>';
											echo '<tr>
														<td>&nbsp;</td>
														<td>- Omzet</td>
														<td class="text-right">'.number_format(array_sum($chk['ribayarthlalu'][$rp][$tp]),0).'</td>
														<td class="text-right">'.number_format(array_sum($chk['ribayarlalu'][$rp][$tp]),0).'</td>
														<td class="text-right">'.number_format(array_sum($chk['ribayarini'][$rp][$tp]),0).'</td>
														<td class="text-right">'.number_format(array_sum($chk['ribayarsdini'][$rp][$tp]),0).'</td>
														<td class="text-right">'.number_format(array_sum($chk['reservejmlh'][$rp][$tp]),0).'</td>
												  </tr>';
									
								}
								// Sub Total per Direktorat
									  echo '<tr>
													<td  colspan="7"><b>Sub Total '.$chkdir[$rp].'</b></td>
											      </tr>';
											echo '<tr>
														<td>&nbsp;</td>
														<td>- Unit</td>
														<td class="text-right">'.number_format(array_sum($chk1['rithlalu'][$rp]),0).'</td>
														<td class="text-right">'.number_format(array_sum($chk1['rimglalu'][$rp]),0).'</td>
														<td class="text-right">'.number_format(array_sum($chk1['rimgini'][$rp]),0).'</td>
														<td class="text-right">'.number_format(array_sum($chk1['risdmgini'][$rp]),0).'</td>
														<td class="text-right">'.number_format(array_sum($chk1['reserveini'][$rp]),0).'</td>
												  </tr>';
											echo '<tr>
														<td>&nbsp;</td>
														<td>- Luas Bang</td>
														<td class="text-right">'.number_format(array_sum($chk1['rinettothlalu'][$rp]),0).'</td>
														<td class="text-right">'.number_format(array_sum($chk1['rinettolalu'][$rp]),0).'</td>
														<td class="text-right">'.number_format(array_sum($chk1['rinettoini'][$rp]),0).'</td>
														<td class="text-right">'.number_format(array_sum($chk1['rinettosdini'][$rp]),0).'</td>
														<td class="text-right">'.number_format(array_sum($chk1['reservenetto'][$rp]),0).'</td>
												  </tr>';
											echo '<tr>
														<td>&nbsp;</td>
														<td>- Luas Tanah</td>
														<td class="text-right">'.number_format(array_sum($chk1['rigrossthlalu'][$rp]),0).'</td>
														<td class="text-right">'.number_format(array_sum($chk1['rigrosslalu'][$rp]),0).'</td>
														<td class="text-right">'.number_format(array_sum($chk1['rigrossini'][$rp]),0).'</td>
														<td class="text-right">'.number_format(array_sum($chk1['rigrosssdini'][$rp]),0).'</td>
														<td class="text-right">'.number_format(array_sum($chk1['reservegross'][$rp]),0).'</td>
												  </tr>';
											echo '<tr>
														<td>&nbsp;</td>
														<td>- Omzet</td>
														<td class="text-right">'.number_format(array_sum($chk1['ribayarthlalu'][$rp]),0).'</td>
														<td class="text-right">'.number_format(array_sum($chk1['ribayarlalu'][$rp]),0).'</td>
														<td class="text-right">'.number_format(array_sum($chk1['ribayarini'][$rp]),0).'</td>
														<td class="text-right">'.number_format(array_sum($chk1['ribayarsdini'][$rp]),0).'</td>
														<td class="text-right">'.number_format(array_sum($chk1['reservejmlh'][$rp]),0).'</td>
												  </tr>';
								
									  
							}
									// Sub Total per Direktorat
									  echo '<tr>
													<td  colspan="7"><b>TOTAL Direkotrat I & II</b></td>
											      </tr>';
											echo '<tr>
														<td>&nbsp;</td>
														<td>- Unit</td>
														<td class="text-right">'.number_format(array_sum($ttl['rithlalu']),0).'</td>
														<td class="text-right">'.number_format(array_sum($ttl['rimglalu']),0).'</td>
														<td class="text-right">'.number_format(array_sum($ttl['rimgini']),0).'</td>
														<td class="text-right">'.number_format(array_sum($ttl['risdmgini']),0).'</td>
														<td class="text-right">'.number_format(array_sum($ttl['reserveini']),0).'</td>
												  </tr>';
											echo '<tr>
														<td>&nbsp;</td>
														<td>- Luas Bang</td>
														<td class="text-right">'.number_format(array_sum($ttl['rinettothlalu']),0).'</td>
														<td class="text-right">'.number_format(array_sum($ttl['rinettolalu']),0).'</td>
														<td class="text-right">'.number_format(array_sum($ttl['rinettoini']),0).'</td>
														<td class="text-right">'.number_format(array_sum($ttl['rinettosdini']),0).'</td>
														<td class="text-right">'.number_format(array_sum($ttl['reservenetto']),0).'</td>
												  </tr>';
											echo '<tr>
														<td>&nbsp;</td>
														<td>- Luas Tanah</td>
														<td class="text-right">'.number_format(array_sum($ttl['rigrossthlalu']),0).'</td>
														<td class="text-right">'.number_format(array_sum($ttl['rigrosslalu']),0).'</td>
														<td class="text-right">'.number_format(array_sum($ttl['rigrossini']),0).'</td>
														<td class="text-right">'.number_format(array_sum($ttl['rigrosssdini']),0).'</td>
														<td class="text-right">'.number_format(array_sum($ttl['reservegross']),0).'</td>
												  </tr>';
											echo '<tr>
														<td>&nbsp;</td>
														<td>- Omzet</td>
														<td class="text-right">'.number_format(array_sum($ttl['ribayarthlalu']),0).'</td>
														<td class="text-right">'.number_format(array_sum($ttl['ribayarlalu']),0).'</td>
														<td class="text-right">'.number_format(array_sum($ttl['ribayarini']),0).'</td>
														<td class="text-right">'.number_format(array_sum($ttl['ribayarsdini']),0).'</td>
														<td class="text-right">'.number_format(array_sum($ttl['reservejmlh']),0).'</td>
												  </tr>';
						?>
							
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	
</section>
<!-- End: Content -->