<!-- Begin: Content -->
<section id="content">

    <div class="row">
        <div class="col-md-12 pn">
            <div class="panel mbn">
                <div class="panel-body">
                    <form class="form-horizontal" role="form" action="javascript:" id="form-filter">

                        <input type="hidden" name="id" id="id"/>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Type Property</label>
                            <div class="col-lg-4">
                                <select id="type_property" class="chosen-select">
                                    <option value=""></option>
                                <?php foreach ($data['type_property'] as $k => $v) { ?>
                                    <option value="<?=$v['kode']?>"><?=$v['konten']?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label"><?=$this->session->userdata('type_entity')==='LD' ? "Cluster" : "Tower"?></label>
                            <div class="col-lg-4">
                                <select id="tower_cluster" class="chosen-select">
                                    <option value=""></option>
                                <?php foreach ($data['tower_cluster'] as $k => $v) { ?>
                                    <option value="<?=$v['kode']?>"><?=$v['konten']?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label"><?=$this->session->userdata('type_entity')==='LD' ? "Blok" : "Lantai"?></label>
                            <div class="col-lg-4">
                                <select id="lantai_blok" class="chosen-select">
                                    <option value=""></option>
                                <?php foreach ($data['lantai_blok'] as $k => $v) { ?>
                                    <option value="<?=$v['kode']?>"><?=$v['konten']?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">No. Unit</label>
                            <div class="col-lg-4">
                                <select id="no_unit" class="chosen-select">
                                    <option value=""></option>
                                <?php foreach ($data['units'] as $k => $v) { ?>
                                    <option data-tower_cluster="<?=$v['tower_cluster']?>" data-lantai_blok="<?=$v['lantai_blok']?>" data-type_property="<?=$v['type_property']?>" value="<?=$v['no_unit']?>"><?=$v['no_unit']?></option>
                                <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <button type="button" id="btn-tambah" class="btn btn-sm btn-primary btn-gradient dark btn-block">Tambah</button>
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
                <div class="panel-body ">
                    <form action="javascript:" id="form-unit">
                    <table class="table table-bordered w500" id="datatable" cellspacing="0">
						<thead>
							<tr class="bg-primary light">
                                <th class="text-center w200">&nbsp;</th>
								<th class="text-center w150">No. Unit</th>
                                <th class="text-center w150">Tgl. Ra. Terbit</th>
                                <th class="text-center">&nbsp;</th>
							</tr>
						</thead>
                        <tbody></tbody>
					</table>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 pn">
            <div class="panel mbn">
                <div class="panel-body ">
                    <form class="form-horizontal" role="form" action="javascript:" id="form-input">
                        
                        <div class="form-group">
							<label class="col-lg-2 control-label">Jenis Dokumen</label>
							<div class="col-lg-4">
								<select id="jenis_dok" name="kode_dokumen" class="chosen-select">
									<option value=""></option>
								<?php foreach($data['dokumen'] as $k => $v) { ?>
									<option value="<?=$v['kode']?>"><?=$v['konten']?></option>
								<?php } ?>
								</select>
							</div>
						</div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Tanggal Ra. Terbit</label>
                            <div class="col-lg-2">
                                <input type="text" name="tgl_ra" id="tgl_ra" class="form-control input-sm input-date">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Nama Notaris</label>
                            <div class="col-lg-4">
                                <input type="text" name="nama_notaris" id="nama_notaris" class="form-control input-sm">
                            </div>
                            <div class="col-lg-2">
                                <button type="button" id="btn-submit" class="btn btn-sm btn-primary btn-gradient dark btn-block">Submit</button>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>

</section>
<!-- End: Content -->