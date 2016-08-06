<?php

if ( ! function_exists( 'profils_taxonomy' ) ) {

// Register Custom Taxonomy
function profils_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Profils', 'Taxonomy General Name', 'citeo' ),
		'singular_name'              => _x( 'Profil', 'Taxonomy Singular Name', 'citeo' ),
		'menu_name'                  => __( 'Profils', 'citeo' ),
		'all_items'                  => __( 'Tous les profils', 'citeo' ),
		'parent_item'                => __( 'Element parent', 'citeo' ),
		'parent_item_colon'          => __( 'Element parent :', 'citeo' ),
		'new_item_name'              => __( 'Nouveau profil', 'citeo' ),
		'add_new_item'               => __( 'Ajouter un profil', 'citeo' ),
		'edit_item'                  => __( 'Modifier le profil', 'citeo' ),
		'update_item'                => __( 'Mettre à jour le profil', 'citeo' ),
		'view_item'                  => __( 'Voir le profil', 'citeo' ),
		'separate_items_with_commas' => __( 'Séparer par des virgules', 'citeo' ),
		'add_or_remove_items'        => __( 'Ajouter ou supprimer', 'citeo' ),
		'choose_from_most_used'      => __( 'Choisissez parmi les plus utilisés', 'citeo' ),
		'popular_items'              => __( 'Les plus populaires', 'citeo' ),
		'search_items'               => __( 'Rechercher', 'citeo' ),
		'not_found'                  => __( 'Non trouvé', 'citeo' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'profils', array( 'page', 'actualite', 'evenement' ), $args );

}

// Hook into the 'init' action
add_action( 'init', 'profils_taxonomy', 0 );

}
