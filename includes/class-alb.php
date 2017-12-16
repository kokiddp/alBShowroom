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

		$this->loader->add_action( 'admin_menu', $plugin_admin, 'alb_add_admin_menu' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'alb_settings_init' );

		$this->loader->add_action( 'add_meta_boxes', $this, 'add_beer_meta_boxes' );
		$this->loader->add_action( 'save_post', $this, 'save_beer_meta_boxes', 10, 2 );

		$this->loader->add_action( 'add_meta_boxes', $this, 'add_sandwich_meta_boxes' );
		$this->loader->add_action( 'save_post', $this, 'save_sandwich_meta_boxes', 10, 2 );

		$this->loader->add_action( 'add_meta_boxes', $this, 'add_event_meta_boxes' );
		$this->loader->add_action( 'save_post', $this, 'save_event_meta_boxes', 10, 2 );	

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

		$this->loader->add_filter( 'template_include', $plugin_public, 'bottled_beer_templates' );
		$this->loader->add_filter( 'template_include', $plugin_public, 'tap_beer_templates' );
		$this->loader->add_filter( 'template_include', $plugin_public, 'sandwich_templates' );

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

		$this->loader->add_action( 'init', $this, 'register_sandwich_post_type', 0 );
		$this->loader->add_action( 'init', $this, 'register_sandwich_taxonomy_category', 0 );
		$this->loader->add_action( 'init', $this, 'register_sandwich_taxonomy_tag', 0 );

		$this->loader->add_action( 'init', $this, 'register_event_post_type', 0 );
		$this->loader->add_action( 'init', $this, 'register_event_taxonomy_category', 0 );
		$this->loader->add_action( 'init', $this, 'register_event_taxonomy_tag', 0 );

		$this->loader->add_action( 'wp', $plugin_public, 'taplist_page' );
		$this->loader->add_action( 'wp', $plugin_public, 'bottlelist_page' );
		$this->loader->add_action( 'wp', $plugin_public, 'events_page' );

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
			'menu_icon'       => plugin_dir_url( __FILE__ ) . 'img/bottled_beer.png'
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
			'menu_icon'       => plugin_dir_url( __FILE__ ) . 'img/tap_beer.png'
		);

		//filter for altering the args
		$args = apply_filters( 'tap_beer_post_type_args', $args );

		register_post_type( 'tap_beer', $args );
	}

	/**
	 * Register the Sandwich custom post type.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_post_type
	 */
	public function register_sandwich_post_type() {
		$labels = array(
			'name'               => __( 'Sandwiches', 'alb' ),
			'singular_name'      => __( 'Sandwich', 'alb' ),
			'add_new'            => __( 'Add Sandwich', 'alb' ),
			'add_new_item'       => __( 'Add Sandwich', 'alb' ),
			'edit_item'          => __( 'Edit Sandwich', 'alb' ),
			'new_item'           => __( 'New Sandwich', 'alb' ),
			'view_item'          => __( 'View Sandwich', 'alb' ),
			'search_items'       => __( 'Search Sandwich', 'alb' ),
			'not_found'          => __( 'No Sandwich found', 'alb' ),
			'not_found_in_trash' => __( 'No Sandwich in the trash', 'alb' ),
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
			'rewrite'         => array( 'slug' => __( 'sandwich', 'alb' ) ), // Permalinks format
			'menu_position'   => 30,
			'menu_icon'       => plugin_dir_url( __FILE__ ) . 'img/sandwich.png'
		);

		//filter for altering the args
		$args = apply_filters( 'sandwich_post_type_args', $args );

		register_post_type( 'sandwich', $args );
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

	/**
	 * Register a taxonomy for Sandwich Categories.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_taxonomy
	 */
	public function register_sandwich_taxonomy_category() {
		$labels = array(
			'name'                       => __( 'Sandwich Categories', 'alb' ),
			'singular_name'              => __( 'Sandwich Category', 'alb' ),
			'menu_name'                  => __( 'Sandwich Categories', 'alb' ),
			'edit_item'                  => __( 'Edit Sandwich Category', 'alb' ),
			'update_item'                => __( 'Update Sandwich Category', 'alb' ),
			'add_new_item'               => __( 'Add New Sandwich Category', 'alb' ),
			'new_item_name'              => __( 'New Sandwich Category Name', 'alb' ),
			'parent_item'                => __( 'Parent Sandwich Category', 'alb' ),
			'parent_item_colon'          => __( 'Parent Sandwich Category:', 'alb' ),
			'all_items'                  => __( 'All Sandwich Categories', 'alb' ),
			'search_items'               => __( 'Search Sandwich Categories', 'alb' ),
			'popular_items'              => __( 'Popular Sandwich Categories', 'alb' ),
			'separate_items_with_commas' => __( 'Separate Sandwich categories with commas', 'alb' ),
			'add_or_remove_items'        => __( 'Add or remove Sandwich categories', 'alb' ),
			'choose_from_most_used'      => __( 'Choose from the most used Sandwich categories', 'alb' ),
			'not_found'                  => __( 'No Sandwich categories found.', 'alb' ),
		);

		$args = array(
			'labels'            => $labels,
			'public'            => true,
			'show_in_nav_menus' => true,
			'show_ui'           => true,
			'show_tagcloud'     => true,
			'hierarchical'      => true,
			'rewrite'           => array( 'slug' => __('sandwich_category', 'alb') ),
			'show_admin_column' => true,
			'query_var'         => true,
		);

		//filter for altering the args
		$args = apply_filters( 'sandwich_category_taxonomy_args', $args );

		register_taxonomy( 'sandwich_category',  array( 'sandwich' ), $args );
	}

	/**
	 * Register a taxonomy for Sandwich Tags.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_taxonomy
	 */
	public function register_sandwich_taxonomy_tag() {
		$labels = array(
			'name'                       => __( 'Sandwich Tags', 'alb' ),
			'singular_name'              => __( 'Sandwich Tag', 'alb' ),
			'menu_name'                  => __( 'Sandwich Tags', 'alb' ),
			'edit_item'                  => __( 'Edit Sandwich Tag', 'alb' ),
			'update_item'                => __( 'Update Sandwich Tag', 'alb' ),
			'add_new_item'               => __( 'Add New Sandwich Tag', 'alb' ),
			'new_item_name'              => __( 'New Sandwich Tag Name', 'alb' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'all_items'                  => __( 'All Sandwich Tags', 'alb' ),
			'search_items'               => __( 'Search Sandwich Tag', 'alb' ),
			'popular_items'              => __( 'Popular Sandwich Tag', 'alb' ),
			'separate_items_with_commas' => __( 'Separate Sandwich Tags with commas', 'alb' ),
			'add_or_remove_items'        => __( 'Add or remove Sandwich Tags', 'alb' ),
			'choose_from_most_used'      => __( 'Choose from the most used Sandwich Tags', 'alb' ),
			'not_found'                  => __( 'No Sandwich Tag found.', 'alb' ),
		);

		$args = array(
			'labels'            => $labels,
			'public'            => true,
			'show_in_nav_menus' => true,
			'show_ui'           => true,
			'show_tagcloud'     => true,
			'hierarchical'      => false,
			'rewrite'           => array( 'slug' => __('sandwich', 'alb') ),
			'show_admin_column' => true,
			'query_var'         => true,
		);

		//filter for altering the args
		$args = apply_filters( 'sandwich_tag_taxonomy_args', $args );

		register_taxonomy( 'sandwich_tag',  array( 'sandwich' ), $args );
	}

	/**
	 * Register the Event custom post type.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_post_type
	 */
	public function register_event_post_type() {
		$labels = array(
			'name'               => __( 'Events', 'alb' ),
			'singular_name'      => __( 'Event', 'alb' ),
			'add_new'            => __( 'Add Event', 'alb' ),
			'add_new_item'       => __( 'Add Event', 'alb' ),
			'edit_item'          => __( 'Edit Event', 'alb' ),
			'new_item'           => __( 'New Event', 'alb' ),
			'view_item'          => __( 'View Event', 'alb' ),
			'search_items'       => __( 'Search Event', 'alb' ),
			'not_found'          => __( 'No Event found', 'alb' ),
			'not_found_in_trash' => __( 'No Event in the trash', 'alb' ),
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
			'rewrite'         => array( 'slug' => __( 'event', 'alb' ) ), // Permalinks format
			'menu_position'   => 30,
			'menu_icon'       => 'dashicons-calendar-alt'
		);

		//filter for altering the args
		$args = apply_filters( 'event_post_type_args', $args );

		register_post_type( 'event', $args );
	}

	/**
	 * Register a taxonomy for Event Categories.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_taxonomy
	 */
	public function register_event_taxonomy_category() {
		$labels = array(
			'name'                       => __( 'Event Categories', 'alb' ),
			'singular_name'              => __( 'Event Category', 'alb' ),
			'menu_name'                  => __( 'Event Categories', 'alb' ),
			'edit_item'                  => __( 'Edit Event Category', 'alb' ),
			'update_item'                => __( 'Update Event Category', 'alb' ),
			'add_new_item'               => __( 'Add New Event Category', 'alb' ),
			'new_item_name'              => __( 'New Event Category Name', 'alb' ),
			'parent_item'                => __( 'Parent Event Category', 'alb' ),
			'parent_item_colon'          => __( 'Parent Event Category:', 'alb' ),
			'all_items'                  => __( 'All Event Categories', 'alb' ),
			'search_items'               => __( 'Search Event Categories', 'alb' ),
			'popular_items'              => __( 'Popular Event Categories', 'alb' ),
			'separate_items_with_commas' => __( 'Separate Event categories with commas', 'alb' ),
			'add_or_remove_items'        => __( 'Add or remove Event categories', 'alb' ),
			'choose_from_most_used'      => __( 'Choose from the most used Event categories', 'alb' ),
			'not_found'                  => __( 'No Event categories found.', 'alb' ),
		);

		$args = array(
			'labels'            => $labels,
			'public'            => true,
			'show_in_nav_menus' => true,
			'show_ui'           => true,
			'show_tagcloud'     => true,
			'hierarchical'      => true,
			'rewrite'           => array( 'slug' => __('event_category', 'alb') ),
			'show_admin_column' => true,
			'query_var'         => true,
		);

		//filter for altering the args
		$args = apply_filters( 'event_category_taxonomy_args', $args );

		register_taxonomy( 'event_category',  array( 'event' ), $args );
	}

	/**
	 * Register a taxonomy for Event Tags.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_taxonomy
	 */
	public function register_event_taxonomy_tag() {
		$labels = array(
			'name'                       => __( 'Event Tags', 'alb' ),
			'singular_name'              => __( 'Event Tag', 'alb' ),
			'menu_name'                  => __( 'Event Tags', 'alb' ),
			'edit_item'                  => __( 'Edit Event Tag', 'alb' ),
			'update_item'                => __( 'Update Event Tag', 'alb' ),
			'add_new_item'               => __( 'Add New Event Tag', 'alb' ),
			'new_item_name'              => __( 'New Event Tag Name', 'alb' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'all_items'                  => __( 'All Event Tags', 'alb' ),
			'search_items'               => __( 'Search Event Tag', 'alb' ),
			'popular_items'              => __( 'Popular Event Tag', 'alb' ),
			'separate_items_with_commas' => __( 'Separate Event Tags with commas', 'alb' ),
			'add_or_remove_items'        => __( 'Add or remove Event Tags', 'alb' ),
			'choose_from_most_used'      => __( 'Choose from the most used Event Tags', 'alb' ),
			'not_found'                  => __( 'No Event Tag found.', 'alb' ),
		);

		$args = array(
			'labels'            => $labels,
			'public'            => true,
			'show_in_nav_menus' => true,
			'show_ui'           => true,
			'show_tagcloud'     => true,
			'hierarchical'      => false,
			'rewrite'           => array( 'slug' => __('event', 'alb') ),
			'show_admin_column' => true,
			'query_var'         => true,
		);

		//filter for altering the args
		$args = apply_filters( 'event_tag_taxonomy_args', $args );

		register_taxonomy( 'event_tag',  array( 'event' ), $args );
	}

	/**
	 * Register the time metaboxes to be used for the beer post type
	 *
	 */
	public function add_beer_meta_boxes() {
		add_meta_box(
			'beer_profile_fields',
			__( 'Beer Profile', 'alb' ),
			array( $this, 'render_beer_meta_boxes' ),
			array( 'bottled_beer', 'tap_beer' ),
			'normal',
			'high'
		);
	}

   /**
	* The HTML for the beer profile fields
	*/
	function render_beer_meta_boxes( $post ) {

		$meta = get_post_custom( $post->ID );
		$beer_brew_name = ! isset( $meta['beer_brew_name'][0] ) ? '' : $meta['beer_brew_name'][0];
		$beer_brew_add = ! isset( $meta['beer_brew_add'][0] ) ? '' : $meta['beer_brew_add'][0];
		$beer_abv = ! isset( $meta['beer_abv'][0] ) ? '' : $meta['beer_abv'][0];
		$beer_ibu = ! isset( $meta['beer_ibu'][0] ) ? '' : $meta['beer_ibu'][0];
		$beer_og = ! isset( $meta['beer_og'][0] ) ? '' : $meta['beer_og'][0];
		$beer_fg = ! isset( $meta['beer_fg'][0] ) ? '' : $meta['beer_fg'][0];
		$beer_color = ! isset( $meta['beer_color'][0] ) ? '' : $meta['beer_color'][0];
		$beer_grains = ! isset( $meta['beer_grains'][0] ) ? '' : $meta['beer_grains'][0];
		$beer_yeast = ! isset( $meta['beer_yeast'][0] ) ? '' : $meta['beer_yeast'][0];
		$beer_hops = ! isset( $meta['beer_hops'][0] ) ? '' : $meta['beer_hops'][0];
		$beer_plato = ! isset( $meta['beer_plato'][0] ) ? '' : $meta['beer_plato'][0];
		$beer_servt = ! isset( $meta['beer_servt'][0] ) ? '' : $meta['beer_servt'][0];
		$beer_pair = ! isset( $meta['beer_pair'][0] ) ? '' : $meta['beer_pair'][0];
		$beer_sizes = ! isset( $meta['beer_sizes'][0] ) ? '' : $meta['beer_sizes'][0];
		$beer_prices = ! isset( $meta['beer_prices'][0] ) ? '' : $meta['beer_prices'][0];
		$beer_sizem = ! isset( $meta['beer_sizem'][0] ) ? '' : $meta['beer_sizem'][0];
		$beer_pricem = ! isset( $meta['beer_pricem'][0] ) ? '' : $meta['beer_pricem'][0];

		wp_nonce_field( basename( __FILE__ ), 'beer_profile_fields' ); ?>

		<table class="form-table">

			<tr>
				<td class="beer_sc" colspan="1">
					<label for="beer_sc" style="font-weight: bold;"><?php _e( 'Beer Shortcode', 'alb' ); ?>
					</label>
				</td>
				<td colspan="4">
					<code class="beer_sc">[<?php echo get_post_type( $post->ID ); ?> id="<?php echo $post->ID; ?>"]</code>
				</td>
			</tr>

			<tr>
				<td class="beer_meta_box_td" colspan="1">
					<label for="beer_brew_name" style="font-weight: bold;"><?php _e( 'Brewery', 'alb' ); ?>
					</label>
				</td>
				<td colspan="4">
					<input type="text" name="beer_brew_name" class="regular-text" value="<?php echo $beer_brew_name; ?>">
					<p class="description"><?php _e( 'Example: Birrificio Aosta', 'alb' ); ?></p>
				</td>
			</tr>

			<tr>
				<td class="beer_meta_box_td" colspan="1">
					<label for="beer_brew_add" style="font-weight: bold;"><?php _e( 'Brewery town and state', 'alb' ); ?>
					</label>
				</td>
				<td colspan="4">
					<input type="text" name="beer_brew_add" class="regular-text" value="<?php echo $beer_brew_add; ?>">
					<p class="description"><?php _e( 'Example: Aosta (AO), ITA', 'alb' ); ?></p>
				</td>
			</tr>

			<tr>
				<td class="beer_meta_box_td" colspan="1">
					<label for="beer_abv" style="font-weight: bold;"><?php _e( 'Alcohol by volume (ABV)', 'alb' ); ?>
					</label>
				</td>
				<td colspan="4">
					<input type="text" name="beer_abv" class="regular-text" value="<?php echo $beer_abv; ?>">
					<p class="description"><?php _e( 'Example: 4.5%', 'alb' ); ?></p>
				</td>
			</tr>

			<tr>
				<td class="beer_meta_box_td" colspan="1">
					<label for="beer_ibu" style="font-weight: bold;"><?php _e( 'International Bitterness Units (IBU)', 'alb' ); ?>
					</label>
				</td>
				<td colspan="4">
					<input type="text" name="beer_ibu" class="regular-text" value="<?php echo $beer_ibu; ?>">
					<p class="description"><?php _e( 'Example: 40', 'alb' ); ?></p>
				</td>
			</tr>

			<tr>
				<td class="beer_meta_box_td" colspan="1">
					<label for="beer_og" style="font-weight: bold;"><?php _e( 'Original Gravity (OG)', 'alb' ); ?>
					</label>
				</td>
				<td colspan="4">
					<input type="text" name="beer_og" class="regular-text" value="<?php echo $beer_og; ?>">
					<p class="description"><?php _e( 'Example: 1.046', 'alb' ); ?></p>
				</td>
			</tr>

			<tr>
				<td class="beer_meta_box_td" colspan="1">
					<label for="beer_fg" style="font-weight: bold;"><?php _e( 'Final Gravity (FG)', 'alb' ); ?>
					</label>
				</td>
				<td colspan="4">
					<input type="text" name="beer_fg" class="regular-text" value="<?php echo $beer_fg; ?>">
					<p class="description"><?php _e( 'Example: 1.020', 'alb' ); ?></p>
				</td>
			</tr>

			<tr>
				<td class="beer_meta_box_td" colspan="1">
					<label for="beer_color" style="font-weight: bold;"><?php _e( 'Color/SRM', 'alb' ); ?>
					</label>
				</td>
				<td colspan="4">
					<input type="text" name="beer_color" class="regular-text" value="<?php echo $beer_color; ?>">
					<p class="description"><?php _e( 'Example: 24 or Black', 'alb' ); ?></p>
				</td>
			</tr>

			<tr>
				<td class="beer_meta_box_td" colspan="1">
					<label for="beer_grains" style="font-weight: bold;"><?php _e( 'Grains', 'alb' ); ?>
					</label>
				</td>
				<td colspan="4">
					<input type="text" name="beer_grains" class="regular-text" value="<?php echo $beer_grains; ?>">
					<p class="description"><?php _e( 'Example: Pale, Caramel, Roasted Barley, Oat Flake', 'alb' ); ?></p>
				</td>
			</tr>

			<tr>
				<td class="beer_meta_box_td" colspan="1">
					<label for="beer_yeast" style="font-weight: bold;"><?php _e( 'Yeast', 'alb' ); ?>
					</label>
				</td>
				<td colspan="4">
					<input type="text" name="beer_yeast" class="regular-text" value="<?php echo $beer_yeast; ?>">
					<p class="description"><?php _e( 'Example: American Ale', 'alb' ); ?></p>
				</td>
			</tr>

			<tr>
				<td class="beer_meta_box_td" colspan="1">
					<label for="beer_hops" style="font-weight: bold;"><?php _e( 'Hops', 'alb' ); ?>
					</label>
				</td>
				<td colspan="4">
					<input type="text" name="beer_hops" class="regular-text" value="<?php echo $beer_hops; ?>">
					<p class="description"><?php _e( 'Example: East Kent Goldings, Northdown', 'alb' ); ?></p>
				</td>
			</tr>

			<tr>
				<td class="beer_meta_box_td" colspan="1">
					<label for="beer_plato" style="font-weight: bold;"><?php _e( 'Plato Degrees', 'alb' ); ?>
					</label>
				</td>
				<td colspan="4">
					<input type="text" name="beer_plato" class="regular-text" value="<?php echo $beer_plato; ?>">
					<p class="description"><?php _e( 'Example: 18', 'alb' ); ?></p>
				</td>
			</tr>

			<tr>
				<td class="beer_meta_box_td" colspan="1">
					<label for="beer_servt" style="font-weight: bold;"><?php _e( 'Serving Temperature', 'alb' ); ?>
					</label>
				</td>
				<td colspan="4">
					<input type="text" name="beer_servt" class="regular-text" value="<?php echo $beer_servt; ?>">
					<p class="description"><?php _e( 'Example: 8°', 'alb' ); ?></p>
				</td>
			</tr>

			<tr>
				<td class="beer_meta_box_td" colspan="1">
					<label for="beer_pair" style="font-weight: bold;"><?php _e( 'Pairings', 'alb' ); ?>
					</label>
				</td>
				<td colspan="4">
					<input type="text" name="beer_pair" class="regular-text" value="<?php echo $beer_pair; ?>">
					<p class="description"><?php _e( 'Example: Fish, poltry', 'alb' ); ?></p>
				</td>
			</tr>

			<tr>
				<td class="beer_meta_box_td" colspan="1">
					<label for="beer_sizes" style="font-weight: bold;"><?php _e( 'Size Small', 'alb' ); ?>
					</label>
				</td>
				<td colspan="4">
					<input type="text" name="beer_sizes" class="regular-text" value="<?php echo $beer_sizes; ?>">
					<p class="description"><?php _e( 'Example: 0.22L', 'alb' ); ?></p>
				</td>
			</tr>

			<tr>
				<td class="beer_meta_box_td" colspan="1">
					<label for="beer_prices" style="font-weight: bold;"><?php _e( 'Price Small', 'alb' ); ?>
					</label>
				</td>
				<td colspan="4">
					<input type="text" name="beer_prices" class="regular-text" value="<?php echo $beer_prices; ?>">
					<p class="description"><?php _e( 'Example: 2.5€', 'alb' ); ?></p>
				</td>
			</tr>

			<tr>
				<td class="beer_meta_box_td" colspan="1">
					<label for="beer_sizem" style="font-weight: bold;"><?php _e( 'Size Medium', 'alb' ); ?>
					</label>
				</td>
				<td colspan="4">
					<input type="text" name="beer_sizem" class="regular-text" value="<?php echo $beer_sizem; ?>">
					<p class="description"><?php _e( 'Example: 0.4L', 'alb' ); ?></p>
				</td>
			</tr>

			<tr>
				<td class="beer_meta_box_td" colspan="1">
					<label for="beer_pricem" style="font-weight: bold;"><?php _e( 'Price Medium', 'alb' ); ?>
					</label>
				</td>
				<td colspan="4">
					<input type="text" name="beer_pricem" class="regular-text" value="<?php echo $beer_pricem; ?>">
					<p class="description"><?php _e( 'Example: 5€', 'alb' ); ?></p>
				</td>
			</tr>

		</table>

	<?php }

   /**
	* Save beer metaboxes
	*
	*/
	function save_beer_meta_boxes( $post_id ) {

		global $post;

		// Verify nonce
		if ( !isset( $_POST['beer_profile_fields'] ) || !wp_verify_nonce( $_POST['beer_profile_fields'], basename(__FILE__) ) ) {
			return $post_id;
		}

		// Check Autosave
		if ( (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || ( defined('DOING_AJAX') && DOING_AJAX) || isset($_REQUEST['bulk_edit']) ) {
			return $post_id;
		}

		// Don't save if only a revision
		if ( isset( $post->post_type ) && $post->post_type == 'revision' ) {
			return $post_id;
		}

		// Check permissions
		if ( !current_user_can( 'edit_post', $post->ID ) ) {
			return $post_id;
		}

		$meta['beer_brew_name'] = ( isset( $_POST['beer_brew_name'] ) ? esc_textarea( $_POST['beer_brew_name'] ) : '' );
		$meta['beer_brew_add'] = ( isset( $_POST['beer_brew_add'] ) ? esc_textarea( $_POST['beer_brew_add'] ) : '' );
		$meta['beer_abv'] = ( isset( $_POST['beer_abv'] ) ? esc_textarea( $_POST['beer_abv'] ) : '' );
		$meta['beer_og'] = ( isset( $_POST['beer_og'] ) ? esc_textarea( $_POST['beer_og'] ) : '' );
		$meta['beer_ibu'] = ( isset( $_POST['beer_ibu'] ) ? esc_textarea( $_POST['beer_ibu'] ) : '' );
		$meta['beer_fg'] = ( isset( $_POST['beer_fg'] ) ? esc_textarea( $_POST['beer_fg'] ) : '' );
		$meta['beer_color'] = ( isset( $_POST['beer_color'] ) ? esc_textarea( $_POST['beer_color'] ) : '' );
		$meta['beer_grains'] = ( isset( $_POST['beer_grains'] ) ? esc_textarea( $_POST['beer_grains'] ) : '' );
		$meta['beer_yeast'] = ( isset( $_POST['beer_yeast'] ) ? esc_textarea( $_POST['beer_yeast'] ) : '' );
		$meta['beer_hops'] = ( isset( $_POST['beer_hops'] ) ? esc_textarea( $_POST['beer_hops'] ) : '' );
		$meta['beer_plato'] = ( isset( $_POST['beer_plato'] ) ? esc_textarea( $_POST['beer_plato'] ) : '' );
		$meta['beer_servt'] = ( isset( $_POST['beer_servt'] ) ? esc_textarea( $_POST['beer_servt'] ) : '' );
		$meta['beer_pair'] = ( isset( $_POST['beer_pair'] ) ? esc_textarea( $_POST['beer_pair'] ) : '' );
		$meta['beer_sizes'] = ( isset( $_POST['beer_sizes'] ) ? esc_textarea( $_POST['beer_sizes'] ) : '' );
		$meta['beer_prices'] = ( isset( $_POST['beer_prices'] ) ? esc_textarea( $_POST['beer_prices'] ) : '' );
		$meta['beer_sizem'] = ( isset( $_POST['beer_sizem'] ) ? esc_textarea( $_POST['beer_sizem'] ) : '' );
		$meta['beer_pricem'] = ( isset( $_POST['beer_pricem'] ) ? esc_textarea( $_POST['beer_pricem'] ) : '' );

		foreach ( $meta as $key => $value ) {
			update_post_meta( $post->ID, $key, $value );
		}
	}

	/**
	 * Register the time metaboxes to be used for the sandwich post type
	 *
	 */
	public function add_sandwich_meta_boxes() {
		add_meta_box(
			'sandwich_profile_fields',
			__( 'Sandwich Profile', 'alb' ),
			array( $this, 'render_sandwich_meta_boxes' ),
			array( 'sandwich' ),
			'normal',
			'high'
		);
	}

   /**
	* The HTML for the sandwich profile fields
	*/
	function render_sandwich_meta_boxes( $post ) {

		$meta = get_post_custom( $post->ID );
		$sandwich_ingredient_1 = ! isset( $meta['sandwich_ingredient_1'][0] ) ? '' : $meta['sandwich_ingredient_1'][0];
		$sandwich_ingredient_2 = ! isset( $meta['sandwich_ingredient_2'][0] ) ? '' : $meta['sandwich_ingredient_2'][0];
		$sandwich_ingredient_3 = ! isset( $meta['sandwich_ingredient_3'][0] ) ? '' : $meta['sandwich_ingredient_3'][0];
		$sandwich_ingredient_4 = ! isset( $meta['sandwich_ingredient_4'][0] ) ? '' : $meta['sandwich_ingredient_4'][0];
		$sandwich_ingredient_5 = ! isset( $meta['sandwich_ingredient_5'][0] ) ? '' : $meta['sandwich_ingredient_5'][0];		
		$sandwich_price = ! isset( $meta['sandwich_price'][0] ) ? '' : $meta['sandwich_price'][0];

		wp_nonce_field( basename( __FILE__ ), 'sandwich_profile_fields' ); ?>

		<table class="form-table">

			<tr>
				<td class="sandwich_sc" colspan="1">
					<label for="sandwich_sc" style="font-weight: bold;"><?php _e( 'Sandwich Shortcode', 'alb' ); ?>
					</label>
				</td>
				<td colspan="4">
					<code class="sandwich_sc">[<?php echo get_post_type( $post->ID ); ?> id="<?php echo $post->ID; ?>"]</code>
				</td>
			</tr>

			<tr>
				<td class="sandwich_meta_box_td" colspan="1">
					<label for="sandwich_ingredient_1" style="font-weight: bold;"><?php _e( 'Ingredient 1', 'alb' ); ?>
					</label>
				</td>
				<td colspan="4">
					<input type="text" name="sandwich_ingredient_1" class="regular-text" value="<?php echo $sandwich_ingredient_1; ?>">
					<p class="description"><?php _e( 'Example: Ciabatta Breead', 'alb' ); ?></p>
				</td>
			</tr>

			<tr>
				<td class="sandwich_meta_box_td" colspan="1">
					<label for="sandwich_ingredient_2" style="font-weight: bold;"><?php _e( 'Ingredient 2', 'alb' ); ?>
					</label>
				</td>
				<td colspan="4">
					<input type="text" name="sandwich_ingredient_2" class="regular-text" value="<?php echo $sandwich_ingredient_2; ?>">
					<p class="description"><?php _e( 'Example: Fassone Hamburger (200g)', 'alb' ); ?></p>
				</td>
			</tr>

			<tr>
				<td class="sandwich_meta_box_td" colspan="1">
					<label for="sandwich_ingredient_3" style="font-weight: bold;"><?php _e( 'Ingredient 3', 'alb' ); ?>
					</label>
				</td>
				<td colspan="4">
					<input type="text" name="sandwich_ingredient_3" class="regular-text" value="<?php echo $sandwich_ingredient_3; ?>">
					<p class="description"><?php _e( 'Example: Brie Cheese', 'alb' ); ?></p>
				</td>
			</tr>

			<tr>
				<td class="sandwich_meta_box_td" colspan="1">
					<label for="sandwich_ingredient_4" style="font-weight: bold;"><?php _e( 'Ingredient 4', 'alb' ); ?>
					</label>
				</td>
				<td colspan="4">
					<input type="text" name="sandwich_ingredient_4" class="regular-text" value="<?php echo $sandwich_ingredient_4; ?>">
					<p class="description"><?php _e( 'Example: Bacon', 'alb' ); ?></p>
				</td>
			</tr>

			<tr>
				<td class="sandwich_meta_box_td" colspan="1">
					<label for="sandwich_ingredient_5" style="font-weight: bold;"><?php _e( 'Ingredient 5', 'alb' ); ?>
					</label>
				</td>
				<td colspan="4">
					<input type="text" name="sandwich_ingredient_5" class="regular-text" value="<?php echo $sandwich_ingredient_5; ?>">
					<p class="description"><?php _e( 'Example: Mustard', 'alb' ); ?></p>
				</td>
			</tr>

			<tr>
				<td class="sandwich_meta_box_td" colspan="1">
					<label for="sandwich_price" style="font-weight: bold;"><?php _e( 'Price', 'alb' ); ?>
					</label>
				</td>
				<td colspan="4">
					<input type="number" name="sandwich_price" class="regular-text" value="<?php echo $sandwich_price; ?>">€
					<p class="description"><?php _e( 'Example: 5', 'alb' ); ?></p>
				</td>
			</tr>

		</table>

	<?php }

   /**
	* Save beer metaboxes
	*
	*/
	function save_sandwich_meta_boxes( $post_id ) {

		global $post;

		// Verify nonce
		if ( !isset( $_POST['sandwich_profile_fields'] ) || !wp_verify_nonce( $_POST['sandwich_profile_fields'], basename(__FILE__) ) ) {
			return $post_id;
		}

		// Check Autosave
		if ( (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || ( defined('DOING_AJAX') && DOING_AJAX) || isset($_REQUEST['bulk_edit']) ) {
			return $post_id;
		}

		// Don't save if only a revision
		if ( isset( $post->post_type ) && $post->post_type == 'revision' ) {
			return $post_id;
		}

		// Check permissions
		if ( !current_user_can( 'edit_post', $post->ID ) ) {
			return $post_id;
		}

		$meta['sandwich_ingredient_1'] = ( isset( $_POST['sandwich_ingredient_1'] ) ? esc_textarea( $_POST['sandwich_ingredient_1'] ) : '' );
		$meta['sandwich_ingredient_2'] = ( isset( $_POST['sandwich_ingredient_2'] ) ? esc_textarea( $_POST['sandwich_ingredient_2'] ) : '' );
		$meta['sandwich_ingredient_3'] = ( isset( $_POST['sandwich_ingredient_3'] ) ? esc_textarea( $_POST['sandwich_ingredient_3'] ) : '' );
		$meta['sandwich_ingredient_4'] = ( isset( $_POST['sandwich_ingredient_4'] ) ? esc_textarea( $_POST['sandwich_ingredient_4'] ) : '' );
		$meta['sandwich_ingredient_5'] = ( isset( $_POST['sandwich_ingredient_5'] ) ? esc_textarea( $_POST['sandwich_ingredient_5'] ) : '' );
		$meta['sandwich_price'] = ( isset( $_POST['sandwich_price'] ) ? esc_textarea( $_POST['sandwich_price'] ) : '' );
		
		foreach ( $meta as $key => $value ) {
			update_post_meta( $post->ID, $key, $value );
		}
	}

	/**
	 * Register the metaboxes to be used for the event post type
	 *
	 */
	public function add_event_meta_boxes() {
		add_meta_box(
			'time_fields',
			__( 'Event description', 'iusetvis' ),
			array( $this, 'render_event_meta_boxes' ),
			'event',
			'normal',
			'high'
		);
	}

   /**
	* The HTML for the time fields
	*/
	function render_event_meta_boxes( $post ) {

		$meta = get_post_custom( $post->ID );
		$event_start_display = ! isset( $meta['event_start_display'][0] ) ? '' : $meta['event_start_display'][0];
		$event_end_display = ! isset( $meta['event_end_display'][0] ) ? '' : $meta['event_end_display'][0];
		$event_start_date = ! isset( $meta['event_start_date'][0] ) ? '' : $meta['event_start_date'][0];
		$event_end_date = ! isset( $meta['event_end_date'][0] ) ? '' : $meta['event_end_date'][0];

		wp_nonce_field( basename( __FILE__ ), 'event_fields' ); ?>

		<table class="form-table">

			<tr>
				<td class="event_sc" colspan="1">
					<label for="event_sc" style="font-weight: bold;"><?php _e( 'Event Shortcode', 'alb' ); ?>
					</label>
				</td>
				<td colspan="4">
					<code class="event_sc">[<?php echo get_post_type( $post->ID ); ?> id="<?php echo $post->ID; ?>"]</code>
				</td>
			</tr>

			<tr>
				<td class="event_meta_box_td" colspan="1">
					<label for="event_start_display" style="font-weight: bold;"><?php _e( 'Start Display Date', 'iusetvis' ); ?>
					</label>
				</td>
				<td colspan="4">
					<input type="date" name="event_start_display" class="regular-text" value="<?php echo date( 'Y-m-d', $event_start_display ); ?>">
				</td>
			</tr>

			<tr>
				<td class="event_meta_box_td" colspan="1">
					<label for="event_end_display" style="font-weight: bold;"><?php _e( 'End Display Date', 'iusetvis' ); ?>
					</label>
				</td>
				<td colspan="4">
					<input type="date" name="event_end_display" class="regular-text" value="<?php echo date( 'Y-m-d', $event_end_display ); ?>">
				</td>
			</tr>

			<tr>
				<td class="event_meta_box_td" colspan="1">
					<label for="event_start_date" style="font-weight: bold;"><?php _e( 'Event Start Date', 'iusetvis' ); ?>
					</label>
				</td>
				<td colspan="4">
					<input type="date" name="event_start_date" class="regular-text" value="<?php echo date( 'Y-m-d', $event_start_date ); ?>">
				</td>
			</tr>

			<tr>
				<td class="event_meta_box_td" colspan="1">
					<label for="event_end_date" style="font-weight: bold;"><?php _e( 'Event End Date', 'iusetvis' ); ?>
					</label>
				</td>
				<td colspan="4">
					<input type="date" name="event_end_date" class="regular-text" value="<?php echo date( 'Y-m-d', $event_end_date ); ?>">
				</td>
			</tr>

		</table>

	<?php }

   /**
	* Save time metaboxes
	*
	*/
	function save_event_meta_boxes( $post_id ) {

		global $post;

		// Verify nonce
		if ( !isset( $_POST['event_fields'] ) || !wp_verify_nonce( $_POST['event_fields'], basename(__FILE__) ) ) {
			return $post_id;
		}

		// Check Autosave
		if ( (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || ( defined('DOING_AJAX') && DOING_AJAX) || isset($_REQUEST['bulk_edit']) ) {
			return $post_id;
		}

		// Don't save if only a revision
		if ( isset( $post->post_type ) && $post->post_type == 'revision' ) {
			return $post_id;
		}

		// Check permissions
		if ( !current_user_can( 'edit_post', $post->ID ) ) {
			return $post_id;
		}

		$meta['event_start_display'] = ( isset( $_POST['event_start_display'] ) ? strtotime( esc_textarea( $_POST['event_start_display'] ) ) : '' );
		$meta['event_end_display'] = ( isset( $_POST['event_end_display'] ) ? strtotime( esc_textarea( $_POST['event_end_display'] ) ) : '' );
		$meta['event_start_date'] = ( isset( $_POST['event_start_date'] ) ? strtotime( esc_textarea( $_POST['event_start_date'] ) ) : '' );
		$meta['event_end_date'] = ( isset( $_POST['event_end_date'] ) ? strtotime( esc_textarea( $_POST['event_end_date'] ) ) : '' );

		foreach ( $meta as $key => $value ) {
			update_post_meta( $post->ID, $key, $value );
		}
	}

}
