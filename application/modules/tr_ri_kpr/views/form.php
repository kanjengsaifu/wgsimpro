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
                        <input type="hidden" name="persentase" id="persentase"/>
                        <input type="hidden" name="keterangan" id="keterangan"/>
                        <input type="hidden" id="lplafond"/>
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
                                <p class="form-control-static pbn"><b>3. Data Realisasi KPR</b></p>
                            </div>
                        </div>
                        <div class="form-group mbn pl15">
                            <div class="col-lg-2">
                                <p class="form-control-static pbn"><b>- No. Reserve</b></p>
                            </div>
                            <div class="col-lg-10">
                                <p class="form-control-static pbn garbaw100" id="presno">:</p>
                            </div>
                        </div>
                        <div class="form-group mbn pl15">
                            <div class="col-lg-2">
                                <p class="form-control-static pbn"><b>- Bank KPR</b></p>
                            </div>
                            <div class="col-lg-10">
                                <p class="form-control-static pbn garbaw100" id="pbank">:</p>
                            </div>
                        </div>
                        <div class="form-group mbn pl15">
                            <div class="col-lg-2">
                                <p class="form-control-static pbn"><b>- Plafond (disetujui)</b></p>
                            </div>
                            <div class="col-lg-10">
                                <p class="form-control-static pbn garbaw100" id="pplafond">:</p>
                            </div>
                        </div>
                        <div class="form-group pl15">
                            <div class="col-lg-2">
                                <p class="form-control-static pbn">&nbsp;</p>
                            </div>
                        </div>
                        <div class="form-group pl15">
                            <div class="col-lg-2">
                                <p class="form-control-static pbn"><b>- Item Alokasi</b></p>
                            </div>
                            <div class="col-lg-4">
                                <select id="alokasi" class="chosen-select">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group pl15">
                            <div class="col-lg-2">
                                <p class="form-control-static pbn"><b>- Nominal</b></p>
                            </div>
                            <div class="col-lg-2">
                                <input type="text" name="rp" id="rp" class="form-control input-sm input-numeric text-right" value="0">
                            </div>
                        </div>
                        <div class="form-group pl15">
                            <div class="col-lg-2">
                                <p class="form-control-static pbn"><b>- Tgl. Realisasi</b></p>
                            </div>
                            <div class="col-lg-2">
                                <input type="text" name="tanggal" id="tanggal" class="form-control input-sm" value="<?=date('d/m/Y')?>">
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
                                <th>Pencairan</th>
                                <th>Nominal</th>
                                <th>Keterangan</th>
                                <th>Nominal Ri.</th>
                                <th>Tanggal</th>
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