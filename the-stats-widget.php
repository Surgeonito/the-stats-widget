<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              blakol.pl
 * @since             1.0.0
 * @package           The_Stats_Widget
 *
 * @wordpress-plugin
 * Plugin Name:       The stats widget
 * Plugin URI:        blakol.pl
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            MK
 * Author URI:        blakol.pl
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       the-stats-widget
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
 * This action is documented in includes/class-the-stats-widget-activator.php
 */
function activate_the_stats_widget() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-the-stats-widget-activator.php';
	The_Stats_Widget_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-the-stats-widget-deactivator.php
 */
function deactivate_the_stats_widget() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-the-stats-widget-deactivator.php';
	The_Stats_Widget_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_the_stats_widget' );
register_deactivation_hook( __FILE__, 'deactivate_the_stats_widget' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-the-stats-widget.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_the_stats_widget() {

	$plugin = new The_Stats_Widget();
	$plugin->run();

}
run_the_stats_widget();
