<?php
/**
 * PHPUnit bootstrap file
 *
 * @package Sample_Plugin
 */

$_tests_dir = getenv( 'WP_TESTS_DIR' );

if ( ! $_tests_dir ) {
	$_tests_dir = rtrim( sys_get_temp_dir(), '/\\' ) . '/wordpress-tests-lib';
}

if ( ! file_exists( $_tests_dir . '/includes/functions.php' ) ) {
	echo "Could not find $_tests_dir/includes/functions.php, have you run bin/install-wp-tests.sh ?";
	exit( 1 );
}

// Give access to tests_add_filter() function.
require_once $_tests_dir . '/includes/functions.php';

function responsi_dir() {
	static $dir = '';
	if ( $dir === '' ) {
		if ( file_exists( WP_CONTENT_DIR . '/responsi/functions.php' ) ) {
			$dir = WP_CONTENT_DIR . '/responsi';
			echo "Found Responsi theme in content dir." . PHP_EOL;
		} elseif ( file_exists( dirname( dirname( __DIR__ ) ) . '/responsi/functions.php' ) ) {
			$dir = dirname( dirname( __DIR__ ) ) . '/responsi';
			echo "Found Responsi theme in relative dir " . dirname( dirname( __DIR__ ) ) . '/responsi' . PHP_EOL;
		} elseif ( file_exists( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) . '/responsi/functions.php' ) ) {
			$dir = dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) . '/responsi';
			echo "Found Responsi theme in relative dir " . dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) . '/responsi' . PHP_EOL;
		} elseif ( file_exists( '/tmp/wordpress/wp-content/themes/responsi/functions.php' ) ) {
			$dir = '/tmp/wordpress/wp-content/themes/responsi';
			echo "Found Responsi theme in tmp dir /tmp/wordpress/wp-content/themes/responsi" . PHP_EOL;
		} elseif ( file_exists( '/home/travis/build/themes/responsi/functions.php' ) ) {
			$dir = '/home/travis/build/responsi/responsi';
			echo "Found Responsi theme in home dir /home/travis/build/responsi/responsi" . PHP_EOL;
		} elseif ( file_exists( '/tmp/wordpress/wp-content/themes/home/travis/build/responsi/responsi/functions.php' ) ) {
			$dir = '/tmp/wordpress/wp-content/themes/home/travis/build/responsi/responsi';
			echo "Found Responsi theme in tmp dir /tmp/wordpress/wp-content/themes/home/travis/build/responsi/responsi" . PHP_EOL;
		} else {
			echo "Could not find Responsi theme." . PHP_EOL;
			exit( 1 );
		}
	}
	return $dir;
}


/**
 * Manually load the plugin being tested.
 */
function _manually_load_responsi() {
	echo esc_html( 'Loading Responsi theme' . PHP_EOL );
	require_once responsi_dir() . '/functions.php';
	update_option( 'responsi_framework_version', RESPONSI_FRAMEWORK_VERSION );
}
tests_add_filter( 'muplugins_loaded', '_manually_load_responsi' );

function _manual_install_framework() {
	echo esc_html( 'Installing Responsi Themes ...' . PHP_EOL );
}
tests_add_filter( 'setup_theme', '_manual_install_framework' );

// Start up the WP testing environment.
require $_tests_dir . '/includes/bootstrap.php';
