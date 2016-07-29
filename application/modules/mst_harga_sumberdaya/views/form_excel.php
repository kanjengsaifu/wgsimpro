<?php
	$kode_entity = $this->session->userdata('kode_entity');
?>

<!-- Begin: Content -->
<section id="content">

    <div class="row">
        <div class="col-md-12 pn">
            <div class="panel">
                <div class="panel-body">
                	<form class="form-horizontal" method="post" action="<?=base_url()?>index.php/harga-sumberdaya-excel/save" id="form-ui" enctype="multipart/form-data">
                		<input type="hidden" name="id" id="id"/>
                		<input type="hidden" name="kode_entity" id="kode_entity" value="<?php echo $kode_entity;?>"/>
						 
                        <div class="form-group">
                            <label class="col-lg-2 control-label">File Excel</label>
                            <div class="col-lg-4">
                                <input type="file" name="f_excel" id="f_excel" class="form-control input-sm">
                            </div>
                        </div>
						<div class="form-group">
                            <label class="col-lg-2 control-label">Format File Excel</label>
                            <div class="col-lg-4">
                                <a href="<?=base_url()?>assets/download/harga_sumberdaya_format.xls"><button type="button" class="btn btn-success btn-gradient dark btn-block">Download</button></a>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-10 control-label">&nbsp;</label>
                            <div class="col-lg-2">
                                <button type="submit" id="btn-submit" class="btn btn-primary btn-gradient dark btn-block">Submit</button>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-12" style="border-bottom: 1px solid #e0e0e0">&nbsp;</div>
                        </div>
                	</form> 

                </div>
            </div>
        </div>
    </div>

</section>
<!-- End: Content -->