<script type="text/javascript">
jQuery(document).ready(function() {
	// init component / plugin
	// reset val
	// init value
	// event
	$('#btn-tambah').click(function() {
        $('#btn-tambah').attr('disabled', true);
        var isvalid = true;
        isvalid &= $('#url').val()==='' ? false : true;
        if(isvalid) {
            $.post(
                '<?=base_url()?>index.php/sinkron/sales/do',
                $('#form-input').serialize(),
                function(respon) {
                    if(respon==='1') {
                        alert('Data tersimpan.');
                        location.href = '<?=base_url()?>index.php/sinkron/sales';
                    }
                }, 'json'
            );
        } else {
            alert('Input belum lengkap.');
        }
        $('#btn-tambah').attr('disabled', false);
	});
});
</script>