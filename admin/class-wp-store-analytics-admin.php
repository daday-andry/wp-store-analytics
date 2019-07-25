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
require_once('class/wsm_db.php' );

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
	
	private $objDatabase;
	
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->objDatabase=new wsmDatabase();

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

		wp_enqueue_style( "boot_strap_css", plugin_dir_url( __FILE__ ).'css/bootstrap.min.css',false, '1.0.0');
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-store-analytics-admin.css');
		
		//wp_enqueue_style("leaflet_css","http://cdn.leafletjs.com/leaflet/v0.7.7/leaflet.css");
		wp_enqueue_style("leaflet_css","https://unpkg.com/leaflet@1.0.3/dist/leaflet.css");

		//marker cluster style
		wp_enqueue_style("leaflet_marker_cluster_css","https://cdnjs.loli.net/ajax/libs/leaflet.markercluster/1.0.5/MarkerCluster.css");
		wp_enqueue_style("leaflet_marker_cluster_df_css","https://cdnjs.loli.net/ajax/libs/leaflet.markercluster/1.0.5/MarkerCluster.Default.css");
		wp_enqueue_style("font_awesome","https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css");
		wp_enqueue_style( "boot_strap_css", plugin_dir_url( __FILE__ ).'css/jquery.jqplot.css',false, '1.0.0');
		
		
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

		//wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-store-analytics-admin.js', array( 'jquery' ), $this->version, false );
		//wp_enqueue_script( $this->plugin_name,'http://cdn.leafletjs.com/leaflet/v0.7.7/leaflet.js');
		wp_enqueue_script( $this->plugin_name,'https://unpkg.com/leaflet@1.0.3/dist/leaflet.js');
		wp_register_script("trafic_map_controller", plugin_dir_url( __FILE__ ) . 'js/wp-store-trafic-map.js');
	//	wp_enqueue_script("trafic_map_controller");
		
		wp_enqueue_script('markercluster_js','https://cdnjs.loli.net/ajax/libs/leaflet.markercluster/1.0.5/leaflet.markercluster.js',array(),'1.0.0',true );
		wp_enqueue_script('jqplot-main',plugin_dir_url( __FILE__ ).'js/jqplot/jquery.jqplot.js',array(),'1.0.0',true );
		wp_enqueue_script('jqplot-pie-render',plugin_dir_url( __FILE__ ).'js/jqplot/jqplot.pieRenderer.js',array(),'1.0.0',true );
		wp_enqueue_script('jqplot-donut-render',plugin_dir_url( __FILE__ ).'js/jqplot/jqplot.donutRenderer.js',array(),'1.0.0',true );
		wp_enqueue_script('jqplot-bar-render',plugin_dir_url( __FILE__ ).'js/jqplot/jqplot.barRenderer.js',array(),'1.0.0',true );
		wp_enqueue_script('jqplot-meter-gauge-render',plugin_dir_url( __FILE__ ).'js/jqplot/jqplot.meterGaugeRenderer.js',array(),'1.0.0',true );
		wp_enqueue_script('jqplot-axis-render',plugin_dir_url( __FILE__ ).'js/jqplot/jqplot.categoryAxisRenderer.js',array(),'1.0.0',true );
		

		
	}
	public function add_admin_menu_page(){
		$this->plugin_screen_hook_suffix = add_menu_page( "Store analytics", "Store analytics","manage_options","wp-store-analytics-menu",array($this,'dashboard_page'),'','2.2.9');
		$this->plugin_screen_hook_suffix = add_submenu_page('wp-store-analytics-menu', 'Dashboard','Dashboard', "manage_options", 'wp-dashboard-analytics', array($this,'dashboard_page'));
		$this->plugin_screen_hook_suffix = add_submenu_page('wp-store-analytics-menu', 'Store_analytics','Store analytics', "manage_options", 'wp-store-analytics', array($this,'store_analytics_page'));
		$this->plugin_screen_hook_suffix = add_submenu_page('wp-store-analytics-menu', 'Trafic_analytics','Trafic analytics', "manage_options", 'wp-trafic-analytics', array($this,'trafic_analytics_page'));
		$this->plugin_screen_hook_suffix = add_submenu_page('wp-store-analytics-menu', 'Configuration','Configuration', "manage_options", 'wp-store-analytics-config', array($this,'config_page'));
	
	}
	function dashboard_page(){
		include_once 'partials/wp-dashbord-analytics-admin-display.php';
	}
	function store_analytics_page(){
		include_once 'partials/wp-store-analytics-admin-display.php';
	}
	function trafic_analytics_page(){
		$totalPageViews=$this->objDatabase->fnGetTotalPageViewCount();
		$totalPageViews=number_format_i18n($totalPageViews,0);

		$totalVisitors=$this->objDatabase->fnGetTotalVisitorsCount();
        $onlineVisitors=$this->objDatabase->fnGetTotalVisitorsCount('Online');
		
		$totalPageViews=number_format_i18n($totalPageViews,0);
		$totalVisitors=number_format_i18n($totalVisitors,0);
		
		include_once 'partials/wp-trafic-analytics-admin-display.php';
	}
	function config_page(){
		include_once 'partials/wp-config-analytics-admin-display.php';
	}	
}
