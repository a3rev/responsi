<?php
/**
 * Archive Template
 *
 * The archive template is a placeholder for archives that don't have a template file.
 * Ideally, all archives would be handled by a more appropriate template according to the
 * current page context (for example, `tag.php` for a `post_tag` archive).
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
<?php global $main_box; ?>
<?php do_action( 'responsi_content_before' ); ?>
<div id="content" class="content col-full clearfix">
    <?php do_action( 'responsi_main_before' ); ?>
    <div id="main" class="box<?php echo esc_attr( $main_box ); ?> main-archive-ctn">
    	<?php do_action( 'responsi_main_content_before' ); ?>
        <?php do_action( 'epl_property_blog' ); ?>
        <?php do_action( 'responsi_main_content_after' ); ?>
    </div>
    <?php do_action( 'responsi_main_after' ); ?>
</div>
<?php do_action( 'responsi_content_after' ); ?>
<?php get_footer(); ?>