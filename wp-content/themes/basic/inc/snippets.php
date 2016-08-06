<?php 


/**
* Change label for posts
*/
// function change_post_menu_label() {
// 	global $menu;
// 	global $submenu;
// 	$menu[5][0] = 'Actualité';
// 	$submenu['edit.php'][5][0] = 'Actualités';
// 	$submenu['edit.php'][10][0] = 'Ajouter des actualités';
// 	echo '';
// }
// add_action( 'admin_menu', 'change_post_menu_label' );


// function change_post_object_label() {
// 	global $wp_post_types;
// 	$labels = &$wp_post_types['post']->labels;
// 	$labels->name = 'Actualités';
// 	$labels->singular_name = 'Actualité';
// 	$labels->add_new = 'Ajouter une actualité';
// 	$labels->add_new_item = 'Ajout actualité';
// 	$labels->edit_item = 'Modifier actualités';
// 	$labels->new_item = 'Actualité';
// 	$labels->view_item = 'Voir l\'actualité';
// 	$labels->search_items = 'Rechercher les actualités';
// 	$labels->not_found = 'Pas d\'actualité trouvé';
// 	$labels->not_found_in_trash = 'Pas d\'actualité trouvé dans la corbeille';
// }
// add_action( 'init', 'change_post_object_label' );




/**
 * Unregister a taxonomy
 * WARNING : display an error message in settings, can NOT use this for now
 */
// add_action( 'init', 'unregister_taxonomy' );
// function unregister_taxonomy()
// {
//     global $wp_taxonomies;
//     $taxonomy = 'category';
//     if ( taxonomy_exists($taxonomy) )
//         unset( $wp_taxonomies[$taxonomy] );
// }



/**
 * Snippet Name: modify custom post type query on archive page
 * Snippet URL: http://www.wpcustoms.net/snippets/modify-custom-post-type-query-on-archive-page/
 */
/*
function wpc_order_post_type_archive( $query ) {
if($query->is_main_query() && is_post_type_archive('evenement' )){
 
		// order post_type and remove pagination
		$query->set('posts_per_page', 1);
		$query->set('order', 'DESC');
	}
}
add_action( 'pre_get_posts', 'wpc_order_post_type_archive' );
*/



// Change admin menu order
// function custom_menu_order($menu_ord) {
//     if (!$menu_ord) return true;
     
//     return array(
//         'index.php', // Dashboard
//         'separator1', // First separator
//         'edit.php?post_type=actualite', // Posts
//         'edit.php?post_type=evenement', // Posts
//         'edit.php?post_type=annuaire', // Posts
//         'edit.php?post_type=kiosque', // Posts
//         'edit.php?post_type=trombinoscope', // Posts
//         'edit.php?post_type=page', // Posts
//         'upload.php', // Media
//         'edit.php?post_type=menu', // Posts
//         'separator2', // Second separator
//         'themes.php', // Appearance
//         'plugins.php', // Plugins
//         'users.php', // Users
//         'tools.php', // Tools
//         'options-general.php', // Settings
//         'edit.php?post_type=acf', // ACF
//         'separator-last', // Last separator
//     );
// }
// add_filter('custom_menu_order', 'custom_menu_order'); // Activate custom_menu_order
// add_filter('menu_order', 'custom_menu_order');




/*
Ajouter les excerpt aux pages
add_action( 'init', 'my_add_excerpts_to_pages' );
function my_add_excerpts_to_pages() {
     add_post_type_support( 'page', 'excerpt' );
}



 */




 ?>