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
essence_show_template_file( __FILE__ );

get_header();
?>

    <div id="content" class="columns eight" role="main">
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

<?php
get_sidebar();
get_footer();
