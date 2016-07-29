<script type="text/javascript">
	// init plugins
    $('.chosen-select').chosen({
		width: '100%',
		allow_single_deselect: true
	});
	$('#datatable').dataTable({
		"bServerSide":true,
		"bProcessing":true,
		"sPaginationType": "full_numbers",
		"bFilter":true,
		"sServerMethod": "POST",
		"sAjaxSource": "<?=base_url()?>index.php/bank-alokasi/DT",
		"columns": [
			{ "name": "kode" },
			{ "name": "nama" },
			{ "name": "no_rekening" },
			{ "name": "nama_entity" },
			{ "searchable": false, "sortable": false }
		]
	});
	$('.input-numeric').autoNumeric('init');
	$('.chosen-select').val('').chosen().trigger('chosen:updated');
    $('#tgl_akad_kredit').datetimepicker({
		pickTime: false,
		format: 'DD/MM/YYYY'
	});
	// event
	$('body').on('click', '.row-view', function() {
		var kode = $(this).attr('data-kode');
		$.post(
			'<?=base_url()?>index.php/bank-alokasi/'+kode,
			function(respon) {
				$('#xkode').attr('data-kode', respon.kode);
				$('#kode_bank').val(respon.kode);
				$('#pkode_nama').html('<h4>'+respon.kode+' / '+respon.nama+'</h4>');
				$('#pno_rekening').html('<h4>'+respon.no_rekening+'</h4>');
				$('#persentase').autoNumeric('set', 0);
				$('#keterangan').val('');
                $('#id').val('');
                $('#indikator').val('').chosen().trigger('chosen:updated');
//				$('#kd_entity').val(respon.kode_entity).trigger('chosen:updated');
				var tbody = $('#datatable-alokasi tbody').html(''),
						tfoot = $('#datatable-alokasi tfoot').html('');
				if(respon.items!==undefined && respon.items[0].keterangan!=='') {
					$.each(respon.items, function(index, item) {
						tbody.append(
							'<tr>'+
							'<td>'+item.persentase+' %</td>'+
							'<td><a href="javascript:" class="row-edit" title="Ubah" alt="Ubah" data-id="'+item.id+'">'+item.keterangan+'</a></td>'+
                            '<td>'+item.indikator+'</td>'+
                            '<td><a href="javascript:" class="row-delete" title="Hapus" alt="Hapus" data-id="'+item.id+'"><span class="glyphicon glyphicon-trash"></span></a></td>'+
							'</tr>'
						);
					});
				}
				$('#persentase').focus();
			}
		);
	});
	$('#btn-submit').click(function() {
        var isValid = true;
        // validasi input
        isValid &= parseFloat($('#persentase').autoNumeric('get'))>0 ? true : false;
        isValid &= $('#keterangan').val()!=='' ? true : false;
        isValid &= $('#indikator').val()!=='' ? true : false;
        // validasi persen
        var sumPersen = 0;
        $('#datatable-alokasi tbody tr').each(function(index, item) {
            if($('#id').val() !== $(item).children().eq(1).children().attr('data-id'))
                sumPersen += parseFloat($(item).children().eq(0).text().replace(new RegExp('%', 'g'), ''));
        });
        sumPersen += parseFloat($('#persentase').autoNumeric('get'));
        isValid &= sumPersen<=100 ? true : false;
        if(isValid) {
            $.post(
                '<?=base_url()?>index.php/bank-alokasi/save',
                $('#form-input').serialize(),
                function(respon) {
                    if(respon==='') {
                        $('#persentase').autoNumeric('set', 0);
                        $('#keterangan').val('');
                        alert('Data tersimpan');
                        // location.href = "<?=base_url()?>index.php/bank-alokasi"
                        $('#progress').autoNumeric('set', 0);
                        $('#kd_perijinan').val('').chosen().trigger('chosen:updated');
                        $('#xkode').trigger('click');
                    }
                }
            );
        } else {
            alert('Input belum valid, mohon periksa kembali.');
        }
	});

	$('#indikator').on('change',function(){
		var valu = $(this).val();
        $('#tgl_akad_kredit').val('1');
        $('#div_tglakad').addClass('hidden');
        $('#div_progres').addClass('hidden');
        $('#progress').autoNumeric('set', 0);
        $('#div_ijin').addClass('hidden');
        $('#kd_perijinan').val('').trigger('chosen:updated');
		if(valu=='tgl_akad_kredit'){
			//$('#div_tglakad').trigger('liszt:updated');
//			$('#div_tglakad').removeClass('hidden');
//			$('#div_tglakad').trigger('chosen:updated');
            $('#tgl_akad_kredit').val('1');
			//$('#kd_perijinan_chosen').attr('style','width: 100%;');
		}else{
			$('#div_tglakad').addClass('hidden');
            $('#tgl_akad_kredit').val('0');
		}
		if(valu=='progress'){
			$('#div_progres').removeClass('hidden');
		}else{
			$('#div_progres').addClass('hidden');
		} 
		if(valu=='perijinan'){ 
			$('#div_ijin').removeClass('hidden');
			
		}else{
			$('#div_ijin').addClass('hidden');
		}
	});
    $('#datatable-alokasi').on('click', '.row-edit', function() {
        if(confirm('Anda yakin ingin merubah data ini?')) {
            var theTR = $(this).parents('tr');
            $('#persentase').autoNumeric('set', theTR.children().eq(0).text().replace(new RegExp('%', 'g'), ''));
            $('#keterangan').val(theTR.children().eq(1).children().text());
            $('#id').val(theTR.children().eq(1).children().attr('data-id'));
            var ind = theTR.children().eq(2).text(),
                arrInd = ind.split(':');
            $('#div_progres').addClass('hidden');
            $('#progress').autoNumeric('set', 0);
            $('#div_ijin').addClass('hidden');
            $('#kd_perijinan').val('').trigger('chosen:updated');
            $('#tgl_akad_kredit').val('0');
            if(arrInd[0]==='Progress') {
                $('#indikator').val('progress').chosen().trigger('chosen:updated');
                $('#progress').autoNumeric('set', arrInd[1].replace(/%/g, '').substr(1));
                $('#div_progres').removeClass('hidden');
            } else if(arrInd[0]==='Dokumen') {
                $('#indikator').val('perijinan').chosen().trigger('chosen:updated');
                $('#kd_perijinan').val($('#kd_perijinan option').filter(function() { return $(this).html() === arrInd[1].substr(1); }).val()).trigger('chosen:updated');
                $('#div_ijin').removeClass('hidden');
            } else {
                $('#indikator').val('tgl_akad_kredit').chosen().trigger('chosen:updated');
                $('#tgl_akad_kredit').val('1');
            }
        }
    });
    $('#datatable-alokasi').on('click', '.row-delete', function() {
        if(confirm('Anda yakin ingin menghapus data ini?')) {
            $.get(
                '<?=base_url()?>index.php/bank-alokasi/delete/'+$(this).attr('data-id'),
                function() {
                    alert('Data terhapus.');
                    $('#xkode').trigger('click');
                }
            );
        }
    });
	/*
	$('body').on('click', '.row-delete', function() {
		if(confirm('ANda yakin ingin menghapus data alokasi untuk bank ini?')) {
			$.post(
				'<?=base_url()?>index.php/bank-alokasi/delete/'+$(this).attr('data-id'),
				function(respon) {
					if(respon==='') {
						alert('Data terhapus.');
						location.href = '<?=base_url()?>index.php/bank-alokasi';
					}
				}
			);
		}
	});
	*/
	$(document).ready(function(){
//		$('.chosen-select').trigger('chosen:updated');
//		$('#indikator_chosen').attr('style','width: 100%;');
//		$('#kd_perijinan_chosen').attr('style','width: 100%;');
        $('#kode_entity').val('<?=$this->session->userdata('kode_entity')?>').trigger('chosen:updated');
	});

</script>
