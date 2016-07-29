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
							<h4 class="mbn">LAPORAN IKHTISAR PERSEDIAAN GEDUNG (APG)</h4>
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
								<th class="text-center" style="vertical-align:middle">Kode</th>
								<th class="text-center" style="vertical-align:middle">Sumberdaya</th>
								<th class="text-center" style="vertical-align:middle">Satuan</th>
								<th class="text-center" style="vertical-align:middle">Vol. Masuk</th>
								<th class="text-center" style="vertical-align:middle">Vol. Keluar</th>
								<th class="text-center" style="vertical-align:middle">Vol. Sisa</th> 	
								<!--<th class="text-center" style="vertical-align:middle">Rencana s/d Selesai</th>-->
							</tr>
						</thead>
						<tbody>
						<?php 
						   foreach($data['datatable'] as $k => $v) {
						   	$r = (object) $v;
						  	echo '<tr>
										<td>'.$r->kode.'</td>
										<td>'.$r->nama.'</td>
										<td>'.$r->satuan.'</td>
										<td class="text-right">'.number_format($r->volume_in,0).'</td>
										<td class="text-right">'.number_format($r->volume_out,0).'</td>
										<td class="text-right">'.number_format($r->volume_sisa,0).'</td>
										<!--<td class="text-right">'.number_format($r->volume_sisa,0).'</td>-->
								  </tr>';
								
							
						   } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	
</section>
<!-- End: Content -->