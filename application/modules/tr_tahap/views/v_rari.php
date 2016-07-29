<!-- Begin: Content -->
<section id="content">

	<div class="row">
        <div class="col-md-12 pn">
            <div class="panel mbn">
                <div class="panel-body">
                    <form action="javascript:" id="go-edit-jurnal" method="POST">
                        <input id="editing" type="hidden" value="1">
                        <input id="no_bukti" type="hidden" value="">
                        <input id="tanggal" type="hidden" value="">
                    </form>
                	<form class="form-horizontal" role="form" action="javascript:" id="form-input">
                        <input type="hidden" name="kode_entity" id="kode_entity"/>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Tampilkan Biaya&nbsp;:</label>
                            <div class="col-lg-2">
                                <select id='show_biaya' single>
                                    <option value="ALL">BL & BTL</option>
                                    <option value="BL">BL</option>
                                    <option value="BTL">BTL</option>
                                </select>
                            </div>
                            
                            <label class="col-lg-1 control-label">Periode&nbsp;<span class="text-danger">*</span></label>
                            <div class="col-lg-1">
                                <input type="text" id="periode" class="form-control input-sm input-date" value="<?=date('m-Y')?>">
                                
                            </div>
                            <div class="col-lg-2">
                                <button type="button" id="btn-submit" class="btn btn-sm btn-primary btn-gradient dark btn-block">Submit</button>
                            </div>
                        </div>
                        <!--div class="form-group">
                            <div class="col-lg-2">
                                <input class="control-label" type="checkbox" id="group-switch" name="group-switch">&nbsp;&nbsp;<label class="control-label">Group by Nomor Bukti&nbsp;</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-2">
                                <button width='100%' type="button" id="btn-edit" name="btn-edit" class="btn btn-sm btn-info btn-block"><i class="fa fa-print"></i>&nbsp;&nbsp;&nbsp;Edit Jurnal</button>
                            </div>
                            <div class="col-lg-2">
                                <button width='100%' type="button" id="btn-delete" name="btn-delete" class="btn btn-sm btn-warning btn-block"><i class="fa fa-print"></i>&nbsp;&nbsp;&nbsp;Hapus</button>
                            </div>
                        </div-->
                	</form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 pn">
            <div class="panel">
                <div class="panel-body">
                    
                    <table class="table table-striped table-bordered table-hover" id="datatabl" cellspacing="0" width="100%">
                        <thead>
                            <tr class="bg-primary light">
                                <th rowspan="2" class="text-center">Tahap</th>
                                <th rowspan="2" class="text-center">Sumberdaya</th>
                                <th colspan="2" class="text-center">Rencana</th>
                                <th colspan="2" class="text-center">Realisasi</th>
                                <th colspan="2" class="text-center">Deviasi</th>
                            </tr>
                            <tr>
                                <td class="text-center bg-primary light">Vol</td>
                                <td class="text-center bg-primary light">Harga</td>
                                <td class="text-center bg-primary light">Vol</td>
                                <td class="text-center bg-primary light">Harga</td>
                                <td class="text-center bg-primary light">Vol</td>
                                <td class="text-center bg-primary light">Harga</td>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="text-center bg-primary light" colspan="2">Grand Total</td>
                                <td class="text-center bg-primary light">Vol</td>
                                <td class="text-center bg-primary light">Harga</td>
                                <td class="text-center bg-primary light">Vol</td>
                                <td class="text-center bg-primary light">Harga</td>
                                <td class="text-center bg-primary light">Vol</td>
                                <td class="text-center bg-primary light">Harga</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

</section>
<!-- End: Content -->