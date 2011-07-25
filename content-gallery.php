<?php
/**
 * The template for display posts of the gallery type
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
