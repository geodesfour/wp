<?php

if( function_exists('acf_add_local_field_group') ):

$page_accueil = get_page_by_title('Accueil');

acf_add_local_field_group(array (
	'key' => 'sur-le-meme-sujet',
	'title' => 'Sur le même sujet',
	'fields' => array (
		array (
			'key' => 'field_55b9e4ab510c9',
			'label' => 'Contenu associés',
			'name' => 'citeo_extra_related_content',
			'type' => 'relationship',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'post_type' => array (
			),
			'taxonomy' => array (
			),
			'filters' => array (
				0 => 'search',
				1 => 'post_type',
				2 => 'taxonomy',
			),
			'elements' => array (
				0 => 'featured_image',
			),
			'min' => '',
			'max' => '',
			'return_format' => 'object',
		),
	),
	'location' => array (
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
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'actualite',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
));

endif;