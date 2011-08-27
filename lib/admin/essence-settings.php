<?php
/**
 * Register the default values for essence theme settings
 */
function essence_theme_settings_defaults() {
	$defaults = array( // define our defaults
		'blog_title_image'       => '',
		'nav'                    => true,
		'nav_superfish'          => true,
		'nav_home'               => true,
		'subnav'                 => false,
		'subnav_superfish'       => true,
		'subnav_home'            => false,
		'widgetize_header_right' => false,
		'header_image_width'     => 940,
		'header_image_height'    => 200,
	);

	return apply_filters('essence_theme_settings_defaults', $defaults);
}

/**
 * This registers the settings field and adds defaults to the options table.
 */
add_action('admin_init', 'essence_register_theme_settings', 5);
function essence_register_theme_settings() {
	register_setting( ESSENCE_SETTINGS_GROUP, ESSENCE_SETTINGS_FIELD, 'essence_sanitize_theme_settings' );
}

function essence_sanitize_theme_settings( $options ) {
	if ( isset( $options['blog_title_image'] ) )
		$options['blog_title_image'] = esc_url_raw( $options['blog_title_image'] );

	if ( isset( $options['nav'] ) )
		$options['nav'] = essence_boolean( $options['nav'] );

	if ( isset( $options['subnav'] ) )
		$options['subnav'] = essence_boolean( $options['subnav'] );

	if ( isset( $options['widgetize_header_right'] ) )
		$options['widgetize_header_right'] = essence_boolean( $options['widgetize_header_right'] );

	if ( isset( $options['header_image_width'] ) )
		$options['header_image_width'] = absint( $options['header_image_width'] );

	if ( isset( $options['header_image_height'] ) )
		$options['header_image_height'] = absint( $options['header_image_height'] );

	return $options;
}

function essence_boolean( $bool ) {
	if ( 'false' == $bool )
		return false;

	return (bool) $bool;
}

function essence_theme_admin_settings() {
	global $screen_layout_columns;
	if ( empty( $screen_layout_columns ) || (int) $screen_layout_columns < 1 ) {
		$screen_layout_columns = 1;
	}

	/**
	 * @todo Consider getting all sidebar boxes in ob and then using that to
	 * determine width.  It would allow a before and after action.
	 */
	//global $wp_meta_boxes;
	//$main_width = empty( $sidebarBoxes )? '100%' : '75%';
	$main_width = '75';
	//if ( !isset($wp_meta_boxes) || !isset($wp_meta_boxes[$page]) || !isset($wp_meta_boxes[$page][$context]) )
	if ( $screen_layout_columns == 3 ) {
		$col_width = '32.67%';
	}
	elseif ( $screen_layout_columns == 2 ) {
		$col_width = '49%';
	}
	else {
		$col_width = '99%';
	}
	?>
		<div class="wrap">
			<?php essence_screen_icon_link(); ?>
			<form action="options.php" method="post">
				<h2>
					<?php esc_html_e( 'Essence Settings', 'essence' ); ?>
				</h2>

				<div class="metabox-holder">
					<div style="width:<?php echo $main_width; ?>%; float:left;">
<?php
					settings_fields( ESSENCE_SETTINGS_GROUP );
					for ( $i = 1; $i <= $screen_layout_columns; $i++ ) {
?>
						<div class="postbox-container" style="width:<?php echo $col_width; ?>;">
<?php
						do_action( "essence-settings-col{$i}-top" );
						do_meta_boxes( 'essence-settings', "col{$i}", '' );
						do_action( 'essence-settings', "col{$i}" );
						do_action( "essence-settings-col{$i}-bottom" );
?>
						</div>
<?php
					}
?>
						<p class="submit">
							<input type="submit" name="Submit" value="<?php esc_attr_e('Update Options &raquo;', 'essence'); ?>" class="button-primary" />
						</p>
					</div>
					<div class="postbox-container" style="width:24%;">
						<?php
							do_meta_boxes( 'essence-settings', 'sidebar', '' );
						?>
					</div>
				</div>
			</form>
		</div>
	<?php
}

add_action( 'admin_init', 'essence_add_default_options_meta_boxes' );
function essence_add_default_options_meta_boxes() {
	/**
	 * Column 1
	 */
	add_meta_box( 'essence-theme-settings-general', __( 'General Settings', 'essence' ), 'essence_theme_settings_general_box', 'essence-settings', 'col1');

	/**
	 * Sidebar
	 */
	add_meta_box( 'essence-xavisys-feed', __( 'Latest news from Xavisys', 'essence' ), 'essence_xavisys_feed_meta_box', 'essence-settings', 'sidebar');
}

function essence_xavisys_feed_meta_box() {
	$args = array(
		'url'			=> 'http://feeds.feedburner.com/Xavisys',
		'items'			=> '5',
	);
	echo '<div class="rss-widget">';
	wp_widget_rss_output( $args );
	echo "</div>";
}

function essence_theme_settings_general_box() { ?>
	<p>
		<label for="blog_title_image">
			<?php _e("Logo Image:", 'essence'); ?>
		</label>
		<input type="text" value="<?php esc_attr_e( essence_get_option('blog_title_image') ); ?>" class="regular-text code" name="<?php echo ESSENCE_SETTINGS_FIELD; ?>[blog_title_image]" id="blog_title_image">
	</p>
	<p>
		<input type="hidden" name="<?php echo ESSENCE_SETTINGS_FIELD; ?>_nav" value="0" />
		<input type="checkbox" name="<?php echo ESSENCE_SETTINGS_FIELD; ?>[nav]" id="<?php echo ESSENCE_SETTINGS_FIELD; ?>_nav" value="1" <?php checked(1, essence_get_option('nav')); ?> />
		<label for="<?php echo ESSENCE_SETTINGS_FIELD; ?>_nav"><?php _e("Include Navigation Menu?", 'essence'); ?></label>
	</p>
	<p>
		<input type="hidden" name="<?php echo ESSENCE_SETTINGS_FIELD; ?>_subnav" value="0" />
		<input type="checkbox" name="<?php echo ESSENCE_SETTINGS_FIELD; ?>[subnav]" id="<?php echo ESSENCE_SETTINGS_FIELD; ?>_subnav" value="1" <?php checked(1, essence_get_option('subnav')); ?> />
		<label for="<?php echo ESSENCE_SETTINGS_FIELD; ?>_subnav"><?php _e("Include Secondary Navigation Menu?", 'essence'); ?></label>
	</p>
	<p>
		<input type="hidden" name="<?php echo ESSENCE_SETTINGS_FIELD; ?>_widgetize_header_right" value="0" />
		<input type="checkbox" name="<?php echo ESSENCE_SETTINGS_FIELD; ?>[widgetize_header_right]" id="<?php echo ESSENCE_SETTINGS_FIELD; ?>_widgetize_header_right" value="1" <?php checked(1, essence_get_option('widgetize_header_right')); ?> />
		<label for="<?php echo ESSENCE_SETTINGS_FIELD; ?>_widgetize_header_right"><?php _e("Widgetize Right Side of Header?", 'essence'); ?></label>
	</p>
	<p>
		<label for="<?php echo ESSENCE_SETTINGS_FIELD; ?>_header_image_width">
			<?php _e("Header Image Width:", 'essence'); ?>
		</label>
		<input type="text" value="<?php esc_attr_e( essence_get_option('header_image_width') ); ?>" class="small-text code" name="<?php echo ESSENCE_SETTINGS_FIELD; ?>[header_image_width]" id="<?php echo ESSENCE_SETTINGS_FIELD; ?>_header_image_width">
	</p>
	<p>
		<label for="<?php echo ESSENCE_SETTINGS_FIELD; ?>_header_image_height">
			<?php _e("Header Image Height:", 'essence'); ?>
		</label>
		<input type="text" value="<?php esc_attr_e( essence_get_option('header_image_height') ); ?>" class="small-text code" name="<?php echo ESSENCE_SETTINGS_FIELD; ?>[header_image_height]" id="<?php echo ESSENCE_SETTINGS_FIELD; ?>_header_image_height">
	</p>
<?php
}
