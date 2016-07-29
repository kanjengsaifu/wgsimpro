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
                    	<!-- </div> -->
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
                                            <select id="rencana-produk" data-placeholder="Pilih Produk" name="rencana-produk" class="chosen-select">
                                                <option value=""></option>
                                                <?php foreach($data['list_produk'] as $k => $v) { ?>
                                                    <option value="<?=$v['kode']?>"><?=$v['konten']?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-1">
                                            <label class="col-lg-1 control-label">
                                                <a href="javascript:" alt="Add row" title="Add row" class="label label-success btn-add-produk" data-target="detail-rencana-produk" class="btn btn-xs btn-success"><span class="fa fa-plus"></span>Add Produk</a>
                                            </label>
                                        </div>
                                    </div>	                    		
		                    	</div>
                                <div class="row">
                                    <form class="form-horizontal" role="form" action="javascript:" id="form-input-rencana-produk">
                                        <div id="satu">
                                            <?php foreach ($data['detail_rencana_penjualan'] as $key => $value) { ?>
                                            <div class="panel-body mod-row pt5 <?php echo $value['nama_produk']?>" id="<?php echo $value['nama_produk']?>">
                                                <div class="row">
                                                    <div class="col-lg-2">
                                                        <a href="javascript:" alt="Delete row" title="Remove row" class="text-danger fs14 pt5"><span class="pt5 glyphicons glyphicons-remove pro-row" data-target="p<?php echo $value['nama_produk']?>-n<?php echo $value['nama_produk']?>">&nbsp;&nbsp;</span></a>
                                                        <label id="data-<?php echo $value['nama_produk']?>" class="control-label <?php echo $value['nama_produk']?>"><b><?php echo $value['konten']?><b></label>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label class="control-label">
                                                            <a href="javascript:" alt="Add row" title="Add row" class="label label-success btn-add-detil" data-target="detil-<?php echo $value['nama_produk']?>-<?php echo $value['konten']?>" class="btn btn-xs btn-success"><span class="fa fa-plus"></span>Add Detail</a>
                                                        </label>&nbsp;&nbsp;
                                                        <label class="control-label">
                                                            <a href="javascript:" alt="Add row" title="Add row" class="label label-success btn-add-data" data-target="detil-<?php echo $value['nama_produk']?>-<?php echo $value['konten']?>" class="btn btn-xs btn-success"><span class="fa fa-plus"></span>Add Data</a>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="row" id="detil-<?php echo $value['nama_produk']?>">
                                                    <?php foreach ($value['anak'] as $k => $v) {
                                                        if($v['type_unit'] != null){?>
                                                            <div class="row mod-row"> 
                                                                <div class="col-lg-1" align="right"> 
                                                                    <input type="text" hidden class="" id="" name="type_property_detil[]" value="<?php echo $v['type_property']?>" />
                                                                    <a href="javascript:" alt="Delete row" title="Remove row" class="text-danger fs14 pt5"><span class="glyphicons glyphicons-remove acc-row">&nbsp;&nbsp;</span></a> 
                                                                </div> 
                                                                <div class="col-lg-2"> 
                                                                    <select id="" name="type_unit_detil[]" data-placeholder="pilih tipe" class="chosen-select pt5 required"> 
                                                                        <option value=""></option> 
                                                                        <?php foreach($data['combo_detail_produk'] as $n => $nilai){?>
                                                                            <option value="<?php echo $nilai['kode']?>" <?php if($nilai['kode'] == $v['type_unit']){ echo 'selected="selected"';}?>><?php echo $nilai['konten'] ?></option> 
                                                                        <?php } ?>
                                                                    </select> 
                                                                </div> 
                                                                <div class="col-lg-1"> 
                                                                    <input type="text" class="input-sm form-control text-center input-numeric" data-v-min="0" data-m-dec="0" placeholder="Volume" id="" name="volume_detil[]" value="<?php echo $v['volume']?>" /> 
                                                                </div> 
                                                                <div class="col-lg-1"> 
                                                                    <input type="text" class="input-sm form-control text-center" placeholder="Satuan" id="" name="satuan_detil[]" value="<?php echo $v['satuan']?>" /> 
                                                                </div> 
                                                                <div class="col-lg-1"> 
                                                                    <input type="text" class="input-sm form-control text-center input-numeric" data-a-sign=" %" data-p-sign="s" data-v-min="0" data-m-dec="0" placeholder="%" id="" name="persen_detil[]" value="<?php echo $v['persentase']?>" /> 
                                                                </div> 
                                                                <label class="col-lg-1 control-label text-right">Rp.</label> 
                                                                <div class="col-lg-2"> 
                                                                    <input type="text" class="input-sm form-control text-right input-numeric required" placeholder="Harga" id="" name="harga_m2_detil[]" value="<?php echo $v['harga_m2']?>" /> 
                                                                </div> 
                                                                <div class="col-lg-2"> 
                                                                    <input type="text" class="input-sm form-control text-right input-numeric required" placeholder="Harga Unit" id="" name="harga_unit_detil[]" value="<?php echo $v['harga_unit']?>" /> 
                                                                </div> 
                                                            </div>  
                                                        <?php } else {?>
                                                            <div class="row mod-row">
                                                                <div class="col-lg-1" align="right">
                                                                    <input type="text" hidden class="" id="" name="type_property_detil[]" value="<?php echo $v['type_property']?>" />
                                                                    <input type="text" hidden class="" id="" name="type_unit_detil[]" value="" />
                                                                    <a href="javascript:" alt="Delete row" title="Remove row" class="text-danger fs14 pt5"><span class="glyphicons glyphicons-remove acc-row">&nbsp;&nbsp;</span></a>
                                                                </div>
                                                                <div class="col-lg-2">
                                                                    <input type="text" readonly class="input-sm form-control text-right" placeholder="Satuan" id="" name="" value="<?php echo $value['konten']?>" />
                                                                </div>
                                                                <div class="col-lg-1">
                                                                    <input type="text" class="input-sm form-control text-center input-numeric" placeholder="Volume" id="" name="volume_detil[]" value="<?php echo $v['volume']?>" />
                                                                </div>
                                                                <div class="col-lg-1">
                                                                    <input type="text" class="input-sm form-control text-center" placeholder="Satuan" id="" name="satuan_detil[]" value="<?php echo $v['satuan']?>" />
                                                                </div>
                                                                <div class="col-lg-1">
                                                                    <input type="text" class="input-sm form-control text-center input-numeric" placeholder="Persentase" id="" name="persen_detil[]" value="<?php echo $v['persentase']?>" />
                                                                </div>
                                                                <label class="col-lg-1 control-label text-right">Rp.</label>
                                                                <div class="col-lg-2">
                                                                    <input type="text" class="input-sm form-control text-right input-numeric required" placeholder="Harga/M2" id="" name="harga_m2_detil[]" value="<?php echo $v['harga_m2']?>" />
                                                                </div>
                                                                <div class="col-lg-2">
                                                                    <input type="text" class="input-sm form-control text-right input-numeric required" placeholder="Harga Unit" id="" name="harga_unit_detil[]" value="<?php echo $v['harga_unit']?>" />
                                                                </div>
                                                            </div>
                                                        <?php }
                                                    }?>
                                                </div>
                                            </div>
                                            <?php }?>
                                        </div>
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
                                <div class="panel-body">
                                    <form class="form-horizontal" role="form" action="javascript:" id="form-input-rencana-jual1">
                                        <div id="dua">
                                            <?php foreach ($data['detail_harga_jual'] as $key => $value) {?>
                                                <div class="row <?php echo $value['type_property']?> mod-row" id="n<?php echo $value['type_property']?>">
                                                    <div class="col-lg-4">
                                                        <input type="text" class="hidden" id="" name="type_property_harga_jual[]" value="<?php echo $value['type_property']?>" />
                                                        <label class="pt5"><b><?php echo $value['konten']?></b></label>
                                                    </div>
                                                    <label class="col-lg-offset-4 col-lg-1 pt5 control-label"><b>Rp.</b></label>
                                                    <div class="col-lg-2">
                                                        <input type="text" class="input-sm form-control input-numeric text-right required" placeholder="Nilai Jual" id="" name="harga_jual[]" value="<?php echo $value['harga_jual']?>" />
                                                    </div>
                                                </div>
                                            <?php }?>
                                        </div>
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
                                        <div id="detil_rencana_jual_1">
                                            <?php foreach ($data['detail_data_luas'] as $key => $value) { ?>
                                                <div class="row <?php echo $value['type_property']?> mod-row">  
                                                    <div class="col-lg-3">  
                                                        <input type="text" class="hidden" id="" name="type_property_luas[]" value="<?php echo $value['type_property']?>" />  
                                                        <a href="javascript:" alt="Delete row" title="Remove row" class="text-danger fs12 text-right"><span class="glyphicons glyphicons-remove acc-row pt5"></span></a>  
                                                        &nbsp;&nbsp;&nbsp;&nbsp;<label class="pt3"><b><?php echo $value['konten']?></b></label>  
                                                    </div>  
                                                    <div class="col-lg-2">  
                                                        <input type="text" class="input-sm form-control input-numeric text-right" placeholder="Gross" id="" name="volume_luas[]" value="<?php echo $value['gross']?>" />
                                                    </div>  
                                                    <div class="col-lg-1">  
                                                        <input type="text" class="input-sm form-control text-center" placeholder="Satuan" id="" name="satuan_luas[]" value="<?php echo $value['satuan_gross']?>" />  
                                                    </div>  
                                                    <div class="col-lg-2">  
                                                        <input type="text" class="input-sm form-control input-numeric text-right" placeholder="Efektif" id="" name="efektif_luas[]" value="<?php echo $value['efektif']?>" />  
                                                    </div>  
                                                    <div class="col-lg-1">  
                                                        <input type="text" class="input-sm form-control text-center" placeholder="Satuan" id="" name="satuan_efektif[]" value="<?php echo $value['satuan_efektif']?>" />
                                                    </div>  
                                                    <div class="col-lg-2">  
                                                        <input type="text" class="input-sm form-control input-numeric text-right" placeholder="Percentage" id="" name="percentage_luas[]" value="<?php echo $value['percentage']?>" />
                                                    </div>  
                                                </div> 
                                            <?php }?>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Harga Jual Netto / M2 -->

                <!-- RENCANA PENJUALAN-->
                <div class="row">
                    <div class="panel-group accordion" id="panel-rencana-penjualan">
                        <div class="panel">
                            <div class="panel-heading bg-success2">
                                <a class="accordion-toggle accordion-icon" data-toggle="collapse" data-parent="#panel-rencana-penjualan" href="#rencana-penjualan-panel" style="color:#fff">RENCANA PENJUALAN</a>
                            </div>
                            <div id="rencana-penjualan-panel" class="panel-collapse collapse in">
                               <div class="panel-body">
                                    <form class="form-horizontal" role="form" action="javascript:" id="form-rencana-penjualan">
                                        <div id="tiga">
                                            <?php foreach ($data['detail_rencana_penjualan'] as $key => $value) { ?>
                                                <div class="row mod-row" id="p<?php echo $value['nama_produk']?>">
                                                    <div class="col-lg-4">
                                                        <input type="text" class="hidden" id="" name="nama_produk_rp[]" value="<?php echo $value['nama_produk']?>" />
                                                        <label class="pt5"><b><?php echo $value['konten']?></b></label>
                                                    </div>
                                                    <div class="col-lg-offset-1 col-lg-2">
                                                        <input type="text" class="input-sm form-control input-numeric text-right" data-m-dec="0" placeholder="Volume" id="" name="volume_rp[]" value="<?php echo $value['volume']?>" />
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <input type="text" class="input-sm form-control text-center" placeholder="Satuan" id="" name="satuan_rp[]" value="<?php echo $value['satuan']?>" />
                                                    </div>
                                                    <label class="col-lg-1 pt5 control-label"><b>Rp.</b></label>
                                                    <div class="col-lg-2">
                                                        <input type="text" data-target="total_rencana_penjualan" class="penjualan input-sm form-control input-numeric text-right required" placeholder="Nilai Jual" id="" name="harga_jual_rp[]" value="<?php echo $value['harga_jual']?>" />
                                                    </div>
                                                </div>
                                            <?php }?>
                                        </div>
                                    </form>
                                    <div id="detil_rb_total" class="row pt10">
                                        <label class="col-lg-2 pt5"><b>TOTAL RENCANA PENJUALAN</b></label><label class="col-lg-offset-4 col-lg-1 control-label pt5 text-right"><b>Rp.</b></label>
                                        <div class="col-lg-4"><input type="text" readonly id="total_rencana_penjualan" name="total_rencana_penjualan" value="<?php echo $data['total_rencana_penjualan']?>" class="input-sm input-numeric form-control text-right" /></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- END RENCANA PENJUALAN -->

                <!-- RENCANA BIAYA -->
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
                                        <div id="detil_rb">
                                        	<?php foreach ($data['detail_rencana_biaya'] as $key => $value) { ?>
                                        		<div class="row <?php echo $value['kode_biaya'];?> mod-row">
													<div class="col-lg-4">
														<input type="text" class="hidden" id="" name="kode_biaya[]" value="<?php echo $value['kode_biaya'];?>" />
														<a href="javascript:" alt="Delete row" title="Remove row" class="text-danger fs12 text-right">
															<span class="glyphicons glyphicons-remove acc-row pt5 rb"></span>
														</a>
														<label class="pt3">&nbsp;&nbsp;&nbsp;<b><?php echo $value['konten'];?></b></label>
													</div>
													<div class="col-lg-2">
														<input type="text" class="input-sm form-control input-numeric text-right" placeholder="Volume" id="" name="volume_rb[]" value="<?php echo $value['volume'];?>" />
													</div>
													<div class="col-lg-1">
														<input type="text" class="input-sm form-control text-center" placeholder="Satuan" id="" name="satuan_rb[]" value="<?php echo $value['satuan'];?>" />
													</div>
													<div class="col-lg-1">
														<input type="text" class="input-sm form-control input-numeric" placeholder="Bobot" id="" name="bobot_rb[]" value="" />
													</div>
													<label class="col-lg-1 pt5 control-label"><b>Rp.</b></label>
													<div class="col-lg-2">
														<input type="text" data-target="total_rencana_biaya" class="rencana input-sm form-control input-numeric text-right required" placeholder="Nilai Biaya" id="" name="biaya_rb[]" value="<?php echo $value['biaya'];?>" />
													</div>
												</div>
                                        	<?php }?>
                                        </div>                                        
                                    </form>
                                    <div id="detil_rb_total" class="row pt10">
                                        <label class="col-lg-2 pt5"><b>TOTAL RENCANA BIAYA :</b></label><label class="col-lg-offset-4 col-lg-1 control-label pt5"><b>Rp.</b></label>
                                        <div class="col-lg-4"><input type="text" readonly data-target="laba_total_rencana_biaya" id="total_rencana_biaya" name="total_rencana_biaya" value="<?php echo $data['total_rencana_biaya'];?>" class="input-sm input-numeric form-control text-right" /></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- END RENCANA BIAYA -->

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
                                            <?php foreach ($data['detail_rencana_laba'] as $key => $value) {?>                                            
                                            
                                            <div class="row">
                                                <label class="col-lg-2 pt5"><b>TOTAL RENCANA PENJUALAN</b></label><label class="col-lg-offset-4 col-lg-1 control-label"><b>Rp.</b></label>
                                                <div class="col-lg-3"><input type="text" readonly id="laba_total_rencana_penjualan" name="laba_total_rencana_penjualan" value="<?php echo $value['rencana_penjualan'];?>" class="input-sm input-numeric form-control text-right" /></div>
                                            </div>
                                            <div class="row">
                                                <label class="col-lg-2 pt5"><b>TOTAL RENCANA BIAYA</b></label><label class="col-lg-offset-4 col-lg-1 control-label"><b>Rp.</b></label>
                                                <div class="col-lg-3">
                                                    <input type="text" readonly id="laba_total_rencana_biaya" name="laba_total_rencana_biaya" value="<?php echo $value['rencana_biaya'];?>" class="input-sm input-numeric form-control text-right" />                                                    
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-lg-10 pt5" style="border-bottom:solid 1px #999" /></label>
                                            </div>
                                            <div class="row">
                                                <label class="col-lg-2 pt5"><b>sub - TOTAL RENCANA LABA</b></label><label class="col-lg-offset-4 col-lg-1 control-label"><b>Rp.</b></label>
                                                <div class="col-lg-3"><input type="text" readonly id="laba_sub_total" name="laba_sub_total" data-v-min="-999999999.99" value="<?php echo $value['sub_total'];?>" class="input-sm input-numeric form-control text-right" /></div>
                                            </div>
                                            <div class="row">
                                                <label class="col-lg-2 pt5"><b>PPH FINAL</b></label><label class="col-lg-offset-4 col-lg-1 control-label"><b>Rp.</b></label>
                                                <div class="col-lg-3"><input type="text" id="laba_pph_final" name="laba_pph_final" value="<?php echo $value['pph_final'];?>" class="input-sm input-numeric form-control text-right" /></div>
                                            </div>
                                            <div class="row">
                                                <label class="col-lg-10 pt5" style="border-bottom:solid 1px #999" /></label>
                                            </div>
                                            <div id="rencana_laba_total" class="row">
                                                <label class="col-lg-2 pt5"><b>TOTAL RENCANA LABA</b></label><label class="col-lg-offset-4 col-lg-1 control-label"><b>Rp.</b></label>
                                                <div class="col-lg-3"><input type="text" readonly id="laba_total_rencana" name="laba_total_rencana" value="<?php echo $value['grand_total'];?>" class="input-sm input-numeric form-control text-right" /></div>
                                            </div>
                                            <?php } ?>
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
                                            <?php foreach ($data['detail_profit_sharing'] as $key => $value) { ?>
                                                <div class="row">
                                                    <label class="col-lg-2 pt5"><b>PT. WIKA REALTY</b></label><label class="col-lg-offset-4 col-lg-1 control-label"><b>Rp.</b></label>
                                                    <div class="col-lg-3">
                                                        <input type="text" id="sharing_total_wika" name="sharing_total_wika" value="<?php echo $value['to_wika'] ?>" class="input-sm input-numeric form-control text-right" />
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <input type="text" id="sharing_persen_wika" placeholder="%" data-a-sign=" %" data-p-sign="s" data-v-min="0" data-m-dec="1" name="sharing_persen_wika" value="<?php echo $value['persen_wika'] ?>" class="input-sm input-numeric form-control text-right" />
                                                    </div>
                                                </div>
                                                <div id="" class="row">
                                                    <label class="col-lg-2 pt5"><b>PEMILIK LAHAN</b></label><label class="col-lg-offset-4 col-lg-1 control-label"><b>Rp.</b></label>
                                                    <div class="col-lg-3">
                                                        <input type="text" id="sharing_total_pemilik" name="sharing_total_pemilik" value="<?php echo $value['to_pemilik'] ?>" class="input-sm input-numeric form-control text-right" />
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <input type="text" id="sharing_persen_pemilik" placeholder="%"  data-a-sign=" %" data-p-sign="s" data-v-min="0" data-m-dec="1" name="sharing_persen_pemilik" value="<?php echo $value['persen_pemilik'] ?>" class="input-sm input-numeric form-control text-right" />
                                                    </div>
                                                </div>
                                            <?php }?>
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
                                            <?php foreach($data['detail_nilai_tanah'] as $key => $value) {?>
                                                <div class="row">
                                                    <label class="col-lg-2 pt5"><b>Nilai Tanah</b></label><label class="col-lg-offset-4 col-lg-1 control-label"><b>Rp.</b></label>
                                                    <div class="col-lg-3">
                                                        <input type="text" id="tanah_total_nilai" name="tanah_total_nilai" value="<?php echo $value['nilai_tanah'] ?>" class="input-sm input-numeric form-control text-right" />
                                                    </div>
                                                </div>
                                                <div id="" class="row">
                                                    <label class="col-lg-2 pt5"><b>Profit Sharing Pemilik Lahan</b></label><label class="col-lg-offset-4 col-lg-1 control-label"><b>Rp.</b></label>
                                                    <div class="col-lg-3">
                                                        <input type="text" id="tanah_pemilik_lahan" name="tanah_pemilik_lahan" value="<?php echo $value['profit_sharing'] ?>" class="input-sm input-numeric form-control text-right" />
                                                    </div>
                                                </div>
                                                <div id="" class="row">
                                                    <label class="col-lg-offset-6 col-lg-1 control-label"><b>Rp.</b></label>
                                                    <div class="col-lg-3">
                                                        <input type="text" id="kolom_satu" name="kolom_satu" value="<?php echo $value['kolom_satu'] ?>" class="input-sm input-numeric form-control text-right" />
                                                    </div>
                                                </div>
                                                <div id="" class="row">
                                                    <label class="col-lg-offset-6 col-lg-1 control-label"><b>@&nbsp;&nbsp;&nbsp;Rp.</b></label>
                                                    <div class="col-lg-3">
                                                        <input type="text" id="kolom_dua" name="kolom_dua" value="<?php echo $value['kolom_dua'] ?>" class="input-sm input-numeric form-control text-right" />
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <label class="pt5" style="vertical-align: middle;"><b>/M2</b></label>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </form>      
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Nilai Tanah Total -->
            </div>
            <div class="panel-body text-right">
                <div class="col-md-9">&nbsp;</div> 
                <div class="col-md-2">
                    <button type="button" id="btn_submit_rik" class="btn btn-primary btn-gradient dark btn-block">Save RIK</button>
                </div>
            </div>
        </div>
    </div>    
</section>
<!-- End: Content -->