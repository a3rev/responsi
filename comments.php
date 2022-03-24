<?php
/**
 * Comments Template
 *
 * This template file handles the display of comments, pingbacks and trackbacks.
 *
 * External functions are used to display the various types of comments.
 *
 * @package ResponsiFramework
 * @subpackage Template
 */

// Do not delete these lines
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && 'comments.php' == basename( $_SERVER['SCRIPT_FILENAME'] ) ) { die ( esc_attr__( 'Please do not load this page directly. Thanks!', 'responsi' ) ); }

// Password is required so don't display comments.
if ( post_password_required() ) { ?><p class="nocomments"><?php esc_attr_e( 'This post is password protected. Enter the password to view comments.', 'responsi' ); ?></p><?php return; }

/**
 * Comment Output.
 *
 * This is where our comments display is generated.
 */
$comments_by_type = separate_comments( $comments );

if ( have_comments() ) {

	echo '<div id="comments">';

 	if ( ! empty( $comments_by_type['comment'] ) ) { ?>
	 	<h2 id="comments-title"><?php printf( _n( 'One Response to %2$s', '%1$s Responses to %2$s', (int)get_comments_number(), 'responsi' ), esc_attr(number_format_i18n( (int)get_comments_number() )), '<em>' . esc_html(get_the_title()) . '</em>' ); ?></h2>
	 	<ol class="commentlist">
			<?php
				/* Loop through and list the comments. Tell wp_list_comments()
				 * to use responsi_custom_comment() to format the comments.
				 * If you want to overload this in a child theme then you can
				 * define responsi_custom_comment() and that will be used instead.
				 * See responsi_custom_comment() in /functions/theme-comments.php for more.
				 */
				wp_list_comments( array( 'callback' => 'responsi_custom_comment', 'type' => 'comment', 'avatar_size' => 40 ) );
			?>
		</ol>
	 	<?php
	 	// Comment pagination.
	 	if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) {
	 		?>
			<div class="navigation">
				<div class="nav-previous fl"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'responsi' ) ); ?></div>
				<div class="nav-next fr"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'responsi' ) ); ?></div>
				<div class="clear"></div>
			</div>
			<?php 
		}

	}

	if ( ! empty( $comments_by_type['pings'] ) ) { ?>
	 	<h2 id="comments-title"><?php esc_attr_e( 'Trackbacks/Pingbacks', 'responsi' ); ?></h2>
	 	<ol class="commentlist">
			<?php
				/* Loop through and list the pings. Tell wp_list_comments()
				 * to use responsi_list_pings() to format the pings.
				 * If you want to overload this in a child theme then you can
				 * define responsi_list_pings() and that will be used instead.
				 * See responsi_list_pings() in /functions/theme-comments.php for more.
				 */
				wp_list_comments( array( 'callback' => 'responsi_list_pings', 'type' => 'pings' ) );
			?>
		</ol>
	<?php }

	echo '</div>';

}

/**
 * Respond Form.
 *
 * This is where the comment form is generated.
 */
comment_form(
	array(
		//'logged_in_as'       => null,
		'title_reply'        => esc_html__( 'Leave a comment', 'responsi' ),
		'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title">',
		'title_reply_after'  => '</h2>',
	)
);
?>