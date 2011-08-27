<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.  The actual display of comments is
 * handled by a callback to essence_comment which is
 * located in the functions.php file.
 *
 * @since 0.0.1
 */
if ( WP_DEBUG && !empty( $_REQUEST['debug'] ) ) {
	if ( 'show' != $_REQUEST['debug'] ) {
		echo '<!-- ';
	}
	esc_html_e( 'Theme File: ' . __FILE__ );
	if ( 'show' != $_REQUEST['debug'] ) {
		echo ' -->';
	}
}

?>

			<div id="comments">
<?php
if ( post_password_required() ) {
?>
				<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'essence' ); ?></p>
			</div><!-- #comments -->
<?php
		/* Stop the rest of comments.php from being processed,
		 * but don't kill the script entirely -- we still have
		 * to fully load the template.
		 */
		return;
}

if ( have_comments() ) {
?>
			<h3 id="comments-title"><?php
				printf( _n( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'essence' ),
					number_format_i18n( get_comments_number() ), '<em>' . get_the_title() . '</em>' );
			?></h3>

	<?php
	if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) { // Are there comments to navigate through?
	?>
			<div class="navigation">
				<div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'essence' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'essence' ) ); ?></div>
			</div> <!-- .navigation -->
	<?php
	} // check for comment navigation
	?>

			<ol class="commentlist">
				<?php
					/* Loop through and list the comments. Tell wp_list_comments()
					 * to use essence_comment() to format the comments.
					 * If you want to overload this in a child theme then you can
					 * define essence_comment() and that will be used instead.
					 * See essence_comment() in essence/functions.php for more.
					 */
					wp_list_comments( array( 'callback' => 'essence_comment' ) );
				?>
			</ol>

	<?php
	if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) { // Are there comments to navigate through?
	?>
			<div class="navigation">
				<div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'essence' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'essence' ) ); ?></div>
			</div><!-- .navigation -->
<?php
	} // check for comment navigation
} // end have_comments()

$comment_form_args = array(
	'comment_notes_after' => '<p>' . __( '<strong>Note</strong>: If you are replying to another commenter, click the "Reply to {NAME} &crarr;" button under their comment!', 'essence' ) . '</p>'
);
comment_form( $comment_form_args );
?>

</div><!-- #comments -->
