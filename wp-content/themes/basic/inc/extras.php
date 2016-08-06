<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package citeo
 */




if ( ! function_exists( 'terms_clauses' ) ) :

/**
 * How to get_terms for post type
 * @TODO : please describe this
 */
function terms_clauses($clauses, $taxonomy, $args) {
	if (isset($args['post_type']) && !empty($args['post_type']) && is_array($args['post_type']))	{

		global $wpdb;
		$post_types = array();
		foreach($args['post_type'] as $cpt)	{
			$post_types[] = "'".$cpt."'";
		}

	    if(!empty($post_types))	{
			$clauses['fields'] = 'DISTINCT '.str_replace('tt.*', 'tt.term_taxonomy_id, tt.term_id, tt.taxonomy, tt.description, tt.parent', $clauses['fields']).', COUNT(t.term_id) AS count';
			$clauses['join'] .= ' INNER JOIN '.$wpdb->term_relationships.' AS r ON r.term_taxonomy_id = tt.term_taxonomy_id INNER JOIN '.$wpdb->posts.' AS p ON p.ID = r.object_id';
			$clauses['where'] .= ' AND p.post_type IN ('.implode(',', $post_types).')';
			$clauses['orderby'] = 'GROUP BY t.term_id '.$clauses['orderby'];
		}
    }
    return $clauses;
}

add_filter('terms_clauses', 'terms_clauses', 10, 3);
endif;


if ( ! function_exists( 'citeo_page_menu_args' ) ) :

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @param array $args Configuration arguments.
 * @return array
 */
function citeo_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'citeo_page_menu_args' );

endif;

if ( ! function_exists( 'citeo_body_classes' ) ) :

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function citeo_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'citeo_body_classes' );
endif;


// if ( ! function_exists( 'citeo_wp_title' ) ) :

// /**
//  * Filters wp_title to print a neat <title> tag based on what is being viewed.
//  *
//  * @param string $title Default title text for current view.
//  * @param string $sep Optional separator.
//  * @return string The filtered title.
//  */
// function citeo_wp_title( $title, $sep ) {
// 	if ( is_feed() ) {
// 		return $title;
// 	}

// 	global $page, $paged;

// 	// Add the blog name
// 	$title .= get_bloginfo( 'name', 'display' );

// 	// Add the blog description for the home/front page.
// 	$site_description = get_bloginfo( 'description', 'display' );
// 	if ( $site_description && ( is_home() || is_front_page() ) ) {
// 		$title .= " $sep $site_description";
// 	}

// 	// Add a page number if necessary:
// 	if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
// 		$title .= " $sep " . sprintf( __( 'Page %s', 'citeo' ), max( $paged, $page ) );
// 	}

// 	return $title;
// }
// add_filter( 'wp_title', 'citeo_wp_title', 10, 2 );

// endif;


if ( ! function_exists( 'citeo_setup_author' ) ) :

/**
 * Sets the authordata global when viewing an author archive.
 *
 * This provides backwards compatibility with
 * http://core.trac.wordpress.org/changeset/25574
 *
 * It removes the need to call the_post() and rewind_posts() in an author
 * template to print information about the author.
 *
 * @global WP_Query $wp_query WordPress Query object.
 * @return void
 */
function citeo_setup_author() {
	global $wp_query;

	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
	}
}
add_action( 'wp', 'citeo_setup_author' );
endif;

if ( ! function_exists( 'prevent_homepage_deleting' ) ) :
/**
 * Prevent homepage from being moved to trash
 * @param  [type] $allcaps [description]
 * @param  [type] $cap     [description]
 * @param  [type] $args    [description]
 * @return [type]          [description]
 */
function prevent_homepage_deleting( $allcaps, $cap, $args ) {

		if ( 'delete_post' != $args[0] ){
			return $allcaps;
		}

		if ( get_option( 'page_on_front' ) != $args[2] ){
			return $allcaps;
		}

		$allcaps[$cap[0]] = false;

		return $allcaps;
}

add_filter( 'user_has_cap', 'prevent_homepage_deleting', 10, 3 );
endif;

if ( ! function_exists( 'remove_footer_admin' ) ) :
/**
 * Change the copyright bottom left
 * @return [type] [description]
 */
function remove_footer_admin () {
	echo '<span id="footer-thankyou">Merci de faire de <a href="http://www.inovagora.net/">Citéo</a> votre outil de création.</span>';
}

add_filter('admin_footer_text', 'remove_footer_admin');
endif;

if ( ! function_exists( 'wpbeginner_remove_version' ) ) :
/**
 * Remove WordPress version information (bottom right)
 * @return [type] [description]
 */
function wpbeginner_remove_version() {
	return '';
}
add_filter('the_generator', 'wpbeginner_remove_version');
endif;



// add a favicon for your admin
// function admin_favicon() {
// 	echo '<link rel="Shortcut Icon" type="image/x-icon" href="'.get_bloginfo('stylesheet_directory').'/images/favicon.png" />';
// }
// add_action('admin_head', 'admin_favicon');


if ( ! function_exists( 'remove_menus' ) ) :

// Change admin menu items
function remove_menus(){
	// remove_menu_page( 'index.php' );               // Dashboard
	remove_menu_page( 'edit.php' );                   // Posts
	remove_menu_page('edit.php?post_type=posts');     // Posts
	// remove_menu_page( 'upload.php' );              // Media
	// remove_menu_page( 'edit.php?post_type=page' ); // Pages
	remove_menu_page( 'edit-comments.php' );       	  // Comments
	// remove_menu_page( 'themes.php' );              // Appearance
	// remove_menu_page( 'plugins.php' );             // Plugins
	// remove_menu_page( 'users.php' );               // Users
	// remove_menu_page( 'tools.php' );               // Tools
	// remove_menu_page( 'options-general.php' );     // Settings

}
add_action( 'admin_menu', 'remove_menus' );
endif;

if ( ! function_exists( 'feed_filters' ) ) :
/**
 * Change the feed rss
 * @return 
 */
function feed_filters($query) {
  if ($query->is_feed) {
    $query->set('post_type', array( 'page', 'evenement', 'actualite'));
  }
  return $query;
}
add_filter('pre_get_posts','feed_filters');
endif;



if ( ! function_exists( 'add_citeo_mime_types' ) ) :
/* Permet de rajouter des champs de recherche dans la médiathèque */
function add_citeo_mime_types( $post_mime_types ) {
 
    // select the mime type, here: 'application/pdf'
    // then we define an array with the label values
 
    $post_mime_types['application/pdf'] = array( __( 'PDFs' ), __( 'Manage PDFs' ), _n_noop( 'PDF <span class="count">(%s)</span>', 'PDFs <span class="count">(%s)</span>' ) );
    $post_mime_types['application/vnd.openxmlformats-officedocument.presentationml.presentation'] = array( __( 'Powerpoints' ), __( 'Manage Powerpoints' ), _n_noop( 'Powerpoints <span class="count">(%s)</span>', 'Powerpoints <span class="count">(%s)</span>' ) );
    $post_mime_types['application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document'] = array( __( 'Documents' ), __( 'Manage Documents' ), _n_noop( 'Documents <span class="count">(%s)</span>', 'Documents <span class="count">(%s)</span>' ) );

    // then we return the $post_mime_types variable
    return $post_mime_types; 
} 
// Add Filter Hook
add_filter( 'post_mime_types', 'add_citeo_mime_types' );
endif;


if ( ! function_exists( 'citeo_update_slug' ) ) :
function citeo_update_slug( $data, $postarr ) {
    if ( !in_array( $data['post_status'], array( 'draft', 'pending', 'auto-draft' ) ) ) {
    	//tool::output($data);
    	$exclude = array('acf-field', 'acf', 'acf-group');
    	if(!in_array($data['post_type'], $exclude)){
    		$data['post_name'] = sanitize_title( $data['post_title'] );
    	}
    }

    return $data;
}
add_filter( 'wp_insert_post_data', 'citeo_update_slug', 99, 2 );
endif;


if ( ! function_exists( 'my_mce_buttons' ) ) :
//Creating the style selector stayed the same
function my_mce_buttons( $buttons ) {
   //array_unshift( $buttons, 'styleselect' );
   $buttons[] = 'styleselect' ;
   return $buttons;
}
add_filter('mce_buttons', 'my_mce_buttons');

function mce_mod( $init ) {
   //theme_advanced_blockformats seems deprecated - instead the hook from Helgas post did the trick
   $init['block_formats'] = "";

   //$init['style_formats']  doesn't work - instead you have to use tinymce style selectors
   $style_formats = array(   
    array(
        'title' => 'Mise en avant',
        'block' => 'div',
        'classes' => 'well',
        'wrapper' => true
    )
   );
   $init['style_formats'] = json_encode( $style_formats );
   // Removing h1 from list
   $init['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6;Preformatted=pre';
   return $init;
}
add_filter('tiny_mce_before_init', 'mce_mod');
endif;
