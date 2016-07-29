<?php
    $kode_entity = $this->session->userdata('kode_entity');
?>
<!-- Begin: Content -->
<section id="content">
    <div class="row">
        <div class="col-md-12 pn">
            <div class="panel">
                <div class="row">
                    <label class="fs16 pt5">&nbsp;&nbsp;&nbsp;<b><?php echo $this->session->userdata('nama_entity');?></b></label>
                </div>

                <!-- Rencana Biaya -->
                <div class="row">
                    <div class="panel-group accordion" id="panel-rencana-biaya">
                        <div class="panel">
                            <div class="panel-heading bg-success2">
                                <a class="accordion-toggle accordion-icon" data-toggle="collapse" data-parent="#panel-rencana-biaya" href="#rencana-penjualan-biaya" style="color:#fff">RENCANA BIAYA</a>
                            </div>
                            <div id="rencana-penjualan-biaya" class="panel-collapse collapse in">
                                <div class="panel-body">    
                                    <div class="row mb20">
                                        <div class="col-lg-6">
                                            <select id="rencana-biaya" data-placeholder="Pilih Rencana Biaya" name="rencana-biaya" class="chosen-select">
                                                <option value=""></option>
                                                <?php foreach($data['list_rencana_biaya'] as $k => $v) { ?>
                                                    <option value="<?=$v['kode']?>"><?=$v['konten']?></option>
                                                <?php } ?>
                                            </select>
                                        </div>                                                
                                        <div class="col-lg-1">
                                            <label class="col-lg-1 control-label">
                                                <a href="javascript:" alt="Add row" title="Add row" class="label label-success btn-add-rencana-biaya" data-target="detil_rb" class="btn btn-xs btn-success"><span class="fa fa-plus"></span>Add</a>
                                            </label>
                                        </div>
                                    </div>  
                                    <div class="row">
                                        <div class="col-lg-7 text-center"><b>Uraian</b></div>
                                        <div class="col-lg-1 text-center"><b>Bobot</b></div>
                                        <div class="col-lg-3 text-center"><b>Biaya (Rp.)</b></div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <form class="form-horizontal" role="form" action="javascript:" id="form-rencana-biaya">
                                        <div id="detil_rb"></div>                                        
                                    </form>
                                    <div id="detil_rb_total" class="row pt10">
                                        <label class="col-lg-2 pt5"><b>TOTAL RENCANA BIAYA :</b></label><label class="col-lg-offset-4 col-lg-1 control-label pt5"><b>Rp.</b></label>
                                        <div class="col-lg-4"><input type="text" readonly data-target="laba_total_rencana_biaya" id="total_rencana_biaya" name="total_rencana_biaya" value="0.00" class="input-sm input-numeric form-control text-right" /></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Rencana Biaya -->
            
                <div class="panel-body text-right">
                    <div class="col-md-9">&nbsp;</div> 
                    <div class="col-md-2">
                        <button type="button" id="btn_submit_rik" class="btn btn-primary btn-gradient dark btn-block">Save RIK</button>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</section>
<!-- End: Content -->