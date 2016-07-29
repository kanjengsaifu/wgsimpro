<!-- Begin: Content -->
<section id="content">

    <div class="row">
        <div class="col-md-12 pn">
            <div class="panel mbn">
                <div class="panel-body">
                    <form class="form-horizontal" role="form" action="javascript:" id="form-input">

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Cara Bayar</label>
                            <div class="col-lg-4">
                                <select id="cara_bayar" name="cara_bayar" class="chosen-select required">
                                    <option value=""></option>
                                    <?php
                                    if(isset($data['pays'])) {
                                        foreach ($data['pays'] as $k => $v) {
                                    ?>
                                    <option value="<?=$v['kode']?>"><?=$v['nama']?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Kode</label>
                            <div class="col-lg-2">
                                <input type="text" name="kode_pay" id="kode_pay" class="form-control input-sm">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Deskripsi</label>
                            <div class="col-lg-4">
                                <input type="text" name="deskripsi" id="deskripsi" class="form-control input-sm">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Jenis</label>
                            <div class="col-lg-4">
                                <select id="kode_item" name="kode_item" class="chosen-select">
                                    <option value=""></option>
                                    <?php
                                    if(isset($data['items'])) {
                                        foreach ($data['items'] as $k => $v) {
                                    ?>
                                    <optgroup label="<?=$k?>">
                                    <?php 
                                            foreach ($v as $k2 => $v2) {
                                                $str = $v2['persentase']==='0'?'Rp. '.number_format($v2['rp'],0):$v2['persentase'].'%';
                                                $str2 = in_array($v2['kode_pay'], array('RES', 'TJ', 'KPR')) ? '' : ', '.$v2['install_num'].'x';
                                    ?>
                                        <option value="<?=$v2['kode_pay']?>"><?=$v2['deskripsi'].' ('.$str.$str2.')'?></option>
                                    <?php
                                            }
                                    ?>
                                    </optgroup>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">No. Urut</label>
                            <div class="col-lg-2">
                                <input type="text" name="no_urut" id="no_urut" class="form-control input-sm" value="0">
                            </div>
                            <div class="col-lg-2">
                                <button type="button" id="btn-submit" class="btn btn-sm btn-primary btn-gradient dark btn-block">Tambah</button>
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

                    <table class="table table-bordered" id="datatable" cellspacing="0">
                        <thead>
                            <tr  class="bg-primary light">
                                <th class="text-center w100">Kode Item</th>
                                <th class="text-center">Deskripsi</th>
                                <th class="text-center w100">Jml. Angsuran</th>
                                <th class="text-center w100">Persentase</th>
                                <th class="text-center w100">Rupiah</th>
                                <th class="w50">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot></tfoot>
                    </table>

                </div>
            </div>
        </div>
    </div>

</section>
<!-- End: Content -->