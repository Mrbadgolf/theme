<?php
/*
 Template Name: Header 8 Template

 * The template for displaying demonstration of Header 8
 */

set_globals();

?>

<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
    thelawyer_headicons();
    do_action('get_header_scripts');
    wp_head();
    thelawyer_set_boxed_background();
    ?>
</head>

<body <?php body_class(); ?>>

<?php
thelawyer_pageloader();
thelawyer_set_boxed_layout();

get_template_part('header8');

?>

<main>
    
    <div class="container">
        <div class="row">
            <?php
            /* Sidebars Main */

            thelawyer_set_header_sidebar_layout();

            ?>

            <?php /* The loop */ ?>
            <?php while ( have_posts() ) : the_post(); ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <div class="entry-content">
                        <?php the_content(); ?>
                        <?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'the-lawyer' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
                    </div><!-- .entry-content -->

                    <?php edit_post_link( esc_html__( 'Edit', 'the-lawyer' ), '<div class="pageedit_link"><span class="edit-link">', '</span></div>' ); ?>
                </article><!-- #post -->

            <?php endwhile; ?>


            <?php get_footer(); ?>
