<?php
/**
 * The template for displaying Category Archive pages.
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

				<h1 class="page-title"><?php
					printf( __( 'Category Archives: %s', 'essence' ), '<span>' . single_cat_title( '', false ) . '</span>' );
				?></h1>
				<?php
					$category_description = category_description();
					if ( ! empty( $category_description ) )
						echo "<div class='archive-meta'>{$category_description}</div>";

				do_action( 'essence_content_open' );
				essence_content_nav( 'nav-above' );

				/* Run the loop for the category page to output the posts.
				 * If you want to overload this in a child theme then include a file
				 * called loop-category.php and that will be used instead.
				 */
				get_template_part( 'loop', 'category' );
				essence_content_nav( 'nav-below' );
				?>

			</div><!-- #content -->
		</div><!-- #container -->

<?php
get_sidebar();
get_footer();
