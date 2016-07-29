<script type="text/javascript">
	// init plugins
	$('#datatable').dataTable({
		"bServerSide":true,
		"bProcessing":true,
		"sPaginationType": "full_numbers",
		"bFilter":true,
		"sServerMethod": "POST",
		"sAjaxSource": "<?=base_url()?>index.php/bank/accounting/DT",
		"columns": [
			{ "name": "kode" },
			{ "name": "nama" },
			{ "name": "no_rekening" },
			{ "name": "kode_entity" },
			{ "name": "kode_jenis" },
			{ "searchable": false, "sortable": false }
		]
	});
	$('body').on('click', '.row-delete', function() {
		if(confirm('ANda yakin ingin menghapus data bank ini?')) {
			$.post(
				'<?=base_url()?>index.php/bank/delete/'+$(this).attr('data-id'),
				function(respon) {
					if(respon==='') {
						alert('Data terhapus.');
						location.href = '<?=base_url()?>index.php/bank';
					}
				}
			);
		}
	});
</script>
