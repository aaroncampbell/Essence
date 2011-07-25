<?php
add_action( 'admin_menu', 'essence_admin_menu_setup' );
function essence_admin_menu_setup() {
	add_theme_page( __( 'Settings', 'essence' ), __( 'Settings', 'essence' ), 'edit_theme_options', 'essence-settings', 'essence_theme_admin_settings' );
}

add_action( 'admin_print_styles-appearance_page_essence-settings', 'essence_admin_page_styles' );
function essence_admin_page_styles() {
	wp_enqueue_style( 'dashboard' );
	wp_enqueue_style( 'essence-options-css', ESSENCE_ADMIN_URL . '/essence-admin.css' );
}

add_action( 'admin_print_scripts-appearance_page_essence-settings', 'essence_admin_page_scripts' );
function essence_admin_page_scripts() {
	wp_enqueue_script( 'postbox' );
	wp_enqueue_script( 'dashboard' );
}

function essence_screen_icon_link( $name = 'essence' ) {
	$link = '<a href="http://essencetheme.com">';
	if ( function_exists( 'get_screen_icon' ) ) {
		$link .= get_screen_icon( $name );
	} else {
		ob_start();
		screen_icon( $name );
		$link .= ob_get_clean();
	}
	$link .= '</a>';
	echo apply_filters( 'essence-screen-icon-link', $link, $name );
}
