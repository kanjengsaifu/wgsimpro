
<script type="text/javascript">

jQuery(document).ready(function() {
	// init plugins
	$('.input-date').datetimepicker({
		minViewMode: 'months',
		pickTime: false,
		format: 'MM/YYYY'
	});
});

function transfer(id,namafile,periode,kodeenti) {
    //document.getElementById("demo").innerHTML = "Hello World";
	//alert(id+'|'+namafile);
	/*
	$.ajax({
		   type: "POST",
		   data: {'periode':JSON.stringify(perio)},
		   url: "./generate",
		   success: function(msg){
				location.reload(); 
		   }
		});
	*/
	filenya='<?=base_url()?>assets/generate/'+namafile;
	
				$.ajax({
				type: 'POST',
				url: '<?=base_url()?>index.php/export-import/porta',
				enctype: 'multipart/form-data',
				data: {
					filedata:filenya,
					periode: periode,
					kode_entity: kodeenti 
				},
				dataType: 'json',
				complete: function(data) {  
					
					window.location.assign(filenya);
				/*
				
					if (typeof data.responseJSON === 'object') {
						if (data.responseJSON.response == 'success') {

							$messageSuccess.removeClass('hidden');
							$messageError.addClass('hidden');

							// Reset Form
							$form.find('.form-control')
								.val('')
								.blur()
								.parent()
								.removeClass('has-success')
								.removeClass('has-error')
								.find('label.error')
								.remove();

 							if (($messageSuccess.offset().top - 80) < $(window).scrollTop()) {
								$('html, body').animate({
									scrollTop: $messageSuccess.offset().top - 80
								}, 300);
							} 

							$submitButton.button('reset');
							
							return;

						}
					}

					$messageError.removeClass('hidden');
					$messageSuccess.addClass('hidden');

					if (($messageError.offset().top - 80) < $(window).scrollTop()) {
						$('html, body').animate({
							scrollTop: $messageError.offset().top - 80
						}, 300);
					}

					$form.find('.has-success')
						.removeClass('has-success');
						
					$submitButton.button('reset');
					*/
				}
			});
}

$('#btn-submit').click(function() {
	
	perio=$("#periode").val(); 	
	//alert(perio);
		$.ajax({
		   type: "POST",
		   data: {'periode':JSON.stringify(perio)},
		   url: "./generate",
		   success: function(msg){
				location.reload(); 
		   }
		});
  });

	// init action fn
	var action = function(act, id) {
		if(act==='edit') {
			location.href = "<?=base_url()?>index.php/rab-btl/edit/"+id;
		} else if(act==='delete') {
			if(confirm("Anda yakin akan menghapus data ini?")) {
				$.post("<?=base_url()?>index.php/rab-btl/delete/"+id,function(ev) {
					if(ev.response==='1') {
						alert('Data berhasil dihapus.');
						location.href = "<?=base_url()?>index.php/rab-btl";
					} else {
						alert('Data gagal dihapus, mohon diperiksa.');
					}
				});
			}
		}
	};
	// init plugins
	/*$('#datatable').dataTable({
		"bServerSide":true,
		"bProcessing":true,
		"sPaginationType": "full_numbers",
		"bFilter":true,
		"sServerMethod": "POST",
		"sAjaxSource": "<?=base_url()?>index.php/rab-btl/DT",
		"columns": [
			{ "name": "kode_coa" },
			{ "name": "kode_sumberdaya" },
			{ "name": "harga" },
			{ "name": "harga_rev" },
			{ "name": "rolling" },
			{ "searchable": false, "sortable": false }
		]
	});*/
</script>
