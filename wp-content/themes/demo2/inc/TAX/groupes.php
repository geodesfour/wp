<?php

if ( ! function_exists( 'groupe_taxonomy' ) ) {

// Register Custom Taxonomy
function groupe_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Groupes', 'Taxonomy General Name', 'citeo' ),
		'singular_name'              => _x( 'Groupe', 'Taxonomy Singular Name', 'citeo' ),
		'menu_name'                  => __( 'Groupes', 'citeo' ),
		'all_items'                  => __( 'Tous les groupes', 'citeo' ),
		'parent_item'                => __( 'Element parent', 'citeo' ),
		'parent_item_colon'          => __( 'Parent : ', 'citeo' ),
		'new_item_name'              => __( 'Nouveau groupe', 'citeo' ),
		'add_new_item'               => __( 'Ajouter un groupe', 'citeo' ),
		'edit_item'                  => __( 'Modifier le groupe', 'citeo' ),
		'update_item'                => __( 'Mettre à jour le froupe', 'citeo' ),
		'view_item'                  => __( 'Voir le groupe', 'citeo' ),
		'separate_items_with_commas' => __( 'Séparer les éléments par des virgules', 'citeo' ),
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
	register_taxonomy( 'groupe', array( 'fiche-trombinoscope' ), $args );

}
add_action( 'init', 'groupe_taxonomy', 0 );

}
