<script type="text/javascript">
jQuery(document).ready(function() {
    var arrUrut = [];
	// init component / plugin
	$('.chosen-select').chosen({
		width: '100%',
		allow_single_deselect: true
	});
	$('.chosen-select').val('').chosen().trigger('chosen:updated');
	$('.input-numeric').autoNumeric('init', { 'mDec': '0' });
    <?php if(isset($data['data']['id'])) {?>
    $('#id').val('<?=$data['data']['id']?>');
    $('#kode').val('<?=$data['data']['kode']?>');
    $('#konten').val('<?=$data['data']['konten']?>');
    $('#no_urut').val('<?=$data['data']['no_urut']?>');
    <?php } 
    if(isset($data['uruts'])) { 
        foreach($data['uruts'] as $v) {
    ?>
    arrUrut.push(<?=$v['no_urut']?>);
    <?php
        }
    ?>
    <?php } ?>
	// event
	$('#btn-submit').click(function() {
        var isValid = true, msg = '';
        if($('#kode').val()==='') { isValid &= false; msg += "\n- Kode Dokumen tidak boleh kosong."; }
        if($('#konten').val()==='') { isValid &= false; msg += "\n- Nama Dokumen tidak boleh kosong."; }
        if(parseFloat($('#no_urut').autoNumeric('get'))<1) { isValid &= false; msg += "\n- No. Urut Prioritas tidak boleh kosong."; }
        if($.inArray(parseInt($('#no_urut').autoNumeric('get')), arrUrut)>=0) { isValid &=false; msg += "\n- No. Urut Prioritas telah dipakai." }
		if(isValid) {
			$.post(
				'<?=base_url()?>index.php/optional-perijinan/save',
				$('#form-input').serialize(),
				function(respon) {
					if(respon==='') {
						alert('Data tersimpan.');
                        location.href = '<?=base_url()?>index.php/optional-perijinan';
					}
				}
			);
		} else {
			alert('Periksa kembali inputan anda: '+msg);
		}
	});
});
</script>