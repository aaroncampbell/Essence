<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @since 0.0.1
 */
essence_show_template_file( __FILE__ );

get_header();
?>

	<div id="content" class="columns eight" role="main">
		<div id="post-0" class="post error404 not-found">
			<h1 class="entry-title"><?php _e( 'Not Found', 'essence' ); ?></h1>
			<div class="entry-content">
				<p><?php _e( 'Apologies, but the page you requested could not be found. Perhaps searching will help.', 'essence' ); ?></p>
				<?php get_search_form(); ?>
			</div><!-- .entry-content -->
		</div><!-- #post-0 -->

	</div><!-- #content -->
	<script type="text/javascript">
		// focus on search field after it has loaded
		document.getElementById('s') && document.getElementById('s').focus();
	</script>

<?php
get_sidebar();
get_footer();
