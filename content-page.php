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
<?php the_title( '<h1 class="title entry-title">', '</h1>' ); ?>
<?php do_action( 'responsi_page_title_after' ); ?>
<div class="clear"></div>
<div class="entry">
  	<div class="clear"></div>
  	<?php do_action( 'responsi_single_post_content_before' ); ?>
  	<?php the_content( __('Continue Reading &rarr;', 'responsi') ); ?>
  	<div class="clear"></div>
    <?php do_action( 'responsi_single_post_content_after' ); ?>
    <div class="clear"></div>
</div>
<div class="clear"></div>
<?php $page_link_args = apply_filters( 'responsi_pagelinks_args', array( 'before' => '<div class="page-link">' . __( 'Pages:', 'responsi' ), 'after' => '</div>' ) ); ?>
<?php wp_link_pages( $page_link_args ); ?>
<?php do_action( 'responsi_post_after' ); ?>