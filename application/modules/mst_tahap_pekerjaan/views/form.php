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
                            <label class="col-lg-2 control-label">Kode&nbsp;<span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <input type="text" name="kode" id="kode" class="form-control input-sm required">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Nama</label>
                            <div class="col-lg-4">
                                <input type="text" name="nama" id="nama" class="form-control input-sm">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Satuan</label>
                            <div class="col-lg-4">
                                <input type="text" name="satuan" id="satuan" class="form-control input-sm">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Volume</label>
                            <div class="col-lg-4">
                                <input type="text" name="volume" id="volume" class="form-control input-sm">
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