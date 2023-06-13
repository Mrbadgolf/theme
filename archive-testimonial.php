<?php
/**
 * The template for displaying Archive Testimonials pages
 */
get_header(); ?>

<div id="primary" class="content-area testimonialsarchive">
    <div id="content" class="site-content" role="main">

        <?php if ( have_posts() ) : ?>
            <header class="archive-header">
                <h1 class="archive-title"><?php thelawyer_testi_title(); ?></h1>
            </header><!-- .archive-header -->
            <?php thelawyer_testi_desc(); ?>

            <?php /* The loop */ ?>
            <?php while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <div class="entry-content">
                            <?php
                            $client_name = types_render_field("name-of-client", array("output"=>"normal"));
                            $client_post = types_render_field("post-of-client", array("output"=>"normal"));
                            $client_photo = types_render_field( "photo-of-client", array("url" => "true"));
                            echo '<a href="'.esc_url(get_permalink()).'"><img src="'.esc_url($client_photo).'" alt="'.$client_name.'"></a>';
                            ?>
                            <div class="mention">
                                <?php the_excerpt(); ?>
                            </div>
                             <?php
                                  echo '<strong>'.esc_attr($client_name).'</strong><p>'.esc_attr($client_post).'</p>';
                             ?>
                    </div>
                </article><!-- #post -->


            <?php endwhile; ?>

            <?php thelawyer_paging_nav(); ?>

        <?php else : ?>
            <?php get_template_part( 'content', 'none' ); ?>
        <?php endif; ?>

    </div><!-- #content -->
</div><!-- #primary -->

<?php get_footer(); ?>
