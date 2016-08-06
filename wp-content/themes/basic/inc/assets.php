<?php 

/**
 * Enqueue scripts and styles.
 */
if ( ! function_exists ( 'citeo_scripts' ) ) {
function citeo_scripts() {

	wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css', array(), null, 'all' );
	wp_enqueue_style( 'beaver', get_template_directory_uri().'/assets/css/beaver.min.css', array(), '20150316' );
	wp_enqueue_style( 'fatmenu', get_template_directory_uri().'/assets/css/jquery.fatmenu.min.css', array(), '20150316' );
	wp_enqueue_style( 'citeo', get_template_directory_uri().'/assets/css/theme.css', array(), '20150316' );
	wp_enqueue_style( 'citeo-style', get_template_directory_uri().'/style.css', array(), '20150316' );

	// wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/assets/js/modernizr.min.js', array(), '20150316', false );
	
	wp_deregister_script( 'jquery' );
	wp_enqueue_script( 'jquery', '//code.jquery.com/jquery-1.11.2.min.js', array(), null, false );
	wp_enqueue_script( 'gmap-api', 'http://maps.google.com/maps/api/js?sensor=true', array(), null, false );
	wp_enqueue_script( 'google-map-init', get_template_directory_uri() . '/assets/js/google-maps.js', array('gmap-api', 'jquery'), '0.1', true );

	global $is_IE;

    // Return early, if not IE
    if ( $is_IE ) {
	    // Include the file, if needed
	    if ( ! function_exists( 'wp_check_browser_version' ) ) {
	        include_once( ABSPATH . 'wp-admin/includes/dashboard.php' );
		}

	    // IE version conditional enqueue
	    $response = wp_check_browser_version();
	    if ( 0 > version_compare( intval( $response['version'] ) , 9 ) ) {
			wp_enqueue_script( 'citeo-html5shiv', get_template_directory_uri() . '/assets/js/html5shiv.min.js', array(), '20150316', false );
			wp_enqueue_script( 'citeo-respond', get_template_directory_uri() . '/assets/js/respond.min.js', array(), '20150316', false );
		}
	}

	wp_enqueue_script( 'bootstrap', '//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js', array(), null, true );
	wp_enqueue_script( 'beaver', get_template_directory_uri() . '/assets/js/beaver.min.js', array(), '20150316', true );
	wp_enqueue_script( 'fatmenu', get_template_directory_uri() . '/assets/js/jquery.fatmenu.min.js', array(), '20150316', true );

	wp_enqueue_script( 'citeo', get_template_directory_uri() . '/assets/js/app.js', array(), '20150316', true );

	
}
add_action( 'wp_enqueue_scripts', 'citeo_scripts' );

}

