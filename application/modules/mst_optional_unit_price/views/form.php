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
                        <input type="hidden" name="sflag" id="sflag" value="<?=$this->session->userdata('type_entity')?>"/>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Field <span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <select id="sfield" name="sfield" class="chosen-select required">
                                    <option value=""></option>
                                    <option value="type_price">Jenis</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Group <span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <select id="grup" name="grup" class="chosen-select required">
                                    <option value=""></option>
                                    <option value="NETTO">NETTO</option>
                                    <option value="PAJAK">PAJAK</option>
                                    <option value="CUSTOM">CUSTOM</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Kode / Konten</label>
                            <div class="col-lg-2">
                                <input type="text" name="kode" id="kode" class="form-control input-sm">
                            </div>
                            <div class="col-lg-4">
                                <input type="text" name="konten" id="konten" class="form-control input-sm">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Formula</label>
                            <div class="col-lg-4">
                                <textarea name="formula" id="formula" class="form-control input-sm" row="3"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">No. Urut</label>
                            <div class="col-lg-2">
                                <input type="text" name="no_urut" id="no_urut" class="form-control input-sm" value="0">
                            </div>
                            <div class="col-lg-2">
                                <button type="button" id="btn-submit" class="btn btn-primary btn-gradient dark btn-block">Submit</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-12" style="border-bottom: 1px solid #e0e0e0">&nbsp;</div>
                        </div>

                    </form>

                    <table class="table table-striped table-bordered table-hover" id="datatable" cellspacing="0" width="100%">
                        <thead>
                            <tr class="bg-primary light bg-gradient">
                                <th>Grup</th>
                                <th>Kode</th>
                                <th>Konten</th>
                                <th>Formula</th>
                                <th>No. Urut</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

</section>
<!-- End: Content -->