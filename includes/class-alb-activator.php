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

		if ( !post_exists( 'bottlelist' ) ) {
			$bottlelist = array(
		        'post_title' => __( 'Bottle List', 'alb' ),
		        'post_name' => 'bottlelist',
		        'post_status' => 'publish',
		        'post_type' => 'page',
		        'comment_status' => 'closed',
		        'ping_status' => 'open'
		    );

			wp_insert_post( $bottlelist );
		}

		if ( !post_exists( 'events' ) ) {
			$events = array(
		        'post_title' => __( 'Events', 'alb' ),
		        'post_name' => 'events',
		        'post_status' => 'publish',
		        'post_type' => 'page',
		        'comment_status' => 'closed',
		        'ping_status' => 'open'
		    );

			wp_insert_post( $events );
		}

		if ( !post_exists( 'news' ) ) {
			$events = array(
		        'post_title' => __( 'News', 'alb' ),
		        'post_name' => 'news',
		        'post_status' => 'publish',
		        'post_type' => 'page',
		        'comment_status' => 'closed',
		        'ping_status' => 'open'
		    );

			wp_insert_post( $events );
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
	    if( is_object( $wpdb->get_row("SELECT post_name FROM wp_posts WHERE post_name = '" . $post_name . "'", 'ARRAY_A') ) ) {
	        return true;
	    } else {
	        return false;
	    }

	}

}
