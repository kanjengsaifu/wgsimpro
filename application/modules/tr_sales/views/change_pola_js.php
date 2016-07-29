<script type="text/javascript">
    var bulatkan = function(id) {
        var vTo = 0, vHa = 0, vNil, fvalpay = 0;
        fvalpay = parseFloat($('#fvalpay'+id).val().replace(new RegExp(',', 'g'), ''));
        vTo = $('#totalPayment').autoNumeric('get');
        vHa = parseFloat($('#vHargaUnit').val().replace(new RegExp(',', 'g'), ''));
        vNil = vTo - vHa;
        $('#fvalpay'+id).autoNumeric('set',(fvalpay - vNil));
        $('.btn-bulat-row').hide();
    };
jQuery(document).ready(function() {
	// init component / plugin
    var idx=1000;
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
            vHargaUnit = 0, vSum = 0,vCheck='';
		$.post(
			'<?=base_url()?>index.php/payment/get/'+resno,
			function(respon) {
				$('#pnama').text(':'+respon.nsb_nama);
				$('#pno_unit').text(':'+respon.no_unit);
				//alert(respon.no_unit);
				$('#no_unit').val(respon.no_unit);
				$('#pharga_unit').text(':'+respon.fharga_unit);
                $('#vHargaUnit').val(respon.fharga_unit);
				$('#pterbilang').text('#'+respon.terbilang+'#');
				$('#pcara_bayar').text(':'+respon.cara_bayar);
				$('#ppola_bayar').text(':'+respon.pola_bayar);
				$('#kode_pay').val(respon.kode_pay);
				$('#cara_bayar').val(respon.cara_bayar);
				var sHTML = '' , snama = '',vSumRa = 0;
                vHargaUnit = respon.fharga_unit;
				if(respon.paydet_rari!==undefined) {
					$.each(respon.paydet_rari, function(index, item) {
                            
                            //if(vCheck !==item.nama){
                                sHTML = '<tr id="'+(item.kode_pay+item.no_urut)+'">';
                                sHTML += '<td class="text-center">'+(index+1)+'</td>';
                                sHTML += '<td>'+(vCheck !==item.nama?(snama===item.nama?'':item.nama):'')+'</td>'; 
                                sHTML += '<td class="text-center">'+(vCheck !==item.nama?(item.tgl_tempo):'')+'</td>';
                                vSumRa += item.ra_rp==='' ? 0 : (vCheck !==item.nama?parseFloat(item.ra_rp):0);
                                sHTML += '<td class="text-right input-numeric">'+(vCheck !==item.nama?(item.ra_rp):'')+'</td>';
                                sHTML += '<td class="text-center">'+(item.tgl_bayar)+'</td>';
                                sHTML += '<td class="text-right input-numeric">'+(item.ri_rp)+'</td>';
                                sHTML += '<td class="text-center">'+(item.no_kwitansi)+'</td>';
                                sHTML += '</tr>';
                                vCheck = item.nama;
                            //}
							
							tblbody.append(sHTML);
						/*tblbody.append(
							'<tr>'+
							'<td class="text-center">'+(index+1)+'</td>'+
							'<td>'+item.nama+'</td>'+
							'<td class="text-center">'+item.tgl_bayar+'</td>'+
							'<td class="text-right input-numeric">'+item.ri_rp+'</td>'+
							'</tr>'
						);*/
						vSum += parseFloat(item.ri_rp);
					});
					tblfoot.append(
						'<tr>'+
						'<td colspan="3" class="text-right">Total Ra</td>'+
						'<td class="text-right input-numeric">'+vSumRa+'</td>'+
                        '<td class="text-right">Total Ri</td>'+
						'<td class="text-right input-numeric">'+vSum+'</td>'+
                        '<td></td>'+
						'</tr>'
					);
					$('.input-numeric').autoNumeric('init');
				}
				$('#reserve_no').val(resno);
				
				//-------------Begin Tambah Angsuran--------------//
			        var sDiv = $('#pay-container').html(""),
					sURL = '',
					sResNo = $('#reserve_no').val(),
					sCaraBayar = respon.cb,
					sKodePay = respon.kode_pay,
					sPayMode = respon.kode_pay, 
					strPayMode = $('#cara_bayar option[value="'+sPayMode+'"]').text(),
					priceP = $('#pharga-'+sPayMode);
					
					sURL = '<?=base_url()?>index.php/payment/getpayment/'+sResNo+'/'+sCaraBayar+'/'+sKodePay;
					$.post(
					sURL,
					function(respon) {
						var str = "",
							sHarga = $('#harga').val(),
							sNum = 1,
                            NoUrut = 1,
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
							if($('#pkode_pay').val()==='') {
								if(parseInt(item.nfield)>1) {
									sNum = 0;
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
										str += '<input type="text" name="fvalpaynew[]" class="form-control input-sm text-right input-numeric hidden" value="0">';
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
									vTotalDP += parseFloat(item.tipepay==='BOOKINGFEE' || item.tipepay==='DOWNPAYMENT' ? vVal2 : 0);
									vTotalAG += parseFloat(item.tipepay==='INSTALLMENT' || item.tipepay==='BANKLOAN' ? vVal2 : 0);
									vMinBooking = item.tipepay==='BOOKINGFEE' && parseFloat(item.persen)===0 ? parseFloat(item.nval) : 0;
									str = '<div class="form-group">';
									str += '<label class="col-lg-4 control-label">'+item.slabel+'</label>';
									str += '<div class="col-lg-4">';
									str += '<input type="hidden" name="fkodepay[]" value="'+item.klabel+'">';
									str += '<input type="hidden" name="fnamapay[]" value="'+item.slabel+'">';
									str += '<input type="hidden" name="fpersenpay[]" value="'+item.persen+'">';
									str += '<input type="text" name="fvalpay[]" class="form-control input-sm text-right input-numeric '+item.klabel+' '+(item.tipepay==='BOOKINGFEE' || item.tipepay==='DOWNPAYMENT' ? 'inDP' : 'inAG')+'" value="'+(vVal2)+'">';
									str += '<input type="text" name="fvalpaynew[]" class="form-control input-sm text-right input-numeric hidden" value="0">';
									str += '<input type="hidden" id="def'+item.klabel+'" value="'+vVal2+'">';
									str += '</div>';
									str += '<div class="col-lg-4'+(item.has_date=='1'?'':' hidden')+'">';
									str += '<input type="text" name="ftglpay[]" value="'+xtglpay.format('DD/MM/YYYY')+'" class="form-control input-sm input-date'+(item.has_date=='1'?'':' hidden')+'">';
									str += '</div>';
									if(item.klabel==='RES')
										str += '<div class="col-lg-4 hidden"><div class="checkbox-custom checkbox-success mb5"><input type="checkbox" id="islunas" name="islunas" value="1"><label for="islunas"> Lunas Reserve</label></div></div>';
									if(item.klabel==='TJ') 
										str += '<div class="col-lg-4 hidden"><div class="checkbox-custom checkbox-success mb5"><input type="checkbox" id="islunasbooking" name="islunasbooking" value="1"><label for="islunasbooking"> Lunas Booking</label></div></div>';
									str += '</div>';
								}
							} else {
								var vVal1 = parseFloat(item.nval);//(item.persen==0?item.nval:parseInt(item.persen)/100*parseFloat(sHarga));
                                var vRiVal = parseFloat(item.ripay);
								var vVal2 = vVal1;//item.tipepay==='BOOKINGFEE' && parseFloat(item.persen)===0 ? vVal1 : vVal1 - vMinBooking;
								vTotalDP += parseFloat(item.tipepay==='BOOKINGFEE' || item.tipepay==='DOWNPAYMENT' ? vVal2 : 0);
								vTotalAG += parseFloat(item.tipepay==='INSTALLMENT' || item.tipepay==='BANKLOAN' ? vVal2 : 0);
								// vMinBooking += item.tipepay==='BOOKINGFEE' && parseFloat(item.persen)===0 ? parseFloat(item.nval) : 0;
								str = '<div class="form-group">';
								str += '<label class="col-lg-4 control-label">'+item.slabel+'</label>';
								str += '<div class="col-lg-4">';
								str += '<input type="hidden" name="'+( item.respay!=='0'?'rkodepay[]':'fkodepay[]')+'" value="'+item.klabel+'">';
								str += '<input type="hidden" name="'+( item.respay!=='0'?'rnamapay[]':'fnamapay[]')+'" value="'+item.slabel+'">';
								str += '<input type="hidden" name="'+( item.respay!=='0'?'rpersenpay[]':'fpersenpay[]')+'" value="'+item.persen+'">';
								str += '<input type="text" id="fvalpay'+NoUrut+'" name="'+( item.respay!=='0'?'rvalpay[]':'fvalpay[]')+'" class="form-control input-sm text-right input-numeric '+(item.tipepay==='BOOKINGFEE' || item.tipepay==='DOWNPAYMENT' ? 'inDP' : 'inAG')+'" value="'+( item.respay!=='0'?vRiVal:vVal2)+'" '+( item.respay!=='0' ? 'disabled="disabled"' : '')+'>';
								str += '<input type="text" name="'+( item.respay!=='0'?'rvalpaynew[]':'fvalpaynew[]')+'fvalpaynew[]" class="form-control input-sm text-right input-numeric hidden" value="0">';
								
                                str += '</div>';
								str += '<div class="col-lg-4'+(item.has_date=='1'?'':' hidden')+'">';
								str += '<input type="text" style="width:80%!important" name="ftglpay[]" class="form-control input-sm input-date'+(item.has_date=='1'?'':' hidden')+'"'+(item.tgl_tempo==undefined ? '' : (item.tgl_tempo==''?'':' value="'+( item.respay!=='0'?item.tglbayar:item.tgl_tempo)+'"'))+'>';
                                str += ( item.respay==='0'?'<a href="javascript:" alt="Add row" title="Add row" onclick="bulatkan('+NoUrut+')" class="label label-warning btn-bulat-row" data-target="inDP"><span class="glyphicons glyphicons-circle_plus"></span> Bulatkan</a>':'');
								str += '</div>';
								if(item.klabel==='RES') 
									str += '<div class="col-lg-4 hidden"><div class="checkbox-custom checkbox-success mb5"><input type="checkbox" id="islunasres" name="islunasres"'+(item.respay!=='0' ? ' checked="checked" disabled="disabled" value="0"' : 'value="1"')+'><label for="islunasres"> Lunas Reserve</label></div></div>';
								if(item.klabel==='TJ') 
									str += '<div class="col-lg-4 hidden"><div class="checkbox-custom checkbox-success mb5"><input type="checkbox" id="islunasbooking" name="islunasbooking" value="1"><label for="islunasbooking"> Lunas Booking</label></div></div>';
								str += '</div>';
							}
							sDiv.append(str);
                            NoUrut++;
						});
						// <div class="col-lg-4 text-right"><label style="width:100%;padding-right:10px;border-bottom:solid 1px #999" class="control-label input-numeric" id="pAG">383,460,000.00</label></div>
						str = '<div class="form-group" id="group-total">';
						str += '<label class="col-lg-4 control-label">Total</label>'; 
						str += '<div class="col-lg-4 text-right"><label id="totalPayment" class="control-label input-numeric" style="width:100%;padding-right: 10px;border-bottom:solid 1px #999">'+sHarga+'</label></div>';
//						str += '</div>';
//                        str += '<div class="form-group" id="group-harga">';
//						str += '<label class="col-lg-4 control-label">Total Harga</label>'; 
//						str += '<div class="col-lg-4 text-right"><label id="totalHarga" class="control-label input-numeric" style="width:100%;padding-right: 10px;border-bottom:solid 1px #999">'+sHarga+'</label></div>';
//						str += '</div>';
//                        str += '<div class="form-group" id="group-lebih">';
//						str += '<label class="col-lg-4 control-label">Lebih</label>'; 
//						str += '<div class="col-lg-4 text-right"><label id="totalLebih" class="control-label input-numeric" style="width:100%;padding-right: 10px;border-bottom:solid 1px #999">'+sHarga+'</label></div>';
                        
                        str += '</div>';
						sDiv.append(str);
						// diskon
						str = '<div class="form-group hidden" id="group-diskon">';
						str += '<label class="col-lg-4 control-label">Diskon</label>'; 
						str += '<div class="col-lg-4 text-right"><label id="totalDiskon" class="control-label input-numeric" style="width:100%;padding-right: 10px;border-bottom:solid 1px #999">0</label></div>';
						str += '</div>';
						sDiv.append(str);
						str = '<div class="form-group hidden" id="group-after-diskon">';
						str += '<label class="col-lg-4 control-label">Total Setelah Diskon</label>'; 
						str += '<div class="col-lg-4 text-right"><label id="totalAfterDiskon" class="control-label input-numeric" style="width:100%;padding-right: 10px;border-bottom:solid 1px #999">0</label></div>';
						str += '<input type="hidden" name="harga_unit_old" value="0"/>';
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
								lastRp = parseFloat($('#pay-container .form-group input[name="fvalpay[]"]:last').autoNumeric('get'));
							$('#pay-container .form-group input[name="fvalpay[]"]:last').autoNumeric('set', (lastRp+rpDiff));
							// console.log(xDP+' - '+xAG+' - '+xTotal+' - '+harga+' - '+rpDiff+' - '+lastRp);
						}
						// fire event
						$('input.input-numeric').trigger('change');
					}
				);
			
			
			//-------------End Tambah Angsuran----------//
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


	$('body').on('mouseover', '.mod-row', function() {
		$('.acc-row').addClass('hidden');
		$(this).children('.acc-row').removeClass('hidden');
	});
	$('body').on('click', '.acc-row', function() {
		$(this).closest('.mod-row').remove();
		$('input.input-numeric').trigger('change');
	});
    $('body').on('click', '.btn-bulat-row', function() {
        var harga = parseFloat($('#vHargaUnit').val().replace(new RegExp(',', 'g'), '')),
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
        var vHargaUnit = 0, vLebih = 0;
        vHargaUnit = parseFloat($('#vHargaUnit').val().replace(new RegExp(',', 'g'), ''));
        //vHargaUnit = $('#vHargaUnit').val();
		$('#totalPayment').autoNumeric('set', vSum);
//        $('#totalHarga').autoNumeric('set', vHargaUnit);
//        if(vHargaUnit===vSum){
//            $('#group-lebih').hide();
//        }else{
//            $('#group-lebih').show();
//        }
//        $('#totalLebih').autoNumeric('set', (vSum - vHargaUnit));
//        alert(harga+' - '+vSum);
		if(harga!==vSum) {
			$('#group-total').attr('style', 'color: red');
            $('.btn-bulat-row').show();
		} else {
			$('#group-total').attr('style', '');
             $('.btn-bulat-row').hide()
		}
    });
	$('body').on('change', 'input.input-numeric', function() {
		var harga = parseFloat($('#vHargaUnit').val().replace(new RegExp(',', 'g'), '')),
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
        var vHargaUnit = 0, vLebih = 0;
        vHargaUnit = parseFloat($('#vHargaUnit').val().replace(new RegExp(',', 'g'), ''));
        //vHargaUnit = $('#vHargaUnit').val();
		$('#totalPayment').autoNumeric('set', vSum);
//        $('#totalHarga').autoNumeric('set', vHargaUnit);
//        if(vHargaUnit===vSum){
//            $('#group-lebih').hide();
//        }else{
//            $('#group-lebih').show();
//        }
//        $('#totalLebih').autoNumeric('set', (vSum - vHargaUnit));
//        alert(harga+' - '+vSum);
		if(harga!==vSum) {
			$('#group-total').attr('style', 'color: red');
            $('.btn-bulat-row').show();
		} else {
			$('#group-total').attr('style', '');
            $('.btn-bulat-row').hide();
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
			'<input type="hidden" name="fnamapay[]"value="'+nama_pay+' #'+targetNum+'">' +
			'<input type="hidden" name="fpersenpay[]" value="">' +
			'<input type="text" name="fvalpay[]" id="fvalpay'+idx+'" class="form-control input-sm text-right input-numeric '+target+'" value="'+val_pay+'">' +
			'</div>' +
			'<div class="col-lg-3">' +
			'<input type="text" name="ftglpay[]" class="form-control input-sm input-date">' +
            '<a href="javascript:" alt="Add row" title="Add row" onclick="bulatkan('+idx+')" class="label label-warning btn-bulat-row" data-target="inDP"><span class="glyphicons glyphicons-circle_plus"></span> Bulatkan</a>'+
			'</div>' +
			'<div class="col-lg-1 acc-row pt5 hidden">' +
			'<a href="javascript:" alt="Delete row" title="Remove row" class="text-danger fs14"><span class="glyphicons glyphicons-remove"></span> </a>' +
			'</div>' +
			'</div>'
            
		);
        idx++;
		// init plugins
		$('.input-numeric').autoNumeric('init');
		$('.input-date').datetimepicker({
			pickTime: false,
			format: 'DD/MM/YYYY'
		});
		$('input.input-numeric').trigger('change');
	});
	$('#btn-submit-change').click(function() {
		//$(this).addClass('disabled');
		//$.post(
		//	'<?=base_url()?>index.php/sales-change-unit/save',
		//	$('#form-change-owner-1').serialize()+'&'+$('#form-change-owner-2').serialize(),
		//	function(respon) {
		//		if(respon!=='') {
		//			alert(respon);
		//			location.href = '<?=base_url()?>index.php/sales-change-unit';
		//		}
		//	}
		//);
		//$(this).removeClass('disabled');
		alert('Ada kesalah simpan data');
	});
});
</script>