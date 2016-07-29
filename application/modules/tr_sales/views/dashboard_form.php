<!-- Begin: Content -->
<section id="content">

    <div class="row">
        <div class="col-md-12 pn">
            <div class="panel mbn">
                <div class="panel-body">
                    <form class="form-horizontal" role="form" action="javascript:" id="form-input">

                        <div class="form-group">
                            <div class="col-lg-6">
                                <h5>Kawasan / Entity: <?=$this->session->userdata('type_entity')?$this->session->userdata('nama_entity').'.':'belum dipilih.'?></h5>
                            </div>
                        </div>
                        <div class="form-group mbn">
                            <label class="col-lg-1 control-label pt5">Group By</label>
                            <div class="col-lg-2">
                                <select id="group_by" class="chosen-select">
                                    <option value="ALL">ALL</option>
                                <?php 
                                if($this->session->userdata('type_entity')) {
                                    if($this->session->userdata('type_entity')==='HR') {
                                ?>
                                    <option value="tower_cluster">TOWER</option>
                                <?php
                                    } elseif($this->session->userdata('type_entity')==='LD') {
                                ?>
                                    <option value="tower_cluster">CLUSTER</option>
                                <?php
                                    }
                                }
                                ?>
                                    <option value="direction">VIEW</option>
                                    <option value="mata_angin">MATA ANGIN</option>
                                </select>
                            </div>
                            <label class="col-lg-1 control-label pt5">Filter By</label>
                            <div class="col-lg-4">
                                <select id="filter_by" class="chosen-select"></select>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 pn">
            <div class="panel">
                <div class="panel-body">
                    <table class="table table-bordered">
                        <tr>
                            <td class="text-right">Legend</td>
                            <td class="text-center" style="background-color: #d9f1d5;width:100px"><b>Available</b></td>
                            <td class="text-center" style="background-color: #fff;width:110px"><b>Hold (by Admin)</b></td>
                            <td class="text-center" style="background-color: #fdf0d4;width:100px"><b>Hold (by Sales)</b></td>
                            <td class="text-center" style="background-color: #ed7764;width:100px"><b>Reserve</b></td>
                            <td class="text-center" style="background-color: #6c9fe3;width:100px"><b>Pesanan</b></td>
                        </tr>
                    </table>
                    <table class="table table-bordered mbn">
                        <tbody>
                            <tr id="tr-units">
                        <?php
                        if(isset($data['units'])) {
                            foreach($data['units'] as $ktower => $vtower) { 
                        ?>
                                <td class="text-center pn" style="vertical-align: middle"><?=$vtower['stower']?></td>
                                <td class="pn">
                                    <table class="table table-bordered mbn">
                                        <tbody>
                                            <tr>
                                            <?php
                                            foreach($vtower['lantais'] as $klantai => $vlantai) {
                                            ?>
                                                <td style="vertical-align: top;" class="pn">
                                                    <table class="table table-bordered mbn">
                                                        <tbody>
                                                            <tr>
                                                                <td class="text-center bg-info"><?=$vlantai['slantai']?></td>
                                                            </tr>
                                                <?php
                                                foreach($vlantai['units'] as $kunit => $vunit) {
                                                    $style = 'color:#000; background-color: #d9f1d5; cursor: pointer;';
                                                    $class = 'td-unit';
                                                    if($vunit['ishold']==='1') {
                                                        $style = 'background-color: #ffffff';
                                                        $class = 'td-none';
                                                    } elseif($vunit['status_tr']==='HOLD') {
                                                        $style = 'background-color: #fdf0d4; cursor: pointer;';
                                                        $class = 'td-unit';
                                                    } elseif($vunit['status_tr']==='RESERVE') {
                                                        $style = 'background-color: #ed7764; cursor: pointer;';
                                                        $class = 'td-unit';
                                                    } elseif($vunit['status_tr']==='BOOKING') {
                                                        $style = 'background-color: #6c9fe3; cursor: pointer;';
                                                        $class = 'td-unit';
                                                    } elseif($vunit['status_tr']==='SALES') {
                                                        $style = 'background-color: #6c9fe3; cursor: pointer;';
                                                        $class = 'td-unit';
                                                    }
                                                ?>
                                                            <tr>
                                                                <td data-id="<?=$vunit['xno_unit']?>"  style="<?=$style?> border: solid 1px #000" class="<?=$class?>"><?=$vunit['no_unit']?></td>
                                                            </tr>
                                                        
                                                <?php
                                                }
                                                ?>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            <?php
                                            }
                                            ?>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                        <?php
                            }
                        }
                        ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- modal -->
    <div class="modal fade" role="dialog" id="modalUnit">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Data Produk</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form class="form-horizontal" role="form" action="javascript:">
                                <div class="form-group mbn">
                                    <label class="col-lg-2 control-label">No. Unit</label>
                                    <div class="col-lg-4">
                                        <p class="form-control-static text-muted" id="pno_unit"></p>
                                    </div>
                                </div>
                            <?php if($this->session->userdata('type_entity')==='HR') { ?>
                                <div class="form-group mbn">
                                    <label class="col-lg-2 control-label">Type</label>
                                    <div class="col-lg-4">
                                        <p class="form-control-static text-muted" id="ptype_unit"></p>
                                    </div>
                                    <label class="col-lg-2 control-label">Tower</label>
                                    <div class="col-lg-4">
                                        <p class="form-control-static text-muted" id="ptower_cluster"></p>
                                    </div>
                                </div>
                                <div class="form-group mbn">
                                    <label class="col-lg-2 control-label">Luas Netto</label>
                                    <div class="col-lg-4">
                                        <p class="form-control-static text-muted" id="pwide_netto"></p>
                                    </div> 
                                    <label class="col-lg-2 control-label">Luas Semi Gross</label>
                                    <div class="col-lg-4">
                                        <p class="form-control-static text-muted" id="pwide_gross"></p>
                                    </div>
                                </div>
                                <div class="form-group mbn">
                                    <label class="col-lg-2 control-label">Lantai</label>
                                    <div class="col-lg-4">
                                        <p class="form-control-static text-muted" id="plantai_blok"></p>
                                    </div> 
                                </div>
                            <?php } elseif($this->session->userdata('type_entity')==='LD') { ?>
                                <div class="form-group mbn">
                                    <label class="col-lg-2 control-label">Type</label>
                                    <div class="col-lg-4">
                                        <p class="form-control-static text-muted" id="ptype_unit"></p>
                                    </div>
                                    <label class="col-lg-2 control-label">Cluster</label>
                                    <div class="col-lg-4">
                                        <p class="form-control-static text-muted" id="ptower_cluster"></p>
                                    </div>
                                </div>
                                <div class="form-group mbn">
                                    <label class="col-lg-2 control-label">Luas Bangunan</label>
                                    <div class="col-lg-4">
                                        <p class="form-control-static text-muted" id="pwide_netto"></p>
                                    </div> 
                                    <label class="col-lg-2 control-label">Luas Tanah</label>
                                    <div class="col-lg-4">
                                        <p class="form-control-static text-muted" id="pwide_gross"></p>
                                    </div>
                                </div>
                                <div class="form-group mbn">
                                    <label class="col-lg-2 control-label">Blok</label>
                                    <div class="col-lg-4">
                                        <p class="form-control-static text-muted" id="plantai_blok"></p>
                                    </div> 
                                </div>
                            <?php } ?>
                                <div class="form-group mbn">
                                    <label class="col-lg-2 control-label">View</label>
                                    <div class="col-lg-4">
                                        <p class="form-control-static text-muted" id="pdirection"></p>
                                    </div>
                                    <label class="col-lg-2 control-label">Arah Mata Angin</label>
                                    <div class="col-lg-4">
                                        <p class="form-control-static text-muted" id="pdirection_wind"></p>
                                    </div>
                                </div>
                                <div id="prices-container">

                                <div class="form-group mbn">
                                    <label class="col-lg-2 control-label">Harga</label>
                                    <div class="col-lg-4">
                                        <p class="form-control-static text-muted" id="pharga"></p>
                                    </div> 
                                    <label class="col-lg-2 control-label">Terbilang</label>
                                    <div class="col-lg-4">
                                        <p class="form-control-static text-muted" id="pterbilang"></p>
                                    </div>
                                </div>

                                </div>
                                <div id="customer-container">

                                <div class="form-group mbn">
                                    <div class="col-lg-12">
                                        <p class="form-control-static" style="border-bottom: solid 1px #e5e5e5;"><b>Customer</b></p>
                                    </div> 
                                </div>
                                <div class="form-group mbn">
                                    <label class="col-lg-2 control-label">Kode Nasabah</label>
                                    <div class="col-lg-4">
                                        <p class="form-control-static text-muted" id="pkode"></p>
                                    </div> 
                                </div>
                                <div class="form-group mbn">
                                    <label class="col-lg-2 control-label">Nama</label>
                                    <div class="col-lg-4">
                                        <p class="form-control-static text-muted" id="pnama"></p>
                                    </div> 
                                    <label class="col-lg-2 control-label">Klasifikasi</label>
                                    <div class="col-lg-4">
                                        <p class="form-control-static text-muted" id="pklasifikasi"></p>
                                    </div>
                                </div>
                                <div class="form-group mbn">
                                    <label class="col-lg-2 control-label">HP</label>
                                    <div class="col-lg-4">
                                        <p class="form-control-static text-muted" id="php"></p>
                                    </div> 
                                    <label class="col-lg-2 control-label">Email</label>
                                    <div class="col-lg-4">
                                        <p class="form-control-static text-muted" id="pemail"></p>
                                    </div>
                                </div>

                                </div>
                                <div class="form-group mbn">
                                    <div class="col-lg-12">
                                        <p class="form-control-static" style="border-bottom: solid 1px #e5e5e5;" id="lbl-status_tr"></p>
                                    </div> 
                                </div>
                                <div id="payment-container">
                                <div class="form-group mbn">
                                    <label class="col-lg-2 control-label" id="lbl-tgl_payment"></label>
                                    <div class="col-lg-4">
                                        <p class="form-control-static text-muted" id="ptgl_payment"></p>
                                    </div> 
                                    <label class="col-lg-2 control-label" id="lbl-reserve_no"></label>
                                    <div class="col-lg-4">
                                        <p class="form-control-static text-muted" id="preserve_no"></p>
                                    </div> 
                                </div>
                                <div class="form-group mbn">
                                    <label class="col-lg-2 control-label" id="lbl-sales_no">Nama Sales</label>
                                    <div class="col-lg-4">
                                        <p class="form-control-static text-muted" id="psales_nama"></p>
                                    </div>
                                    <label class="col-lg-2 control-label" id="lbl-cara_bayar">Cara Bayar</label>
                                    <div class="col-lg-4">
                                        <p class="form-control-static text-muted" id="pcara_bayar"></p>
                                    </div> 
                                </div>
                                <div class="form-group mbn hidden">
                                    <label class="col-lg-2 control-label" id="lbl-kode_pay">Pola Bayar</label>
                                    <div class="col-lg-4">
                                        <p class="form-control-static text-muted" id="pkode_pay"></p>
                                    </div> 
                                </div>
                                <div class="form-group mbn hidden">
                                    <label class="col-lg-2 control-label">Harga Jual</label>
                                    <div class="col-lg-4">
                                        <p class="form-control-static text-muted input-numeric" id="pharga_jual"></p>
                                    </div> 
                                    <label class="col-lg-2 control-label">Terbilang</label>
                                    <div class="col-lg-4">
                                        <p class="form-control-static text-muted" id="pterbilang_jual"></p>
                                    </div>
                                </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="text-align: center">
                    <a href="javascript:" class="btn btn-primary" id="btn-hold">Hold</a>
                    <a href="javascript:" class="btn btn-primary" id="btn-reserve">Reserve</a>
                    <a href="javascript:" class="btn btn-primary" id="btn-booking">Pesanan</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- modal end -->

</section>
<!-- End: Content -->