<?php

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

define( 'ESSENCE_VERSION', '0.1.0' );

function get_essence_settings_field() {
	return apply_filters( 'essence_settings_field', 'essence-settings' );
}

function get_essence_settings_group() {
	return apply_filters( 'essence_settings_group', 'essence-settings-group' );
}

//	Run the essence_pre_framework Hook
do_action( 'essence_pre_framework' );

/**
 * Load Framework Components, unless a child theme says not to
 */
if ( apply_filters( 'essence_load_framework', true ) ) {
	//	Load Functions
	require_once( get_template_directory() . '/lib/functions/tools.php' );
	require_once( get_template_directory() . '/lib/functions/options.php' );

	//	Load Structure
	require_once( get_template_directory() . '/lib/structure/menus.php' );
	require_once( get_template_directory() . '/lib/structure/galleries.php' );

	if ( is_admin() ) {
		//	Load Admin
		require_once( get_template_directory() . '/lib/admin/menu.php' );
		require_once( get_template_directory() . '/lib/admin/essence-settings.php' );
	}
}

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * Used to set the width of images and content. Should be equal to the width the
 * theme is designed for, generally via the style.css stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 1140;

/**
 * This registers and enqueues front-end CSS & JS files
 */
function essence_enqueue_scripts() {
	wp_enqueue_style( 'essence', get_template_directory_uri() . '/style.css', array( 'foundation' ), '20120515' );
	wp_enqueue_style( 'foundation', get_template_directory_uri() . '/css/foundation/foundation.css', array(), '2.2.1' );
	wp_enqueue_style( 'foundation-ie', get_template_directory_uri() . '/css/foundation/ie.css', array( 'foundation' ), '2.2.1' );
	if ( is_child_theme() ) {
		$child_theme = wp_get_theme( get_stylesheet_directory() . '/style.css' );
		wp_enqueue_style( 'essence_child', get_stylesheet_uri(), array('essence'), $child_theme['Version'] );
	}

	/**
	 * @var WP_Styles
	 */
	global $wp_styles;
	// Conditionally load this only for IE < 9
	$wp_styles->add_data( 'foundation-ie', 'conditional', 'lt IE 9' );


	/**
	 * Load SuperFish
	 */
	wp_enqueue_script( 'hoverIntent', get_template_directory_uri() . '/js/hoverIntent.js', array('jquery'), '20110226', true );
	wp_enqueue_script( 'superfish', get_template_directory_uri() . '/js/superfish.js', array('jquery', 'hoverIntent'), '1.4.8', true );
	wp_enqueue_script( 'superfish-args', get_template_directory_uri() . '/js/superfish.args.js', array('superfish'), '20110725', true );
	wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/js/modernizr.js', array('jquery'), '2.5.2', true );
	wp_enqueue_script( 'html5', get_template_directory_uri() . '/js/html5.js', null, '3.6', true );
	wp_enqueue_script( 'foundation', get_template_directory_uri() . '/js/foundation.js', array('jquery'), '2.2.1', true );
	wp_enqueue_script( 'essence', get_template_directory_uri() . '/js/essence.js', array( 'foundation' ), '20120524', true );

	/**
	 * @var WP_Scripts
	 */
	global $wp_scripts;
	// Conditionally load this only for IE < 9
	$wp_scripts->add_data( 'html5', 'conditional', 'lt IE 9' );
}
add_action( 'wp_enqueue_scripts', 'essence_enqueue_scripts' );

function essence_init() {
	/**
	 * If Joost's breadcrumb plugin is installed, hook it into the
	 * essence_content_open action
	 *
	 * @todo ask Joost to include the essence filter in the plugin
	 */
	if ( function_exists( 'yoast_breadcrumb' ) )
		add_action( 'essence_content_open', 'essence_yoast_breadcrumb' );
}
function essence_yoast_breadcrumb() {
	yoast_breadcrumb('<ul class="breadcrumbs"><li>','</li></ul>');
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
		'before_widget' => '<aside id="%1$s" class="widget-container %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );

	// Area 2
	register_sidebar( array (
		'name' => __( 'Secondary Widget Area', 'essence' ),
		'id' => 'secondary-widget-area',
		'description' => __( 'The secondary widget area' , 'essence' ),
		'before_widget' => '<aside id="%1$s" class="widget-container %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );

	// Area 3
	register_sidebar( array (
		'name' => __( 'First Footer Widget Area', 'essence' ),
		'id' => 'first-footer-widget-area',
		'description' => __( 'The first footer widget area' , 'essence' ),
		'before_widget' => '<aside id="%1$s" class="widget-container %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );

	// Area 4
	register_sidebar( array (
		'name' => __( 'Second Footer Widget Area', 'essence' ),
		'id' => 'second-footer-widget-area',
		'description' => __( 'The second footer widget area' , 'essence' ),
		'before_widget' => '<aside id="%1$s" class="widget-container %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );

	// Area 5
	register_sidebar( array (
		'name' => __( 'Third Footer Widget Area', 'essence' ),
		'id' => 'third-footer-widget-area',
		'description' => __( 'The third footer widget area' , 'essence' ),
		'before_widget' => '<aside id="%1$s" class="widget-container %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );

	// Area 6
	register_sidebar( array (
		'name' => __( 'Fourth Footer Widget Area', 'essence' ),
		'id' => 'fourth-footer-widget-area',
		'description' => __( 'The fourth footer widget area' , 'essence' ),
		'before_widget' => '<aside id="%1$s" class="widget-container %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );

	if ( essence_get_option( 'widgetize_header_right' ) ) {
		// Header widget
		register_sidebar( array (
			'name' => __( 'Header Right', 'essence' ),
			'id' => 'header-right-widget-area',
			'description' => __( 'The right side of the header' , 'essence' ),
			'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
			'after_widget' => "</div>",
			'before_title' => '<h4 class="widget-title">',
			'after_title' => '</h4>',
		) );
	}
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
 * @since 0.0.1
 */
function essence_setup() {

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	/**
	 * @todo actually add this support
	 */
	// Post Format support.
	$post_formats = apply_filters( 'essence_post_formats', array(
		'aside',
		'chat',
		'gallery',
		'link',
		'image',
		'quote',
		'status',
		'video',
		'audio',
	) );
	add_theme_support( 'post-formats', $post_formats );

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Add support for flexible headers
	$header_args = array(
		'random-default' => true,
		'flex-height' => true,
		'suggested-height' => apply_filters( 'essence_header_image_height', 200 ),
		'flex-width' => true,
		'suggested-width' => apply_filters( 'essence_header_image_width', 950 ),
		'admin-preview-callback' => 'essence_admin_header_style',
		'default-image' => '%s/images/headers/path.jpg',
		'header-text' => false,
	);
	add_theme_support( 'custom-header', $header_args );

	/**
	 * @todo Generate POT and get translations
	 */
	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	load_theme_textdomain( 'essence', get_template_directory() . '/languages' );

	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/{$locale}.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	// This theme allows users to set a custom background
	add_theme_support( 'custom-background' );

	/**
	 * @todo Post thumbnails should be set to the size of my content showcase once that's implementd
	 */
	add_image_size( 'post-thumbnail', apply_filters( 'essence_thumbnail_image_width', get_custom_header()->width ), apply_filters( 'essence_thumbnail_image_height', get_custom_header()->height ), apply_filters( 'essence_thumbnail_image_crop', true ) );

	do_action( 'essence_setup' );
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
 * @since 0.0.1
 */
function essence_admin_header_style() {
?>
<style type="text/css">
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
function essence_wp_title( $title, $sep, $seplocation ) {
	global $page, $paged; // Contains page number.

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = get_bloginfo( 'name' ) . " {$sep} " . $site_description;

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$title .= ' | ' . sprintf( __( 'Page %s', 'essence' ), max( $paged, $page ) );

 	// Determines position of the separator and direction of the breadcrumb
	if ( 'right' == $seplocation ) { // sep on right, so reverse the order
		$title_array = explode( $sep, $title );
		$title_array = array_reverse( $title_array );
		$title = implode( $sep, $title_array ) . $prefix;
	}

	return $title;
}
endif;
add_filter( 'wp_title', 'essence_wp_title', null, 3 );

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
	if ( has_excerpt() && ! is_attachment() )
		$output .= essence_continue_reading_link();
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
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
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
	if ( $tag_list )
		$posted_in = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'essence' );
	elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) )
		$posted_in = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'essence' );
	else
		$posted_in = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'essence' );

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
			<?php printf( __( '%s <span class="says">says:</span>', 'essence' ), sprintf( '<span class="fn">%s</span>', get_comment_author_link() ) ); ?>
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
			<?php
			$comment_reply_link_args = array(
				'depth'      => $depth,
				'max_depth'  => $args['max_depth'],
				'reply_text' => sprintf( __( 'Reply to %s &crarr;', 'essence' ), get_comment_author() ),
			);
			$comment_reply_link_args = array_merge( $args, $comment_reply_link_args );
			comment_reply_link( $comment_reply_link_args );
			?>
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

/**
 * Display navigation to next/previous pages when applicable
 */
function essence_content_nav( $nav_id ) {
	global $wp_query;

	if ( $wp_query->max_num_pages > 1 ) {
?>
		<div id="<?php esc_attr_e( $nav_id ); ?>">
			<h1 class="assistive-text"><?php _e( 'Post navigation', 'essence' ); ?></h1>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'essence' ) ); ?></div>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'essence' ) ); ?></div>
			<div class="clearfix"></div>
		</div><!-- #<?php esc_html_e( $nav_id ); ?> -->
<?php
	}
}

function essence_add_google_profile( $contactmethods ) {
	// Add Google Profile
	$contactmethods['google_profile'] = 'Google Profile URL';
	return $contactmethods;
}
add_filter( 'user_contactmethods', 'essence_add_google_profile', null, 1);
