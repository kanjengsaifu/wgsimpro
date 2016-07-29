<style type="text/css">
.garbaw100 {
    border-bottom: 1px dashed #999;
    width: 100%;
}
</style>
<!-- Begin: Content -->
<section id="content">
    <div class="row">
		<div class="col-md-12 pn">
			<div class="panel mbn">
				<div class="panel-body" id="pnlbody">
					<form class="form-horizontal" role="form" action="javascript:" id="form-payment">
						<input type="button" class="row-data hidden" id="xresno" data-resno=""/>
						
						<div class="form-group mbn">
							<div class="col-lg-6">
								<p class="form-control-static pbn"><b>1. Data Nasabah Unidentified</b></p>
							</div>
						</div>
						<div class="form-group mbn pl15">
							<div class="col-lg-2">
								<p class="form-control-static pbn"><b>- Nama Bank Penerima</b></p>
							</div>
							<div class="col-lg-4">
								<select id="kode" name="kode" class="chosen-select">
									<option value=""></option>
                                <?php foreach ($data['bank'] as $k => $v) { ?>
                                    <option value="<?=$v['kode']?>"><?=$v['nama']?> [ <?=$v['no_rekening'] ?> ]</option>
                                <?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group mbn pl15">
							<div class="col-lg-2">
								<p class="form-control-static pbn"><b>- Jumlah diterima</b></p>
							</div>
							<div class="col-lg-4">
								<input type="text" name="rp" id="rp" class="form-control input-sm input-numeric text-right">
							</div>
						</div>
						<div class="form-group mbn pl15">
							<div class="col-lg-2">
								<p class="form-control-static pbn"><b>- Tanggal</b></p>
							</div>
							<div class="col-lg-2">
								<input type="text" name="tanggal" id="tanggal" class="form-control input-sm">
							</div>
							<div class="col-lg-2">
								<button id="btn-submit-pay" class="btn btn-primary btn-gradient dark btn-block btn-sm"><span class="glyphicons glyphicons-check"></span>  Submit Payment</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- End: Content -->