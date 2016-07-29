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
					<form class="form-horizontal" role="form" action="javascript:" id="form-change-owner">
						<input type="hidden" name="reserve_no_old" id="reserve_no_old"/>
						<div class="form-group">
                            <label class="col-lg-2 control-label">Klasifikasi <span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <select id="klasifikasi" name="klasifikasi" class="chosen-select">
                                    <option value=""></option>
                                <?php foreach($data['klasifikasi'] as $k => $v) { ?>
                                    <option value="<?=$v['kode']?>"><?=$v['konten']?></option>
                                <?php } ?>
                                </select>
                            </div>
                            <label class="col-lg-2 control-label">Salutation <span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <select id="salutation" name="salutation" class="chosen-select">
                                    <option value=""></option>
                                <?php foreach($data['salutation'] as $k => $v) { ?>
                                    <option value="<?=$v['kode']?>"><?=$v['konten']?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Nama Nasabah <span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <input type="text" name="nama" id="nama" class="form-control input-sm">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Jenis Identitas <span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <select id="jenis_id" name="jenis_id" class="chosen-select">
                                    <option value=""></option>
                                <?php foreach($data['jenis_id'] as $k => $v) { ?>
                                    <option value="<?=$v['kode']?>"><?=$v['konten']?></option>
                                <?php } ?>
                                </select>
                            </div>
                            <label class="col-lg-2 control-label">No. Identitas <span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <input type="text" name="no_id" id="no_id" class="form-control input-sm">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">NPWP <span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <input type="text" name="npwp" id="npwp" class="form-control input-sm">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">HP <span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <input type="text" name="hp" id="hp" class="form-control input-sm">
                            </div>
                            <label class="col-lg-2 control-label">Email <span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <input type="text" name="email" id="email" class="form-control input-sm">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Tempat Lahir <span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control input-sm">
                            </div>
                            <label class="col-lg-2 control-label">Tanggal Lahir <span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <input type="text" name="tgl_lahir" id="tgl_lahir" class="form-control input-sm">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Kewarga negaraan</label>
                            <div class="col-lg-4">
                                <select id="nationality" name="nationality" class="chosen-select">
                                    <option value=""></option>
                                <?php foreach($data['nationality'] as $k => $v) { ?>
                                    <option value="<?=$v['kode']?>"><?=$v['konten']?></option>
                                <?php } ?>
                                </select>
                            </div>
                            <label class="col-lg-2 control-label">Agama</label>
                            <div class="col-lg-4">
                                <select id="agama" name="agama" class="chosen-select">
                                    <option value=""></option>
                                <?php foreach($data['agama'] as $k => $v) { ?>
                                    <option value="<?=$v['kode']?>"><?=$v['konten']?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Jenis Kelamin</label>
                            <div class="col-lg-4">
                                <select id="jk" name="jk" class="chosen-select">
                                    <option value=""></option>
                                <?php foreach($data['jk'] as $k => $v) { ?>
                                    <option value="<?=$v['kode']?>"><?=$v['konten']?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">&nbsp;</label>
                            <div class="col-lg-4">
                                <button type="button" id="btn-add-alamat" class="btn btn-sm btn-success"><span class="fa fa-plus"></span> Tambah Alamat</button>
                            </div>
                        </div>
                        <div id="alamat-container">
                        <div class="alamat-group">

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Alamat #1</label>
                            <div class="col-lg-4">
                                <textarea name="alamat[]" class="form-control input-sm" row="3"></textarea>
                            </div>
                            <label class="col-lg-2 control-label blank-label">&nbsp;</label>
                            <div class="col-lg-4">
                                <div class="radio-custom square radio-success">
                                    <input id="ckalamat-1" type="radio" value="0" name="idx-alamat">
                                    <label for="ckalamat-1"> Alamat Surat-menyurat ?</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Kota</label>
                            <div class="col-lg-4">
                                <input type="text" name="kota[]" class="form-control input-sm">
                            </div>
                            <label class="col-lg-2 control-label">Kodepos</label>
                            <div class="col-lg-4">
                                <input type="text" name="kodepos[]" class="form-control input-sm">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">No. Telepon</label>
                            <div class="col-lg-4">
                                <input type="text" name="telp[]" class="form-control input-sm">
                            </div>
                            <label class="col-lg-2 control-label">Fax</label>
                            <div class="col-lg-4">
                                <input type="text" name="fax[]" class="form-control input-sm">
                            </div>
                        </div>

                        </div>
                        </div>
                        <div class="form-group">
							<div class="col-lg-12">
								<hr/>
							</div>
						</div>
						<div class="form-group">
							<input type="hidden" id="rp_netto" value="0"/>
                            <label class="col-lg-2 control-label blank-label">&nbsp;</label>
                            <div class="col-lg-4">
                                <div class="checkbox-custom square checkbox-success">
                                    <input id="ckrelated-1" type="checkbox" value="1" name="is_related">
                                    <label for="ckrelated-1"> Memiliki hubungan keluarga ?</label>
                                </div>
                            </div>
                        </div>
						<div class="form-group">
							<label class="col-lg-2 control-label">Alasan Ganti Kepemilikan</label>
							<div class="col-lg-4">
								<textarea name="remarks" class="form-control input-sm" row="3"></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label">Biaya Administrasi</label>
							<div class="col-lg-2">
								<input type="text" id="adm_rp" name="adm_rp" class="form-control input-sm input-numeric text-right" value="0">
							</div>
							<div class="col-lg-6">&nbsp;</div>
							<div class="col-lg-2">
								<button id="btn-submit-change" class="btn btn-primary btn-gradient dark btn-block">Submit Change</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	
</section>
<!-- End: Content -->