<script type="text/javascript">
jQuery(document).ready(function() {
	$('.chosen-select').chosen({
		width: '100%',
		allow_single_deselect: true
	});
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

	// event
	$('#btn-set').click(function() {
		$.post(
			'<?=base_url()?>index.php/set-entity/'+$('#kode').val(),
			function(respon) {
				//alert(respon.kode);
				if(respon.kode!==undefined) {
					
					$('#pnama').text(': '+respon.nama);
					$('#pjenis').text(': '+respon.xjenis);
					$('#ptgl_mulai').text(': '+respon.xtgl_mulai);
					$('#ptgl_selesai').text(': '+respon.xtgl_selesai);
					$('#ptipe_entity').text(': '+respon.xtype_entity);
					$('#pnilai_developer').text(': '+respon.nilai_developer);
					
					alert('Kawasan / Entity terpilih saat ini: '+respon.nama);
					
				}
			}
		);
	});

	<?php
	}

	if(!empty($data['divisi'])) {
	?>
		$('#kode').val('<?=isset($data['divisi']['kode'])?$data['divisi']['kode']:''?>').chosen().trigger('chosen:updated');
		$('#pnama').text(': <?=isset($data['divisi']['nama'])?$data['divisi']['nama']:''?>');
		$('#punit').text(': <?=isset($data['divisi']['unit_kerja'])?$data['divisi']['unit_kerja']:''?>');

		$('#btn-set').click(function() {
		$.post(
			'<?=base_url()?>index.php/set-divisi/'+$('#kode').val(),
			function(respon) {
				if(respon.kode!==undefined) {
					$('#pnama').text(': '+respon.nama);
					$('#punit').text(': '+respon.unit_kerja);
					//alert('<?=$this->session->userdata("kode_divisi")?>');
					alert('Kawasan / Departemen terpilih saat ini: '+respon.nama);
				}
			}
			);
		});
	<?php
	}
	?>
});
</script>