<?php

/**
 * Fired during plugin deactivation
 *
 * @link       andrynirina.portfoliobox.net
 * @since      1.0.0
 *
 * @package    Wp_Store_Analytics
 * @subpackage Wp_Store_Analytics/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Wp_Store_Analytics
 * @subpackage Wp_Store_Analytics/includes
 * @author     DADAY Andry <andrysahaedena@gmail.com>
 */
class Wp_Store_Analytics_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		delete_option("active_ecommerce_plugin_name");
		delete_option("active_ecommerce_plugin_version");
	}

}
