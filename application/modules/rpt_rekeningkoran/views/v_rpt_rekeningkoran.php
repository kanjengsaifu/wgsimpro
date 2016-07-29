
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
                            <h4 class="mbn">LAPORAN REKENINGKORAN KONSOLIDASI</h4>
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
                        <!--div class="col-md-2 text-right">
                            <button id="exp2excel" name="exp2excel">Export To Excel</button>
                        </div-->
                    </div>
                    <?php
                        $this->load->helper('generator');

                        $spk = json_decode($data['spk'], true);


                        foreach($spk as $row => $v){
                            $sa_proyek = saldo_outstanding_rk($v['kd_spk'],$data['periode_lap'],'PROYEK');
                            $sa_dept = saldo_outstanding_rk($v['kd_spk'],$data['periode_lap'],'DEPARTEMEN');
                            $jum_sa = ($sa_dept+$sa_proyek);
                            $t_dep = $t_pro = $t_spk = 1000000;

                    ?>
                    <!-- 
                        DEPARTEMENT 
                    -->
                    <table id="t_top_d" class="export2excel table mbn" data-tableName="top_dep">
                        <tbody>
                            <tr>
                                <!--td class="text-left" style="width:15%;background-color: #<?=substr(md5(rand()), 0, 6);?>"><b>SPK : <?=$v['kd_spk'].' - '.$v['nama_entity']?></b></td-->
                                <td class="text-left" style="width:25%;"><b>SPK : <?=$v['kd_spk'].' - '.$v['nama_entity']?></b></td>
                                <td class="text-right" style="width:60%;"><b>Saldo menurut Departemen</b></td>
                                <td class="text-left" style="width:5%;">Rp.</td>
                                <td class="text-right" style="width:10%;"><?=($sa_dept!=null?number_format($sa_dept,0):0)?></td>
                            </tr>
                            <tr>
                                <td class="text-left"></td>
                                <td class="text-right"><b>Saldo menurut Proyek</b></td>
                                <td class="text-left">Rp.</td>
                                <td class="text-right"><?=($sa_proyek!=null?number_format($sa_proyek,0):0)?></td>
                            </tr>
                            <tr>
                                <td class="text-left"><b>Belum dibuku oleh Departemen</b></td>
                                <td class="text-left"></td>
                                <td class="text-left">Rp.</td>
                                <td class="text-right"><b><?=($jum_sa!=null?number_format($jum_sa,0):0)?></b></td>
                            </tr>
                        </tbody>
                    </table>
                    <table id="t_departemen" class="export2excel table table-bordered mbn ">
                        <thead>
                            <tr class="bg-primary light">
                                <th class="text-center" style="width:8%;">No</th>
                                <th class="text-center" style="width:12%;">Tanggal</th>
                                <th class="text-center" style="width:15%;">No. Bukti</th>
                                <th class="text-center">Uraian</th>
                                <th class="text-center" style="width:5%;">D / K</th>
                                <th class="text-center" style="width:15%;">Rupiah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $d_pro = json_decode(detail_rk_outstanding($v['kd_spk'],$data['periode_lap'],'PROYEK'),true);
                                //var_dump($d_pro);
                                $i=1;
                                foreach($d_pro as $drow => $vd) {
                                list($thn, $bln, $tgl) = explode('-', $vd['tanggal']);
                                $tanggal = $tgl.'-'.$bln.'-'.$thn;
                                $dk = $vd['dk'];
                                if($dk==='K'){
                                    $rp = ($vd['rupiah']*-1);
                                }else{
                                    $rp = $vd['rupiah'];
                                }
                                //$rp = ($dk=='K'?($vd['rupiah']*-1):$vd['rupiah']);
                                $t_rp_dep += $rp;
                                if($vd['label']=='A'){
                            ?>
                            <tr>
                                <td class="text-center"><?=$i?></td>
                                <td class="text-center"><?=$tanggal?></td>
                                <td class="text-center"><?=$vd['no_bukti']?></td>
                                <td class="text-left"><?=$vd['uraian']?></td>
                                <td class="text-center"><?=$vd['dk']?></td>
                                <td class="text-right"><?=number_format($rp,0);?></td>
                            </tr>
                            <?php } $i++; } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="text-right" colspan="5"><b>Total Departemen</b></td>
                                <td class="text-right"><?=$vd['label']=='B'?number_format($vd['sisa'],0):0;?></td>
                            </tr>
                        </tfoot>
                    </table>

                    <!-- 
                        PROYEK 
                    -->
                    <p>
                    <table id="t_top_p" class="export2excel table mbn" data-tableName="top_pro">
                        <tbody>
                            <tr>
                                <td class="text-left" style="width:15%;"><b>Belum dibuku oleh SPK <?=$v['kd_spk']?></b></td>
                                <td class="text-right" style="width:70%;"></td>
                                <td class="text-left" style="width:5%;"></td>
                                <td class="text-right" style="width:10%;"></td>
                            </tr>
                        </tbody>
                    </table>
                    <table id="t_proyek" class="export2excel table table-bordered mbn ">
                        <thead>
                            <tr class="bg-primary light">
                                <th class="text-center" style="width:8%;">No</th>
                                <th class="text-center" style="width:12%;">Tanggal</th>
                                <th class="text-center" style="width:15%;">No. Bukti</th>
                                <th class="text-center">Uraian</th>
                                <th class="text-center" style="width:5%;">D / K</th>
                                <th class="text-center" style="width:15%;">Rupiah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $d_pro = json_decode(detail_rk_outstanding($v['kd_spk'],$data['periode_lap'],'DEPARTEMEN'),true);
                                //var_dump($d_pro);
                                $i=0;
                                foreach($d_pro as $drow => $vd) {
                                list($thn, $bln, $tgl) = explode('-', $vd['tanggal']);
                                $tanggal = $tgl.'-'.$bln.'-'.$thn;
                                $dk = $vd['dk'];
                                $rp = ($dk=='K'?($vd['rupiah']*-1):$vd['rupiah']);
                                if($vd['spk']==$v['kd_spk']){
                                    $t_rp_pro += $rp;
                                    //unset($t_rp_pro);
                                }
                                if($vd['label']=='A'){
                            ?>
                            <tr>
                                <td class="text-center"><?=($i+1)?></td>
                                <td class="text-center"><?=$tanggal?></td>
                                <td class="text-center"><?=$vd['no_bukti']?></td>
                                <td class="text-left"><?=$vd['uraian']?></td>
                                <td class="text-center"><?=$dk?></td>
                                <td class="text-right"><?=number_format($rp,0);?></td>
                            </tr>
                            <?php } $i++; } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="text-right" colspan="5"><b>Total SPK</b></td>
                                <td class="text-right"><?=$vd['label']=='B'?number_format($vd['sisa'],0):0;?></td>
                            </tr>
                            <tr>
                                <td class="text-right" colspan="5"><b>Sisa RK</b></td>
                                <td class="text-right"><b><?=($jum_sa!=null?number_format($jum_sa,0):0)?></b></td>
                            </tr>
                        </tfoot>
                    </table>
                    </p>
                    <br><br>
                    <h></h>
                    <?php 
                    
                    }
                    //unset($t_tp_pro);
                    
                    ?>
                    
                </div>
            </div>
        </div>
    </div>

</section>
<!-- End: Content -->