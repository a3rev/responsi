<?php
/**
 * Class to create a custom iColor control
 */
if ( ! class_exists( 'Customize_iColor_Control' ) && class_exists('WP_Customize_Color_Control')) {
	class Customize_iColor_Control extends WP_Customize_Color_Control {
		public $type = 'icolor';

		public $notifications = array();

		public function to_json() {
			parent::to_json();
			$this->json['notifications'] = $this->notifications;
		}

		public function enqueue() {
			wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'responsi-customize-controls' );
		}

		/**
		 * Refresh the parameters passed to the JavaScript via JSON.
		 *
		 * @since 3.4.0
		 * @uses WP_Customize_Control::to_json()
		 */


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
			<# var defaultValue = '#RRGGBB',defaultValueAttr = '',isHueSlider = data.mode === 'hue';
			if (data.defaultValue && _.isString( data.defaultValue ) && ! isHueSlider){
				if ( '#' !== data.defaultValue.substring( 0, 1 ) ) {defaultValue = '#' + data.defaultValue;}else{defaultValue = data.defaultValue;}
				defaultValueAttr = ' data-default-color=' + defaultValue;
			} #>
			<div class="customize-control-container">
				<# if(data.label){ #><span class="customize-control-title">{{{ data.label }}}</span><# } #>
				<div class="customize-control-content icolor-container">
					<label><span class="screen-reader-text">{{{ data.label }}}</span>
					<# if(isHueSlider){ #><input class="color-picker-hue icolor-picker-hue" type="text" data-type="hue" />
					<# }else{ #><input class="color-picker-hex icolor-picker" type="text" maxlength="7" placeholder="{{ defaultValue }}" {{ defaultValueAttr }} /><# } #>
					</label>
				</div>
				<# if( data.description ){ #><span class="customize-control-description">{{{ data.description }}}</span><# } #>
			</div>
			<?php
		}
	}
}
?>
