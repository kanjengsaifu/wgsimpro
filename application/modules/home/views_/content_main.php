<!-- Begin: Content -->
<section id="content">
	<div class="row">
        <div class="col-md-12 pn">
            <div class="panel mbn">
                <div class="panel-body">
                    <form class="form-horizontal" role="form" action="javascript:" id="form-input">

                    	<div class="form-group">
							<label class="col-lg-2 control-label pt5">Kawasan / Entity</label>
							<div class="col-lg-6">
								<select name="kode" id="kode" class="chosen-select sel-entities">
									<option value=""></option>
									<?php foreach($data['entities'] as $k => $v) { ?>
									<option value="<?=$v['id']?>"><?=$v['nama']?></option>
									<?php } ?>
								</select>
							</div>
							<div class="col-lg-2">
								<button type="button" id="btn-set" class="btn btn-sm btn-primary btn-gradient dark btn-block">Submit</button>
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
							<label class="col-lg-2 control-label">Nama Kawasan / Entity</label>
							<div class="col-lg-2">
								<p class="form-control-static text-muted" id="pnama"></p>
							</div> 
							<label class="col-lg-2 control-label">Jenis Pekerjaan</label>
							<div class="col-lg-2">
								<p class="form-control-static text-muted" id="pjenis"></p>
							</div>
						</div>
						<div class="form-group mbn">
							<label class="col-lg-2 control-label">Tanggal Mulai</label>
							<div class="col-lg-2">
								<p class="form-control-static text-muted" id="ptgl_mulai"></p>
							</div> 
							<label class="col-lg-2 control-label">Tanggal Selesai</label>
							<div class="col-lg-2">
								<p class="form-control-static text-muted" id="ptgl_selesai"></p>
							</div>
						</div>
						<div class="form-group mbn">
							<label class="col-lg-2 control-label">Tipe Entity</label>
							<div class="col-lg-2">
								<p class="form-control-static text-muted" id="ptipe_entity"></p>
							</div> 
							<label class="col-lg-2 control-label">Nilai RIK</label>
							<div class="col-lg-2">
								<p class="form-control-static text-muted" id="pnilai_developer">0.00</p>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- End: Content -->