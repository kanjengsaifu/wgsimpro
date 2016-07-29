<!-- Start: Sidebar -->
<aside id="sidebar_left" class="nano nano-primary sidebar-light affix">
    <div class="nano-content">

        <!-- sidebar menu -->
        <ul class="nav sidebar-menu">
            <li>
                <a href="<?=base_url()?>index.php/sales-dashboard">
                    <span class="glyphicons glyphicons-home"></span>
                    <span class="sidebar-title">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="<?=base_url()?>">
                    <span class="glyphicons glyphicons-building"></span>
                    <span class="sidebar-title">Pilih Kawasan / Entity</span>
                </a>
            </li>
            <li>
                <a class="accordion-toggle" href="#">
                    <span class="glyphicons glyphicons-log_book"></span>
                    <span class="sidebar-title">Bussiness Plan</span>
                    <span class="caret"></span>
                </a>
                <ul class="nav sub-nav">
                    <li>
                        <a href="<?=base_url()?>index.php/entity" style="color: #4a89dc !important">
                            <span class="glyphicons glyphicons-building"></span> Kawasan / Entity
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a class="accordion-toggle" href="#">
                    <span class="fa fa-credit-card"></span>
                    <span class="sidebar-title">Master File Sales</span>
                    <span class="caret"></span>
                </a>
                <ul class="nav sub-nav">
                    <li>
                        <a href="<?=base_url()?>index.php/bank" style="color: #4a89dc !important">
                            <span class="glyphicons glyphicons-coins"></span> Bank
                        </a>
                    </li>
                    <li>
                        <a href="<?=base_url()?>index.php/bank-alokasi" style="color: #4a89dc !important">
                            <span class="glyphicons glyphicons-coins"></span> Pengaturan Bank KPR
                        </a>
                    </li>
                    <li>
                        <a href="<?=base_url()?>index.php/optional-stock" style="color: #4a89dc !important">
                            <span class="fa fa-clipboard"></span> Optional Stock
                        </a>
                    </li>
                    <li>
                        <a href="<?=base_url()?>index.php/stock" style="color: #4a89dc !important">
                            <span class="fa fa-clipboard"></span> Stock
                        </a>
                    </li>
                    <li>
                        <a href="<?=base_url()?>index.php/optional-unit-price" style="color: #4a89dc !important">
                            <span class="fa fa-money"></span> Optional Unit Price
                        </a>
                    </li>
                    <li>
                        <a href="<?=base_url()?>index.php/unit-price" style="color: #4a89dc !important">
                            <span class="fa fa-money"></span> Unit Price
                        </a>
                    </li>
                    <li>
                        <a href="<?=base_url()?>index.php/perijinan" style="color: #4a89dc !important">
                            <span class="fa fa-money"></span> Perijinan
                        </a>
                    </li>
                    <li>
                        <a href="<?=base_url()?>index.php/payment-plan/jenis" style="color: #4a89dc !important">
                            <span class="glyphicons glyphicons-stats"></span> Jenis Payment Plan
                        </a>
                    </li>
                    <li>
                        <a href="<?=base_url()?>index.php/payment-plan/pola" style="color: #4a89dc !important">
                            <span class="glyphicons glyphicons-cargo"></span> Pola Payment Plan
                        </a>
                    </li>
                    <li>
                        <a href="<?=base_url()?>index.php/diskon" style="color: #4a89dc !important">
                            <span class="glyphicons glyphicons-cargo"></span> Diskon
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a class="accordion-toggle" href="#">
                    <span class="fa fa-credit-card"></span>
                    <span class="sidebar-title">Sales</span>
                    <span class="caret"></span>
                </a>
                <ul class="nav sub-nav">
                    <li>
                        <a href="<?=base_url()?>index.php/hold" style="color: #4a89dc !important">
                            <span class="glyphicons glyphicons-notes_2"></span> Hold
                        </a>
                    </li>
                    <li>
                        <a href="<?=base_url()?>index.php/reserve" style="color: #4a89dc !important">
                            <span class="fa fa-archive"></span> Reserve
                        </a>
                    </li>
                    <li>
                        <a href="<?=base_url()?>index.php/booking" style="color: #4a89dc !important">
                            <span class="glyphicons glyphicons-calendar"></span> Pesanan
                        </a>
                    </li>
                    <li>
                        <a href="<?=base_url()?>index.php/sales-change-unit" style="color: #4a89dc !important">
                            <span class="glyphicons glyphicons-calendar"></span> Pindah Kavling
                        </a>
                    </li>
                    <li>
                        <a href="<?=base_url()?>index.php/sales-cancel" style="color: #4a89dc !important">
                            <span class="glyphicons glyphicons-calendar"></span> Cancellation
                        </a>
                    </li>
                    <li>
                        <a href="<?=base_url()?>index.php/sales-change-owner" style="color: #4a89dc !important">
                            <span class="glyphicons glyphicons-calendar"></span> Ganti Kepemilikan
                        </a>
                    </li>
                    <li>
                        <a class="accordion-toggle" href="#" style="color: #4a89dc !important">
                            <span class="fa fa-bar-chart-o"></span>
                            Report
                            <span class="caret"></span>
                        </a>
                        <ul class="nav sub-nav">
                            <li>
                                <a href="<?=base_url()?>index.php/sales/report/surat-pesanan" style="color: #ed7764 !important">
                                    Surat Pesanan
                                </a>
                            </li>
                            <li>
                                <a href="<?=base_url()?>index.php/sales/report/konfirmasi-unit" style="color: #ed7764 !important">
                                    Surat Konfirmasi Unit
                                </a>
                            </li>
                            <li>
                                <a href="<?=base_url()?>index.php/sales/report/kartu-nasabah" style="color: #ed7764 !important">
                                    Kartu Nasabah
                                </a>
                            </li>
                            <li>
                                <a href="<?=base_url()?>index.php/sales/report/kartu-piutang" style="color: #ed7764 !important">
                                    Laporan Penerimaan
                                </a>
                            </li>
                            <li>
                                <a href="<?=base_url()?>index.php/sales/report/penagihan" style="color: #ed7764 !important">
                                    Laporan Penagihan
                                </a>
                            </li>
                            <li>
                                <a href="<?=base_url()?>index.php/sales/report/rpt-op" style="color: #ed7764 !important">
                                    Konsolidasi OK
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li>
                <a class="accordion-toggle" href="#">
                    <span class="glyphicons glyphicons-inbox_in"></span>
                    <span class="sidebar-title">A R</span>
                    <span class="caret"></span>
                </a>
                <ul class="nav sub-nav">
                    <li>
                        <a href="<?=base_url()?>index.php/payment" style="color: #4a89dc !important">
                            <span class="fa fa-usd"></span> Penerimaan Pembayaran
                        </a>
                    </li>
                    <li>
                        <a class="accordion-toggle" href="#" style="color: #4a89dc !important">
                            <span class="imoon imoon-calculate"></span>
                            K P R
                            <span class="caret"></span>
                        </a>
                        <ul class="nav sub-nav">
                            <li>
                                <a href="<?=base_url()?>index.php/bank-plafond" style="color: #ed7764 !important">
                                    Plafond
                                </a>
                            </li>
                            <li>
                                <a href="<?=base_url()?>index.php/ri-kpr" style="color: #ed7764 !important">
                                    Realisasi Pambayaran
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li>
                <a class="accordion-toggle" href="#">
                    <span class="glyphicons glyphicons-spade"></span>
                    <span class="sidebar-title">Produksi</span>
                    <span class="caret"></span>
                </a>
                <ul class="nav sub-nav">
                    <li>
                        <a href="<?=base_url()?>index.php/rencana" style="color: #4a89dc !important">
                            <span class="glyphicons glyphicons-cargo"></span> R I K
                        </a>
                    </li>
                    <!--
                    <li>
                        <a href="<?=''//base_url()?>index.php" style="color: #4a89dc !important">
                            <span class="glyphicons glyphicons-cargo"></span> R K A P
                        </a>
                    </li>
                    -->
                    <li>
                        <a href="<?=base_url()?>index.php/bpdp" style="color: #4a89dc !important">
                            <span class="glyphicons glyphicons-cargo"></span> B P D P
                        </a>
                    </li>
                    <li>
                        <a href="<?=base_url()?>index.php/hpp" style="color: #4a89dc !important">
                            <span class="glyphicons glyphicons-cargo"></span> H P P
                        </a>
                    </li>
                    <!-- u -->
                    <li>
                        <a href="<?=base_url()?>index.php/sumberdaya" style="color: #4a89dc !important">
                            <span class="glyphicons glyphicons-cargo"></span> Sumberdaya
                        </a>
                    </li>
                    <li>
                        <a href="<?=base_url()?>index.php/harga-sumberdaya" style="color: #4a89dc !important">
                            <span class="fa fa-money"></span> Harga Sumberdaya
                        </a>
                    </li>
                    <li>
                        <a href="<?=base_url()?>index.php/rekanan" style="color: #4a89dc !important">
                            <span class="glyphicons glyphicons-cargo"></span> Rekanan
                        </a>
                    </li>
                    <!--
                    <li>
                        <a href="<?=''//base_url()?>index.php/tahap-pekerjaan" style="color: #4a89dc !important">
                            <span class="glyphicons glyphicons-cargo"></span> Tahap Pekerjaan
                        </a>
                    </li>
                    <li>
                        <a href="<?=''//base_url()?>index.php/kontrak" style="color: #4a89dc !important">
                            <span class="glyphicons glyphicons-cargo"></span> Kontrak
                        </a>
                    </li>
                    <li>
                        <a href="<?=''//base_url()?>index.php/opname-progress" style="color: #4a89dc !important">
                            <span class="glyphicons glyphicons-cargo"></span> Opname Progress
                        </a>
                    </li>
                    -->
                    <li>
                        <a href="<?=base_url()?>index.php/po" style="color: #4a89dc !important">
                            <span class="glyphicons glyphicons-cargo"></span> P O
                        </a>
                    </li>
                    <li>
                        <a href="<?=base_url()?>index.php/sppk" style="color: #4a89dc !important">
                            <span class="glyphicons glyphicons-cargo"></span> SPK Pekerjaan
                        </a>
                    </li>
                    <li>
                        <a href="<?=base_url()?>index.php/bapb" style="color: #4a89dc !important">
                            <span class="glyphicons glyphicons-cargo"></span> B A P B
                        </a>
                    </li>
                    <li>
                        <a href="<?=base_url()?>index.php/invoice" style="color: #4a89dc !important">
                            <span class="glyphicons glyphicons-cargo"></span> Invoice
                        </a>
                    </li>
                    <li>
                        <a href="<?=base_url()?>index.php/rpt-progress" style="color: #4a89dc !important">
                            <span class="glyphicons glyphicons-cargo"></span> Laporan Progress
                        </a>
                    </li>
                    <!--
                    <li>
                        <a href="<?=''//base_url()?>index.php/bpm" style="color: #4a89dc !important">
                            <span class="glyphicons glyphicons-cargo"></span> B P M
                        </a>
                    </li>
                    -->
                    <!-- end: u -->
                </ul>
            </li>
            <li>
                <a class="accordion-toggle" href="#">
                    <span class="glyphicons glyphicons-inbox_in"></span>
                    <span class="sidebar-title">Akuntansi</span>
                    <span class="caret"></span>
                </a>
                <ul class="nav sub-nav">
                    <li>
                        <a href="<?=base_url()?>index.php/jurnal/ar" style="color: #4a89dc !important">
                            <span class="fa fa-usd"></span> Integrasi A R
                        </a>
                    </li>
                    <li>
                        <a href="<?=base_url()?>index.php/jurnal/view" style="color: #4a89dc !important">
                            <span class="fa fa-usd"></span> Listing Jurnal
                        </a>
                    </li>
                    <li>
                        <a href="<?=base_url()?>index.php/jurnal/entry" style="color: #4a89dc !important">
                            <span class="fa fa-usd"></span> Input Jurnal
                        </a>
                    </li>
                    <li>
                        <a class="accordion-toggle" href="#" style="color: #4a89dc !important">
                            <span class="fa fa-bar-chart-o"></span>
                            Report
                            <span class="caret"></span>
                        </a>
                        <ul class="nav sub-nav">
                            <li>
                                <a href="<?=base_url()?>index.php/rpt-acc/neraca-t" style="color: #ed7764 !important">
                                    Posisi Keuangan
                                </a>
                            </li>
                            <li>
                                <a href="<?=base_url()?>index.php/rpt-acc/neraca-lajur" style="color: #ed7764 !important">
                                    Neraca Lajur
                                </a>
                            </li>
                            <li>
                                <a href="<?=base_url()?>index.php/rpt-acc/labarugi" style="color: #ed7764 !important">
                                    Laba Rugi
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</aside>