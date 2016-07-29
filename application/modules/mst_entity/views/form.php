<!-- Begin: Content -->
<section id="content">

    <div class="row">
        <div class="col-md-12 pn">
            <div class="panel">
                <div class="panel-body">
                    <form class="form-horizontal" role="form" action="javascript:" id="form-input">

                        <input type="hidden" name="id" id="id"/>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Kode</label>
                            <div class="col-lg-4">
                                <input type="text" name="kode" id="kode" class="form-control input-sm">
                            </div>
                            <label class="col-lg-2 control-label">Nama</label>
                            <div class="col-lg-4">
                                <input type="text" name="nama" id="nama" class="form-control input-sm">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Jenis</label>
                            <div class="col-lg-4">
                                <select id="jenis" name="jenis" class="chosen-select">
                                    <option value=""></option>
                                <?php foreach ($data['jenis'] as $k => $v) { ?>
                                    <option value="<?=$v['kode']?>"><?=$v['konten']?></option>
                                <?php } ?>
                                </select>
                            </div>
                            <label class="col-lg-2 control-label">Tipe</label>
                            <div class="col-lg-4">
                                <select id="type_entity" name="type_entity" class="chosen-select">
                                    <option value=""></option>
                                <?php foreach ($data['type_entity'] as $k => $v) { ?>
                                    <option value="<?=$v['kode']?>"><?=$v['konten']?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Alamat</label>
                            <div class="col-lg-4">
                                <textarea name="alamat" id="alamat" class="form-control input-sm" row="3"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Tanggal Mulai</label>
                            <div class="col-lg-2">
                                <input type="text" name="tgl_mulai" id="tgl_mulai" class="form-control input-sm input-date">
                            </div>
                            <label class="col-lg-2 control-label">&nbsp;</label>
                            <label class="col-lg-2 control-label">Tanggal Selesai</label>
                            <div class="col-lg-2">
                                <input type="text" name="tgl_selesai" id="tgl_selesai" class="form-control input-sm input-date">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Nilai RIK</label>
                            <div class="col-lg-2">
                                <input type="text" name="nilai_developer" id="nilai_developer" class="form-control input-sm input-numeric text-right" value="0.00">
                            </div>
                            <label class="col-lg-2 control-label">&nbsp;</label>
                            <label class="col-lg-2 control-label">Nilai Tidak Kena Pajak</label>
                            <div class="col-lg-2">
                                <input type="text" name="nilai_no_tax" id="nilai_no_tax" class="form-control input-sm input-numeric text-right" value="0.00">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Pemilik</label>
                            <div class="col-lg-4">
                                <input type="text" name="pemilik" id="pemilik" class="form-control input-sm">
                            </div>
                            <label class="col-lg-2 control-label">No. Rekening</label>
                            <div class="col-lg-4">
                                <input type="text" name="norek_entity" id="norek_entity" class="form-control input-sm">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Status</label>
                            <div class="col-lg-4">
                                <select id="status_entity" name="status_entity" class="chosen-select">
                                    <option value=""></option>
                                <?php foreach ($data['status_entity'] as $k => $v) { ?>
                                    <option value="<?=$v['kode']?>"><?=$v['konten']?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Manajer Proyek</label>
                            <div class="col-lg-4">
                                <input type="text" name="mgr_proyek" id="mgr_proyek" class="form-control input-sm">
                            </div>
                            <label class="col-lg-2 control-label">Kasie. Operasi</label>
                            <div class="col-lg-4">
                                <input type="text" name="kasie_operasi" id="kasie_operasi" class="form-control input-sm">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Kasie. Keuangan</label>
                            <div class="col-lg-4">
                                <input type="text" name="kasie_keu" id="kasie_keu" class="form-control input-sm">
                            </div>
                            <label class="col-lg-2 control-label">Kasie. Komersial</label>
                            <div class="col-lg-4">
                                <input type="text" name="kasie_kom" id="kasie_kom" class="form-control input-sm">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Direktorat</label>
                            <div class="col-lg-4">
                                <select id="direktorat" name="direktorat" class="chosen-select">
                                    <option value=""></option>
                                <?php foreach ($data['direktorat'] as $k => $v) { ?>
                                    <option value="<?=$v['kode']?>"><?=$v['konten']?></option>
                                <?php } ?>
                                </select>
                            </div>
                            <label class="col-lg-2 control-label">Departemen</label>
                            <div class="col-lg-4">
                                <select id="departemen" name="departemen" class="chosen-select">
                                    <option value=""></option>
                                <?php foreach ($data['departemen'] as $k => $v) { ?>
                                    <option value="<?=$v['kode']?>"><?=$v['konten']?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Unit Kerja</label>
                            <div class="col-lg-4">
                                <select id="unit_kerja" name="unit_kerja" class="chosen-select">
                                    <option value=""></option>
                                <?php foreach ($data['unit_kerja'] as $k => $v) { ?>
                                    <option value="<?=$v['kode']?>"><?=$v['konten']?></option>
                                <?php } ?>
                                </select>
                            </div>
                            <label class="col-lg-2 control-label">SBU</label>
                            <div class="col-lg-4">
                                <select id="sbu" name="sbu" class="chosen-select">
                                    <option value=""></option>
                                <?php foreach ($data['sbu'] as $k => $v) { ?>
                                    <option value="<?=$v['kode']?>"><?=$v['konten']?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Alamat Kantor Pemasaran</label>
                            <div class="col-lg-4">
                                <textarea name="alamat_marketing" id="alamat_marketing" class="form-control input-sm" row="3"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Kota Kantor Pemasaran</label>
                            <div class="col-lg-4">
                                <input type="text" name="kota_marketing" id="kota_marketing" class="form-control input-sm">
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