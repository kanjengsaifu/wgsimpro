<script type="text/javascript" src="<?=base_url()?>assets/vendor/plugins/datatables/extensions/ReloadAjax/js/dataTables.reloadAjax.min.js"></script>
<script type="text/javascript">
	// init plugins
	var tblData = $('#datatable').dataTable({
		"bServerSide":true,
		"bProcessing":true,
		"sPaginationType": "full_numbers",
		"bFilter":true,
		"sServerMethod": "POST",
		"sAjaxSource": "<?=base_url()?>index.php/diskon/DT",
		"columns": [
			{ "name": "nama" },
			{ "name": "diskon" },
			{ "name": "jenis" },
			{ "name": "mekanisme" },
			{ "searchable": false, "sortable": false }
		]
	});
	// events
	$('body').on('click', '.row-delete', function() {
		if(confirm('Anda yakin ingin menghapus data pada baris ini?')) {
			$.post(
				'<?=base_url()?>index.php/diskon/delete/'+$(this).attr('data-id'),
				function(respon) {
					if(respon==='') {
						alert('Data berhasil dihapus.');
						tblData.fnReloadAjax();
					}
				}
			);
		}
	});
</script>
