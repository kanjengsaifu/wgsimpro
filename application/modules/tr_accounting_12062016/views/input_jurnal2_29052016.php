<style type="text/css">
table {
    border-collapse: collapse;
    table-layout:fixed;
}

td {
    padding-top: .3em;
    padding-bottom: .3em;
    padding-left: .5em;
}
</style>
<form id="print-vcr" name="print-vcr" action="javascript:" target="_blank"></form>

<section id="content">
	<form action="javascript:" id="form-input" method="post">
		<div class="row">
	        <div class="col-md-12 pn">
	            <div class="panel mbn">
	                <div class="panel-body">
	                	<div class="form-group"> 
	                		<input name="is_edit_row" id="is_edit_row" type="hidden" value="0">
	                		<input name="is_mode" id="is_mode" type="hidden" value="<?=$data['post']?>">

	                        <table width="100%">
	                        	<tr>
		                        	<td style="width: 9%;" class="text-right">Tanggal :</td>
		                        	<td style="width: 9%;" class="text-left"><input name="tanggal" id="tanggal" style="width: 100px;" class="form-control input-sm text-left" type="text" value="<?=date('d/m/Y')?>"></td>
		                        	
		                        	<td style="width: 3%;" ></td>
		                        	<td style="width: 35%;" class="text-left"></td>
		                        	<td class="text-right"><?=HIDE_INPUTBOX_JURNAL_INFO_KODESPK=='N'?'Dept :':''?></td>
		                        	<td class="text-right">
		                        		<input name="div_name" id="div_name" style="width: 250px;" disabled="" class="form-control input-sm text-left text-uppercase" type="<?=HIDE_INPUTBOX_JURNAL_INFO_KODEDEPT=='N'?'text':'hidden'?>"  value="<?=$this->session->userdata('nama_dept')?>">
		                        		<input name="kd_div" id="kd_div" style="width: 250px;" type="hidden" value="<?=$this->session->userdata('kode_dept')?>">
		                        	</td>
		                        </tr>
		                        <tr>
		                        	<td class="text-right">Nomor Bukti :</td>
		                        	<td><input name="no_bukti" id="no_bukti" style="width: 100px;" class="col-lg-1 form-control input-sm text-left text-uppercase" type="text"  value="" maxlength="6"></td>
		                        	<td><button id="btn-listnobuk">?</button></td>
		                        	<td class="text-left">
		                        		<label id='lbl_nobukti' name='lbl_nobukti' class="crumb-active"><h4>......../.../.../...</h4></label>
		                        		<input name="nomor_bukti" id="nomor_bukti" class="text-uppercase" type="hidden" value="">
		                        		<label id='lbl_lastnobuk1' name='lbl_lastnobuk1' class="crumb-active"></label><label id='lbl_lastnobuk2' name='lbl_lastnobuk2' class="crumb-active"></label>
		                        	</td>
		                        	
		                        	<td class="text-right"><?=HIDE_INPUTBOX_JURNAL_INFO_KODESPK=='N'?'Kode SPK :':''?></td>
		                        	<td class="text-right"><input name="kd_spk_vcr" style="width: 150px;" id="kd_spk_vcr" disabled="" class="form-control input-sm text-left text-uppercase" type="<?=HIDE_INPUTBOX_JURNAL_INFO_KODESPK=='N'?'text':'hidden'?>"  value="<?=$this->session->userdata('kode_entity')?>"></td>
		                        </tr>
		                        <tr>
		                        	<td class="text-right">Jenis :</td>
		                        	<td>
		                        		<?=$data['cbo_jenisjurnal']?>
		                        		<!--input name="kd_jenis2" id="kd_jenis2" style="width: 100px;" class="col-lg-1 form-control input-sm text-left" type="text" placeholder="jenis" value=""--></td>
		                        	<td></td>
		                        	<td class="text-left">
		                        		<table width='60%'>
		                        			<td><label id='lbl_jenis' name='lbl_jenis' class="text-uppercase"></td>
		                        			<td style="width: 80%;"><div id='last_nobuk1'></div><!--button width='100%' type="button" id="btn-cetak-vcr" name="btn-cetak_vcr" class="btn btn-sm btn-success btn-block"><i class="fa fa-print"></i>&nbsp;&nbsp;&nbsp;Voucher</button--></td>
		                        			<td style="width: 80%;"><div id='last_nobuk2'></div><!-- hide dulu <button width='100%' type="button" id="btn-attach" name="btn-attach" class="btn btn-sm btn-system btn-block"><i class="fa fa-paperclip"></i>&nbsp;&nbsp;&nbsp;Attach</button>--></td>
		                        		</table>
		                        	</td>
		                        	
		                        	<td class="text-right" id='input_form'></td>
		                        	<td class="text-right"></td>
		                        </tr>
	                        </table> 
	                	</div>
	                </div>
	            </div>
	        </div>
	        <div class="col-md-12 pn">
	            <div class="panel mbn">
	                <div class="panel-body">
	                	<div class="form-group"> 
	                        	<table id='2' width="100%">
	                        	<tr>
		                        	<td style="width: 9%;" class="text-right"><span id='r_coa'>COA :</span></td>
		                        	<td style="width: 10%;" class="text-left"><input name="kd_coa" id="kd_coa" style="width: 100px;" class="form-control input-sm text-left text-uppercase" type="text" value="" maxlength="5"><span class='text-danger' id='req_tahap'></div></td>
		                        	<td style="width: 22%;" class="text-left"><label id='desc_coa' name='desc_coa'></label></td>
		                        	<td style="width: 9%;" class="text-right"><span id='r_terbit'>Kode Terbit :</span></td>
		                        	<td style="width: 17%;" class="text-left"><input name="no_terbit" id="no_terbit" style="width: 170px;" class="form-control input-sm text-left text-uppercase cterbit" type="text" placeholder="....../.././.." value=""><span class='text-danger' id='req_terbit'></td>
		                        	<td class="text-left">Debet : <label id="vjDebit">0</label></td>
		                        	<td class="text-left">Kredit : <label id="vjKredit">0</label></td>
		                        </tr>
		                        <tr>
		                        	<td class="text-right"><span class='text-danger' id='req_nasabah'></span><span id='r_nasabah'>Kode Nasabah :</span></td>
		                        	<td><input name="kd_nasabah" id="kd_nasabah" style="width: 100px;" class="col-lg-1 form-control input-sm text-left" type="text"  value="" maxlength="4"></td>
		                        	<td class="text-left"><label id='desc_nasabah' name='desc_nasabah'></label></td>
		                        	<td class="text-right"><span class='text-danger' id='req_faktur'></span><span id='r_faktur'>Faktur Pajak :</span></td>
		                        	<td class="text-left"><input name="kd_faktur" id="kd_faktur" style="width: 170px;" class="form-control input-sm text-left text-uppercase fkpajak" type="text" placeholder="000.000-00.00000000" value=""></td>
		                        	<td class="text-right"><input name="debit" style="width: 90%;" id="debit" class="form-control input-sm text-right" type="text" value="0"></td>
		                        	<td class="text-right"><input name="kredit" style="width: 90%;" id="kredit" class="form-control input-sm text-right" type="text" value="0"></td>
		                        </tr>
		                        <tr>
		                        	<td class="text-right"><span class='text-danger' id='req_customer'></span><span id='r_nasabah'>Kode Customer :</span></td>
		                        	<td><input name="kd_customer" id="kd_customer" style="width: 100px;" class="col-lg-1 form-control input-sm text-left" type="text"  value="" maxlength="4"></td>
		                        	<td class="text-left"><label id='desc_customer' name='desc_customer'></label></td>
		                        	<td class="text-right"><span class='text-danger' id='req_invoice'></span><span id='r_invoice'>Invoice :</span></td>
		                        	<td class="text-left"><input name="invoice" id="invoice" style="width: 170px;" class="form-control input-sm text-left text-uppercase" type="text"  value=""></td>
		                        	<td class="text-right"></td>
		                        	<td class="text-right"></td>
		                        </tr>
		                        <tr>
		                        	<td class="text-right"><span class='text-danger' id='req_sbdy'></span><span id='r_sbdy'>Kode Sumberdaya :</span></td>
		                        	<td><input name="kd_sumberdaya" id="kd_sumberdaya" style="width: 100px;" class="col-lg-1 form-control input-sm text-left" type="text"  value="" maxlength="6"></td>
		                        	<td class="text-left"><label id='desc_sumberdaya' name='desc_sumberdaya'></label></td>
		                        	<td class="text-right"><span class='text-danger' id='req_potong'></span><span id='r_faktur'>Bukti Potong :</span></td>
		                        	<td class="text-left"><input name="potong" id="potong" style="width: 170px;" class="form-control input-sm text-left text-uppercase" type="text"  value=""></td>
		                        	<td colspan="2" rowspan="2"><textarea id="uraian" name="uraian" style="width: 95%; rows: 110%;" placeholder="Uraian/Deskripsi Jurnal" class="form-control text-uppercase"></textarea></td>
		                        </tr>
		                        <tr>
		                        	<td class="text-right"><span id='r_spk'>Kode SPK :</span></td>
		                        	<td>
		                        		<input name="kd_spk" id="kd_spk" style="width: 100px;" class="col-lg-1 form-control input-sm text-left" type="text" maxlength="6" value="<?=$this->session->userdata('kode_entity')?>" <?=LOCK_KODESPK=='Y'?'disabled':''?>>
		                        		<span class='text-danger' id='req_spk'></span>
		                        	</td>
		                        	<td class="text-left"><label id='desc_spk' name='desc_spk'><?=$this->session->userdata('nama_entity')?></label></td>
		                        	<td class="text-right"><span id='r_volume'>Volume :</span></td>
		                        	<td class="text-left"><input name="volume" id="volume" style="width: 170px;" class="form-control input-sm text-left" type="text" value="0"></td>
		                        </tr>
		                        <tr>
		                        	<td class="text-right"><span class='text-danger' id='req_tahap'></span><span id='r_tahap'>Kode Tahap :</span></td>
		                        	<td><input name="kd_tahap" id="kd_tahap" style="width: 100px;" class="col-lg-1 form-control input-sm text-left" type="text" maxlength="6"></td>
		                        	<td class="text-left"><label id='desc_tahap' name='desc_tahap'></label></td>
		                        	<td class="text-right"></td>
		                        	<td class="text-left"></td>
		                        	<td></td>
		                        	<td></td>
		                        </tr>
		                        <tr>
		                        	<td class="text-right"><span id='r_bank'>Kode Bank :</span></td>
		                        	<td><input name="kd_bank" id="kd_bank" style="width: 100px;" class="col-lg-1 form-control input-sm text-left" type="text" maxlength="6" value=""><span class='text-danger' id='req_bank'></td>
		                        	<td class="text-left"><label id='desc_bank' name='desc_bank'></label></td>
		                        	<td></td>
		                        	<td><button style="width: 100px;" type="button" id="btn-cancel" name="btn-cancel" class="btn btn-sm btn-warning"><i class="fa fa-circle-o"></i>&nbsp;&nbsp;&nbsp;Cancel</button></td>
		                        	<td class="text-center" colspan="2" style="width: 95%">
		                        		<table class="text-center" style="width: 95%">
		                        			<td style="width: 80%;"><button type="button" id="btn-tambah" name="btn-tambah" class="btn btn-sm btn-primary btn-block"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;&nbsp;Tambah</button></td>
		                        			<td style="width: 80%;"><button type="button" id="btn-simpan" name="btn-simpan" class="btn btn-sm btn-success btn-block"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Simpan</button></td>
		                        			<!--td style="width: 100%;"><button type="button" id="btn-delete" name="btn-delete" class="btn btn-primary dark btn-block input-sm" >Hapus</button></td-->
		                        		</table>
		                        	</td>
		                        </tr>
	                        </table> 
	                	</div>
	                </div>
	            </div>
	        </div>
	        <div class="col-md-12 pn">
	            <div class="panel mbn">
	                <div class="panel-body">
	                	<div class="form-group"> 
	                    	<table id="datatable" name="datatable" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
	                    		<thead>
		                            <tr class="bg-primary light bg-gradient">
		                                <th class="bg-primary light bg-gradient">COA</th>
		                                <th class="bg-primary light bg-gradient">Nasabah</th>
		                                <th class="bg-primary light bg-gradient">Customer</th>
		                                <th class="bg-primary light bg-gradient">Sumber daya</th>
		                                <th class="bg-primary light bg-gradient">SPK</th>
		                                <th class="bg-primary light bg-gradient">Tahap</th>
		                                <th class="bg-primary light bg-gradient">Bank</th>
		                                <th class="bg-primary light bg-gradient">No. Terbit</th>
		                                <th class="bg-primary light bg-gradient">Kode Faktur</th>
		                                <th class="bg-primary light bg-gradient">Invoice</th>
		                                <th class="bg-primary light bg-gradient">Bukti Potong</th>
		                                <th class="bg-primary light bg-gradient">Debet</th>
		                                <th class="bg-primary light bg-gradient">Kredit</th>
		                                <!--th>vDebet</th>
		                                <th>vKredit</th-->
		                                <th class="bg-primary light bg-gradient">Volume</th>
		                                <th class="bg-primary light bg-gradient">Uraian</th>
		                                <th class="bg-primary light bg-gradient">Action</th>
		                            </tr>
		                        </thead>
	                    		<tbody>
	                    		</tbody>
	                    	</table>
	                	</div>
	                </div>
	            </div>
	        </div>
	    </div>
	</form>
	        <!-- modal -->
    <div class="modal fade" role="dialog" id="modal-coa-all">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Daftar Kode Akun</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered table-hover" id="datatable-coa" cellspacing="0" width="100%">
                                <thead>
                                    <tr class="bg-primary light text-center">
                                    	<!--th rowspan="2" width="10"></th--> 
                                        <th rowspan="2">Kode Akun</th>
                                        <th rowspan="2" style="width: 250px;">Uraian / Keterangan</th>
                                        <th colspan="5" class="bg-primary light text-center">Mandatory</th>
                                        <th rowspan="2">&nbsp;</th>
                                    </tr>
                                    <tr class="bg-primary light text-center">
                                    	<td>Tahap</td>
                                    	<td>Sumberdaya</td>
                                    	<td>Nasabah</td>
                                    	<td>Faktur Pajak</td>
                                    	<td>Bank</td>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-pilih" class="btn btn-primary btn-gradient dark">Pilih</button>
                    <button type="button" id="btn-close" class="btn btn-danger btn-gradient dark">Tutup</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- modal end -->

    <!-- modal -->
    <div class="modal fade" role="dialog" id="modal-list_nobuk">
        <div class="modal-dialog modal-lg">
            <div class="modal-content col-md-10">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Daftar Nomor Bukti Belum Terpakai</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                    	<!--div class="col-md-12">
                    		<div class="form-group">
	                            <label class="col-lg-2 control-label">Periode</label>
	                            <div class="col-lg-6">
	                                <input name="periode" id="periode" style="width: 100px;" class="form-control input-sm text-left" type="text" value="<?=date('Y-m')?>">
	                            </div>
	                        </div>
                    	</div-->
                        <div class="col-md-10">
                            <table class="table table-striped table-bordered table-hover" id="datatable-listnobuk" cellspacing="0" width="100%">
                                <thead>
                                    <tr class="bg-primary light text-center">
                                        <th class="bg-primary light text-center">Nomor Bukti</th>
                                        <th class="bg-primary light text-center">Status</th>
                                        <th class="bg-primary light text-center">Pilih</th>
                                    </tr>
                                </thead>
                                <tbody>
                                	
                                </tbody>
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
                                <input name="tgl_periode_list" id="tgl_periode_list" style="width: 100px;" class="form-control input-sm text-left" type="text" value="<?=date('Y-m')?>">
                            </div>
                            <div class="col-lg-2">
                                <select id="v_jenis" name="v_jenis" class="pagesize" title="pilih">
							        	<option selected="selected" value=""></option>  
							            <option value="K">Kas / Bank</option> 
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
							    <tbody>
							    <?php
							    	//var_dump($data);
							    ?>
							        <tr>
							        	<td>283101</td>
							        	<td>10</td>
							        	<td>[pilih]</td>
							        </tr>
							        
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
