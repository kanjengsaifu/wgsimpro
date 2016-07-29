<?php
$type_entity = $this->session->userdata('type_entity');
?>
<!-- Begin: Content -->
<section id="content">

    <div class="row">
        <div class="col-md-12 pn">
            <div class="panel mbn">
                <div class="panel-body">
                    <form class="form-horizontal" role="form" action="javascript:" id="form-input">
                        <input type="hidden" name="id" id="id"/>
						<div class="form-group">
                            <label class="col-lg-2 control-label">Kode Dokumen</label>
                            <div class="col-lg-2">
                                <input type="text" name="kode" id="kode" class="form-control input-sm">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Nama Dokumen</label>
                            <div class="col-lg-4">
                                <input type="text" name="konten" id="konten" class="form-control input-sm">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Prioritas</label>
                            <div class="col-lg-1">
                                <input type="text" name="no_urut" id="no_urut" class="form-control input-sm input-numeric" value="0">
                            </div>
                        </div>
                        <div class="form-group">
							<div class="col-lg-4">&nbsp;</div>
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