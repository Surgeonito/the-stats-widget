<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       blakol.pl
 * @since      1.0.0
 *
 * @package    The_Stats_Widget
 * @subpackage The_Stats_Widget/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    The_Stats_Widget
 * @subpackage The_Stats_Widget/admin
 * @author     MK <mikravv@gmail.com>
 */
class The_Stats_Widget_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 *
	 * @param      string $plugin_name The name of this plugin.
	 * @param      string $version     The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

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
		 * defined in The_Stats_Widget_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The The_Stats_Widget_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/the-stats-widget-admin.css', array(), $this->version, 'all' );

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
		 * defined in The_Stats_Widget_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The The_Stats_Widget_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/the-stats-widget-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function register_rest_routes() {
		register_rest_route( 'stats/v2', 'all_sites_stats', array(
			'methods'  => 'GET',
			'callback' => array( $this, 'get_all_sites_stats_callback' )
		) );
	}

	public function get_all_sites_stats_callback() {
		$out = array();

		if(is_multisite()){
			$sites = get_sites();
		}else{
			$tmp_site = new stdClass();
			$tmp_site->blog_id = get_current_blog_id();
			$sites = array($tmp_site);
		}

		if ( ! empty ( $sites ) ) {

			foreach( $sites as $site ) {
				$site_id = $site->blog_id;
				$details = new stdClass();

				if(is_multisite()){
					$details->is_multisite = 1;
					$details->site = get_blog_details( $site_id );
					switch_to_blog($site_id);
					$details->users_count = get_user_count();
				}else{
					$details->is_multisite = 0;
					$details->site = new stdClass();
					$details->site->blogname = get_bloginfo('name');
					$users_count = count_users();
					$details->users_count = $users_count['total_users'];
				}

				$details->posts_count = wp_count_posts('post');
				$details->pages_count = wp_count_posts('page');

				if(is_multisite()){
					restore_current_blog();
				}

				$out[] = $details;
			}

		}

		wp_send_json( $out );
	}

	public function register_widgets() {
		register_widget( 'Stats_widget' );
	}

}
