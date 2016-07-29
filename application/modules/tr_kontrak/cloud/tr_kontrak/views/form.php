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
                            <label class="col-lg-2 control-label">Tanggal&nbsp;<span class="text-danger">*</span></label>
                            <div class="col-lg-2">
                                <input type="text" name="tanggal" id="tanggal" class="form-control input-sm input-date required">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Jenis Kontrak&nbsp;<span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <select id="jenis_kontrak" name="jenis_kontrak" class="chosen-select required">
                                    <option value=""></option>
                                    <option value="SUBKON">SUBKON / JASA</option>
                                    <option value="KONTRAKTOR">KONTRAKTOR / MATERIAL</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Kode SPK&nbsp;<span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <input type="text" name="kode_spk" id="kode_spk" class="form-control input-sm required">
                            </div>
                        </div>
                        <!-- Rekanan -->
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Rekanan&nbsp;<span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <select id="kode_rekanan" name="kode_rekanan" class="chosen-select required">
                                    <option value=""></option>
                                    <?php foreach($data['list_rekanan'] as $k => $v) { ?>
                                        <option value="<?=$v['kode_rekanan']?>"><?=$v['nama']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div><!-- End Rekanan -->                        
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Volume&nbsp;<span class="text-danger">*</span></label>
                            <div class="col-lg-2">
                                <input type="text" name="volume" id="volume" class="form-control input-sm input-numeric text-right required" value="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Rupiah&nbsp;<span class="text-danger">*</span></label>
                            <div class="col-lg-2">
                                <input type="text" name="rp" id="rp" class="form-control input-sm input-numeric text-right required" value="0">
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