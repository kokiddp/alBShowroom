<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/kokiddp/
 * @since      1.0.0
 *
 * @package    Alb
 * @subpackage Alb/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Alb
 * @subpackage Alb/admin
 * @author     Gabriele Coquillard <gabriele.coquillard@gmail.com>
 */
class Alb_Admin {

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
		 * defined in Alb_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Alb_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/alb-admin.css', array(), $this->version, 'all' );

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
		 * defined in Alb_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Alb_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/alb-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Add the shortcodes for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function add_shortcodes() {


	}

	/**
	 * Add the menu for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function alb_add_admin_menu(  ) { 

		add_menu_page( 
			__( 'AlBirrificio Showroom Settings', 'alb' ),
			__( 'alB Settings', 'alb' ),
			'edit_pages', 
			$this->plugin_name . '_options_page',
			array( $this, 'alb_render_options_page' ),
			'dashicons-hammer'
		);		

	}

	/**
	 * Init the settings fields for the settings admin area.
	 *
	 * @since    1.0.0
	 */
	public function alb_settings_init(  ) { 

		register_setting( $this->plugin_name . '_options_page', 'alb_settings' );

		add_settings_section(
			'alb_options_page_section_taplist', 
			__( 'Taplist Beers', 'alb' ), 
			array( $this, 'alb_taplist_settings_section_callback' ), 
			$this->plugin_name . '_options_page'
		);

		add_settings_field( 
			'alb_select_tap_1', 
			__( '#1', 'alb' ), 
			array( $this, 'alb_select_tap_1_render' ), 
			$this->plugin_name . '_options_page', 
			$this->plugin_name . '_options_page_section_taplist' 
		);

		add_settings_field( 
			'alb_select_tap_2', 
			__( '#2', 'alb' ), 
			array( $this, 'alb_select_tap_2_render' ), 
			$this->plugin_name . '_options_page', 
			$this->plugin_name . '_options_page_section_taplist' 
		);

		add_settings_field( 
			'alb_select_tap_3', 
			__( '#3', 'alb' ), 
			array( $this, 'alb_select_tap_3_render' ), 
			$this->plugin_name . '_options_page', 
			$this->plugin_name . '_options_page_section_taplist' 
		);

		add_settings_field( 
			'alb_select_tap_4', 
			__( '#4', 'alb' ), 
			array( $this, 'alb_select_tap_4_render' ), 
			$this->plugin_name . '_options_page', 
			$this->plugin_name . '_options_page_section_taplist' 
		);

		add_settings_field( 
			'alb_select_tap_5', 
			__( '#5', 'alb' ), 
			array( $this, 'alb_select_tap_5_render' ), 
			$this->plugin_name . '_options_page', 
			$this->plugin_name . '_options_page_section_taplist' 
		);

		add_settings_field( 
			'alb_select_tap_6', 
			__( '#6', 'alb' ), 
			array( $this, 'alb_select_tap_6_render' ), 
			$this->plugin_name . '_options_page', 
			$this->plugin_name . '_options_page_section_taplist' 
		);

		add_settings_field( 
			'alb_select_tap_7', 
			__( '#7', 'alb' ), 
			array( $this, 'alb_select_tap_7_render' ), 
			$this->plugin_name . '_options_page', 
			$this->plugin_name . '_options_page_section_taplist' 
		);

		add_settings_field( 
			'alb_select_tap_8', 
			__( '#8', 'alb' ), 
			array( $this, 'alb_select_tap_8_render' ), 
			$this->plugin_name . '_options_page', 
			$this->plugin_name . '_options_page_section_taplist' 
		);

		add_settings_field( 
			'alb_select_tap_9', 
			__( '#9', 'alb' ), 
			array( $this, 'alb_select_tap_9_render' ), 
			$this->plugin_name . '_options_page', 
			$this->plugin_name . '_options_page_section_taplist' 
		);

		add_settings_field( 
			'alb_select_tap_10', 
			__( '#10', 'alb' ), 
			array( $this, 'alb_select_tap_10_render' ), 
			$this->plugin_name . '_options_page', 
			$this->plugin_name . '_options_page_section_taplist' 
		);

		add_settings_field( 
			'alb_select_tap_P1', 
			__( '#P1', 'alb' ), 
			array( $this, 'alb_select_tap_P1_render' ), 
			$this->plugin_name . '_options_page', 
			$this->plugin_name . '_options_page_section_taplist' 
		);

		add_settings_field( 
			'alb_select_tap_P2', 
			__( '#P2', 'alb' ), 
			array( $this, 'alb_select_tap_P2_render' ), 
			$this->plugin_name . '_options_page', 
			$this->plugin_name . '_options_page_section_taplist' 
		);

	}

	/**
	 * Add the #1 select for the settings area.
	 *
	 * @since    1.0.0
	 */
	function alb_select_tap_1_render(  ) { 

		$options = get_option( 'alb_settings' );
		$tap_beers = get_posts([
		 	'post_type' => 'tap_beer',
			'post_status' => 'publish',
		 	'numberposts' => -1,
			'order'    => 'ASC'
		]);

		?>
		<select name='alb_settings[alb_select_tap_1]'>
			<?php
			if ( count( $tap_beers ) > 0 ) {
				foreach ($tap_beers as $index => $beer) {
					echo '<option value="' . $beer->ID . '" ' . selected( $options['alb_select_tap_1'], $beer->ID ) . '>' . $beer->post_title . '</option>';
				}
			}
			else {
				echo '<option value="0" ' . selected( $options['alb_select_tap_1'], 0 ) .'>' . __( 'No Tab Beer available', 'alb' ) . '</option>';
			}
			?>
		</select>

	<?php

	}

	/**
	 * Add the #2 select for the settings area.
	 *
	 * @since    1.0.0
	 */
	function alb_select_tap_2_render(  ) { 

		$options = get_option( 'alb_settings' );
		$tap_beers = get_posts([
		 	'post_type' => 'tap_beer',
			'post_status' => 'publish',
		 	'numberposts' => -1,
			'order'    => 'ASC'
		]);

		?>
		<select name='alb_settings[alb_select_tap_2]'>
			<?php
			if ( count( $tap_beers ) > 0 ) {
				foreach ($tap_beers as $index => $beer) {
					echo '<option value="' . $beer->ID . '" ' . selected( $options['alb_select_tap_2'], $beer->ID ) . '>' . $beer->post_title . '</option>';
				}
			}
			else {
				echo '<option value="0" ' . selected( $options['alb_select_tap_2'], 0 ) .'>' . __( 'No Tab Beer available', 'alb' ) . '</option>';
			}
			?>
		</select>

	<?php

	}

	/**
	 * Add the #3 select for the settings area.
	 *
	 * @since    1.0.0
	 */
	function alb_select_tap_3_render(  ) { 

		$options = get_option( 'alb_settings' );
		$tap_beers = get_posts([
		 	'post_type' => 'tap_beer',
			'post_status' => 'publish',
		 	'numberposts' => -1,
			'order'    => 'ASC'
		]);

		?>
		<select name='alb_settings[alb_select_tap_3]'>
			<?php
			if ( count( $tap_beers ) > 0 ) {
				foreach ($tap_beers as $index => $beer) {
					echo '<option value="' . $beer->ID . '" ' . selected( $options['alb_select_tap_3'], $beer->ID ) . '>' . $beer->post_title . '</option>';
				}
			}
			else {
				echo '<option value="0" ' . selected( $options['alb_select_tap_3'], 0 ) .'>' . __( 'No Tab Beer available', 'alb' ) . '</option>';
			}
			?>
		</select>

	<?php

	}

	/**
	 * Add the #4 select for the settings area.
	 *
	 * @since    1.0.0
	 */
	function alb_select_tap_4_render(  ) { 

		$options = get_option( 'alb_settings' );
		$tap_beers = get_posts([
		 	'post_type' => 'tap_beer',
			'post_status' => 'publish',
		 	'numberposts' => -1,
			'order'    => 'ASC'
		]);

		?>
		<select name='alb_settings[alb_select_tap_4]'>
			<?php
			if ( count( $tap_beers ) > 0 ) {
				foreach ($tap_beers as $index => $beer) {
					echo '<option value="' . $beer->ID . '" ' . selected( $options['alb_select_tap_4'], $beer->ID ) . '>' . $beer->post_title . '</option>';
				}
			}
			else {
				echo '<option value="0" ' . selected( $options['alb_select_tap_4'], 0 ) .'>' . __( 'No Tab Beer available', 'alb' ) . '</option>';
			}
			?>
		</select>

	<?php

	}

	/**
	 * Add the #5 select for the settings area.
	 *
	 * @since    1.0.0
	 */
	function alb_select_tap_5_render(  ) { 

		$options = get_option( 'alb_settings' );
		$tap_beers = get_posts([
		 	'post_type' => 'tap_beer',
			'post_status' => 'publish',
		 	'numberposts' => -1,
			'order'    => 'ASC'
		]);

		?>
		<select name='alb_settings[alb_select_tap_5]'>
			<?php
			if ( count( $tap_beers ) > 0 ) {
				foreach ($tap_beers as $index => $beer) {
					echo '<option value="' . $beer->ID . '" ' . selected( $options['alb_select_tap_5'], $beer->ID ) . '>' . $beer->post_title . '</option>';
				}
			}
			else {
				echo '<option value="0" ' . selected( $options['alb_select_tap_5'], 0 ) .'>' . __( 'No Tab Beer available', 'alb' ) . '</option>';
			}
			?>
		</select>

	<?php

	}

	/**
	 * Add the #6 select for the settings area.
	 *
	 * @since    1.0.0
	 */
	function alb_select_tap_6_render(  ) { 

		$options = get_option( 'alb_settings' );
		$tap_beers = get_posts([
		 	'post_type' => 'tap_beer',
			'post_status' => 'publish',
		 	'numberposts' => -1,
			'order'    => 'ASC'
		]);

		?>
		<select name='alb_settings[alb_select_tap_6]'>
			<?php
			if ( count( $tap_beers ) > 0 ) {
				foreach ($tap_beers as $index => $beer) {
					echo '<option value="' . $beer->ID . '" ' . selected( $options['alb_select_tap_6'], $beer->ID ) . '>' . $beer->post_title . '</option>';
				}
			}
			else {
				echo '<option value="0" ' . selected( $options['alb_select_tap_6'], 0 ) .'>' . __( 'No Tab Beer available', 'alb' ) . '</option>';
			}
			?>
		</select>

	<?php

	}

	/**
	 * Add the #7 select for the settings area.
	 *
	 * @since    1.0.0
	 */
	function alb_select_tap_7_render(  ) { 

		$options = get_option( 'alb_settings' );
		$tap_beers = get_posts([
		 	'post_type' => 'tap_beer',
			'post_status' => 'publish',
		 	'numberposts' => -1,
			'order'    => 'ASC'
		]);

		?>
		<select name='alb_settings[alb_select_tap_7]'>
			<?php
			if ( count( $tap_beers ) > 0 ) {
				foreach ($tap_beers as $index => $beer) {
					echo '<option value="' . $beer->ID . '" ' . selected( $options['alb_select_tap_7'], $beer->ID ) . '>' . $beer->post_title . '</option>';
				}
			}
			else {
				echo '<option value="0" ' . selected( $options['alb_select_tap_7'], 0 ) .'>' . __( 'No Tab Beer available', 'alb' ) . '</option>';
			}
			?>
		</select>

	<?php

	}

	/**
	 * Add the #8 select for the settings area.
	 *
	 * @since    1.0.0
	 */
	function alb_select_tap_8_render(  ) { 

		$options = get_option( 'alb_settings' );
		$tap_beers = get_posts([
		 	'post_type' => 'tap_beer',
			'post_status' => 'publish',
		 	'numberposts' => -1,
			'order'    => 'ASC'
		]);

		?>
		<select name='alb_settings[alb_select_tap_8]'>
			<?php
			if ( count( $tap_beers ) > 0 ) {
				foreach ($tap_beers as $index => $beer) {
					echo '<option value="' . $beer->ID . '" ' . selected( $options['alb_select_tap_8'], $beer->ID ) . '>' . $beer->post_title . '</option>';
				}
			}
			else {
				echo '<option value="0" ' . selected( $options['alb_select_tap_8'], 0 ) .'>' . __( 'No Tab Beer available', 'alb' ) . '</option>';
			}
			?>
		</select>

	<?php

	}

	/**
	 * Add the #9 select for the settings area.
	 *
	 * @since    1.0.0
	 */
	function alb_select_tap_9_render(  ) { 

		$options = get_option( 'alb_settings' );
		$tap_beers = get_posts([
		 	'post_type' => 'tap_beer',
			'post_status' => 'publish',
		 	'numberposts' => -1,
			'order'    => 'ASC'
		]);

		?>
		<select name='alb_settings[alb_select_tap_9]'>
			<?php
			if ( count( $tap_beers ) > 0 ) {
				foreach ($tap_beers as $index => $beer) {
					echo '<option value="' . $beer->ID . '" ' . selected( $options['alb_select_tap_9'], $beer->ID ) . '>' . $beer->post_title . '</option>';
				}
			}
			else {
				echo '<option value="0" ' . selected( $options['alb_select_tap_9'], 0 ) .'>' . __( 'No Tab Beer available', 'alb' ) . '</option>';
			}
			?>
		</select>

	<?php

	}

	/**
	 * Add the #10 select for the settings area.
	 *
	 * @since    1.0.0
	 */
	function alb_select_tap_10_render(  ) { 

		$options = get_option( 'alb_settings' );
		$tap_beers = get_posts([
		 	'post_type' => 'tap_beer',
			'post_status' => 'publish',
		 	'numberposts' => -1,
			'order'    => 'ASC'
		]);

		?>
		<select name='alb_settings[alb_select_tap_10]'>
			<?php
			if ( count( $tap_beers ) > 0 ) {
				foreach ($tap_beers as $index => $beer) {
					echo '<option value="' . $beer->ID . '" ' . selected( $options['alb_select_tap_10'], $beer->ID ) . '>' . $beer->post_title . '</option>';
				}
			}
			else {
				echo '<option value="0" ' . selected( $options['alb_select_tap_10'], 0 ) .'>' . __( 'No Tab Beer available', 'alb' ) . '</option>';
			}
			?>
		</select>

	<?php

	}

	/**
	 * Add the #P1 selct for the settings area.
	 *
	 * @since    1.0.0
	 */
	function alb_select_tap_P1_render(  ) { 

		$options = get_option( 'alb_settings' );
		$tap_beers = get_posts([
		 	'post_type' => 'tap_beer',
			'post_status' => 'publish',
		 	'numberposts' => -1,
			'order'    => 'ASC'
		]);

		?>
		<select name='alb_settings[alb_select_tap_P1]'>
			<?php
			if ( count( $tap_beers ) > 0 ) {
				foreach ($tap_beers as $index => $beer) {
					echo '<option value="' . $beer->ID . '" ' . selected( $options['alb_select_tap_P1'], $beer->ID ) . '>' . $beer->post_title . '</option>';
				}
			}
			else {
				echo '<option value="0" ' . selected( $options['alb_select_tap_P1'], 0 ) .'>' . __( 'No Tab Beer available', 'alb' ) . '</option>';
			}
			?>
		</select>

	<?php

	}

	/**
	 * Add the #P2 select for the settings area.
	 *
	 * @since    1.0.0
	 */
	function alb_select_tap_P2_render(  ) { 

		$options = get_option( 'alb_settings' );
		$tap_beers = get_posts([
		 	'post_type' => 'tap_beer',
			'post_status' => 'publish',
		 	'numberposts' => -1,
			'order'    => 'ASC'
		]);

		?>
		<select name='alb_settings[alb_select_tap_P2]'>
			<?php
			if ( count( $tap_beers ) > 0 ) {
				foreach ($tap_beers as $index => $beer) {
					echo '<option value="' . $beer->ID . '" ' . selected( $options['alb_select_tap_P2'], $beer->ID ) . '>' . $beer->post_title . '</option>';
				}
			}
			else {
				echo '<option value="0" ' . selected( $options['alb_select_tap_P2'], 0 ) .'>' . __( 'No Tab Beer available', 'alb' ) . '</option>';
			}
			?>
		</select>

	<?php

	}

	/**
	 * Add the Title for the taplist section of the settings area.
	 *
	 * @since    1.0.0
	 */
	function alb_taplist_settings_section_callback(  ) { 

		echo __( 'Tap List', 'alb' );

	}

	/**
	 * Render the settings area.
	 *
	 * @since    1.0.0
	 */
	function alb_render_options_page(  ) { 

		?>
		<form action='options.php' method='post'>

			<h2><?php _e( 'AlBirrificio Showroom Settings', 'alb' ) ?></h2>

			<?php
			settings_fields( $this->plugin_name . '_options_page' );
			do_settings_sections( $this->plugin_name . '_options_page' );
			submit_button();
			?>

		</form>
		<?php

	}

}
