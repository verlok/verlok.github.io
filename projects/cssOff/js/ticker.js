(function($) {

	$.ticker = function(element, options) {

		var defaults = {
			startValue: 59,
			valueSelector: '.value',
			bgImage: '.bg',
			restartAfter: 3,
			imageFontRatio: 0.43,
			vibrationInterval: 10,
			vibrationShake: 5
		};

		var plugin = this;

		plugin.settings = {};

		var $element = $(element);

		plugin.init = function() {
			plugin.settings = $.extend({}, defaults, options); // Settings extension
			plugin.pauseTime = plugin.settings.restartAfter;
			plugin.$value = $element.find(plugin.settings.valueSelector);
			plugin.$bgImage = $element.find(plugin.settings.bgImage);
			plugin.seconds = plugin.settings.startValue;
			plugin.prevBoxHeight = 0;
			plugin.vibrating = false;

			// Initial set of font size: cover both cases
			plugin.$bgImage.bind('load', function() {
				// may not happen in image already loaded
				plugin.updateFontSize(); 
			});
			//may happen before image is loaded
			plugin.updateFontSize(); 

			// First print of seconds
			printSeconds();
	
			// Tick
			plugin.tickIndex = setInterval(function(){
				if (plugin.seconds === 0) {
					plugin.pauseTime--;
					if (plugin.pauseTime === 0) {
						plugin.seconds = plugin.settings.startValue;
						plugin.pauseTime = plugin.settings.restartAfter;
						stopVibration();
					}
				} else {
					plugin.seconds--;
					if (plugin.seconds===0) {
					   startVibration();
					}
				}
				// More print of secs
				printSeconds();
			}, 1000);

		};

		plugin.updateFontSize = function() {
			var boxHeight = plugin.$bgImage.height();
			if (plugin.prevBoxHeight !== boxHeight) {
				plugin.prevBoxHeight = boxHeight;
				var fontSize = Math.round(boxHeight*plugin.settings.imageFontRatio);
				plugin.$value.css('fontSize', fontSize+'px');
			}
		};

		var printSeconds = function() {
			if (plugin.seconds < 10) {
				plugin.$value.html('0'+plugin.seconds);
			} else {
				plugin.$value.html(plugin.seconds);
			}
		};
		
		var startVibration = function() {
			var left, top;
			if (!plugin.vibrating) {
				left = $element.css('left');
				top = $element.css('top');
				plugin.vibrateInitialPosition = {left: left, top: top};
				plugin.vibrateIndex = setInterval(vibrate, plugin.settings.vibrationInterval);
				plugin.vibrating = true;
			}
		};

		var stopVibration = function() {
			if (plugin.vibrating) {
				clearInterval(plugin.vibrateIndex);
				$element.css(plugin.vibrateInitialPosition);
				plugin.vibrating = false;
			}
		};

		var vibrate = function(){
			var shake = plugin.settings.vibrationShake;
			var left = Math.round(Math.random() * shake) - ((shake + 1) / 2),
				top = Math.round(Math.random() * shake) - ((shake + 1) / 2);
			$element.css({
				position: 'relative', 
				left: left+'px', 
				top: top+'px'}
			);
		};

		plugin.init();

	};

	$.fn.ticker = function(options) {

		return this.each(function() {
			if (typeof($(this).data('ticker'))==='undefined') {
				var plugin = new $.ticker(this, options);
				$(this).data('ticker', plugin);
			}
		});

	};

})(jQuery);