<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://github.com/kokiddp/
 * @since      1.0.0
 *
 * @package    Alb
 * @subpackage Alb/public/partials
 */


$url = str_replace( 'partials/', '', plugin_dir_url( __FILE__ ) );
?>

<!doctype html>
<html lang="<?= get_locale() ?>">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title><?php _e('News', 'alb'); ?></title>

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
    src="https://cdnjs.cloudflare.com/ajax/libs/jcarousel/0.3.5/jquery.jcarousel.js"
    integrity="sha256-ne7QVT8yf2EjMBos3wYku6BiwDXyuC7J/mQeZVe5QE8="
    crossorigin="anonymous"></script>
  <script src="<?= $url . 'js/jquery-keyframes.js' ?>"></script>
  <script src="<?= $url . 'js/alb-public.js' ?>"></script>
</head>
<body>

<div id="header">
  <p class="header_title"><?php _e('NEWS FROM THE KITCHEN', 'alb'); ?></p>
</div>

<div id="news_wrapper" class="jcarousel">
  <ul>

<?php

$options = get_option( 'alb_settings' );

$args = array(
  'post_type'  => 'news',
  'post_status' => 'publish',
  'numberposts' => -1,
  'meta_key' => 'news_date',
  'orderby'   => 'meta_value_num',
  'order'      => 'ASC',
  'meta_query' => array(
    'relation' => 'AND',
    array(
      'key'     => 'news_start_display',
      'value'   => time(),
      'compare' => '<=',
    ),
    array(
      'key'     => 'news_end_display',
      'value'   => time(),
      'compare' => '>=',
    ),
  ),
);

$news = get_posts($args);

if ( count( $news ) > 0 ) {
  foreach ($news as $index => $pon) {
    $meta = get_post_meta( $pon->ID );
    $news_name = ! isset( $pon->post_title ) ? '' : $pon->post_title;
    $content = get_post_field( 'post_content', $pon->ID );

    $news_date = ! isset( $meta['news_date'][0] ) ? ' - ' : date_i18n( get_option( 'date_format' ), $meta['news_date'][0] );;

    ?>

    <li>
      <div class="news_item">
        <div class="news_pic">
          <?= get_the_post_thumbnail( $pon->ID, array(497,311) ); ?>
        </div>
        <div class="news_name">
          <?= $news_name ?>
        </div>
        <div class="news_date">
          <?= $news_date; ?>
        </div>
        <div class="news_text">
          <p><?= $content ?></p>
        </div>
      </div>
    </li>

    <?php
    }
  }

?>
  </ul>
</div><!--#event_wrapper-->

<div id="alb_logo_footer"></div>

</body>
</html>