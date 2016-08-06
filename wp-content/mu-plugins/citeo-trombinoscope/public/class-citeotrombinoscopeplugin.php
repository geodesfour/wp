<?php
/**
 * Trombinoscope_Plugin
 *
 * @package   Trombinoscope_Plugin
 * @author    Thomas MARGUENOT <salutation@agence-belle-epoque.fr>
 * @license   GPL-2.0+
 * @link      http://wordpress.org/plugins
 * @copyright 2014 Thomas MARGUENOT
 */

/**
 * Trombinoscope_Plugin class. This class should ideally be used to work with the
 * public-facing side of the WordPress site.
 *
 * If you're interested in introducing administrative or dashboard
 * functionality, then refer to `class-citeotrombinoscopeplugin-admin.php`
 *
 * @package Trombinoscope_Plugin
 * @author  Thomas MARGUENOT <salutation@agence-belle-epoque.fr>
 */
class Trombinoscope_Plugin {

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
	protected $plugin_slug = 'citeotrombinoscopeplugin';

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
		add_action( 'init', array( $this, 'trombinoscope_post_type' ) );
		add_action( 'init', array( $this, 'trombinoscope_custom_fields' ) );
		add_action( 'init', array( $this, 'trombinoscope_options' ) );
		add_action( 'init', array( $this, 'taxonomy_trombinoscope_delegation' ) );
		add_action( 'init', array( $this, 'taxonomy_trombinoscope_political_party' ) );

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
	* Register post type "trombinoscope"
	*
	* @since    1.0.0
	*/
	public function trombinoscope_post_type() {
		$labels = array(
			'name'                => 'Trombinoscope',
			'singular_name'       => 'Trombinoscope',
			'menu_name'           => 'Trombinoscope',
			'parent_item_colon'   => 'Fiche Parente :',
			'all_items'           => 'Toutes les fiches',
			'view_item'           => 'Voir la fiche',
			'add_new_item'        => 'Ajouter une nouvelle fiche',
			'add_new'             => 'Ajouter',
			'edit_item'           => 'Modifier',
			'update_item'         => 'Mettre à jour',
			'search_items'        => 'Rechercher',
			'not_found'           => 'Non trouvée',
			'not_found_in_trash'  => 'Non trouvée dans la corbeille',
		);
		$args = array(
			'label'               => 'fiche-trombinoscope',
			'description'         => 'Type de contenu personnalisé Trombinoscope',
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes', ),
			'taxonomies'          => array( 'delegation', 'post_tag' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => '',
			'menu_icon' 		  => 'dashicons-id-alt',
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'page',
		);
		register_post_type( 'fiche-trombinoscope', $args );
	}

	// Register Custom Taxonomy
	function taxonomy_trombinoscope_delegation() {

		$labels = array(
			'name'                       => _x( 'Commissions', 'Taxonomy General Name', 'text_domain' ),
			'singular_name'              => _x( 'Commission', 'Taxonomy Singular Name', 'text_domain' ),
			'menu_name'                  => __( 'Commissions', 'text_domain' ),
			'all_items'                  => __( 'Toutes les commissions', 'text_domain' ),
			'parent_item'                => __( 'Commission parente', 'text_domain' ),
			'parent_item_colon'          => __( 'Commission parente :', 'text_domain' ),
			'new_item_name'              => __( 'Nouvelle commission', 'text_domain' ),
			'add_new_item'               => __( 'Ajouter une nouvelle commission', 'text_domain' ),
			'edit_item'                  => __( 'Modifier la commission', 'text_domain' ),
			'update_item'                => __( 'Mettre à jour la commission', 'text_domain' ),
			'separate_items_with_commas' => __( 'Séparer avec des virgules', 'text_domain' ),
			'search_items'               => __( 'Rechercher une commission', 'text_domain' ),
			'add_or_remove_items'        => __( 'Ajouter ou supprimer des commissions', 'text_domain' ),
			'choose_from_most_used'      => __( 'Choisir dans les plus utilisées', 'text_domain' ),
			'not_found'                  => __( 'Non trouvée', 'text_domain' ),
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
		register_taxonomy( 'delegation', array( 'fiche-trombinoscope' ), $args );

	}

	function taxonomy_trombinoscope_political_party() {

		$labels = array(
			'name'                       => _x( 'Parti politique', 'Taxonomy General Name', 'text_domain' ),
			'singular_name'              => _x( 'Parti politique', 'Taxonomy Singular Name', 'text_domain' ),
			'menu_name'                  => __( 'Partis politiques', 'text_domain' ),
			'all_items'                  => __( 'Tous les partis politiques', 'text_domain' ),
			'parent_item'                => __( 'Parti politique parent', 'text_domain' ),
			'parent_item_colon'          => __( 'Parti politique parent :', 'text_domain' ),
			'new_item_name'              => __( 'Nouveau parti politique', 'text_domain' ),
			'add_new_item'               => __( 'Ajouter un nouveau parti politique', 'text_domain' ),
			'edit_item'                  => __( 'Modifier le parti politique', 'text_domain' ),
			'update_item'                => __( 'Mettre à jour le parti politique', 'text_domain' ),
			'separate_items_with_commas' => __( 'Séparer avec des virgules', 'text_domain' ),
			'search_items'               => __( 'Rechercher un parti politique', 'text_domain' ),
			'add_or_remove_items'        => __( 'Ajouter ou supprimer des partis politiques', 'text_domain' ),
			'choose_from_most_used'      => __( 'Choisir dans les plus utilisés', 'text_domain' ),
			'not_found'                  => __( 'Non trouvé', 'text_domain' ),
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

		register_taxonomy( 'parti-politique', array( 'fiche-trombinoscope' ), $args );

	}


	/**
	* Register custom fields to trombinoscope cpt
	*
	* @since    1.0.0
	*/
	public function trombinoscope_custom_fields() {

		if(function_exists("register_field_group"))
		{

			register_field_group(array (
				'key' => 'group_54ef4d47218a0',
				'title' => 'Vidéo',
				'fields' => array (
					array (
						'key' => 'field_54ef4d557ec59',
						'label' => 'Vidéo',
						'name' => 'video',
						'prefix' => '',
						'type' => 'oembed',
						'instructions' => 'Coller directement le lien de la vidéo (youtube, dialymotion, vimeo...)',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '',
							'class' => 'embed-container',
							'id' => '',
						),
						'width' => '',
						'height' => '',
					),
				),
				'location' => array (
					array (
						array (
							'param' => 'page_template',
							'operator' => '==',
							'value' => 'page-templates/trombinoscope.php',
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
				'id' => 'acf_page-trombi',
				'title' => 'Elu(e)s mis en avant',
				'fields' => array (
					array (
						'key' => 'field_54d38f356bfc0',
						'label' => '',
						'name' => 'elus_mis_en_avant',
						'type' => 'post_object',
						'instructions' => 'Sélectionnez l\'élus qui doit être mis en avant',
						'post_type' => array (
							0 => 'fiche-trombinoscope',
						),
						'taxonomy' => array (
							0 => 'all',
						),
						'allow_null' => 0,
						'multiple' => 0,
					),
				),
				'location' => array (
					array (
						array (
							'param' => 'page_template',
							'operator' => '==',
							'value' => 'page-templates/trombinoscope.php',
							'order_no' => 0,
							'group_no' => 0,
						),
					),
				),
				'options' => array (
					'position' => 'normal',
					'layout' => 'default',
					'hide_on_screen' => array (
					),
				),
				'menu_order' => 0,
			));
			
			register_field_group(array (
				'id' => 'acf_trombinoscope',
				'title' => 'Trombinoscope',
				'fields' => array (
					// array (
					// 	'key' => 'field_546615dcd57a6',
					// 	'label' => 'Nom',
					// 	'name' => 'citeo_nom_trombi',
					// 	'type' => 'text',
					// 	'default_value' => '',
					// 	'placeholder' => '',
					// 	'prepend' => '',
					// 	'append' => '',
					// 	'formatting' => 'html',
					// 	'maxlength' => '',
					// ),
					// array (
					// 	'key' => 'field_54661612d57a7',
					// 	'label' => 'Prénom',
					// 	'name' => 'citeo_prenom_trombi',
					// 	'type' => 'text',
					// 	'default_value' => '',
					// 	'placeholder' => '',
					// 	'prepend' => '',
					// 	'append' => '',
					// 	'formatting' => 'html',
					// 	'maxlength' => '',
					// ),
					array (
						'key' => 'field_5466161ed57a8',
						'label' => 'Date de naissance',
						'name' => 'citeo_date_trombi',
						'type' => 'date_picker',
						'date_format' => 'yymmdd',
						'display_format' => 'dd/mm/yy',
						'first_day' => 1,
					),
					array (
						'key' => 'field_54661642d57a9',
						'label' => 'Fonction/mandat',
						'name' => 'citeo_fonction_trombi',
						'type' => 'text',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'html',
						'maxlength' => '',
					),
					array (
						'key' => 'field_54eafca97190e',
						'label' => 'Majorité / Opposition',
						'name' => 'citeo_liste_trombi',
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
							'' => 'Choisissez',
							'majorite' => 'Majorité',
							'opposition' => 'Opposition',
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

					array (
						'key' => 'field_5466172cd57ab',
						'label' => 'Profession',
						'name' => 'citeo_profession_trombi',
						'type' => 'text',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'html',
						'maxlength' => '',
					),
					array (
						'key' => 'field_54661838d57ac',
						'label' => 'Citation',
						'name' => 'citeo_accroche_trombi',
						'type' => 'wysiwyg',
						'default_value' => '',
						'toolbar' => 'full',
						'media_upload' => 'yes',
					),
					// array (
					// 	'key' => 'field_5466184fd57ad',
					// 	'label' => 'Biographie',
					// 	'name' => 'citeo_bio_trombi',
					// 	'type' => 'wysiwyg',
					// 	'default_value' => '',
					// 	'toolbar' => 'full',
					// 	'media_upload' => 'yes',
					// ),
					// REMOVED on 1.0.7
					array (
						'key' => 'field_54661869d57ae',
						'label' => 'Téléphone',
						'name' => 'citeo_tel_trombi',
						'type' => 'text',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'html',
						'maxlength' => '',
					),
					array (
						'key' => 'field_54661882d57af',
						'label' => 'E-mail',
						'name' => 'citeo_mail_trombi',
						'type' => 'email',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
					),
					array (
						'key' => 'field_54661890d57b0',
						'label' => 'Site internet',
						'name' => 'citeo_site_trombi',
						'type' => 'text',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'html',
						'maxlength' => '',
					),
					array (
						'key' => 'field_546618bfd57b1',
						'label' => 'Compte twitter',
						'name' => 'citeo_twitter_trombi',
						'type' => 'text',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'html',
						'maxlength' => '',
					),
					array (
						'key' => 'field_546618e2d57b2',
						'label' => 'Facebook',
						'name' => 'citeo_fbck_trombi',
						'type' => 'text',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'html',
						'maxlength' => '',
					),
					array (
						'key' => 'field_54661924d57b3',
						'label' => 'Google plus',
						'name' => 'citeo_google_trombi',
						'type' => 'text',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'html',
						'maxlength' => '',
					),
				),
				'location' => array (
					array (
						array (
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'fiche-trombinoscope',
							'order_no' => 0,
							'group_no' => 0,
						),
					),
				),
				'options' => array (
					'position' => 'normal',
					'layout' => 'default',
					'hide_on_screen' => array (
					),
				),
				'menu_order' => 0,
			));
		}





	}


    /**
     * Register trombinoscope options
     *
     * @since    1.0.0
     */
    public function trombinoscope_options() {
    	if( function_exists('register_field_group') ):

    		register_field_group(array (
    			'key' => 'group_54eb890d32570',
    			'title' => 'Options du trombinoscope des élus',
    			'fields' => array (
    				array (
    					'key' => 'field_54ebba2cee8fb',
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
    					'key' => 'field_54ebba9eee8fd',
    					'label' => 'Format des vignettes',
    					'name' => 'opt_trombinoscope_thumbnail_format',
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
    						'rounded' => 'Ronde',
    						'rectangular' => 'Rectangulaire',
    						'square' => 'Carrée',
    						),
    					'default_value' => array (
    						'rounded' => 'rounded',
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
    					'key' => 'field_54ebbde087d3f',
    					'label' => 'Nombre d\'élément par page',
    					'name' => 'opt_trombinoscope_nb_per_page',
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
    					'key' => 'field_54ebba74ee8fc',
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
    					'key' => 'field_54ebaab015f7d',
    					'label' => 'Activer les filtres',
    					'name' => 'opt_trombinoscope_filters_activated',
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
    					'key' => 'field_54ebab2bc063a',
    					'label' => 'Filtrer par mots clés',
    					'name' => 'opt_trombinoscope_display_search_filter',
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
    					'message' => 'Afficher le champs de recherche par mots clés',
    					'default_value' => 1,
    					),
    				array (
    					'key' => 'field_54ebb92e74ef2',
    					'label' => 'Filtrer par commission',
    					'name' => 'opt_trombinoscope_display_delegation_filter',
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
    					'message' => 'Afficher le filtre de tri par commission',
    					'default_value' => 1,
    					),
    				array (
    					'key' => 'field_54ebb9c574ef4',
    					'label' => 'Filtrer par parti politique',
    					'name' => 'opt_trombinoscope_display_party_filter',
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
    					'message' => 'Afficher le filtre de tri par parti politique',
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
	.taxonomy-parti-politique .term-parent-wrap,
	#newparti-politique_parent
	{
		display: none
	}
	.taxonomy-delegation .term-parent-wrap,
	#newdelegation_parent
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
