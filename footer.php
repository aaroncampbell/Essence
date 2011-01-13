<?php
/**
 * The template used to display the footer
 *
 * Calls sidebar-footer.php for bottom widgets
 *
 * @since 0.0.1
 */
?>

	<div id="footer" role="contentinfo">
		<div id="colophon">

<?php
	/* A sidebar in the footer? Yep. You can can customize
	 * your footer with four columns of widgets.
	 */
	get_sidebar( 'footer' );
?>

			<div id="site-info">
				<a href="<?php echo home_url( '/' ) ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
					<?php bloginfo( 'name' ); ?>
				</a>
			</div><!-- #site-info -->

			<div id="site-generator">
				<?php do_action( 'essence_credits' ); ?>
				<a href="<?php echo esc_url( __( 'http://gotthemes.com/', 'essence' ) ); ?>" title="<?php esc_attr_e( 'Essence Theme Framework for WordPress', 'essence' ); ?>" rel="generator"><?php _e( 'Proudly powered by Essence Theme Framework.', 'essence' ); ?></a>
			</div><!-- #site-generator -->

		</div><!-- #colophon -->
	</div><!-- #footer -->

</div><!-- #wrapper -->

<?php wp_footer(); ?>

</body>
</html>
