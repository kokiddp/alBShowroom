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

		if (window.location.href.indexOf("taplist") > -1 || window.location.href.indexOf("bottlelist") > -1) {

	        var supportedFlag = $.keyframe.isSupported();

			var scrolling_p = $(".marquee > p");

			$.each(scrolling_p, function(index, value) {

				if ($(this).outerWidth(true) > $(this).parent().outerWidth(true)) {

					var start = 100 / $(this).outerWidth(true) * $(this).parent().outerWidth(true);
					var speed = $(this).outerWidth(true) / $(this).parent().outerWidth(true) * 10;
					$.keyframe.define([{
					    name: 'albmarquee-' + index,
					    '0%': {'transform': 'translate3d(' + start + '%, 0, 0)'},
					    '100%': {'transform': 'translate3d(-100%, 0, 0)'}
					}]);
					$(this).css('text-align', 'center').css('animation', 'albmarquee-' + index + ' ' + speed + 's linear infinite');
					$(this).parent().css('overflow', 'hidden');
				}

			});

			if (window.location.href.indexOf("bottlelist") > -1) {
				$('.jcarousel').jcarousel({
			        wrap: 'circular',
			        vertical: 'true',
			        animation: {
				        duration: 800,
				        easing:   'linear'
				    }
			    })
			    .jcarouselAutoscroll({
		            interval: 5000,
		            target: '+=1',
		            autostart: true
		        });
			}
	    }
	    else if (window.location.href.indexOf("events") > -1) {
	    	$('.jcarousel').jcarousel({
		        wrap: 'circular',
		        animation: {
			        duration: 800,
			        easing:   'linear'
			    }
		    })
		    .jcarouselAutoscroll({
	            interval: 8000,
	            target: '+=1',
	            autostart: true
	        });

	        var supportedFlag = $.keyframe.isSupported();

			var scrolling_p = $(".event_text > p");

			$.each(scrolling_p, function(index, value) {

				if ($(this).outerHeight(true) > $(this).parent().outerHeight(true)) {

					var start = 100 / $(this).outerHeight(true) * $(this).parent().outerHeight(true);
					var speed = $(this).outerHeight(true) / $(this).parent().outerHeight(true) * 7;
					$.keyframe.define([{
					    name: 'albevent-' + index,
					    '0%': {'transform': 'translate3d(0, ' + start + '%, 0)'},
					    '100%': {'transform': 'translate3d(0, -100%, 0)'}
					}]);
					$(this).css('animation', 'albevent-' + index + ' ' + speed + 's linear infinite');
					$(this).parent().css('overflow', 'hidden');
				}

			});
	    }
	    else if (window.location.href.indexOf("news") > -1) {
	    	$('.jcarousel').jcarousel({
		        wrap: 'circular',
		        animation: {
			        duration: 800,
			        easing:   'linear'
			    }
		    })
		    .jcarouselAutoscroll({
	            interval: 8000,
	            target: '+=1',
	            autostart: true
	        });

	        var supportedFlag = $.keyframe.isSupported();

			var scrolling_p = $(".news_text > p");

			$.each(scrolling_p, function(index, value) {

				if ($(this).outerHeight(true) > $(this).parent().outerHeight(true)) {

					var start = 100 / $(this).outerHeight(true) * $(this).parent().outerHeight(true);
					var speed = $(this).outerHeight(true) / $(this).parent().outerHeight(true) * 7;
					$.keyframe.define([{
					    name: 'albnews-' + index,
					    '0%': {'transform': 'translate3d(0, ' + start + '%, 0)'},
					    '100%': {'transform': 'translate3d(0, -100%, 0)'}
					}]);
					$(this).css('animation', 'albnews-' + index + ' ' + speed + 's linear infinite');
					$(this).parent().css('overflow', 'hidden');
				}

			});
	    }
		
	});

})( jQuery );
