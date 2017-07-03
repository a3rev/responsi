<?php
//6.5.9.4
if (!function_exists('responsi_get_the_content')) {
    function responsi_get_the_content()
    {
        return get_the_excerpt();  
    }
}

if (!function_exists('responsi_sass_compile_less_mincss')) {
    function responsi_sass_compile_less_mincss( $type = 'options' )
    {
        if( 'options' == $type ){
             $type = 'framework';
        }
        responsi_dynamic_css( $type );  
    }
}

if (!function_exists('responsi_customize_preview_css')) {
    function responsi_customize_preview_css( $cutomize_css )
    {
        $cutomize_css = responsi_minify_css($cutomize_css);
        wp_add_inline_style( 'customize-preview', $cutomize_css );
    }
}

if (!function_exists('responsi_build_sass_css')) {
    function responsi_build_sass_css( $preview = false  )
    {
        return responsi_build_dynamic_css( $preview );  
    }
}

if ( ! function_exists( 'responsi_framework_upgrade_logo' ) ){

    function responsi_framework_upgrade_logo(){
        $upgrade = get_option('upgrade_responsi_logo' );
        if( $upgrade != 'done' ){
            $responsi_logo = get_theme_mod( 'responsi_logo' );
            if( '' !== $responsi_logo && function_exists('responsi_get_attachment_id_by_url') ){
                $responsi_logo_id = responsi_get_attachment_id_by_url( $responsi_logo );
                if( $responsi_logo_id > 0 ){
                    set_theme_mod( 'custom_logo', $responsi_logo_id );
                }
            }
            $upgrade = update_option('upgrade_responsi_logo', 'done' );
        }
    }
}

add_action( 'after_setup_theme', 'responsi_framework_upgrade_logo' );


//4.7

global $wp_version;

if( version_compare( $wp_version , '4.7', '<') ){

    add_filter( 'responsi_customize_register_sections',  'responsi_sections_custom_css' );

    function responsi_sections_custom_css( $sections ){
        $sections['settings_customcss'] = array(
            'title' => __('Add Custom CSS', 'responsi'),
            'priority' => 13,
            'panel' => 'general_settings_panel',
        );
        return $sections;
    }

    add_filter( 'responsi_settings_controls_settings', 'responsi_settings_controls_settings_custom_css' );

    function responsi_settings_controls_settings_custom_css( $settings_controls_settings ){
        global $responsi_options;
        $settings_controls_settings['responsi_custom_css'] = array(
            'control' => array(
                'label'      => __('Custom CSS', 'responsi'),
                'description' => __( 'Quickly add some CSS to your Responsi Child Theme by adding it here.', 'responsi' ),
                'section'    => 'settings_customcss',
                'settings'   => 'responsi_custom_css',
                'type'       => 'itextarea'
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_custom_css']) ? $responsi_options['responsi_custom_css'] : '',
                'sanitize_callback' => 'responsi_sanitize_textarea_esc_html',
            )
        );
        return $settings_controls_settings;
    }

    if ( !function_exists( 'responsi_custom_css' ) ) {
        function responsi_custom_css() {
            do_action('responsi_custom_css_before');

            global $responsi_options, $google_fonts;
            $output     = '';
            $custom_css = $responsi_options['responsi_custom_css'];
            if ( '' !== trim( $custom_css ) ) {
                $output .= $custom_css;
            }
            if ( isset( $output ) ) {
                $output = '<style id="add_custom_css" media="screen">'. $output .'</style>';
                echo $output;
            }

            do_action('responsi_custom_css_after');
        }
    }
    add_action( 'wp_head', 'responsi_custom_css', 10 );
} else {

    if ( ! function_exists( 'responsi_framework_upgrade_custom_css' ) ){

        function responsi_framework_upgrade_custom_css(){
            $upgrade = get_option('upgrade_responsi_custom_css' );
            if( $upgrade != 'done' ){

                global $wpdb;

                $theme = get_option('stylesheet');

                $responsi_custom_css = get_theme_mod( 'responsi_custom_css' );

                $post_content = '/*
You can add your own CSS here.

Click the help icon above to learn more.
*/
';        
                if( '' !== trim( $responsi_custom_css ) ){
                    $post_content .= $responsi_custom_css;

                    $drafts = $wpdb->get_results( 
                    "
                        SELECT *
                        FROM $wpdb->posts
                        WHERE post_title    = '$theme'
                        AND post_type       = 'custom_css'
                        "
                    );

                    if( $drafts ){
                        foreach ( $drafts as $draft ) {
                            wp_delete_post( $draft->ID, true );
                        }
                    }

                    $custom_css_post_id = wp_insert_post( array( 'post_title' => $theme, 'post_name' => $theme, 'post_status' => 'publish', 'comment_status' => 'closed', 'ping_status' => 'closed', 'post_content' => $post_content, 'post_type' => 'custom_css' ) );
                    if( $custom_css_post_id > 0 ){
                        set_theme_mod( 'custom_css_post_id', $custom_css_post_id );
                    }
                }
                $upgrade = update_option('upgrade_responsi_custom_css', 'done' );
            }
        }
    }

    add_action( 'after_setup_theme', 'responsi_framework_upgrade_custom_css' );
}
?>
