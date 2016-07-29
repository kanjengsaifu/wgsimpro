<script type="text/javascript">
jQuery(document).ready(function() {
	// init component / plugin
	$('.chosen-select').chosen({
		width: '100%'
	});
	$('#recog_date').datetimepicker({
		pickTime: false,
		format: 'DD/MM/YYYY'
	});
	// reset val
	$('.chosen-select').val('').trigger('chosen:updated');
	// init value
	<?php if(isset($data['id'])) { ?>
	$('#id').val('<?=$data['id']?>');
	$('#kode_entity').val('<?=$data['kode_entity']?>').trigger('chosen:updated');
	$('#kode_cluster').val('<?=$data['kode_cluster']?>').trigger('chosen:updated');
	$('#unit_type').val('<?=$data['unit_type']?>').trigger('chosen:updated');
	$('#tower').val('<?=$data['tower']?>');
	$('#no_unit').val('<?=$data['no_unit']?>');
	$('#luas_bangunan').val('<?=$data['luas_bangunan']?>');
	$('#p_tanah').val('<?=$data['p_tanah']?>');
	$('#l_tanah').val('<?=$data['l_tanah']?>');
	$('#luas_tanah').val('<?=$data['luas_tanah']?>');
	$('#no_virtual_account').val('<?=$data['no_virtual_account']?>');
	$('#lantai').val('<?=$data['lantai']?>');
	$('#kavling').val('<?=$data['kavling']?>');
	$('#zone').val('<?=$data['zone']?>');
	$('#blok').val('<?=$data['blok']?>');
	$('#kondisi_kavling').val('<?=$data['kondisi_kavling']?>');
	$('#ishold_admin').attr('checked',<?=$data['ishold_admin']==='1'?'true':'false'?>);
	$('#description').val('<?=$data['description']?>');
	$('#alamat').val('<?=$data['alamat']?>');
	$('#kota').val('<?=$data['kota']?>');
	$('#kodepos').val('<?=$data['kodepos']?>');
	$('#direction').val('<?=$data['direction']?>');
	$('#area_uom').val('<?=$data['area_uom']?>');
	$('#ref_no').val('<?=$data['ref_no']?>');
	$('#remarks').val('<?=$data['remarks']?>');
	$('#issales').attr('checked',<?=$data['issales']==='1'?'true':'false'?>);
	$('#price_display<?=$data['price_display']?>').attr('checked','checked');
	$('#mort_status').val('<?=$data['mort_status']?>');
	$('#recog_date').val('<?=$data['xrecog_date']?>');
	<?php } ?>
	// event
	$('#btn-submit').click(function() {
		var data = $('#form-input').serialize();
		// alert(data);
		$.post(
			'<?=base_url()?>index.php/stock/save',
			data,
			function(respon) {
				// alert(respon);
				if(respon=='') {
					alert('Data tersimpan');
					location.href = '<?=base_url()?>index.php/stock';
				}
			}
		);
	});
});
</script>