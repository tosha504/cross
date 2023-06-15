<?php

/**
 * Cross functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package cross
 */

if (!defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function cross_setup()
{
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on start, use a find and replace
		* to change 'garden' to the name of your theme in all the template files.
		*/
	load_theme_textdomain('cross', get_template_directory() . '/languages');

	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support('title-tag');

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support('post-thumbnails');

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'left-header'    		=> esc_html__('Left menu', 'cross'),
			'right-header' 			=> esc_html__('Right menu', 'cross'),
			'mobile'						=> esc_html__('Mobile', 'cross'),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'cross_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support('customize-selective-refresh-widgets');

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action('after_setup_theme', 'cross_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function garden_content_width()
{
	$GLOBALS['content_width'] = apply_filters('garden_content_width', 640);
}
add_action('after_setup_theme', 'garden_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function garden_widgets_init()
{
	register_sidebar(
		array(
			'name'          => esc_html__('Sidebar', 'garden'),
			'id'            => 'sidebar-1',
			'description'   => esc_html__('Add widgets here.', 'garden'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action('widgets_init', 'garden_widgets_init');

/**
 * Disable Gutenberg
 */
// add_filter('use_block_editor_for_post', '__return_false');

// Theme includes directory.
$cross_inc_dir = 'inc';

// Array of files to include.
$cross_includes = array(
	'/functions-template.php',  // 	Theme custom functions
	'/enqueue.php',				//	Enqueue scripts and styles.
	'/custom-header.php',		//	Implement the Custom Header feature.
	'/customizer.php',			//	Customizer additions.
	'/template-tags.php',		// 	Custom template tags for this theme.	
	'/template-functions.php',	//	Functions which enhance the theme by hooking into WordPress.

);

// Load WooCommerce functions if WooCommerce is activated.
if (class_exists('WooCommerce')) {
	$cross_includes[] = '/woocommerce.php';
}

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}

// Include files.
foreach ($cross_includes as $file) {
	require_once get_theme_file_path($cross_inc_dir . $file);
}

/**
 * Make ACF Options
 */
if (function_exists('acf_add_options_page')) {
	$option_page = acf_add_options_page([
		'page_title' => 'General settings',
		'menu_title' => 'General settings',
		'menu_slug' => 'theme-general-settings',
		'post_id' => 'options',
		'capability' => 'edit_posts',
		'redirect' => false
	]);
}

//svg
function cc_mime_types($mimes)
{
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

define('ALLOW_UNFILTERED_UPLOADS', true);

function fix_svg_thumb_display()
{
	echo
	'<style>
		td.media-icon img[src$=".svg"], img[src$=".svg"].attachment-post-thumbnail { 
			width: 100% !important; 
			height: auto !important; 
		}
	</style>';
}

function acf_json_save_point()
{
	return get_template_directory()  . '/acf-json';
}

function acf_json_load_point($paths)
{
	unset($paths[0]);
	$paths[] = get_template_directory()  . '/acf-json';
	return $paths;
}

function acf_json_change_field_group($group)
{
	$groups = array(
		'group_642295c05ad25',
		'group_642295c05ad25__trashed',
		'group_64214c5d4bcc0',
		'group_64214c5d4bcc0__trashed',
		'group_6450cfde19592',
		'group_6450cfde19592__trashed',
	);
	if (in_array($group['key'], $groups)) {
		add_filter('acf/settings/save_json', array('acf_json_save_point'));
	}
	return $group;
}

add_action('acf/update_field_group', 'acf_json_change_field_group');
add_action('acf/trash_field_group', 'acf_json_change_field_group');
add_action('acf/untrash_field_group', 'acf_json_change_field_group');
add_filter('acf/settings/load_json', 'acf_json_load_point');

// custom size images
function add_image_size_new($name, $width = 0, $height = 0, $crop = false)
{
	global $_wp_additional_image_sizes;

	$_wp_additional_image_sizes[$name] = array(
		'width'  => absint($width),
		'height' => absint($height),
		'crop'   => $crop,
	);
}
add_image_size_new('prduct-image', 300, 300, true);
add_image_size_new('banner-image', 450, 500, false);

class AWP_Menu_Walker extends Walker_Nav_Menu
{
	function start_el(&$output, $item, $depth = 0, $args = [], $id = 0)
	{
		$output .= "<li class='" .  implode(" ", $item->classes) . "'>";

		// $output .= '<div class="transition-div"></div>'; //Put your content here
		// var_dump($args->walker->has_children);
		if ($item->url && $item->url != '#') {
			$output .= '<a href="' . $item->url . '">';
		} else {
			$output .= '<span>';
		}

		if ($args->walker->has_children) {
			$output .= '<div class="header__arrow-link"></div>';
		}

		$output .= $item->title;

		if ($item->url && $item->url != '#') {
			$output .= '</a>';
		} else {
			$output .= '</span>';
		}
	}
}
