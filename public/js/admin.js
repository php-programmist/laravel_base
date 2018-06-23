function submit_button(task) {
	$("#task").val(task);
	$("#adminForm").submit();
}

function onNavbar() {
	if (window.innerWidth >= 768) {
		$('.dropdown').on('mouseover', function () {
			$('.dropdown-toggle', this).next('.dropdown-menu').show();
		}).on('mouseout', function () {
			$('.dropdown-toggle', this).next('.dropdown-menu').hide();
		});
		$('.dropdown-toggle').click(function () {
			if ($(this).next('.dropdown-menu').is(':visible')) {
				window.location = $(this).attr('href');
			}
		});
	} else {
		$('.dropdown').off('mouseover').off('mouseout');
	}
}

$(window).resize(function () {
	onNavbar();
});
onNavbar();
