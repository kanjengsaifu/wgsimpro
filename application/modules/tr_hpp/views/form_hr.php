<!-- Begin: Content -->
<section id="content">

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

    <div class="row">
        <div class="col-md-12 pn">
            <div class="panel mbn">
                <div class="panel-body">
                    <form class="form-horizontal" role="form" action="javascript:" id="form-head">
                        <div class="form-group mbn">
                            <label class="col-lg-2 control-label">Jenis Biaya</label>
                            <div class="col-lg-4">
                                <select id="type_cost" class="chosen-select">
                                    <option value=""></option>
                                    <option value="BL">Biaya Langsung</option>
                                    <option value="BTL">Biaya Tak Langsung</option>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <a href="javascript:" alt="Add Header" title="Add Header" class="label label-success btn-add-header"><span class="fa fa-plus"></span> Add Header</a>
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
                    <form class="form-horizontal" role="form" action="javascript:" id="form-luas">
                        <div class="form-group mbn BL-luas-head"></div>
                        <div class="form-group mbn BL-luas">
                            <label class="col-lg-2">Luas</label>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 pn">
            <div class="panel mbn">
                <div class="panel-body" style="overflow-x: scroll-x">
                	<form class="form-horizontal" role="form" action="javascript:" id="form-input">
                        <input type="hidden" name="kode_entity" id="kode_entity" value="<?=$this->session->userdata('kode_entity')?>"/>
                        <div class="form-group mbn BL-head">
                            <label class="col-lg-2">I. Biaya Langsung</label>
                        </div>
                        <div class="BL-container"></div>
                        <div class="form-group mbn BL-total">
                            <div class="col-lg-1">&nbsp;</div>
                            <label class="col-lg-2">TOTAL HPP LANGSUNG</label>
                        </div>
                        <div class="form-group BL-m2">
                            <div class="col-lg-1">&nbsp;</div>
                            <label class="col-lg-2">HPPL /m&sup2;</label>
                        </div>
                        <div class="form-group mbn BTL-head">
                            <label class="col-lg-2">II. Biaya Tidak Langsung</label>
                        </div>
                        <div class="BTL-container"></div>
                        <div class="form-group BTL-total">
                            <div class="col-lg-1">&nbsp;</div>
                            <label class="col-lg-2">TOTAL HPP TIDAK LANGSUNG</label>
                        </div>
                        <div class="form-group mbn HPP-total">
                            <div class="col-lg-1">&nbsp;</div>
                            <label class="col-lg-2">TOTAL HPP</label>
                        </div>
                        <div class="form-group HPP-m2">
                            <div class="col-lg-1">&nbsp;</div>
                            <label class="col-lg-2">HPP /m&sup2;</label>
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
                    <form class="form-horizontal" role="form" action="javascript:">
                        <div class="form-group mn">
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