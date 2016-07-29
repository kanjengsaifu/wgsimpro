<script type="text/javascript">
jQuery(document).ready(function() {

	$('.input-periode').datetimepicker({
		minViewMode: 'months',
		pickTime: false,
		format: 'MM-YYYY'
	});
	// event
	$('#btn-view').click(function() {
		var periode = $('#periode').val();
		window.open('<?=base_url()?>index.php/rpt/rk/'+periode);
	});

	$('#osys_jenis').multiselect("refresh");
	$('#j_piutang').multiselect("refresh");

	$('.chosen-select').val('').chosen().trigger('chosen:updated');
});
</script>