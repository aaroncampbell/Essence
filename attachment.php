<?php
/**
 * The template for displaying attachments.
 *
 * @since 0.0.1
 */
essence_show_template_file( __FILE__ );

get_header();
?>

		<div id="content" class="single-attachment columns eight" role="main">

			<?php
			/* Run the loop to output the attachment.
			 * If you want to overload this in a child theme then include a file
			 * called loop-attachment.php and that will be used instead.
			 */
			get_template_part( 'loop', 'attachment' );
			?>

		</div><!-- #content -->

<?php
get_sidebar();
get_footer();
