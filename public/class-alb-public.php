<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/kokiddp/
 * @since      1.0.0
 *
 * @package    Alb
 * @subpackage Alb/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Alb
 * @subpackage Alb/public
 * @author     Gabriele Coquillard <gabriele.coquillard@gmail.com>
 */
class Alb_Public {

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
		 * defined in Alb_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Alb_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/alb-public.css', array(), $this->version, 'all' );

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
		 * defined in Alb_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Alb_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/alb-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Add the shortcodes for the public area.
	 *
	 * @since    1.0.0
	 */
	public function add_shortcodes() {


	}

	/**
	 * Register the Bottled Beer Template.
	 *
	 * @since    1.0.0
	 */
	public function bottled_beer_templates( $template ) {
	    $post_types = array( 'bottled_beer' );

	    if ( is_singular( $post_types ) )
	        $template = plugin_dir_path( __FILE__ ) . 'partials/alb-public-single-bottled_beer-display.php';

	    return $template;
	}

	/**
	 * Register the Tap Beer Template.
	 *
	 * @since    1.0.0
	 */
	public function tap_beer_templates( $template ) {
	    $post_types = array( 'tap_beer' );

	    if ( is_singular( $post_types ) )
	        $template = plugin_dir_path( __FILE__ ) . 'partials/alb-public-single-tap_beer-display.php';

	    return $template;
	}

	/**
	 * Register the Sandwich Template.
	 *
	 * @since    1.0.0
	 */
	public function sandwich_templates( $template ) {
	    $post_types = array( 'sandwich' );

	    if ( is_singular( $post_types ) )
	        $template = plugin_dir_path( __FILE__ ) . 'partials/alb-public-single-sandwich-display.php';

	    return $template;
	}

}
