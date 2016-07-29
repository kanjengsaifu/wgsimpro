<!-- Begin: Content -->
<section id="content">

    <div class="row">
        <div class="col-md-12 pn">
            <div class="panel">
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover" id="datatable" cellspacing="0" width="100%">
                        <thead>
                            <tr class="bg-primary light bg-gradient">
                                <th>No. Unit</th>
                                <th>Property Type</th>
                                <th>Unit Type</th>
							<?php
							if($this->session->userdata('type_entity')) {
								if($this->session->userdata('type_entity')==='HR') {
							?>
								<th>Tower</th>
								<th>Luas Netto</th>
								<th>Luas Semi Gross</th>
								<th>Lantai</th>
							</div>
							<?php
								} elseif($this->session->userdata('type_entity')==='LD') {
							?>
								<th>Cluster</th>
								<th>Luas Bangunan</th>
								<th>Luas Tanah</th>
								<th>Blok</th>
							<?php
								}
							}
							?>
								<th>View</th>
								<th>Arah Mata Angin</th>
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