<script type="text/javascript" src="<?=base_url()?>assets/vendor/plugins/datatables/extensions/ReloadAjax/js/dataTables.reloadAjax.min.js"></script>
<script type="text/javascript">
var oTbl = null;
var loadJurnal = function() {
	var periode = $('#periode').val(),
		arrPer = periode.split('/'),
		bln = arrPer[0],
		thn = arrPer[1];
	oTbl.fnReloadAjax('<?=base_url()?>index.php/jurnal/DT/'+bln+'-'+thn);
};
jQuery(document).ready(function() {
	// init plugins
	$('.input-date').datetimepicker({
		minViewMode: 'months',
		pickTime: false,
		format: 'MM/YYYY'
	});
	
	$('[data-toggle="tooltip"]').tooltip(); 

	oTbl = $('#datatable').dataTable({
		"bServerSide":true,
		"bProcessing":true,
		"bLengthChange": true,
		"sPaginationType": "full_numbers",
		"bFilter":true,
		"sServerMethod": "POST",
		"scrollX": true,
		// "bAutoWidth": true,
		"iDisplayLength": 30,
		"sAjaxSource": "<?=base_url()?>index.php/jurnal/DT/",
		"createdRow": function ( row, data, index ) {
            $('td', row).eq(0).addClass('highlight');

            if ( data[11].replace(/[\$,]/g, '') * 1 > 0 ) {
                $('td', row).eq(10).addClass('highlight');
            }
            if ( data[12].replace(/[\$,]/g, '') * 1 > 0 ) {
                $('td', row).eq(11).addClass('highlight');
            }
        },
		"columns": [
			{ "name": "no_bukti", "class": "text-center", "width": "100px" },
			{ "name": "tanggal", "class": "text-center", "width": "60px" },
			{ "name": "kode_coa", "class": "text-center", "width": "40px" },
			{ "name": "keterangan", "class": "text-left", "width": "150px" },
			{ "name": "kode_nasabah", "class": "text-center", "width": "100px" },
			{ "name": "kode_customer", "class": "text-center", "width": "100px" },
			{ "name": "kode_sumberdaya", "class": "text-center", "width": "100px" },
			{ "name": "kode_spk", "class": "text-center", "width": "100px" },
			{ "name": "kode_tahap", "class": "text-center", "width": "100px" },
			{ "name": "no_invoice", "class": "text-center", "width": "100px" },
			{ "name": "kode_faktur", "class": "text-center", "width": "100px" },
			{ "name": "volume", "class": "text-right", "width": "100px" },
			{ "name": "debet", "class": "text-right", "width": "100px" },
			{ "name": "kredit", "class": "text-right", "width": "100px" }
		]
	}).rowGrouping({
			bExpandableGrouping: true,
			iGroupingColumnIndex: 0,
			sGroupingColumnSortDirection: "asc",
			iGroupingOrderByColumnIndex: 0
	});
	 $('body').on('click','.row-edit',function(){
        if(confirm('Nomor Bukti ini akan diedit ulang?')) {
            var id = $(this).attr('data-val');
            location.href = 'edit/'+id;
        }
    });
    $('body').on('click','.row-delete',function(){
        if(confirm('Anda yakin Nomor Bukti ini akan dihapus?')) {
            var id = $(this).attr('data-val');
            $.get('jurnal/eidt/'+id);
            tabe.ajax.reload();
        }
    });
	$('body').addClass('sb-l-m');

	$('#btn-submit').click(function() {
		loadJurnal();
	});
});
</script>
