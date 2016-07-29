<!-- Begin: Content -->
<script>
	var fld=[];
	var opt=[];
	var src_key=[];
	var ordfld=[];
	var ordopt=[]; 
	
</script>
<section id="content">


    <form  role="form" action="javascript:">
	<div class="row">
        <div class="col-md-12 pn">
            <div class="panel mbn">
                <div class="panel-body">
					<div class="form-group">
                            <label class="col-lg-12 control-label" style="text-transform:uppercase;">Pencarian Jurnal&nbsp;</label>
                    </div>
					

					<div style="clear:both"></div>
					
					<div class="input_fields_wrap">
						<div class="form-group">
								<div class="col-lg-2">
									<select name="fld[]" id="data0" class="form-control" onchange="fldChange(data0,0)">
										<option value=""></option>
										<option value="no_bukti">No. Bukti</option>
										<option value="tanggal">Tanggal</option>
										<option value="kode_coa">CoA</option>
										<option value="kode_nasabah">Nasabah</option>
										<option value="kode_customer">Customer</option>
										<option value="kode_sumberdaya">Sumberdaya</option>
										<option value="kode_spk">SPK</option>
										<option value="kode_tahap">Tahap</option>
										<option value="no_invoice">No. Invoice</option>
										<option value="kode_faktur">Kode Faktur</option>
										<option value="volume">Volume</option>
										<option value="dk">DK</option>
									</select>									
								</div>
								<div class="col-lg-2">
									<div id="optv0">
										<select name="opt[]" class="form-control">
											<option value=""></option>										
										</select>
									</div>
								</div>
								<div class="col-lg-3">
									<span id="srcv0">
										<input type="text" name="src_key[]" value="" class="form-control"/> 										
									</span> 
								</div> 
						</div>
						<div style="clear:both"></div>
					</div>
					
					<div style="clear:both;padding-top:15px;"></div>
						<div class="form-group">
							<div class="col-lg-1">
								<button class="add_field_button btn btn-sm btn-warning btn-gradient dark btn-block">Tambah</button>
							</div>
						</div>
					<div style="clear:both"></div>
					<div style="height:20px;"></div>
					<div class="form-group">
                            <label class="col-lg-12 control-label" style="text-transform:uppercase;">Order By&nbsp;</label>
                    </div>
					<div style="clear:both"></div>
					<div class="form-group">
								<div class="col-lg-2">
									<select name="ordfld[]" class="form-control">
										<option value=""></option>
										<option value="no_bukti">No. Bukti</option>
										<option value="tanggal" selected>Tanggal</option>
										<option value="kode_coa">CoA</option>
										<option value="kode_nasabah">Nasabah</option>
										<option value="kode_customer">Customer</option>
										<option value="kode_sumberdaya">Sumberdaya</option>
										<option value="kode_spk">SPK</option>
										<option value="kode_tahap">Tahap</option>
										<option value="no_invoice">No. Invoice</option>
										<option value="kode_faktur">Kode Faktur</option>
										<option value="volume">Volume</option>
										<option value="dk">DK</option>
									</select>									
								</div>
								<div class="col-lg-1">
 										<select name="ordopt[]" class="form-control">
											<option value=""></option>										
											<option value="DESC">DESC</option>										
											<option value="ASC" selected>ASC</option>										
										</select>
 								</div>
								<div class="col-lg-2">
									<select name="ordfld[]" class="form-control">
										<option value=""></option>
										<option value="no_bukti" selected>No. Bukti</option>
										<option value="tanggal">Tanggal</option>
										<option value="kode_coa">CoA</option>
										<option value="kode_nasabah">Nasabah</option>
										<option value="kode_customer">Customer</option>
										<option value="kode_sumberdaya">Sumberdaya</option>
										<option value="kode_spk">SPK</option>
										<option value="kode_tahap">Tahap</option>
										<option value="no_invoice">No. Invoice</option>
										<option value="kode_faktur">Kode Faktur</option>
										<option value="volume">Volume</option>
										<option value="dk">DK</option>
									</select>									
								</div>
								<div class="col-lg-1"> 
									<select name="ordopt[]" class="form-control">
										<option value=""></option>										
										<option value="DESC" selected>DESC</option>										
										<option value="ASC">ASC</option>										
									</select>
								</div>
								<div class="col-lg-2">
									<select name="ordfld[]" class="form-control">
										<option value=""></option>
										<option value="no_bukti">No. Bukti</option>
										<option value="tanggal">Tanggal</option>
										<option value="kode_coa">CoA</option>
										<option value="kode_nasabah">Nasabah</option>
										<option value="kode_customer">Customer</option>
										<option value="kode_sumberdaya">Sumberdaya</option>
										<option value="kode_spk">SPK</option>
										<option value="kode_tahap">Tahap</option>
										<option value="no_invoice">No. Invoice</option>
										<option value="kode_faktur">Kode Faktur</option>
										<option value="volume">Volume</option>
										<option value="dk">DK</option>
									</select>									
								</div>
								<div class="col-lg-1"> 
									<select name="ordopt[]" class="form-control">
										<option value=""></option>										
										<option value="DESC">DESC</option>										
										<option value="ASC">ASC</option>										
									</select> 
								</div> 
						</div>
						<div style="clear:both"></div>
					
					<div style="clear:both;padding-top:15px;"></div>
						<div class="form-group">
							<div class="col-lg-1">
								<button class="btn btn-sm btn-primary btn-gradient dark btn-block" id="btn-viewjurnal">View Jurnal</button>
							</div>
						</div>
					<div style="clear:both"></div> 
				</div>
            </div>
        </div>
    </div>
	</form>
                    

    <div class="row">
        <div class="col-md-12 pn">
            <div class="panel">
	            <div class="row">	
	            	<div class="col-md-10">
						<p>&nbsp;</p>
					</div>
					<div class="col-md-2 text-right">
						<button id="exp2excel" name="exp2excel">Export To Excel</button>
					</div>
				</div>

                <div class="panel-body">
                    
                    <table class="table table-striped table-bordered table-hover export2excel" id="datatable" cellspacing="0" width="100%">
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
                        <tbody id="answer"> 
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</section>
<!-- End: Content -->