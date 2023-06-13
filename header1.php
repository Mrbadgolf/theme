<!-- HEADER 1 START -->
<?php 
    thelawyer_topbar(); 
?>

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

<?php thelawyer_set_customized_slider(); ?>

<!-- HEADER 1 END -->
