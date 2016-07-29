
<script>
    $(document).ready(function()
    {
        $('.input-periode').datetimepicker({
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
        
        $('#btn_upload').on('click',function(){
            if($('.input-periode').val()==''){
                alert('Anda belum menetapkan input periode');
                $('#periode').focus();
            }
        });
       
        
    });
    function myFunction(){
        var x = document.getElementById("myFile");
        var txt = "";
        if ('files' in x) {
            if (x.files.length == 0) {
                txt = "Select one or more files.";
            } else {
                for (var i = 0; i < x.files.length; i++) {
                    //txt += "<br><strong>" + (i+1) + ". file</strong><br>";
                    var file = x.files[i];
                    if ('name' in file) {
                        txt += "Nama File: <b>" + file.name + "</b><br>";
                    }
                    if ('size' in file) {
                        txt += "Ukuran File: <b>" + file.size + "</b> bytes <br>";
                    }
                }
            }
        } 
        else {
            if (x.value == "") {
                txt += "Select one or more files.";
            } else {
                txt += "The files property is not supported by your browser!";
                txt  += "<br>The path of the selected file: " + x.value; // If the browser does not support the files property, it will return the path of the selected file instead. 
            }
        }
        document.getElementById("demo").innerHTML = txt;
    }
    var oTbl = null;
    var loadJurnal = function() {
        var periode = $('#periode').val(),
            arrPer = periode.split('/'),
            bln = arrPer[0],
            thn = arrPer[1];
        oTbl.fnReloadAjax('<?=base_url()?>index.php/jurnal/DT/'+bln+'-'+thn);
    };
    function togel_child(uid){
        $('#child_sub_fl_'+uid).toggle();
    }
    function show_child(uid){
        //cek dulu exist ga?
        $.ajax({
            url : "cek_uploaded", 
            type: "post", 
            data: '',
            dataType:"json", 
            success:function(ev){
                //alert(ev.response);
                if(ev.response==1)
                {
                    $('#child_'+uid).toggle();
                    $('#bobot_child_'+uid).load('<?=base_url()?>index.php/jurnal/loadupload');
                }
                if(ev.response==0)
                {
                    alert('Anda belum mengunggah data template jurnal. Harap ulangi.')
                }
            },
            fail: function(ev)
            {
                alert(ev.response);
            },
            error: function(xhr, Status, err) {
                //$.parseJSON(response);
                alert("Terjadi error : "+xhr.responseJSON+'-'+Status+'-'+err);
                //var data = xhr.responseJSON;
                //console.log(data);
            }
        });

        //alert('show');
        
    }
    function load_child(uid){
        //$('#fc_sdid').val(uid);
        $('#bobot_child_'+uid).load('<?=base_url()?>index.php/jurnal/loadupload/'+uid);
    }

    function do_upload()
    {
        //var mul = buildMultipart($('#file_name').val());
        var boundary=Math.random().toString().substr(2);
        $.ajax({
            url : "do_upload", 
            type: "post", 
            async: true,
            processData: false,
            contentType: "multipart/form-data; ",//boundary="+boundary,
            data: {
                    'file_name': $('#file_name').val(),
                    'file_upload': 'Upload' 
                },
            dataType:"json", 
            success:function(ev){
                alert(ev.response);
            },
            fail: function(ev)
            {
                alert(ev.response);
            },
            error: function(xhr, Status, err) {
                //$.parseJSON(response);
                alert("Terjadi error : "+xhr.responseJSON+'-'+Status+'-'+err);
                //var data = xhr.responseJSON;
                //console.log(data);
            }
        });
    }
</script>
