<?php
/**
 * Single Post Template
 *
 * This template is the default page template. It is used to display content when someone is viewing a
 * singular view of a post ('post' post_type).
 * @link http://codex.wordpress.org/Post_Types#Post
 *
 * @package ResponsiFramework
 * @subpackage Template
 */
function responsi_tweak_template( $content_column_grid, $wrapper_content_top, $wrapper_content, $layout_column, $content_column, $layout_column_top, $layout_top, $layout ){
    global $layout;
    $layout = 'one-col';
    return $layout;
}
add_filter( 'responsi_layouts', 'responsi_tweak_template', 10, 8 );

function responsi_tweak_template_class( $classes ){
    $classes[] = ' responsi-tweak-sitewidth';
    return $classes;
}

add_filter( 'body_class', 'responsi_tweak_template_class', 11 );
?>
<?php get_header(); ?>
<?php global $main_box, $count; ?>
<?php do_action( 'responsi_content_before' ); ?>
<div id="content" class="content col-full clearfix">
    <?php do_action( 'responsi_main_before' ); ?>
    <div id="main" class="box<?php echo esc_attr( $main_box );?>">
        <?php do_action( 'responsi_main_content_before' ); ?>
        <div id="single-post" <?php esc_attr( post_class() ); ?>>
            <div class="responsi-area responsi-area-post single-ct">
                <?php do_action( 'responsi_loop_before' ); ?>
                <?php
        		if ( have_posts() ) {
                    $count = 0;
                    while ( have_posts() ) { 
                        the_post();
                        $count++;
                        do_action( 'epl_property_single' );
            		}
        		}
                ?>
                <?php do_action( 'responsi_loop_after' ); ?>
            </div>
        </div>
        <?php do_action( 'responsi_main_content_after' ); ?>
    </div>
    <?php do_action( 'responsi_main_after' ); ?>
</div>
<?php do_action( 'responsi_content_after' ); ?>
<?php get_footer(); ?>