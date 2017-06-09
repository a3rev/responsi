<?php
/**
 * Class to create a custom Border control
 */
if ( ! class_exists( 'Customize_Box_Shadow_Control' ) && class_exists('WP_Customize_Control')) {
	class Customize_Box_Shadow_Control extends WP_Customize_Control {

		public $type = 'box_shadow';

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
			wp_enqueue_style( 'wp-color-picker' );
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
			var setting_id     = data.setting_id;
			var onoff_value    = data.values.onoff;
			var inset_value    = data.values.inset;
			var color_value    = data.values.color;

			var onoff_checked = '';
			if ( 'true' == onoff_value ) {
				onoff_checked = 'checked="checked"';
			} else {
				onoff_value = 'false';
			}

			var inset_checked = '';
			if ( 'inset' == inset_value ) {
				inset_checked = 'checked="checked"';
			} else {
				inset_value = 'outset';
			}
			#>
			<div class="customize-control-container {{ data.custom_class }}">
				<# if ( data.label ) { #>
				<span class="customize-control-title">{{{ data.label }}}</span>
				<# } #>
				<div class="box-shadow-container">
					<div class="responsi-iphone-checkbox">
						<input type="checkbox" data-customize-setting-link="{{ setting_id }}[onoff]" id="{{ setting_id }}_onoff" name="{{ setting_id }}[onoff]" value="{{ onoff_value }}" {{{ onoff_checked }}} class="checkbox responsi-input responsi-box-shadow-onoff responsi-ui-icheckbox" />
					</div>
					<div class="clear"></div>
					<div class="responsi-box-shadow-container">
						<select class="responsi-box-shadow responsi-box-shadow_h_shadow" data-customize-setting-link="{{ setting_id }}[h_shadow]" name="{{ setting_id }}[h_shadow]">
						</select>
						<select class="responsi-box-shadow responsi-box-shadow_v_shadow" data-customize-setting-link="{{ setting_id }}[v_shadow]" name="{{ setting_id }}[v_shadow]">
						</select>
						<select class="responsi-box-shadow responsi-box-shadow_blur" data-customize-setting-link="{{ setting_id }}[blur]" name="{{ setting_id }}[blur]">
						</select>
						<select class="responsi-box-shadow responsi-box-shadow_spread" data-customize-setting-link="{{ setting_id }}[spread]" name="{{ setting_id }}[spread]">
						</select>
						<div class="clear"></div>
						<div class="responsi-iphone-checkbox responsi-iswitcher-checkbox">
							<input type="checkbox" data-customize-setting-link="{{ setting_id }}[inset]" id="{{ setting_id }}_inset" name="{{ setting_id }}[inset]" value="{{ inset_value }}" {{{ inset_checked }}} class="checkbox responsi-input responsi-box-shadow-inset responsi-ui-icheckbox responsi-ui-iswitcher" />
						</div>
						<input type="text" data-customize-setting-link="{{ setting_id }}[color]" name="{{ setting_id }}[color]" value="{{ color_value }}" data-default-color="{{ color_value }}" class="color-picker-hex responsi-color-picker responsi-box-shadow responsi-box-shadow-color" />
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
