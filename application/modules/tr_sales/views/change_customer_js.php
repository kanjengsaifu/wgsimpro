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
			vSum = 0;;
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
				$('#reserve_no_old').val(resno);
				// netto & fee
				$('#rp_netto').val(respon.rp_netto!==null?respon.rp_netto:0);
				$('#adm_rp').autoNumeric('set', parseFloat($('#rp_netto').val())*0.05);
			}
		,'json');
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
	$('#ckrelated-1').change(function() {
		console.log($(this).prop('checked'));
		if($(this).prop('checked')) {
			$('#adm_rp').autoNumeric('set', 0);
		} else {
			$('#adm_rp').autoNumeric('set', parseFloat($('#rp_netto').val())*0.05);
		}
	});
	$('#btn-submit-change').click(function() {
		$(this).addClass('disabled');
		$.post(
			'<?=base_url()?>index.php/sales-change-owner/save',
			$('#form-change-owner').serialize(),
			function(respon) {
				if(respon!=='') {
					alert(respon);
					location.href = '<?=base_url()?>index.php/sales-change-owner';
				}
			}
		);
		$(this).removeClass('disabled');
	});
});
</script>