<?php
global $wp_embed;

if ( ! isset( $content_width ) ){
    $content_width = 900;
}

if ( !is_admin() ) {
    if( function_exists( 'wp_make_content_images_responsive' ) ){
        add_filter( 'a3_lazy_load_html', 'wp_make_content_images_responsive' );
    }
}

add_filter( 'responsi_autoembed_media', array( 
	$wp_embed, 
	'run_shortcode' 
), 8 );

add_filter( 'responsi_autoembed_media', array(
    $wp_embed,
    'autoembed'
), 8 );

add_filter( 'widget_text', array( 
	$wp_embed, 
	'run_shortcode' 
), 8 );

add_filter( 'widget_text', array( 
	$wp_embed, 
	'autoembed' 
), 8 );

//add_action( 'responsi_wrapper_container_before', 'responsi_embed_ob_start', 0 );
//add_action( 'responsi_wrapper_container_after', 'responsi_embed_ob_end_flush', 999 );
add_filter( 'media_view_settings', 'responsi_filter_media_view_settings', 10 , 2 );
add_filter( 'extra_theme_headers', 'responsi_extra_theme_headers' );
add_filter( 'body_class', 'responsi_body_class', 10 );
add_filter( 'get_custom_logo', 'responsi_filter_get_custom_logo', 10, 2 );
add_filter( 'the_excerpt', 'responsi_custom_excerpt_more' );
add_filter( 'excerpt_more', 'responsi_excerpt_more' );
add_filter( 'comment_form_field_comment', 'responsi_comment_form_field_comment', 10 );
add_filter( 'comment_form_default_fields', 'responsi_comment_form_default_fields', 10 );
add_filter( 'comment_form_defaults', 'responsi_comment_form_defaults', 10 );
add_filter( 'responsi_archive_title', 'responsi_archive_title_rss_links', 3, 10 );
add_filter( 'responsi_blog_template_query_args', 'responsi_categories_blogtemplate_excluded', 10 );
add_filter( 'responsi_post_author_posts_card_link', 'responsi_post_author_posts_link', 10, 2 );

add_action( 'wp', 'responsi_404_redirect', 1 );
add_action( 'init', 'responsi_get_post_types' );
add_action( 'init', 'responsi_filter_image_rss' );
add_action( 'wp_head', 'responsi_custom_display_title' );
add_action( 'responsi_meta', 'responsi_meta_tags', 1 );
add_action( 'responsi_head', 'responsi_layout_class' );
add_action( 'responsi_head', 'is_blog_template', 10 );
add_action( 'responsi_head', 'responsi_add_pagination_links', 10 );
add_action( 'responsi_wrapper_nav_content', 'responsi_navigation', 10 );
add_action( 'responsi_loop_before', 'responsi_breadcrumbs', 10 );
add_action( 'responsi_loop_after', 'responsi_blog_template_list_post' );
add_action( 'responsi_main_before', 'responsi_get_sidebar_main_before', 1 );
add_action( 'responsi_main_after', 'responsi_get_sidebar_main_after', 99 );
add_action( 'responsi_main_content_before', 'responsi_main_wrap_before' );
add_action( 'responsi_main_content_after', 'responsi_main_wrap_after' );
add_action( 'responsi_wrapper_header_content', 'responsi_wrapper_header_content', 10 );
add_action( 'responsi_post_meta', 'responsi_single_post_meta' );
add_action( 'responsi_post_after', 'responsi_comments_template' );
add_action( 'responsi_blog_item_content_before', 'responsi_blog_item_content_shiftclick', 10 );
add_action( 'responsi_archive_post_title_item_after', 'responsi_archive_post_date');
add_action( 'responsi_single_post_content_after', 'responsi_single_post_meta_categories_default', 10 );
add_action( 'responsi_single_post_content_after', 'responsi_single_post_meta_tags_default', 10 );
add_action( 'responsi_wrapper_footer_before', 'responsi_footer_sidebars' );
add_action( 'responsi_wrapper_footer_content', 'responsi_wrapper_footer_content' );
add_action( 'responsi_wrapper_footer_additional', 'responsi_footer_additional' );
add_action( 'responsi_wrapper_footer_content_copyright', 'responsi_footer_copyright' );
add_action( 'responsi_wrapper_footer_content_credit', 'responsi_footer_credit' );
add_action( 'wp_footer', 'responsi_scrolltop', 99 );

?>