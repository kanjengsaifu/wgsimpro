<!-- Begin: Content -->
<section id="content">
	<div class="row">
		<div class="col-md-12 pn">
			<div class="panel mbn">
				<div class="panel-body">
					<form class="form-horizontal" role="form" action="javascript:" id="form-payment">
						<div class="form-group">
							<label class="col-lg-2 control-label">Periode Laporan Penerimaan</label>
							<div class="col-lg-2">
								<input type="text" id="from" class="form-control input-sm" value="<?=date('d/m/Y')?>">
							</div>
							<label class="col-lg-1 control-label">s.d</label>
							<div class="col-lg-2">
								<input type="text" id="to" class="form-control input-sm" value="<?=date('d/m/Y')?>">
							</div>
							<div class="col-lg-2">
								<button type="button" id="btn-submit" class="btn btn-primary btn-gradient dark btn-block">Process</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>