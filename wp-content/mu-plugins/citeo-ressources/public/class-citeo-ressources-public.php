<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       inovagora.net
 * @since      1.0.0
 *
 * @package    Citeo_Ressources
 * @subpackage Citeo_Ressources/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Citeo_Ressources
 * @subpackage Citeo_Ressources/public
 * @author     Christophe Béghin <cbeghin@inovagora.net>
 */
class Citeo_Ressources_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $citeo_ressources    The ID of this plugin.
	 */
	private $citeo_ressources;

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
	 * @param      string    $citeo_ressources       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $citeo_ressources, $version ) {

		$this->citeo_ressources = $citeo_ressources;
		$this->version = $version;

		// Load plugin text domain
		//add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// Activate plugin when new blog is added
		//add_action( 'wpmu_new_blog', array( $this, 'activate_new_site' ) );

		// Load public-facing style sheet and JavaScript.
		// add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		// add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		/* Define custom functionality.
		 * Refer To http://codex.wordpress.org/Plugin_API#Hooks.2C_Actions_and_Filters
		 */
		add_action( 'init', array( $this, 'ressources_documentaires_post_type' ) );
		add_action( 'init', array( $this, 'ressources_documentaires_custom_fields' ) );
		add_action( 'init', array( $this, 'ressources_documentaires_options' ) );		
		add_action( 'init', array( $this, 'taxonomy_type_ressource' ) );
		add_action( 'init', array( $this, 'taxonomy_thematique' ) );	
			

		add_action( 'admin_head', array( $this, 'add_admin_styles' ) );

	}

	/**
	 * Return the plugin slug.
	 *
	 * @since    1.0.0
	 *
	 * @return    Plugin slug variable.
	 */
	public function get_plugin_slug() {
		return $this->plugin_slug;
	}


	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Fired when the plugin is activated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses
	 *                                       "Network Activate" action, false if
	 *                                       WPMU is disabled or plugin is
	 *                                       activated on an individual blog.
	 */
	public static function activate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide  ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_activate();
				}

				restore_current_blog();

			} else {
				self::single_activate();
			}

		} else {
			self::single_activate();
		}

	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses
	 *                                       "Network Deactivate" action, false if
	 *                                       WPMU is disabled or plugin is
	 *                                       deactivated on an individual blog.
	 */
	public static function deactivate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_deactivate();

				}

				restore_current_blog();

			} else {
				self::single_deactivate();
			}

		} else {
			self::single_deactivate();
		}

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
	 * Get all blog ids of blogs in the current network that are:
	 * - not archived
	 * - not spam
	 * - not deleted
	 *
	 * @since    1.0.0
	 *
	 * @return   array|false    The blog ids, false if no matches.
	 */
	private static function get_blog_ids() {

		global $wpdb;

		// get an array of blog ids
		$sql = "SELECT blog_id FROM $wpdb->blogs
			WHERE archived = '0' AND spam = '0'
			AND deleted = '0'";

		return $wpdb->get_col( $sql );

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
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		$domain = $this->plugin_slug;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, FALSE, basename( plugin_dir_path( dirname( __FILE__ ) ) ) . '/languages/' );

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
		 * defined in Citeo_Ressources_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Citeo_Ressources_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		// wp_enqueue_style( $this->citeo_ressources, plugin_dir_url( __FILE__ ) . 'css/citeo-ressources-public.css', array(), $this->version, 'all' );

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
		 * defined in Citeo_Ressources_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Citeo_Ressources_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->citeo_ressources, plugin_dir_url( __FILE__ ) . 'js/citeo-ressources-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register post type "ressource"
	 *
	 * @since    1.0.0
	 */
	public function ressources_documentaires_post_type() {
		$labels = array(
			'name'                => 'Ressources',
			'singular_name'       => 'Ressource',
			'menu_name'           => 'Ressources',
			'parent_item_colon'   => 'Ressource parente :',
			'all_items'           => 'Toutes les ressources',
			'view_item'           => 'Voir la ressource',
			'add_new_item'        => 'Ajouter une nouvelle ressource ',
			'add_new'             => 'Ajouter',
			'edit_item'           => 'Editer ressource',
			'update_item'         => 'Mettre à jour ressource',
			'search_items'        => 'Rechercher ressource',
			'not_found'           => 'Non trouvé',
			'not_found_in_trash'  => 'Non trouvé dans la corbeille',
		);
		$args = array(
			'label'               => 'ressource',
			'description'         => 'Type de contenu ressource',
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', ),
			'taxonomies'          => array( 'thematique', 'lieu' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => '',
			'menu_icon'           => 'dashicons-portfolio',
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'page',
		);
		register_post_type( 'ressource', $args );
	}

	// Register Custom Taxonomy
	public function taxonomy_thematique() {

		$labels = array(
			'name'                       => _x( 'Thématiques', 'Taxonomy General Name', 'text_domain' ),
			'singular_name'              => _x( 'Thématique', 'Taxonomy Singular Name', 'text_domain' ),
			'menu_name'                  => __( 'Thématiques', 'text_domain' ),
			'all_items'                  => __( 'Toutes les thématiques', 'text_domain' ),
			'parent_item'                => __( 'Élément parent', 'text_domain' ),
			'parent_item_colon'          => __( 'Élément parent :', 'text_domain' ),
			'new_item_name'              => __( 'Nouvelle thématique', 'text_domain' ),
			'add_new_item'               => __( 'Ajouter une nouvelle thématique', 'text_domain' ),
			'edit_item'                  => __( 'Modifier la thématique', 'text_domain' ),
			'update_item'                => __( 'Mettre à jour la thématique', 'text_domain' ),
			'separate_items_with_commas' => __( 'Séparer avec des virgules', 'text_domain' ),
			'search_items'               => __( 'Rechercher une thématique', 'text_domain' ),
			'add_or_remove_items'        => __( 'Ajouter ou supprimer des thématiques', 'text_domain' ),
			'choose_from_most_used'      => __( 'Choisir dans les plus utilisés', 'text_domain' ),
			'not_found'                  => __( 'Aucun résultat', 'text_domain' ),
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
		register_taxonomy( 'thematique_ressource', array( 'ressource' ), $args );

	}

	public function taxonomy_type_ressource() {

		$labels = array(
			'name'                       => _x( 'Types de documents', 'Taxonomy General Name', 'text_domain' ),
			'singular_name'              => _x( 'Type', 'Taxonomy Singular Name', 'text_domain' ),
			'menu_name'                  => __( 'Types de documents', 'text_domain' ),
			'all_items'                  => __( 'Tous les types', 'text_domain' ),
			'parent_item'                => __( 'Élément parent', 'text_domain' ),
			'parent_item_colon'          => __( 'Élément parent :', 'text_domain' ),
			'new_item_name'              => __( 'Nouveau type', 'text_domain' ),
			'add_new_item'               => __( 'Ajouter un nouveau type', 'text_domain' ),
			'edit_item'                  => __( 'Modifier le type', 'text_domain' ),
			'update_item'                => __( 'Mettre à jour le type', 'text_domain' ),
			'separate_items_with_commas' => __( 'Séparer avec des virgules', 'text_domain' ),
			'search_items'               => __( 'Rechercher un type', 'text_domain' ),
			'add_or_remove_items'        => __( 'Ajouter ou supprimer des types', 'text_domain' ),
			'choose_from_most_used'      => __( 'Choisir dans les plus utilisés', 'text_domain' ),
			'not_found'                  => __( 'Aucun résultat', 'text_domain' ),
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
		register_taxonomy( 'type_ressource', array( 'ressource' ), $args );

	}


	/**
	* Register custom fields to ressources cpt
	*
	* @since    1.0.0
	*/
	public function ressources_documentaires_custom_fields() {
		if( function_exists('register_field_group') ) {

			register_field_group(array (
				'key' => 'group_55112f30d71c3',
				'title' => 'Ressouces documentaires',
				'fields' => array (

					array (
						'key' => 'field_55113050e70d9',
						'label' => 'Date de parution',
						'name' => 'citeo_ressources_date_parution',
						'prefix' => '',
						'type' => 'date_picker',
						'instructions' => '',
						'required' => 1,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'display_format' => 'd/m/Y',
						'return_format' => 'Ymd',
						'first_day' => 1,
					),
					array (
						'key' => 'field_5511311fe70da',
						'label' => 'Document(s) lié(s)',
						'name' => 'citeo_ressources_documents_lies',
						'prefix' => '',
						'type' => 'repeater',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'min' => '',
						'max' => '',
						'layout' => 'table',
						'button_label' => 'Ajouter un élément',
						'sub_fields' => array (
							array (
								'key' => 'field_5511751a76675',
								'label' => 'Liste des documents',
								'name' => 'document',
								'prefix' => '',
								'type' => 'file',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array (
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'return_format' => 'array',
								'library' => 'all',
							),
						),
					),
					array (
						'key' => 'field_5511365af557c',
						'label' => 'Ressource(s) externe(s)',
						'name' => 'citeo_ressources_ressources_externes',
						'prefix' => '',
						'type' => 'repeater',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'min' => '',
						'max' => '',
						'layout' => 'table',
						'button_label' => 'Ajouter un élément',
						'sub_fields' => array (
							array (
								'key' => 'field_551f2345a1171',
								'label' => 'Titre du lien',
								'name' => 'titre_url',
								'prefix' => '',
								'type' => 'text',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array (
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'default_value' => '',
								'placeholder' => '',
							),
							array (
								'key' => 'field_55117745a1175',
								'label' => 'URL du lien',
								'name' => 'url_du_site',
								'prefix' => '',
								'type' => 'url',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array (
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'default_value' => '',
								'placeholder' => '',
							),
						),
					),
					array (
						'key' => 'field_55254ec367708',
						'label' => 'Ressources liée(s)',
						'name' => 'citeo_ressources_ressources_liees',
						'prefix' => '',
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
							0 => 'ressource',
						),
						'taxonomy' => '',
						'filters' => array (
							0 => 'search',
							1 => 'taxonomy',
						),
						'elements' => '',
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
							'value' => 'ressource',
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

			}
	}

	/**
	* Register options for ressources
	*
	* @since    1.0.0
	*/
	public function ressources_documentaires_options() {
		if( function_exists('register_field_group') ):

			register_field_group(array (
				'key' => 'group_54ij571e27766',
				'title' => 'Options des ressources',
				'fields' => array (
					array (
						'key' => 'field_54ij571e2dfdf60',
						'label' => 'Options générales',
						'name' => '',
						'prefix' => '',
						'type' => 'tab',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
							),
						'placement' => 'left',
						),
					array (
						'key' => 'field_54ij571985d580',
						'label' => 'Nombre d\'élément par page',
						'name' => 'opt_ressources_nb_per_page',
						'prefix' => '',
						'type' => 'number',
						'instructions' => '(-1 pour tout afficher)',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
							),
						'default_value' => 12,
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'min' => '',
						'max' => '',
						'step' => 1,
						'readonly' => 0,
						'disabled' => 0,
						),
					array (
						'key' => 'field_54ij57fg22d58d',
						'label' => 'Moteur de filtres',
						'name' => '',
						'prefix' => '',
						'type' => 'tab',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
							),
						'placement' => 'left',
						),
					array (
						'key' => 'field_54ij515d2d599',
						'label' => 'Activer les filtres',
						'name' => 'opt_ressources_filters_activated',
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
						'message' => 'Permettre à l\'internaute de filtrer les fiches',
						'default_value' => 1,
						),
					array (
						'key' => 'field_54ij57185d5c0',
						'label' => 'Filtrer par thématiques',
						'name' => 'opt_ressources_display_thematic_filter',
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
						'message' => 'Afficher le filtre de tri par liste',
						'default_value' => 1,
						),
					array (
						'key' => 'field_54ij5d5185d5c0',
						'label' => 'Filtrer par types',
						'name' => 'opt_ressources_display_types_filter',
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
						'message' => 'Afficher le filtre de tri par liste',
						'default_value' => 1,
						),
					array (
						'key' => 'field_54ij553c696cd',
						'label' => 'Filtrer par date',
						'name' => 'opt_ressources_display_date_filter',
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
						'message' => 'Afficher le filtre de tri par dates',
						'default_value' => 1,
						),
					),
					'location' => array (
						array (
							array (
								'param' => 'options_page',
								'operator' => '==',
								'value' => 'options-citeo-modules',
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
	* Custom admin style
	*
	* @since    1.0.4
	*/
	public function add_admin_styles() {
	?>
	<style>
	.taxonomy-thematique_ressource .term-parent-wrap,
	.taxonomy-type_ressource .term-parent-wrap,
	#newthematique_ressource_parent,
	#newtype_ressource_parent
	{
		display: none
	}
	</style>

	<?php
	}

	/**
	 * NOTE:  Filters are points of execution in which WordPress modifies data
	 *        before saving it or sending it to the browser.
	 *
	 *        Filters: http://codex.wordpress.org/Plugin_API#Filters
	 *        Reference:  http://codex.wordpress.org/Plugin_API/Filter_Reference
	 *
	 * @since    1.0.0
	 */
	public function filter_method_name() {
		// @TODO: Define your filter hook callback here
	}
}
