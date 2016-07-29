<script type="text/javascript">
jQuery(document).ready(function() {
	// init component / plugin
	$('.input-date').datetimepicker({
		pickTime: false,
		format: 'DD/MM/YYYY'
	});
	$('.chosen-select').chosen({
		width: '100%',
		allow_single_deselect: true
	});
	$('.chosen-select').val('').chosen().trigger('chosen:updated');
	$('.input-numeric').autoNumeric('init');
	// init value
	<?php if(isset($data['id'])) { ?>
	$('#id').val('<?=$data['id']?>');
	$('#kode').val('<?=$data['kode']?>');
	$('#nama').val('<?=$data['nama']?>');
	$('#jenis').val('<?=$data['jenis']?>');
	$('#type_entity').val('<?=$data['type_entity']?>');
	$('#alamat').val('<?=$data['alamat']?>');
	$('#tgl_mulai').val('<?=$data['xtgl_mulai']?>');
	$('#tgl_selesai').val('<?=$data['xtgl_selesai']?>');
	$('#nilai_developer').autoNumeric('set','<?=$data['nilai_developer']?>');
	$('#pemilik').val('<?=$data['pemilik']?>');
	$('#status_entity').val('<?=$data['status_entity']?>');
	$('#kasie_operasi').val('<?=$data['kasie_operasi']?>');
	$('#kasie_keu').val('<?=$data['kasie_keu']?>');
	$('#kasie_kom').val('<?=$data['kasie_kom']?>');
	$('#mgr_proyek').val('<?=$data['mgr_proyek']?>');
	$('#alamat_marketing').val('<?=$data['alamat_marketing']?>');
	$('#kota_marketing').val('<?=$data['kota_marketing']?>');
	$('#norek_entity').val('<?=$data['norek_entity']?>');
	$('#direktorat').val('<?=$data['direktorat']?>');
	$('#departemen').val('<?=$data['departemen']?>');
	$('#unit_kerja').val('<?=$data['unit_kerja']?>');
	$('#sbu').val('<?=$data['sbu']?>');
	$('.chosen-select').trigger('chosen:updated');
	<?php } ?>
	// event
	$('#btn-submit').click(function() {
		// validasi
		// --
		$.post(
			'<?=base_url()?>index.php/entity/save',
			$('#form-input').serialize(),
			function(respon) {
				alert('Data tersimpan.');
				location.href = '<?=base_url()?>index.php/entity';
			}
		);
	});
});
</script>