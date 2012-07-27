<?php
/**
 * The template used to display Tag Archive pages
 *
 * @since 0.0.1
 */
essence_show_template_file( __FILE__ );

get_header();
?>

		<div id="content" class="columns eight">
			<h1 class="page-title"><?php
				printf( __( 'Tag Archives: %s', 'essence' ), '<span>' . single_tag_title( '', false ) . '</span>' );
			?></h1>

			<?php
			do_action( 'essence_content_open' );
			essence_content_nav( 'nav-above' );

			/* Run the loop for the tag archive to output the posts
			 * If you want to overload this in a child theme then include a file
			 * called loop-tag.php and that will be used instead.
			 */
			get_template_part( 'loop', 'tag' );
			essence_content_nav( 'nav-below' );
			?>
		</div><!-- #content -->

<?php
get_sidebar();
get_footer();
