(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */


	var name_div = jQuery('.tap-name');
	var name_p = jQuery('.tap-name > p');
	var brewery_div = jQuery('.tap-brewery-name');
	var brewery_p = jQuery('.tap-brewery-name > p');
	var address_div = jQuery('.tap-brewery-address');
	var address_p = jQuery('.tap-brewery-address > p');
	var style_div = jQuery('.tap-style');
	var style_p = jQuery('.tap-style > p');
	var description_div = jQuery('.tap-description');
	var description_p = jQuery('.tap-description > p');

	console.log(description_p.text().length);
	console.log(description_div.width());

	if (name_p.text().length / name_div.width() > 0.25 ) {
		name_div.addClass('marquee');
	}
	if (brewery_p.text().length / brewery_div.width() > 0.25 ) {
		brewery_div.addClass('marquee');
	}
	if (address_p.text().length / address_div.width() > 0.25 ) {
	    address_div.addClass('marquee');
	}
	if (style_p.text().length / style_div.width() > 0.25 ) {
	    style_div.addClass('marquee');
	}
	if (description_p.text().length / description_div.width() > 0.25 ) {
	    description_div.addClass('marquee');
	}

})( jQuery );
