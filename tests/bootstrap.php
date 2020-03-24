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

/**
 * Manually load the plugin being tested.
 */
function _manually_load_responsi() {
	require dirname( dirname( __FILE__ ) ) . '/functions.php';
	update_option( 'responsi_framework_version', RESPONSI_FRAMEWORK_VERSION );
}
tests_add_filter( 'setup_theme', '_manually_load_responsi' );

function _manual_install_framework() {
	echo esc_html( 'Installing Responsi Themes ...' . PHP_EOL );
}
tests_add_filter( 'setup_theme', '_manual_install_framework' );

// Start up the WP testing environment.
require $_tests_dir . '/includes/bootstrap.php';
