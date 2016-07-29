<script type="text/javascript">
jQuery(document).ready(function() {
    $('.chosen-select').chosen({
		width: '100%'
	});
    $('#kode_entity').bootstrapDualListbox();
    $('.chosen-select').val('').chosen().trigger('chosen:updated');
	// init value
	<?php if(isset($data['id'])) { ?>
	$('#id').val('<?=$data['id']?>');
    $('#username').val('<?=$data['username']?>');
	$('#nama').val('<?=$data['nama']?>');
    $('#user_group').val('<?=$data['user_group']?>').chosen().trigger('chosen:updated');
	<?php } ?>
	// event
	$('#btn-submit').click(function() {
		// validasi
		var isValid = true;
        isValid &= $('#username').val()==='' ? false : true;
        isValid &= $('#nama').val()==='' ? false : true;
        isValid &= $('#user_group').val()==='' ? false : true;
		if(isValid) {
			var data = $('#form-input').serialize();
			$.post(
				'<?=base_url()?>index.php/user/save',
				data,
				function(respon) {
					alert('Data tersimpan.');
					location.href = '<?=base_url()?>index.php/user';
				}
			);
		} else {
            alert('Input belum lengkap.');
        }
	});
});
</script>