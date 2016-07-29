<?php
    $kode_entity = $this->session->userdata('kode_entity');
?>
<!-- Begin: Content -->
<section id="content">
    <div class="row">
        <div class="col-md-12 pn">
            <div class="panel">
                <div class="row">
                    <label class="fs16 pt5">&nbsp;&nbsp;&nbsp;<b><?php echo "NAMA ENTITY";?></b></label>
                </div>

                <!-- Data Lahan dan Proyek -->
                <div class="row">
                    <div class="panel-group accordion" id="panel-data-lahan">
                    	<div class="panel">
                    		<div class="panel-heading bg-success2">
		                        <a class="accordion-toggle accordion-icon" data-toggle="collapse" data-parent="#panel-data-lahan" href="#data-lahan" style="color:#fff">Data Lahan & Proyek</a>
		                    </div>
		                    <div id="data-lahan" class="panel-collapse collapse in">
		                    	<div class="panel-body">
		                    		<form class="form-horizontal" role="form" action="javascript:" id="form-input-master-rik">
                                        <div id="" class="row">
                                            <label class="col-lg-3 pt5"><b>LUAS LAHAN</b></label>
                                            <div class="col-lg-1">
                                                <input type="text" class="input-sm form-control text-center input-numeric" data-v-min="0" data-m-dec="0" placeholder="Luas" id="master_luas_lahan" name="master_luas_lahan" value="0" />
                                            </div>
                                            <label class="col-lg-1 pt5"><b>M2</b></label>
                                        </div>
                                        <div class="row">
                                            <label class="col-lg-offset-2 col-lg-1 text-right"><b>REGULASI</b></label>
                                            <label class="col-lg-offset-4 col-lg-1 text-right"><b>PERENCANAAN</b></label>
                                        </div>
                                        <div class="row">
                                            <label class="col-lg-offset-2 col-lg-1 text-right pt5"><b>KDB</b></label>
                                            <div class="col-lg-1">
                                                <input type="text" class="input-sm form-control text-center input-numeric" data-v-min="0" data-m-dec="0" placeholder="Luas" id="master_luas_lahan" name="master_luas_lahan" value="0" />
                                            </div>
                                            <label class="col-lg-offset-3 col-lg-1 text-right pt5"><b>KDB</b></label>
                                            <div class="col-lg-1">
                                                <input type="text" class="input-sm form-control text-center input-numeric" data-v-min="0" data-m-dec="0" placeholder="Luas" id="master_luas_lahan" name="master_luas_lahan" value="0" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-lg-offset-2 col-lg-1 text-right pt5"><b>KLB</b></label>
                                            <div class="col-lg-1">
                                                <input type="text" class="input-sm form-control text-center input-numeric" data-v-min="0" data-m-dec="0" placeholder="Luas" id="master_luas_lahan" name="master_luas_lahan" value="0" />
                                            </div>
                                            <label class="col-lg-offset-3 col-lg-1 text-right pt5"><b>KLB</b></label>
                                            <div class="col-lg-1">
                                                <input type="text" class="input-sm form-control text-center input-numeric" data-v-min="0" data-m-dec="0" placeholder="Luas" id="master_luas_lahan" name="master_luas_lahan" value="0" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-lg-offset-1 col-lg-2 text-right pt5"><b>TINGGI BANGUNAN</b></label>
                                            <div class="col-lg-1">
                                                <input type="text" class="input-sm form-control text-center input-numeric" data-v-min="0" data-m-dec="0" placeholder="Luas" id="master_luas_lahan" name="master_luas_lahan" value="0" />
                                            </div>
                                            <label class="col-lg-1 pt5"><b>Lantai</b></label>
                                            <label class="col-lg-offset-1 col-lg-2 text-right pt5"><b>TINGGI BANGUNAN</b></label>
                                            <div class="col-lg-1">
                                                <input type="text" class="input-sm form-control text-center input-numeric" data-v-min="0" data-m-dec="0" placeholder="Luas" id="master_luas_lahan" name="master_luas_lahan" value="0" />
                                            </div>
                                            <label class="col-lg-1 pt5"><b>Lantai</b></label>
                                        </div>
                                    </form>
		                    	</div>
		                    </div>
                    	</div>
                    </div>
                </div>
                <!-- End Data Lahan dan Proyek -->

                <!-- Rencana Produk -->
                <div class="row">
                    <div class="panel-group accordion" id="panel-rencana-produk">
                    	<div class="panel">
                    		<div class="panel-heading bg-success2">
		                        <a class="accordion-toggle accordion-icon" data-toggle="collapse" data-parent="#panel-rencana-produk" href="#rencana-produk-panel" style="color:#fff">RENCANA PRODUK</a>
		                    </div>
		                    <div id="rencana-produk-panel" class="panel-collapse collapse in">
		                    	<div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <select id="rencana-produk" data-placeholder="Pilih Produk" name="rencana-produk" class="chosen-select required">
                                                <option value=""></option>
                                                <?php foreach($data['list_produk'] as $k => $v) { ?>
                                                    <option value="<?=$v['kode']?>"><?=$v['konten']?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-1">
                                            <label class="col-lg-1 control-label">
                                                <a href="javascript:" alt="Add row" title="Add row" class="label label-success btn-add-produk" data-target="satu-dua" data-target-etc="detil_rencana_penjualan" class="btn btn-xs btn-success"><span class="fa fa-plus"></span>Add Produk</a>
                                            </label>
                                        </div>
                                    </div>	                    		
		                    	</div>
                                <div class="row">
                                    <form class="form-horizontal" role="form" action="javascript:" id="form-input-rencana-produk">
                                        <div id="satu" class=""></div>
                                    </form>
                                </div>
		                    </div>
                    	</div>
                    </div>
                </div>
                <!-- End Rencana Produk -->

                <!-- Harga Jual Netto / M2 -->
                <div class="row">
                    <div class="panel-group accordion" id="panel-harga-jual">
                        <div class="panel">
                            <div class="panel-heading bg-success2">
                                <a class="accordion-toggle accordion-icon" data-toggle="collapse" data-parent="#panel-harga-jual" href="#harga-jual" style="color:#fff">HARGA JUAL NETTO / M2</a>
                            </div>
                            <div id="harga-jual" class="panel-collapse collapse in">
                                <!-- <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <select id="select_harga_jual" data-placeholder="Pilih Produk" name="select_harga_jual" class="chosen-select">
                                                <option value=""></option>
                                                <?php foreach($data['list_produk'] as $k => $v) { ?>
                                                    <option value="<?=$v['kode']?>"><?=$v['konten']?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-1">
                                            <label class="col-lg-1 control-label">
                                                <a href="javascript:" alt="Add row" title="Add row" class="label label-success btn-add-harga-jual" data-target="detil_rencana_jual" class="btn btn-xs btn-success"><span class="fa fa-plus"></span>Add</a>
                                            </label>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="panel-body">
                                    <form class="form-horizontal" role="form" action="javascript:" id="form-input-rencana-jual1">
                                        <div id="dua"></div>
                                    </form>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <label class="col-lg-2"><b>USIA PROYEK : </b></label></br>
                                    </div>
                                        <div class="row"><div class="col-lg-3">
                                            <select id="select_harga_netto" data-placeholder="Pilih Produk Harga Jual Netto" name="select_harge_netto" class="chosen-select">
                                                <option value=""></option>
                                                <?php foreach($data['list_harga_jual_netto'] as $k => $v) { ?>
                                                    <option value="<?=$v['kode']?>"><?=$v['konten']?></option>
                                                <?php } ?>
                                            </select></div>
                                            <div class="col-lg-1">
                                            <label class="col-lg-1 control-label">
                                                <a href="javascript:" alt="Add row" title="Add row" class="label label-success btn-add-harga-jual-netto" data-target="detil_rencana_jual_1" class="btn btn-xs btn-success"><span class="fa fa-plus"></span>Add</a>
                                            </label>
                                        </div>
                                        </div>
                                </div>
                                <div class="panel-body">
                                    <form class="form-horizontal" role="form" action="javascript:" id="form-input-rencana-jual2">
                                        <div id="detil_rencana_jual_1"></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Harga Jual Netto / M2 -->

                <!-- Rencana Penjualan-->
                <div class="row">
                    <div class="panel-group accordion" id="panel-rencana-penjualan">
                        <div class="panel">
                            <div class="panel-heading bg-success2">
                                <a class="accordion-toggle accordion-icon" data-toggle="collapse" data-parent="#panel-rencana-penjualan" href="#rencana-penjualan-panel" style="color:#fff">RENCANA PENJUALAN</a>
                            </div>
                            <div id="rencana-penjualan-panel" class="panel-collapse collapse in">
                                <!-- <div class="panel-body">  
                                    <div class="row">
                                        <div class="col-lg-1">
                                            <label class="col-lg-1 control-label">
                                                <a href="javascript:" alt="Add row" title="Add row" class="label label-success btn-add-rencana-penjualan" data-target="detil_rencana_penjualan" class="btn btn-xs btn-success"><span class="fa fa-plus"></span>Add</a>
                                            </label>
                                        </div>
                                    </div>           
                                </div> -->
                                <div class="panel-body">
                                    <form class="form-horizontal" role="form" action="javascript:" id="form-rencana-penjualan">
                                        <!-- <div id="detil_rencana_penjualan"></div> -->
                                        <div id="tiga"></div>
                                    </form>
                                <!-- </div>
                                <div class="panel-body"> -->
                                    <div id="detil_rb_total" class="row pt10">
                                        <label class="col-lg-2 pt5"><b>TOTAL RENCANA PENJUALAN</b></label><label class="col-lg-offset-4 col-lg-1 control-label pt5 text-right"><b>Rp.</b></label>
                                        <div class="col-lg-4"><input type="text" readonly id="total_rencana_penjualan" name="total_rencana_penjualan" value="0.00" class="input-sm input-numeric form-control text-right" /></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Rencana Penjualan -->

                <!-- Rencana Biaya -->
                <div class="row">
                    <div class="panel-group accordion" id="panel-rencana-biaya">
                        <div class="panel">
                            <div class="panel-heading bg-success2">
                                <a class="accordion-toggle accordion-icon" data-toggle="collapse" data-parent="#panel-rencana-biaya" href="#rencana-penjualan-biaya" style="color:#fff">RENCANA BIAYA</a>
                            </div>
                            <div id="rencana-penjualan-biaya" class="panel-collapse collapse in">
                                <div class="panel-body">    
                                    <div class="row">
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

                <!-- Rencana Laba -->
                <div class="row">
                    <div class="panel-group accordion" id="panel-rencana-laba">
                        <div class="panel">
                            <div class="panel-heading bg-success2">
                                <a class="accordion-toggle accordion-icon" data-toggle="collapse" data-parent="#panel-rencana-laba" href="#rencana-laba-panel" style="color:#fff">RENCANA LABA</a>
                            </div>
                            <div id="rencana-laba-panel" class="panel-collapse collapse in">
                                <div class="panel-body">
                                     <form class="form-horizontal" role="form" action="javascript:" id="form-rencana-laba">
                                        <div id="detil_rencana_penjualan">
                                            <div class="row">
                                                <label class="col-lg-2 pt5"><b>TOTAL RENCANA PENJUALAN</b></label><label class="col-lg-offset-4 col-lg-1 control-label"><b>Rp.</b></label>
                                                <div class="col-lg-3"><input type="text" readonly id="laba_total_rencana_penjualan" name="laba_total_rencana_penjualan" value="0.00" class="input-sm input-numeric form-control text-right" /></div>
                                            </div>
                                            <div class="row">
                                                <label class="col-lg-2 pt5"><b>TOTAL RENCANA BIAYA</b></label><label class="col-lg-offset-4 col-lg-1 control-label"><b>Rp.</b></label>
                                                <div class="col-lg-3">
                                                    <input type="text" readonly id="laba_total_rencana_biaya" name="laba_total_rencana_biaya" value="0.00" class="input-sm input-numeric form-control text-right" />                                                    
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-lg-10 pt5" style="border-bottom:solid 1px #999" /></label>
                                            </div>
                                            <div class="row">
                                                <label class="col-lg-2 pt5"><b>sub - TOTAL RENCANA LABA</b></label><label class="col-lg-offset-4 col-lg-1 control-label"><b>Rp.</b></label>
                                                <div class="col-lg-3"><input type="text" readonly id="laba_sub_total" name="laba_sub_total" data-v-min="-999999999.99" value="0.00" class="input-sm input-numeric form-control text-right" /></div>
                                            </div>
                                            <div class="row">
                                                <label class="col-lg-2 pt5"><b>PPH FINAL</b></label><label class="col-lg-offset-4 col-lg-1 control-label"><b>Rp.</b></label>
                                                <div class="col-lg-3"><input type="text" id="laba_pph_final" name="laba_pph_final" value="" class="input-sm input-numeric form-control text-right" /></div>
                                            </div>
                                            <div class="row">
                                                <label class="col-lg-10 pt5" style="border-bottom:solid 1px #999" /></label>
                                            </div>
                                        <!-- </div> -->
                                            <div id="rencana_laba_total" class="row">
                                                <label class="col-lg-2 pt5"><b>TOTAL RENCANA LABA</b></label><label class="col-lg-offset-4 col-lg-1 control-label"><b>Rp.</b></label>
                                                <div class="col-lg-3"><input type="text" readonly id="laba_total_rencana" name="laba_total_rencana" value="0.00" class="input-sm input-numeric form-control text-right" /></div>
                                            </div>
                                        </div>
                                    </form>          
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Rencana Laba -->

                <!-- Profit Sharing -->
                <div class="row">
                    <div class="panel-group accordion" id="panel-profit-sharing">
                        <div class="panel">
                            <div class="panel-heading bg-success2">
                                <a class="accordion-toggle accordion-icon" data-toggle="collapse" data-parent="#panel-profit-sharing" href="#profit-sharing-panel" style="color:#fff">PROFIT SHARING</a>
                            </div>
                            <div id="profit-sharing-panel" class="panel-collapse collapse in">
                                <div class="panel-body">
                                    <form class="form-horizontal" role="form" action="javascript:" id="form-profit-sharing">
                                        <div id="" class="form-group">
                                            <div class="row">
                                                <label class="col-lg-2 pt5"><b>PT. WIKA REALTY</b></label><label class="col-lg-offset-4 col-lg-1 control-label"><b>Rp.</b></label>
                                                <div class="col-lg-3">
                                                    <input type="text" id="sharing_total_wika" name="sharing_total_wika" value="" class="input-sm input-numeric form-control text-right" />
                                                </div>
                                                <div class="col-lg-1">
                                                    <input type="text" id="sharing_persen_wika" name="sharing_persen_wika" placeholder="%" data-a-sign=" %" data-p-sign="s" data-v-min="0" data-m-dec="1" name="sharing_persen_wika" value="" class="input-sm input-numeric form-control text-right" />
                                                </div>
                                            </div>
                                            <div id="" class="row">
                                                <label class="col-lg-2 pt5"><b>PEMILIK LAHAN</b></label><label class="col-lg-offset-4 col-lg-1 control-label"><b>Rp.</b></label>
                                                <div class="col-lg-3">
                                                    <input type="text" id="sharing_total_pemilik" name="sharing_total_pemilik" value="" class="input-sm input-numeric form-control text-right" />
                                                </div>
                                                <div class="col-lg-1">
                                                    <input type="text" id="sharing_persen_pemilik" name="sharing_persen_pemilik" placeholder="%"  data-a-sign=" %" data-p-sign="s" data-v-min="0" data-m-dec="1" name="sharing_persen_pemilik" value="" class="input-sm input-numeric form-control text-right" />
                                                </div>
                                            </div>
                                        </div>
                                    </form>          
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Profit Sharing -->

                <!-- Nilai Tanah Total -->
                <div class="row">
                    <div class="panel-group accordion" id="panel-nilai-tanah">
                        <div class="panel">
                            <div class="panel-heading bg-success2">
                                <a class="accordion-toggle accordion-icon" data-toggle="collapse" data-parent="#panel-nilai-tanah" href="#rencana_nilai_tanah" style="color:#fff">NILAI TANAH TOTAL</a>
                            </div>
                            <div id="rencana_nilai_tanah" class="panel-collapse collapse in">
                                <div class="panel-body">      
                                    <form class="form-horizontal" role="form" action="javascript:" id="form-nilai-tanah">
                                        <div id="" class="form-group">
                                            <div class="row">
                                                <label class="col-lg-2 pt5"><b>Nilai Tanah</b></label><label class="col-lg-offset-4 col-lg-1 control-label"><b>Rp.</b></label>
                                                <div class="col-lg-3">
                                                    <input type="text" id="tanah_total_nilai" name="tanah_total_nilai" value="0.00" class="input-sm input-numeric form-control text-right" />
                                                </div>
                                            </div>
                                            <div id="" class="row">
                                                <label class="col-lg-2 pt5"><b>Profit Sharing Pemilik Lahan</b></label><label class="col-lg-offset-4 col-lg-1 control-label"><b>Rp.</b></label>
                                                <div class="col-lg-3">
                                                    <input type="text" id="tanah_pemilik_lahan" name="tanah_pemilik_lahan" value="0.00" class="input-sm input-numeric form-control text-right" />
                                                </div>
                                            </div>
                                            <div id="" class="row">
                                                <label class="col-lg-offset-6 col-lg-1 control-label"><b>Rp.</b></label>
                                                <div class="col-lg-3">
                                                    <input type="text" id="kolom_satu" name="kolom_satu" value="0.00" class="input-sm input-numeric form-control text-right" />
                                                </div>
                                            </div>
                                            <div id="" class="row">
                                                <label class="col-lg-offset-6 col-lg-1 control-label"><b>@&nbsp;&nbsp;&nbsp;Rp.</b></label>
                                                <div class="col-lg-3">
                                                    <input type="text" id="kolom_dua" name="kolom_dua" value="0.00" class="input-sm input-numeric form-control text-right" />
                                                </div>
                                                <div class="col-lg-1">
                                                    <label class="pt5" style="vertical-align: middle;"><b>/M2</b></label>
                                                </div>
                                            </div>
                                        </div>
                                    </form>      
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Nilai Tanah Total -->
            
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