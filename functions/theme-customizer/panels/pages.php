<?php
class Responsi_Customize_Pages
{

	public function __construct() {
		add_action( 'customize_preview_init', array( $this, 'responsi_customize_preview_init' ), 11 );
		add_filter( 'responsi_default_options', array( $this, 'responsi_controls_settings' ) );
		add_filter( 'responsi_customize_register_panels',  array( $this, 'responsi_panels' ) );
		add_filter( 'responsi_customize_register_sections',  array( $this, 'responsi_sections' ) );
		add_filter( 'responsi_customize_register_settings',  array( $this, 'responsi_controls_settings' ) );
	}

	public function responsi_customize_preview_init() {
		wp_enqueue_script( 'responsi-customize-page' );
	}

	public function responsi_panels( $panels ){
		$pages_panels = array();
		$pages_panels['pages_panel'] = array(
		    'title' => __('Pages', 'responsi'),
		    'priority' => 4,
		);
		$panels = array_merge($panels, $pages_panels);
		return  $panels ;
	}

	public function responsi_sections( $sections ){
		$pages_sections = array();
		$pages_sections['page_style'] = array(
		    'title' => __('Pages Style', 'responsi'),
		    'priority' => 10,
		    'panel' => 'pages_panel',
		);
		$pages_sections['page_archive'] = array(
		    'title' => __('Archive Pages - Style', 'responsi'),
		    'priority' => 10,
		    'panel' => 'pages_panel',
		);
		$pages_sections['page_archive_features'] = array(
		    'title' => __('Archive Pages - Features', 'responsi'),
		    'priority' => 10,
		    'panel' => 'pages_panel',
		);
		$pages_sections['settings_404'] = array(
		    'title' => __('404 Page', 'responsi'),
		    'priority' => 15,
		    'panel' => 'pages_panel',
		);
		
		$sections = array_merge($sections, $pages_sections);
		return  $sections ;
	}

	public function responsi_controls_settings( $controls_settings ){

		$_default = apply_filters( 'default_settings_options', false );
		
		if( $_default ){
			$responsi_options = array();
		}else{
			global $responsi_options;
		}

		$pages_controls_settings = array();
		$pages_controls_settings['lbpage1'] = array(
			'control' => array(
			    'label'      => __('Page Content Container', 'responsi'),
			    'section'    => 'page_style',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);
		$pages_controls_settings['responsi_page_box_bg'] = array(
			'control' => array(
			    'label'      => __('Background Color', 'responsi'),
			    'section'    => 'page_style',
			    'settings'   => 'multiple',
			    'type'       => 'ibackground'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_page_box_bg']) ? $responsi_options['responsi_page_box_bg'] :  array( 'onoff' => 'false', 'color' => '#ffffff'),
			    'sanitize_callback' => 'responsi_sanitize_background_color',
			    'transport'	=> 'postMessage'
			)
		);
		$pages_controls_settings['responsi_page_box_border'] = array(
			'control' => array(
			    'label' => __('Content Container Border', 'responsi'),
			    'section'    => 'page_style',
			    'settings'   => 'multiple',
			    'type'       => 'border_boxes'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_page_box_border']) ? $responsi_options['responsi_page_box_border'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB','corner' => 'square', 'topleft' => '0', 'topright' => '0', 'bottomright' => '0', 'bottomleft' => '0'),
			    'sanitize_callback' => 'responsi_sanitize_border_boxes',
			    'transport'	=> 'postMessage'
			)
		);

		$pages_controls_settings['responsi_page_box_shadow'] = array(
			'control' => array(
			    'label'      => __('Border Shadow', 'responsi'),
			    'section'    => 'page_style',
			    'settings'   => 'multiple',
			    'type'       => 'box_shadow'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_page_box_shadow']) ? $responsi_options['responsi_page_box_shadow'] : array( 'onoff' => 'false' , 'h_shadow' => '0px' , 'v_shadow' => '0px', 'blur' => '8px' , 'spread' => '0px', 'color' => '#DBDBDB', 'inset' => '' ),
			    'sanitize_callback' => 'responsi_sanitize_box_shadow',
			    'transport'	=> 'postMessage'
			)
		);
		$pages_controls_settings['responsi_page_box_margin'] = array(
			'control' => array(
			    'label'      => __('Margin', 'responsi'),
			    'section'    => 'page_style',
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
					isset($responsi_options['responsi_page_box_margin_top']) ? $responsi_options['responsi_page_box_margin_top'] : '0' , 
					isset($responsi_options['responsi_page_box_margin_bottom']) ? $responsi_options['responsi_page_box_margin_bottom'] : '0',
					isset($responsi_options['responsi_page_box_margin_left']) ? $responsi_options['responsi_page_box_margin_left'] : '0',
					isset($responsi_options['responsi_page_box_margin_right']) ? $responsi_options['responsi_page_box_margin_right'] : '0'
				),
				'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage',
			)
		);
		$pages_controls_settings['responsi_page_box_padding'] = array(
			'control' => array(
			    'label'      => __('Padding', 'responsi'),
			    'section'    => 'page_style',
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
					isset($responsi_options['responsi_page_box_padding_top']) ? $responsi_options['responsi_page_box_padding_top'] : '0' , 
					isset($responsi_options['responsi_page_box_padding_bottom']) ? $responsi_options['responsi_page_box_padding_bottom'] : '0',
					isset($responsi_options['responsi_page_box_padding_left']) ? $responsi_options['responsi_page_box_padding_left'] : '0',
					isset($responsi_options['responsi_page_box_padding_right']) ? $responsi_options['responsi_page_box_padding_right'] : '0'
				),
				'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage',
			)
		);

		$pages_controls_settings['lbpage2'] = array(
			'control' => array(
			    'label'      => __('Page Title Style', 'responsi'),
			    'section'    => 'page_style',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);
		$pages_controls_settings['responsi_page_title_font'] = array(
			'control' => array(
			    'label' => __('Title Font', 'responsi'),
			    'section'    => 'page_style',
			    'settings'   => 'multiple',
			    'type'       => 'typography'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_page_title_font']) ? $responsi_options['responsi_page_title_font'] : array('size' => '26','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#009ee0'),
			    'sanitize_callback' => 'responsi_sanitize_typography',
			    'transport'	=> 'postMessage'
			)
		);
		$pages_controls_settings['responsi_page_title_font_transform'] = array(
			'control' => array(
			    'label'      => __('Title Transformation', 'responsi'),
			    'section'    => 'page_style',
			    'settings'   => 'responsi_page_title_font_transform',
			    'type'       => 'iradio',
			    'input_attrs' => array(
					'checked_label' => 'ON',
					'unchecked_label' => 'OFF',
					'container_width' => 80
		        ),
			    'choices' => array( "none" => __('None', 'responsi'),"uppercase" => __('Uppercase', 'responsi'), "lowercase" => __('Lowercase', 'responsi'))
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_page_title_font_transform']) ? $responsi_options['responsi_page_title_font_transform'] : 'none',
			    'sanitize_callback' => 'responsi_sanitize_choices',
			    'transport'	=> 'postMessage'
			)
		);
		$pages_controls_settings['responsi_page_title_position'] = array(
			'control' => array(
			    'label'      => __('Title Alignment', 'responsi'),
			    'section'    => 'page_style',
			    'settings'   => 'responsi_page_title_position',
			    'type'       => 'iradio',
			    'input_attrs' => array(
					'checked_label' => 'ON',
					'unchecked_label' => 'OFF',
					'container_width' => 80
		        ),
			    'choices' => array( "left" => __('Left', 'responsi'),"center" => __('Center', 'responsi'), "right" => __('Right', 'responsi'))
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_page_title_position']) ? $responsi_options['responsi_page_title_position'] : 'left',
			    'sanitize_callback' => 'responsi_sanitize_choices',
			    'transport'	=> 'postMessage'
			)
		);
		$pages_controls_settings['responsi_page_title_margin'] = array(
			'control' => array(
			    'label'      => __('Title Margin', 'responsi'),
			    'section'    => 'page_style',
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
					isset($responsi_options['responsi_page_title_margin_top']) ? $responsi_options['responsi_page_title_margin_top'] : '0' , 
					isset($responsi_options['responsi_page_title_margin_bottom']) ? $responsi_options['responsi_page_title_margin_bottom'] : '15',
					isset($responsi_options['responsi_page_title_margin_left']) ? $responsi_options['responsi_page_title_margin_left'] : '0',
					isset($responsi_options['responsi_page_title_margin_right']) ? $responsi_options['responsi_page_title_margin_right'] : '0'
				),
				'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage',
			)
		);
		$pages_controls_settings['lbpage3'] = array(
			'control' => array(
			    'label'      => __('Page Content Font Style', 'responsi'),
			    'section'    => 'page_style',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);
		$pages_controls_settings['responsi_page_content_font'] = array(
			'control' => array(
			    'label' => __('Content Font', 'responsi'),
			    'section'    => 'page_style',
			    'settings'   => 'multiple',
			    'type'       => 'typography'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_page_content_font']) ? $responsi_options['responsi_page_content_font'] :array('size' => '14','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#555555'),
			    'sanitize_callback' => 'responsi_sanitize_typography',
			    'transport'	=> 'postMessage'
			)
		);

		$pages_controls_settings['lbpage4'] = array(
			'control' => array(
			    'label'      => __('Page Content Container', 'responsi'),
			    'description' => __('Blog Page Template and WordPress Category and Tag and custom category and tag taxonomy pages - e.g. WooCommerce Shop page, product category and tag pages', 'responsi'),
			    'section'    => 'page_archive',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);
		$pages_controls_settings['responsi_archive_box_bg'] = array(
			'control' => array(
			    'label'      => __('Background Color', 'responsi'),
			    'section'    => 'page_archive',
			    'settings'   => 'multiple',
			    'type'       => 'ibackground'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_archive_box_bg']) ? $responsi_options['responsi_archive_box_bg'] : array( 'onoff' => 'false', 'color' => '#ffffff'),
			    'sanitize_callback' => 'responsi_sanitize_background_color',
			    'transport'	=> 'postMessage'
			)
		);
		$pages_controls_settings['responsi_archive_box_border'] = array(
			'control' => array(
			    'label' => __('Border', 'responsi'),
			    'section'    => 'page_archive',
			    'settings'   => 'multiple',
			    'type'       => 'border_boxes'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_archive_box_border']) ? $responsi_options['responsi_archive_box_border'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB','corner' => 'square', 'topleft' => '0', 'topright' => '0', 'bottomright' => '0', 'bottomleft' => '0'),
			    'sanitize_callback' => 'responsi_sanitize_border_boxes',
			    'transport'	=> 'postMessage'
			)
		);
		$pages_controls_settings['responsi_archive_box_shadow'] = array(
			'control' => array(
			    'label'      => __('Border Shadow', 'responsi'),
			    'section'    => 'page_archive',
			    'settings'   => 'multiple',
			    'type'       => 'box_shadow'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_archive_box_shadow']) ? $responsi_options['responsi_archive_box_shadow'] : array( 'onoff' => 'false' , 'h_shadow' => '0px' , 'v_shadow' => '0px', 'blur' => '0px' , 'spread' => '0px', 'color' => '#DBDBDB', 'inset' => '' ),
			    'sanitize_callback' => 'responsi_sanitize_box_shadow',
			    'transport'	=> 'postMessage'
			)
		);
		$pages_controls_settings['responsi_archive_box_margin'] = array(
			'control' => array(
			    'label'      => __('Margin', 'responsi'),
			    'section'    => 'page_archive',
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
					isset($responsi_options['responsi_archive_box_margin_top']) ? $responsi_options['responsi_archive_box_margin_top'] : '0' ,
					isset($responsi_options['responsi_archive_box_margin_bottom']) ? $responsi_options['responsi_archive_box_margin_bottom'] : '0',
					isset($responsi_options['responsi_archive_box_margin_left']) ? $responsi_options['responsi_archive_box_margin_left'] : '0',
					isset($responsi_options['responsi_archive_box_margin_right']) ? $responsi_options['responsi_archive_box_margin_right'] : '0'
				),
				'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage',
			)
		);
		$pages_controls_settings['responsi_archive_box_padding'] = array(
			'control' => array(
			    'label'      => __('Padding', 'responsi'),
			    'section'    => 'page_archive',
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
					isset($responsi_options['responsi_archive_box_padding_top']) ? $responsi_options['responsi_archive_box_padding_top'] : '0' ,
					isset($responsi_options['responsi_archive_box_padding_bottom']) ? $responsi_options['responsi_archive_box_padding_bottom'] : '0',
					isset($responsi_options['responsi_archive_box_padding_left']) ? $responsi_options['responsi_archive_box_padding_left'] : '0',
					isset($responsi_options['responsi_archive_box_padding_right']) ? $responsi_options['responsi_archive_box_padding_right'] : '0'
				),
				'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage',
			)
		);

		$pages_controls_settings['lbpage5'] = array(
			'control' => array(
			    'label'      => __('Archive Pages Title', 'responsi'),
			    'section'    => 'page_archive',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);
		$pages_controls_settings['responsi_archive_title_font'] = array(
			'control' => array(
			    'label' => __('Title Font', 'responsi'),
			    'section'    => 'page_archive',
			    'settings'   => 'multiple',
			    'type'       => 'typography'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_archive_title_font']) ? $responsi_options['responsi_archive_title_font'] : array('size' => '26','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#009ee0'),
			    'sanitize_callback' => 'responsi_sanitize_typography',
			    'transport'	=> 'postMessage'
			)
		);
		$pages_controls_settings['responsi_archive_title_font_transform'] = array(
			'control' => array(
			    'label'      => __('Title Transformation', 'responsi'),
			    'section'    => 'page_archive',
			    'settings'   => 'responsi_archive_title_font_transform',
			    'type'       => 'iradio',
			    'input_attrs' => array(
					'checked_label' => 'ON',
					'unchecked_label' => 'OFF',
					'container_width' => 80
		        ),
			    'choices' => array( "none" => __('None', 'responsi'),"uppercase" => __('Uppercase', 'responsi'), "lowercase" => __('Lowercase', 'responsi'))
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_archive_title_font_transform']) ? $responsi_options['responsi_archive_title_font_transform'] : 'none',
			    'sanitize_callback' => 'responsi_sanitize_choices',
			    'transport'	=> 'postMessage'
			)
		);
		$pages_controls_settings['responsi_archive_title_position'] = array(
			'control' => array(
			    'label'      => __('Title Alignment', 'responsi'),
			    'section'    => 'page_archive',
			    'settings'   => 'responsi_archive_title_position',
			    'type'       => 'iradio',
			    'input_attrs' => array(
					'checked_label' => 'ON',
					'unchecked_label' => 'OFF',
					'container_width' => 80
		        ),
			    'choices' => array( "left" => __('Left', 'responsi'),"center" => __('Center', 'responsi'), "right" => __('Right', 'responsi'))
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_archive_title_position']) ? $responsi_options['responsi_archive_title_position'] : 'left',
			    'sanitize_callback' => 'responsi_sanitize_choices',
			    'transport'	=> 'postMessage'
			)
		);
		$pages_controls_settings['responsi_archive_title_border_bottom'] = array(
			'control' => array(
			    'label' => __('Under Title Border', 'responsi'),
			    'section'    => 'page_archive',
			    'settings'   => 'multiple',
			    'type'       => 'border'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_archive_title_border_bottom']) ? $responsi_options['responsi_archive_title_border_bottom'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);
		$pages_controls_settings['responsi_archive_title_margin'] = array(
			'control' => array(
			    'label'      => __('Title Margin', 'responsi'),
			    'section'    => 'page_archive',
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
					isset($responsi_options['responsi_archive_title_margin_top']) ? $responsi_options['responsi_archive_title_margin_top'] : '0' , 
					isset($responsi_options['responsi_archive_title_margin_bottom']) ? $responsi_options['responsi_archive_title_margin_bottom'] : '0',
					isset($responsi_options['responsi_archive_title_margin_left']) ? $responsi_options['responsi_archive_title_margin_left'] : '0',
					isset($responsi_options['responsi_archive_title_margin_right']) ? $responsi_options['responsi_archive_title_margin_right'] : '0'
				),
				'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage',
			)
		);
		$pages_controls_settings['lbpage6'] = array(
			'control' => array(
			    'label'      => __('Custom Content Font', 'responsi'),
			    'section'    => 'page_archive',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);
		$pages_controls_settings['responsi_archive_content_font'] = array(
			'control' => array(
			    'label' => __('Font', 'responsi'),
			    'section'    => 'page_archive',
			    'settings'   => 'multiple',
			    'type'       => 'typography'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_archive_content_font']) ? $responsi_options['responsi_archive_content_font'] :array('size' => '14','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#555555'),
			    'sanitize_callback' => 'responsi_sanitize_typography',
			    'transport'	=> 'postMessage'
			)
		);
		$pages_controls_settings['lbpage7'] = array(
			'control' => array(
			    'label'      => __('Inner Container', 'responsi'),
			    'description' => __('Applies to the Archive Page title and any custom content added to the top of the page above the blog cards', 'responsi'),
			    'section'    => 'page_archive',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);
		$pages_controls_settings['responsi_enable_archive_title_box'] = array(
			'control' => array(
			    'label'      => __('Inner Container', 'responsi'),
			    'section'    => 'page_archive',
			    'settings'   => 'responsi_enable_archive_title_box',
			    'type'       => 'icheckbox',
			    'input_attrs' => array(
			    	'class' => 'collapsed'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_enable_archive_title_box']) ? $responsi_options['responsi_enable_archive_title_box'] : 'false',
			    'sanitize_callback' => 'responsi_sanitize_checkboxs',
			    'transport'	=> 'postMessage'
			)
		);
		$pages_controls_settings['responsi_archive_title_box_bg'] = array(
			'control' => array(
			    'label'      => __('Background Color', 'responsi'),
			    'section'    => 'page_archive',
			    'settings'   => 'multiple',
			    'type'       => 'ibackground',
		        'input_attrs' => array(
			    	'class' => 'hide'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_archive_title_box_bg']) ? $responsi_options['responsi_archive_title_box_bg'] : array( 'onoff' => 'false', 'color' => '#ffffff'),
			    'sanitize_callback' => 'responsi_sanitize_background_color',
			    'transport'	=> 'postMessage'
			)
		);
		$pages_controls_settings['responsi_archive_title_box_border'] = array(
			'control' => array(
			    'label' => __('Container Borders', 'responsi'),
			    'section'    => 'page_archive',
			    'settings'   => 'multiple',
			    'type'       => 'border_boxes',
		        'input_attrs' => array(
			    	'class' => 'hide'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_archive_title_box_border']) ? $responsi_options['responsi_archive_title_box_border'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB','corner' => 'square', 'topleft' => '0', 'topright' => '0', 'bottomright' => '0', 'bottomleft' => '0'),
			    'sanitize_callback' => 'responsi_sanitize_border_boxes',
			    'transport'	=> 'postMessage'
			)
		);
		$pages_controls_settings['responsi_archive_title_box_shadow'] = array(
			'control' => array(
			    'label'      => __('Border Shadow', 'responsi'),
			    'section'    => 'page_archive',
			    'settings'   => 'multiple',
			    'type'       => 'box_shadow',
		        'input_attrs' => array(
			    	'class' => 'hide'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_archive_title_box_shadow']) ? $responsi_options['responsi_archive_title_box_shadow'] : array( 'onoff' => 'false' , 'h_shadow' => '0px' , 'v_shadow' => '0px', 'blur' => '2px' , 'spread' => '0px', 'color' => '#DBDBDB', 'inset' => 'inset' ),
			    'sanitize_callback' => 'responsi_sanitize_box_shadow',
			    'transport'	=> 'postMessage'
			)
		);
		$pages_controls_settings['responsi_archive_title_box_margin'] = array(
			'control' => array(
			    'label'      => __('Margin', 'responsi'),
			    'section'    => 'page_archive',
			    'settings'   => 'multitext',
			    'type'       => 'multitext',
			    'choices' => array(
			    	'top' => 'Top',
					'bottom' => 'Bottom',
					'left' => 'Left',
					'right' => 'Right',
		        ),
		        'input_attrs' => array(
			    	'class' => 'hide'
		        )
			),
			'setting' => array(
				'default'		=> array( 
					isset($responsi_options['responsi_archive_title_box_margin_top']) ? $responsi_options['responsi_archive_title_box_margin_top'] : '0' , 
					isset($responsi_options['responsi_archive_title_box_margin_bottom']) ? $responsi_options['responsi_archive_title_box_margin_bottom'] : '20',
					isset($responsi_options['responsi_archive_title_box_margin_left']) ? $responsi_options['responsi_archive_title_box_margin_left'] : '0',
					isset($responsi_options['responsi_archive_title_box_margin_right']) ? $responsi_options['responsi_archive_title_box_margin_right'] : '0'
				),
				'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage',
			)
		);
		$pages_controls_settings['responsi_archive_title_box_padding'] = array(
			'control' => array(
			    'label'      => __('Padding', 'responsi'),
			    'section'    => 'page_archive',
			    'settings'   => 'multitext',
			    'type'       => 'multitext',
			    'choices' => array(
			    	'top' => 'Top',
					'bottom' => 'Bottom',
					'left' => 'Left',
					'right' => 'Right',
		        ),
		        'input_attrs' => array(
			    	'class' => 'hide last'
		        )
			),
			'setting' => array(
				'default'		=> array( 
					isset($responsi_options['responsi_archive_title_box_padding_top']) ? $responsi_options['responsi_archive_title_box_padding_top'] : '0' , 
					isset($responsi_options['responsi_archive_title_box_padding_bottom']) ? $responsi_options['responsi_archive_title_box_padding_bottom'] : '0',
					isset($responsi_options['responsi_archive_title_box_padding_left']) ? $responsi_options['responsi_archive_title_box_padding_left'] : '0',
					isset($responsi_options['responsi_archive_title_box_padding_right']) ? $responsi_options['responsi_archive_title_box_padding_right'] : '0'
				),
				'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage',
			)
		);

		$pages_controls_settings['lbpage8'] = array(
			'control' => array(
			    'label'      => __('Cards Per Endless Scroll', 'responsi'),
			    'section'    => 'page_archive_features',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);

		$pages_controls_settings['posts_per_page'] = array(
			'control' => array(
			    'label'      => __('Number of Cards to Load', 'responsi'),
			    'section'    => 'page_archive_features',
			    'settings'   => 'posts_per_page',
			    'type'       => 'itext'
			),
			'setting' => array(
				'type' => 'option',
				'sanitize_callback' => 'responsi_sanitize_numeric',
			    'default'		=> isset($responsi_options['posts_per_page']) ? $responsi_options['posts_per_page'] : get_option('posts_per_page')
			)
		);

		$pages_controls_settings['lbpage9'] = array(
			'control' => array(
			    'label'      => __('Endless Scroll - Style', 'responsi'),
			    'section'    => 'page_archive_features',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);

		$pages_controls_settings['responsi_showmore'] = array(
			'control' => array(
			    'label'      => __('Endless Scroll Load', 'responsi'),
			    'section'    => 'page_archive_features',
			    'settings'   => 'responsi_showmore',
			    'type'       => 'iswitcher',
			    'choices' => array(
			    	'checked_value' => 'click_showmore',
					'unchecked_value' => 'auto_showmore',
					"checked_label" => "CLICK TO LOAD",
					"unchecked_label" => "AUTO LOADING",
					"container_width" => 160
		        ),
		        'input_attrs' => array(
			    	'class' => 'collapsed-custom'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_showmore']) ? $responsi_options['responsi_showmore'] : 'auto_showmore',
			    'sanitize_callback' => 'responsi_sanitize_checkboxs',
			    //'transport'	=> 'postMessage'
			)
		);
		$pages_controls_settings['responsi_showmore_text'] = array(
			'control' => array(
			    'label'      => __('Click to Load Text', 'responsi'),
			    'section'    => 'page_archive_features',
			    'settings'   => 'responsi_showmore_text',
			    'type'       => 'itext',
			    'input_attrs' => array(
			    	'class' => 'hide-custom'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_showmore_text']) ? $responsi_options['responsi_showmore_text'] : 'SHOW MORE',
			    'sanitize_callback' => 'sanitize_text_field',
			    'transport'	=> 'postMessage'
			)
		);
		$pages_controls_settings['responsi_scroll_font'] = array(
			'control' => array(
			    'label' => __('Font', 'responsi'),
			    'section'    => 'page_archive_features',
			    'settings'   => 'multiple',
			    'type'       => 'typography',
			    'input_attrs' => array(
			    	'class' => 'hide-custom'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_scroll_font']) ? $responsi_options['responsi_scroll_font'] : array('size' => '15','line_height' => '1.5','face' => 'Open Sans','style' => 'bold','color' => '#f9bb02'),
			    'sanitize_callback' => 'responsi_sanitize_typography',
			    'transport'	=> 'postMessage'
			)
		);
		$pages_controls_settings['responsi_scroll_font_text_alignment'] = array(
			'control' => array(
			    'label'      => __('Alignment', 'responsi'),
			    'section'    => 'page_archive_features',
			    'settings'   => 'responsi_scroll_font_text_alignment',
			    'type'       => 'iradio',
			    'input_attrs' => array(
					'checked_label' => 'ON',
					'unchecked_label' => 'OFF',
					'container_width' => 80,
					'class' => 'hide-custom'
		        ),
			    'choices' => array("left" => "Left", "center" => "Center", "right" => "Right", "justify" => "Justify")
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_scroll_font_text_alignment']) ? $responsi_options['responsi_scroll_font_text_alignment'] : 'center',
			    'sanitize_callback' => 'responsi_sanitize_choices',
			    'transport'	=> 'postMessage'
			)
		);
		$pages_controls_settings['lbpage10'] = array(
			'control' => array(
			    'label'      => __('Click to Load Text Container', 'responsi'),
			    'section'    => 'page_archive_features',
			    'type'       => 'ilabel',
			    'input_attrs' => array(
			    	'class' => 'hide-custom'
		        )
			),
			'setting' => array()
		);

		$pages_controls_settings['responsi_scroll_box_bg'] = array(
			'control' => array(
			    'label'      => __('Background Colour', 'responsi'),
			    'section'    => 'page_archive_features',
			    'settings'   => 'multiple',
			    'type'       => 'ibackground',
			    'input_attrs' => array(
			    	'class' => 'hide-custom'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_scroll_box_bg']) ? $responsi_options['responsi_scroll_box_bg'] : array( 'onoff' => 'false', 'color' => '#ffffff'),
			    'sanitize_callback' => 'responsi_sanitize_background_color',
			    'transport'	=> 'postMessage'
			)
		);

		$pages_controls_settings['responsi_scroll_box_border_top'] = array(
			'control' => array(
			    'label' => __('Container Border - Top', 'responsi'),
			    'section'    => 'page_archive_features',
			    'settings'   => 'multiple',
			    'type'       => 'border',
			    'input_attrs' => array(
			    	'class' => 'hide-custom'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_scroll_box_border_top']) ? $responsi_options['responsi_scroll_box_border_top'] : array('width' => '2','style' => 'double','color' => '#F9BB03'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);
		$pages_controls_settings['responsi_scroll_box_border_bottom'] = array(
			'control' => array(
			    'label' => __('Container Border - Bottom', 'responsi'),
			    'section'    => 'page_archive_features',
			    'settings'   => 'multiple',
			    'type'       => 'border',
			    'input_attrs' => array(
			    	'class' => 'hide-custom'
		        ),
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_scroll_box_border_bottom']) ? $responsi_options['responsi_scroll_box_border_bottom'] : array('width' => '2','style' => 'double','color' => '#F9BB03'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);
		$pages_controls_settings['responsi_scroll_box_border_lr'] = array(
			'control' => array(
			    'label' => __('Container Border - Left / Right', 'responsi'),
			    'section'    => 'page_archive_features',
			    'settings'   => 'multiple',
			    'type'       => 'border',
			    'input_attrs' => array(
			    	'class' => 'hide-custom'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_scroll_box_border_lr']) ? $responsi_options['responsi_scroll_box_border_lr'] : array('width' => '0','style' => 'solid','color' => '#F9BB03'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);
		$pages_controls_settings['responsi_scroll_box_border_radius'] = array(
			'control' => array(
			    'label'      => __('Border Corner', 'responsi'),
			    'section'    => 'page_archive_features',
			    'settings'   => 'multiple',
			    'type'       => 'border_radius',
			    'input_attrs' => array(
			    	'class' => 'hide-custom'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_scroll_box_border_radius']) ? $responsi_options['responsi_scroll_box_border_radius'] : array( 'corner' => 'rounded' , 'rounded_value' => 0 ),
			    'sanitize_callback' => 'responsi_sanitize_border_radius',
			    'transport'	=> 'postMessage'
			)
		);
		$pages_controls_settings['responsi_scroll_box_shadow'] = array(
			'control' => array(
			    'label'      => __('Border Shadow', 'responsi'),
			    'section'    => 'page_archive_features',
			    'settings'   => 'multiple',
			    'type'       => 'box_shadow',
			    'input_attrs' => array(
			    	'class' => 'hide-custom'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_scroll_box_shadow']) ? $responsi_options['responsi_scroll_box_shadow'] : array( 'onoff' => 'false' , 'h_shadow' => '0px' , 'v_shadow' => '0px', 'blur' => '2px' , 'spread' => '0px', 'color' => '#DBDBDB', 'inset' => 'inset' ),
			    'sanitize_callback' => 'responsi_sanitize_box_shadow',
			    'transport'	=> 'postMessage'
			)
		);

		$pages_controls_settings['responsi_scroll_box_margin'] = array(
			'control' => array(
			    'label'      => __('Margin', 'responsi'),
			    'section'    => 'page_archive_features',
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
				'default'		=> array( 
					isset($responsi_options['responsi_scroll_box_margin_top']) ? $responsi_options['responsi_scroll_box_margin_top'] : '0' , 
					isset($responsi_options['responsi_scroll_box_margin_bottom']) ? $responsi_options['responsi_scroll_box_margin_bottom'] : '20',
					isset($responsi_options['responsi_scroll_box_margin_left']) ? $responsi_options['responsi_scroll_box_margin_left'] : '0',
					isset($responsi_options['responsi_scroll_box_margin_right']) ? $responsi_options['responsi_scroll_box_margin_right'] : '0'
				),
				'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage',
			)
		);

		$pages_controls_settings['responsi_scroll_box_padding'] = array(
			'control' => array(
			    'label'      => __('Padding', 'responsi'),
			    'section'    => 'page_archive_features',
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
				'default'		=> array( 
					isset($responsi_options['responsi_scroll_box_padding_top']) ? $responsi_options['responsi_scroll_box_padding_top'] : '5' , 
					isset($responsi_options['responsi_scroll_box_padding_bottom']) ? $responsi_options['responsi_scroll_box_padding_bottom'] : '5',
					isset($responsi_options['responsi_scroll_box_padding_left']) ? $responsi_options['responsi_scroll_box_padding_left'] : '5',
					isset($responsi_options['responsi_scroll_box_padding_right']) ? $responsi_options['responsi_scroll_box_padding_right'] : '5'
				),
				'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage',
			)
		);
		
		$pages_controls_settings['lbpage11'] = array(
			'control' => array(
			    'label'      => __('Blog Page - Exclude Categories', 'responsi'),
			    'section'    => 'page_archive_features',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);
		
		$pages_controls_settings['responsi_exclude_cats_blog'] = array(
			'control' => array(
			    'label'      => __( 'Category ID', 'responsi' ),
			    'description' => sprintf(__( 'Specify a comma seperated list of <a href="%s">Post Category</a> IDs or slugs that you want to exclude from your "Blog" page template (eg: uncategorized).', 'responsi' ), admin_url( 'edit-tags.php?taxonomy=category' )),
			    'section'    => 'page_archive_features',
			    'settings'   => 'responsi_exclude_cats_blog',
			    'type'       => 'itext'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_exclude_cats_blog']) ? $responsi_options['responsi_exclude_cats_blog'] : '',
			    'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$pages_controls_settings['lbpage12'] = array(
			'control' => array(
			    'label'      => __('Blog Category Pages RSS', 'responsi'),
				'section'    => 'page_archive_features',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);

		$pages_controls_settings['responsi_archive_header_disable_rss'] = array(
			'control' => array(
			    'label'      => __('Category Pages RSS Link', 'responsi'),
			    'section'    => 'page_archive_features',
			    'settings'   => 'responsi_archive_header_disable_rss',
			    'type'       => 'icheckbox'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_archive_header_disable_rss']) ? $responsi_options['responsi_archive_header_disable_rss'] : 'false',
			    'sanitize_callback' => 'responsi_sanitize_checkboxs',
			)
		);

		$pages_controls_settings['lbpage13'] = array(
			'control' => array(
			    'label'      => __('404 Page Not Found', 'responsi'),
				'section'    => 'settings_404',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);
		$pages_controls_settings['responsi_404_page'] = array(
			'control' => array(
			    'label'      => __('404 Page', 'responsi'),
			    'description' => __( 'Home page is default 404 error page visitors are redirected to when they encounter a broken link', 'responsi' ),
				'section'    => 'settings_404',
			    'settings'   => 'responsi_404_page',
			    'type'       => 'iselect',
			    'choices' => $this->responsi_list_page()
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_404_page']) ? $responsi_options['responsi_404_page'] : '0',
			    'sanitize_callback' => 'responsi_sanitize_choices',
			)
		);
		$pages_controls_settings = apply_filters( 'responsi_pages_controls_settings', $pages_controls_settings );
		$controls_settings = array_merge($controls_settings, $pages_controls_settings);
		return  $controls_settings ;
	}

	public function responsi_list_page(){
		$customize_list_page = array( '0' => __('Select a page:','responsi') );
		$responsi_pages_obj = get_pages('sort_column=post_parent,menu_order');
		foreach ($responsi_pages_obj as $responsi_page) {
		    $customize_list_page[$responsi_page->ID] = $responsi_page->post_title;
		}
		return $customize_list_page;
	}
}

new Responsi_Customize_Pages();
?>