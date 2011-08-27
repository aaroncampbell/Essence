<?php

function essence_setup_menus() {
	if ( essence_get_option('nav') ) {
		register_nav_menus( array(
			'primary'	=> __( 'Primary Navigation', 'essence' ),
		) );
		add_action( 'essence_primary_nav', 'essence_do_primary_nav' );
	}
	if ( essence_get_option('subnav') ) {
		register_nav_menus( array(
			'secondary'	=> __( 'Secondary Navigation', 'essence' ),
		) );
		add_action( 'essence_secondary_nav', 'essence_do_secondary_nav' );
	}
}
add_action( 'essence_setup', 'essence_setup_menus' );

function essence_do_primary_nav () {
	/**
	 * Our navigation menu.  If one isn't filled out, wp_nav_menu
	 * falls back to wp_page_menu.  The menu assiged to the primary
	 * position is the one used.  If none is assigned, the menu with
	 * the lowest ID is used.
	 */
	wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary' ) );
}

function essence_do_secondary_nav () {
	/**
	 * Our navigation menu.  If one isn't filled out, wp_nav_menu
	 * falls back to wp_page_menu.  The menu assiged to the secondary
	 * position is the one used.  If none is assigned, the menu with
	 * the lowest ID is used.
	 */
	wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'secondary' ) );
}
