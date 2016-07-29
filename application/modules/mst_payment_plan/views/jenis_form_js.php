<script type="text/javascript" src="<?=base_url()?>assets/vendor/plugins/datatables/extensions/ReloadAjax/js/dataTables.reloadAjax.min.js"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
	// init component / plugin
	$('.chosen-select').chosen({
		width: '100%'
	});
	$('.input-numeric').autoNumeric('init', {aPad: false});
	// reset val
	$('.chosen-select').val('').chosen().trigger('chosen:updated');
	// init value
	<?php if(isset($data['id'])) { ?>
	$('#id').val('<?=$data['id']?>');
	$('#kode_pay').val('<?=$data['kode_pay']?>');
	$('#deskripsi').val('<?=$data['deskripsi']?>');
	$('#tipe_pay').val('<?=$data['tipe_pay']?>').chosen().trigger('chosen:updated');
	$('#base_period').val('<?=$data['base_period']?>').chosen().trigger('chosen:updated');
	$('#install_num').autoNumeric('set', <?=$data['install_num']?>);
	$('#persentase').autoNumeric('set', <?=$data['persentase']?>);
	$('#rp').autoNumeric('set', <?=$data['rp']?>);
	$('#limit_day').autoNumeric('set', <?=$data['limit_day']?>);
	<?php } ?>
	// event
	$('#btn-submit').click(function() {
		$.post(
			'<?=base_url()?>index.php/payment-plan/save/jenis',
			$('#form-input').serialize(),
			function(respon) {
				if(respon==='') {
					alert('Data tersimpan.');
					location.href = '<?=base_url()?>index.php/payment-plan/jenis';
				}
			}
		);
	});
	$('#base_period').on('change', function() {
		if($(this).val()==='MONTHLY') {
			$('#limit_day').autoNumeric('set', 30);
		}
	});
});
</script>