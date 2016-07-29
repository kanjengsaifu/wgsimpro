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
										<th>Umur Reserve</th>
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
						<input type="hidden" name="reserve_no" id="reserve_no"/>
						<input type="hidden" name="idpay" id="idpay"/>
						<input type="hidden" name="kode_pay" id="kode_pay"/>
						<input type="hidden" name="nama" id="nama"/>
						<input type="hidden" name="no_urut" id="no_urut"/>
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
								<p class="form-control-static"><b>- Tanggal Bayar</b></p>
							</div>
							<div class="col-lg-2">
								<input type="text" name="tgl_bayar" id="tgl_bayar" class="form-control input-sm" value="<?=date('d/m/Y')?>">
							</div>
						</div>
						<div class="form-group mbn pl15">
							<div class="col-lg-2">
								<p class="form-control-static"><b>- Bank Penerima</b></p>
							</div>
							<div class="col-lg-4">
								<select id="kode" name="kode" class="chosen-select">
									<option value=""></option>
                                <?php foreach ($data['bank'] as $k => $v) { ?>
                                    <option value="<?=$v['kode']?>"><?=$v['nama']?> [ <?=$v['no_rekening'] ?> ]</option>
                                <?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group mbn pl15">
							<div class="col-lg-2">
								<p class="form-control-static"><b>&nbsp;</b></p>
							</div>
							<div class="col-lg-4">
								<input type="radio" name="rkbank">BANK&nbsp;
								<input type="radio" name="rkbank">RK
							</div>
						</div>
						<div class="form-group mbn pl15">
							<div class="col-lg-2">
								<p class="form-control-static"><b>- Jenis</b></p>
							</div>
							<div class="col-lg-4">
								<select id="skode_pay" class="chosen-select"></select>
							</div>
						</div>
						<div class="form-group pl15">
							<div class="col-lg-2">
								<p class="form-control-static"><b>- Nominal Bayar</b></p>
							</div>
							<div class="col-lg-2">
								<input type="text" name="rp" id="rp" class="form-control input-sm input-numeric text-right" value="0.00">
							</div>
							<div class="col-lg-2">
								<button id="btn-submit-pay" class="btn btn-primary btn-gradient dark btn-block btn-sm"><span class="glyphicons glyphicons-check"></span>  Submit Payment</button>
							</div>
						</div>
					</form>
					<table class="table table-bordered mbn" id="table-paydet">
						<thead>
							<tr class="bg-primary light">
								<th rowspan="2" style="vertical-align: middle">No.</th>
								<th colspan="3" class="text-center">Piutang</th>
								<th colspan="3" class="text-center">Pembayaran</th>
								<th colspan="2" class="text-center">Denda</th>
							</tr>
							<tr class="bg-primary light">
								<th class="text-center">Keterangan</th>
								<th class="text-center">Jth Tempo</th>
								<th class="text-center">Nilai Tagihan (a)</th>
								<th class="text-center">Tgl Bayar</th>
								<th class="text-center">Nilai Bayar (b)</th>
								<th class="text-center">No. Kwitansi</th>
								<th class="text-center">Hari</th>
								<th class="text-center">Nilai</th>
							</tr>
						</thead>
						<tbody></tbody>
						<tfoot></tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
	
</section>
<!-- End: Content -->