<script src="<?=base_url()?>assets/vendor/plugins/table2excel/jquery.table2excel.js"></script>
<script type="text/javascript">

	function togel_child(no_unit){
		$('#child_sub_fl_'+no_unit).toggle();
	}
	function show_child(parent,periode){
		$('#sub_'+parent).nextAll('tr').each( function()
		{
			$('#sub_'+parent).toggle();
		});
		/*
		//alert(periode);
		var div_kode = $('#divisi_kode').val();
		//alert(periode);
		//alert(parent);
		if($('#tgl_head').is(":visible")){
			//alert('show');
			//$('#tgl_head').css('display','none');
		} else {
			//$('#tgl_head').css('display','block');
		}
		$('#child_'+parent).toggle();
		$('#form_child_'+parent).load('../../../rpt-acc/child/bukubesar/'+parent+'/'+periode);
		*/
	}
    function load_child(parent){
    	$('#fc_sdid').val(parent);
        $('#bobot_child_'+parent).load('../f_unit/'+parent);
    }
	jQuery(document).ready(function() {
		$('body').addClass('sb-l-m');
		
		$('#exp2excel').on('click', function(){
			$('.export2excel').table2excel({
				exclude: ".noExl",
				name: "BUKUBESAR",
				filename: "LAPORAN_BUKUBESAR_<?=trim($data['periode'])?>",
				exclude_img: true,
				exclude_links: true,
				exclude_inputs: true
			});
		});

	});
</script>