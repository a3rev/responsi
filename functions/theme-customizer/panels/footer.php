<?php
class Responsi_Customize_Footer
{
	public function __construct() {
		add_action( 'customize_preview_init', array( $this, 'responsi_customize_preview_init' ), 11 );
		add_filter( 'responsi_default_options', array( $this, 'responsi_controls_settings' ) );
		add_filter( 'responsi_customize_register_panels',  array( $this, 'responsi_panels' ) );
		add_filter( 'responsi_customize_register_sections',  array( $this, 'responsi_sections' ) );
		add_filter( 'responsi_customize_register_settings',  array( $this, 'responsi_controls_settings' ) );
	}

	public function responsi_customize_preview_init() {
		wp_enqueue_script( 'responsi-customize-footer' );
	}

	public function is_panel_footer_widgets_active() {
		global $responsi_options;
		$show_panel = false;
		if(isset($responsi_options['responsi_footer_sidebars']) && $responsi_options['responsi_footer_sidebars'] > 0 ){
			$show_panel = true;
		}
		return $show_panel;
	}

	public function responsi_panels( $panels ){
		$footer_panels = array();
		$footer_panels['footer_widget_settings_panel'] = array(
		    'title' => __('Footer Widgets', 'responsi'),
		    'description' => '',
		    'priority' => 5.5,
		    'active_callback' => array( $this, 'is_panel_footer_widgets_active' )
		);
		$footer_panels['footer_settings_panel'] = array(
		    'title' => __('Footer', 'responsi'),
		    'description' => '',
		    'priority' => 6,
		);
		$panels = array_merge($panels, $footer_panels);
		return  $panels ;
	}

	public function responsi_sections( $sections ){
		$footer_sections = array();
		$footer_sections['footer_widget'] = array(
		    'title' => __('Footer Widgets - Container', 'responsi'),
		    'priority' => 10,
		    'panel' => 'footer_widget_settings_panel',
		);
		$footer_sections['footer_widget_content'] = array(
		    'title' => __('Footer Widgets - Content', 'responsi'),
		    'priority' => 10,
		    'panel' => 'footer_widget_settings_panel',
		);
		$footer_sections['footer_widget_style'] = array(
		    'title' => __('Footer Widgets - Style', 'responsi'),
		    'priority' => 10,
		    'panel' => 'footer_widget_settings_panel',
		);
		$footer_sections['footer_style'] = array(
		    'title' => __('Footer Section - Container', 'responsi'),
		    'priority' => 10,
		    'panel' => 'footer_settings_panel',
		);
		$footer_sections['footer_content_style'] = array(
		    'title' => __('Footer Content - Container', 'responsi'),
		    'priority' => 10,
		    'panel' => 'footer_settings_panel',
		);
		$footer_sections['footer_cusstom_content'] = array(
		    'title' => __('Footer Content', 'responsi'),
		    'priority' => 10,
		    'panel' => 'footer_settings_panel',
		);
		$footer_sections['footer_content'] = array(
		    'title' => __('Footer Notifications', 'responsi'),
		    'priority' => 10,
		    'panel' => 'footer_settings_panel',
		);
		$sections = array_merge($sections, $footer_sections);
		return  $sections ;
	}

	public function responsi_controls_settings( $controls_settings ){

		global $responsi_options;

		$footer_controls_settings = array();
		$footer_controls_settings['footer_label1'] = array(
			'control' => array(
			    'label'      => __('Footer Widget Area Container', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget',
			    'settings'    => 'footer_label1',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);

		$footer_controls_settings['responsi_before_footer_bg'] = array(
			'control' => array(
			    'label'      => __('Background Colour', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget',
			    'settings'   => 'multiple',
			    'type'       => 'ibackground'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_before_footer_bg']) ? $responsi_options['responsi_before_footer_bg'] : array( 'onoff' => 'true', 'color' => '#fabc02' ),
			    'sanitize_callback' => 'responsi_sanitize_background_color',
			    'transport'	=> 'postMessage'
			)
		);
		$footer_controls_settings['responsi_enable_before_footer_bg_image'] = array(
			'control' => array(
			    'label'      => __('Background Image', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget',
			    'settings'   => 'responsi_enable_before_footer_bg_image',
			    'type'       => 'icheckbox',
			    'input_attrs' => array(
			    	'class' => 'collapsed'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_enable_before_footer_bg_image']) ? $responsi_options['responsi_enable_before_footer_bg_image'] : 'false',
			    'sanitize_callback' => 'responsi_sanitize_checkboxs',
			    'transport'	=> 'postMessage'
			)
		);

		$footer_controls_settings['responsi_before_footer_bg_image'] = array(
			'control' => array(
			    'label'      => __('Image', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget',
			    'settings'   => 'responsi_before_footer_bg_image',
			    'type'       => 'iupload',
			    'input_attrs' => array(
			    	'class' => 'hide'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_before_footer_bg_image']) ? $responsi_options['responsi_before_footer_bg_image'] : '',
			    'sanitize_callback' => 'esc_url',
			    'transport'	=> 'postMessage'
			)
		);

		$footer_controls_settings['responsi_before_footer_bg_position'] = array(
			'control' => array(
			    'label'      => __('Image Alignment', 'responsi'),
			    'description' => __( 'Supports absolute values left, right, center, top, bottom or pixel values e.g. 20px for inner container positioning of image.', 'responsi' ),
			    'section'    => 'footer_widget',
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
					isset($responsi_options['responsi_before_footer_bg_position_vertical']) ? $responsi_options['responsi_before_footer_bg_position_vertical'] : 'center' , 
					isset($responsi_options['responsi_before_footer_bg_position_horizontal']) ? $responsi_options['responsi_before_footer_bg_position_horizontal'] : 'center'
				),
				'sanitize_callback' => 'responsi_sanitize_background_position',
			    'transport'	=> 'postMessage'
			)
		);

		$footer_controls_settings['responsi_before_footer_bg_image_repeat'] = array(
			'control' => array(
			    'label'      => __('Image Repeat', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget',
			    'settings'   => 'responsi_before_footer_bg_image_repeat',
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
			    'default'		=> isset($responsi_options['responsi_before_footer_bg_image_repeat']) ? $responsi_options['responsi_before_footer_bg_image_repeat'] : 'repeat',
			    'sanitize_callback' => 'responsi_sanitize_choices',
			    'transport'	=> 'postMessage'
			)
		);

		$footer_controls_settings['responsi_before_footer_border_top'] = array(
			'control' => array(
			    'label' => __('Border - Top', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget',
			    'settings'   => 'multiple',
			    'type'       => 'border'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_before_footer_border_top']) ? $responsi_options['responsi_before_footer_border_top'] : array('width' => '1','style' => 'solid','color' => '#ff6868'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);
		$footer_controls_settings['responsi_before_footer_border_bottom'] = array(
			'control' => array(
			    'label' => __('Border - Bottom', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget',
			    'settings'   => 'multiple',
			    'type'       => 'border'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_before_footer_border_bottom']) ? $responsi_options['responsi_before_footer_border_bottom'] : array('width' => '0','style' => 'solid','color' => '#ff6868'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);
		$footer_controls_settings['responsi_before_footer_border_lr'] = array(
			'control' => array(
			    'label' => __('Border - Left / Right', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget',
			    'settings'   => 'multiple',
			    'type'       => 'border'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_before_footer_border_lr']) ? $responsi_options['responsi_before_footer_border_lr'] : array('width' => '0','style' => 'solid','color' => '#ff6868'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);

		$footer_controls_settings['responsi_before_footer_border_radius_tl'] = array(
			'control' => array(
			    'label'      => __('Border Corner - Top Left', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget',
			    'settings'   => 'multiple',
			    'type'       => 'border_radius'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_before_footer_border_radius_tl']) ? $responsi_options['responsi_before_footer_border_radius_tl'] : array('corner' => 'square','rounded_value' => '0'),
			    'sanitize_callback' => 'responsi_sanitize_border_radius',
			    'transport'	=> 'postMessage'
			)
		);
		$footer_controls_settings['responsi_before_footer_border_radius_tr'] = array(
			'control' => array(
			    'label'      => __('Border Corner - Top Right', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget',
			    'settings'   => 'multiple',
			    'type'       => 'border_radius'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_before_footer_border_radius_tr']) ? $responsi_options['responsi_before_footer_border_radius_tr'] : array('corner' => 'square','rounded_value' => '0'),
			    'sanitize_callback' => 'responsi_sanitize_border_radius',
			    'transport'	=> 'postMessage'
			)
		);
		$footer_controls_settings['responsi_before_footer_border_radius_bl'] = array(
			'control' => array(
			    'label'      => __('Border Corner - Bottom Left', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget',
			    'settings'   => 'multiple',
			    'type'       => 'border_radius'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_before_footer_border_radius_bl']) ? $responsi_options['responsi_before_footer_border_radius_bl'] : array('corner' => 'square','rounded_value' => '0'),
			    'sanitize_callback' => 'responsi_sanitize_border_radius',
			    'transport'	=> 'postMessage'
			)
		);
		$footer_controls_settings['responsi_before_footer_border_radius_br'] = array(
			'control' => array(
			    'label'      => __('Border Corner - Bottom Right', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget',
			    'settings'   => 'multiple',
			    'type'       => 'border_radius'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_before_footer_border_radius_br']) ? $responsi_options['responsi_before_footer_border_radius_br'] : array('corner' => 'square','rounded_value' => '0'),
			    'sanitize_callback' => 'responsi_sanitize_border_radius',
			    'transport'	=> 'postMessage'
			)
		);

		$footer_controls_settings['responsi_before_footer_box_shadow'] = array(
			'control' => array(
			    'label'      => __('Border Shadow', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget',
			    'settings'   => 'multiple',
			    'type'       => 'box_shadow'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_before_footer_box_shadow']) ? $responsi_options['responsi_before_footer_box_shadow'] : array( 'onoff' => 'false' , 'h_shadow' => '0px' , 'v_shadow' => '0px', 'blur' => '8px' , 'spread' => '0px', 'color' => '#DBDBDB', 'inset' => '' ),
			    'sanitize_callback' => 'responsi_sanitize_box_shadow',
			    'transport'	=> 'postMessage'
			)
		);

		$footer_controls_settings['responsi_before_footer_margin'] = array(
			'control' => array(
			    'label'      => __('Margin', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget',
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
					isset($responsi_options['responsi_before_footer_margin_top']) ? $responsi_options['responsi_before_footer_margin_top'] : '0' , 
					isset($responsi_options['responsi_before_footer_margin_bottom']) ? $responsi_options['responsi_before_footer_margin_bottom'] : '0',
					isset($responsi_options['responsi_before_footer_margin_left']) ? $responsi_options['responsi_before_footer_margin_left'] : '0',
					isset($responsi_options['responsi_before_footer_margin_right']) ? $responsi_options['responsi_before_footer_margin_right'] : '0'
				),
				'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage',
			)
		);

		$footer_controls_settings['responsi_before_footer_padding'] = array(
			'control' => array(
			    'label'      => __('Padding', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget',
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
					isset($responsi_options['responsi_before_footer_padding_top']) ? $responsi_options['responsi_before_footer_padding_top'] : '0' ,
					isset($responsi_options['responsi_before_footer_padding_bottom']) ? $responsi_options['responsi_before_footer_padding_bottom'] : '0',
					isset($responsi_options['responsi_before_footer_padding_left']) ? $responsi_options['responsi_before_footer_padding_left'] : '0',
					isset($responsi_options['responsi_before_footer_padding_right']) ? $responsi_options['responsi_before_footer_padding_right'] : '0'
				),
				'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage',
			)
		);

		//Footer Widget content
		$footer_controls_settings['footer_content_label1'] = array(
			'control' => array(
			    'label'      => __('Footer Widget Content', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget_content',
			    'settings'    => 'footer_content_label1',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);

		$footer_controls_settings['responsi_before_footer_content_bg'] = array(
			'control' => array(
			    'label'      => __('Background Colour', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget_content',
			    'settings'   => 'multiple',
			    'type'       => 'ibackground'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_before_footer_content_bg']) ? $responsi_options['responsi_before_footer_content_bg'] : array( 'onoff' => 'false', 'color' => '#fabc02' ),
			    'sanitize_callback' => 'responsi_sanitize_background_color',
			    'transport'	=> 'postMessage'
			)
		);
		$footer_controls_settings['responsi_enable_before_footer_content_bg_image'] = array(
			'control' => array(
			    'label'      => __('Background Image', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget_content',
			    'settings'   => 'responsi_enable_before_footer_content_bg_image',
			    'type'       => 'icheckbox',
			    'input_attrs' => array(
			    	'class' => 'collapsed'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_enable_before_footer_content_bg_image']) ? $responsi_options['responsi_enable_before_footer_content_bg_image'] : 'false',
			    'sanitize_callback' => 'responsi_sanitize_checkboxs',
			    'transport'	=> 'postMessage'
			)
		);

		$footer_controls_settings['responsi_before_footer_content_bg_image'] = array(
			'control' => array(
			    'label'      => __('Image', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget_content',
			    'settings'   => 'responsi_before_footer_content_bg_image',
			    'type'       => 'iupload',
			    'input_attrs' => array(
			    	'class' => 'hide'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_before_footer_content_bg_image']) ? $responsi_options['responsi_before_footer_content_bg_image'] : '',
			    'sanitize_callback' => 'esc_url',
			    'transport'	=> 'postMessage'
			)
		);

		$footer_controls_settings['responsi_before_footer_content_bg_position'] = array(
			'control' => array(
			    'label'      => __('Image Alignment', 'responsi'),
			    'description' => __( 'Supports absolute values left, right, center, top, bottom or pixel values e.g. 20px for inner container positioning of image.', 'responsi' ),
			    'section'    => 'footer_widget_content',
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
					isset($responsi_options['responsi_before_footer_content_bg_position_vertical']) ? $responsi_options['responsi_before_footer_content_bg_position_vertical'] : 'center' , 
					isset($responsi_options['responsi_before_footer_content_bg_position_horizontal']) ? $responsi_options['responsi_before_footer_content_bg_position_horizontal'] : 'center'
				),
				'sanitize_callback' => 'responsi_sanitize_background_position',
			    'transport'	=> 'postMessage'
			)
		);

		$footer_controls_settings['responsi_before_footer_content_bg_image_repeat'] = array(
			'control' => array(
			    'label'      => __('Image Repeat', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget_content',
			    'settings'   => 'responsi_before_footer_content_bg_image_repeat',
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
			    'default'		=> isset($responsi_options['responsi_before_footer_content_bg_image_repeat']) ? $responsi_options['responsi_before_footer_content_bg_image_repeat'] : 'repeat',
			    'sanitize_callback' => 'responsi_sanitize_choices',
			    'transport'	=> 'postMessage'
			)
		);

		$footer_controls_settings['responsi_before_footer_content_border_top'] = array(
			'control' => array(
			    'label' => __('Border - Top', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget_content',
			    'settings'   => 'multiple',
			    'type'       => 'border'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_before_footer_content_border_top']) ? $responsi_options['responsi_before_footer_content_border_top'] : array('width' => '0','style' => 'solid','color' => '#ff6868'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);
		$footer_controls_settings['responsi_before_footer_content_border_bottom'] = array(
			'control' => array(
			    'label' => __('Border - Bottom', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget_content',
			    'settings'   => 'multiple',
			    'type'       => 'border'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_before_footer_content_border_bottom']) ? $responsi_options['responsi_before_footer_content_border_bottom'] : array('width' => '0','style' => 'solid','color' => '#ff6868'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);
		$footer_controls_settings['responsi_before_footer_content_border_lr'] = array(
			'control' => array(
			    'label' => __('Border - Left / Right', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget_content',
			    'settings'   => 'multiple',
			    'type'       => 'border'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_before_footer_content_border_lr']) ? $responsi_options['responsi_before_footer_content_border_lr'] : array('width' => '0','style' => 'solid','color' => '#ff6868'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);

		$footer_controls_settings['responsi_before_footer_content_border_radius_tl'] = array(
			'control' => array(
			    'label'      => __('Border Corner - Top Left', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget_content',
			    'settings'   => 'multiple',
			    'type'       => 'border_radius'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_before_footer_content_border_radius_tl']) ? $responsi_options['responsi_before_footer_content_border_radius_tl'] : array('corner' => 'square','rounded_value' => '0'),
			    'sanitize_callback' => 'responsi_sanitize_border_radius',
			    'transport'	=> 'postMessage'
			)
		);
		$footer_controls_settings['responsi_before_footer_content_border_radius_tr'] = array(
			'control' => array(
			    'label'      => __('Border Corner - Top Right', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget_content',
			    'settings'   => 'multiple',
			    'type'       => 'border_radius'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_before_footer_content_border_radius_tr']) ? $responsi_options['responsi_before_footer_content_border_radius_tr'] : array('corner' => 'square','rounded_value' => '0'),
			    'sanitize_callback' => 'responsi_sanitize_border_radius',
			    'transport'	=> 'postMessage'
			)
		);
		$footer_controls_settings['responsi_before_footer_content_border_radius_bl'] = array(
			'control' => array(
			    'label'      => __('Border Corner - Bottom Left', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget_content',
			    'settings'   => 'multiple',
			    'type'       => 'border_radius'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_before_footer_content_border_radius_bl']) ? $responsi_options['responsi_before_footer_content_border_radius_bl'] : array('corner' => 'square','rounded_value' => '0'),
			    'sanitize_callback' => 'responsi_sanitize_border_radius',
			    'transport'	=> 'postMessage'
			)
		);
		$footer_controls_settings['responsi_before_footer_content_border_radius_br'] = array(
			'control' => array(
			    'label'      => __('Border Corner - Bottom Right', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget_content',
			    'settings'   => 'multiple',
			    'type'       => 'border_radius'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_before_footer_content_border_radius_br']) ? $responsi_options['responsi_before_footer_content_border_radius_br'] : array('corner' => 'square','rounded_value' => '0'),
			    'sanitize_callback' => 'responsi_sanitize_border_radius',
			    'transport'	=> 'postMessage'
			)
		);

		$footer_controls_settings['responsi_before_footer_content_box_shadow'] = array(
			'control' => array(
			    'label'      => __('Border Shadow', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget_content',
			    'settings'   => 'multiple',
			    'type'       => 'box_shadow'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_before_footer_content_box_shadow']) ? $responsi_options['responsi_before_footer_content_box_shadow'] : array( 'onoff' => 'false' , 'h_shadow' => '0px' , 'v_shadow' => '0px', 'blur' => '8px' , 'spread' => '0px', 'color' => '#DBDBDB', 'inset' => '' ),
			    'sanitize_callback' => 'responsi_sanitize_box_shadow',
			    'transport'	=> 'postMessage'
			)
		);

		$footer_controls_settings['responsi_before_footer_content_margin'] = array(
			'control' => array(
			    'label'      => __('Margin', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget_content',
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
					isset($responsi_options['responsi_before_footer_content_margin_top']) ? $responsi_options['responsi_before_footer_content_margin_top'] : '0' , 
					isset($responsi_options['responsi_before_footer_content_margin_bottom']) ? $responsi_options['responsi_before_footer_content_margin_bottom'] : '0',
					isset($responsi_options['responsi_before_footer_content_margin_left']) ? $responsi_options['responsi_before_footer_content_margin_left'] : '0',
					isset($responsi_options['responsi_before_footer_content_margin_right']) ? $responsi_options['responsi_before_footer_content_margin_right'] : '0'
				),
				'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage',
			)
		);

		$footer_controls_settings['responsi_before_footer_content_padding'] = array(
			'control' => array(
			    'label'      => __('Padding', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget_content',
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
					isset($responsi_options['responsi_before_footer_content_padding_top']) ? $responsi_options['responsi_before_footer_content_padding_top'] : '10' ,
					isset($responsi_options['responsi_before_footer_content_padding_bottom']) ? $responsi_options['responsi_before_footer_content_padding_bottom'] : '10',
					isset($responsi_options['responsi_before_footer_content_padding_left']) ? $responsi_options['responsi_before_footer_content_padding_left'] : '10',
					isset($responsi_options['responsi_before_footer_content_padding_right']) ? $responsi_options['responsi_before_footer_content_padding_right'] : '10'
				),
				'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage',
			)
		);

		//Footer Widget
		$footer_controls_settings['footer_label4'] = array(
			'control' => array(
			    'label'      => __('Footer Widget Style', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget_style',
			    'settings'    => 'footer_label4',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);
		$footer_controls_settings['responsi_footer_widget_bg'] = array(
			'control' => array(
			    'label'      => __('Background Color', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget_style',
			    'settings'   => 'multiple',
			    'type'       => 'ibackground'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_widget_bg']) ? $responsi_options['responsi_footer_widget_bg'] : array( 'onoff' => 'false', 'color' => '#ffffff'),
			    'sanitize_callback' => 'responsi_sanitize_background_color',
			    'transport'	=> 'postMessage'
			)
		);
		$footer_controls_settings['responsi_footer_widget_border'] = array(
			'control' => array(
			    'label' => __('Border', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget_style',
			    'settings'   => 'multiple',
			    'type'       => 'border'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_widget_border']) ? $responsi_options['responsi_footer_widget_border'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);
		$footer_controls_settings['responsi_footer_widget_border_radius'] = array(
			'control' => array(
			    'label'      => __('Border Corner', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget_style',
			    'settings'   => 'multiple',
			    'type'       => 'border_radius'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_widget_border_radius']) ? $responsi_options['responsi_footer_widget_border_radius'] : array('corner' => 'square','rounded_value' => '0'),
			    'sanitize_callback' => 'responsi_sanitize_border_radius',
			    'transport'	=> 'postMessage'
			)
		);
		$footer_controls_settings['responsi_footer_widget_box_shadow'] = array(
			'control' => array(
			    'label'      => __('Border Shadow', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget_style',
			    'settings'   => 'multiple',
			    'type'       => 'box_shadow'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_widget_box_shadow']) ? $responsi_options['responsi_footer_widget_box_shadow'] : array( 'onoff' => 'false' , 'h_shadow' => '0px' , 'v_shadow' => '0px', 'blur' => '8px' , 'spread' => '0px', 'color' => '#DBDBDB', 'inset' => '' ),
			    'sanitize_callback' => 'responsi_sanitize_box_shadow',
			    'transport'	=> 'postMessage'
			)
		);
		$footer_controls_settings['responsi_footer_widget_margin_between'] = array(
			'control' => array(
			    'label'      => __('Widget Horizontal Margin', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget_style',
			    'settings'    => 'responsi_footer_widget_margin_between',
			    'type'       => 'itext',
			    'input_attrs' => array(
					'class' => 'custom-itext',
					'after_input' => __('Pixels', 'responsi'),
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_widget_margin_between']) ? $responsi_options['responsi_footer_widget_margin_between'] : '0',
			    'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage'
			)
		);
		$footer_controls_settings['responsi_footer_widget_padding'] = array(
			'control' => array(
			    'label'      => __('Padding', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget_style',
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
					isset($responsi_options['responsi_footer_widget_padding_top']) ? $responsi_options['responsi_footer_widget_padding_top'] : '0' , 
					isset($responsi_options['responsi_footer_widget_padding_bottom']) ? $responsi_options['responsi_footer_widget_padding_bottom'] : '0',
					isset($responsi_options['responsi_footer_widget_padding_left']) ? $responsi_options['responsi_footer_widget_padding_left'] : '0',
					isset($responsi_options['responsi_footer_widget_padding_right']) ? $responsi_options['responsi_footer_widget_padding_right'] : '0'
				),
				'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage',
			)
		);
		$footer_controls_settings['footer_label434'] = array(
			'control' => array(
			    'label'      => __('Widget Header & Titles', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget_style',
			    'settings'    => 'footer_label434',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);
		$footer_controls_settings['responsi_font_footer_widget_title'] = array(
			'control' => array(
			    'label' => __('Title Font', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget_style',
			    'settings'   => 'multiple',
			    'type'       => 'typography'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_font_footer_widget_title']) ? $responsi_options['responsi_font_footer_widget_title'] : array('size' => '15','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#ffffff'),
			    'sanitize_callback' => 'responsi_sanitize_typography',
			    'transport'	=> 'postMessage'
			)
		);
		$footer_controls_settings['responsi_footer_widget_title_text_alignment'] = array(
			'control' => array(
			    'label'      => __('Title Alignment', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget_style',
			    'settings'   => 'responsi_footer_widget_title_text_alignment',
			    'type'       => 'iradio',
			    'input_attrs' => array(
					'checked_label' => 'ON',
					'unchecked_label' => 'OFF',
					'container_width' => 80
		        ),
			    'choices' => array("left" => "Left", "center" => "Center", "right" => "Right", "justify" => "Justify")
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_widget_title_text_alignment']) ? $responsi_options['responsi_footer_widget_title_text_alignment'] : 'left',
			    'sanitize_callback' => 'responsi_sanitize_choices',
			    'transport'	=> 'postMessage'
			)
		);
		$footer_controls_settings['responsi_footer_widget_title_transform'] = array(
			'control' => array(
			    'label'      => __('Title Transformation', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget_style',
			    'settings'   => 'responsi_footer_widget_title_transform',
			    'type'       => 'iradio',
			    'input_attrs' => array(
					'checked_label' => 'ON',
					'unchecked_label' => 'OFF',
					'container_width' => 80
		        ),
			    'choices' => array( "none" => "None","uppercase" => "Uppercase", "lowercase" => "Lowercase")
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_widget_title_transform']) ? $responsi_options['responsi_footer_widget_title_transform'] : 'uppercase',
			    'sanitize_callback' => 'responsi_sanitize_choices',
			    'transport'	=> 'postMessage'
			)
		);
		$footer_controls_settings['footer_label4341'] = array(
			'control' => array(
			    'label'      => __('Widget Title Container', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget_style',
			    'settings'    => 'footer_label4341',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);

		$footer_controls_settings['responsi_footer_widget_title_bg'] = array(
			'control' => array(
			    'label'      => __('Background Color', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget_style',
			    'settings'   => 'multiple',
			    'type'       => 'ibackground'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_widget_title_bg']) ? $responsi_options['responsi_footer_widget_title_bg'] : array( 'onoff' => 'false', 'color' => '#ffffff'),
			    'sanitize_callback' => 'responsi_sanitize_background_color',
			    'transport'	=> 'postMessage'
			)
		);
		$footer_controls_settings['responsi_footer_widget_title_border_top'] = array(
			'control' => array(
			    'label' => __('Border - Top', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget_style',
			    'settings'   => 'multiple',
			    'type'       => 'border'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_widget_title_border_top']) ? $responsi_options['responsi_footer_widget_title_border_top'] : array('width' => '0','style' => 'solid','color' => '#ffffff'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);
		$footer_controls_settings['responsi_footer_widget_title_border_bottom'] = array(
			'control' => array(
			    'label' => __('Border - Bottom', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget_style',
			    'settings'   => 'multiple',
			    'type'       => 'border'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_widget_title_border_bottom']) ? $responsi_options['responsi_footer_widget_title_border_bottom'] : array('width' => '2','style' => 'double','color' => '#ffffff'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);
		$footer_controls_settings['responsi_footer_widget_title_border_left'] = array(
			'control' => array(
			    'label' => __('Border - Left', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget_style',
			    'settings'   => 'multiple',
			    'type'       => 'border'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_widget_title_border_left']) ? $responsi_options['responsi_footer_widget_title_border_left'] : array('width' => '0','style' => 'solid','color' => '#ffffff'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);
		$footer_controls_settings['responsi_footer_widget_title_border_right'] = array(
			'control' => array(
			    'label' => __('Border - Right', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget_style',
			    'settings'   => 'multiple',
			    'type'       => 'border'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_widget_title_border_right']) ? $responsi_options['responsi_footer_widget_title_border_right'] : array('width' => '0','style' => 'solid','color' => '#ffffff'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);
		$footer_controls_settings['responsi_footer_widget_title_border_radius_tl'] = array(
			'control' => array(
			    'label'      => __('Border Corner - Top Left', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget_style',
			    'settings'   => 'multiple',
			    'type'       => 'border_radius'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_widget_title_border_radius_tl']) ? $responsi_options['responsi_footer_widget_title_border_radius_tl'] : array('corner' => 'square','rounded_value' => '0'),
			    'sanitize_callback' => 'responsi_sanitize_border_radius',
			    'transport'	=> 'postMessage'
			)
		);
		$footer_controls_settings['responsi_footer_widget_title_border_radius_tr'] = array(
			'control' => array(
			    'label'      => __('Border Corner - Top Right', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget_style',
			    'settings'   => 'multiple',
			    'type'       => 'border_radius'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_widget_title_border_radius_tr']) ? $responsi_options['responsi_footer_widget_title_border_radius_tr'] : array('corner' => 'square','rounded_value' => '0'),
			    'sanitize_callback' => 'responsi_sanitize_border_radius',
			    'transport'	=> 'postMessage'
			)
		);
		$footer_controls_settings['responsi_footer_widget_title_border_radius_bl'] = array(
			'control' => array(
			    'label'      => __('Border Corner - Bottom Left', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget_style',
			    'settings'   => 'multiple',
			    'type'       => 'border_radius'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_widget_title_border_radius_bl']) ? $responsi_options['responsi_footer_widget_title_border_radius_bl'] : array('corner' => 'square','rounded_value' => '0'),
			    'sanitize_callback' => 'responsi_sanitize_border_radius',
			    'transport'	=> 'postMessage'
			)
		);
		$footer_controls_settings['responsi_footer_widget_title_border_radius_br'] = array(
			'control' => array(
			    'label'      => __('Border Corner - Bottom Right', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget_style',
			    'settings'   => 'multiple',
			    'type'       => 'border_radius'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_widget_title_border_radius_br']) ? $responsi_options['responsi_footer_widget_title_border_radius_br'] : array('corner' => 'square','rounded_value' => '0'),
			    'sanitize_callback' => 'responsi_sanitize_border_radius',
			    'transport'	=> 'postMessage'
			)
		);
		$footer_controls_settings['responsi_footer_widget_title_box_shadow'] = array(
			'control' => array(
			    'label'      => __('Border Shadow', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget_style',
			    'settings'   => 'multiple',
			    'type'       => 'box_shadow'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_widget_title_box_shadow']) ? $responsi_options['responsi_footer_widget_title_box_shadow'] : array( 'onoff' => 'false' , 'h_shadow' => '0px' , 'v_shadow' => '0px', 'blur' => '0px' , 'spread' => '0px', 'color' => '#DBDBDB', 'inset' => 'inset' ),
			    'sanitize_callback' => 'responsi_sanitize_box_shadow',
			    'transport'	=> 'postMessage'
			)
		);
		$footer_controls_settings['responsi_footer_widget_title_align'] = array(
			'control' => array(
			    'label'      => __('Title Container Align', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget_style',
			    'settings'   => 'responsi_footer_widget_title_align',
			    'type'       => 'iradio',
			    'input_attrs' => array(
					'checked_label' => 'ON',
					'unchecked_label' => 'OFF',
					'container_width' => 80
		        ),
			    'choices' => array("right" => "Right", "left" => "Left","center" => "Center","stretched" => "Stretched")
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_widget_title_align']) ? $responsi_options['responsi_footer_widget_title_align'] : 'stretched',
			    'sanitize_callback' => 'responsi_sanitize_choices',
			    'transport'	=> 'postMessage'
			)
		);
		$footer_controls_settings['responsi_footer_widget_title_margin'] = array(
			'control' => array(
			    'label'      => __('Margin', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget_style',
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
					isset($responsi_options['responsi_footer_widget_title_margin_top']) ? $responsi_options['responsi_footer_widget_title_margin_top'] : '0' , 
					isset($responsi_options['responsi_footer_widget_title_margin_bottom']) ? $responsi_options['responsi_footer_widget_title_margin_bottom'] : '5',
					isset($responsi_options['responsi_footer_widget_title_margin_left']) ? $responsi_options['responsi_footer_widget_title_margin_left'] : '0',
					isset($responsi_options['responsi_footer_widget_title_margin_right']) ? $responsi_options['responsi_footer_widget_title_margin_right'] : '0'
				),
				'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage',
			)
		);
		$footer_controls_settings['responsi_footer_widget_title_padding'] = array(
			'control' => array(
			    'label'      => __('Padding', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget_style',
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
					isset($responsi_options['responsi_footer_widget_title_padding_top']) ? $responsi_options['responsi_footer_widget_title_padding_top'] : '0' , 
					isset($responsi_options['responsi_footer_widget_title_padding_bottom']) ? $responsi_options['responsi_footer_widget_title_padding_bottom'] : '5',
					isset($responsi_options['responsi_footer_widget_title_padding_left']) ? $responsi_options['responsi_footer_widget_title_padding_left'] : '0',
					isset($responsi_options['responsi_footer_widget_title_padding_right']) ? $responsi_options['responsi_footer_widget_title_padding_right'] : '0'
				),
				'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage',
			)
		);
		$footer_controls_settings['footer_label4342'] = array(
			'control' => array(
			    'label'      => __('Widget Content Styling', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget_style',
			    'settings'    => 'footer_label4342',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);
		$footer_controls_settings['responsi_font_footer_widget_text'] = array(
			'control' => array(
			    'label' => __('Font', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget_style',
			    'settings'   => 'multiple',
			    'type'       => 'typography'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_font_footer_widget_text']) ? $responsi_options['responsi_font_footer_widget_text'] : array('size' => '12','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#ffffff'),
			    'sanitize_callback' => 'responsi_sanitize_typography',
			    'transport'	=> 'postMessage'
			)
		);
        $footer_controls_settings['responsi_footer_widget_link_color'] = array(
            'control' => array(
                'label'      => __('Text Link', 'responsi'),
                'description' => "",
                'section'    => 'footer_widget_style',
                'settings'   => 'responsi_footer_widget_link_color',
                'type'       => 'icolor'
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_footer_widget_link_color']) ? $responsi_options['responsi_footer_widget_link_color'] : '#ffffff',
                'sanitize_callback' => 'sanitize_hex_color',
                'transport' => 'postMessage'
            )
        );
        $footer_controls_settings['responsi_footer_widget_link_hover_color'] = array(
            'control' => array(
                'label'      => __('Text Link Hover', 'responsi'),
                'description' => "",
                'section'    => 'footer_widget_style',
                'settings'   => 'responsi_footer_widget_link_hover_color',
                'type'       => 'icolor'
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_footer_widget_link_hover_color']) ? $responsi_options['responsi_footer_widget_link_hover_color'] : '#ff6868',
                'sanitize_callback' => 'sanitize_hex_color',
                'transport' => 'postMessage'
            )
        );
        $footer_controls_settings['responsi_footer_widget_link_visited_color'] = array(
            'control' => array(
                'label'      => __('Text Link Clicked', 'responsi'),
                'description' => "",
                'section'    => 'footer_widget_style',
                'settings'   => 'responsi_footer_widget_link_visited_color',
                'type'       => 'icolor'
            ),
            'setting' => array(
                'default'       => isset($responsi_options['responsi_footer_widget_link_visited_color']) ? $responsi_options['responsi_footer_widget_link_visited_color'] : '#ffffff',
                'sanitize_callback' => 'sanitize_hex_color',
                'transport' => 'postMessage'
            )
        );
		$footer_controls_settings['responsi_font_footer_widget_text_alignment'] = array(
			'control' => array(
			    'label'      => __('Alignment', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget_style',
			    'settings'   => 'responsi_font_footer_widget_text_alignment',
			    'type'       => 'iradio',
			    'input_attrs' => array(
					'checked_label' => 'ON',
					'unchecked_label' => 'OFF',
					'container_width' => 80
		        ),
			    'choices' => array("left" => "Left", "center" => "Center", "right" => "Right", "justify" => "Justify")
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_font_footer_widget_text_alignment']) ? $responsi_options['responsi_font_footer_widget_text_alignment'] : 'left',
			    'sanitize_callback' => 'responsi_sanitize_choices',
			    'transport'	=> 'postMessage'
			)
		);
		$footer_controls_settings['responsi_footer_widget_content_padding'] = array(
			'control' => array(
			    'label'      => __('Padding', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget_style',
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
					isset($responsi_options['responsi_footer_widget_content_padding_top']) ? $responsi_options['responsi_footer_widget_content_padding_top'] : '0' , 
					isset($responsi_options['responsi_footer_widget_content_padding_bottom']) ? $responsi_options['responsi_footer_widget_content_padding_bottom'] : '0',
					isset($responsi_options['responsi_footer_widget_content_padding_left']) ? $responsi_options['responsi_footer_widget_content_padding_left'] : '0',
					isset($responsi_options['responsi_footer_widget_content_padding_right']) ? $responsi_options['responsi_footer_widget_content_padding_right'] : '0'
				),
				'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage',
			)
		);

		$footer_controls_settings['footer_label4343'] = array(
			'control' => array(
			    'label'      => __('Footer Widget List Style', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget_style',
			    'settings'    => 'footer_label4343',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);
		$footer_controls_settings['responsi_font_footer_widget_list'] = array(
			'control' => array(
			    'label' => __('Font', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget_style',
			    'settings'   => 'multiple',
			    'type'       => 'typography'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_font_footer_widget_list']) ? $responsi_options['responsi_font_footer_widget_list'] : array('size' => '13','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#ffffff'),
			    'sanitize_callback' => 'responsi_sanitize_typography',
			    'transport'	=> 'postMessage'
			)
		);
		$footer_controls_settings['responsi_before_footer_border_list'] = array(
			'control' => array(
			    'label' => __('Line (border) Under Each list Item', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_widget_style',
			    'settings'   => 'multiple',
			    'type'       => 'border'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_before_footer_border_list']) ? $responsi_options['responsi_before_footer_border_list'] : array('width' => '1','style' => 'solid','color' => '#f8a71d'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);

		//Footer Container
		$footer_controls_settings['footer_label7'] = array(
			'control' => array(
			    'label'      => __('Footer - Container Background', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_style',
			    'settings'    => 'footer_label7',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);
		$footer_controls_settings['responsi_footer_bg'] = array(
			'control' => array(
			    'label'      => __('Background Colour', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_style',
			    'settings'   => 'multiple',
			    'type'       => 'ibackground'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_bg']) ? $responsi_options['responsi_footer_bg'] : array( 'onoff' => 'true', 'color' => '#000000'),
			    'sanitize_callback' => 'responsi_sanitize_background_color',
			    'transport'	=> 'postMessage'
			)
		);
		$footer_controls_settings['responsi_enable_footer_bg_image'] = array(
			'control' => array(
			    'label'      => __('Background Image', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_style',
			    'settings'   => 'responsi_enable_footer_bg_image',
			    'type'       => 'icheckbox',
			    'input_attrs' => array(
			    	'class' => 'collapsed'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_enable_footer_bg_image']) ? $responsi_options['responsi_enable_footer_bg_image'] : 'false',
			    'sanitize_callback' => 'responsi_sanitize_checkboxs',
			    'transport'	=> 'postMessage'
			)
		);

		$footer_controls_settings['responsi_footer_bg_image'] = array(
			'control' => array(
			    'label'      => __('Image', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_style',
			    'settings'   => 'responsi_footer_bg_image',
			    'type'       => 'iupload',
			    'input_attrs' => array(
			    	'class' => 'hide'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_bg_image']) ? $responsi_options['responsi_footer_bg_image'] : '',
			    'sanitize_callback' => 'esc_url',
			    'transport'	=> 'postMessage'
			)
		);

		$footer_controls_settings['responsi_footer_bg_position'] = array(
			'control' => array(
			    'label'      => __('Image Alignment', 'responsi'),
			    'description' => __( 'Supports absolute values left, right, center, top, bottom or pixel values e.g. 20px for inner container positioning of image.', 'responsi' ),
			    'section'    => 'footer_style',
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
					isset($responsi_options['responsi_footer_bg_position_vertical']) ? $responsi_options['responsi_footer_bg_position_vertical'] : 'center' , 
					isset($responsi_options['responsi_footer_bg_position_horizontal']) ? $responsi_options['responsi_footer_bg_position_horizontal'] : 'center'
				),
				'sanitize_callback' => 'responsi_sanitize_background_position',
			    'transport'	=> 'postMessage'
			)
		);

		$footer_controls_settings['responsi_footer_bg_image_repeat'] = array(
			'control' => array(
			    'label'      => __('Image Repeat', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_style',
			    'settings'   => 'responsi_footer_bg_image_repeat',
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
			    'default'		=> isset($responsi_options['responsi_footer_bg_image_repeat']) ? $responsi_options['responsi_footer_bg_image_repeat'] : 'repeat',
			    'sanitize_callback' => 'responsi_sanitize_choices',
			    'transport'	=> 'postMessage'
			)
		);
		$footer_controls_settings['responsi_footer_border_top'] = array(
			'control' => array(
			    'label' => __('Border - Top', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_style',
			    'settings'   => 'multiple',
			    'type'       => 'border'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_border_top']) ? $responsi_options['responsi_footer_border_top'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);
		$footer_controls_settings['responsi_footer_border_bottom'] = array(
			'control' => array(
			    'label' => __('Border - Bottom', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_style',
			    'settings'   => 'multiple',
			    'type'       => 'border'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_border_bottom']) ? $responsi_options['responsi_footer_border_bottom'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);
		$footer_controls_settings['responsi_footer_border_lr'] = array(
			'control' => array(
			    'label' => __('Border - Left / Right', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_style',
			    'settings'   => 'multiple',
			    'type'       => 'border'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_border_lr']) ? $responsi_options['responsi_footer_border_lr'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);
		$footer_controls_settings['responsi_footer_border_radius_tl'] = array(
			'control' => array(
			    'label'      => __('Border Corner - Top Left', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_style',
			    'settings'   => 'multiple',
			    'type'       => 'border_radius'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_border_radius_tl']) ? $responsi_options['responsi_footer_border_radius_tl'] : array('corner' => 'square','rounded_value' => '0'),
			    'sanitize_callback' => 'responsi_sanitize_border_radius',
			    'transport'	=> 'postMessage'
			)
		);
		$footer_controls_settings['responsi_footer_border_radius_tr'] = array(
			'control' => array(
			    'label'      => __('Border Corner - Top Right', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_style',
			    'settings'   => 'multiple',
			    'type'       => 'border_radius'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_border_radius_tr']) ? $responsi_options['responsi_footer_border_radius_tr'] : array('corner' => 'square','rounded_value' => '0'),
			    'sanitize_callback' => 'responsi_sanitize_border_radius',
			    'transport'	=> 'postMessage'
			)
		);
		$footer_controls_settings['responsi_footer_border_radius_bl'] = array(
			'control' => array(
			    'label'      => __('Border Corner - Bottom Left', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_style',
			    'settings'   => 'multiple',
			    'type'       => 'border_radius'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_border_radius_bl']) ? $responsi_options['responsi_footer_border_radius_bl'] : array('corner' => 'square','rounded_value' => '0'),
			    'sanitize_callback' => 'responsi_sanitize_border_radius',
			    'transport'	=> 'postMessage'
			)
		);
		$footer_controls_settings['responsi_footer_border_radius_br'] = array(
			'control' => array(
			    'label'      => __('Border Corner - Bottom Right', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_style',
			    'settings'   => 'multiple',
			    'type'       => 'border_radius'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_border_radius_br']) ? $responsi_options['responsi_footer_border_radius_br'] : array('corner' => 'square','rounded_value' => '0'),
			    'sanitize_callback' => 'responsi_sanitize_border_radius',
			    'transport'	=> 'postMessage'
			)
		);

		$footer_controls_settings['responsi_footer_box_shadow'] = array(
			'control' => array(
			    'label'      => __('Border Shadow', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_style',
			    'settings'   => 'multiple',
			    'type'       => 'box_shadow'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_box_shadow']) ? $responsi_options['responsi_footer_box_shadow'] : array( 'onoff' => 'false' , 'h_shadow' => '0px' , 'v_shadow' => '0px', 'blur' => '8px' , 'spread' => '0px', 'color' => '#DBDBDB', 'inset' => '' ),
			    'sanitize_callback' => 'responsi_sanitize_box_shadow',
			    'transport'	=> 'postMessage'
			)
		);

		$footer_controls_settings['responsi_footer_margin'] = array(
			'control' => array(
			    'label'      => __('Margin', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_style',
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
					isset($responsi_options['responsi_footer_margin_top']) ? $responsi_options['responsi_footer_margin_top'] : '0' , 
					isset($responsi_options['responsi_footer_margin_bottom']) ? $responsi_options['responsi_footer_margin_bottom'] : '0',
					isset($responsi_options['responsi_footer_margin_left']) ? $responsi_options['responsi_footer_margin_left'] : '0',
					isset($responsi_options['responsi_footer_margin_right']) ? $responsi_options['responsi_footer_margin_right'] : '0'
				),
				'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage',
			)
		);

		$footer_controls_settings['responsi_footer_padding'] = array(
			'control' => array(
			    'label'      => __('Padding', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_style',
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
					isset($responsi_options['responsi_footer_padding_top']) ? $responsi_options['responsi_footer_padding_top'] : '0' , 
					isset($responsi_options['responsi_footer_padding_bottom']) ? $responsi_options['responsi_footer_padding_bottom'] : '0',
					isset($responsi_options['responsi_footer_padding_left']) ? $responsi_options['responsi_footer_padding_left'] : '0',
					isset($responsi_options['responsi_footer_padding_right']) ? $responsi_options['responsi_footer_padding_right'] : '0'
				),
				'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage',
			)
		);

		$footer_controls_settings['footer_label8888'] = array(
			'control' => array(
			    'label'      => __('Footer Content Container', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_content_style',
			    'settings'    => 'footer_label8888',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);

		$footer_controls_settings['responsi_footer_content_bg'] = array(
			'control' => array(
			    'label'      => __('Background Colour', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_content_style',
			    'settings'   => 'multiple',
			    'type'       => 'ibackground'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_content_bg']) ? $responsi_options['responsi_footer_content_bg'] : array( 'onoff' => 'false', 'color' => '#000000'),
			    'sanitize_callback' => 'responsi_sanitize_background_color',
			    'transport'	=> 'postMessage'
			)
		);
		$footer_controls_settings['responsi_enable_footer_content_bg_image'] = array(
			'control' => array(
			    'label'      => __('Background Image', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_content_style',
			    'settings'   => 'responsi_enable_footer_content_bg_image',
			    'type'       => 'icheckbox',
			    'input_attrs' => array(
			    	'class' => 'collapsed'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_enable_footer_content_bg_image']) ? $responsi_options['responsi_enable_footer_content_bg_image'] : 'false',
			    'sanitize_callback' => 'responsi_sanitize_checkboxs',
			    'transport'	=> 'postMessage'
			)
		);

		$footer_controls_settings['responsi_footer_content_bg_image'] = array(
			'control' => array(
			    'label'      => __('Image', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_content_style',
			    'settings'   => 'responsi_footer_content_bg_image',
			    'type'       => 'iupload',
			    'input_attrs' => array(
			    	'class' => 'hide'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_content_bg_image']) ? $responsi_options['responsi_footer_content_bg_image'] : '',
			    'sanitize_callback' => 'esc_url',
			    'transport'	=> 'postMessage'
			)
		);

		$footer_controls_settings['responsi_footer_content_bg_position'] = array(
			'control' => array(
			    'label'      => __('Image Alignment', 'responsi'),
			    'description' => __( 'Supports absolute values left, right, center, top, bottom or pixel values e.g. 20px for inner container positioning of image.', 'responsi' ),
			    'section'    => 'footer_content_style',
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
					isset($responsi_options['responsi_footer_content_bg_position_vertical']) ? $responsi_options['responsi_footer_content_bg_position_vertical'] : 'center' , 
					isset($responsi_options['responsi_footer_content_bg_position_horizontal']) ? $responsi_options['responsi_footer_content_bg_position_horizontal'] : 'center'
				),
				'sanitize_callback' => 'responsi_sanitize_background_position',
			    'transport'	=> 'postMessage'
			)
		);

		$footer_controls_settings['responsi_footer_content_bg_image_repeat'] = array(
			'control' => array(
			    'label'      => __('Image Repeat', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_content_style',
			    'settings'   => 'responsi_footer_content_bg_image_repeat',
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
			    'default'		=> isset($responsi_options['responsi_footer_content_bg_image_repeat']) ? $responsi_options['responsi_footer_content_bg_image_repeat'] : 'repeat',
			    'sanitize_callback' => 'responsi_sanitize_choices',
			    'transport'	=> 'postMessage'
			)
		);
		$footer_controls_settings['responsi_footer_content_border_top'] = array(
			'control' => array(
			    'label' => __('Border - Top', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_content_style',
			    'settings'   => 'multiple',
			    'type'       => 'border'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_content_border_top']) ? $responsi_options['responsi_footer_content_border_top'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);
		$footer_controls_settings['responsi_footer_content_border_bottom'] = array(
			'control' => array(
			    'label' => __('Border - Bottom', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_content_style',
			    'settings'   => 'multiple',
			    'type'       => 'border'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_content_border_bottom']) ? $responsi_options['responsi_footer_content_border_bottom'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);
		$footer_controls_settings['responsi_footer_content_border_lr'] = array(
			'control' => array(
			    'label' => __('Border - Left / Right', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_content_style',
			    'settings'   => 'multiple',
			    'type'       => 'border'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_content_border_lr']) ? $responsi_options['responsi_footer_content_border_lr'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);
		$footer_controls_settings['responsi_footer_content_border_radius_tl'] = array(
			'control' => array(
			    'label'      => __('Border Corner - Top Left', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_content_style',
			    'settings'   => 'multiple',
			    'type'       => 'border_radius'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_content_border_radius_tl']) ? $responsi_options['responsi_footer_content_border_radius_tl'] : array('corner' => 'square','rounded_value' => '0'),
			    'sanitize_callback' => 'responsi_sanitize_border_radius',
			    'transport'	=> 'postMessage'
			)
		);
		$footer_controls_settings['responsi_footer_content_border_radius_tr'] = array(
			'control' => array(
			    'label'      => __('Border Corner - Top Right', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_content_style',
			    'settings'   => 'multiple',
			    'type'       => 'border_radius'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_content_border_radius_tr']) ? $responsi_options['responsi_footer_content_border_radius_tr'] : array('corner' => 'square','rounded_value' => '0'),
			    'sanitize_callback' => 'responsi_sanitize_border_radius',
			    'transport'	=> 'postMessage'
			)
		);
		$footer_controls_settings['responsi_footer_content_border_radius_bl'] = array(
			'control' => array(
			    'label'      => __('Border Corner - Bottom Left', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_content_style',
			    'settings'   => 'multiple',
			    'type'       => 'border_radius'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_content_border_radius_bl']) ? $responsi_options['responsi_footer_content_border_radius_bl'] : array('corner' => 'square','rounded_value' => '0'),
			    'sanitize_callback' => 'responsi_sanitize_border_radius',
			    'transport'	=> 'postMessage'
			)
		);
		$footer_controls_settings['responsi_footer_content_border_radius_br'] = array(
			'control' => array(
			    'label'      => __('Border Corner - Bottom Right', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_content_style',
			    'settings'   => 'multiple',
			    'type'       => 'border_radius'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_content_border_radius_br']) ? $responsi_options['responsi_footer_content_border_radius_br'] : array('corner' => 'square','rounded_value' => '0'),
			    'sanitize_callback' => 'responsi_sanitize_border_radius',
			    'transport'	=> 'postMessage'
			)
		);

		$footer_controls_settings['responsi_footer_content_box_shadow'] = array(
			'control' => array(
			    'label'      => __('Border Shadow', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_content_style',
			    'settings'   => 'multiple',
			    'type'       => 'box_shadow'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_content_box_shadow']) ? $responsi_options['responsi_footer_content_box_shadow'] : array( 'onoff' => 'false' , 'h_shadow' => '0px' , 'v_shadow' => '0px', 'blur' => '8px' , 'spread' => '0px', 'color' => '#DBDBDB', 'inset' => '' ),
			    'sanitize_callback' => 'responsi_sanitize_box_shadow',
			    'transport'	=> 'postMessage'
			)
		);

		$footer_controls_settings['responsi_footer_content_margin'] = array(
			'control' => array(
			    'label'      => __('Margin', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_content_style',
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
					isset($responsi_options['responsi_footer_content_margin_top']) ? $responsi_options['responsi_footer_content_margin_top'] : '0' , 
					isset($responsi_options['responsi_footer_content_margin_bottom']) ? $responsi_options['responsi_footer_content_margin_bottom'] : '0',
					isset($responsi_options['responsi_footer_content_margin_left']) ? $responsi_options['responsi_footer_content_margin_left'] : '0',
					isset($responsi_options['responsi_footer_content_margin_right']) ? $responsi_options['responsi_footer_content_margin_right'] : '0'
				),
				'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage',
			)
		);

		$footer_controls_settings['responsi_footer_content_padding'] = array(
			'control' => array(
			    'label'      => __('Padding', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_content_style',
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
					isset($responsi_options['responsi_footer_content_padding_top']) ? $responsi_options['responsi_footer_content_padding_top'] : '10' , 
					isset($responsi_options['responsi_footer_content_padding_bottom']) ? $responsi_options['responsi_footer_content_padding_bottom'] : '10',
					isset($responsi_options['responsi_footer_content_padding_left']) ? $responsi_options['responsi_footer_content_padding_left'] : '10',
					isset($responsi_options['responsi_footer_content_padding_right']) ? $responsi_options['responsi_footer_content_padding_right'] : '10'
				),
				'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage',
			)
		);

		$footer_controls_settings['footer_label8'] = array(
			'control' => array(
			    'label'      => __('Footer Content', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_cusstom_content',
			    'settings'    => 'footer_label8',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);
		$footer_controls_settings['responsi_footer_below'] = array(
			'control' => array(
			    'label'      => __('Footer Content', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_cusstom_content',
			    'settings'   => 'responsi_footer_below',
			    'type'       => 'icheckbox',
			    'input_attrs' => array(
			    	'class' => 'collapsed'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_below']) ? $responsi_options['responsi_footer_below'] : 'false',
				'sanitize_callback' => 'responsi_sanitize_checkboxs',
			)
		);
		$footer_controls_settings['responsi_footer_below_text'] = array(
			'control' => array(
			    'label'      => "",
			    'description' => "",
			    'section'    => 'footer_cusstom_content',
			    'settings'    => 'responsi_footer_below_text',
			    'type'       => 'ieditor',
			    'input_attrs' => array(
			    	'class' => 'hide'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_below_text']) ? $responsi_options['responsi_footer_below_text'] : '',
			    'sanitize_callback' => 'responsi_sanitize_ieditor',
			)
		);

		$footer_controls_settings['footer_label7877'] = array(
			'control' => array(
			    'label'      => __('Footer - Content Font', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_cusstom_content',
			    'settings'    => 'footer_label7877',
			    'type'       => 'ilabel',
			    'input_attrs' => array(
			    	'class' => 'hide'
		        )
			),
			'setting' => array()
		);
		$footer_controls_settings['responsi_footer_custom_font'] = array(
			'control' => array(
			    'label' => __('Font', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_cusstom_content',
			    'settings'   => 'multiple',
			    'type'       => 'typography',
			    'input_attrs' => array(
			    	'class' => 'hide'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_custom_font']) ? $responsi_options['responsi_footer_custom_font'] : array('size' => '12','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#ffffff'),
			    'sanitize_callback' => 'responsi_sanitize_typography',
			    'transport'	=> 'postMessage'
			)
		);
		$footer_controls_settings['responsi_footer_custom_link_color'] = array(
			'control' => array(
			    'label'      => __('Link Colour', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_cusstom_content',
			    'settings'   => 'responsi_footer_custom_link_color',
			    'type'       => 'icolor',
			    'input_attrs' => array(
			    	'class' => 'hide'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_custom_link_color']) ? $responsi_options['responsi_footer_custom_link_color'] : '#ffffff',
			    'sanitize_callback' => 'sanitize_hex_color',
			    'transport'	=> 'postMessage'
			)
		);
		$footer_controls_settings['responsi_footer_custom_link_color_hover'] = array(
			'control' => array(
			    'label'      => __('Link Colour on Mouse Over', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_cusstom_content',
			    'settings'   => 'responsi_footer_custom_link_color_hover',
			    'type'       => 'icolor',
			    'input_attrs' => array(
			    	'class' => 'hide last'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_custom_link_color_hover']) ? $responsi_options['responsi_footer_custom_link_color_hover'] : '#ff0000',
			    'sanitize_callback' => 'sanitize_hex_color',
			    'transport'	=> 'postMessage'
			)
		);

		$footer_controls_settings['footer_label9'] = array(
			'control' => array(
			    'label'      => __('Site Copyright', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_content',
			    'settings'    => 'footer_label9',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);

		$footer_controls_settings['responsi_footer_left'] = array(
			'control' => array(
			    'label'      => __('Copyright Notice (Align Left)', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_content',
			    'settings'   => 'responsi_footer_left',
			    'type'       => 'icheckbox',
			    'input_attrs' => array(
			    	'class' => 'collapsed'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_left']) ? $responsi_options['responsi_footer_left'] : 'true',
			    'sanitize_callback' => 'responsi_sanitize_checkboxs',
			)
		);

		$footer_controls_settings['responsi_footer_left_text'] = array(
			'control' => array(
			    'label'      => __('Copyright Notice (Align Left) Content', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_content',
			    'settings'   => 'responsi_footer_left_text',
			    'type'       => 'itext',
			    'input_attrs' => array(
			    	'class' => 'hide last'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_left_text']) ? $responsi_options['responsi_footer_left_text'] : 'Content &copy; '.date( 'Y' ).' to Business Owners name',
			    'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$footer_controls_settings['footer_label219'] = array(
			'control' => array(
			    'label'      => __('Site Access Link', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_content',
			    'settings'    => 'footer_label219',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);

		$footer_controls_settings['responsi_footer_right_login'] = array(
			'control' => array(
			    'label'      => __('Log in / Log out Link (Far Right)', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_content',
			    'settings'   => 'responsi_footer_right_login',
			    'type'       => 'icheckbox'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_right_login']) ? $responsi_options['responsi_footer_right_login'] : 'true',
			    'sanitize_callback' => 'responsi_sanitize_checkboxs',
			)
		);

		$footer_controls_settings['footer_label10'] = array(
			'control' => array(
			    'label'      => __('Developer Branding', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_content',
			    'settings'    => 'footer_label10',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);

		$footer_controls_settings['responsi_enable_footer_right'] = array(
			'control' => array(
			    'label'      => __('Site Developed By', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_content',
			    'settings'   => 'responsi_enable_footer_right',
			    'type'       => 'icheckbox',
			    'input_attrs' => array(
			    	'class' => 'collapsed'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_enable_footer_right']) ? $responsi_options['responsi_enable_footer_right'] : 'true',
				'sanitize_callback' => 'responsi_sanitize_checkboxs',
			)
		);

		$footer_controls_settings['responsi_footer_right_text_before'] = array(
			'control' => array(
			    'label'      => __('Text Before Image', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_content',
			    'settings'   => 'responsi_footer_right_text_before',
			    'type'       => 'itext',
			    'input_attrs' => array(
			    	'class' => 'hide'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_right_text_before']) ? $responsi_options['responsi_footer_right_text_before'] : 'Powered by',
			    'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$footer_controls_settings['responsi_footer_right_text_before_url'] = array(
			'control' => array(
			    'label'      => __('Text Link URL', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_content',
			    'settings'   => 'responsi_footer_right_text_before_url',
			    'type'       => 'itext',
			    'input_attrs' => array(
			    	'class' => 'hide'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_right_text_before_url']) ? $responsi_options['responsi_footer_right_text_before_url'] : 'http://a3rev.com',
			    'sanitize_callback' => 'esc_url',
			)
		);

		$footer_controls_settings['responsi_footer_right_logo'] = array(
			'control' => array(
			    'label'      => __('Developer Logo', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_content',
			    'settings'   => 'responsi_footer_right_logo',
			    'type'       => 'iupload',
			    'input_attrs' => array(
			    	'class' => 'hide'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_right_logo']) ? $responsi_options['responsi_footer_right_logo'] : get_template_directory_uri().'/images/a3rev.png',
			    'sanitize_callback' => 'esc_url',
			)
		);

		$footer_controls_settings['responsi_footer_right_logo_url'] = array(
			'control' => array(
			    'label'      => __('Developer Logo URL', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_content',
			    'settings'   => 'responsi_footer_right_logo_url',
			    'type'       => 'itext',
			    'input_attrs' => array(
			    	'class' => 'hide'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_right_logo_url']) ? $responsi_options['responsi_footer_right_logo_url'] : 'http://a3rev.com',
			    'sanitize_callback' => 'esc_url',
			)
		);

		$footer_controls_settings['responsi_footer_right_text_after'] = array(
			'control' => array(
			    'label'      => __('Text After Image', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_content',
			    'settings'   => 'responsi_footer_right_text_after',
			    'type'       => 'itext',
			    'input_attrs' => array(
			    	'class' => 'hide'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_right_text_after']) ? $responsi_options['responsi_footer_right_text_after'] : '',
			    'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$footer_controls_settings['responsi_footer_right_text_after_url'] = array(
			'control' => array(
			    'label'      => __('Text Link URL', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_content',
			    'settings'   => 'responsi_footer_right_text_after_url',
			    'type'       => 'itext',
			    'input_attrs' => array(
			    	'class' => 'hide last'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_right_text_after_url']) ? $responsi_options['responsi_footer_right_text_after_url'] : '',
			    'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$footer_controls_settings['footer_label777'] = array(
			'control' => array(
			    'label'      => __('Footer Notices Font', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_content',
			    'settings'    => 'footer_label777',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);
		$footer_controls_settings['responsi_footer_font'] = array(
			'control' => array(
			    'label' => __('Font', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_content',
			    'settings'   => 'multiple',
			    'type'       => 'typography'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_font']) ? $responsi_options['responsi_footer_font'] : array('size' => '12','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#ffffff'),
			    'sanitize_callback' => 'responsi_sanitize_typography',
			    'transport'	=> 'postMessage'
			)
		);
		$footer_controls_settings['responsi_footer_link_color'] = array(
			'control' => array(
			    'label'      => __('Link Colour', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_content',
			    'settings'   => 'responsi_footer_link_color',
			    'type'       => 'icolor'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_link_color']) ? $responsi_options['responsi_footer_link_color'] : '#ffffff',
			    'sanitize_callback' => 'sanitize_hex_color',
			    'transport'	=> 'postMessage'
			)
		);
		$footer_controls_settings['responsi_footer_link_color_hover'] = array(
			'control' => array(
			    'label'      => __('Link Colour on Mouse Over', 'responsi'),
			    'description' => "",
			    'section'    => 'footer_content',
			    'settings'   => 'responsi_footer_link_color_hover',
			    'type'       => 'icolor'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_link_color_hover']) ? $responsi_options['responsi_footer_link_color_hover'] : '#ff0000',
			    'sanitize_callback' => 'sanitize_hex_color',
			    'transport'	=> 'postMessage'
			)
		);
		$footer_controls_settings = apply_filters( 'responsi_footer_controls_settings', $footer_controls_settings );
		$controls_settings = array_merge($controls_settings, $footer_controls_settings);
		return  $controls_settings ;
	}
}

new Responsi_Customize_Footer();
?>