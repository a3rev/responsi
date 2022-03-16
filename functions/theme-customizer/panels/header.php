<?php

namespace A3Rev\Responsi;

class Header
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
        wp_enqueue_script('responsi-customize-header');
    }

    public function responsi_panels($panels)
    {
        $header_panels = array();
        $header_panels['header_settings_panel'] = array(
            'title' => __('Header', 'responsi'),
            'priority' => 2.5,
        );
        $panels = array_merge($panels, $header_panels);
        return  $panels ;
    }

    public function responsi_sections($sections)
    {
        $header_sections = array();
        $header_sections['header_style'] = array(
            'title' => __('Header - Style', 'responsi'),
            'priority' => 10,
            'panel' => 'header_settings_panel',
        );
        $header_sections['header_widgets'] = array(
            'title' => __('Header - Widgets', 'responsi'),
            'priority' => 10,
            'panel' => 'header_settings_panel',
        );
        $sections = array_merge($sections, $header_sections);
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

        $header_controls_settings = array();

        $header_controls_settings['lbheader1'] = array(
            'control' => array(
                'label'      => __('Header Container', 'responsi'),
                'section'    => 'header_style',
                'type'       => 'ilabel'
            ),
            'setting' => array()
        );

        $header_controls_settings['responsi_header_bg'] = array(
            'control' => array(
                'label'      => __('Background Color', 'responsi'),
                'section'    => 'header_style',
                'settings'   => 'multiple',
                'type'       => 'ibackground'
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_header_bg']) ? $responsi_options['responsi_header_bg'] : array('onoff' => 'true', 'color' => '#08364e'),
                'sanitize_callback' => 'responsi_sanitize_background_color',
                'transport' => 'postMessage',
            )
        );

        $header_controls_settings['responsi_enable_header_bg_image'] = array(
            'control' => array(
                'label'      => __('Background Image', 'responsi'),
                'section'    => 'header_style',
                'settings'   => 'responsi_enable_header_bg_image',
                'type'       => 'icheckbox',
                'input_attrs' => array(
                    'class' => 'collapsed'
                )
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_enable_header_bg_image']) ? $responsi_options['responsi_enable_header_bg_image'] : 'false',
                'sanitize_callback' => 'responsi_sanitize_checkboxs',
                'transport' => 'postMessage'
            )
        );

        $header_controls_settings['responsi_header_bg_image'] = array(
            'control' => array(
                'label'      => __('Image', 'responsi'),
                'section'    => 'header_style',
                'settings'   => 'responsi_header_bg_image',
                'type'       => 'iupload',
                'input_attrs' => array(
                    'class' => 'hide'
                )
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_header_bg_image']) ? $responsi_options['responsi_header_bg_image'] : '',
                'sanitize_callback' => 'esc_url',
                'transport' => 'postMessage'
            )
        );

        $header_controls_settings['responsi_bg_header_position'] = array(
            'control' => array(
                'label'      => __('Image Alignment', 'responsi'),
                //'description' => __( 'Supports absolute values left, right, center, top, bottom or pixel values e.g. 20px for inner container positioning of image.', 'responsi' ),
                'section'    => 'header_style',
                'settings'   => 'multitext',
                'type'       => 'multitext',
                'choices' => array(
                    'vertical' => 'Vertical',
                    'horizontal' => 'Horizontal'
                ),
                'input_attrs' => array(
                    'class' => 'hide'
                )
            ),
            'setting' => array(
                'default'       => array(
                    isset($responsi_options['responsi_bg_header_position_vertical']) ? $responsi_options['responsi_bg_header_position_vertical'] : 'center' ,
                    isset($responsi_options['responsi_bg_header_position_horizontal']) ? $responsi_options['responsi_bg_header_position_horizontal'] : 'center'
                ),
                'sanitize_callback' => 'responsi_sanitize_background_position',
                'transport' => 'postMessage'
            )
        );

        $header_controls_settings['responsi_header_bg_image_repeat'] = array(
            'control' => array(
                'label'      => __('Image Repeat', 'responsi'),
                'section'    => 'header_style',
                'settings'   => 'responsi_header_bg_image_repeat',
                'type'       => 'iradio',
                'input_attrs' => array(
                    'checked_label' => 'ON',
                    'unchecked_label' => 'OFF',
                    'container_width' => 80,
                    'class' => 'hide last'
                ),
                'choices' => array(
                    'no-repeat' => 'No repeat',
                    'repeat' => 'Repeat',
                    'repeat-x' => 'Repeat Horizontally',
                    'repeat-y' => 'Repeat Vertically'
                )
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_header_bg_image_repeat']) ? $responsi_options['responsi_header_bg_image_repeat'] : 'repeat',
                'sanitize_callback' => 'responsi_sanitize_choices',
                'transport' => 'postMessage'
            )
        );

        $header_controls_settings['responsi_header_border_top'] = array(
            'control' => array(
                'label'      => __('Container Border - Top', 'responsi'),
                'section'    => 'header_style',
                'settings'   => 'multiple',
                'type'       => 'border'
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_header_border_top']) ? $responsi_options['responsi_header_border_top'] : array('width' => '0','style' => 'solid','color' => '#dbdbdb'),
                'sanitize_callback' => 'responsi_sanitize_border',
                'transport' => 'postMessage',
            )
        );

        $header_controls_settings['responsi_header_border_bottom'] = array(
            'control' => array(
                'label'      => __('Container Border - Bottom', 'responsi'),
                'section'    => 'header_style',
                'settings'   => 'multiple',
                'type'       => 'border'
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_header_border_bottom']) ? $responsi_options['responsi_header_border_bottom'] : array('width' => '0','style' => 'solid','color' => '#dbdbdb'),
                'sanitize_callback' => 'responsi_sanitize_border',
                'transport' => 'postMessage'
            )
        );

        $header_controls_settings['responsi_header_border_lr'] = array(
            'control' => array(
                'label'      => __('Border - Left / Right', 'responsi'),
                'section'    => 'header_style',
                'settings'   => 'multiple',
                'type'       => 'border'
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_header_border_lr']) ? $responsi_options['responsi_header_border_lr'] : array('width' => '0','style' => 'solid','color' => '#dbdbdb'),
                'sanitize_callback' => 'responsi_sanitize_border',
                'transport' => 'postMessage'
            )
        );

        $header_controls_settings['responsi_header_box_shadow'] = array(
            'control' => array(
                'label'      => __('Border Shadow', 'responsi'),
                'section'    => 'header_style',
                'settings'   => 'multiple',
                'type'       => 'box_shadow'
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_header_box_shadow']) ? $responsi_options['responsi_header_box_shadow'] : array( 'onoff' => 'false' , 'h_shadow' => '0px' , 'v_shadow' => '0px', 'blur' => '5px' , 'spread' => '0px', 'color' => '#DBDBDB', 'inset' => '' ),
                'sanitize_callback' => 'responsi_sanitize_box_shadow',
                'transport' => 'postMessage'
            )
        );

        $header_controls_settings['responsi_header_margin'] = array(
            'control' => array(
                'label'      => __('Margin', 'responsi'),
                'section'    => 'header_style',
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
                    isset($responsi_options['responsi_header_margin_top']) ? $responsi_options['responsi_header_margin_top'] : '0' ,
                    isset($responsi_options['responsi_header_margin_bottom']) ? $responsi_options['responsi_header_margin_bottom'] : '0',
                    isset($responsi_options['responsi_header_margin_left']) ? $responsi_options['responsi_header_margin_left'] : '0',
                    isset($responsi_options['responsi_header_margin_right']) ? $responsi_options['responsi_header_margin_right'] : '0'
                ),
                'sanitize_callback' => 'responsi_sanitize_numeric',
                'transport' => 'postMessage',
            )
        );

        $header_controls_settings['responsi_header_padding'] = array(
            'control' => array(
                'label'      => __('Padding', 'responsi'),
                'section'    => 'header_style',
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
                    isset($responsi_options['responsi_header_padding_top']) ? $responsi_options['responsi_header_padding_top'] : '0' ,
                    isset($responsi_options['responsi_header_padding_bottom']) ? $responsi_options['responsi_header_padding_bottom'] : '0',
                    isset($responsi_options['responsi_header_padding_left']) ? $responsi_options['responsi_header_padding_left'] : '0',
                    isset($responsi_options['responsi_header_padding_right']) ? $responsi_options['responsi_header_padding_right'] : '0'
                ),
                'sanitize_callback' => 'responsi_sanitize_numeric',
                'transport' => 'postMessage',
            )
        );

        $header_controls_settings['lbheader2'] = array(
            'control' => array(
                'label'      => __('Header Content Container', 'responsi'),
                'section'    => 'header_style',
                'type'       => 'ilabel'
            ),
            'setting' => array()
        );

        $header_controls_settings['responsi_header_inner_bg'] = array(
            'control' => array(
                'label'      => __('Background Color', 'responsi'),
                'section'    => 'header_style',
                'settings'   => 'multiple',
                'type'       => 'ibackground'
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_header_inner_bg']) ? $responsi_options['responsi_header_inner_bg'] : array('onoff' => 'false', 'color' => '#08364e'),
                'sanitize_callback' => 'responsi_sanitize_background_color',
                'transport' => 'postMessage'
            )
        );

        $header_controls_settings['responsi_enable_header_inner_bg_image'] = array(
            'control' => array(
                'label'      => __('Background Image', 'responsi'),
                'section'    => 'header_style',
                'settings'   => 'responsi_enable_header_inner_bg_image',
                'type'       => 'icheckbox',
                'input_attrs' => array(
                    'class' => 'collapsed'
                )
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_enable_header_inner_bg_image']) ? $responsi_options['responsi_enable_header_inner_bg_image'] : 'false',
                'sanitize_callback' => 'responsi_sanitize_checkboxs',
                'transport' => 'postMessage'
            )
        );

        $header_controls_settings['responsi_header_inner_bg_image'] = array(
            'control' => array(
                'label'      => __('Image', 'responsi'),
                'section'    => 'header_style',
                'settings'   => 'responsi_header_inner_bg_image',
                'type'       => 'iupload',
                'input_attrs' => array(
                    'class' => 'hide'
                )
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_header_inner_bg_image']) ? $responsi_options['responsi_header_inner_bg_image'] : '',
                'sanitize_callback' => 'esc_url',
                'transport' => 'postMessage'
            )
        );

        $header_controls_settings['responsi_bg_header_inner_position'] = array(
            'control' => array(
                'label'      => __('Image Alignment', 'responsi'),
                //'description' => __( 'Supports absolute values left, right, center, top, bottom or pixel values e.g. 20px for inner container positioning of image.', 'responsi' ),
                'section'    => 'header_style',
                'settings'   => 'multitext',
                'type'       => 'multitext',
                'choices' => array(
                    'vertical' => 'Vertical',
                    'horizontal' => 'Horizontal'
                ),
                'input_attrs' => array(
                    'class' => 'hide'
                )
            ),
            'setting' => array(
                'default'       => array(
                    isset($responsi_options['responsi_bg_header_inner_position_vertical']) ? $responsi_options['responsi_bg_header_inner_position_vertical'] : 'center' ,
                    isset($responsi_options['responsi_bg_header_inner_position_horizontal']) ? $responsi_options['responsi_bg_header_inner_position_horizontal'] : 'center'
                ),
                'sanitize_callback' => 'responsi_sanitize_background_position',
                'transport' => 'postMessage'
            )
        );

        $header_controls_settings['responsi_header_inner_bg_image_repeat'] = array(
            'control' => array(
                'label'      => __('Image Repeat', 'responsi'),
                'section'    => 'header_style',
                'settings'   => 'responsi_header_inner_bg_image_repeat',
                'type'       => 'iradio',
                'input_attrs' => array(
                    'checked_label' => 'ON',
                    'unchecked_label' => 'OFF',
                    'container_width' => 80,
                    'class' => 'hide last'
                ),
                'choices' => array(
                    'no-repeat' => 'No repeat',
                    'repeat' => 'Repeat',
                    'repeat-x' => 'Repeat Horizontally',
                    'repeat-y' => 'Repeat Vertically'
                )
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_header_inner_bg_image_repeat']) ? $responsi_options['responsi_header_inner_bg_image_repeat'] : 'repeat',
                'sanitize_callback' => 'responsi_sanitize_choices',
                'transport' => 'postMessage'
            )
        );

        $header_controls_settings['responsi_header_inner_border_top'] = array(
            'control' => array(
                'label'      => __('Container Border - Top', 'responsi'),
                'section'    => 'header_style',
                'settings'   => 'multiple',
                'type'       => 'border'
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_header_inner_border_top']) ? $responsi_options['responsi_header_inner_border_top'] : array('width' => '0','style' => 'solid','color' => '#dbdbdb'),
                'sanitize_callback' => 'responsi_sanitize_border',
                'transport' => 'postMessage'
            )
        );

        $header_controls_settings['responsi_header_inner_border_bottom'] = array(
            'control' => array(
                'label'      => __('Container Border - Bottom', 'responsi'),
                'section'    => 'header_style',
                'settings'   => 'multiple',
                'type'       => 'border'
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_header_inner_border_bottom']) ? $responsi_options['responsi_header_inner_border_bottom'] : array('width' => '0','style' => 'solid','color' => '#dbdbdb'),
                'sanitize_callback' => 'responsi_sanitize_border',
                'transport' => 'postMessage'
            )
        );

        $header_controls_settings['responsi_header_inner_border_lr'] = array(
            'control' => array(
                'label'      => __('Border - Left / Right', 'responsi'),
                'section'    => 'header_style',
                'settings'   => 'multiple',
                'type'       => 'border'
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_header_inner_border_lr']) ? $responsi_options['responsi_header_inner_border_lr'] : array('width' => '0','style' => 'solid','color' => '#dbdbdb'),
                'sanitize_callback' => 'responsi_sanitize_border',
                'transport' => 'postMessage'
            )
        );

        $header_controls_settings['responsi_header_inner_box_shadow'] = array(
            'control' => array(
                'label'      => __('Border Shadow', 'responsi'),
                'section'    => 'header_style',
                'settings'   => 'multiple',
                'type'       => 'box_shadow'
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_header_inner_box_shadow']) ? $responsi_options['responsi_header_inner_box_shadow'] : array( 'onoff' => 'false' , 'h_shadow' => '0px' , 'v_shadow' => '0px', 'blur' => '5px' , 'spread' => '0px', 'color' => '#DBDBDB', 'inset' => '' ),
                'sanitize_callback' => 'responsi_sanitize_box_shadow',
                'transport' => 'postMessage'
            )
        );

        $header_controls_settings['responsi_header_inner_margin'] = array(
            'control' => array(
                'label'      => __('Margin', 'responsi'),
                'section'    => 'header_style',
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
                    isset($responsi_options['responsi_header_inner_margin_top']) ? $responsi_options['responsi_header_inner_margin_top'] : '0' ,
                    isset($responsi_options['responsi_header_inner_margin_bottom']) ? $responsi_options['responsi_header_inner_margin_bottom'] : '0',
                    isset($responsi_options['responsi_header_inner_margin_left']) ? $responsi_options['responsi_header_inner_margin_left'] : '0',
                    isset($responsi_options['responsi_header_inner_margin_right']) ? $responsi_options['responsi_header_inner_margin_right'] : '0'
                ),
                'sanitize_callback' => 'responsi_sanitize_numeric',
                'transport' => 'postMessage',
            )
        );

        $header_controls_settings['responsi_header_inner_padding'] = array(
            'control' => array(
                'label'      => __('Padding', 'responsi'),
                'section'    => 'header_style',
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
                    isset($responsi_options['responsi_header_inner_padding_top']) ? $responsi_options['responsi_header_inner_padding_top'] : '10' ,
                    isset($responsi_options['responsi_header_inner_padding_bottom']) ? $responsi_options['responsi_header_inner_padding_bottom'] : '10',
                    isset($responsi_options['responsi_header_inner_padding_left']) ? $responsi_options['responsi_header_inner_padding_left'] : '10',
                    isset($responsi_options['responsi_header_inner_padding_right']) ? $responsi_options['responsi_header_inner_padding_right'] : '10'
                ),
                'sanitize_callback' => 'responsi_sanitize_numeric',
                'transport' => 'postMessage',
            )
        );

        $header_controls_settings['lbheader3'] = array(
            'control' => array(
                'label'      => __('Header Widget Font', 'responsi'),
                'section'    => 'header_widgets',
                'type'       => 'ilabel'
            ),
            'setting' => array()
        );

        $header_controls_settings['responsi_font_header_widget_title'] = array(
            'control' => array(
                'label' => __('Title Font', 'responsi'),
                'section'    => 'header_widgets',
                'settings'   => 'multiple',
                'type'       => 'typography',
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_font_header_widget_title']) ? $responsi_options['responsi_font_header_widget_title'] : array('size' => '14','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#ffffff'),
                'sanitize_callback' => 'responsi_sanitize_typography',
                'transport' => 'postMessage'
            )
        );

        $header_controls_settings['responsi_font_header_widget_text'] = array(
            'control' => array(
                'label' => __('Content Font', 'responsi'),
                'section'    => 'header_widgets',
                'settings'   => 'multiple',
                'type'       => 'typography',
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_font_header_widget_text']) ? $responsi_options['responsi_font_header_widget_text'] : array('size' => '13','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#7c7c7c'),
                'sanitize_callback' => 'responsi_sanitize_typography',
                'transport' => 'postMessage'
            )
        );

        $header_controls_settings['responsi_font_header_widget_link'] = array(
            'control' => array(
                'label' => __('Linked Text Font', 'responsi'),
                'section'    => 'header_widgets',
                'settings'   => 'multiple',
                'type'       => 'typography',
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_font_header_widget_link']) ? $responsi_options['responsi_font_header_widget_link'] : array('size' => '13','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#7c7c7c'),
                'sanitize_callback' => 'responsi_sanitize_typography',
                'transport' => 'postMessage'
            )
        );

        $header_controls_settings['responsi_font_header_widget_link_hover'] = array(
            'control' => array(
                'label'      => __('Text Link Hover', 'responsi'),
                'section'    => 'header_widgets',
                'settings'   => 'responsi_font_header_widget_link_hover',
                'type'       => 'icolor'
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_font_header_widget_link_hover']) ? $responsi_options['responsi_font_header_widget_link_hover'] : '#ff6868',
                'sanitize_callback' => 'sanitize_hex_color',
                'transport' => 'postMessage'
            )
        );

        $header_controls_settings['responsi_font_header_widget_text_alignment'] = array(
            'control' => array(
                'label'      => __('Content Alignment', 'responsi'),
                'section'    => 'header_widgets',
                'settings'   => 'responsi_font_header_widget_text_alignment',
                'type'       => 'iradio',
                'input_attrs' => array(
                    'checked_label' => 'ON',
                    'unchecked_label' => 'OFF',
                    'container_width' => 80
                ),
                'choices' => array("left" => "Left", "center" => "Center", "right" => "Right", "justify" => "Justify")
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_font_header_widget_text_alignment']) ? $responsi_options['responsi_font_header_widget_text_alignment'] : 'left',
                'sanitize_callback' => 'responsi_sanitize_choices',
                'transport' => 'postMessage'
            )
        );

        $header_controls_settings['lbheader4'] = array(
            'control' => array(
                'label'      => __('Multi Widget Margin', 'responsi'),
                'description' =>  __('Horizontal margin between multiple widgets in the same header widget area', 'responsi'),
                'section'    => 'header_widgets',
                'type'       => 'ilabel'
            ),
            'setting' => array()
        );

        $header_controls_settings['responsi_header_widget_mobile_margin'] = array(
            'control' => array(
                'label'      => __('Widget Horizontal Margin', 'responsi'),
                'section'    => 'header_widgets',
                'settings'   => 'responsi_header_widget_mobile_margin',
                'type'       => 'icheckbox',
                'input_attrs' => array(
                    'class' => 'collapsed'
                )
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_header_widget_mobile_margin']) ? $responsi_options['responsi_header_widget_mobile_margin'] : 'true',
                'sanitize_callback' => 'responsi_sanitize_checkboxs',
                'transport' => 'postMessage'
            )
        );

        $header_controls_settings['responsi_header_widget_mobile_margin_between'] = array(
            'control' => array(
                'section'    => 'header_widgets',
                'settings'    => 'responsi_header_widget_mobile_margin_between',
                'type'       => 'itext',
                'input_attrs' => array(
                    'class' => 'hide last custom-itext',
                    'after_input' => __('Pixels', 'responsi'),
                )
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_header_widget_mobile_margin_between']) ? $responsi_options['responsi_header_widget_mobile_margin_between'] : '10',
                'sanitize_callback' => 'responsi_sanitize_numeric',
                'transport' => 'postMessage'
            )
        );

        $header_controls_settings = apply_filters('responsi_header_controls_settings', $header_controls_settings);
        $controls_settings = array_merge($controls_settings, $header_controls_settings);

        return  $controls_settings ;
    }
}
