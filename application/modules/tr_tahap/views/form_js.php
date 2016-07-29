<script type="text/javascript">
jQuery(document).ready(function() {
	$('.input-date').datetimepicker({
		minViewMode: 'months',
		pickTime: false,
		format: 'YYYY-MM'
	});
		// event
		/*
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
				'<?=base_url()?>index.php/rab-bl/save',
				$('#form-input').serialize(),
				function(respon) {
					alert('Data tersimpan.');
					location.href = '<?=base_url()?>index.php/rab-bl';
				}
			);
		}
	});*/
});
</script>