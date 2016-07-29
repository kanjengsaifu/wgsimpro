<?php
$type_entity = $this->session->userdata('type_entity');
?>
<!-- Begin: Content -->
<section id="content">

    <div class="row">
        <div class="col-md-12 pn">
            <div class="panel mbn">
                <div class="panel-body mbn">
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
							</div>
							<?php
								} elseif($this->session->userdata('type_entity')==='LD') {
							?>
								<th>Cluster</th>
								<th>Luas Bangunan</th>
								<th>Luas Tanah</th>
								<th>Blok</th>
							<?php
								}
							}
							?>
								<th>View</th>
								<th>Arah Mata Angin</th>
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
                    <form class="form-horizontal" role="form" action="javascript:" id="form-input">
                    	<div class="form-group">
							<label class="col-lg-2 control-label">No. Unit</label>
							<div class="col-lg-4">
								<input type="hidden" id="no_unit" name="no_unit"/>
								<input type="hidden" id="kode_dokumen" name="kode_dokumen"/>
								<input type="hidden" id="nama_dokumen" name="nama_dokumen"/>
								<input type="button" class="row-unit hidden" id="xrow-unit" data-unit="" data-encunit=""/>
								<p class="form-control-static text-muted" id="pno_unit"></p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label">Jenis Dokumen</label>
							<div class="col-lg-4">
								<select id="jenis_dok" class="chosen-select">
									<option value=""></option>
								<?php foreach($data as $k => $v) { ?>
									<option value="<?=$v['kode']?>"><?=$v['konten']?></option>
								<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
                            <label class="col-lg-2 control-label">No. Dokumen</label>
                            <div class="col-lg-4">
                                <input type="text" name="no_dokumen" id="no_dokumen" class="form-control input-sm">
                            </div>
                        </div>
                        <div class="form-group hidden">
                            <label class="col-lg-2 control-label">Nama Notaris</label>
                            <div class="col-lg-4">
                                <input type="text" name="nama_notaris" id="nama_notaris" class="form-control input-sm">
                            </div>
                        </div>
                        <!--
						<div class="form-group">
                            <label class="col-lg-2 control-label">Tgl. Ra. Terbit</label>
                            <div class="col-lg-2">
                                <input type="text" name="tgl_ra" id="tgl_ra" class="form-control input-sm">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Tgl. Ri. Terbit</label>
                            <div class="col-lg-2">
                                <input type="text" name="tgl_ri" id="tgl_ri" class="form-control input-sm">
                            </div>
                        </div>
                    	-->
                        <div class="form-group">
							<div class="col-lg-4">&nbsp;</div>
							<div class="col-lg-2">
								<button type="button" id="btn-submit" class="btn btn-primary btn-gradient dark btn-block">Submit</button>
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
                <div class="panel-body ">
                    <table class="table table-bordered" id="datatable" cellspacing="0">
						<thead>
							<tr class="bg-primary light">
								<th>Kode</th>
								<th>Nama</th>
								<th>Nomor</th>
								<th>Ra. Terbit</th>
								<th>Ri. Terbit</th>
								<th style="width:30px">
									<div class="checkbox-custom square checkbox-success">
	                                    <input id="ckpick-head" type="checkbox">
	                                    <label for="ckpick-head">&nbsp;</label>
                                	</div>
                            	</th>
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
            <div class="panel">
                <div class="panel-body ">
                    <form class="form-horizontal hidden" role="form" action="javascript:" id="form-ra-ri">
                    	<div class="form-group">
							<div class="col-lg-3">Ubah Tanggal untuk baris data yang terpilih: </div>
							<div class="col-lg-2">
								<button type="button" id="btn-ra" class="btn btn-xs btn-success dark btn-block" data-title="Ubah Tanggal Ra. Terbit" data-type="ra"><span class="fa fa-calendar"></span>&nbsp;&nbsp;&nbsp;&nbsp;Tanggal Ra.</button>
							</div>
							<div class="col-lg-2">
								<button type="button" id="btn-ri" class="btn btn-xs btn-danger dark btn-block" data-title="Ubah Tanggal Ri. Terbit" data-type="ri"><span class="fa fa-calendar"></span>&nbsp;&nbsp;&nbsp;&nbsp;Tanggal Ri.</button>
							</div>
						</div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- modal -->
    <div class="modal fade" role="dialog" id="modalTanggal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">&nbsp;</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form class="form-horizontal" role="form" action="javascript:" id="form-input-tgl-ra-ri">
                            	<div class="hidden" id="container-date-inputs"></div>
                                <div class="form-group">
		                            <label class="col-lg-2 control-label">Tanggal</label>
		                            <div class="col-lg-2">
		                                <input type="text" id="input-tanggal" class="form-control input-sm">
		                            </div>
		                        </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="text-align: center">
                    <button type="button" id="btn-submit-tanggal" class="btn btn-primary btn-gradient dark btn-block">Submit</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- modal end -->

</section>
<!-- End: Content -->