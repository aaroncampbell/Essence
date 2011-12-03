<?php
/**
 * The Search Form
 *
 * Optional file that allows displaying a custom search form
 * when the get_search_form() template tag is used.
 *
 * @package WordPress
 * @subpackage Twenty Ten
 * @since 0.0.1
 */
essence_show_template_file( __FILE__ );

?>

    <form id="searchform" name="searchform" method="get" action="<?php echo home_url(); ?>">
		<div>
			<label for="s"><?php _e( 'Search', 'essence' ); ?></label>
			<input type="text" id="s" name="s" x-webkit-speech />
			<input type="submit" id="searchsubmit" value="<?php esc_attr_e( 'Search', 'essence' ); ?>" />
		</div>
    </form>
