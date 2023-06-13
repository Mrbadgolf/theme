<?php
/*
 
 * The template for displaying portfolio pages. Nothing special here
 *

 */

get_header(); ?>

	<div id="primary" class="content-area cases">
		<div id="content" class="site-content" role="main">

			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php
					$thelawyer_case_cat = types_render_field("theseo_project_category", array("output"=>"normal"));
					?>
					<h4 class="cat"><?php echo esc_attr($thelawyer_case_cat); ?></h4>
					<header>
						<div class="casenavi">
							<?php echo '<a href="'.esc_url(get_permalink(get_adjacent_post(false,'',false))).'"><span class="icon-arrow-right22"></span></a>'; ?>
							<?php echo '<a href="'.esc_url(get_permalink(get_adjacent_post(false,'',true))).'"><span class="icon-arrow-left22"></span></a>'; ?>
						</div>
						<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
						<?php the_excerpt(); ?>

					</header>
					<div class="entry-content">


						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'the-lawyer' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
					</div><!-- .entry-content -->


						<?php edit_post_link( esc_html__( 'Edit', 'the-lawyer' ), '<span class="edit-link">', '</span>' ); ?>

				</article><!-- #post -->

			<?php endwhile; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>
