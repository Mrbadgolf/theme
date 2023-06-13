<?php
/**
 * The template for displaying Archive pages
 */

get_header(); ?>

	<div id="primary" class="content-area portfoliofeed">
		<div id="content" class="site-content" role="main">

		<?php if ( have_posts() ) : ?>
			<header class="archive-header">
				<h1 class="archive-title"><?php single_cat_title(); ?></h1>
			</header><!-- .archive-header -->
			<?php the_archive_description(); ?>
			<div class="cases_grid">
			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
				$thelawyer_case_cat = types_render_field("theseo_project_category", array("output"=>"normal"));
				?>
				<div class="case">
				<?php if ( has_post_thumbnail() ) { ?>
					<div class="case-image">
						<?php the_post_thumbnail(); ?>
					</div>
				<?php } ?>
				<div class="case-info">
					<h2 class="case-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<?php if ( $thelawyer_case_cat ) { ?>
						<div class="case-category"><?php echo esc_html( $thelawyer_case_cat ); ?></div>
					<?php } ?>
				</div>
				</div>
				
			<?php endwhile; ?>
			</div>
			
			<?php the_posts_pagination(); ?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>
