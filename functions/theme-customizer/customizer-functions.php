<?php
if ( ! function_exists( 'responsi_custom_control_settings' ) ) {
    function responsi_custom_control_settings( $id, $type, $options = array() ) {
        $settings = array();
        if( '' !== $id && '' !== $type ){
            switch ( $type ) {
                case "ibackground":
                    $settings = array( $id.'[onoff]' => $id.'[onoff]', $id.'[color]' => $id.'[color]');
                    break;
                case "border":
                    $settings = array( $id.'[width]' => $id.'[width]', $id.'[style]' => $id.'[style]', $id.'[color]' => $id.'[color]' );
                    break;
                case "border_radius":
                    $settings = array( $id.'[corner]' => $id.'[corner]', $id.'[rounded_value]' => $id.'[rounded_value]');
                    break;
                case "box_shadow":
                    $settings = array( $id.'[onoff]' => $id.'[onoff]', $id.'[h_shadow]' => $id.'[h_shadow]', $id.'[v_shadow]' => $id.'[v_shadow]', $id.'[blur]' => $id.'[blur]', $id.'[spread]' => $id.'[spread]', $id.'[color]' => $id.'[color]', $id.'[inset]' => $id.'[inset]');
                    break;
                case "typography":
                    $settings = array( $id.'[size]' => $id.'[size]', $id.'[line_height]' => $id.'[line_height]', $id.'[face]' => $id.'[face]', $id.'[style]' => $id.'[style]', $id.'[color]' => $id.'[color]');
                    break;
                case "multitext":
                    foreach ( $options['choices'] as $key => $value) {
                        $settings[$id.'_'.$key] = $id.'_'.$key;
                    }
                    break;
                case "imulticheckbox":
                    foreach ( $options['choices'] as $key => $value) {
                        $settings[$id.'_'.$key] = $id.'_'.$key;
                    }
                    break;
                default:
                    $settings = array( $id.'[width]' => $id.'[width]', $id.'[style]' => $id.'[style]', $id.'[color]' => $id.'[color]' );
                    break;
            }
        }
        return $settings;
    }
}

if ( ! function_exists( 'responsi_sanitize_numeric' ) ) {
    function responsi_sanitize_numeric( $value, $setting ) {
        if ( is_numeric( $value ) ) {
            return $value;
        } 
    }
}

if ( ! function_exists( 'responsi_sanitize_background_position' ) ) {
    function responsi_sanitize_background_position( $value, $setting ) {
        if( strripos( $value, 'px', strlen( $value )-2 ) || strripos( $value, 'em', strlen( $value )-2 ) || strripos( $value, 'rem', strlen( $value )-3 ) || strripos( $value, '%', strlen( $value )-1 ) ){
            $_value = array( 'px', 'em', 'rem', '%' );
            foreach( $_value as $v ){
                $_v = explode( $v, $value );
                if( is_array($_v) && 2 === count($_v) && is_numeric($_v[0]) ) {
                    return sanitize_text_field( $value );
                }
            }
        }elseif ( in_array( strtolower( $value ), array( 'top', 'bottom', 'left', 'right', 'center', 'inherit', 'initial' ) ) ){
            return sanitize_text_field( $value );
        }
    }
}

if ( ! function_exists( 'responsi_sanitize_background_size' ) ) {
    function responsi_sanitize_background_size( $value, $setting ) {
        if( strripos( $value, 'px', strlen( $value )-2 ) || strripos( $value, 'em', strlen( $value )-2 ) || strripos( $value, 'rem', strlen( $value )-3 ) || strripos( $value, '%', strlen( $value )-1 ) ){
            $_value = array( 'px', 'em', 'rem', '%' );
            foreach( $_value as $v ){
                $_v = explode( $v, $value );
                if( is_array($_v) && 2 === count($_v) && intval($_v[0]) >= 0 ) {
                    return sanitize_text_field( $value );
                }
            }
        }elseif ( in_array( strtolower( $value ), array( 'cover', 'contain', 'inherit', 'initial', 'auto' ) ) ){
            return sanitize_text_field( $value );
        }
    }
}

if ( ! function_exists( 'responsi_sanitize_background_color' ) ) {
    function responsi_sanitize_background_color( $value, $setting ) {
        $keys = preg_split( '/\[/', str_replace( ']', '', $setting->id ) );
        if ( is_array($keys) && count($keys) > 0 && isset($keys[1]) ){
            if( 'color' === $keys[1] ){
                return sanitize_hex_color( $value );
            }elseif( 'onoff' === $keys[1] ){
                return $value;
            }
        }
    }
}

if ( ! function_exists( 'responsi_sanitize_background_patterns' ) ) {
    function responsi_sanitize_background_patterns( $value, $setting ) {
        return esc_url( $value );
    }
}

if ( ! function_exists( 'responsi_sanitize_border' ) ) {
    function responsi_sanitize_border( $value, $setting ) {
        $keys = preg_split( '/\[/', str_replace( ']', '', $setting->id ) );
        if ( is_array($keys) && count($keys) > 0 && isset($keys[1]) ){
            if( 'color' === $keys[1] ){
                return sanitize_hex_color( $value );
            }elseif(  'style' === $keys[1] ){
                return $value;
            }elseif( 'width' === $keys[1] ){
                return $value;
            }
        }
    }
}

if ( ! function_exists( 'responsi_sanitize_border_radius' ) ) {
    function responsi_sanitize_border_radius( $value, $setting ) {
        $keys = preg_split( '/\[/', str_replace( ']', '', $setting->id ) );
        if ( is_array($keys) && count($keys) > 0 && isset($keys[1]) ){
            if( 'corner' === $keys[1] ){
                return $value;
            }elseif( 'rounded_value' === $keys[1] ){
                if ( is_numeric( $value ) ) {
                    return $value;
                }
            }
        }
    }
}

if ( ! function_exists( 'responsi_sanitize_box_shadow' ) ) {
    function responsi_sanitize_box_shadow( $value, $setting ) {
        $keys = preg_split( '/\[/', str_replace( ']', '', $setting->id ) );
        if ( is_array($keys) && count($keys) > 0 && isset($keys[1]) ){
            if( 'color' === $keys[1] ){
                return sanitize_hex_color( $value );
            }elseif( 'onoff' === $keys[1] ){
                return $value;
            }elseif( 'h_shadow' === $keys[1] ){
                return $value;
            }elseif( 'v_shadow' === $keys[1] ){
                return $value;
            }elseif( 'blur' === $keys[1] ){
                return $value;
            }elseif( 'spread' === $keys[1] ){
                return $value;
            }elseif( 'inset' === $keys[1] ){
                return $value;
            }elseif( 'color' === $keys[1] ){
                return sanitize_hex_color( $value );
            }
        }
    }
}

if ( ! function_exists( 'responsi_sanitize_typography' ) ) {
    function responsi_sanitize_typography( $value, $setting ) {
        $keys = preg_split( '/\[/', str_replace( ']', '', $setting->id ) );
        if ( is_array($keys) && count($keys) > 0 && isset($keys[1]) ){
            if( 'color' === $keys[1] ){
                return sanitize_hex_color( $value );
            }elseif( 'size' === $keys[1] ){
                return $value;
            }elseif( 'line_height' === $keys[1] ){
                return $value;
            }elseif( 'face' === $keys[1] ){
                return $value;
            }elseif( 'style' === $keys[1] ){
                return $value;
            }elseif( 'color' === $keys[1] ){
                return sanitize_hex_color( $value );
            }
        }
    }
}

if ( ! function_exists( 'responsi_sanitize_slider' ) ) {
    function responsi_sanitize_slider( $value , $setting ) {
        if ( is_numeric( $value ) ) {
            return $value;
        }
    }
}

if ( ! function_exists( 'responsi_sanitize_choices' ) ) {
    function responsi_sanitize_choices( $value, $setting ) {
        $value = sanitize_key( $value );
        $choices = $setting->manager->get_control( $setting->id )->choices;
        return ( array_key_exists( $value, $choices ) ? $value : $setting->default );
    }
}

if ( ! function_exists( 'responsi_sanitize_checkboxs' ) ) {
    function responsi_sanitize_checkboxs( $value, $setting ) {
        $value = sanitize_key( $value );
        $choices = $setting->manager->get_control( $setting->id )->choices;
        return ( in_array( $value, $choices ) ? $value : $setting->default );
    }
}

if ( ! function_exists( 'responsi_sanitize_multicheckboxs' ) ) {
    function responsi_sanitize_multicheckboxs( $value, $setting ) {
        $value = sanitize_key( $value );
        if( 'true' === $value ){
            return 'true';
        }else{
            return 'false';
        }
        return $setting->default;
    }
}

if ( ! function_exists( 'responsi_sanitize_layout_width' ) ) {
    function responsi_sanitize_layout_width( $value, $setting ) {
        if ( $value >= 600 && $value <= 3000 && is_numeric( $value ) ){
        	return absint($value);
        }
    }
}

if ( ! function_exists( 'responsi_sanitize_ieditor' ) ) {
    function responsi_sanitize_ieditor( $value, $setting ) {
        return wp_kses_post( $value );
    }
}

if ( ! function_exists( 'responsi_sanitize_textarea' ) ) {
    function responsi_sanitize_textarea( $value, $setting ) {
        $value = wp_kses_post( $value );
        return $value;
    }
}

if ( ! function_exists( 'responsi_sanitize_textarea_esc_html' ) ) {
    function responsi_sanitize_textarea_esc_html( $value, $setting ) {
        $value = htmlspecialchars_decode( strip_tags( wp_kses_post( $value ) ) );
        return $value;
    }
}
?>
