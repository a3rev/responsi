<?php

namespace A3Rev\Responsi;

/**
 * Class to create a custom iSelect control
 */

if ( ! class_exists( '\A3Rev\Responsi\Customize_iSelect_Control' ) && class_exists('\WP_Customize_Control')) {
	class Customize_iSelect_Control extends \WP_Customize_Control {

		public $type = 'iselect';

		public $notifications = array();

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
			$this->json['setting_id']   = $this->id;
			$this->json['value']   = $this->setting->default;
			$this->json['choices'] = $this->choices;
			$this->json['input_attrs'] = $this->input_attrs;
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
			<# 
			if( 'undefined' === typeof data.input_attrs ){ data.input_attrs = {};}
			var setting_id = data.setting_id ? data.setting_id : 'islect',choices = data.choices,input_attrs = data.input_attrs,selected = ''; #>
			<div class="customize-ctrl">
				<# if(data.label){ #><span class="customize-control-title">{{{ data.label }}}</span><# } #>
				<div class="iselect-container">
					<select class="responsi-iselect" name="{{ setting_id }}" id="{{ setting_id }}">
					<# if( "min" in input_attrs && "step" in input_attrs && "max" in input_attrs ){
						for ( var i = parseFloat(input_attrs['min']); i <= parseFloat(input_attrs['max']); i = i+parseFloat(input_attrs['step']) ) {
							selected = ''; if(data.value == i){selected = 'selected="selected"';}
							#><option value="{{ i }}" {{{ selected }}} >{{{ choices[i] }}}</option><#
						}
					}else{
						_.each(choices, function(  val, key ){
							selected = ''; if(data.value == key){selected = 'selected="selected"';} #>
							<option value="{{ key }}" {{{ selected }}} >{{{ val }}}</option>
						<# }); 
					}
					#>
					</select>
				</div>
				<# if( data.description ){ #><span class="customize-control-description">{{{ data.description }}}</span><# } #>
			</div>
			<?php
		}
	}
}
?>