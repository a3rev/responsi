<?php
/*-----------------------------------------------------------------------------------*/
/* Register widgetized areas */
/*-----------------------------------------------------------------------------------*/
if ( !function_exists('responsi_widgets_init') ) {
	function responsi_widgets_init() {
	    if ( !function_exists('register_sidebars') ){
	        return;
	    }

	    global $responsi_options;
	    
	    $widget_animation_class = '';
        $widget_animation_data = '';
        $widget_animation_style = '';

	    if( is_array($responsi_options) && isset( $responsi_options['responsi_widget_animation'] ) ){

	    	$widget_animation = responsi_generate_animation($responsi_options['responsi_widget_animation']);

            if( false !== $widget_animation ){
                $widget_animation_class = ' '.$widget_animation['class'];
                $widget_animation_data = ' data-animation="'.$widget_animation['data'].'"';
                $widget_animation_style = ' style="'.$widget_animation['style'].'"';
            }
        }

	    do_action('responsi_widgets_init_before');

		//Sidebars
		do_action( 'the_widgets_sidebar_init_before' );
		register_sidebar( array( 'name' => __( 'Primary', 'responsi' ),'id' => 'primary', 'description' => __( 'Normal full width Sidebar', 'responsi' ), 'before_widget' => '<div id="%1$s" class="msr-wg'.$widget_animation_class.'"'.$widget_animation_data . $widget_animation_style.'><div class="widget widget_content %2$s"><div class="widget-content clearfix">', 'after_widget' => '</div></div></div>', 'before_title' => '</div><div class="widget-title clearfix">', 'after_title' => '</div><div class="widget-content clearfix">' ) );
	    register_sidebar( array( 'name' => __( 'Secondary', 'responsi' ), 'id' => 'secondary', 'description' => __( 'Secondary sidebar for use in three column layout', 'responsi' ), 'before_widget' => '<div id="%1$s" class="msr-wg'.$widget_animation_class.'"'.$widget_animation_data . $widget_animation_style.'><div class="widget widget_content %2$s"><div class="widget-content clearfix">', 'after_widget' => '</div></div></div>', 'before_title' => '</div><div class="widget-title clearfix">', 'after_title' => '</div><div class="widget-content clearfix">' ) );

	    do_action( 'the_widgets_sidebar_init_after' );

		// Header widgetized area
		do_action( 'the_widgets_header_init_before' );

		$total = 6;
		if ( !$total ){
			$total = 6;
		}
		$i = 0;
		while ( $i < $total ) : $i++;
			register_sidebar( array( 'name' => __( 'Header', 'responsi' )." {$i}", 'id' => 'header-'.$i, 'description' => __( 'Widgetized header', 'responsi' ), 'before_widget' => '<div id="%1$s" class="msr-wg msr-wg-header"><div class="widget %2$s"><div class="widget-content clearfix">', 'after_widget' => '</div></div></div>', 'before_title' => '</div><div class="widget-title clearfix">', 'after_title' => '</div><div class="widget-content clearfix">' ) );
		endwhile;

		do_action( 'the_widgets_header_init_after' );

		do_action( 'the_widgets_footer_init_before' );

		// Footer widgetized area
		$total = 6;
		if ( !$total ){
			$total = 6;
		}
		$i = 0; 
		while ( $i < $total ) : $i++;
			register_sidebar( array( 'name' => __( 'Footer', 'responsi' )." {$i}", 'id' => 'footer-'.$i, 'description' => __( 'Widgetized footer', 'responsi' ), 'before_widget' => '<div id="%1$s" class="msr-wg msr-wg-footer"><div class="widget %2$s"><div class="widget-content clearfix">', 'after_widget' => '</div></div></div>', 'before_title' => '</div><div class="widget-title clearfix">', 'after_title' => '</div><div class="widget-content clearfix">' ) );
		endwhile;

		do_action( 'the_widgets_footer_init_after' );

		do_action( 'responsi_widgets_init_after' );

	}
}

add_action( 'widgets_init', 'responsi_widgets_init' );

function responsi_widget_title( $widget_title ){

	if( is_admin() ) return $widget_title;

	if( !empty( $widget_title ) ){
		return '<h3>' . $widget_title .'</h3>';
	}
	
	return $widget_title;

}

add_filter( 'widget_title', 'responsi_widget_title', 99 );
?>