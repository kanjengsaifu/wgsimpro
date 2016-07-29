<script type="text/javascript" src="<?=base_url()?>assets/vendor/plugins/datatables/extensions/ReloadAjax/js/dataTables.reloadAjax.min.js"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
	// init component / plugin
	$('.chosen-select').chosen({
		width: '100%'
	});
	var tblData = $('#datatable').dataTable({
		"bServerSide":true,
		"bProcessing":true,
		"sPaginationType": "full_numbers",
		"bFilter":true,
		"sServerMethod": "POST",
		"sAjaxSource": "<?=base_url()?>index.php/optional-stock/DT/1",
		"order": [[2, "asc"]],
		"columns": [
			{ "name": "kode" },
			{ "name": "konten" },
			{ "name": "no_urut" },
			{ "searchable": false, "sortable": false }
		]
	});
	// reset val
	$('.chosen-select').val('').chosen().trigger('chosen:updated');
	$('.input-numeric').autoNumeric('init');
	// init value
	
	// event
	$('#sfield').on('change', function() {
		var sfield = $(this).val();
		tblData.fnReloadAjax('<?=base_url()?>index.php/optional-stock/DT/'+sfield);
	});
	$('#btn-submit').click(function() {
		var data = $('#form-input').serialize(), sfield = $('#sfield').val();
		// alert(data);
		$.post(
			'<?=base_url()?>index.php/optional-stock/save',
			data,
			function(respon) {
				// alert(respon);
				if(respon=='') {
					alert('Data tersimpan');
					tblData.fnReloadAjax('<?=base_url()?>index.php/optional-stock/DT/'+sfield);
					$('#id').val('');
					$('#kode').val('');
					$('#konten').val('');
					$('#no_urut').val('0');
				}
			}
		);
	});
	$('body').on('click', '.row-edit', function() {
		if(confirm('Anda yakin ingin mengubah data pada baris ini?')) {
			var theTR = $(this).closest('tr');
			$('#id').val($(this).attr('data-id'));
			$('#kode').val(theTR.children().eq(0).text());
			$('#konten').val(theTR.children().eq(1).text());
			$('#no_urut').val(theTR.children().eq(2).text());
		}
	});
	$('body').on('click', '.row-delete', function() {
		var id = $(this).attr('data-id'), sfield = $('#sfield').val();
		if(confirm('Anda yakin ingin menghapus data pada baris ini?')) {
			$.post(
				'<?=base_url()?>index.php/optional-stock/delete/'+id,
				function(respon) {
					if(respon==='') {
						alert('Data berhasil dihapus.');
						tblData.fnReloadAjax('<?=base_url()?>index.php/optional-stock/DT/'+sfield);
					}
				}
			);
		}
	});
});
</script>