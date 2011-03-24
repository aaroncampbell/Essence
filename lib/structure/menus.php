<?php

function essence_setup_menus() {
	/**
	 * @todo support secondary navigation?
	 */
	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary'	=> __( 'Primary Navigation', 'essence' ),
		'secondary'	=> __( 'Secondary Navigation', 'essence' ),
	) );
}

/** Tell WordPress to run essence_setup() when the 'after_setup_theme' hook is run. */
add_action( 'essence_setup', 'essence_setup_menus' );

function essence_do_primary_nav () {
	/**
	 * @todo add settings to let you use pages, etc here.
	 */
	/**
	 * Our navigation menu.  If one isn't filled out, wp_nav_menu
	 * falls back to wp_page_menu.  The menu assiged to the primary
	 * position is the one used.  If none is assigned, the menu with
	 * the lowest ID is used.
	 */
	wp_nav_menu( array( 'container' => '', 'theme_location' => 'primary' ) );
	wp_nav_menu( array( 'container' => 'nav', 'theme_location' => 'primary' ) );
	wp_list_pages();
	wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary' ) );
}

add_action( 'essence_primary_nav', 'essence_do_primary_nav' );

function essence_do_secondary_nav () {
	/**
	 * @todo add settings to let you use pages, etc here.
	 */
	/**
	 * Our navigation menu.  If one isn't filled out, wp_nav_menu
	 * falls back to wp_page_menu.  The menu assiged to the secondary
	 * position is the one used.  If none is assigned, the menu with
	 * the lowest ID is used.
	 */
	wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'secondary' ) );
}

add_action( 'essence_secondary_nav', 'essence_do_secondary_nav' );
