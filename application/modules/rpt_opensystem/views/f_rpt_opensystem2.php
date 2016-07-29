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
                            <h4 class="mbn">LAPORAN RINCIAN HUTANG <?=strtoupper($data['title_lap']['judul_halaman'])?></h4>
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
                    <!--table id="example" class="table table-bordered mbn">
                        <thead>
                            <tr class="bg-primary light">
                                <th class="text-center"></th>
                                <th class="text-center">TANGGAL</th>
                                <th class="text-center">NOMOR BUKTI</th>
                                <th class="text-center">URAIAN</th>
                                <th class="text-center">PENERBITAN</th>
                                <th class="text-center">PELUNASAN</th>
                                <th class="text-center">SISA</th>
                                <th class="text-center">UMUR</th>
                            </tr>
                        </thead>
                        <tbody-->
                        <?php
                            $t_terbit =0;
                            $t_lunas =0;
                            $t_sisa = 0;
                            
                            $this->load->helper('generator');
                            echo tr_opensystem($data['modul'],$data['periode']);
                        ?>
                        <!--/tbody>
                        <tfoot>
                            <tr class="bg-primary light">
                                <th colspan="3" class="text-right">GRAND TOTAL</th>
                                <th class="text-right"><?=number_format($t_terbit)?></th>
                                <th class="text-right"><?=number_format($t_lunas)?></th>
                                <th class="text-right"><?=number_format($t_sisa)?></th>
                                <th class="text-right"></th>
                            </tr>
                        </tfoot>
                    </table-->
                </div>
            </div>
        </div>
    </div>

</section>
<!-- End: Content -->