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

  <title><?php _e('Events', 'alb'); ?></title>

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
  <p class="header_title"><?php _e('INCOMING EVENTS', 'alb'); ?></p>
</div>

<div id="event_wrapper" class="jcarousel">
  <ul>

<?php

$options = get_option( 'alb_settings' );

$args = array(
  'post_type'  => 'event',
  'post_status' => 'publish',
  'numberposts' => -1,
  'meta_key' => 'event_start_date',
  'orderby'   => 'meta_value_num',
  'order'      => 'ASC',
  'meta_query' => array(
    'relation' => 'AND',
    array(
      'key'     => 'event_start_display',
      'value'   => time(),
      'compare' => '<=',
    ),
    array(
      'key'     => 'event_end_display',
      'value'   => time(),
      'compare' => '>=',
    ),
  ),
);

$events = get_posts($args);

if ( count( $events ) > 0 ) {
  foreach ($events as $index => $event) {
    $meta = get_post_meta( $event->ID );
    $event_name = ! isset( $event->post_title ) ? '' : $event->post_title;
    $content = get_post_field( 'post_content', $event->ID );

    $event_start_date = ! isset( $meta['event_start_date'][0] ) ? ' - ' : date_i18n( get_option( 'date_format' ), $meta['event_start_date'][0] );;
    $event_end_date = ! isset( $meta['event_end_date'][0] ) ? ' - ' : date_i18n( get_option( 'date_format' ), $meta['event_end_date'][0] );

    ?>

    <li>
      <div class="event_item">
        <div class="event_pic">
          <?= get_the_post_thumbnail( $event->ID, array(497,311) ); ?>
        </div>
        <div class="event_name">
          <?= $event_name ?>
        </div>
        <div class="event_dates">
          <?php
            if ($event_start_date != $event_end_date) {
              echo __('From ', 'alb') . $event_start_date . __(' to ', 'alb') . $event_end_date;
            }
            else {
              echo __('The ', 'alb') . $event_start_date;
            }            
          ?>
        </div>
        <div class="event_text">
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