<?php

/**
 * Template for Single Tap Beer Post Type
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

<?php the_title(); ?>

<?php $taxonomies = get_the_terms(get_the_ID(), 'beer_tag'); 
if ( $taxonomies && count( $taxonomies ) > 0 ) {
    
    foreach ($taxonomies as $taxonomy) { ?>
        <?php echo esc_html( $taxonomy->name ); ?>
    <?php }?>

<?php }?>

<?php $categories = get_the_terms(get_the_ID(), 'beer_category');
if ( count( $categories ) > 0 ) {

    foreach ($categories as $category) { ?>
        <?php echo esc_html( $category->name ); ?>
    <?php }?>

<?php }?>

<?php if ( has_post_thumbnail() ) { ?>

    <?php echo get_the_post_thumbnail( get_the_ID(), 'medium' ); ?>

<?php } ?>

<?php the_content(); ?>

<?php get_footer(); ?>