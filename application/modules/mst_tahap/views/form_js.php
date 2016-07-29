<script type="text/javascript">
jQuery(document).ready(function() {
	// init value
	<?php if(isset($data['id'])) { ?>
	$('#id').val('<?=$data['id']?>');
	$('#kode_entity').val('<?=$data['kode_entity']?>');
	$('#kode').val('<?=$data['kode']?>');
	$('#nama').val('<?=$data['nama']?>');
	$('#satuan').val('<?=$data['satuan']?>');
	$('#volume').val('<?=$data['volume']?>');
	$('#bobot').val('<?=$data['bobot']?>');
	$('#rolling').val('<?=$data['rolling']?>');
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
				'<?=base_url()?>index.php/tahap/save',
				$('#form-input').serialize(),
				function(respon) {
					alert('Data tersimpan.');
					location.href = '<?=base_url()?>index.php/tahap';
				}
			);
		}
	});
});
</script>