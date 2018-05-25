<?php
/*-----------------------------------------------------------------------------------*/
/* responsi_layout_class(). */
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'responsi_layout_class' ) ) {
    function responsi_layout_class() {
        global 
        $post, 
        $responsi_options, 
        $responsi_layout_boxed, 
        $responsi_header_is_inside, 
        $responsi_header_is_outside, 
        $responsi_footer_is_outside,
        $layout,  
        $layout_column, 
        $layout_column_top,  
        $layout_top, 
        $content_column, 
        $content_column_grid, 
        $main_box, 
        $sidebar_box, 
        $sidebar_alt_box,
        $wrapper_content, 
        $wrapper_content_top;
    
        if( !is_array( $responsi_options ) ) return;

        $responsi_layout_boxed       = $responsi_options['responsi_layout_boxed'];
        $responsi_header_is_inside   = false;
        $responsi_header_is_outside  = false;
        $responsi_footer_is_outside  = false;

        if ( 'true' === $responsi_layout_boxed ) {
            if ( 'true' === $responsi_options['responsi_header_outside_boxed'] && 'true' === $responsi_options['responsi_fixed_header'] ) {
                $responsi_header_is_inside  = true;
            } elseif ( 'true' === $responsi_options['responsi_header_outside_boxed'] && 'true' !== $responsi_options['responsi_fixed_header'] ) {
                $responsi_header_is_inside  = false;
                $responsi_header_is_outside = true;
            }
            if ( 'true' === $responsi_options['responsi_footer_outside_boxed'] ) {
                $responsi_footer_is_outside = true;
            } else {
                $responsi_footer_is_outside = false;
            }
        } elseif ( 'true' !== $responsi_layout_boxed ) {
            if ( 'true' === $responsi_options['responsi_fixed_header_stretched'] ) {
                $responsi_header_is_inside = true;
            }
            $responsi_footer_is_outside = false;
        }

        $layout = '';

        // Set main layout
        if ( is_singular() ) {
            $layout = get_post_meta( $post->ID, 'layout', true );
            if ( '' !== $layout ) {
                $responsi_options['responsi_layout'] = $layout;
            }
        }

        // Add support for Woocommerce "Shop" landing page body CSS class
        if ( class_exists('woocommerce') && function_exists('is_shop') && '' === $layout && is_shop()) {
            $page_id = get_option( 'woocommerce_shop_page_id' );
            $layout  = get_post_meta( $page_id, 'layout', true );
            if ( '' !== $layout ) {
                $responsi_options['responsi_layout'] = $layout;
            }
        }

        if ( '' === $layout ) {
            if ( isset( $responsi_options['responsi_layout'] ) ) {
                $layout = $responsi_options['responsi_layout'];
            } 
            if ( '' === $layout ){
                $layout = "two-col-left";
            }
        }

        $wrapper_content = 'full';
        $layout_column   = '_1';
        $page_id         = 0;

        if ( is_post_type_archive( 'product' ) ) {
            if ( function_exists( 'wc_get_page_id' ) ) {
                $page_id = wc_get_page_id( 'shop' );
            }
        } else {
            if ( !is_home() ) {
                if ( $post ) {
                    $page_id = $post->ID;
                } else {
                    $page_id = 0;
                }
            } else {
                $page_id = 0;
            }
        }

        if ( is_archive() || is_category() || is_tag() ) {
            if ( is_post_type_archive( 'product' ) ) {
                $content_column      = get_post_meta( $page_id, 'content_layout', true );
                $content_column_grid = get_post_meta( $page_id, 'content_column_grid', true );
            } else {
                $content_column = $responsi_options['responsi_content_layout'];
                if ( !isset( $responsi_options['responsi_content_column_grid'] ) ) {
                    $content_column_grid = $content_column;
                    set_theme_mod( 'responsi_content_column_grid', $content_column );
                } else {
                    $content_column_grid = $responsi_options['responsi_content_column_grid'];
                }
            }

        } else {

            $content_column = get_post_meta( $page_id, 'content_layout', true );

            if ( $content_column <= 0 || '' === $content_column ) {
                $content_column = $responsi_options['responsi_content_layout'];
            }
            if ( $content_column <= 0 ) {
                $content_column = 3;
            }

            $content_column_grid = get_post_meta( $page_id, 'content_column_grid', true );

            if ( $content_column_grid <= 0 || '' === $content_column_grid )
                $content_column_grid = $responsi_options['responsi_content_column_grid'];

            elseif ( $content_column_grid <= 0 || '' === $content_column_grid ) {
                $content_column_grid = $content_column;
            }
            if ( $content_column_grid <= 0 ) {
                $content_column_grid = 3;
            }
        }

        if ( $content_column <= 0 ) {
            $content_column = $responsi_options['responsi_content_layout'];
        }

        if ( $content_column_grid <= 0 ) {
            $content_column_grid = $responsi_options['responsi_content_column_grid'];
        }

        if ($content_column_grid <= 0 || '' === $content_column_grid )
            $content_column_grid = 3;

        apply_filters( 'responsi_layouts', $content_column_grid, $wrapper_content_top, $wrapper_content, $layout_column, $content_column, $layout_column_top, $layout_top, $layout );

        if ( 'one-col' === $layout ) {
            $wrapper_content    = 'full';
            $layout_column      = '1';
            $sidebar_box        = '';
            $main_box           = ' box-last';
            $sidebar_alt_box    = '';
        }
        if ( 'two-col-left' === $layout ) {
            $wrapper_content    = $content_column + 1;
            $layout_column      = '2';
            $sidebar_box        = ' box-last';
            $main_box           = '';
            $sidebar_alt_box    = '';
        }
        if ( 'two-col-right' === $layout ) {
            $wrapper_content    = $content_column + 1;
            $layout_column      = '2';
            $sidebar_box        = '';
            $main_box           = ' box-last';
            $sidebar_alt_box    = '';
        }
        if ( 'three-col-left' === $layout ) {
            $wrapper_content    = $content_column + 2;
            $layout_column      = '3';
            $sidebar_box        = '';
            $main_box           = '';
            $sidebar_alt_box    = ' box-last';
        }
        if ( 'three-col-middle' === $layout ) {
            $wrapper_content    = $content_column + 2;
            $layout_column      = '3';
            $sidebar_box        = '';
            $main_box           = '';
            $sidebar_alt_box    = ' box-last';
        }
        if ( 'three-col-right' === $layout ) {
            $wrapper_content    = $content_column + 2;
            $layout_column      = '3';
            $sidebar_box        = '';
            $main_box           = ' box-last';
            $sidebar_alt_box    = '';
        }
    }
}

/*-----------------------------------------------------------------------------------*/
/* responsi_body_class() */
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'responsi_body_class' ) ) {
    function responsi_body_class( $classes ) {
        global $responsi_options, $post, $wp_query, $wp_version, $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

        $layout = '';
        // Set main layout
        if ( is_singular() ) {
            $layout = get_post_meta( $post->ID, 'layout', true );
            if ( '' !== $layout ) {
                $responsi_options['responsi_layout'] = $layout;
            }
        }

        // Add support for Woocommerce "Shop" landing page body CSS class
        if ( class_exists( 'woocommerce' ) && function_exists( 'is_shop' ) && '' === $layout && is_shop() ) {
            $page_id = get_option( 'woocommerce_shop_page_id' );
            $layout  = get_post_meta( $page_id, 'layout', true );
            if ( '' !== $layout ) {
                $responsi_options['responsi_layout'] = $layout;
            }
        }

        if ( '' === $layout ) {
            $layout = get_option( 'responsi_layout' );
            if ( '' === $layout )
                $layout = 'two-col-left';
        }

        $width = intval( str_replace('px', '', $responsi_options['responsi_layout_width'] ) );

        $width = apply_filters( 'responsi_layout_width', $width );

        // Add classes to body_class() output
        $classes[] = $layout;
        $classes[] = 'width-' . $width;
        $classes[] = $layout . '-' . $width;
        if ( isset( $responsi_options['responsi_enable_header_widget'] ) && 'true' === $responsi_options['responsi_enable_header_widget'] && $responsi_options['responsi_header_sidebars'] > 0) {
            if ( 'false' === $responsi_options['responsi_on_header_1'] )
                $classes[] = 'mobile-header-1';
            if ( 'false' === $responsi_options['responsi_on_header_2'] )
                $classes[] = 'mobile-header-2';
            if ( 'false' === $responsi_options['responsi_on_header_3'] )
                $classes[] = 'mobile-header-3';
            if ( 'false' === $responsi_options['responsi_on_header_4'] )
                $classes[] = 'mobile-header-4';
            if ( 'false' === $responsi_options['responsi_on_header_5'] )
                $classes[] = 'mobile-header-5';
            if ( 'false' === $responsi_options['responsi_on_header_6'] )
                $classes[] = 'mobile-header-6';
        }

        if ( isset($responsi_options['responsi_layout_boxed']) && 'true' === $responsi_options['responsi_layout_boxed'] ) {
            $classes[] = 'layout-box-mode';
        } else {
            $classes[] = 'layout-wide-mode';
        }

        if ( $is_lynx )
            $classes[] = 'lynx';
        elseif ( $is_gecko )
            $classes[] = 'gecko';
        elseif ( $is_opera )
            $classes[] = 'opera';
        elseif ( $is_NS4 )
            $classes[] = 'ns4';
        elseif ( $is_safari )
            $classes[] = 'safari';
        elseif ( $is_chrome )
            $classes[] = 'chrome';
        elseif ( $is_IE ) {
            $browser = $_SERVER['HTTP_USER_AGENT'];
            $browser = substr( "$browser", 25, 8 );
            if ( "MSIE 7.0" === $browser ) {
                $classes[] = 'ie7';
                $classes[] = 'ie';
            } elseif ( "MSIE 6.0" === $browser ) {
                $classes[] = 'ie6';
                $classes[] = 'ie';
            } elseif ( "MSIE 8.0" === $browser ) {
                $classes[] = 'ie8';
                $classes[] = 'ie';
            } elseif ( "MSIE 9.0" === $browser ) {
                $classes[] = 'ie9';
                $classes[] = 'ie';
            } else {
                $classes[] = 'ie';
            }
        } else
            $classes[] = 'unknown';

        if ( $is_iphone )
            $classes[] = 'iphone';

        if ( wp_is_mobile() ) {
            $classes[] = 'mobile-view';
        }

        if ( !is_user_logged_in() ) {
            $classes[] = 'not-login';
        } else {
            $classes[] = 'is-login';
        }

        return $classes;
    }
}

/*-----------------------------------------------------------------------------------*/
/* Responsi Header */
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'responsi_header' ) ) {

    function responsi_header() {
        do_action( 'responsi_doctype_before' );
        $heading_tag = 'span';
        if ( is_home() OR is_front_page() ) { $heading_tag = 'h1'; }
        global $responsi_options, $wrapper_content, $layout_column, $layout, $responsi_layout_boxed, $responsi_header_is_inside, $responsi_header_is_outside, $sidebar_box, $main_box, $sidebar_alt_box;
        ?>
        <!DOCTYPE html>
        <html <?php language_attributes(); ?>>
        <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <?php do_action( 'responsi_meta' ); ?>
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
        <?php do_action( 'responsi_head' ); ?>
        <?php wp_head(); ?>
        </head>
        <body <?php body_class(); ?>>
        <?php do_action( 'responsi_wrapper_container_before' ); ?>
        <div id="wrapper-container" class="site-container clearfix">
        <?php do_action( 'responsi_wrapper_container_content_before' ); ?>
        <div id="wrapper-top-container" class="clearfix">
        <?php do_action( 'responsi_wrapper_top_before' ); ?>
        <div id="wrapper-top-fixed" class="clearfix">
        <?php do_action( 'responsi_wrapper_top_content_before' ); ?>
        <?php
        if( $responsi_header_is_inside ){
            responsi_wrapper_header();
            responsi_wrapper_nav();
        }
        ?>
        <?php do_action( 'responsi_wrapper_top_content_after' ); ?>
        </div>
        <?php do_action( 'responsi_wrapper_top_after' ); ?>
        </div>
        <?php
        if( $responsi_header_is_outside ){
            responsi_wrapper_header();
            responsi_wrapper_nav();
        }
        ?>
        <?php do_action( 'responsi_wrapper_center_before' ); ?>
        <div id="wrapper-center" class="clearfix<?php if( 'true' === $responsi_layout_boxed ){echo ' site-width';}?>">
        <div id="wrapper-boxes" class="clearfix">
        <?php do_action( 'responsi_wrapper_boxes_before' ); ?>
        <div id="wrapper-boxes-content" class="clearfix">
        <?php if( true !== $responsi_header_is_inside && true !== $responsi_header_is_outside ){
            responsi_wrapper_header();
            responsi_wrapper_nav();
        }
        ?>
        <?php do_action( 'responsi_wrapper_content_before' ); ?>
        <div id="wrapper-content" class="clearfix col-<?php echo esc_attr( $layout_column );?>-<?php echo esc_attr( $wrapper_content );?>">
        <?php do_action( 'responsi_wrapper_content_content_before' ); ?>
        <div id="wrapper" class="site-width clearfix">
        <?php do_action( 'responsi_wrapper_article_before' ); ?>
        <article id="wrapper-article" class="clearfix">
        <?php global $shiftclick; echo $shiftclick;?>
        <?php do_action( 'responsi_wrapper_article_content_before' ); ?>
        <?php
    }
}

/*-----------------------------------------------------------------------------------*/
/* Responsi Footer */
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'responsi_footer' ) ) {

    function responsi_footer() {
        global $responsi_options, $responsi_footer_is_outside, $shiftclick;
        ?>
        <?php do_action( 'responsi_wrapper_article_content_after' ); ?>
        </article>
        <?php do_action( 'responsi_wrapper_article_after' ); ?>
        </div>
        <?php do_action( 'responsi_wrapper_content_content_after' ); ?>
        </div>
        <?php do_action( 'responsi_wrapper_content_after' ); ?>
        <?php
        if( $responsi_footer_is_outside && 'true' === $responsi_options['responsi_layout_boxed'] ){
        ?>
        </div>
        <?php do_action( 'responsi_wrapper_boxes_after' ); ?>
        </div>
        </div>
        <?php do_action( 'responsi_wrapper_center_after' ); ?>
        <?php
        }
        ?>
        <?php do_action( 'responsi_wrapper_footer_before' ); ?>
        <div id="wrapper-footer-content" class="clearfix">
          <div id="wrapper-footer" class="site-width clearfix">
            <div id="footer-content" class="clearfix">
            <footer id="footer" class="col-full lv0 clearfix">
              <div id="additional" class="col-below clearfix">
                <?php do_action( 'responsi_wrapper_footer_additional' ); ?>
              </div>
              <div class="clear"></div>
              <?php do_action( 'responsi_wrapper_footer_content' ); ?>
              <?php echo $shiftclick;?>
            </footer>
            </div>
          </div>
          <?php echo $shiftclick;?>
        </div>
        <?php do_action( 'responsi_wrapper_footer_after' ); ?>
        <div class="clear"></div>
        <?php
        if( 'true' !== $responsi_options['responsi_layout_boxed'] || ( 'true' === $responsi_options['responsi_layout_boxed'] && !$responsi_footer_is_outside) ){
            ?>
        </div>
        <?php do_action( 'responsi_wrapper_boxes_after' ); ?>
        </div>
        </div>
        <?php
        }
        ?>
        <?php do_action( 'responsi_wrapper_container_content_after' ); ?>
        </div>
        <?php do_action( 'responsi_wrapper_container_after' ); ?>
        <?php do_action( 'responsi_footer' ); ?>
        <?php wp_footer(); ?>
        </body>
        </html>
        <?php do_action( 'responsi_doctype_after' );
    }
}

/*-----------------------------------------------------------------------------------*/
/* Responsi Sidebar */
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'responsi_sidebar' ) ) {
    function responsi_sidebar(){
        global $responsi_options, $layout, $sidebar_box;
        if ( 'one-col' !== $layout ) {
            $sidebar_args = apply_filters( 'responsi_sidebar_args', array( 'sidebar_id' => 'primary', 'class' => '', 'blank_sidebar' => true, 'blank_sidebar_title' => __('Primary Sidebar', 'responsi'), 'blank_sidebar_content' => __('<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla nec massa enim. Aliquam viverra at est ullamcorper sollicitudin. Proin a leo sit amet nunc malesuada imperdiet pharetra ut eros.</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla nec massa enim. Aliquam viverra at est ullamcorper sollicitudin. Proin a leo sit amet nunc malesuada imperdiet pharetra ut eros.</p>', 'responsi') ) );
            if( is_array($sidebar_args) ){
                if ( responsi_active_sidebar( esc_attr( $sidebar_args['sidebar_id'] ) ) ) {
                    ?>
                    <?php do_action( 'responsi_sidebar_before' ); ?>
                    <div id="sidebar" class="box<?php echo esc_attr( $sidebar_box ).' '. esc_attr( $sidebar_args['class'] );?>">
                        <?php do_action( 'responsi_sidebar_wrap_before' ); ?>
                        <div class="sidebar-wrap clearfix">
                        <div class="sidebar-wrap-content">
                        <?php responsi_dynamic_sidebar( esc_attr( $sidebar_args['sidebar_id'] ) ); ?>
                        </div>
                        <?php global $shiftclick; echo $shiftclick; ?>
                        </div>
                        <?php do_action( 'responsi_sidebar_wrap_after' ); ?>
                    </div>
                    <?php do_action( 'responsi_sidebar_after' ); ?>
                    <?php
                }else{
                    if( $sidebar_args['blank_sidebar'] ){
                        ?>
                        <?php do_action( 'responsi_sidebar_before' ); ?>
                        <div id="sidebar" class="box<?php echo esc_attr( $sidebar_box ).' '. esc_attr( $sidebar_args['class'] );?>">
                            <?php do_action( 'responsi_sidebar_wrap_before' ); ?>
                            <div class="sidebar-wrap clearfix">
                            <div class="sidebar-wrap-content">
                            <div class="masonry_widget masonry_widget_blank <?php echo 'blank-'. esc_attr( $sidebar_args['sidebar_id'] );?>">
                            <div class="widget widget_text">
                            <div class="fw_widget_title clearfix"><h3><?php echo $sidebar_args['blank_sidebar_title']; ?></h3></div>
                            <div class="fw_widget_content clearfix"><div class="textwidget"><?php echo $sidebar_args['blank_sidebar_content']; ?></div></div>
                            </div>
                            </div>
                            </div>
                            <?php global $shiftclick; echo $shiftclick; ?>
                            </div>
                            <?php do_action( 'responsi_sidebar_wrap_after' ); ?>
                        </div>
                        <?php do_action( 'responsi_sidebar_after' ); ?>
                        <?php
                    }
                }
            }
        }
    }
}

/*-----------------------------------------------------------------------------------*/
/* Responsi Sidebar Alt */
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'responsi_sidebar_alt' ) ) {
    function responsi_sidebar_alt(){
        global $responsi_options, $layout, $sidebar_alt_box;
        $layouts = array( 'three-col-left', 'three-col-middle', 'three-col-right' );
        $layout = apply_filters( 'responsi_sidebar_alt', $layout );
        if ( in_array( $layout, $layouts ) ) {
            $sidebar_alt_args = apply_filters( 'responsi_sidebar_alt_args', array( 'sidebar_id' => 'secondary', 'class' => '', 'blank_sidebar' => true, 'blank_sidebar_title' => __('Secondary Sidebar', 'responsi'), 'blank_sidebar_content' => __('<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla nec massa enim. Aliquam viverra at est ullamcorper sollicitudin. Proin a leo sit amet nunc malesuada imperdiet pharetra ut eros.</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla nec massa enim. Aliquam viverra at est ullamcorper sollicitudin. Proin a leo sit amet nunc malesuada imperdiet pharetra ut eros.</p>', 'responsi') ) );
            if( is_array( $sidebar_alt_args ) ){
                if ( responsi_active_sidebar( esc_attr( $sidebar_alt_args['sidebar_id'] ) ) ) {
                    ?>
                    <?php do_action('responsi_sidebar_before'); ?>
                    <div id="sidebar-alt" class="box<?php echo esc_attr( $sidebar_alt_box ) . ' ' . esc_attr( $sidebar_alt_args['class'] );?>">
                        <?php do_action( 'responsi_sidebar_wrap_before' ); ?>
                        <div class="sidebar-wrap clearfix">
                        <div class="sidebar-wrap-content">
                        <?php responsi_dynamic_sidebar( esc_attr( $sidebar_alt_args['sidebar_id'] ) ); ?>
                        </div>
                        <?php global $shiftclick; echo $shiftclick; ?>
                        </div>
                        <?php do_action( 'responsi_sidebar_wrap_after' ); ?>
                    </div>
                    <?php do_action( 'responsi_sidebar_after' ); ?>
                    <?php
                }else{
                    if( $sidebar_alt_args['blank_sidebar'] ){
                        ?>
                        <?php do_action( 'responsi_sidebar_before' ); ?>
                        <div id="sidebar-alt" class="box<?php echo esc_attr( $sidebar_alt_box ) . ' ' . esc_attr( $sidebar_alt_args['class'] );?>">
                            <?php do_action( 'responsi_sidebar_wrap_before' ); ?>
                            <div class="sidebar-wrap clearfix">
                            <div class="sidebar-wrap-content">
                            <div class="masonry_widget masonry_widget_blank <?php echo 'blank-' . esc_attr( $sidebar_alt_args['sidebar_id'] );?>">
                            <div class="widget widget_text">
                            <div class="fw_widget_title clearfix"><h3><?php echo $sidebar_alt_args['blank_sidebar_title']; ?></h3></div>
                            <div class="fw_widget_content clearfix"><div class="textwidget"><?php echo $sidebar_alt_args['blank_sidebar_content']; ?></div></div>
                            </div>
                            </div>
                            </div>
                            <?php global $shiftclick; echo $shiftclick; ?>
                            </div>
                            <?php do_action( 'responsi_sidebar_wrap_after' ); ?>
                        </div>
                        <?php do_action( 'responsi_sidebar_after' ); ?>
                        <?php
                    }
                }
            }
        }
    }
}

/*-----------------------------------------------------------------------------------*/
/* responsi_get_sidebar_main_before */
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'responsi_get_sidebar_main_before' ) ) {
    function responsi_get_sidebar_main_before(){
        global $layout;
        if ( 'two-col-right' === $layout || 'three-col-middle' === $layout || 'three-col-right' === $layout ){ get_sidebar(); }
        if ( 'three-col-right' === $layout ){ get_sidebar( 'alt' ); }
    }
}

/*-----------------------------------------------------------------------------------*/
/* responsi_get_sidebar_main_after */
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'responsi_get_sidebar_main_after' ) ) {
    function responsi_get_sidebar_main_after(){
        global $layout;
        if ( 'two-col-left' === $layout || 'three-col-left' === $layout ){ get_sidebar(); }
        if ( 'three-col-left' === $layout || 'three-col-middle' === $layout ){ get_sidebar( 'alt' ); }
    }
}

/*-----------------------------------------------------------------------------------*/
/* responsi_embed_ob_start */
/*-----------------------------------------------------------------------------------*/

/*if ( !function_exists( 'responsi_embed_ob_start' ) ) {
    function responsi_embed_ob_start(){
        global $responsi_options;
        if( is_array( $responsi_options ) && isset( $responsi_options['responsi_mediaembed'] ) && 'true' === $responsi_options['responsi_mediaembed'] ){
            ob_start();
        }
    }
}*/

/*-----------------------------------------------------------------------------------*/
/* responsi_embed_ob_end_flush */
/*-----------------------------------------------------------------------------------*/

/*if ( !function_exists( 'responsi_embed_ob_end_flush' ) ) {
    function responsi_embed_ob_end_flush(){
        global $wp_embed, $responsi_options;
        if( is_array( $responsi_options ) && isset( $responsi_options['responsi_mediaembed'] ) && 'true' === $responsi_options['responsi_mediaembed'] ){
            $html = ob_get_contents();
            ob_end_clean();
            $html = $wp_embed->run_shortcode( $html );
            $html = do_shortcode( $wp_embed->autoembed( $html ) );
            echo $html;
        }
    }
}*/

/*-----------------------------------------------------------------------------------*/
/* Post Date */
/*-----------------------------------------------------------------------------------*/
/**
 * This function produces the date the post in question was published.
 */

if ( !function_exists( 'responsi_single_post_meta_date' ) ) {

    function responsi_single_post_meta_date() {
        
        $time_string = '<time class="entry-date published updated i_date" datetime="%1$s">%2$s</time>';

        if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
            $time_string = '<time class="entry-date published i_date" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
        }

        $time_string = sprintf( $time_string,
            esc_attr( get_the_date( 'c' ) ),
            get_the_date(),
            esc_attr( get_the_modified_date( 'c' ) ),
            get_the_modified_date()
        );

        /*$output = sprintf( '<span class="posted-on i_dates"><span class="screen-reader-text">%1$s </span><a href="%2$s" rel="bookmark">%3$s</a></span>',
            _x( 'Posted on', 'Used before publish date.', 'responsi' ),
            esc_url( get_permalink() ),
            $time_string
        );*/

        $output = sprintf( '<span class="posted-on i_dates"><span class="screen-reader-text">%1$s </span>%2$s</span>',
            _x( 'Posted on', 'Used before publish date.', 'responsi' ),
            $time_string
        );

        return apply_filters( 'responsi_single_post_meta_date', $output );
    }

}

/*-----------------------------------------------------------------------------------*/
/* Post Author */
/*-----------------------------------------------------------------------------------*/
/**
 * This function produces the author of the post (display name)
 *
 */

if ( !function_exists( 'responsi_single_post_meta_author' ) ) {

    function responsi_single_post_meta_author() {
        
        $output = sprintf( '<span class="i_authors"><span class="author vcard"><span class="screen-reader-text">%1$s </span> <a class="url fn n" href="%2$s">%3$s</a></span></span>',
            _x( 'Author', 'Used before post author name.', 'responsi' ),
            esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
            get_the_author()
        );

        return apply_filters( 'responsi_single_post_meta_author', $output );
    }

}

/*-----------------------------------------------------------------------------------*/
/* Post Author Posts Link */
/*-----------------------------------------------------------------------------------*/
/**
 * This function produces the display name of the post's author, with a link to their
 * author archive screen.
 *
 * @example <code>[post_author_posts_link]</code> is the default usage
 * @example <code>[post_author_posts_link before="<b>" after="</b>"]</code>
 */

if (!function_exists('responsi_post_author_posts_link')) {

    function responsi_post_author_posts_link( $html, $atts )
    {
        $atts = (array) $atts;
        $defaults = array(
            'before' => '<span class="i_author">By ',
            'after' => '</span> <span class="i_in">in</span>'
        );
        $atts     = array_merge( $defaults, $atts );

        // Darn you, WordPress!
        ob_start();
        the_author_posts_link();
        $author = ob_get_clean();
        $html = sprintf('%2$s%1$s%3$s', $author, $atts['before'] , $atts['after'] );
        return apply_filters('responsi_post_author_posts_link', $html, $atts );

    }

}

/*-----------------------------------------------------------------------------------*/
/* Post Comments */
/*-----------------------------------------------------------------------------------*/
/**
 * This function produces the comment link, or a message if comments are closed.
 *
 */

if ( !function_exists( 'responsi_single_post_meta_comments' ) ) {

    function responsi_single_post_meta_comments() {

        global $post;
        
        $defaults = array(
            'zero'          => __( 'Comments [ 0 ]', 'responsi' ),
            'one'           => __( 'Comments [ 1 ]', 'responsi' ),
            'more'          => __( 'Comments [ % ]', 'responsi' ),
            'hide_if_off'   => 'disabled',
            'closed_text'   => apply_filters( 'responsi_post_more_comment_closed_text', __( 'Comments are closed', 'responsi' ) ),
            'before'        => '',
            'after'         => ''
        );

        if ( ( ! get_option( 'responsi_comments' ) || !comments_open()) && 'enabled' === $defaults['hide_if_off'] )
            return;

        if ( 'open' === $post->comment_status ) {
            // Darn you, WordPress!
            ob_start();
            comments_number( $defaults['zero'], $defaults['one'], $defaults['more'] );
            $comments = ob_get_clean();
            $comments = sprintf( '<a href="%s">%s</a>', esc_url( get_comments_link() ) , $comments );
        } else {
            $comments = $defaults['closed_text'];
        }

        $output = sprintf( '<span class="post-comments comments">%2$s%1$s%3$s</span>', $comments, '<span class="i_comment">', '<span>' );
        if ( 'open' === $post->comment_status ) {
            return apply_filters( 'responsi_single_post_meta_comments', $output );
        }

    }
}

/*-----------------------------------------------------------------------------------*/
/* Post Tags */
/*-----------------------------------------------------------------------------------*/
/**
 * This function produces a collection of tags for this post, linked to their
 * appropriate archive screens.
 *
 */

if ( !function_exists( 'responsi_single_post_meta_tags' ) ) {

    function responsi_single_post_meta_tags( $atts ) {
        $atts = (array) $atts;
        $defaults = array(
            'sep'       => ', ',
            'before'    => __('Tags: ', 'responsi'),
            'after'     => ''
        );
        $atts = array_merge( $defaults, $atts );

        $tags = get_the_tag_list( $atts['before'], trim($atts['sep']) . ' ', $atts['after'] );

        if ( !$tags )
            return;

        $output = sprintf( '<div class="posts-tags">%s</div> ', $tags );

        return apply_filters( 'responsi_single_post_meta_tags', $output, $atts );

    }

}

/*-----------------------------------------------------------------------------------*/
/* Post Categories */
/*-----------------------------------------------------------------------------------*/
/**
 * This function produces the category link list
 *
 */

if ( !function_exists( 'responsi_single_post_meta_categories' ) ) {

    function responsi_single_post_meta_categories( $atts ) {
        $atts = (array) $atts;
        $defaults = array(
            'sep'       => ', ',
            'before'    => '',
            'after'     => ''
        );
        $atts = array_merge( $defaults, $atts );

        $cats = get_the_category_list( trim($atts['sep'] ) . ' ' );

        $cats = str_replace( ' rel="category tag"', '', $cats );

        $output = sprintf( '<span class="categories">%2$s%1$s%3$s</span> ', $cats, $atts['before'], $atts['after'] );

        return apply_filters( 'responsi_single_post_meta_categories', $output, $atts );

    }

}

/*-----------------------------------------------------------------------------------*/
/* Login/Logout Link */
/*-----------------------------------------------------------------------------------*/
/**
 * This function produces a login or logout link, depending on the user's login status.
 *
 */

if ( !function_exists( 'responsi_build_loginout' ) ) {

    function responsi_build_loginout( $atts ) {
        $atts = (array) $atts;
        $defaults = array(
            'redirect'  => '',
            'before'    => '',
            'after'     => ''
        );

        $atts = array_merge( $defaults, $atts );

        if ( !is_user_logged_in() )
            $link = '<a href="' . esc_url( wp_login_url( $atts['redirect'] ) ) . '">' . __('Login', 'responsi') . '</a>';
        else
            $link = '<a href="' . esc_url( wp_logout_url( $atts['redirect'] ) ) . '">' . __('Logout', 'responsi') . '</a>';

        $output = $atts['before'] . apply_filters( 'loginout', $link ) . $atts['after'];

        return apply_filters( 'responsi_build_loginout', $output, $atts );

    }

}

/*-----------------------------------------------------------------------------------*/
/* Copyright Text */
/*-----------------------------------------------------------------------------------*/
/**
 * This function produces the default footer copyright text.
 *
 */

if ( !function_exists( 'responsi_build_copyright' ) ) {

    function responsi_build_copyright( $atts ) {
        global $responsi_options;
        $atts = (array) $atts;
        if( !is_array( $responsi_options ) ) return;

        $defaults = array(
            'before'    => '',
            'after'     => ''
        );

        $atts     = array_merge( $defaults, $atts );
        $output   = '';

        if ( 'true' === $responsi_options['responsi_footer_left'] && '' !== trim( $responsi_options['responsi_footer_left_text'] ) ) {
            $output = sprintf('%1$s%3$s%2$s', $atts['before'], $atts['after'], wpautop( strip_tags($responsi_options['responsi_footer_left_text']) ) );
        }

        return apply_filters( 'responsi_build_copyright', $output, $atts );
    }
}

/*-----------------------------------------------------------------------------------*/
/* Below Footer - Site Info */
/*-----------------------------------------------------------------------------------*/
/**
 * This function produces the default footer below text.
 *
 */

if ( !function_exists( 'responsi_build_additional' ) ) {

    function responsi_build_additional( $atts ) {
        global $responsi_options;

        if( !is_array( $responsi_options ) ) return;
        $atts = (array) $atts;
        $defaults = array(
            'before'    => '',
            'after'     => ''
        );

        $atts     = array_merge( $defaults, $atts );
        $output   = '';

        if( isset( $responsi_options['responsi_footer_below']) && 'true' === $responsi_options['responsi_footer_below'] ){
            $output = sprintf('%1$s%3$s%2$s', $atts['before'], $atts['after'], do_shortcode(apply_filters( 'a3_lazy_load_html', wpautop(responsi_autoembed_media($responsi_options['responsi_footer_below_text'])))));
        }
        return apply_filters( 'responsi_build_additional', $output, $atts );

    }

}

/*-----------------------------------------------------------------------------------*/
/* Credit Text */
/*-----------------------------------------------------------------------------------*/
/**
 * This function produces the default footer credit text.
 *
 */

if ( !function_exists( 'responsi_build_credit' ) ) {

    function responsi_build_credit( $atts ) {
        global $responsi_options;

        if( !is_array( $responsi_options ) ) return;
        $atts = (array) $atts;
        $defaults = array(
            'before'    => '',
            'after'     => ''
        );

        $output   = '';
        $html     = '';
        $atts     = array_merge( $defaults, $atts );
        $loginout = '';

        if ( isset($responsi_options['responsi_footer_right_login']) && 'true' === $responsi_options['responsi_footer_right_login'] ) {
            $attr = apply_filters( 'responsi_build_loginout_attr', array(
                'redirect'  => '',
                'before'    => '',
                'after'     => ''
            ));

            $loginout .= responsi_build_loginout( $attr );
        }
        if ( isset($responsi_options['responsi_enable_footer_right']) && 'true' === $responsi_options['responsi_enable_footer_right'] ) {
            $footer_right_text_before     = $responsi_options['responsi_footer_right_text_before'];
            $footer_right_text_before_url = $responsi_options['responsi_footer_right_text_before_url'];

            if ( '' !== trim($footer_right_text_before_url) ) {
                $text_before = '<a href="' . esc_url( $footer_right_text_before_url ) . '" target="_blank">' . $footer_right_text_before . '</a>';
            } else {
                $text_before = $footer_right_text_before;
            }

            $footer_right_logo     = $responsi_options['responsi_footer_right_logo'];
            $footer_right_logo_url = $responsi_options['responsi_footer_right_logo_url'];
            $right_logo = '';
            if ( '' !== trim($footer_right_logo_url) && '' !== trim($footer_right_logo) ) {
                $width_height_attr = responsi_get_image_attribute( $footer_right_logo );
                $right_logo = '<a href="' . esc_url( $footer_right_logo_url ) . '" target="_blank"><img src="' .  esc_url( $footer_right_logo ) . '" alt="'.__( 'Logo', 'responsi' ).'"'.$width_height_attr.'></a>';
            } elseif( '' !== trim( $footer_right_logo ) ) {
                $width_height_attr = responsi_get_image_attribute( $footer_right_logo );
                $right_logo = '<img src="' . esc_url( $footer_right_logo ) . '" alt="'.__( 'Logo', 'responsi' ).'"'.$width_height_attr.'>';
            }

            $footer_right_text_after     = $responsi_options['responsi_footer_right_text_after'];
            $footer_right_text_after_url = $responsi_options['responsi_footer_right_text_after_url'];

            if ( '' !== trim($footer_right_text_after_url) ) {
                $text_after = '<a href="' . esc_url( $footer_right_text_after_url ) . '" target="_blank">' . $footer_right_text_after . '</a>';
            } else {
                $text_after = $footer_right_text_after;
            }

            $html = $text_before . ' ' . $right_logo . ' ' . $text_after;
        }

        $html .= $loginout;

        $output = sprintf( '%1$s%3$s%2$s', $atts['before'], $atts['after'], $html );

        return apply_filters( 'responsi_build_credit', $output, $atts );
    }
}

/*-----------------------------------------------------------------------------------*/
/* Page / Post navigation */
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'responsi_get_post_types' ) ) {
    function responsi_get_post_types() {
        global $responsi_post_types;
        $args = array(
            'public' => true
        );
        $responsi_post_types = array();
        $post_types       = get_post_types( $args, 'names' );
        foreach ( $post_types as $post_type ) {
            if ( 'page' !== $post_type && 'wp_email_images' !== $post_type &&  'attachment' !== $post_type ) {
                $responsi_post_types[$post_type] = ucwords( str_replace( '-', ' ', $post_type ) );
            }
        }
    }
}

/*-----------------------------------------------------------------------------------*/
/* Archive Title */
/*-----------------------------------------------------------------------------------*/
/**
 * Archive Title
 *
 * The main page title, used on the various post archive templates.
 *
 * @since 4.0
 *
 * @param string $before Optional. Content to prepend to the title.
 * @param string $after Optional. Content to append to the title.
 * @param bool $echo Optional, default to true.Whether to display or return.
 * @return null|string Null on no title. String if $echo parameter is false.
 *
 * @package ResponsiFramework
 * @subpackage Template
 */

if ( !function_exists( 'responsi_archive_title' ) ) {

    function responsi_archive_title( $before = '', $after = '', $echo = true ) {

        global $wp_query, $responsi_options;

        if ( is_category() || is_tag() || is_tax() ) {

            $taxonomy_obj        = $wp_query->get_queried_object();
            $term_id             = $taxonomy_obj->term_id;
            $taxonomy_short_name = $taxonomy_obj->taxonomy;
            $taxonomy_raw_obj    = get_taxonomy( $taxonomy_short_name );

        }

        $title       = '';
        $delimiter   = ' | ';
        $date_format = get_option( 'date_format' );

        // Category Archive
        if ( is_category() ) {
            $title = single_cat_title( '', false ) ;
        }

        // Day Archive
        if ( is_day() ) {
            $title = get_the_time( $date_format );
        }

        // Month Archive
        if ( is_month() ) {
            $date_format = apply_filters( 'responsi_archive_title_date_format', 'F, Y' );
            $title       = get_the_time( $date_format );
        }

        // Year Archive
        if ( is_year() ) {
            $date_format = apply_filters( 'responsi_archive_title_date_format', 'Y' );
            $title       = get_the_time( $date_format );
        }

        // Author Archive
        if ( is_author() ) {
            $title = get_the_author_meta( 'display_name', get_query_var( 'author' ) );
        }

        // Tag Archive
        if ( is_tag() ) {
            $title = single_tag_title( '', false );
        }

        // Post Type Archive
        if ( function_exists( 'is_post_type_archive' ) && is_post_type_archive() ) {

            /* Get the post type object. */
            $post_type_object = get_post_type_object( get_query_var( 'post_type' ) );

            $title = $post_type_object->labels->name;
        }

        // Post Format Archive
        if ( get_query_var('taxonomy') === 'post_format' ) {

            $post_format = str_replace( 'post-format-', '', get_query_var( 'post_format' ) );

            $title = get_post_format_string( $post_format );
        }

        // General Taxonomy Archive
        if ( is_tax() ) {
            $title = sprintf( __('%1$s', 'responsi'), $taxonomy_obj->name );
        }

        if ( strlen( $title ) === 0 )
            return;

        $title = $before . $title . $after;

        // Allow for external filters to manipulate the title value.
        $title = apply_filters( 'responsi_archive_title', $title, $before, $after );

        if ( $echo )
            echo $title;
        else
            return $title;

    }
}

/*-----------------------------------------------------------------------------------*/
/* responsi_archive_title_rss_links */
/*-----------------------------------------------------------------------------------*/

function responsi_archive_title_rss_links( $title, $before, $after ){
    global $wp_query, $responsi_options;
    
    if ( is_category() && isset( $responsi_options['responsi_archive_header_disable_rss'] ) && 'true' === $responsi_options['responsi_archive_header_disable_rss'] ) {
        $taxonomy_obj        = $wp_query->get_queried_object();
        $term_id             = $taxonomy_obj->term_id;
        $taxonomy_short_name = $taxonomy_obj->taxonomy;
        $taxonomy_raw_obj    = get_taxonomy( $taxonomy_short_name );
        $cat_obj             = $wp_query->get_queried_object();
        $cat_id              = $cat_obj->cat_ID;
        $title_rss = '<span class="fr catrss"><a href="' . esc_url( get_term_feed_link( $term_id, $taxonomy_short_name, '' ) ) . '">' . __('RSS feed for this section', 'responsi') . '</a></span>';

        $title = str_replace( '<h1 class="title entry-title">', '<h1 class="title fl cat entry-title">', $title );
        $title = str_replace( '</span>', $title_rss, $title );
    }

    return $title;
}

/*-----------------------------------------------------------------------------------*/
/* responsi_archive_post_title_item_after */
/*-----------------------------------------------------------------------------------*/
function responsi_archive_post_date()
{
    global $responsi_options;
    if ( is_array($responsi_options) && isset($responsi_options['responsi_enable_post_date_blog']) && 'true' === $responsi_options['responsi_enable_post_date_blog'] ) {
        ?>
        <div class="blogpostinfo"><span class="i_date date published time"><?php the_time('M j, Y'); ?></span> </div>
       <?php
    }
}

/*-----------------------------------------------------------------------------------*/
/* responsi_continue_reading_link() */
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'responsi_continue_reading_link' ) ) {
    function responsi_continue_reading_link() {
        global $responsi_options;

        if ( 'true' === $responsi_options['responsi_disable_blog_morelink'] ) {
            $showhide = 'blogs-more show-more-link';
        } else {
            $showhide = 'blogs-more hide-more-link';
        }

        $more_link_text = $responsi_options['responsi_blog_morelink_text'];

        $class = 'more-link';
        if ( 'button' === $responsi_options['responsi_blog_morelink_type'] ) {
            $class = 'button more-link-button';
        }

        // More Link?
        $link   = apply_filters( 'responsi_get_the_content_more_link', sprintf('<span class="'. esc_attr( $showhide ) .'"><a href="%s" class="' . esc_attr( $class ) . '">%s</a></span>', esc_url( get_permalink() ), $more_link_text), $more_link_text);
        return $link;
    }
}

function responsi_excerpt_more( $more ){
    if ( ! is_admin() ) {
        $more = '';
    }
    return $more;
}


function responsi_custom_excerpt_more( $output ){
    if ( ! is_attachment() && ! is_admin() ) {
        $output = '<p class="gird_descriptions">' . strip_tags( $output ) . '</p>' . responsi_continue_reading_link();
    }
    return $output;
}



/*-----------------------------------------------------------------------------------*/
/* responsi_get_placeholder_image() */
/*-----------------------------------------------------------------------------------*/

function responsi_get_placeholder_image( $file = 'no-image.png' ) {
    global $responsi_options;
    if ( isset( $responsi_options['responsi_default_image'] ) && '' !== $responsi_options['responsi_default_image'] ) {
        $file_url = trim($responsi_options['responsi_default_image']);
    } else {
        // If we're not looking for a file, do not proceed
        if ( empty( $file ) )
            return;

        // Look for file in stylesheet
        if ( file_exists(get_stylesheet_directory() . '/images/' . $file ) ) {
            $file_url = get_stylesheet_directory_uri() . '/images/' . $file;

            // Look for file in template
        } elseif ( file_exists(get_template_directory() . '/images/' . $file ) ) {
            $file_url = get_template_directory_uri() . '/images/' . $file;
        }
    }
    if ( is_ssl() )
        $file_url = str_replace( 'http://', 'https://', esc_url( $file_url ) );
    return apply_filters( 'responsi_get_placeholder_image', esc_url( $file_url ) );
}

/*-----------------------------------------------------------------------------------*/
/* responsi_add_pagination_links() */
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'responsi_add_pagination_links' ) ) {
    function responsi_add_pagination_links() {
        add_action( 'responsi_loop_after', 'responsi_pagination', 10, 0 );
    }
}

/*-----------------------------------------------------------------------------------*/
/* responsi_meta_tags() */
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'responsi_meta_tags' ) ) {
    function responsi_meta_tags() {
        $html = '';
        //$html .= '<meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1">';
        $html .= '<meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0,user-scalable=no,height=device-height">';
        $html .= '<meta name="format-detection" content="telephone=yes">';
        echo $html;
    }
}

/*-----------------------------------------------------------------------------------*/
/* responsi_filter_media_view_settings() */
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'responsi_filter_media_view_settings' ) ) {
    function responsi_filter_media_view_settings( $settings, $post ){
        if( is_admin() || is_customize_preview() ){
            if( is_array( $settings ) && isset( $settings['post'] ) && is_array( $settings['post'] ) && isset( $settings['post']['id'] ) && $settings['post']['id'] == 0 ){
                $post_id = get_option( 'responsi_framework_auto_draft' );
                if( $post_id > 0 && function_exists('post_exists') && post_exists( 'Responsi Framework' ) ){
                    $settings['post']['id'] = $post_id;
                }else{
                    if( function_exists('post_exists') && !post_exists( 'Responsi Framework' ) ){
                        $post_id = wp_insert_post( array( 'post_title' => 'Responsi Framework', 'post_status' => 'auto-draft', 'post_type' => 'framework' ) );
                        update_option( 'responsi_framework_auto_draft', $post_id );
                        $settings['post']['id'] = $post_id;
                    }
                }
            }
        }
        return $settings;
    }
}

/*-----------------------------------------------------------------------------------*/
/* responsi_404_redirect() */
/*-----------------------------------------------------------------------------------*/

function responsi_404_redirect() {
    if ( is_404() ) {
        global $responsi_options;
        if ( isset( $responsi_options['responsi_404_page'] ) ) {
            $page_id = $responsi_options['responsi_404_page'];
        } else {
            $page_id = get_option('responsi_404_page');
        }
        if ( $page_id > 0 ) {
            $redirect_404_url = esc_url( get_permalink( $page_id ) );
            wp_redirect($redirect_404_url);
            exit();
        } 
    }
}

/*-----------------------------------------------------------------------------------*/
/* responsi_wrapper_header() */
/*-----------------------------------------------------------------------------------*/

function responsi_wrapper_header() {
    global $shiftclick;
    do_action( 'responsi_wrapper_header_before' );
    ?>
    <div id="wrapper-header-content" class="clearfix">
      <?php do_action( 'responsi_wrapper_header_content_before' ); ?>
      <div id="wrapper-header" class="site-width clearfix">
        <div id="header-content" class="clearfix">
        <?php do_action( 'responsi_wrapper_header_content' ); ?>
        </div>
      </div>
      <?php do_action( 'responsi_wrapper_header_content_after' ); ?>
      <?php echo $shiftclick;?>
    </div>
    <?php
    do_action( 'responsi_wrapper_header_after' );
}

/*-----------------------------------------------------------------------------------*/
/* responsi_wrapper_header_content(). */
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'responsi_wrapper_header_content' ) ) {
    function responsi_wrapper_header_content() {
        global $responsi_options, $wrapper_content, $shiftclick;

        $header_sidebar_total = 6;
        $has_header_sidebars  = true;

        $total = $responsi_options['responsi_header_sidebars'];
        if ( isset( $responsi_options['responsi_header_sidebars'] ) && '0' == $responsi_options['responsi_header_sidebars'] ) {
            $total = 0;
        } 

        if ( !isset( $responsi_options['responsi_header_sidebars'] ) ) {
            $total = 0;
        }

        if( isset( $responsi_options['responsi_enable_header_widget'] ) && 'true' !== $responsi_options['responsi_enable_header_widget'] ){
            $has_header_sidebars = false;
            $total = 0;
        }

        if ( $has_header_sidebars && $total > 0 ) {
            ?>
            <div class="clear"></div>
            <header id="header" class="clearfix col-full col-<?php echo esc_attr( $total ); ?>">
            <?php do_action( 'responsi_header_widget_before' ); ?>
            <div class="clear"></div>
            <?php
            $i = 0;

            $box_last = '';

            while ( $i < $total ) {
                $i++;

                if( $i == $total ){
                    $box_last = ' box-last';
                }

                if ( 1 === $i ) {
                    if ( responsi_active_sidebar( 'header-' . $i ) ) {
                        ?>
                    <div class="box<?php echo esc_attr( $box_last ); ?> col-item header-widget-<?php echo $i; ?>"><?php  responsi_dynamic_sidebar('header-' . $i); ?></div>
                        <?php
                    } else {
                        ?>
                    <div class="box<?php echo esc_attr( $box_last ); ?> col-item header-widget-1">
                        <div class="widget widget_text">
                        <?php
                        echo '<div class="site-logo-container">';
                        responsi_site_logo();
                        echo '</div>';
                        echo '<div class="site-description-container">';
                        responsi_site_description();
                         echo '</div>';
                        ?>
                        </div>
                    </div>
                        <?php

                    }
                } else {
                    if ( responsi_active_sidebar( 'header-' . $i ) ) {
                        ?>
                        <div class="box<?php echo esc_attr( $box_last ); ?> col-item header-widget-<?php echo $i; ?> shiftclick_container">
                        <?php responsi_dynamic_sidebar( 'header-' . $i ); ?>
                        <?php echo $shiftclick; ?>
                        </div>
                        <?php
                    }
                }
            }
            ?>
            <div class="clear"></div>
            <?php do_action( 'responsi_header_widget_after' ); ?>
            </header>
            <div class="clear"></div>
            <?php

        } else {
            ?>
            <div class="clear"></div>
            <header id="header" class="clearfix col-full col-1">
            <?php do_action( 'responsi_header_widget_before' ); ?>
                <div class="clear"></div>
                    <div class="box box-last col-item  header-widget-1">
                        <div class="widget widget_text">
                        <?php
                        echo '<div class="site-logo-container">';
                        responsi_site_logo();
                        echo '</div>';
                        echo '<div class="site-description-container">';
                        responsi_site_description();
                        echo '</div>';
                        ?>
                    </div>
                </div>
              <div class="clear"></div>
            <?php do_action( 'responsi_header_widget_after' ); ?>
            </header>
            <div class="clear"></div>
            <?php
        }
    }
}

/*-----------------------------------------------------------------------------------*/
/* responsi_wrapper_nav() */
/*-----------------------------------------------------------------------------------*/

function responsi_wrapper_nav() {
    global $shiftclick;
    do_action( 'responsi_wrapper_nav_before' );
    ?>
    <div id="wrapper-nav-content" class="clearfix">
      <div id="wrapper-nav" class="site-width clearfix">
        <?php do_action( 'responsi_wrapper_nav_content' ); ?>
      </div>
      <?php echo $shiftclick;?>
    </div>
    <?php
    do_action( 'responsi_wrapper_nav_after' );
}

/*-----------------------------------------------------------------------------------*/
/* responsi_navigation() */
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'responsi_navigation' ) ) {
    function responsi_navigation() {
        global $responsi_options;
        do_action( 'responsi_navigation_before' );
        ?>
        <div id="navigation-content" class="clearfix">
          <nav id="navigation" class="clearfix">
            <?php do_action( 'responsi_navigation' ); ?>
            <?php
            $nav_ctr = '';
            $nav_ctr_before = apply_filters( 'responsi_mobile_navigation_before', '' );
            $nav_ctr_after = apply_filters( 'responsi_mobile_navigation_after', '' );
            if ( isset( $responsi_options['responsi_nav_mobile_type'] ) && 'click' === $responsi_options['responsi_nav_mobile_type'] ) {
                $nav_ctr = '<div class="mobile-navigation mobile-navigation-open mobile-navigation-alignment-left"><div class="clearfix"></div>'.$nav_ctr_before.'<span class="nav-mobile-text nav-mobile-text-before"></span><span class="nav-separator"><i class="responsi-icon-mobile-menu responsi-icon-menu"></i></span><span class="nav-mobile-text nav-mobile-text-after">'. __('Navigation', 'responsi') .'</span>'.$nav_ctr_after.'<div class="clearfix"></div>'. do_action( 'responsi_navigation' ) .'<div class="clearfix"></div></div>';
                $nav_ctr = apply_filters( 'responsi_mobile_navigation', $nav_ctr );
            }
            if ( isset( $responsi_options['responsi_nav_mobile_type'] ) && 'select' === $responsi_options['responsi_nav_mobile_type'] ) {
                $nav_ctr = $nav_ctr_before.$nav_ctr.$nav_ctr_after;
            }
            echo $nav_ctr;
            if ( function_exists('has_nav_menu' ) && has_nav_menu( 'primary-menu' ) ) {
                @wp_nav_menu(array(
                    'sort_column'       => 'menu_order',
                    'menu_id'           => 'main-nav',
                    'menu_class'        => 'responsi-menu nav fl',
                    'theme_location'    => 'primary-menu',
                    'items_wrap'        => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                    'container'         => 'ul',
                ));
            } else {
                ?>
            <ul id="main-nav" class="nav fl">
                <?php
                if ( is_page() ){
                    $highlight = "page_item";
                }
                else{
                    $highlight = "page_item current_page_item";
                }
                ?>
              <li class="<?php echo esc_attr( $highlight ); ?>"><a href="<?php echo esc_url( home_url('/') ); ?>"><?php _e('Home', 'responsi'); ?></a></li>
              <?php wp_list_pages( 'sort_column=menu_order&depth=6&title_li=&exclude=' ); ?>
            </ul>
            <?php
            }
            ?>
          </nav>
        </div>
        <?php
        do_action( 'responsi_navigation_after' );
    }
}

/*-----------------------------------------------------------------------------------*/
/* responsi_main_wrap_before(). */
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'responsi_main_wrap_before' ) ) {
    function responsi_main_wrap_before() {
        global $is_blog_template;
        $class = ' clearfix';
        if( is_archive() || $is_blog_template ){
            $class .= ' main-wrap-archive';
        }elseif( is_single() ){
            $class .= ' main-wrap-post';
        }elseif( is_page() ){
            $class .= ' main-wrap-page';
        }
        echo '<div class="main-wrap' .esc_attr( $class ) .'">';
    }
}

/*-----------------------------------------------------------------------------------*/
/* responsi_main_wrap_after(). */
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'responsi_main_wrap_after' ) ) {
    function responsi_main_wrap_after() {
        global $shiftclick;
        echo $shiftclick.'</div>';
    }
}

/*-----------------------------------------------------------------------------------*/
/* responsi_footer_sidebars(). */
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'responsi_footer_sidebars' ) ) {
    function responsi_footer_sidebars() {
        global $responsi_options, $has_footer_sidebars, $shiftclick;

        $footer_sidebar_total = 6;
        $has_footer_sidebars  = false;

        for ( $i = 1; $i <= $footer_sidebar_total; $i++ ) {
            if ( responsi_active_sidebar( 'footer-' . $i ) ) {
                $has_footer_sidebars = true;
            }
        }

        $total = $responsi_options['responsi_footer_sidebars'];
        if ( isset( $responsi_options['responsi_footer_sidebars'] ) && 0 === $responsi_options['responsi_footer_sidebars'] ) {
            $total = 0;
        }

        if( isset( $responsi_options['responsi_enable_footer_widget'] ) && 'true' !== $responsi_options['responsi_enable_footer_widget'] ){
            $has_footer_sidebars = false;
            $total = 0;
        }

        $footer_widget_container_before = '
        <div id="wrapper-footer-top-content" class="clearfix">
            <div class="clear"></div> 
            <div id="wrapper-footer-top" class="site-width clearfix lv0">
                <div class="clear"></div> 
                <div id="footer-top-content" class="clearfix">';
        $footer_widget_container_after = '
                </div>
                <div class="clear"></div>
                '.$shiftclick.'
            </div>
            <div class="clear"></div>
            '.$shiftclick.'
        </div>
        <div class="clear"></div>';

        if ( $has_footer_sidebars && $total > 0) {
            echo $footer_widget_container_before;
            ?>
            <div id="footer-widgets" class="col-full col-<?php echo esc_attr( $total ); ?> clearfix">
            <?php do_action( 'responsi_footer_widget_before' ); ?>
              <div class="clear"></div>
                <?php
                $i = 0;
                $box_last = '';
                while ( $i < $total ) {
                    $i++;
                    if( $i == $total ){
                        $box_last = ' box-last';
                    }
                    if ( responsi_active_sidebar( 'footer-' . $i ) ) {
                        ?>
                    <div class="box<?php echo esc_attr( $box_last );?> col-item footer-widget-<?php echo $i; ?> shiftclick_container">
                    <?php responsi_dynamic_sidebar( 'footer-' . $i ); ?>
                    <?php echo $shiftclick; ?>
                    </div>
                    <?php
                    }
                }
                ?>
              <div class="clear"></div>
            <?php do_action( 'responsi_footer_widget_after' ); ?>
            </div>
            <?php
            echo $footer_widget_container_after;
        } elseif( $total > 0 ) {}
    }
}

/*-----------------------------------------------------------------------------------*/
/* responsi_wrapper_footer_content(). */
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'responsi_wrapper_footer_content' ) ) {
    function responsi_wrapper_footer_content(){
        ?>
        <div id="copyright" class="col-left">
            <?php do_action( 'responsi_wrapper_footer_content_copyright' ); ?>
        </div>
        <div id="credit" class="col-right">
            <?php do_action( 'responsi_wrapper_footer_content_credit' ); ?>
        </div>
        <?php
    }
}

/*-----------------------------------------------------------------------------------*/
/* responsi_footer_copyright(). */
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'responsi_footer_copyright' ) ) {
    function responsi_footer_copyright() {

        global $responsi_options;

        do_action( 'responsi_footer_copyright_before' );

        $attr = apply_filters( 'responsi_footer_copyright_attr', array(
            'before'    => '',
            'after'     => ''
        ));

        $html = responsi_build_copyright( $attr );

        $html = apply_filters( 'responsi_footer_copyright', $html );

        echo $html;

        do_action( 'responsi_footer_copyright_after' );

    }
}

/*-----------------------------------------------------------------------------------*/
/* responsi_footer_credit(). */
/*-----------------------------------------------------------------------------------*/

if (!function_exists('responsi_footer_credit')) {
    function responsi_footer_credit() {

        global $responsi_options;

        do_action( 'responsi_footer_credit_before' );

        $attr = apply_filters( 'responsi_footer_credit_attr', array(
            'before'    => '',
            'after'     => ''
        ));

        $html = responsi_build_credit( $attr );

        $html = apply_filters( 'responsi_footer_credit', $html );

        echo $html;

        do_action( 'responsi_footer_credit_after' );

    }
}

/*-----------------------------------------------------------------------------------*/
/* responsi_footer_additional(). */
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'responsi_footer_additional' ) ) {
    function responsi_footer_additional() {

        global $responsi_options;

        do_action( 'responsi_footer_additional_before' );

        $attr = apply_filters( 'responsi_footer_additional_attr', array(
            'before'    => '',
            'after'     => ''
        ));

        $html = responsi_build_additional( $attr );

        $html = apply_filters( 'responsi_footer_additional', $html );

        echo $html;

        do_action( 'responsi_footer_additional_after' );

    }
}

/*-----------------------------------------------------------------------------------*/
/* responsi_single_post_meta(). */
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'responsi_single_post_meta' ) ) {
    function responsi_single_post_meta() {
        if ( is_page() ) {
            return;
        }

        global $responsi_options;

        $attr_author    = apply_filters( 'responsi_single_post_meta_author_attr', array(
            'before'    => '',
            'after'     => ''
        ));
        $postauthorlink = responsi_single_post_meta_author();

        $postdate  = responsi_single_post_meta_date();
        $postcomments  = responsi_single_post_meta_comments();

        $post_info = $postauthorlink . $postdate . $postcomments;

        if( '' !== $post_info ){
            printf( '<div class="post-meta">%s</div>', apply_filters( 'responsi_single_post_meta', $post_info ) );
        }

    }
}

/*-----------------------------------------------------------------------------------*/
/* responsi_single_post_meta_categories_default(). */
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'responsi_single_post_meta_categories_default' ) ) {
    function responsi_single_post_meta_categories_default() {
        if ( !is_singular('post') )
            return;
        $attr_post_categories = apply_filters( 'responsi_single_post_meta_categories_attr', array(
            'sep'       => ', ',
            'before'    => '<span class="i_cat">' . __('Posted in', 'responsi' ) . ' : ',
            'after'     => '</span>'
        ));
        $post_info_categories = responsi_single_post_meta_categories( $attr_post_categories );
        printf('<div class="post-utility post-utility-cat col-full">%s</div>', apply_filters( 'responsi_single_post_meta_categories_default', $post_info_categories ) );

    }
}

/*-----------------------------------------------------------------------------------*/
/* responsi_single_post_meta_tags_default(). */
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'responsi_single_post_meta_tags_default' ) ) {
    function responsi_single_post_meta_tags_default() {
        if ( !is_singular( 'post' ) )
            return;
        $attr_post_tags = apply_filters( 'responsi_single_post_meta_tags_attr', array(
            'sep'       => ', ',
            'before'    => '<span class="i_tag">' . __('Tags', 'responsi' ) . ' : ',
            'after'     => '</span>'
        ) );
        $post_info_tags = responsi_single_post_meta_tags($attr_post_tags);
        printf('<div class="post-utility post-utility-tag col-full">%s</div>', apply_filters( 'responsi_single_post_meta_tags_default', $post_info_tags) );

    }
}

/*-----------------------------------------------------------------------------------*/
/* responsi_comment_form_field_comment(). */
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'responsi_comment_form_field_comment' ) ) {
    function responsi_comment_form_field_comment( $field ) {

        $field = str_replace( '<label ', '<label class="hide" ', $field );
        $field = str_replace( 'cols="45"', 'cols="50"', $field );
        $field = str_replace( 'rows="8"', 'rows="10"', $field );

        return $field;

    }
}

/*-----------------------------------------------------------------------------------*/
/* responsi_comment_form_default_fields(). */
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'responsi_comment_form_default_fields' ) ) {
    function responsi_comment_form_default_fields( $fields ) {

        $commenter = wp_get_current_commenter();
        $req      = get_option( 'require_name_email' );
        $html_req = ( $req ? " required='required'" : '' );
        $fields['author']   = '<p class="comment-form-author"><input id="author" name="author" type="text" class="txt" tabindex="1" value="' . sanitize_text_field(esc_attr($commenter['comment_author'])) . '" size="30" maxlength="245"' . $html_req . ' />' . '<label for="author">' . __('Name', 'responsi') . ($req ? ' <span class="required">(' . __('required', 'responsi') . ')</span>' : '') . '</label> ' . '</p>';
        $fields['email']    = '<p class="comment-form-email"><input id="email" name="email" type="text" class="txt" tabindex="2" value="' . sanitize_email(esc_attr($commenter['comment_author_email'])) . '" size="30" maxlength="100" aria-describedby="email-notes"' . $html_req . ' />' . '<label for="email">' . __('Email', 'responsi') . ($req ? ' <span class="required">(' . __('required', 'responsi') . ')</span>' : '') . '</label> ' . '</p>';
        $fields['url']      = '<p class="comment-form-url"><input id="url" name="url" type="text" class="txt" tabindex="3" value="' . esc_url($commenter['comment_author_url']) . '" size="30" maxlength="200" />' . '<label for="url">' . __('Website', 'responsi') . '</label></p>';

        return $fields;

    }
}

/*-----------------------------------------------------------------------------------*/
/* responsi_comment_form_defaults(). */
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'responsi_comment_form_defaults' ) ) {
    function responsi_comment_form_defaults( $args ) {

        $tabindex              = count( $args['fields'] ) + 1;
        $args['comment_field'] = str_replace( '<textarea ', '<textarea tabindex="' . $tabindex . '" ', $args['comment_field'] );

        $tabindex++;

        $args['label_submit']         = __( 'Submit Comment', 'responsi' );
        $args['comment_notes_before'] = '';
        $args['comment_notes_after']  = '';
        $args['cancel_reply_link']    = __( 'Cancel reply', 'responsi' );

        return $args;

    }
}

/*-----------------------------------------------------------------------------------*/
/* responsi_comment_form_defaults(). */
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'responsi_comments_template' ) ) {
    function responsi_comments_template( $args ) {
        global $responsi_options;
        $comm = $responsi_options['responsi_comments'];

        if ( ( 'page' === $comm || 'both' === $comm ) && is_page() ) { 
            comments_template(); 
        }elseif ( ( 'post' === $comm || 'both' === $comm ) && is_single() ) { 
            comments_template(); 
        }
    }
}


/*-----------------------------------------------------------------------------------*/
/* responsi_blog_item_content_shiftclick(). */
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'responsi_blog_item_content_shiftclick' ) ) {

    function responsi_blog_item_content_shiftclick() {
        global $shiftclick;
        echo $shiftclick;
    }

}


/*-----------------------------------------------------------------------------------*/
/* is_blog_template(). */
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'is_blog_template' ) ) {

    function is_blog_template() {
        global $is_blog_template;
        $is_blog_template = false;
        if ( is_page_template( 'template-blog.php' ) ) {
            $is_blog_template = true;
        }
        return $is_blog_template;
    }

}

if ( !function_exists( 'responsi_blog_template_list_post' ) ) {
    function responsi_blog_template_list_post(){
        if(is_blog_template()){
            global $wp_query, $content_column_grid, $count;
            $paged = 1;
            if ( get_query_var( 'paged' ) ) { $paged = get_query_var( 'paged' ); }
            if ( get_query_var( 'page' ) ) { $paged = get_query_var( 'page' ); }
            $paged = intval( $paged );
            $query_args = array(
                'post_type' => 'post',
                'paged' => $paged,
                'ignore_sticky_posts' => true,
                'orderby' => 'post_date',
                'order' => 'DESC'
            );
            $query_args = apply_filters( 'responsi_blog_template_query_args', $query_args );
            $wp_query = new WP_Query( $query_args );
            ?>
            <?php
            if ( have_posts() ) {
                $count = 0;
                ?>
                <div class="clear"></div>
                <div class="box-content col<?php echo esc_attr( $content_column_grid ); ?>">
                    <?php
                    while ( have_posts() ) {
                        the_post();
                        $count++;
                        get_template_part( 'content', get_post_format() );
                    }
                    ?>
                </div>
                <?php
            } else {
                get_template_part( 'content', 'noposts' );
            }
        }
    }
}

/*-----------------------------------------------------------------------------------*/
/* responsi_scrolltop(). */
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'responsi_scrolltop' ) ) {
    function responsi_scrolltop() {
        ?>
        <p id="back-top"><a href="#wrap"><span class="responsi-icon-up"></span></a></p>
        <?php
    }
}

/*-----------------------------------------------------------------------------------*/
/* responsi_custom_display_title(). */
/*-----------------------------------------------------------------------------------*/

function responsi_custom_display_title() {
    global $responsi_custom_meta_type;

    if ( is_home() || is_admin() ) {
        return;
    }

    $responsi_custom_meta = array(
        'hide_title' => 0
    );

    if( is_array($responsi_custom_meta_type) && isset($responsi_custom_meta_type['meta_type']) && 'responsi_custom_meta' === $responsi_custom_meta_type['meta_type'] && isset($responsi_custom_meta_type['post_id']) && $responsi_custom_meta_type['post_id'] >= 1 ){
        $responsi_custom_meta = get_post_meta( $responsi_custom_meta_type['post_id'] , $responsi_custom_meta_type['meta_type'], true );
    }elseif(is_array($responsi_custom_meta_type) && isset($responsi_custom_meta_type['meta_type']) && 'responsi_custom_meta_term' === $responsi_custom_meta_type['meta_type'] && isset($responsi_custom_meta_type['post_id']) && $responsi_custom_meta_type['post_id'] >= 1){
        $responsi_custom_meta = get_term_meta( $responsi_custom_meta_type['post_id'] , $responsi_custom_meta_type['meta_type'], true );
    }
    if ( !is_array( $responsi_custom_meta ) ) {
        return;
    }
    if ( 1 === $responsi_custom_meta['hide_title'] ) {
        ?>
        <style type="text/css">.responsi_title, .custom_box .title.entry-title,body .responsi_title, body .custom_box .title.entry-title,.custom_box .product_title.entry-title{display:none !important;}</style>
        <?php
    }
}

/*-----------------------------------------------------------------------------------*/
/* responsi_site_logo(). */
/*-----------------------------------------------------------------------------------*/

function responsi_site_logo(){
    if( function_exists( 'the_custom_logo' ) && function_exists( 'has_custom_logo' ) && has_custom_logo() ){
        the_custom_logo();
    }else{
        ?>
        <a class="logo site-title" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
        <?php
    }
}

function responsi_filter_get_custom_logo( $html, $blog_id ){
    if( $html === '' ){
         $html = sprintf( '<a href="%1$s" class="custom-logo-link" style="display:none;"><img class="custom-logo"/></a>',
            esc_url( home_url( '/' ) )
        );
    }
    $html = str_replace('custom-logo-link', 'custom-logo-link logo site-logo', $html);
    return $html;
}

/*-----------------------------------------------------------------------------------*/
/* responsi_site_description(). */
/*-----------------------------------------------------------------------------------*/

function responsi_site_description(){
    global $responsi_options;
    $site_description = get_bloginfo('description');
    if ( 'true' === $responsi_options['responsi_enable_site_description'] && '' !== $site_description) {
        echo '<span class="site-description">' . $site_description . '</span>';
    }
}

if ( !function_exists( 'responsi_custom_comment' ) ) {
    function responsi_custom_comment( $comment, $args, $depth ) {
       $GLOBALS['comment'] = $comment; ?>
        <li <?php comment_class(); ?>>
            <a name="comment-<?php comment_ID() ?>"></a>
            <div id="li-comment-<?php comment_ID() ?>" class="comment-container">
                <?php if( 'comment' === get_comment_type() ) { ?>
                    <div class="avatar"><?php responsi_the_commenter_avatar( $args ); ?></div>
                <?php } ?>
                <div class="comment-head">
                    <span class="name"><?php responsi_the_commenter_link() ?></span>
                    <span class="date"><?php echo get_comment_date( get_option( 'date_format' ) ) ?> <?php _e('at', 'responsi'); ?> <?php echo get_comment_time( get_option( 'time_format' ) ); ?></span>
                    <span class="perma"><a href="<?php echo esc_url( get_comment_link() ); ?>" title="<?php _e( 'Direct link to this comment', 'responsi' ); ?>">#</a></span>
                    <span class="edit"><?php edit_comment_link( __( 'Edit', 'responsi' ), '', '' ); ?></span>
                </div>
                <div class="comment-entry"  id="comment-<?php comment_ID(); ?>">
                <?php comment_text() ?>

                <?php if ($comment->comment_approved == '0') { ?>
                    <p class='unapproved'><?php _e('Your comment is awaiting moderation.', 'responsi'); ?></p>
                <?php } ?>
                    <div class="reply">
                        <?php comment_reply_link( array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ) ?>
                    </div>
                </div>
            </div>

    <?php
    }
}

if ( ! function_exists( 'responsi_list_pings' ) ) {
    function responsi_list_pings( $comment, $args, $depth ) {

        $GLOBALS['comment'] = $comment;
        ?>
        <li id="comment-<?php comment_ID(); ?>">
            <span class="author"><?php comment_author_link(); ?></span> -
            <span class="date"><?php echo get_comment_date( get_option( 'date_format' ) ); ?></span>
            <span class="pingcontent"><?php comment_text(); ?></span>
        <?php
    }
}

if ( ! function_exists( 'responsi_the_commenter_link' ) ) {
    function responsi_the_commenter_link() {
        $commenter = get_comment_author_link();
        echo $commenter;
    }
}

if ( ! function_exists( 'responsi_the_commenter_avatar' ) ) {
    function responsi_the_commenter_avatar( $args ) {
        global $comment;
        $avatar = get_avatar( $comment,  $args['avatar_size'] );
        echo $avatar;
    }
}

if ( ! function_exists( 'responsi_sanitize_numeric' ) ) {
    function responsi_sanitize_numeric( $value, $setting ) {
        if ( is_numeric( $value ) ) {
            return sanitize_text_field( $value );
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
                return sanitize_text_field( $value );
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
                return sanitize_text_field( $value );
            }elseif( 'width' === $keys[1] ){
                return sanitize_text_field( $value );
            }
        }
    }
}

if ( ! function_exists( 'responsi_sanitize_border_radius' ) ) {
    function responsi_sanitize_border_radius( $value, $setting ) {
        $keys = preg_split( '/\[/', str_replace( ']', '', $setting->id ) );
        if ( is_array($keys) && count($keys) > 0 && isset($keys[1]) ){
            if( 'corner' === $keys[1] ){
                return sanitize_text_field( $value );
            }elseif( 'rounded_value' === $keys[1] ){
                if ( is_numeric( $value ) ) {
                    return sanitize_text_field( $value );
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
                return sanitize_text_field( $value );
            }elseif( 'h_shadow' === $keys[1] ){
                return sanitize_text_field( $value );
            }elseif( 'v_shadow' === $keys[1] ){
                return sanitize_text_field( $value );
            }elseif( 'blur' === $keys[1] ){
                return sanitize_text_field( $value );
            }elseif( 'spread' === $keys[1] ){
                return sanitize_text_field( $value );
            }elseif( 'inset' === $keys[1] ){
                return sanitize_text_field( $value );
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
                return sanitize_text_field( $value );
            }elseif( 'line_height' === $keys[1] ){
                return sanitize_text_field( $value );
            }elseif( 'face' === $keys[1] ){
                return sanitize_text_field( $value );
            }elseif( 'style' === $keys[1] ){
                return sanitize_text_field( $value );
            }elseif( 'color' === $keys[1] ){
                return sanitize_hex_color( $value );
            }
        }
    }
}

if ( ! function_exists( 'responsi_sanitize_slider' ) ) {
    function responsi_sanitize_slider( $value , $setting ) {
        if ( is_numeric( $value ) ) {
            return (int)$value;
        }
    }
}

if ( ! function_exists( 'responsi_sanitize_choices' ) ) {
    function responsi_sanitize_choices( $value, $setting ) {
        
        $choices = isset ( $setting->manager->get_control( $setting->id )->choices ) ? $setting->manager->get_control( $setting->id )->choices : array() ;

        if( !is_array( $choices) ){
            return sanitize_text_field( $setting->default );
        }

        $value = sanitize_key( $value );

        return ( array_key_exists( $value, $choices ) ? sanitize_text_field( $value ) : sanitize_text_field( $setting->default ) );
    }
}

if ( ! function_exists( 'responsi_sanitize_checkboxs' ) ) {
    function responsi_sanitize_checkboxs( $value, $setting ) {

        $default_choices = array( 
            'checked_value'     => 'true', 
            'unchecked_value'   => 'false', 
            'checked_label'     => __( 'ON', 'responsi' ), 
            'unchecked_label'   => __( 'OFF', 'responsi' ),
            'container_width'   => 80
        );

        $choices = isset ( $setting->manager->get_control( $setting->id )->choices ) ? $setting->manager->get_control( $setting->id )->choices : array() ;

        if( !is_array( $choices ) ){
            $choices = $default_choices;
        }else{
            $choices = array_merge( $default_choices, $choices );
        }

        $value = sanitize_key( $value );

        return ( in_array( $value, $choices ) ? sanitize_text_field( $value ) : sanitize_text_field( $setting->default ) );
    }
}

if ( ! function_exists( 'responsi_sanitize_multicheckboxs' ) ) {
    function responsi_sanitize_multicheckboxs( $value, $setting ) {
        $value = sanitize_key( $value );
        return sanitize_text_field( $value );
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