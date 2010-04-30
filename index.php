<?php

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty Ten
 * @since 3.0.0
 */

?>

<?php get_header(); ?>

    <div id="content-container" class="span-15">
        <div id="content">
			<?php do_action( 'essence_content_open' ); ?>

        <?php
        /* Run the loop to output the posts.
         * If you want to overload this in a child theme then include a file
         * called loop-index.php and that will be used instead.
         */
         get_template_part( 'loop', 'index' );
        ?>
        </div><!-- #content -->
    </div><!-- #content-container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
