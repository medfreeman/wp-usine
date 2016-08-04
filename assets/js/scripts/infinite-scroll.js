/* global urls */
/* eslint no-console: 0 */
import queryString from 'query-string';
import 'jquery-ias';
import IASNoneLeftExtension from 'exports?IASNoneLeftExtension!jquery-ias/src/extension/noneleft';
import IASSpinnerExtension from 'exports?IASSpinnerExtension!jquery-ias/src/extension/spinner';
import Spinner from 'spin.js';

$(() => {
	const opts = {
		lines: 7, // The number of lines to draw
		length: 18, // The length of each line
		width: 24, // The line thickness
		radius: 35, // The radius of the inner circle
		scale: 0.2, // Scales overall size of the spinner
		corners: 1, // Corner roundness (0..1)
		color: '#000', // #rgb or #rrggbb or array of colors
		opacity: 0.2, // Opacity of the lines
		rotate: 4, // The rotation offset
		direction: 1, // 1: clockwise, -1: counterclockwise
		speed: 0.8, // Rounds per second
		trail: 40, // Afterglow percentage
		fps: 20, // Frames per second when using setTimeout() as a fallback for CSS
		zIndex: 2e9, // The z-index (defaults to 2000000000)
		className: 'spinner', // The CSS class to assign to the spinner
		shadow: false, // Whether to render a shadow
		hwaccel: true, // Whether to use hardware acceleration
		position: 'relative' // Element positioning
	};

	const ias = jQuery.ias({
		container: '.content__container',
		item: 'article',
		pagination: '.pagination__list',
		next: '.pagination__item.next .pagination__link'
	});

	// Add a loader image which is displayed during loading
	ias.extension(new IASSpinnerExtension({
		html: '<div class="loading--infinite" alt="Loading..." style="text-align: center;"></div>'
	}));

	// Add a text when there are no more pages left to load
	ias.extension(new IASNoneLeftExtension({ text: 'You reached the end' }));

	ias.on('load', (event) => {
		new Spinner(opts).spin($('.loading--infinite')[0]);
		console.log(event.url);
		const data = {
			action: 'test',
			page: 1
		};
		const query = queryString.stringify(data);
		console.log(`${urls.ajax}?${query}`);
	});

	ias.on('loaded', (data, items) => {
		$('.loading--infinite').stop();
		const $items = $(items);
		console.log(`Loaded ${$items.length} items from server`);
	});
});
