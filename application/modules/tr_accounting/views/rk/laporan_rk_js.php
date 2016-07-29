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
});
</script>
<script type="text/javascript">
$(window).load(function() {
    $(".loader").fadeOut("slow");
})
</script>