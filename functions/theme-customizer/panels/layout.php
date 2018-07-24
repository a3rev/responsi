<?php
class Responsi_Customize_Layout
{

	public function __construct() {
		add_action( 'customize_preview_init', array( $this, 'responsi_customize_preview_init' ), 11 );
		add_filter( 'responsi_default_options', array( $this, 'responsi_controls_settings' ) );
		add_filter( 'responsi_customize_register_panels',  array( $this, 'responsi_panels' ),1 );
		add_filter( 'responsi_customize_register_sections',  array( $this, 'responsi_sections' ),1 );
		add_filter( 'responsi_customize_register_settings',  array( $this, 'responsi_controls_settings' ),1 );
	}

	public function responsi_customize_preview_init() {
		wp_enqueue_script( 'responsi-customize-layout' );
	}

	public function responsi_panels( $panels ){
		$layout_panels = array();
		$layout_panels['layout_settings_panel'] = array(
		    'title' => __('Site Structure', 'responsi'),
		    'priority' => 2,
		);
		$panels = array_merge($panels, $layout_panels);
		return  $panels ;
	}

	public function responsi_sections( $sections ){

		$layout_sections = array();
		$layout_sections['layout_style'] = array(
		    'title' => __('Site Layout', 'responsi'),
		    'priority' => 10,
		    'panel' => 'layout_settings_panel',
		);
		$layout_sections['site_structure'] = array(
		    'title' => __('Layout Structure', 'responsi'),
		    'priority' => 10,
		    'panel' => 'layout_settings_panel',
		);
		$layout_sections['background_theme'] = array(
		    'title' => __('Site Background', 'responsi'),
		    'priority' => 10,
		    'panel' => 'layout_settings_panel',
		);
		$layout_sections['content_body_style'] = array(
		    'title' => __('Site Body', 'responsi'),
		    'priority' => 3.4
		);
		$sections = array_merge($sections, $layout_sections);
		return  $sections ;
	}

	public function responsi_controls_settings( $controls_settings ){

		$_default = apply_filters( 'default_settings_options', false );
		
		if( $_default ){
			$responsi_options = array();
		}else{
			global $responsi_options;
		}
		
		$layout_controls_settings = array();
		$layout_controls_settings['lblayout1'] = array(
			'control' => array(
			    'label'      => __('Site Header', 'responsi'),
			    'section'    => 'site_structure',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);

		$layout_controls_settings['responsi_enable_header_widget'] = array(
			'control' => array(
			    'label'      => __('Header Widgets', 'responsi'),
			    'section'    => 'site_structure',
			    'settings'   => 'responsi_enable_header_widget',
			    'type'       => 'icheckbox',
			    'input_attrs' => array(
					'class' => 'collapsed'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_enable_header_widget']) ? $responsi_options['responsi_enable_header_widget'] : 'false',
			    'sanitize_callback' => 'responsi_sanitize_checkboxs',
			)
		);

		$layout_controls_settings['responsi_header_sidebars'] = array(
			'control' => array(
			    'section'    => 'site_structure',
			    'settings'   => 'responsi_header_sidebars',
			    'type'       => 'layout',
			    'input_attrs' => array(
					'class' => 'hide header_sidebars_logical'
		        ),
			    'choices' => array(
			    	//'0' => get_template_directory_uri() . '/functions/images/header-widgets-0.png',
					'1' => get_template_directory_uri() . '/functions/images/header-widgets-1.png',
					'2' => get_template_directory_uri() . '/functions/images/header-widgets-2.png',
					'3' => get_template_directory_uri() . '/functions/images/header-widgets-3.png',
					'4' => get_template_directory_uri() . '/functions/images/header-widgets-4.png',
					'5' => get_template_directory_uri() . '/functions/images/header-widgets-5.png',
					'6' => get_template_directory_uri() . '/functions/images/header-widgets-6.png'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_header_sidebars']) ? $responsi_options['responsi_header_sidebars'] : '1',
				'sanitize_callback' => 'responsi_sanitize_choices',
			)
		);

		$layout_controls_settings['responsi_on_header'] = array(
			'control' => array(
			    'label'      => __('Header Widget Display in Mobile Phones', 'responsi'),
			    'section'    => 'site_structure',
			    'settings'   => 'multicheckbox',
			    'type'       => 'imulticheckbox',
			    'input_attrs' => array(
					'class' => 'hide header-widgets-logic'
		        ),
			    'choices' => array( "1"=>"Header Widget #1","2"=>"Header Widget #2","3"=>"Header Widget #3","4"=>"Header Widget #4","5"=>"Header Widget #5","6"=>"Header Widget #6" )
			),
			'setting' => array(
			    'default'		=> array(
			    	isset($responsi_options['responsi_on_header_1']) ? $responsi_options['responsi_on_header_1'] : 'true',
			    	isset($responsi_options['responsi_on_header_2']) ? $responsi_options['responsi_on_header_2'] : 'true',
			    	isset($responsi_options['responsi_on_header_3']) ? $responsi_options['responsi_on_header_3'] : 'true',
			    	isset($responsi_options['responsi_on_header_4']) ? $responsi_options['responsi_on_header_4'] : 'true',
			    	isset($responsi_options['responsi_on_header_5']) ? $responsi_options['responsi_on_header_5'] : 'true',
			    	isset($responsi_options['responsi_on_header_6']) ? $responsi_options['responsi_on_header_6'] : 'true'
			    ), 
			    'sanitize_callback' => 'responsi_sanitize_multicheckboxs',
			    'transport'	=> 'postMessage'
			)
		);

		$layout_controls_settings['responsi_font_header_widget_text_alignment_mobile'] = array(
			'control' => array(
			    'label'      => __('Center Widget Content in Mobile', 'responsi'),
			    'section'    => 'site_structure',
			    'settings'   => 'responsi_font_header_widget_text_alignment_mobile',
			    'type'       => 'icheckbox',
			    'input_attrs' => array(
					'class' => 'hide last'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_font_header_widget_text_alignment_mobile']) ? $responsi_options['responsi_font_header_widget_text_alignment_mobile'] : 'false',
			    'sanitize_callback' => 'responsi_sanitize_checkboxs',
			    'transport'	=> 'postMessage'
			)
		);

		$layout_controls_settings['lblayout2'] = array(
			'control' => array(
			    'label'      => __('Post / Page Layout', 'responsi'),
			    'section'    => 'site_structure',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);

		$layout_controls_settings['responsi_layout'] = array(
			'control' => array(
			    'label'      => __('Content Sidebar Layout', 'responsi'),
			    'section'    => 'site_structure',
			    'settings'   => 'responsi_layout',
			    'type'       => 'layout',
			    'input_attrs' => array(
			    	'class' => 'sidebar_widget_logical layout-logic'
		        ),
			    'choices' => array(
			    	'one-col' => get_template_directory_uri() . '/functions/images/1c.png',
					'two-col-left' => get_template_directory_uri() . '/functions/images/2cl.png',
					'two-col-right' => get_template_directory_uri() . '/functions/images/2cr.png',
					'three-col-left' => get_template_directory_uri() . '/functions/images/3cl.png',
					'three-col-middle' => get_template_directory_uri() . '/functions/images/3cm.png',
					'three-col-right' => get_template_directory_uri() . '/functions/images/3cr.png'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_layout']) ? $responsi_options['responsi_layout'] : 'two-col-left',
			    'sanitize_callback' => 'responsi_sanitize_choices',
			)
		);

		$layout_controls_settings['responsi_font_sidebar_widget_text_alignment_mobile'] = array(
			'control' => array(
			    'label'      => __('Center Widget Content in Mobile', 'responsi'),
			    'section'    => 'site_structure',
			    'settings'   => 'responsi_font_sidebar_widget_text_alignment_mobile',
			    'type'       => 'icheckbox',
			    'input_attrs' => array(
					'class' => 'sidebar-widgets-logic'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_font_sidebar_widget_text_alignment_mobile']) ? $responsi_options['responsi_font_sidebar_widget_text_alignment_mobile'] : 'false',
			    'sanitize_callback' => 'responsi_sanitize_checkboxs',
			    'transport'	=> 'postMessage'
			)
		);

		$layout_controls_settings['lblayout3'] = array(
			'control' => array(
			    'label'      => __('Content Layout', 'responsi'),
			    'section'    => 'site_structure',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);

		$layout_controls_settings['responsi_content_layout'] = array(
			'control' => array(
			    'label'      => __('Content Section Width', 'responsi'),
			    'section'    => 'site_structure',
			    'settings'   => 'responsi_content_layout',
			    'type'       => 'layout',
			    'input_attrs' => array(
			    	'class' => 'layout-content-logic'
		        ),
			    'choices' => array(
			    	'1' => get_template_directory_uri() . '/functions/images/cw1.png',
					'2' => get_template_directory_uri() . '/functions/images/cw2.png',
					'3' => get_template_directory_uri() . '/functions/images/cw3.png',
					'4' => get_template_directory_uri() . '/functions/images/cw4.png',
					'5' => get_template_directory_uri() . '/functions/images/cw5.png',
					'6' => get_template_directory_uri() . '/functions/images/cw6.png'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_content_layout']) ? $responsi_options['responsi_content_layout'] : '3',
			    'sanitize_callback' => 'responsi_sanitize_choices',
			)
		);

		$layout_controls_settings['responsi_content_column_grid'] = array(
			'control' => array(
			    'label'      => __('Blog Cards Per Row', 'responsi'),
			    'section'    => 'site_structure',
			    'settings'   => 'responsi_content_column_grid',
			    'type'       => 'layout',
			    'choices' => array(
			    	'1' => get_template_directory_uri() . '/functions/images/bc1.png',
					'2' => get_template_directory_uri() . '/functions/images/bc2.png',
					'3' => get_template_directory_uri() . '/functions/images/bc3.png',
					'4' => get_template_directory_uri() . '/functions/images/bc4.png',
					'5' => get_template_directory_uri() . '/functions/images/bc5.png',
					'6' => get_template_directory_uri() . '/functions/images/bc6.png'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_content_column_grid']) ? $responsi_options['responsi_content_column_grid'] : '3',
			    'sanitize_callback' => 'responsi_sanitize_choices',
			)
		);

		$layout_controls_settings['responsi_layout_gutter_vertical'] = array(
			'control' => array(
			    'label'      => __('Card Rows Horizontal Margin', 'responsi'),
			    'section'    => 'site_structure',
			    'settings'   => 'responsi_layout_gutter_vertical',
			    'type'       => 'itext',
			    'input_attrs' => array(
					'class' => 'custom-itext',
					'after_input' => __('Pixels', 'responsi'),
		        ),
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_layout_gutter_vertical']) ? $responsi_options['responsi_layout_gutter_vertical'] : '11',
			    'sanitize_callback' => 'responsi_sanitize_numeric',
			)
		);

		$layout_controls_settings['lblayout4'] = array(
			'control' => array(
			    'label'      => __('Site Footer', 'responsi'),
			    'section'    => 'site_structure',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);

		$layout_controls_settings['responsi_enable_footer_widget'] = array(
			'control' => array(
			    'label'      => __('Footer Widgets', 'responsi'),
			    'section'    => 'site_structure',
			    'settings'   => 'responsi_enable_footer_widget',
			    'type'       => 'icheckbox',
			    'input_attrs' => array(
					'class' => 'collapsed'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_enable_footer_widget']) ? $responsi_options['responsi_enable_footer_widget'] : 'true',
			    'sanitize_callback' => 'responsi_sanitize_checkboxs',
			)
		);

		$layout_controls_settings['responsi_footer_sidebars'] = array(
			'control' => array(
			    'section'    => 'site_structure',
			    'settings'   => 'responsi_footer_sidebars',
			    'type'       => 'layout',
			    'choices' => array(
			    	//'0' => get_template_directory_uri() . '/functions/images/footer-widgets-0.png',
					'1' => get_template_directory_uri() . '/functions/images/footer-widgets-1.png',
					'2' => get_template_directory_uri() . '/functions/images/footer-widgets-2.png',
					'3' => get_template_directory_uri() . '/functions/images/footer-widgets-3.png',
					'4' => get_template_directory_uri() . '/functions/images/footer-widgets-4.png',
					'5' => get_template_directory_uri() . '/functions/images/footer-widgets-5.png',
					'6' => get_template_directory_uri() . '/functions/images/footer-widgets-6.png'
		        ),
		        'input_attrs' => array(
					'class' => 'hide footer_widget_logical'
		        ),
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_sidebars']) ? $responsi_options['responsi_footer_sidebars'] : '4',
			    'sanitize_callback' => 'responsi_sanitize_choices',
			)
		);

		$layout_controls_settings['responsi_font_footer_widget_text_alignment_mobile'] = array(
			'control' => array(
			    'label'      => __('Center Widget Content in Mobile', 'responsi'),
			    'section'    => 'site_structure',
			    'settings'   => 'responsi_font_footer_widget_text_alignment_mobile',
			    'type'       => 'icheckbox',
			    'input_attrs' => array(
					'class' => 'hide last footer-widgets-logic'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_font_footer_widget_text_alignment_mobile']) ? $responsi_options['responsi_font_footer_widget_text_alignment_mobile'] : 'false',
				'sanitize_callback' => 'responsi_sanitize_checkboxs',
				'transport'	=> 'postMessage'
			)
		);

		$layout_controls_settings['lblayout5'] = array(
			'control' => array(
			    'label'      => __('Site Vertical Gutter', 'responsi'),
			    'section'    => 'site_structure',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);

		$layout_controls_settings['responsi_layout_gutter'] = array(
			'control' => array(
			    'label'      => __('Gutter Width %', 'responsi'),
				'section'    => 'site_structure',
			    'settings'   => 'responsi_layout_gutter',
			    'type'       => 'iselect',
			    'choices' => array(
			    	'0' => __('0 Percent', 'responsi'),
			    	'0.5' => __('0.5 Percent', 'responsi'),
			    	'1' => __('1 Percent', 'responsi'),
			    	'1.5' => __('1.5 Percent', 'responsi'),
			    	'2' => __('2 Percent', 'responsi'),
			    	'2.5' => __('2.5 Percent', 'responsi'),
			    	'3' => __('3 Percent', 'responsi')
			    ),
			    'input_attrs'  => array(
					'min' => '0',
					'max' => '3',
					'step' => '0.5'
			    )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_layout_gutter']) ? $responsi_options['responsi_layout_gutter'] : '1',
			    'sanitize_callback' => 'responsi_sanitize_choices',
			)
		);

		$layout_controls_settings['lblayout6'] = array(
			'control' => array(
			    'label'      => __('Site Content Width', 'responsi'),
			    'section'    => 'layout_style',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);

		$layout_controls_settings['responsi_layout_width'] = array(
			'control' => array(
			    'label'      => __('Maximum Content Width', 'responsi'),
			    'description' => __( 'Maximum content width in pixels in large screens.', 'responsi' ),
			    'section'    => 'layout_style',
			    'settings'    => 'responsi_layout_width',
			    'type'       => 'slider',
			    'input_attrs'  => array(
					'min' => '600',
					'max' => '3000',
					'step' => '1'
			    )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_layout_width']) ? $responsi_options['responsi_layout_width'] : 1024,
			    'sanitize_callback' => 'responsi_sanitize_slider',
			    'transport'	=> 'postMessage'
			)
		);

		$layout_controls_settings['lblayout7'] = array(
			'control' => array(
			    'label'      => __('Stretched or Boxed Layout', 'responsi'),
			    'section'    => 'layout_style',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);

		$layout_controls_settings['responsi_layout_boxed'] = array(
			'control' => array(
			    'label'      => __('Site Layout', 'responsi'),
			    'section'    => 'layout_style',
			    'settings'   => 'responsi_layout_boxed',
			    'type'       => 'iswitcher',
			    'choices' => array(
			    	'checked_value' => 'true',
					'checked_label' => 'Boxed',
					'unchecked_value' => 'false',
					'unchecked_label' => 'Stretched',
					'container_width' => 140,
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_layout_boxed']) ? $responsi_options['responsi_layout_boxed'] : 'false',
			    'sanitize_callback' => 'responsi_sanitize_checkboxs',
			)
		);

		$layout_controls_settings['responsi_header_outside_boxed'] = array(
			'control' => array(
			    'label'      => __('Stretched Header with Boxed Content', 'responsi'),
			    'section'    => 'layout_style',
			    'settings'   => 'responsi_header_outside_boxed',
			    'type'       => 'icheckbox',
			    'input_attrs' => array(
			    	'class' => 'for-box-mode collapsed'
		        ),
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_header_outside_boxed']) ? $responsi_options['responsi_header_outside_boxed'] : 'false',
			    'sanitize_callback' => 'responsi_sanitize_checkboxs',
			)
		);

		$layout_controls_settings['responsi_fixed_header'] = array(
			'control' => array(
			    'label'      => __('Fix Header in Browser', 'responsi'),
			    'description' => __( 'Sites content will roll up under the nav bar / header which stays always visible (fixed) in the browser.', 'responsi' ),
			    'section'    => 'layout_style',
			    'settings'   => 'responsi_fixed_header',
			    'type'       => 'icheckbox',
			    'input_attrs' => array(
			    	'class' => 'hide last for-box-mode'
		        ),
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_fixed_header']) ? $responsi_options['responsi_fixed_header'] : 'false',
			    'sanitize_callback' => 'responsi_sanitize_checkboxs',
			)
		);

		$layout_controls_settings['responsi_footer_outside_boxed'] = array(
			'control' => array(
			    'label'      => __('Stretched Footer with Boxed Content', 'responsi'),
			    'section'    => 'layout_style',
			    'settings'   => 'responsi_footer_outside_boxed',
			    'type'       => 'icheckbox',
			    'input_attrs' => array(
			    	'class' => 'for-box-mode'
		        ),
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_footer_outside_boxed']) ? $responsi_options['responsi_footer_outside_boxed'] : 'false',
			    'sanitize_callback' => 'responsi_sanitize_checkboxs',
			)
		);

		$layout_controls_settings['responsi_fixed_header_stretched'] = array(
			'control' => array(
			    'label'      => __('Fix Header in Browser', 'responsi'),
			    'description' => __( 'Sites content will roll up under the nav bar / header which stays always visible (fixed) in the browser.', 'responsi' ),
			    'section'    => 'layout_style',
			    'settings'   => 'responsi_fixed_header_stretched',
			    'type'       => 'icheckbox',
			    'input_attrs' => array(
			    	'class' => 'for-wide-mode'
		        ),
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_fixed_header_stretched']) ? $responsi_options['responsi_fixed_header_stretched'] : 'false',
			    'sanitize_callback' => 'responsi_sanitize_checkboxs',
			)
		);

		$layout_controls_settings['lblayout8'] = array(
			'control' => array(
			    'label'      => __('Boxed Content Border', 'responsi'),
			    'section'    => 'layout_style',
			    'type'       => 'ilabel',
			    'input_attrs' => array(
			    	'class' => 'for-box-mode'
		        ),
			),
			'setting' => array()
		);

		$layout_controls_settings['responsi_enable_boxed_style'] = array(
			'control' => array(
			    'label'      => __('Border Settings', 'responsi'),
			    'section'    => 'layout_style',
			    'settings'   => 'responsi_enable_boxed_style',
			    'type'       => 'icheckbox',
			    'input_attrs' => array(
			    	'class' => 'for-box-mode collapsed'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_enable_boxed_style']) ? $responsi_options['responsi_enable_boxed_style'] : 'true',
			    'sanitize_callback' => 'responsi_sanitize_checkboxs',
			    'transport'	=> 'postMessage'
			)
		);

		$layout_controls_settings['responsi_box_border_lr'] = array(
			'control' => array(
			    'label'      => __('Border - Left / Right', 'responsi'),
			    'section'    => 'layout_style',
			    'settings'   => 'multiple',
			    'type'       => 'border',
			    'input_attrs' => array(
			    	'class' => 'for-box-mode hide'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_box_border_lr']) ? $responsi_options['responsi_box_border_lr'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);

		$layout_controls_settings['responsi_box_border_tb'] = array(
			'control' => array(
			    'label'      => __('Border - Top / Bottom', 'responsi'),
			    'section'    => 'layout_style',
			    'settings'   => 'multiple',
			    'type'       => 'border',
			    'input_attrs' => array(
			    	'class' => 'for-box-mode hide'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_box_border_tb']) ? $responsi_options['responsi_box_border_tb'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);

		$layout_controls_settings['responsi_box_border_radius'] = array(
			'control' => array(
			    'label'      => __('Border Corner', 'responsi'),
			    'section'    => 'layout_style',
			    'settings'   => 'multiple',
			    'type'       => 'border_radius',
			    'input_attrs' => array(
			    	'class' => 'for-box-mode hide'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_box_border_radius']) ? $responsi_options['responsi_box_border_radius'] : array('corner' => 'square','rounded_value' => '0'),
			    'sanitize_callback' => 'responsi_sanitize_border_radius',
			    'transport'	=> 'postMessage'
			)
		);

		$layout_controls_settings['responsi_box_shadow'] = array(
			'control' => array(
			    'label'      => __('Border Shadow', 'responsi'),
			    'section'    => 'layout_style',
			    'settings'   => 'multiple',
			    'type'       => 'box_shadow',
			    'input_attrs' => array(
			    	'class' => 'for-box-mode hide'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_box_shadow']) ? $responsi_options['responsi_box_shadow'] : array( 'onoff' => 'true' , 'h_shadow' => '0px' , 'v_shadow' => '0px', 'blur' => '5px' , 'spread' => '0px', 'color' => '#DBDBDB', 'inset' => '' ),
			    'sanitize_callback' => 'responsi_sanitize_box_shadow',
			    'transport'	=> 'postMessage'
			)
		);

		$layout_controls_settings['responsi_box_margin'] = array(
			'control' => array(
			    'label'      => __('Margin', 'responsi'),
			    'section'    => 'layout_style',
			    'settings'   => 'multitext',
			    'type'       => 'multitext',
			    'choices' => array(
			    	'top' => 'Top',
					'bottom' => 'Bottom',
					'left' => 'Left',
					'right' => 'Right'
		        ),
		        'input_attrs' => array(
			    	'class' => 'for-box-mode hide'
		        )
			),
			'setting' => array(
				'default'		=> array( 
					isset($responsi_options['responsi_box_margin_top']) ? $responsi_options['responsi_box_margin_top'] : '0' , 
					isset($responsi_options['responsi_box_margin_bottom']) ? $responsi_options['responsi_box_margin_bottom'] : '0',
					isset($responsi_options['responsi_box_margin_left']) ? $responsi_options['responsi_box_margin_left'] : '0' , 
					isset($responsi_options['responsi_box_margin_right']) ? $responsi_options['responsi_box_margin_right'] : '0'  
				),
				'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage',
			)
		);

		$layout_controls_settings['responsi_box_padding'] = array(
			'control' => array(
			    'label'      => __('Padding', 'responsi'),
			    'section'    => 'layout_style',
			    'settings'   => 'multitext',
			    'type'       => 'multitext',
			    'choices' => array(
			    	'top' => 'Top',
					'bottom' => 'Bottom',
					'left' => 'Left',
					'right' => 'Right',
		        ),
		        'input_attrs' => array(
			    	'class' => 'for-box-mode hide'
		        )
			),
			'setting' => array(
				'default'		=> array( 
					isset($responsi_options['responsi_box_padding_top']) ? $responsi_options['responsi_box_padding_top'] : '0' , 
					isset($responsi_options['responsi_box_padding_bottom']) ? $responsi_options['responsi_box_padding_bottom'] : '0', 
					isset($responsi_options['responsi_box_padding_left']) ? $responsi_options['responsi_box_padding_left'] : '0', 
					isset($responsi_options['responsi_box_padding_right']) ? $responsi_options['responsi_box_padding_right'] : '0' 
				),
				'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage',
			)
		);

		$layout_controls_settings['lblayout9'] = array(
			'control' => array(
			    'label'      => __('Boxed Content Inner Border', 'responsi'),
			    'section'    => 'layout_style',
			    'type'       => 'ilabel',
			    'input_attrs' => array(
			    	'class' => 'for-box-mode'
		        ),
			),
			'setting' => array()
		);

		$layout_controls_settings['responsi_box_inner_bg'] = array(
			'control' => array(
			    'label'      => __('Background Colour', 'responsi'),
			    'section'    => 'layout_style',
			    'settings'   => 'multiple',
			    'type'       => 'ibackground',
			    'input_attrs' => array(
			    	'class' => 'for-box-mode hide'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_box_inner_bg']) ? $responsi_options['responsi_box_inner_bg'] : array( 'onoff' => 'false', 'color' => '#ffffff' ),
			    'sanitize_callback' => 'responsi_sanitize_background_color',
			    'transport'	=> 'postMessage'
			)
		);

		$layout_controls_settings['responsi_box_inner_border_left'] = array(
			'control' => array(
			    'label'      => __('Border - Left', 'responsi'),
			    'section'    => 'layout_style',
			    'settings'   => 'multiple',
			    'type'       => 'border',
			    'input_attrs' => array(
			    	'class' => 'for-box-mode hide'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_box_inner_border_left']) ? $responsi_options['responsi_box_inner_border_left'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);

		$layout_controls_settings['responsi_box_inner_border_right'] = array(
			'control' => array(
			    'label'      => __('Border - Right', 'responsi'),
			    'section'    => 'layout_style',
			    'settings'   => 'multiple',
			    'type'       => 'border',
			    'input_attrs' => array(
			    	'class' => 'for-box-mode hide'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_box_inner_border_right']) ? $responsi_options['responsi_box_inner_border_right'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);


		$layout_controls_settings['responsi_box_inner_border_top'] = array(
			'control' => array(
			    'label'      => __('Border - Top', 'responsi'),
			    'section'    => 'layout_style',
			    'settings'   => 'multiple',
			    'type'       => 'border',
			    'input_attrs' => array(
			    	'class' => 'for-box-mode hide'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_box_inner_border_top']) ? $responsi_options['responsi_box_inner_border_top'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);

		$layout_controls_settings['responsi_box_inner_border_bottom'] = array(
			'control' => array(
			    'label'      => __('Border - Bottom', 'responsi'),
			    'section'    => 'layout_style',
			    'settings'   => 'multiple',
			    'type'       => 'border',
			    'input_attrs' => array(
			    	'class' => 'for-box-mode hide'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_box_inner_border_bottom']) ? $responsi_options['responsi_box_inner_border_bottom'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);

		$layout_controls_settings['responsi_box_inner_border_radius'] = array(
			'control' => array(
			    'label'      => __('Border Corner', 'responsi'),
			    'section'    => 'layout_style',
			    'settings'   => 'multiple',
			    'type'       => 'border_radius',
			    'input_attrs' => array(
			    	'class' => 'for-box-mode hide'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_box_inner_border_radius']) ? $responsi_options['responsi_box_inner_border_radius'] : array('corner' => 'square','rounded_value' => '0'),
			    'sanitize_callback' => 'responsi_sanitize_border_radius',
			    'transport'	=> 'postMessage'
			)
		);

		$layout_controls_settings['responsi_box_inner_shadow'] = array(
			'control' => array(
			    'label'      => __('Border Shadow', 'responsi'),
			    'section'    => 'layout_style',
			    'settings'   => 'multiple',
			    'type'       => 'box_shadow',
			    'input_attrs' => array(
			    	'class' => 'for-box-mode hide'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_box_inner_shadow']) ? $responsi_options['responsi_box_inner_shadow'] : array( 'onoff' => 'false' , 'h_shadow' => '0px' , 'v_shadow' => '0px', 'blur' => '5px' , 'spread' => '0px', 'color' => '#DBDBDB', 'inset' => '' ),
			    'sanitize_callback' => 'responsi_sanitize_box_shadow',
			    'transport'	=> 'postMessage'
			)
		);

		$layout_controls_settings['responsi_box_inner_margin'] = array(
			'control' => array(
			    'label'      => __('Margin', 'responsi'),
			    'section'    => 'layout_style',
			    'settings'   => 'multitext',
			    'type'       => 'multitext',
			    'choices' => array(
			    	'top' => 'Top',
					'bottom' => 'Bottom',
					'left' => 'Left',
					'right' => 'Right'
		        ),
		        'input_attrs' => array(
			    	'class' => 'for-box-mode hide'
		        )
			),
			'setting' => array(
				'default'		=> array( 
					isset($responsi_options['responsi_box_inner_margin_top']) ? $responsi_options['responsi_box_inner_margin_top'] : '0' , 
					isset($responsi_options['responsi_box_inner_margin_bottom']) ? $responsi_options['responsi_box_inner_margin_bottom'] : '0',
					isset($responsi_options['responsi_box_inner_margin_left']) ? $responsi_options['responsi_box_inner_margin_left'] : '0' , 
					isset($responsi_options['responsi_box_inner_margin_right']) ? $responsi_options['responsi_box_inner_margin_right'] : '0'  
				),
				'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage',
			)
		);

		$layout_controls_settings['responsi_box_inner_padding'] = array(
			'control' => array(
			    'label'      => __('Padding', 'responsi'),
			    'section'    => 'layout_style',
			    'settings'   => 'multitext',
			    'type'       => 'multitext',
			    'choices' => array(
			    	'top' => 'Top',
					'bottom' => 'Bottom',
					'left' => 'Left',
					'right' => 'Right',
		        ),
		        'input_attrs' => array(
			    	'class' => 'for-box-mode hide last'
		        )
			),
			'setting' => array(
				'default'		=> array( 
					isset($responsi_options['responsi_box_inner_padding_top']) ? $responsi_options['responsi_box_inner_padding_top'] : '0' , 
					isset($responsi_options['responsi_box_inner_padding_bottom']) ? $responsi_options['responsi_box_inner_padding_bottom'] : '0', 
					isset($responsi_options['responsi_box_inner_padding_left']) ? $responsi_options['responsi_box_inner_padding_left'] : '0', 
					isset($responsi_options['responsi_box_inner_padding_right']) ? $responsi_options['responsi_box_inner_padding_right'] : '0' 
				),
				'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage',
			)
		);

		$layout_controls_settings['lblayout10'] = array(
			'control' => array(
			    'label'      => __('Theme Background', 'responsi'),
			    'section'    => 'background_theme',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);

		$layout_controls_settings['responsi_style_bg'] = array(
			'control' => array(
			    'label'      => __('Background Colour', 'responsi'),
			    'section'    => 'background_theme',
			    'settings'   => 'multiple',
			    'type'       => 'ibackground'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_style_bg']) ? $responsi_options['responsi_style_bg'] : array( 'onoff' => 'true', 'color' => '#ffffff' ),
			    'sanitize_callback' => 'responsi_sanitize_background_color',
			    'transport'	=> 'postMessage'
			)
		);

		if( class_exists('Responsi_Backgrounds_Addon')){

			$layout_controls_settings['lblayout11'] = array(
				'control' => array(
				    'label'      => __('Tile or Pattern Background ', 'responsi'),

				    'section'    => 'background_theme',
				    'type'       => 'ilabel'
				),
				'setting' => array(
				    'default'		=> null
				)
			);
			$layout_controls_settings['responsi_disable_background_style_img'] = array(
				'control' => array(
				    'label'      => __('Background Tiles and Patterns', 'responsi'),

				    'section'    => 'background_theme',
				    'settings'   => 'responsi_disable_background_style_img',
				    'type'       => 'icheckbox',
				    'input_attrs' => array(
				    	'class' => 'collapsed'
			        )
				),
				'setting' => array(
				    'default'		=> isset($responsi_options['responsi_disable_background_style_img']) ? $responsi_options['responsi_disable_background_style_img'] : 'false',
				    'sanitize_callback' => 'responsi_sanitize_checkboxs',
				    'transport'	=> 'postMessage'
				)
			);
			$layout_controls_settings['responsi_background_style_img'] = array(
				'control' => array(
				    'label'      => __('Tiles and Patterns', 'responsi'),

				    'section'    => 'background_theme',
				    'settings'   => 'responsi_background_style_img',
				    'type'       => 'background_patterns',
				    'input_attrs' => array(
				    	'class' => 'hide last'
			        )
				),
				'setting' => array(
				    'default'		=> isset($responsi_options['responsi_background_style_img']) ? $responsi_options['responsi_background_style_img'] : '',
				    'sanitize_callback' => 'responsi_sanitize_background_patterns',
				    'transport'	=> 'postMessage',
				)
			);
		}

		$layout_controls_settings['lblayout12'] = array(
			'control' => array(
			    'label'      => __('Background Image', 'responsi'),
			    'section'    => 'background_theme',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);

		$layout_controls_settings['responsi_use_style_bg_image'] = array(
			'control' => array(
			    'label'      => __('Background Image', 'responsi'),
			    'section'    => 'background_theme',
			    'settings'   => 'responsi_use_style_bg_image',
			    'type'       => 'icheckbox',
			    'input_attrs' => array(
			    	'class' => 'collapsed-custom'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_use_style_bg_image']) ? $responsi_options['responsi_use_style_bg_image'] : 'false',
			    'sanitize_callback' => 'responsi_sanitize_checkboxs',
			    'transport'	=> 'postMessage'
			)
		);

		$layout_controls_settings['responsi_style_bg_image'] = array(
			'control' => array(
			    'label'      => __('Image', 'responsi'),
			    'section'    => 'background_theme',
			    'settings'   => 'responsi_style_bg_image',
			    'type'       => 'iupload',
			    'input_attrs' => array(
			    	'class' => 'hide-custom'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_style_bg_image']) ? $responsi_options['responsi_style_bg_image'] : '',
			    'sanitize_callback' => 'esc_url',
			    'transport'	=> 'postMessage'
			)
		);

		$layout_controls_settings['responsi_use_bg_size'] = array(
			'control' => array(
			    'label'      => __('Image Resizer', 'responsi'),
			    'section'    => 'background_theme',
			    'settings'   => 'responsi_use_bg_size',
			    'type'       => 'icheckbox',
			    'input_attrs' => array(
			    	'class' => 'collapsed hide-custom'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_use_bg_size']) ? $responsi_options['responsi_use_bg_size'] : 'false',
			    'sanitize_callback' => 'responsi_sanitize_checkboxs',
			    'transport'	=> 'postMessage'
			)
		);

		$layout_controls_settings['responsi_bg_size'] = array(
			'control' => array(
			    'label'      => __('Image Size', 'responsi'),
			    'description'      => __('Supported values are auto, percentage e.g 50% and pixels e.g. 20px', 'responsi'),
			    'section'    => 'background_theme',
			    'settings'   => 'multitext',
			    'type'       => 'multitext',
			    'choices' => array(
			    	'width' => 'Width',
					'height' => 'Height'
		        ),
		        'input_attrs' => array(
			    	'class' => 'hide-custom hide last'
		        )
			),
			'setting' => array(
				'default'		=> array( 
					isset($responsi_options['responsi_bg_size_width']) ? $responsi_options['responsi_bg_size_width'] : '100%' , 
					isset($responsi_options['responsi_bg_size_height']) ? $responsi_options['responsi_bg_size_height'] : 'auto'
				),
				'sanitize_callback' => 'responsi_sanitize_background_size',
			    'transport'	=> 'postMessage'
			)
		);

		$layout_controls_settings['responsi_style_bg_image_attachment'] = array(
			'control' => array(
			    'label'      => __('Image Attachment', 'responsi'),
			    'section'    => 'background_theme',
			    'settings'   => 'responsi_style_bg_image_attachment',
			    'type'       => 'iswitcher',
			    'choices' => array(
			    	'checked_value' => 'inherit',
					'checked_label' => 'SCROLL',
					'unchecked_value' => 'fixed',
					'unchecked_label' => 'FIXED',
					'container_width' => 104,
		        ),
			    'input_attrs' => array(
			    	'class' => 'hide-custom'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_style_bg_image_attachment']) ? $responsi_options['responsi_style_bg_image_attachment'] : 'inherit',
			    'sanitize_callback' => 'responsi_sanitize_checkboxs',
			    'transport'	=> 'postMessage'
			)
		);

		$layout_controls_settings['responsi_bg_position'] = array(
			'control' => array(
			    'label'      => __('Image Alignment', 'responsi'),
			    'description'      => __('Supported values are top, bottom, left, right, center, percentage e.g. 50% and pixels e.g. 20px', 'responsi'),
			    'section'    => 'background_theme',
			    'settings'   => 'multitext',
			    'type'       => 'multitext',
			    'choices' => array(
			    	'vertical' => 'Vertical',
					'horizontal' => 'Horizontal'
		        ),
		        'input_attrs' => array(
			    	'class' => 'hide-custom'
		        )
			),
			'setting' => array(
				'default'		=> array( 
					isset($responsi_options['responsi_bg_position_vertical']) ? $responsi_options['responsi_bg_position_vertical'] : 'center' , 
					isset($responsi_options['responsi_bg_position_horizontal']) ? $responsi_options['responsi_bg_position_horizontal'] : 'center'
				),
				'sanitize_callback' => 'responsi_sanitize_background_position',
			    'transport'	=> 'postMessage'
			)
		);

		$layout_controls_settings['responsi_style_bg_image_repeat'] = array(
			'control' => array(
			    'label'      => __('Image Repeat', 'responsi'),
			    'section'    => 'background_theme',
			    'settings'   => 'responsi_style_bg_image_repeat',
			    'type'       => 'iradio',
			    'input_attrs' => array(
					'checked_label' => 'ON',
					'unchecked_label' => 'OFF',
					'container_width' => 80,
					'class' => 'hide-custom hide-custom-last'
		        ),
			    'choices' => array(
			    	'no-repeat' => 'No repeat',
			    	'repeat' => 'Repeat',
			    	'repeat-x' => 'Repeat Horizontally',
			    	'repeat-y' => 'Repeat Vertically'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_style_bg_image_repeat']) ? $responsi_options['responsi_style_bg_image_repeat'] : 'repeat',
			    'sanitize_callback' => 'responsi_sanitize_choices',
			    'transport'	=> 'postMessage'
			)
		);

		$layout_controls_settings['lblayout13'] = array(
			'control' => array(
			    'label'      => __('Body Container', 'responsi'),
			    'section'    => 'content_body_style',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);

		$layout_controls_settings['responsi_wrap_container_background'] = array(
			'control' => array(
			    'label'      => __('Background Colour', 'responsi'),
			    'description' => __('Container between Header / Primary Nav bar and the Footer. All pages, posts and sidebars sit inside this container', 'responsi'),
			    'section'    => 'content_body_style',
			    'settings'   => 'multiple',
			    'type'       => 'ibackground'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_wrap_container_background']) ? $responsi_options['responsi_wrap_container_background'] : array( 'onoff' => 'false', 'color' => '#ffffff' ),
			    'sanitize_callback' => 'responsi_sanitize_background_color',
			    'transport'	=> 'postMessage'
			)
		);

		$layout_controls_settings['lblayout14'] = array(
			'control' => array(
			    'label'      => __('Body Content', 'responsi'),
			    'section'    => 'content_body_style',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);

		$layout_controls_settings['responsi_wrap_content_background'] = array(
			'control' => array(
			    'label'      => __('Background Colour', 'responsi'),
			    'description' => __('Content between Header / Primary Nav bar and the Footer. All pages, posts and sidebars sit inside this container', 'responsi'),
			    'section'    => 'content_body_style',
			    'settings'   => 'multiple',
			    'type'       => 'ibackground'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_wrap_content_background']) ? $responsi_options['responsi_wrap_content_background'] : array( 'onoff' => 'false', 'color' => '#ffffff' ),
			    'sanitize_callback' => 'responsi_sanitize_background_color',
			    'transport'	=> 'postMessage'
			)
		);

		$layout_controls_settings['responsi_wrapper_border_top'] = array(
			'control' => array(
			    'label'      => __('Container Border - Top', 'responsi'),
			    'section'    => 'content_body_style',
			    'settings'   => 'multiple',
			    'type'       => 'border'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_wrapper_border_top']) ? $responsi_options['responsi_wrapper_border_top'] : array('width' => '0','style' => 'inset','color' => '#DBDBDB'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);

		$layout_controls_settings['responsi_wrapper_border_bottom'] = array(
			'control' => array(
			    'label'      => __('Container Border - Bottom', 'responsi'),
			    'section'    => 'content_body_style',
			    'settings'   => 'multiple',
			    'type'       => 'border'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_wrapper_border_bottom']) ? $responsi_options['responsi_wrapper_border_bottom'] : array('width' => '0','style' => 'inset','color' => '#DBDBDB'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);

		$layout_controls_settings['responsi_wrapper_border_left_right'] = array(
			'control' => array(
			    'label'      => __('Container Border - Left / Right', 'responsi'),
			    'section'    => 'content_body_style',
			    'settings'   => 'multiple',
			    'type'       => 'border'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_wrapper_border_left_right']) ? $responsi_options['responsi_wrapper_border_left_right'] : array('width' => '0','style' => 'inset','color' => '#DBDBDB'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);

		$layout_controls_settings['responsi_wrapper_border_radius'] = array(
			'control' => array(
			    'label'      => __('Border Corner', 'responsi'),
			    'section'    => 'content_body_style',
			    'settings'   => 'multiple',
			    'type'       => 'border_radius'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_wrapper_border_radius']) ? $responsi_options['responsi_wrapper_border_radius'] : array('corner' => 'square','rounded_value' => '0'),
			    'sanitize_callback' => 'responsi_sanitize_border_radius',
			    'transport'	=> 'postMessage'
			)
		);

		$layout_controls_settings['responsi_wrapper_border_box_shadow'] = array(
			'control' => array(
			    'label'      => __('Border Shadow', 'responsi'),
			    'section'    => 'content_body_style',
			    'settings'   => 'multiple',
			    'type'       => 'box_shadow'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_wrapper_border_box_shadow']) ? $responsi_options['responsi_wrapper_border_box_shadow'] : array( 'onoff' => 'false' , 'h_shadow' => '0px' , 'v_shadow' => '0px', 'blur' => '5px' , 'spread' => '0px', 'color' => '#DBDBDB', 'inset' => '' ),
			    'sanitize_callback' => 'responsi_sanitize_box_shadow',
			    'transport'	=> 'postMessage'
			)
		);

		$layout_controls_settings['responsi_wrapper_margin'] = array(
			'control' => array(
			    'label'      => __('Border Margin', 'responsi'),
			    'section'    => 'content_body_style',
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
					isset($responsi_options['responsi_wrapper_margin_top']) ? $responsi_options['responsi_wrapper_margin_top'] : '0' , 
					isset($responsi_options['responsi_wrapper_margin_bottom']) ? $responsi_options['responsi_wrapper_margin_bottom'] : '0',
					isset($responsi_options['responsi_wrapper_margin_left']) ? $responsi_options['responsi_wrapper_margin_left'] : '0',
					isset($responsi_options['responsi_wrapper_margin_right']) ? $responsi_options['responsi_wrapper_margin_right'] : '0'
				),
				'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage',
			)
		);

		$layout_controls_settings['responsi_wrapper_padding'] = array(
			'control' => array(
			    'label'      => __('Border Padding', 'responsi'),
			    'section'    => 'content_body_style',
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
					isset($responsi_options['responsi_wrapper_padding_top']) ? $responsi_options['responsi_wrapper_padding_top'] : '20' , 
					isset($responsi_options['responsi_wrapper_padding_bottom']) ? $responsi_options['responsi_wrapper_padding_bottom'] : '0',
					isset($responsi_options['responsi_wrapper_padding_left']) ? $responsi_options['responsi_wrapper_padding_left'] : '10',
					isset($responsi_options['responsi_wrapper_padding_right']) ? $responsi_options['responsi_wrapper_padding_right'] : '10'
				),
				'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage',
			)
		);

		$layout_controls_settings = apply_filters( 'responsi_layout_controls_settings', $layout_controls_settings );
		$controls_settings = array_merge($controls_settings, $layout_controls_settings);
		return  $controls_settings ;
	}
}

new Responsi_Customize_Layout();
?>
