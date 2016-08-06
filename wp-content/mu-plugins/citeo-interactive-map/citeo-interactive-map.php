<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              inovagora.net
 * @since             1.0.0
 * @package           Citeo_Interactive_Map
 *
 * @wordpress-plugin
 * Plugin Name:       Citéo Carte interactive
 * Plugin URI:        inovagora.net
 * Description:       Plugin pour créer une carte interactive
 * Version:           1.0.3
 * Author:            Inovagora
 * Author URI:        inovagora.net
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       citeo-interactive-map
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-citeo-interactive-map-activator.php
 */
function activate_citeo_interactive_map() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-citeo-interactive-map-activator.php';
	Citeo_Interactive_Map_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-citeo-interactive-map-deactivator.php
 */
function deactivate_citeo_interactive_map() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-citeo-interactive-map-deactivator.php';
	Citeo_Interactive_Map_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_citeo_interactive_map' );
register_deactivation_hook( __FILE__, 'deactivate_citeo_interactive_map' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-citeo-interactive-map.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_citeo_interactive_map() {

	$plugin = new Citeo_Interactive_Map();
	$plugin->run();

}
run_citeo_interactive_map();
