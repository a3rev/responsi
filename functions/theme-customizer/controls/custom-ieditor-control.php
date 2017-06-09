<?php
function responsi_wp_editor_customize() {
	?>
	<div id="wp-editor-customize-container" style="display:none;">
		<a href="#" class="close close-editor-button" title="<?php echo __( 'Close', 'responsi' ); ?>"><span class="icon"></span></a>
		<div class="editor">
			<span id="wpeditor_customize_title" class="customize-control-title"></span>
			<?php
			$output = '';
			ob_start();
			remove_all_filters('mce_external_plugins');
			do_action('filter_mce_external_plugins_before');
			wp_editor( '', 'wpeditorcustomize', array( 'textarea_name' => 'wpeditorcustomize', 'media_buttons' => true, 'textarea_rows' => 20, 'tinymce' => true, 'wpautop' => true ) );
			do_action('filter_mce_external_plugins_after');
			$output .= ob_get_clean();
			echo $output;

			?>
			<p><a href="#" data-id="setting-id" class="button button-primary update-editor-button"><?php echo __( 'Save and close', 'responsi' ); ?></a></p>
		</div>
	</div>
	<div id="wp-editor-customize-backdrop" style="display:none;"></div>
	<?php
}
/**
 * Class to create a custom iEditor control
 */
if ( ! class_exists( 'Customize_iEditor_Control' ) && class_exists('WP_Customize_Control')) {
	class Customize_iEditor_Control extends WP_Customize_Control {

		public $type = 'ieditor';

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
			$this->json['value']        = $this->setting->default;
			$this->json['button_label'] = isset( $this->button_label ) ? $this->button_label : __( 'Edit content', 'responsi' );
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
			<# var setting_id = data.settings['default']; #>
			<div class="customize-control-container">
				<# if ( data.label ) { #>
				<span class="customize-control-title customize-itext-title">{{{ data.label }}}</span>
				<# } #>
				<div class="ieditor-container">
					<button type="button" class="button show-editor-button" id="{{ setting_id }}">{{{ data.button_label }}}</button>
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
