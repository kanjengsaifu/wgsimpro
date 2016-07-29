<script type="text/javascript">
	// init action fn
	var action = function(act, id) {
		if(act==='edit') {
			location.href = "<?=base_url()?>index.php/stock/edit/"+id;
		} else if(act==='delete') {
			if(confirm("Anda yakin akan menghapus data ini?")) {
				$.post("<?=base_url()?>index.php/stock/delete/"+id,function(ev) {
					if(ev.response==='1') {
						alert('Data berhasil dihapus.');
						location.href = "<?=base_url()?>index.php/stock";
					} else {
						alert('Data gagal dihapus, mohon diperiksa.');
					}
				});
			}
		}
	};
	// init plugins
	$('#datatable').dataTable({
		"bServerSide":true,
		"bProcessing":true,
		"sPaginationType": "full_numbers",
		"bFilter":true,
		"sServerMethod": "POST",
		"sAjaxSource": "<?=base_url()?>index.php/stock/DT",
		"columns": [
			{ "name": "no_unit" },
			{ "name": "type_property" },
			{ "name": "tower_cluster" },
			{ "name": "type_unit" },
			{ "name": "wide_netto" },
			{ "name": "wide_gross" },
			{ "name": "lantai_blok" },
			{ "name": "direction" },
			{ "name": "mata_angin" },
			{ "searchable": false, "sortable": false }
		]
	});
</script>
