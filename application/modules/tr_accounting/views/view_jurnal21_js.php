
<link rel="stylesheet" href="<?=base_url()?>assets/vendor/plugins/bootstrap-table/bootstrap-table.css">
<script type="text/javascript" src="<?=base_url()?>assets/vendor/plugins/bootstrap-table/bootstrap-table.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/vendor/plugins/bootstrap-table/extensions/export/bootstrap-table-export.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/vendor/plugins/bootstrap-table/tableExport.js"></script>
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

	    $('.active').on('click',function(){
	    	alert('click');
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
		modifyTableRowspan(columnLast);
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

	    $('.page-number').on('change',function(){
	    	modifyTableRowspan(column1);
			modifyTableRowspan(columnLast);
	    	alert($(this).text());
	    })

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