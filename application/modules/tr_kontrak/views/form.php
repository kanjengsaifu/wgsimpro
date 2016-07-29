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
                            <label class="col-lg-2 control-label">Tanggal Tanda Tangan&nbsp;<span class="text-danger">*</span></label>
                            <div class="col-lg-2">
                                <input type="text" name="tanggal_sign" id="tanggal_sign" class="form-control input-sm input-date required">
                            </div>
                            <label class="col-lg-2 control-label">Tanggal Mulai&nbsp;<span class="text-danger">*</span></label>
                            <div class="col-lg-2">
                                <input type="text" name="tanggal_mulai" id="tanggal_mulai" class="form-control input-sm input-date required">
                            </div>
                            <label class="col-lg-1 control-label">Tanggal Akhir&nbsp;<span class="text-danger">*</span></label>
                            <div class="col-lg-2">
                                <input type="text" name="tanggal_akhir" id="tanggal_akhir" class="form-control input-sm input-date required">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Nomor Kontrak&nbsp;<span class="text-danger">*</span></label>
                            <div class="col-lg-2">
                                <input type="text" name="no_kontrak" id="no_kontrak" class="form-control input-sm required">
                            </div>
                            <label class="col-lg-2 control-label">Jenis Kontrak&nbsp;<span class="text-danger">*</span></label>
                            <div class="col-lg-2">
                                <select id="jenis_kontrak" name="jenis_kontrak" class="chosen-select required">
                                    <option value=""></option>
                                    <option value="SUBKON">SUBKON / JASA</option>
                                    <option value="KONTRAKTOR">KONTRAKTOR / MATERIAL</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Nilai Kontrak&nbsp;<span class="text-danger">*</span></label>
                            <div class="col-lg-2">
                                <input type="text" name="nilai_kontrak" id="nilai_kontrak" nk="" class="form-control input-sm input-numeric text-right required" value="0">
                            </div>
                            <label class="col-lg-2 control-label">Rekanan&nbsp;<span class="text-danger">*</span></label>
                            <div class="col-lg-2">
                                <select id="kode_rekanan" name="kode_rekanan" class="chosen-select required" placeholder="Pilih Nama Rekanan">
                                    <option value=""></option>
                                    <?php foreach($data['rekanans'] as $k => $v) { ?>
                                        <option value="<?=$v['kode_rekanan']?>"><?=$v['nama']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Jenis Termin Progress<span class="text-danger">*</span></label>
                            <div class="col-lg-2">
                                <select id="jenis_termin" name="jenis_termin" class="chosen-select required">
                                    <option value=""></option>
                                    <option value="P">% - Prosentase</option>
                                    <option value="N">Rp - Nilai Nominal Kontrak</option>
                                </select>
                            </div>

                            <label class="col-lg-2 control-label">Retensi&nbsp;<span class="text-danger">*</span></label>
                            <div class="col-lg-1">
                                <input type="text" name="retensi" id="retensi" class="form-control input-sm required">
                            </div>
                            <div class="col-lg-1">
                                <div id="rp_retensi"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Jumlah Termin &nbsp;<span class="text-danger">*</span></label>
                            <div class="col-lg-1">
                                <input type="text" name="jumlah_termin" id="jumlah_termin" class="form-control input-sm required">
                            </div>
                            <label class="col-lg-3 control-label">Jenis Retensi<span class="text-danger">*</span></label>
                            <div class="col-lg-2">
                                <select id="jenis_retensi" name="jenis_retensi" class="chosen-select required">
                                    <option value=""></option>
                                    <option value="P">Progresive</option>
                                    <option value="A">Akhir Tagihan</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                        </div>
                        <!-- TABEL -->
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12-pn">
                                    <div class="panel">
                                        <div class="panel-body">
                                            <table class="table table-striped table-bordered table-hover" id="datatable" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th colspan="5"> DATA TERMIN</th>
                                                    </tr>
                                                    <tr class="bg-primary light bg-gradient">
                                                        <th rowspan="2" class="text-center">Termin ke</th>
                                                        <th rowspan="2" class="text-center">Nilai Termin (Rp)</th>
                                                        <th colspan="2" class="text-center">Progress</th>
                                                        <th rowspan="2" class="text-center">&nbsp;</th>
                                                    </tr>
                                                    <tr class="bg-primary light">
                                                        <th class="text-center">Pekerjaan</th>
                                                        <th class="text-center">Penagihan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                                <tfoot>
                                                    <tr class="bg-primary light bg">
                                                        <td class="text-right">Total</td>
                                                        <td class="text-right"><div id="t_total_rp"></div></td>
                                                        <td class="text-center"><div id="pr_pk"></div>%</td>
                                                        <td class="text-center"><div id="pr_tg"></div>%</td>
                                                        <td></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
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