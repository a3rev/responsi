<?php
/**
 * Loop - Search
 *
 * This is the loop logic used on the search results screen.
 *
 * @package ResponsiFramework
 * @subpackage Template
 */
?>

<?php global $content_column_grid; ?>
<div class="responsi-area responsi-area-archive responsi_title">
    <?php do_action('responsi_loop_before');?>
    <?php do_action('responsi_search_title');?>
</div>
<div class="clear"></div>
<?php
if (have_posts()) {
    $count = 0;
    ?>
    <div id="search_container" class="box-content col<?php echo esc_attr($content_column_grid);?>">
    <?php
    while (have_posts()) {
        the_post();
        $count++;
        get_template_part('content', 'post');
    }
    ?>
    </div>
    <?php
} else {
    get_template_part('content', 'noposts');
}
?>
<?php do_action('responsi_loop_after'); ?>