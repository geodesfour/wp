<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       inovagora.net
 * @since      1.0.0
 *
 * @package    Citeo_Interactive_Map
 * @subpackage Citeo_Interactive_Map/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Citeo_Interactive_Map
 * @subpackage Citeo_Interactive_Map/public
 * @author     Christophe Béghin <cbeghin@inovagora.net>
 */
class Citeo_Interactive_Map_Public {


	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $citeo_interactive_map    The ID of this plugin.
	 */
	private $citeo_interactive_map;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $citeo_interactive_map       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $citeo_interactive_map, $version ) {

		$this->citeo_interactive_map = $citeo_interactive_map;
		$this->version = $version;

		// Activate plugin when new blog is added
		add_action( 'wpmu_new_blog', array( $this, 'activate_new_site' ) );

		add_action( 'init', array( $this, 'map_marker_post_type' ) );
		add_action( 'init', array( $this, 'map_marker_custom_fields' ) );
		add_action( 'init', array( $this, 'map_marker_options' ) );
		add_action( 'init', array( $this, 'taxonomy_category_map' ) );

		add_action( 'admin_head', array( $this, 'add_admin_styles' ) );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Citeo_Interactive_Map_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Citeo_Interactive_Map_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->citeo_interactive_map, plugin_dir_url( __FILE__ ) . 'css/citeo-interactive-map-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Citeo_Interactive_Map_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Citeo_Interactive_Map_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->citeo_interactive_map, plugin_dir_url( __FILE__ ) . 'js/citeo-interactive-map-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Fired when a new site is activated with a WPMU environment.
	 *
	 * @since    1.0.0
	 *
	 * @param    int    $blog_id    ID of the new blog.
	 */
	public function activate_new_site( $blog_id ) {

		if ( 1 !== did_action( 'wpmu_new_blog' ) ) {
			return;
		}

		switch_to_blog( $blog_id );
		self::single_activate();
		restore_current_blog();

	}

	/**
	 * Register post type "evenement"
	 *
	 * @since    1.0.0
	 */
	public function map_marker_post_type() {
		$labels = array(
			"name" => "Carte",
			"singular_name" => "Carte",
			"menu_name" => "Carte interactive",
			"all_items" => "Tous les points",
			"add_new" => "Ajouter",
			"add_new_item" => "Ajouter un point",
			"edit" => "Modifier",
			"edit_item" => "Modifier",
			"new_item" => "Nouveau point",
			"view" => "Voir",
			"view_item" => "Voir le point",
			"search_items" => "Rechercher",
			"not_found" => "Non trouvé",
			"not_found_in_trash" => "Rien dans la corbeille",
			"parent" => "Point Parent",
			);

		$args = array(
			"labels" => $labels,
			"description" => "",
			"public" => true,
			"show_ui" => true,
			"has_archive" => false,
			"show_in_menu" => true,
			"exclude_from_search" => true,
			"capability_type" => "post",
			"map_meta_cap" => true,
			"hierarchical" => false,
			"rewrite" => array( "slug" => "map_marker", "with_front" => true ),
			"query_var" => true,
			"menu_icon" => "dashicons-location-alt",
			"supports" => array( "title", "editor", "thumbnail" ),
			"taxonomies" => array( "category_map" )	);
		register_post_type( "map_marker", $args );

	}



	/**
	 * Register taxonomy "Lieu"
	 *
	 * @since    1.0.0
	 */
	function taxonomy_category_map() {

		$labels = array(
			"name" => "Catégories",
			"label" => "Catégories",
		);

		$args = array(
			'label'  => 'category_map',
			"labels" => $labels,
			"hierarchical" => true,
			"label" => "Catégories",
			"show_ui" => true,
			"query_var" => true,
			"rewrite" => array( 'slug' => 'category_map', 'with_front' => true ),
			"show_admin_column" => false,
		);
		register_taxonomy( "category_map", array( "map_marker" ), $args );

	}


	/**
	* Register custom fields to event cpt
	*
	* @since    1.0.0
	*/
	public function map_marker_custom_fields() {

		if( function_exists('register_field_group') ):

		register_field_group(array (
			'key' => 'group_5526d497e045b',
			'title' => 'Carte',
			'fields' => array (
				array (
					'key' => 'field_5526d49a48b60',
					'label' => 'Position',
					'name' => 'location',
					'prefix' => '',
					'type' => 'google_map',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'center_lat' => '48.856614',
					'center_lng' => '2.352222',
					'zoom' => 5,
					'height' => '',
				),
				array (
					'key' => 'field_5526d4a948b61',
					'label' => 'Tracé',
					'name' => 'kml',
					'prefix' => '',
					'type' => 'file',
					'instructions' => 'Fichier .kml, .kmz',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'return_format' => 'array',
					'library' => 'all',
					'min_size' => '',
					'max_size' => '',
					'mime_types' => '',
				),
			),
			'location' => array (
				array (
					array (
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'map_marker',
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

		register_field_group(array (
			'key' => 'group_5526d4cb262f3',
			'title' => 'Icone carte catégorie',
			'fields' => array (
				array (
					'key' => 'field_5526d4cd97891',
					'label' => 'Icône',
					'name' => 'icone',
					'prefix' => '',
					'type' => 'image',
					'instructions' => 'Générez votre icône ici https://mapicons.mapsmarker.com',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'return_format' => 'array',
					'preview_size' => 'thumbnail',
					'library' => 'all',
					'min_width' => '',
					'min_height' => '',
					'min_size' => '',
					'max_width' => '',
					'max_height' => '',
					'max_size' => '',
					'mime_types' => '',
				),
			),
			'location' => array (
				array (
					array (
						'param' => 'taxonomy',
						'operator' => '==',
						'value' => 'category_map',
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

	}

	/**
	 * Fired for each blog when the plugin is activated.
	 *
	 * @since    1.0.0
	 */
	private static function single_activate() {
		// @TODO: Define activation functionality here
	}

	/**
	 * Fired for each blog when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 */
	private static function single_deactivate() {
		// @TODO: Define deactivation functionality here
	}
	

	/**
	* Register options for events
	*
	* @since    1.0.0
	*/
	public function map_marker_options() {

		if( function_exists('register_field_group') ):


		endif;
	}

	/**
	* Custom admin style
	*
	* @since    1.0.4
	*/
	public function add_admin_styles() {
	//
	// <style>
	// .taxonomy-thematique .term-parent-wrap,
	// #newthematique_parent
	// {
	// 	display: none
	// }
	// .taxonomy-lieu .term-parent-wrap,
	// #newlieu_parent
	// {
	// 	display: none
	// }
	// </style>

	// 
	}



}
