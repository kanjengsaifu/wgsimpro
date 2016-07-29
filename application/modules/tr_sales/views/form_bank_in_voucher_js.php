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
		"sAjaxSource": "<?=base_url()?>index.php/bank-print/DT",
	});
	$('body').on('click', '.row-data', function() {
		var dataid = $(this).attr('data-id');
		var datatanggal = $(this).attr('data-tanggal');
		var datarp = $(this).attr('data-nominal');
		$('#pnlbody').show();
		$('#tgl_bayar').val(datatanggal);
		$('#rp').autoNumeric('set',datarp);
		$('#idundefined').val(dataid);
		//alert($('#idundefined').val());
	});
});
</script>