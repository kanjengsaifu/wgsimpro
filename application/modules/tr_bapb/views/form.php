<!-- Begin: Content -->
<section id="content">
    <?php
    //=var_dump($data['naskon']);
    ?>
    <div class="row">
        <div class="col-md-12 pn">
            <div class="panel mbn">
                <div class="panel-body" id="pnlbody">
                    <form class="form-horizontal" role="form" action="javascript:" id="form-input">
                        <input type="hidden" name="id" id="id" value="<?=isset($data['naskon']['id'])?>" />
                        <div class="form-group">
                            <label class="col-lg-2 control-label">No BAPB.</label>
                            <div class="col-lg-2">
                                <input type="text" name="no_bapb" id="no_bapb" class="form-control input-sm required" value="<?=isset($data['naskon']['no_bapb'])?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Nasabah</label>
                            <div class="col-lg-6">
                                <select id="kd_nasabah" name="kd_nasabah" class="chosen-select required">
                                    <option value=""></option>
                                    <?php 
                                    
                                    foreach($data['nasabahkon'] as $k => $v) { ?>
                                        <option value="<?=$v['kode']?>">[<?=$v['kode']?>] <?=$v['nama']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="col-lg-2 control-label">No. Surat Jalan</label>
                            <div class="col-lg-2">
                                <input type="text" name="no_surat_jalan" id="no_surat_jalan" class="form-control input-sm" value="<?=isset($data['naskon']['no_surat_jalan'])?>">
                            </div>
                            <label class="col-lg-2 control-label">Biaya Angkut</label>
                            <div class="col-lg-1">
                                <div class="radio-custom square radio-success mb5">
                                  <input type="radio" id="angkut1" name="angkut_id" value="1" checked="checked">
                                  <label for="angkut1">Iya</label>
                                </div>
                            </div>
                            <div class="col-lg-1">
                                <div class="radio-custom square radio-primary mb5">
                                  <input type="radio" id="angkut2" name="angkut_id" value="2">
                                  <label for="angkut2">Tidak</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Tanggal BAPB</label>
                            <div class="col-lg-2">
                            <?php 
                                $tglbapb = isset($data['naskon']['tanggal'])?$data['naskon']['tanggal']:''; 
                                list($thn,$bln,$tgl) = explode('-', $tglbapb);
                                $tanggal_bapb = $tgl.'/'.$bln.'/'.$thn;
                            ?>
                                <input type="text" name="tgl_bapb" id="tgl_bapb" class="form-control input-sm input-date required" value="<?=$tanggal_bapb?>">
                            </div>
                            <label class="col-lg-2 control-label">No. Kontrak Angkut</label>
                            <div class="col-lg-4">
                                <select id="no_kontrak" name="no_kontrak" class="chosen-select required">
                                    <option value=""></option>
                                    <?php 
                                    foreach($data['kontrak']as $k => $v) { ?>
                                        <option value="<?=$v['no_kontrak']?>" <?=($v['no_kontrak']==$data['naskon']['no_kontrak']?' selected="selected"':'')?>>[<?=$v['no_kontrak']?>] <?=$v['nama']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Sudah Konfirmasi</label>
                            <div class="col-lg-1">
                                <div class="radio-custom square radio-success mb5">
                                  <input type="radio" id="konf1" name="konfirmasi" value="1" checked="checked">
                                  <label for="konf1">Iya</label>
                                </div>
                            </div>
                            <div class="col-lg-1">
                                <div class="radio-custom square radio-primary mb5">
                                  <input type="radio" id="konf2" name="konfirmasi" value="2">
                                  <label for="konf2">Tidak</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Uraian</label>
                            <div class="col-lg-4">
                                  <textarea name="uraian" id="uraian" class="form-control input-sm input-date required"><?=$data['naskon']['uraian']?></textarea>
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