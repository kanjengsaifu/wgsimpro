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
                                    <?php
                                    if($this->session->userdata('type_entity')) {
                                        if($this->session->userdata('type_entity')==='HR') {
                                    ?>
										<th>Lantai</th>
										<th>Luas Netto</th>
										<th>Luas Semi Gross</th>
                                    <?php
                                        } elseif($this->session->userdata('type_entity')==='LD') {
                                    ?>
                                        <th>Blok</th>
										<th>Luas Bangunan</th>
										<th>Luas Tanah</th>
                                    <?php
                                        }
                                    }
                                    ?>
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
                        <?php
                        if($this->session->userdata('type_entity')) {
                            if($this->session->userdata('type_entity')==='HR') {
                        ?>
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
                        <?php
                            } elseif($this->session->userdata('type_entity')==='LD') {
                        ?>
                        <div class="form-group mbn pl15 hidden">
							<div class="col-lg-2">
								<p class="form-control-static pbn"><b>- Luas Bangunan</b></p>
							</div>
							<div class="col-lg-10">
								<p class="form-control-static pbn garbaw100" id="pluas_bangunan">:</p>
							</div>
						</div>
						<div class="form-group mbn pl15 hidden">
							<div class="col-lg-2">
								<p class="form-control-static pbn"><b>- Luas Tanah</b></p>
							</div>
							<div class="col-lg-10">
								<p class="form-control-static pbn garbaw100" id="pluas_tanah">:</p>
							</div>
						</div>
                        <?php
                            }
                        }
                        ?>
						<div class="form-group mbn pl15">
							<div class="col-lg-2">
								<p class="form-control-static pbn"><b>- Harga Jual</b></p>
							</div>
							<div class="col-lg-10">
								<p class="form-control-static pbn garbaw100" id="pharga_unit">:</p>
                                <input type="hidden" id="vHargaUnit" name="vHargaUnit">
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
								<th rowspan="2" style="vertical-align: middle">No.</th>
								<th colspan="3" class="text-center">Rencana</th>
								<th colspan="3" class="text-center">Realisasi</th>
							</tr>
							<tr class="bg-primary light">
								<th class="text-center">Keterangan</th>
								<th class="text-center">Jth Tempo</th>
								<th class="text-center">Nilai Tagihan (a)</th>
								<th class="text-center">Tgl Bayar</th>
								<th class="text-center">Nilai Bayar (b)</th>
								<th class="text-center">No. Kwitansi</th>
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
					

				    <div class="row">
						<div class="col-md-6 pn">
							<div class="panel mbn">
								<div class="panel-body">
									<form class="form-horizontal" role="form" action="javascript:" id="form-change-owner-1">
										<input type="hidden" id="status_tr" name="status_tr" value="RESERVE"/>
                                		<input type="hidden" id="hold_date" name="hold_date"/> 
		                                <input type="hidden" id="no_unit" name="no_unit"/>
		                                <input type="hidden" id="harga" name="harga"/>
										<input type="hidden" id="kode_pay" name="kode_pay"/>
										<input type="hidden" id="cara_bayar" name="cara_bayar"/>
		                                <div id="pay-container"></div>
									</form>
								</div>
							</div>
						</div>

						<div class="col-md-6 pn">
							<div class="panel mbn">
								<div class="panel-body">
									<form class="form-horizontal" role="form" action="javascript:" id="form-change-owner-2">
										<input type="hidden" name="reserve_no" id="reserve_no"/>
										<div class="form-group">
											<label class="col-lg-2 control-label">Biaya Administrasi</label>
											<div class="col-lg-4">
												<input type="text" name="adm_rp" class="form-control input-sm input-numeric text-right" value="0">
											</div>
											<div class="col-lg-2">&nbsp;</div>
											<div class="col-lg-4">
												<button id="btn-submit-change" class="btn btn-primary btn-gradient dark btn-block">Submit Change</button>
											</div>
										</div>
										<!--div id="pay-ri-container"></div-->
									</form>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
	
</section>
<!-- End: Content -->