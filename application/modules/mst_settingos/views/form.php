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
                		<input type="hidden" name="id" id="id" value="">
                		<input type="hidden" name="kode_entity" id="kode_entity" value="<?php echo $kode_entity;?>"/>
						
						<div class="form-group">
							<label class="col-lg-2 control-label">Jenis</label>
							<div class="col-lg-1">
                                <input type="text" name="jenis" id="jenis" class="form-control input-sm" value="">
                            </div>
						</div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">CoA</label>
                            <div class="col-lg-4">
                                <select id="kode_coa" name="kode_coa" class="chosen-select">
                                    <option value=""></option>
                                <?php foreach($data['coa'] as $k => $v) { ?>
                                    <option value="<?=$v['kode']?>"><?=$v['kode'].' - '.$v['nama']?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Posisi Debit (D) / Kredit (K)</label>
                            <div class="col-lg-6">
                                <div class="col-lg-3 checkbox-custom square checkbox-success">
                                    <input id="penerbitan" type="radio" value="1" name="dk">
                                    <label for="penerbitan"> D - Debit</label>
                                </div>
                                <div class="col-lg-3 checkbox-custom square checkbox-success">
                                    <input id="pelunasan" type="radio" value="1" name="dk">
                                    <label for="pelunasan"> K - Kredit</label>
                            </div>
                            </div>
                        </div>
                        <!--div class="form-group">
                            <label class="col-lg-2 control-label">Posisi </label>
                            <div class="col-lg-6">
                                <div class="col-lg-3 checkbox-custom square checkbox-success">
                                    <input id="penerbitan" type="checkbox" value="1" name="dk">
                                    <label for="penerbitan"> Penerbitan</label>
                                </div>
                                <div class="col-lg-3 checkbox-custom square checkbox-success">
                                    <input id="pelunasan" type="checkbox" value="1" name="dk">
                                    <label for="pelunasan"> Pelunasan</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Posisi</label>
                            <div class="col-lg-4">
                                <select id="kode_posisi" name="kode_posisi" class="chosen-select">
                                    <option value=""></option>
                                    <option value="D">Penerbitan</option>
                                    <option value="K">Pelunasan</option>
                                </select>
                            </div>
                        </div-->
                        <div class="form-group">
                            <label class="col-lg-2 control-label">&nbsp;</label>
                            <div class="col-lg-2">
                                <button type="button" id="btn-submit" class="btn btn-primary btn-gradient dark btn-block">Simpan</button>
                            </div>
                        </div>
                	</form>

                	

                </div>
            </div>
        </div>
    </div>

</section>
<!-- End: Content -->