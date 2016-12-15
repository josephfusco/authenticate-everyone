<?php
/**
 * Plugin Name:    Authenticate Everyone
 * Plugin URI:     https://github.com/josephfusco/authenticate-everyone
 * Description:    Skip user authentication and make everyone admin - intended for local development.
 * Version:        1.0
 * Author:         Joseph Fusco
 * Author URI:     http://josephfus.co/
 * License:        GPLv2 or later
 * License URI:    http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Based off of https://wordpress.org/plugins/no-login/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wp_validate_auth_cookie' ) ) :
/**
 * Validate cookie for everyone.
 *
 * @since  1.0
 */
function wp_validate_auth_cookie() {
	return 1;
}
endif;

/**
 * Set transient for plugin activation warning.
 *
 * @since  1.0
 */
function wpae_set_warning_transient() {
	set_transient( 'wpae-activation-warning', true, 5 );
}
register_activation_hook( __FILE__, 'wpae_set_warning_transient' );

/**
 * Admin warning.
 *
 * @since  1.0
 */
function wpae_activation_warning() {
	if ( get_transient( 'wpae-activation-warning' ) ) {
		?>
		<div class="notice notice-warning is-dismissible">
			<p>All visitors to this site will now automatically be logged in as admin!</p>
		</div>
		<?php
		delete_transient( 'wpae-activation-warning' );
	}
}
add_action( 'admin_notices', 'wpae_activation_warning' );
