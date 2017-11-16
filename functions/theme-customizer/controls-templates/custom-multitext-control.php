<?php
/**
 * Class to create a custom Multiple Text control
 */
if ( ! class_exists( 'Customize_Multiple_Text_Control' ) && class_exists('WP_Customize_Control')) {
	class Customize_Multiple_Text_Control extends WP_Customize_Control {

		public $type = 'multitext';

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
			$defaultValue = array();
			foreach(  $this->choices as $key => $val ){
				$defaultValue[] = $this->settings[ $this->id.'_'.$key ]->default;
			}
			$this->json['setting_id']   = $this->id;
			$this->json['choices']      = $this->choices;
			$this->json['defaultValue'] = $defaultValue;
		}

		protected function render() {
			
			$custom_class = '';
			if( isset( $this->input_attrs['class']) && $this->input_attrs['class'] ){
				$custom_class = ' '.$this->input_attrs['class'];
			}

			$id    = 'customize-control-' . str_replace( '[', '-', str_replace( ']', '', $this->id ) );
			$class = 'customize-control customize-control-responsi customize-control-' . $this->type;

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
	
			<# 
				var choices      = data.choices;
				var defaultValue = data.defaultValue;
			#>
			<div class="customize-control-container">
				<# if ( data.label ) { #>
				<span class="customize-control-title">{{{ data.label }}}</span>
				<# } #>
				<#
				var i = 0;
				_.each(data.choices, function(  val, key ){
					#>
					<div class="responsi-multitext-item"><input name="{{ data.setting_id }}_{{ key }}" id="{{ data.setting_id }}_{{ key }}" data-customize-setting-link="{{ data.setting_id }}_{{ key }}" value="{{defaultValue[i]}}" type="text" class="responsi-text responsi-multitext" /><span class="ilabel-multitext ilabel-multitext-{{{key}}}">{{{val}}}</span></div>
					<#
					i++;
				});
				#>
				<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
				<# } #>
			</div>
			<?php
		}
	}
}
?>