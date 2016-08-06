<?php 




if ( ! function_exists( 'citeo_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */



function citeo_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on citeo, use a find and replace
	 * to change 'citeo' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'citeo', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Add thumbnails
	add_theme_support( 'post-thumbnails' );

	// Add title-tag
	add_theme_support( 'title-tag' );

	// which will, by default, link the editor-style.css file located directly under the current theme directory.
	add_editor_style();

	// Add new images sizes
	add_image_size( 'citeo-logo', false, 120, false );
	add_image_size( 'citeo-logo-retina', false, 240, false );
	add_image_size( 'citeo-thumbnail', 230, 155, true );
	add_image_size( 'citeo-line', 200, 200, false );
	add_image_size( 'citeo-slideshow', 750, 360, true );
	add_image_size( 'citeo-full', 750, false, false );
	add_image_size( 'citeo-half', 300, false, false );
	add_image_size( 'citeo-icon', 100, 100, false );
	add_image_size( 'citeo-portrait', 250, false, false );
	add_image_size( 'citeo-portrait-square', 250, 250, true );
	add_image_size( 'citeo-portrait-mini', 70, 70, true );
	add_image_size( 'citeo-minisite', 263, 216, true );
	add_image_size( 'citeo-publication', 208, 276, false );
	add_image_size( 'citeo-background', 2000, false, false );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	//add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'footer' => 'Pied de page',
	) );

	register_nav_menus( array(
		'main' => 'Menu principal',
	) );

	register_nav_menus( array(
		'top' => 'Tout en haut',
	) );
	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'citeo_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // citeo_setup

add_action( 'after_setup_theme', 'citeo_setup' );


function display_custom_image_sizes( $sizes ) {
  global $_wp_additional_image_sizes;
  if ( empty($_wp_additional_image_sizes) )
    return $sizes;

  foreach ( $_wp_additional_image_sizes as $id => $data ) {
    if ( !isset($sizes[$id]) )
      $sizes[$id] = ucfirst( str_replace( '-', ' ', $id ) );
  }

  return $sizes;
}
add_filter( 'image_size_names_choose', 'display_custom_image_sizes' );



if ( ! function_exists( 'set_default_admin_color' ) ) :

function add_upload_mimes($mimes=array()) {
    $mimes['kml']='application/vnd.google-earth.kml+xml';
    $mimes['kmz']='application/vnd.google-earth.kmz';
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter("upload_mimes","add_upload_mimes");
endif;



if ( ! function_exists( 'set_default_admin_color' ) ) :
/**
 * Set default admin color scheme
 *
 * @link http://smallenvelop.com/how-to-set-default-admin-color-scheme-for-new-users-in-wordpress/
 */
function set_default_admin_color($user_id) {  
    $args = array(
    	'ID' => $user_id,  
        'admin_color' => 'midnight'  
    );  
    wp_update_user( $args );  
}  
add_action('user_register', 'set_default_admin_color');
endif;


if ( ! function_exists( 'citeo_widgets_init' ) ) :
/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function citeo_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'citeo' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );

	// Not yet
	// register_sidebar( array(
	// 	'name'          => __( 'Footer', 'citeo' ),
	// 	'id'            => 'sidebar-footer',
	// 	'description'   => '',
	// 	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	// 	'after_widget'  => '</div>',
	// 	'before_title'  => '<h1 class="widget-title">',
	// 	'after_title'   => '</h1>',
	// ) );

	// register_sidebar( array(
	// 	'name'          => __( 'Top Bar', 'citeo' ),
	// 	'id'            => 'sidebar-top-bar',
	// 	'description'   => '',
	// 	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	// 	'after_widget'  => '</div>',
	// 	'before_title'  => '<h1 class="widget-title">',
	// 	'after_title'   => '</h1>',
	// ) );


}
add_action( 'widgets_init', 'citeo_widgets_init' );
endif;


// unregister all unused default WP Widgets
function unregister_default_wp_widgets() {
    //unregister_widget('WP_Widget_Pages'); // Listing des pages
    unregister_widget('WP_Widget_Calendar'); // Calendrier
    unregister_widget('WP_Widget_Archives'); // Archives   
    //unregister_widget('WP_Widget_Meta'); // Meta
    unregister_widget('WP_Widget_Search'); // Moteur de recherche
    unregister_widget('WP_Widget_Categories'); // Catégories
    unregister_widget('WP_Widget_Recent_Posts'); // Posts récents
    unregister_widget('WP_Widget_Recent_Comments'); // Commentaires
    //unregister_widget('WP_Widget_RSS'); // Flux RSS
    unregister_widget('WP_Widget_Tag_Cloud'); // tag
    unregister_widget('bcn_widget'); // Breadcrumb Nav
}
add_action('widgets_init', 'unregister_default_wp_widgets', 11);


if ( ! isset( $content_width ) ) {
	$content_width = 750;
}


