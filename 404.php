<?php
/**
 * Page 404
 *
 * @package ResponsiFramework
 * @subpackage Template
 */
?>
<?php get_header(); ?>
<?php global $main_box; ?>
<?php do_action('responsi_content_before'); ?>
<div id="content" class="responsi-content-content col-full clearfix">
    <?php do_action( 'responsi_main_before' ); ?>
    <div id="main" class="box<?php echo esc_attr( $main_box ); ?>">
    <?php do_action( 'responsi_main_content_before' ); ?>
        <div id="single-content" <?php esc_attr( post_class() ); ?>>
            <div class="single_content responsi-area responsi-area-page">
                <?php do_action( 'responsi_loop_before' ); ?>
                <?php do_action( 'responsi_post_before' ); ?>
                <?php do_action( 'responsi_page_title_before' ); ?>
                <?php echo '<h1 class="title entry-title">' .__( "We're so sorry, we can't find that page!", 'responsi' ).'</h1>'; ?>
                <?php do_action( 'responsi_page_title_after' ); ?>
                <div class="clear"></div>
                <div class="entry">
                    <div class="clear"></div>
                    <?php do_action( 'responsi_single_post_content_before' ); ?>
                    <p><?php echo sprintf( __( 'We\'re sorry, we can\'t find the page you are looking for. Perhaps you can return back to the <a href="%s" title="%s">homepage</a> or you can try finding it by using the search form below.', 'responsi' ), esc_url( get_home_url() ), esc_html( get_bloginfo( 'title' ) ) );?></p>
                    <?php get_search_form( true ); ?>
                    <div class="clear"></div>
                    <?php do_action( 'responsi_single_post_content_after' ); ?>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
                <?php do_action( 'responsi_post_after' ); ?>
                <?php do_action( 'responsi_loop_after' );?>
            </div>
        </div>
        <?php do_action( 'responsi_main_content_after' ); ?>
    </div>
    <?php do_action( 'responsi_main_after' ); ?>
</div>
<?php do_action( 'responsi_content_after' ); ?>
<?php get_footer(); ?>