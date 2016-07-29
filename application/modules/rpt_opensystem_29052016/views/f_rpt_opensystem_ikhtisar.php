<div class="se-pre-con"></div>
<section id="content" >

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
                            <h4 class="mbn"><?=str_replace('','',strtoupper(str_replace('[tag] ', 'IKHTISAR ', $data['title_lap']['judul_halaman']) ) )?></h4>
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
                                <th class="text-center" rowspan="2">No</th>
                                <th class="text-center" rowspan="2">Kode</th>
                                <th class="text-center" rowspan="2">Nama Nasabah</th>
                                <th class="text-center" rowspan="2">Sisa</th>
                                <th class="text-center" colspan="5">Umur</th>
                            </tr>
                            <tr class="bg-primary light">
                                <td class="text-center">< 1 Bulan</td>
                                <td class="text-center">1 - 3 Bulan</td>
                                <td class="text-center">3 - 6 Bulan</td>
                                <td class="text-center">6 Bulan - 1 Tahun</td>
                                <td class="text-center">> 1 Tahun</td>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $n=1;
                        $sisa = 0;
                        $_30d = $_90d = $_180d = $_360d = $over_360d = 0;
                        foreach($data['rows'] as $row => $v){
                        ?>
                        <tr>
                            <td class="text-right"><?=$n?>&nbsp;&nbsp;&nbsp;</td>
                            <td class="text-center"><?=$v['kode_nasabah']?></td>
                            <td class="text-left"><?=$v['nama_nasabah']?></td>
                            <td class="text-right"><?=number_format($v['sisa'])?></td>
                            <td class="text-right"><?=number_format($v['_30d'])?></td>
                            <td class="text-right"><?=number_format($v['_90d'])?></td>
                            <td class="text-right"><?=number_format($v['_180d'])?></td>
                            <td class="text-right"><?=number_format($v['_360d'])?></td>
                            <td class="text-right"><?=number_format($v['_over360d'])?></td>
                        </tr>
                        <?php
                        $sisa += $v['sisa'];
                        $_30d += $v['_30d'];
                        $_90d += $v['_90d'];
                        $_180d += $v['_180d'];
                        $_360d += $v['_360d'];
                        $over_360d += $v['_over360d'];
                        $n++;
                        }
                        ?>
                        </tbody>
                        <tfoot>
                            <tr class="bg-primary light">
                                <td colspan="3" class="text-right">GRAND TOTAL</td>
                                <td class="text-right"><?=number_format($sisa)?></td>
                                <td class="text-right"><?=number_format($_30d)?></td>
                                <td class="text-right"><?=number_format($_90d)?></td>
                                <td class="text-right"><?=number_format($_180d)?></td>
                                <td class="text-right"><?=number_format($_360d)?></td>
                                <td class="text-right"><?=number_format($over_360d)?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

</section>
<!-- End: Content -->