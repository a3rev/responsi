<?php
/**
 * Class to create a custom Typography control
 */
if ( ! class_exists( 'Customize_Typography_Control' ) && class_exists('WP_Customize_Control')) {
	class Customize_Typography_Control extends WP_Customize_Control {

		public $type = 'typography';

		public $notifications = array();

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 * @uses WP_Customize_Control::__construct()
		 *
		 * @param WP_Customize_Manager $manager Customizer bootstrap instance.
		 * @param string               $id      Control ID.
		 * @param array                $args    Optional. Arguments to override class property defaults.
		 */
		public function __construct( $manager, $id, $args = array() ) {
			parent::__construct( $manager, $id, $args );
		}

		/**
		 * Enqueue scripts/styles.
		 *
		 * @since 1.0.0
		 */
		public function enqueue() {
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'responsi-customize-controls' );
		}

		/**
		 * Refresh the parameters passed to the JavaScript via JSON.
		 *
		 * @since 1.0.0
		 * @uses WP_Customize_Control::to_json()
		 */
		public function to_json() {
			parent::to_json();

			$custom_class = '';
			if( isset( $this->input_attrs['class']) && $this->input_attrs['class'] ){
				$custom_class = $this->input_attrs['class'];
			}

			$values = array();
			foreach( $this->settings as $key => $setting ) {
				$key = str_replace( array( $this->id, '[', ']' ), '', $key );
				if ( isset($setting->default) && is_array($setting->default) && isset($setting->default[$key]) ) {
					$values[$key] = $setting->default[$key];
				} else {
					$values[$key] = $setting->value();
				}
			}

			$this->json['setting_id']   = $this->id;
			$this->json['values']       = $values;
			$this->json['custom_class'] = $custom_class;
			$this->json['notifications'] = $this->notifications;
		}

		protected function render() {
			
			$custom_class = '';
			if( isset( $this->input_attrs['class']) && $this->input_attrs['class'] ){
				$custom_class = ' '.$this->input_attrs['class'];
			}

			$id    = 'customize-control-' . str_replace( '[', '-', str_replace( ']', '', $this->id ) );
			$class = 'customize-control customize-control-' . $this->type;

			$class .= $custom_class;

			printf( '<li id="%s" class="%s">', esc_attr( $id ), esc_attr( $class ) );
			$this->render_content();
			echo '</li>';
		}

		/**
		 * Don't render the control content from PHP, as it's rendered via JS on load.
		 *
		 * @since 3.4.0
		 */
		public function render_content() {}

		/**
		 * Render a JS template for the content of the color picker control.
		 *
		 * @since 4.1.0
		 */
		public function content_template() {
			?>
			<# if( 'undefined' === typeof data.values ){ data.values = {'size':'14' , 'line_height':'1.4' , 'face':'Open Sans', 'style':'normal' , 'color':'#555555'}; }
			var setting_id = data.setting_id,defaultValue = '#RRGGBB',defaultValueAttr = '',isHueSlider = data.mode === 'hue';
			if( data.values.color && _.isString( data.values.color ) && ! isHueSlider ){
				if ( '#' !== data.values.color.substring( 0, 1 ) ) {defaultValue = '#' + data.values.color;}else{defaultValue = data.values.color;}
				defaultValueAttr = ' data-default-color=' + defaultValue;
			} #>
			<div class="customize-ctrl {{ data.custom_class }}">
				<# if(data.label){ #><span class="customize-control-title">{{{ data.label }}}</span><# } #>
				<div class="typography-container">
					<select name="{{ setting_id }}[size]" class="responsi-typography responsi-typography-size"></select>
					<select name="{{ setting_id }}[line_height]" class="responsi-typography responsi-typography-line-height"></select>
					<select name="{{ setting_id }}[face]" class="responsi-typography responsi-typography-face"></select>
					<select name="{{ setting_id }}[style]" class="responsi-typography responsi-typography-style"></select>
					<input class="color-picker-hex icolor-picker" type="text" maxlength="7" placeholder="{{ defaultValue }}" {{ defaultValueAttr }} />
				</div>
				<# if( data.description ){ #><span class="customize-control-description">{{{ data.description }}}</span><# } #>
			</div>
			<?php
		}
	}
}
?>
