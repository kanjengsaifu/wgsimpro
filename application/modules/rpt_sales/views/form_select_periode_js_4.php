<script type="text/javascript">
jQuery(document).ready(function() {
	$('#from,#to').datetimepicker({
		pickTime: false,
		format: 'DD/MM/YYYY'
	});
	// event
	$('#btn-submit').click(function() {
		var from = $('#from').val(), to = $('#to').val(),
			aFrom = from.split('/'), aTo = to.split('/');
		location.href = '<?=base_url()?>index.php/sales/penagihan-kpr/'+aFrom[2]+'-'+aFrom[1]+'-'+aFrom[0]+'/'+aTo[2]+'-'+aTo[1]+'-'+aTo[0];
	});
});
</script>