<script src="<?=base_url()?>assets/vendor/plugins/table2excel/jquery.table2excel.js"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
    $('body').addClass('sb-l-m');

    

    $('#exp2excel').on('click', function(){
      $('.export2excel').table2excel({
        exclude: ".noExl",
        name: "KASBANK",
        filename: "LAPORAN_KASBANK_<?=trim($data['periode'])?>",
        exclude_img: true,
        exclude_links: true,
        exclude_inputs: true
      });
    });

  });
</script>
