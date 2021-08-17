<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://itech-softsolutions.com/
 * @since      1.0.0
 *
 * @package    Itqo
 * @subpackage Itqo/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Itqo
 * @subpackage Itqo/admin
 * @author     iTech Theme <rashedcse18@gmail.com>
 */
class Itqo_Admin {

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
		 * defined in Itqo_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Itqo_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/itqo-admin.css', array(), $this->version, 'all' );

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
		 * defined in Itqo_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Itqo_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/itqo-admin.js', array( 'jquery' ), $this->version, false );

	}

}

function itqo_scripts($hook) {
    if ('toplevel_page_quick-order-create' == $hook) {
        wp_enqueue_style('itqo-style', plugin_dir_url(__FILE__) . 'css/style.css', array(), '1.0.0');
        wp_enqueue_script('itqo-script', plugin_dir_url(__FILE__) . 'js/itqo.js', array('jquery', 'thickbox'), '1.0.0', true);
        $nonce = wp_create_nonce('itqo');
        wp_localize_script('itqo-script', 'itqo', array(
            'nonce' => $nonce,
            'ajax_url' => admin_url('admin-ajax.php'),
            'dc' => __('Discount Coupon', 'itqo'),
            'cc' => __('Coupon Code', 'itqo'),
            'dt' => __('Discount In Taka', 'itqo'),
            'pt' => __('iTech Quick Order', 'itqo'), //plugin title
        ));
        add_thickbox();
    }
}
add_action('admin_enqueue_scripts', 'itqo_scripts');