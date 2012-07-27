<?php
/**
 * The Footer widget areas.
 *
 * @since 0.0.1
 */
essence_show_template_file( __FILE__ );
$essence_footer_sidebars = array(
	'first-footer-widget-area',
	'second-footer-widget-area',
	'third-footer-widget-area',
	'fourth-footer-widget-area',
);
foreach ( $essence_footer_sidebars as $index => $sidebar ) {
	if ( ! is_active_sidebar( $sidebar  ) )
		unset( $essence_footer_sidebars[$index] );
}

/**
 * The footer widget area is triggered if any of the areas have widgets.  If
 * none do, return
 */
if ( empty( $essence_footer_sidebars ) )
	return;

switch ( 12 / count( $essence_footer_sidebars ) ) {
	case 3:
		$essence_footer_sidebar_columns = 'three';
		break;
	case 4:
		$essence_footer_sidebar_columns = 'four';
		break;
	case 6:
		$essence_footer_sidebar_columns = 'six';
		break;
	case 12:
		$essence_footer_sidebar_columns = 'twelve';
		break;
}
?>

<div class="row footer" role="contentinfo">
	<div id="footer-widget-area" role="complementary">
		<?php
		foreach ( $essence_footer_sidebars as $sidebar ) {
			if ( is_active_sidebar( 'first-footer-widget-area' ) ) {
		?>
			<div class="widget-area columns <?php echo esc_attr( $essence_footer_sidebar_columns ) ?>">
				<ul class="xoxo">
					<?php dynamic_sidebar( $sidebar ); ?>
				</ul>
			</div><!-- .widget-area -->
		<?php
			}
		}
		?>
	</div><!-- #footer-widget-area -->
</div><!-- .row.footer -->
