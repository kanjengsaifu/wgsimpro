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
				'<?=base_url()?>index.php/tahap-pekerjaan/save',
				$('#form-input').serialize(),
				function(respon) {
					alert('Data tersimpan.');
					location.href = '<?=base_url()?>index.php/tahap-pekerjaan';
				}
			);
		}
	});
});
</script>