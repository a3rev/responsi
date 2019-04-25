<?php
// File Security Check
if (!defined('ABSPATH'))
    exit;

/*-----------------------------------------------------------------------------------*/
/* responsi_get_template */
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'responsi_get_template' ) ) {
    function responsi_get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {

        if ( $args && is_array($args) ){
            extract($args);
        }

        $located = responsi_locate_template( $template_name, $template_path, $default_path );

        do_action( 'responsi_get_template_before', $template_name, $template_path, $located, $args );

        load_template( $located, false );

        do_action( 'responsi_get_template_after', $template_name, $template_path, $located, $args );
    }
}

/*-----------------------------------------------------------------------------------*/
/* responsi_locate_template */
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'responsi_locate_template' ) ) {
    function responsi_locate_template( $template_name, $template_path = '', $default_path = '' ) {
        global $woocommerce;
        
        if ( !$template_path ){
            $template_path = get_stylesheet_directory();
        }
        
        if ( !$default_path ){
            $default_path = get_stylesheet_directory();
        }

        // Look within passed path within the theme - this is priority
        $template = locate_template( array(
            trailingslashit($template_path) . $template_name,
            $template_name
        ));

        // Get default template
        if ( !$template ){
            $template = $default_path . $template_name;
        }

        // Return what we found
        return apply_filters( 'responsi_locate_template', $template, $template_name, $template_path );
    }
}


/*-----------------------------------------------------------------------------------*/
/* dynamic sidebar */
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'responsi_dynamic_sidebar' ) ) {
    function responsi_dynamic_sidebar( $id = 1 ) {
        $id = apply_filters( 'responsi_dynamic_sidebar', $id );
        return dynamic_sidebar( $id );
    }
}

if ( ! function_exists( 'responsi_active_sidebar' ) ) {
    function responsi_active_sidebar( $id ) {
        $id = apply_filters( 'responsi_active_sidebar', $id );
        if( is_active_sidebar( $id ) ){
            return true;
        }
        return false;
    }
}

/*-----------------------------------------------------------------------------------*/
/* responsi_format_css() */
/*-----------------------------------------------------------------------------------*/
function responsi_format_css( $content ) {
    $content = str_replace( ':;', ': transparent;', $content );
    $content = str_replace( ': ;', ': transparent;', $content );
    $content = str_replace( ': !important', ': transparent !important', $content );
    $content = str_replace( ':px', ':0px', $content );
    $content = str_replace( ': px', ': 0px', $content );
    $content = str_replace( "){", "){\n", $content );
    $content = str_replace( "(.lazy-hidden){\n", "(.lazy-hidden){", $content );
    $content = preg_replace( "/\s*}/", "}\n", $content );
    return $content;
}

/*-----------------------------------------------------------------------------------*/
/* responsi_minify_css() */
/*-----------------------------------------------------------------------------------*/
function responsi_minify_css( $content )
{
    $content = responsi_format_css( $content );
    $content = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $content );
    $content = str_replace( ["\r\n","\r","\n","\t",'  ','    ','     '], '', $content );
    $content = str_replace( " !important", '!important', $content );
    $content = preg_replace( ['(( )+{)','({( )+)'], '{', $content );
    $content = preg_replace( ['(( )+})','(}( )+)','(;( )*})'], '}', $content );
    $content = preg_replace( ['(;( )+)','(( )+;)'], ';', $content );
    $content = str_replace( " : ", ':', $content );
    $content = str_replace( ": ", ':', $content );
    $content = str_replace( " :", ':', $content );
    $content = str_replace( "( ", '(', $content );
    $content = str_replace( " )", ')', $content );
    return $content;
}

/*-----------------------------------------------------------------------------------*/
/* responsi_unminify_css() */
/*-----------------------------------------------------------------------------------*/
function responsi_unminify_css( $content ) {
    $comments = array(
        "`^([\t\s]+)`ism" => '',
        "`^\/\*(.+?)\*\/`ism" => "",
        "`([\n\A;]+)\/\*(.+?)\*\/`ism" => "$1",
        "`([\n\A;\s]+)//(.+?)[\n\r]`ism" => "$1\n",
        "`(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+`ism" => "\n"
    );
    $content = preg_replace( array_keys( $comments ), $comments, $content );
    // add a space before opening braces and a tab after
    $content = preg_replace( "/\s*{\s*/", " {\n\t", $content );
    // add a newline and a tab after each colon
    $content = preg_replace( "/;\s*/", ";\n\t", $content );
    // add a newline before and after closing braces
    $content = preg_replace( "/\s*}/", "\n}\n", $content );
    return $content;
}

/*-----------------------------------------------------------------------------------*/
/* responsi_dynamic_css() */
/*-----------------------------------------------------------------------------------*/
function responsi_dynamic_css( $type = 'framework' ) {
    
    if ( 'developer' === $type || '' === $type )
        return;
    
    $dynamic_css      = '';
    if ( 'framework' === $type ) {
        $dynamic_css = responsi_build_dynamic_css();
    }
    if ( '' !== $dynamic_css ) {
        set_theme_mod( $type . '_custom_css', $dynamic_css );
    }
}

/*-----------------------------------------------------------------------------------*/
/* Register Google Webfonts */
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'responsi_register_webfonts' ) ) {
    function responsi_register_webfonts() {
        global $responsi_version;
        $suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

        $urls = responsi_google_webfonts();

        if( '' !== $urls ){
            wp_register_style( 'google-fonts', esc_url( $urls ) , array(), $responsi_version, 'screen'  );
        }

    }
}

/*-----------------------------------------------------------------------------------*/
/* Google Webfonts Stylesheet Generator */
/*-----------------------------------------------------------------------------------*/
if ( !function_exists('responsi_google_webfonts') ) {
    function responsi_google_webfonts() {
        global $responsi_options, $google_fonts;

        $fonts  = '';
        $urls = '';

        if( !is_array( $responsi_options ) ){
            $responsi_options_webfonts = responsi_default_options();
        }else{
            $responsi_options_webfonts = $responsi_options;
        }

        $responsi_options_webfonts = apply_filters( 'responsi_google_webfonts', $responsi_options_webfonts );

        $list_fonts = array();

        // Go through the options
        if ( !empty( $responsi_options_webfonts ) ) {
            foreach ( $responsi_options_webfonts as $option ) {
                // Check if option has "face" in array
                if ( is_array( $option ) && isset( $option['face'] ) ) {
                    // Check if the google font name exists in the current "face" option
                    if ( array_key_exists( $option['face'], $google_fonts ) && !strstr( $fonts, $option['face'] ) ) {
                        $fonts .= $option['face'] . $google_fonts[$option['face']]['variant'] . "|";
                        $list_fonts[] = $option['face'];
                    }
                }
            }

            // Output google font css in header
            if ( trim( $fonts ) != '' ) {
                $fonts = str_replace( " ", "+", $fonts );
                $urls = 'https://fonts.googleapis.com/css?family=' . str_replace( "%2B",'+',urlencode( $fonts ) );
                $urls = str_replace( '|"', '"', $urls );
            }
        }
        return $urls;
    }
}

/*-----------------------------------------------------------------------------------*/
/* responsi_get_attachment_id_by_url */
/*-----------------------------------------------------------------------------------*/
function responsi_get_attachment_id_by_url( $url ) {
    $attachment_id = 0;
    $dir = wp_upload_dir();
    if ( false !== strpos( $url, $dir['baseurl'] . '/' ) ) { // Is URL in uploads directory?
        $file = basename( $url );
        $query_args = array(
            'post_type'   => 'attachment',
            'post_status' => 'inherit',
            'fields'      => 'ids',
            'meta_query'  => array(
                array(
                    'value'   => $file,
                    'compare' => 'LIKE',
                    'key'     => '_wp_attachment_metadata',
                ),
            )
        );
        $query = new WP_Query( $query_args );
        if ( $query->have_posts() ) {
            foreach ( $query->posts as $post_id ) {
                $meta = wp_get_attachment_metadata( $post_id );
                $original_file       = basename( $meta['file'] );
                $cropped_image_files = wp_list_pluck( $meta['sizes'], 'file' );
                if ( $original_file === $file || in_array( $file, $cropped_image_files ) ) {
                    $attachment_id = $post_id;
                    break;
                }
            }
        }
    }
    return $attachment_id;
}

/*-----------------------------------------------------------------------------------*/
/* Responsi get thumbnail */
/*-----------------------------------------------------------------------------------*/

function responsi_get_thumbnail( $args = array() ) {
    global $post, $responsi_options;

    $default = array(
        'class' => 'responsi_img',
        'type' => 'image',
        'return' => false,
        'size' => 'medium',
        'id' => '',
        'style' => ''
    );

    if ( !is_array( $args ) )
        parse_str( $args, $args );

    $args = array_merge( $default, $args );

    extract( $args );

    if ( empty( $id ) ) {
        $id = $post->ID;
    }

    $size_attr = false;
    if ( isset( $width ) && isset( $height ) ) {
        $size           = array(
            $width,
            $height
        );
        $size_attr = true;
    }

    $width_height_attr = '';
    if( $size_attr ){
        $width_height_attr = ' width="'.$size[0].'" height="'.$size[1].'"';
    }

    $_thumbnail_src = '';
    $_thumbnail_image = '';
    $alt = '';
    $style_ext = '';

    if ( has_post_thumbnail( $id ) ) {
        if( 'image' === $type ){
            $_thumbnail_image         = get_the_post_thumbnail( $id, $size, array( 'class' => $class, 'style' => $style, 'alt' => the_title_attribute( 'echo=0' ) )) ;
        }elseif( 'src' === $type ){
            $_thumbnail_id      = get_post_thumbnail_id( $id );
            $_thumbnail_info    = wp_get_attachment_image_src( $_thumbnail_id, $size );
            $_thumbnail_src     = $_thumbnail_info[0];
        }
    } else {
        
        $post = get_post( $id );
        $alt = '';
        ob_start();
        ob_end_clean();
        $output = preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches );
        if ( !empty( $matches[1][0] ) ) {
            $_thumbnail_src = esc_url( $matches[1][0] );
            $output = preg_match_all( '/<img.+alt=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches );
            if ( !empty($matches[1][0] ) ) {
                $alt = esc_attr( $matches[1][0] );
            }
            $output = preg_match_all( '/<img.+class=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches );
            if ( !empty( $matches[1][0] ) ) {
                $attr_class = str_replace( 'alignleft', "", $matches[1][0] );
                $attr_class = str_replace( 'alignright', "", $attr_class );
                $attr_class = str_replace( 'alignnone', "", $attr_class );
                $attr_class = str_replace( 'aligncenter', "", $attr_class );
                $class .= ' '.esc_attr( $attr_class );
            }

            if( 'image' === $type ){
                if( $style ){
                    $style_ext = ' style="' . esc_attr( $style ) . '"';
                }
                $_thumbnail_image = '<img class="' . esc_attr( stripslashes( trim($class ) ) ) . '"' . $style_ext . ' src="' . esc_url( $_thumbnail_src ) . '" alt="' . esc_attr( $alt ) . '"'.$width_height_attr.'>';
            }elseif( 'src' === $type ){
                $_thumbnail_src = $_thumbnail_src;
            }

        } else {
            $pattern = '/<if' . 'rame.+src=[\'"]([^\'"]+)[\'"].*>/i';
            $output  = preg_match_all( $pattern, $post->post_content, $matches );
            if ( !empty( $matches[1][0] ) ) {
                $_thumbnail_src = esc_url( responsi_get_video_image( esc_url( $matches[1][0] ) ) );
                if( 'image' === $type ){
                    if( $style ){
                        $style_ext = ' style="' . esc_attr( $style ) . '"';
                    }
                    $_thumbnail_image = '<img class="' . esc_attr( stripslashes( trim($class ) ) ) . '"' . $style_ext . ' src="' . esc_url( $_thumbnail_src ) . '" alt="' . esc_attr( $alt ) . '"'.$width_height_attr.'>';
                }elseif( 'src' === $type ){
                    $_thumbnail_src = $_thumbnail_src;
                }
            }else{
                $pattern = responsi_parse_yturl_pattern();
                $output  = preg_match_all( $pattern, $post->post_content, $matches );
                if ( !empty( $matches[1][0] ) ) {
                    $_thumbnail_src = "http://img.youtube.com/vi/" . urlencode($matches[1][0]) . "/0.jpg";
                    if( 'image' === $type ){
                        if( $style ){
                            $style_ext = ' style="' . esc_attr( $style ) . '"';
                        }
                        $_thumbnail_image = '<img class="' . esc_attr( stripslashes( trim($class ) ) ) . '"' . $style_ext . ' src="' . esc_url( $_thumbnail_src ) . '" alt="' . esc_attr( $alt ) . '"'.$width_height_attr.'>';
                    }elseif( 'src' === $type ){
                        $_thumbnail_src = esc_url( $_thumbnail_src );
                    }
                }
            }
        }
    }

    if ( '' === trim( $_thumbnail_src ) && '' === trim( $_thumbnail_image ) ){
        $_thumbnail_src = responsi_get_placeholder_image();
        if( 'image' === $type ){
            if( $style ){
                $style_ext = ' style="' . esc_attr( $style ) . '"';
            }
            if( '' === $width_height_attr )
                $width_height_attr = responsi_get_image_attribute( esc_url($_thumbnail_src ) );
            $_thumbnail_image = '<img class="' . esc_attr( stripslashes( trim( $class ) ) ) . '"' . $style_ext . ' src="' . esc_url( $_thumbnail_src ) . '" alt="'.__( 'No Image', 'responsi' ).'"'.$width_height_attr.'>';
        } elseif ( 'src' === $type ){
            $_thumbnail_src = esc_url( $_thumbnail_src );
        }
    }

    if ( $return ){
        if( 'image' === $type ){
            return $_thumbnail_image;
        }elseif( 'src' === $type ){
            return $_thumbnail_src;
        }
    } else {
        if( 'image' === $type ){
            echo $_thumbnail_image;
        }elseif( 'src' === $type ){
            echo $_thumbnail_src;
        }
    }
}

function responsi_parse_yturl_pattern() {
    $pattern = '#^(?:https?://)?';    # Optional URL scheme. Either http or https.
    $pattern .= '(?:www\.)?';         #  Optional www subdomain.
    $pattern .= '(?:';                #  Group host alternatives:
    $pattern .=   'youtu\.be/';       #    Either youtu.be,
    $pattern .=   '|youtube\.com';    #    or youtube.com
    $pattern .=   '(?:';              #    Group path alternatives:
    $pattern .=     '/embed/';        #      Either /embed/,
    $pattern .=     '|/v/';           #      or /v/,
    $pattern .=     '|/watch\?v=';    #      or /watch?v=,    
    $pattern .=     '|/watch\?.+&v='; #      or /watch?other_param&v=
    $pattern .=   ')';                #    End path alternatives.
    $pattern .= ')';                  #  End host alternatives.
    $pattern .= '([\w-]{11})';        # 11 characters (Length of Youtube video ids).
    $pattern .= '(?:.+)?$#x';         # Optional other ending URL parameters.
    return $pattern;
}

/*-----------------------------------------------------------------------------------*/
/* Get thumbnail from Video Embed code */
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'responsi_get_video_image' ) ) {
    function responsi_get_video_image( $embed ) {
        $video_thumb = '';

        // YouTube - get the video code if this is an embed code (old embed)
        preg_match( '/youtube\.com\/v\/([\w\-]+)/', $embed, $match );

        // YouTube - if old embed returned an empty ID, try capuring the ID from the new frame embed
        if ( !isset( $match[1] ) )
            preg_match('/youtube\.com\/embed\/([\w\-]+)/', $embed, $match );

        // YouTube - if it is not an embed code, get the video code from the youtube URL
        if ( !isset( $match[1] ) )
            preg_match( '/v\=(.+)&/', $embed, $match );

        // YouTube - get the corresponding thumbnail images
        if ( isset( $match[1] ) )
            $video_thumb = "http://img.youtube.com/vi/" . urlencode( $match[1] ) . "/0.jpg";

        // return whichever thumbnail image you would like to retrieve
        return $video_thumb;
    }
}

/*-----------------------------------------------------------------------------------*/
/* Show image in RSS feed */
/* Original code by Justin Tadlock */
/*-----------------------------------------------------------------------------------*/

function responsi_image_rss( $content ) {
    global $post, $id;
    if ( !is_feed() )
        return $content;

    $image       = responsi_get_thumbnail( 'return=false&type=src&width=240&height=240' );
    $image_width = '240';
    // If there's an image, display the image with the content
    if ( '' !== $image ) {
        $content = strip_tags( strip_shortcodes( $content ), apply_filters( 'responsi_get_the_content_allowedtags', '<script>,<style>' ) );
        // Inline styles/scripts
        $content = trim( preg_replace('#<(s(cript|tyle)).*?</\1>#si', '', $content ) );
        $exclude_codes = 'remove_all_miss_shortcode';
        $content       = preg_replace("~(?:\[/?)(?!(?:$exclude_codes))[^/\]]+/?\]~s", '', $content );
        $content       = '<p style="float:right; margin:0 0 10px 15px; width:' . esc_attr( $image_width ) . 'px;"><img src="' . esc_url( $image ) . '" width="' . esc_attr( $image_width ) . '" alt=""></p>' . $content;
        return $content;
    } else {
        return $content;
    }
}

function responsi_filter_image_rss(){
    global $responsi_options;
    if ( is_array( $responsi_options ) && isset( $responsi_options['responsi_rss_thumb'] ) && 'true' === $responsi_options['responsi_rss_thumb'] ) {
        add_filter( 'the_excerpt_rss', 'responsi_image_rss' );
        add_filter( 'the_content', 'responsi_image_rss' );
    }
}

/*-----------------------------------------------------------------------------------*/
/* Responsi get image size */
/*-----------------------------------------------------------------------------------*/
function responsi_get_image_attribute( $url ) {
    $width_height_attr = '';
    $home    = set_url_scheme( home_url(), 'http' );
    $siteurl = set_url_scheme( get_site_url(), 'http' );

    if ( ! empty( $home ) && 0 !== strcasecmp( $home, $siteurl ) ) {
        $wp_path_rel_to_home = str_ireplace( $home, '', $siteurl ); /* $siteurl - $home */
        $pos = strripos( str_replace( '\\', '/', $_SERVER['SCRIPT_FILENAME'] ), trailingslashit( $wp_path_rel_to_home ) );
        $home_path = substr( $_SERVER['SCRIPT_FILENAME'], 0, $pos );
        $home_path = trailingslashit( $home_path );
    } else {
        $home_path = ABSPATH;
    }

    $home_path = str_replace( '\\', '/', $home_path );

    $file_path = str_replace( $siteurl.'/', $home_path , $url );

    if( file_exists( $file_path ) ){
        $size = @getimagesize( $file_path );
        if( is_array( $size ) ){
            $width_height_attr = ' width="'.$size[0].'" height="'.$size[1].'"';
        }
    }

    return $width_height_attr;
}

/*-----------------------------------------------------------------------------------*/
/* responsi_send_no_xss_protection_header() */
/*-----------------------------------------------------------------------------------*/

function responsi_send_no_xss_protection_header( $headers, $object ) {
    if ( is_customize_preview() ){
        $headers['X-XSS-Protection'] = 0;
    }
    return $headers;
}

/*-----------------------------------------------------------------------------------*/
/* responsi_pagination() - Custom loop pagination function  */
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'responsi_pagination' ) ) {
    function responsi_pagination( $args = array() ) {
        global $wp_query, $wp_rewrite;

        do_action('responsi_pagination_start');

        if ( $wp_query->max_num_pages < 2 ) {
            return;
        }

        $paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
        $pagenum_link = html_entity_decode( get_pagenum_link() );
        $query_args   = array();
        $url_parts    = explode( '?', $pagenum_link );

        if ( isset( $url_parts[1] ) ) {
            wp_parse_str( $url_parts[1], $query_args );
        }

        $pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
        $pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

        $format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
        $format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';

        $defaults = apply_filters( 'responsi_pagination_args', array(
            'base'     => $pagenum_link,
            'format'   => $format,
            'total'    => $wp_query->max_num_pages,
            'current'  => $paged,
            'mid_size' => 1,
            'add_args' => array_map( 'urlencode', $query_args ),
            'prev_text' => __( '&larr; Previous', 'responsi' ),
            'next_text' => __( 'Next &rarr;', 'responsi' ),
            'prev_next' => false,
            'show_all' => true,
            'end_size' => 1,
            'mid_size' => 1,
            'add_fragment' => '',
            'type' => 'plain',
            'echo' => true,
            'use_search_permastruct' => true
        ) );

        $args = wp_parse_args( $args, $defaults );

        $links = paginate_links( $args );

        $paginate_links = '';

        if ( $links ) {
            $paginate_links = '<div class="pagination responsi-pagination clearfix" role="navigation">' . $links . '</div>';
        }

        $paginate_links = apply_filters( 'responsi_pagination', $paginate_links );

        do_action( 'responsi_pagination_end' );

        if ( $args['echo'] )
            echo $paginate_links;
        else
            return $paginate_links;
    }
}

/*-----------------------------------------------------------------------------------*/
/* responsi_custom_breadcrumbs() - Custom breadcrumb generator function  */
/*-----------------------------------------------------------------------------------*/

function responsi_custom_breadcrumbs() {

    global $wp_query, $wp_rewrite, $responsi_options;

    if ( !isset($responsi_options['responsi_breadcrumbs_show']) || 'true' !== $responsi_options['responsi_breadcrumbs_show'] ) {
        return;
    }
       
    // Settings
    $separator          = '&gt;';
    $breadcrums_id      = 'breadcrumbs';
    $breadcrums_class   = 'breadcrumb breadcrumbs responsi-breadcrumbs';
    $home_title         = __('Home', 'responsi');
      
    // If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
    $custom_taxonomy    = "{$wp_query->post->post_type}_cat";
       
    // Get the query & post information
    global $post,$wp_query,$prefix;
       
    // Do not display on the homepage
    if ( !is_front_page() ) {
       
        // Build the breadcrums
        echo '<div id="' . $breadcrums_id . '" class="' . $breadcrums_class . '"><div class="breadcrumb-trail">';
           
        // Home page
        echo '<a href="' . esc_url( home_url() ) . '" title="' . esc_attr( get_bloginfo( 'name' ) ) . '" rel="home" class="trail-begin">' . $home_title . '</a>';
        echo '<span class="sep"> ' . wp_kses_post( $separator ) . ' </span>';
           
        if ( is_archive() && !is_tax() && !is_category() && !is_tag() && !is_author() ) {
              
            echo '<span class="trail-end">' . post_type_archive_title($prefix, false) . '</span>';
              
        } else if ( is_archive() && is_tax() && !is_category() && !is_tag() ) {
              
            // If post is a custom post type
            $post_type = get_post_type();
              
            // If it is a custom post type display name and link
            if($post_type != 'post') {
                  
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
              
                echo '<a href="' . $post_type_archive . '">' . $post_type_object->labels->name . '</a>';
                echo '<span class="sep"> ' . wp_kses_post( $separator ) . ' </span>';
              
            }
              
            $custom_tax_name = get_queried_object()->name;
            echo '<span class="trail-end">' . $custom_tax_name . '</span>';
              
        } else if ( is_single() ) {
              
            // If post is a custom post type
            $post_type = get_post_type();
              
            // If it is a custom post type display name and link
            if($post_type != 'post') {
                  
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
              
                echo '<a href="' . $post_type_archive . '">' . $post_type_object->labels->name . '</a>';
                echo '<span class="sep"> ' . wp_kses_post( $separator ) . ' </span>';
              
            }
              
            // Get post category info
            $category = get_the_category();
             
            if(!empty($category)) {
              
                // Get last category post is in
                $last_category = end( ( $category ) );
                  
                // Get parent any categories and create array
                $get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','),',');
                $cat_parents = explode(',',$get_cat_parents);
                  
                // Loop through parent categories and store in variable $cat_display
                $cat_display = '';
                foreach($cat_parents as $parents) {
                    $cat_display .= $parents;
                    $cat_display .= '<span class="sep"> ' . wp_kses_post( $separator ) . ' </span>';
                }
             
            }
              
            // If it's a custom post type within a custom taxonomy
            $taxonomy_exists = taxonomy_exists($custom_taxonomy);
            if(empty($last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {
                   
                $taxonomy_terms = get_the_terms( $post->ID, $custom_taxonomy );
                $cat_id         = $taxonomy_terms[0]->term_id;
                $cat_nicename   = $taxonomy_terms[0]->slug;
                $cat_link       = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
                $cat_name       = $taxonomy_terms[0]->name;
               
            }
              
            // Check if the post is in a category
            if(!empty($last_category)) {
                echo $cat_display;
                echo '<span class="trail-end">' . get_the_title() . '</span>';
                  
            // Else if post is in a custom taxonomy
            } else if(!empty($cat_id)) {
                  
                echo '<a href="' . $cat_link . '">' . $cat_name . '</a>';
                echo '<span class="sep"> ' . wp_kses_post( $separator ) . ' </span>';
                echo '<span class="trail-end">' . get_the_title() . '</span>';
              
            } else {
                  
                echo '<span class="trail-end">' . get_the_title() . '</span>';
                  
            }
              
        } else if ( is_category() ) {
               
            // Category page
            echo '<span class="trail-end">' . single_cat_title('', false) . '</span>';
               
        } else if ( is_page() ) {
               
            // Standard page
            if( $post->post_parent ){
                   
                // If child page, get parents 
                $anc = get_post_ancestors( $post->ID );
                   
                // Get parents in the right order
                $anc = array_reverse($anc);
                   
                // Parent page loop
                if ( !isset( $parents ) ) $parents = null;
                foreach ( $anc as $ancestor ) {
                    $parents .= '<a href="' . get_permalink($ancestor) . '">' . get_the_title($ancestor) . '</a>';
                    $parents .= '<span class="sep"> ' . wp_kses_post( $separator ) . ' </span>';
                }
                   
                // Display parent pages
                echo $parents;
                   
                // Current page
                echo '<span class="trail-end">' . get_the_title() . '</span>';
                   
            } else {
                   
                // Just display current page if not parents
                echo '<span class="trail-end">' . get_the_title() . '</span>';
                   
            }
               
        } else if ( is_tag() ) {
               
            // Tag page
               
            // Get tag information
            $term_id        = get_query_var('tag_id');
            $taxonomy       = 'post_tag';
            $args           = 'include=' . $term_id;
            $terms          = get_terms( $taxonomy, $args );
            $get_term_id    = $terms[0]->term_id;
            $get_term_slug  = $terms[0]->slug;
            $get_term_name  = $terms[0]->name;
               
            // Display the tag name
            echo '<span class="trail-end">' . $get_term_name . '</span>';
           
        } elseif ( is_day() ) {
               
            // Day archive
               
            // Year link
            echo '<a href="' . get_year_link( get_the_time('Y') ) . '">' . get_the_time('Y') . '</a>';
            echo '<span class="sep"> ' . wp_kses_post( $separator ) . ' </span>';
               
            // Month link
            echo '<a href="' . get_month_link( get_the_time('Y'), get_the_time('m') ) . '">' . get_the_time('M') . '</a>';
            echo '<span class="sep"> ' . wp_kses_post( $separator ) . ' </span>';
               
            // Day display
            echo '<span class="trail-end">' . get_the_time('jS') . ' ' . get_the_time('M') . '</span>';
               
        } else if ( is_month() ) {
               
            // Month Archive
               
            // Year link
            echo '<a href="' . get_year_link( get_the_time('Y') ) . '">' . get_the_time('Y') . '</a>';
            echo '<span class="sep"> ' . wp_kses_post( $separator ) . ' </span>';
               
            // Month display
            echo '<span class="trail-end">' . get_the_time('M') . '</span>';
               
        } else if ( is_year() ) {
               
            // Display year archive
            echo '<span class="trail-end">' . get_the_time('Y') . '</span>';
               
        } else if ( is_author() ) {
               
            // Auhor archive
               
            // Get the author information
            global $author;
            $userdata = get_userdata( $author );
               
            // Display author name
            echo '<span class="trail-end">' . $userdata->display_name . '</span>';
           
        } else if ( get_query_var('paged') ) {
               
            // Paginated archives
            echo '<span class="trail-end">'.__('Page','responsi') . ' ' . get_query_var('paged') . '</span>';
               
        } else if ( is_search() ) {
           
            // Search results page
            echo '<span class="trail-end">Search results for: ' . get_search_query() . '</span>';
           
        } elseif ( is_404() ) {
               
            // 404 page
            echo '<span class="trail-end">' .__('Error 404','responsi') . '</span>';
        }
       
        echo '</div></div>';
           
    }
       
}

/*-----------------------------------------------------------------------------------*/
/* responsi_breadcrumbs() - Custom breadcrumb generator function  */
/*-----------------------------------------------------------------------------------*/

function responsi_breadcrumbs( $args = array() ) {
    global $wp_query, $wp_rewrite, $responsi_options;

    if ( !isset($responsi_options['responsi_breadcrumbs_show']) || 'true' !== $responsi_options['responsi_breadcrumbs_show'] ) {
        return;
    }

    /* Create an empty variable for the breadcrumb. */
    $breadcrumb = '';

    /* Create an empty array for the trail. */
    $trail = array();
    $path  = '';

    /* Set up the default arguments for the breadcrumb. */
    $defaults = array(
        'separator' => '&gt;',
        'before' => '<span class="breadcrumb-title">' . __( 'You are here:', 'responsi' ) . '</span>',
        'after' => false,
        'front_page' => false,
        'show_home' => __('Home', 'responsi'),
        'echo' => true,
        'show_posts_page' => true
    );

    /* Allow singular post views to have a taxonomy's terms prefixing the trail. */
    if ( is_singular() )
        $defaults["singular_{$wp_query->post->post_type}_taxonomy"] = false;

    /* Apply filters to the arguments. */
    $args = apply_filters( 'responsi_breadcrumbs_args', $args );

    /* Parse the arguments and extract them for easy variable naming. */
    extract( wp_parse_args( $args, $defaults ) );

    /* If $show_home is set and we're not on the front page of the site, link to the home page. */
    if ( !is_front_page() && $show_home )
        $trail[] = '<a href="' . esc_url( home_url() ) . '" title="' . esc_attr( get_bloginfo( 'name' ) ) . '" rel="home" class="trail-begin">' . esc_html( $show_home ) . '</a>';

    /* If viewing the front page of the site. */
    if ( is_front_page() ) {
        if ( !$front_page )
            $trail = false;
        elseif ($show_home)
            $trail['trail_end'] = "{$show_home}";
    } elseif ( is_home() ) {
        $home_page          = get_page( $wp_query->get_queried_object_id() );
        $trail              = array_merge( $trail, responsi_breadcrumbs_get_parents( $home_page->post_parent, '' ) );
        $trail['trail_end'] = get_the_title( $home_page->ID );
    } elseif ( is_singular() ) {

        /* Get singular post variables needed. */
        $post      = $wp_query->get_queried_object();
        $post_id   = absint( $wp_query->get_queried_object_id() );
        $post_type = $post->post_type;
        $parent    = $post->post_parent;

        /* If a custom post type, check if there are any pages in its hierarchy based on the slug. */
        if ( 'page' !== $post_type && 'post' !== $post_type ) {

            $post_type_object = get_post_type_object( $post_type );

            /* If $front has been set, add it to the $path. */
            if ( 'post' == $post_type || 'attachment' == $post_type || ( $post_type_object->rewrite['with_front'] && $wp_rewrite->front ) )
                $path .= trailingslashit( $wp_rewrite->front );

            /* If there's a slug, add it to the $path. */
            if ( !empty( $post_type_object->rewrite['slug'] ) )
                $path .= $post_type_object->rewrite['slug'];

            /* If there's a path, check for parents. */
            /*if ( !empty( $path ) && '/' != $path )
                $trail = array_merge( $trail, responsi_breadcrumbs_get_parents( '', $path ) );*/

            /* If there's an archive page, add it to the trail. */
            if ( !empty( $post_type_object->has_archive ) && function_exists( 'get_post_type_archive_link' ) )
                $trail[] = '<a href="' . get_post_type_archive_link( $post_type ) . '" title="' . esc_attr( $post_type_object->labels->name ) . '">' . $post_type_object->labels->name . '</a>';
        }

        /* If the post type path returns nothing and there is a parent, get its parents. */
        if ( empty( $path ) && 0 !== $parent || 'attachment' == $post_type )
            $trail = array_merge( $trail, responsi_breadcrumbs_get_parents( $parent, '' ) );

        /* Toggle the display of the posts page on single blog posts. */
        if ( 'post' == $post_type && $show_posts_page == true && 'page' == get_option( 'show_on_front' ) ) {
            $posts_page = get_option( 'page_for_posts' );
            if ( $posts_page != '' && is_numeric( $posts_page ) ) {
                $trail = array_merge( $trail, responsi_breadcrumbs_get_parents( $posts_page, '' ) );
            }
        }elseif( is_singular( 'post' ) && !empty( $post_id ) ){
            $cats = get_the_category( $post_id );
            if( $cats ){
                foreach ( $cats as $cat ){
                    $trail[] = '<a href="' . esc_url( get_category_link( $cat->term_id ) ) . '">'.$cat->cat_name.'</a>';
                }
            }
        }

        /* Display terms for specific post type taxonomy if requested. */
        if ( isset( $args["singular_{$post_type}_taxonomy"] ) && $terms = get_the_term_list( $post_id, $args["singular_{$post_type}_taxonomy"], '', ', ', '') )
            $trail[] = $terms;

        /* End with the post title. */
        $post_title = get_the_title( $post_id ); 
        if ( !empty( $post_title ) )
            $trail['trail_end'] = $post_title;


    } elseif (is_archive()) {

        /* If viewing a taxonomy term archive. */
        if ( is_tax() || is_category() || is_tag() ) {

            /* Get some taxonomy and term variables. */
            $term     = $wp_query->get_queried_object();
            $taxonomy = get_taxonomy( $term->taxonomy );

            /* Get the path to the term archive. Use this to determine if a page is present with it. */
            if ( is_category() )
                $path = get_option( 'category_base' );
            elseif ( is_tag() )
                $path = get_option( 'tag_base' );
            else {
                if ( $taxonomy->rewrite['with_front'] && $wp_rewrite->front )
                    $path = trailingslashit( $wp_rewrite->front );
                $path .= $taxonomy->rewrite['slug'];
            }

            /* Get parent pages by path if they exist. */
            if ( $path )
                $trail = array_merge( $trail, responsi_breadcrumbs_get_parents( '', $path ) );

            /* If the taxonomy is hierarchical, list its parent terms. */
            if ( is_taxonomy_hierarchical($term->taxonomy) && $term->parent )
                $trail = array_merge( $trail, responsi_breadcrumbs_get_term_parents( $term->parent, $term->taxonomy ) );

            /* Add the term name to the trail end. */
            $trail['trail_end'] = $term->name;
        } elseif ( function_exists( 'is_post_type_archive' ) && is_post_type_archive() ) {

            /* Get the post type object. */
            $post_type_object = get_post_type_object( get_query_var( 'post_type' ) );

            /* If $front has been set, add it to the $path. */
            if ( $post_type_object->rewrite['with_front'] && $wp_rewrite->front )
                $path .= trailingslashit( $wp_rewrite->front );

            /* If there's a slug, add it to the $path. */
            if ( !empty( $post_type_object->rewrite['archive'] ) )
                $path .= $post_type_object->rewrite['archive'];

            /* If there's a path, check for parents. */
            if ( !empty($path) && '/' != $path )
                $trail = array_merge( $trail, responsi_breadcrumbs_get_parents( '', $path ) );

            /* Add the post type [plural] name to the trail end. */
            $trail['trail_end'] = $post_type_object->labels->name;
        } elseif ( is_author() ) {

            /* If $front has been set, add it to $path. */
            if ( !empty( $wp_rewrite->front ) )
                $path .= trailingslashit( $wp_rewrite->front );

            /* If an $author_base exists, add it to $path. */
            if ( !empty( $wp_rewrite->author_base) )
                $path .= $wp_rewrite->author_base;

            /* If $path exists, check for parent pages. */
            if ( !empty( $path ) )
                $trail = array_merge( $trail, responsi_breadcrumbs_get_parents( '', $path ) );

            /* Add the author's display name to the trail end. */
            $trail['trail_end'] = get_the_author_meta( 'display_name', get_query_var( 'author' ) );
        } elseif ( is_time() ) {
            if ( get_query_var( 'minute' ) && get_query_var( 'hour' ) )
                $trail['trail_end'] = get_the_time( __( 'g:i a', 'responsi' ) );
            elseif ( get_query_var( 'minute' ) )
                $trail['trail_end'] = sprintf( __( 'Minute %1$s', 'responsi' ), get_the_time( __( 'i', 'responsi' ) ) );
            elseif ( get_query_var( 'hour' ) )
                $trail['trail_end'] = get_the_time( __( 'g a', 'responsi' ) );
        } elseif ( is_date() ) {

            /* If $front has been set, check for parent pages. */
            if ( $wp_rewrite->front )
                $trail = array_merge( $trail, responsi_breadcrumbs_get_parents( '', $wp_rewrite->front ) );

            if ( is_day() ) {
                $trail[]            = '<a href="' . get_year_link( get_the_time( 'Y' ) ) . '" title="' . get_the_time( esc_attr__( 'Y', 'responsi' ) ) . '">' . get_the_time( __( 'Y', 'responsi' ) ) . '</a>';
                $trail[]            = '<a href="' . get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) . '" title="' . get_the_time( esc_attr__( 'F', 'responsi' ) ) . '">' . get_the_time( __( 'F', 'responsi' ) ) . '</a>';
                $trail['trail_end'] = get_the_time( __( 'j', 'responsi' ) );
            }

            elseif ( get_query_var( 'w' ) ) {
                $trail[]            = '<a href="' . get_year_link( get_the_time( 'Y' ) ) . '" title="' . get_the_time( esc_attr__( 'Y', 'responsi' ) ) . '">' . get_the_time( __( 'Y', 'responsi' ) ) . '</a>';
                $trail['trail_end'] = sprintf( __( 'Week %1$s', 'responsi' ), get_the_time( esc_attr__( 'W', 'responsi' ) ) );
            } elseif ( is_month() ) {
                $trail[]            = '<a href="' . get_year_link( get_the_time( 'Y' ) ) . '" title="' . get_the_time( esc_attr__( 'Y', 'responsi' ) ) . '">' . get_the_time( __( 'Y', 'responsi' ) ) . '</a>';
                $trail['trail_end'] = get_the_time( __( 'F', 'responsi' ) );
            } elseif ( is_year() ) {
                $trail['trail_end'] = get_the_time( __( 'Y', 'responsi' ) );
            }
        }
    } elseif ( is_search() )
        $trail['trail_end'] = sprintf( __('Search results for &quot;%1$s&quot;', 'responsi' ), esc_attr( get_search_query() ) );
    elseif ( is_404() )
        $trail['trail_end'] = __( '404 Not Found', 'responsi' );

    /* Allow child themes/plugins to filter the trail array. */
    $trail = apply_filters( 'responsi_breadcrumbs_trail', $trail, $args );

    /* Connect the breadcrumb trail if there are items in the trail. */
    if ( is_array( $trail ) ) {

        /* Open the breadcrumb trail containers. */
        $breadcrumb = '<div class="breadcrumb breadcrumbs responsi-breadcrumbs"><div class="breadcrumb-trail">';

        /* If $before was set, wrap it in a container. */
        if ( !empty( $before ) )
            $breadcrumb .= '<span class="trail-before">' . wp_kses_post( $before ) . '</span> ';

        /* Wrap the $trail['trail_end'] value in a container. */
        if ( !empty( $trail['trail_end'] ) )
            $trail['trail_end'] = '<span class="trail-end">' . wp_kses_post( $trail['trail_end'] ) . '</span>';

        /* Format the separator. */
        if ( !empty( $separator ) )
            $separator = '<span class="sep">' . wp_kses_post( $separator ) . '</span>';

        /* Join the individual trail items into a single string. */
        $breadcrumb .= join( " {$separator} ", $trail );

        /* If $after was set, wrap it in a container. */
        if ( !empty( $after ) )
            $breadcrumb .= ' <span class="trail-after">' . wp_kses_post( $after ) . '</span>';

        /* Close the breadcrumb trail containers. */
        $breadcrumb .= '</div></div>';
    }

    /* Allow developers to filter the breadcrumb trail HTML. */
    $breadcrumb = apply_filters( 'responsi_breadcrumbs', $breadcrumb );

    /* Output the breadcrumb. */
    if ( $echo )
        echo $breadcrumb;
    else
        return $breadcrumb;
}

/*-----------------------------------------------------------------------------------*/
/* responsi_breadcrumbs_get_parents() - Retrieve the parents of the current page/post */
/*-----------------------------------------------------------------------------------*/

function responsi_breadcrumbs_get_parents( $post_id = '', $path = '' ){
    /* Set up an empty trail array. */
    $trail = array();

    /* If neither a post ID nor path set, return an empty array. */
    if ( empty( $post_id ) && empty( $path ) )
        return $trail;

    /* If the post ID is empty, use the path to get the ID. */
    if ( empty( $post_id ) ) {

        /* Get parent post by the path. */
        $parent_page = get_page_by_path( $path );

        if (empty( $parent_page) )
            // search on page name (single word)
            $parent_page = get_page_by_title( $path );

        if (empty($parent_page) )
            // search on page title (multiple words)
            $parent_page = get_page_by_title( str_replace( array(
                '-',
                '_'
            ), ' ', $path ) );

        /* If a parent post is found, set the $post_id variable to it. */
        if ( !empty( $parent_page ) )
            $post_id = $parent_page->ID;
    }

    /* If a post ID and path is set, search for a post by the given path. */
    if ( 0 == $post_id && !empty($path)) {

        /* Separate post names into separate paths by '/'. */
        $path = trim( $path, '/' );
        preg_match_all( "/\/.*?\z/", $path, $matches );

        /* If matches are found for the path. */
        if ( isset( $matches ) ) {

            /* Reverse the array of matches to search for posts in the proper order. */
            $matches = array_reverse( $matches );

            /* Loop through each of the path matches. */
            foreach ( $matches as $match ) {

                /* If a match is found. */
                if ( isset( $match[0] ) ) {

                    /* Get the parent post by the given path. */
                    $path        = str_replace( $match[0], '', $path );
                    $parent_page = get_page_by_path( trim( $path, '/' ) );

                    /* If a parent post is found, set the $post_id and break out of the loop. */
                    if ( !empty( $parent_page ) && $parent_page->ID > 0 ) {
                        $post_id = $parent_page->ID;
                        break;
                    }
                }
            }
        }
    }

    /* While there's a post ID, add the post link to the $parents array. */
    while ( $post_id ) {
        /* Get the post by ID. */
        $page = get_page( $post_id );

        /* Add the formatted post link to the array of parents. */
        $parents[] = '<a href="' . esc_url( get_permalink( $post_id ) ). '" title="' . esc_attr( get_the_title( $post_id ) ) . '">' . esc_html( get_the_title( $post_id ) ) . '</a>';

        /* Set the parent post's parent to the post ID. */
        $post_id = $page->post_parent;
    }

    /* If we have parent posts, reverse the array to put them in the proper order for the trail. */
    if ( isset( $parents ) ){
        $trail = array_reverse( $parents );
    }

    /* Return the trail of parent posts. */
    return $trail;
}

/*-----------------------------------------------------------------------------------*/
/* responsi_breadcrumbs_get_term_parents() - Retrieve the parents of the current term */
/*-----------------------------------------------------------------------------------*/

function responsi_breadcrumbs_get_term_parents( $parent_id = '', $taxonomy = '' ) {

    $trail   = array();
    $parents = array();

    if ( empty( $parent_id ) || empty( $taxonomy ) ){
        return $trail;
    }

    while ( $parent_id ) {

        /* Get the parent term. */
        $parent = get_term( $parent_id, $taxonomy );

        /* Add the formatted term link to the array of parent terms. */
        $parents[] = '<a href="' . esc_url( get_term_link( $parent, $taxonomy ) ) . '" title="' . esc_attr($parent->name) . '">' . $parent->name . '</a>';

        /* Set the parent term's parent as the parent ID. */
        $parent_id = $parent->parent;
    }

    /* If we have parent terms, reverse the array to put them in the proper order for the trail. */
    if ( !empty( $parents ) ){
        $trail = array_reverse( $parents );
    }

    /* Return the trail of parent terms. */
    return $trail;
}

/*-----------------------------------------------------------------------------------*/
/* Exclude categories from displaying on the "Blog" page template.
/*-----------------------------------------------------------------------------------*/

function responsi_categories_blogtemplate_excluded( $args ){

    if ( !function_exists( 'responsi_prepare_category_ids' ) ) {
        return $args;
    }

    $excluded_cats = array();

    $excluded_cats = responsi_prepare_category_ids( 'responsi_exclude_cats_blog' );

    if ( count( $excluded_cats ) > 0 ) {

        foreach ( $excluded_cats as $k => $v ) {
            $excluded_cats[$k] = '-' . $v;
        }
        $cats = join( ',', $excluded_cats );

        $args['cat'] = $cats;
    }

    return $args;

}

/*-----------------------------------------------------------------------------------*/
/* responsi_prepare_category_ids() */
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'responsi_prepare_category_ids' ) ) {
    function responsi_prepare_category_ids( $option ) {
        $cats = array();

        $stored_cats = get_theme_mod( $option );

        if( '' !== trim( $stored_cats ) ) {

            $cats_raw = explode( ',', $stored_cats );

            if ( is_array( $cats_raw ) && ( count( $cats_raw ) > 0 ) ) {
                foreach ( $cats_raw as $k => $v ) {
                    $value = trim( $v );

                    if ( is_numeric( $value ) ) {
                        $cats_raw[$k] = $value;
                    } else {
                        $cat_obj = get_category_by_slug( $value );
                        if ( isset( $cat_obj->term_id ) ) {
                            $cats_raw[$k] = $cat_obj->term_id;
                        }
                    }

                    $cats = $cats_raw;
                }
            }
        }

        return $cats;
    }
}

/*-----------------------------------------------------------------------------------*/
/* responsi_generate_fonts() */
/*-----------------------------------------------------------------------------------*/

if (!function_exists('responsi_generate_fonts')) {
    function responsi_generate_fonts( $option, $imp = false ) {

        global $google_fonts;

        $fonts_style = '';

        if( is_array( $option ) && isset( $option['face']) && isset( $option['line_height']) && isset($option['style']) && isset($option['size']) && isset($option['color']) ){
            $important = '';
            if ( $imp ){
                $important = ' !important';
            }

            if ( array_key_exists( $option['face'], $google_fonts ) ) {
                $option['face'] = "'" . $option['face'] . "', sans-serif";
            }
            if ( !isset($option['style']) && !isset($option['size']) && !isset($option['color']) ){
                $fonts_style = 'font-family: ' . stripslashes( $option["face"] ) . $important . ';';
            } else {
                $fonts_style = 'font:' . esc_attr( $option['style'] ) . ' ' . esc_attr( $option['size'] ) . 'px/' . esc_attr( $option['line_height'] ) . 'em ' . stripslashes( $option['face'] ) . $important . ';color:' . esc_attr( $option['color'] ) . $important . ';';
            }
        }

        return $fonts_style;
    }
}

/*-----------------------------------------------------------------------------------*/
/* responsi_generate_border() */
/*-----------------------------------------------------------------------------------*/

if (!function_exists('responsi_generate_border')) {
    function responsi_generate_border( $option, $border = 'border', $important = false ) {

        $border_style = '';

        $border_types = array( 'border', 'border-top', 'border-bottom', 'border-left', 'border-right' );

        $border = esc_attr( $border );

        if ( $important ) {
            $ipt = ' !important';
        } else {
            $ipt = '';
        }

        if( in_array( $border, $border_types ) ){
            if ( is_array( $option ) && isset( $option['width'] ) && $option['width'] >= 0 && isset( $option['style'] ) && isset( $option['color'] ) && '' !== trim( $option['color'] ) ) {
                $border_style = $border . ':' . esc_attr( $option['width']) . 'px ' . esc_attr( $option['style'] ) . ' ' . esc_attr( $option['color'] ) . $ipt . ';';
            }else{
                $border_style = $border . ':none' . $ipt . ';';
            }

        }else{
            $border_style = 'border:none' . $ipt . ';';
        }

        return $border_style;
    }
}

/*-----------------------------------------------------------------------------------*/
/* responsi_generate_border_boxes() */
/*-----------------------------------------------------------------------------------*/

if (!function_exists('responsi_generate_border_boxes')) {
    function responsi_generate_border_boxes( $option, $important = false ) {

        $border_boxes = '';
        
        $border_style = '';

        $border_corner = '';

        if ( $important ) {
            $ipt = ' !important';
        } else {
            $ipt = '';
        }

        if ( is_array( $option ) ){
            if ( isset( $option['width'] ) && $option['width'] >= 0 && isset( $option['style'] ) && isset( $option['color'] ) && '' !== trim( $option['color'] ) ) {
                $border_style = 'border:' . esc_attr( $option['width']) . 'px ' . esc_attr( $option['style'] ) . ' ' . esc_attr( $option['color'] ) . $ipt . ';';
            }else{
                $border_style = 'border:none' . $ipt . ';';
            }
            if ( isset( $option['corner'] ) && 'rounded' == $option['corner'] ){
                if ( isset( $option['topleft'] ) && $option['topleft'] >= 0 ){
                    $border_corner .= 'border-top-left-radius: '.esc_attr( $option['topleft']).'px' . $ipt . ';';
                }
                if ( isset( $option['topright'] ) && $option['topright'] >= 0 ){
                    $border_corner .= 'border-top-right-radius: '.esc_attr( $option['topright']).'px' . $ipt . ';';
                }
                if ( isset( $option['bottomright'] ) && $option['bottomright'] >= 0 ){
                    $border_corner .= 'border-bottom-right-radius: '.esc_attr( $option['bottomright']).'px' . $ipt . ';';
                }
                if ( isset( $option['bottomleft'] ) && $option['bottomleft'] >= 0 ){
                    $border_corner .= 'border-bottom-left-radius: '.esc_attr( $option['bottomleft']).'px' . $ipt . ';';
                }
            }else{
                $border_corner = 'border-top-left-radius: 0px' . $ipt . '; border-top-right-radius: 0px' . $ipt . '; border-bottom-right-radius: 0px' . $ipt . '; border-bottom-left-radius: 0px' . $ipt . ';';
            }

        }else{
            $border_style = 'border:none' . $ipt . ';';
            $border_corner = 'border-top-left-radius: 0px' . $ipt . '; border-top-right-radius: 0px' . $ipt . '; border-bottom-right-radius: 0px' . $ipt . '; border-bottom-left-radius: 0px' . $ipt . ';';
        }


        $border_boxes .= $border_style;

        $border_boxes .= $border_corner;

        return $border_boxes;
    }
}

/*-----------------------------------------------------------------------------------*/
/* responsi_generate_background_color() */
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'responsi_generate_background_color' ) ) {
    function responsi_generate_background_color( $option = array('onoff' => 'true', 'color' => 'transparent' ), $important = false ) {
        
        if ( $important ) {
            $ipt = ' !important';
        } else {
            $ipt = '';
        }
        
        $background_color = 'background-color:transparent'.$ipt.';';

        if( is_array( $option ) && isset( $option['onoff'] ) && 'true' === $option['onoff'] && isset( $option['color'] ) && '' !== trim( $option['color'] ) ){
            $background_color = 'background-color:'.esc_attr($option['color']).$ipt.';';
        } 

        return $background_color;
    }
}

if ( !function_exists( 'responsi_hextorgb' ) ) {
    function responsi_hextorgb( $color = '', $text = true ) {
        $color = trim( $color );
        if ( '' == $color || 'transparent' == $color ) {
            return false;
        }

        if ( '#' == $color[0] ) {
            $color = substr( $color, 1 );
        }

        if ( 6 == strlen( $color ) ) {
            list( $r, $g, $b ) = array( $color[0].$color[1], $color[2].$color[3], $color[4].$color[5] );
        } elseif ( 3 == strlen( $color ) ) {
            list( $r, $g, $b ) = array( $color[0].$color[0], $color[1].$color[1], $color[2].$color[2] );
        } else {
            return false;
        }

        $r = hexdec($r);
        $g = hexdec($g);
        $b = hexdec($b);

        if ( $text ) {
            return $r.','.$g.','.$b;
        } else {
            return array( $r, $g, $b );
        }
    }
}

if ( !function_exists( 'responsi_generate_background_transparent_color' ) ) {
    function responsi_generate_background_transparent_color( $color, $transparency = 100, $important = true ) {

        if ( $important ) {
            $ipt = ' !important';
        } else {
            $ipt = '';
        }

        $background_transparent = 'background-color:rgba( 0, 0, 0, 0 ) '.$ipt.';';

        $color = responsi_hextorgb( $color );
        $transparency = (int) $transparency / 100;

        if ( $color !== false && 0 <= $transparency ) {
            $background_transparent = 'background-color: rgba( ' . $color . ', ' . $transparency . ' ) '.$ipt.';';
        }
        
        return $background_transparent;

    }
}

if ( !function_exists( 'responsi_generate_animation' ) ) {

    function responsi_generate_animation( $options = array('type' => 'none', 'direction' => '', 'duration' => '1','delay' => '1') ) {

        $defaults = array(
            'type'      => 'none', 
            'direction' => '', 
            'duration'  => '1',
            'delay'     => '1'
        ) ;

        if( is_array( $options ) ) {
            $options = array_merge( $defaults, $options );
        }

        if( !is_array($options) ) 
            return false;

        if( !isset($options['type']) || !isset($options['direction']) || !isset($options['duration']) || !isset($options['delay']) ) 
            return false;

        if( 'none' === $options['type'] ) 
            return false;

        $special_types =  array( 'bounce', 'fade', 'slide', 'zoom' );

        $class_attr = 'animateMe';
        if( 'slide' === $options['type'] && $options['direction'] === '' ){
            $data_attr =  'slideInLeft';
        }else{
            $data_attr =  in_array( $options['type'] , $special_types) ? $options['type'].'In'.ucfirst($options['direction']) : $options['type'];
        }

        $style_attr = 'animation-delay:'.$options['delay'].'s;animation-duration:'.$options['duration'].'s';

        $animation_attributes = array(
            'class' => $class_attr,
            'data'  => $data_attr,
            'style' => $style_attr
        );
       
        return $animation_attributes;

    }
}

/*-----------------------------------------------------------------------------------*/
/* responsi_generate_border_radius_value() */
/*-----------------------------------------------------------------------------------*/

if (!function_exists('responsi_generate_border_radius_value')) {
    function responsi_generate_border_radius_value( $option ) {
        $rounded_value = '0px';
        if ( is_array( $option ) && isset( $option['corner'] ) && 'rounded' === $option['corner'] && isset( $option['rounded_value'] ) && $option['rounded_value'] >= 0 ) {
            $rounded_value = esc_attr( $option['rounded_value'] ) . 'px';
        }
        return $rounded_value;
    }
}

/*-----------------------------------------------------------------------------------*/
/* responsi_generate_border_radius() */
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'responsi_generate_border_radius' ) ) {
    function responsi_generate_border_radius( $option, $important = false ) {

        if ( $important ) {
            $ipt = ' !important';
        } else {
            $ipt = '';
        }

        $rounded_value = '0px';

        $border_radius = 'border-radius: 0px' . $ipt . ';';

        if ( is_array( $option ) && isset( $option['corner'] ) && isset( $option['rounded_value'] ) ) {
            if (  'rounded' === $option['corner'] ) {
                $rounded_value = esc_attr( $option['rounded_value'] ) . 'px';
            }
            $border_radius = 'border-radius: ' . $rounded_value . $ipt . ';';
        }

        return $border_radius;
    }
}

/*-----------------------------------------------------------------------------------*/
/* responsi_generate_box_shadow() */
/*-----------------------------------------------------------------------------------*/

if (!function_exists('responsi_generate_box_shadow')) {
    function responsi_generate_box_shadow( $option, $important = true ) {

        if ( $important ) {
            $ipt = ' !important';
        } else {
            $ipt = '';
        }

        $box_shadow = 'box-shadow: none' . $ipt . ';';

        if ( is_array( $option ) && isset( $option['onoff'] ) && isset( $option['h_shadow'] ) && isset( $option['v_shadow'] ) && isset( $option['blur'] ) && isset( $option['spread'] ) && isset( $option['color'] ) ) {
            
            if ( !isset( $option['inset'] ) ){
                $option['inset'] = '';
            }

            if ( $option['inset'] !== 'inset' ) {
                $option['inset'] = '';
            } else {
                $option['inset'] = 'inset';
            }

            if ( isset( $option['onoff'] ) && 'true' === $option['onoff'] ) {
                $box_shadow = 'box-shadow: ' . esc_attr( $option['h_shadow'] ) . ' ' . esc_attr( $option['v_shadow'] ) . ' ' . esc_attr( $option['blur'] ) . ' ' . esc_attr( $option['spread']) . ' ' . esc_attr( $option['color'] ) . ' ' . esc_attr( $option['inset'] ) . $ipt . ';';
            }

        }

        return $box_shadow;
    }
}

/*-----------------------------------------------------------------------------------*/
/* responsi_extra_theme_headers()  */
/*-----------------------------------------------------------------------------------*/

function responsi_extra_theme_headers( $theme_data ){
    $theme_data[] = 'Template Version';
    return $theme_data;
}

/*-----------------------------------------------------------------------------------*/
/* responsi_autoembed_media()  */
/*-----------------------------------------------------------------------------------*/

function responsi_autoembed_media( $content = '' ){
    return apply_filters( 'responsi_autoembed_media', $content );
}

function responsi_autoembed_media_replace_iframe( $content = '' ){
    //$content = wp_unslash( $content );
    $content = str_replace('frameeditor', 'iframe', $content );
    return $content;
}

/*-----------------------------------------------------------------------------------*/
/* responsi_exclude_button_lists()  */
/*-----------------------------------------------------------------------------------*/

function responsi_button_none_css_lists(){
    

    $responsi_button_none_css_lists = '.mejs-button button';

    $responsi_button_none_css_lists = apply_filters( 'responsi_button_none_css_lists', $responsi_button_none_css_lists );

    $exclude_button_css = '';

    if( '' != trim( $responsi_button_none_css_lists ) ){
        $responsi_button_none_css_lists = explode( ',', $responsi_button_none_css_lists );
        
        if( is_array( $responsi_button_none_css_lists ) && count( $responsi_button_none_css_lists ) > 0 ){

            $exclude_button_css = '';
            $comma = '';

            foreach( $responsi_button_none_css_lists as $element ){
                if( !empty($element) ){
                    $exclude_button_css .= $comma.trim($element);
                    $comma = ',';
                }
            }
        }

    }

    return $exclude_button_css;
}

/*-----------------------------------------------------------------------------------*/
/* responsi_exclude_button_css()  */
/*-----------------------------------------------------------------------------------*/

function responsi_exclude_button_css(){

    global $responsi_options;

    $_exclude_lists = '.customize-partial-edit-shortcut-button, .bfwc-googlepay-button, .close, .none-button-css';

    if( isset( $responsi_options['responsi_exclude_button_lists'] ) && '' != trim( $responsi_options['responsi_exclude_button_lists'] ) ){
        $_exclude_lists .= ',' . trim( $responsi_options['responsi_exclude_button_lists'] );
    }

    $_exclude_lists = apply_filters( 'responsi_exclude_button_css', $_exclude_lists );

    $css_excludes = responsi_build_exclude_button_css( $_exclude_lists );
    
    return $css_excludes;
}

/*-----------------------------------------------------------------------------------*/
/* responsi_build_exclude_button_css()  */
/*-----------------------------------------------------------------------------------*/

function responsi_build_exclude_button_css( $lists = '' ){

    $exclude_button_css = '';

    if( '' != trim( $lists ) ){
        if( trim( $lists ) != '' ){
            $lists = explode( ',', $lists );
            if( is_array( $lists ) && count( $lists ) > 0 ){
                foreach( $lists as $element ){
                    if( !empty($element) ){
                        $exclude_button_css .= ':not(' . trim($element) . ')';
                    }
                }
            }
        }
    }

    return $exclude_button_css;
}

/*-----------------------------------------------------------------------------------*/
/* responsi_dynamic_gutter */
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'responsi_dynamic_gutter' ) ) {

    function responsi_dynamic_gutter( $params = array( 'gutter' => 2, 'gutter_vertical' => 20 ) ) {

        extract( $params );

        $gutter_vertical = ( esc_attr( $gutter_vertical ) );
        $gutter = ( esc_attr( $gutter ) );

        $output = '
        .box-item{
            margin-bottom: '.( ($gutter_vertical) ).'px !important;
        }
        .box-content .box-item{margin-right:'.($gutter).'%;}';

        $output .= '@media only screen and (min-width:783px) {';

            $output .= '
                html .box.box-last{
                    margin-left: 0 !important;
                    margin-right: 0 !important;
                }';

            $output .= '
                .col-right,
                .col-left{
                    width: '.( (100 - ($gutter))/2 ).'%;
                }';

            $output .= '
                .box {
                    margin: 0% '.$gutter.'% 0% 0%;
                    padding: 0 !important;
                }

                .col-1 .box.col-item {
                    float: left;
                    width: 100%;
                }
                .col-2 .box.col-item {
                    float: left;
                    width: '.( (100 - ($gutter))/2 ).'% !important;
                }
                .col-3 .box.col-item {
                    float: left;
                    width: '.( (100 - ($gutter*2))/3 ).'% !important;
                }
                .col-4 .box.col-item {
                    float: left;
                    width: '.( (100 - ($gutter*3))/4 ).'% !important;
                }
                .col-5 .box.col-item {
                    float: left;
                    width: '.( (100 - ($gutter*4))/5 ).'% !important;
                }
                .col-6 .box.col-item {
                    float: left;
                    width: '.( (100 - ($gutter*5))/6).'% !important;
                }';

            $output .= '
                .col-2-2 #sidebar.box,
                .col-2-2 #sidebar-alt.box {
                    float: left;
                    width: '.( (100 - ($gutter))/2 ).'%;
                }
                .col-2-2 .box {
                    float: left;
                    width: '.( (100 - ($gutter))/2 ).'%;
                }

                .col-2-3 #sidebar.box,
                .col-2-3 #sidebar-alt.box {
                    float: left;
                    width: 32%;
                    width: '.( (100 - ($gutter*2))/3 ).'%;
                }
                .col-2-3 .box {
                    float: left;
                    width: '. ( (( (100 - ($gutter*2))/3 ) * 2 ) + ( $gutter ) ) .'%;
                }

                .col-2-4 #sidebar.box,
                .col-2-4 #sidebar-alt.box{
                    float: left;
                    width: '.( (100 - ($gutter*3))/4 ).'%;
                }
                .col-2-4 .box {
                    float: left;
                    width: '. ( (( (100 - ($gutter*3))/4 ) * 3 ) + ( $gutter*2 ) ) .'%;
                }

                .col-2-5 #sidebar.box,
                .col-2-5 #sidebar-alt.box{
                    float: left;
                    width: '.( (100 - ($gutter*4))/5 ).'%;
                }
                .col-2-5 .box{
                    float: left;
                    width: '. ( (( (100 - ($gutter*4))/5 ) * 4 ) + ( $gutter*3 ) ) .'%;
                }

                .col-2-6 #sidebar.box,
                .col-2-6 #sidebar-alt.box{
                    float: left;
                    width: '.( (100 - ($gutter*5))/6 ).'%;
                }
                .col-2-6 .box{
                    float: left;
                    width: '. ( (( (100 - ($gutter*5))/6 ) * 5 ) + ( $gutter*4 ) ) .'%;
                }

                .col-3-3 #sidebar.box,
                .col-3-3 #sidebar-alt.box {
                    float: left;
                    width: '.( (100 - ($gutter*2))/3 ).'%;
                }
                .col-3-3 .box {
                    float: left;
                    width: '.( (100 - ($gutter*2))/3 ).'%;
                }

                .col-3-4 #sidebar.box,
                .col-3-4 #sidebar-alt.box {
                    float: left;
                    width: '.( (100 - ($gutter*3))/4 ).'%;
                }
                .col-3-4 .box {
                    float: left;
                    width: '. ( (( (100 - ($gutter*3))/4 ) * 2 ) + $gutter ) .'%;
                }

                .col-3-5 #sidebar.box,
                .col-3-5 #sidebar-alt.box {
                    float: left;
                    width: '.( (100 - ($gutter*4))/5 ).'%;
                }
                .col-3-5 .box {
                    float: left;
                    width: '. ( (( (100 - ($gutter*4))/5 ) * 3 ) + ( $gutter*2 ) ) .'%;
                }

                .col-3-6 #sidebar.box,
                .col-3-6 #sidebar-alt.box {
                    float: left;
                    width: '.( (100 - ($gutter*5))/6 ).'%;
                }
                .col-3-6 .box {
                    float: left;
                    width: '. ( (( (100 - ($gutter*5))/6 ) * 4 ) + ( $gutter*3 ) ) .'%;
                }';

            $output .= '
                .box .box-content.col1, .col-1-full .box .box-content.col1 .box-item, .box .box-content.col1 .box-item {
                    width: 100% !important;
                }';

            $box_item_2 = ((100-(($gutter*2)))/2);
            $box_item_3 = ((100-(($gutter*3)))/3);
            $box_item_4 = ((100-(($gutter*4)))/4);
            $box_item_5 = ((100-(($gutter*5)))/5);
            $box_item_6 = ((100-(($gutter*6)))/6);

            $box_item_1_2 = ((100-(($gutter*2)))/2);
            $box_item_1_3 = ((100-(($gutter*3)))/3);
            $box_item_1_4 = ((100-(($gutter*4)))/4);
            $box_item_1_5 = ((100-(($gutter*5)))/5);
            $box_item_1_6 = ((100-(($gutter*6)))/6);

            $box_item_2_3 = ((100-(($gutter*3)))/2);
            $box_item_2_4 = ((100-(($gutter*4)))/3);
            $box_item_2_5 = ((100-(($gutter*5)))/4);
            $box_item_2_6 = ((100-(($gutter*6)))/5);

            $box_item_3_4 = ((100-(($gutter*3.5)))/2);
            $box_item_3_5 = ((100-(($gutter*4.5)))/3);
            $box_item_3_6 = ((100-(($gutter*5.5)))/4);

            if( $gutter == 0 ){

                $box_content_2 = (100.1+(($gutter)));
                $box_content_3 = (100.1+(($gutter)));
                $box_content_4 = (100.1+(($gutter)));
                $box_content_5 = (100.1+(($gutter)));
                $box_content_6 = (100.1+(($gutter)));

                $box_content_1_2 = (100.1+(($gutter*2)));
                $box_content_1_3 = (100.1+(($gutter*3)));
                $box_content_1_4 = (100.1+(($gutter*4)));
                $box_content_1_5 = (100.1+(($gutter*5)));
                $box_content_1_6 = (100.1+(($gutter*6)));

                $box_content_2_3 = (100.1+(($gutter*2)));
                $box_content_2_4 = (100.1+(($gutter*3)));
                $box_content_2_5 = (100.1+(($gutter*4)));
                $box_content_2_6 = (100.1+(($gutter*5)));

                $box_content_3_4 = (100.1+(($gutter*2)));
                $box_content_3_5 = (100.1+(($gutter*2)));
                $box_content_3_6 = (100.2+(($gutter*3)));
                
            }elseif( $gutter == 0.5 ){

                $box_content_2 = (100.1+(($gutter)));
                $box_content_3 = (100.1+(($gutter)));
                $box_content_4 = (100.1+(($gutter)));
                $box_content_5 = (100.1+(($gutter)));
                $box_content_6 = (100.2+(($gutter)));

                $box_content_1_2 = (99.6+(($gutter*2)));
                $box_content_1_3 = (99.1+(($gutter*3)));
                $box_content_1_4 = (98.6+(($gutter*4)));
                $box_content_1_5 = (98.1+(($gutter*5)));
                $box_content_1_6 = (97.6+(($gutter*6)));

                $box_content_2_3 = (99.8+(($gutter*2)));
                $box_content_2_4 = (99.2+(($gutter*3)));
                $box_content_2_5 = (98.6+(($gutter*4)));
                $box_content_2_6 = (98.2+(($gutter*5)));

                $box_content_3_4 = (99.8+(($gutter*2.2)));
                $box_content_3_5 = (99.8+(($gutter*2)));
                $box_content_3_6 = (99.8+(($gutter*2)));
                
            }elseif( $gutter == 1 ){

                $box_content_2 = (100.1+(($gutter)));
                $box_content_3 = (100.1+(($gutter)));
                $box_content_4 = (100.1+(($gutter)));
                $box_content_5 = (100.1+(($gutter)));
                $box_content_6 = (100.1+(($gutter)));

                $box_content_1_2 = (99.1+(($gutter*2)));
                $box_content_1_3 = (98.1+(($gutter*3)));
                $box_content_1_4 = (97.1+(($gutter*4)));
                $box_content_1_5 = (96.1+(($gutter*5)));
                $box_content_1_6 = (95.1+(($gutter*6)));

                $box_content_2_3 = (99.5+(($gutter*2)));
                $box_content_2_4 = (98.5+(($gutter*3)));
                $box_content_2_5 = (97.3+(($gutter*4)));
                $box_content_2_6 = (96.3+(($gutter*5)));

                $box_content_3_4 = (99.7+(($gutter*2.2)));
                $box_content_3_5 = (99.6+(($gutter*2)));
                $box_content_3_6 = (99.6+(($gutter*2)));
                
            }elseif( $gutter == 1.5 ){

                $box_content_2 = (100.1+(($gutter)));
                $box_content_3 = (100.1+(($gutter)));
                $box_content_4 = (100.1+(($gutter)));
                $box_content_5 = (100.1+(($gutter)));
                $box_content_6 = (100.1+(($gutter)));

                $box_content_1_2 = (98.6+(($gutter*2)));
                $box_content_1_3 = (97.1+(($gutter*3)));
                $box_content_1_4 = (95.6+(($gutter*4)));
                $box_content_1_5 = (94.1+(($gutter*5)));
                $box_content_1_6 = (92.6+(($gutter*6)));

                $box_content_2_3 = (99.2+(($gutter*2)));
                $box_content_2_4 = (97.6+(($gutter*3)));
                $box_content_2_5 = (96+(($gutter*4)));
                $box_content_2_6 = (94.5+(($gutter*5)));

                $box_content_3_4 = (99.4+(($gutter*2.2)));
                $box_content_3_5 = (99.4+(($gutter*2)));
                $box_content_3_6 = (99.2+(($gutter*2)));
                
            }elseif( $gutter == 2 ){

                $box_content_2 = (100.1+(($gutter)));
                $box_content_3 = (100.1+(($gutter)));
                $box_content_4 = (100.1+(($gutter)));
                $box_content_5 = (100.1+(($gutter)));
                $box_content_6 = (100.2+(($gutter)));

                $box_content_1_2 = (98.1+(($gutter*2)));
                $box_content_1_3 = (96.1+(($gutter*3)));
                $box_content_1_4 = (94.1+(($gutter*4)));
                $box_content_1_5 = (92.1+(($gutter*5)));
                $box_content_1_6 = (90.1+(($gutter*6)));

                $box_content_2_3 = (99.2+(($gutter*2)));
                $box_content_2_4 = (96.8+(($gutter*3)));
                $box_content_2_5 = (94.6+(($gutter*4)));
                $box_content_2_6 = (92.6+(($gutter*5)));

                $box_content_3_4 = (99.3+(($gutter*2.2)));
                $box_content_3_5 = (99.2+(($gutter*2)));
                $box_content_3_6 = (98.9+(($gutter*2)));
                
            }elseif( $gutter == 2.5 ){

                $box_content_2 = (100.1+(($gutter)));
                $box_content_3 = (100.1+(($gutter)));
                $box_content_4 = (100.1+(($gutter)));
                $box_content_5 = (100.1+(($gutter)));
                $box_content_6 = (100.2+(($gutter)));

                $box_content_1_2 = (97.6+(($gutter*2)));
                $box_content_1_3 = (95.1+(($gutter*3)));
                $box_content_1_4 = (92.6+(($gutter*4)));
                $box_content_1_5 = (90.2+(($gutter*5)));
                $box_content_1_6 = (87.6+(($gutter*6)));

                $box_content_2_3 = (98.8+(($gutter*2)));
                $box_content_2_4 = (96.03+(($gutter*3)));
                $box_content_2_5 = (93.3+(($gutter*4)));
                $box_content_2_6 = (90.8+(($gutter*5)));

                $box_content_3_4 = (99.1+(($gutter*2.2)));
                $box_content_3_5 = (99+(($gutter*2)));
                $box_content_3_6 = (98.6+(($gutter*2)));
                
            }elseif( $gutter == 3 ){

                $box_content_2 = (100.1+(($gutter)));
                $box_content_3 = (100.1+(($gutter)));
                $box_content_4 = (100.1+(($gutter)));
                $box_content_5 = (100.1+(($gutter)));
                $box_content_6 = (100.2+(($gutter)));

                $box_content_1_2 = (97.2+(($gutter*2)));
                $box_content_1_3 = (94.1+(($gutter*3)));
                $box_content_1_4 = (91.2+(($gutter*4)));
                $box_content_1_5 = (88.2+(($gutter*5)));
                $box_content_1_6 = (85.2+(($gutter*6)));

                $box_content_2_3 = (98.7+(($gutter*2)));
                $box_content_2_4 = (95.2+(($gutter*3)));
                $box_content_2_5 = (92+(($gutter*4)));
                $box_content_2_6 = (88.8+(($gutter*5)));

                $box_content_3_4 = (99+(($gutter*2.2)));
                $box_content_3_5 = (98.8+(($gutter*2)));
                $box_content_3_6 = (98.4+(($gutter*2)));

            }

            $output .= '
                .box-content.col2 {
                    width: '.$box_content_2.'%;
                }

                .box-content.col2 .box-item {
                    width: '.$box_item_2.'%;
                }

                .box-content.col3 {
                    width: '.$box_content_3.'%;
                }
                .box-content.col3 .box-item {
                    width: '.$box_item_3.'%;
                }

                .box-content.col4 {
                    width: '.$box_content_4.'%;
                }
                .box-content.col4 .box-item {
                    width: '.$box_item_4.'%;
                }

                .box-content.col5 {
                    width: '.$box_content_5.'%;
                }
                .box-content.col5 .box-item {
                    width: '.$box_item_5.'%;
                }

                .box-content.col6 {
                    width: '.$box_content_6.'%;
                }
                .box-content.col6 .box-item {
                    width: '.$box_item_6.'%;
                }';

            $output .= '
                .col-1-full .box .box-content.col2 {
                    width: '.$box_content_1_2.'%;
                }
                .col-1-full .box .box-content.col2 .box-item {
                    width: '.$box_item_1_2.'%;
                }
                .col-1-full .box .box-content.col3 {
                    width: '.$box_content_1_3.'%;
                }
                .col-1-full .box .box-content.col3 .box-item {
                    width: '.$box_item_1_3.'%;
                }
                .col-1-full .box .box-content.col4 {
                    width: '.$box_content_1_4.'%;
                }
                .col-1-full .box .box-content.col4 .box-item {
                    width: '.$box_item_1_4.'%;
                }
                .col-1-full .box .box-content.col5 {
                    width: '.$box_content_1_5.'%;
                }
                .col-1-full .box .box-content.col5 .box-item {
                    width: '.$box_item_1_5.'%;
                }
                .col-1-full .box .box-content.col6 {
                    width: '.$box_content_1_6.'%;
                }
                .col-1-full .box .box-content.col6 .box-item {
                    width: '.$box_item_1_6.'%;
                }
                ';

            $output .= '
                .col-2-3 .box .box-content.col2 {
                    width: '.$box_content_2_3.'%;
                }
                .col-2-3 .box .box-content.col2 .box-item{
                    width: '.$box_item_2_3.'%;
                }
                .col-2-4 .box .box-content.col3 {
                    width: '.$box_content_2_4.'%;
                }
                .col-2-4 .box .box-content.col3 .box-item {
                    width: '.$box_item_2_4.'%;
                }
                .col-2-5 .box .box-content.col4 {
                    width: '.$box_content_2_5.'%;
                }
                .col-2-5 .box .box-content.col4 .box-item{
                    width: '.$box_item_2_5.'%;
                }
                .col-2-6 .box .box-content.col5 {
                    width: '.$box_content_2_6.'%;
                }
                .col-2-6 .box .box-content.col5 .box-item{
                    width: '.$box_item_2_6.'%;
                }
                ';

            $output .= '
                .col-3-4 .box .box-content.col2 {
                    width: '.$box_content_3_4.'%;
                }
                .col-3-4 .box .box-content.col2 .box-item{
                    width: '.$box_item_3_4.'%;
                }';

            $output .= '
                .col-3-5 .box .box-content.col3 {
                    width: '.$box_content_3_5.'%;
                }
                .col-3-5 .box .box-content.col3 .box-item {
                    width: '.$box_item_3_5.'%;
                }';

            $output .= '
                .col-3-6 .box .box-content.col4 {
                    width: '.$box_content_3_6.'%;
                }
                .col-3-6 .box .box-content.col4 .box-item {
                    width: '.$box_item_3_6.'%;
                }
                ';

        $output .= '}';

        $output .= '@media only screen and (min-width:480px) and (max-width:782px) {';
            $output .= '
      
            #header .box.col-item:not(.col-1){
                display: inline-block;
                float: left;
                margin-left: 0 !important;
                margin-right: 0 !important;
                width: '.( (100 - ($gutter))/2 ).'% !important;
            }

            #header .box.col-item.header-widget-1:not(.box-last),
            #header .box.col-item.header-widget-3,
            #header .box.col-item.header-widget-5 {
                margin-right: '.$gutter.'% !important;
            }

            #footer-widgets .box.col-item:not(.col-1){
                display: inline-block;
                float: left;
                margin-left: 0 !important;
                margin-right: 0 !important;
                width: '.( (100 - ($gutter))/2 ).'% !important;
            }

            #footer-widgets .box.col-item.footer-widget-1:not(.box-last),
            #footer-widgets .box.col-item.footer-widget-3,
            #footer-widgets .box.col-item.footer-widget-5 {
                margin-right: '.$gutter.'% !important;
            }

            #content #main .box-content {
                width: '.$box_content_2.'% !important;
            }
            #content #main .box-content .box-item {
                width: '.$box_item_2.'% !important;
            }
            #content #main .box.col-item {
                display: inline-block;
                float: left;
                margin-left: 0 !important;
            }
            .full_container .box.col-item:not(.col-1) {
                display: inline-block;
                float: left;
                margin-left: 0 !important;
                margin-right: 0 !important;
                width: '.( (100 - ($gutter))/2 ).'% !important;
            }
            .full_container .box.col-item.widgetized-1:not(.box-last),
            .full_container .box.col-item.widgetized-3,
            .full_container .box.col-item.widgetized-5 {
                margin-right: '.$gutter.'% !important;
            }

            #content #sidebar .sidebar-wrap-content,
            #content #sidebar-alt .sidebar-wrap-content {
                width: '.$box_content_2.'% !important;
            }
            #content #sidebar .masonry_widget,
            #content #sidebar-alt .masonry_widget {
                margin-left: auto !important;
                margin-right: auto !important;
                width: '.$box_item_2.'% !important;
            }

            .col-2 .box.col-item {
                float: left;
                width: '.( (100 - ($gutter))/2 ).'% !important;
            }
            #boxes .col-item-content {
                margin-left: 0 !important;
                margin-right: '.$gutter.'% !important;
            }
            .woocommerce .summary.content-col-2 {
                width: '.( (100 - ($gutter))/2 ).'% !important;
            }
            ';
        $output .= '}';

        return $output;
    }
}

/*-----------------------------------------------------------------------------------*/
/* responsi_build_dynamic_css() */
/*-----------------------------------------------------------------------------------*/

function responsi_build_dynamic_css( $preview = false ) {

    if ( !$preview ) {
        $responsi_options = responsi_options();
    } else {
        global $responsi_options;
        if ( !is_array( $responsi_options ) ) {
            return '';
        }
    }
    
    $dynamic_css = '';
    
    /* Gutter */
    $gutter_horizontal  = isset( $responsi_options['responsi_layout_gutter'] ) ? esc_attr( $responsi_options['responsi_layout_gutter'] ) : 2;
    $gutter_vertical    = isset( $responsi_options['responsi_layout_gutter_vertical'] ) ? esc_attr( $responsi_options['responsi_layout_gutter_vertical'] ) : 20;

    $gutter = apply_filters( 'responsi_gutter', array(
        'gutter'            => $gutter_horizontal,
        'gutter_vertical'   => $gutter_vertical
    ));

    if ( function_exists('responsi_dynamic_gutter') ) {
        $dynamic_css .= responsi_dynamic_gutter( $gutter );
    }

    /* Body Background */
    $responsi_use_style_bg_image                = isset($responsi_options['responsi_use_style_bg_image']) ? esc_attr( $responsi_options['responsi_use_style_bg_image'] ) : 'false';
    $responsi_style_bg                          = isset($responsi_options['responsi_style_bg']) ? $responsi_options['responsi_style_bg'] : array( 'onoff' => 'true', 'color' => '#ffffff' );
    $responsi_style_bg_image                    = isset($responsi_options['responsi_style_bg_image']) ? str_replace( array( 'https:', 'http:' ), '', esc_url( $responsi_options['responsi_style_bg_image'] ) ) : '';
    $responsi_style_bg_image_repeat             = isset($responsi_options['responsi_style_bg_image_repeat']) ? esc_attr( $responsi_options['responsi_style_bg_image_repeat'] ) : 'repeat';
    $responsi_style_bg_image_attachment         = isset($responsi_options['responsi_style_bg_image_attachment']) ? esc_attr( $responsi_options['responsi_style_bg_image_attachment'] ) : 'inherit';
    $responsi_bg_position_vertical              = isset($responsi_options['responsi_bg_position_vertical']) ? esc_attr( $responsi_options['responsi_bg_position_vertical'] ) : 'center';
    $responsi_bg_position_horizontal            = isset($responsi_options['responsi_bg_position_horizontal']) ? esc_attr( $responsi_options['responsi_bg_position_horizontal'] ) : 'center';
    $responsi_background_style_img              = isset($responsi_options['responsi_background_style_img']) ? esc_attr( $responsi_options['responsi_background_style_img'] ) : '';
    $responsi_disable_background_style_img      = isset($responsi_options['responsi_disable_background_style_img']) ? esc_attr( $responsi_options['responsi_disable_background_style_img'] ) : 'false';
    $responsi_use_bg_size                       = isset($responsi_options['responsi_use_bg_size']) ? esc_attr( $responsi_options['responsi_use_bg_size'] ) : 'false';
    $responsi_bg_size_width                     = isset($responsi_options['responsi_bg_size_width']) ? esc_attr( $responsi_options['responsi_bg_size_width'] ) : '100%';
    $responsi_bg_size_height                    = isset($responsi_options['responsi_bg_size_height']) ? esc_attr( $responsi_options['responsi_bg_size_height'] ) : 'auto';
    $bg_image_size = '';
    if ($responsi_use_bg_size == 'true') {
        $bg_image_size = 'background-size:' . $responsi_bg_size_width . ' ' . $responsi_bg_size_height . ';';
    }
    $body_background_css = '';
    if ( 'true' === $responsi_use_style_bg_image ) {
        $body_background_css .= responsi_generate_background_color( $responsi_style_bg );
        $body_background_css .= 'background-image:url("' . $responsi_style_bg_image . '");';
        $body_background_css .= 'background-repeat:' . $responsi_style_bg_image_repeat . ';';
        $body_background_css .= 'background-attachment:' . $responsi_style_bg_image_attachment . ';';
        $body_background_css .= 'background-position:' . $responsi_bg_position_horizontal . ' ' . $responsi_bg_position_vertical . ';';
        $body_background_css .= $bg_image_size;
        $dynamic_css .= 'body {' . $body_background_css . '}';
        $dynamic_css .= 'body.mobile-view #wrap:after{
            content:"";
            z-index: -1;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background-attachment: inherit;
            background-image: url("' . $responsi_style_bg_image . '");
            ' . responsi_generate_background_color($responsi_style_bg) . '
            background-position:' . $responsi_bg_position_horizontal . ' ' . $responsi_bg_position_vertical . ';
            background-repeat: ' . $responsi_style_bg_image_repeat . ';' . $bg_image_size . '
        }';
    } else {
        if ( 'true' === $responsi_disable_background_style_img && '' !== $responsi_background_style_img ) {
            $dynamic_css .= 'body{
                background-attachment: ' . $responsi_style_bg_image_attachment . ';
                background-image: url("' . $responsi_background_style_img . '");
                ' . responsi_generate_background_color($responsi_style_bg) . '
                background-position:' . $responsi_bg_position_horizontal . ' ' . $responsi_bg_position_vertical . ';
                background-repeat: repeat;
            }';
        } else {
            $dynamic_css .= 'body{
                background-attachment: ' . $responsi_style_bg_image_attachment . ';
                ' . responsi_generate_background_color( $responsi_style_bg ) . '
                background-position:' . $responsi_bg_position_horizontal . ' ' . $responsi_bg_position_vertical . ';
                background-repeat: ' . $responsi_style_bg_image_repeat . ';
            }';
        }
    }

    /* Layout */
    $is_layout_boxed                        = isset( $responsi_options['responsi_layout_boxed'] ) ? esc_attr( $responsi_options['responsi_layout_boxed'] ) : 'true';
    $boxes_width                            = isset( $responsi_options['responsi_layout_width'] ) ? esc_attr( $responsi_options['responsi_layout_width'] ) : 940;
    $is_enable_boxed_style                  = isset( $responsi_options['responsi_enable_boxed_style'] ) ? esc_attr( $responsi_options['responsi_enable_boxed_style'] ) : 'false';
    $box_margin_top                         = isset( $responsi_options['responsi_box_margin_top'] ) ? esc_attr( $responsi_options['responsi_box_margin_top'] ) : 0;
    $box_margin_bottom                      = isset( $responsi_options['responsi_box_margin_bottom'] ) ? esc_attr( $responsi_options['responsi_box_margin_bottom'] ) : 0;
    $box_margin_left                        = isset( $responsi_options['responsi_box_margin_left'] ) ? esc_attr( $responsi_options['responsi_box_margin_left'] ) : 0;
    $box_margin_right                       = isset( $responsi_options['responsi_box_margin_right'] ) ? esc_attr( $responsi_options['responsi_box_margin_right'] ) : 0;
    $responsi_box_padding_top               = isset( $responsi_options['responsi_box_padding_top'] ) ? esc_attr( $responsi_options['responsi_box_padding_top'] ) : 0;
    $responsi_box_padding_bottom            = isset( $responsi_options['responsi_box_padding_bottom'] ) ? esc_attr( $responsi_options['responsi_box_padding_bottom'] ) : 0;
    $responsi_box_padding_left              = isset( $responsi_options['responsi_box_padding_left'] ) ? esc_attr( $responsi_options['responsi_box_padding_left'] ) : 0;
    $responsi_box_padding_right             = isset( $responsi_options['responsi_box_padding_right'] ) ? esc_attr( $responsi_options['responsi_box_padding_right'] ) : 0;
    $box_border_tb                          = isset( $responsi_options['responsi_box_border_tb'] ) ? $responsi_options['responsi_box_border_tb'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $box_border_lr                          = isset( $responsi_options['responsi_box_border_lr'] ) ? $responsi_options['responsi_box_border_lr'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $box_border_radius_option               = isset( $responsi_options['responsi_box_border_radius'] ) ? $responsi_options['responsi_box_border_radius'] : array( 'corner' => 'square','rounded_value' => '0' );
    $box_shadow_option                      = isset( $responsi_options['responsi_box_shadow'] ) ? $responsi_options['responsi_box_shadow'] : array( 'onoff' => 'false' , 'h_shadow' => '0px' , 'v_shadow' => '0px', 'blur' => '5px' , 'spread' => '0px', 'color' => '#DBDBDB', 'inset' => '' );
    $box_border_radius                      = responsi_generate_border_radius( $box_border_radius_option );
    $box_shadow                             = responsi_generate_box_shadow( $box_shadow_option, false );
    $box_inner_margin_top                   = isset( $responsi_options['responsi_box_inner_margin_top'] ) ? esc_attr( $responsi_options['responsi_box_inner_margin_top'] ) : 0;
    $box_inner_margin_bottom                = isset( $responsi_options['responsi_box_inner_margin_bottom'] ) ? esc_attr( $responsi_options['responsi_box_inner_margin_bottom'] ) : 0;
    $box_inner_margin_left                  = isset( $responsi_options['responsi_box_inner_margin_left'] ) ? esc_attr( $responsi_options['responsi_box_inner_margin_left'] ) : 0;
    $box_inner_margin_right                 = isset( $responsi_options['responsi_box_inner_margin_right'] ) ? esc_attr( $responsi_options['responsi_box_inner_margin_right'] ) : 0;
    $responsi_box_inner_padding_top         = isset( $responsi_options['responsi_box_inner_padding_top'] ) ? esc_attr( $responsi_options['responsi_box_inner_padding_top'] ) : 0;
    $responsi_box_inner_padding_bottom      = isset( $responsi_options['responsi_box_inner_padding_bottom'] ) ? esc_attr( $responsi_options['responsi_box_inner_padding_bottom'] ) : 0;
    $responsi_box_inner_padding_left        = isset( $responsi_options['responsi_box_inner_padding_left'] ) ? esc_attr( $responsi_options['responsi_box_inner_padding_left'] ) : 0;
    $responsi_box_inner_padding_right       = isset( $responsi_options['responsi_box_inner_padding_right'] ) ? esc_attr( $responsi_options['responsi_box_inner_padding_right'] ) : 0;
    $box_inner_border_top                   = isset( $responsi_options['responsi_box_inner_border_top'] ) ? $responsi_options['responsi_box_inner_border_top'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $box_inner_border_bottom                = isset( $responsi_options['responsi_box_inner_border_bottom'] ) ? $responsi_options['responsi_box_inner_border_bottom'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $box_inner_border_left                  = isset( $responsi_options['responsi_box_inner_border_left'] ) ? $responsi_options['responsi_box_inner_border_left'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $box_inner_border_right                 = isset( $responsi_options['responsi_box_inner_border_right'] ) ? $responsi_options['responsi_box_inner_border_right'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $box_inner_border_radius_option         = isset( $responsi_options['responsi_box_inner_border_radius'] ) ? $responsi_options['responsi_box_inner_border_radius'] : array( 'corner' => 'square','rounded_value' => '0' );
    $box_inner_shadow_option                = isset( $responsi_options['responsi_box_inner_shadow'] ) ? $responsi_options['responsi_box_inner_shadow'] : array( 'onoff' => 'false' , 'h_shadow' => '0px' , 'v_shadow' => '0px', 'blur' => '5px' , 'spread' => '0px', 'color' => '#DBDBDB', 'inset' => '' );
    $box_inner_border_radius                = responsi_generate_border_radius( $box_inner_border_radius_option );
    $box_inner_shadow                       = responsi_generate_box_shadow( $box_inner_shadow_option, false );
    $box_inner_bg                           = isset( $responsi_options['responsi_box_inner_bg'] ) ? $responsi_options['responsi_box_inner_bg'] : array( 'onoff' => 'false', 'color' => '#ffffff' );
    
    $wrapper = '';
    $box_inner_css = '';

    $border_width_boxed = 0;

    if ( 'true' === $is_layout_boxed ) {
        if ( 'true' === $is_enable_boxed_style ) {
            $wrapper .= 'margin-top:' . $box_margin_top . 'px;';
            $wrapper .= 'margin-bottom:' . $box_margin_bottom . 'px;';
            $wrapper .= 'margin-left:' . $box_margin_left . 'px;';
            $wrapper .= 'margin-right:' . $box_margin_right . 'px;';
            $wrapper .= 'padding-top:' . $responsi_box_padding_top . 'px;';
            $wrapper .= 'padding-bottom:' . $responsi_box_padding_bottom . 'px;';
            $wrapper .= 'padding-left:' . $responsi_box_padding_left . 'px;';
            $wrapper .= 'padding-right:' . $responsi_box_padding_right . 'px;';
            $wrapper .= responsi_generate_border( $box_border_tb, 'border-top' );
            $wrapper .= responsi_generate_border( $box_border_tb, 'border-bottom' );
            $wrapper .= responsi_generate_border( $box_border_lr, 'border-left' );
            $wrapper .= responsi_generate_border( $box_border_lr, 'border-right' );
            $wrapper .= $box_border_radius;
            if ( $box_shadow_option['inset'] != 'inset' ) {
                $wrapper .= $box_shadow;
            }
           
            $box_inner_css .= responsi_generate_background_color( $box_inner_bg );
            $box_inner_css .= 'margin-top:' . $box_inner_margin_top . 'px;';
            $box_inner_css .= 'margin-bottom:' . $box_inner_margin_bottom . 'px;';
            $box_inner_css .= 'margin-left:' . $box_inner_margin_left . 'px;';
            $box_inner_css .= 'margin-right:' . $box_inner_margin_right . 'px;';
            $box_inner_css .= 'padding-top:' . $responsi_box_inner_padding_top . 'px;';
            $box_inner_css .= 'padding-bottom:' . $responsi_box_inner_padding_bottom . 'px;';
            $box_inner_css .= 'padding-left:' . $responsi_box_inner_padding_left . 'px;';
            $box_inner_css .= 'padding-right:' . $responsi_box_inner_padding_right . 'px;';
            $box_inner_css .= responsi_generate_border( $box_inner_border_top, 'border-top' );
            $box_inner_css .= responsi_generate_border( $box_inner_border_bottom, 'border-bottom' );
            $box_inner_css .= responsi_generate_border( $box_inner_border_left, 'border-left' );
            $box_inner_css .= responsi_generate_border( $box_inner_border_right, 'border-right' );
            $box_inner_css .= $box_inner_border_radius;
            $box_inner_css .= $box_inner_shadow;
            if ( is_array( $box_border_lr ) && isset( $box_border_lr['width'] ) && $box_border_lr['width'] >= 0) {
                $border_width_boxed = ( (int) esc_attr( $box_border_lr['width'] ) ) * 2;
            }
            $boxes_width = $boxes_width + $border_width_boxed;
            $dynamic_css .= '.layout-box-mode #wrapper-boxes{' . $wrapper . '}';
            $dynamic_css .= '#wrapper-boxes-content{' . $box_inner_css . '}';
            
        } else {
            $dynamic_css .= '#wrapper-boxes-content,.layout-box-mode #wrapper-boxes{padding:0 !important;margin:0 !important;border:none !important;border-radius:0px !important;box-shadow:none !important;background-color:transparent !important;}';
        }
    } else {
        $dynamic_css .= '#wrapper-boxes-content,.layout-box-mode #wrapper-boxes{padding:0 !important;margin:0 !important;border:none !important;border-radius:0px !important;box-shadow:none !important;background-color:transparent !important;}';
    }

    $dynamic_css .= '@media only screen and (min-width: 783px){.site-width{ max-width:' . $boxes_width . 'px; margin:auto; padding:0 !important; }}';
    
    /* Wrapper */
    $_wrapper_padding_top                   = isset( $responsi_options['responsi_wrapper_padding_top'] ) ? esc_attr( $responsi_options['responsi_wrapper_padding_top'] ) : 0;
    $_wrapper_padding_bottom                = isset( $responsi_options['responsi_wrapper_padding_bottom'] ) ? esc_attr( $responsi_options['responsi_wrapper_padding_bottom'] ) : 0;
    $_wrapper_padding_left                  = isset( $responsi_options['responsi_wrapper_padding_left'] ) ? esc_attr( $responsi_options['responsi_wrapper_padding_left'] ) : 0;
    $_wrapper_padding_right                 = isset( $responsi_options['responsi_wrapper_padding_right'] ) ? esc_attr( $responsi_options['responsi_wrapper_padding_right'] ) : 0;
    $_wrapper_margin_top                    = isset( $responsi_options['responsi_wrapper_margin_top'] ) ? esc_attr( $responsi_options['responsi_wrapper_margin_top'] ) : 0;
    $_wrapper_margin_bottom                 = isset( $responsi_options['responsi_wrapper_margin_bottom'] ) ? esc_attr( $responsi_options['responsi_wrapper_margin_bottom'] ) : 0;
    $_wrapper_margin_left                   = isset( $responsi_options['responsi_wrapper_margin_left'] ) ? esc_attr( $responsi_options['responsi_wrapper_margin_left'] ) : 0;
    $_wrapper_margin_right                  = isset( $responsi_options['responsi_wrapper_margin_right'] ) ? esc_attr( $responsi_options['responsi_wrapper_margin_right'] ) : 0;
    $_wrapper_border_top                    = isset( $responsi_options['responsi_wrapper_border_top'] ) ? $responsi_options['responsi_wrapper_border_top'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $_wrapper_border_bottom                 = isset( $responsi_options['responsi_wrapper_border_bottom'] ) ? $responsi_options['responsi_wrapper_border_bottom'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $_wrapper_border_left_right             = isset( $responsi_options['responsi_wrapper_border_left_right'] ) ? $responsi_options['responsi_wrapper_border_left_right'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $_wrapper_border_radius_option          = isset( $responsi_options['responsi_wrapper_border_radius'] ) ? $responsi_options['responsi_wrapper_border_radius'] : array( 'corner' => 'square','rounded_value' => '0' );
    $_wrapper_border_box_shadow_option      = isset( $responsi_options['responsi_wrapper_border_box_shadow'] ) ? $responsi_options['responsi_wrapper_border_box_shadow'] : array( 'onoff' => 'false' , 'h_shadow' => '0px' , 'v_shadow' => '0px', 'blur' => '5px' , 'spread' => '0px', 'color' => '#DBDBDB', 'inset' => '' );
    $_wrapper_border_radius                 = responsi_generate_border_radius( $_wrapper_border_radius_option );
    $_wrapper_border_box_shadow             = responsi_generate_box_shadow( $_wrapper_border_box_shadow_option, false );
    $responsi_wrap_content_background       = isset( $responsi_options['responsi_wrap_content_background'] ) ? $responsi_options['responsi_wrap_content_background'] : array( 'onoff' => 'false', 'color' => '#ffffff' );
    $responsi_wrap_container_background     = isset( $responsi_options['responsi_wrap_container_background'] ) ? $responsi_options['responsi_wrap_container_background'] : array( 'onoff' => 'false', 'color' => '#ffffff' );

    $content_inside = 'position:relative;';    
    $content_inside .= responsi_generate_background_color( $responsi_wrap_content_background );
    $content_inside .= 'margin-top:' . $_wrapper_margin_top . 'px;';
    $content_inside .= 'margin-bottom:' . $_wrapper_margin_bottom . 'px;';
    $content_inside .= 'margin-left:' . $_wrapper_margin_left . 'px;';
    $content_inside .= 'margin-right:' . $_wrapper_margin_right . 'px;';
    $content_inside .= 'padding-top:' . $_wrapper_padding_top . 'px;';
    $content_inside .= 'padding-bottom:' . $_wrapper_padding_bottom . 'px;';
    $content_inside .= 'padding-left:' . $_wrapper_padding_left . 'px;';
    $content_inside .= 'padding-right:' . $_wrapper_padding_right . 'px;';
    $content_inside .= responsi_generate_border( $_wrapper_border_top, 'border-top' );
    $content_inside .= responsi_generate_border( $_wrapper_border_bottom, 'border-bottom' );
    $content_inside .= responsi_generate_border( $_wrapper_border_left_right, 'border-left' );
    $content_inside .= responsi_generate_border( $_wrapper_border_left_right, 'border-right' );
    $content_inside .= $_wrapper_border_radius;
    $content_inside .= $_wrapper_border_box_shadow;

    $dynamic_css .= '#wrapper-article{' . $content_inside . '}';
    $dynamic_css .= '#wrapper-content{position:relative;z-index:0;' . responsi_generate_background_color( $responsi_wrap_container_background ) . '}';
    
    /* Settings */
    $link                                   = isset( $responsi_options['responsi_link_color'] ) ? esc_attr( $responsi_options['responsi_link_color'] ) : '#009ee0';
    $hover                                  = isset( $responsi_options['responsi_link_hover_color'] ) ? esc_attr( $responsi_options['responsi_link_hover_color'] ) : '#ff6868';
    $link_visited_color                     = isset( $responsi_options['responsi_link_visited_color'] ) ? esc_attr( $responsi_options['responsi_link_visited_color'] ) : '#009ee0';
    $button_text                            = isset( $responsi_options['responsi_button_text'] ) ? $responsi_options['responsi_button_text'] : array('size' => '12','line_height' => '1.2','face' => 'Open Sans','style' => 'bold','color' => '#FFFFFF');
    $button_text_transform                  = isset( $responsi_options['responsi_button_text_transform'] ) ? esc_attr( $responsi_options['responsi_button_text_transform'] ) : 'uppercase';
    $button                                 = isset( $responsi_options['responsi_button_color'] ) ? esc_attr( $responsi_options['responsi_button_color'] ) : '#ff6868';
    $button_gradient_from                   = isset( $responsi_options['responsi_button_gradient_from'] ) ? esc_attr( $responsi_options['responsi_button_gradient_from'] ) : '#ff6868';
    $button_gradient_to                     = isset( $responsi_options['responsi_button_gradient_to'] ) ? esc_attr( $responsi_options['responsi_button_gradient_to'] ) : '#ff6868';
    $button_padding_top                     = isset( $responsi_options['responsi_button_padding_top'] ) ? esc_attr( $responsi_options['responsi_button_padding_top'] ) : 0;
    $button_padding_bottom                  = isset( $responsi_options['responsi_button_padding_bottom'] ) ? esc_attr( $responsi_options['responsi_button_padding_bottom'] ) : 0;
    $button_padding_left                    = isset( $responsi_options['responsi_button_padding_left'] ) ? esc_attr( $responsi_options['responsi_button_padding_left'] ) : 0;
    $button_padding_right                   = isset( $responsi_options['responsi_button_padding_right'] ) ? esc_attr( $responsi_options['responsi_button_padding_right'] ) : 0;
    $a_button_padding_top                   = $button_padding_top + 1;
    $a_button_padding_bottom                = $button_padding_bottom + 1;
    $button_border_top                      = isset( $responsi_options['responsi_button_border_top'] ) ? $responsi_options['responsi_button_border_top'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $button_border_bottom                   = isset( $responsi_options['responsi_button_border_bottom'] ) ? $responsi_options['responsi_button_border_bottom'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $button_border_left                     = isset( $responsi_options['responsi_button_border_left'] ) ? $responsi_options['responsi_button_border_left'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $button_border_right                    = isset( $responsi_options['responsi_button_border_right'] ) ? $responsi_options['responsi_button_border_right'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $button_border_radius_tl_option         = isset( $responsi_options['responsi_button_border_radius_tl'] ) ? $responsi_options['responsi_button_border_radius_tl'] : array( 'corner' => 'square','rounded_value' => '0' );
    $button_border_radius_tr_option         = isset( $responsi_options['responsi_button_border_radius_tr'] ) ? $responsi_options['responsi_button_border_radius_tr'] : array( 'corner' => 'square','rounded_value' => '0' );
    $button_border_radius_bl_option         = isset( $responsi_options['responsi_button_border_radius_bl'] ) ? $responsi_options['responsi_button_border_radius_bl'] : array( 'corner' => 'square','rounded_value' => '0' );
    $button_border_radius_br_option         = isset( $responsi_options['responsi_button_border_radius_br'] ) ? $responsi_options['responsi_button_border_radius_br'] : array( 'corner' => 'square','rounded_value' => '0' );
    $button_border_radius_tl                = responsi_generate_border_radius_value( $button_border_radius_tl_option );
    $button_border_radius_tr                = responsi_generate_border_radius_value( $button_border_radius_tr_option );
    $button_border_radius_bl                = responsi_generate_border_radius_value( $button_border_radius_bl_option );
    $button_border_radius_br                = responsi_generate_border_radius_value( $button_border_radius_br_option );
    $button_border_box_shadow_option        = isset( $responsi_options['responsi_button_border_box_shadow'] ) ? $responsi_options['responsi_button_border_box_shadow'] : array( 'onoff' => 'false' , 'h_shadow' => '0px' , 'v_shadow' => '0px', 'blur' => '5px' , 'spread' => '0px', 'color' => '#DBDBDB', 'inset' => '' );
    $button_border_box_shadow               = responsi_generate_box_shadow( $button_border_box_shadow_option, false );
    $button_text_shadow                     = isset( $responsi_options['responsi_button_text_shadow'] ) ? $responsi_options['responsi_button_text_shadow'] : 'true';
    if ( 'true' === $button_text_shadow ) {
        $button_text_shadow_value = '0 -1px 1px rgba(0, 0, 0, 0.25)';
    }else{
        $button_text_shadow_value = '0 0px 0px rgba(0, 0, 0, 0.25)';
    }

    $dynamic_css .= 'a,a:link, a:visited{color:' . $link . '}';
    $dynamic_css .= 'a:visited{color:' . $link_visited_color . '}';
    $dynamic_css .= 'a:hover, .post-meta a:hover, .post p.tags a:hover,.post-entries a:hover{color:' . $hover . '}';
    
    $bt_css = '';
    $bt_css .= 'display: inline-block;text-decoration: none !important;white-space: nowrap;position: relative;cursor: pointer;';
    $bt_css .= 'padding-top:' . $button_padding_top . 'px;';
    $bt_css .= 'padding-bottom:' . $button_padding_bottom . 'px;';
    $bt_css .= 'padding-left:' . $button_padding_left . 'px;';
    $bt_css .= 'padding-right:' . $button_padding_right . 'px;';
    $bt_css .= responsi_generate_fonts( $button_text );
    $bt_css .= 'line-height: normal';
    $bt_css .= 'text-transform: ' . $button_text_transform . ';';
    $bt_css .= 'text-shadow: ' . $button_text_shadow_value . ';';
    $bt_css .= 'background-color: ' . $button . ';';
    $bt_css .= 'background: linear-gradient( ' . $button_gradient_from . ' , ' . $button_gradient_to . ' );';
    $bt_css .= responsi_generate_border( $button_border_top, 'border-top' );
    $bt_css .= responsi_generate_border( $button_border_bottom, 'border-bottom' );
    $bt_css .= responsi_generate_border( $button_border_left, 'border-left' );
    $bt_css .= responsi_generate_border( $button_border_right, 'border-right' );
    $bt_css .= 'border-radius:' . $button_border_radius_tl . ' ' . $button_border_radius_tr . ' ' . $button_border_radius_br . ' ' . $button_border_radius_bl . ';';
    $bt_css .= $button_border_box_shadow;

    $button_excludes = responsi_exclude_button_css();

    $dynamic_css .= '
    button'.$button_excludes.',
    button:visited'.$button_excludes.',
    input[type=button]'.$button_excludes.',
    input[type=button]:visited'.$button_excludes.',
    input[type=reset]'.$button_excludes.',
    input[type=reset]:visited'.$button_excludes.',
    input[type=submit]'.$button_excludes.',
    input[type=submit]:visited'.$button_excludes.',
    input#submit'.$button_excludes.',
    input#submit:visited'.$button_excludes.',
    .button'.$button_excludes.',
    .button:visited'.$button_excludes.'{'.$bt_css.'}';

    $dynamic_css .= '
    button'.$button_excludes.':hover,
    button:visited'.$button_excludes.':hover,
    input[type=button]'.$button_excludes.':hover,
    input[type=button]:visited'.$button_excludes.':hover,
    input[type=reset]'.$button_excludes.':hover,
    input[type=reset]:visited'.$button_excludes.':hover,
    input[type=submit]'.$button_excludes.':hover,
    input[type=submit]:visited'.$button_excludes.':hover,
    input#submit'.$button_excludes.':hover,
    input#submit:visited'.$button_excludes.':hover,
    .button'.$button_excludes.':hover,
    .button:visited'.$button_excludes.':hover {color:' . esc_attr( $button_text['color'] ) . ' !important;}';

    /* Typography */
    $font_text                              = isset( $responsi_options['responsi_font_text'] ) ? $responsi_options['responsi_font_text'] : array('size' => '14','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#555555');
    $font_h1                                = isset( $responsi_options['responsi_font_h1'] ) ? $responsi_options['responsi_font_h1'] : array('size' => '26','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#009ee0');
    $font_h2                                = isset( $responsi_options['responsi_font_h2'] ) ? $responsi_options['responsi_font_h2'] : array('size' => '24','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#009ee0');
    $font_h3                                = isset( $responsi_options['responsi_font_h3'] ) ? $responsi_options['responsi_font_h3'] : array('size' => '22','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#009ee0');
    $font_h4                                = isset( $responsi_options['responsi_font_h4'] ) ? $responsi_options['responsi_font_h4'] : array('size' => '20','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#009ee0');
    $font_h5                                = isset( $responsi_options['responsi_font_h5'] ) ? $responsi_options['responsi_font_h5'] : array('size' => '18','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#009ee0');
    $font_h6                                = isset( $responsi_options['responsi_font_h6'] ) ? $responsi_options['responsi_font_h6'] : array('size' => '16','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#009ee0');
    $dynamic_css .= 'body{' . responsi_generate_fonts( $font_text ) . '}';
    $dynamic_css .= 'h1{' . responsi_generate_fonts( $font_h1 ) . '}';
    $dynamic_css .= 'h2{' . responsi_generate_fonts( $font_h2 ) . '}';
    $dynamic_css .= 'h3{' . responsi_generate_fonts( $font_h3 ) . '}';
    $dynamic_css .= 'h4{' . responsi_generate_fonts( $font_h4 ) . '}';
    $dynamic_css .= 'h5{' . responsi_generate_fonts( $font_h5 ) . '}';
    $dynamic_css .= 'h6{' . responsi_generate_fonts( $font_h6 ) . '}';
    
    /* Breadcrumbs */
    $breadcrumbs_show                       = isset( $responsi_options['responsi_breadcrumbs_show'] ) ? esc_attr( $responsi_options['responsi_breadcrumbs_show'] ) : 'false';
    $breadcrumbs_font                       = isset( $responsi_options['responsi_breadcrumbs_font'] ) ? $responsi_options['responsi_breadcrumbs_font'] : array('size' => '14','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#555555');
    $breadcrumbs_link                       = isset( $responsi_options['responsi_breadcrumbs_link'] ) ? esc_attr( $responsi_options['responsi_breadcrumbs_link'] ) : '#009ee0';
    $breadcrumbs_link_hover                 = isset( $responsi_options['responsi_breadcrumbs_link_hover'] ) ? esc_attr( $responsi_options['responsi_breadcrumbs_link_hover'] ) : '#ff6868';
    $breadcrumbs_sep                        = isset( $responsi_options['responsi_breadcrumbs_sep'] ) ? esc_attr( $responsi_options['responsi_breadcrumbs_sep'] ) : '#CCCCCC';
    $breadcrumbs_padding_top                = isset( $responsi_options['responsi_breadcrumbs_padding_top'] ) ? esc_attr( $responsi_options['responsi_breadcrumbs_padding_top'] ) : 0;
    $breadcrumbs_padding_bottom             = isset( $responsi_options['responsi_breadcrumbs_padding_bottom'] ) ? esc_attr( $responsi_options['responsi_breadcrumbs_padding_bottom'] ) : 0;
    $breadcrumbs_padding_left               = isset( $responsi_options['responsi_breadcrumbs_padding_left'] ) ? esc_attr( $responsi_options['responsi_breadcrumbs_padding_left'] ) : 0;
    $breadcrumbs_padding_right              = isset( $responsi_options['responsi_breadcrumbs_padding_right'] ) ? esc_attr( $responsi_options['responsi_breadcrumbs_padding_right'] ) : 0;
    $breadcrumbs_margin_top                 = isset( $responsi_options['responsi_breadcrumbs_margin_top'] ) ? esc_attr( $responsi_options['responsi_breadcrumbs_margin_top'] ) : 0;
    $breadcrumbs_margin_bottom              = isset( $responsi_options['responsi_breadcrumbs_margin_bottom'] ) ? esc_attr( $responsi_options['responsi_breadcrumbs_margin_bottom'] ) : 0;
    $breadcrumbs_margin_left                = isset( $responsi_options['responsi_breadcrumbs_margin_left'] ) ? esc_attr( $responsi_options['responsi_breadcrumbs_margin_left'] ) : 0;
    $breadcrumbs_margin_right               = isset( $responsi_options['responsi_breadcrumbs_margin_right'] ) ? esc_attr( $responsi_options['responsi_breadcrumbs_margin_right'] ) : 0;
    $breadcrumbs_bg                         = isset( $responsi_options['responsi_breadcrumbs_bg'] ) ? $responsi_options['responsi_breadcrumbs_bg'] : array( 'onoff' => 'false', 'color' => '#ffffff' );
    $breadcrumbs_border_top                 = isset( $responsi_options['responsi_breadcrumbs_border_top'] ) ? $responsi_options['responsi_breadcrumbs_border_top'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $breadcrumbs_border_bottom              = isset( $responsi_options['responsi_breadcrumbs_border_bottom'] ) ? $responsi_options['responsi_breadcrumbs_border_bottom'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $breadcrumbs_border_lr                  = isset( $responsi_options['responsi_breadcrumbs_border_lr'] ) ? $responsi_options['responsi_breadcrumbs_border_lr'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $breadcrumbs_border_radius_options      = isset( $responsi_options['responsi_breadcrumbs_border_radius'] ) ? $responsi_options['responsi_breadcrumbs_border_radius'] : array( 'corner' => 'square','rounded_value' => '0' );
    $breadcrumbs_box_shadow_option          = isset( $responsi_options['responsi_breadcrumbs_box_shadow'] ) ? $responsi_options['responsi_breadcrumbs_box_shadow'] : array( 'onoff' => 'false' , 'h_shadow' => '0px' , 'v_shadow' => '0px', 'blur' => '5px' , 'spread' => '0px', 'color' => '#DBDBDB', 'inset' => '' );
    $breadcrumbs_border_radius              = responsi_generate_border_radius( $breadcrumbs_border_radius_options );
    $breadcrumbs_box_shadow                 = responsi_generate_box_shadow( $breadcrumbs_box_shadow_option );
    
    $breadcrumbs_css = '';
    if ( 'true' === $breadcrumbs_show ) {
        $breadcrumbs_css_style = '';
        $breadcrumbs_css_style .= responsi_generate_background_color( $breadcrumbs_bg, true );
        $breadcrumbs_css_style .= responsi_generate_border( $breadcrumbs_border_top, 'border-top' );
        $breadcrumbs_css_style .= responsi_generate_border( $breadcrumbs_border_bottom, 'border-bottom' );
        $breadcrumbs_css_style .= responsi_generate_border( $breadcrumbs_border_lr, 'border-left' );
        $breadcrumbs_css_style .= responsi_generate_border( $breadcrumbs_border_lr, 'border-right' );
        $breadcrumbs_css_style .= $breadcrumbs_border_radius;
        $breadcrumbs_css_style .= $breadcrumbs_box_shadow;
        $breadcrumbs_css .= '.breadcrumbs,.breadcrumbs span.trail-end{' . responsi_generate_fonts($breadcrumbs_font) . '} ';
        $breadcrumbs_css .= '.breadcrumbs a{color:' . $breadcrumbs_link . ' !important;}';
        $breadcrumbs_css .= '.breadcrumbs a:hover{color:' . $breadcrumbs_link_hover . ' !important;}';
        $breadcrumbs_css .= '.breadcrumbs span.sep,.breadcrumbs .sep{color:' . $breadcrumbs_sep . ' !important;}';
        $breadcrumbs_css .= '.breadcrumbs{padding-top:' . $breadcrumbs_padding_top . 'px !important;padding-bottom:' . $breadcrumbs_padding_bottom . 'px !important;padding-left:' . $breadcrumbs_padding_left . 'px !important;padding-right:' . $breadcrumbs_padding_right . 'px !important;margin-top:' . $breadcrumbs_margin_top . 'px !important;margin-bottom:' . $breadcrumbs_margin_bottom . 'px !important;margin-left:' . $breadcrumbs_margin_left . 'px !important;margin-right:' . $breadcrumbs_margin_right . 'px !important;}';
        $breadcrumbs_css .= '.breadcrumbs{' . $breadcrumbs_css_style . '}';
    }
    $dynamic_css .= $breadcrumbs_css;

    /* Header */
    $header_bg                              = isset( $responsi_options['responsi_header_bg'] ) ? $responsi_options['responsi_header_bg'] : array( 'onoff' => 'false', 'color' => '#ffffff' );
    $enable_header_bg_image                 = isset( $responsi_options['responsi_enable_header_bg_image'] ) ? esc_attr( $responsi_options['responsi_enable_header_bg_image'] ) : 'false';
    $header_bg_image                        = isset( $responsi_options['responsi_header_bg_image'] ) ? str_replace( array( 'https:', 'http:' ), '', esc_url( $responsi_options['responsi_header_bg_image'] ) ) : '';
    $header_bg_image_repeat                 = isset( $responsi_options['responsi_header_bg_image_repeat'] ) ? esc_attr( $responsi_options['responsi_header_bg_image_repeat'] ) : 'repeat';
    $header_border_top                      = isset( $responsi_options['responsi_header_border_top'] ) ? $responsi_options['responsi_header_border_top'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $header_border_bottom                   = isset( $responsi_options['responsi_header_border_bottom'] ) ? $responsi_options['responsi_header_border_bottom'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $header_border_lr                       = isset( $responsi_options['responsi_header_border_lr'] ) ? $responsi_options['responsi_header_border_lr'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $header_box_shadow_option               = isset( $responsi_options['responsi_header_box_shadow'] ) ? $responsi_options['responsi_header_box_shadow'] : array( 'onoff' => 'false' , 'h_shadow' => '0px' , 'v_shadow' => '0px', 'blur' => '5px' , 'spread' => '0px', 'color' => '#DBDBDB', 'inset' => '' );
    $header_box_shadow                      = responsi_generate_box_shadow( $header_box_shadow_option );
    $header_padding_top                     = isset( $responsi_options['responsi_header_padding_top'] ) ? esc_attr( $responsi_options['responsi_header_padding_top'] ) : 0;
    $header_padding_bottom                  = isset( $responsi_options['responsi_header_padding_bottom'] ) ? esc_attr( $responsi_options['responsi_header_padding_bottom'] ) : 0;
    $header_padding_left                    = isset( $responsi_options['responsi_header_padding_left'] ) ? esc_attr( $responsi_options['responsi_header_padding_left'] ) : 0;
    $header_padding_right                   = isset( $responsi_options['responsi_header_padding_right'] ) ? esc_attr( $responsi_options['responsi_header_padding_right'] ) : 0;
    $header_margin_top                      = isset( $responsi_options['responsi_header_margin_top'] ) ? esc_attr( $responsi_options['responsi_header_margin_top'] ) : 0;
    $header_margin_bottom                   = isset( $responsi_options['responsi_header_margin_bottom'] ) ? esc_attr( $responsi_options['responsi_header_margin_bottom'] ) : 0;
    $header_margin_left                     = isset( $responsi_options['responsi_header_margin_left'] ) ? esc_attr( $responsi_options['responsi_header_margin_left'] ) : 0;
    $header_margin_right                    = isset( $responsi_options['responsi_header_margin_right'] ) ? esc_attr( $responsi_options['responsi_header_margin_right'] ) : 0;
    $font_logo                              = isset( $responsi_options['responsi_font_logo'] ) ? $responsi_options['responsi_font_logo'] : array('size' => '36','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#FFFFFF');
    $font_desc                              = isset( $responsi_options['responsi_font_desc'] ) ? $responsi_options['responsi_font_desc'] : array('size' => '13','line_height' => '1.5','face' => 'PT Sans','style' => 'normal','color' => '#7c7c7c');
    $font_header_widget_title               = isset( $responsi_options['responsi_font_header_widget_title'] ) ? $responsi_options['responsi_font_header_widget_title'] : array('size' => '14','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#ffffff');
    $responsi_font_header_widget_text       = isset( $responsi_options['responsi_font_header_widget_text'] ) ? $responsi_options['responsi_font_header_widget_text'] : array('size' => '13','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#7c7c7c');
    $responsi_font_header_widget_link       = isset( $responsi_options['responsi_font_header_widget_link'] ) ? $responsi_options['responsi_font_header_widget_link'] : array('size' => '13','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#7c7c7c');
    $responsi_font_header_widget_link_hover = isset( $responsi_options['responsi_font_header_widget_link_hover'] ) ? esc_attr( $responsi_options['responsi_font_header_widget_link_hover'] ) : '#ff6868';
    $responsi_bg_header_position_vertical   = isset( $responsi_options['responsi_bg_header_position_vertical'] ) ? esc_attr( $responsi_options['responsi_bg_header_position_vertical'] ) : 'center';
    $responsi_bg_header_position_horizontal = isset( $responsi_options['responsi_bg_header_position_horizontal'] ) ? esc_attr( $responsi_options['responsi_bg_header_position_horizontal'] ) : 'center';
    $responsi_header_widget_text_alignment  = isset( $responsi_options['responsi_font_header_widget_text_alignment'] ) ? esc_attr( $responsi_options['responsi_font_header_widget_text_alignment'] ) : 'left';
       
    $header_css = '';
    $header_css .= 'margin-top:' . $header_margin_top . 'px !important;margin-bottom:' . $header_margin_bottom . 'px !important;';
    $header_css .= 'margin-left:' . $header_margin_left . 'px !important;margin-right:' . $header_margin_right . 'px !important;';
    $header_css .= 'padding-top:' . $header_padding_top . 'px !important;padding-bottom:' . $header_padding_bottom . 'px !important;';
    $header_css .= 'padding-left:' . $header_padding_left . 'px !important;padding-right:' . $header_padding_right . 'px !important;';
    $header_css .= responsi_generate_background_color( $header_bg );
    if ( 'true' === $enable_header_bg_image && '' !== trim( $header_bg_image ) ) {
        $header_css .= 'background-image:url("' . $header_bg_image . '");background-position:' . strtolower($responsi_bg_header_position_horizontal) . ' ' . strtolower($responsi_bg_header_position_vertical) . ';background-repeat:' . $header_bg_image_repeat . ';';
    }
    $header_css .= responsi_generate_border($header_border_top, 'border-top');
    $header_css .= responsi_generate_border($header_border_bottom, 'border-bottom');
    $header_css .= responsi_generate_border($header_border_lr, 'border-left');
    $header_css .= responsi_generate_border($header_border_lr, 'border-right');
    $header_css .= $header_box_shadow;
    $dynamic_css .= '#wrapper-header-content{' . $header_css . '}';

    $header_inner_bg                              = isset( $responsi_options['responsi_header_inner_bg'] ) ? $responsi_options['responsi_header_inner_bg'] : array( 'onoff' => 'false', 'color' => '#ffffff' );
    $enable_header_inner_bg_image                 = isset( $responsi_options['responsi_enable_header_inner_bg_image'] ) ? esc_attr( $responsi_options['responsi_enable_header_inner_bg_image'] ) : 'false';
    $header_inner_bg_image                        = isset( $responsi_options['responsi_header_inner_bg_image'] ) ? str_replace( array( 'https:', 'http:' ), '', esc_url( $responsi_options['responsi_header_inner_bg_image'] ) ) : '';
    $header_inner_bg_image_repeat                 = isset( $responsi_options['responsi_header_inner_bg_image_repeat'] ) ? esc_attr( $responsi_options['responsi_header_inner_bg_image_repeat'] ) : 'repeat';
    $responsi_bg_header_inner_position_vertical   = isset( $responsi_options['responsi_bg_header_inner_position_vertical'] ) ? esc_attr( $responsi_options['responsi_bg_header_inner_position_vertical'] ) : 'center';
    $responsi_bg_header_inner_position_horizontal = isset( $responsi_options['responsi_bg_header_inner_position_horizontal'] ) ? esc_attr( $responsi_options['responsi_bg_header_inner_position_horizontal'] ) : 'center';
    $header_inner_border_top                      = isset( $responsi_options['responsi_header_inner_border_top'] ) ? $responsi_options['responsi_header_inner_border_top'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $header_inner_border_bottom                   = isset( $responsi_options['responsi_header_inner_border_bottom'] ) ? $responsi_options['responsi_header_inner_border_bottom'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $header_inner_border_lr                       = isset( $responsi_options['responsi_header_inner_border_lr'] ) ? $responsi_options['responsi_header_inner_border_lr'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $header_inner_box_shadow_option               = isset( $responsi_options['responsi_header_inner_box_shadow'] ) ? $responsi_options['responsi_header_inner_box_shadow'] : array( 'onoff' => 'false' , 'h_shadow' => '0px' , 'v_shadow' => '0px', 'blur' => '5px' , 'spread' => '0px', 'color' => '#DBDBDB', 'inset' => '' );
    $header_inner_box_shadow                      = responsi_generate_box_shadow( $header_inner_box_shadow_option );
    $header_inner_padding_top                     = isset( $responsi_options['responsi_header_inner_padding_top'] ) ? esc_attr( $responsi_options['responsi_header_inner_padding_top'] ) : 0;
    $header_inner_padding_bottom                  = isset( $responsi_options['responsi_header_inner_padding_bottom'] ) ? esc_attr( $responsi_options['responsi_header_inner_padding_bottom'] ) : 0;
    $header_inner_padding_left                    = isset( $responsi_options['responsi_header_inner_padding_left'] ) ? esc_attr( $responsi_options['responsi_header_inner_padding_left'] ) : 0;
    $header_inner_padding_right                   = isset( $responsi_options['responsi_header_inner_padding_right'] ) ? esc_attr( $responsi_options['responsi_header_inner_padding_right'] ) : 0;
    $header_inner_margin_top                      = isset( $responsi_options['responsi_header_inner_margin_top'] ) ? esc_attr( $responsi_options['responsi_header_inner_margin_top'] ) : 0;
    $header_inner_margin_bottom                   = isset( $responsi_options['responsi_header_inner_margin_bottom'] ) ? esc_attr( $responsi_options['responsi_header_inner_margin_bottom'] ) : 0;
    $header_inner_margin_left                     = isset( $responsi_options['responsi_header_inner_margin_left'] ) ? esc_attr( $responsi_options['responsi_header_inner_margin_left'] ) : 0;
    $header_inner_margin_right                    = isset( $responsi_options['responsi_header_inner_margin_right'] ) ? esc_attr( $responsi_options['responsi_header_inner_margin_right'] ) : 0;
   
    $header_inner_css = '';
    $header_inner_css .= responsi_generate_background_color( $header_inner_bg );
    if ( 'true' === $enable_header_inner_bg_image && '' !== trim( $header_inner_bg_image ) ) {
        $header_inner_css = 'background-image:url("' . $header_inner_bg_image . '");background-position:' . strtolower($responsi_bg_header_inner_position_horizontal) . ' ' . strtolower($responsi_bg_header_inner_position_vertical) . ';background-repeat:' . $header_inner_bg_image_repeat . ';';
    }
    $header_inner_css .= 'margin-top:' . $header_inner_margin_top . 'px !important;margin-bottom:' . $header_inner_margin_bottom . 'px !important;';
    $header_inner_css .= 'margin-left:' . $header_inner_margin_left . 'px !important;margin-right:' . $header_inner_margin_right . 'px !important;';
    $header_inner_css .= 'padding-top:' . $header_inner_padding_top . 'px !important;padding-bottom:' . $header_inner_padding_bottom . 'px !important;';
    $header_inner_css .= 'padding-left:' . $header_inner_padding_left . 'px !important;padding-right:' . $header_inner_padding_right . 'px !important;';
    $header_inner_css .= responsi_generate_border($header_inner_border_top, 'border-top');
    $header_inner_css .= responsi_generate_border($header_inner_border_bottom, 'border-bottom');
    $header_inner_css .= responsi_generate_border($header_inner_border_lr, 'border-left');
    $header_inner_css .= responsi_generate_border($header_inner_border_lr, 'border-right');
    $header_inner_css .= $header_inner_box_shadow;

    $dynamic_css .= '#header-content{' . $header_inner_css . '}';
    $dynamic_css .= '.site-logo-container a.site-title, .site-logo-container a.site-title:hover, .site-logo-container a:link:hover, .site-title, a.site-title:link, a.site-title:hover, a.site-title:link:hover, .header-widget-1 a, .header-widget-1 a:hover, #header .header-widget-1 .widget a, #header .header-widget-1 .widget a:link, #header .header-widget-1 .widget a:link:hover{' . responsi_generate_fonts( $font_logo, true ) . '}';
    $dynamic_css .= '.site-description {' . responsi_generate_fonts($font_desc) . '}';
    $dynamic_css .= '.masonry_widget_header .fw_widget_title h3 {' . responsi_generate_fonts($font_header_widget_title) . '}';
    $dynamic_css .= '#header .widget .textwidget, #header .widget:not(div), #header .widget p,#header .widget label,#header .widget .textwidget,#header .login-username label, #header .login-password label, #header .widget .textwidget .tel, #header .widget .textwidget .tel a, #header .widget .textwidget a[href^=tel], #header .widget * a[href^=tel], #header .widget a[href^=tel]{' . responsi_generate_fonts($responsi_font_header_widget_text) . ' text-decoration: none;}';
    $dynamic_css .= '#header .widget a,#header .widget ul li a,#header .widget ul li{' . responsi_generate_fonts($responsi_font_header_widget_link) . '}';
    $dynamic_css .= '#header .widget a:hover{color:' . $responsi_font_header_widget_link_hover . ';}';
    $dynamic_css .= '.masonry_widget_header .widget{text-align:' . $responsi_header_widget_text_alignment . '}';
    
    $header_widget_alignment_mobile               = isset( $responsi_options['responsi_font_header_widget_text_alignment_mobile'] ) ? esc_attr( $responsi_options['responsi_font_header_widget_text_alignment_mobile'] ) : 'true';
    $header_widget_mobile_margin                  = isset( $responsi_options['responsi_header_widget_mobile_margin'] ) ? esc_attr( $responsi_options['responsi_header_widget_mobile_margin'] ) : 'true';
    $header_widget_mobile_margin_between          = isset( $responsi_options['responsi_header_widget_mobile_margin_between'] ) ? esc_attr( $responsi_options['responsi_header_widget_mobile_margin_between'] ) : 0;
    
    $header_widget_mobile_css = '';

    if ( 'true' === $header_widget_alignment_mobile ) {
        $header_widget_mobile_css .= '.masonry_widget_header .widget, .masonry_widget_header * .widget, .masonry_widget_header .widget *, .masonry_widget_header .widget .fw_widget_title h3, .header-widget-1 .widget .site-logo-container {text-align:center !important;}';
        $header_widget_mobile_css .= '.logo.site-logo,.site-logo-container,.site-description-container{margin:auto;}';
    }

    if ( 'true' === $header_widget_mobile_margin && $header_widget_mobile_margin_between >= 0) {
        $header_widget_mobile_css .= 'body #header .widget{margin-bottom:' . $header_widget_mobile_margin_between . 'px !important;}';
    }else{
        $header_widget_mobile_css .= 'body #header .widget{margin-bottom:0px !important;}';
    }
    $dynamic_css .= '@media only screen and (max-width: 782px){'.$header_widget_mobile_css.'}';
    
    /* Single */
    $font_post_meta                             = isset( $responsi_options['responsi_font_post_meta'] ) ? $responsi_options['responsi_font_post_meta'] : array('size' => '12','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#555555');
    $post_meta_transform                        = isset( $responsi_options['responsi_post_meta_transform'] ) ? esc_attr( $responsi_options['responsi_post_meta_transform'] ) : 'none';
    $post_meta_link                             = isset( $responsi_options['responsi_post_meta_link'] ) ? esc_attr( $responsi_options['responsi_post_meta_link'] ) : '#009ee0';
    $post_meta_link_hover                       = isset( $responsi_options['responsi_post_meta_link_hover'] ) ? esc_attr( $responsi_options['responsi_post_meta_link_hover'] ) : '#ff6868';
    $post_meta_icon                             = isset( $responsi_options['responsi_post_meta_icon'] ) ? esc_attr( $responsi_options['responsi_post_meta_icon'] ) : '#555555';
    $enable_post_meta_icon                      = isset( $responsi_options['responsi_enable_post_meta_icon'] ) ? esc_attr( $responsi_options['responsi_enable_post_meta_icon'] ) : 'true';
    $post_meta_padding_top                      = isset( $responsi_options['responsi_post_meta_padding_top'] ) ? esc_attr( $responsi_options['responsi_post_meta_padding_top'] ) : 0;
    $post_meta_padding_bottom                   = isset( $responsi_options['responsi_post_meta_padding_bottom'] ) ? esc_attr( $responsi_options['responsi_post_meta_padding_bottom'] ) : 0;
    $post_meta_padding_left                     = isset( $responsi_options['responsi_post_meta_padding_left'] ) ? esc_attr( $responsi_options['responsi_post_meta_padding_left'] ) : 0;
    $post_meta_padding_right                    = isset( $responsi_options['responsi_post_meta_padding_right'] ) ? esc_attr( $responsi_options['responsi_post_meta_padding_right'] ) : 0;
    $post_meta_margin_top                       = isset( $responsi_options['responsi_post_meta_margin_top'] ) ? esc_attr( $responsi_options['responsi_post_meta_margin_top'] ) : 0;
    $post_meta_margin_bottom                    = isset( $responsi_options['responsi_post_meta_margin_bottom'] ) ? esc_attr( $responsi_options['responsi_post_meta_margin_bottom'] ) : 0;
    $post_meta_margin_left                      = isset( $responsi_options['responsi_post_meta_margin_left'] ) ? esc_attr( $responsi_options['responsi_post_meta_margin_left'] ) : 0;
    $post_meta_margin_right                     = isset( $responsi_options['responsi_post_meta_margin_right'] ) ? esc_attr( $responsi_options['responsi_post_meta_margin_right'] ) : 0;
    $post_meta_bg                               = isset( $responsi_options['responsi_post_meta_bg'] ) ? $responsi_options['responsi_post_meta_bg'] : array( 'onoff' => 'false', 'color' => '#ffffff' );
    $post_meta_border_top                       = isset( $responsi_options['responsi_post_meta_border_top'] ) ? $responsi_options['responsi_post_meta_border_top'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $post_meta_border_bottom                    = isset( $responsi_options['responsi_post_meta_border_bottom'] ) ? $responsi_options['responsi_post_meta_border_bottom'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $post_meta_border_lr                        = isset( $responsi_options['responsi_post_meta_border_lr'] ) ? $responsi_options['responsi_post_meta_border_lr'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $post_comments_bg                           = isset( $responsi_options['responsi_post_comments_bg'] ) ? $responsi_options['responsi_post_comments_bg'] : array( 'onoff' => 'false', 'color' => '#ffffff' );
    $post_author_archive_bg                     = isset( $responsi_options['responsi_post_author_archive_bg'] ) ? $responsi_options['responsi_post_author_archive_bg'] : array( 'onoff' => 'false', 'color' => '#ffffff' );
    $disable_post_meta_author                   = isset( $responsi_options['responsi_disable_post_meta_author'] ) ? $responsi_options['responsi_disable_post_meta_author'] : 'false';
    $disable_post_meta_date                     = isset( $responsi_options['responsi_disable_post_meta_date'] ) ? $responsi_options['responsi_disable_post_meta_date'] : 'false';
    $disable_post_meta_comment                  = isset( $responsi_options['responsi_disable_post_meta_comment'] ) ? $responsi_options['responsi_disable_post_meta_comment'] : 'false';

    $post_meta_css = '';
    $post_meta_css .= responsi_generate_fonts( $font_post_meta );
    $post_meta_css .= responsi_generate_background_color( $post_meta_bg );
    $post_meta_css .= responsi_generate_border($post_meta_border_top, 'border-top');
    $post_meta_css .= responsi_generate_border($post_meta_border_bottom, 'border-bottom');
    $post_meta_css .= responsi_generate_border($post_meta_border_lr, 'border-left');
    $post_meta_css .= responsi_generate_border($post_meta_border_lr, 'border-right');
    $post_meta_css .= 'margin-top:' . $post_meta_margin_top . 'px !important;margin-bottom:' . $post_meta_margin_bottom . 'px !important;';
    $post_meta_css .= 'margin-left:' . $post_meta_margin_left . 'px !important;margin-right:' . $post_meta_margin_right . 'px !important;';
    $post_meta_css .= 'padding-top:' . $post_meta_padding_top . 'px !important;padding-bottom:' . $post_meta_padding_bottom . 'px !important;';
    $post_meta_css .= 'padding-left:' . $post_meta_padding_left . 'px !important;padding-right:' . $post_meta_padding_right . 'px !important;';
    $post_meta_css .= 'text-transform:' . $post_meta_transform . ';';
    
    $dynamic_css .= '.single .custom_box_post .post-meta {' . $post_meta_css . '}';
    $dynamic_css .= '.single .custom_box_post .post-meta a {text-transform:' . $post_meta_transform . ';color:' . $post_meta_link . ' !important;}';
    $dynamic_css .= '.single .custom_box_post .post-meta a:hover {color:' . $post_meta_link_hover . ' !important;}';
    $dynamic_css .= '.single .custom_box_post .post-meta .i_author:before, .single .custom_box_post .post-meta .i_comment:before, .single .custom_box_post .post-meta .i_authors span.author .fn:before, .single .i_dates time.i_date:before {color:' . $post_meta_icon . ' !important;}';
    $dynamic_css .= '.single .i_dates time.i_date:before{font-size:90%;}';
    if ( 'true' !== $enable_post_meta_icon ) {
        $dynamic_css .= '.single .custom_box_post .post-meta .i_author:before, .single .custom_box_post .post-meta .i_comment:before, .single .custom_box_post .post-meta .i_authors span.author .fn:before, .single .i_dates time.i_date:before{display:none !important;}';
    }
    if ( $disable_post_meta_author != 'true' ) {
        $dynamic_css .= '.single .custom_box_post .post-meta .i_authors{display:none;}';
    }
    if ( 'true' !== $disable_post_meta_date ) {
        $dynamic_css .= '.single .custom_box_post .post-meta .i_dates{display:none;}';
    }
    if ( 'true' !== $disable_post_meta_comment ) {
        $dynamic_css .= '.single .custom_box_post .post-meta .post-comments{display:none;}';
    }
    if ( $disable_post_meta_author != 'true' && 'true' !== $disable_post_meta_date && 'true' !== $disable_post_meta_comment ) {
        $dynamic_css .= '.single .single_content .post-meta{display:none;}';
    }
    
    $post_meta_cat_tag_bg                       = isset( $responsi_options['responsi_post_meta_cat_tag_bg'] ) ? $responsi_options['responsi_post_meta_cat_tag_bg'] : array( 'onoff' => 'false', 'color' => '#ffffff' );
    $post_meta_cat_tag_border_top               = isset( $responsi_options['responsi_post_meta_cat_tag_border_top'] ) ? $responsi_options['responsi_post_meta_cat_tag_border_top'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $post_meta_cat_tag_border_bottom            = isset( $responsi_options['responsi_post_meta_cat_tag_border_bottom'] ) ? $responsi_options['responsi_post_meta_cat_tag_border_bottom'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $post_meta_cat_tag_border_lr                = isset( $responsi_options['responsi_post_meta_cat_tag_border_lr'] ) ? $responsi_options['responsi_post_meta_cat_tag_border_lr'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $post_meta_cat_tag_border_radius_option     = isset( $responsi_options['responsi_post_meta_cat_tag_border_radius'] ) ? $responsi_options['responsi_post_meta_cat_tag_border_radius'] : array( 'corner' => 'square','rounded_value' => '0' );
    $post_meta_cat_tag_border_radius            = responsi_generate_border_radius( $post_meta_cat_tag_border_radius_option );
    $post_meta_cat_tag_padding_top              = isset( $responsi_options['responsi_post_meta_cat_tag_padding_top'] ) ? esc_attr( $responsi_options['responsi_post_meta_cat_tag_padding_top'] ) : 0;
    $post_meta_cat_tag_padding_bottom           = isset( $responsi_options['responsi_post_meta_cat_tag_padding_bottom'] ) ? esc_attr( $responsi_options['responsi_post_meta_cat_tag_padding_bottom'] ) : 0;
    $post_meta_cat_tag_padding_left             = isset( $responsi_options['responsi_post_meta_cat_tag_padding_left'] ) ? esc_attr( $responsi_options['responsi_post_meta_cat_tag_padding_left'] ) : 0;
    $post_meta_cat_tag_padding_right            = isset( $responsi_options['responsi_post_meta_cat_tag_padding_right'] ) ? esc_attr( $responsi_options['responsi_post_meta_cat_tag_padding_right'] ) : 0;
    $post_meta_cat_tag_margin_top               = isset( $responsi_options['responsi_post_meta_cat_tag_margin_top'] ) ? esc_attr( $responsi_options['responsi_post_meta_cat_tag_margin_top'] ) : 0;
    $post_meta_cat_tag_margin_bottom            = isset( $responsi_options['responsi_post_meta_cat_tag_margin_bottom'] ) ? esc_attr( $responsi_options['responsi_post_meta_cat_tag_margin_bottom'] ) : 0;
    $post_meta_cat_tag_margin_left              = isset( $responsi_options['responsi_post_meta_cat_tag_margin_left'] ) ? esc_attr( $responsi_options['responsi_post_meta_cat_tag_margin_left'] ) : 0;
    $post_meta_cat_tag_margin_right             = isset( $responsi_options['responsi_post_meta_cat_tag_margin_right'] ) ? esc_attr( $responsi_options['responsi_post_meta_cat_tag_margin_right'] ) : 0;
    $font_post_cat_tag_transform                = isset( $responsi_options['responsi_font_post_cat_tag_transform'] ) ? esc_attr( $responsi_options['responsi_font_post_cat_tag_transform'] ) : 'none';
    $font_post_cat_tag                          = isset( $responsi_options['responsi_font_post_cat_tag'] ) ? $responsi_options['responsi_font_post_cat_tag'] : array('size' => '12','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#555555');
    $font_post_cat_tag_link                     = isset( $responsi_options['responsi_font_post_cat_tag_link'] ) ? esc_attr( $responsi_options['responsi_font_post_cat_tag_link'] ) : '#009ee0';
    $font_post_cat_tag_link_hover               = isset( $responsi_options['responsi_font_post_cat_tag_link_hover'] ) ? esc_attr( $responsi_options['responsi_font_post_cat_tag_link_hover'] ) : '#ff6868';
    $font_post_cat_tag_icon                     = isset( $responsi_options['responsi_font_post_cat_tag_icon'] ) ? esc_attr( $responsi_options['responsi_font_post_cat_tag_icon'] ) : '#555555';
    $enable_font_post_cat_tag_icon              = isset( $responsi_options['responsi_enable_font_post_cat_tag_icon'] ) ? esc_attr( $responsi_options['responsi_enable_font_post_cat_tag_icon'] ) : 'true';
    
    $post_cat_tag_css = '';
    $post_cat_tag_css .= responsi_generate_fonts( $font_post_cat_tag );
    $post_cat_tag_css .= responsi_generate_background_color( $post_meta_cat_tag_bg, true );
    $post_cat_tag_css .= 'margin-top:' . $post_meta_cat_tag_margin_top . 'px !important;margin-bottom:' . $post_meta_cat_tag_margin_bottom . 'px !important;';
    $post_cat_tag_css .= 'margin-left:' . $post_meta_cat_tag_margin_left . 'px !important;margin-right:' . $post_meta_cat_tag_margin_right . 'px !important;';
    $post_cat_tag_css .= 'padding-top:' . $post_meta_cat_tag_padding_top . 'px !important;padding-bottom:' . $post_meta_cat_tag_padding_bottom . 'px !important;';
    $post_cat_tag_css .= 'padding-left:' . $post_meta_cat_tag_padding_left . 'px !important;padding-right:' . $post_meta_cat_tag_padding_right . 'px !important;';
    $post_cat_tag_css .= responsi_generate_border($post_meta_cat_tag_border_top, 'border-top');
    $post_cat_tag_css .= responsi_generate_border($post_meta_cat_tag_border_bottom, 'border-bottom');
    $post_cat_tag_css .= responsi_generate_border($post_meta_cat_tag_border_lr, 'border-left');
    $post_cat_tag_css .= responsi_generate_border($post_meta_cat_tag_border_lr, 'border-right');
    $post_cat_tag_css .= $post_meta_cat_tag_border_radius;
    $post_cat_tag_css .= 'text-transform:' . $font_post_cat_tag_transform . ';';
    $dynamic_css .= '.post-utility-cat .categories{display:block;' . $post_cat_tag_css . '}';
    $dynamic_css .= '.post-utility-cat .categories a{color:' . $font_post_cat_tag_link . ' !important;}';
    $dynamic_css .= '.post-utility-cat .categories a:hover{color:' . $font_post_cat_tag_link_hover . ' !important;}';
    $dynamic_css .= '.post-utility-cat .categories .i_cat:before{color:' . $font_post_cat_tag_icon . ' !important;}';
    if ( 'true' !== $enable_font_post_cat_tag_icon ) {
        $dynamic_css .= '.post-utility-cat .categories .i_cat:before{display:none !important;}';
    }

    $post_meta_utility_tag_bg                       = isset( $responsi_options['responsi_post_meta_utility_tag_bg'] ) ? $responsi_options['responsi_post_meta_utility_tag_bg'] : array( 'onoff' => 'false', 'color' => '#ffffff' );
    $post_meta_utility_tag_border_top               = isset( $responsi_options['responsi_post_meta_utility_tag_border_top'] ) ? $responsi_options['responsi_post_meta_utility_tag_border_top'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $post_meta_utility_tag_border_bottom            = isset( $responsi_options['responsi_post_meta_utility_tag_border_bottom'] ) ? $responsi_options['responsi_post_meta_utility_tag_border_bottom'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $post_meta_utility_tag_border_lr                = isset( $responsi_options['responsi_post_meta_utility_tag_border_lr'] ) ? $responsi_options['responsi_post_meta_utility_tag_border_lr'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $post_meta_utility_tag_border_radius_option     = isset( $responsi_options['responsi_post_meta_utility_tag_border_radius'] ) ? $responsi_options['responsi_post_meta_utility_tag_border_radius'] : array( 'corner' => 'square','rounded_value' => '0' );
    $post_meta_utility_tag_border_radius            = responsi_generate_border_radius( $post_meta_utility_tag_border_radius_option );
    $post_meta_utility_tag_padding_top              = isset( $responsi_options['responsi_post_meta_utility_tag_padding_top'] ) ? esc_attr( $responsi_options['responsi_post_meta_utility_tag_padding_top'] ) : 0;
    $post_meta_utility_tag_padding_bottom           = isset( $responsi_options['responsi_post_meta_utility_tag_padding_bottom'] ) ? esc_attr( $responsi_options['responsi_post_meta_utility_tag_padding_bottom'] ) : 0;
    $post_meta_utility_tag_padding_left             = isset( $responsi_options['responsi_post_meta_utility_tag_padding_left'] ) ? esc_attr( $responsi_options['responsi_post_meta_utility_tag_padding_left'] ) : 0;
    $post_meta_utility_tag_padding_right            = isset( $responsi_options['responsi_post_meta_utility_tag_padding_right'] ) ? esc_attr( $responsi_options['responsi_post_meta_utility_tag_padding_right'] ) : 0;
    $post_meta_utility_tag_margin_top               = isset( $responsi_options['responsi_post_meta_utility_tag_margin_top'] ) ? esc_attr( $responsi_options['responsi_post_meta_utility_tag_margin_top'] ) : 0;
    $post_meta_utility_tag_margin_bottom            = isset( $responsi_options['responsi_post_meta_utility_tag_margin_bottom'] ) ? esc_attr( $responsi_options['responsi_post_meta_utility_tag_margin_bottom'] ) : 0;
    $post_meta_utility_tag_margin_left              = isset( $responsi_options['responsi_post_meta_utility_tag_margin_left'] ) ? esc_attr( $responsi_options['responsi_post_meta_utility_tag_margin_left'] ) : 0;
    $post_meta_utility_tag_margin_right             = isset( $responsi_options['responsi_post_meta_utility_tag_margin_right'] ) ? esc_attr( $responsi_options['responsi_post_meta_utility_tag_margin_right'] ) : 0;
    $font_post_utility_tag_transform                = isset( $responsi_options['responsi_font_post_utility_tag_transform'] ) ? esc_attr( $responsi_options['responsi_font_post_utility_tag_transform'] ) : 'none';
    $font_post_utility_tag                          = isset( $responsi_options['responsi_font_post_utility_tag'] ) ? $responsi_options['responsi_font_post_utility_tag'] : array('size' => '12','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#555555');
    $font_post_utility_tag_link                     = isset( $responsi_options['responsi_font_post_utility_tag_link'] ) ? esc_attr( $responsi_options['responsi_font_post_utility_tag_link'] ) : '#009ee0';
    $font_post_utility_tag_link_hover               = isset( $responsi_options['responsi_font_post_utility_tag_link_hover'] ) ? esc_attr( $responsi_options['responsi_font_post_utility_tag_link_hover'] ) : '#ff6868';
    $font_post_utility_tag_icon                     = isset( $responsi_options['responsi_font_post_utility_tag_icon'] ) ? esc_attr( $responsi_options['responsi_font_post_utility_tag_icon'] ) : '#555555';
    $enable_font_post_utility_tag_icon              = isset( $responsi_options['responsi_enable_font_post_utility_tag_icon'] ) ? esc_attr( $responsi_options['responsi_enable_font_post_utility_tag_icon'] ) : 'true';
    
    $post_utility_tag_css = '';
    $post_utility_tag_css .= responsi_generate_fonts( $font_post_utility_tag );
    $post_utility_tag_css .= responsi_generate_background_color( $post_meta_utility_tag_bg, true );
    $post_utility_tag_css .= 'margin-top:' . $post_meta_utility_tag_margin_top . 'px !important;margin-bottom:' . $post_meta_utility_tag_margin_bottom . 'px !important;';
    $post_utility_tag_css .= 'margin-left:' . $post_meta_utility_tag_margin_left . 'px !important;margin-right:' . $post_meta_utility_tag_margin_right . 'px !important;';
    $post_utility_tag_css .= 'padding-top:' . $post_meta_utility_tag_padding_top . 'px !important;padding-bottom:' . $post_meta_utility_tag_padding_bottom . 'px !important;';
    $post_utility_tag_css .= 'padding-left:' . $post_meta_utility_tag_padding_left . 'px !important;padding-right:' . $post_meta_utility_tag_padding_right . 'px !important;';
    $post_utility_tag_css .= responsi_generate_border($post_meta_utility_tag_border_top, 'border-top');
    $post_utility_tag_css .= responsi_generate_border($post_meta_utility_tag_border_bottom, 'border-bottom');
    $post_utility_tag_css .= responsi_generate_border($post_meta_utility_tag_border_lr, 'border-left');
    $post_utility_tag_css .= responsi_generate_border($post_meta_utility_tag_border_lr, 'border-right');
    $post_utility_tag_css .= $post_meta_utility_tag_border_radius;
    $post_utility_tag_css .= 'text-transform:' . $font_post_utility_tag_transform . ';';
    $dynamic_css .= '.post-utility-tag .posts-tags{display:block;' . $post_utility_tag_css . '}';
    $dynamic_css .= '.post-utility-tag .posts-tags a{color:' . $font_post_utility_tag_link . ' !important;}';
    $dynamic_css .= '.post-utility-tag .posts-tags a:hover{color:' . $font_post_utility_tag_link_hover . ' !important;}';
    $dynamic_css .= '.post-utility-tag .posts-tags .i_tag:before{color:' . $font_post_utility_tag_icon . ' !important;}';
    if ( 'true' !== $enable_font_post_utility_tag_icon ) {
        $dynamic_css .= '.post-utility-tag .posts-tags .i_tag:before{display:none !important;}';
    }
    $dynamic_css .= '#comments .comment.thread-even{' . responsi_generate_background_color( $post_comments_bg ) . '}';
    $dynamic_css .= 'body #main .box-item .entry-item.blog-post-item .entry-bottom .postinfo,#main .box-item .entry-item .entry-bottom .postinfo,body #main .box-item .entry-item.blog-post-item .entry-bottom .posttags,#main .box-item .entry-item .entry-bottom .posttags, #main .box-item .entry-item .entry-bottom .postinfo{' . responsi_generate_background_color( $post_author_archive_bg ) . '}';
    
    /* Post */
    $_font_post_title                               = isset( $responsi_options['responsi_font_post_title'] ) ? $responsi_options['responsi_font_post_title'] : array('size' => '26','line_height' => '1.2','face' => 'Open Sans','style' => 'normal','color' => '#009ee0');
    $_post_title_font_transform                     = isset( $responsi_options['responsi_post_title_font_transform'] ) ? esc_attr( $responsi_options['responsi_post_title_font_transform'] ) : 'none';
    $_post_title_position                           = isset( $responsi_options['responsi_post_title_position'] ) ? esc_attr( $responsi_options['responsi_post_title_position'] ) : 'left';
    $_post_title_margin_top                         = isset( $responsi_options['responsi_post_title_margin_top'] ) ? esc_attr( $responsi_options['responsi_post_title_margin_top'] ) : 0;
    $_post_title_margin_bottom                      = isset( $responsi_options['responsi_post_title_margin_bottom'] ) ? esc_attr( $responsi_options['responsi_post_title_margin_bottom'] ) : 0;
    $_post_title_margin_left                        = isset( $responsi_options['responsi_post_title_margin_left'] ) ? esc_attr( $responsi_options['responsi_post_title_margin_left'] ) : 0;
    $_post_title_margin_right                       = isset( $responsi_options['responsi_post_title_margin_right'] ) ? esc_attr( $responsi_options['responsi_post_title_margin_right'] ) : 0;
    $_font_post_text                                = isset( $responsi_options['responsi_font_post_text'] ) ? $responsi_options['responsi_font_post_text'] : array('size' => '12','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#555555');

    $post_title_css = '';
    $post_title_css .= responsi_generate_fonts( $_font_post_title, true );
    $post_title_css .= 'text-transform:' . $_post_title_font_transform . ' !important;';
    $post_title_css .= 'text-align:' . $_post_title_position . ';';
    $post_title_css .= 'margin-top:' . $_post_title_margin_top . 'px !important;margin-bottom:' . $_post_title_margin_bottom . 'px !important;';
    $post_title_css .= 'margin-left:' . $_post_title_margin_left . 'px !important;margin-right:' . $_post_title_margin_right . 'px !important;';
    
    $dynamic_css .= '#main .custom_box.custom_box_post h1.title, .custom_box.custom_box_post h1.title, #main .custom_box.custom_box_post h1.title a:link, #main .custom_box.custom_box_post h1.title a:visited{' . $post_title_css . '}';
    $dynamic_css .= '.custom_box.custom_box_post{' . responsi_generate_fonts( $_font_post_text ) . '}';

    $post_box_padding_top                           = isset( $responsi_options['responsi_post_box_padding_top'] ) ? esc_attr( $responsi_options['responsi_post_box_padding_top'] ) : 0;
    $post_box_padding_bottom                        = isset( $responsi_options['responsi_post_box_padding_bottom'] ) ? esc_attr( $responsi_options['responsi_post_box_padding_bottom'] ) : 0;
    $post_box_padding_left                          = isset( $responsi_options['responsi_post_box_padding_left'] ) ? esc_attr( $responsi_options['responsi_post_box_padding_left'] ) : 0;
    $post_box_padding_right                         = isset( $responsi_options['responsi_post_box_padding_right'] ) ? esc_attr( $responsi_options['responsi_post_box_padding_right'] ) : 0;
    $post_box_margin_top                            = isset( $responsi_options['responsi_post_box_margin_top'] ) ? esc_attr( $responsi_options['responsi_post_box_margin_top'] ) : 0;
    $post_box_margin_bottom                         = isset( $responsi_options['responsi_post_box_margin_bottom'] ) ? esc_attr( $responsi_options['responsi_post_box_margin_bottom'] ) : 0;
    $post_box_margin_left                           = isset( $responsi_options['responsi_post_box_margin_left'] ) ? esc_attr( $responsi_options['responsi_post_box_margin_left'] ) : 0;
    $post_box_margin_right                          = isset( $responsi_options['responsi_post_box_margin_right'] ) ? esc_attr( $responsi_options['responsi_post_box_margin_right'] ) : 0;
    $post_box_bg                                    = isset( $responsi_options['responsi_post_box_bg'] ) ? $responsi_options['responsi_post_box_bg'] : array( 'onoff' => 'false', 'color' => '#ffffff' );
    $post_box_border                                = isset( $responsi_options['responsi_post_box_border'] ) ? $responsi_options['responsi_post_box_border'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB','corner' => 'square', 'topleft' => '0', 'topright' => '0', 'bottomright' => '0', 'bottomleft' => '0');
    $post_box_shadow_option                         = isset( $responsi_options['responsi_post_box_shadow'] ) ? $responsi_options['responsi_post_box_shadow'] : array( 'onoff' => 'false' , 'h_shadow' => '0px' , 'v_shadow' => '0px', 'blur' => '5px' , 'spread' => '0px', 'color' => '#DBDBDB', 'inset' => '' );
    $post_box_shadow                                = responsi_generate_box_shadow( $post_box_shadow_option, true );
    
    $post_box_css = '';
    $post_box_css .= 'margin-top:' . $post_box_margin_top . 'px !important;margin-bottom:' . $post_box_margin_bottom . 'px !important;';
    $post_box_css .= 'margin-left:' . $post_box_margin_left . 'px !important;margin-right:' . $post_box_margin_right . 'px !important;';
    $post_box_css .= 'padding-top:' . $post_box_padding_top . 'px !important;padding-bottom:' . $post_box_padding_bottom . 'px !important;';
    $post_box_css .= 'padding-left:' . $post_box_padding_left . 'px !important;padding-right:' . $post_box_padding_right . 'px !important;';
    $post_box_css .= responsi_generate_background_color( $post_box_bg, true );
    $post_box_css .= responsi_generate_border_boxes( $post_box_border, true );
    $post_box_css .= $post_box_shadow;
    
    $dynamic_css .= '.main-wrap-post{' . $post_box_css . '}';

    /* Page */
    $_page_title_font                               = isset( $responsi_options['responsi_page_title_font'] ) ? $responsi_options['responsi_page_title_font'] : array('size' => '26','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#009ee0');
    $_page_title_font_transform                     = isset( $responsi_options['responsi_page_title_font_transform'] ) ? esc_attr( $responsi_options['responsi_page_title_font_transform'] ) : 'none';
    $_page_title_position                           = isset( $responsi_options['responsi_page_title_position'] ) ? esc_attr( $responsi_options['responsi_page_title_position'] ) : 'left';
    $_page_title_margin_top                         = isset( $responsi_options['responsi_page_title_margin_top'] ) ? esc_attr( $responsi_options['responsi_page_title_margin_top'] ) : 0;
    $_page_title_margin_bottom                      = isset( $responsi_options['responsi_page_title_margin_bottom'] ) ? esc_attr( $responsi_options['responsi_page_title_margin_bottom'] ) : 0;
    $_page_title_margin_left                        = isset( $responsi_options['responsi_page_title_margin_left'] ) ? esc_attr( $responsi_options['responsi_page_title_margin_left'] ) : 0;
    $_page_title_margin_right                       = isset( $responsi_options['responsi_page_title_margin_right'] ) ? esc_attr( $responsi_options['responsi_page_title_margin_right'] ) : 0;
    $_page_content_font                             = isset( $responsi_options['responsi_page_content_font'] ) ? $responsi_options['responsi_page_content_font'] : array('size' => '14','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#555555');
    
    $page_title_css = '';
    $page_title_css .= responsi_generate_fonts( $_page_title_font, true ) ;
    $page_title_css .= 'margin-top:' . $_page_title_margin_top . 'px !important;margin-bottom:' . $_page_title_margin_bottom . 'px !important;';
    $page_title_css .= 'margin-left:' . $_page_title_margin_left . 'px !important;margin-right:' . $_page_title_margin_right . 'px !important;';
    $page_title_css .= 'text-transform:' . $_page_title_font_transform . ' !important;';
    $page_title_css .= 'text-align:' . $_page_title_position . ';';
    $dynamic_css .= '#main .custom_box.custom_box_page h1.title, .custom_box.custom_box_page h1.title, #main .custom_box.custom_box_page h1.title a:link, #main .custom_box.custom_box_page h1.title a:visited{' . $page_title_css . '}';
    $dynamic_css .= '.custom_box.custom_box_page{' . responsi_generate_fonts( $_page_content_font ) . '}';

    $page_box_padding_top                           = isset( $responsi_options['responsi_page_box_padding_top'] ) ? esc_attr( $responsi_options['responsi_page_box_padding_top'] ) : 0;
    $page_box_padding_bottom                        = isset( $responsi_options['responsi_page_box_padding_bottom'] ) ? esc_attr( $responsi_options['responsi_page_box_padding_bottom'] ) : 0;
    $page_box_padding_left                          = isset( $responsi_options['responsi_page_box_padding_left'] ) ? esc_attr( $responsi_options['responsi_page_box_padding_left'] ) : 0;
    $page_box_padding_right                         = isset( $responsi_options['responsi_page_box_padding_right'] ) ? esc_attr( $responsi_options['responsi_page_box_padding_right'] ) : 0;
    $page_box_margin_top                            = isset( $responsi_options['responsi_page_box_margin_top'] ) ? esc_attr( $responsi_options['responsi_page_box_margin_top'] ) : 0;
    $page_box_margin_bottom                         = isset( $responsi_options['responsi_page_box_margin_bottom'] ) ? esc_attr( $responsi_options['responsi_page_box_margin_bottom'] ) : 0;
    $page_box_margin_left                           = isset( $responsi_options['responsi_page_box_margin_left'] ) ? esc_attr( $responsi_options['responsi_page_box_margin_left'] ) : 0;
    $page_box_margin_right                          = isset( $responsi_options['responsi_page_box_margin_right'] ) ? esc_attr( $responsi_options['responsi_page_box_margin_right'] ) : 0;
    $page_box_bg                                    = isset( $responsi_options['responsi_page_box_bg'] ) ? $responsi_options['responsi_page_box_bg'] : array( 'onoff' => 'false', 'color' => '#ffffff' );
    $page_box_border                                = isset( $responsi_options['responsi_page_box_border'] ) ? $responsi_options['responsi_page_box_border'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB','corner' => 'square', 'topleft' => '0', 'topright' => '0', 'bottomright' => '0', 'bottomleft' => '0');
    $page_box_shadow_option                         = isset( $responsi_options['responsi_page_box_shadow'] ) ? $responsi_options['responsi_page_box_shadow'] : array( 'onoff' => 'false' , 'h_shadow' => '0px' , 'v_shadow' => '0px', 'blur' => '5px' , 'spread' => '0px', 'color' => '#DBDBDB', 'inset' => '' );
    $page_box_shadow                                = responsi_generate_box_shadow( $page_box_shadow_option, true );
    
    $page_box_css = '';
    $page_box_css .= 'margin-top:' . $page_box_margin_top . 'px !important;margin-bottom:' . $page_box_margin_bottom . 'px !important;';
    $page_box_css .= 'margin-left:' . $page_box_margin_left . 'px !important;margin-right:' . $page_box_margin_right . 'px !important;';
    $page_box_css .= 'padding-top:' . $page_box_padding_top . 'px !important;padding-bottom:' . $page_box_padding_bottom . 'px !important;';
    $page_box_css .= 'padding-left:' . $page_box_padding_left . 'px !important;padding-right:' . $page_box_padding_right . 'px !important;';
    $page_box_css .= responsi_generate_background_color( $page_box_bg, true );
    $page_box_css .= responsi_generate_border_boxes( $page_box_border, true );
    $page_box_css .= $page_box_shadow;
    
    $dynamic_css .= '.main-wrap-page{' . $page_box_css . '}';
    
    /* Archive */

    $archive_box_padding_top                         = isset( $responsi_options['responsi_archive_box_padding_top'] ) ? esc_attr( $responsi_options['responsi_archive_box_padding_top'] ) : 0;
    $archive_box_padding_bottom                      = isset( $responsi_options['responsi_archive_box_padding_bottom'] ) ? esc_attr( $responsi_options['responsi_archive_box_padding_bottom'] ) : 0;
    $archive_box_padding_left                        = isset( $responsi_options['responsi_archive_box_padding_left'] ) ? esc_attr( $responsi_options['responsi_archive_box_padding_left'] ) : 0;
    $archive_box_padding_right                       = isset( $responsi_options['responsi_archive_box_padding_right'] ) ? esc_attr( $responsi_options['responsi_archive_box_padding_right'] ) : 0;
    $archive_box_margin_top                          = isset( $responsi_options['responsi_archive_box_margin_top'] ) ? esc_attr( $responsi_options['responsi_archive_box_margin_top'] ) : 0;
    $archive_box_margin_bottom                       = isset( $responsi_options['responsi_archive_box_margin_bottom'] ) ? esc_attr( $responsi_options['responsi_archive_box_margin_bottom'] ) : 0;
    $archive_box_margin_left                         = isset( $responsi_options['responsi_archive_box_margin_left'] ) ? esc_attr( $responsi_options['responsi_archive_box_margin_left'] ) : 0;
    $archive_box_margin_right                        = isset( $responsi_options['responsi_archive_box_margin_right'] ) ? esc_attr( $responsi_options['responsi_archive_box_margin_right'] ) : 0;
    $archive_box_bg                                  = isset( $responsi_options['responsi_archive_box_bg'] ) ? $responsi_options['responsi_archive_box_bg'] : array( 'onoff' => 'false', 'color' => '#ffffff' );
    $archive_box_border                              = isset( $responsi_options['responsi_archive_box_border'] ) ? $responsi_options['responsi_archive_box_border'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB','corner' => 'square', 'topleft' => '0', 'topright' => '0', 'bottomright' => '0', 'bottomleft' => '0');
    $archive_box_shadow_option                       = isset( $responsi_options['responsi_archive_box_shadow'] ) ? $responsi_options['responsi_archive_box_shadow'] : array( 'onoff' => 'false' , 'h_shadow' => '0px' , 'v_shadow' => '0px', 'blur' => '5px' , 'spread' => '0px', 'color' => '#DBDBDB', 'inset' => '' );
    $archive_box_shadow                              = responsi_generate_box_shadow( $archive_box_shadow_option, true );
    

    $archive_box_css = '';
    $archive_box_css .= 'margin-top:' . $archive_box_margin_top . 'px !important;margin-bottom:' . $archive_box_margin_bottom . 'px !important;';
    $archive_box_css .= 'margin-left:' . $archive_box_margin_left . 'px !important;margin-right:' . $archive_box_margin_right . 'px !important;';
    $archive_box_css .= 'padding-top:' . $archive_box_padding_top . 'px !important;padding-bottom:' . $archive_box_padding_bottom . 'px !important;';
    $archive_box_css .= 'padding-left:' . $archive_box_padding_left . 'px !important;padding-right:' . $archive_box_padding_right . 'px !important;';
    $archive_box_css .= responsi_generate_background_color( $archive_box_bg, true );
    $archive_box_css .= responsi_generate_border_boxes( $archive_box_border, true );
    $archive_box_css .= $archive_box_shadow;

    $dynamic_css .= '.main-wrap-archive{' . $archive_box_css . '}';

    $_archive_title_font                            = isset( $responsi_options['responsi_archive_title_font'] ) ? $responsi_options['responsi_archive_title_font'] : array('size' => '26','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#009ee0');
    $_archive_title_font_transform                  = isset( $responsi_options['responsi_archive_title_font_transform'] ) ? esc_attr( $responsi_options['responsi_archive_title_font_transform'] ) : 'none';
    $_archive_title_position                        = isset( $responsi_options['responsi_archive_title_position'] ) ? esc_attr( $responsi_options['responsi_archive_title_position'] ) : 'left';
    $_archive_title_margin_top                      = isset( $responsi_options['responsi_archive_title_margin_top'] ) ? esc_attr( $responsi_options['responsi_archive_title_margin_top'] ) : 0;
    $_archive_title_margin_bottom                   = isset( $responsi_options['responsi_archive_title_margin_bottom'] ) ? esc_attr( $responsi_options['responsi_archive_title_margin_bottom'] ) : 0;
    $_archive_title_margin_left                     = isset( $responsi_options['responsi_archive_title_margin_left'] ) ? esc_attr( $responsi_options['responsi_archive_title_margin_left'] ) : 0;
    $_archive_title_margin_right                    = isset( $responsi_options['responsi_archive_title_margin_right'] ) ? esc_attr( $responsi_options['responsi_archive_title_margin_right'] ) : 0;
    $_archive_title_border_bottom                   = isset( $responsi_options['responsi_archive_title_border_bottom'] ) ? $responsi_options['responsi_archive_title_border_bottom'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $_archive_content_font                          = isset( $responsi_options['responsi_archive_content_font'] ) ? $responsi_options['responsi_archive_content_font'] : array('size' => '14','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#555555');
    
    $archive_title_css = '';
    $archive_title_css .= responsi_generate_fonts( $_archive_title_font, true );
    $archive_title_css .= 'text-transform:' . $_archive_title_font_transform . ' !important;';
    $archive_title_css .= 'text-align:' . $_archive_title_position . ';';
    $archive_title_css .= 'margin-top:' . $_archive_title_margin_top . 'px !important;margin-bottom:' . $_archive_title_margin_bottom . 'px !important;';
    $archive_title_css .= 'margin-left:' . $_archive_title_margin_left . 'px !important;margin-right:' . $_archive_title_margin_right . 'px !important;';
    
    $dynamic_css .= '#main .custom_box.custom_box_archive h1.title, .custom_box.custom_box_archive h1.title, #main .custom_box.custom_box_archive h1.title a:link, #main .custom_box.custom_box_archive h1.title a:visited{' . $archive_title_css . '}';
    $dynamic_css .= '.custom_box.custom_box_archive,.archive_header .catrss{' . responsi_generate_fonts($_archive_content_font) . '}';
    $dynamic_css .= '.archive_header {' . responsi_generate_border( $_archive_title_border_bottom, 'border-bottom' ) . '}';
    if ( isset( $_archive_title_border_bottom['width'] ) && $_archive_title_border_bottom['width'] > 0 ) {
        $dynamic_css .= '.responsi_title .archive_header{padding-bottom:5px !important;}';
    }

    $enable_archive_title_box                       = isset( $responsi_options['responsi_enable_archive_title_box'] ) ? esc_attr( $responsi_options['responsi_enable_archive_title_box'] ) : 'false';
    $archive_title_box_padding_top                  = isset( $responsi_options['responsi_archive_title_box_padding_top'] ) ? esc_attr( $responsi_options['responsi_archive_title_box_padding_top'] ) : 0;
    $archive_title_box_padding_bottom               = isset( $responsi_options['responsi_archive_title_box_padding_bottom'] ) ? esc_attr( $responsi_options['responsi_archive_title_box_padding_bottom'] ) : 0;
    $archive_title_box_padding_left                 = isset( $responsi_options['responsi_archive_title_box_padding_left'] ) ? esc_attr( $responsi_options['responsi_archive_title_box_padding_left'] ) : 0;
    $archive_title_box_padding_right                = isset( $responsi_options['responsi_archive_title_box_padding_right'] ) ? esc_attr( $responsi_options['responsi_archive_title_box_padding_right'] ) : 0;
    $archive_title_box_margin_top                   = isset( $responsi_options['responsi_archive_title_box_margin_top'] ) ? esc_attr( $responsi_options['responsi_archive_title_box_margin_top'] ) : 0;
    $archive_title_box_margin_bottom                = isset( $responsi_options['responsi_archive_title_box_margin_bottom'] ) ? esc_attr( $responsi_options['responsi_archive_title_box_margin_bottom'] ) : 0;
    $archive_title_box_margin_left                  = isset( $responsi_options['responsi_archive_title_box_margin_left'] ) ? esc_attr( $responsi_options['responsi_archive_title_box_margin_left'] ) : 0;
    $archive_title_box_margin_right                 = isset( $responsi_options['responsi_archive_title_box_margin_right'] ) ? esc_attr( $responsi_options['responsi_archive_title_box_margin_right'] ) : 0;
    $archive_title_box_bg                           = isset( $responsi_options['responsi_archive_title_box_bg'] ) ? $responsi_options['responsi_archive_title_box_bg'] : array( 'onoff' => 'false', 'color' => '#ffffff' );
    $archive_title_box_border                       = isset( $responsi_options['responsi_archive_title_box_border'] ) ? $responsi_options['responsi_archive_title_box_border'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB','corner' => 'square', 'topleft' => '0', 'topright' => '0', 'bottomright' => '0', 'bottomleft' => '0');
    $archive_title_box_shadow_option                = isset( $responsi_options['responsi_archive_title_box_shadow'] ) ? $responsi_options['responsi_archive_title_box_shadow'] : array( 'onoff' => 'false' , 'h_shadow' => '0px' , 'v_shadow' => '0px', 'blur' => '5px' , 'spread' => '0px', 'color' => '#DBDBDB', 'inset' => '' );
    $archive_title_box_shadow                       = responsi_generate_box_shadow( $archive_title_box_shadow_option, true );
    

    $archive_title_box_css           = '';
    $archive_title_box_css .= 'margin-top:' . $archive_title_box_margin_top . 'px !important;margin-bottom:' . $archive_title_box_margin_bottom . 'px !important;';
    $archive_title_box_css .= 'margin-left:' . $archive_title_box_margin_left . 'px !important;margin-right:' . $archive_title_box_margin_right . 'px !important;';
    $archive_title_box_css .= 'padding-top:' . $archive_title_box_padding_top . 'px !important;padding-bottom:' . $archive_title_box_padding_bottom . 'px !important;';
    $archive_title_box_css .= 'padding-left:' . $archive_title_box_padding_left . 'px !important;padding-right:' . $archive_title_box_padding_right . 'px !important;';
    $archive_title_box_css .= responsi_generate_background_color( $archive_title_box_bg, true );
    $archive_title_box_css .= responsi_generate_border_boxes( $archive_title_box_border, true );
    $archive_title_box_css .= $archive_title_box_shadow;
    
    if ( 'true' === $enable_archive_title_box ) {
        $dynamic_css .= '#main .custom_box.custom_box_archive, .custom_box.custom_box_archive,.custom_box_archive{' . $archive_title_box_css . '}';
    } else {
        $dynamic_css .= '#main .custom_box.custom_box_archive, .custom_box.custom_box_archive,.custom_box_archive{padding:0px !important;border-width:0px !important;background-color:transparent !important;box-shadow: 0 0 0px #ffffff !important;border-radius: 0px !important;}';
    }
    
    /* Widgets */
    $responsi_widget_container_bg                    = isset( $responsi_options['responsi_widget_container_bg'] ) ? $responsi_options['responsi_widget_container_bg'] : array( 'onoff' => 'false', 'color' => '#ffffff' );
    $responsi_enable_widget_container_bg_image       = isset( $responsi_options['responsi_enable_widget_container_bg_image'] ) ? esc_attr( $responsi_options['responsi_enable_widget_container_bg_image'] ) : 'false';
    $responsi_widget_container_bg_image              = isset( $responsi_options['responsi_widget_container_bg_image'] ) ? str_replace( array( 'https:', 'http:' ), '', esc_url( $responsi_options['responsi_widget_container_bg_image'] ) ) : '';
    $responsi_widget_container_bg_position_vertical  = isset( $responsi_options['responsi_widget_container_bg_position_vertical'] ) ? esc_attr( $responsi_options['responsi_widget_container_bg_position_vertical'] ) : 'center';
    $responsi_widget_container_bg_position_horizontal = isset( $responsi_options['responsi_widget_container_bg_position_horizontal'] ) ? esc_attr( $responsi_options['responsi_widget_container_bg_position_horizontal'] ) : 'center';
    $responsi_widget_container_bg_image_repeat       = isset( $responsi_options['responsi_widget_container_bg_image_repeat'] ) ? esc_attr( $responsi_options['responsi_widget_container_bg_image_repeat'] ) : 'repeat';
    $responsi_widget_container_border_top            = isset( $responsi_options['responsi_widget_container_border_top'] ) ? $responsi_options['responsi_widget_container_border_top'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $responsi_widget_container_border_bottom         = isset( $responsi_options['responsi_widget_container_border_bottom'] ) ? $responsi_options['responsi_widget_container_border_bottom'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $responsi_widget_container_border_lr             = isset( $responsi_options['responsi_widget_container_border_lr'] ) ? $responsi_options['responsi_widget_container_border_lr'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $widget_container_border_radius_tl_option        = isset( $responsi_options['responsi_widget_container_border_radius_tl'] ) ? $responsi_options['responsi_widget_container_border_radius_tl'] : array( 'corner' => 'square','rounded_value' => '0' );
    $widget_container_border_radius_tr_option        = isset( $responsi_options['responsi_widget_container_border_radius_tr'] ) ? $responsi_options['responsi_widget_container_border_radius_tr'] : array( 'corner' => 'square','rounded_value' => '0' );
    $widget_container_border_radius_bl_option        = isset( $responsi_options['responsi_widget_container_border_radius_bl'] ) ? $responsi_options['responsi_widget_container_border_radius_bl'] : array( 'corner' => 'square','rounded_value' => '0' );
    $widget_container_border_radius_br_option        = isset( $responsi_options['responsi_widget_container_border_radius_br'] ) ? $responsi_options['responsi_widget_container_border_radius_br'] : array( 'corner' => 'square','rounded_value' => '0' );
    $responsi_widget_container_border_radius_tl      = responsi_generate_border_radius_value( $widget_container_border_radius_tl_option );
    $responsi_widget_container_border_radius_tr      = responsi_generate_border_radius_value( $widget_container_border_radius_tr_option );
    $responsi_widget_container_border_radius_bl      = responsi_generate_border_radius_value( $widget_container_border_radius_bl_option );
    $responsi_widget_container_border_radius_br      = responsi_generate_border_radius_value( $widget_container_border_radius_br_option );
    $responsi_widget_container_box_shadow_option     = isset( $responsi_options['responsi_widget_container_box_shadow'] ) ? $responsi_options['responsi_widget_container_box_shadow'] : array( 'onoff' => 'false' , 'h_shadow' => '0px' , 'v_shadow' => '0px', 'blur' => '5px' , 'spread' => '0px', 'color' => '#DBDBDB', 'inset' => '' );
    $responsi_widget_container_box_shadow            = responsi_generate_box_shadow( $responsi_widget_container_box_shadow_option );
    $responsi_widget_container_padding_top           = isset( $responsi_options['responsi_widget_container_padding_top'] ) ? esc_attr( $responsi_options['responsi_widget_container_padding_top'] ) : 0;
    $responsi_widget_container_padding_bottom        = isset( $responsi_options['responsi_widget_container_padding_bottom'] ) ? esc_attr( $responsi_options['responsi_widget_container_padding_bottom'] ) : 0;
    $responsi_widget_container_padding_left          = isset( $responsi_options['responsi_widget_container_padding_left'] ) ? esc_attr( $responsi_options['responsi_widget_container_padding_left'] ) : 0;
    $responsi_widget_container_padding_right         = isset( $responsi_options['responsi_widget_container_padding_right'] ) ? esc_attr( $responsi_options['responsi_widget_container_padding_right'] ) : 0;
    $responsi_widget_container_margin_top            = isset( $responsi_options['responsi_widget_container_margin_top'] ) ? esc_attr( $responsi_options['responsi_widget_container_margin_top'] ) : 0;
    $responsi_widget_container_margin_bottom         = isset( $responsi_options['responsi_widget_container_margin_bottom'] ) ? esc_attr( $responsi_options['responsi_widget_container_margin_bottom'] ) : 0;
    $responsi_widget_container_margin_left           = isset( $responsi_options['responsi_widget_container_margin_left'] ) ? esc_attr( $responsi_options['responsi_widget_container_margin_left'] ) : 0;
    $responsi_widget_container_margin_right          = isset( $responsi_options['responsi_widget_container_margin_right'] ) ? esc_attr( $responsi_options['responsi_widget_container_margin_right'] ) : 0;
    
    $widget_container_css = '';

    $widget_container_css .= responsi_generate_background_color( $responsi_widget_container_bg, true );
    if ( 'true' === $responsi_enable_widget_container_bg_image && '' !== $responsi_widget_container_bg_image ) {
        $widget_container_css .= 'background-image:url("' . $responsi_widget_container_bg_image . '");background-position:' . strtolower($responsi_widget_container_bg_position_horizontal) . ' ' . strtolower($responsi_widget_container_bg_position_vertical) . ';background-repeat:' . $responsi_widget_container_bg_image_repeat . ';';
    }
    $widget_container_css .= responsi_generate_border( $responsi_widget_container_border_top, 'border-top', true );
    $widget_container_css .= responsi_generate_border( $responsi_widget_container_border_bottom, 'border-bottom', true );
    $widget_container_css .= responsi_generate_border( $responsi_widget_container_border_lr, 'border-left', true );
    $widget_container_css .= responsi_generate_border( $responsi_widget_container_border_lr, 'border-right', true );
    $widget_container_css .= 'padding-top:' . $responsi_widget_container_padding_top . 'px !important;';
    $widget_container_css .= 'padding-bottom:' . $responsi_widget_container_padding_bottom . 'px !important;';
    $widget_container_css .= 'padding-left:' . $responsi_widget_container_padding_left . 'px !important;';
    $widget_container_css .= 'padding-right:' . $responsi_widget_container_padding_right . 'px !important;';
    $widget_container_css .= 'margin-top:' . $responsi_widget_container_margin_top . 'px !important;';
    $widget_container_css .= 'margin-bottom:' . $responsi_widget_container_margin_bottom . 'px !important;';
    $widget_container_css .= 'margin-left:' . $responsi_widget_container_margin_left . 'px !important;';
    $widget_container_css .= 'margin-right:' . $responsi_widget_container_margin_right . 'px !important;';
    $widget_container_css .= 'border-radius:' . $responsi_widget_container_border_radius_tl . ' ' . $responsi_widget_container_border_radius_tr . ' ' . $responsi_widget_container_border_radius_br . ' ' . $responsi_widget_container_border_radius_bl . ';';
    $widget_container_css .= $responsi_widget_container_box_shadow;
    $widget_container_css .= 'box-sizing: border-box;';
    
    $dynamic_css .= '#sidebar .sidebar-wrap, #sidebar-alt .sidebar-wrap{' . $widget_container_css . ';}';

    $widget_font_text                               = isset( $responsi_options['responsi_widget_font_text'] ) ? $responsi_options['responsi_widget_font_text'] : array('size' => '14','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#555555');
    $widget_link_color                              = isset( $responsi_options['responsi_widget_link_color'] ) ? esc_attr( $responsi_options['responsi_widget_link_color'] ) : '#009ee0';
    $widget_link_hover_color                        = isset( $responsi_options['responsi_widget_link_hover_color'] ) ? esc_attr( $responsi_options['responsi_widget_link_hover_color'] ) : '#ff6868';
    $widget_link_visited_color                      = isset( $responsi_options['responsi_widget_link_visited_color'] ) ? esc_attr( $responsi_options['responsi_widget_link_visited_color'] ) : '#009ee0';
    $widget_text_alignment                          = isset( $responsi_options['responsi_widget_font_text_alignment'] ) ? esc_attr( $responsi_options['responsi_widget_font_text_alignment'] ) : 'left';
    $widget_bg                                      = isset( $responsi_options['responsi_widget_bg'] ) ? $responsi_options['responsi_widget_bg'] : array( 'onoff' => 'false', 'color' => '#ffffff' );  
    $widget_border                                  = isset( $responsi_options['responsi_widget_border'] ) ? $responsi_options['responsi_widget_border'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB','corner' => 'square', 'topleft' => '0', 'topright' => '0', 'bottomright' => '0', 'bottomleft' => '0');
    $widget_padding_top                             = isset( $responsi_options['responsi_widget_padding_top'] ) ? esc_attr( $responsi_options['responsi_widget_padding_top'] ) : 0;
    $widget_padding_bottom                          = isset( $responsi_options['responsi_widget_padding_bottom'] ) ? esc_attr( $responsi_options['responsi_widget_padding_bottom'] ) : 0;
    $widget_padding_left                            = isset( $responsi_options['responsi_widget_padding_left'] ) ? esc_attr( $responsi_options['responsi_widget_padding_left'] ) : 0;
    $widget_padding_right                           = isset( $responsi_options['responsi_widget_padding_right'] ) ? esc_attr( $responsi_options['responsi_widget_padding_right'] ) : 0;
    $widget_margin_between                          = isset( $responsi_options['responsi_widget_margin_between'] ) ? esc_attr( $responsi_options['responsi_widget_margin_between'] ) : 0;
    $widget_box_shadow_option                       = isset( $responsi_options['responsi_widget_box_shadow'] ) ? $responsi_options['responsi_widget_box_shadow'] : array( 'onoff' => 'false' , 'h_shadow' => '0px' , 'v_shadow' => '0px', 'blur' => '5px' , 'spread' => '0px', 'color' => '#DBDBDB', 'inset' => '' );
    $widget_box_shadow                              = responsi_generate_box_shadow( $widget_box_shadow_option );

    $widget_css = '';
    $widget_css .= 'float: none;';
    $widget_css .= responsi_generate_fonts( $widget_font_text );
    $widget_css .= 'text-align:' . $widget_text_alignment . ';';
    $widget_css .= responsi_generate_background_color( $widget_bg );
    $widget_css .= responsi_generate_border_boxes( $widget_border );
    $widget_css .= 'padding-top:' . $widget_padding_top . 'px;';
    $widget_css .= 'padding-bottom:' . $widget_padding_bottom . 'px;';
    $widget_css .= 'padding-left:' . $widget_padding_left . 'px;';
    $widget_css .= 'padding-right:' . $widget_padding_right . 'px;';
    $widget_css .= 'margin-bottom:' . $widget_margin_between . 'px;';
    $widget_css .= $widget_box_shadow;

    $dynamic_css .= '#sidebar .widget, #sidebar-alt .widget{' . $widget_css . '}';
    $dynamic_css .= '#sidebar .widget ul li, #sidebar .widget ol li, #sidebar .widget p, #sidebar .widget .textwidget, #sidebar .widget:not(div), #sidebar .widget .textwidget .tel, #sidebar .widget .textwidget .tel a, #sidebar .widget .textwidget a[href^=tel], #sidebar .widget * a[href^=tel], #sidebar .widget a[href^=tel], #sidebar-alt .widget ul li, #sidebar-alt .widget ol li, #sidebar-alt .widget p, #sidebar-alt .widget .textwidget, #sidebar-alt .widget:not(div), #sidebar-alt .widget .textwidget .tel, #sidebar-alt .widget .textwidget .tel a, #sidebar-alt .widget .textwidget a[href^=tel], #sidebar-alt .widget * a[href^=tel], #sidebar-alt .widget a[href^=tel]{text-decoration: none; ' . responsi_generate_fonts( $widget_font_text ) . '}';
    $dynamic_css .= '#sidebar .widget a,#sidebar-alt .widget a, #sidebar .widget a:link,#sidebar-alt .widget a:link{color:' . $widget_link_color . '}';
    $dynamic_css .= '#sidebar .widget a:visited,#sidebar-alt .widget a:visited{color:' . $widget_link_visited_color . '}';
    $dynamic_css .= '#sidebar .widget a:hover,#sidebar-alt .widget a:hover{color:' . $widget_link_hover_color . '}';

    $widget_font_title                              = isset( $responsi_options['responsi_widget_font_title'] ) ? $responsi_options['responsi_widget_font_title'] : array('size' => '14','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#555555');
    $widget_title_bg                                = isset( $responsi_options['responsi_widget_title_bg'] ) ? $responsi_options['responsi_widget_title_bg'] : array( 'onoff' => 'false', 'color' => '#ffffff' );  
    $widget_title_border_top                        = isset( $responsi_options['responsi_widget_title_border_top'] ) ? $responsi_options['responsi_widget_title_border_top'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $widget_title_border_bottom                     = isset( $responsi_options['responsi_widget_title_border_bottom'] ) ? $responsi_options['responsi_widget_title_border_bottom'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $widget_title_border_left                       = isset( $responsi_options['responsi_widget_title_border_left'] ) ? $responsi_options['responsi_widget_title_border_left'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $widget_title_border_right                      = isset( $responsi_options['responsi_widget_title_border_right'] ) ? $responsi_options['responsi_widget_title_border_right'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $widget_title_border_radius_tl_option           = isset( $responsi_options['responsi_widget_title_border_radius_tl'] ) ? $responsi_options['responsi_widget_title_border_radius_tl'] : array( 'corner' => 'square','rounded_value' => '0' );
    $widget_title_border_radius_tr_option           = isset( $responsi_options['responsi_widget_title_border_radius_tr'] ) ? $responsi_options['responsi_widget_title_border_radius_tr'] : array( 'corner' => 'square','rounded_value' => '0' );
    $widget_title_border_radius_bl_option           = isset( $responsi_options['responsi_widget_title_border_radius_bl'] ) ? $responsi_options['responsi_widget_title_border_radius_bl'] : array( 'corner' => 'square','rounded_value' => '0' );
    $widget_title_border_radius_br_option           = isset( $responsi_options['responsi_widget_title_border_radius_br'] ) ? $responsi_options['responsi_widget_title_border_radius_br'] : array( 'corner' => 'square','rounded_value' => '0' );
    $widget_title_border_radius_tl                  = responsi_generate_border_radius_value( $widget_title_border_radius_tl_option );
    $widget_title_border_radius_tr                  = responsi_generate_border_radius_value( $widget_title_border_radius_tr_option );
    $widget_title_border_radius_bl                  = responsi_generate_border_radius_value( $widget_title_border_radius_bl_option );
    $widget_title_border_radius_br                  = responsi_generate_border_radius_value( $widget_title_border_radius_br_option );
    $widget_title_box_shadow_option                 = isset( $responsi_options['responsi_widget_title_box_shadow'] ) ? $responsi_options['responsi_widget_title_box_shadow'] : array( 'onoff' => 'false' , 'h_shadow' => '0px' , 'v_shadow' => '0px', 'blur' => '5px' , 'spread' => '0px', 'color' => '#DBDBDB', 'inset' => '' );
    $widget_title_box_shadow                        = responsi_generate_box_shadow( $widget_title_box_shadow_option );
    $widget_title_align                             = isset( $responsi_options['responsi_widget_title_align'] ) ? esc_attr( $responsi_options['responsi_widget_title_align'] ) : 'stretched';
    $widget_title_transform                         = isset( $responsi_options['responsi_widget_title_transform'] ) ? esc_attr( $responsi_options['responsi_widget_title_transform'] ) : 'none';
    $widget_title_text_alignment                    = isset( $responsi_options['responsi_widget_title_text_alignment'] ) ? esc_attr( $responsi_options['responsi_widget_title_text_alignment'] ) : 'center';
    $widget_title_padding_top                       = isset( $responsi_options['responsi_widget_title_padding_top'] ) ? esc_attr( $responsi_options['responsi_widget_title_padding_top'] ) : 0;
    $widget_title_padding_bottom                    = isset( $responsi_options['responsi_widget_title_padding_bottom'] ) ? esc_attr( $responsi_options['responsi_widget_title_padding_bottom'] ) : 0;
    $widget_title_padding_left                      = isset( $responsi_options['responsi_widget_title_padding_left'] ) ? esc_attr( $responsi_options['responsi_widget_title_padding_left'] ) : 0;
    $widget_title_padding_right                     = isset( $responsi_options['responsi_widget_title_padding_right'] ) ? esc_attr( $responsi_options['responsi_widget_title_padding_right'] ) : 0;
    $widget_title_margin_top                        = isset( $responsi_options['responsi_widget_title_margin_top'] ) ? esc_attr( $responsi_options['responsi_widget_title_margin_top'] ) : 0;
    $widget_title_margin_bottom                     = isset( $responsi_options['responsi_widget_title_margin_bottom'] ) ? esc_attr( $responsi_options['responsi_widget_title_margin_bottom'] ) : 0;
    $widget_title_margin_left                       = isset( $responsi_options['responsi_widget_title_margin_left'] ) ? esc_attr( $responsi_options['responsi_widget_title_margin_left'] ) : 0;
    $widget_title_margin_right                      = isset( $responsi_options['responsi_widget_title_margin_right'] ) ? esc_attr( $responsi_options['responsi_widget_title_margin_right'] ) : 0;
    $widget_text_alignment_mobile                   = isset( $responsi_options['responsi_font_sidebar_widget_text_alignment_mobile'] ) ? esc_attr( $responsi_options['responsi_font_sidebar_widget_text_alignment_mobile'] ) : 'true';
    
    $widget_title_css = '';
    $widget_title_css .= responsi_generate_fonts( $widget_font_title, true );
    $widget_title_css .= 'text-transform:' . $widget_title_transform . ' !important;';
    $widget_title_css .= responsi_generate_background_color( $widget_title_bg );
    $widget_title_css .= responsi_generate_border( $widget_title_border_top, 'border-top' );
    $widget_title_css .= responsi_generate_border( $widget_title_border_bottom, 'border-bottom' );
    $widget_title_css .= responsi_generate_border( $widget_title_border_left, 'border-left' );
    $widget_title_css .= responsi_generate_border( $widget_title_border_right, 'border-right' );
    $widget_title_css .= 'border-radius:' . $widget_title_border_radius_tl . ' ' . $widget_title_border_radius_tr . ' ' . $widget_title_border_radius_br . ' ' . $widget_title_border_radius_bl . ';';
    $widget_title_css .= $widget_title_box_shadow ;
    $widget_title_css .= 'padding-top:' . $widget_title_padding_top . 'px !important;padding-bottom:' . $widget_title_padding_bottom . 'px !important;';
    $widget_title_css .= 'padding-left:' . $widget_title_padding_left . 'px !important;padding-right:' . $widget_title_padding_right . 'px !important;';
    $widget_title_css .= 'margin-top:' . $widget_title_margin_top . 'px;margin-bottom:' . $widget_title_margin_bottom . 'px;';
    $widget_title_css .= 'margin-left:' . $widget_title_margin_left . 'px;margin-right:' . $widget_title_margin_right . 'px;';
    $widget_title_css .= 'text-align:' . $widget_title_text_alignment . ' !important;';
    if ( $widget_title_align ) {
        if ( 'Left' === $widget_title_align || 'left' === $widget_title_align ) {
            $widget_title_css .= 'float:left !important;';
        }
        if ( 'Right' === $widget_title_align || 'right' === $widget_title_align ) {
            $widget_title_css .= 'float:right !important;';
        }
        if ( 'Center' === $widget_title_align || 'center' === $widget_title_align ) {
            $widget_title_css .= 'float:none !important;margin-left:auto !important;margin-right:auto !important;display:table;';
        }
        if ( 'Stretched' === $widget_title_align || 'stretched' === $widget_title_align ) {
            $widget_title_css .= 'float:none !important;display:block;';
        }
    }
    $dynamic_css .= '#sidebar .fw_widget_title h3, #sidebar-alt .fw_widget_title h3{' . $widget_title_css . '}';
    if ( 'true' === $widget_text_alignment_mobile ) {
        $dynamic_css .= '@media only screen and (max-width: 782px){#sidebar .fw_widget_title, #sidebar .fw_widget_title h3, #sidebar .fw_widget_title *, #sidebar .fw_widget_content, #sidebar .fw_widget_content *,  #sidebar-alt .fw_widget_title, #sidebar-alt .fw_widget_title h3, #sidebar-alt .fw_widget_title *, #sidebar-alt .fw_widget_content, #sidebar-alt .fw_widget_content * {text-align:center !important;}}';
    }

    $widget_content_padding_top                     = isset( $responsi_options['responsi_widget_content_padding_top'] ) ? esc_attr( $responsi_options['responsi_widget_content_padding_top'] ) : 0;
    $widget_content_padding_bottom                  = isset( $responsi_options['responsi_widget_content_padding_bottom'] ) ? esc_attr( $responsi_options['responsi_widget_content_padding_bottom'] ) : 0;
    $widget_content_padding_left                    = isset( $responsi_options['responsi_widget_content_padding_left'] ) ? esc_attr( $responsi_options['responsi_widget_content_padding_left'] ) : 0;
    $widget_content_padding_right                   = isset( $responsi_options['responsi_widget_content_padding_right'] ) ? esc_attr( $responsi_options['responsi_widget_content_padding_right'] ) : 0;

    $widget_content_css = '';
    $widget_content_css .= 'padding-top:' . $widget_content_padding_top . 'px !important;';
    $widget_content_css .= 'padding-bottom:' . $widget_content_padding_bottom . 'px !important;';
    $widget_content_css .= 'padding-left:' . $widget_content_padding_left . 'px !important;';
    $widget_content_css .= 'padding-right:' . $widget_content_padding_right . 'px !important;';
    $dynamic_css .= '#sidebar .fw_widget_content, #sidebar-alt .fw_widget_content{' . $widget_content_css . '}';
    
    /* Navigation */

    $container_nav_bg                               = isset( $responsi_options['responsi_container_nav_bg'] ) ? $responsi_options['responsi_container_nav_bg'] : array( 'onoff' => 'false', 'color' => '#ffffff' );
    $enable_container_nav_bg_image                  = isset( $responsi_options['responsi_enable_container_nav_bg_image'] ) ? esc_attr( $responsi_options['responsi_enable_container_nav_bg_image'] ) : 'false';
    $responsi_container_bg_image                    = isset( $responsi_options['responsi_container_bg_image'] ) ? str_replace( array( 'https:', 'http:' ), '', esc_url( $responsi_options['responsi_container_bg_image'] ) ) : '';
    $responsi_container_bg_position_vertical        = isset( $responsi_options['responsi_container_bg_position_vertical'] ) ? esc_attr( $responsi_options['responsi_container_bg_position_vertical'] ) : 'center';
    $responsi_container_bg_position_horizontal      = isset( $responsi_options['responsi_container_bg_position_horizontal'] ) ? esc_attr( $responsi_options['responsi_container_bg_position_horizontal'] ) : 'center';
    $responsi_container_bg_image_repeat             = isset( $responsi_options['responsi_container_bg_image_repeat'] ) ? esc_attr( $responsi_options['responsi_container_bg_image_repeat'] ) : 'repeat';
    $responsi_container_nav_border_top              = isset( $responsi_options['responsi_container_nav_border_top'] ) ? $responsi_options['responsi_container_nav_border_top'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $responsi_container_nav_border_bottom           = isset( $responsi_options['responsi_container_nav_border_bottom'] ) ? $responsi_options['responsi_container_nav_border_bottom'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $responsi_container_nav_border_lr               = isset( $responsi_options['responsi_container_nav_border_lr'] ) ? $responsi_options['responsi_container_nav_border_lr'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $responsi_nav_box_shadow_option                 = isset( $responsi_options['responsi_nav_box_shadow'] ) ? $responsi_options['responsi_nav_box_shadow'] : array( 'onoff' => 'false' , 'h_shadow' => '0px' , 'v_shadow' => '0px', 'blur' => '5px' , 'spread' => '0px', 'color' => '#DBDBDB', 'inset' => '' );
    $responsi_nav_box_shadow                        = responsi_generate_box_shadow( $responsi_nav_box_shadow_option, false );
    $responsi_container_nav_padding_top             = isset( $responsi_options['responsi_container_nav_padding_top'] ) ? esc_attr( $responsi_options['responsi_container_nav_padding_top'] ) : 0;
    $responsi_container_nav_padding_bottom          = isset( $responsi_options['responsi_container_nav_padding_bottom'] ) ? esc_attr( $responsi_options['responsi_container_nav_padding_bottom'] ) : 0;
    $responsi_container_nav_padding_left            = isset( $responsi_options['responsi_container_nav_padding_left'] ) ? esc_attr( $responsi_options['responsi_container_nav_padding_left'] ) : 0;
    $responsi_container_nav_padding_right           = isset( $responsi_options['responsi_container_nav_padding_right'] ) ? esc_attr( $responsi_options['responsi_container_nav_padding_right'] ) : 0;
    $responsi_container_nav_margin_top              = isset( $responsi_options['responsi_container_nav_margin_top'] ) ? esc_attr( $responsi_options['responsi_container_nav_margin_top'] ) : 0;
    $responsi_container_nav_margin_bottom           = isset( $responsi_options['responsi_container_nav_margin_bottom'] ) ? esc_attr( $responsi_options['responsi_container_nav_margin_bottom'] ) : 0;
    $responsi_container_nav_margin_left             = isset( $responsi_options['responsi_container_nav_margin_left'] ) ? esc_attr( $responsi_options['responsi_container_nav_margin_left'] ) : 0;
    $responsi_container_nav_margin_right            = isset( $responsi_options['responsi_container_nav_margin_right'] ) ? esc_attr( $responsi_options['responsi_container_nav_margin_right'] ) : 0;
    
    $nav_container_css = '';
    $nav_container_css .= responsi_generate_background_color( $container_nav_bg );
    if ( 'true' === $enable_container_nav_bg_image && trim( $responsi_container_bg_image ) != '') {
        $nav_container_css .= 'background-image:url("' . $responsi_container_bg_image . '");background-position:' . strtolower($responsi_container_bg_position_horizontal) . ' ' . strtolower($responsi_container_bg_position_vertical) . ';background-repeat:' . $responsi_container_bg_image_repeat . ';';
    }
    $nav_container_css .= responsi_generate_border( $responsi_container_nav_border_top, 'border-top' );
    $nav_container_css .= responsi_generate_border( $responsi_container_nav_border_bottom, 'border-bottom' );
    $nav_container_css .= responsi_generate_border( $responsi_container_nav_border_lr, 'border-left' );
    $nav_container_css .= responsi_generate_border( $responsi_container_nav_border_lr, 'border-right' );
    $nav_container_css .= 'padding-top:' . $responsi_container_nav_padding_top . 'px;';
    $nav_container_css .= 'padding-bottom:' . $responsi_container_nav_padding_bottom . 'px;';
    $nav_container_css .= 'padding-left:' . $responsi_container_nav_padding_left . 'px;';
    $nav_container_css .= 'padding-right:' . $responsi_container_nav_padding_right . 'px;';
    $nav_container_css .= 'margin-top:' . $responsi_container_nav_margin_top . 'px;';
    $nav_container_css .= 'margin-bottom:' . $responsi_container_nav_margin_bottom . 'px;';
    $nav_container_css .= 'margin-left:' . $responsi_container_nav_margin_left . 'px;';
    $nav_container_css .= 'margin-right:' . $responsi_container_nav_margin_right . 'px;';
    $nav_container_css .= $responsi_nav_box_shadow;
    
    $dynamic_css .= '#wrapper-nav-content{' . $nav_container_css . '}';
    
    $nav_bg                                         = isset( $responsi_options['responsi_nav_bg'] ) ? $responsi_options['responsi_nav_bg'] : array( 'onoff' => 'false', 'color' => '#ffffff' );
    $responsi_nav_margin_left                       = isset( $responsi_options['responsi_nav_margin_left'] ) ? esc_attr( $responsi_options['responsi_nav_margin_left'] ) : 0;
    $responsi_nav_margin_right                      = isset( $responsi_options['responsi_nav_margin_right'] ) ? esc_attr( $responsi_options['responsi_nav_margin_right'] ) : 0;
    $responsi_nav_margin_top                        = isset( $responsi_options['responsi_nav_margin_top'] ) ? esc_attr( $responsi_options['responsi_nav_margin_top'] ) : 0;
    $responsi_nav_margin_bottom                     = isset( $responsi_options['responsi_nav_margin_bottom'] ) ? esc_attr( $responsi_options['responsi_nav_margin_bottom'] ) : 0;
    $responsi_nav_padding_lr_left                   = isset( $responsi_options['responsi_nav_padding_lr_left'] ) ? esc_attr( $responsi_options['responsi_nav_padding_lr_left'] ) : 0;
    $responsi_nav_padding_lr_right                  = isset( $responsi_options['responsi_nav_padding_lr_right'] ) ? esc_attr( $responsi_options['responsi_nav_padding_lr_right'] ) : 0;
    $responsi_nav_padding_tb_top                    = isset( $responsi_options['responsi_nav_padding_tb_top'] ) ? esc_attr( $responsi_options['responsi_nav_padding_tb_top'] ) : 0;
    $responsi_nav_padding_tb_bottom                 = isset( $responsi_options['responsi_nav_padding_tb_bottom'] ) ? esc_attr( $responsi_options['responsi_nav_padding_tb_bottom'] ) : 0;
    $nav_border_top                                 = isset( $responsi_options['responsi_nav_border_top'] ) ? $responsi_options['responsi_nav_border_top'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $nav_border_bot                                 = isset( $responsi_options['responsi_nav_border_bot'] ) ? $responsi_options['responsi_nav_border_bot'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $nav_border_lr                                  = isset( $responsi_options['responsi_nav_border_lr'] ) ? $responsi_options['responsi_nav_border_lr'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $responsi_nav_border_radius_tl_option           = isset( $responsi_options['responsi_nav_border_radius_tl'] ) ? $responsi_options['responsi_nav_border_radius_tl'] : array( 'corner' => 'square','rounded_value' => '0' );
    $responsi_nav_border_radius_tl                  = responsi_generate_border_radius_value( $responsi_nav_border_radius_tl_option );
    $responsi_nav_border_radius_tr_option           = isset( $responsi_options['responsi_nav_border_radius_tr'] ) ? $responsi_options['responsi_nav_border_radius_tr'] : array( 'corner' => 'square','rounded_value' => '0' );
    $responsi_nav_border_radius_tr                  = responsi_generate_border_radius_value( $responsi_nav_border_radius_tr_option );
    $responsi_nav_border_radius_bl_option           = isset( $responsi_options['responsi_nav_border_radius_bl'] ) ? $responsi_options['responsi_nav_border_radius_bl'] : array( 'corner' => 'square','rounded_value' => '0' );
    $responsi_nav_border_radius_bl                  = responsi_generate_border_radius_value( $responsi_nav_border_radius_bl_option );
    $responsi_nav_border_radius_br_option           = isset( $responsi_options['responsi_nav_border_radius_br'] ) ? $responsi_options['responsi_nav_border_radius_br'] : array( 'corner' => 'square','rounded_value' => '0' );
    $responsi_nav_border_radius_br                  = responsi_generate_border_radius_value( $responsi_nav_border_radius_br_option );
    $responsi_nav_shadow_option                     = isset( $responsi_options['responsi_nav_shadow'] ) ? $responsi_options['responsi_nav_shadow'] : array( 'onoff' => 'false' , 'h_shadow' => '0px' , 'v_shadow' => '0px', 'blur' => '5px' , 'spread' => '0px', 'color' => '#DBDBDB', 'inset' => '' );
    $responsi_nav_shadow                            = responsi_generate_box_shadow($responsi_nav_shadow_option);
    $nav_divider_border                             = isset( $responsi_options['responsi_nav_divider_border'] ) ? $responsi_options['responsi_nav_divider_border'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    
    $responsi_navi_background                       = isset( $responsi_options['responsi_navi_background'] ) ? $responsi_options['responsi_navi_background'] : array( 'onoff' => 'false', 'color' => '#ffffff' );
    $responsi_navi_border_top                       = isset( $responsi_options['responsi_navi_border_top'] ) ? $responsi_options['responsi_navi_border_top'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $responsi_navi_border_bottom                    = isset( $responsi_options['responsi_navi_border_bottom'] ) ? $responsi_options['responsi_navi_border_bottom'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $responsi_navi_border_left                      = isset( $responsi_options['responsi_navi_border_left'] ) ? $responsi_options['responsi_navi_border_left'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $responsi_navi_border_right                     = isset( $responsi_options['responsi_navi_border_right'] ) ? $responsi_options['responsi_navi_border_right'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $responsi_navi_border_radius_tl_option          = isset( $responsi_options['responsi_navi_border_radius_tl'] ) ? $responsi_options['responsi_navi_border_radius_tl'] : array( 'corner' => 'square','rounded_value' => '0' );
    $responsi_navi_border_radius_tl                 = responsi_generate_border_radius_value($responsi_navi_border_radius_tl_option);
    $responsi_navi_border_radius_tr_option          = isset( $responsi_options['responsi_navi_border_radius_tr'] ) ? $responsi_options['responsi_navi_border_radius_tr'] : array( 'corner' => 'square','rounded_value' => '0' );
    $responsi_navi_border_radius_tr                 = responsi_generate_border_radius_value($responsi_navi_border_radius_tr_option);
    $responsi_navi_border_radius_bl_option          = isset( $responsi_options['responsi_navi_border_radius_bl'] ) ? $responsi_options['responsi_navi_border_radius_bl'] : array( 'corner' => 'square','rounded_value' => '0' );
    $responsi_navi_border_radius_bl                 = responsi_generate_border_radius_value($responsi_navi_border_radius_bl_option);
    $responsi_navi_border_radius_br_option          = isset( $responsi_options['responsi_navi_border_radius_br'] ) ? $responsi_options['responsi_navi_border_radius_br'] : array( 'corner' => 'square','rounded_value' => '0' );
    $responsi_navi_border_radius_br                 = responsi_generate_border_radius_value($responsi_navi_border_radius_br_option);
    $responsi_navi_border_margin_top                = isset( $responsi_options['responsi_navi_border_margin_top'] ) ? esc_attr( $responsi_options['responsi_navi_border_margin_top'] ) : 0;
    $responsi_navi_border_margin_bottom             = isset( $responsi_options['responsi_navi_border_margin_bottom'] ) ? esc_attr( $responsi_options['responsi_navi_border_margin_bottom'] ) : 0;
    $responsi_navi_border_margin_left               = isset( $responsi_options['responsi_navi_border_margin_left'] ) ? esc_attr( $responsi_options['responsi_navi_border_margin_left'] ) : 0;
    $responsi_navi_border_margin_right              = isset( $responsi_options['responsi_navi_border_margin_right'] ) ? esc_attr( $responsi_options['responsi_navi_border_margin_right'] ) : 0;
    $responsi_navi_border_padding_top               = isset( $responsi_options['responsi_navi_border_padding_top'] ) ? esc_attr( $responsi_options['responsi_navi_border_padding_top'] ) : 0;
    $responsi_navi_border_padding_bottom            = isset( $responsi_options['responsi_navi_border_padding_bottom'] ) ? esc_attr( $responsi_options['responsi_navi_border_padding_bottom'] ) : 0;
    $responsi_navi_border_padding_left              = isset( $responsi_options['responsi_navi_border_padding_left'] ) ? esc_attr( $responsi_options['responsi_navi_border_padding_left'] ) : 0;
    $responsi_navi_border_padding_right             = isset( $responsi_options['responsi_navi_border_padding_right'] ) ? esc_attr( $responsi_options['responsi_navi_border_padding_right'] ) : 0;
    $nav_font                                       = isset( $responsi_options['responsi_nav_font'] ) ? $responsi_options['responsi_nav_font'] : array('size' => '13','line_height' => '1','face' => 'Open Sans','style' => 'bold','color' => '#FFFFFF');
    $nav_font_transform                             = isset( $responsi_options['responsi_nav_font_transform'] ) ? esc_attr( $responsi_options['responsi_nav_font_transform'] ) : 'uppercase';
    $nav_hover                                      = isset( $responsi_options['responsi_nav_hover'] ) ? esc_attr( $responsi_options['responsi_nav_hover'] ) : '#ffffff';
    $nav_hover_bg                                   = isset( $responsi_options['responsi_nav_hover_bg'] ) ? $responsi_options['responsi_nav_hover_bg'] :  array( 'onoff' => 'true', 'color' => '#8cc700');
    $nav_currentitem                                = isset( $responsi_options['responsi_nav_currentitem'] ) ? esc_attr( $responsi_options['responsi_nav_currentitem'] ) : '#ff6868';
    $nav_currentitem_bg                             = isset( $responsi_options['responsi_nav_currentitem_bg'] ) ? $responsi_options['responsi_nav_currentitem_bg'] :  array( 'onoff' => 'true', 'color' => '#8cc700');
    $responsi_pri_navbar_postion                    = isset( $responsi_options['responsi_nav_position'] ) ? esc_attr( $responsi_options['responsi_nav_position'] ) :  'left';

    $nav_content_css = 'box-sizing: border-box;';
    $nav_content_css .= responsi_generate_background_color($nav_bg, true );

    $nav_content_css .= 'padding-top:' . $responsi_nav_padding_tb_top . 'px !important;';
    $nav_content_css .= 'padding-bottom:' . $responsi_nav_padding_tb_bottom . 'px !important;';
    $nav_content_css .= 'padding-left:' . $responsi_nav_padding_lr_left . 'px !important;';
    $nav_content_css .= 'padding-right:' . $responsi_nav_padding_lr_right . 'px !important;';
    $nav_content_css .= 'margin-top:' . $responsi_nav_margin_top . 'px !important;';
    $nav_content_css .= 'margin-bottom:' . $responsi_nav_margin_bottom . 'px !important;';
    $nav_content_css .= 'margin-left:' . $responsi_nav_margin_left . 'px !important;';
    $nav_content_css .= 'margin-right:' . $responsi_nav_margin_right . 'px !important;';
    $nav_content_css .= responsi_generate_border( $nav_border_top, 'border-top' );
    $nav_content_css .= responsi_generate_border( $nav_border_bot, 'border-bottom' );
    $nav_content_css .= responsi_generate_border( $nav_border_lr, 'border-left' );
    $nav_content_css .= responsi_generate_border( $nav_border_lr, 'border-right' );
    $nav_content_css .= 'border-radius:' . $responsi_nav_border_radius_tl . ' ' . $responsi_nav_border_radius_tr . ' ' . $responsi_nav_border_radius_br . ' ' . $responsi_nav_border_radius_bl . ';';
    $nav_content_css .= $responsi_nav_shadow;
    $dynamic_css .= '#navigation{' . $nav_content_css . '}';
    if ( isset($responsi_options['responsi_nav_mobile_type']) && 'click' === $responsi_options['responsi_nav_mobile_type'] ) {
        $dynamic_css .= '#mobileMenu_main-nav{display:none !important;}';
    }
    if ( isset( $nav_divider_border['width'] ) && $nav_divider_border['width'] >= 0 ) {
        $dynamic_css .= '#navigation > ul.nav > li, #navigation .partial-refresh-menu-container ul.nav > li { '.responsi_generate_border( $nav_divider_border, 'border-left' ).'}';
        $dynamic_css .= 'body #navigation > ul.nav > li:first-child , body #navigation .partial-refresh-menu-container ul.nav > li:first-child { border-left: 0px !important; }';
        $dynamic_css .= '#navigation ul.nav > li > ul  { left: ' . $responsi_navi_border_margin_left . 'px !important; }';
    }
    
    $nav_item_css = '';
    $nav_item_css .= responsi_generate_background_color( $responsi_navi_background );
    $nav_item_css .= responsi_generate_border( $responsi_navi_border_top, 'border-top' );
    $nav_item_css .= responsi_generate_border( $responsi_navi_border_bottom, 'border-bottom' );
    $nav_item_css .= responsi_generate_border( $responsi_navi_border_left, 'border-left' );
    $nav_item_css .= responsi_generate_border( $responsi_navi_border_right, 'border-right' );
    $nav_item_css .= 'padding-top:' . $responsi_navi_border_padding_top . 'px !important;';
    $nav_item_css .= 'padding-bottom:' . $responsi_navi_border_padding_bottom . 'px !important;';
    $nav_item_css .= 'padding-left:' . $responsi_navi_border_padding_left . 'px !important;';
    $nav_item_css .= 'padding-right:' . $responsi_navi_border_padding_right . 'px !important;';
    $nav_item_css .= 'margin-top:' . $responsi_navi_border_margin_top . 'px !important;';
    $nav_item_css .= 'margin-bottom:' . $responsi_navi_border_margin_bottom . 'px !important;';
    $nav_item_css .= 'margin-left:' . $responsi_navi_border_margin_left . 'px !important;';
    $nav_item_css .= 'margin-right:' . $responsi_navi_border_margin_right . 'px !important;';
    $nav_item_css .= 'border-radius:' . $responsi_navi_border_radius_tl . ' ' . $responsi_navi_border_radius_tr . ' ' . $responsi_navi_border_radius_br . ' ' . $responsi_navi_border_radius_bl . ';';
    $nav_item_css .= responsi_generate_fonts( $nav_font, false );
    $nav_item_css .= 'color:' . esc_attr( $nav_font['color'] ) . ';';
    $nav_item_css .= 'text-transform:' . $nav_font_transform . ';';
    $dynamic_css .= '#navigation > ul.nav > li > a,#navigation > ul > li:first-child > a, #navigation .partial-refresh-menu-container ul.nav > li > a,#navigation #navigation .partial-refresh-menu-container ul > li:first-child > a {'.$nav_item_css.'}';
    $dynamic_css .= 'body #navigation ul.nav li.menu-item-account a:before{ top: -1px !important;vertical-align: top !important;}';
    $dynamic_css .= '.mobile-navigation{color:' . esc_attr( $nav_font['color'] ) . ';}';
    $dynamic_css .= '.mobile-navigation .responsi-icon-menu:before,.mobile-navigation .responsi-icon-cancel:before{box-shadow: 1px 0 0 ' . esc_attr( $nav_font['color'] ) . ';}';
    $dynamic_css .= '#navigation ul.nav > li.current-menu-item > a { ' . responsi_generate_background_color($nav_currentitem_bg) . 'color:' . $nav_currentitem . ' !important; }';
    $dynamic_css .= '#navigation ul.nav > li > a:hover,#navigation ul.nav > li:hover > a,#navigation .nav > li.menu-item-has-children:hover > a,.mobile-navigation .responsi-icon-menu:hover,.mobile-navigation .responsi-icon-cancel:hover,#navigation ul.nav > li.current-menu-item > a:hover{ color:' . $nav_hover . '!important; }';
    $dynamic_css .= '#navigation ul.nav > li a:hover, #navigation ul.nav > li.menu-item-has-children:hover > a,#navigation ul.nav > li:hover > a {' . responsi_generate_background_color( $nav_hover_bg, true ) . '}';
    $dynamic_css .= '#navigation ul.nav > li.menu-item-has-children > a:after { border-color:' . esc_attr( $nav_font['color'] ) . ' transparent transparent !important;}';
    $dynamic_css .= '#navigation ul.nav > li.menu-item-has-children:hover > a:after,#navigation ul.nav > li.menu-item-has-children.current-menu-item:hover > a:after{ border-color:' . $nav_hover . ' transparent transparent !important;}';
    $dynamic_css .= '#navigation ul.nav > li.menu-item-has-children.current-menu-item > a:after{ border-color:' . $nav_currentitem . ' transparent transparent !important;}';
    $dynamic_css .= '#navigation, #secondary{text-align:left}';
    $dynamic_css .= '#navigation ul,body #secondary ul{text-align:left}';
    $dynamic_css .= '#navigation select{max-width:100%;margin-bottom:0px !important;margin-top:0px !important;width:100%;}';
    $pri_navbar_postion = 'left';
    if ($responsi_pri_navbar_postion == 'left') {
        $pri_navbar_postion = 'left';
    } elseif ($responsi_pri_navbar_postion == 'right') {
        $pri_navbar_postion = 'right';
    } elseif ($responsi_pri_navbar_postion == 'center') {
        $pri_navbar_postion = 'center';
    }
    $dynamic_css .= '@media only screen and (min-width: 783px){#navigation ul.nav.fl, #navigation ul.nav,#navigation ul.nav.fr {float:none;display:inline-block;}#navigation,#secondary{text-align:' . $pri_navbar_postion . ';}}';
    
    $responsi_nav_dropdown_background               = isset( $responsi_options['responsi_nav_dropdown_background'] ) ? $responsi_options['responsi_nav_dropdown_background'] :  array( 'onoff' => 'true', 'color' => '#ffffff');
    $responsi_nav_dropdown_padding_left             = isset( $responsi_options['responsi_nav_dropdown_padding_left'] ) ? esc_attr( $responsi_options['responsi_nav_dropdown_padding_left'] ) : 0;
    $responsi_nav_dropdown_padding_right            = isset( $responsi_options['responsi_nav_dropdown_padding_right'] ) ? esc_attr( $responsi_options['responsi_nav_dropdown_padding_right'] ) : 0;
    $responsi_nav_dropdown_padding_top              = isset( $responsi_options['responsi_nav_dropdown_padding_top'] ) ? esc_attr( $responsi_options['responsi_nav_dropdown_padding_top'] ) : 0;
    $responsi_nav_dropdown_padding_bottom           = isset( $responsi_options['responsi_nav_dropdown_padding_bottom'] ) ? esc_attr( $responsi_options['responsi_nav_dropdown_padding_bottom'] ) : 0;
    $responsi_nav_dropdown_border_top               = isset( $responsi_options['responsi_nav_dropdown_border_top'] ) ? $responsi_options['responsi_nav_dropdown_border_top'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $responsi_nav_dropdown_border_bottom            = isset( $responsi_options['responsi_nav_dropdown_border_bottom'] ) ? $responsi_options['responsi_nav_dropdown_border_bottom'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $responsi_nav_dropdown_border_left              = isset( $responsi_options['responsi_nav_dropdown_border_left'] ) ? $responsi_options['responsi_nav_dropdown_border_left'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $responsi_nav_dropdown_border_right             = isset( $responsi_options['responsi_nav_dropdown_border_right'] ) ? $responsi_options['responsi_nav_dropdown_border_right'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $responsi_nav_dropdown_border_radius_tl_option  = isset( $responsi_options['responsi_nav_dropdown_border_radius_tl'] ) ? $responsi_options['responsi_nav_dropdown_border_radius_tl'] : array( 'corner' => 'square','rounded_value' => '0' );
    $responsi_nav_dropdown_border_radius_tl         = responsi_generate_border_radius_value($responsi_nav_dropdown_border_radius_tl_option);
    $responsi_nav_dropdown_border_radius_tr_option  = isset( $responsi_options['responsi_nav_dropdown_border_radius_tr'] ) ? $responsi_options['responsi_nav_dropdown_border_radius_tr'] : array( 'corner' => 'square','rounded_value' => '0' );
    $responsi_nav_dropdown_border_radius_tr         = responsi_generate_border_radius_value($responsi_nav_dropdown_border_radius_tr_option);
    $responsi_nav_dropdown_border_radius_bl_option  = isset( $responsi_options['responsi_nav_dropdown_border_radius_bl'] ) ? $responsi_options['responsi_nav_dropdown_border_radius_bl'] : array( 'corner' => 'square','rounded_value' => '0' );
    $responsi_nav_dropdown_border_radius_bl         = responsi_generate_border_radius_value($responsi_nav_dropdown_border_radius_bl_option);
    $responsi_nav_dropdown_border_radius_br_option  = isset( $responsi_options['responsi_nav_dropdown_border_radius_br'] ) ? $responsi_options['responsi_nav_dropdown_border_radius_br'] : array( 'corner' => 'square','rounded_value' => '0' );
    $responsi_nav_dropdown_border_radius_br         = responsi_generate_border_radius_value($responsi_nav_dropdown_border_radius_br_option);
    $responsi_nav_dropdown_shadow_option            = isset( $responsi_options['responsi_nav_dropdown_shadow'] ) ? $responsi_options['responsi_nav_dropdown_shadow'] : array( 'onoff' => 'false' , 'h_shadow' => '0px' , 'v_shadow' => '0px', 'blur' => '5px' , 'spread' => '0px', 'color' => '#DBDBDB', 'inset' => '' );
    $responsi_nav_dropdown_shadow                   = responsi_generate_box_shadow($responsi_nav_dropdown_shadow_option);
    
    $nav_dropdown_css = '';
    $nav_dropdown_css .= responsi_generate_background_color( $responsi_nav_dropdown_background );
    $nav_dropdown_css .= responsi_generate_border( $responsi_nav_dropdown_border_top, 'border-top' );
    $nav_dropdown_css .= responsi_generate_border( $responsi_nav_dropdown_border_bottom, 'border-bottom' );
    $nav_dropdown_css .= responsi_generate_border( $responsi_nav_dropdown_border_left, 'border-left' );
    $nav_dropdown_css .= responsi_generate_border( $responsi_nav_dropdown_border_right, 'border-right' );
    $nav_dropdown_css .= 'padding-top:' . $responsi_nav_dropdown_padding_top . 'px;';
    $nav_dropdown_css .= 'padding-bottom:' . $responsi_nav_dropdown_padding_bottom . 'px;';
    $nav_dropdown_css .= 'padding-left:' . $responsi_nav_dropdown_padding_left . 'px;';
    $nav_dropdown_css .= 'padding-right:' . $responsi_nav_dropdown_padding_right . 'px;';
    $nav_dropdown_css .= 'border-radius:' . $responsi_nav_dropdown_border_radius_tl . ' ' . $responsi_nav_dropdown_border_radius_tr . ' ' . $responsi_nav_dropdown_border_radius_br . ' ' . $responsi_nav_dropdown_border_radius_bl . ';';
    $nav_dropdown_css .= $responsi_nav_dropdown_shadow;
    $dynamic_css .= '#navigation ul.sub-menu li:first-child > a{border-top-left-radius: ' . $responsi_nav_dropdown_border_radius_tl . ';border-top-right-radius: ' . $responsi_nav_dropdown_border_radius_tr . ';}';
    $dynamic_css .= '#navigation ul.sub-menu li:last-child > a{border-bottom-left-radius: ' . $responsi_nav_dropdown_border_radius_bl . ';border-bottom-right-radius: ' . $responsi_nav_dropdown_border_radius_br . ';}';
    $dynamic_css .= '#navigation ul.nav ul{' . $nav_dropdown_css . '}';
    $dynamic_css .= '#navigation ul.nav ul ul{top:-' . esc_attr( $responsi_nav_dropdown_border_top['width'] ) . 'px;}';

    $responsi_nav_dropdown_item_padding_left             = isset( $responsi_options['responsi_nav_dropdown_item_padding_left'] ) ? esc_attr( $responsi_options['responsi_nav_dropdown_item_padding_left'] ) : 0;
    $responsi_nav_dropdown_item_padding_right            = isset( $responsi_options['responsi_nav_dropdown_item_padding_right'] ) ? esc_attr( $responsi_options['responsi_nav_dropdown_item_padding_right'] ) : 0;
    $responsi_nav_dropdown_item_padding_top              = isset( $responsi_options['responsi_nav_dropdown_item_padding_top'] ) ? esc_attr( $responsi_options['responsi_nav_dropdown_item_padding_top'] ) : 0;
    $responsi_nav_dropdown_item_padding_bottom           = isset( $responsi_options['responsi_nav_dropdown_item_padding_bottom'] ) ? esc_attr( $responsi_options['responsi_nav_dropdown_item_padding_bottom'] ) : 0;
    $responsi_nav_dropdown_separator                     = isset( $responsi_options['responsi_nav_dropdown_separator'] ) ? $responsi_options['responsi_nav_dropdown_separator'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $responsi_nav_dropdown_font                          = isset( $responsi_options['responsi_nav_dropdown_font'] ) ? $responsi_options['responsi_nav_dropdown_font'] : array('size' => '13','line_height' => '1','face' => 'Open Sans','style' => 'bold','color' => '#FFFFFF');
    $responsi_nav_dropdown_font_transform                = isset( $responsi_options['responsi_nav_dropdown_font_transform'] ) ? $responsi_options['responsi_nav_dropdown_font_transform'] : 'uppercase';
    $responsi_nav_dropdown_hover_color                   = isset( $responsi_options['responsi_nav_dropdown_hover_color'] ) ? esc_attr( $responsi_options['responsi_nav_dropdown_hover_color'] ) : '#ffffff';
    $responsi_nav_dropdown_item_background               = isset( $responsi_options['responsi_nav_dropdown_item_background'] ) ? $responsi_options['responsi_nav_dropdown_item_background'] :  array( 'onoff' => 'true', 'color' => '#ffffff');
    $responsi_nav_dropdown_hover_background              = isset( $responsi_options['responsi_nav_dropdown_hover_background'] ) ? $responsi_options['responsi_nav_dropdown_hover_background'] :  array( 'onoff' => 'true', 'color' => '#ffffff');
    
    $dynamic_css .= '#navigation ul.nav li ul li a{padding-top:' . $responsi_nav_dropdown_item_padding_top . 'px;padding-bottom:' . $responsi_nav_dropdown_item_padding_bottom . 'px;padding-left:' . $responsi_nav_dropdown_item_padding_left . 'px;padding-right:' . $responsi_nav_dropdown_item_padding_right . 'px;}';
    $dynamic_css .= '#navigation ul.nav ul li {'.responsi_generate_border( $responsi_nav_dropdown_separator, 'border-top' ).'}';
    $dynamic_css .= 'body #navigation ul.nav ul li:first-child{border-top: 0 solid #FFFFFF !important;}';
    $dynamic_css .= 'ul.nav ul li a, #navigation ul.nav li ul li a{ ' . responsi_generate_fonts($responsi_nav_dropdown_font, false) . ' }';
    $dynamic_css .= '#navigation ul.nav li ul li a { text-transform:' . $responsi_nav_dropdown_font_transform . '; }';
    $dynamic_css .= '#navigation ul.nav ul li ,#navigation ul.nav ul li a{white-space: nowrap;' . responsi_generate_background_color($responsi_nav_dropdown_item_background) . '}';
    $dynamic_css .= 'body #navigation ul.sub-menu li{background-color:transparent;}';
    $dynamic_css .= '#navigation ul.nav > li ul li a:hover,#navigation ul.nav > li ul li:hover{' . responsi_generate_background_color($responsi_nav_dropdown_hover_background, true) . '}';
    $dynamic_css .= '#navigation ul.nav > li ul li:hover{background-color:transparent !important;}';
    $dynamic_css .= '#navigation ul.nav > li.menu-item-has-children:hover ul li a{ color:' . esc_attr( $responsi_nav_dropdown_font['color'] ) . '; }';
    $dynamic_css .= '#navigation ul.nav li.menu-item-has-children ul li a:hover{color:' . $responsi_nav_dropdown_hover_color . ';}';
    $dynamic_css .= '#navigation ul.nav > li > ul > li > ul > li > ul > li > a:hover{color:' . $responsi_nav_dropdown_hover_color . ';}';
    $dynamic_css .= '#navigation ul.nav > li > ul > li.menu-item-has-children a:after{ border-color:transparent transparent transparent ' . esc_attr( $responsi_nav_dropdown_font['color'] ) . ';}';
    $dynamic_css .= '#navigation ul.nav > li > ul li.menu-item-has-children:hover > a:hover:after{ border-color:transparent transparent transparent ' . $responsi_nav_dropdown_hover_color . ';}';
    $dynamic_css .= '#navigation > ul.nav > li, #navigation > ul.nav > li:hover, #navigation .partial-refresh-menu-container ul.nav > li, #navigation .partial-refresh-menu-container ul.nav > li:hover {background: none !important;}';
    
    /* Pagination Scroll */
    $scroll_font                                        = isset( $responsi_options['responsi_scroll_font'] ) ? $responsi_options['responsi_scroll_font'] : array('size' => '14','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#555555');
    $scroll_link_hover_color                            = $hover;
    $scroll_font_text_alignment                         = isset( $responsi_options['responsi_scroll_font_text_alignment'] ) ? esc_attr( $responsi_options['responsi_scroll_font_text_alignment'] ) : 'center';
    $scroll_box_margin_top                              = isset( $responsi_options['responsi_scroll_box_margin_top'] ) ? esc_attr( $responsi_options['responsi_scroll_box_margin_top'] ) : 0;
    $scroll_box_margin_bottom                           = isset( $responsi_options['responsi_scroll_box_margin_bottom'] ) ? esc_attr( $responsi_options['responsi_scroll_box_margin_bottom'] ) : 0;
    $scroll_box_margin_left                             = isset( $responsi_options['responsi_scroll_box_margin_left'] ) ? esc_attr( $responsi_options['responsi_scroll_box_margin_left'] ) : 0;
    $scroll_box_margin_right                            = isset( $responsi_options['responsi_scroll_box_margin_right'] ) ? esc_attr( $responsi_options['responsi_scroll_box_margin_right'] ) : 0;
    $scroll_box_padding_top                             = isset( $responsi_options['responsi_scroll_box_padding_top'] ) ? esc_attr( $responsi_options['responsi_scroll_box_padding_top'] ) : 0;
    $scroll_box_padding_bottom                          = isset( $responsi_options['responsi_scroll_box_padding_bottom'] ) ? esc_attr( $responsi_options['responsi_scroll_box_padding_bottom'] ) : 0;
    $scroll_box_padding_left                            = isset( $responsi_options['responsi_scroll_box_padding_left'] ) ? esc_attr( $responsi_options['responsi_scroll_box_padding_left'] ) : 0;
    $scroll_box_padding_right                           = isset( $responsi_options['responsi_scroll_box_padding_right'] ) ? esc_attr( $responsi_options['responsi_scroll_box_padding_right'] ) : 0;
    $scroll_box_bg                                      = isset( $responsi_options['responsi_scroll_box_bg'] ) ? $responsi_options['responsi_scroll_box_bg'] : array( 'onoff' => 'false', 'color' => '#ffffff' );  
    $scroll_box_border_top                              = isset( $responsi_options['responsi_scroll_box_border_top'] ) ? $responsi_options['responsi_scroll_box_border_top'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $scroll_box_border_bottom                           = isset( $responsi_options['responsi_scroll_box_border_bottom'] ) ? $responsi_options['responsi_scroll_box_border_bottom'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $scroll_box_border_lr                               = isset( $responsi_options['responsi_scroll_box_border_lr'] ) ? $responsi_options['responsi_scroll_box_border_lr'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $scroll_box_border_radius_option                    = isset( $responsi_options['responsi_scroll_box_border_radius'] ) ? $responsi_options['responsi_scroll_box_border_radius'] : array( 'corner' => 'square','rounded_value' => '0' );
    $scroll_box_border_radius                           = responsi_generate_border_radius($scroll_box_border_radius_option, true);
    $scroll_box_shadow_option                           = isset( $responsi_options['responsi_scroll_box_shadow'] ) ? $responsi_options['responsi_scroll_box_shadow'] : array( 'onoff' => 'false' , 'h_shadow' => '0px' , 'v_shadow' => '0px', 'blur' => '5px' , 'spread' => '0px', 'color' => '#DBDBDB', 'inset' => '' );
    $scroll_box_shadow                                  = responsi_generate_box_shadow( $scroll_box_shadow_option, true );
        
    $pagination_css = 'box-sizing:border-box;';
    $pagination_css .= 'text-align:' . $scroll_font_text_alignment . ';';
    $pagination_css .= 'margin-top:' . $scroll_box_margin_top . 'px !important;margin-bottom:' . $scroll_box_margin_bottom . 'px !important;margin-left:' . $scroll_box_margin_left . 'px !important;margin-right:' . $scroll_box_margin_right . 'px !important;';
    $pagination_css .= 'padding-top:' . $scroll_box_padding_top . 'px !important;padding-bottom:' . $scroll_box_padding_bottom . 'px !important;padding-left:' . $scroll_box_padding_left . 'px !important;padding-right:' . $scroll_box_padding_right . 'px !important;';
    $pagination_css .= responsi_generate_background_color( $scroll_box_bg, true );
    $pagination_css .= responsi_generate_border( $scroll_box_border_top, 'border-top', true );
    $pagination_css .= responsi_generate_border( $scroll_box_border_bottom, 'border-bottom', true );
    $pagination_css .= responsi_generate_border( $scroll_box_border_lr, 'border-left', true );
    $pagination_css .= responsi_generate_border( $scroll_box_border_lr, 'border-right', true );
    $pagination_css .= $scroll_box_border_radius;
    $pagination_css .= $scroll_box_shadow;
    
    $dynamic_css .= '.click_showmore_container{text-align:center;}';
    $dynamic_css .= 'body #main .click_showmore_container,.nav-entries {' . $pagination_css . '}';
    $dynamic_css .= '.nav-entries, .responsi-pagination,.nav-entries a, .responsi-pagination a,.click_showmore a,.click_showmore { ' . responsi_generate_fonts($scroll_font) . ' }';
    $dynamic_css .= '.responsi-pagination a:hover, .responsi-pagination a:hover,.click_showmore a:hover,.click_showmore a:hover {color:' . $scroll_link_hover_color . '!important}';

    /* Footer Widgets */
    $before_footer_bg                                = isset( $responsi_options['responsi_before_footer_bg'] ) ? $responsi_options['responsi_before_footer_bg'] : array( 'onoff' => 'false', 'color' => '#ffffff' );
    $enable_before_footer_bg_image                   = isset( $responsi_options['responsi_enable_before_footer_bg_image'] ) ? esc_attr( $responsi_options['responsi_enable_before_footer_bg_image'] ) : 'false';
    $before_footer_bg_image                          = isset( $responsi_options['responsi_before_footer_bg_image'] ) ? str_replace( array( 'https:', 'http:' ), '', esc_url( $responsi_options['responsi_before_footer_bg_image'] ) ) : '';
    $before_footer_bg_position_vertical              = isset( $responsi_options['responsi_before_footer_bg_position_vertical'] ) ? esc_attr( $responsi_options['responsi_before_footer_bg_position_vertical'] ) : 'center';
    $before_footer_bg_position_horizontal            = isset( $responsi_options['responsi_before_footer_bg_position_horizontal'] ) ? esc_attr( $responsi_options['responsi_before_footer_bg_position_horizontal'] ) : 'center';
    $before_footer_bg_image_repeat                   = isset( $responsi_options['responsi_before_footer_bg_image_repeat'] ) ? esc_attr( $responsi_options['responsi_before_footer_bg_image_repeat'] ) : 'repeat';
    $before_footer_border_top                        = isset( $responsi_options['responsi_before_footer_border_top'] ) ? $responsi_options['responsi_before_footer_border_top'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $before_footer_border_bottom                     = isset( $responsi_options['responsi_before_footer_border_bottom'] ) ? $responsi_options['responsi_before_footer_border_bottom'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $before_footer_border_lr                         = isset( $responsi_options['responsi_before_footer_border_lr'] ) ? $responsi_options['responsi_before_footer_border_lr'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $before_footer_padding_top                       = isset( $responsi_options['responsi_before_footer_padding_top'] ) ? esc_attr( $responsi_options['responsi_before_footer_padding_top'] ) : 0;
    $before_footer_padding_bottom                    = isset( $responsi_options['responsi_before_footer_padding_bottom'] ) ? esc_attr( $responsi_options['responsi_before_footer_padding_bottom'] ) : 0;
    $before_footer_padding_left                      = isset( $responsi_options['responsi_before_footer_padding_left'] ) ? esc_attr( $responsi_options['responsi_before_footer_padding_left'] ) : 0;
    $before_footer_padding_right                     = isset( $responsi_options['responsi_before_footer_padding_right'] ) ? esc_attr( $responsi_options['responsi_before_footer_padding_right'] ) : 0;
    $before_footer_margin_top                        = isset( $responsi_options['responsi_before_footer_margin_top'] ) ? esc_attr( $responsi_options['responsi_before_footer_margin_top'] ) : 0;
    $before_footer_margin_bottom                     = isset( $responsi_options['responsi_before_footer_margin_bottom'] ) ? esc_attr( $responsi_options['responsi_before_footer_margin_bottom'] ) : 0;
    $before_footer_margin_left                       = isset( $responsi_options['responsi_before_footer_margin_left'] ) ? esc_attr( $responsi_options['responsi_before_footer_margin_left'] ) : 0;
    $before_footer_margin_right                      = isset( $responsi_options['responsi_before_footer_margin_right'] ) ? esc_attr( $responsi_options['responsi_before_footer_margin_right'] ) : 0;
    $before_footer_border_radius_tl_option           = isset( $responsi_options['responsi_before_footer_border_radius_tl'] ) ? $responsi_options['responsi_before_footer_border_radius_tl'] : array( 'corner' => 'square','rounded_value' => '0' );
    $before_footer_border_radius_tl                  = responsi_generate_border_radius_value($before_footer_border_radius_tl_option);
    $before_footer_border_radius_tr_option           = isset( $responsi_options['responsi_before_footer_border_radius_tr'] ) ? $responsi_options['responsi_before_footer_border_radius_tr'] : array( 'corner' => 'square','rounded_value' => '0' );
    $before_footer_border_radius_tr                  = responsi_generate_border_radius_value($before_footer_border_radius_tr_option);
    $before_footer_border_radius_bl_option           = isset( $responsi_options['responsi_before_footer_border_radius_bl'] ) ? $responsi_options['responsi_before_footer_border_radius_bl'] : array( 'corner' => 'square','rounded_value' => '0' );
    $before_footer_border_radius_bl                  = responsi_generate_border_radius_value($before_footer_border_radius_bl_option);
    $before_footer_border_radius_br_option           = isset( $responsi_options['responsi_before_footer_border_radius_br'] ) ? $responsi_options['responsi_before_footer_border_radius_br'] : array( 'corner' => 'square','rounded_value' => '0' );
    $before_footer_border_radius_br                  = responsi_generate_border_radius_value($before_footer_border_radius_br_option);
    $before_footer_box_shadow_option                 = isset( $responsi_options['responsi_before_footer_box_shadow'] ) ? $responsi_options['responsi_before_footer_box_shadow'] : array( 'onoff' => 'false' , 'h_shadow' => '0px' , 'v_shadow' => '0px', 'blur' => '5px' , 'spread' => '0px', 'color' => '#DBDBDB', 'inset' => '' );
    $before_footer_box_shadow                        = responsi_generate_box_shadow($before_footer_box_shadow_option);

    $before_footer_css = 'box-sizing: border-box;position: relative;';
    $before_footer_css .= responsi_generate_background_color($before_footer_bg);
    if ( 'true' === $enable_before_footer_bg_image && '' !== trim( $before_footer_bg_image ) ) {
        $before_footer_css .= 'background-image:url("' . $before_footer_bg_image . '");background-position:' . strtolower($before_footer_bg_position_horizontal) . ' ' . strtolower($before_footer_bg_position_vertical) . ';background-repeat:' . $before_footer_bg_image_repeat . ';';
    }
    $before_footer_css .= responsi_generate_border($before_footer_border_top, 'border-top');
    $before_footer_css .= responsi_generate_border($before_footer_border_bottom, 'border-bottom');
    $before_footer_css .= responsi_generate_border($before_footer_border_lr, 'border-left');
    $before_footer_css .= responsi_generate_border($before_footer_border_lr, 'border-right');
    $before_footer_css .= 'border-radius:' . $before_footer_border_radius_tl . ' ' . $before_footer_border_radius_tr . ' ' . $before_footer_border_radius_br . ' ' . $before_footer_border_radius_bl . ';';
    $before_footer_css .= $before_footer_box_shadow;
    $before_footer_css .= 'padding-top:' . $before_footer_padding_top . 'px;';
    $before_footer_css .= 'padding-bottom:' . $before_footer_padding_bottom . 'px;';
    $before_footer_css .= 'padding-left:' . $before_footer_padding_left . 'px;';
    $before_footer_css .= 'padding-right:' . $before_footer_padding_right . 'px;';
    $before_footer_css .= 'margin-top:' . $before_footer_margin_top . 'px;';
    $before_footer_css .= 'margin-bottom:' . $before_footer_margin_bottom . 'px;';
    $before_footer_css .= 'margin-left:' . $before_footer_margin_left . 'px;';
    $before_footer_css .= 'margin-right:' . $before_footer_margin_right . 'px;';
    
    $dynamic_css .= '#wrapper-footer-top-content{'. $before_footer_css .'}';
    
    $before_footer_content_bg                                 = isset( $responsi_options['responsi_before_footer_content_bg'] ) ? $responsi_options['responsi_before_footer_content_bg'] : array( 'onoff' => 'false', 'color' => '#ffffff' );
    $enable_before_footer_content_bg_image                    = isset( $responsi_options['responsi_enable_before_footer_content_bg_image'] ) ? esc_attr( $responsi_options['responsi_enable_before_footer_content_bg_image'] ) : 'false';
    $responsi_before_footer_content_bg_image                  = isset( $responsi_options['responsi_before_footer_content_bg_image'] ) ? str_replace( array( 'https:', 'http:' ), '', esc_url( $responsi_options['responsi_before_footer_content_bg_image'] ) ) : '';
    $responsi_before_footer_content_bg_position_vertical      = isset( $responsi_options['responsi_before_footer_content_bg_position_vertical'] ) ? esc_attr( $responsi_options['responsi_before_footer_content_bg_position_vertical'] ) : 'center';
    $responsi_before_footer_content_bg_position_horizontal    = isset( $responsi_options['responsi_before_footer_content_bg_position_horizontal'] ) ? esc_attr( $responsi_options['responsi_before_footer_content_bg_position_horizontal'] ) : 'center';
    $responsi_before_footer_content_bg_image_repeat           = isset( $responsi_options['responsi_before_footer_content_bg_image_repeat'] ) ? esc_attr( $responsi_options['responsi_before_footer_content_bg_image_repeat'] ) : 'repeat';
    $responsi_before_footer_content_border_top                = isset( $responsi_options['responsi_before_footer_content_border_top'] ) ? $responsi_options['responsi_before_footer_content_border_top'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $responsi_before_footer_content_border_bottom             = isset( $responsi_options['responsi_before_footer_content_border_bottom'] ) ? $responsi_options['responsi_before_footer_content_border_bottom'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $responsi_before_footer_content_border_lr                 = isset( $responsi_options['responsi_before_footer_content_border_lr'] ) ? $responsi_options['responsi_before_footer_content_border_lr'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $responsi_before_footer_content_padding_top               = isset( $responsi_options['responsi_before_footer_content_padding_top'] ) ? esc_attr( $responsi_options['responsi_before_footer_content_padding_top'] ) : 0;
    $responsi_before_footer_content_padding_bottom            = isset( $responsi_options['responsi_before_footer_content_padding_bottom'] ) ? esc_attr( $responsi_options['responsi_before_footer_content_padding_bottom'] ) : 0;
    $responsi_before_footer_content_padding_left              = isset( $responsi_options['responsi_before_footer_content_padding_left'] ) ? esc_attr( $responsi_options['responsi_before_footer_content_padding_left'] ) : 0;
    $responsi_before_footer_content_padding_right             = isset( $responsi_options['responsi_before_footer_content_padding_right'] ) ? esc_attr( $responsi_options['responsi_before_footer_content_padding_right'] ) : 0;
    $responsi_before_footer_content_margin_top                = isset( $responsi_options['responsi_before_footer_content_margin_top'] ) ? esc_attr( $responsi_options['responsi_before_footer_content_margin_top'] ) : 0;
    $responsi_before_footer_content_margin_bottom             = isset( $responsi_options['responsi_before_footer_content_margin_bottom'] ) ? esc_attr( $responsi_options['responsi_before_footer_content_margin_bottom'] ) : 0;
    $responsi_before_footer_content_margin_left               = isset( $responsi_options['responsi_before_footer_content_margin_left'] ) ? esc_attr( $responsi_options['responsi_before_footer_content_margin_left'] ) : 0;
    $responsi_before_footer_content_margin_right              = isset( $responsi_options['responsi_before_footer_content_margin_right'] ) ? esc_attr( $responsi_options['responsi_before_footer_content_margin_right'] ) : 0;
    $responsi_before_footer_content_border_radius_tl_option   = isset( $responsi_options['responsi_before_footer_content_border_radius_tl'] ) ? $responsi_options['responsi_before_footer_content_border_radius_tl'] : array( 'corner' => 'square','rounded_value' => '0' );
    $responsi_before_footer_content_border_radius_tl          = responsi_generate_border_radius_value($responsi_before_footer_content_border_radius_tl_option);
    $responsi_before_footer_content_border_radius_tr_option   = isset( $responsi_options['responsi_before_footer_content_border_radius_tr'] ) ? $responsi_options['responsi_before_footer_content_border_radius_tr'] : array( 'corner' => 'square','rounded_value' => '0' );
    $responsi_before_footer_content_border_radius_tr          = responsi_generate_border_radius_value($responsi_before_footer_content_border_radius_tr_option);
    $responsi_before_footer_content_border_radius_bl_option   = isset( $responsi_options['responsi_before_footer_content_border_radius_bl'] ) ? $responsi_options['responsi_before_footer_content_border_radius_bl'] : array( 'corner' => 'square','rounded_value' => '0' );
    $responsi_before_footer_content_border_radius_bl          = responsi_generate_border_radius_value($responsi_before_footer_content_border_radius_bl_option);
    $responsi_before_footer_content_border_radius_br_option   = isset( $responsi_options['responsi_before_footer_content_border_radius_br'] ) ? $responsi_options['responsi_before_footer_content_border_radius_br'] : array( 'corner' => 'square','rounded_value' => '0' );
    $responsi_before_footer_content_border_radius_br          = responsi_generate_border_radius_value($responsi_before_footer_content_border_radius_br_option);
    $before_footer_content_box_shadow_option                  = isset( $responsi_options['responsi_before_footer_content_box_shadow'] ) ? $responsi_options['responsi_before_footer_content_box_shadow'] : array( 'onoff' => 'false' , 'h_shadow' => '0px' , 'v_shadow' => '0px', 'blur' => '5px' , 'spread' => '0px', 'color' => '#DBDBDB', 'inset' => '' );
    $before_footer_content_box_shadow                         = responsi_generate_box_shadow($before_footer_content_box_shadow_option);

    $before_footer_content_css = 'box-sizing: border-box;';
    $before_footer_content_css .= responsi_generate_background_color( $before_footer_content_bg );
    if ( 'true' === $enable_before_footer_content_bg_image && '' !== trim( $responsi_before_footer_content_bg_image ) ) {
        $before_footer_content_css .= 'background-image:url("' . $responsi_before_footer_content_bg_image . '");background-position:' . strtolower($responsi_before_footer_content_bg_position_horizontal) . ' ' . strtolower($responsi_before_footer_content_bg_position_vertical) . ';background-repeat:' . $responsi_before_footer_content_bg_image_repeat . ';';
    }
    $before_footer_content_css .= responsi_generate_border($responsi_before_footer_content_border_top, 'border-top');
    $before_footer_content_css .= responsi_generate_border($responsi_before_footer_content_border_bottom, 'border-bottom');
    $before_footer_content_css .= responsi_generate_border($responsi_before_footer_content_border_lr, 'border-left');
    $before_footer_content_css .= responsi_generate_border($responsi_before_footer_content_border_lr, 'border-right');
    $before_footer_content_css .= 'border-radius:' . $responsi_before_footer_content_border_radius_tl . ' ' . $responsi_before_footer_content_border_radius_tr . ' ' . $responsi_before_footer_content_border_radius_br . ' ' . $responsi_before_footer_content_border_radius_bl . ';';
    $before_footer_content_css .= $before_footer_content_box_shadow;
    $before_footer_content_css .= 'padding-top:' . $responsi_before_footer_content_padding_top . 'px;';
    $before_footer_content_css .= 'padding-bottom:' . $responsi_before_footer_content_padding_bottom . 'px;';
    $before_footer_content_css .= 'padding-left:' . $responsi_before_footer_content_padding_left . 'px;';
    $before_footer_content_css .= 'padding-right:' . $responsi_before_footer_content_padding_right . 'px;';
    $before_footer_content_css .= 'margin-top:' . $responsi_before_footer_content_margin_top . 'px;';
    $before_footer_content_css .= 'margin-bottom:' . $responsi_before_footer_content_margin_bottom . 'px;';
    $before_footer_content_css .= 'margin-left:' . $responsi_before_footer_content_margin_left . 'px;';
    $before_footer_content_css .= 'margin-right:' . $responsi_before_footer_content_margin_right . 'px;';
    
    $dynamic_css .= '#wrapper-footer-top-content #footer-top-content{'. $before_footer_content_css .'}';

    $font_footer_widget_text              = isset($responsi_options['responsi_font_footer_widget_text']) ? $responsi_options['responsi_font_footer_widget_text'] : array('size' => '12','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#ffffff');
    $footer_widget_link_color             = isset($responsi_options['responsi_footer_widget_link_color']) ? esc_attr( $responsi_options['responsi_footer_widget_link_color'] ) : '#ffffff';
    $footer_widget_link_hover_color       = isset($responsi_options['responsi_footer_widget_link_hover_color']) ? esc_attr( $responsi_options['responsi_footer_widget_link_hover_color'] ) : '#ff6868';
    $footer_widget_link_visited_color     = isset($responsi_options['responsi_footer_widget_link_visited_color']) ? esc_attr( $responsi_options['responsi_footer_widget_link_visited_color'] ) : '#ffffff';
    $footer_widget_padding_top            = isset($responsi_options['responsi_footer_widget_padding_top']) ? esc_attr( $responsi_options['responsi_footer_widget_padding_top'] ) : '0';
    $footer_widget_padding_bottom         = isset($responsi_options['responsi_footer_widget_padding_bottom']) ? esc_attr( $responsi_options['responsi_footer_widget_padding_bottom'] ) : '0';
    $footer_widget_padding_left           = isset($responsi_options['responsi_footer_widget_padding_left']) ? esc_attr( $responsi_options['responsi_footer_widget_padding_left'] ) : '0';
    $footer_widget_padding_right          = isset($responsi_options['responsi_footer_widget_padding_right']) ? esc_attr( $responsi_options['responsi_footer_widget_padding_right'] ) : '0';
    $footer_widget_bg                     = isset($responsi_options['responsi_footer_widget_bg']) ? $responsi_options['responsi_footer_widget_bg'] : array( 'onoff' => 'false', 'color' => '#ffffff');
    $footer_widget_border                 = isset($responsi_options['responsi_footer_widget_border']) ? $responsi_options['responsi_footer_widget_border'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB','corner' => 'square', 'topleft' => '0', 'topright' => '0', 'bottomright' => '0', 'bottomleft' => '0');
    $font_footer_widget_title             = isset($responsi_options['responsi_font_footer_widget_title']) ? $responsi_options['responsi_font_footer_widget_title'] : array('size' => '15','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#ffffff');
    $footer_widget_title_bg               = isset($responsi_options['responsi_footer_widget_title_bg']) ? $responsi_options['responsi_footer_widget_title_bg'] : array( 'onoff' => 'false', 'color' => '#ffffff');
    $footer_widget_title_border_top       = isset($responsi_options['responsi_footer_widget_title_border_top']) ? $responsi_options['responsi_footer_widget_title_border_top'] : array('width' => '0','style' => 'solid','color' => '#ffffff');
    $footer_widget_title_border_bottom    = isset($responsi_options['responsi_footer_widget_title_border_bottom']) ? $responsi_options['responsi_footer_widget_title_border_bottom'] : array('width' => '0','style' => 'solid','color' => '#ffffff');
    $footer_widget_title_border_left      = isset($responsi_options['responsi_footer_widget_title_border_left']) ? $responsi_options['responsi_footer_widget_title_border_left'] : array('width' => '0','style' => 'solid','color' => '#ffffff');
    $footer_widget_title_border_right     = isset($responsi_options['responsi_footer_widget_title_border_right']) ? $responsi_options['responsi_footer_widget_title_border_right'] : array('width' => '0','style' => 'solid','color' => '#ffffff');
    $widget_title_border_radius_tl_option = isset( $responsi_options['responsi_footer_widget_title_border_radius_tl'] ) ? $responsi_options['responsi_footer_widget_title_border_radius_tl'] : array( 'corner' => 'square','rounded_value' => '0' );
    $widget_title_border_radius_tr_option = isset( $responsi_options['responsi_footer_widget_title_border_radius_tr'] ) ? $responsi_options['responsi_footer_widget_title_border_radius_tr'] : array( 'corner' => 'square','rounded_value' => '0' );
    $widget_title_border_radius_bl_option = isset( $responsi_options['responsi_footer_widget_title_border_radius_bl'] ) ? $responsi_options['responsi_footer_widget_title_border_radius_bl'] : array( 'corner' => 'square','rounded_value' => '0' );
    $widget_title_border_radius_br_option = isset( $responsi_options['responsi_footer_widget_title_border_radius_br'] ) ? $responsi_options['responsi_footer_widget_title_border_radius_br'] : array( 'corner' => 'square','rounded_value' => '0' );
    $widget_title_border_radius_tl        = responsi_generate_border_radius_value( $widget_title_border_radius_tl_option );
    $widget_title_border_radius_tr        = responsi_generate_border_radius_value( $widget_title_border_radius_tr_option );
    $widget_title_border_radius_bl        = responsi_generate_border_radius_value( $widget_title_border_radius_bl_option );
    $widget_title_border_radius_br        = responsi_generate_border_radius_value( $widget_title_border_radius_br_option );
    $footer_widget_box_shadow_option      = isset($responsi_options['responsi_footer_widget_box_shadow']) ? $responsi_options['responsi_footer_widget_box_shadow'] : array( 'onoff' => 'false' , 'h_shadow' => '0px' , 'v_shadow' => '0px', 'blur' => '8px' , 'spread' => '0px', 'color' => '#DBDBDB', 'inset' => '' );
    $footer_widget_box_shadow             = responsi_generate_box_shadow( $footer_widget_box_shadow_option );
    
    $footer_widget_title_box_shadow_option = isset($responsi_options['responsi_footer_widget_title_box_shadow']) ? $responsi_options['responsi_footer_widget_title_box_shadow'] : array( 'onoff' => 'false' , 'h_shadow' => '0px' , 'v_shadow' => '0px', 'blur' => '0px' , 'spread' => '0px', 'color' => '#DBDBDB', 'inset' => '' );
    $footer_widget_title_box_shadow       = responsi_generate_box_shadow( $footer_widget_title_box_shadow_option );

    $footer_widget_title_align            = isset($responsi_options['responsi_footer_widget_title_align']) ? esc_attr( $responsi_options['responsi_footer_widget_title_align'] ) : 'stretched';
    $footer_widget_title_transform        = isset($responsi_options['responsi_footer_widget_title_transform']) ? esc_attr( $responsi_options['responsi_footer_widget_title_transform'] ) : 'uppercase';
    $footer_widget_title_text_alignment   = isset($responsi_options['responsi_footer_widget_title_text_alignment']) ? esc_attr( $responsi_options['responsi_footer_widget_title_text_alignment'] ) : 'left';
    $footer_widget_title_padding_top      = isset($responsi_options['responsi_footer_widget_title_padding_top']) ? esc_attr( $responsi_options['responsi_footer_widget_title_padding_top'] ) : '0';
    $footer_widget_title_padding_bottom   = isset($responsi_options['responsi_footer_widget_title_padding_bottom']) ? esc_attr( $responsi_options['responsi_footer_widget_title_padding_bottom'] ) : '5';
    $footer_widget_title_padding_left     = isset($responsi_options['responsi_footer_widget_title_padding_left']) ? esc_attr( $responsi_options['responsi_footer_widget_title_padding_left'] ) : '0';
    $footer_widget_title_padding_right    = isset($responsi_options['responsi_footer_widget_title_padding_right']) ? esc_attr( $responsi_options['responsi_footer_widget_title_padding_right'] ) : '0';
    $footer_widget_title_margin_top       = isset($responsi_options['responsi_footer_widget_title_margin_top']) ? esc_attr( $responsi_options['responsi_footer_widget_title_margin_top'] ) : '0';
    $footer_widget_title_margin_bottom    = isset($responsi_options['responsi_footer_widget_title_margin_bottom']) ? esc_attr( $responsi_options['responsi_footer_widget_title_margin_bottom'] ) : '5';
    $footer_widget_title_margin_left      = isset($responsi_options['responsi_footer_widget_title_margin_left']) ? esc_attr( $responsi_options['responsi_footer_widget_title_margin_left'] ) : '0';
    $footer_widget_title_margin_right     = isset($responsi_options['responsi_footer_widget_title_margin_right']) ? esc_attr( $responsi_options['responsi_footer_widget_title_margin_right'] ) : '0';
    $footer_widget_text_alignment         = isset($responsi_options['responsi_font_footer_widget_text_alignment']) ? esc_attr( $responsi_options['responsi_font_footer_widget_text_alignment'] ) : 'left';
    $footer_widget_content_padding_top    = isset($responsi_options['responsi_footer_widget_content_padding_top']) ? esc_attr( $responsi_options['responsi_footer_widget_content_padding_top'] ) : '0'; 
    $footer_widget_content_padding_bottom = isset($responsi_options['responsi_footer_widget_content_padding_bottom']) ? esc_attr( $responsi_options['responsi_footer_widget_content_padding_bottom'] ) : '0';
    $footer_widget_content_padding_left   = isset($responsi_options['responsi_footer_widget_content_padding_left']) ? esc_attr( $responsi_options['responsi_footer_widget_content_padding_left'] ) : '0';
    $footer_widget_content_padding_right  = isset($responsi_options['responsi_footer_widget_content_padding_right']) ? esc_attr( $responsi_options['responsi_footer_widget_content_padding_right'] ) : '0';
    $footer_widget_margin_between         = isset($responsi_options['responsi_footer_widget_margin_between']) ? esc_attr( $responsi_options['responsi_footer_widget_margin_between'] ) : '0';
    $responsi_font_footer_widget_list     = isset($responsi_options['responsi_font_footer_widget_list']) ? $responsi_options['responsi_font_footer_widget_list'] : array('size' => '13','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#ffffff');
    $before_footer_border_list            = isset($responsi_options['responsi_before_footer_border_list']) ? $responsi_options['responsi_before_footer_border_list'] : array('width' => '0','style' => 'solid','color' => '#f8a71d');
    
    $footer_widget_item_css = '';
    $footer_widget_item_css .= 'padding-top:' . $footer_widget_content_padding_top . 'px !important;';
    $footer_widget_item_css .= 'padding-bottom:' . $footer_widget_content_padding_bottom . 'px !important;';
    $footer_widget_item_css .= 'padding-left:' . $footer_widget_content_padding_left . 'px !important;';
    $footer_widget_item_css .= 'padding-right:' . $footer_widget_content_padding_right . 'px !important;';
    $dynamic_css .= '.masonry_widget_footer .fw_widget_content{' . $footer_widget_item_css . '}';
    if ( isset($responsi_options['responsi_font_footer_widget_text_alignment_mobile']) && 'true' === $responsi_options['responsi_font_footer_widget_text_alignment_mobile'] ) {
        $dynamic_css .= '@media only screen and (max-width: 782px){.masonry_widget_footer .widget .fw_widget_title, .masonry_widget_footer .widget .fw_widget_title *, .masonry_widget_footer .widget .fw_widget_content, .masonry_widget_footer .widget .fw_widget_content * {text-align:center !important;}}';
    }
    
    $footer_widget_css = 'float: none;';
    $footer_widget_css .= responsi_generate_fonts($font_footer_widget_text);
    $footer_widget_css .= 'padding-top:' . $footer_widget_padding_top . 'px;';
    $footer_widget_css .= 'padding-bottom:' . $footer_widget_padding_bottom . 'px;';
    $footer_widget_css .= 'padding-left:' . $footer_widget_padding_left . 'px;';
    $footer_widget_css .= 'padding-right:' . $footer_widget_padding_right . 'px;';
    $footer_widget_css .= responsi_generate_background_color($footer_widget_bg);
    $footer_widget_css .= responsi_generate_border_boxes($footer_widget_border);
    $footer_widget_css .= $footer_widget_box_shadow;
    $footer_widget_css .= 'text-align:' . $footer_widget_text_alignment . ';';
    $footer_widget_css .= 'margin-bottom:' . $footer_widget_margin_between . 'px;';
    $dynamic_css .= '.masonry_widget_footer .widget{' . $footer_widget_css . '}';
    
    $footer_widget_title_css = '';
    $footer_widget_title_css .= responsi_generate_fonts($font_footer_widget_title, true);
    $footer_widget_title_css .= 'text-transform:' . $footer_widget_title_transform . ' !important;';
    $footer_widget_title_css .= 'text-align:' . $footer_widget_title_text_alignment . ' !important;';
    $footer_widget_title_css .= responsi_generate_background_color($footer_widget_title_bg);
    $footer_widget_title_css .= responsi_generate_border($footer_widget_title_border_top, 'border-top');
    $footer_widget_title_css .= responsi_generate_border($footer_widget_title_border_left, 'border-left');
    $footer_widget_title_css .= responsi_generate_border($footer_widget_title_border_right, 'border-right');
    $footer_widget_title_css .= responsi_generate_border($footer_widget_title_border_bottom, 'border-bottom');
    $footer_widget_title_css .= 'border-radius:' . $widget_title_border_radius_tl . ' ' . $widget_title_border_radius_tr . ' ' . $widget_title_border_radius_br . ' ' . $widget_title_border_radius_bl . ';';
    $footer_widget_title_css .= $footer_widget_title_box_shadow;
    $footer_widget_title_css .= 'padding-top:' . $footer_widget_title_padding_top . 'px !important;padding-bottom:' . $footer_widget_title_padding_bottom . 'px !important;';
    $footer_widget_title_css .= 'padding-left:' . $footer_widget_title_padding_left . 'px !important;padding-right:' . $footer_widget_title_padding_right . 'px !important;';
    $footer_widget_title_css .= 'margin-top:' . $footer_widget_title_margin_top . 'px;margin-bottom:' . $footer_widget_title_margin_bottom . 'px;';
    $footer_widget_title_css .= 'margin-left:' . $footer_widget_title_margin_left . 'px;margin-right:' . $footer_widget_title_margin_right . 'px;';
    
    if ( $footer_widget_title_align ) {
        if ( 'Left' === $footer_widget_title_align || 'left'  === $footer_widget_title_align ) {
            $footer_widget_title_css .= 'float:left !important;';
        }
        if ( 'Right' === $footer_widget_title_align || 'right' === $footer_widget_title_align ) {
            $footer_widget_title_css .= 'float:right !important;';
        }
        if ( 'Center' === $footer_widget_title_align || 'center' === $footer_widget_title_align ) {
            $footer_widget_title_css .= 'float:none !important;margin-left:auto !important;margin-right:auto !important;display:table;';
        }
        if ( 'Stretched' === $footer_widget_title_align || 'stretched' === $footer_widget_title_align ) {
            $footer_widget_title_css .= 'float:none !important;display:block;';
        }
    }
    $dynamic_css .= '.masonry_widget_footer .fw_widget_title h3, .masonry_widget_footer .widget .fw_widget_title h3 {' . $footer_widget_title_css . '}';
    $dynamic_css .= '.masonry_widget_footer .widget, .masonry_widget_footer .widget ul li, .masonry_widget_footer .widget ol li,.masonry_widget_footer .widget p, .masonry_widget_footer .widget .textwidget, .masonry_widget_footer .widget:not(div), .masonry_widget_footer .widget .textwidget .tel, .masonry_widget_footer .widget .textwidget .tel a, .masonry_widget_footer .widget .textwidget a[href^=tel], .masonry_widget_footer .widget * a[href^=tel], .masonry_widget_footer .widget a[href^=tel] { text-decoration: none; ' . responsi_generate_fonts($font_footer_widget_text) . '}';
    $dynamic_css .= '.masonry_widget_footer .widget a,.masonry_widget_footer .widget a, .masonry_widget_footer .widget a:link,.masonry_widget_footer .widget a:link {color:' . $footer_widget_link_color . '}';
    $dynamic_css .= '.masonry_widget_footer .widget a:visited,.masonry_widget_footer .widget a:visited {color:' . $footer_widget_link_visited_color . '}';
    $dynamic_css .= '.masonry_widget_footer .widget a:hover,.masonry_widget_footer .widget a:hover {color:' . $footer_widget_link_hover_color . '}';
    $dynamic_css .= '#wrapper-footer-top .widget ul li a{' . responsi_generate_fonts($responsi_font_footer_widget_list, true) . '}';
    $dynamic_css .= '#wrapper-footer-top .widget ul li a:visited{color:' . $footer_widget_link_visited_color . ' !important;}';
    $dynamic_css .= '#wrapper-footer-top .widget ul li a:hover{color:' . $footer_widget_link_hover_color . ' !important;}';

    if ( isset( $before_footer_border_list['width'] ) && $before_footer_border_list['width'] > 0) {
        $dynamic_css .= '#wrapper-footer-top .widget ul li{'.responsi_generate_border($before_footer_border_list, 'border-top').'}';
        $dynamic_css .= '#wrapper-footer-top .widget ul li:first-child{border-top-width: 0;}';
    } else {
        $dynamic_css .= '#wrapper-footer-top .widget ul li{margin-top: 0 !important;padding: 0 !important;border-top-width: 0;}';
        $dynamic_css .= '#wrapper-footer-top .widget ul li:first-child{border-top-width: 0;}';
    }
    
    /* Footer */
    $footer_font                                = isset($responsi_options['responsi_footer_font']) ? $responsi_options['responsi_footer_font'] : array('size' => '12','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#ffffff');
    $_footer_link_color                         = isset($responsi_options['responsi_footer_link_color']) ? esc_attr( $responsi_options['responsi_footer_link_color'] ): '#ffffff';
    $_footer_link_color_hover                   = isset($responsi_options['responsi_footer_link_color_hover']) ? esc_attr( $responsi_options['responsi_footer_link_color_hover'] ): '#ff0000';
    $footer_custom_font                         = isset($responsi_options['responsi_footer_custom_font']) ? $responsi_options['responsi_footer_custom_font'] : array('size' => '12','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#ffffff');
    $footer_custom_link_color                   = isset($responsi_options['responsi_footer_custom_link_color']) ? esc_attr( $responsi_options['responsi_footer_custom_link_color'] ) : '#ffffff';
    $footer_custom_link_color_hover             = isset($responsi_options['responsi_footer_custom_link_color_hover']) ? esc_attr( $responsi_options['responsi_footer_custom_link_color_hover'] ) : '#ff0000';
    $footer_bg                                  = isset($responsi_options['responsi_footer_bg']) ? $responsi_options['responsi_footer_bg'] : array( 'onoff' => 'true', 'color' => '#000000');
    $footer_border_top                          = isset($responsi_options['responsi_footer_border_top']) ? $responsi_options['responsi_footer_border_top'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $footer_border_bottom                       = isset($responsi_options['responsi_footer_border_bottom']) ? $responsi_options['responsi_footer_border_bottom'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $footer_border_lr                           = isset($responsi_options['responsi_footer_border_lr']) ? $responsi_options['responsi_footer_border_lr'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $responsi_footer_border_radius_tl_option    = isset( $responsi_options['responsi_footer_border_radius_tl'] ) ? $responsi_options['responsi_footer_border_radius_tl'] : array( 'corner' => 'square','rounded_value' => '0' );
    $responsi_footer_border_radius_tr_option    = isset( $responsi_options['responsi_footer_border_radius_tr'] ) ? $responsi_options['responsi_footer_border_radius_tr'] : array( 'corner' => 'square','rounded_value' => '0' );
    $responsi_footer_border_radius_bl_option    = isset( $responsi_options['responsi_footer_border_radius_bl'] ) ? $responsi_options['responsi_footer_border_radius_bl'] : array( 'corner' => 'square','rounded_value' => '0' );
    $responsi_footer_border_radius_br_option    = isset( $responsi_options['responsi_footer_border_radius_br'] ) ? $responsi_options['responsi_footer_border_radius_br'] : array( 'corner' => 'square','rounded_value' => '0' );
    $responsi_footer_border_radius_tl           = responsi_generate_border_radius_value( $responsi_footer_border_radius_tl_option );
    $responsi_footer_border_radius_tr           = responsi_generate_border_radius_value( $responsi_footer_border_radius_tr_option );
    $responsi_footer_border_radius_bl           = responsi_generate_border_radius_value( $responsi_footer_border_radius_bl_option );
    $responsi_footer_border_radius_br           = responsi_generate_border_radius_value( $responsi_footer_border_radius_br_option );
    $responsi_footer_padding_top                = isset($responsi_options['responsi_footer_padding_top']) ? esc_attr( $responsi_options['responsi_footer_padding_top'] ) : '0';
    $responsi_footer_padding_bottom             = isset($responsi_options['responsi_footer_padding_bottom']) ? esc_attr( $responsi_options['responsi_footer_padding_bottom'] ) : '0';
    $responsi_footer_padding_left               = isset($responsi_options['responsi_footer_padding_left']) ? esc_attr( $responsi_options['responsi_footer_padding_left'] ) : '0';
    $responsi_footer_padding_right              = isset($responsi_options['responsi_footer_padding_right']) ? esc_attr( $responsi_options['responsi_footer_padding_right'] ) : '0';
    $responsi_footer_margin_top                 = isset($responsi_options['responsi_footer_margin_top']) ? esc_attr( $responsi_options['responsi_footer_margin_top'] ) : '0';
    $responsi_footer_margin_bottom              = isset($responsi_options['responsi_footer_margin_bottom']) ? esc_attr( $responsi_options['responsi_footer_margin_bottom'] ) : '0';
    $responsi_footer_margin_left                = isset($responsi_options['responsi_footer_margin_left']) ? esc_attr( $responsi_options['responsi_footer_margin_left'] ) : '0';
    $responsi_footer_margin_right               = isset($responsi_options['responsi_footer_margin_right']) ? esc_attr( $responsi_options['responsi_footer_margin_right'] ) : '0';
    $responsi_footer_box_shadow_option          = isset($responsi_options['responsi_footer_box_shadow']) ? $responsi_options['responsi_footer_box_shadow'] : array( 'onoff' => 'false' , 'h_shadow' => '0px' , 'v_shadow' => '0px', 'blur' => '8px' , 'spread' => '0px', 'color' => '#DBDBDB', 'inset' => '' );
    $responsi_footer_box_shadow                 = responsi_generate_box_shadow($responsi_footer_box_shadow_option);
    $enable_footer_bg_image                     = isset($responsi_options['responsi_enable_footer_bg_image']) ? esc_attr( $responsi_options['responsi_enable_footer_bg_image'] ) : 'false';
    $responsi_footer_bg_image                   = isset($responsi_options['responsi_footer_bg_image']) ? str_replace( array( 'https:', 'http:' ), '', esc_url( $responsi_options['responsi_footer_bg_image'] ) ) : '';
    $responsi_footer_bg_position_vertical       = isset($responsi_options['responsi_footer_bg_position_vertical']) ? esc_attr( $responsi_options['responsi_footer_bg_position_vertical'] ) : 'center';
    $responsi_footer_bg_position_horizontal     = isset($responsi_options['responsi_footer_bg_position_horizontal']) ? esc_attr( $responsi_options['responsi_footer_bg_position_horizontal'] ) : 'center';
    $responsi_footer_bg_image_repeat            = isset($responsi_options['responsi_footer_bg_image_repeat']) ? esc_attr( $responsi_options['responsi_footer_bg_image_repeat'] ) : 'repeat';

    $dynamic_css .= '#footer, #footer p { ' . responsi_generate_fonts($footer_font) . ' }';
    $dynamic_css .= '#footer a, #footer * a,#footer a:active { color:' . $_footer_link_color . ' !important; }';
    $dynamic_css .= '#footer a:hover, #footer * a:hover ,#footer a:active:hover{ color:' . $_footer_link_color_hover . ' !important; }';
    $dynamic_css .= '#footer #additional, #footer #additional p { ' . responsi_generate_fonts($footer_custom_font) . ' }';
    $dynamic_css .= '#footer #additional a, #footer #additional * a,#footer #additional a:active { color:' . $footer_custom_link_color . ' !important; }';
    $dynamic_css .= '#footer #additional a:hover, #footer #additional * a:hover ,#footer #additional a:active:hover{ color:' . $footer_custom_link_color_hover . ' !important; }';
    
    $footer_css = 'box-sizing: border-box;overflow: initial;';
    $footer_css .= responsi_generate_background_color($footer_bg, true);
    $footer_css .= responsi_generate_border($footer_border_top, 'border-top');
    $footer_css .= responsi_generate_border($footer_border_bottom, 'border-bottom');
    $footer_css .= responsi_generate_border($footer_border_lr, 'border-left');
    $footer_css .= responsi_generate_border($footer_border_lr, 'border-right');
    $footer_css .= 'border-radius:' . $responsi_footer_border_radius_tl . ' ' . $responsi_footer_border_radius_tr . ' ' . $responsi_footer_border_radius_br . ' ' . $responsi_footer_border_radius_bl . ';';
    if ( 'true' === $enable_footer_bg_image && '' !== trim($responsi_footer_bg_image) ) {
        $footer_css .= 'background-image:url("' . $responsi_footer_bg_image . '");background-position:' . strtolower($responsi_footer_bg_position_horizontal) . ' ' . strtolower($responsi_footer_bg_position_vertical) . ';background-repeat:' . $responsi_footer_bg_image_repeat . ';';
    }

    $footer_css .= $responsi_footer_box_shadow;
    $footer_css .= 'padding-top:' . $responsi_footer_padding_top . 'px !important;';
    $footer_css .= 'padding-bottom:' . $responsi_footer_padding_bottom . 'px !important;';
    $footer_css .= 'padding-left:' . $responsi_footer_padding_left . 'px !important;';
    $footer_css .= 'padding-right:' . $responsi_footer_padding_right . 'px !important;';
    $footer_css .= 'margin-top:' . $responsi_footer_margin_top . 'px !important;';
    $footer_css .= 'margin-bottom:' . $responsi_footer_margin_bottom . 'px !important;';
    $footer_css .= 'margin-left:' . $responsi_footer_margin_left . 'px !important;';
    $footer_css .= 'margin-right:' . $responsi_footer_margin_right . 'px !important;';
    
    $dynamic_css .= '#wrapper-footer-content{' . $footer_css . ';}';

    $footer_content_bg                              = isset($responsi_options['responsi_footer_content_bg']) ? $responsi_options['responsi_footer_content_bg'] : array( 'onoff' => 'false', 'color' => '#000000');
    $footer_content_border_top                      = isset($responsi_options['responsi_footer_content_border_top']) ? $responsi_options['responsi_footer_content_border_top'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $footer_content_border_bottom                   = isset($responsi_options['responsi_footer_content_border_bottom']) ? $responsi_options['responsi_footer_content_border_bottom'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $footer_content_border_lr                       = isset($responsi_options['responsi_footer_content_border_lr']) ? $responsi_options['responsi_footer_content_border_lr'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $responsi_footer_content_border_radius_tl_option    = isset( $responsi_options['responsi_footer_content_border_radius_tl'] ) ? $responsi_options['responsi_footer_content_border_radius_tl'] : array( 'corner' => 'square','rounded_value' => '0' );
    $responsi_footer_content_border_radius_tr_option    = isset( $responsi_options['responsi_footer_content_border_radius_tr'] ) ? $responsi_options['responsi_footer_content_border_radius_tr'] : array( 'corner' => 'square','rounded_value' => '0' );
    $responsi_footer_content_border_radius_bl_option    = isset( $responsi_options['responsi_footer_content_border_radius_bl'] ) ? $responsi_options['responsi_footer_content_border_radius_bl'] : array( 'corner' => 'square','rounded_value' => '0' );
    $responsi_footer_content_border_radius_br_option    = isset( $responsi_options['responsi_footer_content_border_radius_br'] ) ? $responsi_options['responsi_footer_content_border_radius_br'] : array( 'corner' => 'square','rounded_value' => '0' );
    $responsi_footer_content_border_radius_tl       = responsi_generate_border_radius_value( $responsi_footer_content_border_radius_tl_option );
    $responsi_footer_content_border_radius_tr       = responsi_generate_border_radius_value( $responsi_footer_content_border_radius_tr_option );
    $responsi_footer_content_border_radius_bl       = responsi_generate_border_radius_value( $responsi_footer_content_border_radius_bl_option );
    $responsi_footer_content_border_radius_br       = responsi_generate_border_radius_value( $responsi_footer_content_border_radius_br_option );
    $responsi_footer_content_padding_top            = isset($responsi_options['responsi_footer_content_padding_top']) ? esc_attr( $responsi_options['responsi_footer_content_padding_top'] ) : '0';
    $responsi_footer_content_padding_bottom         = isset($responsi_options['responsi_footer_content_padding_bottom']) ? esc_attr( $responsi_options['responsi_footer_content_padding_bottom'] ) : '0';
    $responsi_footer_content_padding_left           = isset($responsi_options['responsi_footer_content_padding_left']) ? esc_attr( $responsi_options['responsi_footer_content_padding_left'] ) : '0';
    $responsi_footer_content_padding_right          = isset($responsi_options['responsi_footer_content_padding_right']) ? esc_attr( $responsi_options['responsi_footer_content_padding_right'] ) : '0';
    $responsi_footer_content_margin_top             = isset($responsi_options['responsi_footer_content_margin_top']) ? esc_attr( $responsi_options['responsi_footer_content_margin_top'] ) : '0';
    $responsi_footer_content_margin_bottom          = isset($responsi_options['responsi_footer_content_margin_bottom']) ? esc_attr( $responsi_options['responsi_footer_content_margin_bottom'] ) : '0';
    $responsi_footer_content_margin_left            = isset($responsi_options['responsi_footer_content_margin_left']) ? esc_attr( $responsi_options['responsi_footer_content_margin_left'] ) : '0';
    $responsi_footer_content_margin_right           = isset($responsi_options['responsi_footer_content_margin_right']) ? esc_attr( $responsi_options['responsi_footer_content_margin_right'] ) : '0';
    
    
    $responsi_footer_content_box_shadow_option      = isset($responsi_options['responsi_footer_content_box_shadow']) ? $responsi_options['responsi_footer_content_box_shadow'] : array( 'onoff' => 'false' , 'h_shadow' => '0px' , 'v_shadow' => '0px', 'blur' => '8px' , 'spread' => '0px', 'color' => '#DBDBDB', 'inset' => '' );
    $responsi_footer_content_box_shadow             = responsi_generate_box_shadow($responsi_footer_content_box_shadow_option);
    $enable_footer_content_bg_image                 = isset($responsi_options['responsi_enable_footer_content_bg_image']) ? esc_attr( $responsi_options['responsi_enable_footer_content_bg_image'] ) : 'false';
    $responsi_footer_content_bg_image               = isset($responsi_options['responsi_footer_content_bg_image']) ? str_replace( array( 'https:', 'http:' ), '', esc_url( $responsi_options['responsi_footer_content_bg_image'] ) ) : '';
    $responsi_footer_content_bg_position_vertical   = isset($responsi_options['responsi_footer_content_bg_position_vertical']) ? esc_attr( $responsi_options['responsi_footer_content_bg_position_vertical'] ) : 'center';
    $responsi_footer_content_bg_position_horizontal = isset($responsi_options['responsi_footer_content_bg_position_horizontal']) ? esc_attr( $responsi_options['responsi_footer_content_bg_position_horizontal'] ) : 'center';
    $responsi_footer_content_bg_image_repeat        = isset($responsi_options['responsi_footer_content_bg_image_repeat']) ? esc_attr( $responsi_options['responsi_footer_content_bg_image_repeat'] ) : 'repeat';

    $footer_content_css = 'box-sizing: border-box;';
    $footer_content_css .= responsi_generate_background_color($footer_content_bg, true);
    $footer_content_css .= responsi_generate_border($footer_content_border_top, 'border-top', true);
    $footer_content_css .= responsi_generate_border($footer_content_border_bottom, 'border-bottom', true);
    $footer_content_css .= responsi_generate_border($footer_content_border_lr, 'border-left', true);
    $footer_content_css .= responsi_generate_border($footer_content_border_lr, 'border-right', true);
    $footer_content_css .= 'border-radius:' . $responsi_footer_content_border_radius_tl . ' ' . $responsi_footer_content_border_radius_tr . ' ' . $responsi_footer_content_border_radius_br . ' ' . $responsi_footer_content_border_radius_bl . ';';
    if ( 'true' === $enable_footer_content_bg_image && '' !== $responsi_footer_content_bg_image ) {
        $footer_content_css .= 'background-image:url("' . $responsi_footer_content_bg_image . '");background-position:' . strtolower($responsi_footer_content_bg_position_horizontal) . ' ' . strtolower($responsi_footer_content_bg_position_vertical) . ';background-repeat:' . $responsi_footer_content_bg_image_repeat . ';';
    }
    $footer_content_css .= $responsi_footer_content_box_shadow;
    $footer_content_css .= 'padding-top:' . $responsi_footer_content_padding_top . 'px !important;';
    $footer_content_css .= 'padding-bottom:' . $responsi_footer_content_padding_bottom . 'px !important;';
    $footer_content_css .= 'padding-left:' . $responsi_footer_content_padding_left . 'px !important;';
    $footer_content_css .= 'padding-right:' . $responsi_footer_content_padding_right . 'px !important;';
    $footer_content_css .= 'margin-top:' . $responsi_footer_content_margin_top . 'px !important;';
    $footer_content_css .= 'margin-bottom:' . $responsi_footer_content_margin_bottom . 'px !important;';
    $footer_content_css .= 'margin-left:' . $responsi_footer_content_margin_left . 'px !important;';
    $footer_content_css .= 'margin-right:' . $responsi_footer_content_margin_right . 'px !important;';

    $dynamic_css .= 'body #wrapper-footer #footer {' . $footer_content_css . ';}';
    
    /* Blog Items */
    $blog_box_bg                                    = isset($responsi_options['responsi_blog_box_bg']) ? $responsi_options['responsi_blog_box_bg'] : array('onoff' => 'true', 'color' => '#ffffff');    
    $blog_box_border                                = isset($responsi_options['responsi_blog_box_border']) ? $responsi_options['responsi_blog_box_border'] : array('width' => '1','style' => 'solid','color' => '#DBDBDB','corner' => 'square', 'topleft' => '0', 'topright' => '0', 'bottomright' => '0', 'bottomleft' => '0');
    $blog_box_shadow_option                         = isset($responsi_options['responsi_blog_box_shadow']) ? $responsi_options['responsi_blog_box_shadow'] : array( 'onoff' => 'true' , 'h_shadow' => '0px' , 'v_shadow' => '0px', 'blur' => '8px' , 'spread' => '0px', 'color' => '#DBDBDB', 'inset' => '' );
    $blog_box_shadow                                = responsi_generate_box_shadow($blog_box_shadow_option);
    $post_thumbnail_type                            = isset($responsi_options['responsi_post_thumbnail_type']) ? esc_attr( $responsi_options['responsi_post_thumbnail_type'] ) : 'top';
    $post_thumbnail_type_wide                       = isset($responsi_options['responsi_post_thumbnail_type_wide']) ? esc_attr( $responsi_options['responsi_post_thumbnail_type_wide'] ) : 50;
    $_post_author_archive_border_top                = isset($responsi_options['responsi_post_author_archive_border_top']) ? $responsi_options['responsi_post_author_archive_border_top'] : array('width' => '1','style' => 'solid','color' => '#DBDBDB');
    $_post_author_archive_border_bottom             = isset($responsi_options['responsi_post_author_archive_border_bottom']) ? $responsi_options['responsi_post_author_archive_border_bottom'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $_post_tags_comment_border_top                  = isset($responsi_options['responsi_post_tags_comment_border_top']) ? $responsi_options['responsi_post_tags_comment_border_top'] : array('width' => '1','style' => 'solid','color' => '#DBDBDB');
    $_post_tags_comment_border_bottom               = isset($responsi_options['responsi_post_tags_comment_border_bottom']) ? $responsi_options['responsi_post_tags_comment_border_bottom'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB');
    $blogext_padding_top                            = isset($responsi_options['responsi_blogext_padding_top']) ? esc_attr( $responsi_options['responsi_blogext_padding_top'] ) : '0'; 
    $blogext_padding_bottom                         = isset($responsi_options['responsi_blogext_padding_bottom']) ? esc_attr( $responsi_options['responsi_blogext_padding_bottom'] ) : '0';
    $blogext_padding_left                           = isset($responsi_options['responsi_blogext_padding_left']) ? esc_attr( $responsi_options['responsi_blogext_padding_left'] ) : '0';
    $blogext_padding_right                          = isset($responsi_options['responsi_blogext_padding_right']) ? esc_attr( $responsi_options['responsi_blogext_padding_right'] ) : '0';
    $_blog_post_thumbnail_margin_top                = isset($responsi_options['responsi_blog_post_thumbnail_margin_top']) ? esc_attr( $responsi_options['responsi_blog_post_thumbnail_margin_top'] ) : '0'; 
    $_blog_post_thumbnail_margin_bottom             = isset($responsi_options['responsi_blog_post_thumbnail_margin_bottom']) ? esc_attr( $responsi_options['responsi_blog_post_thumbnail_margin_bottom'] ) : '0';
    $_blog_post_thumbnail_margin_left               = isset($responsi_options['responsi_blog_post_thumbnail_margin_left']) ? esc_attr( $responsi_options['responsi_blog_post_thumbnail_margin_left'] ) : '0';
    $_blog_post_thumbnail_margin_right              = isset($responsi_options['responsi_blog_post_thumbnail_margin_right']) ? esc_attr( $responsi_options['responsi_blog_post_thumbnail_margin_right'] ) : '0';
    $_blog_post_thumbnail_padding_top               = isset($responsi_options['responsi_blog_post_thumbnail_padding_top']) ? esc_attr( $responsi_options['responsi_blog_post_thumbnail_padding_top'] ) : '0';
    $_blog_post_thumbnail_padding_bottom            = isset($responsi_options['responsi_blog_post_thumbnail_padding_bottom']) ? esc_attr( $responsi_options['responsi_blog_post_thumbnail_padding_bottom'] ) : '0';
    $_blog_post_thumbnail_padding_left              = isset($responsi_options['responsi_blog_post_thumbnail_padding_left']) ? esc_attr( $responsi_options['responsi_blog_post_thumbnail_padding_left'] ) : '0';
    $_blog_post_thumbnail_padding_right             = isset($responsi_options['responsi_blog_post_thumbnail_padding_right']) ? esc_attr( $responsi_options['responsi_blog_post_thumbnail_padding_right'] ) : '0';
    $_blog_post_thumbnail_bg                        = isset($responsi_options['responsi_blog_post_thumbnail_bg']) ? $responsi_options['responsi_blog_post_thumbnail_bg'] : array('onoff' => 'true', 'color' => '#ffffff');
    $_blog_post_thumbnail_border                    = isset($responsi_options['responsi_blog_post_thumbnail_border']) ? $responsi_options['responsi_blog_post_thumbnail_border'] : array('width' => '0','style' => 'solid','color' => '#DBDBDB','corner' => 'square', 'topleft' => '0', 'topright' => '0', 'bottomright' => '0', 'bottomleft' => '0');
    $_blog_post_thumbnail_shadow                    = isset($responsi_options['responsi_blog_post_thumbnail_shadow']) ? $responsi_options['responsi_blog_post_thumbnail_shadow'] : array( 'onoff' => 'false' , 'h_shadow' => '0px' , 'v_shadow' => '0px', 'blur' => '8px' , 'spread' => '0px', 'color' => '#DBDBDB', 'inset' => 'inset' );
    $responsi_blog_post_title_padding_top           = isset($responsi_options['responsi_blog_post_title_padding_top']) ? esc_attr( $responsi_options['responsi_blog_post_title_padding_top'] ) : '0';
    $responsi_blog_post_title_padding_bottom        = isset($responsi_options['responsi_blog_post_title_padding_bottom']) ? esc_attr( $responsi_options['responsi_blog_post_title_padding_bottom'] ) : '0';
    $responsi_blog_post_title_padding_left          = isset($responsi_options['responsi_blog_post_title_padding_left']) ? esc_attr( $responsi_options['responsi_blog_post_title_padding_left'] ) : '0';
    $responsi_blog_post_title_padding_right         = isset($responsi_options['responsi_blog_post_title_padding_right']) ? esc_attr( $responsi_options['responsi_blog_post_title_padding_right'] ) : '0';
    $responsi_blog_post_description_padding_top     = isset($responsi_options['responsi_blog_post_description_padding_top']) ? esc_attr( $responsi_options['responsi_blog_post_description_padding_top'] ) : '0';
    $responsi_blog_post_description_padding_bottom  = isset($responsi_options['responsi_blog_post_description_padding_bottom']) ? esc_attr( $responsi_options['responsi_blog_post_description_padding_bottom'] ) : '0';
    $responsi_blog_post_description_padding_left    = isset($responsi_options['responsi_blog_post_description_padding_left']) ? esc_attr( $responsi_options['responsi_blog_post_description_padding_left'] ) : '0';
    $responsi_blog_post_description_padding_right   = isset($responsi_options['responsi_blog_post_description_padding_right']) ? esc_attr( $responsi_options['responsi_blog_post_description_padding_right'] ) : '0';
    $responsi_blog_post_font_title                  = isset($responsi_options['responsi_blog_post_font_title']) ? $responsi_options['responsi_blog_post_font_title'] : array('size' => '22','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#8cc700');
    $responsi_blog_post_title_alignment             = isset($responsi_options['responsi_blog_post_title_alignment']) ? esc_attr( $responsi_options['responsi_blog_post_title_alignment'] ) : 'left';
    $responsi_blog_post_font_content                = isset($responsi_options['responsi_blog_post_font_content']) ? $responsi_options['responsi_blog_post_font_content'] : array('size' => '14','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#555555');
    $responsi_blog_ext_font                         = isset($responsi_options['responsi_blog_ext_font']) ? $responsi_options['responsi_blog_ext_font'] : array('size' => '12','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#555555');
    $enable_fix_tall_title_grid                     = isset($responsi_options['responsi_enable_fix_tall_title_grid']) ? esc_attr( $responsi_options['responsi_enable_fix_tall_title_grid'] ) : '2';
    $enable_fix_tall_des_grid                       = isset($responsi_options['responsi_enable_fix_tall_des_grid']) ? esc_attr( $responsi_options['responsi_enable_fix_tall_des_grid'] ) : '3';
    $responsi_blog_post_date_padding_top            = isset($responsi_options['responsi_blog_post_date_padding_top']) ? esc_attr( $responsi_options['responsi_blog_post_date_padding_top'] ) : '0';
    $responsi_blog_post_date_padding_bottom         = isset($responsi_options['responsi_blog_post_date_padding_bottom']) ? esc_attr( $responsi_options['responsi_blog_post_date_padding_bottom'] ) : '0';
    $responsi_blog_post_date_padding_left           = isset($responsi_options['responsi_blog_post_date_padding_left']) ? esc_attr( $responsi_options['responsi_blog_post_date_padding_left'] ) : '0';
    $responsi_blog_post_date_padding_right          = isset($responsi_options['responsi_blog_post_date_padding_right']) ? esc_attr( $responsi_options['responsi_blog_post_date_padding_right'] ) : '0';
    $responsi_blog_post_font_date                   = isset($responsi_options['responsi_blog_post_font_date']) ? $responsi_options['responsi_blog_post_font_date'] : array('size' => '12','line_height' => '1.5','face' => 'Open Sans','style' => 'normal','color' => '#555555');
    $responsi_blog_post_font_date_transform         = isset($responsi_options['responsi_blog_post_font_date_transform']) ? esc_attr( $responsi_options['responsi_blog_post_font_date_transform'] ) : 'none';
    $responsi_blog_post_date_alignment              = isset($responsi_options['responsi_blog_post_date_alignment']) ? esc_attr( $responsi_options['responsi_blog_post_date_alignment'] ) : 'left';
    $responsi_blog_post_date_icon                   = isset($responsi_options['responsi_blog_post_date_icon']) ? esc_attr( $responsi_options['responsi_blog_post_date_icon'] ) : '#555555';
    $responsi_enable_blog_post_date_icon            = isset($responsi_options['responsi_enable_blog_post_date_icon']) ? esc_attr( $responsi_options['responsi_enable_blog_post_date_icon'] ) : 'true';
    $disable_ext_cat_author                         = isset($responsi_options['responsi_disable_ext_cat_author']) ? esc_attr( $responsi_options['responsi_disable_ext_cat_author'] ) : 'true';
    $disable_ext_tags_comment                       = isset($responsi_options['responsi_disable_ext_tags_comment']) ? esc_attr( $responsi_options['responsi_disable_ext_tags_comment'] ) : 'true';
    $disable_blog_content                           = isset($responsi_options['responsi_disable_blog_content']) ? esc_attr( $responsi_options['responsi_disable_blog_content'] ) : 'true';
    $responsi_blog_morelink_font                    = isset($responsi_options['responsi_blog_morelink_font']) ? $responsi_options['responsi_blog_morelink_font'] : array('size' => '12','line_height' => '1','face' => 'Open Sans','style' => 'bold','color' => '#ffffff');
    $responsi_blog_morelink_alignment               = isset($responsi_options['responsi_blog_morelink_alignment']) ? esc_attr( $responsi_options['responsi_blog_morelink_alignment'] ) : 'left';
    $responsi_enable_fix_ext_cat_author             = isset($responsi_options['responsi_enable_fix_ext_cat_author']) ? esc_attr( $responsi_options['responsi_enable_fix_ext_cat_author'] ) : '2';
    $responsi_enable_fix_ext_tags_comment           = isset($responsi_options['responsi_enable_fix_ext_tags_comment']) ? esc_attr( $responsi_options['responsi_enable_fix_ext_tags_comment'] ) : '3';
    $responsi_post_author_archive_icon              = isset($responsi_options['responsi_post_author_archive_icon']) ? esc_attr( $responsi_options['responsi_post_author_archive_icon'] ) : '#555555';
    $responsi_enable_post_author_archive_icon       = isset($responsi_options['responsi_enable_post_author_archive_icon']) ? esc_attr( $responsi_options['responsi_enable_post_author_archive_icon'] ) : 'true';
    $responsi_disable_ext_author_cell               = isset($responsi_options['responsi_disable_ext_author_cell']) ? esc_attr( $responsi_options['responsi_disable_ext_author_cell'] ) : 'true';
    $responsi_disable_ext_categories_cell           = isset($responsi_options['responsi_disable_ext_categories_cell']) ? esc_attr( $responsi_options['responsi_disable_ext_categories_cell'] ) : 'true';
    $responsi_disable_ext_comments_cell             = isset($responsi_options['responsi_disable_ext_comments_cell']) ? esc_attr( $responsi_options['responsi_disable_ext_comments_cell'] ) : 'true';
    $responsi_disable_ext_tags_cell                 = isset($responsi_options['responsi_disable_ext_tags_cell']) ? esc_attr( $responsi_options['responsi_disable_ext_tags_cell'] ) : 'true';
    $responsi_fixed_thumbnail                       = isset($responsi_options['responsi_fixed_thumbnail']) ? esc_attr( $responsi_options['responsi_fixed_thumbnail'] ) : 'true';
    $responsi_fixed_thumbnail_tall                  = isset($responsi_options['responsi_fixed_thumbnail_tall']) ? esc_attr( $responsi_options['responsi_fixed_thumbnail_tall'] ) : 63;
    $responsi_blog_post_content_alignment           = isset($responsi_options['responsi_blog_post_content_alignment']) ? esc_attr( $responsi_options['responsi_blog_post_content_alignment'] ) : 'left';
    $responsi_blog_ext_alignment                    = isset($responsi_options['responsi_blog_ext_alignment']) ? esc_attr( $responsi_options['responsi_blog_ext_alignment'] ) : 'left';
    $responsi_blog_post_font_title_transform        = isset($responsi_options['responsi_blog_post_font_title_transform']) ? esc_attr( $responsi_options['responsi_blog_post_font_title_transform'] ) : 'none';
    $blog_des_line_height                           = esc_attr( $responsi_blog_post_font_content['line_height'] );
    $blog_title_line_height                         = esc_attr( $responsi_blog_post_font_title['line_height'] );
    $blog_ext_line_height                           = esc_attr( $responsi_blog_ext_font['line_height'] );
    if ( $post_thumbnail_type_wide <= 0 || '' === $post_thumbnail_type_wide ){
        $post_thumbnail_type_wide = 50;
    }
    $grid_thumb_width                               = ( $post_thumbnail_type_wide - 0.5 );
    $grid_content_width                             = ( 100 - $post_thumbnail_type_wide ) - 0.5;
    
    $dynamic_css .= '.thumbnail_container {width:100%;clear:both;display: inline-block;}';
    if ( 'left' === $post_thumbnail_type ) {
        $dynamic_css .= '.blog-post-item .thumbnail_container{width:' . $grid_thumb_width . '%;float:left;}';
        $dynamic_css .= '.blog-post-item .content_container{width:' . $grid_content_width . '%;float:right;}';
    }
    if ( 'right' === $post_thumbnail_type ) {
        $dynamic_css .= '.blog-post-item .thumbnail_container{width:' . $grid_thumb_width . '%;float:right;}';
        $dynamic_css .= '.blog-post-item .content_container{width:' . $grid_content_width . '%;float:left;}';
    }
    $dynamic_css .= '.box-item .entry-item .entry-bottom .postinfo{' . responsi_generate_border($blog_box_border, 'border', true) . 'border-left:0px !important;border-right:0px !important;}';
    $dynamic_css .= '.box-item .entry-item.blog-post-item .entry-bottom{margin-top:0px;margin-bottom:0px !important;}';
    $dynamic_css .= '.box-item .entry-item.blog-post-item .entry-bottom .postinfo,.box-item .entry-item.blog-post-item .entry-bottom .posttags,.box-item .entry-item .entry-bottom .posttags, .box-item .entry-item .entry-bottom .postinfo{padding-left:' . $blogext_padding_left . 'px;padding-right:' . $blogext_padding_right . 'px;padding-top:' . $blogext_padding_top . 'px;padding-bottom:' . $blogext_padding_bottom . 'px; margin :0px !important; ' . responsi_generate_border($_post_author_archive_border_top, 'border-top', true) . ' ' . responsi_generate_border($_post_author_archive_border_bottom, 'border-bottom', true) . '}';
    $dynamic_css .= '.box-item .entry-item.blog-post-item .entry-bottom .posttags,.box-item .entry-item .entry-bottom .posttags, div.box-content .box-item div.entry-item .entry-bottom .posttags{' . responsi_generate_border($_post_tags_comment_border_top, 'border-top', true) . ' ' . responsi_generate_border($_post_tags_comment_border_bottom, 'border-bottom', true) . '}';
    $dynamic_css .= '.box-item .entry-item.group.post .thumbnail{height:auto !important;margin-bottom:' . $blogext_padding_bottom . 'px !important;}';
    $dynamic_css .= '.box-item .entry-item.group.post h3{height:auto !important;margin-bottom:0px !important;}';
    
    $blog_box_css = '';
    $blog_box_css .= 'padding:0px !important;';
    $blog_box_css .= responsi_generate_background_color($blog_box_bg, true);
    $blog_box_css .= responsi_generate_border_boxes($blog_box_border, true);
    $blog_box_css .= $blog_box_shadow;
    
    $dynamic_css .= '.box-item .entry-item.blog-post-item,.box-item .entry-item.blog-post-item,.box-item .entry-item{' . $blog_box_css . '}';

    $blog_thumbnail_css = 'float: none !important;text-align: center !important;width: auto !important;display:block !important;overflow: hidden;';
    $blog_thumbnail_css .= responsi_generate_background_color($_blog_post_thumbnail_bg, true);
    $blog_thumbnail_css .= responsi_generate_border_boxes($_blog_post_thumbnail_border);
    $blog_thumbnail_css .= responsi_generate_box_shadow($_blog_post_thumbnail_shadow);
    $blog_thumbnail_css .= 'margin-top:' . $_blog_post_thumbnail_margin_top . 'px !important;';
    $blog_thumbnail_css .= 'margin-bottom:' . $_blog_post_thumbnail_margin_bottom . 'px !important;';
    $blog_thumbnail_css .= 'margin-left:' . $_blog_post_thumbnail_margin_left . 'px !important;';
    $blog_thumbnail_css .= 'margin-right:' . $_blog_post_thumbnail_margin_right . 'px !important;';
    $blog_thumbnail_css .= 'padding-top:' . $_blog_post_thumbnail_padding_top . 'px !important;';
    $blog_thumbnail_css .= 'padding-bottom:' . $_blog_post_thumbnail_padding_bottom . 'px !important;';
    $blog_thumbnail_css .= 'padding-left:' . $_blog_post_thumbnail_padding_left . 'px !important;';
    $blog_thumbnail_css .= 'padding-right:' . $_blog_post_thumbnail_padding_right . 'px !important;';

    $dynamic_css .= '.box-item .entry-item.blog-post-item img.thumbnail{margin-bottom:0px !important;}';
    $dynamic_css .= '.box-item .entry-item.blog-post-item .thumbnail{' . $blog_thumbnail_css . '}';
    $dynamic_css .= '.box-item .entry-item.blog-post-item h3{margin:0;padding-top:' . $responsi_blog_post_title_padding_top . 'px !important;padding-bottom:' . $responsi_blog_post_title_padding_bottom . 'px !important;padding-left:' . $responsi_blog_post_title_padding_left . 'px !important;padding-right:' . $responsi_blog_post_title_padding_right . 'px !important;}';
    $dynamic_css .= '.box-item .entry-item.blog-post-item .entry-content{margin:0px;padding-top:' . $responsi_blog_post_description_padding_top . 'px !important;padding-bottom:' . $responsi_blog_post_description_padding_bottom . 'px !important;padding-left:' . $responsi_blog_post_description_padding_left . 'px !important;padding-right:' . $responsi_blog_post_description_padding_right . 'px !important;}';
    $dynamic_css .= 'body.category #main .box-item .entry-item h3 a,body.tag #main .box-item .entry-item h3 a,body.page-template-template-blog-php #main .box-item .entry-item h3 a, .box-item .entry-item h3 a, body.category #main .box-item .entry-item h3,body.tag #main .box-item .entry-item h3,body.page-template-template-blog-php #main .box-item .entry-item h3, .box-item .entry-item h3,body #main .blog-post .blog-post-item h3 a:link,#main .blog-post.box-item .entry-item h3 a:link, #main .blog-post.box-item .entry-item h3 a:visited{text-align:' . $responsi_blog_post_title_alignment . ';' . responsi_generate_fonts($responsi_blog_post_font_title) . '}';
    $dynamic_css .= 'body.category #main .box-item .entry-item h3 a:hover,body.tag #main .box-item .entry-item h3 a:hover,body.page-template-template-blog-php #main .box-item .entry-item h3 a:hover, .box-item .entry-item h3 a:hover,#main .blog-post.box-item .entry-item h3 a:link:hover, #main .blog-post.box-item .entry-item h3 a:visited:hover{ color:' . $hover . ' !important;}';
    $dynamic_css .= 'body.category #main .box-item .entry-item .entry-content p,body.tag #main .box-item .entry-item .entry-content p,body.page-template-template-blog-php #main .box-item .entry-item .entry-content p, .box-item .entry-item .entry-content p{text-align:' . $responsi_blog_post_content_alignment . ';' . responsi_generate_fonts($responsi_blog_post_font_content) . '}';
    $dynamic_css .= 'body.category #main .box-item .entry-item .entry-bottom,body.tag #main .box-item .entry-item .entry-bottom,body.page-template-template-blog-php #main .box-item .entry-item .entry-bottom, .box-item .entry-item .entry-bottom{text-align:' . $responsi_blog_ext_alignment . ';' . responsi_generate_fonts($responsi_blog_ext_font) . '}';
    $dynamic_css .= '@media only screen and (min-width: 480px) {';
    if ( $enable_fix_tall_title_grid == '1' ) {
        $blog_title_height = floatval($blog_title_line_height) + 0.1;
        $dynamic_css .= '.box-item .entry-item h3 a{display:block !important;height: ' . $blog_title_height . 'em !important;overflow: hidden !important;line-height:' . floatval($blog_title_line_height) . 'em !important;}';
    } elseif ( $enable_fix_tall_title_grid == '2' ) {
        $blog_title_height = (floatval($blog_title_line_height) * 2) + 0.1;
        $dynamic_css .= '.box-item .entry-item h3 a{display:block !important;height: ' . $blog_title_height . 'em !important;overflow: hidden !important;line-height:' . floatval($blog_title_line_height) . 'em !important;}';
    } elseif ( $enable_fix_tall_title_grid == '3' ) {
        $blog_title_height = (floatval($blog_title_line_height) * 3) + 0.1;
        $dynamic_css .= '.box-item .entry-item h3 a{display:block !important;height: ' . $blog_title_height . 'em !important;overflow: hidden !important;line-height:' . floatval($blog_title_line_height) . 'em !important;}';
    } else {
        $dynamic_css .= '.box-item .entry-item h3 a{display:inherit !important;height: inherit !important;overflow: inherit !important;line-height:' . floatval($blog_title_line_height) . ' !important;}';
    }
    $dynamic_css .= '}';
    $dynamic_css .= '.box-item .entry-item p.gird_descriptions{margin-bottom:0em !important;}';
    $dynamic_css .= '.box-item .entry-item a.more-link,body #main .box-item .entry-item.blog-post-item a.button{margin-top:5px !important;display:inline-block}';
    
    if ( $enable_fix_tall_des_grid == '1' ) {
        $blog_des_height = floatval($blog_des_line_height);
        $dynamic_css .= '.box-item .entry-item p.gird_descriptions{display:block !important;height: ' . $blog_des_height . 'em !important;overflow: hidden !important;line-height:' . $blog_des_line_height . 'em !important;}';
    } elseif ( $enable_fix_tall_des_grid == '2' ) {
        $blog_des_height = floatval($blog_des_line_height) * 2;
        $dynamic_css .= '.box-item .entry-item p.gird_descriptions{display:block !important;height: ' . $blog_des_height . 'em !important;overflow: hidden !important;line-height:' . $blog_des_line_height . 'em !important;}';
    } elseif ( $enable_fix_tall_des_grid == '3' ) {
        $blog_des_height = floatval($blog_des_line_height) * 3;
        $dynamic_css .= '.box-item .entry-item p.gird_descriptions{display:block !important;height: ' . $blog_des_height . 'em !important;overflow: hidden !important;line-height:' . $blog_des_line_height . 'em !important;}';
    } elseif ( $enable_fix_tall_des_grid == '4' ) {
        $blog_des_height = floatval($blog_des_line_height) * 4;
        $dynamic_css .= '.box-item .entry-item p.gird_descriptions{display:block !important;height: ' . $blog_des_height . 'em !important;overflow: hidden !important;line-height:' . $blog_des_line_height . 'em !important;}';
    }
    $dynamic_css .= '.box-item .entry-item h3 a,.box-item .entry-item h3{text-transform:' . $responsi_blog_post_font_title_transform . '}';
        
    if ( 'true' === $responsi_fixed_thumbnail && $responsi_fixed_thumbnail_tall > 0 ) {
        $dynamic_css .= '.box-item .entry-item .thumbnail > a {display: block !important;max-width: 100% !important;overflow: hidden !important;text-align: center !important;vertical-align: top !important;width: 100% !important;padding:0 !important;margin:0 !important;height: inherit;}';
        $dynamic_css .= '.box-item.masonry-brick .entry-item .thumbnail a img {height: 100% !important;max-width: 100% !important;max-height: 100% !important;width:auto !important;}';
        $dynamic_css .= '.box-item.masonry-brick .entry-item .thumbnail a img:not(.lazy-hidden){height:auto !important;}';
    } else {
        $dynamic_css .= '.box-item .entry-item .thumbnail img:not(.lazy-hidden){height:auto;max-width: 100% !important;max-height: 100% !important;}';
    }
    $dynamic_css .= '.box-item .entry-item .postinfotitle{display:none !important;}';
    $dynamic_css .= '.box-item .entry-item .blogpostinfo{padding-top:' . $responsi_blog_post_date_padding_top . 'px;padding-bottom:' . $responsi_blog_post_date_padding_bottom . 'px;padding-left:' . $responsi_blog_post_date_padding_left . 'px;padding-right:' . $responsi_blog_post_date_padding_right . 'px;text-align:' . $responsi_blog_post_date_alignment . ';text-transform:' . $responsi_blog_post_font_date_transform . ';' . responsi_generate_fonts($responsi_blog_post_font_date) . '}';
    $dynamic_css .= '.box-item .entry-item .blogpostinfo .i_date:before{color:' . $responsi_blog_post_date_icon . ';position: relative;font-size: 90%;}';
    if ( 'true' !== $responsi_enable_blog_post_date_icon ) {
        $dynamic_css .= '.box-item .entry-item .blogpostinfo .i_date:before{display:none !important;}';
    }
    $dynamic_css .= '.box-item .entry-item .entry-content .bottom-bg{margin-bottom:0px;}.entry p.gird_descriptions{margin-bottom:10px;}';
    $dynamic_css .= '.show-more-link{display:block;box-sizing:border-box;text-align:' . $responsi_blog_morelink_alignment . ';}';
    $dynamic_css .= 'div.box-content .box-item div.entry-item .entry-content a.more-link,body #wrapper #content div.box-content .box-item div.entry-item .entry-content a.button{' . responsi_generate_fonts($responsi_blog_morelink_font, false) . '}';
    if ( !isset( $disable_blog_content ) ||  'false' === $disable_blog_content || '' === $disable_blog_content ) {
        $dynamic_css .= 'div.box-content .box-item div.entry-item.blog-post-item .entry-content .gird_descriptions{display:none !important;}';
    }
    if( 'false' === $disable_blog_content && isset( $responsi_options['responsi_disable_blog_morelink'] ) && 'false' === $responsi_options['responsi_disable_blog_morelink'] ){
        $dynamic_css .= 'div.box-content .box-item div.entry-item.blog-post-item .entry-content{display:none;}';
    }
    if ( 'false' === $disable_ext_cat_author ) {
        $dynamic_css .= 'div.box-content .box-item div.entry-item .entry-bottom .postinfo{display:none;}';
    }
    if ('false' === $disable_ext_tags_comment ) {
        $dynamic_css .= 'div.box-content .box-item div.entry-item .entry-bottom .posttags{display:none;} div.box-content .box-item div.entry-item .entry-bottom .postinfo{border-bottom:none !important;}';
    }
    
    if ( $responsi_enable_fix_ext_cat_author == '1' ) {
        $blog_ext_height = floatval($blog_ext_line_height);
        $dynamic_css .= '.box-item .entry-item .entry-bottom .postinfo .custom_lines{display:block !important;height: ' . $blog_ext_height . 'em !important;overflow: hidden !important;line-height:' . $blog_ext_line_height . 'em !important;}';
    } elseif ( $responsi_enable_fix_ext_cat_author == '2' ) {
        $blog_ext_height = floatval($blog_ext_line_height) * 2;
        $dynamic_css .= '.box-item .entry-item .entry-bottom .postinfo .custom_lines{display:block !important;height: ' . $blog_ext_height . 'em !important;overflow: hidden !important;line-height:' . $blog_ext_line_height . 'em !important;}';
    } elseif ( $responsi_enable_fix_ext_cat_author == '3' ) {
        $blog_ext_height = floatval($blog_ext_line_height) * 3;
        $dynamic_css .= '.box-item .entry-item .entry-bottom .postinfo .custom_lines{display:block !important;height: ' . $blog_ext_height . 'em !important;overflow: hidden !important;line-height:' . $blog_ext_line_height . 'em !important;}';
    } else {
        $dynamic_css .= '.box-item .entry-item .entry-bottom .postinfo .custom_lines{display:inherit !important;height: auto !important;overflow: hidden !important;line-height:' . $blog_ext_line_height . ' !important;}';
    }
    
    if ( $responsi_enable_fix_ext_tags_comment == '1' ) {
        $blog_ext_height = floatval($blog_ext_line_height);
        $dynamic_css .= '.box-item .entry-item .entry-bottom .posttags .custom_lines{display:block !important;height: ' . $blog_ext_height . 'em !important;overflow: hidden !important;line-height:' . $blog_ext_line_height . 'em !important;}';
    } elseif ( $responsi_enable_fix_ext_tags_comment == '2' ) {
        $blog_ext_height = floatval($blog_ext_line_height) * 2;
        $dynamic_css .= '.box-item .entry-item .entry-bottom .posttags .custom_lines{display:block !important;height: ' . $blog_ext_height . 'em !important;overflow: hidden !important;line-height:' . $blog_ext_line_height . 'em !important;}';
    } elseif ( $responsi_enable_fix_ext_tags_comment == '3' ) {
        $blog_ext_height = floatval($blog_ext_line_height) * 3;
        $dynamic_css .= '.box-item .entry-item .entry-bottom .posttags .custom_lines{display:block !important;height: ' . $blog_ext_height . 'em !important;overflow: hidden !important;line-height:' . $blog_ext_line_height . 'em !important;}';
    } else {
        $dynamic_css .= '.box-item .entry-item .entry-bottom .posttags .custom_lines{display:inherit !important;height: auto !important;overflow: hidden !important;line-height:' . $blog_ext_line_height . ' !important;}';
    }
    
    if ( 'false' === $responsi_disable_ext_author_cell ) {
        $dynamic_css .= ".entry-bottom .i_author,.entry-bottom .i_in{display:none}";
    }
    if ( 'false' === $responsi_disable_ext_categories_cell ) {
        $dynamic_css .= ".entry-bottom .i_cat,.entry-bottom .i_in{display:none}";
    }
    
    if ( 'false' === $responsi_disable_ext_author_cell && 'false' === $responsi_disable_ext_categories_cell ) {
        $dynamic_css .= 'div.box-content .box-item div.entry-item .entry-bottom .postinfo{display:none;}';
        $dynamic_css .= 'div.box-content .box-item div.entry-item.sticky_product .entry-bottom .postinfo{display:block;}';
    }
    
    if ( 'false' === $responsi_disable_ext_comments_cell ) {
        $dynamic_css .= ".entry-bottom .i_comment{display:none}";
    }
    if ( 'false' ===  $responsi_disable_ext_tags_cell ) {
        $dynamic_css .= ".entry-bottom .i_tag{display:none}";
    }
    
    if ( 'false' === $responsi_disable_ext_comments_cell&& 'false' === $responsi_disable_ext_tags_cell ) {
        $dynamic_css .= 'div.box-content .box-item div.entry-item .entry-bottom .posttags{display:none;} div.box-content .box-item div.entry-item .entry-bottom .postinfo{border-bottom:none !important;}';
    }
    
    if ( $responsi_post_author_archive_icon ) {
        $dynamic_css .= 'body .logout-link:after, body .profile-link:after, body .dashboard-link:after, body .lost_password-link:after, body .register-link:after{color:' . $responsi_post_author_archive_icon . ' !important;}';
        $dynamic_css .= 'span.i_tag_text, span.i_author, span.i_in,span.i_date.updated,.comment-head span.name,.comment-head span.date, .comment-head .perma{margin-right:3px !important;}';
        $dynamic_css .= '.i_author:before,.i_cat:before,.i_comment:before,.i_tag:before,.i_authors span.author .fn:before, .i_date:before {margin-right:3px;position:relative;color:' . $responsi_post_author_archive_icon . ';}';
        $dynamic_css .= '.custom_lines .i_comment{margin-right:3px;}';
        $dynamic_css .= '.post p.tags:hover:before,.post p.tags:before,.icon:before, .icon:after {color:' . $responsi_post_author_archive_icon . ';}';
    }

    if ( 'true' !== $responsi_enable_post_author_archive_icon ) {
        $dynamic_css .= '.box-item .entry-bottom .i_author:before, .box-item .entry-bottom .i_cat:before, .box-item .entry-bottom .i_comment:before, .box-item .entry-bottom .i_tag:before{display:none !important;}';
    }

    $dynamic_css_ext = '';
    
    $dynamic_css_ext = @apply_filters( 'responsi_build_dynamic_css', $dynamic_css_ext );
    
    if ( '' !== $dynamic_css_ext){
        $dynamic_css .= $dynamic_css_ext;
    }

    if( function_exists('responsi_minify_css') ){
        $dynamic_css = responsi_minify_css( $dynamic_css );
    }
    
    return $dynamic_css;
}

function responsi_framework_upgrade(){

    global $responsi_options;

    $upgrade = get_option('upgrade_responsi_693_to_694' );
    
    if( $upgrade != 'done' ){
       
        $theme_mods = get_theme_mods();

        $list_options = array( 
            'responsi_widget_border'                    => 'responsi_widget_border_radius',
            'responsi_page_box_border'                  => 'responsi_page_box_border_radius',
            'responsi_archive_box_border'               => 'responsi_archive_box_border_radius',
            'responsi_post_box_border'                  => 'responsi_post_box_border_radius',
            'responsi_blog_box_border'                  => 'responsi_blog_box_border_radius',
            'responsi_archive_title_box_border'         => 'responsi_archive_title_box_border_radius',
            'responsi_blog_post_thumbnail_border'       =>  array(
                                                            'responsi_blog_post_thumbnail_border_radius_tl',
                                                            'responsi_blog_post_thumbnail_border_radius_tr',
                                                            'responsi_blog_post_thumbnail_border_radius_br',
                                                            'responsi_blog_post_thumbnail_border_radius_bl'
                                                        ),
            'responsi_footer_widget_border'             => 'responsi_footer_widget_border_radius',
            'responsi_top_widget_area_container_border' => 'responsi_top_widget_area_container_border_corner'

        );

        foreach ( $list_options as $border => $corner ) {
            
            if( !is_array( $corner ) ){

                $corners = array();

                if ( isset( $theme_mods[ $corner ] ) && isset( $theme_mods[ $border ] ) ){
                
                    if( isset( $theme_mods[ $corner ]['corner'] ) && $theme_mods[ $corner ]['corner'] == 'rounded' && isset( $theme_mods[ $corner ]['rounded_value'] ) ){
                        $corners = array( 'corner' => 'rounded', 'topleft' => $theme_mods[ $corner ]['rounded_value'], 'topright' => $theme_mods[ $corner ]['rounded_value'], 'bottomright' => $theme_mods[ $corner ]['rounded_value'], 'bottomleft' => $theme_mods[ $corner ]['rounded_value'] );
                        $theme_mods[$border] = array_merge( $theme_mods[ $border ], $corners );
                        set_theme_mod( $border,  $theme_mods[$border] );
                    }
                    
                    remove_theme_mod( $corner );
                
                }elseif ( isset( $theme_mods[ $corner ] ) && !isset( $theme_mods[ $border ] ) ){

                    if( isset( $theme_mods[ $corner ]['corner'] ) && $theme_mods[ $corner ]['corner'] == 'rounded' && isset( $theme_mods[ $corner ]['rounded_value'] ) ){
                        $corners = array( 'corner' => 'rounded', 'topleft' => $theme_mods[ $corner ]['rounded_value'], 'topright' => $theme_mods[ $corner ]['rounded_value'], 'bottomright' => $theme_mods[ $corner ]['rounded_value'], 'bottomleft' => $theme_mods[ $corner ]['rounded_value'] );
                        set_theme_mod( $border,  $corners );
                    }

                    remove_theme_mod( $corner );

                }
                
            }  

            if( is_array( $corner ) ){

                $corners = array();

                foreach ( $corner as $c ) {

                    if ( isset( $theme_mods[ $c ] ) && isset( $theme_mods[ $border ] ) ){

                        if( isset( $theme_mods[ $c ]['corner'] ) && $theme_mods[ $c ]['corner'] == 'rounded' && isset( $theme_mods[ $c ]['rounded_value'] ) ){
                            
                            $corners['corner'] = 'rounded';

                            if( $c == 'responsi_blog_post_thumbnail_border_radius_tl' ){
                                $corners['topleft'] = $theme_mods[ $c ]['rounded_value'];
                            }
                            if( $c == 'responsi_blog_post_thumbnail_border_radius_tr' ){
                                $corners['topright'] = $theme_mods[ $c ]['rounded_value'];
                            }
                            if( $c == 'responsi_blog_post_thumbnail_border_radius_br' ){
                                $corners['bottomright'] =  $theme_mods[ $c ]['rounded_value'];
                            }
                            if( $c == 'responsi_blog_post_thumbnail_border_radius_bl' ){
                                $corners['bottomleft'] =  $theme_mods[ $c ]['rounded_value'];
                            }

                            $theme_mods[$border] = array_merge( $theme_mods[ $border ], $corners );
                            set_theme_mod( $border,  $theme_mods[$border] );
                        }

                        remove_theme_mod( $c );
                    
                    }elseif ( isset( $theme_mods[ $c ] ) && !isset( $theme_mods[ $border ] ) ){

                        if( isset( $theme_mods[ $c ]['corner'] ) && $theme_mods[ $c ]['corner'] == 'rounded' && isset( $theme_mods[ $c ]['rounded_value'] ) ){
                            
                            $corners['corner'] = 'rounded';

                            if( $c == 'responsi_blog_post_thumbnail_border_radius_tl' ){
                                $corners['topleft'] = $theme_mods[ $c ]['rounded_value'];
                            }
                            if( $c == 'responsi_blog_post_thumbnail_border_radius_tr' ){
                                $corners['topright'] = $theme_mods[ $c ]['rounded_value'];
                            }
                            if( $c == 'responsi_blog_post_thumbnail_border_radius_br' ){
                                $corners['bottomright'] =  $theme_mods[ $c ]['rounded_value'];
                            }
                            if( $c == 'responsi_blog_post_thumbnail_border_radius_bl' ){
                                $corners['bottomleft'] =  $theme_mods[ $c ]['rounded_value'];
                            }

                            $theme_mods[$border] = $corners ;

                            set_theme_mod( $border,  $theme_mods[$border] );
                        }

                        remove_theme_mod( $c );

                    }

                }
            }  
            
        }

        $upgrade = update_option('upgrade_responsi_693_to_694', 'done' );
    }

}

?>