<?php

namespace A3Rev\Responsi;

class Settings
{

    public function __construct()
    {
        add_action('customize_preview_init', array( $this, 'responsi_customize_preview_init' ), 11);
        add_filter('responsi_default_options', array( $this, 'responsi_controls_settings' ));
        add_filter('responsi_customize_register_panels', array( $this, 'responsi_panels' ));
        add_filter('responsi_customize_register_sections', array( $this, 'responsi_sections' ));
        add_filter('responsi_customize_register_settings', array( $this, 'responsi_controls_settings' ));
    }

    public function responsi_customize_preview_init()
    {
        wp_enqueue_script('responsi-customize-setting');
    }

    public function responsi_panels($panels)
    {
        $settings_panels = array();
        $settings_panels['general_settings_panel'] = array(
            'title' => __('General Settings', 'responsi'),
            'priority' => 1.5,
        );
        $panels = array_merge($panels, $settings_panels);
        return  $panels ;
    }

    public function responsi_sections($sections)
    {
        $settings_sections = array();
        $settings_sections['settings_site_branding'] = array(
            'title' => __('Site Logo & Images', 'responsi'),
            'priority' => 10,
            'panel' => 'general_settings_panel',
        );
        $settings_sections['settings_buttons'] = array(
            'title' => __('Site Buttons', 'responsi'),
            'priority' => 10,
            'panel' => 'general_settings_panel',
        );
        $settings_sections['settings_links'] = array(
            'title' => __('Site Text Links', 'responsi'),
            'priority' => 10,
            'panel' => 'general_settings_panel',
        );
        $settings_sections['settings_comments'] = array(
            'title' => __('Comments', 'responsi'),
            'priority' => 10,
            'panel' => 'general_settings_panel',
        );
        $settings_sections['settings_typography'] = array(
            'title' => __('Site Typography', 'responsi'),
            'priority' => 10,
            'panel' => 'general_settings_panel',
        );
        $settings_sections['settings_breadcrumbs'] = array(
            'title' => __('Breadcrumb Navigation', 'responsi'),
            'priority' => 10,
            'panel' => 'general_settings_panel',
        );

        $sections = array_merge($sections, $settings_sections);
        return  $sections ;
    }

    public function responsi_controls_settings($controls_settings)
    {

        $_default = apply_filters('default_settings_options', false);
        
        if ($_default) {
            $responsi_options = array();
        } else {
            global $responsi_options;
        }

        $settings_controls_settings = array();

        $settings_controls_settings['lbsettings1'] = array(
            'control' => array(
                'label'      => __('Site Logo', 'responsi'),
                'section'    => 'settings_site_branding',
                'type'       => 'ilabel',
                'priority' => 1,
            ),
            'setting' => array()
        );

        $settings_controls_settings['lbsettings2'] = array(
            'control' => array(
                'label'      => __('Site Title and Tag Line', 'responsi'),
                'priority' => 3,
                'section'    => 'settings_site_branding',
                'type'       => 'ilabel'
            ),
            'setting' => array()
        );

        $settings_controls_settings['responsi_font_logo'] = array(
            'control' => array(
                'label' => __('Site Title Font', 'responsi'),
                'section'    => 'settings_site_branding',
                'settings'   => 'multiple',
                'type'       => 'typography',
                'priority' => 4,
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_font_logo']) ? $responsi_options['responsi_font_logo'] : array('size' => '36','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#FFFFFF'),
                'sanitize_callback' => 'responsi_sanitize_typography',
                'transport' => 'postMessage'
            )
        );

        $settings_controls_settings['responsi_enable_site_description'] = array(
            'control' => array(
                'label'      => __('Show in Header', 'responsi'),
                'section'    => 'settings_site_branding',
                'settings'   => 'responsi_enable_site_description',
                'type'       => 'icheckbox',
                'input_attrs' => array(
                    'class' => 'collapsed'
                ),
                'priority' => 6,
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_enable_site_description']) ? $responsi_options['responsi_enable_site_description'] : 'false',
                'sanitize_callback' => 'responsi_sanitize_checkboxs',
            )
        );

        $settings_controls_settings['responsi_font_desc'] = array(
            'control' => array(
                'label' => __('Tagline Font', 'responsi'),
                'section'    => 'settings_site_branding',
                'settings'   => 'multiple',
                'type'       => 'typography',
                'input_attrs' => array(
                    'class' => 'hide last'
                ),
                'priority' => 6,
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_font_desc']) ? $responsi_options['responsi_font_desc'] : array('size' => '13','line_height' => '1.5','face' => 'PT Sans','style' => 'normal','color' => '#7c7c7c'),
                'sanitize_callback' => 'responsi_sanitize_typography',
                'transport' => 'postMessage'
            )
        );

        $settings_controls_settings['lbsettings3'] = array(
            'control' => array(
                'label'      => __('Site Icon', 'responsi'),
                'section'    => 'settings_site_branding',
                'type'       => 'ilabel',
                'priority' => 6,
            ),
            'setting' => array()
        );

        $settings_controls_settings['lbsettings4'] = array(
            'control' => array(
                'label'      => __('Site Default Image', 'responsi'),
                'section'    => 'settings_site_branding',
                'type'       => 'ilabel',
                'priority' => 12,
            ),
            'setting' => array()
        );
        $settings_controls_settings['responsi_default_image'] = array(
            'control' => array(
                'label'      => __('Default Image', 'responsi'),
                'description' => __('When no image is uploaded or featured in a Post or custom post type the default image is used. Social Share OpenGraph requires image be larger than 200px by 200px', 'responsi'),
                'section'    => 'settings_site_branding',
                'settings'   => 'responsi_default_image',
                'type'       => 'iupload',
                'input_attrs' => array('width' => 250, 'height' => 250 ),
                'priority' => 13,
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_default_image']) ? $responsi_options['responsi_default_image'] : '',
                'sanitize_callback' => 'esc_url',
            )
        );

        $settings_controls_settings['lbsettings5'] = array(
            'control' => array(
                'label'      => __('RSS Feed Image', 'responsi'),
                'section'    => 'settings_site_branding',
                'type'       => 'ilabel',
                'priority' => 13,
            ),
            'setting' => array()
        );
        $settings_controls_settings['responsi_rss_thumb'] = array(
            'control' => array(
                'label'      => __('RSS Image Thumbnail', 'responsi'),
                'section'    => 'settings_site_branding',
                'settings'   => 'responsi_rss_thumb',
                'type'       => 'icheckbox',
                'priority' => 14,
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_rss_thumb']) ? $responsi_options['responsi_rss_thumb'] : 'false',
                'sanitize_callback' => 'responsi_sanitize_checkboxs',
            )
        );
        $settings_controls_settings['lbsettings6'] = array(
            'control' => array(
                'label'      => __('Site Button Style', 'responsi'),
                'section'    => 'settings_buttons',
                'type'       => 'ilabel'
            ),
            'setting' => array()
        );

        $settings_controls_settings['responsi_button_text'] = array(
            'control' => array(
                'label' => __('Font', 'responsi'),
                'section'    => 'settings_buttons',
                'settings'   => 'multiple',
                'type'       => 'typography'
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_button_text']) ? $responsi_options['responsi_button_text'] : array('size' => '12','line_height' => '1.2','face' => 'Open Sans','style' => 'bold','color' => '#FFFFFF'),
                'sanitize_callback' => 'responsi_sanitize_typography',
                'transport' => 'postMessage'
            )
        );
        $settings_controls_settings['responsi_button_text_shadow'] = array(
            'control' => array(
                'label'      => __('Font Shadow', 'responsi'),
                'section'    => 'settings_buttons',
                'settings'   => 'responsi_button_text_shadow',
                'type'       => 'icheckbox',
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_button_text_shadow']) ? $responsi_options['responsi_button_text_shadow'] : 'true',
                'sanitize_callback' => 'responsi_sanitize_checkboxs',
                'transport' => 'postMessage'
            )
        );
        $settings_controls_settings['responsi_button_text_transform'] = array(
            'control' => array(
                'label'      => __('Transform', 'responsi'),
                'section'    => 'settings_buttons',
                'settings'   => 'responsi_button_text_transform',
                'type'       => 'iradio',
                'input_attrs' => array(
                    'checked_label' => 'ON',
                    'unchecked_label' => 'OFF',
                    'container_width' => 80
                ),
                'choices' => array( "none" => __('None', 'responsi'),"uppercase" => __('Uppercase', 'responsi'), "lowercase" => __('Lowercase', 'responsi'))
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_button_text_transform']) ? $responsi_options['responsi_button_text_transform'] : 'uppercase',
                'sanitize_callback' => 'responsi_sanitize_choices',
                'transport' => 'postMessage'
            )
        );
        $settings_controls_settings['responsi_button_color'] = array(
            'control' => array(
                'label'      => __('Base Background Colour', 'responsi'),
                'section'    => 'settings_buttons',
                'settings'   => 'responsi_button_color',
                'type'       => 'icolor'
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_button_color']) ? $responsi_options['responsi_button_color'] : '#ff6868',
                'sanitize_callback' => 'sanitize_hex_color',
                'transport' => 'postMessage'
            )
        );
        $settings_controls_settings['responsi_button_gradient_from'] = array(
            'control' => array(
                'label'      => __('Gradient from', 'responsi'),
                'section'    => 'settings_buttons',
                'settings'   => 'responsi_button_gradient_from',
                'type'       => 'icolor'
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_button_gradient_from']) ? $responsi_options['responsi_button_gradient_from'] : '#ff6868',
                'sanitize_callback' => 'sanitize_hex_color',
                'transport' => 'postMessage'
            )
        );
        $settings_controls_settings['responsi_button_gradient_to'] = array(
            'control' => array(
                'label'      => __('Gradient to', 'responsi'),
                'section'    => 'settings_buttons',
                'settings'   => 'responsi_button_gradient_to',
                'type'       => 'icolor'
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_button_gradient_to']) ? $responsi_options['responsi_button_gradient_to'] : '#ff6868',
                'sanitize_callback' => 'sanitize_hex_color',
                'transport' => 'postMessage'
            )
        );
        $settings_controls_settings['responsi_button_border_top'] = array(
            'control' => array(
                'label' => __('Border - Top', 'responsi'),
                'section'    => 'settings_buttons',
                'settings'   => 'multiple',
                'type'       => 'border'
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_button_border_top']) ? $responsi_options['responsi_button_border_top'] : array('width' => '1','style' => 'solid','color' => '#ef5252'),
                'sanitize_callback' => 'responsi_sanitize_border',
                'transport' => 'postMessage'
            )
        );
        $settings_controls_settings['responsi_button_border_bottom'] = array(
            'control' => array(
                'label' => __('Border - Bottom', 'responsi'),
                'section'    => 'settings_buttons',
                'settings'   => 'multiple',
                'type'       => 'border'
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_button_border_bottom']) ? $responsi_options['responsi_button_border_bottom'] : array('width' => '1','style' => 'solid','color' => '#ef5252'),
                'sanitize_callback' => 'responsi_sanitize_border',
                'transport' => 'postMessage'
            )
        );
        $settings_controls_settings['responsi_button_border_left'] = array(
            'control' => array(
                'label' => __('Border - Left', 'responsi'),
                'section'    => 'settings_buttons',
                'settings'   => 'multiple',
                'type'       => 'border'
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_button_border_left']) ? $responsi_options['responsi_button_border_left'] : array('width' => '1','style' => 'solid','color' => '#ef5252'),
                'sanitize_callback' => 'responsi_sanitize_border',
                'transport' => 'postMessage'
            )
        );
        $settings_controls_settings['responsi_button_border_right'] = array(
            'control' => array(
                'label' => __('Border - Right', 'responsi'),
                'section'    => 'settings_buttons',
                'settings'   => 'multiple',
                'type'       => 'border'
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_button_border_right']) ? $responsi_options['responsi_button_border_right'] : array('width' => '1','style' => 'solid','color' => '#ef5252'),
                'sanitize_callback' => 'responsi_sanitize_border',
                'transport' => 'postMessage'
            )
        );
        $settings_controls_settings['responsi_button_border_radius_tl'] = array(
            'control' => array(
                'label'      => __('Border Corner - Top Left', 'responsi'),
                'section'    => 'settings_buttons',
                'settings'   => 'multiple',
                'type'       => 'border_radius'
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_button_border_radius_tl']) ? $responsi_options['responsi_button_border_radius_tl'] : array( 'corner' => 'rounded' , 'rounded_value' => 19 ),
                'sanitize_callback' => 'responsi_sanitize_border_radius',
                'transport' => 'postMessage'
            )
        );
        $settings_controls_settings['responsi_button_border_radius_tr'] = array(
            'control' => array(
                'label'      => __('Border Corner - Top Right', 'responsi'),
                'section'    => 'settings_buttons',
                'settings'   => 'multiple',
                'type'       => 'border_radius'
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_button_border_radius_tr']) ? $responsi_options['responsi_button_border_radius_tr'] : array( 'corner' => 'rounded' , 'rounded_value' => 19 ),
                'sanitize_callback' => 'responsi_sanitize_border_radius',
                'transport' => 'postMessage'
            )
        );
        $settings_controls_settings['responsi_button_border_radius_bl'] = array(
            'control' => array(
                'label'      => __('Border Corner - Bottom Left', 'responsi'),
                'section'    => 'settings_buttons',
                'settings'   => 'multiple',
                'type'       => 'border_radius'
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_button_border_radius_bl']) ? $responsi_options['responsi_button_border_radius_bl'] : array( 'corner' => 'rounded' , 'rounded_value' => 19 ),
                'sanitize_callback' => 'responsi_sanitize_border_radius',
                'transport' => 'postMessage'
            )
        );
        $settings_controls_settings['responsi_button_border_radius_br'] = array(
            'control' => array(
                'label'      => __('Border Corner - Bottom Right', 'responsi'),
                'section'    => 'settings_buttons',
                'settings'   => 'multiple',
                'type'       => 'border_radius'
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_button_border_radius_br']) ? $responsi_options['responsi_button_border_radius_br'] : array( 'corner' => 'rounded' , 'rounded_value' => 19 ),
                'sanitize_callback' => 'responsi_sanitize_border_radius',
                'transport' => 'postMessage'
            )
        );
        $settings_controls_settings['responsi_button_border_box_shadow'] = array(
            'control' => array(
                'label'      => __('Border Shadow', 'responsi'),
                'section'    => 'settings_buttons',
                'settings'   => 'multiple',
                'type'       => 'box_shadow'
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_button_border_box_shadow']) ? $responsi_options['responsi_button_border_box_shadow'] : array( 'onoff' => 'false' , 'h_shadow' => '0px' , 'v_shadow' => '0px', 'blur' => '2px' , 'spread' => '0px', 'color' => '#DBDBDB', 'inset' => 'inset' ),
                'sanitize_callback' => 'responsi_sanitize_box_shadow',
                'transport' => 'postMessage'
            )
        );

        $settings_controls_settings['responsi_button_padding'] = array(
            'control' => array(
                'label'      => __('Padding', 'responsi'),
                'section'    => 'settings_buttons',
                'settings'   => 'multitext',
                'type'       => 'multitext',
                'choices' => array(
                    'top' => 'Top',
                    'bottom' => 'Bottom',
                    'left' => 'Left',
                    'right' => 'Right',
                )
            ),
            'setting' => array(
                'default'       => array(
                    isset($responsi_options['responsi_button_padding_top']) ? $responsi_options['responsi_button_padding_top'] : '5' ,
                    isset($responsi_options['responsi_button_padding_bottom']) ? $responsi_options['responsi_button_padding_bottom'] : '5',
                    isset($responsi_options['responsi_button_padding_left']) ? $responsi_options['responsi_button_padding_left'] : '15',
                    isset($responsi_options['responsi_button_padding_right']) ? $responsi_options['responsi_button_padding_right'] : '15'
                ),
                'sanitize_callback' => 'responsi_sanitize_numeric',
                'transport' => 'postMessage',
            )
        );

        $settings_controls_settings['lbsettings7plus'] = array(
            'control' => array(
                'label'      => __('Exclude Buttons by class or id from Framework Button style', 'responsi'),
                'section'    => 'settings_buttons',
                'type'       => 'ilabel'
            ),
            'setting' => array()
        );

        $settings_controls_settings['responsi_exclude_button_lists'] = array(
            'control' => array(
                'label'      => "",
                'description' => __('Enter button class (eg: .button-class) or ID (eg: .button-id) that you want excluded, comma separated if more than 1.', 'responsi'),
                'section'    => 'settings_buttons',
                'settings'   => 'responsi_exclude_button_lists',
                'type'       => 'itext',
                'input_attrs' => array(
                )
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_exclude_button_lists']) ? $responsi_options['responsi_exclude_button_lists'] : '',
                'sanitize_callback' => 'sanitize_text_field',
                //'transport'   => 'postMessage'
            )
        );

        $settings_controls_settings['lbsettings7'] = array(
            'control' => array(
                'label'      => __('Site Link Colours', 'responsi'),
                'section'    => 'settings_links',
                'type'       => 'ilabel'
            ),
            'setting' => array()
        );
        $settings_controls_settings['responsi_link_color'] = array(
            'control' => array(
                'label'      => __('Text link Colour', 'responsi'),
                'section'    => 'settings_links',
                'settings'   => 'responsi_link_color',
                'type'       => 'icolor'
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_link_color']) ? $responsi_options['responsi_link_color'] : '#009ee0',
                'sanitize_callback' => 'sanitize_hex_color',
                'transport' => 'postMessage'
            )
        );
        $settings_controls_settings['responsi_link_hover_color'] = array(
            'control' => array(
                'label'      => __('Text Link Colour on Mouse Over', 'responsi'),
                'section'    => 'settings_links',
                'settings'   => 'responsi_link_hover_color',
                'type'       => 'icolor'
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_link_hover_color']) ? $responsi_options['responsi_link_hover_color'] : '#ff6868',
                'sanitize_callback' => 'sanitize_hex_color',
                'transport' => 'postMessage'
            )
        );
        $settings_controls_settings['responsi_link_visited_color'] = array(
            'control' => array(
                'label'      => __('Clicked Text Link Colour', 'responsi'),
                'section'    => 'settings_links',
                'settings'   => 'responsi_link_visited_color',
                'type'       => 'icolor'
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_link_visited_color']) ? $responsi_options['responsi_link_visited_color'] : '#009ee0',
                'sanitize_callback' => 'sanitize_hex_color',
                'transport' => 'postMessage'
            )
        );
        $settings_controls_settings['lbsettings8'] = array(
            'control' => array(
                'label'      => __('Comments', 'responsi'),
                'section'    => 'settings_comments',
                'type'       => 'ilabel'
            ),
            'setting' => array()
        );
        $settings_controls_settings['responsi_comments'] = array(
            'control' => array(
                'label'      => __('Post/Page Comments', 'responsi'),
                'section'    => 'settings_comments',
                'settings'   => 'responsi_comments',
                'type'       => 'iradio',
                'input_attrs' => array(
                    'checked_label' => 'ON',
                    'unchecked_label' => 'OFF',
                    'container_width' => 80
                ),
                'choices' => array( "none" => __('None', 'responsi'), "post" => __('Posts Only', 'responsi'), "page" => __('Pages Only', 'responsi'), "both" => __('Pages / Posts', 'responsi') )
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_comments']) ? $responsi_options['responsi_comments'] : 'both',
                'sanitize_callback' => 'responsi_sanitize_choices',
            )
        );
        $settings_controls_settings['lbsettings9'] = array(
            'control' => array(
                'label'      => __('Comments Style', 'responsi'),
                'section'    => 'settings_comments',
                'type'       => 'ilabel'
            ),
            'setting' => array()
        );
        $settings_controls_settings['responsi_post_comments_bg'] = array(
            'control' => array(
                'label'      => __('Comments Background Color (even threads)', 'responsi'),
                'section'    => 'settings_comments',
                'settings'   => 'multiple',
                'type'       => 'ibackground'
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_post_comments_bg']) ? $responsi_options['responsi_post_comments_bg'] : array( 'onoff' => 'true', 'color' => 'rgba(0, 0, 0, 0.02)'),
                'sanitize_callback' => 'responsi_sanitize_background_color',
                'transport' => 'postMessage'
            )
        );
        $settings_controls_settings['lbsettings10'] = array(
            'control' => array(
                'label'      => __('Default Typography', 'responsi'),
                'description' => __('These fonts are your theme designs default fonts. There are many sections where these can be over ridden with custom font options', 'responsi'),
                'section'    => 'settings_typography',
                'type'       => 'ilabel'
            ),
            'setting' => array()
        );
        $settings_controls_settings['responsi_font_text'] = array(
            'control' => array(
                'label' => __('General Text Font', 'responsi'),
                'section'    => 'settings_typography',
                'settings'   => 'multiple',
                'type'       => 'typography'
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_font_text']) ? $responsi_options['responsi_font_text'] : array('size' => '14','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#555555'),
                'sanitize_callback' => 'responsi_sanitize_typography',
                'transport' => 'postMessage'
            )
        );
        $settings_controls_settings['responsi_font_h1'] = array(
            'control' => array(
                'label' => __('H1 Font', 'responsi'),
                'section'    => 'settings_typography',
                'settings'   => 'multiple',
                'type'       => 'typography'
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_font_h1']) ? $responsi_options['responsi_font_h1'] : array('size' => '26','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#009ee0'),
                'sanitize_callback' => 'responsi_sanitize_typography',
                'transport' => 'postMessage'
            )
        );
        $settings_controls_settings['responsi_font_h2'] = array(
            'control' => array(
                'label' => __('H2 Font', 'responsi'),
                'section'    => 'settings_typography',
                'settings'   => 'multiple',
                'type'       => 'typography'
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_font_h2']) ? $responsi_options['responsi_font_h2'] : array('size' => '24','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#009ee0'),
                'sanitize_callback' => 'responsi_sanitize_typography',
                'transport' => 'postMessage'
            )
        );
        $settings_controls_settings['responsi_font_h3'] = array(
            'control' => array(
                'label' => __('H3 Font', 'responsi'),
                'section'    => 'settings_typography',
                'settings'   => 'multiple',
                'type'       => 'typography'
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_font_h3']) ? $responsi_options['responsi_font_h3'] : array('size' => '22','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#009ee0'),
                'sanitize_callback' => 'responsi_sanitize_typography',
                'transport' => 'postMessage'
            )
        );
        $settings_controls_settings['responsi_font_h4'] = array(
            'control' => array(
                'label' => __('H4 Font', 'responsi'),
                'section'    => 'settings_typography',
                'settings'   => 'multiple',
                'type'       => 'typography'
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_font_h4']) ? $responsi_options['responsi_font_h4'] : array('size' => '20','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#009ee0'),
                'sanitize_callback' => 'responsi_sanitize_typography',
                'transport' => 'postMessage'
            )
        );
        $settings_controls_settings['responsi_font_h5'] = array(
            'control' => array(
                'label' => __('H5 Font', 'responsi'),
                'section'    => 'settings_typography',
                'settings'   => 'multiple',
                'type'       => 'typography'
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_font_h5']) ? $responsi_options['responsi_font_h5'] : array('size' => '18','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#009ee0'),
                'sanitize_callback' => 'responsi_sanitize_typography',
                'transport' => 'postMessage'
            )
        );
        $settings_controls_settings['responsi_font_h6'] = array(
            'control' => array(
                'label' => __('H6 Font', 'responsi'),
                'section'    => 'settings_typography',
                'settings'   => 'multiple',
                'type'       => 'typography'
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_font_h6']) ? $responsi_options['responsi_font_h6'] : array('size' => '16','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#009ee0'),
                'sanitize_callback' => 'responsi_sanitize_typography',
                'transport' => 'postMessage'
            )
        );
        $settings_controls_settings['lbsettings11'] = array(
            'control' => array(
                'label'      => __('Site Breadcrumbs', 'responsi'),
                'section'    => 'settings_breadcrumbs',
                'type'       => 'ilabel'
            ),
            'setting' => array()
        );
        $settings_controls_settings['responsi_breadcrumbs_show'] = array(
            'control' => array(
                'label'      => __('Breadcrumbs', 'responsi'),
                'section'    => 'settings_breadcrumbs',
                'settings'   => 'responsi_breadcrumbs_show',
                'type'       => 'icheckbox',
                'input_attrs' => array(
                    'class' => 'collapsed-custom'
                )
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_breadcrumbs_show']) ? $responsi_options['responsi_breadcrumbs_show'] : 'false',
                'sanitize_callback' => 'responsi_sanitize_checkboxs',
                //'transport'   => 'postMessage'
            )
        );

        $settings_controls_settings['lbsettings12'] = array(
            'control' => array(
                'label'      => __('Breadcrumb Font', 'responsi'),
                'section'    => 'settings_breadcrumbs',
                'type'       => 'ilabel',
                'input_attrs' => array(
                    'class' => 'hide-custom'
                )
            ),
            'setting' => array()
        );
        $settings_controls_settings['responsi_breadcrumbs_font'] = array(
            'control' => array(
                'label' => __('Font', 'responsi'),
                'section'    => 'settings_breadcrumbs',
                'settings'   => 'multiple',
                'type'       => 'typography',
                'input_attrs' => array(
                    'class' => 'hide-custom'
                )
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_breadcrumbs_font']) ? $responsi_options['responsi_breadcrumbs_font'] : array('size' => '14','line_height' => '1','face' => 'Open Sans','style' => 'normal','color' => '#555555'),
                'sanitize_callback' => 'responsi_sanitize_typography',
                'transport' => 'postMessage'
            )
        );
        $settings_controls_settings['responsi_breadcrumbs_link'] = array(
            'control' => array(
                'label'      => __('Text Link Colour', 'responsi'),
                'section'    => 'settings_breadcrumbs',
                'settings'   => 'responsi_breadcrumbs_link',
                'type'       => 'icolor',
                'input_attrs' => array(
                    'class' => 'hide-custom'
                )
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_breadcrumbs_link']) ? $responsi_options['responsi_breadcrumbs_link'] : '#009ee0',
                'sanitize_callback' => 'sanitize_hex_color',
                'transport' => 'postMessage'
            )
        );
        $settings_controls_settings['responsi_breadcrumbs_link_hover'] = array(
            'control' => array(
                'label'      => __('Text Link Hover', 'responsi'),
                'section'    => 'settings_breadcrumbs',
                'settings'   => 'responsi_breadcrumbs_link_hover',
                'type'       => 'icolor',
                'input_attrs' => array(
                    'class' => 'hide-custom'
                )
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_breadcrumbs_link_hover']) ? $responsi_options['responsi_breadcrumbs_link_hover'] : '#ff6868',
                'sanitize_callback' => 'sanitize_hex_color',
                'transport' => 'postMessage'
            )
        );

        $settings_controls_settings['lbsettings13'] = array(
            'control' => array(
                'label'      => __('Breadcrumb Separator', 'responsi'),
                'section'    => 'settings_breadcrumbs',
                'type'       => 'ilabel',
                'input_attrs' => array(
                    'class' => 'hide-custom'
                )
            ),
            'setting' => array()
        );
        $settings_controls_settings['responsi_breadcrumbs_sep'] = array(
            'control' => array(
                'label'      => __('Arrow Separator', 'responsi'),
                'section'    => 'settings_breadcrumbs',
                'settings'   => 'responsi_breadcrumbs_sep',
                'type'       => 'icolor',
                'input_attrs' => array(
                    'class' => 'hide-custom'
                )
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_breadcrumbs_sep']) ? $responsi_options['responsi_breadcrumbs_sep'] : '#CCCCCC',
                'sanitize_callback' => 'sanitize_hex_color',
                'transport' => 'postMessage'
            )
        );
        $settings_controls_settings['lbsettings14'] = array(
            'control' => array(
                'label'      => __('Breadcrumb Container', 'responsi'),
                'section'    => 'settings_breadcrumbs',
                'type'       => 'ilabel',
                'input_attrs' => array(
                    'class' => 'hide-custom'
                )
            ),
            'setting' => array()
        );

        $settings_controls_settings['responsi_breadcrumbs_bg'] = array(
            'control' => array(
                'label'      => __('Background Colour', 'responsi'),
                'section'    => 'settings_breadcrumbs',
                'settings'   => 'responsi_breadcrumbs_bg',
                'settings'   => 'multiple',
                'type'       => 'ibackground',
                'input_attrs' => array(
                    'class' => 'hide-custom'
                )
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_breadcrumbs_bg']) ? $responsi_options['responsi_breadcrumbs_bg'] : array( 'onoff' => 'false', 'color' => '#ffffff'),
                'sanitize_callback' => 'responsi_sanitize_background_color',
                'transport' => 'postMessage'
            )
        );

        $settings_controls_settings['responsi_breadcrumbs_border_top'] = array(
            'control' => array(
                'label' => __('Container Border - Top', 'responsi'),
                'section'    => 'settings_breadcrumbs',
                'settings'   => 'multiple',
                'type'       => 'border',
                'input_attrs' => array(
                    'class' => 'hide-custom'
                )
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_breadcrumbs_border_top']) ? $responsi_options['responsi_breadcrumbs_border_top'] : array('width' => '0','style' => 'solid','color' => '#dbdbdb'),
                'sanitize_callback' => 'responsi_sanitize_border',
                'transport' => 'postMessage'
            )
        );
        $settings_controls_settings['responsi_breadcrumbs_border_bottom'] = array(
            'control' => array(
                'label' => __('Container Border - Bottom', 'responsi'),
                'section'    => 'settings_breadcrumbs',
                'settings'   => 'multiple',
                'type'       => 'border',
                'input_attrs' => array(
                    'class' => 'hide-custom'
                )
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_breadcrumbs_border_bottom']) ? $responsi_options['responsi_breadcrumbs_border_bottom'] : array('width' => '0','style' => 'solid','color' => '#dbdbdb'),
                'sanitize_callback' => 'responsi_sanitize_border',
                'transport' => 'postMessage'
            )
        );
        $settings_controls_settings['responsi_breadcrumbs_border_lr'] = array(
            'control' => array(
                'label' => __('Container Border - Left / Right', 'responsi'),
                'section'    => 'settings_breadcrumbs',
                'settings'   => 'multiple',
                'type'       => 'border',
                'input_attrs' => array(
                    'class' => 'hide-custom'
                )
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_breadcrumbs_border_lr']) ? $responsi_options['responsi_breadcrumbs_border_lr'] : array('width' => '0','style' => 'solid','color' => '#dbdbdb'),
                'sanitize_callback' => 'responsi_sanitize_border',
                'transport' => 'postMessage'
            )
        );
        $settings_controls_settings['responsi_breadcrumbs_border_radius'] = array(
            'control' => array(
                'label'      => __('Border Corner', 'responsi'),
                'section'    => 'settings_breadcrumbs',
                'settings'   => 'multiple',
                'type'       => 'border_radius',
                'input_attrs' => array(
                    'class' => 'hide-custom'
                )
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_breadcrumbs_border_radius']) ? $responsi_options['responsi_breadcrumbs_border_radius'] : array( 'corner' => 'rounded' , 'rounded_value' => 0 ),
                'sanitize_callback' => 'responsi_sanitize_border_radius',
                'transport' => 'postMessage'
            )
        );
        $settings_controls_settings['responsi_breadcrumbs_box_shadow'] = array(
            'control' => array(
                'label'      => __('Border Shadow', 'responsi'),
                'section'    => 'settings_breadcrumbs',
                'settings'   => 'multiple',
                'type'       => 'box_shadow',
                'input_attrs' => array(
                    'class' => 'hide-custom'
                )
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_breadcrumbs_box_shadow']) ? $responsi_options['responsi_breadcrumbs_box_shadow'] : array( 'onoff' => 'false' , 'h_shadow' => '0px' , 'v_shadow' => '0px', 'blur' => '2px' , 'spread' => '0px', 'color' => '#DBDBDB', 'inset' => 'inset' ),
                'sanitize_callback' => 'responsi_sanitize_box_shadow',
                'transport' => 'postMessage'
            )
        );

        $settings_controls_settings['responsi_breadcrumbs_margin'] = array(
            'control' => array(
                'label'      => __('Margin', 'responsi'),
                'section'    => 'settings_breadcrumbs',
                'settings'   => 'multitext',
                'type'       => 'multitext',
                'choices' => array(
                    'top' => 'Top',
                    'bottom' => 'Bottom',
                    'left' => 'Left',
                    'right' => 'Right',
                ),
                'input_attrs' => array(
                    'class' => 'hide-custom'
                )
            ),
            'setting' => array(
                'default'       => array(
                    isset($responsi_options['responsi_breadcrumbs_margin_top']) ? $responsi_options['responsi_breadcrumbs_margin_top'] : '0' ,
                    isset($responsi_options['responsi_breadcrumbs_margin_bottom']) ? $responsi_options['responsi_breadcrumbs_margin_bottom'] : '10',
                    isset($responsi_options['responsi_breadcrumbs_margin_left']) ? $responsi_options['responsi_breadcrumbs_margin_left'] : '0',
                    isset($responsi_options['responsi_breadcrumbs_margin_right']) ? $responsi_options['responsi_breadcrumbs_margin_right'] : '0'
                ),
                'sanitize_callback' => 'responsi_sanitize_numeric',
                'transport' => 'postMessage',
            ),
        );
        $settings_controls_settings['responsi_breadcrumbs_padding'] = array(
            'control' => array(
                'label'      => __('Padding', 'responsi'),
                'section'    => 'settings_breadcrumbs',
                'settings'   => 'multitext',
                'type'       => 'multitext',
                'choices' => array(
                    'top' => 'Top',
                    'bottom' => 'Bottom',
                    'left' => 'Left',
                    'right' => 'Right',
                ),
                'input_attrs' => array(
                    'class' => 'hide-custom hide-custom-last'
                )
            ),
            'setting' => array(
                'default'       => array(
                    isset($responsi_options['responsi_breadcrumbs_padding_top']) ? $responsi_options['responsi_breadcrumbs_padding_top'] : '0' ,
                    isset($responsi_options['responsi_breadcrumbs_padding_bottom']) ? $responsi_options['responsi_breadcrumbs_padding_bottom'] : '0',
                    isset($responsi_options['responsi_breadcrumbs_padding_left']) ? $responsi_options['responsi_breadcrumbs_padding_left'] : '0',
                    isset($responsi_options['responsi_breadcrumbs_padding_right']) ? $responsi_options['responsi_breadcrumbs_padding_right'] : '0'
                ),
                'sanitize_callback' => 'responsi_sanitize_numeric',
                'transport' => 'postMessage',
            ),
        );

        $settings_controls_settings['lbsettings15'] = array(
            'control' => array(
                'label'      => __('Add Custom CSS', 'responsi'),
                'section'    => 'settings_customcss',
                'type'       => 'ilabel'
            ),
            'setting' => array()
        );

        $settings_controls_settings = apply_filters('responsi_settings_controls_settings', $settings_controls_settings);
        $controls_settings = array_merge($controls_settings, $settings_controls_settings);
        return  $controls_settings ;
    }
}
