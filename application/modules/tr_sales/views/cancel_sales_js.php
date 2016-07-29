<script type="text/javascript">
jQuery(document).ready(function() {
	// init component / plugin
	$('.chosen-select').chosen({
		width: '100%',
		allow_single_deselect: true
	});
	$('#datatable').dataTable({
		"bServerSide":true,
		"bProcessing":true,
		"sPaginationType": "full_numbers",
		"bFilter":true,
		"sServerMethod": "POST",
		"sAjaxSource": "<?=base_url()?>index.php/payment/DT",
	});
	$('.chosen-select').val('').chosen().trigger('chosen:updated');
	$('.input-numeric').autoNumeric('init');
	// event
	$('body').on('click', '.row-data', function() {
		var resno = $(this).attr('data-resno'),
			tblbody = $('#table-paydet tbody').html(''),
			vSum = 0;
		$.post(
			'<?=base_url()?>index.php/sales-cancel/get-reserve/'+resno,
			function(respon) {
				$('#pnama').text(':'+respon.nsb_nama);
				$('#pno_unit').text(':'+respon.no_unit);
				$('#pharga_unit').text(':'+respon.fharga_unit);
				$('#pterbilang').text('#'+respon.terbilang+'#');
				$('#pcara_bayar').text(':'+respon.cara_bayar);
				$('#ppola_bayar').text(':'+respon.pola_bayar);
				if(respon.paydet_ri!==undefined) {
					$.each(respon.paydet_ri, function(index, item) {
						tblbody.append(
							'<tr>'+
							'<td class="text-center">'+(index+1)+'</td>'+
							'<td>'+item.nama+'</td>'+
							'<td class="text-center">'+item.tgl_bayar+'</td>'+
							'<td class="text-right input-numeric">'+item.ri_rp+'</td>'+
							'</tr>'
						);
						vSum += parseFloat(item.ri_rp);
					});
					tblbody.append(
						'<tr>'+
						'<td colspan="3" class="text-right">Total</td>'+
						'<td class="text-right input-numeric">'+vSum+'</td>'+
						'</tr>'
					);
					$('.input-numeric').autoNumeric('init');
				}
				$('#reserve_no').val(resno);
				// cancel info
				var vprogress = 0;
				$('#td_ri_bayar').autoNumeric('set', vSum);
				$('#td_tj').autoNumeric('set', respon.rp_tj);
				$('#td_adm').autoNumeric('set', vprogress>0 ? vSum*0.5 : vSum*0.25);
				$('#td_refund').autoNumeric('set', 
					parseFloat($('#td_ri_bayar').autoNumeric('get')) - 
					(
						parseFloat($('#td_tj').autoNumeric('get')) + 
						parseFloat($('#td_adm').autoNumeric('get')) +
						parseFloat($('#td_tax').autoNumeric('get'))
					)
				);
			}
		,'json');
	});
	$('#td_adm, #td_tax').change(function() {
		$('#td_refund').autoNumeric('set', 
			parseFloat($('#td_ri_bayar').autoNumeric('get')) - 
			(
				parseFloat($('#td_tj').autoNumeric('get')) + 
				parseFloat($('#td_adm').autoNumeric('get')) +
				parseFloat($('#td_tax').autoNumeric('get'))
			)
		);
	});
	$('#btn-submit-cancel').click(function() {
		$(this).addClass('disabled');
		$.post(
			'<?=base_url()?>index.php/sales-cancel/save',
			$('#form-cancel').serialize(),
			function(respon) {
				if(respon==='') {
					alert('Proses Cancellation berhasil.');
					location.href = '<?=base_url()?>index.php/sales-cancel';
				}
			}
		);
		$(this).removeClass('disabled');
	});
});
</script>