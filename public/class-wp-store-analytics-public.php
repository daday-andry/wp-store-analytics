<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       andrynirina.portfoliobox.net
 * @since      1.0.0
 *
 * @package    Wp_Store_Analytics
 * @subpackage Wp_Store_Analytics/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wp_Store_Analytics
 * @subpackage Wp_Store_Analytics/public
 * @author     DADAY Andry <andrysahaedena@gmail.com>
 */
class Wp_Store_Analytics_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-store-analytics-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-store-analytics-public.js', array( 'jquery' ), $this->version, false );

	}
	public function addTrackerScript(){
		global $post;	
		$ipAddress = $this->GetIPAddress();
		$blockedIpAdresses = get_option('exclusion_ip_address_list');
		
		if( isset($blockedIpAdresses) && is_array( $blockedIpAdresses ) && isset( $blockedIpAdresses[$ipAddress] ) && $blockedIpAdresses[$ipAddress] ){
			return;
		}
		$postID = 0;
		if( is_single() || is_page() ){
				$postID = $post->ID;	
		}
		$urlReferrer=isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
		$output='';
		$output.='<!-- Wordpress Stats Manager -->
				<script type="text/javascript">
					var _wsm = _wsm || [];
						_wsm.push([\'trackPageView\']);
						_wsm.push([\'enableLinkTracking\']);
						_wsm.push([\'enableHeartBeatTimer\']);
					(function() {
						var u="'.WSA_URL.'";
						_wsm.push([\'setUrlReferrer\', "'.$urlReferrer.'"]);
						_wsm.push([\'setTrackerUrl\',"'.site_url('/?wmcAction=wmcTrack').'"]);
						_wsm.push([\'setSiteId\', "'. get_current_blog_id().'"]);
						_wsm.push([\'setPageId\', "'.$postID.'"]);
						_wsm.push([\'setWpUserId\', "'.get_current_user_id().'"]);           
						var d=document, g=d.createElement(\'script\'), s=d.getElementsByTagName(\'script\')[0];
						g.type=\'text/javascript\'; g.async=true; g.defer=true; g.src=u+\'admin/js/wsa_new.js\'; s.parentNode.insertBefore(g,s);
					})();
				</script>
				<!-- End Wordpress Stats Manager Code -->';
		 echo $output;
	}
	public function GetIPAddress(){
		if( array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER) && !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ) {
			if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',')>0) {
				$addr = explode(",",$_SERVER['HTTP_X_FORWARDED_FOR']);
				return trim($addr[0]);
			} else {
				return $_SERVER['HTTP_X_FORWARDED_FOR'];
			}
		}
		else {
			return $_SERVER['REMOTE_ADDR'];
		}
	  }
	  function add_tracer_request(){
		global $wsmRequestArray;       
        if(isset($wsmRequestArray['wmcAction']) && ($wsmRequestArray['wmcAction']=='wmcTrack' || $wsmRequestArray['wmcAction']=='wmcAutoCron') ){
            self::$objWsmRequest= new wsmRequests($wsmRequestArray);
        }
	}

}
