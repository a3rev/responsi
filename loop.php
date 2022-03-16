<?php
/**
 * Loop
 *
 * This is the default loop file, containing the looping logic for use in all templates
 * where a loop is required.
 *
 * To override this loop in a particular context (in all archives, for example), create a
 * duplicate of this file and rename it to `loop-archive.php`. Make any changes to this
 * new file and they will be reflected on all your archive screens.
 *
 * @package ResponsiFramework
 * @subpackage Template
 */
?>
<?php global $count; ?>
<?php do_action('responsi_loop_before');?>
<?php
if (have_posts()) {
    $count = 0;
    ?>
    <div class="clear"></div>
    <?php
    while (have_posts()) {
        the_post();
        $count++;
        get_template_part('content', get_post_format());
    }
} else {
    get_template_part('content', 'noposts');
}
?>
<?php do_action('responsi_loop_after'); ?>