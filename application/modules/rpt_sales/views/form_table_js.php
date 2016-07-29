<script type="text/javascript">
	$('#datatable-stock').dataTable({
		"bServerSide":true,
		"bProcessing":true, 
		"sPaginationType": "full_numbers",
		"bFilter":true,
		"sServerMethod": "POST",
		"sAjaxSource": "<?=base_url()?>index.php/sales/DT-stock/<?=$data?>",
		"columns": [
			{ "name": "no_unit" },
			{ "name": "nama_nasabah" },
			{ "name": "cara_bayar" }, 
			{ "name": "type_property" },
			{ "name": "tower_cluster" },
			{ "name": "type_unit" },
			{ "name": "wide_netto" },
			{ "name": "wide_gross" },
			{ "name": "lantai_blok" },
			{ "name": "direction" },
			{ "searchable": false, "sortable": false }
		]
	});
</script>