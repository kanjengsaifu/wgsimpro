<style type="text/css">
#garbaw100 {
    border-bottom: 1px dashed #999;
    width: 100%;
}
</style>
<!-- Begin: Content -->
<section id="content">

    <div class="row">
        <div class="col-md-12 pn">

            <div class="admin-form">

                <div id="p1" class="panel heading-border">

                    <div class="panel-body bg-light">
                        <form method="post" action="javascript:" id="form-ui">
                            
                            <!-- nasabah -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="section">
                                        <label class="field">Yang bertanda tangan di bawah ini:</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">1. Nama Lengkap (sesuai KTP)</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="section" id="garbaw100">
                                        <label class="field">:&nbsp;&nbsp;<?=$data['nsb_nama']?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">2. Tempat / Tanggal Lahir</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="section" id="garbaw100">
                                        <label class="field">:&nbsp;&nbsp;<?=$data['nsb_tempat_lahir']?>, <?=$data['nsb_tgl_lahir']?></label>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="section">
                                        <label class="field">Hp</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="section" id="garbaw100">
                                        <label class="field">:&nbsp;&nbsp;<?=$data['nsb_hp']?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">3. Alamat Lengkap</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="section" id="garbaw100">
                                        <label class="field">:&nbsp;&nbsp;<?=$data['nsb_alamat']?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">&nbsp;</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="section" id="garbaw100">
                                        <label class="field">:&nbsp;&nbsp;<?=$data['nsb_alamat_pt']?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">4. No. Telp</label>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="section">
                                        <label class="field">Rumah</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="section" id="garbaw100">
                                        <label class="field">:&nbsp;&nbsp;<?=$data['nsb_telp']?></label>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="section">
                                        <label class="field">Tlp. Kantor</label>
                                    </div>
                                </div>
                                <div class="col-md-2" >
                                    <div class="section" id="garbaw100">
                                        <label class="field">:&nbsp;&nbsp;<?=$data['nsb_telp_pt']?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">&nbsp;</label>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="section">
                                        <label class="field">HP</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="section" id="garbaw100">
                                        <label class="field">: <?=$data['nsb_hp']?></label>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="section">
                                        <label class="field">Fax</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="section" id="garbaw100">
                                        <label class="field">: <?=$data['nsb_fax']?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">5. Email</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="section" id="garbaw100">
                                        <label class="field">:&nbsp;&nbsp;<?=$data['nsb_email']?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">6. No. KTP</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="section" id="garbaw100">
                                        <label class="field">:&nbsp;&nbsp;<?=$data['nsb_noktp']?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">7. NPWP</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="section" id="garbaw100">
                                        <label class="field">:&nbsp;&nbsp;<?=$data['nsb_noktp']?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="section">
                                        <label class="field">dalam hal ini bertindak untuk dan atas nama diri sendiri, yang untuk selanjutnya disebut <b>Pemesan</b>.</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="section">
                                        <label class="field">Dengan ini sepakat untuk memesan 1 (satu) unit <?=$data['ent_nama']?> (satuan rumah susun) sebagai berikut:</label>
                                    </div>
                                </div>
                            </div>
                            <!-- produk -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="section">
                                        <label class="field"><b>I.&nbsp;&nbsp;&nbsp;&nbsp;DATA PRODUK</b></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">1. Kawasan <?=$data['type_entity']=='LANDED'?'Perumahan':'Apartemen'?></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="section" id="garbaw100">
                                        <label class="field">:&nbsp;&nbsp;<?=$data['ent_nama']?></label>
                                    </div>
                                </div>
                            </div>
                <?php
                    if($data['type_entity'] != 'LANDED')
                    {
                ?>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">2. Lantai/No. Unit</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="section" id="garbaw100">
                                        <label class="field">:&nbsp;&nbsp;<?=$data['prod_unit']?></label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="section" id="garbaw100">
                                        <label class="field">:&nbsp;&nbsp;<?=$data['prod_nounit']?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">3. Luas Unit (netto)</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="section" id="garbaw100">
                                        <label class="field">:&nbsp;&nbsp;<?=$data['prod_luas_netto']?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">4. Luas Unit (semigross)</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="section" id="garbaw100">
                                        <label class="field">:&nbsp;&nbsp;<?=$data['prod_luas_gross']?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">5. Peruntukan</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="section" id="garbaw100">
                                        <label class="field">:&nbsp;&nbsp;<?=$data['prod_type']?></label>
                                    </div>
                                </div>
                            </div>
                            <?php 
                                }else{
                            ?>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">2. Blok / Kavling</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="section" id="garbaw100">
                                        <label class="field">:&nbsp;&nbsp;<?=$data['prod_blok'].' / '.$data['prod_kavling']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tipe Bangunan:&nbsp;</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">3. Luas</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="section" id="garbaw100">
                                        <label class="field">:&nbsp;&nbsp;Tanah: <?=$data['prod_luas_gross']?> M<sup>2</sup>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bangunan: <?=$data['prod_luas_netto']?> M<sup>2</sup></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">4. No.Kode Gambar/Spesifikasi</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="section" id="garbaw100">
                                        <label class="field">:&nbsp;&nbsp;</label>
                                    </div>
                                </div>
                            </div>
                            <?php
                                }
                            ?>
                            <!-- Harga -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="section">
                                        <label class="field"><b>II.&nbsp;&nbsp;&nbsp;HARGA UNIT PESANAN</b></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                            <?php
                                if($data['type_entity'] != 'LANDED')
                                {
                            ?>
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">A. Harga Unit Pesanan</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="section" id="garbaw100">
                                        <label class="field">: Rp. <?=number_format($data['tr_jual'],2,'.',',')?></label>
                                    </div>
                                </div>
                                <?php }else{ ?>
                                <div class="col-md-6">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">Harga Kavling dengan / tanpa Banunan  <b>Rp. <?=number_format($data['tr_jual'],2,'.',',')?></b></label>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                            
                            <div class="row">
                                <?php
                                    if($data['type_entity'] == 'LANDED')
                                    {
                                ?>
                                <div class="col-md-6">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">Terbilang :&nbsp;&nbsp;<i><b># <?=$data['terbilang']?> #</b></i></label>
                                    </div>
                                </div>
                                <?php } else { ?>
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">Terbilang </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="section" id="garbaw100">
                                        <label class="field">:&nbsp;&nbsp;#<?=$data['terbilang']?>#</label>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                            <?php
                                    if($data['type_entity'] == 'LANDED')
                                    {
                                ?>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;"><i><b>Harga tersebut sudah termasuk Pajak Pertambahan Nilai (PPN), BPHTB, Akad jual Beli (AJB)/PPAT, Sertifikat HGB, IMB dan Biaya Pengelolaan</i></b></label>
                                    </div>
                                </div>
                            </div>
                            <?php }else{ ?>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">Harga tersebut sudah termasuk Pajak Pertambahan Nilai (PPN)</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">C. Ketentuan harga unit pesanan sebagaimana syarat dan ketentuan umum surat pesanan yang tercantum pada lampiran Surat Pesanan ini</label>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>

                            <!-- Payment plan -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="section">
                                        <label class="field"><b>III.&nbsp;&nbsp;CARA PEMBAYARAN</b></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">Pembayaran dilakukan dengan cara : <b><?=$data['pay_cara_bayar']?></b>&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;<?=($data['pay_cara_bayar']=='KPR / KPA'||$data['pay_cara_bayar']=='CASH BERTAHAP'?'KPR Bank: <b>'.$data['nama_bank'].'</b>':'')?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">dengan rincian sebagai berikut : </label>
                                    </div>
                                </div>
                            </div>
                <?php
                    if($data['type_entity'] != 'LANDED')
                    {
                ?>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">a. Uang Muka</label>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="section" id="garbaw100">
                                        <label class="field">:&nbsp;&nbsp;Rp. <?=number_format($data['pay_um'],2,'.',',')?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;"> - Reserved</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="section" id="garbaw100">
                                        <label class="field">:&nbsp;&nbsp;Rp. <?=number_format($data['pay_reserve'],2,'.',',')?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;"> - Tanda Jadi</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="section" id="garbaw100">
                                        <label class="field">:&nbsp;&nbsp;Rp. <?=number_format($data['pay_jadi'],2,'.',',')?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">b. Rencana KPR</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="section" id="garbaw100">
                                        <label class="field">:&nbsp;&nbsp;Rp. <?=number_format($data['pay_kpr'],2,'.',',')?></label>
                                    </div>
                                </div>
                            </div>
                        
                <?php }else{ 
                        $loop=0;
                        //echo count($data['pays']);
                        $dd = array();
                        $dd = $data['pays'];
                        $total_rp = 0;
                        echo '<div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">A. UANG MUKA PESANAN</label>
                                    </div>
                                </div>
                            </div>';
                        for($i=0;$i<count($data['angsurans']);$i++) {
                            //echo $i.':: '.$dd[$i]['nama']." --- ".$dd[$i]['rp']." --- ".$dd[$i]['no_urut']."<br>";
                            //$total_rp=$dd[$i]['rp'];
                            if (!preg_match('/Ang/',@$dd[$i]['nama'])){
                            ?>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">&nbsp;&nbsp;&nbsp;<?php echo '&nbsp;&nbsp;'.($i+1).'. '.@$dd[$i]['nama'];?></label>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="section">
                                        <label class="field">:&nbsp;&nbsp;Rp. <?php echo @number_format($dd[$i]['rp'],2);?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo @$dd[$i]['tgl_bayar'];?></label>
                                    </div>
                                </div>
                            </div>
                            <?php

                               $total_rp +=@$dd[$i]['rp'];
                                }
                            }
                            ?>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(a)&nbsp;Total</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="section">
                                        <label class="field"><u>:&nbsp;&nbsp;Rp. <?=@number_format($total_rp,2);?></u></label>
                                    </div>
                                </div>
                            </div>
                      <?php

                        echo '<div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">B. PELUNASAN PESANAN</label>
                                    </div>
                                </div>
                            </div>';
                        for($i=0;$i<count($data['angsurans']);$i++) {
                            //echo $i.':: '.$dd[$i]['nama']." --- ".$dd[$i]['rp']." --- ".$dd[$i]['no_urut']."<br>";
                            //$total_rp=$dd[$i]['rp'];
                            if (preg_match('/Ang/',@$dd[$i]['nama'])){
                            ?>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">&nbsp;&nbsp;&nbsp;<?php echo '&nbsp;&nbsp;'.($i).'. '.@$dd[$i]['nama'];?></label>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="section">
                                        <label class="field">:&nbsp;&nbsp;Rp. <?php echo @number_format($dd[$i]['rp'],2);?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo @$dd[$i]['tgl_bayar'];?></label>
                                    </div>
                                </div>
                            </div>
                            <?php
                                $total_rp2 =0;
                               $total_rp2 +=@$dd[$i]['rp'];
                                }
                            }
                            ?>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(b)&nbsp;Total</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="section">
                                        <label class="field"><u>:&nbsp;&nbsp;Rp. <?=@number_format($total_rp2,2);?></u></label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total&nbsp;&nbsp;(a+b)</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="section">
                                        <label class="field">:&nbsp;&nbsp;Rp. <?=@number_format($total_rp+@$total_rp2,2);?></label>
                                    </div>
                                </div>
                            </div>

                            <!-- IV PENYERAHAN PRODUK -->
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="section">
                                        <label class="field"><b>IV.&nbsp;&nbsp;PEMBANGUNAN DAN / ATAU PENYERAHAN PRODUK</b></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">&nbsp;&nbsp;&nbsp;&nbsp;1. Pembangunan dilaksanakan setelah pembayaran Uang Muka Lunas</label>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">&nbsp;&nbsp;&nbsp;&nbsp;2. Waktu Penyerahan <i>12 (dua belas) bulan sejak pelunasan pembayaran</i></label>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">&nbsp;&nbsp;&nbsp;&nbsp;3. Masa Pemeliharaan <i>100 (seratus) hari sejak tanggal pemeliharaan</i></label>
                                    </div>
                                </div>
                            </div>

                            <!-- V LAIN-LAIN -->
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="section">
                                        <label class="field"><b>V.&nbsp;&nbsp;PEMBANGUNAN DAN / ATAU PENYERAHAN PRODUK</b></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">Pemesan bersedia memenuhi peraturan dan persyaratan yang ditetapkan oleh PT. Wika Realty yang diatur dalam Ketentuan Umum Pemesanan Kavling dengan Bangunan sebagaimana terlampir</label>
                                    </div>
                                </div>
                            </div>
                      <?php } //END IF ?>

                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

</section>
<!-- End: Content -->