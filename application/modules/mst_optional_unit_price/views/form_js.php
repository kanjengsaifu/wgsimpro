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
		"sAjaxSource": "<?=base_url()?>index.php/optional-unit-price/DT/1",
		"order": [[4, "asc"]],
		"columns": [
			{ "name": "grup" },
			{ "name": "kode" },
			{ "name": "konten" },
			{ "name": "formula" },
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
		tblData.fnReloadAjax('<?=base_url()?>index.php/optional-unit-price/DT/'+sfield);
	});
	$('#btn-submit').click(function() {
		var data = $('#form-input').serialize(), sfield = $('#sfield').val();
		// alert(data);
		$.post(
			'<?=base_url()?>index.php/optional-unit-price/save',
			data,
			function(respon) {
				// alert(respon);
				if(respon=='') {
					alert('Data tersimpan');
					tblData.fnReloadAjax('<?=base_url()?>index.php/optional-unit-price/DT/'+sfield);
					$('#id').val('');
					$('#grup').val('').chosen().trigger('chosen:updated');
					$('#kode').val('');
					$('#konten').val('');
					$('#formula').val('');
					$('#no_urut').val('0');
				}
			}
		);
	});
	$('body').on('click', '.row-edit', function() {
		if(confirm('Anda yakin ingin mengubah data pada baris ini?')) {
			var theTR = $(this).closest('tr');
			$('#id').val($(this).attr('data-id'));
			$('#grup').val(theTR.children().eq(0).text()).chosen().trigger('chosen:updated');
			$('#kode').val(theTR.children().eq(1).text());
			$('#konten').val(theTR.children().eq(2).text());
			$('#formula').val(theTR.children().eq(3).text());
			$('#no_urut').val(theTR.children().eq(4).text());
		}
	});
	$('body').on('click', '.row-delete', function() {
		var id = $(this).attr('data-id'), sfield = $('#sfield').val();
		if(confirm('Anda yakin ingin menghapus data pada baris ini?')) {
			$.post(
				'<?=base_url()?>index.php/optional-unit-price/delete/'+id,
				function(respon) {
					if(respon==='') {
						alert('Data berhasil dihapus.');
						tblData.fnReloadAjax('<?=base_url()?>index.php/optional-unit-price/DT/'+sfield);
					}
				}
			);
		}
	});
});
</script>