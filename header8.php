<!-- HEADER 8 START -->
<div class ="head8">
    <?php
    thelawyer_topbar3();
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
                                            
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php thelawyer_topbar_cta(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php thelawyer_set_customized_slider(); ?>
</div>
<!-- HEADER 8 END -->
