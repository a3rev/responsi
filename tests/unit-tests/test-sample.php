<?php
/**
 * Class SampleTest
 *
 * @package Sample_Plugin
 */

/**
 * Sample test case.
 */
class a3Rev_Tests_ResponiFramework extends WP_UnitTestCase {

	/**
	 * A single example test.
	 */
	function test_sample() {
		
		$output = 1;
		$this->assertEquals( 1 , $output );

	}

	function test_responsi_exclude_button_css() {
		
		$output = responsi_exclude_button_css();
		$this->assertStringContainsString( '.customize-partial-edit-shortcut-button' , $output );

	}

	function test_responsi_build_dynamic_css() {
		
		$output = responsi_build_dynamic_css();
		$this->assertStringContainsString( '.mobile-view #wrap' , $output );

	}

	function test_responsi_register_webfonts() {
		
		$output = responsi_register_webfonts();
		$this->assertStringContainsString( 'fonts.googleapis.com' , $output );

	}

}
