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
 
    <div class="col-md-12 pn">
        <div class="panel mbn">
            <div class="panel-heading">
                <ul class="nav panel-tabs-border panel-tabs panel-tabs-left">
                    <li id='tab_1'>
                        <a id="a_tab1" data-toggle="tab" href="#tab1" aria-expanded="true">Batch</a>
                    </li>
                    <li id='tab_2' class="active">
                        <a id="a_tab2" data-toggle="tab" href="#tab2" aria-expanded="false">Entry Fields</a>
                    </li>
                    <li id='tab_3'>
                        <a id="a_tab3" data-toggle="tab" href="#tab3" aria-expanded="false">+</a>
                    </li>
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content pn br-n">
                    <div id="tab1" class="tab-pane">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <!--label class="col-lg-1 control-label">Divisi&nbsp;<span class="text-danger">*</span></label-->
                                    <div class="col-lg-2">
                                        <!--input type="hidden" id="div_id" class="form-control input-sm" value="<?=(isset($data['divisi']['unit_kerja'])?$data['divisi']['unit_kerja']:'')?>"-->
                                        <div class="input-group">
                                            <span id='req_divisi'></span><span class="input-group-addon input-sm">UNIT</span>
                                            <input name="div_id" id="div_id" disabled='disabled' class="form-control input-sm text-center" type="text" placeholder="Divisi" value="<?=(isset($data['divisi']['unit_kerja'])?$data['divisi']['unit_kerja']:'')?>">
                                            
                                        </div>
                                        <!--p class="form-control-static text-muted"><?=(isset($data['divisi']['unit_kerja'])?$data['divisi']['unit_kerja']:'')?></p-->
                                    </div>
                                    <!--label class="col-lg-1 control-label">Tanggal&nbsp;<span class="text-danger">*</span></label-->
                                    <div class="col-lg-2">
                                        <!--input type="text" id="tanggal" name="tanggal" class="input-cus-8 input-jurnal-date" value="<?=date('d/m/Y')?>"-->
                                        <div id="datetimepicker2" class="input-group date">
                                            <input name="tanggal" id="tanggal" class="form-control input-sm" type="text" value="<?=date('d/m/Y')?>">
                                            <span id='req_tanggal'></span><span class="input-group-addon input-sm"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    
                                    <!--label class="col-lg-1 control-label">No. Batch&nbsp;<span class="text-danger">*</span></label-->
                                    <!--div class="col-lg-2"> 
                                        <div class="input-group">
                                            <input name="no_batch" id="no_batch" class="form-control input-sm text-left" type="hide" placeholder="Nomor Batch">
                                            <span id='req_batch'></span><span class="input-group-addon input-sm">No Batch</span>
                                        </div>
                                    </div-->
                                    <div class="col-lg-2">
                                        <input name="no_batch" id="no_batch" class="form-control input-sm text-left" type="hidden" placeholder="Nomor Batch">
                                        <?=$data['cbo_jenisjurnal'];?>
                                    </div>
                                    <!--label class="col-lg-2 control-label">No. Bukti&nbsp;<span class="text-danger">*</span></label-->
                                    <div class="col-lg-2">
                                        <!--input type="text" id="no_bukti" name="no_bukti" class="input-cus-6 input-numeric text-right" value="000000"--> 
                                        <input type="hidden" id="nomor_bukti" name="nomor_bukti" class="input-cus-6 input-numeric" value=""> 
                                        <div class="input-group">
                                            <input name="no_bukti" id="no_bukti" class="form-control input-sm text-right" type="number" placeholder="Nomor Bukti" value="000000">
                                            <span id='req_bukti'></span><span class="input-group-addon input-sm">No Bukti</span>
                                        </div>
                                    </div>
                                    <div class="control-label col-lg-2 text-left" id="l_nobuk" name="l_nobuk"></div>
                                    
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div id="tab2" class="tab-pane">
                        <div class="row">
                            <div class="col-md-12">
                                 <div class="row">
                                    <div class="col-md-8 pn">
                                        <div class="panel pn mbn">
                                            <!--div class="panel-heading">
                                                <span class="panel-title"></span>
                                            </div-->
                                            <div class="panel-body">
                                                <form class="form-horizontal" role="form">
                                                    <div class="form-group">
                                                        <!--label id='icoa' class="col-lg-1 control-label">CoA<span id='req_coa'></span></label-->
                                                        <div class="col-lg-4">
                                                            <div class="input-group">
                                                                <span id='req_coa'></span><span class="input-group-addon input-sm">COA</span>
                                                                <select id="kd_coa" name="kd_coa" class="chosen-select required">
                                                                    <option value=""></option>
                                                                <?php foreach ($data['coa'] as $k => $v) { ?>
                                                                    <option value="<?=$v['kode']?>"><?=$v['kode'].' - '.$v['nama']?></option>
                                                                <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <label id='iterbit' class="col-lg-1 control-label"><span id='req_terbit'></span></label>
                                                        <div class="col-lg-3">
                                                            <!--input type="text" name="no_terbit" id="no_terbit" class="form-control input-sm"-->
                                                            <div class="input-group">
                                                                <span class="input-group-addon input-sm">NT<span id='req_terbit'></span></span>
                                                                <input name="no_terbit" id="no_terbit" class="form-control input-sm text-left" type="text" placeholder="Nomor Terbit">
                                                                
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <!--label class="col-lg-1 control-label"><span class='text-danger' id='req_tahap'></span></label-->
                                                            <div class="col-lg-3">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon input-sm">TAHAP<span id='req_tahap'></span></span>
                                                                    <?=$data['cbo_tahap']?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <!--label id='inasabah' class="col-lg-1 control-label">Nasabah <span class='text-danger' id='req_nasabah'></span></label-->
                                                        <div class="col-lg-4">
                                                            <div class="input-group">
                                                                <span id='req_nasabah'></span><span class="input-group-addon input-sm">NASABAH</span>
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
                                                        </div>
                                                        <label class="col-lg-1 control-label"><span class='text-danger' id='req_pajak'></span></label>
                                                        <div class="col-lg-3">
                                                            <!--input type="text" name="kd_faktur" id="kd_faktur" class="form-control input-sm"-->
                                                            <div class="input-group">
                                                                <span id='req_pajak'></span><span class="input-group-addon input-sm">FP</span>
                                                                <input name="kd_faktur" id="kd_faktur" class="form-control input-sm text-left" type="text" placeholder="Faktur Pajak">
                                                                
                                                            </div>
                                                        </div>  
                                                        <!--label class="col-lg-1 control-label"><span class='text-danger' id='req_bank'></span></label-->
                                                        <div class="form-group">
                                                            <div class="col-lg-3">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon input-sm">BANK<span id='req_bank'></span></span>
                                                                    <?=$data['cbo_bank']?>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <!--label class="col-lg-1 control-label"><span class='text-danger' id='req_sbdy'></span></label-->
                                                        <div class="col-lg-4">
                                                            <div class="input-group">
                                                                    <span class="input-group-addon input-sm">SBDY<span id='req_sbdy'></span></span>
                                                                <!--<input type="text" name="kode_spk" id="kode_spk" class="form-control input-sm">-->
                                                                <select id="kd_sumberdaya" name="kd_sumberdaya" class="chosen-select col-lg-8">
                                                                    <option value=""></option>
                                                                <?php foreach ($data['sumberdaya'] as $k => $v) { ?>
                                                                    <option value="<?=$v['kode']?>"><?=$v['nama']?></option>
                                                                <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <label class="col-lg-1 control-label"></label>
                                                        <div class="col-lg-3">
                                                            <!--input type="text" name="noinvoice" id="noinvoice" class="form-control input-sm"-->
                                                            <div class="input-group">
                                                                <span class="input-group-addon input-sm">NI<span id='req_invoice'></span></span>
                                                                <input name="noinvoice" id="noinvoice" class="form-control input-sm text-left" type="text" placeholder="Nomor Invoice">
                                                                
                                                            </div>
                                                        </div>
                                                        
                                                        <!--label class="col-lg-1 control-label">Volume <span class='text-danger' id='req_vol'></span></label-->
                                                        <div class="col-lg-2">
                                                            <!--input type="text" name="volume" id="volume" class="form-control input-sm text-right" val="0"-->
                                                            <div class="input-group">
                                                                <span id='req_vol'></span><span class="input-group-addon input-sm">VOL</span>
                                                                <input name="volume" id="volume" class="form-control input-sm text-right" type="number" placeholder="Volume">
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <!--label class="col-lg-1 control-label">SPK <span id='req_spk'></span></label-->
                                                        <div class="col-lg-4">
                                                            <div class="input-group">
                                                                <span class="input-group-addon input-sm">SPK<span id='req_spk'></span></span>
                                                                <select id="kd_spk" name="kd_spk" class="chosen-select ">
                                                                    <option value=""></option>
                                                                <?php foreach ($data['spk'] as $k => $v) { ?>
                                                                    <option value="<?=$v['kode']?>"><?=$v['nama']?></option>
                                                                <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <label class="col-lg-1 control-label"></label>
                                                        <div class="col-lg-3">
                                                            <!--input type="text" name="bkt_potong" id="bkt_potong" class="form-control input-sm input-numeric" value=""-->
                                                            <div class="input-group">
                                                                <span class="input-group-addon input-sm">BP<span class='text-danger' id='req_pot'></span></span>
                                                                <input name="bkt_potong" id="bkt_potong" class="form-control input-sm text-left" type="text" placeholder="Bukti Potong">
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 pn">
                                        <div class="panel pn mbn">
                                            <!--div class="panel-heading">
                                                <span class="panel-title text-danger" >&nbsp;</span>
                                            </div-->
                                            <div class="panel-body">
                                                <!--div class="form-group">
                                                    <label id="vjDebit" class="col-lg-6 control-label">0</label>
                                                    <label id="vjKredit" class="col-lg-6 control-label">0</label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-lg-6 control-label">Debit</label>
                                                    <label class="col-lg-6 control-label">Kredit</label>
                                                </div-->
                                                <div class="form-group">
                                                    <div class="col-lg-6">
                                                        <!--input type="text" name="debit" id="debit" class="form-control input-sm input-numeric text-right" value="0"-->
                                                        <div class="input-group">
                                                            <input name="debit" id="debit" class="form-control input-sm text-right" type="number" placeholder="Debit" value="0">
                                                            <span class="input-group-addon input-sm">Debit</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <!--input type="text" name="kredit" id="kredit" class="form-control input-sm input-numeric text-right" value="0" -->
                                                        <div class="input-group">
                                                            <input name="kredit" id="kredit" class="form-control input-sm text-right" type="number" placeholder="Kredit" value="0">
                                                            <span class="input-group-addon input-sm">Kredit</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--div class="form-group">
                                                    <label class="col-lg-1 control-label">Keterangan: <span class='text-danger' id='req_ket'></span></label>
                                                    <div class="col-lg-4">
                                                    </div>
                                                </div-->
                                                <div class="form-group">
                                                    <div class="col-lg-12">
                                                        <textarea name="keterangan" id="keterangan" rows="2.5%" placeholder="Uraian/Deskripsi Jurnal" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                                 <div class="form-group">
                                                    <label class="col-lg-1 control-label">&nbsp;</label>
                                                    <div class="col-lg-4">
                                                        <button type="button" id="btn-add" name="btn-add" class="btn btn-primary btn-gradient dark btn-block">Tambah</button>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <button type="button" id="btn-submit" name="btn-submit" class="btn btn-primary btn-gradient dark btn-block" disabled="true">Simpan</button>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-lg-1 control-label">DEBIT</label>
                                                    <label class="col-lg-3 control-label text-right" id="vjDebit">0</label>
                                                    <label class="col-lg-1 control-label"></label>
                                                    <label class="col-lg-1 control-label">KREDIT</label>
                                                    <label class="col-lg-3 control-label text-right" id="vjKredit">0</label>
                                                    <label class="col-lg-1 control-label"></label>
                                                    <label class="col-lg-1 control-label btn-gradient" id="titleBalance"></label>
                                                <div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                    <!--table class="table table-striped table-bordered" id="t_header" name="t_header" cellspacing="0" width="70%">
                        <thead>
                            <tr class="bg-primary light">
                                <th width="40%" colspan="9"></th>
                                <th width="20%">DEBIT:<div id="vjDebit">0</div></th>
                                <th width="20%">KREDIT:<div id="vjKredit">0</div></th>
                                <th width="20%" colspan="2">Selisih<br><div id="titleBalance">0</div></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table-->
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
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</section>
<!--
</form>
-->
<!-- End: Content -->