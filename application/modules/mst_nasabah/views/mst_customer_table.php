        <!-- Start: Content -->
        <section id="content_wrapper">

				<?php $this->load->view('../../home/views/title'); ?>
            <!-- Begin: Content -->
            <section>

                <div class="row">
					<div class="col-md-12">
						<div class="panel panel-visible">
							<div class="panel-heading br-b-n">
                                <!--div class="panel-title hidden-xs">
                                    <span class="glyphicon glyphicon-tasks"></span>Master Customer
									&nbsp;&nbsp;&nbsp;
									<a href="<?=base_url()?>index.php/customer/form" class="btn btn-sm btn-info"><i class="fa fa-home"></i>&nbsp;Tambah data</a>
								</div-->
                            </div>
							<div class="panel-body pn">
								<table class="table table-striped table-bordered table-hover" id="datatable" cellspacing="0" width="100%">
									<thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>No. KTP</th>
											<th>Alamat KTP</th>
											<th>Email</th>
											<th>Telepon</th>
											<th>HP</th>
											<th>Perusahaan</th>
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