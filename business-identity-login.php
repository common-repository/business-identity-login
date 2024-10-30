<?php
/**
 * Plugin Name: Business Identity Login
 * Plugin URI: https://whitespace.se/business-identity-login
 * Description: Customizes the WordPress login page with your business identity, including a custom logo and color scheme.
 * Version: 1.0.0
 * Author: Whitespace AB
 * Author URI: https://whitespace.se
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: business-identity-login
 * Domain Path: /languages
 *
 * @package BusinessIdentityLogin
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Define plugin constants.
if ( ! defined( 'BUIDLO_VERSION' ) ) {
	define( 'BUIDLO_VERSION', '1.0.0' );
}
define( 'BUIDLO_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'BUIDLO_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'BUIDLO_DEFAULT_BACKGROUND_COLOR', '#ECECE7' );
define( 'BUIDLO_DEFAULT_BUTTON_COLOR', '#005E83' );

// Include the main plugin functions.
require_once BUIDLO_PLUGIN_DIR . 'includes/functions.php';

// Load plugin text domain.
add_action( 'plugins_loaded', 'buidlo_load_textdomain' );

// Add admin menu.
add_action( 'admin_menu', 'buidlo_add_admin_menu' );

// Register settings.
add_action( 'admin_init', 'buidlo_settings_init' );

// Enqueue admin scripts and styles.
add_action( 'admin_enqueue_scripts', 'buidlo_enqueue_admin_scripts' );

// Enqueue login styles.
add_action( 'login_enqueue_scripts', 'buidlo_enqueue_login_styles' );

// Change login header URL.
add_filter( 'login_headerurl', 'buidlo_login_header_url' );

// Change login header text.
add_filter( 'login_headertext', 'buidlo_login_header_text' );

// Allow SVG upload.
add_filter( 'upload_mimes', 'buidlo_allow_svg_upload' );
