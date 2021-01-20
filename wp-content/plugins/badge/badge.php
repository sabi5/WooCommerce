<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              cedcommerce
 * @since             1.0.0
 * @package           Badge
 *
 * @wordpress-plugin
 * Plugin Name:       Badge functionality in wooCommerce
 * Plugin URI:        cedcommerce
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Sabreen Shakeel
 * Author URI:        cedcommerce
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       badge
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
define( 'BADGE_VERSION', '1.0.0' );
define( 'CED_BADGE', plugin_dir_path(__FILE__) ); // define constant for plugin directory when override title template file


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-badge-activator.php
 */
function activate_badge() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-badge-activator.php';
	Badge_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-badge-deactivator.php
 */
function deactivate_badge() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-badge-deactivator.php';
	Badge_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_badge' );
register_deactivation_hook( __FILE__, 'deactivate_badge' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-badge.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_badge() {

	$plugin = new Badge();
	$plugin->run();

}
run_badge();
