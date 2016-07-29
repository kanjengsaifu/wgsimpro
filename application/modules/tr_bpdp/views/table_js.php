<script type="text/javascript">
	$('#datatable').dataTable({
		"bServerSide":true,
		"bProcessing":true,
		"sPaginationType": "full_numbers",
		"bFilter":true,
		"sServerMethod": "POST",
		"sAjaxSource": "<?=base_url()?>index.php/bpdp/DT",
		"columns": [
			{ "name": "kode" },
			{ "name": "nama" },
			{ "name": "jenis" },
			{ "name": "type_entity" },
			{ "name": "tgl_mulai" },
			{ "name": "tgl_selesai" },
			{ "name": "nilai_developer" },
			{ "name": "pemilik" },
			{ "name": "status_entity" },
			{ "searchable": false, "sortable": false },
		]
	});
</script>