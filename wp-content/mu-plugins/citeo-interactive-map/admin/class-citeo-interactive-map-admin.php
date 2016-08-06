<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       inovagora.net
 * @since      1.0.0
 *
 * @package    Citeo_Interactive_Map
 * @subpackage Citeo_Interactive_Map/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Citeo_Interactive_Map
 * @subpackage Citeo_Interactive_Map/admin
 * @author     Christophe Béghin <cbeghin@inovagora.net>
 */
class Citeo_Interactive_Map_Admin {

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
	 * @param      string    $citeo_interactive_map       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $citeo_interactive_map, $version ) {

		$this->citeo_interactive_map = $citeo_interactive_map;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->citeo_interactive_map, plugin_dir_url( __FILE__ ) . 'css/citeo-interactive-map-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->citeo_interactive_map, plugin_dir_url( __FILE__ ) . 'js/citeo-interactive-map-admin.js', array( 'jquery' ), $this->version, false );

	}

}
