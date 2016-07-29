
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
		console.log(parent);
		console.log( $("#form-input input[name=fc_sdid]").val()+' :: '+$("#form-input input[name=no_po]").val() );
		$('#sdid').val($("#form-input input[name=fc_sdid]").val() );
		console.log('isinya:::'+$('#sdid').val() );
		if($("#nounit").val()!='')
		{ 
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
	font-size: 10px;
    color: red;
    font-weight: bold;
}
.tabel {
	font-size: 10px;
}
.trx_empty{
	font-size: 10px;
    color: black;
    font-weight: bold;
}
.not_balance{
	font-size: 10px;
    color: red;
    font-weight: bold;
}
.balance{
	font-size: 10px;
    color: green;
    font-weight: bold;
}
</style>

	<table id="t_dataupload" width='20%' class="control-label table tabel table-striped table-bordered table-hover">
		<tr>
			<th width='3%' align='center'>#</th>
			<!--th align='center'>JENIS</th-->
			<th align='center'>C O A</th>
			<th align='center'>DIVISI</th>
			<th align='center'>TANGGAL</th>
			<th align='center'>NO BUKTI</th>
			<th align='center'>NO TERBIT</th>
			<th align='center'>NASABAH</th>
			<th align='center'>SUMBERDAYA</th>
			<th align='center'>SPK</th>
			<th align='center'>TAHAP</th>
			<th align='center'>NO INVOICE</th>
			<th align='center'>NO FAKTUR</th>
			<th align='center'>BUKTI POTONG</th>
			<th align='center'>VOLUME</th>
			<th align='center'>URAIAN</th>
			<th align='center'>D/K</th>
			<th align='center'>RP</th>
			<th align='center'></th>
		</tr>
	
	<?php 
	$this->load->helper('combo');
	$this->load->helper('tglbil');
	$kode_spk = $this->session->userdata('kode_entity');
	if ($num > 0){	
		$count	= 0;
		$fail = 1;
		foreach($query as $row)
		{
			$count++;
			// MANDATORY :
			// tahap, sbdy, nasabah, fakturpajak, kdbank
		?>
		<tr id="tr_<?=$row->tid; ?>">
			<td align='center' width="3%"><?php echo $count; ?></td>
			<td align='left'> <?=(cek_KodeCOA($row->kode_coa)==true?'<input type="hidden" id="kdcoa_false[]" class="kdcoa_false" value="0">'.$row->kode_coa:'<input type="hidden" id="kdcoa_false[]" class="kdcoa_false" value="1">'.$row->kode_coa); ?> </td>
            <td align='left'> <?=($row->kode_divisi==''?'':$row->kode_divisi)?> </td>
            <td align='left'> <?=($row->tanggal==''?'':tgl_indo($row->tanggal,'/')) ?> </td>
            <td align='left'> <?=($row->no_bukti==''?set_ExistNoBuktiIfThere($row->no_bukti).'<input type="hidden" id="nobuk_false[]" class="nobuk_false" value="1">':set_ExistNoBuktiIfThere($row->no_bukti).$row->no_bukti); ?> </td>
            <td align='left'> <?=($row->no_terbit==''?'':$row->no_terbit); ?> </td>
            <td align='left'> <?=($row->nasabah==0?'<input type="hidden" id="nsb_false[]" class="nsb_false" value="0">'.$row->kode_nasabah:'<input type="hidden" id="nsb_false[]" class="nsb_false" value="1">'.$row->kode_nasabah); ?> </td>
            <td align='left'> <?=($row->sumberdaya==0?'<input type="hidden" id="sbd_false[]" class="sbd_false" value="0">':'<input type="hidden" id="sbd_false[]" class="sbd_false" value="1">'.$row->sumberdaya); ?> </td>
            <td align='left'> <?=($row->kode_spk==KODESPK?'<input type="hidden" id="spk_false[]" class="spk_false" value="0">'.$row->kode_spk:'<input type="hidden" id="spk_false[]" class="spk_false" value="1"><span class="trx_exist">'.$row->kode_spk.'</span>'); ?> </td>
            <td align='left'> <?=($row->tahap==0?'<input type="hidden" id="tahap_false[]" class="tahap_false" value="0">'.$row->kode_tahap:'<input type="hidden" id="tahap_false[]" class="tahap_false" value="1">'.$row->kode_tahap); ?> </td>
            <td align='left'> <?=($row->no_invoice==''?'':$row->no_invoice); ?> </td>
            <td align='left'> <?=($row->pajak==0?'<input type="hidden" id="pajak_false[]" class="pajak_false" value="0">'.$row->kode_faktur:'<input type="hidden" id="pajak_false[]" class="pajak_false" value="1">'.$row->kode_faktur); ?> </td>
            <td align='left'> <?=($row->bukti_potong==''?'':$row->bukti_potong); ?> </td>
            <td align='left'> <?=($row->volume==''?'':$row->volume); ?> </td>
            <td align='left'> <?=($row->uraian==''?'<input type="hidden" id="uraian_false[]" class="uraian_false" value="0">':'<input type="hidden" id="uraian_false[]" class="uraian_false" value="1">'.$row->uraian); ?> </td>
            <td align='left'> <?=($row->dk=='D'?'D':'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;K'); ?> </td>
            <td align='left'> <?=($row->rupiah==''?'<input type="hidden" id="rupiah_false[]" class="rupiah_false" value="0">':'<input type="hidden" id="rupiah_false[]" class="rupiah_false" value="1">'.$row->rupiah) ?> </td>
            <td align='center' width="10%">
				<?=($row->IS_BALANCE=='BALANCE'?'<input type="hidden" id="balance_false[]" class="balance_false" value="0">'.'<span class="balance">Balance</span>':'<input type="hidden" id="balance_false[]" class="balance_false" value="1">'.'<span class="not_balance">Not Balance</span>'); ?>,<br>
				<?=($row->IS_EXIST=='PASSED'?'<span class="trx_empty">Blm ada TRX</span>':'<a href="#" class="trx_exist">Sudah Ada TRX</a>'); ?>
				
			</td>
		</tr>
		
		<?php
		}
		?>
		
		<?php
	} else { 
	?>
	<tr id="tr_1111">
			<td align='center' width="3%"></td>
            <td align='left' width="87%"><center>Tidak ada data unit untuk ditampilkan pada Sumberdaya diatas.</center> </td>
            <td align='center' width="10%">
				<!--a style="cursor:pointer" class="row-edit" ><span class="glyphicons glyphicons-edit"></span></a-->
				&nbsp;&nbsp;&nbsp;
				<!--a style="cursor:pointer"  class="row-delete"><span class="glyphicons glyphicons-bin"></span></a-->
			</td>
		</tr>
		<!--form child is loaded here-->
		<tr  id='child_sub_fl_1111'>
			<td align='center' width="3%"></td>
			<td class='f_child' colspan='2'>
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
		<tr id='child_sub_button'>
			<td colspan='4'>
				<button type="button" id="btn-proses" class="btn btn-primary btn-gradient dark btn-block text-center"><b>Proses</b></button>
			</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
	</table>
	
<script type="text/javascript" src="<?=base_url()?>assets/vendor/jquery/jquery_ui/jquery-ui.min.js"></script>
    <script type="text/javascript">
    	jQuery(document).ready(function() {
    		var t_coa = 0;
    		var t_mnas = 0;
    		var t_tahap =0; 
    		var t_sbd =0; 
    		var t_pajak =0; 
    		var t_bank = 0;
    		var total = 0;
    		var t_spk = 0;
    		var balance = 0;

		    $('.kdcoa_false').each(function (index, element) {
		        t_coa = t_coa + parseFloat($(element).val());
		    });
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
		    //KODE SPK sementara REMARK, tapi untuk di PROYEK HARUS DIAKTIFKAN
		    $('.spk_false').each(function (index, element) {
		        t_spk = t_spk + parseFloat($(element).val());
		    });
		    $('.balance_false').each(function (index, element) {
		        balance = balance + parseFloat($(element).val());
		    });
		    /*$('.bank_false').each(function (index, element) {
		        t_bank = t_bank + parseFloat($(element).val());
		    });*/
    		total = t_coa+t_bank+t_mnas+t_sbd+t_tahap+t_pajak+t_spk+balance;
    		//alert(total);
    		if(total>=1) {
    			alert('PERHATIAN !!\n\nKolom yang Tidak Dapat Diproses adalah \n ' 
    									+'- Kode Akun/COA: '+t_coa+' baris salah/wajib isi, \n '
    									+'- Kode Nasabah: '+t_mnas+' baris salah/wajib isi, \n '
    									+'- Kode Tahap: '+t_tahap+' baris salah/wajib isi \n '
    									+'- Faktur Pajak: '+t_pajak+' baris salah/wajib isi \n '
    									+'- Sumberdaya: '+t_sbd+' baris salah/wajib isi \n '
    									+'- Kode SPK: '+t_spk+' baris salah/tidak sesuai\n '
    									+'- Balance: '+balance+' baris Tidak Balance \n\n'
    									+'Pastikan kolom mandatory tidak boleh kosong, Nomor Bukti & Saldo Debit Kredit harap diperhatikan.\nHarap Perbaiki File Excel anda/Hubungi administrator anda untuk bantuan.\n');//\n - Kode Bank: '+t_bank+' error');
				$("#btn-proses").attr("disabled", "disabled");
				$("#btn-proses").on('click',function(){
					alert('tes1');
				});
			}else{
				$("#btn-proses").removeAttr('disabled');
				$("#btn-proses").on('click',function(){
					var answer = confirm("Lanjutkan ke proses Transaksi Jurnal?\n(data existing akan direplace)")
			        if (answer){
			            $.ajax({
			                url:'trx_upload',
			                data: { uid: "<?=$this->session->userdata('usernm')?>"},
			                type: 'POST',
			                success:function(response){
			                	//alert(response.res);
			                	if(response.res=='true'){
			                		alert(response.pesan);
			                		window.location.assign('upload')
			                	}else{
			                		alert(response.pesan);
			                		location.reload();
			                	}
			                   	/*if(parent==0){
			                        window.location.reload();
			                    }else{
			                    	//alert(parent);
			                    	$('#bobot_child_'+parent).load('../f_unit/'+parent);
			                    	$(this).html(response);
			                        $('#bobot_child_fl_'+parent).load(parent);
			                        location.reload();
			                    }*/
			                }
			            });
			        }
				});
				
			}
		    
		   
		});
    </script>