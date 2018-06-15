<?php
class Responsi_Customize_Blogs
{

	public function __construct() {
		add_action( 'customize_preview_init', array( $this, 'responsi_customize_preview_init' ), 11 );
		add_filter( 'responsi_default_options', array( $this, 'responsi_controls_settings' ) );
		add_filter( 'responsi_customize_register_panels',  array( $this, 'responsi_panels' ) );
		add_filter( 'responsi_customize_register_sections',  array( $this, 'responsi_sections' ) );
		add_filter( 'responsi_customize_register_settings',  array( $this, 'responsi_controls_settings' ) );
	}

	public function responsi_customize_preview_init() {
		wp_enqueue_script( 'responsi-customize-blog' );
	}

	public function responsi_panels( $panels ){
		$blogs_panels = array();
		$blogs_panels['blogs_settings_panel'] = array(
		    'title' => __('Blog Cards', 'responsi'),
		    'priority' => 5,
		);
		$panels = array_merge($panels, $blogs_panels);
		return  $panels ;
	}

	public function responsi_sections( $sections ){
		$blogs_sections = array();
		$blogs_sections['blogs_layout'] = array(
		    'title' => __('Blog Card Style', 'responsi'),
		    'priority' => 10,
		    'panel' => 'blogs_settings_panel',
		);
		$blogs_sections['blogs_style'] = array(
		    'title' => __('Blog Card Features', 'responsi'),
		    'priority' => 10,
		    'panel' => 'blogs_settings_panel',
		);
		$sections = array_merge($sections, $blogs_sections);
		return  $sections ;
	}

	public function responsi_controls_settings( $controls_settings ){

		global $responsi_options;

		$blogs_controls_settings = array();

		$blogs_controls_settings['lbblog1'] = array(
			'control' => array(
			    'label'      => __('Blog Card Container', 'responsi'),
			    'section'    => 'blogs_layout',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);

		$blogs_controls_settings['responsi_blog_box_bg'] = array(
			'control' => array(
			    'label'      => __('Card Background Color', 'responsi'),
			    'section'    => 'blogs_layout',
			    'settings'   => 'multiple',
			    'type'       => 'ibackground'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_blog_box_bg']) ? $responsi_options['responsi_blog_box_bg'] : array('onoff' => 'true', 'color' => '#ffffff'),
			    'sanitize_callback' => 'responsi_sanitize_background_color',
			    'transport'	=> 'postMessage'
			)
		);

		$blogs_controls_settings['responsi_blog_box_border'] = array(
			'control' => array(
			    'label'      => __('Card Borders', 'responsi'),
			    'section'    => 'blogs_layout',
			    'settings'   => 'multiple',
			    'type'       => 'border_boxes'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_blog_box_border']) ? $responsi_options['responsi_blog_box_border'] : array('width' => '1','style' => 'solid','color' => '#DBDBDB','corner' => 'square', 'topleft' => '0', 'topright' => '0', 'bottomright' => '0', 'bottomleft' => '0'),
			    'sanitize_callback' => 'responsi_sanitize_border_boxes',
			    'transport'	=> 'postMessage'
			)
		);
		$blogs_controls_settings['responsi_blog_box_shadow'] = array(
			'control' => array(
			    'label'      => __('Border Shadow', 'responsi'),
			    'section'    => 'blogs_layout',
			    'settings'   => 'multiple',
			    'type'       => 'box_shadow'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_blog_box_shadow']) ? $responsi_options['responsi_blog_box_shadow'] : array( 'onoff' => 'true' , 'h_shadow' => '0px' , 'v_shadow' => '0px', 'blur' => '8px' , 'spread' => '0px', 'color' => '#DBDBDB', 'inset' => '' ),
			    'sanitize_callback' => 'responsi_sanitize_box_shadow',
			    'transport'	=> 'postMessage'
			)
		);
		
		$blogs_controls_settings['lbblog2'] = array(
			'control' => array(
			    'label'      => __('Card Layout', 'responsi'),
			    'section'    => 'blogs_layout',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);
		$blogs_controls_settings['responsi_post_thumbnail_type'] = array(
			'control' => array(
			    'label'      => __('Image | Content Layout', 'responsi'),
			    'section'    => 'blogs_layout',
			    'settings'   => 'responsi_post_thumbnail_type',
			    'type'       => 'layout',
			    'choices' => array(
			    	'top' => get_template_directory_uri() . '/functions/images/it.png',
					'left' => get_template_directory_uri() . '/functions/images/il.png',
					'right' => get_template_directory_uri() . '/functions/images/ir.png'
		        ),
		        'input_attrs'  => array(
					'class' => 'post-thumb-type'
			    )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_post_thumbnail_type']) ? $responsi_options['responsi_post_thumbnail_type'] : 'top',
			    'sanitize_callback' => 'responsi_sanitize_choices',
			    'transport'	=> 'postMessage'
			)
		);
		$blogs_controls_settings['responsi_post_thumbnail_type_wide'] = array(
			'control' => array(
			    'label'      => __('Image Wide set as a % of Card Wide', 'responsi'),
			    'section'    => 'blogs_layout',
			    'settings'    => 'responsi_post_thumbnail_type_wide',
			    'type'       => 'slider',
			    'input_attrs'  => array(
					'min' => '1',
					'max' => '50',
					'step' => '1',
					'class' => 'for-post-thumb-type'
			    )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_post_thumbnail_type_wide']) ? $responsi_options['responsi_post_thumbnail_type_wide'] : 50,
			    'sanitize_callback' => 'responsi_sanitize_slider',
			    'transport'	=> 'postMessage'
			)
		);


		$blogs_controls_settings['responsi_fixed_thumbnail'] = array(
			'control' => array(
			    'label'      => __('Image Display Height', 'responsi'),
			    'section'    => 'blogs_layout',
			    'settings'   => 'responsi_fixed_thumbnail',
			    'type'       => 'iswitcher',
			    'choices' => array(
			    	'checked_label' => 'FIXED',
					'unchecked_label' => 'DYNAMIC',
					'unchecked_value' => 'false',
					'checked_value' => 'true',
					'container_width' => 120
		        ),
			    'input_attrs' => array(
			    	'class' => 'collapsed'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_fixed_thumbnail']) ? $responsi_options['responsi_fixed_thumbnail'] : 'true',
			    'sanitize_callback' => 'responsi_sanitize_checkboxs',
			    //'transport'	=> 'postMessage'
			)
		);


		$blogs_controls_settings['responsi_fixed_thumbnail_tall'] = array(
			'control' => array(
			    'label'      => __('Image Height as a % of Width', 'responsi'),
			    'section'    => 'blogs_layout',
			    'settings'    => 'responsi_fixed_thumbnail_tall',
			    'type'       => 'slider',
			    'input_attrs'  => array(
					'min' => '50',
					'max' => '100',
					'step' => '1',
					'class' => 'hide last'
			    )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_fixed_thumbnail_tall']) ? $responsi_options['responsi_fixed_thumbnail_tall'] : 63,
			    'sanitize_callback' => 'responsi_sanitize_slider',
			    //'transport'	=> 'postMessage'
			)
		);
		$blogs_controls_settings['lbblog3'] = array(
			'control' => array(
			    'label'      => __('Blog Card Image Container', 'responsi'),
			    'section'    => 'blogs_layout',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);
		$blogs_controls_settings['responsi_blog_post_thumbnail_bg'] = array(
			'control' => array(
			    'label'      => __('Background Colour', 'responsi'),
			    'section'    => 'blogs_layout',
			    'settings'   => 'multiple',
			    'type'       => 'ibackground'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_blog_post_thumbnail_bg']) ? $responsi_options['responsi_blog_post_thumbnail_bg'] : array('onoff' => 'true', 'color' => '#ffffff'),
			    'sanitize_callback' => 'responsi_sanitize_background_color',
			    'transport'	=> 'postMessage'
			)
		);
		$blogs_controls_settings['responsi_blog_post_thumbnail_border'] = array(
			'control' => array(
			    'label'      => __('Border', 'responsi'),
			    'section'    => 'blogs_layout',
			    'settings'   => 'multiple',
			    'type'       => 'border_boxes'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_blog_post_thumbnail_border']) ? $responsi_options['responsi_blog_post_thumbnail_border'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB','corner' => 'square', 'topleft' => '0', 'topright' => '0', 'bottomright' => '0', 'bottomleft' => '0'),
			    'sanitize_callback' => 'responsi_sanitize_border_boxes',
			    'transport'	=> 'postMessage'
			)
		);
		$blogs_controls_settings['responsi_blog_post_thumbnail_shadow'] = array(
			'control' => array(
			    'label'      => __('Border Shadow', 'responsi'),
			    'section'    => 'blogs_layout',
			    'settings'   => 'multiple',
			    'type'       => 'box_shadow'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_blog_post_thumbnail_shadow']) ? $responsi_options['responsi_blog_post_thumbnail_shadow'] : array( 'onoff' => 'false' , 'h_shadow' => '0px' , 'v_shadow' => '0px', 'blur' => '8px' , 'spread' => '0px', 'color' => '#DBDBDB', 'inset' => 'inset' ),
			    'sanitize_callback' => 'responsi_sanitize_box_shadow',
			    'transport'	=> 'postMessage'
			)
		);
		$blogs_controls_settings['responsi_blog_post_thumbnail_margin'] = array(
			'control' => array(
			    'label'      => __('Margin', 'responsi'),
			    'section'    => 'blogs_layout',
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
					isset($responsi_options['responsi_blog_post_thumbnail_margin_top']) ? $responsi_options['responsi_blog_post_thumbnail_margin_top'] : '0' , 
					isset($responsi_options['responsi_blog_post_thumbnail_margin_bottom']) ? $responsi_options['responsi_blog_post_thumbnail_margin_bottom'] : '5',
					isset($responsi_options['responsi_blog_post_thumbnail_margin_left']) ? $responsi_options['responsi_blog_post_thumbnail_margin_left'] : '0',
					isset($responsi_options['responsi_blog_post_thumbnail_margin_right']) ? $responsi_options['responsi_blog_post_thumbnail_margin_right'] : '0'
				),
				'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage',
			)
		);
		$blogs_controls_settings['responsi_blog_post_thumbnail_padding'] = array(
			'control' => array(
			    'label'      => __('Padding', 'responsi'),
			    'section'    => 'blogs_layout',
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
					isset($responsi_options['responsi_blog_post_thumbnail_padding_top']) ? $responsi_options['responsi_blog_post_thumbnail_padding_top'] : '0' , 
					isset($responsi_options['responsi_blog_post_thumbnail_padding_bottom']) ? $responsi_options['responsi_blog_post_thumbnail_padding_bottom'] : '0',
					isset($responsi_options['responsi_blog_post_thumbnail_padding_left']) ? $responsi_options['responsi_blog_post_thumbnail_padding_left'] : '0',
					isset($responsi_options['responsi_blog_post_thumbnail_padding_right']) ? $responsi_options['responsi_blog_post_thumbnail_padding_right'] : '0'
				),
				'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage',
			)
		);
		$blogs_controls_settings['lbblog4'] = array(
			'control' => array(
			    'label'      => __('Footer Cell #1 Features', 'responsi'),
			    'section'    => 'blogs_layout',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);
		$blogs_controls_settings['responsi_disable_ext_cat_author'] = array(
			'control' => array(
			    'label'      => __('Footer Cell #1', 'responsi'),
			    'section'    => 'blogs_layout',
			    'settings'   => 'responsi_disable_ext_cat_author',
			    'type'       => 'icheckbox',
			    'input_attrs' => array(
			    	'class' => 'collapsed'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_disable_ext_cat_author']) ? $responsi_options['responsi_disable_ext_cat_author'] : 'true',
			    'sanitize_callback' => 'responsi_sanitize_checkboxs',
			)
		);
		
		$blogs_controls_settings['responsi_disable_ext_author_cell'] = array(
            'control' => array(
                'label'      => __('Show Post Author Name', 'responsi'),
                'section'    => 'blogs_layout',
                'settings'   => 'responsi_disable_ext_author_cell',
                'type'       => 'icheckbox',
                'input_attrs' => array(
                    'class' => 'hide'
                ),
            ),
            'setting' => array(
                'default'       => isset($blogs_controls_settings['responsi_disable_ext_author_cell']) ? $blogs_controls_settings['responsi_disable_ext_author_cell'] : 'true',
                'sanitize_callback' => 'responsi_sanitize_checkboxs',
            )
        );
		
		$blogs_controls_settings['responsi_disable_ext_categories_cell'] = array(
			'control' => array(
			    'label'      => __('Post Categories', 'responsi'),
			    'section'    => 'blogs_layout',
			    'settings'   => 'responsi_disable_ext_categories_cell',
			    'type'       => 'icheckbox',
			    'choices' => array(
			    	'checked_label' => 'YES',
					'unchecked_label' => 'NO'
		        ),
			    'input_attrs' => array(
			    	'class' => 'hide'
		        ),
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_disable_ext_categories_cell']) ? $responsi_options['responsi_disable_ext_categories_cell'] : 'true',
			    'sanitize_callback' => 'responsi_sanitize_checkboxs',
			)
		);
		$blogs_controls_settings['responsi_enable_fix_ext_cat_author'] = array(
			'control' => array(
			    'label'      => __('Cell #1 Line Wrap', 'responsi'),
			    'section'    => 'blogs_layout',
			    'settings'   => 'responsi_enable_fix_ext_cat_author',
			    'type'       => 'iradio',
			    'input_attrs' => array(
					'checked_label' => 'ON',
					'unchecked_label' => 'OFF',
					'container_width' => 80,
					'class' => 'hide last'
		        ),
			    'choices' => array("none" => __( 'Auto height', 'responsi' ), "1" => __( '1 Line', 'responsi' ), "2" => __( '2 Line', 'responsi' ), "3" => __( '3 Line', 'responsi' ) )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_enable_fix_ext_cat_author']) ? $responsi_options['responsi_enable_fix_ext_cat_author'] : '2',
			    'sanitize_callback' => 'responsi_sanitize_choices',
			)
		);
		$blogs_controls_settings['lbblog5'] = array(
			'control' => array(
			    'label'      => __('Footer Cell #2 Features', 'responsi'),
			    'section'    => 'blogs_layout',
			    'type'       => 'ilabel',
			),
			'setting' => array()
		);
		$blogs_controls_settings['responsi_disable_ext_tags_comment'] = array(
			'control' => array(
			    'label'      => __('Footer Cell #2', 'responsi'),
			    'section'    => 'blogs_layout',
			    'settings'   => 'responsi_disable_ext_tags_comment',
			    'type'       => 'icheckbox',
			    'input_attrs' => array(
			    	'class' => 'collapsed'
		        ),
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_disable_ext_tags_comment']) ? $responsi_options['responsi_disable_ext_tags_comment'] : 'true',
			    'sanitize_callback' => 'responsi_sanitize_checkboxs',
			)
		);
		$blogs_controls_settings['responsi_disable_ext_comments_cell'] = array(
			'control' => array(
			    'label'      => __('Post Comment Count', 'responsi'),
			    'section'    => 'blogs_layout',
			    'settings'   => 'responsi_disable_ext_comments_cell',
			    'type'       => 'icheckbox',
			    'input_attrs' => array(
			    	'class' => 'hide'
		        ),
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_disable_ext_comments_cell']) ? $responsi_options['responsi_disable_ext_comments_cell'] : 'true',
				'sanitize_callback' => 'responsi_sanitize_checkboxs',
			)
		);
		$blogs_controls_settings['responsi_disable_ext_tags_cell'] = array(
			'control' => array(
			    'label'      => __('Post Tags', 'responsi'),
			    'section'    => 'blogs_layout',
			    'settings'   => 'responsi_disable_ext_tags_cell',
			    'type'       => 'icheckbox',
			    'choices' => array(
			    	'checked_label' => 'ON',
					'unchecked_label' => 'OFF'
		        ),
			    'input_attrs' => array(
			    	'class' => 'hide'
		        ),
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_disable_ext_tags_cell']) ? $responsi_options['responsi_disable_ext_tags_cell'] : 'true',
				'sanitize_callback' => 'responsi_sanitize_checkboxs',
			)
		);
		$blogs_controls_settings['responsi_enable_fix_ext_tags_comment'] = array(
			'control' => array(
			    'label'      => __('Cell #2 Line Wrap', 'responsi'),
			    'section'    => 'blogs_layout',
			    'settings'   => 'responsi_enable_fix_ext_tags_comment',
			    'type'       => 'iradio',
			    'input_attrs' => array(
					'checked_label' => 'ON',
					'unchecked_label' => 'OFF',
					'container_width' => 80,
					'class' => 'hide last'
		        ),
			    'choices' => array("none" => __( 'Auto height', 'responsi' ), "1" => __( '1 Line', 'responsi' ), "2" => __( '2 Line', 'responsi' ), "3" => __( '3 Line', 'responsi' ) )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_enable_fix_ext_tags_comment']) ? $responsi_options['responsi_enable_fix_ext_tags_comment'] : '3',
				'sanitize_callback' => 'responsi_sanitize_choices',
			)
		);

		$blogs_controls_settings['lbblog6'] = array(
			'control' => array(
			    'label'      => __('Card Footer Container', 'responsi'),
			    'section'    => 'blogs_layout',
			    'type'       => 'ilabel',
			    'input_attrs' => array(
					'class' => 'footer-cell-both'
		        )
			),
			'setting' => array()
		);
		$blogs_controls_settings['responsi_blog_ext_font'] = array(
			'control' => array(
			    'label' => __('Font', 'responsi'),
			    'section'    => 'blogs_layout',
			    'settings'   => 'multiple',
			    'type'       => 'typography',
			    'input_attrs' => array(
					'class' => 'footer-cell-both'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_blog_ext_font']) ? $responsi_options['responsi_blog_ext_font'] : array('size' => '12','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#555555'),
			    'sanitize_callback' => 'responsi_sanitize_typography',
			    'transport'	=> 'postMessage'
			)
		);
		$blogs_controls_settings['responsi_blog_ext_alignment'] = array(
			'control' => array(
			    'label'      => __('Alignment', 'responsi'),
			    'section'    => 'blogs_layout',
			    'settings'   => 'responsi_blog_ext_alignment',
			    'type'       => 'iradio',
			    'input_attrs' => array(
					'checked_label' => 'ON',
					'unchecked_label' => 'OFF',
					'container_width' => 80,
					'class' => 'footer-cell-both'
		        ),
			    'choices' => array("left" => "Left", "center" => "Center", "right" => "Right", "justify" => "Justify"),
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_blog_ext_alignment']) ? $responsi_options['responsi_blog_ext_alignment'] : 'left',
			    'sanitize_callback' => 'responsi_sanitize_choices',
			    'transport'	=> 'postMessage'
			)
		);
		$blogs_controls_settings['responsi_post_author_archive_bg'] = array(
			'control' => array(
			    'label'      => __('Background Colour', 'responsi'),
			    'section'    => 'blogs_layout',
			    'settings'   => 'multiple',
			    'type'       => 'ibackground',
			    'input_attrs' => array(
					'class' => 'footer-cell-both'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_post_author_archive_bg']) ? $responsi_options['responsi_post_author_archive_bg'] : array('onoff' => 'true', 'color' => '#f4f4f4'),
			    'sanitize_callback' => 'responsi_sanitize_background_color',
			    'transport'	=> 'postMessage'
			)
		);
		$blogs_controls_settings['responsi_post_author_archive_border_top'] = array(
			'control' => array(
			    'label'      => __('Cells #1 Border - Top', 'responsi'),
			    'section'    => 'blogs_layout',
			    'settings'   => 'multiple',
			    'type'       => 'border',
			    'input_attrs' => array(
					'class' => 'footer-cell-both footer-cell-1'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_post_author_archive_border_top']) ? $responsi_options['responsi_post_author_archive_border_top'] : array('width' => '1','style' => 'solid','color' => '#DBDBDB'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);
		$blogs_controls_settings['responsi_post_author_archive_border_bottom'] = array(
			'control' => array(
			    'label'      => __('Cells #1 Border - Bottom', 'responsi'),
			    'section'    => 'blogs_layout',
			    'settings'   => 'multiple',
			    'type'       => 'border',
			    'input_attrs' => array(
					'class' => 'footer-cell-both footer-cell-1'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_post_author_archive_border_bottom']) ? $responsi_options['responsi_post_author_archive_border_bottom'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);
		$blogs_controls_settings['responsi_post_tags_comment_border_top'] = array(
			'control' => array(
			    'label'      => __('Cells #2 Border - Top', 'responsi'),
			    'section'    => 'blogs_layout',
			    'settings'   => 'multiple',
			    'type'       => 'border',
			    'input_attrs' => array(
					'class' => 'footer-cell-both footer-cell-2'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_post_tags_comment_border_top']) ? $responsi_options['responsi_post_tags_comment_border_top'] : array('width' => '1','style' => 'solid','color' => '#DBDBDB'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);
		$blogs_controls_settings['responsi_post_tags_comment_border_bottom'] = array(
			'control' => array(
			    'label'      => __('Cells #2 Border - Bottom', 'responsi'),
			    'section'    => 'blogs_layout',
			    'settings'   => 'multiple',
			    'type'       => 'border',
			    'input_attrs' => array(
					'class' => 'footer-cell-both footer-cell-2'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_post_tags_comment_border_bottom']) ? $responsi_options['responsi_post_tags_comment_border_bottom'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB'),
			    'sanitize_callback' => 'responsi_sanitize_border',
			    'transport'	=> 'postMessage'
			)
		);

		$blogs_controls_settings['responsi_enable_post_author_archive_icon'] = array(
			'control' => array(
			    'label'      => __('Cells Icons', 'responsi'),
			    'section'    => 'blogs_layout',
			    'settings'   => 'responsi_enable_post_author_archive_icon',
			    'type'       => 'icheckbox',
			    'choices' => array(
			    	'checked_label' => 'ON',
					'unchecked_label' => 'OFF'
		        ),
			    'input_attrs' => array(
			    	'class' => 'collapsed-custom footer-cell-both'
		        ),
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_enable_post_author_archive_icon']) ? $responsi_options['responsi_enable_post_author_archive_icon'] : 'true',
			    'sanitize_callback' => 'responsi_sanitize_checkboxs',
			    'transport'	=> 'postMessage'
			)
		);

		$blogs_controls_settings['responsi_post_author_archive_icon'] = array(
			'control' => array(
			    'label'      => __('Icon Colour', 'responsi'),
			    'section'    => 'blogs_layout',
			    'settings'   => 'responsi_post_author_archive_icon',
			    'type'       => 'icolor',
			    'input_attrs' => array(
					'class' => 'footer-cell-both hide-custom hide-custom-last'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_post_author_archive_icon']) ? $responsi_options['responsi_post_author_archive_icon'] : '#555555',
			    'sanitize_callback' => 'sanitize_hex_color',
			    'transport'	=> 'postMessage'
			)
		);
		$blogs_controls_settings['responsi_blogext_padding'] = array(
			'control' => array(
			    'label'      => __('Padding', 'responsi'),
			    'section'    => 'blogs_layout',
			    'settings'   => 'multitext',
			    'type'       => 'multitext',
			    'choices' => array(
			    	'top' => 'Top',
					'bottom' => 'Bottom',
					'left' => 'Left',
					'right' => 'Right',
		        ),
		        'input_attrs' => array(
					'class' => 'footer-cell-both'
		        )
			),
			'setting' => array(
				'default'		=> array( 
					isset($responsi_options['responsi_blogext_padding_top']) ? $responsi_options['responsi_blogext_padding_top'] : '5' , 
					isset($responsi_options['responsi_blogext_padding_bottom']) ? $responsi_options['responsi_blogext_padding_bottom'] : '5',
					isset($responsi_options['responsi_blogext_padding_left']) ? $responsi_options['responsi_blogext_padding_left'] : '10',
					isset($responsi_options['responsi_blogext_padding_right']) ? $responsi_options['responsi_blogext_padding_right'] : '10'
				),
				'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage',
			)
		);
		
		$blogs_controls_settings['lbblog7'] = array(
			'control' => array(
			    'label'      => __('Post Title Font', 'responsi'),
			    'section'    => 'blogs_style',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);

		$blogs_controls_settings['responsi_blog_post_font_title'] = array(
			'control' => array(
			    'label' => __('Title Font', 'responsi'),
			    'section'    => 'blogs_style',
			    'settings'   => 'multiple',
			    'type'       => 'typography'
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_blog_post_font_title']) ? $responsi_options['responsi_blog_post_font_title'] : array('size' => '22','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#8cc700'),
			    'sanitize_callback' => 'responsi_sanitize_typography',
			    'transport'	=> 'postMessage'
			)
		);
		$blogs_controls_settings['responsi_blog_post_font_title_transform'] = array(
			'control' => array(
			    'label'      => __('Title Transformation', 'responsi'),
			    'section'    => 'blogs_style',
			    'settings'   => 'responsi_blog_post_font_title_transform',
			    'type'       => 'iradio',
			    'input_attrs' => array(
					'checked_label' => 'ON',
					'unchecked_label' => 'OFF',
					'container_width' => 80
		        ),
			    'choices' => array( "none" => "None","uppercase" => "Uppercase", "lowercase" => "Lowercase")
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_blog_post_font_title_transform']) ? $responsi_options['responsi_blog_post_font_title_transform'] : 'none',
			    'sanitize_callback' => 'responsi_sanitize_choices',
			    'transport'	=> 'postMessage'
			)
		);
		$blogs_controls_settings['responsi_blog_post_title_alignment'] = array(
			'control' => array(
			    'label'      => __('Title Alignment', 'responsi'),
			    'section'    => 'blogs_style',
			    'settings'   => 'responsi_blog_post_title_alignment',
			    'type'       => 'iradio',
			    'input_attrs' => array(
					'checked_label' => 'ON',
					'unchecked_label' => 'OFF',
					'container_width' => 80
		        ),
			    'choices' => array("left" => "Left", "center" => "Center", "right" => "Right", "justify" => "Justify")
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_blog_post_title_alignment']) ? $responsi_options['responsi_blog_post_title_alignment'] : 'left',
			    'sanitize_callback' => 'responsi_sanitize_choices',
			    'transport'	=> 'postMessage'
			)
		);

		$blogs_controls_settings['responsi_enable_fix_tall_title_grid'] = array(
			'control' => array(
			    'label'      => __('Post Title Line Wrap', 'responsi'),
			    'section'    => 'blogs_style',
			    'settings'   => 'responsi_enable_fix_tall_title_grid',
			    'type'       => 'iradio',
			    'input_attrs' => array(
					'checked_label' => 'ON',
					'unchecked_label' => 'OFF',
					'container_width' => 80
		        ),
			    'choices' => array("none" => __( 'Auto height', 'responsi' ), "1" => __( '1 Line', 'responsi' ), "2" => __( '2 Line', 'responsi' ), "3" => __( '3 Line', 'responsi' ) )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_enable_fix_tall_title_grid']) ? $responsi_options['responsi_enable_fix_tall_title_grid'] : '2',
				'sanitize_callback' => 'responsi_sanitize_choices',
			)
		);

		$blogs_controls_settings['responsi_blog_post_title_padding'] = array(
			'control' => array(
			    'label'      => __('Title Padding', 'responsi'),
			    'section'    => 'blogs_style',
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
					isset($responsi_options['responsi_blog_post_title_padding_top']) ? $responsi_options['responsi_blog_post_title_padding_top'] : '0' , 
					isset($responsi_options['responsi_blog_post_title_padding_bottom']) ? $responsi_options['responsi_blog_post_title_padding_bottom'] : '5',
					isset($responsi_options['responsi_blog_post_title_padding_left']) ? $responsi_options['responsi_blog_post_title_padding_left'] : '10',
					isset($responsi_options['responsi_blog_post_title_padding_right']) ? $responsi_options['responsi_blog_post_title_padding_right'] : '10'
				),
				'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage',
			)
		);

		$blogs_controls_settings['lbblog8'] = array(
			'control' => array(
			    'label'      => __('Post Published Date', 'responsi'),
			    'section'    => 'blogs_style',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);

		$blogs_controls_settings['responsi_enable_post_date_blog'] = array(
			'control' => array(
			    'label'      => __('Post Date', 'responsi'),
			    'section'    => 'blogs_style',
			    'settings'   => 'responsi_enable_post_date_blog',
			    'type'       => 'icheckbox',
			    'input_attrs' => array(
			    	'class' => 'collapsed-custom'
		        ),
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_enable_post_date_blog']) ? $responsi_options['responsi_enable_post_date_blog'] : 'false',
			    'sanitize_callback' => 'responsi_sanitize_checkboxs',
			    //'transport'	=> 'postMessage'
			)
		);
		$blogs_controls_settings['responsi_blog_post_font_date'] = array(
			'control' => array(
			    'label' => __('Font', 'responsi'),
			    'section'    => 'blogs_style',
			    'settings'   => 'multiple',
			    'type'       => 'typography',
			    'input_attrs' => array(
			    	'class' => 'hide-custom'
		        ),
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_blog_post_font_date']) ? $responsi_options['responsi_blog_post_font_date'] : array('size' => '12','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#555555'),
			    'sanitize_callback' => 'responsi_sanitize_typography',
			    'transport'	=> 'postMessage'
			)
		);
		$blogs_controls_settings['responsi_blog_post_font_date_transform'] = array(
			'control' => array(
			    'label'      => __('Transformation', 'responsi'),
			    'section'    => 'blogs_style',
			    'settings'   => 'responsi_blog_post_font_date_transform',
			    'type'       => 'iradio',
			    'input_attrs' => array(
					'checked_label' => 'ON',
					'unchecked_label' => 'OFF',
					'container_width' => 80,
					'class' => 'hide-custom'
		        ),
			    'choices' => array( "none" => "None","uppercase" => "Uppercase", "lowercase" => "Lowercase")
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_blog_post_font_date_transform']) ? $responsi_options['responsi_blog_post_font_date_transform'] : 'none',
			    'sanitize_callback' => 'responsi_sanitize_choices',
			    'transport'	=> 'postMessage'
			)
		);
		$blogs_controls_settings['responsi_blog_post_date_alignment'] = array(
			'control' => array(
			    'label'      => __('Alignment', 'responsi'),
			    'section'    => 'blogs_style',
			    'settings'   => 'responsi_blog_post_date_alignment',
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
			    'default'		=> isset($responsi_options['responsi_blog_post_date_alignment']) ? $responsi_options['responsi_blog_post_date_alignment'] : 'left',
			    'sanitize_callback' => 'responsi_sanitize_choices',
			    'transport'	=> 'postMessage'
			)
		);
		$blogs_controls_settings['responsi_enable_blog_post_date_icon'] = array(
			'control' => array(
			    'label'      => __('Date Icon', 'responsi'),
			    'section'    => 'blogs_style',
			    'settings'   => 'responsi_enable_blog_post_date_icon',
			    'type'       => 'icheckbox',
			    'choices' => array(
			    	'checked_label' => 'ON',
					'unchecked_label' => 'OFF'
		        ),
			    'input_attrs' => array(
			    	'class' => 'hide-custom collapsed'
		        ),
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_enable_blog_post_date_icon']) ? $responsi_options['responsi_enable_blog_post_date_icon'] : 'true',
			    'sanitize_callback' => 'responsi_sanitize_checkboxs',
			    'transport'	=> 'postMessage'
			)
		);
		$blogs_controls_settings['responsi_blog_post_date_icon'] = array(
			'control' => array(
			    'label'      => __('Icon Colour', 'responsi'),
			    'section'    => 'blogs_style',
			    'settings'   => 'responsi_blog_post_date_icon',
			    'type'       => 'icolor',
			    'input_attrs' => array(
			    	'class' => 'hide-custom hide last'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_blog_post_date_icon']) ? $responsi_options['responsi_blog_post_date_icon'] : '#555555',
			    'sanitize_callback' => 'sanitize_hex_color',
			    'transport'	=> 'postMessage'
			)
		);
		$blogs_controls_settings['responsi_blog_post_date_padding'] = array(
			'control' => array(
			    'label'      => __('Padding', 'responsi'),
			    'section'    => 'blogs_style',
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
					isset($responsi_options['responsi_blog_post_date_padding_top']) ? $responsi_options['responsi_blog_post_date_padding_top'] : '0' , 
					isset($responsi_options['responsi_blog_post_date_padding_bottom']) ? $responsi_options['responsi_blog_post_date_padding_bottom'] : '5',
					isset($responsi_options['responsi_blog_post_date_padding_left']) ? $responsi_options['responsi_blog_post_date_padding_left'] : '10',
					isset($responsi_options['responsi_blog_post_date_padding_right']) ? $responsi_options['responsi_blog_post_date_padding_right'] : '10'
				),
				'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage',
			)
		);
		$blogs_controls_settings['lbblog9'] = array(
			'control' => array(
			    'label'      => __('Post Extract Text', 'responsi'),
			    'section'    => 'blogs_style',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);

		$blogs_controls_settings['responsi_disable_blog_content'] = array(
			'control' => array(
			    'label'      => __('Post Description', 'responsi'),
			    'section'    => 'blogs_style',
			    'settings'   => 'responsi_disable_blog_content',
			    'type'       => 'icheckbox',
			    'input_attrs' => array(
			    	'class' => 'collapsed'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_disable_blog_content']) ? $responsi_options['responsi_disable_blog_content'] : 'true',
				'sanitize_callback' => 'responsi_sanitize_checkboxs',
			)
		);

		$blogs_controls_settings['responsi_blog_post_font_content'] = array(
			'control' => array(
			    'label' => __('Font', 'responsi'),
			    'section'    => 'blogs_style',
			    'settings'   => 'multiple',
			    'type'       => 'typography',
			    'input_attrs' => array(
			    	'class' => 'hide'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_blog_post_font_content']) ? $responsi_options['responsi_blog_post_font_content'] : array('size' => '14','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#555555'),
			    'sanitize_callback' => 'responsi_sanitize_typography',
			    'transport'	=> 'postMessage'
			)
		);
		$blogs_controls_settings['responsi_blog_post_content_alignment'] = array(
			'control' => array(
			    'label'      => __('Alignment', 'responsi'),
			    'section'    => 'blogs_style',
			    'settings'   => 'responsi_blog_post_content_alignment',
			    'type'       => 'iradio',
			    'input_attrs' => array(
					'checked_label' => 'ON',
					'unchecked_label' => 'OFF',
					'container_width' => 80,
					'class' => 'hide'
		        ),
			    'choices' => array("left" => "Left", "center" => "Center", "right" => "Right", "justify" => "Justify")
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_blog_post_content_alignment']) ? $responsi_options['responsi_blog_post_content_alignment'] : 'left',
			    'sanitize_callback' => 'responsi_sanitize_choices',
			    'transport'	=> 'postMessage'
			)
		);
		$blogs_controls_settings['responsi_enable_fix_tall_des_grid'] = array(
			'control' => array(
			    'label'      => __('Post Description Line Wrap', 'responsi'),
			    'section'    => 'blogs_style',
			    'settings'   => 'responsi_enable_fix_tall_des_grid',
			    'type'       => 'iradio',
			    'input_attrs' => array(
					'checked_label' => 'ON',
					'unchecked_label' => 'OFF',
					'container_width' => 80,
					'class' => 'hide'
		        ),
			    'choices' => array("1" => __( '1 Line', 'responsi' ), "2" => __( '2 Line', 'responsi' ), "3" => __( '3 Line', 'responsi' ), "4" => __( '4 Line', 'responsi' ) )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_enable_fix_tall_des_grid']) ? $responsi_options['responsi_enable_fix_tall_des_grid'] : '3',
				'sanitize_callback' => 'responsi_sanitize_choices',
			)
		);
		$blogs_controls_settings['responsi_blog_post_description_padding'] = array(
			'control' => array(
			    'label'      => __('Padding', 'responsi'),
			    'section'    => 'blogs_style',
			    'settings'   => 'multitext',
			    'type'       => 'multitext',
			    'input_attrs' => array(
			    	'class' => 'hide last'
		        ),
			    'choices' => array(
			    	'top' => 'Top',
					'bottom' => 'Bottom',
					'left' => 'Left',
					'right' => 'Right',
		        )
			),
			'setting' => array(
				'default'		=> array( 
					isset($responsi_options['responsi_blog_post_description_padding_top']) ? $responsi_options['responsi_blog_post_description_padding_top'] : '0' , 
					isset($responsi_options['responsi_blog_post_description_padding_bottom']) ? $responsi_options['responsi_blog_post_description_padding_bottom'] : '5',
					isset($responsi_options['responsi_blog_post_description_padding_left']) ? $responsi_options['responsi_blog_post_description_padding_left'] : '10',
					isset($responsi_options['responsi_blog_post_description_padding_right']) ? $responsi_options['responsi_blog_post_description_padding_right'] : '10'
				),
				'sanitize_callback' => 'responsi_sanitize_numeric',
			    'transport'	=> 'postMessage',
			)
		);

		$blogs_controls_settings['lbblog10'] = array(
			'control' => array(
			    'label'      => __('Read More Link', 'responsi'),
			    'section'    => 'blogs_style',
			    'type'       => 'ilabel'
			),
			'setting' => array()
		);
		$blogs_controls_settings['responsi_disable_blog_morelink'] = array(
			'control' => array(
			    'label'      => __('Read More Feature', 'responsi'),
			    'section'    => 'blogs_style',
			    'settings'   => 'responsi_disable_blog_morelink',
			    'type'       => 'icheckbox',
			    'input_attrs' => array(
			    	'class' => 'collapsed'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_disable_blog_morelink']) ? $responsi_options['responsi_disable_blog_morelink'] : 'true',
			    'sanitize_callback' => 'responsi_sanitize_checkboxs',
			    'transport'	=> 'postMessage'
			)
		);
		$blogs_controls_settings['responsi_blog_morelink_type'] = array(
			'control' => array(
			    'label'      => __('Button or Linked Text', 'responsi'),
			    'section'    => 'blogs_style',
			    'settings'   => 'responsi_blog_morelink_type',
			    'type'       => 'iswitcher',
			    'choices' => array(
			    	'checked_value' => 'link',
					'checked_label' => 'Link',
					'unchecked_value' => 'button',
					'unchecked_label' => 'Button',
					'container_width' => 115
		        ),
			    'input_attrs' => array(
			    	'class' => 'hide'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_blog_morelink_type']) ? $responsi_options['responsi_blog_morelink_type'] : 'button',
			    'sanitize_callback' => 'responsi_sanitize_checkboxs',
			    'transport'	=> 'postMessage'
			)
		);
		$blogs_controls_settings['responsi_blog_morelink_text'] = array(
			'control' => array(
			    'label'      => __('Custom Text', 'responsi'),
			    'section'    => 'blogs_style',
			    'settings'   => 'responsi_blog_morelink_text',
			    'type'       => 'itext',
			    'input_attrs' => array(
			    	'class' => 'hide'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_blog_morelink_text']) ? $responsi_options['responsi_blog_morelink_text'] : 'Read more',
			    'sanitize_callback' => 'sanitize_text_field',
			    'transport'	=> 'postMessage'
			)
		);
		$blogs_controls_settings['responsi_blog_morelink_font'] = array(
			'control' => array(
			    'label' => __('Font', 'responsi'),
			    'section'    => 'blogs_style',
			    'settings'   => 'multiple',
			    'type'       => 'typography',
			    'input_attrs' => array(
			    	'class' => 'hide'
		        )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_blog_morelink_font']) ? $responsi_options['responsi_blog_morelink_font'] : array('size' => '12','line_height' => '1','face' => 'Open Sans','style' => 'bold','color' => '#ffffff'),
			    'sanitize_callback' => 'responsi_sanitize_typography',
			    'transport'	=> 'postMessage'
			)
		);

		$blogs_controls_settings['responsi_blog_morelink_alignment'] = array(
			'control' => array(
			    'label'      => __('Alignment', 'responsi'),
			    'section'    => 'blogs_style',
			    'settings'   => 'responsi_blog_morelink_alignment',
			    'type'       => 'iradio',
			    'input_attrs' => array(
					'checked_label' => 'ON',
					'unchecked_label' => 'OFF',
					'container_width' => 80,
					'class' => 'hide last'
		        ),
			    'choices' => array( "left" => __( 'Left', 'responsi' ), "center" => __( 'Center', 'responsi' ), "right" => __( 'Right', 'responsi' ) )
			),
			'setting' => array(
			    'default'		=> isset($responsi_options['responsi_blog_morelink_alignment']) ? $responsi_options['responsi_blog_morelink_alignment'] : 'left',
			    'sanitize_callback' => 'responsi_sanitize_choices',
			    'transport'	=> 'postMessage'
			)
		);
		
		$blogs_controls_settings = apply_filters( 'responsi_blogs_controls_settings', $blogs_controls_settings );
		$controls_settings = array_merge($controls_settings, $blogs_controls_settings);
		return  $controls_settings;
	}
}

new Responsi_Customize_Blogs();
?>