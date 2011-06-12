<?php
/**
 * The loop that displays posts.
 *
 * The loop displays the posts and the post content.  See
 * http://codex.wordpress.org/The_Loop to understand it and
 * http://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 *
 * This can be overridden in child themes with loop.php or
 * loop-template.php, where 'template' is the loop context
 * requested by a template. For example, loop-index.php would
 * be used if it exists and we ask for the loop with:
 * <code>get_template_part( 'loop', 'index' );</code>
 *
 * @since 0.0.1
 */
if ( !empty( $_REQUEST['debug'] ) ) {
	if ( 'show' != $_REQUEST['debug'] ) {
		echo '<!-- ';
	}
	esc_html_e( 'Theme File: ' . __FILE__ );
	if ( 'show' != $_REQUEST['debug'] ) {
		echo ' -->';
	}
}

/* Display navigation to next/previous pages when applicable */
if ( $wp_query->max_num_pages > 1 ) {
?>
	<div id="nav-above" class="navigation">
		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'essence' ) ); ?></div>
		<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'essence' ) ); ?></div>
	</div><!-- #nav-above -->
<?php
}


/* If there are no posts to display, such as an empty archive page */
if ( ! have_posts() ) {
?>
	<div id="post-0" class="post error404 not-found">
		<h1 class="entry-title"><?php _e( 'Not Found', 'essence' ); ?></h1>
		<div class="entry-content">
			<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'essence' ); ?></p>
			<?php get_search_form(); ?>
		</div><!-- .entry-content -->
	</div><!-- #post-0 -->
<?php
}

	/**
	 * Start the Loop.
	 */
while ( have_posts() ) {
	the_post();

/* How to display posts of the Gallery format. The gallery category is the old way. */

	if ( 'gallery' == get_post_format( $post->ID ) || in_category( _x( 'gallery', 'gallery category slug', 'essence' ) ) ) {
?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'essence' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

			<div class="entry-meta">
				<?php essence_posted_on(); ?>
			</div><!-- .entry-meta -->

			<div class="entry-content">
<?php
		if ( post_password_required() ) {
			the_content();
		} else {
			$images = get_children( array( 'post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC', 'numberposts' => 999 ) );
			if ( $images ) {
				$total_images = count( $images );
				$image = array_shift( $images );
				$image_img_tag = wp_get_attachment_image( $image->ID, 'thumbnail' );
				?>
						<div class="gallery-thumb">
							<a class="size-thumbnail" href="<?php the_permalink(); ?>"><?php echo $image_img_tag; ?></a>
						</div><!-- .gallery-thumb -->
						<p><em><?php printf( _n( 'This gallery contains <a %1$s>%2$s photo</a>.', 'This gallery contains <a %1$s>%2$s photos</a>.', $total_images, 'essence' ),
								'href="' . get_permalink() . '" title="' . sprintf( esc_attr__( 'Permalink to %s', 'essence' ), the_title_attribute( 'echo=0' ) ) . '" rel="bookmark"',
								number_format_i18n( $total_images )
							); ?></em></p>
				<?php
			}
			the_excerpt();
		}
?>
			</div><!-- .entry-content -->

			<div class="entry-utility">
			<?php if ( 'gallery' == get_post_format( $post->ID ) ) { ?>
				<a href="<?php echo get_post_format_link( 'gallery' ); ?>" title="<?php esc_attr_e( 'View Galleries', 'essence' ); ?>"><?php _e( 'More Galleries', 'essence' ); ?></a>
				<span class="meta-sep">|</span>
			<?php } elseif ( in_category( _x( 'gallery', 'gallery category slug', 'essence' ) ) ) { ?>
				<a href="<?php echo get_term_link( _x( 'gallery', 'gallery category slug', 'essence' ), 'category' ); ?>" title="<?php esc_attr_e( 'View posts in the Gallery category', 'essence' ); ?>"><?php _e( 'More Galleries', 'essence' ); ?></a>
				<span class="meta-sep">|</span>
			<?php } ?>
				<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'essence' ), __( '1 Comment', 'essence' ), __( '% Comments', 'essence' ) ); ?></span>
				<?php edit_post_link( __( 'Edit', 'essence' ), '<span class="meta-sep">|</span> <span class="edit-link">', '</span>' ); ?>
			</div><!-- .entry-utility -->
		</div><!-- #post-## -->

<?php /* How to display posts of the Aside format. The asides category is the old way. */ ?>

	<?php } elseif ( 'aside' == get_post_format( $post->ID ) || in_category( _x( 'asides', 'asides category slug', 'essence' ) )  ) { ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<?php if ( is_archive() || is_search() ) { // Display excerpts for archives and search. ?>
			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->
		<?php } else { ?>
			<div class="entry-content">
				<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'essence' ) ); ?>
			</div><!-- .entry-content -->
		<?php } ?>

			<div class="entry-utility">
				<?php essence_posted_on(); ?>
				<span class="meta-sep">|</span>
				<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'essence' ), __( '1 Comment', 'essence' ), __( '% Comments', 'essence' ) ); ?></span>
				<?php edit_post_link( __( 'Edit', 'essence' ), '<span class="meta-sep">|</span> <span class="edit-link">', '</span>' ); ?>
			</div><!-- .entry-utility -->
		</div><!-- #post-## -->

<?php /* How to display all other posts. */ ?>

	<?php } else { ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'essence' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

			<div class="entry-meta">
				<?php essence_posted_on(); ?>
			</div><!-- .entry-meta -->

	<?php if ( is_archive() || is_search() ) { // Only display excerpts for archives and search. ?>
			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->
	<?php } else { ?>
			<div class="entry-content">
				<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'essence' ) ); ?>
				<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'essence' ), 'after' => '</div>' ) ); ?>
			</div><!-- .entry-content -->
	<?php } ?>

			<div class="entry-utility">
				<?php if ( count( get_the_category() ) ) { ?>
					<span class="cat-links">
						<?php printf( __( '<span class="%1$s">Posted in</span> %2$s', 'essence' ), 'entry-utility-prep entry-utility-prep-cat-links', get_the_category_list( ', ' ) ); ?>
					</span>
					<span class="meta-sep">|</span>
				<?php } ?>
				<?php
					$tags_list = get_the_tag_list( '', ', ' );
					if ( $tags_list ) {
				?>
					<span class="tag-links">
						<?php printf( __( '<span class="%1$s">Tagged</span> %2$s', 'essence' ), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list ); ?>
					</span>
					<span class="meta-sep">|</span>
				<?php } ?>
				<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'essence' ), __( '1 Comment', 'essence' ), __( '% Comments', 'essence' ) ); ?></span>
				<?php edit_post_link( __( 'Edit', 'essence' ), '<span class="meta-sep">|</span> <span class="edit-link">', '</span>' ); ?>
			</div><!-- .entry-utility -->
		</div><!-- #post-## -->

		<?php comments_template( '', true ); ?>

	<?php } // This was the if statement that broke the loop into three parts based on categories. ?>

<?php } // End the loop. Whew. ?>

<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php if (  $wp_query->max_num_pages > 1 ) { ?>
				<div id="nav-below" class="navigation">
					<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'essence' ) ); ?></div>
					<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'essence' ) ); ?></div>
				</div><!-- #nav-below -->
<?php }
