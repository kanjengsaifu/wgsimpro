<style type="text/css">
.garbaw100 {
    border-bottom: 1px dashed #999;
    width: 100%;
}
</style>
<!-- Begin: Content -->
<div class="col-md-2 topbar-right">
	<a class="btn btn-sm btn-primary btn-gradient dark btn-block" href="<?=base_url() ?>index.php/payment-undefined/form">
		<span class="fa fa-plus"></span>&nbsp;Tambah Penerimaan
	</a>
</div>
<section id="content">
	<div class="row">
		<div class="col-md-12 pn">
            <div class="panel mbn">
                <div class="panel-body">
					<ul class="nav nav-pills mb20">
                        <li class="active">
                            <a href="#tabundefined" data-toggle="tab">Penerimaan Unidentified</a>
                        </li>
                        <li>
                            <a href="#tabdefined" data-toggle="tab">Penerimaan Identified</a>
                        </li>
                    </ul>
					<div class="tab-content br-n pn">
							<div id="tabundefined" class="tab-pane active">
								<table class="table table-striped table-bordered table-hover" id="datatable" cellspacing="0" width="100%">
									<thead>
										<tr class="bg-primary bg-gradient">
											<th>Bank Pengirim</th>
											<th>Nomor Rekening</th>
											<th>Rupiah diterima</th>
											<th>Tanggal</th>
											<th>&nbsp;</th>
										</tr>
									</thead>
									<tbody></tbody>
								</table>
							</div>
							<div id="tabdefined" class="tab-pane">
								<table class="table table-striped table-bordered table-hover" id="datatable2" cellspacing="0" width="100%">
									<thead>
										<tr class="bg-primary bg-gradient">
											<th>Bank Pengirim</th>
											<th>Nomor Rekening</th>
											<th>Kode Nasabah</th>
											<th>Nasabah</th>
											<th>Rupiah diterima</th>
											<th>Tanggal</th>
											<th>No. Reserve</th>
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
				<div class="panel-body" id="pnlbody" style="display: none;">
					<form class="form-horizontal" role="form" action="javascript:" id="form-payment">
						<input type="button" class="row-data hidden" id="xresno" data-resno=""/>
						
						<div class="form-group mbn">
							<div class="col-lg-6">
								<p class="form-control-static pbn"><b>1. Data Nasabah</b></p>
							</div>
						</div>
						<div class="form-group mbn pl15">
							<div class="col-lg-2">
								<p class="form-control-static pbn"><b>- Kode Nasabah [ No Unit ]</b></p>
							</div>
							<div class="col-lg-2">
								<select id="nounit" class="chosen-select">
									<option value=""></option>
                                <?php foreach ($data['unit'] as $k => $v) { ?>
                                    <option value="<?=$v['reserve_no']?>"><?=$v['kode_nasabah'] ?>&nbsp;[ <?=$v['no_unit']?> ]</option>
                                <?php } ?>
								</select>
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
						<input type="hidden" name="idundefined" id="idundefined"/>
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
								<input type="text" name="tgl_bayar" id="tgl_bayar" class="form-control input-sm">
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