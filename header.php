<?php
/**
 * The Header for our theme.
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
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );

	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// If paged && not page 1, add the page number
	essence_the_page_number();
	?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
	/**
	 * Add some JavaScript to pages with the comment form to support sites with
	 * threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/**
	 * Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
	$hTag = apply_filters( 'esssence_title_tag', ( is_home() || is_front_page() )? 'h1' : 'h4' );
?>
</head>

<body <?php body_class(); ?>>
	<div id="header">
		<div id="masthead">
			<div id="branding" role="banner" class="container">
				<<?php echo $hTag; ?> id="site-title">
					<span>
						<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
					</span>
				</<?php echo $hTag;?>>
				<div id="site-description"><?php bloginfo( 'description' ); ?></div>
			</div>
<?php
				// Check to see if the header image has been removed
				$header_image = get_header_image();
				if ( ! empty( $header_image ) ) {
			?>
			<div class="header-image" style="height:<?php echo HEADER_IMAGE_HEIGHT; ?>px">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<?php
						// The header image
						// Check if this is a post or page, if it has a thumbnail, and if it's a big one
						if ( is_singular() &&
								has_post_thumbnail( $post->ID ) &&
								( /* $src, $width, $height */ $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), array( HEADER_IMAGE_WIDTH, HEADER_IMAGE_WIDTH ) ) ) &&
								$image[1] >= HEADER_IMAGE_WIDTH ) {
							// Houston, we have a new header image!
							echo get_the_post_thumbnail( $post->ID, 'post-thumbnail' );
						} else {
					?><img src="<?php header_image(); ?>" width="<?php echo HEADER_IMAGE_WIDTH; ?>" height="<?php echo HEADER_IMAGE_HEIGHT; ?>" alt="" />
<?php
						} // end check for featured image or standard header
					?>
				</a>
			</div>
			<?php
				} // end check for removed header image
			?>

			<div id="access" class="navigation container" role="navigation">
				<?php /* Allow screen readers and text browsers to skip to the content */ ?>
				<div class="skip-link screen-reader-text"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'essence' ); ?>"><?php _e( 'Skip to content', 'essence' ); ?></a></div>
				<?php do_action( 'essence_primary_nav' ); ?>
				<?php do_action( 'essence_secondary_nav' ); ?>
			</div><!-- #access -->
		</div><!-- #masthead -->
	</div><!-- #header -->
	<div id="wrapper" class="hfeed container">
