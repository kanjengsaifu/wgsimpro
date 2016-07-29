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

	// init value
	<?php if(isset($data['id'])) { ?>
		$('#id').val('<?=$data['id']?>');
		$('#tanggal').val('<?=$data['xtanggal']?>');
		$('#no_po').val('<?=$data['no_po']?>');
		$('#kode_spk').val('<?=$data['kode_spk']?>');
		$('#kode_entity').val('<?=$data['kode_entity']?>');
		$('#kode_bpdp').val('<?=$data['kode_bpdp']?>');
		$('input[name="is_pkp"]').prop('checked', <?=$data['is_pkp']==='1'?'true':'false'?>);
		$('input[name="is_order"]').prop('checked', <?=$data['is_order']==='1'?'true':'false'?>);
		$('#no_unit').val('<?=$data['no_unit']?>');

		<?php 
		if(isset($data['sumberdayas'])) { 
			
			foreach ($data['sumberdayas'] as $k => $v) {
		?>
		$('#datatable-sd tbody').append(
			'<tr id="po_<?=$v['id']?>">'+
			'<input type="hidden" name="kode_sumberdaya[]" value="<?=$v['kode_sumberdaya']?>">'+
			'<input type="hidden" name="harga_satuan[]" value="<?=$v['harga_satuan']?>">'+
			'<input type="hidden" name="volume[]" value="<?=$v['volume']?>">'+
			'<input type="hidden" name="sd_id[]" value="<?=$v['po_id']?>">'+
			'<td class="text-center"><?=($k+1)?></td>'+
			'<td id="td_<?=$v['id']?>" style="cursor:pointer" onclick="show_child(<?=$v['id']?>)"><?=$v['nama']?></td>'+
			'<td class="input-numeric text-right"><?=$v['harga_satuan']?></td>'+
			'<td class="input-numeric text-right"><?=$v['volume']?></td>'+
			'<td style="cursor:pointer input-numeric text-right"><?php 
			foreach ($data["units"] as $ky => $vl) { 
				if($vl["sd_id"] == $v["id"]){
					echo $vl["no_unit"].", ";
				}else{
					echo "";
				}
			}?></td>'+
			'</tr>'+
			'<tr style="display:none" id="child_<?=$v['id']?>">'+
			'	<td colspan="5">'+
			'		<span id="bobot_child_<?=$v['id']?>"></span>'+
			'	</td>'+
			'</tr>'
		);
		$('.input-numeric').autoNumeric('init');
		<?php
			}
		} 
		?>
		$('.chosen-select').trigger('chosen:updated');
	<?php } ?>

	// event
	$('#kode_sumberdaya').on('change', function() {
		$('#harga_satuan').autoNumeric('set', $('#kode_sumberdaya option:selected').attr('data-harga'));
	});

	
 	var tampung = "";

	$('#btn-add-sd').click(function() {
		var tbody = $('#datatable-sd tbody'),
			nTR = tbody.find('tr').length;
			var foo = [];
			var str = "";
			if(nTR>1){
				nTR =nTR-1;
			}
			
		tbody.append(
			'<tr>'+
			'<input type="hidden" name="kode_sumberdaya[]" value="'+$('#kode_sumberdaya').val()+'">'+
			'<input type="hidden" name="harga_satuan[]" value="'+$('#harga_satuan').autoNumeric('get')+'">'+
			'<input type="hidden" name="volume[]" value="'+$('#volume').autoNumeric('get')+'">'+
			'<input type="hidden" name="sd_id[]" value="">'+
			'<td class="text-center">'+(nTR+1)+'</td>'+
			'<td>'+$('#kode_sumberdaya option:selected').text()+'</td>'+
			'<td class="input-numeric text-right">'+$('#harga_satuan').autoNumeric('get')+'</td>'+
			'<td class="input-numeric text-right">'+$('#volume').autoNumeric('get')+'</td>'+
			'<td class="input-numeric text-right">'+$('#no_unit option:selected' ).text()+'<div id="multi_unit" name="multi_unit"></div></td>'+
			'</tr>'
		);
		$('.input-numeric').autoNumeric('init');
		// reset detail
		$('#kode_sumberdaya').val('').chosen().trigger('chosen:updated');
		$('#harga_satuan').autoNumeric('set', 0);
		$('#volume').autoNumeric('set', 0);
	});
	$('#btn-submit').click(function() {
		// validasi
		var isValid = true;
		$.each($('.required'), function(index, item) {
			if($(this).val()=='')
				isValid &= false;
		});
		// --
		if(isValid){
			$.post(
				'<?=base_url()?>index.php/po/save',
				$('#form-input').serialize(),
				function(respon) {
					alert('Data tersimpan.');
					location.href = '<?=base_url()?>index.php/po';
				}
			);
		} else {
			alert('Data Belum Lengkap.\n*Wajib Diisi');
		}
	});

	

})

	function togel_child(no_unit)
	{
		$('#child_sub_fl_'+no_unit).toggle();
	}
	function show_child(parent){
		$('#fc_sdid').val(parent);
		//alert($('#fc_sdid').val());
		
		$('#child_'+parent).toggle();
		$('#bobot_child_'+parent).load('../f_unit/'+parent);
	}
    function load_child(parent){
    	$('#fc_sdid').val(parent);
        $('#bobot_child_'+parent).load('../f_unit/'+parent);
    }

    function delet(id,parent)
    {
    	//$('#fc_sdid').val(id);
        var answer = confirm("Anda yakin akan menghapus data ini?")
        if (answer){
            $.ajax({
                url:'<?="../d_unit/";?>'+id,
                type: 'POST',
                success:function(data){
                    if(parent==0){
                        window.location.reload();
                    }else{
                    	//alert(parent);
                    	$('#bobot_child_'+parent).load('../f_unit/'+parent);
                    	$(this).html(data);
                        //$('#bobot_child_fl_'+parent).load(parent);
                        //location.reload();
                        
                        $( "#td_"+parent ).click(function() {
					        console.log("orang utan...");

					        setTimeout(
					            function() {
					                //alert("Called after delay.");
					                $( "#td_"+parent ).click();
					            },
					            3000);
					    });
                    }
                }
            });
        }
    }
</script>