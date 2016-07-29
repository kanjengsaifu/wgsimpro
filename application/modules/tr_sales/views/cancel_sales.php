<style type="text/css">
.garbaw100 {
    border-bottom: 1px dashed #999;
    width: 100%;
}
</style>
<!-- Begin: Content -->
<section id="content">
	<div class="row">
		<div class="col-md-12 pn">
			
			<div class="panel-group accordion mbn" id="panel-payment-plan">
				<div class="panel">
					<div class="panel-heading bg-success2">
						<a class="accordion-toggle accordion-icon" data-toggle="collapse" data-parent="#panel-payment-plan" href="#panel-payment-plan-item1" style="color:#fff">Payment Plan</a>
					</div>
					<div id="panel-payment-plan-item1" class="panel-collapse collapse in">
						<div class="panel-body">
							<table class="table table-striped table-bordered table-hover" id="datatable" cellspacing="0" width="100%">
								<thead>
									<tr class="bg-primary bg-gradient">
										<th>No. Unit</th>
										<th>Nasabah</th>
										<th>Lantai</th>
										<th>Luas Netto</th>
										<th>Luas Semi Gross</th>
										<th>Harga</th>
										<th>No. Reserve</th>
										<th>Tgl. Reserve</th>
										<th>Status</th>
										<th>&nbsp;</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-12 pn">
			<div class="panel mbn">
				<div class="panel-body">
					<form class="form-horizontal" role="form" action="javascript:" id="form-payment">
						<input type="button" class="row-data hidden" id="xresno" data-resno=""/>
						<div class="form-group mbn">
							<div class="col-lg-6">
								<p class="form-control-static pbn"><b>1. Data Nasabah</b></p>
							</div>
						</div>
						<div class="form-group mbn pl15">
							<div class="col-lg-2">
								<p class="form-control-static pbn"><b>- Nama</b></p>
							</div>
							<div class="col-lg-10">
								<p class="form-control-static pbn garbaw100" id="pnama">:</p>
							</div>
						</div>
						<div class="form-group mbn pl15 hidden">
							<div class="col-lg-2">
								<p class="form-control-static pbn"><b>- Alamat</b></p>
							</div>
							<div class="col-lg-10">
								<p class="form-control-static pbn garbaw100" id="palamat">:</p>
							</div>
						</div>
						<div class="form-group mbn pl15 hidden">
							<div class="col-lg-2">
								<p class="form-control-static pbn"><b>- No. Telp</b></p>
							</div>
							<div class="col-lg-10">
								<p class="form-control-static pbn garbaw100" id="ptelp">:</p>
							</div>
						</div>
						<div class="form-group mbn">
							<div class="col-lg-6">
								<p class="form-control-static pbn"><b>2. Data Produk</b></p>
							</div>
						</div>
						<div class="form-group mbn pl15">
							<div class="col-lg-2">
								<p class="form-control-static pbn"><b>- No. Unit</b></p>
							</div>
							<div class="col-lg-10">
								<p class="form-control-static pbn garbaw100" id="pno_unit">:</p>
							</div>
						</div>
						<div class="form-group mbn pl15 hidden">
							<div class="col-lg-2">
								<p class="form-control-static pbn"><b>- Luas Netto</b></p>
							</div>
							<div class="col-lg-10">
								<p class="form-control-static pbn garbaw100" id="pluas_bangunan">:</p>
							</div>
						</div>
						<div class="form-group mbn pl15 hidden">
							<div class="col-lg-2">
								<p class="form-control-static pbn"><b>- Luas Semi Gross</b></p>
							</div>
							<div class="col-lg-10">
								<p class="form-control-static pbn garbaw100" id="pluas_tanah">:</p>
							</div>
						</div>
						<div class="form-group mbn pl15">
							<div class="col-lg-2">
								<p class="form-control-static pbn"><b>- Harga Jual</b></p>
							</div>
							<div class="col-lg-10">
								<p class="form-control-static pbn garbaw100" id="pharga_unit">:</p>
							</div>
						</div>
						<div class="form-group mbn pl15">
							<div class="col-lg-2">
								<p class="form-control-static pbn"><b>&nbsp;</b></p>
							</div>
							<div class="col-lg-10">
								<p class="form-control-static pbn garbaw100" id="pterbilang">##</p>
							</div>
						</div>
						<div class="form-group mbn">
							<div class="col-lg-6">
								<p class="form-control-static pbn"><b>3. Data Pembayaran</b></p>
							</div>
						</div>
						<div class="form-group mbn pl15">
							<div class="col-lg-2">
								<p class="form-control-static pbn"><b>- Cara Bayar</b></p>
							</div>
							<div class="col-lg-10">
								<p class="form-control-static pbn garbaw100" id="pcara_bayar">:</p>
							</div>
						</div>
						<div class="form-group mbn pl15">
							<div class="col-lg-2">
								<p class="form-control-static pbn"><b>- Pola Bayar</b></p>
							</div>
							<div class="col-lg-10">
								<p class="form-control-static pbn garbaw100" id="ppola_bayar">:</p>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12 pn">
			<div class="panel mbn">
				<div class="panel-body">
					<table class="table table-bordered mbn" id="table-paydet">
						<thead>
							<tr class="bg-primary light">
								<th rowspan="2" style="vertical-align: middle" class="text-center">No.</th>
								<th colspan="3" class="text-center">Pembayaran</th>
							</tr>
							<tr class="bg-primary light">
								<th class="text-center">Keterangan</th>
								<th class="text-center">Tgl Bayar</th>
								<th class="text-center">Nilai Bayar (b)</th>
							</tr>
						</thead>
						<tbody></tbody>
						<tfoot></tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12 pn">
			<div class="panel mbn">
				<div class="panel-body">
					<form class="form-horizontal" role="form" action="javascript:" id="form-cancel">
						<input type="hidden" name="reserve_no" id="reserve_no"/>
						<div class="form-group">
							<div class="col-lg-2">
								<p class="form-control-static">Alasan Pembatalan</p>
							</div>
							<div class="col-lg-4">
								<textarea name="remarks" class="form-control input-sm" row="3"></textarea>
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-2">
								<p class="form-control-static">Biaya</p>
							</div>
							<div class="col-lg-4">
								<table class="table table-bordered mbn" id="table-cancel" class="width:50%">
									<thead>
										<tr class="bg-primary light">
											<th>Keterangan</th>
											<th>Nominal</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Pembayaran Diterima</td>
											<td id="td_ri_bayar" class="input-numeric text-right">0</td>
										</tr>
										<tr>
											<td>Tanda Jadi (5%)</td>
											<td id="td_tj" class="input-numeric text-right">0</td>
										</tr>
										<tr>
											<td>Pajak</td>
											<td><input type="text" id="td_tax" name="tax_rp" class="form-control input-sm input-numeric text-right" value="0" /></td>
										</tr>
										<tr>
											<td>Biaya Administrasi</td>
											<td><input type="text" id="td_adm" name="adm_rp" class="form-control input-sm input-numeric text-right" value="0" /></td>
										</tr>
										<tr>
											<td>Nominal Refund</td>
											<td><input type="text" id="td_refund" name="refund_rp" class="form-control input-sm input-numeric text-right" value="0" /></td>
										</tr>
									</tbody>
									<tfoot></tfoot>
								</table>
							</div>
						</div>
						<div class="form-group mbn">
							<div class="col-lg-4">&nbsp;</div>
							<div class="col-lg-2">
								<button id="btn-submit-cancel" class="btn btn-primary btn-gradient dark btn-block">Submit Cancellation</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	
</section>
<!-- End: Content -->