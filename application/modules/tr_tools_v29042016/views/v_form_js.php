<script type="text/javascript">
jQuery(document).ready(function() {
	
	$('#btn-submit').click(function() {
		// validasi
		var isValid = true;
		$.each($('.required'), function(index, item) {
			if($(this).val()=='')
				isValid &= false;
		});
		
		//if(isValid) {
			//var data = $('#form-input').serialize();
			$.post(
				'<?=base_url()?>index.php/gen_coacom',
				null,
				function(respon) {
					if(respon.msg>0){
						alert('Proses Update Data Berhasil');
					}
					console.log(respon.msg);
				}
			);
		//}
	});
});
</script>