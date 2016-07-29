
<script>
    $(document).ready(function()
    {
        $('#periode').datetimepicker({
            minViewMode: 'months',
            pickTime: false,
            format: 'MM-YYYY'
        });
        //alert($("#notify").attr('class'));
        if($("#notify").attr('class')=='success'){
            $('#btn-load').show();
            $('#btn-load').trigger("click");
        }

        $('body').addClass('sb-l-m');
        
        $('#btn-submit').on('click',function(){
            if($('#transfile').val()==''){
                alert('Anda belum memilih file untuk ditransfer ');
                $('#transfile').focus();
            }
        });
       
        
    });
	jQuery(document).ready(function($) {

	'use strict';

//$('#btn-submit').click(function() {
/*	$('#transf').validate({
		
		submitHandler: function(form) {

			var $form = $(form),
				$submitButton = $(this.submitButton);

			$submitButton.button('loading');

			// Ajax Submit
			$.ajaxFileUpload({
				type: 'POST',
				url: '<?=base_url()?>export-import/porta',
				enctype: 'multipart/form-data',
				data: {
					periode: $form.find('#periode').val(),
					transfile: $form.find('#transfile').val(),
					kode_entity: $form.find('#kode_entity').val()
				},
				dataType: 'json',
				complete: function(data) {
					location.reload();
				}
			});
		}
	});*/

});
</script>
