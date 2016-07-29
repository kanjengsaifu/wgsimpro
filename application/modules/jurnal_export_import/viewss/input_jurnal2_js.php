<script type="text/javascript">

jQuery(document).ready(function() {
	//variable
	var nEditing    = null;
    var jDebit      = 0;
    var jKredit     = 0; 
    var _Debit      = 0;
    var _Kredit     = 0; 
    var tDebit      = 0;
    var tKredit     = 0;
    var jBalance    = 0;
    var isBalance   = ''; 
    var row_index 	= 0;
    var coa_exist 	= 1;
    var nas_exist 	= 1;
    var sbdy_exist 	= 1;
    var spk_exist 	= 1;
    var tahap_exist = 1;
    var bank_exist 	= 1;
    $('#vjDebit').autoNumeric('init',{mDec:0});
    $('#vjKredit').autoNumeric('init',{mDec:0});
    $('#vjDebit').autoNumeric('set', 0);
    $('#vjKredit').autoNumeric('set', 0);
    $('#debit').autoNumeric('init',{mDec:0});
    $('#kredit').autoNumeric('init',{mDec:0});
    $('#debit').autoNumeric('set', 0);
    $('#kredit').autoNumeric('set', 0);

	$('body').addClass('sb-l-m');
	// init plugins
	$('.input-date').datetimepicker({
		minViewMode: 'months',
		pickTime: false,
		format: 'MM/YYYY'
	});
    
	$('.input-jurnal-date').datetimepicker({
		minViewMode: 'days',
		pickTime: false,
		format: 'DD/MM/YYYY'
	});

	$('#tanggal').datetimepicker({
        format: 'DD/MM/YYYY',
        startDate: '-3d'
    });

	var table = $('#datatable').DataTable({
        paging: false,
    	searching: false,
    	ordering: true,
    	//retrieve: true,
        info: false,
        scrollY: "240px",
        "columnDefs": [
        	{ 
        		className: "text-right", "targets": [11]  
        	},
        	{ 
        		className: "text-right", "targets": [12]  
        	}
		]
    });
    //table.destroy();
	var oTable = $('#datatable').dataTable();

	$('[data-toggle="tooltip"]').tooltip(); 
	$('#btn-tambah').attr('disabled', true);  
    $("#btn-tambah" ).prop( "disabled", true );
    $( "#btn-simpan" ).prop( "disabled", true );

	
	$("#kd_coa").autocomplete({
        minLength: 1,
        source:
        function(req, add){
            $.ajax({
                url: "<?=base_url()?>index.php/jurnal/lookup/coa",
                dataType: 'json',
                type: 'POST',
                data: req,
                success:
                    function(data){
                        if(data.response =='true'){
                            add(data.message);
                            coa_exist = 1;
                        }else{
                        	$('#btn-tambah').prop('disabled',true);
                        	$('#desc_coa').text('Kode Akun, tidak terdaftar!');
                        	coa_exist = 0;
                        }
                    }
            });
        },
        select: function (event, ui) {
            event.preventDefault();
            //var valu = ui.item.value;
            //alert(ui.item.value + ' => ' +ui.item.label.slice(7,50));
            $(this).val(ui.item.value);
            $('#desc_coa').text(ui.item.label.slice(8,50));
            $("#kd_nasabah").focus();
        }
    });
    $("#kd_coa").on('change',function(){
        if($(this).val()==''){
            $('#desc_coa').text('');
        }
    });

    $("#kd_nasabah").autocomplete({
        minLength: 1,
        source:
        function(req, add){
            $.ajax({
                url: "<?=base_url()?>index.php/jurnal/lookup/nasabah",
                dataType: 'json',
                type: 'POST',
                data: req,
                success:
                    function(data){
                        if(data.response =='true'){
                            add(data.message);
                            nas_exist = 1;
                        }else{
                        	$('#btn-tambah').prop('disabled',true);
                        	$('#desc_nasabah').text('Kode Nasabah, tidak terdaftar!');
                        	nas_exist = 0;
                        }
                    }
            });
        },
        select: function (event, ui) {
            event.preventDefault();
            $(this).val(ui.item.value);
            $('#desc_nasabah').text(ui.item.label.slice(7,50));
            $("#kd_sumberdaya").focus();
        }
    });
    $("#kd_nasabah").on('change',function(){
        if($(this).val()==''){
            $('#desc_nasabah').html('');
        }
    });

    $("#kd_customer").autocomplete({
        minLength: 1,
        source:
        function(req, add){
            $.ajax({
                url: "<?=base_url()?>index.php/jurnal/lookup/customer",
                dataType: 'json',
                type: 'POST',
                data: req,
                success:
                    function(data){
                        if(data.response =='true'){
                            add(data.message);
                            nas_exist = 1;
                        }else{
                            $('#btn-tambah').prop('disabled',true);
                            $('#desc_customer').text('Kode Customer, tidak terdaftar!');
                            nas_exist = 0;
                        }
                    }
            });
        },
        select: function (event, ui) {
            event.preventDefault();
            $(this).val(ui.item.value);
            $('#desc_customer').text(ui.item.label.slice(7,50));
            $("#kd_customer").focus();
        }
    });
    $("#kd_customer").on('change',function(){
        if($(this).val()==''){
            $('#desc_customer').text('');
        }
    });
    $("#kd_customer").keyup(function(e){
        //alert(coa_exist);
        if($(this).val()==''){
            $('#desc_customer').text('');
        }
    });

    $("#kd_sumberdaya").autocomplete({
        minLength: 1,
        source:
        function(req, add){
            $.ajax({
                url: "<?=base_url()?>index.php/jurnal/lookup/sbdy",
                dataType: 'json',
                type: 'POST',
                data: req,
                success:
                    function(data){
                        if(data.response =='true'){
                            add(data.message);
                            sbdy_exist = 1;
                        }else{
                        	$('#btn-tambah').prop('disabled',true);
                        	$('#desc_sumberdaya').text('Kode Sumberdaya, tidak terdaftar!');
                        	sbdy_exist = 0;
                        }
                    }
            });
        },
        select: function (event, ui) {
            event.preventDefault();
            $(this).val(ui.item.value);
            $('#desc_sumberdaya').text(ui.item.label.slice(9,50));
            $("#kd_spk").focus();
        }
    });
    $("#kd_sumberdaya").on('change',function(){
        if($(this).val()==''){
            $('#desc_sumberdaya').text('');
        }
    });
    $("#kd_sumberdaya").keyup(function(e){
        //alert(coa_exist);
        if($(this).val()==''){
            $('#desc_sumberdaya').text('');
        }
    });

    $("#kd_spk").autocomplete({
        minLength: 1,
        source:
        function(req, add){
            $.ajax({
                url: "<?=base_url()?>index.php/jurnal/lookup/spk",
                dataType: 'json',
                type: 'POST',
                data: req,
                success:
                    function(data){
                        if(data.response =='true'){
                            add(data.message);
                            spk_exist = 1;
                        }else{
                        	$('#btn-tambah').prop('disabled',true);
                        	$('#desc_spk').text('Kode SPK, tidak terdaftar!');
                        	spk_exist = 0;
                        }
                    }
            });
        },
        select: function (event, ui) {
            event.preventDefault();
            $(this).val(ui.item.value);
            $('#desc_spk').text(ui.item.label.slice(9,50));
            $("#kd_tahap").focus();
        }
    });
    $("#kd_spk").on('change',function(){
        if($(this).val()==''){
            $('#desc_spk').text('');
        }
    });
    $("#kd_spk").keyup(function(e){
        //alert(coa_exist);
        if($(this).val()==''){
            $('#desc_spk').text('');
        }
    });

    $("#kd_tahap").autocomplete({
        minLength: 1,
        source:
        function(req, add){
            $.ajax({
                url: "<?=base_url()?>index.php/jurnal/lookup/tahap",
                dataType: 'json',
                type: 'POST',
                data: req,
                success:
                    function(data){
                        if(data.response =='true'){
                            add(data.message);
                            tahap_exist = 1;
                        }else{
                        	$('#btn-tambah').prop('disabled',true);
                        	$('#desc_tahap').text('Kode Tahap, tidak terdaftar!');
                        	tahap_exist = 0;
                        }
                    }
            });
        },
        select: function (event, ui) {
            event.preventDefault();
            $(this).val(ui.item.value);
            $('#desc_tahap').text(ui.item.label.slice(7,50));
            $("#kd_bank").focus();
        }
    });
    $("#kd_tahap").on('change',function(){
        if($(this).val()==''){
            $('#desc_tahap').text('');
        }
    });
    $("#kd_tahap").keyup(function(e){
        //alert(coa_exist);
        if($(this).val()==''){
            $('#desc_tahap').text('');
        }
    });

    $("#kd_bank").autocomplete({
        minLength: 1,
        source:
        function(req, add){
            $.ajax({
                url: "<?=base_url()?>index.php/jurnal/lookup/bank",
                dataType: 'json',
                type: 'POST',
                data: req,
                success:
                    function(data){
                        if(data.response =='true'){
                            add(data.message);
                            bank_exist = 1;
                        }else{
                        	$('#btn-tambah').prop('disabled',true);
                        	$('#desc_bank').text('Kode Bank, tidak terdaftar!');
                        	bank_exist = 0;
                        }
                    }
            });
        },
        select: function (event, ui) {
            event.preventDefault();
            $(this).val(ui.item.value);
            $('#desc_bank').text(ui.item.label.slice(9,50));
            $("#no_terbit").focus();
        }
    });

    $("#kd_bank").on('change',function(){
        if($(this).val()==''){
            $('#desc_bank').text('');
        }
    });
    $("#kd_bank").keyup(function(e){
        //alert(coa_exist);
        if($(this).val()==''){
            $('#desc_bank').text('');
        }
    });
    

	$('#kd_jenis').change(function() {
        var kode = $('#kd_jenis option:selected').val();
        $( "#lbl_nobukti" ).text('......../.../.../...');
        $( "#nomor_bukti" ).val('');
        var tglSplit = $("#tanggal").val().split('/');
        var nomorbukti = $("#no_bukti").val() + "/" + tglSplit[1]+ "/" + $(this).val() + "/" +  tglSplit[2].substring(2, 4);
        if(kode == "") {
        	$('#kd_coa').attr('disabled', true);
        	$("#kd_coa").val('');
            alert('Anda belum memilih kode jenis');
        }else if($('#no_bukti').val().length < 6){
            alert('Nomor Bukti kurang dari 6 digit. Harap ulangi.');
            $('#kd_jenis option').prop('selected', function() {
                return this.defaultSelected;
            });
            $('#kd_jenis').multiselect("refresh");
            $('#no_bukti').focus();
        }else{
            $.ajax({
                type: "POST",
                url: "cekNomorBukti",
                data: {nobuk: $.trim(nomorbukti)},
                dataType: "json",
                success: function (response, textStatus) {
                    if(response.msg == 'Exist'){
                        alert('Nomor Bukti sudah ada dalam system!\nHarap masukan Nomor Bukti yang Berbeda!');
                        $('#kd_coa').attr('disabled', true).trigger("liszt:updated");
                        $('#kd_coa').attr('disabled', true).trigger("chosen:updated");
                        $('#no_bukti').val('000000');
                        $('#kd_jenis option').prop('selected', function() {
                            return this.defaultSelected;
                        });
                        $('#kd_jenis').multiselect("refresh");
                        $('#no_bukti').val('000000');
                        $('#no_bukti').focus();
                    }else{
                        if($('#no_bukti').val() < 1){
                            alert('Nomor Bukti Harus diisi dengan benar');
                            $('#kd_jenis option').prop('selected', function() {
                                return this.defaultSelected;
                            });
                            $('#kd_jenis').multiselect("refresh");
                            $('#no_bukti').focus();
                        }else{
                        	$('html, body').animate({
						        scrollTop: $("#input_form").offset().top
						    }, 700);
                            $("#lbl_nobukti").text( nomorbukti );
                            $("#nomor_bukti").val( nomorbukti );
                            $('#kd_coa').attr('disabled', false);
                            $("#kd_coa").focus(); 
                        }
                    }
                },
                error: function (xhr, textStatus, errorThrown) {
                    alert("Error: " + (errorThrown ? errorThrown : xhr.status));
                }
            });
        }
    });
	$("#potong").keydown(function(e){
		var keyCode = e.keyCode || e.which; 
		if(keyCode == 13){
			$('#debit').focus();
		}
	});
	//$("#no_bukti").toUpperCase());
	$("#no_bukti").keydown(function(event) {
		
		if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 ) {
			$(this).val().toUpperCase()
		}
		else {
			if (event.keyCode < 48 || event.keyCode > 57 && event.charChode) {
				event.preventDefault();	
				$(this).val().toUpperCase()
			}	
		}
	});
	$("#kd_coa").keydown(function(event) {
		if ( event.keyCode == 46 || event.keyCode == 8 ) {
		}
		else {
			if (event.keyCode < 48 || event.keyCode > 57 ) {
				event.preventDefault();	
			}	
		}
		$('#btn-tambah').attr('disabled', false);  
        $("#btn-tambah" ).prop( "disabled", false );
	});
	$("#kd_coa").keyup(function(e){
		//alert(coa_exist);
		if(coa_exist==0){
			$("#btn-tambah").prop( "disabled", true );	
		}

	});
    $("#kd_nasabah").keyup(function(e){
        //alert(coa_exist);
        if($(this).val()==''){
            $('#desc_nasabah').text('');
        }
    });

	$("#debit").keydown(function(event) {
		$(this).dblclick();
		if(coa_exist==0){
			$("#btn-tambah").prop( "disabled", true );	
		}
		if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9) {
		}
		else {
			if (event.keyCode < 48 || event.keyCode > 57 ) {
				event.preventDefault();	
			}	
		}
	});
	$("#kredit").keydown(function(event) {
		$(this).dblclick();
		if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 ) {
		}
		else {
			if (event.keyCode < 48 || event.keyCode > 57 ) {
				event.preventDefault();	
			}	
		}
	});
    function createCookie(name,value,days) {
        if (days) {
            var date = new Date();
            date.setTime(date.getTime()+(days*24*60*60*1000));
            var expires = "; expires="+date.toGMTString();
        }
        else var expires = "";
        document.cookie = name+"="+value+expires+"; path=/";
    }

	function getCookie(cname) {
	    var name = cname + "=";
	    var ca = document.cookie.split(';');
	    for(var i=0; i<ca.length; i++) {
	        var c = ca[i];
	        while (c.charAt(0)==' ') c = c.substring(1);
	        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
	    }
	    return "";
	}
	//alert(getCookie('is_edit_nobukti'));
	var is_edit = getCookie('is_edit_nobukti');
    var is_tgl = getCookie("is_edit_tanggal");
	var is_mode = getCookie('is_mode');
    //alert(is_edit+'\n\n'+is_mode);
	//if(is_edit!=='' && is_mode!==''){
    if($('#is_mode').val()=='edit'){
		var dnobuk = is_edit.split('/');
		var _nomor_bk = dnobuk[0]+'/'+dnobuk[1]+'/'+dnobuk[2]+'/'+dnobuk[3]+'/';
        var cookTanggal = is_tgl.replace('-','/').replace('-','/');
		$('#is_mode').val('edit');
		$('#no_bukti').val(dnobuk[0]);
        $('#tanggal').val(cookTanggal);
		$('#nomor_bukti').val(is_edit);
		$('#lbl_nobukti').text(is_edit);
		$('#kd_jenis').val(dnobuk[2]);
        $('#tanggal').attr('disabled', true);
        $('#no_bukti').attr('disabled', true);
        $('#kd_jenis').attr('disabled', true);

		$('html, body').animate({
	        scrollTop: $("#input_form").offset().top
	    }, 700);
	    $('#desc_coa').focus();

	    $.getJSON( "<?=base_url()?>"+"index.php/jurnal/json_nobuk", function( data ) {
			var items = [];
		  	$.each( data, function( key, val ) {
		  		//alert(key + ': '+val);
		  		console.log(val['kd_coa']);
		  		table.row.add([
			       val['kd_coa'],
			       val['kd_nasabah'],
                   val['kd_customer'],
			       val['kd_sumberdaya'],
			       val['kd_spk'],
			       val['kd_tahap'],
			       val['kd_bank'],
			       val['nomor_terbit'],
			       val['faktur_pajak'],
			       val['no_invoice'],
			       val['bukti_potong'],
			       val['debit'],
			       val['kredit'],
			       //val['vdebit'],
			       //val['vkredit'],
			       val['vol'],
			       val['keterangan'],
			       val['aksi']
			    ]).draw().node();
		  	});
		  	sum_debitkredit();
		  	//aktifkan tbl tambah
		  	$('#btn-tambah').prop('disabled', false);
		});
	}else{
		//alert('Data has been destroyed. Please back and try again!');
		$('#is_mode').val('new');
	}
    
    if($('#is_mode').val()=='new'){
        $('#tanggal').attr('disabled', false);
        $('#no_bukti').attr('disabled', false);
        $('#kd_jenis').attr('disabled', false);
        $('#kd_jenis option').prop('selected', function() {
            return this.defaultSelected;
        });
        $('#no_bukti').val('');
    }else{
        $('#tanggal').attr('disabled', true);
        $('#no_bukti').attr('disabled', true);
        $('#kd_jenis').attr('disabled', true);
    }
	function sum_debitkredit(){
		/*var dTotal = 0;
	  	var kTotal = 0;
	    $('.jDebit').each(function (index, element) {
	        dTotal = dTotal + parseFloat($(element).val());
	    });
	    $('.jKredit').each(function (index, element) {
	        kTotal = kTotal + parseFloat($(element).val());
	    });
	    $('#vjDebit').text(dTotal);
	    $('#vjKredit').text(kTotal);*/

	    var tDebit = 0;
	    $('.jDebit').each(function (index, element) {
	    	//$(element).autoNumeric('init');
	        //tDebit = tDebit + parseFloat( $(element).val( $(element).autoNumeric('get') ) );
	        tDebit = tDebit + parseFloat( $(element).val() );
	    });
	    //alert(tDebit);

	    var tKredit = 0;
	    $('.jKredit').each(function (index, element) {
	    	//$(element).autoNumeric('init');
	        //tKredit = tKredit + parseFloat( $(element).val( $(element).autoNumeric('get') ) );
	        tKredit = tKredit + parseFloat( $(element).val() );
	    });

	    var rpBal =0;
	    if(tDebit > tKredit){
	    	isBalance = 'D>K';
	    	rpBal = tDebit-tKredit;
	    	$('#btn-simpan').prop('disabled',true);
	    }else if(tDebit < tKredit){
	    	isBalance = 'D<K';
	    	rpBal = tDebit-tKredit;
	    	$('#btn-simpan').prop('disabled',true);
	    }else{
	    	isBalance = 'BAL';
	    	rpBal = tDebit-tKredit;
	    	$('#btn-simpan').prop('disabled',false);
	    }

	    $('#vjDebit').text(tDebit);
		$('#vjKredit').text(tKredit);
		$('#vjDebit').autoNumeric('set',tDebit);
		$('#vjKredit').autoNumeric('set',tKredit);
	}

    $('#btn-cancel').on('click',function(){
        if($('#is_mode').val()=='edit'){
            createCookie('is_mode','',-1);
            createCookie('is_edit_nobukti','',-1);
            createCookie('is_edit_tanggal','',-1);
            window.location.assign('<?=base_url()?>index.php/jurnal/view');
        }else{
            resetBoks();    
        }
        
    });

    $('#btn-cetak-vcr').on('click',function(){
        if($('#no_bukti').val()==''){
            alert('Nomor belum terisi. Harap lengkapi.');
        }else{
            if($('#is_mode').val()=='new'){
                if(confirm('PERHATIAN !!\nAnda akan mencetak Voucher untuk jurnal berikut. Namun Jurnal yang anda buat BELUM TERSIMPAN kedalam sistem !!!\n'
                        +'Harap SEGERA SIMPAN setelah Voucher ini dicetak.\n\n'
                        +'Ingin tetap mencetak?               (Ok=Cetak, Cancel=Batal)')){
                    $('#form-input').attr('action', '<?=base_url()?>index.php/jurnal-entry/voucher/print');
                    var form=$("#form-input");
                    $.ajax({
                        type:"POST",
                        url: '<?=base_url()?>index.php/jurnal/voucher/print',
                        data: form.serialize(),
                        success: function(res){
                            //console.log(res);  
                            //alert(res);
                            if(res.msg === 'Success'){
                                //alert('Jurnal tersimpan!');
                                //generate pdf voucher disini
                                //$.post( '<?=base_url()?>index.php/jurnal/voucher-print', 
                                    //{ head: res.head, data: res.data },function(data){
                                        $('#print-vcr').attr('action', '<?=base_url()?>index.php/jurnal/voucher-print/'+res.no_voucher);
                                        $('#print-vcr').submit();
                                //});

                            } else {
                                alert('Ada Kesalahan! Harap Periksa kembali.')
                            }
                        }
                    });
                } 
            }else{

            }
        }
        
    });

    $('#btn-simpan').on('click',function() {

        $('#form-input').attr('action', "simpan");
        var form=$("#form-input");
        if($( '#no_bukti' ).val()=='000000' || $( '#no_bukti' ).val()==' ' || $( '#no_bukti' ).val()=='')
        {
            alert('Nomor bukti belum di isi. Harap diisi lebih dahulu!');
        }else{
            $.ajax({
                type:"POST",
                url: form.attr("action"),
                data: form.serialize(),
                success: function(res){
                    console.log(res);  
                    //alert(res);
                    if(res.msg === 'Success'){
                        alert('Jurnal tersimpan!') 
                        table
                            .clear()
                            .draw(); 
	                        //disable apa aja disini ??
	                        $('#kd_jenis').val('');
	                        $('#no_bukti').val('000000');
	                        $('#lbl_nobukti').val('');
	                        $('#nomor_bukti').val('');
	                        $('#faktur_pajak').val('');
	                        $('#no_terbit').val('');
	                        $('#noinvoice').val('');
	                        $('#bukti_potong').val('');
	                        $('#no_terbit').val('');
	                        $('#btn-simpan').prop( "disabled", true );
	                        $('#btn-tambah').prop( "disabled", true );
	                        $('#vjDebit').text('0');
	                        $('#vjKredit').text('0');
                            $('#kd_jenis option:selected').val('');
                    } else {
                        alert('Ada Kesalahan! Harap Periksa kembali.')
                    }
                }
            }); 
        } 	
	});

	$('#btn-tambah').on( 'click', function () {
		
		if(coa_exist==0){
			alert('Maaf, kode akun yang anda masukan salah! Harap dipastikan dengan benar.');
		}else if(nas_exist==0){
			alert('Maaf, kode Nasabah yang anda masukan salah! Harap dipastikan dengan benar.');
		}else if(sbdy_exist==0){
			alert('Maaf, kode Sumberdaya yang anda masukan salah! Harap dipastikan dengan benar.');
		}else if(spk_exist==0){
			alert('Maaf, kode SPK yang anda masukan salah! Harap dipastikan dengan benar.');
		}else if(tahap_exist==0){
			alert('Maaf, kode Tahap yang anda masukan salah! Harap dipastikan dengan benar.');
		}else if(bank_exist==0){
			alert('Maaf, kode Bank yang anda masukan salah! Harap dipastikan dengan benar.');
		}else if($('#debit').val() > 0 && $('#kredit').val() > 0){
            alert('Kolom Debit/Kredit tidak boleh terisi angka bersamaan!');
        }else{
	        if($( '#no_bukti' ).val()=='000000' || $( '#no_bukti' ).val()==' ' || $( '#no_bukti' ).val()=='')
	        {
	            alert('Nomor bukti belum di isi. Harap diisi lebih dahulu!');
	        }else{
	            if($('#btn-tambah').html()=='Ubah'){
	                //var dt_idx = table.row( this ).index();
	                var coa         = $('#kd_coa').val();
	                var nasabah     = $('#kd_nasabah').val();
                    var customer    = $('#kd_customer').val();
	                var sbdy        = $('#kd_sumberdaya').val();
	                var spk         = $('#kd_spk').val();
	                var tahap       = $('#kd_tahap').val(); 
	                var bank        = $('#kd_bank').val(); 
	                var terbit      = $('#no_terbit').val();  
	                var faktur      = $('#kd_faktur').val();  
	                var invoice     = $('#invoice').val(); 
	                var debit       = $('#debit').val();  
	                var kredit      = $('#kredit').val(); 
	                var volume      = $('#volume').val(); 
	                var bkpotong    = $('#potong').val();
	                var uraian      = $('#uraian').val();
	                
	                //console.log( kd_coa );
	                console.log( 'debit: '+debit );
	                console.log( 'kredit: '+kredit );
	                
	                //idx_row = row_index;
	                //console.log( row_index );
	                //console.log( row_index ); 

	                var cbo_coa         = $('#req_coa').text();
	                var cbo_nasabah     = $('#req_nasabah').text();
	                var cbo_sumberdaya  = $('#req_sbdy').text();
	                var cbo_spk         = $('#req_spk').text();
	                var cbo_tahap       = $('#req_tahap').text();
	                var cbo_bank        = $('#req_bank').text();

	                var vcbo_coa        = $('#kd_coa').val();
	                var vcbo_nasabah    = $('#kd_nasabah').val();
	                var vcbo_sumberdaya = $('#kd_sumberdaya').val();
	                var vcbo_spk        = $('#kd_spk').val();
	                var vcbo_tahap      = $('#kd_tahap').val();
	                var vcbo_bank       = $('#kd_bank').val();

	                if(cbo_coa=='*' && (coa==undefined || vcbo_coa == '') ){
	                    alert('Kode Coa Wajib diisi');
	                }else if(cbo_nasabah=='*' && (nasabah==undefined || vcbo_nasabah == '')){
	                    alert('Kode Nasabah Wajib diisi');
	                }else if(cbo_sumberdaya=='*' && (sumberdaya==undefined || vcbo_sumberdaya == '')){
	                    alert('Kode Sumberdaya Wajib diisi');
	                }else if(cbo_spk=='*' && (spk==undefined || vcbo_spk == '')){
	                    alert('Kode SPK Wajib diisi');
	                }else if(cbo_tahap=='*' && (tahap==undefined || vcbo_tahap == '')){
	                    alert('Kode Tahap Wajib diisi');
	                }else if(cbo_bank=='*' && (bank==undefined || vcbo_bank == '')){
	                    alert('Kode Bank Wajib diisi');
	                }else if(uraian==''||uraian==' '){
	                    alert('Keterangan/Uraian transaksi tidak boleh kosong');
	                }else{
	                    if(faktur==''){ faktur='';}if(invoice==''){ invoice='';}if(bkpotong==''){ bkpotong='';} 
	                    if(debit==''){ bkpotong='';}if(kredit==''){ bkpotong='';}if(volume==''){ volume='';}

	                    //update
	                    _fnUpdate(row_index);

	                    //jumlahkan 
	                    sum_debitkredit();

	                    //reset
	                    //resetBoks();

	                    $('#btn-tambah').html('Tambah');
	                    $('#is_edit_row').val(0);
	                    row_index = '';
	                }
	            }else{
	            	//var vD = $('#vjDebit').text($("#debit").val());
	            	//alert('bodong');

	                
	                _Debit = $('#debit').val();
	                _Kredit = $('#kredit').val();

	                if(_Debit=='' || _Debit == NaN){
	                	alert('Kolom Debit tidak boleh kosong/dibawah nol');
	                }else if(_Kredit=='' || _Kredit == NaN){
	                	alert('Kolom Kredit tidak boleh kosong/dibawah nol');
	                }else{
	                	//tambah
	                	fnClickAddRow();

	                	//jumlah debit & kredit
	                	sum_debitkredit();

					    //console.log('DEBIT: '+tDebit+'\nKREDIT: '+tKredit+'\nSTATUS: '+isBalance+'\nBALANCE: '+rpBal);

					    //reset
	                	//resetBoks();
	                	//$('#no_bukti').focus();
	                	//$('#lbl_nobukti').text('....../.../.../...');
	                	//$('#nomor_bukti').val('');
	                	//$('#lbl_jenis').text('');
	                }
		                
		        	//alert('debit=enabled');
		            //$( rowNode ).css( 'color', 'red' ).animate( { color: 'blue' } );
		            
		           	//$('#vjDebit').text(tDebit);
		         	//$('#vjKredit').text(tKredit);
	            }
	        	
	        	//resetBoks();
	        }
	 	}
    });

	$('#kd_coa').change(function(e){
		$('#btn-tambah').attr('disabled', false);  
        $("#btn-tambah" ).prop( "disabled", false );
        //$('#debit').attr('disabled', true);
        //$('#kredit').attr('disabled', true);
        $.ajax({
            type: "POST",
            url: "<?=base_url()?>index.php/jurnal/ismandatory/"+$('#kd_coa').val(),
            dataType: "json",
            success: function (data, textStatus) {
                var tahap = data.mand_tahap;
                var nasabah = data.mand_nasabah;
                var pajak = data.mand_pajak;
                var sbdy = data.mand_sbd;
                var bank = data.mand_bank; 

                if(tahap==1){
                    $('#req_tahap').text('*');
                    $('#kd_tahap').addClass('required');
                    $('#r_tahap').css('color','red');
                }else{
                    $('#req_tahap').text('');
                    $('#kd_tahap').removeClass('required');
                    $('#r_tahap').css('color','');
                }
                if(nasabah==1){
                    $('#req_nasabah').text('*');
                    $('#kd_nasabah').addClass('required');
                    $('#r_nasabah').css('color','red');
                }else{
                    $('#req_nasabah').text('');
                    $('#kd_nasabah').removeClass('required');
                    $('#r_nasabah').css('color','');
                }
                if(pajak==1){
                    $('#req_faktur').text('*');
                    $('#kd_faktur').addClass('required');
                    $('#r_faktur').css('color','red');
                }else{
                    $('#req_pajak').text('');
                    $('#kd_faktur').removeClass('required');
                    $('#r_faktur').css('color','');
                }
                if(sbdy==1){
                    $('#req_sbdy').text('*');
                    $('#kd_sumberdaya').addClass('required');
                    $('#r_sbdy').css('color','red');
                }else{
                    $('#req_sbdy').text('');
                    $('#kd_sumberdaya').removeClass('required');
                    $('#r_sbdy').css('color','');
                }
                if(bank==1){
                    $('#req_bank').text('*');
                    $('#kd_bank').addClass('required');
                    $('#r_bank').css('color','red');
                }else{
                    $('#req_bank').text('');
                    $('#kd_bank').removeClass('required');
                    $('#r_bank').css('color','');
                }
                $('#btn-tambah').attr('disabled', false);  
                $("#btn-tambah" ).prop( "disabled", false );
            },
            error: function (xhr, textStatus, errorThrown) {
                alert("Error: " + (errorThrown ? errorThrown : xhr.status));
            }
        });
    });
	
    $('body').on( 'click', '.row-delete', function () {
    	var idx = table.row( this ).index();
    	//alert(idx);
    	if(confirm('Anda yakin ingin menghapus data ini?')) {
    		table
            .row( $(this).parents('tr'))
            .remove()
            .draw();

            sum_debitkredit();
    	}  	
	});

	$('#datatable tbody').on('click', 'a.row-edit', function () {
    	//alert('edit');
    	//if(confirm('Anda yakin ingin menghapus data ini?')) {
    		 
    		var idx = table.row( $(this).parents('tr') ).index();
        	alert(idx);
        	//alert( data[0].value +"'s salary is: "+ data[ 5 ] );
  			//alert('Row # '+(row_index)+' \nColumn # '+(col_index));
  			var kd_coa          = $('input[name="kode_coa[]"]').get(idx).value;
	        var kd_nasabah      = $('input[name="kode_nasabah[]"]').get(idx).value;
            var kd_customer     = $('input[name="kode_customer[]"]').get(idx).value;
	        var kd_sbdy         = $('input[name="kode_sumberdaya[]"]').get(idx).value;
	        var kd_spk          = $('input[name="kode_spk[]"]').get(idx).value;
	        var kd_tahap        = $('input[name="kode_tahap[]"]').get(idx).value;
	        var kd_bank         = $('input[name="kode_bank[]"]').get(idx).value;
	        var no_terbit       = $('input[name="nomor_terbit[]"]').get(idx).value;
	        var kd_faktur       = $('input[name="kode_faktur[]"]').get(idx).value;
	        var no_invoice      = $('input[name="no_invoice[]"]').get(idx).value;
	        var bkt_potong      = $('input[name="bukti_potong[]"]').get(idx).value;
	        var f_debit         = $('input[name="f_debit[]"]').get(idx).value;
	        var f_kredit        = $('input[name="f_kredit[]"]').get(idx).value;
	        var f_volume        = $('input[name="f_volume[]"]').get(idx).value;
	        var f_uraian        = $('input[name="f_keterangan[]"]').get(idx).value;
	        
	        var l_coa          	= $('input[name="l_coa[]"]').get(idx).value;
	        var l_nas      		= $('input[name="l_nas[]"]').get(idx).value;
            var l_cus           = $('input[name="l_cus[]"]').get(idx).value;
	        var l_sby         	= $('input[name="l_sby[]"]').get(idx).value;
	        var l_spk          	= $('input[name="l_spk[]"]').get(idx).value;
	        var l_thp        	= $('input[name="l_thp[]"]').get(idx).value;
	        var l_bnk         	= $('input[name="l_bnk[]"]').get(idx).value;

            //alert(l_coa+'\n'+l_nas+'\n'+l_cus+'\n'+l_sby+'\n'+l_spk+'\n'+l_thp+'\n'+l_bnk)
	        $('#kd_coa').val(kd_coa);
	        $('#kd_nasabah').val(kd_nasabah);
            $('#kd_customer').val(kd_customer);
	        $('#kd_sumberdaya').val(kd_sbdy);
	        $('#kd_spk').val(kd_spk);
	        $('#kd_tahap').val(kd_tahap);
	        $('#kd_bank').val(kd_bank);
	        $('#no_terbit').val(no_terbit);
	        $('#kd_faktur').val(kd_faktur);
	        $('#invoice').val(no_invoice);
	        $('#potong').val(bkt_potong);
	        $('#debit').val(f_debit);
	        $('#kredit').val(f_kredit);
	        $('#volume').val(f_volume);
	        $('#uraian').val(f_uraian);
	        
            $('#l_coa').val(l_coa);
            $('#l_nas').val(l_nas);
            $('#l_cus').val(l_cus);
            $('#l_sby').val(l_sby);
            $('#l_spk').val(l_spk);
            $('#l_thp').val(l_thp);
            $('#l_bnk').val(l_bnk);

	        $('#desc_coa').text(l_coa);
	        $('#desc_nasabah').text(l_nas);
            $('#desc_customer').text(l_cus);
	        $('#desc_sumberdaya').text(l_sby);
	        $('#desc_spk').text(l_spk);
	        $('#desc_tahap').text(l_thp);
	        $('#desc_bank').text(l_bnk);

	        idx_row = idx;
	        row_index = idx;
	        //console.log( row_index );
	        //console.log( row_index );

	        $('#is_edit_row').val(1);

	        if($('#is_edit_row').val()==1){
	            $('#btn-tambah').html('Ubah');
	            $('#btn-tambah').prop( "disabled", false );
	        }else{
	            $('#btn-tambah').html('Tambah');
	        }

	        if ( $(this).hasClass('selected') ) {
	            $(this).removeClass('selected');
	        }
	        else {
	            table.$('tr.selected').removeClass('selected');
	            $(this).addClass('selected');
	        }
    	//}   	
        sum_debitkredit();
	});
	
	$('#datatable tbody').on('click', 'a.row-duplicate', function () {
    	
    	if(confirm('Baris data berikut akan diduplikasikan ?')) {
    		
    		var idx = table.row( $(this).parents('tr') ).index();
        	alert(idx);
  			var kd_coa          = $('input[name="kode_coa[]"]').get(idx).value;
	        var kd_nasabah      = $('input[name="kode_nasabah[]"]').get(idx).value;
            var kd_customer     = $('input[name="kode_customer[]"]').get(idx).value;
	        var kd_sbdy         = $('input[name="kode_sumberdaya[]"]').get(idx).value;
	        var kd_spk          = $('input[name="kode_spk[]"]').get(idx).value;
	        var kd_tahap        = $('input[name="kode_tahap[]"]').get(idx).value;
	        var kd_bank         = $('input[name="kode_bank[]"]').get(idx).value;
	        var no_terbit       = $('input[name="nomor_terbit[]"]').get(idx).value;
	        var kd_faktur       = $('input[name="kode_faktur[]"]').get(idx).value;
	        var no_invoice      = $('input[name="no_invoice[]"]').get(idx).value;
	        var bkt_potong      = $('input[name="bukti_potong[]"]').get(idx).value;
	        var f_debit         = $('input[name="f_debit[]"]').get(idx).value;
	        var f_kredit        = $('input[name="f_kredit[]"]').get(idx).value;
	        var f_volume        = $('input[name="f_volume[]"]').get(idx).value;
	        var f_uraian        = $('input[name="f_keterangan[]"]').get(idx).value;
	        
	        var l_coa          	= $('input[name="l_coa[]"]').get(idx).value;
            var l_nas           = $('input[name="l_nas[]"]').get(idx).value;
            var l_cus           = $('input[name="l_cus[]"]').get(idx).value;
	        var l_sby         	= $('input[name="l_sby[]"]').get(idx).value;
	        var l_spk          	= $('input[name="l_spk[]"]').get(idx).value;
	        var l_thp        	= $('input[name="l_thp[]"]').get(idx).value;
	        var l_bnk         	= $('input[name="l_bnk[]"]').get(idx).value;

	        $('#kd_coa').val(kd_coa);
	        $('#kd_nasabah').val(kd_nasabah);
            $('#kd_customer').val(kd_customer);
	        $('#kd_sumberdaya').val(kd_sbdy);
	        $('#kd_spk').val(kd_spk);
	        $('#kd_tahap').val(kd_tahap);
	        $('#kd_bank').val(kd_bank);
	        $('#no_terbit').val(no_terbit);
	        $('#kd_faktur').val(kd_faktur);
	        $('#invoice').val(no_invoice);
	        $('#potong').val(bkt_potong);
	        $('#debit').val(f_debit);
	        $('#kredit').val(f_kredit);
	        $('#volume').val(f_volume);
	        $('#uraian').val(f_uraian);
	        

            $('#l_coa').val(l_coa);
            $('#l_nas').val(l_nas);
            $('#l_cus').val(l_cus);
            $('#l_sby').val(l_sby);
            $('#l_spk').val(l_spk);
            $('#l_thp').val(l_thp);
            $('#l_bnk').val(l_bnk);

	        $('#desc_coa').text(l_coa);
	        $('#desc_nasabah').text(l_nas);
            $('#desc_customer').text(l_cus);
	        $('#desc_sumberdaya').text(l_sby);
	        $('#desc_spk').text(l_spk);
	        $('#desc_tahap').text(l_thp);
	        $('#desc_bank').text(l_bnk);

	        idx_row = idx;
	        row_index = idx;
	        //console.log( row_index );
	        //console.log( row_index );

	        
            
            $('#is_edit_row').val(0);

            if($('#is_edit_row').val()==1){
                $('#btn-tambah').html('Ubah');
                $('#btn-tambah').prop( "disabled", false );
            }else{
                $('#btn-tambah').html('Tambah');
            }
            

	        if ( $(this).hasClass('selected') ) {
	            $(this).removeClass('selected');
	        }
	        else {
	            table.$('tr.selected').removeClass('selected');
	            $(this).addClass('selected');
	        }
	        $('#btn-tambah').prop('disabled', false);
    	   
           sum_debitkredit();
        }   	
	});
	
	$('#kd_jenis').multiselect({
        buttonClass: 'dropdown-toggle btn btn-sm btn-primary btn-block'
    });
		
/*	
	$('#datatable tbody').on('click',"input[name$='delete']",function() {
        console.log(table.row($(this).parents('tr')));

	    $('#is_edit_row').val(0);
        $('#btn-tambah').html('Tambah');

	    var tDebit = 0;
	    $('.jDebit').each(function (index, element) {
	        tDebit = tDebit + parseInt($(element).val());
	    });
	    //alert(tDebit);

	    var tKredit = 0;
	    $('.jKredit').each(function (index, element) {
	        tKredit = tKredit + parseInt($(element).val());
	    });
	    var rpBal =0;
	    if(tDebit > tKredit){
	    	isBalance = 'D>K';
	    	rpBal = tDebit-tKredit;
	    }else if(tDebit < tKredit){
	    	isBalance = 'D<K';
	    	rpBal = tDebit-tKredit;
	    }else{
	    	isBalance = 'BAL';
	    	rpBal = tDebit-tKredit;
	    }
	    console.log('DEBIT: '+tDebit+'\nKREDIT: '+tKredit+'\nSTATUS: '+isBalance+'\nBALANCE: '+rpBal);

        table
            .row( $(this).parents('tr'))
            .remove()
            .draw();
            if($('#is_edit_row').val()==1){
            	$('#is_edit_row').val(0);
        		$('#btn-tambah').html('Tambah');
            }
            
		    //alert(tKredit);
		    console.log('DEBIT: '+tDebit+'\nKREDIT:'+tKredit);
		$('#is_edit_row').val(0);
        $('#btn-tambah').html('Tambah');
        $('#is_edit_row').val(0);
        $('#btn-tambah').html('Tambah');
    });
*/
	//Proses Update row data
	function _fnUpdate(idx)
    {
        console.log( 'fnUpdate -->START' );
        var debit = $('#debit').val();
        var kredit = $('#kredit').val();
        var rpl_debit = debit.replace('.00','');
        var rpl_kredit = kredit.replace('.00','');

        var l_coa = '<input type="hidden" name="l_coa[]" id="l_coa[]" value="'+$('#desc_coa').text()+'"/>';
        var l_nas = '<input type="hidden" name="l_nas[]" id="l_nas[]" value="'+$('#desc_nasabah').text()+'"/>';
        var l_cus = '<input type="hidden" name="l_cus[]" id="l_cus[]" value="'+$('#desc_customer').text()+'"/>';
        var l_sby = '<input type="hidden" name="l_sby[]" id="l_sby[]" value="'+$('#desc_sumberdaya').text()+'"/>';
        var l_spk = '<input type="hidden" name="l_spk[]" id="l_spk[]" value="'+$('#desc_spk').text()+'"/>';
        var l_thp = '<input type="hidden" name="l_thp[]" id="l_thp[]" value="'+$('#desc_tahap').text()+'"/>';
        var l_bnk = '<input type="hidden" name="l_bnk[]" id="l_bnk[]" value="'+$('#desc_bank').text()+'"/>';

        var coa 		= $('#kd_coa').val()+l_coa+ '<input type="hidden" name="no_bukti[]" id="no_bukti[]" value="'+$('#no_bukti').val()+'"/><input type="hidden" name="kode_coa[]" id="kode_coa[]" value="'+$('#kd_coa').val()+'"/>';
        var nasabah     = $('#kd_nasabah').val()+l_nas+ '<input type="hidden" name="kode_nasabah[]" id="kode_nasabah[]" value="'+$('#kd_nasabah').val()+'"/>';
        var customer    = $('#kd_customer').val()+l_cus+ '<input type="hidden" name="kode_customer[]" id="kode_customer[]" value="'+$('#kd_customer').val()+'"/>';
        var sbdy 		= $('#kd_sumberdaya').val()+l_sby+ '<input type="hidden" name="kode_sumberdaya[]" id="kode_sumberdaya[]" value="'+$('#kd_sumberdaya').val()+'"/>';
        var spk 		= $('#kd_spk').val()+l_spk+ '<input type="hidden" name="kode_spk[]" id="kode_spk[]" value="'+$('#kd_spk').val()+'"/>';
        var tahap 		= $('#kd_tahap').val()+l_thp+ '<input type="hidden" name="kode_tahap[]" id="kode_tahap[]" value="'+$('#kd_tahap').val()+'"/>';
        var bank 		= $('#kd_bank').val()+ l_bnk+'<input type="hidden" name="kode_bank[]" id="kode_bank[]" value="'+$('#kd_bank').val()+'"/>';
        var terbit 		= $('#no_terbit').val()+ '<input type="hidden" name="nomor_terbit[]" id="nomor_terbit[]" value="'+$('#no_terbit').val()+'"/>';
        var faktur 		= $('#kd_faktur').val()+ '<input type="hidden" name="kode_faktur[]" id="kode_faktur[]" value="'+$('#kd_faktur').val()+'"/>';
        var invoice 	= $('#invoice').val()+ '<input type="hidden" name="no_invoice[]" id="no_invoice[]" value="'+$('#invoice').val()+'"/>';
        var bkpotong 	= $('#potong').val()+ '<input type="hidden" name="bukti_potong[]" id="bukti_potong[]" value="'+$('#potong').val()+'"/>';
        var debit 		= $('#debit').val()+ '<input type="hidden" name="f_debit[]" id="f_debit[]" class="jDebit text-right" value="'+$('#debit').autoNumeric('get')+'"/>';
        var kredit 		= $('#kredit').val()+ '<input type="hidden" name="f_kredit[]" id="f_kredit[]" class="jKredit text-right" value="'+$('#kredit').autoNumeric('get')+'"/>';
        //var vdebit 		= $('#debit').val();
        //var vkredit 	= $('#kredit').val();
        var volume 		= $('#volume').val()+ '<input type="hidden" name="f_volume[]" id="f_volume[]" value="'+$('#volume').val()+'"/>';
        var t_uraian 	= $('#uraian').val()+ '<input type="hidden" name="f_keterangan[]" id="f_keterangan[]" value="'+$('#uraian').val()+'"/>';
        var aksi   		= '<a href="#" class="row-edit" data-toggle="tooltip" title="Edit data"><span class="glyphicons glyphicons-edit"></span></a>&nbsp;&nbsp;&nbsp;'+
                          '<a href="#" class="row-delete" data-toggle="tooltip" title="Delete data"><span class="glyphicons glyphicons-bin"></span></a>&nbsp;&nbsp;&nbsp;'+
                          '<a href="#" class="row-duplicate" data-toggle="tooltip" title="Duplicate this data"><span class="glyphicons glyphicons-playing_dices"></span></a> ';
        

        oTable.fnUpdate([coa,nasabah,customer,sbdy,spk,tahap,bank,terbit,faktur,invoice,bkpotong,debit,kredit,volume,t_uraian,aksi], idx);
        
        console.log( 'fnUpdate -->DONE' );

        var tDebit = 0;
	    $('.jDebit').each(function (index, element) {
	        tDebit = tDebit + parseInt($(element).val());
	    });
	    //alert(tDebit);

	    var tKredit = 0;
	    $('.jKredit').each(function (index, element) {
	        tKredit = tKredit + parseInt($(element).val());
	    });
	    var rpBal =0;
	    if(tDebit > tKredit){
	    	isBalance = 'D>K';
	    	rpBal = tDebit-tKredit;
	    }else if(tDebit < tKredit){
	    	isBalance = 'D<K';
	    	rpBal = tDebit-tKredit;
	    }else{
	    	isBalance = 'BAL';
	    	rpBal = tDebit-tKredit;
	    }
	    $('#vjDebit').text(tDebit);
		$('#vjKredit').text(tKredit);

        $('#is_edit_row').val(0);
        $('#btn-tambah').html('Tambah');

        //bersihkan box
        resetBoks();
    }

    function hitungDK(){
        var tDebit = 0;
        $('.jDebit').each(function (index, element) {
            tDebit = tDebit + parseInt($(element).val());
        });
        //alert(tDebit);

        var tKredit = 0;
        $('.jKredit').each(function (index, element) {
            tKredit = tKredit + parseInt($(element).val());
        });
        var rpBal =0;
        if(tDebit > tKredit){
            isBalance = 'D>K';
            rpBal = tDebit-tKredit;
        }else if(tDebit < tKredit){
            isBalance = 'D<K';
            rpBal = tDebit-tKredit;
        }else{
            isBalance = 'BAL';
            rpBal = tDebit-tKredit;
        }
        $('#vjDebit').text(tDebit);
        $('#vjKredit').text(tKredit);
    }

	//Proses Tambah Data ke Row
	function fnClickAddRow() 
    {
        var coa             = $('#kd_coa').val();
        var nasabah         = $('#kd_nasabah').val();
        var customer        = $('#kd_customer').val();
        var sumberdaya      = $('#kd_sumberdaya').val();
        var spk             = $('#kd_spk').val();
        var tahap           = $('#kd_tahap').val(); 
        var bank            = $('#kd_bank').val(); 
        var nomor_terbit    = $('#no_terbit').val();  
        var faktur_pajak    = $('#kd_faktur').val();  
        var no_invoice      = $('#invoice').val(); 
        var debit           = $('#debit').val();  
        var kredit          = $('#kredit').val(); 
        var vdebit           = $('#debit').val();  
        var vkredit          = $('#kredit').val(); 
        var volume          = $('#volume').val(); 
        var bukti_potong    = $('#potong').val();
        var keterangan      = $('#uraian').val().toUpperCase();
        var aksi            = '';

        var req_coa         = $('#req_coa').text();
        var req_nasabah     = $('#req_nasabah').text();
        var req_customer    = $('#req_customer').text();
        var req_sumberdaya  = $('#req_sbdy').text();
        var req_spk         = $('#req_spk').text();
        var req_tahap       = $('#req_tahap').text();
        var req_bank        = $('#req_bank').text();

        var vcbo_coa        = $('#kd_coa').val();
        var vcbo_nasabah    = $('#kd_nasabah').val();
        var vcbo_sumberdaya = $('#kd_sumberdaya').val();
        var vcbo_spk        = $('#kd_spk').val();
        var vcbo_tahap      = $('#kd_tahap').val();
        var vcbo_bank       = $('#kd_bank').val();

        var l_coa = '<input type="hidden" name="l_coa[]" id="l_coa[]" value="'+$('#desc_coa').text()+'"/>';
        var l_cus = '<input type="hidden" name="l_cus[]" id="l_cus[]" value="'+$('#desc_customer').text()+'"/>';
        var l_nas = '<input type="hidden" name="l_nas[]" id="l_nas[]" value="'+$('#desc_nasabah').text()+'"/>';
        var l_sby = '<input type="hidden" name="l_sby[]" id="l_sby[]" value="'+$('#desc_sumberdaya').text()+'"/>';
        var l_spk = '<input type="hidden" name="l_spk[]" id="l_spk[]" value="'+$('#desc_spk').text()+'"/>';
        var l_thp = '<input type="hidden" name="l_thp[]" id="l_thp[]" value="'+$('#desc_tahap').text()+'"/>';
        var l_bnk = '<input type="hidden" name="l_bnk[]" id="l_bnk[]" value="'+$('#desc_bank').text()+'"/>';

        if(req_coa=='*' && (coa==undefined || coa=='') ){
            alert('Kode Coa Wajib diisi');
        }else if(req_nasabah=='*' && (nasabah == '')){
        	$('#kd_nasabah').focus();
            alert('Kode Nasabah Wajib diisi');
        }else if(req_sumberdaya=='*' && (sumberdaya == '')){
        	$('#kd_sumberdaya').focus();
            alert('Kode Sumberdaya Wajib diisi');
        }else if(req_spk=='*' && (spk=='')){
        	$('#kd_spk').focus();
            alert('Kode SPK Wajib diisi');
        }else if(req_tahap=='*' && (tahap='')){
        	$('#kd_tahap').focus();
            alert('Kode Tahap Wajib diisi');
        }else if(req_bank=='*' && (bank=='')){
            alert('Kode Bank Wajib diisi');
        }else if((debit==0 && kredit==0) || (debit=='' || kredit =='') ){
        	alert('Kolom Debit atau Kredit harus diberi nilai (min: 0)');
        }else if( keterangan=='' ){
        	alert('Uraian Tidak boleh kosong!');
        	$('#uraian').focus();
        }else{
           // var uraian = $('#uraian').val($('#uraian').val().toUpperCase());
            var rpl_debit = debit.replace('.00','');
            var rpl_kredit = kredit.replace('.00','');
            var rowNode = table
                            .row.add( [ 
                                coa             + l_coa + '<input type="hidden" name="no_bukti[]" id="no_bukti[]" value="'+$('#no_bukti').val()+'"/><input type="hidden" name="kode_coa[]" id="kode_coa[]" value="'+coa+'"/>', 
                                nasabah         + l_nas + '<input type="hidden" name="kode_nasabah[]" id="kode_nasabah[]" value="'+nasabah+'"/>', 
                                customer        + l_cus + '<input type="hidden" name="kode_customer[]" id="kode_customer[]" value="'+customer+'"/>', 
                                sumberdaya      + l_sby + '<input type="hidden" name="kode_sumberdaya[]" id="kode_sumberdaya[]" value="'+sumberdaya+'"/>', 
                                spk             + l_spk + '<input type="hidden" name="kode_spk[]" id="kode_spk[]" value="'+spk+'"/>', 
                                tahap           + l_thp + '<input type="hidden" name="kode_tahap[]" id="kode_tahap[]" value="'+tahap+'"/>', 
                                bank            + l_bnk + '<input type="hidden" name="kode_bank[]" id="kode_bank[]" value="'+bank+'"/>', 
                                nomor_terbit    + '<input type="hidden" name="nomor_terbit[]" id="nomor_terbit[]" value="'+nomor_terbit+'"/>', 
                                faktur_pajak    + '<input type="hidden" name="kode_faktur[]" id="kode_faktur[]" value="'+faktur_pajak+'"/>', 
                                no_invoice      + '<input type="hidden" name="no_invoice[]" id="no_invoice[]" value="'+no_invoice+'"/>', 
                                bukti_potong    + '<input type="hidden" name="bukti_potong[]" id="bukti_potong[]" value="'+bukti_potong+'"/>', 
                                debit           + '<input type="hidden" name="f_debit[]" id="f_debit[]" class="jDebit text-right" value="'+$('#debit').autoNumeric('get')+'"/>', 
                                kredit          + '<input type="hidden" name="f_kredit[]" id="f_kredit[]" class="jKredit text-right" value="'+$('#kredit').autoNumeric('get')+'"/>', 
                                //vdebit           + debit, 
                                //vkredit          + kredit, 
                                volume          + '<input type="hidden" name="f_volume[]" id="f_volume[]" value="'+volume+'"/>', 
                                keterangan      + '<input type="hidden" name="f_keterangan[]" id="f_keterangan[]" value="'+keterangan+'"/>',
                                aksi            + '<a href="#" class="row-edit" data-toggle="tooltip" title="Edit data"><span class="glyphicons glyphicons-edit"></span></a>&nbsp;&nbsp;&nbsp;'+
                                                  '<a href="#" class="row-delete" data-toggle="tooltip" title="Delete data"><span class="glyphicons glyphicons-bin"></span></a>&nbsp;&nbsp;&nbsp;'+
                                                  '<a href="#" class="row-duplicate" data-toggle="tooltip" title="Duplicate this data"><span class="glyphicons glyphicons-playing_dices"></span></a> ' ] )
                            .draw()
                            .node();

            $( "#btn-tambah" ).prop( "disabled", true );
            $( "#debit" ).prop( "disabled", false );
            $( "#kredit" ).prop( "disabled", false );

            resetBoks();
        }
    }

    //UPPER
    $('#nomor').keyup(function() {
		$(this).val($(this).val().toUpperCase());
	});
    $('#no_terbit').keyup(function() {
		$(this).val($(this).val().toUpperCase());
	});
	$('#kd_faktur').keyup(function() {
		$(this).val($(this).val().toUpperCase());
	});
	$('#invoice').keyup(function() {
		$(this).val($(this).val().toUpperCase());
	});
	$('#potong').keyup(function() {
		$(this).val($(this).val().toUpperCase());
	});
    $('#uraian').keyup(function() {
		$(this).val($(this).val().toUpperCase());
	});

	$('#no_bukti').focus();

	//CEGATTTT

	$('#debit').keydown(function(e){
		if($('#debit').val()==0){
			$('#kredit').attr('disabled', false);
		}else{
			$('#kredit').attr('disabled', true);
		}
        //$('#debit').attr('disabled', true);
        //$('#kredit').attr('disabled', true);
    });
    $('#kredit').keydown(function(e){
		if($('#kredit').val()==0){
			$('#debit').attr('disabled', false);
		}else{
			$('#debit').attr('disabled', true);
		}
        //$('#debit').attr('disabled', true);
        //$('#kredit').attr('disabled', true);
    });
}); //END OF jQuery Document

	function resetBoks()
	{
	    $('#no_terbit').val('');  
	    $('#kd_faktur').val('');  
	    $('#invoice').val(''); 
	    $('#debit').val(0);  
	    $('#kredit').val(0); 
	    $('#volume').val(0); 
	    $('#potong').val('');
	    $('#uraian').val('');
	    $('#kd_coa').val('');
	    $('#kd_nasabah').val('');
        $('#kd_customer').val('');
	    $('#kd_sumberdaya').val('');
	    //$('#kd_spk').val('');
	    $('#kd_tahap').val('');
	    $('#kd_tahap').val('');
	    $('#kd_bank').val('');

	    $('#desc_coa').text('');
	    $('#desc_nasabah').text('');
        $('#desc_customer').text('');
	    $('#desc_sbdy').text('');
	    //$('#desc_spk').text('');
	    $('#desc_tahap').text('');
	    $('#desc_bank').text('');

        //sum_debitkredit();
	}

</script>