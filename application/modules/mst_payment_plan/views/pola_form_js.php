<script type="text/javascript">
jQuery(document).ready(function() {
	// init component / plugin
	$('.chosen-select').chosen({
		width: '100%'
	});
	// reset val
	$('.chosen-select').val('').chosen().trigger('chosen:updated');
	// init value
	<?php if(isset($data[0])) { ?>
	// assign val
	$('#cara_bayar').val('<?=$data[0]['cara_bayar']?>').chosen().trigger('chosen:updated');
	$('#kode_pay').val('<?=$data[0]['kode_pay']?>');
	$('#deskripsi').val('<?=$data[0]['deskripsi']?>');
	// reset
	$('#cara_bayar').attr('disabled', true).chosen().trigger('chosen:updated');
	$('#kode_pay').attr('disabled', 'disabled');
	$('#deskripsi').attr('disabled', 'disabled');
	<?php 
		foreach ($data as $k => $v) {
	?>
	$('#datatable tbody').append(
		'<tr>'+
		'<td class="text-center"><?=$v['kode_item']?></td>'+
		'<td><?=$v['item_deskripsi']?></td>'+
		'<td class="text-center"><?=$v['install_num']?></td>'+
		'<td class="text-center"><?=$v['persentase']?></td>'+
		'<td class="text-right input-numeric"><?=$v['rp']?></td>'+
		'<td class="text-center"><a href="javascript:" data-id="<?=$v['id']?>" class="row-delete"><span class="glyphicons glyphicons-bin"></span></td>'+
		'</tr>'
	);
	<?php
		}
	?>
	$('.input-numeric').autoNumeric('init', {aPad: false});
	<?php
	} 
	?>
	// event
	$('#btn-submit').click(function() {
		$('#cara_bayar').attr('disabled', false);
		$('#kode_pay').attr('disabled', false);
		$('#deskripsi').attr('disabled', false);
		$(this).toggleClass('disabled');
		$.post(
			'<?=base_url()?>index.php/payment-plan/save/pola',
			$('#form-input').serialize(),
			function(respon) {
				if(respon==='') {
					alert('Data tersimpan.');
					location.href = '<?=base_url()?>index.php/payment-plan/form/pola/'+$('#kode_pay').val();
				}
			}
		);
	});
	$('body').on('click', '.row-delete', function() {
		if(confirm('Anda yakin ingin menghapus data pada baris ini?')) {
			$.post(
				'<?=base_url()?>index.php/payment-plan/delete/pola-item/'+$(this).attr('data-id'),
				function(respon) {
					if(respon==='') {
						alert('Data terhapus');
						location.href = '<?=base_url()?>index.php/payment-plan/form/pola/'+$('#kode_pay').val();
					}
				}
			);
		}
	});
});
</script>