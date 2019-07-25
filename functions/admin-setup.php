<?php
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;

/*-----------------------------------------------------------------------------------*/
/* responsi_framework_upgrade_version */
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'responsi_framework_upgrade_version' ) ){

	function responsi_framework_upgrade_version(){
	    
	    if( version_compare(get_option('responsi_framework_version'), '6.9.7', '<') ){

	        if( get_theme_mods() != false && get_option( 'responsi_framework_version' ) != false ){
	        	$theme = get_option( 'stylesheet' );
	            $version = str_replace('.', '_', get_option( 'responsi_framework_version' ));
	            update_option( 'theme_mods_backup_'.$theme.'_'.$version, get_theme_mods() );
	        }

	        if( function_exists('responsi_framework_upgrade') ){
	        	responsi_framework_upgrade();
	        }

	        if( function_exists('responsi_dynamic_css') ){
		        responsi_dynamic_css( 'framework' );
		    }
	    }

	    if( version_compare(get_option('responsi_framework_version'), '7.0.0', '<') ){

	        if( get_theme_mods() != false && get_option( 'responsi_framework_version' ) != false ){
	        	$theme = get_option( 'stylesheet' );
	            $version = str_replace('.', '_', get_option( 'responsi_framework_version' ));
	            update_option( 'theme_mods_backup_'.$theme.'_'.$version, get_theme_mods() );
	        }

	        global $wpdb;

	       	$wpdb->query( "DELETE FROM {$wpdb->prefix}options WHERE option_name LIKE '%theme_mods_chameleon-responsi_%'" );
	       	$wpdb->query( "DELETE FROM {$wpdb->prefix}options WHERE option_name LIKE '%cladded-responsi_%'" );
	       	$wpdb->query( "DELETE FROM {$wpdb->prefix}options WHERE option_name LIKE '%theme_mods_decor-responsi_%'" );
	       	$wpdb->query( "DELETE FROM {$wpdb->prefix}options WHERE option_name LIKE '%theme_mods_elegance-responsi_%'" );
	       	$wpdb->query( "DELETE FROM {$wpdb->prefix}options WHERE option_name LIKE '%theme_mods_glider-responsi_%'" );
	       	$wpdb->query( "DELETE FROM {$wpdb->prefix}options WHERE option_name LIKE '%theme_mods_professional-responsi_%'" );
	        $wpdb->query( "DELETE FROM {$wpdb->prefix}options WHERE option_name LIKE '%theme_mods_responsi-blank-child_%'" );
	        $wpdb->query( "DELETE FROM {$wpdb->prefix}options WHERE option_name LIKE '%theme_mods_a3rev-responsi_%'" );
	        $wpdb->query( "DELETE FROM {$wpdb->prefix}options WHERE option_name LIKE '%theme_mods_daryldixon-responsi_%'" );
	        $wpdb->query( "DELETE FROM {$wpdb->prefix}options WHERE option_name LIKE '%theme_mods_dixie-responsi_%'" );
	        $wpdb->query( "DELETE FROM {$wpdb->prefix}options WHERE option_name LIKE '%theme_mods_jd-responsi_%'" );
	        $wpdb->query( "DELETE FROM {$wpdb->prefix}options WHERE option_name LIKE '%theme_mods_knight-responsi_%'" );
	        $wpdb->query( "DELETE FROM {$wpdb->prefix}options WHERE option_name LIKE '%theme_mods_lagoon-responsi_%'" );
	        $wpdb->query( "DELETE FROM {$wpdb->prefix}options WHERE option_name LIKE '%theme_mods_myne-responsi_%'" );

	        $wpdb->query( "DELETE FROM {$wpdb->prefix}options WHERE option_name LIKE '%a3rev_options%'" );
	        $wpdb->query( "DELETE FROM {$wpdb->prefix}options WHERE option_name LIKE '%woo_options%'" );

	       	$wpdb->query( "DELETE FROM {$wpdb->prefix}options WHERE option_name LIKE '%theme_mods_responsi_5_%'" );
	       	$wpdb->query( "DELETE FROM {$wpdb->prefix}options WHERE option_name LIKE '%theme_mods_responsi_6_%'" );
	       	$wpdb->query( "DELETE FROM {$wpdb->prefix}options WHERE option_name LIKE '%theme_mods_backup_responsi_%'" );

	    }

	    if( version_compare(get_option('responsi_framework_version'), '7.0.1', '<') ){
	        if( function_exists('responsi_dynamic_css') ){
		        responsi_dynamic_css( 'framework' );
		    }
	    }

	    if ( version_compare(get_option('responsi_framework_version'), '7.5.0') === -1 ) {
	        if( function_exists('responsi_dynamic_css') ){
	        	responsi_upgrade_customize_custom_css();
		        responsi_dynamic_css( 'framework' );
		    }
	    }

	    update_option( 'responsi_framework_version', RESPONSI_FRAMEWORK_VERSION );
	}
}

function responsi_upgrade_customize_custom_css(){

	$list_replaces = array(
		'#wrapper-container' 											=> '.responsi-site-container',
		'#wrapper-top-container' 										=> '.responsi-top-container',
		'#wrapper-top-fixed'  											=> '.responsi-top-fixed',
		'#wrapper-center' 												=> '.responsi-center',
		'#wrapper-boxes-content' 										=> '.responsi-boxes-content',
		'#wrapper-boxes'            									=> '.responsi-boxes',
		'#wrapper-header-content'   									=> '.responsi-header-container',
		'#wrapper-header'           									=> '.responsi-header-wrapper',
		'#wrapper-nav-content' 											=> '.responsi-nav-container',
		'#wrapper-nav' 													=> '.responsi-nav-wrapper',
		'#wrapper-content' 												=> '.responsi-content-container',
		'#wrapper-article' 												=> '.responsi-content-article',
		'#wrapper-top-content' 											=> '.rwc-top-container',
		'#wrapper-responsi-top-areas' 									=> '.rfca-container',
		'#wrapper-top-areas' 											=> '.rfca-wrapper',
		'#wrapper-footer-top-content' 									=> '.responsi-footer-before-container',
		'#wrapper-footer-top' 											=> '.responsi-footer-before-wrapper',
		'#wrapper-footer-content' 										=> '.responsi-footer-container',
		'#wrapper-footer' 												=> '.responsi-footer-wrapper',
		'#wrapper_home_full' 											=> '.hb-gallery-container',
		'#wrapper_home_contain' 										=> '.hb-gallery-content',
		'#wrapper_home' 												=> '.hb-gallery-wrapper',
		'#wrapper' 														=> '.responsi-content-wrapper',
		'#header_top_container' 										=> '.cladded-tw-conatainer',
		'#header_top' 													=> '.cladded-tw-wrapper',
		'#header-content'  												=> '.responsi-header-content',
		'#header' 														=> '.responsi-header ',
		'#navigation-content' 											=> '.responsi-nav-content',
		'#navigation' 													=> '.responsi-nav',
		'#content' 														=> '.responsi-content-content',
		'#main' 														=> '.responsi-content-main',
		'#sidebar-alt' 													=> '.responsi-content-sidebar-alt',
		'#sidebar' 														=> '.responsi-content-sidebar',
		'#footer_copyright_animation' 									=> '.responsi-copyright-animation',
		'#footer_credit_animation' 										=> '.responsi-credit-animation',
		'#footer-top-content' 											=> '.responsi-footer-before-content',
		'#footer-widgets' 												=> '.responsi-footer-before-widgets',
		'#footer-content' 												=> '.responsi-footer-content',
		'#footer' 														=> '.responsi-footer',
		'#additional' 													=> '.responsi-footer-additional',
		'#copyright' 													=> '.responsi-footer-copyright',
		'#credit' 														=> '.responsi-footer-credit',
		'#additional_animation' 										=> '.responsi-additional-animation',
		'#back-top' 													=> '.responsi-scrolltop',
		'#home-content-title' 											=> '.hb-top-content-contaner',
		'#home_title_section1' 											=> '.hb-title-section1',
		'#home_title_section2' 											=> '.hb-title-section2',
		'#home_title_section3' 											=> '.hb-title-section3',
		'#home_title_section4' 											=> '.hb-title-section4',
		'#home_section1' 												=> '.hb-section1',
		'#home_section2' 												=> '.hb-section2',
		'#home_section3' 												=> '.hb-section3',
		'#home_section4' 												=> '.hb-section4',
		'#home' 														=> '.hb-top-gallery',
		'#widgetized-area-title-home' 									=> '.hb-top-widgetized-container',
		'#widgetized_full_container' 									=> '.hb-widgetized-container',
		'#responsi-top-areas' 											=> '.rfca-content',
		'#responsi-top-nav-bar' 										=> '#rtnb-menu',
		'#single-recent-posts' 											=> '.single-recent-posts',
		'#post-author' 													=> '.post-author',
		'.custom_box_product' 											=> '.rwc-area-product',
		'.custom_box_archive' 											=> '.responsi-area-archive',
		'.custom_box_post' 												=> '.responsi-area-post',
		'.custom_box_page' 												=> '.responsi-area-page',
		'.custom_box' 													=> '.responsi-area',
		'.full_container_content' 										=> '.hb-widgetized-wrapper',
		'.full_container' 												=> '.responsi-area-full',
		'.shiftclick_container' 										=> '.responsi-shiftclick',
		'.fw_widget_title' 												=> '.responsi-widget-title',
		'.fw_widget_content' 											=> '.responsi-widget-content',
		'.masonry_widget_blank' 										=> '.widget-blank',
		'.my_home' 														=> '.hb-gallery',
		'.home-slider-before' 											=> '.hb-content-before',
		'.home-slider-after' 											=> '.hb-content-after',
		'.widgetized_title_home' 										=> '.hb-top-widgetized-wrapper',
		'.text_show_above_widget' 										=> '.hb-top-widgetized-content',
		'.widgetized_container' 										=> '.hb-widgetized-content',
		'.widgetized_content' 											=> '.hb-widgetized',
		'.masonry_widget_under_home' 									=> '.masonry-widgetizedcontent_title_home',
		'.under_home_widget_content' 									=> '.widget-widgetized',
		'.content_title_home' 											=> '.hb-top-content-wrapper',
		'.text_show_above_content' 										=> '.hb-top-content-content',
		'.top-nav-bar-navigation' 										=> '.rtnb-navigation',
		'.top-nav-bar-wrapper' 											=> '.rtnb-layout',
		'.top-nav-bar-container' 										=> '.rtnb-container',
		'.top-nav-bar-site-width' 										=> '.rtnb-wrapper',
		'.top-nav-bar-content' 											=> '.rtnb-content',
		'.top-nav-bar' 													=> '.rtnb-content-content',
		'.transparent_layout' 											=> '.transparent-container',
		'.responsi_homebuilder_slider_gallery_blank' 					=> '.hb-img-blank',
		'.responsi-top-areas-content' 									=> '.rfca-content-content',
		'.responsi-top-nav-bar-menu' 									=> '.rtnb-menu',
		'.responsi-icon-mobile-menu' 									=> '.rtnb-icon-menu',
	);

	$_childthemes = get_stylesheet();

	$args = array(
        'post_type'        	=> 'custom_css',
        'post_status'      	=> 'publish',
        'name'        		=> $_childthemes,
    );

	$posts_custom_css = get_posts( $args ); 

	$new_custom_css = '';

	$update = false;
	
	if( $posts_custom_css ){

		foreach ($posts_custom_css as $post) {

			$post_id = $post->ID;

			if( '' != trim( $post->post_content) ){

				$old_custom_css = $post->post_content;

				$new_custom_css = $old_custom_css;

				if( '' != $new_custom_css ){
					
					foreach ( $list_replaces as $key => $value ) {
						$new_custom_css = str_replace( $key, $value, $new_custom_css );
						$update = true;
					}

					if( $update && $post_id > 0 ){

						if( false === get_option('custom_css_'.$_childthemes) ){
							update_option( 'custom_css_'.$_childthemes, $old_custom_css );
						}

						$_edited_post = array(
							'ID'           => $post_id,
						    'post_content' => $new_custom_css
						);

						wp_update_post( $_edited_post);
					}
				}

			}
		}
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

	    add_theme_support( 'woocommerce', array(
		    // Product grid theme settings
		    'product_grid' => array(
		        'default_rows'    => 4,
		        'min_rows'        => 1,
		        'max_rows'        => 6,
		        'default_columns' => 4,
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

	    // Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		add_theme_support( 'align-wide' );
		add_theme_support( 'dark-editor-style' );

		/*
		 * This theme styles the visual editor to resemble the theme style,
		 * specifically font, colors, and column width.
	 	 */
		//add_editor_style( array( 'functions/css/editor-style.css' ) );

		// Load regular editor styles into the new block-based editor.
		add_theme_support( 'editor-styles' );

	 	// Load default block styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for responsive embeds.
		add_theme_support( 'responsive-embeds' );

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
