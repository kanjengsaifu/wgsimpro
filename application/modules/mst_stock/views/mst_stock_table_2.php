        <!-- Start: Content -->
        <section id="content_wrapper">

				<?php $this->load->view('../../home/views/title'); ?>
				
            <!-- Begin: Content -->
            <section>

                <div class="row">
					<div class="col-md-12">
						<div class="panel panel-visible">
							<!--div class="panel-heading br-b-n">
                                <div class="panel-title hidden-xs">
                                    <span class="glyphicon glyphicon-tasks"></span>Master Stock>
									&nbsp;&nbsp;&nbsp;
									<a href="<?=base_url()?>index.php/stock/form" class="btn btn-sm btn-info"><i class="fa fa-home"></i>&nbsp;Tambah data</a>
								</div>
                            </div-->
							<div class="panel-body pn">
								<table class="table table-striped table-bordered table-hover" id="datatable" cellspacing="0">
									<thead>
                                        <tr>
                                            <th>Kode Entity</th>
                                            <th>No. Unit</th>
											<?php
											if($this->session->userdata('type_entity')) {
												if($this->session->userdata('type_entity')==='HIGHRISE') {
											?>
												<th>Luas Netto</th>
												<th>Luas Semi Gross</th>
											</div>
											<?php
												} elseif($this->session->userdata('type_entity')==='LANDED') {
											?>
												<th>Luas Bangunan</th>
												<th>Luas Tanah</th>
											<?php
												}
											}
											?>
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

        </section>