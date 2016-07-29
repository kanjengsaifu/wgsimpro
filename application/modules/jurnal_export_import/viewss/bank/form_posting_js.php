<script type="text/javascript">
jQuery(document).ready(function() {
	// init component / plugin
	$('.chosen-select').chosen({
		width: '100%',
		allow_single_deselect: true
	});
	$('#tgl_bayar').datetimepicker({
		pickTime: false,
		format: 'DD/MM/YYYY'
	});
	$('.input-numeric').autoNumeric('init');
	$('#datatable').dataTable({
		"bServerSide":true,
		"bProcessing":true,
		"sPaginationType": "full_numbers",
		"bFilter":true,
		"sServerMethod": "POST",
		"sAjaxSource": "<?=base_url()?>index.php/jurnal/bank-in/post/dt",
	});
	$('.chosen-select').val('').chosen().trigger('chosen:updated');
	// event
	$('body').on('click', '.row-data', function() {
		var resno = $(this).attr('data-resno');
		$('#idpay').val('');
		$('#kode_pay').val('');
		$('#nama').val('');
		$('#rp').autoNumeric('set',0);
		$('#no_urut').val('');
		$.post(
			'<?=base_url()?>index.php/payment/get/'+resno,
			function(respon) {
				$('#xresno').attr('data-resno',resno);
				$('#pnama').text(': '+respon.nsb_nama);
				$('#pno_unit').text(': '+respon.no_unit);
				$('#pluas_bangunan').text(': '+respon.stk_luas_nett);
				$('#pluas_tanah').text(': '+respon.stk_luas_gross);
				$('#pharga_unit').text(': '+respon.fharga_unit);
				$('#pterbilang').text(': '+respon.terbilang);
				$('#reserve_no').val(respon.reserve_no);
				$('#pcara_bayar').text(': '+respon.cara_bayar);
				$('#skode_pay').html('<option value=""></option>');
				if(respon.pays!==undefined) {
					$.each(respon.pays, function(index, item) {
						$('#skode_pay').append('<option value="'+(item.kode_pay+item.no_urut)+'" data-id="'+
							item.idpay+'" data-kode="'+item.kode_pay+'" data-nama="'+item.nama+'" data-rp="'+
							item.rp+'" data-urut="'+item.no_urut+'"'+(index>0 ? ' disabled="disabled"' : '')+'>'+item.nama+'</option>');
					});
				}
				$('.chosen-select').val('').chosen().trigger('chosen:updated');
				var tbl = $('#table-paydet tbody').html(''), sHTML = '', snama = '',
					tfoot = $('#table-paydet tfoot').html(''), vSumRa = 0, vSumRi = 0;
				$.each(respon.paydet_ra, function(index, item) {
					sHTML = '<tr id="'+(item.kode_pay+item.no_urut)+'">';
					sHTML += '<td class="text-center">'+(index+1)+'</td>';
					sHTML += '<td>'+(snama===item.nama?'':item.nama)+'</td>'; 
					sHTML += '<td class="text-center">'+(item.tgl_tempo)+'</td>';
					vSumRa += item.ra_rp==='' ? 0 : parseFloat(item.ra_rp);
					sHTML += '<td class="text-right input-numeric">'+(item.ra_rp)+'</td>';
					sHTML += '<td class="text-center">'+(item.tgl_bayar)+'</td>';
					sHTML += '<td class="text-right input-numeric">'+(item.ri_rp)+'</td>';
					sHTML += '<td class="text-center">'+(item.no_kwitansi)+'</td>';
					sHTML += '<td class="text-center">'+(item.hari_denda)+'</td>';
					sHTML += '<td class="text-right input-numeric">'+(item.rp_denda)+'</td>';
					sHTML += '</tr>';
					tbl.append(sHTML);
					snama = item.nama;
				});
				if(respon.paydet_ri!==undefined) {
					$.each(respon.paydet_ri, function(index, item) {
						var no_kwitansi = '<a target="_blank" href="<?=base_url()?>index.php/payment/kuitansi/'+item.no_kwitansi+'">'+item.no_kwitansi+'</a>';
						if($('#'+item.kode_pay+item.no_urut).children().eq(4).text()==='') {
							$('#'+item.kode_pay+item.no_urut).children().eq(4).text(item.tgl_bayar);
							$('#'+item.kode_pay+item.no_urut).children().eq(5).text(item.ri_rp);
							$('#'+item.kode_pay+item.no_urut).children().eq(6).html(no_kwitansi);
							if(item.kode_pay.indexOf('KPR')>-1) {
								$('#'+item.kode_pay+item.no_urut).children().eq(4).addClass('text-danger');
								$('#'+item.kode_pay+item.no_urut).children().eq(5).addClass('text-danger');
							}
						} else {
							var sClass = '';
							if(item.kode_pay.indexOf('KPR')>-1) {
								sClass = 'text-danger';
							}
							$('#'+item.kode_pay+item.no_urut).after(
								'<tr id="'+item.kode_pay+item.no_urut+'"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td class="text-center '+sClass+'">'+item.tgl_bayar+
								'</td><td class="text-right input-numeric '+sClass+'">'+item.ri_rp+'</td><td class="text-center">'+no_kwitansi+'</td><td>&nbsp;</td><td>&nbsp;</td></tr>'
							);
						}
						vSumRi += item.ri_rp==='' ? 0 : parseFloat(item.ri_rp);
					});
				}
				tfoot.append('<tr><td colspan="3" class="text-right">Total</td><td class="text-right input-numeric">'+vSumRa+'</td>'+
						'<td>&nbsp;</td><td class="text-right input-numeric" id="sum-ri">'+vSumRi+'</td><td>&nbsp;</td>'+
						'<td>&nbsp;</td><td>&nbsp;</td></tr>');
				$('.input-numeric').autoNumeric('init');
			},
		'json');
	});
	$('#skode_pay').on('change', function() {
		$('#idpay').val($('#skode_pay option[value="'+$(this).val()+'"]').attr('data-id'));
		$('#kode_pay').val($('#skode_pay option[value="'+$(this).val()+'"]').attr('data-kode'));
		$('#nama').val($('#skode_pay option[value="'+$(this).val()+'"]').attr('data-nama'));
		$('#rp').autoNumeric('set',$('#skode_pay option[value="'+$(this).val()+'"]').attr('data-rp'));
		$('#no_urut').val($('#skode_pay option[value="'+$(this).val()+'"]').attr('data-urut'));
	});
	$('#cekall').click(function () {
        $('.chkpos').prop('checked', isChecked('selectall'));
    });
    
	$('#btn-posting').click(function() {
		$(this).addClass('disabled');
		sErr = '';
		if($('#kode_pay').val()==='') {
			sErr += "\n- Jenis pembayaran belum dipilih!";
		}
		if(parseFloat($('#rp').autoNumeric('get'))<1) {
			sErr += "\n- Nominal Bayar harus lebih dari 0 (nol)!";
		}
		if(sErr==='') {
			$.post(
				'<?=base_url()?>index.php/payment/save',
				$('#form-payment').serialize(),
				function(respon) {
					// console.log(respon);
					if(respon!=='') {						
						$('#idpay').val('');
						$('#kode_pay').val('');
						$('#nama').val('');
						$('#rp').autoNumeric('set','0.00'); 
						$('#no_urut').val('');
						$('#skode_pay').val('').chosen().trigger('chosen:updated');
						$('#xresno').trigger('click');
					}
				}
			);
		} else {
			alert("Terjadi kesalahan, mohon diperiksa: "+sErr);
		}
		$(this).removeClass('disabled');
	});
});
</script>