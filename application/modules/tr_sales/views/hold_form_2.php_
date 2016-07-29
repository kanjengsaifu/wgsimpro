<!-- Begin: Content -->
<section id="content">

    <div class="row">
        <div class="col-md-12 pn">
            <div class="panel mbn">
                <div class="panel-body">
                    <form class="form-horizontal" role="form" action="javascript:">


                        <div class="form-group mbn">
                            <label class="col-lg-2 control-label">No. Unit</label>
                            <div class="col-lg-4">
                                <button class="row-unit hidden" id="eno_unit" data-encunit=""></button>
                                <p class="form-control-static text-muted" id="pno_unit"></p>
                            </div>
                        </div>
                        <?php if($this->session->userdata('type_entity')==='HR') { ?>
                        <div class="form-group mbn">
                            <label class="col-lg-2 control-label">Type</label>
                            <div class="col-lg-4">
                                <p class="form-control-static text-muted" id="ptype_unit"></p>
                            </div>
                            <label class="col-lg-2 control-label">Tower</label>
                            <div class="col-lg-4">
                                <p class="form-control-static text-muted" id="ptower_cluster"></p>
                            </div>
                        </div>
                        <div class="form-group mbn">
                            <label class="col-lg-2 control-label">Luas Netto</label>
                            <div class="col-lg-4">
                                <p class="form-control-static text-muted" id="pwide_netto"></p>
                            </div> 
                            <label class="col-lg-2 control-label">Luas Semi Gross</label>
                            <div class="col-lg-4">
                                <p class="form-control-static text-muted" id="pwide_gross"></p>
                            </div>
                        </div>
                        <div class="form-group mbn">
                            <label class="col-lg-2 control-label">Lantai</label>
                            <div class="col-lg-4">
                                <p class="form-control-static text-muted" id="plantai_blok"></p>
                            </div> 
                            <label class="col-lg-2 control-label">View</label>
                            <div class="col-lg-4">
                                <p class="form-control-static text-muted" id="pdirection"></p>
                            </div>
                        </div>
                        <?php } elseif($this->session->userdata('type_entity')==='LD') { ?>
                        <div class="form-group mbn">
                            <label class="col-lg-2 control-label">Type</label>
                            <div class="col-lg-4">
                                <p class="form-control-static text-muted" id="ptype_unit"></p>
                            </div>
                            <label class="col-lg-2 control-label">Cluster</label>
                            <div class="col-lg-4">
                                <p class="form-control-static text-muted" id="ptower_cluster"></p>
                            </div>
                        </div>
                        <div class="form-group mbn">
                            <label class="col-lg-2 control-label">Luas Bangunan</label>
                            <div class="col-lg-4">
                                <p class="form-control-static text-muted" id="pwide_netto"></p>
                            </div> 
                            <label class="col-lg-2 control-label">Luas Tanah</label>
                            <div class="col-lg-4">
                                <p class="form-control-static text-muted" id="pwide_gross"></p>
                            </div>
                        </div>
                        <div class="form-group mbn">
                            <label class="col-lg-2 control-label">Blok</label>
                            <div class="col-lg-4">
                                <p class="form-control-static text-muted" id="plantai_blok"></p>
                            </div> 
                            <label class="col-lg-2 control-label">Arah Mata Angin</label>
                            <div class="col-lg-4">
                                <p class="form-control-static text-muted" id="pdirection"></p>
                            </div>
                        </div>
                        <?php } ?>
                        <div id="prices-container">

                        <div class="form-group mbn">
                            <label class="col-lg-2 control-label">Harga</label>
                            <div class="col-lg-4">
                                <p class="form-control-static text-muted input-numeric" id="pharga">0</p>
                            </div> 
                            <label class="col-lg-2 control-label">Terbilang</label>
                            <div class="col-lg-4">
                                <p class="form-control-static text-muted" id="pterbilang"></p>
                            </div>
                        </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 pn">
        <form class="form-horizontal" role="form" action="javascript:" id="form-customer">
            <div class="panel-group accordion" id="example1">
                <div class="panel">
                    <div class="panel-heading bg-success2" style="padding: 1px 0px 0px 5px!important;">
                        <a class="accordion-toggle accordion-icon" data-toggle="collapse" data-parent="#example1" href="#panel-item1" style="color:#fff">Data Nasabah</a>
                    </div>
                    <div id="panel-item1" class="panel-collapse collapse in">
                        <div class="panel-body">
                            
                            <input type="hidden" id="status_tr" name="status_tr" value="HOLD"/> 
                            <input type="hidden" id="hold_date" name="hold_date" value="<?=date('Y-m-d')?>"/>
                            <input type="hidden" id="no_unit" name="no_unit"/>

                            <div class="form-group">
                                <label class="col-lg-2 control-label">Kode Nasabah</label>
                                <div class="col-lg-4">
                                    <p class="form-control-static text-muted" id="pkode"></p>
                                    <input type="hidden" name="kode" id="kode">
                                </div>
                            </div>
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
                                <label class="col-lg-2 control-label">Tempat Lahir</label>
                                <div class="col-lg-4">
                                    <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control input-sm">
                                </div>
                                <label class="col-lg-2 control-label">Tanggal Lahir</label>
                                <div class="col-lg-4">
                                    <input type="text" name="tgl_lahir" id="tgl_lahir" class="form-control input-sm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Kewarganegaraan</label>
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
                            <!--
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Nama Perusahaan</label>
                                <div class="col-lg-4">
                                    <input type="text" name="nama_perusahaan" id="nama_perusahaan" class="form-control input-sm">
                                </div>
                                <label class="col-lg-2 control-label">Alamat Perusahaan</label>
                                <div class="col-lg-4">
                                    <textarea name="alamat_perusahaan" id="alamat_perusahaan" class="form-control input-sm" row="3"></textarea>
                                </div>
                            </div>
                            -->
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
    </div>


<div class="row mt20 text-center">
    <div class="col-md-9">&nbsp;</div> 
    <div class="col-md-2">
        <button type="button" id="btn-hold" class="btn btn-primary btn-gradient dark btn-block">Submit Hold</button>
    </div>
</div>

</section>
<!-- End: Content -->