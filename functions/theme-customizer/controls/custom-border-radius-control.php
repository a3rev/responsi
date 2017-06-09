<?php
/**
 * Class to create a custom Border Radius control
 */
if ( ! class_exists( 'Customize_Border_Radius_Control' ) && class_exists('WP_Customize_Control')) {
	class Customize_Border_Radius_Control extends WP_Customize_Control {

		public $type = 'border_radius';

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
			var setting_id    = data.setting_id;
			var corner_value  = data.values.corner;
			var rounded_value = data.values.rounded_value;

			var checked = '';
			var value = corner_value;
			if ( 'rounded' == value ) {
				checked = 'checked="checked"';
			} else {
				value = 'square';
			}
			#>
			<div class="customize-control-container {{ data.custom_class }}">
				<# if ( data.label ) { #>
				<span class="customize-control-title customize-border-title">{{{ data.label }}}</span>
				<# } #>
				<div class="border-radius-container">
					<div class="responsi-iphone-checkbox responsi-iswitcher-checkbox">
						<input type="checkbox" data-customize-setting-link="{{ setting_id }}[corner]" id="{{ setting_id }}_corner" name="{{ setting_id }}[corner]" value="{{ value }}" {{{ checked }}} class="checkbox responsi-input responsi-ui-icheckbox responsi-ui-iswitcher" />
					</div>
					<div class="clear"></div>
					<div class="responsi-range-slider responsi-border-corner-slider">
						<div class="ui-slide" id="{{ setting_id }}_rounded_div"></div>
						<input type="text" readonly="readonly" data-customize-setting-link="{{ setting_id }}[rounded_value]" id="{{ setting_id }}_rounded" name="{{ setting_id }}[rounded_value]" value="{{ rounded_value }}" class="responsi-input regular-text responsi-slide-value" />
					</div>
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
