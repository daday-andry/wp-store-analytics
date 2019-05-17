<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       andrynirina.portfoliobox.net
 * @since      1.0.0
 *
 * @package    Wp_Store_Analytics
 * @subpackage Wp_Store_Analytics/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Store_Analytics
 * @subpackage Wp_Store_Analytics/admin
 * @author     DADAY Andry <andrysahaedena@gmail.com>
 */
class Wp_Store_Analytics_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Store_Analytics_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Store_Analytics_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-store-analytics-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Store_Analytics_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Store_Analytics_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-store-analytics-admin.js', array( 'jquery' ), $this->version, false );

	}
	public function add_admin_menu_page(){
		$this->plugin_screen_hook_suffix = add_menu_page( "Store analytics", "Store analytics","manage_options","wp-store-analytics-menu",array($this,'dashboard_page'),'','2.2.9');
		$this->plugin_screen_hook_suffix = add_submenu_page('wp-store-analytics-menu', 'Dashboard','Dashboard', "manage_options", 'wp-store-analytics-dashboard-submenu', array($this,'dashboard_page'));
		$this->plugin_screen_hook_suffix = add_submenu_page('wp-store-analytics-menu', 'Analytics','Analytics', "manage_options", 'wp-store-analytics-analytics-submenu', array($this,'analytics_page'));
		$this->plugin_screen_hook_suffix = add_submenu_page('wp-store-analytics-menu', 'Configuration','Configuration', "manage_options", 'wp-store-analytics-config-submenu', array($this,'config_page'));
	}
	function dashboard_page(){
		include_once 'partials/wp-store-analytics-admin-dashboard.php';
	}
	function analytics_page(){
		include_once 'partials/wp-store-analytics-admin-dashboard.php';
	}
	function config_page(){
		include_once 'partials/wp-store-analytics-admin-dashboard.php';
	}
	
}
