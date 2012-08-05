<?php
if ( get_the_author_meta( 'description' ) ) { // If a user has filled out their description, show a bio on their entries
?>
<div id="entry-author-info" class="info">
	<div id="author-avatar">
		<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'essence_author_bio_avatar_size', 60 ) ); ?>
	</div><!-- #author-avatar -->
	<div id="author-description">
		<h2><?php printf( esc_attr__( 'About %s', 'essence' ), get_the_author() ); ?></h2>
		<?php the_author_meta( 'description' ); ?>
		<div id="author-link">
			<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" rel="author">
				<?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>', 'essence' ), get_the_author() ); ?>
			</a>
		</div><!-- #author-link	-->
	</div><!-- #author-description -->
</div><!-- #entry-author-info -->
<?php
}
