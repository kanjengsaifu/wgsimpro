<!DOCTYPE html>
<html>

<head>
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <title>SIMPRO - WIKA GEDUNG | 2015</title>
    <meta name="keywords" content="SIM PROPERTY WIKA GEDUNG 2015" />
    <meta name="description" content="SIM PROPERTY WIKA GEDUNG 2015">
    <meta name="author" content="WIKA GEDUNG">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Font CSS (Via CDN) -->
    <link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800'>
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Roboto:400,500,700,300">

    <!-- Theme CSS -->
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/assets/fonts/icomoon/icomoon.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/assets/skin/default_skin/css/theme.css">

    <!-- datatables -->
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/vendor/plugins/datatables/media/css/dataTables.bootstrap.css">
    
    <!-- datepicker -->
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/vendor/plugins/datepicker/css/bootstrap-datetimepicker.css">
    
    <!-- jquery choosen -->
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/vendor/plugins/choosen/chosen.min.css">
    
    <!-- jquery duallistbox -->
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/vendor/plugins/duallistbox/bootstrap-duallistbox.min.css">
    
    <!-- jquery jstree -->
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/vendor/plugins/jstree/themes/default/style.min.css">

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?=base_url()?>assets/img/wika_realty.ico">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->

</head>

<body class="blank-page">


    <!-- Start: Main -->
    <div id="main">

        <!-- Start: Header -->
        <header class="navbar navbar-fixed-top bg-success2">
            <ul class="nav navbar-nav navbar-left">
                <li style="width:165px;padding-left:60px">
                    <img src="<?=base_url()?>assets/assets/img/logos/logo_wr.png" style="width:100%" alt="WIKA REALTY"/>
                </li>
                <li style="margin-left:20px">
                    <span id="toggle_sidemenu_l" class="glyphicons glyphicons-show_lines"></span>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle fw600 p15" data-toggle="dropdown"> <img src="<?=base_url()?>assets/assets/img/avatars/2.jpg" alt="avatar" class="mw30 br64 mr15">
                        <span>&nbsp;<?=$this->session->userdata('nama')?>&nbsp;</span>
                        <span class="caret caret-tp"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-persist pn w250 bg-white" role="menu">
                        <li class="br-t of-h">
                            <a href="#" class="fw600 p12 animated animated-short fadeInDown">
                                <span class="fa fa-home pr5"></span> Pilih Kawasan / Entity </a>
                        </li>
                        <li class="br-t of-h">
                            <a href="#" class="fw600 p12 animated animated-short fadeInDown">
                                <span class="fa fa-gear pr5"></span> Pengaturan Akun </a>
                        </li>
                        <li class="br-t of-h">
                            <a href="<?=base_url()?>index.php/logout" class="fw600 p12 animated animated-short fadeInDown">
                                <span class="fa fa-power-off pr5"></span> Logout </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </header>
        <!-- End: Header -->