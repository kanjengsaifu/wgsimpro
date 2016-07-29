<!-- Begin: Content -->
<section id="content">
<div class="row">
        <div class="col-md-12 pn">
            <div class="panel mbn">
                <div class="panel-body"> 
					<div style="text-transform:UPPERCASE">Transfer Jurnal</div>
				</div>
			</div>
		</div>
        <div class="col-md-12 pn">
            <div class="panel mbn">
                <div class="panel-body"> 
                	<form class="form-horizontal" id="transf"  action="http://203.153.218.86/index.php/porta" method="POST" enctype="multipart/form-data">
					
                        <input type="hidden" name="kode_entity" id="kode_entity" value="<?=$this->session->userdata('kode_entity')?>"/>
                        <div class="form-group">
                            <label class="col-lg-1 control-label">Periode&nbsp;<span class="text-danger">*</span></label>
                            
                            <div class="col-lg-1">
                                <input type="text" id="periode" name="periode" class="form-control input-sm input-date" value="<?=date('m/Y')?>"> 
                            </div>
							<div class="col-lg-2">
                                <input type="file" id="transfile" name="transfile" class="form-control input-sm input-date"> 
								<span class="help-block">File dengan ekstensi .csv </span>
                            </div>
                            <div class="col-lg-1">
                                <input type="submit" id="btn-submit" class="btn btn-sm btn-primary btn-gradient dark btn-block" value="submit">
                            </div> 
                        </div>
                	</form>
                </div>
            </div>
        </div>
        <div class="col-md-12 pn">
            <div class="panel mbn">
                <div class="panel-body"> 
					<!--div id="answer"></div-->
                </div>
            </div>
        </div>
    </div>

	<div class="row">
		<div class="col-md-12-pn">
			<div class="panel">
				<div class="panel-body">
					<table class="table table-striped table-bordered table-hover" id="datatable" cellspacing="0" width="100%">
						<thead>
							<tr class="bg-primary light bg-gradient">
								<th>Periode</th>
								<th>Tanggal Transfer</th>
								<!--th>Tanggal Export</th-->	
								<th>Status</th>	
				 			</tr>
						</thead>
						
						<div id="answer">
						<tbody>
						<?php 
							foreach($data['listexport'] as $t => $dt){
								echo "<tr>";
								echo "<td>".$dt['periode']."</td>"; 
								echo "<td>".$dt['tgl_transfer']."</td>"; 
								/*if($dt['tgl_export']=="0000-00-00 00:00:00"){
									echo "<td>-</td>"; 
								}else{
									echo "<td>".$dt['tgl_export']."</td>"; 
								}*/
								if($dt['status']=="0"){
									echo "<td>Gagal Transfer</td>"; 
								}else{
									echo "<td>Transfer Berhasil</td>"; 
								}
			  					echo "</tr>";
							}
						?>
						</tbody>
						</div>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- End : Content -->