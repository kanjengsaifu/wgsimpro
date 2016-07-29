<!-- Begin: Content -->
<section id="content">

    <div class="row">
        <div class="col-md-12 pn">

            <div class="admin-form">

                <div id="p1" class="panel heading-border">

                    <div class="panel-body bg-light">
                        <form method="post" action="javascript:" id="form-ui">
                            <!-- .section-divider -->
                            <!-- nasabah -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="section">
                                        <label class="field"><b>1. DATA NASABAH</b></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">- Nama Nasabah</label>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="section" id="garbaw100">
                                        <label class="field">: <?=$data['nsb_nama']?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">- Alamat</label>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="section" id="garbaw100">
                                        <label class="field">: <?=$data['nsb_alamat']?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">- Telp.</label>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="section" id="garbaw100">
                                        <label class="field">: <?=$data['nsb_telp']?></label>
                                    </div>
                                </div>
                            </div>
                            <!-- Stock -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="section">
                                        <label class="field"><b>2. DATA PRODUK</b></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">- Lantai/Unit</label>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="section" id="garbaw100">
                                        <label class="field">: <?=$data['prod_unit']?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">- Luas Semi Gross</label>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="section" id="garbaw100">
                                        <label class="field">: <?=$data['prod_luas_gross']?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">- Luas Netto</label>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="section" id="garbaw100">
                                        <label class="field">: <?=$data['prod_luas_netto']?></label>
                                    </div>
                                </div>
                            </div>
                            <!-- transaksi -->
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="section">
                                        <label class="field"><b>3. DATA PRODUK YANG DITRANSAKSIKAN</b></label>
                                    </div>
                                </div>
                                <!--
                                <div class="col-md-5">
                                    <div class="section">
                                        <label class="field"><b>PERUBAHAN DATA</b></label>
                                    </div>
                                </div>
                            -->
                            </div>
                            <!--
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">- Harga Jual Netto</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="section" id="garbaw100">
                                        <label class="field">: <?=''//@number_format($data['tr_netto'],2,'.',',')?></label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="section">
                                        <label class="field">- Harga Jual Netto</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="section" id="garbaw100">
                                        <label class="field">: <?=''//@number_format($data['tr_netto'],2,'.',',')?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">- PPN</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="section" id="garbaw100">
                                        <label class="field">: <?=''//@number_format($data['tr_ppn'],2,'.',',')?></label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="section">
                                        <label class="field">- Adendum (+)</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="section" id="garbaw100">
                                        <label class="field">: <?=''//@number_format($data['tr_ad1'],2,'.',',')?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">- BPHTB</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="section" id="garbaw100">
                                        <label class="field">: <?=''//@number_format($data['tr_bphtb'],2,'.',',')?></label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="section">
                                        <label class="field">- Adendum (-)</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="section" id="garbaw100">
                                        <label class="field">: <?=''//@number_format($data['tr_ad2'],2,'.',',')?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">- Surat-surat</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="section" id="garbaw100">
                                        <label class="field">: <?=''//@number_format($data['tr_surat'],2,'.',',')?></label>
                                    </div>
                                </div><div class="col-md-2">
                                    <div class="section">
                                        <label class="field">- Harga Jual Netto</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="section" id="garbaw100">
                                        <label class="field">: <?=''//@number_format($data['tr_netto'],2,'.',',')?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">- Biaya Lola</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="section" id="garbaw100">
                                        <label class="field">: <?=''//@number_format($data['tr_lola'],2,'.',',')?></label>
                                    </div>
                                </div><div class="col-md-2">
                                    <div class="section">
                                        <label class="field">- PPN</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="section" id="garbaw100">
                                        <label class="field">: <?=''//@number_format($data['tr_ppn'],2,'.',',')?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">- Cadangan Bonus</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="section" id="garbaw100">
                                        <label class="field">: <?=''//@number_format($data['tr_bonus'],2,'.',',')?></label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="section">
                                        <label class="field">- BPHTB</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="section" id="garbaw100">
                                        <label class="field">: <?=''//@number_format($data['tr_bphtb'],2,'.',',')?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;"><b>- Total Harga Jual</b></label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="section" id="garbaw100">
                                        <label class="field"><b>: <?=''//number_format($data['tr_jual'],2,'.',',')?></b></label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="section">
                                        <label class="field">- Surat-surat</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="section" id="garbaw100">
                                        <label class="field">: <?=''//@number_format($data['tr_surat'],2,'.',',')?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">&nbsp;</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field">&nbsp;</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="section">
                                        <label class="field">- Biaya Lola</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="section" id="garbaw100">
                                        <label class="field">: <?=''//@number_format($data['tr_lola'],2,'.',',')?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;"></label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field"></label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="section">
                                        <label class="field">- Cadangan Bonus</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="section" id="garbaw100">
                                        <label class="field">: <?=''//@number_format($data['tr_bonus'],2,'.',',')?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;"></label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field"></label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="section">
                                        <label class="field"><b>- Total Harga Jual</b></label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="section" id="garbaw100">
                                    <div class="section">
                                        <label class="field"><b>: <?=''//number_format($data['tr_jual'],2,'.',',')?></b></label>
                                    </div>
                                </div>
                            </div>
                            -->
                            <?php
                            $total = 0;
                            foreach ($data['unit_price'] as $k => $v) {
                                $total += $v['rp'];
                            ?>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">- <?=$v['konten']?></label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="section" id="garbaw100">
                                        <label class="field">: <?=number_format($v['rp'],2,'.',',')?></label>
                                    </div>
                                </div>
                            </div>
                            <?php
                            }
                            ?>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">- Harga Jual Total</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="section" id="garbaw100">
                                        <label class="field">: <?=number_format($total,2,'.',',')?></label>
                                    </div>
                                </div>
                            </div>
                            <!-- Rincian transaksi -->
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="section">
                                        <label class="field"><b>4. RINCIAN PEMBAYARAN DAN PERHITUNGAN PAJAK</b></label>
                                    </div>
                                </div>
                                <div class="col-md-4 text-right">
                                    <div class="section">
                                        <label class="field"><b>Lebih Bayar / Belum Dialokasi: 0.00</b></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered mbn">
                                            <thead>
                                                <tr class="bg-primary light">
                                                    <th rowspan="2" style="vertical-align: middle">No.</th>
                                                    <th colspan="4" style="text-align: center;">Piutang</th>
                                                    <th colspan="3" style="text-align: center;">Pembayaran</th>
                                                    <!--<th colspan="4" style="text-align: center;">Giro</th>-->
                                                    <th colspan="2" style="text-align: center;">Denda</th>
                                                </tr>
                                                <tr class="bg-primary light">
                                                    <th style="text-align: center;">Keterangan</th>
                                                    <th style="text-align: center;">Tgl Tagih</th>
                                                    <th style="text-align: center;">Jth Tempo</th>
                                                    <th style="text-align: center;">Nilai Tagihan (a)</th>
                                                    <th style="text-align: center;">Tgl Bayar</th>
                                                    <th style="text-align: center;">No. Kwitansi</th>
                                                    <th style="text-align: center;">Nilai Bayar (b)</th>
                                                    <!--
                                                    <th style="text-align: center;">Bank Giro</th>
                                                    <th style="text-align: center;">Nomor Giro</th>
                                                    <th style="text-align: center;">Tgl Giro</th>
                                                    <th style="text-align: center;">Nilai Giro (c)</th>
                                                    -->
                                                    <th style="text-align: center;">Hari</th>
                                                    <th style="text-align: center;">Nilai</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                                $iLoop = 1; 
                                                $total_tagihan = $total_bayar = 0;
                                                if(isset($data['payment'])) {

                                                $nama = '';
                                                foreach($data['payment'] as $k => $v) { 
                                                ?>
                                                <tr>
                                                    <td class="text-center"><?=$iLoop?></td>
                                                    <td><?=$v['nama']!==$nama ? $v['nama'] : ''?></td>
                                                    <td class="text-center"><?=$v['nama']!==$nama ? $v['tgl_tempo'] : ''?></td>
                                                    <td class="text-center"><?=$v['nama']!==$nama ? $v['tgl_tempo'] : ''?></td>
                                                    <td class="text-right"><?=$v['nama']!==$nama ? ($v['rp_ra']===''?'':number_format($v['rp_ra'],2,'.',',')) : ''?></td>
                                                    <td class="text-center"><?=$v['tgl_bayar']?></td>
                                                    <td class="text-center"><?=$v['no_kwitansi']?></td>
                                                    <td class="text-right"><?=$v['rp_ri']===''?'':number_format($v['rp_ri'],2,'.',',')?></td>
                                                    <!--
                                                    <td><?=''//$v['bank_giro']?></td>
                                                    <td><?=''//$v['no_giro']?></td>
                                                    <td><?=''//$v['tgl_giro']?></td>
                                                    <td><?=''//$v['rp_giro']?></td>
                                                    -->
                                                    <td><?=$v['hari_denda']?></td>
                                                    <td><?=$v['rp_denda']?></td>
                                                </tr>
                                            <?php 
                                                    $total_tagihan += $nama!==$v['nama'] ? $v['rp_ra'] : 0;
                                                    $total_bayar += $v['rp_ri']==='' ? 0 : $v['rp_ri'];
                                                    $nama = $v['nama'];
                                                    $iLoop++;
                                                }
                                                }?> 
                                                <tr>
                                                    <td colspan="4" class="text-right"><b>Subtotal</b></td>
                                                    <td class="text-right"><b><?=number_format($total_tagihan,2,'.',',')?></b></td>
                                                    <td>&nbsp;</td>
                                                    <td class="text-right"><b><?=number_format($total_bayar/$total_tagihan*100,2)?>%</b></td>
                                                    <td class="text-right"><b><?=number_format($total_bayar,2,'.',',')?></b></td>
                                                    <!--
                                                    <td colspan="2">&nbsp;</td>
                                                    <td><b>.0%</b></td>
                                                    <td><b>0.00</b></td>
                                                    -->
                                                    <td><b>0</b></td>
                                                    <td><b>0.00</b></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">&nbsp;</div>
                            </div>
                            <div class="row <?=isset($data['kpr']) ? '' : 'hidden'?>">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered mbn">
                                            <thead>
                                                <tr class="bg-primary light">
                                                    <th rowspan="2" style="vertical-align: middle;text-align: center;">Keterangan</th>
                                                    <th rowspan="2" style="vertical-align: middle;text-align: center;">%</th>
                                                    <th style="text-align: center;">RA</th>
                                                    <th colspan="2" style="text-align: center;">RI</th>
                                                </tr>
                                                <tr class="bg-primary light">
                                                    <th style="text-align: center;">Rp</th>
                                                    <th style="text-align: center;">TGL</th>
                                                    <th style="text-align: center;">Rp</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            if(isset($data['kpr'])) {
                                                $sKet = '';
                                                $vSum = 0;
                                                foreach ($data['kpr'] as $k => $v) {
                                                    $vSum += $v['ri_rp']!=='' ? $v['ri_rp'] : 0;
                                            ?>
                                                <tr>
                                                    <td><?=$sKet===$v['keterangan']?'':$v['keterangan']?></td>
                                                    <td class="text-center"><?=$sKet===$v['keterangan']?'':$v['persentase']?></td>
                                                    <td class="text-right"><?=$sKet===$v['keterangan']?'':number_format($v['ra_rp'],2)?></td>
                                                    <td class="text-center"><?=$v['ri_tgl']?></td>
                                                    <td class="text-right"><?=$v['ri_rp']!=='' ? number_format($v['ri_rp'],2) : ''?></td>
                                                </tr>
                                            <?php
                                                    $sKet = $v['keterangan'];
                                                }
                                            }
                                            ?>
                                                <tr>
                                                    <td class="text-right" colspan="4"><b>Total</b></td>
                                                    <td class="text-right"><b><?=number_format($vSum,2)?></b></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

</section>
<!-- End: Content -->