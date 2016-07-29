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
                                <th class="bg-primary light bg-gradient">No. Bukti</th>
                                <th class="bg-primary light bg-gradient">Tanggal</th>
                                <th class="bg-primary light bg-gradient">COA</th>
                                <th class="bg-primary light bg-gradient">Uraian</th>
                                <th class="bg-primary light bg-gradient">Nasabah</th>
                                <th class="bg-primary light bg-gradient">Customer</th>
                                <th class="bg-primary light bg-gradient">Sumberdaya</th>
                                <th class="bg-primary light bg-gradient">SPK</th>
                                <th class="bg-primary light bg-gradient">Tahap</th>
                                <th class="bg-primary light bg-gradient">No. Invoice</th>
                                <th class="bg-primary light bg-gradient">Kode Faktur</th>
                                <th class="bg-primary light bg-gradient">Volume</th>
                                <th class="bg-primary light bg-gradient">Debet</th>
                                <th class="bg-primary light bg-gradient">Kredit</th>
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

    <!-- modal -->
    <div class="modal fade" role="dialog" id="modal-listnobuks">
        <div class="modal-dialog modal-lg">
            <div class="modal-content col-md-10">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Daftar Nomor Bukti Belum Terpakai</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        
                        <div class="col-md-12">
                            <label class="col-lg-1 control-label">Periode</label>
                            <div class="col-lg-2">
                                <input name="tgl_periode_list" id="tgl_periode_list" style="width: 100px;" class="form-control input-sm text-left" type="text" value="<?=date('Y/m/d')?>">
                            </div>
                            <div class="col-lg-2">
                                <select id="v_jenis" name="v_jenis" class="pagesize" title="pilih"> 
                                        <option value="K" selected="selected">Kas / Bank</option> 
                                        <option value="M">Memorial</option> 
                                    </select>
                            </div>
                            <div class="col-lg-2">
                                <button id="btn_periode_nobuk" name="btn_periode_nobuk" class="btn-info">Apply</button>
                            </div>
                            <!-- pager --> 
                            <div class="col-lg-8 pager"> 
                                    <img src="http://mottie.github.com/tablesorter/addons/pager/icons/first.png" class="first"/> 
                                    <img src="http://mottie.github.com/tablesorter/addons/pager/icons/prev.png" class="prev"/> 
                                    <span class="pagedisplay"></span> <!-- this can be any element, including an input --> 
                                    <img src="http://mottie.github.com/tablesorter/addons/pager/icons/next.png" class="next"/> 
                                    <img src="http://mottie.github.com/tablesorter/addons/pager/icons/last.png" class="last"/> 
                                    <select class="pagesize" title="Select page size">
                                        <option selected="selected" value="5">5</option>  
                                        <option value="10">10</option> 
                                        <option value="20">20</option> 
                                        <option value="30">30</option> 
                                        <option value="40">40</option> 
                                    </select>
                                    <select class="gotoPage" title="Select page number"></select>
                            </div>
                            <table class="tablesorter table" id="t_sorter">
                                <thead>
                                    <tr class="bg-primary light bg-gradient">
                                        <th>Nomor Bukti</th>
                                        <th>Status</th>
                                        <th>Pilih</th>
                                    </tr>
                                </thead>
                                <tbody id="tb_listnobuk">
                                <?php
                                    //var_dump($data);
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-close-lookup" class="btn btn-danger btn-gradient dark">Tutup</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</section>
<!-- End: Content -->