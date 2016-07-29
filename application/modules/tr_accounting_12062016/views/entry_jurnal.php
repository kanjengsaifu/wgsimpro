<!-- Begin: Content -->
<style>
.input-cus-4 {height: 25px; width:40px; font-size:x-small; line-height: 90%;}
.input-cus-6 {height: 25px; width:60px; font-size:x-small; line-height: 90%;}
.input-cus-8 {height: 25px; width:80px; font-size:x-small; line-height: 90%;}
.input-cus-9 {height: 25px; width:90px; font-size:x-small; line-height: 90%;}
.input-cus-10 {height: 25px; width:100px; font-size:x-small; line-height: 90%;}
</style>
<form class="form-horizontal" role="form" action="javascript:" id="form-input" method="post">
<section id="content">
	<div class="row">
        <div class="col-md-12 pn">
            <div class="panel mbn">
                <div class="panel-body">
                	
                        <div class="form-group">
                            <label class="col-lg-1 control-label">Divisi&nbsp;<span class="text-danger">*</span></label>
                            <div class="col-xs-1">
                                <input type="hidden" id="div_id" class="form-control input-sm" value="<?=(isset($data['divisi']['unit_kerja'])?$data['divisi']['unit_kerja']:'')?>">
                                <p class="form-control-static text-muted"><?=(isset($data['divisi']['unit_kerja'])?$data['divisi']['unit_kerja']:'')?></p>
                            </div>
                            <label class="col-lg-1 control-label">Tanggal&nbsp;<span class="text-danger">*</span></label>
                            <div class="col-lg-1">
                                <input type="text" id="tanggal" name="tanggal" class="input-cus-8 input-jurnal-date" value="<?=date('d/m/Y')?>">
                            </div>
                        </div>
                        <div class="form-group">
                            
                            <label class="col-lg-1 control-label">No. Batch&nbsp;<span class="text-danger">*</span></label>
                            <div class="col-lg-1">
                                <input type="text" id="no_batch" name="no_batch" class="input-cus-6 input-numeric text-right" value="000">
                            </div>
                            <label class="col-lg-1 control-label">Jenis</label>
                            <div class="col-lg-3">
                                <select id="kd_jenis" name="kd_jenis" class="chosen-select input-cus-10">
                                    <option value=""></option>
                                    <option value="B">B - Bukti Bank</option>
                                    <option value="M">M - Memorial</option>
                                    <option value="K">K - Bukti Kas</option>
                                </select>
                            </div>
                            <label class="col-lg-4 control-label">No. Bukti&nbsp;<span class="text-danger">*</span></label>
                            <div class="col-lg-1">
                                <input type="text" id="no_bukti" name="no_bukti" class="input-cus-6 input-numeric text-right" value="000000"> 
                                <input type="hidden" id="nomor_bukti" name="nomor_bukti" class="input-cus-6 input-numeric text-right" value=""> 
                            </div>
                            <div class="col-lg-1">
                                <div class="control-label" id="l_nobuk" name="l_nobuk"></div>
                            </div>
                        </div>
                	
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 pn">
            <div class="panel mbn">
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover" id="datatable" name="datatable" cellspacing="0" width="100%">
                        <thead>
                            <tr class="bg-primary light bg-gradient">
                                <th>CoA</th>
                                <th>Nasabah</th>
                                <th>Sumberdaya</th>
                                <th>SPK</th>
                                <th>Tahap</th>
                                <th>Bank</th>
                                <th>No. Terbit</th>
                                <th>Kode Faktur</th>
                                <th>No. Invoice</th>
                                <th>Bukti Potong</th>
                                <th>Debet</th>
                                <th>Kredit</th>
                                <th>Volume</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- BARU -->
    <div class="row">
        <div class="col-md-9 pn">
            <div class="panel">
                <div class="panel-heading">
                    <span class="panel-title"></span>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label id='icoa' class="col-lg-1 control-label">Kode Akun <span id='req_coa'></span></label>
                            <div class="col-lg-4">
                                <select id="kd_coa" name="kd_coa" class="chosen-select required">
                                    <option value=""></option>
                                <?php foreach ($data['coa'] as $k => $v) { ?>
                                    <option value="<?=$v['kode']?>"><?=$v['kode'].' - '.$v['nama']?></option>
                                <?php } ?>
                                </select>
                            </div>
                            <label id='iterbit' class="col-lg-3 control-label">No.Terbit <span id='req_terbit'></span></label>
                            <div class="col-lg-2">
                                <input type="text" name="no_terbit" id="no_terbit" class="form-control input-sm">
                            </div>
                            
                        </div>
                        <div class="form-group">
                            <label id='inasabah' class="col-lg-1 control-label">Nasabah <span class='text-danger' id='req_nasabah'></span></label>
                            <div class="col-lg-4">
                                <!--<input type="text" name="kd_nasabah" id="kode_nasabah" class="form-control input-sm">-->
                                <select id="kd_nasabah" name="kd_nasabah" class="chosen-select ">
                                    <option value=""></option>
                                <?php foreach ($data['nasabah'] as $k => $v) { ?>
                                    <option value="<?=$v['kode']?>"><?=$v['nama']?></option>
                                <?php } ?>
                                </select>
                                <input type="hidden" name="id" id="id"/>
                                <input type="hidden" name="saldo_awal" id="saldo_awal"/>
                                <input type="hidden" name="dk_saldo_awal" id="dk_saldo_awal"/>
                            </div>
                            <label class="col-lg-3 control-label">Faktu Pajak <span class='text-danger' id='req_pajak'></span></label>
                            <div class="col-lg-3">
                                <input type="text" name="kd_faktur" id="kd_faktur" class="form-control input-sm">
                            </div>

                            
                        </div>
                        <div class="form-group">
                            <label class="col-lg-1 control-label">Sumberdaya <span class='text-danger' id='req_sbdy'></span></label>
                            <div class="col-lg-4">
                                <!--<input type="text" name="kode_spk" id="kode_spk" class="form-control input-sm">-->
                                <select id="kd_sumberdaya" name="kd_sumberdaya" class="chosen-select ">
                                    <option value=""></option>
                                <?php foreach ($data['sumberdaya'] as $k => $v) { ?>
                                    <option value="<?=$v['kode']?>"><?=$v['nama']?></option>
                                <?php } ?>
                                </select>
                            </div>
                            <label class="col-lg-3 control-label">No. Invoice <span class='text-danger' id='req_invoice'></span></label>
                            <div class="col-lg-2">
                                <input type="text" name="noinvoice" id="noinvoice" class="form-control input-sm">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-1 control-label">SPK <span id='req_spk'></span></label>
                            <div class="col-lg-4">
                                <select id="kd_spk" name="kd_spk" class="chosen-select ">
                                    <option value=""></option>
                                <?php foreach ($data['spk'] as $k => $v) { ?>
                                    <option value="<?=$v['kode']?>"><?=$v['nama']?></option>
                                <?php } ?>
                                </select>
                            </div>
                            <label class="col-lg-3 control-label">Bukti Potong <span class='text-danger' id='req_pot'></span></label>
                            <div class="col-lg-3">
                                <input type="text" name="bkt_potong" id="bkt_potong" class="form-control input-sm input-numeric" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-1 control-label">Tahap <span class='text-danger' id='req_tahap'></span></label>
                            <div class="col-lg-6">
                                <select id="kd_tahap" name="kd_tahap" class="chosen-select ">
                                    <option value=""></option>
                                <?php foreach ($data['tahap'] as $k => $v) { ?>
                                    <option value="<?=$v['kode']?>"><?=$v['nama']?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-1 control-label">Bank <span class='text-danger' id='req_bank'></span></label>
                            <div class="col-lg-6">
                                <select id="kd_bank" name="kd_bank" class="chosen-select ">
                                    <option value=""></option>
                                <?php foreach ($data['bank'] as $k => $v) { ?>
                                    <option value="<?=$v['kode']?>"><?=$v['nama']?></option>
                                <?php } ?>
                                </select>
                            </div>
                            <label class="col-lg-1 control-label">Volume <span class='text-danger' id='req_vol'></span></label>
                            <div class="col-lg-1">
                                <input type="text" name="volume" id="volume" class="form-control input-sm text-right" val="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-1 control-label"> </label>
                            <div class="col-lg-6">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-3 pn">
            <div class="panel">
                <div class="panel-heading">
                    <span class="panel-title text-danger" id="titleBalance">&nbsp;</span>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label id="vjDebit" class="col-lg-6 control-label">0</label>
                        <label id="vjKredit" class="col-lg-6 control-label">0</label>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-6 control-label">Debit</label>
                        <label class="col-lg-6 control-label">Kredit</label>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-6">
                            <input type="text" name="debit" id="debit" class="form-control input-sm input-numeric text-right" value="0">
                        </div>
                        
                        <div class="col-lg-6">
                            <input type="text" name="kredit" id="kredit" class="form-control input-sm input-numeric text-right" value="0">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Keterangan: <span class='text-danger' id='req_ket'></span></label>
                        <div class="col-lg-4">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-12">
                            <textarea name="keterangan" id="keterangan" class="form-control"></textarea>
                        </div>
                    </div>
                     <div class="form-group">
                        <label class="col-lg-2 control-label">&nbsp;</label>
                        <div class="col-lg-4">
                            <button type="button" id="btn-add" name="btn-add" class="btn btn-primary btn-gradient dark btn-block">Tambah</button>
                        </div>
                        <div class="col-lg-4">
                            <button type="button" id="btn-submit" name="btn-submit" class="btn btn-primary btn-gradient dark btn-block" disabled="true">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</form>
<!-- End: Content -->