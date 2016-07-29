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
                            <h4 class="mbn">Laporan Rekening Koran per-SPK</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h5 class="mbn">PERIODE <?=@strtoupper($data['periode'])?></h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <p>Dicetak tanggal: <?=date('d/m/Y H:i:s')?>, Oleh: <?=$data['nama']?></p>
                        </div>
                    </div>
                    
                        <?php
                        
                    echo $data['rows']['kod_spk'];
                    foreach ($data['rows'] as $k => $v) {
                        echo $v['kd_spk'];
                        $debet = $v['rupiah']=='D'?$v['rupiah']:0;
                        $kredit = $v['rupiah']=='K'?$v['rupiah']:0;

                        ?>
                        <div class="row text-left">
                            <div class="col-md-12">
                                <p><b>Proyek: <?=$v['kode_spk']?></b></p>
                            </div>
                        </div>
                        <div class="row text-right">
                            <div class="col-md-12">
                                <p>Saldo Menurut Departemen: Rp. <?=number_format($v['rp_dept'])?></p>
                                <p>Saldo Menurut Proyek: Rp. <?=number_format($v['rp_pro'])?></p>
                            </div>
                        </div>
                        <P>
                        <table id="example" class="table table-bordered mbn">
                        <thead>
                            <tr class="bg-primary light">
                                <th class="text-center">TANGGAL</th>
                                <th class="text-center">NOMOR BUKTI</th>
                                <th class="text-center">URAIAN</th>
                                <th class="text-center">D/K</th>
                                <th class="text-center">RUPIAH</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center <?=$class?>"<?=$style?>><?=$v['tanggal']?></td>
                                <td class="text-center <?=$class?>"<?=$style?>><?=$v['no_bukti']?></td>
                                <td class="<?=$class?>"<?=$style?>><?=$v['keterangan']?></td>
                                <td class="text-right <?=$class?>"<?=$style?>><?=$v['dk']?></td>
                                <td class="text-right <?=$class?>"<?=$style?>><?=number_format($v['rp_pro'])?></td>
                            </tr>
                        <?php
                           
                            if($isSubTotal==12){
                        ?>
                            <tr>
                                <td colspan="5"></td>
                            </tr> 
                        <?php
                            
                            }
                            $t_terbit += $terbit;
                            $t_lunas += $lunas;
                            $t_sisa = $t_terbit-$t_lunas;

                        ?>
                            </tbody>
                            <tfoot>
                                <tr class="bg-primary light">
                                    <th colspan="3" class="text-right"> TOTAL</th>
                                    <th class="text-right"></th>
                                    <th class="text-right"><?=number_format($t_terbit)?></th>
                                </tr>
                            </tfoot>
                        </table>
                        </P>
                        <?php
                            } //end FOR
                        ?>
                        
                </div>
            </div>
        </div>
    </div>

</section>
<!-- End: Content -->