<?php

if ( ! function_exists('emploi_post_type') ) {

// Register Custom Post Type
function emploi_post_type() {

	$labels = array(
		'name'                => _x( 'Emplois', 'Post Type General Name', 'citeo' ),
		'singular_name'       => _x( 'Emploi', 'Post Type Singular Name', 'citeo' ),
		'menu_name'           => __( 'Offres d\'emploi', 'citeo' ),
		'name_admin_bar'      => __( 'Offres d\'emploi', 'citeo' ),
		'parent_item_colon'   => __( 'Element parent :', 'citeo' ),
		'all_items'           => __( 'Toutes les offres', 'citeo' ),
		'add_new_item'        => __( 'Ajouter une offre', 'citeo' ),
		'add_new'             => __( 'Ajouter', 'citeo' ),
		'new_item'            => __( 'Nouvelle offre', 'citeo' ),
		'edit_item'           => __( 'Modifier l\'offre', 'citeo' ),
		'update_item'         => __( 'Mettre à jour l\'offre', 'citeo' ),
		'view_item'           => __( 'Voir l\'offre', 'citeo' ),
		'search_items'        => __( 'Rechercher', 'citeo' ),
		'not_found'           => __( 'Non trouvée', 'citeo' ),
		'not_found_in_trash'  => __( 'Non trouvée dans la corbeille', 'citeo' ),
	);
	$args = array(
		'label'               => __( 'emploi', 'citeo' ),
		'description'         => __( 'Offres d\'emploi', 'citeo' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'excerpt' ),
		'taxonomies'          => array( 'emploi_category', 'emploi_type', 'emploi_secteur' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => '',
		'menu_icon'           => 'dashicons-businessman',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => false,		
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
	);
	register_post_type( 'emploi', $args );

}

// Hook into the 'init' action
add_action( 'init', 'emploi_post_type', 0 );

}
