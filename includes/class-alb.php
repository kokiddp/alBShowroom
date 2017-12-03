<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/kokiddp/
 * @since      1.0.0
 *
 * @package    Alb
 * @subpackage Alb/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Alb
 * @subpackage Alb/includes
 * @author     Gabriele Coquillard <gabriele.coquillard@gmail.com>
 */
class Alb {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Alb_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'ALBSHOWROOM_VERSION' ) ) {
			$this->version = ALBSHOWROOM_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'alb';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_common_hooks();
		$this->add_shortcodes();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Alb_Loader. Orchestrates the hooks of the plugin.
	 * - Alb_i18n. Defines internationalization functionality.
	 * - Alb_Admin. Defines all hooks for the admin area.
	 * - Alb_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-alb-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-alb-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-alb-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-alb-public.php';

		$this->loader = new Alb_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Alb_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Alb_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Alb_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Alb_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related both to the public-facing and to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_common_hooks() {

		$plugin_admin = new Alb_Admin( $this->get_plugin_name(), $this->get_version() );
		$plugin_public = new Alb_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'init', $this, 'register_bottled_beer_post_type', 0 );
		$this->loader->add_action( 'init', $this, 'register_tap_beer_post_type', 0 );
		$this->loader->add_action( 'init', $this, 'register_beer_taxonomy_category', 0 );
		$this->loader->add_action( 'init', $this, 'register_beer_taxonomy_tag', 0 );

	}

	/**
	 * Add shortcodes
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function add_shortcodes() {

		$plugin_admin = new Alb_Admin( $this->get_plugin_name(), $this->get_version() );
		$plugin_public = new Alb_Public( $this->get_plugin_name(), $this->get_version() );

		$plugin_public->add_shortcodes();
		$plugin_admin->add_shortcodes();

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Alb_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Register the Bottled Beer custom post type.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_post_type
	 */
	public function register_bottled_beer_post_type() {
		$labels = array(
			'name'               => __( 'Bottled Beers', 'alb' ),
			'singular_name'      => __( 'Bottled Beer', 'alb' ),
			'add_new'            => __( 'Add Bottled Beer', 'alb' ),
			'add_new_item'       => __( 'Add Bottled Beer', 'alb' ),
			'edit_item'          => __( 'Edit Bottled Beer', 'alb' ),
			'new_item'           => __( 'New Bottled Beer', 'alb' ),
			'view_item'          => __( 'View Bottled Beer', 'alb' ),
			'search_items'       => __( 'Search Bottled Beer', 'alb' ),
			'not_found'          => __( 'No Bottled Beer found', 'alb' ),
			'not_found_in_trash' => __( 'No Bottled Beer in the trash', 'alb' ),
		);

		$supports = array(
			'title',
			'editor',
			'thumbnail',
			'revisions',
			'tags',
			'excerpt'
		);

		$args = array(
			'labels'          => $labels,
			'supports'        => $supports,
			'public'          => true,
			'capability_type' => 'post',
			'rewrite'         => array( 'slug' => __( 'bottled_beer', 'alb' ) ), // Permalinks format
			'menu_position'   => 30,
			'menu_icon'       => 'dashicons-book',
		);

		//filter for altering the args
		$args = apply_filters( 'bottled_beer_post_type_args', $args );

		register_post_type( 'bottled_beer', $args );
	}

	/**
	 * Register the Tap Beer custom post type.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_post_type
	 */
	public function register_tap_beer_post_type() {
		$labels = array(
			'name'               => __( 'Tap Beers', 'alb' ),
			'singular_name'      => __( 'Tap Beer', 'alb' ),
			'add_new'            => __( 'Add Tap Beer', 'alb' ),
			'add_new_item'       => __( 'Add Tap Beer', 'alb' ),
			'edit_item'          => __( 'Edit Tap Beer', 'alb' ),
			'new_item'           => __( 'New Tap Beer', 'alb' ),
			'view_item'          => __( 'View Tap Beer', 'alb' ),
			'search_items'       => __( 'Search Tap Beer', 'alb' ),
			'not_found'          => __( 'No Tap Beer found', 'alb' ),
			'not_found_in_trash' => __( 'No Tap Beer in the trash', 'alb' ),
		);

		$supports = array(
			'title',
			'editor',
			'thumbnail',
			'revisions',
			'tags',
			'excerpt'
		);

		$args = array(
			'labels'          => $labels,
			'supports'        => $supports,
			'public'          => true,
			'capability_type' => 'post',
			'rewrite'         => array( 'slug' => __( 'tap_beer', 'alb' ) ), // Permalinks format
			'menu_position'   => 30,
			'menu_icon'       => 'dashicons-book',
		);

		//filter for altering the args
		$args = apply_filters( 'tap_beer_post_type_args', $args );

		register_post_type( 'tap_beer', $args );
	}

	/**
	 * Register a taxonomy for Beer Categories.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_taxonomy
	 */
	public function register_beer_taxonomy_category() {
		$labels = array(
			'name'                       => __( 'Beer Categories', 'alb' ),
			'singular_name'              => __( 'Beer Category', 'alb' ),
			'menu_name'                  => __( 'Beer Categories', 'alb' ),
			'edit_item'                  => __( 'Edit Beer Category', 'alb' ),
			'update_item'                => __( 'Update Beer Category', 'alb' ),
			'add_new_item'               => __( 'Add New Beer Category', 'alb' ),
			'new_item_name'              => __( 'New Beer Category Name', 'alb' ),
			'parent_item'                => __( 'Parent Beer Category', 'alb' ),
			'parent_item_colon'          => __( 'Parent Beer Category:', 'alb' ),
			'all_items'                  => __( 'All Beer Categories', 'alb' ),
			'search_items'               => __( 'Search Beer Categories', 'alb' ),
			'popular_items'              => __( 'Popular Beer Categories', 'alb' ),
			'separate_items_with_commas' => __( 'Separate Beer categories with commas', 'alb' ),
			'add_or_remove_items'        => __( 'Add or remove Beer categories', 'alb' ),
			'choose_from_most_used'      => __( 'Choose from the most used Beer categories', 'alb' ),
			'not_found'                  => __( 'No Beer categories found.', 'alb' ),
		);

		$args = array(
			'labels'            => $labels,
			'public'            => true,
			'show_in_nav_menus' => true,
			'show_ui'           => true,
			'show_tagcloud'     => true,
			'hierarchical'      => true,
			'rewrite'           => array( 'slug' => __('beer_category', 'alb') ),
			'show_admin_column' => true,
			'query_var'         => true,
		);

		//filter for altering the args
		$args = apply_filters( 'beer_category_taxonomy_args', $args );

		register_taxonomy( 'beer_category',  array( 'bottled_beer', 'tap_beer' ), $args );
	}

	/**
	 * Register a taxonomy for Beer Tags.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_taxonomy
	 */
	public function register_beer_taxonomy_tag() {
		$labels = array(
			'name'                       => __( 'Beer Tags', 'alb' ),
			'singular_name'              => __( 'Beer Tag', 'alb' ),
			'menu_name'                  => __( 'Beer Tags', 'alb' ),
			'edit_item'                  => __( 'Edit Beer Tag', 'alb' ),
			'update_item'                => __( 'Update Beer Tag', 'alb' ),
			'add_new_item'               => __( 'Add New Beer Tag', 'alb' ),
			'new_item_name'              => __( 'New Beer Tag Name', 'alb' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'all_items'                  => __( 'All Beer Tags', 'alb' ),
			'search_items'               => __( 'Search Beer Tag', 'alb' ),
			'popular_items'              => __( 'Popular Beer Tag', 'alb' ),
			'separate_items_with_commas' => __( 'Separate Beer Tags with commas', 'alb' ),
			'add_or_remove_items'        => __( 'Add or remove Beer Tags', 'alb' ),
			'choose_from_most_used'      => __( 'Choose from the most used Beer Tags', 'alb' ),
			'not_found'                  => __( 'No Beer Tag found.', 'alb' ),
		);

		$args = array(
			'labels'            => $labels,
			'public'            => true,
			'show_in_nav_menus' => true,
			'show_ui'           => true,
			'show_tagcloud'     => true,
			'hierarchical'      => false,
			'rewrite'           => array( 'slug' => __('beer_tag', 'alb') ),
			'show_admin_column' => true,
			'query_var'         => true,
		);

		//filter for altering the args
		$args = apply_filters( 'beer_tag_taxonomy_args', $args );

		register_taxonomy( 'beer_tag',  array( 'bottled_beer', 'tap_beer' ), $args );
	}

}
