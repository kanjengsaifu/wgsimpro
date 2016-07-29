<script type="text/javascript">
var strUraianBL = '',
	strUraianBTL = '';
<?php 
if(isset($data['uraians'])) { 
	$strBL = $strBTL = '';
	foreach ($data['uraians'] as $k => $v) {
		$strBL .= $v['jenis']==='BL'?'<option value="'.$v['konten'].'" data-jenis="'.$v['jenis'].'">'.$v['konten'].'</option>':'';
		$strBTL .= $v['jenis']==='BTL'?'<option value="'.$v['konten'].'" data-jenis="'.$v['jenis'].'">'.$v['konten'].'</option>':'';
	}
	echo 'strUraianBL = \''.$strBL.'\';';
	echo 'strUraianBTL = \''.$strBTL.'\';';
}
?>
var genDiv = function(ele, opt, ischild) {
	if(typeof ischild === 'undefined' || ischild === null) {
		ischild = 0;
	}
	var depth = opt.no_path.length>1?opt.no_path.split('.').length:1,
		no_path = opt.no_path,
		padding = depth<2 ? '' : ' pl'+(depth*5),
		prop = $('#sel-type_property option:selected').val();
	// str rps
	var strRps = '';
	if(opt.rps==='undefined' || opt.rps === null) {
		$.each($('.luas'), function() {
			strRps += '<div class="col-lg-2 pt5">'+
		        '<input type="text" name="rp['+$(this).attr('data-kode')+'][]" id="rp_'+$(this).attr('data-kode')+'" class="form-control input-numeric input-sm text-right input-rp rp-'+opt.jenis+'-'+$(this).attr('data-kode')+'" value="0">'+
		        '</div>';
		});
	} else {
		$.each(opt.rps, function(index, item) {
			strRps += '<div class="col-lg-2 pt5">'+
		        '<input type="text" name="rp['+index.substr(3)+'][]" id="rp_'+index.substr(3)+'" class="form-control input-numeric input-sm text-right input-rp rp-'+opt.jenis+'-'+index.substr(3)+'" value="'+item+'">'+
		        '</div>';
		});
	}
	var strHTML = 
		'<div class="form-group mb5">'+
		'<input type="hidden" name="no_path[]" id="no_path" value="'+opt.no_path+'"/>'+
		'<input type="hidden" name="parent[]" id="parent" value="'+opt.parent+'"/>'+
		'<input type="hidden" name="jenis[]" id="jenis" value="'+opt.jenis+'"/>'+
		'<div class="col-lg-1">'+
        '<p class="form-control-static'+padding+'"><b>'+no_path+'</b></p>'+
        '</div>'+
		'<div class="col-lg-3 pt5">'+
        '<select id="uraian" name="uraian[]" class="chosen-select uraian" data-placeholder="Uraian">'+
        '<option value=""></option>'+(opt.jenis==='BL'?strUraianBL:strUraianBTL)+
        '</select>'+
        '</div>'+
        strRps+
        '<div class="col-lg-2 pt5">'+
        '<a href="javascript:" alt="Add Detail" title="Add Detail" class="label label-success btn-add-detail" data-depth="'+(depth<1?1:depth)+'" data-parent="'+opt.no_path+'"><span class="fa fa-plus"></span> Detail</a>'+
        '&nbsp;&nbsp;'+
        '<a href="javascript:" alt="Remove row" title="Remove row" class="text-danger fs14 hidden btn-remove-row"><span class="glyphicons glyphicons-remove"></span> </a>' +
        '</div>'+
		'</div>';
	if(ischild===0) {
		ele.append(strHTML);
	} else {
		ele.after(strHTML);
	}
	ele.find('#no_path[value="'+opt.no_path+'"]').closest('.form-group').find('#uraian').val(opt.uraian);
	$('.chosen-select').chosen({
		width: '100%',
		allow_single_deselect: true,
		search_contains: true
	});
	$('.chosen-select').chosen().trigger('chosen:updated');
	$('.input-numeric').autoNumeric('init');
},
	doSUM = function() {
	$.each($('.luas'), function() {
		// sum HPP BL
		var xSum = 0;
		$.each($('.rp-BL-'+$(this).attr('data-kode')), function() {
			xSum += parseFloat($(this).autoNumeric('get'));
		});
		$('.lbl-bl-total-'+$(this).attr('data-kode')).autoNumeric('set', xSum);
		// HPPL m2
		$('.lbl-bl-m2-'+$(this).attr('data-kode')).autoNumeric('set', xSum/parseFloat($(this).autoNumeric('get')));
		// sum HPP BTL
		var xSum = 0;
		$.each($('.rp-BTL-'+$(this).attr('data-kode')), function() {
			xSum += parseFloat($(this).autoNumeric('get'));
		});
		$('.lbl-btl-total-'+$(this).attr('data-kode')).autoNumeric('set', xSum);
		// sum HPP
		$('.lbl-hpp-total-'+$(this).attr('data-kode')).autoNumeric('set', 
			parseFloat($('.lbl-bl-total-'+$(this).attr('data-kode')).autoNumeric('get'))+parseFloat($('.lbl-btl-total-'+$(this).attr('data-kode')).autoNumeric('get')));
		// HPPL m2
		$('.lbl-hpp-m2-'+$(this).attr('data-kode')).autoNumeric('set', 
			parseFloat($('.lbl-hpp-total-'+$(this).attr('data-kode')).autoNumeric('get'))/parseFloat($(this).autoNumeric('get')));
	});
};
jQuery(document).ready(function() {
	// init plugins
	$('.chosen-select').chosen({
		width: '100%',
		allow_single_deselect: true,
		search_contains: true
	});
	$('.chosen-select').val('').chosen().trigger('chosen:updated');
	$('.input-numeric').autoNumeric('init');
	// init page
	$.post(
		'<?=base_url()?>index.php/hpp/get-hpp/'+$('#kode_entity').val(),
		function(respon) {
			// luas
			var divLuasHead = $('.BL-luas-head').html('<label class="col-lg-4">&nbsp;</label>'),
				divLuas = $('.BL-luas').html('<label class="col-lg-4">Luas</label>'),
				divBLTotal = $('.BL-total').html('<div class="col-lg-1">&nbsp;</div><label class="col-lg-3">TOTAL HPP LANGSUNG</label>'),
				divBLm2 = $('.BL-m2').html('<div class="col-lg-1">&nbsp;</div><label class="col-lg-3">HPPL /m&sup2;</label>'),
				divBTLTotal = $('.BTL-total').html('<div class="col-lg-1">&nbsp;</div><label class="col-lg-3">TOTAL HPP TIDAK LANGSUNG</label>'),
				divHPPTotal = $('.HPP-total').html('<div class="col-lg-1">&nbsp;</div><label class="col-lg-3">TOTAL HPP</label>');
				divHPPm2 = $('.HPP-m2').html('<div class="col-lg-1">&nbsp;</div><label class="col-lg-3">HPP /m&sup2;</label>'),
			$.each(respon.luas, function(index, item) {
				divLuasHead.append(
					'<label class="col-lg-2 text-center">'+item.str+'</label>'
				);
				divLuas.append(
					'<label class="col-lg-2 luas luas-'+item.type_property+' text-right input-numeric pr20" data-kode="'+item.type_property+'">'+item.luas+'</label>'
				);
				divBLTotal.append(
					'<label class="col-lg-2 lbl-bl-total lbl-bl-total-'+item.type_property+' text-right input-numeric pr20" data-kode="'+item.type_property+'">0</label>'
				);
				divBLm2.append(
					'<label class="col-lg-2 lbl-bl-m2 lbl-bl-m2-'+item.type_property+' text-right input-numeric pr20" data-kode="'+item.type_property+'">0</label>'
				);
				divBTLTotal.append(
					'<label class="col-lg-2 lbl-btl-total lbl-btl-total-'+item.type_property+' text-right input-numeric pr20" data-kode="'+item.type_property+'">0</label>'
				);
				divHPPTotal.append(
					'<label class="col-lg-2 lbl-hpp-total lbl-hpp-total-'+item.type_property+' text-right input-numeric pr20" data-kode="'+item.type_property+'">0</label>'
				);
				divHPPm2.append(
					'<label class="col-lg-2 lbl-hpp-m2 lbl-hpp-m2-'+item.type_property+' text-right input-numeric pr20" data-kode="'+item.type_property+'">0</label>'
				);
				$('.input-numeric').autoNumeric('init');
			});
			// contents
			$('.BL-container').html('');
			$('.BTL-container').html('');
			$.each(respon.data, function(index, item) {
				var targetDiv = $('.'+item.jenis+'-container'),
					rps = {};
				$.each(item, function(idx, it) {
					if(idx.substr(0, 2)==='rp') {
						rps[idx] = it;
					}
				});
				genDiv(
					targetDiv,
					{
						'parent': item.parent,
						'uraian': item.uraian,
						'jenis': item.jenis,
						'no_path': item.no_path,
						'rps': rps
					}
				);
			});
			doSUM();
		},
		'json'
	);
	// events
	$('.btn-add-header').click(function() {
		if($('#type_cost').val()!=='') {
			var targetDiv = $('.'+$('#type_cost').val()+'-container').find('.form-group').length>0 ?
					$('.'+$('#type_cost').val()+'-container').find('.form-group').last() :
					$('.'+$('#type_cost').val()+'-container'),
				ischild = $('.'+$('#type_cost').val()+'-container').find('.form-group').length>0 ? 1 : 0,
				no_path = $('.'+$('#type_cost').val()+'-container').find('.form-group #parent[value="0"]').length+1,
				pref_path = $('#type_cost').val()==='BL' ? '1.' : '2.';
			genDiv(
				targetDiv,
				{
					'parent': 0,
					'uraian': '',
					'jenis': $('#type_cost option:selected').val(),
					'no_path': pref_path+no_path,
					'rps': null
				},
				ischild
			);
		} else {
			alert('Mohon pilih jenis biaya.');
		}
	});
	$('.BL-container, .BTL-container').on('click', '.btn-add-detail', function() {
		var parent = $(this).attr('data-parent'),
			jenis = $(this).closest('.form-group').find('#jenis').val(),
			member = $(this).closest('.'+jenis+'-container').find('#parent[value="'+parent+'"]'),
			no_path = parent+'.'+(member.length+1),
			targetDiv = member.last().parents('.form-group');
		targetDiv = targetDiv.length>0 ? targetDiv : $(this).closest('.form-group');
		genDiv(
			targetDiv,
			{
				'parent': parent,
				'uraian': '',
				'jenis': jenis,
				'no_path': no_path,
				'rps': null
			},
			1
		);
	});
	$('.BL-container, .BTL-container').on('mouseover', '.form-group', function() {
		$(this).css('background-color', '#ddd');
		$(this).find('.btn-remove-row').removeClass('hidden');
	});
	$('.BL-container, .BTL-container').on('mouseout', '.form-group', function() {
		$(this).css('background-color', '#fff');
		$(this).find('.btn-remove-row').addClass('hidden');
	});
	$('.BL-container, .BTL-container').on('click', '.btn-remove-row', function() {
		$(this).closest('.form-group').remove();
	});
	// custom jquery chosen: allow free text
	$('body').on('keyup', '#uraian_chosen .chosen-drop .chosen-search input', function(e) {
		if(e.which===13 && $(this).closest('.chosen-drop').find('li.no-results').length>0) {
			$(this).closest('.col-lg-3').find('.uraian').append('<option value="'+$(this).val()+'">'+$(this).val()+'</option>');
			$(this).closest('.col-lg-3').find('.uraian').val($(this).val()).chosen().trigger('chosen:updated');
			$(this).closest('.col-lg-3').find('.uraian').chosen().trigger('chosen:updated');
		}
	});
	$('.BL-container, .BTL-container').on('change', '.input-rp', function() {
		doSUM();
	});
	$('#btn-submit').click(function() {
		$('#btn-submit').attr('disabled', true);
		// validasi
		var isValid = true;
		// $.each($('.required'), function(index, item) {
		// 	if($(this).val()=='')
		// 		isValid &= false;
		// });
		
		if(isValid) {
			//var data = $('#form-input').serialize();
			$.post(
				'<?=base_url()?>index.php/hpp/save/1',
				$('#form-input').serialize(),
				function(respon) {
					alert('Data tersimpan.');
					location.href = '<?=base_url()?>index.php/hpp';
				}
			);
		}
	});
});
</script>