<script type="text/javascript">
jQuery(document).ready(function() {
	$('body').on('click', '.pro-row', function(){		
		var target = $(this).closest('.mod-row');
		var target_etc = $(this).attr('data-target');
		if(target_etc != undefined || target_etc != null){
			var satu = target_etc.substring(0,3);
			$('#'+satu).remove();
			var dua = target_etc.substring(4,7);
			$('#'+dua).remove();
		}
		target.remove();
			var rbSum = 0;
		$.each($('input.penjualan'), function(index, item){
				rbSum += parseFloat($(this).val().replace(new RegExp(',', 'g'), ''));
			});
			$('#total_rencana_penjualan').autoNumeric('set', rbSum);
			$('#laba_total_rencana_penjualan').autoNumeric('set', rbSum);
			hitung_laba();
	});

	function hitung_data(){

	}

	$('body').on('click', '.acc-row', function() {
		var target = $(this).closest('.mod-row');
		target.remove();
		if($(this).hasClass('rb')){ //jika detil rencana biaya di remove
			var rbSum = 0;
			$.each($('input.rencana'), function(index, item){
				rbSum += parseFloat($('input.rencana').val().replace(new RegExp(',', 'g'), ''));
			});
			$('#total_rencana_biaya').autoNumeric('set', rbSum);
			$('#laba_total_rencana_biaya').autoNumeric('set', rbSum);
			hitung_laba();
		} else if($(this).hasClass('r-penjualan')){
			var rbSum = 0;
			$.each($('input.penjualan'), function(index, item){
				rbSum += parseFloat($('input.penjualan').val().replace(new RegExp(',', 'g'), ''));
			});
			$('#total_rencana_penjualan').autoNumeric('set', rbSum);
			$('#laba_total_rencana_penjualan').autoNumeric('set', rbSum);
			hitung_laba();
		}
	});

	$('.input-numeric').autoNumeric('init');

	$('.chosen-select').chosen({
		width: '100%',
	});

	$('body').on('change', '.input-numeric', function(){
		var id = $(this), rbSum = 0;
		if(id.attr('data-target') == 'total_rencana_biaya'){
			$.each($('input.rencana'), function(index, item){
				rbSum += parseFloat($(this).val().replace(new RegExp(',', 'g'), ''));
			});
			$('#total_rencana_biaya').autoNumeric('set', rbSum);
			$('#laba_total_rencana_biaya').autoNumeric('set', rbSum);
			hitung_laba();
		} else if(id.attr('data-target') == 'total_rencana_penjualan'){
			$.each($('input.penjualan'), function(index, item){
				rbSum += parseFloat($(this).val().replace(new RegExp(',', 'g'), ''));
			});
			$('#total_rencana_penjualan').autoNumeric('set', rbSum);
			$('#laba_total_rencana_penjualan').autoNumeric('set', rbSum);
			hitung_laba();
		} 
	});

	function hitung_laba(){
		var rPenjualan = parseFloat($('#laba_total_rencana_penjualan').autoNumeric('get'));
		var rBiaya = parseFloat($('#laba_total_rencana_biaya').autoNumeric('get'));
		var subLaba = parseFloat(rPenjualan) - parseFloat(rBiaya);
		$('#laba_sub_total').autoNumeric('set', subLaba);
	}

	// $('.chosen-select').trigger('chosen:updated');
	// $('.chosen-select').val('').chosen().trigger('chosen:updated');

	/* Event Tombol Add Produk - RENCANA PRODUK */
	$('body').on('click', '.btn-add-produk', function() {
		var indexProduk = $('#rencana-produk option:selected').index();
		var valProduk = $('#rencana-produk option:selected').val();
		var textProduk = $('#rencana-produk option:selected').text();
		if(indexProduk == '0' && indexProduk != undefined){
			alert('Produk Belum Dipilih');
		} else {
			if($('#satu').children().hasClass(valProduk)){
				alert('Produk Telah Anda Daftarkan');
			} else {
				var content = '';
				content += '<div class="panel-body mod-row pt5 '+valProduk +'" id="'+valProduk+'">';
				content += '<div class="row">';
				content += '<div class="col-lg-2">';
				content += '<a href="javascript:" alt="Delete row" title="Remove row" class="text-danger fs14 pt5"><span class="pt5 glyphicons glyphicons-remove pro-row" data-target="p'+valProduk+'-n'+valProduk+'">&nbsp;&nbsp;</span></a>';
				content += '<label id="data-'+valProduk+'" class="control-label nama-produk"><b>' +textProduk+'<b></label>';
				content += '</div>' ;
				content += '<div class="col-lg-2">';
				content += '<label class="control-label">';
				content += '<a href="javascript:" alt="Add row" title="Add row" class="label label-success btn-add-detil" data-target="detil-'+valProduk+'-'+textProduk+'" class="btn btn-xs btn-success"><span class="fa fa-plus"></span>Add Detail</a>';
	            content += '</label>&nbsp;&nbsp;';
	            content += '<label class="control-label">';
				content += '<a href="javascript:" alt="Add row" title="Add row" class="label label-success btn-add-data" data-target="detil-'+valProduk+'-'+textProduk+'" class="btn btn-xs btn-success"><span class="fa fa-plus"></span>Add Data</a>';
	            content += '</label>';
	            content += '</div>';
				content += '</div>';
				content += '<div class="row" id="detil-' + $('#rencana-produk option:selected').val() +'">';
				content += '</div>'
				content += '</div>';
				$('#satu').append(content);
				add_rencana_netto(valProduk, textProduk);
				add_rencana_penjualan(valProduk, textProduk);
			}
		}		
	});

	/* Event tombol add detail pada rencana produk - RENCANA PRODUK*/
	$('body').on('click', '.btn-add-detil', function() {
		var x = $(this).attr('data-target');
		var c = getIdSelect(x.substring(0,8));
		var b = '';
		b += '<div class="row mod-row">';
		b += '<div class="col-lg-1" align="right">';
		b += '<input type="text" hidden class="" id="" name="type_property_detil[]" value="'+x.substring(6,8)+'" />';
		b += '<a href="javascript:" alt="Delete row" title="Remove row" class="text-danger fs14 pt5"><span class="glyphicons glyphicons-remove acc-row">&nbsp;&nbsp;</span></a>';
		b += '</div>';
		b += '<div class="col-lg-2">';
		b += '<select id="'+c+'" name="type_unit_detil[]" data-placeholder="pilih tipe" class="chosen-select pt5 required">';
		b += '<option value=""></option>';
		b += '</select>';
		b += '</div>';
		b += '<div class="col-lg-1">';
		b += '<input type="text" class="input-sm form-control text-center input-numeric" data-v-min="0" data-m-dec="0" placeholder="Volume" id="" name="volume_detil[]" value="" />';
		b += '</div>';
		b += '<div class="col-lg-1">';
		b += '<input type="text" class="input-sm form-control text-center" placeholder="Satuan" id="" name="satuan_detil[]" value="" />';
		b += '</div>';
		b += '<div class="col-lg-1">';
		b += '<input type="text" class="input-sm form-control text-center input-numeric" data-a-sign=" %" data-p-sign="s" data-v-min="0" data-m-dec="0" placeholder="%" id="" name="persen_detil[]" value="" />';
		b += '</div>';
		b += '<label class="col-lg-1 control-label text-right">Rp.</label>';
		b += '<div class="col-lg-2">';
		b += '<input type="text" class="input-sm form-control text-right input-numeric required" placeholder="Harga" id="" name="harga_m2_detil[]" value="" />';
		b += '</div>';
		b += '<div class="col-lg-2">';
		b += '<input type="text" class="input-sm form-control text-right input-numeric required" placeholder="Harga Unit" id="" name="harga_unit_detil[]" value="" />';
		b += '</div>';
		b += '</div>';
		b += '</div>';
		$('#'+x.substring(0,8)).append(b);
		$('.chosen-select').chosen({
					width: '100%',
		});
		$.post('<?=base_url()?>index.php/rencana/detail-produk', function(respon) {
				$.each(respon, function(iLoop, item) {
					$('#'+c+'').append('<option value="'+respon[iLoop].kode+'">'+respon[iLoop].konten+'</value>');
				});
				$('.chosen-select').chosen().trigger('chosen:updated');
		});
		$('.input-numeric').autoNumeric('init');
	});

	/* Event tombol add data pada rencana produk - RENCANA PRODUK*/
	$('body').on('click', '.btn-add-data', function(){
		var y = $(this).attr('data-target');
		var target = y.substring(0,8);
		var c = getIdSelect(target);
		var content = '';
		content += '<div class="row mod-row">';
		content += '<div class="col-lg-1" align="right">';
		content += '<input type="text" hidden class="" id="" name="type_property_detil[]" value="'+y.substring(6,8)+'" />';
		content += '<input type="text" hidden class="" id="" name="type_unit_detil[]" value="" />';
		content += '<a href="javascript:" alt="Delete row" title="Remove row" class="text-danger fs14 pt5"><span class="glyphicons glyphicons-remove acc-row">&nbsp;&nbsp;</span></a>';
		content += '</div>';
		content += '<div class="col-lg-2">';
		content += '<input type="text" readonly class="input-sm form-control text-right" placeholder="Satuan" id="'+c+'" name="" value="'+y.substring(9)+'" />';
		content += '</div>';
		content += '<div class="col-lg-1">';
		content += '<input type="text" class="input-sm form-control text-center input-numeric" placeholder="Volume" id="" name="volume_detil[]" value="" /></label>';
		content += '</div>';
		content += '<div class="col-lg-1">';
		content += '<input type="text" class="input-sm form-control text-center" placeholder="Satuan" id="" name="satuan_detil[]" value="" /></label>';
		content += '</div>';
		content += '<div class="col-lg-1">';
		content += '<input type="text" class="input-sm form-control text-center input-numeric" placeholder="Persentase" id="" name="persen_detil[]" value="" /></label>';
		content += '</div>';
		content += '<label class="col-lg-1 control-label text-right">Rp.</label>';
		content += '<div class="col-lg-2">';
		content += '<input type="text" class="input-sm form-control text-right input-numeric required" placeholder="Harga/M2" id="" name="harga_m2_detil[]" value="" /></label>';
		content += '</div>';
		content += '<div class="col-lg-2">';
		content += '<input type="text" class="input-sm form-control text-right input-numeric required" placeholder="Harga Unit" id="" name="harga_unit_detil[]" value="" />';
		content += '</div>';
		content += '</div>';
		content += '</div>';
		$('#'+target).append(content);
		$('.input-numeric').autoNumeric('init');
	});
	
	function add_rencana_netto(valProduk, textProduk){
		if($('#dua').children().hasClass(valProduk)){
			alert('Data Telah Ada Dalam Daftar');
		} else {
			var content = '';
			content += '<div class="row '+valProduk+' mod-row" id="n'+valProduk+'">';
			content += '<div class="col-lg-4">';
			content += '<input type="text" class="hidden" id="" name="type_property_harga_jual[]" value="'+valProduk+'" />';
			content += '<label class="pt5"><b>'+textProduk+'</b></label>';
			content += '</div>';
			content += '<label class="col-lg-offset-4 col-lg-1 pt5 control-label"><b>Rp.</b></label>';
			content += '<div class="col-lg-2">';
			content += '<input type="text" class="input-sm form-control input-numeric text-right required" placeholder="Nilai Jual" id="" name="harga_jual[]" value="" /></label>';
			content += '</div>';
			content += '</div>';
			//$('#' + target).append(content);
			$('#dua').append(content);
			$('.input-numeric').autoNumeric('init');
		}
	}		

	$('body').on('click', '.btn-add-harga-jual-netto', function() {
		var indexHargaNetto = $('#select_harga_netto option:selected').index();
		var valHargaNetto = $('#select_harga_netto option:selected');
		if(indexHargaNetto == '0' && indexHargaNetto != undefined){
			alert('Produk Belum Dipilih');
		} else {
			if($('#detil_rencana_jual_1').children().hasClass(valHargaNetto.val())){
				alert('Data Telah Ada Dalam Daftar');
			} else {
				var content = '';
				var target = $(this).attr('data-target');
				content += '<div class="row '+valHargaNetto.val()+' mod-row">';
				content += '<div class="col-lg-3 align="right">';
				content += '<input type="text" class="hidden" id="" name="type_property_luas[]" value="'+valHargaNetto.val()+'" />';
				content += '<a href="javascript:" alt="Delete row" title="Remove row" class="text-danger fs12 text-right"><span class="glyphicons glyphicons-remove acc-row pt5"></span></a>';
				content += '&nbsp;&nbsp;&nbsp;&nbsp;<label class="pt3"><b>'+valHargaNetto.text()+'</b></label>';
				content += '</div>';
				content += '<div class="col-lg-2">';
				content += '<input type="text" class="input-sm form-control input-numeric text-right" placeholder="Gross" id="" name="volume_luas[]" value="" /></label>';
				content += '</div>';
				content += '<div class="col-lg-1">';
				content += '<input type="text" class="input-sm form-control text-center" placeholder="Satuan" id="" name="satuan_luas[]" value="" /></label>';
				content += '</div>';
				content += '<div class="col-lg-2">';
				content += '<input type="text" class="input-sm form-control input-numeric text-right" placeholder="Efektif" id="" name="efektif_luas[]" value="" /></label>';
				content += '</div>';
				content += '<div class="col-lg-1">';
				content += '<input type="text" class="input-sm form-control text-center" placeholder="Satuan" id="" name="satuan_efektif[]" value="" /></label>';
				content += '</div>';
				content += '<div class="col-lg-2">';
				content += '<input type="text" class="input-sm form-control input-numeric text-right" placeholder="Percentage" id="" name="percentage_luas[]" value="" /></label>';
				content += '</div>';
				content += '</div>';
				$('#' + target).append(content);
				$('.input-numeric').autoNumeric('init');
			}
		}		
	});

	/*
	 * RENCANA PENJUALAN
	 */
	function add_rencana_penjualan(valProduk, textProduk){
		var content = '';
		content += '<div class="row mod-row" id="p'+valProduk+'">';
		content += '<div class="col-lg-4">';
		content += '<input type="text" class="hidden" id="" name="nama_produk_rp[]" value="'+valProduk+'" />';
		content += '<label class="pt5"><b>'+textProduk+'</b></label>';
		content += '</div>';
		content += '<div class="col-lg-offset-1 col-lg-2">';
		content += '<input type="text" class="input-sm form-control input-numeric text-right" data-m-dec="0" placeholder="Volume" id="" name="volume_rp[]" value="" />';
		content += '</div>';
		content += '<div class="col-lg-1">';
		content += '<input type="text" class="input-sm form-control text-center" placeholder="Satuan" id="" name="satuan_rp[]" value="" />';
		content += '</div>';
		content += '<label class="col-lg-1 pt5 control-label"><b>Rp.</b></label>';
		content += '<div class="col-lg-2">';
		content += '<input type="text" data-target="total_rencana_penjualan" class="penjualan input-sm form-control input-numeric text-right required" placeholder="Nilai Jual" id="" name="harga_jual_rp[]" value="" />';
		content += '</div>';
		content += '</div>';
		$('#tiga').append(content);
		$('.input-numeric').autoNumeric('init');		
	}	

	/** 
	 * RENCANA BIAYA 
	 */
	$('body').on('click', '.btn-add-rencana-biaya', function() {
		var indexBiaya = $('#rencana-biaya option:selected').index();
		var valBiaya = $('#rencana-biaya option:selected');
		if(indexBiaya == '0' && indexBiaya != undefined){
			alert('Produk Belum Dipilih');
		} else {
			if($('#detil_rb').children().hasClass(valBiaya.val())){
				alert('Data Telah Ada Dalam Daftar');
			} else {
				var content = '';
				var target = $(this).attr('data-target');
				content += '<div class="row '+valBiaya.val()+' mod-row">';
				content += '<div class="col-lg-5">';
				content += '<input type="text" class="hidden" id="" name="kode_biaya[]" value="'+valBiaya.val()+'" />';
				content += '<a href="javascript:" alt="Delete row" title="Remove row" class="text-danger fs12 text-right"><span class="glyphicons glyphicons-remove acc-row pt5 rb"></span></a>';
				content += '&nbsp;&nbsp;&nbsp;&nbsp;<label class="pt3"><b>'+valBiaya.text()+'</b></label>';
				content += '</div>';
				content += '<div class="col-lg-1">';
				content += '<input type="text" class="input-sm form-control input-numeric text-right" placeholder="Volume" data-m-dec="0" id="" name="volume_rb[]" value="" />';
				content += '</div>';
				content += '<div class="col-lg-1">';
				content += '<input type="text" class="input-sm form-control text-center" placeholder="Satuan" id="" name="satuan_rb[]" value="" />';
				content += '</div>';
				content += '<div class="col-lg-1">';
				content += '<input type="text" class="input-sm form-control input-numeric" placeholder="Bobot" id="" name="bobot_rb[]" value="" />';
				content += '</div>';
				content += '<label class="col-lg-1 pt5 control-label"><b>Rp.</b></label>';
				content += '<div class="col-lg-2">';
				content += '<input type="text" data-target="total_rencana_biaya" class="rencana input-sm form-control input-numeric text-right required" placeholder="Nilai Biaya" id="" name="biaya_rb[]" value="" />';
				content += '</div>';
				content += '</div>';
				$('#' + target).append(content);
				$('.input-numeric').autoNumeric('init');
			}
		}
	});

	function getIdSelect(target){
		var d = new Date();
		var n = d.getTime();
		var id = '';
		return 'type_unit_' + target + n;
	}

	$('#btn_submit_rik').click(function() {
		var isValid = true;
		// $.each($('.required'), function(index, item) {
		// 	if($(this).val()=='')
		// 		isValid &= false;
		// });
		if(isValid){
			var data = $('#form-input-rencana-produk').serialize()+ '&' + $('#form-rencana-biaya').serialize() + '&';
			data += $('#form-input-rencana-jual1').serialize()+'&'+$('#form-input-rencana-jual2').serialize() + '&';
			data += $('#form-rencana-penjualan').serialize()+'&'+$('#form-rencana-laba').serialize()+'&';
			data += $('#form-profit-sharing').serialize()+'&'+$('#form-nilai-tanah').serialize();
			alert(data);
			$.post(
				'<?=base_url()?>index.php/rencana/save',
				data,
				function(respon) {
					if(respon.status==='200') {
						location.href="<?=base_url()?>index.php/rencana";
					} else {
						alert(respon.msg);
					}
				}
			);	
		} else {
			alert('Harap Isi Field Yang Masih Kosong');
		}		
	});

})
</script>
