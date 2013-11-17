<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/*
 *	Add Admin Submenu Page
 */
function ypi_register_menu_page() {
	add_options_page(
		'YouTube Play Icon',		// Title
		'YouTube Play Icon',		// Menu Text
		'manage_options',			// User Access Level
		'ypi_options',				// Unique ID
		'ypi_plugin_admin_template'	// Callback Function
		);
}
add_action( 'admin_menu', 'ypi_register_menu_page' );

/*
 *	Display the Plugin Admin Page
 */
function ypi_plugin_admin_template() {
     if( !current_user_can('manage_options' ) ) {
          wp_die(__('You do not have sufficient permissions to access this page.'));
     }
?>
     <div class="wrap">
	     <h2>YouTube Play Icon Settings</h2>
	     <form method="post" action="options.php">
	          <?php settings_fields( 'ypi_options' ); ?>
	          <?php do_settings_sections( 'ypi_options' ); ?>
	          <?php submit_button(); ?>
	     </form>
     </div><!-- .wrap -->
<?php
}

function ypi_initialize_admin_settings() {
	if ( false == get_option( 'ypi_options' ) ) {
		ypi_activate();
	}

	add_settings_section(
	     'ypi_settings_section_pause',
	     'Pause Icon',
	     '',
	     'ypi_options'
	);

	add_settings_field(
	     'ypi_pause_icon',
	     'Display pause icon when video is paused',
	     'ypi_pause_icon_display',
	     'ypi_options',
	     'ypi_settings_section_pause'
	);

	add_settings_section(
	     'ypi_settings_section',
	     'Disable plugin on:',
	     '',
	     'ypi_options'
	);

	add_settings_field(
	     'ypi_disable_pages',
	     'All Pages',
	     'ypi_disable_pages_display',
	     'ypi_options',
	     'ypi_settings_section'
	);

	add_settings_field(
	     'ypi_disable_posts',
	     'All Posts',
	     'ypi_disable_posts_display',
	     'ypi_options',
	     'ypi_settings_section'
	);

	add_settings_field(
	     'ypi_disable_front_page',
	     'Front Page',
	     'ypi_disable_front_page_display',
	     'ypi_options',
	     'ypi_settings_section'
	);

	add_settings_field(
	     'ypi_disable_home_page',
	     'Home Page / Posts Page',
	     'ypi_disable_home_page_display',
	     'ypi_options',
	     'ypi_settings_section'
	);

	add_settings_field(
	     'ypi_disable_sticky',
	     'Sticky Posts',
	     'ypi_disable_sticky_display',
	     'ypi_options',
	     'ypi_settings_section'
	);

	register_setting(
		'ypi_options',
		'ypi_options'
	);
}
add_action( 'admin_init', 'ypi_initialize_admin_settings' );

/*
 *	Settings API Callbacks
 */
function ypi_pause_icon_display( $args ) {
	$options = get_option( 'ypi_options' );
	$value = isset( $options[ 'ypi_pause_icon' ] ) ?
		$options[ 'ypi_pause_icon' ] : '';
	//$html = '<input type="text" id="ypi_pause_icon" name="ypi_options[ypi_pause_icon]" value="' . $value . '"/>';
	$html = '<input type="checkbox" id="ypi_pause_icon" name="ypi_options[ypi_pause_icon]" value="on"' . checked($value, "on", false) . '/>';
	echo $html;
}

function ypi_disable_pages_display( $args ) {
	$options = get_option( 'ypi_options' );
	$value = isset( $options[ 'ypi_disable_pages' ] ) ?
		$options[ 'ypi_disable_pages' ] : '';
	$html = '<input type="checkbox" id="ypi_disable_pages" name="ypi_options[ypi_disable_pages]" value="on"' . checked($value, "on", false) . '/>';
	echo $html;
}

function ypi_disable_posts_display( $args ) {
	$options = get_option( 'ypi_options' );
	$value = isset( $options[ 'ypi_disable_posts' ] ) ?
		$options[ 'ypi_disable_posts' ] : '';
	$html = '<input type="checkbox" id="ypi_disable_posts" name="ypi_options[ypi_disable_posts]" value="on"' . checked($value, "on", false) . '/>';
	echo $html;
}

function ypi_disable_front_page_display( $args ) {
	$options = get_option( 'ypi_options' );
	$value = isset( $options[ 'ypi_disable_front_page' ] ) ?
		$options[ 'ypi_disable_front_page' ] : '';
	$html = '<input type="checkbox" id="ypi_disable_front_page" name="ypi_options[ypi_disable_front_page]" value="on"' . checked($value, "on", false) . '/>';
	echo $html;
}

function ypi_disable_home_page_display( $args ) {
	$options = get_option( 'ypi_options' );
	$value = isset( $options[ 'ypi_disable_home_page' ] ) ?
		$options[ 'ypi_disable_home_page' ] : '';
	$html = '<input type="checkbox" id="ypi_disable_home_page" name="ypi_options[ypi_disable_home_page]" value="on"' . checked($value, "on", false) . '/>';
	echo $html;
}

function ypi_disable_sticky_display( $args ) {
	$options = get_option( 'ypi_options' );
	$value = isset( $options[ 'ypi_disable_sticky' ] ) ?
		$options[ 'ypi_disable_sticky' ] : '';
	$html = '<input type="checkbox" id="ypi_disable_sticky" name="ypi_options[ypi_disable_sticky]" value="on"' . checked($value, "on", false) . '/>';
	echo $html;
}