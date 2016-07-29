<script type="text/javascript">
jQuery(document).ready(function() {
	$('.chosen-select').chosen({
		width: '100%',
		allow_single_deselect: true
	});
	$('#tanggal').datetimepicker({
		pickTime: false,
		format: 'DD/MM/YYYY'
	});
	$('.input-numeric').autoNumeric('init');
	$('#btn-submit-pay').click(function() {
		$(this).addClass('disabled');
		sErr = '';
		if($('#nama').val()==='') {
			sErr += "\n- Nama Harus Di isi";
		}
		if($('#tanggal').val()==='') {
			sErr += "\n- Tanggal Harus Di isi";
		}
		if(parseFloat($('#rp').autoNumeric('get'))<1) {
			sErr += "\n- Nominal Bayar harus lebih dari 0 (nol)!";
		}
		if(sErr==='') {
			$.post(
				'<?=base_url()?>index.php/payment-undefined/savedata',
				$('#form-payment').serialize(),
				function(respon) {
					if(respon!=='') {
						alert('Data berhasil disimpan!');
						location.href = '<?=base_url() ?>index.php/payment-undefined';
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