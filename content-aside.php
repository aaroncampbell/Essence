<?php
/**
 * The template for display posts of the aside type
 *
 * @since 0.0.1
 */
essence_show_template_file( __FILE__ );
?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<?php if ( is_archive() || is_search() ) { // Display excerpts for archives and search. ?>
			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->
		<?php } else { ?>
			<div class="entry-content">
				<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'essence' ) ); ?>
			</div><!-- .entry-content -->
		<?php } ?>

			<div class="entry-utility">
				<?php essence_posted_on(); ?>
				<span class="meta-sep">|</span>
				<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'essence' ), __( '1 Comment', 'essence' ), __( '% Comments', 'essence' ) ); ?></span>
				<?php edit_post_link( __( 'Edit', 'essence' ), '<span class="meta-sep">|</span> <span class="edit-link">', '</span>' ); ?>
			</div><!-- .entry-utility -->
		</div><!-- #post-## -->
