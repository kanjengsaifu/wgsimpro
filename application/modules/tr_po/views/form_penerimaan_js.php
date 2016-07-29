<script type="text/javascript" language="javascript" class="init">


// function format ( d ) {
	// return 'Nama Customer: '+d.nsb_nama+'<br>'+
	    // 'Total Piutang: '+d.salary+'<br>'+
		// '----';
// }

// $(document).ready(function() {
	// $('#example').dataTable( {
		// "columnDefs": [ 
			// {
				// "targets": [ 3],
				// "visible": true,
				// "searchable": true
			// },
			// {
				// "targets": [ 3 ],
				// "visible": true
			// }
		// ]
	// } );
	// var dt = $('#example').DataTable( {
		// "processing": true,
		// "serverSide": true,
		// "ajax": "sales-stock/kartu-piutang/gen_kartu_piutang/",
		// "columns": [ 
			// {
				// "class":          "details-control",
				// "orderable":      false,
				// "data":           2015,
				// "defaultContent": ""
			// },
			// { "data": "nsb_nama" },
			// { "data": "position" },
			// { "data": "office" }
		// ],
		// "order": [[1, 'asc']]
	// } );

	// // Array to track the ids of the details displayed rows
	// var detailRows = [];

	// $('#example tbody').on( 'click', 'tr td:first-child', function () {
		// var tr = $(this).closest('tr');
		// var row = dt.row( tr );
		// var idx = $.inArray( tr.attr('id'), detailRows );

		// if ( row.child.isShown() ) {
			// tr.removeClass( 'details' );
			// row.child.hide();

			// // Remove from the 'open' array
			// detailRows.splice( idx, 1 );
		// }
		// else {
			// tr.addClass( 'details' );
			// row.child( format( row.data() ) ).show();

			// // Add to the 'open' array
			// if ( idx === -1 ) {
				// detailRows.push( tr.attr('id') );
			// }
		// }
	// } );

	// // On each draw, loop over the `detailRows` array and show any child rows
	// dt.on( 'draw', function () {
		// $.each( detailRows, function ( i, id ) {
			// $('#'+id+' td:first-child').trigger( 'click' );
		// } );
	// } );
// } );

	</script>
