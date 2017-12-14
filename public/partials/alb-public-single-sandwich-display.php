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

$url = str_replace( 'partials/', '', plugin_dir_url( __FILE__ ) );
?>

<!doctype html>
<html lang="<?= get_locale() ?>">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title><?php the_title(); ?></title>

  <link rel="stylesheet" href="<?= $url . 'css/alb-public.css' ?>">

  <script
    src="https://code.jquery.com/jquery-3.2.1.min.js"
    integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
    crossorigin="anonymous"></script>
  <script
    src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
    integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
    crossorigin="anonymous"></script>
  <script 
    src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.Marquee/1.5.0/jquery.marquee.min.js" 
    integrity="sha256-I7mznqYTCAUiVrmSG/HA3maYvPDATj5PKXityGFo/24=" 
    crossorigin="anonymous"></script>
  <script src="<?= $url . 'js/alb-public.js' ?>"></script>
</head>
<body>

<?php while ( have_posts() ) : the_post(); ?>

    <div id="sandwich_left">
        <?php the_title( '<h1 class="sandwich_title">', '</h1>' ); ?>

        <?php $taxonomies = get_the_terms(get_the_ID(), 'sandwich_tag'); 
        if ( $taxonomies && count( $taxonomies ) > 0 ) {
            
            foreach ($taxonomies as $taxonomy) { ?>
                <h2 class="sandwich_tag"><?php echo esc_html( $taxonomy->name ); ?></h2>
            <?php }?>

        <?php }?>

        <?php $categories = get_the_terms(get_the_ID(), 'sandwich_category'); 
        if ( $categories && count( $categories ) > 0 ) {

            foreach ($categories as $category) { ?>
                <h3 class="sandwich_category"><?php echo esc_html( $category->name ); ?></h3>
            <?php }?>

        <?php }?>

        <div class="sandwich_content">
            <?php the_content(); ?>
        </div>
        
        <?php if ( has_post_thumbnail() ) { ?>

            <div class="sandwich_image_wrap">                       
                <div class="sandwich_image">
                    <?php echo get_the_post_thumbnail( get_the_ID(), array(650, 450) ); ?>
                </div><!-- .sandwich_image -->                      
            </div><!-- .sandwiche_image_wrap -->

        <?php }?>
        <div id="alb_sandwich_logo"></div>
    </div>

    <div id="sandwich_right">
        <h2 class="sandwich_ingredients_header"><?php _e('Ingredients', 'alb'); ?></h2>

        <ul class="sandwich_ingredients_list">
        <?php // Sandwich ingredient 1
           $sandwich_ingredient_1 = get_post_meta( get_the_ID(), 'sandwich_ingredient_1', true );
           if ( !empty( $sandwich_ingredient_1 ) ) {
        ?>
            <li class="sandwich_ingredient_1">
                <span class="sandwich_profile_heading"><?php _e('1: ','iusetvis'); ?></span>
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
                <span class="sandwich_profile_heading"><?php _e('2: ','iusetvis'); ?></span>
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
                <span class="sandwich_profile_heading"><?php _e('3: ','iusetvis'); ?></span>
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
                <span class="sandwich_profile_heading"><?php _e('4: ','iusetvis'); ?></span>
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
                <span class="sandwich_profile_heading"><?php _e('5: ','iusetvis'); ?></span>
                <span class="sandwich_profile_meta">
                    <?php 
                        echo $sandwich_ingredient_5;
                    ?>
                </span>
            </li>
        <?php } ?>

        </ul>

    <?php // Sandwich price
       $sandwich_price = get_post_meta( get_the_ID(), 'sandwich_price', true );
       if ( !empty( $sandwich_price ) ) {
    ?>
        <div class="sandwich_price">
            <span class="sandwich_profile_meta">
                € 
                <?php 
                    echo $sandwich_price;
                ?>
            </span>
        </div>
    <?php } ?>
    </div> 

<?php endwhile; // end of the loop. ?>

</body>
</html>