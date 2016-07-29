<script type="text/javascript">
jQuery(document).ready(function() {
	$('.chosen-select').chosen({
		width: '100%',
	});
	$('.chosen-select').val('').chosen().trigger('chosen:updated');
	$('.input-numeric').autoNumeric('init');
	
	$('#tgl_bapb').datetimepicker({
		pickTime: false,
		format: 'DD/MM/YYYY'
	});

	<?php if(isset($data['naskon']['id'])) { ?>
		$('#no_bapb').val('<?=$data['naskon']['no_bapb']?>');
		$('#id').val('<?=$data['naskon']['id']?>');
		$('#no_surat_jalan').val('<?=$data['naskon']['no_surat_jalan']?>');
		$('#kd_nasabah').val('<?=$data['naskon']['kdnasabah']?>').trigger('chosen:updated');
		$('#no_kontrak').val('<?=$data['naskon']['no_kontrak']?>').trigger('chosen:updated');
		$('#uraian').val('<?=$data['naskon']['uraian']?>');
		$('input[id="angkut1"]').prop('checked', <?=$data['naskon']['angkut_id']==='1'?'true':'false'?>);
		$('input[id="angkut2"]').prop('checked', <?=$data['naskon']['angkut_id']==='2'?'true':'false'?>);
		$('input[id="jenis1"]').prop('checked', <?=$data['naskon']['konfirmasi']==='1'?'true':'false'?>);
		$('input[id="jenis2"]').prop('checked', <?=$data['naskon']['konfirmasi']==='2'?'true':'false'?>);
		<?php

			if(isset($data['list_sbdy'])) 
			{
				foreach ($data['list_sbdy'] as $k => $v)
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

	$('#datatable').dataTable({
		"bServerSide":true,
		"bProcessing":true,
		"sPaginationType": "full_numbers",
		"bFilter":true,
		"sServerMethod": "POST",
		"sAjaxSource": "<?=base_url()?>index.php/bapb/DT-po",
		"columns": [
			{ "name": "tanggal" },
			{ "name": "no_po" },
			{ "name": "kode_spk" },
			{ "name": "kode_bpdp" },
			{ "name": "no_unit" },
			{ "searchable": false, "sortable": false }
		]
	});
	// event
	$('body').on('click', '.row-data', function() {
		var po = $(this).attr('data-po'),
			tbody = $('#table-bapb tbody').html('');
		$('#no_po').val(po);
		$('#xno_po').attr('data-po', po);
		$.post(
			'<?=base_url()?>index.php/bapb/get/'+po,
			function(respon) {
				$.each(respon, function(index, item) {
					tbody.append(
						'<tr>'+
						'<td>'+item.nama+'</td>'+
						'<td class="text-right input-numeric">'+item.volume+'</td>'+
						'<td class="text-center">'+item.xtanggal+'</td>'+
						'</tr>');
				});
				$('.input-numeric').autoNumeric('init');
			});

	});
	$('#btn-add-sd').click(function() {
		var isValid = true;
		$.each($('.required'), function(index, item) {

			if($(this).val()=='')
				isValid &= false;
		});
		if(isValid) {
			var tbody = $('#datatable-sd tbody'),
				nTR = tbody.find('tr').length,
				foo = [],
				str = "";

				if(nTR>1){
					nTR =nTR-1;
				}
				
			tbody.append(
				'<tr>'+
				'<input type="hidden" name="kode_sumberdaya[]" value="'+$('#kode_sumberdaya').val()+'">'+
				'<input type="hidden" name="harga_satuan[]" value="'+$('#harga_satuan').autoNumeric('get')+'">'+
				'<input type="hidden" name="volume[]" value="'+$('#volume').autoNumeric('get')+'">'+
				'<input type="hidden" name="sd_id[]" id="sd_id[]" value="">'+
				'<td class="text-center">'+(nTR+1)+'</td>'+
				'<td>'+$('#kode_sumberdaya option:selected').text()+'</td>'+
				'<td class="input-numeric text-right">'+$('#harga_satuan').autoNumeric('get')+'</td>'+
				'<td class="input-numeric text-right">'+$('#volume').autoNumeric('get')+'</td>'+
				'<td class="input-numeric text-center"><a style="cursor:pointer" class="row-delete" href="javascript:delete_row()"><span class="glyphicons glyphicons-bin"></span></a></td>'+
				'</tr>'
			);
			$('.input-numeric').autoNumeric('init');
			// reset detail
			//$('#kode_sumberdaya').val('').chosen().trigger('chosen:updated');
			//$('#harga_satuan').autoNumeric('set', 0);
			//$('#volume').autoNumeric('set', 0);
		}else{
			alert('Item sumberdaya masih ada yang belum terisi. Harap dilengkapi.')
		}
		groupTable();
	});
	
	$('#btn-submit').click(function() {
		console.log('simpan');
		// validasi
		var isValid = true;
		$.each($('.required'), function(index, item) {
			if($(this).val()=='')
				isValid &= false;
		});
		
		if(isValid) {
			//var data = $('#form-input').serialize();
			$.post(
				'<?=base_url()?>index.php/bapb/save',
				$('#form-input').serialize(),
				function(respon) {
					alert('Data tersimpan.');
					location.href = '<?=base_url()?>index.php/bapb';
				}
			);
		}
	});


});

	function groupTable()
 	{
 		$(function() {  
			function groupTable($rows, startIndex, total){
				if (total === 0){
				return;
			}
			var i , currentIndex = startIndex, count=1, lst=[];
			var tds = $rows.find('td:eq('+ currentIndex +')');
			var ctrl = $(tds[0]);
			lst.push($rows[0]);
			for (i=1;i<=tds.length;i++){
				if (ctrl.text() ==  $(tds[i]).text()){
					count++;
					$(tds[i]).addClass('deleted');
					lst.push($rows[i]);
				}
				else{
					if (count>1){
						ctrl.attr('rowspan',count);
						groupTable($(lst),startIndex+1,total-1)
					}
					count=1;
					lst = [];
					ctrl=$(tds[i]);
					lst.push($rows[i]);
				}
			}
			}
			groupTable($('#datatable-sd tr:has(td)'),0,3);
			$('#datatable-sd .deleted').remove();
		});
 	}

 	function delete_row(id)
    {
    	if(confirm("Anda yakin akan menghapus data ini?")) {
	    	if(id!=null){
	    		//alert('delete id: '+id);
	    		$.post("<?=base_url()?>index.php/bapb/delete_sd/"+id,function(ev) {
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