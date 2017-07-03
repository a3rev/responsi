<?php
/**
 * Loop - Archive
 *
 * This is the loop logic used on all archive screens.
 *
 * To override this loop in a particular archive type (in all categories, for example),
 * duplicate the `archive.php` file and rename the duplicate to `category.php`.
 * In the code of `category.php`, change `get_template_part( 'loop', 'archive' );` to
 * `get_template_part( 'loop', 'category' );` and save the file.
 *
 * Create a duplicate of this file and rename it to `loop-category.php`.
 * Make any changes to this new file and they will be reflected on all your category screens.
 *
 * @package ResponsiFramework
 * @subpackage Template
 */
?>
<?php global $content_column_grid, $count; ?>
<div class="custom_box custom_box_archive responsi_title">
	<?php do_action( 'responsi_loop_before' ); ?>
	<?php responsi_archive_title( '<span class="archive_header"><h1 class="title entry-title">', '</h1></span>', true ); ?>
	<?php if ( category_description() ) : ?>
		<div class="page-description archive-description clearfix"><?php echo category_description(); ?></div>
	<?php endif; ?>
</div>
<?php
if ( have_posts() ) {
	$count = 0;
	?>
	<div class="clear"></div>
		<div class="box-content col<?php echo esc_attr( $content_column_grid );?>">
		<?php
		while ( have_posts() ) {
			the_post();
			$count++;
			get_template_part( 'content', get_post_format() );
		}
		?>
	</div>
	<?php
} else {
	get_template_part( 'content', 'noposts' );
}
?>
<?php do_action( 'responsi_loop_after' ); ?>