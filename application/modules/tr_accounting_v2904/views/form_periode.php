<section id="content">
	<div class="row">
        <div class="col-md-12 pn">
            <div class="panel mbn">
                <div class="panel-body">
                	
                    <form class="form-horizontal" role="form" action="javascript:" id="form-input" method="post">
                        <input type="hidden" id="target" value="<?=$data['target']?>"/>
                        <div class="form-group">
                            <label class="col-lg-1 control-label">Periode</label>
                            <div class="col-lg-1">
                                <input type="text" id="periode" class="form-control input-sm input-periode" value="<?=date('m-Y')?>">
                            </div>
                            <div class="col-lg-1">
                                <input type="hidden" id="div_id" name="div_id" value="<?=$this->session->userdata('kode_dept')?>">
                                <button type="button" id="btn-view" class="btn btn-sm btn-primary btn-gradient dark btn-block"><span class="fa fa-search"></span>&nbsp;&nbsp;&nbsp;View</button>
                            </div>
                        </div>
                    </form>
                	
                </div>
            </div>
        </div>
    </div>
</section>