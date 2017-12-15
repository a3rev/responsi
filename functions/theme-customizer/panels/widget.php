<?php
class Responsi_Customize_Widget_Sidebar
{

	public function __construct() {
		add_action( 'customize_preview_init', array( $this, 'responsi_customize_preview_init' ), 11 );
		add_filter( 'responsi_default_options', array( $this, 'responsi_controls_settings' ) );
		add_filter( 'responsi_customize_register_panels',  array( $this, 'responsi_panels' ) );
		add_filter( 'responsi_customize_register_sections',  array( $this, 'responsi_sections' ) );
		add_filter( 'responsi_customize_register_settings',  array( $this, 'responsi_controls_settings' ) );
	}

	public function responsi_customize_preview_init() {
		wp_enqueue_script( 'responsi-customize-widget' );
	}

	public function is_panel_widgets_active() {
		global $layout;
		$show_panel = true;
		if( isset( $layout ) && $layout == 'one-col' ){
			$show_panel = false;
		}
		return $show_panel;
	}

	public function responsi_panels( $panels ){
		$sidebar_panels = array();
		$sidebar_panels['sidebar_widget_settings_panel'] = array(
		    'title' => __('Sidebars and Widgets', 'responsi'),
		    'priority' => 3.5,
		    'active_callback' => array( $this, 'is_panel_widgets_active' )
		);
		$panels = array_merge($panels, $sidebar_panels);
		return  $panels ;
	}

	public function responsi_sections( $sections ){
		$widget_sections = array();
		$widget_sections['widget_container_settings'] = array(
		    'title' => __('Sidebars - Style', 'responsi'),
		    'priority' => 5,
		    'panel' => 'sidebar_widget_settings_panel',
		);
		$widget_sections['widget_settings'] = array(
		    'title' => __('Sidebar Widgets - Style', 'responsi'),
		    'priority' => 5,
		    'panel' => 'sidebar_widget_settings_panel',
		);
		$sections = array_merge($sections, $widget_sections);
		return  $sections ;
	}

	public function responsi_controls_settings( $controls_settings ){

		global $responsi_options;

		$widget_controls_settings = array();

		$widget_controls_settings['lbwidget1'] = array(
            'control' => array(
                'label'      => __('Sidebar Container', 'responsi'),
                'section'    => 'widget_container_settings',
                'type'       => 'ilabel'
            ),
            'setting' => array()
        );

        $widget_controls_settings['responsi_widget_container_bg'] = array(
            'control' => array(
                'label'      => __('Background Colour', 'responsi'),
                'section'    => 'widget_container_settings',
                'settings'   => 'multiple',
                'type'       => 'ibackground'
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_widget_container_bg']) ? $responsi_options['responsi_widget_container_bg'] : array( 'onoff' => 'false', 'color' => '#ffffff'),
                'sanitize_callback' => 'responsi_sanitize_background_color',
                'transport' => 'postMessage'
            )
        );
        $widget_controls_settings['responsi_enable_widget_container_bg_image'] = array(
            'control' => array(
                'label'      => __('Background Image', 'responsi'),
                'section'    => 'widget_container_settings',
                'settings'   => 'responsi_enable_widget_container_bg_image',
                'type'       => 'icheckbox',
                'input_attrs' => array(
                    'class' => 'collapsed'
                )
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_enable_widget_container_bg_image']) ? $responsi_options['responsi_enable_widget_container_bg_image'] : 'false',
                'sanitize_callback' => 'responsi_sanitize_checkboxs',
                'transport' => 'postMessage'
            )
        );

        $widget_controls_settings['responsi_widget_container_bg_image'] = array(
            'control' => array(
                'label'      => __('Image', 'responsi'),
                'section'    => 'widget_container_settings',
                'settings'   => 'responsi_widget_container_bg_image',
                'type'       => 'iupload',
                'input_attrs' => array(
                    'class' => 'hide'
                )
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_widget_container_bg_image']) ? $responsi_options['responsi_widget_container_bg_image'] : '',
                'sanitize_callback' => 'esc_url',
                'transport' => 'postMessage'
            )
        );

        $widget_controls_settings['responsi_widget_container_bg_position'] = array(
            'control' => array(
                'label'      => __('Image Alignment', 'responsi'),
                'description' => __( 'Supports absolute values left, right, center, top, bottom or pixel values e.g. 20px for inner container positioning of image.', 'responsi' ),
                'section'    => 'widget_container_settings',
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
                    isset($responsi_options['responsi_widget_container_bg_position_vertical']) ? $responsi_options['responsi_widget_container_bg_position_vertical'] : 'center' , 
                    isset($responsi_options['responsi_widget_container_bg_position_horizontal']) ? $responsi_options['responsi_widget_container_bg_position_horizontal'] : 'center'
                ),
                'sanitize_callback' => 'responsi_sanitize_background_position',
                'transport' => 'postMessage'
            )
        );

        $widget_controls_settings['responsi_widget_container_bg_image_repeat'] = array(
            'control' => array(
                'label'      => __('Image Repeat', 'responsi'),
                'section'    => 'widget_container_settings',
                'settings'   => 'responsi_widget_container_bg_image_repeat',
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
                'default'       => isset($responsi_options['responsi_widget_container_bg_image_repeat']) ? $responsi_options['responsi_widget_container_bg_image_repeat'] : 'repeat',
                'sanitize_callback' => 'responsi_sanitize_choices',
                'transport' => 'postMessage'
            )
        );
        $widget_controls_settings['responsi_widget_container_border_top'] = array(
            'control' => array(
                'label' => __('Border - Top', 'responsi'),
                'section'    => 'widget_container_settings',
                'settings'   => 'multiple',
                'type'       => 'border'
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_widget_container_border_top']) ? $responsi_options['responsi_widget_container_border_top'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB'),
                'sanitize_callback' => 'responsi_sanitize_border',
                'transport' => 'postMessage'
            )
        );
        $widget_controls_settings['responsi_widget_container_border_bottom'] = array(
            'control' => array(
                'label' => __('Border - Bottom', 'responsi'),
                'section'    => 'widget_container_settings',
                'settings'   => 'multiple',
                'type'       => 'border'
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_widget_container_border_bottom']) ? $responsi_options['responsi_widget_container_border_bottom'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB'),
                'sanitize_callback' => 'responsi_sanitize_border',
                'transport' => 'postMessage'
            )
        );
        $widget_controls_settings['responsi_widget_container_border_lr'] = array(
            'control' => array(
                'label' => __('Border - Left / Right', 'responsi'),
                'section'    => 'widget_container_settings',
                'settings'   => 'multiple',
                'type'       => 'border'
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_widget_container_border_lr']) ? $responsi_options['responsi_widget_container_border_lr'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB'),
                'sanitize_callback' => 'responsi_sanitize_border',
                'transport' => 'postMessage'
            )
        );
        $widget_controls_settings['responsi_widget_container_border_radius_tl'] = array(
            'control' => array(
                'label'      => __('Border Corner - Top Left', 'responsi'),
                'section'    => 'widget_container_settings',
                'settings'   => 'multiple',
                'type'       => 'border_radius'
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_widget_container_border_radius_tl']) ? $responsi_options['responsi_widget_container_border_radius_tl'] : array('corner' => 'square','rounded_value' => '0'),
                'sanitize_callback' => 'responsi_sanitize_border_radius',
                'transport' => 'postMessage'
            )
        );
        $widget_controls_settings['responsi_widget_container_border_radius_tr'] = array(
            'control' => array(
                'label'      => __('Border Corner - Top Right', 'responsi'),
                'section'    => 'widget_container_settings',
                'settings'   => 'multiple',
                'type'       => 'border_radius'
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_widget_container_border_radius_tr']) ? $responsi_options['responsi_widget_container_border_radius_tr'] : array('corner' => 'square','rounded_value' => '0'),
                'sanitize_callback' => 'responsi_sanitize_border_radius',
                'transport' => 'postMessage'
            )
        );
        $widget_controls_settings['responsi_widget_container_border_radius_bl'] = array(
            'control' => array(
                'label'      => __('Border Corner - Bottom Left', 'responsi'),
                'section'    => 'widget_container_settings',
                'settings'   => 'multiple',
                'type'       => 'border_radius'
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_widget_container_border_radius_bl']) ? $responsi_options['responsi_widget_container_border_radius_bl'] : array('corner' => 'square','rounded_value' => '0'),
                'sanitize_callback' => 'responsi_sanitize_border_radius',
                'transport' => 'postMessage'
            )
        );
        $widget_controls_settings['responsi_widget_container_border_radius_br'] = array(
            'control' => array(
                'label'      => __('Border Corner - Bottom Right', 'responsi'),
                'section'    => 'widget_container_settings',
                'settings'   => 'multiple',
                'type'       => 'border_radius'
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_widget_container_border_radius_br']) ? $responsi_options['responsi_widget_container_border_radius_br'] : array('corner' => 'square','rounded_value' => '0'),
                'sanitize_callback' => 'responsi_sanitize_border_radius',
                'transport' => 'postMessage'
            )
        );

        $widget_controls_settings['responsi_widget_container_box_shadow'] = array(
            'control' => array(
                'label'      => __('Border Shadow', 'responsi'),
                'section'    => 'widget_container_settings',
                'settings'   => 'multiple',
                'type'       => 'box_shadow'
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_widget_container_box_shadow']) ? $responsi_options['responsi_widget_container_box_shadow'] : array( 'onoff' => 'false' , 'h_shadow' => '0px' , 'v_shadow' => '0px', 'blur' => '8px' , 'spread' => '0px', 'color' => '#DBDBDB', 'inset' => '' ),
                'sanitize_callback' => 'responsi_sanitize_box_shadow',
                'transport' => 'postMessage'
            )
        );

        $widget_controls_settings['responsi_widget_container_margin'] = array(
            'control' => array(
                'label'      => __('Margin', 'responsi'),
                'section'    => 'widget_container_settings',
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
                    isset($responsi_options['responsi_widget_container_margin_top']) ? $responsi_options['responsi_widget_container_margin_top'] : '0' , 
                    isset($responsi_options['responsi_widget_container_margin_bottom']) ? $responsi_options['responsi_widget_container_margin_bottom'] : '0',
                    isset($responsi_options['responsi_widget_container_margin_left']) ? $responsi_options['responsi_widget_container_margin_left'] : '0',
                    isset($responsi_options['responsi_widget_container_margin_right']) ? $responsi_options['responsi_widget_container_margin_right'] : '0'
                ),
                'sanitize_callback' => 'responsi_sanitize_numeric',
                'transport' => 'postMessage',
            )
        );

        $widget_controls_settings['responsi_widget_container_padding'] = array(
            'control' => array(
                'label'      => __('Padding', 'responsi'),
                'section'    => 'widget_container_settings',
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
                    isset($responsi_options['responsi_widget_container_padding_top']) ? $responsi_options['responsi_widget_container_padding_top'] : '0' , 
                    isset($responsi_options['responsi_widget_container_padding_bottom']) ? $responsi_options['responsi_widget_container_padding_bottom'] : '0',
                    isset($responsi_options['responsi_widget_container_padding_left']) ? $responsi_options['responsi_widget_container_padding_left'] : '0',
                    isset($responsi_options['responsi_widget_container_padding_right']) ? $responsi_options['responsi_widget_container_padding_right'] : '0'
                ),
                'sanitize_callback' => 'responsi_sanitize_numeric',
                'transport' => 'postMessage',
            )
        );

		$widget_controls_settings['lbwidget2'] = array(
			'control' => array(
			    'label'      => __('Sidebar Widget Style', 'responsi'),
			    'section'    => 'widget_settings',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);
		$widget_controls_settings['responsi_widget_bg'] = array(
			'control' => array(
			    'label'      => __('Background Color', 'responsi'),
			    'section'    => 'widget_settings',
			    'settings'   => 'multiple',
			    'type'       => 'ibackground'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_widget_bg']) ? $responsi_options['responsi_widget_bg'] : array( 'onoff' => 'false', 'color' => '#ffffff'),
			    'sanitize_callback' => 'responsi_sanitize_background_color',
                'transport'	=> 'postMessage'
			)
		);
		$widget_controls_settings['responsi_widget_border'] = array(
			'control' => array(
			    'label' => __('Border', 'responsi'),
			    'section'    => 'widget_settings',
			    'settings'   => 'multiple',
			    'type'       => 'border'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_widget_border']) ? $responsi_options['responsi_widget_border'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB'),
			    'sanitize_callback' => 'responsi_sanitize_border',
                'transport'	=> 'postMessage'
			)
		);
		$widget_controls_settings['responsi_widget_border_radius'] = array(
			'control' => array(
			    'label'      => __('Border Corner', 'responsi'),
			    'section'    => 'widget_settings',
			    'settings'   => 'multiple',
			    'type'       => 'border_radius'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_widget_border_radius']) ? $responsi_options['responsi_widget_border_radius'] : array('corner' => 'square','rounded_value' => '0'),
			    'sanitize_callback' => 'responsi_sanitize_border_radius',
                'transport'	=> 'postMessage'
			)
		);
		$widget_controls_settings['responsi_widget_box_shadow'] = array(
			'control' => array(
			    'label'      => __('Border Shadow', 'responsi'),
			    'section'    => 'widget_settings',
			    'settings'   => 'multiple',
			    'type'       => 'box_shadow'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_widget_box_shadow']) ? $responsi_options['responsi_widget_box_shadow'] : array( 'onoff' => 'false' , 'h_shadow' => '0px' , 'v_shadow' => '0px', 'blur' => '8px' , 'spread' => '0px', 'color' => '#DBDBDB', 'inset' => '' ),
			    'sanitize_callback' => 'responsi_sanitize_box_shadow',
                'transport'	=> 'postMessage'
			)
		);
		$widget_controls_settings['responsi_widget_margin_between'] = array(
			'control' => array(
			    'label'      => __('Widget Horizontal Margin', 'responsi'),
			    'section'    => 'widget_settings',
			    'settings'    => 'responsi_widget_margin_between',
			    'type'       => 'itext',
                'input_attrs' => array(
                    'class' => 'custom-itext',
                    'after_input' => __('Pixels', 'responsi'),
                )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_widget_margin_between']) ? $responsi_options['responsi_widget_margin_between'] : '20',
			    'sanitize_callback' => 'responsi_sanitize_numeric',
                'transport'	=> 'postMessage'
			)
		);
		$widget_controls_settings['responsi_widget_padding'] = array(
			'control' => array(
			    'label'      => __('Padding', 'responsi'),
			    'section'    => 'widget_settings',
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
				'default'		=> array( 
					isset($responsi_options['responsi_widget_padding_top']) ? $responsi_options['responsi_widget_padding_top'] : '0' , 
					isset($responsi_options['responsi_widget_padding_bottom']) ? $responsi_options['responsi_widget_padding_bottom'] : '0',
					isset($responsi_options['responsi_widget_padding_left']) ? $responsi_options['responsi_widget_padding_left'] : '0',
					isset($responsi_options['responsi_widget_padding_right']) ? $responsi_options['responsi_widget_padding_right'] : '0'
				),
                'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage',
			)
		);
		$widget_controls_settings['lbwidget3'] = array(
			'control' => array(
			    'label'      => __('Widget Title Font', 'responsi'),
			    'section'    => 'widget_settings',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);
		$widget_controls_settings['responsi_widget_font_title'] = array(
			'control' => array(
			    'label' => __('Title Font', 'responsi'),
			    'section'    => 'widget_settings',
			    'settings'   => 'multiple',
			    'type'       => 'typography'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_widget_font_title']) ? $responsi_options['responsi_widget_font_title'] : array('size' => '15','line_height' => '1.5','face' => 'Open Sans','style' => 'bold','color' => '#f9bb02'),
			    'sanitize_callback' => 'responsi_sanitize_typography',
                'transport'	=> 'postMessage'
			)
		);
		$widget_controls_settings['responsi_widget_title_text_alignment'] = array(
			'control' => array(
			    'label'      => __('Title Alignment', 'responsi'),
			    'section'    => 'widget_settings',
			    'settings'   => 'responsi_widget_title_text_alignment',
			    'type'       => 'iradio',
			    'input_attrs' => array(
					'checked_label' => 'ON',
					'unchecked_label' => 'OFF',
					'container_width' => 80
		        ),
			    'choices' => array("left" => "Left", "center" => "Center", "right" => "Right", "justify" => "Justify")
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_widget_title_text_alignment']) ? $responsi_options['responsi_widget_title_text_alignment'] : 'right',
			    'sanitize_callback' => 'responsi_sanitize_choices',
                'transport'	=> 'postMessage'
			)
		);
		$widget_controls_settings['responsi_widget_title_transform'] = array(
			'control' => array(
			    'label'      => __('Title Transformation', 'responsi'),
			    'section'    => 'widget_settings',
			    'settings'   => 'responsi_widget_title_transform',
			    'type'       => 'iradio',
			    'input_attrs' => array(
					'checked_label' => 'ON',
					'unchecked_label' => 'OFF',
					'container_width' => 80
		        ),
			    'choices' => array( "none" => "None","uppercase" => "Uppercase", "lowercase" => "Lowercase")
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_widget_title_transform']) ? $responsi_options['responsi_widget_title_transform'] : 'uppercase',
			    'sanitize_callback' => 'responsi_sanitize_choices',
                'transport'	=> 'postMessage'
			)
		);
		$widget_controls_settings['lbwidget4'] = array(
			'control' => array(
			    'label'      => __('Widget Title Container', 'responsi'),
			    'section'    => 'widget_settings',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);

		$widget_controls_settings['responsi_widget_title_bg'] = array(
			'control' => array(
			    'label'      => __('Background Color', 'responsi'),
			    'section'    => 'widget_settings',
			    'settings'   => 'multiple',
			    'type'       => 'ibackground'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_widget_title_bg']) ? $responsi_options['responsi_widget_title_bg'] : array( 'onoff' => 'false', 'color' => '#ffffff'),
			    'sanitize_callback' => 'responsi_sanitize_background_color',
                'transport'	=> 'postMessage'
			)
		);
		$widget_controls_settings['responsi_widget_title_border_top'] = array(
			'control' => array(
			    'label' => __('Border - Top', 'responsi'),
			    'section'    => 'widget_settings',
			    'settings'   => 'multiple',
			    'type'       => 'border'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_widget_title_border_top']) ? $responsi_options['responsi_widget_title_border_top'] : array('width' => '0','style' => 'solid','color' => '#f9bb02'),
			    'sanitize_callback' => 'responsi_sanitize_border',
                'transport'	=> 'postMessage'
			)
		);
		$widget_controls_settings['responsi_widget_title_border_bottom'] = array(
			'control' => array(
			    'label' => __('Border - Bottom', 'responsi'),
			    'section'    => 'widget_settings',
			    'settings'   => 'multiple',
			    'type'       => 'border'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_widget_title_border_bottom']) ? $responsi_options['responsi_widget_title_border_bottom'] : array('width' => '2','style' => 'double','color' => '#f9bb02'),
			    'sanitize_callback' => 'responsi_sanitize_border',
                'transport'	=> 'postMessage'
			)
		);
		$widget_controls_settings['responsi_widget_title_border_left'] = array(
			'control' => array(
			    'label' => __('Border - Left', 'responsi'),
			    'section'    => 'widget_settings',
			    'settings'   => 'multiple',
			    'type'       => 'border'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_widget_title_border_left']) ? $responsi_options['responsi_widget_title_border_left'] : array('width' => '0','style' => 'solid','color' => '#f9bb02'),
			    'sanitize_callback' => 'responsi_sanitize_border',
                'transport'	=> 'postMessage'
			)
		);
		$widget_controls_settings['responsi_widget_title_border_right'] = array(
			'control' => array(
			    'label' => __('Border - Right', 'responsi'),
			    'section'    => 'widget_settings',
			    'settings'   => 'multiple',
			    'type'       => 'border'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_widget_title_border_right']) ? $responsi_options['responsi_widget_title_border_right'] : array('width' => '0','style' => 'solid','color' => '#f9bb02'),
			    'sanitize_callback' => 'responsi_sanitize_border',
                'transport'	=> 'postMessage'
			)
		);
		$widget_controls_settings['responsi_widget_title_border_radius_tl'] = array(
			'control' => array(
			    'label'      => __('Border Corner - Top Left', 'responsi'),
			    'section'    => 'widget_settings',
			    'settings'   => 'multiple',
			    'type'       => 'border_radius'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_widget_title_border_radius_tl']) ? $responsi_options['responsi_widget_title_border_radius_tl'] : array('corner' => 'square','rounded_value' => '0'),
			    'sanitize_callback' => 'responsi_sanitize_border_radius',
                'transport'	=> 'postMessage'
			)
		);
		$widget_controls_settings['responsi_widget_title_border_radius_tr'] = array(
			'control' => array(
			    'label'      => __('Border Corner - Top Right', 'responsi'),
			    'section'    => 'widget_settings',
			    'settings'   => 'multiple',
			    'type'       => 'border_radius'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_widget_title_border_radius_tr']) ? $responsi_options['responsi_widget_title_border_radius_tr'] : array('corner' => 'square','rounded_value' => '0'),
			    'sanitize_callback' => 'responsi_sanitize_border_radius',
                'transport'	=> 'postMessage'
			)
		);
		$widget_controls_settings['responsi_widget_title_border_radius_bl'] = array(
			'control' => array(
			    'label'      => __('Border Corner - Bottom Left', 'responsi'),
			    'section'    => 'widget_settings',
			    'settings'   => 'multiple',
			    'type'       => 'border_radius'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_widget_title_border_radius_bl']) ? $responsi_options['responsi_widget_title_border_radius_bl'] : array('corner' => 'square','rounded_value' => '0'),
			    'sanitize_callback' => 'responsi_sanitize_border_radius',
                'transport'	=> 'postMessage'
			)
		);
		$widget_controls_settings['responsi_widget_title_border_radius_br'] = array(
			'control' => array(
			    'label'      => __('Border Corner - Bottom Right', 'responsi'),
			    'section'    => 'widget_settings',
			    'settings'   => 'multiple',
			    'type'       => 'border_radius'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_widget_title_border_radius_br']) ? $responsi_options['responsi_widget_title_border_radius_br'] : array('corner' => 'square','rounded_value' => '0'),
			    'sanitize_callback' => 'responsi_sanitize_border_radius',
                'transport'	=> 'postMessage'
			)
		);
		$widget_controls_settings['responsi_widget_title_box_shadow'] = array(
			'control' => array(
			    'label'      => __('Border Shadow', 'responsi'),
			    'section'    => 'widget_settings',
			    'settings'   => 'multiple',
			    'type'       => 'box_shadow'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_widget_title_box_shadow']) ? $responsi_options['responsi_widget_title_box_shadow'] : array( 'onoff' => 'false' , 'h_shadow' => '0px' , 'v_shadow' => '0px', 'blur' => '0px' , 'spread' => '0px', 'color' => '#DBDBDB', 'inset' => 'inset' ),
			    'sanitize_callback' => 'responsi_sanitize_box_shadow',
                'transport'	=> 'postMessage'
			)
		);
		$widget_controls_settings['responsi_widget_title_align'] = array(
			'control' => array(
			    'label'      => __('Title Container Align', 'responsi'),
			    'section'    => 'widget_settings',
			    'settings'   => 'responsi_widget_title_align',
			    'type'       => 'iradio',
			    'input_attrs' => array(
					'checked_label' => 'ON',
					'unchecked_label' => 'OFF',
					'container_width' => 80
		        ),
			    'choices' => array("right" => "Right", "left" => "Left","center" => "Center","stretched" => "Stretched")
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_widget_title_align']) ? $responsi_options['responsi_widget_title_align'] : 'stretched',
			    'sanitize_callback' => 'responsi_sanitize_choices',
                'transport'	=> 'postMessage'
			)
		);
        $widget_controls_settings['responsi_widget_title_margin'] = array(
            'control' => array(
                'label'      => __('Margin', 'responsi'),
                'section'    => 'widget_settings',
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
                    isset($responsi_options['responsi_widget_title_margin_top']) ? $responsi_options['responsi_widget_title_margin_top'] : '0' , 
                    isset($responsi_options['responsi_widget_title_margin_bottom']) ? $responsi_options['responsi_widget_title_margin_bottom'] : '5',
                    isset($responsi_options['responsi_widget_title_margin_left']) ? $responsi_options['responsi_widget_title_margin_left'] : '0',
                    isset($responsi_options['responsi_widget_title_margin_right']) ? $responsi_options['responsi_widget_title_margin_right'] : '0'
                ),
                'sanitize_callback' => 'responsi_sanitize_numeric',
                'transport' => 'postMessage',
            )
        );
		$widget_controls_settings['responsi_widget_title_padding'] = array(
			'control' => array(
			    'label'      => __('Padding', 'responsi'),
			    'section'    => 'widget_settings',
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
				'default'		=> array( 
					isset($responsi_options['responsi_widget_title_padding_top']) ? $responsi_options['responsi_widget_title_padding_top'] : '0' , 
					isset($responsi_options['responsi_widget_title_padding_bottom']) ? $responsi_options['responsi_widget_title_padding_bottom'] : '5',
					isset($responsi_options['responsi_widget_title_padding_left']) ? $responsi_options['responsi_widget_title_padding_left'] : '0',
					isset($responsi_options['responsi_widget_title_padding_right']) ? $responsi_options['responsi_widget_title_padding_right'] : '0'
				),
                'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage',
			)
		);
		$widget_controls_settings['lbwidget5'] = array(
			'control' => array(
			    'label'      => __('Widget Content Styling', 'responsi'),
			    'section'    => 'widget_settings',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);
		$widget_controls_settings['responsi_widget_font_text'] = array(
			'control' => array(
			    'label' => __('Font', 'responsi'),
			    'section'    => 'widget_settings',
			    'settings'   => 'multiple',
			    'type'       => 'typography'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_widget_font_text']) ? $responsi_options['responsi_widget_font_text'] : array('size' => '13','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#555555'),
			    'sanitize_callback' => 'responsi_sanitize_typography',
                'transport'	=> 'postMessage'
			)
		);
        $widget_controls_settings['responsi_widget_link_color'] = array(
            'control' => array(
                'label'      => __('Text Link', 'responsi'),
                'section'    => 'widget_settings',
                'settings'   => 'responsi_widget_link_color',
                'type'       => 'icolor'
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_widget_link_color']) ? $responsi_options['responsi_widget_link_color'] : '#009ee0',
                'sanitize_callback' => 'sanitize_hex_color',
                'transport' => 'postMessage'
            )
        );
        $widget_controls_settings['responsi_widget_link_hover_color'] = array(
            'control' => array(
                'label'      => __('Text Link Hover', 'responsi'),
                'section'    => 'widget_settings',
                'settings'   => 'responsi_widget_link_hover_color',
                'type'       => 'icolor'
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_widget_link_hover_color']) ? $responsi_options['responsi_widget_link_hover_color'] : '#ff6868',
                'sanitize_callback' => 'sanitize_hex_color',
                'transport' => 'postMessage'
            )
        );
        $widget_controls_settings['responsi_widget_link_visited_color'] = array(
            'control' => array(
                'label'      => __('Text Link Clicked', 'responsi'),
                'section'    => 'widget_settings',
                'settings'   => 'responsi_widget_link_visited_color',
                'type'       => 'icolor'
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_widget_link_visited_color']) ? $responsi_options['responsi_widget_link_visited_color'] : '#009ee0',
                'sanitize_callback' => 'sanitize_hex_color',
                'transport' => 'postMessage'
            )
        );
		$widget_controls_settings['responsi_widget_font_text_alignment'] = array(
			'control' => array(
			    'label'      => __('Alignment', 'responsi'),
			    'section'    => 'widget_settings',
			    'settings'   => 'responsi_widget_font_text_alignment',
			    'type'       => 'iradio',
			    'input_attrs' => array(
					'checked_label' => 'ON',
					'unchecked_label' => 'OFF',
					'container_width' => 80
		        ),
			    'choices' => array("left" => "Left", "center" => "Center", "right" => "Right", "justify" => "Justify")
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_widget_font_text_alignment']) ? $responsi_options['responsi_widget_font_text_alignment'] : 'left',
			    'sanitize_callback' => 'responsi_sanitize_choices',
                'transport'	=> 'postMessage'
			)
		);
		$widget_controls_settings['responsi_widget_content_padding'] = array(
			'control' => array(
			    'label'      => __('Padding', 'responsi'),
			    'section'    => 'widget_settings',
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
				'default'		=> array( 
					isset($responsi_options['responsi_widget_content_padding_top']) ? $responsi_options['responsi_widget_content_padding_top'] : '0' , 
					isset($responsi_options['responsi_widget_content_padding_bottom']) ? $responsi_options['responsi_widget_content_padding_bottom'] : '0',
					isset($responsi_options['responsi_widget_content_padding_left']) ? $responsi_options['responsi_widget_content_padding_left'] : '0',
					isset($responsi_options['responsi_widget_content_padding_right']) ? $responsi_options['responsi_widget_content_padding_right'] : '0'
				),
                'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage',
			)
		);
		$widget_controls_settings = apply_filters( 'responsi_widget_controls_settings', $widget_controls_settings );
		$controls_settings = array_merge($controls_settings, $widget_controls_settings);
		return  $controls_settings ;
	}
}

new Responsi_Customize_Widget_Sidebar();
?>