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
                            <label class="col-lg-1 control-label">Periode&nbsp;<span class="text-danger">*</span></label>
                            <div class="col-lg-1">
                                <input type="text" id="periode" class="form-control input-sm input-date" value="<?=date('m/Y')?>">
                                
                            </div>
                            <div class="col-lg-2">
                                <button type="button" id="btn-submit" class="btn btn-sm btn-primary btn-gradient dark btn-block">Submit</button>
                            </div>
                            <!--
                            <label class="col-lg-2 control-label">Hide Coloumn&nbsp;:</label>
                            <div class="col-lg-4">
                                <select id='show_kolom' multiple>
                                    <option value="">-- pilih --</option>
                                    <option value="3">Nasabah</option>
                                    <option value="4">Sumberdaya</option>
                                    <option value="5">SPK</option>
                                    <option value="6">Tahap</option>
                                    <option value="7">Invoice</option>
                                    <option value="8">Faktur</option>
                                    <option value="9">Volume</option>
                                </select>
                            </div>
                            -->
                        </div>
                        <div class="form-group">
                            <div class="col-lg-2">
                                <input class="control-label" type="checkbox" id="group-switch" name="group-switch">&nbsp;&nbsp;<label class="control-label">Group by Nomor Bukti&nbsp;</label>
                            </div>
                        </div>
                        <!--div class="form-group">
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
                    
                    <table class="table table-striped table-bordered table-hover" id="datatable" cellspacing="0" width="100%">
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
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</section>
<!-- End: Content -->