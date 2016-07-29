<script type="text/javascript">
jQuery(document).ready(function() {
	// init value
	<?php if(isset($data['id'])) { ?>
	$('#id').val('<?=$data['id']?>');
	$('#kode_entity').val('<?=$data['kode_entity']?>');
	$('#kode_tahap').val('<?=$data['kode_tahap']?>');
	$('#kode_sbdaya').val('<?=$data['kode_sumberdaya']?>');
	$('#volumera').val('<?=$data['volume']?>');
	$('#volumero').val('<?=$data['volume_rev']?>');
	//$('#volumepry').val('<?=$data['volumepry']?>');
	<?php } ?>
	// event
	$('#btn-submit').click(function() {
		// validasi
		var isValid = true;
		$.each($('.required'), function(index, item) {
			if($(this).val()=='')
				isValid &= false;
		});
		
		if(isValid) {
			var data = $('#form-input').serialize();
			$.post(
				'<?=base_url()?>index.php/rab-btl/save',
				$('#form-input').serialize(),
				function(respon) {
					alert('Data tersimpan.');
					location.href = '<?=base_url()?>index.php/rab-btl';
				}
			);
		}
	});
});
</script>