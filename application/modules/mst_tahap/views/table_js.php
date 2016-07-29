<script type="text/javascript">
	// init action fn
	var action = function(act, id) {
		if(act==='edit') {
			location.href = "<?=base_url()?>index.php/tahap/edit/"+id;
		} else if(act==='delete') {
			if(confirm("Anda yakin akan menghapus data ini?")) {
				$.post("<?=base_url()?>index.php/tahap/delete/"+id,function(ev) {
					if(ev.response==='1') {
						alert('Data berhasil dihapus.');
						location.href = "<?=base_url()?>index.php/tahap";
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
		"sAjaxSource": "<?=base_url()?>index.php/tahap/DT",
		"columns": [
			{ "name": "kode" },
			{ "name": "nama" },
			{ "name": "satuan" },
			{ "name": "volume" },
			{ "name": "bobot" },
			{ "name": "rolling" },
			{ "searchable": false, "sortable": false }
		]
	});
</script>
