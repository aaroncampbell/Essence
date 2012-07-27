<?php
/**
 * The Template used to display all single posts
 *
 * @since 0.0.1
 */
essence_show_template_file( __FILE__ );

get_header();
?>

		<div id="content" class="columns eight" role="main">
			<?php
			do_action( 'essence_content_open' );
			/* Run the loop to output the post.
			 * If you want to overload this in a child theme then include a file
			 * called loop-single.php and that will be used instead.
			 */
			get_template_part( 'loop', 'single' );
			?>

		</div><!-- #content -->

<?php
get_sidebar();
get_footer();
