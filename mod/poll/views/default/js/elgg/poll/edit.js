/**
 * Poll editing javascript
 */
define(function(require) {
	var $ = require('jquery');
	var elgg = require('elgg');

	// Total number of choices
	var cnum = 0;
	// Max choice id counter
	var cid = 0;

	/**
	 * Initialize the poll editing javascript
	 */
	function init() {
		$('#add-choice').on('click', addChoice);
		$('#old-choices-area').on('click', '.delete-choice', deleteChoice);
		$('#new-choices-area').on('click', '.delete-choice', deleteChoice);

		cnum = parseInt($('#number-of-choices').val());
		cid = parseInt($('#max-choice-id').val());

		$('#poll_edit_cancel').on('click', function() {
			var forward = $(this).data('forward');
			window.location.href = elgg.get_site_url() + forward;
		});
	};

	/**
	 * Add a new empty text field to the form
	 *
	 * @param {Object} e The click event
	 */
	var addChoice = function(e) {
		// Create a new input element
		var input = '<input type="text" class="poll_input-poll-choice" name="choice_text_' + cid + '"> ';
		var deleteIcon = '<div class="elgg-icon fa elgg-icon-pollchoicedelete"></div>';
		var deleteLink = '<a href="#" class="delete-choice" title="' + elgg.echo('poll:delete_choice') + '" data-id="' + cid + '">' + deleteIcon + '</a>';

		var container = '<div id="choice-container-' + cid + '">' + input + deleteLink + '</div>';

		$('#new-choices-area').append(container);

		// Increment total number of choices and max choice id counter
		cnum++;
		$('#number-of-choices').val(cnum);
		cid++;
		$('#max-choice-id').val(cid);

		e.preventDefault();
	};

	/**
	 * Remove a poll choice
	 *
	 * @param {Object} e The click event
	 */
	function deleteChoice(e) {
		var id = $(this).data('id');

		$('#choice-container-' + id).remove();

		// Decrement total number of choices
		cnum--;
		$('#number-of-choices').val(cnum);


		e.preventDefault();
	}

	init();
});
