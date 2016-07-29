<!-- Begin: Content -->
<section id="content" class="table-layout">
        <!-- begin: .tray-center -->
        <div class="tray tray-center pv60 ph50 va-t posr animated-delay animated-long" data-animate='["800","fadeIn"]'>
            <div class="mw2000 center-block">

                <h2 class="lh30 mt10 text-center"><b class="text-primary">Upload Data</b>! Pastikan data anda benar sesuai <a href='<?=base_url()?>files/_tmpl_ledger.xls'>template</a></h2>
                

                <!-- begin: .admin-form -->
                <div class="admin-form">

                    <div id="p1" class="panel heading-border">

                        <div class="panel-body bg-light" id="f_periode">
                            <!--div class="col-lg-2">
                                <div class="input-group">
                                    <span id='req_username'></span><span class="input-group-addon input-sm">Periode</span>
                                    <input name="uid" id="uid" type="hidden" value=""> 
                                    <input name="periode" id="periode" class="form-control input-sm text-left input-periode" type="text" value="">                                        
                                </div>
                            </div-->
                        </div>
                        <div class="panel-body bg-light" id="f_upload">
                            
                            <!--form method="post" action="#" id="form-ui"-->
                            
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="section">
                                            <div id="container">
                                                <div id="body">                                                    
                                                <?php
                                                    $attributes = array('name' => 'file_upload_form', 'id' => 'file_upload_form');
                                                    echo form_open_multipart($this->uri->uri_string(), $attributes);
                                                    
                                                    //var_dump(@$data['success']);
                                                        if (isset($data['success']) && strlen($data['success'])) {
                                                            echo '<div id="notify" class="success">';
                                                            echo '<p>' . @$data['success'] . '</p>';
                                                            echo '</div>';
                                                        }
                                                        if (isset($data['errors']) && strlen($data['errors'])) {
                                                            echo '<div id="notify" class="error">';
                                                            echo '<p>' . @$data['errors'] . '</p>';
                                                            echo '</div>';
                                                        }
                                                        if (validation_errors()) {
                                                            echo validation_errors('<div class="error">', '</div>');
                                                        }
                                                        ?>
                                                    <div>
                                                <p><input name="file_name" id="file_name" readonly="readonly" type="file" class="btn btn-primary btn-gradient"/></p>
                                                <p><input id="btn_upload" name="file_upload" value="Upload" type="submit" class="col-md-4 btn btn-primary btn-gradient" /></p>
                                                
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                            echo form_close();?>
                                    </div>
                                    <!--div class="col-md-4">
                                        <div></div>
                                        <button type="submit" name="file_upload" class="btn btn-primary btn-gradient dark btn-block" >Upload</button>
                                    </div-->
                                    <div class="col-md-4" style="display: none;">
                                        <!--a href="#" onclick="show_child('chairul')">Show Child</a-->
                                        <button type="button" id="btn-load" class="btn btn-primary btn-gradient dark btn-block text-center" style="display: none;" onclick="show_child('<?=$this->session->userdata('usernm')?>')">Load</button>
                                    </div>
                                </div>
                            
                            <!--/form-->
                        </div>
                        <div class="panel-body bg-light" id="t_data">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section">
                                        <div id="jtes"></div>
                                        <span id="bobot_child_<?=$this->session->userdata('usernm')?>"></span>
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