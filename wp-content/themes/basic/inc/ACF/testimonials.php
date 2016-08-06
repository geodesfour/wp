<?php

if(function_exists("register_field_group")) :

$page_accueil = get_page_by_title('Accueil');

register_field_group(array (
	'id' => 'acf_widgets',
	'title' => 'Témoignages',
	'fields' => array (
		array (
		'key' => 'field_54802eed8761a',
		'label' => 'Titre de l\'encart',
		'name' => 'citeo_titre_widget',
		'type' => 'text',
		'column_width' => '',
		'default_value' => '',
		'placeholder' => '',
		'prepend' => '',
		'append' => '',
		'formatting' => 'html',
		'maxlength' => '',
		),
		array (
		'key' => 'field_54802e728759d',
		'label' => 'Témoignage',
		'name' => 'citeo_font_lactualite',
		'type' => 'repeater',
		'sub_fields' => array (
			array (
			'key' => 'field_54802eed8759e',
			'label' => 'Nom et prénom',
			'name' => 'citeo_nom_profil',
			'type' => 'text',
			'column_width' => '',
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'formatting' => 'html',
			'maxlength' => '',
			),
			array (
			'key' => 'field_54802f4c8759f',
			'label' => 'Image',
			'name' => 'citeo_image_profil',
			'type' => 'image',
			'column_width' => '',
			'save_format' => 'id',
			'preview_size' => 'thumbnail',
			'library' => 'all',
			),
			array (
			'key' => 'field_54802f67875a0',
			'label' => 'Fonction',
			'name' => 'citeo_fonction_profil',
			'type' => 'text',
			'column_width' => '',
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'formatting' => 'html',
			'maxlength' => '',
			),
			array (
			'key' => 'field_54802f7d875a1',
			'label' => 'Citation',
			'name' => 'citeo_citation_profil',
			'type' => 'textarea',
			'column_width' => '',
			'default_value' => '',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => '',
			'formatting' => 'br',
			),
		),
		'row_min' => '',
		'row_limit' => '',
		'layout' => 'row',
		'button_label' => 'Ajouter',
		),
	),
	'location' => array (
		array (
			array (
			'param' => 'post_type',
			'operator' => '==',
			'value' => 'actualite',
			'order_no' => 0,
			'group_no' => 0,
			),
		),
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'page',
			),
			array (
				'param' => 'page',
				'operator' => '!=',
				'value' => (string) $page_accueil->ID,
			),
		),
	),
	'options' => array (
		'position' => 'normal',
		'layout' => 'default',
		'hide_on_screen' => array (
		),
	),
	'menu_order' => 2000,
	)
);

endif;

