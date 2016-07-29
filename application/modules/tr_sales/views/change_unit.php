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
				<div class="panel-body pn">

					<div class="row">
						<div class="col-md-12 pn">
							<div class="panel mbn">
								<div class="panel-body">
									<table class="table table-striped table-bordered table-hover" id="datatable-unit" cellspacing="0" width="100%">
		                                <thead>
		                                    <tr class="bg-primary light bg-gradient">
		                                        <th>No. Unit</th>
		                                        <th>Property Type</th>
		                                        <th>Unit Type</th>
		                                    <?php
		                                    if($this->session->userdata('type_entity')) {
		                                        if($this->session->userdata('type_entity')==='HR') {
		                                    ?>
		                                        <th>Tower</th>
		                                        <th>Luas Netto</th>
		                                        <th>Luas Semi Gross</th>
		                                        <th>Lantai</th>
		                                        <th>View</th>
		                                    </div>
		                                    <?php
		                                        } elseif($this->session->userdata('type_entity')==='LD') {
		                                    ?>
		                                        <th>Cluster</th>
		                                        <th>Luas Bangunan</th>
		                                        <th>Luas Tanah</th>
		                                        <th>Blok</th>
		                                        <th>Arah Mata Angin</th>
		                                    <?php
		                                        }
		                                    }
		                                    ?>
		                                        <th>&nbsp;</th>
		                                    </tr>
		                                </thead>
		                                <tbody></tbody>
		                            </table>
                            	</div>
							</div>
						</div>
					</div>

					<div class="row">
				        <div class="col-md-12 pn">
				            <div class="panel mbn">
				                <div class="panel-body">
				                    <form class="form-horizontal" role="form" action="javascript:">


				                        <div class="form-group mbn">
				                            <label class="col-lg-2 control-label">No. Unit</label>
				                            <div class="col-lg-4">
				                                <p class="form-control-static text-muted" id="new-pno_unit"></p>
				                            </div>
				                        </div>
				                        <?php if($this->session->userdata('type_entity')==='HR') { ?>
				                        <div class="form-group mbn">
				                            <label class="col-lg-2 control-label">Type</label>
				                            <div class="col-lg-4">
				                                <p class="form-control-static text-muted" id="new-ptype_unit"></p>
				                            </div>
				                            <label class="col-lg-2 control-label">Tower</label>
				                            <div class="col-lg-4">
				                                <p class="form-control-static text-muted" id="new-ptower_cluster"></p>
				                            </div>
				                        </div>
				                        <div class="form-group mbn">
				                            <label class="col-lg-2 control-label">Luas Netto</label>
				                            <div class="col-lg-4">
				                                <p class="form-control-static text-muted" id="new-pwide_netto"></p>
				                            </div> 
				                            <label class="col-lg-2 control-label">Luas Semi Gross</label>
				                            <div class="col-lg-4">
				                                <p class="form-control-static text-muted" id="new-pwide_gross"></p>
				                            </div>
				                        </div>
				                        <div class="form-group mbn">
				                            <label class="col-lg-2 control-label">Lantai</label>
				                            <div class="col-lg-4">
				                                <p class="form-control-static text-muted" id="new-plantai_blok"></p>
				                            </div> 
				                            <label class="col-lg-2 control-label">View</label>
				                            <div class="col-lg-4">
				                                <p class="form-control-static text-muted" id="new-pdirection"></p>
				                            </div>
				                        </div>
				                        <?php } elseif($this->session->userdata('type_entity')==='LD') { ?>
				                        <div class="form-group mbn">
				                            <label class="col-lg-2 control-label">Type</label>
				                            <div class="col-lg-4">
				                                <p class="form-control-static text-muted" id="new-ptype_unit"></p>
				                            </div>
				                            <label class="col-lg-2 control-label">Cluster</label>
				                            <div class="col-lg-4">
				                                <p class="form-control-static text-muted" id="new-ptower_cluster"></p>
				                            </div>
				                        </div>
				                        <div class="form-group mbn">
				                            <label class="col-lg-2 control-label">Luas Bangunan</label>
				                            <div class="col-lg-4">
				                                <p class="form-control-static text-muted" id="new-pwide_netto"></p>
				                            </div> 
				                            <label class="col-lg-2 control-label">Luas Tanah</label>
				                            <div class="col-lg-4">
				                                <p class="form-control-static text-muted" id="new-pwide_gross"></p>
				                            </div>
				                        </div>
				                        <div class="form-group mbn">
				                            <label class="col-lg-2 control-label">Blok</label>
				                            <div class="col-lg-4">
				                                <p class="form-control-static text-muted" id="new-plantai_blok"></p>
				                            </div> 
				                            <label class="col-lg-2 control-label">Arah Mata Angin</label>
				                            <div class="col-lg-4">
				                                <p class="form-control-static text-muted" id="new-pdirection"></p>
				                            </div>
				                        </div>
				                        <?php } ?>
				                        <div id="prices-container">

				                        <div class="form-group mbn">
				                            <label class="col-lg-2 control-label">Harga</label>
				                            <div class="col-lg-4">
				                                <p class="form-control-static text-muted input-numeric" id="new-pharga">0</p>
				                            </div> 
				                            <label class="col-lg-2 control-label">Terbilang</label>
				                            <div class="col-lg-4">
				                                <p class="form-control-static text-muted" id="new-pterbilang"></p>
				                            </div>
				                        </div>

				                        </div>
				                    </form>
				                </div>
				            </div>
				        </div>
				    </div>

				    <div class="row">
						<div class="col-md-6 pn">
							<div class="panel mbn">
								<div class="panel-body">
									<form class="form-horizontal" role="form" action="javascript:" id="form-change-owner-1">
										<input type="hidden" id="status_tr" name="status_tr" value="RESERVE"/>
                                		<input type="hidden" id="hold_date" name="hold_date"/> 
		                                <input type="hidden" id="no_unit" name="no_unit"/>
		                                <input type="hidden" id="harga" name="harga"/>

		                                <div class="form-group">
		                                    <label class="col-lg-3 control-label">Tgl. Akad Kredit</label>
		                                    <div class="col-lg-3">
		                                        <input type="text" name="tgl_akad" id="tgl_akad" class="form-control input-sm" value="<?=date('d/m/Y')?>">
		                                    </div>
		                                    <label class="col-lg-3 control-label">Tgl. Penyerahan Aplikasi</label>
		                                    <div class="col-lg-3">
		                                        <input type="text" name="tgl_dokumen" id="tgl_dokumen" class="form-control input-sm" value="<?=date('d/m/Y')?>">
		                                    </div>
		                                </div>
		                                <div class="form-group">
		                                    <label class="col-lg-2 control-label">No. Reserve</label>
		                                    <div class="col-lg-4"> 
		                                        <p class="form-control-static text-muted" id="preserve_no">RSV----------</p>
		                                        <input type="hidden" name="reserve_no" id="reserve_no">
		                                    </div>
		                                </div>
		                                <div class="form-group">
		                                    <label class="col-lg-2 control-label">ID Sales</label>
		                                    <div class="col-lg-4">
		                                        <select name="sales_no" id="sales_no" class="chosen-select">
		                                            <option value=""></option>
		                                            <?php foreach($data['saleses'] as $k => $v) { ?>
		                                            <option value="<?=$v['kode']?>"><?=$v['nama']?></option>
		                                            <?php } ?>
		                                        </select>
		                                    </div>
		                                </div>
		                                <div class="form-group">
		                                    <label class="col-lg-2 control-label">Cara Bayar</label>
		                                    <div class="col-lg-10">
		                                        <select name="cara_bayar" id="cara_bayar" class="chosen-select">
		                                            <option value=""></option>
		                                            <?php foreach($data['paymodes'] as $k => $v) { ?>
		                                            <option value="<?=$v['kode']?>"><?=$v['konten']?></option>
		                                            <?php } ?>
		                                        </select>
		                                    </div>
		                                </div>
		                                <div class="form-group mb50">
		                                    <label class="col-lg-2 control-label">Pola Bayar</label>
		                                    <div class="col-lg-10"> 
		                                        <select name="kode_pay" id="kode_pay" class="chosen-select">
		                                            <option value=""></option>
		                                        </select>
		                                    </div>
		                                </div>
		                                <div id="pay-container"></div>
		                                <div class="form-group hidden">
		                                    <label class="col-lg-2 control-label">Bank KPR</label>
		                                    <div class="col-lg-10">
		                                        <select name="kode_bank" id="kode_bank" class="chosen-select">
		                                            <option value=""></option>
		                                            <?php foreach($data['bankkpr'] as $k => $v) { ?>
		                                            <option value="<?=$v['kode']?>"><?=$v['nama']?></option>
		                                            <?php } ?>
		                                        </select>
		                                    </div>
		                                </div>
									</form>
								</div>
							</div>
						</div>

						<div class="col-md-6 pn">
							<div class="panel mbn">
								<div class="panel-body">
									<form class="form-horizontal" role="form" action="javascript:" id="form-change-owner-2">
										<input type="hidden" name="reserve_no_old" id="reserve_no_old"/>
										<div class="form-group">
											<label class="col-lg-2 control-label">Alasan Pindah Unit</label>
											<div class="col-lg-10">
												<textarea name="remarks" class="form-control input-sm" row="3"></textarea>
											</div>
										</div>
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