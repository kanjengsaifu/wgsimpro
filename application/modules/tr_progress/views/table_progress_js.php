<script type="text/javascript">
	// init plugins
	$('#datatable').dataTable({
		"bServerSide":true,
		"bProcessing":true,
		"sPaginationType": "full_numbers",
		"bFilter":true,
        "iDisplayLength": 25,
		"sServerMethod": "POST",
		"sAjaxSource": "<?=base_url()?>index.php/progress/DT",
		"columns": [
			{ "name": "no_unit" },
            { "name": "persen_progress" },
            { "name": "petugas" },
            { "name": "tgl_progress" },
		]
	});
</script>
