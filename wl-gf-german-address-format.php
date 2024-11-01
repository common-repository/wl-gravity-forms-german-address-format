<?php
/*
Plugin Name: WL Gravity Forms - German Address Format
Description: This Plugin changes the order of the city and the zip code for the german address format
Version: 1.0.3
Author: Weslink
Author URI: https://weslink.de
License: GPL V3

*/

define( 'WL_GFGAF_PLUGIN_VERSION', '1.0.3' );
define( 'WL_GFGAF_PLUGIN_DIR', __DIR__);
define( 'WL_GFGAF_PLUGIN_URI', plugins_url( '', __FILE__ ) );
define( 'WL_GFGAF_PLUGIN_NAME', 'wl gf german address format' );



/**
 * Adds a well formatted link on the plugin page
 */
function wl_gfgaf_plugin_add_plugin_links($links, $file) {
	if ( $file == plugin_basename(__DIR__ .'/wl-gf-german-address-format.php') ) {
		$links[] = '<a href="https://weslink.de/">' . esc_html__("Proudly presented by WESLINK _ Let's Web | Site Shop App", 'wl') . '</a>';
	}
	return $links;
}

/**
 * Changes the order of Gravity Forms address fields
 */

function address_format( $format ) {
	return 'zip_before_city';
}

/**
 * Adds the shortcode for the usage in the editor
 */
function wl_gfgaf_plugin_init() {

	// Load the filter for gravity forms
	add_filter( 'gform_address_display_format', 'address_format' );

	// add some links on the plugin page
	add_filter('plugin_row_meta', 'wl_gfgaf_plugin_add_plugin_links', 10, 2);

	// add action for multiplanguage
	add_action( 'plugins_loaded', 'wl_gfgaf_load_textdomain' );

}
add_action( 'init', 'wl_gfgaf_plugin_init' );



/**
 * Load plugin textdomain.
 *
 */
function wl_gfgaf_load_textdomain() {
	load_plugin_textdomain( 'wl-gf-german-address-format', false, basename(__DIR__) . '/languages' );
}


/**
 * First action on activation of the plugin
 */
function wl_gfgaf_plugin_activation() {

	global $wp_version;

	$php = '5.3';
	$wp  = '3.8';

	if ( version_compare( PHP_VERSION, $php, '<' ) ) {
		deactivate_plugins( basename( __FILE__ ) );
		wp_die(
			'<p>' .
			sprintf(
				__( 'This Plugin requires PHP %1$s. Please contact your hoster.', 'wl' ),
				$php
			)
			. '</p> <a href="' . admin_url( 'plugins.php' ) . '">' . __( 'Go Back', 'wl' ) . '</a>'
		);
	}

	if ( version_compare( $wp_version, $wp, '<' ) ) {
		deactivate_plugins( basename( __FILE__ ) );
		wp_die(
			'<p>' .
			sprintf(
				__( 'This plugin requires WordPress %1$s, please update your WordPress.', 'wl' ),
				$php
			)
			. '</p> <a href="' . admin_url( 'plugins.php' ) . '">' . __( 'Go Back', 'wl' ) . '</a>'
		);
	}

}
register_activation_hook( __FILE__, 'wl_gfgaf_plugin_activation' );



