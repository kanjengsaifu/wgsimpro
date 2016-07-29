<script type="text/javascript">
	var action = function(act, id) {
		if(act==='edit') {
			location.href = "<?=base_url()?>index.php/entity/edit/"+id;
		} else if(act==='delete') {
			if(confirm("Anda yakin akan menghapus data ini?")) {
				$.post("<?=base_url()?>index.php/entity/delete/"+id,function(ev) {
					if(ev.response==='1') {
						alert('Data berhasil dihapus.');
						location.href = "<?=base_url()?>index.php/entity";
					} else {
						alert('Data gagal dihapus, mohon diperiksa.');
					}
				});
			}
		}
	};
	$('#datatable').dataTable({
		"bServerSide":true,
		"bProcessing":true,
		"sPaginationType": "full_numbers",
		"bFilter":true,
		"sServerMethod": "POST",
		"sAjaxSource": "<?=base_url()?>index.php/entity/DT",
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