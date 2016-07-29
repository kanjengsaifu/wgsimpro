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
							<label class="col-lg-2 control-label">Nama Sumberdaya</label>
							<div class="col-lg-4">
								<select id="kode_sumberdaya" name="kode_sumberdaya" class="chosen-select">
									<option value=""></option>
								<?php foreach($data['list_sumberdaya'] as $k => $v) { ?>
									<option value="<?=$v['kode']?>"><?=$v['nama']?></option>
								<?php } ?>
								</select>
							</div>
						</div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Harga Satuan</label>
                            <div class="col-lg-4">
                                <input type="text" name="harga_satuan" id="harga_satuan" class="form-control input-sm input-numeric text-right" value="0.00">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Harga Rolling</label>
                            <div class="col-lg-4">
                                <input type="text" name="harga_satuan_review" id="harga_satuan_review" class="form-control input-sm input-numeric text-right" value="0.00">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-10 control-label">&nbsp;</label>
                            <div class="col-lg-2">
                                <button type="button" id="btn-submit" class="btn btn-primary btn-gradient dark btn-block">Submit</button>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-12" style="border-bottom: 1px solid #e0e0e0">&nbsp;</div>
                        </div>
                	</form>

                	<table class="table table-striped table-bordered table-hover" id="datatable" cellspacing="0" width="100%">
                        <thead>
                            <tr class="bg-primary light bg-gradient">
                                <th>Nama Sumberdaya</th>
                                <th>Harga Satuan</th>
                                <th>Harga Rolling</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

</section>
<!-- End: Content -->