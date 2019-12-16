<?php

namespace A3Rev\Responsi;

/**
 * Class to create a custom iLabel control
 */
if ( ! class_exists( '\A3Rev\Responsi\Customize_iLabel_Control' ) && class_exists('\WP_Customize_Control')) {
	class Customize_iLabel_Control extends \WP_Customize_Control {

		public $type = 'ilabel';

		public $notifications = array();

		public function to_json() {
			parent::to_json();
			$this->json['setting_id']   = $this->id;
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
			<div class="customize-ctrl ilabel">
				<# if(data.label){ #><span class="customize-control-title">{{{ data.label }}}</span><# } #>
				<# if( data.description ){ #><span class="customize-control-description">{{{ data.description }}}</span><# } #>
			</div>
			<?php
		}
	}
}
?>