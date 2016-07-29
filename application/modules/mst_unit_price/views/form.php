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
							<label class="col-lg-1 control-label">No. Unit</label>
							<div class="col-lg-4">
								<input type="hidden" id="no_unit" name="no_unit"/>
								<input type="hidden" id="grup" name="grup"/>
								<input type="button" class="row-unit hidden" id="xrow-unit" data-unit="" data-encunit=""/>
								<p class="form-control-static text-muted" id="pno_unit"></p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-1 control-label">Pola Bayar</label>
							<div class="col-lg-4">
								<select id="kode_pay" name="kode_pay" class="chosen-select">
									<option value=""></option>
								<?php foreach($data['paymodes'] as $k => $v) { ?>
									<option value="<?=$v['kode_pay']?>"><?=$v['deskripsi']?></option>
								<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-1 control-label">Jenis</label>
							<div class="col-lg-4">
								<select id="type_price" name="type_price" class="chosen-select">
									<option value=""></option>
								<?php foreach($data['type_price'] as $k => $v) { ?>
									<option value="<?=$v['kode']?>" data-grup="<?=$v['grup']?>" data-formula="<?=$v['formula']?>"><?=$v['konten']?></option>
								<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-1 control-label">Nominal</label>
							<div class="col-lg-2">
								<input type="text" name="rp" id="rp" class="form-control input-sm input-numeric text-right" value="0.00">
							</div>
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
            <div class="panel">
                <div class="panel-body ">
                    <table class="table table-bordered" id="datatable" cellspacing="0">
						<thead></thead>
						<tbody></tbody>
						<tfoot></tfoot>
					</table>
                </div>
            </div>
        </div>
    </div>

</section>
<!-- End: Content -->