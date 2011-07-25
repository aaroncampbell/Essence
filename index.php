<?php

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
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

get_header();
?>

    <div id="content-container" class="span-15">
        <div id="content" role="main">
			<?php
			do_action( 'essence_content_open' );
			essence_content_nav( 'nav-above' );

			/* Run the loop to output the posts.
			 * If you want to overload this in a child theme then include a file
			 * called loop-index.php and that will be used instead.
			 */
			get_template_part( 'loop', 'index' );
			essence_content_nav( 'nav-below' );
			?>
        </div><!-- #content -->
    </div><!-- #content-container -->

<?php
get_sidebar();
get_footer();
