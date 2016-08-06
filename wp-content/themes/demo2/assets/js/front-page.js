$(function() {
	var $publicationCarousel = $('#js-publication-carousel'),
		$accessCarousel = $('#js-access-carousel'),
		refW = 118,
		refH = 175;

	// $(window).load(function() {
	// 	$publicationCarousel.find('.publication').each(function(index, el) {
	// 		var $el = $(el),
	// 			elHeight = $el.height(),
	// 			imgHeight = $el.find('.publication-img').height(),
	// 			pTop = (elHeight - imgHeight) / 2;
	// 		console.log('elHeight : ' + elHeight);
	// 		console.log('imgHeight : ' + imgHeight);
	// 		$el.css('padding-top', pTop);
	// 	});
	// });
	function coverFlowSlider() {
		if ($(window).width() > 1199) {
			$publicationCarousel.addClass('owl-carousel-coverflow');
			var $activeItem = $publicationCarousel.find('.owl-item.active'),
				activeLength = $activeItem.length;

			$publicationCarousel.find('.owl-item').removeClass('main-active');
			if (activeLength == 3) {
				$activeItem.eq(1).addClass('main-active');
			} else if (activeLength == 1) {
				$activeItem.addClass('main-active');
			}
		} else {
			$publicationCarousel.removeClass('owl-carousel-coverflow');
		}
	}
	$publicationCarousel.owlCarousel({
		autoplaySpeed: 750,
		dotsSpeed: 300,
		autoplay: false,
		dots: true,
		nav: false,
		navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
		items: 1,
		dotsEach: 1,
		loop: true,
		responsive: {
			530 : {
				items: 1,
				dots: true,
				nav: true,
			},
			800 : {
				items: 4,
				dots: false,
				nav: true,
			},
			1200 : {
				items: 3,
				dots: false,
				nav: true,
			}
		},
		onChanged : function (event) {
			coverFlowSlider();
		},
		onResized : function (event) {
			coverFlowSlider();
		}
	});

	$accessCarousel.owlCarousel({
		autoplaySpeed: 750,
		dotsSpeed: 300,
		autoplay: false,
		dots: true,
		nav: false,
		navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
		items: 2,
		dotsEach: 1,
		loop: true,
		responsive: {
			530 : {
				items: 3,
				dots: true,
				nav: true,
			},
			800 : {
				items: 3,
				dots: false,
				nav: true,
			},
			1200 : {
				items: 6,
				dots: false,
				nav: true,
			}
		},
	});
});