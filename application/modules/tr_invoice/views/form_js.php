<script type="text/javascript">
jQuery(document).ready(function() {
	// init component / plugin
	$('.chosen-select').chosen({
		width: '100%',
	});
	$('.chosen-select').val('').chosen().trigger('chosen:updated');
	$('.input-numeric').autoNumeric('init');
	$('.input-date').datetimepicker({
		pickTime: false,
		format: 'DD/MM/YYYY'
	});

	$('#bapb_asal').hide();

	$('#asal_invoice').change(function()
	{
		if($(this).val()=="SPK"){
			//alert('hide bapd');
			$('#bapb_asal').hide();
		}else{
			//alert('show bapd');
			$('#bapb_asal').show();
		}
	});

	<?php if(isset($data['id'])) { ?>
		
		$('#id').val('<?=$data['id']?>');
		$('#kode_entity').val('<?=$data['kode_entity']?>');
		$('#no_invoice').val('<?=$data['no_invoice']?>');
		$('#asal_invoice').val('<?=$data['asal_invoice']?>');
		$('#tanggal').val('<?=$data['xtanggal']?>');
		$('input[name="is_um"]').prop('checked', <?=$data['is_um']==='1'?'true':'false'?>);
		$('input[name="is_pkp"]').prop('checked', <?=$data['is_pkp']==='1'?'true':'false'?>);
		$('#no_po').val('<?=$data['no_po']?>');
		$('#kode_rekanan').val('<?=$data['kode_rekanan']?>');
		$('#no_surat_jalan').val('<?=$data['no_surat_jalan']?>');
		$('#tgl_surat_jalan').val('<?=$data['xtgl_surat_jalan']?>');
		$('#no_bapb').val('<?=$data['no_bapb']?>');
		$('#tgl_bapb').val('<?=$data['xtgl_bapb']?>');
		$('#kode_bpdp').val('<?=$data['kode_bpdp']?>');
		$('#rp').autoNumeric('set', <?=$data['rp']?>);
		$('#pph').autoNumeric('set', <?=$data['pph']?>);
		$('#ppn').autoNumeric('set', <?=$data['ppn']?>);

		//alert('no_po: '+"<?=$data['no_po']?>"+'**'+$('#no_po').val());
		if($('#asal_invoice').val()=='SPK')
		{
			$('#bapb_asal').hide();
		}else{
			//alert('show bapd');
			$('#bapb_asal').show();
		}
		<?php

			if(isset($data['sumberdayas'])) 
			{
				foreach ($data['sumberdayas'] as $k => $v)
				{
		?>
					$('#datatable-sd tbody').append(
						'<tr id="sdtr_<?=$v['id']?>">'+
							'<input type="hidden" name="kode_sumberdaya[]" value="<?=$v['kode_sumberdaya']?>">'+
							'<input type="hidden" name="harga_satuan[]" value="<?=$v['volume']?>">'+
							'<input type="hidden" name="volume[]" value="<?=$v['harga_satuan']?>">'+
							'<td class="text-center"><?=($k+1)?></td>'+
							'<td><?=$v['nama']?></td>'+
							'<td class="input-numeric text-right"><?=$v['volume']?></td>'+
							'<td class="input-numeric text-right"><?=$v['harga_satuan']?></td>'+
							'<td class="input-numeric text-center"><a style="cursor:pointer" class="row-deletex" data-id="<?=$v['id']?>" href="javascript:delete_row(<?=$v['id']?>)" ><span class="glyphicons glyphicons-bin"></span></a></td>'+
						'</tr>'
					);
					$('.input-numeric').autoNumeric('init');
		<?php
				}
			}

		?>

		//update ke combo chosen
		$('.chosen-select').trigger('chosen:updated');
	<?php } ?>
		// event
		$('#kode_sumberdaya').on('change', function() {
			$('#harga_satuan').autoNumeric('set', $('#kode_sumberdaya option:selected').attr('data-harga'));
		});

		$('#btn-add-sd').click(function() {
			if($('#kode_sumberdaya').val()!=='') {
				var isValid = true;
				$.each($('.required'), function(index, item) {
					if($(this).val()=='')
						isValid &= false;
				});
				if(isValid){
					var tbody = $('#datatable-sd tbody'),
						nTR = tbody.find('tr').length;
						var foo = [];
						var str = "";
						if(nTR>1){
							nTR =nTR-1;
						}
						tbody.append(
							'<tr id="sd_'+(nTR+1)+'">'+
								'<input type="hidden" name="kode_sumberdaya[]" value="'+$('#kode_sumberdaya').val()+'">'+
								'<input type="hidden" name="harga_satuan[]" value="'+$('#harga_satuan').autoNumeric('get')+'">'+
								'<input type="hidden" name="volume[]" value="'+$('#volume').autoNumeric('get')+'">'+
								'<td class="text-center">'+(nTR+1)+'</td>'+
								'<td>'+$('#kode_sumberdaya option:selected').text()+'</td>'+
								'<td class="input-numeric text-right">'+$('#harga_satuan').autoNumeric('get')+'</td>'+
								'<td class="input-numeric text-right">'+$('#volume').autoNumeric('get')+'</td>'+
								'<td class="input-numeric text-center"><a style="cursor:pointer" class="row-deletex" data-id="'+(nTR+1)+'" href="javascript:delete_row()" ><span class="glyphicons glyphicons-bin"></span></a></td>'+
							'</tr>');
				}
				$('.input-numeric').autoNumeric('init');
				// re-calculate sum val
				$('#rp').autoNumeric('set', 
					parseFloat($('#rp').autoNumeric('get'))+
					(parseFloat($('#harga_satuan').autoNumeric('get'))*parseFloat($('#volume').autoNumeric('get'))));
				// reset detail
				$('#kode_sumberdaya').val('').chosen().trigger('chosen:updated');
				$('#harga_satuan').autoNumeric('set', 0);
				$('#volume').autoNumeric('set', 0);
			}
		});

		$('#btn-submit').click(function() {
			// validasi
			var isValid = true;

			var d = new Date();
			var bul = d.getMonth();
			var har = d.getDate();
			var tglbapb = har+'/'+bul+'/'+d.getFullYear();
			if($('#bapb_asal').css('display')=='none')
				$('#no_bapb').val(0);
				$('#tgl_bapb').val(tglbapb);

			$.each($('.required'), function(index, item) {
				if($(this).val()=='')
						isValid &= false;
					
			});
			// --
			if(isValid){
				$.post(
					'<?=base_url()?>index.php/invoice/save',
					$('#form-input').serialize(),
					function(respon) {
						alert('Data tersimpan.');
						location.href = '<?=base_url()?>index.php/invoice';
					}
				);
			} else {
				alert('Data Belum Lengkap.\n*Wajib Diisi');
			}
		});

		//ubah label kolom dibawahnya
		$('#ckis_um-1').change(function() {
			$('#lbl-title').text('Nilai Invoice');
				if($(this).prop('checked')) {
					$('#lbl-title').text('Nilai Uang Muka');
				}
		});
		$('body').on('click', '.row-delete', function() {
			
			var id = $(this).attr('data-id');
			//alert(id);
			if(confirm('Anda yakin ingin menghapus data ini?')) {
				if(id!=null){
					$.post('<?=base_url()?>index.php/invoice/delete_sd/'+id, function(res) {
						if(res.response==='1')
						{
							alert('Sumberdaya tersebut berhasil dihapus.');
							location.reload();
						}else{
							alert('Data gagal dihapus, mohon diperiksa.');
						}
					});
				}else{
					$("#datatable-sd .deleteLink").on("click",function() {
				        var tr = $(this).closest('tr');
				        tr.css("background-color","#FF3700");

				        tr.fadeOut(400, function(){
				            tr.remove();
				        });
				      return false;
				    });
		    		alert('This row was deleted.');
				}
				
			}
		});

}); //End of jQuery

	function delete_row(id)
    {
    	if(confirm("Anda yakin akan menghapus data ini?")) {
	    	if(id!=null){
	    		//alert('delete id: '+id);
	    		$.post("<?=base_url()?>index.php/invoice/delete_sd/"+id,function(ev) {
					if(ev.response==='1') {
						alert('Sumberdaya tersebut berhasil dihapus.');
						//location.href = "<?=base_url()?>index.php/po/edit/";
						location.reload();
					} else {
						alert('Data gagal dihapus, mohon diperiksa.');
					}
				});
	    	}else{
	    		$("#datatable-sd .row-deletex").on("click",function() {
			        var tr = $(this).closest('tr');
			        tr.css("background-color","#FF3700");

			        tr.fadeOut(100, function(){
			            tr.remove();
			        });
			      return false;
			    });
	    		
	    	}
	    }
    }
</script>