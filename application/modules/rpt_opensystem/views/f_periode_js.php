<script type="text/javascript">
jQuery(document).ready(function() {

	$('.input-periode').datetimepicker({
		minViewMode: 'months',
		pickTime: false,
		format: 'MM-YYYY'
	});
	// event
	$('#btn-view').click(function() {
		var target = $('#j_piutang').val(),
			periode = $('#periode').val(),
			kdcoa = $('#kode_coa option:selected').val();
			jenis = $('#osys_jenis').val();
		
			window.open('<?=base_url()?>index.php/rpt-opsys/'+target+'/'+periode+'/'+jenis);
		
		
	});

	$('#osys_jenis').multiselect("refresh");
	$('#j_piutang').multiselect("refresh");

	$('.chosen-select').val('').chosen().trigger('chosen:updated');
});
</script>