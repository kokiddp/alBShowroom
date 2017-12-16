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
  <script src="<?= $url . 'js/alb-public.js' ?>"></script>
</head>
<body>

<div id="header">
  <div id="header_events_logo"></div>
  <div id="alb_logo"></div>
</div>

<?php

$args = array(
  'post_type'  => 'event',
  'post_status' => 'publish',
  'numberposts' => -1,
  'meta_query' => array(
    'relation' => 'OR',
    array(
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
  ),
);

$options = get_option( 'alb_settings' );

$events = get_posts($args);

var_dump($events);
?>

</body>
</html>