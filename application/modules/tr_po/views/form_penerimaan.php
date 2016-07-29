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
							<h4 class="mbn">LAPORAN PENERIMAAN BARANG / PEMASOK </h4>
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
								<th rowspan="2" class="text-center" style="vertical-align:middle">No. Kontrak</th>
								<th colspan="3" class="text-center" style="vertical-align:middle">Sumberdaya</th>
								<th rowspan="2" class="text-center" style="vertical-align:middle">No. BAPB</th>
								<th rowspan="2" class="text-center" style="vertical-align:middle">Tanggal Diterima</th>
								<th rowspan="2" class="text-center" style="vertical-align:middle">Volume</th>
								<th rowspan="2" class="text-center" style="vertical-align:middle">Harga</th>
							</tr>
							<tr class="bg-primary light">
								<th class="text-center">Kode</th>
								<th class="text-center">Nama</th>
								<th class="text-center">Satuan</th>
							</tr>
						</thead>
						<tbody>
						<?php 
						$nokontrak=$kdnasabah="";
						   foreach($data['datatable'] as $k => $v) {
						   	$r = (object) $v;
							
						  	echo '<tr>
										<td>'.(($nokontrak!==$r->no_kontrak)?$r->no_kontrak:'&nbsp;').'</td>
										<td>'.(($kdnasabah!==$r->kdnasabah)?$r->kdnasabah:(($nokontrak!==$r->no_kontrak)?$r->kdnasabah:'&nbsp;')).'</td>
										<td>'.(($kdnasabah!==$r->kdnasabah)?$r->nama:(($nokontrak!==$r->no_kontrak)?$r->nama:'&nbsp;')).'</td>
										<td></td>
										<td>'.$r->no_bapb.'</td>
										<td>'.$r->tanggal.'</td>
										<td class="text-right">'.number_format($r->volume,0).'</td>
										<td class="text-right">'.number_format($r->harga_satuan,0).'</td>
								  </tr>';
							if($kdnasabah !== $r->kdnasabah)
								$kdnasabah = $r->kdnasabah;
							if($nokontrak !== $r->no_kontrak){
								$nokontrak = $r->no_kontrak;
								$kdnasabah = $r->kdnasabah;
							}
								
							
						   } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	
</section>
<!-- End: Content -->