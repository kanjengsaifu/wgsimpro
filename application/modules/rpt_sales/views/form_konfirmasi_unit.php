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
                                        <label class="field"><b>1. DATA NASABAH</b></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">- Nama Nasabah</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="section" id="garbaw100">
                                        <label class="field">: &nbsp;&nbsp;<?=$data['nsb_nama']?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">- Alamat KTP</label>
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
                                        <label class="field" style="padding-left:20px;">- Alamat Email</label>
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
                                        <label class="field" style="padding-left:20px;">- Tempat / Tanggal Lahir</label>
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
                                        <label class="field" style="padding-left:20px;">- Alamat Domisili</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="section" id="garbaw100">
                                        <label class="field">:&nbsp;&nbsp;<?=$data['nsb_domisili']?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">- Penanggung Jawab</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="section">
                                        <label class="field">&nbsp;</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">   ( Jika atas nama perusahaan )</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="section">
                                        <label class="field">: &nbsp;</label>
                                    </div>
                                </div>
                            </div>
                            <!-- Pekerjaan -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="section">
                                        <label class="field"><b>2. DATA PEKERJAAN DAN PENGHASILAN</b></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">- Nama Perusahaan</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="section" id="garbaw100">
                                        <label class="field">:&nbsp;&nbsp;<?=$data['nsb_nama_pt']?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">- Alamat Perusahaan</label>
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
                                        <label class="field" style="padding-left:20px;">- Kota / Kodepos</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="section" id="garbaw100">
                                        <label class="field">:&nbsp;&nbsp;<?=$data['nsb_kota_pt']?> / <?=$data['nsb_kodepos_pt']?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">- Telepon Kantor (area + no. + ext)</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="section" id="garbaw100">
                                        <label class="field">:&nbsp;&nbsp;<?=$data['nsb_telp_pt']?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">- No. Fax</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="section" id="garbaw100">
                                        <label class="field">:&nbsp;&nbsp;<?=$data['nsb_fax_pt']?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">- Jenis Pekerjaan dan Status</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="section">
                                        <label class="field">:&nbsp;&nbsp;[ ] Pegawai Negeri</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="section">
                                        <label class="field">[ ] Karywan Swasta</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="section">
                                        <label class="field">Status : [ ] Pegawai Tetap</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                    
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="section">
                                        <label class="field">&nbsp;&nbsp;[ ] Karyawan BUMN</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="section" >
                                        <label class="field">[ ] Wiraswasta</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="section">
                                        <label class="field">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [ ] Pegawai Tidak Tetap</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                    
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="section">
                                        <label class="field">&nbsp;&nbsp;[<?=$data['nsb_jenis_job']?> ] Profesional</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="section">
                                        <label class="field"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">- Lama Bekerja</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="section">
                                        <label class="field">:&nbsp;&nbsp;[<?=$data['nsb_lama_kerja']<=5?'<b>X</b>':'&nbsp;&nbsp;'?>] 0 - 5 Thn</label>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="section">
                                        <label class="field">[<?=($data['nsb_lama_kerja']>5&&$data['nsb_lama_kerja']<=10)?'<b>X</b>':'&nbsp;&nbsp;'?>] 6 - 10 Thn</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="section">
                                        <label class="field">[<?=($data['nsb_lama_kerja']>10&&$data['nsb_lama_kerja']<=15)?'<b>X</b>':'&nbsp;&nbsp;'?>] 11 - 15 Thn</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="section">
                                        <label class="field">[<?=($data['nsb_lama_kerja']>15)?'<b>X</b>':'&nbsp;&nbsp;'?>] lebih dari 15 Thn</label>
                                    </div>
                                </div>
                                <!--div class="col-md-6">
                                    <div class="section" id="garbaw100">
                                        <label class="field">: <?=$data['nsb_lama_kerja']?></label>
                                    </div>
                                </div-->
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">- Jenis Usaha</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="section" id="garbaw100">
                                        <label class="field">:&nbsp;&nbsp;<?=$data['nsb_jenis_usaha']?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section"> 
                                        <label class="field" style="padding-left:20px;">- Jabatan</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="section" id="garbaw100">
                                        <label class="field">:&nbsp;&nbsp;<?=$data['nsb_jabatan']?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">- Pendapatan Kantor Tetap perbulan</label>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="section">
                                        <label class="field">:&nbsp;&nbsp;[<?=$data['nsb_pendapatan']<=8?'<b>X</b>':'&nbsp;&nbsp;'?>] 1 - 8 Jt</label>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="section">
                                        <label class="field">[<?=($data['nsb_pendapatan']>8&&$data['nsb_pendapatan']<=16)?'<b>X</b>':'&nbsp;&nbsp;'?>] 9 - 16 Jt</label>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="section">
                                        <label class="field">[<?=($data['nsb_pendapatan']>16&&$data['nsb_pendapatan']<=24)?'<b>X</b>':'&nbsp;&nbsp;'?>] 17 - 24 Jt</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="section">
                                        <label class="field">[<?=($data['nsb_pendapatan']>24)?'<b>X</b>':'&nbsp;&nbsp;'?>] lebih dari 24 Jt</label>
                                    </div>
                                </div>
                                <!--div class="col-md-6">
                                    <div class="section" id="garbaw100">
                                        <label class="field">: <?=$data['nsb_pendapatan']?></label>
                                    </div>
                                </div-->
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">- Sumber pendapatan tambahan</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="section" id="garbaw100">
                                        <label class="field">:&nbsp;&nbsp;<?=$data['nsb_sumber_pendapatan_tambahan']?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">- Pendapatan kantor tambahan perbulan</label>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="section">
                                        <label class="field">:&nbsp;&nbsp;[<?=($data['nsb_pendapatan_tambahan']>0&&$data['nsb_pendapatan_tambahan']<=10)?'<b>X</b>':'&nbsp;&nbsp;'?>] 1 - 10 Jt</label>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="section">
                                        <label class="field">[<?=($data['nsb_pendapatan_tambahan']>10&&$data['nsb_pendapatan_tambahan']<=16)?'<b>X</b>':'&nbsp;&nbsp;'?>] 10 - 20 Jt</label>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="section">
                                        <label class="field">[<?=($data['nsb_pendapatan_tambahan']>20&&$data['nsb_pendapatan_tambahan']<=24)?'<b>X</b>':'&nbsp;&nbsp;'?>] 20 - 30 Jt</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="section">
                                        <label class="field">[<?=($data['nsb_pendapatan_tambahan']>30)?'<b>X</b>':'&nbsp;&nbsp;'?>] lebih dari 30 Jt</label>
                                    </div>
                                </div>
                                <!--div class="col-md-6">
                                    <div class="section" id="garbaw100">
                                        <label class="field">: <?=$data['nsb_pendapatan_tambahan']?></label>
                                    </div>
                                </div-->
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">- NPWP</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="section" id="garbaw100">
                                        <label class="field">:&nbsp;&nbsp;<?=$data['nsb_npwp']?></label>
                                    </div>
                                </div>
                            </div>
                            <!-- tujuan -->
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field"><b>3. TUJUAN PEMBELIAN</b></label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="section">
                                        <label class="field">:&nbsp;&nbsp;[<?=($data['nsb_pendapatan_tambahan']>0&&$data['nsb_pendapatan_tambahan']<=10)?'<b>X</b>':'&nbsp;&nbsp;'?>] Investasi</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="section">
                                        <label class="field"> [<?=($data['nsb_pendapatan_tambahan']>0&&$data['nsb_pendapatan_tambahan']<=10)?'<b>X</b>':'&nbsp;&nbsp;'?>] Hadiah</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="section">
                                        <label class="field">:&nbsp;&nbsp;[<?=($data['nsb_pendapatan_tambahan']>0&&$data['nsb_pendapatan_tambahan']<=10)?'<b>X</b>':'&nbsp;&nbsp;'?>] Ditempati</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="section">
                                        <label class="field"> [<?=($data['nsb_pendapatan_tambahan']>0&&$data['nsb_pendapatan_tambahan']<=10)?'<b>X</b>':'&nbsp;&nbsp;'?>] .....................</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="section">
                                        <label class="field">:&nbsp;&nbsp;[<?=($data['nsb_pendapatan_tambahan']>0&&$data['nsb_pendapatan_tambahan']<=10)?'<b>X</b>':'&nbsp;&nbsp;'?>] Disewakan</label>
                                    </div>
                                </div>
                            </div>
                            <!-- Stock -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="section">
                                        <label class="field"><b>4. DATA PESANAN</b></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">- Blok/Kav</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="section" id="garbaw100">
                                        <label class="field">:&nbsp;&nbsp;<?=$data['prod_blok']?>/<?=$data['prod_kavling']?>&nbsp;&nbsp;&nbsp;&nbsp;No. <?=$data['prod_unit']?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">- Tipe</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="section" id="garbaw100">
                                        <label class="field">:&nbsp;&nbsp;<?=$data['prod_type']?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">- Luas Bangunan</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="section" id="garbaw100">
                                        <label class="field">:&nbsp;&nbsp;<?=$data['prod_luas_netto']?> M2</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">- Luas Tanah</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="section" id="garbaw100">
                                        <label class="field">:&nbsp;&nbsp;<?=$data['prod_luas_gross']?> M2</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">- Kondisi Kavling</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="section" id="garbaw100">
                                        <label class="field">:&nbsp;&nbsp;<?=($data['prod_kondisi']=='STANDARD')?'<strike><b>Standard</b></strike>':'Standard'?> / <?=($data['prod_kondisi']=='HOOK')?'<strike><b>Hook</b></strike>':'Hook'?> / <?=($data['prod_kondisi']=='TAMAN')?'<strike><b>Depan taman</b></strike>':'Depan Taman'?>  <i>*)</i></label>
                                    </div>
                                </div>
                                <!--div class="col-md-6">
                                    <div class="section" id="garbaw100">
                                        <label class="field">: <?=$data['prod_kondisi']?></label>
                                    </div>
                                </div-->
                            </div>
                            <!-- Harga -->
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field"><b>5. TOTAL HARGA JUAL</b></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="section" id="garbaw100">
                                        <label class="field">:&nbsp;&nbsp;Rp. <?=number_format($data['tr_jual'],2,'.',',')?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">- Terbilang</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="section" id="garbaw100">
                                        <label class="field">:&nbsp;&nbsp;<i><?=$data['terbilang']?></i></label>
                                    </div>
                                </div>
                            </div>
                            <!-- Payment plan -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="section">
                                        <label class="field"><b>6. KESEPAKATAN PEMBAYARAN</b></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="section">
                                        <label class="field" style="padding-left:20px;">Cara Pembayaran</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="section">
                                        <label class="field">:&nbsp;&nbsp;[<?=($data['pay_cara_bayar']=='CASH KERAS')?'<b>X</b>':'&nbsp;&nbsp;'?>] Cash Keras</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="section">
                                        <label class="field">[<?=($data['pay_cara_bayar']=='CASH BERTAHAP')?'<b>X</b>':'&nbsp;&nbsp;'?>] Cash Bertahap</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="section">
                                        <label class="field">[<?=($data['pay_cara_bayar']=='KPR / KPA')?'<b>X</b>':'&nbsp;&nbsp;'?>] KPR</label>
                                    </div>
                                </div>
                                <!--div class="col-md-6">
                                    <div class="section" id="garbaw100">
                                        <label class="field">: <?=$data['pay_cara_bayar']?></label>
                                    </div>
                                </div-->
                            </div>
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

                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

</section>
<!-- End: Content -->