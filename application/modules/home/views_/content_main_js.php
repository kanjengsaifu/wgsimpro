<script type="text/javascript">
jQuery(document).ready(function() {
	$('.chosen-select').chosen({
		width: '100%',
		allow_single_deselect: true
	});
    $('.chosen-select').val('').chosen().trigger('chosen:updated');
    <?php
    if(isset($data['msg']) AND $data['msg']!=='') {
    ?>
    alert('<?=$data['msg']?>');
    <?php
    }
    ?>
	<?php
	if(!empty($data['entity'])) {
	?>
		$('#kode').val('<?=isset($data['entity']['id'])?$data['entity']['id']:''?>').chosen().trigger('chosen:updated');
		$('#pnama').text(': <?=isset($data['entity']['nama'])?$data['entity']['nama']:''?>');
		$('#pjenis').text(': <?=isset($data['entity']['xjenis'])?$data['entity']['xjenis']:''?>');
		$('#ptgl_mulai').text(': <?=isset($data['entity']['xtgl_mulai'])?$data['entity']['xtgl_mulai']:''?>');
		$('#ptgl_selesai').text(': <?=isset($data['entity']['xtgl_selesai'])?$data['entity']['xtgl_selesai']:''?>');
		$('#ptipe_entity').text(': <?=isset($data['entity']['xtype_entity'])?$data['entity']['xtype_entity']:''?>');
		$('#pnilai_developer').text(': <?=isset($data['entity']['nilai_developer'])?$data['entity']['nilai_developer']:''?>');
	<?php
	}
	?>
	// event
	$('#btn-set').click(function() {
		$.post(
			'<?=base_url()?>index.php/set-entity/'+$('#kode').val(),
			function(respon) {
				if(respon.kode!==undefined) {
					alert('Kawasan / Entity terpilih saat ini: '+respon.nama);
					$('#pnama').text(': '+respon.nama);
					$('#pjenis').text(': '+respon.xjenis);
					$('#ptgl_mulai').text(': '+respon.xtgl_mulai);
					$('#ptgl_selesai').text(': '+respon.xtgl_selesai);
					$('#ptipe_entity').text(': '+respon.xtype_entity);
					$('#pnilai_developer').text(': '+respon.nilai_developer);
				} else if(respon.msg!==undefined) {
                    alert(respon.msg);
                    $('.chosen-select').val('').chosen().trigger('chosen:updated')
                }
			}
		);
	});
});
</script>