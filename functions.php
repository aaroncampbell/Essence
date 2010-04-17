<?php
define('PARENT_URL', get_bloginfo('template_directory'));
define('CHILD_URL', get_bloginfo('stylesheet_directory'));
define('ESSENCE_VERSION', '0.0.1');


/**
 * This function loads front-end JS files
 *
 */
add_action('get_header', 'essence_load_scripts');
function essence_load_scripts() {
	/**
	 * @todo Comment reply script?
	 */
	/*
	if (is_singular() && get_option('thread_comments') && comments_open())
		wp_enqueue_script('comment-reply');
	*/
	// Load superfish and our common JS (in the footer)
	/**
	 * Load SuperFish
	 */
	wp_enqueue_script('superfish', PARENT_URL.'/js/superfish.js', array('jquery'), '1.4.8', TRUE);
	wp_enqueue_script('superfish-args', PARENT_URL.'/js/superfish.args.js', array('superfish'), ESSENCE_VERSION, true);
}



/**
 * TwentyTen functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * The first function, twentyten_setup(), sets up the theme by registering support
 * for various features in WordPress, such as post thumbnails, navigation menus, and the like.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development), you can
 * override certain functions (those wrapped in a function_exists() call) by defining
 * them first in your child theme's functions.php file. The child theme's functions.php
 * file is included before the parent theme's file, so the child theme functions would
 * be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook. The hook can be removed by using remove_action() or
 * remove_filter() and you can attach your own function to the hook.
 *
 * We can remove the parent theme's hook only after it is attached, which means we need to
 * wait until setting up the child theme:
 *
 * <code>
 * add_action( 'after_setup_theme', 'my_child_theme_setup' );
 * function my_child_theme_setup() {
 *     // We are providing our own filter for excerpt_length (or using the unfiltered value)
 *     remove_filter( 'excerpt_length', 'twentyten_excerpt_length' );
 *     ...
 * }
 * </code>
 *
 * For more information on hooks, see http://codex.wordpress.org/Plugin_API.
 *
 * @package WordPress
 * @subpackage Twenty Ten
 * @since 3.0.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * Used to set the width of images and content. Should be equal to the width the theme
 * is designed for, generally via the style.css stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640;

/** Tell WordPress to run twentyten_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'twentyten_setup' );

if ( ! function_exists('twentyten_setup') ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override twentyten_setup() in a child theme, add your own twentyten_setup to your child theme's
 * functions.php file.
 *
 * @uses add_theme_support() To add support for post thumbnails, navigation menus, and automatic feed links.
 * @uses add_custom_background() To add support for a custom background.
 * @uses add_editor_style() To style the visual editor.
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_custom_image_header() To add support for a custom header.
 * @uses register_default_headers() To register the default custom header images provided with the theme.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since 3.0.0
 */
function twentyten_setup() {

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu()
	add_theme_support( 'nav-menus' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	load_theme_textdomain( 'twentyten', TEMPLATEPATH . '/languages' );

	$locale = get_locale();
	$locale_file = TEMPLATEPATH . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	// This theme allows users to set a custom background
	add_custom_background();

	// Your changeable header business starts here
	define( 'HEADER_TEXTCOLOR', '' );
	// No CSS, just IMG call. The %s is a placeholder for the theme template directory URI.
	define( 'HEADER_IMAGE', '%s/images/headers/forestfloor.jpg' );

	// The height and width of your custom header. You can hook into the theme's own filters to change these values.
	// Add a filter to twentyten_header_image_width and twentyten_header_image_height to change these values.
	define( 'HEADER_IMAGE_WIDTH', apply_filters( 'twentyten_header_image_width',  940 ) );
	define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'twentyten_header_image_height',	198 ) );

	// We'll be using post thumbnails for custom header images on posts and pages.
	// We want them to be 940 pixels wide by 198 pixels tall (larger images will be auto-cropped to fit).
	set_post_thumbnail_size( HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true );

	// Don't support text inside the header image.
	define( 'NO_HEADER_TEXT', true );

	// Add a way for the custom header to be styled in the admin panel that controls
	// custom headers. See twentyten_admin_header_style(), below.
	add_custom_image_header( '', 'twentyten_admin_header_style' );

	// ... and thus ends the changeable header business.

	// Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
	register_default_headers( array (
		'berries' => array (
			'url' => '%s/images/headers/berries.jpg',
			'thumbnail_url' => '%s/images/headers/berries-thumbnail.jpg',
			'description' => __( 'Berries', 'twentyten' )
		),
		'cherryblossom' => array (
			'url' => '%s/images/headers/cherryblossoms.jpg',
			'thumbnail_url' => '%s/images/headers/cherryblossoms-thumbnail.jpg',
			'description' => __( 'Cherry Blossoms', 'twentyten' )
		),
		'concave' => array (
			'url' => '%s/images/headers/concave.jpg',
			'thumbnail_url' => '%s/images/headers/concave-thumbnail.jpg',
			'description' => __( 'Concave', 'twentyten' )
		),
		'fern' => array (
			'url' => '%s/images/headers/fern.jpg',
			'thumbnail_url' => '%s/images/headers/fern-thumbnail.jpg',
			'description' => __( 'Fern', 'twentyten' )
		),
		'forestfloor' => array (
			'url' => '%s/images/headers/forestfloor.jpg',
			'thumbnail_url' => '%s/images/headers/forestfloor-thumbnail.jpg',
			'description' => __( 'Forest Floor', 'twentyten' )
		),
		'inkwell' => array (
			'url' => '%s/images/headers/inkwell.jpg',
			'thumbnail_url' => '%s/images/headers/inkwell-thumbnail.jpg',
			'description' => __( 'Inkwell', 'twentyten' )
		),
		'path' => array (
			'url' => '%s/images/headers/path.jpg',
			'thumbnail_url' => '%s/images/headers/path-thumbnail.jpg',
			'description' => __( 'Path', 'twentyten' )
		),
		'sunset' => array (
			'url' => '%s/images/headers/sunset.jpg',
			'thumbnail_url' => '%s/images/headers/sunset-thumbnail.jpg',
			'description' => __( 'Sunset', 'twentyten' )
		)
	) );
}
endif;

if ( ! function_exists( 'twentyten_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_custom_image_header() in twentyten_setup().
 *
 * @since 3.0.0
 */
function twentyten_admin_header_style() {
?>
<style type="text/css">
#headimg {
	height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
	width: <?php echo HEADER_IMAGE_WIDTH; ?>px;
}
#headimg h1, #headimg #desc {
	display: none;
}
</style>
<?php
}
endif;

if ( ! function_exists( 'twentyten_the_page_number' ) ) :
/**
 * Prints the page number currently being browsed, with a vertical bar before it.
 *
 * Used in Twenty Ten's header.php to add the page number to the <title> HTML tag.
 *
 * @since 3.0.0
 */
function twentyten_the_page_number() {
	global $paged; // Contains page number.
	if ( $paged >= 2 )
		echo ' | ' . sprintf( __( 'Page %s' , 'twentyten' ), $paged );
}
endif;

/**
 * Sets the post excerpt length to 40 characters.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 *
 * @return int
 */
function twentyten_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'twentyten_excerpt_length' );

/**
 * Sets the "read more" link to something pretty.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 *
 * @since 3.0.0
 * @return string A pretty 'Continue reading' link.
 */
function twentyten_excerpt_more( $more ) {
	return '&nbsp;&hellip; <a href="'. get_permalink() . '">' . __('Continue&nbsp;reading&nbsp;<span class="meta-nav">&rarr;</span>', 'twentyten') . '</a>';
}
add_filter( 'excerpt_more', 'twentyten_excerpt_more' );

/**
 * Remove inline styles printed when the gallery shortcode is used.
 *
 * Galleries are styled by the theme in Twenty Ten's style.css.
 *
 * @return string The gallery style filter, with the styles themselves removed.
 */
function twentyten_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
add_filter( 'gallery_style', 'twentyten_remove_gallery_css' );

if ( ! function_exists( 'twentyten_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own twentyten_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since 3.0.0
 */
function twentyten_comment( $comment, $args, $depth ) {
	$GLOBALS ['comment'] = $comment; ?>
	<?php if ( '' == $comment->comment_type ) : ?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>">
		<div class="comment-author vcard">
			<?php echo get_avatar( $comment, 40 ); ?>
			<?php printf( __( '<cite class="fn">%s</cite> <span class="says">says:</span>', 'twentyten' ), get_comment_author_link() ); ?>
		</div>
		<?php if ( $comment->comment_approved == '0' ) : ?>
			<em><?php _e( 'Your comment is awaiting moderation.', 'twentyten' ); ?></em>
			<br />
		<?php endif; ?>

		<div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><?php printf( __( '%1$s at %2$s', 'twentyten' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)', 'twentyten' ),'  ','' ); ?></div>

		<div class="comment-body"><?php comment_text(); ?></div>

		<div class="reply">
			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div>
	</div>

	<?php else : ?>
	<li class="post pingback">
		<p><?php _e( 'Pingback: ', 'twentyten' ); ?><?php comment_author_link(); ?><?php edit_comment_link ( __('edit', 'twentyten'), '&nbsp;&nbsp;', '' ); ?></p>
	<?php endif;
}
endif;

if ( ! function_exists( 'twentyten_cat_list' ) ) :
/**
 * Returns the list of categories
 *
 * Returns the list of categories based on if we are or are
 * not browsing a category archive page.
 *
 * @uses twentyten_term_list
 *
 * @return string
 */
function twentyten_cat_list() {
	return twentyten_term_list( 'category', ', ', __( 'Posted in %s', 'twentyten' ), __( 'Also posted in %s', 'twentyten' ) );
}
endif;

if ( ! function_exists( 'twentyten_tag_list' ) ) :
/**
 * Returns the list of tags
 *
 * Returns the list of tags based on if we are or are not
 * browsing a tag archive page
 *
 * @uses twentyten_term_list
 *
 * @return string
 */
function twentyten_tag_list() {
	return twentyten_term_list( 'post_tag', ', ', __( 'Tagged %s', 'twentyten' ), __( 'Also tagged %s', 'twentyten' ) );
}
endif;


if ( ! function_exists( 'twentyten_term_list' ) ) :
/**
 * Returns the list of taxonomy items in multiple ways
 *
 * Returns the list of taxonomy items differently based on
 * if we are browsing a term archive page or a different
 * type of page.  If browsing a term archive page and the
 * post has no other taxonomied terms, it returns empty
 *
 * @return string
 */
function twentyten_term_list( $taxonomy, $glue = ', ', $text = '', $also_text = '' ) {
	global $wp_query, $post;
	$current_term = $wp_query->get_queried_object();
	$terms = wp_get_object_terms( $post->ID, $taxonomy );
	// If we're viewing a Taxonomy page..
	if ( isset( $current_term->taxonomy ) && $taxonomy == $current_term->taxonomy ) {
		// Remove the term from display.
		foreach ( (array) $terms as $key => $term ) {
			if ( $term->term_id == $current_term->term_id ) {
				unset( $terms[$key] );
				break;
			}
		}
		// Change to Also text as we've now removed something from the terms list.
		$text = $also_text;
	}
	$tlist = array();
	$rel = 'category' == $taxonomy ? 'rel="category"' : 'rel="tag"';
	foreach ( (array) $terms as $term ) {
		$tlist[] = '<a href="' . get_term_link( $term, $taxonomy ) . '" title="' . esc_attr( sprintf( __( 'View all posts in %s', 'twentyten' ), $term->name ) ) . '" ' . $rel . '>' . $term->name . '</a>';
	}
	if ( ! empty( $tlist ) )
		return sprintf( $text, join( $glue, $tlist ) );
	return '';
}
endif;

/**
 * Register widgetized areas, including two sidebars and four widget-ready columns in the footer.
 *
 * To override twentyten_widgets_init() in a child theme, remove the action hook and add your own
 * function tied to the init hook.
 * @uses register_sidebar
 */
function twentyten_widgets_init() {
	// Area 1
	register_sidebar( array (
		'name' => 'Primary Widget Area',
		'id' => 'primary-widget-area',
		'description' => __( 'The primary widget area' , 'twentyten' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => "</li>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 2
	register_sidebar( array (
		'name' => 'Secondary Widget Area',
		'id' => 'secondary-widget-area',
		'description' => __( 'The secondary widget area' , 'twentyten' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => "</li>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 3
	register_sidebar( array (
		'name' => 'First Footer Widget Area',
		'id' => 'first-footer-widget-area',
		'description' => __( 'The first footer widget area' , 'twentyten' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => "</li>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 4
	register_sidebar( array (
		'name' => 'Second Footer Widget Area',
		'id' => 'second-footer-widget-area',
		'description' => __( 'The second footer widget area' , 'twentyten' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => "</li>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 5
	register_sidebar( array (
		'name' => 'Third Footer Widget Area',
		'id' => 'third-footer-widget-area',
		'description' => __( 'The third footer widget area' , 'twentyten' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => "</li>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 6
	register_sidebar( array (
		'name' => 'Fourth Footer Widget Area',
		'id' => 'fourth-footer-widget-area',
		'description' => __( 'The fourth footer widget area' , 'twentyten' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => "</li>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
add_action( 'init', 'twentyten_widgets_init' );

/**
 * Removes the default styles that are packaged with the Recent Comments widget.
 */
function twentyten_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action( 'widgets_init', 'twentyten_remove_recent_comments_style' );
