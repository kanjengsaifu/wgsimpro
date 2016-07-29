        <!-- Start: Content -->
        <section id="content_wrapper">

				<?php $this->load->view('../../home/views/title'); ?>
            <!-- Begin: Content -->
            <section>

                <!-- begin: .tray-center -->
                <div class="tray tray-center va-t posr animated-delay animated-long" data-animate='["800","fadeIn"]'>
                    <div class="center-block">

                        <!-- begin: .admin-form -->
                        <div class="admin-form">

                            <div id="p1" class="">

                                <div class="panel-body bg-light">
                                    <form method="post" action="<?=base_url()?>index.php/customer/save" id="form-ui">
                                        <!--div class="section-divider mb40" id="spy1">
                                            <span>Master Customer</span>
                                        </div>
                                        <!-- .section-divider -->
										
										<input type="hidden" id="id" name="id"/>
										<div class="row"> 
											<div class="col-md-12" class="judul" style="background:#3A6411;padding:10px;margin:10px;color:#fff;text-transform:uppercase">
												Data Customer
                                            </div>
                                        </div>
										<div class="row">
											<!--
                                            <div class="col-md-6">
                                                <div class="section">
                                                    <label class="field">
                                                        <input type="text" name="kode" id="kode" class="gui-input" placeholder="Kode Customer">
                                                    </label>
                                                </div>
                                            </div>
											-->
											<div class="col-md-6">
                                                <div class="section">
                                                    <label class="field">
														<strong>Nama Customer</strong>
                                                        <input type="text" name="nama" id="nama" class="gui-input satu" placeholder="Nama Customer">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
										<div class="row">
                                            <div class="col-md-6">
                                                <div class="section">
                                                    <label class="field">
													<strong>No. KTP</strong>
                                                        <input type="text" name="no_ktp" id="no_ktp" class="gui-input dua" placeholder="No. KTP">
                                                    </label>
                                                </div>
                                            </div>
											<div class="col-md-6">
                                                <div class="section">
                                                    <label class="field"><strong>No. KK</strong>
                                                        <input type="text" name="no_kk" id="no_kk" class="gui-input dua" placeholder="No. KK">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
										<div class="row">
                                            <div class="col-md-6">
                                                <div class="section">
                                                    <label class="field prepend-icon">
														<strong>Alamat KTP</strong>
                                                        <textarea class="gui-textarea satu" id="alamat_ktp" name="alamat_ktp" placeholder="Alamat KTP"></textarea>
                                                    </label>
                                                </div>
                                            </div>
											<div class="col-md-6">
                                                <div class="section">
                                                    <label class="field prepend-icon">
													<strong>Alamat Domisili</strong>
                                                        <textarea class="gui-textarea dua" id="alamat_domisili" name="alamat_domisili" placeholder="Alamat Domisili"></textarea>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
										<div class="row">
                                            <div class="col-md-6">
                                                <div class="section">
                                                    <label class="field">
													<strong>Tempat Lahir</strong>
                                                        <input type="text" name="tempat_lahir" id="tempat_lahir" class="gui-input dua" placeholder="Tempat Lahir">
                                                    </label>
                                                </div>
                                            </div>
											<div class="col-md-6">
                                                <div class="section">
                                                    <label class="field"><strong>Tanggal Lahir</strong>
                                                        <input type="text" name="tgl_lahir" id="tgl_lahir" class="gui-input satu" placeholder="Tanggal Lahir">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
										<div class="row">
                                            <div class="col-md-6">
                                                <div class="section">
                                                    <label class="field"><strong>Email</strong>
                                                        <input type="text" name="email" id="email" class="gui-input satu" placeholder="Email">
                                                    </label>
                                                </div>
                                            </div>
											<div class="col-md-6">
                                                <div class="section">
                                                    <label class="field"><strong>Telepon</strong>
                                                        <input type="text" name="telp" id="telp" class="gui-input dua" placeholder="Telepon">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
										<div class="row">
                                            <div class="col-md-6">
                                                <div class="section">
                                                    <label class="field"><strong>HP</strong>
                                                        <input type="text" name="hp" id="hp" class="gui-input dua" placeholder="HP">
                                                    </label>
                                                </div>
                                            </div>
											<div class="col-md-6">
                                                <div class="section">
                                                    <label class="field"><strong>Fax</strong>
                                                        <input type="text" name="fax" id="fax" class="gui-input satu" placeholder="Fax">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
										<div class="row">
                                            <div class="col-md-6">
                                                <div class="section">
                                                    <label class="field"><strong>Kode Pos</strong>
                                                        <input type="text" name="kodepos" id="kodepos" class="gui-input satu" placeholder="Kode Pos">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
										<div class="row"> 
											<div class="col-md-12" class="judul" style="background:#3A6411;padding:10px;margin:10px;color:#fff;text-transform:uppercase">
												Data Perusahaan
                                            </div>
                                        </div>
										<div class="row">
                                            <div class="col-md-6">
                                                <div class="section">
                                                    <label class="field"><strong>Nama Perusahaan</strong>
                                                        <input type="text" name="nama_perusahaan" id="nama_perusahaan" class="gui-input satu" placeholder="Nama Perusahaan">
                                                    </label>
                                                </div>
                                            </div>
											<div class="col-md-6">
                                                <div class="section">
                                                    <label class="field"><strong>Alamat Perusahaan</strong>
														<textarea class="gui-textarea dua" id="alamat_perusahaan" name="alamat_perusahaan" placeholder="Alamat Perusahaan"></textarea>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
										<div class="row mt20 text-center">
											<div class="col-md-10">&nbsp;</div>
											<div class="col-md-1">
												<button type="submit" class="btn btn-primary btn-gradient dark btn-block">Submit</button>
											</div>
											<div class="col-md-1">
												<button type="reset" class="btn btn-danger btn-gradient dark btn-block">Cancel</button>
											</div>
										</div>
										
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- end: .admin-form -->

                    </div>
                </div>
                <!-- end: .tray-center -->
				
            </section>
            <!-- End: Content -->

        </section>