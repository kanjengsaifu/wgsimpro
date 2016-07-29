<script type="text/javascript">
jQuery(document).ready(function() {
	$('.chosen-select').chosen({
		width: '100%',
		allow_single_deselect: true
	});
	

		$('#kode').val('<?=isset($data['divisi']['kode_unit'])?$data['divisi']['kode_unit']:''?>').chosen().trigger('chosen:updated');
		$('#pnama').text(': <?=isset($data['divisi']['nama_unit'])?$data['divisi']['nama_unit']:''?>');
		$('#punit').text(': <?=isset($data['divisi']['unit_kerja'])?$data['divisi']['unit_kerja']:''?>');

		$('#btn-set').on('click',function() {
		$.post(
			'<?=base_url()?>index.php/set-divisi/'+$('#kode').val(),
			function(respon) {
				//alert(respon.nama_unit);
				//console.log(respon.kode_divisi);
				if(respon.kode_unit!==undefined) {
					$('#pnama').text(': '+respon.nama_unit);
					$('#punit').text(': '+respon.unit_kerja);
					//alert('<?=$this->session->userdata("kode_divisi")?>');
					alert('Departemen terpilih saat ini: '+respon.nama_unit+'\nUntuk Kawasan: '+respon.nama_entity);
				}
			}
			);
		});
	
});
</script>