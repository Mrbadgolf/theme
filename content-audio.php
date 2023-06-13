
<?php
/**
 * The template for displaying posts in the Audio post format
 */
?>
<?php if ( is_single() ) { ?>
<div class="postpage">
	<?php } ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<?php if ( is_single() ) { ?>
				<div class="entry-meta">
					<?php thelawyer_entry_meta(); ?>
					<?php edit_post_link( esc_html__( 'Edit', 'the-lawyer' ), '<span class="edit-link">', '</span>' ); ?>
				</div><!-- .entry-meta -->
			<?php } ?>


			<?php if ( is_single() ) : ?>
				<?php if ( has_post_thumbnail() && ! is_attachment() ) {
					echo '<div class="entry-thumbnail">';
					the_post_thumbnail( 'post-thumbnails' );
					echo '</div>';
				} else {

				}
				?>
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
				<div class="entry-meta"><?php thelawyer_entry_meta(); ?>
					<?php edit_post_link( esc_html__( 'Edit', 'the-lawyer' ), '<span class="edit-link">', '</span>' ); ?></div>
			<?php endif; // is_single() ?>

			<?php thelawyer_heading_header4(); ?>

		</header><!-- .entry-header -->

		<?php if ( is_search() ) : // Only display Excerpts for Search ?>
			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->
		<?php else : ?>
			<div class="entry-content">
				<?php if ( is_single()) : ?>
					<?php
					/* translators: %s: Name of current post */
					the_content( sprintf(
						esc_html__( 'Continue reading ', 'the-lawyer' ), '<span class="meta-nav">&rarr;</span>',
						the_title( '<span class="screen-reader-text">', '</span>', false )
					) );

					wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'the-lawyer' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
					?>
				<?php else : ?>

					<?php thelawyer_entry_date(); ?>
				<?php endif; // is_single() ?>

			</div><!-- .entry-content -->
		<?php endif; ?>

	</article><!-- #post -->

	<?php if ( is_single() ) { ?>
</div>
<?php } ?>