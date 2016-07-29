<?php
    $kode_entity = $this->session->userdata('kode_entity');
?>
<!-- Begin: Content -->
<section id="content">

    <div class="row">
        <div class="col-md-12 pn">
            <div class="panel">
                <div class="panel-body">
                	<form class="form-horizontal" role="form" action="javascript:" id="form-input">
                		<input type="hidden" name="id" id="id"/>
                        <input type="hidden" name="kode_entity" id="kode_entity" value="<?php echo $kode_entity;?>"/>
                		<div class="form-group">
							<label class="col-lg-2 control-label">Jenis Kontrak</label>
                            <div class="col-lg-2">
	                            <div class="radio-custom square radio-success mb5">
	                              <input type="radio" id="jenis1" name="flag" value="1" checked="checked" class="flag">
	                              <label for="jenis1">Pengadaan</label>
	                            </div>
	                        </div>
	                        <div class="col-lg-2">
	                            <div class="radio-custom square radio-primary mb5">
	                              <input type="radio" id="jenis2" name="flag" value="2" class="flag">
	                              <label for="jenis2">Angkut</label>
	                            </div>
                            </div>
						</div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">No. Kontrak&nbsp;<span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <input type="text" name="no_kontrak" id="no_kontrak" class="form-control input-sm required">
                            </div>
                            <label class="col-lg-2 control-label">% PPN</label>
                            <div class="col-lg-1">
                                <input type="text" name="ppn" id="ppn" class="form-control input-sm">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Tanggal&nbsp;Kontrak<span class="text-danger">*</span></label>
                            <div class="col-lg-2">
                                <input type="text" name="tanggal" id="tanggal" class="form-control input-sm input-date required">
                            </div>
                            <label class="col-lg-4 control-label">% PPH</label>
                            <div class="col-lg-1">
                                <input type="text" name="pph" id="pph" class="form-control input-sm">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Nasabah&nbsp;<span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <select id="kd_nasabah" name="kd_nasabah" class="chosen-select required">
                                    <option value=""></option>
                                    <?php 
                                    foreach($data['nasabahkon']as $k => $v) { ?>
                                        <option value="<?=$v['kode']?>">[<?=$v['kode']?>] <?=$v['nama']?></option>
                                    <?php } ?>
                                </select>
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
                                        <option value="<?=$v['kode']?>" data-harga="<?=$v['harga_satuan']?>"><?=$v['nama']?></option>
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