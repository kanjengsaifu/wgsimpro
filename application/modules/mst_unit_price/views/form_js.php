<script type="text/javascript">
jQuery(document).ready(function() {
	// init component / plugin
	$('.chosen-select').chosen({
		width: '100%',
		allow_single_deselect: true
	});
	$('#datatable-unit').dataTable({
		"bServerSide":true,
		"bProcessing":true,
		"sPaginationType": "full_numbers",
		"bFilter":true,
		"sServerMethod": "POST",
		"sAjaxSource": "<?=base_url()?>index.php/unit-price/DT",
		"columns": [
			{ "name": "no_unit" },
			{ "name": "type_property" },
			{ "name": "tower_cluster" },
			{ "name": "type_unit" },
			{ "name": "wide_netto" },
			{ "name": "wide_gross" },
			{ "name": "lantai_blok" },
			{ "name": "direction" },
			{ "name": "mata_angin" },
			{ "name": "action", "searchable": false, "sortable": false }
		]
	});
	$('.chosen-select').val('').chosen().trigger('chosen:updated');
	$('.input-numeric').autoNumeric('init');
	// event
	$('#type_price').on('change', function() {
		$('#grup').val($('#type_price option:selected').attr('data-grup'));
	});
	$('#btn-submit').click(function() {
		$(this).attr('disabled', true);
		var no_unit = $('#no_unit').val();
			// vCara_bayar = $('#kode_pay').val(),
			// sCara_bayar = $('#kode_pay option:selected').text(),
			// sType_price = $('#type_price').val(),
			// vRp = parseFloat($('#rp').autoNumeric('get')),
			// tblbody = $('#datatable tbody');
		if(no_unit!=='') {
			$.post(
				'<?=base_url()?>index.php/unit-price/save',
				$('#form-input').serialize(),
				function(respon) {
					alert('Data tersimpan.');
					$('#xrow-unit').trigger('click');
					$('.chosen-select').val('').chosen().trigger('chosen:updated');
					$('#rp').autoNumeric('set', 0.00);
				}
			);
		} else {
			alert('Silahkan pilih unit.');
		}
		$(this).attr('disabled', false);
	});
	$('body').on('click', '.row-unit', function() {
		var no_unit = $(this).attr('data-unit'),
			encunit = $(this).attr('data-encunit');
		$('#no_unit').val(no_unit);
		$('#pno_unit').text(no_unit);
		$('#xrow-unit').attr('data-unit', no_unit);
		$('#xrow-unit').attr('data-encunit', encunit);
		$('.chosen-select').val('').chosen().trigger('chosen:updated');
		$('#rp').autoNumeric('set', 0.00);
		var tblhead = $('#datatable thead').html(''),
			tblbody = $('#datatable tbody').html(''),
			tblfoot = $('#datatable tfoot').html('');
		$.post(
			'<?=base_url()?>index.php/unit-price/get/'+encunit,
			function(respon) {
				var nMax = 0, arrTotal = [], arrHead = [];
				$.each(respon, function(idx1, it1) {
					var arrSum = [],
						sID = [];
					$.each(it1, function(idx2, it2) {
						var arrRow = [],
							xstr2 = '',
							str2 = '<tr>';
						if(idx2==='CADANGAN BONUS') {
							xstr2 = ' <a class="label label-danger pull-right row-bonus" href="javascript:" style="line-height:12px">Pembulatan</a>';
						}
						str2 += '<td>'+idx2+xstr2+'</td>';
						if(sID.length===0) { /* init element selector ID */
							sID = new Array(nMax);
							for(iLoop=0;iLoop<sID.length;iLoop++) {
								sID[iLoop] = '';
							}
						}
						if(arrHead.length===0) { /* init thead */
							arrHead = new Array(nMax);
							for(iLoop=0;iLoop<arrHead.length;iLoop++) {
								arrHead[iLoop] = '';
							}
						}
						if(it2.length > 0 && it2[0].pay!==''){ /* build item rp */
							$.each(it2, function(idx3, it3) {
								str2 += '<td class="text-right input-numeric">'+it3.rp+'</td>';
								nMax = nMax < parseInt(idx3)+1 ? parseInt(idx3)+1 : nMax;
								arrRow.push(parseFloat(it3.rp));
								sID[idx3] = it3.grup+'-'+it3.xkode_pay; /* assign element selector ID */
								arrHead[idx3] = it3.pay; /* assign thead */
							});
							if(it2.length<nMax) {
								for(iLoop=nMax-1;iLoop>=it2.length;iLoop--) {
									str2 += '<td class="text-right input-numeric">0</td>';
									arrRow.push(0);
									sID[iLoop] = '';
									arrHead[iLoop] = '';
								}
							}
						} else {
							for(var iLoop=0; iLoop<nMax; iLoop++) { /* build item rp to 0 (null items) */
								str2 += '<td class="text-right input-numeric">0</td>';
								arrRow.push(0);
							}
						}
						if(arrSum.length===0) { /* init sub total array */
							arrSum = new Array(nMax);
							for(iLoop=0;iLoop<arrSum.length;iLoop++) {
								arrSum[iLoop] = 0;
							}
						}
						for(iLoop=0;iLoop<arrSum.length;iLoop++) {
							arrSum[iLoop] += parseFloat(arrRow[iLoop]); /* assign sub total array val */
						}
						str2 += '</tr>';
						tblbody.append(str2);
					});
					var str1 = '<tr class="bg-info light">'; /* build sub total row */
					str1 += '<td class="text-right"><b>'+idx1+'</b></td>';
					if(arrTotal.length===0) {
						arrTotal = new Array(nMax);
						for(iLoop=0;iLoop<arrTotal.length;iLoop++) {
							arrTotal[iLoop] = 0;
						}
					}
					for(iLoop=0;iLoop<arrSum.length;iLoop++) {
						str1 += '<td class="text-right input-numeric" style="font-weight:bold" id="'+sID[iLoop]+'">'+arrSum[iLoop]+'</td>';
						arrTotal[iLoop] += arrSum[iLoop];
					}
					str1 += '</tr>';
					tblbody.append(str1);
				});
				var strH = '<tr class="bg-primary light bg-gradient">'; /* build thead */
				strH += '<td class="text-center"><b>JENIS</b></td>';
				for(iLoop=0;iLoop<arrHead.length;iLoop++) {
					strH += '<td class="text-right input-numeric" style="font-weight:bold">'+arrHead[iLoop]+'</td>';
				}
				strH += '</tr>';
				tblhead.append(strH);
				var strT = '<tr class="bg-primary light">'; /* build tfoot (total rp) */
				strT += '<td class="text-right"><b>BRUTO</b></td>';
				for(iLoop=0;iLoop<arrTotal.length;iLoop++) {
					strT += '<td class="text-right input-numeric" style="font-weight:bold">'+arrTotal[iLoop]+'</td>';
				}
				strT += '</tr>';
				tblfoot.append(strT);
				$('.input-numeric').autoNumeric('init');
			},
		'json');
	});
	$('#type_price').on('change', function() {
		var theF = $('#type_price option:selected').attr('data-formula');
		if(theF!==undefined && theF!=='') {
			var availVar = ['NETTO', 'PAJAK', 'CUSTOM'];
			var delimiter = [' ', '\\\+', '-', '\\\(', '\\\)', '\\*', '/', ':', '\\\?'];
			var tokens = theF.split(new RegExp(delimiter.join('|'), 'g'));
			var xstr = '';
			var result = 0;
			for(iLoop=0;iLoop<tokens.length;iLoop++) {
				if($.inArray(tokens[iLoop], availVar)>=0) {
					xstr += 'var ' + tokens[iLoop] + ' = ' + $('#'+tokens[iLoop]+'-'+$('#kode_pay').val()).autoNumeric('get') + ';';
				}
			}
			xstr += 'result = '+theF+';';
			// console.log(eval(xstr));
			$('#rp').autoNumeric('set', eval(xstr));
		}
	});
	$('body').on('click', '.row-bonus', function() {
		if(confirm('Anda yakin ingin melakukan pembulatan untuk Unit Price '+$('#xrow-unit').attr('data-unit')+' ?')) {
			$.post(
				'<?=base_url()?>index.php/unit-price/round/'+$('#xrow-unit').attr('data-encunit'),
				function(respon) {
					if(respon==='') {
						alert('Pembulatan berhasil.');
						$('#xrow-unit').trigger('click');
					} else {
						alert('Terjadi kesalahan, silahkan hubungi administrator.');
					}
				}
			);
		}
	});
});
</script>