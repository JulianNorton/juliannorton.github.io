$('a[href*=#]:not([href=#])').click(function() {
	if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {

		var target = $(this.hash);
		target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
		if (target.length) {
			$('html,body').animate({
				scrollTop: target.offset().top
			}, 750, 'easeInOutCubic');
			return false;
		}
	}
});

$(document).ready(function() {
		$('.gallery').each(function() { // the containers for all your galleries
			$(this).magnificPopup({
			delegate: 'a', // the selector for gallery item
			type: 'image',
			preload: [0,1], // read about this option in next Lazy-loading section
			delegate: 'a', // child items selector, by clicking on it popup will open
			type: 'image',
			gallery: {
				enabled:true
			},
			removalDelay: 300,
			mainClass: 'mfp-fade'
		});
		}); 

	});