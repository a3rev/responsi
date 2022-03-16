<?php
/**
 * Page Template
 *
 * This template is the default page template. It is used to display content when someone is viewing a
 * singular view of a page ('page' post_type) unless another page template overrules this one.
 * @link http://codex.wordpress.org/Pages
 *
 * @package ResponsiFramework
 * @subpackage Template
 */
?>
<?php get_header(); ?>
<?php global $main_box; ?>
<?php do_action('responsi_content_before'); ?>
<div id="content" class="content col-full clearfix">
    <?php do_action('responsi_main_before'); ?>
    <div id="main" class="box<?php echo esc_attr($main_box);?>">
        <?php do_action('responsi_main_content_before'); ?>
        <div id="single-page" <?php esc_attr(post_class()); ?>>
            <div class="responsi-area responsi-area-page single-ct">
                <?php do_action('responsi_loop_before');?>               
                <?php
                if (have_posts()) {
                    $count = 0;
                    while (have_posts()) {
                        the_post();
                        $count++;
                        get_template_part('content', 'page');
                    }
                }
                ?>  
                <?php do_action('responsi_loop_after');?>
            </div>
        </div>
        <?php do_action('responsi_main_content_after'); ?>
    </div>
    <?php do_action('responsi_main_after'); ?>
</div>
<?php do_action('responsi_content_after'); ?>
<?php get_footer(); ?>