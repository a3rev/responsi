<?php
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'init', 'responsi_clear_version_cached' );
function responsi_clear_version_cached() {
	if ( isset( $_POST['rf_clear_version_cached'] ) && 1 === $_POST['rf_clear_version_cached'] ) {
		delete_transient( 'a3_responsi_parent_theme_update_info' );
		delete_option( '_site_transient_update_themes' );
		delete_option( '_site_transient_update_plugins' );
		delete_transient( 'a3_responsi_all_child_themes_info' );
		delete_transient( 'a3_responsi_all_addon_free_info' );
	}
}

/*-----------------------------------------------------------------------------------*/
/* Theme Register Styles */
/*-----------------------------------------------------------------------------------*/

function responsi_register_styles( $styles ){
	global $responsi_version;
	$suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
	$group_styles = array();
    $styles->add( 'responsi-custom-fields', get_template_directory_uri() . '/functions/css/custom-fields'.$suffix.'.css', array(), $responsi_version, 'screen' );
    $styles->add( 'responsi-icon', get_template_directory_uri() . '/functions/css/responsi-icon'.$suffix.'.css', array(), $responsi_version, 'screen' );
    $styles->add( 'responsi-font-face', get_template_directory_uri() . '/functions/css/responsi-font-face' . $suffix . '.css', $group_styles, $responsi_version, 'screen' );
    $styles->add( 'responsi-layout', get_template_directory_uri() . '/functions/css/layout' . $suffix . '.css', array( 'responsi-font-face' ), $responsi_version, 'screen' );
    $styles->add( 'responsi-framework', get_template_directory_uri() . '/style.css', array( 'responsi-layout' ), $responsi_version, 'screen' );
    if( is_child_theme() ){
	    $styles->add( 'responsi-theme', get_bloginfo('stylesheet_url'), array( 'responsi-framework' ), $responsi_version, 'screen' );
	}
}

add_action( 'wp_default_styles', 'responsi_register_styles', 11 );

/*-----------------------------------------------------------------------------------*/
/* Theme Enqueue Google Fonts */
/*-----------------------------------------------------------------------------------*/

add_action( 'wp_head', 'responsi_register_webfonts', 0 );

/*-----------------------------------------------------------------------------------*/
/* Theme responsi_rm_minify_css */
/*-----------------------------------------------------------------------------------*/

function responsi_rm_minify_css(){
	echo '<!-- RM-Minify CSS -->';
}

add_action( 'wp_print_styles', 'responsi_rm_minify_css', 2 );

/*-----------------------------------------------------------------------------------*/
/* Theme Enqueue Styles */
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'responsi_load_styles' ) ){
    function responsi_load_styles(){
    	wp_enqueue_style( 'responsi-icon' );
        wp_enqueue_style( 'responsi-font-face' );
        wp_enqueue_style( 'responsi-layout' );
        wp_enqueue_style( 'responsi-framework' );
        wp_enqueue_style( 'responsi-theme' );
        wp_enqueue_style( 'google-fonts' );
    }
}
add_action( 'wp_head', 'responsi_load_styles', 0 );

/*-----------------------------------------------------------------------------------*/
/* Theme Register Scripts */
/*-----------------------------------------------------------------------------------*/

function responsi_framework_default_scripts( &$scripts ){
	global $responsi_version;
	$suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
	$scripts->add( 'responsi-mobile-custom', get_template_directory_uri() . '/functions/js/jquery.mobile.custom'.$suffix.'.js', array('jquery' ), $responsi_version, true );
	$scripts->add( 'responsi-custom-fields', get_template_directory_uri() . '/functions/js/custom-fields'.$suffix.'.js', array( 'jquery', 'jquery-ui-tabs' ), $responsi_version, true );
	$scripts->add( 'responsi-main-script', get_template_directory_uri() . '/functions/js/jquery.responsi'.$suffix.'.js', array('jquery', 'responsi-mobile-custom' ), $responsi_version, true );
	$scripts->add( 'responsi-infinitescroll', get_template_directory_uri() . '/functions/js/masonry/jquery.infinitescroll'.$suffix.'.js', array('jquery', 'jquery-masonry'), $responsi_version, true );
}

add_action( 'wp_default_scripts', 'responsi_framework_default_scripts', 11 );

/*-----------------------------------------------------------------------------------*/
/* Theme Enqueue Scripts */
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'responsi_load_javascript' ) ){
	function responsi_load_javascript(){
		global $responsi_version, $responsi_options, $layout, $content_column, $content_column_grid ;
		wp_enqueue_script( 'responsi-mobile-custom' );
		wp_enqueue_script( 'responsi-main-script' );
		wp_enqueue_script( 'jquery-masonry' );
        wp_enqueue_script( 'responsi-infinitescroll' );
        $responsi_paramaters =  array(
        	'responsi_is_customized'        => is_customize_preview() ? true : false,
        	'responsi_is_search'        	=> is_search() ? true : false,
        	'responsi_is_permalinks'        => get_option('permalink_structure') ? true : false,
			'responsi_layout'      			=> $layout,
			'responsi_content_column'   	=> $content_column,
			'responsi_content_column_grid' 	=> $content_column_grid,
			'responsi_showmore'      		=> isset( $responsi_options['responsi_showmore'] ) ? $responsi_options['responsi_showmore'] : 'click_showmore',
	        'responsi_showmore_text'      	=> isset( $responsi_options['responsi_showmore_text'] ) ? trim( $responsi_options['responsi_showmore_text'] ) : __( 'Show more', 'responsi' ),
	        'responsi_fixed_thumbnail'  	=> isset( $responsi_options['responsi_fixed_thumbnail'] ) ? $responsi_options['responsi_fixed_thumbnail'] : 'false',
	        'responsi_fixed_thumbnail_tall'	=> isset( $responsi_options['responsi_fixed_thumbnail_tall'] ) ? $responsi_options['responsi_fixed_thumbnail_tall'] : 63,
	        'responsi_loading_text_end'     => apply_filters( 'responsi_infinitescroll_loading_text_end', __( "No more Posts to load.", "responsi" ) ),
	        'responsi_loading_text'      	=> apply_filters( 'responsi_infinitescroll_loading_text', __( "Loading the next set of post...", "responsi" ) ),
	        'responsi_loading_icon'      	=> apply_filters( 'responsi_infinitescroll_loading_icon', esc_url( get_template_directory_uri().'/functions/js/masonry/loading-black.gif' ) ),
		);

		wp_localize_script( 'jquery-masonry', 'responsi_paramaters', $responsi_paramaters );
	    
	    if ( is_singular() ) {
	    	wp_enqueue_script( 'comment-reply' );
	    }
	}
}

add_action( 'wp_head', 'responsi_load_javascript', 0 );

/*-----------------------------------------------------------------------------------*/
/* Enable SEO on these Post types */
/*-----------------------------------------------------------------------------------*/

$seo_post_types = array( 'post', 'page' );
define( "SEOPOSTTYPES", serialize($seo_post_types));
?>