<?php
/*
Teammate template page - spesial for teammmate custom post type
*/

get_header(); ?>


                <?php /* The loop */ ?>
                <?php while ( have_posts() ) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?> " <?php post_class(); ?>>

                        <?php $postofmember = types_render_field("post-of-member", array("output" => "normal"));
                        thelawyer_teammate_page_switcher(); ?>
                        
                    </article><!-- #post -->

                    


                <?php endwhile; ?>

<?php get_footer(); ?>
