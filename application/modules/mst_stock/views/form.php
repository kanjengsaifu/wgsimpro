<?php
$type_entity = $this->session->userdata('type_entity');
?>
<!-- Begin: Content -->
<section id="content">

    <div class="row">
        <div class="col-md-12 pn">
            <div class="panel">
                <div class="panel-body">
                    <form class="form-horizontal" role="form" action="javascript:" id="form-input">

                        <input type="hidden" name="id" id="id"/>
                        <input type="hidden" name="kode_entity" id="kode_entity" value="<?=$this->session->userdata('kode_entity')?>"/>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">No. Unit</label>
                            <div class="col-lg-4">
                                <input type="text" name="no_unit" id="no_unit" class="form-control input-sm">
                            </div>
                            <div class="col-lg-2 checkbox-custom square checkbox-success">
                                    <input id="ckis_hold-1" type="checkbox" value="1" name="ishold">
                                    <label for="ckis_hold-1"> HOLD ?</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Nomor VA <span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <input type="text" name="no_va" id="no_va" class="form-control input-sm required">
                            </div> 
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Type Property <span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <select id="type_property" name="type_property" class="chosen-select required">
                                    <option value=""></option>
                                <?php foreach ($data['type_property'] as $k => $v) { ?>
                                    <option value="<?=$v['kode']?>"><?=$v['konten']?></option>
                                <?php } ?>
                                </select>
                            </div>
                            <label class="col-lg-2 control-label">Unit Type <span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <select id="type_unit" name="type_unit" class="chosen-select required">
                                    <option value=""></option>
                                <?php foreach ($data['type_unit'] as $k => $v) { ?>
                                    <option value="<?=$v['kode']?>"><?=$v['konten']?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label"><?=$type_entity==='HR'?'Tower':'Cluster'?> <span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <select id="tower_cluster" name="tower_cluster" class="chosen-select required">
                                    <option value=""></option>
                                <?php foreach ($data['tower_cluster'] as $k => $v) { ?>
                                    <option value="<?=$v['kode']?>"><?=$v['konten']?></option>
                                <?php } ?>
                                </select>
                            </div>
                            <label class="col-lg-2 control-label"><?=$type_entity==='HR'?'Lantai':'Blok'?> <span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <select id="lantai_blok" name="lantai_blok" class="chosen-select required">
                                    <option value=""></option>
                                <?php foreach ($data['lantai_blok'] as $k => $v) { ?>
                                    <option value="<?=$v['kode']?>"><?=$v['konten']?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">View <span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <select id="direction" name="direction" class="chosen-select required">
                                    <option value=""></option>
                                <?php foreach ($data['direction'] as $k => $v) { ?>
                                    <option value="<?=$v['kode']?>"><?=$v['konten']?></option>
                                <?php } ?>
                                </select>
                            </div>
                            <label class="col-lg-2 control-label">Arah Mata Angin <span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <select id="mata_angin" name="mata_angin" class="chosen-select required">
                                    <option value=""></option>
                                <?php foreach ($data['mata_angin'] as $k => $v) { ?>
                                    <option value="<?=$v['kode']?>"><?=$v['konten']?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                            <?php if($type_entity==='HR') { ?>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Zona <span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <select id="zone" name="zone" class="chosen-select required">
                                    <option value=""></option>
                                <?php foreach ($data['zone'] as $k => $v) { ?>
                                    <option value="<?=$v['kode']?>"><?=$v['konten']?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                            <?php } ?>
                        <?php if($type_entity==='LD') { ?>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Kavling <span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <select id="kavling" name="kavling" class="chosen-select required">
                                    <option value=""></option>
                                <?php foreach ($data['kavling'] as $k => $v) { ?>
                                    <option value="<?=$v['kode']?>"><?=$v['konten']?></option>
                                <?php } ?>
                                </select>
                            </div>
                            <label class="col-lg-2 control-label">Jenis Kavling <span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <select id="type_kavling" name="type_kavling" class="chosen-select required">
                                    <option value=""></option>
                                <?php foreach ($data['type_kavling'] as $k => $v) { ?>
                                    <option value="<?=$v['kode']?>"><?=$v['konten']?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Sales Status <span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <select id="status_sales" name="status_sales" class="chosen-select required">
                                    <option value=""></option>
                                <?php foreach ($data['status_sales'] as $k => $v) { ?>
                                    <option value="<?=$v['kode']?>"><?=$v['konten']?></option>
                                <?php } ?>
                                </select>
                            </div>
                            <label class="col-lg-2 control-label">Mort. Status <span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <select id="status_mort" name="status_mort" class="chosen-select required">
                                    <option value=""></option>
                                <?php foreach ($data['status_mort'] as $k => $v) { ?>
                                    <option value="<?=$v['kode']?>"><?=$v['konten']?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Panjang Tanah</label>
                            <div class="col-lg-2">
                                <input type="text" name="land_len" id="land_len" class="form-control input-sm input-numeric text-right" value="0.00">
                            </div>
                            <label class="col-lg-2 control-label">&nbsp;</label>
                            <label class="col-lg-2 control-label">Lebar Tanah</label>
                            <div class="col-lg-2">
                                <input type="text" name="land_wid" id="land_wid" class="form-control input-sm input-numeric text-right" value="0.00">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label"><?=$type_entity==='HR'?'Luas Netto':'Luas Bangunan'?></label>
                            <div class="col-lg-2">
                                <input type="text" name="wide_netto" id="wide_netto" class="form-control input-sm input-numeric text-right" value="0.00">
                            </div>
                            <label class="col-lg-2 control-label">&nbsp;</label>
                            <label class="col-lg-2 control-label"><?=$type_entity==='HR'?'Luas Semi Gross':'Luas Tanah'?></label>
                            <div class="col-lg-1">
                                <input type="text" name="wide_gross" id="wide_gross" class="form-control input-sm input-numeric text-right" value="0.00">
                            </div>
                            <label class="col-lg-1 control-label">Berdasarkan</label>
                            <div class="col-lg-2">
                                <select id="dasar_ltanah" name="dasar_ltanah" class="chosen-select required">
                                    <option value="0"></option>
                                    <option value="spl">Site Plan</option>
                                    <option value="tko">Stake Out</option>
                                    <option value="bpn">BPN</option>
                                </select>
                            </div>
                        </div>
                        <!--div class="form-group">
                            <label class="col-lg-2 control-label"><?=$type_entity==='HR'?'Luas Netto (2)':'Luas Bangunan (2)'?></label>
                            <div class="col-lg-2">
                                <input type="text" name="wide_netto_2" id="wide_netto_2" class="form-control input-sm input-numeric text-right" value="0.00">
                            </div>
                            <label class="col-lg-2 control-label">&nbsp;</label>
                            <label class="col-lg-2 control-label"><?=$type_entity==='HR'?'Luas Semi Gross (2)':'Luas Tanah (2)'?></label>
                            <div class="col-lg-2">
                                <input type="text" name="wide_gross_2" id="wide_gross_2" class="form-control input-sm input-numeric text-right" value="0.00">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label"><?=$type_entity==='HR'?'Luas Netto (3)':'Luas Bangunan (3)'?></label>
                            <div class="col-lg-2">
                                <input type="text" name="wide_netto_3" id="wide_netto_3" class="form-control input-sm input-numeric text-right" value="0.00">
                            </div>
                            <label class="col-lg-2 control-label">&nbsp;</label>
                            <label class="col-lg-2 control-label"><?=$type_entity==='HR'?'Luas Semi Gross (3)':'Luas Tanah (3)'?></label>
                            <div class="col-lg-2">
                                <input type="text" name="wide_gross_3" id="wide_gross_3" class="form-control input-sm input-numeric text-right" value="0.00">
                            </div>
                        </div-->
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Deskripsi</label>
                            <div class="col-lg-4">
                                <textarea name="deskripsi" id="deskripsi" class="form-control input-sm" row="3"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Alamat</label>
                            <div class="col-lg-4">
                                <textarea name="alamat" id="alamat" class="form-control input-sm" row="3"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Kota</label>
                            <div class="col-lg-4">
                                <input type="text" name="kota" id="kota" class="form-control input-sm">
                            </div>
                            <label class="col-lg-2 control-label">Kodepos</label>
                            <div class="col-lg-2">
                                <input type="text" name="kodepos" id="kodepos" class="form-control input-sm">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Keterangan</label>
                            <div class="col-lg-4">
                                <textarea name="keterangan" id="keterangan" class="form-control input-sm" row="3"></textarea>
                            </div>
                            <label class="col-lg-2 control-label">Remarks</label>
                            <div class="col-lg-4">
                                <textarea name="remarks" id="remarks" class="form-control input-sm" row="3"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Recog. Date</label>
                            <div class="col-lg-2">
                                <input type="text" name="recog_date" id="recog_date" class="form-control input-sm input-date">
                            </div>
                            <label class="col-lg-2 control-label">&nbsp;</label>
                            <label class="col-lg-2 control-label">Extra Area</label>
                            <div class="col-lg-2">
                                <input type="text" name="extra_area" id="extra_area" class="form-control input-sm input-numeric text-right" value="0.00">
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