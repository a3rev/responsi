<?php
/**
 * Template Name: Blog
 * Template Post Type: post, page, product
 *
 * The blog page template displays the "blog-style" template on a sub-page or post.
 *
 * @package ResponsiFramework
 * @subpackage Template
 */
?>
<?php get_header(); ?>
<?php global $main_box, $count; ?>
<?php do_action( 'responsi_content_before' ); ?>
<div id="content" class="content col-full clearfix">
    <?php do_action( 'responsi_main_before' ); ?>
    <div id="main" class="box<?php echo esc_attr( $main_box );?> main-archive-ctn">
        <?php do_action( 'responsi_main_content_before' ); ?>
		<div class="responsi-area responsi-area-archive responsi_title">
			<?php do_action( 'responsi_loop_before' ); ?>
			<?php
		    if ( have_posts() ) { 
		        $count = 0;
		        while ( have_posts() ) { 
		            the_post();
		            $count++;
		            ?>
		            <?php the_title( '<span class="archive_header"><h1 class="title entry-title">', '</h1></span>' ); ?>
		            <div class="page-description clearfix"><?php the_content() ;?></div>
		            <?php
		        }
		    }
		    ?>  
		</div>
		<?php do_action( 'responsi_loop_after' ); ?>
        <?php do_action( 'responsi_main_content_after' ); ?>
    </div>
    <?php do_action( 'responsi_main_after' ); ?>
</div>
<?php do_action( 'responsi_content_after' ); ?>
<?php get_footer(); ?>