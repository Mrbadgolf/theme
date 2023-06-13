<!-- HEADER 4 START -->

<div class="shortheader1">
        <?php thelawyer_topbar(); ?>

    <div class="whitelinemenu default" <?php thelawyer_sticky_class(); ?>>
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-4 col-xs-12">
                    <?php thelawyer_topbar2_logo(); ?>
                </div>
                <div class="col-md-9 col-sm-8 col-xs-12 nav-wrap">
                    <div class="navbar navbar-default">
                        
                            <div class="navbar-header visible-sm visible-xs pull-right">
                                <button type="button" class="navbar-toogle open-menu-list" data-toggle="collapse" data-target="#responsive-menu"><span class="icon-menu11"></span></button>
                            </div>
                            <div class="collapse navbar-collapse pull-right" id="responsive-menu">
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

    <div class="container-fluid pageheading">
        <div class="overslider">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h1><?php
                                echo get_the_title();
                            ?></h1>
                        <div class="hidden-xs hidden-sm">
                            <div class="breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
                                <?php if ( function_exists('yoast_breadcrumb') )
                                {yoast_breadcrumb('','');} ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="sliderh4under">
            <?php thelawyer_set_customized_slider(); ?>
        </div>
    </div>

</div>


<!-- HEADER 4 END -->
