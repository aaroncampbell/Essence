<?php
/**
 * The Sidebar containing the primary and secondary widget areas
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

?>

		<div class="span-9 last sidebar-right">
			<div id="primary" class="widget-area" role="complementary">
				<ul class="xoxo">
				<?php if ( ! dynamic_sidebar( 'primary-widget-area' ) ) { // begin primary widget area ?>
					<li id="search" class="widget-container widget_search">
						<?php get_search_form(); ?>
					</li>

					<li id="archives" class="widget-container">
						<h3 class="widget-title"><?php _e( 'Archives', 'essence' ); ?></h3>
						<ul>
							<?php wp_get_archives( 'type=monthly' ); ?>
						</ul>
					</li>

					<li id="meta" class="widget-container">
						<h3 class="widget-title"><?php _e( 'Meta', 'essence' ); ?></h3>
						<ul>
							<?php wp_register(); ?>
							<li><?php wp_loginout(); ?></li>
							<?php wp_meta(); ?>
						</ul>
					</li>
				<?php } // end primary widget area ?>
				</ul>
			</div><!-- #primary .widget-area -->

			<?php if ( is_active_sidebar( 'secondary-widget-area' ) ) { // Nothing here by default and design ?>
			<div id="secondary" class="widget-area sidebar-right" role="complementary">
				<ul class="xoxo">
					<?php dynamic_sidebar( 'secondary-widget-area' ); ?>
				</ul>
			</div><!-- #secondary .widget-area -->
			<?php } ?>
		</div>
