<?php
/**
 * Page Content Template
 *
 * This template is the default page content template. It is used to display the content of the
 * `page.php` template file, contextually, as well as in archive lists or search results.
 *
 * @package ResponsiFramework
 * @subpackage Template
 */
?>
<?php do_action( 'responsi_post_before' ); ?>
<?php do_action( 'responsi_page_title_before' ); ?>
<?php do_action( 'responsi_page_title' ); ?>
<?php do_action( 'responsi_page_title_after' ); ?>
<div class="entry-content clearfix">
  	<?php do_action( 'responsi_single_post_content_before' ); ?>
  	<?php the_content( __('Continue Reading &rarr;', 'responsi') ); ?>
    <?php do_action( 'responsi_single_post_content_after' ); ?>
</div>
<?php $page_link_args = apply_filters( 'responsi_pagelinks_args', array( 'before' => '<div class="page-link">' . __( 'Pages:', 'responsi' ), 'after' => '</div>' ) ); ?>
<?php wp_link_pages( $page_link_args ); ?>
<?php do_action( 'responsi_post_after' ); ?>