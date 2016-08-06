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
 * @since             1.0.2
 * @package           Citeo_Ressources
 *
 * @wordpress-plugin
 * Plugin Name:       Citéo Ressources documentaires Plugin
 * Plugin URI:        
 * Description:       Plugin gérant les ressources documentaires
 * Version:           1.0.0
 * Author:            Inovagora
 * Author URI:        inovagora.net
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       citeo-ressources
 * Domain Path:       /languages
 */


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-citeo-ressources-activator.php
 */
function activate_citeo_ressources() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-citeo-ressources-activator.php';
	Citeo_Ressources_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-citeo-ressources-deactivator.php
 */
function deactivate_citeo_ressources() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-citeo-ressources-deactivator.php';
	Citeo_Ressources_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_citeo_ressources' );
register_deactivation_hook( __FILE__, 'deactivate_citeo_ressources' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-citeo-ressources.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_citeo_ressources() {

	$plugin = new Citeo_Ressources();
	$plugin->run();

}
run_citeo_ressources();
