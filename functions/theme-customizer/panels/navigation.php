<?php
class Responsi_Customize_Navigation
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
					isset($responsi_options['responsi_nav_padding_lr_left']) ? $responsi_options['responsi_nav_padding_lr_left'] : '10',
					isset($responsi_options['responsi_nav_padding_lr_right']) ? $responsi_options['responsi_nav_padding_lr_right'] : '10'
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
			    'default'		=> isset($responsi_options['responsi_nav_font']) ? $responsi_options['responsi_nav_font'] : array('size' => '13','line_height' => '1','face' => 'Open Sans','style' => 'bold','color' => '#FFFFFF'),
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
			    'choices' => array( "none" => "None","uppercase" => "Uppercase", "lowercase" => "Lowercase")
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
			    'choices' => array( "none" => "None","uppercase" => "Uppercase", "lowercase" => "Lowercase")
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_nav_dropdown_font_transform']) ? $responsi_options['responsi_nav_dropdown_font_transform'] : 'uppercase',
			    'sanitize_callback' => 'responsi_sanitize_choices',
			    'transport'	=> 'postMessage'
			)
		);

		//Navbar in Mobile
		$navigation_controls_settings['lbnav9'] = array(
			'control' => array(
			    'label'      => __('Mobile and Tablet Nav Bar', 'responsi'),
			    'section'    => 'navigation_primary_mobile',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);
		$navigation_controls_settings['responsi_nav_mobile_type'] = array(
			'control' => array(
			    'label'      => __( 'Nav Bar - Mobile Type', 'responsi' ),
			    'section'    => 'navigation_primary_mobile',
			    'settings'   => 'responsi_nav_mobile_type',
			    'type'       => 'iswitcher',
			    'choices' => array(
			    	'checked_value' => 'select',
					'checked_label' => 'SCROLL',
					'unchecked_value' => 'click',
					'unchecked_label' => 'DROPDOWN',
					'container_width' => 140
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_nav_mobile_type']) ? $responsi_options['responsi_nav_mobile_type'] : 'click',
				'sanitize_callback' => 'responsi_sanitize_checkboxs',
			)
		);
		$navigation_controls_settings = apply_filters( 'responsi_navigation_controls_settings', $navigation_controls_settings );
		$controls_settings = array_merge($controls_settings, $navigation_controls_settings);
		return  $controls_settings ;
	}
}

new Responsi_Customize_Navigation();
?>