<?php
/**
 * The Template used to display all single posts
 *
 * @since 0.0.1
 */
?>

<?php get_header(); ?>

		<div id="content-container" class="span-15">
			<div id="content">

			<?php
			/* Run the loop to output the post.
			 * If you want to overload this in a child theme then include a file
			 * called loop-single.php and that will be used instead.
			 */
			get_template_part( 'loop', 'single' );
			?>

			</div><!-- #content -->
		</div><!-- #ccontent-ontainer -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
