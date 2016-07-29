<!DOCTYPE html>
<html>

<head>
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <title>SIMPRO - WIKA GEDUNG</title>
    <meta name="keywords" content="SIM PROPERTY WIKA GEDUNG">
    <meta name="description" content="SIM PROPERTY WIKA GEDUNG">
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

    <link rel="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css">

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
    
    <style type="text/css">
    .tunjuk {
        cursor:pointer;
    }
    .ui-autocomplete {
        cursor:pointer;
        position: absolute;
        top: 100%;
        left: 0;
        z-index: 1000;
        float: left;
        display: none;
        min-width: 160px;
        _width: 160px;
        padding: 4px 6px;
        margin: 2px 0 0 0;
        list-style: none;
        color: #000000;
        background-color: #FFFFD1;/*#6699FF;/*#ffffff;*/
        border-color: #ccc;
        border-color: rgba(0, 0, 0, 0.2);
        border-style: solid;
        border-width: 2px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        -webkit-background-clip: padding-box;
        -moz-background-clip: padding;
        background-clip: padding-box;
        *border-right-width: 2px;
        *border-bottom-width: 2px;

        .ui-menu-item > a.ui-corner-all {
            display: block;
            padding: 3px 15px;
            clear: both;
            font-weight: normal;
            line-height: 18px;
            color: #555555;
            white-space: nowrap;

            &.ui-state-hover, &.ui-state-active {
                color: #ffffff;
                text-decoration: none;
                background-color: #0088cc;
                border-radius: 0px;
                -webkit-border-radius: 0px;
                -moz-border-radius: 0px;
                background-image: none;
            }
        }
    }
    </style>
    <style>
        .no-js #loader { display: none;  }
        .js #loader { display: block; position: absolute; left: 100px; top: 0; }
        .se-pre-con {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url(<?=base_url()?>/assets/img/loader/Preloader_11.gif) center no-repeat #fff;
        }
    </style>

</head>

<body class="blank-page" ng-app="main-App">

    <div class="se-pre-con"></div>

    <!-- Start: Main -->
    <div id="main">

        <!-- Start: Header -->
        <header class="navbar navbar-fixed-top bg-primary">
            <ul class="nav navbar-nav navbar-left">
                <li style="width:170px;padding-left:25px; padding-top:15px;">
                    <img src="<?=base_url()?>assets/assets/img/logos/logo_wr.png" style="height:30px" alt="WIKA GEDUNG"/>
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