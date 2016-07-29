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
                            
                            
                            <div class="col-lg-1">
                                <button type="button" id="btn-submit" class="btn btn-sm btn-primary btn-gradient dark btn-block">Tampilkan</button>
                            </div>
                            <div class="col-lg-1">
                                &nbsp;
                            </div>
                            <div class="col-lg-2">
                                <button type="button" id="btn-v_listnobuk" class="btn btn-sm btn-primary btn-gradient dark btn-block">List Nomor Bukti</button>
                            </div>
                           
                            
                        </div>
                        <div class="row">
                            <label class="col-lg-1 control-label">Group By&nbsp;<span class="text-danger">*</span></label>
                            <div class="col-lg-2">
                                <select id='group_by' name='group_by' single>
                                    <option value="">-- pilih --</option>
                                    <option value="K">Bukti Kas</option>
                                    <option value="B">Bukti Bank</option>
                                    <option value="M">Bukti Menorial</option>
                                </select>
                            </div>
                            <div class="col-md-7">
                                <p>&nbsp;</p>
                            </div>
                            <div class="col-md-2 text-right">
                                <button id="exp2excel" name="exp2excel">Export To Excel</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-2">
                                <input class="control-label" type="checkbox" id="group-switch" name="group-switch">&nbsp;&nbsp;<label class="control-label">Group by Nomor Bukti&nbsp;</label>
                            </div>
                        </div>
                        <!--div class="form-group">
                            <div class="col-lg-2">
                                <input class="control-label" type="checkbox" id="group-switch" name="group-switch">&nbsp;&nbsp;<label class="control-label">Sort by Nomor Bukti&nbsp;</label>
                            </div>
                        </div-->
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
                    
                    <table class="table table-striped table-bordered table-hover export2excel" id="datatable" cellspacing="0" width="100%">
                        <thead>
                            <tr class="bg-primary light bg-gradient">
                                <th>No. Bukti</th>
                                <th>Tanggal</th>
                                <th>COA</th>
                                <th>Uraian</th>
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
                            </tr>
                            <!--tr  id="filterrow">
                                <th>No. Bukti</th>
                                <th>Tanggal</th>
                                <th>COA</th>
                                <th>Uraian</th>
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
                            </tr-->
                        </thead>
                        <!--tfoot>
                            <th>No. Bukti</th>
                            <th>Tanggal</th>
                            <th>COA</th>
                            <th>Uraian</th>
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
                        </tfoot-->
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- modal -->
    <div class="modal fade" role="dialog" id="modal-list_nobuk">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Daftar Nomor Bukti Tersimpan</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered table-hover" id="datatable-listnobuk" cellspacing="0" width="100%">
                                <thead>
                                    <tr class="bg-primary light text-center">
                                        <th class="bg-primary light text-center" colspan="3">Nomor Bukti</th>
                                    </tr>
                                    <tr class="bg-primary light text-center">
                                        <td>Kas</td>
                                        <td>Bank</td>
                                        <td>Memorial</td>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-close" class="btn btn-danger btn-gradient dark">Tutup</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- modal end -->
</section>
<!-- End: Content -->