<script type="text/javascript">
jQuery(document).ready(function() {
	// init plugins
	oTbl = $('#datatable').dataTable({
		"bServerSide":true,
		"bProcessing":true,
		"sPaginationType": "full_numbers",
		"bFilter":true,
		"sServerMethod": "POST",
		"iDisplayLength": 50,
		"sAjaxSource": "<?=base_url()?>index.php/jurnal/ar/DT"
	});
	// events
	$('#datatable').on('click', '.btn-posting', function() {
		var payid = $(this).attr('data-payid');
		$.post(
			'<?=base_url()?>index.php/jurnal/ar/'+payid,
			function(respon) {
				if(respon==='') {
					alert('Data berhasil di-posting.');
					location.href = '<?=base_url()?>index.php/jurnal/ar';
				}
			}
		);
	});
});
</script>
