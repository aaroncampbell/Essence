<?php
/**
 * The Header for our theme.
 */
essence_show_template_file( __FILE__ );
?><!DOCTYPE html>

<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9" <?php language_attributes(); ?>>
<![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />

	<!-- Set the viewport width to device width for mobile -->
	<meta name="viewport" content="width=device-width" />
	<title><?php wp_title(); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
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
	<!-- container -->
	<div class="container">
		<div class="row">
			<header id="branding" role="banner" class="twelve columns">
				<hgroup<?php if ( essence_get_option( 'widgetize_header_right' ) ) { echo ' class="columns four"'; } ?>>
					<<?php echo $hTag; ?> id="site-title">
						<span>
							<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
								<?php
								if ( essence_get_option( 'blog_title_image' ) ) {
								?>
								<img src="<?php echo esc_url( essence_get_option( 'blog_title_image' ) ) ?>" alt="<?php esc_attr_e( get_bloginfo( 'name' ) ); ?>" />
								<?php
								} else {
									bloginfo( 'name' );
								}
								?>
							</a>
						</span>
					</<?php echo $hTag;?>>
					<aside id="site-description"><?php bloginfo( 'description' ); ?></aside>
				</hgroup>
				<?php
				if ( essence_get_option( 'widgetize_header_right' ) ) {
				?>
					<aside class="columns eight">
						<?php dynamic_sidebar( 'header-right-widget-area' ); ?>
					</aside>
				<?php
				}
					// Check to see if the header image has been removed
					$header_image = get_header_image();
					if ( ! empty( $header_image ) ) {
						$header_width = get_custom_header()->width;
						$header_height = get_custom_header()->height;
						?>
						<div class="header-image columns twelve">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
								<img src="<?php header_image(); ?>" alt="" />
							</a>
						</div>
						<?php
					} // end check for removed header image
				?>
			</header>
		</div>
		<div class="row">
			<nav class="navigation columns twelve" role="navigation">
				<h3 class="assistive-text"><?php _e( 'Main menu', 'essence' ); ?></h3>
				<?php /* Allow screen readers / text browsers to skip the navigation menu and get right to the good stuff. */ ?>
				<div class="skip-link screen-reader-text"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'essence' ); ?>"><?php _e( 'Skip to content', 'essence' ); ?></a></div>
				<?php do_action( 'essence_primary_nav' ); ?>
				<?php do_action( 'essence_secondary_nav' ); ?>
			</nav><!-- #access -->
		</div>
		<div class="row">
