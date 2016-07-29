<script type="text/javascript" src="<?=base_url()?>assets/vendor/plugins/datatables/extensions/ReloadAjax/js/dataTables.reloadAjax.min.js"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
	// init component / plugin
	$('.chosen-select').chosen({
		width: '100%',
	});
	$('.chosen-select').val('').chosen().trigger('chosen:updated');
	$('.input-numeric').autoNumeric('init');

	// init value
	<?php if(isset($data['id'])) { ?>
		$('#id').val('<?=$data['id']?>');
		$('#kode_entity').val('<?=$data['kode_entity']?>');
		$('#kode_sumberdaya').val('<?=$data['kode_sumberdaya']?>');
		$('#harga_satuan').val('<?=$data['harga_satuan']?>');
		$('.chosen-select').trigger('chosen:updated');
	<?php } ?>

	var tblData = $('#datatable').dataTable({
		"bServerSide":true,
		"bProcessing":true,
		"sPaginationType": "full_numbers",
		"bFilter":true,
		"sServerMethod": "POST",
		"sAjaxSource": "<?=base_url()?>index.php/harga-sumberdaya/DT/1",
		"columns": [
			{ "name": "nama" },
			{ "name": "harga" },
			{ "name": "harga_satuan_review" },
			{ "searchable": false, "sortable": false }
		]
	});

	$('#kode_sumberdaya').on('change', function() {
		var kodeSumberdaya = $(this).val();
		tblData.fnReloadAjax('<?=base_url()?>index.php/harga-sumberdaya/DT/'+kodeSumberdaya);
	});

	$('body').on('click', '.row-edit', function() {
		if(confirm('Anda yakin ingin mengubah data pada baris ini?')) {
			var theTR = $(this).closest('tr');
			$('#id').val($(this).attr('data-id'));
			$('#harga_satuan').val(theTR.children().eq(1).text());
		}
	});

	$('body').on('click', '.row-delete', function() {
		var id = $(this).attr('data-id'), kodeSumberdaya = $('#kode_sumberdaya').val();
		if(confirm('Anda yakin ingin menghapus data pada baris ini?')) {
			$.post(
				'<?=base_url()?>index.php/harga-sumberdaya/delete/'+id,
				function(respon) {
					if(respon.response==='1') {
						alert('Data berhasil dihapus.');
						tblData.fnReloadAjax('<?=base_url()?>index.php/harga-sumberdaya/DT/'+kodeSumberdaya);
					}
				}
			);
		}
	});

	// event
	$('#btn-submit').click(function() {
		// validasi
		// --
		$.post(
			'<?=base_url()?>index.php/harga-sumberdaya/save',
			$('#form-input').serialize(),
			function(respon) {
				alert('Data tersimpan.');
				location.href = '<?=base_url()?>index.php/harga-sumberdaya';
			}
		);
	});
});
</script>