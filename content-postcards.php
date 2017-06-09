<?php
/**
 * Post cards Content Template
 *
 * This template is the default page content template. It is used to display the content of the
 * `single.php` template file, contextually, as well as in archive lists or search results.
 *
 * @package ResponsiFramework
 * @subpackage Template
 */
?>
<?php
$cats = get_the_category_list( ', ' . ' ' );
$cats = str_replace( '<li>', '<span>', $cats );
$cats = str_replace( '</li>', '</span>', $cats );
$class= 'box-item';
$image = '<a href="'. esc_url( get_permalink() ).'">'.responsi_get_thumbnail( 'return=true&type=image').'</a>';
$title = substr( get_the_title(), 0, 100 );
if( $title === get_the_title() ){
    $title = $title;
}else{
    $title = $title.' ...';
}
?>
<div class="blog-post entry <?php echo esc_attr( $class ); ?>">
    <?php do_action( 'responsi_blog_item_before' ); ?>
    <div class="entry-item blog-post-item">
        <?php do_action( 'responsi_blog_item_content_before' ); ?>
        <div class="thumbnail_container">
            <?php do_action( 'responsi_blog_item_content_thumbnail_before' ); ?>
            <div class="thumbnail"><?php echo $image;?></div>
            <?php do_action( 'responsi_blog_item_content_thumbnail_after' ); ?>
        </div>
        <div class="content_container">
            <?php do_action( 'responsi_archive_post_title_item_before' ); ?>
            <h3><a title="<?php echo esc_html( get_the_title() ); ?>" href="<?php echo esc_url( get_permalink() ); ?>"><?php echo $title;?></a></h3>
            <?php do_action( 'responsi_archive_post_title_item_after' ); ?>
            <div class="entry-content">
              <div class="bottom-bg">
                <div class="excerpt"><?php the_excerpt();?></div>
              </div>
            </div>
        </div>
        <div class="clear"></div>
        <div class="entry-bottom">
            <div class="postinfo"><div class="custom_lines"><?php echo apply_filters( 'responsi_post_author_posts_card_link', '', array( 'before' => '<span class="i_author">By ', 'after' => '</span> <span class="i_in">in</span>' ) );?><?php if($cats) echo '<span class="i_cat">'.$cats.'</span>';?></div></div>
            <div class="posttags">
                <div class="custom_lines">
                <?php
                $tags = get_the_tags( get_the_ID() );
                $html = '';
                if( $tags ){
                    $html = '<span class="i_tag"><span class="i_tag_text">'.__( 'Tagged', 'responsi' ).'</span><span>';
                    $note = '';
                    foreach ( $tags as $tag ){
                        $tag_link = get_tag_link( $tag->term_id ) ;
                        $html .= $note;
                        $html .= '<span><a href="'. esc_url( $tag_link ).'" title="'.$tag->name.' Tag" class="'. esc_attr( $tag->slug) .'">';
                        $html .= $tag->name.'</a></span>';
                        $note = ', ';
                    }
                    $html .= '</span></span>';
                }
                ?>
                <span class="i_comment"><a href="<?php comments_link(); ?>"><?php comments_number( 'No Comment', '1 Comment', '% Comments' ); ?></a></span> <?php echo ' '.$html;?>
                </div>
            </div>
        </div>
        <?php do_action( 'responsi_blog_item_content_after' ); ?>
    </div>
    <?php do_action( 'responsi_blog_item_after' ); ?>
</div>