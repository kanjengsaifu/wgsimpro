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
                '<?=base_url()?>index.php/sinkron/trx/do',
                function(respon) {
                    if(respon.kode_entity!==undefined && respon.kode_entity!=='') {
                        $.ajax({
                            type            : 'POST',
                            url             : $('#url').val()+'/index.php/api/do_sinkron_trx',
                            crossDomain     : true,
                            contentType     : 'application/x-www-form-urlencoded',
                            dataType        : 'json',
                            data            : { data : JSON.stringify(respon) },
                            success         : function(res) {
                                if(res='1') {
                                    alert('Data tersimpan.');
                                    location.href = '<?=base_url()?>index.php/sinkron/trx';
                                } else {
                                    alert("Terjadi kesalahan, hubungi administrator.\n"+respon);
                                }
                            },
                            error           : function(res) {
                                alert(res);
                            }
                        });
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