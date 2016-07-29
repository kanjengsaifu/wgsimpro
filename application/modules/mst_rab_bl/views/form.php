<?php
    /*get kode_entity from session */
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
                            <label class="col-lg-2 control-label">Kode Tahap&nbsp;<span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <?php //<input type="text" name="kode_tahap" id="kode_tahap" class="form-control input-sm required"> ?>
								<select id="kode_tahap" name="kode_tahap" class="chosen-select">
									<option value=""></option>
								<?php foreach($data['list_tahap'] as $k => $v) { ?>
									<option value="<?=$v['kode']?>"><?=$v['nama']?></option>
								<?php } ?>
								</select>
                            </div>
                        </div>
                		<div class="form-group">
                            <label class="col-lg-2 control-label">Kode Sumberdaya&nbsp;<span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <?php //<input type="text" name="kode_sbdaya" id="kode_sbdaya" class="form-control input-sm required">?>
								
								<select id="kode_sumberdaya" name="kode_sumberdaya" class="chosen-select">
									<option value=""></option>
								<?php foreach($data['list_sumberdaya'] as $k => $v) { ?>
									<option value="<?=$v['kode']?>"><?=$v['nama']?></option>
								<?php } ?>
								</select>
                            </div>
                        </div> 
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Volume Ra</label>
                            <div class="col-lg-4">
                                <input type="text" name="volume" id="volume" class="form-control input-sm">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Volume Rev</label>
                            <div class="col-lg-4">
                                <input type="text" name="volume_rev" id="volume_rev" class="form-control input-sm">
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