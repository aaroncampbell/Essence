<?php
/**
 * The template for displaying Search Results pages.
 *
 * @since 0.0.1
 */

get_header();
if ( WP_DEBUG && !empty( $_REQUEST['debug'] ) ) {
	if ( 'show' != $_REQUEST['debug'] ) {
		echo '<!-- ';
	}
	esc_html_e( 'Theme File: ' . __FILE__ );
	if ( 'show' != $_REQUEST['debug'] ) {
		echo ' -->';
	}
}

?>

		<div id="content-container" class="span-15">
			<div id="content" role="main">

<?php if ( have_posts() ) { ?>
				<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'essence' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
				<?php
				do_action( 'essence_content_open' );
				essence_content_nav( 'nav-above' );
				/* Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called loop-search.php and that will be used instead.
				 */
				get_template_part( 'loop', 'search' );
				essence_content_nav( 'nav-below' );
				?>
<?php } else { ?>
				<div id="post-0" class="post no-results not-found">
					<h2 class="entry-title"><?php _e( 'Nothing Found', 'essence' ); ?></h2>
					<div class="entry-content">
						<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'essence' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</div><!-- #post-0 -->
<?php } ?>
			</div><!-- #content -->
		</div><!-- #container -->

<?php
get_sidebar();
get_footer();
