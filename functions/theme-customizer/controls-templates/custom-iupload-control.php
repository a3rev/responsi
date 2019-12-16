<?php

namespace A3Rev\Responsi;

/**
 * Class to create a custom iupload control
 */
if ( ! class_exists( '\A3Rev\Responsi\Customize_iUpload_Control' ) && class_exists('\WP_Customize_Image_Control')) {
	class Customize_iUpload_Control extends \WP_Customize_Image_Control {
		
		public $type = 'iupload';
		public $mime_type = 'image';

		public $notifications = array();

		public function __construct( $manager, $id, $args = array() ) {
			parent::__construct( $manager, $id, $args );
			if ( ( $this instanceof WP_Customize_Image_Control ) ) {
				$this->button_labels = array(
					'select'       => __( 'Add Image', 'responsi' ),
					'change'       => __( 'Change Image', 'responsi' ),
					'default'      => __( 'Default', 'responsi' ),
					'remove'       => __( 'Remove', 'responsi' ),
					'placeholder'  => __( 'No image set', 'responsi' ),
					'frame_title'  => __( 'Select Image', 'responsi' ),
					'frame_button' => __( 'Choose Image', 'responsi' ),
				);
			}
		}

		public function to_json() {
			parent::to_json();
			$this->json['setting_id']      = $this->id;
			$this->json['notifications'] = $this->notifications;
		}

		public function enqueue() {
			wp_enqueue_script( 'responsi-customize-controls' );
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
		 * Render a JS template for the content of the color picker control.
		 *
		 * @since 4.1.0
		 */
		public function content_template() {
			?>
			<# var setting_id = data.setting_id ? data.setting_id : 'iupload';
			if( 'undefined' === typeof data.button_labels ){
				data.button_labels = {
					'select'       : '<?php echo __( 'Add Image', 'responsi' );?>',
					'change'       : '<?php echo __( 'Change Image', 'responsi' );?>',
					'default'      : '<?php echo __( 'Default', 'responsi' );?>',
					'remove'       : '<?php echo __( 'Remove', 'responsi' );?>',
					'placeholder'  : '<?php echo __( 'No image set', 'responsi' );?>',
					'frame_title'  : '<?php echo __( 'Select Image', 'responsi' );?>',
					'frame_button' : '<?php echo __( 'Choose Image', 'responsi' );?>',
				};
			}
			#>
			<div class="customize-ctrl">
			<label for="{{ setting_id }}-button">
				<# if ( data.label ) {  #>
					<span for="{{ setting_id }}-button" class="customize-control-title customize-icolor-title">{{{ data.label }}}</span>
				<# } #>
			</label>

			<# if ( data.attachment && data.attachment.id ) { #>
				<div class="attachment-media-view attachment-media-view-{{ data.attachment.type }} {{ data.attachment.orientation }}">
					<div class="thumbnail thumbnail-{{ data.attachment.type }}">
						<# if ( 'image' === data.attachment.type && data.attachment.sizes && data.attachment.sizes.medium ) { #>
							<img class="attachment-thumb" src="{{ data.attachment.sizes.medium.url.replace(/^https:/i, 'https://').replace(/^http:/i, '') }}" draggable="false" alt="" />
						<# } else if ( 'image' === data.attachment.type && data.attachment.sizes && data.attachment.sizes.full ) { #>
							<img class="attachment-thumb" src="{{ data.attachment.sizes.full.url.replace(/^https:/i, 'https://').replace(/^http:/i, '') }}" draggable="false" alt="" />
						<# } else if ( 'audio' === data.attachment.type ) { #>
							<# if ( data.attachment.image && data.attachment.image.src && data.attachment.image.src !== data.attachment.icon ) { #>
								<img src="{{ data.attachment.image.src.replace(/^https:/i, 'https://').replace(/^http:/i, '') }}" class="thumbnail" draggable="false" alt="" />
							<# } else { #>
								<img src="{{ data.attachment.icon.replace(/^https:/i, 'https://').replace(/^http:/i, '') }}" class="attachment-thumb type-icon" draggable="false" alt="" />
							<# } #>
							<p class="attachment-meta attachment-meta-title">&#8220;{{ data.attachment.title }}&#8221;</p>
							<# if ( data.attachment.album || data.attachment.meta.album ) { #>
							<p class="attachment-meta"><em>{{ data.attachment.album || data.attachment.meta.album }}</em></p>
							<# } #>
							<# if ( data.attachment.artist || data.attachment.meta.artist ) { #>
							<p class="attachment-meta">{{ data.attachment.artist || data.attachment.meta.artist }}</p>
							<# } #>
							<audio style="visibility: hidden" controls class="wp-audio-shortcode" width="100%" preload="none">
								<source type="{{ data.attachment.mime }}" src="{{ data.attachment.url.replace(/^https:/i, 'https://').replace(/^http:/i, '') }}"/>
							</audio>
						<# } else if ( 'video' === data.attachment.type ) { #>
							<div class="wp-media-wrapper wp-video">
								<video controls="controls" class="wp-video-shortcode" preload="metadata"
									<# if ( data.attachment.image && data.attachment.image.src !== data.attachment.icon ) { #>poster="{{ data.attachment.image.src }}"<# } #>>
									<source type="{{ data.attachment.mime }}" src="{{ data.attachment.url.replace(/^https:/i, 'https://').replace(/^http:/i, '') }}"/>
								</video>
							</div>
						<# } else { #>
							<img class="attachment-thumb type-icon icon" src="{{ data.attachment.icon.replace(/^https:/i, 'https://').replace(/^http:/i, '') }}" draggable="false" alt="" />
							<p class="attachment-title">{{ data.attachment.title }}</p>
						<# } #>
					</div>
					<div class="actions">
						<# if ( data.canUpload ) { #>
						<button type="button" class="button remove-button">{{ data.button_labels.remove }}</button>
						<button type="button" class="button upload-button control-focus" id="{{ setting_id }}-button">{{ data.button_labels.change }}</button>
						<div class="clear"></div>
						<# } #>
					</div>
				</div>
			<# } else { #>
				<div class="attachment-media-view">
					<div class="placeholder">
							{{ data.button_labels.placeholder }}
					</div>
					<div class="actions">
						<# if ( data.defaultAttachment ) { #>
							<button type="button" class="button default-button">{{ data.button_labels['default'] }}</button>
						<# } #>
						<# if ( data.canUpload ) { #>
						<button type="button" class="button upload-button" id="{{ setting_id }}-button">{{ data.button_labels.select }}</button>
						<# } #>
						<div class="clear"></div>
					</div>
				</div>
			<# } #>

			<# if ( data.description ) { #>
				<span class="customize-control-description">{{{ data.description }}}</span>
			<# } #>
			</div>
			<?php
		}
	}
}
?>
