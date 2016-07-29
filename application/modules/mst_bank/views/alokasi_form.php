<!-- Begin: Content -->
<section id="content">

    <div class="row">
        <div class="col-md-12 pn">
            <div class="panel mbn">
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover" id="datatable" cellspacing="0" width="100%">
                        <thead>
                            <tr class="bg-primary light bg-gradient">
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>No. Rekening</th>
                                <th>Entity</th>
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

                        <input type="button" class="row-view hidden" id="xkode" data-kode=""/>
                        <input type="hidden" name="kode_bank" id="kode_bank"/>
                        <input type="hidden" name="id" id="id"/>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Kode / Nama Bank</label>
                            <div class="col-lg-4">
                                <div id="pkode_nama"></div>
                            </div> 
                        </div>
                        <div class="form-group">
                             <label class="col-lg-2 control-label">Entity</label>
                            <div class="col-lg-4">
                                <select id="kode_entity" name="kode_entity" class="chosen-select" style="width:100%">
                                    <?php foreach($data['entity'] as $e) { ?>
					<option value="<?=$e['kode']?>"><?=$e['nama']?></option>
				<?php } ?>
                                </select>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">No. Rekening</label>
                            <div class="col-lg-4">
                                <div id="pno_rekening"></div>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Persentase Pencairan</label>
                            <div class="col-lg-2">
                                <input type="text" name="persentase" id="persentase" class="form-control input-sm input-numeric text-right" value="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Keterangan</label>
                            <div class="col-lg-4">
                                <input type="text" name="keterangan" id="keterangan" class="form-control input-sm">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Indikator Pencairan</label>
                            <div class="col-lg-4">
                                <select id="indikator" class="chosen-select">
                                    <option value=""></option>
                                    <option value="tgl_akad_kredit">Tgl. Akad Kredit</option>
                                    <option value="progress">Progress Pembangunan</option>
                                    <option value="perijinan">Perijinan</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group hidden" id="div_tglakad">
                            <label class="col-lg-2 control-label">Tanggal Akad</label>
                            <div class="col-lg-2">
                                <input type="text" name="tgl_akad_kredit" id="tgl_akad_kredit" value="0" class="form-control input-sm">
                            </div>
                        </div>
                        <div class="form-group hidden" id="div_progres">
                            <label class="col-lg-2 control-label">Progress</label>
                            <div class="col-lg-2">
                                <input type="text" name="progress" id="progress" value="0" class="form-control input-sm input-numeric text-right">
                            </div>
                        </div>
                        <div class="form-group hidden" id="div_ijin">
                            <label class="col-lg-2 control-label">Perijinan</label>
                            <div class="col-lg-3">
                                <select id="kd_perijinan" name="perijinan" class="chosen-select">
                                    <option value="0"></option>
                                    <?php
                                        foreach($data['dokumen'] as $k => $v) {
                                    ?>
                                        <option value="<?=$v['kode']?>"><?=$v['konten']?></option>
                                    <?php } ?>
                                </select>
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
                                <th>Keterangan</th>
                                <th>Indikator</th>
                                <th>&nbsp;</th>
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
