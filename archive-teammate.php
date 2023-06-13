<?php
/**
 * The template for displaying Archive pages
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content catteam" role="main">

		<?php if ( have_posts() ) : ?>
			<header class="archive-header">
				<h1 class="archive-title"><?php thelawyer_team_title(); ?></h1>
			</header><!-- .archive-header -->
			<?php thelawyer_team_desc(); ?>
			<div class="team-slide">
			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
			
				<?php $postofmember = types_render_field("post-of-member", array("output" => "normal"));
				thelawyer_teammate_switcher(); ?>
				
			<?php endwhile; ?>
			</div>
			<?php thelawyer_paging_nav(); ?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>
