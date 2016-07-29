<script type="text/javascript">
jQuery(document).ready(function() {
	// init value
	<?php if(isset($data['id'])) { ?>
	$('#id').val('<?=$data['id']?>');
	$('#kode').val('<?=$data['kode']?>');
	$('#jenis').val('<?=$data['jenis']?>');
	$('#nama').val('<?=$data['nama']?>');
	$('#satuan').val('<?=$data['satuan']?>');
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
				'<?=base_url()?>index.php/sumberdaya/save',
				$('#form-input').serialize(),
				function(respon) {
					alert('Data tersimpan.');
					location.href = '<?=base_url()?>index.php/sumberdaya';
				}
			);
		}
	});
});
</script>