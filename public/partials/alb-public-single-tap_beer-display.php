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

<?php if ( has_post_thumbnail() ) { ?>

    <?php echo get_the_post_thumbnail( get_the_ID(), 'medium' ); ?>

<?php } ?>

<?php the_content(); ?>

<?php get_footer(); ?>