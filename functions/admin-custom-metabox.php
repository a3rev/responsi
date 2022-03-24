<?php
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;

if ( !function_exists('responsi_metabox_options') ){

    function responsi_metabox_options(){

        global $responsi_options;

        $responsi_images_directory =  get_template_directory_uri() . '/functions/images/';

        $responsi_metaboxe_options = array();

        if( 'post' === get_post_type() || !get_post_type() ){

            $responsi_metaboxe_options[] = array(
                'name'      => 'layout',
                'label'     => __( 'Content Sidebar Layout', 'responsi' ),
                'type'      => "images",
                'desc'      => __( 'Select a specific layout for this post/page. Overrides default site layout.', 'responsi' ),
                'options'   => array( 
                    ''                  => $responsi_images_directory . 'layout-off.png',
                    'one-col'           => $responsi_images_directory . '1c.png',
                    'two-col-left'      => $responsi_images_directory . '2cl.png',
                    'two-col-right'     => $responsi_images_directory . '2cr.png',
                    'three-col-left'    => $responsi_images_directory . '3cl.png',
                    'three-col-middle'  => $responsi_images_directory . '3cm.png',
                    'three-col-right'   => $responsi_images_directory . '3cr.png'
                )
            );
            $responsi_metaboxe_options[] = array(
                'name' => 'content_layout',
                'label' => __( 'Content Width', 'responsi' ),
                'type' => 'images',
                'desc' => __( 'Select a specific content wide for this post/page. Overrides default site content width.', 'responsi' ),
                'options' => array( 
                    ''                  => $responsi_images_directory . 'layout-off.png',
                    '1'                 => $responsi_images_directory . 'cw1.png',
                    '2'                 => $responsi_images_directory . 'cw2.png',
                    '3'                 => $responsi_images_directory . 'cw3.png',
                    '4'                 => $responsi_images_directory . 'cw4.png',
                    '5'                 => $responsi_images_directory . 'cw5.png',
                    '6'                 => $responsi_images_directory . 'cw6.png'
                )
            );

            $responsi_metaboxe_options[] = array(
                'name' => 'content_column_grid',
                'label' => __( 'Grid View Column', 'responsi' ),
                'type' => 'images',
                'desc' => __( 'Select a specific Column for grid view show in content width for this post/page. Overrides default site content wide.', 'responsi' ),
                'options' => array( 
                    ''                  => $responsi_images_directory . 'layout-off.png',
                    '1'                 => $responsi_images_directory . 'bc1.png',
                    '2'                 => $responsi_images_directory . 'bc2.png',
                    '3'                 => $responsi_images_directory . 'bc3.png',
                    '4'                 => $responsi_images_directory . 'bc4.png',
                    '5'                 => $responsi_images_directory . 'bc5.png',
                    '6'                 => $responsi_images_directory . 'bc6.png'
                )
            );

            /*$responsi_metaboxe_options[] = array(
                'name' => 'content_max_width',
                'label' => __( 'Maximun Content Width', 'responsi' ),
                'type' => 'number',
                'desc' => __( 'Maximum content width in pixels in large screens.', 'responsi' ),
                'options' => array( 
                    'min'                 => 600,
                    'max'                 => 3000,
                    'step'                => 1
                )
            );*/

            $responsi_metaboxe_options[] = array(
                'name' => 'content_max_width',
                'label' => __( 'Maximun Content Width', 'responsi' ),
                'type' => 'slider',
                'desc' => __( 'Maximum content width in pixels in large screens.', 'responsi' ),
                'options' => array( 
                    'min'                   => 600,
                    'max'                   => 3000,
                    'step'                  => 1,
                ),
                'std'                       => isset($responsi_options['responsi_layout_width']) ? $responsi_options['responsi_layout_width'] : 1024,
                'place_holder'              => isset($responsi_options['responsi_layout_width']) ? $responsi_options['responsi_layout_width'] : 1024,
            );

            if ( get_option( 'responsi_metaboxe_options' ) != $responsi_metaboxe_options ) {
                update_option( 'responsi_metaboxe_options', $responsi_metaboxe_options );
            }
        }
    }
}

function responsi_metabox_create( $post, $callback ){
    global $post;

	do_action( 'responsi_metabox_create', $post, $callback );

	$template_to_show = $callback['args'];

    $responsi_metaboxe_options = get_option( 'responsi_metaboxe_options', array() );

	if ( ! is_array( $responsi_metaboxe_options ) ){ 
        $responsi_metaboxe_options = array();
    }

    $display_general_fields = true;
    if ( count( $responsi_metaboxe_options ) <= 0 ) {
        $display_general_fields = false;
    }

    $output = '';

    $output .= wp_nonce_field( 'responsi-metabox-custom-fields', 'responsi-metabox-custom-fields-nonce', true, false );
    
    if ( $callback['id'] === 'responsi-metabox-settings' ) {
	    $output .= '<div class="responsi-metabox-tabs">';
	    //$output .= '<ul class="tabber hide-if-no-js">';
    	if ( $display_general_fields ) {
            //$output .= '<li class="wf-tab-general"><a href="#wf-tab-general">' . __( 'Custom Layout', 'responsi' ) . '</a></li>';
        }
    	$output .= apply_filters( 'responsi_metaboxe_custom_field_tab_headings', '' );
	    //$output .= '</ul>';
    }

    if ( $display_general_fields ) {
        $output .= responsi_metabox_create_fields( $responsi_metaboxe_options, $callback, 'general' );
    }

    $output = apply_filters( 'responsi_metaboxe_custom_field_tab_content', $output );

    $output .= '</div>';

    echo $output;
}

/**
 * responsi_metabox_create_fields()
 *
 * Create markup for custom fields based on the given arguments.
 *
 * @access public
 * @since 1.0.0
 * @param array $metaboxes
 * @param array $callback
 * @param string $token (default: 'general')
 * @return string $output
 */
function responsi_metabox_create_fields( $metaboxes, $callback, $token = 'general' ) {
	global $post;

    if ( ! is_array( $metaboxes ) ){
        return;
    }

	$template_to_show = $token;

	$output = '';

	$output .= '<div id="wf-tab-' . esc_attr( $token ) . '">';
	$output .= '<table class="responsi-metabox-table">';
    foreach ( $metaboxes as $k => $metabox ){

    	$row_css_class = 'responsi-metabox-custom-field';
    	if ( ( $k + 1 ) === count( $metaboxes ) ) { 
            $row_css_class .= ' last';
        }

    	$metaboxid = 'responsi-metabox-' . esc_attr( $metabox['name'] );
    	$metaboxname = esc_attr( $metabox['name'] );

    	$metabox_post_type_restriction = 'undefined';

    	if ( ( '' !== $metabox_post_type_restriction ) && ( $metabox_post_type_restriction === 'true' ) ) {
    		$type_selector = true;
    	} elseif ( 'undefined' === $metabox_post_type_restriction ) {
    		$type_selector = true;
    	} else {
    		$type_selector = false;
    	}

   		$metaboxvalue = '';

    	if ( $type_selector ) {

    		if( isset( $metabox['type'] ) && ( in_array( $metabox['type'], responsi_metabox_fieldtypes() ) ) ) {
                $metaboxvalue = get_post_meta( $post->ID, $metaboxname, true);
			}

			foreach ( array( 'label', 'desc', 'std' ) as $k ) {
				if ( isset( $metabox[$k] ) && ( $metabox[$k] != '' ) ) {
					$metabox[$k] = stripslashes( $metabox[$k] );
				}
			}

    	    if ( '' == $metaboxvalue && isset( $metabox['std'] ) ) {
    	        $metaboxvalue = $metabox['std'];
    	    }

    	    $row_css_class .= ' responsi-metabox-field-type-' . esc_attr( strtolower( $metabox['type'] ) );

			if( 'info' === $metabox['type'] ) {

    	        $output .= '<tr class="' . esc_attr( $row_css_class ) . '" style="background:#f8f8f8; font-size:11px; line-height:1.5em;">';
    	        //$output .= '<th class="responsi-metabox-name"></th>';
    	        $output .= '<td style="font-size:11px;">
                                <label class="responsi-metabox-name" for="' . esc_attr( $metaboxid ) . '">' . $metabox['label'] . '</label>
                                ' . $metabox['desc'] . '
                            </td>';
    	        $output .= '</tr>';

    	    }elseif( 'slider' === $metabox['type'] ) {

                if( $metabox['name'] == 'content_max_width' ){
                    $metaboxvalue = $metabox['std'];
                    $responsi_custom_meta = get_post_meta( $post->ID , 'responsi_custom_meta', true );
                    if( is_array( $responsi_custom_meta ) && isset( $responsi_custom_meta['content_max_width'] ) )
                    $metaboxvalue = $responsi_custom_meta['content_max_width'];
                }

                $min = '';
                $max = '';
                $step = '';
                $place_holder = '';

                $array = $metabox['options'];

                if( $array ) {
                    if( isset( $array['min'] ) && $array['min'] >= 0 ){
                        $min = ' data-min="'.(int)$array['min'].'"';
                    }
                    if( isset( $array['max'] ) && $array['max'] >= 0 ){
                        $max = ' data-max="'.(int)$array['max'].'"';
                    }
                    if( isset( $array['step'] ) && $array['step'] >= 0 ){
                        $step = ' data-step="'.(int)$array['step'].'"';
                    }
                }

                $add_class = ''; 
                $add_counter = '';
                if( 'seo' === $template_to_show ){
                    $add_class = 'words-count';
                    $add_counter = '<span class="counter">0 characters, 0 words</span>';
                }
                $output .= '<tr class="' . esc_attr( $row_css_class ) . '">';
                //$output .= '<th class="responsi-metabox-name"></th>';
                $output .= '<td>
                    <label class="responsi-metabox-name" for="' . esc_attr( $metaboxid ) . '">'.$metabox['label'].'</label>
                    <div class="responsi-range-slider">
                        <div class="ui-slide" id="'.esc_attr( $metaboxid ).'_div"></div>
                        <input type="text" readonly="readonly" id="'.esc_attr( $metaboxid ).'" name="'.esc_attr( $metaboxname ).'" value="'.$metaboxvalue.'" class="responsi-input regular-text islide-value" '.$min.' '.$max.' '.$step.' />
                    </div>';
                $output .= '<span class="responsi-metabox-desc">' . $metabox['desc'] . ' ' . $add_counter . '</span></td>';
                $output .= '</tr>';

            }elseif( 'number' === $metabox['type'] ) {

                $min = '';
                $max = '';
                $step = '';

                $array = $metabox['options'];

                if( $array ) {
                    if( isset( $array['min'] ) && $array['min'] >= 0 ){
                        $min = ' min="'.(int)$array['min'].'"';
                    }
                    if( isset( $array['max'] ) && $array['max'] >= 0 ){
                        $max = ' max="'.(int)$array['max'].'"';
                    }
                    if( isset( $array['step'] ) && $array['step'] >= 0 ){
                        $step = ' step="'.(int)$array['step'].'"';
                    }
                }

                $add_class = ''; 
                $add_counter = '';
                if( 'seo' === $template_to_show ){
                    $add_class = 'words-count';
                    $add_counter = '<span class="counter">0 characters, 0 words</span>';
                }
                $output .= '<tr class="' . esc_attr( $row_css_class ) . '">';
                //$output .= '<th class="responsi-metabox-name"></th>';
                $output .= '<td><label class="responsi-metabox-name" for="' . esc_attr( $metaboxid ) . '">'.$metabox['label'].'</label><input class="responsi-metabox-input-text ' . esc_attr( $add_class ) . '" type="'.$metabox['type'].'" value="' . esc_attr( $metaboxvalue ) . '" name="'.$metaboxname.'" id="' . esc_attr( $metaboxid ) . '" '.$min.' '.$max.' '.$step.'/>';
                $output .= '<span class="responsi-metabox-desc">' . $metabox['desc'] . ' ' . $add_counter . '</span></td>';
                $output .= '</tr>';

            }elseif( 'text' === $metabox['type'] ) {

    	    	$add_class = ''; 
                $add_counter = '';
    	    	if( 'seo' === $template_to_show ){
                    $add_class = 'words-count';
                    $add_counter = '<span class="counter">0 characters, 0 words</span>';
                }
    	        $output .= '<tr class="' . esc_attr( $row_css_class ) . '">';
    	        //$output .= '<th class="responsi-metabox-name"></th>';
    	        $output .= '<td><label class="responsi-metabox-name" for="' . esc_attr( $metaboxid ) . '">'.$metabox['label'].'</label><input class="responsi-metabox-input-text ' . esc_attr( $add_class ) . '" type="'.$metabox['type'].'" value="' . esc_attr( $metaboxvalue ) . '" name="'.$metaboxname.'" id="' . esc_attr( $metaboxid ) . '"/>';
    	        $output .= '<span class="responsi-metabox-desc">' . $metabox['desc'] . ' ' . $add_counter . '</span></td>';
    	        $output .= '</tr>';

    	    } elseif ( 'textarea' === $metabox['type'] ) {

    	   		$add_class = '';
                $add_counter = '';
    	    	if( 'seo' === $template_to_show ){
                    $add_class = 'words-count';
                    $add_counter = '<span class="counter">0 characters, 0 words</span>';
                }
    	        $output .= '<tr class="' . esc_attr( $row_css_class ) . '">';
    	        //$output .= '<th class="responsi-metabox-name"></th>';
    	        $output .= '<td><label class="responsi-metabox-name" for="' . $metabox . '">' . $metabox['label'] . '</label><textarea class="responsi-metabox-input-textarea ' . esc_attr( $add_class ) . '" name="' . $metaboxname . '" id="' . esc_attr( $metaboxid ) . '">' . esc_textarea( stripslashes($metaboxvalue) ) . '</textarea>';
    	        $output .= '<span class="responsi-metabox-desc">'.$metabox['desc'] .' '. $add_counter.'</span></td>';
    	        $output .= '</tr>';

    	    } elseif ( 'select' === $metabox['type'] ) {

    	        $output .= '<tr class="' . esc_attr( $row_css_class ) . '">';
    	        //$output .= '<th class="responsi-metabox-name"></th>';
    	        $output .= '<td><label class="responsi-metabox-name" for="' . esc_attr( $metaboxid ) . '">' . $metabox['label'] . '</label><select class="responsi-metabox-select" id="' . esc_attr( $metaboxid ) . '" name="' . esc_attr( $metaboxname ) . '">';
    	        $output .= '<option value="">' . __( 'Select to return to default', 'responsi' ) . '</option>';

    	        $array = $metabox['options'];

    	        if( $array ) {

    	            foreach ( $array as $id => $option ) {
    	                $selected = '';

    	                if( isset( $metabox['default'] ) )  {
							if( $metabox['default'] == $option && empty( $metaboxvalue ) ) { 
                                $selected = 'selected="selected"';
                            } else  { 
                                $selected = '';
                            }
						}

    	                if( $metaboxvalue == $option ){ 
                            $selected = 'selected="selected"';
                        } else  { 
                            $selected = '';
                        }

    	                $output .= '<option value="' . esc_attr( $option ) . '" ' . $selected . '>' . $option . '</option>';
    	            }
    	        }

    	        $output .= '</select><span class="responsi-metabox-desc">' . $metabox['desc'] . '</span></td>';
    	        $output .= '</tr>';

    	    } elseif ( 'select2' === $metabox['type'] ) {

    	        $output .= '<tr class="' . esc_attr( $row_css_class ) . '">';
    	        //$output .= '<th class="responsi-metabox-name"></th>';
    	        $output .= '<td><label class="responsi-metabox-name" for="' . esc_attr( $metaboxid ) . '">' . $metabox['label'] . '</label><select class="responsi-metabox-select" id="' . esc_attr( $metaboxid ) . '" name="' . esc_attr( $metaboxname ) . '">';
    	        $output .= '<option value="">' . __( 'Select to return to default', 'responsi' ) . '</option>';

    	        $array = $metabox['options'];

    	        if( $array ) {

    	            foreach ( $array as $id => $option ) {
    	                $selected = '';

    	                if( isset( $metabox['default'] ) )  {
							if( $metabox['default'] == $id && empty( $metaboxvalue ) ) {
                                $selected = 'selected="selected"';
                            } else {
                                $selected = '';
                            }
						}

    	                if( $metaboxvalue == $id ) {
                            $selected = 'selected="selected"';
                        } else {
                            $selected = '';
                        }

    	                $output .= '<option value="'. esc_attr( $id ) .'" '. $selected .'>' . $option . '</option>';
    	            }
    	        }

    	        $output .= '</select><span class="responsi-metabox-desc">' . $metabox['desc'] . '</span></td>';
    	        $output .= '</tr>';

    	    } elseif ( 'checkbox' === $metabox['type'] ){

    	        if( $metaboxvalue == 'true' ) {
                    $checked = ' checked="checked"';
                } else {
                    $checked = '';
                }

    	        $output .= '<tr class="' . esc_attr( $row_css_class ) . '">';
    	        //$output .= '<th class="responsi-metabox-name"></th>';
    	        $output .= '<td><label class="responsi-metabox-name" for="' . esc_attr( $metaboxid ) . '">' . $metabox['label'] . '</label><input type="checkbox" '.$checked.' class="responsi-metabox-checkbox" value="true"  id="'.esc_attr( $metaboxid ).'" name="'. esc_attr( $metaboxname ) .'" />';
    	        $output .= '<span class="responsi-metabox-desc" style="display:inline">' . $metabox['desc'] . '</span></td>';
    	        $output .= '</tr>';
    	    
            } elseif ( 'radio' === $metabox['type'] ) {

                $array = $metabox['options'];

        	    if( $array ) {
            	    $output .= '<tr class="' . esc_attr( $row_css_class ) . '">';
            	    //$output .= '<th class="responsi-metabox-name"></th>';
            	    $output .= '<td><label class="responsi-metabox-name" for="' . esc_attr( $metaboxid ) . '">' . $metabox['label'] . '</label>';

        	        foreach ( $array as $id => $option ) {
        	            if( $metaboxvalue == $id ) {
                            $checked = ' checked';
                        } else {
                            $checked = '';
                        }

                        $output .= '<input type="radio" '.$checked.' value="' . $id . '" class="responsi-metabox-radio"  name="'. esc_attr( $metaboxname ) .'" />';
                        $output .= '<span class="responsi-metabox-radio-desc" style="display:inline">'. $option .'</span><div class="responsi-metabox-spacer"></div>';
                    }

                    $output .= '</tr>';
                }

            } elseif ( 'images' === $metabox['type'] ) {
                
                $i = 0;
    			$select_value = '';
    			$layout = '';

    			foreach ( $metabox['options'] as $key => $option ) {
    				$i++;
    				$checked = '';
    				$selected = '';
    				if( '' != $metaboxvalue ) {
    				    if ( $metaboxvalue == $key ) {
                            $checked = ' checked';
                            $selected = 'responsi-metabox-radio-img-selected';
                        }
    				} else {
    				 	if ( isset( $option['std'] ) && $key == $option['std'] ) {
                            $checked = ' checked';
                        } elseif ( $i === 1 ) {
                            $checked = ' checked';
                            $selected = 'responsi-metabox-radio-img-selected';
                        } else { 
                            $checked = ''; 
                        }
                    }
                    $layout .= '<div class="responsi-metabox-radio-img-label">';
    				$layout .= '<input type="radio" id="responsi-metabox-radio-img-' . $metaboxname . $i . '" class="checkbox responsi-metabox-radio-img-radio" value="' . esc_attr( $key ) . '" name="' . $metaboxname . '" ' . $checked . ' />';
    				$layout .= '&nbsp;' . esc_html($key) . '<div class="responsi-metabox-spacer"></div></div>';
    				$layout .= '<img src="' . esc_url( $option ) . '" alt="" class="responsi-metabox-radio-img-img '. $selected .'" onClick="document.getElementById(\'responsi-metabox-radio-img-'. esc_js( $metabox["name"] . $i ) . '\').checked = true;" />';
    			}

    			$output .= '<tr class="' . esc_attr( $row_css_class ) . '">';
    			//$output .= '<th class="responsi-metabox-name"></th>';
    			$output .= '<td class="responsi-metabox-fields"><label class="responsi-metabox-name" for="' . esc_attr( $metaboxid ) . '">' . $metabox['label'] . '</label>';
    			$output .= $layout;
    			$output .= '<span class="responsi-metabox-desc">' . $metabox['desc'] . '</span></td>';
        	    $output .= '</tr>';

    		} elseif( 'upload' === $metabox['type'] ) {
				if( isset( $metabox['default'] ) ){
                    $default = $metabox['default'];
                } else {
                    $default = '';
                }
    	    }
        }
    }
    $output .= '</table>';
    $output .= '</div><!--/#wf-tab-' . $token . '-->';

    return $output;
}

/**
 * responsi_metabox_handle()
 *
 * Handle the saving of the custom fields.
 *
 * @access public
 * @param int $post_id
 * @return void
 */
function responsi_metabox_handle( $post_id = '' ) {
    $pid = '';
    global $globals, $post;

    if ( isset($_POST['post_type']) && 'page' == $_POST['post_type'] ) {
        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return $post_id;
        }
    } else {
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return $post_id;
        }
    }

    $responsi_metaboxe_options = get_option( 'responsi_metaboxe_options', array() );

    // Sanitize post ID.
    if( isset( $_POST['post_ID'] ) ) {
		$pid = intval( $_POST['post_ID'] );
    }

    // Don't continue if we don't have a valid post ID.
    if ( $pid == 0 ) return;

    $upload_tracking = array();

    $responsi_custom_meta = array();

    if ( isset( $_POST['action'] ) && $_POST['action'] === 'editpost' ) {
        if ( ( get_post_type() !== '' ) && ( get_post_type() !== 'nav_menu_item' ) ) {

            foreach ( $responsi_metaboxe_options as $k => $metabox ) {
                if( isset( $metabox['type'] ) && ( in_array( $metabox['type'], responsi_metabox_fieldtypes() ) ) ) {
    				$var = $metabox['name'];
    			    $current_value = '';
    			    $current_value = get_post_meta( $pid, $var, true );
    				if ( isset( $_POST[$var] ) ) {
    					$posted_value = '';
    					$posted_value = $_POST[$var];

                        if( 'content_max_width' == $var ){
                            if( isset( $metabox['std'] ) && $metabox['std'] == $posted_value ){
                            }else{
                                if( get_post_meta( $pid, $var ) === '' ) {
                                    $responsi_custom_meta['content_max_width'] = $posted_value;
                                } elseif( $posted_value != get_post_meta( $pid, $var, true ) ) {
                                    $responsi_custom_meta['content_max_width'] = $posted_value;
                                } elseif( $posted_value === '' ) {
                                }
                            }
                            
                        }else{
        					if( get_post_meta( $pid, $var ) === '' ) {
        						add_post_meta( $pid, $var, $posted_value, true );
        					} elseif( $posted_value != get_post_meta( $pid, $var, true ) ) {
        						update_post_meta( $pid, $var, $posted_value );
        					} elseif( $posted_value === '' ) {
        						delete_post_meta( $pid, $var, get_post_meta( $pid, $var, true ) );
        					}
                        }
    				} elseif ( ! isset( $_POST[$var] ) && $metabox['type'] === 'checkbox' ) {
    					update_post_meta( $pid, $var, 'false' );
    				} else {
    					delete_post_meta( $pid, $var, $current_value );
    				}
                } else if ( $metabox['type'] === 'timestamp' ) {
                	
                    // Timestamp save logic.
                	// It is assumed that the data comes back in the following format:
    				// date: month/day/year
    				// hour: int(2)
    				// minute: int(2)
    				// second: int(2)

    				$var = $metabox['name'];

    				// Format the data into a timestamp.
    				$date = $_POST[$var]['date'];

    				$hour = $_POST[$var]['hour'];
    				$minute = $_POST[$var]['minute'];
    				// $second = $_POST[$var]['second'];
    				$second = '00';

    				$day = substr( $date, 3, 2 );
    				$month = substr( $date, 0, 2 );
    				$year = substr( $date, 6, 4 );

    				$timestamp = mktime( $hour, $minute, $second, $month, $day, $year );
    				update_post_meta( $pid, $var, $timestamp );

                } elseif( isset( $metabox['type'] ) && $metabox['type'] === 'upload' ) {
    				$id = $metabox['name'];
    				$override['action'] = 'editpost';
    			    if( !empty($_FILES['attachement_'.$id]['name']) ){
                        $_FILES['attachement_'.$id]['name'] = preg_replace( '/[^a-zA-Z0-9._\-]/', '', $_FILES['attachement_'.$id]['name']);
                        $uploaded_file = wp_handle_upload( $_FILES['attachement_' . $id ], $override );
    			        $uploaded_file['option_name'] = $metabox['label'];
                        $upload_tracking[] = $uploaded_file;
                        update_post_meta( $pid, $id, $uploaded_file['url'] );
    			    } elseif ( empty( $_FILES['attachement_'.$id]['name'] ) && isset( $_POST[ $id ] ) ) {
    					$posted_value = '';
    					$posted_value = $_POST[$id];
    			        update_post_meta( $pid, $id, $posted_value );
    			    } elseif ( $_POST[ $id ] === '' )  {
    			    	delete_post_meta( $pid, $id, get_post_meta( $pid, $id, true ) );
    			    }

    			}

                update_option( 'responsi_metabox_custom_upload_tracking', $upload_tracking );
            }

            if( count( $responsi_custom_meta ) > 0 ){
                update_post_meta( $pid, 'responsi_custom_meta', $responsi_custom_meta );
            } else {
                delete_post_meta( $pid, 'responsi_custom_meta', get_post_meta( $pid, 'responsi_custom_meta', true ) );
            }
        }
    }
}

/**
 * responsi_metabox_add()
 *
 * Add meta boxes for the ResponsiFramework's custom fields.
 *
 * @access public
 * @since 3.0.0
 * @return void
 */
function responsi_metabox_add() {
	$responsi_metaboxe_options = get_option( 'responsi_metaboxe_options', array() );
    if ( function_exists( 'add_meta_box' ) ) {
    	if ( function_exists( 'get_post_types' ) ) {
    		$custom_post_list = get_post_types();

			foreach ( $custom_post_list as $type ) {

				$settings = array(
					'id'               => 'responsi-metabox-settings',
					'title'            => __( 'Framework Custom Settings', 'responsi' ),
					'callback'         => 'responsi_metabox_create',
					'page'             => $type,
                    'context'          => 'side',
					'priority'         => 'low',
					'callback_args'    => array(
                        '__block_editor_compatible_meta_box'    => true,
                        '__back_compat_meta_box'                => false,
                    )
				);

				$settings = apply_filters( 'responsi_metaboxe_metabox_settings', $settings, $type, $settings['id'] );
				
                add_meta_box( 
                    $settings['id'], 
                    $settings['title'], 
                    $settings['callback'], 
                    $settings['page'], 
                    $settings['context'], 
                    $settings['priority'], 
                    $settings['callback_args']
                );
                
			}
    	}
    }
}

/**
 * responsi_metabox_fieldtypes()
 *
 * Return a filterable array of supported field types.
 *
 * @access public
 * @author Matty
 * @return void
 */
function responsi_metabox_fieldtypes() {
	return apply_filters( 'responsi_metabox_fieldtypes', array( 'text', 'calendar', 'time', 'time_masked', 'select', 'select2', 'radio', 'checkbox', 'textarea', 'images', 'slider' ) );
}

if ( ! function_exists( 'responsi_metabox_load_javascripts' ) ) {
    /**
     * responsi_metabox_load_javascripts()
     *
     * Enqueue JavaScript files used with the custom fields.
     *
     * @access public
     * @param string $hook
     * @since 2.6.0
     * @return void
     */
    function responsi_metabox_load_javascripts( $hook ) {
        if ( in_array( $hook, array( 'post.php', 'post-new.php', 'page-new.php', 'page.php', 'edit-tags.php','term.php', 'customize.php' ) ) ) {
            if ( is_rtl() ){
                global $responsi_version;
                wp_deregister_script('jquery-ui-slider');
                $suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
                wp_enqueue_script( 'jquery-ui-slider',          get_template_directory_uri() . '/functions/js/jquery.ui.slider.rtl' .$suffix . '.js',                                   array( 'jquery' ), $responsi_version, true );
        
            } else {
                wp_enqueue_script( 'jquery-ui-slider' );
            }
      		wp_enqueue_script( 'responsi-custom-fields' );
      	}
    }
}

if ( ! function_exists( 'responsi_metabox_load_styles' ) ) {
    /**
     * responsi_metabox_load_styles()
     *
     * Enqueue CSS files used with the custom fields.
     *
     * @access public
     * @author Matty
     * @since 4.8.0
     * @return void
     */
    function responsi_metabox_load_styles() {
    	global $pagenow;
    	if ( in_array( $pagenow, array( 'post.php', 'post-new.php', 'page-new.php', 'page.php', 'edit-tags.php','term.php', 'customize.php' ) ) ) {
    		wp_enqueue_style( 'responsi-icon' );
            if ( is_rtl() ){
                wp_enqueue_style( 'responsi-custom-fields-rtl' );
            }else{
                wp_enqueue_style( 'responsi-custom-fields' );
            }
           
    	}
    }
}

/*-----------------------------------------------------------------------------------*/
/* Addnew term page */
/*-----------------------------------------------------------------------------------*/

function responsi_taxonomy_add_new_meta_field(){
    global $responsi_options;

    $min = ' data-min="600"';
    $max = ' data-max="3000"';
    $step = ' data-step="1"';
    $content_max_width = isset($responsi_options['content_max_width']) ? $responsi_options['content_max_width'] : 1204;

    $responsi_metaboxe_options = get_option( 'responsi_metaboxe_options', array() );

    $metabox_content_max_width = array();

    if( is_array( $responsi_metaboxe_options ) ){
        foreach ($responsi_metaboxe_options as $key => $value) {
            if( is_array( $value ) && isset( $value['name'] ) && $value['name'] == 'content_max_width' ) {
                $metabox_content_max_width = $value;
            }
        }
    }

    if( is_array( $metabox_content_max_width ) ) {

        $array = $metabox_content_max_width['options'];

        if( isset( $array['min'] ) && $array['min'] >= 0 ){
            $min = ' data-min="'.(int)$array['min'].'"';
        }
        if( isset( $array['max'] ) && $array['max'] >= 0 ){
            $max = ' data-max="'.(int)$array['max'].'"';
        }
        if( isset( $array['step'] ) && $array['step'] >= 0 ){
            $step = ' data-step="'.(int)$array['step'].'"';
        }
        if( isset( $metabox_content_max_width['std'] ) && $metabox_content_max_width['std'] >= 0 ){
            $content_max_width = (int)$metabox_content_max_width['std'];
        }
    }
    ?>
    <div class="form-field">
        <label><strong><?php esc_attr_e('Maximun Content Width', 'responsi'); ?></strong></label>
        <div class="responsi-range-slider">
            <div class="ui-slide" id="<?php echo esc_attr($metabox_content_max_width['name']);?>_div"></div>
            <input type="text" readonly="readonly" id="responsi_custom_meta_term_content_max_width" name="responsi_custom_meta_term[<?php echo esc_attr($metabox_content_max_width['name']);?>]" value="<?php echo esc_attr($content_max_width);?>" class="responsi-input regular-text islide-value" <?php echo $min.$max.$step;?> />
        </div>
        <div style="clear: both;"></div>
        <p class="description"><?php esc_attr_e( 'Maximum content width in pixels in large screens.', 'responsi' );?></p>
    </div>
    <div style="clear: both;"></div>
    <?php
}

/*-----------------------------------------------------------------------------------*/
/* Edit term page */
/*-----------------------------------------------------------------------------------*/

function responsi_taxonomy_edit_meta_field( $term ){
    
    global $responsi_options;

    $responsi_custom_meta_term = get_term_meta( $term->term_id, 'responsi_custom_meta_term', true );

    $min = ' data-min="600"';
    $max = ' data-max="3000"';
    $step = ' data-step="1"';
    $content_max_width = isset($responsi_options['content_max_width']) ? $responsi_options['content_max_width'] : 1204;

    $responsi_metaboxe_options = get_option( 'responsi_metaboxe_options', array() );

    $metabox_content_max_width = array();

    if( is_array( $responsi_metaboxe_options ) ){
        foreach ($responsi_metaboxe_options as $key => $value) {
            if( is_array( $value ) && isset( $value['name'] ) && $value['name'] == 'content_max_width' ) {
                $metabox_content_max_width = $value;
            }
        }
    }

    if( is_array( $metabox_content_max_width ) ) {

        $array = $metabox_content_max_width['options'];

        if( isset( $array['min'] ) && $array['min'] >= 0 ){
            $min = ' data-min="'.(int)$array['min'].'"';
        }
        if( isset( $array['max'] ) && $array['max'] >= 0 ){
            $max = ' data-max="'.(int)$array['max'].'"';
        }
        if( isset( $array['step'] ) && $array['step'] >= 0 ){
            $step = ' data-step="'.(int)$array['step'].'"';
        }
        if( isset( $metabox_content_max_width['std'] ) && $metabox_content_max_width['std'] >= 0 ){
            $content_max_width = (int)$metabox_content_max_width['std'];
        }
    }

    if ( $responsi_custom_meta_term && isset( $responsi_custom_meta_term['content_max_width']) && $responsi_custom_meta_term['content_max_width'] >= 0 && $content_max_width != $responsi_custom_meta_term['content_max_width'] ) {
        $content_max_width = $responsi_custom_meta_term['content_max_width'];
    }

    ?>
    
    <tr class="form-field">
    <th scope="row" valign="top"><label for="responsi_custom_meta_term_content_max_width"><?php esc_attr_e('Maximun Content Width', 'responsi'); ?></label></th>
        <td>
        <div class="responsi-range-slider">
            <div class="ui-slide" id="<?php echo esc_attr($metabox_content_max_width['name']);?>_div"></div>
            <input type="text" readonly="readonly" id="responsi_custom_meta_term_content_max_width" name="responsi_custom_meta_term[<?php echo esc_attr($metabox_content_max_width['name']);?>]" value="<?php echo esc_attr($content_max_width);?>" class="responsi-input regular-text islide-value" <?php echo $min.$max.$step;?> />
        </div>
        <div style="clear: both;"></div>
        <p class="description"><?php esc_attr_e( 'Maximum content width in pixels in large screens.', 'responsi' );?></p>
        </td>
    </tr>
    <?php
}

/*-----------------------------------------------------------------------------------*/
/* Save extra taxonomy fields callback function. */
/*-----------------------------------------------------------------------------------*/

function responsi_save_taxonomy_custom_meta( $term_id ){

    if ( isset( $_POST['responsi_custom_meta_term'] ) ) {

        $responsi_custom_meta_term = array();

        $responsi_metaboxe_options = get_option( 'responsi_metaboxe_options', array() );

        $metabox_content_max_width = array();

        if( is_array( $responsi_metaboxe_options ) ){
            foreach ($responsi_metaboxe_options as $key => $value) {
                if( is_array( $value ) && isset( $value['name'] ) && $value['name'] == 'content_max_width' ) {
                    $metabox_content_max_width = $value;
                }
            }
        }

        if ( isset( $_POST['responsi_custom_meta_term']['content_max_width'] ) && isset( $metabox_content_max_width['std'] ) && $metabox_content_max_width['std'] != $_POST['responsi_custom_meta_term']['content_max_width'] ) {
            $responsi_custom_meta_term['content_max_width'] = $_POST['responsi_custom_meta_term']['content_max_width'];
        }

        if( count( $responsi_custom_meta_term ) > 0 ){
            update_term_meta( $term_id, 'responsi_custom_meta_term', $responsi_custom_meta_term );
        }else{
            delete_term_meta( $term_id, 'responsi_custom_meta_term' );
        }

    }else{
        delete_term_meta( $term_id, 'responsi_custom_meta_term' );
    }
}

/*-----------------------------------------------------------------------------------*/
/* Delete extra taxonomy fields callback function. */
/*-----------------------------------------------------------------------------------*/

function responsi_delete_taxonomy_custom_meta( $term_id ){
    delete_term_meta( $term_id, 'responsi_custom_meta_term' );
}

/*-----------------------------------------------------------------------------------*/
/* responsi_add_all_action_for_custom_taxonomy(). */
/*-----------------------------------------------------------------------------------*/

function responsi_add_all_action_for_custom_taxonomy(){
    if ( !is_admin() ){
        return;
    }
    $args       = array();
    $taxonomies = get_taxonomies($args, 'names');
    if ( $taxonomies ) {
        foreach ( $taxonomies as $taxonomy ) {
            $custom_taxonomy = $taxonomy;
            add_action( $custom_taxonomy . '_add_form_fields', 'responsi_taxonomy_add_new_meta_field', 10, 2 );
            add_action( $custom_taxonomy . '_edit_form_fields', 'responsi_taxonomy_edit_meta_field', 10, 2 );
            add_action( 'edited_' . $custom_taxonomy, 'responsi_save_taxonomy_custom_meta', 10, 2 );
            add_action( 'create_' . $custom_taxonomy, 'responsi_save_taxonomy_custom_meta', 10, 2 );
            add_action( 'delete_' . $custom_taxonomy, 'responsi_delete_taxonomy_custom_meta', 10, 2 );
        }
    }
}

add_action( 'init', 'responsi_add_all_action_for_custom_taxonomy' );

function responsi_custom_meta_post(){

    if ( is_admin() ) {
        return;
    }
    
    global $wp_query, $responsi_custom_meta_type, $post, $responsi_custom_meta;

    $post_id = 0;

    $meta_type = 'responsi_custom_meta';

    if ( isset( $wp_query->queried_object_id ) && $wp_query->queried_object_id > 0 ) {
        if ( isset( $wp_query->queried_object->term_id ) ) {
            $post_id = $wp_query->queried_object->term_id;
            $meta_type = 'responsi_custom_meta_term';
        }
    }

    if( is_singular() && $post->ID ){
        $post_id = $post->ID;
    }

    $post_id = apply_filters( 'responsi_custom_meta_post_id' , $post_id );

    $responsi_custom_meta_type = array(
        'post_id' => $post_id,
        'meta_type' => $meta_type
    );

}

add_action( 'responsi_head', 'responsi_custom_meta_post', 1 );

/**
 * Specify action hooks for the functions above.
 *
 * @access public
 * @since 3.0.0
 * @return void
 */
add_action( 'admin_init', 'responsi_metabox_options', 1 );
add_action( 'admin_enqueue_scripts', 'responsi_metabox_load_javascripts', 10, 1 );
add_action( 'admin_print_styles', 'responsi_metabox_load_styles', 10 );
add_action( 'edit_post', 'responsi_metabox_handle', 10 );
add_action( 'admin_init', 'responsi_metabox_add', 10 );

?>
