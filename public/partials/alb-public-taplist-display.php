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
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<?php

$options = get_option( 'alb_settings' );
$post_ids = array();
foreach ($options as $key => $value) {
	array_push( $post_ids, $value );
}

$tap_beers = get_posts([
 	'post_type' => 'tap_beer',
	'post_status' => 'publish',
 	'numberposts' => -1,
	'order'    => 'ASC',
	'post__in' => $post_ids
]);

if ( count( $tap_beers ) > 0 ) {
	foreach ($tap_beers as $index => $beer) {
		echo $beer->post_title . '<br />';
	}
}

?>