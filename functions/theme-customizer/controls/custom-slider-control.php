<?php
/**
 * Class to create a Custom Slider control
 */
if ( ! class_exists( 'Customize_Slider_Control' ) && class_exists('WP_Customize_Control')) {
	class Customize_Slider_Control extends WP_Customize_Control {

		public $type = 'slider';

		/**
		 * Constructor.
		 *
		 * @since 3.4.0
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
		 * Enqueue scripts/styles for the color picker.
		 *
		 * @since 3.4.0
		 */
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
			$this->json['setting_id'] = $this->id;
			$this->json['value']      = $this->setting->default;
			$this->json['min']        = $this->input_attrs['min'];
			$this->json['max']        = $this->input_attrs['max'];
			$this->json['step']       = $this->input_attrs['step'];
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
			<# var setting_id = data.setting_id; #>
			<div class="customize-control-container">
				<# if ( data.label ) { #>
				<span class="customize-control-title customize-slider-title">{{{ data.label }}}</span>
				<# } #>
				<div class="responsi-range-slider">
					<div class="ui-slide" id="{{ setting_id }}_div"></div>
					<input type="text" readonly="readonly" data-customize-setting-link="{{ setting_id }}" id="{{ setting_id }}" name="{{ setting_id }}" value="{{ data.value }}" class="responsi-input regular-text responsi-slide-value" />
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
