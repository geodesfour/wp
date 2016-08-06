<?php

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles', 100);
function theme_enqueue_styles() {
	
	wp_enqueue_style( 'citeo-fat-menu', get_template_directory_uri() . '/assets/css/jquery.fatmenu.min.css' );
	//wp_enqueue_style( 'child-theme-styles', get_template_directory_uri() . '/assets/css/styles.min.css' );
	wp_enqueue_style( 'citeo-style', get_template_directory_uri() . '/style.css' );

	// Custom Child Theme css
	wp_enqueue_style( 'demo-theme-style', get_stylesheet_directory_uri() . '/assets/css/app.css' );
	wp_enqueue_style( 'demo-style', get_stylesheet_directory_uri() . '/style.css' );
	//wp_dequeue_style( 'citeo-styles' );
	//wp_deregister_style( 'citeo-styles' );
}


/*
 * Make theme available for translation.
 * Translations can be filed in the /languages/ directory.
 * If you're building a theme based on citeo, use a find and replace
 * to change 'child-theme' to the name of your theme in all the template files
 */
add_action('after_setup_theme', 'demo_theme_setup', 20);

function demo_theme_setup(){
	remove_image_size('citeo-portrait-square');
	add_image_size( 'citeo-portrait-square', 194, 250, array( 'center', 'top' ) );
	load_theme_textdomain('demo', get_template_directory() . '/languages');
}