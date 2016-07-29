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
	$('#kd_jenis').val('<?=$data['kode_jenis']?>');
	$('#kd_entity').val('<?=$data['kode_entity']?>').trigger('chosen:updated');
	$('#no_rekening').val('<?=$data['no_rekening']?>').trigger('chosen:updated');
	$('input[name="iskpr"]').prop('checked', <?=$data['iskpr']==='1'?'true':'false'?>);
	$('input[name="is_ops"]').prop('checked', <?=$data['is_ops']==='1'?'true':'false'?>);
	$('input[name="is_tamp"]').prop('checked', <?=$data['is_tamp']==='1'?'true':'false'?>);
	<?php } ?>
	// event
	$('#btn-submit').click(function() {
		// validasi
		// --
		$.post(
			'<?=base_url()?>index.php/bank/save',
			$('#form-input').serialize(),
			function(respon) {
				alert('Data tersimpan.');
				location.href = '<?=base_url()?>index.php/bank';
			}
		);
	});

	$('.chosen-select').val('').chosen().trigger('chosen:updated');
});
</script>