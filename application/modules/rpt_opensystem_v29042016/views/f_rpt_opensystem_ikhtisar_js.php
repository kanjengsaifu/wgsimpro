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

    $('#exp2excel').on('click', function(){
        $('.export2excel').table2excel({
            exclude: ".noExl",
            name: "IKHTISAR_OS",
            filename: "LAPORAN_<?=str_replace('','',strtoupper(str_replace('[tag] ', 'IKHTISAR ', $data['title_lap']['judul_halaman']) ) ).'_'.trim(strtoupper($data['periode']) )?>",
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