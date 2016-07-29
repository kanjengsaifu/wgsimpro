<script type="text/javascript">
var strUraianBL = '',
	strUraianBTL = '',
	strCoa = '',
	strRIK = '',
	headerLoop = 1,
	strUnit = '';
<?php 
if(isset($data['option']['uraians'])) { 
	$strBL = $strBTL = '';
	foreach ($data['option']['uraians'] as $k => $v) {
		$strBL .= $v['jenis']==='BL'?'<option value="'.$v['konten'].'" data-jenis="'.$v['jenis'].'">'.$v['konten'].'</option>':'';
		$strBTL .= $v['jenis']==='BTL'?'<option value="'.$v['konten'].'" data-jenis="'.$v['jenis'].'">'.$v['konten'].'</option>':'';
	}
	echo 'strUraianBL = \''.$strBL.'\';';
	echo 'strUraianBTL = \''.$strBTL.'\';';
}
if(isset($data['option']['coas'])) { 
	$str = '';
	foreach ($data['option']['coas'] as $k => $v) {
		$str .= '<option value="'.$v['kode'].'">'.$v['kode'].' - '.$v['nama'].'</option>';
	}
	echo 'strCoa = \''.$str.'\';';
}
if(isset($data['option']['units'])) { 
	$str = '';
	foreach ($data['option']['units'] as $k => $v) {
		$str .= '<option value="'.$v['no_unit'].'">'.$v['no_unit'].'</option>';
	}
	echo 'strUnit = \''.$str.'\';';
}
if(isset($data['option']['riks'])) { 
	$str = '';
	foreach ($data['option']['riks'] as $k => $v) {
		$str .= '<option value="'.$v['id'].'">'.$v['konten'].'</option>';
	}
	echo 'strRIK = \''.$str.'\';';
}
?>
var romanize = function(num) {
    if (!+num)
        return false;
    var digits = String(+num).split(""),
        key = ["","C","CC","CCC","CD","D","DC","DCC","DCCC","CM",
               "","X","XX","XXX","XL","L","LX","LXX","LXXX","XC",
               "","I","II","III","IV","V","VI","VII","VIII","IX"],
        roman = "",
        i = 3;
    while (i--)
        roman = (key[+digits.pop() + (i * 10)] || "") + roman;
    return Array(+digits.join("") + 1).join("M") + roman;
}, 
genDiv = function(ele, opt, ischild) {
	if(typeof ischild === 'undefined' || ischild === null) {
		ischild = 0;
	}
	var depth = opt.no_path.length>1?opt.no_path.split('.').length:1,
		no_path = depth<2 ? romanize(parseInt(opt.no_path)) : opt.no_path,
		padding = depth<2 ? '' : ' pl'+(depth*5),
		prop = $('#sel-type_property option:selected').val(),
		eleUnits = '';
	if(opt.units!==undefined) {
		$.each(opt.units, function(index, item) {
			/* /([.*+?^=!:${}()|\[\]\/\\])/g */
			var xno = item.no_path.replace(/([.])/g, '_');
			eleUnits += '<div class="row-unit">'+
				'<input type="hidden" name="no_unit[d'+xno+'][]" class="unit-no" value="'+item.no_unit+'" />'+
				'<input type="hidden" name="vol_unit[d'+xno+'][]" class="unit-vol" value="'+item.volume+'" />'+
				'<input type="hidden" name="rp_unit[d'+xno+'][]" class="unit-rp" value="'+item.rp+'" />'+
				'</div>';
		});
	}
	var strHTML = 
		'<div class="form-group mb5">'+
		'<input type="hidden" name="no_path[]" id="no_path" value="'+opt.no_path+'"/>'+
		'<input type="hidden" name="parent[]" id="parent" value="'+opt.parent+'"/>'+
		'<input type="hidden" name="jenis[]" id="jenis" value="'+opt.jenis+'"/>'+
		'<input type="hidden" name="type_property[]" id="type_property" value="'+opt.type_property+'"/>'+
		'<div class="col-lg-1">'+
        '<p class="form-control-static'+padding+'"><b>'+no_path+'</b></p>'+
        '</div>'+
		'<div class="col-lg-3 pt5">'+
        '<select id="uraian" name="uraian[]" class="chosen-select uraian" data-placeholder="Uraian">'+
        '<option value=""></option>'+(opt.jenis==='BL'?strUraianBL:strUraianBTL)+
        '</select>'+
        '</div>'+
        '<div class="col-lg-1 pn pt5">'+
        '<div class="checkbox-custom square checkbox-success">'+
        '<input id="ckis_unit-'+no_path+'" type="checkbox"'+(eleUnits!==''?' checked':'')+'>'+
        '<label for="ckis_unit-'+no_path+'"> Unit ?</label>'+
        '</div>'+
        '</div>'+
        '<div class="col-lg-1 pt5">'+
        '<select id="kode_coa" name="kode_coa[]" class="chosen-select" data-placeholder="CoA">'+
        '<option value=""></option>'+strCoa+
        '</select>'+
        '</div>'+
        '<div class="col-lg-1 pt5">'+
        '<select id="kode_rik" name="kode_rik[]" class="chosen-select" data-placeholder="RIK">'+
        '<option value=""></option>'+strRIK+
        '</select>'+
        '</div>'+
        '<div class="col-lg-1 pt5">'+
        '<input type="text" name="bobot[]" id="bobot" class="form-control input-numeric input-sm text-right" value="'+opt.bobot+'">'+
        '</div>'+
        '<div class="col-lg-2 pt5">'+
        '<input type="text" name="rp[]" id="rp" class="form-control input-numeric input-sm text-right" value="'+opt.rp+'">'+
        '</div>'+
        '<div class="col-lg-2 pt5">'+
        '<a href="javascript:" alt="View Units" title="View Units" class="label label-primary btn-view-units'+(eleUnits===''?' hidden':'')+'"><span class="fa fa-search"></span> Units</a>  '+
        '<div class="hidden container-unit">'+eleUnits+'</div>'+
        '<a href="javascript:" alt="Add Detail" title="Add Detail" class="label label-success btn-add-detail" data-depth="'+(depth<1?1:depth)+'" data-parent="'+opt.no_path+'"><span class="fa fa-plus"></span> Detail</a>'+
        '&nbsp;&nbsp;'+
        '<a href="javascript:" alt="Remove row" title="Remove row" class="text-danger fs14 hidden btn-remove-row"><span class="glyphicons glyphicons-remove"></span> </a>' +
        '</div>'+
		'</div>';
	if(ischild===0) {
		if(!$('#container-form').find('.lbl-prop-'+opt.type_property).length>0) {
			ele.append(
				'<div class="form-group fg-label mbn">'+
				'<div class="col-lg-3">'+
	            '<p class="form-control-static pbn lbl-prop-'+opt.type_property+'"><b>'+$('#sel-type_property option:selected').text()+'</b></p>'+
	            '</div>'+
				'</div>'
			);
		}
		if(!ele.find('.lbl-jenis').length>0) {
			ele.append(
				'<div class="form-group fg-label mb5">'+
				'<div class="col-lg-3">'+
	            '<p class="form-control-static lbl-jenis"><b>'+(opt.jenis==='BL'?'A. BIAYA LANGSUNG':'B. BIAYA TAK LANGSUNG')+'</b></p>'+
	            '</div>'+
				'</div>'
			);
		}
		ele.append(strHTML);
		ele.find('#no_path[value="'+opt.no_path+'"]').closest('.form-group').find('#uraian').val(opt.uraian);
		ele.find('#no_path[value="'+opt.no_path+'"]').closest('.form-group').find('#kode_coa').val(opt.kode_coa);
		ele.find('#no_path[value="'+opt.no_path+'"]').closest('.form-group').find('#kode_rik').val(opt.kode_rik);
	} else {
		ele.after(strHTML);
	}
	$('.chosen-select').chosen({
		width: '100%',
		allow_single_deselect: true,
		search_contains: true
	});
	$('.chosen-select').chosen().trigger('chosen:updated');
	$('.input-numeric').autoNumeric('init');
};
jQuery(document).ready(function() {
	$('.chosen-select').chosen({
		width: '100%',
		allow_single_deselect: true,
		search_contains: true
	});
	$('.chosen-select').val('').chosen().trigger('chosen:updated');
	$('.input-numeric').autoNumeric('init');
	$('.input-date').datetimepicker({
		minViewMode: 'years',
		pickTime: false,
		format: 'YYYY'
	});
	$('#modalUnits, #modalItems').modal({
		show: false,
		backdrop: false
	});
	// init value
	<?php if(isset($data['entity'])) { ?>
	$('#pnama').text(': <?=$data['entity']['nama']?>');
	$('#pjenis').text(': <?=$data['entity']['jenis']?>');
	$('#ptgl_mulai').text(': <?=$data['entity']['tgl_mulai']?>');
	$('#ptgl_selesai').text(': <?=$data['entity']['tgl_selesai']?>');
	$('#ptipe_entity').text(': <?=$data['entity']['type_entity']?>');
	$('#pnilai_developer').text(': <?=$data['entity']['nilai_developer']?>');
	$('#kode_entity').val('<?=$data['entity']['kode_entity']?>');
	<?php } ?>
	// event
	$('body').on('click', '.btn-add-header', function() {
		$('#btn-submit-item').attr('data-ischild', '0');
		$('#modalItems').modal('show');
	});
	$('body').on('click', '.btn-view-root', function() {
		var entity = $('#kode_entity').val(),
			tahun = $('#tahun').val(),
			container = $('#container-form').html(''),
			prop = $('#sel-type_property option:selected').val(),
			jenis = 'BL',
			ischild = parseInt($(this).attr('data-ischild')),
			divBL = container.find('#container-'+prop+'-'+jenis),
			divBTL = container.find('#container-'+prop+'-BTL');
		if(prop==='') {
			$('#sel-type_property').trigger('chosen:open');
		} else {
			if(!divBL.length>0) {
				var sibling = $('div[id|="container-'+prop+'"]');
				if(!sibling.length>0) {
					container.append(
						'<div id="container-'+prop+'-'+jenis+'"></div>'
					);
				} else {
					sibling.after(
						'<div id="container-'+prop+'-'+jenis+'"></div>'
					);
				}
				divBL = container.find('#container-'+prop+'-'+jenis);
			}
			var content = divBL.find('.form-group').not('.fg-label');
			if(!content.length>0) {
				$.post(
					'<?=base_url()?>index.php/bpdp/form/'+entity+'/'+tahun+'/'+prop+'/'+jenis,
					function(respon) {
						if(respon.kode_entity!==undefined) {
							if(respon.items.length>0) {
								$.each(respon.items, function(index, item) {
									genDiv(divBL, item);
								});
							} else {
								var no_path = content.length+1;
								genDiv(divBL, {
									'parent': '0',
									'uraian': '',
									'kode_coa': '',
									'bobot': '0',
									'rp': '0',
									'jenis': jenis,
									'type_property': prop,
									'no_path': no_path
								});
							}
						}
					},
				'json');
			}
			// BTL
			jenis = 'BTL';
			if(!divBTL.length>0) {
				var sibling = $('div[id|="container-'+prop+'"]');
				if(!sibling.length>0) {
					container.append(
						'<div id="container-'+prop+'-'+jenis+'"></div>'
					);
				} else {
					sibling.after(
						'<div id="container-'+prop+'-'+jenis+'"></div>'
					);
				}
				divBTL = container.find('#container-'+prop+'-'+jenis);
			}
			var content = divBTL.find('.form-group').not('.fg-label');
			if(!content.length>0) {
				$.post(
					'<?=base_url()?>index.php/bpdp/form/'+entity+'/'+tahun+'/'+prop+'/BTL',
					function(respon) {
						if(respon.kode_entity!==undefined) {
							if(respon.items.length>0) {
								$.each(respon.items, function(index, item) {
									genDiv(divBTL, item);
								});
							} else {
								var no_path = content.length+1;
								genDiv(divBTL, {
									'parent': '0',
									'uraian': '',
									'kode_coa': '',
									'bobot': '0',
									'rp': '0',
									'jenis': jenis,
									'type_property': prop,
									'no_path': no_path
								});
							}
						}
					},
				'json');
			}
		}
	});
	$('body').on('click', '.btn-add-detail', function() {
		var parent = $(this).attr('data-parent'),
			jenis = $(this).closest('.form-group').find('#jenis').val(),
			prop = $(this).closest('.form-group').find('#type_property').val(),
			member = $(this).closest('#container-'+prop+'-'+jenis).find('#parent[value="'+parent+'"]'),
			no_path = parent+'.'+(member.length+1),
			ele = member.last().parents('.form-group');
		ele = ele.length===0 ? $(this).closest('.form-group') : ele;
		genDiv(ele, {
			'parent': parent,
			'uraian': '',
			'kode_coa': '',
			'bobot': '0',
			'rp': '0',
			'jenis': jenis,
			'type_property': prop,
			'no_path': no_path
		}, '1');
	});
	$('#btn-submit-item').click(function() {
		var entity = $('#kode_entity').val(),
			tahun = $('#tahun').val(),
			container = $('#container-form'),
			prop = $('#sel-type_property option:selected').val(),
			jenis = $('#type_cost option:selected').val(),
			ischild = parseInt($(this).attr('data-ischild'));
			div = container.find('#container-'+prop+'-'+jenis);
		if(prop==='') {
			$('#sel-type_property').trigger('chosen:open');
		} else if(jenis==='') {
			$('#type_cost').trigger('chosen:open');
		} else {
			if(!div.length>0) {
				var sibling = $('div[id|="container-'+prop+'"]');
				if(!sibling.length>0) {
					container.append(
						'<div id="container-'+prop+'-'+jenis+'"></div>'
					);
				} else {
					sibling.after(
						'<div id="container-'+prop+'-'+jenis+'"></div>'
					);
				}
				div = container.find('#container-'+prop+'-'+jenis);
			}
			var content = div.find('.form-group').not('.fg-label'),
				no_path = content.length+1;
			genDiv(div, {
				'parent': '0',
				'uraian': '',
				'kode_coa': '',
				'bobot': '0',
				'rp': '0',
				'jenis': jenis,
				'type_property': prop,
				'no_path': no_path
			});
			$('#modalItems').modal('hide');
		}
	});
	$('#container-form').on('mouseover', '.form-group', function() {
		$(this).css('background-color', '#ddd');
		$(this).find('.btn-remove-row').removeClass('hidden');
	});
	$('#container-form').on('mouseout', '.form-group', function() {
		$(this).css('background-color', '#fff');
		$(this).find('.btn-remove-row').addClass('hidden');
	});
	$('#container-form').on('click', '.btn-remove-row', function() {
		$(this).closest('.form-group').remove();
	});
	$('body').on('click', 'input[type="checkbox"]', function() {
		$(this).closest('.form-group').find('.container-unit').html('');
		if($(this).prop('checked')) {
			$(this).closest('.form-group').find('.btn-view-units').removeClass('hidden');
		} else {
			$(this).closest('.form-group').find('.btn-view-units').addClass('hidden');
		}
	});
	$('body').on('change', '.uraian', function() {
		var xval = $(this).val(),
			jenis = $(this).closest('.form-group').find('.uraian option[value="'+xval+'"]').attr('data-jenis');
		$(this).closest('.form-group').find('#jenis').val(jenis);
	});
	// custom jquery chosen: allow free text
	$('body').on('keyup', '#uraian_chosen .chosen-drop .chosen-search input', function(e) {
		if(e.which===13 && $(this).closest('.chosen-drop').find('li.no-results').length>0) {
			$(this).closest('.col-lg-3').find('.uraian').append('<option value="'+$(this).val()+'">'+$(this).val()+'</option>');
			$(this).closest('.col-lg-3').find('.uraian').val($(this).val()).chosen().trigger('chosen:updated');
			$(this).closest('.col-lg-3').find('.uraian').chosen().trigger('chosen:updated');
		}
	});
	$('body').on('click', '.btn-view-units', function() {
		var form = $('#form-view-units').html(
				'<div class="form-group not-input">'+
                '<div class="col-lg-2">'+
                '<a href="javascript:" alt="Add Unit" title="Add Unit" class="label label-success btn-add-unit"><span class="fa fa-plus"></span> Unit</a>'+
                '</div>'+
	            '</div>'
            ),
			container = $(this).closest('.form-group').find('.container-unit .row-unit');
		$.each(container, function(index, item) {
			form.append(
				'<div class="form-group">'+
                '<label class="col-lg-1 control-label">No. Unit</label>'+
                '<div class="col-lg-2">'+
                '<select class="chosen-select unit-no">'+
                '<option value=""></option>'+
                strUnit+
                '</select>'+
                '</div>'+
                '<label class="col-lg-1 control-label">Volume</label>'+
                '<div class="col-lg-2">'+
                '<input type="text" class="form-control input-sm input-numeric unit-vol" value="'+$(this).find('.unit-vol').val()+'">'+
                '</div>'+
                '<label class="col-lg-1 control-label">Nilai</label>'+
                '<div class="col-lg-2">'+
                '<input type="text" class="form-control input-sm input-numeric unit-rp" value="'+$(this).find('.unit-rp').val()+'">'+
                '</div>'+
                '</div>'
            );
            $('.unit-no:last').val($(this).find('.unit-no').val());
		});
		$('.chosen-select').chosen({
			width: '100%',
			search_contains: true,
		}).trigger('chosen:updated');
		$('.input-numeric').autoNumeric('init');
		$('#btn-submit-unit').attr('data-index', $(this).closest('.form-group').index());
		$('#modalUnits').modal('show');
	});
	$('body').on('click', '.btn-add-unit', function() {
		$('#form-view-units').append(
			'<div class="form-group">'+
            '<label class="col-lg-1 control-label">No. Unit</label>'+
            '<div class="col-lg-2">'+
            '<select class="chosen-select unit-no" style="width: 100%">'+
            '<option value=""></option>'+
            strUnit+
            '</select>'+
            '</div>'+
            '<label class="col-lg-1 control-label">Volume</label>'+
            '<div class="col-lg-2">'+
            '<input type="text" class="form-control input-sm input-numeric unit-vol" value="0">'+
            '</div>'+
            '<label class="col-lg-1 control-label">Nilai</label>'+
            '<div class="col-lg-2">'+
            '<input type="text" class="form-control input-sm input-numeric unit-rp" value="0">'+
            '</div>'+
            '</div>'
		);
		$('.chosen-select').chosen().trigger('chosen:updated');
		$('.input-numeric').autoNumeric('init');
	});
	$('#btn-submit-unit').click(function() {
		var targetIdx = $(this).attr('data-index'),
			targetDiv = $('#container-form .form-group').eq(targetIdx).find('.container-unit').html(''),
			no_path = 'd'+$('#container-form .form-group').eq(targetIdx).find('#no_path').val();
			/* /([.*+?^=!:${}()|\[\]\/\\])/g */
			no_path = no_path.replace(/([.])/g, '_');
		$.each($('#form-view-units .form-group').not('.not-input'), function(index, item) {
			targetDiv.append(
				'<div class="row-unit">'+
				'<input type="hidden" name="no_unit['+no_path+'][]" class="unit-no" value="'+$(this).find('.unit-no').val()+'" />'+
				'<input type="hidden" name="vol_unit['+no_path+'][]" class="unit-vol" value="'+$(this).find('.unit-vol').val()+'" />'+
				'<input type="hidden" name="rp_unit['+no_path+'][]" class="unit-rp" value="'+$(this).find('.unit-rp').val()+'" />'+
				'</div>'
			);
		});
		$('#modalUnits').modal('hide');
	});
	$('#btn-submit').click(function() {
		// validasi
		var isValid = true;
		// $.each($('.required'), function(index, item) {
		// 	if($(this).val()=='')
		// 		isValid &= false;
		// });
		
		if(isValid) {
			//var data = $('#form-input').serialize();
			$.post(
				'<?=base_url()?>index.php/bpdp/save',
				$('#form-input').serialize(),
				function(respon) {
					alert('Data tersimpan.');
					location.href = '<?=base_url()?>index.php/bpdp';
				}
			);
		}
	});
});
</script>