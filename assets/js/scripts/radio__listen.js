$(() => {
	$('.radio__listen').on('click', (event) => {
		window.open('http://static.infomaniak.ch/infomaniak/radio/html/radiousine_player.html', 'Live', 'scrollbars=no,width=468,height=100');
		event.preventDefault();
		return false;
	});
});
