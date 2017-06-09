<?php
/**
 * Class to create a custom iColor control
 */
if ( ! class_exists( 'Customize_iColor_Control' ) && class_exists('WP_Customize_Color_Control')) {
	class Customize_iColor_Control extends WP_Customize_Color_Control {
		public $type = 'icolor';

		public function enqueue() {
			wp_enqueue_script( 'responsi-customize-controls' );
		}

		/**
		 * Refresh the parameters passed to the JavaScript via JSON.
		 *
		 * @since 3.4.0
		 * @uses WP_Customize_Control::to_json()
		 */
		public function to_json() {
			parent::to_json();
			$this->json['defaultValue'] = $this->setting->default;
		}

		protected function render() {
			$custom_class = '';
			if( isset( $this->input_attrs['class']) && $this->input_attrs['class'] ){
				$custom_class = ' '.$this->input_attrs['class'];
			}

			$id    = 'customize-control-' . str_replace( '[', '-', str_replace( ']', '', $this->id ) );
			$class = 'customize-control responsi-customize-control customize-control-' . $this->type;

			$class .= $custom_class;

			?><li id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $class ); ?>">
				<?php $this->render_content(); ?>
			</li><?php
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
			<div class="customize-control-container">
				<# if ( data.label ) { #>
				<span class="customize-control-title customize-icolor-title">{{{ data.label }}}</span>
				<# } #>
				<div class="icolor-container">
					<input class="color-picker-hex responsi-color-picker responsi-icolor responsi-icolor-color" type="text" value="{{ data.defaultValue }}" data-default-color="{{ data.defaultValue }}" />
				</div>
				<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
				<# } #>
			</div>
			<?php
		}
	}
}
?>
