<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/assets/skin/default_skin/css/theme.css">
<script type="text/javascript">

	function _simpan(parent)
	{
		
		$('#add_unit_'+parent).click(function() {
			// validasi
			var isValid = true;
			$.each($('.required'), function(index, item) {
				if($(this).val()=='')
					isValid &= false;
			});
			// --

			if($("#nounit").val()!=''){//isValid){
				$.post(
					'<?=base_url()?>index.php/po/ad_unit',
					$('#f_unit_child_'+parent).serialize(),
					function(respon) {
						alert('Data tersimpan.');
						//location.href = '<?=base_url()?>index.php/po';
						$( "#td_"+parent ).click();

					}
				);
			} else {
				alert('Data Belum Lengkap.\n*Wajib Diisi');
			}
		});
	}

	function simpan(parent)
	{
		alert(parent);
		alert($("#form-input input[name=fc_sdid]").val()+' :: '+$("#form-input input[name=no_po]").val());
		$('#sdid').val($("#form-input input[name=fc_sdid]").val());
		alert('isinya:::'+$('#sdid').val());
		if($("#nounit").val()!='')
		{//isValid){
			$.post(
				'<?=base_url()?>index.php/po/ad_unit',
				$('#f_unit_child_'+parent).serialize(),
				function(respon) {
					alert('Data tersimpan.');
					//location.href = '<?=base_url()?>index.php/po';
					$( "#td_"+parent ).click();
					$( "#td_"+parent ).click();
				}
			);
		} else {
			alert('Data Belum Lengkap.\n*Wajib Diisi');
		}
	}
</script>
<style>
.trx_exist {
    color: red;
    font-weight: bold;
}
.trx_empty{
    color: black;
    font-weight: bold;
}
.not_balance{
    color: red;
    font-weight: bold;
}
.balance{
    color: green;
    font-weight: bold;
}
</style>
	<table id="t_child" width='20%' class="table table-striped table-bordered table-hover">
		<tr>
			<th width='3%' align='center'>#</th>
			<th align='center'>TANGGAL</th> 
			<th align='center'>NO BUKTI</th>
			<th align='center'>DESKRIPSI</th>
			<th align='center'>DEBIT</th>
			<th align='center'>KREDIT</th>
			<th align='center'>SALDO</th>
		</tr>
	
	<?php 
	$this->load->helper('combo');
	$this->load->helper('tglbil');
	if ($num > 0){	
		$count	= 0;
		$fail = 1;
		$sa = 0;
		$debit = 0;
		$kredit = 0;
		$saldo = 0;
		//$sa = $saldo_awal->saldo;
		//var_dump($saldo_awal);
		foreach ($saldo_awal as $k => $v) {
			$sal[] = $v;
		}
		//var_dump($sal[5]);
		$sa_awal = $sal[5];
		foreach($query as $row)
		{
			$count++;
			// MANDATORY :
			// tahap, sbdy, nasabah, fakturpajak, kdbank
			$debit +=($row->dk=='D'?$row->rupiah:0);
			$kredit +=($row->dk=='K'?$row->rupiah:0);
			$saldo = $sa_awal+$debit-$kredit;
		?>
		<tr>
			<td align='center' width="3%"><?php echo $count; ?></td>
			<td align='left'> <?=$row->tanggal?> </td>
            <td align='left'> <?=$row->no_bukti?> </td>
            <td align='left'> <?=$row->uraian?> </td>
            <td align='right'> <?=($row->dk=='D'?number_format($row->rupiah,0):0)?> </td>
            <td align='right'> <?=($row->dk=='K'?number_format($row->rupiah):0)?> </td>
            <td align='right'> <?=number_format($saldo)?> </td>
		</tr>
		
		<?php
		}
		?>
		
		<?php
	} else { 
	?>
	<tr id="tr_1111">
			<td align='center' width="3%"></td>
            <td align='left' width="87%" colspan="5"><center>Tidak ada data unit untuk ditampilkan pada COA diatas.</center> </td>
            <td align='center' width="10%">
				<!--a style="cursor:pointer" class="row-edit" ><span class="glyphicons glyphicons-edit"></span></a-->
				&nbsp;&nbsp;&nbsp;
				<!--a style="cursor:pointer"  class="row-delete"><span class="glyphicons glyphicons-bin"></span></a-->
			</td>
		</tr>
		<!--form child is loaded here-->
		<tr  id='child_sub_fl_1111'>
			<td align='center' width="3%"></td>
			<td class='f_child' colspan='6'>
				<form id="f_unit_child_1111" action="javascript:">
				<input type="hidden" name="sdid" id="sdid" value="">
				<input type="hidden" name="sdpo" id="sdpo" value="">     
				</form>
				<button id="add_unit_1111; ?>" onclick="simpan(1111)"><span class="fa fa-plus">&nbsp;Tambah</span></button>
			</td>
		</tr>
	<?php
}
	?>
	</table>
	
<script type="text/javascript" src="<?=base_url()?>assets/vendor/jquery/jquery_ui/jquery-ui.min.js"></script>
    <script type="text/javascript">
    	jQuery(document).ready(function() {
    		
    		var t_mnas = 0;
    		var t_tahap =0; 
    		var t_sbd =0; 
    		var t_pajak =0; 
    		var t_bank = 0;
    		var total = 0;

		    $('.nsb_false').each(function (index, element) {
		        t_mnas = t_mnas + parseFloat($(element).val());
		    });
		    $('.tahap_false').each(function (index, element) {
		        t_tahap = t_tahap + parseFloat($(element).val());
		    });
		    $('.pajak_false').each(function (index, element) {
		        t_pajak = t_pajak + parseFloat($(element).val());
		    });
		    $('.sbd_false').each(function (index, element) {
		        t_sbd = t_sbd + parseFloat($(element).val());
		    });
		    /*$('.bank_false').each(function (index, element) {
		        t_bank = t_bank + parseFloat($(element).val());
		    });*/
    		total = t_bank+t_mnas+t_sbd+t_tahap+t_pajak;
    		if(total>1) {
    			alert('Kolom yang tak dapat diproses adalah \n - Kode Nasabah:'+t_mnas+' baris error, \n - Kode Tahap: '+t_tahap+' baris error \n - Faktur Pajak: '+t_pajak+' baris error \n - Sumberdaya: '+t_sbd+' baris error \n\nPastikan kolom mandatory tidak boleh kosong / File Excel harus diperbaiki!\n');//\n - Kode Bank: '+t_bank+' error');
				$("#btn-proses").attr("disabled", "disabled");
			}else{
				$("#btn-proses").removeAttr('disabled');
				/*var answer = confirm("Lanjutkan ke proses Transaksi Jurnal?\n(data existing akan direplace)")
		        if (answer){
		            $.ajax({
		                url:'trx_upload',
		                data: { uid: "<?=$this->session->userdata('usernm')?>"},
		                type: 'POST',
		                success:function(data){
		                	alert(data);
		                    //if(parent==0){
		                    //    window.location.reload();
		                    //}else{
		                    	//alert(parent);
		                    	//$('#bobot_child_'+parent).load('../f_unit/'+parent);
		                    //	$(this).html(data);
		                        //$('#bobot_child_fl_'+parent).load(parent);
		                        //location.reload();
		                        
		                   // }
		                }
		            });
		        }*/
			}
		    
		   
		});
    </script>