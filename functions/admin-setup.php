<?php
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;

/*-----------------------------------------------------------------------------------*/
/* responsi_framework_upgrade_version */
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'responsi_framework_upgrade_version' ) ){

	function responsi_framework_upgrade_version(){
	    
	    if( version_compare(get_option('responsi_framework_version'), '6.9.4', '<') ){
	        
	        if( get_theme_mods() != false && get_option( 'responsi_framework_version' ) != false ){
	            $version = str_replace('.', '_', get_option( 'responsi_framework_version' ));
	            $theme = get_option( 'stylesheet' );
	            update_option( 'theme_mods_'.$theme.'_'.$version.'_backup', get_theme_mods() );
	        }

	        if( function_exists('responsi_framework_upgrade') ){
	        	responsi_framework_upgrade();
	        }

	        if( function_exists('responsi_dynamic_css') ){
		        responsi_dynamic_css( 'framework' );
		    }
	    }

	    update_option( 'responsi_framework_version', RESPONSI_FRAMEWORK_VERSION );
	}
}

add_action( 'after_setup_theme', 'responsi_framework_upgrade_version', 9 );

/*-----------------------------------------------------------------------------------*/
/* responsi_setup */
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'responsi_setup' ) ){
	function responsi_setup(){

		/*-----------------------------------------------------------------------------------*/
		/* load_theme_textdomain */
		/*-----------------------------------------------------------------------------------*/

		$locale = apply_filters( 'theme_locale', get_locale(), 'responsi' );
	    load_textdomain( 'responsi', WP_LANG_DIR . '/responsi/responsi-' . $locale . '.mo' );
	    load_theme_textdomain( 'responsi', get_template_directory() . '/languages/' );

		/*-----------------------------------------------------------------------------------*/
		/* Add Theme Support */
		/*-----------------------------------------------------------------------------------*/

	    add_theme_support( 'woocommerce' );

	    add_theme_support( 'woocommerce', array(
		    // Product grid theme settings
		    'product_grid'          => array(
		        'default_rows'    => 1,
		        'min_rows'        => 1,
		        'max_rows'        => '',
		        'default_columns' => 1,
		        'min_columns'     => 1,
		        'max_columns'     => 6,
		    ),
		) );

	    add_theme_support( 'title-tag' );

	    register_nav_menus( array(
	        'primary-menu' => __( 'Primary Menu', 'responsi' )
	    ));

	    add_theme_support( 'html5', array(
	        'comment-list',
	        'comment-form',
	        'search-form',
	        'gallery',
	        'caption'
	    ));

	    add_theme_support( 'custom-logo' );
	    add_theme_support( 'post-thumbnails' );
	    add_theme_support( 'automatic-feed-links' );
	    add_theme_support( 'customize-selective-refresh-widgets' );
		add_editor_style();
	}
}

add_action( 'after_setup_theme', 'responsi_setup' );

/*-----------------------------------------------------------------------------------*/
/* responsi_after_setup_theme */
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'responsi_after_setup_theme' ) ){
	function responsi_after_setup_theme(){
		do_action( 'responsi_after_setup_theme' );
	}
}

/*-----------------------------------------------------------------------------------*/
/* responsi_build_css_theme_actived() */
/*-----------------------------------------------------------------------------------*/

function responsi_build_css_theme_actived(){
	responsi_dynamic_css( 'framework' );
}

add_action( 'responsi_after_setup_theme', 'responsi_build_css_theme_actived', 10 );

global $pagenow;

if ( is_admin() && isset( $_GET['activated'] ) && ( true === $_GET['activated']  ) && ( 'themes.php' === $pagenow  ) ){

	// Call action that sets.
	add_action( 'after_setup_theme', 'responsi_after_setup_theme' );

	// Custom action for theme-setup (redirect is at priority 10).
	do_action( 'responsi_theme_activate' );
}

?>