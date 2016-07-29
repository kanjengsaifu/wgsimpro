<script type="text/javascript">
jQuery(document).ready(function() {
	// init component / plugin
	$('.chosen-select').chosen({
		width: '100%'
	});
	$('.input-numeric').autoNumeric('init');
	// reset val
	$('.chosen-select').val('').chosen().trigger('chosen:updated');
	// init value
	<?php if(isset($data['id'])) { ?>
	$('#id').val('<?=$data['id']?>');
	$('#nama').val('<?=$data['nama']?>');
	$('#diskon').autoNumeric('set', '<?=$data['diskon']?>');
	$('#jenis').val('<?=$data['jenis']?>');
	$('#mekanisme').val('<?=$data['mekanisme']?>');
	$('.chosen-select').chosen().trigger('chosen:updated');
	<?php } ?>
	// event
	$('#btn-submit').click(function() {
		$.post(
			'<?=base_url()?>index.php/diskon/save',
			$('#form-input').serialize(),
			function(respon) {
				if(respon==='') {
					alert('Data tersimpan.');
					location.href = '<?=base_url()?>index.php/diskon';
				}
			}
		);
	});
});
</script>