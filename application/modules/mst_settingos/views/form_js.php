<script type="text/javascript">
jQuery(document).ready(function() {
	// init component / plugin
	$('.chosen-select').chosen({
		width: '100%',
	});
	$('.chosen-select').val('').chosen().trigger('chosen:updated');
	$('.input-numeric').autoNumeric('init');


	// init value
	<?php if(isset($data['id'])) { ?>
		$('#id').val('<?=$data['id']?>');
		$('#jenis').val('<?=$data['jenis']?>');
		$('#kode_coa').val('<?=$data['kode_coa']?>');
		$('input[id="penerbitan"]').prop('checked', <?=$data['penerbitan']=='D'?'true':'false'?>);
		$('input[id="pelunasan"]').prop('checked', <?=$data['pelunasan']=='K'?'true':'false'?>);
		//$( "#pelunasan" ).prop( "checked", true );
		$('.chosen-select').trigger('chosen:updated');
	<?php } ?>



	
 	var tampung = "";

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
				'<?=base_url()?>index.php/settos/save',
				$('#form-input').serialize(),
				function(respon) {
					alert('Data tersimpan.');
					location.href = '<?=base_url()?>index.php/settos';
				}
			);
		} else {
			alert('Data Belum Lengkap.\n*Wajib Diisi');
		}
	});

	var delete_rowx = function(act, id) {
		if(act==='edit') {
			location.href = "<?=base_url()?>index.php/settos/edit/"+id;
		} else if(act==='delete') {
			if(confirm("Anda yakin akan menghapus data ini?")) {
				$.post("<?=base_url()?>index.php/settos/delete/"+id,function(ev) {
					if(ev.response==='1') {
						alert('Data berhasil dihapus.');
						location.href = "<?=base_url()?>index.php/settos";
					} else {
						alert('Data gagal dihapus, mohon diperiksa.');
					}
				});
			}
		}
	};

});
 	
	
    function delet(id,parent)
    {
    	//$('#fc_sdid').val(id);
        var answer = confirm("Anda yakin akan menghapus data ini?")
        if (answer){
            $.ajax({
                url:'<?="../d_unit/";?>'+id,
                type: 'POST',
                success:function(data){
                    if(parent==0){
                        window.location.reload();
                    }else{
                    	//alert(parent);
                    	$('#bobot_child_'+parent).load('../f_unit/'+parent);
                    	$(this).html(data);
                        //$('#bobot_child_fl_'+parent).load(parent);
                        //location.reload();
                        
                        $( "#td_"+parent ).click(function() {
					        console.log("orang utan...");

					        setTimeout(
					            function() {
					                //alert("Called after delay.");
					                $( "#td_"+parent ).click();
					            },
					            3000);
					    });
                    }
                }
            });
        }
    }

    function delete_row(id)
    {
    	if(confirm("Anda yakin akan menghapus data ini?")) {
	    	if(id!=null){
	    		//alert('delete id: '+id);
	    		$.post("<?=base_url()?>index.php/po/d_unit/"+id,function(ev) {
					if(ev.response==='1') {
						alert('Unit tersebut berhasil dihapus.');
						//location.href = "<?=base_url()?>index.php/po/edit/";
						location.reload();
					} else {
						alert('Data gagal dihapus, mohon diperiksa.');
					}
				});
	    	}else{
	    		//alert('delete this row');
	    		//$(this).parents('tr').first().remove();
	    		//$(this).parent().remove()
	    		$("#datatable-sd .row-deletex").on("click",function() {
			        var tr = $(this).closest('tr');
			        tr.css("background-color","#FF3700");

			        tr.fadeOut(100, function(){
			            tr.remove();
			        });
			      return false;
			    });
	    	}


	    }
    }




</script>