<?php
/**
 * The Footer widget areas.
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

	/* The footer widget area is triggered if any of the areas
	 * have widgets. So let's check that first.
	 *
	 * If none of the sidebars have widgets, then let's bail early.
	 */
	if (   ! is_active_sidebar( 'first-footer-widget-area'  )
		&& ! is_active_sidebar( 'second-footer-widget-area' )
		&& ! is_active_sidebar( 'third-footer-widget-area'  )
		&& ! is_active_sidebar( 'fourth-footer-widget-area' )
	)
		return;
	// If we get this far, we have widgets. Let do this.
?>

			<div id="footer-widget-area" role="complementary">

<?php
if ( is_active_sidebar( 'first-footer-widget-area' ) ) {
?>
				<div id="first" class="widget-area span-6">
					<ul class="xoxo">
						<?php dynamic_sidebar( 'first-footer-widget-area' ); ?>
					</ul>
				</div><!-- #first .widget-area -->
<?php
}

if ( is_active_sidebar( 'second-footer-widget-area' ) ) {
?>
				<div id="second" class="widget-area span-6">
					<ul class="xoxo">
						<?php dynamic_sidebar( 'second-footer-widget-area' ); ?>
					</ul>
				</div><!-- #second .widget-area -->
<?php
}

if ( is_active_sidebar( 'third-footer-widget-area' ) ) {
?>
				<div id="third" class="widget-area span-6">
					<ul class="xoxo">
						<?php dynamic_sidebar( 'third-footer-widget-area' ); ?>
					</ul>
				</div><!-- #third .widget-area -->
<?php
}

if ( is_active_sidebar( 'fourth-footer-widget-area' ) ) {
?>
				<div id="fourth" class="widget-area span-6 last">
					<ul class="xoxo">
						<?php dynamic_sidebar( 'fourth-footer-widget-area' ); ?>
					</ul>
				</div><!-- #fourth .widget-area -->
<?php
}
?>

			</div><!-- #footer-widget-area -->
