<?php
/**
 * Citeo_Options_Plugin
 *
 * @package   Citeo_Options_Plugin
 * @author    Thomas MARGUENOT <salutation@agence-belle-epoque.fr>
 * @license   GPL-2.0+
 * @link      http://wordpress.org/plugins
 * @copyright 2014 Thomas MARGUENOT
 */

/**
 * Citeo_Options_Plugin class. This class should ideally be used to work with the
 * public-facing side of the WordPress site.
 *
 * If you're interested in introducing administrative or dashboard
 * functionality, then refer to `class-citeooptionsplugin-admin.php`
 *
 * @package Citeo_Options_Plugin
 * @author  Thomas MARGUENOT <salutation@agence-belle-epoque.fr>
 */
class Citeo_Options_Plugin {

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
	protected $plugin_slug = 'citeooptionsplugin';

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
		add_action( 'init', array( $this, 'option_custom_fields' ) );

		add_action( 'admin_head', array( $this, 'add_admin_styles' ) );

		add_filter( '@TODO', array( $this, 'filter_method_name' ) );


		if( function_exists('acf_add_options_page') ) {
			// @see: http://www.advancedcustomfields.com/resources/options-page/

			acf_add_options_page(array(
				'page_title' 	=> 'Options',
				'menu_title'	=> 'Options',
				'capability'	=> 'manage_options',
				'menu_slug'		=> 'options-citeo',
				'redirect'		=> true,
				'icon_url'		=> 'dashicons-welcome-widgets-menus'
				));
		}

		if( function_exists('acf_add_options_sub_page') )
		{
			acf_add_options_sub_page(array(
				'title' => 'Général',
				'parent' => 'options-citeo',
				'capability' => 'manage_options',
				'slug'		=> 'options-citeo-general',
				));
		}

		if( function_exists('acf_add_options_sub_page') )
		{
			acf_add_options_sub_page(array(
				'title' => 'Modules',
				'parent' => 'options-citeo',
				'capability' => 'manage_options',
				'slug'		=> 'options-citeo-modules',
				));
		}


		// Adding subpage
		// @see: http://www.advancedcustomfields.com/resources/acf_add_options_sub_page/
		// if( function_exists('acf_add_options_sub_page') )
		// {
		//     acf_add_options_sub_page(array(
		//         'title' => 'Footer',
		//         'parent' => 'citeo-options',
		//         'capability' => 'manage_options'
		//     ));
		// }



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
	* Register custom fields for option page
	*
	* @since    1.0.0
	*/
	public function option_custom_fields() {

		if(function_exists("register_field_group")) {

			register_field_group(array (
				'key' => 'group_54ef426474f1b',
				'title' => 'Options générales',
				'fields' => array (
					array (
						'key' => 'field_54ef4520f3498',
						'label' => 'Général',
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
						'key' => 'field_54ef456cf3499',
						'label' => 'Favicon',
						'name' => 'opt_general_favicon',
						'prefix' => '',
						'type' => 'image',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
							),
						'return_format' => 'url',
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
					array (
						'key' => 'field_54ef45ebf349a',
						'label' => 'Icône pour mobile',
						'name' => 'opt_general_icon_mobile',
						'prefix' => '',
						'type' => 'image',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
							),
						'return_format' => 'url',
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
					array (
						'key' => 'field_550195ef0072f',
						'label' => 'Mise en page',
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
						'key' => 'field_550167556cd2c',
						'label' => 'Mode Boxed',
						'name' => 'opt_general_boxed_mode',
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
						'default_value' => 0,
						),
					array (
						'key' => 'field_550165556fgd5t',
						'label' => 'Conteneur Fluide',
						'name' => 'opt_general_container_fluid',
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
						'default_value' => 0,
						),
					array (
						'key' => 'field_550197e400730',
						'label' => 'Image de fond',
						'name' => 'opt_general_background_image',
						'prefix' => '',
						'type' => 'image',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
							),
						'return_format' => 'array',
						'preview_size' => 'citeo-full',
						'library' => 'all',
						'min_width' => '',
						'min_height' => '',
						'min_size' => '',
						'max_width' => '',
						'max_height' => '',
						'max_size' => '',
						'mime_types' => '',
						),
					array (
						'key' => 'field_54ef47f9464e7',
						'label' => 'Header & Navigation',
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
						'key' => 'field_55016b6099fed',
						'label' => 'Position du menu',
						'name' => 'opt_general_menu_location',
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
							'top' => 'En haut',
							'content-top' => 'Au dessus du contenu',
							),
						'default_value' => array (
							'content-top' => 'content-top',
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
						'key' => 'field_54ef4894464ea',
						'label' => 'Logo',
						'name' => 'opt_general_logo',
						'prefix' => '',
						'type' => 'image',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
							),
						'return_format' => 'array',
						'preview_size' => 'citeo-logo',
						'library' => 'all',
						'min_width' => '',
						'min_height' => '',
						'min_size' => '',
						'max_width' => '',
						'max_height' => '',
						'max_size' => '',
						'mime_types' => '',
						),
					// array (
					// 	'key' => 'field_54ef48c0464eb',
					// 	'label' => 'Logo Retina (2x)',
					// 	'name' => 'opt_general_logo_retina',
					// 	'prefix' => '',
					// 	'type' => 'image',
					// 	'instructions' => '',
					// 	'required' => 0,
					// 	'conditional_logic' => 0,
					// 	'wrapper' => array (
					// 		'width' => '',
					// 		'class' => '',
					// 		'id' => '',
					// 		),
					// 	'return_format' => 'array',
					// 	'preview_size' => 'citeo-logo',
					// 	'library' => 'all',
					// 	'min_width' => '',
					// 	'min_height' => '',
					// 	'min_size' => '',
					// 	'max_width' => '',
					// 	'max_height' => '',
					// 	'max_size' => '',
					// 	'mime_types' => '',
					// 	),
					array (
						'key' => 'field_54ef48d9464ec',
						'label' => 'Emplacement du logo',
						'name' => 'opt_general_logo_location',
						'prefix' => '',
						'type' => 'select',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => array (
							array (
								array (
									'field' => 'field_54ef4862464e9',
									'operator' => '==',
									'value' => '1',
									),
								),
							),
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
							),
						'choices' => array (
							'bandeau-image' => 'Bandeau image',
							'menu' => 'Menu',
							),
						'default_value' => array (
							'bandeau-image' => 'bandeau-image',
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
						'key' => 'field_54ef480d464e8',
						'label' => 'Afficher la top bar',
						'name' => 'opt_general_display_top_bar',
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
						'key' => 'field_54ef4862464e9',
						'label' => 'Afficher le bandeau image',
						'name' => 'opt_general_display_header_banner',
						'prefix' => '',
						'type' => 'true_false',
						'instructions' => '',
						'required' => 0,
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
							),
						'message' => '',
						'default_value' => 1,
						),
					array (
						'key' => 'field_54ef4c505f679',
						'label' => 'Image du bandeau',
						'name' => 'opt_general_header_banner_image',
						'prefix' => '',
						'type' => 'image',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => array (
							array (
								array (
									'field' => 'field_54ef4862464e9',
									'operator' => '==',
									'value' => '1',
									),
								),
							),
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
							),
						'return_format' => 'array',
						'preview_size' => 'citeo-full',
						'library' => 'all',
						'min_width' => '',
						'min_height' => '',
						'min_size' => '',
						'max_width' => '',
						'max_height' => '',
						'max_size' => '',
						'mime_types' => '',
						),
					array (
						'key' => 'field_54f044fdf485c',
						'label' => 'Hauteur du bandeau',
						'name' => 'opt_general_header_banner_image_height',
						'prefix' => '',
						'type' => 'number',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => array (
							array (
								array (
									'field' => 'field_54ef4862464e9',
									'operator' => '==',
									'value' => '1',
									),
								),
							),
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
							),
						'default_value' => 200,
						'placeholder' => '',
						'prepend' => '',
						'append' => 'px',
						'min' => 100,
						'max' => 500,
						'step' => '',
						'readonly' => 0,
						'disabled' => 0,
						),
					array (
						'key' => 'field_54ef4d601e024',
						'label' => 'Pied de page',
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
						'key' => 'field_54ef4e481e027',
						'label' => 'Afficher le mega footer',
						'name' => 'opt_general_display_mega_footer',
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
						'key' => 'field_54ef4d6c1e025',
						'label' => 'Afficher le bandeau image',
						'name' => 'opt_general_display_footer_banner',
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
						'key' => 'field_54ef4e2a1e026',
						'label' => 'Image du bandeau',
						'name' => 'opt_general_footer_banner_image',
						'prefix' => '',
						'type' => 'image',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => array (
							array (
								array (
									'field' => 'field_54ef4d6c1e025',
									'operator' => '==',
									'value' => '1',
									),
								),
							),
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
							),
						'return_format' => 'array',
						'preview_size' => 'citeo-full',
						'library' => 'all',
						'min_width' => '',
						'min_height' => '',
						'min_size' => '',
						'max_width' => '',
						'max_height' => '',
						'max_size' => '',
						'mime_types' => '',
						),
					array (
						'key' => 'field_54f0457bf485d',
						'label' => 'Hauteur du bandeau',
						'name' => 'opt_general_footer_banner_image_height',
						'prefix' => '',
						'type' => 'number',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => array (
							array (
								array (
									'field' => 'field_54ef4d6c1e025',
									'operator' => '==',
									'value' => '1',
									),
								),
							),
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
							),
						'default_value' => 200,
						'placeholder' => '',
						'prepend' => '',
						'append' => 'px',
						'min' => 100,
						'max' => 500,
						'step' => '',
						'readonly' => 0,
						'disabled' => 0,
						),
					array (
						'key' => 'field_54ef4e73a76bb',
						'label' => 'Contenu',
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
						'key' => 'field_5501d07765519',
						'label' => 'Afficher le fil d\'ariane',
						'name' => 'opt_general_display_breadcrumb',
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
						'key' => 'field_54ef632268207',
						'label' => 'Activer la lecture automatique sur le carrousel',
						'name' => 'opt_general_automatic_carrousel',
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
						'key' => 'field_54ef637368208',
						'label' => 'Navigation afficher sur le carrousel',
						'name' => 'opt_general_displayed_nav',
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
							'puces-fleches' => 'Puces et flèches',
							'puces' => 'Puces',
							'fleches' => 'Flèches',
							),
						'default_value' => array (
							'puces-fleches' => 'Puces et flèches',
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
						'key' => 'field_54ef4e7fa76bc',
						'label' => 'Afficher les dates de publication',
						'name' => 'opt_general_display_publish_date',
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
						'key' => 'field_54ef4f04a76bd',
						'label' => 'Afficher les catégories',
						'name' => 'opt_general_display_categories',
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
						'key' => 'field_54ef4f1ca76be',
						'label' => 'Afficher les auteurs',
						'name' => 'opt_general_display_authors',
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
						'key' => 'field_5500a84930b2a',
						'label' => 'Afficher les boutons de partage sur les réseaux sociaux',
						'name' => 'opt_general_displayed_share_buttons',
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
						'key' => 'field_54ef4b58f4a7c',
						'label' => 'Coordonnées',
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
						'key' => 'field_54ef491c464ed',
						'label' => 'Numéro de téléphone',
						'name' => 'opt_general_phone_number',
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
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
						'readonly' => 0,
						'disabled' => 0,
						),
					array (
						'key' => 'field_54ef497c464ef',
						'label' => 'Adresse postale',
						'name' => 'opt_general_address',
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
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
						'readonly' => 0,
						'disabled' => 0,
						),
					array (
						'key' => 'field_54ef4965464ee',
						'label' => 'Adresse email de contact',
						'name' => 'opt_general_email',
						'prefix' => '',
						'type' => 'email',
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
						'prepend' => '',
						'append' => '',
						),
					array (
						'key' => 'field_54ef4a28c7818',
						'label' => 'Compte Twitter',
						'name' => 'opt_general_twitter',
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
						'prepend' => '@',
						'append' => '',
						'maxlength' => '',
						'readonly' => 0,
						'disabled' => 0,
						),
					array (
						'key' => 'field_54ef4a44c7819',
						'label' => 'Compte Facebook',
						'name' => 'opt_general_facebook',
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
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
						'readonly' => 0,
						'disabled' => 0,
						),
					array (
						'key' => 'field_54ef4a60c781a',
						'label' => 'Compte Google+',
						'name' => 'opt_general_google_plus',
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
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
						'readonly' => 0,
						'disabled' => 0,
						),
					array (
						'key' => 'field_54ef4b27221de',
						'label' => 'Outils',
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
						'key' => 'field_54ef4a7fc781b',
						'label' => 'Google Webmaster Tools',
						'name' => 'opt_general_google_webmaster_tools',
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
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
						'readonly' => 0,
						'disabled' => 0,
						),
					array (
						'key' => 'field_54ef4ac1c781c',
						'label' => 'Google Analytics',
						'name' => 'opt_general_google_analytics',
						'prefix' => '',
						'type' => 'textarea',
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
						'maxlength' => '',
						'rows' => '',
						'new_lines' => '',
						'readonly' => 0,
						'disabled' => 0,
						),
					),
				'location' => array (
					array (
						array (
							'param' => 'options_page',
							'operator' => '==',
							'value' => 'options-citeo-general',
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
	* Custom admin style
	*
	* @since    1.0.4
	*/
	public function add_admin_styles() {
	?>
	<style>

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
