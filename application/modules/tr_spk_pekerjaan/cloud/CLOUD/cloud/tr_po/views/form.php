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
                            <label class="col-lg-2 control-label">Tanggal&nbsp;<span class="text-danger">*</span></label>
                            <div class="col-lg-2">
                                <input type="text" name="tanggal" id="tanggal" class="form-control input-sm input-date required">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">No. PO&nbsp;<span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <input type="text" name="no_po" id="no_po" class="form-control input-sm required">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">B P D P&nbsp;<span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <select id="kode_bpdp" name="kode_bpdp" class="chosen-select required">
                                    <option value=""></option>
                                    <?php foreach($data['bpdps'] as $k => $v) { ?>
                                        <option value="<?=$v['no_path']?>"><?=$v['no_path'].' '.$v['uraian']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <label class="col-lg-2 control-label">Kontrak&nbsp;<span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <select id="kode_spk" name="kode_spk" class="chosen-select required">
                                    <option value=""></option>
                                    <?php foreach($data['kontraks'] as $k => $v) { ?>
                                        <option value="<?=$v['kode_spk']?>"><?=$v['nama']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <!--div class="form-group">
                            <label class="col-lg-2 control-label">No. Unit&nbsp;<span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <select id="no_unit" name="no_unit" class="chosen-select required">
                                    <option value=""></option>
                                    <?php foreach($data['stocks'] as $k => $v) { ?>
                                        <option value="<?=$v['no_unit']?>"><?=$v['no_unit']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div-->
                        <div class="form-group">
                            <div class="col-lg-2">&nbsp;</div>
                            <div class="col-lg-4">
                                <div class="checkbox-custom square checkbox-success">
                                    <input id="ckis_pkp-1" type="checkbox" value="1" name="is_pkp">
                                    <label for="ckis_pkp-1"> PKP ?</label>
                                </div>
                            </div>
                            <div class="col-lg-2">&nbsp;</div>
                            <div class="col-lg-4">
                                <div class="checkbox-custom square checkbox-success">
                                    <input id="ckis_order-1" type="checkbox" value="1" name="is_order">
                                    <label for="ckis_order-1"> Order ?</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-12">
                                <hr/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Sumberdaya&nbsp;<span class="text-danger">*</span></label>
                            <div class="col-lg-4">
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
                            <!-- modify: 8/12/2015 -->
                            <!--label class="col-lg-2 control-label">No. Unit</label>
                            <div class="col-lg-4">
                                <!--select id="no_unit" name="no_unit" class="chosen-select required">
                                    <option value=""></option>
                                    <?php foreach($data['stocks'] as $k => $v) { ?>
                                        <option value="<?=$v['no_unit']?>"><?=$v['no_unit']?></option>
                                    <?php } ?>
                                </select-->
                                <!--select id="no_unit[]" name="no_unit[]" class="chosen-select" multiple>
                                    <?php foreach($data['stocks'] as $k => $v) { ?>
                                        <option value="<?=$v['no_unit']?>"><?=$v['no_unit']?></option>
                                    <?php } ?>
                                </select>
                            </div-->
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">&nbsp;<span class="text-danger">&nbsp;</span></label>
                            <div class="col-lg-2">
                                <button type="button" id="btn-add-sd" class="btn btn-sm btn-success btn-gradient dark btn-block"><span class="fa fa-plus"></span>&nbsp;&nbsp;Tambah</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-12">
                                <input type="hidden" name="fc_sdid" id="fc_sdid" value="">
                                <table class="table table-striped table-bordered table-hover" id="datatable-sd" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No.</th>
                                            <th class="text-center">Sumberdaya</th>
                                            <th class="text-center">Harga Satuan</th>
                                            <th class="text-center">Volume</th>
                                            <th class="text-center">Unit</th>
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