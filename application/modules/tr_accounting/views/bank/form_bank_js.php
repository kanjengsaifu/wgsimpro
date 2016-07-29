<script type="text/javascript">
	jQuery(document).ready(function() {
		$('body').addClass('sb-l-m');

		var table = $('#t_bank').dataTable({
	        "bServerSide":true,
			"bProcessing":true,
			"bFilter":true,
			"sServerMethod": "POST",
			"iDisplayLength": 50,
			"sAjaxSource": "<?=base_url()?>index.php/jurnal/bank-out/voucher/dt",
			"columns": [
				{"name": "uraian"},
				{"name": "id_trx"},
				{"name": "kd_bank"},
				{"name": "no_rek"},
				{"name": "kd_cus"},
				{"name": "status"},
				{"name": "no_reserve"},
				{"name": "no_kuitansi"},
				{"name": "rupiah"},
				{"sortable": true, "searchable": true}
			]
	    });
	    /*var oTable = $('#t_bank').DataTable({
	        paging: false,
	    	searching: false,
	    	ordering: true,
	        info: false,
	        scrollY: "320px"
	    });*/
	    var counter = 1;
		$('#btn-add-row').on('click', function(e){

	        var uraian = '<input type="text" style="width: 100%;" name="uraian[]" id="uraian[]" value=""/>';
	        var id_trx = '<input type="text" style="width: 100%;" name="id_trx[]" id="id_trx[]" value=""/>';
	        var kd_bnk = '<input type="text" style="width: 100%;" name="kd_bnk[]" id="kd_bnk[]" value=""/>';
	        var no_rek = '<input type="text" style="width: 100%;" name="no_rek[]" id="no_rek[]" value=""/>';
	        var kd_cus = '<input type="text" style="width: 100%;" name="kd_cus[]" id="kd_cus[]" value=""/>';
	        var status = '<input type="text" style="width: 100%;" name="status[]" id="status[]" value=""/>';
	        var no_rsv = '<input type="text" style="width: 100%;" name="no_rsv[]" id="no_rsv[]" value=""/>';
	        var no_kui = '<input type="text" style="width: 100%;" name="no_kui[]" id="no_kui[]" value=""/>';
	        var rupiah = '<input type="text" style="width: 100%;" name="rupiah[]" id="rupiah[]" value=""/>';
	        var aksi   = '<a href="#" class="row-edit" data-toggle="tooltip" title="Edit data"><span class="glyphicons glyphicons-edit"></span></a>&nbsp;&nbsp;&nbsp;'+
                          '<a href="#" class="row-delete" data-toggle="tooltip" title="Delete data"><span class="glyphicons glyphicons-bin"></span></a>&nbsp;&nbsp;&nbsp;'+
                          '<a href="#" class="row-duplicate" data-toggle="tooltip" title="Duplicate this data"><span class="glyphicons glyphicons-playing_dices"></span></a> ';
		    var rowNode = table
		                    .row.add( [ counter, uraian , id_trx , kd_bnk , no_rek , kd_cus , status , no_rsv , no_kui , rupiah , aksi ] )
		                    .draw()
		                    .node();

		    counter++;
		});

		function addRow() 
	    {
	    	var counter = 1;

	        var uraian = '<input type="text" name="uraian[]" id="uraian[]" value=""/>';
	        var id_trx = '<input type="text" name="it_trx[]" id="it_trx[]" value=""/>';
	        var kd_bnk = '<input type="text" name="kd_bnk[]" id="kd_bnk[]" value=""/>';
	        var no_rek = '<input type="text" name="no_rek[]" id="no_rek[]" value=""/>';
	        var kd_cus = '<input type="text" name="kd_cus[]" id="kd_cus[]" value=""/>';
	        var status = '<input type="text" name="status[]" id="status[]" value=""/>';
	        var no_rsv = '<input type="text" name="re_rsv[]" id="re_rsv[]" value=""/>';
	        var no_kui = '<input type="text" name="no_kui[]" id="no_kui[]" value=""/>';
	        var rupiah = '<input type="text" name="rupiah[]" id="rupiah[]" value=""/>';
	        var aksi   = '<a href="#" class="row-edit" data-toggle="tooltip" title="Edit data"><span class="glyphicons glyphicons-edit"></span></a>&nbsp;&nbsp;&nbsp;'+
                          '<a href="#" class="row-delete" data-toggle="tooltip" title="Delete data"><span class="glyphicons glyphicons-bin"></span></a>&nbsp;&nbsp;&nbsp;'+
                          '<a href="#" class="row-duplicate" data-toggle="tooltip" title="Duplicate this data"><span class="glyphicons glyphicons-playing_dices"></span></a> ';
		    var rowNode = table
		                    .row.add( [ counter, uraian , id_trx , kd_bnk , no_rek , kd_cus , status , no_rsv , no_kui , rupiah , aksi ] )
		                    .draw()
		                    .node();

		    counter++;
	    }
	});

	

</script>