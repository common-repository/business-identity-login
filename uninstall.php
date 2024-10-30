<?php
/**
 * Uninstall Business Identity Login.
 *
 * @package BusinessIdentityLogin
 */

// If uninstall is not called from WordPress, exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// Remove all options set by the plugin.
delete_option( 'buidlo_logo_type' );
delete_option( 'buidlo_logo' );
delete_option( 'buidlo_logo_aspect_ratio' );
delete_option( 'buidlo_background_color' );
delete_option( 'buidlo_button_color' );
