<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://aporia.info
 * @since             1.0.2
 * @package           Wc_Labels
 *
 * @wordpress-plugin
 * Plugin Name:       WC Labels
 * Plugin URI:        https://aporia.info/plugins/wc-labels
 * Description:       This plugin provides printable jewellery labels for all Woocommerce Products
 * Version:           1.0.2
 * Author:            Darcy Christ
 * Author URI:        https://aporia.info
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wc-labels
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
 * This action is documented in includes/class-wc-labels-activator.php
 */
function activate_wc_labels() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wc-labels-activator.php';
	Wc_Labels_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wc-labels-deactivator.php
 */
function deactivate_wc_labels() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wc-labels-deactivator.php';
	Wc_Labels_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wc_labels' );
register_deactivation_hook( __FILE__, 'deactivate_wc_labels' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wc-labels.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wc_labels() {

	$plugin = new Wc_Labels();
	$plugin->run();

}
run_wc_labels();
