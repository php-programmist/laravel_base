jQuery(document).ready(function ($) {
	
	$('.commentlist li').each(function (i) {
		
		$(this).find('div.commentNumber').text('#' + (i + 1));
		
	});
	
	$('#commentform').on('click', '#submit', function (e) {
		
		e.preventDefault();
		
		var comParent = $(this);
		
		$('.wrap_result').css('color', 'green').text('Сохранение комментария').fadeIn(500, function () {
			
			var data = $('#commentform').serializeArray();
			
			$.ajax({
				
				url: $('#commentform').attr('action'),
				data: data,
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				type: 'POST',
				datatype: 'JSON',
				success: function (html) {
					if (html.status == 'error') {
						$('.wrap_result')
							.css('color', 'red')
							.html('<strong>Ошибки:</strong><br />' + html.error.join('<br />'))
							.delay(5000).fadeOut(500);
					}
					else if (html.status == 'success') {
						$('.wrap_result')
							.append('<br /><strong>Сохранено!</strong>')
							.delay(2000)
							.fadeOut(500, function () {
								if (html.data.parent_id > 0) {
									comParent.parents('div#respond').prev().after('<ul class="children">' + html.comment + '</ul>');
								}
								else {
									if ($.contains('#comments', 'ol.commentlist')) {
										$('ol.commentlist').append(html.comment);
									}
									else {
										
										$('#respond').before('<ol class="commentlist group">' + html.comment + '</ol>');
										
									}
								}
								$('#cancel-comment-reply-link').click();
								$('#text').val('');
							})
						
					}
					else if (html.status == 'moderate') {
						$('.wrap_result')
							.html(html.msg)
							.delay(5000)
							.fadeOut(500, function () {
								$('#cancel-comment-reply-link').click();
								$('#text').val('');
							})
						
					}
				},
				error: function () {
					$('.wrap_result').css('color', 'red').html('<strond>Ошибка! </strong>');
					$('.wrap_result').delay(2000).fadeOut(500, function () {
						$('#cancel-comment-reply-link').click();
					});
				}
				
			});
		});
		
	});
	
});