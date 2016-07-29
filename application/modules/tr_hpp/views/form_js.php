<script type="text/javascript">
jQuery(document).ready(function() {
	// init component / plugin
	$('.chosen-select').chosen({
		width: '100%',
		allow_single_deselect: true
	});
	$('#datatable-unit').dataTable({
		"bServerSide":true,
		"bProcessing":true,
		"sPaginationType": "full_numbers",
		"bFilter":true,
		"sServerMethod": "POST",
		"sAjaxSource": "<?=base_url()?>index.php/hpp/DT",
		"columns": [
			{ "name": "no_unit" },
			{ "name": "type_property" },
			{ "name": "tower_cluster" },
			{ "name": "type_unit" },
			{ "name": "wide_netto" },
			{ "name": "wide_gross" },
			{ "name": "lantai_blok" },
			{ "name": "rp" },
			{ "name": "action", "searchable": false, "sortable": false }
		]
	});
	$('.chosen-select').val('').chosen().trigger('chosen:updated');
	$('.input-numeric').autoNumeric('init');
	// event
	$('#btn-submit').click(function() {
		$(this).attr('disabled', true);
		var no_unit = $('#no_unit').val();
		if(no_unit!=='') {
			$.post(
				'<?=base_url()?>index.php/hpp/save',
				$('#form-input').serialize(),
				function(respon) {
					alert('Data tersimpan.');
					$('#xrow-unit').trigger('click');
					$('.chosen-select').val('').chosen().trigger('chosen:updated');
					$('#rp').autoNumeric('set', 0.00);
				}
			);
		} else {
			alert('Silahkan pilih unit.');
		}
		$(this).attr('disabled', false);
	});
	$('body').on('click', '.row-unit', function() {
		var no_unit = $(this).attr('data-unit'),
			encunit = $(this).attr('data-encunit');
		$('#no_unit').val(no_unit);
		$('#pno_unit').text(no_unit);
		$('#xrow-unit').attr('data-unit', no_unit);
		$('#xrow-unit').attr('data-encunit', encunit);
		$('.chosen-select').val('').chosen().trigger('chosen:updated');
		$('#rp').autoNumeric('set', 0.00);
		var tblbody = $('#datatable tbody').html(''),
			tblfoot = $('#datatable tfoot').html(''),
			sumRP = 0;
		$.post(
			'<?=base_url()?>index.php/hpp/get/'+encunit,
			function(respon) {
				$.each(respon, function(index, item) {
					tblbody.append(
						'<tr>'+
						'<td>'+item.konten+'</td>'+
						'<td class="text-right input-numeric">'+item.rp+'</td>'+
						'</tr>'
					);
					sumRP += parseFloat(item.rp);
				});
				tblfoot.append(
					'<tr>'+
					'<td class="text-right">Jumlah</td>'+
					'<td class="text-right input-numeric">'+sumRP+'</td>'+
					'</tr>'
				);
				$('.input-numeric').autoNumeric('init');
			},
		'json');
	});
});
</script>