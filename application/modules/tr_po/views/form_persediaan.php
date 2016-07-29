<!-- Begin: Content -->
<section id="content">

    <div class="row">
		<div class="col-md-12 pn">
			<div class="panel mbn">
				<div class="panel-body" style="overflow-x: scroll">
					<div class="row">
						<div class="col-md-12">
							<h4 class="mbn">PT WIKA GEDUNG</h4>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<h5 class="mbn">PROYEK <?=@$data['kawasan']?></h5>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 text-center">
							<h4 class="mbn">LAPORAN IKHTISAR PERSEDIAAN</h4>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 text-center">
							<h5 class="mbn">Periode <?=@$data['periode']?></h5>
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
								<th rowspan="2" class="text-center" style="vertical-align:middle">Kode</th>
								<th rowspan="2" class="text-center" style="vertical-align:middle">Sumberdaya</th>
								<th colspan="2" class="text-center" style="vertical-align:middle">Masuk</th>
								<th colspan="2" class="text-center" style="vertical-align:middle">Keluar</th>
								<th colspan="2" class="text-center" style="vertical-align:middle">Sisa</th> 	
								<th rowspan="2" class="text-center" style="vertical-align:middle">Harga Satuan Rata2</th>
							</tr>
							<tr class="bg-primary light">
								<th class="text-center">Volume</th>
								<th class="text-center">Harga</th>
								<th class="text-center">Volume</th>
								<th class="text-center">Harga</th>
								<th class="text-center">Volume</th>
								<th class="text-center">Harga</th>
							</tr>
						</thead>
						<tbody>
						<?php 
						$vi=$hi=$vo=$ho=$vs=$hs=0;
						   foreach($data['datatable'] as $k => $v) {
						   	$r = (object) $v;
							$hi += $r->harga_in; 
							$ho += $r->harga_out;
							$hs += $r->harga_sisa;
						  	echo '<tr>
										<td>'.$r->kode.'</td>
										<td>'.$r->nama.'</td>
										<td class="text-right">'.number_format($r->volume_in,0).'</td>
										<td class="text-right">'.number_format($r->harga_in,0).'</td>
										<td class="text-right">'.number_format($r->volume_out,0).'</td>
										<td class="text-right">'.number_format($r->harga_out,0).'</td>
										<td class="text-right">'.number_format($r->volume_sisa,0).'</td>
										<td class="text-right">'.number_format($r->harga_sisa,0).'</td>
										<td class="text-right">'.number_format($r->harga_rata,0).'</td>
								  </tr>';
								
							
						   } 
						   echo '<tr>
										<td>&nbsp</td>
										<td class="text-right">Jumlah</td>
										<td class="text-right"></td>
										<td class="text-right">'.number_format($hi,0).'</td>
										<td class="text-right"></td>
										<td class="text-right">'.number_format($ho,0).'</td>
										<td class="text-right"></td>
										<td class="text-right">'.number_format($hs,0).'</td>
										<td class="text-right"></td>
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