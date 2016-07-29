<!-- Begin: Content -->
<section id="content">

    <div class="row">
        <div class="col-md-12 pn">
            <div class="panel">
                <div class="panel-body">
                    <?php
                    $tmp = array();
                    $sub = array();
                    $totals = array();
                    $total_ter = array();
                    $total_lun = array();
                    $total_sis = array();
                    
                    $i=1;
                    foreach($data['rows'] as $row){
                        
                        
                        $tanggal= $row['tanggal'];
                        $kd_nas = $row['kode_nasabah'];
                        $nm_nas = $row['nama_nasabah'];
                        $no_ter = $row['no_terbit'];
                        $no_buk = $row['no_bukti'];
                        $coa    = $row['kode_coa'];
                        $ket    = $row['keterangan'];
                        $terbit = $row['penerbitan']; //$row['cost'] * $qty;
                        $lunas  = $row['pelunasan'];
                        $umur   = $row['umur'];
                        $sa = 0;
                        $sisa   = ($sa + $terbit) - $lunas;
                        $si_sa = $terbit==0?$sisa*-1:$sisa;
                        //echo $kd_nas;die;
                        $terbit+=$terbit;
                        
                        if(!isset($tmp[$kd_nas])){ 

                            $tmp[$kd_nas] = '';
                            $sub[$no_ter] = '';
                            $totals[$sisa] = 0;
                            $total_ter[$terbit] = 0;
                            $sub_ter[$terbit] = 0;
                            $total_lun[$lunas] = 0; 
                            $total_sis[$sisa] = 0; 
                        }

                        $tmp[$kd_nas] .= "<tr id='kdnas_".$kd_nas."'>
                                            <td>".$tanggal."</td>
                                            <td>".$no_buk."</td>
                                            <td>".$ket."</td>
                                            <td class='text-right'>".number_format($terbit,0)."</td>
                                            <td class='text-right'>".number_format($lunas,0)."</td>
                                            <td class='text-right'>".number_format($sisa,0)."</td>
                                            <td class='text-center'>".$umur."</td>
                                        </tr>";
                        $sub[$no_ter] = "<tr>
                                            <td></td>
                                            <td>".$no_ter."</td>
                                            <td>SUB TOTAL NOMOR TERBIT</td>
                                            <td class='text-right'>".number_format($terbit,0)."</td>
                                            <td class='text-right'>".number_format($lunas,0)."</td>
                                            <td class='text-right'>".number_format($sisa,0)."</td>
                                            <td class='text-center'>".$umur."</td>
                                        </tr>";
                        $total_ter[$kd_nas] += $terbit;
                        $total_lun[$kd_nas] += $lunas;
                        $total_sis[$kd_nas] += $sisa;
                        $sub_ter[$no_ter] += $terbit;

                        $i++;

                    }

                    echo '<table class="table table-striped table-bordered table-hover" id="datatable" cellspacing="0" width="100%">';
                    echo '<thead>
                                <tr class="bg-primary light bg-gradient"> 
                                    <th>Tanggal</th>
                                    <th>Nomor Bukti</th>
                                    <th>Keterangan</th>
                                    <th>Penerbitan</th>
                                    <th>Pelunasan</th>
                                    <th>Sisa</th>
                                    <th>Umur</th>
                                </tr>
                            </thead>
                            <tbody>';

                    foreach($total_ter as $kd_nas =>$total){ 
                        
                        $ter_rp = $total_ter[$kd_nas]; 
                        $lun_rp = $total_lun[$kd_nas];
                        $sisa_rp = $total_sis[$kd_nas];

                        if($ter_rp >0 && $lun_rp >0 && $sisa_rp >0){
                        echo '<tr id="'.$kd_nas.'"> 
                                <td></td>
                                <td><b>'.$kd_nas.' - '.$nm_nas.'</b></td>
                                <td><b>SUB TOTAL</b></td>
                                <td class="text-right"><b>'.number_format($ter_rp,0).'</b></td>
                                <td class="text-right"><b>'.number_format($lun_rp,0).'</b></td>
                                <td class="text-right"><b>'.number_format($sisa_rp,0).'</b></td>
                                <td class="text-center"></b></td>
                              </tr>';
                        }
                        echo $tmp[$kd_nas];
                        echo '<tr> 
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                              </tr>';

                        $grand_ter += $ter_rp;
                        $grand_lun += $lun_rp;
                        $grand_sis = $grand_ter-$grand_lun;
                        
                    }
                        echo '<tr> 
                                <td colspan="2"></td>
                                <td><b>GRAND TOTAL</b></td>
                                <td class="text-right"><b>'.number_format($grand_ter,0).'</b></td>
                                <td class="text-right"><b>'.number_format($grand_lun,0).'</b></td>
                                <td class="text-right"><b>'.number_format($grand_sis,0).'</b></td>
                                <td></td>
                              </tr>';

                    echo "      </tbody>
                            </table>";
                    ?>
                </div>
            </div>
        </div>
    </div>

</section>
<!-- End: Content -->