<!-- Start: Sidebar -->
<aside id="sidebar_left" class="nano nano-primary sidebar-light affix">
    <div class="nano-content">

        <!-- sidebar menu -->
        <ul class="nav sidebar-menu">
        <?php
        foreach ($data as $k => $v) {
            if(isset($v['children'])) {
        ?>
            <li id="<?=$k?>">
                <a class="accordion-toggle" href="#">
                    <span class="<?=$v['icon']?>"></span>
                    <span class="sidebar-title"><?=$v['judul_menu']?></span>
                    <span class="caret"></span>
                </a>
                <ul class="nav sub-nav">
        <?php
                foreach ($v['children'] as $k2 => $v2) {
                    if(isset($v2['children'])) {
        ?>
                    <li>
                        <a class="accordion-toggle" href="#" style="color: #4a89dc !important">
                            <span class="<?=$v2['icon']?>"></span> <?=$v2['judul_menu']?>
                            <span class="caret"></span>
                        </a>
                        <ul class="nav sub-nav">
        <?php
                        foreach ($v2['children'] as $k3 => $v3) {
        ?>
                            <li>
                                <a href="<?=base_url()?>index.php/<?=$v3['url']?>" style="color: #ed7764 !important">
                                    <?=$v3['judul_menu']?>
                                </a>
                            </li>
        <?php
                        }
        ?>
                        </ul>
                    </li>
        <?php
                    } else {
        ?>
                    <li>
                        <a href="<?=base_url()?>index.php/<?=$v2['url']?>" style="color: #4a89dc !important">
                            <span class="<?=$v2['icon']?>"></span> <?=$v2['judul_menu']?>
                        </a>
                    </li>
        <?php
                    }
                }
        ?>
                </ul>
            </li>
        <?php
            } else {
        ?>
            <li id="<?=$k?>">
                <a href="<?=base_url()?>index.php/<?=$v['url']?>">
                    <span class="<?=$v['icon']?>"></span>
                    <span class="sidebar-title"><?=$v['judul_menu']?></span>
                </a>
            </li>
        <?php
            }
        }
        ?>
        </ul>
    </div>
</aside>