<?php
/**
 * The Search Form
 *
 * Optional file that allows displaying a custom search form
 * when the get_search_form() template tag is used.
 *
 * @package WordPress
 * @subpackage Twenty Ten
 * @since 3.0.0
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

    <form id="searchform" name="searchform" method="get" action="<?php echo home_url(); ?>">
		<div>
			<label for="s"><?php _e( 'Search', 'essence' ); ?></label>
			<input type="text" id="s" name="s" />
			<input type="submit" id="searchsubmit" value="<?php esc_attr_e( 'Search', 'essence' ); ?>" />
		</div>
    </form>
