<?php

namespace A3Rev\Responsi;

/**
 * Responsi Customize classes
 *
 * @package WordPress
 * @subpackage Customize
 * @since 3.9.0
 */

/**
 * Responsi Customize class.
 *
 * Implements responsi management in the Customizer.
 *
 * @since 3.9.0
 *
 * @see Responsi_Customize
 */

final class Customizer {

	public $manager;

	protected $settings = array();

	protected $panels = array();

	protected $sections = array();

	protected $controls = array();

	public function __construct() {

		add_action( 'init',  									array( $this, 'responsi_customize_stop_heartbeat'), 1 );
		add_action( 'admin_enqueue_scripts',  					array( $this, 'responsi_customize_stop_heartbeat') );
		
		add_action( 'wp_enqueue_scripts', 						array( $this, 'responsi_add_dynamic_css' ) );

		if( is_customize_preview() ){
			add_action( 'wp_default_scripts', 					array( $this, 'responsi_register_script' ), 11 );
		}
		
		add_filter( 'responsi_focus_panels', 					array( $this, 'responsi_focus_panels') );
		add_filter( 'responsi_focus_sections', 					array( $this, 'responsi_focus_sections') );
		add_filter( 'responsi_focus_controls', 					array( $this, 'responsi_focus_controls') );
		
		add_filter( 'responsi_customized_post_value', 			array( $this, 'responsi_customized_post_value') );
		add_filter( 'responsi_customized_changeset_data_value', array( $this, 'responsi_customized_changeset_data_value') );

		add_action( 'customize_register',                      	array( $this, 'responsi_customize_register' ) );
		add_action( 'customize_preview_init', 					array( $this, 'responsi_customize_preview_init' ) );

		add_action( 'customize_controls_print_styles', 			array( $this, 'responsi_customize_controls_print_styles' ) );
		add_action( 'customize_controls_enqueue_scripts', 		array( $this, 'responsi_customize_controls_print_footer_scripts' ) );
		add_action( 'customize_controls_print_footer_scripts', 'responsi_wp_editor_customize', 9 );
		add_action( 'customize_controls_print_footer_scripts', 	array( $this, 'responsi_customize_controls_settings' ), 1000 );
		add_action( 'customize_save_after', 					array( $this, 'responsi_customize_save_options'), 999 );

	}

	public function responsi_customize_stop_heartbeat() {
		if( is_customize_preview() ){
			wp_deregister_script( 'heartbeat' );
			wp_deregister_style( 'a3rev-wp-admin-style' );
			wp_deregister_style( 'a3rev-dashboard-menu-style' );
		}
	}

	public function add_control( $id, $args = array() ) {
		if ( $id instanceof \WP_Customize_Control ) {
			$control = $id;
		} else {
			$control = new \WP_Customize_Control( $this, $id, $args );
		}

		$this->controls[ $control->id ] = $control;
		return $control;
	}

	public function responsi_customize_register() {

		@set_time_limit( 86400 );
		@ini_set( "memory_limit", "640M" );

		$controls_template = 'controls-templates';

		$_custom_customizer_control = array(
			'functions/theme-customizer/'.$controls_template.'/custom-ilabel-control.php',
			'functions/theme-customizer/'.$controls_template.'/custom-icheckbox-control.php',
			'functions/theme-customizer/'.$controls_template.'/custom-imulticheckbox-control.php',
			'functions/theme-customizer/'.$controls_template.'/custom-itext-control.php',
			'functions/theme-customizer/'.$controls_template.'/custom-itextarea-control.php',
			'functions/theme-customizer/'.$controls_template.'/custom-iselect-control.php',
			'functions/theme-customizer/'.$controls_template.'/custom-slider-control.php',
			'functions/theme-customizer/'.$controls_template.'/custom-background-patterns-control.php',
			'functions/theme-customizer/'.$controls_template.'/custom-layout-control.php',
			'functions/theme-customizer/'.$controls_template.'/custom-ieditor-control.php',
			'functions/theme-customizer/'.$controls_template.'/custom-iswitcher-control.php',
			'functions/theme-customizer/'.$controls_template.'/custom-iradio-control.php',
			'functions/theme-customizer/'.$controls_template.'/custom-icolor-control.php',
			'functions/theme-customizer/'.$controls_template.'/custom-iupload-control.php',
			'functions/theme-customizer/'.$controls_template.'/custom-iuploadcrop-control.php',
			'functions/theme-customizer/'.$controls_template.'/custom-multitext-control.php',
			'functions/theme-customizer/'.$controls_template.'/custom-ibackground-control.php',
			'functions/theme-customizer/'.$controls_template.'/custom-border-control.php',
			'functions/theme-customizer/'.$controls_template.'/custom-border-radius-control.php',
			'functions/theme-customizer/'.$controls_template.'/custom-border-boxes-control.php',
			'functions/theme-customizer/'.$controls_template.'/custom-box-shadow-control.php',
			'functions/theme-customizer/'.$controls_template.'/custom-typography-control.php',
			'functions/theme-customizer/'.$controls_template.'/custom-animation-control.php',
			'functions/theme-customizer/'.$controls_template.'/custom-column-control.php',
		);
		$_custom_customizer_control = apply_filters( '_custom_customizer_control', $_custom_customizer_control );
		foreach ( $_custom_customizer_control as $i ) {
			locate_template( $i, true );
		}

		global $wp_customize;

		$this->manager = $wp_customize;

		$changeset = $this->manager->unsanitized_post_values();

		// Preview settings for responsi early so that the sections and controls will be added properly.
		$setting_ids = array();
		foreach ( array_keys( $changeset ) as $setting_id ) {
			$setting_ids[] = $setting_id;
		}
		
		$settings = $this->manager->add_dynamic_settings( $setting_ids );
		if ( $this->manager->settings_previewed() ) {
			foreach ( $settings as $setting ) {
				$setting->preview();
			}
		}

		//Register Controls
		$this->manager->register_control_type( '\A3Rev\Responsi\Customize_iLabel_Control' );
		$this->manager->register_control_type( '\A3Rev\Responsi\Customize_iText_Control' );
		$this->manager->register_control_type( '\A3Rev\Responsi\Customize_iTextarea_Control' );
		$this->manager->register_control_type( '\A3Rev\Responsi\Customize_iSelect_Control' );
		$this->manager->register_control_type( '\A3Rev\Responsi\Customize_Layout_Control' );
		$this->manager->register_control_type( '\A3Rev\Responsi\Customize_Background_Patterns_Control' );
		$this->manager->register_control_type( '\A3Rev\Responsi\Customize_Slider_Control' );
		$this->manager->register_control_type( '\A3Rev\Responsi\Customize_iCheckbox_Control' );
		$this->manager->register_control_type( '\A3Rev\Responsi\Customize_iMultiCheckbox_Control' );
		$this->manager->register_control_type( '\A3Rev\Responsi\Customize_iSwitcher_Control' );
		$this->manager->register_control_type( '\A3Rev\Responsi\Customize_iRadio_Control' );
		$this->manager->register_control_type( '\A3Rev\Responsi\Customize_iColor_Control' );
		$this->manager->register_control_type( '\A3Rev\Responsi\Customize_iUpload_Control' );
		$this->manager->register_control_type( '\A3Rev\Responsi\Customize_iUploadCrop_Control' );
		$this->manager->register_control_type( '\A3Rev\Responsi\Customize_Multiple_Text_Control' );
		$this->manager->register_control_type( '\A3Rev\Responsi\Customize_Typography_Control' );
		$this->manager->register_control_type( '\A3Rev\Responsi\Customize_iBackground_Control' );
		$this->manager->register_control_type( '\A3Rev\Responsi\Customize_Border_Control' );
		$this->manager->register_control_type( '\A3Rev\Responsi\Customize_Border_Radius_Control' );
		$this->manager->register_control_type( '\A3Rev\Responsi\Customize_Border_Boxes_Control' );
		$this->manager->register_control_type( '\A3Rev\Responsi\Customize_Box_Shadow_Control' );
		$this->manager->register_control_type( '\A3Rev\Responsi\Customize_iEditor_Control' );
		$this->manager->register_control_type( '\A3Rev\Responsi\Customize_Animation_Control' );
		$this->manager->register_control_type( '\A3Rev\Responsi\Customize_Column_Control' );

		//Register Panels
		$panels = apply_filters( 'responsi_customize_register_panels', array() );
		if( is_array( $panels ) && count( $panels ) > 0 ){
			foreach ($panels as $key => $value) {
				$this->manager->add_panel( $key, $value );
				$this->panels[$key] = $value;
			}
		}

		//Register Sections
		$sections = apply_filters( 'responsi_customize_register_sections', array() );
		if( is_array( $sections ) && count( $sections ) > 0 ){
			foreach ($sections as $key => $value) {
				$this->manager->add_section( $key, $value );
				$this->sections[$key] = $value;
			}
		}

		$new_setting_ids = array();
		
		$_controls_settings = apply_filters( 'responsi_customize_register_settings', array() );

		$_controls_settings_new = array(); 

		if( is_array( $_controls_settings ) && count( $_controls_settings ) > 0 ){
			$i = 0;
			foreach ($_controls_settings as $key => $value) {
				if( isset($value['control']['type']) && $value['control']['type'] == 'ilabel' ){
					$key = 'lb'.$i;
				}
				$_controls_settings_new[$key] = $value;
				$i++;
			}
		}

		$_controls_settings = $_controls_settings_new;

		//Register settings
		if( is_array( $_controls_settings_new ) && count( $_controls_settings_new ) > 0 ){

			foreach ($_controls_settings_new as $key => $value) {

				if( isset($value['control']) && isset($value['setting']) ){

					if( isset($value['control']['settings']) && $value['control']['settings'] == 'multitext' ){
						
						$default = array( '0', '0' ,'0' ,'0' );
						
						if( isset($value['setting']['default']) && is_array($value['setting']['default']) ){
							$default = $value['setting']['default'];
						}

						$value['control']['settings'] = $this->responsi_custom_control_settings( $key, $value['control']['type'], $value['control'] );

						$i = 0;
						foreach ( $value['control']['settings'] as $key => $val ){
							
							if( count($default) > 0 ){
								$value['setting']['default'] = $default[$i];
							}
							$this->settings[$key] = $value['setting'];
							$i++;

						}

					}elseif( isset($value['control']['settings']) && $value['control']['settings'] == 'multiple' ){

						if( !isset($value['setting']['default']) || !is_array($value['setting']['default']) || count( $value['setting']['default']) <= 0 ){
							
							switch ($value['control']['type']) {
								case "ibackground":
			                    	$value['setting']['default'] = array('onoff' => 'false','color' => '#ffffff');
			                    	break;
				                case "border":
				                	$value['setting']['default'] = array('width' => '0','style' => 'solid','color' => '#DBDBDB');
				                    break;
				                case "border_radius":
				                    $value['setting']['default'] = array('corner' => 'square','rounded_value' => '0');
				                    break;
				                case "border_boxes":
				                	$value['setting']['default'] = array('width' => '0','style' => 'solid','color' => '#DBDBDB','corner' => 'square', 'topleft' => '0', 'topright' => '0', 'bottomright' => '0', 'bottomleft' => '0');
				                    break;
				                case "box_shadow":
				                    $value['setting']['default'] = array( 'onoff' => 'false' , 'h_shadow' => '0px' , 'v_shadow' => '0px', 'blur' => '8px' , 'spread' => '0px', 'color' => '#DBDBDB', 'inset' => 'inset' );
				                    break;
				                case "typography":
				                    $value['setting']['default'] = array('size' => '13','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#555555');
				                    break;
				                case "animation":
				                    $value['setting']['default'] = array('type' => 'none','direction' => '', 'duration' => '1','delay' => '1');
				                    break;
				                case "column":
				                	$columns =  array( 'col' => '1' );
				                	if( isset( $value['control']['choices']) && is_array($value['control']['choices']) && count($value['control']['choices']) > 0 ){
				                		$i = 0;
				                		foreach ($value['control']['choices'] as $k => $val) {
				                			$i++;
				                			$columns['col'.$i] = round(100/count($value['control']['choices']));
				                		}
				                	}
				                    $value['setting']['default'] = $columns;
				                    break;
				            }
				        }

						$value['control']['settings'] = $this->responsi_custom_control_settings( $key, $value['control']['type'], $value['control'] );

        				$setting = $value['setting'];
        				
						foreach ( $value['control']['settings'] as $key => $val ){
							
							$key_default = explode('[', $key);
							$key_default = str_replace(']', '', $key_default[1]);
							
							if( isset(  $setting['default'][$key_default])){
								$value['setting']['default'] = $setting['default'][$key_default];
							}
							
							$this->settings[$key] = $value['setting'];
						}

					}elseif( isset($value['control']['settings']) && $value['control']['settings'] == 'multicheckbox' ){
						
						$default = array( 'false' );
						
						if( isset($value['setting']['default']) && is_array($value['setting']['default']) ){
							$default = $value['setting']['default'];
						}

						$value['control']['settings'] = $this->responsi_custom_control_settings( $key, $value['control']['type'], $value['control'] );

						$i = 0;
						foreach ( $value['control']['settings'] as $key => $val ){
							if(count($default) > 0 ){
								$value['setting']['default'] = $default[$i];
							}
							$this->settings[$key] = $value['setting'];
							$i++;
						}

					}elseif( isset($value['control']['type']) && $value['control']['type'] == 'iradio' ){

						if( isset($value['control']['choices']) && is_array($value['control']['choices']) && isset($value['setting']['default']) && $value['setting']['default'] == '' ){
							$choices = $value['control']['choices'];
							reset($choices);
							$value['setting']['default'] = key($choices);
						}

						$this->settings[$key] = $value['setting'];

					}elseif( isset($value['control']['type']) && $value['control']['type'] == 'slider' ){

						if( !isset($value['setting']['default']) || $value['setting']['default'] <= 0 ){
							$value['setting']['default'] = $value['control']['input_attrs']['min'];
						}

						$this->settings[$key] = $value['setting'];

					}elseif( isset($value['control']['type']) && $value['control']['type'] == 'ilabel' ){

						$value['setting']['type'] = '';
						$this->settings[$key] = $value['setting'];

					}else{

						$this->settings[$key] = $value['setting'];
						
					}
				}
			}

			foreach ( $this->settings as $id => $data ) {
				$this->manager->add_setting( $id, $data );
			}

		}

		//Register Controls Variabel
		if( is_array( $_controls_settings_new ) && count( $_controls_settings_new ) > 0 ){
			foreach ($_controls_settings_new as $key => $value) {

				if( isset($value['control']) ){
					if( isset($value['control']['settings']) && $value['control']['settings'] == 'multiple' ){
						$value['control']['settings'] = $this->responsi_custom_control_settings( $key, $value['control']['type'], $value['control'] );
					}
					if( isset($value['control']['settings']) && $value['control']['settings'] == 'multitext' ){
						$value['control']['settings'] = $this->responsi_custom_control_settings( $key, $value['control']['type'], $value['control'] );
					}
					if( isset($value['control']['settings']) && $value['control']['settings'] == 'multicheckbox' ){
						$value['control']['settings'] = $this->responsi_custom_control_settings( $key, $value['control']['type'], $value['control'] );
					}

					/*
					$notifications = array(
						'dismissible' => true,
		                'message' => 'Message.',
		                'type' => 'success'
					);*/

					switch ( $value['control']['type'] ) {
						case "iradio":
							$this->add_control( new \A3Rev\Responsi\Customize_iRadio_Control( $this->manager, $key, $value['control']) );
					        break;
						case "icheckbox":
							$this->add_control( new \A3Rev\Responsi\Customize_iCheckbox_Control( $this->manager, $key, $value['control']) );
					        break;
					    case "imulticheckbox":
					    	$this->add_control( new \A3Rev\Responsi\Customize_iMultiCheckbox_Control( $this->manager, $key, $value['control']) );
					        break;
						case "iswitcher":
							$this->add_control( new \A3Rev\Responsi\Customize_iSwitcher_Control( $this->manager, $key, $value['control']) );
					        break;
					    case "slider":
					    	$this->add_control( new \A3Rev\Responsi\Customize_Slider_Control( $this->manager, $key, $value['control']) );
					        break;
					    case "layout":
					    	$this->add_control( new \A3Rev\Responsi\Customize_Layout_Control( $this->manager, $key, $value['control']) );
					        break;
					    case "ibackground":
					    	$this->add_control( new \A3Rev\Responsi\Customize_iBackground_Control( $this->manager, $key, $value['control']) );
					        break;
					    case "border":
					    	$this->add_control( new \A3Rev\Responsi\Customize_Border_Control( $this->manager, $key, $value['control']) );
					        break;
					    case "border_radius":
					    	$this->add_control( new \A3Rev\Responsi\Customize_Border_Radius_Control( $this->manager, $key, $value['control']) );
					        break;
					    case "border_boxes":
					    	$this->add_control( new \A3Rev\Responsi\Customize_Border_Boxes_Control( $this->manager, $key, $value['control']) );
					        break;
					    case "box_shadow":
					    	$this->add_control( new \A3Rev\Responsi\Customize_Box_Shadow_Control( $this->manager, $key, $value['control']) );
					        break;
					    case "typography":
					    	$this->add_control( new \A3Rev\Responsi\Customize_Typography_Control( $this->manager, $key, $value['control']) );
					        break;
					    case "animation":
		                    $this->add_control( new \A3Rev\Responsi\Customize_Animation_Control( $this->manager, $key, $value['control']) );
		                    break;
		                case "column":
		                    $this->add_control( new \A3Rev\Responsi\Customize_Column_Control( $this->manager, $key, $value['control']) );
		                    break;
					    case "multitext":
					    	$this->add_control( new \A3Rev\Responsi\Customize_Multiple_Text_Control( $this->manager, $key, $value['control']) );
					        break;
					    case "icolor":
					    	$this->add_control( new \A3Rev\Responsi\Customize_iColor_Control( $this->manager, $key, $value['control']) );
					        break;
					    case "iupload":
					    	$this->add_control( new \A3Rev\Responsi\Customize_iUpload_Control( $this->manager, $key, $value['control']) );
					    	break;
					    case "iuploadcrop":
					    	$this->add_control( new \A3Rev\Responsi\Customize_iUploadCrop_Control( $this->manager, $key, $value['control']) );
					    	break;
					    case "background_patterns":
					    	$this->add_control( new \A3Rev\Responsi\Customize_Background_Patterns_Control( $this->manager, $key, $value['control']) );
					        break;
					    case "itext":
					    	$this->add_control( new \A3Rev\Responsi\Customize_iText_Control( $this->manager, $key, $value['control']) );
					        break;
					    case "itextarea":
					    	$this->add_control( new \A3Rev\Responsi\Customize_iTextarea_Control( $this->manager, $key, $value['control']) );
					        break;
					    case "ieditor":
					    	$this->add_control( new \A3Rev\Responsi\Customize_iEditor_Control( $this->manager, $key, $value['control']) );
					        break;
					    case "iselect":
					    	$this->add_control( new \A3Rev\Responsi\Customize_iSelect_Control( $this->manager, $key, $value['control']) );
					        break;
					    case "ilabel":
					    	$this->add_control( new \A3Rev\Responsi\Customize_iLabel_Control( $this->manager, $key, $value['control']) );
					        break;
					    default:
					    	$this->add_control( $key, $value['control'] );
					        break;
					}
				}
			}
		}

		if( $this->manager->get_control( 'custom_logo' ) ){
			$this->manager->get_control( 'custom_logo' )->section 	= 'settings_site_branding';
			$this->manager->get_control( 'custom_logo' )->priority 	= 2;
			$this->manager->get_control( 'custom_logo' )->label = '';
		}	

		if( $this->manager->get_control( 'blogname' ) ){
			$this->manager->get_control( 'blogname' )->section 	= 'settings_site_branding';
			$this->manager->get_control( 'blogname' )->priority 	= 3;
		}
		if( $this->manager->get_control( 'blogdescription' ) ){
			$this->manager->get_control( 'blogdescription' )->section 	= 'settings_site_branding';
			$this->manager->get_control( 'blogdescription' )->label = __('Tagline / Description', 'responsi');
			$this->manager->get_control( 'blogdescription' )->priority 	= 5;
		}
		if( $this->manager->get_control( 'site_icon' ) ){
			$this->manager->get_control( 'site_icon' )->section 	= 'settings_site_branding';
			$this->manager->get_control( 'site_icon' )->priority 	= 7;
		}
		

		// Abort if selective refresh is not available.
	    if ( isset( $this->manager->selective_refresh ) ) {

	    	do_action('responsi_customize_selective_refresh_before');

	    	$responsi_site_logo_selective_refresh = apply_filters( 'responsi_site_logo_selective_refresh', array( 'custom_logo', 'blogname' ) );
	    	
	    	if( is_array( $responsi_site_logo_selective_refresh ) && count( $responsi_site_logo_selective_refresh ) > 0 ){
	    		foreach( $responsi_site_logo_selective_refresh as $value){
	    			if( $this->manager->get_setting( $value ) )
	    				$this->manager->get_setting( $value )->transport = 'postMessage';
	    		}
	    		$this->manager->selective_refresh->add_partial( 'responsi_site_logo_selective_refresh', array(
			        'selector' => '.logo-ctn',
			        'settings' => $responsi_site_logo_selective_refresh,
			        'render_callback' => 'responsi_site_logo'
			    ) );
	    	}

	    	$responsi_site_description_selective_refresh = apply_filters( 'responsi_site_description_selective_refresh', array( 'blogdescription', 'responsi_enable_site_description') );
	    	
	    	if( is_array( $responsi_site_description_selective_refresh ) && count( $responsi_site_description_selective_refresh ) > 0 ){
	    		foreach( $responsi_site_description_selective_refresh as $value){
	    			if( $this->manager->get_setting( $value ) )
	    				$this->manager->get_setting( $value )->transport = 'postMessage';
	    		}
	    		$this->manager->selective_refresh->add_partial( 'responsi_site_description_selective_refresh', array(
			        'selector' => '.desc-ctn',
			        'settings' => $responsi_site_description_selective_refresh,
			        'render_callback' => 'responsi_site_description'
			    ) );
	    	}

	    	$responsi_site_before_footer_selective_refresh = apply_filters( 'responsi_site_before_footer_selective_refresh', array( 'responsi_footer_below', 'responsi_footer_below_text') );
	    	
	    	if( is_array( $responsi_site_before_footer_selective_refresh ) && count( $responsi_site_before_footer_selective_refresh ) > 0 ){
	    		foreach( $responsi_site_before_footer_selective_refresh as $value){
	    			if( $this->manager->get_setting( $value ) )
	    				$this->manager->get_setting( $value )->transport = 'postMessage';
	    		}
	    		$this->manager->selective_refresh->add_partial( 'responsi_site_before_footer_selective_refresh', array(
			        'selector' => '.footer .additional',
			        'settings' => $responsi_site_before_footer_selective_refresh,
			        'render_callback' => 'responsi_footer_additional'
			    ) );
	    	}

	    	$responsi_site_footer_copyright_selective_refresh = apply_filters( 'responsi_site_footer_copyright_selective_refresh', array( 'responsi_footer_left', 'responsi_footer_left_text') );
	    	
	    	if( is_array( $responsi_site_footer_copyright_selective_refresh ) && count( $responsi_site_footer_copyright_selective_refresh ) > 0 ){
	    		foreach( $responsi_site_footer_copyright_selective_refresh as $value){
	    			if( $this->manager->get_setting( $value ) )
	    				$this->manager->get_setting( $value )->transport = 'postMessage';
	    		}
	    		$this->manager->selective_refresh->add_partial( 'responsi_site_footer_copyright_selective_refresh', array(
			        'selector' => '.footer .copyright',
			        'settings' => $responsi_site_footer_copyright_selective_refresh,
			        'render_callback' => 'responsi_footer_copyright'
			    ) );
	    	}

	    	$responsi_site_footer_credit_selective_refresh = apply_filters( 'responsi_site_footer_credit_selective_refresh', array( 'responsi_footer_right_text_before', 'responsi_footer_right_login', 'responsi_enable_footer_right', 'responsi_footer_right_text_before_url', 'responsi_footer_right_logo', 'responsi_footer_right_logo_url','responsi_footer_right_text_after','responsi_footer_right_text_after_url') );
	    	
	    	if( is_array( $responsi_site_footer_credit_selective_refresh ) && count( $responsi_site_footer_credit_selective_refresh ) > 0 ){
	    		foreach( $responsi_site_footer_credit_selective_refresh as $value){
	    			if( $this->manager->get_setting( $value ) )
	    				$this->manager->get_setting( $value )->transport = 'postMessage';
	    		}
	    		$this->manager->selective_refresh->add_partial( 'responsi_site_footer_credit_selective_refresh', array(
			        'selector' => '.footer .credit',
			        'settings' => $responsi_site_footer_credit_selective_refresh,
			        'render_callback' => 'responsi_footer_credit'
			    ) );
	    	}

		    do_action('responsi_customize_selective_refresh_after');

	    }
		
	}

	public function responsi_customize_controls_settings(){
		?>
		<script type="text/javascript">
			var _responsiCustomizeSettings = {};
				_responsiCustomizeSettings.initialClientTimestamp = _.now();
				_responsiCustomizeSettings.panels = <?php echo wp_json_encode( $this->panels );?>;
				_responsiCustomizeSettings.sections = <?php echo wp_json_encode( $this->sections );?>;
				_responsiCustomizeSettings.controls = {};
		<?php
		if( is_array( $this->controls ) && count( $this->controls ) > 0 ){
			// Serialize controls one by one to improve memory usage.
			echo "(function ( c ){\n";
			foreach ( $this->controls as $control ) {

				if ( $control->check_capabilities() ) {
					printf(
						"c[%s] = %s;\n",
						wp_json_encode( $control->id ),
						wp_json_encode( $control->json() )
					);
				}
			}
			echo "})( _responsiCustomizeSettings.controls );\n";
		}
		?>
		</script>
		<?php

	}

	public function responsi_add_dynamic_css() {

		$layout_css = '.responsi-site, .responsi-toolbar, .toolbar-ctn, .responsi-wrapper, .responsi-header, .header, .responsi-navigation, .navigation, .content, .responsi-footer { position: relative; }
		.responsi-site { margin: 0 auto; padding: 0; }
		.toolbar-ctn { width: 100%; left: 0; transform: translateZ(0); }
		.toolbar-sticky .toolbar-ctn { position: fixed }
		.responsi-toolbar { left: 0; z-index: 9999; }
		.header { clear: both; }
		.header-widget-1 a { margin: 0; }
		.header-widget-1 a.logo { clear: both; display: block; }
		.header-widget-1 a.logo:hover { text-decoration: none; }
		.header-widget-1 a, .header-widget-1 a:hover { padding: 0; text-decoration: none; }
		.logo.site-logo a, .logo.site-logo img { vertical-align: top; }
		.logo.site-logo, .header .header-widget-1 .widget .logo.site-logo, .header .header-widget-1 .widget .logo.site-logo:hover, .header .header-widget-1 .widget .logo.site-logo:link, .header .header-widget-1 .widget .logo.site-logo:visited, .header .header-widget-1 .widget .logo.site-logo:focus { display: inline-block; line-height: 0; max-width: 100%; }
		.logo-ctn, .desc-ctn { line-height: 0; padding: 0; margin: 0; box-sizing: border-box; }
		.site-description { display: block; }
		.header a.logo { display: inline; }
		.header .header-widget-1 a, .header .header-widget-2 a, .header .header-widget-3 a, .header .header-widget-4 a, .header .header-widget-5 a, .header .header-widget-6 a { display: inline; }
		.footer-widgets-ctn .widget ul li { padding: 4px 0 0 !important; margin-top: 5px; }
		.footer-widgets-ctn .widget ul li:first-child { border-top: 0 dotted #bbb; margin-top: 0; }
		.footer p:first-child, .footer p:last-child { padding: 0; margin: 0; }
		.footer-widgets-in .box.col-item { margin-bottom: 0 !important; }
		.footer-widgets .block { padding-top: 20px; }
		.archive-title-ctn { display: table; float: none; width: 100%; color: #222; }
		.archive-title-ctn .catrss a { padding: 10px 0 0; text-decoration: none; line-height: 1; vertical-align: sub; display: block; }
		.ad-gallery .ad-thumbs .ad-thumb-list { float: none !important; }
		.ad-gallery .ad-image-wrapper .ad-image img { height: auto !important; vertical-align: middle !important; }
		#twitter li { padding: 6px 0; border-bottom: 1px solid #eee; }
		#twitter a { display: inline; padding: 0; background: none !important; border: none !important; }
		.fb_iframe_widget, .fb_iframe_widget > span, .fb_iframe_widget iframe * { max-width: 100%; }
		.fb_iframe_widget iframe { position: relative; left: 0; max-width: 100%; }
		.box-item .entry-item .card-thumb .thumb a img:not(.lazy-hidden) { opacity: 0; }
		.site-loaded .box-item .entry-item .card-thumb .thumb a img { opacity: 1; transition: opacity 0.5s; }
		.box-item { box-sizing: border-box; float: left; }
		.card-item { overflow: hidden; }
		.main { margin-bottom: 0px; }
		.main .box-item .entry-item.group.post h3 { margin-bottom: 15px !important; }
		.main .box-item .entry-item.group.post .thumb { height: 140px; }
		.main .box-item .entry-item { position: relative; }
		.main .box-item .entry-item .thumb { margin-bottom: 15px; width: 100%; }
		.main .box-item .entry-item .thumb img { border: none !important; height: auto; margin: 0 auto !important; max-width: 100%; padding: 0 !important; }
		.main .box-item .entry-item .card-meta .posttags ul li { background: 0; list-style: square; margin: 0; padding: 0; }
		.main .search_loop .box-item .entry-item { background: none !important; border: 0 solid #cdcdce !important; margin: 0 !important; padding: 0 !important; box-shadow: 0 0 0 0 #dbdbdb !important; }
		.main-archive .main-ctn { border: 0px solid #000; background-color: transparent; box-shadow: 0 0 0px #ffffff; border-radius: 0px; margin: 0px; padding: 0px; box-sizing: border-box; }
		.sidebar-ctn { padding: 0px; background-color: transparent; margin: 0px; box-sizing: border-box; }
		.responsi-area-archive { margin-top: 0; margin-bottom: 20px; }
		.widgetized { margin-bottom: 0; }
		#title-area { margin-bottom: 0 !important; overflow: hidden; }
		.content { padding: 0; }
		.content iframe { max-width: 100%; }
		.breadcrumbs { margin-bottom: 15px; }
		.breadcrumbs span.sep { color: #dae7ee; }
		.breadcrumbs span.trail-end { color: #c00; }
		.breadcrumbs span.trail-before { display: none; }
		body.ie .box-item .entry-item .thumb img { display: block !important; }
		.search_loop .responsi-area { background: none !important; border: 0 solid #cdcdce !important; margin: 0 !important; padding: 0 !important; box-shadow: 0 0 0 0 #dbdbdb !important; }
		.search_loop .entry { background: none !important; border: 0 solid #cdcdce !important; margin: 0 !important; padding: 0 !important; box-shadow: 0 0 0 0 #dbdbdb !important; }
		.responsi-area-post .post, .responsi-area-post .post-entries, .responsi-area-post #comments, .responsi-area-post #respond { margin-bottom: 0; margin-top: 0; }
		p.pvc_stats { margin-bottom: 0; background-position: left center !important; }
		.msr-wg-footer { display: inline-block; width: 100%; }
		.footer .credit a { vertical-align: middle; display: inline-block; }
		.footer-widgets { clear: both; position: relative; }
		.infinite-scroll.masonry { transition-property: none; }
		.navigation-mobile { display: none; }
		.navigation-mobile * { vertical-align: middle; }
		.ctrl-close { display: none !important; }
		.box-content { overflow: hidden; }
		.box-content.masonry { overflow: visible; }
		html body.ie9 .box-content .masonry-brick { margin-left: 0 !important; margin-right: 0 !important; }
		.main.box .box-content.col1 { width: 100% !important; box-sizing: border-box; }
		.main.box .box-content.col1 .box-item { width: 100% !important; margin-left: 0 !important; margin-right: 0 !important; box-sizing: border-box; }
		.main .box-item .card-thumb .thumb img.lazy-hidden { width: 100% !important; height: auto !important; left: 0; right: 0; position: inherit; }
		.card-thumb .thumb { line-height: 1; }
		.box-full { margin: 0 !important; padding: 0 !important; box-sizing: border-box; max-width: none !important; }
		.responsi-shiftclick, footer.footer, .sidebar-ctn { position: relative; }
		.shiftclick, .bt-shiftclick { color: #fff; display: none; position: absolute; left: 0px !important; top: 0px !important; cursor: pointer; z-index: 0; margin: 0px; font-size: 12px !important; font-weight: bold; text-shadow: 1px 1px 1px #000; color: #fff; width: 15px; height: 15px; line-height: 0 !important; }
		.lv0 > .shiftclick { top: 0px !important; left: 15px !important; z-index: 0 !important; }
		.lv1 > .shiftclick, .box-item.masonry-brick .shiftclick, .box.col-item > .shiftclick, .sidebar-ctn > .shiftclick { top: 5px !important; left: 5px !important; z-index: 10 !important; color: #000; text-shadow: 1px 1px 1px #fff; }
		.lv2 > .shiftclick { top: 8px !important; left: 4px !important; z-index: 2 !important; }
		.lv3 > .shiftclick { top: 12px !important; left: 6px !important; z-index: 3 !important; }
		.clearfix:hover > .shiftclick, .responsi-shiftclick:hover > .shiftclick, .card-item:hover > .shiftclick { display: block; }
		.customize-partial-edit-shortcuts-hidden .clearfix > .shiftclick, .customize-partial-edit-shortcuts-hidden .responsi-shiftclick > .shiftclick, .customize-partial-edit-shortcuts-hidden .card-item > .shiftclick { display: none !important; }
		.shiftclick:hover { font-size: 15px !important; }
		#infscr-loading { background: none repeat scroll 0 0 #000; bottom: 0 !important; color: #fff; left: 32% !important; margin: 0; opacity: .8; padding: 20px 1%; position: absolute; text-align: center; width: 30%; min-width: 200px; font-size: 12px !important; font-family: "Open Sans", sans-serif !important; line-height: 1 !important; border-radius: 5px; z-index: 1111; }
		#infscr-loading img { width: auto !important; }
		.tax-room_category .pagination-ctrl, .tax-people_group .pagination-ctrl, .tax-project_category .pagination-ctrl, .tax-sponsor_category .pagination-ctrl { display: none !important; }
		@keyframes fallPerspective {
			100% { transform: translateZ(0px) translateY(0px) rotateX(0deg) !important; opacity: 1; transition: .9s opacity; }
		}
		@media only screen and (min-width:783px) {
			.responsi-navigation { box-sizing: border-box; }
			.navigation-in { clear: both; line-height: 0; background: none; }
			.navigation-in ul.menu { float: none; display: inline-block; }
			.navigation-in ul.menu > li { display: inline-block; }
			.navigation-in ul.menu li.menu-item-account a:before { top: -1px !important; vertical-align: top !important; }
			.navigation-in ul.responsi-menu > li a:hover { text-decoration: none; }
			.navigation-in ul.responsi-menu ul { left: 0; text-align: left; }
			.navigation-in ul.responsi-menu ul ul { top: -1px; left: 100%; }
			.navigation-in .nav li ul li.menu-item-has-children a { display: inline-block; }
			.navigation-in .nav li ul li.menu-item-has-children > a:after { content: ""; display: inline-block; background-color: transparent !important; border: 4px solid #fff; border-color: transparent transparent transparent #000; margin: 0px 0px 0px 7px !important; padding: 0; position: relative; right: 0 !important; top: 0px !important; width: 0px; height: 0; vertical-align: middle; }
			.navigation-in .nav li.menu-item-has-children > a:after { content: ""; display: inline-block; background-color: transparent !important; border: 4px solid #fff; border-color: #fff transparent transparent transparent; margin: 0 0 0 7px !important; padding: 0; position: relative; right: 0 !important; top: 2px !important; width: 0px; height: 0; vertical-align: middle; }
			.responsi-menu .menu-item-has-children > i, .responsi-menu .menu-item-has-children > svg { opacity: 0; }
			.responsi-menu .menu-item-has-children > i:before, .responsi-menu .menu-item-has-children > svg { vertical-align: middle; }
			.navigation-in ul.responsi-menu { position: relative; margin-bottom: 0; display: inline-block !important; }
			.navigation-in ul.responsi-menu li { position: relative; float: left; list-style: none; }
			.navigation-in ul.responsi-menu li a { display: block; }
			.navigation-in ul.responsi-menu li a:hover { text-decoration: none; }
			.navigation-in ul.responsi-menu ul { width: auto; visibility: hidden; position: absolute; top: 100%; left: 0; z-index: 9999; margin: 0; padding: 0; margin: 0; display: none; min-width: 100%; }
			.navigation-in ul.responsi-menu ul ul { width: 100%; left: 100%; top: 0; }
			.navigation-in ul.responsi-menu ul li { float: none; }
			.navigation-in ul.responsi-menu ul li a { width: 100%; display: inline-block; box-sizing: border-box; text-decoration: none; }
			.navigation-in ul.responsi-menu ul li.current-menu-item a { color: #5d88b3; }
			.sub-menu li a, .navigation-in .children li a { white-space: nowrap; }
			.sub-menu li ul { width: auto !important; }
			.responsi-menu .menu-item-has-children > i, .responsi-menu .menu-item-has-children > svg { display: none }
			.navigation-in ul.responsi-menu li:hover > ul { visibility: visible; display: block; }
			.site-width { margin: 0 auto; }
			.col-left { float: left; }
			.col-right { float: right; }
			.box-content .box-item.masonry-brick { float: none !important; margin-left: 0; margin-right: auto !important; }
			.header-ctn .header .widget { margin-bottom: 0 !important; }
			.header-ctn .header .box { margin-bottom: 0 !important; }
			.sidebar .sidebar-in { height: auto !important; position: relative !important; }
			.sidebar-alt .sidebar-in { height: auto !important; position: relative !important; }
			.sidebar { height: auto !important; }
			.sidebar .msr-wg { position: inherit !important; top: 0 !important; left: 0 !important; }
			.sidebar-alt { height: auto !important; }
			.sidebar-alt .msr-wg { position: inherit !important; top: 0 !important; left: 0 !important; }
			.content-ctn .sidebar { display: inline; margin-top: 0; margin-bottom: 0 !important; }
			.content-ctn .sidebar-alt { display: inline; margin-top: 0; margin-bottom: 0 !important; }
			.main { position: relative; }
			.footer-widgets.col-2 .footer-widget-2 { margin-right: 0; }
			.footer-widgets.col-3 .footer-widget-3 { margin-right: 0; }
			.footer-widgets.col-4 .footer-widget-4 { margin-right: 0; }
		}
		@media only screen and (max-width:782px) {
			.toolbar-ctn { position: relative; }
			.responsi-menu { display: none; }
			.responsi-frontend #responsi-wrapper:not(.site-width) .responsi-content { overflow-x: hidden; }
			.mobile-header-1 .header-widget-1 { display: none !important; }
			.mobile-header-2 .header-widget-2 { display: none !important; }
			.mobile-header-3 .header-widget-3 { display: none !important; }
			.mobile-header-4 .header-widget-4 { display: none !important; }
			.mobile-header-5 .header-widget-5 { display: none !important; }
			.mobile-header-6 .header-widget-6 { display: none !important; }
			.responsi-navigation { padding: 0 !important; padding-left: 0px !important; padding-right: 0px !important; padding-top: 0 !important; padding-bottom: 0 !important; border: none !important; margin: 0 !important; box-shadow: none !important; border-radius: 0 !important; }
			.navigation-in { padding-left: 0px !important; padding-right: 0px !important; padding-top: 0 !important; padding-bottom: 0 !important; border: none !important; margin: 0 !important; box-shadow: none !important; border-radius: 0 !important; }
			.responsi-menu .menu-item-has-children { position: relative; overflow-x: hidden; }
			.responsi-menu .menu-item-has-children > i, .responsi-menu .menu-item-has-children > svg { position: absolute !important; z-index: 9999 !important; cursor: pointer !important; right: auto; top: 0; width: auto; }
			.responsi-menu ul { display: none; box-sizing: border-box; overflow: hidden; }
			.responsi-menu li.menu-item-has-children:hover > ul { display: none; }
			.responsi-menu li.menu-item-has-children.open > ul { display: block; }
			.responsi-menu li.menu-item-has-children .item-arrow { position: relative; display: inline-block !important; width: 0 !important; height: 0 !important; left: 0 !important; right: 0 !important; }
			.responsi-menu li.menu-item-has-children i.fa-caret-down { top: 2px; text-align: left; }
			ul.responsi-menu li.menu-item-has-children a:after, ul.responsi-menu > li > ul > li.menu-item-has-children a:after { border-color: #ffffff transparent transparent !important; display: none; }
			ul.responsi-menu > li.menu-item-has-children:hover > a:after { opacity: 0.7 !important; }
			ul.responsi-menu > li.menu-item-has-children.current-menu-item:hover > a:after { opacity: 0.7 !important; }
			.navigation.clearfix { }
			ul.responsi-menu ul li { width: 100%; }
			ul.responsi-menu ul a { text-shadow: 0 0 0 #000 !important; }
			ul.responsi-menu { width: 100%; }
			ul.responsi-menu li { width: 100%; box-sizing: border-box; }
			ul.responsi-menu .menu-item-has-children > i, ul.responsi-menu .menu-item-has-children > svg { }
			ul.responsi-menu a { display: flex; }
			ul.responsi-menu ul li a { }
			ul.responsi-menu ul { }
			ul.responsi-menu > li.menu-item-has-children > a:after { border-color: #ffffff transparent transparent !important; display: none; }
			.navigation-mobile .hamburger-icon:hover { opacity: 0.7; }
			.navigation-mobile { display: block; box-sizing: border-box; width: auto; float: none; margin: 0; padding: 0; background: #000; border: 0px solid #000; border-radius: 0px; box-shadow: 0 0 0px 0px #dbdbdb; }
			.navigation-mobile i { height: auto; width: auto; display: inline-block; }
			.navigation-mobile span { position: relative; display: inline-block; }
			.responsi-frontend:not(.has-fontawesome) .responsi-menu .menu-item-has-children > i:before { font-family: "responsi-font-face" !important; content: "\b4"; top: -2px; position: relative; color: inherit !important; }
			.responsi-frontend:not(.has-fontawesome) .responsi-menu .menu-item-has-children.open > i:before { content: "\b2"; top: -1px; color: inherit !important; }
			.navigation-mobile .hamburger-icon:before { margin: 5px 5px 5px 5px; box-shadow: 0px 0 0 0 #cccccc !important; color: #ffffff; cursor: pointer; display: inline-block; font-size: 24px; height: auto; vertical-align: middle; width: auto; }
			.navigation-mobile span.separator { margin-right: 0px; padding-right: 0px; line-height: 0; top: 0; display: inline-block; line-height: 0; }
			.navigation-mobile.alignment-left .before { display: none; }
			.navigation-mobile.alignment-right .after { display: none; }
			.navigation-mobile.alignment-left span.separator { border-left: none; }
			.navigation-mobile.alignment-right span.separator { border-right: none; }
			.navigation-mobile span.menu-text { display: inline-block; font-size: 16px; line-height: normal; margin: 5px 5px 5px 8px; padding: 0; position: inherit; vertical-align: middle; top: 0; font-weight: bold; }
		}
		@media only screen and (min-width:480px) and (max-width:782px) {
			.main { width: 100% !important; }
		}
		@media only screen and (min-width:601px) {
			.footer .col-left { margin-bottom: 0; float: left; }
			.footer .col-right { margin-bottom: 0; text-align: right; float: right; }
		}
		@media only screen and (max-width:600px) {
			.footer .copyright { text-align: center; }
			.footer .credit { text-align: center; }
		}
		@media only screen and (max-width:480px) {
			.sidebar .sidebar-in, .sidebar-alt .sidebar-in { height: auto !important; position: relative !important; }
			.sidebar .msr-wg, .sidebar-alt .msr-wg { display: block; width: 100%; position: inherit !important; top: 0 !important; left: 0 !important; }
			.responsi-site .box-content .box-item { width: 100%; margin-left: 0 !important; margin-right: 0 !important; }
			.responsi-site .box-item .entry-item .thumb > a { height: auto !important; max-height: none !important; width: 100% !important; box-sizing: border-box; max-width: none !important; }
			.responsi-site .box-item .thumb > a img, .responsi-site .main .box-item .thumb > a img { height: auto !important; max-height: none !important; width: auto !important; box-sizing: border-box; max-width: 100% !important; }
			#infscr-loading { left: 0 !important; width: 100% !important; }
			.card-item .card-thumb { width: 100%; clear: both; display: inline-block; float: none; }
			.card-item .card-content { width: 100%; clear: both; float: none; }
		}
		@media screen and (min-width:480px) { }
		';

		wp_add_inline_style( 'responsi-framework', $layout_css );

		if ( is_customize_preview() ) {
			if( is_child_theme() ){
				wp_add_inline_style( 'responsi-theme', responsi_build_dynamic_css( true ) );
			}else{
				wp_add_inline_style( 'responsi-framework', responsi_build_dynamic_css( true ) );
			}
		} else {
			$framework_custom_css = get_theme_mod( 'framework_custom_css' );
			if ( false === $framework_custom_css ) {
				if( is_child_theme() ){
					wp_add_inline_style( 'responsi-theme', responsi_build_dynamic_css( true ) );
				}else{
					wp_add_inline_style( 'responsi-framework', responsi_build_dynamic_css( true ) );
				}
			}else{
				if( is_child_theme() ){
					wp_add_inline_style( 'responsi-theme', get_theme_mod( 'framework_custom_css' ) );
				}else{
					wp_add_inline_style( 'responsi-framework', get_theme_mod( 'framework_custom_css' ) );
				}
			}
		}
	}

	public function responsi_register_script( &$scripts ) {
		global $responsi_version, $google_fonts, $line_heights, $gFonts;

		$suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

		$system_fonts = array(
			'Arial, sans-serif'                                           => array( 'name' => 'Arial' ),
			'Verdana, Geneva, sans-serif'                                 => array( 'name' => 'Verdana' ),
			'Trebuchet MS, Tahoma, sans-serif'                            => array( 'name' => 'Trebuchet MS' ),
			'Georgia, serif'                                              => array( 'name' => 'Georgia' ),
			'Times New Roman, serif'                                      => array( 'name' => 'Times New Roman' ),
			'Tahoma, Geneva, Verdana, sans-serif'                         => array( 'name' => 'Tahoma' ),
			'Palatino, Palatino Linotype, serif'                          => array( 'name' => 'Palatino' ),
			'Helvetica Neue, Helvetica, sans-serif'                       => array( 'name' => 'Helvetica Neue' ),
			'Calibri, Candara, Segoe, Optima, sans-serif'                 => array( 'name' => 'Calibri' ),
			'Myriad Pro, Myriad, sans-serif'                              => array( 'name' => 'Myriad Pro' ),
			'Lucida Grande, Lucida Sans Unicode, Lucida Sans, sans-serif' => array( 'name' => 'Lucida Grande' ),
			'Arial Black, sans-serif'                                     => array( 'name' => 'Arial Black' ),
			'Gill Sans, Gill Sans MT, Calibri, sans-serif'                => array( 'name' => 'Gill Sans' ),
			'Geneva, Tahoma, Verdana, sans-serif'                         => array( 'name' => 'Geneva' ),
			'Impact, Charcoal, sans-serif'                                => array( 'name' => 'Impact' ),
			'Courier, Courier New, monospace'                             => array( 'name' => 'Courier, Courier New' ),
			'Century Gothic, sans-serif'                                  => array( 'name' => 'Century Gothic' ),
		);

		if( function_exists('responsi_google_webfonts') ) {
			responsi_google_webfonts();
		}

		$all_fonts = array_merge( $system_fonts, $google_fonts );

		$line_heights = array();
		for ( $i = 0.6; $i <= 3.1; $i += 0.1 ){
			$line_heights[] = trim( $i );
		}

		// Registry main responsi customize script
		$scripts->add( 'responsi-customize-function', 	get_template_directory_uri() . '/functions/theme-customizer/js/preview/function.preview' .$suffix . '.js', 	array( 'jquery', 'customize-preview', 'customize-selective-refresh' ), $responsi_version, true );

		// Registry script libs
		$scripts->add( 'jquery-ui-slider-rtl', 			get_template_directory_uri() . '/functions/js/jquery.ui.slider.rtl' .$suffix . '.js', 									array( 'jquery' ), $responsi_version, true );
		$scripts->add( 'jquery-ui-ioscheckbox', 		get_template_directory_uri() . '/functions/js/iphone-style-checkboxes' .$suffix . '.js', 								array( 'jquery' ), $responsi_version, true );
		$scripts->add( 'jquery-ui-ioscheckbox-rtl', 	get_template_directory_uri() . '/functions/js/iphone-style-checkboxes.rtl' .$suffix . '.js', 							array( 'jquery' ), $responsi_version, true );

		// Registry control scripts
		$scripts->add( 'responsi-customize-controls', 	get_template_directory_uri() . '/functions/theme-customizer/js/customize-controls' . $suffix . '.js', 					array( 'customize-controls' ), $responsi_version, true );

		// Registry Preview scripts for run inside a Customizer preview frame.
		$scripts->add( 'responsi-customize-header', 	get_template_directory_uri() . '/functions/theme-customizer/js/preview/header.preview' .$suffix . '.js', 		array( 'jquery', 'responsi-customize-function' ), $responsi_version, true );
		$scripts->add( 'responsi-customize-navigation', get_template_directory_uri() . '/functions/theme-customizer/js/preview/navigation.preview' .$suffix . '.js', 	array( 'jquery', 'responsi-customize-function' ), $responsi_version, true );
		$scripts->add( 'responsi-customize-layout', 	get_template_directory_uri() . '/functions/theme-customizer/js/preview/layout.preview' .$suffix . '.js', 		array( 'jquery', 'responsi-customize-function' ), $responsi_version, true );
		$scripts->add( 'responsi-customize-setting', 	get_template_directory_uri() . '/functions/theme-customizer/js/preview/setting.preview' .$suffix . '.js', 	array( 'jquery', 'responsi-customize-function' ), $responsi_version, true );
		$scripts->add( 'responsi-customize-widget', 	get_template_directory_uri() . '/functions/theme-customizer/js/preview/widget.preview' .$suffix . '.js', 		array( 'jquery', 'responsi-customize-function' ), $responsi_version, true );
		$scripts->add( 'responsi-customize-footer', 	get_template_directory_uri() . '/functions/theme-customizer/js/preview/footer.preview' .$suffix . '.js', 		array( 'jquery', 'responsi-customize-function' ), $responsi_version, true );
		$scripts->add( 'responsi-customize-post', 		get_template_directory_uri() . '/functions/theme-customizer/js/preview/post.preview' .$suffix . '.js', 		array( 'jquery', 'responsi-customize-function' ), $responsi_version, true );
		$scripts->add( 'responsi-customize-page', 		get_template_directory_uri() . '/functions/theme-customizer/js/preview/page.preview' .$suffix . '.js', 		array( 'jquery', 'responsi-customize-function' ), $responsi_version, true );
		$scripts->add( 'responsi-customize-blog', 		get_template_directory_uri() . '/functions/theme-customizer/js/preview/blog.preview' .$suffix . '.js', 		array( 'jquery', 'responsi-customize-function' ), $responsi_version, true );
		$scripts->add( 'responsi-customize-focus', 		get_template_directory_uri() . '/functions/theme-customizer/js/preview/shiftclick' .$suffix . '.js', 			array( 'jquery', 'responsi-customize-function' ), $responsi_version, true );
		
		if( is_array($gFonts) ){
			$fontsDefaultsParameters =  $gFonts;
		}else{
			$fontsDefaultsParameters = array();
		}
		did_action( 'init' ) && $scripts->localize( 'responsi-customize-function', 'fontsDefaults', $fontsDefaultsParameters );

		$backgrounds_list = array();
		$patterns_list    = array();
		if ( function_exists( 'get_backgrounds_img' ) ) {
			$backgrounds_list = get_backgrounds_img();
			$patterns_list    = get_backgrounds_img( 'patterns' );
		}
		$background_patterns_control_parameters = array(
			'backgrounds' => $backgrounds_list,
			'patterns'    => $patterns_list,
			'bg_url'      => defined( 'RESPONSI_BG_PICKER_URL' ) ? RESPONSI_BG_PICKER_URL : '',
		);
		did_action( 'init' ) && $scripts->localize( 'responsi-customize-controls', '_wpCustomBackgroundPatternsControl', $background_patterns_control_parameters );

		$iradio_control_parameters = array(
			'onoff' => array(
				'checked_label'   => __( 'ON', 'responsi' ),
				'unchecked_label' => __( 'OFF', 'responsi' ),
				'container_width' => 80,
			),
		);
		did_action( 'init' ) && $scripts->localize( 'responsi-customize-controls', '_wpCustomIRadioControl', $iradio_control_parameters );

		$imulticheckbox_control_parameters = array(
			'onoff' => array(
				'checked_label'   => __( 'ON', 'responsi' ),
				'unchecked_label' => __( 'OFF', 'responsi' ),
				'checked_value'   => 'true',
				'unchecked_value' => 'false',
				'container_width' => 80,
			),
		);
		did_action( 'init' ) && $scripts->localize( 'responsi-customize-controls', '_wpCustomIMultiCheckboxControl', $imulticheckbox_control_parameters );

		$border_radius_control_parameters = array(
			'rounded' => array(
				'min' => 0,
				'max' => 100,
				'step'=> 1,
			),
			'corner' => array(
				'checked_value'   => 'rounded',
				'unchecked_value' => 'square',
				'checked_label'   => __( 'ROUNDED', 'responsi' ),
				'unchecked_label' => __( 'SQUARE', 'responsi' ),
				'container_width' => 120,
			)
		);
		did_action( 'init' ) && $scripts->localize( 'responsi-customize-controls', '_wpCustomBorderRadiusControl', $border_radius_control_parameters );

		$box_shadow_control_parameters = array(
			'size' => array(
				'min' => -20,
				'max' => 20,
			),
			'onoff' => array(
				'checked_value'   => 'true',
				'unchecked_value' => 'false',
				'checked_label'   => __( 'ON', 'responsi' ),
				'unchecked_label' => __( 'OFF', 'responsi' ),
				'container_width' => 80,
			),
			'inset' => array(
				'checked_value'   => 'inset',
				'unchecked_value' => 'outset',
				'checked_label'   => __( 'INNER', 'responsi' ),
				'unchecked_label' => __( 'OUTER', 'responsi' ),
				'container_width' => 100,
			)
		);
		did_action( 'init' ) && $scripts->localize( 'responsi-customize-controls', '_wpCustomBoxShadowControl', $box_shadow_control_parameters );

		$ibackground_control_parameters = array(
			'onoff' => array(
				'checked_value'   => 'true',
				'unchecked_value' => 'false',
				'checked_label'   => __( 'ON', 'responsi' ),
				'unchecked_label' => __( 'OFF', 'responsi' ),
				'container_width' => 80,
			)
		);
		did_action( 'init' ) && $scripts->localize( 'responsi-customize-controls', '_wpCustomiBackgroundControl', $ibackground_control_parameters );

		$typography_control_parameters = array(
			'size' => array(
				'min' => 9,
				'max' => 71,
			),
			'line_heights' => $line_heights,
			'fonts' => $all_fonts,
			'styles' => array(
				'100'         => __( '100', 'responsi' ),
				'200'         => __( '200', 'responsi' ),
				'300'         => __( '300', 'responsi' ),
				'400'         => __( '400', 'responsi' ),
				'500'         => __( '500', 'responsi' ),
				'600'         => __( '600', 'responsi' ),
				'700'         => __( '700', 'responsi' ),
				'800'         => __( '800', 'responsi' ),
				'900'         => __( '900', 'responsi' ),
				'normal'      => __( 'Deafult', 'responsi' ),
				'300 normal'  => __( 'Thin', 'responsi' ),
				'300 italic'  => __( 'Thin/Italic', 'responsi' ),
				'italic'      => __( 'Italic', 'responsi' ),
				'bold'        => __( 'Bold', 'responsi' ),
				'bold italic' => __( 'Bold/Italic', 'responsi' ),
			),
		);
		did_action( 'init' ) && $scripts->localize( 'responsi-customize-controls', '_wpCustomTypographyControl', $typography_control_parameters );

		$border_control_parameters = array(
			'width' => array(
				'min' => 0,
				'max' => 20,
			),
			'styles' => array(
				'solid' 	=> __( 'Solid', 'responsi' ),
				'dashed' 	=> __( 'Dashed', 'responsi' ),
				'dotted' 	=> __( 'Dotted', 'responsi' ),
				'double' 	=> __( 'Double', 'responsi' ),
				'groove' 	=> __( 'Groove', 'responsi' ),
				'ridge' 	=> __( 'Ridge', 'responsi' ) ,
				'inset' 	=> __( 'Inset', 'responsi' ) ,
				'outset' 	=> __( 'Outset', 'responsi' )
			),
		);
		did_action( 'init' ) && $scripts->localize( 'responsi-customize-controls', '_wpCustomBorderControl', $border_control_parameters );

		$border_boxes_control_parameters = array(
			'width' => array(
				'min' => 0,
				'max' => 20,
			),
			'styles' => array(
				'solid' 	=> __( 'Solid', 'responsi' ),
				'dashed' 	=> __( 'Dashed', 'responsi' ),
				'dotted' 	=> __( 'Dotted', 'responsi' ),
				'double' 	=> __( 'Double', 'responsi' ),
				'groove' 	=> __( 'Groove', 'responsi' ),
				'ridge' 	=> __( 'Ridge', 'responsi' ) ,
				'inset' 	=> __( 'Inset', 'responsi' ) ,
				'outset' 	=> __( 'Outset', 'responsi' )
			),
			'rounded' => array(
				'min' => 0,
				'max' => 100,
				'step'=> 1,
			),
			'corner' => array(
				'checked_value'   => 'rounded',
				'unchecked_value' => 'square',
				'checked_label'   => __( 'ROUNDED', 'responsi' ),
				'unchecked_label' => __( 'SQUARE', 'responsi' ),
				'container_width' => 120,
			)
		);
		did_action( 'init' ) && $scripts->localize( 'responsi-customize-controls', '_wpCustomBorderBoxesControl', $border_boxes_control_parameters );

		$animation_control_parameters = array(

			'type' => array(
				'none'   		=> __( 'None', 'responsi' ),
				'flash'   		=> __( 'Flash', 'responsi' ),
				'pulse'   		=> __( 'Pulse', 'responsi' ),
				'rubberBand'   	=> __( 'Rubber Band', 'responsi' ),
				'shake'  		=> __( 'Shake', 'responsi' ),
				'swing'   		=> __( 'Swing', 'responsi' ),
				'tada'   		=> __( 'Tada', 'responsi' ),
				'wobble'   		=> __( 'Wobble', 'responsi' ),
				'jello'   		=> __( 'Jello', 'responsi' ),
				'heartBeat'   	=> __( 'Heart Beat', 'responsi' ),
				'hinge'   		=> __( 'Hinge', 'responsi' ),
				'jackInTheBox'  => __( 'Jack In The Box', 'responsi' ),
				'rollIn'   		=> __( 'Roll', 'responsi' ),
				'lightSpeedIn'  => __( 'Light Speed', 'responsi' ),
				'flip'   		=> __( 'Flip', 'responsi' ),
				'flipInX'   	=> __( 'Flip X', 'responsi' ),
				'flipInY'   	=> __( 'Flip Y', 'responsi' ),
				'rotateIn'   	=> __( 'Rotate', 'responsi' ),
				'bounce'   		=> __( 'Bounce', 'responsi' ),
				'fade'   		=> __( 'Fade', 'responsi' ),
				'slide'   		=> __( 'Slide', 'responsi' ),
				'zoom'   		=> __( 'Zoom', 'responsi' ),
			),
			'direction' => array(
				'left'   		=> __( 'Left', 'responsi' ),
				'right'   		=> __( 'Right', 'responsi' ),
				''   			=> __( 'Center', 'responsi' ),
				'up'   		=> __( 'Top', 'responsi' ),
				'down'   		=> __( 'Bottom', 'responsi' ),
			),
			'duration' => array(
				'min' => 1,
				'max' => 5,
				'step'=> 1,
			),
			'delay' => array(
				'min' => 0,
				'max' => 5,
				'step'=> 1,
			)
		);
		did_action( 'init' ) && $scripts->localize( 'responsi-customize-controls', '_wpCustomAnimationControl', $animation_control_parameters );

		$_panelIds = apply_filters( 'responsi_focus_panels', array( array( 'selector' => '', 'settings' => '' )) ) ;
		did_action( 'init' ) && $scripts->localize( 'responsi-customize-focus', '_panelIds', $_panelIds );
		
		$_sectionIds = apply_filters( 'responsi_focus_sections', array( array( 'selector' => '', 'settings' => '' ) ) );
		did_action( 'init' ) && $scripts->localize( 'responsi-customize-focus', '_sectionIds', $_sectionIds );
		
		$_controlIds = apply_filters( 'responsi_focus_controls', array( array( 'selector' => '', 'settings' => '' ) ) );
		did_action( 'init' ) && $scripts->localize( 'responsi-customize-focus', '_controlIds', $_controlIds );

	}

	public function responsi_customize_preview_init(){
		wp_enqueue_script( 'responsi-customize-function' );
		wp_enqueue_script( 'responsi-customize-focus' );
	}

	public function responsi_customize_controls_print_styles() {
		global $wp_version, $responsi_version;
		$suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
		$rtl = is_rtl() ? '.rtl' : '';
		
		if ( version_compare( $wp_version, '5.2.4', '<=' ) ) {
	        wp_enqueue_style( 'responsi-customize', get_template_directory_uri() . '/functions/theme-customizer/css/customize-old' . $rtl .$suffix . '.css', array(), $responsi_version, 'screen' );
	    }else{
	    	wp_enqueue_style( 'responsi-customize', get_template_directory_uri() . '/functions/theme-customizer/css/customize' . $rtl .$suffix . '.css', array(), $responsi_version, 'screen' );
	    }
	}

	public function responsi_customize_controls_print_footer_scripts() {
		if ( is_rtl() ){
			wp_enqueue_script( 'jquery-ui-slider-rtl' );
			wp_enqueue_script( 'jquery-ui-ioscheckbox-rtl' );
		} else {
			wp_enqueue_script( 'jquery-ui-slider' );
			wp_enqueue_script( 'jquery-ui-ioscheckbox' );
		}
		wp_enqueue_script( 'responsi-customize-controls' );
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_style( 'wp-color-picker' );
	}

	public function responsi_custom_control_settings( $id, $type, $options = array() ) {
        $settings = array();
        if( '' !== $id && '' !== $type ){
            switch ( $type ) {
                case "ibackground":
                    $settings = array( $id.'[onoff]' => $id.'[onoff]', $id.'[color]' => $id.'[color]');
                    break;
                case "border":
                    $settings = array( $id.'[width]' => $id.'[width]', $id.'[style]' => $id.'[style]', $id.'[color]' => $id.'[color]' );
                    break;
                case "border_radius":
                    $settings = array( $id.'[corner]' => $id.'[corner]', $id.'[rounded_value]' => $id.'[rounded_value]');
                    break;
                case "box_shadow":
                    $settings = array( $id.'[onoff]' => $id.'[onoff]', $id.'[h_shadow]' => $id.'[h_shadow]', $id.'[v_shadow]' => $id.'[v_shadow]', $id.'[blur]' => $id.'[blur]', $id.'[spread]' => $id.'[spread]', $id.'[color]' => $id.'[color]', $id.'[inset]' => $id.'[inset]');
                    break;
                case "border_boxes":
                    $settings = array( $id.'[width]' => $id.'[width]', $id.'[style]' => $id.'[style]', $id.'[color]' => $id.'[color]', $id.'[corner]' => $id.'[corner]', $id.'[topleft]' => $id.'[topleft]', $id.'[topright]' => $id.'[topright]', $id.'[bottomright]' => $id.'[bottomright]', $id.'[bottomleft]' => $id.'[bottomleft]' );
                    break;
                case "typography":
                    $settings = array( $id.'[size]' => $id.'[size]', $id.'[line_height]' => $id.'[line_height]', $id.'[face]' => $id.'[face]', $id.'[style]' => $id.'[style]', $id.'[color]' => $id.'[color]');
                    break;
                case "animation":
                    $settings = array( $id.'[type]' => $id.'[type]', $id.'[direction]' => $id.'[direction]', $id.'[duration]' => $id.'[duration]', $id.'[delay]' => $id.'[delay]');
                    break;
                case "column":
                	$custom_settings = array( $id.'[col]' => $id.'[col]' );
                	if( isset( $options['choices']) && is_array($options['choices']) && count($options['choices']) > 0 ){
                		$i = 0;
                		foreach ($options['choices'] as $k => $val) {
                			$i++;
                			$custom_settings[$id.'[col'.$i.']'] = $id.'[col'.$i.']';
                		}
                	}

                    $settings = $custom_settings;
                    break;
                case "multitext":
                    foreach ( $options['choices'] as $key => $value) {
                        $settings[$id.'_'.$key] = $id.'_'.$key;
                    }
                    break;
                case "imulticheckbox":
                    foreach ( $options['choices'] as $key => $value) {
                        $settings[$id.'_'.$key] = $id.'_'.$key;
                    }
                    break;
                default:
                    $settings = array( $id.'[width]' => $id.'[width]', $id.'[style]' => $id.'[style]', $id.'[color]' => $id.'[color]' );
                    break;
            }
        }
        return $settings;
    }

	public function responsi_focus_controls( $_controlIds ) {

		$focusControl =  array();

		$controlIds = apply_filters( 'responsi_focus_controls_selector', $focusControl );

		if( is_array ($controlIds) && count($controlIds) > 0 ){
			foreach( $controlIds as $settings => $selector ){
				$_controlIds[] = array(
					'selector' => $selector,
			        'settings' => $settings,
				);
			}
		}

		return $_controlIds;
	}

	public function responsi_focus_sections( $_sectionIds ) {

		$focusSection =  array( 
			'sidebar-widgets-primary' => '.sidebar .widget-blank',
			'sidebar-widgets-secondary' => '.sidebar-alt .widget-blank',
			'header_style' => '.responsi-header > .shiftclick',
			'header_widgets' => '.responsi-header .responsi-shiftclick > .shiftclick',
			'navigation_primary' => '.responsi-navigation > .shiftclick',
			'footer_widget' => '.responsi-footer-widgets > .shiftclick',
			'footer_widget_content' => '.footer-widgets-ctn > .shiftclick',
			'footer_widget_style' => '.footer-widgets .responsi-shiftclick > .shiftclick',
			'footer_style' => '.responsi-footer > .shiftclick',
			'footer_content_style' => '.footer > .shiftclick',
			'content_body_style' => '.content-in > .shiftclick',
		);

		for( $i = 1 ; $i <= 6 ; $i ++ ){
			$focusSection['sidebar-widgets-footer-'.$i] = '.footer-widget-'.$i.' .widget-blank';
		}

		for( $i = 2 ; $i <= 6 ; $i ++ ){
			$focusSection['sidebar-widgets-header-'.$i] = '.header-widget-'.$i.' .widget-blank';
		}

		$sectionIds = apply_filters( 'responsi_focus_sections_selector', $focusSection );

		if( is_array ($sectionIds) && count($sectionIds) > 0 ){
			foreach( $sectionIds as $settings => $selector ){
				$_sectionIds[] = array(
					'selector' => $selector,
			        'settings' => $settings,
				);
			}
		}

		return $_sectionIds;

	}

	public function responsi_focus_panels( $_panelIds ) {

		$focusPanel =  array();

		$focusPanel =  array( 
			'sidebar_widget_settings_panel' => '.sidebar-ctn.clearfix > .shiftclick',
			'pages_panel' => '.main-page.clearfix > .shiftclick, .main-archive.clearfix > .shiftclick',
			'blogs_settings_panel' => '.card-item > .shiftclick',
			'posts_settings_panel' => '.main-post.clearfix > .shiftclick',
		);

		$panelIds = apply_filters( 'responsi_focus_panels_selector', $focusPanel );

		if( is_array ($panelIds) && count($panelIds) > 0 ){
			foreach( $panelIds as $settings => $selector ){
				$_panelIds[] = array(
					'selector' => $selector,
			        'settings' => $settings,
				);
			}
		}

		return $_panelIds;

	}

	public function responsi_customized_post_value( $post_value ){
		$new_post_value = array();
		if( is_array($post_value) && count( $post_value ) > 0 ){
			foreach( $post_value as $key => $value ){
				if(!is_array($key)){
					$keys = preg_split( '/\[/', str_replace( ']', '', $key ) );
					if( is_array($keys) && count($keys) > 0 && isset($keys[0]) && isset($keys[1]) ){
						$k = str_replace( get_stylesheet().'::', '', $keys[0]);
						$new_post_value[$k][$keys[1]] = $value;
						unset($post_value[$key]);
					}
				}
			}
			$post_value = array_merge( $post_value, $new_post_value );
		}
		return $post_value;
	}

	public function responsi_customized_changeset_data_value( $changeset_data ){
		$new_post_value = array();
		if( is_array( $changeset_data ) && count( $changeset_data ) > 0 ){
			foreach ( $changeset_data as $key => $value ){
				if(!is_array($key)){
					$keys = preg_split( '/\[/', str_replace( ']', '', $key ) );
					if( is_array($keys) && count($keys) > 0 && isset($keys[0]) && isset($keys[1]) ){
						$k = str_replace( get_stylesheet().'::', '', $keys[0]);
						$new_post_value[$k][$keys[1]] = $value['value'];
					}else{
						$k = str_replace( get_stylesheet().'::', '', $keys[0]);
						$new_post_value[$k] = $value['value'];
					}
				}			
			}

			$changeset_data = $new_post_value;

		}
		return $changeset_data;
	}

	public function responsi_add_filter_default_settings_options(){
		return true;
	}

	public function responsi_customize_save_options( $settings ) {
		global $responsi_options;
		$post_value = array();
		if( isset($_POST['customized']) ){
			$post_value = json_decode( wp_unslash( $_POST['customized'] ), true );
			$post_value = apply_filters( 'responsi_customized_post_value', $post_value );
		}else{
			$post_value = $settings->changeset_data();
			$post_value = apply_filters( 'responsi_customized_changeset_data_value', $post_value );
		}

		if( is_array( $responsi_options ) && count( $responsi_options ) > 0 && is_array( $post_value ) && count( $post_value ) > 0 ){

			add_filter( 'default_settings_options', array( $this, 'responsi_add_filter_default_settings_options' ) );
			
			$_default_options = responsi_default_options();

			if ( function_exists('default_option_child_theme') ){
				$_default_options = array_replace_recursive( $_default_options, default_option_child_theme() );
			}

			$theme_mods = get_theme_mods();

			$build_dynamic_css = false;
			foreach( $post_value as $key=>$value ){
				if( array_key_exists( $key, $_default_options )){
					$build_dynamic_css = true;
				}
			}

			$_customize_options = array_replace_recursive( $theme_mods, $post_value );
			if( is_array( $_customize_options ) ){
				foreach( $_customize_options as $key => $value ){
					if( array_key_exists( $key, $_default_options )){
						if( is_array( $value ) && is_array( $_default_options[$key] ) ){
							$new_opt = array_diff_assoc( $value, $_default_options[$key] );
							if( is_array( $new_opt ) && count( $new_opt ) > 0 ){
								set_theme_mod( $key,  $new_opt );
							}else{
								remove_theme_mod( $key );
							}
						}else{
							if( !is_array( $value ) && !is_array($_default_options[$key]) && $value == $_default_options[$key] ){
								remove_theme_mod( $key );
							}
						}
					}
				}
			}

			if ( $this->manager && !$this->manager->is_theme_active()){
				$build_dynamic_css = true;
			}

			if( function_exists('responsi_dynamic_css') && $build_dynamic_css ){
				responsi_dynamic_css( 'framework' );
				do_action('responsi_build_dynamic_css_success', $post_value );
				return;
			}
		}
		responsi_dynamic_css( 'framework' );
	}

}
?>
