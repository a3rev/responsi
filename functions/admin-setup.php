<?php
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;

/*-----------------------------------------------------------------------------------*/
/* responsi_framework_upgrade_version */
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'responsi_framework_upgrade_version' ) ){

	function responsi_framework_upgrade_version(){

		if( version_compare(get_option('responsi_framework_version'), '8.1.2', '<') ){

	        if( function_exists('responsi_dynamic_css') ){
	        	responsi_dynamic_css( 'framework' );
		    }

	    }
	    
	    if( version_compare(get_option('responsi_framework_version'), '7.9.3', '<') ){

	        if( function_exists('responsi_framework_upgrade') ){
	        	responsi_framework_upgrade();
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
	        	_upgrade_customize_custom_css_phase1();
		        responsi_dynamic_css( 'framework' );
		    }
	    }

	    if ( version_compare(get_option('responsi_framework_version'), '7.6.2') === -1 ) {
	        if( function_exists('responsi_dynamic_css') ){
	        	_upgrade_customize_custom_css_phase2();
		        responsi_dynamic_css( 'framework' );
		    }
	    }

	    update_option( 'responsi_framework_version', RESPONSI_FRAMEWORK_VERSION );
	}
}

function _upgrade_customize_custom_css_phase2(){
	$list_replaces = array(
		'#wrapper-container' => '#responsi-site',
		'.responsi-site-container' => '.responsi-site',
		'#wrapper-top-container' => '#responsi-toolbar',
		'.responsi-top-container' => '.responsi-toolbar',
		'#wrapper-top-fixed' => '#toolbar-ctn',
		'.responsi-top-fixed' => '.toolbar-ctn',
		'.responsi-top-sticky' => '.toolbar-sticky',
		'#wrapper-center' => '#responsi-wrapper',
		'.responsi-center' => '.responsi-wrapper',
		'#wrapper-boxes' => '#wrapper-ctn',
		'.responsi-boxes' => '.wrapper-ctn',
		'#wrapper-boxes-content' => '#wrapper-in',
		'.responsi-boxes-content' => '.wrapper-in',
		'.responsi-header-wrapper' => '.header-ctn',
		'.responsi-header-content' => '.header-in',
		'#wrapper-header' => '#header-ctn',
		'#header-content' => '#header-in',
		'.responsi-header' => '.header',
		'#wrapper-header-content' => '#responsi-header',
		'.responsi-header-container' => '.responsi-header',
		'.header-container' => '.responsi-header',
		'.site-logo-container' => '.logo-ctn',
		'.site-description-container' => '.desc-ctn',
		'.masonry_widget_header' => '.msr-wg-header',
		'#wrapper-nav-content' => '#responsi-navigation',
		'.responsi-nav-container' => '.responsi-navigation',
		'#wrapper-nav' => '#navigation-ctn',
		'.responsi-nav-wrapper' => '.navigation-ctn',
		'#navigation-content' => '#navigation-in',
		'.responsi-nav-content' => '.navigation-in',
		'.mobile-navigation-alignment-left' => '.alignment-left',
		'.mobile-navigation-alignment-right' => '.alignment-right',
		'.mobile-navigation-open' => '.open',
		'.mobile-navigation-close' => '.close',
		'.mobile-navigation' => '.navigation-mobile',
		'.nav-mobile-text' => '.menu-text',
		'.menu-text-before' => '.before',
		'.menu-text-after' => '.after',
		'.nav-separator' => '.separator',
		'.responsi-icon-mobile-menu' => '.menu-icon',
		'.responsi-icon-menu' => '.hamburger-icon',
		'#wrapper-footer-top-content' => '#responsi-footer-widgets',
		'.responsi-footer-before-container' => '.responsi-footer-widgets',
		'#wrapper-footer-top' => '#footer-widgets-ctn',
		'.responsi-footer-before-wrapper' => '.footer-widgets-ctn',
		'#footer-top-content' => '#footer-widgets-in',
		'.responsi-footer-before-content' => '.footer-widgets-in',
		'.responsi-footer-before-widgets' => '.footer-widgets',
		'.masonry_widget_footer' => '.msr-wg-footer',
		'#wrapper-footer-content' => '#responsi-footer',
		'.responsi-footer-container' => '.responsi-footer',
		'#wrapper-footer' => '#footer-ctn',
		'.responsi-footer-wrapper' => '.footer-ctn',
		'#responsi-content-sidebar-alt' => '#sidebar-alt',
		'.responsi-content-sidebar-alt' => '.sidebar-alt',
		'#responsi-content-sidebar' => '#sidebar',
		'.responsi-content-sidebar' => '.sidebar',
		'.sidebar-wrap-content' => '.sidebar-in',
		'.sidebar-wrap' => '.sidebar-ctn',
		'.responsi-content-main' => '.main',
		'main-wrap-' => 'main-',
		'main-wrap' => 'main-ctn',
		'archive-container' => 'main-archive-ctn',
		'.responsi-content-content' => '.content',
		'#wrapper-article' => '#content-in',
		'.responsi-content-article' => '.content-in',
		'.responsi-content-wrapper' => '.content-ctn',
		'.responsi-content-container' => '.responsi-content',
		'blog-post' => 'card',
		'.thumbnail_container' => '.card-thumb',
		'.thumbnail' => '.thumb',
		'.content_container' => '.card-content',
		'.entry-bottom' => '.card-meta',
		'.custom_lines' => '.meta-lines',
		'.entry-content' => '.card-info',
		'.bottom-bg' => '.info-ctn',
		'.gird_descriptions' => '.desc',
		'.blogs-more' => '.ctrl',
		'.show-more-link' => '.ctrl-open',
		'.hide-more-link' => '.ctrl-close',
		'.more-link-button' => '.ctrl-button',
		'.post-utility-cat' => '.categories',
		'.post-utility-tag' => '.tags',
		'.single_content' => '.single-ct',
		'.video_ojbect_container' => '.video-ojbect-ctn',
		'.masonry_widget_home' => '.msr-wg-home',
		'.masonry_widget' => '.msr-wg',
		'responsi-widget-' => 'widget-',
		'#hb-gallery-container' => '#hb-sliders',
		'.hb-gallery-container' => '.hb-sliders',
		'#hb-gallery-wrapper' => '#sliders-ctn',
		'.hb-gallery-wrapper' => '.sliders-ctn',
		'#hb-gallery-content' => '#sliders-in',
		'.hb-gallery-content' => '.sliders-in',
		'#hb-gallery' => '#sliders-ct',
		'.hb-gallery' => '.sliders-ct',
		'#hb-top-widgetized-container' => '#hb-widgetized-title',
		'.hb-top-widgetized-container' => '.hb-widgetized-title',
		'#hb-top-widgetized-wrapper' => '#widgetized-title-ctn',
		'.hb-top-widgetized-wrapper' => '.widgetized-title-ctn',
		'#hb-top-widgetized-content' => '#widgetized-title',
		'.hb-top-widgetized-content' => '.widgetized-title',
		'#hb-widgetized-content' => '#widgetized-in',
		'.hb-widgetized-content' => '.widgetized-in',
		'#hb-widgetized-wrapper' => '#widgetized-ctn',
		'.hb-widgetized-wrapper' => '.widgetized-ctn',
		'#hb-widgetized-container' => '#hb-widgetized',
		'.hb-widgetized-container' => '.hb-widgetized',
		'#hb-top-content-ctn' => '#hb-content-title',
		'.hb-top-content-ctn' => '.hb-content-title',
		'#hb-top-content-wrapper' => '#content-title-ctn',
		'.hb-top-content-wrapper' => '.content-title-ctn',
		'#hb-top-content-content' => '#content-title-in',
		'.hb-top-content-content' => '.content-title-in',
		'.shop-product' => '.card-product',
		'.shop-pro-item' => '.card-product-item',
		'.thumbnail_container' => '.card-thumb',
		'.content_container' => '.card-content',
		'.responsi-wc-price' => '.wctpl-price',
		'.entry-bottom' => '.card-meta',
		'.entry-content' => '.card-info',
		'.pro_gird_descriptions' => '.product-desc',
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

function _upgrade_customize_custom_css_phase1(){

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

	    /*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'script',
				'style',
			)
		);

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'flex-width'  => true,
				'flex-height' => true,
			)
		);

	    add_theme_support( 'post-thumbnails' );
		//set_post_thumbnail_size( 1568, 9999 );
	    add_theme_support( 'automatic-feed-links' );
	    add_theme_support( 'customize-selective-refresh-widgets' );

	    // Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );


		/*
		 * This theme styles the visual editor to resemble the theme style,
		 * specifically font, colors, and column width.
	 	 */
		//add_editor_style( array( 'functions/css/editor-style.css' ) );

		// Add support for Block Styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for full and wide align images.
		add_theme_support( 'align-wide' );

		// Add support for editor styles.
		add_theme_support( 'editor-styles' );

		// Add custom editor font sizes.
		/*add_theme_support(
			'editor-font-sizes',
			array(
				array(
					'name'      => __( 'Small', 'responsi' ),
					'shortName' => __( 'S', 'responsi' ),
					'size'      => 19.5,
					'slug'      => 'small',
				),
				array(
					'name'      => __( 'Normal', 'responsi' ),
					'shortName' => __( 'M', 'responsi' ),
					'size'      => 22,
					'slug'      => 'normal',
				),
				array(
					'name'      => __( 'Large', 'responsi' ),
					'shortName' => __( 'L', 'responsi' ),
					'size'      => 36.5,
					'slug'      => 'large',
				),
				array(
					'name'      => __( 'Huge', 'responsi' ),
					'shortName' => __( 'XL', 'responsi' ),
					'size'      => 49.5,
					'slug'      => 'huge',
				),
			)
		);*/

		// Editor color palette.
		/*add_theme_support(
			'editor-color-palette',
			array(
				array(
					'name'  => 'default' === get_theme_mod( 'primary_color' ) ? __( 'Blue', 'responsi' ) : null,
					'slug'  => 'primary',
					'color' => get_theme_mod( 'primary_color_hue', 199 ),
				),
				array(
					'name'  => 'default' === get_theme_mod( 'primary_color' ) ? __( 'Dark Blue', 'responsi' ) : null,
					'slug'  => 'secondary',
					'color' => get_theme_mod( 'primary_color_hue', 199 ),
				),
				array(
					'name'  => __( 'Dark Gray', 'responsi' ),
					'slug'  => 'dark-gray',
					'color' => '#111',
				),
				array(
					'name'  => __( 'Light Gray', 'responsi' ),
					'slug'  => 'light-gray',
					'color' => '#767676',
				),
				array(
					'name'  => __( 'White', 'responsi' ),
					'slug'  => 'white',
					'color' => '#FFF',
				),
			)
		);*/

		// Add support for responsive embeds.
		add_theme_support( 'responsive-embeds' );

	}
}

add_action( 'after_setup_theme', 'responsi_setup' );

if ( !function_exists( 'responsi_get_customizer_css' ) ){
	function responsi_get_customizer_css( $type = 'front-end' ) {

		global $post, $responsi_options;

		$blockBgCSS = '';

		$post_box_bg                                    = isset( $responsi_options['responsi_post_box_bg'] ) ? $responsi_options['responsi_post_box_bg'] : array( 'onoff' => 'false', 'color' => '#ffffff' );
		$page_box_bg 			= isset( $responsi_options['responsi_page_box_bg'] ) ? $responsi_options['responsi_page_box_bg'] : array( 'onoff' => 'false', 'color' => '#ffffff' );
    	$wrap_content_bg       	= isset( $responsi_options['responsi_wrap_content_background'] ) ? $responsi_options['responsi_wrap_content_background'] : array( 'onoff' => 'false', 'color' => '#ffffff' );
    	$box_inner_bg           = isset( $responsi_options['responsi_box_inner_bg'] ) ? $responsi_options['responsi_box_inner_bg'] : array( 'onoff' => 'false', 'color' => '#ffffff' );
    	$is_layout_boxed		= isset( $responsi_options['responsi_layout_boxed'] ) ? esc_attr( $responsi_options['responsi_layout_boxed'] ) : 'true';
    	$is_enable_boxed_style  = isset( $responsi_options['responsi_enable_boxed_style'] ) ? esc_attr( $responsi_options['responsi_enable_boxed_style'] ) : 'false';
    	$wrap_ctn_bg     		= isset( $responsi_options['responsi_wrap_container_background'] ) ? $responsi_options['responsi_wrap_container_background'] : array( 'onoff' => 'false', 'color' => '#ffffff' );

		if( $post && $post->post_type == 'post' && isset($post_box_bg['onoff']) && isset($post_box_bg['color']) && 'false' != $post_box_bg['onoff'] && '' != $post_box_bg['color'] && 'transparent' != $post_box_bg['color'] ){
			$blockBgCSS = responsi_generate_background_color($post_box_bg);
		}elseif( isset($page_box_bg['onoff']) && isset($page_box_bg['color']) && 'false' != $page_box_bg['onoff'] && '' != $page_box_bg['color'] && 'transparent' != $page_box_bg['color'] ){
			$blockBgCSS = responsi_generate_background_color($page_box_bg);
		}elseif( isset($wrap_content_bg['onoff']) && isset($wrap_content_bg['color']) && 'false' != $wrap_content_bg['onoff'] && '' != $wrap_content_bg['color'] && 'transparent' != $wrap_content_bg['color'] ){
			$blockBgCSS = responsi_generate_background_color($wrap_content_bg);
		}elseif( isset($wrap_ctn_bg['onoff']) && isset($wrap_ctn_bg['color']) && 'false' != $wrap_ctn_bg['onoff'] && '' != $wrap_ctn_bg['color'] && 'transparent' != $wrap_ctn_bg['color'] ){
			$blockBgCSS = responsi_generate_background_color($wrap_ctn_bg);
		}elseif( 'true' === $is_layout_boxed && 'true' === $is_enable_boxed_style && isset($box_inner_bg['onoff']) && isset($box_inner_bg['color']) && 'false' != $box_inner_bg['onoff'] && '' != $box_inner_bg['color'] && 'transparent' != $box_inner_bg['color'] ){
			$blockBgCSS = responsi_generate_background_color($box_inner_bg);
		}else {
		    $responsi_use_style_bg_image                = isset($responsi_options['responsi_use_style_bg_image']) ? esc_attr( $responsi_options['responsi_use_style_bg_image'] ) : 'false';
		    $responsi_style_bg                          = isset($responsi_options['responsi_style_bg']) ? $responsi_options['responsi_style_bg'] : array( 'onoff' => 'true', 'color' => '#ffffff' );
		    $responsi_style_bg_image                    = isset($responsi_options['responsi_style_bg_image']) ? esc_url( $responsi_options['responsi_style_bg_image'] ) : '';
		    $responsi_style_bg_image_repeat             = isset($responsi_options['responsi_style_bg_image_repeat']) ? esc_attr( $responsi_options['responsi_style_bg_image_repeat'] ) : 'repeat';
		    $responsi_style_bg_image_attachment         = isset($responsi_options['responsi_style_bg_image_attachment']) ? esc_attr( $responsi_options['responsi_style_bg_image_attachment'] ) : 'inherit';
		    $responsi_bg_position_vertical              = isset($responsi_options['responsi_bg_position_vertical']) ? esc_attr( $responsi_options['responsi_bg_position_vertical'] ) : 'center';
		    $responsi_bg_position_horizontal            = isset($responsi_options['responsi_bg_position_horizontal']) ? esc_attr( $responsi_options['responsi_bg_position_horizontal'] ) : 'center';
		    $responsi_background_style_img              = isset($responsi_options['responsi_background_style_img']) ? esc_attr( $responsi_options['responsi_background_style_img'] ) : '';
		    $responsi_disable_background_style_img      = isset($responsi_options['responsi_disable_background_style_img']) ? esc_attr( $responsi_options['responsi_disable_background_style_img'] ) : 'false';
		    $responsi_use_bg_size                       = isset($responsi_options['responsi_use_bg_size']) ? esc_attr( $responsi_options['responsi_use_bg_size'] ) : 'false';
		    $responsi_bg_size_width                     = isset($responsi_options['responsi_bg_size_width']) ? esc_attr( $responsi_options['responsi_bg_size_width'] ) : '100%';
		    $responsi_bg_size_height                    = isset($responsi_options['responsi_bg_size_height']) ? esc_attr( $responsi_options['responsi_bg_size_height'] ) : 'auto';
		    $bg_image_size = '';
		    if ($responsi_use_bg_size == 'true') {
		        $bg_image_size = 'background-size:' . $responsi_bg_size_width . ' ' . $responsi_bg_size_height . ';';
		    }

		    if ( 'true' === $responsi_use_style_bg_image ) {
		        $blockBgCSS .= responsi_generate_background_color( $responsi_style_bg );
		        $blockBgCSS .= 'background-image:url("' . $responsi_style_bg_image . '");';
		        $blockBgCSS .= 'background-repeat:' . $responsi_style_bg_image_repeat . ';';
		        $blockBgCSS .= 'background-attachment:' . $responsi_style_bg_image_attachment . ';';
		        $blockBgCSS .= 'background-position:' . $responsi_bg_position_horizontal . ' ' . $responsi_bg_position_vertical . ';';
		        $blockBgCSS .= $bg_image_size;
		    } else {
		        if ( 'true' === $responsi_disable_background_style_img && '' !== $responsi_background_style_img ) {
		            $blockBgCSS .= '
		                background-attachment: ' . $responsi_style_bg_image_attachment . ';
		                background-image: url("' . $responsi_background_style_img . '");
		                ' . responsi_generate_background_color($responsi_style_bg) . '
		                background-position:' . $responsi_bg_position_horizontal . ' ' . $responsi_bg_position_vertical . ';
		                background-repeat: repeat;
		            ';
		        } else {
		            $blockBgCSS .= '
		                background-attachment: ' . $responsi_style_bg_image_attachment . ';
		                ' . responsi_generate_background_color( $responsi_style_bg ) . '
		                background-position:' . $responsi_bg_position_horizontal . ' ' . $responsi_bg_position_vertical . ';
		                background-repeat: ' . $responsi_style_bg_image_repeat . ';
		            ';
		        }
		    }
		}

		$css = '';

		if( '' != $blockBgCSS ){
			$css .= '
				.editor-styles-wrapper {
					' . $blockBgCSS . '
				}
			';
		}

		return $css;

	}
}
/**
 * Enqueue supplemental block editor styles.
 */
function responsi_block_editor_styles() {

	$css_dependencies = array();

	// Enqueue the editor styles.
	wp_enqueue_style( 'responsi-block-editor-styles', get_theme_file_uri( '/functions/css/editor-style-block.css' ), $css_dependencies, wp_get_theme()->get( 'Version' ), 'all' );

	// Add inline style from the Customizer.
	wp_add_inline_style( 'responsi-block-editor-styles', responsi_get_customizer_css( 'block-editor' ) );
	
}

add_action( 'enqueue_block_editor_assets', 'responsi_block_editor_styles', 1, 1 );

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
