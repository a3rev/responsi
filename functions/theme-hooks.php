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

    $styles->add( 'animate', get_template_directory_uri() . '/functions/css/animate/animate.min.css', array(), $responsi_version, 'all' );    
    $styles->add( 'responsi-custom-fields', get_template_directory_uri() . '/functions/css/custom-fields'.$suffix.'.css', array(), $responsi_version, 'all' );
    $styles->add( 'responsi-custom-fields-rtl', get_template_directory_uri() . '/functions/css/custom-fields.rtl'.$suffix.'.css', array(), $responsi_version, 'all' );
    $styles->add( 'responsi-icon', get_template_directory_uri() . '/functions/css/responsi-icon'.$suffix.'.css', array(), $responsi_version, 'all' );
    $styles->add( 'responsi-framework', get_template_directory_uri() . '/style.css', array(), $responsi_version, 'all' );
    if( is_child_theme() ){
	    $styles->add( 'responsi-theme', get_bloginfo('stylesheet_url'), array( 'responsi-framework' ), $responsi_version, 'all' );
	}
}

add_action( 'wp_default_styles', 'responsi_register_styles', 1 );

function responsi_register_googlefonts( $styles ){
	global $responsi_version;
	$suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

	$fontUrl = responsi_google_webfonts();

	if( $fontUrl != '' ){
		$urls = $fontUrl.'&display=swap';
		$styles->add( 'responsi-googlefonts', $urls, array( 'common' ) );
	}
	
}

add_action( 'wp_default_styles', 'responsi_register_googlefonts', 11 );

function responsi_print_styles_array( $handles ){
	if( function_exists('wp_should_load_block_editor_scripts_and_styles') && wp_should_load_block_editor_scripts_and_styles() ){
		$handles[] = 'responsi-googlefonts';
	}
	return $handles;
}

add_filter('print_styles_array', 'responsi_print_styles_array');


/*-----------------------------------------------------------------------------------*/
/* Theme Enqueue Google Fonts */
/*-----------------------------------------------------------------------------------*/

add_action( 'wp_head', 'responsi_register_webfonts', 0 );

/*-----------------------------------------------------------------------------------*/
/* Theme responsi_rm_minify_css */
/*-----------------------------------------------------------------------------------*/

function responsi_rm_minify_css(){
	do_action( 'responsi_rm_minify_css_before' );
	echo '<!-- RM-Minify CSS -->';
	do_action( 'responsi_rm_minify_css_after' );
}

add_action( 'wp_print_styles', 'responsi_rm_minify_css', 2 );

/*-----------------------------------------------------------------------------------*/
/* Theme Enqueue Styles */
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'responsi_load_styles' ) ){
    function responsi_load_styles(){

    	global $responsi_animate;

    	if ( is_user_logged_in() ) {
	    	wp_enqueue_style( 'responsi-icon' );
	    }
        wp_enqueue_style( 'responsi-framework' );
        wp_enqueue_style( 'responsi-theme' );

        global $responsi_options;

        if( is_customize_preview() ){
        	$responsi_animate = true;
        }else{
        	$responsi_animate = false;
        }

        $animateOpLists = array(
        	'responsi_header_animation_1',
	        'responsi_header_animation_2',
	        'responsi_header_animation_3',
	        'responsi_header_animation_4',
	        'responsi_header_animation_5',
	        'responsi_header_animation_6',
	        'responsi_blog_animation',
	        'responsi_widget_animation',
	        'responsi_additional_animation',
	        'responsi_footer_left_animation',
	        'responsi_footer_link_animation',
	        'responsi_footer_animation_1',
	        'responsi_footer_animation_2',
	        'responsi_footer_animation_3',
	        'responsi_footer_animation_4',
	        'responsi_footer_animation_5',
	        'responsi_footer_animation_6'
	       
	    );

	    $animateOpLists = apply_filters( 'responsi-animateOpLists', $animateOpLists );

	    if( is_array( $animateOpLists ) && count( $animateOpLists ) > 0 ){
	    	foreach ( $animateOpLists as $value) {
	    		if( isset( $responsi_options[ $value ] ) && is_array( $responsi_options[ $value ] ) ){
	    			if( isset( $responsi_options[ $value ]['type'] ) && $responsi_options[ $value ]['type'] != 'none' ){
	    				$responsi_animate = true;
	    			}
	    		}
	    	}
	    }

	    $responsi_animate = apply_filters( 'responsi-animate', $responsi_animate );

	    if( is_customize_preview() ){
        	wp_enqueue_style( 'animate' );
        }elseif( $responsi_animate ){
        	wp_enqueue_style( 'animate' );
        }

        // Load the dark colorscheme.
		if ( 'dark' === get_theme_mod( 'colorscheme', 'light' ) || is_customize_preview() ) {
			wp_enqueue_style( 'responsi-colors-dark', get_theme_file_uri( '/functions/css/colors-dark.css' ), array( 'responsi-framework' ) );
		}

        if( !is_customize_preview() ){
        	wp_enqueue_style( 'google-fonts' );
        }
    }
}
add_action( 'wp_head', 'responsi_load_styles', 0 );

add_action( 'admin_head', 'responsi_admin_load_google_fonts', 0 );

function responsi_admin_load_google_fonts(){
	global $pagenow;
	responsi_register_webfonts();
	if ( in_array( $pagenow, array( 'post.php' ) ) && isset( $_GET['post'] ) && isset( $_GET['action'] ) ) {
		wp_enqueue_style( 'google-fonts' );
	}
}

/*-----------------------------------------------------------------------------------*/
/* Theme Register Scripts */
/*-----------------------------------------------------------------------------------*/

function responsi_framework_default_scripts( &$scripts ){
	global $responsi_version;
	$suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
    $scripts->add( 'waypoints', get_template_directory_uri() . '/functions/js/waypoints/jquery.waypoints.min.js', array('jquery' ), $responsi_version, true );
	$scripts->add( 'a3-blockpress-animation', get_template_directory_uri() . '/functions/js/front/js/animation-on-scroll.js', array('waypoints' ), $responsi_version, true );
	$scripts->add( 'jquery-mobile-touch', get_template_directory_uri() . '/functions/js/jquery.mobile.touch.min.js', array( 'jquery'), $responsi_version, true );
	$scripts->add( 'responsi-custom-fields', get_template_directory_uri() . '/functions/js/custom-fields'.$suffix.'.js', array( 'jquery', 'jquery-ui-tabs' ), $responsi_version, true );
	$scripts->add( 'infinitescroll', get_template_directory_uri() . '/functions/js/infinite-scroll.pkgd.min.js', array( 'jquery' ), '4.0.1', true );
	$scripts->add( 'responsi-main-script', get_template_directory_uri() . '/functions/js/jquery.responsi'.$suffix.'.js', array( 'jquery', 'infinitescroll' ), $responsi_version, true );
}

add_action( 'wp_default_scripts', 'responsi_framework_default_scripts', 11 );

/*-----------------------------------------------------------------------------------*/
/* Theme Enqueue Scripts */
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'responsi_load_javascript' ) ){
	function responsi_load_javascript(){
		global $responsi_version, $responsi_options, $layout, $content_column, $content_column_grid, $responsi_animate, $responsi_icons;
		if( wp_is_mobile() ){
			//wp_enqueue_script( 'jquery-mobile-touch' );
		}

        wp_enqueue_script( 'infinitescroll' );
		wp_enqueue_script( 'responsi-main-script' );

        if( $responsi_animate ){
        	wp_enqueue_script( 'a3-blockpress-animation' );
        }
        $responsi_paramaters =  array(
        	'responsi_is_customized'        	=> is_customize_preview() ? true : false,
        	'responsi_is_search'        		=> is_search() ? true : false,
        	'responsi_is_permalinks'        	=> get_option('permalink_structure') ? true : false,
			'responsi_layout'      				=> $layout,
			'responsi_content_column'   		=> $content_column,
			'responsi_content_column_grid' 		=> $content_column_grid,
			'responsi_showmore'      			=> isset( $responsi_options['responsi_showmore'] ) ? $responsi_options['responsi_showmore'] : 'click_showmore',
	        'responsi_showmore_text'      		=> isset( $responsi_options['responsi_showmore_text'] ) ? trim( $responsi_options['responsi_showmore_text'] ) : __( 'Show more', 'responsi' ),
	        'responsi_fixed_thumbnail'  		=> isset( $responsi_options['responsi_fixed_thumbnail'] ) ? $responsi_options['responsi_fixed_thumbnail'] : 'false',
	        'responsi_fixed_thumbnail_tall'		=> isset( $responsi_options['responsi_fixed_thumbnail_tall'] ) ? $responsi_options['responsi_fixed_thumbnail_tall'] : 63,
	        'responsi_loading_text_end'     	=> apply_filters( 'responsi_infinitescroll_loading_text_end', __( "No more Posts to load.", "responsi" ) ),
	        'responsi_loading_text'      		=> apply_filters( 'responsi_infinitescroll_loading_text', __( "Loading the next set of post...", "responsi" ) ),
	        'responsi_allow_nextpage_ext'     	=> apply_filters( 'responsi_allow_nextpage_ext', array( 'html', 'htm' ) ),
	        'responsi_google_webfonts'      	=> is_customize_preview() ? esc_url( responsi_google_webfonts() ) : false,
	        'responsi_exclude_button_css'   	=> responsi_exclude_button_css(),
	        'responsi_button_none_css_lists'	=> responsi_button_none_css_lists(),
	        'responsi_icons'					=> $responsi_icons
		);

		wp_localize_script( 'responsi-main-script', 'responsi_paramaters', $responsi_paramaters );

	    if ( is_singular() ) {
	    	wp_enqueue_script( 'comment-reply' );
	    }
	}
}

add_action( 'wp_footer', 'responsi_load_javascript', 0 );

/*-----------------------------------------------------------------------------------*/
/* Enable SEO on these Post types */
/*-----------------------------------------------------------------------------------*/

$seo_post_types = array( 'post', 'page' );
define( "SEOPOSTTYPES", serialize($seo_post_types));
?>
