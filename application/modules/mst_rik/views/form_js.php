<script type="text/javascript">
jQuery(document).ready(function() {
	// init plugin
	$('.chosen-select').chosen({
		width: '100%',
	});
	// init value
	<?php if(isset($data['ra_biayas'])) { 
		$sumRp = 0;
		foreach ($data['ra_biayas'] as $k => $v) { 
			$sumRp += $v['biaya']; ?>
	var content = '';
	var target = 'detil_rb';
	content += '<div class="row <?=$v['kode_biaya']?> mod-row">';
	content += '<div class="col-lg-7">';
	content += '<input type="text" class="hidden" id="" name="kode_biaya[]" value="<?=$v['kode_biaya']?>" />';
	content += '<a href="javascript:" alt="Delete row" title="Remove row" class="text-danger fs12 text-right"><span class="glyphicons glyphicons-remove acc-row pt5 rb"></span></a>';
	content += '&nbsp;&nbsp;&nbsp;&nbsp;<label class="pt3"><b><?=$v['konten']?></b></label>';
	content += '</div>';
	content += '<div class="col-lg-1 hidden">';
	content += '<input type="text" class="input-sm form-control input-numeric text-right" placeholder="Volume" data-m-dec="0" id="" name="volume_rb[]" value="<?=$v['volume']?>" />';
	content += '</div>';
	content += '<div class="col-lg-1 hidden">';
	content += '<input type="text" class="input-sm form-control text-center" placeholder="Satuan" id="" name="satuan_rb[]" value="<?=$v['satuan']?>" />';
	content += '</div>';
	content += '<div class="col-lg-1">';
	content += '<input type="text" class="input-sm form-control input-numeric" placeholder="Bobot" id="" name="bobot_rb[]" value="<?=$v['bobot']?>" />';
	content += '</div>';
	content += '<label class="col-lg-1 pt5 control-label"><b>Rp.</b></label>';
	content += '<div class="col-lg-2">';
	content += '<input type="text" data-target="total_rencana_biaya" class="rencana ra-biaya-rp input-sm form-control input-numeric text-right required" placeholder="Nilai Biaya" id="" name="biaya_rb[]" value="<?=$v['biaya']?>" />';
	content += '</div>';
	content += '</div>';
	$('#' + target).append(content);
	$('.input-numeric').autoNumeric('init');
	<?php } ?>
	$('#total_rencana_biaya').autoNumeric('set', <?=$sumRp?>);
	<?php } ?>
	/** 
	 * RENCANA BIAYA 
	 */
	$('body').on('click', '.btn-add-rencana-biaya', function() {
		var indexBiaya = $('#rencana-biaya option:selected').index();
		var valBiaya = $('#rencana-biaya option:selected');
		if(indexBiaya == '0' && indexBiaya != undefined){
			alert('Produk Belum Dipilih');
		} else {
			if($('#detil_rb').children().hasClass(valBiaya.val())){
				alert('Data Telah Ada Dalam Daftar');
			} else {
				var content = '';
				var target = $(this).attr('data-target');
				content += '<div class="row '+valBiaya.val()+' mod-row">';
				content += '<div class="col-lg-7">';
				content += '<input type="text" class="hidden" id="" name="kode_biaya[]" value="'+valBiaya.val()+'" />';
				content += '<a href="javascript:" alt="Delete row" title="Remove row" class="text-danger fs12 text-right"><span class="glyphicons glyphicons-remove acc-row pt5 rb"></span></a>';
				content += '&nbsp;&nbsp;&nbsp;&nbsp;<label class="pt3"><b>'+valBiaya.text()+'</b></label>';
				content += '</div>';
				content += '<div class="col-lg-1 hidden">';
				content += '<input type="text" class="input-sm form-control input-numeric text-right" placeholder="Volume" data-m-dec="0" id="" name="volume_rb[]" value="" />';
				content += '</div>';
				content += '<div class="col-lg-1 hidden">';
				content += '<input type="text" class="input-sm form-control text-center" placeholder="Satuan" id="" name="satuan_rb[]" value="" />';
				content += '</div>';
				content += '<div class="col-lg-1">';
				content += '<input type="text" class="input-sm form-control input-numeric" placeholder="Bobot" id="" name="bobot_rb[]" value="" />';
				content += '</div>';
				content += '<label class="col-lg-1 pt5 control-label"><b>Rp.</b></label>';
				content += '<div class="col-lg-2">';
				content += '<input type="text" data-target="total_rencana_biaya" class="rencana ra-biaya-rp input-sm form-control input-numeric text-right required" placeholder="Nilai Biaya" id="" name="biaya_rb[]" value="0" />';
				content += '</div>';
				content += '</div>';
				$('#' + target).append(content);
				$('.input-numeric').autoNumeric('init');
			}
		}
	});

	$('body').on('change', '.ra-biaya-rp', function() {
		var sumRaBiayaRp = 0;
		$.each($('.ra-biaya-rp'), function(index, item) {
			sumRaBiayaRp += parseFloat($(this).autoNumeric('get'));
		});
		$('#total_rencana_biaya').autoNumeric('set', sumRaBiayaRp);
	});

	$('#btn_submit_rik').click(function() {
		var isValid = true;
		// $.each($('.required'), function(index, item) {
		// 	if($(this).val()=='')
		// 		isValid &= false;
		// });
		if(isValid){
			var data = $('#form-rencana-biaya').serialize();
			// alert(data);
			$.post(
				'<?=base_url()?>index.php/rencana/save',
				data,
				function(respon) {
					if(respon.status==='200') {
						location.href="<?=base_url()?>index.php/rencana";
					} else {
						alert(respon.msg);
					}
				}
			);	
		} else {
			alert('Harap Isi Field Yang Masih Kosong');
		}		
	});

})
</script>