<script type="text/javascript" src="<?=base_url()?>assets/vendor/plugins/datatables/extensions/ReloadAjax/js/dataTables.reloadAjax.min.js"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
	// init component / plugin
	$('.chosen-select').chosen({
		width: '100%',
	});
	$('.chosen-select').val('').chosen().trigger('chosen:updated');
	$('.input-numeric').autoNumeric('init');
	$('.input-date').datetimepicker({
		pickTime: false,
		format: 'DD/MM/YYYY'
	});

	// init value
	<?php if(isset($data['id'])) { ?>
		$('#id').val('<?=$data['id']?>');
		$('#tanggal_sign').val('<?=$data['xtanggal']?>');
		$('#tanggal_mulai').val('<?=$data['stanggal']?>');
		$('#tanggal_akhir').val('<?=$data['etanggal']?>');
		$('#retensi').val('<?=$data['retensi']?>');
		$('#kode_rekanan').val('<?=$data['kode_rekanan']?>');
		$('#no_kontrak').val('<?=$data['no_kontrak']?>');
		$('#kode_entity').val('<?=$data['kode_entity']?>');
		$('#nilai_kontrak').autoNumeric('set','<?php echo $data['nilai_kontrak'];?>');
		$('#jenis_kontrak').val('<?=$data['jenis_kontrak']?>');
		$('#jenis_termin').val('<?=$data['jenis_termin']?>');
		$('#jumlah_termin').val('<?=$data['jumlah_termin']?>');
		$("#nilai_kontrak").attr("nk", '<?=$data['nilai_kontrak']?>');
		$('#jenis_retensi').val('<?=$data['jenis_retensi']?>');
		//$('input[name="jenis_termin"]').prop('selected', <?=$data['jenis_termin']==='N'?'true':'false'?>);

		$('input[name="jumlah_termin"]').prop('disabled', true);
		$('input[name="tanggal_sign"]').prop('disabled', true);
		$('input[name="tanggal_mulai"]').prop('disabled', true);
		$('input[name="tanggal_akhir"]').prop('disabled', true);
		$('input[name="no_kontrak"]').prop('disabled', true);
		$('input[name="nilai_kontrak"]').prop('disabled', true);
		$('input[name="jenis_retensi"]').prop('disabled', true);

		$("#jenis_retensi").attr('disabled', true).trigger("liszt:updated");
		$("#jenis_retensi").trigger("chzn:updated");

		$("#jenis_termin").attr('disabled', true).trigger("liszt:updated");
		$("#jenis_termin").trigger("chzn:updated");

		$("#jenis_kontrak").attr('disabled', true).trigger("liszt:updated");
		$("#jenis_kontrak").trigger("chzn:updated");

		$("#kode_rekanan").attr('disabled', true).trigger("liszt:updated");
		$("#kode_rekanan").trigger("chzn:updated");

		<?php
			if(isset($data['termins'])) {
				foreach ($data['termins'] as $k => $v) {
		?>
					$('#datatable tbody').append(
								'<tr id="tr_<?=$v['termin_ke']?>">'+
					            '    <td class="text-right"> '+<?=$v['termin_ke']?>+' <input type="hidden" id="t_ke[]" name="t_ke[]" value="<?=$v['termin_ke']?>"></td>'+
					            '    <td class="text-right">Rp. <input type="text" class="text-right" id="t_rupiah[]" name="t_rupiah[]" value="<?=$v['nilai_termin']?>"></td>'+
					            '    <td class="text-center"><input width="25%" class="text-center" type="text" id="pr_pekerjaan[]" name="pr_pekerjaan[]" value="<?=$v['pr_pkerjaan']?>">%</td>'+
					            '    <td class="text-center"><input width="25%" class="text-center" type="text" id="pr_penagihan[]" name="pr_penagihan[]" value="<?=$v['pr_penagihan']?>">%</td>'+
					            '	 <td class="input-numeric text-center"><a style="cursor:pointer" class="row-delete" href="javascript:delete(1)"><span class="glyphicons glyphicons-bin"></span></a></td>'+
					            '</tr>'
							);
		<?php
				} ?>
				$('.input-numeric').autoNumeric('init');
		<?php
			} ?>
		

		var rp_k = '<?=$data['nilai_kontrak']?>';

		$('.chosen-select').trigger('chosen:updated');
	<?php } ?>
	//$('#jumlah_termin').val('0');

	$('#jumlah_termin').keydown(function( event ){
		var jTermin = 0;
		jTermin = $(this).val();
		var i, jR, nR, jT, nProgresiv, tRupiah, rpTotal;
		var nk = 0;
		nk = $('#nilai_kontrak').attr('nk');
		jR = $('#jenis_retensi').val();
		rt = $('#retensi').val();
		jT = $('#jenis_retensi').val();
		nTagihan = nk/jTermin;
		if(jR == 'P')
		{
			nR = nTagihan*(rt/100);
			nProgresiv = nTagihan-nR;
			tRupiah = nProgresiv;
		}else{
			var tAkhir = 0;
			tAkhir = nTagihan-(nk*(rt/100));
		}
		rpTotal = nk-(nk*(rt/100));


		if ( event.which == 13 ) {
			event.preventDefault();

			if(jR==''){
				alert('Retensi belum dipilih.')
			}else if(jT == ''){
			 	alert('Jenis Termin belum dipilih')
			}else{
				if($(this).val() > 0 ){
					for (i = 1; i <= jTermin; i++) { 
				    	if(jR == 'P'){
				    		$('#datatable tbody').append(
								'<tr id="tr_'+i+'">'+
					            '    <td class="text-right"> '+i+' ('+bilangan(i)+') <input type="hidden" id="t_ke[]" name="t_ke[]" value="'+i+'"></td>'+
					            '    <td class="text-right">Rp. <input type="text" class="text-right" id="t_rupiah[]" name="t_rupiah[]" value="'+tRupiah+'"></td>'+
					            '    <td class="text-center"><input width="25%" class="text-center" type="text" id="pr_pekerjaan[]" name="pr_pekerjaan[]" value="'+100/jTermin+'">%</td>'+
					            '    <td class="text-center"><input width="25%" class="text-center" type="text" id="pr_penagihan[]" name="pr_penagihan[]" value="'+100/jTermin+'">%</td>'+
					            '	 <td class="input-numeric text-center"><a style="cursor:pointer" class="row-delete" href="javascript:delete(1)"><span class="glyphicons glyphicons-bin"></span></a></td>'+
					            '</tr>'
							);
				    	}else{
				    		if(i<jTermin) {
					    		$('#datatable tbody').append(
									'<tr id="tr_'+i+'">'+
						            '    <td class="text-right"> '+i+' ('+bilangan(i)+') <input type="hidden" id="t_ke[]" name="t_ke[]" value="'+i+'"></td>'+
						            '    <td class="text-right">Rp. <input type="text" class="text-right" id="t_rupiah[]" name="t_rupiah[]" value="'+nTagihan+'"></td>'+
						            '    <td class="text-center"><input width="25%" class="text-center" type="text" id="pr_pekerjaan[]" name="pr_pekerjaan[]" value="'+100/jTermin+'">%</td>'+
						            '    <td class="text-center"><input width="25%" class="text-center" type="text" id="pr_penagihan[]" name="pr_penagihan[]" value="'+100/jTermin+'">%</td>'+
						            '	 <td class="input-numeric text-center"><a style="cursor:pointer" class="row-delete" href="javascript:delete(1)"><span class="glyphicons glyphicons-bin"></span></a></td>'+
						            '</tr>'
								);
					    	}else{
					    		$('#datatable tbody').append(
									'<tr id="tr_'+i+'">'+
						            '    <td class="text-right"> '+i+' ('+bilangan(i)+') <input type="hidden" id="t_ke[]" name="t_ke[]" value="'+i+'"></td>'+
						            '    <td class="text-right">Rp. <input type="text" class="text-right" id="t_rupiah[]" name="t_rupiah[]" value="'+tAkhir+'"></td>'+
						            '    <td class="text-center"><input width="25%" class="text-center" type="text" id="pr_pekerjaan[]" name="pr_pekerjaan[]" value="'+100/jTermin+'">%</td>'+
						            '    <td class="text-center"><input width="25%" class="text-center" type="text" id="pr_penagihan[]" name="pr_penagihan[]" value="'+100/jTermin+'">%</td>'+
						            '	 <td class="input-numeric text-center"><a style="cursor:pointer" class="row-delete" href="javascript:delete(1)"><span class="glyphicons glyphicons-bin"></span></a></td>'+
						            '</tr>'
								);
					    	}
				    	}
					}
					$('#t_total_rp').text('Rp. '+rpTotal);
				}else{
					$('#datatable tbody').remove();
					$('#t_total_rp').text('');
				}
			}
		}
		
	});/*.keydown(function( event ) {
	  if ( event.which == 13 ) {
	  	alert('hello enter');
	    event.preventDefault();
	  }
	});*/
	
	// event
	$('#nilai_kontrak').change(function(){
		//alert($(this).val().replace(',',''));
		$('#nilai_kontrak').attr('nk',$(this).val().replace(',',''));
		$('#nilai_kontrak').attr('nk').replace(',','');
		var n = '';
		n = $('#nilai_kontrak').attr('nk').replace(',','');
		var x = n.replace(',','');
		//alert('hasilnya: '+x);
		$('#nilai_kontrak').attr('nk',x);
	});
	$('#jenis_retensi').on('change', function() {
		//if($(this).val()=="P"){
			var rr; 
			rr = $('#nilai_kontrak').attr('nk');
			var rn = 0;
			rn = (rr*$('#retensi').val())/100;
			var rx = 0;
			rx = rr-rn;
			$('#rp_retensi').text('Rp. '+rn);
		//}else{

		//}
		
	});
	$('#btn-submit').click(function() {
		// validasi
		var isValid = true;
		$.each($('.required'), function(index, item) {
			if($(this).val()=='')
				isValid &= false;
		});
		// --
		if(isValid){
			$.post(
				'<?=base_url()?>index.php/kontrak/save',
				$('#form-input').serialize(),
				function(respon) {
					alert('Data tersimpan.');
					location.href = '<?=base_url()?>index.php/kontrak';
				}
			);
		} else {
			alert('Data Belum Lengkap.\n*Wajib Diisi');
		}
	});
})


var th = ['','ribu','juta', 'miliar','triliun'];
// uncomment this line for English Number System
// var th = ['','thousand','million', 'milliard','billion'];

var dg = ['nol','satu','dua','tuga','empat', 'lima','enam','tujuh','delapan','sembilan']; 
var tn = ['sepuluh','sebelas','dua belas','tiga belas', 'empat belas','lima belas','enam belas', 'tujuh belas','delapan belas','sembilan belas']; 
var tw = ['dua puluh','tiga puluh','empat puluh','lima puluh', 'enam puluh','tujuh puluh','delapan puluh','sembilan puluh']; 

function bilangan(s){
	s = s.toString(); s = s.replace(/[\, ]/g,''); 
	if (s != parseFloat(s)) 
		return 'not a number'; 

	var x = s.indexOf('.'); 
	if (x == -1) x = s.length; 
	if (x > 15) 
		return 'too big'; 
	var n = s.split(''); 
	var str = ''; 
	var sk = 0; 
	for (var i=0; i < x; i++) {
		if ((x-i)%3==2) {
			if (n[i] == '1') {
				str += tn[Number(n[i+1])] + ' '; 
				i++; sk=1;
			} else if (n[i]!=0) {str += tw[n[i]-2] + ' ';
			sk=1;
		}
	} else if (n[i]!=0) {
		str += dg[n[i]] +' '; 
		if ((x-i)%3==0) str += 'ratus ';
		sk=1;
	} 

		if ((x-i)%3==1) {
			if (sk) str += th[(x-i-1)/3] + ' ';
			sk=0;
		}
	} 
	if (x != s.length) {
		var y = s.length; str += 'point '; 
		for (var i=x+1; i<y; i++) 
			str += dg[n[i]] +' ';
	} 
	return str.replace(/\s+/g,' ');
}
</script>