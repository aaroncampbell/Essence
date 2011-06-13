<?php
/**
 * The template used to display Tag Archive pages
 *
 * @since 0.0.1
 */
if ( !empty( $_REQUEST['debug'] ) ) {
	if ( 'show' != $_REQUEST['debug'] ) {
		echo '<!-- ';
	}
	esc_html_e( 'Theme File: ' . __FILE__ );
	if ( 'show' != $_REQUEST['debug'] ) {
		echo ' -->';
	}
}

get_header(); ?>

		<div id="container" class="span-15">
			<div id="content">

				<h1 class="page-title"><?php
					printf( __( 'Tag Archives: %s', 'essence' ), '<span>' . single_tag_title( '', false ) . '</span>' );
				?></h1>

<?php
/* Run the loop for the tag archive to output the posts
 * If you want to overload this in a child theme then include a file
 * called loop-tag.php and that will be used instead.
 */
 get_template_part( 'loop', 'tag' );
?>
			</div><!-- #content -->
		</div><!-- #container -->

<?php
get_sidebar();
get_footer();
