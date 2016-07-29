<script src="<?=base_url()?>assets/vendor/plugins/table2excel/jquery.table2excel.js"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
	$('body').addClass('sb-l-m');

	$('#exp2excel').on('click', function(){
		$('.export2excel').table2excel({
			exclude: ".noExl",
			name: "BUKUBESAR",
			filename: "LAPORAN_NERACA_T_<?=strtoupper(trim($data['periode']))?>",
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