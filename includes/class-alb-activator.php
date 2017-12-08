<?php

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/kokiddp/
 * @since      1.0.0
 *
 * @package    Alb
 * @subpackage Alb/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Alb
 * @subpackage Alb/includes
 * @author     Gabriele Coquillard <gabriele.coquillard@gmail.com>
 */
class Alb_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		flush_rewrite_rules();
		add_theme_support( 'post-thumbnails' );

		if ( !post_exists( 'taplist' ) ) {
			$taplist = array(
		        'post_title' => __( 'Tap List', 'alb' ),
		        'post_name' => 'taplist',
		        'post_status' => 'publish',
		        'post_type' => 'page',
		        'comment_status' => 'closed',
		        'ping_status' => 'open'
		    );

			wp_insert_post( $taplist );
		}

	}

	/**
	 *   Determine if a post exists based on post_name and post_type
	 *
	 *   @param $post_name string unique post name	
	 *   @param $post_type string post type (defaults to 'post')
	 */

	public function post_exists( $post_name ) {

		global $wpdb;
	    if($wpdb->get_row("SELECT post_name FROM wp_posts WHERE post_name = '" . $post_name . "'", 'ARRAY_A')) {
	        return true;
	    } else {
	        return false;
	    }

	}

}
