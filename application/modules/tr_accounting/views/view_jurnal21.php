<style type="text/css">
    .someclass { background-color: red; }
</style>

<!-- Begin: Content -->
<section id="content">

    <div class="row">
        <div class="col-md-12 pn">
            <div class="panel-group accordion mbn" id="panel-payment-plan">
                <div class="panel">
                    <div class="panel-heading bg-success2">
                        <a class="accordion-toggle accordion-icon" data-toggle="collapse" data-parent="#panel-payment-plan" href="#panel-payment-plan-item1" style="color:#fff">Filter (Query)</a>
                    </div>
                    <div id="panel-payment-plan-item1" class="panel-collapse collapse in">
                        <div class="panel-body">
                            <form action="javascript:" id="go-edit-jurnal" method="POST">
                                <input id="editing" type="hidden" value="1">
                                <input id="no_bukti" type="hidden" value="">
                                <input id="tanggal" type="hidden" value="">
                            </form>
                            <form class="form-horizontal" role="form" action="javascript:" id="form-input">
                                <input type="hidden" name="kode_entity" id="kode_entity"/>
                                <div class="form-group">
                                    <label class="col-lg-1 control-label">Periode&nbsp;<span class="text-danger">*</span></label>
                                    <div class="col-lg-1">
                                        <input type="text" id="periode" class="form-control input-sm input-date" value="<?=date('m/Y')?>">
                                    </div>
                                    <div class="col-lg-1">
                                        <button type="button" id="btn-submit" class="btn btn-sm btn-primary btn-gradient dark btn-block">Filter</button>
                                    </div>
                                </div>
                                <!--div class="form-group">
                                    <div class="col-lg-2">
                                        <input class="control-label" type="checkbox" id="group-switch" name="group-switch">&nbsp;&nbsp;<label class="control-label">Group by Nomor Bukti&nbsp;</label>
                                    </div>
                                </div-->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 pn">
            <div class="panel">
                <div class="panel-body">
                    <!--
                    <div class="bg-light pv8 pl15 pr10 br-a br-light">
                        <div class="row">
                            <div class="hidden-xs hidden-sm col-md-3 va-m">
                                <div class="btn-group admin-form hidden">
                                    <button type="button" class="btn btn-default light lh25">
                                        <label class="option block mn">
                                            <input type="checkbox" name="mobileos" value="FR">
                                            <span class="checkbox va-t"></span> Select All
                                        </label>

                                    </button>
                                </div>
                                <div class="btn-group mr10">
                                    <button type="button" class="btn btn-default light"><i class="fa fa-print"></i>
                                    </button>
                                    <button type="button" class="btn btn-default light"><i class="fa fa-calendar"></i>
                                    </button>
                                    <button type="button" class="btn btn-default light"><i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-9 text-right">
                                <span class="va-m text-muted mr15"> Showing <strong>15</strong> of <strong>253</strong> </span>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default light"><i class="fa fa-chevron-left"></i>
                                    </button>
                                    <a href="javascript:" class="btn btn-default light">1</a>
                                    <a href="javascript:" class="btn btn-default light">2</a>
                                    <a href="javascript:" class="btn btn-default light">3</a>
                                    <a href="javascript:" class="btn btn-default light">4</a>
                                    <a href="javascript:" class="btn btn-default light">5</a>
                                    <button type="button" class="btn btn-default light"><i class="fa fa-chevron-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    -->
                    <div id="toolbar">
                            <select class="form-control">
                                <option value="">Export Basic</option>
                                <option value="all">Export All</option>
                                <option value="selected">Export Selected</option>
                            </select>
                        </div>
                    <div class="table-responsive">
                        <table class="table table-responsive table-bordered table-hover mbn t-vjurnal" id="t_vjurnal" width="100%"
                            data-toggle="table"
                            data-show-export="true"
                            data-pagination="true"
                            data-click-to-select="true"
                            data-toolbar="#toolbar">
                            <thead>
                                <tr class="bg-primary light bg-gradient">
                                    <th>No. Bukti</th>
                                    <th>Tanggal</th>
                                    <th>CoA</th>
                                    <th>Nasabah</th>
                                    <th>Customer</th>
                                    <th>Sumberdaya</th>
                                    <th>SPK</th>
                                    <th>Tahap</th>
                                    <th>No. Invoice</th>
                                    <th>Kode Faktur</th>
                                    <th>Volume</th>
                                    <th>Debet</th>
                                    <th>Kredit</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Table cell1</td>
                                    <td>Table cell2</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell9</td>
                                    <td>Table cell10</td>
                                    <td>Table cell</td>
                                    <td>Table cell13</td>
                                    <td>1</td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>Table cell1</td>
                                    <td>Tables cell2</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Tableq cell</td>
                                    <td>Tabled cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell9</td>
                                    <td>Table fcell10</td>
                                    <td>Table cell</td>
                                    <td>Table cell13</td>
                                    <td>1</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Table cell1</td>
                                    <td>Table cell2</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell9</td>
                                    <td>Table cell10</td>
                                    <td>Table cell</td>
                                    <td>Table cell13</td>
                                    <td>2</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Table cell1</td>
                                    <td>Table cell2</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell9</td>
                                    <td>Table cell10</td>
                                    <td>Table cell</td>
                                    <td>Table cell13</td>
                                    <td>2</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Table cell1</td>
                                    <td>Table cell2</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell9</td>
                                    <td>Table cell10</td>
                                    <td>Table cell</td>
                                    <td>Table cell13</td>
                                    <td>3</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Table cell1</td>
                                    <td>Table cell2</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell9</td>
                                    <td>Table cell10</td>
                                    <td>Table cell</td>
                                    <td>Table cell13</td>
                                    <td>3</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Table cell1</td>
                                    <td>Table cell2</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell9</td>
                                    <td>Table cell10</td>
                                    <td>Table cell</td>
                                    <td>Table cell13</td>
                                    <td>3</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Table cell1</td>
                                    <td>Table cell2</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell9</td>
                                    <td>Table cell10</td>
                                    <td>Table cell</td>
                                    <td>Table cell13</td>
                                    <td>3</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Table cell1</td>
                                    <td>Table cell2</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell9</td>
                                    <td>Table cell10</td>
                                    <td>Table cell</td>
                                    <td>Table cell13</td>
                                    <td>3</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Table cell1</td>
                                    <td>Table cell2</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell9</td>
                                    <td>Table cell10</td>
                                    <td>Table cell</td>
                                    <td>Table cell13</td>
                                    <td>4</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Table cell1</td>
                                    <td>Table cell2</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell9</td>
                                    <td>Table cell10</td>
                                    <td>Table cell</td>
                                    <td>Table cell13</td>
                                    <td>4</td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Table cell1</td>
                                    <td>Table cell2</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell9</td>
                                    <td>Table cell10</td>
                                    <td>Table cell</td>
                                    <td>Table cell13</td>
                                    <td>5</td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Table cell1</td>
                                    <td>Table cell2</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell9</td>
                                    <td>Table cell10</td>
                                    <td>Table cell</td>
                                    <td>Table cell13</td>
                                    <td>5</td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Table cell1</td>
                                    <td>Table cell2</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell9</td>
                                    <td>Table cell10</td>
                                    <td>Table cell</td>
                                    <td>Table cell13</td>
                                    <td>5</td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>Table cell1</td>
                                    <td>Table cell2</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell9</td>
                                    <td>Table cell10</td>
                                    <td>Table cell</td>
                                    <td>Table cell13</td>
                                    <td>6</td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>Table cell1</td>
                                    <td>Table cell2</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell9</td>
                                    <td>Table cell10</td>
                                    <td>Table cell</td>
                                    <td>Table cell13</td>
                                    <td>6</td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>Table cell1</td>
                                    <td>Table cell2</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell9</td>
                                    <td>Table cell10</td>
                                    <td>Table cell</td>
                                    <td>Table cell13</td>
                                    <td>7</td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>Table cell1</td>
                                    <td>Table cell2</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell9</td>
                                    <td>Table cell10</td>
                                    <td>Table cell</td>
                                    <td>Table cell13</td>
                                    <td>7</td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>Table cell1</td>
                                    <td>Table cell2</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell9</td>
                                    <td>Table cell10</td>
                                    <td>Table cell</td>
                                    <td>Table cell13</td>
                                    <td>7</td>
                                </tr>
                                <!--tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr-->
                            </tbody>
                        </table>
                    </div>
                    <div>
                    </div>
                    <div class="bg-light pv8 pl15 pr10 br-a br-light">
                        <div class="row">
                            <div class="hidden-xs hidden-sm col-md-3 va-m">
                                <div class="btn-group">
                                </div>
                            </div>
                            <div class="col-md-9 text-right">
                                <span class="va-m text-muted mr15"> Showing <strong>15</strong> of <strong>253</strong> </span>
                                
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default light"><i class="fa fa-chevron-left"></i>
                                    </button>
                                    <?=$data['pagenum']?>
                                    <a href="javascript:" class="btn btn-default light">1</a>
                                    <a href="javascript:" class="btn btn-default light">2</a>
                                    <a href="javascript:" class="btn btn-default light">3</a>
                                    <a href="javascript:" class="btn btn-default light">4</a>
                                    <a href="javascript:" class="btn btn-default light">5</a>
                                    <button type="button" class="btn btn-default light"><i class="fa fa-chevron-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
<!-- End: Content -->