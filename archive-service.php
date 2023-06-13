<?php
/**
 * The template for displaying Archive pages
 */

get_header(); ?>

<div id="primary" class="content-area">
	<header class="archive-header">
		<h1 class="archive-title"><?php thelawyer_serv_title(); ?></h1>
	</header><!-- .archive-header -->
	<?php thelawyer_services_desc(); ?>

	<div id="content" class="site-content serviceslist" role="main">

		<?php if (have_posts()) : ?>
			<?php while (have_posts()) : the_post(); ?>
				<?php
				// Retrieve the value of the 'sicon' custom field using the Types plugin.
				$servico = types_render_field("sicon", array("url" => "true"));

				// Set a default image if the post doesn't have a featured image.
				$thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'thelawyer_services');
				if (empty($thumbnail)) {
					$thumbnail = get_template_directory_uri() . '/images/nots.gif';
				}
				?>

				<div class="<?php thelawyer_services_column_control(); ?> lawyer_services">
					<div class="entry-thumbnail">
						<img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" />
						<div class="staticover">
							<a href="<?php the_permalink(); ?>" class="ico">
								<img src="<?php echo esc_url($servico); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
							</a>
							<h5><a href="<?php the_permalink(); ?>" class="more"><?php the_title(); ?></a></h5>
						</div>
						<div class="thumbhover">
							<a href="<?php the_permalink(); ?>"><span class="icon-eye2"></span></a>
						</div>
					</div>
				</div>

			<?php endwhile; ?>

			<?php thelawyer_paging_nav(); ?>

		<?php else : ?>
			<?php get_template_part('content', 'none'); ?>
		<?php endif; ?>
	</div><!-- #content -->

</div><!-- #primary -->

<?php get_footer(); ?>
