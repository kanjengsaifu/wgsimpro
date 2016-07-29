<script type="text/javascript">
jQuery(document).ready(function() {
	$('.chosen-select').chosen({
		width: '100%',
		allow_single_deselect: true
	});
	$('#tanggal').datetimepicker({
		pickTime: false,
		format: 'DD/MM/YYYY'
	});
	
	$('.input-numeric').autoNumeric('init');
	$('#rp').autoNumeric('set','0');
	$('#datatable').dataTable({
		"bServerSide":true,
		"bProcessing":true,
		"sPaginationType": "full_numbers",
		"bFilter":true,
		"sServerMethod": "POST",
		"sAjaxSource": "<?=base_url()?>index.php/bank-post/DT",
	});
	$('body').on('click', '.row-data', function() {
		if(confirm('Ingin Posting?')) {
			var dataid = $(this).attr('data-id');
			$.post(
				'<?=base_url() ?>index.php/bank-post/save/'+dataid,
				function(respon) {
					if(respon.id!=='') {
						alert('Data berhasil dposting!');
						location.href = '<?=base_url() ?>index.php/bank-post';
					}
				},
			'json');
		}
	});
});
</script>