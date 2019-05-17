<?php

/**
 * Fired during plugin activation
 *
 * @link       andrynirina.portfoliobox.net
 * @since      1.0.0
 *
 * @package    Wp_Store_Analytics
 * @subpackage Wp_Store_Analytics/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wp_Store_Analytics
 * @subpackage Wp_Store_Analytics/includes
 * @author     DADAY Andry <andrysahaedena@gmail.com>
 */
class Wp_Store_Analytics_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		
		/** Teste if woocomerce is present **/
		if (class_exists( 'WooCommerce')) {
            global  $woocommerce ;
			if(!version_compare( $woocommerce->version,"2.7", ">=" ) ) {
				die('Woocomerce doit >= 2.7. Curent version:'.$woocommerce->version);
			}else{
				add_option('active_ecommerce_plugin_name','woocomerce');
				add_option('active_ecommerce_plugin_version',$woocommerce->version);
			}
		}
		/*** Test if WP-commerce is present */
		elseif(!is_plugin_active('wp-e-commerce/wp-shopping-cart.php')){
			die("ce plugin necessite woocommerce > 2.7 ou WP eCommerce");
		}else{
			add_option('active_ecommerce_plugin_name','wp-e-commerce');
		}	
	}

}
