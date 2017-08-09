define(function (require) {

	var $ = require('jquery');
	var elgg = require('elgg');
	require('jquery.ui.autocomplete.html');

	return {
		init: function(id) {
			var data = $('#' + id + '_autocomplete').data();
			
			$('#' + id + '_autocomplete').each(function() {
				$(this)
				.bind( 'keydown', function(event) {
					if (event.keyCode === $.ui.keyCode.TAB && $(this).data('autocomplete').menu.active) {
						// don't navigate away from the field on tab when selecting an item
						event.preventDefault();
					}
					
					if (event.keyCode === $.ui.keyCode.ENTER) {
						 event.preventDefault();
					}
				})
				.autocomplete({
					source: function(request, response) {
						$.getJSON(elgg.get_site_url() + 'groups/group_invite_autocomplete', {
							q: request.term,
							'user_guids': function() {
								var result = '';
								
								$('#' + data.destination + ' input[name="' + data.name + '[]"]').each(function() {
									if (result === '') {
										result = $(this).val();
									} else {
										result += ',' + $(this).val();
									}
								});
			
								return result;
							},
							'group_guid' : data.groupGuid,
							'relationship': data.relationship,
							'inputname': data.name
						}, response );
					},
					search: function() {
						// custom minLength
						var term = this.value;
						if (term.length < data.minChars) {
							return false;
						}
						return;
					},
					focus: function() {
						// prevent value inserted on focus
						return false;
					},
					select: function(event, ui) {
						this.value = '';
						
						if (ui.item.html) {
							$('#' + data.destination).append(ui.item.html);
							return false;
						}
						
						return false;
					},
					autoFocus: true,
					messages: {
				        noResults: '',
				        results: function() {}
				    }
				});
				
				$(this).data('ui-autocomplete')._renderItem = function(ul, item) {
					return $('<li></li>')
						.data('item.autocomplete', item)
						.append(item.html)
						.appendTo(ul);
				};
				
				$(this).data('ui-autocomplete')._resizeMenu = function() {
					var autocomplete = this.element[0];
					this.menu.element.outerWidth( $(autocomplete).outerWidth() );
				};
			});
			
			$(document).on('click', '#' + data.destination + ' .elgg-icon-delete-alt', function() {
				$(this).closest('.group_tools_group_invite_autocomplete_autocomplete_result').remove();
			});
		}
	};
});
