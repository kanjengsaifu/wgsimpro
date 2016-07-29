<script type="text/javascript" src="<?=base_url()?>assets/vendor/plugins/tableExport/tableExport.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/vendor/plugins/tableExport/jquery.base64.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/vendor/plugins/tableExport/html2canvas.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/vendor/plugins/tableExport/jspdf/jspdf.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/vendor/plugins/tableExport/jspdf/libs/sprintf.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/vendor/plugins/tableExport/jspdf/libs/base64.js"></script>

	<script type="text/javascript" src="<?=base_url()?>assets/vendor/plugins/jsPDF/jspdf.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/vendor/plugins/jsPDF/libs/FileSaver.js/FileSaver.js"></script>
	<!--script type="text/javascript" src="<?=base_url()?>assets/vendor/plugins/jsPDF/libs/BlobBuilder.js/BlobBuilder.js"></script-->

	<script type="text/javascript" src="<?=base_url()?>assets/vendor/plugins/jsPDF/jspdf.plugin.addimage.js"></script>

	<script type="text/javascript" src="<?=base_url()?>assets/vendor/plugins/jsPDF/jspdf.plugin.standard_fonts_metrics.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/vendor/plugins/jsPDF/jspdf.plugin.split_text_to_size.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/vendor/plugins/jsPDF/jspdf.plugin.from_html.js"></script>

<script type="text/javascript">
	$(document).ready( function () {
		
	    $('.input-date').datetimepicker({
		    minViewMode: 'months',
		    pickTime: false,
		    format: 'MM/YYYY'
		  });
	    $('body').addClass('sb-l-m');
	    var periode = $('#periode').val(),
	        arrPer = periode.split('/'),
	        bln1 = arrPer[0],
	        thn1 = arrPer[1];
		$('#advance').on('click',function(){
			//alert($('#advance-search').is(":visible"));
			if($('#advance-search').is(":visible")==false){ //lagi hide utk ditampilin
				//alert('1');
				$('#is_adv').val(1);
				$('#cari').attr('disabled',true);
				$('#q').attr('disabled',true);
			}else{	//lagi show, utk disembunyiin
				//alert('0');
				$('#is_adv').val(0);
				$('#cari').attr('disabled',false);
				$('#q').attr('disabled',false);
			}
			$('#advance-search').slideToggle('slow');
			
		});
		$('#limit').on('change',function(){
			$.ajax({
                url: "<?=base_url()?>index.php/jurnal/page/limit",
                dataType: 'json',
                type: 'POST',
                data: {limit: $(this).val()},
                success:
                    function(respon){
                        console.log(respon.limit);
                        window.location.reload();
                    }
            });

            
		});
		$('.to-pdf').click(function () {
		    var pdf = new jsPDF('p','in','legal')
				, source = $('#content')[0]

				, specialElementHandlers = {
					'#bypassme': function(element, renderer){
						return true
					}
				}

				pdf.fromHTML(
					source // HTML string or DOM elem ref.
					, 0.5 // x coord
					, 0.5 // y coord
					, {
						'width':7.5 // max width of content on PDF
						, 'elementHandlers': specialElementHandlers
					}
				)

				pdf.save('Test.pdf');
		});
		$('.new-row').on('click',function(){
			var add_row = 
						'<tr>' +
                        '    <td>' +
                        '        <select id="field[]" name="field[]" class="input-xsm">' +   
                        '          <option value=""> </option>' +
                        '          <option value="no_bukti"> Nomor Bukti </option>' +
                        '          <option value="tanggal"> Tanggal </option>' +
                        '          <option value="kode_coa"> Kode CoA </option>' +
                        '          <option value="kode_nasabah"> Nasabah </option>' +
                        '          <option value="kode_customer"> Customer</option>' +
                        '          <option value="kode_sumberdaya"> Sumberdaya </option>' +
                        '          <option value="kode_spk"> SPK </option>' +
                        '          <option value="kode_tahap"> Tahap </option>' +
                        '          <option value="no_invoice"> Nomor Invoice</option>' +
                        '          <option value="kode_faktur"> Nomor Faktur</option>' +
                        '          <option value="volume"> Volume</option>' +
                        '          <option value="rp_debit"> Debet</option>' +
                        '          <option value="rp_kredit"> Kredit</option>' +
                        '          <option value="keterangan"> Uraian</option>' +
                        '        </select>' +
                        '    </td>' +
                        '    <td>&nbsp;&nbsp;</td>' +
                        '    <td> ' +
                        '        <select id="kondisi[]" name="kondisi[]" class="input-xsm"> ' +  
                        '          <option value="">  </option>' +
                        '          <option value="="> = </option>' +
                        '          <option value=">"> > </option>' +
                        '          <option value="<"> < </option>' +
                        '          <option value=">="> >= </option>' +
                        '          <option value="<="> <= </option>' +
                        '          <option value="<>"> <> </option>' +
                        '          <option value="like_before"> %xx </option>' +
                        '          <option value="like_after"> xx% </option>' +
                        '          <option value="like_both"> %xx% </option>' +
                        '        </select> ' +
                        '    </td>' +
                        '    <td>&nbsp;&nbsp;</td>' +
                        '    <td><input id="nilai[]" name="nilai[]" type="text" value="" class="input-xsm"></td>' +
                        '    <td>&nbsp;&nbsp;</td>' +
                        '    <td><a href="javascript:" class="del-row"><span class="fa fa-minus-square"></span></a></td>' +
                        '</tr>';
			$('#t_filter > tbody:last-child').append(add_row);
		});
		function createCookie(name, value) {
	        var date = new Date();
	        date.setTime(date.getTime()+(1120*1000));
	        var expires = "; expires="+date.toGMTString();

	       document.cookie = name+"="+value+expires+"; path=/";
	    }
		
		$('.row-edit').on('click', function(){
			var nobuk = $('#nobukti').val();
			if($('#nobukti').val()==''){
				alert('ERROR!\n\nAnda belum memilih nomor bukti untuk di edit. Harap ulangi.');
			}else{
				if(confirm('EDIT ! \n\nNomor Bukti '+nobuk+' ini akan diedit ulang?')) {
		            var id = $(this).attr('data-val');
		            var tgl = $(this).attr('tgl-val');
		            $('#nobukti').val(id);
		            $('#tanggal').val(tgl);
		            $('#go-edit-jurnal').attr('action', "<?=base_url()?>index.php/jurnal-entry/edit");
		            createCookie('is_edit_nobukti',id);
		            createCookie('is_edit_tanggal',tgl);
		            //createCookie('is_mode','edit');
		            //var form=$("#form-input"); 
		            $("#go-edit-jurnal").submit();
		        }else{
		            $('#nobukti').val('');
		        }
			}
		});
		$('.row-delete').on('click', function(){
			var nobuk = $('#nobukti').val();
			//alert('delete this voucher : '+row_data);
			var nobuk = $('#nobukti').val();
			if($('#nobukti').val()==''){
				alert('ERROR!\n\nAnda belum memilih nomor bukti yang akan dihapus. Harap ulangi.');
			}else{
				if(confirm('HAPUS !\n\nAnda yakin Nomor bukti: '+nobuk+' ini, akan dihapus?')) {
		            
		            $.post('del_nobuk/',{ no_bukti: nobuk }).done(function( data ){

		                //alert( "Data Loaded: " + data );
		                //loadJurnal();
		                window.location.reload();
		            });
		        }
		    }
		});
		$("input[name^=nobuk]").click(function() {
	    	var no_bukti = $(this).val();
	    	$('#nobukti').val(no_bukti);
		});
		$('.export-excel').on('click',function(){
			$('#t_vjurnal').tableExport({type:'excel',escape:'false'});
		});
		$('#ckperiode').on('change',function(){
			if($(this).is(':checked') == true){
				$('#ckperiode').val(1);
				$('#is_periode').val(1);
			}else{
				$('#ckperiode').val(0);
				$('#is_periode').val(0);
			}
		});
	  	$('[data-toggle="tooltip"]').tooltip(); 

			var beforeTable = $('#t_vjurnalx').clone().removeAttr('id').appendTo('#before')
		    // code for grouping in "after" table
		    var $rows = $('#t_vjurnalx tbody tr');
		    var items = [],
		        itemtext = [],
		        currGroupStartIdx = 0;
		    $rows.each(function(i) {
		        var $this = $(this);
		        var itemCell = $(this).find('td:eq(0)');
		        var item = itemCell.text();
		        itemCell.remove();
		        if ($.inArray(item, itemtext) === -1) {
		            itemtext.push(item);
		            items.push([i, item]);
		            groupRowSpan = 1;
		            currGroupStartIdx = i;
		            $this.data('rowspan', 1);
		        } else {
		            var rowspan = $rows.eq(currGroupStartIdx).data('rowspan') + 1;
		            $rows.eq(currGroupStartIdx).data('rowspan', rowspan);
		        }
		    });

	    $.each(items, function(i) {
	        var $row = $rows.eq(this[0]);
	        var rowspan = $row.data('rowspan');
	        $row.prepend('<td rowspan="' + rowspan + '">' + this[1] + '</td>');
	    });

	    function mergeAllCommonRows() {
	    	var table = $('#t_vjurnal');
		    var firstColumnBrakes = [];
		    // iterate through the columns instead of passing each column as function parameter:
		    for(var i=1; i<=table.find('th').length; i++){
		        var previous = null, cellToExtend = null, rowspan = 1;
		        table.find("td:nth-child(" + i + ")").each(function(index, e){
		            var jthis = $(this), content = jthis.text();
		            // check if current row "break" exist in the array. If not, then extend rowspan:
		            if (previous == content && content !== "" && $.inArray(index, firstColumnBrakes) === -1) {
		                // hide the row instead of remove(), so the DOM index won't "move" inside loop.
		                jthis.addClass('hidden');
		                cellToExtend.attr("rowspan", (rowspan = rowspan+1));
		            }else{
		                // store row breaks only for the first column:
		                if(i === 1) firstColumnBrakes.push(index);
		                rowspan = 1;
		                previous = content;
		                cellToExtend = jthis;
		            }
		        });
		    }
		    // now remove hidden td's (or leave them hidden if you wish):
		    $('td.hidden').remove();
		}

		//mergeAllCommonRows();

	    var column1 = $('.t-vjurnal td:first-child');
	    var columnx = $('#t_vjurnal td:last-child');
		var column2 = $('.t-vjurnal td:nth-child(2)');
		var columnLast = $('.t-vjurnal td:nth-child(15)');
		var column14 = $('.t-vjurnal td:nth-child(14)');

		modifyTableRowspan(column1);
		//modifyTableRowspan(columnLast);
		//modifyTableRowspan(column14);

		function modifyTableRowspan(column) {

	        var prevText = "";
	        var counter = 0;

	        column.each(function (index) {
	            var textValue = $(this).text();

	            if (index === 0) {
	                prevText = textValue; 
	            }
	            
	            if (textValue !== prevText || index === column.length - 1) {
	                var first = index - counter;
	                if (index === column.length - 1) {
	                    counter = counter + 1;
	                }
	                column.eq(first).attr('rowspan', counter);
	                if (index === column.length - 1)
	                {
	                    for (var j = index; j > first; j--) {
	                        column.eq(j).remove();
	                    }
	                }
	                else {
	                    for (var i = index - 1; i > first; i--) {
	                        column.eq(i).remove();
	                    }
	                }
	                prevText = textValue;
	                counter = 0;
	            }
	            counter++;
	        });
	    }

	    $('#t_vjurnalx').each(function () {
 
		    var dimension_cells = new Array();
		    var dimension_col = null;
		    var columnTitle = "Aksi";
		 
		    var i = 0;

		    $(this).find('th').each(function () {
		        
		        if ($(this).html().trim() == columnTitle) {
		            dimension_col = i;
		        }
		        i++;
		    });
		    
		    var first_instance = null;

		    $(this).find('tr').each(function () {
		        
		        var dimension_td = $(this).find('td').eq( dimension_col ) ;
		 
		        if (first_instance == null) {
		            first_instance = dimension_td;
		        } else if (dimension_td.text() == first_instance.text()) {

		            dimension_td.remove();

		            first_instance.attr('rowspan', parseInt(first_instance.attr('rowspan'),10) + 1);
		        } else {
		            first_instance = dimension_td;
		        }
		 
		    });
		});

		$('body').on('click','ul#search_page_pagination>li>a',function(e){
			e.preventDefault();  // prevent default behaviour for anchor tag
			var Pagination_url = $(this).attr('href'); // getting href of <a> tag
			$.ajax({
				url:Pagination_url,
				type:'POST',
				success:function(data){
					var $page_data = $(data);
					$('#container').html($page_data.find('div#body'));
					$('table').addClass('table');
				}
			});
		});
	});
</script>