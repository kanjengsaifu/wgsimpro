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
                                <th class="text-center" rowspan="2">No</th>
                                <th class="text-center" rowspan="2">Kode</th>
                                <th class="text-center" rowspan="2">Nama Sumberdaya</th>
                                <th class="text-center" colspan="2">Masuk</th>
                                <th class="text-center" colspan="2">Keluar</th>
                                <th class="text-center" colspan="2">Sisa</th>
                                <th class="text-center" rowspan="2">Harga Rata-rata</th>
                            </tr>
                            <tr class="bg-primary light">
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
                        //foreach ($res as $row)
                        foreach($res as $row){
                            #var_dump($row);
                        ?>
                        <tr>
                            <td class="text-right"><?=$n?>&nbsp;&nbsp;&nbsp;</td>
                            <td class="text-center"><?=$row->kode?></td>
                            <td class="text-left"><?=$row->nama?></td>
                            <td class="text-right"><?=number_format($row->vol_in)?></td>
                            <td class="text-right"><?=number_format($row->price_in)?></td>
                            <td class="text-right"><?=number_format($row->vol_out)?></td>
                            <td class="text-right"><?=number_format($row->price_out)?></td>
                            <td class="text-right"><?=number_format($row->vol_sisa)?></td>
                            <td class="text-right"><?=number_format($row->price_sisa)?></td>
                            <td class="text-right"><?=number_format($row->price_avg)?></td>
                        </tr>
                        <?php
                        $_priceIN += $row->price_in;
                        $_priceOUT += $row->price_out;
                        $_priceSISA += $row->price_sisa;
                        $_priceAVG += $row->price_avg;
                        $n++;
                        }
                        ?>
                        </tbody>
                        <tfoot>
                            <tr class="bg-primary light">
                                <td colspan="3" class="text-right">GRAND TOTAL</td>
                                <td class="text-right"></td>
                                <td class="text-right"><?=number_format($_priceIN)?></td>
                                <td class="text-right"></td>
                                <td class="text-right"><?=number_format($_priceOUT)?></td>
                                <td class="text-right"></td>
                                <td class="text-right"><?=number_format($_priceSISA)?></td>
                                <td class="text-right"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

</section>
<!-- End: Content -->