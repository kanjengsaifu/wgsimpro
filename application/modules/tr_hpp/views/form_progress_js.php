<script type="text/javascript">
jQuery(document).ready(function() {
	// init component / plugin
	$('#datatable-unit').dataTable({
		"bServerSide":true,
		"bProcessing":true,
		"sPaginationType": "full_numbers",
		"bFilter":true,
		"sServerMethod": "POST",
		"sAjaxSource": "<?=base_url()?>index.php/rpt-progress/DT",
		"columns": [
			{ "name": "no_unit" },
			{ "name": "type_property" },
			{ "name": "type_unit" },
			{ "name": "hpp" },
			{ "name": "ri" },
			{ "name": "progress" }
		]
	});
	$('.input-numeric').autoNumeric('init');
	// event
});
</script>