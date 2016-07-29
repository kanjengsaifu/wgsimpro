<script type="text/javascript">
	// init action fn
	var action = function(act, id) {
		if(act==='edit') {
			location.href = "<?=base_url()?>index.php/kontrak/edit/"+id;
		} else if(act==='delete') {
			if(confirm("Anda yakin akan menghapus data ini?")) {
				$.post("<?=base_url()?>index.php/kontrak/delete/"+id,function(ev) {
					if(ev.response==='1') {
						alert('Data berhasil dihapus.');
						location.href = "<?=base_url()?>index.php/kontrak";
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
		"sAjaxSource": "<?=base_url()?>index.php/kontrak/DT",
		"columns": [
			{ "name": "nomor_kontrak" },
			{ "name": "nilai_kontrak" },
			{ "name": "retensi" },
			{ "name": "tanggal_mulai" },
			{ "name": "tanggal_akhir" },
			{ "name": "nama_rekanan" },
			{ "searchable": false, "sortable": false }
		]
	});
</script>
