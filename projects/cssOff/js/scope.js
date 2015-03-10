// Avoid accidentally forgot console.log break js on IE<9
if (typeof(console) === 'undefined') {
    console = {log: function() {return false; }};
}

$(document).ready(function(){

	/* Form validation */
	
	$("#subscribtion").validate();

	/* Obstacles click manager */

	var $buttons = $('#obstacles li');
	$buttons.bind('click', function(evt){
		$buttons.removeClass('selected');
		$(this).addClass('selected');
	});

	/* Prizes animation manager */

	var $prizes = $('#prizes li');
	$prizes.bind('mouseover', function(evt){
		$(this).addClass('animate');
	});
	$prizes.bind('mouseout', function(evt){
		$prizes.removeClass('animate');
	});
	$prizes.bind('click', function(evt){
		$prizes.removeClass('animate');
		$(this).addClass('animate');
	});

	/* Time ticker manager */
	var $alarmClock = $('#alarmClock');
	$alarmClock.ticker();

	/* Smooth scroll */
	$('html').smoothScroll();

	/* Graphic select field */
	$("select").selectBox({menuTransition: 'slide', menuSpeed: 'fast'});

	/* Things to do on resize */
	$(window).bind('resize', function() {
		$alarmClock.data('ticker').updateFontSize();
	});

	/* Add title attribute, used for CSS2 content-generated text-shadow */
	if (!Modernizr.textshadow) {
		var $elementsWithShadow = $('#siteHeader .payoff, #obstacles h1, #prizes h1, #beAContestant h1');
		$elementsWithShadow.each(function() {
			var $this = $(this);
			$this.attr('title', $this.text());
		});
	}

	/* Insertion of corners in buttons, for browser without border-radius */
	if (!Modernizr.borderradius) {
		// Bad to see, but this is the most js-performant way to do such a dom insertion
		$('#obstacles .button').prepend('<span class="rc tl"></span><span class="rc tr"></span><span class="rc br"></span><span class="rc bl"></span>');
	}

	// If user's browser supports css animations, load the animations stylesheet, 
	// otherwise load the fallback with the defaults
	Modernizr.load({
		test: Modernizr.cssanimations,
		yep: 'css/animations.css'
	});

});