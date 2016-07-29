<div class="se-pre-con"></div>
<section id="content">

    <div class="row">
        <div class="col-md-12 pn">
            <div class="panel">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <!--<h4 class="mbn">PT WIJAYA BANGUN GEDUNG</h4>-->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="mbn">KAWASAN <?=@$data['kawasan']?></h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h4 class="mbn"><?=str_replace('','',strtoupper(str_replace('[tag] ', 'RINCIAN ', $data['title_lap']['judul_halaman']) ) )?></h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h5 class="mbn">PERIODE <?=@strtoupper($data['periode'])?></h5>
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
                    <table id="example" class="table table-bordered mbn export2excel">
                        <thead>
                            <tr class="bg-primary light">
                                <th class="text-center">TANGGAL</th>
                                <th class="text-center">NOMOR BUKTI</th>
                                <th class="text-center">URAIAN</th>
                                <?=$data['is_rpt_show']['is_tmp_faktur']==1? '<td class="text-center"><b>FAKTUR</b></td>':''?>
                                <!--th class="text-center">FAKTUR</th-->
                                <th class="text-center">PENERBITAN</th>
                                <th class="text-center">PELUNASAN</th>
                                <th class="text-center">SISA</th>
                                <th class="text-center">UMUR</th>
                                <th class="text-center">CATATAN</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $t_terbit =0;
                            $t_lunas =0;
                            $t_sisa = 0;
                            $t_sub_penerbitan = 0;
                            $t_sub_pelunasan = 0;
                            foreach ($data['rows'] as $k => $v) {
                                
                                $isSubTotal = strspn($v['keterangan'],'SISA PERNAS');
                                $isSisaTotal = strspn($v['keterangan'],'SISA');
                                if($isSubTotal==12){
                                    $class = 'text-right text-bold';
                                    $style = 'style="background-color: #D3D3D3; color: #696969;"';
                                }else if($isSisaTotal==4){
                                    $class = 'text-right text-bold';
                                    $style = '';
                                }else{
                                    $class = 'text-left';
                                    $style = '';
                                }

                                $terbit = number_format($v['penerbitan']);
                                $lunas = number_format($v['pelunasan']);
                                $t_sisa = $terbit-$lunas;
                                $is_closed1 = $v['closed'];
                                $is_closed2 = $v['closed2'];
                                $t_terbit += $v['penerbitan'];
                                $t_lunas += $v['pelunasan'];
                                //if($v['keterangan'])
                                if($v['label']=='A2'){
                                    $sisa_a2 = $v['sisa'];
                                }else{
                                    if($v['label']=='B'){
                                        $sisa_a2 = $v['sisa'];
                                        $terbit_b = number_format($v['penerbitan']);
                                        $lunas_b = number_format($v['pelunasan']);
                                    }else{
                                        $sisa_a2 = '';
                                    }
                                    //$sisa_a2 = '';//$v['sisa'];
                                }
                               //if($is_closed1!=$is_closed2){
                                //if($v['keterangan']!=='SISA'){
                               // if($v['label']!=='B'){
                        ?>
                            <tr>
                            <?php 
                                if($v['label']<>'B'){
                            ?>
                                <td class="text-center <?=$class?>"<?=$style?>><?=$v['tanggal']?></td>
                                <td class="text-center <?=$class?>"<?=$style?>><?=$v['no_bukti']?></td>
                            <?php } ?>
                                <td <?=$isSubTotal==12?'colspan="3" ':''?> class="<?=$class?>"<?=$style?>> <?=$v['label']=='B'?'<b>'.($v['keterangan']!='SISA'?$v['keterangan']:'').'</b>':($v['keterangan']!='SISA'?$v['keterangan']:'')?></td>
                                <?=$data['is_rpt_show']['is_tmp_faktur']==1?'<td class="text-center" '.$class.' '.$style.'>'.$v['kode_faktur'].'</td>':''?>
                                <td class="text-right <?=$class?>"<?=$style?>><?=number_format($v['penerbitan'])?></td>
                                <td class="text-right <?=$class?>"<?=$style?>><?=number_format($v['pelunasan'])?></td>
                                <td class="text-right <?=$class?>"<?=$style?>><?=number_format($sisa_a2)?></td>
                                <td class="text-center <?=$class?>"<?=$style?>><?=$v['label']=='A2'?$v['umur']:''?></td>
                                <td class="text-center <?=$class?>"<?=$style?>></td>
                            </tr>
                            <?php 
                                //}
                                
                           //}
                            if($isSubTotal==12){
                        ?>
                            <tr>
                                <td colspan="7"></td>
                            </tr> 
                        <?php
                            
                            }
                            $t_terbit += $terbit;
                            $t_lunas += $lunas;
                            $t_sisa = $t_terbit-$t_lunas;
                            }
                        ?>
                        </tbody>
                        <tfoot>
                            <tr class="bg-primary light">
                                <th colspan="3" class="text-right">GRAND TOTAL</th>
                                <?=$data['is_rpt_show']['is_tmp_faktur']==1? '<td class="text-center">&nbsp;</td>':''?>
                                <th class="text-right"><?=number_format($t_terbit)?></th>
                                <th class="text-right"><?=number_format($t_lunas)?></th>
                                <th class="text-right"><?=number_format($t_sisa)?></th>
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