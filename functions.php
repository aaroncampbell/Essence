<?php
/**
 * For use with debugging
 */
if ( !function_exists('dump') ) {
	function dump($v, $title = '', $return = false, $htmlcomment = false) {
		if (!empty($title)) {
			$before_title = ($htmlcomment)? '::' : '<h4>';
			$after_title = ($htmlcomment)? '::' : '</h4>';
			$title = $before_title . htmlentities($title) . $after_title;
		}
		ob_start();
		var_dump($v);
		$v = ob_get_clean();
		if ( $htmlcomment ) {
			$v = "<!--\r\n{$title}\r\n{$v}\r\n-->";
		} else {
			$v = $title . '<pre>' . htmlentities($v) . '</pre>';
		}
		if ( $return ) {
			return $v;
		}
		echo $v;
	}
}

/**
 * Essence functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action
 * and filter hooks in WordPress to change core functionality.
 *
 * The function essence_setup(), sets up the theme by registering support
 * for various features in WordPress, such as post thumbnails, navigation menus,
 * and the like.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development),
 * you can override certain functions (those wrapped in a function_exists()
 * call) by defining them first in your child theme's functions.php file. The
 * child theme's functions.php file is included before the parent theme's file,
 * so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook. The hook can be removed by using
 * remove_action() or remove_filter() and you can attach your own function to
 * the hook.
 *
 * We can remove the parent theme's hook only after it is attached, which means
 * we need to wait until setting up the child theme:
 *
 * <code>
 * add_action( 'after_setup_theme', 'my_child_theme_setup' );
 * function my_child_theme_setup() {
 *     // We are providing our own filter for excerpt_length (or using the unfiltered value)
 *     remove_filter( 'excerpt_length', 'essence_excerpt_length' );
 *     ...
 * }
 * </code>
 *
 * For more information on hooks, see http://codex.wordpress.org/Plugin_API.
 */

define('PARENT_URL', get_bloginfo('template_directory'));
define('CHILD_URL', get_bloginfo('stylesheet_directory'));
define('ESSENCE_VERSION', '0.0.1');

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * Used to set the width of images and content. Should be equal to the width the
 * theme is designed for, generally via the style.css stylesheet.
 *
 * @todo Swap this out based on the page layout?  Is that possible?
 */
if ( ! isset( $content_width ) )
	$content_width = 640;


/**
 * This function loads front-end JS files
 *
 */
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
	wp_enqueue_script('hoverIntent', PARENT_URL.'/js/hoverIntent.js', array('jquery'), '0.0.1', true);
	wp_enqueue_script('superfish', PARENT_URL.'/js/superfish.js', array('jquery', 'hoverIntent'), '1.4.8', true);
	wp_enqueue_script('superfish-args', PARENT_URL.'/js/superfish.args.js', array('superfish'), ESSENCE_VERSION, true);
	wp_enqueue_script('label-over', PARENT_URL.'/js/label_over.js', array('jquery'), ESSENCE_VERSION, true);
}
add_action('get_header', 'essence_load_scripts');


function essence_init() {
	/**
	 * If Joost's breadcrumb plugin is installed, hook it into the
	 * essence_content_open action
	 *
	 * @todo ask Joost to include the essence filter in the plugin
	 */
	if ( function_exists('yoast_breadcrumb_output') ) {
		add_action('essence_content_open','yoast_breadcrumb_output',10,1);
	}
}
add_action( 'init', 'essence_init' );


/**
 * Register widgetized areas, including two sidebars and four widget-ready
 * columns in the footer.
 *
 * To override essence_widgets_init() in a child theme, remove the action hook
 * and add your own function tied to the init hook.
 * @uses register_sidebar
 */
function essence_widgets_init() {
	// Area 1
	register_sidebar( array (
		'name' => __( 'Primary Widget Area', 'essence' ),
		'id' => 'primary-widget-area',
		'description' => __( 'The primary widget area' , 'essence' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => "</li>",
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );

	// Area 2
	register_sidebar( array (
		'name' => __( 'Secondary Widget Area', 'essence' ),
		'id' => 'secondary-widget-area',
		'description' => __( 'The secondary widget area' , 'essence' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => "</li>",
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );

	// Area 3
	register_sidebar( array (
		'name' => __( 'First Footer Widget Area', 'essence' ),
		'id' => 'first-footer-widget-area',
		'description' => __( 'The first footer widget area' , 'essence' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => "</li>",
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );

	// Area 4
	register_sidebar( array (
		'name' => __( 'Second Footer Widget Area', 'essence' ),
		'id' => 'second-footer-widget-area',
		'description' => __( 'The second footer widget area' , 'essence' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => "</li>",
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );

	// Area 5
	register_sidebar( array (
		'name' => __( 'Third Footer Widget Area', 'essence' ),
		'id' => 'third-footer-widget-area',
		'description' => __( 'The third footer widget area' , 'essence' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => "</li>",
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );

	// Area 6
	register_sidebar( array (
		'name' => __( 'Fourth Footer Widget Area', 'essence' ),
		'id' => 'fourth-footer-widget-area',
		'description' => __( 'The fourth footer widget area' , 'essence' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => "</li>",
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );
}
add_action( 'init', 'essence_widgets_init' );


if ( ! function_exists('essence_setup') ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as
 * indicating support post thumbnails.
 *
 * To override essence_setup() in a child theme, add your own essence_setup to
 * your child theme's functions.php file.
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
function essence_setup() {

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	/**
	 * @todo actually add this support, as well as support for chat, link, image, quote, status, video, and audio
	 */
	// Post Format support. You can also use the legacy "gallery" or "asides" (note the plural) categories.
	add_theme_support( 'post-formats', array( 'aside', 'gallery' ) );

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	/**
	 * @todo Generate POT and get translations
	 */
	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	load_theme_textdomain( 'essence', TEMPLATEPATH . '/languages' );

	$locale = get_locale();
	$locale_file = TEMPLATEPATH . "/languages/{$locale}.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	/**
	 * @todo support secondary navigation?
	 */
	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'essence' ),
	) );

	/**
	 * @todo implement custom backgrounds
	 */
	// This theme allows users to set a custom background
	add_custom_background();

	/**
	 * @todo implement this header stuff
	 */
	// Your changeable header business starts here
	if ( ! defined( 'HEADER_TEXTCOLOR' ) )
		define( 'HEADER_TEXTCOLOR', '' );
	// No CSS, just IMG call. The %s is a placeholder for the theme template directory URI.
	if ( ! defined( 'HEADER_IMAGE' ) )
		define( 'HEADER_IMAGE', '%s/images/headers/path.jpg' );

	// The height and width of your custom header. You can hook into the theme's own filters to change these values.
	// Add a filter to essence_header_image_width and essence_header_image_height to change these values.
	define( 'HEADER_IMAGE_WIDTH', apply_filters( 'essence_header_image_width',  940 ) );
	define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'essence_header_image_height',	198 ) );

	/**
	 * @todo Post thumbnails should be set to the size of my content showcase once that's implementd
	 */
	// We'll be using post thumbnails for custom header images on posts and pages.
	// We want them to be 940 pixels wide by 198 pixels tall (larger images will be auto-cropped to fit).
	set_post_thumbnail_size( HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true );

	/**
	 * @todo check on NO_HEADER_TEXT
	 */
	// Don't support text inside the header image.
	if ( ! defined( 'NO_HEADER_TEXT' ) )
		define( 'NO_HEADER_TEXT', true );

	// Add a way for the custom header to be styled in the admin panel that controls
	// custom headers. See essence_admin_header_style(), below.
	add_custom_image_header( '', 'essence_admin_header_style' );

	// ... and thus ends the changeable header business.

	/**
	 * @todo Include my own custom headers, talk to Matt about including these ones?
	 */
	// Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
	register_default_headers( array (
		'berries' => array (
			'url' => '%s/images/headers/berries.jpg',
			'thumbnail_url' => '%s/images/headers/berries-thumbnail.jpg',
			'description' => __( 'Berries', 'essence' )
		),
		'cherryblossom' => array (
			'url' => '%s/images/headers/cherryblossoms.jpg',
			'thumbnail_url' => '%s/images/headers/cherryblossoms-thumbnail.jpg',
			'description' => __( 'Cherry Blossoms', 'essence' )
		),
		'concave' => array (
			'url' => '%s/images/headers/concave.jpg',
			'thumbnail_url' => '%s/images/headers/concave-thumbnail.jpg',
			'description' => __( 'Concave', 'essence' )
		),
		'fern' => array (
			'url' => '%s/images/headers/fern.jpg',
			'thumbnail_url' => '%s/images/headers/fern-thumbnail.jpg',
			'description' => __( 'Fern', 'essence' )
		),
		'forestfloor' => array (
			'url' => '%s/images/headers/forestfloor.jpg',
			'thumbnail_url' => '%s/images/headers/forestfloor-thumbnail.jpg',
			'description' => __( 'Forest Floor', 'essence' )
		),
		'inkwell' => array (
			'url' => '%s/images/headers/inkwell.jpg',
			'thumbnail_url' => '%s/images/headers/inkwell-thumbnail.jpg',
			'description' => __( 'Inkwell', 'essence' )
		),
		'path' => array (
			'url' => '%s/images/headers/path.jpg',
			'thumbnail_url' => '%s/images/headers/path-thumbnail.jpg',
			'description' => __( 'Path', 'essence' )
		),
		'sunset' => array (
			'url' => '%s/images/headers/sunset.jpg',
			'thumbnail_url' => '%s/images/headers/sunset-thumbnail.jpg',
			'description' => __( 'Sunset', 'essence' )
		)
	) );
}
endif;
/** Tell WordPress to run essence_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'essence_setup' );


if ( ! function_exists( 'essence_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_custom_image_header() in essence_setup().
 *
 * @since 3.0.0
 */
function essence_admin_header_style() {
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

if ( ! function_exists( 'essence_the_page_number' ) ) :
/**
 * Prints the page number currently being browsed, with a pipe before it.
 *
 * Used in Essence's header.php to add the page number to the <title> HTML tag.
 *
 * @todo Make the | a setting?  Add rtl support?
 */
function essence_the_page_number() {
	global $page, $paged; // Contains page number.

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'essence' ), max( $paged, $page ) );
}
endif;

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * To override this in a child theme, remove the filter and optionally add
 * your own function tied to the wp_page_menu_args filter hook.
 *
 * @since 0.0.1
 */
function essence_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'essence_page_menu_args' );

/**
 * Sets the post excerpt length to 40 characters.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 *
 * @return int
 */
function essence_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'essence_excerpt_length' );
/**
 * Returns a "Continue Reading" link for excerpts
 *
 * @since 0.0.1
 * @return string "Continue Reading" link
 */
function essence_continue_reading_link() {
	return ' <a href="'. get_permalink() . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'essence' ) . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and essence_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 *
 * @since 0.0.1
 * @return string An ellipsis
 */
function essence_auto_excerpt_more( $more ) {
	return ' &hellip;' . essence_continue_reading_link();
}
add_filter( 'excerpt_more', 'essence_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 *
 * @since 0.0.1
 * @return string Excerpt with a pretty "Continue Reading" link
 */
function essence_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= essence_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'essence_custom_excerpt_more' );

/**
 * Remove inline styles printed when the gallery shortcode is used.
 *
 * Galleries are styled by the theme in style.css. This is just a simple filter
 * call that tells WordPress to not use the default styles.
 *
 * @since 0.0.1
 */
add_filter( 'use_default_gallery_style', '__return_false' );

/**
 * Removes the default styles that are packaged with the Recent Comments widget.
 *
 * To override this in a child theme, remove the filter and optionally add your own
 * function tied to the widgets_init action hook.
 *
 * @since 0.0.1
 */
function essence_remove_recent_comments_style() {
	add_filter( 'show_recent_comments_widget_style', '__return_false' );
}
add_action( 'widgets_init', 'essence_remove_recent_comments_style' );

if ( ! function_exists( 'essence_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 *
 * @since 0.0.1
 */
function essence_posted_on() {
	printf( __( '<span class="%1$s">Posted on</span> %2$s <span class="meta-sep">by</span> %3$s', 'essence' ),
		'meta-prep meta-prep-author',
		sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
			get_permalink(),
			esc_attr( get_the_time() ),
			get_the_date()
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
			get_author_posts_url( get_the_author_meta( 'ID' ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'essence' ), get_the_author() ),
			get_the_author()
		)
	);
}
endif;

if ( ! function_exists( 'essence_posted_in' ) ) :
/**
 * Prints HTML with meta information for the current post (category, tags and permalink).
 *
 * @since 0.0.1
 */
function essence_posted_in() {
	// Retrieves tag list of current post, separated by commas.
	$tag_list = get_the_tag_list( '', ', ' );
	if ( $tag_list ) {
		$posted_in = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'essence' );
	} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
		$posted_in = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'essence' );
	} else {
		$posted_in = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'essence' );
	}
	// Prints the string, replacing the placeholders.
	printf(
		$posted_in,
		get_the_category_list( ', ' ),
		$tag_list,
		get_permalink(),
		the_title_attribute( 'echo=0' )
	);
}
endif;

if ( ! function_exists( 'essence_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own essence_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since 0.0.1
 */
function essence_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>">
		<div class="comment-author vcard">
			<?php echo get_avatar( $comment, 40 ); ?>
			<?php printf( __( '%s <span class="says">says:</span>', 'essence' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
		</div><!-- .comment-author .vcard -->
		<?php if ( $comment->comment_approved == '0' ) : ?>
			<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'essence' ); ?></em>
			<br />
		<?php endif; ?>

		<div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
			<?php
				/* translators: 1: date, 2: time */
				printf( __( '%1$s at %2$s', 'essence' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)', 'essence' ), ' ' );
			?>
		</div><!-- .comment-meta .commentmetadata -->

		<div class="comment-body"><?php comment_text(); ?></div>

		<div class="reply">
			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div><!-- .reply -->
	</div><!-- #comment-##  -->

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'essence' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'essence' ), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}
endif;
