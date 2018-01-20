(($) => {
	'use strict';

	var TW;

	window.TW = {
		init   : () => {

		},
		resize : () => {

		},
		onReady: () => {
			window.TW.widgets.init();
		},
		widgets: {
			init  : () => {
				window.TW.widgets.load();
				setInterval(window.TW.widgets.update, 60000);
			},
			update: () => {
				window.TW.widgets.load();
			},
			load  : () => {
				var req = $.get(
					restapi.sites_stats_api_endpoint
				).done(function (data) {
					window.TW.widgets.plot(data);
				}).fail(function () {
					console.log("error");
				});
			},
			plot  : (data) => {
				var html_output = '';

				html_output += '<table>';
				for (var i = 0; i < data.length; i++) {
					var row = data[i];

					html_output += '<tr><td colspan="2"><b>' + row.site.blogname + '</b></td></tr>';

					if(row.is_multisite == 1){
						html_output += '<tr><td >Site url</td><td><a href="' + row.site.home + '">visit the site</a></td></tr>';
					}

					html_output += '<tr><td >Published posts count</td><td>' + row.posts_count.publish + '</td></tr>';
					html_output += '<tr><td >Published pages count</td><td>' + row.pages_count.publish + '</td></tr>';

					html_output += '<tr><td >Users count</td><td>' + row.pages_count.publish + '</td></tr>';
				}
				html_output += '</table>';

				$(".js-the_stats_widget_widget").html(html_output);
			}
		}
	}

	TW = window.TW;

	TW.init();

	$(window).resize(() => {
		let TW = window.TW;
		TW.resize();
	});

	$(document).ready(() => {
		let TW = window.TW;
		TW.onReady();
	});

})(jQuery);
