<?php
/**
 * Class to create a custom Background Patterns control
 */
if ( ! class_exists( 'Customize_Background_Patterns_Control' ) && class_exists('WP_Customize_Control')) {
	class Customize_Background_Patterns_Control extends WP_Customize_Control {

		public $type = 'background_patterns';

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
			$this->json['value']       = $this->setting->default;
			$this->json['backgrounds'] = array();
			$this->json['patterns']    = array();
			$this->json['bg_url']      = '';
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
				var setting_id  = data.settings['default'];
				var backgrounds = data.backgrounds;
				var patterns    = data.patterns
				var bg_url      = data.bg_url
				if ( typeof _wpCustomBackgroundPatternsControl != 'undefined' ) {
					backgrounds = _wpCustomBackgroundPatternsControl.backgrounds;
					patterns    = _wpCustomBackgroundPatternsControl.patterns;
					bg_url      = _wpCustomBackgroundPatternsControl.bg_url;
				}
			#>
			<div class="customize-control-container">
				<span class="customize-control-title customize-background-patterns-title"><?php echo __( 'Background Tiles', 'responsi' ); ?></span>
				<#
				var i = 0;
				var checked = '';
				var selected = '';
				var imglink;
				_.each( backgrounds, function( val, key ) {
					i++;
					checked  = '';
					selected = '';
					imglink  = bg_url + '/backgrounds/' + val;
					if ( data.value == imglink ) {
						checked  = 'checked=checked';
						selected = 'background-selected';
					}
				#>
					<span onClick="document.getElementById('bp-img-{{ setting_id }}{{ i }}').click();" class="bp-item bp-item-{{ i }} {{ selected }}">
						<input data-customize-setting-link="{{ setting_id }}" type="radio" id="bp-img-{{ setting_id }}{{ i }}" class="checkbox bp-radio" value="{{ bg_url }}/backgrounds/{{val}}" name="{{ setting_id }}" {{ checked }} />
					</span>
				<# }); #>
				<hr class="customize-background-line">
				<span class="customize-control-title customize-background-patterns-title"><?php echo __( 'Patterns', 'responsi' ); ?></span>
				<#
				_.each( patterns, function( val, key ) {
					i++;
					checked  = '';
					selected = '';
					imglink  = bg_url + '/patterns/' + val;
					if ( data.value == imglink ) {
						checked  = 'checked=checked';
						selected = 'background-selected';
					}
				#>
					<span onClick="document.getElementById('bp-img-{{ setting_id }}{{ i }}').click();" class="bp-item bp-item-{{ i }} {{ selected }}">
						<input data-customize-setting-link="{{ setting_id }}" type="radio" id="bp-img-{{ setting_id }}{{ i }}" class="checkbox bp-radio" value="{{ bg_url }}/patterns/{{val}}" name="{{ setting_id }}" {{ checked }} />
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