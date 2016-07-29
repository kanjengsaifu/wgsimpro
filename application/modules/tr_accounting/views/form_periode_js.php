<script type="text/javascript">
jQuery(document).ready(function() {
	$('.input-periode').datetimepicker({
		minViewMode: 'months',
		pickTime: false,
		format: 'MM-YYYY'
	});
	// event
	$('#btn-view').click(function() {
		var target = $('#target').val(),
			periode = $('#periode').val(),
			kdcoa = $('#kode_coa option:selected').val();
			divisi = $('#div_id').val();
		
			window.open('<?=base_url()?>index.php/rpt-acc/'+target+'/'+periode+'/'+divisi);
		
		
	});



	$('.chosen-select').val('').chosen().trigger('chosen:updated');
});
</script>