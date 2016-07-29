<!-- Begin: Content -->
<section id="content">
    <div class="row">
		<div class="col-md-12 pn">
			<div class="panel mbn">
				<div class="panel-body" style="overflow-x: scroll;">
					<div class="row">
						<div class="col-md-12">
							<!--<h4 class="mbn">PT WIJAYA KARYA REALTY</h4>-->
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 text-center">
							<h4 class="mbn">LAPORAN KONSOLIDASI OP</h4>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 text-center">
							<h5 class="mbn">Periode <?=@$data['periode']?></h5>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<p>Dicetak tanggal: <?=date('d/m/Y H:i:s')?>, Oleh: <?=@$data['nama']?></p>
						</div>
					</div>
					<table id="example" class="table table-bordered mbn" style="font-size: 10px!important">
						<thead>
							<tr class="bg-primary light">
								<th rowspan="2" class="text-center">No.</th>
								<th rowspan="2" class="text-center">UNIT PPU</th>
								<th colspan="3" class="text-center">Realisasi</th>
								<th rowspan="2" class="text-center" style="vertical-align:middle">Reserve</th>
							</tr>
							<tr class="bg-primary light">
								<th class="text-center">Minggu Lalu</th>
								<th class="text-center">Minggu Ini</th>
								<th class="text-center">s.d Minggu Ini</th>
							</tr>
						</thead>
						<tbody>
                        <?php
                        foreach($data['datatable'] as $k=>$v) {
                            $sumDir = array(
                                array(0,0,0,0),
                                array(0,0,0,0),
                                array(0,0,0,0),
                                array(0,0,0,0)
                            );
                        ?>
                        <?php
                        ?>
                            <tr>
                                <td colspan="6"><b><?=$k?></b></td>
                            </tr>
                            <?php
                            foreach($v as $k2=>$v2) {
                                $sumType = array(
                                    array(0,0,0,0),
                                    array(0,0,0,0),
                                    array(0,0,0,0),
                                    array(0,0,0,0)
                                );
                            ?>
                            <tr>
                                <td colspan="6" class="pl15"><b><?=$k2?></b></td>
                            </tr>
                                <?php
                                foreach($v2 as $k3=>$v3) {
                                    // sum per type
                                    // sum unit
                                    $sumType[0][0] += $v3[1][0][1];
                                    $sumType[0][1] += $v3[1][0][2];
                                    $sumType[0][2] += $v3[1][0][1]+$v3[1][0][2];
                                    $sumType[0][3] += $v3[1][0][3];
                                    // sum gross
                                    $sumType[1][0] += $v3[1][1][1];
                                    $sumType[1][1] += $v3[1][1][2];
                                    $sumType[1][2] += $v3[1][1][1]+$v3[1][1][2];
                                    $sumType[1][3] += $v3[1][1][3];
                                    // sum netto
                                    $sumType[2][0] += $v3[1][2][1];
                                    $sumType[2][1] += $v3[1][2][2];
                                    $sumType[2][2] += $v3[1][2][1]+$v3[1][2][2];
                                    $sumType[2][3] += $v3[1][2][3];
                                    // sum omzet
                                    $sumType[3][0] += $v3[1][3][1];
                                    $sumType[3][1] += $v3[1][3][2];
                                    $sumType[3][2] += $v3[1][3][1]+$v3[1][3][2];
                                    $sumType[3][3] += $v3[1][3][3];
                                    // sum per dir
                                    // sum unit
                                    $sumDir[0][0] += $v3[1][0][1];
                                    $sumDir[0][1] += $v3[1][0][2];
                                    $sumDir[0][2] += $v3[1][0][1]+$v3[1][0][2];
                                    $sumDir[0][3] += $v3[1][0][3];
                                    // sum gross
                                    $sumDir[1][0] += $v3[1][1][1];
                                    $sumDir[1][1] += $v3[1][1][2];
                                    $sumDir[1][2] += $v3[1][1][1]+$v3[1][1][2];
                                    $sumDir[1][3] += $v3[1][1][3];
                                    // sum netto
                                    $sumDir[2][0] += $v3[1][2][1];
                                    $sumDir[2][1] += $v3[1][2][2];
                                    $sumDir[2][2] += $v3[1][2][1]+$v3[1][2][2];
                                    $sumDir[2][3] += $v3[1][2][3];
                                    // sum omzet
                                    $sumDir[3][0] += $v3[1][3][1];
                                    $sumDir[3][1] += $v3[1][3][2];
                                    $sumDir[3][2] += $v3[1][3][1]+$v3[1][3][2];
                                    $sumDir[3][3] += $v3[1][3][3];
                                ?>
                            <tr>
                                <td class="text-center"><b><?=$k3+1?></b></td>
                                <td colspan="5"><b><?=$v3[0]?></b></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td><?=$v3[1][0][0]?></td>
                                <td class="text-right"><?=$v3[1][0][1]?></td>
                                <td class="text-right"><?=$v3[1][0][2]?></td>
                                <td class="text-right"><?=$v3[1][0][1]+$v3[1][0][2]?></td>
                                <td class="text-right"><?=$v3[1][0][3]?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td><?=$v3[1][1][0]?></td>
                                <td class="text-right"><?=number_format($v3[1][1][1],2)?></td>
                                <td class="text-right"><?=number_format($v3[1][1][2],2)?></td>
                                <td class="text-right"><?=number_format($v3[1][1][1]+$v3[1][1][2],2)?></td>
                                <td class="text-right"><?=number_format($v3[1][1][3],2)?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td><?=$v3[1][2][0]?></td>
                                <td class="text-right"><?=number_format($v3[1][2][1],2)?></td>
                                <td class="text-right"><?=number_format($v3[1][2][2],2)?></td>
                                <td class="text-right"><?=number_format($v3[1][2][1]+$v3[1][2][2],2)?></td>
                                <td class="text-right"><?=number_format($v3[1][2][3],2)?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td><?=$v3[1][3][0]?></td>
                                <td class="text-right"><?=number_format($v3[1][3][1])?></td>
                                <td class="text-right"><?=number_format($v3[1][3][2])?></td>
                                <td class="text-right"><?=number_format($v3[1][3][1]+$v3[1][3][2])?></td>
                                <td class="text-right"><?=number_format($v3[1][3][3])?></td>
                            </tr>
                                <?php
                                }
                                ?>
                            <tr>
                                <td colspan="6" class="pl15"><b>Sub Total <?=$k2?></b></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>- Unit</td>
                                <td class="text-right"><?=$sumType[0][0]?></td>
                                <td class="text-right"><?=$sumType[0][1]?></td>
                                <td class="text-right"><?=$sumType[0][2]?></td>
                                <td class="text-right"><?=$sumType[0][3]?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>- Luas <?=$k2==='High Rise'?'Netto':'Bang.'?></td>
                                <td class="text-right"><?=number_format($sumType[1][0],2)?></td>
                                <td class="text-right"><?=number_format($sumType[1][1],2)?></td>
                                <td class="text-right"><?=number_format($sumType[1][2],2)?></td>
                                <td class="text-right"><?=number_format($sumType[1][3],2)?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>- Luas <?=$k2==='High Rise'?'Gross':'Tanah'?></td>
                                <td class="text-right"><?=number_format($sumType[2][0],2)?></td>
                                <td class="text-right"><?=number_format($sumType[2][1],2)?></td>
                                <td class="text-right"><?=number_format($sumType[2][2],2)?></td>
                                <td class="text-right"><?=number_format($sumType[2][3],2)?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>- Omzet</td>
                                <td class="text-right"><?=number_format($sumType[3][0])?></td>
                                <td class="text-right"><?=number_format($sumType[3][1])?></td>
                                <td class="text-right"><?=number_format($sumType[3][2])?></td>
                                <td class="text-right"><?=number_format($sumType[3][3])?></td>
                            </tr>
                            <?php
                            }
                            ?>
                            <tr>
                                <td colspan="6" class="pl15"><b>Sub Total <?=$k?></b></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>- Unit</td>
                                <td class="text-right"><?=$sumDir[0][0]?></td>
                                <td class="text-right"><?=$sumDir[0][1]?></td>
                                <td class="text-right"><?=$sumDir[0][2]?></td>
                                <td class="text-right"><?=$sumDir[0][3]?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>- Luas <?=$k2==='High Rise'?'Netto':'Bang.'?></td>
                                <td class="text-right"><?=number_format($sumDir[1][0],2)?></td>
                                <td class="text-right"><?=number_format($sumDir[1][1],2)?></td>
                                <td class="text-right"><?=number_format($sumDir[1][2],2)?></td>
                                <td class="text-right"><?=number_format($sumDir[1][3],2)?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>- Luas <?=$k2==='High Rise'?'Gross':'Tanah'?></td>
                                <td class="text-right"><?=number_format($sumDir[2][0],2)?></td>
                                <td class="text-right"><?=number_format($sumDir[2][1],2)?></td>
                                <td class="text-right"><?=number_format($sumDir[2][2],2)?></td>
                                <td class="text-right"><?=number_format($sumDir[2][3],2)?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>- Omzet</td>
                                <td class="text-right"><?=number_format($sumDir[3][0])?></td>
                                <td class="text-right"><?=number_format($sumDir[3][1])?></td>
                                <td class="text-right"><?=number_format($sumDir[3][2])?></td>
                                <td class="text-right"><?=number_format($sumDir[3][3])?></td>
                            </tr>
                        <?
                        }
                        ?>
                        </tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	
</section>
<!-- End: Content -->