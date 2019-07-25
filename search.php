<?php
/**
 * Search Template
 *
 * The search template is used to display search results from the native WordPress search.
 *
 * If no search results are found, the user is assisted in refining their search query in
 * an attempt to produce an appropriate search results set for the user's search query.
 *
 * @package ResponsiFramework
 * @subpackage Template
 */
?>
<?php get_header(); ?>
<?php global $main_box; ?>
<?php do_action( 'responsi_content_before' ); ?>
<div id="content" class="responsi-content-content col-full page">
 	<?php do_action( 'responsi_main_before' ); ?>
	<div id="main" class="box<?php echo esc_attr( $main_box );?> archive-container">
  		<?php do_action( 'responsi_main_content_before' ); ?>
    	<?php get_template_part( 'loop', 'search' ); ?>
  		<?php do_action( 'responsi_main_content_after' ); ?>
  	</div>
  	<?php do_action( 'responsi_main_after' ); ?>
</div>
<?php do_action( 'responsi_content_after' ); ?>
<?php get_footer(); ?>