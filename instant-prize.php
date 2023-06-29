<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://rightglobalgroup.com/
 * @since             4.1.0
 * @package           Instant_Prize
 *
 * @wordpress-plugin
 * Plugin Name:       Instant Prize Auto
 * Plugin URI:        https://rightglobalgroup.com/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           4.6.0
 * Author:            Right Global Group
 * Author URI:        https://rightglobalgroup.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       instant-prize
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 4.1.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'INSTANT_PRIZE_VERSION', '4.1.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-instant-prize-activator.php
 */
function activate_instant_prize() {
	global $wpdb;
	$table_name = $wpdb->prefix . 'instant_prize';
	$collate = $wpdb->get_charset_collate();
	$sql = "CREATE TABLE $table_name (
			id INT NOT NULL AUTO_INCREMENT,
			date DATETIME NOT NULL,
			prize_name VARCHAR(255) NOT NULL,
			ticket_number VARCHAR(255) NOT NULL,
			winner_name VARCHAR(255) NOT NULL,
			winner_id VARCHAR(255) NOT NULL,
			PRIMARY KEY (id)
    	) $collate";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	$delta = dbDelta( $sql );
	$table_name = $wpdb->prefix . 'prize_winners';
	$sql = "CREATE TABLE $table_name (
			id INT NOT NULL AUTO_INCREMENT,
			date DATETIME NOT NULL,
			prize_name VARCHAR(255) NOT NULL,
			ticket_number VARCHAR(255) NOT NULL,
			winner_name VARCHAR(255) NOT NULL,
			winner_id VARCHAR(255) NOT NULL,
			PRIMARY KEY (id)
    	) $collate";
	dbDelta( $sql );
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-instant-prize-activator.php';
	Instant_Prize_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-instant-prize-deactivator.php
 */
function deactivate_instant_prize() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-instant-prize-deactivator.php';
	Instant_Prize_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_instant_prize' );
register_deactivation_hook( __FILE__, 'deactivate_instant_prize' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-instant-prize.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    4.1.0
 */
function run_instant_prize() {

	$plugin = new Instant_Prize();
	$plugin->run();

}
run_instant_prize();
