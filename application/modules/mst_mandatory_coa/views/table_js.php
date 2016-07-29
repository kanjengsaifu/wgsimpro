
<script type="text/javascript">
jQuery(document).ready(function() {
	// init component / plugin
	$('.chosen-select').chosen({
		width: '100%',
		allow_single_deselect: true
	});

	$('.chosen-select').val('').chosen().trigger('chosen:updated');
});

	function show_combo(id)
	{
	  	
	  	if($('#kdcoa_'+id).is(':visible'))
	  	{
	  		$('#kdcoa_'+id).hide();
	  	}else{
	  		$('#kdcoa_'+id).show();
	  	}

	  	if($('#cb_kdcoa_'+id).is(':visible'))
	  	{
	  		$('#cb_kdcoa_'+id).hide();
	  	}else{
	  		$('#cb_kdcoa_'+id).show();
	  	}

	  	if($('#btn_smpn_'+id).is(':visible'))
	  	{
	  		$('#btn_smpn_'+id).hide();
	  	}else{
	  		$('#btn_smpn_'+id).show();
	  	}
	  	if($('#btn_batal_'+id).is(':visible'))
	  	{
	  		$('#btn_batal_'+id).hide();
	  	}else{
	  		$('#btn_batal_'+id).show();
	  	}
	  	if($('#edit_'+id).is(':visible'))
	  	{
	  		$('#edit_'+id).hide();
	  	}else{
	  		$('#edit_'+id).show();
	  	}
	  	
	}
	function change_checked(name_id)
	{
		var ckbox = $('#'+name_id);
		$('#'+name_id).change(function () {
			if (ckbox.is(':checked')) {
	            //alert('You have Checked it');
	            $(this).val(1);
	        } else {
	            //alert('You Un-Checked it');
	            $(this).val(0);
	        }
		 });
	}
	function save_new()
	{
		var _id,_kdcoa,_sbdy,_alat,_tahap,_buktiterbit,_pajak,_bank,_nasabah = '';
		//tahap, sbdy, nasabah, fakturpajak, kdbank
		_id 			= 0;
		_kdcoa			= $('#cb_coa_new').val();
		_sbdy 			= $('#sbdy_new').val();
		//_alat			= $('#alat_new').val();
		_tahap			= $('#tahap_new').val();
		_pajak			= $('#pajak_new').val();
		_bank			= $('#bank_new').val();
		_nasabah		= $('#nasabah_new').val();
		//_buktiterbit	= $('#buktiterbit_new').val();

		$.ajax({
	       	url : "mandcoa/save", 
	       	type: "post", //form method
	       	data: {
	       			'id': _id,
	       			'kode_coa': _kdcoa, 
	       			'tahap': _tahap, 
	       			'sbdy': _sbdy, 
	       			'nasabah': _nasabah, 
	       			'pajak': _pajak,
	       			'bank': _bank
	       		},
	       	dataType:"json", 
	       	/*beforeSend:function(){
	         //lakukan apasaja sambil menunggu proses selesai disini
	         //misal tampilkan loading
	         
	         $(".loading").html("Please wait....");
	         
	       	},*/
	       	success:function(ev){
	       	//var outcome = $.parseJSON(ev);
	           //alert(ev.response+' '+ev.error_num+' '+ev.msg);
	           	if(ev.response==0){
	           		if(ev.error_num=='1062'){
	           			alert('Terjadi kesalahan!! Kode CoA tidak boleh sama/duplikat! Harap ulangi lagi');
	           		}else{
	           			alert('Terjadi kesalahan!! Harap periksa kembali inputan anda!');
	           		}
	           		window.location.reload();
	           	}else{
					alert("Data berhasil disimpan!");

	        		$('#btn_smpn_new').toggle();
	        		window.location.reload();
	           	}
	       	},
	       	fail: function(ev)
	       	{
	    		alert(ev.response);
	       	},
	       	error: function(xhr, Status, err) {
				//$.parseJSON(response);
	    		alert("Terjadi error : "+xhr.responseJSON+'-'+Status+'-'+err);
				//var data = xhr.responseJSON;
    			//console.log(data);
	       	}
		});
	}
	function combo_change(id)
	{
		var txt;
		var r = confirm("Anda merubah datanya, ingin disimpan sebagai berubahannya?");
		if (r == true) {
		    //alert('HASIL: '+$('#cb_kdcoa_'+id).find('option:selected').text());
		    //alert(txt);
		    if($('#cb_coa_'+id).val()!=''){
		    	$('#kdcoa_'+id).show();
			    $('#kdcoa_'+id).html($('#cb_kdcoa_'+id).find('option:selected').text());
			   
					$('#cb_kdcoa_'+id).hide();
					var _id,_kdcoa,_sbdy,_alat,_tahap,_buktiterbit = '';
					_id 			= id;
					_kdcoa			= $('#cb_coa_'+id).val();
					_sbdy 			= $('#sbdy_'+id).val();
					_alat			= $('#alat_'+id).val();
					_tahap			= $('#tahap_'+id).val();
					_pajak			= $('#pajak_'+id).val();
					_bank			= $('#bank_'+id).val();
					_nasabah		= $('#nasabah_'+id).val();

					$.ajax({
			           	url : "mandcoa/save", 
			           	type: "post", 
			           	data: {
			           			'id': _id,
				       			'kode_coa': _kdcoa, 
				       			'tahap': _tahap, 
				       			'sbdy': _sbdy, 
				       			'nasabah': _nasabah, 
				       			'pajak': _pajak,
				       			'bank': _bank
		           			},
		           		dataType:"json", 
		           		success:function(ev){
				       	//var outcome = $.parseJSON(ev);
				           //alert(ev.response+' '+ev.error_num+' '+ev.msg);
			           	if(ev.response==0){
			           		if(ev.error_num=='1062'){
			           			alert('Terjadi kesalahan!! Kode CoA tidak boleh sama/duplikat! Harap ulangi lagi');
			           		}else{
			           			alert('Terjadi kesalahan!! Harap periksa kembali inputan anda!');
			           		}
			           		window.location.reload();
			           	}else{
							alert("Data berhasil disimpan!");

			        		$('#btn_smpn_new').toggle();
			        		window.location.reload();
			           	}
			       	},
		           	error: function(xhr, Status, err) 
		           	{
		    			$("Terjadi error : "+xhr+'-'+Status.response+"-"+err);
		           	}
				});
		    }else{
		    	alert('Tetapkan kode COA lebih dahulu');
		    }
		}else{
			show_combo(id);
		}
	}

$(document).ready(function(){
    
    $(".btn").click(function(){
		$("#f_new").toggle();
	});

    $("cb_coa").hide();
    

    $('td').click(function(){
	   var row_index = $(this).parent().index();
	   var col_index = $(this).index();
	});
});
</script>