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

<div class="loader"></div>
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
                            <!--h4 class="mbn"><?=str_replace('','',strtoupper(str_replace('[tag] ', 'IKHTISAR ', $data['title_lap']['judul_halaman']) ) )?></h4-->
                            <h4 class="mbn">LAPORAN IKHTISAR APK (JURNAL)</h4>
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
                                <th class="text-center" rowspan="3">No</th>
                                <th class="text-center" rowspan="3">Kode</th>
                                <th class="text-center" rowspan="3">Nama Sumberdaya</th>
                                <th class="text-center" rowspan="2" colspan="2">RAB</th>
                                <th class="text-center" rowspan="2" colspan="2">Saldo Awal</th>
                                <th class="text-center" colspan="4">Mutasi</th>
                                <th class="text-center" rowspan="2" colspan="2">Sisa</th>
                                <th class="text-center" rowspan="3">Harga Rata-rata</th>
                                <th class="text-center" rowspan="2" colspan="2">Material Tersedia</th>
                                <th class="text-center" rowspan="2" colspan="2">Terhadap RAB</th>
                            </tr>
                            </tr>
                            <tr class="bg-primary light">
                                <td class="text-center" colspan="2">Masuk</td>
                                <td class="text-center" colspan="2">Keluar</td>
                            </tr>
                            <tr class="bg-primary light">
                                <td class="text-center">Vol</td>
                                <td class="text-center">Harga</td>
                                <td class="text-center">Vol</td>
                                <td class="text-center">Harga</td>
                                <td class="text-center">Vol</td>
                                <td class="text-center">Harga</td>
                                <td class="text-center">Vol</td>
                                <td class="text-center">Harga</td>
                                <td class="text-center">Vol</td>
                                <td class="text-center">Harga</td>
                                <td class="text-center">Vol</td>
                                <td class="text-center">Harga</td>
                                <td class="text-center">Vol</td>
                                <td class="text-center">Harga</td>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $n=1;
                        $sisa = 0;
                        $_30d = $_90d = $_180d = $_360d = $over_360d = 0;
                        $res = json_decode($data['rows']);
                        $result_array = array();    
                        $_priceRAB = 0;
                        $_volSA = 0;
                        $_priceSA = 0;    
                        $_priceIN = 0;
                        $_priceOUT = 0;
                        $_priceSISA = 0;
                        $_priceAVG = 0;
                        $_volMOV = 0;
                        $_priceMOV = 0;
                        $_volVsRAB = $volRAB = $priceRAB = 0;
                        $_priceVsRAB = $material_vol = $material_price = 0;
                        foreach($res as $row){
                            #var_dump($row);
                            $material_vol = $row->sa_vol+($row->vol_in-$row->vol_out);
                            $material_price = $row->sa_price+($row->price_in-$row->price_out);
                            $volRAB = ($row->rab_vol-$material_vol);
                            $priceRAB = ($row->rab_price-$material_price);
                        ?>
                        <tr>
                            <td class="text-right"><?=$n?>&nbsp;&nbsp;&nbsp;</td>
                            <td class="text-center"><?=$row->kode?></td>
                            <td class="text-left"><?=$row->nama?></td>
                            <!-- RAB -->
                            <td class="text-right"><?=number_format($row->rab_vol)?></td>
                            <td class="text-right"><?=number_format($row->rab_price)?></td>
                            <!-- Saldo Awal -->
                            <td class="text-right"><?=number_format($row->sa_vol)?></td>
                            <td class="text-right"><?=number_format($row->sa_price)?></td>
                            <!-- IN -->
                            <td class="text-right"><?=number_format($row->vol_in)?></td>
                            <td class="text-right"><?=number_format($row->price_in)?></td>
                            <!-- OUT -->
                            <td class="text-right"><?=number_format($row->vol_out)?></td>
                            <td class="text-right"><?=number_format($row->price_out)?></td>
                            <!-- SISA -->
                            <td class="text-right"><?=number_format($row->vol_sisa)?></td>
                            <td class="text-right"><?=number_format($row->price_sisa)?></td>
                            <!-- APK Rata-rata -->
                            <td class="text-right"><?=number_format($row->price_avg)?></td>
                            <!-- APK Bergerak -->
                            <td class="text-right"><?=number_format($row->vol_mov)?></td>
                            <td class="text-right"><?=number_format($row->price_mov)?></td>
                            <!-- Terhadap RAB -->
                            <td class="text-right"><?=number_format($volRAB)?></td>
                            <td class="text-right"><?=number_format($priceRAB)?></td>
                        </tr>
                        <?php
                        $_priceRAB += $row->rab_price;
                        $_volSA += $row->sa_vol;
                        $_priceSA += $row->sa_price; 
                        $_priceIN += $row->price_in;
                        $_priceOUT += $row->price_out;
                        $_priceSISA += $row->price_sisa;
                        $_priceAVG += $row->price_avg;
                        $_priceMOV += $row->price_mov;
                        $_volVsRAB += $row->sa_vol-$row->vol_mov;
                        $_priceVsRAB += $row->rab_price-$row->price_mov;
                        $_volMATERIAL +=$material_vol;
                        $_priceMATERIAL +=$material_price;
                        $n++;
                        }
                        ?>
                        </tbody>
                        <tfoot>
                            <tr class="bg-primary light text-bold">
                                <td colspan="3" class="text-right">GRAND TOTAL</td>
                                <td class="text-right"></td>
                                <td class="text-right"><?=number_format($_priceRAB)?></td>
                                <td class="text-right"></td>
                                <td class="text-right"><?=number_format($_priceSA)?></td>
                                <td class="text-right"></td>
                                <td class="text-right"><?=number_format($_priceIN)?></td>
                                <td class="text-right"></td>
                                <td class="text-right"><?=number_format($_priceOUT)?></td>
                                <td class="text-right"></td>
                                <td class="text-right"><?=number_format($_priceSISA)?></td>
                                <td class="text-right"></td>
                                <td class="text-right"></td>
                                <td class="text-right"><?=number_format($_priceMATERIAL)?></td>
                                <td class="text-right"></td>
                                <td class="text-right"><?=number_format($_priceVsRAB)?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

</section>
<!-- End: Content -->