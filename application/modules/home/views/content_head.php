<!-- Start: Content -->
<section id="content_wrapper">

    <!-- Start: Topbar -->
    <header id="topbar">
        <div class="col-md-10 topbar-left">
            <span class="fs18"><?=@$nama?></span>
        </div>
        <div class="col-md-2 topbar-right">
            <?php if(isset($btnurl)) { ?>
            <a href="<?=@$btnurl?>" class="btn btn-sm btn-primary btn-gradient dark btn-block"><span class="fa fa-plus"></span>  New Data</a>
            <?php } ?>
        </div>
    </header>
    <!-- End: Topbar -->