<?php
/**
 * The template for displaying posts in the Image post format
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<?php if ( is_single() ) : ?>


			<div class="entry-meta">
				<?php thelawyer_entry_meta(); ?>

				<?php edit_post_link( esc_html__( 'Edit', 'the-lawyer' ), '<span class="edit-link">', '</span>' ); ?>

				<?php if ( is_single() && get_the_author_meta( 'description' ) && is_multi_author() ) : ?>
					<?php get_template_part( 'author-bio' ); ?>
				<?php endif; ?>
			</div><!-- .entry-meta -->
			<?php if ( has_post_thumbnail() && ! is_attachment() ) {
				echo '<div class="entry-thumbnail">';
				the_post_thumbnail( 'post-thumbnails' );
				echo '</div>';
			} else {

			}
			?>
			<?php thelawyer_heading_header4(); ?>
		<?php else : ?>
			<?php if ( has_post_thumbnail() && ! is_attachment() ) {
				echo '<div class="entry-thumbnail">';
				the_post_thumbnail( 'post-thumbnails' );
				echo '<div class="thumbhover"><a href="'.get_permalink().'"><span class="icon-eye2"></span></a></div>
                    </div>';
			} else {

			}
			?>
		<h3 class="entry-title">
			<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h3>
			<div class="entry-meta">
				<?php thelawyer_entry_meta(); ?>

				<?php edit_post_link( esc_html__( 'Edit', 'the-lawyer' ), '<span class="edit-link">', '</span>' ); ?>

				<?php if ( is_single() && get_the_author_meta( 'description' ) && is_multi_author() ) : ?>
					<?php get_template_part( 'author-bio' ); ?>
				<?php endif; ?>
			</div><!-- .entry-meta -->
			<div class="dline"><?php thelawyer_entry_date(); ?></div>
		<?php endif; // is_single() ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
		if ( is_single() ) {
			/* translators: %s: Name of current post */
			the_content( sprintf(
				esc_html__( 'Continue reading %s ', 'the-lawyer' ), '<span class="meta-nav">&rarr;</span>',
				the_title( '<span class="screen-reader-text">', '</span>', false )
			) );

			wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'the-lawyer' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
		}

		?>
		<div class="clearfix"></div>
	</div><!-- .entry-content -->


</article><!-- #post -->
