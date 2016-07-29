<?php
    /*get kode_entity from session */
    $kode_entity = $this->session->userdata('kode_entity');
?>
<!-- Begin: Content -->
<section id="content">

    <div class="row">
        <div class="col-md-12 pn">
            <div class="panel">
                <div class="panel-body">
                	<!--form class="form-horizontal" role="form" action="javascript:" id="form-input"-->
                	<form class="form-horizontal" role="form" method="POST" action="" id="form-input">
                		<input type="hidden" name="id" id="id"/>
                        <input type="hidden" name="kode_entity" id="kode_entity" value="<?php echo $kode_entity;?>"/>
                         <div class="form-group">
                            <label class="col-lg-1 control-label">Periode&nbsp;<span class="text-danger">*</span></label>
                            <div class="col-lg-1">
                                <input type="text" name="periode" id="periode" class="form-control input-sm input-date" value="<?=date('Y-m')?>">
                                
                            </div>
                            <div class="col-lg-2">
                                <!--button type="button" id="btn-submit" class="btn btn-sm btn-primary btn-gradient dark btn-block">Submit</button-->
                                <input type="submit" id="btn-submit" class="btn btn-sm btn-primary btn-gradient dark btn-block" value="Submit">
                            </div> 
						</div>
                   
                	</form>
                </div>
            </div>
        </div>
    </div>

</section>
<?php
	if(isset($_POST['periode'])){
		$periode1=$_POST['periode'];
		$kode_entity=$_POST['kode_entity'];
		
		$periode=explode("-",$periode1);
		$tahun=$periode[0];
		$bulan=intval($periode[1]);
		
		
		if($tahun%4 == 0){
			$hari=Array("","31","29","31","30","31","30","31","31","30","31","30","31");
		}else{
			$hari=Array("","31","28","31","30","31","30","31","31","30","31","30","31");
		}

		$periode1=$periode1."-".$hari[$bulan];
		
		//echo "<script>window.open('".base_url()."index.php/tahap/rpt-ra-ri/".$periode1."');</script>";
		echo "<script>window.open('".base_url()."index.php/tahap/rpt-ra-ri/".$periode1."/".$kode_entity."');</script>";
	}
?>
<!-- End: Content -->