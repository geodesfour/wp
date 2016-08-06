<?php
/**
 * Citeo Publication Plugin
 *
 * Plugin gérant le type de contenu publication
 *
 * @package   Trombinoscope_Plugin
 * @author    Inovagora <contact@inovagora.net>
 * @license   GPL-2.0+
 * @link      http://wordpress.org/plugins
 * @copyright 2014 Inovagora
 *
 * @wordpress-plugin
 * Plugin Name:       Citeo Publication Plugin
 * Description:       Plugin gérant les publications
 * Version:           1.0.2
 * Author:            Inovagora
 * Author URI:        inovagora.net
 * Text Domain:       citeopublicationplugin
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 * GitHub Plugin URI: 
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

require_once( plugin_dir_path( __FILE__ ) . 'public/class-citeopublicationplugin.php' );

/*
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 */
register_activation_hook( __FILE__, array( 'Citeo_Publication_Plugin', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Citeo_Publication_Plugin', 'deactivate' ) );

add_action( 'plugins_loaded', array( 'Citeo_Publication_Plugin', 'get_instance' ) );

/*----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 *----------------------------------------------------------------------------*/

/*
 * @TODO:
 *
 * If you want to include Ajax within the dashboard, change the following
 * conditional to:
 *
 * if ( is_admin() ) {
 *   ...
 * }
 *
 * The code below is intended to to give the lightest footprint possible.
 */
if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {

	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-citeopublicationplugin-admin.php' );
	add_action( 'plugins_loaded', array( 'Citeo_Publication_Plugin_Admin', 'get_instance' ) );

}
