if ($num > 0){
?>
	<table width='100%'>
		<tr>
			<th width='10'>#</th>
			<th>TANGGAL</th>
			<th>DARI</th>
			<th align='left'>ISI KOMENTAR</th>
		</tr>
		
		<?php 

		
		$count	= 0;
		?>
		<?php
		foreach($query as $row)
		{
		$count++;
		?>
		<tr id="tr_<?php echo "3" ?>">
			<td align='center' width="3%"><?php echo $count; ?></td>
            <td align='left' width="10%"> <?php echo  date(now()); ?> </td>
            <td align='left' width="10%"> <?php echo "dddd" ?> </td>
            <td align='left' width="77%"> <?php echo "$row->OA_COMMENTS"; ?> </td>
            
			<!--<td align='center' width="10%">
				<a class='update' onclick='show_editbox(<?php echo $row->OA_CID ?>)' style='cursor:pointer'></a>
				<a class='delete' onclick='delet(<?php echo $row->OA_CID ?>,0)' style='cursor:pointer'></a>
			</td>-->
		</tr>
		<!--form child is loaded here-->
		<tr style='display:none' id='child_sub_fl_<?php echo $row->OA_CID; ?>'>
			<td class='f_child' colspan='6'>
				<span id='bobot_child_sub_fl_<?php echo $row->OA_CID; ?>'></span>
			</td>
		</tr>
		<?php
		}
		?>
	</table>
    
<?php 
} else { ?>
   <!-- <a class='update' onclick='show_subchild(<?php echo $row->OA_ID ?>)' style='cursor:pointer'>Beri Komentar</a>-->
   <center>Tidak ada riwayat komentar untuk ditampilkan pada lembar surat diatas.</center> 
<?php
}?>