<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/kokiddp/
 * @since             1.0.0
 * @package           Alb
 *
 * @wordpress-plugin
 * Plugin Name:       alBShowroom
 * Plugin URI:        https://github.com/kokiddp/alBShowroom
 * Description:       AlBirrificio Showroom awesomeness!
 * Version:           1.0.0
 * Author:            Gabriele Coquillard
 * Author URI:        https://github.com/kokiddp/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       alb
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently pligin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'ALBSHOWROOM_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-alb-activator.php
 */
function activate_alb() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-alb-activator.php';
	Alb_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-alb-deactivator.php
 */
function deactivate_alb() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-alb-deactivator.php';
	Alb_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_alb' );
register_deactivation_hook( __FILE__, 'deactivate_alb' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-alb.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_alb() {

	$plugin = new Alb();
	$plugin->run();

}
run_alb();
