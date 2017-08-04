/**
 * Poll javascript
 */
define(function(require) {
	var $ = require('jquery');
	var elgg = require('elgg');

	/**
	 * Initialize the plugin javascript
	 */
	function init() {
		$('.poll-show-link').on('click', toggleResults);

		$('.poll-vote-button').on('click', function(e) {
			var guid = $(this).attr("rel");

			// submit the vote and display the response when it arrives
			elgg.action('action/poll/vote', {
				data: $('#poll-vote-form-' + guid).serialize(),
				success: function(response) {
					if (response.output) {
						$('#poll-container-' + guid).html(response.output);
					}
				}
			});

			e.preventDefault();
		});
	};


	/**
	 * Toggle between poll voting form and the results
	 *
	 * @param {Object} e The click event
	 */
	toggleResults = function(e) {
		var guid = $(this).data('guid');

		if ($("#poll-vote-form-" + guid).is(":visible")) {
			$(this).html(elgg.echo('poll:show_poll'));
		} else {
			$(this).html(elgg.echo('poll:show_results'));
		}

		$("#poll-vote-form-" + guid).toggle();
		$("#poll-post-body-" + guid).toggle();

		e.preventDefault();
	};
	
	init();
});
