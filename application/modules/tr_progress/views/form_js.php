<script type="text/javascript">
jQuery(document).ready(function() {
	// init component / plugin
	$('.chosen-select').chosen({
		width: '100%',
		allow_single_deselect: true,
		search_contains: true
	});
    $('#tgl_progress').datetimepicker({
		pickTime: false,
		format: 'DD/MM/YYYY'
	});
	$('.input-numeric').autoNumeric('init');
	// reset val
	$('.chosen-select').val('').chosen().trigger('chosen:updated');
	// init value
	
	// event
    $('#type_property, #tower_cluster, #lantai_blok').on('change', function() {
        $('#no_unit option').removeClass('hidden');
        if($('#type_property').val()!=='')
            $('#no_unit option[data-type_property!="'+$('#type_property').val()+'"]').addClass('hidden');
        if($('#tower_cluster').val()!=='')
            $('#no_unit option[data-tower_cluster!="'+$('#tower_cluster').val()+'"]').addClass('hidden');
        if($('#lantai_blok').val()!=='')
            $('#no_unit option[data-lantai_blok!="'+$('#lantai_blok').val()+'"]').addClass('hidden');
        $('#no_unit').val('').chosen().trigger('chosen:updated');
    });
    $('#btn-tambah').click(function() {
//        var no_unit = $('#no_unit').val();
//        if(no_unit!=='') {
            var target = $('#datatable tbody').html('');
        if($("#no_unit").val()==='') {
            $.each($('#no_unit option:not(.hidden)'), function(k, v) {
                var progress = 0;
                $.post(
                    '<?=base_url()?>index.php/progress/unit',
                    {no_unit: $(v).val()},
                    function(respon) {
                        progress = parseFloat(respon.persen_progress);
                        target.append(
                            '<tr>'+
                            '<td>&nbsp;</td>'+
                            '<td class="text-center">'+$(v).val()+'</td>'+
                            '<td class="text-right">'+progress+'</td>'+
                            '<td><input type="hidden" name="no_unit[]" value="'+$(v).val()+'"/><input type="text" name="persen_progress[]" value="0" class="w150 text-right input-numeric" /></td>'+
                            '<td>&nbsp;</td>'+
                            '</tr>'
                        );
                        $('.input-numeric').autoNumeric('init');
                    },
                    'json'
                );
            });
        } else {
            var progress = 0;
            $.post(
                '<?=base_url()?>index.php/progress/unit',
                {no_unit: $("#no_unit").val()},
                function(respon) {
                    progress = parseFloat(respon.persen_progress);
                    target.append(
                        '<tr>'+
                        '<td class="text-center">'+$("#no_unit").val()+'</td>'+
                        '<td class="text-right">'+progress+'</td>'+
                        '<td><input type="hidden" name="no_unit[]" value="'+$("#no_unit").val()+'"/><input type="text" name="persen_progress[]" value="0" class="w150 text-right input-numeric" /></td>'+
                        '</tr>'
                    );
                    $('.input-numeric').autoNumeric('init');
                },
                'json'
            );
            
        }
            
//            $('#no_unit').val('').chosen().trigger('chosen:updated');
//        }
    });
    $('#btn-input-progress').click(function() {
        var xval = $('#input-progress').autoNumeric('get');
        $('input[name="persen_progress[]"]').each(function() {
            $(this).autoNumeric('set', xval);
        });
    });
	$('#btn-submit').click(function() {
        var isvalid = true;
        isvalid &= $('#datatable tbody tr').length<1 ? false : true;
        isvalid &= $('#petugas').val()==='' ? false : true;
        isvalid &= $('#tgl_progress').val()==='' ? false : true;
        if(isvalid) {
            $.post(
                '<?=base_url()?>index.php/progress/save',
                $('#form-progress').serialize()+'&'+$('#form-input').serialize(),
                function(respon) {
                    if(respon==='') {
                        alert('Data tersimpan.');
                        location.href = '<?=base_url()?>index.php/progress';
                    }
                }
            );
        } else {
            alert('Input belum lengkap.');
        }
	});
});
</script>