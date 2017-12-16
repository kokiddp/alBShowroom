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


	$(document).ready(function() {

		if (window.location.href.indexOf("taplist") > -1) {

	       var supportedFlag = $.keyframe.isSupported();

			var scrolling_p = $(".marquee > p");

			$.each(scrolling_p, function(index, value) {

				if ($(this).outerWidth(true) > $(this).parent().outerWidth(true)) {

					var start = 100 / $(this).outerWidth(true) * $(this).parent().outerWidth(true);
					var speed = $(this).outerWidth(true) / $(this).parent().outerWidth(true) * 7;
					$.keyframe.define([{
					    name: 'albmarquee-' + index,
					    '0%': {'transform': 'translate3d(' + start + '%, 0, 0)'},
					    '100%': {'transform': 'translate3d(-100%, 0, 0)'}
					}]);
					$(this).css('text-align', 'center').css('animation', 'albmarquee-' + index + ' ' + speed + 's linear infinite');
					$(this).parent().css('overflow', 'hidden');
				}

			});
	    }
		
	});

})( jQuery );
