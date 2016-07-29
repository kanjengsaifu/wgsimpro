<style type="text/css">
    .someclass { background-color: red; }
</style>

<!-- Begin: Content -->
<section id="content">
    <div class="row">
        <div class="col-md-12 pn">
            <div class="panel">
                <div class="panel-body">
                    <div class="bg-light pv8 pl15 pr10 br-a br-light hidden-xs">
                        <div class="row">
                            <div class="col-md-6 text-left">
                                <div class="btn-group  accordion mbn" id="panel-payment-plan">
                                        <form id="go-edit-jurnal" action="<?php echo site_url('jurnal/view2/page/0'); ?>" method="POST">
                                            <input id="editing" type="hidden" value="1">
                                            <input id="nobukti" type="hidden" value="">
                                            <input id="tanggal" inamed="tanggal" type="hidden" value="">
                                            <input type="hidden" name="kode_entity" id="kode_entity"/>
                                            <input type="hidden" id="is_adv" name="is_adv"value="0">
                                            <input type="hidden" id="is_periode" name="is_periode"value="0">

                                            <input type="search" name="cari" id="cari" placeholder="Search..."> <input type="submit" name="q" id="q" value="Search"><input type="button" id="advance" name="advance" value="Advance Search">
                                            <div id="advance-search" class="panel-collapse collapse col-md-10 in pn" style="display:none;">
                                                <div class="panel-body">
                                                        <div class="row">
                                                            <div class="panel">
                                                                <div class="form-group">
                                                                    <table id='t_filter' class="table table-responsive">
                                                                        <tr>
                                                                            <td>Periode Bulan & Tahun</td>
                                                                            <td>
                                                                                <!--div class="checkbox-custom circle checkbox-success mb2 no-bukti"-->
                                                                                    <input id="ckperiode" name="ckperiode" type="checkbox" value="0">
                                                                                    <!--label for="ckperiode"></label-->
                                                                                </div>
                                                                            </td>
                                                                            <td colspan="4" style="width: 90%;">
                                                                                <input type="text" id="periode" name="periode" class="form-control input-sm input-date" value="<?=date('m/Y')?>">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <select id="field[]" name="field[]" class="input-xsm">   
                                                                                    <option value=""> </option>
                                                                                    <option value="no_bukti"> Nomor Bukti </option>
                                                                                    <option value="tanggal"> Tanggal </option>
                                                                                    <option value="kode_coa"> Kode CoA </option>
                                                                                    <option value="kode_nasabah"> Nasabah </option>
                                                                                    <option value="kode_customer"> Customer</option>
                                                                                    <option value="kode_nasabah"> Sumberdaya </option>
                                                                                    <option value="kode_spk"> SPK </option>
                                                                                    <option value="kode_tahap"> Tahap </option>
                                                                                    <option value="no_invoice"> Nomor Invoice</option>
                                                                                    <option value="kode_faktur"> Nomor Faktur</option>
                                                                                    <option value="volume"> Volume</option>
                                                                                    <option value="rp_debit"> Debet</option>
                                                                                    <option value="rp_kredit"> Kredit</option>
                                                                                    <option value="keterangan"> Uraian</option>
                                                                                </select>
                                                                            </td>
                                                                            <td>&nbsp;&nbsp;</td>
                                                                            <td> 
                                                                                <select id="kondisi[]" name="kondisi[]" class="input-xsm">
                                                                                    <option value=""> </option>
                                                                                    <option value="="> = </option>
                                                                                    <option value=">"> > </option>
                                                                                    <option value="<"> < </option>
                                                                                    <option value=">="> >= </option>
                                                                                    <option value="<="> <= </option>
                                                                                    <option value="<>"> <> </option>
                                                                                    <option value="like_before"> %xx </option>
                                                                                    <option value="like_after"> xx% </option>
                                                                                    <option value="like_both"> %xx% </option>
                                                                                </select> 
                                                                            </td>
                                                                            <td>&nbsp;&nbsp;</td>
                                                                            <td><input id="nilai[]" name="nilai[]" type="text" value="" class="input-xsm"></td>
                                                                            <td>&nbsp;&nbsp;</td>
                                                                            <td><a href="javascript:" class='new-row'><span class="fa fa-plus-square fa-danger"></span></a></td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="col-lg-3">
                                                                        &nbsp;&nbsp;
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <button type="submit" id="btn-submit" class="btn btn-sm btn-primary btn-gradient dark btn-block">Filter</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                </div>
                                            </div>
                                        </form>
                                </div>
                            </div>
                            <div class="col-md-6 text-right">
                                
                                <div class="btn-group mr10">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default light row-edit"><i class="fa fa-pencil"></i></button>
                                        &nbsp;&nbsp;&nbsp;
                                        <button type="button" class="btn btn-default light row-delete"><i class="fa fa-trash"></i></button>
                                    </div>
                                    <div class="btn-group">
                                        <div class="col-md-2">
                                            &nbsp;&nbsp;
                                        </div>
                                    </div>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default light" onclick="window.print()"><i class="fa fa-print"></i></button>
                                        <!--button type="button" class="btn btn-default light export-excel"><i class="fa fa-list-alt"></i></button-->
                                        <button type="button" class="btn btn-default light dropdown-toggle ph8" data-toggle="dropdown">
                                            <span class="fa fa-tags"></span>
                                            <span class="caret ml5"></span>
                                        </button>
                                        <ul class="dropdown-menu pull-right" role="menu">
                                            <li>
                                                <a href="#" onclick="$('#t_vjurnal').tableExport({type:'excel',escape:'false'});">Export to Excel</a>
                                            </li>
                                            <li>
                                                <a href="#" class="to-pdf" onclick="$('#t_vjurnal').tableExport({type:'pdf',pdfFontSize:'4',escape:'true'});">Export to PDF</a>
                                            </li>
                                            <li>
                                                <a href="#" onclick="$('#t_vjurnal').tableExport({type:'png',escape:'false'});">Export to PNG</a>
                                            </li>
                                            <!--li>
                                                <a href="#">Favorites</a>
                                            </li>
                                            <li class="divider"></li>
                                            <li>
                                                <a href="#">
                                                    <span class="fa fa-plus pr5"></span> Create New</a>
                                            </li-->
                                        </ul>
                                    </div>
                                    <!--div class="btn-group">
                                        <div class="col-md-2">
                                            &nbsp;
                                        </div>
                                    </div>
                                    <div class="btn-group">
                                        <select id='pagerow[]' class="btn btn-default light">
                                            <option value="10"> 10 </option>
                                            <option value="20"> 20 </option>
                                            <option value="25"> 25 </option>
                                            <option value="30"> 30 </option>
                                            <option value="50"> 50 </option>
                                            <option value="80"> 80 </option>
                                            <option value="100"> 100 </option>
                                            <option value=""> All </option>
                                        </select>
                                    </div-->
                                </div>
                                <!--div class="btn-group">
                                    <?=$this->pagination->create_links(); ?> -->
                                    <!--button type="button" class="btn btn-default light"><i class="fa fa-chevron-left"></i>
                                    </button>
                                    <a href="javascript:" class="btn btn-default light">1</a>
                                    <a href="javascript:" class="btn btn-default light">2</a>
                                    <a href="javascript:" class="btn btn-default light">3</a>
                                    <a href="javascript:" class="btn btn-default light">4</a>
                                    <a href="javascript:" class="btn btn-default light">5</a>
                                    <button type="button" class="btn btn-default light"><i class="fa fa-chevron-right"></i>
                                    </button-->
                                <!--</div> -->
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-responsive table-bordered table-hover mbn t-vjurnal" id="t_vjurnal" width="100%">
                            <thead>
                                <tr class="bg-primary light bg-gradient">
                                    <th>No. Bukti</th>
                                    <th>Tanggal</th>
                                    <th>CoA</th>
                                    <th>Nasabah</th>
                                    <th>Customer</th>
                                    <th>Sumberdaya</th>
                                    <th>SPK</th>
                                    <th>Tahap</th>
                                    <th>No. Invoice</th>
                                    <th>Kode Faktur</th>
                                    <th>Volume</th>
                                    <th>Debet</th>
                                    <th>Kredit</th>
                                    <th>Keterangan</th>
                                    <!--th>Aksi</th-->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    //var_dump($data['rowtot']);
                                    if (count($data) > 1) {
                                        $i=1;
                                        foreach($data as $k => $v)
                                        {
                                            if(!empty($v['no_bukti']) ){
                                ?>
                                <tr>
                                    <td>
                                        <div class="radio-custom circle radio-success mb2 no-bukti">
                                            <input id="nobuk<?=$i?>" type="radio" value="<?=$v['no_bukti']?>" name="nobuk[]">
                                            <label for="nobuk<?=$i?>"><?=$v['no_bukti']?></label>
                                        </div>
                                    </td>
                                    <td><?=$v['tanggal']?></td>
                                    <td><?=$v['kode_coa']?></td>
                                    <td><?=$v['kode_nasabah']?></td>
                                    <td><?=$v['kode_customer']?></td>
                                    <td><?=$v['kode_sumberdaya']?></td>
                                    <td><?=$v['kode_spk']?></td>
                                    <td><?=$v['no_invoice']?></td>
                                    <td><?=$v['kode_tahap']?></td>
                                    <td><?=$v['kode_faktur']?></td>
                                    <td><?=$v['volume']?></td>
                                    <td><?=($v['dk']=='D'?$v['rupiah']:0)?></td>
                                    <td><?=($v['dk']=='K'?$v['rupiah']:0)?></td>
                                    <td><?=$v['keterangan']?></td>
                                    <!--td><?=$v['no_bukti']?></td-->
                                </tr>
                                <?php 
                                            }
                                            $i++; 
                                        }

                                    }else {
                                        echo "<tr><td colspan='15' class='text-center'>Hasil pencarian tidak ditemukan.</td></tr>";
                                    }
                                ?>
 
                            </tbody>
                        </table>
                        
                    </div>
                    <div class="bg-light pv8 pl15 pr10 br-a br-light hidden-xs">
                        <div class="row">
                            <!--div class="hidden-xs hidden-sm col-md-3 va-m"-->
                            <div class="col-md-3 text-left">
                                <!--span class="va-m text-muted mr15"> Showing <strong><?=$data['start']?></strong> of <strong><?=$data['total_record']?></strong> </span-->
                                <label class="va-m text-muted mr15">Rows &nbsp;</label>
                                <div class="btn-group">
                                    <select id='limit' name='limit' class="btn btn-default light">
                                        <option value="10" <?=$data['limit']==10?'selected':''?> > 10 </option>
                                        <option value="20" <?=$data['limit']==20?'selected':''?> > 20 </option>
                                        <option value="25" <?=$data['limit']==25?'selected':''?> > 25 </option>
                                        <option value="30" <?=$data['limit']==30?'selected':''?> > 30 </option>
                                        <option value="50" <?=$data['limit']==50?'selected':''?> > 50 </option>
                                        <option value="80" <?=$data['limit']==80?'selected':''?> > 80 </option>
                                        <option value="100" <?=$data['limit']==100?'selected':''?> > 100 </option>
                                        <!--option value="" <?=$data['limit']=='All'?'selected':''?> > All </option-->
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-9 text-right">
                                <span class="va-m text-muted mr15"> Showing <strong><?=$data['start']?></strong> of <strong><?=$data['total_record']?></strong> </span>
                                <div class="btn-group">
                                    <?=$data['pagination']; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End: Content -->