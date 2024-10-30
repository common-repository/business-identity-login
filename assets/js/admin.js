/**
 * Business Identity Login admin JavaScript.
 *
 * Handles functionality for the plugin's admin settings page.
 *
 * @package BusinessIdentityLogin
 */

jQuery( document ).ready(
	function ($) {
		// Initialize color pickers.
		$( ".buidlo-color-picker" ).wpColorPicker();

		// Handle logo type selection.
		$( 'input[name="buidlo_logo_type"]' ).change(
			function () {
				if ($( this ).val() === "custom") {
					$( ".buidlo-custom-logo-row" ).show();
				} else {
					$( ".buidlo-custom-logo-row" ).hide();
				}
			}
		);

		// Handle logo upload.
		$( "#buidlo-upload-logo" ).click(
			function (e) {
				e.preventDefault();

				var custom_uploader = wp
				.media(
					{
						title: "Select Logo",
						button: {
							text: "Use this image",
						},
						multiple: false,
					}
				)
				.on(
					"select",
					function () {
						var attachment = custom_uploader
						.state()
						.get( "selection" )
						.first()
						.toJSON();
						$( "#buidlo-logo-input" ).val( attachment.url );
						$( ".buidlo-custom-logo-preview" ).html(
							'<img src="' +
							attachment.url +
							'" alt="Custom Logo Preview">'
						);
						$( "#buidlo-remove-logo" ).show();
					}
				)
				.open();
			}
		);

		// Handle logo removal.
		$( "#buidlo-remove-logo" ).click(
			function (e) {
				e.preventDefault();
				$( "#buidlo-logo-input" ).val( "" );
				$( ".buidlo-custom-logo-preview" ).html( "" );
				$( this ).hide();
			}
		);

		// Show/hide custom logo row based on initial logo type selection.
		if ($( 'input[name="buidlo_logo_type"]:checked' ).val() === "custom") {
			$( ".buidlo-custom-logo-row" ).show();
		} else {
			$( ".buidlo-custom-logo-row" ).hide();
		}

		// Show/hide remove logo button based on initial logo value.
		if ($( "#buidlo-logo-input" ).val()) {
			$( "#buidlo-remove-logo" ).show();
		} else {
			$( "#buidlo-remove-logo" ).hide();
		}
	}
);
