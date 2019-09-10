<?php
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

final class Responsi_Customize {

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
		if ( $id instanceof WP_Customize_Control ) {
			$control = $id;
		} else {
			$control = new WP_Customize_Control( $this, $id, $args );
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
		$this->manager->register_control_type( 'Customize_iLabel_Control' );
		$this->manager->register_control_type( 'Customize_iText_Control' );
		$this->manager->register_control_type( 'Customize_iTextarea_Control' );
		$this->manager->register_control_type( 'Customize_iSelect_Control' );
		$this->manager->register_control_type( 'Customize_Layout_Control' );
		$this->manager->register_control_type( 'Customize_Background_Patterns_Control' );
		$this->manager->register_control_type( 'Customize_Slider_Control' );
		$this->manager->register_control_type( 'Customize_iCheckbox_Control' );
		$this->manager->register_control_type( 'Customize_iMultiCheckbox_Control' );
		$this->manager->register_control_type( 'Customize_iSwitcher_Control' );
		$this->manager->register_control_type( 'Customize_iRadio_Control' );
		$this->manager->register_control_type( 'Customize_iColor_Control' );
		$this->manager->register_control_type( 'Customize_iUpload_Control' );
		$this->manager->register_control_type( 'Customize_iUploadCrop_Control' );
		$this->manager->register_control_type( 'Customize_Multiple_Text_Control' );
		$this->manager->register_control_type( 'Customize_Typography_Control' );
		$this->manager->register_control_type( 'Customize_iBackground_Control' );
		$this->manager->register_control_type( 'Customize_Border_Control' );
		$this->manager->register_control_type( 'Customize_Border_Radius_Control' );
		$this->manager->register_control_type( 'Customize_Border_Boxes_Control' );
		$this->manager->register_control_type( 'Customize_Box_Shadow_Control' );
		$this->manager->register_control_type( 'Customize_iEditor_Control' );
		$this->manager->register_control_type( 'Customize_Animation_Control' );
		$this->manager->register_control_type( 'Customize_Column_Control' );

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
							$this->add_control( new Customize_iRadio_Control( $this->manager, $key, $value['control']) );
					        break;
						case "icheckbox":
							$this->add_control( new Customize_iCheckbox_Control( $this->manager, $key, $value['control']) );
					        break;
					    case "imulticheckbox":
					    	$this->add_control( new Customize_iMultiCheckbox_Control( $this->manager, $key, $value['control']) );
					        break;
						case "iswitcher":
							$this->add_control( new Customize_iSwitcher_Control( $this->manager, $key, $value['control']) );
					        break;
					    case "slider":
					    	$this->add_control( new Customize_Slider_Control( $this->manager, $key, $value['control']) );
					        break;
					    case "layout":
					    	$this->add_control( new Customize_Layout_Control( $this->manager, $key, $value['control']) );
					        break;
					    case "ibackground":
					    	$this->add_control( new Customize_iBackground_Control( $this->manager, $key, $value['control']) );
					        break;
					    case "border":
					    	$this->add_control( new Customize_Border_Control( $this->manager, $key, $value['control']) );
					        break;
					    case "border_radius":
					    	$this->add_control( new Customize_Border_Radius_Control( $this->manager, $key, $value['control']) );
					        break;
					    case "border_boxes":
					    	$this->add_control( new Customize_Border_Boxes_Control( $this->manager, $key, $value['control']) );
					        break;
					    case "box_shadow":
					    	$this->add_control( new Customize_Box_Shadow_Control( $this->manager, $key, $value['control']) );
					        break;
					    case "typography":
					    	$this->add_control( new Customize_Typography_Control( $this->manager, $key, $value['control']) );
					        break;
					    case "animation":
		                    $this->add_control( new Customize_Animation_Control( $this->manager, $key, $value['control']) );
		                    break;
		                case "column":
		                    $this->add_control( new Customize_Column_Control( $this->manager, $key, $value['control']) );
		                    break;
					    case "multitext":
					    	$this->add_control( new Customize_Multiple_Text_Control( $this->manager, $key, $value['control']) );
					        break;
					    case "icolor":
					    	$this->add_control( new Customize_iColor_Control( $this->manager, $key, $value['control']) );
					        break;
					    case "iupload":
					    	$this->add_control( new Customize_iUpload_Control( $this->manager, $key, $value['control']) );
					    	break;
					    case "iuploadcrop":
					    	$this->add_control( new Customize_iUploadCrop_Control( $this->manager, $key, $value['control']) );
					    	break;
					    case "background_patterns":
					    	$this->add_control( new Customize_Background_Patterns_Control( $this->manager, $key, $value['control']) );
					        break;
					    case "itext":
					    	$this->add_control( new Customize_iText_Control( $this->manager, $key, $value['control']) );
					        break;
					    case "itextarea":
					    	$this->add_control( new Customize_iTextarea_Control( $this->manager, $key, $value['control']) );
					        break;
					    case "ieditor":
					    	$this->add_control( new Customize_iEditor_Control( $this->manager, $key, $value['control']) );
					        break;
					    case "iselect":
					    	$this->add_control( new Customize_iSelect_Control( $this->manager, $key, $value['control']) );
					        break;
					    case "ilabel":
					    	$this->add_control( new Customize_iLabel_Control( $this->manager, $key, $value['control']) );
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
				'300'         => __( 'Thin', 'responsi' ),
				'300 italic'  => __( 'Thin/Italic', 'responsi' ),
				'normal'      => __( 'Normal', 'responsi' ),
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
		global $responsi_version;
		$suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
		$rtl = is_rtl() ? '.rtl' : '';
		wp_enqueue_style( 'responsi-customize', get_template_directory_uri() . '/functions/theme-customizer/css/customize' . $rtl .$suffix . '.css', array(), $responsi_version, 'screen' );
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

new Responsi_Customize();

