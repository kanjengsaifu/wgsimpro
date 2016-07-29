
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
					<form class="form-horizontal" role="form" action="javascript:" id="form-bank-in">
						<input type="hidden" id="idbank" name="idbank"/>
						<div class="form-group">
                            <label class="col-lg-2 control-label">Jenis</label>
                            <div class="col-lg-1">
	                            <div class="radio-custom square radio-success mb5">
	                              <input type="radio" id="jenis1" name="jenis" value="BM" checked="checked">
	                              <label for="jenis1">Bank</label>
	                            </div>
	                        </div>
	                        <div class="col-lg-1">
	                            <div class="radio-custom square radio-primary mb5">
	                              <input type="radio" id="jenis2" name="jenis" value="CB">
	                              <label for="jenis2">Cash</label>
	                            </div>
                            </div>
                           <!-- <div class="col-lg-2">
								<div class="checkbox-custom square checkbox-success">
									<input id="unidentified" type="checkbox" name="unidentified" value="1">
									<label for="unidentified"> Unidentified Debtor ?</label>
								</div>
							</div> -->
                        </div>
                        <div class="form-group">
							<label class="col-lg-2 control-label">Tanggal</label>
							<div class="col-lg-2">
								<input type="text" name="tanggal" id="tanggal" class="form-control input-sm">
							</div>
							<label class="col-lg-2 control-label">Bank Penerima</label>
							<div class="col-lg-4">
								<select id="kode_bank" name="kode_bank" class="chosen-select">
									<option value=""></option>
                                <?php foreach ($data['bank'] as $k => $v) { ?>
                                    <option value="<?=$v['kode']?>"><?=$v['nama']?> [ <?=$v['no_rekening'] ?> ]</option>
                                <?php } ?>
								</select>
							</div>
						</div>
                        <div class="form-group">
							<label class="col-lg-2 control-label">Diterima dari</label>
							<div class="col-lg-4">
								<select id="kode_nasabah" name="kode_nasabah" class="chosen-select">
									<option value=""></option>
                                <?php foreach ($data['unit'] as $k => $v) { ?>
                                    <option value="<?=$v['kode']?>"><?=$v['kode'] ?>&nbsp;[ <?=$v['nama']?> ]</option>
                                <?php } ?>
								</select>
							</div>
						</div>
						 <div class="form-group">
							<label class="col-lg-2 control-label">Keterangan</label>
							<div class="col-lg-4">
								<textarea class="form-control textarea-grow" id="keterangan" name="keterangan" rows="4"></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label">Nominal</label>
							<div class="col-lg-4">
								<input type="text" name="rp" id="rp" class="form-control input-sm input-numeric text-right">
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-2">
							</div>
							
							<div class="col-lg-2" id="btnsimpan">
								<button id="btn-submit-pay" class="btn btn-primary btn-gradient dark btn-block btn-sm"><span class="glyphicons glyphicons-check"></span>Simpan</button>
							</div>
							<div class="col-lg-2" id="btnupdate" style="display: none;">
								<button id="btn-update-pay" class="btn btn-primary btn-gradient dark btn-block btn-sm"><span class="glyphicons glyphicons-check"></span>Update</button>
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
                	<table class="table table-striped table-bordered table-hover" id="datatable" cellspacing="0" width="100%">
						<thead>
							<tr class="bg-primary bg-gradient">
								<th>Nomor Voucher</th>
								<th>Tanggal</th>
								<th>Bank Penerima</th>
								<th>Debitor</th>
								<th>Keterangan</th>
								<th>Nominal</th>
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