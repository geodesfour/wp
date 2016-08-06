<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package citeo
 */

$page_accueil = get_page_by_title('Accueil');



if ($page_accueil && $page_accueil->ID > 0) {

	/**
	 * Don't touch it!
	 */
	$location = array(
					array(
						array(
			                'param' => 'page',
			                'operator' => '==',
			                'value' => (string) $page_accueil->ID,
			                'order_no' => 0,
			                'group_no' => 0
	                	)
	                )
	            );
	$options = array(
	                'position' => 'normal',
	                'layout' => 'default',
	                'hide_on_screen' => array(
	                    0 => 'the_content'
	                )
	            );
	$menu_order = 1;






	/**
	 * Carrousel
	 */
    if (function_exists("register_field_group")) {
        register_field_group(array(
            'id' => 'acf_accueil_carrousel',
            'title' => 'Le carrousel',
            'fields' => array(
                array(
                    'key' => 'field_54609ec2b9184',
                    'label' => '',
                    'name' => 'citeo_carrousel',
                    'type' => 'relationship',
                    'return_format' => 'object',
                    'post_type' => array(
                        0 => 'page',
                        1 => 'actualite'
                    ),
                    'taxonomy' => array(
                        0 => 'all'
                    ),
			'filters' => array (
				0 => 'search',
				1 => 'post_type',
			),
                    'result_elements' => array(
                        0 => 'featured_image', 
                        1 => 'post_type',
                        2 => 'post_title'
                    ),
                    'max' => ''
                )
            ),
            'location' => $location,
            'options' => $options,
            'menu_order' => $menu_order++,
        ));
    }


	/**
	 * Accès directs
	 */
    if (function_exists("register_field_group")) {
        register_field_group(array(
            'id' => 'acf_accueil_acces_direct',
            'title' => 'Les accès direct',
            'fields' => array(
                array(
                    'key' => 'field_5460c250c9df0',
                    'label' => '',
                    'name' => 'citeo_acces_direct',
                    'type' => 'repeater',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_5460c2bfc9df1',
                            'label' => 'Titre accès direct',
                            'name' => 'citeo_titre_ac',
                            'type' => 'text',
                            'column_width' => '',
                            'default_value' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'formatting' => 'html',
                            'maxlength' => ''
                        ),
                        array(
                            'key' => 'field_5460c2dbc9df2',
                            'label' => 'Image accès direct',
                            'name' => 'citeo_image_ac',
                            'type' => 'image',
                            'column_width' => '',
                            'save_format' => 'object',
                            'preview_size' => 'thumbnail',
                            'library' => 'all'
                        ),
                        array(
                            'key' => 'field_5464d1f359eb6',
                            'label' => 'Code couleur accès direct',
                            'name' => 'citeo_couleur_ac',
                            'type' => 'color_picker',
                            'column_width' => '',
                            'default_value' => ''
                        ),
                        array(
                            'key' => 'field_5460c329c9df3',
                            'label' => 'Lien interne accès direct',
                            'name' => 'citeo_lien_ac',
                            'type' => 'relationship',
                            'column_width' => '',
                            'return_format' => 'object',
                            'post_type' => array(
                                0 => 'page'
                            ),
                            'taxonomy' => array(
                                0 => 'all'
                            ),
                            'filters' => array(
                                0 => 'search'
                            ),
                            'result_elements' => array(
                                0 => 'post_type',
                                1 => 'post_title'
                            ),
                            'max' => ''
                        ),
                        array(
                            'key' => 'field_5464d24559eb7',
                            'label' => 'Lien externe accès direct',
                            'name' => 'citeo_lien_ext_ac',
                            'type' => 'text',
                            'column_width' => '',
                            'default_value' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'formatting' => 'html',
                            'maxlength' => ''
                        ),
                        array(
                            'key' => 'ouvrir-le-lien-dans-un-nouvel-onglet',
                            'label' => 'Nouvel onglet',
                            'name' => 'citeo_lien_new_tab',
                            'prefix' => '',
                            'type' => 'true_false',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array (
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'message' => 'Ouvrir le lien extérieur dans un nouvel onglet',
                            'default_value' => 0,
                        ),
                    ),
                    'row_min' => '',
                    'row_limit' => '',
                    'layout' => 'row',
                    'button_label' => 'Ajouter un accès direct'
                )
            ),
            'location' => $location,
            'options' => $options,
            'menu_order' => $menu_order++,
        ));
    }


	/**
	 * Les actualités à la une
	 */
    if (function_exists("register_field_group")) {
        register_field_group(array(
            'id' => 'acf_accueil_actualites',
            'title' => 'Les actualités à la une',
            'fields' => array(
                array(
                    'key' => 'field_5460c594bddf7',
                    'label' => '',
                    'name' => 'citeo_actu_star',
                    'type' => 'relationship',
                    'return_format' => 'object',
                    'post_type' => array(
                        0 => 'actualite'
                    ),
                    'taxonomy' => array(
                        0 => 'all'
                    ),
                    'filters' => array(
                        0 => 'search'
                    ),
                    'result_elements' => array(
                        0 => 'featured_image',
                        1 => 'post_type',
                        2 => 'post_title'
                    ),
                    'max' => 4
                )
            ),
            'location' => $location,
            'options' => $options,
            'menu_order' => $menu_order++,
        ));
    }

    /**
     * Les brèves
     */
    if (function_exists("register_field_group")) {
        register_field_group(array(
            'id' => 'acf_accueil_breves',
            'title' => 'Les brèves',
            'fields' => array(
                array(
                    'key' => 'field_5450c594bhdf7',
                    'label' => '',
                    'name' => 'citeo_breves',
                    'type' => 'relationship',
                    'return_format' => 'object',
                    'post_type' => array(
                        0 => 'breve'
                    ),
                    'taxonomy' => array(
                        0 => 'all'
                    ),
                    'filters' => array(
                        0 => 'search'
                    ),
                    'result_elements' => array(
                        0 => 'featured_image',
                        1 => 'post_type',
                        2 => 'post_title'
                    ),
                    'max' => 4
                )
            ),
            'location' => $location,
            'options' => $options,
            'menu_order' => $menu_order++,
        ));
    }
    

	/**
	 * Les minisites
	 */
    if (function_exists("register_field_group")) {
        register_field_group(array(
            'id' => 'acf_accueil_minisites',
            'title' => 'Les minisites',
            'fields' => array(
                array(
                    'key' => 'field_5464d37bd6577',
                    'label' => 'Mise en avant',
                    'name' => 'citeo_minisites',
                    'type' => 'repeater',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_5464d40ad6578',
                            'label' => 'Titre',
                            'name' => 'citeo_minisites_titre',
                            'type' => 'text',
                            'column_width' => '',
                            'default_value' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'formatting' => 'html',
                            'maxlength' => ''
                        ),
                        array(
                            'key' => 'field_5464d41bd6579',
                            'label' => 'Image',
                            'name' => 'citeo_minisites_image',
                            'type' => 'image',
                            'column_width' => '',
                            'save_format' => 'object',
                            'preview_size' => 'medium',
                            'library' => 'all'
                        ),
                        array(
                            'key' => 'field_5464d435d657a',
                            'label' => 'Lien',
                            'name' => 'citeo_minisites_lien',
                            'type' => 'text',
                            'column_width' => '',
                            'default_value' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'formatting' => 'html',
                            'maxlength' => ''
                        )
                    ),
                    'row_min' => '',
                    'row_limit' => 2,
                    'layout' => 'row',
                    'button_label' => 'Ajouter un minisite'
                ),
                
                array(
                    'key' => 'field_5464d4db674f0',
                    'label' => 'Les autres minisites',
                    'name' => 'citeo_minisites_carrousel',
                    'type' => 'repeater',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_5464d4db674f2',
                            'label' => 'Image',
                            'name' => 'citeo_minisites_image',
                            'type' => 'image',
                            'column_width' => '',
                            'save_format' => 'object',
                            'preview_size' => 'medium',
                            'library' => 'all'
                        ),
                        array(
                            'key' => 'field_5464d4db674f3',
                            'label' => 'Lien',
                            'name' => 'citeo_minisites_lien',
                            'type' => 'text',
                            'column_width' => '',
                            'default_value' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'formatting' => 'html',
                            'maxlength' => ''
                        )
                    ),
                    'row_min' => '',
                    'row_limit' => '',
                    'layout' => 'row',
                    'button_label' => 'Ajouter un minisite'
                )
            ),
            'location' => $location,
            'options' => $options,
            'menu_order' => $menu_order++,
        ));
    }


	/**
	 * Le kiosque
	 */
    if (function_exists("register_field_group")) {
        register_field_group(array(
            'id' => 'acf_accueil_kiosque',
            'title' => 'Le kiosque',
            'fields' => array(
                array(
                    'key' => 'field_5464d540696f3',
                    'label' => 'Publication mise en avant',
                    'name' => 'citeo_carrousel_kiosque',
                    'type' => 'relationship',
                    'return_format' => 'object',
                    'post_type' => array(
                        0 => 'publication'
                    ),
                    'taxonomy' => array(
                        0 => 'all'
                    ),
                    'filters' => array(
                        0 => 'search'
                    ),
                    'result_elements' => array(
                        0 => 'post_type',
                        1 => 'post_title'
                    ),
                    'max' => ''
                )
            ),
            'location' => $location,
            'options' => $options,
            'menu_order' => $menu_order++,
        ));
    }
    

	/**
	 * Carte de la ville
	 */
    if (function_exists("register_field_group")) {
        register_field_group(array(
            'id' => 'acf_accueil_carte_de_la_ville',
            'title' => 'Carte de la ville',
            'fields' => array(
                array(
                    'key' => 'field_54d294d9ec830',
                    'label' => '',
                    'name' => 'map_city',
                    'type' => 'google_map',
                    'center_lat' => '48.856614',
                    'center_lng' => '2.352222',
                    'zoom' => '12',
                    'height' => ''
                ),
                array(
                    'key' => 'field_54d29625ec831',
                    'label' => 'Zoom par défaut',
                    'name' => 'map_city_zoom',
                    'type' => 'number',
                    'default_value' => '10',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'min' => 4,
                    'max' => 16,
                    'step' => 1
                )
            ),
            'location' => $location,
            'options' => $options,
            'menu_order' => $menu_order++,
        ));
    }
    

	/**
	 * Les contacts
	 */
    if (function_exists("register_field_group")) {
        register_field_group(array(
            'id' => 'acf_accueil_contact_info',
            'title' => 'Les contacts',
            'fields' => array(
                array(
                    'key' => 'field_5464da17284fb',
                    'label' => '',
                    'name' => 'citeo_adresse_accueil',
                    'type' => 'repeater',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_5464deba284fc',
                            'label' => 'Contenu adresse',
                            'name' => 'citeo_texte_adresse',
                            'type' => 'wysiwyg',
                            'column_width' => '',
                            'default_value' => '',
                            'toolbar' => 'full',
                            'media_upload' => 'yes'
                        ),
                        array(
                            'key' => 'field_54d296fcbd7a5',
                            'label' => 'Point sur la carte',
                            'name' => 'map_city_marker',
                            'type' => 'google_map',
                            'center_lat' => '48.856614',
                            'center_lng' => '2.352222',
                            'zoom' => '12',
                            'height' => 300
                        )
                    ),
                    'row_min' => '',
                    'row_limit' => '',
                    'layout' => 'row',
                    'button_label' => 'Ajouter une adresse'
                )
            ),
            'location' => $location,
            'options' => $options,
            'menu_order' => $menu_order++,
        ));
    }


if( function_exists('register_field_group') ):

register_field_group(array (
    'key' => 'group_5500a4480ebc5',
    'title' => 'Alerte',
    'fields' => array (
        array (
            'key' => 'field_5500a45697783',
            'label' => 'Message d\'alerte',
            'name' => 'citeo_message_texte',
            'prefix' => '',
            'type' => 'text',
            'instructions' => 'Message d\'alerte temporaire à diffuser sur la page d\'accueil',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array (
                'width' => 80,
                'class' => '',
                'id' => '',
            ),
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'maxlength' => '',
            'readonly' => 0,
            'disabled' => 0,
        ),
        array (
            'key' => 'field_5500a59097784',
            'label' => 'Type de message',
            'name' => 'citeo_message_type',
            'prefix' => '',
            'type' => 'select',
            'instructions' => 'Couleur du message',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array (
                'width' => 20,
                'class' => '',
                'id' => '',
            ),
            'choices' => array (
                'success' => 'Succès (vert)',
                'info' => 'Informatif (bleu)',
                'warning' => 'Attention (orange)',
                'danger' => 'Danger (rouge)',
            ),
            'default_value' => array (
                '' => '',
            ),
            'allow_null' => 0,
            'multiple' => 0,
            'ui' => 0,
            'ajax' => 0,
            'placeholder' => '',
            'disabled' => 0,
            'readonly' => 0,
        ),
    ),
    'location' => $location,
    'options' => $options,
    'menu_order' => $menu_order++,
));

endif;

    

}