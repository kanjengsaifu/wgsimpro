<?php
$type_entity = $this->session->userdata('type_entity');
?>
<!-- Begin: Content -->
<section id="content">

    <div class="row">
        <div class="col-md-12 pn">
            <div class="panel mbn">
                <div class="panel-body mbn">
                	<table class="table table-striped table-bordered table-hover" id="datatable-unit" cellspacing="0" width="100%">
                        <thead>
                            <tr class="bg-primary light bg-gradient">
                                <th>No. Unit</th>
                                <th>Property Type</th>
                                <th>Unit Type</th>
								<th>HPP</th>
								<th>Realisasi</th>
								<th>Progress</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 pn">
            <div class="panel mbn">
                <div class="panel-body">
                    <form class="form-horizontal" role="form" action="javascript:" id="form-input">
                    	<div class="form-group mn">
							<label class="col-lg-2 control-label">Total HPP</label>
							<div class="col-lg-2">
								<p class="form-control-static text-right"><?=isset($data['hpp'])?number_format($data['hpp'],2):'0.00'?></p>
							</div>
						</div>
						<div class="form-group mn">
							<label class="col-lg-2 control-label">Total Realisasi</label>
							<div class="col-lg-2">
								<p class="form-control-static text-right"><?=isset($data['ri'])?number_format($data['ri'],2):'0.00'?></p>
							</div>
						</div>
						<div class="form-group mn">
							<label class="col-lg-2 control-label">Total Progress</label>
							<div class="col-lg-2">
								<p class="form-control-static text-right"><?=number_format((isset($data['ri'])?number_format($data['ri'],2):0)/(isset($data['hpp'])?number_format($data['hpp'],2):0)*100,2)?> %</p>
							</div>
						</div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</section>
<!-- End: Content -->