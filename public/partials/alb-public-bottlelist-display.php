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

$bottled_beers = get_posts([
 	'post_type' => 'bottled_beer',
	'post_status' => 'publish',
 	'numberposts' => -1
]);

if ( count( $bottled_beers ) > 0 ) {
	foreach ($bottled_beers as $index => $beer) {
		echo $beer->post_title . '<br />';
	}
}

?>