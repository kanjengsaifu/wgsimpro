<script type="text/javascript">

jQuery(document).ready(function() {
	// init component / plugin
	$('.chosen-select').chosen({
		width: '25%',
	});
	$('.chosen-select').val('').chosen().trigger('chosen:updated');
	$('.chosen-select').trigger('chosen:updated');
	$('#sdid').val($("#form-input input[name=fc_sdid]").val());
	$('#sdpo').val($("#form-input input[name=no_po]").val());

});

	function simpan(parent)
	{
		
		$('#add_unit_'+parent).click(function() {
			// validasi
			var isValid = true;
			$.each($('.required'), function(index, item) {
				if($(this).val()=='')
					isValid &= false;
			});
			// --

			if($("#nounit").val()!=''){//isValid){
				$.post(
					'<?=base_url()?>index.php/po/ad_unit',
					$('#f_unit_child_'+parent).serialize(),
					function(respon) {
						alert('Data tersimpan.');
						//location.href = '<?=base_url()?>index.php/po';
						$( "#td_"+parent ).click();
					}
				);
			} else {
				alert('Data Belum Lengkap.\n*Wajib Diisi');
			}
		});
	}
</script>
<?php

if ($num > 0){
?>
	<table width='20%' class="table table-striped table-bordered table-hover">
		<tr>
			<th width='3%' align='center'>#</th>
			<th align='center'>NOMOR UNIT&nbsp;&nbsp;&nbsp;
			
            </th>
			<th align='center'></th>
		</tr>
		
	<?php 
		$count	= 0;

		foreach($query as $row)
		{
			$count++;
		?>
		<tr id="tr_<?=$row->no_unit; ?>">
			<td align='center' width="3%"><?php echo $count; ?></td>
            <td align='left' width="87%"> <?=$row->no_unit; ?> </td>
            <td align='center' width="10%">
				<!--a style="cursor:pointer" class="row-edit" data-id="<?=$row->id; ?>" onclick='show_editbox(<?=$row->id; ?>)' ><span class="glyphicons glyphicons-edit"></span></a>&nbsp;&nbsp;&nbsp;-->
				<a style="cursor:pointer"  class="row-delete" data-id="<?=$row->id; ?>" onclick='delet(<?=$row->id; ?>,<?=$row->sd_id;?>)' ><span class="glyphicons glyphicons-bin"></span></a>
			</td>
		</tr>
		
		<?php
		}
		?>
		<!--form child is loaded here-->
		<tr id='child_sub_fl_<?=$row->id; ?>'>
			<td align='center' width="3%"></td>
			<td class='f_child' colspan='2'>
				<form id="f_unit_child_<?=$row->id; ?>" action="javascript:">
				<input type="hidden" name="sdid" id="sdid" value="">
				<input type="hidden" name="sdpo" id="sdpo" value="">
				<select id="nounit" name="nounit[]" class="chosen-select" multiple>
                                    <?php foreach($query2 as $rau) { ?>
                                        <option value="<?=$rau->no_unit;?>"><?=$rau->no_unit;?></option>
                                    <?php } ?>
                                </select>
                                
                                
				</form>
				<button id="add_unit_<?=$row->id; ?>" onclick="simpan(<?=$row->id; ?>)"><span class="fa fa-plus">&nbsp;Tambah</span></button>
			</td>
		</tr>
	</table>
    
<?php
} else { 

?>
   <table width='20%' class="table table-striped table-bordered table-hover">
		<tr>
			<th width='3%' align='center'>#</th>
			<th align='center'>NOMOR UNIT&nbsp;&nbsp;&nbsp;<a style="cursor:pointer" class="row-edit" ><span class="glyphicons glyphicons-edit"></span></a></th>
			<th align='center'></th>
		</tr>
		
		<?php 
		$count	= 1;

		//foreach($query as $row)
		//{
		//	$count++;
		?>
		<tr id="tr_1111">
			<td align='center' width="3%"></td>
            <td align='left' width="87%"><center>Tidak ada data unit untuk ditampilkan pada Sumberdaya diatas.</center> </td>
            <td align='center' width="10%">
				<a style="cursor:pointer" class="row-edit" ><span class="glyphicons glyphicons-edit"></span></a>&nbsp;&nbsp;&nbsp;
				<a style="cursor:pointer"  class="row-delete"><span class="glyphicons glyphicons-bin"></span></a>
			</td>
		</tr>
		<!--form child is loaded here-->
		<tr  id='child_sub_fl_1111'>
			<td align='center' width="3%"></td>
			<td class='f_child' colspan='2'>
				<form id="f_unit_child_1111" action="javascript:">
				<input type="hidden" name="sdid" id="sdid" value="">
				<input type="hidden" name="sdpo" id="sdpo" value="">
				<select id="nounit" name="nounit[]" class="chosen-select" multiple>
                                    <?php foreach($query2 as $rau) { ?>
                                        <option value="<?=$rau->no_unit;?>"><?=$rau->no_unit;?></option>
                                    <?php } ?>
                                </select>
                                
                                
				</form>
				<button id="add_unit_1111; ?>" onclick="simpan(1111)"><span class="fa fa-plus">&nbsp;Tambah</span></button>
			</td>
		</tr>
		<?php
		//}
	
		?>
	</table>
   
<?php
}
?>