$(() => {
	$('.link__location').addClass('cursor-pointer');
	$('.link__location').on('click', (event) => {
		window.location.href = $(event.target).data('href');
	});
});
