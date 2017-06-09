<?php
//Filter Content - Remove wpautop
if ( !is_admin() ) {
    add_filter( 'the_content', 'responsi_remove_wpautop', 99 );
    add_filter( 'get_the_excerpt', 'responsi_remove_shortcode_get_the_excerpt', 99 );
}

if ( !function_exists( 'responsi_remove_shortcode_get_the_excerpt' ) ) {
    function responsi_remove_shortcode_get_the_excerpt( $content ) {
        // Strip tags and shortcodes
        $content = strip_tags( strip_shortcodes( $content ), apply_filters( 'responsi_get_the_content_allowedtags', '<script>,<style>' ) );
        // Inline styles/scripts
        $content = trim( preg_replace('#<(s(cript|tyle)).*?</\1>#si', '', $content ) );

        $exclude_codes = 'remove_all_miss_shortcode';
        $content       = preg_replace("~(?:\[/?)(?!(?:$exclude_codes))[^/\]]+/?\]~s", '', $content );
        return $content;
    }
}

//Filter widget_text - Support do shortcode widget text
add_filter( 'widget_text', 'do_shortcode' );

$sections = array(
    'responsi_single_post_meta',
    'responsi_single_post_meta_categories_default',
    'responsi_single_post_meta_tags_default',
    'responsi_build_copyright',
    'responsi_build_credit',
    'responsi_build_additional'
);

foreach ($sections as $s){
    add_filter( $s, 'do_shortcode', 20 );
}

if (!function_exists('responsi_remove_wpautop_shortcode')) {
    function responsi_remove_wpautop_shortcode( $content )
    {
        $content = do_shortcode( shortcode_unautop( $content ) );
        $content = preg_replace( '#^<\/p>|^<br \/>|<p>$#', '', $content );
        return $content;
    }
}

if ( !function_exists( 'responsi_remove_wpautop' ) ) {
    function responsi_remove_wpautop( $content ) {
        $content = shortcode_unautop( $content );
        $content = preg_replace( '#^<\/p>|^<br \/>|<p>$#', '', $content );
        return $content;
    }
}

//Responsi Tool Bar Menus
if ( !function_exists( 'responsi_admin_bar_menu' ) ) {
    function responsi_admin_bar_menu () {
        global $wp_admin_bar;
        $menu_label = __( 'Responsi', 'responsi' );

        $wp_admin_bar->add_menu( array( 'id' => 'responsithemes', 'title' => $menu_label, 'href' => wp_customize_url() ) );

        do_action('responsi_support_admin_bar_menu_before');

        $customize_menu = false;
        if ( current_user_can('manage_options') ){
            $customize_menu = true;
        }
        $customize_menu = apply_filters( 'responsi_support_admin_bar_menu_customize', $customize_menu );
        if( $customize_menu ){
            $wp_admin_bar->add_menu( array( 'parent' => 'responsithemes', 'id' => 'responsithemes-theme-options', 'title' => __( 'Theme Customizer', 'responsi' ), 'href' => wp_customize_url() ) );
        }

        do_action('responsi_support_admin_bar_menu_after');

    }
}

add_action( 'admin_bar_menu', 'responsi_admin_bar_menu', 20 );

if ( !function_exists( 'responsi_admin_bar_menu_items' ) ) {
    function responsi_admin_bar_menu_items(){

        global $wp_admin_bar;

        $changelog_menu = true;
        $changelog_menu = apply_filters( 'responsi_support_admin_bar_menu_changelog', $changelog_menu );
        if( $changelog_menu ){
             $wp_admin_bar->add_menu( array( 'parent' => 'responsithemes', 'id' => 'responsithemes-responsi-changelog', 'title' => __( 'Changelog', 'responsi' ), 'meta' => array('target' => '_blank' ), 'href' => get_template_directory_uri().'/changelog.txt??KeepThis=true&TB_iframe=true' ) );
        }
    }
}

add_action( 'responsi_support_admin_bar_menu_after', 'responsi_admin_bar_menu_items', 11 );

if ( !function_exists( 'responsi_admin_bar_menu_style' ) ) {
    function responsi_admin_bar_menu_style(){
        $css = '';
        if( is_admin() ){
            $css .= '@font-face { font-family: "responsi-icon"; src: url("'.get_template_directory_uri().'/functions/fonts/responsi-icon.eot"); src: url("'.get_template_directory_uri().'/functions/fonts/responsi-icon.eot?#iefix") format("embedded-opentype"), url("'.get_template_directory_uri().'/functions/fonts/responsi-icon.woff") format("woff"), url("'.get_template_directory_uri().'/functions/fonts/responsi-icon.ttf") format("truetype"), url("'.get_template_directory_uri().'/functions/fonts/responsi-icon.svg#responsi-icon") format("svg"); font-weight: normal; font-style: normal; }';
        }
        $css .= '
        #wp-admin-bar-responsithemes > a.ab-item:before{font-family:"responsi-icon"!important;font-style:normal!important;font-weight:normal!important;font-variant:normal!important;text-transform:none!important;line-height:1;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale;display:inline-block;font-size:17px!important;transition:all 0.1s ease-in-out 0s;content:"a"!important;padding:4px;margin-right:6px;top:3px;}
        @media screen and (max-width:782px){
            #wp-admin-bar-responsithemes > a{width:35px!important;overflow:hidden;}
            #wp-admin-bar-responsithemes > a.ab-item:before{font-size:28px!important;top:5px!important;}
        ';
        wp_add_inline_style( 'admin-bar', responsi_minify_css( $css ) );
        //wp_add_inline_script( 'jquery-migrate', 'jQuery(document).ready(function(){jQuery(window).on( "load", function() {jQuery("#wpadminbar #wp-admin-bar-responsithemes-responsi-changelog a").addClass("thickbox");});});' );
    }
}

add_action( 'wp_enqueue_scripts', 'responsi_admin_bar_menu_style' );
add_action( 'admin_enqueue_scripts', 'responsi_admin_bar_menu_style' );

?>
