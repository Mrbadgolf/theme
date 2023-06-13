<?php
/**
 * The template for displaying 404 pages (Not Found)
 */

get_header();

if (have_posts()) :
	while (have_posts()) :
		the_post();
	endwhile;
else :
	?>
	<div id="primary" class="content-area error404">
		<div id="content" class="site-content" role="main">

			<header class="page-header">
				<h1 class="page-title"><?php esc_html_e('Not Found', 'the-lawyer'); ?></h1>
			</header>

			<div class="page-wrapper">
				<div class="page-content text-center">
					<div class="e404">
						<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/404.png" alt="<?php echo esc_attr__('Error 404: Page Not Found', 'the-lawyer'); ?>" class="img-responsive center-block mb50">
						<h2><?php esc_html_e('Sorry! Page not found!', 'the-lawyer'); ?></h2>

					</div>

					<div></div>
					<p><?php esc_html_e('It looks like nothing was found at this location. Maybe try a search?', 'the-lawyer'); ?></p>
					<?php get_search_form(); ?>

				</div><!-- .page-content -->
			</div><!-- .page-wrapper -->

		</div><!-- #content -->
	</div><!-- #primary -->

<?php
endif;

get_footer();
?>
