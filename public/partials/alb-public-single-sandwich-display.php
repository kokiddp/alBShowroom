<?php

/**
 * Template for Single Sandwich Post Type
 *
 * @link       https://github.com/kokiddp/IusEtVis
 * @since      1.0.0
 *
* @package    Alb
 * @subpackage Alb/public
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<?php get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <?php while ( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?>>

            <div class="post-content-inner-wrap sandwich_post_list entry-content">

                <?php the_title( '<h1 class="sandwich-title">', '</h1>' ); ?>

                <?php $taxonomies = get_the_terms(get_the_ID(), 'sandwich_tag'); 
                if ( $taxonomies && count( $taxonomies ) > 0 ) {
                    
                    foreach ($taxonomies as $taxonomy) { ?>
                        <h2><?php echo esc_html( $taxonomy->name ); ?></h2>
                    <?php }?>

                <?php }?>

                <?php $categories = get_the_terms(get_the_ID(), 'sandwich_category'); 
                if ( count( $categories ) > 0 ) {

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

        </article>

        <?php endwhile; // end of the loop. ?>

    </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>