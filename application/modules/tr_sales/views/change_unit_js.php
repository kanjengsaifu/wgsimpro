<script type="text/javascript">
jQuery(document).ready(function() {
	// init component / plugin
	$('.chosen-select').chosen({
		width: '100%',
		allow_single_deselect: true
	});
	$('#tgl_akad, #tgl_dokumen').datetimepicker({
		pickTime: false,
		format: 'DD/MM/YYYY'
	});
	$('#datatable').dataTable({
		"bServerSide":true,
		"bProcessing":true,
		"sPaginationType": "full_numbers",
		"bFilter":true,
		"sServerMethod": "POST",
		"sAjaxSource": "<?=base_url()?>index.php/payment/DT",
	});
	$('#datatable-unit').dataTable({
		"bServerSide":true,
		"bProcessing":true,
		"sPaginationType": "full_numbers",
		"bFilter":true,
		"sServerMethod": "POST",
		"sAjaxSource": "<?=base_url()?>index.php/reserve/DT",
		"columns": [
			{"name": "no_unit"},
			{"name": "type_property"},
			{"name": "type_unit"},
			{"name": "tower_cluster"},
			{"name": "wide_netto"},
			{"name": "wide_gross"},
			{"name": "lantai_blok"},
			{"name": "direction"},
			{"sortable": false, "searchable": false}
		]
	});
	$('.chosen-select').val('').chosen().trigger('chosen:updated');
	$('.input-numeric').autoNumeric('init');
	// event
	$('body').on('click', '.row-data', function() {
		var resno = $(this).attr('data-resno'),
			tblbody = $('#table-paydet tbody').html(''),
			tblfoot = $('#table-paydet tfoot').html(''),
			vSum = 0;;
		$.post(
			'<?=base_url()?>index.php/sales-cancel/get-reserve/'+resno,
			function(respon) {
				$('#pnama').text(':'+respon.nsb_nama);
				$('#pno_unit').text(':'+respon.no_unit);
				$('#pharga_unit').text(':'+respon.fharga_unit);
				$('#pterbilang').text('#'+respon.terbilang+'#');
				$('#pcara_bayar').text(':'+respon.cara_bayar);
				$('#ppola_bayar').text(':'+respon.pola_bayar);
				if(respon.paydet_ri!==undefined) {
					$.each(respon.paydet_ri, function(index, item) {
						tblbody.append(
							'<tr>'+
							'<td class="text-center">'+(index+1)+'</td>'+
							'<td>'+item.nama+'</td>'+
							'<td class="text-center">'+item.tgl_bayar+'</td>'+
							'<td class="text-right input-numeric">'+item.ri_rp+'</td>'+
							'</tr>'
						);
						vSum += parseFloat(item.ri_rp);
					});
					tblfoot.append(
						'<tr>'+
						'<td colspan="3" class="text-right">Total</td>'+
						'<td class="text-right input-numeric">'+vSum+'</td>'+
						'</tr>'
					);
					$('.input-numeric').autoNumeric('init');
				}
				$('#reserve_no_old').val(resno);
			}
		,'json');
	});
	$('body').on('click', '.row-unit', function() {
		var resNoOld = $('#reserve_no_old').val();
		if(resNoOld!=='') {
			var no_unit = $(this).attr('data-encunit');
			$('#kode_pay').html('<option value=""></option>');
			$('.chosen-select').val('').chosen().trigger('chosen:updated');
			$.post(
				'<?=base_url()?>index.php/reserve/get/'+no_unit,
				function(respon) {
					// produk
					$('#new-pno_unit').text(respon.no_unit);
					$('#new-ptype_unit').text(respon.type_unit);
					$('#new-ptower_cluster').text(respon.tower_cluster);
					$('#new-pwide_netto').text(respon.wide_netto);
					$('#new-pwide_gross').text(respon.wide_gross);
					$('#new-pluas_tanah').text(respon.luas_tanah);
					$('#new-plantai_blok').text(respon.lantai_blok);
					// $('#pharga').autoNumeric('set',respon.tr_jual); 
					// $('#pterbilang').text(respon.terbilang); 
					$('#new-pdirection').text(respon.direction==null?'':respon.direction); 
					// prices
					var pricesHTML = $('#prices-container').html('');
					if(respon.prices !== undefined) {
						$.each(respon.prices, function(index, item) {
							pricesHTML.append(
								'<div class="form-group mbn">'+
								'<label class="col-lg-2 control-label">Harga '+item.nama+'</label>'+
								'<div class="col-lg-4">'+
								'<p class="form-control-static text-muted input-numeric" id="pharga-'+item.kode_pay+'">'+item.tr_jual+'</p>'+
								'</div>'+
								'<label class="col-lg-2 control-label">Terbilang</label>'+
								'<div class="col-lg-4">'+
								'<p class="form-control-static text-muted" id="pterbilang-'+item.kode_pay+'">'+item.terbilang+'</p>'+
								'</div>'+
								'</div>'
							);
						});
						$('.input-numeric').autoNumeric('init');
					}
					// payment plan
					$('#no_unit').val(respon.no_unit);
					// $('#harga').val(respon.tr_jual);
					// $('#tgl_akad').val(respon.tgl_akad===null ? '<?=date('d/m/Y')?>' : respon.tgl_akad);
					// $('#tgl_dokumen').val(respon.tgl_dokumen===null ? '<?=date('d/m/Y')?>' : respon.tgl_dokumen);
					$('#hold_date').val(respon.hold_date===null ? '<?=date('Y-m-d')?>' : respon.hold_date);
					$('#preserve_no').text(respon.reserve_no==undefined?'RSV----------':respon.reserve_no); 
					$('#reserve_no').val(respon.reserve_no==undefined?'':respon.reserve_no);
					$('#pay-container').html("");
					$('#kode_bank').val(respon.kode_bank).chosen().trigger('chosen:updated');
					// customer
					$('#pkode').text(respon.kode==undefined?respon.no_unit+'-------':respon.kode); 
					$('#kode').val(respon.kode==undefined?'':respon.kode);
					$('#klasifikasi').val(respon.klasifikasi).chosen().trigger('chosen:updated');
					$('#salutation').val(respon.salutation).chosen().trigger('chosen:updated');
					$('#nama').val(respon.nama);
					$('#jenis_id').val(respon.jenis_id).chosen().trigger('chosen:updated');
					$('#no_id').val(respon.no_id);
					$('#npwp').val(respon.npwp);
					$('#email').val(respon.email);
					$('#hp').val(respon.hp);
					$('#tempat_lahir').val(respon.tempat_lahir);
					$('#tgl_lahir').val(respon.xtgl_lahir);
					$('#nationality').val(respon.nationality).chosen().trigger('chosen:updated');
					$('#agama').val(respon.agama).chosen().trigger('chosen:updated');
					$('#jk').val(respon.jk).chosen().trigger('chosen:updated');
					// alamat
					$('#alamat-container').html('');
					if(respon.alamats!==undefined) {
						$.each(respon.alamats, function(index, item) {
							$('#alamat-container').append(
								'<div class="alamat-group">'+

	                            '<div class="form-group">'+
	                                '<label class="col-lg-2 control-label">Alamat #'+(index+1)+'</label>'+
	                                '<div class="col-lg-4">'+
	                                    '<textarea name="alamat[]" class="form-control input-sm" row="3">'+item.alamat+'</textarea>'+
	                                '</div>'+
	                                '<label class="col-lg-2 control-label blank-label">&nbsp;</label>'+
	                                '<div class="col-lg-4">'+
	                                    '<div class="radio-custom square radio-success">'+
	                                        '<input id="ckalamat-'+(index+1)+'" data-id="'+item.id+'" type="radio" value="'+index+'" name="idx-alamat">'+
	                                        '<label for="ckalamat-'+(index+1)+'"> Alamat Surat-menyurat ?</label>'+
	                                    '</div>'+
	                                '</div>'+
	                            '</div>'+
	                            '<div class="form-group">'+
	                                '<label class="col-lg-2 control-label">Kota</label>'+
	                                '<div class="col-lg-4">'+
	                                    '<input type="text" name="kota[]" class="form-control input-sm" value="'+item.kota+'">'+
	                                '</div>'+
	                                '<label class="col-lg-2 control-label">Kodepos</label>'+
	                                '<div class="col-lg-4">'+
	                                    '<input type="text" name="kodepos[]" class="form-control input-sm" value="'+item.kodepos+'">'+
	                                '</div>'+
	                            '</div>'+
	                            '<div class="form-group">'+
	                                '<label class="col-lg-2 control-label">No. Telepon</label>'+
	                                '<div class="col-lg-4">'+
	                                    '<input type="text" name="telp[]" class="form-control input-sm" value="'+item.telp+'">'+
	                                '</div>'+
	                                '<label class="col-lg-2 control-label">Fax</label>'+
	                                '<div class="col-lg-4">'+
	                                    '<input type="text" name="fax[]" class="form-control input-sm" value="'+item.fax+'">'+
	                                '</div>'+
	                            '</div>'+

	                            '</div>'
							);
						});
						$('input[data-id="'+respon.alamat+'"]').prop('checked', true);
					} else {
						$('#alamat-container').append(
							'<div class="alamat-group">'+

	                        '<div class="form-group">'+
	                            '<label class="col-lg-2 control-label">Alamat #1</label>'+
	                            '<div class="col-lg-4">'+
	                                '<textarea name="alamat[]" class="form-control input-sm" row="3"></textarea>'+
	                            '</div>'+
	                            '<label class="col-lg-2 control-label blank-label">&nbsp;</label>'+
	                            '<div class="col-lg-4">'+
	                                '<div class="radio-custom square radio-success">'+
	                                    '<input id="ckalamat-1" type="radio" value="0" name="idx-alamat">'+
	                                    '<label for="ckalamat-1"> Alamat Surat-menyurat ?</label>'+
	                                '</div>'+
	                            '</div>'+
	                        '</div>'+
	                        '<div class="form-group">'+
	                            '<label class="col-lg-2 control-label">Kota</label>'+
	                            '<div class="col-lg-4">'+
	                                '<input type="text" name="kota[]" class="form-control input-sm">'+
	                            '</div>'+
	                            '<label class="col-lg-2 control-label">Kodepos</label>'+
	                            '<div class="col-lg-4">'+
	                                '<input type="text" name="kodepos[]" class="form-control input-sm">'+
	                            '</div>'+
	                        '</div>'+
	                        '<div class="form-group">'+
	                            '<label class="col-lg-2 control-label">No. Telepon</label>'+
	                            '<div class="col-lg-4">'+
	                                '<input type="text" name="telp[]" class="form-control input-sm">'+
	                            '</div>'+
	                            '<label class="col-lg-2 control-label">Fax</label>'+
	                            '<div class="col-lg-4">'+
	                                '<input type="text" name="fax[]" class="form-control input-sm">'+
	                            '</div>'+
	                        '</div>'+

	                        '</div>'
						);
					}
				}
			);
		} else {
			alert('Silahkan pilih dahulu transaksi yang akan diubah.');
		}
	});
	$('#cara_bayar').on('change', function() {
		// alert($(this).val());
		if($('#no_unit').val()!=='') {
			$('#pay-container').html("");
			var sPayMode = $(this).val(), sSel = $('#kode_pay').html(""),
				strPayMode = $('#cara_bayar option:selected').text();
			if(sPayMode!=='HARDCASH')
				sSel.append('<option value=""></value>');
			// var priceP = $('#pharga-'+sPayMode);
			// if(priceP.length!==0) {
				// $('#harga').val(priceP.autoNumeric('get'));

				$.post(
					'<?=base_url()?>index.php/sales/payment-plan/'+sPayMode,
					function(respon) {
						// console.log(respon);
						$.each(respon, function(iLoop, item) {
							sSel.append('<option value="'+respon[iLoop].kode_pay+'">'+respon[iLoop].deskripsi+'</value>');
						});
						$('.chosen-select').chosen().trigger('chosen:updated');
						if(sPayMode==='HARDCASH') {
							sSel.chosen().change();
						}
					}
				);
			// } else {
			// 	alert('Harga unit untuk metode '+strPayMode+' belum tersedia.');
			// 	$(this).val('').trigger('chosen:updated');
			// }
			$('#kode_bank').parents('.form-group').addClass('hidden');
			if(sPayMode==='KPRKPA') {
				$('#kode_bank').parents('.form-group').removeClass('hidden');
			}
		} else {
			alert('Silahkan pilih unit.');
			$(this).val('').trigger('chosen:updated');
		}
	});
	$('#kode_pay').on('change', function() {
		if($('#no_unit').val()!=='') {
			var sPayMode = $(this).val(),
				strPayMode = $('#kode_pay option:selected').text(),
				priceP = $('#pharga-'+sPayMode);
			if(priceP.length!==0) {
				$('#harga').val(priceP.autoNumeric('get'));
				var sDiv = $('#pay-container').html("");
				$.post(
					'<?=base_url()?>index.php/sales/payment-mode/'+$(this).val(),
					function(respon) {
						var str = "",
							sHarga = $('#harga').val(),
							sNum = 1,
							vMinBooking = 0,
							vTotalDP = 0,
							vTotalAG = 0;
						str = '<div class="form-group" style="border-bottom: solid 1px #000;">';
						str += '<label class="col-lg-4 control-label">&nbsp;</label>';
						str += '<label class="col-lg-4 text-center">Nominal</label>';
						str += '<label class="col-lg-4 text-center">Tgl. Ra. Bayar</label>';
						str += '</div>';
						sDiv.append(str);
						var xtglpay = moment();
						$.each(respon, function(iLoop, item) {
							if(parseInt(item.nfield)>1) {
								sNum = 1;
								str = '';
								for(var fLoop=0; fLoop<parseInt(item.nfield); fLoop++) {
									if(item.limit_day==='30') {
										xtglpay = xtglpay.add(1, 'months');
									} else if(parseInt(item.limit_day)>0) {
										xtglpay = xtglpay.add(parseInt(item.limit_day), 'days');
									}
									if(item.tipepay!=='BOOKINGFEE') {
										var stgl = parseInt(xtglpay.format('D'));
										if(stgl<=10) {
											xtglpay.date(10);
										} else {
											xtglpay.date(20);
										}
									}
									vTotalDP += item.tipepay==='BOOKINGFEE' || item.tipepay==='DOWNPAYMENT' ? Math.round(parseFloat(item.persen==0?item.nval:parseFloat(item.persen)/100*parseFloat(sHarga)/parseFloat(item.nfield))) : 0;
									vTotalAG += item.tipepay==='INSTALLMENT' || item.tipepay==='BANKLOAN' ? Math.round(parseFloat(item.persen==0?item.nval:parseFloat(item.persen)/100*parseFloat(sHarga)/parseFloat(item.nfield))) : 0;
									str += '<div class="form-group mod-row">';
									str += '<label class="col-lg-4 control-label">'+item.slabel+' #'+sNum+'</label>';
									str += '<div class="col-lg-4">';
									str += '<input type="hidden" name="fkodepay[]" value="'+item.klabel+'">';
									str += '<input type="hidden" name="fnamapay[]" value="'+item.slabel+' #'+sNum+'">';
									str += '<input type="hidden" name="fpersenpay[]" value="'+item.persen+'">';
									str += '<input type="text" name="fvalpay[]" class="form-control input-sm text-right input-numeric '+(item.tipepay==='BOOKINGFEE' || item.tipepay==='DOWNPAYMENT' ? 'inDP' : 'inAG')+'" value="'+Math.round(item.persen==0?item.nval:parseFloat(item.persen)/100*parseFloat(sHarga)/parseFloat(item.nfield))+'">';
									str += '</div>';
									str += '<div class="col-lg-3'+(item.has_date=='1'?'':' hidden')+'">';
									str += '<input type="text" name="ftglpay[]" class="form-control input-sm input-date" value="'+xtglpay.format('DD/MM/YYYY')+'">';
									str += '</div>';
									str += '<div class="col-lg-1 acc-row pt5 hidden">';
									str += '<a href="javascript:" alt="Delete row" title="Remove row" class="text-danger fs14"><span class="glyphicons glyphicons-remove"></span> </a>';
									str += '</div>';
									str += '</div>';
									sNum++;
								}
							} else {
								if(item.limit_day==='30') {
									xtglpay = xtglpay.add(1, 'months');
								} else if(parseInt(item.limit_day)>0) {
									xtglpay = xtglpay.add(parseInt(item.limit_day), 'days');
								}
								if(item.tipepay!=='BOOKINGFEE') {
									var stgl = parseInt(xtglpay.format('D'));
									if(stgl<=10) {
										xtglpay.date(10);
									} else {
										xtglpay.date(20);
									}
								}
								var vVal1 = (item.persen==0?item.nval:parseInt(item.persen)/100*parseFloat(sHarga));
								var vVal2 = Math.round(item.tipepay==='BOOKINGFEE' && parseFloat(item.persen)===0 ? vVal1 : vVal1 - vMinBooking);
								vTotalDP += item.tipepay==='BOOKINGFEE' || item.tipepay==='DOWNPAYMENT' ? vVal2 : 0;
								vTotalAG += parseFloat(item.tipepay==='INSTALLMENT' || item.tipepay==='BANKLOAN' ? vVal2 : 0);
								vMinBooking = item.tipepay==='BOOKINGFEE' && parseFloat(item.persen)===0 ? parseFloat(item.nval) : 0;
								str = '<div class="form-group">';
								str += '<label class="col-lg-4 control-label">'+item.slabel+'</label>';
								str += '<div class="col-lg-4">';
								str += '<input type="hidden" name="fkodepay[]" value="'+item.klabel+'">';
								str += '<input type="hidden" name="fnamapay[]" value="'+item.slabel+'">';
								str += '<input type="hidden" name="fpersenpay[]" value="'+item.persen+'">';
								str += '<input type="text" name="fvalpay[]" class="form-control input-sm text-right input-numeric '+item.klabel+' '+(item.tipepay==='BOOKINGFEE' || item.tipepay==='DOWNPAYMENT' ? 'inDP' : 'inAG')+'" value="'+(vVal2)+'">';
								str += '<input type="hidden" id="def'+item.klabel+'" value="'+vVal2+'">';
								str += '</div>';
								str += '<div class="col-lg-4'+(item.has_date=='1'?'':' hidden')+'">';
								str += '<input type="text" name="ftglpay[]" value="'+xtglpay.format('DD/MM/YYYY')+'" class="form-control input-sm input-date'+(item.has_date=='1'?'':' hidden')+'">';
								str += '</div>';
								if(item.klabel==='RES')
									str += '<div class="col-lg-4 hidden"><div class="checkbox-custom checkbox-success mb5"><input type="checkbox" id="islunas" name="islunas" value="1"><label for="islunas"> Lunas Reserve</label></div></div>';
								str += '</div>';
							}
							sDiv.append(str);
						});
						// <div class="col-lg-4 text-right"><label style="width:100%;padding-right:10px;border-bottom:solid 1px #999" class="control-label input-numeric" id="pAG">383,460,000.00</label></div>
						str = '<div class="form-group" id="group-total">';
						str += '<label class="col-lg-4 control-label">Total</label>'; 
						str += '<div class="col-lg-4 text-right"><label id="totalPayment" class="control-label input-numeric" style="width:100%;padding-right: 10px;border-bottom:solid 1px #999">'+sHarga+'</label></div>';
						str += '</div>';
						sDiv.append(str);
						// append sub
						str = '<div class="form-group">';
						str += '<label class="col-lg-4 control-label">Total Uang Muka</label>';
						str += '<div class="col-lg-4 text-right"><label id="pDP" class="control-label input-numeric" style="width:100%;padding-right: 10px;border-bottom:solid 1px #999">'+vTotalDP+'</label></div>';
						str += '<div class="col-lg-2 pt5">';
						str += '<a href="javascript:" alt="Add row" title="Add row" class="label label-success btn-add-row" data-target="inDP"><span class="glyphicons glyphicons-circle_plus"></span> Tambah Angsuran</a>';
						str += '</div>';
						str += '</div>';
						$('.inDP:last').parents('.form-group').after(str);
						str = '<div class="form-group">';
						str += '<label class="col-lg-4 control-label">Total Angsuran</label>';
						str += '<div class="col-lg-4 text-right"><label id="pAG" class="control-label input-numeric" style="width:100%;padding-right: 10px;border-bottom:solid 1px #999">'+vTotalAG+'</label></div>';
						str += '<div class="col-lg-2 pt5">';
						str += '<a href="javascript:" alt="Add row" title="Add row" class="label label-success btn-add-row" data-target="inAG"><span class="glyphicons glyphicons-circle_plus"></span> Tambah Angsuran</a>';
						str += '</div>';
						str += '</div>';
						$('.inAG:last').parents('.form-group').after(str);
						// init plugins
						$('.input-numeric').autoNumeric('init');
						$('.input-date').datetimepicker({
							pickTime: false,
							format: 'DD/MM/YYYY'
						});
						// fix rp diff
						var xDP = parseFloat($('#pDP').autoNumeric('get')),
							xAG = parseFloat($('#pAG').autoNumeric('get')),
							xTotal = xDP + xAG,
							harga = parseFloat($('#harga').val().replace(new RegExp(',', 'g'), ''));
						if(xTotal!==harga) {
							var rpDiff = harga - xTotal,
								lastRp = parseFloat($('#pay-container input.input-numeric:last').autoNumeric('get'));
							$('#pay-container input.input-numeric:last').autoNumeric('set', (lastRp+rpDiff));
							// console.log(xDP+' - '+xAG+' - '+xTotal+' - '+harga+' - '+rpDiff+' - '+lastRp);
						}
						// fire event
						$('input.input-numeric').trigger('change');
						// generate Ri. bayar
						// var riHTML = $('#pay-ri-container').html('<div class="form-group">&nbsp;</div><div class="form-group">&nbsp;</div><div class="form-group">&nbsp;</div><div class="form-group">&nbsp;</div><div class="form-group"><label class="col-lg-4 control-label">Alokasi Pembayaran</label></div>'),
						// 	riBayar = parseFloat($('#table-paydet tfoot tr td.input-numeric').autoNumeric('get'));
						// $.each($('#pay-container .form-group'), function(index, item) {
						// 	var rpInput = $(this).find('input.input-numeric');
						// 	if(rpInput.length>0) {
						// 		var theRP = parseFloat(rpInput.autoNumeric('get'));
						// 		if(riBayar<theRP) {
						// 			if(riBayar>0) {
						// 				riHTML.append(
						// 					'<div class="form-group">'+
						// 					'<label class="col-lg-4 control-label">'+$(this).find('.control-label').text()+'</label>'+
						// 					'<div class="col-lg-4 text-right"><label class="control-label input-numeric" style="width:100%;padding-right: 10px;">'+riBayar+'</label></div>'+
						// 					'</div>'
						// 				);
						// 				riBayar = 0;
						// 			}
						// 		} else {
						// 			riHTML.append(
						// 				'<div class="form-group">'+
						// 				'<label class="col-lg-4 control-label">'+$(this).find('.control-label').text()+'</label>'+
						// 				'<div class="col-lg-4 text-right"><label class="control-label input-numeric" style="width:100%;padding-right: 10px;">'+theRP+'</label></div>'+
						// 				'</div>'
						// 			);
						// 			riBayar -= theRP;
						// 		}
						// 	}
						// 	$('.input-numeric').autoNumeric('init');
						// });
					}
				);
				
			} else {
				alert('Harga unit untuk metode '+strPayMode+' belum tersedia.');
				$(this).val('').trigger('chosen:updated');
			}
		} else {
			alert('Silahkan pilih unit.');
		}
	});
	$('body').on('mouseover', '.mod-row', function() {
		$('.acc-row').addClass('hidden');
		$(this).children('.acc-row').removeClass('hidden');
	});
	$('body').on('click', '.acc-row', function() {
		$(this).closest('.mod-row').remove();
		$('input.input-numeric').trigger('change');
	});
	$('body').on('change', 'input.input-numeric', function() {
		var harga = parseFloat($('#harga').val().replace(new RegExp(',', 'g'), '')),
			vSum = 0;
		// alert(harga+'  '+vSum);
		var $ele = $(this),
			vSubSum = 0;
		if($ele.hasClass('inDP')) {
			if($(this).hasClass('RES')) {
				var vRES = parseFloat($('#defRES').val()) - parseFloat($('.RES').val().replace(new RegExp(',', 'g'), '')),
					vTJ = parseFloat($('#defTJ').val()),
					vX = vTJ+vRES;
				// console.log(vTJ+vRES);
				$('.TJ').autoNumeric('set', vX);
			}
			$.each($('.inDP'), function(index, item) {
				vSubSum += parseFloat($(this).val().replace(new RegExp(',', 'g'), ''));
			});
			$('#pDP').autoNumeric('set', vSubSum);
		} else if($ele.hasClass('inAG')) {
			$.each($('.inAG'), function(index, item) {
				vSubSum += parseFloat($(this).val().replace(new RegExp(',', 'g'), ''));
			});
			$('#pAG').autoNumeric('set', vSubSum);
		}
		$.each($('input.input-numeric'), function(index, item) {
			vSum += parseFloat($(this).val().replace(new RegExp(',', 'g'), ''));
		});
		$('#totalPayment').autoNumeric('set', vSum);
		if(harga!==vSum) {
			$('#group-total').attr('style', 'color: red');
		} else {
			$('#group-total').attr('style', '');
		}
	});
	$('body').on('click', '.btn-add-row', function() {
		var target = $(this).attr('data-target'),
			targetNum = target==='inDP' ? $('.'+target).length - 1 : $('.'+target).length + 1;
		var kode_pay = $('.'+target+':last').parents('.form-group').children().eq(1).children().eq(0).val(),
			nama_pay = $('.'+target+':last').parents('.form-group').children().eq(1).children().eq(1).val(),
			persen_pay = $('.'+target+':last').parents('.form-group').children().eq(1).children().eq(2).val(),
			val_pay = $('.'+target+':last').parents('.form-group').children().eq(1).children().eq(3).val();
		nama_pay = nama_pay.substr(0, nama_pay.indexOf('#')-1);
		$('.'+target+':last').parents('.form-group').after(
			'<div class="form-group mod-row">' +
			'<label class="col-lg-4 control-label">'+nama_pay+' #'+targetNum+'</label>' +
			'<div class="col-lg-4">' +
			'<input type="hidden" name="fkodepay[]" value="'+kode_pay+'">' +
			'<input type="hidden" name="fnamapay[]" value="'+nama_pay+' #'+targetNum+'">' +
			'<input type="hidden" name="fpersenpay[]" value="">' +
			'<input type="text" name="fvalpay[]" class="form-control input-sm text-right input-numeric '+target+'" value="'+val_pay+'">' +
			'</div>' +
			'<div class="col-lg-3">' +
			'<input type="text" name="ftglpay[]" class="form-control input-sm input-date">' +
			'</div>' +
			'<div class="col-lg-1 acc-row pt5 hidden">' +
			'<a href="javascript:" alt="Delete row" title="Remove row" class="text-danger fs14"><span class="glyphicons glyphicons-remove"></span> </a>' +
			'</div>' +
			'</div>'
		);
		// init plugins
		$('.input-numeric').autoNumeric('init');
		$('.input-date').datetimepicker({
			pickTime: false,
			format: 'DD/MM/YYYY'
		});
		$('input.input-numeric').trigger('change');
	});
	$('#btn-submit-change').click(function() {
		$(this).addClass('disabled');
		$.post(
			'<?=base_url()?>index.php/sales-change-unit/save',
			$('#form-change-owner-1').serialize()+'&'+$('#form-change-owner-2').serialize(),
			function(respon) {
				if(respon!=='') {
					alert(respon);
					location.href = '<?=base_url()?>index.php/sales-change-unit';
				}
			}
		);
		$(this).removeClass('disabled');
	});
});
</script>