<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              andrynirina.portfoliobox.net
 * @since             1.0.0
 * @package           Wp_Store_Analytics
 *
 * @wordpress-plugin
 * Plugin Name:       WP Store analytics
 * Plugin URI:        https://github.com/daday-andry/wp-store-analytics
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            DADAY Andry
 * Author URI:        andrynirina.portfoliobox.net
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-store-analytics
 * Domain Path:       /languages
 */


 
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
include_once (plugin_dir_path( __FILE__ ) . 'includes/functions.php');
/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WP_STORE_ANALYTICS_VERSION', '1.0.0' );
define( 'WSM_ONLINE_SESSION',15 ); //DEFINE ONLINE SESSION TIME IN MINUTES
define( 'WSM_PREFIX','wsm');

define( 'WSA_URL', plugin_dir_url( __FILE__ ) );
define('WSA_TIMEZONE',wsmCurrentGetTimezoneOffset());

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-store-analytics-activator.php
 */
function activate_wp_store_analytics() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-store-analytics-activator.php';
	Wp_Store_Analytics_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-store-analytics-deactivator.php
 */
function deactivate_wp_store_analytics() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-store-analytics-deactivator.php';
	Wp_Store_Analytics_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_store_analytics' );
register_deactivation_hook( __FILE__, 'deactivate_wp_store_analytics' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-store-analytics.php';

global $wsmAdminPageHooks,$wsmRequestArray;
$wsmAdminPageHooks=array();
$wsmRequestArray=array();
if(isset($_REQUEST) && is_array($_REQUEST)){
    $wsmRequestArray=$_REQUEST;
}
/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_store_analytics() {

	$plugin = new Wp_Store_Analytics();
	$plugin->run();

}
run_wp_store_analytics();
