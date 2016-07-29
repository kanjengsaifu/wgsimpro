<!-- Begin: Content -->
<section id="content">

    <div class="row">
        <div class="col-md-12 pn">
            <div class="panel">
                <div class="panel-body">
                    <form class="form-horizontal" role="form" action="javascript:" id="form-input">

                        <input type="hidden" name="id" id="id"/>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Nama Diskon /(%)</label>
                            <div class="col-lg-4">
                                <input type="text" name="nama" id="nama" class="form-control input-sm">
                            </div>
                            <div class="col-lg-1">
                                <input type="text" name="diskon" id="diskon" class="form-control input-sm input-numeric text-right">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Jenis</label>
                            <div class="col-lg-4">
                                <select id="jenis" name="jenis" class="chosen-select">
                                    <option value=""></option>
                                    <option value="PROPORSIONAL">PROPORSIONAL</option>
                                    <option value="UANG MUKA">UANG MUKA</option>
                                    <option value="ANGSURAN">ANGSURAN</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Mekanisme Penerapan</label>
                            <div class="col-lg-4">
                                <select id="mekanisme" name="mekanisme" class="chosen-select required">
                                    <option value=""></option>
                                    <option value="PROPORSIONAL">PROPORSIONAL</option>
                                    <option value="TERAPKAN DI 1 ANGSURAN">TERAPKAN DI 1 ANGSURAN</option>
                                </select>
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