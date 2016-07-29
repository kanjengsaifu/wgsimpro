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
                            <div class="col-lg-2 checkbox-custom square checkbox-success">
                                    <input id="ckis_um-1" type="checkbox" value="1" name="is_um">
                                    <label for="ckis_um-1"> UM ?</label>
                            </div>
                            <label class="col-lg-2 control-label">Asal Invoice&nbsp;<span class="text-danger">*</span></label>
                            <div class="col-lg-2">
                                <select id="asal_invoice" name="asal_invoice" class="chosen-select required">
                                    <option value=""></option>
                                    <option value="SPK">Surat Perintah Kerja - SPK</option>
                                    <option value="PO">Purchase Order - PO </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">No Invoice&nbsp;<span class="text-danger">*</span></label>
                            <div class="col-lg-2">
                                <input type="text" name="no_invoice" id="no_invoice" class="form-control input-sm required">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">No. PO&nbsp;<span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <select id="no_po" name="no_po" class="chosen-select required">
                                    <option value=""></option>
                                    <?php foreach($data['pos'] as $k => $v) { ?>
                                        <option value="<?=$v['no_po']?>"><?=$v['no_po']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Rekanan&nbsp;<span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <select id="kode_rekanan" name="kode_rekanan" class="chosen-select required">
                                    <option value=""></option>
                                    <?php foreach($data['rekanans'] as $k => $v) { ?>
                                        <option value="<?=$v['kode_rekanan']?>"><?=$v['nama']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">No. Surat Jalan</label>
                            <div class="col-lg-4">
                                <input type="text" name="no_surat_jalan" id="no_surat_jalan" class="form-control input-sm">
                            </div>
                            <label class="col-lg-2 control-label">Tgl. Surat Jalan</label>
                            <div class="col-lg-2">
                                <input type="text" name="tgl_surat_jalan" id="tgl_surat_jalan" class="form-control input-sm input-date">
                            </div>
                        </div>
                        <div class="form-group"  id="bapb_asal" style="display: block;">
                            <label class="col-lg-2 control-label">B A P B</label>
                            <div class="col-lg-4">
                                <select id="no_bapb" name="no_bapb" class="chosen-select">
                                    <option value=""></option>
                                    <?php foreach($data['bapbs'] as $k => $v) { ?>
                                        <option value="<?=$v['no_po']?>"><?=$v['no_po']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <label class="col-lg-2 control-label">Tgl. B A P B</label>
                            <div class="col-lg-2">
                                <input type="text" name="tgl_bapb" id="tgl_bapb" class="form-control input-sm input-date">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">B P D P</label>
                            <div class="col-lg-8">
                                <select id="kode_bpdp" name="kode_bpdp" class="chosen-select">
                                    <option value=""></option>
                                    <?php foreach($data['bpdps'] as $k => $v) { ?>
                                        <option value="<?=$v['no_path']?>"><?=$v['no_path'].' '.$v['uraian']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">No. Unit</label>
                            <div class="col-lg-4">
                                <select id="no_unit" name="no_unit[]" class="chosen-select">
                                    <?php foreach($data['stocks'] as $k => $v) { ?>
                                        <option value="<?=$v['no_unit']?>"><?=$v['no_unit']?></option>
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
                            <label class="col-lg-2 control-label">Sumberdaya</label>
                            <div class="col-lg-4">
                                <select id="kode_sumberdaya" class="chosen-select">
                                    <option value=""></option>
                                    <?php foreach($data['sumberdayas'] as $k => $v) { ?>
                                        <option value="<?=$v['kode']?>" data-harga="<?=$v['harga_satuan']?>"><?=$v['nama']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <label class="col-lg-2 control-label">Harga Satuan</label>
                            <div class="col-lg-2">
                                <input type="text" id="harga_satuan" class="form-control input-sm input-numeric text-right" value="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Volume</label>
                            <div class="col-lg-2">
                                <input type="text" id="volume" class="form-control input-sm input-numeric text-right" value="0">
                            </div>
                            <div class="col-lg-2">
                                <button type="button" id="btn-add-sd" class="btn btn-sm btn-success btn-gradient dark btn-block"><span class="fa fa-plus"></span>&nbsp;&nbsp;Tambah</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-12">
                                <table class="table table-striped table-bordered table-hover" id="datatable-sd" cellspacing="0" width="100%">
                                    <thead>
                                        <tr class="bg-primary light bg-gradient">
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
                            <label class="col-lg-2 control-label" id="lbl-title">Nilai Invoice</label>
                            <div class="col-lg-2">
                                <input type="text" id="rp" name="rp" class="form-control input-sm input-numeric text-right" value="0">
                            </div>
                            <div class="col-lg-4">
                                <div class="checkbox-custom square checkbox-success">
                                    <input id="ckis_pkp-1" type="checkbox" value="1" name="is_pkp">
                                    <label for="ckis_pkp-1"> PKP ?</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label" id="lbl-title">PPN</label>
                            <div class="col-lg-2">
                                <input type="text" id="ppn" name="ppn" class="form-control input-sm input-numeric text-right" value="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label" id="lbl-title">PPh</label>
                            <div class="col-lg-2">
                                <input type="text" id="pph" name="pph" class="form-control input-sm input-numeric text-right" value="0">
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