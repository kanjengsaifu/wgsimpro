<script type="text/javascript">
jQuery(document).ready(function() {
	// init component / plugin
	$('.chosen-select').chosen({
		width: '100%',
		allow_single_deselect: true
	});
	$('#tgl_ra, #tgl_ri, #input-tanggal').datetimepicker({
		pickTime: false,
		format: 'DD/MM/YYYY'
	});
	$('#datatable-unit').dataTable({
		"bServerSide":true,
		"bProcessing":true,
		"sPaginationType": "full_numbers",
		"bFilter":true,
		"sServerMethod": "POST",
		"sAjaxSource": "<?=base_url()?>index.php/perijinan/DT",
		"columns": [
			{ "name": "no_unit" },
			{ "name": "type_property" },
			{ "name": "tower_cluster" },
			{ "name": "type_unit" },
			{ "name": "wide_netto" },
			{ "name": "wide_gross" },
			{ "name": "lantai_blok" },
			{ "name": "direction" },
			{ "name": "mata_angin" },
			{ "name": "action", "searchable": false, "sortable": false }
		]
	});
	$('.chosen-select').val('').chosen().trigger('chosen:updated');
	$('.input-numeric').autoNumeric('init');
	$('#modalTanggal').modal({
		show: false,
		backdrop: false
	});
	// event
	$('body').on('click', '.row-unit', function() {
		var encunit = $(this).attr('data-encunit'),
			no_unit = $(this).attr('data-unit'),
			tbody = $('#datatable tbody').html('');
		$.post(
			'<?=base_url()?>index.php/perijinan/'+encunit,
			function(respon) {
				$('#form-ra-ri').addClass('hidden');
				$('#pno_unit').text(': '+no_unit);
				$('#no_unit').val(no_unit);
				$('#xrow-unit').attr('data-encunit', encunit);
				$('#xrow-unit').attr('data-unit', no_unit);
				if(respon[0]!==undefined) {
					$.each(respon, function(index, item) {
						tbody.append(
							'<tr>'+
							'<td>'+item.kode_dokumen+'</td>'+
							'<td>'+item.nama_dokumen+'</td>'+
							'<td>'+item.no_dokumen+'</td>'+
							'<td>'+item.xtgl_ra+'</td>'+
							'<td>'+item.xtgl_ri+'</td>'+
							'<td>'+
								'<div class="checkbox-custom square checkbox-success">'+
                                '<input id="ckpick-'+index+'" type="checkbox" class="ckpick" data-id="'+item.id+'">'+
                                '<label for="ckpick-'+index+'">&nbsp;</label>'+
                                '</div>'+
                            '</td>'+
							'</tr>'
						);
					});
					$('#form-ra-ri').removeClass('hidden');
				}
			},'json'
		);
	});
	$('#jenis_dok').on('change', function() {
		var kode = $(this).val(),
			nama = $('#jenis_dok option:selected').text();
		$('#kode_dokumen').val(kode);
		$('#nama_dokumen').val(nama);
		// nama notaris
		$('#nama_notaris').closest('.form-group').addClass('hidden');
		if(kode==='AJB') {
			$('#nama_notaris').closest('.form-group').removeClass('hidden');
		}
	});
	$('#ckpick-head').change(function() {
		var picked = $(this).prop('checked');
		$.each($('.ckpick'), function() {
			$(this).prop('checked', picked);
		});
	});
	$('#btn-ra, #btn-ri').click(function() {
		var n_pick = $('.ckpick:checked').length,
			target = $(this).attr('data-type');
		if(n_pick>0) {
			var inputs_div = $('#container-date-inputs').html('');
			$.each($('.ckpick:checked'), function() {
				inputs_div.append(
					'<input type="hidden" name="id[]" value="'+$(this).attr('data-id')+'" />'+
					'<input type="hidden" name="tgl_'+target+'[]" class="input-tgl-'+target+'" />'
				);
			});
			inputs_div.append(
				'<input type="hidden" name="target" value="'+target+'" />'
			);
			$('#input-tanggal').val('');
			$('#input-tanggal').attr('data-target', target);
			var title = $(this).attr('data-title');
			$('.modal-title').text(title);
			$('#modalTanggal').modal('show');
		} else {
			alert('Silahkan pilih baris data yang ingin diubah.');
		}
	});
	$('#input-tanggal').change(function() {
		$('.input-tgl-'+$(this).attr('data-target')).val($(this).val());
	});
	$('#btn-submit-tanggal').click(function() {
		$.post(
			'<?=base_url()?>index.php/perijinan/save/tanggal',
			$('#form-input-tgl-ra-ri').serialize(),
			function(respon) {
				if(respon==='') {
					alert('Perubahan tanggal selesai.');
					$('#modalTanggal').modal('hide');
					$('#xrow-unit').trigger('click');
				}
			}
		);
	});
	$('#btn-submit').click(function() {
		if($('#no_unit').val()!=='') {
			$.post(
				'<?=base_url()?>index.php/perijinan/save',
				$('#form-input').serialize(),
				function(respon) {
					if(respon==='') {
						alert('Data tersimpan.');
						$('#jenis_dok').val('').chosen().trigger('chosen:updated');
						$('#no_dokumen').val('');
						$('#tgl_ra').val('');
						$('#tgl_ri').val('');
						$('#xrow-unit').trigger('click');
					}
				}
			);
		} else {
			alert('Silahkan pilih Unit.');
		}
	});
});
</script>