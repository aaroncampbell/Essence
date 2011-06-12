<?php
class Essence_Options {
	/**
	 * @var Essence_Options - Static property to hold our singleton instance
	 */
	static $instance = false;

	/**
	 * @var array - Settings Cache - These are raw settings
	 */
	private $_settings_cache = array();

	/**
	 * @var array - Options Cache - These are the settings after they have been processed by our filters
	 */
	private $_options_cache = array();

	/**
	 * This is our constructor, which is private to force the use of getInstance()
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Function to instantiate our class and make it a singleton
	 */
	public static function getInstance() {
		if ( !self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	public function get_option( $key, $setting = null ) {
		// get setting
		$setting = $setting ? $setting : ESSENCE_SETTINGS_FIELD;

		// allow child theme to short-circuit this function
		$pre = apply_filters( 'essence_pre_get_option_' . $key, false, $setting );
		if ( false !== $pre )
			return $pre;

		// Check options cache
		if ( isset( $this->_options_cache[$setting][$key] ) ) {

			// option has been cached
			return $this->_options_cache[$setting][$key];

		}

		// check settings cache
		if ( ! isset( $this->_settings_cache[$setting] ) ) {
			// set value and cache setting
			$options = get_option($setting);
			if  ( ESSENCE_SETTINGS_FIELD == $setting ) {
				$options = wp_parse_args( $options, essence_theme_settings_defaults() );
			} elseif ( is_callable( "essence_{$setting}_defaults" ) ) {
				$options = wp_parse_args( $options, call_user_func( "essence_{$setting}_defaults" ) );
			}
			$this->_settings_cache[$setting] = $options;
		}
		// setting has been cached
		$options = apply_filters( 'essence_options', $this->_settings_cache[$setting], $setting );


		// check for non-existent option
		if ( !is_array( $options ) || !array_key_exists( $key, $options ) ) {

			// cache non-existent option
			$this->_options_cache[$setting][$key] = '';

			return '';
		}

		// cache option
		$this->_options_cache[$setting][$key] = $options[$key];

		return $this->_options_cache[$setting][$key];

	}

}

// Instantiate our class
$essence_options = Essence_Options::getInstance();


/**
 * Helper functions
 */
/**
 * @param [optional]$args See efficientRelatedPosts::getRelatedPosts
 */
function essence_get_option( $key, $setting = null ) {
	// Instantiate our class
	$essence_options = Essence_Options::getInstance();
	return $essence_options->get_option( $key, $setting );
}

function essence_option( $key, $setting = null ) {
	// Instantiate our class
	$essence_options = Essence_Options::getInstance();
	echo $essence_options->get_option( $key, $setting );
}
