<style>
#id_confrmdiv
{
    display: none;
    background-color: #eee;
    border-radius: 5px;
    border: 1px solid #aaa;
    position: fixed;
    width: 300px;
    left: 50%;
    margin-left: -150px;
    padding: 6px 8px 8px;
    box-sizing: border-box;
    text-align: center;
}
#id_confrmdiv .button {
    background-color: #ccc;
    display: inline-block;
    border-radius: 3px;
    border: 1px solid #aaa;
    padding: 2px;
    text-align: center;
    width: 80px;
    cursor: pointer;
}
#id_confrmdiv .button:hover
{
    background-color: #ddd;
}
#confirmBox .message
{
    text-align: left;
    margin-bottom: 8px;
}
</style>
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
		<!--
			
<div id="id_confrmdiv">Data sudah benar, apakah anda yakin akan melakukan replace data?
    <button id="id_truebtn">Yes</button>
    <button id="id_falsebtn">No</button>
</div>
    
		-->
        <div class="col-md-12 pn">
            <div class="panel mbn">
                <div class="panel-body"> 
                	<form class="form-horizontal" id="transf"  action="http://203.153.218.86/index.php/porta" method="POST" enctype="multipart/form-data">
					
                        <input type="hidden" name="kode_entity" id="kode_entity" value="<?=$this->session->userdata('kode_entity')?>"/>
                        <div class="form-group">
                            <label class="col-lg-1 control-label">Periode&nbsp;<span class="text-danger">*</span></label>
                            
                            <div class="col-lg-1">
                                <input type="text" id="periode" name="periode" class="form-control input-sm input-date" value="<?=date('m-Y')?>"> 
                            </div>
							<div class="col-lg-2">
                                <input type="file" id="transfile" name="transfile" class="form-control input-sm input-date"> 
								<span class="help-block">File dengan ekstensi .csv </span>
                            </div>
							<div class="col-lg-1"> 
								<div id="tombolkirim"></div> 
                            </div>
                             
                						
                        </div>
					</form>	
					 
                </div>
            </div>
							<div style="clear:both"></div>
        </div>
        <div class="col-md-12 pn">
            <div class="panel mbn">
                <div class="panel-body">
						<div class="form-group"> 
                             
								<div id="id_confrmdiv">Data sudah benar, apakah anda yakin akan melakukan replace data?
									<button id="id_truebtn">Yes</button>
									<button id="id_falsebtn">No</button>
								</div> 	
                						
                        </div>			
				<div id="csvimporthint2" style="width: 100%; height: 120px; display:none; overflow-y: auto;"></div>
					<!--div id="answer"></div-->
                </div>
            </div>
        </div>
    </div>

	<div class="row">
	
    
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