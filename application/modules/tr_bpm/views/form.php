<!-- Begin: Content -->
<section id="content">
	
	<div class="row">
		<div class="col-md-12 pn">
			<div class="panel mbn">
				<div class="panel-body" id="pnlbody">
					<form class="form-horizontal" role="form" action="javascript:" id="form-input">
						<input type="hidden" name="id" id="id" />
						<div class="form-group">
							<label class="col-lg-2 control-label">No BPM.</label>
                            <div class="col-lg-2">
	                            <input type="text" name="no_bpm" id="no_bpm" class="form-control input-sm required">
	                        </div>
                            
                        </div>
                        <div class="form-group">
							<label class="col-lg-2 control-label">Tanggal</label>
							<div class="col-lg-2">
								<input type="text" name="tgl_bpm" id="tgl_bpm" class="form-control input-sm input-date required">
							</div>
						</div>
                        <div class="form-group">
							<label class="col-lg-2 control-label">Sudah Konfirmasi</label>
                            <div class="col-lg-1">
	                            <div class="radio-custom square radio-success mb5">
	                              <input type="radio" id="konf1" name="konfirmasi" value="1" checked="checked">
	                              <label for="jenis1">Iya</label>
	                            </div>
	                        </div>
	                        <div class="col-lg-1">
	                            <div class="radio-custom square radio-primary mb5">
	                              <input type="radio" id="konf2" name="konfirmasi" value="2">
	                              <label for="jenis2">Tidak</label>
	                            </div>
                            </div>
						</div>
						<div class="form-group">
                            <div class="col-lg-12">
                                <hr/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label sumberdayas">Sumberdaya&nbsp;<span class="text-danger">*</span></label>
                            <div class="col-lg-4 sumberdayas">
                                <select id="kode_sumberdaya" class="chosen-select">
                                    <option value=""></option>
                                    <?php foreach($data['sumberdayas'] as $k => $v) { ?>
                                        <option value="<?=$v['kode']?>"><?=$v['nama']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <label class="col-lg-2 control-label">Harga Satuan&nbsp;<span class="text-danger">*</span></label>
                            <div class="col-lg-2">
                                <input type="text" id="harga_satuan" class="form-control input-sm input-numeric text-right" value="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Volume&nbsp;<span class="text-danger">*</span></label>
                            <div class="col-lg-2">
                                <input type="text" id="volume" class="form-control input-sm input-numeric text-right" value="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">&nbsp;<span class="text-danger">&nbsp;</span></label>
                            <div class="col-lg-2">
                                <button type="button" id="btn-add-sd" class="btn btn-sm btn-success btn-gradient dark btn-block"><span class="fa fa-plus"></span>&nbsp;&nbsp;Tambah</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-12">
                                <table class="table table-striped table-bordered table-hover" id="datatable-sd" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No.</th>
                                            <th class="text-center">Sumberdaya</th>
                                            <th class="text-center">Harga Satuan</th>
                                            <th class="text-center">Volume</th>
                                            <th class="text-center">&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-12">
                                <hr/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-10 control-label">&nbsp;</label>
                            <div class="col-lg-2">
                                <button type="button" id="btn-submit" class="btn btn-primary btn-gradient dark btn-block">Submit</button>
                            </div>
                        </div>
					</form>
				</div>
			</div>
		</div>
	</div>

	

</section>
<!-- End: Content -->