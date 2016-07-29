<!-- Begin: Content -->
<style>
.text-bold {
	font-weight: bold;
}
.loader {
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
	background: url('<?=base_url()?>assets/img/spinner.gif') 50% 50% no-repeat rgb(249,249,249);
}
a.tangan {
	cursor: pointer;
}
</style>
<div class="loaderx"></div>
<section id="content">

    <div class="row">
		<div class="col-md-12 pn">
			<div class="panel mbn">
				<div class="panel-body" style="overflow-x: scroll">
					<div class="row">
						<div class="col-md-12">
							<!--<h4 class="mbn">PT WIJAYA KARYA BANGUN GEDUNG</h4>-->
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<h5 class="mbn">KAWASAN <?=@$data['kawasan']?></h5>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 text-center">
							<h4 class="mbn">LAPORAN TAHAP RENCANA (Ra) & REALISASI (Ri) <?=(isset($data['divisi'])?strtoupper($data['divisi']['nama']):'')?></h4>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 text-center">
							<h5 class="mbn">PERIODE <?=@strtoupper($data['periode'])?></h5>
							<input type="hidden" id="periode" name="periode" value="<?=$data['peuriode']?>">
						</div>
					</div>
					<div class="row">
						<div class="col-md-10">
							<p>Dicetak tanggal: <?=date('d/m/Y H:i:s')?>, Oleh: <?=$data['nama']?></p>
						</div>
						<div class="col-md-2 text-right">
							<button id="exp2excel" name="exp2excel">Export To Excel</button>
						</div>
					</div>
					<table id="t_bukubesar" class="table table-bordered mbn export2excel">
						<thead>
							<tr class="bg-primary light">
								<th class="text-center" rowspan="2">#</th>
								<th width='3%' align='center' rowspan="2">TAHAP</th>
								<th class='text-center' rowspan="2">SUMBERDAYA</th> 
								<th class='text-center' colspan="2">RENCANA AWAL</th>
								<th class='text-center' colspan="2">ROLLING</th>
								<th class='text-center' colspan="2">REALISASI</th>
								<th class='text-center' colspan="2">DEVIASI</th>
							</tr>
							<tr class="bg-primary light">
								<th class='text-center'>Volume</th>
								<th class='text-center'>Harga</th>
								<th class='text-center'>Volume</th>
								<th class='text-center'>Harga</th>
								<th class='text-center'>Volume</th>
								<th class='text-center'>Harga</th>
								<th class='text-center'>Volume</th>
								<th class='text-center'>Harga</th>
							</tr>
						</thead>
						<tbody>
						<?php
						$coa = $data['rowsa']['coa'];
						$sal_awal = $data['rowsa']['saldo'];
						$kode_spk = $this->session->userdata('kode_entity');
						//var_dump($data['rowsa']);die;
						$this->load->helper('combo');
						$bs_debit = 0;
						$bs_kredit = 0;
						$ks_debit = 0;
						$ks_kredit = 0;

						$bs_saldo = 0;
						$ks_saldo = 0;
						
						$d_mut = 0;
						$k_mut = 0;
						$s_mut = 0;

						$bank_sal = 0;

						$t_saldo_awal = 0;
						$kel_biaya = array(
								array('kode'=>'BL','nm_kel'=>'BIAYA LANGSUNG'),
								array('kode'=>'BTL','nm_kel'=>'BIAYA TIDAK LANGSUNG')
								);
						//var_dump($kel_biaya[0]['kode']);die;
						$i=1;
						foreach ($kel_biaya as $k => $v) {
							//echo $v['kode'];
							
						?>
							<tr id="<?=$v['kode']?>"class="alert alert-primary alert-border-bottom">
								<td class="text-center"><a class="tangan" onclick="show_child('<?=$v["kode"]?>','<?=$kode_spk?>','<?=$data['periode']?>')"><span id="spn_<?=$v['kode']?>" class="fa fa-chevron-down"></span></a></td>
								<td class="text-left" colspan="10"><b><?=$v['nm_kel']?></b></td>
							</tr>
							<?php $this->load->helper('generator');
							$subclas="sub_".$v['kode'];
							
							//$kelompok_biaya, $kode_spk, $periode, $tr_idname='', $tr_varval='', $tr_class='', $td_idname='', $td_varval='', $td_class='', $extra=''
							?>
							
							<?=tr_tahap_rari($v['kode'], $kode_spk, $data['peuriode'],$data['kde_div'],$v['saldo'],'sub_'.$v['kode'],'','class="'.$subclas.'"')?>
							<!--tr class="bg-dark light">
								<th colspan="3" class="text-right">SUB TOTAL</th>
								<th class="text-right"><?=number_format($ks_debit)?></th>
								<th class="text-right"><?=number_format($ks_kredit)?></th>
								<th class="text-right"><?=number_format($ks_debit)?></th>
								<th class="text-right"><?=number_format($ks_kredit)?></th>
								<th class="text-right"><?=number_format($ks_debit)?></th>
								<th class="text-right"></th>
							</tr-->
							
						<?php
							$i++;
						}
						?>
						</tbody>
						<tfoot>
							<tr class="bg-warning danger-border-bottom">
								<th colspan="3" class="text-right"></th>
								<th class="text-right"></th>
								<th class="text-right"></th>
								<th class="text-right"></th>
								<th class="text-right"></th>
								<th class="text-right"></th>
								<th class="text-right"></th>
								<th class="text-right"></th>
								<th class="text-right"></th>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
	
</section>
<!-- End: Content -->

<script type="text/javascript" charset="utf-8" async defer>
jQuery(document).ready(function() {
	function sumOfColumns(table, columnIndex) {
	    var tot = 0;
	    table.find("tr").children("td:nth-child(" + columnIndex + ")")
	    .each(function() {
	        $this = $(this);
	        if (!$this.hasClass("sum") && $this.html() != "") {
	            tot += parseInt($this.html());
	        }
	    });
	    return tot;
	}

	function do_sums() {
	    $("tr.sum").each(function(i, tr) {
	        $tr = $(tr);
	        $tr.children().each(function(i, td) {
	            $td = $(td);
	            var table = $td.parent().parent().parent();
	            if ($td.hasClass("sum")) {
	                $td.html(sumOfColumns(table, i+1));
	            }
	        })
	    });
	}
});
</script>