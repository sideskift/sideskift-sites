<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://sideskift.dk
 * @since             1.0.0
 * @package           Sideskift_Sites
 *
 * @wordpress-plugin
 * Plugin Name:       SideSkift sites
 * Plugin URI:        https://sideskift.dk/plugins/sideskift-sites
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Henrik Gregersen
 * Author URI:        https://sideskift.dk
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       sideskift-sites
 * Domain Path:       /languages
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-sideskift-sites-activator.php
 */
function activate_sideskift_sites() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sideskift-sites-activator.php';
	Sideskift_Sites_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-sideskift-sites-deactivator.php
 */
function deactivate_sideskift_sites() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sideskift-sites-deactivator.php';
	Sideskift_Sites_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_sideskift_sites' );
register_deactivation_hook( __FILE__, 'deactivate_sideskift_sites' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-sideskift-sites.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_sideskift_sites() {

	$plugin = new Sideskift_Sites();
	$plugin->run();

}
run_sideskift_sites();
