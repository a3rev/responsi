<?php
/**
 * Responsi_Theme_Privacy class.
 */

defined( 'ABSPATH' ) || exit;


class Responsi_Theme_Privacy {

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

		$suggested_text =  '<strong class="privacy-policy-tutorial">' . __( 'Suggested text:', 'responsi' ) . ' </strong>';
		
		$content = '
			<div class="wp-suggested-text">'.
				'<p class="privacy-policy-tutorial">' . __( 'Responsi Theme Framework uses fonts from <a href="https://fonts.google.com/" target="_blank" rel="noopener">google fonts</a>, you should list in privacy page.', 'responsi' ) . '</p>' .
				'<p>' . $suggested_text .__( 'Links on this site may use Google fonts. Google may collect data about you, use cookies, IP, embed additional third-party tracking.', 'responsi' ).'</p>'.
				'<p>' . __( 'Please see the <a href="https://policies.google.com/privacy/" target="_blank" rel="noopener">Google Privacy Policy</a> for more details.', 'responsi' ) . '</p>'.
			'</div>';
		
		return apply_filters( 'responsi_privacy_policy_content', $content );
	}
	
}

new Responsi_Theme_Privacy();