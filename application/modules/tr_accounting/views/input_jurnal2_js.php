<script type="text/javascript" src="<?=base_url()?>assets/vendor/plugins/jquerymask/jquery.maskedinput.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/vendor/plugins/datatables/extensions/ReloadAjax/js/dataTables.reloadAjax.min.js"></script>
<!-- TableSorter -->
<!--script type="text/javascript" src="<?=base_url()?>assets/vendor/plugins/tablesorter/jquery.tablesorter2261.js"></script>
<script src="<?=base_url()?>assets/vendor/plugins/tablesorter/widget-storage.js"></script>
<script src="<?=base_url()?>assets/vendor/plugins/tablesorter/widget-filter.js"></script-->
<script type="text/javascript" src="http://mottie.github.io/tablesorter/js/jquery.tablesorter.js"></script>
<script type="text/javascript" src="http://mottie.github.io/tablesorter/js/jquery.tablesorter.widgets.js"></script>
<script type="text/javascript" src="https://mottie.github.io/tablesorter/addons/pager/jquery.tablesorter.pager.js"></script>
<!--script type="text/javascript" src="<?=base_url()?>assets/vendor/plugins/tablesorter/docs/js/chili/chili-1.8b.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/vendor/plugins/tablesorter/docs/js/docs.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/vendor/plugins/tablesorter/docs/js/examples.js"></script-->

<script type="text/javascript">
var pilihCoa = function(kdcoa,desc) {
        $('#kd_coa').val(kdcoa);
        $('#desc_coa').text(desc);
    };
var listNoBuks = function() {
  var periode = $('#tanggal').val(),
    v_jenis = $('#v_jenis').val(),
    arrPer = periode.split('/'),
    tgl = arrPer[0],
    bln = arrPer[1],
    thn = arrPer[2],
    kdJenis = $('#kd_jenis').val();
    if($('#kd_jenis').val()==''){
        //$('#datatable-listnobuk').dataTable().fnReloadAjax('<?=base_url()?>index.php/jurnal/DT/'+bln+'-'+thn);
    }else{
        $('#datatable-listnobuk').dataTable().fnReloadAjax('<?=base_url()?>index.php/jurnal/listNoBuk/'+v_jenis+'/'+thn+'-'+bln);
    }
    
};
var v_listNoBuk = function() {
  var periode = $('#tgl_periode_list').val(),
    v_jenis = $('#v_jenis').val(),
    arrPer = periode.split('/'),
    tgl = arrPer[0],
    bln = arrPer[1],
    thn = arrPer[2];
    kdJenis = $('#kd_jenis').val();
    $('#datatable-listnobuk').dataTable().fnReloadAjax('<?=base_url()?>index.php/jurnal/listNoBuk/A/'+'/'+thn+'-'+bln);
};

var pakai = function(nobuk_kosong) {
    var periode = $('#tanggal').val(),
        v_jenis = $('#v_jenis').val(),
        arrPer = periode.split('/'),
        tgl = arrPer[0],
        bln = arrPer[1],
        thn = arrPer[2],
        kdJenis = $('#kd_jenis').val();
        $('#no_bukti').val(nobuk_kosong);
        $('#nomor_bukti').val(nobuk_kosong);
        $('#lbl_nobukti').html(nobuk_kosong+'/'+bln+'/'+kdJenis+'/'+thn);
        alert(nobuk_kosong+'/'+bln+'/'+kdJenis+'/'+thn);

    };
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
    var cus_exist   = 1;
    var spk_exist 	= 1;
    var tahap_exist = 1;
    var bank_exist 	= 1;

    var duplicIdx   = 0;


    var periode = $('#tanggal').val(),
    v_jenis = $('#v_jenis').val(),
    arrPer = periode.split('/'),
    tgl = arrPer[0],
    bln = arrPer[1],
    thn = arrPer[2];

    //FORMAT NOMOR
    $(".cterbit").mask("9999999/99/*/99");
    $(".fkpajak").mask("999.999-99.99999999");

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
	$('#tgl_periode_list').datetimepicker({
		minViewMode: 'months',
		pickTime: false,
		format: 'YYYY-MM'
	});
    
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

    $('#modal-list_nobuk').modal({
        show: false,
        backdrop: false
    });
    $('#modal-listnobuks').modal({
        show: false,
        backdrop: false
    });
/*
  var t_listnobuk = $('#datatable-listnobuk').DataTable({
        "bServerSide":true,
        "bProcessing":true,
        "sPaginationType": "full_numbers",
        
        ///"ajax": "<?=base_url()?>index.php/jurnal/listNoBuk/M",
        "ajax": {
            "url": "<?=base_url()?>index.php/jurnal/listNoBuk/A/"+thn+'/'+bln+'/?draw=11',
            "type": "POST",
            "dataSrc": function ( json ) {
                  /*for ( var i=0, ien=json.data.length ; i<ien ; i++ ) {
                    json.data[i][2] = '<a href="/message/'+json.data[i][0]+'>View message</a>';
                  }
                  return json.data;
                  */
                  /*
                }
          },
          "aoColumns": [
            { "mDataProp": "nomor" },
            { "mDataProp": "nomor" },
          ]
    });
*/
    $("#btn_periode_nobuk").on('click', function(){
        var periode = $('#tgl_periode_list').val(),
            tgl = arrPer[0],
            bln = arrPer[1],
            thn = arrPer[2];
        var jenis = $("#v_jenis").val();
        $.get('../jurnal/listNoBuk/'+jenis+'/'+periode, function(html) { 
             // append the "ajax'd" data to the table body 
             $("#t_sorter tbody").append(html); 
            // let the plugin know that we made a update 
            $("#t_sorter").trigger("update"); 
            // set sorting column and direction, this will sort on the first and third column 
            var sorting = [[2,1],[0,0]]; 
            // sort on the first column 
            $("#t_sorter").trigger("sorton",[sorting]); 
        }); 
        return false; 
    });



    $('#btn-listnobuk').on('click', function(){
        var periode = $('#tanggal').val(),
            v_jenis = $('#v_jenis').val(),
            arrPer = periode.split('/'),
            tgl = arrPer[0],
            bln = arrPer[1],
            thn = arrPer[2];
        if($("#kd_jenis").val() =='' || $("#no_bukti").val() == ""){
            alert('Harap pilih dahulu jenis transaksi jurnal');
        }else{
            $.ajax({
                type:"POST",
                //url: '../jurnal/listNoBuk/'+$("#kd_jenis").val()+'/'+thn+'-'+bln+'-'+tgl,
                data: {"nobukti": ''},
                success: function(res){
                    $('#tb_listnobuk').empty();
                    $.get('../jurnal/listNoBuk/'+$("#kd_jenis").val()+'/'+thn+'-'+bln+'-'+tgl, function(html) { 
                         // append the "ajax'd" data to the table body 
                         $("#t_sorter tbody").append(html); 
                        // let the plugin know that we made a update 
                        $("#t_sorter").trigger("update"); 
                        // set sorting column and direction, this will sort on the first and third column 
                        var sorting = [[2,1],[0,0]]; 
                        // sort on the first column 
                        $("#t_sorter").trigger("sorton",[sorting]); 
                    }); 
                    return false; 
                    /*var tr; var resort = true;
                    for (var i = 0; i < res.length; i++) {
                        tr = $('<tr/>');
                        tr.append("<td>" + res[i].nomor + "</td>");
                        tr.append("<td>" + res[i].status + "</td>");
                        tr.append("<td>pilih(" + res[i].nomor + ")</td>");
                        $('#t_sorter').append(tr);
                        /*$('#t_sorter')
                          .find('tbody').append(tr)
                          .trigger('addRows', [tr, resort]);*/
                    //}
                    //console.log(res.[0].nomor);
                   /*var row = 
                    '<tr>'+
                    '   <td>'+res.nomor+'</td>'+
                    '   <td>'+res.status+'</td>'+
                    '   <td>pilih('+res.nomor+')</td>'+
                    '</tr>',
                          $row = $(row),
                          resort = true;
                        $('#t_sorter')
                          .find('tbody').append($row)
                          .trigger('addRows', [$row, resort]);
                        return false;*/
                },
                error: function(XMLHttpRequest, textStatus, errorThrown){
                    console.log(errorThrown);
                }

            }).fail(function (jqXHR, textStatus, error) {
                console.log(jqXHR.responseText);
            }); 
            $('#modal-listnobuks').modal('show');
        }
         
        
    });
    $('#btn-close-lookup').on('click', function(){
        $('#modal-listnobuk').modal('hide');
    });

    $('.tablesorter')
        .bind('filterInit', function() {
            // check that storage ulility is loaded
            if ($.tablesorter.storage) {
                // get saved filters
                var f = $.tablesorter.storage(this, 'tablesorter-filters') || [];
                $(this).trigger('search', [f]);
            }
        })
        .bind('filterEnd', function(){
            if ($.tablesorter.storage) {
                // save current filters
                var f = $(this).find('.tablesorter-filter').map(function(){
                    return $(this).val() || '';
                }).get();
                $.tablesorter.storage(this, 'tablesorter-filters', f);
            }
    });

/*
* TABLESORTER
*/
    $('.tablesorter').tablesorter({
        theme: 'blue',

        // fix the column widths
        widthFixed: true,
        widgets: ['zebra', 'filter'],

        widgetOptions: {
            zebra: [
                "ui-widget-content even",
                "ui-state-default odd"
                ],
            uitheme: 'jui',
            columns: [
                "primary",
                "secondary",
                "tertiary"
                ],

            columns_tfoot: true,
            columns_thead: true,
            filter_childRows: false,
            filter_columnFilters: true,
            filter_cssFilter: "tablesorter-filter",
            filter_functions: null,
            filter_hideFilters: false,
            filter_ignoreCase: true,
            filter_reset: null,
            filter_searchDelay: 300,
            filter_startsWith: false,
            filter_useParsedData: false,
            resizable: true,
            saveSort: true,
            stickyHeaders: "tablesorter-stickyHeader"

        }
    });

    var $table = $('.tablesorter'),
        // define pager options
        pagerOptions = {
        // target the pager markup - see the HTML block below
        container: $(".pager"),
        output: '{startRow} - {endRow} / {filteredRows} ({totalRows})',
        fixedHeight: true, 
        removeRows: false,
        cssGoto: '.gotoPage'
    };


	var table = $('#datatable').DataTable({
        paging: false,
    	searching: false,
    	ordering: false,
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

     $table
        .tablesorter({
          theme: 'blue',
          headerTemplate : '{content} {icon}', // new in v2.7. Needed to add the bootstrap icon!
          widthFixed: true,
          widgets: ['zebra', 'filter']
    })

        .tablesorterPager(pagerOptions);

        var r, $row, num = 50,
          row = '<tr><td>Student{i}</td><td>{m}</td><td>{g}</td><td>{r}</td><td>{r}</td><td>{r}</td><td>{r}</td><td><button type="button" class="remove" title="Remove this row">X</button></td></tr>' +
            '<tr><td>Student{j}</td><td>{m}</td><td>{g}</td><td>{r}</td><td>{r}</td><td>{r}</td><td>{r}</td><td><button type="button" class="remove" title="Remove this row">X</button></td></tr>';
        $('button:contains(Add)').click(function(){
          // add two rows of random data!
          r = row.replace(/\{[gijmr]\}/g, function(m){
            return {
              '{i}' : num + 1,
              '{j}' : num + 2,
              '{r}' : Math.round(Math.random() * 100),
              '{g}' : Math.random() > 0.5 ? 'male' : 'female',
              '{m}' : Math.random() > 0.5 ? 'Mathematics' : 'Languages'
            }[m];
          });
          num = num + 2;
          $row = $(r);
          $table
            .find('tbody').append($row)
            .trigger('addRows', [$row]);
          return false;
        });

        // Delete a row
        // *************
        $table.delegate('button.remove', 'click' ,function(){
          // NOTE this special treatment is only needed if `removeRows` is `true`
          // disabling the pager will restore all table rows
          $table.trigger('disablePager');
          // remove chosen row
          $(this).closest('tr').remove();
          // restore pager
          $table.trigger('enablePager');
        });

        // Destroy pager / Restore pager
        // **************
        $('button:contains(Destroy)').click(function(){
          // Exterminate, annhilate, destroy! http://www.youtube.com/watch?v=LOqn8FxuyFs
          var $t = $(this);
          if (/Destroy/.test( $t.text() )){
            $table.trigger('destroyPager');
            $t.text('Restore Pager');
          } else {
            $table.tablesorterPager(pagerOptions);
            $t.text('Destroy Pager');
          }
          return false;
        });

        // Disable / Enable
        // **************
        $('.toggle').click(function(){
          var mode = /Disable/.test( $(this).text() );
          // triggering disablePager or enablePager
          $table.trigger( (mode ? 'disable' : 'enable') + 'Pager');
          $(this).text( ( mode ? 'Enable' : 'Disable' ) + ' Pager');
          return false;
        });
        $table.bind('pagerChange', function(){
          // pager automatically enables when table is sorted.
          $('.toggle').text( 'Disable Pager' );
        });

/* *** END TABLESORTER ****/

	var oTable = $('#datatable').dataTable();

	$('[data-toggle="tooltip"]').tooltip(); 
	$('#btn-tambah').attr('disabled', true);  
    //$("#btn-tambah" ).prop( "disabled", true );
    $( "#btn-simpan" ).prop( "disabled", true );

    $('#modal-coa-all').modal({
        show: false,
        backdrop: false
    });

    $("#btn_periode_nobuk").on('click',function(){
        var periode  = $("#tgl_periode_list").val()
        v_jenis = $("#v_jenis").val();
        //alert('helllo...');
        $.ajax({
            url: '<?php echo base_url();?>index.php/jurnal/listNoBuk/'+v_jenis+'/'+periode+'/?draw=11',
            type: "post",
            dataType: "json",
            data: {
                json: JSON.stringify([
                    {
                    id: 1,
                    firstName: "Peter",
                    lastName: "Jhons"},
                {
                    id: 2,
                    firstName: "David",
                    lastName: "Bowie"}
                ]),
                delay: 3
            },
            success: function(data, textStatus, jqXHR) {
                
                drawTable(data);
            }
        });
    });

    function drawTable(data) {
        for (var i = 0; i < data.length; i++) {
            console.log(data[i]);
            drawRow(data[i]);
        }
    }

    function drawRow(rowData) {
        var row = $("<tr />")
        $("#t_sorter").append(row); 
        row.append($("<td>" + rowData.nomor + "</td>"));
        row.append($("<td>" + rowData.nomor + "</td>"));
        row.append($("<td><a href='javascript;'>pilih</a></td>"));
    }
	/*
    *   AUTOCOMPLETE / LOOKUP DATA
    *
    */
	$("#kd_coa").autocomplete({
        minLength: 1,
        source:
        function(req, add){
            $.ajax({
                //url: "<?=base_url()?>index.php/jurnal/lookup/coa",
                url: "<?=base_url()?>index.php/jurnal/lookupCommon/"+$("#kd_jenis").val()+'/'+$("#kd_coa").val(),
                dataType: 'json',
                type: 'POST',
                data: req,
                success:
                    function(data){
                        if(data.response =='true'){
                            add(data.message);
                            coa_exist = 1;
                        }else{
                        	//$('#btn-tambah').prop('disabled',true);
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

            $('#req_tahap').text('');
            $('#kd_tahap').removeClass('required');
            $('#r_tahap').css('color','');

            $('#req_nasabah').text('');
            $('#kd_nasabah').removeClass('required');
            $('#r_nasabah').css('color','');

            $('#req_faktur').text('');
            $('#kd_faktur').removeClass('required');
            $('#r_faktur').css('color','');

            $('#req_sumberdaya').text('');
            $('#kd_sumberdaya').removeClass('required');
            $('#r_sbdy').css('color','');

            $('#req_ban').text('');
            $('#kd_bank').removeClass('required');
            $('#r_bank').css('color','');

        }
    });
    $('#kd_coa').change(function(e){
        $('#btn-tambah').attr('disabled', false);  
        $("#btn-tambah" ).prop( "disabled", false );
        //$('#debit').attr('disabled', true);
        //$('#kredit').attr('disabled', true);
        if($(this).val()==''){
            $('#kd_coa').focus();
            alert('Kode COA/Akun tidak boleh kosong.');
        }else if($('#kd_coa').val().length < 5){
            alert('Kode COA belum memenuhi syarat. Pastikan dengan banar.');
            $('#kd_coa').focus();
        }else{
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
        }
    });
    $('#datatable-coa').dataTable({
        "bServerSide":true,
        "bProcessing":true,
        "bLengthChange": true,
        "sPaginationType": "full_numbers",
        "bFilter":true,
        "sServerMethod": "POST",
        "sAjaxSource": "<?=base_url()?>index.php/jurnal/listCoa",
        "columns": [
            { "name": "kode", "class": "text-center"},
            { "name": "nama", "class": "text-left"},
            { "name": "mand_tahap", "class": "text-center" },
            { "name": "mand_sbd", "class": "text-center" },
            { "name": "mand_nasabah", "class": "text-center" },
            { "name": "mand_pajak", "class": "text-center" },
            { "name": "mand_bank", "class": "text-center" }, 
            { "searchable": true, "sortable": true }
        ]
    });
    $("#kd_coa").keydown(function(event) {
        console.log('keyCode: '+event.keyCode);
        if ( event.keyCode == 27 || event.keyCode == 46 || event.keyCode == 63 || event.keyCode == 8 || event.keyCode == 9) { //titik  atau backspace
            if(event.keyCode == 27){
                console.log('ESC - popshowup');
                $('#modal-coa-all').modal('show');
            }
            if(event.keyCode == 9){
                if( $(this).val().length < 5 ){
                    alert('Kode belum memenuhi syarat. Ulangi lagi');
                    $(this).focus();
                }else{
                    $('#kd_nasabah').focus();
                }
                console.log('key TAB pressed');
                
            }
            /*else{
                if(event.keyCode == 27){
                    $('#kd_nasabah').focus();
                }
                console.log('keyCode: '+event.keyCode);    
            }*/
            
        }else{
            if (event.keyCode < 48 || event.keyCode > 57 ) {
                event.preventDefault(); 
            }
        }
        $('#btn-tambah').attr('disabled', false);  
        $("#btn-tambah" ).prop( "disabled", false );
    });
    $("#kd_coa").keyup(function(e){
        if(e.keyCode == 9){
            if($("#kd_coa").val().length < 5) {
                alert('Kode Akun belum lengkap. Ulangi');
                $("#kd_coa").focus();
                e.preventDefault();
            }else{
                $(this).next('#kd_nasabah').focus();
                $('#kd_nasabah').focus();    
                e.preventDefault();
            }
        }else{

        }
    });
/*
    $("#kd_coa").keypress(function(event) {
        console.log('keyCode: '+event.keyCode);
        if(event.keyCode == 13 || event.keyCode == 9 ) { 
            console.log('ENTER');
            $('#modal-listnobuk').modal('hide');
            $('#kd_nasabah').focus();
        }else{
            console.log('keyCode: '+event.keyCode);
        }
    });
*/
    //---END JS COA

    $('#btn-close').click(function() {
        $('#modal-coa-all').modal('hide');
    });
    //--- KODE_NASABAH
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
                            if($("#kd_nasabah").val()==''){
                                nas_exist = 0;
                            }else{
                                nas_exist = 1;
                            }
                        }else{
                        	//$('#btn-tambah').prop('disabled',true);
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
            $("#kd_customer").focus();
        }
    });
    $("#kd_nasabah").on('change',function(){
        if($(this).val()=='' && tDebit==tKredit && $('#uraian').val()!=''){
            console.log('Tombol Tambah = Enabled');
           // $('#btn-tambah').prop('disabled',false);
        }/*else{
            console.log('Disable lah');
        }*/
        if($(this).val()==''){
            $('#desc_nasabah').html('');
        }
    });

   /* $("#kd_nasabah").keyup(function(e){
        if($(this).val()=='' && tDebit==tKredit && $('#uraian').val()!=''){
            console.log('Tombol Tambah = Enabled');
           // $('#btn-tambah').prop('disabled',false);
        }else if($('#kd_coa').val().length < 5){
            alert('Kode COA belum memenuhi syarat. Pastikan dengan banar.');
            $('#kd_coa').focus();
        }else{

        }
    });
    $("#kd_nasabah").keydown(function(event) {

        if ( event.keyCode == 13 ) { //enter, titik  atau backspace
            console.log('keyCode: '+event.keyCode);
            if($(this).val().length <=0){
                alert('INFO: Kode Nasabah Kosong');
                event.preventDefault(); 
            }else{
                $('#kd_customer').focus();
                event.preventDefault();
            }
        }else{
            if ( (event.keyCode < 48 || event.keyCode > 57 )|| (event.keyCode < 65 || event.keyCode > 122) ) {
                event.preventDefault(); 
            }
        }
    });*/
    
    $('#modal-listnobuk').modal('hide');
    $("#kd_nasabah").keypress(function(event) {
        $('#modal-listnobuk').modal('hide');
        if(event.keyCode == 9 ) { 
            if($(this).val().length === 0){
                $('#modal-listnobuk').modal({
                    show: false,
                    backdrop: false
                });
                alert('Kode Nasabah anda biarkan kosong?');
                $('#modal-listnobuk').modal({
                    show: false,
                    backdrop: false
                });
                $('#kd_customer').focus();
                event.preventDefault();
            }
            
            console.log('ENTER');
            $('#kd_customer').focus();
            event.preventDefault();
        }else{
            console.log('keyCode: '+event.keyCode);
        }
    });
    //--- END KODE_NASABAH
    
    //--- KODE CUSTOMER
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
                            if($("#kd_customer").val()==''){
                                cus_exist = 0;
                            }else{
                                cus_exist = 1;
                            }
                        }else{
                            //$('#btn-tambah').prop('disabled',true);
                            $('#desc_customer').text('Kode Customer, tidak terdaftar!');
                            cus_exist = 0;
                        }
                    }
            });
        },
        select: function (event, ui) {
            event.preventDefault();
            $(this).val(ui.item.value);
            $('#desc_customer').text(ui.item.label.slice(7,50));
            $("#kd_sumberdaya").focus();
        }
    });
    $("#kd_customer").on('change',function(){
        if($(this).val()==''){
            $('#desc_customer').text('');
        }
    });
    /*$("#kd_customer").keyup(function(e){
        //alert(coa_exist);
        if($(this).val()==''){
            $('#desc_customer').text('');
        }
    });
    $("#kd_customer").keydown(function(event) {

        if ( event.keyCode == 13 ) { //titik  atau backspace
            console.log('keyCode: '+event.keyCode);
        }else{
            if (event.keyCode < 48 || event.keyCode > 57 ) {
                event.preventDefault(); 
            }
        }
    });
    $("#kd_customer").keypress(function(event) {
        if(event.keyCode == 13 || event.keyCode == 9 ) { 
            console.log('ENTER');
            $('#kd_sumberdaya').focus();
        }else{
            console.log('keyCode: '+event.keyCode);
        }
    });
    */
    $("#kd_customer").keypress(function(event) {
        $('#modal-listnobuk').modal('hide');
        if(event.keyCode == 9 ) { 
            if($(this).val().length === 0){
                $('#modal-listnobuk').modal({
                    show: false,
                    backdrop: false
                });
                alert('Kode Customer anda biarkan kosong?');
                $('#modal-listnobuk').modal({
                    show: false,
                    backdrop: false
                });
                $('#kd_sumberdaya').focus();
                event.preventDefault();
            }
            
            console.log('ENTER');
            $('#kd_sumberdaya').focus();
            event.preventDefault();
        }else{
            console.log('keyCode: '+event.keyCode);
        }
    });
    //--- END KODE_CUSTOMER

    //--- KODE SUMBERDAYA
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
                            if($("#kd_sumberdaya").val()==''){
                                sbdy_exist = 0;
                            }else{
                                sbdy_exist = 1;
                            }
                        }else{
                        	//$('#btn-tambah').prop('disabled',true);
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
            $("#kd_tahap").focus();
        }
    });
    $("#kd_sumberdaya").on('change',function(){
        if($(this).val()==''){
            $('#desc_sumberdaya').text('');
        }
    });
   /* $("#kd_sumberdaya").keyup(function(e){
        //alert(coa_exist);
        if($(this).val()==''){
            $('#desc_sumberdaya').text('');
        }
        if($(this).val()=='' && tDebit==tKredit && $('#uraian').val()!=''){
            console.log('Tombol Tambah = Enabled');
         //   $('#btn-tambah').prop('disabled',false);
        }
    });
    $("#kd_sumberdaya").keydown(function(event) {

        if ( event.keyCode == 13 ) { //titik  atau backspace
            console.log('keyCode: '+event.keyCode);
        }else{
            if (event.keyCode < 48 || event.keyCode > 57 ) {
                event.preventDefault(); 
            }
        }
    });
    $("#kd_sumberdaya").keypress(function(event) {
        if(event.keyCode == 13 || event.keyCode == 9 ) { 
            console.log('ENTER');
            $('#kd_tahap').focus();
        }else{
            console.log('keyCode: '+event.keyCode);
        }
    });
    */
    $("#kd_sumberdaya").keypress(function(event) {
        $('#modal-listnobuk').modal('hide');
        if(event.keyCode == 9 ) { 
            if($(this).val().length === 0){
                $('#modal-listnobuk').modal({
                    show: false,
                    backdrop: false
                });
                alert('Kode Sumberdaya anda biarkan kosong?');
                $('#modal-listnobuk').modal({
                    show: false,
                    backdrop: false
                });
                $('#kd_tahap').focus();
                event.preventDefault();
            }
            
            console.log('ENTER');
            $('#kd_tahap').focus();
            event.preventDefault();
        }else{
            console.log('keyCode: '+event.keyCode);
        }
    });
    //--- END KODE SUMBERDAYA

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
                            if($("#kd_spk").val()==''){
                                spk_exist = 0;
                            }else{
                                spk_exist = 1;
                            }
                        }else{
                        	//$('#btn-tambah').prop('disabled',true);
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
    /*
    $("#kd_spk").keyup(function(e){
        //alert(coa_exist);
        if($(this).val()==''){
            $('#desc_spk').text('');
        }
        if($(this).val()=='' && tDebit==tKredit && $('#uraian').val()!=''){
            console.log('Tombol Tambah = Enabled');
           // $('#btn-tambah').prop('disabled',false);
        }
    });
*/
    //--- KODE TAHAP
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
                            if($("#kd_tahap").val()==''){
                                tahap_exist = 0;
                            }else{
                                tahap_exist = 1;
                            }
                        }else{
                        	//$('#btn-tambah').prop('disabled',true);
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
    /*
    $("#kd_tahap").keyup(function(e){
        //alert(coa_exist);
        if($(this).val()==''){
            $('#desc_tahap').text('');
        }
    });
    $("#kd_tahap").keydown(function(event) {

        if ( event.keyCode == 13 ) { //titik  atau backspace
            console.log('keyCode: '+event.keyCode);
        }else{
            if (event.keyCode < 48 || event.keyCode > 57 ) {
                event.preventDefault(); 
            }
        }
    });
    $("#kd_tahap").keypress(function(event) {
        if(event.keyCode == 13 || event.keyCode == 9 ) { 
            console.log('ENTER');
            $('#kd_bank').focus();
        }else{
            console.log('keyCode: '+event.keyCode);
        }
    });
    */
    $("#kd_tahap").keypress(function(event) {
        $('#modal-listnobuk').modal('hide');
        if(event.keyCode == 9 ) { 
            if($(this).val().length === 0){
                $('#modal-listnobuk').modal({
                    show: false,
                    backdrop: false
                });
                alert('Kode Tahap anda biarkan kosong?');
                $('#modal-listnobuk').modal({
                    show: false,
                    backdrop: false
                });
                $('#kd_bank').focus();
                event.preventDefault();
            }
            
            console.log('ENTER');
            $('#kd_bank').focus();
            event.preventDefault();
        }else{
            console.log('keyCode: '+event.keyCode);
        }
    });
    //--- END KODE TAHAP


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
                            if($("#kd_bank").val()==''){
                                bank_exist = 0;
                            }else{
                                bank_exist = 1;
                            }
                        }else{
                        	//$('#btn-tambah').prop('disabled',true);
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
    /*
    $("#kd_bank").keyup(function(e){
        //alert(coa_exist);
        if($(this).val()==''){
            $('#desc_bank').text('');
        }
        if($(this).val()=='' && tDebit==tKredit && $('#uraian').val()!=''){
            console.log('Tombol Tambah = Enabled');
            //$('#btn-tambah').prop('disabled',false);
        }
    });
    $("#kd_bank").keydown(function(event) {

        if ( event.keyCode == 13 ) { //titik  atau backspace
            console.log('keyCode: '+event.keyCode);
        }else{
            if (event.keyCode < 48 || event.keyCode > 57 ) {
                event.preventDefault(); 
            }
        }
    });
    $("#kd_bank").keypress(function(event) {
        if(event.keyCode == 13 || event.keyCode == 9 ) { 
            console.log('ENTER');
            $('#no_terbit').focus();
        }else{
            console.log('keyCode: '+event.keyCode);
        }
    });
    */
    $("#kd_bank").keypress(function(event) {
        $('#modal-listnobuk').modal('hide');
        if(event.keyCode == 9 ) { 
            if($(this).val().length === 0){
                $('#modal-listnobuk').modal({
                    show: false,
                    backdrop: false
                });
                alert('Kode Tahap anda biarkan kosong?');
                $('#modal-listnobuk').modal({
                    show: false,
                    backdrop: false
                });
                $('#no_terbit').focus();
                event.preventDefault();
            }
            
            console.log('ENTER');
            $('#no_terbit').focus();
            event.preventDefault();
        }else{
            console.log('keyCode: '+event.keyCode);
        }
    });
    //--- END KODE BANK

    //--- NO TERBIT
    /*$("#no_terbit").keydown(function(event) {

        if ( event.keyCode == 13 ) { //titik  atau backspace
            console.log('keyCode: '+event.keyCode);
        }else{
            if (event.keyCode < 48 || event.keyCode > 57 ) {
                event.preventDefault(); 
            }
        }
    });
    $("#no_terbit").keypress(function(event) {
        if(event.keyCode == 13 || event.keyCode == 9 ) { 
            console.log('ENTER');
            $('#kd_faktur').focus();
        }else{
            console.log('keyCode: '+event.keyCode);
        }
    });*/
    $("#no_terbit").keypress(function(event) {
        $('#modal-listnobuk').modal('hide');
        if(event.keyCode == 9 ) { 
            if($(this).val().length === 0){
                $('#modal-listnobuk').modal({
                    show: false,
                    backdrop: false
                });
                alert('Nomor Terbit anda biarkan kosong?');
                $('#modal-listnobuk').modal({
                    show: false,
                    backdrop: false
                });
                $('#kd_faktur').focus();
                event.preventDefault();
            }
            
            console.log('ENTER');
            $('#kd_faktur').focus();
            event.preventDefault();
        }else{
            console.log('keyCode: '+event.keyCode);
        }
    });
    //--- END NO TERBIT

    //--- KODE FAKTUR
    /*$("#kd_faktur").keydown(function(event) {

        if ( event.keyCode == 13 ) { //titik  atau backspace
            console.log('keyCode: '+event.keyCode);
        }else{
            if (event.keyCode < 48 || event.keyCode > 57 ) {
                event.preventDefault(); 
            }
        }
    });
    $("#kd_faktur").keypress(function(event) {
        if(event.keyCode == 13 || event.keyCode == 9 ) { 
            console.log('ENTER');
            $('#invoice').focus();
        }else{
            console.log('keyCode: '+event.keyCode);
        }
    });*/
    $("#kd_faktur").keypress(function(event) {
        $('#modal-listnobuk').modal('hide');
        if(event.keyCode == 9 ) { 
            if($(this).val().length === 0){
                $('#modal-listnobuk').modal({
                    show: false,
                    backdrop: false
                });
                alert('Nomor Terbit anda biarkan kosong?');
                $('#modal-listnobuk').modal({
                    show: false,
                    backdrop: false
                });
                $('#invoice').focus();
                event.preventDefault();
            }
            
            console.log('ENTER');
            $('#invoice').focus();
            event.preventDefault();
        }else{
            console.log('keyCode: '+event.keyCode);
        }
    });
    //--- END KODE FAKTUR

    //--- INVOICE
    /*
    $("#invoice").keydown(function(event) {

        if ( event.keyCode == 13 ) { //titik  atau backspace
            console.log('keyCode: '+event.keyCode);
        }else{
            if (event.keyCode < 48 || event.keyCode > 57 ) {
                event.preventDefault(); 
            }
        }
    });
    $("#invoice").keypress(function(event) {
        if(event.keyCode == 13 || event.keyCode == 9 ) { 
            console.log('ENTER');
            $('#potong').focus();
        }else{
            console.log('keyCode: '+event.keyCode);
        }
    });*/
    $("#invoice").keypress(function(event) {
        $('#modal-listnobuk').modal('hide');
        if(event.keyCode == 9 ) { 
            if($(this).val().length === 0){
                $('#modal-listnobuk').modal({
                    show: false,
                    backdrop: false
                });
                alert('Nomor Invoice anda biarkan kosong?');
                $('#modal-listnobuk').modal({
                    show: false,
                    backdrop: false
                });
                $('#potong').focus();
                event.preventDefault();
            }
            
            console.log('ENTER');
            $('#potong').focus();
            event.preventDefault();
        }else{
            console.log('keyCode: '+event.keyCode);
        }
    });
    //--- END INVOICE

    //--- INVOICE
    /*
    $("#potong").keydown(function(event) {

        if ( event.keyCode == 13 ) { //titik  atau backspace
            console.log('keyCode: '+event.keyCode);
        }else{
            if (event.keyCode < 48 || event.keyCode > 57 ) {
                event.preventDefault(); 
            }
        }
    });
    $("#potong").keypress(function(event) {
        if(event.keyCode == 13 || event.keyCode == 9 ) { 
            console.log('ENTER');
            $('#volume').focus();
        }else{
            console.log('keyCode: '+event.keyCode);
        }
    });
    */
    $("#potong").keypress(function(event) {
        $('#modal-listnobuk').modal('hide');
        if(event.keyCode == 9 ) { 
            if($(this).val().length === 0){
                $('#modal-listnobuk').modal({
                    show: false,
                    backdrop: false
                });
                alert('Nomor Invoice anda biarkan kosong?');
                $('#modal-listnobuk').modal({
                    show: false,
                    backdrop: false
                });
                $('#volume').focus();
                event.preventDefault();
            }
            
            console.log('ENTER');
            $('#volume').focus();
            event.preventDefault();
        }else{
            console.log('keyCode: '+event.keyCode);
        }
    });
    //--- END INVOICE

    //--- VOLUME
    /*
    $("#volume").keydown(function(event) {

        if ( event.keyCode == 13 ) { //titik  atau backspace
            console.log('keyCode: '+event.keyCode);
        }else{
            if (event.keyCode < 48 || event.keyCode > 57 ) {
                event.preventDefault(); 
            }
        }
    });
    $("#volume").keypress(function(event) {
        if(event.keyCode == 13 || event.keyCode == 9 ) { 
            console.log('ENTER');
            $('#debit').focus();
        }else{
            console.log('keyCode: '+event.keyCode);
        }
    });
    */
    $("#volume").keypress(function(event) {
        $('#modal-listnobuk').modal('hide');
        if(event.keyCode == 9 ) { 
            if($(this).val().length === 0){
                $('#modal-listnobuk').modal({
                    show: false,
                    backdrop: false
                });
                alert('Nomor Invoice anda biarkan kosong?');
                $('#modal-listnobuk').modal({
                    show: false,
                    backdrop: false
                });
                $('#debit').focus();
                event.preventDefault();
            }
            
            console.log('ENTER');
            $('#debit').focus();
            event.preventDefault();
        }else{
            console.log('keyCode: '+event.keyCode);
        }
    });
    //--- END VOLUME

    //--- DEBIT
    /*
    $("#debit").keydown(function(event) {

        if ( event.keyCode == 13 ) { //titik  atau backspace
            console.log('keyCode: '+event.keyCode);
        }else{
            if (event.keyCode < 48 || event.keyCode > 57 ) {
                event.preventDefault(); 
            }
        }
    });
    $("#debit").keypress(function(event) {
        if(event.keyCode == 13 || event.keyCode == 9 ) { 
            console.log('ENTER');
            $('#kredit').focus();
        }else{
            console.log('keyCode: '+event.keyCode);
        }
    });
    */
    $("#debit").keypress(function(event) {
        $('#modal-listnobuk').modal('hide');
        if(event.keyCode == 9 ) { 
            if($(this).val().length === 0){
                $('#modal-listnobuk').modal({
                    show: false,
                    backdrop: false
                });
                alert('Nomor Invoice anda biarkan kosong?');
                $('#modal-listnobuk').modal({
                    show: false,
                    backdrop: false
                });
                $('#kredit').focus();
                event.preventDefault();
            }
            
            console.log('ENTER');
            $('#kredit').focus();
            event.preventDefault();
        }else{
            console.log('keyCode: '+event.keyCode);
        }
    });
    //--- END 
    //--- KREDIT
    /*
    $("#kredit").keydown(function(event) {

        if ( event.keyCode == 13 ) { //titik  atau backspace
            console.log('keyCode: '+event.keyCode);
        }else{
            if (event.keyCode < 48 || event.keyCode > 57 ) {
                event.preventDefault(); 
            }
        }
    });
    $("#kredit").keypress(function(event) {
        if(event.keyCode == 13 || event.keyCode == 9 ) { 
            console.log('ENTER');
            $('#uraian').focus();
        }else{
            console.log('keyCode: '+event.keyCode);
        }
    });
    */
    $("#kredit").keypress(function(event) {
        $('#modal-listnobuk').modal('hide');
        if(event.keyCode == 9 ) { 
            if($(this).val().length === 0){
                $('#modal-listnobuk').modal({
                    show: false,
                    backdrop: false
                });
                alert('Nomor Invoice anda biarkan kosong?');
                $('#modal-listnobuk').modal({
                    show: false,
                    backdrop: false
                });
                $('#uraian').focus();
                event.preventDefault();
            }
            
            console.log('ENTER');
            $('#uraian').focus();
            event.preventDefault();
        }else{
            console.log('keyCode: '+event.keyCode);
        }
    });
    //--- END 

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

            //////
            $.ajax({
                type: "POST",
                url: "../jurnal/getLastNoBuk/"+$('#kd_jenis').val(),
                data: '',
                dataType: "json",
                success: function (response, textStatus) {
                    $('#last_nobuk1').html('Last Number: <b>'+response.last_num+'</b>');
                    /*if(response.kbm=='M'){
                        $('#last_nobuk1').html('LAST_MEMORIAL: '+response.last_num);
                        $('#last_nobuk2').html('');
                    }else{
                        $('#last_nobuk1').html('LAST_KAS: <i>'+response.b_kas+'</i>');
                        $('#last_nobuk2').html('LAST_BANK: <i>'+response.b_bank+'</i>');
                    }*/
                    
                    console.log(response.last_num);
                },
                error: function (xhr, textStatus, errorThrown) {
                    alert("Error: " + (errorThrown ? errorThrown : xhr.status));
                }
            });
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
	
    $("#kd_nasabah").keyup(function(e){
        //alert(coa_exist);
        if($(this).val()==''){
            $('#desc_nasabah').text('');
        }
    });
    $("#kd_custmer").keyup(function(e){
        //alert(coa_exist);
        if($(this).val()==''){
            $('#desc_customer').text('');
        }
    });
    $("#kd_sumberdaya").keyup(function(e){
        //alert(coa_exist);
        if($(this).val()==''){
            $('#desc_sumberdaya').text('');
        }
    });

	$("#debit").keydown(function(event) {
		$(this).dblclick();
		if(coa_exist==0){
		//	$("#btn-tambah").prop( "disabled", true );	
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
            createCookie('is_mode','',1);
            createCookie('is_edit_nobukti','',1);
            createCookie('is_edit_tanggal','',1);
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
        }
        
    });

    $('#btn-simpan_').on('click',function() {
        $('#form-input').attr('action', "simpan");
        var form=$("#form-input");
        $.ajax({
            type:"POST",
            url: form.attr("action"),
            data: form.serialize(),
            success: function(res){
                console.log(res);  
                //alert(res);
                if(res.msg === 'QC_PASSED') {
                    console.log(res.msg);
                    $('#form-input').attr('action', "../jurnal/simpan");
                    var form=$("#form-input");
                    if($( '#no_bukti' ).val()=='000000' || $( '#no_bukti' ).val()==' ' || $( '#no_bukti' ).val()=='')
                    {
                        alert('Nomor bukti belum di-isi. Harap isi lebih dahulu!');
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
                                        $('#lbl_nobukti').text('');
                                } else {
                                    console.log(res.msg+' :: '+res.nobuk);
                                    alert(res.msg);
                                    //alert('Ada Kesalahan! Harap Periksa kembali/Hubungi administrator system anda.')
                                }
                            }
                        }); 
                    }   
                } else {
                    alert('Ada Kesalahan! Harap Periksa kembali/Hubungi administrator system anda.')
                }
            }
        });

        
	});

    $('#btn-simpan').on('click',function() {

        $('#form-input').attr('action', "../jurnal/simpan");
        var form=$("#form-input");
        if($( '#no_bukti' ).val()=='000000' || $( '#no_bukti' ).val()==' ' || $( '#no_bukti' ).val()=='')
        {
            alert('Nomor bukti belum di-isi. Harap isi lebih dahulu!');
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
                            $('#lbl_nobukti').text('');
                    } else {
                        alert('Ada Kesalahan! Harap Periksa kembali/Hubungi administrator system anda.')
                    }
                }
            });

            $.post(
                '<?=base_url()?>index.php/gen_coacom',
                null,
                function(respon) {
                    if(respon.msg == 'Updated'){
                        //alert('Proses Update Data Berhasil\r\n'+respon.new+ ' has been added');
                        console.log(respon.new+ ' has been added of coa commonly usage.');
                    }else{
                        console.log(respon.msg);
                    }
                }
            );

        }   
    });


	$('#btn-tambah').on( 'click', function () {
		var nobukti = $('#lbl_nobukti').text();
        var totIndex = oTable.fnSettings().fnRecordsTotal();

        $.ajax({
            type:"POST",
            url: '../jurnal/cek_dentry',
            data: {"nobukti": nobukti},
            success: function(res){
                console.log(res.msg+'::'+res.pesan);  
                //alert(res);
                if(res.msg === 'aya_euy'){
                    alert(res.pesan); 
                    $('#btn-simpan').prop('disabled',true);
                } 
                if(res.msg === 'teu_aya'){
                    //alert(res.pesan); 
                    console.log(res.pesan);
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown){
                console.log(errorThrown);
            }

        }).fail(function (jqXHR, textStatus, error) {
            console.log(jqXHR.responseText);
        }); 

        console.log( 'row count: '+oTable.fnSettings().fnRecordsTotal() );

        
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
	                
                    console.log( 'row index: '+row_index );
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
                        $('#kd_coa').focus();
                    }else if(coa == ''){
                        alert('Kode Coa Wajib diisi');
                        $('#kd_coa').focus();
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

                        _Debit = $('#debit').val();
                        _Kredit = $('#kredit').val();

                        if(_Debit=='' || _Debit == NaN){
                            $('#debit').val(0);
                            alert('Kolom Debit tidak boleh kosong/dibawah nol');
                        }else if(_Kredit=='' || _Kredit == NaN){
                            $('#kredit').val(0);
                            alert('Kolom Kredit tidak boleh kosong/dibawah nol');
                        }else{
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
	                }
	            }else{
	            	//var vD = $('#vjDebit').text($("#debit").val());
	            	//alert('bodong');

	                
	                _Debit = $('#debit').val();
	                _Kredit = $('#kredit').val();

	                if(_Debit=='' || _Debit == NaN){
                        $('#debit').val(0);
	                	alert('Kolom Debit tidak boleh kosong/dibawah nol');
	                }else if(_Kredit=='' || _Kredit == NaN){
                        $('#kredit').val(0);
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
        	console.log('Row Index: '+idx);
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
        	
            //alert(idx);

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
                          '<a href="#" class="row-delete" data-toggle="tooltip" title="Delete data"><span class="glyphicons glyphicons-bin"></span></a>  &nbsp;&nbsp;&nbsp;'+
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
    var count = 0;
	function fnClickAddRow() 
    {
        var currentPage = table.page();
        var counter = 1;

        
        var index = table.row(this).index(),
        rowCount = table.data().length+1,
        insertedRow = table.row(rowCount).data(),
        tempRow;

        console.log( 'row index: '+index);
        console.log( 'rowCount: '+rowCount);
        console.log( 'insertedRow: '+insertedRow);

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
        var vdebit          = $('#debit').val();  
        var vkredit         = $('#kredit').val(); 
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

        var kdtahap         = $('#kd_tahap').val();

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
                                kdtahap         + l_thp + '<input type="hidden" name="kode_tahap[]" id="kode_tahap[]" value="'+$('#kd_tahap').val()+'"/>', 
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
                                                  '<a href="#" class="row-delete" data-toggle="tooltip" title="Delete data"><span class="glyphicons glyphicons-bin"></span></a> &nbsp;&nbsp;&nbsp;'+
                                                  '<a href="#" class="row-duplicate" data-toggle="tooltip" title="Duplicate this data"><span class="glyphicons glyphicons-playing_dices"></span></a> ' ] )
                            .order( [[ 1, 'asc' ]] )
                            .draw(false)
                            .node();

            $( "#btn-tambah" ).prop( "disabled", true );
            $( "#debit" ).prop( "disabled", false );
            $( "#kredit" ).prop( "disabled", false );
            //counter++;
            //table.page(currentPage).draw();
            
            resetBoks();
            table.page(currentPage).draw();
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
	    $('#desc_sumberdaya').text('');
	    //$('#desc_spk').text('');
	    $('#desc_tahap').text('');
	    $('#desc_bank').text('');

                        $('#req_tahap').text('');
                        $('#kd_tahap').removeClass('required');
                        $('#r_tahap').css('color','');

                        $('#req_nasabah').text('');
                        $('#kd_nasabah').removeClass('required');
                        $('#r_nasabah').css('color','');

                        $('#req_pajak').text('');
                        $('#kd_faktur').removeClass('required');
                        $('#r_faktur').css('color','');

                        $('#req_sbdy').text('');
                        $('#kd_sumberdaya').removeClass('required');
                        $('#r_sbdy').css('color','');

                        $('#req_bank').text('');
                        $('#kd_bank').removeClass('required');
                        $('#r_bank').css('color','');

        //sum_debitkredit();
	}

    function cekAndEnableButtonAdd(){
        var nt = $('#no_terbit').val();  
        var kf = $('#kd_faktur').val();  
        var iv = $('#invoice').val(); 
        var dr = $('#debit').val();  
        var cr = $('#kredit').val(); 
        var vl = $('#volume').val(); 
        var bp = $('#potong').val();
        var ur = $('#uraian').val();
        var ak = $('#kd_coa').val();
        var kn = $('#kd_nasabah').val();
        var kc = $('#kd_customer').val();
        var ks = $('#kd_sumberdaya').val();
        var kp = $('#kd_tahap').val();
        var kb = $('#kd_bank').val();
        var da = $('#desc_coa').text();
        var dn = $('#desc_nasabah').text();
        var dc = $('#desc_customer').text();
        var ds = $('#desc_sumberdaya').text();
        var dt = $('#desc_tahap').text();
        var db = $('#desc_bank').text();

        if(nt!=='' || kf!=='' || iv!=='' || dr!=='' || cr!=='' || vl!=='' || 
           bp!=='' || ur!=='' || ak!=='' || kn!=='' || kc!=='' || ks!=='' || 
           kt!=='' || kp!=='' || kb!=='' || da!=='' || dn!=='' || dc!=='' || 
           ds!=='' || dt!=='' || db!=='' ){
            $("#btn-tambah" ).prop( "enabled", true );
        }else{
            $("#btn-tambah" ).prop( "enabled", false );
        }

    }

</script>