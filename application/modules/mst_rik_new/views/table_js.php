<script type="text/javascript">
// init action fn
	var action = function(act, id) {
		if(act==='edit') {
			location.href = "<?=base_url()?>index.php/rencana/"+id;
		}
	};

	$('#datatable').dataTable({
		"bServerSide":true,
		"bProcessing":true,
		"sPaginationType": "full_numbers",
		"bFilter":true,
		"sServerMethod": "POST",
		"sAjaxSource": "<?=base_url()?>index.php/rencana/DT",
		"columns": [
			{ "name": "kode" },
			{ "name": "nama" },
			{ "name": "type_entity"},
			{ "searchable": false, "sortable": false}
		]
	});
</script>