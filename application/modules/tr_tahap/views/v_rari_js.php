<script type="text/javascript" src="<?=base_url()?>assets/vendor/plugins/datatables/extensions/ReloadAjax/js/dataTables.reloadAjax.min.js"></script>

<script type="text/javascript">

var table = null;
var loadJurnal = function() {
  var periode = $('#periode').val(),
    arrPer = periode.split('-'),
    bln = arrPer[0],
    thn = arrPer[1];
    $('#datatable').dataTable().fnReloadAjax('<?=base_url()?>index.php/rpt-rari/dt/'+periode);
};
  $(document).ready( function () {
    $('.input-date').datetimepicker({
    minViewMode: 'months',
    pickTime: false,
    format: 'MM-YYYY'
  });
 
    $('#btn-submit').click(function() {
      var target = $('#target').val(),
        periode = $('#periode').val();
        //kdcoa = $('#kode_coa option:selected').val();
        //divisi = $('#div_id').val();
      
        window.open('<?=base_url()?>index.php/tahap/rpt-rari/'+periode);
    });

    $('body').addClass('sb-l-m');
    var periode = $('#periode').val(),
        arrPer = periode.split('-'),
        bln1 = arrPer[0],
        thn1 = arrPer[1];


  $('[data-toggle="tooltip"]').tooltip(); 
  $('#show_biaya').multiselect({
        buttonClass: 'dropdown-toggle btn btn-sm btn-primary btn-block'
    });
  table =$('#datatable').DataTable({
      "bServerSide": true,
      "bProcessing": true,
      "sPaginationType": "full_numbers",
      "bFilter": true,
      "sServerMethod": "POST", 
      /*'ajax': {
        "type"   : "POST",
        "url"    : '<?=base_url()?>index.php/jurnal/DT2/',
        "data"   : {
              "bln" : bln1,
              "thn" : thn1
             },
        "dataSrc": "",
        "rowCallback": function( row, data, displayIndex ) {
          if ( $.inArray(data.DT_RowId, selected) !== -1 ) {
            $(row).addClass('selected');
          }
        }
      },
      'sColumns': [
        {"data" : "no_bukti"},
        {"data" : "tanggal"},
        {"data" : "kode_coa"},
        {"data" : "kode_nasabah"}
      ]*/
      "columnDefs": [ { "visible": true, "targets": 0 } ],
      "order": [[ 0, 'asc' ]],

      "sAjaxSource": '<?=base_url()?>index.php/jurnal/DT/',
      
      "aoColumns": [
          { "name": "grup", "class": "text-left", "width": "100px" },
          { "name": "kode_item", "class": "text-center", "width": "100px" },
          { "name": "nama_item", "class": "text-center", "width": "60px" },
          { "name": "kode_sd", "class": "text-center", "width": "40px" },
          { "name": "nama_sd", "class": "text-left","width": "150px" },
          { "name": "ra_vol", "class": "text-center", "width": "100px" },
          { "name": "ra_harga", "class": "text-right", "width": "100px" },
          { "name": "ri_vol", "class": "text-center", "width": "100px" },
          { "name": "ri_harga", "class": "text-right", "width": "100px" }
        ]

    });
  
  });

</script>

