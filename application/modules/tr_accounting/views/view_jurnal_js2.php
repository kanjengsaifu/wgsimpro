<script type="text/javascript" src="<?=base_url()?>assets/vendor/plugins/datatables/extensions/ReloadAjax/js/dataTables.reloadAjax.min.js"></script>
<script src="<?=base_url()?>assets/vendor/plugins/table2excel/jquery.table2excel.js"></script>
<script type="text/javascript" src="http://mottie.github.io/tablesorter/js/jquery.tablesorter.js"></script>
<script type="text/javascript" src="http://mottie.github.io/tablesorter/js/jquery.tablesorter.widgets.js"></script>
<script type="text/javascript" src="https://mottie.github.io/tablesorter/addons/pager/jquery.tablesorter.pager.js"></script>

<script type="text/javascript">

var table = null;
var loadJurnal = function() {
  var periode = $('#periode').val(),
    arrPer = periode.split('/'),
    bln = arrPer[0],
    thn = arrPer[1],
    groupBy = $('#group_by').val();
    if($('#group_by').val()==''){
        $('#datatable').dataTable().fnReloadAjax('<?=base_url()?>index.php/jurnal/DT/'+bln+'-'+thn);
    }else{
        $('#datatable').dataTable().fnReloadAjax('<?=base_url()?>index.php/jurnal/vjurnal_dt/'+bln+'-'+thn+'/'+groupBy);
    }
    
};
  $(document).ready( function () {
    $('.input-date').datetimepicker({
    minViewMode: 'months',
    pickTime: false,
    format: 'MM/YYYY'
  });
    $('body').addClass('sb-l-m');
    var periode = $('#periode').val(),
        arrPer = periode.split('/'),
        bln1 = arrPer[0],
        thn1 = arrPer[1];

  $('#modal-list_nobuk').modal({
        show: false,
        backdrop: false
    });
  $('#modal-list_nobuk').modal({
        show: false,
        backdrop: false
  });
  $('#modal-listnobuks').modal({
      show: false,
      backdrop: false
  });



  $('#btn-v_listnobuk').on('click', function(){
      $('#modal-listnobuks').modal('show');
        
  });

  $('#btn_periode_nobuk').on('click',function(){
      var periode = $('#tgl_periode_list').val(),
            v_jenis = $('#v_jenis').val(),
            arrPer = periode.split('/'),
            tgl = arrPer[2],
            bln = arrPer[1],
            thn = arrPer[0];
        if(v_jenis ==''){
            alert('Harap pilih dahulu jenis jurnal');
        }else{
            $.ajax({
                type:"POST",
                //url: '../jurnal/listNoBuk/'+$("#kd_jenis").val()+'/'+thn+'-'+bln+'-'+tgl,
                data: {"nobukti": ''},
                success: function(res){
                    $('#tb_listnobuk').empty();
                    $.get('../jurnal/listViewNoBuk/'+v_jenis+'/'+thn+'-'+bln+'-'+tgl, function(html) { 
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

  /*var t_listnobuk =$('#datatable-listnobuk').DataTable({
    "bServerSide":true,
    "bProcessing":true,
    "sPaginationType": "full_numbers",
    "bFilter":true,
    "sServerMethod": "POST",
    "ajax": "<?=base_url()?>index.php/jurnal/listNoBuk/A",
    "columns": [
      { "name": 0 }
    ]
  });*/

  $('#btnlistnobuk').on('click', function(){
    $('#modal-list_nobuk').modal('show');
  });
  $('#btn-close').on('click', function(){
    $('#modal-list_nobuk').modal('hide');
  });

  $('[data-toggle="tooltip"]').tooltip(); 

  $('#exp2excel').on('click', function(){
        $('.export2excel').table2excel({
            exclude: ".noExl",
            name: "VIEWJURNAL",
            filename: "VIEW_JURNAL_"+periode,
            exclude_img: true,
            exclude_links: true,
            exclude_inputs: true
        });
    });
  table =$('#datatable').DataTable({
      "bServerSide": true,
      "bProcessing": true,
      "lengthMenu": [[10, 25, 50, 100, 200, 500, 99999], [10, 25, 50, 100, 200, 500, 'All']],
      "sPaginationType": "full_numbers",
      "bSortable": true,
      "sServerMethod": "POST", 
      "bInfo": false,
      "bRetrieve": true,
      "ordering": true,
      "orderMulti": true,
      "columnDefs": [ { "visible": true, "targets": 0 } ],
      "order": [[ 0, 'desc' ]],
      "aaSorting": [[0, 'desc'],[1, 'desc']],
      "drawCallback": function ( settings ) {
        if( $('#group-switch').is(':checked') ) {
          var api = this.api();
          var rows = api.rows( {page:'current'} ).nodes();
          var last=null;
          //var cell = table.cell( this );
          //var dtval = cell.data( cell.data() + 1 ).draw();
          api.column(0, {page:'current'} ).data().each( function ( group, i ) {
            console.log(group);
              if ( last !== group ) {
                  $(rows).eq( i ).before(
                      '<tr class="group">'+
                      '   <td colspan="14">'+
                      '     <table> '+
                      '       <!--td><input name="no_bukti[]" id="no_bukti[]" type="radio" value="'+group+'">&nbsp;&nbsp;</td-->'+
                      '       <td><b><h5>'+group+'</h5></b></td> '+
                      '       <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+
                      '           <a href="javascript:" class="row-edit" data-toggle="tooltip" title="Edit Nomor Bukti" data-val="'+group+'" tgl-val="'+this.column(1).data().reduce( function (tanggal) { return tanggal; })+'"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp;&nbsp;'+
                      '           <a href="javascript:" class="row-delete" data-toggle="tooltip" title="Hapus per-Nomor Bukti" data-val="'+group+'"><span class="glyphicon glyphicon-trash"></span></a>'+
                      '       </td> '+
                      '     </table> '+
                      '   </td> '+
                      '</tr>'
                  );
                  last = group;
              }
          });
        }
      },
      "sAjaxSource": '<?=base_url()?>index.php/jurnal/DT',
      "createdRow": function ( row, data, index ) {
            $('td', row).eq(0).addClass('highlight');
            console.log(data[11])
            if(data[11] == null){
              
            }else{
              if ( data[11].replace(/[\$,]/g, '') * 1 > 0 ) {
                $('td', row).eq(11).addClass('highlight');
              }
              if ( data[12].replace(/[\$,]/g, '') * 1 > 0 ) {
                  $('td', row).eq(12).addClass('highlight');
              }
            }
            
        },
      "aoColumns": [
          { "name": "no_bukti", "class": "text-center", "width": "100px", "bSortable": false },
          { "name": "tanggal", "class": "text-center", "width": "60px", "bSortable": false },
          { "name": "kode_coa", "class": "text-center", "width": "40px", "bSortable": false },
          { "name": "keterangan", "class": "text-left","width": "150px", "bSortable": false },
          { "name": "kode_nasabah", "class": "text-center", "width": "100px", "bSortable": false },
          { "name": "kode_sumberdaya", "class": "text-center", "width": "100px", "bSortable": false },
          { "name": "kode_spk", "class": "text-center", "width": "100px", "bSortable": false },
          { "name": "kode_tahap", "class": "text-center", "width": "100px", "bSortable": false },
          { "name": "no_invoice", "class": "text-center", "width": "100px", "bSortable": false },
          { "name": "kode_faktur", "class": "text-center", "width": "100px", "bSortable": false },
          { "name": "volume", "class": "text-right", "width": "100px", "bSortable": false },
          { "name": "debet", "class": "text-right", "width": "100px", "bSortable": false },
          { "name": "kredit", "class": "text-right", "width": "100px", "bSortable": false },
          { "name": "volume", "class": "text-right", "width": "100px", "bSortable": false}
        ]

    });

    function dt_tgl(){
      table
          .column( 1 )
          .data()
          .reduce( function (tanggal) {
              return tanggal;
          } );
    }
    function createCookie(name, value) {
        var date = new Date();
        date.setTime(date.getTime()+(1120*1000));
        var expires = "; expires="+date.toGMTString();

       document.cookie = name+"="+value+expires+"; path=/";
    }
    $('body').on('click','.row-edit',function(){
        if(confirm('Nomor Bukti ini akan diedit ulang?')) {
            var id = $(this).attr('data-val');
            var tgl = $(this).attr('tgl-val');
            $('#no_bukti').val(id);
            $('#tanggal').val(tgl);
            $('#go-edit-jurnal').attr('action', "<?=base_url()?>index.php/jurnal-entry/edit");
            createCookie('is_edit_nobukti',id);
            createCookie('is_edit_tanggal',tgl);
            //createCookie('is_mode','edit');
            //var form=$("#form-input"); 
            $("#go-edit-jurnal").submit();
        }else{
            $('#no_bukti').val('');
        }
    });
    $('body').on('click','.row-delete',function(){
        if(confirm('Anda yakin Nomor Bukti ini akan dihapus?')) {
            var id = $(this).attr('data-val');
            
            $.post('del_nobuk/',{ no_bukti: id }).done(function( data ){

                //alert( "Data Loaded: " + data );
                loadJurnal();
                //table.ajax.reload();
                //table.draw();
            });
        }
    });
    $('#group-switch').change(function() {
        if($(this).is(':checked')) {
             table
                .columns( 0 )
                .visible( false )
                .draw();
          }
           else {
            table
                .columns( 0 )
                .visible(true)
                .draw();
          }
    });
    
    $('#btn-submit').click(function() {
        loadJurnal();
        //table.ajax.reload();
        //table.draw();
      
    });
      $('#show_kolom').on('change',function(){
        $( "select option:selected" ).each(function() {
            fnShowHide($( this ).val());
          });
      });
      $('#show_kolom').multiselect({
          buttonClass: 'multiselect dropdown-toggle btn btn-sm btn-primary btn-block'
      });
      function fnShowHide( iCol )
      {
        //var oTable = $('#datatable').DataTable();
        
        var bVis = oTbl.fnSettings().aoColumns[iCol].bVisible;
        oTbl.fnSetColumnVis( iCol, bVis ? false : true );
      }
  });

</script>

