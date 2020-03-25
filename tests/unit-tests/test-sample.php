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

	function setUp() {
		parent::setUp();
		$this->theme_root = DIR_TESTDATA . '/themedir1';

		$this->orig_theme_dir = $GLOBALS['wp_theme_directories'];

		// /themes is necessary as theme.php functions assume /themes is the root if there is only one root.
		$GLOBALS['wp_theme_directories'] = array( WP_CONTENT_DIR . '/themes', $this->theme_root );

		add_filter('theme_root', array(&$this, '_theme_root'));
		add_filter( 'stylesheet_root', array(&$this, '_theme_root') );
		add_filter( 'template_root', array(&$this, '_theme_root') );
		// clear caches
		wp_clean_themes_cache();
		unset( $GLOBALS['wp_themes'] );
	}

	function tearDown() {
		$GLOBALS['wp_theme_directories'] = $this->orig_theme_dir;
		remove_filter('theme_root', array(&$this, '_theme_root'));
		remove_filter( 'stylesheet_root', array(&$this, '_theme_root') );
		remove_filter( 'template_root', array(&$this, '_theme_root') );
		wp_clean_themes_cache();
		unset( $GLOBALS['wp_themes'] );
		parent::tearDown();
	}

	// replace the normal theme root dir with our premade test dir
	function _theme_root($dir) {
		return $this->theme_root;
	}

	function test_theme_responsi() {
		$theme = get_theme('Responsi');

		$this->assertFalse( empty($theme) );

		$this->assertEquals( 'Responsi', $theme['Name'] );
		$this->assertEquals( 'Responsi', $theme['Title'] );
		$this->assertEquals( 'WordPress Designers have been calling for it and at last it is here - a lightweight Framework that sits on top of core WordPress to make every aspect of WordPress theme design completely customizable with instant live preview. Install and activate Responsi Framework and it opens the WordPress Customizer menu with its 700+ site layout and style options. Sick of searching for a WordPress Theme that fits all of your projects requirements? The fully customizable and extendable Responsi Framework is your answer. Are you a designer not a coder? Responsi Framework is for you. The customizer allows you to see every change live as it is made in the customizer preview screen.  The customizer menu has been sorted logically into all elements of a WordPress site e.g. Site Structure, Header, Nav Bars, Site Body, Pages, Blog Posts, Blog Cards, Footer Widgets, Footer, to make creating and editing site layout and style a simple process. Responsi Framework empowers everyone regardless of skill level or experience to create a unique hand crafted WordPress theme for their site. Built in cross platform code with mobile first focus means you never have to worry about your design breaking in tablet or mobile, your handcrafted theme design will always show perfectly in any browser. Responsi Framework changes the way that we think about WordPress Themes. The Framework is endlessly extendable with a built in ecosystem of Free and Premium Responsi Plugins that add advanced features to the Framework (see Responsi Plugins menu in the WordPress Appearance menu). The Responsi Themes menu has Responsi Starter Child themes for those looking for some design starter inspiration. Or just add content and launch your fully mobile responsive site right away.', $theme['Description'] );
		$this->assertEquals( '<a href="http://a3rev.com/">a3THEMES</a>', $theme['Author'] );
		$this->assertEquals( '7.8.0', $theme['Version'] );
		$this->assertEquals( 'responsi', $theme['Template'] );
		$this->assertEquals( 'responsi', $theme['Stylesheet'] );
		$this->assertEquals( $this->theme_root.'/responsi/functions.php', reset($theme['Template Files']) );
		$this->assertEquals( $this->theme_root.'/responsi/index.php', next($theme['Template Files']) );

		$this->assertEquals( $this->theme_root.'/responsi/style.css', reset($theme['Stylesheet Files']) );

		$this->assertEquals( $this->theme_root.'/responsi', $theme['Template Dir'] );
		$this->assertEquals( $this->theme_root.'/responsi', $theme['Stylesheet Dir'] );
		$this->assertEquals( 'publish', $theme['Status'] );
		$this->assertEquals( '', $theme['Parent Theme'] );
	}

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

	/*function test_responsi_build_dynamic_css() {
		
		$output = responsi_build_dynamic_css();
		$this->assertStringContainsString( '.mobile-view #wrap' , $output );

	}

	function test_responsi_register_webfonts() {
		
		$output = responsi_register_webfonts();
		$this->assertStringContainsString( 'fonts.googleapis.com' , $output );

	}*/

}
