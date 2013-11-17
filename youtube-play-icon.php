<?php
/**
 * Plugin Name: YouTube Play Icon
 * Plugin URI: n/a
 * Description: Displays a play icon in the browser tab/title bar when playing embedded YouTube videos
 * Version: 1.0
 * Author: Kellen Mace
 * Author URI: https://twitter.com/KellenMace
 * License: http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

/*
 *	Activate Plugin
 */
function ypi_activate() {
	$options = array(
		'ypi_pause_icon'			=> '',
	    'ypi_disable_pages' 		=> '',
	    'ypi_disable_posts' 		=> '',
	    'ypi_disable_front_page' 	=> '',
	    'ypi_disable_home_page' 	=> '',
	    'ypi_disable_sticky' 		=> ''
	);
	add_option( 'ypi_options', $options );
}
register_activation_hook( __FILE__, 'ypi_activate' );

/*
 *	Initialize Plugin
 */
function ypi_initialize() {
	
	// Don't run scripts in dashboard, search pages, or archive pages
	if ( !is_admin() && !is_search() && !is_archive() ) {
		$options = get_option( 'ypi_options' );
		
		// Run scripts on front page, and all pages unless disabled
		if ( is_page()  && !$options[ 'ypi_disable_pages' ] ) {
			if ( is_front_page() && !$options[ 'ypi_disable_front_page' ] )
				ypi_enqueue_scripts();
			elseif ( !is_front_page() )
				ypi_enqueue_scripts();
		}

		// Run scripts on front page, home page, sticky post pages, and all posts unless disabled
		elseif ( is_single() && !$options[ 'ypi_disable_posts' ] ) {
			if ( is_front_page() && !$options[ 'ypi_disable_front_page' ] )
				ypi_enqueue_scripts();
			elseif ( is_home() && !$options[ 'ypi_disable_home_page' ] )
				ypi_enqueue_scripts();
			elseif ( is_sticky() && !$options[ 'ypi_disable_sticky' ] )
				ypi_enqueue_scripts();
			elseif ( !is_front_page() && !is_home() && !is_sticky() )
				ypi_enqueue_scripts();
		}
	}
}
add_action('wp_enqueue_scripts', 'ypi_initialize');

function ypi_enqueue_scripts() {
	
	// Enqueue scripts
	wp_enqueue_script('ypi-scripts', plugin_dir_url( __FILE__ ) . 'js/ypi-scripts.js');

	// Send user's preference to show or not to show pause icon to javascript file as a JS object
	$options = get_option( 'ypi_options' );
	$ypi_pause_icon = isset( $options[ 'ypi_pause_icon' ] ) ?
		$options[ 'ypi_pause_icon' ] : '';
	wp_localize_script( 'ypi-scripts', 'ypi_pause_icon', $ypi_pause_icon );

	// Enqueue YouTube IFrame API
	wp_enqueue_script('ypi-youtube-api', 'https://www.youtube.com/iframe_api');
}

// Include admin submenu entry and plugin admin page
include_once( plugin_dir_path( __FILE__ ) . 'includes/ypi-admin.php' );