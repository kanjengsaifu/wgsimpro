<script type="text/javascript">
	// init plugins
	$('.chosen-select').chosen({
		width: '100%'
	});
	$('#tanggal').datetimepicker({
		pickTime: false,
		format: 'DD/MM/YYYY'
	});
	$('#datatable').dataTable({
		"bServerSide":true,
		"bProcessing":true,
		"sPaginationType": "full_numbers",
		"bFilter":true,
		"sServerMethod": "POST",
		"sAjaxSource": "<?=base_url()?>index.php/ri-kpr/DT",
		"columns": [
			{ "name": "no_unit" },
			{ "name": "nasabah" },
			{ "name": "bank" },
			{ "name": "kpr" },
			{ "name": "um" },
			{ "searchable": false, "sortable": false }
		]
	});
	$('.input-numeric').autoNumeric('init');
	// event
	$('body').on('click', '.row-view', function() {
		var resno = $(this).attr('data-resno'),
			tbody = $('#datatable-alokasi tbody').html(''),
			selAlokasi = $('#alokasi').html('');
		$.post(
			'<?=base_url()?>index.php/ri-kpr/'+resno,
			function(respon) {
				$('#reserve_no').val(respon.reserve_no);
				$('#xresno').attr('data-resno', respon.reserve_no);
				$('#pnama').text(': '+respon.nasabah);
				$('#pno_unit').text(': '+respon.no_unit);
				$('#pharga_unit').text(': '+respon.harga_unit);
				$('#pterbilang').text('#'+respon.terbilang+'#');
				$('#presno').text(': '+respon.reserve_no);
				$('#pbank').text(': '+respon.bank);
				$('#pplafond').text(': '+respon.plafond);
				$('#lplafond').val(respon.plafond.replace(new RegExp(',', 'g'), ''));
				if(respon.alokasi[0].kode_bank!==undefined) {
					selAlokasi.append('<option value=""></option>');
					tbody.append('<tr class="hidden" id="rowSum"></tr>');
					var sKet = '', sOption = '';
					$.each(respon.alokasi, function(index, item) {
						var itemNominal = (parseFloat(respon.plafond.replace(new RegExp(',', 'g'), ''))*parseFloat(item.persentase)/100),
							itemRp = isNaN(parseFloat(item.rp.replace(new RegExp(',', 'g'), ''))) ? 0 : parseFloat(item.rp.replace(new RegExp(',', 'g'), ''));
						selAlokasi.append('<option value="'+item.keterangan+'" data-persen="'+item.persentase+'">'+item.keterangan+'</option>');
						if(sKet!==item.keterangan) {
							tbody.append(
								'<tr>'+
								'<td>'+item.persentase+' %</td>'+
								'<td class="input-numeric text-right">'+(parseFloat(respon.plafond.replace(new RegExp(',', 'g'), ''))*parseFloat(item.persentase)/100)+'</td>'+
								'<td>'+item.keterangan+'</td>'+
								'<td class="text-right">'+item.rp+'</td>'+
								'<td>'+(item.tanggal===null || item.tanggal==='' ? '' : item.tanggal)+'</td>'+
								'</tr>'
							);
						} else {
							tbody.append(
								'<tr>'+
								'<td>&nbsp;</td>'+
								'<td>&nbsp;</td>'+
								'<td>&nbsp;</td>'+
								'<td class="text-right">'+item.rp+'</td>'+
								'<td>'+(item.tanggal===null || item.tanggal==='' ? '' : item.tanggal)+'</td>'+
								'</tr>'
							);
						}
						var targetSum = $('#datatable-alokasi tbody tr#rowSum').find('td[data-target="'+item.keterangan+'"]'),
							targetRP = itemRp;
						if(targetSum.length>0) {
							targetSum.text(parseFloat(targetSum.text())+itemRp);
							targetRP = parseFloat(targetSum.text())+itemRp;
						} else {
							$('#datatable-alokasi tbody tr#rowSum').append('<td data-target="'+item.keterangan+'" class="input-numeric">'+itemRp+'</td>');
						}
						sKet = item.keterangan;
						if(itemNominal<=targetRP) {
							$('#alokasi option[value="'+item.keterangan+'"]').remove();
						}
					});
					$('.chosen-select').chosen().trigger('chosen:updated');
					$('.input-numeric').autoNumeric('init');
				}
			},
		'json');
	});
	$('#alokasi').on('change', function() {
		var keterangan = $(this).val(),
			persentase = $('#alokasi option:selected').attr('data-persen'),
			itemRp = $('#datatable-alokasi tbody').find('td:contains("'+keterangan+'")').next().text().replace(new RegExp(',', 'g'), '');
		itemRp = isNaN(parseFloat(itemRp)) ? 0 : parseFloat(itemRp);
		$('#keterangan').val(keterangan);
		$('#persentase').val(persentase);
		$('#rp').autoNumeric('set', (parseFloat($('#lplafond').val())*parseFloat(persentase)/100)-itemRp);
	});
	$('#btn-submit').click(function() {
		var keterangan = $(this).val(),
			persentase = $('#alokasi option:selected').attr('data-persen'),
			plafond = $('#lplafond').val(),
			rp = $('#rp').autoNumeric('get'),
			itemRp = $('#datatable-alokasi tbody').find('td:contains("'+keterangan+'")').next().text().replace(new RegExp(',', 'g'), '');
		itemRp = isNaN(parseFloat(itemRp)) ? 0 : parseFloat(itemRp);
		if(parseFloat(rp)+parseFloat(itemRp)>parseFloat(plafond)*parseFloat(persentase)/100) {
			alert('Nominal realisasi melebihi prosentase yang ditentukan.');
			$('#rp').focus();
		} else {
			$.post(
				'<?=base_url()?>index.php/ri-kpr/save',
				$('#form-input').serialize(),
				function(respon) {
					if(respon==='') {
						$('#xresno').trigger('click');
					}
				}
			);
		}
	});
</script>
