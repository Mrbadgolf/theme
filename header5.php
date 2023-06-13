<!-- HEADER 5 START -->
<div class ="head5">
    <?php
    thelawyer_topbar2();
    ?>


    <div class="whitelinemenu default" <?php thelawyer_sticky_class(); ?>>
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12 nav-wrap">
                    <div class="row">
                        <div class="navbar navbar-default">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="navbar-header visible-sm visible-xs pull-right">
                                        <button type="button" class="navbar-toogle open-menu-list" data-toggle="collapse" data-target="#responsive-menu"><span class="icon-menu11"></span></button>
                                    </div>
                                    <div class="collapse navbar-collapse" id="responsive-menu">
                                        <ul class="nav navbar-nav nav-list">
                                            <?php sell_set_nav(); ?>
                                            <?php thelawyer_cart_menu(); ?>
                                            <?php thelawyer_search_menu(); ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php thelawyer_set_customized_slider(); ?>

<!-- HEADER 5 END -->
