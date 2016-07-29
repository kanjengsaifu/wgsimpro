<script type="text/javascript">
jQuery(document).ready(function() {
	// init component / plugin
	$('.chosen-select').chosen({
		width: '100%',
		allow_single_deselect: true
	});
	$('.chosen-select').val('').trigger('chosen:updated');
	$('#modalUnit').modal({
		show: false, 
		backdrop: false
	});
	// event
	$('#group_by').on('change', function() {
		var sSelect = $(this).val(), tSelect = $('#group_by option[value="'+$(this).val()+'"]').text();
		if(sSelect!=='ALL') {
			$.post(
				'<?=base_url()?>index.php/sales/get-group/'+sSelect,
				function(respon) {
					// console.log(respon);
					$('#filter_by').html('').append('<option value=""></option>');
					$.each(respon, function(iLoop, item) {
						$('#filter_by').append('<option value="'+item.field+'">'+item.nmfield+'</option>');
					});
					$('#filter_by').val('').trigger('chosen:updated');
				}
			);
		}else{

			location.reload();
		}
	});
	$('#filter_by').on('change', function() {  
		var sSelect1 = $('#group_by').val(), sSelect2 = $(this).val(), tSelect = $('#filter_by option[value="'+$(this).val()+'"]').text();
		if(sSelect2!=='') {
			$.getJSON(
				'<?=base_url()?>index.php/sales/filter/'+sSelect1+'/'+sSelect2,
				function(respon) {
					$('#tr-units').html('');
					var str = "";
					str += '<td class="text-center pn" style="vertical-align: top">';
					str += '<div class="panel">';
					str += '<div class="panel-heading bg-success">';
					str += '<span class="panel-title">'+tSelect+'</span>';
					str += '</div>';
					str += '<div class="panel-body pn">';
					str += '<table class="table table-bordered mbn">';
					str += '<tbody>';
					$.each(respon, function(iLoop, item) {
						str += '<tr>';
						str += '<td style="background-color: #ece7f9;">'+iLoop+'</td>';
						var td = '';
						$.each(item, function(iLoop2, item2) {
							var sStyle = ' background-color: #d9f1d5; cursor: pointer';
							var sClass = 'td-unit';
							if(item2.ishold==='1') {
								sStyle = 'background-color: #ffffff';
								sClass = 'td-none';
							} else if(item2.status_tr==='HOLD') {
								sStyle = 'background-color: #fdf0d4;';
								sClass = 'td-unit';
							} else if(item2.status_tr==='RESERVE') {
								sStyle = 'background-color: #ed7764;';
								sClass = 'td-unit';
							} else if(item2.status_tr==='BOOKING') {
								sStyle = 'background-color: #6c9fe3 ';
								sClass = 'td-unit';
							} else if(item2.status_tr==='PESANAN') {
								sStyle = 'background-color: #6c9fe3 ';
								sClass = 'td-unit';
							} else if(item2.status_tr==='SALES') {
								sStyle = 'background-color: #6c9fe3 ';
								sClass = 'td-unit';
							}
							td += '<td data-id="'+item2.xno_unit+'" class="'+sClass+'" style="'+sStyle+'">'+item2.no_unit+'</td>';
						});
						str += td;
						str += '</tr>';
					});
					str += '</tbody>';
					str += '</table>';
					str += '</div>';
					str += '</div>';
					str += '</td>';
					$('#tr-units').html(str);
				}
			);
		}
	});
	$('body').on('click', '.td-unit', function() {
		var id =  $(this).attr('data-id');
		$.getJSON(
			'<?=base_url()?>index.php/sales/get/'+id,
			function(respon) { 
				$('#pno_unit').text(respon.no_unit);
				$('#ptype_unit').text(respon.type_unit);
				$('#ptower_cluster').text(respon.tower_cluster);
				$('#pwide_netto').text(respon.wide_netto);
				$('#pwide_gross').text(respon.wide_gross);
				$('#plantai_blok').text(respon.lantai_blok);
				$('#pdirection').text(respon.direction!==null?respon.direction:'');
				$('#pdirection_wind').text(respon.mata_angin!==null?respon.mata_angin:'');
				// $('#pharga').text(respon.tr_jual);
				// $('#pterbilang').text(respon.terbilang);
				// prices
				var pricesHTML = $('#prices-container').html('');
				// if(respon.cara_bayar===null || respon.cara_bayar==='')
				if(respon.prices !== undefined) {
					$.each(respon.prices, function(index, item) {
						var str = respon.cara_bayar===null || respon.cara_bayar==='' ? '' : 'hidden';
						pricesHTML.append(
							'<div class="form-group mbn '+(respon.kode_pay===item.kode_pay?'':str)+'">'+
							'<label class="col-lg-2 control-label">Harga '+item.nama+'</label>'+
							'<div class="col-lg-4">'+
							'<p class="form-control-static text-muted input-numeric" id="pharga-'+item.cara_bayar+'">'+item.tr_jual+'</p>'+
							'</div>'+
							'<label class="col-lg-2 control-label">Terbilang</label>'+
							'<div class="col-lg-4">'+
							'<p class="form-control-static text-muted" id="pterbilang-'+item.cara_bayar+'">'+item.terbilang+'</p>'+
							'</div>'+
							'</div>'
						);
						if(respon.cara_bayar!==null && respon.cara_bayar!=='') {
							if(respon.kode_pay===item.kode_pay) {
								pricesHTML.append(
									'<div class="form-group mbn">'+
									'<label class="col-lg-2 control-label">Harga NETTO</label>'+
									'<div class="col-lg-4">'+
									'<p class="form-control-static text-muted input-numeric" id="pharga-netto-'+item.cara_bayar+'">'+item.rp_netto+'</p>'+
									'</div>'+
									'<label class="col-lg-2 control-label">Terbilang</label>'+
									'<div class="col-lg-4">'+
									'<p class="form-control-static text-muted" id="pterbilang-netto-'+item.cara_bayar+'">'+item.terbilang_netto+'</p>'+
									'</div>'+
									'</div>'
								);
							}
						}
					});
				}
                if($('#prices-container').find('div.form-group').length<1) {
                    pricesHTML.append(
                        '<div class="form-group mbn">'+
                        '<div class="col-lg-6">Harga Unit Belum tersedia.</div>'+
                        '</div>'
                    );
                }
				// customer
				$('#customer-container').addClass('hidden');
				if(respon.nama!==undefined && respon.nama!=='') {
					$('#pkode').text(respon.kode);
					$('#pnama').text(respon.salutation+'. '+respon.nama);
					$('#pklasifikasi').text(respon.klasifikasi);
					$('#php').text(respon.hp);
					$('#pemail').text(respon.email);
					$('#customer-container').removeClass('hidden');
				}
				// payment plan
				$('#lbl-status_tr').html('<b>Status: '+respon.status_tr+(respon.status_tr!==null && respon.status_tr!=='SALES'?' ('+respon.umur_payment+')':'')+'</b>');
				$('#lbl-status_tr').removeClass('hidden');
				if(respon.status_tr===null) {
					$('#lbl-status_tr').addClass('hidden');
				}
				$('#payment-container').addClass('hidden');
				if(respon.payments!==undefined && respon.payments.length>0) {
					$('#lbl-tgl_payment').text('Tanggal '+respon.status_tr);
					$('#ptgl_payment').text(respon.tgl_payment);
					$('#lbl-reserve_no').text('No. '+respon.status_tr);
					$('#preserve_no').text(respon.reserve_no);
					$('#psales_nama').text(respon.sales_nama);
					$('#pcara_bayar').text(respon.cara_bayar_desc);
					$('#pkode_pay').text(respon.skode_pay);
					$('#pharga_jual').text(respon.harga_jual);
					$('#pterbilang_jual').text(respon.terbilang_jual);
					$('#payment-container').removeClass('hidden');
				}
				// buttons
				$('#btn-hold').attr('href', '<?=base_url()?>index.php/hold/'+id);
				$('#btn-reserve').attr('href', '<?=base_url()?>index.php/reserve/'+id);
				$('#btn-booking').attr('href', '<?=base_url()?>index.php/booking/'+id);
				$('#btn-hold').removeClass('disabled');
				$('#btn-reserve').removeClass('disabled');
				$('#btn-booking').removeClass('disabled');
				if(respon.status_tr==='HOLD') {
					$('#btn-hold').addClass('disabled');
					$('#btn-reserve').removeClass('disabled');
					$('#btn-booking').removeClass('disabled');
				}
				if(respon.status_tr==='RESERVE') {
					$('#btn-hold').addClass('disabled');
					$('#btn-reserve').addClass('disabled');
					$('#btn-booking').removeClass('disabled');
				}
				if(respon.status_tr==='BOOKING' || (respon.harga_unit_old!=='0' && respon.harga_unit_old!==undefined)) {
					$('#btn-hold').addClass('disabled');
					$('#btn-reserve').addClass('disabled');
					$('#btn-booking').addClass('disabled');
				}
				if(respon.status_tr==='SALES') {
					$('#btn-hold').addClass('disabled');
					$('#btn-reserve').addClass('disabled');
					$('#btn-booking').addClass('disabled');
				}
				$('.input-numeric').autoNumeric('init');
			}
		);
		$('#modalUnit').modal('show');
	});
});
</script>
