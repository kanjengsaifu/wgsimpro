<script src="<?=base_url()?>assets/vendor/plugins/table2excel/jquery.table2excel.js"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
	$('body').addClass('sb-l-m');

	$('#exp2excel').on('click', function(){
		$('.export2excel').table2excel({
			exclude: ".noExl",
			name: "LABARUGI",
			filename: "LAPORAN_LABARUGI_<?=trim($data['periode'])?>",
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