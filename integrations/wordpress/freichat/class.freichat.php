<?php

class FreiChat {

	public static function init() {
		$token   = get_option( 'freichat_token' );
		$domain  = get_option( 'freichat_domain' );
		$baseUrl = get_option( 'freichat_base_url' );

		if ( ! empty( $token ) && is_user_logged_in() ) {
			$user   = wp_get_current_user();
			$id     = $user->get( 'ID' );
			$name   = base64_encode( $user->get( 'display_name' ) );
			$avatar = base64_encode( get_avatar_url( $id ) );
			$pubKey = explode( "$$", $token )[0];
			$change = date( 'Ymd' );

			?>
            <script type="text/javascript">
				<?php
				if (! empty( $domain )) {
				?>
                window.FreiChatClient = {
                    baseUrl: `<?php echo $domain; ?>`
                };
				<?php
				}
				?>
                import('<?php echo "$baseUrl/v1/freichat-float.js?pubKey=$pubKey&userId=$id&displayName=$name&displayImage=$avatar&change=$change"; ?>');
            </script>

			<?php
		}
	}
}