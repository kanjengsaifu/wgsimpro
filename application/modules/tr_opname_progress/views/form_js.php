<script type="text/javascript" src="<?=base_url()?>assets/vendor/plugins/datatables/extensions/ReloadAjax/js/dataTables.reloadAjax.min.js"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
	// init component / plugin
	$('.chosen-select').chosen({
		width: '100%',
	});
	$('.chosen-select').val('').chosen().trigger('chosen:updated');
	$('.input-numeric').autoNumeric('init');
	$('.input-date').datetimepicker({
		pickTime: false,
		format: 'DD/MM/YYYY'
	});

	// init value
	<?php if(isset($data['id'])) { ?>
		$('#id').val('<?=$data['id']?>');
		$('#tanggal').val('<?=$data['xtanggal']?>');
		$('#kode_tahap').val('<?=$data['kode_tahap']?>');
		$('#kode_spk').val('<?=$data['kode_spk']?>');
		$('#kode_entity').val('<?=$data['kode_entity']?>');
		$('#volume').autoNumeric('set','<?php echo $data['volume'];?>');
		$('.chosen-select').trigger('chosen:updated');
	<?php } ?>

	// event
	$('#btn-submit').click(function() {
		// validasi
		var isValid = true;
		$.each($('.required'), function(index, item) {
			if($(this).val()=='')
				isValid &= false;
		});
		// --
		if(isValid){
			$.post(
				'<?=base_url()?>index.php/opname-progress/save',
				$('#form-input').serialize(),
				function(respon) {
					alert('Data tersimpan.');
					location.href = '<?=base_url()?>index.php/opname-progress';
				}
			);
		} else {
			alert('Data Belum Lengkap.\n*Wajib Diisi');
		}
	});
})
</script>