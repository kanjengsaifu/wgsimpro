<!-- Begin: Content -->
<section id="content">
	<div class="row">
        <div class="col-md-12 pn">
            <div class="panel mbn">
                <div class="panel-body">
                    <form class="form-horizontal" role="form" action="javascript:" id="form-input">

                    	<div class="form-group">
							<label class="col-lg-2 control-label pt5">Departemen</label>
							<div class="col-lg-6">
								<!--select name="kode" id="kode" class="chosen-select sel-entities">
									<option value=""></option>
									<?php foreach($data['entities'] as $k => $v) { ?>
									<option value="<?=$v['id']?>"><?=$v['nama']?></option>
									<?php } ?>
								</select-->
								<?php 
									$this->load->helper('combo');
									echo combo_divisi('kode','','pilih','chosen-select sel-entities');
								?>
							</div>
							<div class="col-lg-2">
								<button type="button" id="btn-set" class="btn btn-sm btn-primary btn-gradient dark btn-block">Pilih</button>
							</div>
						</div>

                     </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
		<div class="col-md-12 pn">
			<div class="panel mbn">
				<div class="panel-body">
					<form class="form-horizontal" role="form" action="javascript:" id="form-info-entity">
						<div class="form-group mbn">
							<label class="col-lg-2 control-label">Nama Departemen</label>
							<div class="col-lg-2">
								<p class="form-control-static text-muted" id="pnama"></p>
							</div> 
							<label class="col-lg-2 control-label">Unit Kerja</label>
							<div class="col-lg-2">
								<p class="form-control-static text-muted" id="punit"></p>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- End: Content -->