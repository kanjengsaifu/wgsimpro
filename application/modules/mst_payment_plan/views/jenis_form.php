<?php
$type_entity = $this->session->userdata('type_entity');
?>
<!-- Begin: Content -->
<section id="content">

    <div class="row">
        <div class="col-md-12 pn">
            <div class="panel">
                <div class="panel-body">
                    <form class="form-horizontal" role="form" action="javascript:" id="form-input">

                        <input type="hidden" name="id" id="id"/>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Kode / Deskripsi</label>
                            <div class="col-lg-2">
                                <input type="text" name="kode_pay" id="kode_pay" class="form-control input-sm">
                            </div>
                            <div class="col-lg-8">
                                <input type="text" name="deskripsi" id="deskripsi" class="form-control input-sm">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Tipe</label>
                            <div class="col-lg-4">
                                <select id="tipe_pay" name="tipe_pay" class="chosen-select">
                                    <option value=""></option>
                                    <option value="BOOKINGFEE">BOOKING FEE</option>
                                    <option value="DOWNPAYMENT">DOWN PAYMENT</option>
                                    <option value="INSTALLMENT">ANGSURAN</option>
                                    <option value="BANKLOAN">PINJAMAN / BANK</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Periode</label>
                            <div class="col-lg-4">
                                <select id="base_period" name="base_period" class="chosen-select required">
                                    <option value=""></option>
                                    <option value="DAILY">DAILY (Harian)</option>
                                    <option value="MONTHLY">MONTHLY (Bulanan)</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Instalasi</label>
                            <div class="col-lg-2">
                                <input type="text" name="install_num" id="install_num" class="form-control input-sm text-right input-numeric" value="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Prosentase</label>
                            <div class="col-lg-2">
                                <input type="text" name="persentase" id="persentase" class="form-control input-sm text-right input-numeric" value="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Nominal</label>
                            <div class="col-lg-2">
                                <input type="text" name="rp" id="rp" class="form-control input-sm text-right input-numeric" value="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Durasi</label>
                            <div class="col-lg-2">
                                <input type="text" name="limit_day" id="limit_day" class="form-control input-sm text-right input-numeric" value="0">
                            </div>
                            <div class="col-lg-2">
                                <button type="button" id="btn-submit" class="btn btn-primary btn-gradient dark btn-block">Submit</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

</section>
<!-- End: Content -->