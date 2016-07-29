<script type="text/javascript">
	// init plugins
	$('.chosen-select').chosen({
		width: '100%'
	});
	$('#tgl_ri_akad, #tgl_disetujui').datetimepicker({
		pickTime: false,
		format: 'DD/MM/YYYY'
	});
	$('#datatable').dataTable({
		"bServerSide":true,
		"bProcessing":true,
		"sPaginationType": "full_numbers",
		"bFilter":true,
		"sServerMethod": "POST",
		"sAjaxSource": "<?=base_url()?>index.php/bank-plafond/DT",
		"columns": [
			{ "name": "no_unit" },
			{ "name": "nasabah" },
			{ "name": "bank" },
			{ "name": "kpr" },
			{ "name": "um" },
			{ "searchable": false, "sortable": false }
		]
	});
	$('.input-numeric').autoNumeric('init');
	// event
	$('body').on('click', '.row-view', function() {
		var resno = $(this).attr('data-resno'),
			tbody = $('#datatable-alokasi tbody').html('');
		$.post(
			'<?=base_url()?>index.php/bank-plafond/'+resno,
			function(respon) {
				$('#reserve_no').val(respon.reserve_no);
				$('#xresno').attr('data-resno', respon.reserve_no);
				$('#pnama').text(': '+respon.nasabah);
				$('#pno_unit').text(': '+respon.no_unit);
				$('#pharga_unit').text(': '+respon.harga_unit);
				$('#pterbilang').text('#'+respon.terbilang+'#');
				$('#tgl_akad').val(respon.tgl_akad);
				$('#kode_bank').val(respon.kode_bank).chosen().trigger('chosen:updated');
				$('#rp').autoNumeric('set', respon.rp_kpr);
				if(respon.alokasi[0].kode_bank!==undefined) {
					$.each(respon.alokasi, function(index, item) {
						tbody.append(
							'<tr>'+
							'<td align="center" onclick="show_child('+item.persentase+','+respon.reserve_no+')"><a id="id_'+item.persentase+' href="#">+</a></td>'+
							'<td>'+item.persentase+' %</td>'+
							'<td class="input-numeric text-right">'+(parseFloat(respon.rp_kpr)*parseFloat(item.persentase)/100)+'</td>'+
							'<td>'+item.keterangan+'</td>'+
							'</tr>'
						);
					});
					$('.input-numeric').autoNumeric('init');
				}
			},
		'json');
	});
	$('#btn-submit').click(function() {
		$.post(
			'<?=base_url()?>index.php/bank-plafond/save',
			$('#form-input').serialize(),
			function(respon) {
				if(respon.status==='200') {
					alert(respon.msg);
					$('#xresno').trigger('click');
				}
			},'json'
		);
	});
	var npr = '';
		var kodebg = '';
		var kodebg_pr ='';
	function togel_child(uid){
        $('#child_sub_'+uid).toggle();
    }
    function show_child(pr,kode){
    	

		$('#child_'+pr+'_'+kode).toggle();
		$('#bobot_child_'+pr+'_'+kode).load('<?=base_url()?>index.php/bank-alokasi/child/'+pr+'/'+kode);
		kodebg = kode;
		npr = pr;
		kodebg_pr = pr+'_'+kode;

    }
    function load_child(uid){
        //$('#fc_sdid').val(uid);
        $('#bobot_child_'+uid).load('<?=base_url()?>index.php/bank-alokasi/child');
    }
</script>
