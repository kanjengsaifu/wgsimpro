<script type="text/javascript">
jQuery(document).ready(function() {
	// init plugins
	$('.input-date').datetimepicker({
		minViewMode: 'months',
		pickTime: false,
		format: 'MM/YYYY'
	});
	var table = $('#datatable').DataTable();
	alert('tess');
	$.getJSON( "http://localhost/wgprop/index.php/jurnal/json_nobuk", function( data ) {
		var items = [];
	  	$.each( data, function( key, val ) {
	  		//alert(key + ': '+val);
	  		console.log(val['kd_coa']);
	  		table.row.add([
		       val['kd_coa'],
		       val['kd_nasabah'],
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
		       val['vol'],
		       val['keterangan'],
		       val['aksi']
		    ]).draw();
	    	
	  	});
	});
});
</script>
