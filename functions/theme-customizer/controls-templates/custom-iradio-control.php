<?php
/**
 * Class to create a custom iRadio control
 */
if ( ! class_exists( 'Customize_iRadio_Control' ) && class_exists('WP_Customize_Control')) {
	class Customize_iRadio_Control extends WP_Customize_Control {

		public $type = 'iradio';

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
			$this->json['std']     = isset($this->input_attrs['std']) ? $this->input_attrs['std'] : '';
			$this->json['choices'] = $this->choices;
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
			<# var setting_id = data.setting_id ? data.setting_id : 'iradio',choices = data.choices,checked = ''; #>
			<div class="customize-ctrl">
				<# if(data.label){ #><span class="customize-control-title">{{{ data.label }}}</span><# } #>
				<div class="responsi-iphone-checkbox">
					<# _.each(choices, function(  val, key ){
						checked = '';
						if(data.value != ''){if(data.value == key){checked = 'checked="checked" checkbox-disabled="true"';}}else{if(data.std != '' && data.std == key){checked = 'checked="checked" checkbox-disabled="true"';}} #>
					<input name="{{ setting_id }}" id="{{ setting_id }}_{{ key }}_iradio" value="{{ key }}" {{{ checked }}} class="responsi-input responsi-radio responsi-ui-iradio" type="radio" /><label>{{ val }}</label><div class="clear"></div>
					<# }); #>
				</div>
				<# if( data.description ){ #><span class="customize-control-description">{{{ data.description }}}</span><# } #>
			</div>
			<?php
		}
	}
}
?>