<?php
/**
 * The template for displaying Author Archive pages.
 *
 * @since 0.0.1
 */
essence_show_template_file( __FILE__ );

get_header();
?>

		<div id="content" class="columns eight" role="main">

<?php
	/* Queue the first post, that way we know who
	 * the author is when we try to get their name,
	 * URL, description, avatar, etc.
	 *
	 * We reset this later so we can run the loop
	 * properly with a call to rewind_posts().
	 */
	if ( have_posts() )
		the_post();

	// If a user has filled out their description, show a bio on their entries.
	if ( get_the_author_meta( 'description' ) ) {
?>
					<div id="entry-author-info" class="rounded-box">
						<div id="author-avatar">
							<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'essence_author_bio_avatar_size', 60 ) ); ?>
						</div><!-- #author-avatar -->
						<div id="author-description">
							<h1><?php the_author(); ?></h1>
							<?php
								the_author_meta( 'description' );
								$contact_links = array();
								foreach( _wp_get_user_contactmethods() as $method => $name ) {
									$contact_method = get_the_author_meta( $method );
									if ( $contact_method )
										$contact_links[] = '<a href="' . esc_url($contact_method) . '" class="contact_method_' . esc_attr( $method ) . '" rel="me">' . esc_html( $name ) . '</a>';
								}
								if ( ! empty( $contact_links ) ) {
									?>
									<br />
									<br />
									<strong>Find me on:</strong>
									<ul class="author-contact">
										<li><?php echo implode( '</li><li>', $contact_links ); ?></li>
									</ul>
									<?php
								}
							?>
						</div><!-- #author-description	-->
					</div><!-- #entry-author-info -->
<?php
	}

	/* Since we called the_post() above, we need to
	 * rewind the loop back to the beginning that way
	 * we can run the loop properly, in full.
	 */
	rewind_posts();

	do_action( 'essence_content_open' );
	essence_content_nav( 'nav-above' );

	/* Run the loop for the author archive page to output the authors posts
	 * If you want to overload this in a child theme then include a file
	 * called loop-author.php and that will be used instead.
	 */
	get_template_part( 'loop', 'author' );
	essence_content_nav( 'nav-below' );
?>
		</div><!-- #content -->

<?php
get_sidebar();
get_footer();
