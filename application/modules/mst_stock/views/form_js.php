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
	$('.chosen-select').val('').chosen().trigger('chosen:updated');
	$('.input-numeric').autoNumeric('init');
	// init value
	<?php if(isset($data['id'])) { ?>
	$('#id').val('<?=$data['id']?>');
	$('#kode_entity').val('<?=$data['kode_entity']?>');
	$('#no_unit').val('<?=$data['no_unit']?>');
	$('#no_va').val('<?=$data['no_va']?>');
	$('#type_property').val('<?=$data['type_property']?>');
	$('#type_unit').val('<?=$data['type_unit']?>');
	$('#tower_cluster').val('<?=$data['tower_cluster']?>');
	$('#lantai_blok').val('<?=$data['lantai_blok']?>');
	$('#kavling').val('<?=$data['kavling']?>');
	$('#type_kavling').val('<?=$data['type_kavling']?>');
	$('#direction').val('<?=$data['direction']?>');
	$('#mata_angin').val('<?=$data['mata_angin']?>');
	$('#zone').val('<?=$data['zone']?>');
	$('#status_sales').val('<?=$data['status_sales']?>');
	$('#status_mort').val('<?=$data['status_mort']?>');
	$('#land_len').autoNumeric('set','<?=$data['land_len']?>');
	$('#land_wid').autoNumeric('set','<?=$data['land_wid']?>');
	$('#wide_netto').autoNumeric('set','<?=$data['wide_netto']?>');
	$('#wide_gross').autoNumeric('set','<?=$data['wide_gross']?>');
	/*$('#wide_netto_2').autoNumeric('set','<?=$data['wide_netto_2']?>');
	$('#wide_gross_2').autoNumeric('set','<?=$data['wide_gross_2']?>');
	$('#wide_netto_3').autoNumeric('set','<?=$data['wide_netto_3']?>');
	$('#wide_gross_3').autoNumeric('set','<?=$data['wide_gross_3']?>');*/
	$('#dasar_ltanah').val('<?=$data['dasar_ltanah']?>');
	$('#deskripsi').val('<?=$data['deskripsi']?>');
	$('#alamat').val('<?=$data['alamat']?>');
	$('#kota').val('<?=$data['kota']?>');
	$('#kodepos').val('<?=$data['kodepos']?>');
	$('#keterangan').val('<?=$data['keterangan']?>');
	$('#remarks').val('<?=$data['remarks']?>');
	$('#recog_date').val('<?=$data['xrecog_date']?>');
	$('#extra_area').autoNumeric('set','<?=$data['extra_area']?>');
	//$('#ishold').val('<?=$data['ishold']?>');
	$('input[name="ishold"]').prop('checked', <?=$data['ishold']==='1'?'true':'false'?>);
	$('.chosen-select').trigger('chosen:updated');
	<?php } ?>
	// event
	<?php if($this->session->userdata('type_entity')=='LD') { ?>
	$('#lantai_blok, #kavling').on('change', function() {
		if($('#id').val()==='') {
			$('#no_unit').val($('#lantai_blok').val()+'-'+$('#kavling').val()+'-------');
		}
	});
	<?php } elseif($this->session->userdata('type_entity')=='HR') { ?>
	$('#tower_cluster, #lantai_blok').on('change', function() {
		if($('#id').val()==='') {
			$('#no_unit').val($('#tower_cluster').val()+'-'+$('#lantai_blok').val()+'-------');
		}
	});
	<?php } ?>
	$('#btn-submit').click(function() {
		var isValid = true;
		$.each($('.required'), function(index, item) {
			if($(this).val()=='')
				isValid &= false;
		});
		if(isValid) {
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
		} else {
			alert('Field mandatory belum terisi dengan lengkap.');
		}
	});
});
</script>