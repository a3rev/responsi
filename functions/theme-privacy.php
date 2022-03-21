<?php

namespace A3Rev\Responsi;

/**
 * Responsi_Theme_Privacy class.
 */

defined( 'ABSPATH' ) || exit;


class Privacy {

	public $name = 'Responsi Theme Framework';
	
	public function __construct() {
		add_action( 'admin_init', array( $this, 'add_privacy_message' ), 2 );
	}

	public function add_privacy_message() {
		if ( function_exists( 'wp_add_privacy_policy_content' ) ) {
			wp_add_privacy_policy_content( $this->name, $this->get_privacy_message() );
		}
	}

	public function get_privacy_message() {

		$suggested_text = '<strong class="privacy-policy-tutorial">' . __( 'Suggested text:', 'responsi' ) . ' </strong>';
		$ggFonts_url  	= 'https://fonts.google.com/';
		$policies_url 	= 'https://policies.google.com/privacy/';

		$content = '
		<div class="wp-suggested-text">
			<p class="privacy-policy-tutorial">' . sprintf( __( 'Responsi Theme Framework uses fonts from <a href="%s" target="_blank" rel="noopener">google fonts</a>, you should list in privacy page.', 'responsi' ), $ggFonts_url ) . '</p>
			<p>' . sprintf( '%s'. __( 'Links on this site may use Google fonts. Google may collect data about you, use cookies, IP, embed additional third-party tracking.', 'responsi' ), $suggested_text ) .'</p>
			<p>' . sprintf( __( 'Please see the <a href="%s" target="_blank" rel="noopener">Google Privacy Policy</a> for more details.', 'responsi' ), $policies_url ) . '</p>
		</div>';
		
		return apply_filters( 'responsi_privacy_policy_content', $content );
	}
	
}
