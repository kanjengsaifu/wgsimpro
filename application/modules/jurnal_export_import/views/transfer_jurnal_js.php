<script type='text/javascript'>
        //<![CDATA[
        $(window).load(function() {
            $("#transfile").change(function(e) {
                var ext = $("input#transfile").val().split(".").pop().toLowerCase();

                if ($.inArray(ext, ["csv"]) == -1) {
                    alert('Upload CSV');
                    return false;
                }
                var sipp = "";
                var failed = "";
                var totaldata = "";

                if (e.target.files != undefined) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var totdata = e.target.result.split("\n");
                        var totaldata = totdata.length;
                        var csvval = e.target.result.split("\n");

                        periode = $("input#periode").val();
                        kdspk = $("input#kode_entity").val(); 
                        var inputrad = "";
                        cekdata = "";
                        for (var j = 1; j < (totaldata - 1); j++) {
                            
							var csvvalue = csvval[j].split(","); //Baca perkolom
                            var strTgl = csvvalue[2];
                            var strSPK = csvvalue[10];
							
							/*Begin Cek TanggalData dan PeriodeUser*/
                            var tanggal = strTgl.replace('"', "");
                            tanggal = tanggal.split("-");
                            var tglPeriod = tanggal[1] + "-" + tanggal[0];

                            if (periode == tglPeriod) {
                                //cekdata="aman "+cekdata;
                                sipp++;
                            } else {
                                failed++;
                                cekdata = cekdata+"<br /> Failed Tanggal  <br /> Line"+" "+j+" ";
                            }
							/*End Cek TanggalData dan PeriodeUser*/
							
							
							/*Begin Cek SPKData dan SPKUser*/ 
							var spk=strSPK.replace('"',"");
							var spk=spk.replace('"',"");
                            if (spk == kdspk) {
                                //cekdata="aman "+cekdata;
                                sipp++;
                            } else {
                                failed++;
                                cekdata = cekdata+"<br /> Failed Kode SPK  <br /> Line"+" "+j+" ";
                            }
							/*End Cek SPKData dan SPKUser*/							
                        }

						dataTotal=(totaldata - 2)*2;
                        if (dataTotal==sipp) {
								document.getElementById('id_confrmdiv').style.display="block"; //this is the replace of this line 
							
                        }else{
							alert("Mohon Data Diperiksa Kembali");
							
                        }
						$( "#id_truebtn" ).click(function() {
							$("#id_confrmdiv").hide();
							var tombol='<input type="submit" id="btn-submit" class="btn btn-sm btn-primary btn-gradient dark btn-block" value="submit">';
							
							$("#tombolkirim").html(tombol);
						});
						$( "#id_falsebtn" ).click(function() {
							location.reload();
						return false;
						});

                        
                        $("#csvimporthint").html(inputrad);
						
                        $("#csvimporthint2").show();
                        $("#csvimporthint2").html(cekdata);
                        $("#csvimporthinttitle").show();
                    };


                    reader.readAsText(e.target.files.item(0));

                }

                return false;

            });
        }); //]]>
    </script>
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
				location.reload();
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
