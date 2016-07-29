<script type="text/javascript">
jQuery(document).ready(function() {
	// init component / plugin
	$('.chosen-select').chosen({
		width: '100%',
		allow_single_deselect: true
	});
	$('.chosen-select').val('').chosen().trigger('chosen:updated');
	// init value
	<?php if(isset($data['id'])) { ?>
	$('#id').val('<?=$data['id']?>');
	$('#kode').val('<?=$data['kode']?>');
	$('#nama').val('<?=$data['nama']?>');
	$('#kode_jenis').val('<?=$data['kode_jenis']?>').trigger('chosen:updated');
	$('#coa').val('<?=$data['coa']?>');
	$('#kode_entity').val('<?=$data['kode_entity']?>').trigger('chosen:updated');
	$('#no_rekening').val('<?=$data['no_rekening']?>');
	<?php } ?>
	// event
	$('#btn-submit').click(function() {
		// validasi
		// --
		$.post(
			'<?=base_url()?>index.php/bank/accounting/save',
			$('#form-input').serialize(),
			function(respon) {
				alert('Data tersimpan.');
				location.href = '<?=base_url()?>index.php/bank/setup';
			}
		);
	});

	//$('.chosen-select').val('').chosen().trigger('chosen:updated');
});
</script>