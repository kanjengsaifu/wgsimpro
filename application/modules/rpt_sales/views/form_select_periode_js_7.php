<script type="text/javascript">
jQuery(document).ready(function() {
	$('#from,#to').datetimepicker({
		pickTime: false,
		format: 'DD/MM/YYYY'
	});
	// event
	$('#btn-submit').click(function() {
		var from = $('#from').val(), aFrom = from.split('/');
		location.href = '<?=base_url()?>index.php/sales/kartu-stock-opname/'+aFrom[2]+'-'+aFrom[1]+'-'+aFrom[0];
	});
});
</script>