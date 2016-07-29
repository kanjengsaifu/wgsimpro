<!-- Begin: Content -->
<section id="content">

    <div class="row">
        <div class="col-md-12 pn">
            <div class="panel mbn">
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover" id="datatable" cellspacing="0" width="100%">
                        <thead>
                            <tr class="bg-primary light bg-gradient">
                                <th>No. Unit</th>
                                <th>Nasabah</th>
                                <th>Bank</th>
                                <th>Nominal KPR</th>
                                <th>Nominal UM</th>
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

                        <input type="hidden" name="reserve_no" id="reserve_no"/>
                        <input type="button" id="xresno" class="row-view hidden"/>

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
                                <p class="form-control-static pbn"><b>3. Dokumen Persetujuan</b></p>
                            </div>
                        </div>
                        <div class="form-group pl15">
                            <div class="col-lg-2">
                                <p class="form-control-static pbn"><b>- No. Surat Persetujuan</b></p>
                            </div>
                            <div class="col-lg-4">
                                <input type="text" name="no_persetujuan_kredit" id="no_persetujuan_kredit" class="form-control input-sm">
                            </div>
                        </div>
                        <div class="form-group pl15">
                            <div class="col-lg-2">
                                <p class="form-control-static pbn"><b>- Tgl. Surat</b></p>
                            </div>
                            <div class="col-lg-2">
                                <input type="text" name="tgl_disetujui" id="tgl_disetujui" class="form-control input-sm">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-lg-2">
                                <p class="form-control-static pbn"><b>4. Ri. Akad Kredit</b></p>
                            </div>
                            <div class="col-lg-2 pl25">
                                <input type="text" name="tgl_ri_akad" id="tgl_ri_akad" class="form-control input-sm">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-lg-2">
                                <p class="form-control-static pbn"><b>5. Bank KPR</b></p>
                            </div>
                            <div class="col-lg-4 pl25">
                                <select name="kode_bank" id="kode_bank" class="chosen-select">
                                    <option value=""></option>
                                    <?php foreach($data['bankkpr'] as $k => $v) { ?>
                                    <option value="<?=$v['kode']?>"><?=$v['nama']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-2">
                                <p class="form-control-static pbn"><b>6. Nomial yang disetujui (Plafond)</b></p>
                            </div>
                            <div class="col-lg-2 pl25">
                                <input type="text" name="rp" id="rp" class="form-control input-sm input-numeric text-right" value="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 control-label">&nbsp;</label>
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
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover" id="datatable-alokasi" cellspacing="0" width="100%">
                        <thead>
                            <tr class="bg-primary light bg-gradient">
                                <th width="5%"></th>
                                <th>Pencairan</th>
                                <th>Nominal</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot></tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

</section>
<!-- End: Content -->