define(['jquery'], function($) {
	
	var init_autocomplete = function(elem) {
		$(elem)
		// don't navigate away from the field on tab when selecting an item
		.bind("keydown", function(event) {
			if ((event.keyCode === $.ui.keyCode.TAB) && $(this).data("autocomplete").menu.active) {
				event.preventDefault();
			}
		})
		.autocomplete({
			source: function(request, response) {
				$.getJSON(elgg.get_site_url() + "thewire/autocomplete", {
					q: elgg.thewire_tools.extract_last(request.term, this.element[0]),
					page_owner_guid: elgg.get_page_owner_guid()
				}, response);
			},
			search: function() {
				// custom minLength
				var term = elgg.thewire_tools.extract_last(this.value, this);
				var firstChar = term.substring(0, 1);
				
				if ((term.length > 1) && (firstChar == "@" || firstChar == "#")) {
					return true;
				}
				return false;
			},
			focus: function() {
				// prevent value inserted on focus
				return false;
			},
			select: function(event, ui) {
				var pos = this.selectionStart;
				var begin_parts = elgg.thewire_tools.split(this.value.substring(0, pos));
				
				begin_parts.pop();
				var begin_part = begin_parts.join(" ").trim();
				var end_part = this.value.substring(pos).trim();
				
				var content = [];

				if (begin_part !== "") {
					content.push(begin_part);
				}

				// add the selected item
				var item_length = 0;
				if (ui.item.type == "user") {
					item_length = ui.item.username.length + 1;
					content.push("@" + ui.item.username);
				} else {
					item_length = ui.item.value.length + 1;
					content.push("#" + ui.item.value);
				}

				if (end_part !== "") {
					content.push(end_part);
				} else {
					// add placeholder to get the comma-and-space at the end
					content.push("");
				}
				
				this.value = content.join(" ");

				var endpos = begin_part.length + item_length + 1;
				
				this.selectionStart = endpos;
				this.selectionEnd = endpos;
				return false;
			},
			autoFocus: true,
			// turn off experimental live help - no i18n support and a little buggy
			messages: {
				noResults: '',
				results: function() {}
			}
		}).data("ui-autocomplete")._renderItem = function(ul, item) {
			var list_body = "";
			if(item.type == "user"){
				list_body = "<img src='" + item.icon + "' /> " + item.name;
			} else {
				list_body = item.value;
			}

			return $("<li></li>")
				.data("item.autocomplete", item)
				.append("<a>" + list_body + "</a>")
				.appendTo( ul );
		};
	};

	$('.elgg-form-thewire-add textarea[name="body"]').each(function(i) {
		init_autocomplete(this);
	});
});