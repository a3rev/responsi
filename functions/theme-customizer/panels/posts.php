<?php
class Responsi_Customize_Blog_Posts
{

	public function __construct() {
		add_action( 'customize_preview_init', array( $this, 'responsi_customize_preview_init' ), 11 );
		add_filter( 'responsi_default_options', array( $this, 'responsi_controls_settings' ) );
		add_filter( 'responsi_customize_register_panels',  array( $this, 'responsi_panels' ) );
		add_filter( 'responsi_customize_register_sections',  array( $this, 'responsi_sections' ) );
		add_filter( 'responsi_customize_register_settings',  array( $this, 'responsi_controls_settings' ) );
	}

	public function responsi_customize_preview_init() {
		wp_enqueue_script( 'responsi-customize-post' );
	}

	public function responsi_panels( $panels ){
		$posts_panels = array();
		$posts_panels['posts_settings_panel'] = array(
		    'title' => __('Blog Posts', 'responsi'),
		    'description' => '',
		    'priority' => 4.5,
		);
		$panels = array_merge($panels, $posts_panels);
		return  $panels ;
	}

	public function responsi_sections( $sections ){
		$posts_sections = array();
		
		$posts_sections['posts_style'] = array(
		    'title' => __('Post Style', 'responsi'),
		    'priority' => 1,
		    'panel' => 'posts_settings_panel',
		);
		$posts_sections['posts_layout'] = array(
		    'title' => __('Post Features', 'responsi'),
		    'priority' => 3,
		    'panel' => 'posts_settings_panel',
		);
		$sections = array_merge($sections, $posts_sections);
		return  $sections ;
	}

	public function responsi_controls_settings( $controls_settings ){

		global $responsi_options;

		$posts_controls_settings = array();

		$posts_controls_settings['post_label1'] = array(
			'control' => array(
			    'label'      => __('Post Container', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_style',
			    'settings'    => 'post_label1',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);
		$posts_controls_settings['responsi_post_box_bg'] = array(
			'control' => array(
			    'label'      => __('Background Color', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_style',
			    'settings'   => 'multiple',
			    'type'       => 'ibackground'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_post_box_bg']) ? $responsi_options['responsi_post_box_bg'] : array( 'onoff' => 'false', 'color' => '#ffffff'),
			    'sanitize_callback' => 'responsi_sanitize_background_color',
			    'transport'	=> 'postMessage'
			)
		);
		$posts_controls_settings['responsi_post_box_border'] = array(
			'control' => array(
			    'label' => __('Container Border', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_style',
			    'settings'   => 'multiple',
			    'type'       => 'border'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_post_box_border']) ? $responsi_options['responsi_post_box_border'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);
		$posts_controls_settings['responsi_post_box_border_radius'] = array(
			'control' => array(
			    'label'      => __('Border Corner', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_style',
			    'settings'   => 'multiple',
			    'type'       => 'border_radius'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_post_box_border_radius']) ? $responsi_options['responsi_post_box_border_radius'] : array('corner' => 'square','rounded_value' => '3'),
			    'sanitize_callback' => 'responsi_sanitize_border_radius',
			    'transport'	=> 'postMessage'
			)
		);
		$posts_controls_settings['responsi_post_box_shadow'] = array(
			'control' => array(
			    'label'      => __('Border Shadow', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_style',
			    'settings'   => 'multiple',
			    'type'       => 'box_shadow'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_post_box_shadow']) ? $responsi_options['responsi_post_box_shadow'] : array( 'onoff' => 'false' , 'h_shadow' => '0px' , 'v_shadow' => '0px', 'blur' => '8px' , 'spread' => '0px', 'color' => '#DBDBDB', 'inset' => '' ),
			    'sanitize_callback' => 'responsi_sanitize_box_shadow',
			    'transport'	=> 'postMessage'
			)
		);
		$posts_controls_settings['responsi_post_box_margin'] = array(
			'control' => array(
			    'label'      => __('Margin', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_style',
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
					isset($responsi_options['responsi_post_box_margin_top']) ? $responsi_options['responsi_post_box_margin_top'] : '0' ,
					isset($responsi_options['responsi_post_box_margin_bottom']) ? $responsi_options['responsi_post_box_margin_bottom'] : '0',
					isset($responsi_options['responsi_post_box_margin_left']) ? $responsi_options['responsi_post_box_margin_left'] : '0',
					isset($responsi_options['responsi_post_box_margin_right']) ? $responsi_options['responsi_post_box_margin_right'] : '0'
				),
				'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage',
			)
		);
		$posts_controls_settings['responsi_post_box_padding'] = array(
			'control' => array(
			    'label'      => __('Padding', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_style',
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
					isset($responsi_options['responsi_post_box_padding_top']) ? $responsi_options['responsi_post_box_padding_top'] : '0' ,
					isset($responsi_options['responsi_post_box_padding_bottom']) ? $responsi_options['responsi_post_box_padding_bottom'] : '0',
					isset($responsi_options['responsi_post_box_padding_left']) ? $responsi_options['responsi_post_box_padding_left'] : '0',
					isset($responsi_options['responsi_post_box_padding_right']) ? $responsi_options['responsi_post_box_padding_right'] : '0'
				),
				'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage',
			)
		);
		$posts_controls_settings['post_label2'] = array(
			'control' => array(
			    'label'      => __('Post Title', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_style',
			    'settings'    => 'post_label2',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);
		$posts_controls_settings['responsi_font_post_title'] = array(
			'control' => array(
			    'label' => __('Title Font', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_style',
			    'settings'   => 'multiple',
			    'type'       => 'typography'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_font_post_title']) ? $responsi_options['responsi_font_post_title'] : array('size' => '26','line_height' => '1.2','face' => 'Open Sans','style' => 'normal','color' => '#009ee0'),
			    'sanitize_callback' => 'responsi_sanitize_typography',
			    'transport'	=> 'postMessage'
			)
		);
		$posts_controls_settings['responsi_post_title_font_transform'] = array(
			'control' => array(
			    'label'      => __('Title Transformation', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_style',
			    'settings'   => 'responsi_post_title_font_transform',
			    'type'       => 'iradio',
			    'input_attrs' => array(
					'checked_label' => 'ON',
					'unchecked_label' => 'OFF',
					'container_width' => 80
		        ),
			    'choices' => array( "none" => "None","uppercase" => "Uppercase", "lowercase" => "Lowercase")
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_post_title_font_transform']) ? $responsi_options['responsi_post_title_font_transform'] : 'none',
			    'sanitize_callback' => 'responsi_sanitize_choices',
			    'transport'	=> 'postMessage'
			)
		);
		$posts_controls_settings['responsi_post_title_margin'] = array(
			'control' => array(
			    'label'      => __('Title Margin', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_style',
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
					isset($responsi_options['responsi_post_title_margin_top']) ? $responsi_options['responsi_post_title_margin_top'] : '0' ,
					isset($responsi_options['responsi_post_title_margin_bottom']) ? $responsi_options['responsi_post_title_margin_bottom'] : '0',
					isset($responsi_options['responsi_post_title_margin_left']) ? $responsi_options['responsi_post_title_margin_left'] : '0',
					isset($responsi_options['responsi_post_title_margin_right']) ? $responsi_options['responsi_post_title_margin_right'] : '0'
				),
				'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage',
			)
		);
		$posts_controls_settings['post_label1222'] = array(
			'control' => array(
			    'label'      => __('Post Content Font', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_style',
			    'settings'    => 'post_label1222',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);
		$posts_controls_settings['responsi_font_post_text'] = array(
			'control' => array(
			    'label' => __('Content Font', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_style',
			    'settings'   => 'multiple',
			    'type'       => 'typography'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_font_post_text']) ? $responsi_options['responsi_font_post_text'] : array('size' => '14','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#555555'),
			    'sanitize_callback' => 'responsi_sanitize_typography',
			    'transport'	=> 'postMessage'
			)
		);

		$posts_controls_settings['post_label4'] = array(
			'control' => array(
			    'label'      => __('Categories Meta Font', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_style',
			    'settings'    => 'post_label4',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);
		$posts_controls_settings['responsi_font_post_cat_tag'] = array(
			'control' => array(
			    'label' => __('Font', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_style',
			    'settings'   => 'multiple',
			    'type'       => 'typography'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_font_post_cat_tag']) ? $responsi_options['responsi_font_post_cat_tag'] : array('size' => '14','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#555555'),
			    'sanitize_callback' => 'responsi_sanitize_typography',
			    'transport'	=> 'postMessage'
			)
		);
		$posts_controls_settings['responsi_font_post_cat_tag_transform'] = array(
			'control' => array(
			    'label'      => __('Transformation', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_style',
			    'settings'   => 'responsi_font_post_cat_tag_transform',
			    'type'       => 'iradio',
			    'input_attrs' => array(
					'checked_label' => 'ON',
					'unchecked_label' => 'OFF',
					'container_width' => 80
		        ),
			    'choices' => array( "none" => "None","uppercase" => "Uppercase", "lowercase" => "Lowercase")
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_font_post_cat_tag_transform']) ? $responsi_options['responsi_font_post_cat_tag_transform'] : 'none',
			    'sanitize_callback' => 'responsi_sanitize_choices',
			    'transport'	=> 'postMessage'
			)
		);
		$posts_controls_settings['responsi_font_post_cat_tag_link'] = array(
			'control' => array(
			    'label'      => __('Text Link Colour', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_style',
			    'settings'   => 'responsi_font_post_cat_tag_link',
			    'type'       => 'icolor'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_font_post_cat_tag_link']) ? $responsi_options['responsi_font_post_cat_tag_link'] : '#009ee0',
			    'sanitize_callback' => 'sanitize_hex_color',
			    'transport'	=> 'postMessage'
			)
		);

		$posts_controls_settings['responsi_font_post_cat_tag_link_hover'] = array(
			'control' => array(
			    'label'      => __('Text Link Hover', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_style',
			    'settings'   => 'responsi_font_post_cat_tag_link_hover',
			    'type'       => 'icolor'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_font_post_cat_tag_link_hover']) ? $responsi_options['responsi_font_post_cat_tag_link_hover'] : '#ff6868',
			    'sanitize_callback' => 'sanitize_hex_color',
			    'transport'	=> 'postMessage'
			)
		);

		$posts_controls_settings['post_labelz4'] = array(
			'control' => array(
			    'label'      => __('Categories Meta Icon', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_style',
			    'settings'    => 'post_labelz4',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);

		$posts_controls_settings['responsi_enable_font_post_cat_tag_icon'] = array(
			'control' => array(
			    'label'      => __('Meta Icon', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_style',
			    'settings'   => 'responsi_enable_font_post_cat_tag_icon',
			    'type'       => 'icheckbox',
			    'choices' => array(
			    	'checked_label' => 'ON',
					'unchecked_label' => 'OFF'
		        ),
			    'input_attrs' => array(
			    	'class' => 'collapsed-custom'
		        ),
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_enable_font_post_cat_tag_icon']) ? $responsi_options['responsi_enable_font_post_cat_tag_icon'] : 'true',
			    'sanitize_callback' => 'responsi_sanitize_checkboxs',
			    'transport'	=> 'postMessage'
			)
		);

		$posts_controls_settings['responsi_font_post_cat_tag_icon'] = array(
			'control' => array(
			    'label'      => __('Icon Colour', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_style',
			    'settings'   => 'responsi_font_post_cat_tag_icon',
			    'type'       => 'icolor',
			    'input_attrs' => array(
			    	'class' => 'hide-custom hide-custom-last'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_font_post_cat_tag_icon']) ? $responsi_options['responsi_font_post_cat_tag_icon'] : '#555555',
			    'sanitize_callback' => 'sanitize_hex_color',
			    'transport'	=> 'postMessage'
			)
		);

		$posts_controls_settings['post_labelz14'] = array(
			'control' => array(
			    'label'      => __('Categories Meta Container', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_style',
			    'settings'    => 'post_labelz14',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);

		$posts_controls_settings['responsi_post_meta_cat_tag_bg'] = array(
			'control' => array(
			    'label'      => __('Background Color', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_style',
			    'settings'   => 'multiple',
			    'type'       => 'ibackground'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_post_meta_cat_tag_bg']) ? $responsi_options['responsi_post_meta_cat_tag_bg'] : array( 'onoff' => 'false', 'color' => '#ffffff'),
			    'sanitize_callback' => 'responsi_sanitize_background_color',
			    'transport'	=> 'postMessage'
			)
		);
		$posts_controls_settings['responsi_post_meta_cat_tag_border_top'] = array(
			'control' => array(
			    'label' => __('Border - Top', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_style',
			    'settings'   => 'multiple',
			    'type'       => 'border'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_post_meta_cat_tag_border_top']) ? $responsi_options['responsi_post_meta_cat_tag_border_top'] : array('width' => '0','style' => 'solid','color' => '#E6E6E6'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);
		$posts_controls_settings['responsi_post_meta_cat_tag_border_bottom'] = array(
			'control' => array(
			    'label' => __('Border - Bottom', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_style',
			    'settings'   => 'multiple',
			    'type'       => 'border'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_post_meta_cat_tag_border_bottom']) ? $responsi_options['responsi_post_meta_cat_tag_border_bottom'] : array('width' => '0','style' => 'solid','color' => '#E6E6E6'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);
		$posts_controls_settings['responsi_post_meta_cat_tag_border_lr'] = array(
			'control' => array(
			    'label' => __('Border - Left / Righ', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_style',
			    'settings'   => 'multiple',
			    'type'       => 'border'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_post_meta_cat_tag_border_lr']) ? $responsi_options['responsi_post_meta_cat_tag_border_lr'] : array('width' => '0','style' => 'solid','color' => '#E6E6E6'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);
		$posts_controls_settings['responsi_post_meta_cat_tag_border_radius'] = array(
			'control' => array(
			    'label'      => __('Border Corner', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_style',
			    'settings'   => 'multiple',
			    'type'       => 'border_radius'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_post_meta_cat_tag_border_radius']) ? $responsi_options['responsi_post_meta_cat_tag_border_radius'] : array('corner' => 'square','rounded_value' => '0'),
			    'sanitize_callback' => 'responsi_sanitize_border_radius',
			    'transport'	=> 'postMessage'
			)
		);
		$posts_controls_settings['responsi_post_meta_cat_tag_margin'] = array(
			'control' => array(
			    'label'      => __('Margin', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_style',
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
					isset($responsi_options['responsi_post_meta_cat_tag_margin_top']) ? $responsi_options['responsi_post_meta_cat_tag_margin_top'] : '0' ,
					isset($responsi_options['responsi_post_meta_cat_tag_margin_bottom']) ? $responsi_options['responsi_post_meta_cat_tag_margin_bottom'] : '10',
					isset($responsi_options['responsi_post_meta_cat_tag_margin_left']) ? $responsi_options['responsi_post_meta_cat_tag_margin_left'] : '0',
					isset($responsi_options['responsi_post_meta_cat_tag_margin_right']) ? $responsi_options['responsi_post_meta_cat_tag_margin_right'] : '0'
				),
				'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage',
			)
		);
		$posts_controls_settings['responsi_post_meta_cat_tag_padding'] = array(
			'control' => array(
			    'label'      => __('Padding', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_style',
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
					isset($responsi_options['responsi_post_meta_cat_tag_padding_top']) ? $responsi_options['responsi_post_meta_cat_tag_padding_top'] : '0' ,
					isset($responsi_options['responsi_post_meta_cat_tag_padding_bottom']) ? $responsi_options['responsi_post_meta_cat_tag_padding_bottom'] : '0',
					isset($responsi_options['responsi_post_meta_cat_tag_padding_left']) ? $responsi_options['responsi_post_meta_cat_tag_padding_left'] : '0',
					isset($responsi_options['responsi_post_meta_cat_tag_padding_right']) ? $responsi_options['responsi_post_meta_cat_tag_padding_right'] : '0'
				),
				'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage',
			)
		);

		$posts_controls_settings['post_label411'] = array(
			'control' => array(
			    'label'      => __('Tag Meta Font', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_style',
			    'settings'    => 'post_label411',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);
		$posts_controls_settings['responsi_font_post_utility_tag'] = array(
			'control' => array(
			    'label' => __('Font', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_style',
			    'settings'   => 'multiple',
			    'type'       => 'typography'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_font_post_utility_tag']) ? $responsi_options['responsi_font_post_utility_tag'] : array('size' => '14','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#555555'),
			    'sanitize_callback' => 'responsi_sanitize_typography',
			    'transport'	=> 'postMessage'
			)
		);
		$posts_controls_settings['responsi_font_post_utility_tag_transform'] = array(
			'control' => array(
			    'label'      => __('Transformation', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_style',
			    'settings'   => 'responsi_font_post_utility_tag_transform',
			    'type'       => 'iradio',
			    'input_attrs' => array(
					'checked_label' => 'ON',
					'unchecked_label' => 'OFF',
					'container_width' => 80
		        ),
			    'choices' => array( "none" => "None","uppercase" => "Uppercase", "lowercase" => "Lowercase")
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_font_post_utility_tag_transform']) ? $responsi_options['responsi_font_post_utility_tag_transform'] : 'none',
			    'sanitize_callback' => 'responsi_sanitize_choices',
			    'transport'	=> 'postMessage'
			)
		);
		$posts_controls_settings['responsi_font_post_utility_tag_link'] = array(
			'control' => array(
			    'label'      => __('Text Link Colour', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_style',
			    'settings'   => 'responsi_font_post_utility_tag_link',
			    'type'       => 'icolor'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_font_post_utility_tag_link']) ? $responsi_options['responsi_font_post_utility_tag_link'] : '#009ee0',
			    'sanitize_callback' => 'sanitize_hex_color',
			    'transport'	=> 'postMessage'
			)
		);

		$posts_controls_settings['responsi_font_post_utility_tag_link_hover'] = array(
			'control' => array(
			    'label'      => __('Text Link Hover', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_style',
			    'settings'   => 'responsi_font_post_utility_tag_link_hover',
			    'type'       => 'icolor'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_font_post_utility_tag_link_hover']) ? $responsi_options['responsi_font_post_utility_tag_link_hover'] : '#ff6868',
			    'sanitize_callback' => 'sanitize_hex_color',
			    'transport'	=> 'postMessage'
			)
		);

		$posts_controls_settings['post_labelv4'] = array(
			'control' => array(
			    'label'      => __('Tag Meta Icon', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_style',
			    'settings'    => 'post_labelv4',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);

		$posts_controls_settings['responsi_enable_font_post_utility_tag_icon'] = array(
			'control' => array(
			    'label'      => __('Meta Icon', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_style',
			    'settings'   => 'responsi_enable_font_post_utility_tag_icon',
			    'type'       => 'icheckbox',
			    'choices' => array(
			    	'checked_label' => 'ON',
					'unchecked_label' => 'OFF'
		        ),
			    'input_attrs' => array(
			    	'class' => 'collapsed-custom'
		        ),
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_enable_font_post_utility_tag_icon']) ? $responsi_options['responsi_enable_font_post_utility_tag_icon'] : 'true',
			    'sanitize_callback' => 'responsi_sanitize_checkboxs',
			    'transport'	=> 'postMessage'
			)
		);

		$posts_controls_settings['responsi_font_post_utility_tag_icon'] = array(
			'control' => array(
			    'label'      => __('Icon Colour', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_style',
			    'settings'   => 'responsi_font_post_utility_tag_icon',
			    'type'       => 'icolor',
			    'input_attrs' => array(
			    	'class' => 'hide-custom hide-custom-last'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_font_post_utility_tag_icon']) ? $responsi_options['responsi_font_post_utility_tag_icon'] : '#555555',
			    'sanitize_callback' => 'sanitize_hex_color',
			    'transport'	=> 'postMessage'
			)
		);

		$posts_controls_settings['post_labelv45'] = array(
			'control' => array(
			    'label'      => __('Tag Meta Container', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_style',
			    'settings'    => 'post_labelv45',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);

		$posts_controls_settings['responsi_post_meta_utility_tag_bg'] = array(
			'control' => array(
			    'label'      => __('Background Color', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_style',
			    'settings'   => 'multiple',
			    'type'       => 'ibackground'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_post_meta_utility_tag_bg']) ? $responsi_options['responsi_post_meta_utility_tag_bg'] : array( 'onoff' => 'false', 'color' => '#ffffff'),
			    'sanitize_callback' => 'responsi_sanitize_background_color',
			    'transport'	=> 'postMessage'
			)
		);
		$posts_controls_settings['responsi_post_meta_utility_tag_border_top'] = array(
			'control' => array(
			    'label' => __('Border - Top', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_style',
			    'settings'   => 'multiple',
			    'type'       => 'border'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_post_meta_utility_tag_border_top']) ? $responsi_options['responsi_post_meta_utility_tag_border_top'] : array('width' => '0','style' => 'solid','color' => '#E6E6E6'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);
		$posts_controls_settings['responsi_post_meta_utility_tag_border_bottom'] = array(
			'control' => array(
			    'label' => __('Border - Bottom', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_style',
			    'settings'   => 'multiple',
			    'type'       => 'border'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_post_meta_utility_tag_border_bottom']) ? $responsi_options['responsi_post_meta_utility_tag_border_bottom'] : array('width' => '0','style' => 'solid','color' => '#E6E6E6'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);
		$posts_controls_settings['responsi_post_meta_utility_tag_border_lr'] = array(
			'control' => array(
			    'label' => __('Border - Left / Righ', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_style',
			    'settings'   => 'multiple',
			    'type'       => 'border'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_post_meta_utility_tag_border_lr']) ? $responsi_options['responsi_post_meta_utility_tag_border_lr'] : array('width' => '0','style' => 'solid','color' => '#E6E6E6'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);
		$posts_controls_settings['responsi_post_meta_utility_tag_border_radius'] = array(
			'control' => array(
			    'label'      => __('Border Corner', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_style',
			    'settings'   => 'multiple',
			    'type'       => 'border_radius'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_post_meta_utility_tag_border_radius']) ? $responsi_options['responsi_post_meta_utility_tag_border_radius'] : array('corner' => 'square','rounded_value' => '0'),
			    'sanitize_callback' => 'responsi_sanitize_border_radius',
			    'transport'	=> 'postMessage'
			)
		);
		$posts_controls_settings['responsi_post_meta_utility_tag_margin'] = array(
			'control' => array(
			    'label'      => __('Margin', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_style',
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
					isset($responsi_options['responsi_post_meta_utility_tag_margin_top']) ? $responsi_options['responsi_post_meta_utility_tag_margin_top'] : '0' ,
					isset($responsi_options['responsi_post_meta_utility_tag_margin_bottom']) ? $responsi_options['responsi_post_meta_utility_tag_margin_bottom'] : '10',
					isset($responsi_options['responsi_post_meta_utility_tag_margin_left']) ? $responsi_options['responsi_post_meta_utility_tag_margin_left'] : '0',
					isset($responsi_options['responsi_post_meta_utility_tag_margin_right']) ? $responsi_options['responsi_post_meta_utility_tag_margin_right'] : '0'
				),
				'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage',
			)
		);
		$posts_controls_settings['responsi_post_meta_utility_tag_padding'] = array(
			'control' => array(
			    'label'      => __('Padding', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_style',
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
					isset($responsi_options['responsi_post_meta_utility_tag_padding_top']) ? $responsi_options['responsi_post_meta_utility_tag_padding_top'] : '0' ,
					isset($responsi_options['responsi_post_meta_utility_tag_padding_bottom']) ? $responsi_options['responsi_post_meta_utility_tag_padding_bottom'] : '0',
					isset($responsi_options['responsi_post_meta_utility_tag_padding_left']) ? $responsi_options['responsi_post_meta_utility_tag_padding_left'] : '0',
					isset($responsi_options['responsi_post_meta_utility_tag_padding_right']) ? $responsi_options['responsi_post_meta_utility_tag_padding_right'] : '0'
				),
				'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage',
			)
		);

		$posts_controls_settings['post_layout_label1'] = array(
			'control' => array(
			    'label'      => __('Post Title Meta', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_layout',
			    'settings'    => 'post_layout_label1',
			    'type'       => 'ilabel',
			    'priority' => 3,
			),
			'setting' => array()
		);

		$posts_controls_settings['responsi_disable_post_meta_author'] = array(
			'control' => array(
			    'label'      => __('Post Author', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_layout',
			    'settings'   => 'responsi_disable_post_meta_author',
			    'type'       => 'icheckbox'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_disable_post_meta_author']) ? $responsi_options['responsi_disable_post_meta_author'] : 'true',
			    'sanitize_callback' => 'responsi_sanitize_checkboxs',
			    'transport'	=> 'postMessage',
			)
		);

		$posts_controls_settings['responsi_disable_post_meta_date'] = array(
			'control' => array(
			    'label'      => __('Post Date', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_layout',
			    'settings'   => 'responsi_disable_post_meta_date',
			    'type'       => 'icheckbox'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_disable_post_meta_date']) ? $responsi_options['responsi_disable_post_meta_date'] : 'true',
			    'sanitize_callback' => 'responsi_sanitize_checkboxs',
			    'transport'	=> 'postMessage',
			)
		);

		$posts_controls_settings['responsi_disable_post_meta_comment'] = array(
			'control' => array(
			    'label'      => __('Post Comment Count', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_layout',
			    'settings'   => 'responsi_disable_post_meta_comment',
			    'type'       => 'icheckbox'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_disable_post_meta_comment']) ? $responsi_options['responsi_disable_post_meta_comment'] : 'true',
			    'sanitize_callback' => 'responsi_sanitize_checkboxs',
			    'transport'	=> 'postMessage',
			)
		);

		$posts_controls_settings['post_label3'] = array(
			'control' => array(
			    'label'      => __('Post Title Meta Font', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_layout',
			    'settings'    => 'post_label3',
			    'type'       => 'ilabel',
			    'input_attrs' => array(
			    	'class' => 'single-post-meta'
		        )
			),
			'setting' => array()
		);
		$posts_controls_settings['responsi_font_post_meta'] = array(
			'control' => array(
			    'label' => __('Font', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_layout',
			    'settings'   => 'multiple',
			    'type'       => 'typography',
			    'input_attrs' => array(
			    	'class' => 'single-post-meta'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_font_post_meta']) ? $responsi_options['responsi_font_post_meta'] : array('size' => '12','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#555555'),
			    'sanitize_callback' => 'responsi_sanitize_typography',
			    'transport'	=> 'postMessage'
			)
		);
		$posts_controls_settings['responsi_post_meta_transform'] = array(
			'control' => array(
			    'label'      => __('Transformation', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_layout',
			    'settings'   => 'responsi_post_meta_transform',
			    'type'       => 'iradio',
			    'input_attrs' => array(
					'checked_label' => 'ON',
					'unchecked_label' => 'OFF',
					'container_width' => 80,
					'class' => 'single-post-meta'
		        ),
			    'choices' => array( "none" => "None","uppercase" => "Uppercase", "lowercase" => "Lowercase")
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_post_meta_transform']) ? $responsi_options['responsi_post_meta_transform'] : 'none',
			    'sanitize_callback' => 'responsi_sanitize_choices',
			    'transport'	=> 'postMessage'
			)
		);

		$posts_controls_settings['responsi_post_meta_link'] = array(
			'control' => array(
			    'label'      => __('Text Link Colour', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_layout',
			    'settings'   => 'responsi_post_meta_link',
			    'type'       => 'icolor',
			    'input_attrs' => array(
			    	'class' => 'single-post-meta'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_post_meta_link']) ? $responsi_options['responsi_post_meta_link'] : '#009ee0',
			    'sanitize_callback' => 'sanitize_hex_color',
			    'transport'	=> 'postMessage'
			)
		);

		$posts_controls_settings['responsi_post_meta_link_hover'] = array(
			'control' => array(
			    'label'      => __('Text Link Hover', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_layout',
			    'settings'   => 'responsi_post_meta_link_hover',
			    'type'       => 'icolor',
			    'input_attrs' => array(
			    	'class' => 'single-post-meta'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_post_meta_link_hover']) ? $responsi_options['responsi_post_meta_link_hover'] : '#ff6868',
			    'sanitize_callback' => 'sanitize_hex_color',
			    'transport'	=> 'postMessage'
			)
		);

		$posts_controls_settings['post_labelvv3'] = array(
			'control' => array(
			    'label'      => __('Post Title Meta Icons', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_layout',
			    'settings'    => 'post_labelvv3',
			    'type'       => 'ilabel',
			    'input_attrs' => array(
			    	'class' => 'single-post-meta'
		        )
			),
			'setting' => array()
		);

		$posts_controls_settings['responsi_enable_post_meta_icon'] = array(
			'control' => array(
			    'label'      => __('Meta Icons', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_layout',
			    'settings'   => 'responsi_enable_post_meta_icon',
			    'type'       => 'icheckbox',
			    'choices' => array(
			    	'checked_label' => 'ON',
					'unchecked_label' => 'OFF'
		        ),
			    'input_attrs' => array(
			    	'class' => 'collapsed-custom single-post-meta'
		        ),
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_enable_post_meta_icon']) ? $responsi_options['responsi_enable_post_meta_icon'] : 'true',
			    'sanitize_callback' => 'responsi_sanitize_checkboxs',
			    'transport'	=> 'postMessage'
			)
		);

		$posts_controls_settings['responsi_post_meta_icon'] = array(
			'control' => array(
			    'label'      => __('Icon Colour', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_layout',
			    'settings'   => 'responsi_post_meta_icon',
			    'type'       => 'icolor',
			    'input_attrs' => array(
			    	'class' => 'single-post-meta hide-custom hide-custom-last'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_post_meta_icon']) ? $responsi_options['responsi_post_meta_icon'] : '#555555',
			    'sanitize_callback' => 'sanitize_hex_color',
			    'transport'	=> 'postMessage'
			)
		);

		$posts_controls_settings['post_label355'] = array(
			'control' => array(
			    'label'      => __('Post Title Meta Container', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_layout',
			    'settings'    => 'post_label355',
			    'type'       => 'ilabel',
			    'input_attrs' => array(
			    	'class' => 'single-post-meta'
		        )
			),
			'setting' => array()
		);

		$posts_controls_settings['responsi_post_meta_bg'] = array(
			'control' => array(
			    'label'      => __('Background Color', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_layout',
			    'settings'   => 'multiple',
			    'type'       => 'ibackground',
			    'input_attrs' => array(
			    	'class' => 'single-post-meta'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_post_meta_bg']) ? $responsi_options['responsi_post_meta_bg'] : array( 'onoff' => 'false', 'color' => '#ffffff'),
			    'sanitize_callback' => 'responsi_sanitize_background_color',
			    'transport'	=> 'postMessage'
			)
		);
		$posts_controls_settings['responsi_post_meta_border_top'] = array(
			'control' => array(
			    'label' => __('Border - Top', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_layout',
			    'settings'   => 'multiple',
			    'type'       => 'border',
			    'input_attrs' => array(
			    	'class' => 'single-post-meta'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_post_meta_border_top']) ? $responsi_options['responsi_post_meta_border_top'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);
		$posts_controls_settings['responsi_post_meta_border_bottom'] = array(
			'control' => array(
			    'label' => __('Border - Bottom', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_layout',
			    'settings'   => 'multiple',
			    'type'       => 'border',
			    'input_attrs' => array(
			    	'class' => 'single-post-meta'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_post_meta_border_bottom']) ? $responsi_options['responsi_post_meta_border_bottom'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);
		$posts_controls_settings['responsi_post_meta_border_lr'] = array(
			'control' => array(
			    'label' => __('Border - Left / Right', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_layout',
			    'settings'   => 'multiple',
			    'type'       => 'border',
			    'input_attrs' => array(
			    	'class' => 'single-post-meta'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_post_meta_border_lr']) ? $responsi_options['responsi_post_meta_border_lr'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);
		$posts_controls_settings['responsi_post_meta_margin'] = array(
			'control' => array(
			    'label'      => __('Margin', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_layout',
			    'settings'   => 'multitext',
			    'type'       => 'multitext',
			    'choices' => array(
			    	'top' => 'Top',
					'bottom' => 'Bottom',
					'left' => 'Left',
					'right' => 'Right',
		        ),
			    'input_attrs' => array(
			    	'class' => 'single-post-meta'
		        )
			),
			'setting' => array(
				'default'		=> array(
					isset($responsi_options['responsi_post_meta_margin_top']) ? $responsi_options['responsi_post_meta_margin_top'] : '0' ,
					isset($responsi_options['responsi_post_meta_margin_bottom']) ? $responsi_options['responsi_post_meta_margin_bottom'] : '15',
					isset($responsi_options['responsi_post_meta_margin_left']) ? $responsi_options['responsi_post_meta_margin_left'] : '0',
					isset($responsi_options['responsi_post_meta_margin_right']) ? $responsi_options['responsi_post_meta_margin_right'] : '0'
				),
				'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage',
			)
		);
		$posts_controls_settings['responsi_post_meta_padding'] = array(
			'control' => array(
			    'label'      => __('Padding', 'responsi'),
			    'description' => "",
			    'section'    => 'posts_layout',
			    'settings'   => 'multitext',
			    'type'       => 'multitext',
			    'choices' => array(
			    	'top' => 'Top',
					'bottom' => 'Bottom',
					'left' => 'Left',
					'right' => 'Right',
		        ),
			    'input_attrs' => array(
			    	'class' => 'single-post-meta'
		        )
			),
			'setting' => array(
				'default'		=> array(
					isset($responsi_options['responsi_post_meta_padding_top']) ? $responsi_options['responsi_post_meta_padding_top'] : '0' ,
					isset($responsi_options['responsi_post_meta_padding_bottom']) ? $responsi_options['responsi_post_meta_padding_bottom'] : '0',
					isset($responsi_options['responsi_post_meta_padding_left']) ? $responsi_options['responsi_post_meta_padding_left'] : '0',
					isset($responsi_options['responsi_post_meta_padding_right']) ? $responsi_options['responsi_post_meta_padding_right'] : '0'
				),
				'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage',
			)
		);
		$posts_controls_settings = apply_filters( 'responsi_posts_controls_settings', $posts_controls_settings );
		$controls_settings = array_merge($controls_settings, $posts_controls_settings);
		return  $controls_settings ;
	}
}

new Responsi_Customize_Blog_Posts();
?>