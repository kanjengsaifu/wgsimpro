<script src="<?=base_url()?>assets/vendor/plugins/table2excel/jquery.table2excel.js"></script>
<script type="text/javascript">
var table = null;
var loadJurnal = function() {
  var periode = $('#periode').val(),
    arrPer = periode.split('/'),
    bln = arrPer[0],
    thn = arrPer[1];
    $('#datatable').dataTable().fnReloadAjax('<?=base_url()?>index.php/jurnal/DT/'+bln+'-'+thn);
};


$(document).ready(function () { 
    $('body').addClass('sb-l-m');

     table = $('#datatablex').dataTable();
    //Initiate DataTable
    $('#datatable tbody').on('click', 'row-hide', function () {
        $('#kd_nas_').toggle('slow');
    });

    //auto merge row table
    /*var el = $("tr td:last-child");
      for(var i = 0; i < el.length; i++){
        if (el[i].innerHTML == el[i+1].innerHTML){
          el[i].setAttribute("rowspan","2");
          el[i+1].parentElement.removeChild(el[i+1])
        }
      }*/
    $('#exp2excel').on('click', function(){
        $('.export2excel').table2excel({
            exclude: ".noExl",
            name: "OPENSYSTEM",
            filename: "LAPORAN_APK_IKHTISAR_<?=trim(strtoupper($data['periode']) )?>",
            exclude_img: true,
            exclude_links: true,
            exclude_inputs: true
        });
    });
});
</script>
<script type="text/javascript">
$(window).load(function() {
    $(".loader").fadeOut("slow");
})
</script>