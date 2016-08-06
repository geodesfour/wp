<?php

if ( ! function_exists( 'emploi_category_taxonomy' ) ) {

// Register Custom Taxonomy
function emploi_category_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Catégories', 'Taxonomy General Name', 'citeo' ),
		'singular_name'              => _x( 'Catégorie', 'Taxonomy Singular Name', 'citeo' ),
		'menu_name'                  => __( 'Catégories', 'citeo' ),
		'all_items'                  => __( 'Toutes les catégories', 'citeo' ),
		'parent_item'                => __( 'Parent', 'citeo' ),
		'parent_item_colon'          => __( 'Parent :', 'citeo' ),
		'new_item_name'              => __( 'Nouvelle catégorie', 'citeo' ),
		'add_new_item'               => __( 'Ajouter une catégorie', 'citeo' ),
		'edit_item'                  => __( 'Modifier la catégorie', 'citeo' ),
		'update_item'                => __( 'Mettre à jour la catégorie', 'citeo' ),
		'view_item'                  => __( 'Voir la catégorie', 'citeo' ),
		'separate_items_with_commas' => __( 'Séparer par des virgules', 'citeo' ),
		'add_or_remove_items'        => __( 'Ajouter ou supprimer', 'citeo' ),
		'choose_from_most_used'      => __( 'Choisissez parmi les plus utilisées', 'citeo' ),
		'popular_items'              => __( 'Les plus populaires', 'citeo' ),
		'search_items'               => __( 'Recherche', 'citeo' ),
		'not_found'                  => __( 'Non trouvé', 'citeo' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
	);
	register_taxonomy( 'emploi_category', array( 'emploi' ), $args );

}

// Hook into the 'init' action
add_action( 'init', 'emploi_category_taxonomy', 0 );

}

if ( ! function_exists( 'emploi_secteur_taxonomy' ) ) {

// Register Custom Taxonomy
function emploi_secteur_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Secteurs', 'Taxonomy General Name', 'citeo' ),
		'singular_name'              => _x( 'Secteur', 'Taxonomy Singular Name', 'citeo' ),
		'menu_name'                  => __( 'Secteurs', 'citeo' ),
		'all_items'                  => __( 'Tous les secteurs', 'citeo' ),
		'parent_item'                => __( 'Parent', 'citeo' ),
		'parent_item_colon'          => __( 'Parent :', 'citeo' ),
		'new_item_name'              => __( 'Nouveau secteur', 'citeo' ),
		'add_new_item'               => __( 'Ajouter un secteur', 'citeo' ),
		'edit_item'                  => __( 'Modifier le secteur', 'citeo' ),
		'update_item'                => __( 'Mettre à jour le secteur', 'citeo' ),
		'view_item'                  => __( 'Voir le secteur', 'citeo' ),
		'separate_items_with_commas' => __( 'Séparer par des virgules', 'citeo' ),
		'add_or_remove_items'        => __( 'Ajouter ou supprimer', 'citeo' ),
		'choose_from_most_used'      => __( 'Choisissez parmi les plus utilisés', 'citeo' ),
		'popular_items'              => __( 'Les plus populaires', 'citeo' ),
		'search_items'               => __( 'Recherche', 'citeo' ),
		'not_found'                  => __( 'Non trouvé', 'citeo' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
	);
	register_taxonomy( 'emploi_secteur', array( 'emploi' ), $args );

}

// Hook into the 'init' action
add_action( 'init', 'emploi_secteur_taxonomy', 0 );

}


if ( ! function_exists( 'emploi_type_taxonomy' ) ) {

// Register Custom Taxonomy
function emploi_type_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Types', 'Taxonomy General Name', 'citeo' ),
		'singular_name'              => _x( 'Type', 'Taxonomy Singular Name', 'citeo' ),
		'menu_name'                  => __( 'Types', 'citeo' ),
		'all_items'                  => __( 'Tous les types', 'citeo' ),
		'parent_item'                => __( 'Parent', 'citeo' ),
		'parent_item_colon'          => __( 'Parent :', 'citeo' ),
		'new_item_name'              => __( 'Nouveau type', 'citeo' ),
		'add_new_item'               => __( 'Ajouter un type', 'citeo' ),
		'edit_item'                  => __( 'Modifier le type', 'citeo' ),
		'update_item'                => __( 'Mettre à jour le type', 'citeo' ),
		'view_item'                  => __( 'Voir le type', 'citeo' ),
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
		'show_tagcloud'              => false,
	);
	register_taxonomy( 'emploi_type', array( 'emploi' ), $args );

}

// Hook into the 'init' action
add_action( 'init', 'emploi_type_taxonomy', 0 );

}
