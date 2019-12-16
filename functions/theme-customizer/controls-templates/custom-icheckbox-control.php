<?php

namespace A3Rev\Responsi;

/**
 * Class to create a custom iCheckbox control
 */
if ( ! class_exists( '\A3Rev\Responsi\Customize_iCheckbox_Control' ) && class_exists('\WP_Customize_Control')) {
	class Customize_iCheckbox_Control extends \WP_Customize_Control {

		public $type = 'icheckbox';

		public $ui_class = '';

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
			$this->json['choices']     	   = isset( $this->choices ) ? $this->choices : array( 
				'checked_value' 	=> 'true', 
				'unchecked_value' 	=> 'false', 
				'checked_label' 	=> __( 'ON', 'responsi' ), 
				'unchecked_label' 	=> __( 'OFF', 'responsi' ),
				'container_width' 	=> 80
			);
			$this->json['value']           = $this->setting->default;
			$this->json['checked_value']   = isset( $this->choices['checked_value'] ) ? $this->choices['checked_value'] : 'true' ;
			$this->json['unchecked_value'] = isset( $this->choices['unchecked_value'] ) ? $this->choices['unchecked_value'] : 'false' ;
			$this->json['checked_label']   = isset( $this->choices['checked_label'] ) ? $this->choices['checked_label'] : __( 'ON', 'responsi' ) ;
			$this->json['unchecked_label'] = isset( $this->choices['unchecked_label'] ) ? $this->choices['unchecked_label'] : __( 'OFF', 'responsi' ) ;
			$this->json['container_width'] = isset( $this->choices['container_width'] ) ? $this->choices['container_width'] : 80 ;
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
			<# var setting_id = data.setting_id ? data.setting_id : 'icheckbox',checked_value = data.checked_value,unchecked_value = data.unchecked_value,container_width = data.container_width,checked = '',value = data.value;
			if ( value == checked_value ) {checked = 'checked="checked"';value = checked_value;}else{value = unchecked_value;} #>
			<div class="customize-ctrl">
				<# if(data.label){ #><span class="customize-control-title">{{{ data.label }}}</span><# } #>
				<div class="responsi-iphone-checkbox">
					<input type="checkbox" {{{ checked }}} id="{{ setting_id }}" class="checkbox responsi-input responsi-ui-icheckbox <?php echo $this->ui_class; ?>" />
				</div>
				<# if( data.description ){ #><span class="customize-control-description">{{{ data.description }}}</span><# } #>
			</div>
			<?php
		}
	}
}
?>
