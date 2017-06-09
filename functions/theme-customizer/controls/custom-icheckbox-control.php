<?php
/**
 * Class to create a custom iCheckbox control
 */
if ( ! class_exists( 'Customize_iCheckbox_Control' ) && class_exists('WP_Customize_Control')) {
	class Customize_iCheckbox_Control extends WP_Customize_Control {

		public $type = 'icheckbox';

		public $ui_class = '';

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
		 * Enqueue scripts/styles for the switcher.
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
			$this->json['setting_id']      = $this->id;
			$this->json['value']           = $this->setting->default;
			$this->json['checked_value']   = isset( $this->choices['checked_value'] ) ? $this->choices['checked_value'] : 'true' ;
			$this->json['unchecked_value'] = isset( $this->choices['unchecked_value'] ) ? $this->choices['unchecked_value'] : 'false' ;
			$this->json['checked_label']   = isset( $this->choices['checked_label'] ) ? $this->choices['checked_label'] : __( 'ON', 'responsi' ) ;
			$this->json['unchecked_label'] = isset( $this->choices['unchecked_label'] ) ? $this->choices['unchecked_label'] : __( 'OFF', 'responsi' ) ;
			$this->json['container_width'] = isset( $this->choices['container_width'] ) ? $this->choices['container_width'] : 80 ;
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
			var setting_id      = data.setting_id;
			var checked_value   = data.checked_value;
			var unchecked_value = data.unchecked_value;
			var container_width = data.container_width;

			var checked = '';
			var value = data.value;
			if ( value == checked_value ) {
				checked = 'checked="checked"';
			} else {
				value = unchecked_value;
			}
			#>
			<div class="customize-control-container">
				<# if ( data.label ) { #>
				<span class="customize-control-title">{{{ data.label }}}</span>
				<# } #>
				<div class="responsi-iphone-checkbox">
					<input type="checkbox" data-customize-setting-link="{{ setting_id }}" id="{{ setting_id }}" name="{{ setting_id }}" value="{{ value }}" {{{ checked }}} class="checkbox responsi-input responsi-ui-icheckbox <?php echo $this->ui_class; ?>" />
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
