<!-- Begin : Content -->
<section id="content">
    <div class="row">
		<div class="col-md-12 pn">
			<div class="panel mbn">
				<div class="panel-body">
                    <form class="form-horizontal" role="form" action="javascript:" id="form-filter">
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
                                <button type="button" id="btn-filter" class="btn btn-sm btn-primary btn-gradient dark btn-block">Filter</button>
                            </div>
                        </div>
                    </form>
                </div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 pn">
			<div class="panel">
				<div class="panel-body">
					<table class="table table-striped table-bordered table-hover" id="datatable" cellspacing="0" width="100%">
						<thead>
							<tr class="bg-primary light bg-gradient">
								<th rowspan="2" class="text-center" style="vertical-align:middle">No. Unit</th>
                            <?php foreach($data['head'] as $v) { ?>
                                <th colspan="2" class="text-center" style="vertical-align:middle"><?=$v['nama']?></th>
                            <?php } ?>
                            </tr>
                            
                            <tr class="bg-primary light bg-gradient">
                                <?php foreach($data['head'] as $v) { ?>
                                <td class="text-center">Ra</td>
                                <td class="text-center">Ri</td>
                                <?php } ?>
                            </tr>
                            
						</thead>
						<tbody>
                        <?php foreach($data['body'] as $k => $v) { ?>
                            <tr data-no_unit="<?=$v['no_unit']?>" data-tower_cluster="<?=$v['tower_cluster']?>" data-lantai_blok="<?=$v['lantai_blok']?>" data-type_property="<?=$v['type_property']?>">
                                <td class="text-center"><?=$v['no_unit']?></td>
                            <?php foreach($v['docs'] as $k2 => $v2) { ?>
                                <td class="text-center w75"><?=$v2['ra']?></td>
                                <td class="text-center w75"><?=$v2['ri']?></td>
                            <?php } ?>
                            </tr>
                        <?php } ?>
                        </tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- End : Content -->