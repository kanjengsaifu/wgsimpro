<script type="text/javascript">
jQuery(document).ready(function() {
	// init component / plugin
	$('.chosen-select').chosen({
		width: '100%',
		allow_single_deselect: true,
		search_contains: true
	});
    $('#tgl_ri').datetimepicker({
		pickTime: false,
		format: 'DD/MM/YYYY'
	});
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
        var data = "";
        if($('#no_unit').val()==='') {
            $.each($('#no_unit option:not(.hidden)'), function(k, v) {
                data += "&no_unit[]="+$(v).val();
            });
        } else {
            data = "&no_unit[]="+$("#no_unit").val();
        }
        $.post(
            '<?=base_url()?>index.php/perijinan/get-units',
            data.substr(1),
            function(respon) {
                if(respon.kode!==undefined && respon.kode==='200') {
                    var target = $('#datatable tbody').html('');
                    $.each(respon.data, function(k, v) {
                        target.append(
                            '<tr>'+
                            '<td></td>'+
                            '<td class="text-center">'+v.no_unit+'<input type="hidden" name="no_unit[]" value="'+v.no_unit+'"/></td>'+
                            '<td class="text-center">'+v.tgl_ra+'</td>'+
                            '<td></td>'+
                            '</tr>'
                        );
                    });
                } else {
                    console.log(respon);
                }
            },
            'json'
        );
    });
	$('#btn-submit').click(function() {
        var isvalid = true;
        isvalid &= $('#datatable tbody tr').length<1 ? false : true;
//        isvalid &= $('#petugas').val()==='' ? false : true;
//        isvalid &= $('#tgl_progress').val()==='' ? false : true;
        if(isvalid) {
            $.post(
                '<?=base_url()?>index.php/perijinan/save/master-2',
                $('#form-unit').serialize()+'&'+$('#form-input').serialize(),
                function(respon) {
                    if(respon==='') {
                        alert('Data tersimpan.');
                        location.href = '<?=base_url()?>index.php/perijinan/master-2';
                    }
                }
            );
        } else {
            alert('Input belum lengkap.');
        }
	});
});
</script>