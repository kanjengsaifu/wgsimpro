<script type="text/javascript" src="<?=base_url()?>assets/vendor/plugins/datatables/extensions/ReloadAjax/js/dataTables.reloadAjax.min.js"></script>
<script src="<?=base_url()?>assets/vendor/plugins/table2excel/jquery.table2excel.js"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
    $('body').addClass('sb-l-m');

    

    $('#exp2excel').on('click', function(){
      $('.export2excel').table2excel({
        exclude: ".noExl",
        name: "QVIEW",
        filename: "QUERY_JURNAL_VIEW",
        exclude_img: true,
        exclude_links: true,
        exclude_inputs: true
      });
    });

  });
 function fldChange(selectObj,idopt) {
   /*var selectIndex=selectObj.selectedIndex;
   var selectValue=selectObj.options[selectIndex].text;*/
   var selectValueTgl=$(selectObj).val();
   var selectValue=$(selectObj).val();
   var optdata="optv"+idopt;
   var optdata=document.getElementById(optdata);
   var tglmode=".inptgl"+idopt;
   /*$(tglmode).datetimepicker({ 
		pickTime: false,
		format: 'YYYY-MM-DD'
	});*/
	
		  var elnotgl="";
		  var vsrc="srcv"+idopt;
		  var vsrc=document.getElementById(vsrc);
		 if(selectValueTgl=="tanggal"){
			 //elnotgl='<input type="text" id="src_key['+idopt+']"  name="src_key['+idopt+']" class="form-control input-sm" value="<?=date("Y-m-d")?>">';
			 elnotgl='<input type="text" name="src_key[]" class="form-control inptgl" value="<?=date("Y-m-d")?>">';
			 vsrc.innerHTML=elnotgl;
		 }else{ 
			 elnotgl='<input type="text" name="src_key[]" value="" class="form-control">';
			 vsrc.innerHTML=elnotgl;
		 }
		 
   var kata='<select name="opt[]"  class="form-control"><option value="%LIKE">%LIKE</option><option value="IN">IN</option><option value="LIKE%">LIKE%</option><option value="NOT LIKE">NOT LIKE</option><option value="=">=</option><option value="%LIKE%">%LIKE%</option></select>';
   var bil='<select name="opt[]" class="form-control"><option value="<"><</option><option value="<="><=</option><option value=">">></option><option value=">=">>=</option>	<option value="=">=</option></select>';
   var hampa='<select name="opt[]" class="form-control"><option value=""><</option></select>';
	//var 
   //alert(output.innerText);

		 if(selectValue=="no_bukti"||selectValue=="kode_coa"||selectValue=="kode_sumberdaya"||selectValue=="kode_nasabah"||selectValue=="kode_customer"||selectValue=="kode_customer"||selectValue=="kode_spk"||selectValue=="kode_tahap"||selectValue=="no_invoice"||selectValue=="kode_faktur"){
		   optdata.innerHTML=kata;
		 }else if(selectValue=="tanggal"||selectValue=="volume"||selectValue=="dk"){
		   optdata.innerHTML=bil;
		 }else{
			optdata.innerHTML=hampa;
		 }
		 
 }
  

	$('body').on('focus',".inptgl", function(){
		$(this).datetimepicker({
			pickTime: false,
			format: 'YYYY-MM-DD'
		}); 
	});



$(document).ready(function() {
  

    var max_fields      = 12; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
    
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            //$(wrapper).append('<div><input type="text" name="mytext[]"/><a href="#" class="remove_field">Remove</a></div>'); //add input box
            $(wrapper).append('<div><div class="form-group"><div class="col-lg-2"><select name="fld[]" id="data'+x+'" class="form-control" onchange="fldChange(data'+x+','+x+')"><option value=""></option><option value="no_bukti">No. Bukti</option><option value="tanggal">Tanggal</option><option value="kode_coa">CoA</option><option value="kode_nasabah">Nasabah</option><option value="kode_customer">Customer</option><option value="kode_sumberdaya">Sumberdaya</option><option value="kode_spk">SPK</option><option value="kode_tahap">Tahap</option><option value="no_invoice">No. Invoice</option><option value="kode_faktur">Kode Faktur</option><option value="volume">Volume</option><option value="dk">DK</option></select></div><div class="col-lg-2"><div id="optv'+x+'"><select name="opt[]" class="form-control"><option value=""></option></select></div></div><div class="col-lg-3"><span id="srcv'+x+'"><input type="text" name="src_key[]" value="" class="form-control"/></span></div></div><a href="#" class="remove_field">Hapus</a><div style="clear:both"></div></div>'); //add input box

            x++; //text box increment
		}
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })


    
	
});

$('#btn-viewjurnal').click(function() {
	fld=[]; opt=[]; src_key=[];
	ordfld=[]; ordopt=[];
	no=0;
	 $("[name=fld\\[\\]]").each(function() {
      fld[no++]=$(this).val();
    });
	
	no=0;
	$("[name=opt\\[\\]]").each(function() {
      opt[no++]=$(this).val();
    });
	
	no=0;
	$("[name=src_key\\[\\]]").each(function() {
      src_key[no++]=$(this).val();
    });
	
	
	no=0;
	 $("[name=ordfld\\[\\]]").each(function() {
      ordfld[no++]=$(this).val();
    });
	
	no=0;
	$("[name=ordopt\\[\\]]").each(function() {
      ordopt[no++]=$(this).val();
    });
		$.ajax({
		   type: "POST",
		   data: {'fld':JSON.stringify(fld),'opt':JSON.stringify(opt),'src_key':JSON.stringify(src_key),'ordfld':JSON.stringify(ordfld),'ordopt':JSON.stringify(ordopt)},
		   url: "./queryjurnal",
		   success: function(msg){
			$('#answer').html(msg);
			 //$("tbody#datatable").append(msg);
			  //$('#datatable').dataTable().fnReloadAjax(msg);
		   }
		});
  });
	
var loadJurnal2 = function() {
  /*var periode = $('#periode').val(),
    arrPer = periode.split('/'),
    bln = arrPer[0],
    thn = arrPer[1];
    $('#datatable').dataTable().fnReloadAjax('<?=base_url()?>index.php/jurnal/DT/'+bln+'-'+thn);*/
};
//======================================================================================================================================================================================================================================================================================================================================================
var table = null;
var loadJurnal = function() {
/*  var periode = $('#periode').val(),
    arrPer = periode.split('/'),
    bln = arrPer[0],
    thn = arrPer[1];
    $('#datatable').dataTable().fnReloadAjax('<?=base_url()?>index.php/jurnal/DT/'+bln+'-'+thn);*/
};
  $(document).ready( function () {
    $('.input-date').datetimepicker({
    minViewMode: 'months',
    pickTime: false,
    format: 'MM/YYYY'
  });
    $('body').addClass('sb-l-m');
   /* var periode = $('#periode').val(),
        arrPer = periode.split('/'),
        bln1 = arrPer[0],
        thn1 = arrPer[1];
*/

  $('[data-toggle="tooltip"]').tooltip(); 

  table =$('#datatable').DataTable({
       "bFilter": false,
       "columnDefs": [ { "visible": true, "targets": 0 } ],
      "order": [[ 0, 'asc' ]],  
      "aoColumns": [
          { "name": "no_bukti", "class": "text-center", "width": "100px" },
          { "name": "tanggal", "class": "text-center", "width": "60px" },
          { "name": "kode_coa", "class": "text-center", "width": "40px" },
          { "name": "kode_nasabah", "class": "text-center", "width": "100px" },
          { "name": "kode_sumberdaya", "class": "text-center", "width": "100px" },
          { "name": "kode_spk", "class": "text-center", "width": "100px" },
          { "name": "kode_tahap", "class": "text-center", "width": "100px" },
          { "name": "no_invoice", "class": "text-center", "width": "100px" },
          { "name": "kode_faktur", "class": "text-center", "width": "100px" },
          { "name": "volume", "class": "text-right", "width": "100px" },
          { "name": "debet", "class": "text-right", "width": "100px" },
          { "name": "kredit", "class": "text-right", "width": "100px" },
          { "name": "keterangan","class": "text-right", "width": "150px" },
          { "name": "","class": "text-right", "width": "1px" },
        ]

    });
  function dt_tgl(){
    table
        .column( 1 )
        .data()
        .reduce( function (tanggal) {
            return tanggal;
        } );
  }
    function createCookie(name, value) {
        var date = new Date();
        date.setTime(date.getTime()+(1120*1000));
        var expires = "; expires="+date.toGMTString();

       document.cookie = name+"="+value+expires+"; path=/";
    }
    $('body').on('click','.row-edit',function(){
        if(confirm('Nomor Bukti ini akan diedit ulang?')) {
            var id = $(this).attr('data-val');
            var tgl = $(this).attr('tgl-val');
            $('#no_bukti').val(id);
            $('#tanggal').val(tgl);
            $('#go-edit-jurnal').attr('action', "<?=base_url()?>index.php/jurnal-entry/edit");
            createCookie('is_edit_nobukti',id);
            createCookie('is_edit_tanggal',tgl);
            //createCookie('is_mode','edit');
            //var form=$("#form-input"); 
            $("#go-edit-jurnal").submit();
        }else{
            $('#no_bukti').val('');
        }
    });
    $('body').on('click','.row-delete',function(){
        if(confirm('Anda yakin Nomor Bukti ini akan dihapus?')) {
            var id = $(this).attr('data-val');
            
            $.post('del_nobuk/',{ no_bukti: id }).done(function( data ){

                //alert( "Data Loaded: " + data );
                loadJurnal();
                //table.ajax.reload();
                //table.draw();
            });
        }
    });
    $('#group-switch').change(function() {
        if($(this).is(':checked')) {
             table
                .columns( 0 )
                .visible( false )
                .draw();
          }
           else {
            table
                .columns( 0 )
                .visible(true)
                .draw();
          }
    });
    
    $('#btn-submit').click(function() {
        loadJurnal();
        //table.ajax.reload();
        //table.draw();
      
    });
      $('#show_kolom').on('change',function(){
        $( "select option:selected" ).each(function() {
            fnShowHide($( this ).val());
          });
      });
      $('#show_kolom').multiselect({
          buttonClass: 'multiselect dropdown-toggle btn btn-sm btn-primary btn-block'
      });
      function fnShowHide( iCol )
      {
        //var oTable = $('#datatable').DataTable();
        
        var bVis = oTbl.fnSettings().aoColumns[iCol].bVisible;
        oTbl.fnSetColumnVis( iCol, bVis ? false : true );
      }
  });

</script>

