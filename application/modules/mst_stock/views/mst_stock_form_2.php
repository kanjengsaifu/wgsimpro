        <!-- Start: Content -->
        <section id="content_wrapper">

				<?php $this->load->view('../../home/views/title'); ?>
            <!-- Begin: Content -->
            <section id="content">
				<div class="row">
					<div class="col-md-12">
						<div class="panel">
							<div class="panel-body">
								<form class="form-horizontal" role="form" action="javascript:" id="form-input">
									<input type="hidden" id="id" name="id"/>
									<div class="form-group">
										<label class="col-lg-2 control-label">Kawasan / Entity</label>
										<div class="col-lg-10">
											<select id="kode_entity" name="kode_entity" class="chosen-select" data-placeholder="Entity">
											<?php foreach($entities as $k => $v) { ?>
												<option value="<?=$v['kode']?>"><?=$v['nama']?></option>
											<?php } ?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-2 control-label">Kode Cluster</label>
										<div class="col-lg-4">
											<select id="kode_cluster" name="kode_cluster" class="chosen-select" data-placeholder="Kode Cluster">
											<?php foreach($clustercode as $k => $v) { ?>
												<option value="<?=$v['kode']?>"><?=$v['nama']?></option>
											<?php } ?>
											</select>
										</div>
										<label class="col-lg-2 control-label">Tipe Property</label>
										<div class="col-lg-4">
											<select id="unit_type" name="unit_type" class="chosen-select" data-placeholder="Tipe Property">
											<?php foreach($unittype as $k => $v) { ?>
												<option value="<?=$v['kode']?>"><?=$v['nama']?></option>
											<?php } ?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-2 control-label">Tower</label>
										<div class="col-lg-4">
											<input type="text" id="tower" name="tower" class="form-control input-sm">
										</div>
										<label class="col-lg-2 control-label">No. Unit</label>
										<div class="col-lg-4">
											<input type="text" id="no_unit" name="no_unit" class="form-control input-sm">
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-2 control-label">Panjang Tanah</label>
										<div class="col-lg-4">
											<input type="text" id="p_tanah" name="p_tanah" class="form-control input-sm">
										</div>
										<label class="col-lg-2 control-label">Lebar Tanah</label>
										<div class="col-lg-4">
											<input type="text" id="l_tanah" name="l_tanah" class="form-control input-sm">
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-2 control-label">Luas Bangunan</label>
										<div class="col-lg-4">
											<input type="text" id="luas_bangunan" name="luas_bangunan" class="form-control input-sm">
										</div>
										<label class="col-lg-2 control-label">Luas Tanah</label>
										<div class="col-lg-4">
											<input type="text" id="luas_tanah" name="luas_tanah" class="form-control input-sm">
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-2 control-label">Lantai</label>
										<div class="col-lg-4">
											<input type="text" id="lantai" name="lantai" class="form-control input-sm">
										</div>
										<label class="col-lg-2 control-label">Kavling</label>
										<div class="col-lg-4">
											<input type="text" id="kavling" name="kavling" class="form-control input-sm">
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-2 control-label">Zona</label>
										<div class="col-lg-4">
											<input type="text" id="zone" name="zone" class="form-control input-sm">
										</div>
										<label class="col-lg-2 control-label">Blok</label>
										<div class="col-lg-4">
											<input type="text" id="blok" name="blok" class="form-control input-sm">
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-2 control-label">Kondisi Kavling</label>
										<div class="col-lg-4">
											<textarea id="kondisi_kavling" name="kondisi_kavling" class="form-control input-sm" row="3"></textarea>
										</div>
										<label class="col-lg-2 control-label">No. Virtual Account</label>
										<div class="col-lg-4">
											<input type="text" id="no_virtual_account" name="no_virtual_account" class="form-control input-sm">
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-2">&nbsp;</div>
										<div class="col-md-4">
											<div class="checkbox-custom checkbox-success mb5">
												<input type="checkbox" id="ishold_admin" name="ishold_admin" value="1">
												<label for="ishold_admin">Hold (by admin)</label> 
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-2 control-label">Deskripsi</label>
										<div class="col-lg-4">
											<textarea id="description" name="description" class="form-control input-sm" row="3"></textarea>
										</div>
										<label class="col-lg-2 control-label">Alamat</label>
										<div class="col-lg-4">
											<textarea id="alamat" name="alamat" class="form-control input-sm" row="3"></textarea>
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-2 control-label">Kota</label>
										<div class="col-lg-4">
											<input type="text" id="kota" name="kota" class="form-control input-sm">
										</div>
										<label class="col-lg-2 control-label">Kodepos</label>
										<div class="col-lg-4">
											<input type="text" id="kodepos" name="kodepos" class="form-control input-sm">
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-2 control-label">Area UOM</label>
										<div class="col-lg-4">
											<input type="text" id="area_uom" name="area_uom" class="form-control input-sm">
										</div>
										<label class="col-lg-2 control-label">Reference No.</label>
										<div class="col-lg-4">
											<input type="text" id="ref_no" name="ref_no" class="form-control input-sm">
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-2 control-label">Direction</label>
										<div class="col-lg-4">
											<input type="text" id="direction" name="direction" class="form-control input-sm">
										</div>
										<label class="col-lg-2 control-label">Remarks</label>
										<div class="col-lg-4"> 
											<textarea id="remarks" name="remarks" class="form-control input-sm" row="3"></textarea>
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-2">&nbsp;</div>
										<div class="col-sm-4">
											<div class="checkbox-custom checkbox-success mb5">
												<input type="checkbox" id="issales" name="issales" value="1">
												<label for="issales">Sales</label> 
											</div>
										</div>
										<div class="col-sm-2">Price Display</div>
										<div class="col-sm-4">
											<div class="radio-custom square radio-success mb5">
												<input type="radio" id="price_display1" name="price_display" value="1">
												<label for="price_display1">Include VAT</label>&nbsp;&nbsp;
												<input type="radio" checked="checked" id="price_display0" name="price_display" value="0">
												<label for="price_display0">Exclude VAT</label> 
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-2 control-label">Mort Status</label>
										<div class="col-lg-4">
											<input type="text" id="mort_status" name="mort_status" class="form-control input-sm">
										</div>
										<label class="col-lg-2 control-label">Recog. Date</label>
										<div class="col-lg-4">
											<input type="text" id="recog_date" name="recog_date" class="form-control input-sm">
										</div>
									</div>
									<div class="row mt20 text-center">
										<div class="col-md-8">&nbsp;</div>
										<div class="col-md-1">
											<button type="button" id="btn-submit" class="btn btn-primary btn-gradient dark btn-block">Submit</button>
										</div>
										<div class="col-md-1">
											<button type="button" class="btn btn-danger btn-gradient dark btn-block">Cancel</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>

            </section>
            <!-- End: Content -->

        </section>
		