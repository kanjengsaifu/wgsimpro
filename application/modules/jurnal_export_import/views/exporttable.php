<!-- Begin: Content -->
<section id="content">
<div class="row">
        <div class="col-md-12 pn">
            <div class="panel mbn">
                <div class="panel-body"> 
					<div style="text-transform:UPPERCASE">Generate File Export</div>
				</div>
			</div>
		</div>
        <div class="col-md-12 pn">
            <div class="panel mbn">
                <div class="panel-body"> 
                	<form class="form-horizontal" role="form" action="javascript:" id="form-input">
                        <input type="hidden" name="kode_entity" id="kode_entity" value="<?=$this->session->userdata('kode_entity')?>"/>
                        <div class="form-group">
                            <label class="col-lg-1 control-label">Periode&nbsp;<span class="text-danger">*</span></label>
                            <div class="col-lg-1">
                                <input type="text" id="periode" class="form-control input-sm input-date" value="<?=date('m/Y')?>">
                                
                            </div>
                            <div class="col-lg-2">
                                <button type="button" id="btn-submit" class="btn btn-sm btn-primary btn-gradient dark btn-block">Submit</button>
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
								<th>Tanggal Generate</th>
								<!--th>Tanggal Export</th>	
								<th>Status</th-->	
								<th><center>Action</center></th>	 
							</tr>
						</thead>
						
						<div id="answer">
						<tbody>
						<?php 
							foreach($data['listexport'] as $t => $dt){
								echo "<tr>";
								echo "<td>".$dt['periode']."</td>"; 
								echo "<td>".$dt['tgl_generate']."</td>"; 
								/*if($dt['tgl_export']=="0000-00-00 00:00:00"){
									echo "<td>-</td>"; 
								}else{
									echo "<td>".$dt['tgl_export']."</td>"; 
								}
								if($dt['status']=="0"){
									echo "<td>Belum Upload</td>"; 
								}else{
									echo "<td>Terkirim</td>"; 
								}*/
								
								if($dt['status']=="0"){
									//echo '<td><button type="button" id="tranfi-'.$dt['id_export'].'" onClick="transfer('.$dt['id_export'].',\''.$dt['namafile'].'\',\''.$dt['periode'].'\',\''.$dt['kode_entity'].'\')" class="btn btn-sm btn-primary btn-gradient dark btn-block">Transfer File</button></td>'; 
									echo '<td><a href="'.base_url().'assets/generate/'.$dt['namafile'].'"><button type="button" id="tranfi-'.$dt['id_export'].'" class="btn btn-sm btn-primary btn-gradient dark btn-block">Download File</button></a></td>'; 
									//echo '<td><a href="./../../application/assets/generate/'.$dt['namafile'].'"><button type="button" id="tranfi-'.$dt['id_export'].'" class="btn btn-sm btn-primary btn-gradient dark btn-block">Transfer File</button></a></td>'; 
								}else{
									echo "<td>&nbsp;</td>"; 
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