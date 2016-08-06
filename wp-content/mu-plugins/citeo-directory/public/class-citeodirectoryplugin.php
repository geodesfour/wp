<?php
/**
 * Citeo_Directory_Plugin
 *
 * @package   Citeo_Directory_Plugin
 * @author    Thomas MARGUENOT <salutation@agence-belle-epoque.fr>
 * @license   GPL-2.0+
 * @link      http://wordpress.org/plugins
 * @copyright 2014 Thomas MARGUENOT
 */

/**
 * Citeo_Directory_Plugin class. This class should ideally be used to work with the
 * public-facing side of the WordPress site.
 *
 * If you're interested in introducing administrative or dashboard
 * functionality, then refer to `class-citeodirectoryplugin-admin.php`
 *
 * @package Citeo_Directory_Plugin
 * @author  Thomas MARGUENOT <salutation@agence-belle-epoque.fr>
 */
class Citeo_Directory_Plugin {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	const VERSION = '0.0.1';

	/**
	 * Unique identifier for your plugin.
	 *
	 *
	 * The variable name is used as the text domain when internationalizing strings
	 * of text. Its value should match the Text Domain file header in the main
	 * plugin file.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'citeodirectoryplugin';

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// Activate plugin when new blog is added
		add_action( 'wpmu_new_blog', array( $this, 'activate_new_site' ) );

		// Load public-facing style sheet and JavaScript.
		// add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		// add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		/* Define custom functionality.
		 * Refer To http://codex.wordpress.org/Plugin_API#Hooks.2C_Actions_and_Filters
		 */
		
		add_action( 'init', array( $this, 'directory_post_type' ) );
		add_action( 'init', array( $this, 'directory_custom_fields' ) );
		add_action( 'init', array( $this, 'directory_options' ) );
		add_action( 'init', array( $this, 'taxonomy_directory_categorie' ) );

		add_action( 'admin_head', array( $this, 'add_admin_styles' ) );

		add_filter( '@TODO', array( $this, 'filter_method_name' ) );

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
	 * Register and enqueue public-facing style sheet.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_slug . '-plugin-styles', plugins_url( 'assets/css/public.css', __FILE__ ), array(), self::VERSION );
	}

	/**
	 * Register and enqueues public-facing JavaScript files.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_slug . '-plugin-script', plugins_url( 'assets/js/public.js', __FILE__ ), array( 'jquery' ), self::VERSION );
	}

	/**
	* Register post type "annuaire"
	*
	* @since    1.0.0
	*/
	public function directory_post_type() {
		$labels = array(
			'name'                => 'Annuaire',
			'singular_name'       => 'Annuaire',
			'menu_name'           => 'Annuaire',
			'parent_item_colon'   => 'Fiche Parente :',
			'all_items'           => 'Toutes les fiches',
			'view_item'           => 'Voir la fiche',
			'add_new_item'        => 'Ajouter une nouvelle fiche',
			'add_new'             => 'Ajouter',
			'edit_item'           => 'Modifier une fiche',
			'update_item'         => 'Mettre à jour la fiche',
			'search_items'        => 'Rechercher',
			'not_found'           => 'Non trouvé',
			'not_found_in_trash'  => 'Non trouvé dans la corbeille',
		);
		$args = array(
			'label'               => 'fiche-annuaire',
			'description'         => 'Type de contenu personnalisé annuaire',
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'thumbnail', ),
			'taxonomies'          => array( 'categorie', 'lieu', 'post_tag' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => '',
			'menu_icon' 		  => 'dashicons-clipboard',
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'page',
		);
		register_post_type( 'fiche-annuaire', $args );
	}


	/**
	 * Register taxonomy "Catégorie"
	 *
	 * @since    1.0.0
	 */
	function taxonomy_directory_categorie() {

		$labels = array(
			'name'                       => _x( 'Catégories', 'Taxonomy General Name', 'text_domain' ),
			'singular_name'              => _x( 'Catégorie', 'Taxonomy Singular Name', 'text_domain' ),
			'menu_name'                  => __( 'Catégories', 'text_domain' ),
			'all_items'                  => __( 'Toutes les catégories', 'text_domain' ),
			'parent_item'                => __( 'Élément parent', 'text_domain' ),
			'parent_item_colon'          => __( 'Élément parent :', 'text_domain' ),
			'new_item_name'              => __( 'Nouvelle catégorie', 'text_domain' ),
			'add_new_item'               => __( 'Ajouter une nouvelle catégorie', 'text_domain' ),
			'edit_item'                  => __( 'Modifier la catégorie', 'text_domain' ),
			'update_item'                => __( 'Mettre à jour la catégorie', 'text_domain' ),
			'separate_items_with_commas' => __( 'Séparer avec des virgules', 'text_domain' ),
			'search_items'               => __( 'Rechercher une catégorie', 'text_domain' ),
			'add_or_remove_items'        => __( 'Ajouter ou supprimer des catégories', 'text_domain' ),
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
		register_taxonomy( 'categorie', array( 'fiche-annuaire' ), $args );

	}

	/**
	* Register custom fields to directory cpt
	*
	* @since    1.0.0
	*/
	public function directory_custom_fields() {
		if(function_exists("register_field_group"))
		{
			register_field_group(array (
				'id' => 'acf_directory-acf',
				'title' => 'directory acf',
				'fields' => array (
					array (
						'key' => 'field_54bfd0325628b',
						'label' => 'Complément d\'information',
						'name' => 'complement_info',
						'type' => 'wysiwyg',
						'default_value' => '',
						'toolbar' => 'full',
						'media_upload' => 'yes',
					),
					array (
						'key' => 'field_54d296fcbd7a5',
						'label' => 'Adresse',
						'name' => 'address',
						'type' => 'google_map',
						'center_lat' => '48.856614',
						'center_lng' => '2.352222',
						'zoom' => '12',
						'height' => 400,
					),
				),
				'location' => array (
					array (
						array (
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'fiche-annuaire',
							'order_no' => 0,
							'group_no' => 0,
						),
					),
				),
				'options' => array (
					'position' => 'normal',
					'layout' => 'no_box',
					'hide_on_screen' => array (
						0 => 'custom_fields',
						1 => 'comments',
						2 => 'format',
						3 => 'send-trackbacks',
					),
				),
				'menu_order' => 0,
			));
		}
	}


	/**
	* Register options for directory
	*
	* @since    1.0.0
	*/
	public function directory_options() {
		if( function_exists('register_field_group') ):

			register_field_group(array (
				'key' => 'group_54ef5bb56d463',
				'title' => 'Options de l\'annuaire',
				'fields' => array (
					array (
						'key' => 'field_54ef5bb57280b',
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
						'key' => 'field_54ef5bb57284d',
						'label' => 'Nombre d\'élément par page',
						'name' => 'opt_directory_nb_per_page',
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
						'key' => 'field_54ef5c845e89e',
						'label' => 'Afficher la carte',
						'name' => 'opt_directory_display_map',
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
						'message' => '',
						'default_value' => 1,
						),
					array (
						'key' => 'field_54ef6277379b4',
						'label' => 'Ordre d\'affichage',
						'name' => 'opt_directory_order_display',
						'prefix' => '',
						'type' => 'select',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
							),
						'choices' => array (
							'title' => 'Alphabétique',
							'menu_order' => 'Manuel',
							'rand'	=> 'Aléatoire',
							),
						'default_value' => array (
							'title' => 'title',
							),
						'allow_null' => 0,
						'multiple' => 0,
						'ui' => 0,
						'ajax' => 0,
						'placeholder' => '',
						'disabled' => 0,
						'readonly' => 0,
						),
					array (
						'key' => 'field_54ef5bb572862',
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
						'key' => 'field_54ef5bb572878',
						'label' => 'Activer les filtres',
						'name' => 'opt_directory_filters_activated',
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
						'key' => 'field_54ef5bb5728a3',
						'label' => 'Filtrer par catégorie',
						'name' => 'opt_directory_display_category_filter',
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
						'message' => 'Afficher le filtre de tri par catégorie',
						'default_value' => 1,
						),
					array (
						'key' => 'field_54ef5bb5728b9',
						'label' => 'Filtrer par lieu',
						'name' => 'opt_directory_display_place_filter',
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
						'message' => 'Afficher le filtre de tri par lieu',
						'default_value' => 1,
						),
					array (
						'key' => 'field_54ef5c335e89d',
						'label' => 'Filtrer par mot-clés',
						'name' => 'opt_directory_display_search_filter',
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
						'message' => 'Afficher le filtre de tri par mots clés',
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
	.taxonomy-lieu .term-parent-wrap,
	#newlieu_parent
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
