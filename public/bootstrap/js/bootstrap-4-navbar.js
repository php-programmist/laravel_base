/*!
 * Bootstrap 4 multi dropdown navbar ( https://bootstrapthemes.co/demo/resource/bootstrap-4-multi-dropdown-navbar/ )
 * Copyright 2017.
 * Licensed under the GPL license
 */


$(document).ready(function () {
	var pathPage = location.pathname.slice(1);
	
	var parentUl = $('.nav-item a[href*="' + pathPage + '"]').closest('li').addClass('active').parent('ul');
	var grandParentUl = parentUl.parent('.navbar-nav li').addClass('active').parent('ul');
	grandParentUl.parent('.navbar-nav li').addClass('active').parent('ul');
	
	if (!is_touch_device()) {
		$('.dropdown-toggle').on('click', function (e) {
			if ($(this).next('.dropdown-menu').is(':visible')) {
				window.location = $(this).attr('href');
			}
		});
	}
	else {
		$('.dropdown-menu').css('paddingLeft', '1em');
		$('.dropdown-toggle')
			.each(function (o) {
				var link = $(this).attr('href');
				if (link && link != '#') {
					$(this).next(".dropdown-menu").addClass('show');
				}
			})
			.on('click', function (e) {
				var link = $(this).attr('href');
				if (link && link != '#') {
				window.location = $(this).attr('href');
			}
		});
	}
	
	$('.dropdown-menu a.dropdown-toggle').on('click', function (e) {
		var $el = $(this);
		var $parent = $(this).offsetParent(".dropdown-menu");
		if (!$(this).next().hasClass('show')) {
			$(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
		}
		var $subMenu = $(this).next(".dropdown-menu");
		$subMenu.toggleClass('show');
		
		$(this).parent("li").toggleClass('show');
		
		$(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function (e) {
			$('.dropdown-menu .show').removeClass("show");
		});
		
		if (!$parent.parent().hasClass('navbar-nav')) {
			$el.next().css({"top": $el[0].offsetTop, "left": $parent.outerWidth() - 4});
		}
		
		return false;
	});
	
	
});

function is_touch_device() {
	return (('ontouchstart' in window)
		|| (navigator.MaxTouchPoints > 0)
		|| (navigator.msMaxTouchPoints > 0));
}
