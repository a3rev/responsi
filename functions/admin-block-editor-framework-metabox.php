<?php
/**
 * Block editor document panel for Responsi framework custom settings (classic meta box equivalent).
 *
 * @package Responsi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Internal meta: lets the block editor mark the post dirty when framework fields change in the DOM.
 * Removed after each save so it is not kept in the database.
 */
function responsi_register_framework_metabox_touch_meta() {
	$post_types = get_post_types(
		array(
			'show_in_rest' => true,
		),
		'names'
	);
	foreach ( $post_types as $post_type ) {
		register_post_meta(
			$post_type,
			'responsi_mb_touch',
			array(
				'type'              => 'string',
				'single'            => true,
				'show_in_rest'      => true,
				'sanitize_callback' => 'sanitize_text_field',
				'auth_callback'     => function ( $allowed, $meta_key, $object_id ) {
					unset( $allowed, $meta_key );
					return (bool) current_user_can( 'edit_post', (int) $object_id );
				},
			)
		);
	}
}
add_action( 'init', 'responsi_register_framework_metabox_touch_meta', 20 );

/**
 * Do not persist the touch meta (it is only for editor dirty state).
 *
 * @param int $post_id Post ID.
 */
function responsi_clear_framework_metabox_touch_meta( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	$post_id = (int) $post_id;
	if ( $post_id <= 0 ) {
		return;
	}
	delete_post_meta( $post_id, 'responsi_mb_touch' );
}
add_action( 'save_post', 'responsi_clear_framework_metabox_touch_meta', 999 );

/**
 * Build associative array of framework field values for REST (read path).
 *
 * @param int $post_id Post ID.
 * @return array<string, string>
 */
function responsi_collect_framework_field_values( $post_id ) {
	$out  = array();
	$opts = get_option( 'responsi_metaboxe_options', array() );
	if ( ! is_array( $opts ) ) {
		return $out;
	}

	$custom = get_post_meta( $post_id, 'responsi_custom_meta', true );
	if ( ! is_array( $custom ) ) {
		$custom = array();
	}

	foreach ( $opts as $metabox ) {
		if ( ! isset( $metabox['type'], $metabox['name'] ) ) {
			continue;
		}
		$name = $metabox['name'];
		if ( 'content_max_width' === $name && 'slider' === $metabox['type'] ) {
			$val = isset( $custom['content_max_width'] ) ? (string) $custom['content_max_width'] : '';
			if ( '' === $val && isset( $metabox['std'] ) ) {
				$val = (string) $metabox['std'];
			}
			$out[ $name ] = $val;
		} elseif ( in_array( $metabox['type'], responsi_metabox_fieldtypes(), true ) ) {
			$out[ $name ] = (string) get_post_meta( $post_id, $name, true );
		}
	}

	return $out;
}

/**
 * REST get_callback for responsi_framework_fields.
 *
 * @param array<string, mixed> $object Post REST object.
 * @return array<string, string>|null
 */
function responsi_rest_get_framework_fields( $object ) {
	if ( empty( $object['id'] ) ) {
		return null;
	}
	$post_id = (int) $object['id'];
	if ( $post_id <= 0 || ! current_user_can( 'edit_post', $post_id ) ) {
		return null;
	}
	return responsi_collect_framework_field_values( $post_id );
}

/**
 * REST update_callback for responsi_framework_fields.
 *
 * @param mixed           $value    Decoded JSON object.
 * @param WP_Post         $post_obj Post object.
 * @param string          $field    Field name (unused).
 * @param WP_REST_Request $request  Request (unused).
 * @param string          $object_type Object subtype.
 * @return bool|WP_Error
 */
function responsi_rest_update_framework_fields( $value, $post_obj, $field, $request, $object_type ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed
	unset( $field, $request, $object_type );
	if ( ! $post_obj instanceof WP_Post ) {
		return true;
	}
	if ( ! current_user_can( 'edit_post', $post_obj->ID ) ) {
		return new WP_Error(
			'rest_cannot_edit',
			__( 'Sorry, you are not allowed to edit this post.', 'responsi' ),
			array( 'status' => rest_authorization_required_code() )
		);
	}
	if ( null === $value || '' === $value ) {
		return true;
	}
	if ( ! is_array( $value ) ) {
		return true;
	}

	$clean = array();
	foreach ( $value as $k => $v ) {
		if ( ! is_string( $k ) || '' === $k ) {
			continue;
		}
		if ( is_scalar( $v ) ) {
			$clean[ $k ] = (string) $v;
		}
	}

	responsi_metabox_apply_posted_values( $post_obj->ID, $clean, array() );

	return true;
}

/**
 * Register REST field and HTML route.
 */
function responsi_framework_metabox_register_rest() {
	$post_types = get_post_types(
		array(
			'show_in_rest' => true,
		),
		'names'
	);

	foreach ( $post_types as $post_type ) {
		register_rest_field(
			$post_type,
			'responsi_framework_fields',
			array(
				'get_callback'    => 'responsi_rest_get_framework_fields',
				'update_callback' => 'responsi_rest_update_framework_fields',
				'schema'          => array(
					'description'          => __( 'Responsi framework custom settings (same storage as the classic meta box).', 'responsi' ),
					'type'                 => 'object',
					'context'              => array( 'view', 'edit' ),
					'properties'           => array(),
					'additionalProperties' => array(
						'type' => 'string',
					),
				),
			)
		);
	}

	register_rest_route(
		'responsi/v1',
		'/framework-metabox/(?P<id>\\d+)',
		array(
			'methods'             => WP_REST_Server::READABLE,
			'permission_callback' => function ( WP_REST_Request $req ) {
				$id = (int) $req->get_param( 'id' );
				return $id > 0 && current_user_can( 'edit_post', $id );
			},
			'callback'            => function ( WP_REST_Request $req ) {
				$id = (int) $req->get_param( 'id' );
				$post = get_post( $id );
				if ( ! $post instanceof WP_Post ) {
					return new WP_Error( 'not_found', __( 'Post not found.', 'responsi' ), array( 'status' => 404 ) );
				}

				$GLOBALS['post'] = $post;
				setup_postdata( $post );

				/**
				 * Same preamble as classic edit screen: rebuild option definitions when applicable.
				 *
				 * @param WP_Post $post Post being edited.
				 */
				if ( function_exists( 'responsi_metabox_options' ) ) {
					responsi_metabox_options();
				}

				/**
				 * Allow child themes / plugins to mirror responsi_metabox_create hooks.
				 *
				 * @param WP_Post $post Post being edited.
				 */
				do_action( 'responsi_framework_block_editor_metabox_before_render', $post );

				ob_start();
				// Classic screen wraps output in #responsi-metabox-settings.postbox > .inside (required by custom-fields.css).
				echo '<div id="responsi-metabox-settings" class="postbox responsi-framework-block-editor-metabox-postbox"><div class="inside">';
				responsi_metabox_create(
					$post,
					array(
						'id'   => 'responsi-metabox-settings',
						'args' => array(
							'__block_editor_compatible_meta_box' => true,
							'__back_compat_meta_box'             => false,
						),
					)
				);
				echo '</div></div>';
				$html = ob_get_clean();
				wp_reset_postdata();

				return array(
					'html' => $html,
				);
			},
		)
	);
}
add_action( 'rest_api_init', 'responsi_framework_metabox_register_rest' );

/**
 * Enqueue block editor script and legacy metabox assets inside the editor.
 */
function responsi_framework_metabox_enqueue_block_editor() {
	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( ! $screen || ! $screen->is_block_editor() ) {
		return;
	}

	global $responsi_version;
	$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	if ( is_rtl() ) {
		wp_deregister_script( 'jquery-ui-slider' );
		wp_enqueue_script(
			'jquery-ui-slider',
			get_template_directory_uri() . '/functions/js/jquery.ui.slider.rtl' . $suffix . '.js',
			array( 'jquery' ),
			$responsi_version,
			true
		);
	} else {
		wp_enqueue_script( 'jquery-ui-slider' );
	}

	wp_enqueue_script( 'responsi-custom-fields' );

	if ( is_rtl() ) {
		wp_enqueue_style( 'responsi-custom-fields-rtl' );
	} else {
		wp_enqueue_style( 'responsi-custom-fields' );
	}
	wp_enqueue_style( 'responsi-icon' );

	wp_enqueue_script(
		'responsi-framework-block-editor',
		get_template_directory_uri() . '/functions/js/responsi-framework-block-editor.js',
		array(
			'wp-plugins',
			'wp-edit-post',
			'wp-element',
			'wp-components',
			'wp-data',
			'wp-api-fetch',
			'wp-i18n',
			'jquery',
			'jquery-ui-slider',
			'jquery-ui-tabs',
			'responsi-custom-fields',
		),
		$responsi_version,
		true
	);

	wp_localize_script(
		'responsi-framework-block-editor',
		'responsiFrameworkMetaboxEditor',
		array(
			'title' => __( 'Framework Custom Settings', 'responsi' ),
		)
	);
}
add_action( 'enqueue_block_editor_assets', 'responsi_framework_metabox_enqueue_block_editor', 20 );
