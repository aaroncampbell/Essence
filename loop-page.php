<?php
/**
 * The loop that displays a page.
 *
 * The loop displays the posts and the post content.  See
 * http://codex.wordpress.org/The_Loop to understand it and
 * http://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 *
 * This can be overridden in child themes with loop-page.php.
 *
 * @since 0.0.1
 */

if ( WP_DEBUG && !empty( $_REQUEST['debug'] ) ) {
	if ( 'show' != $_REQUEST['debug'] ) {
		echo '<!-- ';
	}
	esc_html_e( 'Theme File: ' . __FILE__ );
	if ( 'show' != $_REQUEST['debug'] ) {
		echo ' -->';
	}
}

if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();
?>

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php if ( is_front_page() ) { ?>
						<h2 class="entry-title"><?php the_title(); ?></h2>
					<?php } else { ?>
						<h1 class="entry-title"><?php the_title(); ?></h1>
					<?php } ?>

					<div class="entry-content">
						<?php
							the_content();
							wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'essence' ), 'after' => '</div>' ) );
							edit_post_link( __( 'Edit', 'essence' ), '<span class="edit-link">', '</span>' );
						?>
					</div><!-- .entry-content -->
				</div><!-- #post-## -->

<?php
		comments_template( '', true );
	} // end of the loop.
}
