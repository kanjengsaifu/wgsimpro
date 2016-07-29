<script type="text/javascript">
	// init plugins
    $('.chosen-select').chosen({
		width: '100%',
		allow_single_deselect: true,
		search_contains: true
	});
    // events
    $('#btn-filter').click(function() {
        $('#datatable tbody tr').removeClass('hidden');
        if($('#type_property').val()!=='')
            $('#datatable tbody tr[data-type_property!="'+$('#type_property').val()+'"]').addClass('hidden');
        if($('#tower_cluster').val()!=='')
            $('#datatable tbody tr[data-tower_cluster!="'+$('#tower_cluster').val()+'"]').addClass('hidden');
        if($('#lantai_blok').val()!=='')
            $('#datatable tbody tr[data-lantai_blok!="'+$('#lantai_blok').val()+'"]').addClass('hidden');
        if($('#no_unit').val()!=='')
            $('#datatable tbody tr[data-no_unit!="'+$('#no_unit').val()+'"]').addClass('hidden');
    });
</script>
