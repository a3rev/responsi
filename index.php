<?php
/**
 * Index Template
 *
 * The index template is a placeholder for all cases that don't have a template file.
 * Ideally, all fases would be handled by a more appropriate template according to the
 * current page context (for example, `tag.php` for a `post_tag` archive or `single.php`
 * for a single blog post).
 *
 * @package ResponsiFramework
 * @subpackage Template
 */
?>
<?php get_header(); ?> 
<?php global $main_box; ?>
<?php do_action( 'responsi_content_before' ); ?>
<div id="content" class="responsi-content-content col-full clearfix">
    <?php do_action( 'responsi_main_before' ); ?>
    <div id="main" class="box<?php echo esc_attr( $main_box ) ;?>">
        <?php do_action( 'responsi_main_content_before' ); ?>
        <?php get_template_part( 'loop', 'index' ); ?>
        <?php do_action( 'responsi_main_content_after' ); ?>
    </div>
    <?php do_action( 'responsi_main_after' ); ?>
</div>
<?php do_action( 'responsi_content_after' ); ?>
<?php get_footer(); ?>