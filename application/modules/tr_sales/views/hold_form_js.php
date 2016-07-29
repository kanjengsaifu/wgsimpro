<script type="text/javascript">
jQuery(document).ready(function() {
	// init component / plugin
	$('.chosen-select').chosen({
		width: '100%',
		allow_single_deselect: true
	});
	$('#tgl_lahir').datetimepicker({
		pickTime: false,
		format: 'DD/MM/YYYY'
	});
	$('#datatable-unit').dataTable({
		"bServerSide":true,
		"bProcessing":true,
		"sPaginationType": "full_numbers",
		"bFilter":true,
		"sServerMethod": "POST",
		"sAjaxSource": "<?=base_url()?>index.php/hold/DT",
		"columns": [
			{"name": "no_unit"},
			{"name": "type_property"},
			{"name": "type_unit"},
			{"name": "tower_cluster"},
			{"name": "wide_netto"},
			{"name": "wide_gross"},
			{"name": "lantai_blok"},
			{"name": "direction"},
			{"sortable": false, "searchable": false}
		]
	});
	$('#datatable-ret').dataTable({
		"bServerSide":true,
		"bProcessing":true,
		"sPaginationType": "full_numbers",
		"bFilter":true,
		"sServerMethod": "POST",
		"sAjaxSource": "<?=base_url()?>index.php/hold/DTret",
		"columns": [
			{"name": "no_unit"},
			{"name": "type_property"},
			{"name": "type_unit"},
			{"name": "tower_cluster"},
			{"name": "wide_netto"},
			{"name": "wide_gross"},
			{"name": "lantai_blok"},
			{"name": "direction"},
			{"searchable": false},
			{"searchable": false},
			{"sortable": false, "searchable": false}
		]
	});
	$('.input-numeric').autoNumeric('init');
	// event
	$('body').on('click', '.row-unit', function() {
		var no_unit = $(this).attr('data-encunit');
		$('.chosen-select').val('').chosen().trigger('chosen:updated');
		$.post(
			'<?=base_url()?>index.php/reserve/get/'+no_unit,
			function(respon) {
				// produk
				$('#pno_unit').text(respon.no_unit);
				$('#ptype_unit').text(respon.type_unit);
				$('#ptower_cluster').text(respon.tower_cluster);
				$('#pwide_netto').text(respon.wide_netto);
				$('#pwide_gross').text(respon.wide_gross);
				$('#pluas_tanah').text(respon.luas_tanah);
				$('#plantai_blok').text(respon.lantai_blok);
				$('#pdirection').text(respon.direction==null?'':respon.direction); 
				// prices
				var pricesHTML = $('#prices-container').html('');
				if(respon.prices !== undefined) {
					$.each(respon.prices, function(index, item) {
						pricesHTML.append(
							'<div class="form-group mbn">'+
							'<label class="col-lg-2 control-label">Harga '+item.nama+'</label>'+
							'<div class="col-lg-4">'+
							'<p class="form-control-static text-muted input-numeric" id="pharga-'+item.cara_bayar+'">'+item.tr_jual+'</p>'+
							'</div>'+
							'<label class="col-lg-2 control-label">Terbilang</label>'+
							'<div class="col-lg-4">'+
							'<p class="form-control-static text-muted" id="pterbilang-'+item.cara_bayar+'">'+item.terbilang+'</p>'+
							'</div>'+
							'</div>'
						);
					});
					$('.input-numeric').autoNumeric('init');
				}
				// payment plan
				$('#no_unit').val(respon.no_unit);
				$('#hold_date').val(respon.hold_date===null ? '<?=date('Y-m-d')?>' : respon.hold_date);
			}
		);
	});
	$('body').on('click', '.row-extend', function() {
		var no_unit = $(this).attr('data-encunit'),
			isextend = $(this).attr('data-extend');
		if(isextend==='0') {
			if(confirm('Anda yakin ingin extend data ini?')) {
				$.post(
					'<?=base_url()?>index.php/hold/extend/'+no_unit,
					function(respon) {
						if(respon.status === '200') {
							alert('Data berhasil diubah.');
							location.href = '<?=base_url()?>index.php/hold';
						} else {
							alert(respon.msg);
						}
					}
				);
			}
		} else {
			alert('Data ini telah di extend sebelumnya.')
		}
	});
	$('body').on('click', '.row-cancel', function() {
		var no_unit = $(this).attr('data-encunit');
		if(confirm('Anda yakin ingin cancel data ini?')) {
			$.post(
				'<?=base_url()?>index.php/hold/cancel/'+no_unit,
				function(respon) {
					if(respon.status === '200') {
						alert('Data berhasil diubah.');
						location.href = '<?=base_url()?>index.php/hold';
					} else {
						alert(respon.msg);
					}
				}
			);
		}
	});
	$('#btn-add-alamat').click(function() {
		var theDiv = $('.alamat-group:last'),
			alamat_txt = theDiv.children().eq(0).find('.control-label').text(),
			alamat_no = parseInt(alamat_txt.split('#')[1])+1,
			newDiv = '<div class="alamat-group">'+theDiv.html()+'</div>';
		theDiv.after(newDiv);
		$('.alamat-group:last').children().eq(0).find('.control-label').not('.blank-label').text('Alamat #'+alamat_no);
		$('.alamat-group:last').children().eq(0).find('.radio-custom').children().eq(0).attr('id', 'ckalamat-'+alamat_no);
		$('.alamat-group:last').children().eq(0).find('.radio-custom').children().eq(0).val((alamat_no-1));
		$('.alamat-group:last').children().eq(0).find('.radio-custom').children().eq(1).attr('for', 'ckalamat-'+alamat_no);
	});
	$('#btn-hold').click(function() {
		var no_unit = $('#no_unit').val();
		if(no_unit!=='') {
			$.post(
				'<?=base_url()?>index.php/hold/save',
				$('#form-customer').serialize(),
				function(respon) {
					alert(respon.msg);
					location.href = '<?=base_url()?>index.php/hold';
				}
			);
		} else {
			alert('Unit belum dipilih.')
		}
	});
});
</script>