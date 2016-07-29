<script type="text/javascript" src="<?=base_url()?>assets/vendor/plugins/datatables/extensions/ReloadAjax/js/dataTables.reloadAjax.min.js"></script>
<script type="text/javascript">
var oTbl = null;
var loadJurnal = function() {
	var periode = $('#periode').val(),
		arrPer = periode.split('/'),
		bln = arrPer[0],
		thn = arrPer[1];
	oTbl.fnReloadAjax('<?=base_url()?>index.php/jurnal/DT/'+bln+'-'+thn);
};

function resetBoks()
{
    $('#no_terbit').val('');  
    $('#kd_faktur').val('');  
    $('#no_invoice').val(''); 
    $('#debit').val(0);  
    $('#kredit').val(0); 
    $('#volume').val(0); 
    $('#bkt_potong').val('');
    $('#keterangan').val('');
    $('#kd_coa').val('').chosen().trigger('chosen:updated');
    $('#kd_nasabah').val('').chosen().trigger('chosen:updated');
    $('#kd_sumberdaya').val('').chosen().trigger('chosen:updated');
    $('#kd_spk').val('').chosen().trigger('chosen:updated');
    //$('#kd_tahap').val('').chosen().trigger('chosen:updated');
    $('#kd_tahap').val('');
    $('#kd_bank').val('').chosen().trigger('chosen:updated');
}

function getID(idnya)
    {
        alert(idnya);
        $(idnya).parents().index('tr');
        var rwid = $(this).attr('href');
        alert(rwid);
        var index = $("#datatable tr").index($(this));
        alert(index);
        var indek = $("tr", $(this).closest("#datatable")).index(this) ;
        alert(indek);
        var dTable = $("#datatable tr").dataTable();
        var tes = dTable.row( idnya ).index();
        alert( tes );
    }
$(document).ready(function(e){
    $('a.row-edit').click(function(e){ 
        var i = $(this).index(); 
        alert(i);
    });
});
jQuery(document).ready(function() {
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

    $("#datatable a").on('click', function(e){
        //alert(e.target.name);
        alert('tes dulu');
        var i = $(this).index(this);
        alert(i);
    });

    $('body').addClass('sb-l-m');

    $('#datatable').dataTable({
        "searching": false,
        'info': false,
        "paging":   false,
        "sScrollY": "200px",
        "scrollCollapse": true
    } ); 

    var table = $('#datatable').DataTable();
    
    /* parameter ----------------
    ----------------------------------------------------------------------------------------
    kode_coa,kode_nasabah,kode_sumberdaya,kode_spk,kode_tahap,kode_bank,
    nomor_terbit,kode_faktur,no_invoice,bukti_potong,f_debit,f_kredit,f_volume,f_keterangan
    */
    var idx_row = 0;
/*
    $('#datatable tbody').on( 'click', 'tr', function () {
        var dt_idx = table.row( this ).index();
        var kd_coa          = $('input[name="kode_coa[]"]').get(dt_idx).value;
        var kd_nasabah      = $('input[name="kode_nasabah[]"]').get(dt_idx).value;
        var kd_sbdy         = $('input[name="kode_sumberdaya[]"]').get(dt_idx).value;
        var kd_spk          = $('input[name="kode_spk[]"]').get(dt_idx).value;
        var kd_tahap        = $('input[name="kode_tahap[]"]').get(dt_idx).value;
        var kd_bank         = $('input[name="kode_bank[]"]').get(dt_idx).value;
        var no_terbit       = $('input[name="nomor_terbit[]"]').get(dt_idx).value;
        var kd_faktur       = $('input[name="kode_faktur[]"]').get(dt_idx).value;
        var no_invoice      = $('input[name="no_invoice[]"]').get(dt_idx).value;
        var bkt_potong      = $('input[name="bukti_potong[]"]').get(dt_idx).value;
        var f_debit         = $('input[name="f_debit[]"]').get(dt_idx).value;
        var f_kredit        = $('input[name="f_kredit[]"]').get(dt_idx).value;
        var f_volume        = $('input[name="f_volume[]"]').get(dt_idx).value;
        var f_uraian        = $('input[name="f_keterangan[]"]').get(dt_idx).value;
        //var coa,nasabah,sbdy,spk,tahap,bank,terbit,faktur,invoice,bkpotong,debit,kredit,volume,uraian = '';
        $('#kd_coa').val(kd_coa).chosen().trigger('chosen:updated');
        $('#kd_nasabah').val(kd_nasabah).chosen().trigger('chosen:updated');
        $('#kd_sumberdaya').val(kd_sbdy).chosen().trigger('chosen:updated');
        $('#kd_spk').val(kd_spk).chosen().trigger('chosen:updated');
        $('#kd_tahap').val(kd_tahap).chosen().trigger('chosen:updated');
        $('#kd_bank').val(kd_bank).chosen().trigger('chosen:updated');
        $('#no_terbit').val(no_terbit);
        $('#kd_faktur').val(kd_faktur);
        $('#noinvoice').val(no_invoice);
        $('#bkt_potong').val(bkt_potong);
        $('#debit').val(f_debit);
        $('#kredit').val(f_kredit);
        $('#volume').val(f_volume);
        $('#keterangan').val(f_uraian);
        
        //console.log( kd_coa );
        console.log( 'debit: '+f_debit );
        console.log( 'kredit: '+f_kredit );
        
        idx_row = dt_idx;
        console.log( dt_idx );
        console.log( idx_row );
        //_fnUpdate(parseInt(dt_idx),coa,nasabah,sbdy,spk,tahap,bank,terbit,faktur,invoice,bkpotong,debit,kredit,volume,uraian);
    });
*/
    
    //kita cara logika cepet aja dah
    /*
    var oTable = $('#datatable').DataTable();
    $('#datatable tbody').on('click',"input[name$='delete']",function() {
        console.log(table.row($(this).parents('tr')));
        table
            .row( $(this).parents('tr'))
            .remove()
            .draw();
    });
    $('#datatable tbody').on('click',"input[name$='edit']",function() {
        alert($('tr.odd').index());
        alert($('#datatable').DataTable().row( this ).index() );
        console.log($(this).row( this ).index());
    });

    $('#datatable ss').on('click',function(e) {
        console.log($('a').index(this));
        console.log(table.row($(this).parents('tr').index()));
        /*table
            .row( $(this).parents('tr'))
            .remove()
            .draw();
        var dt_idx = $('a').index(this);
        var kd_coa          = $('input[name="kode_coa[]"]').get(dt_idx).value;
        var kd_nasabah      = $('input[name="kode_nasabah[]"]').get(dt_idx).value;
        var kd_sbdy         = $('input[name="kode_sumberdaya[]"]').get(dt_idx).value;
        var kd_spk          = $('input[name="kode_spk[]"]').get(dt_idx).value;
        var kd_tahap        = $('input[name="kode_tahap[]"]').get(dt_idx).value;
        var kd_bank         = $('input[name="kode_bank[]"]').get(dt_idx).value;
        var no_terbit       = $('input[name="nomor_terbit[]"]').get(dt_idx).value;
        var kd_faktur       = $('input[name="kode_faktur[]"]').get(dt_idx).value;
        var no_invoice      = $('input[name="no_invoice[]"]').get(dt_idx).value;
        var bkt_potong      = $('input[name="bukti_potong[]"]').get(dt_idx).value;
        var f_debit         = $('input[name="f_debit[]"]').get(dt_idx).value;
        var f_kredit        = $('input[name="f_kredit[]"]').get(dt_idx).value;
        var f_volume        = $('input[name="f_volume[]"]').get(dt_idx).value;
        var f_uraian        = $('input[name="f_keterangan[]"]').get(dt_idx).value;
        //var coa,nasabah,sbdy,spk,tahap,bank,terbit,faktur,invoice,bkpotong,debit,kredit,volume,uraian = '';
        $('#kd_coa').val(kd_coa).chosen().trigger('chosen:updated');
        $('#kd_nasabah').val(kd_nasabah).chosen().trigger('chosen:updated');
        $('#kd_sumberdaya').val(kd_sbdy).chosen().trigger('chosen:updated');
        $('#kd_spk').val(kd_spk).chosen().trigger('chosen:updated');
        $('#kd_tahap').val(kd_tahap).chosen().trigger('chosen:updated');
        $('#kd_bank').val(kd_bank).chosen().trigger('chosen:updated');
        $('#no_terbit').val(no_terbit);
        $('#kd_faktur').val(kd_faktur);
        $('#noinvoice').val(no_invoice);
        $('#bkt_potong').val(bkt_potong);
        $('#debit').val(f_debit);
        $('#kredit').val(f_kredit);
        $('#volume').val(f_volume);
        $('#keterangan').val(f_uraian);

        var btadd = $('#btn-add').html();

        if(btadd=='Tambah'){
            $( "#debit" ).prop( "disabled", false );
            $( "#kredit" ).prop( "disabled", false );
            $('#btn-add').html('Ubah');
        }else{
            $('#btn-add').html('Tambah');
        }            
    });
   */

    function _fnUpdate(idx,coa,nasabah,sbdy,spk,tahap,bank,terbit,faktur,invoice,bkpotong,debit,kredit,volume,uraian)
    {
        console.log( 'fnUpdate -->START' );
        oTable.fnUpdate([coa,nasabah,sbdy,spk,tahap,bank,terbit,faktur,invoice,bkpotong,debit,kredit,volume,uraian], parseInt(idx));
        $('input[name="kode_coa[]"]:eq('+idx+')').val(coa);
        $('input[name="kode_nasabah[]"]:eq('+idx+')').val(nasabah);
        $('input[name="kode_sumberdaya[]"]:eq('+idx+')').val(sbdy);
        $('input[name="kode_spk[]"]:eq('+idx+')').val(spk);
        $('input[name="kode_tahap[]"]:eq('+idx+')').val(tahap);
        $('input[name="kode_bank[]"]:eq('+idx+')').val(bank);
        $('input[name="nomor_terbit[]"]:eq('+idx+')').val(terbit);
        $('input[name="kode_faktur[]"]:eq('+idx+')').val(faktur);
        $('input[name="no_invoice[]"]:eq('+idx+')').val(invoice);
        $('input[name="bukti_potong[]"]:eq('+idx+')').val(bkpotong);
        $('input[name="f_debit[]"]:eq('+idx+')').val(debit);
        $('input[name="f_kredit[]"]:eq('+idx+')').val(kredit);
        $('input[name="f_volume[]"]:eq('+idx+')').val(volume);
        $('input[name="f_keterangan[]"]:eq('+idx+')').val(uraian);
        console.log( 'fnUpdate -->DONE' );
        
    }
    var bTable = $('#datatable').DataTable();

    
    
   

    $('#tab2').addClass('active');
    $('#tab1 aria-expanded').val('true');
    $("a#tab1").bind('click');
    
	
    $('#tanggal').datetimepicker({
        format: 'DD/mm/YYYY',
        startDate: '-3d'
    });

    $('#kd_jenis').multiselect({
        buttonClass: 'multiselect dropdown-toggle btn btn-default btn-primary input-sm'
    });

    $('#kd_bank').multiselect({
        buttonClass: 'multiselect dropdown-toggle btn btn-default btn-primary input-sm'
    });
    $('#kd_tahap').multiselect({
        buttonClass: 'multiselect dropdown-toggle btn btn-default btn-primary input-sm'
    });

    /*$('#kd_coa').multiselect({
        enableFiltering: true,
    });*/

    $('#btn-submit').click(function() {
        //alert('simpan??');
        $('#form-input').attr('action', "simpan");
        var form=$("#form-input");
        if($( '#no_bukti' ).val()=='000000' || $( '#no_bukti' ).val()==' ' || $( '#no_bukti' ).val()=='')
        {
            alert('Nomor bukti belum di isi. Harap diisi lebih dahulu!');
        }else{
            $.ajax({
                type:"POST",
                url:form.attr("action"),
                data:form.serialize(),

                success: function(res){
                    console.log(res);  
                    //alert(res.msg);
                    if(res.msg === 'Success'){
                        alert('Jurnal tersimpan!') 
                        table
                            .clear()
                            .draw(); 
                        //disable apa aja disini ??
                        $( '#kd_jenis' ).val('').chosen().trigger('chosen:updated');
                        $( '#no_bukti' ).val('000000');
                        $( '#l_nobuk' ).val('');
                        $( '#nobuk' ).val('');
                        $('#faktur_pajak' ).val('');
                        $('#no_terbit' ).val('');
                        $('#noinvoice' ).val('');
                        $('#bukti_potong' ).val('');
                        $('#no_terbit' ).val('');
                        $('#btn-submit' ).prop( "disabled", true );
                        $('#btn-add' ).prop( "disabled", true );
                        $('#kd_coa').attr('disabled', true).trigger("liszt:updated");
                        $('#kd_coa').attr('disabled', true).trigger("chosen:updated");
                        $('#vjDebit').text('0');
                        $('#vjKredit').text('0');
                        $('#titleBalance').text('0');

                        $("#a_tab1").trigger('click');
                        $('#a_tab1').find('a').trigger('click');
                    } else {
                        alert('Ada Kesalahan! Harap Periksa kembali.')
                    }
                }
            }); 
        }
       	
	});

    $('#btn-submit' ).prop( "disabled", true );
    $('#btn-add' ).prop( "disabled", true );
    $('#kd_coa').attr('disabled', true).trigger("liszt:updated");
    $('#kd_coa').attr('disabled', true).trigger("chosen:updated");

    $('#kd_coa').change(function(e){
        $('#debit').attr('disabled', false);
        $('#kredit').attr('disabled', false);
        $.ajax({
            type: "POST",
            url: "ismandatory/"+$('#kd_coa option:selected').val(),
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
                }else{
                    $('#req_tahap').text('');
                    $('#kd_tahap').removeClass('required');
                }
                if(nasabah==1){
                    $('#req_nasabah').text('*');
                    $('#kd_nasabah').addClass('required');
                }else{
                    $('#req_nasabah').text('');
                    $('#kd_nasabah').removeClass('required');
                }
                if(pajak==1){
                    $('#req_pajak').text('*');
                    $('#kd_faktur').addClass('required');
                }else{
                    $('#req_pajak').text('');
                    $('#kd_faktur').removeClass('required');
                }
                if(sbdy==1){
                    $('#req_sbdy').text('*');
                    $('#kd_sumberdaya').addClass('required');
                }else{
                    $('#req_sbdy').text('');
                    $('#kd_sumberdaya').removeClass('required');
                }
                if(bank==1){
                    $('#req_bank').text('*');
                    $('#kd_bank').addClass('required');
                }else{
                    $('#req_bank').text('');
                    $('#kd_bank').removeClass('required');
                }
                    
                $( "#btn-add" ).prop( "disabled", false );
            },
            error: function (xhr, textStatus, errorThrown) {
                alert("Error: " + (errorThrown ? errorThrown : xhr.status));
            }
        });
    });

	$('#kd_jenis').change(function() {
        var kode = $('#kd_jenis option:selected').val();
        $( "#l_nobuk" ).text(' ');
        $( "#nomor_bukti" ).val(' ');
        var tglSplit = $("#tanggal").val().split('/');
        var nomorbukti = $("#no_bukti").val() + "/" + tglSplit[1]+ "/" + $(this).val() + "/" +  tglSplit[2].substring(2, 4);
        if(kode == "") {
            alert('Anda belum memilih kode jenis');
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
                        $('#no_bukti').focus();
                    }else{
                        $( "#l_nobuk" ).text( nomorbukti );
                        $( "#nomor_bukti" ).val( nomorbukti );
                        $('#kd_coa').attr('disabled', false).trigger("liszt:updated");
                        $("#kd_coa").attr('disabled', false).trigger("chosen:updated"); 
                        $("#a_tab2").trigger('click');
                        $('#a_tab2').find('a').trigger('click');
                    }
                },
                error: function (xhr, textStatus, errorThrown) {
                    alert("Error: " + (errorThrown ? errorThrown : xhr.status));
                }
            });
        }
    });

    $( '#no_bukti' ).change(function() {
        
        var kode = $('#kd_jenis option:selected').val();
        $( "#l_nobuk" ).text(' ');
        $( "#nomor_bukti" ).val(' ');
        var tglSplit = $("#tanggal").val().split('/');
        var nomorbukti = $(this).val() + "/" + tglSplit[1]+ "/" + kode + "/" +  tglSplit[2].substring(2, 4);
        
        if(kode == "") {
            alert('Anda belum memilih kode jenis');
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
                        $(this).val('000000');
                        $( this ).focus();
                    }else{
                        $('#l_nobuk').text(' ');
                        $("#l_nobuk").text( nomorbukti );
                        $("#nomor_bukti").val( nomorbukti );
                        $('#kd_coa').attr('disabled', false).trigger("liszt:updated");
                        $("#kd_coa").attr('disabled', false).trigger("chosen:updated");
                        $("#a_tab2").trigger('click');
                        $('#a_tab2').find('a').trigger('click');
                    }
                },
                error: function (xhr, textStatus, errorThrown) {
                    alert("Error: " + (errorThrown ? errorThrown : xhr.status));
                }
            });
            
        }
    });
    $( "#debit" ).change(function() {
        $( "#debit" ).prop( "disabled", false );
        $( "#kredit" ).prop( "disabled", true );
    });
    $( "#kredit" ).change(function() {
        $( "#kredit" ).prop( "disabled", false );
        $( "#debit" ).prop( "disabled", true );
    });


    $('#btn-add').on( 'click', function () {
        if($( '#no_bukti' ).val()=='000000' || $( '#no_bukti' ).val()==' ' || $( '#no_bukti' ).val()=='')
        {
            alert('Nomor bukti belum di isi. Harap diisi lebih dahulu!');
        }else{

            //var len = oTable.fnGetData().length;
            //if(len <= 0){
                fnClickAddRow();
                /*var coa             = $('#kd_coa option:selected').val();
                var nasabah         = $('#kd_nasabah option:selected').val();
                var sumberdaya      = $('#kd_sumberdaya option:selected').val();
                var spk             = $('#kd_spk option:selected').val();
                var tahap           = $('#kd_tahap option:selected').val(); 
                var bank            = $('#kd_bank option:selected').val(); 
                var nomor_terbit    = $('#no_terbit').val();  
                var faktur_pajak    = $('#kd_faktur').val();  
                var no_invoice      = $('#noinvoice').val(); 
                var debit           = $('#debit').val();  
                var kredit          = $('#kredit').val(); 
                var volume          = $('#volume').val(); 
                var bukti_potong    = $('#bkt_potong').val();
                var keterangan      = $('#keterangan').val();
                //var aksi            = '';

                var kd_coa          =  '<td>'+coa+'<input type="hidden" name="no_bukti[]" id="no_bukti[]" value="'+$('#nomor_bukti').val()+'"/><input type="hidden" name="kode_coa[]" id="kode_coa[]" value="'+coa+'"/> </td>'; 
                var kd_nasabah      =  '<td>'+nasabah+'<input type="hidden" name="kode_nasabah[]" id="kode_nasabah[]" value="'+nasabah+'"/> </td>';
                var kd_sbdy         =  '<td>'+sumberdaya+'<input type="hidden" name="kode_sumberdaya[]" id="kode_sumberdaya[]" value="'+sumberdaya+'"/> </td>';
                var kd_spk          =  '<td>'+spk+'<input type="hidden" name="kode_spk[]" id="kode_spk[]" value="'+spk+'"/> </td>';
                var kd_tahap        =  '<td>'+tahap+'<input type="hidden" name="kode_tahap[]" id="kode_tahap[]" value="'+tahap+'"/> </td>';
                var kd_bank         =  '<td>'+bank+'<input type="hidden" name="kode_bank[]" id="kode_bank[]" value="'+bank+'"/> </td>';
                var kd_terbit       =  '<td>'+nomor_terbit+'<input type="hidden" name="nomor_terbit[]" id="nomor_terbit[]" value="'+nomor_terbit+'"/> </td>';
                var kd_faktur       =  '<td>'+faktur_pajak+'<input type="hidden" name="kode_faktur[]" id="kode_faktur[]" value="'+faktur_pajak+'"/> </td>';
                var _invoice        =  '<td>'+no_invoice+'<input type="hidden" name="no_invoice[]" id="no_invoice[]" value="'+no_invoice+'"/> </td>';
                var _potong         =  '<td>'+bukti_potong+'<input type="hidden" name="bukti_potong[]" id="bukti_potong[]" value="'+bukti_potong+'"/> </td>';
                var _debit          =  '<td>'+debit+'<input type="hidden" name="f_debit[]" id="f_debit[]" class="jDebit" value="'+debit+'"/> </td>';
                var _kredit         =  '<td>'+kredit+'<input type="hidden" name="f_kredit[]" id="f_kredit[]" class="jKredit" value="'+kredit+'"/> </td>';
                var _volume         =  '<td>'+volume+'<input type="hidden" name="f_volume[]" id="f_volume[]" value="'+volume+'"/> </td>';
                var _uraian         =  '<td>'+keterangan+'<input type="hidden" name="f_keterangan[]" id="f_keterangan[]" value="'+keterangan+'"/> </td>';
                var aksi            =  '<td><input type="button" name="edit" value="E" />&nbsp;&nbsp;&nbsp;'+
                                                  '<input type="button" name="delete" value="X" />&nbsp;&nbsp;'+
                                                  '<a class="auah" href="#">EEE</a> </td>';
                $('#t_jurnal tbody').append('<tr class="odd">'+kd_coa+kd_nasabah+kd_sbdy+kd_spk+kd_tahap+kd_bank+kd_terbit+kd_faktur+_invoice+_potong+_debit+_kredit+_volume+_uraian+aksi+'</tr>');
                */
           /* }else{
                var dt_idx = table.row( this ).index();
                var coa         = $('#kd_coa option:selected').val();
                var nasabah     = $('#kd_nasabah option:selected').val();
                var sbdy        = $('#kd_sumberdaya option:selected').val();
                var spk         = $('#kd_spk option:selected').val();
                var tahap       = $('#kd_tahap option:selected').val(); 
                var bank        = $('#kd_bank option:selected').val(); 
                var terbit      = $('#no_terbit').val();  
                var faktur      = $('#kd_faktur').val();  
                var invoice     = $('#noinvoice').val(); 
                var debit       = $('#debit').val();  
                var kredit      = $('#kredit').val(); 
                var volume      = $('#volume').val(); 
                var bkpotong    = $('#bkt_potong').val();
                var uraian      = $('#keterangan').val();
                
                //console.log( kd_coa );
                console.log( 'debit: '+debit );
                console.log( 'kredit: '+kredit );
                
                idx_row = dt_idx;
                console.log( dt_idx );
                console.log( idx_row ); 

                _fnUpdate(parseInt(dt_idx),coa,nasabah,sbdy,spk,tahap,bank,terbit,faktur,invoice,bkpotong,debit,kredit,volume,uraian);

                resetBoks();
            }*/
            
        }
    });
    var nEditing = null;


    function fnClickAddRow() {
        //alert('add?');
        var jDebit      = 0;
        var jKredit     = 0; 
        var tDebit      = 0;
        var tKredit     = 0;
        var jBalance    = 0;

        var coa             = $('#kd_coa option:selected').val();
        var nasabah         = $('#kd_nasabah option:selected').val();
        var sumberdaya      = $('#kd_sumberdaya option:selected').val();
        var spk             = $('#kd_spk option:selected').val();
        var tahap           = $('#kd_tahap option:selected').val(); 
        var bank            = $('#kd_bank option:selected').val(); 
        var nomor_terbit    = $('#no_terbit').val();  
        var faktur_pajak    = $('#kd_faktur').val();  
        var no_invoice      = $('#noinvoice').val(); 
        var debit           = $('#debit').val();  
        var kredit          = $('#kredit').val(); 
        var volume          = $('#volume').val(); 
        var bukti_potong    = $('#bkt_potong').val();
        var keterangan      = $('#keterangan').val();
        var aksi            = '';

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
        }else{
            /*
            var rowNode = table
                            .row.add( [ 
                                coa             + '<input type="hidden" name="no_bukti[]" id="no_bukti[]" value="'+$('#nomor_bukti').val()+'"/><input type="hidden" name="kode_coa[]" id="kode_coa[]" value="'+coa+'"/>', 
                                nasabah         + '<input type="hidden" name="kode_nasabah[]" id="kode_nasabah[]" value="'+nasabah+'"/>', 
                                sumberdaya      + '<input type="hidden" name="kode_sumberdaya[]" id="kode_sumberdaya[]" value="'+sumberdaya+'"/>', 
                                spk             + '<input type="hidden" name="kode_spk[]" id="kode_spk[]" value="'+spk+'"/>', 
                                tahap           + '<input type="hidden" name="kode_tahap[]" id="kode_tahap[]" value="'+tahap+'"/>', 
                                bank            + '<input type="hidden" name="kode_bank[]" id="kode_bank[]" value="'+bank+'"/>', 
                                nomor_terbit    + '<input type="hidden" name="nomor_terbit[]" id="nomor_terbit[]" value="'+nomor_terbit+'"/>', 
                                faktur_pajak    + '<input type="hidden" name="kode_faktur[]" id="kode_faktur[]" value="'+faktur_pajak+'"/>', 
                                no_invoice      + '<input type="hidden" name="no_invoice[]" id="no_invoice[]" value="'+no_invoice+'"/>', 
                                bukti_potong    + '<input type="hidden" name="bukti_potong[]" id="bukti_potong[]" value="'+coa+'"/>', 
                                debit           + '<input type="hidden" name="f_debit[]" id="f_debit[]" class="jDebit" value="'+debit+'"/>', 
                                kredit          + '<input type="hidden" name="f_kredit[]" id="f_kredit[]" class="jKredit" value="'+kredit+'"/>', 
                                volume          + '<input type="hidden" name="f_volume[]" id="f_volume[]" value="'+volume+'"/>', 
                                keterangan      + '<input type="hidden" name="f_keterangan[]" id="f_keterangan[]" value="'+keterangan+'"/>',
                                aksi            + '<input type="button" name="edit" value="E" />&nbsp;&nbsp;&nbsp;'+
                                                  '<input type="button" name="delete" value="X" />&nbsp;&nbsp;'+
                                                  '<a class="auah" href="#">EEE</a>' ] )
                            .draw()
                            .node();
*/
            var btn_aksi        = '<a class="row-edit" href="#"><span class="glyphicons glyphicons-edit"></span></a>&nbsp;&nbsp;&nbsp'+
                                  '<a class="row-delete" href="#"><span class="glyphicons glyphicons-bin"></span></a>&nbsp;&nbsp;'+
                                  '<input type="button" name="delete" value="X" />';
            var kd_coa          =  '<td>'+coa+'<input type="hidden" name="no_bukti[]" id="no_bukti[]" value="'+$('#nomor_bukti').val()+'"/><input type="hidden" name="kode_coa[]" id="kode_coa[]" value="'+coa+'"/> </td>'; 
            var kd_nasabah      =  '<td>'+nasabah+'<input type="hidden" name="kode_nasabah[]" id="kode_nasabah[]" value="'+nasabah+'"/> </td>';
            var kd_sbdy         =  '<td>'+sumberdaya+'<input type="hidden" name="kode_sumberdaya[]" id="kode_sumberdaya[]" value="'+sumberdaya+'"/> </td>';
            var kd_spk          =  '<td>'+spk+'<input type="hidden" name="kode_spk[]" id="kode_spk[]" value="'+spk+'"/> </td>';
            var kd_tahap        =  '<td>'+tahap+'<input type="hidden" name="kode_tahap[]" id="kode_tahap[]" value="'+tahap+'"/> </td>';
            var kd_bank         =  '<td>'+bank+'<input type="hidden" name="kode_bank[]" id="kode_bank[]" value="'+bank+'"/> </td>';
            var kd_terbit       =  '<td>'+nomor_terbit+'<input type="hidden" name="nomor_terbit[]" id="nomor_terbit[]" value="'+nomor_terbit+'"/> </td>';
            var kd_faktur       =  '<td>'+faktur_pajak+'<input type="hidden" name="kode_faktur[]" id="kode_faktur[]" value="'+faktur_pajak+'"/> </td>';
            var _invoice        =  '<td>'+no_invoice+'<input type="hidden" name="no_invoice[]" id="no_invoice[]" value="'+no_invoice+'"/> </td>';
            var _potong         =  '<td>'+bukti_potong+'<input type="hidden" name="bukti_potong[]" id="bukti_potong[]" value="'+bukti_potong+'"/> </td>';
            var _debit          =  '<td>'+debit+'<input type="hidden" name="f_debit[]" id="f_debit[]" class="jDebit" value="'+debit+'"/> </td>';
            var _kredit         =  '<td>'+kredit+'<input type="hidden" name="f_kredit[]" id="f_kredit[]" class="jKredit" value="'+kredit+'"/> </td>';
            var _volume         =  '<td>'+volume+'<input type="hidden" name="f_volume[]" id="f_volume[]" value="'+volume+'"/> </td>';
            var _uraian         =  '<td>'+keterangan+'<input type="hidden" name="f_keterangan[]" id="f_keterangan[]" value="'+keterangan+'"/> </td>';
            var aksi            =  '<td>'+btn_aksi+'</td>';

            $('#t_jurnal tbody').append('<tr class="odd">'+kd_coa+kd_nasabah+kd_sbdy+kd_spk+kd_tahap+kd_bank+kd_terbit+kd_faktur+_invoice+_potong+_debit+_kredit+_volume+_uraian+aksi+'</tr>');

            if($('#debit').is(":disabled")){
                if(parseFloat(kredit) < 0 || kredit === ''){
                    alert('Kolom Debit/Kredit harus diisi nominal rupiah');
                }else{
                    //$( rowNode ).css( 'color', 'red' ).animate( { color: 'black' } );
                    $('.jDebit').each(function (index, element) {
                        tDebit = tDebit + parseFloat($(element).val());
                    });
                    
                    $('.jKredit').each(function (index, element) {
                        tKredit = tKredit + parseFloat($(element).val());
                    });
                    //alert(tDebit+'-'+tKredit);
                    $('#vjDebit').text(tDebit);
                    $('#vjKredit').text(tKredit);
                    var isBalance = '';
                    if(tDebit > tKredit){
                       //isBalance = 'Debit > Kredit --- Selisih: ('+(tDebit-tKredit)+')'; 
                       isBalance = (tDebit-tKredit); 
                       $( "#btn-submit" ).prop( "disabled", true );
                    }else if(tDebit < tKredit){
                        //isBalance = 'Debit < Kredit --- Selisih: ('+(tDebit-tKredit)+')';
                        isBalance = '('+(tDebit-tKredit)+')';
                        $( "#btn-submit" ).prop( "disabled", true );
                    }else{
                        isBalance = 'B A L A N C E';
                        $( "#btn-submit" ).prop( "disabled", false );
                    }
                        
                    $('#titleBalance').text(isBalance);
                    resetBoks();
                }
            }else if($('#kredit').is(":disabled")){ 
                if(parseFloat(debit) < 0 || debit === ''){
                    alert('Kolom Debit/Kredit harus diisi nominal rupiah');
                }else{
                    //$( rowNode ).css( 'color', 'red' ).animate( { color: 'black' } );
                    $('.jDebit').each(function (index, element) {
                        tDebit = tDebit + parseFloat($(element).val());
                    });
                    
                    $('.jKredit').each(function (index, element) {
                        tKredit = tKredit + parseFloat($(element).val());
                    });
                    //alert(tDebit+'-'+tKredit);
                    $('#vjDebit').text(tDebit);
                    $('#vjKredit').text(tKredit);
                    var isBalance = '';
                    if(tDebit > tKredit){
                       //isBalance = 'Debit > Kredit --- Selisih: ('+(tDebit-tKredit)+')'; 
                       isBalance = (tDebit-tKredit); 
                       $( "#btn-submit" ).prop( "disabled", true );
                    }else if(tDebit < tKredit){
                        //isBalance = 'Debit < Kredit --- Selisih: ('+(tDebit-tKredit)+')';
                        isBalance = '('+(tDebit-tKredit)+')';
                        $( "#btn-submit" ).prop( "disabled", true );
                    }else{
                        isBalance = 'B A L A N C E';
                        $( "#btn-submit" ).prop( "disabled", false );
                    }
                        
                    $('#titleBalance').text(isBalance);
                    resetBoks();
                }
            }

           
            $( "#debit" ).prop( "disabled", false );
            $( "#kredit" ).prop( "disabled", false );
            

        }
    }

  

    $('.chosen-select').val('').chosen().trigger('chosen:updated');

    //Harus diakhir, kalo ga, chosen-nya gak jalan! huekz! '(
    $("#a_tab1").trigger('click');
    $('#a_tab1').find('a').trigger('click');
    
});
</script>
