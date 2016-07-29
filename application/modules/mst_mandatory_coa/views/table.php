<!-- Begin : Content -->
<?php 
		$this->load->helper('combo');
?>
<section id="content">
	<div class="row">
		<div class="col-md-12-pn">
			<div class="panel">
				<div class="panel-body">
					<table class="table table-striped table-bordered table-hover" id="datatable" cellspacing="0" width="100%">
						<thead>
							<!-- 
							tahap, sbdy, nasabah, fakturpajak, kdbank
							-->
							<tr class="bg-primary light bg-gradient" align='center'>
								<th align='center' width="2%">#</th>
								<th width="50%">Code Of Account (CoA)</th>
								<th align='center' width="2%">Tahap?</th>
								<th align='center' width="2%">Sumberdaya?</th>
								<th align='center' width="2%">Nasabah?</th>
								<th align='center' width="2%">Faktur Pajak?</th>
								<th align='center' width="2%">Kode Bank?</th>
								<!--th align='center' width="2%">Alat?</th>	
								<th align='center' width="2%">Bukti Terbit?</th-->	
								<th align='center' width="20%">Action</th>
							</tr>
						</thead>
						<tbody>
							<tr id="f_new" style="display: none;">
								<td align='center' width="3%"></td>
					            <td align='left'> 
					            	<?=combo_coa('cb_coa_new', '', '', 'chosen-select', 'onchange=""')?>
					            </td>
					            <td align='center'><div class="checkbox-custom square checkbox-success"><input id="tahap_new" type="checkbox" value="0" name="tahap_new" onclick="change_checked('tahap_new')"><label for="tahap_new"> </label></div></td>
					            <td align='center'><div class="checkbox-custom square checkbox-success"><input id="sbdy_new" type="checkbox" value="0" name="sbdy_new" onclick="change_checked('sbdy_new')"><label for="sbdy_new"></div></td>
					            <td align='center'><div class="checkbox-custom square checkbox-success"><input id="nasabah_new" type="checkbox" value="0" name="nasabah_new"  onclick="change_checked('nasabah_new')"><label for="nasabah_new"></div></td>
					            <td align='center'><div class="checkbox-custom square checkbox-success"><input id="pajak_new" type="checkbox" value="0" name="pajak_new"  onclick="change_checked('pajak_new')"><label for="pajak_new"></div></td>
					            <td align='center'><div class="checkbox-custom square checkbox-success"><input id="bank_new" type="checkbox" value="0" name="bank_new" onclick="change_checked('bank_new')"><label for="bank_new"></div></td>
					            <!--td align='center'><input id="buktiterbit_new" type="checkbox" value="0" name="buktiterbit_new" onclick="change_checked('buktiterbit_new')"></td-->
					            <td align='center' width="10%">
									<div id="btn_smpn_new" ><button onclick="save_new()">Simpan</button></div>
								</td>
							</tr>
							<div id="add_new"></div>
							<?php 
							//$this->load->helper('combo');
							$num = count($data['t_data']);
							if ($num > 0){	
								$count	= 0;

								foreach($data['t_data'] as $k => $v)
								{
									$count++;
							?>
							<!-- 
							tahap, sbdy, nasabah, fakturpajak, kdbank
							-->
							<tr id="tr_<?=$v['rid']; ?>">
								<td align='center' width="3%"><?php echo $count; ?></td>
					            <td align='left'> 
					            	<span id="tmp_kdcoa"></span>
					            	<div id="kdcoa_<?=$v['rid']?>"><?=$v['coa']?></div>
					            	<div id="cb_kdcoa_<?=$v['rid']?>" style="display: none;"><?=combo_coa('cb_coa_'.$v['rid'], $v['kode_coa'], '', 'chosen-select', 'onchange=""')?></div>
					            </td>
					            <td align='center'><span class="checkbox-custom square checkbox-success"><input id="tahap_<?=$v['rid']?>" type="checkbox" value="<?=$v['is_tahap']?>" name="sbdy_<?=$v['rid']?>" <?=$v['is_tahap']==1?"checked":"" ?> onclick="change_checked('sbdy_<?=$v['rid']?>')"><label for="tahap_<?=$v['rid']?>"></span></td>
					            <td align='center'><span class="checkbox-custom square checkbox-success"><input id="sbdy_<?=$v['rid']?>" type="checkbox" value="<?=$v['is_sbdy']?>" name="sbdy_<?=$v['rid']?>" <?=$v['is_sbdy']==1?"checked":"" ?> onclick="change_checked('sbdy_<?=$v['rid']?>')"><label for="sbdy_<?=$v['rid']?>"></span></td>
					            <td align='center'><div class="checkbox-custom square checkbox-success"><input id="nasabah_<?=$v['rid']?>" type="checkbox" value="<?=$v['is_nasabah']?>" name="nasabah_<?=$v['rid']?>" <?=$v['is_nasabah']==1?"checked":"" ?> onclick="change_checked('nasabah_<?=$v['rid']?>')"><label for="nasabah_<?=$v['rid']?>"></div></td>
					            <td align='center'><div class="checkbox-custom square checkbox-success"><input id="pajak_<?=$v['rid']?>" type="checkbox" value="<?=$v['is_fpajak']?>" name="pajak_<?=$v['rid']?>" <?=$v['is_fpajak']==1?"checked":"" ?> onclick="change_checked('pajak_<?=$v['rid']?>')"><label for="pajak_<?=$v['rid']?>"></div></td>
					            <td align='center'><div class="checkbox-custom square checkbox-success"><input id="bank_<?=$v['rid']?>" type="checkbox" value="<?=$v['is_bank']?>" name="bank_<?=$v['rid']?>" <?=$v['is_bank']==1?"checked":"" ?> onclick="change_checked('bank_<?=$v['rid']?>')"><label for="bank_<?=$v['rid']?>"></div></td>
					            
					            <td align='center' width="10%">
									<button id="btn_smpn_<?=$v['rid']?>" style="display: none;" onclick="combo_change(<?=$v['rid']?>)">Simpan</button>&nbsp;&nbsp;&nbsp;<button id="btn_batal_<?=$v['rid']?>" style="display: none;" onclick="show_combo(<?=$v['rid']?>);">Batal</button><a id="edit_<?=$v['rid']?>" style="cursor:pointer; display: block;" class="row-edit" data-id="<?=$v['rid']; ?>" onclick="show_combo(<?=$v['rid']?>)"><span class="glyphicons glyphicons-edit"></span></a>
									<!--a style="cursor:pointer"  class="row-delete" data-id="<?=$v['rid']; ?>" onclick='delet(<?=$v['rid']; ?>,<?=$v['rid'];?>)' ><span class="glyphicons glyphicons-bin"></span></a-->
								</td>
							</tr>
							
							<?php
							} 
						} else { 
							?>
							<tr id="tr_1111">
						            <td align='left' width="100%" colspan="6"><center>Tidak ada data unit untuk ditampilkan pada Sumberdaya diatas.</center> </td>
						            
								</tr>
								<!--form child is loaded here-->
								<tr  id='child_sub_fl_1111'>
									<td align='center' width="3%"></td>
									<td class='f_child' colspan='5'>
										<form id="f_unit_child_1111" action="javascript:">
										<input type="hidden" name="sdid" id="sdid" value="">
										<input type="hidden" name="sdpo" id="sdpo" value="">
										
						                                
						                                
										</form>
										<button id="add_unit_1111; ?>" onclick="simpan(1111)"><span class="fa fa-plus">&nbsp;Tambah</span></button>
									</td>
								</tr>
							<?php
						}
						?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- End : Content -->