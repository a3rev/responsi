<?php
/**
 * Class to create a custom Column control
 */
if ( ! class_exists( 'Customize_Column_Control' ) && class_exists('WP_Customize_Control')) {
	class Customize_Column_Control extends WP_Customize_Control {

		public $type = 'column';

		public $notifications = array();

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
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
		 * Enqueue scripts/styles.
		 *
		 * @since 1.0.0
		 */
		public function enqueue() {
			wp_enqueue_script( 'responsi-customize-controls' );
		}

		/**
		 * Refresh the parameters passed to the JavaScript via JSON.
		 *
		 * @since 1.0.0
		 * @uses WP_Customize_Control::to_json()
		 */
		public function to_json() {
			parent::to_json();

			$custom_class = '';
			if( isset( $this->input_attrs['class']) && $this->input_attrs['class'] ){
				$custom_class = $this->input_attrs['class'];
			}

			$validate = false;

			if( isset( $this->input_attrs['validate']) && $this->input_attrs['validate'] ){
				$validate = $this->input_attrs['validate'];
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
			$this->json['notifications'] = $this->notifications;
			$this->json['choices'] = $this->choices;
			$this->json['validate'] = $validate;
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

			var setting_id = data.setting_id, checked, selected, i = 0, choices = data.choices, inp;

			if( 'undefined' === typeof data.values ){ 
				data.values = {'col':'1' }; 
				_.each(choices, function(  val, key ){
					i++;
					data.values['col'+i] = Math.round(100/Object.keys(choices).length);
				});
			}

			#>
			<div class="customize-ctrl {{ data.custom_class }}">
				<# if(data.label){ #><span class="customize-control-title">{{{ data.label }}}</span><# } #>
				<div class="column-container">
					<# 
						i = 0;
						_.each(choices, function(  val, key ){
						i++;
						#>
						<span class="column-item column-item-{{i}}">
							<# checked = '';selected = '';
							if(data.values.col == key){checked = 'checked="checked"';selected = 'responsi-radio-img-selected';}
							#>
							<input type="radio" id="responsi-radio-img-{{ setting_id }}{{i}}" class="checkbox responsi-radio-img-radio" value="{{key}}" name="{{ setting_id }}" {{{ checked }}} />
							<img id="{{ setting_id }}_{{i}}" data-src="{{ val }}" alt="" data-value="{{ key }}" class="responsi-radio-img-img {{ selected }}" onClick="document.getElementById('responsi-radio-img-{{ setting_id }}{{i}}').click();" />
						</span>
					<# }); #>

					<span class="column-item-input column-item-input{{data.values.col}}">
					<# 
					i = 0;
					_.each(choices, function(  val, key ){
						i++;
						inp = data.values['col'+i];
						#>
						<input type="number" data-id="{{i}}" id="responsi-input-{{ setting_id }}{{i}}" class="column-input-{{i}} responsi-input-input" value="{{ inp }}" name="{{ setting_id }}_{{i}}" min="1" max="100" />
					<# }); #>
					</span>
					
				</div>
				<# if( data.description ){ #><span class="customize-control-description">{{{ data.description }}}</span><# } #>
			</div>
			<?php
		}
	}
}
?>
