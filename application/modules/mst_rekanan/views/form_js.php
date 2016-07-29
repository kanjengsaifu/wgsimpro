<script type="text/javascript">
jQuery(document).ready(function() {
	// init value
	<?php if(isset($data['id'])) { ?>
	$('#id').val('<?=$data['id']?>');
	$('#kode_rekanan').val('<?=$data['kode_rekanan']?>');
	$('#nama').val('<?=$data['nama']?>');
	$('#npwp').val('<?=$data['npwp']?>');
	$('#ktp').val('<?=$data['ktp']?>');
	$('#alamat').val('<?=$data['alamat']?>');
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
			//var data = $('#form-input').serialize();
			$.post(
				'<?=base_url()?>index.php/rekanan/save',
				$('#form-input').serialize(),
				function(respon) {
					alert('Data tersimpan.');
					location.href = '<?=base_url()?>index.php/rekanan';
				}
			);
		}
	});
});
</script>