<!-- Begin: Content -->
<section id="content">

    <div class="row">
        <div class="col-md-12 pn">
            <div class="panel">
                <div class="panel-body">
                	<form class="form-horizontal" role="form" action="javascript:" id="form-input">
                		<input type="hidden" name="id" id="id"/>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Nama Group</label>
                            <div class="col-lg-4">
                                <input type="text" name="nama" id="nama" class="form-control input-sm">
                            </div>
                        </div>
                        <div class="form-group hidden">
                            <label class="col-lg-2 control-label">Kawasan / Entity</label>
                            <div class="col-lg-10">
                                <select id="kode_entity" name="kode_entity[]" multiple="multiple">
                                <?php foreach($data['entity'] as $k => $v) { ?>
                                    <option value="<?=$v['kode']?>" <?=$v['selected']==='0'?'':'selected'?>><?=$v['nama']?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Menu Aplikasi</label>
                            <div class="col-lg-10">
                                <div id="tree-menu" style="height: 500px;overflow-y:scroll;border:1px solid #dddddd"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-10 control-label">&nbsp;</label>
                            <div class="col-lg-2">
                                <button type="button" id="btn-submit" class="btn btn-primary btn-gradient dark btn-block">Submit</button>
                            </div>
                        </div>
                	</form>
                </div>
            </div>
        </div>
    </div>

</section>
<!-- End: Content -->