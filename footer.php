<?php
/**
 * The template used to display the footer
 *
 * Calls sidebar-footer.php for bottom widgets
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

?>

		<div id="footer" role="contentinfo">
			<div id="colophon">

				<?php
					/**
					 * A sidebar in the footer? Yep. You can can customize
					 * your footer with four columns of widgets.
					 */
					get_sidebar( 'footer' );
				?>

				<div id="site-info" class="clear span-15">
					<a href="<?php echo home_url( '/' ) ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
						<?php bloginfo( 'name' ); ?>
					</a>
				</div><!-- #site-info -->

				<div id="site-generator" class="span-9 last">
					<?php do_action( 'essence_credits' ); ?>
					<a href="<?php echo esc_url( apply_filters( 'essence-footer-link-url', 'http://essencetheme.com' ) ); ?>" title="<?php esc_attr_e( apply_filters( 'essence-footer-link-title', __( 'Essence Theme Framework for WordPress', 'essence' ) ) ); ?>" rel="generator"><?php esc_html_e( apply_filters( 'essence-footer-link-text', __( 'Proudly powered by Essence Theme Framework.', 'essence' ) ) ); ?></a>
				</div><!-- #site-generator -->

			</div><!-- #colophon -->
		</div><!-- #footer -->

	</div><!-- #wrapper -->

<?php wp_footer(); ?>

</body>
</html>
