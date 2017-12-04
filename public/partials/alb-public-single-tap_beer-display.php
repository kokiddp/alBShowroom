<?php

/**
 * Template for Single Tap Beer Post Type
 *
 * @link       https://github.com/kokiddp/IusEtVis
 * @since      1.0.0
 *
 * @package    Iusetvis
 * @subpackage Iusetvis/public/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<?php get_header(); ?>

<?php the_title(); ?>

<?php
$categories = get_the_terms(get_the_ID(), 'sandwich_category');

if ( count( $categories ) > 0 ) { 
    foreach ($categories as $category) { ?>
        <h3><?php echo esc_html( $category->name ); ?></h3>
    <?php }?>
<?php }?>

<?php if ( has_post_thumbnail() ) { ?>

    <?php echo get_the_post_thumbnail( get_the_ID(), 'medium' ); ?>

<?php } ?>

<?php the_content(); ?>

<?php get_footer(); ?>