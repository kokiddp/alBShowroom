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

  <title><?php _e('Tap List', 'alb'); ?></title>

  <link rel="stylesheet" href="<?= $url . 'css/alb-public.css' ?>">

  <script
  	src="https://code.jquery.com/jquery-3.2.1.min.js"
  	integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  	crossorigin="anonymous"></script>
  <script src="<?= $url . 'js/jquery-keyframes.js' ?>"></script>
  <script src="<?= $url . 'js/alb-public.js' ?>"></script>
</head>
<body>

<div id="header">
	<div id="header_taplist_logo"></div>
	<div id="alb_logo"></div>
</div>

<?php

$options = get_option( 'alb_settings' );
$post_ids = array();
foreach ($options as $key => $value) {
	array_push( $post_ids, (int)$value );
}

$tap_beers = get_posts([
 	'post_type' => 'tap_beer',
	'post_status' => 'publish',
 	'numberposts' => 12,
	'post__in' => $post_ids,
	'orderby' => 'post__in'
]);

if ( count( $tap_beers ) > 0 ) {
	foreach ($tap_beers as $index => $beer) {
		$meta = get_post_meta( $beer->ID );
		$content = get_post_field( 'post_content', $beer->ID );
		$categories = get_the_terms( $beer->ID, 'beer_category' );
		$beer_name = ! isset( $beer->post_title ) ? '' : $beer->post_title;
		$beer_category = count( $categories ) == 0 ? '' : $categories[0]->name;

		$beer_brew_name = ! isset( $meta['beer_brew_name'][0] ) ? '' : $meta['beer_brew_name'][0];
		$beer_brew_add = ! isset( $meta['beer_brew_add'][0] ) ? '' : $meta['beer_brew_add'][0];		

		$beer_abv = ! isset( $meta['beer_abv'][0] ) ? '' : $meta['beer_abv'][0];
		$beer_ibu = ! isset( $meta['beer_ibu'][0] ) ? '' : $meta['beer_ibu'][0];

		$beer_og = ! isset( $meta['beer_og'][0] ) ? '' : $meta['beer_og'][0];
		$beer_fg = ! isset( $meta['beer_fg'][0] ) ? '' : $meta['beer_fg'][0];
		$beer_color = ! isset( $meta['beer_color'][0] ) ? '' : $meta['beer_color'][0];
		$beer_grains = ! isset( $meta['beer_grains'][0] ) ? '' : $meta['beer_grains'][0];
		$beer_yeast = ! isset( $meta['beer_yeast'][0] ) ? '' : $meta['beer_yeast'][0];
		$beer_hops = ! isset( $meta['beer_hops'][0] ) ? '' : $meta['beer_hops'][0];
		$beer_plato = ! isset( $meta['beer_plato'][0] ) ? '' : $meta['beer_plato'][0];
		$beer_servt = ! isset( $meta['beer_servt'][0] ) ? '' : $meta['beer_servt'][0];
		$beer_pair = ! isset( $meta['beer_pair'][0] ) ? '' : $meta['beer_pair'][0];

		$beer_description = 
			( empty( $beer_og ) ? '' : ( __('Original gravity: ', 'alb') . $beer_og . ( empty( $beer_fg ) && empty( $beer_color ) && empty( $beer_grains ) && empty( $beer_yeast ) && empty( $beer_hops ) && empty( $beer_plato ) && empty( $beer_servt ) && empty( $beer_pair ) &&  empty( $content ) ? '' : ' - ' ) ) ) .
			( empty( $beer_fg ) ? '' : ( __('Final gravity: ', 'alb') . $beer_fg . ( empty( $beer_color ) && empty( $beer_grains ) && empty( $beer_yeast ) && empty( $beer_hops ) && empty( $beer_plato ) && empty( $beer_servt ) && empty( $beer_pair ) &&  empty( $content ) ? '' : ' - ' ) ) ) .
			( empty( $beer_color ) ? '' : ( __('Color: ', 'alb') . $beer_color . ( empty( $beer_grains ) && empty( $beer_yeast ) && empty( $beer_hops ) && empty( $beer_plato ) && empty( $beer_servt ) && empty( $beer_pair ) &&  empty( $content ) ? '' : ' - ' ) ) ) .
			( empty( $beer_grains ) ? '' : ( __('Grains: ', 'alb') . $beer_grains . ( empty( $beer_yeast ) && empty( $beer_hops ) && empty( $beer_plato ) && empty( $beer_servt ) && empty( $beer_pair ) &&  empty( $content ) ? '' : ' - ' ) ) ) .
			( empty( $beer_yeast ) ? '' : ( __('Yeast: ', 'alb') . $beer_yeast . ( empty( $beer_hops ) && empty( $beer_plato ) && empty( $beer_servt ) && empty( $beer_pair ) &&  empty( $content ) ? '' : ' - ' ) ) ) .
			( empty( $beer_hops ) ? '' : ( __('Hops: ', 'alb') . $beer_hops . ( empty( $beer_plato ) && empty( $beer_servt ) && empty( $beer_pair ) &&  empty( $content ) ? '' : ' - ' ) ) ) .
			( empty( $beer_plato ) ? '' : ( __('Plato degrees: ', 'alb') . $beer_plato . ( empty( $beer_servt ) && empty( $beer_pair ) &&  empty( $content ) ? '' : ' - ' ) ) ) .
			( empty( $beer_servt ) ? '' : ( __('Serving temperature: ', 'alb') . $beer_servt . ( empty( $beer_pair ) &&  empty( $content ) ? '' : ' - ' ) ) ) .
			( empty( $beer_pair ) ? '' : ( __('Pairings: ', 'alb') . $beer_pair . ( empty( $content ) ? '' : ' - ' ) ) ) .
			( empty( $content ) ? '' : $content );

		$beer_sizes = ! isset( $meta['beer_sizes'][0] ) ? '' : $meta['beer_sizes'][0];
		$beer_prices = ! isset( $meta['beer_prices'][0] ) ? '' : $meta['beer_prices'][0];
		$beer_sizem = ! isset( $meta['beer_sizem'][0] ) ? '' : $meta['beer_sizem'][0];
		$beer_pricem = ! isset( $meta['beer_pricem'][0] ) ? '' : $meta['beer_pricem'][0];
		?>
		<div class="tapentry">
		  	<div class="tapentry-row">
		    	<div class="tap-number">
		      		<p>
		        		<?php 
		        		if ($index < 10) {
		        			echo $index + 1;
		        		}
		        		elseif ($index == 10) {
		        			echo 'P1';
		        		}
		        		elseif ($index == 11) {
		        			echo 'P2';
		        		}
		        		else {
		        			echo '#';
		        		}
		        		?>
		      		</p>      
		    	</div>
		    	<div class="tap-icon">
		      		<?= get_the_post_thumbnail( $beer->ID, array(60,60) ); ?>
		    	</div>
		    	<div class="tap-name marquee">
		      		<p><?= $beer_name; ?></p>      
		    	</div>
		    	<div class="tap-brewery">
		      		<div class="tap-subbrewery">
		        		<div class="tap-subbrewery-row1">
		          			<div class="tap-subbrewery-row1-cell">
		            			<div class="tap-subbrewery-row1-table">
		              				<div class="tap-subbrewery-row1-row">
		                				<div class="tap-brewery-name marquee">
		                  					<p><?= $beer_brew_name; ?></p>
		                				</div>
		              				</div>
		            			</div>
		          			</div>
		        		</div>
		        		<div class="tap-subbrewery-row2">
		          			<div class="tap-subbrewery-row2-cell">
		            			<div class="tap-subbrewery-row2-table">
		              				<div class="tap-subbrewery-row2-row">
		                				<div class="tap-brewery-address marquee">
		                  					<p><?= $beer_brew_add; ?></p>                  
		                				</div>
		              				</div>
		            			</div>
		          			</div>
		        		</div>
		      		</div>  
		    	</div>
		    	<div class="tap-meta">
		      		<div class="tap-submeta">
		        		<div class="tap-submeta-row1">
		          			<div class="tap-submeta-row1-cell">
		            			<div class="tap-submeta-row1-table">
		              				<div class="tap-submeta-row1-row">
		                				<div class="tap-style marquee">
		                  					<p><?= $beer_category; ?></p>
		                				</div>
		                				<div class="tap-abv">
		                  					<p><span class='apex'><?php _e('ABV', 'alb'); ?></span> <?= $beer_abv; ?></p>                  
		                				</div>
		                				<div class="tap-ibu">
		                  					<p><span class='apex'><?php _e('IBU', 'alb'); ?></span> <?= $beer_ibu; ?></p>                  
		                				</div>
		              				</div>
		            			</div>
		          			</div>
		        		</div>
		        		<div class="tap-submeta-row2">
		          			<div class="tap-submeta-row2-cell">
		            			<div class="tap-submeta-row2-table">
		             				<div class="tap-submeta-row2-row">
		                				<div class="tap-description marquee">
		                  					<p><?= $beer_description; ?></p>                  
		                				</div>
		              				</div>
		            			</div>
		          			</div>
		        		</div>
		      		</div>
		    	</div>
		    	<div class="tap-prices">
		      		<p><span class='apex'><?= $beer_sizes; ?></span> <?= $beer_prices; ?><?php if ( !empty( $beer_prices ) && $beer_prices != '' ) { echo ' €'; } ?></p>      
		    	</div>
		    	<div class="tap-pricem">
		      		<p><span class='apex'><?= $beer_sizem; ?></span> <?= $beer_pricem; ?><?php if ( !empty( $beer_pricem ) && $beer_pricem != '' ) { echo ' €'; } ?></p>      
		    	</div>
		  	</div>
		</div>
		<?php
	}
}

?>
</body>
</html>