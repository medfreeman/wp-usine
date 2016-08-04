/* global vox */
import 'jquery-colorbox';
import 'jquery-colorbox/i18n/jquery.colorbox-fr.js';
import 'jquery-colorbox/example4/colorbox.css';
import enquire from 'exports?enquire!enquire';

$(() => {
	// Executes in MD and LG breakpoints
	enquire.register('only screen and (min-width: 992px)', {
		match: () => {
			$('.vox__link').each(function eachLink() {
				const $this = $(this);
				const url = $this.attr('href').replace(/\/?(\?|#|$)/, '/$1');
				const title = $this.attr('title');
				const html = `<span id="cboxTitleLeft">${title}</span> | `
								+ '<span id="cboxDownload">'
								+ `<a href="${url}" title="${vox.downloadTitle}">`
								+ `<strong>${vox.downloadText}</strong></a>`
								+ '</span>';
				$this.colorbox(
					{
						href: `${url}cover`,
						photo: true,
						fixed: true,
						preloading: true,
						loop: false,
						maxWidth: '100%',
						maxHeight: '100%',
						current: vox.currentItemText,
						previous: vox.previousText,
						next: vox.nextText,
						title: () => html
					}
				);
			});
		},
		unmatch: () => {
			$.colorbox.remove();
		}
	});
});
