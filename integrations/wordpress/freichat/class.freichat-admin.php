<?php

class FreiChat_Admin {

	public static function plugin_activation() {
		$data = generateToken();

		if ($data['error'] == null) {
			update_option("freichat_token", $data['key']);
		} else {
			update_option("freichat_token_error", $data['error']);
		}
	}

	public static function init() {
		add_action( 'admin_menu', array( 'FreiChat_Admin', 'freichat_settings' ) );
		add_action( 'admin_init', array( 'FreiChat_Admin', 'page_init' ) );
	}

	public static function freichat_settings() {
		add_options_page( 'FreiChat', 'FreiChat', 'manage_options', 'freichat-settings', array(
			'FreiChat_Admin',
			'display_page'
		) );
	}

	/**
	 * Register and add settings
	 */
	public static function page_init() {
		register_setting(
			'freichat', // Option group
			'freichat_token', // Option name
			array()
		);
		register_setting(
			'freichat', // Option group
			'freichat_domain', // Option name
			array()
		);

		add_settings_section(
			'freichat_settings_section',
			__( 'FreiChat Settings', 'freichat' ),
			array( 'FreiChat_Admin', 'section_callback' ),
			'freichat-settings'
		);

		add_settings_field(
			'token',
			'Token',
			array( 'FreiChat_Admin', 'token_callback' ),
			'freichat-settings',
			'freichat_settings_section'
		);

		add_settings_field(
			'domain',
			'Chat Domain',
			array( 'FreiChat_Admin', 'domain_callback' ),
			'freichat-settings',
			'freichat_settings_section'
		);

	}

	public static function section_callback() {
		// echo __( 'FreiChat Settings', 'freichat' );
	}

	public static function token_callback() {
		$token = get_option( 'freichat_token' );

		printf(
			'<input type="text" id="token" name="freichat_token" value="%s" placeholder="%s"/>',
			$token ? esc_attr( $token ) : '',
			__( "Please deactivate and activate plugin again if token is empty", "freichat" )
		);

		echo '<p class="description">(Token used for secure communication with freichat servers. Please do not edit/change it.)</p>';
	}

	public static function domain_callback() {
		$token = get_option( 'freichat_domain' );

		printf(
			'<input type="text" id="domain" name="freichat_domain" value="%s" placeholder="%s"/>',
			$token ? esc_attr( $token ) : '',
			__( "[OPTIONAL] https://chat.your_domain.com", "freichat" )
		);

		echo '<p class="description">(If you have a domain that redirects to nodelb.freichat.com, you can enter that here)</p>';
	}


	public static function display_page() {
		?>
        <form action='options.php' method='post'>

			<?php
			settings_fields( 'freichat' );
			do_settings_sections( 'freichat-settings' );
			submit_button();
			?>

        </form>
		<?php
	}
}