<?php
/**
 * Functions for Business Identity Login plugin.
 *
 * @package BusinessIdentityLogin
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Load plugin text domain.
 */
function buidlo_load_textdomain() {
	load_plugin_textdomain( 'business-identity-login', false, dirname( plugin_basename( __FILE__ ) ) . '/../languages' );
}

/**
 * Add admin menu.
 */
function buidlo_add_admin_menu() {
	add_options_page(
		esc_html__( 'Business Identity Login Settings', 'business-identity-login' ),
		esc_html__( 'Business Identity Login', 'business-identity-login' ),
		'manage_options',
		'business-identity-login',
		'buidlo_options_page'
	);
}

/**
 * Register settings.
 */
function buidlo_settings_init() {
	register_setting( 'buidlo_settings', 'buidlo_logo_type' );
	register_setting( 'buidlo_settings', 'buidlo_logo' );
	register_setting( 'buidlo_settings', 'buidlo_logo_aspect_ratio' );
	register_setting( 'buidlo_settings', 'buidlo_background_color' );
	register_setting( 'buidlo_settings', 'buidlo_button_color' );
}

/**
 * Create options page.
 */
function buidlo_options_page() {
	$site_icon_id    = get_option( 'site_icon' );
	$site_icon_url   = $site_icon_id ? wp_get_attachment_image_url( $site_icon_id, 'full' ) : '';
	$logo_type       = get_option( 'buidlo_logo_type', 'site_icon' );
	$custom_logo_url = get_option( 'buidlo_logo', '' );
	?>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<p><?php esc_html_e( 'Customize your WordPress login page with your business identity. Choose a logo and set colors to match your brand.', 'business-identity-login' ); ?></p>
		<form action="options.php" method="post">
			<?php
			settings_fields( 'buidlo_settings' );
			do_settings_sections( 'buidlo_settings' );
			?>
			<table class="form-table">
				<tr>
					<th scope="row"><?php esc_html_e( 'Logo Type', 'business-identity-login' ); ?></th>
					<td>
						<fieldset>
							<label>
								<input type="radio" name="buidlo_logo_type" value="site_icon" <?php checked( $logo_type, 'site_icon' ); ?> <?php disabled( empty( $site_icon_url ) ); ?>>
								<?php esc_html_e( 'Use Site Icon', 'business-identity-login' ); ?>
							</label>
							<br>
							<label>
								<input type="radio" name="buidlo_logo_type" value="custom" <?php checked( $logo_type, 'custom' ); ?>>
								<?php esc_html_e( 'Use Custom Logo', 'business-identity-login' ); ?>
							</label>
						</fieldset>
						<?php if ( empty( $site_icon_url ) ) : ?>
							<p class="description">
								<?php
								printf(
									/* translators: %s: URL to the General Settings page */
									esc_html__( 'No Site Icon is currently set. You can set one in the %s.', 'business-identity-login' ),
									'<a href="' . esc_url( admin_url( 'options-general.php' ) ) . '">' . esc_html__( 'General Settings', 'business-identity-login' ) . '</a>'
								);
								?>
							</p>
						<?php endif; ?>
					</td>
				</tr>
				<tr class="buidlo-custom-logo-row" <?php echo ( 'site_icon' === $logo_type ) ? 'style="display:none;"' : ''; ?>>
					<th scope="row"><?php esc_html_e( 'Custom Logo', 'business-identity-login' ); ?></th>
					<td>
						<div class="buidlo-custom-logo-wrapper">
							<input type="hidden" name="buidlo_logo" id="buidlo-logo-input" value="<?php echo esc_attr( $custom_logo_url ); ?>">
							<div class="buidlo-custom-logo-preview">
								<?php if ( $custom_logo_url ) : ?>
									<img src="<?php echo esc_url( $custom_logo_url ); ?>" alt="Custom Logo Preview">
								<?php endif; ?>
							</div>
							<p>
								<button type="button" class="button" id="buidlo-upload-logo"><?php esc_html_e( 'Select Logo', 'business-identity-login' ); ?></button>
								<button type="button" class="button" id="buidlo-remove-logo" <?php echo empty( $custom_logo_url ) ? 'style="display:none;"' : ''; ?>><?php esc_html_e( 'Remove Logo', 'business-identity-login' ); ?></button>
							</p>
							<p class="description">
								<?php esc_html_e( 'Upload or select your company logo. This will replace the WordPress logo on the login page.', 'business-identity-login' ); ?>
								<br>
								<?php esc_html_e( 'Supported formats: JPG, PNG, GIF, SVG', 'business-identity-login' ); ?>
							</p>
						</div>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Logo Aspect Ratio', 'business-identity-login' ); ?></th>
					<td>
						<select name="buidlo_logo_aspect_ratio">
							<option value="1" <?php selected( get_option( 'buidlo_logo_aspect_ratio', '1' ), '1' ); ?>><?php esc_html_e( 'Original (1:1)', 'business-identity-login' ); ?></option>
							<option value="2" <?php selected( get_option( 'buidlo_logo_aspect_ratio', '1' ), '2' ); ?>><?php esc_html_e( 'Half Size (1:2)', 'business-identity-login' ); ?></option>
							<option value="4" <?php selected( get_option( 'buidlo_logo_aspect_ratio', '1' ), '4' ); ?>><?php esc_html_e( 'Quarter Size (1:4)', 'business-identity-login' ); ?></option>
						</select>
						<p class="description"><?php esc_html_e( 'Adjust the display size of your logo on the login page.', 'business-identity-login' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Background Color', 'business-identity-login' ); ?></th>
					<td>
						<input type="text" name="buidlo_background_color" value="<?php echo esc_attr( get_option( 'buidlo_background_color', BUIDLO_DEFAULT_BACKGROUND_COLOR ) ); ?>" class="buidlo-color-picker">
						<p class="description"><?php esc_html_e( 'Choose a background color for the login page. This color will fill the entire background.', 'business-identity-login' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Button Color', 'business-identity-login' ); ?></th>
					<td>
						<input type="text" name="buidlo_button_color" value="<?php echo esc_attr( get_option( 'buidlo_button_color', BUIDLO_DEFAULT_BUTTON_COLOR ) ); ?>" class="buidlo-color-picker">
						<p class="description"><?php esc_html_e( 'Set the color for the login button. Choose a color that contrasts well with your background color.', 'business-identity-login' ); ?></p>
					</td>
				</tr>
			</table>
			<?php submit_button(); ?>
		</form>
		<p>
			<?php esc_html_e( 'To see your changes, save the settings and visit your login page:', 'business-identity-login' ); ?>
			<a href="<?php echo esc_url( wp_login_url() ); ?>" target="_blank"><?php esc_html_e( 'View Login Page', 'business-identity-login' ); ?></a>
		</p>
	</div>
	<?php
}

/**
 * Enqueue admin scripts and styles.
 *
 * @param string $hook The current admin page.
 */
function buidlo_enqueue_admin_scripts( $hook ) {
	if ( 'settings_page_business-identity-login' !== $hook ) {
		return;
	}

	wp_enqueue_media();
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wp-color-picker' );
	wp_enqueue_style( 'buidlo-admin-styles', BUIDLO_PLUGIN_URL . 'assets/css/admin.css', array(), BUIDLO_VERSION );
	wp_enqueue_script( 'buidlo-admin-script', BUIDLO_PLUGIN_URL . 'assets/js/admin.js', array( 'jquery', 'wp-color-picker' ), BUIDLO_VERSION, true );
}

/**
 * Enqueue login styles.
 */
function buidlo_enqueue_login_styles() {
	$logo_type        = get_option( 'buidlo_logo_type', 'site_icon' );
	$logo_url         = ( 'site_icon' === $logo_type ) ? get_site_icon_url() : esc_url( get_option( 'buidlo_logo' ) );
	$background_color = esc_attr( get_option( 'buidlo_background_color', BUIDLO_DEFAULT_BACKGROUND_COLOR ) );
	$button_color     = esc_attr( get_option( 'buidlo_button_color', BUIDLO_DEFAULT_BUTTON_COLOR ) );

	// Only proceed with custom logo if one is set.
	if ( ! empty( $logo_url ) ) {
		// Get image dimensions.
		$image_size  = buidlo_get_image_size( $logo_url );
		$logo_width  = $image_size[0];
		$logo_height = $image_size[1];

		// Apply aspect ratio.
		$aspect_ratio  = intval( get_option( 'buidlo_logo_aspect_ratio', '1' ) );
		$adjusted_size = min( $logo_width, $logo_height ) / $aspect_ratio;

		$adjusted_width  = $adjusted_size;
		$adjusted_height = $adjusted_size;

		// Limit width to 320px max.
		if ( $adjusted_width > 320 ) {
			$scale_factor    = 320 / $adjusted_width;
			$adjusted_width  = 320;
			$adjusted_height = round( $adjusted_height * $scale_factor );
		}
	}
	?>
	<style>
		<?php if ( ! empty( $logo_url ) ) : ?>
		#login h1 a, .login h1 a {
			background-image: url(<?php echo esc_url( $logo_url ); ?>);
			height: <?php echo esc_attr( $adjusted_height ); ?>px;
			width: <?php echo esc_attr( $adjusted_width ); ?>px;
			max-width: 320px;
			background-size: contain;
			background-repeat: no-repeat;
			background-position: center;
		}
		<?php endif; ?>
		#login form {
			border: none !important;
		}
		#login .button-primary {
			background-color: <?php echo esc_attr( $button_color ); ?> !important;
			border-color: <?php echo esc_attr( $button_color ); ?> !important;
		}
		body.login, #wp-auth-check-wrap #wp-auth-check {
			background-color: <?php echo esc_attr( $background_color ); ?> !important;
		}
	</style>
	<?php
}

/**
 * Gets the dimensions of an image.
 *
 * @param string $url The URL of the image.
 * @return array An array containing the width and height of the image.
 */
function buidlo_get_image_size( $url ) {
	$file_path = buidlo_get_file_path_from_url( $url );
	if ( empty( $file_path ) ) {
		return array( 0, 0 );
	}

	$extension = strtolower( pathinfo( $file_path, PATHINFO_EXTENSION ) );

	if ( 'svg' === $extension ) {
		return buidlo_get_svg_size( $file_path );
	} else {
		// For PNG and other image types.
		$image_size = getimagesize( $file_path );
		if ( false === $image_size ) {
			return array( 0, 0 );
		}
		return array( $image_size[0], $image_size[1] );
	}
}

/**
 * Gets the file path from a URL.
 *
 * @param string $url The URL of the file.
 * @return string|false The file path or false if not found.
 */
function buidlo_get_file_path_from_url( $url ) {
	$upload_dir = wp_upload_dir();
	$file_path  = str_replace( $upload_dir['baseurl'], $upload_dir['basedir'], $url );

	if ( file_exists( $file_path ) ) {
		return $file_path;
	}

	// Handle site icon separately.
	if ( get_site_icon_url() === $url ) {
		$site_icon_id = get_option( 'site_icon' );
		if ( $site_icon_id ) {
			return get_attached_file( $site_icon_id );
		}
	}

	return false;
}

/**
 * Gets the dimensions of an SVG image.
 *
 * @param string $file_path The file path of the SVG image.
 * @return array An array containing the width and height of the SVG image.
 */
function buidlo_get_svg_size( $file_path ) {
	// Default size for SVG if we can't determine dimensions.
	$default_size = array( 0, 0 );

	// Initialize WP_Filesystem.
	global $wp_filesystem;
	if ( empty( $wp_filesystem ) ) {
		require_once ABSPATH . '/wp-admin/includes/file.php';
		WP_Filesystem();
	}

	// Check if file exists and is readable.
	if ( ! $wp_filesystem->exists( $file_path ) || ! $wp_filesystem->is_readable( $file_path ) ) {
		return $default_size;
	}

	$svg_content = $wp_filesystem->get_contents( $file_path );
	if ( false === $svg_content ) {
		return $default_size;
	}

	$svg = simplexml_load_string( $svg_content );
	if ( false === $svg ) {
		return $default_size;
	}

	$attributes = $svg->attributes();

	// Try to get viewBox dimensions.
	if ( isset( $attributes['viewBox'] ) ) {
		$view_box = explode( ' ', (string) $attributes['viewBox'] );
		if ( 4 === count( $view_box ) ) {
			return array( (int) $view_box[2], (int) $view_box[3] );
		}
	}

	// Try to get width and height attributes.
	if ( isset( $attributes['width'], $attributes['height'] ) ) {
		$width  = (string) $attributes['width'];
		$height = (string) $attributes['height'];

		// Remove any non-numeric characters (like 'px').
		$width  = preg_replace( '/[^0-9.]/', '', $width );
		$height = preg_replace( '/[^0-9.]/', '', $height );

		if ( is_numeric( $width ) && is_numeric( $height ) ) {
			return array( (int) $width, (int) $height );
		}
	}

	// If we couldn't determine the size, return the default.
	return $default_size;
}

/**
 * Change login header URL.
 *
 * @return string The URL for the login header link.
 */
function buidlo_login_header_url() {
	return home_url();
}

/**
 * Change login header text.
 *
 * @return string The text for the login header link.
 */
function buidlo_login_header_text() {
	return get_bloginfo( 'name' );
}

/**
 * Allow SVG upload.
 *
 * @param array $mimes Allowed mime types.
 * @return array Modified allowed mime types.
 */
function buidlo_allow_svg_upload( $mimes ) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
