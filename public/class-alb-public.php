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

		add_shortcode( 'bottled_beer', array( $this, 'bottled_beer_shortcode' ) );
		add_shortcode( 'tap_beer', array( $this, 'tap_beer_shortcode' ) );
		add_shortcode( 'sandwich', array( $this, 'sandwich_shortcode' ) );
		add_shortcode( 'event', array( $this, 'event_shortcode' ) );

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

	/**
	 * Register the Tap List Page.
	 *
	 * @since    1.0.0
	 */
	public function taplist_page() {

	    if(is_page('taplist')){	
			$page = plugin_dir_path( __FILE__ ) . 'partials/alb-public-taplist-display.php';
			include($page);
			die();
		}

	}

	/**
	 * Register the Bottled List Page.
	 *
	 * @since    1.0.0
	 */
	public function bottlelist_page() {

	    if(is_page('bottlelist')){	
			$page = plugin_dir_path( __FILE__ ) . 'partials/alb-public-bottlelist-display.php';
			include($page);
			die();
		}

	}

	/**
	 * Register the Bottled List Page.
	 *
	 * @since    1.0.0
	 */
	public function events_page() {

	    if(is_page('events')){	
			$page = plugin_dir_path( __FILE__ ) . 'partials/alb-public-events-display.php';
			include($page);
			die();
		}

	}

	public function bottled_beer_shortcode( $atts ) {

        ob_start();

        /**
        * Define attributes defaults
        *
        */
        extract( shortcode_atts( array ( 'id' => '' ), $atts ) );

        /**
        * Define WP_Query parameters based on shortcode_atts
        *
        */
        $args = array(
            'post_type'      => 'bottled_beer',
            'page_id'        => $id
        );

        /**
        * Check if the user wants to display by category/term and
        * if so, get the custom posts term/category
        *
        */
        $query = new WP_Query( $args );

        /**
        * Run the loop based on the parameters
        *
        */
        if ( $query->have_posts() ) { 

        ?>

	        <?php while ( $query->have_posts() ) : $query->the_post(); ?>

	            <?php the_title(); ?>

	            <?php $taxonomies = get_the_terms(get_the_ID(), 'beer_tag'); 
                if ( $taxonomies && count( $taxonomies ) > 0 ) {
                    
                    foreach ($taxonomies as $taxonomy) { ?>
                        <?php echo esc_html( $taxonomy->name ); ?>
                    <?php }?>

                <?php }?>

	            <?php $categories = get_the_terms(get_the_ID(), 'beer_category'); 
                if ( $categories && count( $categories ) > 0 ) {

                    foreach ($categories as $category) { ?>
                        <h3><?php echo esc_html( $category->name ); ?></h3>
                    <?php }?>

                <?php }?>

	            <?php if ( has_post_thumbnail() ) { ?>

	            	<?php echo get_the_post_thumbnail( get_the_ID(), 'medium' ); ?>

	            <?php } ?>

	            <?php the_content(); ?>

	        <?php endwhile;

	        wp_reset_postdata(); ?>

	    	<?php $tap_beer = ob_get_clean();

	    	return $tap_beer;

    	}

    }

    public function tap_beer_shortcode( $atts ) {

        ob_start();

        /**
        * Define attributes defaults
        *
        */
        extract( shortcode_atts( array ( 'id' => '' ), $atts ) );

        /**
        * Define WP_Query parameters based on shortcode_atts
        *
        */
        $args = array(
            'post_type'      => 'tap_beer',
            'page_id'        => $id
        );

        /**
        * Check if the user wants to display by category/term and
        * if so, get the custom posts term/category
        *
        */
        $query = new WP_Query( $args );

        /**
        * Run the loop based on the parameters
        *
        */
        if ( $query->have_posts() ) { 

        ?>

	        <?php while ( $query->have_posts() ) : $query->the_post(); ?>

	            <?php the_title(); ?>

	            <?php $taxonomies = get_the_terms(get_the_ID(), 'beer_tag'); 
                if ( $taxonomies && count( $taxonomies ) > 0 ) {
                    
                    foreach ($taxonomies as $taxonomy) { ?>
                        <?php echo esc_html( $taxonomy->name ); ?>
                    <?php }?>

                <?php }?>

	            <?php $categories = get_the_terms(get_the_ID(), 'beer_category');
 
                if ( $categories && count( $categories ) > 0 ) { 
                    foreach ($categories as $category) { ?>
                        <?php echo esc_html( $category->name ); ?>
                    <?php }?>

                <?php }?>

	            <?php if ( has_post_thumbnail() ) { ?>

	            	<?php echo get_the_post_thumbnail( get_the_ID(), 'medium' ); ?>

	            <?php } ?>

	            <?php the_content(); ?>

	        <?php endwhile;

	        wp_reset_postdata(); ?>

	    	<?php $tap_beer = ob_get_clean();

	    	return $tap_beer;

    	}

    }

	public function sandwich_shortcode( $atts ) {

        ob_start();

        /**
        * Define attributes defaults
        *
        */
        extract( shortcode_atts( array ( 'id' => '' ), $atts ) );

        /**
        * Define WP_Query parameters based on shortcode_atts
        *
        */
        $args = array(
            'post_type'      => 'sandwich',
            'page_id'        => $id
        );

        /**
        * Check if the user wants to display by category/term and
        * if so, get the custom posts term/category
        *
        */
        $query = new WP_Query( $args );

        /**
        * Run the loop based on the parameters
        *
        */
        if ( $query->have_posts() ) { 

        ?>

            <?php while ( $query->have_posts() ) : $query->the_post(); ?>

				<div class="post-content-inner-wrap sandwich_post_list entry-content">

	                <?php the_title( '<h2 class="sandwich-title">', '</h2>' ); ?>

	                <?php $taxonomies = get_the_terms(get_the_ID(), 'sandwich_tag'); 
	                if ( $taxonomies && count( $taxonomies ) > 0 ) {
	                    foreach ($taxonomies as $taxonomy) { ?>
	                        <h2><?php echo esc_html( $taxonomy->name ); ?></h2>
	                    <?php }?>

	                <?php }?>

	                <?php $categories = get_the_terms(get_the_ID(), 'sandwich_category');
	                if ( $categories && count( $categories ) > 0 ) {
	                    foreach ($categories as $category) { ?>
	                        <h3><?php echo esc_html( $category->name ); ?></h3>
	                    <?php }?>

	                <?php }?>

	                <?php if ( has_post_thumbnail() ) { ?>

		                <div class="sandwich_image_wrap">	                    
		                    <div class="sandwich_image">
		                        <?php echo get_the_post_thumbnail( get_the_ID(), 'medium' ); ?>
		                    </div><!-- .sandwich_image -->	                    
		                </div><!-- .sandwiche_image_wrap -->

	                <?php } // end featured image check ?>

	                <div class="sandwich_profile_wrap">

						<div class="sandwich_post_content">

	                        <?php the_content(); ?>

	                    </div><!-- .sandwich_post_content -->

	                    <div class="sandwich_profile">
	                        <ul>

	                            <?php // Sandwich ingredient 1
	                               $sandwich_ingredient_1 = get_post_meta( get_the_ID(), 'sandwich_ingredient_1', true );
	                               if ( !empty( $sandwich_ingredient_1 ) ) {
	                            ?>
	                                <li class="sandwich_ingredient_1">
	                                    <span class="sandwich_profile_heading"><?php _e('Ingredient 1: ','iusetvis'); ?></span>
	                                    <span class="sandwich_profile_meta">
	                                        <?php 
	                                            echo $sandwich_ingredient_1;
	                                        ?>
	                                    </span>
	                                </li>
	                            <?php } ?>

	                            <?php // Sandwich ingredient 2
	                               $sandwich_ingredient_2 = get_post_meta( get_the_ID(), 'sandwich_ingredient_2', true );
	                               if ( !empty( $sandwich_ingredient_2 ) ) {
	                            ?>
	                                <li class="sandwich_ingredient_2">
	                                    <span class="sandwich_profile_heading"><?php _e('Ingredient 2: ','iusetvis'); ?></span>
	                                    <span class="sandwich_profile_meta">
	                                        <?php 
	                                            echo $sandwich_ingredient_2;
	                                        ?>
	                                    </span>
	                                </li>
	                            <?php } ?>

	                            <?php // Sandwich ingredient 3
	                               $sandwich_ingredient_3 = get_post_meta( get_the_ID(), 'sandwich_ingredient_3', true );
	                               if ( !empty( $sandwich_ingredient_3 ) ) {
	                            ?>
	                                <li class="sandwich_ingredient_3">
	                                    <span class="sandwich_profile_heading"><?php _e('Ingredient 3: ','iusetvis'); ?></span>
	                                    <span class="sandwich_profile_meta">
	                                        <?php 
	                                            echo $sandwich_ingredient_3;
	                                        ?>
	                                    </span>
	                                </li>
	                            <?php } ?>

	                            <?php // Sandwich ingredient 4
	                               $sandwich_ingredient_4 = get_post_meta( get_the_ID(), 'sandwich_ingredient_4', true );
	                               if ( !empty( $sandwich_ingredient_4 ) ) {
	                            ?>
	                                <li class="sandwich_ingredient_4">
	                                    <span class="sandwich_profile_heading"><?php _e('Ingredient 4: ','iusetvis'); ?></span>
	                                    <span class="sandwich_profile_meta">
	                                        <?php 
	                                            echo $sandwich_ingredient_4;
	                                        ?>
	                                    </span>
	                                </li>
	                            <?php } ?>

	                            <?php // Sandwich ingredient 5
	                               $sandwich_ingredient_5 = get_post_meta( get_the_ID(), 'sandwich_ingredient_5', true );
	                               if ( !empty( $sandwich_ingredient_5 ) ) {
	                            ?>
	                                <li class="sandwich_ingredient_5">
	                                    <span class="sandwich_profile_heading"><?php _e('Ingredient 5: ','iusetvis'); ?></span>
	                                    <span class="sandwich_profile_meta">
	                                        <?php 
	                                            echo $sandwich_ingredient_5;
	                                        ?>
	                                    </span>
	                                </li>
	                            <?php } ?>

	                            <?php // Sandwich price
	                               $sandwich_price = get_post_meta( get_the_ID(), 'sandwich_price', true );
	                               if ( !empty( $sandwich_price ) ) {
	                            ?>
	                                <li class="sandwich_price">
	                                    <span class="sandwich_profile_heading"><?php _e('Price: ','iusetvis'); ?> €</span>
	                                    <span class="sandwich_profile_meta">
	                                        <?php 
	                                            echo $sandwich_price;
	                                        ?>
	                                    </span>
	                                </li>
	                            <?php } ?>

	                        </ul>
	                    </div><!-- .sandwich_profile -->

	                </div><!-- .sandwich_profile_wrap -->

	            </div><!-- .post-content-inner-wrap .sandwich_post_list .entry-content -->

            <?php endwhile;
        wp_reset_postdata(); ?>

    	<?php $sandwich = ob_get_clean();

    	return $sandwich;

    	}

    }

    public function event_shortcode( $atts ) {

        ob_start();

        /**
        * Define attributes defaults
        *
        */
        extract( shortcode_atts( array ( 'id' => '' ), $atts ) );

        /**
        * Define WP_Query parameters based on shortcode_atts
        *
        */
        $args = array(
            'post_type'      => 'event',
            'page_id'        => $id
        );

        /**
        * Check if the user wants to display by category/term and
        * if so, get the custom posts term/category
        *
        */
        $query = new WP_Query( $args );

        /**
        * Run the loop based on the parameters
        *
        */
        if ( $query->have_posts() ) { 

        ?>

            <?php while ( $query->have_posts() ) : $query->the_post(); ?>

				<div class="post-content-inner-wrap event_post_list entry-content">

	                <?php the_title( '<h2 class="event-title">', '</h2>' ); ?>

	                <?php $taxonomies = get_the_terms(get_the_ID(), 'event_tag'); 
	                if ( $taxonomies && count( $taxonomies ) > 0 ) {
	                    foreach ($taxonomies as $taxonomy) { ?>
	                        <h2><?php echo esc_html( $taxonomy->name ); ?></h2>
	                    <?php }?>

	                <?php }?>

	                <?php $categories = get_the_terms(get_the_ID(), 'event_category');
	                if ( $categories && count( $categories ) > 0 ) {
	                    foreach ($categories as $category) { ?>
	                        <h3><?php echo esc_html( $category->name ); ?></h3>
	                    <?php }?>

	                <?php }?>

	                <?php if ( has_post_thumbnail() ) { ?>

		                <div class="event_image_wrap">	                    
		                    <div class="event_image">
		                        <?php echo get_the_post_thumbnail( get_the_ID(), 'medium' ); ?>
		                    </div><!-- .event_image -->	                    
		                </div><!-- .event_image_wrap -->

	                <?php } // end featured image check ?>

	                <div class="event_profile_wrap">

						<div class="event_post_content">

	                        <?php the_content(); ?>

	                    </div><!-- .event_post_content -->

	                    <div class="event_profile">
	                        <ul>

	                            <?php // Start date
	                               $event_start_date = get_post_meta( get_the_ID(), 'event_start_date', true );
	                               if ( !empty( $event_start_date ) ) {
	                            ?>
	                                <li class="event_start_date">
	                                    <span class="event_profile_heading"><?php _e('Start date: ','iusetvis'); ?></span>
	                                    <span class="event_profile_meta">
	                                        <?php 
	                                            echo date_i18n( get_option( 'date_format' ) , $event_start_date );
	                                        ?>
	                                    </span>
	                                </li>
	                            <?php } ?>

	                            <?php // End date
	                               $event_end_date = get_post_meta( get_the_ID(), 'event_end_date', true );
	                               if ( !empty( $event_end_date ) ) {
	                            ?>
	                                <li class="event_end_date">
	                                    <span class="event_profile_heading"><?php _e('End date: ','iusetvis'); ?></span>
	                                    <span class="event_profile_meta">
	                                        <?php 
	                                            echo date_i18n( get_option( 'date_format' ) , $event_end_date );
	                                        ?>
	                                    </span>
	                                </li>
	                            <?php } ?>

	                        </ul>
	                    </div><!-- .event_profile -->

	                </div><!-- .event_profile_wrap -->

	            </div><!-- .post-content-inner-wrap .event_post_list .entry-content -->

            <?php endwhile;
        wp_reset_postdata(); ?>

    	<?php $event = ob_get_clean();

    	return $event;

    	}

    }

}
