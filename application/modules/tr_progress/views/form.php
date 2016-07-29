<!-- Begin: Content -->
<section id="content">

    <div class="row">
        <div class="col-md-12 pn">
            <div class="panel mbn">
                <div class="panel-body">
                    <form class="form-horizontal" role="form" action="javascript:" id="form-filter">

                        <input type="hidden" name="id" id="id"/>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Type Property</label>
                            <div class="col-lg-4">
                                <select id="type_property" class="chosen-select">
                                    <option value=""></option>
                                <?php foreach ($data['type_property'] as $k => $v) { ?>
                                    <option value="<?=$v['kode']?>"><?=$v['konten']?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Cluster Tower</label>
                            <div class="col-lg-4">
                                <select id="tower_cluster" class="chosen-select">
                                    <option value=""></option>
                                <?php foreach ($data['tower_cluster'] as $k => $v) { ?>
                                    <option value="<?=$v['kode']?>"><?=$v['konten']?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Blok Lantai</label>
                            <div class="col-lg-4">
                                <select id="lantai_blok" class="chosen-select">
                                    <option value=""></option>
                                <?php foreach ($data['lantai_blok'] as $k => $v) { ?>
                                    <option value="<?=$v['kode']?>"><?=$v['konten']?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">No. Unit</label>
                            <div class="col-lg-4">
                                <select id="no_unit" class="chosen-select">
                                    <option value=""></option>
                                <?php foreach ($data['units'] as $k => $v) { ?>
                                    <option data-tower_cluster="<?=$v['tower_cluster']?>" data-lantai_blok="<?=$v['lantai_blok']?>" data-type_property="<?=$v['type_property']?>" value="<?=$v['no_unit']?>"><?=$v['no_unit']?></option>
                                <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <button type="button" id="btn-tambah" class="btn btn-sm btn-primary btn-gradient dark btn-block">Tambah</button>
                            </div>
                            <div class="col-lg-1">&nbsp;</div>
                            <div class="col-lg-1">
                                <input type="text" id="input-progress" class="form-control input-sm input-numeric text-right" value="0">
                            </div>
                            <div class="col-lg-2">
                                <button type="button" id="btn-input-progress" class="btn btn-sm btn-primary btn-gradient dark btn-block">Terapkan ke semua</button>
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
                    <form action="javascript:" id="form-progress">
                        <table class="table table-bordered" id="datatable" cellspacing="0">
                            <thead>
                                <tr class="bg-primary light">
                                    <th style="background-color: #FFFFFF;width: 16%">&nbsp;</th>
                                    <th class="w150 text-center">No. Unit</th>
                                    <th class="w150">Progress Sebelum (%)</th>
                                    <th class="w150">Progress Saat ini (%)</th>
                                    <th style="background-color: #FFFFFF">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 pn">
            <div class="panel mbn">
                <div class="panel-body ">
                    <form class="form-horizontal" role="form" action="javascript:" id="form-input">
                        
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Petugas</label>
                            <div class="col-lg-4">
                                <input type="text" name="petugas" id="petugas" class="form-control input-sm">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Tanggal Progress</label>
                            <div class="col-lg-2">
                                <input type="text" name="tgl_progress" id="tgl_progress" class="form-control input-sm input-date">
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