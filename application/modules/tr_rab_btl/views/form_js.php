<script type="text/javascript">
jQuery(document).ready(function() {
	
	$('.chosen-select').chosen({
		width: '100%',
	});
	
	// init value
	<?php if(isset($data['id'])) { ?>
	$('#id').val('<?=$data['id']?>');
	$('#kode_entity').val('<?=$data['kode_entity']?>');
	$('#kode_coa').val('<?=$data['kode_coa']?>');
	 $('#kode_coa').trigger("chosen:updated");
	$('#kode_sumberdaya').val('<?=$data['kode_sumberdaya']?>');
	 $('#kode_sumberdaya').trigger("chosen:updated");
	$('#harga').val('<?=$data['harga']?>');
	$('#harga_rev').val('<?=$data['harga_rev']?>');
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