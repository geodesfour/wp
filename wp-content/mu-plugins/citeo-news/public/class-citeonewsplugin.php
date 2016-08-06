<?php
/**
 * Citeo_News_Plugin
 *
 * @package   Citeo_News_Plugin
 * @author    Thomas MARGUENOT <t.marguenot@agence-belle-epoque.fr>
 * @license   GPL-2.0+
 * @link      http://wordpress.org/plugins
 * @copyright 2014 Thomas MARGUENOT
 */

/**
 * Citeo_News_Plugin class. This class should ideally be used to work with the
 * public-facing side of the WordPress site.
 *
 * If you're interested in introducing administrative or dashboard
 * functionality, then refer to `class-citeonewsplugin-admin.php`
 *
 * @package Citeo_News_Plugin
 * @author  Thomas MARGUENOT <t.marguenot@agence-belle-epoque.fr>
 */
class Citeo_News_Plugin {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	const VERSION = '0.1';

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
	protected $plugin_slug = 'citeonewsplugin';

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
		add_action( 'init', array( $this, 'news_post_type' ) );
		add_action( 'init', array( $this, 'news_custom_fields' ) );
		add_action( 'init', array( $this, 'news_options' ) );
		add_action( 'init', array( $this, 'taxonomy_thematique' ) );

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
	 * Register post type "actualite"
	 *
	 * @since    1.0.0
	 */
	public function news_post_type() {
		$labels = array(
			'name'                => 'Actualités',
			'singular_name'       => 'Actualité',
			'menu_name'           => 'Actualités',
			'parent_item_colon'   => 'Actualité parente :',
			'all_items'           => 'Toutes les actualités',
			'view_item'           => 'Voir l\'actualité',
			'add_new_item'        => 'Ajouter une nouvelle actualité',
			'add_new'             => 'Ajouter',
			'edit_item'           => 'Editer actualité',
			'update_item'         => 'Mettre à jour actualité',
			'search_items'        => 'Rechercher actualité',
			'not_found'           => 'Non trouvé',
			'not_found_in_trash'  => 'Non trouvé dans la corbeille',
		);
		$args = array(
			'label'               => 'actualite',
			'description'         => 'Type de contenu actualité',
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', ),
			'taxonomies'          => array( 'thematique', 'post_tag' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 6,
			'menu_icon'           => 'dashicons-format-aside',
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'page',
		);
		register_post_type( 'actualite', $args );
	}

	// Register Custom Taxonomy
	function taxonomy_thematique() {

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
		register_taxonomy( 'thematique', array( 'breve', 'actualite', 'evenement' ), $args );

	}




	/**
	* Register custom fields to news cpt
	*
	* @since    1.0.0
	*/
	public function news_custom_fields() {
		if(function_exists("register_field_group"))
		{

			register_field_group(array (
				'key' => 'group_99ef49b9b87de',
				'title' => 'Carrousel',
				'fields' => array (
					array (
						'key' => 'field_54ef49c0b4597',
						'label' => '',
						'name' => 'carrousel',
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
							0 => 'actualite',
							1 => 'evenement',
							2 => 'page',
						),
						'taxonomy' => '',
						'filters' => array (
							0 => 'search',
							1 => 'post_type',
						),
						'elements' => array (
							0 => 'featured_image',
						),
						'max' => 5,
						'return_format' => 'object',
					),
				),
				'location' => array (
					array (
						array (
							'param' => 'page_template',
							'operator' => '==',
							'value' => 'page-templates/evenements.php',
						),
					),
					array (
						array (
							'param' => 'page_template',
							'operator' => '==',
							'value' => 'page-templates/actualites.php',
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
	* Register options for news
	*
	* @since    1.0.0
	*/
	public function news_options() {
		if( function_exists('register_field_group') ):

			register_field_group(array (
				'key' => 'group_54ef571e27766',
				'title' => 'Options des actualités',
				'fields' => array (
					array (
						'key' => 'field_54ef571e2d560',
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
						'key' => 'field_54ef571e2d580',
						'label' => 'Nombre d\'élément par page',
						'name' => 'opt_news_nb_per_page',
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
						'key' => 'field_54ef571e2d58d',
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
						'key' => 'field_54ef571e2d599',
						'label' => 'Activer les filtres',
						'name' => 'opt_news_filters_activated',
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
						'key' => 'field_54ef571e2d5c0',
						'label' => 'Filtrer par thématiques',
						'name' => 'opt_news_display_thematic_filter',
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
	.taxonomy-thematique .term-parent-wrap,
	#newthematique_parent
	{
		display: none;
	}
	.wpseo-admin-page #sidebar-container, .wpseo-admin-page #i18n_promo_box {
		display: none;
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
