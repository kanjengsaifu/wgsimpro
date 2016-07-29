<script type="text/javascript">
(function($, undefined) {
    "use strict";
    var span = document.createElement('span'),
        label = document.createElement('label'),
        radioV = document.createElement('input'),
        radioI = document.createElement('input'),
        radioU = document.createElement('input'),
        radioD = document.createElement('input');
    span.setAttribute('style', 'color: #666666;');
    label.setAttribute('style', 'margin-left: 10px;');
    radioV.setAttribute('type', "radio");
    radioV.setAttribute('value', "view");
    radioI.setAttribute('type', "radio");
    radioI.setAttribute('value', "insert");
    radioU.setAttribute('type', "radio");
    radioU.setAttribute('value', "update");
    radioD.setAttribute('type', "radio");
    radioD.setAttribute('value', "delete");
    $.jstree.plugins.radios = function(options, parent) {
        this.redraw_node = function(obj, deep, callback) {
            obj = parent.redraw_node.call(this, obj, deep, callback);
            if(obj && $(obj).attr('id')!=='root' && $(obj).attr('data-access')!=='0') {
                var tmpS = span.cloneNode(true),
                    tmpL1 = label.cloneNode(true),
                    tmpV = radioV.cloneNode(true),
                    tmpL2 = label.cloneNode(true),
                    tmpI = radioI.cloneNode(true),
                    tmpL3 = label.cloneNode(true),
                    tmpU = radioU.cloneNode(true),
                    tmpL4 = label.cloneNode(true),
                    tmpD = radioD.cloneNode(true);
                tmpV.setAttribute('checked', true);
                tmpV.name = 'rdAkses['+$(obj).attr('id')+']';
                tmpL1.appendChild(tmpV);
                tmpL1.innerHTML += '&nbsp;Lihat';
                if($(obj).attr('data-access')==='insert')
                    tmpI.setAttribute('checked', true);
                tmpI.name = 'rdAkses['+$(obj).attr('id')+']';
                tmpL2.appendChild(tmpI);
                tmpL2.innerHTML += '&nbsp;Tambah';
                if($(obj).attr('data-access')==='update')
                    tmpU.setAttribute('checked', true);
                tmpU.name = 'rdAkses['+$(obj).attr('id')+']';
                tmpL3.appendChild(tmpU);
                tmpL3.innerHTML += '&nbsp;Ubah';
                if($(obj).attr('data-access')==='delete')
                    tmpD.setAttribute('checked', true);
                tmpD.name = 'rdAkses['+$(obj).attr('id')+']';
                tmpL4.appendChild(tmpD);
                tmpL4.innerHTML += '&nbsp;Hapus';
                tmpS.appendChild(tmpL1);
                tmpS.appendChild(tmpL2);
                tmpS.appendChild(tmpL3);
                tmpS.appendChild(tmpL4);
                obj.insertBefore(tmpS, obj.childNodes[2]);
            }
            return obj;
        };
    };
})(jQuery);
jQuery(document).ready(function() {
    $('#kode_entity').bootstrapDualListbox();
    $('#tree-menu').jstree({
        'core': {
            'data': {
                'url': '<?=base_url()?>index.php/user-group/menu/<?=isset($data['id'])?$data['id']:''?>',
                'dataType': 'json'
//                'data': function(node) {
//                    return { id: node.id };
//                }
            }
        },
        'plugins': ['checkbox', 'radios']
    });
	// init value
	<?php if(isset($data['id'])) { ?>
	$('#id').val('<?=$data['id']?>');
	$('#nama').val('<?=$data['nama']?>');
	<?php } ?>
	// event
	$('#btn-submit').click(function() {
		// validasi
		var isValid = true;
        isValid &= $('#nama').val()==='' ? false : true;
		if(isValid) {
			var data = $('#form-input').serialize(),
                menu = '',
                arr = $('#tree-menu').jstree('get_selected');
            $.each(arr, function(index, item) {
                menu += '&menu[]='+item;
            });
            data += menu==='' ? '' : menu;
			$.post(
				'<?=base_url()?>index.php/user-group/save',
				data,
				function(respon) {
					alert('Data tersimpan.');
					location.href = '<?=base_url()?>index.php/user-group';
				}
			);
		}
	});
});
</script>