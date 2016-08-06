<?php

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles', 100);
function theme_enqueue_styles() {
	
	wp_dequeue_style( 'open-sans' );
	// wp_deregister_style( 'open-sans' );
	wp_dequeue_style( 'citeo' );
	wp_dequeue_style( 'beaver' );
	wp_dequeue_style( 'citeo-style' );
	wp_dequeue_style( 'citeo-fat-menu' );
	wp_dequeue_style( 'fatmenu' );
	wp_dequeue_style( 'citeo-ressources' );

	wp_dequeue_style( 'font-awesome' );
	wp_dequeue_style( 'photoswipe-core-css' );
	wp_dequeue_style( 'photoswipe-default-skin' );


	wp_dequeue_script( 'citeo-ressources' );
	wp_dequeue_script( 'citeo-interactive-map' );
	// wp_dequeue_script( 'fatmenu' );
	wp_dequeue_script( 'citeo' );
	// wp_dequeue_script( 'beaver' );
	wp_dequeue_script( 'gmap-api' );
	wp_dequeue_script( 'jquery' );
	// wp_dequeue_script( 'simple-photoswipe' );
	// wp_dequeue_script( 'photoswipe' );
	// wp_dequeue_script( 'bootstrap' );
	wp_dequeue_script( 'modernizr' );
	// wp_dequeue_script( 'google-map-init' );




	wp_enqueue_style( 'source-sans-pro', 'http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700,400italic,700italic,900' );
	wp_enqueue_style( 'font-awesome' );
	wp_enqueue_style( 'beaver' );
	wp_enqueue_style( 'photoswipe-core-css' );
	wp_enqueue_style( 'photoswipe-default-skin' );
	wp_enqueue_style( 'citeo-fat-menu', get_template_directory_uri() . '/assets/css/jquery.fatmenu.min.css' );
	wp_enqueue_style( 'citeo-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'demo-2-theme', get_stylesheet_directory_uri() . '/assets/css/demo2.css' );

	wp_enqueue_script( 'jquery' );
	// wp_enqueue_script( 'jquery-local', get_stylesheet_directory_uri() . '/assets/js/jquery.min.js' );
	wp_enqueue_script( 'modernizr' );
	wp_enqueue_script( 'gmap-api' );

	if (is_front_page()) {
		wp_enqueue_script( 'front-page', get_stylesheet_directory_uri() . '/assets/js/front-page.js', array(), '20150722', true );
	}
	wp_enqueue_script( 'app', get_stylesheet_directory_uri() . '/assets/js/app.js', array(), '20150722', true );

	// Custom Child Theme css
}


/*
 * Make theme available for translation.
 * Translations can be filed in the /languages/ directory.
 * If you're building a theme based on citeo, use a find and replace
 * to change 'child-theme' to the name of your theme in all the template files
 */
add_action('after_setup_theme', 'child_theme_setup', 20);

function child_theme_setup(){

	remove_image_size('citeo-slideshow');
	add_image_size( 'citeo-slideshow', 1110, 362, true );

	remove_image_size('citeo-thumbnail');
	add_image_size( 'citeo-thumbnail', 350, 204, true );
	
	remove_image_size('citeo-full');
	add_image_size( 'citeo-full', 717, 420, true );

	remove_image_size('citeo-minisite');
	add_image_size( 'citeo-minisite', 360, 315, true );

	remove_image_size('citeo-shortline');
	add_image_size( 'citeo-shortline', 110, 126, true );

	remove_image_size('citeo-partenaire');
	add_image_size( 'citeo-partenaire', 240, 150, false );

	remove_image_size('citeo-logo');
	add_image_size( 'citeo-logo', 130, 152, false );

	remove_image_size('citeo-icon');
	add_image_size( 'citeo-icon', 108, 108, false );

	remove_image_size('citeo-logo-retina');
	add_image_size( 'citeo-logo-retina', 260, 304, false );

	remove_image_size('citeo-portrait');
	add_image_size( 'citeo-portrait', 250, 332, true );

	remove_image_size('citeo-portrait');
	add_image_size( 'citeo-portrait', 206, 236, true );

	load_theme_textdomain('child-theme', get_template_directory() . '/languages');

}


function enable_more_buttons($buttons) {
  $buttons[] = 'hr';
  $buttons[] = 'anchor';

  /*
  Repeat with any other buttons you want to add, e.g.
	  $buttons[] = 'fontselect';
	  $buttons[] = 'sup';
  */

  return $buttons;
}
add_filter("mce_buttons", "enable_more_buttons");

$sage_includes = [
	'inc/CPT/offres-emploi.php',
	'inc/TAX/offres-emploi.php',
	'inc/ACF/offres-emploi.php',

	'inc/ACF/extras-infos.php',
	'inc/ACF/related.php',

	'inc/TAX/profils.php',
	'inc/TAX/groupes.php',
];

foreach ($sage_includes as $file) {
  if (!$filepath = locate_template($file)) {
    trigger_error(sprintf(__('Error locating %s for inclusion', 'sage'), $file), E_USER_ERROR);
  }
  require_once $filepath;
}

unset($file, $filepath);
