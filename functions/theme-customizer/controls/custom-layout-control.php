<?php
/**
 * Class to create a custom Layout control
 */
if ( ! class_exists( 'Customize_Layout_Control' ) && class_exists('WP_Customize_Control')) {
	class Customize_Layout_Control extends WP_Customize_Control {

		public $type = 'layout';

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
			$this->json['value']   = $this->setting->default;
			$this->json['choices'] = $this->choices;
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
			<# 
				var setting_id = data.settings['default']; 
				var choices    = data.choices;
			#>
			<div class="customize-control-container">
				<# if ( data.label ) { #>
				<span class="customize-control-title customize-layout-title">{{{ data.label }}}</span>
				<# } #>
				<# 
				var checked = '';
				var selected = '';
				var i = 0;
				_.each(choices, function(  val, key ){
					i++;
					checked = '';
					selected = '';
					if ( data.value == key ) {
						checked = 'checked="checked"';
						selected = 'responsi-radio-img-selected';
					}
					#>
					<span class="layout-item layout-item-{{ i }}">
					<input data-customize-setting-link="{{ setting_id }}" type="radio" id="responsi-radio-img-{{ setting_id }}{{ i }}" class="checkbox responsi-radio-img-radio" value="{{key}}" name="{{ setting_id }}" {{{ checked }}} />
					<span class="responsi-radio-img-label">{{ key }}</span>
					<img id="{{ setting_id }}_{{ i }}" src="{{ val }}" alt="" data-value="{{ key }}" class="responsi-radio-img-img {{ selected }}" onClick="document.getElementById('responsi-radio-img-{{ setting_id }}{{ i }}').click();" />
					</span>
				<# }); #>
				<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
				<# } #>
			</div>
			<?php
		}
	}
}
?>