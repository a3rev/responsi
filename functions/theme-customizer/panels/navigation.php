<?php

namespace A3Rev\Responsi;

class Navigation
{

	public function __construct() {
		add_action( 'customize_preview_init', array( $this, 'responsi_customize_preview_init' ), 11 );
		add_filter( 'responsi_default_options', array( $this, 'responsi_controls_settings' ) );
		add_filter( 'responsi_customize_register_panels',  array( $this, 'responsi_panels' ) );
		add_filter( 'responsi_customize_register_sections',  array( $this, 'responsi_sections' ) );
		add_filter( 'responsi_customize_register_settings',  array( $this, 'responsi_controls_settings' ) );
	}

	public function responsi_customize_preview_init() {
		wp_enqueue_script( 'responsi-customize-navigation' );
	}

	public function responsi_panels( $panels ){
		$navigation_panels = array();
		$navigation_panels['navigation_settings_panel'] = array(
		    'title' => __('Navigation Bars', 'responsi'),
		    'priority' => 3,
		);
		$panels = array_merge($panels, $navigation_panels);
		return  $panels ;
	}

	public function responsi_sections( $sections ){
		$navigation_sections = array();
		$navigation_sections['navigation_primary'] = array(
		    'title' => __('Nav Bar - Primary', 'responsi'),
		    'priority' => 2,
		    'panel' => 'navigation_settings_panel',
		);
		$navigation_sections['navigation_primary_dropdown'] = array(
		    'title' => __('Nav Bar - Dropdown', 'responsi'),
		    'priority' => 3,
		    'panel' => 'navigation_settings_panel',
		);
		$navigation_sections['navigation_primary_mobile'] = array(
		    'title' => __('Nav Bar - Mobile', 'responsi'),
		    'priority' => 4,
		    'panel' => 'navigation_settings_panel',
		);
		$sections = array_merge($sections, $navigation_sections);
		return  $sections ;
	}

	public function responsi_controls_settings( $controls_settings ){

		$_default = apply_filters( 'default_settings_options', false );
		
		if( $_default ){
			$responsi_options = array();
		}else{
			global $responsi_options;
		}

		$navigation_controls_settings = array();

		//Navi Primary
		$navigation_controls_settings['lbnav1'] = array(
			'control' => array(
			    'label'      => __('Primary Nav Bar (PNB) Container', 'responsi'),
			    'section'    => 'navigation_primary',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);

		$navigation_controls_settings['responsi_container_nav_bg'] = array(
			'control' => array(
			    'label'      => __('Background Color', 'responsi'),
			    'section'    => 'navigation_primary',
			    'settings'   => 'multiple',
			    'type'       => 'ibackground'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_container_nav_bg']) ? $responsi_options['responsi_container_nav_bg'] : array( 'onoff' => 'true', 'color' => '#009ee0'),
			    'sanitize_callback' => 'responsi_sanitize_background_color',
			    'transport'	=> 'postMessage'
			)
		);

		$navigation_controls_settings['responsi_enable_container_nav_bg_image'] = array(
			'control' => array(
			    'label'      => __('Background Image', 'responsi'),
			    'section'    => 'navigation_primary',
			    'settings'   => 'responsi_enable_container_nav_bg_image',
			    'type'       => 'icheckbox',
			    'input_attrs' => array(
			    	'class' => 'collapsed'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_enable_container_nav_bg_image']) ? $responsi_options['responsi_enable_container_nav_bg_image'] : 'false',
			    'sanitize_callback' => 'responsi_sanitize_checkboxs',
			    'transport'	=> 'postMessage'
			)
		);

		$navigation_controls_settings['responsi_container_bg_image'] = array(
			'control' => array(
			    'label'      => __('Image', 'responsi'),
			    'section'    => 'navigation_primary',
			    'settings'   => 'responsi_container_bg_image',
			    'type'       => 'iupload',
			    'input_attrs' => array(
			    	'class' => 'hide'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_container_bg_image']) ? $responsi_options['responsi_container_bg_image'] : '',
			    'sanitize_callback' => 'esc_url',
			    'transport'	=> 'postMessage'
			)
		);

		$navigation_controls_settings['responsi_container_bg_image_size_on'] = array(
            'control' => array(
                'label'      => __('Image Resizer', 'responsi'),
                'section'    => 'navigation_primary',
                'settings'   => 'responsi_container_bg_image_size_on',
                'type'       => 'icheckbox',
                'input_attrs' => array(
                    'class' => 'hide collapsed-custom-sub'
                )
            ),
            'setting' => array(
                'sanitize_callback' => 'responsi_sanitize_checkboxs',
                'default'       => isset($responsi_options['responsi_container_bg_image_size_on']) ? $responsi_options['responsi_container_bg_image_size_on'] : 'false',
                'transport' => 'postMessage'
            )
        );

        $navigation_controls_settings['responsi_container_bg_image_size'] = array(
            'control' => array(
                'label'      => __('Image Size', 'responsi'),
                //'description'      => __('Supported values are auto, percentage e.g 50% and pixels e.g. 20px', 'responsi'),
                'section'    => 'navigation_primary',
                'settings'   => 'multitext',
                'type'       => 'multitext',
                'choices' => array(
                    'width' => 'Width',
                    'height' => 'Height'
                ),
                'input_attrs' => array(
                    'class' => 'hide hide-custom-sub hide-custom-sub-last'
                ),
            ),
            'setting' => array(
                'sanitize_callback' => 'responsi_sanitize_background_size',
                'default'       => array( 
                    isset($responsi_options['responsi_container_bg_image_size_width']) ? $responsi_options['responsi_container_bg_image_size_width'] : '100%' , 
                    isset($responsi_options['responsi_container_bg_image_size_height']) ? $responsi_options['responsi_container_bg_image_size_height'] : 'auto'
                ),
                'transport' => 'postMessage'
            )
        );

		$navigation_controls_settings['responsi_container_bg_position'] = array(
			'control' => array(
			    'label'      => __('Image Alignment', 'responsi'),
			    'description' => __( 'Supports absolute values left, right, center, top, bottom or pixel values e.g. 20px for inner container positioning of image', 'responsi' ),
			    'section'    => 'navigation_primary',
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
				'default'		=> array( 
					isset($responsi_options['responsi_container_bg_position_vertical']) ? $responsi_options['responsi_container_bg_position_vertical'] : 'center' , 
					isset($responsi_options['responsi_container_bg_position_horizontal']) ? $responsi_options['responsi_container_bg_position_horizontal'] : 'center'
				),
				'sanitize_callback' => 'responsi_sanitize_background_position',
			    'transport'	=> 'postMessage'
			)
		);

		$navigation_controls_settings['responsi_container_bg_image_repeat'] = array(
			'control' => array(
			    'label'      => __('Image Repeat', 'responsi'),
			    'section'    => 'navigation_primary',
			    'settings'   => 'responsi_container_bg_image_repeat',
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
			    'default'		=> isset($responsi_options['responsi_container_bg_image_repeat']) ? $responsi_options['responsi_container_bg_image_repeat'] : 'repeat',
			    'sanitize_callback' => 'responsi_sanitize_choices',
			    'transport'	=> 'postMessage'
			)
		);
		$navigation_controls_settings['responsi_container_nav_border_top'] = array(
			'control' => array(
			    'label' => __('Border - Top', 'responsi'),
			    'section'    => 'navigation_primary',
			    'settings'   => 'multiple',
			    'type'       => 'border'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_container_nav_border_top']) ? $responsi_options['responsi_container_nav_border_top'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);
		$navigation_controls_settings['responsi_container_nav_border_bottom'] = array(
			'control' => array(
			    'label' => __('Border - Bottom', 'responsi'),
			    'section'    => 'navigation_primary',
			    'settings'   => 'multiple',
			    'type'       => 'border'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_container_nav_border_bottom']) ? $responsi_options['responsi_container_nav_border_bottom'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);
		$navigation_controls_settings['responsi_container_nav_border_lr'] = array(
			'control' => array(
			    'label' => __('Border - Left / Right', 'responsi'),
			    'section'    => 'navigation_primary',
			    'settings'   => 'multiple',
			    'type'       => 'border'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_container_nav_border_lr']) ? $responsi_options['responsi_container_nav_border_lr'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);

		$navigation_controls_settings['responsi_container_nav_border_radius'] = array(
            'control' => array(
                'label' => __('Border Corner', 'responsi'),
                'section' => 'navigation_primary',
                'settings' => 'multiple',
                'type' => 'border_radius',
            ),
            'setting' => array(
            
                'sanitize_callback' => 'responsi_sanitize_border_radius',
                'default' => isset($responsi_options['responsi_container_nav_border_radius']) ? $responsi_options['responsi_container_nav_border_radius'] : array(
                    'corner' => 'rounded',
                    'rounded_value' => '0'
                ),
                'transport'   => 'postMessage'
            )
        );

		$navigation_controls_settings['responsi_nav_box_shadow'] = array(
			'control' => array(
			    'label'      => __('Border Shadow', 'responsi'),
			    'section'    => 'navigation_primary',
			    'settings'   => 'multiple',
			    'type'       => 'box_shadow'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_nav_box_shadow']) ? $responsi_options['responsi_nav_box_shadow'] : array( 'onoff' => 'false' , 'h_shadow' => '0px' , 'v_shadow' => '0px', 'blur' => '8px' , 'spread' => '0px', 'color' => '#DBDBDB', 'inset' => '' ),
			    'sanitize_callback' => 'responsi_sanitize_box_shadow',
			    'transport'	=> 'postMessage'
			)
		);

		$navigation_controls_settings['responsi_container_nav_margin'] = array(
			'control' => array(
			    'label'      => __('Border Margin', 'responsi'),
			    'section'    => 'navigation_primary',
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
					isset($responsi_options['responsi_container_nav_margin_top']) ? $responsi_options['responsi_container_nav_margin_top'] : '0' , 
					isset($responsi_options['responsi_container_nav_margin_bottom']) ? $responsi_options['responsi_container_nav_margin_bottom'] : '0',
					isset($responsi_options['responsi_container_nav_margin_left']) ? $responsi_options['responsi_container_nav_margin_left'] : '0',
					isset($responsi_options['responsi_container_nav_margin_right']) ? $responsi_options['responsi_container_nav_margin_right'] : '0'
				),
				'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage',
			)
		);

		$navigation_controls_settings['responsi_container_nav_padding'] = array(
			'control' => array(
			    'label'      => __('Border Padding', 'responsi'),
			    'section'    => 'navigation_primary',
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
					isset($responsi_options['responsi_container_nav_padding_top']) ? $responsi_options['responsi_container_nav_padding_top'] : '0' , 
					isset($responsi_options['responsi_container_nav_padding_bottom']) ? $responsi_options['responsi_container_nav_padding_bottom'] : '0',
					isset($responsi_options['responsi_container_nav_padding_left']) ? $responsi_options['responsi_container_nav_padding_left'] : '0',
					isset($responsi_options['responsi_container_nav_padding_right']) ? $responsi_options['responsi_container_nav_padding_right'] : '0'
				),
				'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage',
			)
		);

		$navigation_controls_settings['lbhex33'] = array(
            'control' => array(
                'label' => __('Mobile Settings', 'responsi'),
                'section' => 'navigation_primary',
                'type' => 'ilabel',
                'input_attrs' => array(
                    'class' => 'ilabel2'
                )
            ),
            'setting' => array(
            
            )
        );

        $navigation_controls_settings['responsi_container_nav_mobile_margin'] = array(
            'control' => array(
                'label' => __('Margin', 'responsi'),
                'section' => 'navigation_primary',
                'settings' => 'multitext',
                'type' => 'multitext',
                'choices' => array(
                    'top' => 'Top',
                    'bottom' => 'Bottom',
                    'left' => 'Left',
                    'right' => 'Right'
                ),
            ),
            'setting' => array(
            
                'sanitize_callback' => 'responsi_sanitize_numeric',
                'default' => array(
                    isset($responsi_options['responsi_container_nav_mobile_margin_top']) ? $responsi_options['responsi_container_nav_mobile_margin_top'] : '0',
                    isset($responsi_options['responsi_container_nav_mobile_margin_bottom']) ? $responsi_options['responsi_container_nav_mobile_margin_bottom'] : '0',
                    isset($responsi_options['responsi_container_nav_mobile_margin_left']) ? $responsi_options['responsi_container_nav_mobile_margin_left'] : '10',
                    isset($responsi_options['responsi_container_nav_mobile_margin_right']) ? $responsi_options['responsi_container_nav_mobile_margin_right'] : '10'
                ),
                'transport'   => 'postMessage',
            )
        );

        $navigation_controls_settings['responsi_container_nav_mobile_padding'] = array(
            'control' => array(
                'label' => __('Padding', 'responsi'),
                'section' => 'navigation_primary',
                'settings' => 'multitext',
                'type' => 'multitext',
                'choices' => array(
                    'top' => 'Top',
                    'bottom' => 'Bottom',
                    'left' => 'Left',
                    'right' => 'Right'
                ),
            ),
            'setting' => array(
            
                'sanitize_callback' => 'responsi_sanitize_numeric',
                'default' => array(
                    isset($responsi_options['responsi_container_nav_mobile_padding_top']) ? $responsi_options['responsi_container_nav_mobile_padding_top'] : '0',
                    isset($responsi_options['responsi_container_nav_mobile_padding_bottom']) ? $responsi_options['responsi_container_nav_mobile_padding_bottom'] : '0',
                    isset($responsi_options['responsi_container_nav_mobile_padding_left']) ? $responsi_options['responsi_container_nav_mobile_padding_left'] : '0',
                    isset($responsi_options['responsi_container_nav_mobile_padding_right']) ? $responsi_options['responsi_container_nav_mobile_padding_right'] : '0'
                ),
                'transport'   => 'postMessage',
            )
        );

        //Nav Bar Content
        $navigation_controls_settings['lbhex34'] = array(
            'control' => array(
                'label' => __('Nav Bar Area Inner Container', 'responsi'),
                'section' => 'navigation_primary',
                'type' => 'ilabel',
            ),
            'setting' => array(
            
            )
        );

        $navigation_controls_settings['responsi_content_nav_background_color'] = array(
            'control' => array(
                'label' => __('Background Color', 'responsi'),
                'section' => 'navigation_primary',
                'settings' => 'multiple',
                'type' => 'ibackground',
                'input_attrs' => array(
                )
            ),
            'setting' => array(
            
                'sanitize_callback' => 'responsi_sanitize_background_color',
                'default' => isset($responsi_options['responsi_content_nav_background_color']) ? $responsi_options['responsi_content_nav_background_color'] : array( 'onoff' => 'false', 'color' => '#ffffff'),
                'transport'   => 'postMessage'
            )
        );

        $navigation_controls_settings['responsi_content_nav_background_image'] = array(
            'control' => array(
                'label' => __('Background Image', 'responsi'),
                'section' => 'navigation_primary',
                'settings' => 'responsi_content_nav_background_image',
                'type' => 'icheckbox',
                'input_attrs' => array(
                    'class' => 'collapsed'
                )
            ),
            'setting' => array(
            
                'sanitize_callback' => 'responsi_sanitize_checkboxs',
                'default' => isset($responsi_options['responsi_content_nav_background_image']) ? $responsi_options['responsi_content_nav_background_image'] : 'false',
                'transport'   => 'postMessage'
            )
        );

        $navigation_controls_settings['responsi_content_nav_background_image_url'] = array(
            'control' => array(
                'label' => __('Image', 'responsi'),
                'section' => 'navigation_primary',
                'settings' => 'responsi_content_nav_background_image_url',
                'type' => 'iupload',
                'input_attrs' => array(
                    'class' => 'hide'
                )
            ),
            'setting' => array(
            
                'sanitize_callback' => 'esc_url',
                'default' => isset($responsi_options['responsi_content_nav_background_image_url']) ? $responsi_options['responsi_content_nav_background_image_url'] : '',
                'transport'   => 'postMessage'
            )
        );

        $navigation_controls_settings['responsi_content_nav_background_image_size_on'] = array(
            'control' => array(
                'label'      => __('Image Resizer', 'responsi'),
                'section'    => 'navigation_primary',
                'settings'   => 'responsi_content_nav_background_image_size_on',
                'type'       => 'icheckbox',
                'input_attrs' => array(
                    'class' => 'hide collapsed-custom-sub'
                )
            ),
            'setting' => array(
            
                'sanitize_callback' => 'responsi_sanitize_checkboxs',
                'default'       => isset($responsi_options['responsi_content_nav_background_image_size_on']) ? $responsi_options['responsi_content_nav_background_image_size_on'] : 'false',
                'transport' => 'postMessage'
            )
        );

        $navigation_controls_settings['responsi_content_nav_background_image_size'] = array(
            'control' => array(
                'label'      => __('Image Size', 'responsi'),
                //'description'      => __('Supported values are auto, percentage e.g 50% and pixels e.g. 20px', 'responsi'),
                'section'    => 'navigation_primary',
                'settings'   => 'multitext',
                'type'       => 'multitext',
                'choices' => array(
                    'width' => 'Width',
                    'height' => 'Height'
                ),
                'input_attrs' => array(
                    'class' => 'hide hide-custom-sub hide-custom-sub-last'
                ),
            ),
            'setting' => array(
            
                'sanitize_callback' => 'responsi_sanitize_background_size',
                'default'       => array( 
                    isset($responsi_options['responsi_content_nav_background_image_size_width']) ? $responsi_options['responsi_content_nav_background_image_size_width'] : '100%' , 
                    isset($responsi_options['responsi_content_nav_background_image_size_height']) ? $responsi_options['responsi_content_nav_background_image_size_height'] : 'auto'
                ),
                'transport' => 'postMessage'
            )
        );

        $navigation_controls_settings['responsi_content_nav_background_image_position'] = array(
            'control' => array(
                'label' => __('Image Alignment', 'responsi'),
                'section' => 'navigation_primary',
                'settings' => 'multitext',
                'type' => 'multitext',
                'choices' => array(
                    'vertical' => 'Vertical',
                    'horizontal' => 'Horizontal'
                ),
                'input_attrs' => array(
                    'class' => 'hide'
                )
            ),
            'setting' => array(
            
                'sanitize_callback' => 'responsi_sanitize_background_position',
                'default' => array(
                    isset($responsi_options['responsi_content_nav_background_image_position_vertical']) ? $responsi_options['responsi_content_nav_background_image_position_vertical'] : 'center',
                    isset($responsi_options['responsi_content_nav_background_image_position_horizontal']) ? $responsi_options['responsi_content_nav_background_image_position_horizontal'] : 'center'
                ),
                'transport'   => 'postMessage',
            )
        );

        $navigation_controls_settings['responsi_content_nav_background_image_repeat'] = array(
            'control' => array(
                'label' => __('Image Repeat', 'responsi'),
                'section' => 'navigation_primary',
                'settings' => 'responsi_content_nav_background_image_repeat',
                'type' => 'iradio',
                'input_attrs' => array(
                    'checked_label' => 'ON',
                    'unchecked_label' => 'OFF',
                    'container_width' => 80,
                    'class' => 'hide last'
                ),
                'choices' => array(
                    'no-repeat' => 'No Repeat',
                    'repeat' => 'Repeat',
                    'repeat-x' => 'Repeat Horizontally',
                    'repeat-y' => 'Repeat Vertically'
                )
            ),
            'setting' => array(
            
                'sanitize_callback' => 'responsi_sanitize_choices',
                'default' => isset($responsi_options['responsi_content_nav_background_image_repeat']) ? $responsi_options['responsi_content_nav_background_image_repeat'] : 'no-repeat',
                'transport'   => 'postMessage'
            )
        );

        $navigation_controls_settings['responsi_content_nav_border_top'] = array(
            'control' => array(
                'label' => __('Border - Top', 'responsi'),
                'section' => 'navigation_primary',
                'settings' => 'multiple',
                'type' => 'border',
            ),
            'setting' => array(
            
                'sanitize_callback' => 'responsi_sanitize_border',
                'default' => isset($responsi_options['responsi_content_nav_border_top']) ? $responsi_options['responsi_content_nav_border_top'] : array(
                    'width' => '0',
                    'style' => 'solid',
                    'color' => '#ffffff'
                ),
                'transport'   => 'postMessage'
            )
        );

        $navigation_controls_settings['responsi_content_nav_border_bottom'] = array(
            'control' => array(
                'label' => __('Border - Bottom', 'responsi'),
                'section' => 'navigation_primary',
                'settings' => 'multiple',
                'type' => 'border',
            ),
            'setting' => array(
            
                'sanitize_callback' => 'responsi_sanitize_border',
                'default' => isset($responsi_options['responsi_content_nav_border_bottom']) ? $responsi_options['responsi_content_nav_border_bottom'] : array(
                    'width' => '0',
                    'style' => 'solid',
                    'color' => '#ffffff'
                ),
                'transport'   => 'postMessage'
            )
        );

        $navigation_controls_settings['responsi_content_nav_border_lr'] = array(
            'control' => array(
                'label' => __('Border - Left / Right', 'responsi'),
                'section' => 'navigation_primary',
                'settings' => 'multiple',
                'type' => 'border',
            ),
            'setting' => array(
            
                'sanitize_callback' => 'responsi_sanitize_border',
                'default' => isset($responsi_options['responsi_content_nav_border_lr']) ? $responsi_options['responsi_content_nav_border_lr'] : array(
                    'width' => '0',
                    'style' => 'solid',
                    'color' => '#ffffff'
                ),
                'transport'   => 'postMessage'
            )
        );

        $navigation_controls_settings['responsi_content_nav_border_radius'] = array(
            'control' => array(
                'label' => __('Border Corner', 'responsi'),
                'section' => 'navigation_primary',
                'settings' => 'multiple',
                'type' => 'border_radius',
            ),
            'setting' => array(
            
                'sanitize_callback' => 'responsi_sanitize_border_radius',
                'default' => isset($responsi_options['responsi_content_nav_border_radius']) ? $responsi_options['responsi_content_nav_border_radius'] : array(
                    'corner' => 'rounded',
                    'rounded_value' => '0'
                ),
                'transport'   => 'postMessage'
            )
        );

        $navigation_controls_settings['responsi_content_nav_box_shadow'] = array(
            'control' => array(
                'label' => __('Border Shadow', 'responsi'),
                'section' => 'navigation_primary',
                'settings' => 'multiple',
                'type' => 'box_shadow',
            ),
            'setting' => array(
            
                'sanitize_callback' => 'responsi_sanitize_box_shadow',
                'default' => isset($responsi_options['responsi_content_nav_box_shadow']) ? $responsi_options['responsi_content_nav_box_shadow'] : array(
                    'onoff' => 'false',
                    'h_shadow' => '0px',
                    'v_shadow' => '0px',
                    'blur' => '8px',
                    'spread' => '0px',
                    'color' => '#DBDBDB',
                    'inset' => ''
                ),
                'transport'   => 'postMessage'
            )
        );

        $navigation_controls_settings['responsi_content_nav_margin'] = array(
            'control' => array(
                'label' => __('Margin', 'responsi'),
                'section' => 'navigation_primary',
                'settings' => 'multitext',
                'type' => 'multitext',
                'choices' => array(
                    'top' => 'Top',
                    'bottom' => 'Bottom',
                    'left' => 'Left',
                    'right' => 'Right'
                ),
            ),
            'setting' => array(
            
                'sanitize_callback' => 'responsi_sanitize_numeric',
                'default' => array(
                    isset($responsi_options['responsi_content_nav_margin_top']) ? $responsi_options['responsi_content_nav_margin_top'] : '0',
                    isset($responsi_options['responsi_content_nav_margin_bottom']) ? $responsi_options['responsi_content_nav_margin_bottom'] : '0',
                    isset($responsi_options['responsi_content_nav_margin_left']) ? $responsi_options['responsi_content_nav_margin_left'] : '10',
                    isset($responsi_options['responsi_content_nav_margin_right']) ? $responsi_options['responsi_content_nav_margin_right'] : '10'
                ),
                'transport'   => 'postMessage',
            )
        );

        $navigation_controls_settings['responsi_content_nav_padding'] = array(
            'control' => array(
                'label' => __('Padding', 'responsi'),
                'section' => 'navigation_primary',
                'settings' => 'multitext',
                'type' => 'multitext',
                'choices' => array(
                    'top' => 'Top',
                    'bottom' => 'Bottom',
                    'left' => 'Left',
                    'right' => 'Right'
                ),
            ),
            'setting' => array(
            
                'sanitize_callback' => 'responsi_sanitize_numeric',
                'default' => array(
                    isset($responsi_options['responsi_content_nav_padding_top']) ? $responsi_options['responsi_content_nav_padding_top'] : '0',
                    isset($responsi_options['responsi_content_nav_padding_bottom']) ? $responsi_options['responsi_content_nav_padding_bottom'] : '0',
                    isset($responsi_options['responsi_content_nav_padding_left']) ? $responsi_options['responsi_content_nav_padding_left'] : '0',
                    isset($responsi_options['responsi_content_nav_padding_right']) ? $responsi_options['responsi_content_nav_padding_right'] : '0'
                ),
                'transport'   => 'postMessage',
            )
        );

        $navigation_controls_settings['lbhex35'] = array(
            'control' => array(
                'label' => __('Mobile Inner Content Settings', 'responsi'),
                'section' => 'navigation_primary',
                'type' => 'ilabel',
                'input_attrs' => array(
                    'class' => 'ilabel2'
                )
            ),
            'setting' => array(
            
            )
        );

        $navigation_controls_settings['responsi_content_nav_mobile_margin'] = array(
            'control' => array(
                'label' => __('Margin', 'responsi'),
                'section' => 'navigation_primary',
                'settings' => 'multitext',
                'type' => 'multitext',
                'choices' => array(
                    'top' => 'Top',
                    'bottom' => 'Bottom',
                    'left' => 'Left',
                    'right' => 'Right'
                ),
            ),
            'setting' => array(
            
                'sanitize_callback' => 'responsi_sanitize_numeric',
                'default' => array(
                    isset($responsi_options['responsi_content_nav_mobile_margin_top']) ? $responsi_options['responsi_content_nav_mobile_margin_top'] : '0',
                    isset($responsi_options['responsi_content_nav_mobile_margin_bottom']) ? $responsi_options['responsi_content_nav_mobile_margin_bottom'] : '0',
                    isset($responsi_options['responsi_content_nav_mobile_margin_left']) ? $responsi_options['responsi_content_nav_mobile_margin_left'] : '0',
                    isset($responsi_options['responsi_content_nav_mobile_margin_right']) ? $responsi_options['responsi_content_nav_mobile_margin_right'] : '0'
                ),
                'transport'   => 'postMessage',
            )
        );

        $navigation_controls_settings['responsi_content_nav_mobile_padding'] = array(
            'control' => array(
                'label' => __('Padding', 'responsi'),
                'section' => 'navigation_primary',
                'settings' => 'multitext',
                'type' => 'multitext',
                'choices' => array(
                    'top' => 'Top',
                    'bottom' => 'Bottom',
                    'left' => 'Left',
                    'right' => 'Right'
                ),
            ),
            'setting' => array(
            
                'sanitize_callback' => 'responsi_sanitize_numeric',
                'default' => array(
                    isset($responsi_options['responsi_content_nav_mobile_padding_top']) ? $responsi_options['responsi_content_nav_mobile_padding_top'] : '0',
                    isset($responsi_options['responsi_content_nav_mobile_padding_bottom']) ? $responsi_options['responsi_content_nav_mobile_padding_bottom'] : '0',
                    isset($responsi_options['responsi_content_nav_mobile_padding_left']) ? $responsi_options['responsi_content_nav_mobile_padding_left'] : '0',
                    isset($responsi_options['responsi_content_nav_mobile_padding_right']) ? $responsi_options['responsi_content_nav_mobile_padding_right'] : '0'
                ),
                'transport'   => 'postMessage',
            )
        );

		$navigation_controls_settings['lbnav2'] = array(
			'control' => array(
			    'label'      => __('PNB Tabs Container', 'responsi'),
			    'section'    => 'navigation_primary',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);
		$navigation_controls_settings['responsi_nav_bg'] = array(
			'control' => array(
			    'label'      => __('Background Colour', 'responsi'),
			    'section'    => 'navigation_primary',
			    'settings'   => 'multiple',
			    'type'       => 'ibackground'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_nav_bg']) ? $responsi_options['responsi_nav_bg'] : array( 'onoff' => 'false', 'color' => '#009ee0'),
			    'sanitize_callback' => 'responsi_sanitize_background_color',
			    'transport'	=> 'postMessage'
			)
		);

		$navigation_controls_settings['responsi_nav_border_top'] = array(
			'control' => array(
			    'label'      => __('Border - Top', 'responsi'),
			    'section'    => 'navigation_primary',
			    'settings'   => 'multiple',
			    'type'       => 'border'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_nav_border_top']) ? $responsi_options['responsi_nav_border_top'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);
		$navigation_controls_settings['responsi_nav_border_bot'] = array(
			'control' => array(
			    'label'      => __('Border - Bottom', 'responsi'),
			    'section'    => 'navigation_primary',
			    'settings'   => 'multiple',
			    'type'       => 'border'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_nav_border_bot']) ? $responsi_options['responsi_nav_border_bot'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);
		$navigation_controls_settings['responsi_nav_border_lr'] = array(
			'control' => array(
			    'label'      => __('Border - Left / Right', 'responsi'),
			    'section'    => 'navigation_primary',
			    'settings'   => 'multiple',
			    'type'       => 'border'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_nav_border_lr']) ? $responsi_options['responsi_nav_border_lr'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);
		$navigation_controls_settings['responsi_nav_border_radius_tl'] = array(
			'control' => array(
			    'label'      => __('Border Corner - Top Left', 'responsi'),
			    'section'    => 'navigation_primary',
			    'settings'   => 'multiple',
			    'type'       => 'border_radius'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_nav_border_radius_tl']) ? $responsi_options['responsi_nav_border_radius_tl'] : array('corner' => 'square','rounded_value' => '0'),
			    'sanitize_callback' => 'responsi_sanitize_border_radius',
			    'transport'	=> 'postMessage'
			)
		);
		$navigation_controls_settings['responsi_nav_border_radius_tr'] = array(
			'control' => array(
			    'label'      => __('Border Corner - Top Right', 'responsi'),
			    'section'    => 'navigation_primary',
			    'settings'   => 'multiple',
			    'type'       => 'border_radius'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_nav_border_radius_tr']) ? $responsi_options['responsi_nav_border_radius_tr'] : array('corner' => 'square','rounded_value' => '0'),
			    'sanitize_callback' => 'responsi_sanitize_border_radius',
			    'transport'	=> 'postMessage'
			)
		);
		$navigation_controls_settings['responsi_nav_border_radius_bl'] = array(
			'control' => array(
			    'label'      => __('Border Corner - Bottom Left', 'responsi'),
			    'section'    => 'navigation_primary',
			    'settings'   => 'multiple',
			    'type'       => 'border_radius'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_nav_border_radius_bl']) ? $responsi_options['responsi_nav_border_radius_bl'] : array('corner' => 'square','rounded_value' => '0'),
			    'sanitize_callback' => 'responsi_sanitize_border_radius',
			    'transport'	=> 'postMessage'
			)
		);
		$navigation_controls_settings['responsi_nav_border_radius_br'] = array(
			'control' => array(
			    'label'      => __('Border Corner - Bottom Right', 'responsi'),
			    'section'    => 'navigation_primary',
			    'settings'   => 'multiple',
			    'type'       => 'border_radius'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_nav_border_radius_br']) ? $responsi_options['responsi_nav_border_radius_br'] : array('corner' => 'square','rounded_value' => '0'),
			    'sanitize_callback' => 'responsi_sanitize_border_radius',
			    'transport'	=> 'postMessage'
			)
		);
		$navigation_controls_settings['responsi_nav_shadow'] = array(
			'control' => array(
			    'label'      => __('Border Shadow', 'responsi'),
			    'section'    => 'navigation_primary',
			    'settings'   => 'multiple',
			    'type'       => 'box_shadow'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_nav_shadow']) ? $responsi_options['responsi_nav_shadow'] : array( 'onoff' => 'false' , 'h_shadow' => '0px' , 'v_shadow' => '0px', 'blur' => '5px' , 'spread' => '0px', 'color' => '#DBDBDB', 'inset' => '' ),
			    'sanitize_callback' => 'responsi_sanitize_box_shadow',
			    'transport'	=> 'postMessage'
			)
		);
		$navigation_controls_settings['responsi_nav_margin'] = array(
			'control' => array(
			    'label'      => __('Border Margin', 'responsi'),
			    'section'    => 'navigation_primary',
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
					isset($responsi_options['responsi_nav_margin_top']) ? $responsi_options['responsi_nav_margin_top'] : '0' , 
					isset($responsi_options['responsi_nav_margin_bottom']) ? $responsi_options['responsi_nav_margin_bottom'] : '0',
					isset($responsi_options['responsi_nav_margin_left']) ? $responsi_options['responsi_nav_margin_left'] : '0',
					isset($responsi_options['responsi_nav_margin_right']) ? $responsi_options['responsi_nav_margin_right'] : '0'
				),
				'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage',
			)
		);

		$navigation_controls_settings['responsi_nav_padding'] = array(
			'control' => array(
			    'label'      => __('Border Padding', 'responsi'),
			    'section'    => 'navigation_primary',
			    'settings'   => 'multitext',
			    'type'       => 'multitext',
			    'choices' => array(
			    	'tb_top' => 'Top',
					'tb_bottom' => 'Bottom',
					'lr_left' => 'Left',
					'lr_right' => 'Right',
		        )
			),
			'setting' => array(
				'default'		=> array( 
					isset($responsi_options['responsi_nav_padding_tb_top']) ? $responsi_options['responsi_nav_padding_tb_top'] : '0' , 
					isset($responsi_options['responsi_nav_padding_tb_bottom']) ? $responsi_options['responsi_nav_padding_tb_bottom'] : '0',
					isset($responsi_options['responsi_nav_padding_lr_left']) ? $responsi_options['responsi_nav_padding_lr_left'] : '0',
					isset($responsi_options['responsi_nav_padding_lr_right']) ? $responsi_options['responsi_nav_padding_lr_right'] : '0'
				),
				'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage',
			)
		);

		$navigation_controls_settings['lbnav3'] = array(
			'control' => array(
			    'label'      => __('PNB Tabs Style', 'responsi'),
			    'section'    => 'navigation_primary',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);

		$navigation_controls_settings['responsi_navi_background'] = array(
			'control' => array(
			    'label'      => __('Tab Colour', 'responsi'),
			    'section'    => 'navigation_primary',
			    'settings'   => 'multiple',
			    'type'       => 'ibackground'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_navi_background']) ? $responsi_options['responsi_navi_background'] : array( 'onoff' => 'true', 'color' => 'transparent'),
			    'sanitize_callback' => 'responsi_sanitize_background_color',
			    'transport'	=> 'postMessage'
			)
		);

		$navigation_controls_settings['responsi_nav_hover_bg'] = array(
			'control' => array(
			    'label'      => __('Tab Hover Colour', 'responsi'),
			    'section'    => 'navigation_primary',
			    'settings'   => 'multiple',
			    'type'       => 'ibackground'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_nav_hover_bg']) ? $responsi_options['responsi_nav_hover_bg'] : array( 'onoff' => 'true', 'color' => '#8cc700'),
			    'sanitize_callback' => 'responsi_sanitize_background_color',
			    'transport'	=> 'postMessage'
			)
		);

		$navigation_controls_settings['responsi_nav_border_hover'] = array(
            'control' => array(
                'label' => __('Tab Hover Border Colour', 'responsi'),
                'section' => 'navigation_primary',
                'settings' => 'responsi_nav_border_hover',
                'type' => 'icolor',
            ),
            'setting' => array(
                'sanitize_callback' => 'sanitize_hex_color',
                'default' => isset($responsi_options['responsi_nav_border_hover']) ? $responsi_options['responsi_nav_border_hover'] : '#ffffff',
                'transport'   => 'postMessage'
            )
        );

		$navigation_controls_settings['responsi_nav_currentitem_bg'] = array(
			'control' => array(
			    'label'      => __('Open Tab Colour', 'responsi'),
			    'section'    => 'navigation_primary',
			    'settings'   => 'multiple',
			    'type'       => 'ibackground'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_nav_currentitem_bg']) ? $responsi_options['responsi_nav_currentitem_bg'] : array( 'onoff' => 'true', 'color' => '#ffffff'),
			    'sanitize_callback' => 'responsi_sanitize_background_color',
			    'transport'	=> 'postMessage'
			)
		);

		$navigation_controls_settings['responsi_nav_currentitem_border'] = array(
            'control' => array(
                'label' => __('Open Tab Border Colour', 'responsi'),
                'section' => 'navigation_primary',
                'settings' => 'responsi_nav_currentitem_border',
                'type' => 'icolor',
            ),
            'setting' => array(
                'sanitize_callback' => 'sanitize_hex_color',
                'default' => isset($responsi_options['responsi_nav_currentitem_border']) ? $responsi_options['responsi_nav_currentitem_border'] : '#ffffff',
                'transport'   => 'postMessage'
            )
        );

		$navigation_controls_settings['responsi_nav_position'] = array(
			'control' => array(
			    'label'      => __('Tabs Alignment', 'responsi'),
			    'section'    => 'navigation_primary',
			    'settings'   => 'responsi_nav_position',
			    'type'       => 'iradio',
			    'input_attrs' => array(
					'checked_label' => 'ON',
					'unchecked_label' => 'OFF',
					'container_width' => 80
		        ),
			    'choices' => array("left" => "Left", "center" => "Center", "right" => "Right")
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_nav_position']) ? $responsi_options['responsi_nav_position'] : 'left',
			    'sanitize_callback' => 'responsi_sanitize_choices',
			    'transport'	=> 'postMessage'
			)
		);

		$navigation_controls_settings['responsi_nav_divider_border'] = array(
			'control' => array(
			    'label'      => __('Tabs Vertical Separator', 'responsi'),
			    'section'    => 'navigation_primary',
			    'settings'   => 'multiple',
			    'type'       => 'border'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_nav_divider_border']) ? $responsi_options['responsi_nav_divider_border'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);

		$navigation_controls_settings['lbnav4'] = array(
			'control' => array(
			    'label'      => __('PNB Tabs Border Style', 'responsi'),
			    'section'    => 'navigation_primary',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);

		$navigation_controls_settings['responsi_navi_border_top'] = array(
			'control' => array(
			    'label' => __('Border - Top', 'responsi'),
			    'section'    => 'navigation_primary',
			    'settings'   => 'multiple',
			    'type'       => 'border'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_navi_border_top']) ? $responsi_options['responsi_navi_border_top'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);
		$navigation_controls_settings['responsi_navi_border_bottom'] = array(
			'control' => array(
			    'label' => __('Border - Bottom', 'responsi'),
			    'section'    => 'navigation_primary',
			    'settings'   => 'multiple',
			    'type'       => 'border'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_navi_border_bottom']) ? $responsi_options['responsi_navi_border_bottom'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);
		$navigation_controls_settings['responsi_navi_border_left'] = array(
			'control' => array(
			    'label' => __('Border - Left', 'responsi'),
			    'section'    => 'navigation_primary',
			    'settings'   => 'multiple',
			    'type'       => 'border'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_navi_border_left']) ? $responsi_options['responsi_navi_border_left'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);
		$navigation_controls_settings['responsi_navi_border_right'] = array(
			'control' => array(
			    'label' => __('Border - Right', 'responsi'),
			    'section'    => 'navigation_primary',
			    'settings'   => 'multiple',
			    'type'       => 'border'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_navi_border_right']) ? $responsi_options['responsi_navi_border_right'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);
		$navigation_controls_settings['responsi_navi_border_radius_tl'] = array(
			'control' => array(
			    'label'      => __('Border Corner - Top Left', 'responsi'),
			    'section'    => 'navigation_primary',
			    'settings'   => 'multiple',
			    'type'       => 'border_radius'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_navi_border_radius_tl']) ? $responsi_options['responsi_navi_border_radius_tl'] : array('corner' => 'square','rounded_value' => '0'),
			    'sanitize_callback' => 'responsi_sanitize_border_radius',
			    'transport'	=> 'postMessage'
			)
		);
		$navigation_controls_settings['responsi_navi_border_radius_tr'] = array(
			'control' => array(
			    'label'      => __('Border Corner - Top Right', 'responsi'),
			    'section'    => 'navigation_primary',
			    'settings'   => 'multiple',
			    'type'       => 'border_radius'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_navi_border_radius_tr']) ? $responsi_options['responsi_navi_border_radius_tr'] : array('corner' => 'square','rounded_value' => '0'),
			    'sanitize_callback' => 'responsi_sanitize_border_radius',
			    'transport'	=> 'postMessage'
			)
		);
		$navigation_controls_settings['responsi_navi_border_radius_bl'] = array(
			'control' => array(
			    'label'      => __('Border Corner - Bottom Left', 'responsi'),
			    'section'    => 'navigation_primary',
			    'settings'   => 'multiple',
			    'type'       => 'border_radius'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_navi_border_radius_bl']) ? $responsi_options['responsi_navi_border_radius_bl'] : array('corner' => 'square','rounded_value' => '0'),
			    'sanitize_callback' => 'responsi_sanitize_border_radius',
			    'transport'	=> 'postMessage'
			)
		);
		$navigation_controls_settings['responsi_navi_border_radius_br'] = array(
			'control' => array(
			    'label'      => __('Border Corner - Bottom Right', 'responsi'),
			    'section'    => 'navigation_primary',
			    'settings'   => 'multiple',
			    'type'       => 'border_radius'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_navi_border_radius_br']) ? $responsi_options['responsi_navi_border_radius_br'] : array('corner' => 'square','rounded_value' => '0'),
			    'sanitize_callback' => 'responsi_sanitize_border_radius',
			    'transport'	=> 'postMessage'
			)
		);

		$navigation_controls_settings['responsi_navi_border_radius_first_tl'] = array(
            'control' => array(
                'label' => __('Fisrt Item Border Corner - Top Left', 'responsi'),
                'section' => 'navigation_primary',
                'settings' => 'multiple',
                'type' => 'border_radius',
            ),
            'setting' => array(
                
                'sanitize_callback' => 'responsi_sanitize_border_radius',
                'default' => isset($responsi_options['responsi_navi_border_radius_first_tl']) ? $responsi_options['responsi_navi_border_radius_first_tl'] : array(
                    'corner' => 'rounded',
                    'rounded_value' => '0'
                ),
                'transport'   => 'postMessage'
            )
        );

        $navigation_controls_settings['responsi_navi_border_radius_first_tr'] = array(
            'control' => array(
                'label' => __('Fisrt Item Border Corner - Top Right', 'responsi'),
                'section' => 'navigation_primary',
                'settings' => 'multiple',
                'type' => 'border_radius',
            ),
            'setting' => array(
                
                'sanitize_callback' => 'responsi_sanitize_border_radius',
                'default' => isset($responsi_options['responsi_navi_border_radius_first_tr']) ? $responsi_options['responsi_navi_border_radius_first_tr'] : array(
                    'corner' => 'rounded',
                    'rounded_value' => '0'
                ),
                'transport'   => 'postMessage'
            )
        );

        $navigation_controls_settings['responsi_navi_border_radius_first_bl'] = array(
            'control' => array(
                'label' => __('Fisrt Item Border Corner - Bottom Left', 'responsi'),
                'section' => 'navigation_primary',
                'settings' => 'multiple',
                'type' => 'border_radius',
            ),
            'setting' => array(
                
                'sanitize_callback' => 'responsi_sanitize_border_radius',
                'default' => isset($responsi_options['responsi_navi_border_radius_first_bl']) ? $responsi_options['responsi_navi_border_radius_first_bl'] : array(
                    'corner' => 'rounded',
                    'rounded_value' => '0'
                ),
                'transport'   => 'postMessage'
            )
        );

        $navigation_controls_settings['responsi_navi_border_radius_first_br'] = array(
            'control' => array(
                'label' => __('Fisrt Item Border Corner - Bottom Right', 'responsi'),
                'section' => 'navigation_primary',
                'settings' => 'multiple',
                'type' => 'border_radius',
            ),
            'setting' => array(
                
                'sanitize_callback' => 'responsi_sanitize_border_radius',
                'default' => isset($responsi_options['responsi_navi_border_radius_first_br']) ? $responsi_options['responsi_navi_border_radius_first_br'] : array(
                    'corner' => 'rounded',
                    'rounded_value' => '0'
                ),
                'transport'   => 'postMessage'
            )
        );

        $navigation_controls_settings['responsi_navi_border_radius_last_tl'] = array(
            'control' => array(
                'label' => __('Last Item Border Corner - Top Left', 'responsi'),
                'section' => 'navigation_primary',
                'settings' => 'multiple',
                'type' => 'border_radius',
            ),
            'setting' => array(
                
                'sanitize_callback' => 'responsi_sanitize_border_radius',
                'default' => isset($responsi_options['responsi_navi_border_radius_last_tl']) ? $responsi_options['responsi_navi_border_radius_last_tl'] : array(
                    'corner' => 'rounded',
                    'rounded_value' => '0'
                ),
                'transport'   => 'postMessage'
            )
        );

        $navigation_controls_settings['responsi_navi_border_radius_last_tr'] = array(
            'control' => array(
                'label' => __('Last Item Border Corner - Top Right', 'responsi'),
                'section' => 'navigation_primary',
                'settings' => 'multiple',
                'type' => 'border_radius',
            ),
            'setting' => array(
                
                'sanitize_callback' => 'responsi_sanitize_border_radius',
                'default' => isset($responsi_options['responsi_navi_border_radius_last_tr']) ? $responsi_options['responsi_navi_border_radius_last_tr'] : array(
                    'corner' => 'rounded',
                    'rounded_value' => '0'
                ),
                'transport'   => 'postMessage'
            )
        );

        $navigation_controls_settings['responsi_navi_border_radius_last_bl'] = array(
            'control' => array(
                'label' => __('Last Item Border Corner - Bottom Left', 'responsi'),
                'section' => 'navigation_primary',
                'settings' => 'multiple',
                'type' => 'border_radius',
            ),
            'setting' => array(
                
                'sanitize_callback' => 'responsi_sanitize_border_radius',
                'default' => isset($responsi_options['responsi_navi_border_radius_last_bl']) ? $responsi_options['responsi_navi_border_radius_last_bl'] : array(
                    'corner' => 'rounded',
                    'rounded_value' => '0'
                ),
                'transport'   => 'postMessage'
            )
        );

        $navigation_controls_settings['responsi_navi_border_radius_last_br'] = array(
            'control' => array(
                'label' => __('Last Item Border Corner - Bottom Right', 'responsi'),
                'section' => 'navigation_primary',
                'settings' => 'multiple',
                'type' => 'border_radius',
            ),
            'setting' => array(
                
                'sanitize_callback' => 'responsi_sanitize_border_radius',
                'default' => isset($responsi_options['responsi_navi_border_radius_last_br']) ? $responsi_options['responsi_navi_border_radius_last_br'] : array(
                    'corner' => 'rounded',
                    'rounded_value' => '0'
                ),
                'transport'   => 'postMessage'
            )
        );


		$navigation_controls_settings['responsi_navi_li_margin'] = array(
			'control' => array(
			    'label'      => __('Margin', 'responsi'),
			    'description' => __(" Margin add space between each tab items.", 'responsi'),
			    'section'    => 'navigation_primary',
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
					isset($responsi_options['responsi_navi_li_margin_top']) ? $responsi_options['responsi_navi_li_margin_top'] : '0' , 
					isset($responsi_options['responsi_navi_li_margin_bottom']) ? $responsi_options['responsi_navi_li_margin_bottom'] : '0',
					isset($responsi_options['responsi_navi_li_margin_left']) ? $responsi_options['responsi_navi_li_margin_left'] : '0',
					isset($responsi_options['responsi_navi_li_margin_right']) ? $responsi_options['responsi_navi_li_margin_right'] : '0'
				),
				'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage',
			)
		);

		$navigation_controls_settings['responsi_navi_border_margin'] = array(
			'control' => array(
			    'label'      => __('Margin', 'responsi'),
			    'section'    => 'navigation_primary',
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
					isset($responsi_options['responsi_navi_border_margin_top']) ? $responsi_options['responsi_navi_border_margin_top'] : '0' , 
					isset($responsi_options['responsi_navi_border_margin_bottom']) ? $responsi_options['responsi_navi_border_margin_bottom'] : '0',
					isset($responsi_options['responsi_navi_border_margin_left']) ? $responsi_options['responsi_navi_border_margin_left'] : '0',
					isset($responsi_options['responsi_navi_border_margin_right']) ? $responsi_options['responsi_navi_border_margin_right'] : '0'
				),
				'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage',
			)
		);

		$navigation_controls_settings['responsi_navi_border_padding'] = array(
			'control' => array(
			    'label'      => __('Padding', 'responsi'),
			    'section'    => 'navigation_primary',
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
					isset($responsi_options['responsi_navi_border_padding_top']) ? $responsi_options['responsi_navi_border_padding_top'] : '12' , 
					isset($responsi_options['responsi_navi_border_padding_bottom']) ? $responsi_options['responsi_navi_border_padding_bottom'] : '12',
					isset($responsi_options['responsi_navi_border_padding_left']) ? $responsi_options['responsi_navi_border_padding_left'] : '15',
					isset($responsi_options['responsi_navi_border_padding_right']) ? $responsi_options['responsi_navi_border_padding_right'] : '15'
				),
				'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage',
			)
		);

		$navigation_controls_settings['lbnav5'] = array(
			'control' => array(
			    'label'      => __('Nav Bar Font', 'responsi'),
			    'section'    => 'navigation_primary',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);

		$navigation_controls_settings['responsi_nav_font'] = array(
			'control' => array(
			    'label' => __('Menu Item Font', 'responsi'),
			    'section'    => 'navigation_primary',
			    'settings'   => 'multiple',
			    'type'       => 'typography'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_nav_font']) ? $responsi_options['responsi_nav_font'] : array('size' => '14','line_height' => '1','face' => 'Open Sans','style' => 'bold','color' => '#FFFFFF'),
			    'sanitize_callback' => 'responsi_sanitize_typography',
			    'transport'	=> 'postMessage'
			)
		);
		$navigation_controls_settings['responsi_nav_font_transform'] = array(
			'control' => array(
			    'label'      => __('Font Transformation', 'responsi'),
			    'section'    => 'navigation_primary',
			    'settings'   => 'responsi_nav_font_transform',
			    'type'       => 'iradio',
			    'input_attrs' => array(
					'checked_label' => 'ON',
					'unchecked_label' => 'OFF',
					'container_width' => 80
		        ),
			    'choices' => array( "none" => __('None', 'responsi'),"uppercase" => __('Uppercase', 'responsi'), "lowercase" => __('Lowercase', 'responsi'))
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_nav_font_transform']) ? $responsi_options['responsi_nav_font_transform'] : 'uppercase',
			    'sanitize_callback' => 'responsi_sanitize_choices',
			    'transport'	=> 'postMessage'
			)
		);
		$navigation_controls_settings['responsi_nav_hover'] = array(
			'control' => array(
			    'label'      => __('Font on Hover', 'responsi'),
			    'section'    => 'navigation_primary',
			    'settings'   => 'responsi_nav_hover',
			    'type'       => 'icolor'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_nav_hover']) ? $responsi_options['responsi_nav_hover'] : '#ffffff',
			    'sanitize_callback' => 'sanitize_hex_color',
			    'transport'	=> 'postMessage'
			)
		);
		
		$navigation_controls_settings['responsi_nav_currentitem'] = array(
			'control' => array(
			    'label'      => __('Open Item Font', 'responsi'),
			    'section'    => 'navigation_primary',
			    'settings'   => 'responsi_nav_currentitem',
			    'type'       => 'icolor'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_nav_currentitem']) ? $responsi_options['responsi_nav_currentitem'] : '#ff6868',
			    'sanitize_callback' => 'sanitize_hex_color',
			    'transport'	=> 'postMessage'
			)
		);
		
		//Dropdown
		$navigation_controls_settings['lbnav6'] = array(
			'control' => array(
			    'label'      => __('Nav Bar Dropdown Container', 'responsi'),
			    'section'    => 'navigation_primary_dropdown',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);
		$navigation_controls_settings['responsi_nav_dropdown_background'] = array(
			'control' => array(
			    'label'      => __('Background Color', 'responsi'),
			    'section'    => 'navigation_primary_dropdown',
			    'settings'   => 'multiple',
			    'type'       => 'ibackground'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_nav_dropdown_background']) ? $responsi_options['responsi_nav_dropdown_background'] : array( 'onoff' => 'true', 'color' => '#ffffff'),
			    'sanitize_callback' => 'responsi_sanitize_background_color',
			    'transport'	=> 'postMessage'
			)
		);
		$navigation_controls_settings['responsi_nav_dropdown_border_top'] = array(
			'control' => array(
			    'label' => __('Border - Top', 'responsi'),
			    'section'    => 'navigation_primary_dropdown',
			    'settings'   => 'multiple',
			    'type'       => 'border'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_nav_dropdown_border_top']) ? $responsi_options['responsi_nav_dropdown_border_top'] : array('width' => '1','style' => 'solid','color' => '#DBDBDB'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);
		$navigation_controls_settings['responsi_nav_dropdown_border_bottom'] = array(
			'control' => array(
			    'label' => __('Border - Bottom', 'responsi'),
			    'section'    => 'navigation_primary_dropdown',
			    'settings'   => 'multiple',
			    'type'       => 'border'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_nav_dropdown_border_bottom']) ? $responsi_options['responsi_nav_dropdown_border_bottom'] : array('width' => '1','style' => 'solid','color' => '#DBDBDB'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);
		$navigation_controls_settings['responsi_nav_dropdown_border_left'] = array(
			'control' => array(
			    'label' => __('Border - Left', 'responsi'),
			    'section'    => 'navigation_primary_dropdown',
			    'settings'   => 'multiple',
			    'type'       => 'border'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_nav_dropdown_border_left']) ? $responsi_options['responsi_nav_dropdown_border_left'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);
		$navigation_controls_settings['responsi_nav_dropdown_border_right'] = array(
			'control' => array(
			    'label' => __('Border - Right', 'responsi'),
			    'section'    => 'navigation_primary_dropdown',
			    'settings'   => 'multiple',
			    'type'       => 'border'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_nav_dropdown_border_right']) ? $responsi_options['responsi_nav_dropdown_border_right'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);
		$navigation_controls_settings['responsi_nav_dropdown_border_radius_tl'] = array(
			'control' => array(
			    'label'      => __('Border Corner - Top Left', 'responsi'),
			    'section'    => 'navigation_primary_dropdown',
			    'settings'   => 'multiple',
			    'type'       => 'border_radius'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_nav_dropdown_border_radius_tl']) ? $responsi_options['responsi_nav_dropdown_border_radius_tl'] : array('corner' => 'square','rounded_value' => '0'),
			    'sanitize_callback' => 'responsi_sanitize_border_radius',
			    'transport'	=> 'postMessage'
			)
		);
		$navigation_controls_settings['responsi_nav_dropdown_border_radius_tr'] = array(
			'control' => array(
			    'label'      => __('Border Corner - Top Right', 'responsi'),
			    'section'    => 'navigation_primary_dropdown',
			    'settings'   => 'multiple',
			    'type'       => 'border_radius'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_nav_dropdown_border_radius_tr']) ? $responsi_options['responsi_nav_dropdown_border_radius_tr'] : array('corner' => 'square','rounded_value' => '0'),
			    'sanitize_callback' => 'responsi_sanitize_border_radius',
			    'transport'	=> 'postMessage'
			)
		);
		$navigation_controls_settings['responsi_nav_dropdown_border_radius_bl'] = array(
			'control' => array(
			    'label'      => __('Border Corner - Bottom Left', 'responsi'),
			    'section'    => 'navigation_primary_dropdown',
			    'settings'   => 'multiple',
			    'type'       => 'border_radius'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_nav_dropdown_border_radius_bl']) ? $responsi_options['responsi_nav_dropdown_border_radius_bl'] : array('corner' => 'square','rounded_value' => '0'),
			    'sanitize_callback' => 'responsi_sanitize_border_radius',
			    'transport'	=> 'postMessage'
			)
		);
		$navigation_controls_settings['responsi_nav_dropdown_border_radius_br'] = array(
			'control' => array(
			    'label'      => __('Border Corner - Bottom Right', 'responsi'),
			    'section'    => 'navigation_primary_dropdown',
			    'settings'   => 'multiple',
			    'type'       => 'border_radius'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_nav_dropdown_border_radius_br']) ? $responsi_options['responsi_nav_dropdown_border_radius_br'] : array('corner' => 'square','rounded_value' => '0'),
			    'sanitize_callback' => 'responsi_sanitize_border_radius',
			    'transport'	=> 'postMessage'
			)
		);

		$navigation_controls_settings['responsi_nav_dropdown_shadow'] = array(
			'control' => array(
			    'label'      => __('Border Shadow', 'responsi'),
			    'section'    => 'navigation_primary_dropdown',
			    'settings'   => 'multiple',
			    'type'       => 'box_shadow'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_nav_dropdown_shadow']) ? $responsi_options['responsi_nav_dropdown_shadow'] : array( 'onoff' => 'false' , 'h_shadow' => '0px' , 'v_shadow' => '0px', 'blur' => '5px' , 'spread' => '0px', 'color' => '#DBDBDB', 'inset' => '' ),
			    'sanitize_callback' => 'responsi_sanitize_box_shadow',
			    'transport'	=> 'postMessage'
			)
		);
		$navigation_controls_settings['responsi_nav_dropdown_padding'] = array(
			'control' => array(
			    'label'      => __('Padding', 'responsi'),
			    'section'    => 'navigation_primary_dropdown',
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
					isset($responsi_options['responsi_nav_dropdown_padding_top']) ? $responsi_options['responsi_nav_dropdown_padding_top'] : '0' , 
					isset($responsi_options['responsi_nav_dropdown_padding_bottom']) ? $responsi_options['responsi_nav_dropdown_padding_bottom'] : '0',
					isset($responsi_options['responsi_nav_dropdown_padding_left']) ? $responsi_options['responsi_nav_dropdown_padding_left'] : '0',
					isset($responsi_options['responsi_nav_dropdown_padding_right']) ? $responsi_options['responsi_nav_dropdown_padding_right'] : '0'
				),
				'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage',
			)
		);

		$navigation_controls_settings['lbnav7'] = array(
			'control' => array(
			    'label'      => __('Dropdown Item Containers', 'responsi'),
			    'section'    => 'navigation_primary_dropdown',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);

		$navigation_controls_settings['responsi_nav_dropdown_item_background'] = array(
			'control' => array(
			    'label'      => __('Container Colour', 'responsi'),
			    'section'    => 'navigation_primary_dropdown',
			    'settings'   => 'multiple',
			    'type'       => 'ibackground'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_nav_dropdown_item_background']) ? $responsi_options['responsi_nav_dropdown_item_background'] : array( 'onoff' => 'true', 'color' => '#009ee0'),
			    'sanitize_callback' => 'responsi_sanitize_background_color',
			    'transport'	=> 'postMessage'
			)
		);
		$navigation_controls_settings['responsi_nav_dropdown_hover_background'] = array(
			'control' => array(
			    'label'      => __('Container Hover Colour', 'responsi'),
			    'section'    => 'navigation_primary_dropdown',
			    'settings'   => 'multiple',
			    'type'       => 'ibackground'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_nav_dropdown_hover_background']) ? $responsi_options['responsi_nav_dropdown_hover_background'] : array( 'onoff' => 'true', 'color' => '#8cc700'),
			    'sanitize_callback' => 'responsi_sanitize_background_color',
			    'transport'	=> 'postMessage'
			)
		);

		$navigation_controls_settings['responsi_nav_dropdown_item_padding'] = array(
			'control' => array(
			    'label'      => __('Item Container Padding', 'responsi'),
			    'section'    => 'navigation_primary_dropdown',
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
					isset($responsi_options['responsi_nav_dropdown_item_padding_top']) ? $responsi_options['responsi_nav_dropdown_item_padding_top'] : '11' , 
					isset($responsi_options['responsi_nav_dropdown_item_padding_bottom']) ? $responsi_options['responsi_nav_dropdown_item_padding_bottom'] : '11',
					isset($responsi_options['responsi_nav_dropdown_item_padding_left']) ? $responsi_options['responsi_nav_dropdown_item_padding_left'] : '13',
					isset($responsi_options['responsi_nav_dropdown_item_padding_right']) ? $responsi_options['responsi_nav_dropdown_item_padding_right'] : '13'
				),
				'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage',
			)
		);

		$navigation_controls_settings['responsi_nav_dropdown_separator'] = array(
			'control' => array(
			    'label' => __('Item Horizontal Separator', 'responsi'),
			    'section'    => 'navigation_primary_dropdown',
			    'settings'   => 'multiple',
			    'type'       => 'border'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_nav_dropdown_separator']) ? $responsi_options['responsi_nav_dropdown_separator'] : array('width' => '1','style' => 'solid','color' => '#DBDBDB'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);

		$navigation_controls_settings['lbnav8'] = array(
			'control' => array(
			    'label'      => __('Dropdown Menu Item Font', 'responsi'),
			    'section'    => 'navigation_primary_dropdown',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);

		$navigation_controls_settings['responsi_nav_dropdown_font'] = array(
			'control' => array(
			    'label' => __('Menu Item Font', 'responsi'),
			    'section'    => 'navigation_primary_dropdown',
			    'settings'   => 'multiple',
			    'type'       => 'typography',
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_nav_dropdown_font']) ? $responsi_options['responsi_nav_dropdown_font'] : array('size' => '13','line_height' => '1','face' => 'Open Sans','style' => 'bold','color' => '#ffffff'),
			    'sanitize_callback' => 'responsi_sanitize_typography',
			    'transport'	=> 'postMessage'
			)
		);
		$navigation_controls_settings['responsi_nav_dropdown_hover_color'] = array(
			'control' => array(
			    'label'      => __('Font on Hover', 'responsi'),
			    'section'    => 'navigation_primary_dropdown',
			    'settings'   => 'responsi_nav_dropdown_hover_color',
			    'type'       => 'icolor'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_nav_dropdown_hover_color']) ? $responsi_options['responsi_nav_dropdown_hover_color'] : '#ffffff',
			    'sanitize_callback' => 'sanitize_hex_color',
			    'transport'	=> 'postMessage'
			)
		);
		$navigation_controls_settings['responsi_nav_dropdown_font_transform'] = array(
			'control' => array(
			    'label'      => __('Font Transformation', 'responsi'),
			    'section'    => 'navigation_primary_dropdown',
			    'settings'   => 'responsi_nav_dropdown_font_transform',
			    'type'       => 'iradio',
			    'input_attrs' => array(
					'checked_label' => 'ON',
					'unchecked_label' => 'OFF',
					'container_width' => 80
		        ),
			    'choices' => array( "none" => __('None', 'responsi'),"uppercase" => __('Uppercase', 'responsi'), "lowercase" => __('Lowercase', 'responsi'))
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_nav_dropdown_font_transform']) ? $responsi_options['responsi_nav_dropdown_font_transform'] : 'uppercase',
			    'sanitize_callback' => 'responsi_sanitize_choices',
			    'transport'	=> 'postMessage'
			)
		);

		/*Nav Bar Mobile Settings*/
        $navigation_controls_settings['lbhex43'] = array(
			'control' => array(
			    'label'      => __('Nav Bar Mobile Container', 'responsi'),
			    'section'    => 'navigation_primary_mobile',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);

        $navigation_controls_settings['responsi_navbar_container_mobile_background_color'] = array(
            'control' => array(
                'label' => __('Background Color', 'responsi'),
                'section' => 'navigation_primary_mobile',
                'settings' => 'multiple',
                'type' => 'ibackground',
                'input_attrs' => array(
                    'class' => ''
                )
            ),
            'setting' => array(
                'sanitize_callback' => 'responsi_sanitize_background_color',
                'default' => isset($responsi_options['responsi_navbar_container_mobile_background_color']) ? $responsi_options['responsi_navbar_container_mobile_background_color'] : array( 'onoff' => 'true', 'color' => '#000000'),
                'transport'   => 'postMessage'
            )
        );

        $navigation_controls_settings['responsi_navbar_container_mobile_border_top'] = array(
            'control' => array(
                'label' => __('Border - Top', 'responsi'),
                'section' => 'navigation_primary_mobile',
                'settings' => 'multiple',
                'type' => 'border',
                'input_attrs' => array(
                    'class' => ''
                )
            ),
            'setting' => array(
                'sanitize_callback' => 'responsi_sanitize_border',
                'default' => isset($responsi_options['responsi_navbar_container_mobile_border_top']) ? $responsi_options['responsi_navbar_container_mobile_border_top'] : array(
                    'width' => '0',
                    'style' => 'solid',
                    'color' => '#ffffff'
                ),
                'transport'   => 'postMessage'
            )
        );

        $navigation_controls_settings['responsi_navbar_container_mobile_border_bottom'] = array(
            'control' => array(
                'label' => __('Border - Bottom', 'responsi'),
                'section' => 'navigation_primary_mobile',
                'settings' => 'multiple',
                'type' => 'border',
                'input_attrs' => array(
                    'class' => ''
                )
            ),
            'setting' => array(
                'sanitize_callback' => 'responsi_sanitize_border',
                'default' => isset($responsi_options['responsi_navbar_container_mobile_border_bottom']) ? $responsi_options['responsi_navbar_container_mobile_border_bottom'] : array(
                    'width' => '0',
                    'style' => 'solid',
                    'color' => '#ffffff'
                ),
                'transport'   => 'postMessage'
            )
        );

        $navigation_controls_settings['responsi_navbar_container_mobile_border_lr'] = array(
            'control' => array(
                'label' => __('Border - Left / Right', 'responsi'),
                'section' => 'navigation_primary_mobile',
                'settings' => 'multiple',
                'type' => 'border',
                'input_attrs' => array(
                    'class' => ''
                )
            ),
            'setting' => array(
                'sanitize_callback' => 'responsi_sanitize_border',
                'default' => isset($responsi_options['responsi_navbar_container_mobile_border_lr']) ? $responsi_options['responsi_navbar_container_mobile_border_lr'] : array(
                    'width' => '0',
                    'style' => 'solid',
                    'color' => '#ffffff'
                ),
                'transport'   => 'postMessage'
            )
        );

        $navigation_controls_settings['responsi_navbar_container_mobile_border_radius'] = array(
            'control' => array(
                'label' => __('Border Corner', 'responsi'),
                'section' => 'navigation_primary_mobile',
                'settings' => 'multiple',
                'type' => 'border_radius',
                'input_attrs' => array(
                    'class' => ''
                )
            ),
            'setting' => array(
                'sanitize_callback' => 'responsi_sanitize_border_radius',
                'default' => isset($responsi_options['responsi_navbar_container_mobile_border_radius']) ? $responsi_options['responsi_navbar_container_mobile_border_radius'] : array(
                    'corner' => 'rounded',
                    'rounded_value' => '0'
                ),
                'transport'   => 'postMessage'
            )
        );

        $navigation_controls_settings['responsi_navbar_container_mobile_box_shadow'] = array(
            'control' => array(
                'label' => __('Border Shadow', 'responsi'),
                'section' => 'navigation_primary_mobile',
                'settings' => 'multiple',
                'type' => 'box_shadow',
                'input_attrs' => array(
                    'class' => ''
                )
            ),
            'setting' => array(
                'sanitize_callback' => 'responsi_sanitize_box_shadow',
                'default' => isset($responsi_options['responsi_navbar_container_mobile_box_shadow']) ? $responsi_options['responsi_navbar_container_mobile_box_shadow'] : array(
                    'onoff' => 'false',
                    'h_shadow' => '0px',
                    'v_shadow' => '0px',
                    'blur' => '8px',
                    'spread' => '0px',
                    'color' => '#DBDBDB',
                    'inset' => ''
                ),
                'transport'   => 'postMessage'
            )
        );

        $navigation_controls_settings['responsi_navbar_container_mobile_margin'] = array(
            'control' => array(
                'label' => __('Margin', 'responsi'),
                'section' => 'navigation_primary_mobile',
                'settings' => 'multitext',
                'type' => 'multitext',
                'choices' => array(
                    'top' => 'Top',
                    'bottom' => 'Bottom',
                    'left' => 'Left',
                    'right' => 'Right'
                ),
                'input_attrs' => array(
                    'class' => ''
                )
            ),
            'setting' => array(
                'sanitize_callback' => 'responsi_sanitize_numeric',
                'default' => array(
                    isset($responsi_options['responsi_navbar_container_mobile_margin_top']) ? $responsi_options['responsi_navbar_container_mobile_margin_top'] : '0',
                    isset($responsi_options['responsi_navbar_container_mobile_margin_bottom']) ? $responsi_options['responsi_navbar_container_mobile_margin_bottom'] : '0',
                    isset($responsi_options['responsi_navbar_container_mobile_margin_left']) ? $responsi_options['responsi_navbar_container_mobile_margin_left'] : '0',
                    isset($responsi_options['responsi_navbar_container_mobile_margin_right']) ? $responsi_options['responsi_navbar_container_mobile_margin_right'] : '0'
                ),
                'transport'   => 'postMessage',
            )
        );

        $navigation_controls_settings['responsi_navbar_container_mobile_padding'] = array(
            'control' => array(
                'label' => __('Padding', 'responsi'),
                'section' => 'navigation_primary_mobile',
                'settings' => 'multitext',
                'type' => 'multitext',
                'choices' => array(
                    'top' => 'Top',
                    'bottom' => 'Bottom',
                    'left' => 'Left',
                    'right' => 'Right'
                ),
                'input_attrs' => array(
                    'class' => ''
                )
            ),
            'setting' => array(
                'sanitize_callback' => 'responsi_sanitize_numeric',
                'default' => array(
                    isset($responsi_options['responsi_navbar_container_mobile_padding_top']) ? $responsi_options['responsi_navbar_container_mobile_padding_top'] : '5',
                    isset($responsi_options['responsi_navbar_container_mobile_padding_bottom']) ? $responsi_options['responsi_navbar_container_mobile_padding_bottom'] : '5',
                    isset($responsi_options['responsi_navbar_container_mobile_padding_left']) ? $responsi_options['responsi_navbar_container_mobile_padding_left'] : '5',
                    isset($responsi_options['responsi_navbar_container_mobile_padding_right']) ? $responsi_options['responsi_navbar_container_mobile_padding_right'] : '5'
                ),
                'transport'   => 'postMessage',
            )
        );

        $navigation_controls_settings['lbhex44'] = array(
			'control' => array(
			    'label' => __('Mobile Icon Container', 'responsi'),
			    'section'    => 'navigation_primary_mobile',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);


        $navigation_controls_settings['responsi_nav_icon_mobile_background_color'] = array(
            'control' => array(
                'label' => __('Background Color', 'responsi'),
                'section' => 'navigation_primary_mobile',
                'settings' => 'multiple',
                'type' => 'ibackground',
                'input_attrs' => array(
                    'class' => ''
                )
            ),
            'setting' => array(
                'sanitize_callback' => 'responsi_sanitize_background_color',
                'default' => isset($responsi_options['responsi_nav_icon_mobile_background_color']) ? $responsi_options['responsi_nav_icon_mobile_background_color'] : array( 'onoff' => 'false', 'color' => '#000000'),
                'transport'   => 'postMessage'
            )
        );

        $navigation_controls_settings['responsi_nav_icon_mobile_border_top'] = array(
            'control' => array(
                'label' => __('Border - Top', 'responsi'),
                'section' => 'navigation_primary_mobile',
                'settings' => 'multiple',
                'type' => 'border',
                'input_attrs' => array(
                    'class' => ''
                )
            ),
            'setting' => array(
                'sanitize_callback' => 'responsi_sanitize_border',
                'default' => isset($responsi_options['responsi_nav_icon_mobile_border_top']) ? $responsi_options['responsi_nav_icon_mobile_border_top'] : array(
                    'width' => '0',
                    'style' => 'solid',
                    'color' => '#ffffff'
                ),
                'transport'   => 'postMessage'
            )
        );

        $navigation_controls_settings['responsi_nav_icon_mobile_border_bottom'] = array(
            'control' => array(
                'label' => __('Border - Bottom', 'responsi'),
                'section' => 'navigation_primary_mobile',
                'settings' => 'multiple',
                'type' => 'border',
                'input_attrs' => array(
                    'class' => ''
                )
            ),
            'setting' => array(
                'sanitize_callback' => 'responsi_sanitize_border',
                'default' => isset($responsi_options['responsi_nav_icon_mobile_border_bottom']) ? $responsi_options['responsi_nav_icon_mobile_border_bottom'] : array(
                    'width' => '0',
                    'style' => 'solid',
                    'color' => '#ffffff'
                ),
                'transport'   => 'postMessage'
            )
        );

        $navigation_controls_settings['responsi_nav_icon_mobile_border_left'] = array(
            'control' => array(
                'label' => __('Border - Left', 'responsi'),
                'section' => 'navigation_primary_mobile',
                'settings' => 'multiple',
                'type' => 'border',
                'input_attrs' => array(
                    'class' => ''
                )
            ),
            'setting' => array(
                'sanitize_callback' => 'responsi_sanitize_border',
                'default' => isset($responsi_options['responsi_nav_icon_mobile_border_left']) ? $responsi_options['responsi_nav_icon_mobile_border_left'] : array(
                    'width' => '0',
                    'style' => 'solid',
                    'color' => '#ffffff'
                ),
                'transport'   => 'postMessage'
            )
        );

        $navigation_controls_settings['responsi_nav_icon_mobile_border_right'] = array(
            'control' => array(
                'label' => __('Border - Right', 'responsi'),
                'section' => 'navigation_primary_mobile',
                'settings' => 'multiple',
                'type' => 'border',
                'input_attrs' => array(
                    'class' => ''
                )
            ),
            'setting' => array(
                'sanitize_callback' => 'responsi_sanitize_border',
                'default' => isset($responsi_options['responsi_nav_icon_mobile_border_right']) ? $responsi_options['responsi_nav_icon_mobile_border_right'] : array(
                    'width' => '0',
                    'style' => 'solid',
                    'color' => '#ffffff'
                ),
                'transport'   => 'postMessage'
            )
        );

        $navigation_controls_settings['responsi_nav_icon_mobile_border_radius'] = array(
            'control' => array(
                'label' => __('Border Corner', 'responsi'),
                'section' => 'navigation_primary_mobile',
                'settings' => 'multiple',
                'type' => 'border_radius',
                'input_attrs' => array(
                    'class' => ''
                )
            ),
            'setting' => array(
                'sanitize_callback' => 'responsi_sanitize_border_radius',
                'default' => isset($responsi_options['responsi_nav_icon_mobile_border_radius']) ? $responsi_options['responsi_nav_icon_mobile_border_radius'] : array(
                    'corner' => 'rounded',
                    'rounded_value' => '0'
                ),
                'transport'   => 'postMessage'
            )
        );

        $navigation_controls_settings['responsi_nav_icon_mobile_box_shadow'] = array(
            'control' => array(
                'label' => __('Border Shadow', 'responsi'),
                'section' => 'navigation_primary_mobile',
                'settings' => 'multiple',
                'type' => 'box_shadow',
                'input_attrs' => array(
                    'class' => ''
                )
            ),
            'setting' => array(
                'sanitize_callback' => 'responsi_sanitize_box_shadow',
                'default' => isset($responsi_options['responsi_nav_icon_mobile_box_shadow']) ? $responsi_options['responsi_nav_icon_mobile_box_shadow'] : array(
                    'onoff' => 'false',
                    'h_shadow' => '0px',
                    'v_shadow' => '0px',
                    'blur' => '8px',
                    'spread' => '0px',
                    'color' => '#DBDBDB',
                    'inset' => ''
                ),
                'transport'   => 'postMessage'
            )
        );

        $navigation_controls_settings['responsi_nav_icon_mobile_margin'] = array(
            'control' => array(
                'label' => __('Margin', 'responsi'),
                'section' => 'navigation_primary_mobile',
                'settings' => 'multitext',
                'type' => 'multitext',
                'choices' => array(
                    'top' => 'Top',
                    'bottom' => 'Bottom',
                    'left' => 'Left',
                    'right' => 'Right'
                ),
                'input_attrs' => array(
                    'class' => ''
                )
            ),
            'setting' => array(
                'sanitize_callback' => 'responsi_sanitize_numeric',
                'default' => array(
                    isset($responsi_options['responsi_nav_icon_mobile_margin_top']) ? $responsi_options['responsi_nav_icon_mobile_margin_top'] : '0',
                    isset($responsi_options['responsi_nav_icon_mobile_margin_bottom']) ? $responsi_options['responsi_nav_icon_mobile_margin_bottom'] : '0',
                    isset($responsi_options['responsi_nav_icon_mobile_margin_left']) ? $responsi_options['responsi_nav_icon_mobile_margin_left'] : '0',
                    isset($responsi_options['responsi_nav_icon_mobile_margin_right']) ? $responsi_options['responsi_nav_icon_mobile_margin_right'] : '5'
                ),
                'transport'   => 'postMessage',
            )
        );

        $navigation_controls_settings['responsi_nav_icon_mobile_padding'] = array(
            'control' => array(
                'label' => __('Padding', 'responsi'),
                'section' => 'navigation_primary_mobile',
                'settings' => 'multitext',
                'type' => 'multitext',
                'choices' => array(
                    'top' => 'Top',
                    'bottom' => 'Bottom',
                    'left' => 'Left',
                    'right' => 'Right'
                ),
                'input_attrs' => array(
                    'class' => ''
                )
            ),
            'setting' => array(
                'sanitize_callback' => 'responsi_sanitize_numeric',
                'default' => array(
                    isset($responsi_options['responsi_nav_icon_mobile_padding_top']) ? $responsi_options['responsi_nav_icon_mobile_padding_top'] : '0',
                    isset($responsi_options['responsi_nav_icon_mobile_padding_bottom']) ? $responsi_options['responsi_nav_icon_mobile_padding_bottom'] : '0',
                    isset($responsi_options['responsi_nav_icon_mobile_padding_left']) ? $responsi_options['responsi_nav_icon_mobile_padding_left'] : '0',
                    isset($responsi_options['responsi_nav_icon_mobile_padding_right']) ? $responsi_options['responsi_nav_icon_mobile_padding_right'] : '0'
                ),
                'transport'   => 'postMessage',
            )
        );

        $navigation_controls_settings['lbhex45'] = array(
			'control' => array(
			    'label' => __('Icon Size & Colour', 'responsi'),
			    'section'    => 'navigation_primary_mobile',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);

        $navigation_controls_settings['responsi_nav_icon_mobile_alignment'] = array(
            'control' => array(
                'label'      => __('Alignment', 'responsi'),
                'section'    => 'navigation_primary_mobile',
                'settings'   => 'responsi_nav_icon_mobile_alignment',
                'type'       => 'iradio',
                'input_attrs' => array(
                    'checked_label' => 'ON',
                    'unchecked_label' => 'OFF',
                    'container_width' => 80,
                    'class' => ''
                ),
                'choices' => array("left" => "Left", "right" => "Right" )
            ),
            'setting' => array(
                'sanitize_callback' => 'responsi_sanitize_choices',
                'default'       => isset($responsi_options['responsi_nav_icon_mobile_alignment']) ? $responsi_options['responsi_nav_icon_mobile_alignment'] : 'left',
                'transport' => 'postMessage'
            )
        );

        $navigation_controls_settings['responsi_nav_icon_mobile_size'] = array(
            'control' => array(
                'label' => __('Size', 'responsi'),
                'section' => 'navigation_primary_mobile',
                'settings' => 'responsi_nav_icon_mobile_size',
                'type' => 'slider',
                'input_attrs' => array(
                    'min' => '7',
                    'max' => '100',
                    'step' => '1',
                    'class' => ''
                )
            ),
            'setting' => array(
                'sanitize_callback' => 'responsi_sanitize_slider',
                'default' => isset($responsi_options['responsi_nav_icon_mobile_size']) ? $responsi_options['responsi_nav_icon_mobile_size'] : 24,
                'transport'   => 'postMessage'
            )
        );

        $navigation_controls_settings['responsi_nav_icon_mobile_color'] = array(
            'control' => array(
                'label' => __('Colour', 'responsi'),
                'section' => 'navigation_primary_mobile',
                'settings' => 'responsi_nav_icon_mobile_color',
                'type' => 'icolor',
                'input_attrs' => array(
                    'class' => ''
                )
            ),
            'setting' => array(
                'sanitize_callback' => 'sanitize_hex_color',
                'default' => isset($responsi_options['responsi_nav_icon_mobile_color']) ? $responsi_options['responsi_nav_icon_mobile_color'] : '#ffffff',
                'transport'   => 'postMessage'
            )
        );

        $navigation_controls_settings['lbhex46'] = array(
			'control' => array(
			    'label' => __('Separator', 'responsi'),
			    'section'    => 'navigation_primary_mobile',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);

        $navigation_controls_settings['responsi_nav_icon_mobile_separator'] = array(
            'control' => array(
                'label' => "",
                'section' => 'navigation_primary_mobile',
                'settings' => 'multiple',
                'type' => 'border',
                'input_attrs' => array(
                    'class' => ''
                )
            ),
            'setting' => array(
                'sanitize_callback' => 'responsi_sanitize_border',
                'default' => isset($responsi_options['responsi_nav_icon_mobile_separator']) ? $responsi_options['responsi_nav_icon_mobile_separator'] : array(
                    'width' => '2',
                    'style' => 'solid',
                    'color' => '#161616'
                ),
                'transport'   => 'postMessage'
            )
        );

        $navigation_controls_settings['lbhex47'] = array(
			'control' => array(
			    'label' => __('Nav Bar Mobile Text', 'responsi'),
			    'section'    => 'navigation_primary_mobile',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);

        $navigation_controls_settings['responsi_nav_container_mobile_text_on'] = array(
            'control' => array(
                'label' => __('Navigation Text', 'responsi'),
                'section' => 'navigation_primary_mobile',
                'settings' => 'responsi_nav_container_mobile_text_on',
                'type' => 'icheckbox',
                'input_attrs' => array(
                    'class' => 'collapsed '
                )
            ),
            'setting' => array(
                'sanitize_callback' => 'responsi_sanitize_checkboxs',
                'default' => isset($responsi_options['responsi_nav_container_mobile_text_on']) ? $responsi_options['responsi_nav_container_mobile_text_on'] : 'true',
                'transport'   => 'postMessage'
            )
        );

        $navigation_controls_settings['responsi_nav_container_mobile_text'] = array(
            'control' => array(
                'label'      => "",
                'section'    => 'navigation_primary_mobile',
                'settings'    => 'responsi_nav_container_mobile_text',
                'type'       => 'itext',
                'input_attrs' => array(
                    'class' => 'hide '
                )
            ),
            'setting' => array(
                'sanitize_callback' => 'sanitize_text_field',
                'default'       => isset($responsi_options['responsi_nav_container_mobile_text']) ? $responsi_options['responsi_nav_container_mobile_text'] : 'Navigation',
                'transport'   => 'postMessage'
            )
        );

        $navigation_controls_settings['responsi_nav_container_mobile_text_font'] = array(
            'control' => array(
                'label' => __('Font', 'responsi'),
                'section' => 'navigation_primary_mobile',
                'settings' => 'multiple',
                'type' => 'typography',
                'input_attrs' => array(
                    'class' => ''
                )
            ),
            'setting' => array(
                'sanitize_callback' => 'responsi_sanitize_typography',
                'default' => isset($responsi_options['responsi_nav_container_mobile_text_font']) ? $responsi_options['responsi_nav_container_mobile_text_font'] : array(
                    'size' => '18',
                    'line_height' => '1',
                    'face' => 'Open Sans',
                    'style' => 'normal',
                    'color' => '#FFFFFF'
                ),
                'transport'   => 'postMessage'
            )
        );

        $navigation_controls_settings['responsi_nav_container_mobile_text_font_transform'] = array(
            'control' => array(
                'label' => __('Font transform', 'responsi'),
                'section' => 'navigation_primary_mobile',
                'settings' => 'responsi_nav_container_mobile_text_font_transform',
                'type' => 'iradio',
                'input_attrs' => array(
                    'checked_label' => 'ON',
                    'unchecked_label' => 'OFF',
                    'container_width' => 80,
                    'class' => ''
                ),
                'choices' => array(
                    'none' => 'None',
                    'uppercase' => 'Uppercase',
                    'lowercase' => 'Lowercase'
                )
            ),
            'setting' => array(
                'sanitize_callback' => 'responsi_sanitize_choices',
                'default' => isset($responsi_options['responsi_nav_container_mobile_text_font_transform']) ? $responsi_options['responsi_nav_container_mobile_text_font_transform'] : 'none',
                'transport'   => 'postMessage'
            )
        );

        $navigation_controls_settings['responsi_nav_container_mobile_text_margin'] = array(
            'control' => array(
                'label' => __('Margin', 'responsi'),
                'section' => 'navigation_primary_mobile',
                'settings' => 'multitext',
                'type' => 'multitext',
                'choices' => array(
                    'top' => 'Top',
                    'bottom' => 'Bottom',
                    'left' => 'Left',
                    'right' => 'Right'
                ),
                'input_attrs' => array(
                    'class' => 'hide '
                )
            ),
            'setting' => array(
                'sanitize_callback' => 'responsi_sanitize_numeric',
                'default' => array(
                    isset($responsi_options['responsi_nav_container_mobile_text_margin_top']) ? $responsi_options['responsi_nav_container_mobile_text_margin_top'] : '0',
                    isset($responsi_options['responsi_nav_container_mobile_text_margin_bottom']) ? $responsi_options['responsi_nav_container_mobile_text_margin_bottom'] : '0',
                    isset($responsi_options['responsi_nav_container_mobile_text_margin_left']) ? $responsi_options['responsi_nav_container_mobile_text_margin_left'] : '8',
                    isset($responsi_options['responsi_nav_container_mobile_text_margin_right']) ? $responsi_options['responsi_nav_container_mobile_text_margin_right'] : '8'
                ),
                'transport'   => 'postMessage',
            )
        );

        $navigation_controls_settings['responsi_nav_container_mobile_text_padding'] = array(
            'control' => array(
                'label' => __('Padding', 'responsi'),
                'section' => 'navigation_primary_mobile',
                'settings' => 'multitext',
                'type' => 'multitext',
                'choices' => array(
                    'top' => 'Top',
                    'bottom' => 'Bottom',
                    'left' => 'Left',
                    'right' => 'Right'
                ),
                'input_attrs' => array(
                    'class' => 'hide last '
                )
            ),
            'setting' => array(
                'sanitize_callback' => 'responsi_sanitize_numeric',
                'default' => array(
                    isset($responsi_options['responsi_nav_container_mobile_text_padding_top']) ? $responsi_options['responsi_nav_container_mobile_text_padding_top'] : '0',
                    isset($responsi_options['responsi_nav_container_mobile_text_padding_bottom']) ? $responsi_options['responsi_nav_container_mobile_text_padding_bottom'] : '0',
                    isset($responsi_options['responsi_nav_container_mobile_text_padding_left']) ? $responsi_options['responsi_nav_container_mobile_text_padding_left'] : '0',
                    isset($responsi_options['responsi_nav_container_mobile_text_padding_right']) ? $responsi_options['responsi_nav_container_mobile_text_padding_right'] : '0'
                ),
                'transport'   => 'postMessage',
            )
        );

		//Navbar in Mobile
		$navigation_controls_settings['lbnav9'] = array(
			'control' => array(
			    'label'      => __('Mobile and Tablet Dropdown', 'responsi'),
			    'section'    => 'navigation_primary_mobile',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);

        $navigation_controls_settings['responsi_nav_container_dropdown_mobile_background_color'] = array(
            'control' => array(
                'label' => __('Background Color', 'responsi'),
                'section' => 'navigation_primary_mobile',
                'settings' => 'multiple',
                'type' => 'ibackground',
            ),
            'setting' => array(
                'sanitize_callback' => 'responsi_sanitize_background_color',
                'default' => isset($responsi_options['responsi_nav_container_dropdown_mobile_background_color']) ? $responsi_options['responsi_nav_container_dropdown_mobile_background_color'] : array( 'onoff' => 'true', 'color' => '#000000'),
                'transport'   => 'postMessage'
            )
        );

        $navigation_controls_settings['responsi_nav_container_dropdown_mobile_border_top'] = array(
            'control' => array(
                'label' => __('Border - Top', 'responsi'),
                'section' => 'navigation_primary_mobile',
                'settings' => 'multiple',
                'type' => 'border',
            ),
            'setting' => array(
                'sanitize_callback' => 'responsi_sanitize_border',
                'default' => isset($responsi_options['responsi_nav_container_dropdown_mobile_border_top']) ? $responsi_options['responsi_nav_container_dropdown_mobile_border_top'] : array(
                    'width' => '2',
                    'style' => 'solid',
                    'color' => '#161616'
                ),
                'transport'   => 'postMessage'
            )
        );

        $navigation_controls_settings['responsi_nav_container_dropdown_mobile_border_bottom'] = array(
            'control' => array(
                'label' => __('Border - Bottom', 'responsi'),
                'section' => 'navigation_primary_mobile',
                'settings' => 'multiple',
                'type' => 'border',
            ),
            'setting' => array(
                'sanitize_callback' => 'responsi_sanitize_border',
                'default' => isset($responsi_options['responsi_nav_container_dropdown_mobile_border_bottom']) ? $responsi_options['responsi_nav_container_dropdown_mobile_border_bottom'] : array(
                    'width' => '0',
                    'style' => 'solid',
                    'color' => '#161616'
                ),
                'transport'   => 'postMessage'
            )
        );

        $navigation_controls_settings['responsi_nav_container_dropdown_mobile_border_lr'] = array(
            'control' => array(
                'label' => __('Border - Left / Right', 'responsi'),
                'section' => 'navigation_primary_mobile',
                'settings' => 'multiple',
                'type' => 'border',
            ),
            'setting' => array(
                'sanitize_callback' => 'responsi_sanitize_border',
                'default' => isset($responsi_options['responsi_nav_container_dropdown_mobile_border_lr']) ? $responsi_options['responsi_nav_container_dropdown_mobile_border_lr'] : array(
                    'width' => '0',
                    'style' => 'solid',
                    'color' => '#161616'
                ),
                'transport'   => 'postMessage'
            )
        );

        $navigation_controls_settings['responsi_nav_container_dropdown_mobile_border_radius'] = array(
            'control' => array(
                'label' => __('Border Corner', 'responsi'),
                'section' => 'navigation_primary_mobile',
                'settings' => 'multiple',
                'type' => 'border_radius',
            ),
            'setting' => array(
                'sanitize_callback' => 'responsi_sanitize_border_radius',
                'default' => isset($responsi_options['responsi_nav_container_dropdown_mobile_border_radius']) ? $responsi_options['responsi_nav_container_dropdown_mobile_border_radius'] : array(
                    'corner' => 'rounded',
                    'rounded_value' => '0'
                ),
                'transport'   => 'postMessage'
            )
        );

        $navigation_controls_settings['responsi_nav_container_dropdown_mobile_box_shadow'] = array(
            'control' => array(
                'label' => __('Border Shadow', 'responsi'),
                'section' => 'navigation_primary_mobile',
                'settings' => 'multiple',
                'type' => 'box_shadow',
            ),
            'setting' => array(
                'sanitize_callback' => 'responsi_sanitize_box_shadow',
                'default' => isset($responsi_options['responsi_nav_container_dropdown_mobile_box_shadow']) ? $responsi_options['responsi_nav_container_dropdown_mobile_box_shadow'] : array(
                    'onoff' => 'false',
                    'h_shadow' => '0px',
                    'v_shadow' => '0px',
                    'blur' => '8px',
                    'spread' => '0px',
                    'color' => '#DBDBDB',
                    'inset' => ''
                ),
                'transport'   => 'postMessage'
            )
        );

        $navigation_controls_settings['responsi_nav_container_dropdown_mobile_margin'] = array(
            'control' => array(
                'label' => __('Margin', 'responsi'),
                'section' => 'navigation_primary_mobile',
                'settings' => 'multitext',
                'type' => 'multitext',
                'choices' => array(
                    'top' => 'Top',
                    'bottom' => 'Bottom',
                    'left' => 'Left',
                    'right' => 'Right'
                ),
            ),
            'setting' => array(
                'sanitize_callback' => 'responsi_sanitize_numeric',
                'default' => array(
                    isset($responsi_options['responsi_nav_container_dropdown_mobile_margin_top']) ? $responsi_options['responsi_nav_container_dropdown_mobile_margin_top'] : '0',
                    isset($responsi_options['responsi_nav_container_dropdown_mobile_margin_bottom']) ? $responsi_options['responsi_nav_container_dropdown_mobile_margin_bottom'] : '0',
                    isset($responsi_options['responsi_nav_container_dropdown_mobile_margin_left']) ? $responsi_options['responsi_nav_container_dropdown_mobile_margin_left'] : '0',
                    isset($responsi_options['responsi_nav_container_dropdown_mobile_margin_right']) ? $responsi_options['responsi_nav_container_dropdown_mobile_margin_right'] : '0'
                ),
                'transport'   => 'postMessage',
            )
        );

        $navigation_controls_settings['responsi_nav_container_dropdown_mobile_padding'] = array(
            'control' => array(
                'label' => __('Padding', 'responsi'),
                'section' => 'navigation_primary_mobile',
                'settings' => 'multitext',
                'type' => 'multitext',
                'choices' => array(
                    'top' => 'Top',
                    'bottom' => 'Bottom',
                    'left' => 'Left',
                    'right' => 'Right'
                ),
            ),
            'setting' => array(
                'sanitize_callback' => 'responsi_sanitize_numeric',
                'default' => array(
                    isset($responsi_options['responsi_nav_container_dropdown_mobile_padding_top']) ? $responsi_options['responsi_nav_container_dropdown_mobile_padding_top'] : '0',
                    isset($responsi_options['responsi_nav_container_dropdown_mobile_padding_bottom']) ? $responsi_options['responsi_nav_container_dropdown_mobile_padding_bottom'] : '0',
                    isset($responsi_options['responsi_nav_container_dropdown_mobile_padding_left']) ? $responsi_options['responsi_nav_container_dropdown_mobile_padding_left'] : '0',
                    isset($responsi_options['responsi_nav_container_dropdown_mobile_padding_right']) ? $responsi_options['responsi_nav_container_dropdown_mobile_padding_right'] : '0'
                ),
                'transport'   => 'postMessage',
            )
        );

        $navigation_controls_settings['lbhex49'] = array(
            'control' => array(
                'label' => __('Nav Bar Mobile Dropdown Items', 'responsi'),
                'section' => 'navigation_primary_mobile',
                'type' => 'ilabel',
            ),
			'setting' => array()
        );

        $navigation_controls_settings['responsi_nav_item_dropdown_mobile_font'] = array(
            'control' => array(
                'label' => __('Font', 'responsi'),
                'section' => 'navigation_primary_mobile',
                'settings' => 'multiple',
                'type' => 'typography',
            ),
            'setting' => array(
                'sanitize_callback' => 'responsi_sanitize_typography',
                'default' => isset($responsi_options['responsi_nav_item_dropdown_mobile_font']) ? $responsi_options['responsi_nav_item_dropdown_mobile_font'] : array(
                    'size' => '13',
                    'line_height' => '1',
                    'face' => 'Open Sans',
                    'style' => 'normal',
                    'color' => '#FFFFFF'
                ),
                'transport'   => 'postMessage'
            )
        );

        $navigation_controls_settings['responsi_nav_item_dropdown_mobile_hover_color'] = array(
            'control' => array(
                'label' => __('Colour on Mouse Over', 'responsi'),
                'section' => 'navigation_primary_mobile',
                'settings' => 'responsi_nav_item_dropdown_mobile_hover_color',
                'type' => 'icolor',
            ),
            'setting' => array(
                'sanitize_callback' => 'sanitize_hex_color',
                'default' => isset($responsi_options['responsi_nav_item_dropdown_mobile_hover_color']) ? $responsi_options['responsi_nav_item_dropdown_mobile_hover_color'] : '#ffffff',
                'transport'   => 'postMessage'
            )
        );

        $navigation_controls_settings['responsi_nav_item_dropdown_mobile_font_transform'] = array(
            'control' => array(
                'label' => __('Font transform', 'responsi'),
                'section' => 'navigation_primary_mobile',
                'settings' => 'responsi_nav_item_dropdown_mobile_font_transform',
                'type' => 'iradio',
                'input_attrs' => array(
                    'checked_label' => 'ON',
                    'unchecked_label' => 'OFF',
                    'container_width' => 80,
                    'class' => ''
                ),
                'choices' => array(
                    'none' => 'None',
                    'uppercase' => 'Uppercase',
                    'lowercase' => 'Lowercase'
                )
            ),
            'setting' => array(
                'sanitize_callback' => 'responsi_sanitize_choices',
                'default' => isset($responsi_options['responsi_nav_item_dropdown_mobile_font_transform']) ? $responsi_options['responsi_nav_item_dropdown_mobile_font_transform'] : 'uppercase',
                'transport'   => 'postMessage'
            )
        );

        $navigation_controls_settings['responsi_nav_item_dropdown_mobile_background'] = array(
            'control' => array(
                'label' => __('Background Color', 'responsi'),
                'section' => 'navigation_primary_mobile',
                'settings' => 'multiple',
                'type' => 'ibackground',
            ),
            'setting' => array(
                'sanitize_callback' => 'responsi_sanitize_background_color',
                'default' => isset($responsi_options['responsi_nav_item_dropdown_mobile_background']) ? $responsi_options['responsi_nav_item_dropdown_mobile_background'] : array( 'onoff' => 'false', 'color' => '#000000'),
                'transport'   => 'postMessage'
            )
        );

        $navigation_controls_settings['responsi_nav_item_dropdown_mobile_hover_background'] = array(
            'control' => array(
                'label' => __('Hover background color', 'responsi'),
                'section' => 'navigation_primary_mobile',
                'settings' => 'multiple',
                'type' => 'ibackground',
            ),
            'setting' => array(
                'sanitize_callback' => 'responsi_sanitize_background_color',
                'default' => isset($responsi_options['responsi_nav_item_dropdown_mobile_hover_background']) ? $responsi_options['responsi_nav_item_dropdown_mobile_hover_background'] : array( 'onoff' => 'true', 'color' => '#161616'),
                'transport'   => 'postMessage'
            )
        );

        $navigation_controls_settings['responsi_nav_item_dropdown_mobile_separator'] = array(
            'control' => array(
                'label' => __('Separator', 'responsi'),
                //'description' => __("No Border = 0px.", 'responsi'),
                'section' => 'navigation_primary_mobile',
                'settings' => 'multiple',
                'type' => 'border',
            ),
            'setting' => array(
                'sanitize_callback' => 'responsi_sanitize_border',
                'default' => isset($responsi_options['responsi_nav_item_dropdown_mobile_separator']) ? $responsi_options['responsi_nav_item_dropdown_mobile_separator'] : array(
                    'width' => '2',
                    'style' => 'solid',
                    'color' => '#161616'
                ),
                'transport'   => 'postMessage'
            )
        );

        $navigation_controls_settings['responsi_nav_item_dropdown_mobile_padding'] = array(
            'control' => array(
                'label' => __('Padding', 'responsi'),
                'description' => __("Padding between the Item cell Border and the Item (space around each item text).", 'responsi'),
                'section' => 'navigation_primary_mobile',
                'settings' => 'multitext',
                'type' => 'multitext',
                'choices' => array(
                    'top' => 'Top',
                    'bottom' => 'Bottom',
                    'left' => 'Left',
                    'right' => 'Right'
                ),
            ),
            'setting' => array(
                'sanitize_callback' => 'responsi_sanitize_numeric',
                'default' => array(
                    isset($responsi_options['responsi_nav_item_dropdown_mobile_padding_top']) ? $responsi_options['responsi_nav_item_dropdown_mobile_padding_top'] : '9',
                    isset($responsi_options['responsi_nav_item_dropdown_mobile_padding_bottom']) ? $responsi_options['responsi_nav_item_dropdown_mobile_padding_bottom'] : '9',
                    isset($responsi_options['responsi_nav_item_dropdown_mobile_padding_left']) ? $responsi_options['responsi_nav_item_dropdown_mobile_padding_left'] : '10',
                    isset($responsi_options['responsi_nav_item_dropdown_mobile_padding_right']) ? $responsi_options['responsi_nav_item_dropdown_mobile_padding_right'] : '10'
                ),
                'transport'   => 'postMessage',
            )
        );

        $navigation_controls_settings['lbhex49plus'] = array(
            'control' => array(
                'label' => __('Child Menu', 'responsi'),
                'section' => 'navigation_primary_mobile',
                'type' => 'ilabel',
            ),
			'setting' => array()
            
        );

        $navigation_controls_settings['responsi_nav_item_dropdown_mobile_submenu_font'] = array(
            'control' => array(
                'label' => __('Font', 'responsi'),
                'section' => 'navigation_primary_mobile',
                'settings' => 'multiple',
                'type' => 'typography',
            ),
            'setting' => array(
                'sanitize_callback' => 'responsi_sanitize_typography',
                'default' => isset($responsi_options['responsi_nav_item_dropdown_mobile_submenu_font']) ? $responsi_options['responsi_nav_item_dropdown_mobile_submenu_font'] : array(
                    'size' => '13',
                    'line_height' => '1',
                    'face' => 'Open Sans',
                    'style' => 'normal',
                    'color' => '#FFFFFF'
                ),
                'transport'   => 'postMessage'
            )
        );

        $navigation_controls_settings['responsi_nav_item_dropdown_mobile_submenu_hover_color'] = array(
            'control' => array(
                'label' => __('Colour on Mouse Over', 'responsi'),
                'section' => 'navigation_primary_mobile',
                'settings' => 'responsi_nav_item_dropdown_mobile_submenu_hover_color',
                'type' => 'icolor',
            ),
            'setting' => array(
                'sanitize_callback' => 'sanitize_hex_color',
                'default' => isset($responsi_options['responsi_nav_item_dropdown_mobile_submenu_hover_color']) ? $responsi_options['responsi_nav_item_dropdown_mobile_submenu_hover_color'] : '#ffffff',
                'transport'   => 'postMessage'
            )
        );

        $navigation_controls_settings['responsi_nav_item_dropdown_mobile_submenu_background'] = array(
            'control' => array(
                'label' => __('Background Color', 'responsi'),
                'section' => 'navigation_primary_mobile',
                'settings' => 'multiple',
                'type' => 'ibackground',
            ),
            'setting' => array(
                'sanitize_callback' => 'responsi_sanitize_background_color',
                'default' => isset($responsi_options['responsi_nav_item_dropdown_mobile_submenu_background']) ? $responsi_options['responsi_nav_item_dropdown_mobile_submenu_background'] : array( 'onoff' => 'false', 'color' => '#000000'),
                'transport'   => 'postMessage'
            )
        );

        $navigation_controls_settings['responsi_nav_item_dropdown_mobile_submenu_font_transform'] = array(
            'control' => array(
                'label' => __('Font transform', 'responsi'),
                'section' => 'navigation_primary_mobile',
                'settings' => 'responsi_nav_item_dropdown_mobile_submenu_font_transform',
                'type' => 'iradio',
                'input_attrs' => array(
                    'checked_label' => 'ON',
                    'unchecked_label' => 'OFF',
                    'container_width' => 80,
                    'class' => ''
                ),
                'choices' => array(
                    'none' => 'None',
                    'uppercase' => 'Uppercase',
                    'lowercase' => 'Lowercase'
                )
            ),
            'setting' => array(
                'sanitize_callback' => 'responsi_sanitize_choices',
                'default' => isset($responsi_options['responsi_nav_item_dropdown_mobile_submenu_font_transform']) ? $responsi_options['responsi_nav_item_dropdown_mobile_submenu_font_transform'] : 'uppercase',
                'transport'   => 'postMessage'
            )
        );

        $navigation_controls_settings['responsi_nav_item_dropdown_mobile_submenu_hover_background'] = array(
            'control' => array(
                'label' => __('Hover background color', 'responsi'),
                'section' => 'navigation_primary_mobile',
                'settings' => 'multiple',
                'type' => 'ibackground',
            ),
            'setting' => array(
                'sanitize_callback' => 'responsi_sanitize_background_color',
                'default' => isset($responsi_options['responsi_nav_item_dropdown_mobile_submenu_hover_background']) ? $responsi_options['responsi_nav_item_dropdown_mobile_submenu_hover_background'] : array( 'onoff' => 'true', 'color' => '#161616'),
                'transport'   => 'postMessage'
            )
        );

        $navigation_controls_settings['responsi_nav_item_dropdown_mobile_submenu_separator'] = array(
            'control' => array(
                'label' => __('Separator', 'responsi'),
                //'description' => __("No Border = 0px.", 'responsi'),
                'section' => 'navigation_primary_mobile',
                'settings' => 'multiple',
                'type' => 'border',
            ),
            'setting' => array(
                'sanitize_callback' => 'responsi_sanitize_border',
                'default' => isset($responsi_options['responsi_nav_item_dropdown_mobile_submenu_separator']) ? $responsi_options['responsi_nav_item_dropdown_mobile_submenu_separator'] : array(
                    'width' => '2',
                    'style' => 'solid',
                    'color' => '#161616'
                ),
                'transport'   => 'postMessage'
            )
        );
		
		$navigation_controls_settings = apply_filters( 'responsi_navigation_controls_settings', $navigation_controls_settings );
		$controls_settings = array_merge($controls_settings, $navigation_controls_settings);
		return  $controls_settings ;
	}
}
?>
