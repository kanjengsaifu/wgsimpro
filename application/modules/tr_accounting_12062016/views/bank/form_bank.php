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
<form action="javascript:" id="form-input" method="post">
	<section id="content">
		<div class="row">
	        <div class="col-md-12 pn">
	            <div class="panel mbn">
	                <div class="panel-body">
	                	<div class="form-group"> 
	                		<input name="is_edit_row" id="is_edit_row" type="hidden" value="0">
	                		<input name="is_mode" id="is_mode" type="hidden" value="entry">
	                        <table width="100%">
	                        	<tr>
		                        	<td style="width: 9%;" class="text-right">Tanggal :</td>
		                        	<td style="width: 11%;" class="text-left"><input name="tanggal" id="tanggal" style="width: 100px;" class="form-control input-sm text-left" type="text" value="<?=date('d/m/Y')?>"></td>
		                        	<td style="width: 35%;" class="text-left"></td>
		                        	<td class="text-right">Dept :</td>
		                        	<td class="text-right">
		                        		<input name="div_name" id="div_name" style="width: 250px;" disabled="" class="form-control input-sm text-left text-uppercase" type="text"  value="<?=$this->session->userdata('unit_kerja')?>">
		                        		<input name="kd_div" id="kd_div" style="width: 250px;" type="hidden" value="<?=$this->session->userdata('kode_dept')?>">
		                        	</td>
		                        </tr>
		                        <tr>
		                        	<td class="text-right">Nomor Bukti :</td>
		                        	<td><input name="no_bukti" id="no_bukti" style="width: 100px;" class="col-lg-1 form-control input-sm text-left text-uppercase" type="text"  value="" maxlength="6"></td>
		                        	<td>
		                        		<label id='lbl_nobukti' name='lbl_nobukti' class="crumb-active"><h4>......../.../.../...</h4></label>
		                        		<input name="nomor_bukti" id="nomor_bukti" class="text-uppercase" type="hidden" value="">
		                        	</td>
		                        	<td class="text-right">Kode SPK :</td>
		                        	<td class="text-right"><input name="kd_spk_vcr" style="width: 150px;" id="kd_spk_vcr" disabled="" class="form-control input-sm text-left text-uppercase" type="text"  value="<?=$this->session->userdata('kode_entity')?>"></td>
		                        </tr>
		                        <tr>
		                        	<td class="text-right">Jenis :</td>
		                        	<td>
		                        		
		                        		<input name="kd_jenis2" id="kd_jenis2" style="width: 100px;" class="col-lg-1 form-control input-sm text-left" type="text" placeholder="jenis" value=""></td>
		                        	<td class="text-left">
		                        		<table width='60%'>
		                        			<td><label id='lbl_jenis' name='lbl_jenis' class="text-uppercase"></td>
		                        			<td style="width: 80%;"><button width='100%' type="button" id="btn-cetak_vcr" name="btn-cetak_vcr" class="btn btn-sm btn-success btn-block"><i class="fa fa-print"></i>&nbsp;&nbsp;&nbsp;Voucher</button></td>
		                        			<td style="width: 80%;"><!--button width='100%' type="button" id="btn-add-row" name="btn-add-row" class="btn btn-sm btn-system btn-block"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;Tambah Baris</button--></td>
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
	                    	<table id="t_bank" name="t_bank" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
	                    		<thead>
		                            <tr class="bg-primary light bg-gradient">
		                                <!--th style="width: 8px;" class="text-center">#</th-->
		                                <th class="text-center">U R A I A N</th>
		                                <th class="text-center">ID TRX</th>
		                                <th class="text-center">KODE BANK</th>
		                                <th class="text-center">NOMOR REKENING</th>
		                                <th class="text-center">KODE CUSTOMER</th>
		                                <th class="text-center">STATUS</th>
		                                <th class="text-center">NO RESERVE</th>
		                                <th class="text-center">NO KUITANSI</th>
		                                <th class="text-center">RUPIAH</th>
		                                <th style="width: 60px;" class="text-center"></th>
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
	</section>
</form>